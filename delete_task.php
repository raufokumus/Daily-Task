<?php
// Veritabanı bağlantısı ve giriş kontrolü
// ...
session_start();

// Oturum kontrolü
if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit();
}

// Veritabanı bağlantısı
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "site";

$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Oturum kullanıcısı
$username = $_SESSION['username'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Formdan silinecek görevin ID'sini al
  $deletedTaskId = $_POST["deletedTaskId"];

  // Görevi veritabanından sil
  $sql = "DELETE FROM tasks WHERE id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $deletedTaskId);
  $result = mysqli_stmt_execute($stmt);

  if ($result) {
    // Görev başarıyla silindi
    // Ana sayfaya yönlendir
    header("Location: home.php");
    exit();
  } else {
    // Görev silinirken hata oluştu
    // İşlemleriniz...
  }

  mysqli_stmt_close($stmt);
}
