<?
####################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
####################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
####################################################################################################################################################
?>

	<div class="contents_area">
        <div class="page_title">
            <div>���̵� / ��й�ȣ ã��</div>
            <ul class="nav">
                <li><img src="../image/common/icon_nav_home.gif" alt="home" /></li>
                <li>&gt;</li>
                <li class="current">���̵� / ��й�ȣ ã��</li>
            </ul>
        </div>
        
        <div id="id_serch">
        	<p class="id_serch">
        		<span style="float:left; margin:0 7px 4px 6px; color:#f68427;font-size:18px; font-weight:bold">l</span>���̵� ã��
        	</p>
			<table class="logintable" width="726px"  summary="���̵� ã��"  >
				<tr>
					<td class="title1">�̸�</td>
					<td class="input_tit1"><input type="text" name="uid" id="uid" class="c2"></td>
				</tr>
				<tr>
					<td class="title1">���� ����</td>
					<td class="input_tit1">
						<input type="text" name="jumin" id="jumin" onKeyUp="if(this.value.length >= 8)email.focus();" maxlength="8" style="ime-mode:disabled;">
						��>19980203
					</td>
				</tr>
				<tr>
					<td class="title1_3">�̸���</td>
					<td class="input_tit2"><input type="text" name="email" id="email"></td>
				</tr>
			</table>
			<div class="Btn">
				<input type="image" src="/image2/main/01_fdIdBtn.jpg" alt="send" onclick="find_IdPw('zip3.php', '', 'uid', 'jumin', 'email', 'id'); return false;" class="id_icon">
			</div>

			<p class="id_serch">
				<span style="float:left; margin:0 7px 4px 6px; color:#f68427;font-size:18px; font-weight:bold">l</span>��й�ȣ ã��
			</p>
			<table class="logintable" width="726px"  summary="��й�ȣ ã��" >
				<tr>
					<td class="title1">���̵�</td>
					<td class="input_tit1"><input type="text" name="uid2" id="uid2"></td>
				</tr>
				<tr>
					<td class="title1">���� ����</td>
					<td class="input_tit1">
						<input type="text" name="jumin2" id="jumin2" onKeyUp="if(this.value.length >= 8)email2.focus();" maxlength="8" style="ime-mode:disabled;">
						��>19980203
					</td>
				</tr>
				<tr>
					<td class="title1_3">�̸���</td>
					<td class="input_tit2"><input type="text" name="email2" id="email2"></td>
				</tr>
			</table>
			<div class="Btn">
				<input type="image" src="/image2/main/01_fdPwBtn.jpg" alt="send" onclick="find_IdPw('zip3.php', '', 'uid2', 'jumin2', 'email2', 'pw');$('#view_list2').html('<p align=center>Ȯ�� ���� �� �Դϴ�. ��ø� ��ٷ� �ּ���...</p>');return false;" class="id_icon">
			</div>
			</br>
			<p class="notice">- ���̵𡤺�й�ȣ ã�� ���� ��, <span style="color:#ff6633; font-weight:bold">������</span>�� ���� ��Ź�帳�ϴ�.</p>
        </div>
        
    </div>
