<?
include_once "head.php";

if(!$_GET['board']){
	error_historyBack("잘못된 접근입니다.");
	exit;
}

if(!$_SESSION["global_code"]) {
	location("/m/globalNoticeList.php?board=group_04_30");
	exit;
}

$temp_search = "";
if($_SESSION["global_admin_yn"] != "Y") { //임시 글
	$temp_search = " AND b.hero_temp != '1' ";
}

$action = "";
if($_GET["hero_idx"]) {
	$action = "edit";

	$sql  = " SELECT b.hero_idx, b.hero_title, b.hero_code, b.hero_command, b.hero_table ";
	$sql .= " , b.hero_today, b.hero_notice,  b.hero_temp, b.hero_pcMobile ";
	$sql .= " , m.hero_nick, m.hero_level, m.hero_admin_yn ";
	$sql .= " FROM global_board b ";
	$sql .= " LEFT JOIN global_member m ON b.hero_code = m.hero_code ";
	$sql .= " WHERE b.hero_use_yn = 'Y' AND b.hero_idx = '".$_GET["hero_idx"]."' ".$temp_search;
	
	$res = sql($sql, "on");
	$view = mysql_fetch_assoc($res);
	
	$hero_nick = $view["hero_nick"];
	
	//권한 자신이 작성한 글만 볼 수 있음
	if(($view["hero_code"] != $_SESSION["global_code"]) && $_SESSION["global_admin_yn"] != "Y") {
		error_historyBack("본인이 작성한 글만 접근 가능합니다.");
		exit;
	}
	
	if($view['hero_pcMobile']!='M'){
		error_historyBack("모바일에서는 모바일에서 등록한 글만 수정할 수 있습니다");
		exit;
	}
	
	$hero_command = htmlspecialchars_decode($view['hero_command']);
	$hero_command = explode("<br class='Mobile'/><br /><br /><div style='text-align:center;'>",$hero_command);
	$command = str_replace("<br />","\n",$hero_command[0]);
	$command = str_replace("<br class='Mobile' /><div style= 'text-align:center;' ></div>","",$command);
} else {
	$action = "write";
	
	if($_SESSION["temp_level"] == "9999") {
		$hero_nick = $_SESSION["temp_nick"];
	} else {
		$hero_nick = $_SESSION["global_nick"];
	}
}
?>
<link href="css/general.css?v=1" rel="stylesheet" type="text/css">
<form name="searchForm" id="searchForm" method="GET">
<? foreach($_GET as $key=>$val) {?>
<input type="hidden" name="<?=$key?>" value="<?=$val?>" />
<? } ?>
</form>
<!--컨텐츠 시작-->
<div class="introTxtWrap">
	<div class="title ">|&nbsp;&nbsp;후기통</div> 
    <div class="content" style="width:calc(100% - 60px)">애경의 생활 제품을 직접 체험하고 다양한 소식을 전하는 Global Club 회원 여러분만을 위한 공간입니다.</div>
</div>
<div class="writeWrap"> 
<form name="frm" class="form-horizontal" role="form" enctype="multipart/form-data" method="post" action="globalReviewAction.php?board=<?=$_GET["board"];?>&action=<?=$action?>&page=<?=$page;?>">
<input type="hidden" name="hero_table" value="<?=$_GET["board"]?>">
<input type="hidden" name="board_code" value="review" />
<input type="hidden" name="hero_pcMobile" value="M"/>
<input type="hidden" name="hero_idx" value="<?=$view["hero_idx"]?>" />
<div class="form-group">
	<label class="col-sm-2 control-label" for="hero_title">제목</label>
	<div class="col-sm-10">		
		<input type="text" name="hero_title" id="hero_title" title="제목" value="<?=$view['hero_title'];?>" class="form-control" autocomplete="off" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="hero_nick">작성자</label>
	<div class="col-sm-10">		
		<input type="text" name="hero_nick" id="hero_nick" title="작성자" value="<?=$hero_nick;?>" readonly class="form-control"/>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-2 control-label" for="command">내용</label>
	<div class="col-sm-10">	
		<textarea class="form-control" rows="10" name="hero_command"><?=$command?></textarea>	
	</div>
</div>	


<div class="form-group mWriteImage">
	<label class="col-sm-2 control-label" style="margin-bottom:5px;">파일</label>
	<div class="col-sm-10">	
		<p><?=$view['hero_ori_file']?></p>
		<input type="file" id="hero_file" name="hero_file[]" title="첨부파일" />
		<p style="color:#f00; letter-spacing:-0.5px; margin:5px 0 0 0; line-height:18px;">* jpg, jpeg, gif, png, bmp, zip, hwp, ppt, xls, doc, txt, pdf, xlsx, pptx, docx 파일을 2MB 이하로만 첨부가 가능합니다.</p>
	</div>
</div>
	
<div class="form-actions">
	<button type="button" class="btn btn-warning" onclick="fnList()">취소</button>
	<? if($view["hero_idx"]) {?>
		<button type="button" class="btn btn-primary" onclick="doSubmit(this.form);">수정</button>
	<? } else { ?>
		<button type="button" class="btn btn-primary" onclick="doSubmit(this.form);">등록</button>
	<? } ?>
</div>	
</form>
</div>
<div class="clear"></div>
<script type="text/javascript">
function fnList() {
	$("#searchForm").attr("action","globalReviewList.php").submit();	
}

$("#hero_file").change(function(){
	var file = this;
	var filename = $(this).val();
	var maxSize  = 2 * 1024 * 1024    //2MB
	var fileSize = 0;
	var browser=navigator.appName;

	// 익스플로러일 경우
	if (browser=="Microsoft Internet Explorer") {
		var oas = new ActiveXObject("Scripting.FileSystemObject");
		fileSize = oas.getFile( filename ).size;
	} else {
		fileSize = file.files[0].size;
	}

	if(maxSize < fileSize) {
		alert("이미지 용량초과입니다.\n2MB이하로 업로드를 진행해 주세요.");
		$(this).val("");
		return false;
	}
})

function doSubmit(theform){
	var title = theform.hero_title;
	var name = theform.hero_nick;
	var cmd = theform.hero_command;
	var text = cmd.value.trim().replace(/\n/g,"");

	if(title.value == ""){
		alert("제목을 입력하세요.");
		title.style.border = '1px solid red';
		title.focus();
		return false;
	} else {
		title.style.border = '';
	}

	if(cmd.value == ""){
		alert("내용을 입력하세요.");
		cmd.focus();
		return false;
	}

	if(text.length < 5) {
		alert("5글자 미만의 글을 작성 불가합니다.");
		return false;
	}

	if($("input:file[name='hero_file[]']")) {
		if($("input:file[name='hero_file[]']").val()) {
			var filename = $("input:file[name='hero_file[]']").val();
			var flieLen = filename.length;
			var lastDot = filename.lastIndexOf('.');
			var fileExt = filename.substring(lastDot+1, flieLen).toLowerCase();
			var maxSize = 2 * 1024 * 1024
	
			var extArr = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'zip', 'hwp', 'ppt', 'xls', 'doc', 'txt', 'pdf', 'xlsx', 'pptx', 'docx'];
			var checkExt = false;
			for(var i = 0; i < extArr.length; i++) {
			    if(fileExt == extArr[i]) checkExt = true;
			}
	
			if(!checkExt) {
				alert("첨부파일 확장자를 확인해주세요");
				return;	
			}
		}
	}
        
	theform.submit();
	return false;
}
</script>
<!--컨텐츠 종료-->
<?include_once "tail.php";?>