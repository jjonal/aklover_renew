<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################

//2014-05-15 �˻��� �߰�
if(strcmp($_POST['kewyword'], '')){
	if($_POST['select']=='hero_all'){
		$search = ' and ( hero_nick like \'%'.$_POST['kewyword'].'%\' or hero_name like \'%'.$_POST['kewyword'].'%\' or hero_id like \'%'.$_POST['kewyword'].'%\' or hero_memo like \'%'.$_POST['kewyword'].'%\')';
		$search_next = '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
	}else{
		$search = ' and '.$_POST['select'].' like \'%'.$_POST['kewyword'].'%\'';
	    $search_next = '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
	}
}else if(strcmp($_GET['kewyword'], '')){
    if($_GET['select']=='hero_all'){
		$search = ' and ( hero_nick like \'%'.$_GET['kewyword'].'%\' or hero_name like \'%'.$_GET['kewyword'].'%\' or hero_id like \'%'.$_GET['kewyword'].'%\' or hero_memo like \'%'.$_GET['kewyword'].'%\')';
		$search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
	}else{
		$search = ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
		$search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
	}
}

######################################################################################################################################################
$sql = 'select * from member where hero_level<=\''.$_SESSION['temp_level'].'\' '.$search.' ';
sql($sql);
$total_data = @mysql_num_rows($out_sql);
######################################################################################################################################################
$list_page=20;

//2014-05-15 �ѹ���
if($_GET['page']){
	$j=$total_data-(($_GET['page']-1)*$list_page);
}else{
	$j=$total_data;
}

$page_per_list=10;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board'].$search_next.'&idx='.$_GET['idx'].'&order='.$_GET['order'];
######################################################################################################################################################
if(!strcmp($_GET['type'], 'new')){
    $idx = $_REQUEST['next_idx'];
    $sql_one_update = 'hero_out=\'\', hero_use=\'0\'';
    $msg = '����';
    $sql = 'UPDATE member SET '.$sql_one_update.' WHERE hero_idx = \''.$idx.'\';'.PHP_EOL;
    @mysql_query($sql);
    $sql = 'UPDATE admin SET '.$sql_one_update.' WHERE hero_idx = \''.$idx.'\';'.PHP_EOL;
    @mysql_query($sql);
    msg($msg.' �Ǿ����ϴ�.','location.href="'.PATH_HOME.'?'.get('type','').'"');
    exit;
}
if(!strcmp($_GET['type'], 'drop')){
    $idx = $_REQUEST['next_idx'];
    $sql_one_update = 'hero_out=\'�����ڿ� ���� Ż�� �Ǿ����ϴ�.\', hero_point=\'0\', hero_use=\'1\'';
    $msg = 'Ż��';
    $sql = 'UPDATE member SET '.$sql_one_update.' WHERE hero_idx = \''.$idx.'\';'.PHP_EOL;
    @mysql_query($sql);
######################################################################################################################################################
/*ȸ��Ż��� ����Ʈ ����
    $sql = 'DELETE FROM point WHERE hero_code = \''.$check_list['hero_code'].'\';';
    @mysql_query($sql);
*/
######################################################################################################################################################
    $sql_one_update = 'hero_out=\'�����ڿ� ���� Ż�� �Ǿ����ϴ�.\', hero_use=\'1\'';
    $sql = 'UPDATE admin SET '.$sql_one_update.' WHERE hero_idx = \''.$idx.'\';'.PHP_EOL;
    @mysql_query($sql);
    msg($msg.' �Ǿ����ϴ�.','location.href="'.PATH_HOME.'?'.get('type','').'"');
    exit;
}
if(!strcmp($_GET['type'], 'edit')){
    $table='member';
    $data_i = '1';
    $count = @count($_POST);
    $sql_one_update = '';
    
    /*
     * 17.11.02 ������ �г��� ���� �� �ߺ� üũ
     */
    $sql 		= "SELECT hero_nick FROM member WHERE hero_idx = '{$_POST['hero_idx']}'";
    $out_sql	= @mysql_query($sql);
    $data 		= @mysql_fetch_assoc($out_sql);
    if( $data['hero_nick'] != $_POST['hero_nick'] ) {
    	$sql 		= "SELECT hero_nick FROM member WHERE hero_nick = '{$_POST['hero_nick']}'";
    	$out_sql	= @mysql_query($sql);
    	$cnt 		= @mysql_num_rows($out_sql);
    	if( $cnt > 0 ) {
    		msg("�г����� �ߺ��˴ϴ�." ,'location.href="'.PATH_HOME.'?'.get('type','').'"');
    		exit;
    	}
    }
    
    while(list($post_key, $post_val) = each($_POST)){
        if(!strcmp($post_key, 'hero_idx')){
            $idx = $_POST[$post_key];
            $data_i++;
            continue;
        }
        if(!strcmp($post_key, 'hero_dropday')){
            if(!strcmp($_POST['hero_dropday'], '')){
                $data_i++;
                continue;
            }
        }
        if(!strcmp($count, $data_i)){
            $comma = '';
        }else{
            $comma = ', ';
        }

        $sql_one_update .= $post_key.'=\''.$_POST[$post_key].'\''.$comma;
    $data_i++;
    }
    $user_level_up = $_POST['hero_level'];
    $sql_one_update .= ', hero_write=\''.$user_level_up.'\', hero_view=\''.$user_level_up.'\', hero_update=\''.$user_level_up.'\', hero_rev=\''.$user_level_up.'\'';
    $sql = 'UPDATE '.$table.' SET '.$sql_one_update.' WHERE hero_idx = \''.$idx.'\';'.PHP_EOL;
        
    mysql_query($sql);
    msg('���� �Ǿ����ϴ�.','location.href="'.PATH_HOME.'?'.get('type','').'"');
    exit;
}
?>
                        <link type='text/css' href='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.css' rel='stylesheet' />	
                        <script type="text/javascript" src="<?=DOMAIN_END?>cal/jquery.min.js"></script>
                        <script type='text/javascript' src='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.min.js'></script>
						
						<!--20140515 ��ġ �� ������ ����-->
						<div align="center" style="padding:10px">
							<a href="<?=PATH_HOME.'?'.get('order','');?>" style='font-size: 20px;font-weight:800'>�ʱ�����</a>
							<a href="<?=PATH_HOME.'?'.get('order','view=01_01');?>"><font color=red style='padding-left:10px;font-size: 20px;font-weight:800'>������2</font></a>					
						</div>
						<!--20140515 �˻����� �߰�-->
						<div class="searchbox" style="margin-bottom:20px;">
									<div class="wrap_1">
									<form action="<?=PATH_HOME.'?'.get('page');?>" method="POST" >
										<select name="select" id="" style="width:80px">
											<option value="hero_id"<?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>���̵�</option>
											<option value="hero_name"<?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>����</option>

										  <option value="hero_nick"<?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>�г���</option>
										  
										  <option value="hero_memo"<?if(!strcmp($_REQUEST['select'], 'hero_memo')){echo ' selected';}else{echo '';}?>>����</option>
										  <option value="hero_all"<?if(!strcmp($_REQUEST['select'], 'hero_all')){echo ' selected';}else{echo '';}?>>���̵�+����+�г���+����</option>
										</select>
										<input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];?>" class="kewyword">
										<input type="image" src="../image/bbs/btn_search.gif" alt="�˻�" class="bd0">
									</form>
									</div>
									</div>

                        <table class="t_list">
                            <thead>
                                <tr>
									
									<!--20140515 ������ ����-->

                                    <!--<th width="3%" class="first"><input type="checkbox" name="check_all" onclick="check_All();"/></th>-->
