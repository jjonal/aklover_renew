<!DOCTYPE html>
<?
header("Content-Type:text/html; charset=EUC-KR");
include_once "head.php";
//phpinfo();

//���� json ������ ����, DB ����
//� json ������ �ȱ���, DB ����
?>
<title>aklover</title>
<head>
<meta charset="EUC-KR">
</head>
<body>
<form name="form0" id="form0" method="POST">
<input type="text" name="id" />
<a href="javascript:;" onClick="fnTest()">���ڵ� �׽�Ʈ</a>

<div class="joinColumnGroup">
	<label><span>*</span>�г���</label>
	<input type="text" name="hero_nick" id="hero_nick_02" onkeyup="ch_nick(this);"/>
	<span id="ch_nick_text"></span>
	<p class="txt_emphasis mgt5">�� AK LOVER �г����� �߿��� Ȱ�� ��ҷ� ������ �Ұ��Ͽ���, �����ϰ� �ۼ����ּ���.</p>
	
	
	<input type="text" name="hero_user" id="hero_user" onfocusout="ch_hero_user(this);" />
	<span id="ch_hero_user_text" class="mgt5"></span>
</div>
</form>
<script>
$(document).ready(function(){
	console.log("ready");
})
function fnTest(){
	console.log("���ڵ� �׽�Ʈ");
	//$("#form0").attr("action","test_action.php").submit();

	$.ajax({
			url:"test_action.php"
			,data:$("#form0").serialize()
			,type:"POST"
			,dataType:"html"
			,success:function(d) {
				console.log("success");
				console.log(d);
			},error:function(e) {
				console.log("error");
				console.log(e);
			}
		}) 
}

function ch_nick(obj){
	var nick_alert_area = $(obj).next("span");
	var blank_pattern = /[\s]/g;
	if( blank_pattern.test($(obj).val()) == true){
	    alert('������ ����� �� �����ϴ�.');
	    $(obj).val("");
	    $(obj).focus();
	    return false;
	}
			
	if(trim($(obj).val())==''){
		nick_alert_area.html("�г����� �Է��� �ּ���.");
		return false;
	}else{
		hero_ajax_2222('/m/zip_action.php', 'ch_nick_text', 'hero_nick_02', 'nick'); 
		return false;
	}
}

function hero_ajax_2222(serverURL, objID, inputID, type){
	var input = document.getElementById(inputID);
	//alert(input);
	console.log(input);
	//var input = $('#'+inputID).val()
	if(trim(input.value)==''){
		return false;
	}
	//var queryString = 'input_chat=' + input.value + '&type=' + type;
	var queryString = 'input=' + input.value + '&type=' + type;

	var finaldata;
    $.ajax({      
        type:"POST",  
        url:serverURL,      
        data:queryString, 
        async: false,
        success:function(args){
            console.log(args);
        		//var obj = document.getElementById(objID);
                //obj.innerHTML = args;
            
        }
    });
    
}

function ch_hero_user(obj) {

	var queryString = "type=hero_user";
	queryString += "&hero_user_type=hero_nick";
	queryString += "&hero_user="+obj.value;


	$.ajax({      
        type:"POST",  
        url:"/m/zip_action.php",      
        data:queryString, 
        async: false,
        success:function(args){
            console.log(args);
        		//var obj = document.getElementById(objID);
                //obj.innerHTML = args;
            
        }
    });

}
</script>
</body>
</html>