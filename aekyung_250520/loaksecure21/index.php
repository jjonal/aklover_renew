<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD����
######################################################################################################################################################
include_once '../freebest/head.php';

if(!$_SESSION['temp_id']){echo '<script>location.href="'.PATH_END.'out.php"</script>';exit;}
//ȸ�� ������ ���� �޴��� ���� �����ϰ� 9998 ���� �߰� 2019-04-09
if( (!strcmp($_SESSION['temp_level'], '10000')) or (!strcmp($_SESSION['temp_level'], '9999')) or (!strcmp($_SESSION['temp_level'], '9998')) or (!strcmp($_SESSION['temp_level'], '9997')) or (!strcmp($_SESSION['temp_level'], '9996')) ){
include                                     FREEBEST_INC_END.'hero.php';
include                                     FREEBEST_INC_END.'function.php';

######################################################################################################################################################
if($_SESSION['temp_level'] == "9997") {
	include_once                                PATH_INC_END.'top9997.php';
} else if($_SESSION['temp_level'] == "9996") { //�۷ι�
	include_once                                PATH_INC_END.'top9996.php';
} else {
	include_once                                PATH_INC_END.'top.php';
}
include_once                                PATH_INC_END.'main.php';
include_once                                PATH_INC_END.'tail.php';
######################################################################################################################################################

exit;
}else{
   echo '<script>alert("������ �����ϴ�.")</script>';
   echo '<script>location.href="'.PATH_END.'out.php"</script>';exit;
}
?>
