<?php

class GetJobs
{
    //@var instance of database class itself
    private $db = null;

    function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getJobs($id)
    {
        $all_jobs = file_get_contents(str_replace('{{id}}', $id, API_URL));
        $all_jobs = json_decode($all_jobs, true);

        foreach ($all_jobs['kids'] as $field => $job_id) {
            $single_job = file_get_contents(str_replace('{{id}}', $job_id, API_URL));
            $single_job = json_decode($single_job, true);

            $parent_id = $single_job['parent'];
            $post_id = $job_id;
            $time_posted = $single_job['time'];
            $job_desc = $single_job['text'];

            $programming_language = $this->getProgrammingLanguages(strtolower($job_desc));
            $frameworks = $this->getFrameworks(strtolower($job_desc));
            $package_managers = $this->getPackageManagers(strtolower($job_desc));
            $databases = $this->getDatabases(strtolower($job_desc));
            $job_types = $this->getJobTypes(strtolower($job_desc));

            //Insert job into database
            $this->addJob($post_id, $parent_id, $job_types, $job_desc, $programming_language, $frameworks,
                $package_managers, $databases, $time_posted);
        }

        //Get total counts of each category (programming language, job type, framework, database) for adding to db table
        $this->getCategoryCounts($id);
        return '<h2>Jobs Successfully Added!</h2>';
    }

    public function getDatabases($text)
    {
        $databases = explode(',', DATABASES);
        $found_databases = '';
        foreach ($databases as $find_database) {
            $pos = strpos($text, $find_database);

            //Hacky code to account for different ways people input databases. Re-factor this eventually
            if ($find_database == 'ms sql' || $find_database  == 'sql server') {
                $find_database = 'mysql';
            }
            if ($find_database == 'elastic search') {
                $find_database = 'elasticsearch';
            }

            if ($pos > 0) {
                $found_databases .= $find_database.',';
            }
        }
        //Remove dupes
        $found_databases = implode(',', array_keys(array_flip(explode(',', $found_databases))));
        return rtrim($found_databases, ',');
    }

    public function getProgrammingLanguages($text)
    {
        $program_languages = explode(',', PROGRAMMING_LANGUAGES);
        $found_languages = '';
        foreach ($program_languages as $find_language) {
            if ($find_language == 'java') {
	         //Using word boundaries for "java" so it doesn't get picked up within javascript
		 if (preg_match("/\b".preg_quote($find_language)."\b/i", $text)) {
		      $pos = 1;
		 } else {
		     $pos = 0;
		 }	
            } else {
                $pos = strpos($text, $find_language);
		    }		
            if ($pos > 0) {
                $found_languages .= $find_language.',';
            }
        }
        //Remove dupes
        $found_languages = implode(',', array_keys(array_flip(explode(',', $found_languages))));
        return rtrim($found_languages, ',');
    }

    public function getFrameworks($text)
    {
        $frameworks = explode(',', FRAMEWORKS);
        $found_frameworks = '';
        foreach ($frameworks as $find_framework) {
            $pos = strpos($text, $find_framework);
            if ($pos > 0) {
                $found_frameworks .= $find_framework.',';
            }
        }
        return rtrim($found_frameworks, ',');
    }

    public function getJobTypes($text)
    {
        $job_types = explode(',', JOB_TYPES);
        $found_types = '';
        foreach ($job_types as $find_type) {
            $pos = strpos($text, $find_type);

            //Hacky code to account for different ways people input job types. Re-factor this eventually
            if ($find_type == 'onsite' || $find_type  == 'on site') {
                $find_type = 'on-site';
            }
            if ($find_type == 'full time') {
                $find_type = 'full-time';
            }
            if ($find_type == 'part time') {
                $find_type = 'part-time';
            }

            if ($pos > 0) {
                $found_types .= $find_type.',';
            }
        }
        //Remove dupes
        $found_types = implode(',', array_keys(array_flip(explode(',', $found_types))));
        return rtrim($found_types, ',');
    }

    public function getPackageManagers($text)
    {
        $package_managers = explode(',', PACKAGE_MANAGERS);
        $found_packages = '';
        foreach ($package_managers as $find_package) {
            $pos = strpos($text, $find_package);
            if ($pos > 0) {
                $found_packages .= $find_package.',';
            }
        }
        return rtrim($found_packages, ',');
    }

