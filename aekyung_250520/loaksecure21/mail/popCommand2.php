<!DOCTYPE html>
<?
define('_HEROBOARD_', TRUE);
include_once '../../freebest/head.php';
include                                    '../popupSessionCheck.php';
include                                     FREEBEST_INC_END.'hero.php';
include                                     FREEBEST_INC_END.'function.php';

$hero_idx = $_GET["hero_idx"];

$sql = 'SELECT hero_command2 FROM mail WHERE hero_idx=\''.$_GET['hero_idx'].'\';';
sql($sql, 'on');
$out_row = @mysql_fetch_assoc($out_sql);

$temp_command = htmlspecialchars_decode ( $out_row['hero_command2'] );
$next_command = str_ireplace ( '<img', '<img onerror="this.src=\'' . IMAGE_END . 'hero.jpg\';" ', $temp_command );
?>
<meta charset="euc-kr" />
<head>
<link rel="stylesheet" type="text/css" href="<?=ADMIN_DEFAULT?>/css/admin.css" />
<script type="text/javascript" src="<?=JS_END;?>jquery.min.js"></script>
<script type="text/javascript" src="<?=JS_END;?>jquery.form.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
</head>
<body style="background:none;">
<div class="popupWrap">
	
	<div class="popHeader">
		<h1>쪽지함 내용</h1>
	</div>
	<div class="popContents">
	<?=$next_command;?>
	</div>
		
</div>
</body>
<html>