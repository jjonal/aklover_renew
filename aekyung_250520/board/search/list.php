<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$cut_count_name = '6';
$cut_title_name = '34';
######################################################################################################################################################
$sql_review_select = "";

$tab = $_REQUEST['tab'];
if(!$tab) $tab = 1;

if(strcmp($_REQUEST['kewyword'], '')){
    //필터 제목, 작성자 구분
    if(!strcmp($_REQUEST['select'], '')){
        $sql_select = 'hero_title';
        $sql_review_select = "hero_command";
    }else{
        $sql_select = $_REQUEST['select'];
        if($sql_select == "hero_title") $sql_review_select = "r.hero_command";
        if($sql_select == "hero_nick") $sql_review_select = "m.hero_nick";
    }
    
    //검색내용
    $search = ' and '.$sql_select.' like \'%'.$_REQUEST['kewyword'].'%\'';
    $sql_review_select = ' and '.$sql_review_select.' like \'%'.$_REQUEST['kewyword'].'%\'';
    $search_next = '&select='.$sql_select.'&kewyword='.stripslashes($_REQUEST['kewyword'])."&tab=".$tab;

	$mission_code   = "'group_04_05','group_02_03'";  //체험단/이벤트 -> 체험단, 게릴라이벤트
	$board_code     = "'group_04_03','group_02_02' "; //공지/커뮤니티 -> 공지사항, 수다통
	$post_code 		= "'group_04_09','group_04_10','group_04_22'"; //후기/활동 -> 체험후기, 우수후기, 모임후기
	$reply_code 	= "'group_04_03','group_02_02','group_04_05','group_02_03','group_04_09','group_04_10','group_04_22' "; //댓글 -> 공지/커뮤니티, 수다통, 체험단/이벤트, 게릴라이벤트, 체허무기, 우수후기, 모임후기

	if($_SESSION["temp_level"] > 0) {
		$board_code .= ",'group_04_24'"; //배움통
		$reply_code .= ",'group_04_24'";
	}

    // level 9999 운영자
    // level 10000 관리자
	if($_SESSION["temp_level"] >= 9999 || $_SESSION["temp_level"] == 9995) { // level 9995 Beauty Club 영상팀
		$mission_code .= ",'group_04_27'"; //Beauty/Life Club 영상팀 인데 사용X
		$reply_code .= ",'group_04_27'";
	}

	if($_SESSION["temp_level"] >= 9999 || $_SESSION["temp_level"] == 9996) { // level 9996 뷰티클럽
		$mission_code .= ",'group_04_06'"; //체험단/이벤트
		$reply_code .= ",'group_04_06'";
	}

	$totalCount = 0; //총 건수
	$total_data = 0; //탭별 카운트

    //체험단/이벤트
	$sql_mission = " SELECT count(*) as cnt FROM (SELECT hero_idx FROM mission WHERE hero_use=1 AND hero_table in ($mission_code) ".$search;
	$sql_mission .= " union all SELECT hero_idx FROM board WHERE hero_use=1 AND hero_table in ($mission_code) ".$search. " ) a ";
	sql($sql_mission);
	$row = mysql_fetch_assoc($out_sql);
	$missonCount = $row["cnt"];

	//공지/커뮤니티
	$sql_board = " SELECT count(*) as cnt FROM board WHERE hero_use=1 AND hero_table in ($board_code) ".$search;
	sql($sql_board);
	$row = mysql_fetch_assoc($out_sql);
	$boardCount = $row["cnt"];

	//후기/활동
	$sql_post = " SELECT count(*) as cnt FROM board WHERE hero_use=1 AND hero_table in ($post_code) ".$search;
	sql($sql_post);
	$row = mysql_fetch_assoc($out_sql);
	$postCount = $row["cnt"];

	//댓글
	$sql_reply = " SELECT count(*) as cnt FROM review r inner join  member m ON r.hero_code = m.hero_code WHERE r.hero_table in ($reply_code) ".$sql_review_select;
	sql($sql_reply);
	$row = mysql_fetch_assoc($out_sql);
	$replyCount = $row["cnt"];

    //촘 건수
	$totalCount = $missonCount+$boardCount+$postCount+$replyCount;
	
    //페이지네이션
	$list_page=8;
	$page_per_list=10;
	if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
	$start = ($page-1)*$list_page;
	$next_path="board=".$_GET['board'].$search_next;

    //탭별 건수
	if($tab == "1") {
		$total_data = $missonCount;
		$sql_list = " SELECT * FROM (SELECT hero_title, hero_table, hero_nick, hero_code, hero_idx, hero_today FROM mission WHERE hero_use=1 AND hero_table in ($mission_code) ".$search;
		$sql_list .= " union all SELECT hero_title, hero_table, hero_nick, hero_code, hero_idx, hero_today  FROM board WHERE hero_use=1 AND hero_table in ($mission_code) ".$search." ) a";
	} else if($tab == "2") {
		$total_data = $boardCount;
		$sql_list = " SELECT hero_title, hero_table, hero_nick, hero_code, hero_idx, hero_today  FROM board WHERE hero_use=1 AND hero_table in ($board_code) ".$search;
	} else if($tab == "3") {
		$total_data = $postCount;
		$sql_list = " SELECT hero_title, hero_table, hero_nick, hero_code, hero_idx, hero_today  FROM board WHERE hero_use=1 AND hero_table in ($post_code) ".$search;
	} else if($tab == "4") {
		$total_data = $replyCount;
		$sql_list = " SELECT r.hero_command as hero_title, r.hero_table, r.hero_code, r.hero_old_idx as hero_idx, m.hero_nick, r.hero_today ";
		$sql_list .= " FROM review r INNER JOIN member m ON r.hero_code = m.hero_code WHERE r.hero_table in ($reply_code) ".$sql_review_select;
	}
	
	$sql_list .= " ORDER BY hero_idx DESC limit ".$start.",".$list_page;
//	echo $sql_list;
	sql($sql_list);
}

