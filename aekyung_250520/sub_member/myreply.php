<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;

######################################################################################################################################################
	$cut_count_name = '4';
	$cut_title_name = '30';//40
######################################################################################################################################################
	if(strcmp($_REQUEST['kewyword'], '')){
		
		$kewyword = $_REQUEST['kewyword'];
		$select = $_GET['select'];
		
		if($select=='hero_title' || $_GET['select']=='hero_nick')		$search = ' and B.'.$select.' like \'%'.$kewyword.'%\'';
		elseif($_GET['select']=='hero_command')						$search = ' and A.'.$select.' like \'%'.$kewyword.'%\'';
	    
	    $search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
	}
######################################################################################################################################################
	$sql = "select count(*) as count from review A inner join board B on A.hero_old_idx=B.hero_idx where A.hero_code='".$_SESSION['temp_code']."' ".$search." order by A.hero_today desc";
	//echo $sql;
	$sql_res = mysql_query($sql) or die("<script>alert('시스템 에러, 다시 시도해주시기 바랍니다. 에러코드 - REPLY_01');location.href='/main/index.php';</script>");
	$sql_rs = mysql_fetch_assoc($sql_res);
	$total_data = $sql_rs['count'];
######################################################################################################################################################
	$list_page=8;
	$page_per_list=10;
	
	if(!strcmp($_GET['page'], ''))  $page = '1';
	else 							$page = $_GET['page'];
	
	$start = ($page-1)*$list_page;
	$next_path="board=".$_GET['board'].$search_next;
	
	$num=$total_data - $start;
######################################################################################################################################################
	$sql = "select * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$_GET['board']."'";//desc
	$sql_res = mysql_query($sql) or die("<script>alert('시스템 에러, 다시 시도해주시기 바랍니다. 에러코드 - REPLY_02');location.href='/main/index.php';</script>");
	$right_list                             = mysql_fetch_assoc($sql_res);
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
    <div class="sub_cont replypage">
        <div class="sub_wrap board_wrap f_sb">
            <div class="left">
                <? include_once BOARD_INC_END.'mypage_nav.php';?>
            </div>
            <div class="contents right black_btn">
                <div class="page_tit fz32 fw600">나의 작성글</div>
                <div class="boardTabMenuWrap">
                    <a href="/main/index.php?board=mylist" class="fw600">게시글</a>
                    <a href="/main/index.php?board=myreply" class="on fw600">댓글</a>
                </div>
                <? include_once BOARD_INC_END.'search.php';?>
                <table border="0" cellpadding="0" cellspacing="0" class="point_table">
                    <colgroup>
                        <col width="15%" />
                        <col width="35%" />
                        <col width="35%" />
                        <col width="15%" />
                    </colgroup>
                    <thead>
                        <tr class="bbshead">
                            <th class="first">번호</th>
                            <th>댓글 내용</th>
                            <th>게시글</th>
                            <th class="last">댓글 작성일</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?
                    //group by 게시판 idx, inner join 게시판( 게시판이 삭제되지 않은 경우 )
                    $sql = "select A.hero_idx, A.hero_code, A.hero_old_idx, A.hero_today, A.hero_command, A.hero_depth_idx_old, B.hero_idx as board_idx, B.hero_title as board_title, B.hero_table as board_table, B.hero_01 as board_01, B.hero_03 as board_03 from review A inner join board B on A.hero_old_idx=B.hero_idx where A.hero_code='".$_SESSION['temp_code']."' ".$search." order by A.hero_today desc  limit ".$start.",".$list_page."";
                    //echo "<script>console.log(\"".$sql."\")</script>";
                    $sql_res = mysql_query($sql) ;//or die("<script>alert('시스템 에러, 다시 시도해주시기 바랍니다. 에러코드 - REPLY_03');location.href='/main/index.php';</script>");

                    while($list                             = mysql_fetch_assoc($sql_res)){
                        //댓글 작성 이후의 해당글에 댓글이 달렸을 경우 new
                        $main_review_sql = "select count(*) as count from review where hero_old_idx='".$list['hero_old_idx']."' and hero_depth_idx_old = ".$list['hero_depth_idx_old']." and hero_today>'".$list['hero_today']."' and hero_code!='".$list['hero_code']."'";
                        //echo $main_review_sql;
                        $out_main_review_sql = mysql_query($main_review_sql); //or die("<script>alert('시스템 에러, 다시 시도해주시기 바랍니다. 에러코드 - TODAY_04');location.href='/main/index.php';</script>");
                        $main_review_data = mysql_fetch_assoc($out_main_review_sql);
                        $review_count = $main_review_data['count'];

                        if(strcmp($review_count, '0')){
                            if($list['hero_today']>date('Y-m-d H:i:s',strtotime("-1 week")))
                                $re_count_total = "<strong><font color='orange'>[".$review_count."]</font></strong>";
                            else
                                $re_count_total = "<font color='orange'>[".$review_count."]</font>";
                        }else{
                            $re_count_total = "";
                        }

                        //if(!strcmp(y."-".m."-".d, date( "y-m-d", strtotime($list['hero_today']))))	 	 $new_img_view = " <img src='".DOMAIN_END."image/sub_new.jpg' alt='new' />";
                        //else 																			 $new_img_view = "";

                        if( (!strcmp($list['board_table'],'group_04_05')) or (!strcmp($list['board_table'],'group_04_06')) or (!strcmp($list['board_table'],'group_04_07')) or (!strcmp($list['board_table'],'group_04_08')) ){
                            $page='1';
                            $view='step_06&hero_idx='.$list['board_idx'];
                            $idx=$list['board_01'];
                        }else{
                            $page=$page;
                            $view='view';
                            $idx=$list['board_idx'];
                        }

                        if(!strcmp($list['board_table'], 'hero')){
                        ?>
                            <tr onclick="location.href='<?=PATH_HOME;?>?board=<?=$list['board_03']?>&next_board=hero&page=<?=$page?>&view=<?=$view?>&idx=<?=$idx;?>'" style="cursor:pointer;">
                        <?
                        }else{
                        ?>
                            <tr onclick="location.href='<?=PATH_HOME;?>?board=<?=$list['board_table']?>&page=<?=$page?>&view=<?=$view?>&idx=<?=$idx;?>'" style="cursor:pointer;">
                        <?}?>
                                <td><?=$num?></td>
                        <?
                        //대댓글 닉네임
                        $rereplay= '';
                        $commandArray = explode('SS$$SS', $list['hero_command']);
                        if($commandArray[1]) {
                            $parentName = $commandArray[1];
                            $list['hero_command'] = $commandArray[2];
                        }
                        else{
                            $parentName = '';
                            $list['hero_command'] = $commandArray[0];
                        }

                        if($parentName != ''){
                            $rereplay = '<b class="bold" style="color: #FF4C05">@'.$parentName.'</b>';
                        }
                        ?>
                                <td class="t_tit"><div><?=$rereplay?> <?=cut($list['hero_command'], $cut_title_name);?> <?=$re_count_total?></div></td>
                                <td class="t_tit"><div class="rel mu_bar"><?=cut($list['board_title'], $cut_title_name)?></div></td>
                                <td><?=date( "y-m-d", strtotime($list['hero_today']));?></td>
                            </tr>
                        <?
                            $num--;
                            }
                        ?>
                    </tbody>
                </table>
                <? include_once BOARD_INC_END.'button.php';?>
            </div>
        </div>
    </div>
</div>