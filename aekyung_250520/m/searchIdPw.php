<? 
	include_once "head.php";
	
	if($_SESSION["temp_code"]) {
		error_location("�α��� �����Դϴ�.\\n�ùٸ� ��η� �̿��� �ּ���.","/m/main.php");
	}
	
	$group_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_REQUEST['board'].'\';';//Ÿ��Ʋ
	$out_group = @mysql_query($group_sql);
	$right_list                             = @mysql_fetch_assoc($out_group);
	
?>
<link href="/m/css/musign/member.css" rel="stylesheet" type="text/css">
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
	<div class="id_tit f_c">
		<p class="fz36 bold on">���̵� ã��</p>
		<span></span>
		<p class="fz36 bold rel">��й�ȣ ã��</p>
	</div> 

	<div id="id_serch">  
		<div class="findbx findid on">
			<form name="formId" id="formId">
			<input type="hidden" name="type" value="id" />
			<div class="input_wrap">
				<p class="fz16 fw500">�̸�</p>
				<input type="text" name="hero_name" placeholder="�̸��� �Է��� �ּ���.">
			</div>	
			<div class="input_wrap">
				<p class="fz16 fw500">���� ����(��_19980203)</p>
				<input type="text" name="hero_jumin" onKeyUp="if(this.value.length >= 8)hero_mail.focus();" maxlength="8" numberOnly style="ime-mode:disabled;" placeholder="������ �Է��� �ּ���.">
			</div>	
			<div class="input_wrap">
				<p class="fz16 fw500">�̸���</p>
				<input type="text" name="hero_mail" placeholder="�̸����� �Է��� �ּ���.">
			</div>
			</form>
			<!--!!!!!!!! [���߿�û] ��������� alert������� ���̵� ����Ǵ°� �ƴ϶� �˾��������� �����ؾ��մϴ� [��]!!!!!!!!  -->
			<div class="Btn f_c">
				<a href="javascript:;" onClick="fnSearchId();" class="btn_submit btn_black">���̵� ã��</a>
			</div>
			<!--//////////// end ////////////  -->		
			<div class="term dis-no find_IdPw">
				<div class="inner rel">
					<h2 class="t_c fz24 bold">���̵� ã��</h2>
					<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="�ݱ�"></div>							
					<!--!!!!!!!! [���߿�û] Ȯ�ε� ���̵� [��]////////////  -->
					<div class="cont t_c find_id dis-no">
						<p class="fz15 fw500 gray08 t_c">������ ���̵� �˷��帳�ϴ�.</p>
						<p class="idinfo t_c fz28 fw600 memberId">
							[��ID]
						</p>
					</div>	
					<!--!!!!!!!! [���߿�û] or ȸ������ ����ġ�� [��]////////////  -->
					<div class="cont t_c no_find_id dis-no">
						<p class="idinfo t_c fz28 fw600">
							<img src="/img/front/icon/warning.webp" alt="���"><br>
							��ġ�ϴ� ȸ�� ������ �����ϴ�.<br>
							�Է��Ͻ� ������ Ȯ���Ͽ� �ּ���.
						</p>
					</div>
				</div>	
			</div>	
		</div>
		<div class="findbx findpw"> 	
			<form name="formPw" id="formPw">
			<input type="hidden" name="type" id="type" value="pw2" />
			<div class="input_wrap">
				<p class="fz16 fw500">���̵�</p>
				<input type="text" name="hero_id" id="hero_id" placeholder="���̵� �Է��� �ּ���.">
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
			</form>
			<!--!!!!!!!! [���߿�û] ��������� alert������� ���̵� ����Ǵ°� �ƴ϶� �˾��������� �����ؾ��մϴ� [��]!!!!!!!!  -->
			<div class="Btn f_c">
				<a href="javascript:;" onClick="fnSearchPw()" class="btn_submit btn_black">��й�ȣ ã��</a>
			</div>	
			<div class="term pw_popup dis-no">
				<div class="inner rel">
                    <form name="formchgPw" id="formchgPw">
                    <input type="hidden" name="type" value="chgpw" />
					<!--!!!!!!!! [���߿�û] ��й�ȣ ���� -- �ϴ� ��ȿ�� �˻� ���� �������������� �����Խ��ϴ� ���� ���� ��Ź�帳�ϴ� [��]////////////  -->
					<input type="hidden" id="pwTF" value="false">
                    <div class="find_pw dis-no">
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
                            <p class="idinfo t_c fz28 fw600">
                                <img src="/img/front/icon/warning.webp" alt="���"><br>
                                ��ġ�ϴ� ȸ�� ������ �����ϴ�.<br>
                                �Է��Ͻ� ������ Ȯ���Ͽ� �ּ���.
                            </p>
                        </div>
                    </div>
					<!--!!!!!!!! end ////////////  -->
                    </form>
				</div>	
			</div>	
		</div>	
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
});
fnSearchId = function() {
	var _form = $("#formId");

	if(!_form.find("input[name='hero_name']").val()) {
		alert("�̸��� �Է��� �ּ���.");
		_form.find("input[name='hero_name']").focus();
		return;
	}

	if(!_form.find("input[name='hero_jumin']").val()) {
		alert("��������� �Է��� �ּ���.");
		_form.find("input[name='hero_jumin']").focus();
		return;
	}

	if(!_form.find("input[name='hero_mail']").val()) {
		alert("�̸����� �Է��� �ּ���.");
		_form.find("input[name='hero_mail']").focus();
		return;
	}

	$.ajax({
        url:"searchIdPwAction.php"
        ,data:_form.serialize()
        ,type:"POST"
        ,dataType:"html"
        ,success:function(d) {
            $(".find_IdPw").removeClass("dis-no"); //�˾� ����
            let find_id = d;

            if(find_id != ''){ //���̵� ����
                $(".find_id").removeClass("dis-no"); //���̵� ��ġ ����
                $(".idinfo.t_c.fz28.fw600.memberId").text(find_id);
            }else { //���̵� ����
                $(".no_find_id").removeClass("dis-no"); //���̵� ����ġ ����
            }
        },error:function(e) {
            console.log(e);
            alert("�����߽��ϴ�.\n�ٽ� �̿��� �ּ���.");
        }
    })
}
sencAuthCode = function() {
    var _form = $("#formPw");
    $("#type").val('sendAuth');

    if(!_form.find("input[name='hero_id']").val()) {
        alert("���̵� �Է��� �ּ���.");
        _form.find("input[name='hero_id']").focus();
        return;
    }

    if(!_form.find("input[name='hero_name']").val()) {
        alert("�̸��� �Է��� �ּ���.");
        _form.find("input[name='hero_name']").focus();
        return;
    }

    if(!_form.find("input[name='hero_hp1']").val() || !_form.find("input[name='hero_hp2']").val() || !_form.find("input[name='hero_hp3']").val()) {
        alert("�޴�����ȣ�� �Է��� �ּ���.");
        _form.find("input[name='hero_hp1']").focus();
        return;
    }

    $.ajax({
        url:"searchIdPwAction.php"
        ,data:_form.serialize()
        ,type:"POST"
        ,dataType:"html"
        ,success:function(d) {
            if(d == $("#hero_id").val()){
                alert('�����ڵ尡 �߼۵Ǿ����ϴ�.');
            }else {
                alert(d);
            }
        },error:function(e) {
            console.log(e);
            alert("�����߽��ϴ�.\n�ٽ� �̿��� �ּ���.");
        }
    })
}

