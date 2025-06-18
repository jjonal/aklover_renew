<?
include_once "head.php";
if(!$_GET['board']){
	error_historyBack("잘못된 접근입니다");
	exit;
}

$error = "WRTIE_01";
$pk_sql = "select * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$_GET['board']."'";//desc
$pk_res = new_sql($pk_sql,$error,"on");

if((string)$pk_res==$error){
	error_historyBack("");
	exit;
}

$right_list = mysql_fetch_assoc($pk_res);
if($right_list['hero_write']>$_SESSION['temp_level'] || !$_SESSION['temp_level']){
	error_historyBack("권한이 없습니다");
	exit;
}

//21-05-28 로얄권한 추가
if($_GET['board'] == "group_04_29") {
	$loyal_auth = false; //작성권한
	$loyal_auth_sql  = " SELECT COUNT(*) cnt FROM member_loyal ";
	$loyal_auth_sql .= " WHERE hero_code = '".$_SESSION["temp_code"]."' AND date_format(CONCAT(gisu_year, gisu_month,'01'),'%Y%m%d') < '".date("Ym")."01"."' ";
	$loyal_auth_sql .= " AND  date_format(date_add(date_format(CONCAT(gisu_year, gisu_month,'01'),'%Y%m%d'), INTERVAL 7 MONTH),'%Y%m%d') > '".date("Ym")."01"."' ";
	$loyal_auth_res = sql($loyal_auth_sql);
	$loyal_auth_rs = mysql_fetch_assoc($loyal_auth_res);

	if($loyal_auth_rs["cnt"] > 0) $loyal_auth = true; //등록 기수(기간) 6개월까지 게시판 이용 가능

	if(!$loyal_auth && $_SESSION['temp_level'] < 9999) {
		msg('Loyal AKLOVER 권한이 없습니다.','location.href="/m/loyalAkLover.php?board=group_04_29"');exit;
	}
}

$idx = $_GET['idx'];
$board = $_GET['board'];
$page = $_GET['page'];

if($_GET['idx'])		$action = "update";
else					$action = "write";

$code = $_SESSION['temp_code'];
$name = $_SESSION['temp_name'];
$nick = $_SESSION['temp_nick'];
$level = $_SESSION['temp_level'];
$today = date("Y-m-d H:i:s");

if($action=='update'){
	$error = "WRTIE_02";
	$sql = "select A.*, B.hero_code, B.hero_nick, B.hero_name from board as A left outer join member as B on A.hero_code=B.hero_code where A.hero_table = '".$board."' and A.hero_idx='".$idx."'";
	$sql_res = new_sql($sql, $error);

	if((string)$sql_res==$error){
		error_historyBack("");
		exit;
	}

	$sql_rs = mysql_fetch_assoc($sql_res);
	if($sql_rs['hero_pcMobile']!='M'){  
		error_historyBack("모바일에서는 모바일에서 등록한 글만 수정할 수 있습니다");
		exit;
	}
	
	$code = $sql_rs['hero_code'];
	$name = $sql_rs['hero_name'];
	$nick = $sql_rs['hero_nick'];
	$today = $sql_rs['hero_today'];
	$hero_command = htmlspecialchars_decode($sql_rs['hero_command']);
	$hero_command = explode("<br class='Mobile'/><br /><br /><div style='text-align:center;'>",$hero_command);
	$command = str_replace("<br />","",$hero_command[0]);
	$command = str_replace("<br class='Mobile' /><div style= 'text-align:center;' ></div>","",$command);
	$hero_images = str_ireplace ( "</div>", "", $hero_command[1] );
	$hero_images = explode("<br /><br />",$hero_images);		
}
?>
<!--컨텐츠 시작-->
<? if($_GET["board"] == "group_04_03" || $_GET["board"] == "cus_2" || $_GET["board"] == "cus_3") { ?>     
	<?include_once "cscenter.php"?> 
<? } else if($_GET["board"] == "group_02_02"){ //lover_talk?>
	<? include_once "talk_top.php"; ?>
<? } else {  
	include_once "boardIntroduce.php"; 
} ?>

