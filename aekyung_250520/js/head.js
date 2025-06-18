function add_file(name){
    var new_div = document.createElement('div');
        new_div.innerHTML = '<input type="file" name="' + name + '">';
    var view_dir = document.getElementById('uploads')
        view_dir.appendChild(new_div);//alert(new_div.innerHTML);//document.write(new_div.innerHTML);
}
ajax = false;
    if(window.XMLHttpRequest){// IE이외
        ajax = new XMLHttpRequest();
    }else if(window.ActiveXObject){// IE용 
        try{ajax = new ActiveXObject('Msxml2.XMLHTTP');
    }catch(e){
        ajax = new ActiveXObject('Microsoft.XMLHTTP');
    }
}
function getData(serverURL, objID){
	var input_id = document.getElementById('login_id').value;
	var input_pw = document.getElementById('login_pw').value;
	var input_check = document.getElementById('logout_check').value;
	var queryString = 'login_id=' + input_id + '&login_pw=' + input_pw + '&logout_check=' + input_check;
	    ajax.open('POST', serverURL);
	    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	    ajax.send(queryString);
	
	    document.getElementById('login_id').value='';
	    document.getElementById('login_id').focus();//    login_form.login_id.focus()
	    document.getElementById('login_pw').value='';
	    ajax.onreadystatechange = function(){
	    	if (ajax.readyState == 4 && ajax.status == 200){
	            var obj = document.getElementById(objID);
	            obj.innerHTML = ajax.responseText;
	            location.reload();
	        }
	    }
}  
function hero_ajax(serverURL, objID, inputID, type){
	var input = document.getElementById(inputID);
	//alert(input);
	// console.log(input);
	//var input = $('#'+inputID).val()
	if(trim(input.value)==''){
		return false;
	}
	var queryString = 'input_chat=' + input.value + '&type=' + type;
	var finaldata;
    $.ajax({      
        type:"POST",  
        url:serverURL,      
        data:queryString, 
        async: false,
        success:function(args){
        		var obj = document.getElementById(objID);
                obj.innerHTML = args;
            
        }
    });
    
}

function hero_ajax4(serverURL, objID, inputID, type){
	var input = encodeURIComponent(document.getElementById(inputID).value);
	var queryString = 'input_chat=' + input + '&type=' + type;
	    ajax.open('POST', serverURL);
	    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	    ajax.send(queryString);

	    ajax.onreadystatechange = function(){
	        if (ajax.readyState == 4 && ajax.status == 200){
	            var obj = document.getElementById(objID);
	            obj.value = ajax.responseText;
	        }
	    }
	}

function hero_ajax5(serverURL, objID, inputID, type){
	var input = document.getElementById(inputID);
	var queryString = 'input_chat=' + input.value + '&type=' + type;
    $.ajax({      
        type:"POST",  
        url:serverURL,      
        data:queryString,      
        success:function(args){
            var obj = document.getElementById(objID);
            obj.innerHTML = args;
    		location.reload();
        }
    });  
}

function msg(msg,command){
    alert(msg);
    command;
}

function hero_review(serverURL, objID, inputID, type, modeID){
var input = encodeURIComponent(document.getElementById(inputID).value);
var mode = document.getElementById(modeID).value;
var queryString = 'input_chat=' + input + '&type=' + type + '&mode=' + mode;
    ajax.open('POST', serverURL);
    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ajax.send(queryString);
    ajax.onreadystatechange = function(){
        if (ajax.readyState == 4 && ajax.status == 200){
            var obj = document.getElementById(objID);
            obj.innerHTML = ajax.responseText;
        }
    }
}

