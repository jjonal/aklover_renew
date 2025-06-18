<?
// ####################################################################################################################################################
// HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
// ####################################################################################################################################################
if (! defined ( '_HEROBOARD_' ))	exit ();
	// ####################################################################################################################################################
if (! strcmp ( $_SESSION ['temp_level'], '' )) {
	$my_level = '0';
	$my_write = '0';
	$my_view = 0;
	$my_update = '0';
	$my_rev = '0';
} else {
	$my_level = $_SESSION ['temp_level'];
	$my_write = $_SESSION ['temp_write'];
	$my_view = $_SESSION ['temp_view'];
	$my_update = $_SESSION ['temp_update'];
	$my_rev = $_SESSION ['temp_rev'];
}

// ####################################################################################################################################################
$cut_title_name = '26';
$sql = "select * from mission as A, (select count(hero_superpass) as superpass from mission_review where hero_old_idx='".$_GET ['idx']."' and hero_table='" . $_GET ['board'] . "' and hero_superpass ='Y') as B where hero_table = '" . $_GET ['board'] . "' and hero_idx='" . $_GET ['idx'] . "';";
//echo "<script>console.log('".$sql."')";
sql ( $sql, 'on' );
$out_row = @mysql_fetch_assoc ( $out_sql ); // mysql_fetch_row

$check_day = date ( "Y-m-d", time () );
$today_04_02 = date ( "Y-m-d", strtotime ( $out_row ['hero_today_04_02'] ) );

if ($my_write < '99' and $today_04_02 < $check_day){
	
	$action_href = PATH_HOME . '?' . get ( 'view' );
	msg(' 마감된 미션입니다.', 'location.href="' . $action_href . '"' );
	exit ();

}
// ####################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\'' . $_GET ['board'] . '\';'; // desc
sql ( $sql );
$right_list = @mysql_fetch_assoc ( $out_sql );

// 프리미엄 미션은 로그인이후 접속가능
if ($_GET ['board'] == 'group_04_06' || $_GET ['board'] == 'group_04_08') {
	$tf = false;
	if($my_view==0){
		error_historyBack("로그인이 필요한 미션입니다");
		exit;
	}
	//LUNA 체험단
	elseif($_GET ['board'] == 'group_04_06'){
		$temp_id = $_SESSION['temp_id'];
		$group_04_06_list = array("ADMIN", "AEKYUNG", "utlt0716","opcso806", "gomsongja","urii4","jimin5566","azzan","theka19","caroljoo","haonsu","bbyuneh","iamjini","yndbsk","ssj126","eg2820","strowberrys","djatndus12","upopo11","jjy3153","heeen134","juyeong0417","wada85","abbeyroad","dusghkhot","amandahyun","saphira","joara2938","sally_yu90","yjsm79","acarian","wgh17626","zioooiz","wlgysnl23","hsyeon91","rara8386","yunha7684","phe6594","about9311");
		foreach ($group_04_06_list as $ab) {
			if($ab == $temp_id){
					$tf = true;
			}
		}
		if($tf==false){
			error_historyBack("죄송합니다. 이 미션은 선정된 인원만 참여가 가능합니다.");
			exit;
		}
	}
	//AK 기자단
	elseif($right_list ['hero_view'] > $my_view){
		error_historyBack("죄송합니다. 이 미션은 레벨 ".$right_list ['hero_view']."부터 참여할 수 있습니다.");
		exit;
	}
}

