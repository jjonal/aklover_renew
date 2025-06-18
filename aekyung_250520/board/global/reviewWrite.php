<?
if(!defined('_HEROBOARD_'))exit;

if(!$_GET['board']){
	error_historyBack("잘못된 접근입니다.");
	exit;
}

if($_SESSION["global_admin_yn"] != "Y" && !$_SESSION["global_code"]) {
	location("/main/index.php?board=group_04_30&view=noticeList");
	exit;
}

$temp_search = "";
if($_SESSION["global_admin_yn"] != "Y") { //임시 글
	$temp_search = " AND b.hero_temp != '1' ";
}

$action = "";
$level_icon = "";
$hero_nick = "";
if($_GET["hero_idx"]) {
	$action = "edit";

	$sql  = " SELECT b.hero_idx, b.hero_title, b.hero_code, b.hero_command, b.hero_table ";
	$sql .= " , b.hero_today, b.hero_notice,  b.hero_temp, b.hero_pcMobile, m.hero_nick, m.hero_level, m.hero_admin_yn ";
	$sql .= " FROM global_board b ";
	$sql .= " LEFT JOIN global_member m ON b.hero_code = m.hero_code ";
	$sql .= " WHERE b.hero_use_yn = 'Y' AND b.hero_idx = '".$_GET["hero_idx"]."' ".$temp_search;
	
	$res = sql($sql, "on");
	$view = mysql_fetch_assoc($res);
	
	//권한 자신이 작성한 글만 볼 수 있음
	if(($view["hero_code"] != $_SESSION["global_code"]) && $_SESSION["global_admin_yn"] != "Y") {
		error_historyBack("본인이 작성한 글만 접근 가능합니다.");
		exit;
	}
	
	$hero_nick = $view["hero_nick"];
	
	if($view["hero_admin_yn"] == "Y") {
		$level_icon = "/image/bbs/levAdmin01.png";
	} else {
		$level_icon = "/image/bbs/lev_global.png";
	}

	$hero_command = "";
	if($view["hero_pcMobile"] == "M") {
		$hero_command = nl2br($view["hero_command"]);
	} else {
		$hero_command = $view["hero_command"];
	}

} else {
	$action = "write";
	
	if($_SESSION["temp_level"] == "9999") {
		$hero_nick = $_SESSION["temp_nick"];
		$level_icon = "/image/bbs/levAdmin01.png";
	} else {
		$hero_nick = $_SESSION["global_nick"];
		if($_SESSION["global_admin_yn"] == "Y") {
			$level_icon = "/image/bbs/levAdmin01.png";
		} else {
			$level_icon = "/image/bbs/lev_global.png";
		}
	}
}