?>
<div id="subpage" class="search_end">
	<div class="sub_title">
	</div>
	<div class="sub_cont">
		<div class="sub_wrap board_wrap f_sb">
			<div class="left">
				<div class="searchbox mu_searchbox">
					<div class="title fz20 fw600 pc">SEARCH</div>	
					<div class="search_cont rel">
					<form action="<?=PATH_HOME.'?'.get('page');?>" method="POST" >
						<select name="select" id="">
						<option value="hero_title"<?if(!strcmp($_REQUEST['select'], 'hero_title')){echo ' selected';}else{echo '';}?>>제목</option>
						<option value="hero_nick"<?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>작성자</option>
						</select>
						<input name="kewyword" type="text" value="<?echo stripslashes($_REQUEST['kewyword']);?>" class="kewyword wid100" placeholder="검색어를 입력해주세요">
						<input type="submit" class="mu_search_btn screen_out" value="검색" />
					</form>
					</div>
				</div>
			</div>
			<div class="contents right">
				<p style="margin-bottom:4rem; font-size:1.6rem;">총 검색 <strong><?=number_format($totalCount);?>건</strong> 검색되었습니다.</p>
				<div class="introduceTab">
					<ul class="boardTabMenuWrap activityTab">
						<li <?=$tab=="1"?"class='on'":"";?> rel="tab01">체험단/이벤트(<?=number_format($missonCount);?>)</li>
						<li <?=$tab=="2"?"class='on'":"";?> rel="tab02">공지/커뮤니티 (<?=number_format($boardCount);?>)</li>
						<li <?=$tab=="3"?"class='on'":"";?> rel="tab04">후기/활동 (<?=number_format($postCount);?>)</li>
						<li <?=$tab=="4"?"class='on'":"";?> rel="tab03">댓글 (<?=number_format($replyCount);?>)</li>
					</ul>
				</div>
				<table border="0" cellpadding="0" cellspacing="0" class="bbs_list" style="margin-top:10px;">					
					<colgroup>
						<col width="15%" />
						<col width="*" />
						<col width="18%" />
						<col width="18%" />
					</colgroup>
					<thead>
						<tr class="bbshead">
							<th class="first">번호</th>
							<th>제목</th>
							<th>작성자</th>
							<th class="last">날짜</th>
						</tr>
					</thead>
					<tbody>					
					<?
					$i=0;
					while($list                             = @mysql_fetch_assoc($out_sql)){
					$num=$total_data - $start-$i;
						$i++;
                        //게시글 카테고리
						$info_sql = 'select * from hero_group where hero_board=\''.$list['hero_table'].'\';';
						$out_info_sql = mysql_query($info_sql);
						$info_list                             = @mysql_fetch_assoc($out_info_sql);
                        //작성자
						$pk_sql = 'select a.hero_level,a.hero_nick,b.hero_img_new from member as a, level as b  where b.hero_level = a.hero_level and a.hero_code = \''.$list['hero_code'].'\'';
						$out_pk_sql = mysql_query($pk_sql);
						$pk_row                             = @mysql_fetch_assoc($out_pk_sql);
						
						$target = "";
						if($list['hero_table'] == "group_04_09" || $list['hero_table'] == "group_04_10" || $list['hero_table'] == "group_04_22") {
							$link = PATH_HOME."?board=".$list['hero_table']."&view=view2&idx=".$list['hero_idx'];
							$target = "_blank";
						} else {
							$link = PATH_HOME."?board=".$list['hero_table']."&view=view&idx=".$list['hero_idx'];
						}
					?>
					<tr>
						<td><?=$num;?></td>
						<td class="tl">
						<a href="<?=$link;?>" target="<?=$target?>">
							<b class="main_c">[<?=$info_list['hero_title']?>]</b> <?=cut($list['hero_title'], $cut_title_name);?>
						</a>
						</td>
						<td><?=$pk_row['hero_nick'];?></td>
						<td><?=date( "Y.m.d", strtotime($list['hero_today']));?></td>
                    </tr>
					<?}?>
					<? if($i==0) {?>
					<tr>
						<td colspan="4">검색된 데이터가 없습니다.</td>
					</tr>
					<? } ?>						
					</tbody>
				</table>
				<? include_once BOARD_INC_END.'button.php';?>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	$(".activityTab li").on("click",function(){
		var k = $(".activityTab li").index(this)+1;
		location.href = "<?=$MAIN_HOME?>?board=<?=$_GET["board"]?>&select=<?=$sql_select?>&kewyword=<?=stripslashes($_REQUEST["kewyword"])?>&tab="+k;
	})
})
</script>
