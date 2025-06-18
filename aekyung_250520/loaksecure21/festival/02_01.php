<?
if($_GET['hero_idx']){
	$hero_idx = $_GET['hero_idx'];
}
$sql = "select A.*, B.hero_name as goods_name,B.hero_serial_number,B.hero_point as goods_point,B.hero_display,C.hero_level,C.hero_hp,C.hero_mail,C.hero_address_01,C.hero_address_02,C.hero_address_03 ";
$sql .= "from order_main A inner join goods B on A.goods_idx=B.hero_idx inner join member C on A.hero_code=C.hero_code where A.hero_idx=".$hero_idx.";";
//echo $sql;
sql ( $sql );

$roll_list = @mysql_fetch_assoc ( $out_sql );
	

?>
<form name="searchForm" id="searchForm" method="GET">
<? 
unset($_GET["hero_code"]);
unset($_GET["view"]);
foreach($_GET as $key=>$val) {?>
<input type="hidden" name="<?=$key?>" value="<?=$val?>" />
<? } ?>
</form>
<p class="tit_section">제품정보</p>
<table class="t_view mgt10">
<colgroup>
	<col width="150px">
	<col width=*>
	<col width="150px">
	<col width=*>
</colgroup>
<tr>
	<th>제품코드</th>
	<td><?=$roll_list['hero_serial_number']?></td>
	<th>제품이름</th>
	<td><?=$roll_list['goods_name']?></td>
</tr>
<tr>
	<th>상품포인트</th>
	<td><?=$roll_list['goods_point']?></td>
	<th>판매여부</th>
	<td><?=$roll_list['hero_display']?></td>
</tr>
</table>

<p class="tit_section mgt30">주문자 정보</p>
<table class="t_view mgt10">
<colgroup>
	<col width="150px">
	<col width=*>
	<col width="150px">
	<col width=*>
</colgroup>
<tr>
	<th>아이디</th>
	<td><?=$roll_list['hero_id']?></td>
	<th>닉네임</th>
	<td><?=$roll_list['hero_nick']?></td>
</tr>
<tr>
	<th>이름</th>
	<td><?=$roll_list['hero_name']?></td>
	<th>레빌</th>
	<td><?=$roll_list['hero_level']?></td>
</tr>
<tr>
	<th>휴대폰번호</th>
	<td><?=$roll_list['hero_hp']?></td>
	<th>이메일</th>
	<td><?=$roll_list['hero_mail']?></td>
</tr>
</table>

<p class="tit_section mgt30">배송 정보</p>
<table class="t_view mgt10">
<colgroup>
	<col width="150px">
	<col width=*>
	<col width="150px">
	<col width=*>
</colgroup>
<tr>
	<th>주문번호</th>
	<td><?=$roll_list['hero_order_number']?></td>
	<th>우편번호</th>
	<td><?=$roll_list['hero_address_01']?></td>
</tr>
<tr>
	<th>주소</th>
	<td colspan="3"><?=$roll_list['hero_address_02']?> ><?=$roll_list['hero_address_03']?></td>
</tr>
<tr>
	<th>배송시 메모</th>
	<td colspan="3"><?=$roll_list['rcv_memo']?></td>
</tr>
<tr>
	<th>주문현황</th>
	<td>
		<?=$roll_list['hero_process']=="O"? "배송준비" : ""?>
		<?=$roll_list['hero_process']=="D"? "배송중" : ""?>
		<?=$roll_list['hero_process']=="E"? "수령완료" : ""?>
		<?=$roll_list['hero_process']=="C"? "주문취소" : ""?>
	</td>
	<th>구매일</th>
	<td><?=$roll_list['hero_regdate']?></td>
</tr>
</table>
<div class="btnGroup">
	<div class="l"><a href="javascript:;" onclick="fnList();" class="btnList">목록</a></div>
</div>
<script>
$(document).ready(function(){
	fnList = function() {
		$("#searchForm").submit();
	}	
})
</script>
