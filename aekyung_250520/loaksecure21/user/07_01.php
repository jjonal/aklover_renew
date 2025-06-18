<?
####################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
####################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
####################################################################################################################################################
/*
$sql = 'select * from member where hero_info_di=\''.$_POST['hero_info_di'].'\' and hero_info_ci=\''.$_POST['hero_info_ci'].'\';';//desc//asc
sql($sql);
$check_count = @mysql_num_rows($out_sql);
*/
$sql = 'select * from member where hero_id=\''.$_POST['hero_id'].'\';';//desc//asc
sql($sql);
$check_count = @mysql_num_rows($out_sql);
//if(strcmp($check_count,'0')){echo '<script>alert("이미 가입하셨습니다.");location.href="history.go(-1)"</script>';exit;}
if(strcmp($check_count,'0')){echo '<script>alert("이미 가입하셨습니다.");location.href="'.PATH_HOME.'?board='.$_GET['board'].'&idx='.$_GET['idx'].'"</script>';exit;}
//if( (strcmp($check_count,'0')) or (!strcmp($_POST['hero_info_di'],'')) ){echo '<script>alert("이미 가입하셨습니다.");location.href="'.PATH_HOME.'?board=login"</script>';exit;}
$hero_code = $_POST['hero_id'].'_'.$_POST['hero_code_date'];
$hero_table = $_POST['hero_table'];
$hero_pw = $_POST['hero_pw_01'];
$hero_mail = $_POST['hero_mail_01'].'@'.$_POST['hero_mail_02'];
####################################################################################################################################################
$sql = 'select * from hero_group where hero_board=\''.$_GET['board'].'\';';//desc//asc
sql($sql,'on');
$check_list                             = @mysql_fetch_assoc($out_sql);
if(!strcmp($check_list['hero_write_point'],'0')){
}else{
    $check_one = 'hero_code, hero_table, hero_id, hero_title, hero_name, hero_nick, hero_point, hero_today';
    $check_two = '\''.$hero_code.'\', \''.$_GET['board'].'\', \''.$_POST['hero_id'].'\', \''.$check_list['hero_title'].'\', \''.$_POST['hero_name'].'\', \''.$_POST['hero_nick'].'\', \''.$check_list['hero_write_point'].'\', \''.$_POST['hero_today'].'\'';
    $sql = 'INSERT INTO point ('.$check_one.') VALUES ('.$check_two.');';
    sql($sql, 'on');
}
####################################################################################################################################################
$drop_check = explode('||', $_POST['hero_drop']);
while(list($drop_key, $drop_val) = each($drop_check)){
    unset($_POST[$drop_val]);
}
####################################################################################################################################################
$post_count = sizeof($_POST);
$post_i='1';

$sql_one .= 'hero_code, hero_pw, hero_mail, ';
$sql_two .= '\''.$hero_code.'\', \''.$hero_pw.'\', \''.$hero_mail.'\', ';
while(list($post_key, $post_val) = each($_POST)){
    if(!strcmp($post_i, $post_count)){
        $comma = '';
    }else{
        $comma = ', ';
    }
    $sql_one .= $post_key.$comma;
    $sql_two .= '\''.$post_val.'\''.$comma;
    $post_i++;
}
$sql = 'INSERT INTO '.$hero_table.' ('.$sql_one.') VALUES ('.$sql_two.');';
sql($sql, 'on');
####################################################################################################################################################
?>
    <div style="width:706px;">
        <div class="page_title">
            <h2><img src="../image/title/title_7_1.gif" alt="회원정보수정" /></h2>
        </div>
        <div class="contents">
            <div class="resbox">
                <span class="restxt"><?=$_POST['hero_name']?> 님</span>
            </div>
            <div class="btngroup tc" >
                <a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&idx=57"><img src="../image/member/btn_gomain.gif" /></a>
            </div>
        </div>
    </div>
