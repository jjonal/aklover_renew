<?php
####################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
####################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
####################################################################################################################################################
function checkReferer($url) {
   $referer = $_SERVER['HTTP_REFERER'];
   $res = strpos($referer,$url);
   return $res == 0 ? false : true;
}
  
	if(!checkReferer("/main/index.php")){ 
		echo "<script>
		alert('�߸��� ���� �Դϴ�.');
		history.go(-1);
		</script>";
		exit;
	}

	$id = $_REQUEST["id"];
	$auth = $_REQUEST["auth"];
	$pass = $_REQUEST["newPw"];
	$repass = $_REQUEST["chNewPw"];

	if($id == $pass){
		echo "<script>
		alert('���̵�� ��й�ȣ�� ���� �� �� �����ϴ�.');
		history.go(-1);
		</script>";
		exit;
	}
	if($repass != $pass){
		echo "<script>
		alert('��й�ȣ�� ��й�ȣ Ȯ���� ��ġ���� �ʽ��ϴ�.');
		history.go(-1);
		</script>";
		exit;
	}
	
	$hero_idx = 0;
	$hero_id = "";
	$target_idx = 0;

	//��й�ȣ ���� ��û Ȯ��
	if($id != "" && $auth != ""){
		$sql = "SELECT hero_idx, hero_id, target_idx FROM reset_pw WHERE hero_id='".$id."' and  auth_code='".$auth."' and DATEDIFF(hero_date, now()) > -3";
		$res = mysql_query($sql);
		
		if(!$res){			
			echo "<script>
			alert('�ý��� �����Դϴ�.�����ڿ��� ���� �ٶ��ϴ�.');
			history.go(-1);
			</script>";
			exit;		
		}
		
		$list = mysql_fetch_assoc($res);
		
		$hero_idx = (int)$list["hero_idx"];
		$hero_id = $list["hero_id"];
		$target_idx = $list["target_idx"];
	}

	if($hero_idx == 0){
		echo "<script>
		alert('��ȿ�� ��й�ȣ ã�� ��û�� �ƴմϴ�.');
		history.go(-1);
		</script>";
		exit;
	}


	//ȸ�� Ȯ��
	$sql = "SELECT COUNT(*) as ct, hero_id FROM member WHERE hero_idx=".$target_idx." and hero_use=0";
	$res = mysql_query($sql);
	
	if(!$res){			
		echo "<script>
		alert('�ý��� �����Դϴ�.�����ڿ��� ���� �ٶ��ϴ�.');
		history.go(-1);
		</script>";
		exit;		
	}
	$list = mysql_fetch_assoc($res);
	if((int)$list["ct"] == 0){
		echo "<script>
		alert('ȸ�������� �������� �ʽ��ϴ�.');
		history.go(-1);
		</script>";
		exit;
	}

	//��й�ȣ ����
	$login_id = $list['hero_id'];
	$pw_md5 = md5($pass);
	$temp = $pw_md5.$login_id;
	$pw_sha3_256 = sha3_hash('sha3-256', $temp);
	
	$sql = "UPDATE member SET hero_pw='".$pw_sha3_256."' WHERE hero_idx=".$target_idx;
	//echo $sql;
	//exit;
	mysql_query($sql);


	//��й�ȣ ���� ��û ó��
	$sql = "UPDATE reset_pw set auth_code=NULL, reset_ip='".$_SERVER["REMOTE_ADDR"]."', reset_date=now() WHERE hero_idx=".$hero_idx;
	mysql_query($sql);

	echo "<script>
	alert('��й�ȣ�� ���� �Ͽ����ϴ�. �α��� �� ���ٶ��ϴ�.');
	location.replace('/');
	</script>";
	exit;
?>
