<link rel="stylesheet" type="text/css" href="/css/front/cscenter.css" />
<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
if(!strcmp($_SESSION['temp_level'], '')){
    $my_level = '0';
    $my_write = '0';
    $my_view = '0';
    $my_update = '0';
    $my_rev = '0';
}else{
    $my_level = $_SESSION['temp_level'];
    $my_write = $_SESSION['temp_write'];
    $my_view = $_SESSION['temp_view'];
    $my_update = $_SESSION['temp_update'];
    $my_rev = $_SESSION['temp_rev'];
}
//2014.03.26 비회원 볼 수 있도록 권한 설정 변경
//if(!strcmp($my_level,'0')){msg('권한이 없습니다.','location.href="'.PATH_HOME.'?board=login"');exit;}
//}
######################################################################################################################################################
$cut_count_name = '6';
$cut_title_name = '32';
######################################################################################################################################################
if(strcmp($_POST['kewyword'], '')){
    if($_POST['select'] == 'hero_all') {
        $search = ' and (hero_title like \'%'.$_POST['kewyword'].'%\' or hero_command like \'%'.$_POST['kewyword'].'%\')';
    }else {
        $search = ' and '.$_POST['select'].' like \'%'.$_POST['kewyword'].'%\'';
    }

    $search_next = '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
}else if(strcmp($_GET['kewyword'], '')){
    if($_GET['select'] == 'hero_all') {
        $search = ' and (hero_title like \'%'.$_GET['kewyword'].'%\' or hero_command like \'%'.$_GET['kewyword'].'%\')';
    }else {
        $search = ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
    }
    $search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
}

//카테고리 검색
if(strcmp($_GET['category'], '') && strcmp($_GET['category'], '전체')){
    $search .= " and hero_06 ='".$_GET['category']."' ";
    $search_next = "&category=".$_GET['category'];
}else{
}

$gubun = "";
if($_GET["board"] == "group_04_03") { //공지사항
    $gubun_arr = array("1"=>"필독","2"=>"안내","3"=>"이벤트");
}

if($_GET["gubun"]) {
    $search .= " AND gubun = '".$_GET["gubun"]."' ";
    $search_next .= "&gubun=".$_GET["gubun"];
}
######################################################################################################################################################
##임시글 권한 설정
if($_SESSION['temp_level']<9999)	$hero_use="and hero_use=1 ";

$sql = 'select * from board where hero_table=\''.$_GET['board'].'\''.$search.' '.$hero_use.' order by hero_notice desc, hero_idx desc;';
sql($sql);
$total_data = @mysql_num_rows($out_sql);
######################################################################################################################################################
$list_page=8;
$page_per_list=10;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board'].$search_next;
######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);

