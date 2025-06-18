<!Doctype html>
<?
define('_HEROBOARD_', TRUE);
include_once                                                        '../freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';

$mission_idx = $_GET["mission_idx"];

if($_SESSION["temp_level"] != "9999") {
	message("�̿� ������ �����ϴ�..","");
	exit;
}

//��ϵ� �̼����� ����
$sql_mission_check = " SELECT count(*) cnt FROM mission WHERE hero_idx = '".$mission_idx."' ";
sql($sql_mission_check, "on");
$row_mission = mysql_fetch_array($out_sql);

$mission_cnt = $row_mission["cnt"];

if($mission_cnt < 1) { //�̼��� �������� ������
	message("��������� �̼� ��� �� �̿밡���մϴ�.","");
	exit;
}

$sql_survey_check  = " SELECT count(*) cnt FROM mission_survey WHERE mission_idx = '".$mission_idx."' ";
sql($sql_survey_check);
$row_survey = mysql_fetch_array($out_sql);


$view_sql = "select * from mission where hero_idx=" . $mission_idx;
sql($view_sql,"on");
$view_row = mysql_fetch_array($out_sql);

$template_visibility = false;
if($view_row['hero_table'] == 'group_04_05') {
    if($view_row['hero_type'] == 0) {
        $template_visibility = true;
    } else if($view_row['hero_type'] == 8) {
        $template_visibility = true;
    } else if($view_row['hero_type'] == 5) {
        $template_visibility = true;
    }
} else if($view_row['hero_table'] == 'group_04_06') {
    if($view_row['hero_type'] == 0) {
        $template_visibility = true;
    } else if($view_row['hero_type'] == 9) {
        $template_visibility = true;
    }
} else if($view_row['hero_table'] == 'group_04_28') {
    if($view_row['hero_type'] == 0) {
        $template_visibility = true;
    } else if($view_row['hero_type'] == 9) {
        $template_visibility = true;
    }
}
 
?>
<html>
<head>
<title>�ְ� �������� AKLOVER</title>
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.form.js"></script>
<link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" ></script>
<link rel="stylesheet" type="text/css" href="/css/reset2.css" />
<link rel="stylesheet" type="text/css" href="/css/mission2.css" />
</head>
<body>
<div class="popWrap">
	<div class="popHead">AK LOVER</div>
	<form name="form0" id="form0" method="POST" enctype="multipart/form-data"> 
	<input type="hidden" name="mode" value="insert" />
	<input type="hidden" name="mission_idx" value="<?=$mission_idx?>" />
	<div id="surveyData" class="contents" style="padding:10px 0; border:1px solid #dedede;">
	</div>
	</form>
	
	<div class="btnGroup">
		<a href="javascript:;" onClick="fnFormAdd()" class="btn_l">�����߰�</a>
		<?if($template_visibility) {?>
			<a href="javascript:;" onClick="fnTemplateFormAdd('<?=$mission_idx?>')" class="btn_l" style="margin-left: 10px;">�������׵��</a>
		<?}?>
		<a href="javascript:;" onClick="fnSend()" class="btn_r">���</a>
	</div>
</div>
</body>
</html>
<script>
$(document).ready(function(){
	$("#surveyData").sortable();
    $("#surveyData").disableSelection();
	
})

function fnDelFile(hero_idx) {
	if(confirm("������ ���� �Ͻðڽ��ϱ�?")) {
		var param = "mode=delFile"+"&hero_idx="+hero_idx;
		$.ajax({
				url:"popSurveyProc.php"
				,data:param
				,dataType:"json"
				,type:"POST"
				,success:function(d){
					if(d.result == 1) {
						alert("���� �����Ǿ����ϴ�.");
						location.reload();
					} else {
						alert("������ �����߽��ϴ�.");
					}
 				},error:function(e){
 					console.log(e);
 					alert("�����߽��ϴ�.");
				}
			})
	}
}

function fnDelete(t, hero_idx){
	if(confirm("������ ������ ���� �Ͻðڽ��ϱ�?")) {
		if(hero_idx) {
			var param = "mode=del"+"&hero_idx="+hero_idx;
			$.ajax({
				url:"popSurveyProc.php"
				,data:param
				,dataType:"json"
				,type:"POST"
				,success:function(d){
					if(d.result == 1) {
						var _tableForm = $(t).parents("table");
						_tableForm.remove();
					} else {
						alert("������ �����߽��ϴ�.");
					}
 				},error:function(e){
 					console.log(e);
 					alert("�����߽��ϴ�.");
				}
			})
		} else {
			var _tableForm = $(t).parents("table");
			_tableForm.remove();
		}		
	}
}

function fnEditOPtion(t) {
	var _ui_questionType = $(t).parents("table").find(".ui_questionType");

	var __hero_idx = $(t).parents("table").find("input[name='hero_idx[]']").val();

	if(!__hero_idx) {
		__hero_idx = $(t).parents("table").find("input[name='temp_hero_idx[]']").val();
	}
	
	var html = "";
	if($(t).val() == "1") {
		html = '<textarea></textarea>';
	} else if($(t).val() == "2") {
		html  = '<div class="optionWrap"><a href="javascript:;" onClick="fnOptionAddType2(this)" class="btnDefault">�߰�</a> <span class="txt_ex">(�ִ� 20������ �߰� �����մϴ�.)<span></div>'
		html += '<div><input type="radio"> <input type="text" name="op_'+__hero_idx+'[]" title="�ɼ�" placeholder="�ɼ�" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div>';
		html += '<div><input type="radio"> <input type="text" name="op_'+__hero_idx+'[]" title="�ɼ�" placeholder="�ɼ�" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div>';
		
	} else if($(t).val() == "3") {
		html  = '<div class="optionWrap"><a href="javascript:;" onClick="fnOptionAddType3(this)" class="btnDefault">�߰�</a> <span class="txt_ex">(�ִ� 20������ �߰� �����մϴ�.)<span></div>'
		html += '<div><input type="checkbox"> <input type="text" name="op_'+__hero_idx+'[]" title="�ɼ�" placeholder="�ɼ�" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div>';
		html += '<div><input type="checkbox"> <input type="text" name="op_'+__hero_idx+'[]" title="�ɼ�" placeholder="�ɼ�" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div>';	
	}
	_ui_questionType.html(html); 
}

