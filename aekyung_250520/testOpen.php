<? 
session_start();
if($_GET["mode"]=="open") {
	$_SESSION["aklover"] = "yes";
	
	echo $_SESSION["aklover"];
	
}
?>

<? if($_GET["mode"]=="open") {?>
	<p><a href="/main/index.php">PC �������� �̵��ϱ�</a></p>
	<p><a href="/m/main.php">����� �������� �̵��ϱ�</a></p>
	<p><a href="/loaksecure21/logout.php">������ �������� �̵��ϱ�</a></p>
<? } ?>