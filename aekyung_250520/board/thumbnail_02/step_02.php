<?
if(!defined('_HEROBOARD_'))exit;

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
$sql = 'select * from mission where hero_table = \''.$_GET['board'].'\' and hero_idx=\''.$_GET['idx'].'\';';
sql($sql, 'on');
$out_row = @mysql_fetch_assoc($out_sql);//mysql_fetch_row

$mission_board_type = false; //�ҹ�����, �̼� �����ϱ� Ÿ��
if($out_row["hero_type"] == "2" ||  $out_row["hero_type"] == "10") {
	$mission_board_type = true;
}

$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);

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
$temp_id = $_SESSION['temp_id'];
$temp_code = $_SESSION['temp_code'];
$temp_title = $right_list['hero_title'];
$temp_point = $right_list['hero_view_point'];
$temp_idx = $_GET['idx'];

$sql_01 = 'select * from mission_review where hero_old_idx=\''.$_GET['idx'].'\' order by hero_today desc';
$out_sql_01 = @mysql_query($sql_01);
$count_01 = @mysql_num_rows($out_sql_01);

if(!strcmp($_GET['type'], 'drop')){

    pointDel($_GET['hero_idx'], $_GET['board'], "mission_application");
    $drop_mission_sql = 'DELETE FROM mission_review WHERE hero_idx = \''.$_GET['hero_idx'].'\'';
    @mysql_query($drop_mission_sql);

    //����� ����Ʈ ����
    if($out_row["delivery_point_yn"] == "Y" && $row_write_check["delivery_point_yn"] == "Y") {
    	deliveryPoint($_GET['idx'], $_SESSION["temp_id"], $_SESSION['temp_code'], $_SESSION['temp_name'], $_SESSION['temp_nick'], -$_DELIVERY_POINT);
    }

	if($mission_board_type) {
		$board_sql = " SELECT hero_idx FROM board WHERE hero_code = '".$_SESSION['temp_code']."' AND hero_01 = '".$_GET['idx']."' AND hero_table = '".$_GET['board']."' ";
		$board_res = sql($board_sql);
		$board_rs = mysql_fetch_assoc($board_res);

		$drop_mission_sql = "DELETE FROM board WHERE hero_code = '".$_SESSION['temp_code']."' AND hero_01 = '".$_GET['idx']."' AND hero_table = '".$_GET['board']."'";
    	@mysql_query($drop_mission_sql);

    	$drop_mission_url_sql = "DELETE FROM mission_url WHERE board_hero_idx = '".$board_rs["hero_idx"]."' ";
    	@mysql_query($drop_mission_url_sql);
	}

	//�������� ����
	$drop_survey_sql = " DELETE FROM mission_survey_answer WHERE mission_review_idx = '".$_GET['hero_idx']."' ";
	@mysql_query($drop_survey_sql);

    $msg = '���� �Ǿ����ϴ�.';
    $get_herf = get('view||type','view=view','');
    $action_href = PATH_HOME.'?'.$get_herf;
    msg($msg,'location.href="'.$action_href.'"');
	exit;
}

