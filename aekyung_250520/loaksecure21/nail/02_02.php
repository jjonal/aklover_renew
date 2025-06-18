<?
if(!defined('_HEROBOARD_'))exit;

//�̼�����
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

//�� ����
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

//����Ʈ
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
	<h4>��÷��</h4>
	<p><label>����</label> : <?=$mission_rs["hero_title"]?></p>
	<p><label>ü��� Ÿ��</label> : <?=$focus_type_arr[$mission_rs["hero_type"]]?>, <label>�����н�</label> : <?=$mission_rs["hero_superpass"]=="Y" ? "���":"�̻��"?>, <label>�������Ʈ����</label> : <?=$mission_rs["delivery_point_yn"]=="Y" ? "����":"������"?></p>
	<p><label>����ı� ����</label> : <?=$greatPoint?>p, <label>��������Ʈ</label> : <?=$thanksPoint?>p</p>
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
		<th>�ı��ۼ�Ȯ��</th>
		<td>
			<input type="radio" name="board_write" id="board_write_all" value="" <?=!$_GET["board_write"] ? "checked":""?> /><label for="board_write_all">��ü</label>
			<input type="radio" name="board_write" id="board_write_Y" value="Y" <?=$_GET["board_write"]=="Y" ? "checked":""?>/><label for="board_write_Y">�ı��ۼ�</label>
			<input type="radio" name="board_write" id="board_write_N" value="N" <?=$_GET["board_write"]=="N" ? "checked":""?>/><label for="board_write_N">�ı� ���ۼ�</label>
			<input type="radio" name="board_write" id="board_write_W" value="W" <?=$_GET["board_write"]=="W" ? "checked":""?>/><label for="board_write_W">����ı�</label>
			<input type="radio" name="board_write" id="board_write_T" value="T" <?=$_GET["board_write"]=="T" ? "checked":""?>/><label for="board_write_T">��������Ʈ</label>
		</td>
	</tr>
	<tr>
		<th>�˻���</th>
		<td>
			<select name="select">
		    	<option value="hero_nick" <?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>�г���</option>
		    	<option value="hero_name" <?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>�̸�</option>
		    	<option value="hero_id" <?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>���̵�</option>
	    	</select>
	    	<input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];;?>" class="kewyword">		
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">�˻�</a>
</div>


<div class="listExplainWrap">
<label>�� </label> : <strong><?=$total_data?></strong>��
</div>
<div class="btnGroupFunction">
	<div class="leftWrap">
		<div class="mission">
			<input type="radio" name="functionType" id="functionType_1" value="best" class="ml10"><label for="functionType_1">����ı� ����</label>
			<input type="radio" name="functionType" id="functionType_2" value="thanks" class="ml10"><label for="functionType_2">��������Ʈ ����</label>
			
			<a href="javascript:;" class="btnFunc ml10" onClick="fnExec()">����</a>
			<a href="javascript:;" class="btnFormCancel" onClick="fnCancel()">���</a>
		</div>
	</div>
	<div class="rightWrap">
		<select name="alrimtalk_type">
			<option value="">����/�˸��� �߼�Ÿ�Լ���</option>
			<option value="11">���̵���� ���ؼ�</option>
			<option value="12">�ı� �̵��</option>
			<option value="13">�������� ���� ������</option>
			<option value="14">ǰ��/���� ������</option>
			<option value="15">����ı� ���� ����Ʈ</option>
			<option value="16">��������Ʈ</option>
		</select>
		<a href="javascript:;" class="btnFormCancel" onClick="fnMessageSend();">�����߼�</a>
		
		<a href="javascript:;" class="btnFormExcel" onClick="fnExcel();">��÷�� �ٿ�ε�</a>
		<a href="javascript:;" class="btnFormExcel" onClick="fnExcelReview();">�ı��� �ٿ�ε�</a>
		<select name="list_count" onchange="fnListCount()">
        	<option value="">��� ��</option>
            <option value="20"<?if(!strcmp($_REQUEST['list_count'], '20')){echo ' selected';}else{echo '';}?>>20��</option>
        	<option value="30"<?if(!strcmp($_REQUEST['list_count'], '30')){echo ' selected';}else{echo '';}?>>30��</option>
	        <option value="50"<?if(!strcmp($_REQUEST['list_count'], '50')){echo ' selected';}else{echo '';}?>>50��</option>
            <option value="100"<?if(!strcmp($_REQUEST['list_count'], '100')){echo ' selected';}else{echo '';}?>>100��</option>
            <option value="250"<?if(!strcmp($_REQUEST['list_count'], '250')){echo ' selected';}else{echo '';}?>>250��</option>
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
		<th rowspan="2">�ı��ۼ�</th>
		<th rowspan="2">���̵�</th>
		<th rowspan="2">�г���</th>
		<th rowspan="2">�̸�</th>
		<th rowspan="2">�޴���</th>
		<th rowspan="2">����</th>
		<th colspan="5">�ı��� SNS URL ��� �Ǽ�</th>
		<th rowspan="2">�г�Ƽ ��</th>
		<th rowspan="2">�����</th>
	</tr>
	<tr>
		<th>���̹� ��α�</th>
		<th>�ν�Ÿ�׷�</th>
		<th>�ı�(����)</th>
		<th>ī��</th>
		<th>��Ÿ</th>
	</tr>
