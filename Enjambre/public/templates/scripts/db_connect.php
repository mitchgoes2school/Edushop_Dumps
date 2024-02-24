<?php
    $db = mysqli_connect('localhost','root','','edushop');

    if($db->connect_error){
        die("Connection Failed :". $db->connect_error);
    }
    function getOneRecord($table, $fields,$condition,$data){
        global $db;
		$query = "SELECT $fields FROM $table WHERE $condition = '$data'";
		$response = $db->query($query);
        $result = mysqli_fetch_assoc($response);
        return $result;
	}
    function getJoinRecord($table, $fields){
        global $db;
		$query = "SELECT $fields FROM $table";
        $result = array();
		$response = $db->query($query);

        while($row = mysqli_fetch_assoc($response)){
			array_push($result, $row);
		}
        return $result;
	}
    function getAll($table){
        global $db;
		$query = "SELECT * FROM $table";
		$response = array();
		$sql = $db->query($query);
		
		while($row = mysqli_fetch_assoc($sql)){
			array_push($response, $row);
		}
		
		return $response;
	}
    function addRecord($table, $field, $data){
        global $db;
		$fld = implode(",",$field);
		$dta = implode("','", $data);
		$strQuery = "INSERT INTO $table ($fld) VALUES('$dta')";
		$query = mysqli_query($db, $strQuery);
		
		$result = ($query)? true: false ;
		return $result;
	}
?>