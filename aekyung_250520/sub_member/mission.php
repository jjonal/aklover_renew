<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################

if(!is_numeric($_SESSION['temp_level'])){
	error_location("�α����� ���ּ���","/main/index.php?board=login");
	exit;
}

######################################################################################################################################################
$cut_count_name = '6';
$cut_title_name = '32';

$list_page=10;
$page_per_list=5;

$today = date("Y-m-d");

if(!is_numeric($_GET['page']))		$page = 1;
else								$page = $_GET['page'];

$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board'].$search_next;

$code = $_SESSION['temp_code'];
$board = $_GET['board'];
######################################################################################################################################################
if($_GET['kewyword']){
    $search = " and ".$_GET['select']." like '%".$_GET['kewyword']."%'";
    $search_next = "&select=".$_GET['select']."&kewyword=".$_GET['kewyword'];
}
// 24.06.19 https://app.asana.com/0/1207585762197898/1207597939373068/f ��û�� ���� �˻��Ⱓ �߰�
if($_GET['date-from']){
	$search .= "AND DATE_FORMAT(B.hero_today,'%Y-%m-%d') between DATE_FORMAT('".$_GET['date-from']."','%Y-%m-%d') and DATE_FORMAT('".$_GET['date-to']."','%Y-%m-%d')";
	$search_next .= "&date-from=".$_GET['date-from']."&date-to=".$_GET['date-to'];
}
if($_GET['lot_01']){
    $search = " and B.lot_01 = '".$_GET['lot_01']."'";
    $search_next = "&lot_01=".$_GET['lot_01'];
}

######################################################################################################################################################
$error = "MISSION_01";
$main_sql = "select count(*) from mission as A inner join (select hero_code,hero_old_idx, lot_01, hero_today from mission_review where hero_code='".$code."') as B on B.hero_old_idx=A.hero_idx inner join (select hero_code, hero_nick from member where hero_code='".$code."') as C on B.hero_code=C.hero_code where 1=1 ".$search."";

$main_res = new_sql($main_sql,$error,"on");

if((string)$main_res==$error){
	error_historyBack("");
	exit;
}

$total_data = mysql_result($main_res,0,0);
######################################################################################################################################################
$error = "MISSION_02";
$sql = "select * from hero_group where hero_order!=0 and hero_board ='".$board."'";//desc
$right_res = new_sql($sql,$error);
if((string)$right_res==$error){
	error_historyBack("");
	exit;
}

$right_list                             = @mysql_fetch_assoc($right_res);
?>
	<div id="subpage" class="mypage">
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
				<div class="contents right date_ver">
					<div class="page_tit fz32 fw600">���� ü���</div>
					<!-- [����] ��÷ü��� ������ �ʿ�  -->
					<div class="boardTabMenuWrap">
						<a href="/main/index.php?board=mission" class="<?=$_GET['lot_01'] != 1 ? "on":""?> fw600">��û�� ü���</a>
						<a href="/main/index.php?board=mission&lot_01=1" class=" <?=$_GET['lot_01'] == 1 ? "on":""?> fw600">��÷�� ü���</a>
					</div>
					<? include_once BOARD_INC_END.'search.php';?>
					<table border="0" cellpadding="0" cellspacing="0" class="bbs_list">
						<colgroup>
							<col width="130px" />
							<col width="150px" />
							<col width="*" />
							<col width="160px" />
						</colgroup>
						<thead>
							<tr class="bbshead">
								<th class="first">��ȣ</th>
								<th>Ȱ�� ����</th>
								<th>Ȱ�� ����</th>
								<th>����</th>
								<th>��û��</th>
                                <?
                                if($_SERVER['REMOTE_ADDR'] == '121.167.104.240'){
                                    if($_GET['lot_01'] == 1){
                                        echo '<th>�ı�</th>';
                                    }
                                }
                                ?>
							</tr>
						</thead>
						<tbody>
							<?
							$error = "MISSION_03";
							$sql="select A.hero_idx, A.hero_table, A.hero_title, A.hero_kind, A.hero_today_01_01, A.hero_today_01_01, A.hero_today_02_01, A.hero_today_02_02, ";
							$sql.="A.hero_today_03_01, A.hero_today_03_02, A.hero_today_04_01, A.hero_today_04_02, A.hero_thumb, A.hero_type, B.hero_idx as review_idx, B.lot_01, B.hero_today ";
