<?php
	$hostname = "localhost";
	$username = "root";
	$password = "";
	$database = "EduShop";
	//database connection
	function connect(){
		global $hostname, $username, $password, $database;
		return mysqli_connect($hostname, $username, $password, $database);
	}
	//gets all the books
	function getAll($table){
		$strQuery = "SELECT * FROM $table";
		$result = array();
		$conn = connect();
		$query = mysqli_query($conn, $strQuery);
		
		while($row = mysqli_fetch_assoc($query)){
			array_push($result, $row);
		}
		
		return $result;
	}
	//Searches for a specific record
	function getRecord($table, $fields, $data){
		$strQuery = "SELECT * FROM $table WHERE $fields = '$data'";
		$conn = connect();
		$query = mysqli_query($conn, $strQuery);
		$result = mysqli_fetch_assoc($query);
		mysqli_close($conn);
		return $result;
	}

	function getMultipleRecord($table, $fields, $data){
		//$fld = implode(",",$fields);
		//$dta = implode("','", $data);

		$flds = array();
		
		for($i = 0;$i<count($fields);$i++){
			array_push($flds, "'{$fields[$i]} = {$data[$i]}'");
		}
		$fld = implode(",", $flds);
		$strQuery = "SELECT * FROM $table WHERE $fld";
		$conn = connect();
		$query = mysqli_query($conn, $strQuery);
		$result = mysqli_fetch_assoc($query);
		mysqli_close($conn);
		return $result;
	}

	function getRecordWithColumn($table, $col, $fields, $data){
		$strQuery = "SELECT $col FROM $table WHERE $fields = '$data'";
		//$strQuery = "SELECT bid.*, (SELECT CONCAT(user_first_name,' ', user_Last_name) FROM user_details WHERE user_ID = bid.User_ID) AS name FROM bid WHERE Auctioned_Item_ID = 10001;";
		$conn = connect();
		
		$query = mysqli_query($conn, $strQuery);

		if (mysqli_num_rows($query) > 0) {
			// Initialize an empty array to store the fetched data
			$data = array();
		
			// Fetch each row of data and add it to the array
			while ($row = mysqli_fetch_assoc($query)) {
				$data[] = $row;
			}
		}


		//$result = mysqli_fetch_assoc($query);
		mysqli_close($conn);
		return $data;
	}


	function addRecord($table, $field, $data){
		$fld = implode(",",$field);
		$dta = implode("','", $data);
		$strQuery = "INSERT INTO $table ($fld) VALUES('$dta')";
		$conn = connect();
		$query = mysqli_query($conn, $strQuery);
		
		$result = ($query)? true: false ;
		return $result;
	}

	function addParentChildRecord($parent_table, $parent_field, $parent_data, $child_table, $child_field, $child_data){
		$conn = connect();
		
		//Inserting parent data
		$pfld = implode(",",$parent_field);
		$pdta = implode("','", $parent_data);
		$str_query_parent = "INSERT INTO $parent_table ($pfld) VALUES('$pdta')";
		$parent_query = mysqli_query($conn, $str_query_parent);

		$user_id = mysqli_insert_id($conn);

		//Insert child data
		$cfld = implode(",",$child_field);
		$cdta = implode("','", $child_data);
		$str_query_child = "INSERT INTO $child_table (user_id, $cfld) VALUES('$user_id','$cdta')";
		$child_query = mysqli_query($conn, $str_query_child);

		$result = ($parent_query && $child_query)? true: false;
		return $result;
	}
	function getLatest($table, $tableID) {
		$strQuery = "SELECT * FROM $table ORDER BY $tableID DESC LIMIT 1";
		$conn = connect();
		$query = mysqli_query($conn, $strQuery);
		$result = mysqli_fetch_assoc($query);
		mysqli_close($conn);
		return $result;
	}	
	
	function updateRecords($table, $field, $data){
		$flds = array();
		
		for($i = 0;$i<count($field);$i++){
			array_push($flds, "$field[$i] = '$data[$i]'");
		}
		
		$fld = implode(",", $flds);
		$strQuery = "UPDATE $table SET $fld WHERE $field[0] = '$data[0]'";
		$conn = connect();
		$query = mysqli_query($conn, $strQuery);
		
		$result = ($query)? true: false ;
		return $result;
	}

	function updateEmailVerificationStatus($data){
		$strQuery = "UPDATE user SET user_email_verification_status = 1 WHERE user_verification_token = '$data'";
		$conn = connect();
		$query = mysqli_query($conn, $strQuery);

		$result = ($query)? true: false ;
		return $result;
	}
	
	function deleteRecord($table,$field ,$data){
		$strQuery = "DELETE FROM $table WHERE $field = '$data'";
		$conn = connect();
		$query = mysqli_query($conn, $strQuery);
		
		$result = ($query)? true: false ;
		return $result;
	}

	function checkEmailExists($data){
		$check_email_query = "SELECT * FROM user_details WHERE user_email = '$data'";
		$conn = connect();
		$check_email_query_run = mysqli_query($conn, $check_email_query);

		$result = (mysqli_num_rows($check_email_query_run)> 0)? true: false;
		return $result;
	}
	function getJoinRecord($table, $fields){
		$query = "SELECT $fields FROM $table";
        $result = array();
		$response = connect()->query($query);

        while($row = mysqli_fetch_assoc($response)){
			array_push($result, $row);
		}
        return $result;
	}
	function getMaxRecordValue($maxfield,$table,$fields,$data){
		$strQuery = "SELECT MAX($maxfield) as $maxfield  FROM $table WHERE $fields = '$data'";
		$conn = connect();
		$query = mysqli_query($conn, $strQuery);
		$result = mysqli_fetch_assoc($query);
		mysqli_close($conn);
		return $result;
	}
	
?>