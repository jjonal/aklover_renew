<?
// :)��
$table = 'mail';
if(!strcmp($_GET['type'], 'write')){
    if(!strcmp($_POST['hero_user'], '')) {
		msg('������ �����ϼ���.','location.href="'.PATH_HOME.'?'.get('type','').'"');
		exit;
	}else {
		$_POST['hero_user'] = str_replace(",","||",$_POST['hero_user']);
	}
	
    $data_i = '1';
    $count = @count($_POST)-1; //hero_user ���� ���� �Է� �� �߰�
    while(list($post_key, $post_val) = each($_POST)) {
    	if($post_key != "hero_user") {
	        if(!strcmp($count, $data_i)) {
	            $comma = '';
	        } else {
	            $comma = ', ';
	        }
	        
	        if(!strcmp($post_key,"hero_command")) {
	            $command = nl2br(htmlspecialchars($_POST[$post_key]));
	            $command = str_ireplace("<br />", "", $command);//���� ����
	            
	            $sql_one_write .= $post_key.$comma;
	            $sql_two_write .= '\''.$command.'\''.$comma;
	        } else {
	            $sql_one_write .= $post_key.$comma;
	            $sql_two_write .= '\''.$_POST[$post_key].'\''.$comma;
	        }
	        
	        $data_i++;
    	}
    }
    
    if($_POST["hero_user"] == "all") {
    	$sql = 'INSERT INTO '.$table.' ('.$sql_one_write.', hero_user) VALUES ('.$sql_two_write.',\''.$_POST["hero_user"].'\') ';
    	$result = mysql_query($sql);
    }
    
    if($_POST["alrimtalk_type"] && $_POST["hero_user"] != "allUser" && $_POST["hero_user"] != "all") {
    	$arr_hero_id = explode("||",$_POST["hero_user"]); 
    	for($i=0; $i < count($arr_hero_id); $i++) {
    		
    		$sql = 'INSERT INTO '.$table.' ('.$sql_one_write.', hero_user) VALUES ('.$sql_two_write.',\''.$arr_hero_id[$i].'\') ';
    		$result = mysql_query($sql);
    		
    		if($_POST["alrimtalk_type"] != "4") {
    			
    			if($result) {
    				$hero_idx_mail = mysql_insert_id();
    			}
    			
	    		$sql_member = " SELECT hero_hp FROM member WHERE hero_id = '".$arr_hero_id[$i]."' AND hero_use = 0 ";
	    		
	    		$member = mysql_query($sql_member);
	    		$member_data = @mysql_fetch_array($member);
	    		
				$admin_nickname = $_SESSION["temp_nick"];
	    		
				if($member_data["hero_hp"]) {
					if($_POST["alrimtalk_type"] == "1") {
						$type = "10007";
						
//						$msg = "AK LOVER ������ ".$admin_nickname."�κ��� ���� ����!
//�����Ͻ� ü��� ���̵���� ���ؼ��� ������û�帳�ϴ�.
//
//�Ⱓ �� �̼��� �� ���Ƽ�� �ΰ��Ǵ�, ���� �ٷ� AK LOVER Ȩ������ �� �������� Ȯ�����ּ���!";
						
					} else if($_POST["alrimtalk_type"] == "2") {
						$type = "10005";
						
//		$msg = "AK LOVER ������ ".$admin_nickname."�κ��� ���� ����!
//��û�Ͻ� ü��� �ı� �̵�� �ȳ��帳�ϴ�.
//
//���� ���Ƽ�� ����Ʈ�� �����Ǿ����� �ڼ��� ������ ���� �ٷ� AK LOVER Ȩ������ �� �������� Ȯ�����ּ���!";
					} else if($_POST["alrimtalk_type"] == "3") {
		$type = "10006";
						
//		$msg = "AK LOVER ������ ".$admin_nickname."�κ��� ���� ����!
//�����Ͻ� ü��ܿ� ���� ��������Ʈ�� ���޵Ǿ����ϴ�.
//
//���������� �ı� �׻� ����帮�� �ڼ��� ������, ���� �ٷ� AK LOVER Ȩ������ �� �������� Ȯ�����ּ���! ";
					} else if($_POST["alrimtalk_type"] == "5") {
		$type = "10010";
					
//		$msg = "AK LOVER ������ ".$admin_nickname."�κ��� ������ �����߽��ϴ�.
//���� �ٷ� �������� Ȯ�����ּ���!
//
//������ Ȯ������ �ʾ� �߻��ϴ� �����Ϳ� ���ؼ��� å������ �ʽ��ϴ�.";
					} else if($_POST["alrimtalk_type"] == "6") {
		$type = "10011";
							
//		$msg = "AK LOVER ������ ".$admin_nickname."�κ��� ������ �����߽��ϴ�.
//��ü��� ��÷�� ���ϵ帳�ϴ�!
//
//���� �ٷ� ������������������  ��÷ ��  ü����� Ȯ�����ּ���:)";
					} else if($_POST["alrimtalk_type"] == "7") {
		$type = "10012";
							
//		$msg = "AK LOVER ������ ".$admin_nickname."�κ��� ������ �����߽��ϴ�.
//�������翡 �������ּ���.
//
//���� ���� �Ϸ��ڿ��Դ� ������ AK LOVER ����Ʈ�� ���޵˴ϴ�!
//���� �ٷ� �������� Ȯ���� �ּ���!";
					}
                    if($command != '') $msg = $command;

		    		adminSendAlrimTalk($msg,$member_data["hero_hp"],$type,$hero_idx_mail,$arr_hero_id[$i]);
				}
	    		
	    	}
    	}
    	
    }
    msg('�߼� �Ǿ����ϴ�.','location.href="'.PATH_HOME.'?'.get('type||hero_user||page||','').'"');
    exit;
}
?>
<style>
#draggable {top:100px; left:495px; width:851px; height:680px;}/*205 || 495 || 851 || 380 */
span { font-size:12px; }
#list:hover{background: #B9DEFF;cursor:pointer;}
</style>
<form name="form_next" id="form_next" action="<?=PATH_HOME.'?'.get('','type=write');?>" method="post" enctype="multipart/form-data"> 
<input type="hidden" name="hero_code" value="<?=$_SESSION['temp_code']?>">
<input type="hidden" name="hero_table" value="mail">
<input type="hidden" name="hero_today" value="<?=Ymdhis?>">
<input type="hidden" name="hero_name" value="<?=$_SESSION['temp_name']?>">
<table class="t_view">
<colgroup>
	<col width="150px">
	<col width=*>
