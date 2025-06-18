<?
if(!defined('_HEROBOARD_'))exit;

$search = "";

if(strcmp($_GET["kewyword"], "")){
	$search .= " AND  ".$_GET["select"]." LIKE '%".$_GET["kewyword"]."%' ";
}

if(strlen($_GET["lot_01"]) > 0) {
	$search .= " AND  r.lot_01 = '".$_GET["lot_01"]."' ";
}

if($_GET["delivery_point"]) {
	if($_GET["delivery_point"]=="Y") {
		$search .= " AND  delivery_point > 0 ";
	} else if($_GET["delivery_point"]=="N") {
		$search .= " AND  (delivery_point = 0 || delivery_point is null) ";
	}
}

//총 갯수
$sql  = " SELECT count(*) AS cnt FROM ";
$sql .= " (SELECT r.hero_idx, r.hero_new_name, r.hero_hp_01, r.hero_hp_02, r.hero_hp_03 ";
$sql .= " , r.lot_01, r.delivery_point_yn, r.hero_superpass, r.hero_today ";
$sql .= " , m.hero_id, m.hero_name, m.hero_nick, m.hero_jumin ";
$sql .= " , (SELECT COUNT(*) FROM member_penalty WHERE hero_use_yn ='Y' AND hero_code = m.hero_code) AS penalty_cnt ";
$sql .= " , (SELECT sum(hero_order_point) FROM order_main WHERE hero_code=r.hero_code  AND hero_process = 'DE' AND mission_idx = r.hero_old_idx) AS delivery_point ";
$sql .= " FROM mission_review r ";
$sql .= " INNER JOIN member m ON r.hero_code = m.hero_code ";
$sql .= " WHERE m.hero_use=0 AND r.hero_old_idx='".$_GET['hero_idx']."') r WHERE 1=1 ".$search;

sql($sql);
$out_res = mysql_fetch_assoc($out_sql);
$total_data = $out_res['cnt'];

$i=$total_data;

$list_page=$_REQUEST['list_count']==""?20:$_REQUEST['list_count'];
$page_per_list=10;
  
if(!strcmp($_GET['page'], ''))		$page = '1';
else								$page = $_GET['page'];
	
$i = $i-($page-1)*$list_page;


$start = ($page-1)*$list_page;
$next_path=get("page");

//리스트
$sql  = " SELECT r.* FROM ";
$sql .= " (SELECT r.hero_idx, r.hero_new_name, r.hero_hp_01, r.hero_hp_02, r.hero_hp_03 ";
$sql .= " , r.lot_01, r.delivery_point_yn, r.hero_superpass, r.hero_today ";
$sql .= " , m.hero_id, m.hero_name, m.hero_nick, m.hero_jumin ";
$sql .= " , (SELECT COUNT(*) FROM member_penalty WHERE hero_use_yn ='Y' AND hero_code = m.hero_code) AS penalty_cnt ";
$sql .= " , (SELECT ifnull(sum(hero_order_point),0) FROM order_main WHERE hero_code=r.hero_code  AND hero_process = 'DE' AND mission_idx = r.hero_old_idx) AS delivery_point ";
$sql .= " FROM mission_review r ";
$sql .= " INNER JOIN member m ON r.hero_code = m.hero_code ";
$sql .= " WHERE m.hero_use=0 AND r.hero_old_idx='".$_GET['hero_idx']."' ) r WHERE 1=1 ".$search;
$sql .= " ORDER BY r.hero_idx DESC ";
$sql .= " LIMIT ".$start.",".$list_page;

$list_res = sql($sql);

//미션정보
$mission_sql = " SELECT hero_type, hero_title, hero_superpass, delivery_point_yn, hero_table FROM mission WHERE hero_idx = '".$_GET["hero_idx"]."' ";
$mission_res = sql($mission_sql);
$mission_rs = mysql_fetch_assoc($mission_res);

$mission_board_type = false;
if($mission_rs["hero_type"] == "2" || $mission_rs["hero_type"] == "10") {
	$mission_board_type = true;
}
?>

