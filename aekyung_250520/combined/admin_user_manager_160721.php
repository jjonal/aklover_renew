<?php 

######  접근제한    #################################################
if(!defined('_HEROBOARD_'))exit;

if($_SESSION['temp_level']<9999 || !is_numeric($_SESSION['temp_level'])) exit;


######  변수설정    #################################################
$oneMonthAgo = date("Y-m-d",strtotime("-1 month"));
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

	$user_power_blog	 	= $_POST['user_power_blog'];
	$user_vip_user			= $_POST['user_vip_user'];
	$superpass				= $_POST['superpass'];

	$user_today				= $_POST['user_today'];

	//3개월 전

	$search_condition = '';
	$search_condition_02 = '';

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

	if($user_power_blog==1)												$search_condition .= "and A.hero_memo>2000 and A.hero_memo_01='상' ";
	if($user_vip_user==1)												$search_condition .= "and D.hero_code!='' and A.hero_today>='".$oneMonthAgo."' and hero_blog_00!='' ";

	if($user_today){
		if(strlen($user_today)==7)										$search_condition .= "and left(A.hero_oldday,7)='".$user_today."' ";
		elseif(strlen($user_today)==10)									$search_condition .= "and left(A.hero_oldday,10)='".$user_today."' ";
	}

	if($superpass)														$search_condition .= "and A.hero_superpass='".$superpass."' ";


}


?>