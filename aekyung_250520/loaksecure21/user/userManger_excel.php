<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //��������

header( "Content-type: application/vnd.ms-excel;charset=euc-kr" );
header( "Content-Disposition: attachment; filename=ȸ������_".date("Ymd",time()).".xls" );
header("Content-charset=euc-kr");
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

$search = "";

//if($_GET["hero_point_start"]) {
//	$search .= " AND hero_point >= '".$_GET["hero_point_start"]."' ";
//}
//
//if($_GET["hero_point_end"]) {
//	$search .= " AND hero_point <= '".$_GET["hero_point_start"]."' ";
//}
//
//if($_GET["hero_blog"]) {
//	if($_GET["hero_blog"] == "1") {
//		$search .= " AND  hero_blog_00 is not null  AND  hero_blog_00 != '' ";
//	} else if($_GET["hero_blog"] == "2") {
//		$search .= " AND  hero_blog_04 is not null  AND  hero_blog_04 != '' ";
//	} else if($_GET["hero_blog"] == "3") {
//		$search .= " AND  ((hero_blog_00 is not null  AND  hero_blog_00 != '') or (hero_blog_04 is not null  AND  hero_blog_04 != ''))  ";
//	} else if($_GET["hero_blog"] == "4") {
//		$search .= " AND  hero_blog_00 is not null  AND  hero_blog_00 != '' AND hero_blog_04 is not null  AND  hero_blog_04 != '' ";
//	} else if($_GET["hero_blog"] == "5") {
//		$search .= " AND  (hero_blog_03 is not null  AND  hero_blog_03 != '' AND hero_blog_06 is not null  AND  hero_blog_06 != ''  AND hero_blog_07 is not null  AND  hero_blog_07 != '' AND hero_blog_08 is not null  AND  hero_blog_08 != '' ) ";
//	} else if($_GET["hero_blog"] == "6") {
//	    $search .= " AND  hero_naver_influencer is not null  AND  hero_naver_influencer != '' ";
//	}
//}
//
//if($_GET["hero_memo_01_image"]) {
//	$search .= " AND hero_memo_01_image = '".$_GET["hero_memo_01_image"]."' ";
//}
//
//if($_GET["hero_memo_01"]) {
//	$search .= " AND hero_memo_01 = '".$_GET["hero_memo_01"]."' ";
//}
//
//if($_GET["hero_insta_image_grade"]) {
//	$search .= " AND hero_insta_image_grade = '".$_GET["hero_insta_image_grade"]."' ";
//}
//
//if($_GET["hero_insta_grade"]) {
//	$search .= " AND hero_insta_grade = '".$_GET["hero_insta_grade"]."' ";
//}
//
//if($_GET["hero_youtube_grade"]) {
//	$search .= " AND hero_youtube_grade = '".$_GET["hero_youtube_grade"]."' ";
//}
//
//if($_GET["hero_jumin"]) {
//	$search .= " AND hero_jumin = '".$_GET["hero_jumin"]."' ";
//}
//
//if($_GET["hero_level_start"]) {
//	$search .= " AND hero_level >= '".$_GET["hero_level_start"]."' ";
//}
//
//if($_GET["hero_level_end"]) {
//	$search .= " AND hero_level <= '".$_GET["hero_level_end"]."' ";
//}
//
//if($_GET["hero_oldday_start"]) {
//	$search .= " AND date_format(hero_oldday,'%Y-%m-%d') >= '".$_GET["hero_oldday_start"]."' ";
//}
//
//if($_GET["hero_oldday_end"]) {
//	$search .= " AND date_format(hero_oldday,'%Y-%m-%d') <= '".$_GET["hero_oldday_end"]."' ";
//}
//
//if($_GET["hero_age_start"]) {
//	$birthYear = date("Y")-$_GET["hero_age_start"]+1;
//	$search .= " AND substr(hero_jumin,1,4) <= '".$birthYear."' ";
//}
//
//if($_GET["hero_age_end"]) {
//	$birthYear = date("Y")-$_GET["hero_age_end"]+1;
//	$search .= " AND substr(hero_jumin,1,4) >= '".$birthYear."' ";
//}
//
//
//if($_GET["kewyword"]) {
//	$search .= " AND ".$_GET["select"]." like '%".$_GET["kewyword"]."%' ";
//}