if(!strcmp($_GET['type'], 'drop')){
    $post_count = @count($_POST['hero_drop']);
    for($i=0;$i<$post_count;$i++){
        $review_sql = 'select * from review WHERE hero_old_idx = \''.$_POST['hero_drop'][$i].'\';';
        $out_review = @mysql_query($review_sql);
        /*
                while($review_list                             = @mysql_fetch_assoc($out_review)){
                    $point_sql = 'DELETE FROM point WHERE hero_review_idx = \''.$review_list['hero_idx'].'\';';
                    @mysql_query($point_sql);
                    $member_total_sql = 'select SUM(hero_point) as member_total from point WHERE hero_code=\''.$review_list['hero_code'].'\';';
                    $out_member_total_sql = @mysql_query($member_total_sql);
                    $member_total_list                             = @mysql_fetch_assoc($out_member_total_sql);
                    $member_total_point = $member_total_list['member_total'];
                    $sql = 'UPDATE member SET hero_point=\''.$member_total_point.'\' WHERE hero_code = \''.$review_list['hero_code'].'\';'.PHP_EOL;
                    @mysql_query($sql);
                }
        */
        // 댓글 삭제 전 데이터 저장 S musign 25.07.10 jnr
        $review_sql = "SELECT r.hero_code, r.hero_table, r.hero_command, r.hero_today 
               FROM review r 
               WHERE r.hero_old_idx = '".$_POST['hero_drop'][$i]."'";
        $review_result = @mysql_query($review_sql);
        // 댓글 데이터가 있다면 삭제 이력 테이블에 저장 (조회되는 여러value가 있을수 있기에 foreach문으로 처리)
        while($review = @mysql_fetch_assoc($review_result)) {
            $save_sql = "INSERT INTO board_del 
                 (hero_code, hero_table, hero_command, hero_today, content_type) 
                 VALUES (
                     '".addslashes($review['hero_code'])."',
                     '".addslashes($review['hero_table'])."',
                     '".addslashes($review['hero_command'])."',
                     '".$review['hero_today']."',
                     'reply'
                 )";
            @mysql_query($save_sql);
        }


        $review_drop_sql = 'DELETE FROM review WHERE hero_old_idx = \''.$_POST['hero_drop'][$i].'\';';
        @mysql_query($review_drop_sql);
        $board_select_sql = 'select * from board WHERE hero_idx=\''.$_POST['hero_drop'][$i].'\';';
        $out_board_select = @mysql_query($board_select_sql);
        $board_select_list                             = @mysql_fetch_assoc($out_board_select);
        @unlink(USER_FILE_INC_END.$board_select_list['hero_board_one']);

        $drop_action_img = $board_select_list['hero_command'];
        $code_main_value = "&lt;img.*src=&quot;(.*)&quot;.*&gt;";
        preg_match_all("`$code_main_value`iU", $drop_action_img, $code_main);
        while(list($code_key, $code_val) = @each($code_main[1])){
            if(!strcmp(eregi(USER_PHOTO_END,$code_val),'1')){
                $check_file = @str_ireplace(USER_PHOTO_END, USER_PHOTO_INC_END, $code_val);
                @unlink($check_file);
            }else{
                continue;
            }
        }

        // 댓글 삭제 전 데이터 저장 musign 25.07.10 jnr
        // 게시글 삭제 전 데이터 저장
        $board_sql = "SELECT b.hero_code, b.hero_table, b.hero_command, b.hero_today 
              FROM board b 
              WHERE b.hero_idx = '".$_POST['hero_drop'][$i]."'";
        $board_result = @mysql_query($board_sql);
        $board = @mysql_fetch_assoc($board_result);

        if($board) {
            $save_sql = "INSERT INTO board_del 
                 (hero_code, hero_table, hero_command, hero_today, content_type) 
                 VALUES (
                     '".addslashes($board['hero_code'])."',
                     '".addslashes($board['hero_table'])."',
                     '".addslashes($board['hero_command'])."',
                     '".$board['hero_today']."',
                     'board'
                 )";
            @mysql_query($save_sql);
        }
        // 댓글 삭제 전 데이터 저장 E musign 25.07.10 jnr
        $board_drop_sql = 'DELETE FROM board WHERE hero_idx = \''.$_POST['hero_drop'][$i].'\';';
        @mysql_query($board_drop_sql);
    }
    $msg = '삭제 되었습니다.';
    $get_herf = get('next_board||view||action||idx||page||type','','');
    $action_href = PATH_HOME.'?'.$get_herf;
    msg($msg,'location.href="'.$action_href.'"');
}
?>
<div id="subpage" class="cscenter">
    <div class="sub_title">
        <div class="sub_wrap">
            <div class="f_b">
                <h1 class="fz68 main_c fw600">고객센터</h1>
            </div>
        </div>
    </div>
    <div class="sub_cont">
        <div class="sub_wrap board_wrap f_sb">
            <div class="left">
                <ul class="sub_menu">
                    <li class="on"><a href="/main/index.php?board=group_04_03">공지사항 <img src="/img/front/icon/bread.webp" alt="공지사항 바로가기"></a></li>
                    <li><a href="/main/index.php?board=group_04_33">FAQ <img src="/img/front/icon/bread.webp" alt="FAQ 바로가기"></a></li>
                    <li><a href="/main/index.php?board=group_04_35&view_type=list">1:1 문의 <img src="/img/front/icon/bread.webp" alt="1:1 문의 바로가기"></a></li>
                    <!-- <li class="link"><a href="/main/index.php?board=group_04_03&page=1&view=view&idx=443487">1:1 문의 <img src="/img/front/icon/bread.webp" alt="1:1 문의 바로가기"></a></li> -->
                </ul>
                <div class="caution">
                    <h3 class="fz20 fw600">안내/유의사항</h3>
                    <div class="f_fs">
                        <img src="/img/front/icon/caution.webp" alt="안내/유의사항">
                        <p class="fz14">
                            AK Lover 활동 및 운영에 대해서는 공지사항을 확인해주세요!<br />
                            그 외 궁금하신 사항은 FAQ를 확인하거나, 1:1 문의를 남겨주세요!
                        </p>
                    </div>
                </div>
                <? include_once BOARD_INC_END.'search.php';?>
            </div>
            <div class="contents right">
                <!-- 탑 슬라이드 -->
                <? include_once BOARD_INC_END.'top_slide.php';?>
                <div class="boardTabMenuWrap colorType">
                    <a href="<?=PATH_HOME?>?board=<?=$_GET["board"]?>" <?if(!$_GET["gubun"]) {?>class="on"<?}?>>전체</a>
                    <a href="<?=PATH_HOME?>?board=<?=$_GET["board"]?>&gubun=1" <?if($_GET["gubun"] == "1") {?>class="on"<?}?>>필독</a>
                    <a href="<?=PATH_HOME?>?board=<?=$_GET["board"]?>&gubun=2" <?if($_GET["gubun"] == "2") {?>class="on"<?}?>>안내</a>
                    <a href="<?=PATH_HOME?>?board=<?=$_GET["board"]?>&gubun=3" <?if($_GET["gubun"] == "3") {?>class="on"<?}?>>이벤트</a>
                </div>
                <table class="bbs_list">
                    <colgroup>
                        <? if($_SESSION['temp_level'] >= "9999") {?>
                            <col width="47px" />
                        <? } ?>
                        <col width="100px" />
                        <? if($_GET["board"] == "group_04_03") { ?>
                            <col width="90px" />
                        <? } ?>
                        <col width="*" />
                        <col width="110px" />
                        <col width="160px" />
                        <? if($_SESSION['temp_level'] >= "9999") {?>
                            <!-- <col width="70px" /> -->
                        <? } ?>
                    </colgroup>
                    <thead>
                    <tr class="bbshead">
                        <? if($_SESSION['temp_level'] >= "9999") {?>
                            <th></th>
                        <? } ?>
                        <th>번호</th>
                        <? if($_GET["board"] == "group_04_03") { ?>
                            <th>카테고리</th>
                        <? } ?>
                        <th>제목</th>
                        <th>글쓴이</th>
                        <th>날짜</th>
                        <? if($_SESSION['temp_level'] >= "9999") {?>
                            <!-- <th>조회수</th> -->
                        <? } ?>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- 상단고정  -->
                    <?
                    $sql = 'select * from board where hero_table=\'hero\' and hero_order =\'0\' and hero_notice_use = \'0\' '.$hero_use.' order by hero_today desc;';
                    sql($sql);
                    while($hero_list = @mysql_fetch_assoc($out_sql)){

                    $main_review_sql_01 = 'select * from review where hero_old_idx=\''.$hero_list['hero_idx'].'\'';
                    $out_main_review_sql_01 = @mysql_query($main_review_sql_01);
                    $main_review_data_01 = @mysql_num_rows($out_main_review_sql_01);

                    if(strcmp($main_review_data_01, '0')) {
                        $re_count_total = "<strong><font color='orange'>[".$main_review_data_01."]</font></strong>";
                    } else {
                        $re_count_total = "";
                    }

                    $pk_sql = 'select a.hero_level,a.hero_nick,b.hero_img_new from member as a, level as b  where b.hero_level = a.hero_level and a.hero_code = \''.$hero_list['hero_code'].'\'';
                    $out_pk_sql = mysql_query($pk_sql);
                    $pk_row                             = @mysql_fetch_assoc($out_pk_sql);

                    if(!strcmp(y."-".m."-".d, date( "Y.m.d", strtotime($hero_list['hero_today'])))){
                        $new_img_view = " <img src='".DOMAIN_END."image/sub_new.jpg' alt='new' />";
                    }else{
                        $new_img_view = "";
                    }

                    ?>
                    <tr class="notice" onclick="location.href='<?=PATH_HOME;?>?board=<?=$_GET['board']?>&next_board=hero&page=<?=$page?>&view=view&idx=<?=$hero_list['hero_idx'];?>'" style="cursor:pointer;">
                        <? if($_SESSION['temp_level'] >= "9999") {?>
                            <td></td>
                        <? } ?>
                        <td><img src="../image/bbs/icon_notice.gif" alt="공지" /></td>
                        <? if($_GET["board"] == "group_04_03") { ?>
                            <td class="color_<?=$hero_list['gubun'];?>"><span><?=$gubun_arr[$hero_list['gubun']]?></span></td>
                        <? } ?>
                        <td class="t_l">
                            <?=cut($hero_list['hero_title'], $cut_title_name);?> <?=$re_count_total.$new_img_view?>
                        </td>
                        <td><?if(!strcmp($hero_list['hero_notice'], '1')){?><strong><?=cut($pk_row['hero_nick'], $cut_count_name);?></strong><?}else{echo cut($pk_row['hero_nick'], $cut_count_name);}?></td>
                        <td><?=date( "Y.m.d", strtotime($hero_list['hero_today']));?></td>
                        <? if($_SESSION['temp_level'] >= "9999") {?>
                            <!-- <td><?=$hero_list['hero_hit']?></td> -->
                        <? } ?>
                    </tr>
                    <!-- 공지리스트  -->
                    <form name="form_next" action="<?=PATH_HOME.'?'.get('','type=drop');?>" method="post" enctype="multipart/form-data">
                        <?
                        }
                        $sql = "select * from board where hero_table='".$_GET['board']."' ".$search." ".$hero_use." order by hero_notice desc, hero_idx desc limit ".$start.",".$list_page;
                        sql($sql);
                        $i=0;
                        while($list = @mysql_fetch_assoc($out_sql)){
                            $num=$total_data - $start-$i;
                            $i++;

                            $main_review_sql = 'select * from review where hero_old_idx=\''.$list['hero_idx'].'\'';
                            $out_main_review_sql = @mysql_query($main_review_sql);
                            $main_review_data = @mysql_num_rows($out_main_review_sql);
                            if(strcmp($main_review_data, '0')){
                                $re_count_total = "<strong><font color='orange'>[".$main_review_data."]</font></strong>";
                            }else{
                                $re_count_total = "";
                            }

                            $pk_sql = 'select a.hero_level,a.hero_nick,b.hero_img_new from member as a, level as b  where b.hero_level = a.hero_level and a.hero_code = \''.$list['hero_code'].'\'';
                            $out_pk_sql = mysql_query($pk_sql);
                            $pk_row                             = @mysql_fetch_assoc($out_pk_sql);

                            if(!strcmp(y."-".m."-".d, date( "Y.m.d", strtotime($list['hero_today'])))){
                                $new_img_view = " <img src='".DOMAIN_END."image/sub_new.jpg' alt='new' />";
                            }else{
                                $new_img_view = "";
                            }

                            ?>
                            <tr>
                                <?if($_SESSION['temp_level']>='9999'){?>
                                <td class="input_chk">
                                    <input id="numbox_<?=$list['hero_idx']?>" type="checkbox" name="hero_drop[]" value="<?=$list['hero_idx']?>">
                                    <label for="numbox_<?=$list['hero_idx']?>" class="input_chk_label"></label>
                                    <?}?>
                                </td>
                                <td>
                                    <?=$num;?>
                                </td>
                                <? if($_GET["board"] == "group_04_03") { ?>
                                    <td class="color_<?=$list['gubun'];?>"><span><?=$gubun_arr[$list['gubun']]?></span></td>
                                <? } ?>
                                <td class="t_l" onclick="location.href='<?=PATH_HOME;?>?board=<?=$_GET['board']?>&page=<?=$page?>&view=view&idx=<?=$list['hero_idx'];?>'" style="cursor:pointer;">
                                    <?=cut($list['hero_title'], $cut_title_name);?> <?=$re_count_total.$new_img_view?>
                                </td>
                                <td><?=cut($pk_row['hero_nick'], $cut_count_name);?></td>
                                <td><?=date( "Y.m.d", strtotime($list['hero_today']));?></td>
                                <? if($_SESSION['temp_level'] >= "9999") {?>
                                    <!-- <td><?=$list['hero_hit']?></td> -->
                                <? } ?>
                            </tr>
                        <? } ?>
                    </form>
                    </tbody>
                </table>
                <div class="admin_btn">
                    <? if($_SESSION['temp_level']>='9999'){?>
                        <a href="javascript:form_next.submit();" class="btn_delete">글삭제</a>
                    <?}?>
                    <? include_once BOARD_INC_END.'button.php';?>
                </div>
            </div>
        </div>
    </div>
</div>