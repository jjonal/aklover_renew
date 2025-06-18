<?
####################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
####################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;


?>


<!--다운메뉴 시작-->
<div id="down_menu" style="display:none; position:absolute; z-index:20; background-color:#fff; width:100%">
  <div id="main_menu" style="width:310px; height:auto; margin:auto">
  <form action="<?=DOMAIN_END?>m/search.php?board=search" method="POST" >
  <ul style="width:100%; height:auto">
  <li style="font-size:16px; font-weight:bold; color:#757575; letter-spacing:-1px; padding-left:8px;">SEARCH </li>
<!--
  <li style="margin-left:10px">
     <select name="" size="1" class="menu_select">
       <option>제목</option>
       <option value="일반미션">일반미션</option>
       <option value="프리미엄미션">프리미엄미션</option>
       <option value="활동미션">활동미션</option>
       <option value="선물상자">선물상자</option>
       <option value="생생후기">생생후기</option>
       <option value="러버스타">러버스타</option>
       <option value="오늘하루">오늘하루</option>
       <option value="출석체크">출석체크</option>
       <option value="꽃미녀팁">꽃미녀팁</option>
       <option value="주부9단팁">주부9단팁</option>
       <option value="미식가팁">미식가팁</option>
       <option value="예술가팁">예술가팁</option>
       <option value="공지사항">공지사항</option>
       <option value="핫이슈">핫이슈</option>
       <option value="AK LOVER란?">LOVER란?</option>
     </select>
  </li>
-->
  <li style="margin-left:10px">
    <input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];;?>" class="menu_search">
  </li>
  
  
  <li style="margin-left:8px; margin-top:12px">
    <input type="image" src="img/search.jpg" alt="검색" width="30px">
  </li>

  </ul>
</form>
</div>

            <div id="menu_line"></div>
            
                
            <div id="menu_list" style="width:90%; margin:auto; margin-top:15px;z-index:100">
               <ul style="width:100%">
               <li style="width:40%;">
                  <a href="<?=DOMAIN_END?>m/mission.php?board=group_04_05"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> 일반미션</p></a>  
                  <a href="<?=DOMAIN_END?>m/mission.php?board=group_04_06"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> 프리미엄 미션</p></a>
                  <a href="<?=DOMAIN_END?>m/mission.php?board=group_04_07"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> 애경박스</p></a>
                  <a href="<?=DOMAIN_END?>m/mission.php?board=group_04_08"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> AK 기자단</p></a>
               </li>
            
               <li style="width:31%">
                  <a href="<?=DOMAIN_END?>m/board_01.php?board=group_04_09"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> 생생후기</p></a>
                  <a href="<?=DOMAIN_END?>m/board_02.php?board=group_04_10"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> 러버스타</p></a>
                  <a href="<?=DOMAIN_END?>m/today.php?board=group_02_01"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> 오늘하루</p></a>
                  <a href="<?=DOMAIN_END?>m/check.php?board=group_04_04"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> 출석체크</p></a>
               </li>
              
               <li style="width:29%">
                  <a href="<?=DOMAIN_END?>m/board_00.php?board=group_01_01"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> 꽃미녀팁</p></a>
                  <a href="<?=DOMAIN_END?>m/board_00.php?board=group_01_02"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> 똑순이팁</p></a>
                  <a href="<?=DOMAIN_END?>m/board_00.php?board=group_01_03"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> 미식가팁</p></a>
                  <a href="<?=DOMAIN_END?>m/board_00.php?board=group_01_04"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> 문화가팁</p></a>
              </li>
              </ul>
             
              <ul style="width:100%">
              <li style="width:40%">
                  <a href="<?=DOMAIN_END?>m/today.php?board=group_04_03"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> 공지사항</p></a>
              </li>
            
              <li style="width:31%">
                  <a href="<?=DOMAIN_END?>m/today.php?board=group_03_03"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> 핫이슈</p></a>
              </li>
              
              <li style="width:29%">
                  <a href="aklover.php"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> AK LOVER란?</p></a>
              </li>
             </ul>
           </div>
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
             <div id="login" style="width:310px; margin:auto;">
             <form name="form_next" action="<?=PATH_END?>login_check.php" enctype="multipart/form-data" method="post" onsubmit="return false;">
                <ul>
                <li style="margin-top:6px; margin-right:5px">아이디</li>
                <li style="margin-right:6px"><input name="hero_id" id="hero_id" type="text" class="login_box"></li>
                <li style="margin-top:6px; margin-right:6px">비밀번호</li>
                <li style="margin-right:8px"><input name="hero_pw" id="hero_pw" type="password" class="login_box"></li>
                <li><input type="image" src="img/login_btn1.jpg" alt="로그인" height="25px" onClick="go_submit(this.form)"></li>

                </ul>
             </form>
             </div>
<?}?>
           <div><img src="img/shadow1.jpg" alt="" width="100%" height="2px"/>
           </div>
</div>             
<!--다운메뉴 종료 -->
 