<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
include("db/dbHelper.php");

$conn = connect();
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}





$page_title = 'Register';
include("includes/header.php");
?>
<div class="bg-image img-fluid" style="background-image: url('img/bg.png');">
  <div class="py-5">
    <div class="container">
    <?php
    if(isset($_SESSION['status'])){
      echo"
      <div class='alert alert-warning'>
        <h5>".$_SESSION['status']."</h5>
      </div>
      ";
      unset($_SESSION['status']);
    }
    ?>
      <div class="row justify-content-center">
        <div class="col-md-8 bg-light rounded-4 card shadow m-4">
          <div class="card-header">
            <h2 class="py-4">
              Registration Form
            </h2>
          </div>
          <div class="card-body">
            <form action="register_code.php" method="POST">
              <div class="row">
                <div class="col-md-4 mb-4">
                  <div class="form-outline">
                    <label class="form-label" for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstname" class="form-control rounded borderEduOrange" required/>
                  </div>
                </div>
                <div class="col-md-4 mb-4">
                  <div class="form-outline">
                    <label class="form-label" for="middlename">Middle Name</label>
                    <input type="text" id="middlename"  name="middlename" class="form-control rounded borderEduOrange" />
                  </div>
                </div>
                <div class="col-md-4 mb-4">
                <div class="form-outline">
                  <label class="form-label" for="lastname">Last Name</label>
                  <input type="text" id="lastname" name = "lastname" class="form-control rounded borderEduOrange" required/>
                </div>
                </div>
              </div>
              <div class="form-group mb-3">
                  <label for="">Email Address</label>
                  <input type="email" id="email" name="email" class="form-control rounded borderEduOrange" required/>
              </div>
              <div class="row">
                <div class="col-md-6 mb-4">
                  <div class="form-outline">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password"  name="password" class="form-control rounded borderEduOrange" required/>
                  </div>
                </div>
                <div class="col-md-6 mb-4">
                  <div class="form-outline">
                    <label class="form-label" for="confirmpassword">Confirm Password</label>
                    <input type="password" id="confirmpassword" name = "password" class="form-control rounded borderEduOrange" required/>
                  </div>
                </div>
                </div>
              <div class="form-group mb-3">
                  <label for="">Address</label>
                  <input name='address' type="text" class="form-control rounded borderEduOrange" required/>
              </div>
              <div class="form-group mb-3">
                <h3 class="py-2 text-center"> Optional Information </h3>
                <hr style="color: #FC4F00; border: 1px solid; ">
                <div class="form-outline">
                  <label class="form-label" for="firstName">Academic Achievement</label>
                  <select class="form-select rounded border border-warning" aria-label="Default select example">
                    <option selected>Academic Achievement</option>
                    <option value="1">Academic Excellence i.e (Cum laude, Summa Cumlaude, Magna Cum Laude etc.)</option>
                    <option value="2">Board Passer</option>
                    <option value="3">Topnotcher</option>
                  </select>
                </div>
              </div>
              <div class="form-group mb-3">
                <label for="formFile" class="form-label">Upload Proof of Achievement</label>
                <input class="form-control rounded border border-warning" type="file" id="formFile">
              </div>
              <div class="d-grid gap-2 col-6 mx-auto">
                <button class="btn" name="register" type="submit" style="background-color: #FC4F00; color: white;">Register</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include('includes/footer.php'); ?>