<link rel="stylesheet" type="text/css" href="/css/front/lovertalk.css">
<link rel="stylesheet" type="text/css" href="/css/front/supporters.css">
<?
if (! defined ( '_HEROBOARD_' )) exit ();

$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\'' . $_GET ['board'] . '\';'; // desc
sql ( $sql );
$right_list = @mysql_fetch_assoc ( $out_sql );

$view_sql = 'select * from mission where hero_table = \'' . $_GET ['board'] . '\' and hero_idx=\'' . $_GET ['idx'] . '\';';

$out_view_sql = mysql_query ( $view_sql );
$view_row = @mysql_fetch_assoc ( $out_view_sql ); // mysql_fetch_row

//�̼� �������� ��Ͽ���
if($_GET ['idx']) {
	$survey_sql = " SELECT count(*) cnt FROM mission_survey WHERE mission_idx = '".$_GET ['idx']."' ";
	$survey_res = sql($survey_sql);
	$survey_rs = mysql_fetch_assoc($survey_res);
}

$focus_group = false;

//��� ����
if($_GET["board"] == "group_04_06" || $_GET["board"] == "group_04_28") {
	$focus_group = true;
	$sql_gisu = " SELECT hero_beauty_gisu, hero_youtube_gisu, hero_life_gisu FROM mission_gisu ";
	sql($sql_gisu);
	$rs_gisu = @mysql_fetch_assoc($out_sql);

	$rs_gisu_select = "";
	if($view_row["hero_idx"]) {
		if($_GET["board"] == "group_04_06") {
			$rs_gisu_select = $view_row["hero_beauty_gisu"];
		} else if($_GET["board"] == "group_04_27") {
			$rs_gisu_select = $view_row["hero_movie_gisu"];
		} else if($_GET["board"] == "group_04_28") {
			$rs_gisu_select = $view_row["hero_life_gisu"];
		}
	} else {
		if($_GET["board"] == "group_04_06") {
			$rs_gisu_select = $rs_gisu["hero_beauty_gisu"];
		} else if($_GET["board"] == "group_04_27") {
			$rs_gisu_select = "";
		} else if($_GET["board"] == "group_04_28") {
			$rs_gisu_select = $rs_gisu["hero_life_gisu"];
		}
	}

} else if($_GET["board"] == "group_04_27") {
	$focus_group = true;
}

$hero_ftc_naver = "";
$hero_banner = ""; //���̹� ���������� ����
$hero_ftc_insta = "";
$hero_insta = ""; //�ν�Ÿ���������� ����
if($_GET["action"] == "write") {
	$hero_banner = '<a href="http://www.aklover.co.kr" target="_blank"><img src="http://www.aklover.co.kr/image2/banner_04_05.jpg"></a>';
	$hero_insta = "AK LOVER ��ǰ����\n";
} else if($_GET["action"] == "update") {
	$hero_ftc_naver = $view_row["hero_ftc_naver"];
	$hero_banner = $view_row["hero_banner"];
	$hero_ftc_insta = $view_row["hero_ftc_insta"];
	$hero_insta = $view_row["hero_insta"];
}

?>
<!-- <link type='text/css' href='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.css' rel='stylesheet' /> -->
<script type="text/javascript" src="<?=DOMAIN_END?>cal/jquery.min.js"></script>
<script type="text/javascript">
jQuery.noConflict();
</script>
<script type='text/javascript' src='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.min.js'></script>
<script type="text/javascript" src="<?=DOMAIN_END?>js/jquery.form.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#keyWordAdd").click(function(){
		if($("#keyWordStr").val() == ""){
			alert("Ű���带 �Է��� �ּ���.");
			$("#keyWordStr").focus();
			return;
		}
		var tmp = $("#keyWordStr").val().split(",");
		for(var i=0;i<tmp.length;i++){
			if(tmp[i]==''){continue;}
			if($(".delkeyWord").size() != 0){
				frm.hero_keywords.value += ":";
			}
			frm.hero_keywords.value += tmp[i];
			$("#keyWordContainer").append("<span style='padding:5px;' class='keyWordItem'>"+tmp[i]+" <img src='/image/common/icon_delete.gif' align='absmiddle' class='delkeyWord' onClick='delkeyWord(this);' name='"+shuffleRandom(1000)+"' style='cursor:pointer;'/></span>");
		}
		$("#keyWordStr").val("");
	});

	<? if($focus_group) { //�����̼�?>
		$("input[name='hero_type']").on("click",function() {
			if($(this).val() == "7") {
				$("#sdate2, #edate2, #sdate3, #edate3, #sdate4, #edate4, #not_01, #not_02, #not_03, #not_04").show();
				$("#txt_change").html("ü��� ��û");
				if(confirm("�����ؽ�Ʈ [�����̼�]���� �Էµ˴ϴ�.")) {
					$("#hero_kind").val("�����̼�");
				}

				<? if($_GET["board"] == "group_04_06") { ?>
					$("select[name='hero_beauty_gisu']").val("");
					$("select[name='hero_beauty_gisu']").hide();
				<? } else if($_GET["board"] == "group_04_27") { ?>
					//$("select[name='hero_movie_gisu']").val("");
					//$("select[name='hero_movie_gisu']").hide();
				<? } else if($_GET["board"] == "group_04_28") { ?>
					$("select[name='hero_life_gisu']").val("");
					$("select[name='hero_life_gisu']").hide();
				<? } ?>
			} else if($(this).val() == "9") {
				$("#sdate2, #edate2, #sdate3, #edate3, #sdate4, #edate4, #not_01, #not_02, #not_03, #not_04").show();
				$("#txt_change").html("ü��� ��û");
				if(confirm("�����ؽ�Ʈ [����̼�]���� �Էµ˴ϴ�.")) {
					$("#hero_kind").val("����̼�");
				}

				<? if($_GET["board"] == "group_04_06") { ?>
					$("select[name='hero_beauty_gisu']").val("<?=$rs_gisu_select?>");
					$("select[name='hero_beauty_gisu']").show();
				<? } else if($_GET["board"] == "group_04_27") { ?>
					$("select[name='hero_movie_gisu']").val("<?=$rs_gisu_select?>");
					$("select[name='hero_movie_gisu']").show();
					selMovieGisu($("select[name='hero_movie_group']").val(),'<?=$rs_gisu_select?>');
				<? } else if($_GET["board"] == "group_04_28") { ?>
					$("select[name='hero_life_gisu']").val("<?=$rs_gisu_select?>");
					$("select[name='hero_life_gisu']").show();
				<? } ?>
			} else {
				$("#sdate2, #edate2, #sdate3, #edate3, #sdate4, #edate4, #not_01, #not_02, #not_03, #not_04").hide();
				$("#txt_change").html("�ı� ���");
				if(confirm("�����ؽ�Ʈ [����̼�]���� �Էµ˴ϴ�.")) {
					$("#hero_kind").val("����̼�");
				}

				<? if($_GET["board"] == "group_04_06") { ?>
					$("select[name='hero_beauty_gisu']").val("<?=$rs_gisu_select?>");
					$("select[name='hero_beauty_gisu']").show();
				<? } else if($_GET["board"] == "group_04_27") { ?>
					//$("select[name='hero_movie_gisu']").val("<?=$rs_gisu_select?>");
					//$("select[name='hero_movie_gisu']").show();
					//selMovieGisu($("select[name='hero_movie_group']").val(),'<?=$rs_gisu_select?>');
				<? } else if($_GET["board"] == "group_04_28") { ?>
					$("select[name='hero_life_gisu']").val("<?=$rs_gisu_select?>");
					$("select[name='hero_life_gisu']").show();
				<? } ?>
			}
		})
	<? } ?>
});

