<?
####################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
####################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;


?>


<!--�ٿ�޴� ����-->
<div id="down_menu" style="display:none; position:absolute; z-index:20; background-color:#fff; width:100%">
  <div id="main_menu" style="width:310px; height:auto; margin:auto">
  <form action="<?=DOMAIN_END?>m/search.php?board=search" method="POST" >
  <ul style="width:100%; height:auto">
  <li style="font-size:16px; font-weight:bold; color:#757575; letter-spacing:-1px; padding-left:8px;">SEARCH </li>
<!--
  <li style="margin-left:10px">
     <select name="" size="1" class="menu_select">
       <option>����</option>
       <option value="�Ϲݹ̼�">�Ϲݹ̼�</option>
       <option value="�����̾��̼�">�����̾��̼�</option>
       <option value="Ȱ���̼�">Ȱ���̼�</option>
       <option value="��������">��������</option>
       <option value="�����ı�">�����ı�</option>
       <option value="������Ÿ">������Ÿ</option>
       <option value="�����Ϸ�">�����Ϸ�</option>
       <option value="�⼮üũ">�⼮üũ</option>
       <option value="�ɹ̳���">�ɹ̳���</option>
       <option value="�ֺ�9����">�ֺ�9����</option>
       <option value="�̽İ���">�̽İ���</option>
       <option value="��������">��������</option>
       <option value="��������">��������</option>
       <option value="���̽�">���̽�</option>
       <option value="AK LOVER��?">LOVER��?</option>
     </select>
  </li>
-->
  <li style="margin-left:10px">
    <input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];;?>" class="menu_search">
  </li>
  
  
  <li style="margin-left:8px; margin-top:12px">
    <input type="image" src="img/search.jpg" alt="�˻�" width="30px">
  </li>

  </ul>
</form>
</div>

            <div id="menu_line"></div>
            
                
            <div id="menu_list" style="width:90%; margin:auto; margin-top:15px;z-index:100">
               <ul style="width:100%">
               <li style="width:40%;">
                  <a href="<?=DOMAIN_END?>m/mission.php?board=group_04_05"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> �Ϲݹ̼�</p></a>  
                  <a href="<?=DOMAIN_END?>m/mission.php?board=group_04_06"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> �����̾� �̼�</p></a>
                  <a href="<?=DOMAIN_END?>m/mission.php?board=group_04_07"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> �ְ�ڽ�</p></a>
                  <a href="<?=DOMAIN_END?>m/mission.php?board=group_04_08"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> AK ���ڴ�</p></a>
               </li>
            
               <li style="width:31%">
                  <a href="<?=DOMAIN_END?>m/board_01.php?board=group_04_09"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> �����ı�</p></a>
                  <a href="<?=DOMAIN_END?>m/board_02.php?board=group_04_10"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> ������Ÿ</p></a>
                  <a href="<?=DOMAIN_END?>m/today.php?board=group_02_01"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> �����Ϸ�</p></a>
                  <a href="<?=DOMAIN_END?>m/check.php?board=group_04_04"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> �⼮üũ</p></a>
               </li>
              
               <li style="width:29%">
                  <a href="<?=DOMAIN_END?>m/board_00.php?board=group_01_01"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> �ɹ̳���</p></a>
                  <a href="<?=DOMAIN_END?>m/board_00.php?board=group_01_02"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> �ȼ�����</p></a>
                  <a href="<?=DOMAIN_END?>m/board_00.php?board=group_01_03"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> �̽İ���</p></a>
                  <a href="<?=DOMAIN_END?>m/board_00.php?board=group_01_04"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> ��ȭ����</p></a>
              </li>
              </ul>
             
              <ul style="width:100%">
              <li style="width:40%">
                  <a href="<?=DOMAIN_END?>m/today.php?board=group_04_03"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> ��������</p></a>
              </li>
            
              <li style="width:31%">
                  <a href="<?=DOMAIN_END?>m/today.php?board=group_03_03"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> ���̽�</p></a>
              </li>
              
              <li style="width:29%">
                  <a href="aklover.php"><p class="menu_title"><img src="img/arrow.jpg" alt="" width="7px"/> AK LOVER��?</p></a>
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
                alert("���̵� �Է��ϼ���");
                id.style.border = '1px solid red';
                id.focus();//    document.getElementById("input_chat").focus();//    login_form.login_id.focus()
                return false;
            }else if(id.value.length > 20){
                alert("���̵� �Է��ϼ���");
                id.style.border = '1px solid red';
                id.focus();//    document.getElementById("input_chat").focus();//    login_form.login_id.focus()
                return false;
            }else{
                id.style.border = '';
            }
//##################################################################################################################################################//
            if(pw_01.value == ""){
                alert("��й�ȣ�� �Է��ϼ���.");
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
                <li style="margin-top:6px; margin-right:5px">���̵�</li>
                <li style="margin-right:6px"><input name="hero_id" id="hero_id" type="text" class="login_box"></li>
                <li style="margin-top:6px; margin-right:6px">��й�ȣ</li>
                <li style="margin-right:8px"><input name="hero_pw" id="hero_pw" type="password" class="login_box"></li>
                <li><input type="image" src="img/login_btn1.jpg" alt="�α���" height="25px" onClick="go_submit(this.form)"></li>

                </ul>
             </form>
             </div>
<?}?>
           <div><img src="img/shadow1.jpg" alt="" width="100%" height="2px"/>
           </div>
</div>             
<!--�ٿ�޴� ���� -->
 