</colgroup>
<tbody>
<tr>
	<th>������ ���</th>
	<td><input type="hidden" name="hero_nick" value="<?=$_SESSION['temp_nick']?>"><?=$_SESSION['temp_nick'];?></td>
</tr>
<tr>
	<th>�޴� ���</th>
    <td>
		<div class="receiveBox">
			<!-- ���� �� �޼��� ������� ����  20200109 �ּ����� ���� 
			<a href="#" style="width:230px" onclick="javascript:document.getElementById('hero_user').value='allUser'" class="btn_blue2">�����ϸ� ���� ����(����ȸ�� ������)</a>
			 -->
			<a href="javascript:;" onclick="javascript:document.getElementById('hero_user').value='all'" class="btnForm">��ü(����ȸ����)</a>
			<a href="javascript:;" onclick="javascript:showzip();" class="btnForm">����</a>
		</div>
        <textarea id="hero_user" name="hero_user" class="textarea" style="word-break:break-all"><?=$_REQUEST["search_uesr"]?></textarea>
	</td>
</tr>
<tr>
	<th>�˸��� ����</th>
	<td>
		<p class="txt_emphasis">�� �޴»���� �������� ���� �� �˸����� �߼۵˴ϴ�.</br>�� ���뺸�� ��ư�� ���콺 ���� �� �˸��� �޼����� Ȯ���� �� �ֽ��ϴ�.</p>
		<div style="margin:10px;">
        	<span style="display:inline; color:#333; margin:0 20px 0 0">�˸��� ����</span>


			<input type="radio" name="alrimtalk_type" id="alrimtalk_type_1" value="1"><label for="alrimtalk_type_1">���̵���� ���ؼ�</label>
            <a href="javascript:;" id="alrimtalk_content_1" class="btn_message_title btnForm"
title="AK LOVER ������ ��Ʒκ��� ���� ����!
�����Ͻ� ü��� ���̵���� ���ؼ��� ������û�帳�ϴ�.

�Ⱓ �� �̼��� �� ���Ƽ�� �ΰ��Ǵ�,
���� �ٷ� AK LOVER Ȩ������ �� �������� Ȯ�����ּ���!">���뺸��</a>


            <input type="radio" name="alrimtalk_type" id="alrimtalk_type_2" value="2"><label for="alrimtalk_type_2">�ı� �̵��</label>
            <a href="javascript:;" id="alrimtalk_content_2" class="btn_message_title btnForm"
title="AK LOVER ������ ��Ʒκ��� ���� ����!
��û�Ͻ� ü��� �ı� �̵�� �ȳ��帳�ϴ�.

���� ���Ƽ�� ����Ʈ�� �����Ǿ����� �ڼ��� ������
���� �ٷ� AK LOVER Ȩ������ �� �������� Ȯ�����ּ���!">���뺸��</a>


            <input type="radio" name="alrimtalk_type" id="alrimtalk_type_3" value="3"><label for="alrimtalk_type_3">���� ����Ʈ ����</label>
            <a href="javascript:;" id="alrimtalk_content_3" class="btn_message_title btnForm"
title="AK LOVER ������ ��Ʒκ��� ���� ����!
�����Ͻ� ü��ܿ� ���� ��������Ʈ�� ���޵Ǿ����ϴ�.

���������� �ı� �׻� ����帮�� �ڼ��� ������,
���� �ٷ� AK LOVER Ȩ������ �� �������� Ȯ�����ּ���!">���뺸��</a>


            <input type="radio" name="alrimtalk_type" id="alrimtalk_type_5" value="5"><label for="alrimtalk_type_5">���� Ȯ��</label>
            <a href="javascript:;" id="alrimtalk_content_5" class="btn_message_title btnForm"
title="AK LOVER ������ ��Ʒκ��� ������ �����߽��ϴ�.
���� �ٷ� �������� Ȯ�����ּ���!

������ Ȯ������ �ʾ� �߻��ϴ� �����Ϳ� ���ؼ��� 
å������ �ʽ��ϴ�.">���뺸��</a>

            <input type="radio" name="alrimtalk_type" id="alrimtalk_type_6" value="6"><label for="alrimtalk_type_6">ü��� ��÷</label>
            <a href="javascript:;" id="alrimtalk_content_6" class="btn_message_title btnForm"
