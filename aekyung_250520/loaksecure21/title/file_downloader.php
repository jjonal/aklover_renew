<?php 

	//보안 관련
	define("__CASTLE_PHP_VERSION_BASE_DIR__", $_SERVER['DOCUMENT_ROOT']."/castle-php/"); 
	include_once(__CASTLE_PHP_VERSION_BASE_DIR__ . "castle_referee.php");
	
	if(!$_GET['file']){
		
		"<script>alert('잚못된 접급입니다.');history.back(-1)</script>";
		
	}

	// 파일 Path를 지정합니다.
	// id값등을 이용해 Database에서 찾아오거나 GET이나 POST등으로 가져와 주세요.
	$filePath = $_GET['file'];
	$file = $_SERVER['DOCUMENT_ROOT']."/loaksecure21/manual_folder/".$filePath;
	$file_size = filesize($file);
	$filename = urlencode($filePath);
	// 접근경로 확인 (외부 링크를 막고 싶다면 포함해주세요)
	if (!eregi($_SERVER['HTTP_HOST'], $_SERVER['HTTP_REFERER'])){
		echo "<script>alert('외부 다운로드는 불가능합니다.');</script>";
		return;
	}
	if (is_file($file)){
		// 파일 전송용 HTTP 헤더를 설정합니다.
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
		
		//파일을 열어서, 전송합니다.
		$fp = fopen($file, "rb");
		
		if (!fpassthru($fp)) {
			fclose($fp);
		}
	}
?>