?>

        <div class="contents">
            <div class="spm_step3">
                <div class="box1">
                    <div class="article_img"> <img onerror="this.src='<?=IMAGE_END?>hero.jpg';" src="<?=$out_row['hero_thumb']?>" width='126' height='126'/> </div>
                    <ul class="article_txt">
                        <li class="c_orange"><?=$out_row['hero_title']?></li>
                        <li class="mt20 application">
                            <!--<img src="../image/mission/spm_date.gif" alt="" />-->
                            <div class="check_icon">���� �Ⱓ</div>
                            <?=date( "y�� m�� d��", strtotime($out_row['hero_today_01_01']));?> ~ <?=date( "y�� m�� d��", strtotime($out_row['hero_today_04_02']));?>
                        </li>
                        <?php if($my_view>98){?>
                        <li class="mt5 application">
                            <!--<img src="../image/mission/spm_cnt.gif" alt="" />-->
                            <div class="check_icon">��û�� �ο�</div>
                            <span class="c_orange bold"><?=$count_01?></span> ��
                        </li>
                        <?php }?>
                    </ul>
                </div>

                <div id="content_wrap">
	                <? include_once("missionDate.php") ?>
        		</div>

                <div class="box3">
                    <p style="font-size:14px;margin:10px 0 5px 22px;"><span class="titleLine" style="line-height:21px;">l</span>ü��� ��û��</p>
                    <ul class="txt">
                        <li>ü��ܿ� �����ǽ� �в��� �޴��� ���ڸ� ���� �ȳ��� �帳�ϴ�.</li>
                        <li>�߰� ���ǻ����� ������ 1:1���Ƿ� ���ּ���.</li>
                    </ul>
                <div class="spm_wrap">
					<?
					$check_day = date( "Y-m-d", time());
					$today_01_01 = date( "Y-m-d", strtotime($out_row['hero_today_01_01']));
					$today_01_02 = date( "Y-m-d", strtotime($out_row['hero_today_01_02']));

					while($list_01                             = @mysql_fetch_assoc($out_sql_01)){
					    $pk_m_sql = 'select * from member where hero_code = \''.$list_01['hero_code'].'\'';
					    $out_pk_m_sql = mysql_query($pk_m_sql);
					    $out_pk_m_row                             = @mysql_fetch_assoc($out_pk_m_sql);

					    if($out_pk_m_row['hero_code']==$_SESSION['temp_code'] || $my_level>=9999){
						    $pk_p_sql = 'select * from level where hero_level = \''.$out_pk_m_row['hero_level'].'\'';
						    $out_pk_p_sql = mysql_query($pk_p_sql);
						    $pk_p_row                             = @mysql_fetch_assoc($out_pk_p_sql);

							if($check_day>="2013-11-21")    $hero_mt5_view = $list_01['hero_03'];
							else						    $hero_mt5_view = $list_01['hero_02'];

							$hero_mt5_view = str_replace("/////","<br/>",$hero_mt5_view);

							?>
		                    <dl>
		                        <dd>
		                            <ul>

		                                <li>
		                                	<img src="<?=str($pk_p_row['hero_img_new'])?>" alt="level1" />
		                                	<?=$list_01['hero_nick']?>&nbsp;&nbsp;&nbsp;
		                                	<?php if($_GET['board']=='group_04_07'){?>
		                                		<span style="font-size: 12px;background-color: #f68428;height: 21px;margin-bottom: 5px;color: white;text-align: center;padding: 3px 10px;font-weight: 800;">��û ��ȣ : <?=$list_01['hero_number']?></span>
		                                	<?php }?>
		                                	<span style="font-size: 12px;">&nbsp;&nbsp;&nbsp;<?=($list_01['hero_superpass']=='Y')? "[�����н� ���]" : "" ;?></span>
			                                <?if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
			                                    if(!strcmp($list_01['hero_code'], $_SESSION['temp_code'])){?>
			                                		<a href="<?=PATH_HOME_HTTPS.'?'.get('view','view=step_02_01&hero_idx='.$list_01['hero_idx'])?>">[����]</a>
			                                		<a href="<?=PATH_HOME_HTTPS.'?'.get('type||hero_idx','type=drop&hero_idx='.$list_01['hero_idx'].'&board='.$list_01['hero_table'])?>">[����]</a>
			                                <?}}?>

		                                </li>
		                                <li class="mt5"><?=$hero_mt5_view?> </li>
		                            </ul>
		                        </dd>
		                    </dl>
					<?}}?>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="spm_01"> <img src="../image/mission/spm_bg4.gif" alt="top" /> </div>
                <div class="btngroup tr">
                    <a href="<?=PATH_HOME.'?'.get('view||idx')?>"><img src="../image/bbs/btn_list.gif" alt="���" /></a>
                </div>
            </div>
        </div>
    </div>
<?
}else{
        $msg = '����';
        $action_href = PATH_HOME.'?'.get('view');
        msg($msg.' �����ϴ�.','location.href="'.$action_href.'"');
    exit;
}
?>