<?
include_once "head.php";

if(!strcmp($_SESSION['temp_level'], '')){
    $my_level = '0';
    $my_write = '0';
    $my_view = '0';
    $my_update = '0';
    $my_rev = '0';
}else{
    $my_level = $_SESSION['temp_level'];
    $my_write = $_SESSION['temp_write'];
    $my_view = $_SESSION['temp_view'];
    $my_update = $_SESSION['temp_update'];
    $my_rev = $_SESSION['temp_rev'];
}

$cut_title_name = '26';
$_GET['board'];
$sql = 'select * from mission where hero_table = \''.$_GET['board'].'\' and hero_idx=\''.$_GET['mission_idx'].'\';';
sql($sql, 'on');
$out_row = @mysql_fetch_assoc($out_sql);//mysql_fetch_row

$mission_board_type = false; //소문내기, 미션 인증하기 타입
if($out_row["hero_type"] == "2" ||  $out_row["hero_type"] == "10") {
	$mission_board_type = true;
}

$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);

$missionAuth = false;

if($right_list['hero_view'] <= $my_view){
	$missionAuth = true;
} else if($_GET["board"] == "group_04_06" && $_SESSION["before_beauty_auth"] == "Y") {
	$missionAuth = true;
} else if($_GET["board"] == "group_04_27" && ($_SESSION["before_beautymovie_auth"] == "Y" || $_SESSION["before_lifemovie_auth"] == "Y")) {
	$missionAuth = true;
} else if($_GET["board"] == "group_04_28" && $_SESSION["before_life_auth"] == "Y") {
	$missionAuth = true;
}

if($my_view < 9999) {
	$sql_write_check = " SELECT hero_code, delivery_point_yn FROM mission_review WHERE hero_old_idx = '".$_GET['mission_idx']."' AND  hero_code = '".$_SESSION['temp_code']."' ";
	$rs_write_check = mysql_query($sql_write_check);
	$row_write_check = mysql_fetch_assoc($rs_write_check);

	if(!$row_write_check["hero_code"]) {
		error_historyBack("신청정보가 없습니다.");
	}
}

if($missionAuth){
######################################################################################################################################################
$temp_id = $_SESSION['temp_id'];
$temp_code = $_SESSION['temp_code'];
$temp_title = $right_list['hero_title'];
$temp_point = $right_list['hero_view_point'];
$temp_idx = $_GET['idx'];
######################################################################################################################################################
/////////////////////////////////////////////////////////hero_mission_idx
$sql_01 = 'select * from mission_review where hero_old_idx=\''.$_GET['mission_idx'].'\' and hero_code=\''.$_SESSION['temp_code'].'\' order by hero_today desc';
$out_sql_01 = @mysql_query($sql_01);
$count_01 = @mysql_num_rows($out_sql_01);
$list_01 = @mysql_fetch_assoc($out_sql_01);

//삭제시
if(!strcmp($_GET['type'], 'drop')){
	pointDel($_GET['hero_idx'] ,$_GET['board'],"mission_application");
	$drop_mission_sql = 'DELETE FROM mission_review WHERE hero_idx = \''.$_GET['hero_idx'].'\'';
	@mysql_query($drop_mission_sql);
	
	//배송피 포인트 삭제
	if($out_row["delivery_point_yn"] == "Y" && $row_write_check["delivery_point_yn"] == "Y") {
		deliveryPoint($_GET['mission_idx'], $_SESSION["temp_id"], $_SESSION['temp_code'], $_SESSION['temp_name'], $_SESSION['temp_nick'], -$_DELIVERY_POINT);
	}
	
	if($mission_board_type) {
		$board_sql = " SELECT hero_idx FROM board WHERE hero_code = '".$_SESSION['temp_code']."' AND hero_01 = '".$_GET['mission_idx']."' AND hero_table = '".$_GET['board']."' ";
		$board_res = sql($board_sql);
		$board_rs = mysql_fetch_assoc($board_res);
		
		$drop_mission_sql = "DELETE FROM board WHERE hero_code = '".$_SESSION['temp_code']."' AND hero_01 = '".$_GET['mission_idx']."' AND hero_table = '".$_GET['board']."'";
		@mysql_query($drop_mission_sql);
		
		$del_mission_url_sql = " DELETE FROM mission_url WHERE board_hero_idx = '".$board_rs["hero_idx"]."' ";
		sql($del_mission_url_sql);
	}
	
	//설문조사 삭제
	$drop_survey_sql = " DELETE FROM mission_survey_answer WHERE mission_review_idx = '".$_GET['hero_idx']."' ";
	@mysql_query($drop_survey_sql);

    $msg = '삭제 되었습니다.';
    $get_herf = get('mission_idx||hero_idx||type','','');
    $action_href = DOMAIN_END.'m/mission.php?'.$get_herf;
    location($action_href);
    exit;
}

?>

<link href="css/general_completion.css" rel="stylesheet" type="text/css">
<!--컨텐츠 시작-->
<div id="content">     
    <? include_once "boardIntroduce.php"; ?>
    <div class="clear"></div>  

    <div id="content_bg" style="position:relative">
         <img src="img/general/completion_bg.jpg" alt="" width="100%"/>
         <div style="width:100%; margin:auto; text-align:center; position:absolute; top:60%">
          	<p><span style="color:#404040"><?=$list_01['hero_nick']?>님의 체험단 신청</span>이 완료되었습니다.</p>
          	<p>
          		<span style="color:#404040;font-size:0.8em;margin-bottom:10px;">
          
          		<?=($list_01['hero_superpass']=='Y')? "[슈퍼패스 사용]" : "" ;?>
          		</span>
          	</p>
          	
            <a href="<?=DOMAIN_END.'m/mission.php?'.get('hero_idx||mission_idx||type')?>" class="m_content_btn">목록</a>&nbsp;&nbsp;
            <a href="<?=DOMAIN_END.'m/mission_edit.php?'.get('hero_idx','hero_idx='.$list_01['hero_idx'])?>" class="m_content_btn">수정</a>&nbsp;&nbsp;
            <a href="<?=DOMAIN_END.'m/mission_completion.php?'.get('type||hero_idx','type=drop&hero_idx='.$list_01['hero_idx'])?>" class="m_content_btn">삭제</a>
         </div>
    </div>
    
</div> 
     
   <div class="clear"></div>
<!--컨텐츠 종료-->
<?
include_once "tail.php";
}else{
        $msg = '권한';
        $action_href = PATH_HOME.'?'.get('view','download=ok');
        msg($msg.' 없습니다.','location.href="'.$action_href.'"');
    exit;
}
?>