function delkeyWord(obj){
	var values = "";
	frm.hero_keywords.value = "";
	var target = "";
	for(var i=0;i<$(".delkeyWord").size();i++){
		if($(".delkeyWord").eq(i).attr("name") == obj.name){
			target = i;
		}else{
			frm.hero_keywords.value += $(".keyWordItem").eq(i).text()+":";
		}
	}
	$(".keyWordItem").eq(target).remove();
	var tmp = frm.hero_keywords.value.length;
	if(frm.hero_keywords.value.substring(tmp,tmp-1) == ":"){
		frm.hero_keywords.value = frm.hero_keywords.value.substr(0,frm.hero_keywords.value.length-1);
	}
}
function shuffleRandom(n){
	var ar = new Array();
	var temp;
	var rnum;
	for(var i=1; i<=n; i++){ar.push(i);}
	for(var i=0; i< ar.length ; i++){
		rnum = Math.floor(Math.random() *n);
		temp = ar[i];
		ar[i] = ar[rnum];
		ar[rnum] = temp;
	}
	return ar;
}
</script>
<div id="subpage" class="talk_write">
<div class="sub_wrap board_wrap">
<div class="contents right">
	<div class="write_cont">
	<div class="cont_top">
		<? if($_GET['board'] == "group_04_06") {?>
			<h2 class="fz15 fw600 main_c">�����̾� ��Ƽ Ŭ��</h2>
		<? } else if($_GET['board'] == "group_04_28") {?>
			<h2 class="fz15 fw600 main_c">�����̾� ������ Ŭ��</h2>
		<? } else if($_GET['board'] == "group_04_05") { ?>
			<h2 class="fz15 fw600 main_c">������ ��Ƽ&������ Ŭ��</h2>
		<? } ?>
	</div>
	<div><img src="/image/bbs/guide_thumb.gif"/></div>
		<div style="background:#F2F2F2;margin-bottom:10px;">
			<div id="thumbnailView" style="width:680px;height:105px;overflow-x:hidden;overflow-y:scroll;"></div>
		</div>
		<script type="text/javascript" src="/loak/loak.js?v=1"></script>
		<form name="frm" id="form1" method="post" action="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&view=action_write&action=<?=$_GET['action']?>&idx=<?=$_GET['idx'];?>&page=<?=$_GET['page'];?>" enctype="multipart/form-data">
        	<span style="color:#F00">�������ε� �ִ������ : 730px(������ 730px�� ��� ���� ���Ұ����մϴ�)</span>
			<div class="spm_img spm_editor">
			<input type="hidden" name="hero_drop" value="hero_drop||sm_file||command||chkbox||inputWidth||inputAlt||inputCaption||setWidth||setHeight||setBgcolor||thumbCount||keyWordStr||command2||inputTitle">
			<input type="hidden" name="hero_code" value="<?=$_SESSION['temp_code'];?>">
			<input type="hidden" name="hero_table" value="<?=$_GET['board'];?>">
			<input type="hidden" name="hero_id" value="<?=$_SESSION['temp_id'];?>">
			<input type="hidden" name="hero_name" value="<?=$_SESSION['temp_name'];?>">
			<input type="hidden" name="hero_nick" value="<?=$_SESSION['temp_nick'];?>">
			<input type="hidden" name="thumbCount" id="thumbCount" value="0">
			<input type="hidden" name="hero_thumb" id="hero_thumb" value="<?=$view_row['hero_thumb']?>">
			<input type="hidden" name="hero_ask" id="hero_ask">
            <input type="hidden" name="hero_multiple" id="hero_multiple">
            <input type="hidden" name="hero_multiple_answer" id="hero_multiple_answer">
            <input type="hidden" name="hero_single" id="hero_single">
            <input type="hidden" name="hero_single_answer" id="hero_single_answer">
			<input type="hidden" name="hero_img_old" value="<?=$view_row['hero_img_old']?>"/>
			<input type="hidden" name="hero_bg" value="#d7f4fc"/>
			<?if(strcmp($_GET['action'], 'update')){?>
            <input type="hidden" name="hero_today" value="<?=Ymdhis?>">
			<?}?>
            <input type="hidden" name="hero_ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
            <input type="hidden" name="hero_question_url_list" id="hero_question_url_list"/>
            <textarea id="editor" name="command"><?=htmlspecialchars_decode($view_row['hero_command'])?></textarea>
			</div>
			<div class="spm_txt spm_mission_box">
				<dl>
					<dt>
						<span class="bg1">ü��� Ÿ��</span>
					</dt>
					<dd class="line2">
						<? if($focus_group) {?>
							<div class="f_fs">
								<div class="input_radio mgr20">
									<input type="radio" id="type01" name="hero_type" value="0" <? echo ($view_row['hero_type']==0)? "checked='checked'" : "" ;?>/>
									<label for="type01" class="">����̼�</label>
								</div>
								<div class="input_radio mgr20">
									<input type="radio" id="type02" name="hero_type" value="9" <? echo ($view_row['hero_type']==9)? "checked='checked'" : "" ;?>/>
									<label for="type02" class="">����̼�(����)</label>
								</div>
								<div class="input_radio mgr20">
									<input type="radio" id="type03" name="hero_type" value="7" <? echo ($view_row['hero_type']==7)? "checked='checked'" : "" ;?>/>
									<label for="type03" class="">�����̼�</label>
								</div>
							</div>
						<? } else { ?>
							<div class="f_fs">
								<div class="input_radio mgr20">
									<input type="radio" id="type04" name="hero_type" value="0" <? echo ($view_row['hero_type']==0)? "checked='checked'" : "" ;?>/>
									<label for="type04" class="">�Ϲݹ̼�</label>
								</div>
								<div class="input_radio mgr20">
									<input type="radio" id="type05" name="hero_type" value="10" <? echo ($view_row['hero_type']==10)? "checked='checked'" : "" ;?>/>
									<label for="type05" class="">ü���</label>
								</div>
							</div>
						<? } ?>
						<div class="f_fs">
							<div class="input_radio mgr20">
								<input type="radio" id="type06" name="hero_type" value="1" <? echo ($view_row['hero_type']==1)? "checked='checked'" : "" ;?>/>
								<label for="type06" class="">�̺�Ʈ</label>
													</div>
							<div class="input_radio mgr20">
								<input type="radio" id="type07" name="hero_type" value="2" <? echo ($view_row['hero_type']==2)? "checked='checked'" : "" ;?>/>
								<label for="type07" class="">�ҹ�����</label><br/>
													</div>
							<div class="input_radio mgr20">
								<input type="radio" id="type08" name="hero_type" value="3" <? echo ($view_row['hero_type']==3)? "checked='checked'" : "" ;?>/>
								<label for="type08" class="">��������</label>
													</div>
							<div class="input_radio mgr20">
								<input type="radio" id="type09" name="hero_type" value="8" <? echo ($view_row['hero_type']==8)? "checked='checked'" : "" ;?>/>
								<label for="type09" class="">����Ʈü��</label>
													</div>
							<div class="input_radio mgr20">
								<input type="radio" id="type10" name="hero_type" value="5" <? echo ($view_row['hero_type']==5)? "checked='checked'" : "" ;?>/>
								<label for="type10" class="">��ǰǰ��</label>
							</div>
						</div>
					</dd>
				</dl>
                        <script>
						var appendText = "<dl class='d2'><dt>";
						appendText += "<span class='bg1'>����� ����</span></dt>";
						appendText += "<dd><input type='text' id='hero_select_best' placeholder='���ڸ� �Է����ּ���.'onkeydown=\"ch_number('hero_select_best')\" onblur=\"ch_number('hero_select_best')\"";
						appendText += "name='hero_select_best' value='<?=$view_row['hero_select_best']?>' style='width:550px; height: 23px;'/>";
						appendText += "</dd></dl>";

						var appendBlank = "";

						$(document).ready(function() {

							if($(':radio[name="hero_type"]:checked').val() == 2 || $(':radio[name="hero_type"]:checked').val() == 10) {
								var txt1 = "";
								if($(':radio[name="hero_type"]:checked').val() == "2") {
									txt1 = "�ҹ�����";
								} else if($(':radio[name="hero_type"]:checked').val() == "10") {
									txt1 = "ü���";
								}

								$('.d2').remove();
								$('.d1').children().children().text(txt1+" ����");
								$('.d3').text(txt1+' ����');
								$('.d4').text('���� �� ����');
								$('.d5').text('���� �� ��������');
								$('.d1').after(appendText);
								$('.s1').css('display','block');
								$('.s2').css('display','none');
							} else {
								$('.d1').children().children().text('��������');
								$('.d3').text('ü��� ��û');
								$('.d4').text('��û �� ����');
								$('.d5').text('��û �� ��������');
								$('.d2').remove();
								$('.s1').css('display','none');
								$('.s2').css('display','block');
							}

							$("input:radio[name=hero_type]").click(function() {

								var mission_text  = "- �� ü����� <span style=color:red;>��α� 1�� + �ν�Ÿ�׷� 1�� �� 2�� �ʼ�</span>�Դϴ�.<br/>";
									mission_text += "- ü��� ��û �� ��α� URL �� �ν�Ÿ�׷� URL�� Ȯ�ε��� ���� ���<br/>&nbsp; �����н��� ����ϴ��� ������ �������� ���ܵǸ� ��� ��� �� �����н��� ��߱� ���� �ʽ��ϴ�.<br/>";
									mission_text += "- ��� ����Ʈ ���� ��, ü��� ���� �������� �����Ǵ� ��ǰ ��۷�� ���� �δ��Դϴ�.<br/>";
									mission_text += "- �귣�� ��û�� ���� �ο� �� ��������, ����� ������ ����� ���� �ֽ��ϴ�.<br/>";
									mission_text += "- �ڵ������ٴ� ī�޶�� ���� ������ Ȱ�����ּ���.<br/>";
									mission_text += "- <span style=color:red;>����, 3���� �� ���� ������ ����� ����! ����� Ȯ�� �� ���Ƽ �ΰ� �� �� �ִ� �� ���� ��Ź�帳�ϴ�!</span><br/><br/>";
									mission_text += "<span style=color:red;>* �Ⱓ �� �ı� �� ��Ͻ� 1,000����Ʈ ������ �Բ� 3���� �� ü��� �������� ���ܵ˴ϴ�.</span><br/>";
									mission_text += "- �ı� ��� �� [������ ���̵�] �� ��ʸ� �ݵ�� ������ �� �������ּ���.";

								var hero_banner_txt = "<a href=\"http://www.aklover.co.kr\" target=\"_blank\"><img src=\"http://www.aklover.co.kr/image2/banner_04_05.jpg\"></a>";
								var hero_insta_txt = "AK LOVER ��ǰ����";

								if($(this).val() == 2 || $(this).val() == 10) {
									var txt1 = "";
									if($(this).val() == "2") {
										txt1 = "�ҹ�����";
									} else if($(this).val() == "10") {
										txt1 = "ü���";
									}

									$('.d2').remove();

									$('.d1').children().children().text(txt1+" ����");
									$('.d3').text(txt1+' ����');
									$('.d4').text('���� �� ����');
									$('.d5').text('���� �� ��������');
									$('.d1').after(appendText);
									$('.s1').css('display','block');
									$('.s2').css('display','none');

									$("#hero_banner").val(hero_banner_txt);
									$("#hero_insta").val(hero_insta_txt);
								} else if($(this).val() == 8) {
									hero_banner_txt = "<a href=\"http://www.aklover.co.kr\" target=\"_blank\"><img src=\"http://www.aklover.co.kr/image2/banner_point_04_05.jpg\"></a>";
									hero_insta_txt = "AK LOVER ��ǰ�� �� ���� ����";

									$("#hero_banner").val(hero_banner_txt);
									$("#hero_insta").val(hero_insta_txt);

								} else {
									$('.d1').children().children().text('��������');
									$('.d3').text('ü��� ��û');
									$('.d4').text('��û �� ����');
									$('.d5').text('��û �� ��������');
									$('.d2').remove();
									$('.s1').css('display','none');
									$('.s2').css('display','block');

									$("#hero_banner").val(hero_banner_txt);
									$("#hero_insta").val(hero_insta_txt);
								}

								missionText($(this).val(), <?=$_GET["board"]?>);
							});

						});
						</script>

				<dl>
					<dt>
						<span class="bg1">�����н� ����</span>
					</dt>
					<dd>
						<div class="input_radio"><input type="radio" id="use1" name="hero_superpass" value="Y" <? echo ($view_row['hero_superpass']=='Y')? "checked='checked'" : "" ;?>/> <label for="use1">���</label></div>
						<div class="input_radio"><input type="radio" id="use2" name="hero_superpass" value="N" <? echo ($view_row['hero_superpass']=='N')? "checked='checked'" : "" ;?>/> <label for="use2">�̻��</label></div>
					</dd>
				</dl>
				 <dl>
					<dt>
						<span class="bg1">��� POINT����</span>
					</dt>
					<dd>
						<div class="input_radio"><input type="radio" id="use3" name="delivery_point_yn" value='Y' <?=$view_row['delivery_point_yn']=='Y'?'checked':''?>/> <label for="use3">���</label></div>
						<div class="input_radio"><input type="radio" id="use4" name="delivery_point_yn" value='N' <?=($view_row['delivery_point_yn']=='N' || $view_row['delivery_point_yn']=='')?'checked':''?>/> <label for="use4">��� ����</label></div>
                    </dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1"><span style="cursor: pointer;" onclick="Javascript:showImageInfo();">����</span></span>
					</dt>
					<dd>
						<input type="text" id="hero_title" name="hero_title" value="<?=$view_row['hero_title']?>" placeholder="������ �Է��ϼ���."
						/>
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1"><span>����</span></span>
					</dt>
					<dd style="padding-top: 1rem;">
						<textarea id="hero_title_02" name="hero_title_02"><?=$view_row['hero_title_02']?></textarea>
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1"><span>���� �ؽ�Ʈ</span></span>
					</dt>
					<dd>
						<input type="text" id="hero_kind" placeholder='6 �������Ϸ� �Է����ֽñ� �ٶ��ϴ�.'
							name="hero_kind" value="<?=$view_row['hero_kind']?>" onblur="ch_count_text_kind(6,'hero_kind');"/>
					</dd>
				</dl>

				<dl>
					<dt>
						<span class="bg1"><span>��û���</span></span>
					</dt>
					<dd>
						<input type="text" id="hero_target" placeholder='28 ���� �̳��� �Է����ֽñ� �ٶ��ϴ�.'
						onkeydown="ch_count_text(28,'hero_target');" onblur="ch_count_text(28,'hero_target');"
							name="hero_target" value="<?=$view_row['hero_target']?>" <?php if($_GET['board'] =='group_04_07'){//�ְ�ڽ� ?>background-color:#F0F0F0;<?php } ?>" />

						<? if($_GET['board'] == "group_04_06") {?>
							<select name="hero_beauty_gisu" style="padding:5px;">
								<option value="">��ƼŬ�� ��� ����</option>
								<? for($z=$rs_gisu["hero_beauty_gisu"] ; $z >= 1; $z--) {?>
								<option value="<?=$z?>" <?=$z==$rs_gisu_select ? "selected":"";?>>��ƼŬ�� <?=$z?>��</option>
								<? } ?>
							</select>
						<? } else if($_GET['board'] == "group_04_27") {?>
							<div style="margin-top:5px;">
								<select name="hero_movie_group" style="padding:5px;" onChange="selMovieGisu(this.value,'<?=$rs_gisu_select;?>')">
									<option value="">����ä�� �׷�</option>
									<option value="group_04_27" <?=$view_row["hero_movie_group"]=="group_04_27" ? "selected":"";?>>Beauty ����</option>
									<option value="group_04_31" <?=$view_row["hero_movie_group"]=="group_04_31" ? "selected":"";?>>Life ����</option>
								</select>
								<select name="hero_movie_gisu" style="padding:5px;">
									<option value="0" selected>��� ����</option>
								</select>
							</div>
						<? } else if($_GET['board'] == "group_04_28") { ?>
							<select name="hero_life_gisu" style="padding:5px;">
								<option value="">������ ��� ����</option>
								<? for($z=$rs_gisu["hero_life_gisu"]; $z >= 1; $z--) { ?>
								<option value="<?=$z?>" <?=$z==$rs_gisu_select ? "selected":"";?>>������Ŭ�� <?=$z;?>��</option>
								<? } ?>
							</select>
						<? } ?>


					</dd>
				</dl>
				<dl>

					<dt>
						<span class="bg1">�����ο�</span>
					</dt>
					<dd>
						<input type="text" id="hero_select_count" placeholder='���ڸ� �Է����ּ���.'
						onkeydown="ch_number('hero_select_count');" onblur="ch_number('hero_select_count');"
							name="hero_select_count" value="<?=$view_row['hero_select_count']?>"/>
					</dd>
				</dl>

				<dl class="d1">
					<dt>
						<span class="bg1">��������</span>
					</dt>
					<dd>
						<input type="text" id="hero_benefit" placeholder='28 ���� �̳��� �Է����ֽñ� �ٶ��ϴ�.'
						onkeydown="ch_count_text(28,'hero_benefit');" onblur="ch_count_text(28,'hero_benefit');"
							name="hero_benefit" value="<?=$view_row['hero_benefit']?>"
							style="width: 550px; height: 23px;<?php if($_GET['board'] =='group_04_07'){//�ְ�ڽ� ?>background-color:#F0F0F0;<?php } ?>" />
					</dd>
				</dl>
                <dl>
					<dt>
						<span class="bg1">����� ����</span>
					</dt>
					<dd>
						<input type="text" id="hero_benefit_02" placeholder='28 ���� �̳��� �Է����ֽñ� �ٶ��ϴ�.'
						onkeydown="ch_count_text(28,'hero_benefit_02');" onblur="ch_count_text(28,'hero_benefit_02');"
							name="hero_benefit_02" value="<?=$view_row['hero_benefit_02']?>"/>
					</dd>
				</dl>
                <dl>
					<dt>
						<span class="bg1">ü��� �ȳ�</span>
					</dt>
					<dd class="no-top">
					<?php if($view_row['hero_guide']){?>
						<textarea name="hero_guide" id="editor3" class="textarea" style="width:600px; height: 150px;"><?=htmlspecialchars_decode($view_row['hero_guide']);?></textarea>
	                <?php }else{
	                    if($_GET["board"] == "group_04_06") {
	                        $mission_text = "<strong>[�̼�����]</strong><br/>
                            <strong>���̼� ��ǰ:</strong> <br/>
                            <strong>���̼� ��û ����:</strong><br/> 
                            <strong>���̼� ��ǰ �߼���:</strong> <br/>
                            <strong>������ ���� �� Ȩ������ �� �ı���:</strong>  <br/>
                            <span style=color:red;><strong>�� �̼� ���̵� �ǿ��� ���̵���� �ٿ�ε� �� ������ �ۼ� ��Ź�帳�ϴ�.</strong></span><br/>
                            <strong>�� �Ⱓ �� ������ ���ε� �� Ȩ������ �ı��� �Ϸ� = ���� �̼� ����</strong><br/>
                            <strong>�� ���� �̼� �����ڿ� ���Ͽ� AK LOVER ����Ʈ�� ���޵˴ϴ�.</strong><br/>
                               * �ʼ� �̼� + �����̼� ����Ʈ ���� ���� ���̵���� ����<br/><br/>
                             
                            <strong>[�̼� ��û ��� ���]</strong><br/>
                            <span style=color:red;>* ��û�� ������ ���� ��� ����, ��û�Ⱓ ���� ���� ��� �Ұ�</span><br/>
                            �� ��û �Ϸ� �̼� ����<br/>
                            �� �ϴ� [��û�� Ȯ��] ��ư Ŭ��<br/>
                            �� [����] Ŭ�� > ��� �Ϸ�<br/><br/>
                             
                            <strong>[�̼� ���� ���ǻ���]</strong><br/>
                            - �ȳ� �� �̼� ���� �Ⱓ�� �ݵ�� �������ּ���.<br/>
                            - �������� \"�ı� ���\" �Ⱓ �� Ȩ�������� ������ּ���.<br/>
                              * ��� ���: �ش� ������ \"�ı� ����ϱ�\" ��ư Ŭ�� �� �ȳ��� ���� ���<br/>
                            - ���ε� �Ϸ� �� ������ URL�� Ȩ�������� ������� ���� ���<br/>
                              �Ⱓ �� �̼� �̼������� ���ֵǸ� ������ ������ ��ƽ��ϴ�.<br/>
                            - �������� ������ ���̵���� ���� �� �ۼ����ּ���.<br/>
                              <span style=color:red;>* ���̵� �� �ȳ� �� ȭ��ǰ�� �� ǥ�ñ��� ����ȭ ���� ���� ���Ǻ�Ź�帳�ϴ�.</span><br/>
                              <span style=color:red;>* ��Ȱȭ����ǰ ���� ǥ�á����� ���� ������ �����Ǿ����ϴ�.</span>( ��ũ���� )<br/>
                            - �̼� ������ ����� ��ȯ �� ���� ����<br/>
                            - �ۼ��� �������� ���� ������ �ڷ�� Ȱ��� �� �ֽ��ϴ�.<br/><br/>
                             
                            <strong>[���Ƽ �� ���� �ȳ�]</strong><br/><br/>
                            
                            - �̼� ������ 2ȸ �Ǵ� �Ⱓ �� �ı� �̵�� 5ȸ �̻��� �� Ȱ�� �Ұ�<br/>
                            - Ȱ�� �Ϸ� ������ �� 1ȸ, Ȱ�� �Ⱓ �� �� 10ȸ �̻� ����̼� ���� �� ����<br/>
                              * �̼� ���� �ִ� Ƚ���� ������ �����ϴ�.<br/>
                            - Ȱ�� �ȳ��ڷ� Ȯ���ϱ�: <br/><br/>
                            
                            <strong>[����]</strong><br/>
                            - ��ǰ����: 080-024-1357(�����ںδ�) �ְ� ����������<br/>
                            - �̼ǹ���: īī���� �÷��� ģ�� <��ƼŬ��> 1:1 ��ȭ<br/>
                            ";
	                    } else if($_GET["board"] == "group_04_28") {
	                        $mission_text = "<strong>[�̼�����]</strong><br/>
                            <strong>���̼� ��ǰ: </strong><br/>                          
                            <strong>���̼� ��û ����: </strong><br/>
                            <strong>���̼� ��ǰ �߼���: </strong><br/>
                            <strong>������ ���� �� Ȩ������ �� �ı���: </strong><br/>
                            <span style=color:red;><strong>�� �̼� ���̵� �ǿ��� ���̵���� �ٿ�ε� �� ������ �ۼ� ��Ź�帳�ϴ�.</strong></span><br/>
                            <strong>�� �Ⱓ �� ������ ���ε� �� Ȩ������ �ı��� �Ϸ� = ���� �̼� ����</strong><br/>
                            <strong>�� ���� �̼� �����ڿ� ���Ͽ� AK LOVER ����Ʈ�� ���޵˴ϴ�.</strong><br/>
                               * �ʼ� �̼� + �����̼� ����Ʈ ���� ���� ���̵���� ����<br/><br/>
                             
                            <strong>[�̼� ��û ��� ���]</strong><br/>
                            <span style=color:red;>* ��û�� ������ ���� ��� ����, ��û�Ⱓ ���� ���� ��� �Ұ�</span><br/>
                            �� ��û �Ϸ� �̼� ����<br/>
                            �� �ϴ� [��û�� Ȯ��] ��ư Ŭ��<br/>
                            �� [����] Ŭ�� > ��� �Ϸ�<br/><br/>
                             
                            <strong>[�̼� ���� ���ǻ���]</strong><br/>
                            - �ȳ� �� �̼� ���� �Ⱓ�� �ݵ�� �������ּ���.<br/>
                            - �������� \"�ı� ���\" �Ⱓ �� Ȩ�������� ������ּ���.<br/>
                              * ��� ���: �ش� ������ \"�ı� ����ϱ�\" ��ư Ŭ�� �� �ȳ��� ���� ���<br/>
                            - ���ε� �Ϸ� �� ������ URL�� Ȩ�������� ������� ���� ���<br/>
                              �Ⱓ �� �̼� �̼������� ���ֵǸ� ������ ������ ��ƽ��ϴ�.<br/>
                            - �������� ������ ���̵���� ���� �� �ۼ����ּ���.<br/>
                              <span style=color:red;>* ���̵� �� �ȳ� �� ȭ��ǰ�� �� ǥ�ñ��� ����ȭ ���� ���� ���Ǻ�Ź�帳�ϴ�.</span><br/>
                              <span style=color:red;>* ��Ȱȭ����ǰ ���� ǥ�á����� ���� ������ �����Ǿ����ϴ�.</span> ( ��ũ���� )<br/>
                            - �̼� ������ ����� ��ȯ �� ���� ����<br/>
                            - �ۼ��� �������� ���� ������ �ڷ�� Ȱ��� �� �ֽ��ϴ�.<br/><br/>
                             
                            <strong>[���Ƽ �� ���� �ȳ�]</strong><br/>
                            - �̼� ������ 2ȸ �Ǵ� �Ⱓ �� �ı� �̵�� 5ȸ �̻��� �� Ȱ�� �Ұ�<br/>
                            - Ȱ�� �Ϸ� ������ �� 1ȸ, Ȱ�� �Ⱓ �� �� 10ȸ �̻� ����̼� ���� �� ����<br/>
                              * �̼� ���� �ִ� Ƚ���� ������ �����ϴ�.<br/>
                            - Ȱ�� �ȳ��ڷ� Ȯ���ϱ�:<br/><br/>  
                             
                            <strong>[����]</strong><br/>
                            - ��ǰ����: 080-024-1357(�����ںδ�) �ְ� ����������<br/>
                            - �̼ǹ���: īī���� �÷��� ģ�� <������Ŭ��> 1:1 ��ȭ<br/>
                            ";
	                    } else {
	                        $mission_text = "- �� ü����� <span style=color:red;>��α� 1�� + �ν�Ÿ�׷� 1�� �� 2�� �ʼ�</span>�Դϴ�.<br/>
                    		- ü��� ��û �� ��α� URL �� �ν�Ÿ�׷� URL�� Ȯ�ε��� ���� ���<br/>&nbsp; �����н��� ����ϴ��� ������ �������� ���ܵǸ� ��� ��� �� �����н��� ��߱� ���� �ʽ��ϴ�.<br/>
                    		- ��� ����Ʈ ���� ��, ü��� ���� �������� �����Ǵ� ��ǰ ��۷�� ���� �δ��Դϴ�.<br/>
                    		- �귣�� ��û�� ���� �ο� �� ��������, ����� ������ ����� ���� �ֽ��ϴ�.<br/>
                    		- �ڵ������ٴ� ī�޶�� ���� ������ Ȱ�����ּ���.<br/>
                    		- <span style=color:red;>����, 3���� �� ���� ������ ����� ����! ����� Ȯ�� �� ���Ƽ �ΰ� �� �� �ִ� �� ���� ��Ź�帳�ϴ�!</span><br/><br/>
                    		<span style=color:red;>* �Ⱓ �� �ı� �� ��Ͻ� 1,000����Ʈ ������ �Բ� 3���� �� ü��� �������� ���ܵ˴ϴ�.</span><br/>
                    		- �ı� ��� �� [������ ���̵�] �� ��ʸ� �ݵ�� ������ �� �������ּ���.";
	                    }
					?>
						<textarea name="hero_guide" id="editor3" class="textarea" style="width:600px; height: 150px;"><?=$mission_text ?></textarea>
	                <?php }?>
					</dd>
				</dl>
                <dl>
					<dt>
						<span class="bg1">������ ���̵�</span>
					</dt>
					<dd>
						<textarea name="hero_help" id="hero_help" class="textarea" style="width: 550px; height: 150px;"><?=$view_row['hero_help'];?></textarea>
					</dd>
				</dl>
                <dl class="dis-no">
					<dt>
						<span class="bg1">ü��� ����</span>
					</dt>
					<dd class="f_cs date_selec">
						<input type="text" id="sdate5" name="hero_today_05_01"
						value="<?=$view_row['hero_today_05_01']?>" class="input10"
						style="text-align: center" /> <input type="text"
						id="edate5" name="hero_today_05_02"
						value="<?=$view_row['hero_today_05_02']?>" class="input10"
						style="text-align: center" /> <input type="button" value="�ʱ�ȭ" onclick="$('#sdate5').val('');$('#edate5').val('');"/>
					</dd>
				</dl>
				<dl>
					<dt>
						 <? if($focus_group){?>
							<script>
								$(function(){
									$("#sdate2, #edate2, #sdate3, #edate3, #sdate4, #edate4, #not_01, #not_02, #not_03, #not_04").hide();
								});
							</script>
							<span class="bg1" id="txt_change">�ı� ���</span>
						<? }else{?>
							<span class="bg1 d3">ü��� ��û</span>
						<? }?>
					</dt>
					<dd class="f_cs date_selec">
						<input type="text" id="sdate1" name="hero_today_01_01"
							value="<?=$view_row['hero_today_01_01']?>" class="input10"
							style="text-align: center" readonly /> <input type="text"
							id="edate1" name="hero_today_01_02"
							value="<?=$view_row['hero_today_01_02']?>" class="input10"
							style="text-align: center" readonly />
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1" id="not_01">������ ��ǥ</span>
					</dt>
					<dd class="f_cs date_selec">
						<input type="text" id="sdate2" name="hero_today_02_01"
							value="<?=$view_row['hero_today_02_01']?>" class="input10"
							style="text-align: center" readonly /> <input type="text"
							id="edate2" name="hero_today_02_02"
							value="<?=$view_row['hero_today_02_02']?>" class="input10"
							style="text-align: center" readonly />
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1" id="not_02">�ı� ���</span>
					</dt>
					<dd class="f_cs date_selec">
						<input type="text" id="sdate3" name="hero_today_03_01"
							value="<?=$view_row['hero_today_03_01']?>" class="input10"
							style="text-align: center" readonly /> <input type="text"
							id="edate3" name="hero_today_03_02"
							value="<?=$view_row['hero_today_03_02']?>" class="input10"
							style="text-align: center" readonly />
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1" id="not_04">����ı� ��ǥ</span>
					</dt>
					<dd class="f_cs date_selec">
						<input type="text" id="sdate4" name="hero_today_04_01"
							value="<?=$view_row['hero_today_04_01']?>" class="input10"
							style="text-align: center" readonly /> <input type="text"
							id="edate4" name="hero_today_04_02"
							value="<?=$view_row['hero_today_04_02']?>" class="input10"
							style="text-align: center" readonly />
					</dd>
				</dl>
				<dl id="not_03" class="s2">
					<span class="fz14" style="color:#B19D75; line-height: 1.8rem;" >
						<b style="font-weight: 600;">* �ı� ��� �Ⱓ�� �ʿ� ���� ���</b> - ������ ��ǥ �����ϰ� �ı��� ������/������, ����ı� ������/�������� ������ ���ڷ� �������ּ���.
							<br /> EX) ������ ��ǥ �������� 2024.01.01�̶�� �ı��� ������/������, ����ı� ��ǥ ������/�������� 2024.01.01�� �����ϰ� ����
					</span>
				</dl>
				<dl id="not_03" class="s1">
                    <span class="fz14" style="color:#B19D75" >* �ҹ����� �Ⱓ - ������ ��ǥ, �ı� ���, ����ı� ��ǥ �Ⱓ�� ��� ���� ���� �������ּ���.</span>
				</dl>
                <link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/anytime.5.1.2.css">
                <script src="<?=ADMIN_DEFAULT?>/js/anytime.5.1.2.js"></script>
                <script>
                    //��� ��¥���� ����
                    // $(function(){
                    //     for(var i=1;i<=5;i++){
                    //         jQuery("#sdate"+i).AnyTime_picker( {
                    //             format: "%Y-%m-%d %H:%i:00"
                    //         });
                    //         jQuery("#edate"+i).AnyTime_picker( {
                    //             format: "%Y-%m-%d %H:%i:00"
                    //         });
                    //     }
                    // });
                </script>
				<dl>
					<dt>
						<span class="bg1">��ʻ���1</span>
					</dt>
					<dd style="margin-top: 1.2rem;">
						<p style="color:#B19D75; margin-bottom:5px;">���̹� ��α� ��������� ����</p>
						<div class="ftc_word" style="display:none;">
							<label>����������</label>
							<input type="text" name="hero_ftc_naver" value="<?=$hero_ftc_naver?>" />
						</div>
						<textarea name="hero_banner" id="hero_banner" class="textarea dis-no" style="width: 550px; height: 150px;"><?=$hero_banner?></textarea>
                        <input type="file" name="bannerFile" id="bannerFile" />
                        <a href="javascript:;" onclick="bannerUpload()" class="btnSubmit"><span class="btn_up">���ε�</span> <span class="fz12">(�̹������� �ڵ����� ����˴ϴ�)</span></a>
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1" style="letter-spacing:-2px;">��ʻ���2</span>
					</dt>
					<dd style="margin-top: 1.2rem;">
						<p style="color:#B19D75; margin-bottom:5px;">�ν�Ÿ�׷� ������ ���� ����</p>
						<div class="ftc_word" style="display:none;">
							<label>����������</label>
							<input type="text" name="hero_ftc_insta" value="<?=$hero_ftc_insta?>" />
						</div>
						<textarea name="hero_insta" id="hero_insta" class="textarea" style="width: 550px; height: 150px;"><?=$hero_insta?></textarea>
						<input type="file" name="instaBannerFile" id="instaBannerFile" />
                        <a href="javascript:;" onclick="instaBannerUpload()" class="btnSubmit"><span class="btn_up">���ε�</span> <span class="fz12">(�̹������� �ڵ����� ����˴ϴ�)</span></a>
					</dd>
				</dl>
				<? if($_GET["board"] == "group_04_27") {?>
				<dl>
					<dt>
						<span class="bg1">��ʻ���3</span>
					</dt>
					<dd style="margin-top: 1.2rem;">
						<p style="color:#B19D75; margin-bottom:5px;">���� ä�� ������ ���� ����</p>
						<? if($_GET['action'] == "write") {?>
						<textarea name="hero_youtube" id="hero_youtube" class="textarea" style="width: 550px; height: 150px;">AK LOVER ��ǰ����</textarea>
						<? }else {?>
						<textarea name="hero_youtube" id="hero_youtube" class="textarea" style="width: 550px; height: 150px;"><?=$view_row['hero_youtube'];?></textarea>
						<? } ?>
						<input type="file" name="youtubeBannerFile" id="youtubeBannerFile" />
                        <a href="javascript:;" onclick="youtubeBannerUpload()" class="btnSubmit" style="background:#09F;padding:3px;color:#fff;line-height:40px;"/>���ε�</a>(�̹������� �ڵ����� ����˴ϴ�)
					</dd>
				</dl>
				<? } ?>

                <dl id="step_write_question_url" >
					<dt>
						<span class="bg1">URL ����</span>
					</dt>
                    <?
					$hero_question_url_list = explode("/////",$view_row['hero_question_url_list']);
					$url_list = array();
					foreach($hero_question_url_list as $key => $value) {
						$url_list["{$value}"] = $value;
					}
					?>
					<dd class="date_selec" style="margin-top: 1.2rem;">
						<div class="f_cs">
							<div class="input_radio"><input type="radio" name="hero_question_url_yn" id="hero_question_url_yn_Y" value="Y" <?=$view_row['hero_question_url_yn']=="Y" || !$view_row['hero_question_url_yn'] ? "checked":"";?>><label for="hero_question_url_yn_Y">���</label></div>
							<div class="input_radio"><input type="radio" name="hero_question_url_yn" id="hero_question_url_yn_N" value="N" <?=$view_row['hero_question_url_yn']=="N" ? "checked":"";?>><label for="hero_question_url_yn_N">�̻��</label></div>
						</div>
						<div class="">
							<div class="f_cs" style="margin-top: 1.2rem;">
								<div class="input_chk mgr20"><input type="checkbox" id="sns01" class="question_url_list" value='��α�' <?=$url_list['��α�']=='��α�'?'checked':''?>/><label class="input_chk_label" for="sns01">���̹� ��α� URL</label></div>
								<div class="input_chk mgr20"><input type="checkbox" id="sns02" class="question_url_list" value='�ν�Ÿ�׷�' <?=$url_list['�ν�Ÿ�׷�']=='�ν�Ÿ�׷�'?'checked':''?>/> <label class="input_chk_label" for="sns02">�ν�Ÿ�׷� URL</label></div>
								<div class="input_chk mgr20"><input type="checkbox" id="sns03" class="question_url_list" value='���� ä��' <?=$url_list['���� ä��']=='���� ä��'?'checked':''?>/> <label class="input_chk_label" for="sns03">���� ä�� URL</label></div>
							</div>
							<div class="f_cs" style="margin-top: 1.2rem;">
								<div class="input_chk mgr20"><input type="checkbox" id="sns04" class="question_url_list" value='���̽���' <?=$url_list['���̽���']=='���̽���'?'checked':''?>/> <label class="input_chk_label" for="sns04">���̽��� URL</label></div>
								<div class="input_chk mgr20"><input type="checkbox" id="sns05" class="question_url_list" value='Ʈ����' <?=$url_list['Ʈ����']=='Ʈ����'?'checked':''?>/><label class="input_chk_label" for="sns05"> Ʈ���� URL</label></div>
								<div class="input_chk mgr20"><input type="checkbox" id="sns06" class="question_url_list" value='īī�����丮' <?=$url_list['īī�����丮']=='īī�����丮'?'checked':''?>/><label class="input_chk_label" for="sns06"> īī�����丮 URL</label></div>
							</div>
							<p style="color:#B19D75; margin-top: 1.2rem;">����) ü��� ��û �� ������ URL �׸� ����</p>
                        </div>
                    </dd>
				</dl>
				<div style="clear:both;"></div>
				<dl>
					<dt>
						<span class="bg1">URL �ʼ� �Է� üũ</span>
					</dt>
					<dd style="margin-top: 1.2rem;">
						<div class="input_radio"><input type="radio" name="hero_question_url_check" id="hero_question_url_check_1" value="1" <?=$view_row["hero_question_url_check"]=="1" ? "checked":"";?>/><label for="hero_question_url_check_1">���̹� ��α�</label></div>
						<div class="input_radio"><input type="radio" name="hero_question_url_check" id="hero_question_url_check_2" value="2" <?=$view_row["hero_question_url_check"]=="2" ? "checked":"";?>/><label for="hero_question_url_check_2">�ν�Ÿ�׷�</label></div>
						<div class="input_radio" style="margin-bottom: 0.8rem;"><input type="radio" name="hero_question_url_check" id="hero_question_url_check_5" value="5" <?=$view_row["hero_question_url_check"]=="5" ? "checked":"";?>/><label for="hero_question_url_check_5">�ı�(����)</label></div><br/>

						<div class="input_radio"><input type="radio" name="hero_question_url_check" id="hero_question_url_check_3" value="3" <?=$view_row["hero_question_url_check"]=="3" ? "checked":"";?>/><label for="hero_question_url_check_3">���̹� ��α� or �ν�Ÿ�׷�</label></div>
						<div class="input_radio" style="margin-bottom: 0.8rem;"><input type="radio" name="hero_question_url_check" id="hero_question_url_check_4" value="4" <?=$view_row["hero_question_url_check"]=="4" ? "checked":"";?>/><label for="hero_question_url_check_4">���̹� ��α� and �ν�Ÿ�׷�</label></div><br/>
						<div class="input_radio" style="margin-bottom: 0.8rem;"><input type="radio" name="hero_question_url_check" id="hero_question_url_check_6" value="6" <?=$view_row["hero_question_url_check"]=="6" ? "checked":"";?>/><label for="hero_question_url_check_6">���̹� ��α� or �ν�Ÿ�׷� or �ı�(����)</label></div><br/>

						<div class="input_radio"><input type="radio" name="hero_question_url_check" id="hero_question_url_check_9" value="9" <?=$view_row["hero_question_url_check"]=="9" ? "checked":"";?>/><label for="hero_question_url_check_9">üũ ����</label></div>
						<p style="color:#B19D75; margin-top: 1.2rem;">����) ü��� ��û �� �ı� ��� �� �ʼ� �Է� ������ ����</p>
					</dd>
					<div style="clear:both;"></div>

				</dl>
				<dl>
					<dt>
						<span class="bg1">
							<? if($focus_group) {?>
								���̵���� <b class="fz12">(�ν�Ÿ�׷�)</b>
							<? } else { ?>
								���̵���� <b class="fz12">(�ν�Ÿ�׷�)</b>
							<? } ?>
						</span>
					</dt>
					<dd>
						<input type="file" name="guideFile" />(20MB ����)
						<? if($view_row["guide_ori_file"]) {?>
						<br/><div class="input_chk"><input type="checkbox" id="del1" name="delGuideFile" value="Y" /><label for="del1" class="input_chk_label"><?=$view_row["guide_ori_file"]?></label><span style="color:#F00; margin-top: .6rem; display: inline-block;">(���� �� üũ�� �ּ���)</span></div>
						<? } ?>
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1">
							<? if($focus_group) {?>
								���̵���� <b class="fz12">(��α�)</b>
							<? } else { ?>
								���̵���� <b class="fz12">(��α�)</b>
							<? } ?>
						</span>
					</dt>
					<dd>
						<input type="file" name="guideFile2" />(20MB ����) 
						<? if($view_row["guide_ori_file2"]) {?>
						<br/><div class="input_chk"><input type="checkbox" id="del2" name="delGuideFile2" value="Y" /><label for="del2" class="input_chk_label"><?=$view_row["guide_ori_file2"]?></label><span style="color:#F00; margin-top: .6rem; display: inline-block;">(���� �� üũ�� �ּ���)</span></div>
						<? } ?>
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1">
							<? if($focus_group) {?>
								���̵���� <b class="fz12">(��Ʃ��)</b>
							<? } else { ?>
								���̵���� <b class="fz12">(��Ʃ��)</b>
							<? } ?>
						</span>
					</dt>
					<dd>
						<input type="file" name="guideFile3" />(20MB ����) <?=$view_row["guide_ori_file3"]?>
						<? if($view_row["guide_ori_file3"]) {?>
						<br/><div class="input_chk"><input type="checkbox" id="del3" name="delGuideFile3" value="Y" /><label for="del3" class="input_chk_label"><?=$view_row["guide_ori_file3"]?></label><span style="color:#F00; margin-top: .6rem; display: inline-block;">(���� �� üũ�� �ּ���)</span></div>
						<? } ?>
					</dd>
				</dl>
				<div class="clearfix"></div>

				<div style="margin: 6rem 0 0;">
				<h2 class="fz20 bold" style="margin-bottom: 2rem;">ü��� �ı��� ����</h2>
				<dl>
					<dt>
						<span class="bg1">��ǰ�� ����</span>
					</dt>
					<dd style="margin-top: 1rem;">
						<div class="input_radio"><input type="radio" name="hero_product_review_yn" id="hero_product_review_yn_Y" value="Y" <?=$view_row['hero_product_review_yn']=="Y"?"checked":"";?>/><label for="hero_product_review_yn_Y">����</label></div>
						<div class="input_radio"><input type="radio" name="hero_product_review_yn" id="hero_product_review_yn_N" value="N" <?=($view_row['hero_product_review_yn']=="N" || !$view_row['hero_product_review_yn']) ? "checked":"";?>/><label for="hero_product_review_yn_N">�̳���</label></div>
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1">���������� Ȯ��</span>
					</dt>
					<dd style="margin-top: 1rem;">
						<div class="input_radio"><input type="radio" name="hero_ftc" id="hero_ftc_1" value="1"/><label for="hero_ftc_1">Ȯ��</label></div>
						<div class="input_radio"><input type="radio" name="hero_ftc" id="hero_ftc_0" value="0" <?=($view_row['hero_ftc']=="0" && strlen($view_row['hero_ftc']) > 0 || !$view_row['hero_ftc']) ? "checked":"";?>/><label for="hero_ftc_0">��Ȯ��</label></div>
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1">ü��� ��������</span>
					</dt>
					<dd style="margin-top: 1rem;">
						<div class="input_radio"><input type="radio" name="hero_use" id="hero_use_1" value="1" <?=$view_row['hero_use']!="0" &&  $view_row['hero_use']!="2"?"checked":"";?>/><label for="hero_use_1">����</label></div>
						<div class="input_radio"><input type="radio" name="hero_use" id="hero_use_0" value="0" <?=$view_row['hero_use']=="0"?"checked":"";?>/><label for="hero_use_0">�����</label></div>
					</dd>
				</dl>

			</div>
			<!--
            <div class="spm_img" style="text-align:center">
                <input type="file" id="hero_img_old" name="hero_img_old" style="width:350px; "/>
            </div>