//                            $sql.="(select count(*) from board where hero_01 = A.hero_idx and hero_table = A.hero_table and hero_code = '".$code."' and lot_01 = 1) review_check";
							$sql.="from mission as A inner join (select hero_idx, hero_code,hero_old_idx, lot_01, hero_today from mission_review where hero_code='".$code."') as B on A.hero_idx=B.hero_old_idx ";
							$sql.="inner join (select hero_code,hero_nick from member where hero_code='".$code."') as C on B.hero_code=C.hero_code where 1=1 ".$search." ";
							$sql.="order by CASE WHEN (hero_today_01_01<='".$today." 00:00:00"."' and hero_today_01_02>='".$today." 00:00:00"."') THEN hero_today_01_02 END desc, ";
							$sql.="CASE WHEN (hero_today_02_01<='".$today." 00:00:00"."' and hero_today_02_02>='".$today." 00:00:00"."') THEN hero_today_02_02 END desc, ";
							$sql.="CASE WHEN (hero_today_03_01<='".$today." 00:00:00"."' and hero_today_03_02>='".$today." 00:00:00"."') THEN hero_today_03_02 END desc, ";
							$sql.="CASE WHEN (hero_today_04_01<='".$today." 00:00:00"."' and hero_today_04_02>='".$today." 00:00:00"."') THEN hero_today_04_02 END desc, ";
							$sql.="CASE WHEN (hero_today_04_02<='".$today." 00:00:00"."') THEN hero_today_04_02 END desc ";
							$sql.="limit ".$start.",".$list_page.";";

							//echo $sql;

							$main_res = new_sql($sql,$error);
							if((string)$main_res==$error){
								error_historyBack("");
								exit;
							}

							$i=0;
							while($list                             = @mysql_fetch_assoc($main_res)){
								$reviwer_tf = "";
								$board_title = "";
								$num=$total_data - $start-$i;
								$i++;

                                //�ı��� ���� - ������ �󼼿��� ������
                                $new_sql = 'select * from board where hero_table = \'' . $list ['hero_table'] . '\' and hero_code=\'' . $_SESSION ['temp_code'] . '\' and hero_01=\'' . $list ['hero_idx'] . '\'';
                                $view_new_sql = mysql_query ( $new_sql );
                                $new_count = mysql_num_rows ( $view_new_sql );
                                $new_res = mysql_fetch_assoc($view_new_sql);

                                //�ı��� ��ư �����߰� 240926 YDH
                                $review_button = '';
								if(substr($list["hero_today_04_02"],0,10)<$today){ //����ı� ��ǥ < ����
									$progress = "ü��� ����";
									// $href = "javascript:alert(\"������ ü����Դϴ�.\")";
                                    // ������ ü��ܵ� ���� �����ϰ� ��û�Ͽ� ���� ��ġ
                                    $href = "/main/index.php?board=".$list['hero_table']."&view=view&idx=".$list['hero_idx'];
									if($list['lot_01']==1){
										$error = "MISSION_04";
										$board_sql = "select hero_idx, hero_table, hero_title from board where hero_code='".$code."' and hero_01='".$list['hero_idx']."'";
										$board_res = new_sql($board_sql,$error);
										if((string)$board_res==$error){
											error_historyBack("");
											exit;
										}

										$borad_count = mysql_num_rows($board_res);
										if($borad_count>0){
											$board_rs	= mysql_fetch_assoc($board_res);
											if($board_rs['hero_board_three']==1)	$reviwer_tf = "<span class='mu_bar'>[����ı� ��÷]</span>";
											$board_title = "<a href='http://www.aklover.co.kr/main/index.php?board=".$board_rs['hero_table']."&view=view2&idx=".$board_rs['hero_idx']."' target='_blank'><img src='/img/front/mypage/thum.jpg'><div class='txt_bx'><p class='ribon'><span class='type1'>�����̾� ��Ƽ Ŭ��</span>".$reviwer_tf."</p><p class='tit t_l'>[�ı�] ".cut($board_rs['hero_title'],$cut_title_name)."</p></div></a>";
										}
									}

                                    $review_button = '<span>������ ��� �Ⱓ ����</span>';
								}
                                //240926 musign ���� YDH - ���� ���� ü����̶� �����ϰ� ����
                                //����ı� ��ǥ ������ <= ���� && ����ı� ��ǥ ������ >= ����
								elseif(substr($list["hero_today_04_01"],0,10)<=$today && substr($list["hero_today_04_02"],0,10)>=$today){
									$progress = "����ı� ��ǥ";
//									$href = "/main/index.php?board=".$list['hero_table']."&view=step_05&best=true&idx=".$list['hero_idx'];
                                    //250320 musign ���� YDH - ������� ���о��� ü��� �������� �̵�
                                    $href = "/main/index.php?board=".$list['hero_table']."&view=view&idx=".$list['hero_idx'];

									if($list['lot_01']==1){
										$error = "MISSION_04";
										$board_sql = "select hero_idx, hero_table, hero_title from board where hero_code='".$code."' and hero_01='".$list['hero_idx']."' and hero_board_three=1";
										$board_res = new_sql($board_sql,$error);
										if((string)$board_res==$error){
											error_historyBack("");
											exit;
										}

										$borad_count = mysql_num_rows($board_res);
										if($borad_count>0){
											$board_rs	= mysql_fetch_assoc($board_res);
											$reviwer_tf = "<span class='mu_bar'>[����ı� ��÷]</span>";
											$board_title = "<a href='http://www.aklover.co.kr/main/index.php?board=".$board_rs['hero_table']."&view=view2&idx=".$board_rs['hero_idx']."' target='_blank'><img src='/img/front/mypage/thum.jpg'><div class='txt_bx'><p class='ribon'><span class='type1'>�����̾� ��Ƽ Ŭ��</span>".$reviwer_tf."</p><p class='tit t_l'>[�ı�]  ".cut($board_rs['hero_title'],$cut_title_name)."</p></div></a>";
										}
									}

                                    $review_button = '<span>������ ��� �Ⱓ ����</span>';
								}
                                //�ı��� ������ <= ���� && �ı��� ������ >= ����
								elseif(substr($list["hero_today_03_01"],0,10)<=$today && substr($list["hero_today_03_02"],0,10)>=$today){
									$progress = "�ı� ���";
									$href = "/main/index.php?board=".$list['hero_table']."&view=view&idx=".$list['hero_idx'];

									if($list['lot_01']==1){
										$reviwer_tf = "<span class='mu_bar'>[ü��� ����]</span>";
										$error = "MISSION_04";
										$board_sql = "select hero_idx, hero_table, hero_title, hero_board_three from board where hero_code='".$code."' and hero_01='".$list['hero_idx']."'";
                                        $board_res = new_sql($board_sql,$error);
										if((string)$board_res==$error){
											error_historyBack("");
											exit;
										}

										$borad_count = mysql_num_rows($board_res);
										if($borad_count>0){
											$board_rs	= mysql_fetch_assoc($board_res);

                                            $href = "/main/index.php?board=".$list['hero_table']."&view=view&idx=".$list['hero_idx'];
											$board_title = "<a href='http://www.aklover.co.kr/main/index.php?board=".$board_rs['hero_table']."&view=view2&idx=".$board_rs['hero_idx']."'  target='_blank'><img src='/img/front/mypage/thum.jpg'><div class='txt_bx'><p class='ribon'><span class='type1'>�����̾� ��Ƽ Ŭ��</span>".$reviwer_tf."</p><p class='tit t_l'>[�ı�]  ".cut($board_rs['hero_title'],$cut_title_name)."</p></div></a>";
										}else{
											$reviwer_tf = "<span class='mu_bar'>[ü��� ����]</span>";
										}
									}

                                    if (! strcmp ( $new_count, '0' )) {
                                        $review_button = '<a href="'.PATH_HOME.'?board='.$list['hero_table'].'&view=write2&action=write&page=1&idx='.$list['hero_idx'].'"><img src="/img/front/board/icon_create.png" alt="�ı���" /></a>';
                                    }else {
                                        if($list['hero_type'] == 2) { //�ҹ�����
                                            $review_button = substr($new_res['hero_today'],0,10);
                                            $review_button = '<a href="'.MAIN_HOME.'?board=group_04_05&idx='.$list['hero_idx'].'&view=step_02_01&hero_idx='.$list['review_idx'].'&somun=Y&board_idx='.$new_res['hero_idx'].'"><img src="/img/front/board/icon_update.png" alt="�ı����" /></a>';
                                            $review_button .= '<a href="javascript:;" onclick="confirmAction(\'�����Ͻðڽ��ϱ�?\', \''.MAIN_HOME.'?board=group_04_05&view=step_02&idx='.$list['hero_idx'].'&&type=drop&hero_idx='.$list['review_idx'].'\', parent)"><img src="/img/front/board/icon_delete.png" alt="�ı����" /></a>';
                                        }else{
                                            $review_button = substr($new_res['hero_today'],0,10);
                                            $review_button .= "<a href=\"".MAIN_HOME."?board=".$list['hero_table']."&view=write2&action=update&page=".$_GET['page']."&hero_idx=".$new_res['hero_idx']."\"><img src='/img/front/board/icon_update.png' alt='�ı����' /></a>";
                                            $review_button .= '<a href="javascript:;" onclick="confirmAction(\'�����Ͻðڽ��ϱ�?\', \''.MAIN_HOME.'?board='.$list['hero_table'].'&view=action_delete&action=delete&idx='.$new_res['hero_idx'].'&page='.$_GET['page'].'\', parent)"><img src="/img/front/board/icon_delete.png" alt="�ı����" /></a>';
                                        }
                                    }
								}
                                //��÷�� ��ǥ ������ <= ���� && ��÷�� ��ǥ ������ >= ����
								elseif(substr($list["hero_today_02_01"],0,10)<=$today && substr($list["hero_today_02_02"],0,10)>=$today){
									$progress = "������ ��ǥ";
//									$href = "/main/index.php?board=".$list['hero_table']."&view=step_03&idx=".$list['hero_idx'];
                                    //250320 musign ���� YDH - ������� ���о��� ü��� �������� �̵�
                                    $href = "/main/index.php?board=".$list['hero_table']."&view=view&idx=".$list['hero_idx'];
									if($list["lot_01"]==1)		$reviwer_tf = "<span class='mu_bar'>[ü��� ����]</span>";

                                    $review_button  = '';
								}
								else{
									$progress = "ü��� ��û";
									$href = "/main/index.php?board=".$list['hero_table']."&view=view&idx=".$list['hero_idx'];

                                    $review_button  = '';
								}

                                /* class ��Ƽ�� ��� type1, ������ type2, ��Ƽ type3 �־��ּ��� */
                                if($list['hero_table'] == 'group_04_05'){
                                    $type = "<p class='ribon'><span class='type3'>������ ��Ƽ&������ Ŭ��</span> ".$reviwer_tf."</p>";
                                }else if($list['hero_table'] == 'group_04_06'){
                                    $type = "<p class='ribon'><span class='type1'>�����̾� ��Ƽ Ŭ��</span> ".$reviwer_tf."</p>";
                                }else if($list['hero_table'] == 'group_04_28'){
                                    $type = "<p class='ribon'><span class='type2'>�����̾� ������ Ŭ��</span> ".$reviwer_tf."</p>";
                                }

                                $thumb = "";
                                if($list['hero_thumb'] != ''){
                                    $thumb = "<img src='".$list['hero_thumb']."'>";
                                }else {
                                    $thumb = "<img src='/img/front/main/tab01.webp'>";
                                }

								$mission_title  = "<a href='".$href."' class='board_title'>".$thumb."<div class='txt_bx'>".$type."<p class='tit t_l'>".cut($list['hero_title'],$cut_title_name)."</p></div></a>";
								?>
								<tr>
									<td><?=$num;?></td>
									<td><?=$list['hero_kind']?></td>
									<td class="mission_td">
										<!-- [����] �����, ī�װ� -->
										<?=$mission_title?>
									</td>
									<td><?=$progress?></td>
									<td><?=date( "Y.m.d", strtotime($list['hero_today']));?></td>
                                    <?
                                    if($_SERVER['REMOTE_ADDR'] == '121.167.104.240'){
                                        if($_GET['lot_01'] == 1){
                                            echo '<td class="review_btn">'.$review_button.'</td>';
                                        }
                                    }
                                    ?>
								</tr>
							<?}?>
						</tbody>
					</table>
					<div class="btngroup">
						<div class="paging">
							<? echo page($total_data,$list_page,$page_per_list,$_GET['page'],$next_path);?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
