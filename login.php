<?php
require_once "connectdb.php";
session_start();
if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $query = "SELECT * FROM user WHERE email='$email' AND password='$password'";
  $result = $conn->query($query);
  if ($result->num_rows > 0) {
    $_SESSION['username'] = $email;
    echo "Login berhasil!";
    header("location:home.php");
  } else {
    echo "Login gagal. Cek kembali username dan password.";
  }
} else {
  $error =  'Data tidak boleh kosong !!';
}

function generateCSRFToken() {
  if (empty($_SESSION['csrf_token'])) {
      $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generate a random token
  }
}
generateCSRFToken();
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">

  <title>Login Page</title>
</head>

<body>

  <div class="divide">
    <div class="row">
      <div class="kiri col-md-6 h-100">
        <img class="mw-100" src="Login Page.png" alt="Max-width 100%">
      </div>
      <div class="col-md-6">
        <div class="kanan h-100 card border-0 mx-auto">
          <div class="my-auto">
            <p class="text-login font-weight-bold">
              Login to Your Account
            </p>
            <form action="login.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        
              <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" name="email" class="form-control curved-10" placeholder="Enter your Email here" id="exampleInputEmail1" aria-describedby="emailHelp" required><br>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="password" class="form-control curved-10" placeholder="Enter your Password here" id="exampleInputPassword1" required><br>
                <input type="submit" name="submit" value="Login" class="btn btn-login font-weight-bold col-5">
              </div>
              <div class="d-flex justify-content-between mt-4">
                <a class="btn btn-regis font-weight-bold col-5" href="regist.php">
                  Register
                </a>
              </div>
            </form>
            <p class="text-center">
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  
   
  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    -->
</body>

</html>