<?php
// ---------------------------------------------------------------------------
//                              CHXImage
//
// �� �ڵ�� ���� ���ؼ� �����˴ϴ�.
// ȯ�濡 �°� ���� �Ǵ� �����Ͽ� ����� �ֽʽÿ�.
//
// ---------------------------------------------------------------------------

require_once("config.php");

//----------------------------------------------------------------------------
//
//
define('hero_save_time',                                                         date('Y_m_d_h_i_s', time()),FALSE);
$tempfile = $_FILES['file']['tmp_name'];
$filename = "temp_".hero_save_time.'_'.$_FILES['file']['name'];

$pos = strrpos($filename, '.');
$ext = strtolower(substr($filename, $pos, strlen($filename)));

switch ($ext) {
case '.gif' :
case '.png' :
case '.jpg' :
case '.jpeg' :
	break;
default :
	die("-ERR: File Format!");
}


$random_name = "temp_".hero_save_time.'_'.random_generator() . $ext;
$thumb_path = "/user/photo/".date("Y_m")."/";
$savefile = $_SERVER["DOCUMENT_ROOT"].$thumb_path.$random_name;

$image_size = getimagesize($tempfile);

if($image_size[0]>800 && $_SESSION['temp_level']<9999){

	$temp_name = explode(".",$_FILES['file']['name']);
	$temp_extenstion = $temp_name[count($temp_name)-1];
	
	$temp_filename = time()."_".$_SESSION["temp_id"].".".$temp_extenstion;

	$temp_file = $_SERVER["DOCUMENT_ROOT"].$thumb_path.$temp_filename;

	if(!is_dir($_SERVER["DOCUMENT_ROOT"].$thumb_path))	mkdir($_SERVER["DOCUMENT_ROOT"].$thumb_path, 0707);

	if(move_uploaded_file($_FILES['file']['tmp_name'], $temp_file)){

		$im = thumbnail($temp_file, 730, null);
		
		imagejpeg($im, $savefile, 100);
		imagedestroy($im);
		unlink($temp_file);

	}else{
		echo "0";
		exit;
	}
}else{
	move_uploaded_file($tempfile, $savefile);
}
move_uploaded_file($tempfile, $savefile);


$imgsize = getimagesize($savefile);
$filesize = filesize($savefile);

if (!$imgsize) {
	$filesize = 0;
	$random_name = '-ERR';
	unlink($savefile);
};

$rdata = sprintf( '{"fileUrl": "%s/%s", "filePath": "%s/%s", "origName": "%s", "fileName": "%s", "fileSize": "%d" }',
	SAVE_URL,
	$random_name,
	SAVE_DIR,
	$random_name,
	$filename,
	$random_name,
	$filesize );


//thumbnail ($savefile,175,155);
echo $rdata;

function random_generator ($min=8, $max=32, $special=NULL, $chararray=NULL) {
// ---------------------------------------------------------------------------
//
//
    $random_chars = array();
    
    if ($chararray == NULL) {
        $str = "abcdefghijklmnopqrstuvwxyz";
        $str .= strtoupper($str);
        $str .= "1234567890";

        if ($special) {
            $str .= "!@#$%";
        }
    }
    else {
        $str = $charray;
    }

    for ($i=0; $i<strlen($str)-1; $i++) {
        $random_chars[$i] = $str[$i];
    }

    srand((float)microtime()*1000000);
    shuffle($random_chars);

    $length = rand($min, $max);
    $rdata = '';
    
    for ($i=0; $i<$length; $i++) {
        $char = rand(0, count($random_chars) - 1);
        $rdata .= $random_chars[$char];
    }
    return $rdata;
}


## Image LoadJpeg (String $fName);
function LoadImage ($fName) {
	$file_ext = strtolower(substr(strrchr($fName,"."), 1)); //Ȯ����
	switch ($file_ext) {
		case "jpg": case "jpeg":
			$im = @ImageCreateFromJPEG ($fName);
			break;
		case "gif":
			$im = @ImageCreateFromGIF ($fName);
			break;
		case "png":
			$im = @ImageCreateFromPNG ($fName);
			break;
	}

	if (!$im) {
		$im = imagecreatetruecolor (150, 30);
		$bgc = ImageColorAllocate ($im, 255, 255, 255);
		$tc = ImageColorAllocate ($im, 0, 0, 0);
		ImageFilledRectangle ($im, 0, 0, 150, 30, $bgc);
		ImageString ($im, 1, 5, 5, "Error loading $fName", $tc);
	}
	return $im;
}

