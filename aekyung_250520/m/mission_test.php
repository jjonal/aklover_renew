<?php
include_once "head.php";
#####################################################################################################################################################
if($_GET['kewyword']){
    $search = ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
    $search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
}

$sql = "select * from mission where hero_table='".$_REQUEST['board']."' ".$search;//hero_today_04_02 desc
if( (!strcmp($_SESSION['temp_level'], '10000')) or (!strcmp($_SESSION['temp_level'], '9999')) ){ 
	//������ �� ��� �� ���� �� 
}else{
	//�����ڰ� �ƴҰ��, ����� �̼Ǹ� ������ 
	$sql.=" and ((hero_today_05_01 is null or hero_today_05_01='') or (hero_today_05_01 is not null and hero_today_05_01 != '' and '".date("Y-m-d H:i")."' >= hero_today_05_01)) and ((hero_today_05_02 is null or hero_today_05_02 ='') or (hero_today_05_02 is not null and hero_today_05_02 != '' and '".date("Y-m-d H:i")."' <= hero_today_05_02)) ";
}


$searchType = $_GET['searchType'];
$searchText = $_GET['searchText'];
$statusSearch = $_GET['statusSearch'];
$ymd = date("Y-m-d");
if($statusSearch) {
	switch ($statusSearch) {
		case "A": //��û
			$sql .= " AND '".$ymd."' between hero_today_01_01 and hero_today_01_02 ";
			break;
		case "B": //��ǥ
			$sql .= " AND '".$ymd."' between hero_today_02_01 and hero_today_02_02 ";
			break;
		case "C": //�ı�
			$sql .= " AND '".$ymd."' between hero_today_03_01 and hero_today_03_02 AND hero_today_02_02 != hero_today_03_02 ";
			break;
		case "D": //�����
			$sql .= " AND '".$ymd."' between hero_today_04_01 and hero_today_04_02 AND hero_today_02_02 != hero_today_04_02 ";
			break;
	}
}
if($searchType) {
	$sql .=" and ".$searchType." like '%".$searchText."%' ";
}
sql($sql,"on");
$total_data = @mysql_num_rows($out_sql);



######################################################################################################################################################



$list_page=20;
$page_per_list=5;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;

//http://www.aklover.co.kr/m/board_00.php?board=group_01_01
$next_path=get("page");
######################################################################################################################################################
$group_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_REQUEST['board'].'\';';//desc
//echo $group_sql;
$out_group = @mysql_query($group_sql);
$right_list                             = @mysql_fetch_assoc($out_group);
$my_view 	=	$_SESSION ['temp_view'] == '' ? '0' : $_SESSION ['temp_view'];

// �����̾� �̼��� �α������� ���Ӱ���
$noAuthPage = false;
$temp_auth_hero_code = $_SESSION["temp_code"];
if($_GET ['board'] == 'group_04_06' || $_GET ['board'] == 'group_04_08' || $_GET ['board'] == 'group_04_23' || $_GET ['board'] == 'group_04_25' || $_GET ['board'] == 'group_04_27'){
	if($my_view != '9999' && $my_view != '10000'){
		if($my_view < $right_list['hero_list']) {
			//error_historyBack("�˼��մϴ�. ������ �����ϴ�.");
			//exit;
			
			if($right_list["hero_list"] == "9997") {
				if( $temp_auth_hero_code == "11355" || $temp_auth_hero_code == "16069" || $temp_auth_hero_code == "7632") {
					$noAuthPage = false;
				} else {
					$noAuthPage = true;
				}
			} else {
				$noAuthPage = true;
			}
		}else {
			//���ڴ�
			if($_GET ['board'] == 'group_04_08'){
				if($right_list['hero_list'] == '9998') {
					if($my_view != $right_list['hero_list'] ){
						//error_historyBack("�˼��մϴ�. AKLOVER ���ڴܸ� ������ �� �ֽ��ϴ�.");
						//exit;
						$noAuthPage = true;	
					}
				}else {
					if($my_view < $right_list['hero_list']) {
						//error_historyBack("�˼��մϴ�. ������ �����ϴ�.");
						//exit;
						$noAuthPage = true;	
					}
				}
				
			//�ֽ�Ŭ��
			}else if($_GET ['board'] == 'group_04_23'){
				if($right_list['hero_list'] == '9997') {
					
					if($my_view != $right_list['hero_list']){
						//error_historyBack("�˼��մϴ�. �ֽ�Ŭ���� ������ �� �ֽ��ϴ�.");
						//exit;
						$noAuthPage = true;	
					}
				}else {
					if($my_view < $right_list['hero_list']) {
						//error_historyBack("�˼��մϴ�. ������ �����ϴ�.");
						//exit;
						$noAuthPage = true;	
					}
				}
				
			//��Ƽ��Ÿ
			}else if($_GET['board'] == 'group_04_06'){
				if($right_list['hero_list'] == '9996') {
					if($my_view != $right_list['hero_list'] &&  $_SESSION['temp_id'] != "sr1787"){
						//error_historyBack("�˼��մϴ�. ��Ƽ��Ÿ�� ������ �� �ֽ��ϴ�.");
						//exit;
						$noAuthPage = true;	
					}
				}else {
					if($my_view < $right_list['hero_list']) {
						//error_historyBack("�˼��մϴ�. ������ �����ϴ�.");
						//exit;
						$noAuthPage = true;	
					}
				}
			//��ƼȦ��
			}else if($_GET['board'] == 'group_04_27'){
				if($right_list['hero_list'] == '9995') {
					if($my_view != $right_list['hero_list'] &&  $_SESSION['temp_id'] != "sr1787"){
						//error_historyBack("�˼��մϴ�. ��ƼȦ���� ������ �� �ֽ��ϴ�.");
						//exit;
						$noAuthPage = true;	
					}
				}else {
					if($my_view < $right_list['hero_list']) {
						//error_historyBack("�˼��մϴ�. ������ �����ϴ�.");
						//exit;
						$noAuthPage = true;	
					}
				}
			}
		}
	}
}
######################################################################################################################################################



