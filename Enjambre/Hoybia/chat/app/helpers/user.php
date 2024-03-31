<?php  

function getUser($userId, $conn){
   $sql = "SELECT user.*,user_details.* FROM user join user_details on user.user_id = user_details.user_id
           WHERE user.user_id=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$userId]);

   if ($stmt->rowCount() === 1) {
   	 $user = $stmt->fetch();
   	 return $user;
   }else {
   	$user = [];
   	return $user;
   }
}