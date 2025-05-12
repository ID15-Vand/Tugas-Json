<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'catur');

class koneksi {
    public $mysqli;

    function __construct() {
        $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    function __destruct() {
        $this->mysqli->close();
    }

    function select($table) {
        $sql = "SELECT * FROM $table";
        $result = $this->mysqli->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
