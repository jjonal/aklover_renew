<?
if(!defined('_HEROBOARD_'))exit;

//미션정보
$mission_sql = " SELECT hero_type, hero_title, hero_superpass, delivery_point_yn FROM mission WHERE hero_idx = '".$_GET["hero_idx"]."' ";
$mission_res = sql($mission_sql);
$mission_rs = mysql_fetch_assoc($mission_res);

if($mission_rs["hero_type"] == "7") exit();

$search = "";

if(strcmp($_GET["kewyword"], "")){
	$search .= " AND  ".$_GET["select"]." LIKE '%".$_GET["kewyword"]."%' ";
}

if($_GET["board_write"]) {
	if($_GET["board_write"] == "Y") {
		$search .= " AND  b.url_cnt > 0 ";
	} else if($_GET["board_write"] == "N") {
		$search .= " AND  (b.url_cnt = 0 || b.url_cnt is null) ";
	} else if($_GET["board_write"] == "W") {
		$search .= " AND  b.url_cnt > 0 AND b.hero_board_three = '1' ";
	} else if($_GET["board_write"] == "T") {
		$search .= " AND  r.url_cnt > 0 AND r.hero_board_three = '2' ";
	}
}

//총 갯수
$sql  = " SELECT count(*) cnt FROM ( ";
$sql .= " SELECT b.hero_idx, b.hero_board_three ";
$sql .= " , m.hero_name, m.hero_id, m.hero_nick ";
$sql .= " ,sum(if(u.url is not null || u.url != 0,'1','0')) as url_cnt ";
$sql .= "  FROM board b ";
$sql .= " INNER JOIN member m ON b.hero_code = m.hero_code ";
$sql .= " LEFT JOIN mission_url u ON b.hero_idx = u.board_hero_idx ";
$sql .= " WHERE m.hero_use=0 AND b.hero_01='".$_GET['hero_idx']."' GROUP BY b.hero_idx ";
$sql .= " ) b WHERE 1=1 ".$search;

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
$sql  = " SELECT  b.* FROM ( ";
$sql .= " SELECT b.hero_idx, b.hero_board_three, b.hero_today ";
$sql .= " , m.hero_id, m.hero_name, m.hero_nick, m.hero_jumin, m.hero_hp ";
$sql .= " , sum(if(u.url is not null || u.url != 0,'1','0')) as url_cnt ";
$sql .= " , sum(if(u.gubun = 'naver','1','0')) AS naver_cnt ";
$sql .= " , sum(if(u.gubun = 'insta','1','0')) AS insta_cnt ";
$sql .= " , sum(if(u.gubun = 'movie','1','0')) AS movie_cnt ";
$sql .= " , sum(if(u.gubun = 'cafe','1','0')) AS cafe_cnt ";
$sql .= " , sum(if(u.gubun = 'etc','1','0')) AS etc_cnt ";
$sql .= " , (SELECT COUNT(*) FROM member_penalty WHERE hero_use_yn ='Y' AND hero_code = m.hero_code) AS penalty_cnt ";
$sql .= " FROM board b ";
$sql .= " INNER JOIN member m ON b.hero_code = m.hero_code ";
$sql .= " LEFT JOIN mission_url u ON b.hero_idx = u.board_hero_idx ";
$sql .= " WHERE m.hero_use=0 AND b.hero_01='".$_GET['hero_idx']."' ";
$sql .= " GROUP BY b.hero_code ";
$sql .= " ORDER BY b.hero_idx DESC ) b WHERE 1=1 ".$search;
$sql .= " LIMIT ".$start.",".$list_page;

$list_res = sql($sql);

