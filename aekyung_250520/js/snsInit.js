//TODO �׽�Ʈ Ű Ȯ��
//�
var naver = {
	client_id : "D_sIq_99IKhzGve9N28N",
	client_secret : "w8bAFHLHRN",
	redirect_uri : location.href
};

//�׽�Ʈ
// var naver = {
// 	client_id : "EqDbPAFJg1yrwvTDaLX_",
// 	client_secret : "jWE0XJsxYS",
// 	redirect_uri : location.href
// };

//musign �׽�Ʈ
// var naver = {
// 	client_id : "OLFcd5sE0JYjmwJqZQtY",
// 	client_secret : "JDVrqiJt7i",
// 	redirect_uri : location.href
// };
  
	$(function() {
		  try {
			  if (Kakao) {
			  	  Kakao.init('6c3fae05e5032f2c1649eb3840dfba75'); //�
				  // Kakao.init('414ca7b8ce5710f0b275056c10013f7a'); //����
				  // Kakao.init('646bfa3ea2b08de3b003a7879454abfe'); //musign �׽�Ʈ
			  };
		  } catch(e) {
			  
		  };
	});

    function loginKakao(from){ // �α��� â�� ���ϴ�.
        Kakao.Auth.login({
      	  success: function(authObj) {
      	      // �α��� ������, API�� ȣ���մϴ�.
      	      Kakao.API.request({
      	        url: '/v2/user/me',
      	        success: function(res) {
      	        	$(".img-loading").css("display","block");
      				snsType = "kakaoTalk";
      				where = from;
      				afterLogin.login(res);
      	        },
      	        fail: function(error) {
      	          alert("īī���� ���� �����Դϴ�. �ٽ� �õ����ּ���.");
      	          location.reload();
      	          $(".img-loading").css("display","none");
      	          return false;
      	        }
      	      });
      	    },
          fail: function(err) {
        	console.log(err);
          	alert("īī���� ���� �����Դϴ�. �ٽ� �õ��� �ּ���.");
          	$(".img-loading").css("display","none");

          	Kakao.Auth.logout();
          	Kakao.API.cleanup();
          	location.reload();
	        return false;
          }
        });
      };

