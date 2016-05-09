<?php

class GetData
{
    //@var instance of database class itself
    private $db = null;

    function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function categoryCounts($type)
    {
        $query = "SELECT category, total_count FROM category_counts WHERE type = :type AND total_count > 14 ".
                 "ORDER BY total_count DESC LIMIT 10";
        $result = $this->db->select($query, array('type' => $type));
        return $result;
    }

    public function getAllJobs()
    {
        $query = "SELECT * FROM hn_posts LIMIT 700";
        $result = $this->db->select($query);
        return $result;
    }
}