title="AK LOVER ������ ��Ʒκ��� ������ �����߽��ϴ�.
��ü��� ��÷�� ���ϵ帳�ϴ�!

���� �ٷ� ������������������  ��÷ ��  ü����� Ȯ�����ּ���:)">���뺸��</a>

            <input type="radio" name="alrimtalk_type" id="alrimtalk_type_7" value="7"><label for="alrimtalk_type_7">��������</label>
            <a href="javascript:;" id="alrimtalk_content_7" class="btn_message_title btnForm"
title="AK LOVER ������ ��Ʒκ��� ������ �����߽��ϴ�.
�������翡 �������ּ���.

���� ���� �Ϸ��ڿ��Դ� ������ AK LOVER ����Ʈ�� ���޵˴ϴ�!
���� �ٷ� �������� Ȯ���� �ּ���!">���뺸��</a>
											
                                		</div>
                                		<div style="margin:10px;">
                                			<span style="display:inline; color:#333; margin:0 9px 0 0">�˸��� ������</span>
                                			<input type="radio" name="alrimtalk_type" id="alrimtalk_type_4" value="4" class="btnForm"><label for="alrimtalk_type_4">�˸��� ������</label>
                                		</div>
                                		
                                	</td>
                                </tr>
<tr>
	<th>����</th>
	<td>
		<input type="text" id="hero_title" name="hero_title" value="<?=$main_list['hero_title'];?>">
	</td>
</tr>
<tr>
	<th>����(�˸���)</th>
	<td>
		<p class="txt_emphasis">�� �� �����Ϳ� �ۼ��� ���븸 �˸������� �߼۵˴ϴ�.</br>�� �Ʒ� �����Ϳ� �ۼ��� ������ ���� ��� �� �����Ϳ� �ۼ��� ������ �����Կ� ǥ�õ˴ϴ�.</p>
		<br/>
		<textarea name="hero_command" id="editor" class="textarea" style="height:200px; padding:10px;"><?=$out_row['hero_command'];?></textarea>
	</td>
</tr>
<tr>
	<th>����(������)</th>
	<td>
		<p class="txt_emphasis">�� �� �����Ϳ� �ۼ��� ������ �����Կ� ǥ�õ˴ϴ�.</br>�� �� �����Ϳ� �ۼ��� ������ ���� ��� �� �����Ϳ� �ۼ��� ������ �����Կ� ǥ�õ˴ϴ�.</p>
		<br/>
		<textarea id="editor2" name="hero_command2" style="height:300px;"><?=$out_row['hero_command2'];?></textarea>
	</td>
</tr>

</tbody>
</table>
<div class="align_c margin_t20">
	<a href="javascript:;" onClick="goSend()" class="btnAdd">����</a>
</div>
<br/><br/>
</form>
<!-- (s)���� ���̾� -->
<div id="draggable" class="layerWrap mailMemberListLayer ui-widget-content">
	<div class="header">
		<h4>����</h4>
		<a href="javascript:;" class="btn_close" id="close_popup" onclick="javascript:inputzip();">�ݱ�</a>
	</div>
	<div class="layerMailContWrap" id="layer">
<?
$search_next .= "board=mail&idx=23";

if($_REQUEST["hero_point_start"]) {
	$search .= " AND hero_point >= '".$_REQUEST["hero_point_start"]."' ";
	$search_next .= '&hero_point_start='.$_REQUEST['hero_point_start'];
}

if($_REQUEST["hero_point_end"]) {
	$search .= " AND hero_point <= '".$_REQUEST["hero_point_end"]."' ";
	$search_next .= '&hero_point_end='.$_REQUEST['hero_point_end'];
}

if($_REQUEST["hero_blog"]) {
	if($_GET["hero_blog"] == "1") {
		$search .= " AND  hero_blog_00 is not null  AND  hero_blog_00 != '' ";
	} else if($_REQUEST["hero_blog"] == "2") {
		$search .= " AND  hero_blog_04 is not null  AND  hero_blog_04 != '' ";
	} else if($_REQUEST["hero_blog"] == "3") {
		$search .= " AND  ((hero_blog_00 is not null  AND  hero_blog_00 != '') or (hero_blog_04 is not null  AND  hero_blog_04 != ''))  ";
	} else if($_REQUEST["hero_blog"] == "4") {
		$search .= " AND  hero_blog_00 is not null  AND  hero_blog_00 != '' AND hero_blog_04 is not null  AND  hero_blog_04 != '' ";
	} else if($_REQUEST["hero_blog"] == "5") {
		$search .= " AND  hero_blog_03 is not null  AND  hero_blog_03 != '' ";
	}
	$search_next .= '&hero_blog='.$_REQUEST['hero_blog'];
}

if($_REQUEST["hero_memo_01_image"]) {
	$search .= " AND hero_memo_01_image = '".$_REQUEST["hero_memo_01_image"]."' ";
	$search_next .= '&hero_memo_01_image='.$_REQUEST['hero_memo_01_image'];
}

if($_REQUEST["hero_memo_01"]) {
	$search .= " AND hero_memo_01 = '".$_REQUEST["hero_memo_01"]."' ";
	$search_next .= '&hero_memo_01='.$_REQUEST['hero_memo_01'];
}

