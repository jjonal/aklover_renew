<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;

if(!$_SESSION['temp_code']){
	error_location("�� ���� �����Դϴ�.","/main/index.php?board=idcheck");
	exit;
}

######################################################################################################################################################
$board = $_GET['board'];

######################################################################################################################################################
$error = "INFOEDIT_01";
$right_sql = "select * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$board."'";//desc
$right_res = new_sql($right_sql,$error,"on");
if((string)$right_res==$error){
	error_historyBack("");
	exit;
}

$right_list                             = mysql_fetch_assoc($right_res);

######################################################################################################################################################
$error = "INFOEDIT_02";
$member_sql = "select * from member where hero_code='".$_SESSION['temp_code']."' ;";
$member_res = new_sql($member_sql,$error);
if((string)$member_res==$error){
	error_historyBack("");
	exit;
}

$member_list                             = mysql_fetch_assoc($member_res);

$hero_mail = explode('@', $member_list['hero_mail']);

$ch_facebook = "notEndrolled";
$ch_kakao = "notEndrolled";
$ch_naver = "notEndrolled";
$ch_facebook_onclick = "loginFB('infoedit');";
$ch_kakako_onclick = "loginKakao('infoedit');";
$ch_naver_onclick = "loginNaver('infoedit');";

if($member_list['hero_facebook']){
	$ch_facebook = "";
	$ch_facebook_class = "_grey";
	$ch_facebook_onclick = "";
}
if($member_list['hero_kakaoTalk']){
	$ch_kakao = "";
	$ch_kakao_class = "_grey";
	$ch_kakako_onclick = "";
	
}
if($member_list['hero_naver']){
	$ch_naver = "";
	$ch_naver_class = "_grey";
	$ch_naver_onclick = "";
}

/* 
$question_sql = "select * from member_question where left(hero_period,8)<='".date('Ymd')."' and right(hero_period,8)>='".date('Ymd')."'";
//echo $question_sql;
$question_res = mysql_query($question_sql) or die("�ý��ۿ����Դϴ�. �ٽ� �õ��� �ּ���.");
$question_rs = mysql_fetch_assoc($question_res);
 */
 
//�߰��Է»��� ����Ʈ �޾Ҵ��� ����
$point_sql = "select * from point where hero_title like 'ȸ�������߰��Է�' and hero_code='".$member_list['hero_code']."' and hero_old_idx='2' ";
//echo $point_sql;
$point_sql = mysql_query($point_sql) or die();
$point_sql = mysql_fetch_assoc($point_sql); 
                       	
