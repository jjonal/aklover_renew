<? 
if(!defined('_HEROBOARD_'))exit;

if(!strcmp($_GET['type'], 'edit')){
	if($_POST["hero_idx"] &&  $_POST["hero_answer"]) {
		$result = false;
		$answer_sql  = " UPDATE global_board SET hero_answer = '".$_POST["hero_answer"]."', hero_answer_date = now() ";
		$answer_sql .= " WHERE hero_idx = '".$_POST["hero_idx"]."' AND board_code = 'qna' ";
				
		$result = sql($answer_sql);
		
		if($result && $_POST['alrimTalk'] == "Y") {
			$hero_id = $_POST['hero_id'];
			$hero_hp = $_POST['hero_hp'];
			$admin_nick = $_SESSION["temp_nick"];
			
			$alrim_msg = "AK LOVER  글로벌클럽  1:1 문의 건에 대한 답변이 등록되었습니다.
자세한 내용은 글로벌클럽 > 1:1 문의에서 확인 바랍니다";
			
			$subject = "글로벌 고객센터 1:1 문의 답변 안내".$_POST["hero_idx"];
			adminSendAlrimTalk($alrim_msg,$hero_hp,"10017",$subject,$hero_id);
			
		}
		
		if($result) {
			msg($msg.'답변이 등록/수정 되었습니다.','location.href="'.PATH_HOME.'?'.get('type','').'"');
			exit;
		}
	}
} else if(!strcmp($_GET['type'], 'drop')){
	
	$reslut = false;
	$delete_sql = " UPDATE global_board SET hero_use_yn = 'N' WHERE hero_idx = '".$_GET["hero_idx"]."' AND  board_code = 'qna' ";
	$result = sql($delete_sql);
	if($result) {
		msg('삭제 되었습니다.','location.href="'.PATH_HOME.'?'.get('type||hero_idx','').'"');
		exit;
	}
}

$search = "";

if($_GET["answer"]) {
	if($_GET["answer"] == "Y") {
		$search .= " AND (length(b.hero_answer) > 0 || length(b.hero_answer_date) > 0) ";
	} else if($_GET["answer"] == "N") {
		$search .= " AND ((b.hero_answer is null || b.hero_answer = '') && (b.hero_answer_date is null || b.hero_answer_date = '')) ";
	}
}

if($_GET["kewyword"]) {
	$search .= " AND ".$_GET["select"]." LIKE '%".$_GET["kewyword"]."%' ";
}

$total_sql  = " SELECT count(*) cnt FROM global_board b ";
$total_sql .= " LEFT JOIN global_member m ON b.hero_code = m.hero_code ";
$total_sql .= " WHERE b.hero_use_yn = 'Y' AND b.hero_table = 'group_04_30' AND b.board_code = 'qna' ".$search;

sql($total_sql);
$out_res = mysql_fetch_assoc($out_sql);
$total_data = $out_res["cnt"];

$i=$total_data;

$list_page=10;
$page_per_list=10;

if(!strcmp($_GET['page'], ''))		$page = '1';
else								$page = $_GET['page'];

$i = $i-($page-1)*$list_page;

$start = ($page-1)*$list_page;
$next_path=get("page");

$sql  = " SELECT b.hero_idx, b.hero_title, b.hero_file, b.hero_ori_file ";
$sql .= " , b.hero_today, b.hero_command, b.hero_answer, b.hero_answer_date  ";
$sql .= " , m.hero_hp, m.hero_id , m.hero_address_01, m.hero_address_02, m.hero_address_03, m.hero_name, m.hero_nick ";
$sql .= " , m.hero_level, m.hero_country ";
$sql .= " FROM global_board b ";
$sql .= " LEFT JOIN global_member m ON b.hero_code = m.hero_code ";
$sql .= " WHERE b.hero_use_yn = 'Y' AND b.hero_table = 'group_04_30' AND b.board_code = 'qna' ".$search." ORDER BY b.hero_today DESC LIMIT ".$start.",".$list_page;
$list_res = sql($sql);

$country_arr = array("vn"=>"베트남","ru"=>"러시아","cn"=>"중국");

