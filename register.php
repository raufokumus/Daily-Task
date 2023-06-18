<?php
// Veritabanı bağlantısı
$dbHost = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "site";

$db = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
if ($db->connect_error) {
  die("Database connection failed: " . $db->connect_error);
}

// Kullanıcı kaydı
function registerUser($username, $password, $first_name, $last_name, $email) {
  global $db;

  // Parolayı hashleme
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  // Veritabanına kullanıcıyı kaydetme
  $query = "INSERT INTO users (username, password, first_name, last_name, email) VALUES (?, ?, ?, ?, ?)";
  $statement = $db->prepare($query);
  $statement->bind_param("sssss", $username, $hashedPassword, $first_name, $last_name, $email);
  $statement->execute();
  $statement->close();

  return true;
}

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];

  // Kullanıcıyı kaydet
  if (registerUser($username, $password, $first_name, $last_name, $email)) {
    header("Location: index.php");
    exit();
  } else {
    $errorMessage = "An error occurred while registering the user!";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous"></head>
  <link rel="shortcut icon" href="main.svg">
  <body>
    
  <div class="container">

  <section class="text-center">
      <style>
        .cascading-right {
          margin-right: -50px;
        }
      
        @media (max-width: 991.98px) {
          .cascading-right {
            margin-right: 0;
          }
        }
      </style>

      <!-- Jumbotron -->
      <div class="container py-3">
      <?php if (isset($errorMessage)): ?>
      <p class="text-danger"><?php echo $errorMessage; ?></p>
    <?php endif; ?>
        <div class="row align-items-center">
          <div class="col-6 ">
            <div class="card cascading-right" style="
                background: hsla(0, 0%, 100%, 0.55);
                backdrop-filter: blur(30px);
                ">
              <div class="card-body p-5 shadow-5 text-center">
                <h2 class="fw-bold mb-5">Sign Up</h2>
                <form  method="POST" action="register.php">

                  <div class="mb-3 d-flex">
                    <div class="col-6 d-flex align-items-center">
                      <div class="input-group ">
                        <span class="input-group-text" id="basic-addon1">User Name</span>
                        <input type="text" id="username" name="username" class="form-control" required>
                      </div>
                    </div>
                    <div class="col-6 d-flex align-items-center">
                      <div class="input-group ">
                        <input type="email" id="email" name="email" class="form-control" required>
                        <span class="input-group-text" id="basic-addon2">Email</span>
                      </div>
                    </div>
                  </div>

                  <div class="mb-3 d-flex">
                    <div class="input-group">
                      <span class="input-group-text">First and last name</span>
                      <input type="text" id="first_name" name="first_name" class="form-control" required>
                      <input type="text" id="last_name" name="last_name" class="form-control" required>
                    </div>
                  </div>

                  <div class="mb-3 d-flex">
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1">Password</span>
                      <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                  </div>

                  <!-- Submit button -->
                  <button type="submit" class="btn btn-primary btn-block mb-4">
                    Sign Up
                  </button>

                  <!-- Register buttons -->
                </form>
                <p class="mt-3">Do you have an account? <a href="index.php">Login</a></p>
              </div>
            </div>
          </div>

          <div class="col-6">
            <img src="https://mdbootstrap.com/img/new/ecommerce/vertical/004.jpg" class="w-100 rounded-4 shadow-4"
              alt="" />
          </div>
        </div>
      </div>
      <!-- Jumbotron -->
    </section>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script></body>
</html>
