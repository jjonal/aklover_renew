<? include_once "head.php";?>
<?

if(!defined('_HEROBOARD_'))exit;

$view_check = false;

$search = "";

if($_GET["category"]) {
	if($_GET["category"] != "전체") {
		$search .= " AND hero_06 = '".$_GET["category"]."' ";
	}
}

$group_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\'' . $_REQUEST ['board'] . '\';'; // desc
//echo $group_sql;
$out_group = @mysql_query ($group_sql);
$right_list = @mysql_fetch_assoc ($out_group);

if(!$_GET["board"]) {
	error_historyBack("페이지 권한이 없습니다.","/m/main.php");
	exit;
}

$total_sql = "select count(*) cnt from board where hero_table='".$_GET['board']."'".$search." and hero_use=1 ";
sql($total_sql);
$out_rs = mysql_fetch_assoc($out_sql);
$total_data = $out_rs["cnt"];

$list_page = 10;
$page_per_list = 5;

if (! strcmp ( $_GET ['page'], '' )) $page = '1';
else 	$page = $_GET ['page'];

$start = ($page - 1) * $list_page;
$next_path = get ( "page||hero_i_count||idx" );

$sql  = " SELECT * FROM board WHERE hero_table='".$_GET['board']."' ".$search." AND hero_use=1 ";
$sql .= " ORDER BY hero_order ASC, hero_today DESC LIMIT ".$start.",".$list_page;
$list_res = sql($sql);
?>

<link href="css/musign/board.css" rel="stylesheet" type="text/css">
<link href="css/musign/cscenter.css" rel="stylesheet" type="text/css">
<? include_once "cscenter.php"; ?>
<div class="btnTodayWrap">
	<div class="boardTabMenuWrap faqType">
		<? foreach($_FAQ_CATEGORY as $val) {?>
			<a href="/m/faq.php?board=cus_2&category=<?=$val?>"
			<? if($val == $_GET["category"]) {?>
			class="on"
			<? } else if($val=="전체" && !$_GET["category"]){ ?>
			class="on"
			<? } ?>
			>
			<?=$val?>
			</a>
		<? }?>
	</div>
</div>
<div id="today_list">
	<ul class="faq_list">		
		<? while($list = mysql_fetch_assoc($list_res)){ ?>
		<li class="q">
			<div class="tit_wrap">
				<p class="cate fz28"><?=$list['hero_06']?></p>
				<div class="f_cs q_tit">
					<p class="tit fz28 bold"><span class="main_c bold">Q.</span> <?=$list['hero_title']?></p>                                        
				</div>         
			</div>                               
			<div class="answer">
				<div class="fz28 cont_a"><b class="bold main_c">A.</b> <?=htmlspecialchars_decode($list['hero_command']);?></div>
			</div>
		</li>
		<? } ?>
	</ul>
	<div id="page_number" class="paging">
		<? include_once "page.php"?>
	</div>
</div>
<?include_once "tail.php";?>
<script>
	$(document).ready(function(){
		$('.answer').hide();
		$('.q .tit_wrap').click(function(e) {
			if($(this).next().css('display') == "none") {
				$('.q .tit_wrap').removeClass('active');
				$(this).addClass('active');
				$('.answer').hide();
				$(this).next().show();
			}else {
				$('.q .tit_wrap').removeClass('active');
				$('.answer').hide();
			}
		});
	});
</script>