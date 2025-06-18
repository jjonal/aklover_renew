<?
if(!defined('_HEROBOARD_'))exit;

if(is_numeric($_GET['idx']))	$idx = $_GET['idx'];
else							error_location('잘못된 접근입니다', '/main/index.php');

$board = $_GET['board'];
$code 		 = 		$_SESSION['temp_code'];
$fulltoday 	 = 		date("Y-m-d H:i:s");
$today 		 = 		substr($fulltoday,0,10);
$today = date( "Y-m-d", time());

//일반미션, 프리미엄미션, 애경박스 생생후기
if($board=="group_04_05" || $board=="group_04_06" || $board=="group_04_07" || $board=="group_04_23" || $board=="group_04_27" || $board=="group_04_28"){
	$board = "group_04_09";
}

db("aekyung");

if(!strcmp($_SESSION['temp_level'], '')){ //비로그인시
	$_SESSION['temp_level'] = '0';
	$_SESSION['temp_write'] = '0';
	$_SESSION['temp_view'] = '0';
	$_SESSION['temp_update'] = '0';
	$_SESSION['temp_rev'] = '0';
}

$group_sql = "SELECT hero_view FROM hero_group WHERE hero_board = '".$board."'";
$group_res = mysql_query($group_sql);

if(!$group_res){
	logging_error($code, $board."VIEW2_01-".$group_sql,$fulltoday);
	error_historyBack("");
	exit;
}

$group_list = mysql_fetch_assoc($sql_res);

//권한
if($group_list['hero_view'] && $group_list['hero_view'] > $_SESSION['temp_view']){
	error_historyBack($group_list['hero_view']."레벨부터 입장이 가능한 페이지입니다.");
	exit;
}

$error="VIEW2_TOP_01";
/*
	$board_sql = "select A.*, B.hero_view as group_view, B.hero_title as group_title, B.hero_view_point as group_view_point, B.hero_right as group_right, B.hero_top_title as group_top_title ";
	$board_sql .= "from board A, hero_group B where A.hero_idx = '".$_GET['idx']."' and B.hero_board='".$board."'";
*/

$board_sql = " SELECT hero_idx, hero_title, hero_thumb, hero_today, hero_code FROM board WHERE hero_idx = '".$_GET['idx']."' ";
$sql_res = new_sql($board_sql,$error,"on");

if((string)$sql_res==$error){
	error_historyBack("");
	exit;
}

$board_list = mysql_fetch_assoc($sql_res);

if(!$board_list['hero_idx']){
	error_historyBack("잘못된 접근입니다.");
	exit;
}

$mission_url_sql = " SELECT gubun, url FROM mission_url WHERE board_hero_idx = '".$_GET['idx']."' ORDER BY field(gubun, 'naver', 'insta', 'movie', 'cafe', 'etc') ASC, hero_idx ASC ";
$mission_res = sql($mission_url_sql);

$error="VIEW2_TOP_02";
$pk_sql  = " SELECT A.hero_id, A.hero_level, A.hero_nick, A.hero_idx, B.hero_img_new FROM member as A ";
$pk_sql .= " , level as B where B.hero_level = A.hero_level and A.hero_code = '".$board_list['hero_code']."'";

$out_pk_sql = new_sql($pk_sql,$error);

if((string)$out_pk_sql==$error){
	error_historyBack("");
	exit;
}

$pk_row = mysql_fetch_assoc($out_pk_sql);

