<?php
// ---------------------------------------------------------------------------
//                              CHXImage
//
// 이 코드는 데모를 위해서 제공됩니다.
// 환경에 맞게 수정 또는 참고하여 사용해 주십시오.
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
	$file_ext = strtolower(substr(strrchr($fName,"."), 1)); //확장자
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
$size=getimagesize($filepath); //원본 이미지사이즈를 구함
$src_im=LoadImage($filepath);
//1 소스의 너비가 높이보다 큰 경우
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
//1-1 소스의 너비가 타겟의 너비보다 작은 경우
if($size[0] < $width){
	//1-1-1 소스의 높이가 타겟의 높이보다 작은 경우
	if($size[1] < $height){//높이를 살려서 너비를 크롭
		$new_width = round(($size[1] * $width)/$height);
		$new_height= $size[1];

		//crop
		$target_width = round($size[0]*$height/$size[1]);
		$target_height = round($size[1]*$height/$size[1]);

		$target_x = -round(($target_width-$new_width)/2);
		$target_y = 0;

		//1-1-2 소스의 높이가 타겟의 높이보다 크거나 같은 경우
		}else{//너비를 살려서 높이를 크롭
		$new_width = $size[0];
		$new_height=round(($size[0] * $height)/$width);

		$target_width = round($size[0]*$height/$size[1]);
		$target_height = round($size[1]*$height/$size[1]);

		$target_x = -round(($target_width-$new_width)/2);
		$target_y = 0;
	}
	//1-2 소스의 너비가 타겟의 너비보다 크거나 같은 경우
	}else{
	//1-2-1 소스의 높이가 타겟의 높이보다 작은 경우
	if($size[1] < $height){//높이를 살리고 너비를 크롭

	//가로길이가 긴 이미지를 전체보이기 위해
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
				
			//단 높이가 $new_height보다 높아야 한다.
			if($target_width < $new_width){
			$target_height = $height;
			$target_width =round($heigt*$size[0]/$size[1]);
			}
			$target_x = 0;
			$target_y = -round(($target_height-$new_height)/2);
			}
			//1-2-2 소스의 높이가 타겟의 높이보다 크거나 같은 경우
			}else{//높이에 맞추어 리사이징, 너비를 크롭
			// Resize
			$new_width = $width;
			$new_height= $height;

			$target_width = round($size[0]*$height/$size[1]);
			$target_height = round($size[1]*$height/$size[1]);

			//단, 너비가 $new_width보다 넓어야 한다.
			if($target_width < $new_width){
			$target_width = $width;
			$target_height =round($width*$size[1]/$size[0]);
		}

$target_x = -round(($target_width-$new_width)/2);
$target_y = 0;
}
}
}else{//2 소스의 높이가 너비보다 크거나 같은 경우
//2-1 소스의 너비가 타겟의 너비보다 작은 경우
if($size[0] < $width){
//2-1-1 소스의 높이가 타겟의 높이보다 작은 경우
if($size[1] < $height){//너비를 살리고 높이를 크롭
$new_width = $size[0];
$new_height=round(($size[0] * $height)/$width);

	$target_width = round($size[0]*$width/$size[0]);
		$target_height = round($size[1]*$width/$size[0]);

		$target_x = 0;
		$target_y = -round(($target_height-$new_height)/2);
}else{
//2-1-2 소스의 높이가 타겟의 높이보다 크거나 같은 경우
$new_width = $size[0];
$new_height=round(($size[0] * $height)/$width);

$target_width = round($size[0]*$width/$size[0]);
$target_height = round($size[1]*$width/$size[0]);

$target_x = 0;
	$target_y = -round(($target_height-$new_height)/2);
}
//2-2 소스의 너비가 타겟의 너비보다 크거나 같은 경우
}else{
//2-2-2 소스의 높이가 타겟의 높이보다 크거나 같은 경우
// Resize
$new_width = $width;
$new_height= $height;

$target_width = round($size[0]*$width/$size[0]);
$target_height = round($size[1]*$width/$size[0]);
	
//단 높이가 $new_height보다 높아야 한다.
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