// 다른 미션들은 비로그인시에도 볼 수 있도록 하였음.
// ####################################################################################################################################################
$temp_id = $_SESSION ['temp_id'];
$temp_code = $_SESSION ['temp_code'];
$temp_top_title = $right_list ['hero_title'];
$temp_title = $out_row ['hero_title'];
$temp_point = $right_list ['hero_view_point'];
$temp_idx = $_GET ['idx'];
if (! strcmp ( $temp_point, '' )) {
	$temp_point = '0';
} else {
	$temp_point = $temp_point;
}
if ((! strcmp ( $my_level, '0' )) or (! strcmp ( $temp_point, '0' ))) {
	// 포인트는 없다
} else {
	
	// 2014.05.14 로그인 이후 포인트관련 기능이 작동하도록 수정
	if ($right_list ['hero_view'] <= $my_view) {
		
		$sql = 'select * from point where hero_table=\'' . $_GET ['board'] . '\' and hero_code = \'' . $temp_code . '\' and hero_type=\'' . $_GET ['view'] . '\' and hero_old_idx=\'' . $_GET ['idx'] . '\' order by hero_today desc limit 0,1;';
		sql ( $sql, 'on' );
		$today_list = @mysql_fetch_assoc ( $out_sql );
		$last_day = date ( "Ymd", strtotime ( $today_list ['hero_today'] ) );
		$to_day = date ( "Ymd", time () );
		if (! strcmp ( $to_day, $last_day )) {
		} else {
			$member_sql = 'select * from member where hero_code=\'' . $temp_code . '\'';
			$out_member = mysql_query ( $member_sql );
			$member_list = @mysql_fetch_assoc ( $out_member );
			$total_point = $member_list ['hero_point'];
			$total = $total_point + $temp_point;
			
			$today_sql = 'select * from point where date(hero_today)=\'' . date ( "Y-m-d", time () ) . '\' and hero_code=\'' . $temp_code . '\' and not hero_title="월출석개근";';
			$out_today_sql = mysql_query ( $today_sql );
			$today_total_point = '0';
			while ( $today_today_list = @mysql_fetch_assoc ( $out_today_sql ) ) {
				$today_total_point = $today_total_point + $today_today_list ['hero_point'];
			}
			if (! strcmp ( $today_total_point, '' )) {
				$today_total_point = '0';
			} else {
				$today_total_point = $today_total_point;
			}
			$admin_today_sql = 'select * from today where hero_type=\'hero_total\'';
			$out_admin_today_sql = mysql_query ( $admin_today_sql );
			$admin_today_today_list = @mysql_fetch_assoc ( $out_admin_today_sql );
			if ($admin_today_today_list ['hero_point'] > $today_total_point) {
				$level_sql = 'select * from level where hero_level!=\'0\' and hero_point_01<=\'' . $total . '\' and hero_point_02>=\'' . $total . '\'';
				$out_level = mysql_query ( $level_sql );
				$level_list = @mysql_fetch_assoc ( $out_level );
				$level_up_sql = 'select * from level_up';
				$out_level_up = mysql_query ( $level_up_sql );
				if ($member_list ['hero_level'] <= $level_list ['hero_level']) {
					// ####################################################################################################################################################
					$out_level_up_count = @mysql_num_rows ( $out_level_up );
					if (strcmp ( $out_level_up_count, '0' )) {
						
						while ( $level_up_list = @mysql_fetch_assoc ( $out_level_up ) ) {
							if (! strcmp ( $member_list ['hero_level'], $level_up_list ['hero_level'] )) {
								$check_point_sql = 'select * from point where hero_table=\'' . $level_up_list ['hero_table'] . '\' and hero_type=\'' . $level_up_list ['hero_type'] . '\' and hero_code=\'' . $temp_code . '\';';
								$out_check_point_sql = mysql_query ( $check_point_sql );
								$out_check_point_count = @mysql_num_rows ( $out_check_point_sql );
								if ($level_up_list ['hero_number'] <= $out_check_point_count) {
									$level_up_ok = $level_up_ok + '0';
								} else {
									$level_up_ok = $level_up_ok + '1';
								}
							} else {
								$level_up_ok = '0';
							}
						}
					} else {
						$level_up_ok = '0';
					}
					// ####################################################################################################################################################
					
					if (! strcmp ( $level_up_ok, '0' )) {
						$sql_one_write = 'hero_old_idx, hero_code, hero_table, hero_type, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today';
						$sql_two_write = '\'' . $_GET ['idx'] . '\', \'' . $temp_code . '\', \'' . $_GET ['board'] . '\', \'' . $_GET ['view'] . '\', \'' . $temp_id . '\', \'' . $temp_top_title . '\', \'' . $temp_title . '\', \'' . $_SESSION ['temp_name'] . '\', \'' . $_SESSION ['temp_nick'] . '\', \'' . $temp_point . '\', \'' . Ymdhis . '\'';
						$sql = 'INSERT INTO point (' . $sql_one_write . ') VALUES (' . $sql_two_write . ');';
						mysql_query ( $sql );
						if (! strcmp ( $_SESSION ['temp_drop'], '' )) {
							$user_level_up = $level_list ['hero_level'];
							$user_write_up = $level_list ['hero_level'];
							$user_view_up = $level_list ['hero_level'];
							$user_update_up = $level_list ['hero_level'];
							$user_rev_up = $level_list ['hero_level'];
						} else {
							$user_level_up = $level_list ['hero_level'];
							$user_write_up = $my_write;
							$user_view_up = $my_view;
							$user_update_up = $my_update;
							$user_rev_up = $my_rev;
						}
						$temp_level_sql = 'select * from level where hero_level=\'' . $user_level_up . '\'';
						$out_temp_level = mysql_query ( $temp_level_sql );
						$temp_level_list = @mysql_fetch_assoc ( $out_temp_level );
						// $msg = '축하 합니다. 레벨 상승하셨습니다.\n 현재 등급은 : ['.$temp_level_list['hero_name'].']';
						if ($level_list ['hero_level'] > $member_list ['hero_level']) {
							$msg = '축하 합니다. 레벨 상승하셨습니다.';
							$sql = 'UPDATE member SET hero_level=\'' . $user_level_up . '\', hero_write=\'' . $user_write_up . '\', hero_view=\'' . $user_view_up . '\', hero_update=\'' . $user_update_up . '\', hero_rev=\'' . $user_rev_up . '\', hero_point=\'' . $total . '\' WHERE hero_code = \'' . $_SESSION ['temp_code'] . '\';' . PHP_EOL;
							mysql_query ( $sql );
							// msg($msg,'');
						} else {
							$sql = 'UPDATE member SET hero_point=\'' . $total . '\' WHERE hero_code = \'' . $_SESSION ['temp_code'] . '\';' . PHP_EOL;
							mysql_query ( $sql );
						}
						$_SESSION ['temp_level'] = $user_level_up;
						$_SESSION ['temp_write'] = $user_write_up;
						$_SESSION ['temp_view'] = $user_view_up;
						$_SESSION ['temp_update'] = $user_update_up;
						$_SESSION ['temp_rev'] = $user_rev_up;
					} else {
						$sql_one_write = 'hero_old_idx, hero_code, hero_table, hero_type, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today';
						$sql_two_write = '\'' . $_GET ['idx'] . '\', \'' . $temp_code . '\', \'' . $_GET ['board'] . '\', \'' . $_GET ['view'] . '\', \'' . $temp_id . '\', \'' . $temp_top_title . '\', \'' . $temp_title . '\', \'' . $_SESSION ['temp_name'] . '\', \'' . $_SESSION ['temp_nick'] . '\', \'' . $temp_point . '\', \'' . Ymdhis . '\'';
						$sql = 'INSERT INTO point (' . $sql_one_write . ') VALUES (' . $sql_two_write . ');';
						mysql_query ( $sql );
						$sql = 'UPDATE member SET hero_point=\'' . $total . '\' WHERE hero_code = \'' . $_SESSION ['temp_code'] . '\';' . PHP_EOL;
						mysql_query ( $sql );
					}
				} else {
					$sql_one_write = 'hero_old_idx, hero_code, hero_table, hero_type, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today';
					$sql_two_write = '\'' . $_GET ['idx'] . '\', \'' . $temp_code . '\', \'' . $_GET ['board'] . '\', \'' . $_GET ['view'] . '\', \'' . $temp_id . '\', \'' . $temp_top_title . '\', \'' . $temp_title . '\', \'' . $_SESSION ['temp_name'] . '\', \'' . $_SESSION ['temp_nick'] . '\', \'' . $temp_point . '\', \'' . Ymdhis . '\'';
					$sql = 'INSERT INTO point (' . $sql_one_write . ') VALUES (' . $sql_two_write . ');';
					mysql_query ( $sql );
					$sql = 'UPDATE member SET hero_point=\'' . $total . '\' WHERE hero_code = \'' . $_SESSION ['temp_code'] . '\';' . PHP_EOL;
					mysql_query ( $sql );
				}
			} else {
				$sql_one_write = 'hero_old_idx, hero_code, hero_table, hero_type, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today';
				$sql_two_write = '\'' . $_GET ['idx'] . '\', \'' . $temp_code . '\', \'' . $_GET ['board'] . '\', \'' . $_GET ['view'] . '\', \'' . $temp_id . '\', \'' . $temp_top_title . '\', \'' . $temp_title . '(당일 포인트 초과)\', \'' . $_SESSION ['temp_name'] . '\', \'' . $_SESSION ['temp_nick'] . '\', \'0\', \'' . Ymdhis . '\'';
			}
		}
	}
}

