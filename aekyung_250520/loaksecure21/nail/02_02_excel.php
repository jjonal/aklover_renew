<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //��������

$mission_sql = " SELECT hero_title, hero_question_url_list, hero_table  FROM mission WHERE hero_idx = ".$_GET['hero_idx'];
$mission_res = sql($mission_sql,"on");
$mission_rs = mysql_fetch_assoc($mission_res);

$category = "";
if($mission_rs["hero_table"]=="group_04_06") {
	$category = "��ƼŬ��";
} else if($mission_rs["hero_table"]=="group_04_27") {
	$category = "��Ƽ/������ Ŭ�� ������ ";
} else if($mission_rs["hero_table"]=="group_04_28") {
	$category = "������Ŭ��";
}

$filename = htmlspecialchars_decode($mission_rs["hero_title"]);

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
$sql .= " SELECT b.hero_idx ,b.hero_today, b.hero_agree ";
$sql .= " , b.hero_board_three, b.akbeauty_id, b.hero_code, b.hero_product_review ";
$sql .= " , m.hero_hp , m.hero_address_01, m.hero_address_02, m.hero_address_03 ";
$sql .= " , m.hero_id, m.hero_name, m.hero_nick, m.hero_jumin, m.hero_mail ";
$sql .= " , m.hero_sns_update_date, m.hero_memo, m.hero_memo_01, m.hero_memo_01_image ";
$sql .= " , m.hero_insta_cnt, m.hero_insta_grade, m.hero_insta_image_grade ";
$sql .= " , m.hero_youtube_cnt, m.hero_youtube_grade, m.hero_youtube_view ";
$sql .= " , m.hero_sex, m.hero_level, m.hero_oldday, m.hero_blog_00, m.hero_blog_03 ";
$sql .= " , m.hero_blog_04";
$sql .= " FROM board b ";
$sql .= " INNER JOIN member m ON b.hero_code = m.hero_code ";
$sql .= " WHERE m.hero_use=0 AND b.hero_01='".$_GET['hero_idx']."' ";
$sql .= " ORDER BY b.hero_idx DESC ) b WHERE 1=1 ".$search;

$list_res = sql($sql);

?>
<table width="100%" border="1" cellpadding="1" cellspacing="0">
<tr>
	<th>��ȣ</th>
	<th>ī�װ�</th>
	<th>ü��ܸ�</th>
	<th>�̸�</th>
	<th>���̵�</th>
	<th>�г���</th>
	<th>����</th>
	<th>����</th>
	<th>����</th>
	<th>������</th>
	<th>�̸���</th>
	<th>�޴�����ȣ</th>
	<th>�����ȣ</th>
	<th>�ּ�</th>
	<th>����Ƽ ������Ʈ ��¥</th>
	<th>ȸ������ ��α� URL</th>
	<th>��α� �湮�� ��</th>
	<th>�̹��� ����Ƽ</th>
	<th>�ؽ�Ʈ ����Ƽ</th>
	<th>ȸ������ �ν�Ÿ URL</th>
	<th>�ν�Ÿ �ȷο� ��</th>
	<th>�̹��� ����Ƽ</th>
	<th>�ؽ�Ʈ ����Ƽ</th>
	<th>ȸ������ ���� ä�� URL(��Ʃ��)</th>
	<th>��Ʃ�� ������ ��</th>
	<th>��ȸ��</th>
	<th>������ ���</th>
	<th>��ǰ��</th>
	<th>����ı�</th>
	<th>�г�Ƽ</th>
	<th>�����</th>
	<th>���̹� ��α� URL</th>
	<th>�ν�Ÿ�׷� URL</th>
	<th>����(�ı�) URL</th>
	<th>ī�� URL</th>
	<th>��Ÿ URL</th>
