


///////////////////////////////////////////////    모바일 댓글     /////////////////////////////////////////////////////////////						
						
	function hero_review_end_m(serverURL, objID, inputID, type, modeID, hero_save_ID, hero_save_id_old){
		var input = encodeURIComponent(document.getElementById(inputID).value);
		var mode = document.getElementById(modeID).value;
		var save_ID = document.getElementById(hero_save_ID).value;
		var save_id_old = document.getElementById(hero_save_id_old).value;
		var queryString = 'input_chat=' + input + '&type=' + type + '&mode=' + mode + '&save_id=' + save_ID + '&save_id_old=' + save_id_old;
		    ajax.open('POST', serverURL);
		    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');						    ajax.send(queryString);
						
		    ajax.onreadystatechange = function(){
		        if (ajax.readyState == 4 && ajax.status == 200){
		            /*var obj = document.getElementById(objID);
		            obj.innerHTML = ajax.responseText;*/
		            alert('완료 되었습니다.');
		            location.reload();
		            return false;
		        }
		    }
		}

	function hero_ajax_m(serverURL, objID, inputID, type){
		/*var input = document.getElementById(inputID);*/
		var queryString = 'type=' + type;
	    ajax.open('POST', serverURL);
	    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	    ajax.send(queryString);


	    ajax.onreadystatechange = function(){
	    	if (ajax.readyState == 4 && ajax.status == 200){
	    		var obj = document.getElementById(objID);
	    		obj.innerHTML = ajax.responseText;
	    		location.reload();
	    	}
	    }
	}