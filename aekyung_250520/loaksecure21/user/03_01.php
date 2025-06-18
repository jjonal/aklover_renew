<?
//print_r($_POST);
//exit;
function hero_file2($file_inc_path = null,$file_path = null){
    global $HTTP_POST_FILES,$_POST,$_GET,$out_hero_file;
    if( (strcmp($_GET["type"],"edit")) and (strcmp($_GET["type"],"write")) ){exit;}
    $table = $_POST['hero_table'];
    $file_count = @count($HTTP_POST_FILES);
    if(strcmp($file_count,"0")){
       $i='1';
        while(list($file_key, $file_val) = each($HTTP_POST_FILES)){
            if(!strcmp($_GET["type"],"edit")){
                $sql = "select * from ".$table." where hero_idx='".$_POST['hero_idx']."'";
                $out_sql    = mysql_query($sql);
                $list       = @mysql_fetch_assoc($out_sql);
                $hero_img_new = $list[$file_key];
            }
            if(!strcmp($file_count, $i)){
                $comma = ', ';
            }else{
                $comma = ', ';
            }
            if(strcmp($HTTP_POST_FILES[$file_key]['size'],"0")){
                if(!strcmp($_GET["type"],"edit")){
                    @unlink($file_inc_path.$hero_img_new);
                }
                @move_uploaded_file($HTTP_POST_FILES[$file_key]['tmp_name'],$file_inc_path.Y_m_d_h_i_s.'_'.$HTTP_POST_FILES[$file_key]['name']);
                $up_one .= $file_key."='".$file_path.Y_m_d_h_i_s.'_'.$HTTP_POST_FILES[$file_key]['name']."'".$comma;

                $write_one .= $file_key.$comma;
                $write_two .= "'".$file_path.Y_m_d_h_i_s.'_'.$HTTP_POST_FILES[$file_key]['name']."'".$comma;
            }else{
                if(!strcmp($_POST['hero_img_old'],$hero_img_new)){
                    $hero_img = $hero_img_new;
                }else{
                    @unlink($file_inc_path.$hero_img_new);
                    $hero_img = $_POST['hero_img_old'];
                }
                $up_one .= $file_key."='".$hero_img."'".$comma;
                $write_one .= $file_key.$comma;
                $write_two .= "'".$hero_img."'".$comma;
            }
            $i++;
        }
    }
    $data_i = '1';
    $idx = $_POST['hero_idx'];
####################################################################################################################################################
    $drop_check = explode('||', $_POST['hero_drop']);
    while(list($drop_key, $drop_val) = each($drop_check)){
        unset($_POST[$drop_val]);
    }
####################################################################################################################################################
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
        if(!strcmp($_GET["type"],"edit")){
            $up_one .= $post_key.'=\''.$_POST[$post_key].'\''.$comma;
        }else if(!strcmp($_GET["type"],"write")){
            $write_one .= $post_key.$comma;
            $write_two .= '\''.$_POST[$post_key].'\''.$comma;
        }
    $data_i++;
    }
    if(!strcmp($_GET["type"],"edit")){
        $msg = "수정";
        $sql = 'UPDATE '.$table.' SET '.$up_one.' WHERE hero_idx = \''.$idx.'\';'.PHP_EOL;
    }else if(!strcmp($_GET["type"],"write")){
        $msg = "추가";
        $sql = 'INSERT INTO '.$table.' ('.$write_one.') VALUES ('.$write_two.');';
    }
    mysql_query($sql);
    msg($msg.' 되었습니다.','location.href="'.PATH_HOME.'?'.get('view||type','').'"');

    return $out_hero_file;
}
if(!strcmp($_GET["type"],"drop")){
    $msg = "삭제";
    $sql = 'DELETE FROM level WHERE hero_idx = \''.$_GET['hero_idx'].'\';';
    @mysql_query($sql);
    msg($msg.' 되었습니다.','location.href="'.PATH_HOME.'?'.get('view||type','').'"');
}else{
    hero_file2(AKLOVER_PHOTO_INC_END,AKLOVER_PHOTO_END);
}
exit;
?>