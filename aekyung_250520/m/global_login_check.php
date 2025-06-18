<?
$action = $_GET["action"];
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once                                                        $_SERVER['DOCUMENT_ROOT'].'/freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';

if($action == "login") {
    $login_pw = $_POST['hero_pw'];
    $login_id = $_POST['hero_id'];
    $pw_md5 = md5($login_pw);
    $temp = $pw_md5.$login_id;
    $pw_sha3_256 = sha3_hash('sha3-256', $temp);
    
    $sql = " SELECT count(*) cnt FROM global_member WHERE hero_use = 0 AND hero_id = '".$_POST["hero_id"]."' AND hero_pw = '".$pw_sha3_256."' ";
	$res = sql($sql, "on");
	$rs = mysql_fetch_assoc($res);

	if($rs["cnt"] == 1) {
		$login_sql = " SELECT hero_code, hero_country, hero_level, hero_nick, hero_admin_yn FROM global_member WHERE hero_id = '".$_POST["hero_id"]."' ";
		$login_res = sql($login_sql);
		$login_rs = mysql_fetch_assoc($login_res);

		$_SESSION["global_code"] = $login_rs["hero_code"];
		$_SESSION["global_country"] = $login_rs["hero_country"];
		$_SESSION["global_nick"] = $login_rs["hero_nick"];
		$_SESSION["global_admin_yn"] = $login_rs["hero_admin_yn"];
		//$_SESSION["global_level"] = $login_rs["hero_level"];
		$_SESSION["temp_level"] = $login_rs["hero_level"];

		$login_update_sql = " UPDATE global_member SET hero_today = now() WHERE hero_id = '".$_POST["hero_id"]."' ";
		sql($login_update_sql);

		if($_POST["chk_global_id_cookie"]) {
			setcookie("cookie_global_hero_id",$_POST["hero_id"],time()+(29*24*60*60));
		} else {
			setcookie("cookie_global_hero_id","",time()+(30*24*60*60));
		}

		message("로그인 되었습니다.");
		location("/m/main.php");
	} else {
		message("일치하는 정보가 없습니다.\\n다시 이용해 주세요.");
		location(DOMAIN."/main/index.php?board=group_04_30&view=login");
	}

}
?>