<?php
require 'session_management.php'; // Sertakan file session management

include 'Database.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $db = new mysqli('localhost', 'root', '', 'laundry_rsmbec');

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Ambil data linen berdasarkan ID
    $query = "SELECT * FROM stok_linen WHERE id = ?";
    $stmt = $db->prepare($query);
    if ($stmt === false) {
        die("Prepare failed: " . $db->error);
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $linen = $result->fetch_assoc();

    // Pastikan data ditemukan
    if (!$linen) {
        die("Data tidak ditemukan!");
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $jenis_linen = $_POST['jenis_linen'];
        $jumlah = $_POST['jumlah'];
        $keterangan = $_POST['keterangan'];
        $kondisi = $_POST['kondisi'];

        // Update data linen
        $query = "UPDATE stok_linen SET jenis = ?, jumlah = ?, keterangan = ?, kondisi = ? WHERE id = ?";
        $stmt = $db->prepare($query);
        if ($stmt === false) {
            die("Prepare failed: " . $db->error);
        }
        $stmt->bind_param("sissi", $jenis_linen, $jumlah, $keterangan, $kondisi, $id);

        if ($stmt->execute()) {
            header("Location: kamar_bedah.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
    $db->close();
} else {
    echo "ID tidak ditemukan!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet"> <!-- Sertakan file CSS Anda -->
    <title>Ubah Linen</title>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold text-center text-blue-600 mb-10">Ubah Linen</h1>
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <form method="post" action="">
                <div class="mb-4">
                    <label for="jenis_linen" class="block text-gray-700">Jenis Linen</label>
                    <input type="text" name="jenis_linen" id="jenis_linen" value="<?= isset($linen['jenis']) ? htmlspecialchars($linen['jenis']) : '' ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="jumlah" class="block text-gray-700">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah" value="<?= isset($linen['jumlah']) ? htmlspecialchars($linen['jumlah']) : '' ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="keterangan" class="block text-gray-700">Keterangan</label>
                    <input type="text" name="keterangan" id="keterangan" value="<?= isset($linen['keterangan']) ? htmlspecialchars($linen['keterangan']) : '' ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="kondisi" class="block text-gray-700">Kondisi</label>
                    <input type="text" name="kondisi" id="kondisi" value="<?= isset($linen['kondisi']) ? htmlspecialchars($linen['kondisi']) : '' ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                    <a href="kamar_bedah.php" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-4">Batal</a>
                </div>
            </form>
        </div>
    </div>
   <!-- Include footer -->
   <?php include 'footer.php'; ?>
</body>
</html>