-->
			<div class="btngroup" style="margin-top: 6rem;">
				<div class="btn_r f_sc">
					<? if($view_row["hero_idx"]) {?>
						<a href="javascript:;" onClick="fnPopSurvey('<?=$view_row["hero_idx"]?>');" class="btn_submit btn_white">�������� <?=$survey_rs["cnt"] > 0 ? "����":"�߰�"?></a>
					<? } ?>
					<? if(!strcmp($_GET['action'], 'update')){?>
                        <a href="<?=PATH_HOME.'?'.get('view||action','view=view');?>" class="btn_submit btn_white">����ϱ�</a>
					<? }else{?>
                        <a href="<?=PATH_HOME.'?'.get('view||action');?>" class="btn_submit btn_white">����ϱ�</a>
					<? }?>
                        <a href="javascript:;" onclick="javascript:return doSubmit(frm);" class="btn_submit btn_main_c">����ϱ�</a>
				</div>
			</div>
		</div>
	</div>
	</form>
</div>
</div>
</div>

<script>
	function bannerUpload() {
		var form = $('#form1')[0];
		var formData = new FormData(form);
		formData.append("bannerFile",$("#bannerFile")[0].files[0]);
		$.ajax({
			url: "/board/thumbnail_02/bannerUpload.php",
			type: "POST",
			data:  formData,
			contentType: false,
			cache: false,
			processData:false,
			success: function(data) {
				$("#hero_banner").val("<img src=\"http://<?=$_SERVER['HTTP_HOST'];?>/image2/banner/"+data+"\">");
			}

	    });


	}

	function instaBannerUpload() {
		var form = $('#form1')[0];
		var formData = new FormData(form);
		formData.append("instaBannerFile",$("#instaBannerFile")[0].files[0]);

		$.ajax({
			url: "/board/thumbnail_02/instaBannerUpload.php",
			type: "POST",
			data:  formData,
			contentType: false,
			cache: false,
			processData:false,
			success: function(data) {
				$("#hero_insta").val("<a href=\"http://aklover.co.kr\" target=\"_blank\"><img src=\"http://<?=$_SERVER['HTTP_HOST'];?>/image2/banner/"+data+"\"></a>");
			}

	    });
	}

	function youtubeBannerUpload() {
		var form = $('#form1')[0];
		var formData = new FormData(form);
		formData.append("instaBannerFile",$("#instaBannerFile")[0].files[0]);

		$.ajax({
			url: "/board/thumbnail_02/youtubeBannerUpload.php",
			type: "POST",
			data:  formData,
			contentType: false,
			cache: false,
			processData:false,
			success: function(data) {
				$("#hero_youtube").val("<a href=\"http://aklover.co.kr\" target=\"_blank\"><img src=\"http://<?=$_SERVER['HTTP_HOST'];?>/image2/banner/"+data+"\"></a>");
			}

	    });
	}

	function ch_count_text_kind(count,id){
		var ids = document.getElementById(id);
		if(count < ids.value.length){
			ids.value = ids.value.substring(0,count);
			alert(count+"���� ���Ϸ� �Է����ּ���.");
			ids.focus();
		}
	};
	function ch_count_text(count,id){
		var ids = document.getElementById(id);

		if(count<ids.value.length){
			ids.value = ids.value.substring(0,count);
			alert(count+"���� �̳��� �Է����ּ���.");
			ids.focus();
		}
	};
	function ch_number(id){
		var ids = document.getElementById(id);
		if(isNaN(ids.value)==true){
			ids.value="";
			alert("���ڸ� �Է��� �ּ���.");
			ids.focus();
		}
	};