<div class="view_title_box">
	<h4>신청자</h4>
	<p><label>제목</label> : <?=$mission_rs["hero_title"]?></p>
	<p><label>체험단 타입</label> : 
		<? if($mission_rs["hero_table"] == "group_04_05") {?>
			<?=$type_arr[$mission_rs["hero_type"]]?>
		<? } else {?>
			<?=$focus_type_arr[$mission_rs["hero_type"]]?>
		<? } ?>
		, <label>슈퍼패스</label> : <?=$mission_rs["hero_superpass"]=="Y" ? "사용":"미사용"?>, <label>배송포인트차감</label> : <?=$mission_rs["delivery_point_yn"]=="Y" ? "차감":"미차감"?></p>
</div>

<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
<input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
<input type="hidden" name="hero_idx" value="<?=$_GET["hero_idx"]?>" />
<input type="hidden" name="board" value="<?=$_GET["board"]?>" />
<input type="hidden" name="view" value="<?=$_GET["view"]?>" />
<table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>당첨자</th>
		<td>
			<input type="radio" name="lot_01" id="lot_01_all" value="" <?=strlen($_GET["lot_01"])==0 ? "checked":""?> /><label for="lot_01_all">전체</label>
			<input type="radio" name="lot_01" id="lot_01_1" value="1" <?=$_GET["lot_01"]==1 ? "checked":""?>/><label for="lot_01_1">당첨자</label>
			<input type="radio" name="lot_01" id="lot_01_0" value="0" <?=strlen($_GET["lot_01"])==1 && $_GET["lot_01"]==0 ? "checked":""?>/><label for="lot_01_0">미당첨자</label>
		</td>
	</tr>
	<tr>
		<th>배송비 포인트</th>
		<td>
			<input type="radio" name="delivery_point" id="delivery_point_all" value="" <?=!$_GET["delivery_point"] ? "checked":""?>/><label for="delivery_point_all">전체</label>
			<input type="radio" name="delivery_point" id="delivery_point_Y" value="Y" <?=$_GET["delivery_point"]=="Y" ? "checked":""?>/><label for="delivery_point_Y">차감</label>
			<input type="radio" name="delivery_point" id="delivery_point_N" value="N" <?=$_GET["delivery_point"]=="N" ? "checked":""?>/><label for="delivery_point_N">미차감</label>
		</td>
	</tr>
	<tr>
		<th>검색어</th>
		<td>
			<select name="select">
		    	<option value="r.hero_nick" <?if(!strcmp($_REQUEST['select'], 'r.hero_nick')){echo ' selected';}else{echo '';}?>>닉네임</option>
		    	<option value="r.hero_name" <?if(!strcmp($_REQUEST['select'], 'r.hero_name')){echo ' selected';}else{echo '';}?>>이름</option>
		    	<option value="r.hero_new_name" <?if(!strcmp($_REQUEST['select'], 'r.hero_new_name')){echo ' selected';}else{echo '';}?>>받는이름</option>
		    	<option value="r.hero_id" <?if(!strcmp($_REQUEST['select'], 'r.hero_id')){echo ' selected';}else{echo '';}?>>아이디</option>
	    	</select>
	    	<input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];;?>" class="kewyword">		
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">검색</a>
</div>


