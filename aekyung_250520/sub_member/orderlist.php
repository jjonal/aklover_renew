<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
if(!strcmp($_SESSION['temp_level'], '')){
    $my_level = '0';
}else{
    $my_level = $_SESSION['temp_level'];
	$possiblePoint = possiblePoint($_SESSION["temp_id"], $_SESSION["temp_code"]);
}
if(!strcmp($my_level,'0')){msg('권한이 없습니다.','location.href="'.PATH_HOME.'?board=login"');exit;}
######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list = @mysql_fetch_assoc($out_sql);
######################################################################################################################################################

//상품취소

if($_POST["type"] == "cancel") {
	
	$sql_cancel  = " SELECT from_unixtime(startDate,'%Y%m%d') AS  startDate, from_unixtime(endDate,'%Y%m%d') AS endDate, o.goods_idx ";
	$sql_cancel .= " FROM order_main o INNER JOIN goods g ON o.goods_idx = g.hero_idx ";
	$sql_cancel .= " LEFT JOIN order_period p ON g.hero_old_idx = p.hero_old_idx ";
	$sql_cancel .= " WHERE o.hero_idx = '".$_POST["hero_idx"]."' AND o.hero_code = '".$_SESSION['temp_code']."' "; 
	$sql_cancel .= " AND o.hero_process!='".$_PROCESS_REMOVE."' AND  o.hero_process!='".$_PROCESS_CANCEL."' ";
	
	$res = sql($sql_cancel);
	$view = mysql_fetch_assoc($res);

	if($view["startDate"] <= date("Ymd") && $view["endDate"] >= date("Ymd")) { //포인트 페스티벌 기간에만 취소 가능
	 	$sql_cancel_update  = " UPDATE order_main SET hero_process = '".$_PROCESS_CANCEL."', hero_cancel_date = now()  ";
	 	$sql_cancel_update .= " WHERE hero_code = '".$_SESSION['temp_code']."' AND hero_idx = '".$_POST["hero_idx"]."' ";
	 	
	 	$res = sql($sql_cancel_update);
	 	
	 	if($res) {
	 		$sql_goods_update = " UPDATE goods SET hero_quantity = hero_quantity+1 WHERE hero_idx = '".$view["goods_idx"]."' ";
	 		$res = sql($sql_goods_update);
	 	}
	 	msg('상품 취소되었습니다.','location.href="'.PATH_HOME.'?'.get('').'"');
	 	exit;
 	} else {
 		msg('상품 취소기간이 지났습니다.','location.href="'.PATH_HOME.'?'.get('').'"');
 		exit;
 	}
}
?>
<div id="subpage" class="mypage date_ver">		
	<form name="form_next" action="<?=$_SERVER["REQUEST_URI"]?>" method="post">
	<input type="hidden" name="type" value="">
	<input type="hidden" name="hero_idx" value=""><!--  order_main 고유번호 -->
	</form>	
	<div class="sub_title">
		<div class="sub_wrap">
			<div class="f_b">
				<h1 class="fz68 main_c fw600">마이페이지</h1>			
			</div>		
			<? include_once BOARD_INC_END.'mypage_top.php';?>
		</div>
	</div>
	<div class="sub_cont">
		<div class="sub_wrap board_wrap f_sb">
			<div class="left">
				<? include_once BOARD_INC_END.'mypage_nav.php';?>
			</div>
			<div class="contents myPointArea right">
				<div class="page_tit fz32 fw600">나의 포인트</div>							
				<div class="introduceTab">
					<ul class="boardTabMenuWrap">
						<a href="/main/index.php?board=mypoint">포인트 내역</a>
						<a href="/main/index.php?board=mypoint&gubun=delivery">배송비 내역</a>
						<a href="/main/index.php?board=orderlist" class="on">포인트 페스티벌 교환내역</a>
					</ul>
				</div>
				<div class="buy_adress f_cs">
					<?
						//##################################################################################################################################################//
						$sql = "select hero_hp, hero_address_01, hero_address_02, hero_address_03 from member where hero_code='".$_SESSION['temp_code']."' and hero_id='".$_SESSION['temp_id']."'";
						$res = mysql_query($sql) or die(mysql_error());
						$rs = @mysql_fetch_assoc($res);
						$user_mobile = $rs["hero_hp"];
						$user_post = $rs["hero_address_01"];
						$user_addr = $rs["hero_address_02"];
						$user_addr_detail = $rs["hero_address_03"];
					?>
					<div class="card">
						<p class="tit fz16">받는 주소</p>
						<span class="fz15">[<?=$user_post?>] <?=$user_addr." ".$user_addr_detail?></span>
					</div>
					<div class="card">
						<p class="tit fz16">받는 전화번호</p>
						<span class="fz15"><?=$user_mobile?></span>
					</div>
					<div class="edit_my fz15">
						주소 및 전화번호는<br/>
						나의 정보 변경에서 수정 하실 수<br/> 
						있습니다.
						<a href="/main/index.php?board=infoauth"><span>나의 정보 변경 바로가기</span> <img src="/img/front/main/tab_arr_right.webp" alt="바로가기"></a>
					</div>
				</div>				
				<p class="fz15 today_point">※ 당해년도 포인트 페스티벌 교환내역만 제공됩니다.<br />
				※ ‘교환 취소’는 포인트 페스티벌 기간동안만 가능합니다.</p>
				<table class="point_table oder_table mt10">
					<colgroup>
						<col width="160px" />
						<col width="*" />
						<col width="150" />
						<col width="150" />
						<!-- <col width="160" /> -->
						<col width="160" />
					</colgroup>
					<thead>
						<tr>
							<th style="text-align:center">이미지</th>
							<th style="text-align:center">제품명</th>
							<th style="text-align:center">포인트</th>
							<th style="text-align:center">교환일</th>
							<!-- <th style="text-align:center">배송현황</th> -->
							<th style="text-align:center">교환 취소</th>
						</tr>
					</thead>
					<tbody>
						<?
						$sql  = " SELECT A.*, B.hero_name as goods_name,B.hero_image ";
						$sql .= " , from_unixtime(startDate,'%Y%m%d') AS  startDate, from_unixtime(endDate,'%Y%m%d') AS endDate ";
						$sql .= " FROM order_main A INNER JOIN goods B ON A.goods_idx=B.hero_idx ";
						$sql .= " LEFT JOIN order_period p ON B.hero_old_idx = p.hero_old_idx ";
						$sql .= " WHERE hero_code='".$_SESSION['temp_code']."' AND A.hero_process!='".$_PROCESS_REMOVE."' ";
						$sql .= " AND A.hero_process!='".$_PROCESS_CANCEL."' ";
						//$sql .= " AND date_format(A.hero_regdate,'%Y') = '".date("Y")."' ORDER BY A.hero_idx DESC ";
						// musign 25.01.09 고객사 요청에 의해 24.12.01~부터 조회되도록 변경 ->01.22 요청에 의해 24.01월부터로 수정
						$sql .= " AND A.hero_regdate BETWEEN '2024-01-01 00:00:00' AND '".date("Y")."-12-31 23:59:59' ORDER BY A.hero_idx DESC ";
						
						$res = mysql_query($sql) or die(mysql_error());
						if(mysql_num_rows($res)){
							while($rs = mysql_fetch_array($res)){
						?>

						<tr class="last">
							<td><img src="<?=str($rs['hero_image'])?>" alt="상품이미지" width="80"></td>
							<td style="text-align:left; color: #000;" class="t_tit"><div class="ellipsis_2line"><?=$rs['goods_name']?></div></td>
							<td><span class="c_brown"><?=number_format($rs['hero_order_point'])?></span> P</td>
							<!-- [개발] 구매일자에 날짜 제외 시, 분, 초 단위 빼주세요! -->
							<td><span class="c_brown"><?=$rs['hero_regdate']?></span></td>
							<!-- <td class="icon_point <? echo $_GOODS_PROCESS[$rs['hero_process']] == "배송완료" ? "done" : ( $_GOODS_PROCESS[$rs['hero_process']] == "배송중" ? "plus" :"minus")?>"><span><?=$_GOODS_PROCESS[$rs['hero_process']]?></span> </td> -->
							<td class="btn_cancel">
								<? if($rs['hero_process'] != $_PROCESS_CANCEL) {?>
									<? if($rs["startDate"] <= date("Ymd") && $rs["endDate"] >= date("Ymd")) {?>
										<a href="javascript:;" onClick="fnCancel('<?=$rs["hero_idx"]?>');" class="btn_s_cancel">취소하기</a>
									<? } else { ?>
										<a href="javascript:;" onClick="alert('포인트 페스티벌 기간에 취소 가능합니다.')" class="btn_s_cancel">취소하기</a>
									<? } ?>
								<? } else { ?>
									<p class="op05">취소완료</p>
								<? } ?>
							</td>
						</tr>
						<?
							}
						}else{
						?>
							<tr class="last">
								<td colspan="5">
								<b>※ 교환하신 내역이 없습니다. ※</b>
								</td>
							</tr>
						<?
						}
						?>
					</tbody>
				</table>            
			</div>
		</div>
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