<div class="write_cont"> 
<form name="frm" class="form-horizontal" role="form" enctype="multipart/form-data" method="post" action="action.php?board=<?=$board;?>&action=<?=$action?>&idx=<?=$idx;?>&page=<?=$page;?>">
<input type="hidden" name="hero_drop" value="hero_drop||command||chkbox||image_temp||$hero_thumb"/>
<input type="hidden" name="hero_code" value="<?=$code;?>"/>
<input type="hidden" name="hero_review" value="<?=$code;?>"/>
<input type="hidden" name="hero_today" value="<?=$today;?>"/>
<input type="hidden" name="hero_ip" value="<?=$_SERVER['REMOTE_ADDR']?>"/>
<input type="hidden" name="hero_name" value="<?=$name;?>"/>
<input type="hidden" name="hero_pcMobile" value="M"/>
<input type="hidden" name="hero_table" value="<?=$board;?>">
<input type="hidden" name="hero_notice" value="1">
<div class="form-group">
	<div class="tit">		
		<input type="text" name="hero_title" id="hero_title" title="제목" value="<?=$sql_rs['hero_title'];?>" class="fz28" autocomplete="off" placeholder="제목을 입력하세요."/>
	</div>
</div>
<div class="form-group">
	<!-- <label class="col-sm-2 control-label" for="hero_nick">작성자</label> -->
	<div class="col-sm-10">		
		<!-- <input type="text" name="hero_nick" id="hero_nick" title="작성자" value="<?=$nick;?>" readonly class="form-control"/> -->
		<?if($_SESSION['temp_level']>=9999){?>
			<?if($board=="group_02_02"){?>
				<div class="input_chk"><input type="checkbox" name="hero_notice_use" id="hero_notice_use" value="1" <?=$sql_rs['hero_notice_use'] == "1" ? "checked":"";?> />
				<label for="hero_notice_use" class="input_chk_label">Lover 톡 공지</label></div>
			<?}?>
		<?}?>
	</div>
</div>
<? if($_GET["board"]=='group_02_02'){//수다통?>
<div class="form-group">
	<p class="list_tit fz28 bold">카테고리</p>
	<div class="col-sm-10">	
		<select name="gubun" class="wr_select">
			<option value="">선택해주세요.</option>
			<option value='1' <?=($sql_rs['gubun']==1)?"selected='selected'":""?>>일상</option>
			<option value='2' <?=($sql_rs['gubun']==2)?"selected='selected'":""?>>체험단</option>
			<option value='3' <?=($sql_rs['gubun']==3)?"selected='selected'":""?>>제안</option>
		</select>
	</div>
</div>
<? } else if($_GET["board"]=='group_04_24'){ ?>
<div class="form-group">
	<p class="list_tit fz28 bold">카테고리</p>
	<div class="col-sm-10">	
		<select name="hero_keywords" class="wr_select">
			<option value="">선택해주세요.</option>
			<option value='1' <?=($sql_rs['hero_keywords']==1)?"selected='selected'":""?>>리뷰</option>
			<option value='2' <?=($sql_rs['hero_keywords']==2)?"selected='selected'":""?>>활동</option>
			<option value='3' <?=($sql_rs['hero_keywords']==3)?"selected='selected'":""?>>리뷰 TIP</option>
			<option value='4' <?=($sql_rs['hero_keywords']==4)?"selected='selected'":""?>>매체 TIP</option>
		</select>
	</div>
</div>
<div class="form-group">
	<p class="list_tit fz28 bold">카테고리</p>
	<div class="col-sm-10">	
		<select name="gubun" class="wr_select">
			<option value="">선택해주세요.</option>
			<option value='1' <?=($sql_rs['gubun']==1)?"selected='selected'":""?>>필독</option>
			<option value='2' <?=($sql_rs['gubun']==2)?"selected='selected'":""?>>블로그</option>
			<option value='3' <?=($sql_rs['gubun']==3)?"selected='selected'":""?>>인스타</option>
			<option value='4' <?=($sql_rs['gubun']==4)?"selected='selected'":""?>>유튜브&영상</option>
		</select>
	</div>
</div>
<? } else if($_GET["board"]=='cus_3'){ ?>
<div class="form-group">
	<p class="list_tit fz28 bold">카테고리</p>
	<div class="col-sm-10">	
		<select name="gubun" class="wr_select">
			<option value="">선택해주세요.</option>
			<option value='1' <?=($sql_rs['gubun']==1)?"selected='selected'":""?>>체험단 문의</option>
			<option value='2' <?=($sql_rs['gubun']==2)?"selected='selected'":""?>>체험단 후기수정</option>
			<option value='3' <?=($sql_rs['gubun']==3)?"selected='selected'":""?>>홈페이지 문의</option>
			<option value='4' <?=($sql_rs['gubun']==4)?"selected='selected'":""?>>기타</option>
		</select>
	</div>
</div>
<? } ?>
<div class="form-group">
	<label class="fz28 bold" for="command">내용</label>
	<div class="textarea_wrap">	
		<textarea class="form-control" rows="10" name="command"><?=$command?></textarea>	
	</div>
