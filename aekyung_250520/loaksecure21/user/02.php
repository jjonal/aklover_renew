<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################

if(strcmp($_POST['gender'], '')){
	$search .= ' and hero_sex = '.$_POST['gender'];
	$search_next .= '&gender='.$_POST['gender'];
}else if(strcmp($_GET['gender'], '')){
	$search .= ' and hero_sex = '.$_GET['gender'];
	$search_next .= '&gender='.$_GET['gender'];
}



if(strcmp($_POST['age'], '')){
	if($_POST['age']=='6'){
		$search .= ' and left(YEAR(CURDATE())-left(hero_jumin,4)+1,1) >= '.$_POST['age'].'';
		$search_next .= '&age='.$_POST['age'];
	}else{
		$search .= ' and left(YEAR(CURDATE())-left(hero_jumin,4)+1,1) = '.$_POST['age'].'';
		$search_next .= '&age='.$_POST['age'];
	}
}else if(strcmp($_GET['age'], '')){
	if($_GET['age']=='6'){
		$search .= ' and left(YEAR(CURDATE())-left(hero_jumin,4)+1,1) >= '.$_GET['age'].'';
		$search_next .= '&age='.$_GET['age'];
	}else{
		$search .= ' and left(YEAR(CURDATE())-left(hero_jumin,4)+1,1) = '.$_GET['age'].'';
		$search_next .= '&age='.$_GET['age'];
	}
}


if(strcmp($_POST['grade'], '')){
	$search .= ' and hero_level = '.$_POST['grade'];
	$search_next .= '&grade='.$_POST['grade'];
}else if(strcmp($_GET['grade'], '')){
	$search .= ' and hero_level = '.$_GET['grade'];
	$search_next .= '&grade='.$_GET['grade'];
}



if(strcmp($_POST['content'], '')){
	$search .= " and hero_memo_01 = '".$_POST['content']."'";
	$search_next .= '&content='.$_POST['content'];
}else if(strcmp($_GET['content'], '')){
	$search .= " and hero_memo_01 = '".$_GET['content']."'";
	$search_next .= '&content='.$_GET['content'];
}



if(strcmp($_POST['kewyword'], '')){
    $search .= ' and '.$_POST['select'].' like \'%'.$_POST['kewyword'].'%\'';
    $search_next .= '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
}else if(strcmp($_GET['kewyword'], '')){
    $search .= ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
    $search_next .= '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
}

######################################################################################################################################################
$sql = "select * from member where hero_level<='".$_SESSION['temp_level']."' ".$search." ";
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
<style>
	.t_list thead th { letter-spacing: -1px; } 
