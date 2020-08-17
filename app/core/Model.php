<?php

namespace app\core;

abstract class Model
{
    public $db;
    public function __construct()
    {
        $this->db = new \app\lib\Db;
    }
}
