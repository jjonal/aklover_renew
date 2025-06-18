<?
include_once "head.php";
if(!defined('_HEROBOARD_'))exit;

$view_check = false; //intro 공지사항 때문에 필요
if($_GET['view_type'] == "list") $view_check = true;

$group_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\'' . $_REQUEST ['board'] . '\';'; // desc
$out_group = @mysql_query ( $group_sql );
$right_list = @mysql_fetch_assoc ( $out_group );

if ($_SESSION ['temp_level']=='0' || empty($_SESSION ['temp_level']) ) {
	echo "<script>alert('로그인해주시기 바랍니다.');</script>";
	echo "<script>location.href='/m/login.php';</script>";
	exit;
}

if($view_check) {


$search = "";
if($_GET["gubun"]) {
	$search .= " AND gubun = '".$_GET["gubun"]."' ";
}

$total_sql  =  " SELECT count(*) cnt FROM board A ";
$total_sql .=  " LEFT JOIN member B ON A.hero_code = B.hero_code ";
$total_sql .=  " LEFT JOIN level C ON B.hero_level=C.hero_level ";
$total_sql .=  " WHERE A.hero_code='".$_SESSION['temp_code']."' AND A.hero_table='".$_REQUEST ['board']."' ".$search;
$total_sql .=  " ORDER BY A.hero_today DESC ";

sql($total_sql,"on");
$out_res = mysql_fetch_assoc($out_sql);
$total_data = $out_res["cnt"];

$list_page = 10;
$page_per_list = 5;
if (! strcmp ( $_GET ['page'], '' )) $page = '1';
else 	$page = $_GET ['page'];

$start = ($page - 1) * $list_page;
$next_path = get ( "page||hero_i_count||idx" );

$sql  =  " SELECT A.*, B.hero_nick AS nick, C.hero_img_new FROM board A ";
$sql .=  " LEFT JOIN member B ON A.hero_code = B.hero_code ";
$sql .=  " LEFT JOIN level C ON B.hero_level=C.hero_level ";
$sql .=  " WHERE A.hero_code='".$_SESSION['temp_code']."' AND A.hero_table='".$_REQUEST ['board']."' ".$search;
$sql .=  " ORDER BY A.hero_today DESC ";
$sql .=  " LIMIT ".$start.", ".$list_page;
$list_res = sql($sql);

$gubun_arr = array("1"=>"체험단 문의","2"=>"체험단 후기수정","3"=>"홈페이지 문의","4"=>"기타");
?>
<script type="text/javascript" src="<?=JS_END;?>head.js"></script>

<? include_once "cscenter.php"; ?>
<div class="btnTodayWrap">
	<div class="boardTabMenuWrap colorType">
		<a href="<?=DOMAIN_END?>m/customer.php?board=<?=$_REQUEST['board']?>&view_type=list" <?if(!$_GET["gubun"]) {?>class="on"<?}?>>전체</a>
		<a href="<?=DOMAIN_END?>m/customer.php?board=<?=$_REQUEST['board']?>&view_type=list&gubun=1" <?if($_GET["gubun"] == "1") {?>class="on"<?}?>>체험단 문의</a>
		<a href="<?=DOMAIN_END?>m/customer.php?board=<?=$_REQUEST['board']?>&view_type=list&gubun=2" <?if($_GET["gubun"] == "2") {?>class="on"<?}?>>체험단 후기수정</a>
		<a href="<?=DOMAIN_END?>m/customer.php?board=<?=$_REQUEST['board']?>&view_type=list&gubun=3" <?if($_GET["gubun"] == "3") {?>class="on"<?}?>>홈페이지 문의</a>
		<a href="<?=DOMAIN_END?>m/customer.php?board=<?=$_REQUEST['board']?>&view_type=list&gubun=4" <?if($_GET["gubun"] == "4") {?>class="on"<?}?>>기타</a>
	</div>
	<? if($right_list['hero_write'] <= $_SESSION ['temp_write']) { ?>
	<span class="gallery_btn"> 
		<a href="<?=DOMAIN_END?>m/write.php?board=<?=$_REQUEST['board']?>&action=write" class="btn btn_write">문의하기</a>
	</span>
	<? } ?>
</div>
<form name="searchForm" id="searchForm">
<input type="hidden" name="hero_idx" />
<input type="hidden" name="board" value="<?=$_GET["board"]?>" />
<input type="hidden" name="page" value="<?=$page?>" />
<input type="hidden" name="view_type" value="<?=$_GET["view_type"]?>"/>
</form>
<div id="today_list">
<? while ($board_list = @mysql_fetch_assoc($list_res)) {
	
	$img_parser_url = @parse_url ( $board_list ['hero_img_new'] );
	$img_host = $img_parser_url ['host'];
	$img_path = $img_parser_url ['path'];
	if (! strcmp ( $board_list ['hero_img_new'], '' )) {
		$view_img = IMAGE_END . 'hero.jpg';
	} else if (! strcmp ( $img_host, '' )) {
		$view_img = IMAGE_END . 'hero.jpg';
	} else if (! strcmp ( $img_host, $HTTP_SERVER_VARS ['HTTP_HOST'] )) {
		$view_img = $list ['hero_img_new'];
	} else if (! strcmp ( eregi ( 'naver', $img_host ), '1' )) {
		$view_img = IMAGE_END . 'hero.jpg';
	} else {
		$view_img = $board_list ['hero_img_new'];
	}
	
	$content = $board_list ['hero_command'];
	$content = TRIM ( str_ireplace ( '&nbsp;', '', strip_tags ( htmlspecialchars_decode ( $content ) ) ) );
	$content = str_replace ( "\r", "", $content );
	$content = str_replace ( "\n", "", $content );
	$content = str_replace ( "&#65279;", "", $content );
	$content_01 = cut ( $content, '50' );
	if (! strcmp ( $content_01, "" )) {
		$content_01 = "&nbsp;";
	}
	$title = $board_list ['hero_title'];
	$title = TRIM ( str_ireplace ( '&nbsp;', '', strip_tags ( htmlspecialchars_decode ( $title ) ) ) );
	$title = str_replace ( "\r", "", $title );
	$title = str_replace ( "\n", "", $title );
	$title = str_replace ( "&#65279;", "", $title );
	$title_01 = cut ( $title, '50' );
	if (! strcmp ( $title_01, "" )) {
		$title_01 = "&nbsp;";
	}
	if (! strcmp ( y . "-" . m . "-" . d, date ( "y-m-d", strtotime ( $board_list ['hero_today'] ) ) )) {
		$new_img_view = " <img src='" . DOMAIN_END . "image/main_new_bt.png'  width='13' alt='new' />";
	} else {
		$new_img_view = "";
	}
	
	?>
<div class="tabbtn">
	<a href="javascript:;" onClick="fnView('<?=$board_list['hero_idx'];?>')">
		<div class="title_left">
			<ul>
				<li class="tabbtn_title">
					<span class="color_<?=$board_list['gubun'];?>"><?=$gubun_arr[$board_list['gubun']]?></span>
					<div class="fz28 fw500 ellipsis_100">
						<!--!!!!!!!! [개발요청] pc 처럼 답변 대기 or 완료 개발 !!!!!!!!  -->	
						<?if(!$list['hero_10']) {?>
							[답변대기]
						<?}
						else
						{ ?>
							[답변완료]
						<?}?>
						<?=$title_01?>
					</div>
				</li>
				<li class="tabbtn_top f_cs op05">
					<?=$board_list['nick']?>
					<span class="date mu_bar"><?=date( "Y.m.d", strtotime($board_list['hero_today']));?></span>
				</li>
				
			</ul>
		</div>
	</a>
</div>	
<?
	$i ++;
}
?>
</div>

<? if($total_data ==0) {?>
<div style="text-align:center; padding:10px;">
등록된 데이터가 없습니다.
</div>
<? } ?>

<div id="page_number" class="paging">
	<?include_once "page.php"?>
</div>
	<!--컨텐츠 종료-->
<? }else {//view_check ?>	
	<? include_once "cscenter.php"; ?>
	<div class="contents">
    	<h1>고객센터</h1>
        <div class="cs">
            <p class="titleBig">
                AK LOVER 회원분들의<br />
                작은 목소리에도 귀 기울이겠습니다.
            </p>
            <div class="description">
                AK LOVER 활동 문의 및 제안사항은 <br/>1:1 문의를 통해 접수해 주시고,
                통화를 원하시는 경우, <br/><em>고객센터(080-024-1357)</em>로 전화주시면  <br/>친절하게 상담해 드리겠습니다.
            </div>
            
            <div class="csInfo">
                <dl>
                    <dt>문의전화</dt>
                    <dd>080-024-1357 <span>(수신자부담)</span></dd>
                </dl>
                <dl>
                    <dt>상담시간</dt>
                    <dd>평일 9시~18시 <span>(토, 일, 법정 공휴일 제외)</span></dd>
                </dl><br />
                <div class="btnSection">
                    <a href="/m/customer.php?board=cus_3&view_type=list" class="a_btn">1:1문의</a>
                </div>
            </div>
    	</div>
    </div>
<? } ?>
<link href="css/musign/board.css" rel="stylesheet" type="text/css">
<link href="css/musign/cscenter.css" rel="stylesheet" type="text/css">	
<?include_once "tail.php";?>
<script>
$(document).ready(function(){
	fnView = function(hero_idx) {
		$("#searchForm input[name='hero_idx']").val(hero_idx);
		$("#searchForm").attr("action","customer_view.php").submit();
	}
})
</script>