?>
<link href="css/general.css" rel="stylesheet" type="text/css">
<!--������ ����-->
	
    <!-- <div id="title"><p><?=$right_list['hero_title'];?></p></div>-->
     
     
     
<? include_once "boardIntroduce.php"; ?>
 	<div class="clear"></div>

    <!-- gallery ���� -->
    <? if($noAuthPage) { ?>
    	<? 
    		//���� ��¥�������� �̹��� ���� ���� 2018-12-21
    		// $check_date ���� ����
    		// m/notAuthPage.php ������pc, �����
    		if($_GET['board'] == "group_04_06") {
    		$check_date = date("Ymd");
    		
    			if($check_date < 20190722) { 
		?>
					<div>
        				<img src="/image/mission/19_beauty_5_2.jpg"  width="100%"/>
        			</div>
				<? } else { ?>
						<? include_once("{$_SERVER[DOCUMENT_ROOT]}/m/notAuthPage.php"); ?>
				<? } ?>
    	
    	<? } else { ?>
    		<? include_once("{$_SERVER[DOCUMENT_ROOT]}/m/notAuthPage.php"); ?>
    		
    		<? if($_GET['board'] == "group_04_27") { ?>
    			<? include_once("{$_SERVER[DOCUMENT_ROOT]}/m/notAuthPageYoutuber_Test.php"); ?>
    		<? } ?> 
    		
    	<? } ?>
    <? } else { ?>
  	  	<div id="gallery">
    	<ul id="missionStatus">
        	<? if($_GET['board'] == 'group_04_06' || $_GET['board'] == 'group_04_23' || $_GET['board'] == 'group_04_25' || $_GET['board'] == 'group_04_27'){ //��Ƽ,�ֽ� ?>
            	<li class="missionStatusSearch <?=$_GET['statusSearch']==""?"on":""?>" data-val="">��ü</li>
                <li class="missionStatusSearch <?=$_GET['statusSearch']=="A"?"on":""?>" data-val="A">�ı���</li>
            <? }else { ?>
            	<li class="missionStatusSearch <?=$_GET['statusSearch']==""?"on":""?>" data-val="">��ü</li>
                <li class="missionStatusSearch <?=$_GET['statusSearch']=="A"?"on":""?>" data-val="A">ü��ܽ�û</li>
                <li class="missionStatusSearch <?=$_GET['statusSearch']=="B"?"on":""?>" data-val="B">�����ڹ�ǥ</li>
                <li class="missionStatusSearch <?=$_GET['statusSearch']=="C"?"on":""?>" data-val="C">�ı���</li>
                <li class="missionStatusSearch <?=$_GET['statusSearch']=="D"?"on":""?>" data-val="D">����ڹ�ǥ</li>
            <? } ?>
        </ul>

      	<script>
		$(document).ready(function(){
			$('.missionStatusSearch').click(function(){
				$('.missionStatusSearch').removeClass('on');
				if($(this).attr('class').indexOf('on') != -1) {
					$(this).addClass('on');
				}
				$('#statusSearch').val($(this).attr('data-val'));
				$('#frm').submit();
			})
		})

		</script>
        <ul class="mobileMissionList">
<?
$main_sql = $sql. "order by CASE WHEN (hero_today_01_01<='".date('Y-m-d 00:00:00')."' and hero_today_01_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_01_01 END desc,
	CASE WHEN (hero_today_02_01<='".date('Y-m-d 00:00:00')."' and hero_today_02_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_02_01 END desc,
	CASE WHEN (hero_today_03_01<='".date('Y-m-d 00:00:00')."' and hero_today_03_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_03_01 END desc,
	CASE WHEN (hero_today_04_01<='".date('Y-m-d 00:00:00')."' and hero_today_04_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_04_01 END desc,
	CASE WHEN (hero_today_04_02<='".date('Y-m-d 00:00:00')."') THEN hero_today_04_01 END desc ";

if($_GET['board'] == "group_04_06" || $_GET['board'] == "group_04_23" || $_GET['board'] == "group_04_27") { //��Ƽ, �ֽ�, ��Ʃ��
	$main_sql .= " , hero_today_01_01 DESC ";
} else {
	$main_sql .= " , hero_idx DESC ";
}
	
$main_sql	.= " limit ".$start.",".$list_page." ";

	
	$out_main = @mysql_query($main_sql);
	$cnt = @mysql_num_rows($out_main);
	$i=0;
if( $cnt > 0 ) {
	while($main_list                             = @mysql_fetch_assoc($out_main)){
		$ul_class = "";
		if($i%2 == 0) {
			$ul_class = "class='left'";
		}
		
		$img_parser_url = @parse_url($main_list['hero_img_new']);
		$img_host = $img_parser_url['host'];
		$img_path = $img_parser_url['path'];
		
		if($main_list['hero_thumb']){
			$view_img = $main_list['hero_thumb'];
		}elseif(is_file($main_list['hero_img_new'])){
			$view_img = $main_list['hero_img_new'];
		}else{
			$view_img = IMAGE_END.'hero.jpg';
		}
	
		$content = $main_list['hero_command'];
		$content = TRIM(str_ireplace('&nbsp;', '', strip_tags(htmlspecialchars_decode($content))));
		$content = str_replace("\r", "", $content);
		$content = str_replace("\n", "", $content);
		$content = str_replace("&#65279;", "", $content);
		$content_01 = cut($content,'50');
		if(!strcmp($content_01,"")){
			$content_01 = "&nbsp;";
		}
	
	
		$title = $main_list['hero_title'];
		$title = TRIM(str_ireplace('&nbsp;', '', strip_tags(htmlspecialchars_decode($title))));
		$title = str_replace("\r", "", $title);
		$title = str_replace("\n", "", $title);
		$title = str_replace("&#65279;", "", $title);
		$title_01 = cut($title,'35');
		if(!strcmp($title_01,"")){
			$title_01 = "&nbsp;";
		}
		$check_day = date( "Y-m-d", time());
		$today_01_01 = date( "Y-m-d", strtotime($main_list['hero_today_01_01']));
		$today_01_02 = date( "Y-m-d", strtotime($main_list['hero_today_01_02']));
	
		$today_02_01 = date( "Y-m-d", strtotime($main_list['hero_today_02_01']));
		$today_02_02 = date( "Y-m-d", strtotime($main_list['hero_today_02_02']));
	
		$today_03_01 = date( "Y-m-d", strtotime($main_list['hero_today_03_01']));
		$today_03_02 = date( "Y-m-d", strtotime($main_list['hero_today_03_02']));
	
		$today_04_01 = date( "Y-m-d", strtotime($main_list['hero_today_04_01']));
		$today_04_02 = date( "Y-m-d", strtotime($main_list['hero_today_04_02']));
		
		$mission_complete = '';
	
		
		//�糪, �ֽ�
		if($_GET['board'] == "group_04_23" || $_GET['board'] == 'group_04_06' || $_GET['board'] == 'group_04_25' || $_GET['board'] == 'group_04_27'){
			if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
				$review_menu = "�ı� ���";
				$one_day = date( "m��d��", strtotime($main_list['hero_today_01_01']));
				$two_day = date( "m��d��", strtotime($main_list['hero_today_01_02']));
				$mission_complete ='';
			}else if($today_01_02<$check_day){
				$review_menu = "ü��� ����";
				$mission_complete = "<div style='position:absolute;left:0;top:0;background-color: #eeeeee;opacity: 0.8; width:100%;height:100%;'><img src='/m/img/general/mission_complete.png' style='position:absolute;top:12px;left:15%;'>";
				$one_day = date( "m��d��", strtotime($main_list['hero_today_01_01']));
				$two_day = date( "m��d��", strtotime($main_list['hero_today_01_02']));
			}
		// �糪, �ֽ� �ƴѰ�
		}else {
			if($main_list['hero_type'] == 2) {
				if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
					$review_menu = "�ҹ����� ��û";
					$one_day = date( "m��d��", strtotime($main_list['hero_today_01_01']));
					$two_day = date( "m��d��", strtotime($main_list['hero_today_01_02']));
					$mission_complete ='';
				}else if(($today_02_02 == $today_03_02) and ($today_02_02 == $today_04_02) and ($today_03_02 == $today_04_02) and ($today_02_02 >= $check_day)){
					$review_menu = "�ҹ����� ��ǥ";
					$one_day = date( "m��d��", strtotime($main_list['hero_today_02_01']));
					$two_day = date( "m��d��", strtotime($main_list['hero_today_04_02']));
				}else if(($today_04_02 < $check_day)){
					$review_menu = "�ҹ����� ����";
					$mission_complete = "<div style='position:absolute;left:0;top:0;background-color: #eeeeee;opacity: 0.8; width:100%;height:100%;'><img src='/m/img/general/mission_complete.png' style='position:absolute;top:12px;left:15%;'>";
					$one_day = date( "m��d��", strtotime($main_list['hero_today_01_01']));
					$two_day = date( "m��d��", strtotime($main_list['hero_today_04_02']));
				}
			}else {
				if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
					//20180831 �ӽ÷� ����
					if($main_list['hero_idx'] == "1288") {
						$review_menu = "�̺�Ʈ ��û";
					} else {
						$review_menu = "ü��� ��û";
					}
					$one_day = date( "m��d��", strtotime($main_list['hero_today_01_01']));
					$two_day = date( "m��d��", strtotime($main_list['hero_today_01_02']));
				}else if( ($today_02_01<=$check_day) and ($today_02_02>=$check_day) ){
					$review_menu = "������ ��ǥ";
					$one_day = date( "m��d��", strtotime($main_list['hero_today_02_01']));
					$two_day = date( "m��d��", strtotime($main_list['hero_today_02_02']));
				}else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
					$review_menu = "�ı� ���";
					$one_day = date( "m��d��", strtotime($main_list['hero_today_03_01']));
					$two_day = date( "m��d��", strtotime($main_list['hero_today_03_02']));
				}else if( ($today_04_01<=$check_day) and ($today_04_02>=$check_day) ){
					$review_menu = "����ı� ��ǥ";
					$one_day = date( "m��d��", strtotime($main_list['hero_today_04_01']));
					$two_day = date( "m��d��", strtotime($main_list['hero_today_04_02']));
				}else if($today_04_02<$check_day){
					$review_menu = "ü��� ����";
					$mission_complete = "<div style='position:absolute;left:0;top:0;background-color: #eeeeee;opacity: 0.8; width:100%;height:100%;'><img src='/m/img/general/mission_complete.png' style='position:absolute;top:12px;left:15%;'>";    
					$one_day = date( "m��d��", strtotime($main_list['hero_today_01_01']));
					$two_day = date( "m��d��", strtotime($main_list['hero_today_04_02']));
				}
			}
		}
		
		
		
		
	?>
			
				<li <?=$ul_class?>>
                <span class="ribon"><?=$review_menu?></span>
				<a href="/m/mission_view<?echo ($_REQUEST['board']=='group_04_07')? "_02" : ""; ?>.php?board=<?=$_REQUEST['board']?>&page=<?=$page?>&hero_idx=&mission_idx=<?=$main_list['hero_idx']?>">
					<div><img onerror="this.src='<?=IMAGE_END?>hero.jpg';" src="<?=$view_img?>" width="100%"></div>
					<div class="title"><?=$title_01?></div>
					<div class="date">
						<?=$one_day?> - <?=$two_day?>
					</div>
				</a>
				<?=$mission_complete?>
				</li>
			
	<?
	$i++;
	}
	?>
    </ul>
    <?
}else {
	?>
 		<div id="blankList">
        	�˻������ �����ϴ�.
        </div>
	<? 
} 
?>
     </ul>
     <div class="clear"></div> 
	 </div>
    
	     
        <div id="page_number" style="text-align:center">
        <?include_once "page.php"?>
        </div>
        <? include_once 'searchBox.php';?>
        <!-- gallery ���� --> 
   <? } ?>
      
    
<!--������ ����-->

<script>
<? if(!strcmp($_REQUEST['download'],"ok")){?>
downMenu();
<? } ?>
</script>
<?include_once "tail.php";?>