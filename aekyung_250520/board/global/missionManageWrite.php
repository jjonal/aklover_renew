<?
if(!defined('_HEROBOARD_'))exit;

if($_SESSION["global_admin_yn"] != "Y") {
	error_historyBack("�����ڸ� ���� �����մϴ�.");
	exit;
}

$action = "";
if($_GET["hero_idx"]) {
	$action = "update";
	
	$sql  = " SELECT hero_idx, hero_thumb , hero_title, hero_title_02, hero_product  ";
	$sql .= " , hero_start_date, hero_end_date, hero_command, hero_media, hero_required ";
	$sql .= " , hero_tag , hero_tag_sub, hero_guide, hero_help, hero_country ";
	$sql .= " , guide_ori_file1, guide_file1, guide_ori_file2, guide_file2 ";
	$sql .= " FROM global_mission ";
	$sql .= " WHERE hero_use_yn = 'Y' AND hero_idx ='".$_GET["hero_idx"]."' ";
	$res = sql($sql, "on");
	$view = mysql_fetch_assoc($res);
	
} else {
	$action = "write";
}
?>
<form name="searchForm" id="searchForm" method="GET">
<? foreach($_GET as $key=>$val) {?>
<input type="hidden" name="<?=$key?>" value="<?=$val?>" />
<? } ?>
</form>
<div class="contents_area">
	<div class="page_title">
		<div>�������� �̼�</div>
		<ul class="nav">
			<li><img src="/image/common/icon_nav_home.gif" alt="home" /></li>
			<li>&gt;</li>
			<li>�۷ι� Ŭ��</li>
			<li>&gt;</li>
			<li class="current">�������� �̼�</li>
		</ul>
	</div>
	
	<div class="contents">
		<div><img src="/image/bbs/guide_thumb.gif"></div>
		<div style="background:#F2F2F2;margin-bottom:10px;">
			<div id="thumbnailView" style="width:680px;height:105px;overflow-x:hidden;overflow-y:scroll;"></div>
		</div>
		<form name="frm" id="form1" method="post" action="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&view=missionManageAction&action=<?=$action?>" enctype="multipart/form-data">
		<input type="hidden" name="hero_idx" id="hero_idx" value="<?=$view["hero_idx"]?>">
		<input type="hidden" name="thumbCount" id="thumbCount" value="0">
		<input type="hidden" name="hero_thumb" id="hero_thumb" value="<?=$view['hero_thumb']?>">
			<span style="color:#F00">�������ε� �ִ������ : 730px(������ 730px�� ��� ���� ���Ұ����մϴ�)</span>
			<div class="spm_img spm_editor">
				<textarea id="editor" name="command"><?=htmlspecialchars_decode($view['hero_command'])?></textarea>
			</div>
			
			<div class="spm_txt spm_mission_box globalMissionManagerBox">
				<dl>
					<dt>
						<span class="bg1">����</span>
					</dt>
					<dd>
						<input type="radio" name="hero_country" id="hero_country_vn" value="vn" <?=$view["hero_country"] == "vn" ? "checked":"";?>/><label for="hero_country_vn">��Ʈ��</label>
						<input type="radio" name="hero_country" id="hero_country_ru" value="ru" <?=$view["hero_country"] == "ru" ? "checked":"";?>/><label for="hero_country_ru">���þ�</label>
						<input type="radio" name="hero_country" id="hero_country_cn" value="cn" <?=$view["hero_country"] == "cn" ? "checked":"";?>/><label for="hero_country_cn">�߱�</label>
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1">����</span>
					</dt>
					<dd>
						<input type="text" id="hero_title" name="hero_title" value="<?=$view["hero_title"]?>" />
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1">����</span>
					</dt>
					<dd>
						<input type="text" id="hero_title_02" name="hero_title_02" value="<?=$view["hero_title_02"]?>" />
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1">�̼���ǰ</span>
					</dt>
					<dd>
						<input type="text" id="hero_product" name="hero_product" value="<?=$view["hero_product"]?>" />
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1"><span>�ʼ��̼�</span></span>
					</dt>
					<dd>
                        <textarea id="hero_required" name="hero_required" style="height:150px"><?=$view['hero_required']?></textarea>
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1"><span>�ʼ� �±�</span></span>
					</dt>
					<dd>
						<p>�ʼ� �±�</p>
						<input type="text" id="hero_tag" name="hero_tag" value="<?=$view['hero_tag']?>" style="width:550px; height:23px; margin:5px 0 0 0;" />
						<p style="margin:10px 0 0 0;">���� �±�</p>
						<input type="text" id="hero_tag_sub" name="hero_tag_sub" value="<?=$view['hero_tag_sub']?>" style="width:550px; height:23px; margin:5px 0 0 0;" />	
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1">ü��� �ȳ�</span>
					</dt>
					<dd style="width:705px">
						<textarea name="hero_guide" id="editor3" class="textarea" style="width: 600px; height: 150px; display: none;"><?=htmlspecialchars_decode($view['hero_guide']);?></textarea>
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1">������ ���̵�</span>
					</dt>
					<dd>
						<textarea name="hero_help" id="hero_help" class="textarea" style="height: 150px;"><?=$view["hero_help"];?></textarea>
					</dd>
				</dl>
				<dl>
                	<dt style="width:705px">
                    	<span class="bg1">ü��� ��û����</span>(��ü��ܿ��� �ݿ��˴ϴ�)
                    </dt>
					<dd style="width:705px;">
						<textarea name="hero_media" id="editor2" class="textarea" style="width:600px; height: 150px;"><?=$view['hero_media'];?></textarea>
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1">�̼ǱⰣ</span>
					</dt>
					<dd>
						<input type="text" name="hero_start_date" id="sdate1" style="width:150px;" value="<?=$view["hero_start_date"]?>"/>
						<input type="text" name="hero_end_date" id="edate1" style="width:150px;" value="<?=$view["hero_end_date"]?>"/>
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1">���̵����(1)</span>
					</dt>
					<dd>
						<input type="file" name="guideFile1" />(20MB ����) <?=$view["guide_ori_file1"]?>
						<? if($view["guide_ori_file1"]) {?>
						<br/><?=$view["guide_ori_file1"]?> <input type="checkbox" name="delGuideFile1" value="Y" /> <span style="color:#F00">(���� �� üũ�� �ּ���)</span>
						<? } ?>
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1">���̵����(2)</span>
					</dt>
					<dd> 
						<input type="file" name="guideFile2" />(20MB ����) <?=$view["guide_ori_file2"]?>
						<? if($view["guide_ori_file2"]) {?>
						<br/><?=$view["guide_ori_file2"]?> <input type="checkbox" name="delGuideFile2" value="Y" /> <span style="color:#F00">(���� �� üũ�� �ּ���)</span>
						<? } ?>
					</dd>
				</dl>
				<div style="clear:both;"></div>
				
				<div class="btngroup tc mt20">
					<? if($action == "write") { ?>
						<a href="javascript:;" onclick="javascript:return doSubmit(frm);" class="a_btn">���</a>
					<? } else if($action == "update") { ?>
						<a href="javascript:;" onclick="javascript:return doSubmit(frm);" class="a_btn">����</a>
					<? } ?>
	                <a href="javascript:;" onClick="fnList();" class="a_btn2">���</a>
				</div>
			</div>
		</form>
	</div>