<!--                                    <th width="5%">��ȣ</th>-->
									<th width="3%">NO</th>
									<!--20140515 ���� href���� search_next �߰� -->
                                    <th width="10%"><a href="<?=PATH_HOME.'?'.get('order','order=hero_id desc').$search_next;;?>">��</a> ���̵� <a href="<?=PATH_HOME.'?'.get('order','order=hero_id asc').$search_next;;?>">��</a></th>
                                    <th width="8%"><a href="<?=PATH_HOME.'?'.get('order','order=hero_name desc').$search_next;;?>">��</a> �� �� <a href="<?=PATH_HOME.'?'.get('order','order=hero_name asc').$search_next;;?>">��</a></th>
                                    <th width="10%"><a href="<?=PATH_HOME.'?'.get('order','order=hero_nick desc').$search_next;;?>">��</a> �г��� <a href="<?=PATH_HOME.'?'.get('order','order=hero_nick asc').$search_next;;?>">��</a></th>
                                    <th width="5%"><a href="<?=PATH_HOME.'?'.get('order','order=hero_point desc').$search_next;;?>">��</a> �� ����Ʈ <a href="<?=PATH_HOME.'?'.get('order','order=hero_point asc').$search_next;;?>">��</a></th>
                                    <th width="10%"><a href="<?=PATH_HOME.'?'.get('order','order=hero_level desc').$search_next;;?>">��</a> ��� <a href="<?=PATH_HOME.'?'.get('order','order=hero_level asc').$search_next;;?>">��</a></th>
                                    <th width="5%"><a href="<?=PATH_HOME.'?'.get('order','order=hero_use desc').$search_next;;?>">��</a> Ż�𿩺� <a href="<?=PATH_HOME.'?'.get('order','order=hero_use asc').$search_next;;?>">��</a></th>
                                    <th width="*"><a href="<?=PATH_HOME.'?'.get('order','order=hero_id desc').$search_next;;?>">��</a> ���� <a href="<?=PATH_HOME.'?'.get('order','order=hero_id asc').$search_next;;?>">��</a></th>
                                    <th width="10%"><a href="<?=PATH_HOME.'?'.get('order','order=hero_dropday desc').$search_next;;?>">��</a> �Ⱓ <a href="<?=PATH_HOME.'?'.get('order','order=hero_dropday asc').$search_next;;?>">��</a></th>
