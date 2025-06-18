<?
if(!defined('_HEROBOARD_'))exit;

if($_SESSION["global_code"]) error_location("이미 로그인 되었습니다.","/main/index.php");

if($_COOKIE['cookie_global_hero_id']) {
	$check = "checked";
} else {
	$check = "";
}
?>
<div class="contents_area">
	<div class="page_title">
		<div>로그인</div>
		<ul class="nav">
			<li><img src="/image/common/icon_nav_home.gif" alt="home" /></li>
			<li>&gt;</li>
			<li>글로벌 클럽</li>
			<li>&gt;</li>
			<li class="current">로그인</li>
		</ul>
	</div>
	<div class="contents">
		<div class="loginbox">
			<h3 class="txt_tit">AK LOVER Global Club 로그인</h3>
			<form name="loginForm" id="loginForm" action="<?=PATH_HOME_HTTPS?>?board=<?=$_GET["board"]?>&view=login_check&action=login" method="post" onsubmit="return false;">
			<input type="hidden" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>">
			<div class="loginForm">
	        	<dl class="inputBox">
	        		<dd>
	        			<div><input type="text" name="hero_id" id="hero_id" class="c2 enterArea" style="ime-mode:disabled;" maxlength="20" value="<?=$_COOKIE['chk_global_id_cookie']?>"></div>
	        			<div><input type="password" name="hero_pw" id="hero_pw" class="c4 enterArea"></div>
	        		</dd>
	        		<dd>
	        			<a href="javascript:;" onClick="go_submit()"><img src="/image/member/btn_login.gif" alt="LOGIN" ></a>
	        		</dd>
	        	</dl>
	        	<div class="idSaveBox">
					<input type="checkbox" name="chk_global_id_cookie" id="chk_global_id_cookie" value="true" <?=$check?> />
					<label for="chk_id_cookie">아이디 저장</label>
	        	</div>
	        	
	        	<p class="globalLoginInfo">
	        		AK LOVER Global Club 로그인 및 일반문의는<br/>
	        		AK LOVER Global Club 카카오톡 및<br/>
	        		Global Club > 1:1문의를 통해 접수해 주세요
	        	</p>
			</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
function go_submit() {
    var id = document.loginForm.hero_id;
    var pw_01 = document.loginForm.hero_pw;
    
    if(id.value.length < 4){
        alert("아이디를 입력하세요");
        id.style.border = '1px solid red';
        id.focus();
        return false;
        
    }else if(id.value.length > 20){
        alert("아이디를 입력하세요");
        id.style.border = '1px solid red';
        id.focus();
        return false;
        
    }else{
        id.style.border = '';
    }
    

    if(pw_01.value == ""){
        alert("비밀번호를 입력하세요.");
        pw_01.style.border = '1px solid red';
        pw_01.focus();
        return false;
        
    }else{
        pw_01.style.border = '';
    }
    
    document.loginForm.submit();
    return true;
}
</script>
