<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
if(strcmp($_POST['kewyword'], '')){
    $search .= ' and '.$_POST['select'].' like \'%'.$_POST['kewyword'].'%\'';
    $search_next .= '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
}else if(strcmp($_GET['kewyword'], '')){
    $search .= ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
    $search_next .= '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
}

if(strcmp($_POST['hero_today_start'], '') && strcmp($_POST['hero_today_end'], '')){
	$search .= " and date_format(A.hero_out_date,'%Y-%m-%d') between '".$_POST['hero_today_start']."' AND '".$_POST['hero_today_end']."'";
	$search_next .= '&hero_today_start='.$_POST['hero_today_start'].'&hero_today_end='.$_POST['hero_today_end'];
}else if(strcmp($_GET['hero_today_start'], '') && strcmp($_GET['hero_today_end'], '')){
	$search .= " and date_format(A.hero_out_date,'%Y-%m-%d') between '".$_GET['hero_today_start']."' AND '".$_GET['hero_today_end']."'";
	$search_next .= '&hero_today_start='.$_GET['hero_today_start'].'&hero_today_end='.$_GET['hero_today_end'];
}

######################################################################################################################################################
$sql = "select B.*, A.hero_out_date from member A LEFT JOIN member_backup B ON A.hero_code=B.hero_code where A.hero_use='2' ".$search." ";
//echo $sql."<br>";
sql($sql);
$total_data = @mysql_num_rows($out_sql);
######################################################################################################################################################
$list_page=50;
$page_per_list=10;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board'].$search_next.'&idx='.$_GET['idx'].'&order='.$_GET['order'];
######################################################################################################################################################
//echo $search_next;
?>
<link type='text/css' href='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.css' rel='stylesheet' />
<script type="text/javascript" src="<?=DOMAIN_END?>cal/jquery.min.js"></script>
<script type='text/javascript' src='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.min.js'></script> 
<style>
	.t_list thead th { letter-spacing: -1px; } 
</style>

						<div class="searchbox" style="margin-top: 20px;background: #f2f2f2;width: 800px;border: 1px solid #D7D7D7;border-radius: 10px;">
						  <div class="wrap_1" style="padding:11px 20px;">
                            <form action="<?=PATH_HOME.'?'.get('page');?>" method="POST" >
                            	<span style="font-size:12px;font-weight:800">Search</span>&nbsp;&nbsp;&nbsp;
        
                            	<input type="text"  id="sdate1" name="hero_today_start"  value="<?=$_REQUEST['hero_today_start']?>" style="text-align: center" /> ~ 
		                		<input type="text"  id="edate1" name="hero_today_end"  value="<?=$_REQUEST['hero_today_end']?>" style="text-align: center" />
                            
                                <select name="select" id="">
                                  <option value="B.hero_nick"<?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>�г���</option>
                                  <option value="B.hero_name"<?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>����</option>
                                  <option value="B.hero_id"<?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>���̵�</option>
                                </select>
                                
                                <input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];?>" class="kewyword">
                                <input type="image" src="../image/bbs/btn_search.gif" alt="�˻�" class="bd0">
                                <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                (�޸�ȸ������� ����)
                            </form>
                            <script>
								$(function() {      // window.onload ��� ���� ��ũ��Ʈ
									dateclick2();
								});
								function dateclick2(){
									var dates = $("#sdate1, #edate1").datepicker({
										monthNames: ['�� 1��','�� 2��','�� 3��','�� 4��','�� 5��','�� 6��','�� 7��','�� 8��','�� 9��','�� 10��','�� 11��','�� 12��'],
										dayNamesMin: ['��', '��', 'ȭ', '��', '��', '��', '��'],
										defaultDate: null,
										showMonthAfterYear:true,
										dateFormat: 'yy-mm-dd',
										onSelect: function( selectedDate ) {
											var option = this.id == "sdate1" ? "minDate" : "maxDate",
											instance = $( this ).data( "datepicker" ),
											date = $.datepicker.parseDate(
												instance.settings.dateFormat ||
												$.datepicker._defaults.dateFormat,
												selectedDate, instance.settings );
											dates.not( this ).datepicker( "option", option, date );
										}
									});
								};
							</script>
                            </div>
                        </div>
                        
                        <div style="float:right">�� �ο� : <span style="color:#f00"><?=number_format($total_data)?></span>��</div>
                        <div style="clear:both"></div>
                        
                        <table class="t_list">
                            
                            <thead>
                                <tr>
                                    <!--<th width="3%" class="first"><input type="checkbox" name="check_all" onclick="check_All();"/></th>-->