$greatPoint = 2000;
$thanksPoint = 500;
?>
<div class="view_title_box">
	<h4>당첨자</h4>
	<p><label>제목</label> : <?=$mission_rs["hero_title"]?></p>
	<p><label>체험단 타입</label> : <?=$focus_type_arr[$mission_rs["hero_type"]]?>, <label>슈퍼패스</label> : <?=$mission_rs["hero_superpass"]=="Y" ? "사용":"미사용"?>, <label>배송포인트차감</label> : <?=$mission_rs["delivery_point_yn"]=="Y" ? "차감":"미차감"?></p>
	<p><label>우수후기 선정</label> : <?=$greatPoint?>p, <label>감사포인트</label> : <?=$thanksPoint?>p</p>
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
		<th>후기작성확인</th>
		<td>
			<input type="radio" name="board_write" id="board_write_all" value="" <?=!$_GET["board_write"] ? "checked":""?> /><label for="board_write_all">전체</label>
			<input type="radio" name="board_write" id="board_write_Y" value="Y" <?=$_GET["board_write"]=="Y" ? "checked":""?>/><label for="board_write_Y">후기작성</label>
			<input type="radio" name="board_write" id="board_write_N" value="N" <?=$_GET["board_write"]=="N" ? "checked":""?>/><label for="board_write_N">후기 미작성</label>
			<input type="radio" name="board_write" id="board_write_W" value="W" <?=$_GET["board_write"]=="W" ? "checked":""?>/><label for="board_write_W">우수후기</label>
			<input type="radio" name="board_write" id="board_write_T" value="T" <?=$_GET["board_write"]=="T" ? "checked":""?>/><label for="board_write_T">감사포인트</label>
		</td>
	</tr>
	<tr>
		<th>검색어</th>
		<td>
			<select name="select">
		    	<option value="hero_nick" <?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>닉네임</option>
		    	<option value="hero_name" <?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>이름</option>
		    	<option value="hero_id" <?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>아이디</option>
	    	</select>
	    	<input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];;?>" class="kewyword">		
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">검색</a>
</div>


<div class="listExplainWrap">
<label>총 </label> : <strong><?=$total_data?></strong>건
</div>
<div class="btnGroupFunction">
	<div class="leftWrap">
		<div class="mission">
			<input type="radio" name="functionType" id="functionType_1" value="best" class="ml10"><label for="functionType_1">우수후기 선정</label>
			<input type="radio" name="functionType" id="functionType_2" value="thanks" class="ml10"><label for="functionType_2">감사포인트 지급</label>
			
			<a href="javascript:;" class="btnFunc ml10" onClick="fnExec()">실행</a>
			<a href="javascript:;" class="btnFormCancel" onClick="fnCancel()">취소</a>
		</div>
	</div>
	<div class="rightWrap">
		<select name="alrimtalk_type">
			<option value="">쪽지/알림톡 발송타입선택</option>
			<option value="11">가이드라인 미준수</option>
			<option value="12">후기 미등록</option>
			<option value="13">오프라인 모임 미참여</option>
			<option value="14">품평/설문 미진행</option>
			<option value="15">우수후기 지급 포인트</option>
			<option value="16">감사포인트</option>
		</select>
		<a href="javascript:;" class="btnFormCancel" onClick="fnMessageSend();">쪽지발송</a>
		
		<a href="javascript:;" class="btnFormExcel" onClick="fnExcel();">당첨자 다운로드</a>
		<a href="javascript:;" class="btnFormExcel" onClick="fnExcelReview();">후기등록 다운로드</a>
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
<input type="hidden" name="point" />
<table class="t_list">
<colgroup>
	<col width="4%" />
	<col width="8%" />
	<col width="8%" />
	<col width="8%" />
	<col width="8%" />
	<col width="10%" />
	<col width="6%" />
	<col width="4%" />
	<col width="4%" />
	<col width="4%" />
	<col width="4%" />
	<col width="4%" />
	<col width="4%" />
	<col width="8%" />
</colgroup>
<thead>
	<tr>
		<th rowspan="2"><input type="checkbox" id="allCheck"></th>
		<th rowspan="2">후기작성</th>
		<th rowspan="2">아이디</th>
		<th rowspan="2">닉네임</th>
		<th rowspan="2">이름</th>
		<th rowspan="2">휴대폰</th>
		<th rowspan="2">나이</th>
		<th colspan="5">후기등록 SNS URL 등록 건수</th>
		<th rowspan="2">패널티 수</th>
		<th rowspan="2">등록일</th>
	</tr>
	<tr>
		<th>네이버 블로그</th>
		<th>인스타그램</th>
		<th>후기(영상)</th>
		<th>카페</th>
		<th>기타</th>
	</tr>