if($_REQUEST["hero_insta_image_grade"]) {
	$search .= " AND hero_insta_image_grade = '".$_REQUEST["hero_insta_image_grade"]."' ";
	$search_next .= '&hero_insta_image_grade='.$_REQUEST['hero_insta_image_grade'];
}

if($_REQUEST["hero_insta_grade"]) {
	$search .= " AND hero_insta_grade = '".$_REQUEST["hero_insta_grade"]."' ";
	$search_next .= '&hero_insta_grade='.$_REQUEST['hero_insta_grade'];
}

if($_REQUEST["hero_youtube_grade"]) {
	$search .= " AND hero_youtube_grade = '".$_REQUEST["hero_youtube_grade"]."' ";
	$search_next .= '&hero_youtube_grade='.$_REQUEST['hero_youtube_grade'];
}

if($_REQUEST["hero_level_start"]) {
	$search .= " AND hero_level >= '".$_REQUEST["hero_level_start"]."' ";
	$search_next .= '&hero_level_start='.$_REQUEST['hero_level_start'];
}

if($_REQUEST["hero_level_end"]) {
	$search .= " AND hero_level <= '".$_REQUEST["hero_level_end"]."' ";
	$search_next .= '&hero_level_end='.$_REQUEST['hero_level_end'];
}

if($_REQUEST["hero_oldday_start"]) {
	$search .= " AND date_format(hero_oldday,'%Y-%m-%d') >= '".$_REQUEST["hero_oldday_start"]."' ";
	$search_next .= '&hero_oldday_start='.$_REQUEST['hero_oldday_start'];
}

if($_REQUEST["hero_oldday_end"]) {
	$search .= " AND date_format(hero_oldday,'%Y-%m-%d') <= '".$_REQUEST["hero_oldday_end"]."' ";
	$search_next .= '&hero_oldday_end='.$_REQUEST['hero_oldday_end'];
}

if(strlen($_REQUEST["hero_sex"]) > 0) {
	$search .= " AND hero_sex = '".$_REQUEST["hero_sex"]."' ";
	$search_next .= '&hero_sex='.$_REQUEST['hero_sex'];
}

if($_REQUEST["hero_age_start"]) {
	$birthYear = date("Y")-$_REQUEST["hero_age_start"]+1;
	$search .= " AND substr(hero_jumin,1,4) <= '".$birthYear."' ";
	$search_next .= '&hero_age_start='.$_REQUEST['hero_age_start'];
}

if($_REQUEST["hero_age_end"]) {
	$birthYear = date("Y")-$_REQUEST["hero_age_end"]+1;
	$search .= " AND substr(hero_jumin,1,4) >= '".$birthYear."' ";
	$search_next .= '&hero_age_end='.$_REQUEST['hero_age_end'];
}

if($_REQUEST["hero_chk_phone"]) {
	if($_REQUEST["hero_chk_phone"] == "1") {
		$search .= " AND hero_chk_phone = '1' ";
	} else {
		$search .= " AND hero_chk_phone != '1' ";
	}
	$search_next .= '&hero_chk_phone='.$_REQUEST['hero_chk_phone'];
}

if($_REQUEST["hero_chk_email"]) {
	if($_REQUEST["hero_chk_email"] == "1") {
		$search .= " AND hero_chk_email = '1' ";
	} else {
		$search .= " AND hero_chk_email != '1' ";
	}
	
	$search_next .= '&hero_chk_email='.$_REQUEST['hero_chk_email'];
}

if($_REQUEST["kewyword"]) {
	$search .= " AND ".$_REQUEST["select"]." like '%".$_REQUEST["kewyword"]."%' ";
	$search_next .= '&select='.$_REQUEST['select'].'&kewyword='.$_REQUEST["kewyword"];
}

$sql =  " SELECT hero_id FROM ( ";
$sql .=  " SELECT hero_nick, hero_id, hero_name, hero_hp, hero_oldday ";
$sql .=  " , (date_format(now(),'%Y') - left(hero_jumin,4) + 1) hero_age ";
$sql .=  " , hero_sex, hero_blog_00, hero_blog_04, hero_blog_03, hero_chk_phone, hero_chk_email ";
$sql .=  " FROM member WHERE hero_level <= '".$_SESSION['temp_level']."' ".$search." ) m WHERE 1=1 ";

sql($sql);
$total_data = @mysql_num_rows($out_sql);

if($_REQUEST["list_page"]) {
	$list_page = $_REQUEST["list_page"];
} else {
	$list_page=20;
}

$page_per_list=10;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path=get("page");

$sql  =  " SELECT * FROM ( ";
$sql .=  " SELECT hero_nick, hero_id, hero_name, hero_hp, hero_oldday ";
$sql .=  " , (date_format(now(),'%Y') - left(hero_jumin,4) + 1) hero_age ";
$sql .=  " , hero_sex, hero_blog_00, hero_blog_03, hero_blog_04, hero_chk_phone, hero_chk_email ";
$sql .=  " , hero_point, hero_level, hero_jumin, hero_memo_01_image , hero_memo_01";
$sql .=  " , hero_insta_image_grade, hero_insta_grade, hero_youtube_grade";
$sql .=  " FROM member WHERE hero_level <= '".$_SESSION['temp_level']."') m WHERE 1=1 ".$search.$view_order." limit ".$start.",".$list_page;

