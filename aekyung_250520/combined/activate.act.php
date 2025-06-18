<?
//######################## 최초 실행, 비 로그인 1년이 넘은 모든 대상자를 휴면으로 처리 #######################
define('_HEROBOARD_', TRUE);
include_once '../freebest/head.php';
include_once '../freebest/hero.php';
include_once '../freebest/function.php';

db("aekyung");
if(!eregi(getenv("HTTP_HOST"),getenv("HTTP_REFERER")))
{
     echo "<script>alert(\"올바른 경로로 접근해주세요.\");history.go(-1);</script>";
     exit;
}


//1. backup 테이블에서 복원
$sql1 = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS  WHERE table_name = 'member' AND table_schema='aekyung' ";//컬럼조회
$res1 = mysql_query($sql1) or die(mysql_error());
$sql2 = "update member as A,member_backup as B set ";
while($rs1 = mysql_fetch_array($res1)){
	if($rs1["COLUMN_NAME"] == "hero_idx"){
	} else if($rs1["COLUMN_NAME"] == "hero_today") { //190520 수정 미장기회원 동의 시 로그인 시간 현재시간으로 변경
		$sql2 .= "A.".$rs1["COLUMN_NAME"]." = now() ,";
	} else {
		$sql2 .= "A.".$rs1["COLUMN_NAME"]."=B.".$rs1["COLUMN_NAME"].",";
	}
}
$sql2.="A.hero_idx=A.hero_idx where A.hero_code=B.hero_code and B.hero_code='".$_REQUEST["hero_code"]."' ";//기존 데이터에서 null 처리 시킴
mysql_query($sql2) or die(mysql_error());


//2. backup 테이블에서 삭제
$sql_backupdelete = "delete from member_backup where hero_code='".$_REQUEST["hero_code"]."'";
$res_backupdelete = mysql_query($sql_backupdelete) or die(mysql_error());

//3. 회원 히스토리 테이블 저장
$sql_backup = "insert into member_backup_history (hero_code,hero_type,hero_today) values ('".$_REQUEST["hero_code"]."','in',now())";
$res_backup = mysql_query($sql_backup) or die(mysql_error());

echo "<script>
alert(\"계정을 활성화 하였습니다. 로그인 후 이용해 주세요.\");";
if($_REQUEST["mobilepc"]=="pc"){
	echo "window.location.replace('/main/index.php');";
}elseif($_REQUEST["mobilepc"]=="mobile"){
	echo "window.location.replace('/m/main.php');";
}
echo  "</script>";
?>