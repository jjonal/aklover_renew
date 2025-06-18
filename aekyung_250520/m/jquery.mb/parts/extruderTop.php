<?
####################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
####################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
?>

<?
	if(!strcmp($_SESSION['temp_code'],'')){
?>



    <script type="text/javascript">
            function go_submit(form) {
//##################################################################################################################################################//
            var id = form.hero_id;
            var pw_01 = form.hero_pw;
//##################################################################################################################################################//
            if(id.value.length < 4){
                alert("아이디를 입력하세요");
                id.style.border = '1px solid red';
                id.focus();//    document.getElementById("input_chat").focus();//    login_form.login_id.focus()
                return false;
            }else if(id.value.length > 20){
                alert("아이디를 입력하세요");
                id.style.border = '1px solid red';
                id.focus();//    document.getElementById("input_chat").focus();//    login_form.login_id.focus()
                return false;
            }else{
                id.style.border = '';
            }
//##################################################################################################################################################//
            if(pw_01.value == ""){
                alert("비밀번호를 입력하세요.");
                pw_01.style.border = '1px solid red';
                pw_01.focus();
                return false;
            }else{
                pw_01.style.border = '';
            }
				form.submit();
//##################################################################################################################################################//
            return true;
            }
    </script>
             <div id="menu_line"></div>
             <div id="login" class='col-xs-6' style="margin:auto;padding: 40px 0px;">
             
             
		            <form name="form_next" action="/m/login_check.php" enctype="multipart/form-data" method="post" onsubmit="return false;">
						  <div class="form-group">
							    <label for="exampleInputEmail1">아이디</label>
							    <input type="text" class="form-control" name="hero_id" id="hero_id" placeholder="아이디">
						  </div>
						  <div class="form-group">
							    <label for="exampleInputPassword1">비밀번호</label>
							    <input type="password" class="form-control" name="hero_pw" id="hero_pw" placeholder="비밀번호">
						  </div>
						  <button type="button" class="btn btn-primary" onClick="go_submit(this.form)">로그인</button>
					</form>
             
             
             
             
             </div>
<?}?>
           <div><img src="img/shadow1.jpg" alt="" width="100%" height="2px"/>
           </div>
</div>