// 25.06.24 Ű���� ���� ���� musign
if($_GET["hero_chk_phone"]) {
    if($_GET["hero_chk_phone"] == "1") {
        $search .= " AND hero_chk_phone = '1' ";
    } else {
        $search .= " AND hero_chk_phone != '1' ";
    }
}

if(strlen($_GET["hero_sex"]) > 0) {
	$search .= " AND hero_sex = '".$_GET["hero_sex"]."' ";
}

if($_GET["hero_chk_email"]) {
    if($_GET["hero_chk_email"] == "1") {
        $search .= " AND hero_chk_email = '1' ";
    } else {
        $search .= " AND hero_chk_email != '1' ";
    }
}

// ������
if($_GET["hero_board_group"]) {
    if($_GET["hero_board_group"] == "b") { // ��α�
        $search .= " AND mg.hero_board_group = 'b' ";
    } else if($_GET["hero_board_group"] == "i") { // �ν�Ÿ
        $search .= " AND mg.hero_board_group = 'i' ";
    } else if($_GET["hero_board_group"] == "s") { // ����
        $search .= " AND mg.hero_board_group = 's' ";
    }
}

// �������� ����
if( !empty($_GET["hero_level"]) && is_array($_GET["hero_level"]) ) {

    $hero_level_conditions = array(); // array() ���

    foreach($_GET["hero_level"] as $level_type) {
        switch($level_type) {
            case "9996": // ������ ��Ƽ & ������ Ŭ��
                $hero_level_conditions[] = "(m.hero_level = '9996')";
                break;
            case "9994": // �����̾� ��Ƽ Ŭ��
                $hero_level_conditions[] = "(m.hero_level = '9994')";
                break;
            case "etc": // �����̾� ������ Ŭ��
                $hero_level_conditions[] = "((m.hero_level != '') or (m.hero_level != ''))";
                break;
        }
    }

    if(!empty($hero_level_conditions)) {
        $search .= " AND (" . implode(" OR ", $hero_level_conditions) . ")";
    }
}

if($_GET["startDate"]) {
    $search .= " AND date_format(m.hero_oldday,'%Y-%m-%d') >= '".$_GET["startDate"]."' ";
}

if($_GET["edate"]) {
    $search .= " AND date_format(m.hero_oldday,'%Y-%m-%d') <= '".$_GET["edate"]."' ";
}


// ���ɴ� ����������� ��� (�� ���� ����)
if($_GET["startAge"]) {
    $search .= " AND (
        YEAR(CURRENT_DATE) - SUBSTR(m.hero_jumin,1,4)
        - (DATE_FORMAT(CURRENT_DATE, '%m%d') < CONCAT(SUBSTR(m.hero_jumin,5,2), SUBSTR(m.hero_jumin,7,2)))
    ) >= " . $_GET["startAge"];
}

if($_GET["endAge"]) {
    $search .= " AND (
        YEAR(CURRENT_DATE) - SUBSTR(m.hero_jumin,1,4)
        - (DATE_FORMAT(CURRENT_DATE, '%m%d') < CONCAT(SUBSTR(m.hero_jumin,5,2), SUBSTR(m.hero_jumin,7,2)))
    ) <= " . $_GET["endAge"];
}

// sns ����

if(!empty($_GET["hero_blog"]) && is_array($_GET["hero_blog"])) {

    $hero_blog_conditions = array(); // array() ���

    foreach($_GET["hero_blog"] as $blog_type) {
        switch($blog_type) {
            case "1": // ��α�
                $hero_blog_conditions[] = "(m.hero_blog_00 is not null AND hero_blog_00 != '')";
                break;
            case "2": // �ν�Ÿ
                $hero_blog_conditions[] = "(m.hero_blog_04 is not null AND hero_blog_04 != '')";
                break;
            case "3": // ��α� or �ν�Ÿ
                $hero_blog_conditions[] = "((m.hero_blog_00 is not null AND m.hero_blog_00 != '') or (m.hero_blog_04 is not null AND m.hero_blog_04 != ''))";
                break;
            case "4": // ��α� and �ν�Ÿ
                $hero_blog_conditions[] = "(m.hero_blog_00 is not null AND m.hero_blog_00 != '' AND m.hero_blog_04 is not null AND m.hero_blog_04 != '')";
                break;
            case "5": // ���� ä��
                $hero_blog_conditions[] = "((m.hero_blog_03 is not null AND m.hero_blog_03 != '') OR (m.hero_blog_06 is not null AND m.hero_blog_06 != '') OR (m.hero_blog_07 is not null AND m.hero_blog_07 != '') OR (m.hero_blog_08 is not null AND m.hero_blog_08 != ''))";
                break;
            case "6": // ���÷��
                $hero_blog_conditions[] = "(m.hero_naver_influencer is not null AND m.hero_naver_influencer != '')";
                break;
            case "7": // ����
                $hero_blog_conditions[] = "(m.hero_blog_07 is not null AND hero_blog_07 != '')";
                break;
            case "8": // ��Ÿ
                $hero_blog_conditions[] = "(m.hero_blog_08 is not null AND hero_blog_08 != '')";
                break;
        }
    }

    if(!empty($hero_blog_conditions)) {
        $search .= " AND (" . implode(" OR ", $hero_blog_conditions) . ")";
    }
}

if($_GET["kewyword"] && $_GET["select"] != 'none') { //
    if($_GET["select"] == 'hero_nick') { // �г��� �˻�
        $_GET["select"] = 'm.'.$_GET["select"];
    } elseif ($_GET["select"] == 'hero_name') { // �̸�
        $_GET["select"] = 'm.'.$_GET["select"];
    } elseif ($_GET["select"] == 'hero_id') { // ���̵�
        $_GET["select"] = 'm.'.$_GET["select"];
    } elseif ($_GET["select"] == 'hero_hp') { // ��ȭ��ȣ
        $_GET["select"] = 'm.hero_hp';
        // �˻���� ������ ���� �� ������
        $phone = preg_replace("/[^0-9]/", "", $_GET["kewyword"]); // ���ڸ� ����
        $_GET["kewyword"] = substr($phone, 0, 3) . '-' . substr($phone, 3, 4) . '-' . substr($phone, 7);
    }
    $search .= " AND ".$_GET["select"]." like '%".$_GET["kewyword"]."%' ";
}

$sql = " SELECT *, (total_point - use_point) AS hero_point FROM ";
$sql .= " (SELECT m.hero_idx, m.hero_code, hero_id, hero_nick, hero_name, hero_jumin, hero_sex ";
$sql .= " , hero_oldday, hero_hp, hero_mail, hero_address_01, hero_address_02";
$sql .= " , hero_address_03, hero_chk_phone, hero_chk_email, area, area_etc_text ";
$sql .= " , m.hero_today, hero_level, hero_point, hero_user_type, hero_user ";
$sql .= " , hero_blog_00, hero_blog_04, hero_blog_03, hero_blog_05, hero_blog_06, hero_blog_07, hero_blog_08 ";
$sql .= " , hero_memo, hero_memo_01_image, hero_memo_01 , hero_insta_cnt, hero_insta_image_grade ";
$sql .= " , hero_insta_grade, hero_youtube_cnt, hero_youtube_grade, hero_youtube_view, hero_kakaoTalk, hero_naver, hero_google, hero_sns_update_date";
$sql .= " , hero_naver_influencer, hero_naver_influencer_name, hero_naver_influencer_category ";
$sql .= " , hero_qs_01, hero_qs_02, hero_qs_03, hero_qs_04, hero_qs_05 ";
$sql .= " , hero_qs_06, hero_qs_07, hero_qs_08 ";
$sql .= " , (SELECT ifnull(sum(hero_point),0) FROM point WHERE hero_code = m.hero_code) AS total_point ";
$sql .= " , (SELECT ifnull(sum(hero_order_point),0) FROM order_main WHERE hero_process != 'C' AND hero_code = m.hero_code) AS use_point ";
$sql .= " FROM member m LEFT JOIN member_question q ON m.hero_code = q.hero_code AND q.hero_pid = 4 ";
$sql .= " WHERE hero_use = 0 ".$search;
$sql .= " ) m ORDER BY m.hero_idx DESC  ";

$list_res = sql($sql,"on");

?>