sql($sql, 'end');
$count = @mysql_num_rows($out_sql);
?>
	<!--(s) �˻�����-->
	<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>" method="POST" >
	<input type="hidden" name="search_uesr" value="<?=$_REQUEST["search_uesr"]?>" /> 
	<input type="hidden" name="hero_table" value="mail">
	<input type="hidden" name="idx" value="<?=$_REQUEST["idx"]?>">
	<table class="tbSearch">
	<colgroup>
		<col width="120px" />
		<col width="*" />
		<col width="120px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>��ü����Ʈ</th>
		<td><input type="text" name="hero_point_start" numberOnly value="<?=$_REQUEST["hero_point_start"]?>" style="width:80px"/> ~ <input type="text" name="hero_point_end" numberOnly value="<?=$_REQUEST["hero_point_end"]?>" style="width:80px"/></td>
		<th>SNS ����</th>
		<td>
			<input type="radio" name="hero_blog" id="hero_blog_naver" value="" <?=!$_REQUEST["hero_blog"] ? "checked":"";?>/><label for="hero_blog">��ü</label>
			<input type="radio" name="hero_blog" id="hero_blog_naver" value="1" <?=$_REQUEST["hero_blog"] == "1" ? "checked":"";?>/><label for="hero_blog_naver">���̹� ��α�</label>
			<input type="radio" name="hero_blog" id="hero_blog_insta" value="2" <?=$_REQUEST["hero_blog"] == "2" ? "checked":"";?>/><label for="hero_blog_insta">�ν�Ÿ�׷�</label>
			<input type="radio" name="hero_blog" id="hero_blog_youtube" value="5" <?=$_REQUEST["hero_blog"] == "5" ? "checked":"";?>/><label for="hero_blog_youtube">��Ʃ��</label><br/>
			<input type="radio" name="hero_blog" id="hero_blog_naver_or_insta" value="3" <?=$_REQUEST["hero_blog"] == "3" ? "checked":"";?>/><label for="hero_blog_naver_or_insta">���̹� ��α� or �ν�Ÿ�׷�</label><br/>
			<input type="radio" name="hero_blog" id="hero_blog_naver_and_insta" value="4" <?=$_REQUEST["hero_blog"] == "4" ? "checked":"";?>/><label for="hero_blog_naver_and_insta">���̹� ��α� and �ν�Ÿ�׷�</label><br/>
			
		</td>
	</tr>
	<tr>
		<th>���̹� ��α�<br/>�̹��� ����Ƽ</th>
		<td>
			<select name="hero_memo_01_image">
				<option value="">����</option>
				<option value="��" <?=$_REQUEST["hero_memo_01_image"] == "��" ? "selected":"";?>>��</option>
				<option value="�߻�" <?=$_REQUEST["hero_memo_01_image"] == "�߻�" ? "selected":"";?>>�߻�</option>
				<option value="��" <?=$_REQUEST["hero_memo_01_image"] == "��" ? "selected":"";?>>��</option>
				<option value="����" <?=$_REQUEST["hero_memo_01_image"] == "����" ? "selected":"";?>>����</option>
				<option value="��" <?=$_REQUEST["hero_memo_01_image"] == "��" ? "selected":"";?>>��</option>
			</select>
		</td>
		<th>���̹� ��α�<br/>�ؽ�Ʈ ����Ƽ</th>
		<td>
			<select name="hero_memo_01">
				<option value="">����</option>
				<option value="��" <?=$_REQUEST["hero_memo_01"] == "��" ? "selected":"";?>>��</option>
				<option value="�߻�" <?=$_REQUEST["hero_memo_01"] == "�߻�" ? "selected":"";?>>�߻�</option>
				<option value="��" <?=$_REQUEST["hero_memo_01"] == "��" ? "selected":"";?>>��</option>
				<option value="����" <?=$_REQUEST["hero_memo_01"] == "����" ? "selected":"";?>>����</option>
				<option value="��" <?=$_REQUEST["hero_memo_01"] == "��" ? "selected":"";?>>��</option>
			</select>
		</td>
	</tr>
	<tr>
		<th>�ν�Ÿ�׷�<br/>�̹��� ����Ƽ</th>
		<td>
			<select name="hero_insta_image_grade">
				<option value="">����</option>
				<option value="��" <?=$_REQUEST["hero_insta_image_grade"] == "��" ? "selected":"";?>>��</option>
				<option value="�߻�" <?=$_REQUEST["hero_insta_image_grade"] == "�߻�" ? "selected":"";?>>�߻�</option>
				<option value="��" <?=$_REQUEST["hero_insta_image_grade"] == "��" ? "selected":"";?>>��</option>
				<option value="����" <?=$_REQUEST["hero_insta_image_grade"] == "����" ? "selected":"";?>>����</option>
				<option value="��" <?=$_REQUEST["hero_insta_image_grade"] == "��" ? "selected":"";?>>��</option>
			</select>
		</td>
		<th>�ν�Ÿ�׷�<br/>�ؽ�Ʈ ����Ƽ</th>
		<td>
			<select name="hero_insta_grade">
				<option value="">����</option>
				<option value="��" <?=$_REQUEST["hero_insta_grade"] == "��" ? "selected":"";?>>��</option>
				<option value="�߻�" <?=$_REQUEST["hero_insta_grade"] == "�߻�" ? "selected":"";?>>�߻�</option>
				<option value="��" <?=$_REQUEST["hero_insta_grade"] == "��" ? "selected":"";?>>��</option>
				<option value="����" <?=$_REQUEST["hero_insta_grade"] == "����" ? "selected":"";?>>����</option>
				<option value="��" <?=$_REQUEST["hero_insta_grade"] == "��" ? "selected":"";?>>��</option>
			</select>
		</td>
	</tr>
	<tr>
		<th>��Ʃ��<br/>������ ���</th>
		<td colspan="3">
			<select name="hero_youtube_grade">
				<option value="">����</option>
				<option value="��" <?=$_REQUEST["hero_youtube_grade"] == "��" ? "selected":"";?>>��</option>
				<option value="�߻�" <?=$_REQUEST["hero_youtube_grade"] == "�߻�" ? "selected":"";?>>�߻�</option>
				<option value="��" <?=$_REQUEST["hero_youtube_grade"] == "��" ? "selected":"";?>>��</option>
				<option value="����" <?=$_REQUEST["hero_youtube_grade"] == "����" ? "selected":"";?>>����</option>
				<option value="��" <?=$_REQUEST["hero_youtube_grade"] == "��" ? "selected":"";?>>��</option>
			</select>
		</td>
	</tr>
	<tr>
		<th>����</th>
		<td>
			<input type="text" name="hero_level_start" numberOnly value="<?=$_REQUEST["hero_level_start"]?>" style="width:80px"/> ~ <input type="text" name="hero_level_end" numberOnly value="<?=$_REQUEST["hero_level_end"]?>" style="width:80px"/>
		</td>
		<th>������</th>
		<td>
			<input type="text" name="hero_oldday_start" class="dateMode" value="<?=$_REQUEST["hero_oldday_start"]?>" style="width:100px"/> ~ <input type="text" name="hero_oldday_end" name="hero_oldday_end" class="dateMode" value="<?=$_REQUEST["hero_oldday_end"]?>" style="width:100px"/>
		</td>
	</tr>
	<tr>
		<th>����</th>
		<td>
			<input type="radio" name="hero_sex" id="hero_sex_all" value="" <?=!$_REQUEST["hero_sex"] ? "checked":""?>/><label for="hero_sex_all">��ü</label>
			<input type="radio" name="hero_sex" id="hero_sex_0" value="0" <?=($_REQUEST["hero_sex"]=="0" &&  strlen($_REQUEST["hero_sex"]) > 0) ? "checked":""?>/><label for="hero_sex_0">����</label>
			<input type="radio" name="hero_sex" id="hero_sex_1" value="1" <?=$_REQUEST["hero_sex"]=="1" ? "checked":""?>/><label for="hero_sex_1">����</label
		</td>
		<th>���ɴ�</th>
		<td>
			<input type="text" name="hero_age_start" numberOnly value="<?=$_REQUEST["hero_age_start"]?>" style="width:100px"/> ~ <input type="text" name="hero_age_end" numberOnly value="<?=$_REQUEST["hero_age_end"]?>" style="width:100px"/>
		</td>
	</tr>
	<tr>
		<th>�޴��� ���ŵ���</th>
		<td>
			<input type="radio" name="hero_chk_phone" id="hero_chk_phone_all" value="" <?=!$_REQUEST["hero_chk_phone"] ? "checked":""?>/><label for="hero_chk_phone_all">��ü</label>
			<input type="radio" name="hero_chk_phone" id="hero_chk_phone_1" value="1" <?=$_REQUEST["hero_chk_phone"]=="1" ? "checked":""?>/><label for="hero_chk_phone_1">����</label>
			<input type="radio" name="hero_chk_phone" id="hero_chk_phone_2" value="2" <?=($_REQUEST["hero_chk_phone"]!="1" && strlen($_REQUEST["hero_chk_phone"]) > 0) ? "checked":""?>/><label for="hero_chk_phone_2">�̵���</label
		</td>
		<th>�̸��� ���ŵ���</th>
		<td>
			<input type="radio" name="hero_chk_email" id="hero_chk_email_all" value="" <?=!$_REQUEST["hero_chk_email"] ? "checked":""?>/><label for="hero_chk_email_all">��ü</label>
			<input type="radio" name="hero_chk_email" id="hero_chk_email_1" value="1" <?=$_REQUEST["hero_chk_email"]=="1" ? "checked":""?>/><label for="hero_chk_email_1">����</label>
			<input type="radio" name="hero_chk_email" id="hero_chk_email_2" value="2" <?=($_REQUEST["hero_chk_email"]!="1" && strlen($_REQUEST["hero_chk_email"]) > 0) ? "checked":""?>/><label for="hero_chk_email_2">�̵���</label
		</td>
	</tr>
	<tr>
		<th>�˻�</th>
		<td colspan="3">
			<select name="select" style="width:120px;">
            	<option value="hero_nick"<?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>�г���</option>
                <option value="hero_id"<?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>���̵�</option>
                <option value="hero_name"<?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>����</option>
                <option value="hero_hp"<?if(!strcmp($_REQUEST['select'], 'hero_hp')){echo ' selected';}else{echo '';}?>>�ڵ���</option>
            </select>
            <input name="kewyword" type="text" value="<?=$_REQUEST['kewyword'];?>" class="kewyword">
		</td>
	</tr>
	</table>
	<div class="btnGroupSearch">
		<a href="javascript:;" onClick="$('#searchForm').submit();" class="btnSearch">�˻�</a>
	</div>
	
	<p class="explainBox">
		- ���̵� ���� �� �޴»���� �߰��˴ϴ�.(����)<br>
		- üũ�ڽ� ���� �� ���ùڽ� Ŭ�� �� �ϰ� �޴»���� �߰��˴ϴ�.(���� X)
	</p>
	
	<div class="btnGroupFunction">
		<div class="leftWrap">
			�� <strong> <?=number_format($total_data)?></strong>��
		</div>
		<div class="rightWrap">
			 <select name="list_page" style="width:80px;">
		   	 	<option value="20" <?if(!strcmp($_REQUEST['list_page'], '20')){echo ' selected';}?>>20</option>
			   	<option value="50" <?if(!strcmp($_REQUEST['list_page'], '50')){echo ' selected';}?>>50</option>
			   	<option value="100" <?if(!strcmp($_REQUEST['list_page'], '100')){echo ' selected';}?>>100</option>
			   	<option value="200" <?if(!strcmp($_REQUEST['list_page'], '200')){echo ' selected';}?>>200</option>
			   	<option value="500" <?if(!strcmp($_REQUEST['list_page'], '500')){echo ' selected';}?>>500</option>
			 </select>
		</div>
	</div>
