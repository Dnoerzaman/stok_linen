<?php
require 'session_management.php'; // Sertakan file session management
class Database {
    private $host = 'localhost'; // Ganti dengan host database Anda
    private $username = 'root'; // Ganti dengan username database Anda
    private $password = ''; // Ganti dengan password database Anda
    private $database = 'laundry_rsmbec'; // Nama database Anda

    public $conn;

    public function __construct() {
        // Buat koneksi ke database
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        // Periksa koneksi
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function query($query) {
        return $this->conn->query($query);
    }

    public function prepare($query) {
        return $this->conn->prepare($query);
    }

    public function close() {
        $this->conn->close();
    }
}