</div>
<link type='text/css' href='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.css' rel='stylesheet' />
<script type="text/javascript" src="<?=DOMAIN_END?>cal/jquery.min.js"></script>
<script type='text/javascript' src='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.min.js'></script> 
<script type="text/javascript" src="/loak/loak.js?v=1"></script>
<script>
var myeditor = new cheditor();             
myeditor.config.editorHeight = '300px';     
myeditor.config.editorWidth = '100%';       
myeditor.inputForm = 'editor';             
myeditor.run(); 

var myeditor2 = new cheditor();              
myeditor2.config.editorHeight = '300px';    
myeditor2.config.editorWidth = '100%';       
myeditor2.inputForm = 'editor2';             
myeditor2.run(); 

var myeditor3 = new cheditor();              
myeditor3.config.editorHeight = '300px';    
myeditor3.config.editorWidth = '100%';       
myeditor3.inputForm = 'editor3';             
myeditor3.run(); 

function doSubmit(theform){
	myeditor.outputBodyHTML();
	myeditor2.outputBodyHTML();
	myeditor3.outputBodyHTML();

	if(!$("input:radio[name='hero_country']:checked")) {
		alert("������ ������ �ּ���.");
		return;
	}

	if(!$("input[name='hero_title']").val()) {
		alert("������ �Է��� �ּ���.");
		return;
	}

	if(!$("input[name='hero_start_date']").val() || !$("input[name='hero_end_date']").val()) {
		alert("�̼ǱⰣ�� �Է��� �ּ���.");
		return;
	}

	theform.submit();
	return false;
}

var dates = jQuery("#sdate1, #edate1").datepicker({
    monthNames: ['�� 1��','�� 2��','�� 3��','�� 4��','�� 5��','�� 6��','�� 7��','�� 8��','�� 9��','�� 10��','�� 11��','�� 12��'],
    dayNamesMin: ['��', '��', 'ȭ', '��', '��', '��', '��'],
    defaultDate: null,
    showMonthAfterYear:true,
    dateFormat: 'yy-mm-dd',
    onSelect: function( selectedDate ) {
        var option = this.id == "sdate1" ? "minDate" : "maxDate",
        instance = jQuery( this ).data( "datepicker" ),
        date = jQuery.datepicker.parseDate(
            instance.settings.dateFormat ||
            jQuery.datepicker._defaults.dateFormat,
            selectedDate, instance.settings );
        dates.not( this ).datepicker( "option", option, date );
    }
});

function showImageInfo() {
    var data = myeditor.getImages();
    if (data == null) {
        alert('�ø� �̹����� �����ϴ�.');
        return;
    }
    for (var i=0; i<data.length; i++) {
        var str = 'URL: ' + data[i].fileUrl + "\n";
        str += '���� ���: ' + data[i].filePath + "\n";
        str += '���� �̸�: ' + data[i].origName + "\n";
        str += '���� �̸�: ' + data[i].fileName + "\n";
        str += 'ũ��: ' + data[i].fileSize;
        alert(str);
    }
}

$(document).ready(function(){
	fnList = function() {
		$("#searchForm input[name='view']").val("missionList");
		$("#searchForm").submit();
	}
});
</script>
