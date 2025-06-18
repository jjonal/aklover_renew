<?php 
if(!defined('_HEROBOARD_'))exit;

include_once '../combined/admin_user_manager.php';

if(!$_GET['page'])		$page = '1';
else						$page = $_GET['page'];
?>
<link rel="stylesheet" type="text/css" href="<?=CSS_END;?>general.css"/>
<link rel="stylesheet" type="text/css" href="<?=PATH_END?>css/admin_login.css" />
<link rel="stylesheet" href="<?=PATH_END?>css/admin.css" type="text/css" />
<script type="text/javascript" src="<?=JS_END;?>jquery.min.js"></script>
<script type="text/javascript" src="<?=JS_END;?>head.js"></script>
<link type='text/css' href='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.css' rel='stylesheet' />
<script type="text/javascript" src="<?=DOMAIN_END?>cal/jquery.min.js"></script>
<script type='text/javascript' src='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.min.js'></script> 
<script>
$(function() {      // window.onload 대신 쓰는 스크립트
    dateclick2();
});
function dateclick2(){
    var dates = $("#sdate1, #edate1").datepicker({
        monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
        defaultDate: null,
        showMonthAfterYear:true,
        dateFormat: 'yy-mm-dd',
        onSelect: function( selectedDate ) {
            var option = this.id == "sdate1" ? "minDate" : "maxDate",
            instance = $( this ).data( "datepicker" ),
            date = $.datepicker.parseDate(
                instance.settings.dateFormat ||
	            $.datepicker._defaults.dateFormat,
	            selectedDate, instance.settings );
	        dates.not( this ).datepicker( "option", option, date );
		}
	});
};
</script>
<div id="searchPointArea">
<form action="<?=$_SERVER['PHP_SELF']."?"."board=".$_GET['board']."&idx=".$_GET['idx']?>" name="frm"  id="frm">
	<input type="hidden" name="board"  value="<?=$_GET['board']?>"/> 
	<input type="hidden" name="idx"  value="<?=$_GET['idx']?>"/>
	
	<table>
		<colgroup>
			<col width="100px" />
			<col width="600px"/>
			<col width="*" />
		</colgroup>
			<tr>
				<th>기간</th>
				<td colspan="2">
                		<input type="text"  id="sdate1" name="hero_today_start"  value="<?=$_GET['hero_today_start']?>" style="text-align: center"  readonly/> ~ 
                		<input type="text"  id="edate1" name="hero_today_end"  value="<?=$_GET['hero_today_end']?>" style="text-align: center"  readonly/>
                </td>
			</tr>
            <tr>
            	<th>차감/반환</th>                
                <td colspan="2"><input type="radio" name="pointType"  id="pointAll" value="All" style="width:26px;" <?if($_GET['pointType']=="" || $_GET['pointType']=="All" ) echo checked;?>/><label for="pointAll">전체</label> 
                    <input type="radio" name="pointType"  id="pointPlus" value="Plus" style="width:26px;" <?if($_GET['pointType']=="Plus" ) echo checked;?>/><label for="pointPlus">차감</label> 
                    <input type="radio" name="pointType"  id="pointMinus" value="Minus" style="width:26px;" <?if($_GET['pointType']=="Minus" ) echo checked;?>/><label for="pointMinus">반환</label>
                </td>
            </tr>
			<tr>
				
				<th>직접검색</th>
				<td>
					<select name="selectValue">
						<option value="hero_id" <? echo $_GET['selectValue'] == "hero_id" ? "selected" : ""?>>아이디</option>
						<option value="hero_name" <? echo $_GET['selectValue'] == "hero_name" ? "selected" : ""?>>성명</option>
						<option value="hero_nick" <? echo $_GET['selectValue'] == "hero_nick" ? "selected" : ""?>>닉네임</option>
					</select>
					&nbsp;
					<input type="text" name="textValue" id="textValue" value="<?=$_GET['textValue']?>"/>
					<script>
					$(function() { 
						$('#textValue').keyup(function(e) {
						    if (e.keyCode == 13) $("#frm").submit();       
						});
					});
					</script>
				</td>
				<td align="right" ><div onclick="$('#frm').submit();" style="width:150px; cursor:pointer;height: 25px;padding: 10px 7px 2px 7px;background: #376EA6;color:white;text-align:center;font-size:13px;">검 색</div></td>
			</tr>
	</table>
