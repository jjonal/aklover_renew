<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
if(!strcmp($_SESSION['temp_level'], '')){
    $my_level = '0';
}else{
    $my_level = $_SESSION['temp_level'];
}
if(!strcmp($my_level,'0')){msg('권한이 없습니다.','location.href="'.PATH_HOME.'?board=login"');exit;}
######################################################################################################################################################
$cut_count_name = '6';
$cut_title_name = '34';
######################################################################################################################################################
if(strcmp($_GET['kewyword'], '')){
	
	$kewyword = $_GET['kewyword'];
	$select = $_GET['select'];
	
	if($select=='hero_nick')																$search = " and B.".$select." like '%".$kewyword."%'";
	elseif($select=='hero_title' || $_GET['select']=='hero_command')						$search = " and A.".$select." like '%".$kewyword."%'";
	
    $search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
}
######################################################################################################################################################
$sql = "select count(*) from ";
$sql .= "(select hero_idx, hero_title, hero_command, hero_user, hero_user_check, left(hero_today,10) as hero_today from mail where hero_code='".$_SESSION['temp_code']."' and hero_table='mail' and hero_use=1) as A ";
$sql .= "left outer join member as B on A.hero_user=B.hero_id ";
$sql .= "where 1=1 ".$search;
//echo "<script>console.log(\"".$sql."\");</script>";
sql($sql);
$total_data = mysql_result($out_sql,0,0);
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

        <div class="contents">
            <table border="0" cellpadding="0" cellspacing="0" class="bbs_list">
                <colgroup>
                    <col width="90px" />
                    <col width="*" />
                    <col width="90px" />
                    <col width="70px" />
                </colgroup>
                <tr class="bbshead">
                	<th>번호</th>
                    <th>제목</th>
                    <th>받은사람</th>
                    <th>날짜</th>
                </tr>
	        	<?php 
					$sql = "select A.*, B.hero_nick, C.hero_img_new from ";
					$sql .= "(select hero_idx, hero_title, hero_command, hero_user, hero_user_check, left(hero_today,10) as hero_today from mail where hero_code='".$_SESSION['temp_code']."' and hero_table='mail' and hero_use=1) as A ";
					$sql .= "left outer join member as B on A.hero_user=B.hero_id ";
					$sql .= "inner join level as C on C.hero_level=B.hero_level ";
					$sql .= "where 1=1 ".$search." order by A.hero_today desc limit ".$start.",".$list_page;
					sql($sql);
					//echo $sql;
					$i=0;
					while($list                             = @mysql_fetch_assoc($out_sql)){
						$num=$total_data - $start-$i;
						$i++;
					?>
					    <tr onclick="location.href='<?=PATH_HOME;?>?board=<?=$_GET['board']?>&page=<?=$page?>&view=mail_view&idx=<?=$list['hero_idx'];?>'" style="cursor:pointer;">
					        <td><?=$num;?></td>
							
							<td class="tl">
								<?  
								if($list['hero_user_check']!=null)		echo cut($list['hero_title'], $cut_title_name);
								else									echo "<b>".cut($list['hero_title'], $cut_title_name)."</b>&nbsp;&nbsp;<font color=red>[안읽음]</font>";
								?>
							</td>
					        
					        <td><img src='<?=str($list['hero_img_new'])?>'/><?=cut($list['hero_nick'], $cut_count_name);?></td>
					        <td><?=$list['hero_today']?></td>
					    </tr>
					<?}
				?>
            </table>
			<!--<? include_once BOARD_INC_END.'button.php';?>-->
			<? include_once BOARD_INC_END.'search.php';?>
        </div>
    </div>