## Image thumbnail_jpg(String $filepath, int $width, int $height);
function thumbnail($filepath, $width=null, $height=null) {
$size=getimagesize($filepath); //���� �̹�������� ����
$src_im=LoadImage($filepath);
//1 �ҽ��� �ʺ� ���̺��� ū ���
if($height==null && $width){
$new_width=$width;
$new_height = round($new_width*$size[1]/$size[0]);

$target_width = $new_width;
$target_height = $new_height;

$target_x = 0;
$target_y = 0;

}
elseif($width==null && $height){
$new_height=$height;
$new_width = round($new_height*$size[0]/$size[1]);

$target_width = $new_width;
$target_height = $new_height;

$target_x = 0;
$target_y = 0;

}
elseif($size[0] >= $size[1]){
//1-1 �ҽ��� �ʺ� Ÿ���� �ʺ񺸴� ���� ���
if($size[0] < $width){
	//1-1-1 �ҽ��� ���̰� Ÿ���� ���̺��� ���� ���
	if($size[1] < $height){//���̸� ����� �ʺ� ũ��
		$new_width = round(($size[1] * $width)/$height);
		$new_height= $size[1];

		//crop
		$target_width = round($size[0]*$height/$size[1]);
		$target_height = round($size[1]*$height/$size[1]);

		$target_x = -round(($target_width-$new_width)/2);
		$target_y = 0;

		//1-1-2 �ҽ��� ���̰� Ÿ���� ���̺��� ũ�ų� ���� ���
		}else{//�ʺ� ����� ���̸� ũ��
		$new_width = $size[0];
		$new_height=round(($size[0] * $height)/$width);

		$target_width = round($size[0]*$height/$size[1]);
		$target_height = round($size[1]*$height/$size[1]);

		$target_x = -round(($target_width-$new_width)/2);
		$target_y = 0;
	}
	//1-2 �ҽ��� �ʺ� Ÿ���� �ʺ񺸴� ũ�ų� ���� ���
	}else{
	//1-2-1 �ҽ��� ���̰� Ÿ���� ���̺��� ���� ���
	if($size[1] < $height){//���̸� �츮�� �ʺ� ũ��

	//���α��̰� �� �̹����� ��ü���̱� ����
		if($size[1] > 110){
		$new_width = round(($size[1] * $width)/$height);
			$new_height= $size[1];

			$target_width = round($size[0]*$height/$size[1]);
			$target_height = round($size[1]*$height/$size[1]);

			$target_x = -round(($target_width-$new_width)/2);
			$target_y = 0;
			}else{
			$new_width = $width;
			$new_height= $height;

			$target_width = round($size[0]*$width/$size[0]);
			$target_height = round($size[1]*$width/$size[0]);
				
			//�� ���̰� $new_height���� ���ƾ� �Ѵ�.
			if($target_width < $new_width){
			$target_height = $height;
			$target_width =round($heigt*$size[0]/$size[1]);
			}
			$target_x = 0;
			$target_y = -round(($target_height-$new_height)/2);
			}
			//1-2-2 �ҽ��� ���̰� Ÿ���� ���̺��� ũ�ų� ���� ���
			}else{//���̿� ���߾� ������¡, �ʺ� ũ��
			// Resize
			$new_width = $width;
			$new_height= $height;

			$target_width = round($size[0]*$height/$size[1]);
			$target_height = round($size[1]*$height/$size[1]);

			//��, �ʺ� $new_width���� �о�� �Ѵ�.
			if($target_width < $new_width){
			$target_width = $width;
			$target_height =round($width*$size[1]/$size[0]);
		}

$target_x = -round(($target_width-$new_width)/2);
$target_y = 0;
}
}
}else{//2 �ҽ��� ���̰� �ʺ񺸴� ũ�ų� ���� ���
//2-1 �ҽ��� �ʺ� Ÿ���� �ʺ񺸴� ���� ���
if($size[0] < $width){
//2-1-1 �ҽ��� ���̰� Ÿ���� ���̺��� ���� ���
if($size[1] < $height){//�ʺ� �츮�� ���̸� ũ��
$new_width = $size[0];
$new_height=round(($size[0] * $height)/$width);

	$target_width = round($size[0]*$width/$size[0]);
		$target_height = round($size[1]*$width/$size[0]);

		$target_x = 0;
		$target_y = -round(($target_height-$new_height)/2);
}else{
//2-1-2 �ҽ��� ���̰� Ÿ���� ���̺��� ũ�ų� ���� ���
$new_width = $size[0];
$new_height=round(($size[0] * $height)/$width);

$target_width = round($size[0]*$width/$size[0]);
$target_height = round($size[1]*$width/$size[0]);

$target_x = 0;
	$target_y = -round(($target_height-$new_height)/2);
}
//2-2 �ҽ��� �ʺ� Ÿ���� �ʺ񺸴� ũ�ų� ���� ���
}else{
//2-2-2 �ҽ��� ���̰� Ÿ���� ���̺��� ũ�ų� ���� ���
// Resize
$new_width = $width;
$new_height= $height;

$target_width = round($size[0]*$width/$size[0]);
$target_height = round($size[1]*$width/$size[0]);
	
//�� ���̰� $new_height���� ���ƾ� �Ѵ�.
if($target_height < $new_height){
$target_height = $height;
	$target_width =round($heigt*$size[0]/$size[1]);
}
$target_x = 0;
$target_y = -round(($target_height-$new_height)/2);
}
}


$thumb = imagecreatetruecolor($new_width,$new_height);
imagecopyresized($thumb, $src_im, $target_x, $target_y, 0, 0, $target_width, $target_height, $size[0], $size[1]);

return $thumb;
}

?>