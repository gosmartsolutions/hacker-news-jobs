<?php

class GetData
{
    //@var instance of database class itself
    private $db = null;

    function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function categoryCounts($type,$parent_id)
    {
        $query = "SELECT category, total_count FROM category_counts WHERE type = :type AND parent_id = :pid AND total_count > 14 ".
                 "ORDER BY total_count DESC LIMIT 10";
        $result = $this->db->select($query, array('type' => $type,'pid' => $parent_id));
        return $result;
    }

    public function getAllJobs($parent_id)
    {
        $query = "SELECT * FROM hn_posts WHERE parent_id = :pid LIMIT 700";
	$result = $this->db->select($query, array('pid' => $parent_id));
        return $result;
    }
}
