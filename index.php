<?php
session_start();

// Giriş yapmış bir kullanıcı varsa ana sayfaya yönlendirme
if (isset($_SESSION['username'])) {
  header("Location: home.php");
  exit();
}

// Kullanıcı adı ve parola doğrulaması
function authenticate($username, $password) {
  // Bu fonksiyonda, kullanıcı doğrulaması için veritabanınıza erişim yapmanız gerekecektir.
  // Kullanıcının veritabanında kayıtlı olup olmadığını kontrol etmelisiniz.
  // Parolanın doğruluğunu kontrol etmek için password_verify($password, $hashedPassword) fonksiyonunu kullanmayı unutmayın.
  // Eğer kullanıcı doğrulanıyorsa true, aksi halde false döndürmelisiniz.
  // Bu örnekte doğrulama kontrolü yapılmadığı için her giriş başarılı kabul edilecektir.
  return true;
}

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Kullanıcıyı doğrula
  if (authenticate($username, $password)) {
    $_SESSION['username'] = $username;
    header("Location: home.php");
    exit();
  } else {
    $errorMessage = "Username or password is incorrect!";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous"></head>
<body>
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
        <div class="row align-items-center">
          <div class="col-6 ">
            <div class="card cascading-right" style="
                background: hsla(0, 0%, 100%, 0.55);
                backdrop-filter: blur(30px);
                ">
              <div class="card-body p-5 shadow-5 text-center">
                <h2 class="fw-bold mb-5">Codeout</h2>
                <form  method="POST" action="index.php">

                  <!-- Email input -->
                  <div class="form-outline mb-4">
                    <label class="form-label" for="username">User Name</label>
                    <input type="text" id="username" name="username" class="form-control" />
                  </div>

                  <!-- Password input -->
                  <div class="form-outline mb-4">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" />
                  </div>

                  <!-- Submit button -->
                  <button type="submit" class="btn btn-primary btn-block mb-4">
                    Login
                  </button>

                  <!-- Register buttons -->
                </form>
                <p class="mt-3">Don't have an account? <a href="register.php">Register</a></p>
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
