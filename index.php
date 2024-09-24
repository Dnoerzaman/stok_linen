<?php
require 'session_management.php'; // Sertakan file session management
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet"> <!-- Sertakan file CSS Anda -->
    <title>Stok Linen</title>
    <style>
        body {
            background-image: url(''); /* untuk gambar bg */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body class="bg-gray-100">
<nav class="bg-blue-600 p-4">
        <div class="container mx-auto flex items-center justify-between">
            <!-- Teks -->
            <h1 class="text-white text-2xl font-bold">STOK LINEN</h1>
            
            <!-- Logo -->
            <img src="img/logoBEC.png" alt="Logo BEC" class="w-34 h-10"> <!-- Sesuaikan ukuran sesuai kebutuhan -->
        </div>
    </nav>

    <div class="container mx-auto py-8">
    <div class="flex flex-col md:flex-row lg:flex-row gap-2">
        <a href="kamar_bedah.php" class="bg-white bg-opacity-50 p-6 rounded-lg shadow-lg hover:bg-blue-300 transition duration-200">
            <h2 class="text-xl font-bold mb-2">Kamar Bedah dan CSSU</h2>
            <p class="text-gray-700">Kelola stok linen di Kamar Bedah dan CSSU.</p>
        </a>

        <a href="rawat_inap_jalan.php" class="bg-white bg-opacity-50 p-6 rounded-lg shadow-lg hover:bg-blue-300 transition duration-200">
            <h2 class="text-xl font-bold mb-2">Rawat Inap dan Rawat Jalan</h2>
            <p class="text-gray-700">Kelola stok linen di Rawat Inap dan Rawat Jalan.</p>
        </a>

        <a href="igd.php" class="bg-white bg-opacity-50 p-6 rounded-lg shadow-lg hover:bg-blue-300 transition duration-200">
            <h2 class="text-xl font-bold mb-2">IGD</h2>
            <p class="text-gray-700">Kelola stok linen di IGD.</p>
        </a>

        <a href="penunjang_medis.php" class="bg-white bg-opacity-50 p-6 rounded-lg shadow-lg hover:bg-blue-300 transition duration-200">
            <h2 class="text-xl font-bold mb-2">Penunjang Medis</h2>
            <p class="text-gray-700">Kelola stok linen di Penunjang Medis.</p>
        </a>

        <a href="fasilitas_umum.php" class="bg-white bg-opacity-50 p-6 rounded-lg shadow-lg hover:bg-blue-300 transition duration-200">
            <h2 class="text-xl font-bold mb-2">Lainnya</h2>
            <p class="text-gray-700">Kelola stok linen di Fasilitas Umum dan lainnya.</p>
        </a>

        <a href="rekap.php" class="bg-white bg-opacity-50 p-6 rounded-lg shadow-lg hover:bg-blue-300 transition duration-200">
            <h2 class="text-xl font-bold mb-2">Rekap</h2>
            <p class="text-gray-700">Lihat rekapitulasi stok linen.</p>
        </a>
    </div>
</div>

    <!-- Tombol Logout -->
    <form action="logout.php" method="post" class="w-full text-center mt-8">
        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Logout</button>
    </form>

     <!-- Include footer -->
     <?php include 'footer.php'; ?>

</body>
</html>
