<?
####################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
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
//if(strcmp($check_count,'0')){echo '<script>alert("이미 가입하셨습니다.");location.href="'.PATH_HOME.'?board=login"</script>';exit;}

/*
<form name="login_form" onsubmit="return false;">
function alert($msg,$command){
    echo "<script language=javascript>    alert('$msg');   $command   </script>";
}
alert("경고다 잘못했다.","history.go(-1);");
<button onclick="alert('죽이는구만')">클릭해봐잉</button>
*/
//$_POST['param_r1'] = '관리자';
//$_POST['param_r2'] = '20130807';
$param_r2_01 = substr($_POST['param_r2'], '0', '4');//년
$param_r2_02 = substr($_POST['param_r2'], '4', '2');//월
$param_r2_03 = substr($_POST['param_r2'], '6', '2');//일
//$_POST['param_r3'] = '1';//성별

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
//에러발생시
//        }
//            var id = document.getElementsByName(id)[0].value;//document.form명.id명
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
                id.style.border = '1px solid #e4e4e4';
            }
            if(nick.value.length < 2){
                alert("닉네임을 입력하세요");
                nick.style.border = '1px solid red';
                nick.focus();//    document.getElementById("input_chat").focus();//    login_form.login_id.focus()
                return false;
            }else if(nick.value.length > 20){
                alert("닉네임을 입력하세요");
                nick.style.border = '1px solid red';
                nick.focus();//    document.getElementById("input_chat").focus();//    login_form.login_id.focus()
                return false;
            }else{
                nick.style.border = '1px solid #e4e4e4';
            }
//##################################################################################################################################################//
            var action = document.getElementById("id_action");
            if(action == undefined){//if(id_action == null){}else{} //alert(typeof(id_action));//undefined
                alert("중복 확인이필요합니다.");
                id.focus();//                form.id_list.focus();
                return false;
            }else if(action.value == "hero_down"){
                alert("사용불가능한 아이디입니다.");
                id.focus();//                alert(action.value);
                return false;
            }else if(action.value == "hero_ok"){//                                alert(action.value);
            }
            var new_action = document.getElementById("nick_action");
            if(new_action == undefined){//if(id_action == null){}else{} //alert(typeof(id_action));//undefined
                alert("중복 확인이필요합니다.");
                nick.focus();//                form.id_list.focus();
                return false;
            }else if(new_action.value == "hero_down"){
                alert("사용불가능한 닉네임입니다.");
                nick.focus();//                alert(action.value);
                return false;
            }else if(new_action.value == "hero_ok"){//                                alert(action.value);
            }
//##################################################################################################################################################//
            if(pw_01.value == ""){
                alert("비밀번호를 입력하세요.");
                pw_01.style.border = '1px solid red';
                pw_01.focus();
                return false;
            }else{
                pw_01.style.border = '1px solid #e4e4e4';
            }
            if(pw_02.value == ""){
                alert("비밀번호를 입력하세요.");
                pw_02.style.border = '1px solid red';
                pw_02.focus();
                return false;
            }else{
                pw_02.style.border = '1px solid #e4e4e4';
            }
            if(pw_01.value != pw_02.value){
                alert("비밀번호가 다름니다.");
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
                alert("이메일을 입력하세요.");
                mail_01.style.border = '1px solid red';
                mail_01.focus();
                return false;
            }else{
                mail_01.style.border = '1px solid #e4e4e4';
            }
            if(mail_02.value == ""){
                alert("이메일을 선택하세요.");
                mail_02.style.border = '1px solid red';
                mail_02.focus();
                return false;
            }else{
                mail_02.style.border = '1px solid #e4e4e4';
            }
//##################################################################################################################################################//
            if(hp.value == ""){
                alert("핸드폰번호를 입력하세요.");
                hp.style.border = '1px solid red';
                hp.focus();
                return false;
            }else{
                hp.style.border = '1px solid #e4e4e4';
            }
//##################################################################################################################################################//
            if(address_01.value == ""){
                alert("우편번호를 입력하세요.");
                address_01.style.border = '1px solid red';
                address_01.focus();
                return false;
            }else{
                address_01.style.border = '1px solid #e4e4e4';
            }
            if(address_02.value == ""){
                alert("주소를 입력하세요.");
                address_02.style.border = '1px solid red';
                address_02.focus();
                return false;
            }else{
                address_02.style.border = '1px solid #e4e4e4';
            }
            if(address_03.value == ""){
                alert("나머지주소를 입력하세요.");
                address_03.style.border = '1px solid red';
                address_03.focus();
                return false;
            }else{
                address_03.style.border = '1px solid #e4e4e4';
            }
            if(blog_00.value == ""){
                alert("블로그 URL을 입력하세요.");
                blog_00.style.border = '1px solid red';
                blog_00.focus();
                return false;
            }else{
                blog_00.style.border = '1px solid #e4e4e4';
            }
            if(excuse.value == ""){
                alert("AK Lover로 선발해야 하는 이유를 입력하세요.");
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
                alert("AK Lover를 알게된 경로를 선택하셔야 합니다.");
                return false;
            }else{
            }