//naver
      
   // �Ʒ� ������ ������ ���Ϳ��� ���ø����̼� ����� ���� �߱� ���� �� �ֽ��ϴ�.




	  
      $(document).ready(function(){
		  /*
		  var naver_id_login = new naver_id_login(naver.client_id, naver.redirect_uri);
		  console.log("tt");
		  console.log(naver_id_login);
		  */
		  
    	  var state = $.cookie("state_token");
    	  //alert(naver.checkAuthorizeState(state));
    	  if(typeof state != "undefined"){
	    	  if(naver.checkAuthorizeState(state) === "connected") {
	    		  where = $.cookie("where");
	    		  checkLoginState();
	    		  $.removeCookie("state_token");
	    	  }
    	  }
      });
      
      function generateState() {
    		// CSRF ������ ���� state token ���� �ڵ�
    		// state token�� ���� ������ ���� ���ǿ� ���� �Ǿ�� �մϴ�.
    		var oDate = new Date();
    		return oDate.getTime();
    	}
    	function saveState(state,from) {
    		$.removeCookie("state_token");
    		$.cookie("state_token", state);
    		$.cookie("where", from);
    	}
    	
    	function loginNaver(from) {
    		/*
			var state = generateState();
    		saveState(state,from);
			naver.login(state+"&svctype=0");
			*/
			//console.log("URL.LOGIN="+URL.LOGIN);
			//returnl;
			//document.location.href = URL.LOGIN + "?client_id=" + client_id + "&response_type=code&redirect_uri=" + encodeURIComponent(redirect_uri) + "&state=" + state_token+"&svctype=0";
    		//https://nid.naver.com/oauth2.0/authorize?client_id=D_sIq_99IKhzGve9N28N&response_type=code&redirect_uri=https%3A%2F%2Fwww.aklover.co.kr%2Fmain%2Findex.php&state=1473244136786&svctype=0
			//var popLoginNaver= window.open("https://nid.naver.com/oauth2.0/authorize?client_id=D_sIq_99IKhzGve9N28N&response_type=code&redirect_uri=https%3A%2F%2Fwww.aklover.co.kr%2Fmain%2Findex.php&state="+state,"popLoginNaver","width=600,height=600");
			//popLoginNaver.focus();
		
			//document.location.href = URL.LOGIN + "?client_id=" + client_id + "&response_type=code&redirect_uri=" + encodeURIComponent(redirect_uri) + "&state=" + state_token+"&svctype=0";
			
			console.log(naver.client_id);
			
			console.log(naver_id_login.oauthParams.access_token);

    	}
      
    	var tokenInfo = { access_token:"" , refresh_token:"" };
    	function checkLoginState() {
			console.log("checkLoginState");

    		var state = $.cookie("state_token");
    		//alert(naver.checkAuthorizeState(state));
    		if(naver.checkAuthorizeState(state) === "connected") {
    			//���������� Callback������ ���޵Ǿ��� ��� Access Token�߱� ��û ����
    			naver.getAccessToken(function(data) {
    				var response = data._response.responseJSON;
    				if(response.error === "fail") {
    					alert("���̹� ���̵� ���� �����Դϴ�. �ٽ� �õ��� �ּ���.");
    					location.href="/main/index.php?board="+where;
    				    return ; 
    				}
    				$(".img-loading").css("display","block");
    				tokenInfo.access_token = response.access_token;
					
					console.log("token"+tokenInfo.access_token);
    				tokenInfo.refresh_token = response.refresh_token;
					
					//https://developers.naver.com/docs/login/profile

					var URL = "https://apis.naver.com/nidlogin/nid/getUserProfile.json?response_type=json";
					
					//var URL = "https://openapi.naver.com/v1/nid/me";
					//AAAAOIk/6hN2YygQkhFGDQpC0EnJGPVmUZZxETL7NbRxc+TEglZEJDxLmtO0pIDI1cNFErkxmgzN/75x6Sbvgdaf5qU=
					//AAAAN5L7IFELtjSDGlA1XplXh43o5RETHDFWfhf75hLiggMa8ZHuer+U8zBv/0kE/Auni808PxhGQov8+p8LysfYfP4=
    			    naver.api(URL, tokenInfo.access_token, function(data) {
						 console.log(data);

    			          var response = data._response.responseJSON;
    			          $.removeCookie("state_token");
    			          snsType = "naver";
    			          afterLogin.login(response.response);
    			          $.removeCookie("where");
    			          $(".img-loading").css("display","none");
    			          return false;

    			    });
					
    			});
    		} else {
    			alert("���̹� �α��� �����Դϴ�. �ٽ� �õ����ּ���.");
          		location.reload();
          		return false;
    		}
    		$(".img-loading").css("display","none");
    		
    	}
    
    	function snsAjax(response){
    		if(response.id!='' || response.id!=null){
    			$(".img-loading").css("display","block");
    			var url="/main/zip_sns.php";
    			var params = "snsId="+response.id+"&snsType="+snsType+"&snsWhere="+where;
    	  	    $.ajax({      
    	  	        type:"POST",  
    	  	        url:url,      
    	  	        data:params,
    	  	        async : false,
    	  	        success:function(args){
    	  	        	snsResult = args;
    	  	        	$(".img-loading").css("display","none");
    	  	        },complete:function(){
    	      	       	$('.img-loading').css('display','none'); 
    			    },error:function(e){  
    	  	            alert("SNS ���� �����Դϴ�. �ٽ� �õ����ּ���");
    	  	            location.reload();  
    	  	        }
    	  	    });  
    	  	    
    	  	    if(snsResult==1){
					alert("������ �����Ǿ����ϴ�.");
					return 1;
				}else if(snsResult.substring(0,7)=='message'){
					alert(snsResult.substring(8));
					location.href="/main/index.php?board="+where;
					return 0;
				}else{
					alert("�ý��� �����Դϴ�. �ٽ� �õ����ּ���.");
					location.href="/main/index.php?board="+where;
					return 0;
				}
    	  	    $(".img-loading").css("display","none");
    		}
    	 }	
    
    	
    afterLogin = {
    	inputData : function(response){
			console.log("snsType"+snsType);
			console.log("response.id"+response.id);
    		$("input[name='snsType']").val(snsType);
    		$("input[name='snsId']").val(response.id);
    	},
    	login : function (response){
			console.log("login");
    		if(where=='login'){
    			console.log(response);
    			afterLogin.inputData(response);
        	  	document.loginForm.submit();
    		}else if(where=='idcheck'){
	    		var chSns = snsAjax(response);
	    		if(chSns!=1){
	    			return false;
	    		}
	    		afterLogin.inputData(response);
	    		if(typeof response.email!='undefined'){
	    			$("input[name='snsEmail']").val(response.email);
	    		}
	    	    document.idcheckForm.submit();
    		}else if(where=='infoedit'){
    			var chSns = snsAjax(response);
    			location.href="/main/index.php?sns=snsAuth&board="+where;
    			if(chSns!=1){
    				return false;
    			}
    		}else if(where=='all'){
				afterLogin.inputData(response);
        	  	document.banner_loginForm.submit();
			}
    		
    	}
    }
    
