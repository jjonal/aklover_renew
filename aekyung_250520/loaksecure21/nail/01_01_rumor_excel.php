<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //��������

$mission_sql = " SELECT hero_title, hero_question_url_list  FROM mission WHERE hero_idx = ".$_GET['hero_idx'];
$mission_res = sql($mission_sql,"on");
$mission_rs = mysql_fetch_assoc($mission_res);

$filename = htmlspecialchars_decode($mission_rs["hero_title"]);
$hero_question_url_list =  $mission_rs["hero_question_url_list"];
$question_url_arr = explode("/////",$hero_question_url_list);

header( "Content-type: application/vnd.ms-excel;charset=euc-kr" );
header( "Content-Disposition: attachment; filename=".$filename."_��û�ڸ��_".date("Ymd",time()).".xls" );
header("Content-charset=euc-kr");
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

$search = "";
if(strcmp($_GET["kewyword"], "")){
	$search .= " AND  ".$_GET["select"]." LIKE '%".$_GET["kewyword"]."%' ";
}

if(strlen($_GET["lot_01"]) > 0) {
	$search .= " AND  r.lot_01 = '".$_GET["lot_01"]."' ";
}

if($_GET["delivery_point"]) {
	if($_GET["delivery_point"]=="Y") {
		$search .= " AND  o.hero_order_point > 0 ";
	} else if($_GET["delivery_point"]=="N") {
		$search .= " AND  (o.hero_order_point = 0 || o.hero_order_point is null) ";
	}
}

$sql  = " SELECT r.hero_idx, r.hero_new_name, r.hero_hp_01, r.hero_hp_02, r.hero_hp_03 ";
$sql .= " , r.lot_01, r.delivery_point_yn, r.hero_superpass, r.hero_today ";
$sql .= " , r.hero_hp_01, r.hero_hp_02, r.hero_hp_03, r.hero_address_01, r.hero_address_02 ";
$sql .= " , r.hero_address_03, r.hero_agree, r.hero_01, r.hero_code ";
$sql .= " , m.hero_id, m.hero_name, m.hero_nick, m.hero_jumin, m.hero_sex ";
$sql .= " , m.hero_level, m.hero_oldday, m.hero_mail ";
$sql .= " , m.hero_sns_update_date, m.hero_memo, m.hero_memo_01, m.hero_memo_01_image ";
$sql .= " , m.hero_blog_00, m.hero_blog_03, m.hero_blog_04 ";
$sql .= " , m.hero_insta_cnt, m.hero_insta_grade, m.hero_insta_image_grade ";
$sql .= " , m.hero_youtube_cnt, m.hero_youtube_grade, m.hero_youtube_view ";
$sql .= " , b.hero_idx as board_hero_idx ";
$sql .= " , ifnull(hero_order_point,0) as delivery_point ";
$sql .= " FROM mission_review r ";
$sql .= " INNER JOIN member m ON r.hero_code = m.hero_code ";
$sql .= " LEFT JOIN order_main o ON r.hero_code = o.hero_code AND o.hero_process = 'DE' AND o.mission_idx = '".$_GET['hero_idx']."' ";
$sql .= " LEFT JOIN board b ON b.hero_01 = r.hero_old_idx AND r.hero_code = b.hero_code ";
$sql .= " WHERE m.hero_use=0 AND r.hero_old_idx='".$_GET['hero_idx']."' ".$search;
$sql .= " ORDER BY r.hero_idx DESC ";

$list_res = sql($sql);

//��������
$survey_cnt = 0;
$mission_survey_check_sql = " SELECT count(*) cnt FROM mission_survey WHERE mission_idx = '".$_GET['hero_idx']."' ";
$mission_survey_check_res = sql($mission_survey_check_sql);
$mission_survey_check_rs = mysql_fetch_assoc($mission_survey_check_res);
$survey_cnt = $mission_survey_check_rs["cnt"];

if($survey_cnt > 0) {
	$mission_survey_sql  = " SELECT questionType, title, necessary FROM mission_survey ";
	$mission_survey_sql .= " WHERE mission_idx = '".$_GET['hero_idx']."' ORDER BY hero_idx ASC ";
	$mission_survey_res = sql($mission_survey_sql);
}

