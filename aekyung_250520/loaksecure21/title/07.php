<?
if(!strcmp($_GET['type'], 'edit')){
    $post_count = @count($_POST['hero_idx']);
    for($i=0;$i<$post_count;$i++){
        reset($_POST);
        unset($sql_one_update);
        $idx = $_POST['hero_idx'][$i];
        $data_i = '1';
        $count = @count($_POST);
        while(list($post_key, $post_val) = each($_POST)){
           if(!strcmp($post_key, 'hero_idx')){
                $data_i++;
                continue;
            }
            if(!strcmp($count, $data_i)){
                $comma = '';
            }else{
                $comma = ', ';
            }
            $sql_one_update .= $post_key.'=\''.$_POST[$post_key][$i].'\''.$comma;
        $data_i++;
        }
        $sql = 'UPDATE hero_group SET '.$sql_one_update.' WHERE hero_idx = \''.$idx.'\';'.PHP_EOL;
        mysql_query($sql);
    }
    echo '<script>location.href="'.PATH_HOME.'?'.get('type','').'"</script>';
    msg('���� �Ǿ����ϴ�.','location.href="'.PATH_HOME.'?'.get('type','').'"');
    exit;
}
?>
<div class="view_title_box">
	*�⼮üũ�� ���� POINT�� ȹ���� ����Ʈ�� ���� �ֽø� �˴ϴ�.<br><br>
	�̼�����Ʈ ������<br>
	<font color=red><b>�̼ǿ� ������� �̶�</b></font> �̼��� �ۼ� �� ���� �Ҽ��ִ� �����Դϴ�.<br><br>
	<font color=green>�б� POINT</font>�� ����Ʈ�� ����� <font color=red>�̼��� Ŭ�������� ��� ����Ʈ</font>�Դϴ�.<br>
	<font color=green>��� POINT</font>�� <font color=red>���信 ����� �Է������� ��� ����Ʈ</font>�Դϴ�.<br>
	<font color=green>�����(�̼�) �ۼ���</font> ��� ����Ʈ�� <font color=red>�̼ǽ�û �� �������ν�û POINT</font>�� �����ø� �˴ϴ�.<br>
	<font color=green>���� �ۼ��� ��� ����Ʈ</font>�� <font color=red>�̼����� �� ������������ POINT</font>�� �����ø� �˴ϴ�.
</div>

<table class="t_list">
<thead>
<tr>
	<th width="20%">ī�װ�</th>
	<th width="7%">�˻�����</th>
	<th width="7%">�������</th>
	<th width="7%">�б����(����Ʈ�����)</th>
	<th width="7%">�б����(��������)</th>
	<th width="7%">��۱���</th>
	<th width="7%">���� POINT</th>
	<th width="7%">�б� POINT</th>
	<th width="7%">��� POINT</th>
	<th width="7%">�̼ǽ�û �� �������ν�û POINT</th>
	<th width="7%">�̼�����(�ı���) �� ������������ POINT</th>
