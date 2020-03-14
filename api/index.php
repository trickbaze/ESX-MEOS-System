<?php
require "../config.php";

//Checkk if app_identifier is valid and not blocked
if (isset($_GET['app_identifier']) AND trim($_GET['app_identifier']) != NULL) {
	$check = $con->query("SELECT * FROM app_activations WHERE app_identifier = '".$con->real_escape_string($_GET['app_identifier'])."' AND status='banned'");
	if ($check->num_rows > 0) {
		echo "ERROR";
	}
}

if (isset($_GET['action'])) {
	if ($_GET['action'] == "register_device") {
		if (trim($_POST['pin']) == null) {
			echo "No pin in POST";
			exit;
		}
		if (trim($_POST['secKey']) == null) {
			echo "No secKey in POST";
			exit;
		}
	
	
		$getUser = $con->query("SELECT id FROM users WHERE pin = '".$con->real_escape_string($_POST['pin'])."' AND status = 'active' AND app='1'");
		if ($getUser->num_rows === 1) {
			$getUser = $getUser->fetch_assoc();
		} else {
			echo "Invalid result after PIN lookup";
			exit;
		}
		
		$update = $con->query("UPDATE users SET pin = null, secKey = '".$con->real_escape_string($_POST['secKey'])."' WHERE id = '".$getUser['id']."'");
		
		if ($update) {
			echo "DONE";
			exit;
		} else {
			echo "ERROR";
			exit;
		}
	}
	
	if ($_GET['action'] == "authenticate") {
		if (trim($_GET['secKey']) == null) {
			echo "No secKey in GET";
			exit;
		}
		
		$getUser = $con->query("SELECT id,username,rang,name FROM users WHERE secKey = '".$con->real_escape_string($_GET['secKey'])."' AND app='1'");
		if ($getUser->num_rows === 1) {
			$getUser = $getUser->fetch_assoc();
			$addAppIdentifier = $con->query("INSERT INTO app_activations (id,userid,app_identifier) VALUES ('','".$getUser['id']."','".$con->real_escape_string($_GET['app_identifier'])."')");
			echo json_encode($getUser);
			exit;
		} else {
			echo "ERROR";
			exit;
		}
	}
	
	if ($_GET['action'] == "search") {
		
	}
}
?>