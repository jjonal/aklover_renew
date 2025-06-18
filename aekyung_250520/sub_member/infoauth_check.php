<?

if(!defined('_HEROBOARD_'))exit;

if(!$_SESSION['temp_code']){
	error_location("잘못된 접근입니다.","/main/index.php?board=idcheck");
	exit;
}

if(!$_POST["auth_password"]){
	error_location("잘못된 접근입니다.","/main/index.php?board=infoauth");
	exit;	
} else {
    $sql = " SELECT hero_id FROM member WHERE hero_code = '".$_SESSION['temp_code']."' ";
    $res = sql($sql);
    $rs = mysql_fetch_assoc($res);
    $hero_id = $rs["hero_id"];
    $hero_pw = $_POST['auth_password'];
    $pw_md5 = md5($hero_pw);
    $temp = $pw_md5.$hero_id;
    $pw_sha3_256 = sha3_hash('sha3-256', $temp);
    
    $sql = "select hero_id from member where hero_code = '".$_SESSION['temp_code']."' and hero_pw = '".$pw_sha3_256."' ";
	$out_sql = new_sql($sql,$error,"on");
	$count = mysql_num_rows($out_sql);
	if($count == 1) {
		$location = PATH_HOME_HTTPS."?board=infoedit";
	} else {
		message('비밀번호를 다시 확인해 주세요.');
		$location = PATH_HOME_HTTPS."?board=infoauth";
	}
}

location($location);
exit;
?>
