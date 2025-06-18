// JavaScript Document
$(function(){	
		
	$(document).on("keyup", "input:text[numberOnly]", function() {$(this).val( $(this).val().replace(/[^0-9]/gi,"") );});
	
	//(s) 20171218 ��� ����, �ٿ��ֱ� �ȵǰ� ó��
	var ctrlDown = false;
	var ctrlKey = 17, vKey = 86, cKey = 67;

	$(document).keydown(function(e) {
		if (e.keyCode == ctrlKey) ctrlDown = true;
		//if(e.keyCode === 13 && e.target == "input") event.preventDefault();
	}).keyup(function(e)
	{
		if (e.keyCode == ctrlKey) ctrlDown = false;
	});

	$(".nonCtrl").keydown(function(e) {
		if (ctrlDown && (e.keyCode == vKey || e.keyCode == cKey)) return false;
	});
	//(e) 20171218 ��� ����, �ٿ��ֱ� �ȵǰ� ó��
	
	/* 21-05-25 ������, �⼮üũ �˸� ����
	setInterval(function(){
    	$(".postNumber").toggle();
    }, 700);
    */

	
});

var map;
function initialize(latitude,hardness,content) {
 //alert(latitude);
	var myLatlng = new google.maps.LatLng(latitude,hardness);
	var myOptions = {
		zoom: 16,
		center: myLatlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	var infowindow = new google.maps.InfoWindow(
	{ content: content,
		position: myLatlng
	});
	infowindow.open(map);
	
	var marker = new google.maps.Marker({
		position: myLatlng, 
		map: map
	});
}

var sidebarurl = "http://www.lion-korea.com/"; // Change as required 
var sidebartitle = "LionKorea"; // Change as required 
var url = this.location; 
var title = document.title; 

function bookmarksite() { 
	if (window.sidebar && window.sidebar.addPanel){ // Firefox 
	window.sidebar.addPanel(sidebartitle, sidebarurl,""); 
	} 
	else if ( document.all ) { // IE Favorite 
	window.external.AddFavorite(url, title); 
	} 
	else if (window.opera && window.print) { 
	// do nothing 
	 } 
	else if (navigator.appName=="Netscape") { 
	alert("<Ctrl+D>�� ���� ������������ ���ã�⿡ �߰����ּ���."); 
	} 
} 

function mover(i){		
	$('.rollimg').css({'z-index':'10'});
	$('.rollimg').eq(nowidx).css({'z-index':'15'});
	tmpidx=i-1;		
	$('.rollimg').eq(tmpidx).css({'opacity':0,'z-index':'20'});
	$('.rollimg').eq(tmpidx).animate({'opacity': 1},1000);
	nowidx=tmpidx;		
}

function nextp(){
	$('.bnext').unbind('click');
	clearTimeout(times2);
	$des=$('.notice_roll .txt p:first');
	$des.animate( {marginTop:-58},500,function(){
		$cut=$des.detach();
		$des.css({marginTop:0});
		$(".notice_roll .txt p:last").after($cut);
		$('.bnext').click(nextp);
		tm2();
	});	
}

function prevp(){
	$('.bprev').unbind('click');
	clearTimeout(times2);
	$des=$('.notice_roll .txt p:last');
	$cut=$des.detach();	
	$des.css({marginTop:-58});
	$(".notice_roll .txt p:first").before($cut);
	$des.animate({marginTop:0},500,function(){$('.bprev').click(prevp);tm2();});		
}

function tm(){
	times=setInterval("action()",8000);
}

function tstop(){
	clearTimeout(times);	
}

function action(){
	tstop();
	t=t+1;
	if (t>cnt){t=1;}
	mover(t);
	tm();			
}

function pre(){
	tstop();
	t=t-1;
	if (t<1){t=cnt;}
	mover(t);
	tm();	
}
function tm2(){	
times2=setInterval("notice()",5000);
}

function notice(){
$('.bnext').click();
}

//-------------------------------------------------

//�˾�����	
	function popup(PopIdx, PopUrl, strWidth, strHeight, strTop, strLeft,sc) {
		var from_idx = document.cookie.indexOf(name+'=');
		if (from_idx != -1) { 
			from_idx += name.length + 1
			to_idx = document.cookie.indexOf(';', from_idx) 
			if (to_idx == -1) {
				to_idx = document.cookie.length
			}
			//return unescape(document.cookie.substring(from_idx, to_idx))
		}
		if (PopIdx)	{
			var blnCookie = getCookie("popup_id_" + PopIdx);
			if ( !blnCookie ) {
			winOpenNotice(PopUrl, strWidth, strHeight, strTop, strLeft, "no_" + PopIdx, sc);
			}
		}
	}

	function getCookie(name) {
		var from_idx = document.cookie.indexOf(name+'=');
		if (from_idx != -1) {
			from_idx += name.length + 1
			to_idx = document.cookie.indexOf(';', from_idx)
			if (to_idx == -1) {
				to_idx = document.cookie.length
			}
			return unescape(document.cookie.substring(from_idx, to_idx))
		}
	}
	function optionsCheck(){
		alert('�ɼ� ����');
	}

	function winOpenNotice(url,width,height,left,top,winName,sc){
		var scrolls = sc;
		var open = window.open(url,winName,"width=" + width + ",height=" + height + ",scrollbars=" + scrolls + ",left=" + left + ",top=" + top + ",status=no,toolbar=no"); 
		open.focus();	
	}

	//�˾�����_F ����Ʈ����
	function goodsBuy(goodsPoint, userPoint, goodsIdx){
		if(goodsPoint <= userPoint){
			if(confirm("�ش� ��ǰ�� �����Ͻðڽ��ϱ�?")){
				var form = document.form_next;
				form.type.value = "new";
				form.goods_idx.value = goodsIdx;
				form.goods_point.value = goodsPoint;
				form.submit();
			}else{
				return false;
			}
		}else{
			alert("����Ʈ�� �����Ͽ� ��ǰ���Ű� �Ұ����մϴ�");
			return false;
		}
	}
	
function extension_check(filename, type){
	if(filename==''){
		return false;
	}
	var extensions = [];
	switch(type){
		case "image" : extensions.push("jpg","jpeg","png","gif"); break; 
		case "other" : extensions.push("xlsx","xlsm","xlsb","xls","xml","hwp","txt","txt"); break; 
		default : extensions.push("not");break;
	}
	if(extensions[0]=='not'){
		alert("Ÿ���� �߸� �����Ǿ� �ֽ��ϴ�.");
		return false;
	}else{
		var filenames = filename.split(".");
		var fileExtension = filenames[filenames.length-1];
		var tf_extension=false;
		
		for(var i in extensions){
			
			if(extensions[i] == fileExtension.toLowerCase()){
				tf_extension = true;
				return true;
				break;
			}
		}
		alert(fileExtension+"�� ��ȿ�� Ȯ���ڰ� �ƴմϴ�.");
		return false;
	}
}

function pcMobile(where, alocation){
	if(where=='mobile'){
		setCookie("pcMobile","mobile",-1200);
		location.href=alocation;
	}else if(where=='pc'){
		setCookie("pcMobile","pc",1200);
		location.href=alocation;
	}
}

function delCookie( name ) {
	jQuery.removeCookie(name);
	//jQuery.cookie(name, '',{expires: -1,path:'/main/index.php'});
}

function setCookie( cookieName, cookieValue, expireDate ){
	var today = new Date();
	today.setDate( today.getDate() + parseInt( expireDate ) );
	document.cookie = cookieName + "=" + escape( cookieValue ) + "; path=/; expires=" + today.toGMTString() + ";";
}

function quick_button(){
	if($("#quick_button").prop("class")=="on"){
		$( "#quick_button" ).prop("class","off" ).animate({ "right": "+=190px" });
		$("#quick_button").css("display","none");
		$( "#quick02" ).css("border-left","1px solid #dcdcdc");
		$( "#quick02" ).animate({width: "+=199px"});
		$('#qimage').prop('src','/image2/main/qclose.png');
	}else if($("#quick_button").prop("class")=="off"){
		$( "#quick_button").prop("class","on" ).animate({ "right": "-=190px" });
		$("#quick_button").css("display","block");
		$( "#quick02" ).css("border-left","none");
		$( "#quick02" ).animate({width: "-=199px"});
		$( '#qimage' ).prop('src','/image2/main/qopen.png');

		var expire = new Date();
		var cDay = 1000*60*60*24;
		var cName = 'quick_off';
		var cValue = '1';
		expire.setDate(expire.getDate() + cDay);
		
		cookies = cName + '=' + escape(cValue) + '; path=/ '; // �ѱ� ������ �������� escape(cValue)�� �մϴ�.
		if(typeof cDay != 'undefined') {
			cookies += ';expires=' + expire.toGMTString() + ';';
			document.cookie = cookies;
		}
	}
}


function openLayer1(len, img, num, chg){					// len = tab id�� ����, num = tab1...tab2...tab3... ���� �� ��° ����, img = img id�� ��θ� 
	for(var i=1; i<=len; i++){
		var gubun = $("#img"+i).attr("src").substr(-3, 3);	// jpg,gif,png ���� �ܾ���� �̾Ƴ���.
		if(i == num){
			if($("#tab"+i).css("display") == "none"){
				$("#img"+i).attr("src", img+chg+"."+gubun);
				$("#tab"+i).slideDown(500);
			}else{
				$("#img"+i).attr("src", img+"."+gubun);
				$("#tab"+i).slideUp(500);
			}
		}else{
			$("#img"+i).attr("src", img+"."+gubun);
			$("#tab"+i).css("display", "none");
		}
	}
}

function open0(link){
    var link1 = encodeURIComponent(link);
    window.open('http://www.facebook.com/sharer/sharer.php?u='+link1,'','width=520 height=400 scrollbars=yes');
}
function open1(sub, link){
    var sub1 = encodeURIComponent(sub);
    var link1 = encodeURIComponent(link);
    window.open('http://twitter.com/home?status='+sub1+' '+link1,'','width=520 height=200 scrollbars=yes');
}
function open2(sub, link){
    var sub1 = encodeURIComponent(sub);
    var link1 = encodeURIComponent(link);
    window.open('http://plugin.me2day.net/v1/me2post/create_post_form.nhn?body='+sub1+' '+link1,'','width=520 height=400 scrollbars=yes');
}

//�յ� ���� ����
function trim(str){
  return str.replace(/(^\s*)|(\s*$)/gi, ""); 
}


function confirmAction(message,locations,obj){
	
	if(typeof obj === 'undefined') obj = "document";
	
	if(confirm(message)==true)		document.location.href=locations;
	else							return false;
	
}

//######  ���� �ۼ�, ����    ############################################################################
function hero_review_submit(review_form, command, device){
	//'review_form', 'hero_command','pc'
	var url = "/main/zip_review.php";
	var queryString = $("#"+review_form).serialize();

	if(command!=''){
		var input = encodeURIComponent(document.getElementById(command).value);
		var text = document.getElementById(command).value.trim().replace(/\n/g,"");
		
		if(input=="" || input==null){
			alert("����� �Է��� �ּ���.");
			return false;
		}
		
		if(text.length < 5) {
			alert("5���� �̸��� ���� �ۼ� �Ұ��մϴ�.");
			return false;
		}

		queryString += "&command="+input;
	}
	
	$.ajax({      
	    type:"POST",  
	    url:url,      
	    data:queryString,
	    async : 'false',
	    success:function(args){
	    	//console.log(args);
	    	args = trim(args);
			//alert(args);

	    	if(args.substring(0,7)=="message"){
	    		var message = args.split(":");
	    		alert(message[1]);
	    	}else if(args!=1){
		    	if(args=="REGISTERED")			alert("�ش� ����� �̹� ��ϵǾ����ϴ�.");
		    	else if(args=="WRONG_SETTING")	alert("�߸��� �����Դϴ�. �ٽ� �õ����ּ���.");
		    	else							alert("�˼��մϴ�. �ý��� �����Դϴ�. �ٽ� �õ����ּ���. ���� ������ �ݺ��� ��� �����Ϳ� �������ּ���.");
	    	}
	    	if(device=='pc'){
	    		location.reload();
	    	}else{
	    		var thisNo = location.href.split("#tabbtn_")[1];
	    		var tabcon = $(".tabcon_"+thisNo);
	    		tabcon.addClass("tabcon_hide");
	    		today_openLayer(thisNo);
	    	}
	    	return false;

	    }
	});
}

//######  ���� ����    ############################################################################
function hero_review_del(idx,device){
	var url = "/main/zip_review.php";
	var queryString = "mode=review_drop&depth_idx="+idx;
	$.ajax({      
	    type:"POST",  
	    url:url,
	    data:queryString,
	    async : 'false',
	    success:function(args){
	    	args = trim(args);
	    	if(args!=1){
	    		if(args.substr(0,7)=='message'){
	    			var message = args.split(":");
	    			alert(message[1]);
	    		}else{
	    			alert("�˼��մϴ�. �ý��� �����Դϴ�. �ٽ� �õ����ּ���. ���� ������ �ݺ��� ��� �����Ϳ� �������ּ���.");
	    		}	
	    	}
	    	if(device=='pc'){
	    		location.reload();
	    	}else{
	    		var thisNo = location.href.split("#tabbtn_")[1];
	    		var tabcon = $(".tabcon_"+thisNo);
	    		tabcon.addClass("tabcon_hide");
	    		today_openLayer(thisNo);
	    	}
	    }
	});
}

//�迭�� �� ���� Ȯ�� - �׽�Ʈ��
function dump(arr,level) {
	var dumped_text = "";
	if(!level) level = 0;
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";
	if(typeof(arr) == 'object') { //Array/Hashes/Objects 
		for(var item in arr) {
			var value = arr[item];
			
			if(typeof(value) == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += dump(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else { //Stings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	console.log(dumped_text);
}

//url ����Ȯ��
function isValidURL(url) {
	var urlregex = new RegExp("^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
	return urlregex.test(url);
}

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,    
    function(m,key,value) {
      vars[key] = value;
    });
    return vars;
}

//���̰��
var chAge = {
		setDate : function (chYear,chMonth,chDate){
			year = Number(chYear);
			month = Number(chMonth);
			date = Number(chDate);
			var d = new Date();
			thisYear = Number(d.getFullYear());
			thisMonth = Number(d.getMonth())+1;
			thisDate = Number(d.getDate());
		},
		countUniversalAge : function(){
			if(typeof year=='undefined' || year==''){
				alert("��¥�� �������� �ʾҽ��ϴ�.");
				return false;
			}
			if(typeof month=='undefined' || month==''){
				alert("��¥�� �������� �ʾҽ��ϴ�.");
				return false;
			}
			if(typeof date=='undefined' || date==''){
				alert("��¥�� �������� �ʾҽ��ϴ�.");
				return false;
			}
			
			var age = Number(thisYear - year);
			if(year<thisYear){
				if(month==thisMonth){
					if(date>thisDate){
						age = age-1;
					}
				}else if(month>thisMonth){
					age = age-1;
				}
			}
			return age;
		},
		countKoreanAge : function (){
			if(typeof year=='undefined' || year==''){
				alert("��¥�� �������� �ʾҽ��ϴ�.");
				return false;
			}
			return thisYear - year;
		}
}

//�ؽ�Ʈ Ȯ��
var chTextType = {
	isEnNumOther : function(theText){
		var pass_check = /^.*(?=^.{8,15}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[~!@#$%^&+=*()_-]).*$/;
		return pass_check.test(theText);
	},
	isKor : function(theText){
		var kor_check = new RegExp("/[��-��|��-��|��-��]/");
		return kor_check.test(theText);
	}
}

function mail_send(idx){
	$('#cluetip').css('display','none');
	$('#mail_form').load("/mail_send.php?idx="+idx+"").css('display','block');
}

//pc ���� �� �ݱ�
function close_mail(){
	$('#mail_form').css('display','none');
}

//�߼� ajax
function submits_mail(device){							
	var hero_title = $('#hero_title_mail');
	var hero_command = $('#editor_mail');

	if(hero_title.val()==''){
		alert("������ �Է����ּ���.");
		hero_title.focus();
		return false;
	}

	if(hero_command.val()==''){
		alert("������ �Է����ּ���.");
		hero_command.focus();
		return false;
	}

	
	var re = ch_count_text(300,'editor_mail');
	var re2 = ch_count_text(40,'hero_title_mail');
	
	var postData = $("form[name=form_mail_next]").serialize();
	postData = postData+"&hero_title="+hero_title.val()+"&hero_command="+hero_command.val()+"";
	//alert(postData);
	//alert(re);
	if(re==0 && re2==0){
		$.ajax({
			type: "POST",  
			url: "/mail_send_act.php",   
			data: postData,  
			success: function(data){
				if(data==1){
					alert('�߼۵Ǿ����ϴ�.');
					if(device == "mobile") {
						fnProfileClose()
					} else {
						close_mail();
					}
				}else if(data==0){
					alert('�߼ۿ� �����Ͽ����ϴ�. �ٽ� �õ����ּ���.');
					if(device == "mobile") {
						fnProfileClose()
					} else {
						close_mail();
					}
				}else{
					alert(data);
					close_mail();
				}
			}				
		});
	}
}
function ch_count_text(count,id){
	var ids = document.getElementById(id);
	if(count<ids.value.length && ids.value.length!=0){
		alert(count+"���� �̳��� �Է����ּ���.");
		ids.focus();
		return 1;
	}else{
		return 0;
	}
};

function downMenu() {
	$('.flap').click();
}

//����� ������ ���̾� ���� 21-03-18
function fnProfile(idx){
	console.log("fnProfile");
	$.ajax({
		url:"/m/info_mem.php"
		,data:"idx="+idx
		,type:"GET"
		,dataType:"html"
		,success:function(d) {
			$(".profileWrap").html(d); // ������ /m/tail.php ����
		}
	})
}

function fnProfileClose() {
	$(".profileWrap").html("");
}

function fnProfileSendForm(){
	$(".profileWrap .profile").hide();
	$(".profileWrap .message").show();
}

// musign cart S 241119
function goodsCart(goodsPoint, goodsIdx){
	//if(goodsPoint <= userPoint){
		if(confirm("�ش� ��ǰ�� ��ٱ��Ͽ� �߰��Ͻðڽ��ϱ�?")){
			var form = document.form_next;
			form.type.value = "cart";
			form.goods_idx.value = goodsIdx;
			form.goods_point.value = goodsPoint;
			form.submit();
		}else{
			return false;
		}
	//}
}

// ��ٱ��� ��ǰ �����ϱ�
function allGoodsBuy(){

	if(confirm("��ٱ��Ͽ� ��� ��ǰ���� �����Ͻðڽ��ϱ�?")){
		var form = document.form_next;
		form.type.value = "allGoodsBuy";
		form.submit();
	}
}

// ��ٱ��� ��ǰ �����ϱ�
function goodsDel(cart_idx){
	if(confirm("�ش� ��ǰ�� ��ٱ��Ͽ��� �����Ͻðڽ��ϱ�?")){
		var form = document.form_next;
		form.type.value = "goodsDel";
		form.cart_idx.value = cart_idx;
		form.submit();
	}
}

// ��ٱ��� ��ǰ ��ü �����ϱ�
function goodsAllDel(){
	if(confirm("��ٱ��Ͽ� ��� ��� ��ǰ�� �����˴ϴ�. �����Ͻðڽ��ϱ�?")){
		var form = document.form_next;
		form.type.value = "goodsAllDel";
		form.submit();
	}
}
// musign cart E 241119



