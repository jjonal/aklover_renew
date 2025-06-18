<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once '../freebest/head2.php';
if(strcmp($_POST['logout_check'], 'logout_check')){echo '<script>location.href="'.PATH_END.'out2.php"</script>';exit;}
######################################################################################################################################################
include_once FREEBEST_INC_END.'function.php';
######################################################################################################################################################
$sql = 'select * from admin where hero_id = "'.$_POST['login_id'].'" and hero_pw = "'.$_POST['login_pw'].'" and hero_level >= 9999 and hero_use = \'0\';';
sql($sql, 'end');
$count = @mysql_num_rows($out_sql);
if( (!strcmp($count, '')) or (!strcmp($count, '0')) ){
//    iconv('EUC-KR', 'UTF-8', '<font color=blue>아이디와 비밀번호를 다시 확인해 주세요.');
}else{
    $list = mysql_fetch_assoc($out_sql);//mysql_fetch_row

    $_SESSION['temp_code'] = $list['hero_code'];
    $_SESSION['temp_id'] = $list['hero_id'];
    $_SESSION['temp_name'] = $list['hero_name'];
    $_SESSION['temp_nick'] = $list['hero_nick'];
    $_SESSION['temp_level'] = $list['hero_level'];
    $_SESSION['temp_write'] = $list['hero_write'];
    $_SESSION['temp_view'] = $list['hero_view'];
    $_SESSION['temp_update'] = $list['hero_update'];
    $_SESSION['temp_rev'] = $list['hero_rev'];
    if(!strcmp($list['hero_dropday'], '')){
    }else{
        $_SESSION['temp_drop'] = date( "Y-m-d", strtotime($list['hero_dropday']));
    }

}
?>
