<?
if(!defined('_HEROBOARD_'))exit;

if($_SESSION["temp_code"]) {
	error_location("�α��� �����Դϴ�.\\n�ùٸ� ��η� �̿��� �ּ���.","/main/index.php");
}
?>

<link rel="stylesheet" type="text/css" href="/css/front/member.css" />
	<div class="contents_area findpw_wrap mu_member"> 
		<div class="notice">
			<div class="f_cs">
				<img src="/img/front/member/findicon.png" alt="��ǳ��">
				<p class="noti_txt">
					���̵� �����̳���?<br>
					�Ʒ��� ��������� �����Ͻð� ������ �Է����ּ���.
				</p>
				<p class="noti_txt" style="display: none;">
					��й�ȣ�� �����̳���?<br>
					�Ʒ��� ��������� �����Ͻð� ������ �Է����ּ���.
				</p>
			</div>
		</div>
		<div class="id_tit f_b">
			<p class="fz36 bold on">���̵� ã��</p>
			<span></span>
			<p class="fz36 bold rel">��й�ȣ ã��</p>
		</div>       
        <div id="id_serch">   
			<div class="findbx findid on">
				<div class="input_wrap">
					<p class="fz16 fw500">�̸�</p>
					<input type="text" name="uid" id="uid" class="c2" placeholder="�̸��� �Է��� �ּ���.">
				</div>
				<div class="input_wrap">
					<p class="fz16 fw500">���� ����(��_19980203)</p>
					<input type="text" name="jumin" id="jumin" onKeyUp="if(this.value.length >= 8)email.focus();" maxlength="8" numberOnly style="ime-mode:disabled;" placeholder="������ �Է��� �ּ���.">
				</div>
				<div class="input_wrap">
					<p class="fz16 fw500">�̸���</p>
					<input type="text" name="email" id="email" placeholder="�̸����� �Է��� �ּ���.">
				</div>
				<!--!!!!!!!! [���߿�û] ��������� alert������� ���̵� ����Ǵ°� �ƴ϶� �˾��������� �����ؾ��մϴ�[��] !!!!!!!!  -->
				<div class="Btn f_c">
					<div type="text" alt="send" onclick="find_IdPw('zip3.php', '', 'uid', 'jumin', 'email', 'id'); return false;" class="btn_submit btn_black">���̵� ã��</div>
				</div>
				<!--//////////// end ////////////  -->	
				<div class="term dis-no find_IdPw">
					<div class="inner rel">
						<h2 class="t_c fz24 bold">���̵� ã��</h2>
						<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="�ݱ�"></div>							
						<!--!!!!!!!! [���߿�û] Ȯ�ε� ���̵� [��]////////////  -->
						<div class="cont t_c find_id dis-no">
							<p class="fz18 fw500 gray08 t_c">������ ���̵� �˷��帳�ϴ�.</p>
							<p class="idinfo t_c fz20 fw600">
								[��ID]
							</p>
						</div>
						<!--!!!!!!!! [���߿�û] or ȸ������ ����ġ�� [��]////////////  -->
						<div class="cont t_c no_find_id dis-no">
							<p class="idinfo t_c fz17 fw600">
								<img src="/img/front/icon/warning.webp" alt="���"><br>
								��ġ�ϴ� ȸ�� ������ �����ϴ�.<br>
								�Է��Ͻ� ������ Ȯ���Ͽ� �ּ���.
							</p>
						</div>
					</div>	
				</div>
			</div>  
			<div class="findbx findpw"> 					
				<div class="input_wrap">
					<p class="fz16 fw500">���̵�</p>
					<input type="text" name="uid2" id="uid2" placeholder="���̵� �Է��� �ּ���.">
				</div>
				<!--!!!!!!!! [���߿�û] ������ ���� �̸����� ������ϴ�  [��]////////////  -->
				<div class="input_wrap">
					<p class="fz16 fw500">�̸�</p>
					<input type="text" name="hero_name" id="hero_name" placeholder="�̸��� �Է��� �ּ���.">
				</div>
				<div class="input_wrap">
					<p class="fz16 fw500">�������� ���</p>
					<ul class="certify_icon f_cs">
						<li><p class="input_radio"><input type="radio" name="" id="" value="" checked/><label for="" class="input_chk_label">�޴��� ��ȣ</label></p></li>
					</ul>
				</div>
                <div class="input_wrap certify">
                    <p class="fz16 fw500">�޴�����ȣ</p>
                    <div class="number_bx">
                        <input type="text" name="hero_hp1" id="hero_hp1" maxlength="4" numberOnly>
                        - <input type="text" name="hero_hp2" id="hero_hp2" maxlength="4" numberOnly>
                        - <input type="text" name="hero_hp3" id="hero_hp3" maxlength="4" numberOnly>
                    </div>
                </div>
                <div class="Btn f_c">
                    <a href="javascript:;" onClick="sencAuthCode()" class="btn_submit btn_black">�����ڵ� �ޱ�</a>
                </div>
                <div class="input_wrap">
                    <p class="fz16 fw500">�����ڵ�</p>
                    <div class="number_bx">
                        <input type="text" name="authCode" id="authCode" maxlength="6">
                    </div>
                </div>
				<!--!!!!!!!! [���߿�û] ��ȭ��ȣ ���� ���� [��]!!!!!!!!  -->
				<div class="Btn f_c">
					<a href="javascript:;" onClick="searchPassword()" class="btn_submit btn_black">��й�ȣ ã��</a>
				</div>
				<!--//////////// end ////////////  -->	
				<div class="term pw_popup dis-no">
					<div class="inner rel">
                        <div class="find_pw dis-no">
                            <!--!!!!!!!! [���߿�û] ��й�ȣ ���� -- �ϴ� ��ȿ�� �˻� ���� �������������� �����Խ��ϴ� ���� ���� ��Ź�帳�ϴ� [��]////////////  -->
                            <input type="hidden" id="pwTF" value="false">
                            <h2 class="t_c fz24 bold">��й�ȣ ����</h2>
                            <div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="�ݱ�"></div>
                            <div class="cont">
                                <div class="input_wrap">
                                    <p class="fz16 fw500">�� ��й�ȣ</p>
                                    <input type="password" name="newPw" id="newPw" onkeyup="chPwdTF(this);" class="editPwInputArea" maxlength="16"  placeholder="����, ����, Ư����ȣ�� �����Ͽ� 8�ڸ� �̻� �Է����ּ���">
                                    <span id="newPwText"></span>
                                </div>
                                <div class="input_wrap">
                                    <p class="fz16 fw500">�� ��й�ȣ Ȯ��</p>
                                    <input type="password" name="chNewPw" id="chNewPw" onkeyup="chPwdTF(this);" class="editPwInputArea" maxlength="16" placeholder="����, ����, Ư����ȣ�� �����Ͽ� 8�ڸ� �̻� �Է����ּ���">
                                    <span id="chNewPwText"></span>
                                </div>
                            </div>
                            <div class="Btn f_c">
                                <a href="javascript:;" onClick="changePassword()" class="btn_submit btn_black">��й�ȣ ����</a>
                            </div>
                        </div>
						<!--!!!!!!!! end ////////////  -->	
						<!--!!!!!!!! [���߿�û] or ȸ������ ����ġ�� [��]////////////  -->
                        <div class="no_find_pw dis-no">
                            <h2 class="t_c fz24 bold">��й�ȣ ã��</h2>
                            <div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="�ݱ�"></div>
                            <div class="cont t_c">
                                <p class="idinfo t_c fz17 fw600">
                                    <img src="/img/front/icon/warning.webp" alt="���"><br>
                                    ��ġ�ϴ� ȸ�� ������ �����ϴ�.<br>
                                    �Է��Ͻ� ������ Ȯ���Ͽ� �ּ���.
                                </p>
                            </div>
                        </div>
						<!--!!!!!!!! end ////////////  -->			
					</div>	
				</div>	
			</div>  
			</br>
		</div>
    </div>
