<?php

session_start();

# check if the user is logged in
if (isset($_SESSION['auth_user'])) {
    # check if the key is submitted
    if(isset($_POST['key'])){
       # database connection file
	   include '../db.conn.php';

	   # creating simple search algorithm :) 
	   $key = "%{$_POST['key']}%";
     
	   $sql = "SELECT user.*,user_details.* FROM user join user_details on user.user_id = user_details.user_id
	           WHERE user_details.user_first_name
	           LIKE ? OR user_details.user_first_name LIKE ?";
       $stmt = $conn->prepare($sql);
       $stmt->execute([$key, $key]);

       if($stmt->rowCount() > 0){ 
         $users = $stmt->fetchAll();

         foreach ($users as $user) {
         	if ($user['user_id'] == $_SESSION['auth_user']['user_id']) continue;
       ?>
       <li class="list-group-item">
		<a href="chat.php?user=<?=$user['user_id']?>"
		   class="d-flex
		          justify-content-between
		          align-items-center p-2">
			<div class="d-flex
			            align-items-center">

			    <img src="uploads/<?=$user['user_image']?>"
			         class="w-10 rounded-circle">

			    <h3 class="fs-xs m-2">
			    	<?=$user['user_first_name']?>
			    </h3>            	
			</div>
		 </a>
	   </li>
       <?php } }else { ?>
         <div class="alert alert-info 
    				 text-center">
		   <i class="fa fa-user-times d-block fs-big"></i>
           The user "<?=htmlspecialchars($_POST['key'])?>"
           is  not found.
		</div>
    <?php }
    }

}else {
	header("Location: ../../index.php");
	exit;
}