</script>

<script type="text/javascript">
    function doSubmit (theform){
        myeditor.outputBodyHTML();

<? if($_GET['board'] =='group_04_05'){//ü���?>
		//20170502 �߰�
		// myeditor2.outputBodyHTML();
		myeditor3.outputBodyHTML();
<? } else if($focus_group){?>
		myeditor3.outputBodyHTML();
<? } ?>

		<? if($_GET['board'] =='group_04_27'){//����ä��?>
			if(!$("select[name='hero_movie_group']").val()) {
				alert("��û��� ����ä�� �׷��� ������ �ּ���.");
				return;
			}



			if(!$("select[name='hero_movie_gisu']").val() && $(":radio[name='hero_type']:checked").val() != "7") {
				alert("��û��� ����ä�� �׷��� ����� ������ �ּ���.");
				return;
			}

		<? } ?>

		var chk_length = $('.question_url_list:checkbox:checked').length;
		var url_list = "";
		var j = 1;
// 		if(chk_length == 0 && $(":radio[name=hero_type]:checked").val() != 1) {
// 			alert('�Է¹��� URL�� �������ּ���');
// 			return false;
// 		}

		$('.question_url_list').each(function() {
			if(this.checked){
				if(j == 1) url_list += this.value;
				else url_list += "/////"+this.value;

				j++;
			}
		});
		$("#hero_question_url_list").val(url_list);

		if(!$("input:radio[name='hero_question_url_check']").is(":checked")) {
			alert("URL �ʼ� �Է��� ������ �ּ���.");
			return false;
		}

        var title = theform.hero_title;
        var name = theform.hero_nick;
        var cmd = theform.command;

        theform.submit();
        return false;
    }

    function showImageInfo() {
        var data = myeditor.getImages();
        if (data == null) {
            alert('�ø� �̹����� �����ϴ�.');
            return;
        }
        for (var i=0; i<data.length; i++) {
            var str = 'URL: ' + data[i].fileUrl + "\n";
            str += '���� ���: ' + data[i].filePath + "\n";
            str += '���� �̸�: ' + data[i].origName + "\n";
            str += '���� �̸�: ' + data[i].fileName + "\n";
            str += 'ũ��: ' + data[i].fileSize;
            alert(str);
        }
    }

    </script>
