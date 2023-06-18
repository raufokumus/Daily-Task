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
  // Formdan görev bilgilerini al
  $editedTaskId = $_POST["editedTaskId"];
  $editedTask = $_POST["editedTask"];
  $startDate = $_POST["start_date"];
  $endDate = $_POST["end_date"];

  // Görevi veritabanında güncelle
  $sql = "UPDATE tasks SET task = ?, start_date = ?, end_date = ? WHERE id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "sssi", $task, $startDate, $endDate, $taskID);
  $result = mysqli_stmt_execute($stmt);

  if ($result) {
    // Başarılı bir şekilde güncellendi
    // İşlemleriniz...
  } else {
    // Güncelleme başarısız oldu
    // İşlemleriniz...
  }
  
$conn->close();
header("Location: home.php");
}