// ####################################################################################################################################################


							$yoil = array('일','월','화','수','목','금','토');

							$startD = $out_row['hero_today_01_01'];
							$endD = $out_row['hero_today_01_02'];
							$startD = $yoil[date('w', strtotime($startD))];
							$endD = $yoil[date('w', strtotime($endD))];

							$releaseSD = $out_row['hero_today_02_01'];
							$releaseSD = $yoil[date('w', strtotime($releaseSD))];

							$reviewSD = $out_row['hero_today_03_01'];
							$reviewED = $out_row['hero_today_03_02'];
							$reviewSD = $yoil[date('w', strtotime($reviewSD))];
							$reviewED = $yoil[date('w', strtotime($reviewED))];
							
							
							$check_day = date ( "Y-m-d", time () );
							$today_01_01 = date ( "Y-m-d", strtotime ( $out_row ['hero_today_01_01'] ) );
							$today_01_02 = date ( "Y-m-d", strtotime ( $out_row ['hero_today_01_02'] ) );
							
							$today_02_01 = date ( "Y-m-d", strtotime ( $out_row ['hero_today_02_01'] ) );
							$today_02_02 = date ( "Y-m-d", strtotime ( $out_row ['hero_today_02_02'] ) );
							
							$today_03_01 = date ( "Y-m-d", strtotime ( $out_row ['hero_today_03_01'] ) );
							$today_03_02 = date ( "Y-m-d", strtotime ( $out_row ['hero_today_03_02'] ) );
							
							$today_04_01 = date ( "Y-m-d", strtotime ( $out_row ['hero_today_04_01'] ) );
							$today_04_02 = date ( "Y-m-d", strtotime ( $out_row ['hero_today_04_02'] ) );
							
							echo $review_menu;
							if (($today_01_01 <= $check_day) and ($today_01_02 >= $check_day)) {
								$review_menu = '리뷰어 신청 : ';
								$one_day = $out_row ['hero_today_01_01'];
								$two_day = $out_row ['hero_today_01_02'];
								$setup_type = '1';
							} else if (($today_02_01 <= $check_day) and ($today_02_02 >= $check_day)) {
								$review_menu = '리뷰어 발표 : ';
								$one_day = $out_row ['hero_today_02_01'];
								$two_day = $out_row ['hero_today_02_02'];
								$setup_type = '2';
							} else if (($today_03_01 <= $check_day) and ($today_03_02 >= $check_day)) {
								$review_menu = '리뷰 등록 : ';
								$one_day = $out_row ['hero_today_03_01'];
								$two_day = $out_row ['hero_today_03_02'];
								$setup_type = '3';
							} else if (($today_04_01 <= $check_day) and ($today_04_02 >= $check_day)) {
								$review_menu = '베스트 발표 : ';
								$one_day = $out_row ['hero_today_04_01'];
								$two_day = $out_row ['hero_today_04_02'];
								$setup_type = '4';
							} else {
								$review_menu = '참여 기간 : ';
								$one_day = $out_row ['hero_today_01_01'];
								$two_day = $out_row ['hero_today_04_02'];
								$setup_type = '5';
							}

						
