<?
define('_HEROBOARD_', TRUE);//HEROBOARD¿ÀÇÂ
include_once                                                        '../freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';


$mode = $_POST["mode"];
$result = 0;
if($mode == "infoauth") {
    $sql = " SELECT hero_id FROM member WHERE hero_code = '".$_SESSION['temp_code']."' ";
    $res = sql($sql, "on");
    $rs = mysql_fetch_assoc($res);
    $hero_id = $rs["hero_id"];
    $hero_pw = $_POST['auth_password'];
    $pw_md5 = md5($hero_pw);
    $temp = $pw_md5.$hero_id;
    $pw_sha3_256 = sha3_hash('sha3-256', $temp);
    
    $sql2 = " SELECT hero_id FROM member WHERE hero_code = '".$_SESSION['temp_code']."' and hero_pw = '".$pw_sha3_256."' ";    
	$out_sql = sql($sql2,"on");
	
	$count = mysql_num_rows($out_sql);
	if($count == 1) {
		$result = 1;
	} else {
		$result = -1;
	}
}
echo $result;
?>