<!--                                    <th width="5%">��ȣ</th>-->
                                    <th style="width:3%;"><a href="<?=PATH_HOME.'?'.get('order','order=B.hero_id desc').$search_next;?>">��</a> ���̵� <a href="<?=PATH_HOME.'?'.get('order','order=B.hero_id asc').$search_next;?>">��</a></th>
                                    <th style="width:3%;"><a href="<?=PATH_HOME.'?'.get('order','order=B.hero_name desc').$search_next;?>">��</a> �� �� <a href="<?=PATH_HOME.'?'.get('order','order=B.hero_name asc').$search_next;?>">��</a></th>
                                    <th style="width:3%;"><a href="<?=PATH_HOME.'?'.get('order','order=B.hero_nick desc').$search_next;?>">��</a> �г��� <a href="<?=PATH_HOME.'?'.get('order','order=B.hero_nick asc').$search_next;?>">��</a></th>
                                    <th style="width:2%;"><a href="<?=PATH_HOME.'?'.get('order','order=B.hero_jumin desc').$search_next;?>">��</a> ���� <a href="<?=PATH_HOME.'?'.get('order','order=B.hero_jumin asc').$search_next;?>">��</a></th>
                                    <th style="width:3%;"><a href="<?=PATH_HOME.'?'.get('order','order=B.hero_sex desc').$search_next;?>">��</a> ���� <a href="<?=PATH_HOME.'?'.get('order','order=B.hero_sex asc').$search_next;?>">��</a></th>
                                    <th style="width:4%;">����ó</th>
                                    <th style="width:2%;">�����ȣ</th>
                                    <th style="width:6%;">�ּ�</th>
                                    <th style="width:7%;">��α�</th>
                                    <th style="width:5%;">�̸���</th>
                                    <th style="width:3%;"><a href="<?=PATH_HOME.'?'.get('order','order=B.hero_excuse_check desc').$search_next;?>">��</a> ���԰�� <a href="<?=PATH_HOME.'?'.get('order','order=B.hero_excuse_check asc').$search_next;?>">��</a></th>
                                    <th style="width:2%;">��õ��</th>

                                   
                                    <th style="width:3%;"><a href="<?=PATH_HOME.'?'.get('order','order=B.hero_oldday desc').$search_next;?>">��</a> ����� <a href="<?=PATH_HOME.'?'.get('order','order=B.hero_oldday asc').$search_next;?>">��</a></th>
                                    <th style="width:5%;"><a href="<?=PATH_HOME.'?'.get('order','order=A.hero_out_date desc').$search_next;?>">��</a> �޸�ȸ������� <a href="<?=PATH_HOME.'?'.get('order','order=A.hero_out_date asc').$search_next;?>">��</a></th>
                                    <th style="width:3%;">����</th>
                                </tr>
                            </thead>
                            <tbody>
                        <?
                        if(!strcmp($_GET['order'], '')){
                            $view_order = ' order by A.hero_out_date desc';
                        }else{
                            $view_order = ' order by '.$_GET['order'];
                        }
                        $sql = "select date_format(A.hero_out_date,'%Y-%m-%d') as hero_out_date_normal, B.* from member A LEFT JOIN member_backup B ON A.hero_code=B.hero_code";
                        $sql .= " where A.hero_use='2' ".$search.$view_order." limit ".$start.",".$list_page;
                        //echo $sql;
                        sql($sql);
                        
                        
                        while($list                             = @mysql_fetch_assoc($out_sql)){
                       
	                      
	                        
	                        if(!strcmp($list['hero_sex'], '1')){
	                            $sex = "����";
	                        }else if(!strcmp($list['hero_sex'], '0')){
	                            if(!strcmp($list['hero_info_di'], '')){
	                                $sex = "������";
	                            }else{
	                                $sex = "����";
	                            }
	                        }else{
	                            $sex = "������";
	                        }
							if($list['area']) {
								$excuse_check = $list['area'];
							}else {
								if(!strcmp($list['hero_excuse_check'], '0')){
									$excuse_check="�Ź�";
								}else if(!strcmp($list['hero_excuse_check'], '1')){
									$excuse_check="����";
								}else if(!strcmp($list['hero_excuse_check'], '2')){
									$excuse_check="��α�";
								}else if(!strcmp($list['hero_excuse_check'], '3')){
									$excuse_check="ī��";
								}else if(!strcmp($list['hero_excuse_check'], '4')){
									$excuse_check="����";
								}else if(!strcmp($list['hero_excuse_check'], '5')){
									$excuse_check="��Ÿ<br>".$list['hero_excuse_path'];
								}
							}
								
	                        
	                        if(!strcmp($list['hero_jumin'], '')){
	                            $jumin = "������";
	                        }else if(!strcmp($list['hero_jumin'], '00000000')){
	                            $jumin = "������";
	                        }else{
	                            $jumin = Y-substr($list['hero_jumin'],0,4)+1;
	                        }
	                        ?>
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
<!--                                <td><?=in($list['hero_idx']);?></td>-->
                                    <td><?=$list['hero_id'];?></td>
                                    <td><?=name_masking($list['hero_name']);?></td>
                                    <td><?=$list['hero_nick'];?></td>

                                    <td><?=$jumin;?></td>
                                    <td><?=$sex;?></td>
                                   
                                    <td><?=phone_masking($list['hero_hp']);?></td>
                                    <td><?=$list['hero_address_01'];?></td>
                                    <td><?=$list['hero_address_02'];?> <?=$list['hero_address_03'];?></td>
                                    <td>
                                    	<? echo ($list['hero_blog_00']) ? $list['hero_blog_00']."<br>" : '';?>
                                    	<? echo ($list['hero_blog_01']) ? $list['hero_blog_00']."<br>" : '';?>
                                    	<? echo ($list['hero_blog_02']) ? $list['hero_blog_00']."<br>" : '';?>
                                    	<? echo ($list['hero_blog_03']) ? $list['hero_blog_00']."<br>" : '';?>
                                    	<? echo ($list['hero_blog_04']) ? $list['hero_blog_00']."<br>" : '';?>
                                    	<? echo ($list['hero_blog_05']) ? $list['hero_blog_00']."<br>" : '';?>
                                    </td>
                                    <td><?=$list['hero_mail'];?></td>
                                    <td><?=$excuse_check;?></td>
									<td><?=$list['hero_user']; ?></td>
                                    <td><?=date( "Y-m-d", strtotime($list['hero_oldday']));?></td>
                                    <td><?=$list['hero_out_date_normal'];?></td>
                                    <td><a href="#" onclick="location.href='<?=url('PATH_HOME||board||'.$board.'||&view=restMemberView&idx='.$_GET['idx'].'&next_idx='.$list['hero_idx']);?>'" style="cursor:pointer;" class="btn_blue">��������</a></td>
                                </tr>
                                
                        <?
                        }
                        ?>
                            </tbody>
                        </table>
                        <div style="width:100%; text-align:center; margin-top:20px;">
<? include_once PATH_INC_END.'page.php';?>
                        </div>
<? //include_once BOARD_INC_END.'search.php';?>
                        
                        <?php 
                        //echo $sql;
                        ?>