</form>
<!-- (e) �˻����� -->
<form name="frm" id="frm" method="post">
<table class="t_list">
	<colgroup>
		<col width="3%">
    	<col width="12%">
        <col width="8%">
        <col width="8%">
        <col width="*">
        <col width="5%">
        <col width="8%">
        <col width="8%">
        <col width="8%">
        <col width="8%">
        <col width="8%">
        <col width="8%">
    </colgroup>
	<thead>
		<tr>
			<th><input type="checkbox" id="allCheck" onClick="fnAllCheck(this)"></th>
			<th>�г���</th>
			<th>���̵�</th>
			<th>�̸�</th>
			<th>�ڵ���</th>
			<th>����</th>
			<th>����</th>
			<th>���̹�<br/>��α�</th>
			<th>�ν�Ÿ</th>
			<th>��Ʃ��</th>
			<th>�޴�������</th>
			<th>�̸��ϼ���</th>
  		</tr>
	</thead>
    <tbody>
<?
$check_i = '1';
while($list  = @mysql_fetch_assoc($out_sql)){
?>
		<tr>
			<td>
				<input type="checkbox" class="hero_checkbox" id="<?='chk'.$check_i?>" name="check" value="<?=$list['hero_id'];?>">
			</td>
			<td><?=$list['hero_nick'];?></td>
		    <td><a href="javascript:;" onClick="fnSelect('<?=$list['hero_id'];?>')" style="color:#376ea6"><?=$list['hero_id'];?></a></td>
		    <td><?=$list['hero_name'];?></td>
		    <td><?=$list['hero_hp'];?></td>
		    <td><?=$list['hero_age'];?></td>
		    <td><?=$list['hero_sex'] == '0' ? '��':'��'?></td>
		    <td><?=$list['hero_blog_00'] ? '����':'-';?></td>
		    <td><?=$list['hero_blog_04'] ? '����':'-'?></td>
		    <td><?=$list['hero_blog_03'] ? '����':'-'?></td>
		    <td><?=$list['hero_chk_phone'] == 1 ? '����':'�ź�'?></td>
		    <td><?=$list['hero_chk_email'] == 1 ? '����':'�ź�'?></td>
		</tr>
<?
$check_i++;
}
?>
	</tbody>
