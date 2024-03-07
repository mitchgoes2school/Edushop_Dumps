<?php
session_start();
include("db/dbHelper.php");

/*if(isset($_SESSION['authenticated'])){
  if($_SESSION['authenticated']==true){
      header("location: index.php");
  }
}*/

// Establish database connection
$conn = connect();
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the user is already logged in
// if (isset($_SESSION["logged_inuser"])) {
//     header("#");
//     exit;
// }
$page_title = 'Login';
include("includes/header.php");
?>
<div class="bg-image img-fluid" style="background-image: url('img/bg.png');">
  <div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5">
      <div class="col-lg-7 text-center text-lg-start">
        <h1 class="display-4 fw-bold lh-1 mb-3">Empower your journey</h1>
        <p class="col-lg-10 fs-4">Shop smartly with EduShop. Where knowledge meets value!</p>
      </div>
      <div class="col-md-10 mx-auto col-lg-5">
        <?php
          //print_r($_SESSION['status']);
          if(isset($_SESSION['status'])){
            echo"
            <div class='alert alert-warning'>
              <h5>".$_SESSION['status']."</h5>
            </div>
            ";
            unset($_SESSION['status']);
          }
        ?>
        <form action="login_code.php" method="POST" class="p-4 p-md-5 border rounded-2 bg-light">
          <div class="form-floating mb-3">
            <input type="email" class="form-control" name="username" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
            <label fosr="floatingPassword">Password</label>
          </div>
          <div class="checkbox mb-3">
            <label>
              <input type="checkbox" value="remember-me"> Remember me
            </label>
          </div>
          <button class="w-100 btn btn-lg btn-primary" name="login" type="submit" style = "background: #FC4F00">Login</button>
          <hr class="my-4">
          <small class="text-muted">Don't have have an account? <a href = "register.php">Click here to register.</a></small>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include("includes/footer.php");?>
