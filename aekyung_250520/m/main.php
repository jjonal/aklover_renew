<?php

######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD���� 
#####################################################################################################################################################
// ������ 2023.04.27
//echo '<script>location.href="http://'.$_SERVER['HTTP_HOST'].'/server_job_notice/aklover_notice_230427.html"</script>';exit;

//��� ����
include_once "head.php";
//��� ����

$loyal_period_sql = " SELECT if(startdate <= date_format(now(),'%Y-%m-%d') AND enddate >= date_format(now(),'%Y-%m-%d'),1,0) as status, hero_month FROM member_loyal_period ";
$loyal_period_res = sql($loyal_period_sql);
$loyal_period_rs = mysql_fetch_assoc($loyal_period_res);

if($loyal_period_rs["status"] == "1") { //����
	$startDateOfMonth = date("Y-m")."-01";
	$timestamp = strtotime($startDateOfMonth)-1;
	$gisu_date = date("Ym", $timestamp);
	$gisu_year = substr($gisu_date,0,4);
	$gisu_month = substr($gisu_date,4,2);
	
	$hero_month = "";
	if($loyal_period_rs["hero_month"] > 0) {
	    $hero_month = $loyal_period_rs["hero_month"]."�� ";
	}
	
	//�̴��� Loyal ȸ��
	$review_member_sql =  " SELECT m.hero_nick FROM member_loyal l INNER JOIN member m ON l.hero_code = m.hero_code ";
	$review_member_sql .= " WHERE gisu_year = '".$gisu_year."' AND gisu_month = '".$gisu_month."' ORDER BY l.hero_idx ASC ";
	$review_member_res = sql($review_member_sql);
}
?>	


<div id="popupView" style="position:relative; display:none;">
	<div style="width:80%; position:fixed; z-index:100; top:40%; left:10%;">
		<div><a href="/m/mission_view.php?board=group_04_05&page=1&hero_idx=&mission_idx=2824"><img src="/m/img/popup/popup_231204.jpg" width="100%" style="display:block;" /></a></div>
		<div>
			<div style="height:40px; width:50%; float:left; font-size:14px; text-align:center; background:#ccc; line-height:38px;">
				<a href="#" onClick="fnPopClose('Y')" style="color:#000; text-decoration:none;">���� �Ϸ� ���� �ʱ�</a>
			</div>
			<div style="height:40px; width:50%; float:left; font-size:14px; text-align:center; background:#f68f43; line-height:38px;">
				<a href="#" onClick="fnPopClose()" style="color:#fff; text-decoration:none;">�˾��ݱ�</a>
			</div>
		</div>
		<div style="clear:both"></div>
	</div>