</form>
</div>
<?php 
// 검색쿼리 설정
$hero_today_start = $_GET['hero_today_start'];
$hero_today_end = $_GET['hero_today_end'];
$selectValue = $_GET['selectValue'];
$textValue = $_GET['textValue'];

$pointType = $_GET['pointType'];
$pointLimit = $_GET['pointLimit'];

$search = "";
$next_path = "";

$next_path="board=".$_GET['board']."&idx=".$_GET['idx'];
if($hero_today_start && $hero_today_end){
	$search .= "and date_format(`hero_regdate`,'%Y-%m-%d') between '".$hero_today_start."' and '".$hero_today_end."' ";
	$next_path .= "&hero_today_start=".$hero_today_start."&hero_today_end=".$hero_today_end;
}
if($selectValue && $textValue){
	if($selectValue == "hero_id"){
		$search .= "and hero_id like '%".$textValue."%' ";
	}else if($selectValue == "hero_name"){
		$search .= "and hero_name like '%".$textValue."%' ";
	}else if($selectValue == "hero_nick"){
		$search .= "and hero_nick like '%".$textValue."%' ";
	}
	$next_path .= "&selectValue=".$selectValue."&textValue=".$textValue;
}

if($pointType){
	if($pointType == 'Plus') $search .=" and hero_order_point > 0 ";
	else if($pointType == 'Minus') $search .=" and hero_order_point < 0 ";
	
	$next_path .= "&pointType=".$pointType;
}


// 페이징을 위한 데이타 총 갯수
$sql = "select hero_code from order_main where hero_process='DE' ".$search;
$out_sql = mysql_query($sql);
$total_data = @mysql_num_rows($out_sql);

if($_GET['page']!=''){
	$NO = $total_data-(($_GET['page']-1)*$list_page);
	$page = $_GET['page'];
	
}else{
	$page = '1';
	$NO = $total_data;
}

$start = ($page-1)*$list_page;

?>
<div id="resultPointArea">
	<p>총 :<?=number_format($total_data)?>건</p>
	
	<table>
		<colgroup>
			<col width="200px" />
			<col width="200px" />
			<col width="100px" />
			<col width="100px" />
			<col width="100px" />
			<col width="*" />
			<col width="100px" />
		</colgroup>

		<tr>
			<th>적립일</th>
			<th>아이디</th>
			<th>성명</th>
			<th>닉네임</th>
			<th>차감/반환</th>
			<th>내용</th>
			<th>포인트</th>
		</tr>
		<?
		
		// 게시판 쿼리
		$sql = " select hero_idx, hero_id, hero_name, hero_nick, hero_order_point, hero_regdate ";
		$sql .= " ,(select hero_title from mission where hero_idx = o.mission_idx ) as  mission_title ";
		$sql .="from order_main o ";
		$sql .="where hero_process='DE' ".$search." ";
		$sql .="order by hero_idx desc ";
		$sql .="limit ".$start.",".$list_page."";
		//echo $sql;
		$out_sql = mysql_query($sql);	
		
		if($total_data == 0){
        ?>	
       <tr><td colspan="8">검색 결과가 없습니다.</td></tr>
        <? 
         } else{
	           while($list = @mysql_fetch_assoc($out_sql)){
	           $point = $list['hero_order_point']*-1;
	    ?>
		<tr>
			<td><?=$list['hero_regdate']?></td>
			<td><?=$list['hero_id']?></td>
			<td><?=name_masking($list['hero_name'])?></td>
			<td><?=$list['hero_nick']?></td>
			<td><?=$list['hero_order_point'] > 0 ? "차감":"반환";?></td>
			<td style="text-align:left;">배송비 가용포인트 (<?=strip_tags($list["mission_title"]);?>)</td>
			<td><?=$point?> P</td>
		</tr>
		<? } //end while
	      } //end if?>
	</table>
</div>

		<div style="width:98%;"><? include_once PATH_INC_END.'page.php';?></div>
     	
     	<script>
	     	function ch_page(page){
		     	location.href="<?=PATH_HOME.'?board='.$_GET['board'].'&idx='.$_GET['idx'].'&page='?>"+page+"<?=$search_next?>";
	     	}
     	</script>          


    
    