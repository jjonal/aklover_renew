<!DOCTYPE html> 
<?php 
$video = $_GET['video'];
?>

<html> 
<body style="background: #000;"> 
	<div style="margin:0 auto;  width: 700px";">
		<video width="700" height="700" controls autoplay>
		  <source src="/image2/video/<?=$video?>.mp4" type="video/mp4">
		</video>
	</div>
</body>
</html>