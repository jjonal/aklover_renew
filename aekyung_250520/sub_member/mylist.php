<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$cut_count_name = '4';
$cut_title_name = '34';//40
######################################################################################################################################################
if(strcmp($_GET['kewyword'], '')){
    $search = ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
    $search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
}
######################################################################################################################################################
$sql = 'select * from board where hero_code=\''.$_SESSION['temp_code'].'\''.$search.' order by hero_today desc;';
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
?>

<div id="subpage" class="mypage alrampage">
    <div class="sub_title">
        <div class="sub_wrap">
            <div class="f_b">
                <h1 class="fz68 main_c fw600">마이페이지</h1>			
            </div>		
            <? include_once BOARD_INC_END.'mypage_top.php';?>
        </div>
    </div>
	<div class="sub_cont">
        <div class="sub_wrap board_wrap f_sb">
            <div class="left">
                <? include_once BOARD_INC_END.'mypage_nav.php';?>
            </div>
            <div class="contents right black_btn">		
                <div class="page_tit fz32 fw600">나의 작성글</div>	
                <div class="boardTabMenuWrap">						
                    <a href="/main/index.php?board=mylist" class="on fw600">게시글</a>						
                    <a href="/main/index.php?board=myreply" class="fw600">댓글</a>
                </div> 
                <? include_once BOARD_INC_END.'search.php';?>
                <table border="0" cellpadding="0" cellspacing="0" class="point_table">
                    <colgroup>
                        <col width="150px" />
                        <col width="*" />
                        <col width="220px" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th>번호</th>
                            <th>제목</th>
                            <th>게시일</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                            $sql = 'select * from board where hero_code=\''.$_SESSION['temp_code'].'\''.$search.' order by hero_today desc limit '.$start.','.$list_page.';';
                            echo "<script>console.log(\"".$sql."\");</script>";
                            sql($sql);
                            $i=0;
                            while($list                             = @mysql_fetch_assoc($out_sql)){
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

                            // 새글
                            if(!strcmp(y."-".m."-".d, date( "y-m-d", strtotime($list['hero_today'])))){
                                $new_img_view = "";
                            }else{
                                $new_img_view = "";
                            }

                                if( (!strcmp($list['hero_table'],'group_04_05')) or (!strcmp($list['hero_table'],'group_04_06')) or (!strcmp($list['hero_table'],'group_04_07')) or (!strcmp($list['hero_table'],'group_04_08')) ){
                                    $page='1';
                                    $view='step_05&hero_idx='.$list['hero_idx'];
                                    $idx=$list['hero_01'];
                                }else{
                                    $page=$page;
                                    $view='view';
                                    $idx=$list['hero_idx'];
                                }
                            if(!strcmp($list['hero_table'], 'hero')){
                        ?>
                        <tr onclick="location.href='<?=PATH_HOME;?>?board=<?=$list['hero_03']?>&next_board=hero&page=<?=$page?>&view=view&idx=<?=$idx;?>'" style="cursor:pointer;">
                            <?php	
                                }else{
                                    if($list['hero_03']=='cus_3'){
                            ?>
                                <tr onclick="location.href='<?=PATH_HOME;?>?board=<?=$list['hero_table']?>&page=<?=$page?>&view=view_new&idx=<?=$idx;?>'" style="cursor:pointer;">
                            <?php 
                                }else{
                            ?>
                                <tr onclick="location.href='<?=PATH_HOME;?>?board=<?=$list['hero_table']?>&page=<?=$page?>&view=<?=$view?>&idx=<?=$idx;?>'" style="cursor:pointer;">
                            <?php 
                                }
                            ?>
                            <?}?>
                            <td><?=$num?></td>
                            <td class="t_tit"><div class="ellipsis_100"><?=cut($list['hero_title'], $cut_title_name);?> <?=$re_count_total.$new_img_view?></div></td>
                            <td><?=date( "Y-m-d", strtotime($list['hero_today']));?></td>
                        </tr>
                        <?}?>
                    </tbody>
                </table>
                <? include_once BOARD_INC_END.'button.php';?>
            </div>    
        </div>
    </div>
</div>