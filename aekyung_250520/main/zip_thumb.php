<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD����


######################################################################################################################################################
include_once '../freebest/head.php';
include_once FREEBEST_INC_END.'function.php';
db("aekyung");

######################################################################################################################################################
	if(!strcmp($_SESSION['temp_level'], '')){
	
		error_location('���������� �����Դϴ�. �α��� �Ŀ� �ٽ� �õ��� �ּ���.', '/main/index.php?board=login');
		echo "0";
		exit;
		 
	}

######################################################################################################################################################
	
	//$thumbImage = $_POST['thumbImage'];
	$hero_thumb		=		$_FILES["thumbImage"];
	$board			=		$_GET["board"];
	$code			=		$_SESSION["temp_code"];
	
	if(!is_uploaded_file ( $hero_thumb['tmp_name'] )){
		logging_error($code, $board."-AJAX_IMAGE_UPLOAD_01-�̹��� ���ε� ����", $full_today);
		echo "0";
		exit;
	}
			
	$thumb_path = "/user/photo/".date("Y_m")."/";
	
	$temp_name = explode(".",$hero_thumb['name']);
	$temp_extenstion = $temp_name[count($temp_name)-1];
	
	$temp_filename = time()."_".$_SESSION["temp_id"].".".$temp_extenstion;
	$thum_filename = "thum_".$temp_filename;

	$temp_file = $_SERVER["DOCUMENT_ROOT"].$thumb_path.$temp_filename;
	$thumb_file = $_SERVER["DOCUMENT_ROOT"].$thumb_path.$thum_filename;

	if(!is_dir($_SERVER["DOCUMENT_ROOT"].$thumb_path))	mkdir($_SERVER["DOCUMENT_ROOT"].$thumb_path, 0777);

	if(move_uploaded_file($hero_thumb['tmp_name'], $temp_file)){

		//$im = thumbnail($temp_file, 223, 174);
//		$im = thumbnail($temp_file, 224, 151);
        $im = thumbnail($temp_file, 380, 380); //������ ����
		imagejpeg($im, $thumb_file, 100);
		imagedestroy($im);
		unlink($temp_file);

		$hero_thumb_img = $thumb_path.$thum_filename;
		
		echo $hero_thumb_img;

	}else{
		logging_error($code, $board."-AJAX_IMAGE_UPLOAD_02-�̹��� ���ε� ����", $full_today);
		echo "0";
		exit;
	}
	