fnSearchPw = function() {
    var _form = $("#formPw");
    $("#type").val('pw2');

    if(!_form.find("input[name='hero_id']").val()) {
        alert("���̵� �Է��� �ּ���.");
        _form.find("input[name='hero_id']").focus();
        return;
    }

    if(!_form.find("input[name='hero_name']").val()) {
        alert("�̸��� �Է��� �ּ���.");
        _form.find("input[name='hero_name']").focus();
        return;
    }

    if(!_form.find("input[name='hero_hp1']").val() || !_form.find("input[name='hero_hp2']").val() || !_form.find("input[name='hero_hp3']").val()) {
        alert("�޴�����ȣ�� �Է��� �ּ���.");
        _form.find("input[name='hero_hp1']").focus();
        return;
    }

    if(!_form.find("input[name='authCode']").val() || !_form.find("input[name='hero_hp2']").val() || !_form.find("input[name='hero_hp3']").val()) {
        alert("�����ڵ带 �Է��� �ּ���.");
        _form.find("input[name='authCode']").focus();
        return;
    }

    $.ajax({
        url:"searchIdPwAction.php"
        ,data:_form.serialize()
        ,type:"POST"
        ,dataType:"html"
        ,success:function(d) {
            $(".pw_popup").removeClass("dis-no");
            if(d == $("#hero_id").val()){
                $(".find_pw").removeClass("dis-no");
            }else {
                $(".no_find_pw").removeClass("dis-no");
            }
        },error:function(e) {
            console.log(e);
            alert("�����߽��ϴ�.\n�ٽ� �̿��� �ּ���.");
        }
    })
}

changePassword = function() {
    var _form = $("#formchgPw");

    var param = "type=chgpw&hero_id="+$("#hero_id").val()+"&newPw="+$("#newPw").val()+"&chNewPw="+$("#chNewPw").val();
    if(pwTF.value == 'false') {
        return;
    }

    $.ajax({
        url:"searchIdPwAction.php"
        ,data:param
        ,type:"POST"
        ,dataType:"html"
        ,success:function(d) {
            if(d == $("#hero_id").val()){
                alert('��й�ȣ�� ����Ǿ����ϴ�.');
                location.reload(); // /m/login.php ����� ���ߵ��� ������?
            }else {
                alert(d);
            }
        },error:function(e) {
            console.log(e);
            alert("�����߽��ϴ�.\n�ٽ� �̿��� �ּ���.");
        }
    })
}

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
<?include_once "tail.php";?>