<table width="100%" border="1" cellpadding="1" cellspacing="0">
<tr>
	<th>������ȣ</th>
    <?php if(isset($_GET['chk_id']) && $_GET['chk_id'] == 'on'): ?>
        <th>���̵�</th>
    <?php endif; ?>
    <?php if(isset($_GET['chk_name']) && $_GET['chk_name'] == 'on'): ?>
        <th>�̸�</th>
    <?php endif; ?>
    <?php if(isset($_GET['chk_nick']) && $_GET['chk_nick'] == 'on'): ?>
        <th>�г���</th>
    <?php endif; ?>
    <?php if(isset($_GET['chk_age']) && $_GET['chk_age'] == 'on'): ?>
        <th>����</th>
    <?php endif; ?>
    <?php if(isset($_GET['chk_sex']) && $_GET['chk_sex'] == 'on'): ?>
        <th>����</th>
    <?php endif; ?>
	<th>�������</th>
	<th>������</th>
	<th>�޴�����ȣ</th>
	<th>�̸���</th>
	<th>�����ȣ</th>
	<th>�ּ�</th>
	<th>���԰��</th>
	<th>���� ���ſ���</th>
	<th>�̸��� ���ſ���</th>
	<th>�ֱ� �α��� �ð�</th>
	<th>����</th>
	<th>���� ����Ʈ</th>
	<th>����Ƽ ������Ʈ</th>
	<th>���̹� ��α�</th>
	<th>�湮�� ��</th>
	<th>�̹��� ����Ƽ</th>
	<th>�ؽ�Ʈ ����Ƽ</th>
	<th>�ν�Ÿ�׷�</th>
	<th>�ȷο� ��</th>
	<th>�̹��� ����Ƽ</th>
	<th>�ؽ�Ʈ ����Ƽ</th>
	<th>��Ʃ�� URL</th>
	<th>������ ��</th>
	<th>��Ʃ�� ��ȸ��</th>
	<th>������ ���</th>
	<th>��Ÿ URL</th>
	<th>���÷��� Ȱ�� ī�װ�</th>
	<th>���÷�� ��</th>
	<th>���÷�� Ȩ URL</th>
	<th>���̹� TV</th>
	<th>ƽ��</th>
	<th>��Ÿ(����)</th>
	<th>���� SNS URL ��/��</th>
	<th>��ȥ ����</th>
	<th>�ڳ� ����</th>
	<th>�ڳ� ��/�¾ �⵵</th>
	<th>AKLOVER�� ������ ����</th>
	<th>AK LOVER�� Ȱ���ϴ� ��������/ü��� ī�� �Ǵ� Ȩ������</th>
	<th>�г�Ƽ</th>
	<th>���� ���� ���̹�</th>
	<th>���� ���� īī��</th>
	<th>���� ���� ����</th>
	<th>��õ���</th>
	<th>��õ��</th>
</tr>
<?
$list_res = sql($sql,"on");
if (!$list_res) {
    die('SQL ���� �߻�: ' . mysql_error());
}