</thead>
	<? if($total_data > 0) {
	   while($list = mysql_fetch_assoc($list_res)) {
		$board_write_txt = "";
		if($list["url_cnt"] > 0) {
			if($list["hero_board_three"] == "1") {
				$board_write_txt = "우수후기";
			} else if($list["hero_board_three"] == "2") {
				$board_write_txt = "감사포인트";
			} else {
				$board_write_txt = "작성";
			}
		} else {
			$board_write_txt = "미작성";
		}
		
		$age = (date("Y")-substr($list["hero_jumin"],0,4))+1;
	?>
	<tr>
		<td><input type="checkbox" name="hero_idx[]" value="<?=$list["hero_idx"]?>" /></td>
		<td><?=$board_write_txt?></td>
		<td><?=$list["hero_id"]?></td>
		<td><?=$list["hero_nick"]?></td>
		<td><?=$list["hero_name"]?></td>
		<td><?=$list["hero_hp"]?></td>
		<td><?=$age?></td>
		<td><?=$list["naver_cnt"]?></td>
		<td><?=$list["insta_cnt"]?></td>
		<td><?=$list["movie_cnt"]?></td>
		<td><?=$list["cafe_cnt"]?></td>
		<td><?=$list["etc_cnt"]?></td>
		<td><?=$list["penalty_cnt"]?></td>
		<td><?=substr($list["hero_today"],0,10)?></td>
	</tr>
	<? }
   } else {?>
   <tr>
   		<td colspan="14">등록된 데이터가 없습니다.</td>
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
	
	fnExec = function() {
		var confirm_txt = "";

		if(!$("input:radio[name='functionType']:checked").val()) {
			alert("기능을 선택해 주세요.");
			return;
		} 

		if($("input:checkbox[name='hero_idx[]']:checked").length == 0) {
			alert("선택한 회원이 없습니다.");
			return;
		}
		
		if($("input:radio[name='functionType']:checked").val() == "best") {
			confirm_txt = "우수후기 선정 실행하시겠습니까?";
			$("#listForm input[name='mode']").val("best");
			$("#listForm input[name='point']").val('<?=$greatPoint?>');
		} else if($("input:radio[name='functionType']:checked").val() == "thanks") {
			confirm_txt = "감사포인트 실행하시겠습니까?";
			$("#listForm input[name='mode']").val("thanks");
			$("#listForm input[name='point']").val('<?=$thanksPoint?>');
		}

		if(confirm(confirm_txt)) {
			$.ajax({
				url:"/loaksecure21/nail/02_02_action.php"
				,type:"POST"
				,data:$("#listForm").serialize()
				,dataType:"json"
				,success:function(data){
					if(data.total > 0) {
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

	fnCancel = function() {
		var confirm_txt = "";

		if(!$("input:radio[name='functionType']:checked").val()) {
			alert("기능을 선택해 주세요.");
			return;
		} 

		if($("input:checkbox[name='hero_idx[]']:checked").length == 0) {
			alert("선택한 회원이 없습니다.");
			return;
		}
		
		if($("input:radio[name='functionType']:checked").val() == "best") {
			confirm_txt = "우수후기 선정을 취소하시겠습니까?";
			$("#listForm input[name='mode']").val("bestCancel");
			$("#listForm input[name='point']").val('<?=$greatPoint?>');
		} else if($("input:radio[name='functionType']:checked").val() == "thanks") {
			confirm_txt = "지급된 감사포인트를 취소 실행하시겠습니까?";
			$("#listForm input[name='mode']").val("thanksCancel");
			$("#listForm input[name='point']").val('<?=$thanksPoint?>');
		}

		if(confirm(confirm_txt)) {
			$.ajax({
				url:"/loaksecure21/nail/02_02_action.php"
				,type:"POST"
				,data:$("#listForm").serialize()
				,dataType:"json"
				,success:function(data){
					if(data.total > 0) {
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

	fnMessageSend = function() {
		if(!$("select[name='alrimtalk_type'").val()) {
			alert("쪽지/알림톡 발송타입을 선택해 주세요");
			return;
		}

		if($("input:checkbox[name='hero_idx[]']:checked").length == 0) {
			alert("선택한 회원이 없습니다.");
			return;
		}

		if(confirm("쪽지/알림톡을 발송하시겠습니까?")) {
			$("#listForm input[name='mode']").val("message");
			
			var param = $("#listForm").serialize();
			param += "&alrimtalk_type="+$("select[name='alrimtalk_type'").val();
			param += "&hero_mission_idx="+$("#searchForm input[name='hero_idx']").val();
			
			$.ajax({
					url:"/loaksecure21/nail/02_02_action.php"
					,type:"POST"
					,data:param
					,dataType:"json"
					,success:function(data){
						console.log(data);
						if(data.total > 0) {
							alert("실행결과 실행:"+data.total+", 성공:"+data.success+", 실패:"+data.fail+"\n실행되었습니다.");
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

	fnListCount = function() {
		$("#searchForm").attr("action","").submit();
	}

	fnSearch = function() {
		$("#searchForm").attr("action","").submit();
	}

	fnExcel = function() {
		$("#searchForm").attr("action","/loaksecure21/nail/02_02_excel.php").submit();
	}

	fnExcelReview = function() {
		$("#searchForm").attr("action","/loaksecure21/nail/02_02_review_excel.php").submit();
	}
})
</script>
                        	
                        