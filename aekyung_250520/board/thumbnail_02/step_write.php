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

//미션 설문조사 등록여부
if($_GET ['idx']) {
	$survey_sql = " SELECT count(*) cnt FROM mission_survey WHERE mission_idx = '".$_GET ['idx']."' ";
	$survey_res = sql($survey_sql);
	$survey_rs = mysql_fetch_assoc($survey_res);
}

$focus_group = false;

//기수 선택
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
$hero_banner = ""; //네이버 공정위문구 설명
$hero_ftc_insta = "";
$hero_insta = ""; //인스타공정위문구 설명
if($_GET["action"] == "write") {
	$hero_banner = '<a href="http://www.aklover.co.kr" target="_blank"><img src="http://www.aklover.co.kr/image2/banner_04_05.jpg"></a>';
	$hero_insta = "AK LOVER 제품지원\n";
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
			alert("키워드를 입력해 주세요.");
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

	<? if($focus_group) { //자율미션?>
		$("input[name='hero_type']").on("click",function() {
			if($(this).val() == "7") {
				$("#sdate2, #edate2, #sdate3, #edate3, #sdate4, #edate4, #not_01, #not_02, #not_03, #not_04").show();
				$("#txt_change").html("체험단 신청");
				if(confirm("리본텍스트 [자율미션]으로 입력됩니다.")) {
					$("#hero_kind").val("자율미션");
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
				$("#txt_change").html("체험단 신청");
				if(confirm("리본텍스트 [정기미션]으로 입력됩니다.")) {
					$("#hero_kind").val("정기미션");
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
				$("#txt_change").html("후기 등록");
				if(confirm("리본텍스트 [정기미션]으로 입력됩니다.")) {
					$("#hero_kind").val("정기미션");
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
			<h2 class="fz15 fw600 main_c">프리미어 뷰티 클럽</h2>
		<? } else if($_GET['board'] == "group_04_28") {?>
			<h2 class="fz15 fw600 main_c">프리미어 라이프 클럽</h2>
		<? } else if($_GET['board'] == "group_04_05") { ?>
			<h2 class="fz15 fw600 main_c">베이직 뷰티&라이프 클럽</h2>
		<? } ?>
	</div>
	<div><img src="/image/bbs/guide_thumb.gif"/></div>
		<div style="background:#F2F2F2;margin-bottom:10px;">
			<div id="thumbnailView" style="width:680px;height:105px;overflow-x:hidden;overflow-y:scroll;"></div>
		</div>
		<script type="text/javascript" src="/loak/loak.js?v=1"></script>
		<form name="frm" id="form1" method="post" action="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&view=action_write&action=<?=$_GET['action']?>&idx=<?=$_GET['idx'];?>&page=<?=$_GET['page'];?>" enctype="multipart/form-data">
        	<span style="color:#F00">사진업로드 최대사이즈 : 730px(사진이 730px일 경우 정렬 사용불가능합니다)</span>
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
						<span class="bg1">체험단 타입</span>
					</dt>
					<dd class="line2">
						<? if($focus_group) {?>
							<div class="f_fs">
								<div class="input_radio mgr20">
									<input type="radio" id="type01" name="hero_type" value="0" <? echo ($view_row['hero_type']==0)? "checked='checked'" : "" ;?>/>
									<label for="type01" class="">정기미션</label>
								</div>
								<div class="input_radio mgr20">
									<input type="radio" id="type02" name="hero_type" value="9" <? echo ($view_row['hero_type']==9)? "checked='checked'" : "" ;?>/>
									<label for="type02" class="">정기미션(선택)</label>
								</div>
								<div class="input_radio mgr20">
									<input type="radio" id="type03" name="hero_type" value="7" <? echo ($view_row['hero_type']==7)? "checked='checked'" : "" ;?>/>
									<label for="type03" class="">자율미션</label>
								</div>
							</div>
						<? } else { ?>
							<div class="f_fs">
								<div class="input_radio mgr20">
									<input type="radio" id="type04" name="hero_type" value="0" <? echo ($view_row['hero_type']==0)? "checked='checked'" : "" ;?>/>
									<label for="type04" class="">일반미션</label>
								</div>
								<div class="input_radio mgr20">
									<input type="radio" id="type05" name="hero_type" value="10" <? echo ($view_row['hero_type']==10)? "checked='checked'" : "" ;?>/>
									<label for="type05" class="">체험단</label>
								</div>
							</div>
						<? } ?>
						<div class="f_fs">
							<div class="input_radio mgr20">
								<input type="radio" id="type06" name="hero_type" value="1" <? echo ($view_row['hero_type']==1)? "checked='checked'" : "" ;?>/>
								<label for="type06" class="">이벤트</label>
													</div>
							<div class="input_radio mgr20">
								<input type="radio" id="type07" name="hero_type" value="2" <? echo ($view_row['hero_type']==2)? "checked='checked'" : "" ;?>/>
								<label for="type07" class="">소문내기</label><br/>
													</div>
							<div class="input_radio mgr20">
								<input type="radio" id="type08" name="hero_type" value="3" <? echo ($view_row['hero_type']==3)? "checked='checked'" : "" ;?>/>
								<label for="type08" class="">설문조사</label>
													</div>
							<div class="input_radio mgr20">
								<input type="radio" id="type09" name="hero_type" value="8" <? echo ($view_row['hero_type']==8)? "checked='checked'" : "" ;?>/>
								<label for="type09" class="">포인트체험</label>
													</div>
							<div class="input_radio mgr20">
								<input type="radio" id="type10" name="hero_type" value="5" <? echo ($view_row['hero_type']==5)? "checked='checked'" : "" ;?>/>
								<label for="type10" class="">제품품평</label>
							</div>
						</div>
					</dd>
				</dl>
                        <script>
						var appendText = "<dl class='d2'><dt>";
						appendText += "<span class='bg1'>우수자 선정</span></dt>";
						appendText += "<dd><input type='text' id='hero_select_best' placeholder='숫자만 입력해주세요.'onkeydown=\"ch_number('hero_select_best')\" onblur=\"ch_number('hero_select_best')\"";
						appendText += "name='hero_select_best' value='<?=$view_row['hero_select_best']?>' style='width:550px; height: 23px;'/>";
						appendText += "</dd></dl>";

						var appendBlank = "";

						$(document).ready(function() {

							if($(':radio[name="hero_type"]:checked').val() == 2 || $(':radio[name="hero_type"]:checked').val() == 10) {
								var txt1 = "";
								if($(':radio[name="hero_type"]:checked').val() == "2") {
									txt1 = "소문내기";
								} else if($(':radio[name="hero_type"]:checked').val() == "10") {
									txt1 = "체험단";
								}

								$('.d2').remove();
								$('.d1').children().children().text(txt1+" 혜택");
								$('.d3').text(txt1+' 참여');
								$('.d4').text('참여 시 질문');
								$('.d5').text('참여 시 공지사항');
								$('.d1').after(appendText);
								$('.s1').css('display','block');
								$('.s2').css('display','none');
							} else {
								$('.d1').children().children().text('선정혜택');
								$('.d3').text('체험단 신청');
								$('.d4').text('신청 시 질문');
								$('.d5').text('신청 시 공지사항');
								$('.d2').remove();
								$('.s1').css('display','none');
								$('.s2').css('display','block');
							}

							$("input:radio[name=hero_type]").click(function() {

								var mission_text  = "- 본 체험단은 <span style=color:red;>블로그 1건 + 인스타그램 1건 총 2건 필수</span>입니다.<br/>";
									mission_text += "- 체험단 신청 시 블로그 URL 및 인스타그램 URL이 확인되지 않을 경우<br/>&nbsp; 슈퍼패스를 사용하더라도 선정자 선정에서 제외되며 사용 취소 된 슈퍼패스는 재발급 되지 않습니다.<br/>";
									mission_text += "- 배송 포인트 차감 외, 체험단 참여 혜택으로 제공되는 제품 배송료는 본인 부담입니다.<br/>";
									mission_text += "- 브랜드 요청에 따라서 인원 및 선정혜택, 우수자 혜택이 변경될 수도 있습니다.<br/>";
									mission_text += "- 핸드폰보다는 카메라로 찍은 사진을 활용해주세요.<br/>";
									mission_text += "- <span style=color:red;>또한, 3개월 내 리뷰 포스팅 비공개 금지! 비공개 확인 시 페널티 부과 될 수 있는 점 참고 부탁드립니다!</span><br/><br/>";
									mission_text += "<span style=color:red;>* 기간 내 후기 미 등록시 1,000포인트 차감과 함께 3개월 간 체험단 선정에서 제외됩니다.</span><br/>";
									mission_text += "- 후기 등록 시 [콘텐츠 가이드] 내 배너를 반드시 콘텐츠 내 삽입해주세요.";

								var hero_banner_txt = "<a href=\"http://www.aklover.co.kr\" target=\"_blank\"><img src=\"http://www.aklover.co.kr/image2/banner_04_05.jpg\"></a>";
								var hero_insta_txt = "AK LOVER 제품지원";

								if($(this).val() == 2 || $(this).val() == 10) {
									var txt1 = "";
									if($(this).val() == "2") {
										txt1 = "소문내기";
									} else if($(this).val() == "10") {
										txt1 = "체험단";
									}

									$('.d2').remove();

									$('.d1').children().children().text(txt1+" 혜택");
									$('.d3').text(txt1+' 참여');
									$('.d4').text('참여 시 질문');
									$('.d5').text('참여 시 공지사항');
									$('.d1').after(appendText);
									$('.s1').css('display','block');
									$('.s2').css('display','none');

									$("#hero_banner").val(hero_banner_txt);
									$("#hero_insta").val(hero_insta_txt);
								} else if($(this).val() == 8) {
									hero_banner_txt = "<a href=\"http://www.aklover.co.kr\" target=\"_blank\"><img src=\"http://www.aklover.co.kr/image2/banner_point_04_05.jpg\"></a>";
									hero_insta_txt = "AK LOVER 상품권 및 혜택 지급";

									$("#hero_banner").val(hero_banner_txt);
									$("#hero_insta").val(hero_insta_txt);

								} else {
									$('.d1').children().children().text('선정혜택');
									$('.d3').text('체험단 신청');
									$('.d4').text('신청 시 질문');
									$('.d5').text('신청 시 공지사항');
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
						<span class="bg1">슈퍼패스 여부</span>
					</dt>
					<dd>
						<div class="input_radio"><input type="radio" id="use1" name="hero_superpass" value="Y" <? echo ($view_row['hero_superpass']=='Y')? "checked='checked'" : "" ;?>/> <label for="use1">사용</label></div>
						<div class="input_radio"><input type="radio" id="use2" name="hero_superpass" value="N" <? echo ($view_row['hero_superpass']=='N')? "checked='checked'" : "" ;?>/> <label for="use2">미사용</label></div>
					</dd>
				</dl>
				 <dl>
					<dt>
						<span class="bg1">배송 POINT차감</span>
					</dt>
					<dd>
						<div class="input_radio"><input type="radio" id="use3" name="delivery_point_yn" value='Y' <?=$view_row['delivery_point_yn']=='Y'?'checked':''?>/> <label for="use3">사용</label></div>
						<div class="input_radio"><input type="radio" id="use4" name="delivery_point_yn" value='N' <?=($view_row['delivery_point_yn']=='N' || $view_row['delivery_point_yn']=='')?'checked':''?>/> <label for="use4">사용 안함</label></div>
                    </dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1"><span style="cursor: pointer;" onclick="Javascript:showImageInfo();">제목</span></span>
					</dt>
					<dd>
						<input type="text" id="hero_title" name="hero_title" value="<?=$view_row['hero_title']?>" placeholder="제목을 입력하세요."
						/>
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1"><span>부제</span></span>
					</dt>
					<dd style="padding-top: 1rem;">
						<textarea id="hero_title_02" name="hero_title_02"><?=$view_row['hero_title_02']?></textarea>
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1"><span>리본 텍스트</span></span>
					</dt>
					<dd>
						<input type="text" id="hero_kind" placeholder='6 글자이하로 입력해주시기 바랍니다.'
							name="hero_kind" value="<?=$view_row['hero_kind']?>" onblur="ch_count_text_kind(6,'hero_kind');"/>
					</dd>
				</dl>

				<dl>
					<dt>
						<span class="bg1"><span>신청대상</span></span>
					</dt>
					<dd>
						<input type="text" id="hero_target" placeholder='28 글자 이내로 입력해주시기 바랍니다.'
						onkeydown="ch_count_text(28,'hero_target');" onblur="ch_count_text(28,'hero_target');"
							name="hero_target" value="<?=$view_row['hero_target']?>" <?php if($_GET['board'] =='group_04_07'){//애경박스 ?>background-color:#F0F0F0;<?php } ?>" />

						<? if($_GET['board'] == "group_04_06") {?>
							<select name="hero_beauty_gisu" style="padding:5px;">
								<option value="">뷰티클럽 기수 선택</option>
								<? for($z=$rs_gisu["hero_beauty_gisu"] ; $z >= 1; $z--) {?>
								<option value="<?=$z?>" <?=$z==$rs_gisu_select ? "selected":"";?>>뷰티클럽 <?=$z?>기</option>
								<? } ?>
							</select>
						<? } else if($_GET['board'] == "group_04_27") {?>
							<div style="margin-top:5px;">
								<select name="hero_movie_group" style="padding:5px;" onChange="selMovieGisu(this.value,'<?=$rs_gisu_select;?>')">
									<option value="">영상채널 그룹</option>
									<option value="group_04_27" <?=$view_row["hero_movie_group"]=="group_04_27" ? "selected":"";?>>Beauty 영상</option>
									<option value="group_04_31" <?=$view_row["hero_movie_group"]=="group_04_31" ? "selected":"";?>>Life 영상</option>
								</select>
								<select name="hero_movie_gisu" style="padding:5px;">
									<option value="0" selected>기수 선택</option>
								</select>
							</div>
						<? } else if($_GET['board'] == "group_04_28") { ?>
							<select name="hero_life_gisu" style="padding:5px;">
								<option value="">라이프 기수 선택</option>
								<? for($z=$rs_gisu["hero_life_gisu"]; $z >= 1; $z--) { ?>
								<option value="<?=$z?>" <?=$z==$rs_gisu_select ? "selected":"";?>>라이프클럽 <?=$z;?>기</option>
								<? } ?>
							</select>
						<? } ?>


					</dd>
				</dl>
				<dl>

					<dt>
						<span class="bg1">선정인원</span>
					</dt>
					<dd>
						<input type="text" id="hero_select_count" placeholder='숫자만 입력해주세요.'
						onkeydown="ch_number('hero_select_count');" onblur="ch_number('hero_select_count');"
							name="hero_select_count" value="<?=$view_row['hero_select_count']?>"/>
					</dd>
				</dl>

				<dl class="d1">
					<dt>
						<span class="bg1">선정혜택</span>
					</dt>
					<dd>
						<input type="text" id="hero_benefit" placeholder='28 글자 이내로 입력해주시기 바랍니다.'
						onkeydown="ch_count_text(28,'hero_benefit');" onblur="ch_count_text(28,'hero_benefit');"
							name="hero_benefit" value="<?=$view_row['hero_benefit']?>"
							style="width: 550px; height: 23px;<?php if($_GET['board'] =='group_04_07'){//애경박스 ?>background-color:#F0F0F0;<?php } ?>" />
					</dd>
				</dl>
                <dl>
					<dt>
						<span class="bg1">우수자 혜택</span>
					</dt>
					<dd>
						<input type="text" id="hero_benefit_02" placeholder='28 글자 이내로 입력해주시기 바랍니다.'
						onkeydown="ch_count_text(28,'hero_benefit_02');" onblur="ch_count_text(28,'hero_benefit_02');"
							name="hero_benefit_02" value="<?=$view_row['hero_benefit_02']?>"/>
					</dd>
				</dl>
                <dl>
					<dt>
						<span class="bg1">체험단 안내</span>
					</dt>
					<dd class="no-top">
					<?php if($view_row['hero_guide']){?>
						<textarea name="hero_guide" id="editor3" class="textarea" style="width:600px; height: 150px;"><?=htmlspecialchars_decode($view_row['hero_guide']);?></textarea>
	                <?php }else{
	                    if($_GET["board"] == "group_04_06") {
	                        $mission_text = "<strong>[미션일정]</strong><br/>
                            <strong>▶미션 제품:</strong> <br/>
                            <strong>▶미션 신청 마감:</strong><br/> 
                            <strong>▶미션 제품 발송일:</strong> <br/>
                            <strong>▶원고 오픈 및 홈페이지 내 후기등록:</strong>  <br/>
                            <span style=color:red;><strong>※ 미션 가이드 탭에서 가이드라인 다운로드 후 컨텐츠 작성 부탁드립니다.</strong></span><br/>
                            <strong>※ 기간 내 컨텐츠 업로드 및 홈페이지 후기등록 완료 = 정상 미션 참여</strong><br/>
                            <strong>※ 정상 미션 참여자에 한하여 AK LOVER 포인트가 지급됩니다.</strong><br/>
                               * 필수 미션 + 자율미션 포인트 지급 기준 가이드라인 참고<br/><br/>
                             
                            <strong>[미션 신청 취소 방법]</strong><br/>
                            <span style=color:red;>* 신청자 본인이 직접 취소 가능, 신청기간 종료 이후 취소 불가</span><br/>
                            ① 신청 완료 미션 선택<br/>
                            ② 하단 [신청자 확인] 버튼 클릭<br/>
                            ③ [삭제] 클릭 > 취소 완료<br/><br/>
                             
                            <strong>[미션 진행 주의사항]</strong><br/>
                            - 안내 된 미션 진행 기간을 반드시 엄수해주세요.<br/>
                            - 컨텐츠는 \"후기 등록\" 기간 내 홈페이지에 등록해주세요.<br/>
                              * 등록 방법: 해당 페이지 \"후기 등록하기\" 버튼 클릭 후 안내에 따라 등록<br/>
                            - 업로드 완료 된 컨텐츠 URL을 홈페이지에 등록하지 않은 경우<br/>
                              기간 내 미션 미수행으로 간주되며 혜택이 제공이 어렵습니다.<br/>
                            - 컨텐츠는 제공된 가이드라인 숙지 후 작성해주세요.<br/>
                              <span style=color:red;>* 가이드 내 안내 된 화장품법 및 표시광고 공정화 관련 법률 유의부탁드립니다.</span><br/>
                              <span style=color:red;>* 생활화학제품 등의 표시·광고에 관한 규정이 제정되었습니다.</span>( 링크삽입 )<br/>
                            - 미션 컨텐츠 비공개 전환 및 삭제 금지<br/>
                            - 작성된 포스팅은 향후 컨텐츠 자료로 활용될 수 있습니다.<br/><br/>
                             
                            <strong>[페널티 및 혜택 안내]</strong><br/><br/>
                            
                            - 미션 미진행 2회 또는 기간 내 후기 미등록 5회 이상일 시 활동 불가<br/>
                            - 활동 완료 혜택은 월 1회, 활동 기간 내 총 10회 이상 정기미션 참여 시 지급<br/>
                              * 미션 참여 최대 횟수는 제한이 없습니다.<br/>
                            - 활동 안내자료 확인하기: <br/><br/>
                            
                            <strong>[문의]</strong><br/>
                            - 제품문의: 080-024-1357(수신자부담) 애경 고객만족센터<br/>
                            - 미션문의: 카카오톡 플러스 친구 <뷰티클럽> 1:1 대화<br/>
                            ";
	                    } else if($_GET["board"] == "group_04_28") {
	                        $mission_text = "<strong>[미션일정]</strong><br/>
                            <strong>▶미션 제품: </strong><br/>                          
                            <strong>▶미션 신청 마감: </strong><br/>
                            <strong>▶미션 제품 발송일: </strong><br/>
                            <strong>▶원고 오픈 및 홈페이지 내 후기등록: </strong><br/>
                            <span style=color:red;><strong>※ 미션 가이드 탭에서 가이드라인 다운로드 후 컨텐츠 작성 부탁드립니다.</strong></span><br/>
                            <strong>※ 기간 내 컨텐츠 업로드 및 홈페이지 후기등록 완료 = 정상 미션 참여</strong><br/>
                            <strong>※ 정상 미션 참여자에 한하여 AK LOVER 포인트가 지급됩니다.</strong><br/>
                               * 필수 미션 + 자율미션 포인트 지급 기준 가이드라인 참고<br/><br/>
                             
                            <strong>[미션 신청 취소 방법]</strong><br/>
                            <span style=color:red;>* 신청자 본인이 직접 취소 가능, 신청기간 종료 이후 취소 불가</span><br/>
                            ① 신청 완료 미션 선택<br/>
                            ② 하단 [신청자 확인] 버튼 클릭<br/>
                            ③ [삭제] 클릭 > 취소 완료<br/><br/>
                             
                            <strong>[미션 진행 주의사항]</strong><br/>
                            - 안내 된 미션 진행 기간을 반드시 엄수해주세요.<br/>
                            - 컨텐츠는 \"후기 등록\" 기간 내 홈페이지에 등록해주세요.<br/>
                              * 등록 방법: 해당 페이지 \"후기 등록하기\" 버튼 클릭 후 안내에 따라 등록<br/>
                            - 업로드 완료 된 컨텐츠 URL을 홈페이지에 등록하지 않은 경우<br/>
                              기간 내 미션 미수행으로 간주되며 혜택이 제공이 어렵습니다.<br/>
                            - 컨텐츠는 제공된 가이드라인 숙지 후 작성해주세요.<br/>
                              <span style=color:red;>* 가이드 내 안내 된 화장품법 및 표시광고 공정화 관련 법률 유의부탁드립니다.</span><br/>
                              <span style=color:red;>* 생활화학제품 등의 표시·광고에 관한 규정이 제정되었습니다.</span> ( 링크삽입 )<br/>
                            - 미션 컨텐츠 비공개 전환 및 삭제 금지<br/>
                            - 작성된 포스팅은 향후 컨텐츠 자료로 활용될 수 있습니다.<br/><br/>
                             
                            <strong>[페널티 및 혜택 안내]</strong><br/>
                            - 미션 미진행 2회 또는 기간 내 후기 미등록 5회 이상일 시 활동 불가<br/>
                            - 활동 완료 혜택은 월 1회, 활동 기간 내 총 10회 이상 정기미션 참여 시 지급<br/>
                              * 미션 참여 최대 횟수는 제한이 없습니다.<br/>
                            - 활동 안내자료 확인하기:<br/><br/>  
                             
                            <strong>[문의]</strong><br/>
                            - 제품문의: 080-024-1357(수신자부담) 애경 고객만족센터<br/>
                            - 미션문의: 카카오톡 플러스 친구 <라이프클럽> 1:1 대화<br/>
                            ";
	                    } else {
	                        $mission_text = "- 본 체험단은 <span style=color:red;>블로그 1건 + 인스타그램 1건 총 2건 필수</span>입니다.<br/>
                    		- 체험단 신청 시 블로그 URL 및 인스타그램 URL이 확인되지 않을 경우<br/>&nbsp; 슈퍼패스를 사용하더라도 선정자 선정에서 제외되며 사용 취소 된 슈퍼패스는 재발급 되지 않습니다.<br/>
                    		- 배송 포인트 차감 외, 체험단 참여 혜택으로 제공되는 제품 배송료는 본인 부담입니다.<br/>
                    		- 브랜드 요청에 따라서 인원 및 선정혜택, 우수자 혜택이 변경될 수도 있습니다.<br/>
                    		- 핸드폰보다는 카메라로 찍은 사진을 활용해주세요.<br/>
                    		- <span style=color:red;>또한, 3개월 내 리뷰 포스팅 비공개 금지! 비공개 확인 시 페널티 부과 될 수 있는 점 참고 부탁드립니다!</span><br/><br/>
                    		<span style=color:red;>* 기간 내 후기 미 등록시 1,000포인트 차감과 함께 3개월 간 체험단 선정에서 제외됩니다.</span><br/>
                    		- 후기 등록 시 [콘텐츠 가이드] 내 배너를 반드시 콘텐츠 내 삽입해주세요.";
	                    }
					?>
						<textarea name="hero_guide" id="editor3" class="textarea" style="width:600px; height: 150px;"><?=$mission_text ?></textarea>
	                <?php }?>
					</dd>
				</dl>
                <dl>
					<dt>
						<span class="bg1">콘텐츠 가이드</span>
					</dt>
					<dd>
						<textarea name="hero_help" id="hero_help" class="textarea" style="width: 550px; height: 150px;"><?=$view_row['hero_help'];?></textarea>
					</dd>
				</dl>
                <dl class="dis-no">
					<dt>
						<span class="bg1">체험단 노출</span>
					</dt>
					<dd class="f_cs date_selec">
						<input type="text" id="sdate5" name="hero_today_05_01"
						value="<?=$view_row['hero_today_05_01']?>" class="input10"
						style="text-align: center" /> <input type="text"
						id="edate5" name="hero_today_05_02"
						value="<?=$view_row['hero_today_05_02']?>" class="input10"
						style="text-align: center" /> <input type="button" value="초기화" onclick="$('#sdate5').val('');$('#edate5').val('');"/>
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
							<span class="bg1" id="txt_change">후기 등록</span>
						<? }else{?>
							<span class="bg1 d3">체험단 신청</span>
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
						<span class="bg1" id="not_01">선정자 발표</span>
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
						<span class="bg1" id="not_02">후기 등록</span>
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
						<span class="bg1" id="not_04">우수후기 발표</span>
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
						<b style="font-weight: 600;">* 후기 등록 기간이 필요 없을 경우</b> - 선정자 발표 마감일과 후기등록 시작일/마감일, 우수후기 시작일/마감일을 동일한 일자로 선택해주세요.
							<br /> EX) 선정자 발표 마감일이 2024.01.01이라면 후기등록 시작일/마감일, 우수후기 발표 시작일/마감일을 2024.01.01로 동일하게 선택
					</span>
				</dl>
				<dl id="not_03" class="s1">
                    <span class="fz14" style="color:#B19D75" >* 소문내기 기간 - 선정자 발표, 후기 등록, 우수후기 발표 기간을 모두 같은 날로 설정해주세요.</span>
				</dl>
                <link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/anytime.5.1.2.css">
                <script src="<?=ADMIN_DEFAULT?>/js/anytime.5.1.2.js"></script>
                <script>
                    //모든 날짜포맷 통일
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
						<span class="bg1">배너삽입1</span>
					</dt>
					<dd style="margin-top: 1.2rem;">
						<p style="color:#B19D75; margin-bottom:5px;">네이버 블로그 공정위배너 삽입</p>
						<div class="ftc_word" style="display:none;">
							<label>공정위문구</label>
							<input type="text" name="hero_ftc_naver" value="<?=$hero_ftc_naver?>" />
						</div>
						<textarea name="hero_banner" id="hero_banner" class="textarea dis-no" style="width: 550px; height: 150px;"><?=$hero_banner?></textarea>
                        <input type="file" name="bannerFile" id="bannerFile" />
                        <a href="javascript:;" onclick="bannerUpload()" class="btnSubmit"><span class="btn_up">업로드</span> <span class="fz12">(이미지명이 자동으로 변경됩니다)</span></a>
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1" style="letter-spacing:-2px;">배너삽입2</span>
					</dt>
					<dd style="margin-top: 1.2rem;">
						<p style="color:#B19D75; margin-bottom:5px;">인스타그램 공정위 문구 삽입</p>
						<div class="ftc_word" style="display:none;">
							<label>공정위문구</label>
							<input type="text" name="hero_ftc_insta" value="<?=$hero_ftc_insta?>" />
						</div>
						<textarea name="hero_insta" id="hero_insta" class="textarea" style="width: 550px; height: 150px;"><?=$hero_insta?></textarea>
						<input type="file" name="instaBannerFile" id="instaBannerFile" />
                        <a href="javascript:;" onclick="instaBannerUpload()" class="btnSubmit"><span class="btn_up">업로드</span> <span class="fz12">(이미지명이 자동으로 변경됩니다)</span></a>
					</dd>
				</dl>
				<? if($_GET["board"] == "group_04_27") {?>
				<dl>
					<dt>
						<span class="bg1">배너삽입3</span>
					</dt>
					<dd style="margin-top: 1.2rem;">
						<p style="color:#B19D75; margin-bottom:5px;">영상 채널 공정위 문구 삽입</p>
						<? if($_GET['action'] == "write") {?>
						<textarea name="hero_youtube" id="hero_youtube" class="textarea" style="width: 550px; height: 150px;">AK LOVER 제품지원</textarea>
						<? }else {?>
						<textarea name="hero_youtube" id="hero_youtube" class="textarea" style="width: 550px; height: 150px;"><?=$view_row['hero_youtube'];?></textarea>
						<? } ?>
						<input type="file" name="youtubeBannerFile" id="youtubeBannerFile" />
                        <a href="javascript:;" onclick="youtubeBannerUpload()" class="btnSubmit" style="background:#09F;padding:3px;color:#fff;line-height:40px;"/>업로드</a>(이미지명이 자동으로 변경됩니다)
					</dd>
				</dl>
				<? } ?>

                <dl id="step_write_question_url" >
					<dt>
						<span class="bg1">URL 선택</span>
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
							<div class="input_radio"><input type="radio" name="hero_question_url_yn" id="hero_question_url_yn_Y" value="Y" <?=$view_row['hero_question_url_yn']=="Y" || !$view_row['hero_question_url_yn'] ? "checked":"";?>><label for="hero_question_url_yn_Y">사용</label></div>
							<div class="input_radio"><input type="radio" name="hero_question_url_yn" id="hero_question_url_yn_N" value="N" <?=$view_row['hero_question_url_yn']=="N" ? "checked":"";?>><label for="hero_question_url_yn_N">미사용</label></div>
						</div>
						<div class="">
							<div class="f_cs" style="margin-top: 1.2rem;">
								<div class="input_chk mgr20"><input type="checkbox" id="sns01" class="question_url_list" value='블로그' <?=$url_list['블로그']=='블로그'?'checked':''?>/><label class="input_chk_label" for="sns01">네이버 블로그 URL</label></div>
								<div class="input_chk mgr20"><input type="checkbox" id="sns02" class="question_url_list" value='인스타그램' <?=$url_list['인스타그램']=='인스타그램'?'checked':''?>/> <label class="input_chk_label" for="sns02">인스타그램 URL</label></div>
								<div class="input_chk mgr20"><input type="checkbox" id="sns03" class="question_url_list" value='영상 채널' <?=$url_list['영상 채널']=='영상 채널'?'checked':''?>/> <label class="input_chk_label" for="sns03">영상 채널 URL</label></div>
							</div>
							<div class="f_cs" style="margin-top: 1.2rem;">
								<div class="input_chk mgr20"><input type="checkbox" id="sns04" class="question_url_list" value='페이스북' <?=$url_list['페이스북']=='페이스북'?'checked':''?>/> <label class="input_chk_label" for="sns04">페이스북 URL</label></div>
								<div class="input_chk mgr20"><input type="checkbox" id="sns05" class="question_url_list" value='트위터' <?=$url_list['트위터']=='트위터'?'checked':''?>/><label class="input_chk_label" for="sns05"> 트위터 URL</label></div>
								<div class="input_chk mgr20"><input type="checkbox" id="sns06" class="question_url_list" value='카카오스토리' <?=$url_list['카카오스토리']=='카카오스토리'?'checked':''?>/><label class="input_chk_label" for="sns06"> 카카오스토리 URL</label></div>
							</div>
							<p style="color:#B19D75; margin-top: 1.2rem;">참고) 체험단 신청 시 선택한 URL 항목 노출</p>
                        </div>
                    </dd>
				</dl>
				<div style="clear:both;"></div>
				<dl>
					<dt>
						<span class="bg1">URL 필수 입력 체크</span>
					</dt>
					<dd style="margin-top: 1.2rem;">
						<div class="input_radio"><input type="radio" name="hero_question_url_check" id="hero_question_url_check_1" value="1" <?=$view_row["hero_question_url_check"]=="1" ? "checked":"";?>/><label for="hero_question_url_check_1">네이버 블로그</label></div>
						<div class="input_radio"><input type="radio" name="hero_question_url_check" id="hero_question_url_check_2" value="2" <?=$view_row["hero_question_url_check"]=="2" ? "checked":"";?>/><label for="hero_question_url_check_2">인스타그램</label></div>
						<div class="input_radio" style="margin-bottom: 0.8rem;"><input type="radio" name="hero_question_url_check" id="hero_question_url_check_5" value="5" <?=$view_row["hero_question_url_check"]=="5" ? "checked":"";?>/><label for="hero_question_url_check_5">후기(영상)</label></div><br/>

						<div class="input_radio"><input type="radio" name="hero_question_url_check" id="hero_question_url_check_3" value="3" <?=$view_row["hero_question_url_check"]=="3" ? "checked":"";?>/><label for="hero_question_url_check_3">네이버 블로그 or 인스타그램</label></div>
						<div class="input_radio" style="margin-bottom: 0.8rem;"><input type="radio" name="hero_question_url_check" id="hero_question_url_check_4" value="4" <?=$view_row["hero_question_url_check"]=="4" ? "checked":"";?>/><label for="hero_question_url_check_4">네이버 블로그 and 인스타그램</label></div><br/>
						<div class="input_radio" style="margin-bottom: 0.8rem;"><input type="radio" name="hero_question_url_check" id="hero_question_url_check_6" value="6" <?=$view_row["hero_question_url_check"]=="6" ? "checked":"";?>/><label for="hero_question_url_check_6">네이버 블로그 or 인스타그램 or 후기(영상)</label></div><br/>

						<div class="input_radio"><input type="radio" name="hero_question_url_check" id="hero_question_url_check_9" value="9" <?=$view_row["hero_question_url_check"]=="9" ? "checked":"";?>/><label for="hero_question_url_check_9">체크 없음</label></div>
						<p style="color:#B19D75; margin-top: 1.2rem;">참고) 체험단 신청 및 후기 등록 시 필수 입력 값으로 선택</p>
					</dd>
					<div style="clear:both;"></div>

				</dl>
				<dl>
					<dt>
						<span class="bg1">
							<? if($focus_group) {?>
								가이드라인 <b class="fz12">(인스타그램)</b>
							<? } else { ?>
								가이드라인 <b class="fz12">(인스타그램)</b>
							<? } ?>
						</span>
					</dt>
					<dd>
						<input type="file" name="guideFile" />(20MB 이하)
						<? if($view_row["guide_ori_file"]) {?>
						<br/><div class="input_chk"><input type="checkbox" id="del1" name="delGuideFile" value="Y" /><label for="del1" class="input_chk_label"><?=$view_row["guide_ori_file"]?></label><span style="color:#F00; margin-top: .6rem; display: inline-block;">(삭제 시 체크해 주세요)</span></div>
						<? } ?>
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1">
							<? if($focus_group) {?>
								가이드라인 <b class="fz12">(블로그)</b>
							<? } else { ?>
								가이드라인 <b class="fz12">(블로그)</b>
							<? } ?>
						</span>
					</dt>
					<dd>
						<input type="file" name="guideFile2" />(20MB 이하) 
						<? if($view_row["guide_ori_file2"]) {?>
						<br/><div class="input_chk"><input type="checkbox" id="del2" name="delGuideFile2" value="Y" /><label for="del2" class="input_chk_label"><?=$view_row["guide_ori_file2"]?></label><span style="color:#F00; margin-top: .6rem; display: inline-block;">(삭제 시 체크해 주세요)</span></div>
						<? } ?>
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1">
							<? if($focus_group) {?>
								가이드라인 <b class="fz12">(유튜브)</b>
							<? } else { ?>
								가이드라인 <b class="fz12">(유튜브)</b>
							<? } ?>
						</span>
					</dt>
					<dd>
						<input type="file" name="guideFile3" />(20MB 이하) <?=$view_row["guide_ori_file3"]?>
						<? if($view_row["guide_ori_file3"]) {?>
						<br/><div class="input_chk"><input type="checkbox" id="del3" name="delGuideFile3" value="Y" /><label for="del3" class="input_chk_label"><?=$view_row["guide_ori_file3"]?></label><span style="color:#F00; margin-top: .6rem; display: inline-block;">(삭제 시 체크해 주세요)</span></div>
						<? } ?>
					</dd>
				</dl>
				<div class="clearfix"></div>

				<div style="margin: 6rem 0 0;">
				<h2 class="fz20 bold" style="margin-bottom: 2rem;">체험단 후기등록 관리</h2>
				<dl>
					<dt>
						<span class="bg1">상품평 노출</span>
					</dt>
					<dd style="margin-top: 1rem;">
						<div class="input_radio"><input type="radio" name="hero_product_review_yn" id="hero_product_review_yn_Y" value="Y" <?=$view_row['hero_product_review_yn']=="Y"?"checked":"";?>/><label for="hero_product_review_yn_Y">노출</label></div>
						<div class="input_radio"><input type="radio" name="hero_product_review_yn" id="hero_product_review_yn_N" value="N" <?=($view_row['hero_product_review_yn']=="N" || !$view_row['hero_product_review_yn']) ? "checked":"";?>/><label for="hero_product_review_yn_N">미노출</label></div>
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1">공정위문구 확인</span>
					</dt>
					<dd style="margin-top: 1rem;">
						<div class="input_radio"><input type="radio" name="hero_ftc" id="hero_ftc_1" value="1"/><label for="hero_ftc_1">확인</label></div>
						<div class="input_radio"><input type="radio" name="hero_ftc" id="hero_ftc_0" value="0" <?=($view_row['hero_ftc']=="0" && strlen($view_row['hero_ftc']) > 0 || !$view_row['hero_ftc']) ? "checked":"";?>/><label for="hero_ftc_0">미확인</label></div>
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1">체험단 공개여부</span>
					</dt>
					<dd style="margin-top: 1rem;">
						<div class="input_radio"><input type="radio" name="hero_use" id="hero_use_1" value="1" <?=$view_row['hero_use']!="0" &&  $view_row['hero_use']!="2"?"checked":"";?>/><label for="hero_use_1">공개</label></div>
						<div class="input_radio"><input type="radio" name="hero_use" id="hero_use_0" value="0" <?=$view_row['hero_use']=="0"?"checked":"";?>/><label for="hero_use_0">비공개</label></div>
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
						<a href="javascript:;" onClick="fnPopSurvey('<?=$view_row["hero_idx"]?>');" class="btn_submit btn_white">설문조사 <?=$survey_rs["cnt"] > 0 ? "수정":"추가"?></a>
					<? } ?>
					<? if(!strcmp($_GET['action'], 'update')){?>
                        <a href="<?=PATH_HOME.'?'.get('view||action','view=view');?>" class="btn_submit btn_white">취소하기</a>
					<? }else{?>
                        <a href="<?=PATH_HOME.'?'.get('view||action');?>" class="btn_submit btn_white">취소하기</a>
					<? }?>
                        <a href="javascript:;" onclick="javascript:return doSubmit(frm);" class="btn_submit btn_main_c">등록하기</a>
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
			alert(count+"글자 이하로 입력해주세요.");
			ids.focus();
		}
	};
	function ch_count_text(count,id){
		var ids = document.getElementById(id);

		if(count<ids.value.length){
			ids.value = ids.value.substring(0,count);
			alert(count+"글자 이내로 입력해주세요.");
			ids.focus();
		}
	};
	function ch_number(id){
		var ids = document.getElementById(id);
		if(isNaN(ids.value)==true){
			ids.value="";
			alert("숫자만 입력해 주세요.");
			ids.focus();
		}
	};

</script>

<script type="text/javascript">
    function doSubmit (theform){
        myeditor.outputBodyHTML();

<? if($_GET['board'] =='group_04_05'){//체험단?>
		//20170502 추가
		// myeditor2.outputBodyHTML();
		myeditor3.outputBodyHTML();
<? } else if($focus_group){?>
		myeditor3.outputBodyHTML();
<? } ?>

		<? if($_GET['board'] =='group_04_27'){//영상채널?>
			if(!$("select[name='hero_movie_group']").val()) {
				alert("신청대상 영상채널 그룹을 선택해 주세요.");
				return;
			}



			if(!$("select[name='hero_movie_gisu']").val() && $(":radio[name='hero_type']:checked").val() != "7") {
				alert("신청대상 영상채널 그룹의 기수를 선택해 주세요.");
				return;
			}

		<? } ?>

		var chk_length = $('.question_url_list:checkbox:checked').length;
		var url_list = "";
		var j = 1;
// 		if(chk_length == 0 && $(":radio[name=hero_type]:checked").val() != 1) {
// 			alert('입력받을 URL을 선택해주세요');
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
			alert("URL 필수 입력을 선택해 주세요.");
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
            alert('올린 이미지가 없습니다.');
            return;
        }
        for (var i=0; i<data.length; i++) {
            var str = 'URL: ' + data[i].fileUrl + "\n";
            str += '저장 경로: ' + data[i].filePath + "\n";
            str += '원본 이름: ' + data[i].origName + "\n";
            str += '저장 이름: ' + data[i].fileName + "\n";
            str += '크기: ' + data[i].fileSize;
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

//20170502 추가
<? if($_GET['board'] =='group_04_05'){//체험단?>
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
	if(hero_type=="8") { //포인트 체험
		html  = "- 본 체험단은 가이드라인 내 <strong>필수 미션을 진행해주셔야 합니다.</strong><br/>";
		html += "<span style=color:red;>- 해당 제품 구매 후, 홈페이지에 등록되는 가이드라인에 따라 후기 작성 부탁드립니다.</span><br/>";
		html += "- 체험단 신청 시 블로그 URL 확인되지 않을 경우 선정이 어렵습니다.<br/>";
		html += "- 후기 등록은 <span style=color:red;>일반 체험단과 동일하게 가이드라인에 따라 개인 블로그에 후기 1건 작성해 주시면 됩니다.</span><br/>";
		html += "- 브랜드 요청에 따라서 인원 및 선정 혜택이 변경될 수 있습니다.<br/>";
		html += "- 핸드폰보다는 카메라로 찍은 사진을 활용해주세요.<br/>";
		html += "- 또한, 3개월 내 리뷰 포스팅 비공개 금지! 비공개 확인 시 페널티 부과 될 수 있는 점 참고 부탁드립니다!<br/><br/>";
		html += "* 기간 내 후기 미 등록시 1,000포인트 차감과 함께 3개월 간 체험단 선정에서 제외됩니다.<br/>";
		html += "- 후기 등록 시 [콘텐츠 가이드] 내 배너를 반드시 콘텐츠 내 삽입해주세요";
	} else if(hero_type == "0" || hero_type == "9") {
		if(board == 'group_04_06') {
			html  = "<strong>[미션일정]</strong><br/>";
            html += "<strong>▶미션 제품:</strong> <br/>";
            html += "<strong>▶미션 신청 마감:</strong><br/>";
            html += "<strong>▶미션 제품 발송일:</strong> <br/>";
            html += "<strong>▶원고 오픈 및 홈페이지 내 후기등록:</strong>  <br/>";
            html += "<span style=color:red;><strong>※ 미션 가이드 탭에서 가이드라인 다운로드 후 컨텐츠 작성 부탁드립니다.</strong></span><br/>";
            html += "<strong>※ 기간 내 컨텐츠 업로드 및 홈페이지 후기등록 완료 = 정상 미션 참여</strong><br/>";
            html += "<strong>※ 정상 미션 참여자에 한하여 AK LOVER 포인트가 지급됩니다.</strong><br/>";
            html += "* 필수 미션 + 자율미션 포인트 지급 기준 가이드라인 참고<br/><br/>";
            html += "<strong>[미션 신청 취소 방법]</strong><br/>";
            html += "<span style=color:red;>* 신청자 본인이 직접 취소 가능, 신청기간 종료 이후 취소 불가</span><br/>";
            html += "① 신청 완료 미션 선택<br/>";
            html += "② 하단 [신청자 확인] 버튼 클릭<br/>";
            html += "③ [삭제] 클릭 > 취소 완료<br/><br/>";
            html += "<strong>[미션 진행 주의사항]</strong><br/>";
            html += "- 안내 된 미션 진행 기간을 반드시 엄수해주세요.<br/>";
            html += "- 컨텐츠는 \"후기 등록\" 기간 내 홈페이지에 등록해주세요.<br/>";
            html += "* 등록 방법: 해당 페이지 \"후기 등록하기\" 버튼 클릭 후 안내에 따라 등록<br/>";
            html += "- 업로드 완료 된 컨텐츠 URL을 홈페이지에 등록하지 않은 경우<br/>";
            html += "기간 내 미션 미수행으로 간주되며 혜택이 제공이 어렵습니다.<br/>";
            html += "- 컨텐츠는 제공된 가이드라인 숙지 후 작성해주세요.<br/>";
            html += "<span style=color:red;>* 가이드 내 안내 된 화장품법 및 표시광고 공정화 관련 법률 유의부탁드립니다.</span><br/>";
            html += "<span style=color:red;>* 생활화학제품 등의 표시·광고에 관한 규정이 제정되었습니다.</span>( 링크삽입 )<br/>";
            html += "- 미션 컨텐츠 비공개 전환 및 삭제 금지<br/>";
            html += "- 작성된 포스팅은 향후 컨텐츠 자료로 활용될 수 있습니다.<br/><br/>";
            html += "<strong>[페널티 및 혜택 안내]</strong><br/><br/>";
            html += "- 미션 미진행 2회 또는 기간 내 후기 미등록 5회 이상일 시 활동 불가<br/>";
            html += "- 활동 완료 혜택은 월 1회, 활동 기간 내 총 10회 이상 정기미션 참여 시 지급<br/>";
            html += "* 미션 참여 최대 횟수는 제한이 없습니다.<br/>";
            html += "- 활동 안내자료 확인하기: <br/><br/>";
            html += "<strong>[문의]</strong><br/>";
            html += "- 제품문의: 080-024-1357(수신자부담) 애경 고객만족센터<br/>";
            html += "- 미션문의: 카카오톡 플러스 친구 <뷰티클럽> 1:1 대화<br/>";
		} else if(board == 'group_04_28') {
			html  = "<strong>[미션일정]</strong><br/>";
			html += "<strong>▶미션 제품: </strong><br/>";
            html += "<strong>▶미션 신청 마감: </strong><br/>";
            html += "<strong>▶미션 제품 발송일: </strong><br/>";
            html += "<strong>▶원고 오픈 및 홈페이지 내 후기등록: </strong><br/>";
            html += "<span style=color:red;><strong>※ 미션 가이드 탭에서 가이드라인 다운로드 후 컨텐츠 작성 부탁드립니다.</strong></span><br/>";
            html += "<strong>※ 기간 내 컨텐츠 업로드 및 홈페이지 후기등록 완료 = 정상 미션 참여</strong><br/>";
            html += "<strong>※ 정상 미션 참여자에 한하여 AK LOVER 포인트가 지급됩니다.</strong><br/>";
            html += "* 필수 미션 + 자율미션 포인트 지급 기준 가이드라인 참고<br/><br/>";
            html += "<strong>[미션 신청 취소 방법]</strong><br/>";
            html += "<span style=color:red;>* 신청자 본인이 직접 취소 가능, 신청기간 종료 이후 취소 불가</span><br/>";
            html += "① 신청 완료 미션 선택<br/>";
            html += "② 하단 [신청자 확인] 버튼 클릭<br/>";
            html += "③ [삭제] 클릭 > 취소 완료<br/><br/>";
            html += "<strong>[미션 진행 주의사항]</strong><br/>";
            html += "- 안내 된 미션 진행 기간을 반드시 엄수해주세요.<br/>";
            html += "- 컨텐츠는 \"후기 등록\" 기간 내 홈페이지에 등록해주세요.<br/>";
            html += "* 등록 방법: 해당 페이지 \"후기 등록하기\" 버튼 클릭 후 안내에 따라 등록<br/>";
            html += " - 업로드 완료 된 컨텐츠 URL을 홈페이지에 등록하지 않은 경우<br/>";
            html += "기간 내 미션 미수행으로 간주되며 혜택이 제공이 어렵습니다.<br/>";
            html += "- 컨텐츠는 제공된 가이드라인 숙지 후 작성해주세요.<br/>";
            html += "<span style=color:red;>* 가이드 내 안내 된 화장품법 및 표시광고 공정화 관련 법률 유의부탁드립니다.</span><br/>";
            html += "<span style=color:red;>* 생활화학제품 등의 표시·광고에 관한 규정이 제정되었습니다.</span> ( 링크삽입 )<br/>";
            html += "- 미션 컨텐츠 비공개 전환 및 삭제 금지<br/>";
            html += "- 작성된 포스팅은 향후 컨텐츠 자료로 활용될 수 있습니다.<br/><br/>";
            html += "<strong>[페널티 및 혜택 안내]</strong><br/>";
            html += "- 미션 미진행 2회 또는 기간 내 후기 미등록 5회 이상일 시 활동 불가<br/>";
            html += "- 활동 완료 혜택은 월 1회, 활동 기간 내 총 10회 이상 정기미션 참여 시 지급<br/>";
            html += "* 미션 참여 최대 횟수는 제한이 없습니다.<br/>";
            html += "- 활동 안내자료 확인하기:<br/><br/>";
            html += "<strong>[문의]</strong><br/>";
            html += "- 제품문의: 080-024-1357(수신자부담) 애경 고객만족센터<br/>";
            html += "- 미션문의: 카카오톡 플러스 친구 <라이프클럽> 1:1 대화<br/>";
		}
	} else {
		html = "- 본 체험단은 <span style=color:red;>블로그 1건 + 인스타그램 1건 총 2건 필수</span>입니다.<br/>";
		html += "- 체험단 신청 시 블로그 URL 및 인스타그램 URL이 확인되지 않을 경우<br/>&nbsp; 슈퍼패스를 사용하더라도 선정자 선정에서 제외되며 사용 취소 된 슈퍼패스는 재발급 되지 않습니다.<br/>";
		html += "- 배송 포인트 차감 외, 체험단 참여 혜택으로 제공되는 제품 배송료는 본인 부담입니다.<br/>";
		html += "- 브랜드 요청에 따라서 인원 및 선정혜택, 우수자 혜택이 변경될 수도 있습니다.<br/>";
		html += "- 핸드폰보다는 카메라로 찍은 사진을 활용해주세요.<br/>";
		html += "- <span style=color:red;>또한, 3개월 내 리뷰 포스팅 비공개 금지! 비공개 확인 시 페널티 부과 될 수 있는 점 참고 부탁드립니다!</span><br/><br/>";
		html += "<span style=color:red;>* 기간 내 후기 미 등록시 1,000포인트 차감과 함께 3개월 간 체험단 선정에서 제외됩니다.</span><br/>";
		html += "- 후기 등록 시 [콘텐츠 가이드] 내 배너를 반드시 콘텐츠 내 삽입해주세요.";
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

    //날짜포맷 통일로 주석
    dateclick1(); //체험단 노출
    dateclick2(); //체험단 신청
    dateclick3(); //선정자 발표
    dateclick4(); //후기등록
    dateclick5(); //우수후기 발표

    <? if($focus_group && $view_row["hero_type"] == "7") { //자율미션?>
    	$("#sdate2, #edate2, #sdate3, #edate3, #sdate4, #edate4, #not_01, #not_02, #not_03, #not_04").show();
 	  	$("#txt_change").html("체험단 신청");
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
    <? if($focus_group && $view_row["hero_type"] == "9") { //정기미션 선택?>
    	$("#sdate2, #edate2, #sdate3, #edate3, #sdate4, #edate4, #not_01, #not_02, #not_03, #not_04").show();
 	  	$("#txt_change").html("체험단 신청");
    <? } ?>
});
//체험단 노출
function dateclick1(){
    var dates = jQuery("#sdate5, #edate5").datepicker({
        monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
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
            
            //클릭하고나면 다른 날짜값 사라져서 미리 저장
            var sdate = $("#sdate5").val();
            var edate = $("#edate5").val();

            dates.not( this ).datepicker( "option", option, date );

            //날짜 선택하면 포맷해주고 다른 날짜값 다시 넣어줌
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
//체험단 신청
function dateclick2(){
    var dates = jQuery("#sdate1, #edate1").datepicker({
        monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
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

            //클릭하고나면 다른 날짜값 사라져서 미리 저장
            var sdate = $("#sdate1").val();
            var edate = $("#edate1").val();

            dates.not( this ).datepicker( "option", option, date );

            //날짜 선택하면 포맷해주고 다른 날짜값 다시 넣어줌
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
//선정자 발표
function dateclick3(){
    var dates = jQuery("#sdate2, #edate2").datepicker({
        monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
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

            //클릭하고나면 다른 날짜값 사라져서 미리 저장
            var sdate = $("#sdate2").val();
            var edate = $("#edate2").val();

            dates.not( this ).datepicker( "option", option, date );

            //날짜 선택하면 포맷해주고 다른 날짜값 다시 넣어줌
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
//후기등록
function dateclick4(){
    var dates = jQuery("#sdate3, #edate3").datepicker({
        monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
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

            //클릭하고나면 다른 날짜값 사라져서 미리 저장
            var sdate = $("#sdate3").val();
            var edate = $("#edate3").val();

           dates.not( this ).datepicker( "option", option, date );

            //날짜 선택하면 포맷해주고 다른 날짜값 다시 넣어줌
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
//우수후기 발표
function dateclick5(){
    var dates = jQuery("#sdate4, #edate4").datepicker({
        monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
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

            //클릭하고나면 다른 날짜값 사라져서 미리 저장
            var sdate = $("#sdate4").val();
            var edate = $("#edate4").val();

            dates.not( this ).datepicker( "option", option, date );

            //날짜 선택하면 포맷해주고 다른 날짜값 다시 넣어줌
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
					_hero_movie_gisu.append("<option value=''>기수 선택</option>");

					var start_gisu = "";
					if(val=="group_04_27") {
						start_gisu = 10;
					} else if(val=="group_04_31") {
						start_gisu = 3;
					}

				 	for(var i=d; i>=start_gisu; i--) {
					 	if(selectedVal) {
						 	if(i==selectedVal) attrSelected = "selected";
					 		_hero_movie_gisu.append("<option value='"+i+"' "+attrSelected+">"+i+"기수</option>");
				 		} else {
				 			if(i==d) attrSelected = "selected";
					 		_hero_movie_gisu.append("<option value='"+i+"' "+attrSelected+">"+i+"기수</option>");
				 		}
				 		attrSelected = "";
					}
				},error:function(e){
					console.log(e);
					alert("오류가 발생했습니다.\n다시 이용해 주세요.");
				}
			})
	}
}

<? if($_GET["idx"]) {?>
	selMovieGisu('<?=$view_row["hero_movie_group"]?>',<?=$view_row["hero_movie_gisu"]?>)
<? } ?>
</script>