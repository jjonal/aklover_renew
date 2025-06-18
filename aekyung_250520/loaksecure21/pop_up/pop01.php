<?
$table = 'popup';
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
        if(!strcmp(eregi('hero_use',$sql_one_update),'1')){

        }else{
            $sql_one_update .= ', hero_use=\'\'';
        }
        $sql = 'UPDATE '.$table.' SET '.$sql_one_update.' WHERE hero_idx = \''.$idx.'\';'.PHP_EOL;
        mysql_query($sql);
    }
    msg('수정 되었습니다.','location.href="'.PATH_HOME.'?'.get('type','').'"');
    exit;
}
?>
<style>
input{text-align:center;}
</style>
                        <div id="layer" style="text-align:center; position:absolute; display:none; margin:0; padding:0; z-index:1;border:solid 5px red"></div>
                        <table class="t_list">
                            <thead>
                                <tr>
                                    <th width="10%">선택</th>
                                    <th width="10%">가로위치</th>
                                    <th width="10%">세로위치</th>
                                    <th width="10%">폭</th>
                                    <th width="10%">높이</th>
                                    <th width="10%">순서</th>
                                    <th width="10%">상태</th>
                                    <th width="10%">설정</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form name="form_next" action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post" enctype="multipart/form-data" onsubmit="return false"> 
<?
$sql = 'select * from '.$table.' order by hero_order asc;';
sql($sql);
$i = '0';
while($roll_list                             = @mysql_fetch_assoc($out_sql)){
    if(!strcmp($roll_list['hero_use'],"1")){
        $use = '<font color=red><b>사용중</b></font>';
        $hero_checked = ' checked';
    }else{
        $use = '미사용';
        $hero_checked = '';
    }
?>

                                <input type="hidden" name="hero_idx[]" value="<?=$roll_list['hero_idx']?>">
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
                                    <td><?=$roll_list['hero_idx']?> <input type="checkbox" name="hero_use[<?=$i?>]" value="1" <?=$hero_checked;?>></td>
                                    <td><input type="text" name="hero_width_point[]" value="<?=$roll_list['hero_width_point']?>" style="width:90%"></td>
                                    <td><input type="text" name="hero_height_point[]" value="<?=$roll_list['hero_height_point']?>" style="width:90%"></td>
                                    <td><input type="text" name="hero_width[]" value="<?=$roll_list['hero_width']?>" style="width:90%"></td>
                                    <td><input type="text" name="hero_height[]" value="<?=$roll_list['hero_height']?>" style="width:90%"></td>
                                    <td><input type="text" name="hero_order[]" value="<?=$roll_list['hero_order']?>" style="width:90%"></td>
                                    <td><?=$use?></td>
                                    <td><input type="image" src="<?=DOMAIN_END?>image/bbs/btn_edit.gif" onclick="javascript:location.href='<?=PATH_HOME.'?'.get('type||view','view=01_00&hero_idx='.$roll_list['hero_idx'])?>';"></td>
                                </tr>
<?
$i++;
}
?>
                                <tr>
                                    <td colspan="8">
                                        <a href="javascript:form_next.submit();" class="btn_blue2">설정수정</a>
                                    </td>
                                </tr>
                                </form>
                            </tbody>
                        </table>
