<?php 

	//���� ����
	define("__CASTLE_PHP_VERSION_BASE_DIR__", $_SERVER['DOCUMENT_ROOT']."/castle-php/"); 
	include_once(__CASTLE_PHP_VERSION_BASE_DIR__ . "castle_referee.php");
	
	if(!$_GET['file']){
		
		"<script>alert('����� �����Դϴ�.');history.back(-1)</script>";
		
	}

	// ���� Path�� �����մϴ�.
	// id������ �̿��� Database���� ã�ƿ��ų� GET�̳� POST������ ������ �ּ���.
	$filePath = $_GET['file'];
	$file = $_SERVER['DOCUMENT_ROOT']."/loaksecure21/manual_folder/".$filePath;
	$file_size = filesize($file);
	$filename = urlencode($filePath);
	// ���ٰ�� Ȯ�� (�ܺ� ��ũ�� ���� �ʹٸ� �������ּ���)
	if (!eregi($_SERVER['HTTP_HOST'], $_SERVER['HTTP_REFERER'])){
		echo "<script>alert('�ܺ� �ٿ�ε�� �Ұ����մϴ�.');</script>";
		return;
	}
	if (is_file($file)){
		// ���� ���ۿ� HTTP ����� �����մϴ�.
		if(strstr($HTTP_USER_AGENT, "MSIE 5.5")){
	
			header("Content-Type: doesn/matter");
			Header("Content-Length: ".$file_size);
			header("Content-Disposition: filename=".$filename);
			header("Content-Transfer-Encoding: binary");
			header("Pragma: no-cache");
			header("Expires: 0");
		
		}else{
			Header("Content-type: file/unknown");
			Header("Content-Disposition: attachment; filename=".$filename);
			Header("Content-Transfer-Encoding: binary");
			Header("Content-Length: ".$file_size);
			Header("Content-Description: PHP3 Generated Data");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		
		//������ ���, �����մϴ�.
		$fp = fopen($file, "rb");
		
		if (!fpassthru($fp)) {
			fclose($fp);
		}
	}
?>