</style>

						<div class="searchbox" style="margin-top: 20px;background: #f2f2f2;width: 800px;border: 1px solid #D7D7D7;border-radius: 10px;">
						  <div class="wrap_1" style="padding:11px 20px;">
                            <form action="<?=PATH_HOME.'?'.get('page');?>" method="POST" >
                            	<span style="font-size:12px;font-weight:800">Search</span>&nbsp;&nbsp;&nbsp;
                            	<select name="gender" id="">
                            		<option value=''>����</option>
                            		<option value='0' <?if(!strcmp($_REQUEST['gender'], '0')){echo ' selected';}else{echo '';}?>>����</option>
                            		<option value='1' <?if(!strcmp($_REQUEST['gender'], '1')){echo ' selected';}else{echo '';}?>>����</option>
                            	</select>
                            	&nbsp;
                            	<select name="age" id="" style="width:70px;">
                            		<option value='' >����</option>
                            		<option value='1' <?if(!strcmp($_REQUEST['age'], '1')){echo ' selected';}else{echo '';}?>>10��</option>
                            		<option value='2' <?if(!strcmp($_REQUEST['age'], '2')){echo ' selected';}else{echo '';}?>>20��</option>
                            		<option value='3' <?if(!strcmp($_REQUEST['age'], '3')){echo ' selected';}else{echo '';}?>>30��</option>
                            		<option value='4' <?if(!strcmp($_REQUEST['age'], '4')){echo ' selected';}else{echo '';}?>>40��</option>
                            		<option value='5' <?if(!strcmp($_REQUEST['age'], '5')){echo ' selected';}else{echo '';}?>>50��</option>
                            		<option value='6' <?if(!strcmp($_REQUEST['age'], '6')){echo ' selected';}else{echo '';}?>>60�� �̻�</option>
                            	</select>
                            	<select name="content" id="" style="width:70px;">
                            		<option value=''>������</option>
                            		<option value='��' <?if(!strcmp($_REQUEST['content'], '��')){echo ' selected';}else{echo '';}?>>��</option>
                            		<option value='��' <?if(!strcmp($_REQUEST['content'], '��')){echo ' selected';}else{echo '';}?>>��</option>
                            		<option value='��' <?if(!strcmp($_REQUEST['content'], '��')){echo ' selected';}else{echo '';}?>>��</option>
                            	</select>
                            	
                            	&nbsp;
                            	���&nbsp;<input type="text" placeholder="����(���ڴ�:98)" name="grade" value="<?=$_REQUEST['grade'] ?>" style="width:90px;"/>
                            	&nbsp;
                            	
                                <select name="select" id="">
                                  <option value="hero_nick"<?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>�г���</option>
                                  <option value="hero_name"<?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>����</option>
                                  <option value="hero_id"<?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>���̵�</option>
                                  <option value="hero_hp"<?if(!strcmp($_REQUEST['select'], 'hero_hp')){echo ' selected';}else{echo '';}?>>�޴���</option>
                                  <option value="hero_mail"<?if(!strcmp($_REQUEST['select'], 'hero_mail')){echo ' selected';}else{echo '';}?>>�̸���</option>
                                  <option value="hero_memo"<?if(!strcmp($_REQUEST['select'], 'hero_memo')){echo ' selected';}else{echo '';}?>>���</option>
                                  <option value="hero_memo_01"<?if(!strcmp($_REQUEST['select'], 'hero_memo_01')){echo ' selected';}else{echo '';}?>>������</option>
                                </select>
                                <input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];?>" class="kewyword" style="width:210px;" placeholder="�޴��� �˻� �� ex) 010-1234-1234">
                                <input type="image" src="../image/bbs/btn_search.gif" alt="�˻�" class="bd0">
                            </form>
                            </div>
                        </div>



                        <table class="t_list">
                            
                            <thead>
                                <tr>
                                    <td align="center" style="padding:10px">
                                        <a href="<?=PATH_HOME.'?'.get('order','');?>">�ʱ�����</a>
                                        <a href="<?=PATH_END;?>user/print.php" target="_black"><font color="red"><b>����Ʈ</b></font></a>
                                    </td>
                                </tr>
                                <tr>
                                    <!--<th width="3%" class="first"><input type="checkbox" name="check_all" onclick="check_All();"/></th>-->
