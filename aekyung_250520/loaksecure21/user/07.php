<?
####################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
####################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
?>
<?
if($_GET['ttt']=='ttt'){
?>
<table style="width:100%">
<colgroup>
	<col width="22%" />
	<col width="22%" />
	<col width="22%" />
	<col width="22%" />
	<col width="22%" />
</colgroup>
<?
$sql = 'SELECT `hero_idx`,`hero_id`,`hero_nick`,`hero_info_di`,`hero_login_ip` '
        . ' FROM `member` '
        . ' ORDER BY `member`.`hero_login_ip` ASC'
        . ' LIMIT 0 , 10000';
$query = mysql_query($sql);
$checker='';
$cnt = 0;
$data_wrap['hero_idx']=array();
$data_wrap['hero_id']=array();
$cnt2=0;
$data_wrap['hero_nick']=array();
$data_wrap['hero_login_ip']=array();
$data_wrap['hero_pw']=array();
$data_wrap['hero_login_ip_checker']=array();
while($data = mysql_fetch_assoc($query)){
    $data_wrap['hero_idx'][$cnt]=$data['hero_idx'];
    $data_wrap['hero_id'][$cnt]=$data['hero_id'];
    $data_wrap['hero_pw'][$cnt]=$data['hero_info_di'];
    $data_wrap['hero_nick'][$cnt]=$data['hero_nick'];
    $data_wrap['hero_login_ip'][$cnt]=$data['hero_login_ip'];
        if($data['hero_login_ip']==$checker){
            $data_wrap['hero_login_ip_checker'][$cnt]=true;
            $data_wrap['hero_login_ip_checker'][$cnt-1]=true;
        }else{
            $data_wrap['hero_login_ip_checker'][$cnt]=false;
        }
        $checker=$data['hero_login_ip'];
    $cnt++;
}
$checker2=$data_wrap['hero_login_ip'][0];
for($j=0;$j<=$cnt-1;$j++){
    if($data_wrap['hero_login_ip_checker'][$j]==true){
if($data_wrap['hero_login_ip'][$j]==$checker2){
?>
<tr style="border-top:#eee solid 1px;height:20px;">
<?
}else{
?>
<tr style="border-top:#2c9ce8 solid 3px;height:20px;">
<?
}
?>
	<td><?=$data_wrap['hero_idx'][$j];?></td>
	<td><?=$data_wrap['hero_id'][$j];?></td>
	<td><?=$data_wrap['hero_pw'][$j];?></td>
	<td><?=$data_wrap['hero_nick'][$j];?></td>
	<td <? if($data_wrap['hero_login_ip_checker'][$j]==true){ ?>style="background:#ffd3d3;color:#F00;"<? } ?>><?=$data_wrap['hero_login_ip'][$j];?></td>
</tr>
<?
        $checker2=$data_wrap['hero_login_ip'][$j];
$cnt2++;
    }
}
?>
</table>
<?
echo '/'.$cnt.'/'.$cnt2;
exit;
}
?>
<?
####################################################################################################################################################
//if(!strcmp($_POST['param_r1'],'')){echo '<script>location.href="'.PATH_HOME.'?board=idcheck"</script>';exit;}
$sql = 'select * from member where hero_info_di=\''.$_POST['param_r5'].'\' and hero_info_ci=\''.$_POST['param_r6'].'\';';//desc//asc
sql($sql);
$check_count = @mysql_num_rows($out_sql);
//if(strcmp($check_count,'0')){echo '<script>alert("�̹� �����ϼ̽��ϴ�.");location.href="'.PATH_HOME.'?board=login"</script>';exit;}

/*
<form name="login_form" onsubmit="return false;">
function alert($msg,$command){
    echo "<script language=javascript>    alert('$msg');   $command   </script>";
}
alert("���� �߸��ߴ�.","history.go(-1);");
<button onclick="alert('���̴±���')">Ŭ���غ���</button>
*/
//$_POST['param_r1'] = '������';
//$_POST['param_r2'] = '20130807';
$param_r2_01 = substr($_POST['param_r2'], '0', '4');//��
$param_r2_02 = substr($_POST['param_r2'], '4', '2');//��
$param_r2_03 = substr($_POST['param_r2'], '6', '2');//��
//$_POST['param_r3'] = '1';//����

if(!strcmp($param_r2_01,'')){
    $param_r2_01 = Y;
}else{
    $param_r2_01 = $param_r2_01;
}
if(!strcmp($param_r2_02,'')){
    $param_r2_02 = m;
}else{
    $param_r2_02 = $param_r2_02;
}
if(!strcmp($param_r2_03,'')){
    $param_r2_03 = d;
}else{
    $param_r2_03 = $param_r2_03;
}
?>
    <script type="text/javascript" src="<?=JS_END?>birthdate.js"></script>
    <script type="text/javascript">
        function showzip(){
            $('.layer_zip').show();
        }
        function inputzip(){
            $('.layer_zip').hide();
        }
        function emailChg(){
            form_next.hero_mail_02.value = form_next.email_select.value;
        }
        function fnLoad_01(a,b,c,d,e,f){
            document.getElementById("hero_address_01").value=a;
            document.getElementById("hero_address_02").value=b + ' ' + c + d + e;
            $('.layer_zip').hide();
        }
//        function fnLoad_01(a,b,c,d,e,f){
//�����߻���
//        }
//            var id = document.getElementsByName(id)[0].value;//document.form��.id��
//            var id_action = document.getElementsByName("id_action")[0];

function checkNumber(e) {
 var eventCode =(window.netscape)? e.which : e.keyCode;

 if ( ( (96<=eventCode) && (eventCode<=105) ) || ( (48<=eventCode) && (eventCode<=57) ) || (eventCode==8) || (eventCode==37) || (eventCode==39) || (eventCode==9)|| (eventCode==46))
 {
  e.returnValue=true;
 }
 else
 {
  e.preventDefault();
  e.returnValue=false;
 }
}

        function go_submit(form) {
//##################################################################################################################################################//
            var id = form.hero_id;
            var pw_01 = form.hero_pw_01;
            var pw_02 = form.hero_pw_02;
            var nick = form.hero_nick;
            var mail_01 = form.hero_mail_01;
            var mail_02 = form.hero_mail_02;
            var hp = form.hero_hp;
            var address_01 = form.hero_address_01;
            var address_02 = form.hero_address_02;
            var address_03 = form.hero_address_03;
            var blog_00 = form.hero_blog_00;
            var excuse = form.hero_excuse;
            var excuse_check = form.hero_excuse_check;
            var terms_01 = form.hero_terms_01;
            var terms_02 = form.hero_terms_02;
            var terms_03 = form.hero_terms_03;
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
                id.style.border = '1px solid #e4e4e4';
            }
            if(nick.value.length < 2){
                alert("�г����� �Է��ϼ���");
                nick.style.border = '1px solid red';
                nick.focus();//    document.getElementById("input_chat").focus();//    login_form.login_id.focus()
                return false;
            }else if(nick.value.length > 20){
                alert("�г����� �Է��ϼ���");
                nick.style.border = '1px solid red';
                nick.focus();//    document.getElementById("input_chat").focus();//    login_form.login_id.focus()
                return false;
            }else{
                nick.style.border = '1px solid #e4e4e4';
            }
//##################################################################################################################################################//
            var action = document.getElementById("id_action");
            if(action == undefined){//if(id_action == null){}else{} //alert(typeof(id_action));//undefined
                alert("�ߺ� Ȯ�����ʿ��մϴ�.");
                id.focus();//                form.id_list.focus();
                return false;
            }else if(action.value == "hero_down"){
                alert("���Ұ����� ���̵��Դϴ�.");
                id.focus();//                alert(action.value);
                return false;
            }else if(action.value == "hero_ok"){//                                alert(action.value);
            }
            var new_action = document.getElementById("nick_action");
            if(new_action == undefined){//if(id_action == null){}else{} //alert(typeof(id_action));//undefined
                alert("�ߺ� Ȯ�����ʿ��մϴ�.");
                nick.focus();//                form.id_list.focus();
                return false;
            }else if(new_action.value == "hero_down"){
                alert("���Ұ����� �г����Դϴ�.");
                nick.focus();//                alert(action.value);
                return false;
            }else if(new_action.value == "hero_ok"){//                                alert(action.value);
            }