<div class="listExplainWrap">
<label>총 </label> : <strong><?=$total_data?></strong>건, <span class="icon_gray">블랙리스트</span>
</div>
<div class="btnGroupFunction">
	<div class="leftWrap">
		<a href="javascript:;" class="btnFunc" onClick="fnWinning()">당첨</a>
		<a href="javascript:;" class="btnFormCancel" onClick="fnWinningCancel()">당첨취소</a>
		<!--<a href="javascript:;" class="btnFunc" onClick="fnDelivery()">배송비 차감</a>-->
		<a href="javascript:;" class="btnFormCancel" onClick="fnDeliveryCancel();">배송비 환불</a>
	</div>
	<div class="rightWrap">
		<a href="javascript:;" class="btnFormExcel" onClick="fnUploadPopup('<?=$_GET["hero_idx"]?>');">당첨자 선정 업로드</a>
		<? if($mission_board_type == false) {?>
			<a href="javascript:;" class="btnFormExcel" onClick="fnExcel();">일반미션 신청자 다운로드</a>
		<? } else { //소문내기?>
			<a href="javascript:;" class="btnFormExcel" onClick="fnExcelRumor();">소문내기 신청자 다운로드</a>
		<? } ?>
		<select name="list_count" onchange="fnListCount()">
        	<option value="">출력 수</option>
            <option value="20"<?if(!strcmp($_REQUEST['list_count'], '20')){echo ' selected';}else{echo '';}?>>20개</option>
        	<option value="30"<?if(!strcmp($_REQUEST['list_count'], '30')){echo ' selected';}else{echo '';}?>>30개</option>
	        <option value="50"<?if(!strcmp($_REQUEST['list_count'], '50')){echo ' selected';}else{echo '';}?>>50개</option>
            <option value="100"<?if(!strcmp($_REQUEST['list_count'], '100')){echo ' selected';}else{echo '';}?>>100개</option>
            <option value="250"<?if(!strcmp($_REQUEST['list_count'], '250')){echo ' selected';}else{echo '';}?>>250개</option>
		</select>
	</div>
</div>
</form>
<form name="listForm" id="listForm" method="POST">
<input type="hidden" name="mode" />
<table class="t_list">
<colgroup>
	<col width="4%" />
	<col width="8%" />
	<col width="8%" />
	<col width="10%" />
	<col width="*" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="6%" />
	<col width="6%" />
	<col width="6%" />
	<col width="6%" />
	<col width="8%" />
</colgroup>
<thead>
	<tr>
		<th><input type="checkbox" id="allCheck"></th>
		<th>당첨여부</th>
		<th>슈퍼패스</th>
		<th>아이디</th>
		<th>닉네임</th>
		<th>이름</th>
		<th>받는이름</th>
		<th>받는 휴대폰</th>
		<th>나이</th>
		<th>패널티 횟수</th>
		<th>배송비 차감여부</th>
		<th>배송비</th>
		<th>등록일</th>
	</tr>
</thead>
	<? 
	if($total_data > 0) {
	while($list = mysql_fetch_assoc($list_res)) { 
	   	$lot_01_txt = "미당첨";
	   	if($list["lot_01"] == "1") $lot_01_txt = "당첨";
	   	
	   	$superpass_txt = "미사용";
	   	if($list["hero_superpass"] == "Y") $superpass_txt = "사용";
	   	
	   	$age = (date("Y")-substr($list["hero_jumin"],0,4))+1;
	   	$hp = $list["hero_hp_01"]."-".$list["hero_hp_02"]."-".$list["hero_hp_03"];
	   	$delivery_point_yn = $list["delivery_point_yn"] == "Y" ? "차감":"미차감";
	?>
	<tr>
		<td><input type="checkbox" name="hero_idx[]" value="<?=$list["hero_idx"]?>" /></td>
		<td><?=$lot_01_txt?></td>
		<td><?=$superpass_txt?></td>
		<td><?=$list["hero_id"]?></td>
		<td><?=$list["hero_nick"]?></td>
		<td><?=$list["hero_name"]?></td>
		<td><?=$list["hero_new_name"]?></td>
		<td><?=$hp?></td>
		<td><?=$age?></td>
		<td><?=$list["penalty_cnt"]?></td>
		<td><?=$delivery_point_yn?></td>
		<td><?=$list["delivery_point"]?></td>
		<td><?=substr($list["hero_today"],0,10)?></td>
	</tr>
	<? }
	} else {?>
	<tr>
		<td colspan="13">등록된 데이터가 없습니다.</td>
	</tr>
	<? } ?>
</table>
</form>

<div class="btnGroupL">
	<a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&page=<?=$_GET['page']?>&idx=<?=$_GET["idx"]?>" class="btnList">목록</a>
</div>

