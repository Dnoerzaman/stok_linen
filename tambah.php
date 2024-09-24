<?php
require 'session_management.php'; // Sertakan file session management

include 'Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ruangan = $_POST['lokasi'];
    $jenis_linen = $_POST['jenis_linen'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];
    $kondisi = $_POST['kondisi'];

    // Validasi input
    if (!empty($ruangan) && !empty($jenis_linen) && !empty($jumlah) && !empty($keterangan) && !empty($kondisi)) {
        $db = new mysqli('localhost', 'root', '', 'laundry_rsmbec');

        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        // Query untuk memasukkan data ke dalam tabel stok_linen
        $query = "INSERT INTO stok_linen (ruangan, jenis, jumlah, keterangan, kondisi) VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        
        if ($stmt === false) {
            die("Prepare failed: " . $db->error);
        }

        // Mengikat parameter
        $stmt->bind_param('ssiss', $ruangan, $jenis_linen, $jumlah, $keterangan, $kondisi);

        if ($stmt->execute()) {
            // Redirect ke halaman ruangan yang sesuai setelah berhasil menyimpan data
            $stmt->close();
            $db->close();
            header("Location: " . strtolower(str_replace(' ', '_', $ruangan)) . ".php");
            exit;
        } else {
            die("Execute failed: " . $stmt->error);
        }

    
    } else {
        echo "Semua field harus diisi.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet"> <!-- Sertakan file CSS Anda -->
    <title>Tambah Linen</title>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold text-center text-blue-600 mb-10">Tambah Linen</h1>
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <form action="" method="POST">
                <input type="hidden" name="lokasi" value="<?= htmlspecialchars($_GET['lokasi']) ?>">
                <div class="mb-4">
                    <label for="jenis_linen" class="block text-gray-700 font-bold mb-2">Jenis Linen:</label>
                    <input type="text" id="jenis_linen" name="jenis_linen" class="form-input mt-1 block w-full" required>
                </div>
                <div class="mb-4">
                    <label for="jumlah" class="block text-gray-700 font-bold mb-2">Jumlah:</label>
                    <input type="number" id="jumlah" name="jumlah" class="form-input mt-1 block w-full" required>
                </div>
                <div class="mb-4">
                    <label for="keterangan" class="block text-gray-700 font-bold mb-2">Keterangan:</label>
                    <input type="text" id="keterangan" name="keterangan" class="form-input mt-1 block w-full" required>
                </div>
                <div class="mb-4">
                    <label for="kondisi" class="block text-gray-700 font-bold mb-2">Kondisi:</label>
                    <input type="text" id="kondisi" name="kondisi" class="form-input mt-1 block w-full" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                    <a href="kamar_bedah.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4">Kembali</a>
                </div>
            </form>
        </div>
    </div>
   <!-- Include footer -->
   <?php include 'footer.php'; ?>
</body>
</html>
