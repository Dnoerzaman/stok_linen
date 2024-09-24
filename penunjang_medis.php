<?php
require 'session_management.php'; // Sertakan file session management

include 'Database.php';

class PenunjangMedis {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getLinen() {
        $query = "SELECT id, jenis, jumlah, kondisi, keterangan FROM stok_linen WHERE ruangan = 'Penunjang Medis'";
        $result = $this->db->query($query);
        if ($result === false) {
            die("Query failed: " . $this->db->error);
        }
        return $result;
    }
}

$db = new mysqli('localhost', 'root', '', 'laundry_rsmbec');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$penunjangMedis = new PenunjangMedis($db);
$linens = $penunjangMedis->getLinen();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet"> <!-- Sertakan file CSS Anda -->
    <title>Penunjang Medis</title>

</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold text-center text-blue-600 mb-10">Penunjang Medis</h1>
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 border-b">Jenis Linen</th>
                        <th class="py-2 px-4 border-b">Jumlah</th>
                        <th class="py-2 px-4 border-b">Kondisi</th>
                        <th class="py-2 px-4 border-b">Keterangan</th>
                        <th class="py-2 px-4 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $linens->fetch_assoc()): ?>
                        <tr>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($row['jenis'] ?? 'N/A') ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($row['jumlah'] ?? 'N/A') ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($row['kondisi'] ?? 'N/A') ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($row['keterangan'] ?? 'N/A') ?></td>
                            <td class="py-2 px-4 border-b text-center">
                                <a href="ubah.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:text-blue-800 font-bold">Ubah</a> |
                                <a href="hapus.php?id=<?= $row['id'] ?>" class="text-red-600 hover:text-red-800 font-bold">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div class="mt-4 text-center">
                <a href="tambah.php?lokasi=Penunjang Medis" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Tambah</a>
                <a href="index.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4">Kembali</a>
            </div>
        </div>
    </div>
    <form action="logout.php" method="post" class="w-full text-center">
        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ">Logout</button>
    </form>
    
    <!-- Include footer -->
    <?php include 'footer.php'; ?>
</body>
</html>

<?php
$db->close();
?>