?>
<table width="100%" border="1" cellpadding="1" cellspacing="0">
<tr>
	<th>��ȣ</th>
	<th>ī�װ�</th>
	<th>����</th>
	<th>�̸�</th>
	<th>�޴��̸�</th>
	<th>���̵�</th>
	<th>�г���</th>
	<th>����</th>
	<th>����</th>
	<th>����</th>
	<th>������</th>
	<th>�̸���</th>
	<th>�޴� �޴�����ȣ</th>
	<th>�޴� �����ȣ</th>
	<th>�޴� �ּ�</th>
	<th>����Ƽ ������Ʈ ��¥</th>
	<th>ȸ������ ��α� URL</th>
	<th>��α� �湮�� ��</th>
	<th>�̹��� ����Ƽ</th>
	<th>�ؽ�Ʈ ����Ƽ</th>
	<th>ȸ������ �ν�Ÿ URL</th>
	<th>�ν�Ÿ �ȷο� ��</th>
	<th>�̹��� ����Ƽ</th>
	<th>�ؽ�Ʈ ����Ƽ</th>
	<th>ȸ������ ��Ʃ�� URL</th>
	<th>��Ʃ�� ������ ��</th>
	<th>��ȸ��</th>
	<th>������ ���</th>
	<th>�����н�</th>
	<th>��ۺ���������</th>
	<th>��ۺ�</th>
	<th>������ ����</th>
	<th>��÷����</th>
	<th>�г�Ƽ</th>
	<th>�����</th>
	<th>���̹� ��α� URL</th>
	<th>�ν�Ÿ�׷� URL</th>
	<th>��Ʃ�� URL</th>
	<th>ī�� URL</th>
	<th>��Ÿ URL</th>
	<? 
	if($survey_cnt > 0) {
	while($mission_survey_list = mysql_fetch_assoc($mission_survey_res)) {
		$questionType_arr = array("1"=>"�ְ���","2"=>"���� ������","3"=>"���� ������");
		
	?>
		<th><? if($mission_survey_list["necessary"]=="Y") {?>
			(�ʼ�)
			<? } ?>
			<?=$mission_survey_list["title"]?>/<?=$questionType_arr[$mission_survey_list["questionType"]]?>
		</th>
	<? }
	}?>
