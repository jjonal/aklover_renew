<? 

if($_SESSION['temp_level'] < 9997){ //관리자 팝업화면 권한 체크
	echo '<script>alert("권한이 없습니다.")</script>';
	echo '<script>location.href="'.PATH_END.'out.php"</script>';exit;
}
?>