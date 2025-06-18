<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/anytime.5.1.2.css">
<script src="<?=ADMIN_DEFAULT?>/js/anytime.5.1.2.js"></script>	
<script type="text/javascript" src="/loak/loak.js"></script>	
<?
if(!defined('_HEROBOARD_'))exit;

$table = 'popup';
if(!strcmp($_GET['type'], 'edit')){
    $drop_check = explode('||', $_POST['hero_drop']);
    while(list($drop_key, $drop_val) = each($drop_check)){
        unset($_POST[$drop_val]);
    }
    @reset($_POST);
    $data_i = '1';
    $count = @count($_POST);
    while(list($post_key, $post_val) = each($_POST)){
        if(!strcmp($post_key, 'hero_idx')){
            $idx = $_POST[$post_key];
            $data_i++;
            continue;
        }
        if(!strcmp($count, $data_i)){
            $comma = '';
        }else{
            $comma = ', ';
        }
        $sql_one_update .= $post_key.'=\''.$_POST[$post_key].'\''.$comma;
    $data_i++;
    }
    $sql = 'UPDATE '.$table.' SET '.$sql_one_update.' WHERE hero_idx = \''.$idx.'\';'.PHP_EOL;
    mysql_query($sql);
    msg('수정 되었습니다.','location.href="'.PATH_HOME.'?'.get('type','').'"');
    exit;
} else if(!strcmp($_GET['type'], 'drop')){
    $sql = 'DELETE FROM '.$table.' WHERE hero_idx = \''.$_GET['hero_idx'].'\';';
    mysql_query($sql);
    msg('삭제 되었습니다.','location.href="'.PATH_HOME.'?'.get('type||hero_idx','').'"');
}
$popup_sql = 'select * from popup where hero_idx=\''.$_REQUEST['hero_idx'].'\';';//desc<=
$out_popup_sql = mysql_query($popup_sql);
$popup_list                             = @mysql_fetch_assoc($out_popup_sql);
?>
<form method="post" name="form_next" onsubmit="return doSubmit(this)">
<input type="hidden" name="hero_drop" value="hero_drop||inputWidth||inputAlt||inputCaption">
<input type="hidden" name="hero_idx" value="<?=$popup_list['hero_idx']?>">
<table class="t_view">
<colgroup>
	<col width="150" />
	<col width="*" />
</colgroup>
<tr>
	<th>가로위치</th>
	<td><input type="text" name="hero_width_point" value="<?=$popup_list['hero_width_point']?>" style="width:200px"/> 예 : 100</td>
</tr>
<tr>
	<th>세로위치</th>
	<td><input type="text" name="hero_height_point" value="<?=$popup_list['hero_height_point']?>" style="width:200px"/> 예 : 100</td>
</tr>
<tr>
	<th>폭</th>
	<td><input type="text" name="hero_width" value="<?=$popup_list['hero_width']?>" style="width:200px;"/> 예 : 700</td>
</tr>
<tr>
	<th>높이</th>
	<td><input type="text" name="hero_height" value="<?=$popup_list['hero_height']?>" style="width:200px;"/> 예 : 500</td>
</tr>
<tr>
	<th>링크</th>
	<td><input type="text" name="hero_href" value="<?=$popup_list['hero_href']?>"/></td>
</tr>
<tr>
	<th>노출시간</th>
	<td><input type="text" name="hero_startdate" id="sdate" value="<?=$popup_list['hero_startdate']?>" style="width:140px;"/> ~
		<input type="text" name="hero_enddate" id="edate" value="<?=$popup_list['hero_enddate']?>" style="width:140px;"/>
		<a href="javascript:;" onclick="$('#sdate').val('');$('#edate').val('');" class="btnForm">초기화</a>
	</td>
</tr>
<tr>
	<th>내용</th>
	<td><textarea id="fm_post" name="hero_command"><?=$popup_list['hero_command']?></textarea></td>
</tr>
</table>
</form>
<div class="btnGroup">
	<div class="l"><a href="javascript:;" class="btnList" onClick="location.href='<?=PATH_HOME.'?'.get('type||view||hero_idx','')?>'">목록</a></div>
	<div class="r"><a href="javascript:;" class="btnAdd" onClick="doSubmit(form_next)">수정</a></div>
</div>
<script>
$(function(){
	$("#sdate").AnyTime_picker( {
		format: "%Y-%m-%d %H:%i:00"
	});
    $("#edate").AnyTime_picker( {
		format: "%Y-%m-%d %H:%i:00"
    }); 
});
</script>
<script type="text/javascript">
function doSubmit(theform){
	myeditor.outputBodyHTML();
    theform.action = "<?=PATH_HOME.'?'.get('type','type=edit')?>";
    theform.submit();
	return false;
}

function showImageInfo() {
	var data = myeditor.getImages();
	if(data == null){
		alert('올린 이미지가 없습니다.');
		return;
	}

	for(var i=0; i<data.length; i++) {
		var str = 'URL: ' + data[i].fileUrl + "\n";
 			str += '저장 경로: ' + data[i].filePath + "\n";
			str += '원본 이름: ' + data[i].origName + "\n";
			str += '저장 이름: ' + data[i].fileName + "\n";
			str += '크기: ' + data[i].fileSize;
			alert(str);
	}
}
</script>
<script type="text/javascript">
	var myeditor = new cheditor();              // 에디터 개체를 생성합니다.
	myeditor.config.editorHeight = '400px';     // 에디터 세로폭입니다.
	myeditor.config.editorWidth = '100%';        // 에디터 가로폭입니다.
	myeditor.inputForm = 'fm_post';             // textarea의 id 이름입니다. 주의: name 속성 이름이 아닙니다.
	myeditor.run();                             // 에디터를 실행합니다.
</script>