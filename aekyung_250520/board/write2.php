<link rel="stylesheet" type="text/css" href="/css/front/lovertalk.css">
<link rel="stylesheet" type="text/css" href="/css/front/supporters.css">
<?
######################################################################################################################################################
//15�� 3�� ������ ����
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;

if($_SESSION['temp_level']=='' || !is_numeric($_SESSION['temp_level']) || !$_GET['action']){
	echo '<script>location.href="./out.php"</script>';
	exit;
}

$focus_group = false;
if($_GET["board"] == "group_04_06" || $_GET["board"] == "group_04_27" || $_GET["board"] == "group_04_28") {
	$focus_group = true;
}

$member_sql = " SELECT hero_info_ci FROM member WHERE hero_use = 0  AND hero_code = '".$_SESSION["temp_code"]."' ";
$member_res = sql($member_sql);
$member_rs = mysql_fetch_assoc($member_res);

if(!$member_rs["hero_info_ci"]){
	error_location("ü��ܿ� �����ϱ� ���ؼ��� ���������� �ʿ��մϴ�","/main/index.php?board=auth");
	exit;
}

$fulltoday = date("Y-m-d H:i:s");

if($_GET['action']=='update'){
	$hero_idx 		= 	 $_GET['hero_idx'];
	$board 			= 	 $_GET['board'];
	$next_board		=	 $_GET['next_board'];
	$action			=	 $_GET['action'];
	$page			=	 $_GET['page'];
    if($page == '') $page = '1';

	$sql = "select * from board where hero_idx='".$hero_idx."'";
	$sql_res = mysql_query($sql);
	if(!$sql_res){
		logging_error($_SESSION['temp_nick'],$board."-WRITE2_01",$fulltoday);
		error_historyBack("");
		exit;
	}

	$out_row = mysql_fetch_assoc($sql_res);//mysql_fetch_row

	$mission_idx	=	 $out_row['hero_01'];
	$code 			=	 $out_row['hero_code'];
	$name 			=	 $out_row['hero_name'];
	$nick			=	 $out_row['hero_nick'];
	$totay 			=	 $out_row['hero_today'];
	$review_count 	=	 $out_row['hero_review_count'];
	$hero_thumb 	=	 $out_row['hero_thumb'];
	$hero_product_review 	=	 $out_row['hero_product_review'];
	$agree			=	 $out_row['hero_agree'];

	$new_table 	= $out_row['hero_table'];
	$hero_03 	= $out_row['hero_03'];

	//���̹�
	$naver_sql = " SELECT url, member_check, admin_check FROM mission_url WHERE board_hero_idx = '".$hero_idx."' AND gubun='naver' ";
	$naver_res = sql($naver_sql);
	$naver_rs = mysql_fetch_assoc($naver_res);

	//�ν�Ÿ
	$insta_sql = " SELECT url, member_check, admin_check FROM mission_url WHERE board_hero_idx = '".$hero_idx."' AND gubun='insta' ";
	$insta_res = sql($insta_sql);
	$insta_rs = mysql_fetch_assoc($insta_res);

	//���� ä��
	if($out_row["hero_table"] == "group_04_27") {
		$movie_sql = " SELECT url, member_check, admin_check FROM mission_url WHERE board_hero_idx = '".$hero_idx."' AND gubun='movie' ORDER BY hero_idx ASC ";
		$movie_res = sql($movie_sql);
	}

	//ī��
	$cafe_sql = " SELECT url, member_check, admin_check FROM mission_url WHERE board_hero_idx = '".$hero_idx."' AND gubun='cafe' ORDER BY hero_idx ASC ";
	$cafe_res = sql($cafe_sql);

	//��Ÿ
	$etc_sql = " SELECT url, member_check, admin_check FROM mission_url WHERE board_hero_idx = '".$hero_idx."' AND gubun='etc' ORDER BY hero_idx ASC ";
	$etc_res = sql($etc_sql);

	if($code!=$_SESSION['temp_code'] && $_SESSION['temp_level']<9999){
		echo '<script>location.href="./out.php"</script>';
		exit;
	}
} else if(!strcmp($_GET['action'], 'write')){
	$mission_idx	=	 $_GET['idx'];
	$board 			= 	 $_GET['board'];
	$action			=	 $_GET['action'];
	$page			=	 $_GET['page'];
    if($page == '') $page = '1';

	$code 			= 	$_SESSION['temp_code'];
	$name 			= 	$_SESSION['temp_name'];
	$nick 			= 	$_SESSION['temp_nick'];
	$level 			= 	$_SESSION['temp_level'];

	$totay 			= 	Ymdhis;
	$review_count	=	'0';
	$hero_thumb 	=	"";

	$new_table 		=	$_GET['board'];
	$hero_03 		=	$_GET['board'];
}

	$sql = "select * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$_GET['board']."'";//desc
	$sql_res = mysql_query($sql);
	if(!$sql_res){
		logging_error($_SESSION['temp_nick'],$board."-WRITE2_02",$fulltoday);
		error_historyBack("");
		exit;
	}

	$right_list = mysql_fetch_assoc($sql_res);

	$pk_sql = 'select * from level where hero_level = \''.$level.'\'';
	$sql_res = mysql_query($pk_sql);
	if(!$sql_res){
		logging_error($_SESSION['temp_nick'],$board."-WRITE2_03",$fulltoday);
		error_historyBack("");
		exit;
	}
	$pk_row = mysql_fetch_assoc($sql_res);

	//�̼� ����
	$mission_sql  = " SELECT hero_idx, hero_type, hero_ftc, hero_ftc_naver, hero_ftc_insta, hero_question_url_list, hero_product_review_yn, hero_question_url_check ";
	$mission_sql .= " , hero_table ,hero_movie_group,  hero_movie_gisu , hero_banner";
	$mission_sql .= " FROM mission WHERE hero_idx = '".$mission_idx."' ";

	$mission_sql_res = mysql_query($mission_sql);
	$mission_row = mysql_fetch_assoc($mission_sql_res);

	//21-06-01 ���� ���� �߰�
	$mission_write_auth = true;
	if($focus_group) {
		if($mission_row["hero_type"] == "7") {
			$review_auth_sql  = " SELECT count(*) cnt FROM mission_review WHERE hero_old_idx = '".$mission_idx."'  ";
			$review_auth_sql .= " AND hero_code = '".$_SESSION["temp_code"]."' AND lot_01 = '1' ";
			$review_auth_res = sql($review_auth_sql);
			$review_auth_rs = mysql_fetch_assoc($review_auth_res);

			if($review_auth_rs["cnt"] == 0) $mission_write_auth = false;
		} else { //TODO 220317 ����̼�  ���ٱ��� �߰�
			if($_SESSION["temp_level"] != "9999") {
				if($mission_row["hero_table"] == "group_04_06") {//��Ƽü���
					if($_SESSION["temp_level"] != "9996") $mission_write_auth = false;
				} else if($mission_row["hero_table"] == "group_04_28") { //������ü���
					if($_SESSION["temp_level"] != "9994") $mission_write_auth = false;
				} else if($mission_row["hero_table"] == "group_04_27") { //���� ü���
					if($mission_row["hero_movie_group"] == "group_04_27") {
						if($_SESSION["temp_level"] != "9995") $mission_write_auth = false;
					} else if($mission_row["hero_movie_group"] == "group_04_31") {
						if($_SESSION["temp_level"] != "9993") $mission_write_auth = false;
					}
				}
			}
		}
	} else {
		$review_auth_sql  = " SELECT count(*) cnt FROM mission_review WHERE hero_old_idx = '".$mission_idx."'  ";
		$review_auth_sql .= " AND hero_code = '".$_SESSION["temp_code"]."' AND lot_01 = '1' ";
		$review_auth_res = sql($review_auth_sql);
		$review_auth_rs = mysql_fetch_assoc($review_auth_res);

		if($review_auth_rs["cnt"] == 0) $mission_write_auth = false;
	}

    //musign �߰� ������ ��ϱⰣ���� ���� S
    $review_period_sql = " SELECT count(*) cnt FROM mission WHERE hero_idx = '" . $mission_idx . "'  ";
    //�ҹ�����
    if($mission_row["hero_type"] == "2"){
        $review_period_sql .= " AND NOW() BETWEEN hero_today_01_01 AND hero_today_01_02 ";
    }
    //�ҹ����� ��
    else {
        $review_period_sql .= " AND NOW() BETWEEN hero_today_03_01 AND hero_today_03_02 ";
    }
    $review_period_res = sql($review_period_sql);
    $review_period_rs = mysql_fetch_assoc($review_period_res);
    //musign �߰� ������ ��ϱⰣ���� ���� E

    if($_SESSION['temp_level'] < 9998){
        if(!$mission_write_auth) {
            error_historyBack("ü��ܿ� ��÷�� ȸ���� �̿� �����մϴ�.");
            exit;
        }

        if ($review_period_rs["cnt"] == 0) {
            error_historyBack("������ ��� �Ⱓ�� �ƴմϴ�.");
            exit;
        }
    }
    
	//����������
	$search_ftc_naver = $mission_row["hero_banner"];
	$search_ftc_naver = preg_replace("/\s+/","",$search_ftc_naver);
	$search_ftc_naver = strtolower($search_ftc_naver);
	$search_ftc_naver = urlEncode($search_ftc_naver);

	$search_ftc_insta = $mission_row["hero_ftc_insta"];
	$search_ftc_insta = preg_replace("/\s+/","",$search_ftc_insta);
	$search_ftc_insta = strtolower($search_ftc_insta);
	$search_ftc_insta = urlEncode($search_ftc_insta);

	$hero_question_url_list = $mission_row["hero_question_url_list"]; //�ı⾲�� ���̹� ��α�, �ν�Ÿ �ʼ��� üũ

	if($_GET['hero_idx']) $page_title = "�ı����";
	else $page_title = "�ı���"