<script type="text/javascript">
    var myeditor = new cheditor();
    myeditor.config.editorHeight = '300px';
    myeditor.config.editorWidth = '100%';
    myeditor.inputForm = 'editor';
    myeditor.run();

//20170502 �߰�
<? if($_GET['board'] =='group_04_05'){//ü���?>
	// var myeditor2 = new cheditor();
	// myeditor2.config.editorHeight = '150px';
    // myeditor2.config.editorWidth = '100%';
    // myeditor2.inputForm = 'editor2';
    // myeditor2.run();

    var myeditor3 = new cheditor();
	myeditor3.config.editorHeight = '300px';
    myeditor3.config.editorWidth = '100%';
    myeditor3.inputForm = 'editor3';
    myeditor3.run();
<? } ?>

<? if($focus_group) { ?>
	var myeditor3 = new cheditor();
	myeditor3.config.editorHeight = '300px';
	myeditor3.config.editorWidth = '100%';
	myeditor3.inputForm = 'editor3';
	myeditor3.run();
<? } ?>

<? if($view_row['hero_question_url_yn'] == "N") {?>
	$(".question_url_list").prop("checked",false);
	$(".question_url_list").attr("disabled",true);
<? } ?>

function missionText(hero_type, board) {
	var html = "";
	if(hero_type=="8") { //����Ʈ ü��
		html  = "- �� ü����� ���̵���� �� <strong>�ʼ� �̼��� �������ּž� �մϴ�.</strong><br/>";
		html += "<span style=color:red;>- �ش� ��ǰ ���� ��, Ȩ�������� ��ϵǴ� ���̵���ο� ���� �ı� �ۼ� ��Ź�帳�ϴ�.</span><br/>";
		html += "- ü��� ��û �� ��α� URL Ȯ�ε��� ���� ��� ������ ��ƽ��ϴ�.<br/>";
		html += "- �ı� ����� <span style=color:red;>�Ϲ� ü��ܰ� �����ϰ� ���̵���ο� ���� ���� ��α׿� �ı� 1�� �ۼ��� �ֽø� �˴ϴ�.</span><br/>";
		html += "- �귣�� ��û�� ���� �ο� �� ���� ������ ����� �� �ֽ��ϴ�.<br/>";
		html += "- �ڵ������ٴ� ī�޶�� ���� ������ Ȱ�����ּ���.<br/>";
		html += "- ����, 3���� �� ���� ������ ����� ����! ����� Ȯ�� �� ���Ƽ �ΰ� �� �� �ִ� �� ���� ��Ź�帳�ϴ�!<br/><br/>";
		html += "* �Ⱓ �� �ı� �� ��Ͻ� 1,000����Ʈ ������ �Բ� 3���� �� ü��� �������� ���ܵ˴ϴ�.<br/>";
		html += "- �ı� ��� �� [������ ���̵�] �� ��ʸ� �ݵ�� ������ �� �������ּ���";
	} else if(hero_type == "0" || hero_type == "9") {
		if(board == 'group_04_06') {
			html  = "<strong>[�̼�����]</strong><br/>";
            html += "<strong>���̼� ��ǰ:</strong> <br/>";
            html += "<strong>���̼� ��û ����:</strong><br/>";
            html += "<strong>���̼� ��ǰ �߼���:</strong> <br/>";
            html += "<strong>������ ���� �� Ȩ������ �� �ı���:</strong>  <br/>";
            html += "<span style=color:red;><strong>�� �̼� ���̵� �ǿ��� ���̵���� �ٿ�ε� �� ������ �ۼ� ��Ź�帳�ϴ�.</strong></span><br/>";
            html += "<strong>�� �Ⱓ �� ������ ���ε� �� Ȩ������ �ı��� �Ϸ� = ���� �̼� ����</strong><br/>";
            html += "<strong>�� ���� �̼� �����ڿ� ���Ͽ� AK LOVER ����Ʈ�� ���޵˴ϴ�.</strong><br/>";
            html += "* �ʼ� �̼� + �����̼� ����Ʈ ���� ���� ���̵���� ����<br/><br/>";
            html += "<strong>[�̼� ��û ��� ���]</strong><br/>";
            html += "<span style=color:red;>* ��û�� ������ ���� ��� ����, ��û�Ⱓ ���� ���� ��� �Ұ�</span><br/>";
            html += "�� ��û �Ϸ� �̼� ����<br/>";
            html += "�� �ϴ� [��û�� Ȯ��] ��ư Ŭ��<br/>";
            html += "�� [����] Ŭ�� > ��� �Ϸ�<br/><br/>";
            html += "<strong>[�̼� ���� ���ǻ���]</strong><br/>";
            html += "- �ȳ� �� �̼� ���� �Ⱓ�� �ݵ�� �������ּ���.<br/>";
            html += "- �������� \"�ı� ���\" �Ⱓ �� Ȩ�������� ������ּ���.<br/>";
            html += "* ��� ���: �ش� ������ \"�ı� ����ϱ�\" ��ư Ŭ�� �� �ȳ��� ���� ���<br/>";
            html += "- ���ε� �Ϸ� �� ������ URL�� Ȩ�������� ������� ���� ���<br/>";
            html += "�Ⱓ �� �̼� �̼������� ���ֵǸ� ������ ������ ��ƽ��ϴ�.<br/>";
            html += "- �������� ������ ���̵���� ���� �� �ۼ����ּ���.<br/>";
            html += "<span style=color:red;>* ���̵� �� �ȳ� �� ȭ��ǰ�� �� ǥ�ñ��� ����ȭ ���� ���� ���Ǻ�Ź�帳�ϴ�.</span><br/>";
            html += "<span style=color:red;>* ��Ȱȭ����ǰ ���� ǥ�á����� ���� ������ �����Ǿ����ϴ�.</span>( ��ũ���� )<br/>";
            html += "- �̼� ������ ����� ��ȯ �� ���� ����<br/>";
            html += "- �ۼ��� �������� ���� ������ �ڷ�� Ȱ��� �� �ֽ��ϴ�.<br/><br/>";
            html += "<strong>[���Ƽ �� ���� �ȳ�]</strong><br/><br/>";
            html += "- �̼� ������ 2ȸ �Ǵ� �Ⱓ �� �ı� �̵�� 5ȸ �̻��� �� Ȱ�� �Ұ�<br/>";
            html += "- Ȱ�� �Ϸ� ������ �� 1ȸ, Ȱ�� �Ⱓ �� �� 10ȸ �̻� ����̼� ���� �� ����<br/>";
            html += "* �̼� ���� �ִ� Ƚ���� ������ �����ϴ�.<br/>";
            html += "- Ȱ�� �ȳ��ڷ� Ȯ���ϱ�: <br/><br/>";
            html += "<strong>[����]</strong><br/>";
            html += "- ��ǰ����: 080-024-1357(�����ںδ�) �ְ� ����������<br/>";
            html += "- �̼ǹ���: īī���� �÷��� ģ�� <��ƼŬ��> 1:1 ��ȭ<br/>";
		} else if(board == 'group_04_28') {
			html  = "<strong>[�̼�����]</strong><br/>";
			html += "<strong>���̼� ��ǰ: </strong><br/>";
            html += "<strong>���̼� ��û ����: </strong><br/>";
            html += "<strong>���̼� ��ǰ �߼���: </strong><br/>";
            html += "<strong>������ ���� �� Ȩ������ �� �ı���: </strong><br/>";
            html += "<span style=color:red;><strong>�� �̼� ���̵� �ǿ��� ���̵���� �ٿ�ε� �� ������ �ۼ� ��Ź�帳�ϴ�.</strong></span><br/>";
            html += "<strong>�� �Ⱓ �� ������ ���ε� �� Ȩ������ �ı��� �Ϸ� = ���� �̼� ����</strong><br/>";
            html += "<strong>�� ���� �̼� �����ڿ� ���Ͽ� AK LOVER ����Ʈ�� ���޵˴ϴ�.</strong><br/>";
            html += "* �ʼ� �̼� + �����̼� ����Ʈ ���� ���� ���̵���� ����<br/><br/>";
            html += "<strong>[�̼� ��û ��� ���]</strong><br/>";
            html += "<span style=color:red;>* ��û�� ������ ���� ��� ����, ��û�Ⱓ ���� ���� ��� �Ұ�</span><br/>";
            html += "�� ��û �Ϸ� �̼� ����<br/>";
            html += "�� �ϴ� [��û�� Ȯ��] ��ư Ŭ��<br/>";
            html += "�� [����] Ŭ�� > ��� �Ϸ�<br/><br/>";
            html += "<strong>[�̼� ���� ���ǻ���]</strong><br/>";
            html += "- �ȳ� �� �̼� ���� �Ⱓ�� �ݵ�� �������ּ���.<br/>";
            html += "- �������� \"�ı� ���\" �Ⱓ �� Ȩ�������� ������ּ���.<br/>";
            html += "* ��� ���: �ش� ������ \"�ı� ����ϱ�\" ��ư Ŭ�� �� �ȳ��� ���� ���<br/>";
            html += " - ���ε� �Ϸ� �� ������ URL�� Ȩ�������� ������� ���� ���<br/>";
            html += "�Ⱓ �� �̼� �̼������� ���ֵǸ� ������ ������ ��ƽ��ϴ�.<br/>";
            html += "- �������� ������ ���̵���� ���� �� �ۼ����ּ���.<br/>";
            html += "<span style=color:red;>* ���̵� �� �ȳ� �� ȭ��ǰ�� �� ǥ�ñ��� ����ȭ ���� ���� ���Ǻ�Ź�帳�ϴ�.</span><br/>";
            html += "<span style=color:red;>* ��Ȱȭ����ǰ ���� ǥ�á����� ���� ������ �����Ǿ����ϴ�.</span> ( ��ũ���� )<br/>";
            html += "- �̼� ������ ����� ��ȯ �� ���� ����<br/>";
            html += "- �ۼ��� �������� ���� ������ �ڷ�� Ȱ��� �� �ֽ��ϴ�.<br/><br/>";
            html += "<strong>[���Ƽ �� ���� �ȳ�]</strong><br/>";
            html += "- �̼� ������ 2ȸ �Ǵ� �Ⱓ �� �ı� �̵�� 5ȸ �̻��� �� Ȱ�� �Ұ�<br/>";
            html += "- Ȱ�� �Ϸ� ������ �� 1ȸ, Ȱ�� �Ⱓ �� �� 10ȸ �̻� ����̼� ���� �� ����<br/>";
            html += "* �̼� ���� �ִ� Ƚ���� ������ �����ϴ�.<br/>";
            html += "- Ȱ�� �ȳ��ڷ� Ȯ���ϱ�:<br/><br/>";
            html += "<strong>[����]</strong><br/>";
            html += "- ��ǰ����: 080-024-1357(�����ںδ�) �ְ� ����������<br/>";
            html += "- �̼ǹ���: īī���� �÷��� ģ�� <������Ŭ��> 1:1 ��ȭ<br/>";
		}
	} else {
		html = "- �� ü����� <span style=color:red;>��α� 1�� + �ν�Ÿ�׷� 1�� �� 2�� �ʼ�</span>�Դϴ�.<br/>";
		html += "- ü��� ��û �� ��α� URL �� �ν�Ÿ�׷� URL�� Ȯ�ε��� ���� ���<br/>&nbsp; �����н��� ����ϴ��� ������ �������� ���ܵǸ� ��� ��� �� �����н��� ��߱� ���� �ʽ��ϴ�.<br/>";
		html += "- ��� ����Ʈ ���� ��, ü��� ���� �������� �����Ǵ� ��ǰ ��۷�� ���� �δ��Դϴ�.<br/>";
		html += "- �귣�� ��û�� ���� �ο� �� ��������, ����� ������ ����� ���� �ֽ��ϴ�.<br/>";
		html += "- �ڵ������ٴ� ī�޶�� ���� ������ Ȱ�����ּ���.<br/>";
		html += "- <span style=color:red;>����, 3���� �� ���� ������ ����� ����! ����� Ȯ�� �� ���Ƽ �ΰ� �� �� �ִ� �� ���� ��Ź�帳�ϴ�!</span><br/><br/>";
		html += "<span style=color:red;>* �Ⱓ �� �ı� �� ��Ͻ� 1,000����Ʈ ������ �Բ� 3���� �� ü��� �������� ���ܵ˴ϴ�.</span><br/>";
		html += "- �ı� ��� �� [������ ���̵�] �� ��ʸ� �ݵ�� ������ �� �������ּ���.";
	}

	myeditor3.replaceContents(html);

}
</script>

