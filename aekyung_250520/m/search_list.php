<?php
include_once "head.php";

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
//    echo $sql_list;
    sql($sql_list);
} else {
    $sql_list = "";
    sql($sql_list);
}


?>
<link href="/m/css/musign/board.css" rel="stylesheet" type="text/css">
<link href="/m/css/musign/cscenter.css" rel="stylesheet" type="text/css">
<div id="subpage" class="search_view">
<div class="sub_wrap">
    <div class="left">
        <? include_once 'searchBox.php';?>
    </div>
</div>
<div id="gallery">
    <p class="result_txt">총 검색 <strong><?=number_format($totalCount);?>건</strong> 검색되었습니다.</p>
    <div class="boardTabMenuWrap">
        <span class="missionStatusSearch <?=$tab=="1"?"active":"";?>" rel="tab01">체험단/이벤트(<?=number_format($missonCount);?>)</span>
        <span class="missionStatusSearch <?=$tab=="2"?"active":"";?>" rel="tab02">공지/커뮤니티(<?=number_format($boardCount);?>)</span>
        <span class="missionStatusSearch <?=$tab=="3"?"active":"";?>" rel="tab04">후기/활동(<?=number_format($postCount);?>)</span>
        <span class="missionStatusSearch <?=$tab=="4"?"active":"";?>" rel="tab03">댓글(<?=number_format($replyCount);?>)</span>
    </div>
    <!-- 리스트 s -->
    <div id="today_list">       
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
            <div class="tabbtn">
                <a href="<?=$link;?>" target="<?=$target?>">
                    <div class="title_left">
                        <ul>
                            <li class="tabbtn_title">
                                <span><?=$num;?></span>
                                <div class="fz28 fw500 ellipsis_100">
								    <b class="main_c">[<?=$info_list['hero_title']?>]</b> <?=cut($list['hero_title'], $cut_title_name);?>
                                </div>		
                            </li>
                            <li class="tabbtn_top f_cs op05">
							<?=$pk_row['hero_nick'];?>
							<span class="date mu_bar"><?=date( "Y.m.d", strtotime($list['hero_today']));?></span>
						</li>
                        </ul>
                    </div>
                </a>
            </div>
        <?}?>
        <? if($i==0) {?>
            <div class="no_result">검색된 데이터가 없습니다</div>
        <? } ?>
    </div>
</div>
<div id="page_number" class="paging">
    <?include_once "page.php"?>
</div>
<!-- gallery 종료 -->
<!--컨텐츠 종료-->
<script>
    $(document).ready(function(){
        <!--[개발요청] 카테고리 클릭 이벤트 부탁드립니다!-->
        $(".activityTab li").on("click",function(){
            var k = $(".activityTab li").index(this)+1;
            location.href = "/m/search_list.php??board=<?=$_GET["board"]?>&select=<?=$sql_select?>&kewyword=<?=$_REQUEST["kewyword"]?>&tab="+k;
        })
    })
</script>
<?include_once "tail.php";?>