</div>	
<? if($_GET["board"]!="cus_3" && $_GET["board"]!="group_04_29") {?>
<div class="upfile f_cs">
	<p class="list_tit fz28 fw500">대표이미지</p>
	<div class="col-sm-10">
		<?
			if($hero_images[0]){
				echo $hero_images[0];
				echo "<input type='hidden' name='image_temp[]' value='".htmlentities($hero_images[0],ENT_QUOTES)."' accept='image/*'>";
			}
		?>
		<div class="upfile_inner rel">			
			<input type="file" id="hero_board_one" name="hero_image[]" accept="image/*">	
			<label for="hero_board_one" class="custom-file-upload">파일선택<img src="/img/front/icon/fileup.webp" alt="첨부파일 업로드"></label>
		</div>	
	</div>
</div>
<div class="upfile f_cs">
	<p class="list_tit fz28 fw500">사진2</p>
	<div class="col-sm-10">	
		<?
			if($hero_images[1]){
				echo $hero_images[1];
				echo "<input type='hidden' name='image_temp[]' value='".htmlentities($hero_images[1],ENT_QUOTES)."' accept='image/*'>";
			}
		?>	
		<div class="upfile_inner rel">
			<input type="file" id="hero_board_two" name="hero_image[]" accept="image/*">	
			<label for="hero_board_two" class="custom-file-upload">파일선택<img src="/img/front/icon/fileup.webp" alt="첨부파일 업로드"></label>
		</div>
	</div>                               
</div>
<div class="upfile f_cs">
	<p class="list_tit fz28 fw500">사진3</p>
	<div class="col-sm-10">	
		<?
			if($hero_images[2]){
				echo $hero_images[2];
				echo "<input type='hidden' name='image_temp[]' value='".htmlentities($hero_images[2],ENT_QUOTES)."' accept='image/*'>";
			}
		?>
		<div class="upfile_inner rel">
			<input type="file" id="hero_board_three" name="hero_image[]" accept="image/*">	
			<label for="hero_board_three" class="custom-file-upload">파일선택<img src="/img/front/icon/fileup.webp" alt="첨부파일 업로드"></label>
		</div>
	</div>
</div>	
<div class="warn">                                        
	<p class="fz26 op05">* jpg, jpeg, gif, png, bmp, zip, hwp, ppt, xls, doc, txt, pdf, xlsx, pptx, docx 파일을 2MB 이하로만 첨부가 가능합니다.</p>
	<p class="fz26 op05">* 첨부된 파일은 전체 이용자가 다운로드 받을 수 있으니 주의하시기 바랍니다.</p>
</div>  
<? } ?>	
<? if($_GET["board"] == "cus_3") {?>
<div class="upfile f_cs">
	<p class="list_tit fz28 fw500">첨부파일</p>
	<div class="col-sm-10">	
		<p><?=$sql_rs['hero_board_two']?></p>
		<div class="upfile_inner rel">
			<input type="file" id="hero_board_one" name="hero_board_one[]" title="첨부파일" />
			<label for="hero_board_one" class="custom-file-upload">파일선택<img src="/img/front/icon/fileup.webp" alt="첨부파일 업로드"></label>
		</div>
	</div>
</div>
<div class="warn">                                        
	<p class="fz26 op05">* jpg, jpeg, gif, png, bmp, zip, hwp, ppt, xls, doc, txt, pdf, xlsx, pptx, docx 파일을 2MB 이하로만 첨부가 가능합니다.</p>
	<p class="fz26 op05">* 첨부된 파일은 전체 이용자가 다운로드 받을 수 있으니 주의하시기 바랍니다.</p>
</div>  
<? } ?>