<script>
$(function() {
	$("input[name='hero_question_url_yn']").on("click",function(){
		if($(this).val() == "N") {
			$(".question_url_list").prop("checked",false);
			$(".question_url_list").attr("disabled",true);
		} else {
			$(".question_url_list").attr("disabled",false);
		}
	})

    //��¥���� ���Ϸ� �ּ�
    dateclick1(); //ü��� ����
    dateclick2(); //ü��� ��û
    dateclick3(); //������ ��ǥ
    dateclick4(); //�ı���
    dateclick5(); //����ı� ��ǥ

    <? if($focus_group && $view_row["hero_type"] == "7") { //�����̼�?>
    	$("#sdate2, #edate2, #sdate3, #edate3, #sdate4, #edate4, #not_01, #not_02, #not_03, #not_04").show();
 	  	$("#txt_change").html("ü��� ��û");
 	  	if($_GET["board"] == "group_04_06") {
 	  		$("select[name='hero_beauty_gisu']").val("");
 	    	$("select[name='hero_beauty_gisu']").hide();
 	  	} else if($_GET["board"] == "group_04_27") {
 	  		$("select[name='hero_youtube_gisu']").val("");
 	    	$("select[name='hero_youtube_gisu']").hide();
 	  	} else if($_GET["board"] == "group_04_28") {
 	  		$("select[name='hero_life_gisu']").val("");
 	     	$("select[name='hero_life_gisu']").hide();
 	  	}
    <? } ?>
    <? if($focus_group && $view_row["hero_type"] == "9") { //����̼� ����?>
    	$("#sdate2, #edate2, #sdate3, #edate3, #sdate4, #edate4, #not_01, #not_02, #not_03, #not_04").show();
 	  	$("#txt_change").html("ü��� ��û");
    <? } ?>
});
//ü��� ����
function dateclick1(){
    var dates = jQuery("#sdate5, #edate5").datepicker({
        monthNames: ['�� 1��','�� 2��','�� 3��','�� 4��','�� 5��','�� 6��','�� 7��','�� 8��','�� 9��','�� 10��','�� 11��','�� 12��'],
        dayNamesMin: ['��', '��', 'ȭ', '��', '��', '��', '��'],
        defaultDate: null,
        showMonthAfterYear:true,
        dateFormat: 'yy-mm-dd',
        onSelect: function( selectedDate ) {
            var option = this.id == "sdate5" ? "minDate" : "maxDate",
            instance = jQuery( this ).data( "datepicker" ),
            date = jQuery.datepicker.parseDate(
                instance.settings.dateFormat ||
                jQuery.datepicker._defaults.dateFormat,
                selectedDate, instance.settings );
            
            //Ŭ���ϰ��� �ٸ� ��¥�� ������� �̸� ����
            var sdate = $("#sdate5").val();
            var edate = $("#edate5").val();

            dates.not( this ).datepicker( "option", option, date );

            //��¥ �����ϸ� �������ְ� �ٸ� ��¥�� �ٽ� �־���
            if(this.id == "sdate5"){
                this.value += " 00:00:00";
                $("#edate5").val(edate);
            }else {
                this.value += " 23:59:59";
                $("#sdate5").val(sdate);
            }
        }
    });
};
//ü��� ��û
function dateclick2(){
    var dates = jQuery("#sdate1, #edate1").datepicker({
        monthNames: ['�� 1��','�� 2��','�� 3��','�� 4��','�� 5��','�� 6��','�� 7��','�� 8��','�� 9��','�� 10��','�� 11��','�� 12��'],
        dayNamesMin: ['��', '��', 'ȭ', '��', '��', '��', '��'],
        defaultDate: null,
        showMonthAfterYear:true,
        dateFormat: 'yy-mm-dd',
        onSelect: function( selectedDate ) {
            var option = this.id == "sdate1" ? "minDate" : "maxDate",
            instance = jQuery( this ).data( "datepicker" ),
            date = jQuery.datepicker.parseDate(
                instance.settings.dateFormat ||
                jQuery.datepicker._defaults.dateFormat,
                selectedDate, instance.settings );

            //Ŭ���ϰ��� �ٸ� ��¥�� ������� �̸� ����
            var sdate = $("#sdate1").val();
            var edate = $("#edate1").val();

            dates.not( this ).datepicker( "option", option, date );

            //��¥ �����ϸ� �������ְ� �ٸ� ��¥�� �ٽ� �־���
            if(this.id == "sdate1"){
                this.value += " 00:00:00";
                $("#edate1").val(edate);
            }else {
                this.value += " 23:59:59";
                $("#sdate1").val(sdate);
            }
        }
    });
};
//������ ��ǥ
function dateclick3(){
    var dates = jQuery("#sdate2, #edate2").datepicker({
        monthNames: ['�� 1��','�� 2��','�� 3��','�� 4��','�� 5��','�� 6��','�� 7��','�� 8��','�� 9��','�� 10��','�� 11��','�� 12��'],
        dayNamesMin: ['��', '��', 'ȭ', '��', '��', '��', '��'],
        defaultDate: null,
        showMonthAfterYear:true,
        dateFormat: 'yy-mm-dd',
        onSelect: function( selectedDate ) {
            var option = this.id == "sdate2" ? "minDate" : "maxDate",
            instance = jQuery( this ).data( "datepicker" ),
            date = jQuery.datepicker.parseDate(
                instance.settings.dateFormat ||
                jQuery.datepicker._defaults.dateFormat,
                selectedDate, instance.settings );

            //Ŭ���ϰ��� �ٸ� ��¥�� ������� �̸� ����
            var sdate = $("#sdate2").val();
            var edate = $("#edate2").val();

            dates.not( this ).datepicker( "option", option, date );

            //��¥ �����ϸ� �������ְ� �ٸ� ��¥�� �ٽ� �־���
            if(this.id == "sdate2"){
                this.value += " 00:00:00";
                $("#edate2").val(edate);
            }else {
                this.value += " 23:59:59";
                $("#sdate2").val(sdate);
            }
        }
    });
};
//�ı���
function dateclick4(){
    var dates = jQuery("#sdate3, #edate3").datepicker({
        monthNames: ['�� 1��','�� 2��','�� 3��','�� 4��','�� 5��','�� 6��','�� 7��','�� 8��','�� 9��','�� 10��','�� 11��','�� 12��'],
        dayNamesMin: ['��', '��', 'ȭ', '��', '��', '��', '��'],
        defaultDate: null,
        showMonthAfterYear:true,
        dateFormat: 'yy-mm-dd',
        onSelect: function( selectedDate ) {
            var option = this.id == "sdate3" ? "minDate" : "maxDate",
            instance = jQuery( this ).data( "datepicker" ),
            date = jQuery.datepicker.parseDate(
                instance.settings.dateFormat ||
                jQuery.datepicker._defaults.dateFormat,
                selectedDate, instance.settings );

            //Ŭ���ϰ��� �ٸ� ��¥�� ������� �̸� ����
            var sdate = $("#sdate3").val();
            var edate = $("#edate3").val();

           dates.not( this ).datepicker( "option", option, date );

            //��¥ �����ϸ� �������ְ� �ٸ� ��¥�� �ٽ� �־���
            if(this.id == "sdate3"){
                this.value += " 00:00:00";
                $("#edate3").val(edate);
            }else {
                this.value += " 23:59:59";
                $("#sdate3").val(sdate);
            }
        }
    });
};
//����ı� ��ǥ
function dateclick5(){
    var dates = jQuery("#sdate4, #edate4").datepicker({
        monthNames: ['�� 1��','�� 2��','�� 3��','�� 4��','�� 5��','�� 6��','�� 7��','�� 8��','�� 9��','�� 10��','�� 11��','�� 12��'],
        dayNamesMin: ['��', '��', 'ȭ', '��', '��', '��', '��'],
        defaultDate: null,
        showMonthAfterYear:true,
        dateFormat: 'yy-mm-dd',
        onSelect: function( selectedDate ) {
            var option = this.id == "sdate4" ? "minDate" : "maxDate",
                instance = jQuery( this ).data( "datepicker" ),
                date = jQuery.datepicker.parseDate(
                    instance.settings.dateFormat ||
                    jQuery.datepicker._defaults.dateFormat,
                    selectedDate, instance.settings );

            //Ŭ���ϰ��� �ٸ� ��¥�� ������� �̸� ����
            var sdate = $("#sdate4").val();
            var edate = $("#edate4").val();

            dates.not( this ).datepicker( "option", option, date );

            //��¥ �����ϸ� �������ְ� �ٸ� ��¥�� �ٽ� �־���
            if(this.id == "sdate4"){
                this.value += " 00:00:00";
                $("#edate4").val(edate);
            }else {
                this.value += " 23:59:59";
                $("#sdate4").val(sdate);
            }
        }
    });
};