?>
<div id="subpage" class="talk_write">
	<div class="sub_wrap board_wrap">
		<div class="contents right">
			<div class="write_cont">
				<div class="cont_top">
					<h2 class="fz15 fw600 main_c">ü��� <?=$page_title?></h2>
					<p class="fz14 fw500 op05" style="margin-top: .7rem;"><span class="txt_emphasis">*</span>�� �ʼ� �Է� �׸��Դϴ�.
					<? if($board=="group_04_09"){?>
						<span class="main_c fz14 bold">* ü��� �ı�� ü���ı� �޴��� �ƴ� �ش� ü��� �� �ϴܿ� �ִ� '�ı� ���'�� ���� ���� �ּ���.</span>
					<? } ?>
					</p>
				</div>
				<form name="frm" method="post" action="<?=MAIN_HOME;?>?board=<?=$board;?>&next_board=<?=$board;?>&view=action2&action=<?=$action;?>&hero_idx=<?=$hero_idx;?>&mission_idx=<?=$mission_idx?>&page=<?=$page?>" enctype="multipart/form-data">
				<input type="hidden" name="hero_drop" value="hero_drop||x||y">
				<input type="hidden" name="hero_code" value="<?=$code;?>">
				<input type="hidden" name="hero_review" value="<?=$code;?>">
				<input type="hidden" name="hero_today" value="<?=$totay;?>">
				<input type="hidden" name="hero_ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
				<input type="hidden" name="hero_review_count" value="<?=$review_count?>">
				<input type="hidden" name="hero_name" value="<?=$name;?>">
				<input type="hidden" name="hero_01" value="<?=$mission_idx;?>">
				<input type="hidden" name="hero_notice" value="1">
				<input type="hidden" name="hero_03" value="<?=$hero_03?>">
				<input type="hidden" name="hero_table" value="<?=$new_table?>">
				<input type="hidden" name="hero_nick" id="hero_nick" title="�ۼ���" value="<?=$nick;?>" readonly/>
				<? if(!strcmp($board, 'group_04_10')){ ?>
					<input type="hidden" name="hero_02" value="1">
				<? } ?>
				<div class="">
					<div class="tit"><input type="text" name="hero_title" id="hero_title" class="w590" title="����" value="<?=$out_row['hero_title'];?>" placeholder="������ �Է��ϼ���."/></div>
					<div class="thum_file upfile f_cs mgb25">
						<p class="list_tit fz17 fw500">��ǥ �̹���</p>
						<div>
							<div id="present_image_area">
								<? if($hero_thumb){ ?>
									<img src="<?=$hero_thumb?>" style="width:200px;margin-top:10px;"><br/>
								<? } ?>
							</div>
							<div class="rel">
								<input type="hidden" id="hero_thumb" name="hero_thumb" value="<?=$hero_thumb?>"/>
								<label for="write_hero_thumb" id="link" class="btnUpload custom-file-upload">�̹��� ���ε�<img src="/img/front/icon/fileup.webp" alt="÷������ ���ε�"></label>
							</div>
							<p class="fz15 op05">* 10MB ���Ϸ� ���ε��� �ּ���.</p>
						</div>
					</div>
					<div class="mgb25 f_cs">
						<p class="list_tit fz17 fw500">�ۼ���</p>
						<div><?=$nick;?></div>
					</div>
					<? if($mission_row["hero_product_review_yn"]=="Y") {?>
						<div class="thum_file upfile f_cs">
							<p class="list_tit fz17 fw500" style="margin-top: 1rem;">��ǰ��(ĸ��)<br/>�̹���</p>
							<div>
								<div id="present_image_area">
									<? if($hero_thumb){ ?>
										<img src="<?=$hero_product_review?>">
									<? } ?>
								</div>
								<div class="rel">
									<input type="hidden" id="hero_product_review" name="hero_product_review" value="<?=$hero_product_review?>"/>
									<label for="write_hero_product_review" id="link" class="btnUpload custom-file-upload">�̹��� ���ε�<img src="/img/front/icon/fileup.webp" alt="÷������ ���ε�"></label>
								</div>
							</div>
						</div>
						<div class="warn mgb25">
							<p class="fz15 op05">
								- ��ǰ�� �ۼ��� �����̼��Դϴ�.<br />
								- ����Ʈ ü��� �������̼ǣ����� ������ ��ǰ ��ǰ���� �ۼ��Ͻ� ��� ĸ�ĺ��� ÷�����ּ���.
							</p>
						</div>
					<? } ?>
					<div class="dis-no">
						<? if($mission_row['hero_question_url_check'] && $mission_row['hero_question_url_check'] != "9") {?>
							<?
							if($mission_row['hero_question_url_check'] == "1") {?>
							<div>
								<div colspan="2" style="border-bottom:none;">
									<span class="txt_emphasis_12">* ���̹� ��α� URL�� �ʼ��� �Է��ϼž� �մϴ�.</span>
								</div>
							</div>
							<? } else if($mission_row['hero_question_url_check'] == "2") {?>
							<div>
								<div colspan="2" style="border-bottom:none;">
									<span class="txt_emphasis_12">* �ν�Ÿ�׷� URL�� �ʼ��� �Է��ϼž� �մϴ�.</span>
								</div>
							</div>
							<? } else if($mission_row['hero_question_url_check'] == "3") {?>
							<div>
								<div colspan="2" style="border-bottom:none;">
									<span class="txt_emphasis_12">* ���̹� ��α�/�ν�Ÿ�׷� URL �� �Ѱ��� URL�� �ʼ��� �Է��ϼž� �մϴ�.</span>
								</div>
							</div>
							<? } else if($mission_row['hero_question_url_check'] == "4") {?>
							<div>
								<div colspan="2" style="border-bottom:none;">
									<span class="txt_emphasis_12">* ���̹� ��α�, �ν�Ÿ�׷� URL�� �ʼ��� �Է��ϼž� �մϴ�.</span>
								</div>
							</div>
							<? } else if($mission_row['hero_question_url_check'] == "6") {?>
							<div>
								<div colspan="2" style="border-bottom:none;">
									<span class="txt_emphasis_12">* ���̹� ��α�, �ν�Ÿ�׷� URL, �ı�(����) URL �� �ʼ��� �Է��ϼž� �մϴ�.</span>
								</div>
							</div>
							<? } else if($mission_row['hero_question_url_check'] == "5" && $_GET["board"] == "group_04_27") {?>
							<div>
								<div colspan="2" style="border-bottom:none;">
									<span class="txt_emphasis_12">* �ı�(����) URL�� �ʼ��� �Է��ϼž� �մϴ�.</span>
								</div>
							</div>
							<? } ?>
						<? } ?>
					</div>
					<div class="info_banner_wrap">
						<p class="list_tit fz17 fw500">������ ��� �ȳ�</p>
						<div class="info_banner">
							<p class="fz14 fw500 main_c"><img src="/img/front/icon/caution.webp" alt="�ȳ�/���ǻ���" style="margin-right: .5rem;">Notice</p>
							<span class="fz17 fw600">
								�����ŷ�����ȸ ��ǥ�� ������� ��ħ�� ����, ��� ��ǰ ���信�� ������ ��ʰ� �ݵ�� ����Ǿ�� �մϴ�.<br/>
								���� ������ �ۼ� �� AK Lover ������ ������ �� �������ּ���!
							</span>
						</div>
					</div>
					<div class="sns_wirte">
						<div>
							<div class="fz16 fw500" style="margin-bottom: 1.4rem;">
								���̹� ��α� URL
							</div>
							<div>
								<div class="f_b">
									<div class="blog_input_wrap">
										<input type="text" name="naver_url" placeholder="�ݵ�� ������ URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)" class="inputUrl" value="<?=$naver_rs["url"]?>"/>
										<input type="hidden" name="naver_admin_check" id="naver_admin_check" value="<?=$naver_rs["admin_check"]?>" />
									</div>
									<? if($mission_row["hero_ftc"] == "1") { ?>
										<div><a href="javascript:;" onClick="fnAdminCheck('naver')" class="btnUrlCheck fz15 fw600">������ ��� Ȯ��</a></div>
									<? } ?>
								</div>
								<? if($mission_row["hero_ftc"] == "1") { ?>	<p class="txt_url_check" id="txt_naver_url_check"></p><? } ?>
								<p class="main_c fz12 fw500 desc">���̹� ��α��� ��� ������ ��ʰ� ���������� ������ �Ǿ����� �ݵ�� Ȯ���� �����ž� �մϴ�.<br />
								Ȯ���ϱ� ��ư�� Ŭ���Ͻð� �ı� ����� �Ϸ����ֽñ� �ٶ��ϴ�.</p>
								<!-- <dl class="urlAgreeBox">
									<dt>�� �����ŷ�����ȸ ������ �ۼ��Ͽ����ϱ�?</dt>
									<dd>
										<input type="radio" name="naver_member_check" id="naver_member_check_Y" value="Y" <?=$naver_rs["member_check"] == "Y" ? "checked":"";?>/><label for="naver_member_check_Y">��</label>
										<input type="radio" name="naver_member_check" id="naver_member_check_N" vlaue="N" <?=$naver_rs["member_check"] == "N" ? "checked":"";?>/><label for="naver_member_check_N">�ƴϿ�</label>
									</dd>
								</dl>							 -->
							</div>
						</div>
						<div>
							<div class="fz16 fw500" style="margin-bottom: 1.4rem;">
								�ν�Ÿ�׷� URL
							</div>
							<div>
								<div class="f_b">
									<div class="blog_input_wrap">
										<input type="text" name="insta_url" placeholder="�ݵ�� ������ URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)" class="inputUrl" value="<?=$insta_rs["url"]?>"/>
										<input type="hidden" name="insta_admin_check" id="insta_admin_check" value="<?=$insta_rs["admin_check"]?>"/>
									</div>
								</div>
								<? if($mission_row["hero_ftc"] == "1") { ?>	<p class="txt_url_check" id="txt_insta_url_check"></p><? } ?>
								<dl class="urlAgreeBox">
									<dt>�� �����ŷ�����ȸ ������ �ۼ��Ͽ����ϱ�?</dt>
									<dd>
										<div class="input_radio"><input type="radio" name="insta_member_check" id="insta_member_check_Y" value="Y" <?=$insta_rs["member_check"] == "Y" ? "checked":"";?>/><label for="insta_member_check_Y" class="input_radio_label">��</label></div>
										<div class="input_radio"><input type="radio" name="insta_member_check" id="insta_member_check_N" value="N" <?=$insta_rs["member_check"] == "N" ? "checked":"";?>/><label for="insta_member_check_N" class="input_radio_label">�ƴϿ�</label></div>
									</dd>
									<p class="txt_agree_info mgb10">
										�� �����ŷ�����ȸ�� ����õ���� � ���� ǥ�ñ��� �ɻ���ħ�� �Ǵ� �����ڻ�ŷ� ����� �Һ��ں�ȣ�� ���� �������� ���� �ʼ� �����������, �ۼ����� ���� ��� AK LOVER Ȱ���� �������� ���� �� �ֽ��ϴ�.
									</p>
								</dl>
							</div>
						</div>
						<? if($mission_row['hero_question_url_check'] == "6" || $_GET['board'] == 'group_04_27' || $out_row["hero_table"] == "group_04_27"){ ?>
						<div>
							<div class="fz16 fw500" style="margin-bottom: 1.4rem;">��Ʃ�� URL</div>
							<div>
								<div class="ui_urlBox">
									<div class="ui_url rel">
										<input type="text" name="movie_url[]" placeholder="�ݵ�� ������ URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)" class="inputUrl3"/>
										<a href="javascript:;" onClick="fnUrl(this,'add')" class="btn_url_add">+</a>
										<dl class="urlAgreeBox">
											<dt>�� �����ŷ�����ȸ ������ �ۼ��Ͽ����ϱ�?</dt>
											<dd>
												<div class="input_radio"><input type="radio" name="movie_member_check1" id="movie_member_check1_Y" value="Y"/><label for="movie_member_check1_Y">��</label></div>
												<div class="input_radio"><input type="radio" name="movie_member_check1" id="movie_member_check1_N" value="N"/><label for="movie_member_check1_N">�ƴϿ�</label></div>
											</dd>
										</dl>
										<p class="txt_agree_info mgb10">
											�� �����ŷ�����ȸ�� ����õ���� � ���� ǥ�ñ��� �ɻ���ħ�� �Ǵ� �����ڻ�ŷ� ����� �Һ��ں�ȣ�� ���� �������� ���� �ʼ� �����������, �ۼ����� ���� ��� AK LOVER Ȱ���� �������� ���� �� �ֽ��ϴ�.
										</p>
									</div>
									<? if($_GET["action"] == "update" && ($mission_row['hero_question_url_check'] == "6" || $_GET["board"] == "group_04_27" || $out_row["hero_table"] == "group_04_27")) {
										$k = 2;
										while($movie_list = mysql_fetch_assoc($movie_res)) {
									?>
										<div class="ui_url rel">
											<input type="text" name="movie_url[]" placeholder="�ݵ�� ������ URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)" class="inputUrl3" value="<?=$movie_list["url"]?>"/>
											<a href="javascript:;" onClick="fnUrl(this,'minus')" class="btn_url_minus">-</a>
											<dl class="urlAgreeBox">
												<dt>�� �����ŷ�����ȸ ������ �ۼ��Ͽ����ϱ�?</dt>
												<dd>
													<div class="input_radio"><input type="radio" name="movie_member_check<?=$k?>" id="movie_member_check<?=$k?>_Y" value="Y" <?=$movie_list["member_check"] == "Y" ? "checked":"";?>/><label for="movie_member_check<?=$k?>_Y">��</label></div>
													<div class="input_radio"><input type="radio" name="movie_member_check<?=$k?>" id="movie_member_check<?=$k?>_N" value="N" <?=$movie_list["member_check"] == "N" ? "checked":"";?>/><label for="movie_member_check<?=$k?>_N">�ƴϿ�</label></div>
												</dd>
											</dl>
											<p class="txt_agree_info mgb10">
												�� �����ŷ�����ȸ�� ����õ���� � ���� ǥ�ñ��� �ɻ���ħ�� �Ǵ� �����ڻ�ŷ� ����� �Һ��ں�ȣ�� ���� �������� ���� �ʼ� �����������, �ۼ����� ���� ��� AK LOVER Ȱ���� �������� ���� �� �ֽ��ϴ�.
											</p>
										</div>
									<?
										$k++;
										}
									}?>
								</div>
							</div>
						</div>
						<? } ?>
						<div>
							<div class="fz16 fw500" style="margin-bottom: 1.4rem;">��Ÿ</div>
							<div>
								<div class="ui_urlBox">
									<div class="ui_url rel">
										<input type="text" name="etc_url[]" placeholder="�ݵ�� ������ URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)" class="inputUrl3"/>
										<a href="javascript:;" onClick="fnUrl(this,'add')" class="btn_url_add">+</a>
										<dl class="urlAgreeBox">
											<dt>�� �����ŷ�����ȸ ������ �ۼ��Ͽ����ϱ�?</dt>
											<dd>
												<div class="input_radio"><input type="radio" name="etc_member_check1" id="etc_member_check1_Y" value="Y"/><label for="etc_member_check1_Y">��</label></div>
												<div class="input_radio"><input type="radio" name="etc_member_check1" id="etc_member_check1_N" value="N"/><label for="etc_member_check1_N">�ƴϿ�</label></div>
											</dd>
										</dl>
										<p class="txt_agree_info mgb10">
											�� �����ŷ�����ȸ�� ����õ���� � ���� ǥ�ñ��� �ɻ���ħ�� �Ǵ� �����ڻ�ŷ� ����� �Һ��ں�ȣ�� ���� �������� ���� �ʼ� �����������, �ۼ����� ���� ��� AK LOVER Ȱ���� �������� ���� �� �ֽ��ϴ�.
										</p>
									</div>
									<? if($_GET["action"] == "update") {
										$k = 2;
										while($etc_list = mysql_fetch_assoc($etc_res)) {
									?>
										<div class="ui_url">
											<input type="text" name="etc_url[]" placeholder="�ݵ�� ������ URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)" class="inputUrl3" value="<?=$etc_list["url"]?>"/>
											<a href="javascript:;" onClick="fnUrl(this,'minus')" class="btn_url_minus">-</a>
											<dl class="urlAgreeBox">
												<dt>�� �����ŷ�����ȸ ������ �ۼ��Ͽ����ϱ�?</dt>
												<dd>
													<div class="input_radio"><input type="radio" name="etc_member_check<?=$k?>" id="etc_member_check<?=$k?>_Y" value="Y" <?=$etc_list["member_check"] == "Y" ? "checked":"";?>/><label for="cafe_member_check<?=$k?>_Y">��</label></div>
													<div class="input_radio"><input type="radio" name="etc_member_check<?=$k?>" id="etc_member_check<?=$k?>_N" value="N" <?=$etc_list["member_check"] == "N" ? "checked":"";?>/><label for="cafe_member_check<?=$k?>_N">�ƴϿ�</label></div>
												</dd>
											</dl>
											<p class="txt_agree_info mgb10">
												�� �����ŷ�����ȸ�� ����õ���� � ���� ǥ�ñ��� �ɻ���ħ�� �Ǵ� �����ڻ�ŷ� ����� �Һ��ں�ȣ�� ���� �������� ���� �ʼ� �����������, �ۼ����� ���� ��� AK LOVER Ȱ���� �������� ���� �� �ֽ��ϴ�.
											</p>
										</div>
									<?
										$k++;
										}
									}?>
								</div>
							</div>
						</div>
						<div class="dis-no">
							<div colspan="2">
							<div class="infoBox">
									<p class="txt_info">
									�� AK LOVER���� ����Ǵ� ��� ü����� �����ŷ�����ȸ ǥ�ñ���� ��ħ�� ���� ��ǰ�� �����޾� �ı⸦ �ۼ��Ͻ� ���, �밡�� ���θ� ǥ���ϴ� ���� ������ ��Ģ���� �ϰ� �ֽ��ϴ�.<br/>
									<span class="txt_subInfo">
									�� ���̹� ��α�, �ν�Ÿ�׷� URL�� 1���� ��� �����ϸ�, �ı�(����), ī��, ��Ÿ URL�� �ִ� 5������ ����� �����մϴ�.<br/>
									�� ��Ÿ����  Ʈ����, īī�����丮, ���̽��� �� URL�� �Է��մϴ�.
									</span>
									</p>
								</div>
							</div>
						</div>
						<? if($_GET['board'] == 'group_04_06' || $_GET['board'] == 'group_04_08' || $_GET['board'] == 'group_04_23' || $_GET['board'] == 'group_04_27' || $_GET['board'] == 'group_04_28'){ ?>
							<div class="last">
								<div style="line-height:25px; border-top:1px solid #d4d4d4" colspan="2">
									<p class="tit mgt5">������ Ȱ�� ����</p>
									<p class="txt_tit_ex mgt5">
										AK LOVER Ȱ���� ��ȯ���� �ۼ��� ��� ������(���۹�)�� ���õ� �Ǹ�(���۱�, �ʻ�� ��)�� AK LOVER
										Ȱ������ ������ ��/���� ������ǰ �� �귣�� ������Ʈ, Ȩ���� ���, �¶���/�������� ����,
										��Ÿ ����, ȫ�� �� ������ �ڷ�� AK LOVER Ȱ�� ��, Ȱ���� ����� �Ŀ��� ������ ���� öȸ �ǻ縦 ������ ������ �������� �����Ӱ� �̿��� �Ǹ� �� 2���� ���۹� �ۼ����� �ְ����߿� ����ϸ� �̿� �����մϴ�.
									</p>
									<p style="padding:5px 0 5px 0; font-size:14px;">�� ���뿡 �����Ͻʴϱ�?
										<div class="input_chk"><input type="checkbox" name="hero_agree" id="hero_agree" value='Y' style="width: 20px; height:20px;" <? echo $agree=='Y' ? 'checked' : '' ?>><label for="hero_agree" class="input_chk_label">��</label></div>
									</p>
									<p style="color:#F68427;"> * ������ Ȱ�� �� ���� �� ����� �Ұ��մϴ�.</p>
								</div>
							</div>
						<? } ?>
					</div>
					<div class="btngroup">
						<div class="btn_r f_c">
							<a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&page=<?=$_GET['page'];?>" class="fz17 fw500 btn_submit btn_line">����ϱ�</a>
							<a href="javascript:;" onclick="javascript:return doSubmit(frm);" class="fz17 fw500 btn_submit btn_main_c">
								<?=$_GET["action"] == "update" ? "�����ϱ�":"����ϱ�"?>
							</a>
						</div>
					</div>
				</div>
				</form>
				<form action="zip_thumb.php" id="write2_file_upload" enctype="multipart/form-data" method="post" >
					<input type="file" name="thumbImage" id="write_hero_thumb" title="�̹���" style="position: absolute; left: -9999em;"/>
				</form>
				<form action="zip_thumb.php" id="write3_file_upload" enctype="multipart/form-data" method="post" >
					<input type="file" name="thumbImage" id="write_hero_product_review" title="�̹���" style="position: absolute; left: -9999em;"/>
				</form>
			</div>
		</div>
	</div>