<?if( (!strcmp($_REQUEST['board'], 'group_04_05')) or (!strcmp($_REQUEST['board'], 'group_04_06')) or (!strcmp($_REQUEST['board'], 'group_04_07')) or (!strcmp($_REQUEST['board'], 'group_04_08')) or (!strcmp($_REQUEST['board'], 'group_04_09')) or (!strcmp($_REQUEST['board'], 'group_04_27')) or (!strcmp($_REQUEST['board'], 'group_04_28'))){?>
<div class="form-group">
	<p class="list_tit fz28 bold">URL</p>	
	<div class="warn">                                        
		<p class="fz26 op05">*URL은 한줄에 하나씩 전체 주소(HTTP:// 또는 HTTPS://)를 넣어주세요</p>
	</div> 
	<div class="col-sm-10">				
		<div class="textarea_wrap">	
			<textarea id="hero_04" name="hero_04" class="form-control"/><?=$out_row['hero_04'];?></textarea>
		</div>
	</div>
</div> 
<?}?>		
<div class="write_btn_wrap">
	<button type="button" class="btn btn_cancle" onclick="history.go(-1);">취소하기</button>
	<? if($_GET['idx']) {?>
		<button type="button" class="btn btn_submit" onclick="doSubmit(this.form);">수정하기</button>
	<? } else { ?>
		<button type="button" class="btn btn_submit" onclick="doSubmit(this.form);">등록하기</button>
	<? } ?>
</div>	
</form>
</div>
<div class="clear"></div>
<script type="text/javascript">

$("#hero_board_one").change(function(){
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


    function doSubmit (theform){
        var title = theform.hero_title;
        var name = theform.hero_nick;
        var cmd = theform.command;
        var text = cmd.value.trim().replace(/\n/g,"");

        if(title.value == ""){
            alert("제목을 입력하세요.");
            title.style.border = '1px solid red';
            title.focus();
            return false;
        }else{
            title.style.border = '';
        }

        <? if($board=="group_02_02" || $board=="group_04_24" || $board=="cus_3") { ?>
		if(!$("select[name='gubun']").val()) {
			alert("카테고리를 선택해주세요.");
			return false;
		}
    	<? } ?>
    	
		if(cmd.value == ""){
	        alert("내용을 입력하세요.");
	        cmd.focus();
	        return false;
        }

		if(text.length < 5) {
			alert("5글자 미만의 글을 작성 불가합니다.");
			return false;
		}

		if($("input:file[name='hero_board_one[]']")) {
			if($("input:file[name='hero_board_one[]']").val()) {
				var filename = $("input:file[name='hero_board_one[]']").val();
				var flieLen = filename.length;
				var lastDot = filename.lastIndexOf('.');
				var fileExt = filename.substring(lastDot+1, flieLen).toLowerCase();
				var maxSize = 2 * 1024 * 1024

				//var filesize = document.getElementById("hero_board_one[]").files[0].size;
				//var filesize = document.frm.hero_board_one.files[0].size;
				//console.log(filesize);


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
<link href="css/musign/board.css" rel="stylesheet" type="text/css">
<link href="css/musign/cscenter.css" rel="stylesheet" type="text/css">	
<?include_once "tail.php";?>