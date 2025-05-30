<?php

require_once "koneksi.php";

class catur{
    public $db;

    function __construct(){
        $this->db = new koneksi();
    }

    function show($table){
        return $this->db->select($table);
    }

    function insert($table, $data) {
    return $this->db->insert($table, $data);
    }


    

}