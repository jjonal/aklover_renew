<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
if(!strcmp($_SESSION['temp_level'], '')){
    $my_level = '0';
}else{
    $my_level = $_SESSION['temp_level'];
}
if(!strcmp($my_level,'0')){msg('������ �����ϴ�.','location.href="'.PATH_HOME.'?board=login"');exit;}
######################################################################################################################################################
$cut_count_name = '6';
$cut_title_name = '34';
######################################################################################################################################################
if(strcmp($_POST['kewyword'], '')){
    $search = ' and '.$_POST['select'].' like \'%'.$_POST['kewyword'].'%\'';
    $search_next = '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
}else if(strcmp($_GET['kewyword'], '')){
    $search = ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
    $search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
}
######################################################################################################################################################
#���� �ѹ����� ���� ȸ������
$sql = "SELECT hero_oldday FROM member WHERE hero_id ='".$_SESSION['temp_id']."'";
sql($sql);
$member = @mysql_fetch_assoc($out_sql);
######################################################################################################################################################
#���� �ѹ���
$sql = 'select * from mail where hero_table=\''.$_GET['board'].'\''.$search.' and ((hero_user=\'all\' and hero_today > \''.$member['hero_oldday'].'\') or CONCAT(\'||\', hero_user, \'||\') LIKE \'%||'.$_SESSION['temp_id'].'||%\') order by hero_today desc;';
sql($sql);
$total_data = @mysql_num_rows($out_sql);
######################################################################################################################################################
#���������̼�
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
                    <h1 class="fz68 main_c fw600">����������</h1>			
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
					<div class="page_tit fz32 fw600">���� �˸���</div>	
					<? include_once BOARD_INC_END.'search.php';?>
					<table border="0" cellpadding="0" cellspacing="0" class="bbs_list">
						<colgroup>
							<col width="12%" />
							<col width="*" />
							<col width="13%" />
							<col width="13%" />
							<col width="13%" />
						</colgroup>
						<thead>
							<tr class="bbshead">
								<th>��ȣ</th>
								<th>����</th>								
								<th>Ȯ�� ����</th>
								<th>�������</th>
								<th>��¥</th>
							</tr>
						</thead>
						<tbody>						
							<?

							$sql = 'SELECT A.*, C.hero_img_new FROM mail A 
									LEFT JOIN member B ON A.hero_code = B.hero_code 
									LEFT JOIN level C ON B.hero_level = C.hero_level
									WHERE A.hero_table=\''.$_GET['board'].'\''.$search.' 
									AND 
									((A.hero_user=\'all\' AND A.hero_today > \''.$member['hero_oldday'].'\') 
									OR CONCAT(\'||\', A.hero_user, \'||\') LIKE \'%||'.$_SESSION['temp_id'].'||%\')
									ORDER BY A.hero_today DESC LIMIT '.$start.','.$list_page.';';
							sql($sql);
							$i=0;
							while($list                             = @mysql_fetch_assoc($out_sql)){
							$num=$total_data - $start-$i;
							$i++;

							$open_check = true;
							$view_search_id = ",".$_SESSION['temp_id'].",";
							$view_user_check_id = str_replace("||",",",$list['hero_user_check']);
							$view_user_check_id = ",".$view_user_check_id.",";

							if(strcmp(eregi($view_search_id,$view_user_check_id),'1')){
								$open_check = false;
							}

							$icon_msg = "";
							if($list["hero_user"] == "all") {
								if($open_check) {
									$icon_msg = "<img src='/image2/icon_msg_group_open.jpg' />";
								} else {
									//��ü ������ ��� �� 7�� ���Ŀ��� �������� ó��.
									$today = date("Ymd");
									$mail_today = date("Ymd",strtotime("+7 days", strtotime(substr($list["hero_today"],0,10))));
									if($mail_today <= $today) $open_check = true;
									
									if($open_check) {
										$icon_msg = "<img src='/image2/icon_msg_group_open.jpg' />";
									} else {
										$icon_msg = "<img src='/image2/icon_msg_group.jpg' />";
									}
								}
							} else {
								if($open_check) {
									$icon_msg = "<img src='/image2/icon_msg_individual_open.jpg' />";
								} else {
									$icon_msg = "<img src='/image2/icon_msg_individual.jpg' />";
								}
							}
							?>
							<tr onclick="location.href='<?=PATH_HOME;?>?board=<?=$_GET['board']?>&page=<?=$page?>&view=mail_view&idx=<?=$list['hero_idx'];?>'" style="cursor:pointer;">
							<td><?=$num;?></td>							
							<td class="tl">
								<? if($open_check){?>
									<?=cut($list['hero_title'], $cut_title_name);?>
								<?}else{?>
									<b><?=cut($list['hero_title'], $cut_title_name);?></b>
								<?}?>
							</td>
							<td>
								<? if($open_check){?>
									<span class="open"><img src="/img/front/mypage/confirm.png" alt="Ȯ��"></span>
								<? } else {?>
									<span class="noneOpen"><img src="/img/front/mypage/nonfirm.png" alt="��Ȯ��"></span>
								<? } ?>
							</td>
							<td>
								<? if(!strcmp($list['hero_notice'], '1')){ ?>
									<strong><?=cut($list['hero_nick'], $cut_count_name);?></strong>
								<? }else echo cut($list['hero_nick'], $cut_count_name); ?>
							</td>
							<td><?=date( "y-m-d", strtotime($list['hero_today']));?></td>
						</tr>		
						<?}?>				
						</tbody>
					</table>
					<div class="paging">
						<? include_once BOARD_INC_END.'page.php';?>
					</div>
				</div> <!-- right (e)} -->
			</div> <!-- sub_wrap (e)} -->
		</div><!-- sub_cont (e)} -->
	</div><!-- subpage (e)} -->
