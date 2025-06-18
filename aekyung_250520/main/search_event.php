<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD오픈

######################################################################################################################################################
include_once '../freebest/head.php';
include_once FREEBEST_INC_END.'function.php';

######################################################################################################################################################
if($_SESSION['temp_level']<9999){
	echo iconv("EUC-KR", "UTF-8", 'message:비정상적인 접근입니다. 로그인 후에 다시 시도해 주세요.');
	exit;
		
}

######################################################################################################################################################
$mission_idx 	= 	$_POST['idx'];
$board_idxs 	= 	$_POST['idxs'];
$search_mode 	= 	$_POST['search_mode'];
$search_text 	=	iconv("UTF-8", "EUC-KR", $_POST['search_text']);
$code		 	=	$_SESSION['temp_code'];

if($mission_idx){
	
	$sub_where = "hero_01='".$mission_idx."'";
	$error = "SEARCH_EVENT_01";
	
}elseif($search_text){
	
	if(!$search_text){
		echo iconv("EUC-KR", "UTF-8", "message:검색어를 입력해주세요.");
		exit;
	}elseif(!$search_mode){
		echo "message:검색옵션을 선택해주세요.";
		exit;
	}
	
	if($search_mode!='total'){
		$sub_where = "hero_".$search_mode." like '%".$search_text."%' ";
	}else{
		$sub_where = "(hero_title or hero_command or hero_nick or hero_code or hero_name like '%".$search_text."%') ";
	}	
	
	$error = "SEARCH_EVENT_02";
	
}elseif($board_idxs){
	
	$sub_where = "hero_idx in (".$board_idxs.")";
	$error = "SEARCH_EVENT_03";
	
}


	$main_sql = "select hero_idx, hero_table, left(hero_nick,4) as hero_nick, left(hero_title,30) as hero_title, hero_img_new, hero_thumb, left(hero_today,10) as hero_today from board where ".$sub_where." order by hero_idx desc";
	$main_res = new_sql($main_sql,$error,"on");
	
	if($main_res==$error){
		echo "0";
		exit;
	}
	
	$main_rs_count = mysql_num_rows($main_res);
	$event_data = "";
	
	$i=$main_rs_count;
	
	if($main_rs_count==0){
		$event_data .= "<tr>";
		$event_data .= "<td colspan='5'>no data</td>";
		$event_data .= "</tr>";
	}else{
		while($main_rs = mysql_fetch_assoc($main_res)){
			
			if($main_rs['hero_thumb']){
				$hero_thumb = "<img class='thumb_img' src='".$main_rs['hero_thumb']."'/>";
			}elseif($main_rs['hero_img_new']){
				$hero_thumb = "<img class='thumb_img' src='".$main_rs['hero_img_new']."'/>";
			}
			$event_data .= "<tr>";
			$event_data .= "<td><div class='input_chk'><input id='td_num_".$main_rs['hero_idx']."' type='checkbox' value='".$main_rs['hero_idx']."'/> <label for='td_num_".$main_rs['hero_idx']."' class='input_chk_label'></label></div></td>";
			$event_data .= "<td onclick=\"window.open('/main/index.php?board=group_04_09&view=view&idx=".$main_rs['hero_idx']."');\">".$i."</td>";
			$event_data .= "<td onclick=\"window.open('/main/index.php?board=group_04_09&view=view&idx=".$main_rs['hero_idx']."');\">".$hero_thumb."</td>";
			$event_data .= "<td onclick=\"window.open('/main/index.php?board=group_04_09&view=view&idx=".$main_rs['hero_idx']."');\">".$main_rs['hero_nick']."</td>";
			$event_data .= "<td onclick=\"window.open('/main/index.php?board=group_04_09&view=view&idx=".$main_rs['hero_idx']."');\">".$main_rs['hero_title']."</td>";
			$event_data .= "<td onclick=\"window.open('/main/index.php?board=group_04_09&view=view&idx=".$main_rs['hero_idx']."');\">".$main_rs['hero_today']."</td>";
			$event_data .= "</tr>";
				
			$i--;
			$hero_thumb='';
		}
	}
	
	echo iconv("EUC-KR", "UTF-8", $event_data);
	exit;