?>
<!DOCTYPE html>
<html>
<head>
<title>애경 서포터즈 AKLOVER</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="Content-Type" content="text/html; charset=<?=OLDSET;?>" />
<meta name="Keywords" content="<?=$hero_alt['1'];?>" />
<meta property="og:type" content="website" />
<meta property="og:title" content="<?=$sns_title?>" />
<meta property="og:image" content="<?=$sns_image?>" />
<meta property="og:description" content="" />
<meta property="og:site_name" content="<?=$hero_alt['0'];?>" />
<meta property="og:url" content="<?=$link?>" />
<link rel="stylesheet" type="text/css" href="/css/general2.css?version==00000004"/>
<script type="text/javascript" src="http://aklover.co.kr/js/jquery.min.js"></script>
<script type="text/javascript" src="http://aklover.co.kr/js/head.js"></script>
<script type="text/javascript" src="http://aklover.co.kr/js/common.js"></script>
<style>
ul.top_ul{margin:10px 0 0 20px !important;}
ul.top_ul li{float:none !important; text-align:left !important; margin:10px 0 0 0;}
.clear{clear:both;}
</style>
<?//ie 8인 경우
if( strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 8.0') !== FALSE) echo "<script src='http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js'></script>";
?>
</head>
<body>
<?
	$mission_sql = "SELECT A.hero_idx AS board_idx, B.hero_type, B.hero_idx, C.hero_idx as review_idx FROM board A 
					LEFT JOIN mission B ON A.hero_01 = B.hero_idx
					LEFT JOIN mission_review C ON A.hero_code = C.hero_code
					WHERE A.hero_idx = '".$_GET['idx']."' AND
						  A.hero_01 = C.hero_old_idx
					LIMIT 1";

	$mission_sql_res = mysql_query($mission_sql);
	$mission_type = mysql_fetch_array($mission_sql_res);
?>
<div id="view_link_headerWrap">
	<div id="view_link_header">
		<h1><a href="http://www.aklover.co.kr" target="_parent"><img src="/image2/etc/logo.png" alt="aklover logo" width="139" height="88" border="0"></a></h1>
		<ul class="top_ul">
			<li><?=$board_list['hero_title'] ?></li>
			<li><img src="<?=str($pk_row[hero_img_new])?>"/><?=$pk_row['hero_nick'] ?> / <?=date("Y.m.d", strtotime($board_list['hero_today'])) ?>
				<?php if($_SESSION['temp_level']>=9999 || ($_SESSION['temp_id']==$pk_row['hero_id'] && $_SESSION['temp_id'])){?>
                    	<? if($mission_type['hero_type'] == 2) { ?>
                            <a href="<?=MAIN_HOME;?>?board=group_04_05&idx=<?=$mission_type['hero_idx']?>&view=step_02_01&hero_idx=<?=$mission_type['review_idx']?>&somun=Y&board_idx=<?=$mission_type['board_idx']?>"><img src="/image2/etc/blog_link_modi.gif"></a>
                            <a href="javascript:;" onclick="confirmAction('삭제하시겠습니까?', '<?=MAIN_HOME;?>?board=group_04_05&view=step_02&idx=<?=$mission_type['hero_idx']?>&&type=drop&hero_idx=<?=$mission_type['review_idx']?>', parent)"><img src="/image2/etc/blog_link_del.gif"></a>
                        <? }else { ?>
                            <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&view=write2&action=update&page=<?=$_GET['page'];?>&hero_idx=<?=$_GET['idx']?>"><img src="/image2/etc/blog_link_modi.gif"></a>
                            <a href="javascript:;" onclick="confirmAction('삭제하시겠습니까?', '<?=MAIN_HOME;?>?board=<?=$_GET['board']?>&view=action_delete&action=delete&idx=<?=$_GET['idx'];?>&page=<?=$_GET['page'];?>', parent)"><img src="/image2/etc/blog_link_del.gif"></a>
                        <? } ?>
				<?php }?>
			</li>
		</ul>
		<div class="clear"></div>
		<div class="shareWrap">
			<div class="thumbImage"><img src="<?=$board_list["hero_thumb"]?>"</div>
			<div class="shareBtnWrap">
				<table class="tb_urlList">
					<colgroup>
						<col width="50%" />
						<col width="50%" />
					</colgroup>
					<?
					$gubun_arr = array("naver"=>"네이버 블로그","insta"=>"인스타그램","movie"=>"영상(후기)","cafe"=>"까페","etc"=>"기타");
					while($list = mysql_fetch_assoc($mission_res)) {?>
					<tr>
						<th><?=$gubun_arr[$list["gubun"]]?></th>
						<td><a href="<?=$list["url"]?>" target="_blank" class="btnLink">바로가기</a></td>
					</tr>
					<? } ?>
				</table>
			</div>
		</div>
	</div>
</div>
</body>
</html>