<script>

$(document).ready(function(){
	// ���̵�, ��й�ȣ tab 
	const notiTxt = $('.noti_txt');
	const idTit = $('.id_tit > p');
	const idCont = $('.findbx');
	$.each(idTit, function(idx, item){
		$(this).click(function(){
			idTit.removeClass('on');
			$(this).addClass('on');
			idCont.removeClass('on');
			idCont.eq(idx).addClass('on');
			notiTxt.hide();
			notiTxt.eq(idx).show();
		});
	});
	// ��ü���� �˾� �ݱ�
	$('.term .btn_x').click(function(){
		$(this).parents('.term').addClass('dis-no');

        //���̵� ã��
        $(".find_id").addClass("dis-no");
        $(".no_find_id").addClass("dis-no");
        //��й�ȣ ã��
        $(".find_pw").addClass("dis-no");
        $(".no_find_pw").addClass("dis-no");
	});	
	// ������� tab 
	const cerDiv = $('.certify');
	const cerTab = $('.certify_icon > li');
	const cerInput = $('.certify_icon > li input');
	// const idCont = $('.findbx');
	$.each(cerTab, function(idx, item){
		$(this).click(function(){
			cerInput.prop('checked', false);
			cerInput.eq(idx).prop('checked', true);
			cerDiv.hide();
			cerDiv.eq(idx).show();
		});
	});
	// �̸��� �����Է�
	emailChg =function(){
		if(email_select.value != "")  $('#hero_mail_02').attr('readonly', true);
		else $('#hero_mail_02').attr('readonly', false);
		hero_mail_02.value = email_select.value;
	}
    //�����ڵ� �ޱ�
    sencAuthCode = function(){
        if(!$("#uid2").val()) {
            alert("���̵� �Է��� �ּ���.");
            $("#uid2").focus();
            return;
        }

        if(!$("#hero_hp1").val() || !$("#hero_hp2").val() || !$("#hero_hp3").val()) {
            alert("�޴�����ȣ�� �Է��� �ּ���.");
            $("#hero_hp1").focus();
            return;
        }

        var hero_hp = $("#hero_hp1").val()+"-"+$("#hero_hp2").val()+"-"+$("#hero_hp3").val();

        var param = "type=sendAuth&hero_id="+$("#uid2").val()+"&hero_name="+$("#hero_name").val()+"&hero_hp="+hero_hp;

        $.ajax({
            url:"/main/zip3.php"
            ,data:param
            ,type:"post"
            ,dataType:"html"
            ,success:function(d){
                if(d == $("#uid2").val()){
                    alert('�����ڵ尡 �߼۵Ǿ����ϴ�.');
                }else {
                    alert(d);
                }
            },error:function(e){
                console.log(e);
                alert("������ �߻��߽��ϴ�.\n�����ڿ��� ������ �ּ���.");
            }
        })
    }
    //��ȿ���˻�
    searchPassword = function(){

        if(!$("#uid2").val()) {
            alert("���̵� �Է��� �ּ���.");
            $("#uid2").focus();
            return;
        }

        if(!$("#hero_hp1").val() || !$("#hero_hp2").val() || !$("#hero_hp3").val()) {
            alert("�޴�����ȣ�� �Է��� �ּ���.");
            $("#hero_hp1").focus();
            return;
        }

        if(!$("#authCode").val()) {
            alert("�����ڵ带 �Է��� �ּ���.");
            $("#authCode").focus();
            return;
        }

        var hero_hp = $("#hero_hp1").val()+"-"+$("#hero_hp2").val()+"-"+$("#hero_hp3").val();

        var param = "type=pw2&hero_id="+$("#uid2").val()+"&hero_name="+$("#hero_name").val()+"&hero_hp="+hero_hp+"&auth="+$("#authCode").val();

        $.ajax({
            url:"/main/zip3.php"
            ,data:param
            ,type:"post"
            ,dataType:"html"
            ,success:function(d){
                $(".pw_popup").removeClass("dis-no");
                if(d == $("#uid2").val()){
                    $(".find_pw").removeClass("dis-no");
                }else {
                    $(".no_find_pw").removeClass("dis-no");
                }
            },error:function(e){
                console.log(e);
                alert("������ �߻��߽��ϴ�.\n�����ڿ��� ������ �ּ���.");
            }
        })
    }
    //��й�ȣ ����
    changePassword = function(){
        var param = "type=chgpw&hero_id="+$("#uid2").val()+"&newPw="+$("#newPw").val()+"&chNewPw="+$("#chNewPw").val();

        if(pwTF.value == 'false') {
            return;
        }

        $.ajax({
            url:"/main/zip3.php"
            ,data:param
            ,type:"post"
            ,dataType:"html"
            ,success:function(d){
                if(d == $("#uid2").val()){
                    alert('��й�ȣ�� ����Ǿ����ϴ�.');
                    location.reload(); // /main/index.php?board=login ����� ���ߵ��� ������?
                }else {
                    alert(d);
                }
            },error:function(e){
                console.log(e);
                alert("������ �߻��߽��ϴ�.\n�����ڿ��� ������ �ּ���.");
            }
        })
    }
})

