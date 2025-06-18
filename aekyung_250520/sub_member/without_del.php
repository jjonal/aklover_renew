<?
####################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
####################################################################################################################################################
$_POST['hero_idx'];

    $login_pw = $_POST['hero_pw'];
    $login_id = $_POST['hero_id'];
    $pw_md5 = md5($login_pw);
    $temp = $pw_md5.$login_id;
    $pw_sha3_256 = sha3_hash('sha3-256', $temp);
    
    $sql = "select * from member where hero_id = '".$_POST['hero_id']."' and hero_pw = '".$pw_sha3_256."';";
    sql($sql, 'on');
    $count = @mysql_num_rows($out_sql);
    
if(!strcmp($count, '0')){
    msg('비밀번호를 정확히 입력해주세요.','history.go(-1)');
}else{
	$result = 0;
    $sql_one = 'hero_use=\'1\'';
    $sql = 'UPDATE admin SET '.$sql_one.' WHERE hero_id = \''.$_POST['hero_id'].'\';';
    sql($sql, 'on');
	//241213 뮤자인 수정 - hero_hp 삭제
	$sql_one = "hero_table='', hero_info_type=null, hero_info_di=null, hero_info_ci=null, hero_facebook='' ";
	$sql_one .= ", hero_kakaoTalk='', hero_naver='', hero_google = '' ";
    $sql_one .= ", hero_pw=null, hero_name=null, hero_jumin=null, hero_sex=null, hero_mail=null, hero_address_01=null, hero_address_02=null, ";
    $sql_one .= " hero_address_03=null, hero_job_01=null, hero_job_02=null, hero_job_03=null, hero_blog_00=null, hero_blog_01=null, hero_blog_02=null, hero_blog_03=null, ";
    $sql_one .= " hero_blog_03_channel_name = null, hero_blog_04=null, hero_blog_05=null, hero_blog_05_name='', hero_blog_06=null , hero_blog_07=null , hero_blog_08=null, hero_blog_type='', hero_excuse=null, hero_excuse_check=0, hero_excuse_path='', hero_terms_01='0', hero_terms_02='0', ";
    $sql_one .= " hero_terms_03='0', hero_terms_04='0' , hero_terms_05=null, hero_today=null, hero_today_plus=null, hero_login_ip=null, hero_dropday=null, hero_point=0 ";
    $sql_one .= ", hero_out_reason = '".$_POST["hero_out_reason"]."', hero_out='".$_POST['hero_out']."', hero_out_date='".time()."', ";
    $sql_one .= " hero_memo=null, hero_memo_01=null , hero_memo_01_image=null, hero_memo_02=null, hero_memo_03=null, hero_memo_04=null ";
    $sql_one .= ", hero_user_type = null, hero_user=null, hero_superpass='', hero_use='1', hero_chk_phone='0', ";
    $sql_one .= " hero_chk_email=1, area=null, area_etc_text=null, hero_activity = null, hero_oldday = null, hero_vip = 'N' ";
    $sql_one .= ", hero_level = 0, hero_write = 0, hero_view = 0, hero_update = 0, hero_rev = 0 ";
    $sql_one .= ", hero_insta_cnt = 0, hero_insta_grade = null, hero_insta_image_grade = null , hero_youtube_cnt = 0, hero_youtube_grade = null, hero_core_member =  'N' ";
    $sql_one .= ", hero_sns_update_date = null, hero_youtube_view = null";
    
	//160527 주석$sql_one = "hero_out='".$_POST['hero_out']."', hero_use='1', hero_out_date='".time()."'";
    $sql = 'UPDATE member SET '.$sql_one.' WHERE hero_idx = \''.$_POST['hero_idx'].'\';';

    $result = sql($sql, 'on');
    $msg = '탈퇴';
    $action_href = PATH_END.'out.php';
    if($result) {
    	msg($msg.' 되었습니다.','location.href="'.$action_href.'"');
    } else {
    	msg('탈퇴 실패했습니다.','history.go(-1)');
    }
}
?>