<!--
                                    <th width="9%">�������</th>
                                    <th width="9%">�б����</th>
-->									<th width="5%">�ȷο���</th>
									<th width="9%">�̸���</th>
									<th width="9%">����</th>
                                    <th width="9%">��۱���</th>
                                    <th width="10%">����</th>
                                </tr>
                            </thead>
                            <tbody>
                        <?
                        if(!strcmp($_GET['order'], '')){
                            $view_order = ' order by hero_oldday desc';
                        }else{
                            $view_order = ' order by '.$_GET['order'];
                        }
                        $sql = 'select * from member where hero_level<=\''.$_SESSION['temp_level'].'\''.$search.$view_order.' limit '.$start.','.$list_page.';';
//                        $sql = 'select * from member where hero_level<=\''.$_SESSION['temp_level'].'\' and hero_use=\'0\';';//desc
                        sql($sql);
                        $i='0';
                        while($list                             = @mysql_fetch_assoc($out_sql)){
/*
                        $level_sql = 'select * from level where hero_use=\'0\' and hero_level='.$list['hero_level'].' order by hero_level desc;';//desc<=
                        $out_level_sql = mysql_query($level_sql);
                        $level_list                             = @mysql_fetch_assoc($out_level_sql);
*/
/*
                        $user_sql = 'select hero_point from point where hero_code=\''.$list['hero_code'].'\';';//desc
                        $user_sql = mysql_query($user_sql);
                        $point = '0';

                        while($total_list                             = @mysql_fetch_assoc($user_sql)){
*/
//                            $point = $point+$total_list['hero_point'];
                            $point = $list['hero_point'];

//                        }
                        
                        if(!strcmp($list['hero_use'], '0')){
                            $use = '����';
                        }else if(!strcmp($list['hero_use'], '1')){
                            $use = '<font color=red>Ż��</font>';
                        }
                        if(!strcmp($list['hero_dropday'], '')){
                            $drop_day = '';
                        }else{
                            $drop_day = date( "Y-m-d", strtotime($list['hero_dropday']));
                        }
                        ?>
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
								<!--20140515 ������ư action���� search_next �߰� -->
                                <form name="form_next<?=$i?>" action="<?=PATH_HOME.'?'.get('','type=edit').$search_next;?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="hero_idx" value="<?=$list['hero_idx']?>">
									<td><?=$j?></td>
                                    <td><?=$list['hero_id'];?></td>
                                    <td><?=name_masking($list['hero_name']);?></td>
                                    <td><input type="text" name="hero_nick" id="hero_nick" value="<?=$list['hero_nick'];?>"></td>
                                    <td><?=$point;?></td>
                                    <td>
                                        <select name="hero_level" id="hero_level">
<?
                                    $level_sql = 'select * from level where hero_level<=\''.$_SESSION['temp_level'].'\' and hero_use=\'0\' order by hero_level asc;';//desc
                                    $out_level_sql = mysql_query($level_sql);
                                    while($level_list                             = @mysql_fetch_assoc($out_level_sql)){
?>
                                            <option value="<?=$level_list['hero_level']?>"<?if(!strcmp($level_list['hero_level'], $list['hero_level'])){echo ' selected';}else{echo '';}?>><?=$level_list['hero_name'];?></option>
<?
                                    }
?>
                                         </select>
                                    </td>
                                    <td><?=$use?></td>
                                    <td style="word-break:break-all"><?=$list['hero_memo'];?></td>
                                    <td style="word-break:break-all">

                                        <input type="text" id="edate<?=$i?>" name="hero_dropday" value="<?=$drop_day?>" style="text-align:center;width:80px" class="input10" readonly/>
                                        <script>
                                            $(function() {      // window.onload ��� ���� ��ũ��Ʈ
                                                    dateclick<?=$i?>();
                                                });
                                                function dateclick<?=$i?>() {
                                                    var dates = $( "#sdate, #edate<?=$i?>" ).datepicker({
                                                        monthNames: ['�� 1��','�� 2��','�� 3��','�� 4��','�� 5��','�� 6��','�� 7��','�� 8��','�� 9��','�� 10��','�� 11��','�� 12��'],
                                                        dayNamesMin: ['��', '��', 'ȭ', '��', '��', '��', '��'],
                                                        defaultDate: null,
                                                        showMonthAfterYear:true,
                                                        dateFormat: 'yy-mm-dd',
                                                        onSelect: function( selectedDate ) {
                                                            var option = this.id == "sdate" ? "minDate" : "maxDate",
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
                                    </td>
<!--
                                    <td style="word-break:break-all">
                                        <select name="hero_write" id="hero_write">
<?
$sql = 'select * from level';
$out_list_sql = mysql_query($sql);
while($new_list                             = @mysql_fetch_assoc($out_list_sql)){
?>
                                            <option value="<?=$new_list['hero_level']?>"<?if(!strcmp($new_list['hero_level'], $list['hero_write'])){echo ' selected';}else{echo '';}?>><?=$new_list['hero_name'];?></option>
<?
}
?>
                                         </select>
                                    </td>
                                    <td style="word-break:break-all">
                                        <select name="hero_view" id="hero_view">
<?
$sql = 'select * from level';
$out_list_sql = mysql_query($sql);
while($new_list                             = @mysql_fetch_assoc($out_list_sql)){
?>
                                            <option value="<?=$new_list['hero_level']?>"<?if(!strcmp($new_list['hero_level'], $list['hero_view'])){echo ' selected';}else{echo '';}?>><?=$new_list['hero_name'];?></option>
<?
}
?>
                                         </select>
                                    </td>
                                  
-->		
									<td><input type="text" name="hero_insta_cnt" value="<?=$list["hero_insta_cnt"];?>" /></td>
									<td>
									<label for="hero_chk_email_1_<?=$list['hero_idx'];?>">����</label> <input type="radio" name="hero_chk_email" id="hero_chk_email_1_<?=$list['hero_idx'];?>" value="1" <?=$list['hero_chk_email'] == "1" ? "checked":"";?>>
									<label for="hero_chk_email_0_<?=$list['hero_idx'];?>">���Űź�</label> <input type="radio" name="hero_chk_email" id="hero_chk_email_0_<?=$list['hero_idx'];?>" value="0" <?=$list['hero_chk_email'] != "1" ? "checked":"";?>>
									</td>
									<td>
									<label for="hero_chk_phone_1_<?=$list['hero_idx'];?>">����</label> <input type="radio" name="hero_chk_phone" id="hero_chk_phone_1_<?=$list['hero_idx'];?>" value="1" <?=$list['hero_chk_phone'] == "1" ? "checked":"";?>>
									<label for="hero_chk_phone_0_<?=$list['hero_idx'];?>">���Űź�</label> <input type="radio" name="hero_chk_phone" id="hero_chk_phone_0_<?=$list['hero_idx'];?>" value="0" <?=$list['hero_chk_phone'] != "1" ? "checked":"";?>>
									</td>
                                    <td style="word-break:break-all">
                                        <select name="hero_rev" id="hero_rev">
<?
$sql = 'select * from level';
$out_list_sql = mysql_query($sql);
while($new_list                             = @mysql_fetch_assoc($out_list_sql)){
?>
                                            <option value="<?=$new_list['hero_level']?>"<?if(!strcmp($new_list['hero_level'], $list['hero_rev'])){echo ' selected';}else{echo '';}?>><?=$new_list['hero_name'];?></option>
<?
}
?>
                                         </select>
                                        <?$list['hero_write'];?>
                                    </td>
                                    <td>
                                        <a href="javascript:form_next<?=$i?>.submit();" class="btn_blue">����</a>
                                        <a href="<?=url('PATH_HOME||board||'.$board.'||&view=02_02&idx='.$_GET['idx'].'&next_page='.$_GET['page'].'&next_idx='.$list['hero_idx']);?>" class="btn_blue">����ƮȮ��</a>
                                    </td>
                                </tr>
                            </form>
<?
$j--;
$i++;
}
?>
                            </tbody>
                        </table>
                        <div style="width:100%; text-align:center; margin-top:20px;">
<? include_once PATH_INC_END.'page.php';?>
                        </div>
<? //include_once BOARD_INC_END.'search.php';?>
                        <div class="searchbox" style="margin-bottom:20px;">
									<div class="wrap_1">
									<form action="<?=PATH_HOME.'?'.get('page');?>" method="POST" >
										<select name="select" id="" style="width:80px">
											<option value="hero_id"<?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>���̵�</option>
											<option value="hero_name"<?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>����</option>

										  <option value="hero_nick"<?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>�г���</option>
										  
										  <option value="hero_memo"<?if(!strcmp($_REQUEST['select'], 'hero_memo')){echo ' selected';}else{echo '';}?>>����</option>
										  <option value="hero_all"<?if(!strcmp($_REQUEST['select'], 'hero_all')){echo ' selected';}else{echo '';}?>>���̵�+����+�г���+����</option>
										</select>
										<input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];?>" class="kewyword">
										<input type="image" src="../image/bbs/btn_search.gif" alt="�˻�" class="bd0">
									</form>
									</div>
									</div>