//##################################################################################################################################################//
            if(pw_01.value == ""){
                alert("��й�ȣ�� �Է��ϼ���.");
                pw_01.style.border = '1px solid red';
                pw_01.focus();
                return false;
            }else{
                pw_01.style.border = '1px solid #e4e4e4';
            }
            if(pw_02.value == ""){
                alert("��й�ȣ�� �Է��ϼ���.");
                pw_02.style.border = '1px solid red';
                pw_02.focus();
                return false;
            }else{
                pw_02.style.border = '1px solid #e4e4e4';
            }
            if(pw_01.value != pw_02.value){
                alert("��й�ȣ�� �ٸ��ϴ�.");
                pw_01.style.border = '1px solid red';
                pw_02.style.border = '1px solid red';
                pw_01.focus();
                return false;
            }else{
                pw_01.style.border = '1px solid #e4e4e4';
                pw_02.style.border = '1px solid #e4e4e4';
            }
//##################################################################################################################################################//
            if(mail_01.value == ""){
                alert("�̸����� �Է��ϼ���.");
                mail_01.style.border = '1px solid red';
                mail_01.focus();
                return false;
            }else{
                mail_01.style.border = '1px solid #e4e4e4';
            }
            if(mail_02.value == ""){
                alert("�̸����� �����ϼ���.");
                mail_02.style.border = '1px solid red';
                mail_02.focus();
                return false;
            }else{
                mail_02.style.border = '1px solid #e4e4e4';
            }
//##################################################################################################################################################//
            if(hp.value == ""){
                alert("�ڵ�����ȣ�� �Է��ϼ���.");
                hp.style.border = '1px solid red';
                hp.focus();
                return false;
            }else{
                hp.style.border = '1px solid #e4e4e4';
            }
//##################################################################################################################################################//
            if(address_01.value == ""){
                alert("�����ȣ�� �Է��ϼ���.");
                address_01.style.border = '1px solid red';
                address_01.focus();
                return false;
            }else{
                address_01.style.border = '1px solid #e4e4e4';
            }
            if(address_02.value == ""){
                alert("�ּҸ� �Է��ϼ���.");
                address_02.style.border = '1px solid red';
                address_02.focus();
                return false;
            }else{
                address_02.style.border = '1px solid #e4e4e4';
            }
            if(address_03.value == ""){
                alert("�������ּҸ� �Է��ϼ���.");
                address_03.style.border = '1px solid red';
                address_03.focus();
                return false;
            }else{
                address_03.style.border = '1px solid #e4e4e4';
            }
            if(blog_00.value == ""){
                alert("��α� URL�� �Է��ϼ���.");
                blog_00.style.border = '1px solid red';
                blog_00.focus();
                return false;
            }else{
                blog_00.style.border = '1px solid #e4e4e4';
            }
            if(excuse.value == ""){
                alert("AK Lover�� �����ؾ� �ϴ� ������ �Է��ϼ���.");
                excuse.style.border = '1px solid red';
                excuse.focus();
                return false;
            }else{
                excuse.style.border = '1px solid #e4e4e4';
            }
            var total = 0;
            var max = excuse_check.length;
            for (var idx = 0; idx < max; idx++) {
                if (eval("excuse_check[" + idx + "].checked") == true){
                    total += 1;
               }
            }
            if(total == "0"){
                alert("AK Lover�� �˰Ե� ��θ� �����ϼž� �մϴ�.");
                return false;
            }else{
            }
//##################################################################################################################################################//
            if(terms_01.checked == ""){
                alert("ȸ������� �����ϼž� �մϴ�.");
                terms_01.style.border = '1px solid red';
                terms_01.focus();
                return false;
            }else{
                terms_01.style.border = '1px solid #e4e4e4';
            }
            if(terms_02.checked == ""){
                alert("������������ �� Ȱ�� ���Ǽ��� �����ϼž� �մϴ�.");
                terms_02.style.border = '1px solid red';
                terms_02.focus();
                return false;
            }else{
                terms_02.style.border = '1px solid #e4e4e4';
            }
            if(terms_03.checked == ""){
                alert("����������޹�ħ�� �����ϼž� �մϴ�.");
                terms_03.style.border = '1px solid red';
                terms_03.focus();
                return false;
            }else{
                terms_03.style.border = '1px solid #e4e4e4';
            }
            form.submit();
//##################################################################################################################################################//
            return true;
        }
    </script>
    <script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>
	<script src="/js/daumAddressApi.js"></script>
        <div class="layer_zip">
            <form name="login_form" action="<?=PATH_HOME?>?board=result" onsubmit="return false;">
            <dl>
                <dt><img src="../image/member/zip1.gif" alt="�����ȣ ã��" /></dt>
                <dd>
                <input id="addr" type="text" class="addr" /><input type="image" src="../image/member/btn_findzip.gif" alt="�ּ�ã��" onclick="hero_ajax('zip2.php', 'view_list', 'addr', 'zip'); return false;"/>
                </dd>
                <dd class="list">
                    <div id="view_list"></div>
                </dd>
                <dd class="tc"><a href="javascript:inputzip();"><img src="../image/member/btn_cancel.gif" alt="�Է�" /></a></dd>
            </dl>
            </form>
        </div>
    <div style="width:706px;"><?//"border:1px solid #e4e4e4"?>
        <div class="page_title">
            <h2><img src="../image/title/title_7_1.gif" alt="ȸ������" /></h2>
        </div>
        <div class="contents">
        <form name="form_next" action="<?=PATH_HOME?>?board=<?=$_GET['board']?>&idx=<?=$_GET['idx']?>&view=07_01" enctype="multipart/form-data" method="post" onsubmit="return false;">
            <input type="hidden" name="hero_drop" value="nick_action||id_action||hero_code_date||hero_pw_01||hero_pw_02||hero_drop||hero_mail_01||hero_mail_02||email_select">
            <input type="hidden" name="hero_code_date" value="<?=Y_m_d?>">
            <input type="hidden" name="hero_table" value="member">
            <input type="hidden" name="hero_jumin" value="<?=$_POST['param_r2']?>">
            <input type="hidden" name="hero_sex" value="<?=$_POST['param_r3']?>">
            <input type="hidden" name="hero_oldday" value="<?=Ymdhis?>">
            <input type="hidden" name="hero_today" value="<?=Ymdhis?>">
            <input type="hidden" name="hero_today_plus" value="<?=Ymdhis?>">
            <input type="hidden" name="hero_total_count" value="0">
            <input type="hidden" name="hero_login_ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
            <input type="hidden" name="hero_info_type" value="<?=$_POST['param_r4']?>">
            <input type="hidden" name="hero_info_di" value="<?=$_POST['param_r5']?>">
            <input type="hidden" name="hero_info_ci" value="<?=$_POST['param_r6']?>">
            <p class="c_orange bold lh35">*�� �ʼ� ���� �׸��Դϴ�!!!</p>
            <table class="member">
                <colgroup>
                    <col width="160px" />
                    <col width="*" />
                </colgroup>
                <tr class="first">
                    <th><img src="../image/member/fd1.gif" alt="���̵�" /></th>
                    <td>
                        <input type="text" name="hero_id" id="hero_id" style="ime-mode:disabled;"/><a href="#"> <img src="../image/member/btn_checkid.gif" alt="���̵��ߺ�üũ"  onclick="hero_ajax('zip2.php', 'id_list', 'hero_id', 'id'); return false;"/></a> <span id="id_list">4~20�� ��밡��</span>
                    </td>
                </tr>
                <tr>
                    <th><img src="../image/member/fd2.gif" alt="��й�ȣ" /></th>
                    <td><input type="password" name="hero_pw_01" id="hero_pw_01" /></td>
                </tr>
                <tr>
                    <th><img src="../image/member/fd3.gif" alt="��й�ȣ Ȯ��" /></th>
                    <td><input type="password" name="hero_pw_02" id="hero_pw_02" /></td>
                </tr>
                <tr>
                    <th><img src="../image/member/fd4.gif" alt="�̸�" /></th>
                    <td><input type="text" name="hero_name" id="hero_name" value="<?=$_POST['param_r1']?>"/></td>
                </tr>
                <tr>
                    <th><img src="../image/member/fd16.gif" alt="�г���" /></th>
                    <td>
                        <input type="text" name="hero_nick" id="hero_nick"/><a href="#"> <img src="../image/member/btn_checkid.gif" alt="�г����ߺ�üũ"  onclick="hero_ajax('zip2.php', 'nick_list', 'hero_nick', 'nick'); return false;"/></a> <span id="nick_list">2~20�� ��밡��</span>
                        <br>�� AK LOVER ī�� Ȱ���� �е��� ����Ʈ ������ ���� ī��� ������ �г������� ������ּ���.
                    </td>
                </tr>
                <tr>
                    <th><img src="../image/member/fd5.gif" alt="�������" /></th>
                    <td>
                        <SELECT id ="year" title="����⵵ ����" class="mr12"></SELECT>
                        <SELECT id ="month" title="����� ����" class="mr12"></SELECT>
                        <SELECT id ="date" title="����� ����" class="mr12"></SELECT>
                        <script type="text/javascript">date_populate("date", "month", "year", "<?=$param_r2_01;?>", "<?=number_format($param_r2_02);?>", "<?=number_format($param_r2_03);?>");</script> 
