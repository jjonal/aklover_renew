<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
if(strcmp($_REQUEST['kewyword'], '')){
	if(!strcmp($_REQUEST['select'], 'hero_all')){
		$search = ' ( hero_nick like \'%'.$_REQUEST['kewyword'].'%\' or hero_id like \'%'.$_REQUEST['kewyword'].'%\' or';
		$search .= ' hero_name like \'%'.$_REQUEST['kewyword'].'%\' or hero_new_name like \'%'.$_REQUEST['kewyword'].'%\') and ';
		$search_next = '&select='.$_REQUEST['select'].'&kewyword='.$_REQUEST['kewyword'];
	}else{
		$search = ' '.$_REQUEST['select'].' like \'%'.$_REQUEST['kewyword'].'%\' and ';
		$search_next = '&select='.$_REQUEST['select'].'&kewyword='.$_REQUEST['kewyword'];
	}
}
######################################################################################################################################################
$sql = 'select * from mission_review where '.$search.' hero_old_idx=\''.$_GET['hero_idx'].'\'';
sql($sql);
$total_data = @mysql_num_rows($out_sql);

/////////// no ���� 20140509
$i=$total_data;

######################################################################################################################################################
$list_page=50;
$page_per_list=5;

if(!strcmp($_GET['page'], '')){
	$page = '1';
}else{
	$page = $_GET['page'];
	
	/////////// no ���� 20140509
	$i = $i-($page-1)*$list_page;
}

$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board'].$search_next.'&idx='.$_GET['idx'].'&view='.$_GET['view'].'&hero_idx='.$_GET['hero_idx'];
######################################################################################################################################################
if(!strcmp($_GET['action'], 'ok')){
    $sql = 'UPDATE mission_review SET lot_01=\'1\' WHERE hero_idx = \''.$_GET['new_idx'].'\';'.PHP_EOL;
    @mysql_query($sql);
    msg('���� �Ǿ����ϴ�.','location.href="'.PATH_HOME.'?'.get('action||new_idx','').'"');
    exit;
}else if(!strcmp($_GET['action'], 'no')){
    $sql = 'UPDATE mission_review SET lot_01=\'0\' WHERE hero_idx = \''.$_GET['new_idx'].'\';'.PHP_EOL;
    @mysql_query($sql);
    msg('��� �Ǿ����ϴ�.','location.href="'.PATH_HOME.'?'.get('action||new_idx','').'"');
    exit;
}
$level_old_sql = $sql.' order by hero_table,hero_today desc limit '.$start.','.$list_page.';';
$out_level_old_sql = mysql_query($level_old_sql);
$level_old_list                             = @mysql_fetch_assoc($out_level_old_sql);

$level_sql = 'select * from hero_group where hero_board=\''.$level_old_list['hero_table'].'\';';//desc<=
$out_level_sql = mysql_query($level_sql);
$level_list                             = @mysql_fetch_assoc($out_level_sql);

$mission_sql = 'select * from mission where hero_table=\''.$level_old_list['hero_table'].'\' and hero_idx=\''.$_GET['hero_idx'].'\';';//desc<=
$out_mission_sql = mysql_query($mission_sql);
$mission_list                             = @mysql_fetch_assoc($out_mission_sql);

?>
						<center>
							<div style="margin:20px;">
								<font color="red" style="margin:20px;font-size: 20px;font-weight: 800;"> ����� ��û�� </font>
								<a href="<?=PATH_HOME.'?'.get('view||hero_idx')?>" class="btn_blue2">���</a>
							</div>
							<div class="searchbox" style="margin:20px;">
                            <div class="wrap_1">
                            <form action="<?=PATH_HOME.'?'.get('page');?>" method="POST" >
                                <select name="select" id="" style="width:70px;">
                                  <option value="hero_nick"<?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>�г���</option>
                                  <option value="hero_id"<?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>���̵�</option>
                                  <option value="hero_name"<?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>�̸�</option>
                                  <option value="hero_new_name"<?if(!strcmp($_REQUEST['select'], 'hero_new_name')){echo ' selected';}else{echo '';}?>>�޴��̸�</option>
								  <option value="hero_all"<?if(!strcmp($_REQUEST['select'], 'hero_all')){echo ' selected';}else{echo '';}?>>�г���+���̵�+�̸�+�޴��̸�</option>
                                <input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];?>" class="kewyword">
                                <input type="image" src="../image/bbs/btn_search.gif" alt="�˻�" class="bd0">
								</form>
								</div>
							</div>
                        </center>

                       
