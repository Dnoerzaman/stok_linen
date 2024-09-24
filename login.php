<?php
session_start();
include 'db_connect.php';

// Cek jika user sudah tidak aktif lebih dari 30 menit
$timeout_duration = 1800; // 30 menit = 1800 detik
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset();     // Hapus data session
    session_destroy();   // Hancurkan session
    header('Location: login.php?timeout=true'); // Redirect ke halaman login dengan pesan timeout
    exit;
}

// Jika form login dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk cek username dan password di database
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Jika login berhasil, set session
        $_SESSION['loggedin'] = true;
        $_SESSION['last_activity'] = time(); // Set waktu login
        header("Location: index.php"); // Redirect ke halaman utama
    } else {
        $error = "Username atau password salah.";
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
    <title>Login</title>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-gray-300 p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-bold mb-4 text-center">Login</h2>

        <!-- Pesan timeout jika user di-logout karena inaktivitas -->
        <?php if (isset($_GET['timeout']) && $_GET['timeout'] == 'true') {
            echo "<p class='text-red-500'>Sesi Anda telah berakhir karena inaktivitas. Silakan login kembali.</p>";
        } ?>

        <!-- Pesan error jika username atau password salah -->
        <?php if (isset($error)) { echo "<p class='text-red-500'>$error</p>"; } ?>

        <!-- Form login -->
        <form method="POST" action="login.php" class="space-y-4">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Login</button>
        </form>
    </div>
    <!-- Include footer -->
   <?php include 'footer.php'; ?>
</body>
</html>
