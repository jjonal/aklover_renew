<link rel="stylesheet" type="text/css" href="/css/front/cscenter.css" />
<link rel="stylesheet" type="text/css" href="/css/front/review.css" />
<script type="text/javascript" src="/js/musign/board.js"></script>
<?
if(!defined('_HEROBOARD_'))exit;

$idx = $_GET["idx"];
$board = $_GET["board"];
$cut_count_name = '6';
$cut_title_name = '10';
$cut_command_name = '50';
$today = date("Y-m-d");

// 160928 ü���ı� 9�� ���, ����ı� 6�����
if($_GET['board'] == 'group_04_09'){
	$list_page=9;
}else{
	$list_page=6;
}
$page_per_list=10;

if(!strcmp($_GET['page'], ''))		$page = '1';
else								$page = $_GET['page'];
//�˻�
if($_GET['kewyword']){
	if($_GET['select']=="hero_title" || $_GET['select']=="hero_command") {
		$search = " and A.".$_GET['select']." like '%".$_GET['kewyword']."%'";
	} else if($_GET['select']=="hero_id") {
		$search = " and B.hero_id = '".$_GET['kewyword']."' ";
	} else {
		$search = " and B.".$_GET['select']." like '%".$_GET['kewyword']."%'";
	}
	$search_next = "&select=".$_GET['select']."&kewyword=".stripslashes($_GET['kewyword']);
}


if($_GET['ak_product']) {
	$search = " and A.hero_01 in (select hero_idx from mission where hero_keywords like '%".$_GET['ak_product']."%' ) ";
	$search_next = "&select=".$_GET['select']."&kewyword=".stripslashes($_GET['kewyword'])."&ak_product=".$_GET['ak_product'];
}

$start = ($page-1)*$list_page;
$next_path="board=".$board."&idx=".$idx.$search_next;

######################################################################################################################################################
$error = "THUMBNAIL_04_LIST_01";
if($board=="group_04_22"){
	$mission_after = "select hero_old_idx from mission_after where hero_idx=".$idx."";
	$mission_after_res = new_sql($mission_after,$error);
	if($mission_after_res==$error){
		error_historyBack("");
		exit;
	}
	$hero_old_idx = mysql_result($mission_after_res,0,"hero_old_idx");
	$where = "and A.hero_idx in (".$hero_old_idx.") ";

//160504 group_04_23 �ֽ�Ŭ�� �߰�, group_04_08 ���ڴ� ����
//���� group �ڵ� ����� �ȵ�
}elseif($board=="group_04_09"){
    $tableType = $_GET['statusSearch'];
    $next_path="board=".$board."&statusSearch=".$tableType."&idx=".$idx.$search_next;

    $where = "and A.hero_table in ('group_04_05', 'group_04_07', 'group_04_08', 'group_04_09', 'group_04_23', 'group_04_06', 'group_04_27', 'group_04_28') ";

    if($tableType) {
        switch ($tableType) {
            case "A": //ü���
                $where = "and A.hero_table = 'group_04_05' ";
                break;
            case "B": //��ƼŬ��
                $where = "and A.hero_table = 'group_04_06' ";
                break;
            case "C": //������Ŭ��
                $where = "and A.hero_table = 'group_04_28' ";
                break;
            default :
                $where = "and A.hero_table in ('group_04_05', 'group_04_07', 'group_04_08', 'group_04_09', 'group_04_23', 'group_04_06', 'group_04_27', 'group_04_28') ";
                break;
        }
    }

}elseif($board=="group_04_10"){
	$where = "and A.hero_table in ('group_04_05', 'group_04_07', 'group_04_08', 'group_04_09', 'group_04_23' , 'group_04_06', 'group_04_27', 'group_04_28') and (A.hero_board_three='1' or A.hero_table='group_04_10')";
}

$sql = "select count(*) from board as A, member as B where A.hero_code=B.hero_code ".$where." and A.hero_use='1' ".$search."";


$count_res = new_sql($sql,$error,"on");

if((string)$count_res==$error){
	error_historyBack("");
	exit;
}

$total_data = mysql_result($count_res,0,0);
######################################################################################################################################################
$sql = "select * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$_GET['board']."'";//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);

