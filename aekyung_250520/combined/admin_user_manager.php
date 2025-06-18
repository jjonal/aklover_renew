<?php 

######  접근제한    #################################################
if(!defined('_HEROBOARD_'))exit;

if($_SESSION['temp_level']<9999 || !is_numeric($_SESSION['temp_level'])) exit;


######  변수설정    #################################################
$oneMonthAgo = date("Y-m-d",strtotime("-1 month"));
$threeMonthAgo = date("Y-m-d",strtotime("-3 month"));
$this_year = date('Y',time());
$list_page=50;
$page_per_list=10;
$total_data = 0;
$page = 0;
$start = 0;
$next_path ='';
$order ="";
$NO = 0;
$board = $_POST['board'];

if($_POST['order']){
	$order = $_POST['order'];
	$order = explode('-',$order);
	$order = "hero_".$order[0]." ".$order[1];

}else{
	$order = "hero_possible desc";
}


if($_POST['mode']=='search'){

	$user_id	 			= $_POST['user_id'];
	$user_nick 				= $_POST['user_nick'];
	$user_name 				= $_POST['user_name'];
	$user_level 			= $_POST['user_level'];
	$user_region 			= $_POST['user_region'];
	$user_age 				= $_POST['user_age'];
	$user_point_bypoint 	= $_POST['user_point_bypoint'];
	$user_point_bypoint_02 	= $_POST['user_point_bypoint_02'];
	$user_point_bydate 		= $_POST['user_point_bydate'];
	$user_penalty 			= $_POST['user_penalty'];
	$user_phone_agree 		= $_POST['user_phone_agree'];
	$user_email_agree 		= $_POST['user_email_agree'];

	$keyword		 		= $_POST['keyword'];
	$content_grade	 		= $_POST['content_grade'];
	$visit_count		 	= $_POST['visit_count'];
	$blog_type		 		= $_POST['blog_type'];
	$mission_sns		 	= $_POST['mission_sns'];
	$mission_sns2		 	= $_POST['mission_sns2'];
	$mission_sns3		 	= $_POST['mission_sns3'];
	$mission_sns4		 	= $_POST['mission_sns4'];

	$user_power_blog	 	= $_POST['user_power_blog'];
	$user_vip_user			= $_POST['user_vip_user'];
	$all_check				= $_POST['all_check'];
	$superpass				= $_POST['superpass'];
	$double_member			= $_POST['double_member'];
	
	$user_today				= $_POST['user_today'];
	
	$user_di				= $_POST['user_di'];
	

	//3개월 전

	$search_condition = '';
	$search_condition_02 = '';
	$double_member_query = '';
	$serach_condition_best_review = '';
	
	if($user_id)														$search_condition .= "and hero_id like '%".$user_id."%' ";
	if($user_nick)														$search_condition .= "and hero_nick like '%".$user_nick."%' ";
	if($user_name)														$search_condition .= "and hero_name like '%".$user_name."%' ";

	if(is_numeric($user_level[0]) && is_numeric($user_level[1]))		$search_condition .= "and hero_level >= ".$user_level[0]." and hero_level <= ".$user_level[1]." ";
	elseif(is_numeric($user_level[0]) && !is_numeric($user_level[1]))	$search_condition .= "and hero_level = ".$user_level." ";

	if($user_region)													$search_condition .= "and (hero_address_02 like '%".$user_region."%' or hero_address_03 like '%".$user_region."%') ";

	if($user_point_bypoint[0] && $user_point_bypoint[1])				$search_condition .= "and hero_total >= ".$user_point_bypoint[0]." and hero_total <= ".$user_point_bypoint[1]." ";
	elseif($user_point_bypoint[0] && !$user_point_bypoint[1])			$search_condition .= "and hero_total = ".$user_point_bypoint[0]." ";

	if(is_numeric($user_point_bypoint_02[0]) && is_numeric($user_point_bypoint_02[1]))			$search_condition .= "and hero_possible >= ".$user_point_bypoint_02[0]." and hero_possible <= ".$user_point_bypoint_02[1]." ";
	elseif(($user_point_bypoint_02[0]) && !is_numeric($user_point_bypoint_02[1]))				$search_condition .= "and hero_possible = ".$user_point_bypoint_02[0]." ";

	if($user_point_bydate[0] && $user_point_bydate[1])					$search_condition_02 .= "and left(hero_today,10) >= '".$user_point_bydate[0]."' and left(hero_today,10) <= '".$user_point_bydate[1]."' ";
	elseif($user_point_bydate[0] && !$user_point_bydate[1])				$search_condition_02 .= "and left(hero_today,10) = '".$user_point_bydate[0]."' ";

	if($user_age){
		switch($user_age){
			case 1 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) < 11 ";break;
			case 10 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 11 and (".$this_year."-left(hero_jumin,4)+1) <= 15 ";break;
			case 15 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 16 and (".$this_year."-left(hero_jumin,4)+1) <= 20 ";break;
			case 20 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 21 and (".$this_year."-left(hero_jumin,4)+1) <= 25 ";break;
			case 25 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 26 and (".$this_year."-left(hero_jumin,4)+1) <= 30 ";break;
			case 30 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 31 and (".$this_year."-left(hero_jumin,4)+1) <= 35 ";break;
			case 35 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 36 and (".$this_year."-left(hero_jumin,4)+1) <= 40 ";break;
			case 40 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 41 and (".$this_year."-left(hero_jumin,4)+1) <= 45 ";break;
			case 45 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 46 and (".$this_year."-left(hero_jumin,4)+1) <= 50 ";break;
			case 50 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 51 and (".$this_year."-left(hero_jumin,4)+1) <= 55 ";break;
			case 55 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 56 and (".$this_year."-left(hero_jumin,4)+1) <= 60 ";break;
			case 60 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 61 ";break;
		}
	}

	if($user_penalty)													$search_condition .= "and (hero_memo_02 like '%".$user_penalty."%' or hero_memo_03 like '%".$user_penalty."%' or hero_memo_04 like '%".$user_penalty."%') ";
	if(is_numeric($user_phone_agree))									$search_condition .= "and (hero_chk_phone=".$user_phone_agree." or hero_chk_phone=2) ";
	if(is_numeric($user_email_agree))									$search_condition .= "and (hero_chk_email=".$user_email_agree." or hero_chk_email=2) ";

	if($content_grade)													$search_condition .= "and hero_memo_01='".$content_grade."' ";
	if($visit_count)													$search_condition .= "and hero_memo='".$visit_count."' ";
	if($blog_type)														$search_condition .= "and (hero_blog_00 like '%".$blog_type."%' or hero_blog_01 like '%".$blog_type."%' or hero_blog_02 like '%".$blog_type."%' or hero_blog_03 like '%".$blog_type."%' or hero_blog_04 like '%".$blog_type."%' or hero_blog_05 like '%".$blog_type."%') ";

	if($mission_sns)													$search_condition .= "and (hero_blog_00 like '%".$mission_sns."%' or hero_blog_01 like '%".$mission_sns."%' or hero_blog_02 like '%".$mission_sns."%' or hero_blog_03 like '%".$mission_sns."%' or hero_blog_04 like '%".$mission_sns."%' or hero_blog_05 like '%".$mission_sns."%') ";
	if($mission_sns2)													$search_condition .= "and (hero_blog_00 like '%".$mission_sns2."%' or hero_blog_01 like '%".$mission_sns2."%' or hero_blog_02 like '%".$mission_sns2."%' or hero_blog_03 like '%".$mission_sns2."%' or hero_blog_04 like '%".$mission_sns2."%' or hero_blog_05 like '%".$mission_sns2."%') ";
	if($mission_sns3)													$search_condition .= "and (hero_blog_00 like '%".$mission_sns3."%' or hero_blog_01 like '%".$mission_sns3."%' or hero_blog_02 like '%".$mission_sns3."%' or hero_blog_03 like '%".$mission_sns3."%' or hero_blog_04 like '%".$mission_sns3."%' or hero_blog_05 like '%".$mission_sns3."%') ";
	if($mission_sns4)													$search_condition .= "and (hero_blog_00 like '%".$mission_sns4."%' or hero_blog_01 like '%".$mission_sns4."%' or hero_blog_02 like '%".$mission_sns4."%' or hero_blog_03 like '%".$mission_sns4."%' or hero_blog_04 like '%".$mission_sns4."%' or hero_blog_05 like '%".$mission_sns4."%') ";
	
	if($user_power_blog==1)												$search_condition .= "and A.hero_memo>2000 and A.hero_memo_01='상' ";
	if($user_vip_user) {
		$search_condition .= "and hero_core_member ='Y'";
		$search_core = " and (";
		for($i=0; $i<count($user_vip_user); $i++) {
			if($i > 0 && $i < count($user_vip_user)) {
				$search_core .= " or ";
			}
			if($user_vip_user[$i] == "A") {
				$search_core .= " hero_memo_01 = '상'";
			}
			if($user_vip_user[$i] == "B") {
				$search_core .= " hero_memo >= 1500";
			}
			/*
			if($user_vip_user[$i] == "B") {
				$serach_condition_best_review = " left outer join (select hero_code from board WHERE hero_board_three = 1 group by hero_code) as D on D.hero_code = A.hero_code ";
				$search_core .= " D.hero_code is not null";
			}
			*/
			
		}
		$search_core .= ")";
		$search_condition .= $search_core;

	}
	

	if($user_today){
		if(strlen($user_today)==7)										$search_condition .= "and left(A.hero_oldday,7)='".$user_today."' ";
		elseif(strlen($user_today)==10)									$search_condition .= "and left(A.hero_oldday,10)='".$user_today."' ";
	}

	if($superpass)														$search_condition .= "and A.hero_superpass='".$superpass."' ";
	
	
	//이중회원 - 해당소스는 맨아래에 위치해야 한다. $serach_condition 으로 분기하기때문에
	if($double_member){
		if($search_condition == ""){
			$double_member_query = " ,(select hero_login_ip from member group by hero_login_ip having count(hero_login_ip) > 1) as E ";
			$search_condition .= "and A.hero_login_ip = E.hero_login_ip ";
		}else{
			$search_condition .= "or A.hero_login_ip=(select hero_login_ip from member where 1=1 ".$search_condition.")";

		}
	}
	
	if($user_di == "1") {
		$search_condition .= " and (A.hero_info_di is not null or A.hero_info_di <> '' ) ";
	} else if($user_di == "2") {
		$search_condition .= " and (A.hero_info_di is null or A.hero_info_di = '' )";
	}
}


?>