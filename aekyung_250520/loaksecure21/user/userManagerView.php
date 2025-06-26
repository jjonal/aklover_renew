<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/user.css?v=250617" type="text/css" />
<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/sub.css?v=250617" type="text/css" />

<!-- �� ����Ʈ �� -->
<ul class="viewTabList">
    <li class="on" data-idx="1"><a>ȸ�� ����</a></li>
    <li data-idx="2"><a>������ ����</a></li>
    <li data-idx="3"><a>ü��� ��û�̷�</a></li>
    <li data-idx="4"><a>Ȱ�� ����</a></li>
    <li data-idx="5"><a>�������� �̷� ����</a></li>
</ul>

<?
if(!defined('_HEROBOARD_'))exit;
// 25.06.24 �ټ����� ���� include �̱� ������ �ش� ���� �������� ���� ������ ����!

$hero_code = $_GET["hero_code"];

$member_sql  = " SELECT m.* ";
$member_sql .= " , q.hero_qs_01, q.hero_qs_02, q.hero_qs_03, q.hero_qs_04, q.hero_qs_05";
$member_sql .= " , q.hero_qs_06, q.hero_qs_07, q.hero_qs_08 ";
$member_sql .= " , q.hero_qs_18, q.hero_qs_19, q.hero_qs_20, q.hero_qs_21, q.hero_qs_22, q.hero_qs_23,mg.hero_board, mg.hero_board_group  ";
$member_sql .= " , (SELECT ifnull(sum(hero_point),0) FROM point WHERE hero_code = m.hero_code) as hero_point ";
$member_sql .= " , (SELECT ifnull(sum(hero_order_point),0) FROM order_main WHERE hero_code = m.hero_code AND hero_process!='".$_PROCESS_CANCEL."') hero_order_point ";
$member_sql .= " , (date_format(now(),'%Y') - substr(hero_jumin,1,4) + 1) as hero_age, mg.hero_board, mg.hero_board_group ";
$member_sql .= " FROM member m ";
$member_sql .= " LEFT JOIN member_question q ON m.hero_code = q.hero_code AND q.hero_pid = 4 ";
$member_sql .= " LEFT JOIN (
    SELECT mg1.* 
    FROM member_gisu mg1
    INNER JOIN (
        SELECT hero_code, MAX(gisu) AS max_gisu
        FROM member_gisu
        GROUP BY hero_code
    ) mg2 ON mg1.hero_code = mg2.hero_code AND mg1.gisu = mg2.max_gisu
)  mg ON m.hero_code = mg.hero_code ";
$member_sql .= " WHERE m.hero_use = 0 AND m.hero_code = '".$hero_code."' ";
$member_sql .= " ORDER BY m.hero_idx DESC ";

$member_res = sql($member_sql,"on");
$view = mysql_fetch_assoc($member_res);

$pw_init_sql  = " SELECT hero_today FROM member_pw_initialize WHERE hero_code = '".$hero_code."' ORDER BY hero_today DESC LIMIT 1";
$pw_init_res = sql($pw_init_sql,"on");
$pw_init = mysql_fetch_assoc($pw_init_res);


$hero_hp = explode("-",$view["hero_hp"]);
$hero_mail = explode("@",$view["hero_mail"]);

$hero_naver_blog = str_replace("https://blog.naver.com/", "", $view["hero_blog_00"]);
$hero_naver_blog = str_replace("http://blog.naver.com/", "", $hero_naver_blog);
$hero_naver_blog = str_replace("https://m.blog.naver.com/", "", $hero_naver_blog);
$hero_naver_blog = str_replace("http://m.blog.naver.com/", "", $hero_naver_blog);
$hero_naver_blog = str_replace("blog.naver.com/", "", $hero_naver_blog);

$hero_instagram = str_replace("https://www.instagram.com/", "", $view["hero_blog_04"]);
$hero_instagram = str_replace("http://www.instagram.com/", "", $hero_instagram);
$hero_instagram = str_replace("https://instagram.com/", "", $hero_instagram);
$hero_instagram = str_replace("http://instagram.com/", "", $hero_instagram);
$hero_instagram = str_replace("instagram.com/", "", $hero_instagram);


$hero_naver_influencer = str_replace("https://in.naver.com/", "", $view["hero_naver_influencer"]);

$hero_qs_18 = "";
if($view["hero_qs_18"] == "Y") {
    $hero_qs_18 = "����";
} else if($view["hero_qs_18"] == "N") {
    $hero_qs_18 = "����";
}

$hero_qs_19 = "";
if($view["hero_qs_19"] == "Y") {
    $hero_qs_19 = "����";
} else if($view["hero_qs_19"] == "N") {
    $hero_qs_19 = "����";
}

$hero_qs_20 = "";
if($view["hero_qs_20"] == "Y") {
    $hero_qs_20 = "����";
} else if($view["hero_qs_20"] == "N") {
    $hero_qs_20 = "����";
}

$hero_qs_21 = "";
if($view["hero_qs_21"] == "Y") {
    $hero_qs_21 = "����";
} else if($view["hero_qs_21"] == "N") {
    $hero_qs_21 = "����";
}

$handphone = "";
if(isset($view["hero_info_ci"]) && !empty($view["hero_info_ci"])) {
    $handphone = "�޴��� ";
}

$facebook = "";
if(isset($view["hero_facebook"]) && !empty($view["hero_facebook"])) {
    $facebook = "���̽��� ";
}

$kakaoTalk = "";
if(isset($view["hero_kakaoTalk"]) && !empty($view["hero_kakaoTalk"])) {
    $kakaoTalk = "īī���� ";
}

$naver = "";
if(isset($view["hero_naver"]) && !empty($view["hero_naver"])) {
    $naver = "���̹� ";
}

$google = "";
if(isset($view["hero_google"]) && !empty($view["hero_google"])) {
    $google = "���� ";
}
// musign ����������� �߰�
if($view["hero_level"] == "9996") {
    $hero_group = "�����̾� ��Ƽ Ŭ��";
} elseif ($view["hero_level"] == "9994"){
    $hero_group = "�����̾� ������ Ŭ��";
} else {
    $hero_group = "������ ��Ƽ & ������ Ŭ��"; // ������Ī ��������������
}

// �������� �� ����
if($view["hero_board_group"] == "b") {
    $hero_board_group = "��α�";
} elseif ($view["hero_board_group"] == "i") {
    $hero_board_group = "�ν�Ÿ";
} elseif ($view["hero_board_group"] == "s") {
    $hero_board_group = "����";
}

?>

<div class="viewTabContents">
    <ul>
        <li class="content_item active user_info" data-idx="1">
            <? include_once PATH_INC_END.'/user/userManagerView_1.php';?>
        </li>
        <li class="content_item" data-idx="2">
            <? include_once PATH_INC_END.'/user/userManagerView_2.php';?>
        </li>
        <li class="content_item" data-idx="3">
            <? include_once PATH_INC_END.'/user/userManagerView_3.php';?>
        </li>
        <li class="content_item" data-idx="4">
            <? include_once PATH_INC_END.'/user/userManagerView_4.php';?>
        </li>
        <li class="content_item" data-idx="5">
            <? include_once PATH_INC_END.'/user/userManagerView_5.php';?>
        </li>
    </ul>
</div> <!-- 25.06.24 ���� ������ �׺���̼� �̵��� �� Ȱ��ȭ�� ���� �Ӽ� �߰� -->