//����Ʈ ����üũ
$my_view 	=	$_SESSION ['temp_view'] == '' ? '0' : $_SESSION ['temp_view'];
if($my_view != '9999' && $my_view != '10000'){
	if($my_view < $right_list['hero_list']) {
		error_historyBack("�˼��մϴ�. ������ �����ϴ�.");
		exit;
	}
}
######################################################################################################################################################
//�����ı� �����
if($_GET['board'] == 'group_04_22') {
    $moim_sql = "select * from mission_after where hero_idx = " . $idx . " order by hero_period_01 desc";
    $moim_res = new_sql($moim_sql, $error);

    $moim_thumb = "";
    $moim_title = "";

    if ($moim_res == $error) {
        error_historyBack("");
        exit;
    }

    while ($moim_rs = mysql_fetch_assoc($moim_res)) {
        $moim_thumb = $moim_rs['hero_thumb'];
        $moim_title = $moim_rs['hero_title'];
    }
}
######################################################################################################################################################
//����ı� �̴��� AK Lover
$loyal_period_sql = " SELECT if(startdate <= date_format(now(),'%Y-%m-%d') AND enddate >= date_format(now(),'%Y-%m-%d'),1,0) as status, hero_month FROM member_loyal_period ";
$loyal_period_res = sql($loyal_period_sql);
$loyal_period_rs = mysql_fetch_assoc($loyal_period_res);

$startDateOfMonth = date("Y-m")."-01";
$timestamp = strtotime($startDateOfMonth)-1;
$gisu_date = date("Ym", $timestamp);
$gisu_year = substr($gisu_date,0,4);
$gisu_month = substr($gisu_date,4,2);

$hero_month = "";
if($loyal_period_rs["hero_month"] > 0) {
    $hero_month = $loyal_period_rs["hero_month"]."�� ";
}

$review_member_sql =  " SELECT m.hero_nick FROM member_loyal l INNER JOIN member m ON l.hero_code = m.hero_code ";
$review_member_sql .= " WHERE gisu_year = '".$gisu_year."' AND gisu_month = '".$gisu_month."' ORDER BY l.hero_idx ASC ";
$review_member_res = sql($review_member_sql);
$review_member = "''";
$i = 0;