?>
<form name="searchForm" id="searchForm" method="GET">
<? foreach($_GET as $key=>$val) {?>
<input type="hidden" name="<?=$key?>" value="<?=$val?>" />
<? } ?>
</form>
<div class="contents_area">
	<div class="page_title">
		<div>후기통</div>
		<ul class="nav">
			<li><img src="/image/common/icon_nav_home.gif" alt="home" /></li>
			<li>&gt;</li>
			<li>글로벌 클럽</li>
			<li>&gt;</li>
			<li class="current">후기통</li>
		</ul>
	</div>
	<form name="frm" id="frm" method="POST" enctype="multipart/form-data" action="<?=MAIN_HOME;?>?board=<?=$_GET["board"]?>&view=reviewAction&action=<?=$action?>">
	<input type="hidden" name="hero_table" value="<?=$_GET["board"]?>" />
	<input type="hidden" name="board_code" value="review" />
	<input type="hidden" name="hero_idx" value="<?=$view["hero_idx"]?>" />
	<input type="hidden" name="thumbCount" id="thumbCount" value="0"> 
	<input type="hidden" name="hero_thumb" id="hero_thumb" value=""> 
	<input type="hidden" name="hero_pcMobile" value="P"/>
	<div class="contents">
		<table border="0" cellpadding="0" cellspacing="0" class="bbs_view">
		<colgroup>
			<col width="90px" />
			<col width="*" />
		</colgroup>
		<tbody>
		<tr class="bbshead">
			<th><img src="../image/bbs/tit_subject.gif" alt="제목"></th>
			<td><input type="text" name="hero_title" id="hero_title" class="w590" title="제목" value="<?=$view["hero_title"]?>"></td>
		</tr>
		<tr>
			<th><img src="../image/bbs/tit_writer.gif" alt="작성자"></th>
			<td>
				<img src="<?=$level_icon?>">
				<?=$hero_nick?>
			</td>
		</tr>
		<tr style="display:none">
			<td colspan="2" align="center" valign="top" style="padding-top: 10px; padding-bottom: 10px">
				<div><img src="/image/bbs/guide_thumb.gif" /></div>
				<div style="background: #F2F2F2; margin-bottom: 10px;">
					<div id="thumbnailView" style="width: 680px; height: 105px; overflow-x: hidden; overflow-y: scroll;"></div>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<textarea id="editor" name="hero_command"><?=$hero_command?></textarea>
			</td>
		</tr>
		<tr class="last">
			<th><img src="../image/bbs/tit_file.gif" style="vertical-align: middle;"></th>
			<td><input type="file" id="hero_file" name="hero_file[]" title="첨부파일" value="">
				<p style="color:#f00; letter-spacing:-0.5px;">* jpg, jpeg, gif, png, bmp, zip, hwp, ppt, xls, doc, txt, pdf, xlsx, pptx, docx 파일을 2MB 이하로만 첨부가 가능합니다.</p>
			</td>
		</tr>
		</table>
		 <div class="btngroup">
	 	 	<div class="btn_r">
	 	 		<? if($_SESSION["global_code"]) {?>
		 	 		<? if($view["hero_idx"]) {?>
		 	 			<a href="javascript:;" onclick="javascript:doSubmit(document.frm);" class="a_btn">수정</a>
		 	 		<? } else { ?>
		 	 			<a href="javascript:;" onclick="javascript:doSubmit(document.frm);" class="a_btn">등록</a>
		 	 		<? } ?>
	 	 		<? } ?>
	            <a href="javascript:;" onClick="fnList();" class="a_btn2">취소</a>
	 	 	</div>
		 </div>
	</div>
	</form>
</div>
<script type="text/javascript" src="/loak/loak.js?v=1"></script>
<script type="text/javascript">
    var myeditor = new cheditor();              // 에디터 개체를 생성합니다.
    myeditor.config.editorHeight = '300px';     // 에디터 세로폭입니다.
    myeditor.config.editorWidth = '100%';        // 에디터 가로폭입니다.
 	myeditor.config.oncontextmenu = false; 
	myeditor.inputForm = 'editor';             // textarea의 id 이름입니다. 주의: name 속성 이름이 아닙니다.
	myeditor.run();                             // 에디터를 실행합니다.

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
		
		var cmd_len_check = myeditor.outputBodyText();
        myeditor.outputBodyHTML();
        
        var title = theform.hero_title;
        var cmd = theform.command;

        if(title.value == ""){
            alert("제목을 입력하세요.");
            title.style.border = '1px solid red';
            title.focus();
            return false;
        }else{
            title.style.border = '';
        }
		
		if(cmd_len_check == ""){
	        alert("내용을 입력하세요.");
	        return false;
        }


        if(cmd_len_check.length < 5) {
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

	function showImageInfo() {
	    var data = myeditor.getImages();
	    if (data == null) {
	        alert('올린 이미지가 없습니다.');
	        return;
	    }
	    for (var i=0; i<data.length; i++) {
	        var str = 'URL: ' + data[i].fileUrl + "\n";
	        str += '저장 경로: ' + data[i].filePath + "\n";
	        str += '원본 이름: ' + data[i].origName + "\n";
	        str += '저장 이름: ' + data[i].fileName + "\n";
	        str += '크기: ' + data[i].fileSize;
	        alert(str);
	    }
	}

	$(document).ready(function(){
		fnList = function() {
			$("#searchForm input[name='view']").val("reviewList");
			$("#searchForm").submit();
		}
	});
</script>