//��й�ȣ ��ȿ���˻� -- ���������� �������� �����ͼ� ��ȿ�� �˻絵 ���� ���� ��Ź�帳�ϴ�
function chPwdTF(obj){
    var newPw = document.getElementById("newPw");
    var chNewPw = document.getElementById("chNewPw");

    var newPwText = document.getElementById("newPwText");
    var chNewPwText = document.getElementById("chNewPwText");

    var hp = $("#hero_hp1").val()+"-"+$("#hero_hp2").val()+"-"+$("#hero_hp3").val();
    var hpNumber = hp.split("-");

    var pwTF = document.getElementById("pwTF");
    if (newPw.value.length < 8) {
        newPwText.style.color="<?=$_MAIN_COLOR[0];?>";
        newPwText.innerHTML ="����, ����, Ư����ȣ�� �����Ͽ� 8�ڸ� �̻� �Է����ּ���";
        pwTF.value="false";
        obj.focus();
        return false;
    }else if(!chTextType.isEnNumOther(newPw.value)){
        newPwText.style.color="<?=$_MAIN_COLOR[0];?>";
        newPwText.innerHTML ="����, ����, Ư����ȣ�� �����Ͽ� �ּ���";
        pwTF.value="false";
        obj.focus();
        return false;
    }
    else if((typeof hpNumber[1] != 'undefined' && typeof hpNumber[2] != 'undefined') && (newPw.value.indexOf(hpNumber[1])>0 || newPw.value.indexOf(hpNumber[2])>0)){
        newPwText.style.color="<?=$_MAIN_COLOR[0];?>";
        newPwText.innerHTML ="�ڵ��� ��ȣ�� ��й�ȣ�� ������ �� �����ϴ�.";
        pwTF.value="false";
        obj.focus();
        return false;
    }else{
        newPwText.style.color="<?=$_MAIN_COLOR[1];?>";
        newPwText.innerHTML ="��� ������ ��й�ȣ�Դϴ�";
    }
    if(chNewPw.value!=''){
        if(chNewPw.value!=newPw.value){
            chNewPwText.style.color="<?=$_MAIN_COLOR[0];?>";
            chNewPwText.innerHTML ="��й�ȣ�� ���� �ʽ��ϴ�";
            pwTF.value="false";
            obj.focus();
            return false;
        }else{
            chNewPwText.style.color="<?=$_MAIN_COLOR[1];?>";
            chNewPwText.innerHTML ="��й�ȣ�� �����ϴ�.";
            pwTF.value="true";
        }
    }
}
</script>
