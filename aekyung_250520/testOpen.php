<? 
session_start();
if($_GET["mode"]=="open") {
	$_SESSION["aklover"] = "yes";
	
	echo $_SESSION["aklover"];
	
}
?>

<? if($_GET["mode"]=="open") {?>
	<p><a href="/main/index.php">PC 페이지로 이동하기</a></p>
	<p><a href="/m/main.php">모바일 페이지로 이동하기</a></p>
	<p><a href="/loaksecure21/logout.php">관리자 페이지로 이동하기</a></p>
<? } ?>