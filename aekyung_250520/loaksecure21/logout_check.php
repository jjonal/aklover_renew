<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD����
include_once '../freebest/head.php';
if(strcmp($_POST['logout_check'], 'logout_check')){echo '<script>location.href="'.PATH_END.'out.php"</script>';exit;}
######################################################################################################################################################
include_once FREEBEST_INC_END.'function.php';
######################################################################################################################################################
$login_pw = $_POST['login_pw'];
$login_id = $_POST['login_id'];
$pw_md5 = md5($login_pw);
$temp = $pw_md5.$login_id;
$pw_sha3_256 = sha3_hash('sha3-256', $temp);

$sql = "select * from admin where hero_id = '".$_POST['login_id']."' and hero_pw = '".$pw_sha3_256."' and hero_level >= 9996 and hero_use = 0;";

sql($sql, 'end');
$count = @mysql_num_rows($out_sql);
if( (!strcmp($count, '')) or (!strcmp($count, '0')) ){
//    iconv('EUC-KR', 'UTF-8', '<font color=blue>���̵�� ��й�ȣ�� �ٽ� Ȯ���� �ּ���.');
	echo '<script>
			alert(\'���̵�� ��й�ȣ�� Ȯ���� �ּ���.\');
			location.href="'.PATH_END.'out.php";
		  </script>';
	exit;
}else{
	$chk_id_cookie = $_POST['chk_id_cookie'];
    if($chk_id_cookie=="true"){
    	//�Ѵް� ���̵� ����
    	setcookie("cookie_login_id",$_POST["login_id"],time()+(29*24*60*60));
    }else{
    	//üũ�� ������ ����
    	setcookie("cookie_login_id","",time()+(30*24*60*60));
    }
	
    $list = mysql_fetch_assoc($out_sql);//mysql_fetch_row

    $_SESSION['temp_code'] = $list['hero_code'];
    $_SESSION['temp_id'] = $list['hero_id'];
    $_SESSION['temp_name'] = $list['hero_name'];
    $_SESSION['temp_nick'] = $list['hero_nick'];
    $_SESSION['temp_level'] = $list['hero_level'];
    $_SESSION['temp_write'] = $list['hero_write'];
    $_SESSION['temp_view'] = $list['hero_view'];
    $_SESSION['temp_update'] = $list['hero_update'];
    $_SESSION['temp_rev'] = $list['hero_rev'];
    $_SESSION["temp_loginTime"] = date("YmdHis");
    if(!strcmp($list['hero_dropday'], '')){
    }else{
        $_SESSION['temp_drop'] = date( "Y-m-d", strtotime($list['hero_dropday']));
    }
	echo "<script> 
			document.location.href='index.php'; 
		   </script>"; 

}
?>
