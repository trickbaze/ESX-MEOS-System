
<?php
ini_set("session.hash_function","sha512");
session_start();

ini_set("max_execution_time",500);

error_reporting(0);


$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_data = "meos";

$con = new mysqli($db_host,$db_user,$db_pass,$db_data);

$dd = array(
"host" => "localhost",
"user" => "root",
"pass" => "",
"data" => "esxlegacy_22eb04"
);

$ddcon = new mysqli($dd['host'],$dd['user'],$dd['pass'],$dd['data']);

$ddg = array(
"host" => "",
"user" => "",
"pass" => "",
"data" => ""
);


$site_title = "Server | MEOS Systeem";
$browser_color = "#004682";

# Don't toch this
require "GoogleAuthenticator.php";
$ga = new PHPGangsta_GoogleAuthenticator();

if (isset($_SESSION['id'])) {
	$q = $con->query("SELECT status FROM users WHERE id = '".$_SESSION['id']."' AND status = 'active'");
	if ($q->num_rows == 0) {
		Header("Location: exit.php");
	}
}

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

//Log
$data = 
array(
"SERVER"=>$_SERVER,
"SESSION"=>$_SESSION,
"POST"=>$a,
"GET"=>$_GET
);
$con->query("INSERT INTO pagevisitlog (
uri,
ip,
_SERVER,
_SESSION,
_POST,
_GET) 
VALUES
(
'".$_SERVER['REQUEST_URI']."',
'".$_SERVER['REMOTE_ADDR']."',
'".json_encode($data['SERVER'])."',
'".json_encode($data['SESSION'])."',
'".json_encode($data['POST'])."',
'".json_encode($data['GET'])."'
)");
$curl = curl_init();

curl_setopt($curl,CURLOPT_URL,"https://meos.zoutelanderp.nl/indexveh.php");
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_HEADER, false); 
curl_setopt($curl,CURLOPT_HEADER, false); 
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

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
