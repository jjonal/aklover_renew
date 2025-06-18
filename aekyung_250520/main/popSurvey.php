<!Doctype html>
<?
define('_HEROBOARD_', TRUE);
include_once                                                        '../freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';

$mission_idx = $_GET["mission_idx"];

if($_SESSION["temp_level"] != "9999") {
	message("이용 권한이 없습니다..","");
	exit;
}

//등록된 미션인지 검증
$sql_mission_check = " SELECT count(*) cnt FROM mission WHERE hero_idx = '".$mission_idx."' ";
sql($sql_mission_check, "on");
$row_mission = mysql_fetch_array($out_sql);

$mission_cnt = $row_mission["cnt"];

if($mission_cnt < 1) { //미션이 존재하지 않으면
	message("설문조사는 미션 등록 후 이용가능합니다.","");
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
<title>애경 서포터즈 AKLOVER</title>
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
		<a href="javascript:;" onClick="fnFormAdd()" class="btn_l">문항추가</a>
		<?if($template_visibility) {?>
			<a href="javascript:;" onClick="fnTemplateFormAdd('<?=$mission_idx?>')" class="btn_l" style="margin-left: 10px;">사전문항등록</a>
		<?}?>
		<a href="javascript:;" onClick="fnSend()" class="btn_r">등록</a>
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
	if(confirm("파일을 삭제 하시겠습니까?")) {
		var param = "mode=delFile"+"&hero_idx="+hero_idx;
		$.ajax({
				url:"popSurveyProc.php"
				,data:param
				,dataType:"json"
				,type:"POST"
				,success:function(d){
					if(d.result == 1) {
						alert("파일 삭제되었습니다.");
						location.reload();
					} else {
						alert("실행중 실패했습니다.");
					}
 				},error:function(e){
 					console.log(e);
 					alert("실패했습니다.");
				}
			})
	}
}

function fnDelete(t, hero_idx){
	if(confirm("선택한 문항을 삭제 하시겠습니까?")) {
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
						alert("실행중 실패했습니다.");
					}
 				},error:function(e){
 					console.log(e);
 					alert("실패했습니다.");
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
		html  = '<div class="optionWrap"><a href="javascript:;" onClick="fnOptionAddType2(this)" class="btnDefault">추가</a> <span class="txt_ex">(최대 20개까지 추가 가능합니다.)<span></div>'
		html += '<div><input type="radio"> <input type="text" name="op_'+__hero_idx+'[]" title="옵션" placeholder="옵션" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div>';
		html += '<div><input type="radio"> <input type="text" name="op_'+__hero_idx+'[]" title="옵션" placeholder="옵션" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div>';
		
	} else if($(t).val() == "3") {
		html  = '<div class="optionWrap"><a href="javascript:;" onClick="fnOptionAddType3(this)" class="btnDefault">추가</a> <span class="txt_ex">(최대 20개까지 추가 가능합니다.)<span></div>'
		html += '<div><input type="checkbox"> <input type="text" name="op_'+__hero_idx+'[]" title="옵션" placeholder="옵션" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div>';
		html += '<div><input type="checkbox"> <input type="text" name="op_'+__hero_idx+'[]" title="옵션" placeholder="옵션" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div>';	
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
		var html = '<div><input type="radio"> <input type="text" name="op_'+__hero_idx+'[]" title="옵션" placeholder="옵션" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div>';
		_ui_questionType.append(html);
	} else {
		alert("옵션은 20개까지 추가 가능합니다.");
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
		var html = '<div><input type="checkbox"> <input type="text" name="op_'+__hero_idx+'[]" title="옵션" placeholder="옵션" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div>';
		_ui_questionType.append(html);
	} else {
		alert("옵션은 20개까지 추가 가능합니다.");
	}
}

function fnSend(){
	if(confirm("설문조사를 등록하시겠습니까?")) {
		var validCheck = true;
		$("#form0 input[name='mode']").val("insert");
	
		$("#form0 input").each(function(index, item) {
			if(item.title && !item.value) {
				alert(item.title+"을 입력해 주세요.");
				item.focus();
				validCheck = false;
				return false;
			}
		})
		
		$("#form0 textarea").each(function(index, item) {
			if(item.title && !item.value) {
				alert(item.title+"을 입력해 주세요.");
				item.focus();
				validCheck = false;
				return false;
			}
		})
		
		if(!validCheck) return;

		$("input[name='necessary[]']").each(function(index,item){ //값이 없어도 생성, 체크해서 전송해야함
			if(!$(this).is(":checked")) {
				$(this).val("N");
				$(this).prop("checked",true);
			}
		})	
		$("#form0").attr("action","popSurveyProc.php").submit();
	}
	
	/* 
	if(confirm("설문조사를 등록하시겠습니까?")) {
		var frm = $("form[name=form0]");
	
		var options = {
	            url : "./popSurveyProc.php",
	            dataType : 'html',
	            contentType:'application/x-www-form-urlencoded; charset=euc-kr',
	            success :function(d) {
	            	console.log("success");
		           	console.log(d);
	            	if(d.result==1) {
	            		alert("등록되었습니다.");
	            	}
	            }, 
	            error: function(data, result, resultMsg) {
		            console.log("error");
	            	console.log(data);
	            	alert("데이터 전송 중 오류가 발생하였습니다.");  
	            }            
	        };
		
		frm.ajaxSubmit(options);
	} */
	
	
}

<? if($row_survey["cnt"] > 0) {?>
fnGetFormData('<?=$mission_idx?>');
<? } ?>
</script>