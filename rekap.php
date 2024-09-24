<?php
require 'session_management.php'; // Sertakan file session management

require 'vendor/autoload.php'; // Jika menggunakan Composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Inisialisasi koneksi ke database
$db = new mysqli('localhost', 'root', '', 'laundry_rsmbec');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Set pagination variables
$limit = 10; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
$offset = ($page - 1) * $limit; // Hitung offset untuk SQL query

// Hitung total data dan total halaman
$result_count = $db->query("SELECT COUNT(*) AS total FROM stok_linen");
$row_count = $result_count->fetch_assoc();
$total_data = $row_count['total'];
$total_pages = ceil($total_data / $limit); // Total halaman

// Fungsi untuk mengunduh data ke Excel
if (isset($_POST['download_excel'])) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'Ruangan');
    $sheet->setCellValue('B1', 'Jenis Linen');
    $sheet->setCellValue('C1', 'Jumlah');
    $sheet->setCellValue('D1', 'Kondisi');
    $sheet->setCellValue('E1', 'Keterangan');

    // Ambil data dari database
    $query = "SELECT ruangan, jenis, jumlah, kondisi, keterangan FROM stok_linen";
    $result = $db->query($query);

    $rowIndex = 2; // Mulai dari baris kedua untuk data
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowIndex, $row['ruangan']);
        $sheet->setCellValue('B' . $rowIndex, $row['jenis']);
        $sheet->setCellValue('C' . $rowIndex, $row['jumlah']);
        $sheet->setCellValue('D' . $rowIndex, $row['kondisi']);
        $sheet->setCellValue('E' . $rowIndex, $row['keterangan']);
        $rowIndex++;
    }

    $writer = new Xlsx($spreadsheet);
    $fileName = 'rekap_linen.xlsx';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet"> <!-- Sertakan file CSS Anda -->
    <title>Rekap Linen</title>
    <style>
         body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content {
            flex: 1;
        }
        .download-btn {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .pagination {
            display: flex;
            justify-content: left;
            margin-top: 20px;
        }
        .pagination a {
            margin: 0 5px;
            padding: 8px 16px;
            border: 1px solid #ddd;
            text-decoration: none;
            color: #333;
        }
        .pagination a.active {
            background-color: whitesmoke;
            color: black;
        }
        .pagination a:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Tombol Download Excel -->
    <form method="post" class="download-btn">
        <button type="submit" name="download_excel" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Download Excel
        </button>
    </form>

    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold text-center text-blue-600 mb-10">Rekap Linen</h1>

        <div class="bg-white p-8 rounded-lg shadow-lg">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 border-b">Ruangan</th>
                        <th class="py-2 px-4 border-b">Jenis Linen</th>
                        <th class="py-2 px-4 border-b">Jumlah</th>
                        <th class="py-2 px-4 border-b">Kondisi</th>
                        <th class="py-2 px-4 border-b">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Ambil data dari database untuk ditampilkan di tabel -->
                    <?php
                    $query = "SELECT ruangan, jenis, jumlah, kondisi, keterangan FROM stok_linen ORDER BY ruangan";
                    $result = $db->query($query);
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($row['ruangan']) . "</td>";
                        echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($row['jenis']) . "</td>";
                        echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($row['jumlah']) . "</td>";
                        echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($row['kondisi']) . "</td>";
                        echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($row['keterangan']) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        <!-- Pagination Links -->
        <div class="pagination">
                <?php
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo '<a href="rekap.php?page=' . $i . '" class="' . ($i == $page ? 'active' : '') . '">' . $i . '</a>';
                }
                ?>
            </div>    
        </div>
    </div>
    <div class="mt-4 text-center">
                <a href="index.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4">Kembali</a>
    </div>
        <form action="logout.php" method="post" class="w-full text-center mt-8">
            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Logout</button>
        </form>
            
        <!-- Include footer -->
    <?php include 'footer.php'; ?>

</body>
</html>

<?php
// Tutup koneksi database
$db->close();
?>
