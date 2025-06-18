<?
if(!defined('_HEROBOARD_'))exit;

if(is_numeric($_GET['idx']))	$idx = $_GET['idx'];
else							echo "<script>alert('잘못된 접근입니다');location.href='/main/index.php'</script>";
	
$today = date( "Y-m-d", time());
if(strcmp($_SESSION['temp_drop'], '')){ //레벨 체크
	$temp_drop = $_SESSION['temp_drop'];
	if($temp_drop<=$today){
		$sql = 'UPDATE member SET hero_dropday=null, hero_level=\''.$_SESSION['temp_level'].'\', hero_write=\''.$_SESSION['temp_level'].'\', hero_view=\''.$_SESSION['temp_level'].'\', hero_update=\''.$_SESSION['temp_level'].'\', hero_rev=\''.$_SESSION['temp_level'].'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
		@sql($sql, 'on');
		$_SESSION['temp_write']=$_SESSION['temp_level'];
		$_SESSION['temp_view']=$_SESSION['temp_level'];
		$_SESSION['temp_update']=$_SESSION['temp_level'];
		$_SESSION['temp_rev']=$_SESSION['temp_level'];
		unset($_SESSION['temp_drop']);
	}
}

if(!strcmp($_SESSION['temp_level'], '')){ //비로그인시 
    $_SESSION['temp_level'] = '0';
    $_SESSION['temp_write'] = '0';
    $_SESSION['temp_view'] = '0';
    $_SESSION['temp_update'] = '0';
    $_SESSION['temp_rev'] = '0';
}

//접근권한 이달의 로얄 회원만 가능
$loyal_auth = false; //작성권한
$loyal_auth_sql  = " SELECT COUNT(*) cnt FROM member_loyal ";
$loyal_auth_sql .= " WHERE hero_code = '".$_SESSION["temp_code"]."' AND date_format(CONCAT(gisu_year, gisu_month,'01'),'%Y%m%d') < '".date("Ym")."01"."' ";
$loyal_auth_sql .= " AND  date_format(date_add(date_format(CONCAT(gisu_year, gisu_month,'01'),'%Y%m%d'), INTERVAL 7 MONTH),'%Y%m%d') > '".date("Ym")."01"."' ";
$loyal_auth_res = sql($loyal_auth_sql);
$loyal_auth_rs = mysql_fetch_assoc($loyal_auth_res);

if($loyal_auth_rs["cnt"] > 0) $loyal_auth = true; //등록 기수(기간) 6개월까지 게시판 이용 가능

if(!$loyal_auth && $_SESSION['temp_level'] < 9999) {
	msg('Loyal AKLOVER 권한이 없습니다.','location.href="'.PATH_HOME.'?board=group_04_29"');exit;
}

$board_sql = "select A.*, B.hero_view as group_view, B.hero_title as group_title, B.hero_view_point as group_view_point, B.hero_right as group_right, B.hero_top_title as group_top_title ";
$board_sql .= "from board A, hero_group B where A.hero_idx = '".$_REQUEST['idx']."' and B.hero_board='".$_GET['board']."'";
	
$sql_res = mysql_query($board_sql) or die("<script>alert('시스템 에러입니다. 다시 시도해 주세요. 에러코드 : VIEW_01');location.href='/main/index.php'</script>");
$board_list                            = mysql_fetch_assoc($sql_res);
	
if(!strcmp($board_list['hero_table'],'hero'))    	$group_table_name = $board_list['hero_03'];
else    											$group_table_name = $board_list['hero_table'];

if($_SESSION['temp_level'] < 9999 && $board_list["hero_use"] == "0") {
	msg('비공개 게시글 입니다.','location.href="/main/index.php?board=group_02_03"');
	exit;
}

$pk_sql = "select A.hero_level, A.hero_nick, A.hero_idx, B.hero_img_new from member as A, level as B where B.hero_level = A.hero_level and A.hero_code = '".$board_list['hero_code']."'";
$out_pk_sql = mysql_query($pk_sql) or die("<script>alert('시스템 에러입니다. 다시 시도해주세요. 에러코드 : VIEW_02');location.href='/main/index.php'</script>");

$pk_row                             = mysql_fetch_assoc($out_pk_sql);
	