while($list = mysql_fetch_assoc($list_res)){
	$age = (date("Y")-substr($list["hero_jumin"],0,4))+1;
	$hero_sex_txt = "";
	if($list["hero_sex"] == 0) {
		$hero_sex_txt = "��";
	} else if($list["hero_sex"] == 1) {
		$hero_sex_txt = "��";
	}
	
	$hero_chk_phone_txt = $list["hero_chk_phone"] == "1" ? "����":"�̼���";
	$hero_chk_email_txt = $list["hero_chk_email"] == "1" ? "����":"�̼���";
	
	$hero_qs_01_txt = $list["hero_qs_01"] == "Y" ? "����":"����";
	$hero_qs_02_txt = $list["hero_qs_02"] == "Y" ? "��ȥ":"��ȥ";
	$hero_qs_03_txt = $list["hero_qs_03"] == "Y" ? "����":"����";
	$hero_qs_07_txt = $list["hero_qs_07"] == "Y" ? "����":"����";
	
	$hero_kakaoTalk_txt = $list["hero_kakaoTalk"] ? "����":"";
	$hero_naver_txt = $list["hero_naver"] ? "����":"";
	$hero_google_txt = $list["hero_google"] ? "����":"";
	
	$hero_user_type_txt = "";
	if($list["hero_user_type"] == "hero_id") {
		$hero_user_type_txt = "���̵�";
	} else if($list["hero_user_type"] == "hero_nick") {
		$hero_user_type_txt = "�г���";
	}
	
	
	$penalty_sql = "SELECT memo FROM member_penalty WHERE hero_use_yn = 'Y' AND hero_code = '".$list["hero_code"]."' ";
	$penalty_res = sql($penalty_sql);
?>
<tr>
	<td><?=$list["hero_code"]?></td>
    <?php if(isset($_GET['chk_id']) && $_GET['chk_id'] == 'on'): ?>
        <td><?=$list["hero_id"]?></td>
    <?php endif; ?>
    <?php if(isset($_GET['chk_name']) && $_GET['chk_name'] == 'on'): ?>
        <td><?=$list["hero_name"]?></td>
    <?php endif; ?>
    <?php if(isset($_GET['chk_nick']) && $_GET['chk_nick'] == 'on'): ?>
        <td><?=$list["hero_nick"]?></td>
    <?php endif; ?>
    <?php if(isset($_GET['chk_age']) && $_GET['chk_age'] == 'on'): ?>
        <td><?=(date("Y")-substr($list["hero_jumin"],0,4))+1?></td>
    <?php endif; ?>
    <?php if(isset($_GET['chk_sex']) && $_GET['chk_sex'] == 'on'): ?>
        <td><?=$list["hero_sex"] == 0 ? "��" : "��"?></td>
    <?php endif; ?>
	<td><?=$list["hero_jumin"]?></td>
	<td><?=$list["hero_oldday"]?></td>
	<td><?=$list["hero_hp"]?></td>
	<td><?=$list["hero_mail"]?></td>
	<td><?=$list["hero_address_01"]?></td>
	<td><?=$list["hero_address_02"]?> <?=$list["hero_address_03"]?></td>
	<td><?=$list["area"]?>
		<?if($list["area"]=="��Ÿ") {?>
		(<?=$list["area_etc_text"]?>)
		<? } ?>
	</td>
	<td><?=$hero_chk_phone_txt?></td>
	<td><?=$hero_chk_email_txt?></td>
	<td><?=$list["hero_today"]?></td>
	<td><?=$list["hero_level"]?></td>
	<td><?=$list["hero_point"]?></td>
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
	<td><?=$list["hero_blog_05"]?></td>
	
	<td><?=$list["hero_naver_influencer_category"]?></td>
	<td><?=$list["hero_naver_influencer_name"]?></td>
	<td><?=$list["hero_naver_influencer"]?></td>
	
	<td><?=$list["hero_blog_06"]?></td>
	<td><?=$list["hero_blog_07"]?></td>
	<td><?=$list["hero_blog_08"]?></td>
	<td><?=$hero_qs_01_txt?></td>
	<td><?=$hero_qs_02_txt?></td>
	<td><?=$hero_qs_03_txt?></td>
	<td>
		<? if($list["hero_qs_04"]) {
			$hero_qs_05_arr = explode(",",$list["hero_qs_05"]);
			$hero_qs_05_txt = "";
			foreach($hero_qs_05_arr as $val) {
				if($hero_qs_05_txt) $hero_qs_05_txt .= ", ";
				$hero_qs_05_txt .= $val;
			}
			
		?>
			<?=$list["hero_qs_04"]?>��/<?=$hero_qs_05_txt?>
		<? } ?>
	</td>
	<td><?=$list["hero_qs_06"]?></td>
	<td><?=$hero_qs_07_txt?>
		<? if($list["hero_qs_07"] == "Y") {?>
			(<?=$list["hero_qs_08"]?>)
		<? } ?>
	</td>
	<td>
		<? 
		  $penalty_num = 0; 
		  while($penalty_list = mysql_fetch_assoc($penalty_res)) {
		  	$penalty_num++;
		?>
			<?=$penalty_num?>) <?=$penalty_list["memo"]?><br style="mso-data-placement:same-cell;">
		<? } ?>
	</td>
	<td><?=$hero_naver_txt?></td>
	<td><?=$hero_kakaoTalk_txt?></td>
	<td><?=$hero_google_txt?></td>
	<td><?=$hero_user_type_txt?></td>
	<td><?=$list["hero_user"]?></td>
</tr>
<? } ?>
</table>