<!--                        (�� 17��)-->
                    </td>
                </tr>
                <tr>
                    <th><img src="../image/member/fd6.gif" alt="" /></th>
                    <td>
                        <input type="text" name="hero_mail_01" value="" class="w191" style="ime-mode:disabled;"> @
                        <input type="text" name="hero_mail_02" value="" class="w191" style="ime-mode:disabled;">
                        <select name="email_select" id="email_select" onchange='javascript:emailChg();' class="w191">
                            <option value="">�����Է�</option>
                            <option value="paran.com">paran.com</option>
                            <option value="chollian.net">chollian.net</option>
                            <option value="empal.com">empal.com</option>
                            <option value="freechal.com">freechal.com</option>
                            <option value="hotmail.com">hotmail.com</option>
                            <option value="lycos.co.kr">lycos.co.kr</option>
                            <option value="korea.com">korea.com</option>
                            <option value="nate.com">nate.com</option>
                            <option value="naver.com">naver.com</option>
                            <option value="netian.com">netian.com</option>
                            <option value="unitel.co.kr">unitel.co.kr</option>
                            <option value="yahoo.co.kr">yahoo.co.kr</option>
                            <option value="hanmail.net">hanmail.net</option>
                            <option value="daum.net">daum.net</option>
                         </select>
                    </td>
                </tr>
                <tr>
                    <th><img src="../image/member/fd7.gif" alt="�ڵ��� ��ȣ"/></th>
                    <td><input type="text" name="hero_hp" id="hero_hp" style="ime-mode:disabled;"/></td>
                </tr>
                <tr>
                    <th><img src="../image/member/fd8.gif" alt="�����ּ�" /></th>
                    <td>
                        <input type="text" name="hero_address_01" id="hero_address_01" onclick="javascript:btnAddressGet()" class="w190" readonly/>
                        <a href="javascript:btnAddressGet()"><img src="../image/member/btn_zipcode.gif" alt="�����ȣã��" /></a><br />
                        <input type="text" name="hero_address_02" id="hero_address_02" onclick="javascript:btnAddressGet()" class="w390" readonly/><br />
                        <input type="text" name="hero_address_03" id="hero_address_03" class="w390" style="margin-top:5px;" />
                    </td>
                </tr>
                <tr>
                    <th><img src="../image/member/fd9.gif" alt="" /></th>
                    <td class="sns">
                        <label for="sns0">��α� URL</label><input type="text" name="hero_blog_00" value="" id="sns0"  /><br />
                        <label for="sns1">���̽��� URL</label><input type="text" name="hero_blog_01" value="" id="sns1"  /><br />
                        <label for="sns2">Ʈ���� URL</label><input type="text" name="hero_blog_02" value="" id="sns2" /><br />
                        <label for="sns3">īī�����丮 URL</label><input type="text" name="hero_blog_03" value="" id="sns3" /><br />
                        <label for="sns4">�������� URL</label><input type="text" name="hero_blog_04" value="" id="sns4" /><br />
                        <label for="sns5">�׿� SNS URL</label><input type="text" name="hero_blog_05" value="" id="sns5" />
                    </td>
                </tr>
                <tr>
                    <th><img src="../image/member/fd10.gif" alt="ALLOVER�� �����ؾ� �ϴ� ����" /></th>
                    <td><textarea name="hero_excuse" id="hero_excuse" cols="30" rows="5" class="w535"></textarea></td>
                </tr>
                <tr class="last">
                    <th><img src="../image/member/fd11.gif" alt="ALLOVER�� �˰Ե� ���" /></th>
                    <td>

                        <SCRIPT>
                        function check_type_01(cb){
                            for(j = 0; j < 6; j++){
                                if(eval("document.form_next.hero_excuse_check["+j+"].checked")==true){
                                    document.form_next.hero_excuse_check[j].checked = false;
                                    if(j == cb){
                                        document.form_next.hero_excuse_check[j].checked = true;
                                    }
                                }
                            }
                        }
                        </script>
                        <p class="ref">
                            <input type="radio" name="area" value="����" /> &nbsp;���� 
                            <input type="radio" name="area" value="�Ź�"/> &nbsp;�Ź� 
                            <input type="radio" name="area" value="����" /> &nbsp;���� 
                            <input type="radio" name="area" value="��α�" />&nbsp; ��α� 
                            <br/>
                            <input type="radio" name="area" value="����" /> &nbsp;ī�� 
                            <input type="radio" name="area" value="���̽���" /> &nbsp;���̽���
                            <input type="radio" name="area" value="�ν�Ÿ�׷�" /> &nbsp;�ν�Ÿ�׷� 
                            <input type="radio" name="area" value="����" /> &nbsp;����
                            <br/> 
                            <input type="radio" name="area" value="����" /> &nbsp;���� 
                            <input type="radio" name="area" value="��Ÿ" /> &nbsp;��Ÿ
                        </p>
                        <label for="ref6">��Ÿ</label> <input type="text" name="hero_excuse_path" id="hero_excuse_path" class="w390" />
                    </td>
                </tr>
            </table>
            <img src="../image/member/terms1.gif" alt="ȸ�����" class="mt60" />
            <div class="terms">
                <p>
                (2012�� 8�� 25���� �����)</p>
                <p>�̿���</p>
                <p>��1�� ��Ģ</p>
                <p>�� 1�� (�� ��) �� �̿���(���� '���'�̶� �մϴ�)�� &quot;�ְ���(��)�� �ְ��� �йи� ����Ʈ �̿� ��(���� 'ȸ��'�̶� �մϴ�)���� ȸ�簡 �����ϴ� �ְ����߿��� ��ϴ� ������Ʈ ������(���� '����'�� �մϴ�)�� �������� �� �̿뿡 ���� ���� ���װ� ��Ÿ �ʿ��� ������ ��ü������ �������� �������� �մϴ�.</p>
                <p>�� 2�� (����� ȿ�� �� ����) </p>
                <p>�� �� ���񽺸� �̿��ϰ��� �ϴ� ��� �̿��ڿ� ���Ͽ� �� ȿ���� �߻��մϴ�. <br />
                �� �� ����� ������ ������ �Ϻ� ȭ�� �Ǵ� ��Ÿ ��� � ���Ͽ� �� ������ ���������ν� �� ȿ���� �߻��մϴ�. <br />
                �� ȸ��� � �Ǵ� ������ �߿��� ������ ���� ��� �� ����� ���Ƿ� ������ �� ������, ����� ����� �� �� ��2�װ� ���� ������� ���������ν� �� ȿ���� �߻��մϴ�. </p>
                <p>�� 3�� (��� �� ��Ģ) </p>
                <p>�� ����� ��õ��� ���� ������ ������ű⺻��, ������Ż����, ������Ÿ��̿����� � ���� ���� �� ��Ÿ ���ù���, ȸ�簡 ������ ���� ��ħ � ���մϴ�. </p>
                <p>�� 4�� (����� ����) </p>
                <p>�� ������� ����ϴ� ����� ���Ǵ� ������ �����ϴ�. <br />
                1. ȸ �� : ���񽺸� �����ޱ� ���Ͽ� ȸ��� �̿����� ü���ϰų� �̿��� ���̵�(ID)�� �ο����� �ڸ� ���մϴ�. <br />
                2. ���̵� (ID) : ȸ���ĺ��� ȸ���� ���� �̿��� ���Ͽ� ȸ���� �����ϰ� ȸ�簡 �����ϴ� �����ڿ� ������ ���� <br />
                3. �� �� �� ȣ : ȸ���� ��к�ȣ�� ���� ȸ���ڽ��� ������ ���ڿ� ������ ���� <br />
                4. �� �� : ȸ�� �Ǵ� ȸ���� ���� �̿� ���� �� �̿����� �����Ű�� �ǻ�ǥ�� </p>
                <p>�� 5�� (������ ����) <br />
                ȸ��� ȸ������ ȸ�簡 ��ü �����ϴ� ����, Ÿ ��ü�� ���� ������ ����, Ÿ ��ü�� ������ ���� �� ��Ÿ ȸ�翡�� ������ ���ϴ� ���� ���� ���� �����մϴ�. <br />
                ��, ȸ���� ������ �� ���񽺺��� �������� �� ��������� ����ǰų� ����, �� ������ ���� �ֽ��ϴ�. </p>
                <p>�� 2�� ���� �̿���</p>
                <p>�� 6�� (�̿����� ����) </p>
                <p>�� &quot;���� �̿����� �����Ͻʴϱ�?&quot; ��� �̿��û���� ������ ȸ���� &quot;����&quot; ���߸� ������ �� ����� �����ϴ� ������ ���ֵ˴ϴ�. <br />
                �� �̿����� ��7���� ������ ȸ���� �̿��û�� ���Ͽ� ȸ�簡 �³������ν� �����մϴ�. </p>
                <p>�� 7�� (�̿��û) </p>
                <p>�� �� ���񽺸� �̿��ϱ� ���ؼ��� ȸ�� ������ ���Խ�û ��Ŀ��� �䱸�ϴ� ��� �̿��� ������ ����Ͽ� ��û�մϴ�. <br />
                �� ���Խ�û ��Ŀ� �����ϴ� ��� �̿��� ������ ��� ���� �������� ������ ���ֵ˴ϴ�. �Ǹ��̳� ���� ������ �Է����� ���� ����ڴ� ������ ��ȣ�� ���� �� ������ ������ ������ ���� �� �ֽ��ϴ�. </p>
                <p>�� 8�� (���������� ��ȣ �� ���)</p>
                <p>(1) ȸ��� ���� ������ ���ϴ� �ٿ� ���� ȸ���� ���������� ��ȣ�ϱ� ���� ����մϴ�. ���������� ��ȣ �� ��뿡 ���ؼ��� ���� ���� �� ȸ���� �������� ��ȣ��å�� ����˴ϴ�. ��, ȸ���� ���� ����Ʈ �̿��� ��ũ�� ����Ʈ������ ȸ���� �������� ��ȣ��å�� ������� �ʽ��ϴ�. ����, ȸ���� ��й�ȣ ���� Ÿ�ο��� ������� �ʵ��� ö���� �����ؾ� �ϸ� ȸ��� ȸ���� ��å������ ���� ����� ������ ���ؼ� å���� ���� �ʽ��ϴ�.</p>
                <p>(2) ȸ��� ������ ���� ��쿡 ���� ����ϴ� ���� ������ ȸ���� ���������� ��3�ڿ��� ������ �� �ֽ��ϴ�.<br />
                - �������̳� ��Ÿ ���α�����κ��� ���������� ��û ���� ���<br />
                - ȸ���� ���� �Ǵ� ����� ������ �����Ͽ� �������� Ȯ�� ���� ������ȣ ������ ���� �ʿ��� ���<br />
                - ��Ÿ ������ ���� �䱸�Ǵ� ���</p>
                <p>�� 9��(ȸ������ ��뿡 ���� ����) </p>
                <p>�� ȸ��� ��7���� ���� ���� ��û ��Ŀ� ����� ȸ���� ���������� �� �̿����� ����� �� �̿������ ���� ������ ���� �������� �̿��մϴ�. <br />
                �� ȸ�� ������ ȸ��� ������ ��ü�� ������ �� �ֽ��ϴ�. ��, ȸ��� ȸ�� ���� ���� ������ ���� ��ü, ���� ����, ������ ȸ�� ������ ���� ���� ������ �����ϰ� ȸ���� ���Ǹ� ���� �մϴ�. <br />
                �� ȸ���� ȸ�� ���� ������ ���� �������� ���� ������ ���� ���� �� ������ �� �� �ֽ��ϴ�. <br />
                �� ȸ���� ���� ��û ��Ŀ� ȸ�������� �����ϰ�, ȸ�翡 �� ����� ���� �̿��û�� �ϴ� ���� ȸ�簡 �� ����� ���� �̿��û���� ����� ȸ�������� ����, �̿� �� �����ϴ� �Ϳ� �����ϴ� ������ ���ֵ˴ϴ�. </p>
                <p>�� 10��(�̿� ��û�� �³��� ����) </p>
                <p>(1) ȸ��� ��5��, ��6���� ������ ���� �̿��û�� ���Ͽ� ���� ����� �Ǵ� ����� ������ ���� ��쿡 ��Ģ������ ���������� ���� ���� �̿��� �³��մϴ�.<br />
                (2) ȸ��� �Ʒ����׿� �ش��ϴ� ��쿡 ���ؼ� �³��� ������ �� �ֽ��ϴ�.<br />
                - ������ ������ ������ �������� �ƴ��� �̿��û�� ��� <br />
                - ���� ���� �Ǵ� ��ȸ�� �ȳ�� ����, ��ǳ����� ������ �������� ��û�� ���<br />
                - ������ �뵵�� �� ���񽺸� �̿��ϰ��� �ϴ� ��� <br />
                - ������ �߱��� �������� �� ���񽺸� �̿��ϰ��� �ϴ� ��� <br />
                - ���񽺿� ������迡 �ִ� �̿��ڰ� ��û�ϴ� ��� <br />
                - ���� �Ǵ� ����� �����Ͽ� �̿����� ������ ���� �ִ� �̿��ڰ� ��û�ϴ� ���<br />
                - ��Ÿ ������ ���� ������ �����ϸ� ��û�ϴ� ��� <br />
                (3) ȸ��� ���� �̿��û�� ���� �� ȣ�� �ش��ϴ� ��쿡�� �� ��û�� ���Ͽ� �³� ���ѻ����� �ؼҵ� ������ �³��� ������ �� �ֽ��ϴ�.<br />
                - ȸ�簡 ������ ������ ���� ���<br />
                - ȸ���� ����� ������ �ִ� ���<br />
                - ��Ÿ ȸ���� ��å������ �̿�³��� ����� ���<br />
                (4) ȸ��� �̿��û���� ���� ���ɿ��� �����ϴ� �̼������� ��쿡 ���񽺺� �ȳ����� ���ϴ� �ٿ� ���� �³��� ������ �� �ֽ��ϴ�.<br />
                (5) ȸ��� ȸ�� ���� ���� �Ϸ� ���� ��2�� �� ȣ�� ���� ������ �߰ߵ� ��� �̿� �³��� öȸ�� �� �ֽ��ϴ�.</p>
                <p>�� 11�� (�̿���ID �ο� �� ���� ��)</p>
                <p>(1) ȸ��� ȸ���� ���Ͽ� ����� ���ϴ� �ٿ� ���� �̿��� ID�� �ο��մϴ�.<br />
                (2) �̿���ID�� ��Ģ������ ������ �Ұ��ϸ� �ε����� ������ ���Ͽ� ���� �ϰ��� �ϴ� ��쿡�� �ش� ID�� �����ϰ� �簡���ؾ� �մϴ�.<br />
                (3) �̿���ID�� ȸ�� ������ ���� �Ͽ� ȸ�� �Ǵ� ��ȸ�簡 ��ϴ� ����Ʈ�� ȸ��ID�� ����� �� �ֽ��ϴ�.<br />
                (4) �̿���ID�� ���� �� ȣ�� �ش��ϴ� ��쿡�� ȸ���� ��û �Ǵ� ȸ���� �������� ���� �Ǵ� �̿��� ������ �� �ֽ��ϴ�.<br />
                - �̿���ID�� ��ȭ��ȣ �Ǵ� �ֹε�Ϲ�ȣ ������ ��ϵǾ� ���Ȱ ħ�ذ� ����Ǵ� ���<br />
                - Ÿ�ο��� �������� �ְų� ��ǳ��ӿ� ��߳��� ���<br />
                - ȸ��, ȸ���� ���� �Ǵ� ���� ��� ���� ��Ī�� �����ϰų� ���� ���� ����� �ִ� ��� <br />
                - ��Ÿ �ո����� ������ �ִ� ���<br />
                (5) �̿���ID �� ��й�ȣ�� ����å���� ȸ������ �ֽ��ϴ�. �̸� ��Ȧ�� �����Ͽ� �߻��ϴ� ���� �̿���� ���� �Ǵ� ��3�ڿ� ���� �����̿� � ���� å���� ȸ������ ������ ȸ��� �׿� ���� å���� ���� �ʽ��ϴ�.<br />
                (6) ��Ÿȸ�� �������� ���� �� ���� � ���� ������ ���񽺺� �ȳ��� ���ϴ� �ٿ� ���մϴ�.</p>
                <p>��3�� ��������� �ǹ�</p>
                <p>�� 12�� (ȸ���� �ǹ�) </p>
                <p>�� ȸ��� ��19�� �� ��21������ ���� ��츦 �����ϰ� �� ������� ���� �ٿ� ���� �����, ���������� ���񽺸� ������ �� �ֵ��� �ּ��� ����� ���Ͽ��� �մϴ�. <br />
                �� ȸ��� ���񽺿� ���õ� ���� �׻� ����� �� �ִ� ���·� ����, �����ϰ�, ��ְ� �߻��ϴ� ��� ��ü ���� �̸� ����, ������ �� �ֵ��� �ּ��� ����� ���Ͽ��� �մϴ�. </p>
                <p>�� 13�� (���Ȱ�� ��ȣ) </p>
                <p>�� ȸ��� ���񽺿� �����Ͽ� ����� ȸ���� ���������� ������ ���� �³����� Ÿ�ο��� ����, ���� �Ǵ� ������ �� ������, ���� ���� ���� �̿��� ����� �������� ����� �� �����ϴ�. �ٸ�, ���� �� ȣ�� 1�� �ش��ϴ� ��쿡�� �׷����� �ƴ��մϴ�. <br />
                1. ������ɿ� ���Ͽ� ������� �������� ���������κ��� �䱸���� ��� <br />
                2. ���������������ȸ�� ��û�� �ִ� ��� <br />
                3. ��Ÿ ������ɿ� ���� ��� <br />
                �� ��1���� ���� ������, ȸ��� ��������� �����Ͽ� ȸ�� ��ü �Ǵ� �Ϻ��� ���������� ���� ����ڷḦ �ۼ��Ͽ� �̸� ����� �� �ְ�, ���񽺸� ���Ͽ� ȸ���� ��ǻ�Ϳ� ��Ű�� ������ �� �ֽ��ϴ�. �� ��� ȸ���� ��Ű�� ������ �ź��ϰų� ��Ű�� ���ſ� ���Ͽ� ����ϵ��� ����ϴ� ��ǻ���� �������� ������ ������ �� �ֽ��ϴ�. </p>
                <p>�� 14��(ȸ���� �ǹ�) </p>
                <p>�� ȸ���� ���񽺸� �̿��� �� ������ ������ ���� �ʾƾ� �մϴ�. <br />
                1. �ٸ� ȸ���� ID �� ��й�ȣ�� �����ϰ� ����ϴ� ���� <br />
                2. ���񽺸� �̿��Ͽ� ���� ������ ȸ���� �������� �̿� �ܿ� ����,����,����, 2���� ���� ���� ���Ͽ� ����, ����,���,����,����,���� � ����ϰų� ��3�ڿ��� �����ϴ� ���� <br />
                3. Ÿ���� ���� �ջ��Ű�ų� �������� �ִ� ���� <br />
                4. ȸ���� ���۱�, ��3���� ���۱� �� ��Ÿ �Ǹ��� ħ���ϴ� ���� <br />
                5. �������� �� ��ǳ��ӿ� ���ݵǴ� ������ ����,����,����,���� ���� Ÿ�ο��� �����ϴ� ���� <br />
                6. ���˿� ��εȴٰ� ���������� �����Ǵ� ���� <br />
                7. ���񽺿� ���õ� ������ �������̳� ���� ���� �ı� �� ȥ���� ���߽�Ű�� ��ǻ�� ���̷��� �����ڷḦ ��� �Ǵ� �����ϴ� ���� <br />
                8. ������ ������ ��� ������ �� �ִ� ������ �����ϰų� �������� �ǻ翡 ���Ͽ� ���� ������ �����ϴ� ���� <br />
                9. ���������������ȸ, �Һ��ں�ȣ��ü �� ���ŷ� �ִ� ������κ��� �����䱸�� �޴� ���� <br />
                10. ���Ű�������ȸ�� ����, ��� �Ǵ� ��������� �޴� ���Ź� ���� ���� <br />
                11. ��Ÿ ������ɿ� ����Ǵ� ���� <br />
                �� ȸ���� �� ������� �����ϴ� ���װ� ���� �̿�ȳ� �Ǵ� ���ǻ����� �ؼ� �Ͽ��� �մϴ�. <br />
                �� ȸ���� ���뺰�� ȸ�簡 ���� �������׿� �Խ��ϰų� ������ ������ �̿� ���ѻ����� �ؼ��Ͽ��� �մϴ�. <br />
                �� ȸ���� ȸ���� �����³� ���̴� ���񽺸� �̿��Ͽ� ��� ���������� �� �� ������, ���������� ���� �߻��� ����� ���Ͽ� ȸ��� å���� ���� �ʽ��ϴ�. <br />
                �� ȸ���� �̿� ���� ���������� ���Ͽ� ȸ�翡 ���ع���ǹ��� ���ϴ�. <br />
                �� ȸ���� ������ �̿����, ��Ÿ �̿� ���� ������ Ÿ�ο��� �絵, ������ �� ������, �̸� �㺸�� ������ �� �����ϴ�. <br />
                �� ȸ���� ȸ���� �����³� ���̴� ������ ���� �Ǵ� �Ϻ� ���� �� ����� ������ �� �����ϴ�. </p>
                <p>��4�� ���� �̿�</p>
                <p>�� 15�� (ȸ�� ID�� ��й�ȣ ������ ���� ȸ���� �ǹ��� å��) </p>
                <p>�� ���̵�(ID)�� ��й�ȣ�� ���� ��� ����å���� ȸ������ �ֽ��ϴ�. ȸ������ �ο��� ���̵�(ID)�� ��й�ȣ�� ������Ȧ, ������뿡 ���Ͽ� �߻��ϴ� ��� ����� ���� å���� ȸ������ �ֽ��ϴ�. <br />
                �� �ڽ��� ���̵�(ID)�� Ÿ�ο� ���� ���� �̿�Ǵ� ��� ȸ���� �ݵ�� ȸ�翡 �� ����� �뺸�ؾ� �մϴ�. <br />
                �� ȸ���� ���̵�(ID)�� ȸ���� ���� ���� ���� ������ �� �����ϴ�. </p>
                <p>�� 16�� (������ ����) </p>
                <p>ȸ��� ȸ���� ���� �̿� ���� �ʿ䰡 �ִٰ� �����Ǵ� �پ��� ������ ���ؼ� ���ڿ����̳� ���ſ��� ���� ������� ȸ������ ������ �� �ֽ��ϴ�. </p>
                <p>�� 17�� (ȸ���� �Խù�) </p>
                <p>(1) �Խù��̶� ���� ȸ���� ���񽺸� �̿��ϸ鼭 �Խ��� ��, ����, ���� ���ϰ� ��ũ ���� ���մϴ�.<br />
                (2) ȸ���� ���񽺿� ����ϴ� �Խù� ������ ���Ͽ� ���� �Ǵ� Ÿ�ο��� ���س� ��Ÿ ������ �߻��ϴ� ��� ȸ���� �̿� ���� å���� ���ԵǸ�, ȸ��� Ư���� ������ ���� �� �̿� ���Ͽ� å���� ���� �ʽ��ϴ�.<br />
                (3) ȸ��� ���� �� ȣ�� �ش��ϴ� �Խù� ���� ȸ���� ���� ���Ǿ��� �ӽðԽ� �ߴ�, ����, ����,�̵� �Ǵ� ��� �ź� ���� ���� ��ġ�� ���Ҽ� �ֽ��ϴ�.<br />
                - �ٸ� ȸ�� �Ǵ� �� 3�ڿ��� ���� ����� �ְų� ���� �ջ��Ű�� ������ ���<br />
                - �������� �� ��ǳ��ӿ� ���ݵǴ� ������ �����ϰų� ��ũ��Ű�� ���<br />
                - �ҹ����� �Ǵ� ��ŷ�� �����ϴ� ������ ���<br />
                - ������ �������� �ϴ� ������ ���<br />
                - ���˿� ��εȴٰ� ���������� �����Ǵ� ������ ���<br />
                - �ٸ� �̿��� �Ǵ� �� 3���� ���۱� �� ��Ÿ �Ǹ��� ħ���ϴ� ������ ���<br />
                - ������ ��ġ�� �Ǵ��̳� ������ ������ �������� ȸ�簡 ���� ���ݿ� �������� �ʴ´ٰ� �Ǵ��ϴ� ���<br />
                - ȸ�翡�� ������ �Խù� ��Ģ�� ��߳��ų�, �Խ��� ���ݿ� �������� �ʴ� ���<br />
                - ��Ÿ ������ɿ� ����ȴٰ� �ǴܵǴ� ���<br />
                (4) ȸ��� �Խù� � ���Ͽ� ��3�ڷκ��� ���Ѽ�, �������� ���� �Ǹ� ħ�ظ� ������ �Խ��ߴ� ��û�� ���� ��� �̸� �ӽ÷� �Խ��ߴ�(�����ߴ�)�� �� ������, �Խ��ߴ� ��û�ڿ� �Խù� ����� ���� �Ҽ�, ���� ��Ÿ �̿� ���ϴ� ���ñ���� ���� ���� �̷���� ȸ�翡 ������ ��� �̿� �����ϴ�. <br />
                (5) �ش� �Խù� � ���� �ӽðԽ� �ߴ��� �� ���, �Խù��� ����� ȸ���� ��Խ�(�����簳)�� ȸ�翡 ��û�� �� ������, �Խ� �ߴ��Ϸκ��� 3���� ���� �� �Խø� ��û���� �ƴ��� ��� ȸ��� �̸� ������ �� �ֽ��ϴ�.</p>
                <p>�� 18�� (�Խù��� ���� ���۱�)</p>
                <p>(1) ȸ�簡 �ۼ��� �Խù� �Ǵ� ���۹��� ���� ���۱� ��Ÿ ���������� ȸ�翡 �ͼ��մϴ�.,.<br />
                (2) ȸ���� ���� ���� �Խ��� �Խù��� ���۱��� �Խ��� ȸ������ �ͼӵ˴ϴ�. ��, ȸ��� ������ �, ����, ����, ����, ȫ���� �������� ȸ���� ������ ��� ���� �������� ���۱ǹ��� �����ϴ� ������ ���࿡ ��ġ�ǰ� �ո����� ���� ������ ������ ���� ȸ���� ����� �Խù��� ����� �� �ֽ��ϴ�.<br />
                - ���� ������ ȸ�� �Խù��� ����, ����, ����, ����, ����, ���� �� ���۹����� ��ġ�� �ʴ� ���� �������� ���� ���۹� �ۼ�<br />
                - �̵��, ��Ż� �� ���� ���� ��Ʈ�ʿ��� ȸ���� �Խù� ������ ����, ���� Ȥ�� ȫ���ϰ� �ϴ� ��. ��, �� ��� ȸ��� ������ ���� ���� ȸ���� �̿���ID �ܿ� ȸ���� ���������� �������� �ʽ��ϴ�.<br />
                (3) ȸ��� ���� �̿��� ������� ȸ���� �Խù��� �̿��ϰ��� �ϴ� ���, ��ȭ, �ѽ�, ���ڿ��� ���� ����� ���� ������ ȸ���� ���Ǹ� ���� �մϴ�.<br />
                (4) ȸ���� �̿��� ������ �� ��� ���� ������ ��ϵ� �Խù�(ex. ����, ��α�, ����Ȩ ��) ��ü�� �����˴ϴ�. ��, Ÿ�ο� ���� ����, ��� ������ ��Խ� �ǰų� ������ �Խù��� Ÿ���� �Խù��� ���յǾ� �����Ǵ� �Խù�, ���� �Խ��ǿ� ��ϵ� �Խù� ���� �׷����� �ʽ��ϴ�. </p>
                <p>�� 19�� (���� �̿�ð�)</p>
                <p>�� ������ �̿��� ȸ���� ������ �Ǵ� ����� Ư���� ������ ���� �� ���߹��� 1�� 24�ð��� ��Ģ���� �մϴ�. �ٸ�, ��������, �����ġ �� ȸ�簡 ���� ���� �� ��ġ�� �ʿ�� �ϴ� �ð��� �׷����� �ʽ��ϴ�. <br />
                �� ȸ��� ���񽺸� ���������� �����Ͽ� �� �������� �̿밡�� �ð��� ������ ���� �� �ֽ��ϴ�. �� ��� �� ������ ������ �����մϴ�. </p>
                <p>�� 20�� (���� �̿�å��)</p>
                <p>ȸ���� ȸ�翡�� ���������� ������ ��츦 �����ϰ�� ���񽺸� �̿��Ͽ� ��ǰ�� �Ǹ��ϴ� ����Ȱ���� �� �� ������ Ư�� ��ŷ, ���� ���� ����, ��������Ʈ�� ���� �������, ���S/W �ҹ����� ���� �� �� �����ϴ�. �̸� ���� �߻��� ����Ȱ���� ��� �� �ս�, �������� ���� ���� �� ���� ��ġ � ���ؼ��� ȸ�簡 å���� ���� �ʽ��ϴ�. </p>
                <p>�� 21�� (���� ������ ����) </p>
                <p>�� ȸ��� ���� �� ȣ�� �ش��ϴ� ��� ���� ������ ������ �� �ֽ��ϴ�. <br />
                1. ���񽺿� ������ ���� �� ����� ���� �ε����� ��� <br />
                2. ��Ÿ �Ұ��׷��� ������ �ִ� ��� <br />
                �� ȸ��� ����������, ����, ���� ������ ��� �Ǵ� �̿뷮�� ���� ������ �������� ���� �̿뿡 ������ �ִ� ������ ������ ���� �Ǵ� �Ϻθ� ���� �ϰų� ������ �� �ֽ��ϴ�. </p>
                <p>�� 22�� (�����ֿ��� �ŷ�) </p>
                <p>ȸ��� �� ���񽺻� ����Ǿ� �ְų� �� ���񽺸� ���� �������� ����Ȱ���� ȸ���� �����ϰų� ���� �Ǵ� �ŷ��� ����μ� �߻��ϴ� ��� �ս� �Ǵ� ���ؿ� ���� å���� ���� �ʽ��ϴ�. </p>
                <p>�� 23�� (�� ũ) </p>
                <p>�� ���� �Ǵ� ��3�ڴ� ������̵��� ����Ʈ �Ǵ� �ڷῡ ���� ��ũ�� ������ �� �ֽ��ϴ�. <br />
                ȸ��� �׷��� ����Ʈ �� �ڷῡ ���� �ƹ��� �������� �����Ƿ�, ȸ���� ȸ�簡 �׿� ���� �ܺ� ����Ʈ�� �ڷḦ �̿��ϴ� �Ϳ� ���� å���� ������, �׷��� ����Ʈ�� �ڷῡ ����, �Ǵ� �׷κ��� �̿� ������ ����, ����, ��ǰ�̳� ��ῡ ���� ȸ�簡 �ƹ��� ������ ���� �ʰ�, �׿� ���� å���� ������ �����ϰ� �̿� �����մϴ�. ����, ȸ���� �׷��� ����Ʈ�� �ڷῡ ����, �Ǵ� �׸� ���Ͽ� �̿� ������ ����, ��ǰ �Ǵ� ���񽺸� �̿��ϰų� �̸� �ŷ������� ����, �Ǵ� �̿� �����Ͽ� �߱�ǰų� �߱�Ǿ��ٰ� ����Ǵ� ��� ���س� �սǿ� ���Ͽ� ȸ��� ������ �Ǵ� ���������� å���� ���� ������ �����ϰ� �̿� �����մϴ�. <br />
                ��5�� ������� �� �̿�����</p>
                <p>�� 24�� (������� �� �̿�����)<br />
                <br />
                �� ȸ���� ���� �̿����� �����ϰ��� �� ��쿡�� ������ �¶��� �Ǵ� ȸ�簡 ���� ������ �̿����� ���� ȸ�翡 ������û�� �Ͽ��� �մϴ�. <br />
                �� ȸ��� ȸ���� ���� �� ȣ�� 1�� �ش��ϴ� ������ �Ͽ��� ��� ���� ���� ���� �̿����� �����ϰų� �Ǵ� ���� �̿��� ������ �� �ֽ��ϴ�. <br />
                1. Ÿ���� ���� ID �� ��й�ȣ�� ������ ��� <br />
                2. ���� ��� ���Ƿ� ������ ��� <br />
                3. ������ �̸��� �Ǹ��� �ƴ� ��� <br />
                4. ���� ����ڰ� �ٸ� ID�� ���ߵ���� �� ��� <br />
                5. �������� �� ��ǳ��ӿ� ���صǴ� ������ ���Ƿ� ������Ų ��� <br />
                6. ȸ���� ���� �Ǵ� ��ȸ�� ������ ������ �������� ���� �̿��� ��ȹ �Ǵ� ���� �ϴ� ��� <br />
                7. Ÿ���� ���� �ջ��Ű�ų� �������� �ִ� ������ �� ��� <br />
                8. ������ ������ ��� ������ �������� ������ �����ϰų� ���� ������ �����ϴ� ��� <br />
                9. ��ż����� �������̳� ���� ���� �ı��� ���߽�Ű�� ��ǻ�� ���̷��� ���α׷����� �����ϴ� ��� <br />
                10. ȸ��, �ٸ� ȸ�� �Ǵ� ��3���� ���������� ħ���ϴ� ��� <br />
                11. ���������������ȸ �� �ܺα���� ���� �䱸�� �ְų� ���Ű�������ȸ�� ����, ��� �Ǵ� ��������� �޴� ���Ź� ���������� �ִ� ��� <br />
                12. Ÿ���� ��������, �̿���ID �� ��й�ȣ�� �����ϰ� ����ϴ� ��� <br />
                13. ȸ���� ���� ������ �̿��Ͽ� ���� ������ ȸ���� ���� �³� ���� ���� �Ǵ� �����Ű�ų� ��������� �̿��ϴ� ��� <br />
                14. ȸ���� �Խ��� � �������� �����ϰų� ��������Ʈ�� ����(��ũ)�ϴ� ��� <br />
                15. ���� �����̳�, �� ����� �����Ͽ� ��Ÿ ȸ�簡 ���� �̿����ǿ� ������ ��� <br />
                �� ȸ��� ȸ���� �̿����� ü���Ͽ� ���̵�(ID) �� ��й�ȣ�� �ο� ���� �Ŀ��� ȸ���� ���ǿ� ���� ���� �̿��� ���� �� �� �ֽ��ϴ�. <br />
                �� ���� ��2��, ��3���� ȸ����ġ�� ���Ͽ� ȸ���� ȸ�簡 ���� ������ ���� ���ǽ�û�� �� �� �ֽ��ϴ�. <br />
                �� ������ ���ǽ�û�� �����ϴٰ� ȸ�簡 �����ϴ� ���, ȸ��� ��� ������ �̿��� �簳�ؾ� �մϴ�. </p>
                <p>��6�� ���ع�� ��</p>
                <p>�� 25�� (���ع��)</p>
                <p>ȸ��� ���� �̿����� ������ ������ ���� �̿�� �����Ͽ� ȸ���� ���ǳ� ���ǿ� ���� ���� �ƴ� �� ȸ������ �߻��� ��� ���ؿ� ���Ͽ��� å���� ���� �ʽ��ϴ�. ȸ���� ���񽺸� �̿��Կ� �־� ���� �ҹ������� ���Ͽ� ȸ�簡 ���� ȸ�� �̿��� ��3�ڷκ��� ���ع��û��, �Ҽ��� ����� ������ �������⸦ �޴� ��� ���� ȸ���� ȸ���� ��å�� ���Ͽ� ����Ͽ��� �ϸ�, ���� ȸ�簡 ��å���� ���� ���� ���� ȸ���� �׷� ���Ͽ� ȸ�翡 �߻��� ��� ���ظ� ����Ͽ��� �մϴ�. </p>
                <p>�� 26�� (��å����) </p>
                <p>�� ȸ��� õ������ �Ǵ� �̿� ���ϴ� �Ұ��׷����� ���Ͽ� ���񽺸� ������ �� ���� ��쿡�� ���� ������ ���� å���� �����˴ϴ�. <br />
                �� ȸ��� ȸ���� ��å������ ���� ������ �̿���ֿ� ���Ͽ� å���� ���� �ʽ��ϴ�. <br />
                �� ȸ��� ȸ���� ȸ���� ���� �������κ��� ���Ǵ� ������ ���� ���Ͽ��ų� ���� �ڷῡ ���� ��� ���� �Ǵ� �̿����� ���Ͽ� ���ذ� �߻��� ��쿡 �׿� ���� å���� ���� �ʽ��ϴ�. <br />
                �� ȸ��� ȸ���� ���񽺿� ������ ����, �ڷ�, ����� �ŷڵ�, ��Ȯ�� �� �� ���뿡 ���Ͽ��� å���� ���� �ʽ��ϴ�. </p>
                <p>�� 27�� (����)</p>
                <p>(1) ȸ�簡 ȸ���� ���Ͽ� ������ �ϴ� ��� ȸ���� ȸ�翡 ����� ���ڿ��� �ּҷ� �� �� �ֽ��ϴ�.<br />
                (2) ȸ��� ��Ư���ټ� ȸ������ ������ �ؾ� �� ��� ���� �Խ����� ���� 7�� �̻� �Խ������ν� ���� ������ ������ �� �ֽ��ϴ�.</p>
                <p>�� 28��(���ҹ���)</p>
                <p>�� ���� �̿�� �����Ͽ� ȸ��� ȸ�����̿� ������ �߻��� ���, �켱 �ֹ氣�� ������ �ذ��� ���� ������ �����Ͽ��� �մϴ�. <br />
                �� ȸ��� ȸ������ ���￡ ���� �Ҽ��� ����� ��� ȸ��� ȸ���� �����Ͽ� ���ҹ����� ���մϴ�. </p>
                <p>�� Ģ <br />
                - �� ����� 2012�� 8�� 25�Ϻ��� �����մϴ�.<br />
                </p>
            </div>
            <div class="lh35 tr c_orange bold">
                <input type="checkbox" name="hero_terms_01" id="hero_terms_01" value="0" class="bd0"/><label for="term">ȸ������� �����մϴ�.</label>
            </div>
            <img src="../image/member/terms2.gif" alt="������������ �� Ȱ�뵿�Ǽ�" />
            <div class="terms">
                '�ְ���' �� ������ ���������� �߿���ϸ�, "������Ÿ� �̿����� �� ������ȣ"�� ���� ������ �ؼ��ϰ� �ֽ��ϴ�. <br>

                �����ϴ� �������� �׸�: �̸� , ������� , �̸���, ����ó, �����ּ�<br>

                ���������� ���� �� �̿����:  AK Lover Ȱ���� ���� �̸��� Ȥ�� SMS 

                <br>
                ��󿬶�/Ȱ���� ���� ��������/ ��ǰȫ���������� ��<br>

                ���������� ���� �� �̿�Ⱓ: ��簡 ������ ���������� ���������� ���� �� ���� ���� ������ �޼��Ǹ� �ı��մϴ�. 
            </div>
            <div class="lh35 tr c_orange bold">
                <input type="checkbox" name="hero_terms_02" id="hero_terms_02" value="0" class="bd0"/><label for="term2">�����մϴ�.</label>
            </div>
            <img src="../image/member/terms3.gif" alt="����������޹�ħ" />
            <div class="terms">
              <p><strong>���������� �����׸�  �� �̿����</strong></p>
              <p>ȸ���  �̿��� Ȯ��, ��ǰ ��� �� ���?�м��� ���� ������ �ڷ�μ� �̿����� ���⿡ �´� ������  ���񽺸� �����ϱ� ���� �������� �̿����� ���������� ����?�̿��ϰ�  �ֽ��ϴ�. �����ϴ� �������� �׸� ���� ��ü���� �������� �� �̿������  ������ �����ϴ�. </p>
              <p>- ����, ���̵�, ��й�ȣ, i-pin ��ȣ, �ڵ��� ����, �������, ���� ���̹�ī�� ID/�г���: ���� �̿뿡 ���� ���� Ȯ�� ������ �̿�</p>
              <p>- �̸����ּ�, �ڵ��� ��ȣ: �������� ����, �Ҹ� ó�� �� ��Ȱ�� �ǻ���� ����� Ȯ��, �̺�Ʈ ���� ���� �ȳ�</p>
              <p>- �ּ�, ��ȭ��ȣ: ��ǰ ��ۿ� ���� ��Ȯ�� ������� Ȯ��</p>
              <p>��Ÿ  �����׸�(�޴���ȭ ��ȣ, �������, SNS URL): ���θ��� ���񽺸� �����ϱ� ���� �ڷ�</p>
            </div>
            <div class="terms" style="margin-top:25px;">
              <p><strong>���� �� ��� �� ��3�ڿ�  ���� ���� �� ����</strong></p>
              <p>ȸ���  �̿����� ���ǰ� �ְų� ���� ������ ������ ���� ��츦 �����ϰ�� ��� ��쿡�� ������������ �������� �� �̿���������� ������ ������ �Ѿ� �̿����� ���������� �̿��ϰų� ��3�ڿ��� �������� �ʽ��ϴ�.</p>
              <p>�̿�����  ���������� �����ϰų� �����ϴ� ��쿡�� ������ �̿��ڿ��� �����ްų� �����ϴ� �ڰ� �����̸� �ֵ� ����� ��������, ���� �Ǵ� �����Ǵ� ���������׸��� ��������, ���������� �����ϰų� �����ϴ� ������ �������� � ����  ���������� ���ڿ��� �Ǵ� ������ ���� ������ �� �̿� ���� ���Ǹ� ���մϴ�. ����  �̿��ڰ� �ϴ� ���������� ������ �����ϴ��� �������� �� ���Ǹ� öȸ�� �� �ֽ��ϴ�.</p>
              <p>�ٸ�, ������ ��쿡�� ȸ��� �̿����� ���� ���� ���������� ��  ����������޹�ħ ���� ����� ������ �Ѿ� �̿��ϰų� ��3�ڿ���  �����ϴ� ���� �����մϴ�. </p>
              <p>����������  ���� ��������� ���Ͽ� �ʿ��� ���</p>
              <p>����ۼ�, �м����� �Ǵ� �������縦 ���Ͽ� �ʿ��� ���μ� Ư�� ������  �˾ƺ� �� ���� ���·� �����Ͽ� �����ϴ� ���</p>
              <p>�����Ǹ�ŷ��׺�к��忡���ѹ���, �ſ��������̿�׺�ȣ�����ѹ���, ������� �⺻��, ������Ż����, ���漼��, �Һ��ں�ȣ��, �ѱ������, ����Ҽ۹� �� ������ Ư���� ������ �ִ� ���</p>
              <p>ȸ�簡  ������ �Ϻ� �Ǵ� ������ �絵,  �պ�, ��� ������ ���������ڷμ��� �Ǹ��� �ǹ��� �����ϴ� ���, ȸ��� �Ǹ�?�ǹ��� �����ȴٴ� ��� �� �Ǹ�?�ǹ��� �°��� ���� ����, �ּ�, ��ȭ��ȣ ��Ÿ ����ó�� ���� AK  Lover Ȩ�������� �ּ� 30�� �̻� �Խ��ϰų� Ȥ�� ����?���ڿ��� �� ���� ������� �̿��ڿ� �����ϰڽ��ϴ�.</p>
            </div>
            <div class="terms" style="margin-top:25px;">
              <p><strong>���������� ����,�̿�Ⱓ ��  �ı�</strong></p>
              <p>ȸ���  ���������� �������� �Ǵ� �������� ������ �޼��� ������ �̿����� ���������� ��ü ���� �ı��մϴ�. </p>
              <p>ȸ������������  ���: ȸ�������� Ż���ϰų� ȸ������ ����� ��</p>
              <p>���������  ���: ��ǰ �Ǵ� ���񽺰� �ε��ǰų� ������ ��</p>
              <p>��������, �̺�Ʈ ���� ������ ���Ͽ� ������ ���: ���� ��������, �̺�Ʈ ���� ������ ��</p>
              <p>- ���̿�  ��µ� ���������� �м��� �м��ϰų� �Ұ��� ���� �ı�</p>
              <p>- ������  ���� ���·� ����� ���������� ����� ����� �� ���� ����� �޾��� ����Ͽ� ���� </p>
              <p>�ٸ�, ��� �� ���ڻ�ŷ�����ǼҺ��ں�ȣ�����ѹ��� � ���Ͽ� ������ �ʿ伺�� �ִ� ��쿡�� ������ ����  �����Ⱓ �̿����� ���������� ������ �� �ֽ��ϴ�. </p>
              <p>���  �Ǵ� û�� öȸ � ���� ���:  5��</p>
              <p>��ݰ���  �� ��ȭ ���� ���޿� ���� ���:  5��</p>
              <p>�Һ���  �Ҹ� �Ǵ� ���� ó���� ���� ���:  3��</p>
              <p>����  ���Ǹ� �޾� �����ϰ� �ִ� �ŷ��������� ������ ������ �䱸�ϴ� ��� AKmall�� �� ����,Ȯ�� �� �� �ֵ��� ��ġ�մϴ�.</p>
            </div>
            <div class="lh35 tr c_orange bold">
            <span style="color:#999; font-weight:normal; float:left; ">* ȸ�������� ���ؼ��� �������� ����  �̿� ���ǿ� �ݵ�� ���ǰ� �ʿ��մϴ�.</span>
                <input type="checkbox" name="hero_terms_03" id="hero_terms_03" value="0"/><label for="term3">�����մϴ�.</label>
            </div>
          <img src="../image/member/terms4.gif" alt="����������޹�ħ" />
            <div class="terms">
              <p><strong>���������� �����׸�  �� �̿����</strong></p>
              <p>ȸ���  �̿��� Ȯ��, ��ǰ ��� �� ���?�м��� ���� ������ �ڷ�μ� �̿����� ���⿡ �´� ������  ���񽺸� �����ϱ� ���� �������� �̿����� ���������� ����?�̿��ϰ�  �ֽ��ϴ�. �����ϴ� �������� �׸� ���� ��ü���� �������� �� �̿������  ������ �����ϴ�. </p>
              <p>- ����, ���̵�, ��й�ȣ, i-pin ��ȣ, �ڵ��� ����, �������, ���� ���̹�ī�� ID/�г���: ���� �̿뿡 ���� ���� Ȯ�� ������ �̿�</p>
              <p>- �̸����ּ�, �ڵ��� ��ȣ: �������� ����, �Ҹ� ó�� �� ��Ȱ�� �ǻ���� ����� Ȯ��, �̺�Ʈ ���� ���� �ȳ�</p>
              <p>- �ּ�, ��ȭ��ȣ: ��ǰ ��ۿ� ���� ��Ȯ�� ������� Ȯ��</p>
              <p>��Ÿ  �����׸�(�޴���ȭ ��ȣ, �������, SNS URL): ���θ��� ���񽺸� �����ϱ� ���� �ڷ�</p>
            </div>
          <div class="lh35 tr c_orange bold">
            <span style="color:#999; font-weight:normal; float:left; ">
            * ȸ�������� ���ؼ��� �������� �����Ź ���ǿ� �ݵ�� ���ǰ� �ʿ��մϴ�.
            </span>
                <input type="checkbox" name="hero_terms_04" id="hero_terms_04" value="0"/><label for="hero_terms_04">�����մϴ�.</label>
            </div>
            <div class="btngroup tc">
                <input type="image" src="../image/member/btn_signup.gif" alt="ȸ�������ϱ�" onClick="go_submit(this.form)"/>
            </div>
        </form>
        </div>
    </div>