</div>

	
	<link rel="stylesheet" type="text/css" href="/m/css/musign/main.css" />
	<script type="text/javascript" src="/m/js/musign/main.js"></script>
    <link rel="stylesheet" type="text/css" href="/m/css/musign/main_popup.css" />
    <script src="/js/musign/popup_close_period.js"></script>

	<!-- main -->
	<div class="content_wrapper main_index main_01"> 	
   		<!-- visuall banner -->
			<?
			$sql = "select hero_type,hero_title, hero_subtitle, hero_main, hero_href, hero_period from banner_mobile where hero_use='1' ";
			//20240304musign S
			$sql .= " and ('".date("Y-m-d H:i:s")."' between hero_today_01 and hero_today_02) order by hero_order asc";
			//20240304musign E
			//$sql .= " and '2024-01-18 18:02:17' between hero_today_01 and hero_today_02 order by hero_order asc";
			sql($sql);
			$rollimg_count = @mysql_num_rows($out_sql);

			$banner_link = "";
		?>	
        <section class="sec01 main_slide">
			<div class="swiper-container slider">
				<div class="swiper-wrapper">
					<?  
					while($roll_list = @mysql_fetch_assoc($out_sql)){
						if($roll_list['hero_href'] != "")  {
							$banner_link = $roll_list['hero_href'];
						}else {
							$banner_link = "javascript:;";
						}
					?>
					<div class="swiper-slide">
						<div class="bannerBackImg" style="width:100%;">
							<a href="<?=$banner_link?>">
								<img src="/aklover/photo/<?=$roll_list["hero_main"];?>" />
							</a>
						</div>
					</div>
					<? } ?>
				</div>
				<!-- Add Pagination -->
                <div class="swbtn_wrap rel f_c">
                    <div class="swiper-pagination"></div>  
                    <div class="play_btn swiper-button-pause"><img src="/img/front/icon/stop.png" alt="pause"></div>
                    <div class="play_btn swiper-button-play"><img src="/img/front/icon/play.png" alt="play"></div>
                </div> 
			</div>
		</section>       
   		<!-- /// visuall banner -->
    	<!-- // supporters -->
		<section class="section2 sec_suppoter main_display">
			<div class="section_head">
				<div class="tit_bg">
                    <?
                    //����� ���������� �������� ���� ��������
                    $sql = "SELECT * FROM with_supporters_mo order by replace(hero_idx,3,0);";
                    sql($sql);

                    while ($supporters_list = @mysql_fetch_assoc($out_sql)){
                        if($supporters_list['hero_cate'] == 'Beauty')   $style = 'style="display: inline"';
                        else                                            $style = 'style="display: none;"';
                        ?>
                            <img src="/aklover/photo/<?=$supporters_list['hero_main']?>" alt="<?=$supporters_list['hero_cate']?>" <?=$style?>>
                        <?
                    }
                    ?>
				</div>
				<div class="section_tit">            
					<span class="fz22 fw600 tit">�����ؿ�, ��������</span>
					<h1 class="fz72 main_c en">With Supporters</h1>
				</div>
				<div class="tabtit">
					<div class="titbx">
                        <span class="tit depth1_c">Premier</span>
                        <span class="tit depth1 on">Basic</span>
					</div>
                    <ul>
                        <li>
                            <div class="hash_box" style="display: none;">
                                <div>
                                    <span class="depth1 depth1_cs act">Premier Beauty</span>
                                    <span class="depth1">Premier Life</span>
                                </div>
                            </div>
                        </li>
                        <li class="on">
                            <div class="hash_box" style="display: block;">
                                <div>
                                    <span class="depth1_s act">Basic Beauty & life</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
			</div>
			<div class="tabcont">
                    <!--[���߿�û]������ �Դϴ�-->
                    <div class="tabbox on swiper-container">
                        <ul class="f_fs cursor_cont swiper-wrapper">
                            <?
                            $list_sql = "SELECT * FROM mission WHERE hero_kind != '����ü��' AND hero_table = 'group_04_05' ";
                            if($_SESSION['temp_level'] < 9999 ){
                                $list_sql .=" AND hero_use = 1 AND ((hero_today_05_01 is null or hero_today_05_01='') or (hero_today_05_01 is not null and hero_today_05_01 != '' AND '".date("Y-m-d H:i")."' >= hero_today_05_01)) ";
                                $list_sql .=" AND ((hero_today_05_02 is null or hero_today_05_02 ='') OR (hero_today_05_02 is not null and hero_today_05_02 != '' AND '".date("Y-m-d H:i")."' <= hero_today_05_02)) ";
                            }
                            $list_sql .=" ORDER BY hero_priority DESC,
								CASE WHEN (hero_today_01_01<='".date('Y-m-d 00:00:00')."' and hero_today_01_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_01_01 END DESC,
								CASE WHEN (hero_today_02_01<='".date('Y-m-d 00:00:00')."' and hero_today_02_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_02_01 END DESC,
								CASE WHEN (hero_today_03_01<='".date('Y-m-d 00:00:00')."' and hero_today_03_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_03_01 END DESC,
								CASE WHEN (hero_today_04_01<='".date('Y-m-d 00:00:00')."' and hero_today_04_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_04_01 END DESC,
								CASE WHEN (hero_today_04_02<='".date('Y-m-d 00:00:00')."') THEN hero_today_04_01 END desc ";
                            $list_sql .= " , hero_today_01_01 DESC ";
                            $list_sql .= "LIMIT 0,3";

                            sql($list_sql, 'on');

                            while($list = @mysql_fetch_assoc($out_sql)){
                                $check_day = date( "Y-m-d", time());
                                $today_01_01 = date( "Y-m-d", strtotime($list['hero_today_01_01']));
                                $today_01_02 = date( "Y-m-d", strtotime($list['hero_today_01_02']));
                                $today_02_01 = date( "Y-m-d", strtotime($list['hero_today_02_01']));
                                $today_02_02 = date( "Y-m-d", strtotime($list['hero_today_02_02']));
                                $today_03_01 = date( "Y-m-d", strtotime($list['hero_today_03_01']));
                                $today_03_02 = date( "Y-m-d", strtotime($list['hero_today_03_02']));
                                $today_04_01 = date( "Y-m-d", strtotime($list['hero_today_04_01']));
                                $today_04_02 = date( "Y-m-d", strtotime($list['hero_today_04_02']));
                                $today_05_01 = date( "Y-m-d", strtotime($list['hero_today_05_01']));
                                $today_05_02 = date( "Y-m-d", strtotime($list['hero_today_05_02']));

                                $status_txt = "";
                                $status = "";
                                $period_day = "";
                                $ribbon_text = "";
                                $type_check = "";

                                $ribbon_text = $list['hero_kind'];
                                if($list['hero_type'] == "4" || $list['hero_type'] == "7") {
                                    $ribbon_text = $list['hero_kind'];
                                }

                                if($mission_board_type) {
                                    $txt1 = "";
                                    $txt2 = "";
                                    if($list["hero_type"] == "2") {
                                        $txt1 = "�ҹ����� ";
                                        $txt2 = "�ҹ����� ��û";
                                    } else if($list["hero_type"] == "10") {
                                        $txt1 = "ü���";
                                        $txt2 = "ü��� ����";
                                    }
    
                                    if(($today_01_01<=$check_day) and ($today_01_02>=$check_day)){
                                        $status_txt = $txt2;
                                        $status = "1";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                        $period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                                    }else if(($today_02_02 == $today_03_02) and ($today_02_02 == $today_04_02) and ($today_03_02 == $today_04_02) and ($today_02_02 >= $check_day)){
                                        $status_txt = "��÷�� ��ǥ";
                                        $status = "2";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_02_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                        $period_day =  intval((strtotime($list['hero_today_04_02'])-strtotime(date("Ymd")))/86400);
                                    }else if(($today_04_02 < $check_day)){
                                        $status_txt = $txt1." ����";
                                        $status = "5";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                    }
                                } else {
                                    if(($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
                                        //20180831 �ӽ÷� �߰�
                                        if($list['hero_idx'] == "1288") {
                                            $status_txt = "�̺�Ʈ ��û";
                                        } else {
                                            $status_txt = "ü��� ��û";
                                        }
                                        $status = "1";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                        $period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                                    }else if( ($today_02_01<=$check_day) and ($today_02_02>=$check_day) ){
                                        $status_txt = "������ ��ǥ";
                                        $status = "2";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_02_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_02_02']));
                                        $period_day =  intval((strtotime($list['hero_today_02_02'])-strtotime(date("Ymd")))/86400);
                                    }else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
                                        $status_txt = "�ı���";
                                        $status = "3";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_03_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_03_02']));
                                        $period_day =  intval((strtotime($list['hero_today_03_02'])-strtotime(date("Ymd")))/86400);
                                    }else if(($today_04_01<=$check_day) and ($today_04_02>=$check_day)){
                                        $status_txt = "����ı��ǥ";
                                        $status = "4";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_04_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                        $period_day =  intval((strtotime($list['hero_today_04_02'])-strtotime(date("Ymd")))/86400);
                                    }else if($today_04_02<$check_day){
                                        $status_txt = "ü��� ����";
                                        $status = "5";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                    }else if($today_05_01>$check_day){
                                        $status_txt = "ü��� ���⿹��";
                                        $status = "5";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                    }
                                }

                                // if($list['hero_type'] == "7" || $list['hero_type'] == "9") { //�����̼�, ����̼�(����)
                                //     if(($today_01_01<=$check_day) and ($today_01_02>=$check_day)){
                                //         $status_txt = "ü��� ��û";
                                //         $status = "1";
                                //         $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                //         $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                //         $period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                                //     }else if( ($today_02_01<=$check_day) and ($today_02_02>=$check_day) ){
                                //         $status_txt = "������ ��ǥ";
                                //         $status = "2";
                                //         $one_day = date( "Y.m.d", strtotime($list['hero_today_02_01']));
                                //         $two_day = date( "Y.m.d", strtotime($list['hero_today_02_02']));
                                //         $period_day =  intval((strtotime($list['hero_today_02_02'])-strtotime(date("Ymd")))/86400);
                                //     }else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
                                //         $status_txt = "�ı���";
                                //         $status = "3";
                                //         $one_day = date( "Y.m.d", strtotime($list['hero_today_03_01']));
                                //         $two_day = date( "Y.m.d", strtotime($list['hero_today_03_02']));
                                //         $period_day =  intval((strtotime($list['hero_today_03_02'])-strtotime(date("Ymd")))/86400);
                                //     }else if( ($today_04_01<=$check_day) and ($today_04_02>=$check_day) ){
                                //         $status_txt = "����ı��ǥ";
                                //         $status = "4";
                                //         $one_day = date( "Y.m.d", strtotime($list['hero_today_04_01']));
                                //         $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                //         $period_day =  intval((strtotime($list['hero_today_04_02'])-strtotime(date("Ymd")))/86400);
                                //     }else if($today_04_02<$check_day){
                                //         $status_txt = "ü��� ����";
                                //         $status = "5";
                                //         $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                //         $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                //     }else if($today_05_01>$check_day){
                                //         $status_txt = "ü��� ���⿹��";
                                //         $status = "5";
                                //         $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                //         $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                //     }
                                // } else {
                                //     if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
                                //         $status_txt = "�ı���";
                                //         $status = "3";
                                //         $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                //         $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                //         $period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                                //     }else if($today_01_02<$check_day){
                                //         $status_txt = "ü��� ����";
                                //         $status = "5";
                                //         $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                //         $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                //     }else if($today_05_01>$check_day){
                                //         $status_txt = "ü��� ���⿹��";
                                //         $status = "5";
                                //         $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                //         $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                //     }
                                // }
                                ?>
                                <li class="swiper-slide">
                                    <a href="/m/mission_view.php?board=group_04_05&page=1&hero_idx=&mission_idx=<?=$list['hero_idx']?>">
                                        <div class="img_bx">
                                            <div class="status_wrap">
                                                <span class="status status_txt"><?=$ribbon_text?></span>
                                            </div>
                                            <img src="<?=$list['hero_thumb']?>" alt="aklover">
                                            <div class="ico_bx">
                                                <?
                                                if($list["hero_question_url_check"] == "1") {
                                                    $type_check = "<span class='ic_sns ic_naver screen_out'>���̹�</span>";
                                                } else if($list["hero_question_url_check"] == "2") {
                                                    $type_check = "<span class='ic_sns ic_insta screen_out'>�ν�Ÿ�׷�</span>";
                                                } else if($list["hero_question_url_check"] == "3") {
                                                    $type_check = "<span class='ic_sns ic_naver screen_out'>���̹�</span><span class='ic_sns ic_insta screen_out'>�ν�Ÿ�׷�</span>";
                                                } else if($list["hero_question_url_check"] == "4") {
                                                    $type_check = "<span class='ic_sns ic_naver screen_out'>���̹�</span><span class='ic_sns ic_insta screen_out'>�ν�Ÿ�׷�</span>";
                                                } else if($list["hero_question_url_check"] == "5") {
                                                    $type_check = "<span class='ic_sns ic_youtube screen_out'>������</span>";
                                                } else if($list["hero_question_url_check"] == "6") {
                                                    $type_check = "<span class='ic_sns ic_naver screen_out'>���̹�</span><span class='ic_sns ic_insta screen_out'>�ν�Ÿ�׷�</span><span class='ic_sns ic_youtube screen_out'>������</span>";
                                                }
                                                ?>
                                                <?=$type_check?>
                                            </div>
                                        </div>
                                        <div class="txt_bx">
                                            <p class="tit fz20 fw600 ellipsis_100"><?=$list['hero_title']?></p>
                                            <? if($period_day) {?>
                                                <span class="status"><?=$status_txt?></span>
                                                <span class="period fz14">
                                                    D-<?=$period_day?>
                                                </span>
                                            <? } else if($period_day == 0 && strlen($period_day) > 0) { ?>
                                                <span class="status"><?=$status_txt?></span>
                                                <span class="period fz14">
                                                    D-DAY
                                                </span>
                                            <? } ?>
                                            <? if($status == 5) {?>
                                                <span class="status"><?=$status_txt?></span>
                                                <span class="period fz14">
                                                    END
                                                </span>
                                            <? } ?>
                                            <p class="fz12 fw600"><?=$one_day?> - <?=$two_day?></p>
                                        </div>
                                    </a>
                                </li>
                                <?
                            }
                            ?>
                        </ul>
                    </div>
                    <!--[���߿�û]��Ƽ �Դϴ�-->
                    <div class="tabbox tab_beauty swiper-container">
                        <ul class="f_fs cursor_cont swiper-wrapper">
                            <?
                            $list_sql = "SELECT * FROM mission WHERE hero_kind != '����ü��' AND hero_table = 'group_04_06' ";
                            if($_SESSION['temp_level'] < 9999 ){
                                $list_sql .=" AND hero_use = 1 AND ((hero_today_05_01 is null or hero_today_05_01='') or (hero_today_05_01 is not null and hero_today_05_01 != '' AND '".date("Y-m-d H:i")."' >= hero_today_05_01)) ";
                                $list_sql .=" AND ((hero_today_05_02 is null or hero_today_05_02 ='') OR (hero_today_05_02 is not null and hero_today_05_02 != '' AND '".date("Y-m-d H:i")."' <= hero_today_05_02)) ";
                            }
                            $list_sql .=" ORDER BY hero_priority DESC,
								CASE WHEN (hero_today_01_01<='".date('Y-m-d 00:00:00')."' and hero_today_01_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_01_01 END DESC,
								CASE WHEN (hero_today_02_01<='".date('Y-m-d 00:00:00')."' and hero_today_02_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_02_01 END DESC,
								CASE WHEN (hero_today_03_01<='".date('Y-m-d 00:00:00')."' and hero_today_03_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_03_01 END DESC,
								CASE WHEN (hero_today_04_01<='".date('Y-m-d 00:00:00')."' and hero_today_04_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_04_01 END DESC,
								CASE WHEN (hero_today_04_02<='".date('Y-m-d 00:00:00')."') THEN hero_today_04_01 END desc ";
                            $list_sql .= " , hero_today_01_01 DESC ";
                            $list_sql .= "LIMIT 0,3";

                            sql($list_sql, 'on');

                            while($list = @mysql_fetch_assoc($out_sql)){
                                $check_day = date( "Y-m-d", time());
                                $today_01_01 = date( "Y-m-d", strtotime($list['hero_today_01_01']));
                                $today_01_02 = date( "Y-m-d", strtotime($list['hero_today_01_02']));
                                $today_02_01 = date( "Y-m-d", strtotime($list['hero_today_02_01']));
                                $today_02_02 = date( "Y-m-d", strtotime($list['hero_today_02_02']));
                                $today_03_01 = date( "Y-m-d", strtotime($list['hero_today_03_01']));
                                $today_03_02 = date( "Y-m-d", strtotime($list['hero_today_03_02']));
                                $today_04_01 = date( "Y-m-d", strtotime($list['hero_today_04_01']));
                                $today_04_02 = date( "Y-m-d", strtotime($list['hero_today_04_02']));
                                $today_05_01 = date( "Y-m-d", strtotime($list['hero_today_05_01']));
                                $today_05_02 = date( "Y-m-d", strtotime($list['hero_today_05_02']));

                                $status_txt = "";
                                $status = "";
                                $period_day = "";
                                $ribbon_text = "";
                                $type_check = "";

                                $ribbon_text = $list['hero_kind'];
                                if($list['hero_type'] == "4" || $list['hero_type'] == "7") {
                                    $ribbon_text = $list['hero_kind'];
                                }

                                if($list['hero_type'] == "7" || $list['hero_type'] == "9") { //�����̼�, ����̼�(����)
                                    if(($today_01_01<=$check_day) and ($today_01_02>=$check_day)){
                                        $status_txt = "ü��� ��û";
                                        $status = "1";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                        $period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                                    }else if( ($today_02_01<=$check_day) and ($today_02_02>=$check_day) ){
                                        $status_txt = "������ ��ǥ";
                                        $status = "2";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_02_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_02_02']));
                                        $period_day =  intval((strtotime($list['hero_today_02_02'])-strtotime(date("Ymd")))/86400);
                                    }else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
                                        $status_txt = "�ı���";
                                        $status = "3";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_03_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_03_02']));
                                        $period_day =  intval((strtotime($list['hero_today_03_02'])-strtotime(date("Ymd")))/86400);
                                    }else if( ($today_04_01<=$check_day) and ($today_04_02>=$check_day) ){
                                        $status_txt = "����ı��ǥ";
                                        $status = "4";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_04_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                        $period_day =  intval((strtotime($list['hero_today_04_02'])-strtotime(date("Ymd")))/86400);
                                    }else if($today_04_02<$check_day){
                                        $status_txt = "ü��� ����";
                                        $status = "5";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                    }else if($today_05_01>$check_day){
                                        $status_txt = "ü��� ���⿹��";
                                        $status = "5";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                    }
                                } else {
                                    if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
                                        $status_txt = "�ı���";
                                        $status = "3";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                        $period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                                    }else if($today_01_02<$check_day){
                                        $status_txt = "ü��� ����";
                                        $status = "5";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                    }else if($today_05_01>$check_day){
                                        $status_txt = "ü��� ���⿹��";
                                        $status = "5";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                    }
                                }
                                ?>
                                <li class="swiper-slide">
                                    <a href="/m/mission_view.php?board=group_04_06&page=1&hero_idx=&mission_idx=<?=$list['hero_idx']?>">
                                        <div class="img_bx">
                                            <div class="status_wrap">
                                                <span class="status status_txt"><?=$ribbon_text?></span>
                                            </div>
                                            <img src="<?=$list['hero_thumb']?>" alt="aklover">
                                            <div class="ico_bx">
                                                <?
                                                if($list["hero_question_url_check"] == "1") {
                                                    $type_check = "<span class='ic_sns ic_naver screen_out'>���̹�</span>";
                                                } else if($list["hero_question_url_check"] == "2") {
                                                    $type_check = "<span class='ic_sns ic_insta screen_out'>�ν�Ÿ�׷�</span>";
                                                } else if($list["hero_question_url_check"] == "3") {
                                                    $type_check = "<span class='ic_sns ic_naver screen_out'>���̹�</span><span class='ic_sns ic_insta screen_out'>�ν�Ÿ�׷�</span>";
                                                } else if($list["hero_question_url_check"] == "4") {
                                                    $type_check = "<span class='ic_sns ic_naver screen_out'>���̹�</span><span class='ic_sns ic_insta screen_out'>�ν�Ÿ�׷�</span>";
                                                } else if($list["hero_question_url_check"] == "5") {
                                                    $type_check = "<span class='ic_sns ic_youtube screen_out'>������</span>";
                                                } else if($list["hero_question_url_check"] == "6") {
                                                    $type_check = "<span class='ic_sns ic_naver screen_out'>���̹�</span><span class='ic_sns ic_insta screen_out'>�ν�Ÿ�׷�</span><span class='ic_sns ic_youtube screen_out'>������</span>";
                                                }
                                                ?>
                                                <?=$type_check?>
                                            </div>
                                        </div>
                                        <div class="txt_bx">
                                            <p class="tit fz20 fw600 ellipsis_100"><?=$list['hero_title']?></p>
                                            <? if($period_day) {?>
                                                <span class="status"><?=$status_txt?></span>
                                                <span class="period fz14">
                                                    D-<?=$period_day?>
                                                </span>
                                            <? } else if($period_day == 0 && strlen($period_day) > 0) { ?>
                                                <span class="status"><?=$status_txt?></span>
                                                <span class="period fz14">
                                                    D-DAY
                                                </span>
                                            <? } ?>
                                            <? if($status == 5) {?>
                                                <span class="status"><?=$status_txt?></span>
                                                <span class="period fz14">
                                                    END
                                                </span>
                                            <? } ?>
                                            <p class="fz12 fw600"><?=$one_day?> - <?=$two_day?></p>
                                        </div>
                                    </a>
                                </li>
                                <?
                            }
                            ?>
                        </ul>
                    </div>
                    <!--[���߿�û]������ �Դϴ�-->
                    <div class="tabbox swiper-container">
                        <ul class="f_fs cursor_cont swiper-wrapper">
                            <?
                            $list_sql = "SELECT * FROM mission WHERE hero_kind != '����ü��' AND hero_table = 'group_04_28' ";
                            if($_SESSION['temp_level'] < 9999 ){
                                $list_sql .=" AND hero_use = 1 AND ((hero_today_05_01 is null or hero_today_05_01='') or (hero_today_05_01 is not null and hero_today_05_01 != '' AND '".date("Y-m-d H:i")."' >= hero_today_05_01)) ";
                                $list_sql .=" AND ((hero_today_05_02 is null or hero_today_05_02 ='') OR (hero_today_05_02 is not null and hero_today_05_02 != '' AND '".date("Y-m-d H:i")."' <= hero_today_05_02)) ";
                            }
                            $list_sql .=" ORDER BY hero_priority DESC,
								CASE WHEN (hero_today_01_01<='".date('Y-m-d 00:00:00')."' and hero_today_01_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_01_01 END DESC,
								CASE WHEN (hero_today_02_01<='".date('Y-m-d 00:00:00')."' and hero_today_02_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_02_01 END DESC,
								CASE WHEN (hero_today_03_01<='".date('Y-m-d 00:00:00')."' and hero_today_03_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_03_01 END DESC,
								CASE WHEN (hero_today_04_01<='".date('Y-m-d 00:00:00')."' and hero_today_04_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_04_01 END DESC,
								CASE WHEN (hero_today_04_02<='".date('Y-m-d 00:00:00')."') THEN hero_today_04_01 END desc ";
                            $list_sql .= " , hero_today_01_01 DESC ";
                            $list_sql .= "LIMIT 0,3";

                            sql($list_sql, 'on');

                            while($list = @mysql_fetch_assoc($out_sql)){
                                $check_day = date( "Y-m-d", time());
                                $today_01_01 = date( "Y-m-d", strtotime($list['hero_today_01_01']));
                                $today_01_02 = date( "Y-m-d", strtotime($list['hero_today_01_02']));
                                $today_02_01 = date( "Y-m-d", strtotime($list['hero_today_02_01']));
                                $today_02_02 = date( "Y-m-d", strtotime($list['hero_today_02_02']));
                                $today_03_01 = date( "Y-m-d", strtotime($list['hero_today_03_01']));
                                $today_03_02 = date( "Y-m-d", strtotime($list['hero_today_03_02']));
                                $today_04_01 = date( "Y-m-d", strtotime($list['hero_today_04_01']));
                                $today_04_02 = date( "Y-m-d", strtotime($list['hero_today_04_02']));
                                $today_05_01 = date( "Y-m-d", strtotime($list['hero_today_05_01']));
                                $today_05_02 = date( "Y-m-d", strtotime($list['hero_today_05_02']));

                                $status_txt = "";
                                $status = "";
                                $period_day = "";
                                $ribbon_text = "";
                                $type_check = "";

                                $ribbon_text = $list['hero_kind'];
                                if($list['hero_type'] == "4" || $list['hero_type'] == "7") {
                                    $ribbon_text = $list['hero_kind'];
                                }

                                if($list['hero_type'] == "7" || $list['hero_type'] == "9") { //�����̼�, ����̼�(����)
                                    if(($today_01_01<=$check_day) and ($today_01_02>=$check_day)){
                                        $status_txt = "ü��� ��û";
                                        $status = "1";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                        $period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                                    }else if( ($today_02_01<=$check_day) and ($today_02_02>=$check_day) ){
                                        $status_txt = "������ ��ǥ";
                                        $status = "2";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_02_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_02_02']));
                                        $period_day =  intval((strtotime($list['hero_today_02_02'])-strtotime(date("Ymd")))/86400);
                                    }else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
                                        $status_txt = "�ı���";
                                        $status = "3";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_03_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_03_02']));
                                        $period_day =  intval((strtotime($list['hero_today_03_02'])-strtotime(date("Ymd")))/86400);
                                    }else if( ($today_04_01<=$check_day) and ($today_04_02>=$check_day) ){
                                        $status_txt = "����ı��ǥ";
                                        $status = "4";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_04_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                        $period_day =  intval((strtotime($list['hero_today_04_02'])-strtotime(date("Ymd")))/86400);
                                    }else if($today_04_02<$check_day){
                                        $status_txt = "ü��� ����";
                                        $status = "5";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                    }else if($today_05_01>$check_day){
                                        $status_txt = "ü��� ���⿹��";
                                        $status = "5";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                    }
                                } else {
                                    if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
                                        $status_txt = "�ı���";
                                        $status = "3";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                        $period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                                    }else if($today_01_02<$check_day){
                                        $status_txt = "ü��� ����";
                                        $status = "5";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                    }else if($today_05_01>$check_day){
                                        $status_txt = "ü��� ���⿹��";
                                        $status = "5";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                    }
                                }
                                ?>
                                <li class="swiper-slide">
                                    <a href="/m/mission_view.php?board=group_04_28&page=1&hero_idx=&mission_idx=<?=$list['hero_idx']?>">
                                        <div class="img_bx">
                                            <div class="status_wrap">
                                                <span class="status status_txt"><?=$ribbon_text?></span>
                                            </div>
                                            <img src="<?=$list['hero_thumb']?>" alt="aklover">
                                            <div class="ico_bx">
                                                <?
                                                if($list["hero_question_url_check"] == "1") {
                                                    $type_check = "<span class='ic_sns ic_naver screen_out'>���̹�</span>";
                                                } else if($list["hero_question_url_check"] == "2") {
                                                    $type_check = "<span class='ic_sns ic_insta screen_out'>�ν�Ÿ�׷�</span>";
                                                } else if($list["hero_question_url_check"] == "3") {
                                                    $type_check = "<span class='ic_sns ic_naver screen_out'>���̹�</span><span class='ic_sns ic_insta screen_out'>�ν�Ÿ�׷�</span>";
                                                } else if($list["hero_question_url_check"] == "4") {
                                                    $type_check = "<span class='ic_sns ic_naver screen_out'>���̹�</span><span class='ic_sns ic_insta screen_out'>�ν�Ÿ�׷�</span>";
                                                } else if($list["hero_question_url_check"] == "5") {
                                                    $type_check = "<span class='ic_sns ic_youtube screen_out'>������</span>";
                                                } else if($list["hero_question_url_check"] == "6") {
                                                    $type_check = "<span class='ic_sns ic_naver screen_out'>���̹�</span><span class='ic_sns ic_insta screen_out'>�ν�Ÿ�׷�</span><span class='ic_sns ic_youtube screen_out'>������</span>";
                                                }
                                                ?>
                                                <?=$type_check?>
                                            </div>
                                        </div>
                                        <div class="txt_bx">
                                            <p class="tit fz20 fw600 ellipsis_100"><?=$list['hero_title']?></p>
                                            <? if($period_day) {?>
                                                <span class="status"><?=$status_txt?></span>
                                                <span class="period fz14">
                                                    D-<?=$period_day?>
                                                </span>
                                            <? } else if($period_day == 0 && strlen($period_day) > 0) { ?>
                                                <span class="status"><?=$status_txt?></span>
                                                <span class="period fz14">
                                                    D-DAY
                                                </span>
                                            <? } ?>
                                            <? if($status == 5) {?>
                                                <span class="status"><?=$status_txt?></span>
                                                <span class="period fz14">
                                                    END
                                                </span>
                                            <? } ?>
                                            <p class="fz12 fw600"><?=$one_day?> - <?=$two_day?></p>
                                        </div>
                                    </a>
                                </li>
                                <?
                            }
                            ?>
                        </ul>
                    </div>
                </div>
		</section>
		<!-- // supporters -->
		<!-- about ak lover -->
		<section class="section3 sec_about">
			<div class="cont_wr">
				<div class="section_tit t_l">            
					<span class="fz22 fw600">�˾ư���, AK Lover</span>
					<h1 class="fz72 main_c en">About AK Lover</h1>
				</div>
				<div class="section_cont">
					<ul class="grid_4 cursor_cont">
                        <?
                        $sql = "select * from about order by replace(hero_order,0,999) asc;";
                        sql($sql);

                        while ($about_list = @mysql_fetch_assoc($out_sql)){
                            ?>
                            <li>
                                <a href="<?=$about_list['hero_href_mo']?>"><img src="/aklover/photo/<?=$about_list['hero_main']?>" alt="aklover"></a>
                                <a href="<?=$about_list['hero_href_mo']?>"><span class="fz22 fw600 link_tit"><?=$about_list['hero_title']?></span></a>
                            </li>
                            <?
                        }
                        ?>
					</ul>
				</div>
			</div>
		</section>    
		<!-- // about ak lover -->
		<!-- best Review -->
		<section class="section3 sec_reivew main_display">
        <div class="section_cont">
            <div class="tabtit">
                <span class="fz22 fw600">�����ؿ�, ����ı�</span>
                <h1 class="fz72 en">Best Review</h1>
                <div class="titbx">
                    <span class="tit depth1_c on">Premier</span>
                    <span class="tit depth1">Basic</span>
                </div>
                <ul>
                    <li class="on">
                        <div class="hash_box">
                            <div>
                                <span class="depth1 depth1_cs act">Premier Beauty</span>
                                <span class="depth1">Premier Life</span>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="hash_box">
                            <div>
                                <span class="depth1_s">Basic Beauty & life</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="tabcont">
                <div class="swiper-container tabbox">
                    <ul class="f_fs swiper-wrapper">
                        <li class="swiper-slide">
                            <div>
                                <img src="/img/front/main/tabcont07.jpg" alt="aklover">
                                <div class="content">
                                    <div class="f_cs">                                        
                                        <img src="/img/front/main/profile.webp" alt="aklover" class="profile">
                                        <span class="fz25 fw500">����e</span>
                                    </div>
                                    <div class="fz24 fw300 txtbox ellipsis_3line">
                                        ������ �������� �׷��� ����ũ���� �ϸ� �ݼ� �������� Ŀ���� �� �� �ż� ����� �Ǵ�����.
                                    </div>
                                    <div class='sns_btn_group f_c'>                                        
                                        <a href='https://www.instagram.com/p/C63ZgOsrAwr/?igsh=MzRlODBiNWFlZA==' target='_blank' class='btnLink insta'><span></span><p>�ν�Ÿ�׷�</p></a>                                            
                                        <a href='https://blog.naver.com/aldi9382/223444449870' target='_blank' class='btnLink blog'><span></span><p>��α�</p></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide">
                            <div>
                                <img src="/img/front/main/tabcont08.jpg" alt="aklover">
                                <div class="content">
                                    <div class="f_cs">                                        
                                        <img src="/img/front/main/profile.webp" alt="aklover" class="profile">
                                        <span class="fz25 fw500">����</span>
                                    </div>
                                    <div class="fz24 fw300 txtbox ellipsis_3line">
                                        ���� �ȴ��ϼ���~! ���� ��¥ ��� �ٵ����, �ٵ� ��ũ�� �߰��ؼ� �ٷ� ���к��� ���Կ�.
                                    </div>
                                    <div class='sns_btn_group f_c'>                                        
                                        <a href='https://www.instagram.com/p/C4YQudtvxsP/?igsh=N256cWlwbG9rdXR6' target='_blank' class='btnLink insta'><span></span><p>�ν�Ÿ�׷�</p></a>                                            
                                        <a href='https://blog.naver.com/sayunov/223380422662' target='_blank' class='btnLink blog'><span></span><p>��α�</p></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide">
                            <div>
                                <img src="/img/front/main/tabcont09.jpg" alt="aklover">
                                <div class="content">
                                    <div class="f_cs">                                        
                                        <img src="/img/front/main/profile.webp" alt="aklover" class="profile">
                                        <span class="fz25 fw500">Ǫ���ϴ�</span>
                                    </div>
                                    <div class="fz24 fw300 txtbox ellipsis_3line">
                                        ���� ���������� ������ �� �ٰ����� �帶ö����!!! �帶ö�� �Ǹ� ���� ���̸�, ���� ���� ���, ���ϸ��� ���� �̺ұ���~~ 
                                    </div>
                                    <div class='sns_btn_group f_c'>                                        
                                        <a href='https://www.instagram.com/p/C79lvJSva4i/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==' target='_blank' class='btnLink insta'><span></span><p>�ν�Ÿ�׷�</p></a>                                            
                                        <a href='https://blog.naver.com/jyjj0201/223473800757' target='_blank' class='btnLink blog'><span></span><p>��α�</p></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide">
                            <div>
                                <img src="/img/front/main/tabcont09_1.jpg" alt="aklover">
                                <div class="content">
                                    <div class="f_cs">                                        
                                        <img src="/img/front/main/profile.webp" alt="aklover" class="profile">
                                        <span class="fz25 fw500">�ϳ����</span>
                                    </div>
                                    <div class="fz24 fw300 txtbox ellipsis_3line">
                                        �ʼ� ���� 3�� �̸�� �� �ϳ��� �ı⼼ô��
                                        �ı⼼ô�� ������ Ȱ���Ϸ��� ���� ���õ� �߿��� �� �ƽ���?
                                        �׷��� ���� ������ �󸶳� ������ �������� �����ϴ� �͵� ���� �ʴ�����.
                                    </div>
                                    <div class='sns_btn_group f_c'>                                        
                                        <a href='https://www.instagram.com/p/C1XD6arv2QB/?igsh=MWtxODAwM2s3N3Jxcw==' target='_blank' class='btnLink insta'><span></span><p>�ν�Ÿ�׷�</p></a>                                            
                                        <a href='https://blog.naver.com/duna0912/223305083687' target='_blank' class='btnLink blog'><span></span><p>��α�</p></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="swiper-container tabbox on">
                    <ul class="f_fs swiper-wrapper">
                        <li class="swiper-slide">
                            <div>
                                <img src="/img/front/main/tabcont01.jpg" alt="aklover">
                                <div class="content">
                                    <div class="f_cs">                                        
                                        <img src="/img/front/main/profile.webp" alt="aklover" class="profile">
                                        <span class="fz25 fw500">�Ƕ�ġ��</span>
                                    </div>
                                    <div class="fz24 fw300 txtbox ellipsis_3line">
                                        �ȳ��ϼ���:) �����������Ͻ� �� ������ ��Ʈ�� �̹��� ���Ӱ� ������Ǿ� ���ƿԴٰ� �ؿ� ������ ����ǵ� ��¥ ���Ҵµ� �̹��� ������Ǹ鼭 �� �������ٰ� �ϴ� �ϰ� ����� ���ۿ� ���°žƴѰ���
                                    </div>
                                    <div class='sns_btn_group f_c'>                                        
                                        <a href='https://www.instagram.com/p/C3zE3hfLpJv/?igsh=cXN1eXJ3Y2JidDk%3D' target='_blank' class='btnLink insta'><span></span><p>�ν�Ÿ�׷�</p></a>                                            
                                        <a href='https://blog.naver.com/hhu1004/223365360688' target='_blank' class='btnLink blog'><span></span><p>��α�</p></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide">
                            <div>
                                <img src="/img/front/main/tabcont02.jpg" alt="aklover">
                                <div class="content">
                                    <div class="f_cs">                                        
                                        <img src="/img/front/main/profile.webp" alt="aklover" class="profile">
                                        <span class="fz25 fw500">����</span>
                                    </div>
                                    <div class="fz24 fw300 txtbox ellipsis_3line">
                                        �������� ���� ����ũ�� �� �ȷ�Ʈ�� ������ �� �ֳ���? ������ ���� ���� �ᵵ �� �÷�? ���� ���� �ٸ� �ȷ�Ʈ�� �ű�� ���ε���
                                    </div>
                                    <div class='sns_btn_group f_c'>                                        
                                        <a href='https://www.instagram.com/p/C2XYADzy8l8/?igsh=MXN5aGNvc2lkeXRrMQ%3D%3D' target='_blank' class='btnLink insta'><span></span><p>�ν�Ÿ�׷�</p></a>                                            
                                        <a href='https://blog.naver.com/one09060/223329494096' target='_blank' class='btnLink blog'><span></span><p>��α�</p></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide">
                            <div>
                                <img src="/img/front/main/tabcont03.jpg" alt="aklover">
                                <div class="content">
                                    <div class="f_cs">                                        
                                        <img src="/img/front/main/profile.webp" alt="aklover" class="profile">
                                        <span class="fz25 fw500">��ΰŴϳ�</span>
                                    </div>
                                    <div class="fz24 fw300 txtbox ellipsis_3line">
                                        �ȴ��ϼ��� �ϳ��Դϴ�- ������ �߿���� �Ǻΰ� �����ϴ� ���� Ǫ��Ǫ���� ���� �Ǻθ��̶� �ʱ��ʱ� ������ �����Ǻ� ǥ���� �ϰ� �ʹ��󱸿�?
                                    </div>
                                    <div class='sns_btn_group f_c'>                                             
                                        <a href='https://blog.naver.com/khc_0710/223361044757' target='_blank' class='btnLink blog'><span></span><p>��α�</p></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide">
                            <div>
                                <img src="/img/front/main/tabcont03_1.jpg" alt="aklover">
                                <div class="content">
                                    <div class="f_cs">                                        
                                        <img src="/img/front/main/profile.webp" alt="aklover" class="profile">
                                        <span class="fz25 fw500">�Ӽ���</span>
                                    </div>
                                    <div class="fz24 fw300 txtbox ellipsis_3line">
                                        �ȳ��ϼ���! ������ �̲��Ÿ� ���� ����ϰ�! ���ڱ����� ���ϰ� ���� ������ ����Ʈ�� �� Ŭ�� ���ؾ��� ������ ���е� & �� Ŭ�� �� Ŭ��¡�� ����غ��ҽ��ϴ�.
                                    </div>
                                    <div class='sns_btn_group f_c'>                           
                                        <a href='https://www.instagram.com/p/C7sVD89S6y0/?igsh=MXd5cnlhbzc3ZDdnMA==' target='_blank' class='btnLink insta'><span></span><p>�ν�Ÿ�׷�</p></a>                      
                                        <a href='https://blog.naver.com/lsm991227/223466238178' target='_blank' class='btnLink blog'><span></span><p>��α�</p></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="swiper-container tabbox">
                <ul class="f_fs swiper-wrapper">
                        <li class="swiper-slide">
                            <div>
                                <img src="/img/front/main/tabcont04.jpg" alt="aklover">
                                <div class="content">
                                    <div class="f_cs">                                        
                                        <img src="/img/front/main/profile.webp" alt="aklover" class="profile">
                                        <span class="fz25 fw500">������</span>
                                    </div>
                                    <div class="fz24 fw300 txtbox ellipsis_3line">
                                     �ȳ��ϼ��� :) ����³� �������� ���� �����ϰ� �ذ��� �� �ִ� �ǳ����� ĸ������ ��ť��Ʈ �Ұ��� �帱�Կ�!
                                    </div>
                                    <div class='sns_btn_group f_c'>                                        
                                        <a href='https://www.instagram.com/p/C8R-UoxPW9-/?igsh=MTNmaHFscWF6OW9sNw==' target='_blank' class='btnLink insta'><span></span><p>�ν�Ÿ�׷�</p></a>                                            
                                        <a href='https://blog.naver.com/trian78/223481470258' target='_blank' class='btnLink blog'><span></span><p>��α�</p></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide">
                            <div>
                                <img src="/img/front/main/tabcont05.jpg" alt="aklover">
                                <div class="content">
                                    <div class="f_cs">                                        
                                        <img src="/img/front/main/profile.webp" alt="aklover" class="profile">
                                        <span class="fz25 fw500">���︾</span>
                                    </div>
                                    <div class="fz24 fw300 txtbox ellipsis_3line">
                                    ���� ������ �������� �Բ� �ִٺ��� ȭ��� û�Ұ� ����� �� ���ƿ�. ���̵���� ���� �ִٺ��� �������� ���� ȭ��� û���ϱⰡ �� ������µ���. 
                                    </div>
                                    <div class='sns_btn_group f_c'>                                        
                                        <a href='https://www.instagram.com/p/C3P4jTuLgnL/?igsh=MWpybWFqY3E4Znc3dg==' target='_blank' class='btnLink insta'><span></span><p>�ν�Ÿ�׷�</p></a>                                            
                                        <a href='https://blog.naver.com/lyw5559/223353489178' target='_blank' class='btnLink blog'><span></span><p>��α�</p></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide">
                            <div>
                                <img src="/img/front/main/tabcont06.jpg" alt="aklover">
                                <div class="content">
                                    <div class="f_cs">                                        
                                        <img src="/img/front/main/profile.webp" alt="aklover" class="profile">
                                        <span class="fz25 fw500">�ٴٲ�</span>
                                    </div>
                                    <div class="fz24 fw300 txtbox ellipsis_3line">
                                        ������ �ذ� �ʹ� ������ �����ϰ� ���� �����⸦ ����ϴ� �� ���� �ξ� �����°� �� ��� �����󱸿�.
                                    </div>
                                    <div class='sns_btn_group f_c'>                                        
                                        <a href='https://www.instagram.com/p/C6eAs8DRvaZ/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==' target='_blank' class='btnLink insta'><span></span><p>�ν�Ÿ�׷�</p></a>                                            
                                        <a href='https://blog.naver.com/forminji0406/223434627497' target='_blank' class='btnLink blog'><span></span><p>��α�</p></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide">
                            <div>
                                <img src="/img/front/main/tabcont06_1.jpg" alt="aklover">
                                <div class="content">
                                    <div class="f_cs">                                        
                                        <img src="/img/front/main/profile.webp" alt="aklover" class="profile">
                                        <span class="fz25 fw500">��e</span>
                                    </div>
                                    <div class="fz24 fw300 txtbox ellipsis_3line">
                                        �������� ����ö�� �Ǹ� �� ������ �ٵ� �� ������ ����߰ڴ� �ϰ� Ȩ��� ��������� ����� �־����ϴ�.
                                        ����� ������ ������ ������ �ľ�� ���κ��� ����ִ� Ȩ��� �������    
                                    </div>
                                    <div class='sns_btn_group f_c'>                                        
                                        <a href='https://www.instagram.com/p/C7-aMF1PnPK/?igsh=Zmw5b3VibXZleXl6' target='_blank' class='btnLink insta'><span></span><p>�ν�Ÿ�׷�</p></a>                                            
                                        <a href='https://blog.naver.com/limlim805/223473202890' target='_blank' class='btnLink blog'><span></span><p>��α�</p></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- // best Review -->			
    <!-- // news -->
    <section class="section4 sec_news">
    	<div class="section_tit">
            <?
            $sql = "SELECT * FROM bot_content WHERE hero_use = '1' order by hero_idx";
            sql($sql);

            $bot_main = @mysql_fetch_assoc($out_sql);
            ?>
            <div class="section_tit t_l">
                <span class="fz22 fw600"><?=$bot_main['hero_title']?></span>
                <h1 class="fz72 main_c en"><?=$bot_main['hero_sub_title']?></h1>
            </div>
            <?
            while ($list = @mysql_fetch_assoc($out_sql)){
                ?>
                <div class="section_cont">
                    <div class="cont_img">
                        <a href="<?=$list['hero_mo_href']?>"><img src="/aklover/photo/<?=$list['hero_main']?>" alt="�̸��� QUIZ"></a>
                    </div>
                    <div class="cont_txt">
                        <div class="cont_tit">
                            <a href="<?=$list['hero_mo_href']?>" class="cont_lnk">
                                <div class="lnk-wrap">
                                    <strong class="tit_txt fz25 fw600 f_cs ellipsis_100"><?=$list['hero_title']?></strong>
                                </div>
                                <p class="fz24 sub_txt ellipsis_2line">
                                    <?=nl2br($list['hero_sub_title'])?>
                                </p>
                            </a>
                        </div>
                    </div>
                </div>
                <?
            }
            ?>
    	</div>
    </section>    
    <!-- // news -->    	
    <!-- // rolling banner -->
    <section class="section5 sec_rollbanner">
    	<h2 class="text_hidden">����ȸ�� ����Ʈ</h2>                                    
        <div class="roll_wrap">
            <ul class="list">
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=1&brandhall_idx=31&brand_idx=38"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/AGE20'S.png" alt="AGE20'S"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=1&brandhall_idx=31&brand_idx=36"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/LUNA.png" alt="LUNA"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=1&brandhall_idx=31&brand_idx=37"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/asolution.png" alt="asolution"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=1&brandhall_idx=31&brand_idx=39"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/pointand.png" alt="pointand"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=1&brandhall_idx=31&brand_idx=35"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/sneaky.png" alt="sneaky"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=26&brand_idx=17"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/kerasys.png" alt="kerasys"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=26&brand_idx=46"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/Blackforet.png" alt="Blackforet"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=26&brand_idx=43"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/alpist.png" alt="alpist"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=27&brand_idx=45"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/shower.png" alt="shower"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=27&brand_idx=49"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/LUVSCENT.png" alt="LUVSCENT"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=27&brand_idx=48"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/chiuub.png" alt="chiuub"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=72"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/lechatelard.png" alt="lechatelard"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=68"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/liq.png" alt="liq"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=59&brand_idx=75"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/bravo.png" alt="bravo"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=65"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/savorr.png" alt="savorr"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=59&brand_idx=59"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/soonsam.png" alt="soonsam"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=70"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/spark.png" alt="spark"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=74"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/mom.png" alt="mom"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=62&brand_idx=53"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/airfresh.png" alt="airfresh"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=71"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/wool.png" alt="wool"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=59&brand_idx=67"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/trio.png" alt="trio"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=73"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/herbmary.png" alt="herbmary"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=60&brand_idx=55"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/home.png" alt="home"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=61&brand_idx=54"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/whistle.png" alt="whistle"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=76"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/SWAY.png" alt="SWAY"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=69"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/zet.png" alt="zet"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=61"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/2080.png" alt="2080"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=50"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/2080kiz.png" alt="2080kiz"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=34"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/bycolor.png" alt="bycolor"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=63"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/salarium.png" alt="salarium"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=30&brand_idx=66"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/labccin.png" alt="labccin"></a></li>
            </ul>
            <ul class="list">
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=1&brandhall_idx=31&brand_idx=38"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/AGE20'S.png" alt="AGE20'S"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=1&brandhall_idx=31&brand_idx=36"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/LUNA.png" alt="LUNA"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=1&brandhall_idx=31&brand_idx=37"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/asolution.png" alt="asolution"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=1&brandhall_idx=31&brand_idx=39"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/pointand.png" alt="pointand"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=1&brandhall_idx=31&brand_idx=35"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/sneaky.png" alt="sneaky"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=26&brand_idx=17"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/kerasys.png" alt="kerasys"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=26&brand_idx=46"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/Blackforet.png" alt="Blackforet"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=26&brand_idx=43"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/alpist.png" alt="alpist"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=27&brand_idx=45"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/shower.png" alt="shower"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=27&brand_idx=49"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/LUVSCENT.png" alt="LUVSCENT"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=27&brand_idx=48"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/chiuub.png" alt="chiuub"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=72"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/lechatelard.png" alt="lechatelard"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=68"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/liq.png" alt="liq"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=59&brand_idx=75"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/bravo.png" alt="bravo"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=65"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/savorr.png" alt="savorr"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=59&brand_idx=59"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/soonsam.png" alt="soonsam"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=70"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/spark.png" alt="spark"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=74"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/mom.png" alt="mom"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=62&brand_idx=53"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/airfresh.png" alt="airfresh"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=71"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/wool.png" alt="wool"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=59&brand_idx=67"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/trio.png" alt="trio"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=73"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/herbmary.png" alt="herbmary"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=60&brand_idx=55"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/home.png" alt="home"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=61&brand_idx=54"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/whistle.png" alt="whistle"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=76"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/SWAY.png" alt="SWAY"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=69"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/zet.png" alt="zet"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=61"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/2080.png" alt="2080"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=50"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/2080kiz.png" alt="2080kiz"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=34"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/bycolor.png" alt="bycolor"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=63"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/salarium.png" alt="salarium"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=30&brand_idx=66"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/labccin.png" alt="labccin"></a></li>
            </ul>
        </div>
    </section>   
    <!-- // rolling banner -->
</div>

<!-- ������ ���� �˾�(s) -->
<?
$sql = "SELECT * FROM main_popup WHERE hero_use='1' ";
$sql .= " and ('".date("Y-m-d H:i:s")."' between hero_today_01 and hero_today_02) order by replace(hero_order,0,999) asc";
sql($sql);
$i = 1;

while($list = @mysql_fetch_assoc($out_sql)){ ?>
    <div class="mainpopup overlay" id="mainpopup<?=$i?>">
        <div class="popup_inner">
            <a href="<?=$list['hero_mo_href']?>" class="fz26 bold">
                <img src="/aklover/photo/<?=$list['hero_main']?>" alt="���� �˾�">
            </a>
            <br>
            <button class="btnx fz26 bold">�ݱ�</button>
            <div class="close_txt">
                <a class="btn_today_close_alram">���� �Ϸ� �� â�� ���� ����</a>
            </div>
        </div>
    </div>

    <script>
        $('#mainpopup<?=$i?> .btnx').click(function(){
            cookieSetting.setCookie("today", "yes", 1);
            $('#mainpopup<?=$i?>').hide();
        });

        $("#mainpopup<?=$i?> .btn_today_close_alram").on("click", function () {
            cookieSetting.setCookie("today", "yes", 1);
            $('#mainpopup<?=$i?>').hide();
        });

        if (cookieSetting.getCookie("today") == "yes") {
            $('#mainpopup<?=$i?>').hide();
        } else {
            $('#mainpopup<?=$i?>').show();
        }
    </script>
<? $i++;} ?>
<!-- ������ ���� �˾�(e) -->

<?php
//############ �޸���� ���� â ���� #################
if($_REQUEST["dormancy"] == "yes"){
	$dormancy_code = $_REQUEST["hero_code"];
	$dormancy_name = $_REQUEST["hero_name"];
	$dormancy_out_date = $_REQUEST["hero_out_date"];
	$dormancy_id = $_REQUEST["hero_id"];

?>
<style type='text/css'>
	.dimmed {	position: fixed; top: 0; right: 0; bottom: 0; left: 0; z-index: 998; display: block; width:100%; height: 100%; background-color:#A8A8A8; content: ''; opacity:0.7;}
	*{font-family:'�������',Nanum Gothic; font-size:14px; color:#4c4c4c; margin:0; padding:0;}
	/* .sleepbox { 
		position: absolute;
		width:440px;
		height:366px;

		z-index:1000;
		left:0px;
		top:0px;
		background: #fff;
		-webkit-box-shadow: 3px 3px 15px #afafaf;  
			-moz-box-shadow: 3px 3px 15px #afafaf; 
			box-shadow: 3px 3px 15px #afafaf;

	}	 */
</style>	
<script type='text/javascript'>
	$(function(){
		$(window).scrollTop(0);
		document.body.style.overflow = 'hidden';
		$('body').append('<div class=dimmed></div>');
		// $('#sleepbox').css({'left': ( ($(window).width() - $('#sleepbox').width())/2 )+ 'px', 'top' : ( ($(window).height() - $('#sleepbox').height())/2 + $(window).scrollTop() )+ 'px'}).show();
	});	
	function goSubmit(){
		if(confirm("ȸ�������� Ȱ��ȭ �Ͻðڽ��ϱ�?")){
			return true;
		}else{
			return false;
		}	
	}		
</script> 
<div id='sleepbox' class='sleepbox'> 
<!--�޸��������-->
<form name="dormancy" method="post" action="/combined/activate.act.php" onsubmit="return goSubmit();">
    <input type="hidden" name="hero_code" value="<?=$dormancy_code?>"/>
    <input type="hidden" name="mobilepc" value="mobile"/>
    <h3 class="fz18 fw600">��������</h3>
    <div class="sb_container">
        <div class="sb_des fz13">
            <strong class="fw600"><?=$dormancy_name?>(<?=$dormancy_id?>)</strong> ȸ������<br />
            ��Ⱓ ����Ʈ�� �̿����� �ʾ�  <br />
            ���̵� �޸�����Դϴ�. <br />
            �޸������ ���̵� �� �̿��ϱ� ���ؼ���<br />
            �Ʒ� &quot;������&quot; ���� ������ ����<br />
            ȸ���� ���� �̿��� �����ϰ� �˴ϴ�. <br />
            &quot;�������� ����'�� ���� �� ���̵�� �޸���°� �����˴ϴ�.
        </div>
        <div class="sb_qus">
            <p class="fz14 fw600 main_c">����Ȱ��ȭ ����</p>
            <p class="fz13"><span class="bold">���̵�(<?=$dormancy_id?>)</span> �޸���¸�<br /> �����ϴµ� �����Ͻʴϱ�?</p>

            <div class="sb_btn f_c">
                <input type="submit" class="submit_btn fw600 fz13" value="������" />
                <a href="/" class="submit_btn fw600 fz13 blank">�������� ����</a>
            </div>
        </div>
    </div>
</form>
<!--�޸������-->	
</div>		
<?php
//############ �޸���� ���� â �� #################
}
?>		
<?php
include_once "tail.php";
?> 		
<script>
function setCookie( name, value, expirehours ) {
	var todayDate = new Date();
	todayDate.setHours( todayDate.getHours() + expirehours );
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
}

function getCookie(name) {
	var value = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
	return value? value[2] : null;
}

function fnPopClose(check) {
	if(check == "Y") {
		setCookie("mobile_cookie_221107", "done" , 24);
	}
	$("#popupView").hide();
}

$(document).ready(function(){
    $('body').addClass('main');
});
/*
if(getCookie("mobile_cookie_221107") != "done") {
	$("#popupView").show();
}
*/

</script>