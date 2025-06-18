<?
header("Content-Type:text/html; charset=EUC-KR");
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once '../freebest/head.php';
######################################################################################################################################################
include_once FREEBEST_INC_END.'function.php';

if(!strcmp($_POST['type'],'nick')){
	$str_len = strlen($_POST['input']);
	

	$sql = "select * from member where hero_nick = '".$_POST['input']."' ";
	$sql = out($sql);
	sql($sql, 'end');
	$count = @mysql_num_rows($out_sql);
	if(!strcmp($count,'0')){



		//################### 휴면계정 추가 ######################
		$sql = "select * from member_backup where hero_nick = '".$_POST['input']."' ";
		$sql = out($sql);
		sql($sql, 'end');
		$count = @mysql_num_rows($out_sql);

		if($count == 0){
			$out = "<font style='color:".$_MAIN_COLOR[1].";'>사용하실 수 있습니다.</font>";
			$out .= '<input type=hidden id="nick_action" value="hero_ok">';
		}else{
			$out = "<font style='color:".$_MAIN_COLOR[0].";'>이미 사용 중인 닉네임입니다.</font>";
			$out .= '<input type="hidden" id="nick_action" value="hero_down">';
		}
		//################### 휴면계정 추가 ######################




	}else{
		$out = "<font style='color:".$_MAIN_COLOR[0].";'>input이미 사용 중인 닉네임입니다.</font>".$sql;
		$out .= '<input type="hidden" id="nick_action" value="hero_down">';
	}
	echo $out;
	//echo iconv('EUC-KR', 'UTF-8', $out);
} else if(!strcmp($_POST['type'],'hero_user')){
	//$sql = " SELECT count(*) cnt FROM member WHERE hero_use = 0 AND ".$_POST["hero_user_type"]." = '".iconv("utf-8","euc-kr",$_POST["hero_user"])."' ";
	$sql = " SELECT count(*) cnt FROM member WHERE hero_use = 0 AND ".$_POST["hero_user_type"]." = '".$_POST["hero_user"]."' ";
	sql($sql, 'on');
	$rs = @mysql_fetch_assoc($out_sql);
	echo $sql;
}


?>
