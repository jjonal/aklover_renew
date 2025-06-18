<?
ob_start();
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################

define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once                                                        '../../freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';

db("aekyung");

$idx = $_POST['idx'];
//echo $idx;
if(is_numeric($idx)){
	
	$select = "select A.hero_select_count, B.enrolled_count from mission A, (select count(*) enrolled_count from mission_review where hero_old_idx='".$idx."' and hero_superpass='Y') B where A.hero_idx='".$idx."'";
	//echo $select;
	$select_res = mysql_query($select) or die('9');
	$selcet_rs = mysql_fetch_assoc($select_res);

	
	$superpass_max_num = 0;
	
	$superpass_max_num = countSuperpass($selcet_rs['hero_select_count']);
	
	if($superpass_max_num<=$selcet_rs['enrolled_count'])	echo "0";
	else													echo "1";
	
}


?>
