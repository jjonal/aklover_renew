<?php
####################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
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
		alert('잘못된 접근 입니다.');
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
		alert('아이디와 비밀번호를 같게 할 수 없습니다.');
		history.go(-1);
		</script>";
		exit;
	}
	if($repass != $pass){
		echo "<script>
		alert('비밀번호와 비밀번호 확인이 일치하지 않습니다.');
		history.go(-1);
		</script>";
		exit;
	}
	
	$hero_idx = 0;
	$hero_id = "";
	$target_idx = 0;

	//비밀번호 변경 요청 확인
	if($id != "" && $auth != ""){
		$sql = "SELECT hero_idx, hero_id, target_idx FROM reset_pw WHERE hero_id='".$id."' and  auth_code='".$auth."' and DATEDIFF(hero_date, now()) > -3";
		$res = mysql_query($sql);
		
		if(!$res){			
			echo "<script>
			alert('시스템 에러입니다.관리자에게 문의 바랍니다.');
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
		alert('유효한 비밀번호 찾기 요청이 아닙니다.');
		history.go(-1);
		</script>";
		exit;
	}


	//회원 확인
	$sql = "SELECT COUNT(*) as ct, hero_id FROM member WHERE hero_idx=".$target_idx." and hero_use=0";
	$res = mysql_query($sql);
	
	if(!$res){			
		echo "<script>
		alert('시스템 에러입니다.관리자에게 문의 바랍니다.');
		history.go(-1);
		</script>";
		exit;		
	}
	$list = mysql_fetch_assoc($res);
	if((int)$list["ct"] == 0){
		echo "<script>
		alert('회원정보가 존재하지 않습니다.');
		history.go(-1);
		</script>";
		exit;
	}

	//비밀번호 변경
	$login_id = $list['hero_id'];
	$pw_md5 = md5($pass);
	$temp = $pw_md5.$login_id;
	$pw_sha3_256 = sha3_hash('sha3-256', $temp);
	
	$sql = "UPDATE member SET hero_pw='".$pw_sha3_256."' WHERE hero_idx=".$target_idx;
	//echo $sql;
	//exit;
	mysql_query($sql);


	//비밀번호 변경 요청 처리
	$sql = "UPDATE reset_pw set auth_code=NULL, reset_ip='".$_SERVER["REMOTE_ADDR"]."', reset_date=now() WHERE hero_idx=".$hero_idx;
	mysql_query($sql);

	echo "<script>
	alert('비밀번호를 변경 하였습니다. 로그인 후 사용바랍니다.');
	location.replace('/');
	</script>";
	exit;
?>
