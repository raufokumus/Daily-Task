<?php
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


// Görevleri al
$sql = "SELECT id, task, task_date, due_date FROM tasks where username = '$username'";
$result = mysqli_query($conn, $sql);

// Görevleri diziye dönüştür
$events = array();
while ($row = mysqli_fetch_assoc($result)) {
  $event = array(
    'id' => $row['id'],
    'title' => $row['task'],
    'start' => $row['task_date'],
    'end' => $row['due_date']
    
  );
  $events[] = $event;
}

// JSON formatında çıktı üret
header('Content-Type: application/json');
echo json_encode($events);

