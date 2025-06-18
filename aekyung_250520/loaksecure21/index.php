<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
######################################################################################################################################################
include_once '../freebest/head.php';

if(!$_SESSION['temp_id']){echo '<script>location.href="'.PATH_END.'out.php"</script>';exit;}
//회원 데이터 추출 메뉴만 접근 가능하게 9998 레벨 추가 2019-04-09
if( (!strcmp($_SESSION['temp_level'], '10000')) or (!strcmp($_SESSION['temp_level'], '9999')) or (!strcmp($_SESSION['temp_level'], '9998')) or (!strcmp($_SESSION['temp_level'], '9997')) or (!strcmp($_SESSION['temp_level'], '9996')) ){
include                                     FREEBEST_INC_END.'hero.php';
include                                     FREEBEST_INC_END.'function.php';

######################################################################################################################################################
if($_SESSION['temp_level'] == "9997") {
	include_once                                PATH_INC_END.'top9997.php';
} else if($_SESSION['temp_level'] == "9996") { //글로벌
	include_once                                PATH_INC_END.'top9996.php';
} else {
	include_once                                PATH_INC_END.'top.php';
}
include_once                                PATH_INC_END.'main.php';
include_once                                PATH_INC_END.'tail.php';
######################################################################################################################################################

exit;
}else{
   echo '<script>alert("권한이 없습니다.")</script>';
   echo '<script>location.href="'.PATH_END.'out.php"</script>';exit;
}
?>
