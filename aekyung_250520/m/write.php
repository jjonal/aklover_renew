<?
include_once "head.php";
if(!$_GET['board']){
	error_historyBack("�߸��� �����Դϴ�");
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
	error_historyBack("������ �����ϴ�");
	exit;
}

//21-05-28 �ξ���� �߰�
if($_GET['board'] == "group_04_29") {
	$loyal_auth = false; //�ۼ�����
	$loyal_auth_sql  = " SELECT COUNT(*) cnt FROM member_loyal ";
	$loyal_auth_sql .= " WHERE hero_code = '".$_SESSION["temp_code"]."' AND date_format(CONCAT(gisu_year, gisu_month,'01'),'%Y%m%d') < '".date("Ym")."01"."' ";
	$loyal_auth_sql .= " AND  date_format(date_add(date_format(CONCAT(gisu_year, gisu_month,'01'),'%Y%m%d'), INTERVAL 7 MONTH),'%Y%m%d') > '".date("Ym")."01"."' ";
	$loyal_auth_res = sql($loyal_auth_sql);
	$loyal_auth_rs = mysql_fetch_assoc($loyal_auth_res);

	if($loyal_auth_rs["cnt"] > 0) $loyal_auth = true; //��� ���(�Ⱓ) 6�������� �Խ��� �̿� ����

	if(!$loyal_auth && $_SESSION['temp_level'] < 9999) {
		msg('Loyal AKLOVER ������ �����ϴ�.','location.href="/m/loyalAkLover.php?board=group_04_29"');exit;
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
		error_historyBack("����Ͽ����� ����Ͽ��� ����� �۸� ������ �� �ֽ��ϴ�");
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
<!--������ ����-->
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
		<input type="text" name="hero_title" id="hero_title" title="����" value="<?=$sql_rs['hero_title'];?>" class="fz28" autocomplete="off" placeholder="������ �Է��ϼ���."/>
	</div>
</div>
<div class="form-group">
	<!-- <label class="col-sm-2 control-label" for="hero_nick">�ۼ���</label> -->
	<div class="col-sm-10">		
		<!-- <input type="text" name="hero_nick" id="hero_nick" title="�ۼ���" value="<?=$nick;?>" readonly class="form-control"/> -->
		<?if($_SESSION['temp_level']>=9999){?>
			<?if($board=="group_02_02"){?>
				<div class="input_chk"><input type="checkbox" name="hero_notice_use" id="hero_notice_use" value="1" <?=$sql_rs['hero_notice_use'] == "1" ? "checked":"";?> />
				<label for="hero_notice_use" class="input_chk_label">Lover �� ����</label></div>
			<?}?>
		<?}?>
	</div>
</div>
<? if($_GET["board"]=='group_02_02'){//������?>
<div class="form-group">
	<p class="list_tit fz28 bold">ī�װ�</p>
	<div class="col-sm-10">	
		<select name="gubun" class="wr_select">
			<option value="">�������ּ���.</option>
			<option value='1' <?=($sql_rs['gubun']==1)?"selected='selected'":""?>>�ϻ�</option>
			<option value='2' <?=($sql_rs['gubun']==2)?"selected='selected'":""?>>ü���</option>
			<option value='3' <?=($sql_rs['gubun']==3)?"selected='selected'":""?>>����</option>
		</select>
	</div>
</div>
<? } else if($_GET["board"]=='group_04_24'){ ?>
<div class="form-group">
	<p class="list_tit fz28 bold">ī�װ�</p>
	<div class="col-sm-10">	
		<select name="hero_keywords" class="wr_select">
			<option value="">�������ּ���.</option>
			<option value='1' <?=($sql_rs['hero_keywords']==1)?"selected='selected'":""?>>����</option>
			<option value='2' <?=($sql_rs['hero_keywords']==2)?"selected='selected'":""?>>Ȱ��</option>
			<option value='3' <?=($sql_rs['hero_keywords']==3)?"selected='selected'":""?>>���� TIP</option>
			<option value='4' <?=($sql_rs['hero_keywords']==4)?"selected='selected'":""?>>��ü TIP</option>
		</select>
	</div>
</div>
<div class="form-group">
	<p class="list_tit fz28 bold">ī�װ�</p>
	<div class="col-sm-10">	
		<select name="gubun" class="wr_select">
			<option value="">�������ּ���.</option>
			<option value='1' <?=($sql_rs['gubun']==1)?"selected='selected'":""?>>�ʵ�</option>
			<option value='2' <?=($sql_rs['gubun']==2)?"selected='selected'":""?>>��α�</option>
			<option value='3' <?=($sql_rs['gubun']==3)?"selected='selected'":""?>>�ν�Ÿ</option>
			<option value='4' <?=($sql_rs['gubun']==4)?"selected='selected'":""?>>��Ʃ��&����</option>
		</select>
	</div>
</div>
<? } else if($_GET["board"]=='cus_3'){ ?>
<div class="form-group">
	<p class="list_tit fz28 bold">ī�װ�</p>
	<div class="col-sm-10">	
		<select name="gubun" class="wr_select">
			<option value="">�������ּ���.</option>
			<option value='1' <?=($sql_rs['gubun']==1)?"selected='selected'":""?>>ü��� ����</option>
			<option value='2' <?=($sql_rs['gubun']==2)?"selected='selected'":""?>>ü��� �ı����</option>
			<option value='3' <?=($sql_rs['gubun']==3)?"selected='selected'":""?>>Ȩ������ ����</option>
			<option value='4' <?=($sql_rs['gubun']==4)?"selected='selected'":""?>>��Ÿ</option>
		</select>
	</div>
</div>
<? } ?>
<div class="form-group">
	<label class="fz28 bold" for="command">����</label>
	<div class="textarea_wrap">	
		<textarea class="form-control" rows="10" name="command"><?=$command?></textarea>	
	</div>
</div>	
<? if($_GET["board"]!="cus_3" && $_GET["board"]!="group_04_29") {?>
<div class="upfile f_cs">
	<p class="list_tit fz28 fw500">��ǥ�̹���</p>
	<div class="col-sm-10">
		<?
			if($hero_images[0]){
				echo $hero_images[0];
				echo "<input type='hidden' name='image_temp[]' value='".htmlentities($hero_images[0],ENT_QUOTES)."' accept='image/*'>";
			}
		?>
		<div class="upfile_inner rel">			
			<input type="file" id="hero_board_one" name="hero_image[]" accept="image/*">	
			<label for="hero_board_one" class="custom-file-upload">���ϼ���<img src="/img/front/icon/fileup.webp" alt="÷������ ���ε�"></label>
		</div>	
	</div>
</div>
<div class="upfile f_cs">
	<p class="list_tit fz28 fw500">����2</p>
	<div class="col-sm-10">	
		<?
			if($hero_images[1]){
				echo $hero_images[1];
				echo "<input type='hidden' name='image_temp[]' value='".htmlentities($hero_images[1],ENT_QUOTES)."' accept='image/*'>";
			}
		?>	
		<div class="upfile_inner rel">
			<input type="file" id="hero_board_two" name="hero_image[]" accept="image/*">	
			<label for="hero_board_two" class="custom-file-upload">���ϼ���<img src="/img/front/icon/fileup.webp" alt="÷������ ���ε�"></label>
		</div>
	</div>                               
</div>
<div class="upfile f_cs">
	<p class="list_tit fz28 fw500">����3</p>
	<div class="col-sm-10">	
		<?
			if($hero_images[2]){
				echo $hero_images[2];
				echo "<input type='hidden' name='image_temp[]' value='".htmlentities($hero_images[2],ENT_QUOTES)."' accept='image/*'>";
			}
		?>
		<div class="upfile_inner rel">
			<input type="file" id="hero_board_three" name="hero_image[]" accept="image/*">	
			<label for="hero_board_three" class="custom-file-upload">���ϼ���<img src="/img/front/icon/fileup.webp" alt="÷������ ���ε�"></label>
		</div>
	</div>
</div>	
<div class="warn">                                        
	<p class="fz26 op05">* jpg, jpeg, gif, png, bmp, zip, hwp, ppt, xls, doc, txt, pdf, xlsx, pptx, docx ������ 2MB ���Ϸθ� ÷�ΰ� �����մϴ�.</p>
	<p class="fz26 op05">* ÷�ε� ������ ��ü �̿��ڰ� �ٿ�ε� ���� �� ������ �����Ͻñ� �ٶ��ϴ�.</p>
</div>  
<? } ?>	
<? if($_GET["board"] == "cus_3") {?>
<div class="upfile f_cs">
	<p class="list_tit fz28 fw500">÷������</p>
	<div class="col-sm-10">	
		<p><?=$sql_rs['hero_board_two']?></p>
		<div class="upfile_inner rel">
			<input type="file" id="hero_board_one" name="hero_board_one[]" title="÷������" />
			<label for="hero_board_one" class="custom-file-upload">���ϼ���<img src="/img/front/icon/fileup.webp" alt="÷������ ���ε�"></label>
		</div>
	</div>
</div>
<div class="warn">                                        
	<p class="fz26 op05">* jpg, jpeg, gif, png, bmp, zip, hwp, ppt, xls, doc, txt, pdf, xlsx, pptx, docx ������ 2MB ���Ϸθ� ÷�ΰ� �����մϴ�.</p>
	<p class="fz26 op05">* ÷�ε� ������ ��ü �̿��ڰ� �ٿ�ε� ���� �� ������ �����Ͻñ� �ٶ��ϴ�.</p>
</div>  
<? } ?>

<?if( (!strcmp($_REQUEST['board'], 'group_04_05')) or (!strcmp($_REQUEST['board'], 'group_04_06')) or (!strcmp($_REQUEST['board'], 'group_04_07')) or (!strcmp($_REQUEST['board'], 'group_04_08')) or (!strcmp($_REQUEST['board'], 'group_04_09')) or (!strcmp($_REQUEST['board'], 'group_04_27')) or (!strcmp($_REQUEST['board'], 'group_04_28'))){?>
<div class="form-group">
	<p class="list_tit fz28 bold">URL</p>	
	<div class="warn">                                        
		<p class="fz26 op05">*URL�� ���ٿ� �ϳ��� ��ü �ּ�(HTTP:// �Ǵ� HTTPS://)�� �־��ּ���</p>
	</div> 
	<div class="col-sm-10">				
		<div class="textarea_wrap">	
			<textarea id="hero_04" name="hero_04" class="form-control"/><?=$out_row['hero_04'];?></textarea>
		</div>
	</div>
</div> 
<?}?>		
<div class="write_btn_wrap">
	<button type="button" class="btn btn_cancle" onclick="history.go(-1);">����ϱ�</button>
	<? if($_GET['idx']) {?>
		<button type="button" class="btn btn_submit" onclick="doSubmit(this.form);">�����ϱ�</button>
	<? } else { ?>
		<button type="button" class="btn btn_submit" onclick="doSubmit(this.form);">����ϱ�</button>
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

	// �ͽ��÷η��� ���
	if (browser=="Microsoft Internet Explorer") {
		var oas = new ActiveXObject("Scripting.FileSystemObject");
		fileSize = oas.getFile( filename ).size;
	} else {
		fileSize = file.files[0].size;
	}

	if(maxSize < fileSize) {
		alert("�̹��� �뷮�ʰ��Դϴ�.\n2MB���Ϸ� ���ε带 ������ �ּ���.");
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
            alert("������ �Է��ϼ���.");
            title.style.border = '1px solid red';
            title.focus();
            return false;
        }else{
            title.style.border = '';
        }

        <? if($board=="group_02_02" || $board=="group_04_24" || $board=="cus_3") { ?>
		if(!$("select[name='gubun']").val()) {
			alert("ī�װ��� �������ּ���.");
			return false;
		}
    	<? } ?>
    	
		if(cmd.value == ""){
	        alert("������ �Է��ϼ���.");
	        cmd.focus();
	        return false;
        }

		if(text.length < 5) {
			alert("5���� �̸��� ���� �ۼ� �Ұ��մϴ�.");
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
					alert("÷������ Ȯ���ڸ� Ȯ�����ּ���");
					return;	
				}
			}
		}
        
        theform.submit();
        return false;
    }
</script>
<!--������ ����-->
<link href="css/musign/board.css" rel="stylesheet" type="text/css">
<link href="css/musign/cscenter.css" rel="stylesheet" type="text/css">	
<?include_once "tail.php";?>