</tr>                               
</thead>
<tbody>
<form name="form_next" action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post" enctype="multipart/form-data"> 
<?
$sql = 'select * from hero_group where hero_type!=\'html\' and hero_menu=\'0\' and hero_use=\'1\' order by hero_point,hero_order asc;';
sql($sql, 'on');
$count = @mysql_num_rows($out_sql);
//    echo $list['hero_title'].'<br>';
while($list                             = @mysql_fetch_assoc($out_sql)){
######################################################################################################################################################
?>
                                <input type="hidden" name="hero_idx[]" value="<?=$list['hero_idx']?>">
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
                                    <!--ī�װ�-->
                                    <td><?=$list['hero_title']?></td>
                                    <!--�˻�����-->
                                    <td>
                                        <select name="hero_search[]" id="hero_search[]">
<?
                        $level_sql = 'select * from level where hero_level<=\''.$_SESSION['temp_level'].'\' and hero_use=\'0\' order by hero_level asc;';//desc
                        $out_level_sql = mysql_query($level_sql);
                        while($level_list                             = @mysql_fetch_assoc($out_level_sql)){
?>
                                            <option value="<?=$level_list['hero_level']?>"<?if(!strcmp($level_list['hero_level'], $list['hero_search'])){echo ' selected';}else{echo '';}?>><?=$level_list['hero_name'];?></option>
<?
                        }
?>
                                         </select>
                                    </td>
                                    <!--�������-->
                                    <td>
                                        <select name="hero_write[]" id="hero_write[]">
<?
                        $out_level_sql = mysql_query($level_sql);
                        while($level_list                             = @mysql_fetch_assoc($out_level_sql)){
?>
                                            <option value="<?=$level_list['hero_level']?>"<?if(!strcmp($level_list['hero_level'], $list['hero_write'])){echo ' selected';}else{echo '';}?>><?=$level_list['hero_name'];?></option>
<?
                        }
?>
                                         </select>
                                    </td>
                                    <!--�б����(����Ʈ�����)-->
                                    <td>
                                        <select name="hero_list[]" id="hero_list[]">
<?
                        $out_level_sql = mysql_query($level_sql);
                        while($level_list                             = @mysql_fetch_assoc($out_level_sql)){
?>
                                            <option value="<?=$level_list['hero_level']?>"<?if(!strcmp($level_list['hero_level'], $list['hero_list'])){echo ' selected';}else{echo '';}?>><?=$level_list['hero_name'];?></option>
<?
                        }
?>
                                        </select>
                                    </td>
                                    <!--�б����(��������)-->
                                    <td>
                                        <select name="hero_view[]" id="hero_view[]">
<?
                        $out_level_sql = mysql_query($level_sql);
                        while($level_list                             = @mysql_fetch_assoc($out_level_sql)){
?>
                                            <option value="<?=$level_list['hero_level']?>"<?if(!strcmp($level_list['hero_level'], $list['hero_view'])){echo ' selected';}else{echo '';}?>><?=$level_list['hero_name'];?></option>
<?
                        }
?>
                                        </select>
                                    </td>
                                    <!--��۱���-->
                                    <td>
                                        <select name="hero_rev[]" id="hero_rev[]">
<?
                        $out_level_sql = mysql_query($level_sql);
                        while($level_list                             = @mysql_fetch_assoc($out_level_sql)){
?>
                                            <option value="<?=$level_list['hero_level']?>"<?if(!strcmp($level_list['hero_level'], $list['hero_rev'])){echo ' selected';}else{echo '';}?>><?=$level_list['hero_name'];?></option>
<?
                        }
?>
                                        </select>
                                    </td>
                                    <!--���� POINT-->
                                    <td>
                                        <input type="text" name="hero_write_point[]" value="<?=$list['hero_write_point']?>" style="width:70px;text-align:center;">
                                    </td>
                                    <!--�б� POINT-->
                                    <td>
                                        <input type="text" name="hero_view_point[]" value="<?=$list['hero_view_point']?>" style="width:70px;text-align:center;">
                                    </td>
                                    <!--��� POINT-->
                                    <td>
                                        <input type="text" name="hero_rev_point[]" value="<?=$list['hero_rev_point']?>" style="width:70px;text-align:center;">
                                    </td>
                                    <!--�̼ǽ�û �� �������ν�û POINT-->
                                    <td>
                                        <input type="text" name="hero_mission_point[]" value="<?=$list['hero_mission_point']?>" style="width:70px;text-align:center;">
                                    </td>
                                    <!--�̼�����(�ı���) �� ������������ POINT-->
                                    <td>
                                        <input type="text" name="hero_mission_join[]" value="<?=$list['hero_mission_join']?>" style="width:70px;text-align:center;">
                                    </td>
                                </tr>
<?
$i++;
}
?>
                                </form>
                            </tbody>
                        </table>
<div class="btnGroup">
	 <a href="javascript:form_next.submit();" class="btnAdd">��������</a>
</div>
<?// include_once PATH_INC_END.'page.php';?>
<?// include_once PATH_INC_END.'search.php';?>