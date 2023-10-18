<?php
//Version 1.2.4
ini_set("session.hash_function","sha512");
session_start();

ini_set("max_execution_time",500);

error_reporting(0);


// Meos database
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_data = "meos";

$con = new mysqli($db_host,$db_user,$db_pass,$db_data);

// Fivem ESX database
$dd = array(
"host" => "localhost",
"user" => "root",
"pass" => "",
"data" => "esxlegacy_2ec75d"
);

$ddcon = new mysqli($dd['host'],$dd['user'],$dd['pass'],$dd['data']);


// Site name, title, footer and browser color
$site_name = "Los Santos";
$site_title = "Los Santos | MEOS Systeem";
$site_footer = "Copyright © Los Santos";
$browser_color = "#004682";

# Never touch this
require "GoogleAuthenticator.php";
$ga = new PHPGangsta_GoogleAuthenticator();

if (isset($_SESSION['id'])) {
	$q = $con->query("SELECT status FROM users WHERE id = '".$_SESSION['id']."' AND status = 'active'");
	if ($q->num_rows == 0) {
		Header("Location: exit.php");
	}
}

# Never touch this

if (isset($_POST)) {
	$a = $_POST;
	if (isset($a['password'])) {
		$a['password'] = NULL;
	}
	
	if (isset($a['password1'])) {
		$a['password1'] = NULL;
	}
	
	if (isset($a['password2'])) {
		$a['password2'] = NULL;
	}
}

# Never touch this
if (isset($_GET)) {
	foreach($_GET as $key => $value) {
		//$_GET[$key] = $con->real_escape_string($value);
	}
reset($_GET);
}

if (isset($_POST)) {
	foreach($_POST as $key => $value) {
		//$_POST[$key] = $con->real_escape_string($value);
	}
reset($_GET);
}
?>