function fnGetFormData(mission_idx) {
	$.ajax({
		url:"/main/surveyForm.php?mission_idx="+mission_idx
		,type:"get"
		//,contentType:"application/x-www-form-urlencoded; charset=utf-8"
		,dataType:"html"
		,success:function(d){
			$("#surveyData").append(d);
		}
		})	
}

function fnTemplateFormAdd(mission_idx) {
	$.ajax({
		url:"/main/surveyTemplateForm.php?mission_idx="+mission_idx
		,type:"get"
		//,contentType:"application/x-www-form-urlencoded; charset=utf-8"
		,dataType:"html"
		,success:function(d){
			$("#surveyData").append(d);
		}
		})	
}

function fnFormAdd() {
	var temp_hero_idx = Number($("#surveyData  table").length+1);
	
	$.ajax({
			url:"/main/surveyForm.php"
			,type:"get"
			,data:"temp_hero_idx="+temp_hero_idx
			//,contentType:"application/x-www-form-urlencoded; charset=utf-8"
			,dataType:"html"
			,success:function(d){
				console.log(d);
				$("#surveyData").append(d);
				window.scrollTo({top:$(document).height(), left:0, behavior:'auto'});
			}
	})	
}

function fnOptionDel(t){
	$(t).parent("div").remove();
}

function fnOptionAddType2(t) {
	var _ui_questionType = $(t).parents(".ui_questionType");
	var ea = _ui_questionType.find("input[type='radio']").length;
	var input_id = ea+1;
	var __hero_idx = $(t).parents("table").find("input[name='hero_idx[]']").val();

	if(!__hero_idx) {
		__hero_idx = $(t).parents("table").find("input[name='temp_hero_idx[]']").val();
	}

	if(ea < 20) {
		var html = '<div><input type="radio"> <input type="text" name="op_'+__hero_idx+'[]" title="�ɼ�" placeholder="�ɼ�" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div>';
		_ui_questionType.append(html);
	} else {
		alert("�ɼ��� 20������ �߰� �����մϴ�.");
	}
}

function fnOptionAddType3(t) {
	var _ui_questionType = $(t).parents(".ui_questionType");
	var ea = _ui_questionType.find("input[type='checkbox']").length;
	var input_id = ea+1;
	var __hero_idx = $(t).parents("table").find("input[name='hero_idx[]']").val();

	if(!__hero_idx) {
		__hero_idx = $(t).parents("table").find("input[name='temp_hero_idx[]']").val();
	}
	if(ea < 20) {
		var html = '<div><input type="checkbox"> <input type="text" name="op_'+__hero_idx+'[]" title="�ɼ�" placeholder="�ɼ�" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div>';
		_ui_questionType.append(html);
	} else {
		alert("�ɼ��� 20������ �߰� �����մϴ�.");
	}
}

function fnSend(){
	if(confirm("�������縦 ����Ͻðڽ��ϱ�?")) {
		var validCheck = true;
		$("#form0 input[name='mode']").val("insert");
	
		$("#form0 input").each(function(index, item) {
			if(item.title && !item.value) {
				alert(item.title+"�� �Է��� �ּ���.");
				item.focus();
				validCheck = false;
				return false;
			}
		})
		
		$("#form0 textarea").each(function(index, item) {
			if(item.title && !item.value) {
				alert(item.title+"�� �Է��� �ּ���.");
				item.focus();
				validCheck = false;
				return false;
			}
		})
		
		if(!validCheck) return;

		$("input[name='necessary[]']").each(function(index,item){ //���� ��� ����, üũ�ؼ� �����ؾ���
			if(!$(this).is(":checked")) {
				$(this).val("N");
				$(this).prop("checked",true);
			}
		})	
		$("#form0").attr("action","popSurveyProc.php").submit();
	}
	
	/* 
	if(confirm("�������縦 ����Ͻðڽ��ϱ�?")) {
		var frm = $("form[name=form0]");
	
		var options = {
	            url : "./popSurveyProc.php",
	            dataType : 'html',
	            contentType:'application/x-www-form-urlencoded; charset=euc-kr',
	            success :function(d) {
	            	console.log("success");
		           	console.log(d);
	            	if(d.result==1) {
	            		alert("��ϵǾ����ϴ�.");
	            	}
	            }, 
	            error: function(data, result, resultMsg) {
		            console.log("error");
	            	console.log(data);
	            	alert("������ ���� �� ������ �߻��Ͽ����ϴ�.");  
	            }            
	        };
		
		frm.ajaxSubmit(options);
	} */
	
	
}

<? if($row_survey["cnt"] > 0) {?>
fnGetFormData('<?=$mission_idx?>');
<? } ?>
</script>