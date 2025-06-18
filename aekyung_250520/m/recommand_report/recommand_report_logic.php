<?php

######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################

	$recommand_sql = 'select * from hero_recommand where hero_recommand_code = \''.$_SESSION['temp_code'].'\' and hero_board_idx = \''.$_GET['hero_idx'].'\';';
	$out_recommand_sql = @mysql_query($recommand_sql);
	$recommand_count = @mysql_num_rows($out_recommand_sql);
	
	
	if(!strcmp($_GET['type'], 'recommand')){
		if(!strcmp($recommand_count, '0')){
			$member_sql = 'select * from member where hero_code = \''.$board_list['hero_code'].'\';';
			$out_member_sql = @mysql_query($member_sql);
			$member_list = @mysql_fetch_assoc($out_member_sql);//mysql_fetch_row
			if(strcmp($_SESSION['temp_code'], '')){
				$hero_url_value = str_ireplace('&type=recommand', '', DOMAIN.URI);
				$sql_one_write = 'hero_url, hero_board, hero_board_idx, hero_board_code, hero_board_id, hero_board_nick, hero_board_name, hero_recommand_code, hero_recommand_id, hero_recommand_nick, hero_recommand_name, hero_today';
				$sql_two_write = '\''.$hero_url_value.'\', \''.$_REQUEST['board'].'\', \''.$_REQUEST['hero_idx'].'\', \''.$member_list['hero_code'].'\', \''.$member_list['hero_id'].'\', \''.$member_list['hero_nick'].'\', \''.$member_list['hero_name'].'\', \''.$_SESSION['temp_code'].'\', \''.$_SESSION['temp_id'].'\', \''.$_SESSION['temp_nick'].'\', \''.$_SESSION['temp_name'].'\', \''.Ymdhis.'\'';
				$hero_recommand_sql = 'INSERT INTO hero_recommand ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
				@mysql_query($hero_recommand_sql);
				$temp_rec = $board_list['hero_rec']+1;
				$up_member_sql = 'UPDATE board SET hero_rec=\''.$temp_rec.'\' WHERE hero_idx = \''.$_REQUEST['hero_idx'].'\';';
				$out_member_sql = @mysql_query($up_member_sql);
			}
		}
		$msg = '추천 하였습니다.';
		$get_herf = get('type','');
		$action_href = $_SERVER['PHP_SELF'].'?'.$get_herf;
		msg($msg,'location.href="'.$action_href.'"');
		exit;
	}
	
	
	
	$report_sql = 'select * from hero_report where hero_report_code = \''.$_SESSION['temp_code'].'\' and hero_board_idx = \''.$_GET['hero_idx'].'\';';
	$out_report_sql = @mysql_query($report_sql);
	$report_count = @mysql_num_rows($out_report_sql);
	
	if(!strcmp($_GET['type'], 'report')){
		if(!strcmp($report_count, '0')){
			$member_sql = 'select * from member where hero_code = \''.$board_list['hero_code'].'\';';
			$out_member_sql = @mysql_query($member_sql);
			$member_list = @mysql_fetch_assoc($out_member_sql);//mysql_fetch_row
			if(strcmp($_SESSION['temp_code'], '')){
				$board = $_GET['board'];
				$hero_idx = $_GET['hero_idx'];
				$page = $_GET['page'];
				$hero_url_value = "/main/index.php?board=".$board."&page=".$page."&view=view&idx=".$hero_idx."";
				//$hero_url_value = str_ireplace('&type=report', '', DOMAIN.URI);
				$sql_one_write = 'hero_url, hero_board, hero_board_idx, hero_board_code, hero_board_id, hero_board_nick, hero_board_name, hero_report_code, hero_report_id, hero_report_nick, hero_report_name, hero_today';
				$sql_two_write = '\''.$hero_url_value.'\', \''.$_REQUEST['board'].'\', \''.$_REQUEST['hero_idx'].'\', \''.$member_list['hero_code'].'\', \''.$member_list['hero_id'].'\', \''.$member_list['hero_nick'].'\', \''.$member_list['hero_name'].'\', \''.$_SESSION['temp_code'].'\', \''.$_SESSION['temp_id'].'\', \''.$_SESSION['temp_nick'].'\', \''.$_SESSION['temp_name'].'\', \''.Ymdhis.'\'';
				$hero_report_sql = 'INSERT INTO hero_report ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
				@mysql_query($hero_report_sql);
			}
		}
		$msg = '신고 하였습니다.';
		$get_herf = get('type','');
		$action_href = $_SERVER['PHP_SELF'].'?'.$get_herf;
		msg($msg,'location.href="'.$action_href.'"');
		exit;
	
	}

?>