<style>
/*
.t_list{white-space:nowrap;}
.t_list td,tr,th{white-space:nowrap;}
*/
</style>
                        <table class="t_list">
                            <thead>
                                <tr>
									<th style="padding:10px;">
                                        ī�װ� : <font color="blue" style="font-weight:800;">
													<?=$level_list['hero_title'];?>
												    </font><br>
										���� : <font color="blue" style="font-weight:800;"><?=$mission_list['hero_title'];?></font><br>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>
                                        <table class="t_list" style="table-layout:fixed;word-wrap:break-word; word-break:break-all;">
                                            <thead>
                                                <tr>
													<th width="2%">��û��ȣ</th>
                                                    <th width="3%"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_01_02&table_type=hero_id&table_name=���̵�")?>">���̵�</a></th>
                                                    <th width="3%"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_01_02&table_type=hero_nick&table_name=�г���")?>">�г���</a></th>
                                                    <th width="3%"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_01_02&table_type=hero_name&table_name=�̸�")?>">�̸�</a></th>
                                                    <th width="3%"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_01_02&table_type=hero_new_name&table_name=�޴��̸�")?>">�޴��̸�</a></th>
                                                    <th width="3%">���ɴ�</th>
                                                    <th width="6%"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_01_02&table_type=hero_hp&table_name=��ȭ��ȣ")?>">��ȭ��ȣ</a></th>
                                                    <th width="3%"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_01_02&table_type=hero_address&table_name=�����ôº��ּ�")?>">�����ȣ</a></th>
                                                    <th width="10%"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_01_02&table_type=hero_address&table_name=�����ôº��ּ�")?>">�����ôº��ּ�</a></th>
                                                    <th width="20%"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_01_02&table_type=hero_03&table_name=��û�ʼ�����")?>">��û�ʼ�����</a></th>
                                                    <th width="9%"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_01_02&table_type=hero_01&table_name=url")?>">url</a></th>

                                                    <th width="3%">�湮�ڼ�</th>
                                                    <th width="3%">������</th>
                                                    <th width="5%">���</th>
                                                    <th width="5%">���</th>
                                                    <th width="5%">�����н�</th>
                                                    <th width="5%">�����</th>
                                                    <th width="100px">����</th>

                                                </tr>
                                            </thead>
                                            <tbody>
<?
                        $sql = $sql.' order by hero_table,hero_today desc limit '.$start.','.$list_page.';';
                        sql($sql);
                        while($list                             = @mysql_fetch_assoc($out_sql)){

                        if(!strcmp($list['lot_01'], '1')){
                            $lot_01 = '���� ����������';
                        }else{
                            $lot_01 = '';
                        }

                        $member_sql = "select * from member where hero_code='".$list['hero_code']."';";
                        $out_member_sql = @mysql_query($member_sql);
                        $member_list                             = @mysql_fetch_assoc($out_member_sql);
	                        
                        	if($member_list['hero_jumin'])               	$age = date('Y')-substr($member_list['hero_jumin'],0,4)+1;
                        	else											$age = '';

                        ?>
                                            <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
												<td><?=$list['hero_number']?></td>  
                                                <td><?=nl2br($list['hero_id']);?></td>
                                                <td><?=nl2br($list['hero_nick']);?></td>
                                                <td><?=nl2br($list['hero_name']);?></td>
                                                <td><?=nl2br($list['hero_new_name']);?></td>
                                                <td><?=$age?></td>
                                                <td><?=nl2br($list['hero_hp_01']);?>-<?=nl2br($list['hero_hp_02']);?>-<?=nl2br($list['hero_hp_03']);?></td>
                                                <td><?=nl2br($list['hero_address_01']);?></td>
                                                <td><?=nl2br($list['hero_address_02']);?> <?=nl2br($list['hero_address_03']);?></td>
                                                <td>
                                                <?php 
                                                	if($list['hero_03'])	$hero_03 = explode("/////",$list['hero_03']);
                                                	foreach ($hero_03 as $value){
                                                ?>
                                                		<?=$value?><br/>
                                                <?php }?>
                                                </td>
                                                <td><?=$list['hero_01'];?></td>

                                                <td><?=$member_list['hero_memo'];?></td>
                                                <td><?=$member_list['hero_memo_01'];?></td>
                                                <td><?=$member_list['hero_memo_02'];?></td>
                                                <td><?=$member_list['hero_memo_03'];?></td>
                                                <td><?=$list['hero_superpass'];?></td>
                                                <td><?=date( "Y-m-d", strtotime($list['hero_today']));?></td>
                                                <td><?=$lot_01;?><br>
                                                    <a href="#" onclick="location.href='<?=PATH_HOME.'?'.get('action||new_idx','action=ok&new_idx='.$list['hero_idx']);?>'" class="btn_blue2">����</a>
                                                    <a href="#" onclick="location.href='<?=PATH_HOME.'?'.get('action||new_idx','action=no&new_idx='.$list['hero_idx']);?>'" class="btn_blue2">���</a>

                                                </td>
                                            </tr>
                        <?
						 $i--;
                        }
                        ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            </tbody>
                        </table>

                        <div style="width:100%; text-align:center; margin-top:20px;">
<? include_once PATH_INC_END.'page.php';?>
                        </div>
<? //include_once BOARD_INC_END.'search.php';?>
                        