<!--                                    <th width="5%">��ȣ</th>-->
                                    <th style="width:3%;"><a href="<?=PATH_HOME.'?'.get('order','order=hero_id desc').$search_next;?>">��</a> ���̵� <a href="<?=PATH_HOME.'?'.get('order','order=hero_id asc').$search_next;?>">��</a></th>
                                    <th style="width:3%;"><a href="<?=PATH_HOME.'?'.get('order','order=hero_name desc').$search_next;?>">��</a> �� �� <a href="<?=PATH_HOME.'?'.get('order','order=hero_name asc').$search_next;?>">��</a></th>
                                    <th style="width:3%;"><a href="<?=PATH_HOME.'?'.get('order','order=hero_nick desc').$search_next;?>">��</a> �г��� <a href="<?=PATH_HOME.'?'.get('order','order=hero_nick asc').$search_next;?>">��</a></th>
                                    <th style="width:2%;"><a href="<?=PATH_HOME.'?'.get('order','order=hero_jumin desc').$search_next;?>">��</a> ���� <a href="<?=PATH_HOME.'?'.get('order','order=hero_jumin asc').$search_next;?>">��</a></th>
                                    <th style="width:3%;"><a href="<?=PATH_HOME.'?'.get('order','order=hero_sex desc').$search_next;?>">��</a> ���� <a href="<?=PATH_HOME.'?'.get('order','order=hero_sex asc').$search_next;?>">��</a></th>
                                    <th style="width:4%;">����ó</th>
                                    <th style="width:2%;">�����ȣ</th>
                                    <th style="width:6%;">�ּ�</th>
                                    <th style="width:7%;">��α�</th>
                                    <th style="width:5%;">�̸���</th>
                                    <th style="width:3%;"><a href="<?=PATH_HOME.'?'.get('order','order=hero_excuse_check desc').$search_next;?>">��</a> ���԰�� <a href="<?=PATH_HOME.'?'.get('order','order=hero_excuse_check asc').$search_next;?>">��</a></th>
                                    <th style="width:2%;"><!--<a href="<?=PATH_HOME.'?'.get('order','order=hero_nick desc').$search_next;?>">��</a> -->��õ��<!-- <a href="<?=PATH_HOME.'?'.get('order','order=hero_nick asc').$search_next;?>">��</a>--></th>

                                    <th style="width:3%;"><a href="<?=PATH_HOME.'?'.get('order','order=hero_point desc').$search_next;?>">��</a> ������Ʈ <a href="<?=PATH_HOME.'?'.get('order','order=hero_point asc').$search_next;?>">��</a></th>
                                    <th style="width:3%;"><a href="<?=PATH_HOME.'?'.get('order','order=possible_point desc').$search_next;?>">��</a> ��������Ʈ <a href="<?=PATH_HOME.'?'.get('order','order=possible_point asc').$search_next;?>">��</a></th>
                                    <th style="width:2%;"><a href="<?=PATH_HOME.'?'.get('order','order=hero_level desc').$search_next;?>">��</a> ��� <a href="<?=PATH_HOME.'?'.get('order','order=hero_level asc').$search_next;?>">��</a></th>
                                    <th style="width:3%;"><a href="<?=PATH_HOME.'?'.get('order','order=hero_oldday desc').$search_next;?>">��</a> ����� <a href="<?=PATH_HOME.'?'.get('order','order=hero_oldday asc').$search_next;?>">��</a></th>
                                    <th style="width:2%;"><a href="<?=PATH_HOME.'?'.get('order','order=hero_use desc').$search_next;?>">��</a> Ż�� <a href="<?=PATH_HOME.'?'.get('order','order=hero_use asc').$search_next;?>">��</a></th>
	<?if(!strcmp($_SESSION['temp_level'], '100')){?>
                                    <th>���</th>
	<?}?>
                                    <th style="width:2%;">��α� �湮�ڼ�</th>
                                    <th style="width:3%;"><a href="<?=PATH_HOME.'?'.get('order','order=hero_memo_01 desc').$search_next;?>">��</a> ������ <a href="<?=PATH_HOME.'?'.get('order','order=hero_memo_01 asc').$search_next;?>">��</a></th>
                                    <th style="width:3%;">����</th>
                                </tr>
                            </thead>
                            <tbody>
                        <?
                        if(!strcmp($_GET['order'], '')){
                            $view_order = ' order by hero_oldday desc';
                        }else{
                            $view_order = ' order by '.$_GET['order'];
                        }
                        $sql = "select A.*, (A.hero_point-ifnull(B.total_use_point,0)) as possible_point from member A LEFT OUTER JOIN (select hero_code, SUM(hero_order_point) as total_use_point from order_main group by hero_code) as B on A.hero_code=B.hero_code ";
                        $sql .= "where A.hero_level<='".$_SESSION['temp_level']."' ".$search.$view_order." limit ".$start.",".$list_page;
                        //echo $sql;
//                        $sql = 'select * from member where hero_level<=\''.$_SESSION['temp_level'].'\' and hero_use=\'0\';';//desc
                        sql($sql);
                        
                        
                        while($list                             = @mysql_fetch_assoc($out_sql)){
                       
	                        $point = $list['hero_point'];
	                        //$possible_point = $point - $list['total_use_point'];
	                        
	                        if(!strcmp($list['hero_use'], '0')){
	                            $use = '';
	                        }else if(!strcmp($list['hero_use'], '1')){
	                            $use = '<font color=red>Ż��</font>';
	                        }
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
                                    <td><?=$point;?></td>
                                    <td><?=$list['possible_point']?></td>
                                    <td><?=$list['hero_level'];?></td>
                                    <td><?=date( "Y-m-d", strtotime($list['hero_oldday']));?></td>
                                    <td><?=$use?></td>
									 <?if(!strcmp($_SESSION['temp_level'], '100')){?>
   	                                	<td><?=$list['hero_pw'];?></td>
									<?}?>
                                    <td><?=$list['hero_memo'];?></td>
                                    <td><?=$list['hero_memo_01'];?></td>
                                    <td><a href="#" onclick="location.href='<?=url('PATH_HOME||board||'.$board.'||&view=02_00&idx='.$_GET['idx'].'&next_idx='.$list['hero_idx']);?>'" style="cursor:pointer;" class="btn_blue">��������</a></td>
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