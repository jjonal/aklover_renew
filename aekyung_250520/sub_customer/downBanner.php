<?
//모바일에서도 사용
$folder = "../image2/";
if($_GET["gubun"] == "1") {
	$filename = "aklover_common.jpg";
	$orifilename = "공정위문구.jpg";
} else if($_GET["gubun"] == "2") {
	$filename = "banner_point_04_05.jpg";
	$orifilename = "포인트_공정위문구.jpg";
}
ob_start();
if(eregi("(MSIE 5.0|MSIE 5.1|MSIE 5.5|MSIE 6.0|MSIE 7|MSIE 8|MSIE 9|MSIE 10|Trident/7.0)",$_SERVER["HTTP_USER_AGENT"])){
	
	//$filenames = iconv("UTF-8","CP949", $filename);
	$file_all = $folder.$filename;
	echo $filename;
	if (!is_file($file_all)) {
		die('File download error.'.$filename);
	}
	
	
	$mime = array('application/octet-stream');
	header('Content-Type: '.$mime);
	//header("Content-Disposition: attachment; filename=".$orifilename);
	header("Content-Disposition: attachment; filename=".iconv('euc-kr','UTF-8',$orifilename));
	header('Content-Transfer-Encoding: binary');
	header("Content-Length: ".filesize($file_all));
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header("Content-Description: File Transfer");
	header('Expires: 0');
	 
}else{ 
	
	$file_all = $folder.$filename;
	
	if (!is_file($file_all)) {
		die('File download error.'.$filename);
	}
	
	header("Content-Type: doesn/matter");
	header("Content-Disposition: attachment; filename=".iconv('euc-kr','UTF-8',$orifilename));
	header("Content-Length: ".filesize($file_all));
	header("Content-Description: PHP3 Generated Data");
	header("Cache-Control: cache, must-revalidate");

	header("Content-Description: File Transfer");
	header("Pragma: no-cache");
	header("Expires: 0");
}
######################################################################################################################################################
$fp = fopen($file_all, 'rb'); 
 while(!feof($fp)) { 
     echo fread($fp, 100*1024); 
     flush(); 
}
fclose ($fp);
######################################################################################################################################################
?>