</div>

<script src="/js/jquery.form.js"></script>
<script type="text/javascript">
var clipboard_naver = new Clipboard('.btn_clip_naver');
clipboard_naver.on('success', function(e) {
    alert("���̹���α� ������������ ���� �Ǿ����ϴ�.");
});

clipboard_naver.on('error', function(e) {
    console.log(e);
});

var clipboard_insta = new Clipboard('.btn_clip_insta');
clipboard_insta.on('success', function(e) {
    alert("�ν�Ÿ�׷� ������������ ���� �Ǿ����ϴ�.");
});

clipboard_insta.on('error', function(e) {
    console.log(e);
});

$(document).ready(function(){

    <? if($mission_row["hero_ftc"]=="1") {?>
        $("input[name='naver_url']").on("keyup",function(){
            fnAdminCheckCancel("naver");
        })

        $("input[name='insta_url']").on("keyup",function(){
            fnAdminCheckCancel("insta");
        })
    <? } ?>

    fnAdminCheckCancel = function(gubun) {
        if(gubun == "naver") {
            $("#naver_admin_check").val("N");
            $("#txt_naver_url_check").html("");
        } else if(gubun == "insta") {
            $("#insta_admin_check").val("N");
            $("#txt_insta_url_check").html("");
        }
    }

    fnAdminCheck = function(gubun) {
        if(gubun == "naver") {
            var param = "mode=naver_url_check&naver_url="+$("input[name='naver_url']").val()+"&search_keyword=<?=$search_ftc_naver?>";
            if(!$("input[name='naver_url']").val()) {
                alert("���̹� ��α׸� �Է����ּ���.");
                $("input[name='naver_url']").focus();
                return;
            }
        } else if(gubun == "insta") {
            var param = "mode=insta_url_check&insta_url="+$("input[name='insta_url']").val()+"&search_keyword=<?=$search_ftc_insta?>";
            if(!$("input[name='insta_url']").val()) {
                alert("�ν�Ÿ�׷�  URL�� �Է����ּ���.");
                $("input[name='insta_url']").focus();
                return;
            }
        }

        $.ajax({
            url:"/main/sns_url_check.php"
            ,data:param
            ,type:"POST"
            ,dataType:"html"
            ,success:function(d){
                if(d=="success") {
                    if(gubun == "naver") {
                        $("#naver_admin_check").val("Y");
                        $("#txt_naver_url_check").addClass("txt_success");
                        $("#txt_naver_url_check").html("��������ʰ� Ȯ�εǾ����ϴ�.");
                    } else if(gubun == "insta") {
                        $("#insta_admin_check").val("Y");
                        $("#txt_insta_url_check").addClass("txt_success");
                        $("#txt_insta_url_check").html("������������ Ȯ�εǾ����ϴ�.");
                    }
                } else {
                    if(gubun == "naver") {
                        var html  = "������ ��� �̹����� '������ ��ũ �����ϱ�' ��ư�� ���� ���� �� ��ũ�� ������ �� �ı� ����� �����մϴ�.";
                        html += "<br/>��� ���� ����� AK Lover �̿�鼭 ������������ ������ ��� ���� ���̵带 �������ֽñ� �ٶ��ϴ�.<br/>";
                        html += '<span class="txt_fail_copy"><?=$mission_row["hero_ftc_naver"]?> <a href="javascript:;" class="btn_copy btn_clip_naver" data-clipboard-text="http://www.aklover.co.kr/image2/banner_04_05.jpg">������ ��ũ �����ϱ�</a></span>';

                        $("#naver_admin_check").val("N");
                        $("#txt_naver_url_check").removeClass("txt_success");
                        $("#txt_naver_url_check").html(html);
                    } else if(gubun == "insta") {
                        var html  = "������ ���� ���ۼ��� �ı� ����� �Ұ��մϴ�.";
                            html += "<br/>�ݵ��, �Ʒ� ���� �״�� ������ ��ܿ� ���� ��Ź�帳�ϴ�.<br/>";
                            html += '<span class="txt_fail_copy"><?=$mission_row["hero_ftc_insta"]?> <a href="javascript:;" class="btn_copy btn_clip_insta" data-clipboard-text="<?=$mission_row['hero_ftc_insta']?>">���������� �����ϱ�</a></span>';

                        $("#insta_admin_check").val("N");
                        $("#txt_insta_url_check").removeClass("txt_success");
                        $("#txt_insta_url_check").html(html);
                    }
                }
            },error:function(e) {
                console.log(e);
            }
        })
    }

    fnUrl = function(t,type) {
        if(type == "add"){
            var html = "<div class='ui_url rel'>"+$(t).parents(".ui_url").html()+"</div>";
            var ui_urlBox = $(t).parents(".ui_urlBox");
            var idx = ui_urlBox.children("div").length+1;
            html = html.replace("+","-");
            html = html.replace(/add/gi,"minus");
            html = html.replace(/member_check1/gi,"member_check"+idx);
            var ui_url_limit_ea = 5;
            if(ui_urlBox.children("div").length < ui_url_limit_ea) {
                ui_urlBox.append(html);
            } else {
                alert("�ִ� 5������ ��� �����մϴ�.");
                return;
            }
        } else if(type == "minus"){
            var ui_urlBox = $(t).parents(".ui_url");
            ui_urlBox.remove();
        }
    }

    $("#write_hero_thumb").change(function(){
        var file = this;
        var filename = $(this).val();
        var maxSize  = 10 * 1024 * 1024    //10MB
        var fileSize = 0;
        var browser=navigator.appName;

        var tf_extension = extension_check(filename,"image");

        if(tf_extension==false){
            $(this).val("");
            return false;
        }

        // �ͽ��÷η��� ���
        if (browser=="Microsoft Internet Explorer") {
            var oas = new ActiveXObject("Scripting.FileSystemObject");
            fileSize = oas.getFile( filename ).size;
        } else {
            fileSize = file.files[0].size;
        }

        if(maxSize < fileSize) {
            alert("�̹��� �뷮�ʰ��Դϴ�.\n10MB���Ϸ� ���ε带 ������ �ּ���.");
            return false;
        }

        var options=
        {
                success: function(data){
                    if(data=='0'){
                        alert("�˼��մϴ�. �̹��� ���ε� �����Դϴ�. �ٽ� �õ����ּ���. ���� ������ �ݺ��� ��� �����Ϳ� �������ּ���.");
                        return false;
                    }else{
                        $("#present_image_area").html("<img src='"+data+"' style='margin:10px 0;'/>");
                        data = trim(data);
                        $("#hero_thumb").val(data);
                    }
                },beforeSend:function(){
                    $('.img-loading').css('display','block');
                }
                ,complete:function(){
                    $('.img-loading').css('display','none');

                },error:function(e){
                    alert("�˼��մϴ�. �̹��� ���ε� �����Դϴ�. �ٽ� �õ����ּ���. ���� ������ �ݺ��� ��� �����Ϳ� �������ּ���.");
                    return false;
                }
        };
        $('#write2_file_upload').ajaxForm(options).submit();

    });

    $("#write_hero_product_review").change(function(){ //��ǰ��
        var file = this;
        var filename = $(this).val();
        var maxSize  = 10 * 1024 * 1024    //10MB
        var fileSize = 0;
        var browser=navigator.appName;

        var tf_extension = extension_check(filename,"image");

        if(tf_extension==false){
            $(this).val("");
            return false;
        }

        // �ͽ��÷η��� ���
        if (browser=="Microsoft Internet Explorer") {
            var oas = new ActiveXObject("Scripting.FileSystemObject");
            fileSize = oas.getFile( filename ).size;
        } else {
            fileSize = file.files[0].size;
        }

        if(maxSize < fileSize) {
            alert("�̹��� �뷮�ʰ��Դϴ�.\n10MB���Ϸ� ���ε带 ������ �ּ���.");
            return false;
        }

        var options=
        {
                success: function(data){
                    if(data=='0'){
                        alert("�˼��մϴ�. �̹��� ���ε� �����Դϴ�. �ٽ� �õ����ּ���. ���� ������ �ݺ��� ��� �����Ϳ� �������ּ���.");
                        return false;
                    }else{
                        $("#product_review_image_area").html("<img src='"+data+"' style='margin:10px 0;'/>");
                        data = trim(data);
                        $("#hero_product_review").val(data);
                    }
                },beforeSend:function(){
                    $('.img-loading').css('display','block');
                }
                ,complete:function(){
                    $('.img-loading').css('display','none');

                },error:function(e){
                    alert("�˼��մϴ�. �̹��� ���ε� �����Դϴ�. �ٽ� �õ����ּ���. ���� ������ �ݺ��� ��� �����Ϳ� �������ּ���.");
                    return false;
                }
        };
        $('#write3_file_upload').ajaxForm(options).submit();

    });

});


