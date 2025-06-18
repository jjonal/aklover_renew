<?
define('_HEROBOARD_', TRUE);
include_once                                '../../freebest/head.php';
include                                     FREEBEST_INC_END.'hero.php';
include                                     FREEBEST_INC_END.'function.php';
?>
<!DOCTYPE html>

<html>
<head></head>
<body>
<form name="form_excel" method="post" enctype="multipart/form-data" action="excelUpload_test.php">
	<input type="file" name="upload_excel" />
	<input type="submit" value="전송" />
</form>
</body>
</html>