</table>
</form>
<div class="btnGroup">
	<a href="javascript:;" onClick="fnCheckSelect()" class="btnAdd">����</a>
</div>
<div style="width:100%; text-align:center; margin-top:20px;">                        
<?
function page2($total,$list,$tail,$page,$next_path){
    global $PHP_SELF;
    $total_page = ceil($total/$list);
    if (!$page) $page = 1;
    $page_list = ceil($page/$tail)-1;
    if($page_list>0){
        $tail_page  = '     <a href="#" onclick="javascript:go_submit(searchForm,\''.$_REQUEST["idx"].'\',\'1\')"><span class="page"><<</span></a>'.PHP_EOL;
        $prev_page  = ($page_list-1)*$tail+1;
        $tail_page  = '     <a href="#" onclick="javascript:go_submit(searchForm,\''.$_REQUEST["idx"].'\',\''.$prev_page.'\')"><span class="page"><</span></a>'.PHP_EOL;
    }
    $page_end=($page_list+1)*$tail;
    if($page_end>$total_page) $page_end=$total_page;
    for($setpage=$page_list*$tail+1;$setpage<=$page_end;$setpage++){
        if ($setpage==$page){
            $tail_page .= '                            <a href="#" class="on"><span class="page">'.$setpage.'</span></a>'.PHP_EOL;
        }else{
            $tail_page .= '                            <a href="#" onclick="javascript:go_submit(searchForm,\''.$_REQUEST["idx"].'\',\''.$setpage.'\')"><span>'.$setpage.'</span></a>'.PHP_EOL;
        }
    }
    if($page_end<$total_page){
        $next_page = ($page_list+1)*$tail+1;
        $tail_page .= '     <a href="#" onclick="javascript:go_submit(searchForm,\''.$_REQUEST["idx"].'\',\''.$next_page.'\')"><span class="page">></span></a>'.PHP_EOL;
        $tail_page .= '     <a href="#" onclick="javascript:go_submit(searchForm,\''.$_REQUEST["idx"].'\',\''.$total_page.'\')"><span class="page">>></span></a>'.PHP_EOL;
    }
    return $tail_page;
}
?>
<div class="paginate"><?=page2($total_data,$list_page,$page_per_list,$page,$search_next)?></div>
<script>
function go_submit(temp_form,idx,page){
    //temp_form.action="<?=PATH_HOME?>?"+link+"&page="+page;
    temp_form.action="<?=PATH_HOME?>?page="+page+"&board=mail&idx="+idx;
    temp_form.submit();
    return true;
}
</script>
                        </div>
