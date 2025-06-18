<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //레벨제한

$mode = $_POST["mode"];
$hero_code = $_POST["hero_code"];
$data = array();
if($mode == "withdrawal") {
    //241213 뮤자인 수정 - hero_hp 삭제
	$sql_column = "hero_table='', hero_info_type=null, hero_info_di=null, hero_info_ci=null, hero_facebook='' ";
	$sql_column .= ", hero_kakaoTalk='', hero_naver='', hero_google = '' ";
	$sql_column .= ", hero_pw=null, hero_name=null, hero_jumin=null, hero_sex=null, hero_mail=null, hero_address_01=null, hero_address_02=null, ";
	$sql_column .= " hero_address_03=null, hero_job_01=null, hero_job_02=null, hero_job_03=null, hero_blog_00=null, hero_blog_01=null, hero_blog_02=null, hero_blog_03=null, ";
	$sql_column .= " hero_blog_04=null, hero_blog_05=null, hero_blog_05_name='', hero_blog_06=null, hero_blog_07=null, hero_blog_08=null,  ";
	$sql_column .= " hero_blog_type='', hero_excuse=null, hero_excuse_check=null, hero_excuse_path='', hero_terms_01='', hero_terms_02='',";
	$sql_column .= " hero_terms_03='', hero_terms_04='' , hero_terms_05='', hero_today=null, hero_today_plus=null, hero_login_ip=null, hero_dropday=null, hero_point=null ";
	$sql_column .= ", hero_out_reason = '0', hero_out='관리자에 의해 탈퇴 되었습니다.', hero_out_date='".time()."', ";
	$sql_column .= " hero_memo=null, hero_memo_01=null, hero_memo_01_image = null, hero_memo_02=null, hero_memo_03=null, hero_memo_04=null ";
	$sql_column .= ", hero_user_type = null, hero_user=null, hero_superpass=null, hero_use='1', hero_chk_phone=null, ";
	$sql_column .= " hero_chk_email=null, area=null, area_etc_text=null, hero_oldday = null, hero_vip = null ";
	$sql_column .= ", hero_level = 0, hero_write = 0, hero_view = 0, hero_update = 0, hero_rev = 0 ";
	$sql_column .= ", hero_insta_cnt = 0, hero_insta_grade = null, hero_insta_image_grade = null, hero_youtube_cnt = 0, hero_youtube_grade = null, hero_core_member =  null ";
	$sql_column .= ", hero_youtube_view = null, hero_sns_update_date = null ";
	
	$sql =  " UPDATE member SET ".$sql_column." WHERE hero_use = 0 AND hero_code = '".$hero_code."' ";
	$result = sql($sql,"on");
	
	if(!$result) {
		$data["result"] = "-1";
	} else {
		$data["result"] = "1";
	}
} else if($mode == "edit") { //기본정보 수정
	$member_sql  = " SELECT hero_chk_phone, hero_chk_email FROM member "; 
	$member_sql .= " WHERE hero_use = 0 AND hero_code = '".$hero_code."' ";
	$member_res = sql($member_sql,"on");
	
	$view = mysql_fetch_assoc($member_res);
	
	$hero_chk_phone_past = $view["hero_chk_phone"];
	$hero_chk_email_past = $view["hero_chk_email"];
	
	
	$hero_hp = $_POST["hero_hp_01"]."-".$_POST["hero_hp_02"]."-".$_POST["hero_hp_03"];
	$hero_mail = $_POST["hero_mail_01"]."@".$_POST["hero_mail_02"];
	$sql  = " UPDATE member SET ";
	$sql .= " hero_hp = '".$hero_hp."', hero_mail = '".$hero_mail."' ";
	$sql .= " , hero_chk_phone = '".$_POST["hero_chk_phone"]."', hero_chk_email = '".$_POST["hero_chk_email"]."' ";
	//$sql .= " , hero_address_01 = '".$_POST["hero_address_01"]."', hero_address_02 = '".$_POST["hero_address_02"]."', hero_address_03 = '".$_POST["hero_address_03"]."' ";
	$sql .= " WHERE hero_use = 0 AND hero_code = '".$hero_code."' ";
	
	$result = sql(out($sql));
	
	//수신동의 히스토리 저장 21-09-08
	$ins_history_sql  = " INSERT INTO member_agree_history ";
	$ins_history_sql .= " (hero_today, hero_chk_phone_past, hero_chk_email_past, hero_chk_phone, hero_chk_email, route, hero_code, edit_hero_code) VALUES ";
	$ins_history_sql .= " (now(),'".$hero_chk_phone_past."','".$hero_chk_email_past."','".$_POST["hero_chk_phone"]."','".$_POST["hero_chk_email"]."','A','".$hero_code."','".$_SESSION["temp_code"]."') ";
	
	$result = sql($ins_history_sql);
	
	
	if(!$result) {
		$data["result"] = "-1";
	} else {
		$data["result"] = "1";
	}
} else if($mode == "editSns") { //SNS 관리 정보 수정
    if(!isset($_POST["hero_blog_00"]) || empty($_POST["hero_blog_00"])) {
        $blog_00 = $_POST["hero_blog_00"];
    } else {
        $blog_00 = "https://blog.naver.com/".$_POST["hero_blog_00"];
    }
    
    if(!isset($_POST["hero_blog_04"]) || empty($_POST["hero_blog_04"])) {
        $blog_04 = $_POST["hero_blog_04"];
    } else {
        $blog_04 = "https://www.instagram.com/".$_POST["hero_blog_04"];
    }
    
    if(!isset($_POST["hero_naver_influencer"]) || empty($_POST["hero_naver_influencer"])) {
        $naver_influencer = $_POST["hero_naver_influencer"];
    } else {
        $naver_influencer = "https://in.naver.com/".$_POST["hero_naver_influencer"];
    }
    
	$sql  = " UPDATE member SET ";
	$sql .= " hero_blog_00 = '".$blog_00."', hero_memo = '".$_POST["hero_memo"]."' , hero_memo_01_image = '".$_POST["hero_memo_01_image"]."' , hero_memo_01 = '".$_POST["hero_memo_01"]."' ";
	$sql .= " , hero_blog_04 = '".$blog_04."', hero_insta_cnt = '".$_POST["hero_insta_cnt"]."', hero_insta_image_grade = '".$_POST["hero_insta_image_grade"]."', hero_insta_grade = '".$_POST["hero_insta_grade"]."' ";
	$sql .= " , hero_blog_03 = '".$_POST["hero_blog_03"]."', hero_youtube_cnt = '".$_POST["hero_youtube_cnt"]."', hero_youtube_grade = '".$_POST["hero_youtube_grade"]."' ";
	$sql .= " , hero_youtube_view = '".$_POST["hero_youtube_view"]."' ";
	$sql .= " , hero_blog_05 = '".$_POST["hero_blog_05"]."' ";
	$sql .= " , hero_blog_06 = '".$_POST["hero_blog_06"]."' ";
	$sql .= " , hero_blog_07 = '".$_POST["hero_blog_07"]."' ";
	$sql .= " , hero_blog_08 = '".$_POST["hero_blog_08"]."' ";
	$sql .= " , hero_naver_influencer = '".$naver_influencer."' , hero_naver_influencer_name = '".$_POST["hero_naver_influencer_name"]."' , hero_naver_influencer_category = '".$_POST["hero_naver_influencer_category"]."'";
	$sql .= " , hero_sns_update_date = '".$_POST["hero_sns_update_date"]."' ";
	$sql .= " WHERE hero_use = 0 AND hero_code = '".$hero_code."' ";
	
	$result = sql(out($sql),"on");
	
	if(!$result) {
		$data["result"] = "-1";
	} else {
		$data["result"] = "1";
	}	
} else if($mode = "pwInitialize") {
    if(isset($_POST["pw_initialized"]) && !empty($_POST["pw_initialized"])) {
        $member_sql  = " SELECT hero_nick, hero_id FROM member ";
        $member_sql .= " WHERE hero_code = '".$hero_code."' ";
        $member_res = sql($member_sql,"on");
        
        $view = mysql_fetch_assoc($member_res);
        
        $hero_nick = $view["hero_nick"];
        $hero_id = $view["hero_id"];
        
        $ins_history_sql  = " INSERT INTO member_pw_initialize ";
        $ins_history_sql .= " (hero_today, hero_nick, hero_id, hero_code) VALUES ";
        $ins_history_sql .= " (now(), "."'".$hero_nick."','".$hero_id."','".$hero_code."') ";
        $result = sql($ins_history_sql);
        
        $userId = $hero_id;
        $userPw = md5($_POST["pw_initialized"]);
        $temp = $userPw.$userId;
        $sha3_pw = sha3_hash('sha3-256', $temp);
        
        $update_sql  = "UPDATE member SET hero_pw = '".$sha3_pw."' WHERE hero_id = '".$userId."' AND hero_code = '".$hero_code."'";
        $result = sql(out($update_sql),"on");
        
        if(!$result) {
            $data["result"] = "-1";
        } else {
            $data["result"] = "1";
        }
    } else {
        $data["result"] = "-1";
    }
}
echo json_encode($data);
exit;
?>