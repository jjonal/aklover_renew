<?php

if(is_array($_FILES)) {
	if(is_uploaded_file($_FILES['instaBannerFile']['tmp_name'])) {
		
	$sourcePath = $_FILES['instaBannerFile']['tmp_name'];
	$filePath = $_SERVER["DOCUMENT_ROOT"]."/image2/banner/";


	$arrExe = explode(".", $_FILES['instaBannerFile']['name']);
	$exetention = $arrExe[1];

	if($exetention == "php" || $exetention == "php3" || $exetention == "html" || $exetention == "htm"){
		$exetention .= "s";
	}

	$filenameTemp = $_FILES['instaBannerFile'][name];
	$num = 0;
	$exists = file_exists($filePath.$_FILES['instaBannerFile'][name]);
	while($exists){
		$filenameTemp = $arrExe[0].$num.".".$exetention;
		$exists = file_exists($filePath.$filenameTemp);
		$num++;
	}

		if(move_uploaded_file($sourcePath,($filePath.$filenameTemp))) {
			echo $filenameTemp; 
		}
	}
}
?>