</thead>
	<? if($total_data > 0) {
	   while($list = mysql_fetch_assoc($list_res)) {
		$board_write_txt = "";
		if($list["url_cnt"] > 0) {
			if($list["hero_board_three"] == "1") {
				$board_write_txt = "����ı�";
			} else if($list["hero_board_three"] == "2") {
				$board_write_txt = "��������Ʈ";
			} else {
				$board_write_txt = "�ۼ�";
			}
		} else {
			$board_write_txt = "���ۼ�";
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
   		<td colspan="14">��ϵ� �����Ͱ� �����ϴ�.</td>
   </tr>
   <? } ?>
</table>
</form>

<div class="btnGroupL">
	<a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&page=<?=$_GET['page']?>&idx=<?=$_GET["idx"]?>" class="btnList">���</a>
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
			alert("����� ������ �ּ���.");
			return;
		} 

		if($("input:checkbox[name='hero_idx[]']:checked").length == 0) {
			alert("������ ȸ���� �����ϴ�.");
			return;
		}
		
		if($("input:radio[name='functionType']:checked").val() == "best") {
			confirm_txt = "����ı� ���� �����Ͻðڽ��ϱ�?";
			$("#listForm input[name='mode']").val("best");
			$("#listForm input[name='point']").val('<?=$greatPoint?>');
		} else if($("input:radio[name='functionType']:checked").val() == "thanks") {
			confirm_txt = "��������Ʈ �����Ͻðڽ��ϱ�?";
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
						alert("������ ����:"+data.total+", ����:"+data.success+", ����:"+data.fail+"\n����Ǿ����ϴ�.");
						location.reload();
					} else {
						alert("���� �� ���� �߽��ϴ�.");
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
			alert("����� ������ �ּ���.");
			return;
		} 

		if($("input:checkbox[name='hero_idx[]']:checked").length == 0) {
			alert("������ ȸ���� �����ϴ�.");
			return;
		}
		
		if($("input:radio[name='functionType']:checked").val() == "best") {
			confirm_txt = "����ı� ������ ����Ͻðڽ��ϱ�?";
			$("#listForm input[name='mode']").val("bestCancel");
			$("#listForm input[name='point']").val('<?=$greatPoint?>');
		} else if($("input:radio[name='functionType']:checked").val() == "thanks") {
			confirm_txt = "���޵� ��������Ʈ�� ��� �����Ͻðڽ��ϱ�?";
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
						alert("������ ����:"+data.total+", ����:"+data.success+", ����:"+data.fail+"\n����Ǿ����ϴ�.");
						location.reload();
					} else {
						alert("���� �� ���� �߽��ϴ�.");
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
			alert("����/�˸��� �߼�Ÿ���� ������ �ּ���");
			return;
		}

		if($("input:checkbox[name='hero_idx[]']:checked").length == 0) {
			alert("������ ȸ���� �����ϴ�.");
			return;
		}

		if(confirm("����/�˸����� �߼��Ͻðڽ��ϱ�?")) {
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
							alert("������ ����:"+data.total+", ����:"+data.success+", ����:"+data.fail+"\n����Ǿ����ϴ�.");
						} else {
							alert("���� �� ���� �߽��ϴ�.");
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
                        	
                        