</tr>
<? 
$num = 1;
while($list = mysql_fetch_assoc($list_res)){
	$hero_sex_txt = $list["hero_sex"] == "1" ? "��":"��";
	$age = date("Y")-substr($list["hero_jumin"],0,4)+1;
	$hero_phone = $list["hero_hp_01"]."-".$list["hero_hp_02"]."-".$list["hero_hp_03"];
	$hero_superpass = "�̻��";
	if($list["hero_superpass"]=="Y") $hero_superpass = "���";
	
	$hero_01_arr = explode(",",$list["hero_01"]); //url
	
	$lot_01_txt = "�̴�÷";
	
	if($list["lot_01"] == "1") $lot_01_txt = "��÷";
	
	//�г�Ƽ
	$penalty_sql = " SELECT memo FROM member_penalty WHERE hero_use_yn = 'Y' AND hero_code = '".$list["hero_code"]."' ";
	$penalty_res = sql($penalty_sql);
	
	//��������
	if($survey_cnt > 0) {
		$mission_survey_answer_sql = " SELECT answer FROM mission_survey_answer WHERE mission_review_idx = '".$list["hero_idx"]."' ORDER BY hero_idx ASC ";
		$mission_survey_answer_res = sql($mission_survey_answer_sql);
	}
	
	//�ҹ����� �ı�(url)
	//���̹�
	$naver_sql = " SELECT url FROM mission_url WHERE board_hero_idx = '".$list["board_hero_idx"]."' AND gubun='naver' ";
	$naver_res = sql($naver_sql);
	
	//�ν�Ÿ
	$insta_sql = " SELECT url FROM mission_url WHERE board_hero_idx = '".$list["board_hero_idx"]."' AND gubun='insta' ";
	$insta_res = sql($insta_sql);
	
	//��Ʃ��
	$youtube_sql = " SELECT url FROM mission_url WHERE board_hero_idx = '".$list["board_hero_idx"]."' AND gubun='youtube' ";
	$youtube_res = sql($youtube_sql);
	
	//����
	$cafe_sql = " SELECT url FROM mission_url WHERE board_hero_idx = '".$list["board_hero_idx"]."' AND gubun='cafe' ";
	$cafe_res = sql($cafe_sql);
	
	//����
	$etc_sql = " SELECT url FROM mission_url WHERE board_hero_idx = '".$list["board_hero_idx"]."' AND gubun='etc' ";
	$etc_res = sql($etc_sql);
	
?>
<tr>
	<td><?=$num?></td>
	<td>�Ϲ�ü���</td>
	<td><?=$mission_rs["hero_title"]?></td>
	<td><?=$list["hero_name"]?></td>
	<td><?=$list["hero_new_name"]?></td>
	<td><?=$list["hero_id"]?></td>
	<td><?=$list["hero_nick"]?></td>
	<td><?=$hero_sex_txt?></td>
	<td><?=$age?></td>
	<td><?=$list["hero_level"]?></td>
	<td><?=substr($list["hero_oldday"],0,10)?></td>
	<td><?=$list["hero_mail"]?></td>
	<td><?=$hero_phone?></td>
	<td><?=$list["hero_address_01"]?></td>
	<td><?=$list["hero_address_02"]?></td>
	<td><?=$list["hero_sns_update_date"]?></td>
	<td><?=$list["hero_blog_00"]?></td>
	<td><?=$list["hero_memo"]?></td>
	<td><?=$list["hero_memo_01_image"]?></td>
	<td><?=$list["hero_memo_01"]?></td>
	<td><?=$list["hero_blog_04"]?></td>
	<td><?=$list["hero_insta_cnt"]?></td>
	<td><?=$list["hero_insta_image_grade"]?></td>
	<td><?=$list["hero_insta_grade"]?></td>
	<td><?=$list["hero_blog_03"]?></td>
	<td><?=$list["hero_youtube_cnt"]?></td>
	<td><?=$list["hero_youtube_view"]?></td>
	<td><?=$list["hero_youtube_grade"]?></td>
	<td><?=$hero_superpass?></td>
	<td><?=$list["delivery_point_yn"]?></td>
	<td><?=$list["delivery_point"]?></td>
	<td><?=$list["hero_agree"]?></td>
	<td><?=$lot_01_txt?></td>
	<td>
		<? 
			$k = 0;
			while($penalty_list = mysql_fetch_assoc($penalty_res)) {
				$k++;
			?>
			<? if($k > 1) {?><br style="mso-data-placement:same-cell;"><? } ?>
			<?=$k?>) <?=$penalty_list["memo"]?>
		<? } ?>
	</td>
	<td><?=substr($list["hero_today"],0,10)?></td>
	<td>
		<? 
		$br_num = 0;
		while($naver_list = mysql_fetch_assoc($naver_res)) {
		?>
			<? if($br_num > 0) {?><br style="mso-data-placement:same-cell;"><? } ?>
			<?=$naver_list["url"]?>
		<? 
			$br_num++;
		  } 
		?>
	</td>
	<td>
		<? 
		$br_num = 0;
		while($insta_list = mysql_fetch_assoc($insta_res)) {
		?>
			<? if($br_num > 0) {?><br style="mso-data-placement:same-cell;"><? } ?>
			<?=$insta_list["url"]?>
		<? 
			$br_num++;
		  } 
		?>	
	</td>
	<td>
		<? 
		$br_num = 0;
		while($youtube_list = mysql_fetch_assoc($youtube_res)) {
		?>
			<? if($br_num > 0) {?><br style="mso-data-placement:same-cell;"><? } ?>
			<?=$youtube_list["url"]?>
		<? 
			$br_num++;
		  } 
		?>
	</td>
	<td>
		<? 
		$br_num = 0;
		while($cafe_list = mysql_fetch_assoc($cafe_res)) {
		?>
			<? if($br_num > 0) {?><br style="mso-data-placement:same-cell;"><? } ?>
			<?=$cafe_list["url"]?>
		<? 
			$br_num++;
		  } 
		?>		
	</td>
	<td>
		<? 
		$br_num = 0;
		while($etc_list = mysql_fetch_assoc($etc_res)) {
		?>
			<? if($br_num > 0) {?><br style="mso-data-placement:same-cell;"><? } ?>
			<?=$etc_list["url"]?>
		<? 
			$br_num++;
		  } 
		?>
	</td>
	<?
	if($survey_cnt > 0) {
		while($answer_list = mysql_fetch_assoc($mission_survey_answer_res)) {
	?>
		<td><?=$answer_list["answer"]?></td>	
	<? }
	}?>
</tr>
<? 
$num++;
} 
?>
</table>
                        	
                        
                        
                        
                        
                        