if ($right_list ['hero_write'] <= $my_write) {
	?>
    <div class="button_area">
		<dl>
			<dt style="width: 100%; text-align: center">
				<a
					href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&page=<?=$_GET['page']?>&view=step_write&action=update&idx=<?=$_GET['idx']?>"><span style='margin: 10px'
					class="bg1">수정</span></a> <a
					href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&view=action4&action=delete&idx=<?=$_GET['idx'];?>&page=<?=$_GET['page'];?>"><span style='margin: 10px'
					class="bg1">삭제</span></a>
			</dt>
		</dl>
		<dl>
			<dt style="width: 100%; text-align: center">
				<a
					href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_02&idx=<?=$out_row['hero_idx']?>"><span
					class="bg1" style='margin: 10px'>미션 신청 확인</span></a> <a
					href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_05&idx=<?=$_GET['idx']?>"><span
					class="bg1" style='margin: 10px'>후기 등록 확인</span></a>
			</dt>
		</dl>
		<div class="clearfix"></div>
	</div>
<?}?>

<!-- 목록버튼 -->
	<div style="text-align: right;">
		<a href="<?=$_SERVER['PHP_SELF']."?board=".$_GET['board']."&page=".$_GET['page']?>">
			<img src="../image/bbs/btn_list.gif" alt="<?=$_GET['board']?>">
		</a>
	</div>

	<div id="content_wrap">

		<?php if($_GET['board']!='group_04_07'){?>
	
			<div class="spm_txt">
				<dl>
					<dt id='spm_top' style=""><?=$out_row['hero_title']?></dt>
				</dl>
				<dl>
					<dt id='spm_top_02' style=""><?=$out_row['hero_title_02']?></dt>
				</dl>
				<div class="clearfix"></div>
			</div>
		
			<div id="content_image">
		
				<?
					if($out_row['hero_thumb'])		$img_new = $out_row['hero_thumb'];
					else							$img_new = $out_row['hero_img_new'];
				?>
					<img src='<?=$img_new?>' width='289px' height='228px'>
			</div>
			
			
			
			<div id="content_top">
				<table>
						
					<tr>
						<td class='cate'>참여 대상</td>
						<td class='cont' height="auto"><?=$out_row['hero_target']?></td>
					</tr>
					<tr>
						<td class='cate'>신청 기간</td>
						<td class='cont' height="auto" style="font-weight:bold;"><?=date('m월 d일',strtotime($out_row['hero_today_01_01'])).'('.$startD.')'.' - '.date('m월 d일',strtotime($out_row['hero_today_01_02'])).'('.$endD.')'?></td>
					</tr>
					<?
						if($out_row['hero_select_count']!=0){
					?>
					<tr>
						<td class='cate'>선정 인원</td>
						<td class='cont' height="auto" style="font-weight:bold;"><?=$out_row['hero_select_count']?> 명</td>
					</tr>
					<?
						}
					?>
					<tr>
						<td class='cate'>당첨자 발표</td>
						<td class='cont' height="auto" style="font-weight:bold;"><?=date('m월 d일',strtotime($out_row['hero_today_02_01'])).'('.$releaseSD.')'?></td>
					</tr>  
					<?php if($out_row['hero_today_02_02']!=$out_row['hero_today_03_02']){ ?>
					<tr>
						<td class='cate'>후기등록기간</td>
						<td class='cont' height="auto" style="font-weight:bold;"><?=date('m월 d일',strtotime($out_row['hero_today_03_01'])).'('.$reviewSD.')'.' - '.date('m월 d일',strtotime($out_row['hero_today_03_02'])).'('.$reviewED.')'?></td>
					</tr>
					<?php }?>
					<?php if($out_row['hero_benefit']){ ?>
					<tr>
						<td class='cate'>혜택</td>
						<td class='cont' height="auto"><?=$out_row['hero_benefit']?></td>
					</tr>
					<?php }?>
					<?
						if($out_row['hero_char']!=''){
					?>
					<tr>
						<td class='cate'>제품 특징</td>
						<td class='cont' height="auto"><?=$out_row['hero_char']?></td>
					</tr>
					<?
						}
					?>
					<?
						if($out_row['hero_required']!=''){
					?>
					<tr >
						<td class='cate'>필수 미션</td>
						<td class='cont' height="auto"><?=$out_row['hero_required']?></td>
					</tr>
					<?
						}
					?>
					
					<?
						if($out_row['hero_tag']!=''){
					?>
					<tr>
						<td class='cate' style='border-bottom:none;'>필수 키워드</td>
						<td class='cont' height="auto"><?=$out_row['hero_tag']?></td>
					</tr>  
					<?
						}
					?>
					<?php 
						if($out_row['hero_superpass']=='Y'){
					?>
					<tr style="border-bottom:none;">
						<td class='cate' style='border-bottom:none;'>슈퍼패스</td>
						<?php //선정인원의 10%를 슈퍼패스 가능인원  -> 10명 미만일 경우 최소 1명으로 설정, 10명 이상일때는 반올림으로 설정?>
						<td class='cont' height="auto"><?=$out_row['superpass']?>명 / <?=countSuperpass($out_row['hero_select_count'])?>명</td>
					</tr>
					<?php 
						//ak 기자단의 경우
						}elseif($_GET['board'] != "group_04_08"){
					?>
					<tr style="border-bottom:none;">
						<td class='cate' style='border-bottom:none;'>슈퍼패스</td>
						<?php //선정인원의 10%를 슈퍼패스 가능인원  -> 10명 미만일 경우 최소 1명으로 설정, 10명 이상일때는 반올림으로 설정?>
						<td class='cont' height="auto">이 미션은 슈퍼패스를 사용하실 수 없습니다.</td>
					</tr>
					<?php 		
						}
					?>
				</table>
			</div>
			<br>
		
			
			<div class="content_detail">
				
					<table>
					
						<tr>
							<td class='cate'>
								미션 안내
							</td>
							<td class='cont'>
								<?=str_replace("\n","<br>",$out_row['hero_guide']);?>
							</td>
						</tr>
				<?
					if($out_row['hero_help']){
				?>
						<tr>
							<td class='cate'>
								미션 가이드
							</td>
							<td class='cont'>
								<?=str_replace("\n","<br>",$out_row['hero_help']);?>
							</td>
						</tr>
				<?
				}
				?>	
					
				
				<?
					if($out_row['hero_banner'] && $_GET['board']!='group_04_08'){
				?>		
						<tr style='border-bottom:none;'>
							<td class='cate'>배너를 달아주세요</td>
							<td class='cont' style='padding-bottom: 11px;'>
								<img src="/image2/banner/ak_lover_banner.png">
								<p style="width: 470px;height: 63px;word-break: break-all;"><?=htmlspecialchars(trim($out_row['hero_banner']))?></p>
							</td>
						</tr>
				<?
				}
				?>
					</table>
				
				<div class="clearfix"></div>
			</div>
			<?php 
				$command = htmlspecialchars_decode($out_row['hero_command']);
				$command = str_replace("&#160;","",$command);
			?>
			<div class="spm_img"><?=$command;?></div>


			
			<?php }else{?>
			
				<?php 
				$command = htmlspecialchars_decode($out_row['hero_command']);
				$command = str_replace("&#160;","",$command);
				?>
				<div class="spm_img" style="padding:0;"><?=$command;?></div>
			
			<?php }?>
			
			
			<div class="button_area">
				<?
				$sql = "select * from mission_review where hero_table = '" . $_GET ['board'] . "' and hero_code='" . $_SESSION ['temp_code'] . "' and hero_old_idx='" . $_GET ['idx'] . "'";
				//echo "<script>console.log('".$sql."');</script>";
				$view_sql = mysql_query ( $sql );
				$data_count = mysql_num_rows ( $view_sql );
				
				//ak 기자단이 아닐 경우
				if($_GET['board']!='group_04_08' && $_GET['board']!='group_04_06')		$img_name = "mission_participate.jpg";
				else																	$img_name = "mission_certificate.jpg";
				
				if(!strcmp($setup_type, '1')){
					if(!strcmp($data_count,'0')){
						?>
            				<a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_01&idx=<?=$out_row['hero_idx']?>">
            					<img src="/image2/etc/<?=$img_name?>" alt="미션참여하기" style='margin: 20px 0 40px 0;'/>
            				</a>
						<?
					}else{
					?>

						<dl>
							<dt style="width: 100%; text-align: center">
								<? if(strcmp($_SESSION['temp_id'], '')){ ?>
									<a	href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_02&idx=<?=$out_row['hero_idx']?>">
										<img src="/image2/etc/missionBtn02.jpg" alt="신청자 확인" style="cursor: pointer;margin: 20px 0 40px 0;"/>
									</a>
								<? }else{ ?>
                
									<img src="/image2/etc/<?=$img_name?>" alt="미션참여하기" style="cursor: pointer;margin: 20px 0 40px 0;" onclick="Javascript:alert('로그인을 하셔야 참여가능합니다');window.location.href='/main/index.php?board=login';" />
								<? } ?>
            
						
							</dt>
						</dl>
						<div class="clearfix"></div>

				<?
					}
				}elseif (! strcmp ( $setup_type, '2' )) {
				?>

					<dl>
						<dt style="width: 100%; text-align: center">
							<a	href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_03&idx=<?=$out_row['hero_idx']?>">
								<img src="/image2/etc/missionBtn03.jpg" alt="당첨자 확인" style="cursor: pointer;margin: 20px 0 40px 0;"/>
							</a> 
							<a	href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_02&idx=<?=$out_row['hero_idx']?>">
								<img src="/image2/etc/missionBtn02.jpg" alt="신청자 확인" style="cursor: pointer;margin: 20px 0 40px 0;"/>
							</a>
						</dt>
					</dl>
					<div class="clearfix"></div>

				<?
				} else if (! strcmp ( $setup_type, '3' )) {
					$sql = 'select * from mission_review where hero_table = \'' . $_GET ['board'] . '\' and lot_01=\'1\' and hero_code=\'' . $_SESSION ['temp_code'] . '\' and hero_old_idx=\'' . $_GET ['idx'] . '\'';
					$view_sql = @mysql_query ( $sql );
					$data_count = @mysql_num_rows ( $view_sql );
				?>

					
					<div style="width: 100%; text-align: center">
						<?
							if (! strcmp ( $data_count, '0' )) {
						?>
		                		<a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_05&page=1&idx=<?=$_GET['idx']?>">
									<img src="/image2/etc/reviewbtn02.jpg" alt="후기 확인하기" style="cursor: pointer;margin: 20px 0 40px 0;"/>
								</a>
						<?
							} else {
								$new_sql = 'select * from board where hero_table = \'' . $_GET ['board'] . '\' and hero_code=\'' . $_SESSION ['temp_code'] . '\' and hero_01=\'' . $_GET ['idx'] . '\'';
								$view_new_sql = mysql_query ( $new_sql );
								$new_count = mysql_num_rows ( $view_new_sql );
								if (! strcmp ( $new_count, '0' )) {
						?>
		                			<a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=write2&action=write&page=1&idx=<?=$_GET['idx']?>">
		                				<img src="/image2/etc/reviewbtn01.jpg" alt="후기 등록하기" style="cursor: pointer;margin: 20px 0 40px 0;"/>
									</a>
						<?
								} else {
						?>
		                			<a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_05&page=1&idx=<?=$_GET['idx']?>">
		                				<img src="/image2/etc/reviewbtn02.jpg" alt="후기 확인하기" style="cursor: pointer;margin: 20px 0 40px 0;"/>
									</a>
						<?
								}
							}
						?>
            
					</div>
					<div class="clearfix"></div>

				<?
				} else if (! strcmp ( $setup_type, '4' )) {
				?>
					
					<div style="width: 100%; text-align: center">
						<a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_05&action=write&page=1&idx=<?=$_GET['idx']?>">
							<img src="/image2/etc/missionBtn01.jpg" alt="발표 확인" style="cursor: pointer;margin: 20px 0 40px 0;"/>
						</a>
					</div>
					
					<div class="clearfix"></div>

				<?
				} else if (! strcmp ( $setup_type, '5' )) {
				?>
					
					<div style="width: 100%; text-align: center">
						<a
							href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_05&action=write&page=1&idx=<?=$_GET['idx']?>"><img src="/image2/etc/missionBtn01.jpg" alt="발표 확인" style="cursor: pointer;margin: 20px 0 40px 0;"/>
						</a>
					</div>
					
					<div class="clearfix"></div>

				<?
				}
				?>

			
			</div><!-- content_wrap -->
		</div>
</div>
<?

// 2014.05.14 로그인시 미션볼수 있게 하는 기능 제거
// }
// else{
// if(!strcmp($my_level, '0')){
// $msg = '권한이';
// $action_href = PATH_HOME.'?board=login';
// }else{
// $msg = '권한이';
// $action_href = PATH_HOME.'?'.get('view');
// }
// msg($msg.' 없습니다.','location.href="'.$action_href.'"');
// exit;
// }
?>