function fnPopSurvey(mission_idx){
	var popSurvey = window.open('/main/popSurvey.php?mission_idx='+mission_idx,'popSurvey','width=930, height=500, scrollbars=yes');
	popSurvey.focus();
}

function selMovieGisu(val, selectedVal) {
	if(val) {
		var attrSelected = "";
		var param = "hero_movie_group="+val;
		$.ajax({
				url:"/main/selMovieGisu.php",
				type:"GET",
				data:param,
				dataType:"html",
				success:function(d){
					_hero_movie_gisu = $("select[name='hero_movie_gisu']");
					_hero_movie_gisu.empty();
					_hero_movie_gisu.append("<option value=''>��� ����</option>");

					var start_gisu = "";
					if(val=="group_04_27") {
						start_gisu = 10;
					} else if(val=="group_04_31") {
						start_gisu = 3;
					}

				 	for(var i=d; i>=start_gisu; i--) {
					 	if(selectedVal) {
						 	if(i==selectedVal) attrSelected = "selected";
					 		_hero_movie_gisu.append("<option value='"+i+"' "+attrSelected+">"+i+"���</option>");
				 		} else {
				 			if(i==d) attrSelected = "selected";
					 		_hero_movie_gisu.append("<option value='"+i+"' "+attrSelected+">"+i+"���</option>");
				 		}
				 		attrSelected = "";
					}
				},error:function(e){
					console.log(e);
					alert("������ �߻��߽��ϴ�.\n�ٽ� �̿��� �ּ���.");
				}
			})
	}
}

<? if($_GET["idx"]) {?>
	selMovieGisu('<?=$view_row["hero_movie_group"]?>',<?=$view_row["hero_movie_gisu"]?>)
<? } ?>
</script>