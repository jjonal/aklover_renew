<?
define('_HEROBOARD_', TRUE);//HEROBOARD¿ÀÇÂ
include_once '../freebest/head.php';
include_once                                                        $_SERVER['DOCUMENT_ROOT'].'/freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';

if($_POST["mode"] == "without") {
	$result = 0;
	
	$login_pw = $_POST['hero_pw'];
	$login_id = $_SESSION["temp_id"];
	$pw_md5 = md5($login_pw);
	$temp = $pw_md5.$login_id;
	$pw_sha3_256 = sha3_hash('sha3-256', $temp);
	
	$sql = " select * from member where hero_id = '".$_SESSION["temp_id"]."' and hero_pw = '".$pw_sha3_256."' ";
	sql($sql, 'on');
	$count = @mysql_num_rows($out_sql);
	if(!strcmp($count, '0')){
		$result = 2;
		echo $result;
	}else{
		$sql_one = 'hero_use=\'1\'';
		$sql = 'UPDATE admin SET '.$sql_one.' WHERE hero_id = \''.$_POST['hero_id'].'\';';
		sql($sql, 'on');
	
		$sql_one = "hero_table='', hero_info_type=null, hero_info_di=null, hero_info_ci=null, hero_facebook='' ";
		$sql_one .= ", hero_kakaoTalk='', hero_naver='', hero_google='' ";
	    $sql_one .= ", hero_pw=null, hero_name=null, hero_jumin=null, hero_sex=null, hero_mail=null, hero_hp=null, hero_address_01=null, hero_address_02=null, ";
	    $sql_one .= " hero_address_03=null, hero_job_01=null, hero_job_02=null, hero_job_03=null, hero_blog_00=null, hero_blog_01=null, hero_blog_02=null, hero_blog_03=null, ";
	    $sql_one .= " hero_blog_03_channel_name = null, hero_blog_04=null, hero_blog_05=null, hero_blog_05_name='', hero_blog_06=null, hero_blog_07=null, hero_blog_08=null, hero_blog_type='', hero_excuse=null, hero_excuse_check=null, hero_excuse_path='', hero_terms_01='', hero_terms_02='', ";
	    $sql_one .= " hero_terms_03='', hero_terms_04='' , hero_terms_05='', hero_today=null, hero_today_plus=null, hero_login_ip=null, hero_dropday=null, hero_point=null ";
	    $sql_one .= ", hero_out_reason = '".$_POST["hero_out_reason"]."', hero_out='".$_POST['hero_out']."', hero_out_date='".time()."', ";
	    $sql_one .= " hero_memo=null, hero_memo_01=null, hero_memo_01_image=null, hero_memo_02=null, hero_memo_03=null, hero_memo_04=null ";
	    $sql_one .= ", hero_user_type = null, hero_user=null, hero_superpass=null, hero_use='1', hero_chk_phone=null, ";
	    $sql_one .= " hero_chk_email=null, area=null, area_etc_text=null, hero_oldday = null, hero_vip = null ";
	    $sql_one .= ", hero_level = 0, hero_write = 0, hero_view = 0, hero_update = 0, hero_rev = 0 ";
	    $sql_one .= ", hero_insta_cnt = 0, hero_insta_grade = null, hero_insta_image_grade = null, hero_youtube_cnt = 0, hero_youtube_grade = null, hero_core_member =  null ";
	    $sql_one .= ", hero_sns_update_date = null, hero_youtube_view = null";
	
		//160527 ÁÖ¼®$sql_one = "hero_out='".$_POST['hero_out']."', hero_use='1', hero_out_date='".time()."'";
		$sql = 'UPDATE member SET '.out($sql_one).' WHERE hero_idx = \''.$_POST['hero_idx'].'\';';
		$result = sql($sql, 'on');
		echo $result;
	}
}
?>