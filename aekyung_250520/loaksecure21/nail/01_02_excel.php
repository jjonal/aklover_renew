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

$sns_naver_url_check = "";
$sns_insta_url_check = "";
$sns_movie_url_check = "";
$sns_url_num = 0;
foreach($question_url_arr as $val) {
	if($val == "��α�") {
		$sns_naver_url_check = $sns_url_num;
	} else if($val == "�ν�Ÿ�׷�") {
		$sns_insta_url_check = $sns_url_num;
	} else if($val == "���� ä��") {
		$sns_movie_url_check = $sns_url_num;
	}
	$sns_url_num++;
}

header( "Content-type: application/vnd.ms-excel;charset=euc-kr" );
header( "Content-Disposition: attachment; filename=".$filename."_��÷�ڸ��_".date("Ymd",time()).".xls" );
header("Content-charset=euc-kr");
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

$search = "";

if(strcmp($_GET["kewyword"], "")){
	$search .= " AND  ".$_GET["select"]." LIKE '%".$_GET["kewyword"]."%' ";
}

//����Ʈ
$sql  = " SELECT * FROM ( ";
$sql .= " SELECT r.hero_idx ,r.hero_new_name, r.hero_hp_01, r.hero_hp_02, r.hero_hp_03 ";
$sql .= " , r.lot_01, r.delivery_point_yn, r.hero_superpass, r.hero_today, r.hero_01 ";
$sql .= " , r.hero_address_01, r.hero_address_02, r.hero_address_03, r.hero_agree ";
$sql .= " , m.hero_id, m.hero_name, m.hero_nick, m.hero_sex, m.hero_jumin, m.hero_level, m.hero_oldday, m.hero_mail ";
$sql .= " , m.hero_sns_update_date, m.hero_memo, m.hero_memo_01, m.hero_memo_01_image ";
$sql .= " , m.hero_insta_cnt, m.hero_insta_grade, m.hero_insta_image_grade ";
$sql .= " , m.hero_youtube_cnt, m.hero_youtube_grade, m.hero_youtube_view , m.hero_code";
$sql .= " , b.hero_idx as board_hero_idx , b.hero_board_three, b.akbeauty_id, b.hero_product_review ";
$sql .= " , (SELECT ifnull(sum(hero_order_point),0) FROM order_main WHERE hero_code=r.hero_code  AND hero_process = 'DE' AND mission_idx = r.hero_old_idx) AS delivery_point ";
$sql .= " FROM mission_review r ";
$sql .= " INNER JOIN member m ON r.hero_code = m.hero_code ";
$sql .= " LEFT JOIN board b ON r.hero_old_idx = b.hero_01 AND b.hero_code = r.hero_code ";
$sql .= " WHERE m.hero_use=0 AND r.hero_old_idx='".$_GET['hero_idx']."' AND r.lot_01 = '1' ";
$sql .= " ORDER BY r.hero_idx DESC ) r WHERE 1=1 ".$search;


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
	<th>ü��ܸ�</th>
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
	<th>��α� URL</th>
	<th>��α� �湮�� ��</th>
	<th>�̹��� ����Ƽ</th>
	<th>�ؽ�Ʈ ����Ƽ</th>
	<th>�ν�Ÿ URL</th>
	<th>�ν�Ÿ �ȷο� ��</th>
	<th>�̹��� ����Ƽ</th>
	<th>�ؽ�Ʈ ����Ƽ</th>
	<th>���� ä�� URL</th>
	<th>��Ʃ�� ������ ��</th>
	<th>��ȸ��</th>
	<th>������ ���</th>
	<th>�����н�</th>
	<th>��ۺ���������</th>
	<th>��ۺ�</th>
	<th>��ǰ��</th>
	<th>����ı�</th>
	<th>�г�Ƽ</th>
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
	<th>�����</th>
</tr>
<? 
$num = 1;
while($list = mysql_fetch_assoc($list_res)){
	$age = date("Y")-substr($list["hero_jumin"],0,4)+1;
	$hero_sex_txt = $list["hero_sex"] == "1" ? "��":"��";
	
	$hero_hp = $list["hero_hp_01"]."-".$list["hero_hp_02"]."-".$list["hero_hp_03"];
	$hero_superpass = "�̻��";
	if($list["hero_superpass"]=="Y") $hero_superpass = "���";
	
	$hero_board_three_txt = "-";
	if($list["hero_board_three"] == "1") $hero_board_three_txt = "����ı�";
	
	$hero_01_arr = explode(",",$list["hero_01"]); //url
	
	//�г�Ƽ
	$penalty_sql = " SELECT memo FROM member_penalty WHERE hero_use_yn = 'Y' AND hero_code = '".$list["hero_code"]."' ";
	$penalty_res = sql($penalty_sql);
	
	//��������
	if($survey_cnt > 0) {
		$mission_survey_answer_sql = " SELECT answer FROM mission_survey_answer WHERE mission_review_idx = '".$list["hero_idx"]."' ORDER BY hero_idx ASC ";
		$mission_survey_answer_res = sql($mission_survey_answer_sql);
	}
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
	<td><?=$list["hero_oldday"]?></td>
	<td><?=$list["hero_mail"]?></td>
	<td><?=$hero_hp?></td>
	<td><?=$list["hero_address_01"]?></td>
	<td><?=$list["hero_address_02"]?> <?=$list["hero_address_03"]?></td>
	<td><?=$list["hero_sns_update_date"]?></td>
	<td>
		<? if(strlen($sns_naver_url_check) > 0) { ?>
			<?=$hero_01_arr[$sns_naver_url_check]?>
		<? } else { ?>
			�̼� URL ���� ����
		<? } ?>
	</td>
	<td><?=$list["hero_memo"]?></td>
	<td><?=$list["hero_memo_01_image"]?></td>
	<td><?=$list["hero_memo_01"]?></td>
	<td>
		<? if(strlen($sns_insta_url_check) > 0) { ?>
			<?=$hero_01_arr[$sns_insta_url_check]?>
		<? } else { ?>
			�̼� URL ���� ����
		<? } ?>
	</td>
	<td><?=$list["hero_insta_cnt"]?></td>
	<td><?=$list["hero_insta_image_grade"]?></td>
	<td><?=$list["hero_insta_grade"]?></td>
	<td>
		<? if(strlen($sns_movie_url_check) > 0) { ?>
			<?=$hero_01_arr[$sns_movie_url_check]?>
		<? } else { ?>
			�̼� URL ���� ����
		<? } ?>
	</td>
	<td><?=$list["hero_youtube_cnt"]?></td>
	<td><?=$list["hero_youtube_view"]?></td>
	<td><?=$list["hero_youtube_grade"]?></td>
	<td><?=$hero_superpass?></td>
	<td><?=$list["delivery_point_yn"]=="Y" ?"����":"������"?></td>
	<td><?=$list["delivery_point"]?></td>
	<td <? if($list["hero_product_review"]) {?>width="140" style="min-height:80px; text-align:center"<?}?>>
		<? if($list["hero_product_review"]) {?>
			<img src="http://<?=$_SERVER["HTTP_HOST"]?>/<?=$list["hero_product_review"]?>" width="100" />
		<? } ?>
	</td>
	<td><?=$hero_board_three_txt?></td>
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
	<?
	if($survey_cnt > 0) {
		while($answer_list = mysql_fetch_assoc($mission_survey_answer_res)) {
	?>
		<td><?=$answer_list["answer"]?></td>	
	<? }
	}?>
	<td><?=substr($list["hero_today"],0,10)?></td>
</tr>
<? 
$num++;
} 
?>
</table>