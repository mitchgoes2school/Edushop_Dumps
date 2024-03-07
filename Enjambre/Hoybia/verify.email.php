<?php
include("db/dbHelper.php");
session_start();
if(isset($_GET['token'])){
    $token = $_GET['token'];
    $verify = getRecord('user', 'user_verification_token', $token);
    if(count($verify) > 0){
        $row = $verify;
        if($row['user_email_verification_status'] == 0) {
            $clicked_token = $row['user_verification_token'];
            $update_query = updateEmailVerificationStatus($clicked_token);
            if($update_query){
                $_SESSION['status'] = "Your account has verified successfully!";
                header("Location: login.php");
                exit(0);
            } else {
                $_SESSION['status'] = "Email verification failed.";
                header("Location: login.php");
                exit(0);
            }
        }else {
            $_SESSION['status'] = "Email already verified, please login.";
            header("Location: login.php");
            exit(0);
        }
    }else {
        $_SESSION['status'] = "Token does not exist";
        header("Location: login.php");
    }
}else { 
    $_SESSION['status'] = "Not Allowed";
    header("Location: login.php");
}
?>