if($point_sql['hero_idx']=="")		$addpoint_check = 'N';//�� �޾Ҵ� 
else								$addpoint_check = 'Y';//�޾Ҵ� 
?>
    <div class="contents">
    	
    	<form name="form_next" action="<?=PATH_HOME?>?board=update" enctype="multipart/form-data" method="post" onsubmit="return go_submit(this);">
            <input type="hidden" name="hero_idx" value="<?=$member_list['hero_idx']?>">
            <input type="hidden" name="hero_today_plus" value="<?=Ymdhis?>">
            <input type="hidden" name="hero_login_ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
			
			<div id="infoEditSns">
							<div style="padding-top: 16px;">�α��� �����ϱ�</div>
							<img src="/image2/etc/line.png"/>
							<div class="info_sns <?=$ch_facebook?>" onclick="<?=$ch_facebook_onclick?>"><img src="/image2/etc/sns01<?=$ch_facebook_class?>.jpg" alt="���̽���" border="0" style="vertical-align:middle;">���̽���</div>
							<div class="info_sns <?=$ch_kakao?>" onclick="<?=$ch_kakako_onclick?>"><img src="/image2/etc/sns02<?=$ch_kakao_class?>.jpg" alt="īī����" border="0" style="vertical-align:middle;" >īī����</div>
							<div class="info_sns <?=$ch_naver?>" onclick="<?=$ch_naver_onclick?>;"><img src="/image2/etc/sns03<?=$ch_naver_class?>.jpg" alt="���̹�" border="0" style="vertical-align:middle;">���̹�</div>
						</div>
			
			<p class="member_alert"><span style="color:#f68428">*</span>�� �ʼ� �Է� �׸��Դϴ�!!!</p>
			
            <table class="member">
                <colgroup>
                    <col width="160px" />
                    <col width="*" />
                </colgroup>
                <tr class="first">
                    <th><span>*</span> ���̵�</th>
                    <td><span class="c_brown bold"><?=$member_list['hero_id']?></span></td>
                </tr>
                <tr>
                    <th><span>*</span> �̸�</th>
                    <td><span class="c_brown bold"><?=$member_list['hero_name']?></span></td>
                </tr>
                <tr>
                    <th><span>*</span> �г���</th>
                    <td><span class="c_brown bold"><?=$member_list['hero_nick']?></span> <span class="notification">* �г��� ����� �����ڿ��� 1:1���Ƿ� ��û�ϼ���</span></td>
                </tr>
                <tr>
                    <th><span>*</span> �������</th>
                    <td><span class="c_brown bold"><?=substr($member_list['hero_jumin'], '0', '4');?>�� <?=substr($member_list['hero_jumin'], '4', '2');?>�� <?=substr($member_list['hero_jumin'], '6', '2');?>��</span><!-- (�� <span class="c_brown bold">17</span>��)--></td>
                </tr>
                <tr>
                    <th><span>*</span> �̸���</th>
                    <td>
                        <input type="text" name="hero_mail_01" value="<?=$hero_mail['0'];?>" style="ime-mode:disabled;"/> @<br/>
                        <input type="text" name="hero_mail_02" value="<?=$hero_mail['1'];?>" style="ime-mode:disabled;"/>
                        <select id="email_select" onchange='javascript:emailChg();' class="short">
                            <option value="">�����Է�</option>
                            <option value="naver.com"<?if(!strcmp($hero_mail['1'], 'naver.com')){echo ' selected';}else{echo '';}?>>naver.com</option>
                            <option value="hanmail.net"<?if(!strcmp($hero_mail['1'], 'hanmail.net')){echo ' selected';}else{echo '';}?>>hanmail.net</option>
                            <option value="daum.net"<?if(!strcmp($hero_mail['1'], 'daum.net')){echo ' selected';}else{echo '';}?>>daum.net</option>
                            <option value="gmail.com"<?if(!strcmp($hero_mail['1'], 'gmail.com')){echo ' selected';}else{echo '';}?>>gmail.com</option>
                            <option value="hotmail.com"<?if(!strcmp($hero_mail['1'], 'hotmail.com')){echo ' selected';}else{echo '';}?>>hotmail.com</option>
                            <option value="paran.com"<?if(!strcmp($hero_mail['1'], 'paran.com')){echo ' selected';}else{echo '';}?>>paran.com</option>
                            <option value="nate.com"<?if(!strcmp($hero_mail['1'], 'nate.com')){echo ' selected';}else{echo '';}?>>nate.com</option>
                         </select>
                         <p style="height:25px;">�̸��� ����&nbsp;&nbsp;&nbsp;&nbsp;
                         	
							<input type="radio" name="hero_chk_email" value='1' <?php echo ($member_list['hero_chk_email']==1 || $member_list['hero_chk_email']==2)? "checked='checked'" : "";?> style='width:13px;' checked="checked">����
							<input type="radio" name="hero_chk_email" value='0' <?php echo ($member_list['hero_chk_email']==0)? "checked='checked'" : "";?> style='width:13px;'>���Ǿ���
						 </p>
                    </td>
                </tr>
    			
    			<?php
				$next = str_ireplace('-', '', $member_list['hero_hp']);
				$next = str_ireplace('~', '', $next);
				$next = str_ireplace('_', '', $next);
				$next = str_ireplace('/', '', $next);
				//substr($site_list['hero_hp'], '0', '3');
				?> 
				
				<tr>
                    <th><span>*</span> �ڵ���</th>
                    <td>
                        <input type="text" name="hero_hp_01" id="hero_hp_01" value="<?=substr($next, '0', '3');?>" onKeyUp="if(this.value.length >= 3)hero_hp_02.focus();" maxlength="3" style="ime-mode:disabled;" class="short"/>
                        <input type="text" name="hero_hp_02" id="hero_hp_02" value="<?=substr($next, '3', '4');?>" onKeyUp="if(this.value.length >= 4)hero_hp_03.focus();" maxlength="4" style="ime-mode:disabled;" class="short"/>
                        <input type="text" name="hero_hp_03" id="hero_hp_03" value="<?=substr($next, '7', '4');?>" maxlength="4" style="ime-mode:disabled;" class="short"/>
                        <p style="height:25px;">
							<span>SMS ����&nbsp;&nbsp;&nbsp;&nbsp;</span>
							<input type="radio" name="hero_chk_phone" value='1' <?php echo ($member_list['hero_chk_phone']==1)? "checked='checked'" : "";?> style='width:13px;' checked="checked">����
							<input type="radio" name="hero_chk_phone" value='0' <?php echo ($member_list['hero_chk_phone']==0)? "checked='checked'" : "";?> style='width:13px;'>���Ǿ���<br>
						</p>
                    </td>
                </tr>
                <tr>
                    <th><span>*</span> �ּ�</th>
                    <td>
                        <input type="text" name="hero_address_01" id="hero_address_01" value="<?=$member_list['hero_address_01']?>" class="short"/>
                        <a href="javascript:showzip()"><img src="../image/member/btn_zipcode.gif" alt="�����ȣã��" /></a><br />
                        <input type="text" name="hero_address_02" id="hero_address_02" value="<?=$member_list['hero_address_02']?>" class="w390" style="margin-top:1px;"/><br />
                        <input type="text" name="hero_address_03" id="hero_address_03" value="<?=$member_list['hero_address_03']?>" class="w390" style="margin-top:1px;" />
                    </td>
                </tr>
 <?php