<div class="pagingWrap">
<? include_once PATH_INC_END.'page.php';?>
</div>
<script>
$(document).ready(function(){

	$("#allCheck").on("click",function(){
		if($(this).is(":checked")) {
			$("input:checkbox[name='hero_idx[]']").prop("checked",true);
		} else {
			$("input:checkbox[name='hero_idx[]']").prop("checked",false);
		}
	})
	
	//추후 진행 포인트 속도부하 때문에
	fnDelivery = function() {
		if($("input:checkbox[name='hero_idx[]']:checked").length == 0) {
			alert("선택한 회원이 없습니다.");
			return;
		}
		$("#listForm input[name='mode']").val("delivery");

		//$("#listForm").attr("action","/loaksecure21/nail/01_01_action.php").submit();
		$.ajax({
			url:"/loaksecure21/nail/01_01_action.php"
			,type:"POST"
			,data:$("#listForm").serialize()
			,dataType:"json"
			,success:function(data){
				if(data.success > 0) {
					alert("실행결과 실행:"+data.total+", 성공:"+data.success+", 실패:"+data.fail+"\n실행되었습니다.");
					location.reload();
				} else {
					alert("실행 중 실패 했습니다.");
					return;
				}
			},error:function(error){
				console.log(error);
			}
		})
	}
	
	fnDeliveryCancel = function() {
		if($("input:checkbox[name='hero_idx[]']:checked").length == 0) {
			alert("선택한 회원이 없습니다.");
			return;
		}
		$("#listForm input[name='mode']").val("deliveryCancel");

		//$("#listForm").attr("action","/loaksecure21/nail/01_01_action.php").submit();
		$.ajax({
			url:"/loaksecure21/nail/01_01_action.php"
			,type:"POST"
			,data:$("#listForm").serialize()
			,dataType:"json"
			,success:function(data){
				alert("실행결과 실행:"+data.total+", 성공:"+data.success+", 실패:"+data.fail+"\n실행되었습니다.");
				location.reload();
			},error:function(error){
				console.log(error);
			}
		})
	}
	
	fnWinning = function() {
		if($("input:checkbox[name='hero_idx[]']:checked").length == 0) {
			alert("선택한 회원이 없습니다.");
			return;
		}

		if(confirm("당첨 실행하시겠습니까?")) {
			$("#listForm input[name='mode']").val("winning");
			$.ajax({
					url:"/loaksecure21/nail/01_01_action.php"
					,type:"POST"
					,data:$("#listForm").serialize()
					,dataType:"json"
					,success:function(data){
						if(data.success > 0) {
							alert("실행결과 실행:"+data.total+", 성공:"+data.success+", 실패:"+data.fail+"\n실행되었습니다.");
							location.reload();
						} else {
							alert("실행 중 실패 했습니다.");
							return;
						}
					},error:function(error){
						console.log(error);
					}
				})
		}
	}

	fnWinningCancel = function() {
		if($("input:checkbox[name='hero_idx[]']:checked").length == 0) {
			alert("선택한 회원이 없습니다.");
			return;
		}

		if(confirm("당첨취소 실행하시겠습니까?")) {
			$("#listForm input[name='mode']").val("winningCancel");
			$.ajax({
					url:"/loaksecure21/nail/01_01_action.php"
					,type:"POST"
					,data:$("#listForm").serialize()
					,dataType:"json"
					,success:function(data){
						if(data.success > 0) {
							alert("실행결과 실행:"+data.total+", 성공:"+data.success+", 실패:"+data.fail+"\n실행되었습니다.");
							location.reload();
						} else {
							alert("실행 중 실패 했습니다.");
							return;
						}
					},error:function(error){
						console.log(error);
					}
				})
		}
	}

	fnUploadPopup = function(hero_old_idx) {
		var popup_01_01_01 = window.open('/loaksecure21/nail/popup_01_01_01.php?hero_old_idx='+hero_old_idx,'popup_01_01_01','width=600, height=600');
		popup_01_01_01.focus();
	}

	fnListCount = function() {
		$("#searchForm").attr("action","").submit();
	}

	fnSearch = function() {
		$("#searchForm").attr("action","").submit();
	}

	fnExcel = function() {
		$("#searchForm").attr("action","/loaksecure21/nail/01_01_excel.php").submit();
	}

	fnExcelRumor = function() {
		$("#searchForm").attr("action","/loaksecure21/nail/01_01_rumor_excel.php").submit();
	}
})
</script>
                        	
                        