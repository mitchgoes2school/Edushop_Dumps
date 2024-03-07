<?php
session_start();
require("db/dbHelper.php");
$conn = connect();

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);
    $userInfo = $_SESSION['auth_user'];
    $userId = $userInfo['user_id'];
    $updateType = $data['updateType'];
    switch($updateType){
    case 'NameChange':
        $firstname = $data['fname'];
        $middlename = $data['mname'];
        $lastname = $data['lname'];
    
        $response = updateRecords('user_details', ['user_id', 'user_first_name', 'user_middle_name', 'user_last_name'], [$userId, $firstname, $middlename, $lastname]);
    
        if ($response) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        break;
    case 'changeAddress':
       $address = $data['newAddress'];
       
       $response = updateRecords('user_details',['user_id','user_address'],[$userId,$address]);
       if ($response) {
        echo json_encode(['success' => true]);
        } 
        else {
        echo json_encode(['success' => false]);
        }
        break;
    case 'changeNumber':
            $number = $data['newNumber'];
            
            $response = updateRecords('user_details',['user_id','user_contact_number'],[$userId,$number]);
            if ($response) {
             echo json_encode(['success' => true]);
             } 
             else {
             echo json_encode(['success' => false]);
             }
             break;
    }
}
?>
