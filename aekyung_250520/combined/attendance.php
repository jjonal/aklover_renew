<?php 
##권한 체크
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
##변수 설정
######################################################################################################################################################
$temp_id 		= 	$_SESSION['temp_id'];
$temp_code 		= 	$_SESSION['temp_code'];
$temp_nick 		= 	$_SESSION['temp_nick'];
$my_level 		= 	$_SESSION['temp_level'];
$my_write 		= 	$_SESSION['temp_write'];
$my_view 		= 	$_SESSION['temp_view'];
$my_update 		=	$_SESSION['temp_update'];
$my_rev 		=	$_SESSION['temp_rev'];

$today 			= 	date("Y-m-d");
$full_today 	= 	date("Y-m-d H:i:s");

$board			=	$_GET['board'];


##방문한 회원 리스트 파일로 저장
######################################################################################################################################################

$fileName = date("Ym")."afli9389-4-k04rnjx.txt";
$dir = "../board/guide_4/visitedList/".$fileName;

if(is_file($dir) && is_dir("../board/guide_4/visitedList/"))		$file = fopen($dir,"ab");
elseif(is_dir("../board/guide_4/visitedList/"))						$file = fopen($dir,"wb");

if($file){

	$bname = browser_check();

	$log = "//".$temp_nick."/".date('Y-m-d H:i:s')."/".$bname."\n";
	//echo $log;

	fwrite($file,$log);
	fclose($file);
}


######################################################################################################################################################
$sql = "select * from hero_group where hero_board='".$board."'";
sql($sql, 'on');
$point_list                             = @mysql_fetch_assoc($out_sql);


//페이지 설정 레벨 보다 사용자의 레벨이 높을 경우  
if($point_list['hero_write'] > $my_level){
	if($board!="group_04_04") { //20170630 수정 출석체크는 예외
		error_historyBack("죄송합니다. ".$point_list['hero_write'].' 레벨부터 입장이 가능합니다.');
		exit;
	}
}

	$temp_top_title 	=	 $point_list['hero_title'];
	$temp_title			=	 $point_list['hero_title'];
	$temp_point 		=	 $point_list['hero_write_point'];

	if(!strcmp($temp_point, ''))   	$temp_point = '0';
	else						   	$temp_point = $temp_point;


	$sql = "select * from member where hero_code='".$temp_code."'";
	$member = mysql_query($sql);
	$member_list                             = @mysql_fetch_assoc($member);

	$total_point = $member_list['hero_point'];
	$total = $total_point+$temp_point;


	$old_sql = "select A.hero_sum_point, B.hero_today from (select sum(hero_point) as hero_sum_point, hero_code from point where hero_code='".$temp_code."') as A left outer join (select hero_today, hero_code from point where hero_code='".$temp_code."' and left(hero_today,10)='".$today."' and hero_table='group_04_04') as B on A.hero_code=B.hero_code";
	//echo $old_sql;
	$out_old_sql = mysql_query($old_sql);
	$out_old_res = mysql_fetch_assoc($out_old_sql);
	$old_point = $out_old_res['hero_sum_point'];


	if(!strcmp($old_point,''))   $old_point = '0';
	else				  	     $old_point = $old_point;




	## 출석체크 기능
	######################################################################################################################################################
	if(!strcmp($_GET['type'], 'write')){

		$sql = "select count(*) as double_check from point where hero_table='".$board."' and hero_code = '".$temp_code."' and left(hero_today,10)='".$today."' order by hero_today desc limit 0,1";
		$double_check_sql = mysql_query($sql);

		if(!$double_check_sql){
			logging_error($temp_code, $board."-ATTENDENCE_01 : ".$sql, $full_today);
			error_location("","/main/index.php?board=group_04_04");
			exit;
		}

		$today_list                             = mysql_fetch_assoc($double_check_sql);

		if($today_list['double_check']){

			error_location("이미 출석하셨습니다.", PATH_HOME.'?'.get('type'));
			msg($msg.' 하셨습니다.','location.href="'.$action_href.'"');
			exit;

		}
			

		//포인트 부여 및 등업기능//테이블, 타입, 글번호, 리뷰번호, 제목, 최대포인트 포함여부, 날짜
		######################################################################################################################################################
		//한달 개근 50point 증정
		if(date('d',time())==date('t')){
			attendanceGift($temp_id, $temp_code);
		};		
		//$point_insert_pf = pointInsert($board, 'attendance', 0, 0, "출석체크", 'Y', $full_today);
		
		$point_insert_pf = pointAdd($board, 'attendance', 0, 0, 0, "출석체크", 'Y');
		//echo $point_insert_pf;
		//exit;
		if(substr($point_rs,0,7)=='message'){
			$point_rs = explode(":",$point_rs);
			message($point_rs[1]);
		}elseif($point_insert_pf!=1){

			error_location("",PATH_HOME.'?'.get('type'));
			exit;

		}
			
			
		location(URI_PATH.'?'.get('type'));
			
		######################################################################################################################################################
		exit;
	}
	######################################################################################################################################################
?>