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

//$_GET["mission_idx"] = $_GET['idx']; //����� ���� ���� �ٸ�
$_GET["idx"] = $_GET['mission_idx']; //����� ���� ���� �ٸ�

$sql = 'select * from mission where hero_table = \''.$_GET['board'].'\' and hero_idx=\''.$_GET['idx'].'\';';
sql($sql, 'on');
$out_row = @mysql_fetch_assoc($out_sql);

$mission_board_type = false; //�ҹ�����, �̼� �����ϱ� Ÿ��
if($out_row["hero_type"] == "2" ||  $out_row["hero_type"] == "10") {
	$mission_board_type = true;
}

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
} else if($focus_group && ($_SESSION["before_beauty_auth"] == "Y" || $_SESSION["before_life_auth"] == "Y" || $_SESSION["before_beautymovie_auth"] == "Y" || $_SESSION["before_lifemovie_auth"] == "Y")) {
	$missionAuth = true;
}

if($my_view < 9999) {
	$sql_write_check = " SELECT hero_code, delivery_point_yn FROM mission_review WHERE hero_old_idx = '".$_GET['idx']."' AND  hero_code = '".$_SESSION['temp_code']."' ";
	$rs_write_check = mysql_query($sql_write_check);
	$row_write_check = mysql_fetch_assoc($rs_write_check);

//	if(!$row_write_check["hero_code"]) {
//		error_historyBack("��û������ �����ϴ�.");
//	}
}

if($missionAuth){
	$sql_01 = 'select * from mission_review where hero_old_idx=\''.$_GET['idx'].'\' order by hero_today desc';
	$out_sql_01 = @mysql_query($sql_01);
	$count_01 = @mysql_num_rows($out_sql_01);
}

?>
<link href="css/general_viewer.css?v=1" rel="stylesheet" type="text/css">
<link href="css/musign/mission_application.css" rel="stylesheet" type="text/css">
<div id="content" class="guide_popup popup mission_aplication" style="display:none;">
	<div class="inner rel">
		<!-- (s) ��Ʈ�� ���� -->
		<!--	--><?// include_once "boardIntroduce.php"; ?>
		<!-- (e) ��Ʈ�� ���� -->

		<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="�ݱ�"></div>
		<div class="scroll popup_contents">
			<img src="<?=$img_new?>"/>
			<div class="mission_top">
				<h2 class="fw600"><?=$out_row['hero_title']?></h2>
				<ul>
					<li class="f_b">
						<p class="fw600 f_cs"><img src="/img/front/icon/twinkle.webp" alt="�� ������" class="star_ic"/>����Ⱓ</p>
						<p class="f_cs"><?=date( "y�� m�� d��", strtotime($out_row['hero_today_01_01']));?> ~ <?=date( "y�� m�� d��", strtotime($out_row['hero_today_04_02']));?></p>
					</li>
					<? if($my_view>9998){ ?>
						<li class="f_b">
							<p class="fw600"><img src="/img/front/icon/twinkle.webp" alt="�� ������" class="star_ic"/>��û�� �ο�</p>
							<p><?=$count_01?> ��</p>
						</li>
					<? } ?>
				</ul>
			</div>
			
			<!--		--><?// include_once("missionDate.php") ?>
			
			<h3 class="fw600 fz16">ü��� ��û��</h3>
			<div class="application_list">
				<div class="notice">
					<p class="fz12 flex"><span>- </span> ü��ܿ� �����ǽ� �в��� �޴��� ���ڸ� ���� �ȳ��� �帳�ϴ�.</p>
					<p class="fz12 flex"><span>- </span> �߰� ���ǻ����� ������ 1:1���Ƿ� ���ּ���.</p>
				</div>
				<ul class="f_cl">
					<? 
					$check_day = date( "Y-m-d", time());
					$today_01_01 = date( "Y-m-d", strtotime($out_row['hero_today_01_01']));
					$today_01_02 = date( "Y-m-d", strtotime($out_row['hero_today_01_02']));
					
					while($list_01 = @mysql_fetch_assoc($out_sql_01)){
						$pk_m_sql = 'select * from member where hero_code = \''.$list_01['hero_code'].'\'';
						$out_pk_m_sql = mysql_query($pk_m_sql);
						$out_pk_m_row = @mysql_fetch_assoc($out_pk_m_sql);	
						if($out_pk_m_row['hero_code']==$_SESSION['temp_code'] || $my_level>=9999){
							$pk_p_sql = 'select * from level where hero_level = \''.$out_pk_m_row['hero_level'].'\'';
							$out_pk_p_sql = mysql_query($pk_p_sql);
							$pk_p_row                             = @mysql_fetch_assoc($out_pk_p_sql);
						
							if($check_day>="2013-11-21")    $hero_mt5_view = $list_01['hero_03'];
							else						    $hero_mt5_view = $list_01['hero_02'];
								
							$hero_mt5_view = str_replace("/////","<br/>",$hero_mt5_view);
					?>
					<li class="f_cs">
						<div class="img_wrap <?php if(str($pk_p_row['hero_img_new']) === "https://www.aklover.co.kr/image/bbs/lev1.png?v=3"){?> position_img <? } ?>">
							<img src="<?=str($pk_p_row['hero_img_new'])?>" alt="level1" /> 
						</div>
						<?=$list_01['hero_nick']?>&nbsp;&nbsp;&nbsp;
						<span style="font-size: 12px;">&nbsp;&nbsp;&nbsp;<?=($list_01['hero_superpass']=='Y')? "[�����н� ���]" : "" ;?></span>
						<? if(($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
								if(!strcmp($list_01['hero_code'], $_SESSION['temp_code'])){?>
									<a href="<?=DOMAIN_END.'m/mission_edit.php?'.get('hero_idx','hero_idx='.$list_01['hero_idx'])?>">[����]</a>
									<a href="<?=DOMAIN_END.'m/mission_edit.php?'.get('type||hero_idx','type=drop&hero_idx='.$list_01['hero_idx'])?>">[����]</a>  
						<?		}
						}?>
					</li>
					<? }
					}?>
				</ul>
			</div>
			
			<!-- <div class="mission_view_btn">
				<a href="<?=DOMAIN_END?>m/mission.php?board=<?=$_GET["board"]?>" class="m_content_btn">���</a>
			</div> -->
		</div>
	</div>
</div> 
<div class="clear"></div>
<!--������ ����-->
<? include_once "tail.php"; ?>	