if(strcmp($board_list['hero_table'],'hero')){ //공지사항 페이지를 제외한 모든 view 페이지
	if($board_list['hero_notice_use'] != "1") {
		if($_SESSION['temp_level']<9999)	$hero_use = " AND hero_use=1 "; ##임시글 권한 설정
		$prev_sql = " SELECT  hero_idx, hero_title FROM board where hero_table = '".$group_table_name."' and hero_idx > '".$idx."' AND hero_notice_use != '1' ".$hero_use." ORDER BY hero_idx ASC limit 0,1 ";
    		
		$prev_res = sql($prev_sql);
		$prev_rs = mysql_fetch_assoc($prev_res);
    		
		$next_sql = " SELECT  hero_idx, hero_title FROM board where hero_table = '".$group_table_name."' and hero_idx < '".$idx."' AND hero_notice_use != '1' ".$hero_use." ORDER BY hero_idx DESC limit 0,1 ";
    		
		$next_res = sql($next_sql);
		$next_rs = mysql_fetch_assoc($next_res);
    	
   		$prevNext["prev_idx"] = $prev_rs["hero_idx"];
   		$prevNext["prev_title"] = $prev_rs["hero_title"];
   		
   		$prevNext["next_idx"] = $next_rs["hero_idx"];
   		$prevNext["next_title"] = $next_rs["hero_title"];
	}
}
?>
<div class="contents">
	<table border="0" cellpadding="0" cellspacing="0" class="bbs_view">
		<colgroup>
			<col width="90px" />
			<col width="400px" />
			<col width="100px" />
			<col width="105px" />
		</colgroup>
		<tr class="bbshead print_area">
			<th><img src="../image/bbs/tit_subject.gif" alt="제목" /></th>
			<td>
				<?if(!strcmp ( $board_list ['hero_table'], 'hero' )) {?>
					<img src="../image/bbs/icon_notice.gif" alt="공지" />
				<?}?>
				<?if($board == "group_02_02" && $board_list['hero_notice_use'] == 1){ //수다통?>
					<img src="../image/bbs/icon_notice.gif" alt="공지" />
				<?}?>
				<? if($board == "group_04_24" && $board_list['hero_keywords']){?>
					<span class="txt_hero_keywords">[<?=$hero_keywords_arr[$board_list['hero_keywords']]?>]</span>
				<? } ?>
				<?=cut($board_list['hero_title'],48);?>
			</td>
			<td colspan="2" style="text-align: right;">
			<?				
				$snsURL = "https://".$_SERVER["HTTP_HOST"]."/main/index.php?board=".$_REQUEST["board"]."&view=view&idx=".$_REQUEST["idx"];
				$snsTitle = $board_list['hero_title'];
			?>
			<a href="javascript:sns('facebook','<?=$snsTitle?>','<?=$snsURL?>');"><img src="../image/ico_fc.jpg" alt="페이스북공유"></a> 
			<a href="javascript:sns('twitter','<?=$snsTitle?>','<?=$snsURL?>');"><img src="../image/ico_tw.jpg" alt="트위터공유"></a> 
			<script>
				function sns(snsType,snsTitle, snsURL) {
					var snsArray = new Array();
						snsArray['twitter'] = "http://twitter.com/intent/tweet?text=" + encodeURIComponent(snsTitle) + '&url=' + encodeURIComponent(snsURL);
						snsArray['facebook'] = "http://www.facebook.com/share.php?u=" + encodeURIComponent(snsURL);							
						window.open(snsArray[snsType]);
				}
			</script>
			</td>
		</tr>
		<? if($board=="group_02_02" || $board=="group_04_24"){?>
		<tr class="print_area">
			<th><img src="../image/bbs/txt_category.gif" alt="카테고리" /></th>
			<td colspan="3" class="color_<?=$board_list['gubun'];?>"><?=$gubun_arr[$board_list['gubun']]?></td>
		</tr>
		<? } ?>
		<tr class="print_area">
			<th><img src="../image/bbs/tit_writer_2.gif" alt="작성자" /></th>
			<td><?=info_mem( $pk_row ['hero_nick'], $pk_row ['hero_idx'], $pk_row ['hero_img_new'])?></td>
			<th><img src="../image/bbs/tit_date.gif" alt="날짜" /></th>
			<td><?=date( "y-m-d H:i", strtotime($board_list['hero_today']));?></td>
		</tr>
		<tr class="print_area">
		<?
			$temp_command = htmlspecialchars_decode ( $board_list ['hero_command'] );
			$next_command = str_ireplace ( '<img', '<img onerror="this.src=\'' . IMAGE_END . 'hero.jpg\';" ', $temp_command );
			$temp_hero_04 = href ( nl2br ( $board_list ['hero_04'] ) );
			$temp_hero_04 = str_ireplace ( '<A', '<A target="_blank"', $temp_hero_04 );
		?>
		    <td colspan="4" valign="top" width="705px" class="bbs_view" style="padding: 25px; line-height: normal; word-break: break-all; color:#000;">
		    	<?=$next_command;?>
				<div style="padding: 30px; text-align: center;"><?=$temp_hero_04;?></div>
			</td>
		</tr>
		<!--170627 추천 신고 버튼 삭제
       	<?	if(strcmp ( $_SESSION ['temp_code'], '' )) {
				if($recommand_count == 0 || $report_count == 0) {
		?>

				<tr>
					<td colspan="4" style="padding:35px;text-align:center;">
		        	  	<?php
							if ($recommand_count == 0) {
						?>
		                <a onclick="confirm_writing('recommand','<?=PATH_HOME.'?'.get('type','type=recommand');?>')">
		                	<img src="/image2/etc/like.jpg" alt="추천">
		                </a>
		                &nbsp;&nbsp;
		                <?php
							}
																				
							if ($report_count == 0) {
						?>
		                &nbsp;&nbsp;
		                <a onclick="confirm_writing('report','<?=PATH_HOME.'?'.get('type','type=report');?>')">
		               		<img src="/image2/etc/btn_report.jpg" alt="신고">
		               	</a>
		                <?php
							}
						?>
		      		</td>
				</tr>

				<?
					}
				}
				?>
				-->
		<?if((! strcmp ( $_REQUEST ['board'], 'group_04_05' )) or (! strcmp ( $_REQUEST ['board'], 'group_04_06' )) or (! strcmp ( $_REQUEST ['board'], 'group_04_07' )) or (! strcmp ( $_REQUEST ['board'], 'group_04_08' )) or (! strcmp ( $_REQUEST ['board'], 'group_04_09' )) or (! strcmp ( $_REQUEST ['board'], 'group_04_27' )) or (! strcmp ( $_REQUEST ['board'], 'group_04_28' )) ) {?>
		<tr>
			<th><img src="../image/bbs/tit_url.gif" style="vertical-align: middle;"></th>
			<td colspan="3" style="padding: 10px;"><?=$temp_hero_04;?></td>
		</tr>
		<?}?>
		<?if(strcmp($board_list['hero_board_two'], '')){
			if($idx == '136705'){  // 160315 수정함 특정 게시물 파일 로그인 회원만 다운로드 되게 하려고
				if(strcmp($_SESSION['temp_code'], '')){ ?>
				<tr>
					<th><center>파일</center></th>
					<td colspan="3"><a href="http://aklover.co.kr/user/file/16day.zip">16day.zip</td>
				</tr>   
				<?} 
			}else{
			?>
            <tr>
				<th><center>파일</center></th>
				<td colspan="3"><a href="http://aklover.co.kr/freebest/download.php?hero=<?=$board_list['hero_board_one']?>&download=<?=$board_list['hero_board_two']?>"><?=$board_list['hero_board_two'];?></td>
			</tr>
			<?
			}// end else
		 }
		 if(strcmp ($prevNext ['prev_idx'],'')) { ?>
		 <tr>
		 	<th><img src="../image/bbs/tit_prev.gif" alt="이전글" /></th>
			<td colspan="3">
				<a href="<?=PATH_HOME;?>?board=<?=$_GET['board'];?>&page=<?=$_GET['page'];?>&view=view&idx=<?=$prevNext['prev_idx'];?>"><?=cut($prevNext['prev_title'],26);?></a>
			</td>
		 </tr>
		 <?}
		 if(strcmp ($prevNext ['next_idx'],'')) {?>
		<tr class="last">
			<th><img src="../image/bbs/tit_next.gif" alt="다음글" /></th>
			<td colspan="3">
				<a href="<?=PATH_HOME;?>?board=<?=$_GET['board'];?>&page=<?=$_GET['page'];?>&view=view&idx=<?=$prevNext['next_idx'];?>"><?=cut($prevNext['next_title'],26);?></a>
			</td>
		</tr>
		<?}?>
	</table>
	<?
	include_once BOARD_INC_END . 'button3.php';
	
	$check_review_sql = 'select * from hero_group where hero_board=\'' . $_GET ['board'] . '\';';
	$out_check_review_sql = mysql_query ( $check_review_sql );
	$check_review_list = @mysql_fetch_assoc ( $out_check_review_sql );
	$check_review_list ['hero_rev'];
	
	include_once BOARD_INC_END . 'review2.php';
	?>
</div>
</div>