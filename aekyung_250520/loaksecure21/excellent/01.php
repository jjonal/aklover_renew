<?
$table = 'hero_group';
$hero_board = 'excellent';
$hero_point = '9';
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
}else if(!strcmp($_GET['type'], 'write')){
        $sql_one_write = 'hero_group, hero_board, hero_point, hero_menu, hero_order, hero_use';
        $sql_two_write = '\''.$hero_board.'\', \''.$hero_board.'\', \''.$hero_point.'\', \'1\', \'0\', \'1\' ';
        $sql = 'INSERT INTO '.$table.' ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
        mysql_query($sql);
    msg('추가 되었습니다.','location.href="'.PATH_HOME.'?'.get('type','').'"');
    exit;
}else if(!strcmp($_GET['type'], 'drop')){
    $sql = 'DELETE FROM '.$table.' WHERE hero_idx = \''.$_GET['hero_idx'].'\';';
    sql($sql);
    msg('삭제 되었습니다.','location.href="'.PATH_HOME.'?'.get('type||hero_idx','').'"');
    exit;
}
?>

                        <div id="layer" style="text-align:center; position:absolute; display:none; margin:0; padding:0; z-index:1;border:solid 5px red"></div>
                        <table class="t_list">
                            <thead>
                                <tr>
									<th width="4%">NO</th>
                                    <th width="5%">선택</th>
                                    <th width="12%">TOP 제목</th>
                                    <th width="22%">제목</th>
                                    <th width="*">링크</th>
                                    <th width="7%">순서</th>
                                    <th width="7%">상태</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form name="form_next" action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post" enctype="multipart/form-data"> 
<?
$sql = 'select * from '.$table.' where hero_group=\''.$hero_board.'\' order by hero_board asc, hero_order asc;';
sql($sql);
$i = '0';

//2014-05-14 no 추가
$j=1;

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
                                <input type="hidden" name="hero_today[]" value="<?=Ymdhis?>">
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
									<td><?=$j?></td>
                                    <td><input type="checkbox" name="hero_use[<?=$i?>]" value="1" <?=$hero_checked;?>></td>
                                    <td><?=$roll_list['hero_top_title']?></td>
                                    <td><input type="text" name="hero_title[]" value="<?=$roll_list['hero_title']?>" style="width:200px"></td>
                                    <td><input type="text" name="hero_href[]" value="<?=$roll_list['hero_href']?>" style="width:400px"></td>
                                    <td><input type="text" name="hero_order[]" value="<?=$roll_list['hero_order']?>" style="width:40px;text-align:center;"></td>
                                    <td><?=$use?></td>
                                </tr>
<?
$j++;
$i++;
}
?>
                                <tr>
                                    <td colspan="6">
                                        <a href="javascript:form_next.submit();" class="btn_blue2">설정수정</a>
                                    </td>
                                </tr>
                                </form>
                            </tbody>
                        </table>