function hero_review_end(serverURL, objID, inputID, type, modeID, hero_save_ID, hero_save_id_old){
	var input = encodeURIComponent(document.getElementById(inputID).value);
	var mode = document.getElementById(modeID).value;
	var save_ID = document.getElementById(hero_save_ID).value;
	var save_id_old = document.getElementById(hero_save_id_old).value;
	var queryString = 'input_chat=' + input + '&type=' + type + '&mode=' + mode + '&save_id=' + save_ID + '&save_id_old=' + save_id_old;

	$.ajax({      
	        type:"POST",  
	        url:serverURL,      
	        data:queryString,      
	        success:function(args){ 
	        	alert(args);
	            var obj = document.getElementById(objID);
	            obj.innerHTML = args;
	        }
	    });  
}

function find_IdPw(serverURL, objID, obj_01_ID, obj_02_ID, obj_03_ID, type){
	var obj_01 = encodeURIComponent(document.getElementById(obj_01_ID).value);
	var obj_02 = document.getElementById(obj_02_ID).value;
	var obj_03 = document.getElementById(obj_03_ID).value;
	var queryString = "";

	queryString = '01=' + obj_01 + '&02=' + obj_02 + '&03=' + obj_03 + '&type=' + type;

    ajax.open('POST', serverURL);
    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ajax.send(queryString);

    if(type == 'id'){ //아이디 찾기
        ajax.onreadystatechange = function(){
            if (ajax.readyState == 4 && ajax.status == 200){
                $(".find_IdPw").removeClass("dis-no"); //팝업 노출
                let find_id = ajax.responseText;

                if(find_id != ''){ //아이디 있음
                    $(".find_id").removeClass("dis-no"); //아이디 일치 노출
                    $(".idinfo.t_c.fz20.fw600").text(find_id);
                }else { //아이디 없음
                    $(".no_find_id").removeClass("dis-no"); //아이디 불일치 노출
                }
                return false;
            }
        }
    }
    else { //비밀번호 찾기
        ajax.onreadystatechange = function(){
            if (ajax.readyState == 4 && ajax.status == 200){
                alert(ajax.responseText);
                return false;
            }
        }
    }
}

function hero_review2(serverURL, objID, obj_01_ID, obj_02_ID, obj_03_ID, type){
var obj_01 = encodeURIComponent(document.getElementById(obj_01_ID).value);
var obj_02 = document.getElementById(obj_02_ID).value;
var obj_03 = document.getElementById(obj_03_ID).value;
var queryString = '01=' + obj_01 + '&02=' + obj_02 + '&03=' + obj_03 + '&type=' + type;
    ajax.open('POST', serverURL);
    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ajax.send(queryString);
    ajax.onreadystatechange = function(){
        if (ajax.readyState == 4 && ajax.status == 200){
            var obj = document.getElementById(objID);
            obj.innerHTML = ajax.responseText;
        }
    }
}

function hero_layer(inputID, par){
    var div = document.getElementById(inputID);
    div.style.display='block';
    div.innerHTML = '<img name="hero" src="' + par + '" style="cursor:pointer;" onclick="javascript:hero_close(\'' + inputID + '\');"  />';
    var img_width = document.images['hero'].width;
    var img_height = document.images['hero'].height;
    x = (document.body.clientWidth - img_width) / 2;
    y = (document.body.clientHeight - img_height) /2;
    div.style.top = y + "px";
    div.style.left = x + "px";
}
function hero_layer2(inputID, par){
    var div = document.getElementById(inputID);
    div.style.display='block';
    div.innerHTML = '<img name="hero" src="' + par + '" style="cursor:pointer;" onclick="javascript:hero_close(\'' + inputID + '\');"  />';
    var img_width = document.images['hero'].width;
    var img_height = document.images['hero'].height;
    x = (document.offsetWidth - img_width) / 2;
    y = (document.offsetHeight - img_height) /2;
    div.style.top = y + "px";
    div.style.left = x + "px";
}
function hero_close(closeID){
    var div=document.getElementById(closeID);
    div.innerHTML='';
    div.style.top = '0px';
    div.style.left = '0px';
    div.style.display='none';
}
function allCheck(check, name){
	$("input:checkbox[name='"+name+"']").each(function(){
		this.checked = check;
	});
}

