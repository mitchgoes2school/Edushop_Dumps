<?php
session_start();
include('db/dbHelper.php');
$conn = connect();

if(isset($_POST["login"])) {
    // Perform basic validation
    if (!empty(trim($_POST["username"])) && !empty(trim($_POST["password"]))) {
        $user_name = mysqli_real_escape_string($conn, $_POST["username"]);
        $user_password = mysqli_real_escape_string($conn, md5($_POST["password"]));
        // Fetch the user account from the database
        $user = getRecord('user', 'user_name', $user_name);
        $user_details = getRecord('user_details', 'user_email', $user_name);
        
            // Verify the password
            if ($user_password === $user['user_password']) {
                //echo $user['user_email_verification_status'];
                if($user['user_email_verification_status'] == 1) {
                    $_SESSION['authenticated'] = TRUE;
                    $_SESSION['auth_user'] = [
                        'user_id' => $user['user_id'],
                        'username' => $user['user_name'],
                        'user_first_name' => $user_details['user_first_name'],
                        'user_last_name' => $user_details['user_last_name'],
                    ];
                    header("Location: index.php");
                }else {
                    $_SESSION['status'] = "Please verify your email address to login!";
                    header("Location: login.php");
                    exit(0);
                }
                /*$_SESSION["logged_inuser"] = $user_name;
                header("Location: index.php");
                exit(0);*/
            } else {
                $_SESSION['status'] = "Email or password does not match on any of our records.";
                header("Location: login.php");
                exit(0);
            }
    } else {
        $_SESSION['status'] = "All fields must be field";
        header("Location: login.php");
    }

}
?>