<? //include_once BOARD_INC_END.'search.php';?>
						
</div>
                        </div>


<script type="text/javascript" src="/loak/loak.js?v=1"></script>
<script src="/js/jquery.form.js"></script>
<script type="text/javascript">
    var myeditor = new cheditor();              // ������ ��ü�� �����մϴ�.
    myeditor.config.editorHeight = '300px';     // ������ �������Դϴ�.
    myeditor.config.editorWidth = '100%';        // ������ �������Դϴ�.
   
    myeditor.inputForm = 'editor2';             // textarea�� id �̸��Դϴ�. ����: name �Ӽ� �̸��� �ƴմϴ�.
    myeditor.run();                             // �����͸� �����մϴ�.
    
$(document).ready(function(){
    $("#draggable").draggable();
    $("#close_popup").click(function(){
        $("#draggable").hide();
    });

    // ��� �˸��� ��ư�� Ŭ�� �̺�Ʈ �߰�
    $(".btn_message_title").on("click", function () {
        updateEditor($(this).attr("title"));
    });

    // ���� ��ư Ŭ�� �� �ش� ���� ǥ��
    $("input[name='alrimtalk_type']").on("click", function () {
        let contentId = $(this).attr("id").replace("alrimtalk_type_", "alrimtalk_content_");
        updateEditor($("#" + contentId).attr("title"));
    });
});

var search = "<?=$search?>";
var new_kewyword="<?=$_REQUEST['select']?>";
var new_page="<?=$_REQUEST['page']?>";
    
function updateEditor(content) {
    $("#editor").text(content).val(content);
}

function showzip(){
    $('#draggable').show();
}

function inputzip(){
    $('#draggable').hide();
}

if(new_kewyword!=""){
	showzip();
}

if(new_page!=""){
	showzip();
}

if(search != "") {
	showzip();
}


function fnAllCheck(t) {
	if($(t).is(":checked")) {
		$("input:checkbox[name='check']").prop("checked",true);
	} else {
		$("input:checkbox[name='check']").prop("checked",false);
	}
}

function goSend() { //���� ������
	//form_next
	if(!$("input[name='alrimtalk_type']").is(":checked")) {
		alert("�˸��� ������ Ȯ���� �ּ���.");
		return;
	}

	if(!$("#hero_title").val()) {
		alert("������ �Է��� �ּ���.");
		return;
	}
	
	 myeditor.outputBodyHTML();

	$("#form_next").submit();
}

function fnSelect(hero_id) {
	var select_val = "";
	if($("#hero_user").val() == "all") {
		$("#hero_user").val("");
		$("input[name='search_uesr']").val("");
	}	

	if($("#hero_user").val()) {
		select_val += $("#hero_user").val()+"||"+hero_id
	} else {
		select_val = hero_id
	}

	$("#hero_user").val(select_val);
	$("input[name='search_uesr']").val(select_val);
}

function fnCheckSelect() {
	var select_val = "";
	if($("#hero_user").val() == "all") {
		$("#hero_user").val("");
		$("input[name='search_uesr']").val("");
	}

	var checkList = $("input:checkbox[name='check']:checked");
	if(checkList.length > 0) {
		var hero_id_arr = "";
		$("input:checkbox[name='check']:checked").each(function(){
			if(hero_id_arr && this.value) hero_id_arr += "||";
			hero_id_arr += this.value;
		})
	}
	
	/*if($("#hero_user").val()) {
		select_val += $("#hero_user").val()+"||"+hero_id_arr
	} else {
		select_val = hero_id_arr
	}*/
	$("input[name='search_uesr']").val(""); //���� ����
	$("#hero_user").val(hero_id_arr);
}
                        
function change(inputID, inputVALUE) {
var f = document.getElementById(inputID);
var temp_user = document.getElementById('hero_user').value;
    if(f.checked == false){
        f.checked = true;
        if(temp_user=='all'){
            document.getElementById('hero_user').value=inputVALUE;
            document.getElementById('hero_user_01').value=inputVALUE;
        }else if(temp_user==''){
            document.getElementById('hero_user').value=inputVALUE;
            document.getElementById('hero_user_01').value=inputVALUE;
        }else{
            document.getElementById('hero_user').value=temp_user+'||'+inputVALUE;
            document.getElementById('hero_user_01').value=temp_user+'||'+inputVALUE;
        }
        document.getElementById('list'+inputVALUE).style.background='#B9DEFF';
    }else{
        f.checked = false;
        var delete_temp = document.getElementById('hero_user').value.split("||");
        var del_len = delete_temp.length;
        for(var i=0; i<=del_len; i++){
            if(delete_temp[i] == inputVALUE){
                var deldel = i;
            }
        }
        var delete_end = delete_temp.splice(deldel, 1);
        document.getElementById('hero_user').value=delete_temp.join('||');
        document.getElementById('hero_user_01').value=delete_temp.join('||');
        document.getElementById('list'+inputVALUE).style.background='white';
    }
} 
</script>
