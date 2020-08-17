<?php


namespace app\lib;

class Db
{
    protected $db;
    public function __construct()
    {
        $config = require "app/config/db.php";
        $this->db = new \PDO("{$config['sql']}:host={$config['host']};dbname={$config['dbname']}", $config['username'], $config['password'], [
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        ]);
    }

    public function query($sql_query, $params=[])
    {
        $query = $this->db->prepare($sql_query);
        $query->execute($params);
        return $query; 
    }

    public function row($sql_query, $params = [], $response_type = \PDO::FETCH_ASSOC)
    {
        $result = $this->query($sql_query, $params);
        return $result->fetchAll($response_type);
    }

    public function column($sql_query, $params = [], $response_type = \PDO::FETCH_ASSOC)
    {
        $result = $this->query($sql_query, $params);
        return $result->fetchColumn($response_type);
    }
}