if($addpoint_check == "N"){//�� ���� ��� 
   if(mktime(0,0,0,2,1,2016) <= time() && mktime(23,59,59,2,28,2016) >= time()) { //�̺�Ʈ �Ⱓ
 ?>          
 			<input type="hidden" name="addPoint_check" value="N">
			<input type="hidden" name="question_idx" value="2">
			<input type="hidden" name="question_validation" value="F">
              <tr>
                	<!--############################ �߰� �Է� �̺�Ʈ ���� ################################-->
                	<style>
			          .tname{color:#f68428;font-weight:bold;}
			        </style>
                	<td colspan="2" style="padding:0">
                		<table border="0" cellpadding="0" cellspacing="0" width="100%">
                			<tr>
			                    <th class='notneed' colspan="2" style="background-color:#F5F5F5;width:100%;text-align:center;font-weight: bold;font-size: 14px;">�߰��Է� �̺�Ʈ</th>
			                </tr>    
                			<tr>
			                    <th class='notneed' style="width:116px;background-color:#F5F5F5;">��α�/����SNS</th>
			                    <td style="width:*;">
			                    	<script>
			                    		function blog_check(obj){
			                    			if(obj.value == "�ִ�"){
			                    				if(obj.checked){
				                    				$(".blog").attr("disabled",false);
			                    				}else{
					                    			$(".blog").attr("disabled",true);              					
			                    				}
			                    			}else{//���� 
			                    				if(obj.checked){
				                    				$(".blog").attr("disabled",true);
			                    				}else{
					                    			$(".blog").attr("disabled",false);	                    					
			                    				}
			                    			}
			                    		}
			                    	</script>			                    	
			                    	<span style="font-weight:bold;background-color:#FFF5BB;font-size: 13px;">��α� � ����
			                    	<input type="radio" name="hero_qs_01" value="�ִ�" onclick="blog_check(this);"/>�ִ� 
			                    	<input type="radio" name="hero_qs_01" value="����" onclick="blog_check(this);"/>����</span>
			                    	<br>
			                        <span class="tname">��α� URL </span>
			                        <br>
			                        <input type="text" name="hero_blog_00" class='w390 blog' style="ime-mode:disabled;" disabled="disabled"/><br/>
			                        <p style="font-size:11px;color:#aaaaaa;">�� ��α׸� ����Ͻø� AKLOVER���� Ȱ�� �ÿ� �پ��� ������ ���� �� �ֽ��ϴ�.</p>
			                        <span class="tname">��α� �� �湮�� ��</span>
			                        <br>
			                        <input type="radio" name="hero_qs_02" value="200��" class="blog"/>200�� ����
			                        <input type="radio" name="hero_qs_02" value="200~800��" class="blog"/>200~800��
			                        <input type="radio" name="hero_qs_02" value="801~1,500��" class="blog"/>801~1,500��
			                        <br>
			                        <input type="radio" name="hero_qs_02" value="1,501~3,000��" class="blog"/>1,501~3,000��
			                        <input type="radio" name="hero_qs_02" value="3,001~4,000��" class="blog"/>3,001~4,000��
			                        <input type="radio" name="hero_qs_02" value="4,001~5,000��" class="blog"/>4,001~5,000��
			                        <input type="radio" name="hero_qs_02" value="5,001~10,000��" class="blog"/>5,001~10,000��
			                        <input type="radio" name="hero_qs_02" value="10,000�� �̻�" class="blog"/>10,000�� �̻�
			                        <br>
			                        <span class="tname">��α� Ÿ��(�� �ߺ� ���� ����)</span>
			                        <br>
			                        <input type="checkbox" name="hero_qs_03" value="�м�" class="blog"/>�м�
			                        <input type="checkbox" name="hero_qs_03" value="����" class="blog"/>����
			                        <input type="checkbox" name="hero_qs_03" value="����" class="blog"/>���� 
			                        <input type="checkbox" name="hero_qs_03" value="�ϻ�" class="blog"/>�ϻ� 
			                        <input type="checkbox" name="hero_qs_03" value="����" class="blog"/>����
			                        <input type="checkbox" name="hero_qs_03" value="�ֿ�" class="blog"/>�ֿ�
			                        </br>
			                        <input type="checkbox" name="hero_qs_03" value="����,����" class="blog"/>����,���� 
			                        <input type="checkbox" name="hero_qs_03" value="����,���" class="blog"/>����,���
			                        <input type="checkbox" name="hero_qs_03" value="����" class="blog"/>����
			                        <input type="checkbox" name="hero_qs_03" value="�ǰ�" class="blog"/>�ǰ�
			                        <input type="checkbox" name="hero_qs_03" value="IT" class="blog"/>IT
			                        <input type="checkbox" name="hero_qs_03" value="����" class="blog"/>����
			                        <input type="checkbox" name="hero_qs_03" value="���" class="blog"/>���
			                        <br>
			                        <span class="tname">���̽��� URL </span>
			                        <br>
			                        <input type="text" name="hero_blog_01" class='w390 blog' style="ime-mode:disabled;" disabled="disabled"/><br/>
			                        <span class="tname">�ν�Ÿ�׷� URL </span>
			                        <br>
			                        <input type="text" name="hero_blog_04" class='w390 blog' style="ime-mode:disabled;" disabled="disabled"/><br/>
			                        <span class="tname">īī�����丮 URL </span>
			                        <br>
			                        <input type="text" name="hero_blog_03" class='w390 blog' style="ime-mode:disabled;" disabled="disabled"/><br/>
			                        <span class="tname">Ʈ���� URL </span>
			                        <br>
			                        <input type="text" name="hero_blog_02" class='w390 blog' style="ime-mode:disabled;" disabled="disabled"/><br/>
			                    </td>
			                </tr> 

			                <tr>
			                    <th class='notneed' style="width:116px;background-color:#F5F5F5;">���� ������ ����</th>
			                    <td style="width:*;">
			                    	<span class="tname">��ȥ ����</span>
			                    	<br>
			                    	<input type="radio" name="hero_qs_04" value="��ȥ"/>��ȥ 
			                    	<input type="radio" name="hero_qs_04" value="��ȥ"/>��ȥ
			                    	<br>
			                    	<span class="tname">���� ������</span>
			                        <br>
			                        <input type="radio" name="hero_qs_09" value="2��"/>2��
			                        <input type="radio" name="hero_qs_09" value="3��"/>3�� 
			                        <input type="radio" name="hero_qs_09" value="4��"/>4��
			                        <input type="radio" name="hero_qs_09" value="5��"/>5��
			                        <input type="radio" name="hero_qs_09" value="6�� �̻�"/>6�� �̻�
			                        <br>
		                    		<script>
			                    		function child_check(obj){
			                    			if(obj.value == "�ִ�"){
			                    				if(obj.checked){
				                    				$(".child").attr("disabled",false);
			                    				}else{
					                    			$(".child").attr("disabled",true);              					
			                    				}
			                    			}else{//���� 
			                    				if(obj.checked){
				                    				$(".child").attr("disabled",true);
			                    				}else{
					                    			$(".child").attr("disabled",false);	                    					
			                    				}
			                    			}
			                    		}
			                    	</script>				                        
			                        <span style="font-weight:bold;background-color:#FFF5BB;font-size: 13px;">�ڳ� ����
			                    	<input type="radio" name="hero_qs_10" value="�ִ�" onclick="child_check(this);"/>�ִ� 
			                    	<input type="radio" name="hero_qs_10" value="����" onclick="child_check(this);"/>����</span>
									<br>
			                        <span class="tname">�ڳ��� ��� ����</span>
			                        <br>
			                        <input type="text" name="hero_qs_05" class='w390 child' style="ime-mode:disabled;" disabled="disabled"/>
			                        <br/>
			                        <span class="tname">�ڳ��� ����</span>
			                        <br>
			                        <input type="text" name="hero_qs_11" class='w390 child' style="ime-mode:disabled;" disabled="disabled"/>			                        
			                    </td>
			                </tr> 
			                <tr>
			                    <th class='notneed' style="width:116px;background-color:#F5F5F5;">�Һ� ���� ����</th>
			                    <td style="width:*;">
			                    	<span class="tname">��Ȱ��ǰ �� ��Ƽ��ǰ�� ������ �� �ַ� ����ϴ� ����ó</span>
			                    	<br>
			                    	<input type="radio" name="hero_qs_12" value="Ȩ����"/>Ȩ���� 
			                    	<input type="radio" name="hero_qs_12" value="������Ʈ"/>������Ʈ
			                    	<input type="radio" name="hero_qs_12" value="������Ʈ"/>������Ʈ
			                    	<input type="radio" name="hero_qs_12" value="������"/>������
			                    	<input type="radio" name="hero_qs_12" value="�巯�׽����"/>�巰�����
			                    	<br>
			                    	<span class="tname">�� ����ó���� �ַ� �����ϴ� ������?</span>
			                    	<br>
			                    	<input type="radio" name="hero_qs_13" value="������"/>������ 
			                    	<input type="radio" name="hero_qs_13" value="���ټ�"/>���ټ�
			                    	<input type="radio" name="hero_qs_13" value="����"/>����
			                    	<input type="radio" name="hero_qs_13" value="���θ��"/>���θ��	
			                    	<br>
			                    	<span class="tname">Ȩ���ο��� ��ǰ�� ������ ����</span>
			                    	<br>
			                    	<input type="radio" name="hero_qs_14" value="�ִ�"/>�ִ� 
			                    	<input type="radio" name="hero_qs_14" value="����"/>����  
			                    	<br>
			                    	<span class="tname">�巰�����(�ӽ���, �н�, �ø��꿵 ��)���� ��ǰ�� ������ ����</span>
			                    	<br>
			                    	<input type="radio" name="hero_qs_15" value="�ִ�"/>�ִ� 
			                    	<input type="radio" name="hero_qs_15" value="����"/>����
			                    	<br>
			                    	<span class="tname">�¶��� ���θ����� ��ǰ�� ������ ����</span>
			                    	<br>
			                    	<input type="radio" name="hero_qs_06" value="�ִ�"/>�ִ� 
			                    	<input type="radio" name="hero_qs_06" value="����"/>����                      	
			                    </td>
			               </tr>  
			                <tr>
			                    <th class='notneed' style="width:116px;background-color:#F5F5F5;">���ɻ�/�ְ� ����</th>
			                    <td style="width:*;">
		                    		<script>
			                    		function ak_check(obj){
			                    			if(obj.value == "�ߴ�"){
			                    				if(obj.checked){
				                    				$(".ak").attr("disabled",false);
			                    				}else{
					                    			$(".ak").attr("disabled",true);              					
			                    				}
			                    			}else{//�� �ߴ�
			                    				if(obj.checked){
				                    				$(".ak").attr("disabled",true);
			                    				}else{
					                    			$(".ak").attr("disabled",false);	                    					
			                    				}
			                    			}
			                    		}
			                    	</script>	
			                        <span style="font-weight:bold;background-color:#FFF5BB;font-size: 13px;">AK ��Ƽ���� ����
			                    	<input type="radio" name="hero_qs_16" value="�ߴ�" onclick="ak_check(this);"/>�ߴ� 
			                    	<input type="radio" name="hero_qs_16" value="�� �ߴ�" onclick="ak_check(this);"/>�� �ߴ�</span>
			                    	<br>
			                    	<span class="tname">���ԵǾ� �ִٸ� AK ��Ƽ�� ���̵� ����</span>
			                    	<br>
			                    	<input type="text" name="hero_qs_17" class='w390 ak' style="ime-mode:disabled;" disabled="disabled"/>                  	
			                    </td>
			               </tr>  			                   
                		</table>
                	</td>
				 	<!--############################ �߰� �Է� �̺�Ʈ �� ################################-->
                </tr>
<?php
	}//�̺�Ʈ �Ⱓ ���� ��� 
}//�� ���� ���   
?> 
            </table>
 
            
            <div class="btngroup tc" >
                <input type="image" src="../image/member/btn_infoedit.gif" alt="ȸ����������" />
            </div>
            
        </form>
       
        </div>
        
        <div class="layer_zip" style="top:700px;">   
            <dl>
            <form name="login_form" action="<?=PATH_HOME?>?board=result" onsubmit="return false;">
                <dt><img src="../image/member/zip1.gif" alt="�����ȣ ã��" /></dt>
                <dd>
                <input id="addr" type="text" class="addr" /><input type="image" src="../image/member/btn_findzip.gif" alt="�ּ�ã��" onclick="hero_ajax('zip.php', 'view_list', 'addr', 'zip'); return false;"/>
                </dd>
                <dd class="list">
                    <div id="view_list"></div>
                </dd>
                <dd class="tc"><a href="javascript:inputzip();"><img src="../image/member/btn_cancel.gif" alt="�Է�" /></a></dd>
            </form>
            </dl>
    	</div>
    	<form id="infoEditForm" >
        	<input type="hidden" name="snsId">
	       	<input type="hidden" name="snsType">
        </form>
    </div>
    
        <!-- sns -->
<script type="text/javascript" src="<?=JS_END;?>jquery.cookie.js" ></script>
<script type="text/javascript" charset="utf-8" src="https://static.nid.naver.com/js/naverLogin.js" ></script>
<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
<script type="text/javascript" src="<?=JS_END;?>snsInit.js"></script>
    
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

		function onlyNumber(event) {
		    var key = window.event ? event.keyCode : event.which;    
		
		    if ((event.shiftKey == false) && ((key  > 47 && key  < 58) || (key  > 95 && key  < 106)
		    || key  == 35 || key  == 36 || key  == 37 || key  == 39  // ����Ű �¿�,home,end  
		    || key  == 8  || key  == 46 ) // del, back space
		    ) {
		        return true;
		    }else {
		        return false;
		    }    
		};

        function go_submit(form) {
//##################################################################################################################################################//
            
            var mail_01 = form.hero_mail_01;
            var mail_02 = form.hero_mail_02;
            var hp_01 = form.hero_hp_01;
            var hp_02 = form.hero_hp_02;
            var hp_03 = form.hero_hp_03;
            var address_01 = form.hero_address_01;
            var address_02 = form.hero_address_02;
            var address_03 = form.hero_address_03;
            var blog_00 = form.hero_blog_00;

//##################################################################################################################################################//
            //pw_01.style.border = '1px solid #e4e4e4';
            //pw_02.style.border = '1px solid #e4e4e4';
            mail_01.style.border = '1px solid #e4e4e4';
            mail_02.style.border = '1px solid #e4e4e4';
            hp_01.style.border = '1px solid #e4e4e4';
            hp_02.style.border = '1px solid #e4e4e4';
            hp_03.style.border = '1px solid #e4e4e4';
            address_01.style.border = '1px solid #e4e4e4';
            address_02.style.border = '1px solid #e4e4e4';
            address_03.style.border = '1px solid #e4e4e4';
            
//##################################################################################################################################################//
            if(mail_01.value == ""){
                alert("�̸����� �Է��ϼ���.");mail_01.style.border = '1px solid red';mail_01.focus();
                return false;
            }
            if(mail_02.value == ""){
                alert("�̸����� �����ϼ���.");mail_02.style.border = '1px solid red';mail_02.focus();
                return false;
            }
//##################################################################################################################################################//
            if(hp_01.value == ""){
                alert("�ڵ�����ȣ�� �Է��ϼ���.");hp_01.style.border = '1px solid red';hp_01.focus();
                return false;
            }
            if(hp_02.value == ""){
                alert("�ڵ�����ȣ�� �Է��ϼ���.");hp_02.style.border = '1px solid red';hp_02.focus();
                return false;
            }
            if(hp_03.value == ""){
                alert("�ڵ�����ȣ�� �Է��ϼ���.");hp_03.style.border = '1px solid red';hp_03.focus();
                return false;
            }
//##################################################################################################################################################//
            if(address_01.value == ""){
                alert("�����ȣ�� �Է��ϼ���.");address_01.style.border = '1px solid red';address_01.focus();
                return false;
            }
            if(address_02.value == ""){
                alert("�ּҸ� �Է��ϼ���.");address_02.style.border = '1px solid red';address_02.focus();
                return false;
            }
            if(address_03.value == ""){
                alert("�������ּҸ� �Է��ϼ���.");address_03.style.border = '1px solid red';address_03.focus();
                return false;
            }
            
//##################################################################################################################################################//
//##################################################################################################################################################//

<?php
if($addpoint_check == "N"){//�� ���� ��� 
  if(mktime(0,0,0,2,1,2016) <= time() && mktime(23,59,59,2,28,2016) >= time()) { //�̺�Ʈ �Ⱓ
?>
         	//############################ �߰� �Է� �̺�Ʈ ���� ################################
        	var tmpMsg="\n\n�߰� �Է� ������ �� �Է��Ͻø� 20����Ʈ�� ������ �� �ֽ��ϴ�.\n�߰� �Է� ���� ���� �Ͻðڽ��ϱ�?";
         	if($('input[name=hero_qs_01]:checked').length == 0){
        		if(confirm("��α� � ���ΰ� ���õ��� �ʾҽ��ϴ�."+tmpMsg)){
        			form.question_validation.value="F";
        			form.submit();
        			return false;
        		}else{
        			$('input[name=hero_qs_01]').eq(0).focus();
        			return false;
        		}
        	}else{
         		if($('input[name=hero_qs_01]').eq(0).prop("checked")){
		        	if($('input[name=hero_blog_00]').val() == ""){
		        		if(confirm("��α� URL�� �Է� ���� �ʾҽ��ϴ�."+tmpMsg)){
		        			form.question_validation.value="F";
		        			form.submit();
		        			return false;
		        		}else{
		        			$('input[name=hero_blog_00]').focus();
		        			return false;
		        		}
		        	}
		        	if($('input[name=hero_qs_02]:checked').length == 0){
		        		if(confirm("��α� �� �湮�� ���� ���õ��� �ʾҽ��ϴ�."+tmpMsg)){
		        			form.question_validation.value="F";
		        			form.submit();
		        			return false;
		        		}else{
		        			$('input[name=hero_qs_02]').eq(0).focus();
		        			return false;
		        		}
		        	}   
		        	if($('input[name=hero_qs_03]:checked').length == 0){
		        		if(confirm("��α� Ÿ���� ���õ��� �ʾҽ��ϴ�."+tmpMsg)){
		        			form.question_validation.value="F";
		        			form.submit();
		        			return false;
		        		}else{
		        			$('input[name=hero_qs_03]').eq(0).focus();
		        			return false;
		        		}
		        	} 
		        }	
	        }	
        	if($('input[name=hero_qs_04]:checked').length == 0){
        		if(confirm("��ȥ ���ΰ� ���õ��� �ʾҽ��ϴ�."+tmpMsg)){
        			form.question_validation.value="F";
        			form.submit();
        			return false;
        		}else{
        			$('input[name=hero_qs_04]').eq(0).focus();
        			return false;
        		}
        	}                
        	if($('input[name=hero_qs_09]:checked').length == 0){
        		if(confirm("���� ������ ���� ���õ��� �ʾҽ��ϴ�."+tmpMsg)){
        			form.question_validation.value="F";
        			form.submit();
        			return false;
        		}else{
        			$('input[name=hero_qs_09]').eq(0).focus();
        			return false;
        		}
        	}   
        	
        	if($('input[name=hero_qs_10]:checked').length == 0){
        		if(confirm("�ڳ� ������ ���õ��� �ʾҽ��ϴ�."+tmpMsg)){
        			form.question_validation.value="F";
        			form.submit();
        			return false;
        		}else{
        			$('input[name=hero_qs_10]').eq(0).focus();
        			return false;
        		}
        	}else{
        		if($('input[name=hero_qs_10]').eq(0).prop("checked")){
		        	if($('input[name=hero_qs_05]').val() == ""){
		        		if(confirm("�ڳ��� ��������� �Է� ���� �ʾҽ��ϴ�."+tmpMsg)){
		        			form.question_validation.value="F";
		        			form.submit();
		        			return false;
		        		}else{
		        			$('input[name=hero_qs_05]').focus();
		        			return false;
		        		}
		        	}
		        	if($('input[name=hero_qs_11]').val() == ""){
		        		if(confirm("�ڳ��� ������ �Է� ���� �ʾҽ��ϴ�."+tmpMsg)){
		        			form.question_validation.value="F";
		        			form.submit();
		        			return false;
		        		}else{
		        			$('input[name=hero_qs_11]').focus();
		        			return false;
		        		}
		        	}
		        }	
	        } 

        	if($('input[name=hero_qs_12]:checked').length == 0){
        		if(confirm("�ֿ� ����ó�� ���õ��� �ʾҽ��ϴ�."+tmpMsg)){
        			form.question_validation.value="F";
        			form.submit();
        			return false;
        		}else{
        			$('input[name=hero_qs_12]').eq(0).focus();
        			return false;
        		}
        	} 
        	if($('input[name=hero_qs_13]:checked').length == 0){
        		if(confirm("�ֿ� ����ó ���� ������ ���õ��� �ʾҽ��ϴ�."+tmpMsg)){
        			form.question_validation.value="F";
        			form.submit();
        			return false;
        		}else{
        			$('input[name=hero_qs_13]').eq(0).focus();
        			return false;
        		}
        	} 
         	if($('input[name=hero_qs_14]:checked').length == 0){
        		if(confirm("ȫ���� ��ǰ ���� ���� ���ΰ� ���õ��� �ʾҽ��ϴ�."+tmpMsg)){
        			form.question_validation.value="F";
        			form.submit();
        			return false;
        		}else{
        			$('input[name=hero_qs_14]').eq(0).focus();
        			return false;
        		}
        	} 
         	if($('input[name=hero_qs_15]:checked').length == 0){
        		if(confirm("�巰����� ��ǰ ���� ���� ���ΰ� ���õ��� �ʾҽ��ϴ�."+tmpMsg)){
        			form.question_validation.value="F";
        			form.submit();
        			return false;
        		}else{
        			$('input[name=hero_qs_15]').eq(0).focus();
        			return false;
        		}
        	}     
         	if($('input[name=hero_qs_06]:checked').length == 0){
        		if(confirm("�¶��� ���θ� ��ǰ ���� ���� ���ΰ� ���õ��� �ʾҽ��ϴ�."+tmpMsg)){
        			form.question_validation.value="F";
        			form.submit();
        			return false;
        		}else{
        			$('input[name=hero_qs_06]').eq(0).focus();
        			return false;
        		}
        	}     	       	        		        
        	if($('input[name=hero_qs_16]:checked').length == 0){
        		if(confirm("AK ��Ƽ�� ���� ���ΰ� ���õ��� �ʾҽ��ϴ�."+tmpMsg)){
        			form.question_validation.value="F";
        			form.submit();
        			return false;
        		}else{
        			$('input[name=hero_qs_16]').eq(0).focus(); 
        			return false;
        		}
        	}else{
        		if($('input[name=hero_qs_16]').eq(0).prop("checked")){
		        	if($('input[name=hero_qs_17]').val() == ""){
		        		if(confirm("AK ��Ƽ�� ���̵� �Է� ���� �ʾҽ��ϴ�."+tmpMsg)){
		        			form.question_validation.value="F";
		        			form.submit();
		        			return false;
		        		}else{
		        			$('input[name=hero_qs_17]').focus();
		        			return false;
		        		}
		        	}
		        }	
	        }		      	      
	        //############################ �߰� �Է� �̺�Ʈ ���� ################################
	        form.question_validation.value="T";
<?php 
	}//�̺�Ʈ �Ⱓ ���� ��� 
}//�� ���� ���
?>

//##################################################################################################################################################//
            form.submit();
//##################################################################################################################################################//
            return true;
        }
        
    </script>
				
    