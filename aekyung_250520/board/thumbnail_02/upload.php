<?php
if(is_array($_FILES)) {
	if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
	$sourcePath = $_FILES['userImage']['tmp_name'];
	$filePath = $_SERVER["DOCUMENT_ROOT"]."/user/upload/";


	$arrExe = explode(".", $_FILES['userImage']['name']);
	$exetention = $arrExe[1];

	if($exetention == "php" || $exetention == "php3" || $exetention == "html" || $exetention == "htm"){
		$exetention .= "s";
	}

	$filenameTemp = $_FILES['userImage'][name];
	$num = 0;
	$exists = file_exists($filePath.$_FILES['userImage'][name]);
	while($exists){
		$filenameTemp = $arrExe[0]."[".$num."].".$exetention;
		$exists = file_exists($filePath.$filenameTemp);
		$num++;
	}

		if(move_uploaded_file($sourcePath,($filePath.$filenameTemp))) {
		?>
		<?php echo $filenameTemp; ?>
		<?php 
		}
	}
}
?>