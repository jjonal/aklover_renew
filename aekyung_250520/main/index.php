<?
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

// ������ 2023.04.27
//echo '<script>location.href="http://'.$_SERVER['HTTP_HOST'].'/server_job_notice/aklover_notice_230427.html"</script>';exit;


$pageCheck = $_GET["pageCheck"];

ob_start();
//����� �� ���
include_once $_SERVER['DOCUMENT_ROOT'].'/freebest/Mobile_Detect.php';
$detect = new Mobile_Detect;
if($detect->isMobile() or $detect->isTablet()){
	define('MOBILE',   "mobile",TRUE);
	//echo $_COOKIE["pcMobile"];
	//echo $_COOKIE["pcMobile2"];
	if($_COOKIE["pcMobile"]!='pc'){
        echo "<script>location.href='https://www.aklover.co.kr/m/main.php'</script>";
		exit;
	}
}
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD����

include_once '../freebest/head.php';
include_once FREEBEST_INC_END.'hero.php';
include_once FREEBEST_INC_END.'function.php';

#####################################################################################################################################################
##	�ı�, �����ı�, ������Ÿ - ��â���� blog ������ ÷��(frameset)
#####################################################################################################################################################
if($_GET['view']=='view2'){
	include_once DOMAIN_INC_END."/board/".$_GET['view'].".php";
	exit;
}
if($_GET['view']=='view2_top'){
	include_once DOMAIN_INC_END."/board/".$_GET['view'].".php";
	exit;
}

include_once PATH_INC_END.'top2.php';

//$_REQUEST['bbs'];
//array_key_exists( 'name', $_POST )
//post(NULL, FALSE)) exit
#####################################################################################################################################################
if(
        (!strcmp($_GET['hero'],''))
    and (!strcmp($_GET['path'],''))
    and (!strcmp($_GET['board'],''))
    and (!strcmp($_GET['root'],''))
    and (!strcmp($_GET['admin'],''))
){
#####################################################################################################################################################
    include_once PATH_INC_END.'main2.php';
    if($pageCheck == "Y") echo "page=".PATH_INC_END.'main2.php';
}else if(strcmp($_GET['hero'],'')){
    include_once PATH_INC_END.'left.php';
    include_once hero($_GET['hero'].'||inc').$_GET['view'].'.php';
    if($pageCheck == "Y") echo "page=".hero($_GET['hero'].'||inc').$_GET['view'].'.php';
}else if(strcmp($_GET['path'],'')){
    include_once                                                    PATH_INC_END.'left.php';
    include_once                                                    DOMAIN_INC_END.$_GET['path'].'.php';
    if($pageCheck == "Y") echo "page=".DOMAIN_INC_END.$_GET['path'].'.php';
}else if(strcmp($_GET['board'],'')){
    // include_once                                                    PATH_INC_END.'left.php';
    include_once                                                    BOARD_INC_HOME;
    if($pageCheck == "Y") echo "page=".BOARD_INC_HOME;
}else if(strcmp($_GET['root'],'')){
    include_once                                                    PATH_INC_END.'left.php';
    include_once                                                    PATH_INC_END.$_GET['root'].'.php';
    if($pageCheck == "Y") echo "page=".PATH_INC_END.$_GET['root'].'.php';
}else if(strcmp($_GET['admin'],'')){
    include_once                                                    PATH_INC_END.'left.php';
    include_once                                                    PATH_INC_HOME;
    if($pageCheck == "Y") echo "page=".PATH_INC_HOME;
}else{
//    echo PATH_INC_HOME;
//    include_once                                                    PATH_INC_HOME;
}

//�������� ��û�� Ȯ���� Ǫ��X
include_once  PATH_INC_END.'tail2.php';
?>
