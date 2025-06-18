<?
	$board_type = "1";
	if($_GET['board'] == 'group_04_05' && $mission_board_type){ //체험단 && 소문내기
		$board_type = "1";
	} else if($_GET['board'] == 'group_04_05'){ //체험단
		$board_type = "2";
	} else {
		$board_type = "3";
	}

	//20170512 체험단 일때만 당첨자 조건에 따른 탭메뉴 노출
	if($board_type != "3") {
		$sql_winner = "select lot_01 from mission_review where hero_table = '" . $_GET ['board'] . "' and hero_code='" . $_SESSION ['temp_code'] . "' and hero_old_idx='" . $_GET ['mission_idx'] . "'";
		
		sql($sql_winner);
		$data_winner = @mysql_fetch_assoc ($out_sql);
	}
	
	//당첨여부
	$winner_yn = "N";
	if($board_type == "3") {
		if($_SESSION['temp_level']  == $right_list['hero_view'] ||  $_SESSION['temp_id'] == "sr1787" ||  $_SESSION['temp_id'] == "dai42429" || $_SESSION['temp_level'] >= 9999) {
			$winner_yn = "Y";
		} else if($out_row['hero_type'] == "0" && $_GET['board'] == "group_04_27") {
			if($_SESSION['temp_level'] == "9993") $winner_yn = "Y";
		} 
	}else {
		if($data_winner["lot_01"] == "1" || $_SESSION['temp_level'] >= 9999) $winner_yn = "Y";
	}
	
	if($out_row['hero_command'] == "&lt;br /&gt;") {
		$command = "";	
	} else {
		//공지 상세
		$command = htmlspecialchars_decode ( $out_row['hero_command'] );
		$command = str_replace("&#160;","",$command);
		
		//20170512 체험단신청(체험단만 존재)
		$hero_media = htmlspecialchars_decode ( $out_row['hero_media'] );
		$hero_media = str_replace("&#160;","",$hero_media);
	}
?>
<div class="content_guide rel">
	<? if($command){ ?>
		<div class="spm_img notice_bottom tabBtnArea1">			
			<div class="more_view_cont rel">
				<?=htmlspecialchars_decode($command);?>
			</div>
			<? if($out_row['hero_product_more']) { ?>
			<div class="more_div">
				<a href="<?=$out_row['hero_product_more']?>" class="product_more" target="_blank">제품정보 더 보기 ></a>
			</div>
			<? } else { ?>
				<div class="more_btn more_btn_view fz28 bold">더보기</div>
			<? } ?>
		</div> <!-- 미션공지 테이블말고 div로 함 -->
	<? } ?>
</div>