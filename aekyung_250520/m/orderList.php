<?
include_once "head.php";

if($_GET['board']!="orderlist"){
	echo "<script>alert('잘 못된 접근입니다.');location.href='/m/main.php'</script>";	
}
if(!strcmp($_SESSION['temp_level'], '')){
	$my_level = '0';
}else{
	$my_level = $_SESSION['temp_level'];
	$possiblePoint = possiblePoint($_SESSION["temp_id"], $_SESSION["temp_code"]);
}
if(!strcmp($my_level,'0')){msg('권한이 없습니다.','location.href="/m/main.php"');exit;}

$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
$right_list = mysql_query($sql);
$right_list = @mysql_fetch_assoc($right_list);

$sql  =  " SELECT hero_hp, hero_address_01, hero_address_02, hero_address_03 FROM member  ";
$sql .=  " WHERE hero_code='".$_SESSION['temp_code']."' ";
$res = mysql_query($sql) or die(mysql_error());
$rs = @mysql_fetch_assoc($res);
$user_mobile = $rs["hero_hp"];
$user_post = $rs["hero_address_01"];
$user_addr = $rs["hero_address_02"];
$user_addr_detail = $rs["hero_address_03"];

if($_POST["type"] == "cancel") {

	$sql_cancel  = " SELECT from_unixtime(startDate,'%Y%m%d') AS  startDate, from_unixtime(endDate,'%Y%m%d') AS endDate, o.goods_idx ";
	$sql_cancel .= " FROM order_main o INNER JOIN goods g ON o.goods_idx = g.hero_idx ";
	$sql_cancel .= " LEFT JOIN order_period p ON g.hero_old_idx = p.hero_old_idx ";
	$sql_cancel .= " WHERE o.hero_idx = '".$_POST["hero_idx"]."' AND o.hero_code = '".$_SESSION['temp_code']."' ";
	$sql_cancel .= " AND o.hero_process!='".$_PROCESS_REMOVE."' AND  o.hero_process!='".$_PROCESS_CANCEL."' ";

	$res = sql($sql_cancel);
	$view = mysql_fetch_assoc($res);

	if($view["startDate"] <= date("Ymd") && $view["endDate"] >= date("Ymd")) { //포인트 축제 기간에만 취소 가능
		$sql_cancel_update  = " UPDATE order_main SET hero_process = '".$_PROCESS_CANCEL."', hero_cancel_date = now()  ";
		$sql_cancel_update .= " WHERE hero_code = '".$_SESSION['temp_code']."' AND hero_idx = '".$_POST["hero_idx"]."' ";
			
		$res = sql($sql_cancel_update);
			
		if($res) {
			$sql_goods_update = " UPDATE goods SET hero_quantity = hero_quantity+1 WHERE hero_idx = '".$view["goods_idx"]."' ";
			$res = sql($sql_goods_update);
		}
		msg('상품 취소되었습니다.','location.href="/m/orderList.php?board=orderlist"');
		exit;
	} else {
		msg('상품 취소기간이 지났습니다.','location.href="/m/orderList.php?board=orderlist"');
		exit;
	}
}

$sql  = " SELECT A.*, B.hero_name as goods_name,B.hero_image ";
$sql .= " , from_unixtime(startDate,'%Y%m%d') AS  startDate, from_unixtime(endDate,'%Y%m%d') AS endDate ";
$sql .= " FROM order_main A INNER JOIN goods B ON A.goods_idx=B.hero_idx ";
$sql .= " LEFT JOIN order_period p ON B.hero_old_idx = p.hero_old_idx ";
$sql .= " WHERE hero_code='".$_SESSION['temp_code']."' and A.hero_process!='".$_PROCESS_REMOVE."' ";
$sql .= " AND A.hero_process != '".$_PROCESS_CANCEL."' ";
//$sql .= " AND date_format(A.hero_regdate,'%Y') = '".date("Y")."' ORDER BY A.hero_idx DESC ";
//musign고객사 요청에따라 쿼리 수정 ->01.22 요청에 의해 24.01월부터로 수정
$sql .= " AND A.hero_regdate BETWEEN '2024-01-01 00:00:00' AND '".date("Y")."-12-31 23:59:59' ORDER BY A.hero_idx DESC ";
$res = mysql_query($sql) or die(mysql_error());
?>
<!--컨텐츠 시작-->
<link href="css/musign/cscenter.css" rel="stylesheet" type="text/css">
<link href="css/musign/board.css" rel="stylesheet" type="text/css">
<div id="subpage" class="mypage mypoint">	
	<div class="my_top off">    
		<div class="sub_title">       
			<div class="sub_wrap">  
				<div class="btn_back f_cs" onclick="goBack()"><img src="/m/img/musign/main/hd_back.webp" alt="뒤로 가기"></div>   
				<h1 class="fz36">나의 포인트</h1>       
			</div>
		</div>  
		<? include_once "mypage_top.php";?> 
	</div>    		
	<div class="boardTabMenuWrap">
		<a href="/m/mypoint.php?board=mypoint" <?=$gubun=="point" ? "class='on'":"";?>>포인트 내역</a>
		<a href="/m/mypoint.php?gubun=delivery" <?=$gubun=="delivery" ? "class='on'":"";?>>배송비 내역</a>
		<a href="/m/orderList.php?board=orderlist" class="on">포인트 페스티벌 교환내역</a>
	</div>