//##################################################################################################################################################//
            if(terms_01.checked == ""){
                alert("회원약관에 동의하셔야 합니다.");
                terms_01.style.border = '1px solid red';
                terms_01.focus();
                return false;
            }else{
                terms_01.style.border = '1px solid #e4e4e4';
            }
            if(terms_02.checked == ""){
                alert("개인정보수집 및 활용 동의서에 동의하셔야 합니다.");
                terms_02.style.border = '1px solid red';
                terms_02.focus();
                return false;
            }else{
                terms_02.style.border = '1px solid #e4e4e4';
            }
            if(terms_03.checked == ""){
                alert("개인정보취급방침에 동의하셔야 합니다.");
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
                <dt><img src="../image/member/zip1.gif" alt="우편번호 찾기" /></dt>
                <dd>
                <input id="addr" type="text" class="addr" /><input type="image" src="../image/member/btn_findzip.gif" alt="주소찾기" onclick="hero_ajax('zip2.php', 'view_list', 'addr', 'zip'); return false;"/>
                </dd>
                <dd class="list">
                    <div id="view_list"></div>
                </dd>
                <dd class="tc"><a href="javascript:inputzip();"><img src="../image/member/btn_cancel.gif" alt="입력" /></a></dd>
            </dl>
            </form>
        </div>
    <div style="width:706px;"><?//"border:1px solid #e4e4e4"?>
        <div class="page_title">
            <h2><img src="../image/title/title_7_1.gif" alt="회원가입" /></h2>
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
            <p class="c_orange bold lh35">*는 필수 가입 항목입니다!!!</p>
            <table class="member">
                <colgroup>
                    <col width="160px" />
                    <col width="*" />
                </colgroup>
                <tr class="first">
                    <th><img src="../image/member/fd1.gif" alt="아이디" /></th>
                    <td>
                        <input type="text" name="hero_id" id="hero_id" style="ime-mode:disabled;"/><a href="#"> <img src="../image/member/btn_checkid.gif" alt="아이디중복체크"  onclick="hero_ajax('zip2.php', 'id_list', 'hero_id', 'id'); return false;"/></a> <span id="id_list">4~20자 사용가능</span>
                    </td>
                </tr>
                <tr>
                    <th><img src="../image/member/fd2.gif" alt="비밀번호" /></th>
                    <td><input type="password" name="hero_pw_01" id="hero_pw_01" /></td>
                </tr>
                <tr>
                    <th><img src="../image/member/fd3.gif" alt="비밀번호 확인" /></th>
                    <td><input type="password" name="hero_pw_02" id="hero_pw_02" /></td>
                </tr>
                <tr>
                    <th><img src="../image/member/fd4.gif" alt="이름" /></th>
                    <td><input type="text" name="hero_name" id="hero_name" value="<?=$_POST['param_r1']?>"/></td>
                </tr>
                <tr>
                    <th><img src="../image/member/fd16.gif" alt="닉네임" /></th>
                    <td>
                        <input type="text" name="hero_nick" id="hero_nick"/><a href="#"> <img src="../image/member/btn_checkid.gif" alt="닉네임중복체크"  onclick="hero_ajax('zip2.php', 'nick_list', 'hero_nick', 'nick'); return false;"/></a> <span id="nick_list">2~20자 사용가능</span>
                        <br>※ AK LOVER 카페 활동자 분들은 포인트 산정을 위해 카페와 동일한 닉네임으로 사용해주세요.
                    </td>
                </tr>
                <tr>
                    <th><img src="../image/member/fd5.gif" alt="생년월일" /></th>
                    <td>
                        <SELECT id ="year" title="출생년도 선택" class="mr12"></SELECT>
                        <SELECT id ="month" title="출생월 선택" class="mr12"></SELECT>
                        <SELECT id ="date" title="출생일 선택" class="mr12"></SELECT>
                        <script type="text/javascript">date_populate("date", "month", "year", "<?=$param_r2_01;?>", "<?=number_format($param_r2_02);?>", "<?=number_format($param_r2_03);?>");</script> 
<!--                        (만 17세)-->
                    </td>
                </tr>
                <tr>
                    <th><img src="../image/member/fd6.gif" alt="" /></th>
                    <td>
                        <input type="text" name="hero_mail_01" value="" class="w191" style="ime-mode:disabled;"> @
                        <input type="text" name="hero_mail_02" value="" class="w191" style="ime-mode:disabled;">
                        <select name="email_select" id="email_select" onchange='javascript:emailChg();' class="w191">
                            <option value="">직접입력</option>
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
                    <th><img src="../image/member/fd7.gif" alt="핸드폰 번호"/></th>
                    <td><input type="text" name="hero_hp" id="hero_hp" style="ime-mode:disabled;"/></td>
                </tr>
                <tr>
                    <th><img src="../image/member/fd8.gif" alt="자택주소" /></th>
                    <td>
                        <input type="text" name="hero_address_01" id="hero_address_01" onclick="javascript:btnAddressGet()" class="w190" readonly/>
                        <a href="javascript:btnAddressGet()"><img src="../image/member/btn_zipcode.gif" alt="우편번호찾기" /></a><br />
                        <input type="text" name="hero_address_02" id="hero_address_02" onclick="javascript:btnAddressGet()" class="w390" readonly/><br />
                        <input type="text" name="hero_address_03" id="hero_address_03" class="w390" style="margin-top:5px;" />
                    </td>
                </tr>
                <tr>
                    <th><img src="../image/member/fd9.gif" alt="" /></th>
                    <td class="sns">
                        <label for="sns0">블로그 URL</label><input type="text" name="hero_blog_00" value="" id="sns0"  /><br />
                        <label for="sns1">페이스북 URL</label><input type="text" name="hero_blog_01" value="" id="sns1"  /><br />
                        <label for="sns2">트위터 URL</label><input type="text" name="hero_blog_02" value="" id="sns2" /><br />
                        <label for="sns3">카카오스토리 URL</label><input type="text" name="hero_blog_03" value="" id="sns3" /><br />
                        <label for="sns4">미투데이 URL</label><input type="text" name="hero_blog_04" value="" id="sns4" /><br />
                        <label for="sns5">그외 SNS URL</label><input type="text" name="hero_blog_05" value="" id="sns5" />
                    </td>
                </tr>
                <tr>
                    <th><img src="../image/member/fd10.gif" alt="ALLOVER로 선발해야 하는 이유" /></th>
                    <td><textarea name="hero_excuse" id="hero_excuse" cols="30" rows="5" class="w535"></textarea></td>
                </tr>
                <tr class="last">
                    <th><img src="../image/member/fd11.gif" alt="ALLOVER를 알게된 경로" /></th>
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
                            <input type="radio" name="area" value="없음" /> &nbsp;없음 
                            <input type="radio" name="area" value="신문"/> &nbsp;신문 
                            <input type="radio" name="area" value="잡지" /> &nbsp;잡지 
                            <input type="radio" name="area" value="블로그" />&nbsp; 블로그 
                            <br/>
                            <input type="radio" name="area" value="까페" /> &nbsp;카페 
                            <input type="radio" name="area" value="페이스북" /> &nbsp;페이스북
                            <input type="radio" name="area" value="인스타그램" /> &nbsp;인스타그램 
                            <input type="radio" name="area" value="지인" /> &nbsp;지인
                            <br/> 
                            <input type="radio" name="area" value="쪽지" /> &nbsp;쪽지 
                            <input type="radio" name="area" value="기타" /> &nbsp;기타
                        </p>
                        <label for="ref6">기타</label> <input type="text" name="hero_excuse_path" id="hero_excuse_path" class="w390" />
                    </td>
                </tr>
            </table>
            <img src="../image/member/terms1.gif" alt="회원약관" class="mt60" />
            <div class="terms">
                <p>
                (2012년 8월 25일자 시행령)</p>
                <p>이용약관</p>
                <p>제1장 총칙</p>
                <p>제 1조 (목 적) 이 이용약관(이하 '약관'이라 합니다)은 &quot;애경산업(주)의 애경산업 패밀리 사이트 이용 고객(이하 '회원'이라 합니다)간에 회사가 제공하는 애경산업㈜에서 운영하는 웹사이트 웹서비스(이하 '서비스'라 합니다)의 가입조건 및 이용에 관한 제반 사항과 기타 필요한 사항을 구체적으로 규정함을 목적으로 합니다.</p>
                <p>제 2조 (약관의 효력 및 변경) </p>
                <p>① 본 서비스를 이용하고자 하는 모든 이용자에 대하여 그 효력을 발생합니다. <br />
                ② 이 약관의 내용은 서비스의 일부 화면 또는 기타 방법 등에 의하여 그 내용을 게재함으로써 그 효력을 발생합니다. <br />
                ③ 회사는 운영 또는 영업상 중요한 사유가 있을 경우 본 약관을 임의로 변경할 수 있으며, 변경된 약관은 본 조 제2항과 같은 방법으로 공지함으로써 그 효력을 발생합니다. </p>
                <p>제 3조 (약관 외 준칙) </p>
                <p>이 약관에 명시되지 않은 사항은 전기통신기본법, 전기통신사업법, 정보통신망이용촉진 등에 관한 법률 및 기타 관련법령, 회사가 별도로 정한 지침 등에 의합니다. </p>
                <p>제 4조 (용어의 정의) </p>
                <p>이 약관에서 사용하는 용어의 정의는 다음과 같습니다. <br />
                1. 회 원 : 서비스를 제공받기 위하여 회사와 이용계약을 체결하거나 이용자 아이디(ID)를 부여받은 자를 말합니다. <br />
                2. 아이디 (ID) : 회원식별과 회원의 서비스 이용을 위하여 회원이 선정하고 회사가 승인하는 영문자와 숫자의 조합 <br />
                3. 비 밀 번 호 : 회원의 비밀보호를 위해 회원자신이 설정한 문자와 숫자의 조합 <br />
                4. 해 지 : 회사 또는 회원이 서비스 이용 이후 그 이용계약을 종료시키는 의사표시 </p>
                <p>제 5조 (서비스의 내용) <br />
                회사는 회원에게 회사가 자체 개발하는 서비스, 타 업체와 협력 개발한 서비스, 타 업체가 개발한 서비스 및 기타 회사에서 별도로 정하는 각종 서비스 등을 제공합니다. <br />
                단, 회사의 사정상 각 서비스별로 제공일정 및 제공방법이 변경되거나 지연, 미 제공될 수도 있습니다. </p>
                <p>제 2장 서비스 이용계약</p>
                <p>제 6조 (이용계약의 성립) </p>
                <p>① &quot;위의 이용약관에 동의하십니까?&quot; 라는 이용신청시의 물음에 회원이 &quot;동의&quot; 단추를 누르면 이 약관에 동의하는 것으로 간주됩니다. <br />
                ② 이용계약은 제7조에 규정한 회원의 이용신청에 대하여 회사가 승낙함으로써 성립합니다. </p>
                <p>제 7조 (이용신청) </p>
                <p>① 본 서비스를 이용하기 위해서는 회사 소정의 가입신청 양식에서 요구하는 모든 이용자 정보를 기록하여 신청합니다. <br />
                ② 가입신청 양식에 기재하는 모든 이용자 정보는 모두 실제 데이터인 것으로 간주됩니다. 실명이나 실제 정보를 입력하지 않은 사용자는 법적인 보호를 받을 수 없으며 서비스의 제한을 받을 수 있습니다. </p>
                <p>제 8조 (개인정보의 보호 및 사용)</p>
                <p>(1) 회사는 관계 법령이 정하는 바에 따라 회원의 개인정보를 보호하기 위해 노력합니다. 개인정보의 보호 및 사용에 대해서는 관련 법령 및 회사의 개인정보 보호정책이 적용됩니다. 단, 회사의 공식 사이트 이외의 링크된 사이트에서는 회사의 개인정보 보호정책이 적용되지 않습니다. 또한, 회원은 비밀번호 등이 타인에게 노출되지 않도록 철저히 관리해야 하며 회사는 회원의 귀책사유로 인해 노출된 정보에 대해서 책임을 지지 않습니다.</p>
                <p>(2) 회사는 다음과 같은 경우에 법이 허용하는 범위 내에서 회원의 개인정보를 제3자에게 제공할 수 있습니다.<br />
                - 수사기관이나 기타 정부기관으로부터 정보제공을 요청 받은 경우<br />
                - 회원의 법령 또는 약관의 위반을 포함하여 부정행위 확인 등의 정보보호 업무를 위해 필요한 경우<br />
                - 기타 법률에 의해 요구되는 경우</p>
                <p>제 9조(회원정보 사용에 대한 동의) </p>
                <p>① 회사는 제7조에 따라 가입 신청 양식에 기재된 회원의 개인정보를 본 이용계약의 이행과 본 이용계약상의 서비스 제공을 위한 목적으로 이용합니다. <br />
                ② 회원 정보는 회사와 제휴한 업체에 제공될 수 있습니다. 단, 회사는 회원 정보 제공 이전에 제휴 업체, 제공 목적, 제공할 회원 정보의 내용 등을 사전에 공지하고 회원의 동의를 얻어야 합니다. <br />
                ③ 회원은 회원 정보 수정을 통해 언제든지 개인 정보에 대한 열람 및 수정을 할 수 있습니다. <br />
                ④ 회원이 가입 신청 양식에 회원정보를 기재하고, 회사에 본 약관에 따라 이용신청을 하는 것은 회사가 본 약관에 따라 이용신청서에 기재된 회원정보를 수집, 이용 및 제공하는 것에 동의하는 것으로 간주됩니다. </p>
                <p>제 10조(이용 신청의 승낙과 제한) </p>
                <p>(1) 회사는 제5조, 제6조의 규정에 의한 이용신청에 대하여 업무 수행상 또는 기술상 지장이 없는 경우에 원칙적으로 접수순서에 따라 서비스 이용을 승낙합니다.<br />
                (2) 회사는 아래사항에 해당하는 경우에 대해서 승낙을 보류할 수 있습니다.<br />
                - 본인의 진정한 정보를 제공하지 아니한 이용신청의 경우 <br />
                - 법령 위반 또는 사회의 안녕과 질서, 미풍양속을 저해할 목적으로 신청한 경우<br />
                - 부정한 용도로 본 서비스를 이용하고자 하는 경우 <br />
                - 영리를 추구할 목적으로 본 서비스를 이용하고자 하는 경우 <br />
                - 서비스와 경쟁관계에 있는 이용자가 신청하는 경우 <br />
                - 법령 또는 약관을 위반하여 이용계약이 해지된 적이 있는 이용자가 신청하는 경우<br />
                - 기타 규정한 제반 사항을 위반하며 신청하는 경우 <br />
                (3) 회사는 서비스 이용신청이 다음 각 호에 해당하는 경우에는 그 신청에 대하여 승낙 제한사유가 해소될 때까지 승낙을 유보할 수 있습니다.<br />
                - 회사가 설비의 여유가 없는 경우<br />
                - 회사의 기술상 지장이 있는 경우<br />
                - 기타 회사의 귀책사유로 이용승낙이 곤란한 경우<br />
                (4) 회사는 이용신청고객이 관계 법령에서 규정하는 미성년자일 경우에 서비스별 안내에서 정하는 바에 따라 승낙을 보류할 수 있습니다.<br />
                (5) 회사는 회원 가입 절차 완료 이후 제2항 각 호에 따른 사유가 발견된 경우 이용 승낙을 철회할 수 있습니다.</p>
                <p>제 11조 (이용자ID 부여 및 변경 등)</p>
                <p>(1) 회사는 회원에 대하여 약관에 정하는 바에 따라 이용자 ID를 부여합니다.<br />
                (2) 이용자ID는 원칙적으로 변경이 불가하며 부득이한 사유로 인하여 변경 하고자 하는 경우에는 해당 ID를 해지하고 재가입해야 합니다.<br />
                (3) 이용자ID는 회원 본인의 동의 하에 회사 또는 자회사가 운영하는 사이트의 회원ID와 연결될 수 있습니다.<br />
                (4) 이용자ID는 다음 각 호에 해당하는 경우에는 회원의 요청 또는 회사의 직권으로 변경 또는 이용을 정지할 수 있습니다.<br />
                - 이용자ID가 전화번호 또는 주민등록번호 등으로 등록되어 사생활 침해가 우려되는 경우<br />
                - 타인에게 혐오감을 주거나 미풍양속에 어긋나는 경우<br />
                - 회사, 회사의 서비스 또는 서비스 운영자 등의 명칭과 동일하거나 오인 등의 우려가 있는 경우 <br />
                - 기타 합리적인 사유가 있는 경우<br />
                (5) 이용자ID 및 비밀번호의 관리책임은 회원에게 있습니다. 이를 소홀이 관리하여 발생하는 서비스 이용상의 손해 또는 제3자에 의한 부정이용 등에 대한 책임은 회원에게 있으며 회사는 그에 대한 책임을 지지 않습니다.<br />
                (6) 기타회원 개인정보 관리 및 변경 등에 관한 사항은 서비스별 안내에 정하는 바에 의합니다.</p>
                <p>제3장 계약당사자의 의무</p>
                <p>제 12조 (회사의 의무) </p>
                <p>① 회사는 제19조 및 제21조에서 정한 경우를 제외하고 이 약관에서 정한 바에 따라 계속적, 안정적으로 서비스를 제공할 수 있도록 최선의 노력을 다하여야 합니다. <br />
                ② 회사는 서비스에 관련된 설비를 항상 운용할 수 있는 상태로 유지, 보수하고, 장애가 발생하는 경우 지체 없이 이를 수리, 복구할 수 있도록 최선의 노력을 다하여야 합니다. </p>
                <p>제 13조 (사생활의 보호) </p>
                <p>① 회사는 서비스와 관련하여 기득한 회원의 개인정보를 본인의 사전 승낙없이 타인에게 누설, 공개 또는 배포할 수 없으며, 서비스 관련 업무 이외의 상업적 목적으로 사용할 수 없습니다. 다만, 다음 각 호의 1에 해당하는 경우에는 그러하지 아니합니다. <br />
                1. 관계법령에 의하여 수사상의 목적으로 관계기관으로부터 요구받은 경우 <br />
                2. 정보통신윤리위원회의 요청이 있는 경우 <br />
                3. 기타 관계법령에 의한 경우 <br />
                ② 제1항의 범위 내에서, 회사는 광고업무와 관련하여 회원 전체 또는 일부의 개인정보에 관한 통계자료를 작성하여 이를 사용할 수 있고, 서비스를 통하여 회원의 컴퓨터에 쿠키를 전송할 수 있습니다. 이 경우 회원은 쿠키의 수신을 거부하거나 쿠키의 수신에 대하여 경고하도록 사용하는 컴퓨터의 브라우저의 설정을 변경할 수 있습니다. </p>
                <p>제 14조(회원의 의무) </p>
                <p>① 회원은 서비스를 이용할 때 다음의 행위를 하지 않아야 합니다. <br />
                1. 다른 회원의 ID 및 비밀번호를 부정하게 사용하는 행위 <br />
                2. 서비스를 이용하여 얻은 정보를 회원의 개인적인 이용 외에 복사,가공,번역, 2차적 저작 등을 통하여 복제, 공연,방송,전시,배포,출판 등에 사용하거나 제3자에게 제공하는 행위 <br />
                3. 타인의 명예를 손상시키거나 불이익을 주는 행위 <br />
                4. 회사의 저작권, 제3자의 저작권 등 기타 권리를 침해하는 행위 <br />
                5. 공공질서 및 미풍양속에 위반되는 내용의 정보,문장,도형,음성 등을 타인에게 유포하는 행위 <br />
                6. 범죄와 결부된다고 객관적으로 인정되는 행위 <br />
                7. 서비스와 관련된 설비의 오동작이나 정보 등의 파괴 및 혼란을 유발시키는 컴퓨터 바이러스 감염자료를 등록 또는 유포하는 행위 <br />
                8. 서비스의 안정적 운영을 방해할 수 있는 정보를 전송하거나 수신자의 의사에 반하여 광고성 정보를 전송하는 행위 <br />
                9. 정보통신윤리위원회, 소비자보호단체 등 공신력 있는 기관으로부터 시정요구를 받는 행위 <br />
                10. 선거관리위원회의 중지, 경고 또는 시정명령을 받는 선거법 위반 행위 <br />
                11. 기타 관계법령에 위배되는 행위 <br />
                ② 회원은 이 약관에서 규정하는 사항과 서비스 이용안내 또는 주의사항을 준수 하여야 합니다. <br />
                ③ 회원은 내용별로 회사가 서비스 공지사항에 게시하거나 별도로 공지한 이용 제한사항을 준수하여야 합니다. <br />
                ④ 회원은 회사의 사전승낙 없이는 서비스를 이용하여 어떠한 영리행위도 할 수 없으며, 영리행위에 의해 발생한 결과에 대하여 회사는 책임을 지지 않습니다. <br />
                ⑤ 회원은 이와 같은 영리행위에 대하여 회사에 손해배상의무를 집니다. <br />
                ⑥ 회원은 서비스의 이용권한, 기타 이용 계약상 지위를 타인에게 양도, 증여할 수 없으며, 이를 담보로 제공할 수 없습니다. <br />
                ⑦ 회원은 회사의 사전승낙 없이는 서비스의 전부 또는 일부 내용 및 기능을 전용할 수 없습니다. </p>
                <p>제4장 서비스 이용</p>
                <p>제 15조 (회원 ID와 비밀번호 관리에 대한 회원의 의무와 책임) </p>
                <p>① 아이디(ID)와 비밀번호에 관한 모든 관리책임은 회원에게 있습니다. 회원에게 부여된 아이디(ID)와 비밀번호의 관리소홀, 부정사용에 의하여 발생하는 모든 결과에 대한 책임은 회원에게 있습니다. <br />
                ② 자신의 아이디(ID)가 타인에 의해 무단 이용되는 경우 회원은 반드시 회사에 그 사실을 통보해야 합니다. <br />
                ③ 회원의 아이디(ID)는 회사의 사전 동의 없이 변경할 수 없습니다. </p>
                <p>제 16조 (정보의 제공) </p>
                <p>회사는 회원이 서비스 이용 도중 필요가 있다고 인정되는 다양한 정보에 대해서 전자우편이나 서신우편 등의 방법으로 회원에게 제공할 수 있습니다. </p>
                <p>제 17조 (회원의 게시물) </p>
                <p>(1) 게시물이라 함은 회원이 서비스를 이용하면서 게시한 글, 사진, 각종 파일과 링크 등을 말합니다.<br />
                (2) 회원이 서비스에 등록하는 게시물 등으로 인하여 본인 또는 타인에게 손해나 기타 문제가 발생하는 경우 회원은 이에 대한 책임을 지게되며, 회사는 특별한 사정이 없는 한 이에 대하여 책임을 지지 않습니다.<br />
                (3) 회사는 다음 각 호에 해당하는 게시물 등을 회원의 사전 동의없이 임시게시 중단, 수정, 삭제,이동 또는 등록 거부 등의 관련 조치를 취할수 있습니다.<br />
                - 다른 회원 또는 제 3자에게 심한 모욕을 주거나 명예를 손상시키는 내용인 경우<br />
                - 공공질서 및 미풍양속에 위반되는 내용을 유포하거나 링크시키는 경우<br />
                - 불법복제 또는 해킹을 조장하는 내용인 경우<br />
                - 영리를 목적으로 하는 광고일 경우<br />
                - 범죄와 결부된다고 객관적으로 인정되는 내용일 경우<br />
                - 다른 이용자 또는 제 3자의 저작권 등 기타 권리를 침해하는 내용인 경우<br />
                - 사적인 정치적 판단이나 종교적 견해의 내용으로 회사가 서비스 성격에 부합하지 않는다고 판단하는 경우<br />
                - 회사에서 규정한 게시물 원칙에 어긋나거나, 게시판 성격에 부합하지 않는 경우<br />
                - 기타 관계법령에 위배된다고 판단되는 경우<br />
                (4) 회사는 게시물 등에 대하여 제3자로부터 명예훼손, 지적재산권 등의 권리 침해를 이유로 게시중단 요청을 받은 경우 이를 임시로 게시중단(전송중단)할 수 있으며, 게시중단 요청자와 게시물 등록자 간에 소송, 합의 기타 이에 준하는 관련기관의 결정 등이 이루어져 회사에 접수된 경우 이에 따릅니다. <br />
                (5) 해당 게시물 등에 대해 임시게시 중단이 된 경우, 게시물을 등록한 회원은 재게시(전송재개)를 회사에 요청할 수 있으며, 게시 중단일로부터 3개월 내에 재 게시를 요청하지 아니한 경우 회사는 이를 삭제할 수 있습니다.</p>
                <p>제 18조 (게시물에 대한 저작권)</p>
                <p>(1) 회사가 작성한 게시물 또는 저작물에 대한 저작권 기타 지적재산권은 회사에 귀속합니다.,.<br />
                (2) 회원이 서비스 내에 게시한 게시물의 저작권은 게시한 회원에게 귀속됩니다. 단, 회사는 서비스의 운영, 전시, 전송, 배포, 홍보의 목적으로 회원의 별도의 허락 없이 무상으로 저작권법에 규정하는 공정한 관행에 합치되게 합리적인 범위 내에서 다음과 같이 회원이 등록한 게시물을 사용할 수 있습니다.<br />
                - 서비스 내에서 회원 게시물의 복제, 수정, 개조, 전시, 전송, 배포 및 저작물성을 해치지 않는 범위 내에서의 편집 저작물 작성<br />
                - 미디어, 통신사 등 서비스 제휴 파트너에게 회원의 게시물 내용을 제공, 전시 혹은 홍보하게 하는 것. 단, 이 경우 회사는 별도의 동의 없이 회원의 이용자ID 외에 회원의 개인정보를 제공하지 않습니다.<br />
                (3) 회사는 전항 이외의 방법으로 회원의 게시물을 이용하고자 하는 경우, 전화, 팩스, 전자우편 등의 방법을 통해 사전에 회원의 동의를 얻어야 합니다.<br />
                (4) 회원이 이용계약 해지를 한 경우 본인 계정에 기록된 게시물(ex. 메일, 블로그, 마이홈 등) 일체는 삭제됩니다. 단, 타인에 의해 보관, 담기 등으로 재게시 되거나 복제된 게시물과 타인의 게시물과 결합되어 제공되는 게시물, 공용 게시판에 등록된 게시물 등은 그러하지 않습니다. </p>
                <p>제 19조 (서비스 이용시간)</p>
                <p>① 서비스의 이용은 회사의 업무상 또는 기술상 특별한 지장이 없는 한 연중무휴 1일 24시간을 원칙으로 합니다. 다만, 정기점검, 긴급조치 등 회사가 서비스 점검 및 조치를 필요로 하는 시간은 그러하지 않습니다. <br />
                ② 회사는 서비스를 일정범위로 분할하여 각 범위별로 이용가능 시간을 별도로 정할 수 있습니다. 이 경우 그 내용을 사전에 공지합니다. </p>
                <p>제 20조 (서비스 이용책임)</p>
                <p>회원은 회사에서 공식적으로 인정한 경우를 제외하고는 서비스를 이용하여 상품을 판매하는 영업활동을 할 수 없으며 특히 해킹, 광고를 통한 수익, 음란사이트를 통한 상업행위, 상용S/W 불법배포 등을 할 수 없습니다. 이를 어기고 발생한 영업활동의 결과 및 손실, 관계기관에 의한 구속 등 법적 조치 등에 관해서는 회사가 책임을 지지 않습니다. </p>
                <p>제 21조 (서비스 제공의 중지) </p>
                <p>① 회사는 다음 각 호에 해당하는 경우 서비스 제공을 중지할 수 있습니다. <br />
                1. 서비스용 설비의 보수 등 공사로 인한 부득이한 경우 <br />
                2. 기타 불가항력적 사유가 있는 경우 <br />
                ② 회사는 국가비상사태, 정전, 제반 설비의 장애 또는 이용량의 폭주 등으로 정상적인 서비스 이용에 지장이 있는 때에는 서비스의 전부 또는 일부를 제한 하거나 중지할 수 있습니다. </p>
                <p>제 22조 (광고주와의 거래) </p>
                <p>회사는 본 서비스상에 게재되어 있거나 본 서비스를 통한 광고주의 판촉활동에 회원이 참여하거나 교신 또는 거래의 결과로서 발생하는 모든 손실 또는 손해에 대해 책임을 지지 않습니다. </p>
                <p>제 23조 (링 크) </p>
                <p>본 서비스 또는 제3자는 월드와이드웹 사이트 또는 자료에 대한 링크를 제공할 수 있습니다. <br />
                회사는 그러한 사이트 및 자료에 대한 아무런 통제권이 없으므로, 회원은 회사가 그와 같은 외부 사이트나 자료를 이용하는 것에 대해 책임이 없으며, 그러한 사이트나 자료에 대한, 또는 그로부터 이용 가능한 내용, 광고, 제품이나 재료에 대해 회사가 아무런 보증도 하지 않고, 그에 대해 책임이 없음을 인정하고 이에 동의합니다. 또한, 회원은 그러한 사이트나 자료에 대한, 또는 그를 통하여 이용 가능한 내용, 상품 또는 서비스를 이용하거나 이를 신뢰함으로 인해, 또는 이와 관련하여 야기되거나 야기되었다고 주장되는 어떠한 손해나 손실에 대하여 회사는 직접적 또는 간접적으로 책임을 지지 않음을 인정하고 이에 동의합니다. <br />
                제5장 계약해지 및 이용제한</p>
                <p>제 24조 (계약해지 및 이용제한)<br />
                <br />
                ① 회원이 서비스 이용계약을 해지하고자 할 경우에는 본인이 온라인 또는 회사가 정한 별도의 이용방법을 통해 회사에 해지신청을 하여야 합니다. <br />
                ② 회사는 회원이 다음 각 호의 1에 해당하는 행위를 하였을 경우 사전 통지 없이 이용계약을 해지하거나 또는 서비스 이용을 중지할 수 있습니다. <br />
                1. 타인의 서비스 ID 및 비밀번호를 도용한 경우 <br />
                2. 서비스 운영을 고의로 방해한 경우 <br />
                3. 가입한 이름이 실명이 아닌 경우 <br />
                4. 동일 사용자가 다른 ID로 이중등록을 한 경우 <br />
                5. 공공질서 및 미풍양속에 저해되는 내용을 고의로 유포시킨 경우 <br />
                6. 회원이 국익 또는 사회적 공익을 저해할 목적으로 서비스 이용을 계획 또는 실행 하는 경우 <br />
                7. 타인의 명예를 손상시키거나 불이익을 주는 행위를 한 경우 <br />
                8. 서비스의 안정적 운영을 방해할 목적으로 정보를 전송하거나 광고성 정보를 전송하는 경우 <br />
                9. 통신설비의 오동작이나 정보 등의 파괴를 유발시키는 컴퓨터 바이러스 프로그램등을 유포하는 경우 <br />
                10. 회사, 다른 회원 또는 제3자의 지적재산권을 침해하는 경우 <br />
                11. 정보통신윤리위원회 등 외부기관의 시정 요구가 있거나 선거관리위원회의 중지, 경고 또는 시정명령을 받는 선거법 위반행위가 있는 경우 <br />
                12. 타인의 개인정보, 이용자ID 및 비밀번호를 부정하게 사용하는 경우 <br />
                13. 회사의 서비스 정보를 이용하여 얻은 정보를 회사의 사전 승낙 없이 복제 또는 유통시키거나 상업적으로 이용하는 경우 <br />
                14. 회원이 게시판 등에 음란물을 게재하거나 음란사이트를 연결(링크)하는 경우 <br />
                15. 관련 법령이나, 본 약관을 포함하여 기타 회사가 정한 이용조건에 위반한 경우 <br />
                ③ 회사는 회원이 이용계약을 체결하여 아이디(ID) 및 비밀번호를 부여 받은 후에라도 회원의 조건에 따른 서비스 이용을 제한 할 수 있습니다. <br />
                ④ 본조 제2항, 제3항의 회사조치에 대하여 회원은 회사가 정한 절차에 따라 이의신청을 할 수 있습니다. <br />
                ⑤ 전항의 이의신청이 정당하다고 회사가 인정하는 경우, 회사는 즉시 서비스의 이용을 재개해야 합니다. </p>
                <p>제6장 손해배상 등</p>
                <p>제 25조 (손해배상)</p>
                <p>회사는 서비스 이용요금이 무료인 동안의 서비스 이용과 관련하여 회사의 고의나 과실에 의한 것이 아닌 한 회원에게 발생한 어떠한 손해에 대하여도 책임을 지지 않습니다. 회원이 서비스를 이용함에 있어 행한 불법행위로 인하여 회사가 당해 회원 이외의 제3자로부터 손해배상청구, 소송을 비롯한 각종의 이의제기를 받는 경우 당해 회원은 회사의 면책을 위하여 노력하여야 하며, 만일 회사가 면책되지 못한 경우는 당해 회원은 그로 인하여 회사에 발생한 모든 손해를 배상하여야 합니다. </p>
                <p>제 26조 (면책사항) </p>
                <p>① 회사는 천재지변 또는 이에 준하는 불가항력으로 인하여 서비스를 제공할 수 없는 경우에는 서비스 제공에 관한 책임이 면제됩니다. <br />
                ② 회사는 회원의 귀책사유로 인한 서비스의 이용장애에 대하여 책임을 지지 않습니다. <br />
                ③ 회사는 회원이 회사의 서비스 제공으로부터 기대되는 이익을 얻지 못하였거나 서비스 자료에 대한 취사 선택 또는 이용으로 인하여 손해가 발생한 경우에 그에 대해 책임을 지지 않습니다. <br />
                ④ 회사는 회원이 서비스에 게재한 정보, 자료, 사실의 신뢰도, 정확성 등 그 내용에 관하여는 책임을 지지 않습니다. </p>
                <p>제 27조 (통지)</p>
                <p>(1) 회사가 회원에 대하여 통지를 하는 경우 회원이 회사에 등록한 전자우편 주소로 할 수 있습니다.<br />
                (2) 회사는 불특정다수 회원에게 통지를 해야 할 경우 공지 게시판을 통해 7일 이상 게시함으로써 개별 통지에 갈음할 수 있습니다.</p>
                <p>제 28조(관할법원)</p>
                <p>① 서비스 이용과 관련하여 회사와 회원사이에 분쟁이 발생한 경우, 우선 쌍방간에 분쟁의 해결을 위해 성실히 협의하여야 합니다. <br />
                ② 회사와 회원간의 분쟁에 대해 소송이 제기될 경우 회사와 회원이 협의하여 관할법원을 정합니다. </p>
                <p>부 칙 <br />
                - 이 약관은 2012년 8월 25일부터 시행합니다.<br />
                </p>
            </div>
            <div class="lh35 tr c_orange bold">
                <input type="checkbox" name="hero_terms_01" id="hero_terms_01" value="0" class="bd0"/><label for="term">회원약관에 동의합니다.</label>
            </div>
            <img src="../image/member/terms2.gif" alt="개인정보수집 및 활용동의서" />
            <div class="terms">
                '애경산업' 은 고객님의 개인정보를 중요시하며, "정보통신망 이용촉진 및 정보보호"에 관한 법률을 준수하고 있습니다. <br>

                수집하는 개인정보 항목: 이름 , 생년월일 , 이메일, 연락처, 자택주소<br>

                개인정보의 수집 및 이용목적:  AK Lover 활동에 따른 이메일 혹은 SMS 

                <br>
                비상연락/활동에 따른 혜택제공/ 제품홍보정보제공 등<br>

                개인정보의 보유 및 이용기간: 당사가 수집한 개인정보는 개인정보의 수집 및 제공 받은 목적이 달성되면 파기합니다. 
            </div>
            <div class="lh35 tr c_orange bold">
                <input type="checkbox" name="hero_terms_02" id="hero_terms_02" value="0" class="bd0"/><label for="term2">동의합니다.</label>
            </div>
            <img src="../image/member/terms3.gif" alt="개인정보취급방침" />
            <div class="terms">
              <p><strong>개인정보의 수집항목  및 이용목적</strong></p>
              <p>회사는  이용자 확인, 제품 배송 및 통계?분석을 통한 마케팅 자료로서 이용자의 취향에 맞는 최적의  서비스를 제공하기 위한 목적으로 이용자의 개인정보를 수집?이용하고  있습니다. 수집하는 개인정보 항목에 따른 구체적인 수집목적 및 이용목적은  다음과 같습니다. </p>
              <p>- 성명, 아이디, 비밀번호, i-pin 번호, 핸드폰 인증, 생년월일, 기존 네이버카페 ID/닉네임: 서비스 이용에 따른 본인 확인 절차에 이용</p>
              <p>- 이메일주소, 핸드폰 번호: 고지사항 전달, 불만 처리 등 원활한 의사소통 경로의 확보, 이벤트 정보 등의 안내</p>
              <p>- 주소, 전화번호: 물품 배송에 대한 정확한 배송지의 확보</p>
              <p>기타  선택항목(휴대전화 번호, 생년월일, SNS URL): 개인맞춤 서비스를 제공하기 위한 자료</p>
            </div>
            <div class="terms" style="margin-top:25px;">
              <p><strong>목적 외 사용 및 제3자에  대한 제공 및 공유</strong></p>
              <p>회사는  이용자의 동의가 있거나 관련 법령의 규정에 의한 경우를 제외하고는 어떠한 경우에도 『개인정보의 수집목적 및 이용목적』에서 고지한 범위를 넘어 이용자의 개인정보를 이용하거나 제3자에게 제공하지 않습니다.</p>
              <p>이용자의  개인정보를 제공하거나 공유하는 경우에는 사전에 이용자에게 제공받거나 공유하는 자가 누구이며 주된 사업이 무엇인지, 제공 또는 공유되는 개인정보항목이 무엇인지, 개인정보를 제공하거나 공유하는 목적이 무엇인지 등에 대해  개별적으로 전자우편 또는 서면을 통해 고지한 후 이에 대한 동의를 구합니다. 또한  이용자가 일단 개인정보의 제공에 동의하더라도 언제든지 그 동의를 철회할 수 있습니다.</p>
              <p>다만, 다음의 경우에는 회사는 이용자의 동의 없이 개인정보를 이  개인정보취급방침 에서 명시한 범위를 넘어 이용하거나 제3자에게  제공하는 것이 가능합니다. </p>
              <p>서비스제공에  따른 요금정산을 위하여 필요한 경우</p>
              <p>통계작성, 학술연구 또는 시장조사를 위하여 필요한 경우로서 특정 개인을  알아볼 수 없는 형태로 가공하여 제공하는 경우</p>
              <p>금융실명거래및비밀보장에관한법률, 신용정보의이용및보호에관한법률, 전기통신 기본법, 전기통신사업법, 지방세법, 소비자보호법, 한국은행법, 형사소송법 등 법률에 특별한 규정이 있는 경우</p>
              <p>회사가  영업의 일부 또는 전부의 양도,  합병, 상속 등으로 서비스제공자로서의 권리와 의무를 이전하는 경우, 회사는 권리?의무가 이전된다는 사실 및 권리?의무를 승계한 자의 성명, 주소, 전화번호 기타 연락처에 대해 AK  Lover 홈페이지에 최소 30일 이상 게시하거나 혹은 서면?전자우편 그 밖의 방법으로 이용자에 통지하겠습니다.</p>
            </div>
            <div class="terms" style="margin-top:25px;">
              <p><strong>개인정보의 보유,이용기간 및  파기</strong></p>
              <p>회사는  개인정보의 수집목적 또는 제공받은 목적이 달성된 때에는 이용자의 개인정보를 지체 없이 파기합니다. </p>
              <p>회원가입정보의  경우: 회원가입을 탈퇴하거나 회원에서 제명된 때</p>
              <p>배송정보의  경우: 물품 또는 서비스가 인도되거나 제공된 때</p>
              <p>설문조사, 이벤트 등의 목적을 위하여 수집한 경우: 당해 설문조사, 이벤트 등이 종료한 때</p>
              <p>- 종이에  출력된 개인정보는 분쇄기로 분쇄하거나 소각을 통해 파기</p>
              <p>- 전자적  파일 형태로 저장된 개인정보는 기록을 재생할 수 없는 기술적 받업을 사용하여 삭제 </p>
              <p>다만, 상법 및 전자상거래등에서의소비자보호에관한법률 등에 의하여 보존할 필요성이 있는 경우에는 다음과 같이  일정기간 이용자의 개인정보를 보유할 수 있습니다. </p>
              <p>계약  또는 청약 철회 등에 관한 기록:  5년</p>
              <p>대금결제  및 재화 등의 공급에 관한 기록:  5년</p>
              <p>소비자  불만 또는 분쟁 처리에 관한 기록:  3년</p>
              <p>고객의  동의를 받아 보유하고 있는 거래정보등을 고객께서 열람을 요구하는 경우 AKmall은 그 열람,확인 할 수 있도록 조치합니다.</p>
            </div>
            <div class="lh35 tr c_orange bold">
            <span style="color:#999; font-weight:normal; float:left; ">* 회원가입을 위해서는 개인정보 수집  이용 동의에 반드시 동의가 필요합니다.</span>
                <input type="checkbox" name="hero_terms_03" id="hero_terms_03" value="0"/><label for="term3">동의합니다.</label>
            </div>
          <img src="../image/member/terms4.gif" alt="개인정보취급방침" />
            <div class="terms">
              <p><strong>개인정보의 수집항목  및 이용목적</strong></p>
              <p>회사는  이용자 확인, 제품 배송 및 통계?분석을 통한 마케팅 자료로서 이용자의 취향에 맞는 최적의  서비스를 제공하기 위한 목적으로 이용자의 개인정보를 수집?이용하고  있습니다. 수집하는 개인정보 항목에 따른 구체적인 수집목적 및 이용목적은  다음과 같습니다. </p>
              <p>- 성명, 아이디, 비밀번호, i-pin 번호, 핸드폰 인증, 생년월일, 기존 네이버카페 ID/닉네임: 서비스 이용에 따른 본인 확인 절차에 이용</p>
              <p>- 이메일주소, 핸드폰 번호: 고지사항 전달, 불만 처리 등 원활한 의사소통 경로의 확보, 이벤트 정보 등의 안내</p>
              <p>- 주소, 전화번호: 물품 배송에 대한 정확한 배송지의 확보</p>
              <p>기타  선택항목(휴대전화 번호, 생년월일, SNS URL): 개인맞춤 서비스를 제공하기 위한 자료</p>
            </div>
          <div class="lh35 tr c_orange bold">
            <span style="color:#999; font-weight:normal; float:left; ">
            * 회원가입을 위해서는 개인정보 취급위탁 동의에 반드시 동의가 필요합니다.
            </span>
                <input type="checkbox" name="hero_terms_04" id="hero_terms_04" value="0"/><label for="hero_terms_04">동의합니다.</label>
            </div>
            <div class="btngroup tc">
                <input type="image" src="../image/member/btn_signup.gif" alt="회원가입하기" onClick="go_submit(this.form)"/>
            </div>
        </form>
        </div>
    </div>