function placeholderFunction(obj){

    var baseText = $(obj).html("");
    if(baseText=="��) http://blog.naver.com/****** \n &nbsp;&nbsp;&nbsp;https://story.kakao.com/*****"){
        baseText.html("");
    }

}

function doSubmit (theform){

    var expUrl = /^http[s]?\:\/\//i; //url üũ

    var title		=	 theform.hero_title;
    var thumb 		=	 theform.hero_thumb;
    var link 		=	 theform.hero_04;
    var hero_table 	=	 theform.hero_table;
    var hero_03 	=	 theform.hero_03;
    var hero_product_review =	 theform.hero_product_review;

    var hero_question_url_check = "<?=$mission_row["hero_question_url_check"]?>"; //URL �ʼ� �� üũ

    if(trim(title.value) == ""){
        alert("������ �Է��� �ּ���.");
        title.style.border = '1px solid red';
        title.focus();
        return false;
    }else{
        title.style.border = '';
    }

    if(thumb.value == ""){
        alert("��ǥ �̹����� ������ּ���.");
        return false;
    }

    if(hero_question_url_check == "1") {
        if(!$("input[name='naver_url']").val()) {
            alert("���̹� ��α� URL�� �Է��� �ּ���.");
            $("input[name='naver_url']").focus();
            return;
        }
    }

    if(hero_question_url_check == "3") {
        if(!$("input[name='naver_url']").val() && !$("input[name='insta_url']").val()) {
            alert("���̹� ��α�/�ν�Ÿ�׷� URL ��  �Ѱ��� URL�� �ʼ��� �Է��ϼž� �մϴ�.");
            $("input[name='naver_url']").focus();
            return false;
        }
    } else if(hero_question_url_check == "4") {
        if(!$("input[name='naver_url']").val() || !$("input[name='insta_url']").val()) {
            alert("���̹� ��α�, �ν�Ÿ�׷� URL�� �ʼ��� �Է��ϼž� �մϴ�.");
            $("input[name='naver_url']").focus();
            return false;
        }
    }

    if($("input[name='naver_url']").val()) {
        if (!expUrl.test($("input[name='naver_url']").val())) {
            alert("���̹� ��α� URL http:// �Ǵ� https:// �ʼ��� �Է��� �ʿ��մϴ�.");
            $("input[name='naver_url']").focus();
            return;
        }
    }

    <? if($mission_row["hero_ftc"] == "1") {?>
    if($("input[name='naver_admin_check']").val() != "Y") {
        alert("���̹� ��α� ������ ���� Ȯ�� �� ������ �ּ���.");
        return;
    }
    <? } ?>

    // 	if($("input:radio[name='naver_member_check']:checked").val() != "Y") {
    // 		alert("���̹� ��α� �����ŷ�����ȸ ���� �ۼ��� �������ּ���.");
    // 		return;
    // 	}
    // }

    if(hero_question_url_check == "2") {
        if(!$("input[name='insta_url']").val()) {
            alert("�ν�Ÿ�׷�  URL�� �Է��� �ּ���.");
            $("input[name='insta_url']").focus();
            return;
        }
    }

    if($("input[name='insta_url']").val()) {
        if(!expUrl.test($("input[name='insta_url']").val())) {
            alert("�ν�Ÿ�׷� URL http:// �Ǵ� https:// �ʼ��� �Է��� �ʿ��մϴ�.");
            return;
        }

        <? if($mission_row["hero_ftc"] == "1") {?>
        if($("input[name='insta_admin_check']").val() != "Y") {
            alert("�ν�Ÿ�׷� ������ ���� Ȯ�� �� ������ �ּ���.");
            return;
        }
        <? } ?>

        if($("input:radio[name='insta_member_check']:checked").val() != "Y") {
            alert("�ν�Ÿ�׷� �����ŷ�����ȸ ���� �ۼ��� �������ּ���.");
            return;
        }
    }

    <? if($_GET ['board'] == 'group_04_27') { ?>
        var movie_check_val = false;
        $("input[name='movie_url[]']").each(function(i){
            if($(this).val()) movie_check_val = true;
        })

        if(hero_question_url_check == "5") {
            if(!movie_check_val) {
                alert("��Ʃ�� URL�� �Է��� �ּ���.");
                return;
            }
        }

        var movieUrlCheck = true;
        var movieMemberCheck = true;
        $("input[name='movie_url[]']").each(function(i){
            if($(this).val()) {
                if(!expUrl.test($(this).val())) {
                    alert("��Ʃ�� URL http:// �Ǵ� https:// �ʼ��� �Է��� �ʿ��մϴ�.");
                    movieUrlCheck = false;
                    return false;
                }

                if($(this).parent(".ui_url").find("input[type=radio]:checked").val() != "Y") {
                    alert("��Ʃ�� �����ŷ�����ȸ ���� �ۼ��� �������ּ���.")
                   movieMemberCheck = false;
                   return false;
                }
            }
        })
        if(!movieUrlCheck) return;
        if(!movieMemberCheck) return;
    <? } ?>

    var etcUrlCheck = true;
    var etcMemberCheck = true;
    $("input[name='etc_url[]']").each(function(i){
        if($(this).val()) {
            if(!expUrl.test($(this).val())) {
                alert("��Ÿ URL http:// �Ǵ� https:// �ʼ��� �Է��� �ʿ��մϴ�.");
                etcUrlCheck = false;
                return false;
            }

            if($(this).parent(".ui_url").find("input[type=radio]:checked").val() != "Y") {
                alert("��Ÿ �����ŷ�����ȸ ���� �ۼ��� �������ּ���.")
               etcMemberCheck = false;
               return false;
            }
        }
    })

    if(!etcUrlCheck) return;
    if(!etcMemberCheck) return;

    var url_value_check = false; //������ URL 1���� �ݵ�� ����� �ʿ���
    $(".inputUrl").each(function(i){
        if($(this).val()) url_value_check = true;
    })

    $(".inputUrl3").each(function(i){
        if($(this).val()) url_value_check = true;
    })

    if(!url_value_check) {
        alert("������ URL�� 1�� �̻� ����� �ʿ��մϴ�.");
        return;
    }

    <? if($_GET['board'] == 'group_04_06' || $_GET['board'] == 'group_04_27' || $_GET['board'] == 'group_04_28'){ ?>
        var check 		=	 theform.hero_agree.checked;
        if(!check){
            alert("������ Ȱ�뿡 �����ؾ� �̼� ��û�� �����մϴ�");
            theform.hero_agree.focus();
            return false;
        }
    <? }?>

    //���õ� ī�װ��� hero_03���� �Ҵ�, ��ü ������ �������� ���� �״�� ����
    if(hero_table.value!='hero'){
        hero_03.value=hero_table.value;
    }
    hero_table.disabled =false;

    if(!confirm('������ ������ �ʼ��� ���� ��Ź�帳�ϴ�.')) return false;

    theform.submit();
    return false;
}
</script>