?>
<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
<input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
<input type="hidden" name="board" value="<?=$_GET["board"]?>" />
<table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>답변유무</th>
		<td>
			<input type="radio" name="answer" id="answer_all" value="" <?=!$_GET["answer"] ? "checked":""?> /><label for="answer_all">전체</label>
			<input type="radio" name="answer" id="answer_Y" value="Y" <?=$_GET["answer"]=="Y" ? "checked":""?>/><label for="answer_Y">답변</label>
			<input type="radio" name="answer" id="answer_N" value="N" <?=$_GET["answer"]=="N" ? "checked":""?>/><label for="answer_N">미답변</label>
		</td>
	</tr>
	<tr>
		<th>검색어</th>
		<td>
			 <select name="select">
             	<option value="m.hero_nick"<?if(!strcmp($_REQUEST['select'], 'm.hero_nick')){echo ' selected';}else{echo '';}?>>닉네임</option>
				<option value="m.hero_name"<?if(!strcmp($_REQUEST['select'], 'm.hero_name')){echo ' selected';}else{echo '';}?>>성명</option>
				<option value="b.hero_title"<?if(!strcmp($_REQUEST['select'], 'b.hero_title')){echo ' selected';}else{echo '';}?>>질문</option>
				<option value="b.hero_command"<?if(!strcmp($_REQUEST['select'], 'b.hero_command')){echo ' selected';}else{echo '';}?>>질문내용</option>
				<option value="b.hero_answer"<?if(!strcmp($_REQUEST['select'], 'b.hero_answer')){echo ' selected';}else{echo '';}?>>답변내용</option>
			</select>
	    	<input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];;?>" class="kewyword">		
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">검색</a>
</div>
</form>

<div class="listExplainWrap mgb10">
	<label>총 </label> : <strong><?=number_format($total_data)?></strong>건
</div>

<table class="t_list">
<thead>
<tr>
	<th width="3%">NO</th>
	<th width="6%">국가</th>
	<th width="17%">질문자</th>
	<th width="25%">질문</th>
	<th width="25%">답변</th>
	<th width="7%">설정</th>
</tr>
</thead>
<?
if($total_data > 0) {
	while($list = @mysql_fetch_assoc($out_sql)){
?>
<form name="form_next<?=$i?>" id="form_next<?=$i?>" action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post" enctype="multipart/form-data"> 
<input type="hidden" name="hero_idx" value="<?=$list['hero_idx']?>">
<input type="hidden" name="hero_ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
<input type="hidden" name="hero_id" value="<?=$list['hero_id']?>">
<input type="hidden" name="hero_hp" value="<?=$list['hero_hp']?>">
<tr>
	<td><?=$i?></td>
	<td><?=$country_arr[$list["hero_country"]]?></td>
    <td class="title">
		이름 : <?=$list['hero_name']?><br>
                      닉네임 : <font color="red"><?=$list['hero_nick']?></font><br>
		아이디 : <?=$list['hero_id']?><br>
                     연락처 : <?=$list['hero_hp']?><br><br>
                     주소 : <?=$list['hero_address_01']?><br>
        <?=$list['hero_address_02']?><br>
		<?=$list['hero_address_03']?><br><br>
                     레벨 : <?=$list['hero_level']?><br><br>
                     첨부파일 : <a href="<?=FREEBEST_END?>download.php/freebest/download.php?hero=<?=$list['hero_file']?>&download=<?=$list['hero_ori_file']?>" ><?=$list['hero_ori_file'];?></a>
	</td>
	<td class="question"> 
	         작성일 : <font color="red"><?=$list['hero_today']?></font><br>
                    제목 : <font color="red"><?=$list['hero_title']?></font><br>
       <?=nl2br(htmlspecialchars_decode($list['hero_command']))?>
	</td>
    <td class="title">
    	답변일: <font color="red"><?=$list['hero_answer_date']?></font><br>
    	<textarea name="hero_answer" class="textarea" style="height:200px; margin-top:5px;"><?=$list['hero_answer']?></textarea>
    </td>
    <td>
		<div style="margin:0 0 20px 0;">
			<input type="checkbox" name="alrimTalk" id="alrimTalk<?=$i?>" value="Y" checked/><label for="alrimTalk<?=$i?>">알림톡 전송</label>
		</div>
		<a href="javascript:;" onClick="fnAnswer('form_next<?=$i?>','<?=$i?>')" class="btnFormFunc">답변하기</a>
		<a href="javascript:;" onClick="fnAnswerDel('<?=$list['hero_idx']?>')" class="btnForm">삭제</a>
	</td>
</tr>
</form>
<?
$i--;
}
} else {
?>
<tr>
	<td colspan="6">등록된 데이터가 없습니다.</td>
</tr>
<? } ?>
</table>

<div class="pagingWrap">
<? include_once PATH_INC_END.'page.php';?>
</div>
<script>
function fnSearch() {
	$("#searchForm").attr("action","").submit();
}

function fnAnswer(formName,i) {	
	if($("#alrimTalk"+i).is(":checked")) {
		if(!confirm("알림톡 전송이 체크되어 있습니다. 답변을 전송하시겠습니까?")) {
			return;
		} 
	}

	$("#"+formName).submit();
}

function fnAnswerDel(hero_idx) {
	if(confirm("1:1문의 글을 삭제 하시겠습니까?")) {
		location.href = "<?=PATH_HOME.'?'.get('','type=drop')?>&hero_idx="+hero_idx
	}
}
</script>