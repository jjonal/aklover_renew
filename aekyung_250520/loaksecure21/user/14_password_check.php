<?
session_start();
$password = $_POST["password"];

if($password == "##19ak") {
	$_SESSION["passwordSuccess"] = "Y";
	$result = true;
} else {
	$result = false;
}
?>
{"result":"<?=$result?>"}