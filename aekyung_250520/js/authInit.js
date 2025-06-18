
auth = {
	hp_Popup : function(form){
		window.open('', 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
		form.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
		form.target = "popupChk";
		form.submit();
    },
    ip_Popup : function(form){
    	window.open('', 'popupIPIN2', 'width=450, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
    	form.target = "popupIPIN2";
    	form.action = "https://cert.vno.co.kr/ipin.cb";
    	form.submit();
    }
}