</tr>
<? 
$num = 1;
while($list = mysql_fetch_assoc($list_res)){
	$age = date("Y")-substr($list["hero_jumin"],0,4)+1;	
	$hero_sex_txt = $list["hero_sex"] == "1" ? "��":"��";
	$hero_board_three_txt = "-";
	if($list["hero_board_three"] == "1") $hero_board_three_txt = "����ı�";
	
	//�г�Ƽ
	$penalty_sql = " SELECT memo FROM member_penalty WHERE hero_use_yn = 'Y' AND hero_code = '".$list["hero_code"]."' ";
	$penalty_res = sql($penalty_sql);
	
	if($list["hero_idx"]) {
		$naver_url_sql = " SELECT url FROM mission_url WHERE board_hero_idx = '".$list["hero_idx"]."' AND gubun = 'naver' ";
		$naver_url_res = sql($naver_url_sql);
		
		$insta_url_sql = " SELECT url FROM mission_url WHERE board_hero_idx = '".$list["hero_idx"]."' AND gubun = 'insta' ";
		$insta_url_res = sql($insta_url_sql);
		
		$movie_url_sql = " SELECT url FROM mission_url WHERE board_hero_idx = '".$list["hero_idx"]."' AND gubun = 'movie' ";
		$movie_url_res = sql($movie_url_sql);
		
		$cafe_url_sql = " SELECT url FROM mission_url WHERE board_hero_idx = '".$list["hero_idx"]."' AND gubun = 'cafe' ";
		$cafe_url_res = sql($cafe_url_sql);
		
		$etc_url_sql = " SELECT url FROM mission_url WHERE board_hero_idx = '".$list["hero_idx"]."' AND gubun = 'etc' ";
		$etc_url_res = sql($etc_url_sql);
	}
?>
<tr>
	<td><?=$num?></td>
	<td><?=$category;?></td>
	<td><?=$mission_rs["hero_title"]?></td>
	<td><?=$list["hero_name"]?></td>
	<td><?=$list["hero_id"]?></td>
	<td><?=$list["hero_nick"]?></td>
	<td><?=$hero_sex_txt?></td>
	
	<td><?=$age?></td>
	<td><?=$list["hero_level"]?></td>
	<td><?=$list["hero_oldday"]?></td>
	<td><?=$list["hero_mail"]?></td>
	<td><?=$list["hero_hp"]?></td>
	<td><?=$list["hero_address_01"]?></td>
	<td><?=$list["hero_address_02"]?> <?=$list["hero_address_03"]?></td>
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
	<td><?=substr($list["hero_today"],0,10)?></td>
	<td>
		<? 
		  $br_num = 0;
		  while($list = mysql_fetch_assoc($naver_url_res)) {?>
		  	<? if($br_num > 0) {?><br style="mso-data-placement:same-cell;"><? } ?>
			<?=$list["url"]?>
		<? 
			$br_num++;
		  } 
		?>
	</td>
	<td>
		<? 
		$br_num = 0;
		while($list = mysql_fetch_assoc($insta_url_res)) {?>
			<? if($br_num > 0) {?><br style="mso-data-placement:same-cell;"><? } ?>
			<?=$list["url"]?>
		<? 
			$br_num++;
		  } 
		?>
	</td>
	<td>
		<? 
		$br_num = 0;
		while($list = mysql_fetch_assoc($movie_url_res)) { ?>
			<? if($br_num > 0) {?><br style="mso-data-placement:same-cell;"><? } ?>
			<?=$list["url"]?>
		<? } ?>
	</td>
	<td>
		<? 
		$br_num = 0;
		while($list = mysql_fetch_assoc($cafe_url_res)) { ?>
			<? if($br_num > 0) {?><br style="mso-data-placement:same-cell;"><? } ?>
			<?=$list["url"]?>
		<? 
			$br_num++;
		  } 
		?>
	</td>
	<td>
		<? 
		$br_num = 0;
		while($list = mysql_fetch_assoc($etc_url_res)) { ?>
			<? if($br_num > 0) {?><br style="mso-data-placement:same-cell;"><? } ?>
			<?=$list["url"]?>
		<? 
			$br_num++;
		  } 
		?>
	</td>
</tr>
<? 
$num++;
} 
?>
</table>
                        	
                        
                        
                        
                        
                        
                        