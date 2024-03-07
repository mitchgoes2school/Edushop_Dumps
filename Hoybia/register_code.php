<?php
session_start();
include('db/dbHelper.php');
//include('register.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

function sendEmailVerify($name, $email, $verify_token){
  $mail = new PHPMailer(true);

  $mail->isSMTP();
  $mail->SMTPAuth = true;

  $mail->Host = 'smtp.gmail.com';
  $mail->Username = 'edushop.business@gmail.com';
  $mail->Password = 'fxrw zmct unfx iqnc';

  $mail->SMTPSecure = "tls";
  $mail->Port = 587;

  $mail->setFrom('edushop.business@gmail.com', $name);
  $mail->addAddress($email);

  $mail->isHTML(true);
  $mail->Subject = 'EduShop Account - Email Verification';

  //REMINDER TO CHANGE LINK WHEN NEW DOMAIN IS USED
  $email_template = "
    <h2>You have registered with EduShop</h2>
    <h5>Verify your email address to Login with the given link below</h5>
    <br/>
    <br/>
    <a href = 'localhost/edushop/verify.email.php?token=$verify_token'>Click me!</a>
  ";

  $mail->Body = $email_template;
  $mail->send();
  //echo "Message has been sent.";
}


$conn = connect();
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
if (isset($_POST["register"])){
    $user_name = $_POST["email"];
    $user_first_name = $_POST["firstname"];
    $user_middle_name = $_POST["middlename"];
    $user_last_name = $_POST["lastname"];
    $user_address = $_POST["address"];
    $user_password = md5($_POST["password"]);
    $user_type = 'User';
    $user_verification_token = md5(rand());
    $user_createdAt = date("Y-m-d H:i:s");
    $user_status = 'Active';
  
    $user_parent_fld = ['user_name', 'user_password', 'user_type', 'user_verification_token','user_createdAt', 'user_status'];
    $user_parent_dta = [$user_name, $user_password, $user_type, $user_verification_token, $user_createdAt, $user_status];
  
    $user_child_fld = ['user_email','user_first_name', 'user_middle_name', 'user_last_name', 'user_address'];
    $user_child_dta = [$user_name, $user_first_name, $user_middle_name, $user_last_name, $user_address];
  
    if(checkEmailExists($user_name)){
      $_SESSION['status'] = "Email ID already exists";
      header("location: register.php");
    }else {
      $registerUser = addParentChildRecord('user', $user_parent_fld, $user_parent_dta, 'user_details', $user_child_fld, $user_child_dta);
      if($registerUser){
        sendEmailVerify("$user_last_name", "$user_name", "$user_verification_token");
        $_SESSION['status'] = "Registration Successfull! Please verify your email.";
        header("location: register.php");
      }else {
        $_SESSION['status'] = "Registration Failed!";
        header("location: register.php");
      }
    }
}
?>