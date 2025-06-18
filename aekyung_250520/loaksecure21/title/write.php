<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$hero_code = $_POST['hero_id'].'_'.Y_m_d;

$hero_hp = $_POST['hero_hp1'].'-'.$_POST['hero_hp2'].'-'.$_POST['hero_hp3'];
$hero_mail = $_POST['email1'].'@'.$_POST['email2'];
$idx = $_POST['hero_idx'];
$type = $_POST['type'];
$table = $_POST['hero_table'];

function write($use_no = null){
    //비밀번호에 암호화 대한 로직 YDH
    $hero_pw = $_POST['hero_pw'];
    $hero_id = $_POST['hero_id'];
    $pw_md5 = md5($hero_pw);
    $temp = $pw_md5.$hero_id;
    $pw_sha3_256 = sha3_hash('sha3-256', $temp);

    global $hero_code, $hero_hp, $hero_mail, $idx, $type, $table, $out_get;
    $hero_code_next = $_POST['hero_code'];
    $use_check = explode('||', $use_no);
    while(list($use_key, $use_val) = each($use_check)){
        unset($_POST[$use_val]);
    }
    $data_count = sizeof($_POST);
    $data_i = '0';
    while(list($post_key, $post_val) = each($_POST)){
        $data_check = $data_count-1;
        if(strcmp($data_check, $data_i)){
            $comma = ', ';
        }else{
            $comma = '';
        }
        if(!strcmp($type, 'write')){
            if($post_key == 'hero_pw' && $_POST[$post_key] != '') { //암호화
                $_POST[$post_key] = $pw_sha3_256;
            }
            $sql_one .= $post_key.$comma;
            $sql_two .= '\''.$_POST[$post_key].'\''.$comma;
        }else if(!strcmp($type, 'modify')){
            if($post_key == 'hero_pw' && $_POST[$post_key] == ''){ //비밀번호 공백이면 skip
                continue;
            }else if($post_key == 'hero_pw' && $_POST[$post_key] != '') { //아니면 암호화
                $_POST[$post_key] = $pw_sha3_256;
            }
            $sql_one .= $post_key.' = \''.$_POST[$post_key].'\''.$comma;
        }
        $data_i++;
    }

    if(!strcmp($type, 'write')){
        $sql = 'select * from admin where hero_id = \''.$_POST['hero_id'].'\';';
        $write_sql = @mysql_query($sql);
        $count_01 = @mysql_num_rows($write_sql);
        $sql = 'select * from member where hero_id = \''.$_POST['hero_id'].'\';';
        $write_sql = @mysql_query($sql);
        $count_02 = @mysql_num_rows($write_sql);
        $sum_count = $count_01+$count_02;
        if( (!strcmp($sum_count, '0')) and (strcmp($_POST['hero_id'], '')) ){
            $sql_one = 'hero_code, hero_write, hero_view, hero_update, hero_rev, hero_hp, hero_mail, '.$sql_one;
            $sql_two = '\''.$hero_code.'\', \''.$_POST['hero_level'].'\', \''.$_POST['hero_level'].'\', \''.$_POST['hero_level'].'\', \''.$_POST['hero_level'].'\', \''.$hero_hp.'\', \''.$hero_mail.'\', '.$sql_two;
            $sql = 'INSERT INTO '.$table.' ('.$sql_one.') VALUES ('.$sql_two.');';
            @mysql_query($sql);
            $sql = 'INSERT INTO member ('.$sql_one.') VALUES ('.$sql_two.');';
            @mysql_query($sql);
        }else{
            echo '<script>location.href="'.PATH_HOME.'?'.get('view','view=01_write&type=write').'";alert("사용 중입니다.");</script>';
        }
    }else if( (!strcmp($type, 'update')) or (!strcmp($type, 'modify')) ){
        $sql = 'UPDATE '.$table.' SET '.$sql_one.' WHERE hero_code = \''.$hero_code_next.'\';';
        @mysql_query($sql);
        $sql = 'UPDATE member SET '.$sql_one.' WHERE hero_code = \''.$hero_code_next.'\';';
        @mysql_query($sql);
    }
$out_get = 'board=title&idx=2';
echo '<script>alert("등록 하였습니다.");location.href="'.PATH_HOME.'?'.$out_get.'"</script>';
}
write($_POST['hero_drop']);
?>
