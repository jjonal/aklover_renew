<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
$table = 'level_up';
if(!strcmp($_GET['type'], 'write')){
    if(!strcmp($_POST['hero_number'], '')){msg('Ƚ���� �Է��ϼ���.','location.href="'.PATH_HOME.'?'.get('type','').'"');exit;}
    $data_i = '1';
    $count = @count($_POST);
    while(list($post_key, $post_val) = each($_POST)){
        if(!strcmp($count, $data_i)){
            $comma = '';
        }else{
            $comma = ', ';
        }
//        $sql_one_update .= $post_key.'=\''.$_POST[$post_key].'\''.$comma;
        $sql_one_write .= $post_key.$comma;
        $sql_two_write .= '\''.$_POST[$post_key].'\''.$comma;

    $data_i++;
    }
    $sql = 'INSERT INTO '.$table.' ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
    mysql_query($sql);
    msg('�߰� �Ǿ����ϴ�.','location.href="'.PATH_HOME.'?'.get('type','').'"');
    exit;
}else if(!strcmp($_GET['type'], 'edit')){
    if(!strcmp($_POST['hero_number'], '')){msg('Ƚ���� �Է��ϼ���.','location.href="'.PATH_HOME.'?'.get('type','').'"');exit;}
    $data_i = '1';
    $count = @count($_POST);
    while(list($post_key, $post_val) = each($_POST)){
        if(!strcmp($post_key, 'hero_idx')){
            $idx = $_POST[$post_key];
            $data_i++;
            continue;
        }
        if(!strcmp($count, $data_i)){
            $comma = '';
        }else{
            $comma = ', ';
        }
        $sql_one_update .= $post_key.'=\''.$_POST[$post_key].'\''.$comma;
    $data_i++;
    }
    $sql = 'UPDATE '.$table.' SET '.$sql_one_update.' WHERE hero_idx = \''.$idx.'\';'.PHP_EOL;
    mysql_query($sql);
    msg('���� �Ǿ����ϴ�.','location.href="'.PATH_HOME.'?'.get('type','').'"');
    exit;
}else if(!strcmp($_GET['type'], 'drop')){
    $sql = 'DELETE FROM '.$table.' WHERE hero_idx = \''.$_GET['hero_idx'].'\';';
    mysql_query($sql);
    msg('���� �Ǿ����ϴ�.','location.href="'.PATH_HOME.'?'.get('type||hero_idx','').'"');
}
//            continue;
?>
                        <table class="t_list">
                            <thead>
                                <tr>
                                    <th width="25%">ī�װ�</th>
                                    <th width="25%">����</th>
                                    <th width="25%">Ƚ��</th>
                                    <th width="25%">����</th>
                                </tr>
                            </thead>
                            <tbody>
<?
$sql = 'select * from level_up';
sql($sql, 'on');
$i = '0';
while($level_up_list                             = @mysql_fetch_assoc($out_sql)){
?>

                            <form name="form_next<?=$i?>" action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post" enctype="multipart/form-data"> 
                            <input type="hidden" name="hero_idx" value="<?=$level_up_list['hero_idx']?>">
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
                                    <td>
                                        <select name="hero_table" id="hero_table" style="width:200px;">
<?
$sql = 'select * from hero_group where hero_type!=\'html\' and hero_menu=\'0\' and hero_use=\'1\' order by hero_point,hero_order asc;';//desc//                        $user_sql = mysql_query($sql);
$out_list_sql = mysql_query($sql);
while($list                             = @mysql_fetch_assoc($out_list_sql)){
?>
                                            <option value="<?=$list['hero_board']?>"<?if(!strcmp($list['hero_board'], $level_up_list['hero_table'])){echo ' selected';}else{echo '';}?>><?=$list['hero_title'];?></option>
<?
}
?>
                                         </select>
                                    </td>
                                    <td>
                                        <select name="hero_type" id="hero_type" style="width:200px;">
                                            <option value="hero_write"<?if(!strcmp($level_up_list['hero_type'], 'hero_write')){echo ' selected';}else{echo '';}?>>����</option>
                                            <option value="hero_view"<?if(!strcmp($level_up_list['hero_type'], 'hero_view')){echo ' selected';}else{echo '';}?>>�б�</option>
                                            <option value="hero_rev"<?if(!strcmp($level_up_list['hero_type'], 'hero_rev')){echo ' selected';}else{echo '';}?>>����</option>
                                         </select>
                                    </td>
                                    <td>
                                        <input type="text" name="hero_number" value="<?=$level_up_list['hero_number']?>" style="width:200px;text-align:center;">
                                    </td>
                                    <td>
                                        <a href="javascript:form_next<?=$i?>.submit();" class="btn_blue2">����</a>
                                    </td>
                                </tr>
                            </form>
<?
    $i++;
}
?>
                            </tbody>
                        </table>
                        <br><br>
