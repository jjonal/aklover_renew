<?php
include_once "head.php";

$cut_count_name = '6';
$cut_title_name = '34';
######################################################################################################################################################
$sql_review_select = "";

$tab = $_REQUEST['tab'];
if(!$tab) $tab = 1;

if(strcmp($_REQUEST['kewyword'], '')){
    //���� ����, �ۼ��� ����
    if(!strcmp($_REQUEST['select'], '')){
        $sql_select = 'hero_title';
        $sql_review_select = "hero_command";
    }else{
        $sql_select = $_REQUEST['select'];
        if($sql_select == "hero_title") $sql_review_select = "r.hero_command";
        if($sql_select == "hero_nick") $sql_review_select = "m.hero_nick";
    }

    //�˻�����
    $search = ' and '.$sql_select.' like \'%'.$_REQUEST['kewyword'].'%\'';
    $sql_review_select = ' and '.$sql_review_select.' like \'%'.$_REQUEST['kewyword'].'%\'';
    $search_next = '&select='.$sql_select.'&kewyword='.stripslashes($_REQUEST['kewyword'])."&tab=".$tab;

    $mission_code   = "'group_04_05','group_02_03'";  //ü���/�̺�Ʈ -> ü���, �Ը����̺�Ʈ
    $board_code     = "'group_04_03','group_02_02' "; //����/Ŀ�´�Ƽ -> ��������, ������
    $post_code 		= "'group_04_09','group_04_10','group_04_22'"; //�ı�/Ȱ�� -> ü���ı�, ����ı�, �����ı�
    $reply_code 	= "'group_04_03','group_02_02','group_04_05','group_02_03','group_04_09','group_04_10','group_04_22' "; //��� -> ����/Ŀ�´�Ƽ, ������, ü���/�̺�Ʈ, �Ը����̺�Ʈ, ü�㹫��, ����ı�, �����ı�

    if($_SESSION["temp_level"] > 0) {
        $board_code .= ",'group_04_24'"; //�����
        $reply_code .= ",'group_04_24'";
    }

    // level 9999 ���
    // level 10000 ������
    if($_SESSION["temp_level"] >= 9999 || $_SESSION["temp_level"] == 9995) { // level 9995 Beauty Club ������
        $mission_code .= ",'group_04_27'"; //Beauty/Life Club ������ �ε� ���X
        $reply_code .= ",'group_04_27'";
    }

    if($_SESSION["temp_level"] >= 9999 || $_SESSION["temp_level"] == 9996) { // level 9996 ��ƼŬ��
        $mission_code .= ",'group_04_06'"; //ü���/�̺�Ʈ
        $reply_code .= ",'group_04_06'";
    }

    $totalCount = 0; //�� �Ǽ�
    $total_data = 0; //�Ǻ� ī��Ʈ

    //ü���/�̺�Ʈ
    $sql_mission = " SELECT count(*) as cnt FROM (SELECT hero_idx FROM mission WHERE hero_use=1 AND hero_table in ($mission_code) ".$search;
    $sql_mission .= " union all SELECT hero_idx FROM board WHERE hero_use=1 AND hero_table in ($mission_code) ".$search. " ) a ";
    sql($sql_mission);
    $row = mysql_fetch_assoc($out_sql);
    $missonCount = $row["cnt"];

    //����/Ŀ�´�Ƽ
    $sql_board = " SELECT count(*) as cnt FROM board WHERE hero_use=1 AND hero_table in ($board_code) ".$search;
    sql($sql_board);
    $row = mysql_fetch_assoc($out_sql);
    $boardCount = $row["cnt"];

    //�ı�/Ȱ��
    $sql_post = " SELECT count(*) as cnt FROM board WHERE hero_use=1 AND hero_table in ($post_code) ".$search;
    sql($sql_post);
    $row = mysql_fetch_assoc($out_sql);
    $postCount = $row["cnt"];

    //���
    $sql_reply = " SELECT count(*) as cnt FROM review r inner join  member m ON r.hero_code = m.hero_code WHERE r.hero_table in ($reply_code) ".$sql_review_select;
    sql($sql_reply);
    $row = mysql_fetch_assoc($out_sql);
    $replyCount = $row["cnt"];

    //�� �Ǽ�
    $totalCount = $missonCount+$boardCount+$postCount+$replyCount;

    //���������̼�
    $list_page=8;
    $page_per_list=10;
    if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
    $start = ($page-1)*$list_page;
    $next_path="board=".$_GET['board'].$search_next;

    //�Ǻ� �Ǽ�
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
    <p class="result_txt">�� �˻� <strong><?=number_format($totalCount);?>��</strong> �˻��Ǿ����ϴ�.</p>
    <div class="boardTabMenuWrap">
        <span class="missionStatusSearch <?=$tab=="1"?"active":"";?>" rel="tab01">ü���/�̺�Ʈ(<?=number_format($missonCount);?>)</span>
        <span class="missionStatusSearch <?=$tab=="2"?"active":"";?>" rel="tab02">����/Ŀ�´�Ƽ(<?=number_format($boardCount);?>)</span>
        <span class="missionStatusSearch <?=$tab=="3"?"active":"";?>" rel="tab04">�ı�/Ȱ��(<?=number_format($postCount);?>)</span>
        <span class="missionStatusSearch <?=$tab=="4"?"active":"";?>" rel="tab03">���(<?=number_format($replyCount);?>)</span>
    </div>
    <!-- ����Ʈ s -->
    <div id="today_list">       
        <?
        $i=0;
        while($list                             = @mysql_fetch_assoc($out_sql)){
            $num=$total_data - $start-$i;
            $i++;
            //�Խñ� ī�װ�
            $info_sql = 'select * from hero_group where hero_board=\''.$list['hero_table'].'\';';
            $out_info_sql = mysql_query($info_sql);
            $info_list                             = @mysql_fetch_assoc($out_info_sql);
            //�ۼ���
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
            <div class="no_result">�˻��� �����Ͱ� �����ϴ�</div>
        <? } ?>
    </div>
</div>
<div id="page_number" class="paging">
    <?include_once "page.php"?>
</div>
<!-- gallery ���� -->
<!--������ ����-->
<script>
    $(document).ready(function(){
        <!--[���߿�û] ī�װ� Ŭ�� �̺�Ʈ ��Ź�帳�ϴ�!-->
        $(".activityTab li").on("click",function(){
            var k = $(".activityTab li").index(this)+1;
            location.href = "/m/search_list.php??board=<?=$_GET["board"]?>&select=<?=$sql_select?>&kewyword=<?=$_REQUEST["kewyword"]?>&tab="+k;
        })
    })
</script>
<?include_once "tail.php";?>