    public function getCategoryCounts($id)
    {
        //First delete current counts for id
	$this->db->delete("cat_count","parent_id = :pid", array("pid" => $id));
	echo 'Deleted counts';
		
	//Get and add program language counts
        $program_languages = explode(',', PROGRAMMING_LANGUAGES);
        $type = 'language';
        foreach ($program_languages as $cat) {
	    if ($cat == 'java') {
	         $query = "SELECT COUNT(post_id) AS cat_count FROM `hn_posts` WHERE `parent_id` = :pid AND `languages` LIKE :cat 
			    AND `languages` NOT LIKE '%javascript%'";
            } else {	
                  $query = "SELECT COUNT(post_id) AS cat_count FROM `hn_posts` WHERE `parent_id` = :pid AND `languages` LIKE :cat";
	    }	
	    $result = $this->db->select($query, array('cat' => "%$cat%", 'pid' => $id));
            if (count($result) > 0) {
                 $cat_count = $result[0]['cat_count'];
                 if ($cat_count > 0) {
                      $this->addCategoryCount($type,$cat,$id,$cat_count);
		      echo '<br />Added '.$type.' '.$cat.' with count: '.$cat_count;
                 }
            }
        }

        //Get and add framework counts
        $frameworks = explode(',', FRAMEWORKS);
        $type = 'framework';
        foreach ($frameworks as $cat) {
            $query = "SELECT COUNT(post_id) AS cat_count FROM `hn_posts` WHERE `parent_id` = :pid AND `frameworks` LIKE :cat";
            $result = $this->db->select($query, array('cat' => "%$cat%", 'pid' => $id));
            if (count($result) > 0) {
                $cat_count = $result[0]['cat_count'];
                if ($cat_count > 0) {
                    $this->addCategoryCount($type,$cat,$id,$cat_count);
					echo '<br />Added '.$type.' '.$cat.' with count: '.$cat_count;
                }
            }
        }

        //Get and add database counts
        $databases = explode(',', DATABASES);
        $type = 'database';
        foreach ($databases as $cat) {
            $query = "SELECT COUNT(post_id) AS cat_count FROM `hn_posts` WHERE `parent_id` = :pid AND `databases` LIKE :cat";
            $result = $this->db->select($query, array('cat' => "%$cat%", 'pid' => $id));
            if (count($result) > 0) {
                $cat_count = $result[0]['cat_count'];
                if ($cat_count > 0) {
                    $this->addCategoryCount($type,$cat,$id,$cat_count);
					echo '<br />Added '.$type.' '.$cat.' with count: '.$cat_count;
                }
            }
        }

        //Get and add job type counts
        $job_types = explode(',', JOB_TYPES);
        $type = 'job_type';
        foreach ($job_types as $cat) {
            $query = "SELECT COUNT(post_id) AS cat_count FROM `hn_posts` WHERE `parent_id` = :pid AND `job_type` LIKE :cat";
            $result = $this->db->select($query, array('cat' => "%$cat%", 'pid' => $id));
            if (count($result) > 0) {
                $cat_count = $result[0]['cat_count'];
                if ($cat_count > 0) {
                    $this->addCategoryCount($type,$cat,$id,$cat_count);
					echo '<br />Added '.$type.' '.$cat.' with count: '.$cat_count;
                }
            }
        }
    }

    public function addCategoryCount($type,$cat,$id,$cat_count)
    {
        $this->db->insert('category_counts', array(
            "type" => $type,
            "category" => $cat,
            "parent_id" => $id,
            "total_count" => $cat_count
        ));
    }

    public function addJob(
        $post_id,
        $parent_id,
        $job_types,
        $job_desc,
        $programming_language,
        $frameworks,
        $package_managers,
        $databases,
        $time_posted
    ) {
        $this->db->insert('hn_posts', array(
            "post_id" => $post_id,
            "parent_id" => $parent_id,
            "job_type" => $job_types,
            "job_desc" => $job_desc,
            "languages" => $programming_language,
            "frameworks" => $frameworks,
            "package_managers" => $package_managers,
            "databases" => $databases,
            "time_posted" => $time_posted
        ));
    }
}
