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

$_GET["mission_idx"] = $_GET['idx']; //모바일 변수 값이 다름

$sql = 'select * from mission where hero_table = \''.$_GET['board'].'\' and hero_idx=\''.$_GET['idx'].'\';';
sql($sql, 'on');
$out_row = @mysql_fetch_assoc($out_sql);

$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list = @mysql_fetch_assoc($out_sql);

$focus_group = false;
if($_GET["board"] == "group_04_06" || $_GET["board"] == "group_04_27" || $_GET["board"] == "group_04_28") {
	$focus_group = true;
}

$missionAuth = false;

if($right_list['hero_view'] <= $my_view){
	$missionAuth = true;
} else if($focus_group && ($_SESSION["before_beauty_auth"] == "Y" || $_SESSION["before_beautymovie_auth"] == "Y" || $_SESSION["before_lifemovie_auth"] == "Y" || $_SESSION["before_life_auth"] == "Y")) {
	$missionAuth = true;
}

if($missionAuth){
	$sql_01 = 'select * from mission_review where hero_old_idx=\''.$_GET['idx'].'\' and lot_01=\'1\' order by hero_today desc, hero_idx desc';
	$out_sql_01 = @mysql_query($sql_01);
	$count_01 = @mysql_num_rows($out_sql_01);
}

?>
<style>
.contents {
	padding: 10rem 10px 30rem;
}
.pic_win {
	line-height: 1.4;
	font-size: 14px;
}
.win_list_wrap > p {
	font-size: 20px;
}
.win_list img {
	margin-right: 1rem;
}
.win_list {
	grid-column-gap: 2rem;
	grid-row-gap: 1rem;
}
.win_list li {
	padding: 1rem 0;
	border-bottom: 1px solid var(--border);
	font-size: var(--fz28);
	font-weight: 500;
}
.win_list_wrap .pic_win {
	margin-top: 1.5rem;
	margin-bottom: 1.7rem;
	display: block;
}
</style>
<div id="content" class="contents">			
	<div class="win_list_wrap">
		<p class="bold">선정자 발표</p>
		<span class="pic_win fz24 fw500">*체험단에 선정되신 분께는 휴대폰 문자를 통해 안내해 드립니다.<br /> 추가 문의사항은 고객센터 1:1문의로 해주세요.</span>
        <div class="">
			<ul class="win_list grid_4">	
			<? 
			$check_day = date( "Y-m-d", time());
			$today_01_01 = date( "Y-m-d", strtotime($out_row['hero_today_01_01']));
			$today_01_02 = date( "Y-m-d", strtotime($out_row['hero_today_01_02']));
			if($count_01 > 0) {
			while($list_01 = @mysql_fetch_assoc($out_sql_01)){
				$pk_m_sql = 'select * from member where hero_code = \''.$list_01['hero_code'].'\'';
			    $out_pk_m_sql = mysql_query($pk_m_sql);
			    $out_pk_m_row                             = @mysql_fetch_assoc($out_pk_m_sql);
			    $pk_p_sql = 'select * from level where hero_level = \''.$out_pk_m_row['hero_level'].'\'';
			    $out_pk_p_sql = mysql_query($pk_p_sql);
			    $pk_p_row  = @mysql_fetch_assoc($out_pk_p_sql);    
			?>
				<li>
					<img src="/img/front/main/profile.webp" alt="aklover" class="profile">
					<?=$list_01['hero_nick']?>
				</li>
			<? } 
			} else {?>
				<li>당첨된 인원이 없습니다.</li>
			<? } ?>
		</ul>
	</div>
</div> 

<div class="clear"></div>
<!--컨텐츠 종료-->
<? include_once "tail.php"; ?>	