</div>
<form name="form_next" action="<?=$_SERVER["REQUEST_URI"]?>" method="post">
<input type="hidden" name="type" value="">
<input type="hidden" name="hero_idx" value=""><!--  order_main 고유번호 -->
</form>
<div class="sub_wrap point_order">
	<div class="buy_adress">
		<div class="card">
			<p class="tit fz26">받는 주소</p>
			<span class="fz24">[<?=$user_post?>] <?=$user_addr." ".$user_addr_detail?></span>
		</div>
		<div class="card">
			<p class="tit fz26">받는 전화번호</p>
			<span class="fz24"><?=$user_mobile?></span>
		</div>
		<div class="edit_my fz26">
			주소 및 전화번호는
			나의 정보 변경에서 수정 하실 수
			있습니다.
			<a href="/"><span>나의 정보 변경 바로가기</span><img src="/img/front/main/tab_arr_right.webp" alt="바로가기"></a>
		</div>	
		<p class="fz24 today_point">※ 당해년도 포인트 페스티벌 교환내역만 제공됩니다.<br />
		※ ‘교환취소’는 포인트 페스티벌 기간동안만 가능합니다.</p>
	</div>	
	<div class="oder_table point_table">
	<? if(mysql_num_rows($res)){ ?>
	<ul class="point_table_li">
		<? while($rs = mysql_fetch_array($res)){?>
		<li class="f_sc">			
			<div class="img"><img src="<?=str($rs['hero_image'])?>" /></div>
			<div class="cont">
				<div class="f_cs desc_top">
					<!-- <div><p class="icon_point <? echo $_GOODS_PROCESS[$rs['hero_process']] == "배송완료" ? "done" : ( $_GOODS_PROCESS[$rs['hero_process']] == "배송중" ? "plus" :"minus")?>"><?=$_GOODS_PROCESS[$rs['hero_process']]?></p></div> -->
					<div><?=number_format($rs['hero_order_point'])?>P</div>	
				</div>
				<div class="tit fz28 fw600 ellipsis_2line"><?=$rs['goods_name']?></div>
				<div class="btn_cancel">
					<? if($rs['hero_process'] != $_PROCESS_CANCEL) {?>
						<? if($rs["startDate"] <= date("Ymd") && $rs["endDate"] >= date("Ymd")) {?>
							<a href="javascript:;" onClick="fnCancel('<?=$rs["hero_idx"]?>');" class="btn_s_cancel">취소하기</a>
						<? } else { ?>
							<a href="javascript:;" onClick="alert('포인트 페스티벌 기간에 취소 가능합니다.')" class="btn_s_cancel">취소하기</a>
						<? } ?>
					<? } else { ?>
						<p class="op05">취소완료</p>
					<? } ?>
				</div>
			</div>
		</li>
		<? } ?>
	</ul>
	<? } else { ?>
	<p class="non_search">※ 교환하신 내역이 없습니다.</p>
	<? } ?>
	</div>
</div>    
<script>
function fnCancel(hero_idx){
	if(confirm("교환하신 상품을 취소하시겠습니까?")) {
		$("input[name='hero_idx']").val(hero_idx);
		$("input[name='type']").val("cancel");
		$("form[name='form_next']").submit();
	}
}
</script>
<?include_once "tail.php";?>