while($list = mysql_fetch_assoc($review_member_res)){
//    if($i==0)	$comma = '';
//    else		$comma = ',';

    $comma = ',';

    $review_member .= $comma.'\''.$list['hero_nick'].'\'';
    $i++;
}
?>
<div id="subpage" class="cscenter reviewpage">
	<div class="sub_title">
		<div class="sub_wrap">
			<div class="f_b">
                <div>
                    <h1 class="fz68 main_c fw500 ko">
						<? if($board == "group_04_10") { ?>
						��� ������
						<? } else if($board == "group_04_09") { ?>
						��ü ������
						<? } else if($board == "group_04_22") { ?>
						���� ������
						<? } ?>
					</h1>
                    <p class="fz18 fw600">
						<? if($board == "group_04_10") { ?>
							AK Lover�� ����� �������� Ȯ���غ�����!
						<? } else if($board == "group_04_09") { ?>
							AK Lover�� ��� �ı⸦ ����������!
						<? } else if($board == "group_04_22") { ?>
							AK Lover�� ��ſ� ���� ������ ����������!
						<? } ?>
					</p>
                </div>
                <ul class="tab f_c">
                    <li><a href="/main/index.php?board=group_04_10" class="fz18 fw600 <? if($board == "group_04_10") { ?>on<? } ?>">��� ������</a></li>
                    <li><a href="/main/index.php?board=group_04_09" class="fz18 fw600 <? if($board == "group_04_09") { ?>on<? } ?>">��ü ������</a></li>
                    <li><a href="/main/index.php?board=group_04_22" class="fz18 fw600 <? if($board == "group_04_22") { ?>on<? } ?>">���� ������</a></li>
                </ul>
            </div>
		</div>
	</div>
	<div class="sub_cont">
		<div class="sub_wrap board_wrap f_sb">
			<div class="left">
				<? if($board == "group_04_22") { // �����ı� (��� �� �ı⸮��Ʈ)?>
					<!--  [���� ��û] \board\thumbnail_04\list2.php�� �ִ� ��� ������� ����Ǿ�� �մϴ�!![��] -->
					<ul class="moim">
						<li>
							<div>
								<a href="/main/index.php?board=<?=$_GET["board"]?>&idx=<?=$main_res["hero_idx"]?>">
									<img src="<?=$moim_thumb?>" class="event_img">
								</a>
								<div class="event_text">
									<a href="/main/index.php?board=<?=$_GET["board"]?>&idx=<?=$main_res["hero_idx"]?>">
										<p class="ptitle"><span class="title ellipsis_2line fz18 fw600"><?=$moim_title?></span></p>
									</a>
								</div>
							</div>
						</li>
					</ul>
				<? } ?>
				<? if($board == "group_04_10") { // ����ı� ?>
					<? include_once BOARD_INC_END.'search.php';?>
					<div class="caution">
						<h3 class="fz20 fw600">��� �������� ä�� �Ƿ���?</h3>
						<div>
							<div class="f_fs">
								<img src="/img/front/icon/check.png" alt="����ı� ü��">
								<p class="fz14 fw500">������Ƽ�� ������</p>
							</div>
							<span class="info">
							- ������ �ִ� ��<br />
							- ���ϰ� �������� ��ǰ ������ ���� ���� �ڼ��� ������<br />
							- ������ �̹��� ���(��ȭ��, ����, ��� ��)<br />
							- �پ��� ��ǰ Ȱ�� �� ���(��Ÿ�ϸ� ��, ��� ���� ��, <br />
							&nbsp&nbsp&nbsp Before/After �� ��)<br />
							- ����&GIF ���� ��Ȯ�� Ÿ�ֿ̹� �����ϰ� ���
							</span>
						</div>
						<div>
							<div class="f_fs">
								<img src="/img/front/icon/check.png" alt="����ı� ü��">
								<p class="fz14 fw500">������ �ִ� ������</p>
							</div>
							<span class="info">
							- ��ǰ�� ���� �Ẹ�� ������ ���� �����ϰ� �ۼ��� ������<br />
							- ������ �̾߱⸦ ���� ���丮�ڸ��� ���Ͽ� �д��̿��� <br />
							&nbsp&nbsp&nbsp ������ �ִ� ������<br />
							- ��Ȯ�� ���� �������� �д��̿��� ������ �ִ� ������
							</span>
						</div>
					</div>
				<? } else if($board == "group_04_09") { // ��ü�ı� ?>
					<? include_once BOARD_INC_END.'search.php';?>
					<p class="cate_tit fz20 fw800 bold">SUPPORTERS</p>
					<ul id="missionStatus" class="review_cate_tab grid_2">
						<li class="missionStatusSearch <?=$_GET['statusSearch']==""?"on":""?>" data-val="">��ü</li>
						<li class="missionStatusSearch <?=$_GET['statusSearch']=="A"?"on":""?>" data-val="A">������ ��Ƽ&������ Ŭ��</li>
						<li class="missionStatusSearch <?=$_GET['statusSearch']=="B"?"on":""?>" data-val="B">�����̾� ��Ƽ Ŭ��</li>
						<li class="missionStatusSearch <?=$_GET['statusSearch']=="C"?"on":""?>" data-val="C">�����̾� ������ Ŭ��</li>
					</ul>
				<? } ?>
			</div>
			<div class="contents right rel">
				<? if($board == "group_04_10") { //����ı� ?>
				<div class="best_review review_list">
					<div class="titbx">
						<p class="tit f_cs"><img src="/img/front/icon/best.png" alt="�̴��� ak lover"><span class="fz32 bold">�̴��� AK Lover</span></p>
						<div class="desc fz15 fw500 rel">
							<span>
                                <?php
                                $sql = 'select * from hero_group where hero_idx=\'281\';';//desc

                                sql($sql);
                                $list = @mysql_fetch_assoc($out_sql);
                                $data = explode('||', $list['hero_title']);
                                ?>
                                    <?=nl2br(htmlspecialchars($data[0]))?><br><br> <!--�̴��� AK Lover �Ұ�-->
                                    <b class="fz13"><?=nl2br(htmlspecialchars($data[1]))?></b><br> <!--�̴��� AK Lover ���� ���� �� ����-->
							</span>
							<div class="swiper-button-prev"></div>
							<div class="swiper-button-next"></div>
						</div>
					</div>
					<!-- [����] �̴��� ��� �ı� �����̵�[��] -->
					<div class="swiper-container best_review_slide">
					<div class="swiper-wrapper">
                            <?
                            $month_hero_old_idx_sql  = " SELECT hero_idx FROM monthak_manager ";
                            $month_hero_old_idx_sql .= " WHERE hero_use = '0' ";
                            $month_hero_old_idx_sql .= " AND now() BETWEEN startdate AND enddate ";

                            sql($month_hero_old_idx_sql);
                            $month_hero_old_idx_list = @mysql_fetch_assoc($out_sql);

                            $month_hero_old_idx = $month_hero_old_idx_list['hero_idx'];

                            $month_sql  = " SELECT a.board_hero_idx, b.hero_title, b.hero_code, b.hero_nick, b.hero_thumb, c.hero_profile ";
                            $month_sql .= " FROM monthak a ";
                            $month_sql .= " LEFT JOIN board b ON a.board_hero_idx = b.hero_idx ";
                            $month_sql .= " LEFT JOIN member c ON b.hero_code = c.hero_code ";
                            $month_sql .= " WHERE a.hero_use = '0' ";
                            $month_sql .= " AND a.hero_old_idx = '{$month_hero_old_idx}' ";

                            sql($month_sql);
                            while($month_list = @mysql_fetch_assoc($out_sql)){
                                if($month_list['hero_profile'] == ''){
                                    $profile = "/img/front/mypage/defalt.webp";
                                }else {
                                    $profile = $month_list['hero_profile'];
                                }
                                ?>
                                <div class="swiper-slide">
                                    <div class="rel cont_wrap">
                                        <img src="<?=$month_list['hero_thumb']?>" class="thum_img">
                                        <div class="txt_bx">
                                            <span class="nick"><img src="<?=$profile?>"><?=$month_list['hero_nick']?></span>
                                            <span class="title ellipsis_3line"><?=$month_list['hero_title']?></span>
                                        </div>
                                    </div>
                                    <div class='sns_btn_group f_c'>
                                        <?
                                        $month_url_sql = "select gubun, url from mission_url where board_hero_idx = '".$month_list['board_hero_idx']."'";
                                        $month_url_res = new_sql($month_url_sql, $error);

                                        while($month_url_list = mysql_fetch_assoc($month_url_res)){
                                            if($month_url_list['gubun'] == 'insta') {?>
                                                <a href='<?=$month_url_list['url']?>' target='_blank' class='btnLink insta'><span></span><p>�ν�Ÿ�׷�</p></a>
                                            <?}
                                            if($month_url_list['gubun'] == 'naver') {?>
                                                <a href='<?=$month_url_list['url']?>' target='_blank' class='btnLink blog'><span></span><p>��α�</p></a>
                                            <?}
                                            if($month_url_list['gubun'] == 'movie') {?>
                                                <a href='<?=$month_url_list['url']?>' target='_blank' class='btnLink youtube'><span></span><p>��Ʃ��</p></a>
                                            <?}
                                            if($month_url_list['gubun'] == 'etc') {?>
                                                <a href='<?=$month_url_list['url']?>' target='_blank' class='btnLink etc'><span></span><p>��Ÿ</p></a>
                                            <?}
                                        }?>
                                    </div>
                                </div>
                            <?}?>
						</div>
					</div>

				</div>
				<h4 class="fz32 fw600">��ü ���������</h4>
				<!-- [����] ������ ���� ī�װ� �� ���� -->
				<ul id="missionStatus" class="boardTabMenuWrap">
					<!-- <li class="missionStatusSearch <?=$_GET['statusSearch']==""?"on":""?>" data-val="">��ü</li>
					<li class="missionStatusSearch <?=$_GET['statusSearch']=="A"?"on":""?>" data-val="A">��Ƽ</li>
					<li class="missionStatusSearch <?=$_GET['statusSearch']=="B"?"on":""?>" data-val="B">�۽����ɾ�</li>
					<li class="missionStatusSearch <?=$_GET['statusSearch']=="C"?"on":""?>" data-val="C">Ȩ�ɾ�</li> -->
				</ul>
				<? } ?>
				<div class="<? if($board == "group_04_10") { ?>best_reviewbox<? } ?> rel">
					<form name="form_next" action="<?=PATH_HOME.'?'.get('','type=drop');?>" method="post" enctype="multipart/form-data">
						<? if($total_data == 0) { ?>
						<div style='width:100%; border:2px solid #eee; padding:30px 0; text-align:center; font-size:16px; font-weight:bold;'>ü�� �ıⰡ �������� �ʽ��ϴ�.</div>
						<?	} ?>
						<ul class="review_list grid_3">
							<?
							$error = "THUMBNAIL_04_LIST_02";

							$sql  = " SELECT * ";
							$sql .= " , (SELECT count(*) FROM mission_url WHERE board_hero_idx = A.hero_idx) as url_cnt ";
							$sql .= " FROM ( SELECT A.hero_idx, A.hero_code, A.hero_table, A.hero_command, A.hero_thumb ";
							$sql .= " , A.hero_img_new, A.hero_today, A.hero_title,A.hero_04,A.blog_url ";
							$sql .= " , A.cafe_url ,A.sns_url, A.etc_url, B.hero_level, B.hero_nick, B.hero_profile FROM board  A ";
							$sql .= " INNER JOIN member B ON A.hero_code = B.hero_code ";
							$sql .= " WHERE 1=1 ".$where." ".$search." and A.hero_use=1 order by A.hero_today desc limit ".$start.",".$list_page.") as A ";
							$sql .= " ,(select hero_img_new as level_img, hero_level from level) as C where A.hero_level=C.hero_level order by A.hero_today desc";
							//echo $sql;

							$res = new_sql($sql, $error);
							if((string)$res==$error){
								error_historyBack("");
								exit;
							}
							$view_count = '4';
							$dd = '1';

							$unblocked_site = array("naver", "daum", "tistory");
							$unblocked_site_name = array("���̹�", "����", "Ƽ���丮");
							$total_html = "";
							$i = 0;
							while($list = mysql_fetch_assoc($res)){
                                if(empty($list['hero_profile'])){
                                    $hero_profile = "/img/front/mypage/defalt.webp";
                                }else {
                                    $hero_profile = $list['hero_profile'];
                                }

								if($list['hero_04']) {
									$link="<a href='http://".$_SERVER["HTTP_HOST"]."/main/index.php?board=".$list['hero_table']."&page=".$page."&view=view2&idx=".$list['hero_idx']."' target='_blank'>";
								}else if($list['blog_url'] || $list['cafe_url'] || $list['sns_url'] || $list['etc_url']) {
									$link="<a href='http://".$_SERVER["HTTP_HOST"]."/main/index.php?board=".$list['hero_table']."&page=".$page."&view=view2&idx=".$list['hero_idx']."' target='_blank'>";
								} else if($list["url_cnt"] > 0) {
									$link="<a href='http://".$_SERVER["HTTP_HOST"]."/main/index.php?board=".$list['hero_table']."&page=".$page."&view=view2&idx=".$list['hero_idx']."' target='_blank'>";
								}else {
									$link="<a href=".PATH_HOME."?board=".$_GET['board']."&page=".$page."&view=view&idx=".$list['hero_idx']." target='_blank'>";
								}

								if($list["hero_thumb"])	    			$view_img = $list['hero_thumb'];
								elseif($list["hero_img_new"]) 	 		$view_img = $list['hero_img_new'];
								else						    		$view_img = IMAGE_END.'hero.jpg';

								$main_review_sql = "select count(*) from review where hero_old_idx='".$list['hero_idx']."'";
								$out_main_review_sql = @mysql_query($main_review_sql);
								$main_review_data = @mysql_result($out_main_review_sql,0,0);

								if($main_review_data>0)			$re_count_total = "<strong><font color='orange'>[".$main_review_data."]</font></strong>";
								else							$re_count_total = "";

								if($today == substr($list['hero_today'],0,10))		$new_img_view = " style='background:url(".DOMAIN_END."image/main_new_bt.png) no-repeat 0 2px;'";

								if (strcmp($dd,'3'))		$total_html .= "<li>";
								else if(!strcmp($dd,'3')){
									$total_html .= "<li class='last'>";
									$dd = '0';
								}

								$new_content = "����:".$list['hero_title']."\n\n�ۼ���:".date( "Y-m-d", strtotime($list['hero_today']))."\n\n�ۼ���:".$list['hero_nick'];
								$total_html .= "<div class='rel cont_wrap' title='".$new_content."'>";

								if ($list['hero_nick'] == '������') {
									$total_html .= $link;
								}

								$total_html .= "<img src='".$view_img."' class='thum_img' onError='this.src=\"/image/hero_empty.jpg\"'/>";
								$total_html .= "<div class='txt_bx'>";
								// [����]������ �̹��� �ӽ��۾� �Դϴ�[��]
								$total_html .= "<span class='nick'><img src='$hero_profile'/>".$list['hero_nick']."</span>";
								if($list['hero_nick']) {
									$total_html .= "<span class='title ellipsis_3line'>".cut($list['hero_title'], '300').$re_count_total."</span></div>";
								}
								$total_html .= "</div>";

								// [����] ���� ��ư ��ġ �̵�
								$total_html .= "<div class='update_bx'>";
                                if($_SESSION['temp_level']>=9999 || ($_SESSION['temp_code']==$list['hero_code'] && $_SESSION['temp_code'])){
                                    $mission_sql = "SELECT A.hero_idx AS board_idx, B.hero_type, B.hero_idx, C.hero_idx as review_idx FROM board A
                                                    LEFT JOIN mission B ON A.hero_01 = B.hero_idx
                                                    LEFT JOIN mission_review C ON A.hero_code = C.hero_code
                                                    WHERE A.hero_idx = '".$_GET['idx']."' AND
                                                          A.hero_01 = C.hero_old_idx
                                                    LIMIT 1";

                                    $mission_sql_res = mysql_query($mission_sql);
                                    $mission_type = mysql_fetch_array($mission_sql_res);

                                    if($mission_type['hero_type'] == 2) {
                                        $total_html .= "<a href=\"".MAIN_HOME."?board=group_04_05&idx=".$mission_type['hero_idx']."&view=step_02_01&hero_idx=".$mission_type['review_idx']."&somun=Y&board_idx=".$mission_type['board_idx']."\"><img src=\"/img/front/icon/update_btn.webp\"></a>";
                                    }else{
                                        $total_html .= "<a href=\"".MAIN_HOME."?board=".$list['hero_table']."&view=write2&action=update&page=".$_GET['page']."&hero_idx=".$list['hero_idx']."\"><img src=\"/img/front/icon/update_btn.webp\"></a>";
                                    }
                                }

								$total_html .= "</div>";

								$total_html .= "<div class='sns_btn_group f_c'>";
								// [����] �ش� sns �Խñ۷� �ٷΰ��� [��]
                                $url_sql = "select gubun, url from mission_url where board_hero_idx = '".$list['hero_idx']."'";
                                $url_res = new_sql($url_sql, $error);
//                                echo $url_sql;
                                while($url_list = mysql_fetch_assoc($url_res)){
                                    if($url_list['gubun'] == 'insta') {
                                        $total_html .= "<a href='".$url_list['url']."' target='_blank' class='btnLink insta'><span></span><p>�ν�Ÿ�׷�</p></a>";
                                    }
                                    if($url_list['gubun'] == 'naver') {
                                        $total_html .= "<a href='".$url_list['url']."' target='_blank' class='btnLink blog'><span></span><p>��α�</p></a>";
                                    }
                                    if($url_list['gubun'] == 'movie') {
                                        $total_html .= "<a href='".$url_list['url']."' target='_blank' class='btnLink youtube'><span></span><p>��Ʃ��</p></a>";
                                    }
                                    if($url_list['gubun'] == 'etc') {
                                        $total_html .= "<a href='".$url_list['url']."' target='_blank' class='btnLink etc'><span></span><p>��Ÿ</p></a>";
                                    }
                                }
								$total_html .= "</div></li>";
								$dd++;
							}//while
							echo $total_html;
							?>
						</ul>
					</form>
					<?//����ı�
					include_once BOARD_INC_END.'button.php';
                    ?>
				</div>
			</div>
		</div>
	</div>
</div>


	<script>
    $(document).ready(function(){
    	$('.missionStatusSearch').click(function(){
    		$('.missionStatusSearch').removeClass('on');
    		if($(this).attr('class').indexOf('on') != -1) {
    			$(this).addClass('on');
    		}
    		$('#statusSearch').val($(this).attr('data-val'));
    		$('#searchFrm').submit();
    	})
    })
    </script>
