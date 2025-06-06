<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'catur');

class koneksi {
    public $mysqli;
    public $query;

    function __construct() {
        $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    function __destruct() {
        $this->mysqli->close();
    }

    function where($array = array()){

    }

    function select($table) {
        $sql = "SELECT * FROM $table";
        $result = $this->mysqli->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    function insert($table, $data = array()) {
    // $data = ['Nama' => 'xxx', 'Notasi' => 'yyy', 'Persentase' => 50]

    $columns = implode(", ", array_keys($data));
    $valuesArray = array_map(function($value) {
        return "'".$this->mysqli->real_escape_string($value)."'";
    }, array_values($data));
    $values = implode(", ", $valuesArray);

    $sql = "INSERT INTO $table ($columns) VALUES ($values)";

    return $this->mysqli->query($sql);
}

     
}
