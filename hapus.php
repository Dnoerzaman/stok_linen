<?php
require 'session_management.php'; // Sertakan file session management
 
include 'Database.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Koneksi ke database
    $db = new mysqli('localhost', 'root', '', 'laundry_rsmbec');

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Hapus data linen berdasarkan ID
    $query = "DELETE FROM stok_linen WHERE id = ?";
    $stmt = $db->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: kamar_bedah.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $db->error;
    }

    $db->close();
} else {
    echo "ID tidak ditemukan!";
}
?>
