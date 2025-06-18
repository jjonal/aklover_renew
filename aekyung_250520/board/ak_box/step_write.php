<?
// ####################################################################################################################################################
// HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
// ####################################################################################################################################################
if (! defined ( '_HEROBOARD_' ))
	exit ();
	// ####################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\'' . $_GET ['board'] . '\';'; // desc
sql ( $sql );
$right_list = @mysql_fetch_assoc ( $out_sql );
// ####################################################################################################################################################
$view_sql = 'select * from mission where hero_table = \'' . $_GET ['board'] . '\' and hero_idx=\'' . $_GET ['idx'] . '\';';
$out_view_sql = mysql_query ( $view_sql );
$view_row = @mysql_fetch_assoc ( $out_view_sql ); // mysql_fetch_row
?>
<link type='text/css'
	href='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.css' rel='stylesheet' />
<script type="text/javascript" src="<?=DOMAIN_END?>cal/jquery.min.js"></script>
<script type='text/javascript'
	src='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.min.js'></script>
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

function add_question_area(){

	var step_write_question_area = $("#step_write_question_area").children('dd');
	var count_area = step_write_question_area.length;
	count_area = count_area-1;
	var last_count = step_write_question_area.eq(count_area).attr('alt');
	last_count = parseInt(last_count)+1;
	var add_html = "<dd alt='"+last_count+"'><textarea class='textarea hero_ask' style='width: 515px; height: 100px;float:left;' ></textarea><div style='width: 33px;float: left;'><p class='step_write_plus_btn' onclick='add_question_area();'>+</p><p class='step_write_plus_btn' onclick='minus_question_area("+last_count+");' style='margin-top: 3px;'>-</p></div></dd>";
	$("#step_write_question_area").append(add_html);
	
}

function minus_question_area(eq_n){

	eq_n = parseInt(eq_n);
	var step_write_question_area = $("#step_write_question_area").children('dd');

	step_write_question_area.each(function( index ) {
		//alert(eq_n);

		if($(this).attr('alt')==eq_n){
			$(this).remove();
			
		}
		
	});
	//var count_area = step_write_question_area.length;
	
}
</script>
<style>

	.step_write_plus_btn { background-color: #b19d75;font-size: 20px;font-weight: 800;color: white;margin-left: 10px;float: left;width: 23px;height: 22px;text-align: center;padding-top: 5px; }

</style>
<div class="contents_area">
	<div class="page_title">
		<h2>
			<img src="<?=str($right_list['hero_right']);?>"
				alt="<?=$right_list['hero_title'];?>" />
		</h2>
		<ul class="nav">
			<li><img src="../image/common/icon_nav_home.gif" alt="home" /></li>
			<li>&gt;</li>
			<li><?=$right_list['hero_top_title']?></li>
			<li>&gt;</li>
			<li class="current"><?=$right_list['hero_title']?></li>
		</ul>
	</div>
	<div class="contents">
		<!--        <form name="frm" method="post" action="<?=PATH_HOME.'?'.get('','type=edit');?>">-->
		<!--        <form name="frm" action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post" enctype="multipart/form-data"> -->
		<div><img src="/image/bbs/guide_thumb.gif"/></div>	
		
		<div style="background:#F2F2F2;margin-bottom:10px;">
			<div id="thumbnailView" style="width:680px;height:105px;overflow-x:hidden;overflow-y:scroll;"></div>
		</div>
		<script type="text/javascript" src="/cheditor/cheditor.js"></script>
		
		<form name="frm" method="post"	action="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&view=action2&action=<?=$_GET['action']?>&idx=<?=$_GET['idx'];?>&page=<?=$_GET['page'];?>">
			<div class="spm_img">
			
			<input type="hidden" name="hero_drop" value="hero_drop||sm_file||command||chkbox||inputWidth||inputAlt||inputCaption||setWidth||setHeight||setBgcolor||thumbCount||keyWordStr">
			<input type="hidden" name="hero_code" value="<?=$_SESSION['temp_code'];?>"> 
			<input type="hidden" name="hero_table" value="<?=$_GET['board'];?>"> 
			<input type="hidden" name="hero_id" value="<?=$_SESSION['temp_id'];?>">
			<input type="hidden" name="hero_name" value="<?=$_SESSION['temp_name'];?>"> 
			<input type="hidden" name="hero_nick" value="<?=$_SESSION['temp_nick'];?>">
			<input type="hidden" name="thumbCount" id="thumbCount" value="0">
			<input type="hidden" name="hero_thumb" id="hero_thumb" value="<?=$view_row['hero_thumb']?>">
			<input type="hidden" name="hero_ask" id="hero_ask">
<?if(strcmp($_GET['action'], 'update')){?>
            <input type="hidden" name="hero_today" value="<?=Ymdhis?>">
<?}?>
            <input type="hidden" name="hero_ip"
											value="<?=$_SERVER['REMOTE_ADDR']?>"> <textarea id="editor"
													name="command"><?=$view_row['hero_command']?></textarea>
			</div>
			<div class="spm_txt">
				<!--  
				<dl>
					<dt>
						<span class="bg1">미션 타입</span>
					</dt>
					<dd>
						<input type="radio" name="hero_type" value="0" <?echo ($view_row['hero_type']==0)? "checked='checked'" : "" ;?>/> 일반 미션
						<input type="radio" name="hero_type" value="1" <?echo ($view_row['hero_type']==1)? "checked='checked'" : "" ;?>/> 이벤트/설문조사
					</dd>
				</dl>
				-->
				<dl>
					<dt>
						<span class="bg1">미션 종류</span>
					</dt>
					<dd>
						<select name="hero_mission_type" id="hero_mission_type">
					        <option>선택</option>
					        <option value='1' <?=($view_row['hero_mission_type']==1)? "selected='selected'": "";?>>뷰티</option>
					        <option value='2' <?=($view_row['hero_mission_type']==2)? "selected='selected'": "";?>>세제</option>
					        <option value='3' <?=($view_row['hero_mission_type']==3)? "selected='selected'": "";?>>식품</option>
					        <option value='4' <?=($view_row['hero_mission_type']==4)? "selected='selected'": "";?>>타사코웍</option>
					    </select>
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1"><span style="cursor: pointer;"
							onclick="Javascript:showImageInfo();">제목</span></span>
					</dt>
					<dd>
						<input type="text" id="hero_title" name="hero_title"
							value="<?=$view_row['hero_title']?>"
							style="width: 550px; height: 23px;" />
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1"><span>부제</span></span>
					</dt>
					<dd>
						<input type="text" id="hero_title_02" name="hero_title_02"
							value="<?=$view_row['hero_title_02']?>"
							style="width: 550px; height: 23px;" />
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1"><span>리본 텍스트</span></span>
					</dt>
					<dd>
						<input type="text" id="hero_kind" placeholder='4 글자로 입력해주시기 바랍니다.'
							name="hero_kind" value="<?=$view_row['hero_kind']?>"
							style="width: 550px; height: 23px;" onblur="ch_count_text_kind(4,'hero_kind');"/>
					</dd>
				</dl>
				
				<dl>
					<dt>
						<span class="bg1"><span>참여대상</span></span>
					</dt>
					<dd>
						<input type="text" id="hero_target" placeholder='28 글자 이내로 입력해주시기 바랍니다.'
						onblur="ch_count_text(28,'hero_target');"
							name="hero_target" value="<?=$view_row['hero_target']?>"
							style="width: 550px; height: 23px;" />
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1"><span>선정인원</span></span>
					</dt>
					<dd>
						<input type="text" id="hero_select_count" placeholder='숫자만 입력해주세요.'
						onblur="ch_number('hero_select_count');"
							name="hero_select_count" value="<?=$view_row['hero_select_count']?>"
							style="width: 550px; height: 23px;" />
					</dd>
				</dl>

				<dl>
					<dt>
						<span class="bg1"><span>혜택</span></span>
					</dt>
					<dd>
						<input type="text" id="hero_benefit" placeholder='28 글자 이내로 입력해주시기 바랍니다.'
						onblur="ch_count_text(28,'hero_benefit');"
							name="hero_benefit" value="<?=$view_row['hero_benefit']?>"
							style="width: 550px; height: 23px;" />
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1"><span>제품 특징</span></span>
					</dt>
					<dd>
						<input type="text" id="hero_char"
							name="hero_char" value="<?=$view_row['hero_char']?>"
							style="width: 550px; height: 23px;" />
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1"><span>필수미션</span></span>
					</dt>
					<dd>
						<input type="text" id="hero_required" placeholder='54 글자 이내로 입력해주시기 바랍니다.'
						onblur="ch_count_text(54,'hero_required');"
							name="hero_required" value="<?=$view_row['hero_required']?>"
							style="width: 550px; height: 23px;" />
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1"><span>필수 키워드</span></span>
					</dt>
					<dd>
						<input type="text" id="hero_tag"
							name="hero_tag" value="<?=$view_row['hero_tag']?>"
							style="width: 550px; height: 23px;" />
					</dd>
				</dl>

				<dl>
					<dt>
						<span class="bg1">미션 안내</span>
					</dt>
					<dd>
					<?php if($view_row['hero_guide']){?>
						<textarea name="hero_guide" id="hero_guide" class="textarea" style="width: 550px; height: 150px;"><?=$view_row['hero_guide'];?></textarea>
					<?php }else{ 
						$mission_text = "- 리뷰 등록 시 스폰서 배너를 반드시 부착해주세요.<br/>- 리뷰 제품 배송료(2500원)은 본인 부담입니다.<br/>- 브랜드 요청에 따라서 인원 및 경품이 변경될 수도 있습니다.<br/>- 핸드폰 카메라로 찍은 사진으로 리뷰를 작성하지 않길 부탁드립니다.<br/><br/><span style='color:red;'>* 기간 내 리뷰 미 등록시 페널티가 주어지게 되며, 차후 미션 참여에 불이익을 받을 수 있습니다.</span>";?>
						<textarea name="hero_guide" id="hero_guide" class="textarea" style="width: 550px; height: 150px;"><?=$mission_text ?></textarea>
					<?php }?>
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1">미션 가이드</span>
					</dt>
					<dd>
						<textarea name="hero_help" id="hero_help" class="textarea" style="width: 550px; height: 150px;"><?=$view_row['hero_help'];?></textarea>
					</dd>
				</dl>
				<dl>
					<dt>
						<span class="bg1">리뷰어 신청</span>
					</dt>
					<dd>
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
						<span class="bg1">리뷰어 발표</span>
					</dt>
					<dd>
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
						<span class="bg1">리뷰 등록</span>
					</dt>
					<dd>
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
						<span class="bg1">베스트 발표</span>
					</dt>
					<dd>
						<input type="text" id="sdate4" name="hero_today_04_01"
							value="<?=$view_row['hero_today_04_01']?>" class="input10"
							style="text-align: center" readonly /> <input type="text"
							id="edate4" name="hero_today_04_02"
							value="<?=$view_row['hero_today_04_02']?>" class="input10"
							style="text-align: center" readonly />
					</dd>
				</dl>
				
				
				<dl>
					<dt>
						<span class="bg1">배너를 달아주세요</span>
					</dt>
					<dd>
						<textarea name="hero_banner" id="hero_banner" class="textarea" style="width: 550px; height: 200px;"><?=$view_row['hero_banner'];?></textarea>
					</dd>
				</dl>
				
				<dl id="step_write_question_area" >
					<dt>
						<span class="bg1">신청 시 질문</span>
					</dt>
						<?php 
							$hero_ask = explode("/////",$view_row['hero_ask']);
							$ask_i = 0;
							foreach($hero_ask as $key => $value) {
						?>
								<dd alt="<?=$ask_i?>">
									<textarea class="textarea hero_ask" style="width: 510px; height: 100px;float: left;"><?=$value;?></textarea>
									<div style="width: 33px;float: left;">
										<p class="step_write_plus_btn" onclick="add_question_area();">+</p>
										<p class="step_write_plus_btn" onclick="minus_question_area(<?=$ask_i?>);">-</p>
									</div>
								</dd>
							
						<?php 
								$ask_i++;
							}
						?>
					
				</dl>
				
				<dl>
					<dt>
						<span class="bg1">신청 시 공지사항</span>
					</dt>
					<dd>
						<textarea class="textarea" name="hero_ask_notice" style="width: 550px; height: 100px;"><?=$view_row['hero_ask_notice'];?></textarea>
					</dd>
				</dl>
				  
				<dl>
					<dt>
						<span class="bg1">메인 고정</span>
					</dt>
					<dd>
						<input type="radio" name="hero_notice_use" value="0" <?echo ($view_row['hero_notice_use']!=1)? "checked='checked'" : "" ;?>/> 고정 안함
						<input type="radio" name="hero_notice_use" value="1" <?echo ($view_row['hero_notice_use']==1)? "checked='checked'" : "" ;?>/> 고정
					</dd>
				</dl>
				
				
				<dl>
					<dt>
						<span class="bg1">애경산업 연동 키워드</span>
					</dt>					
					<dd>
						<input name="keyWordStr" type="text"  class="input_re" id="keyWordStr" style="height:22px;" onkeypress="return !(window.event && window.event.keyCode == 13);"/>
						&nbsp;<input name="keyWordAdd" type="button" id="keyWordAdd" value="태그 추가"/>
						<input type="hidden" id="hero_keywords" name="hero_keywords" value="<?=$view_row['hero_keywords']?>"/>
					</dd>
					<dd id="keyWordContainer">
						<?php
						if($view_row['hero_keywords']){
							$hero_keywords = explode(":",$view_row['hero_keywords']);
							for($i=0;$i<sizeof($hero_keywords);$i++){
								echo "<span style='padding:5px;' class='keyWordItem'>".$hero_keywords[$i]." <img src='/image/common/icon_delete.gif' align='absmiddle' class='delkeyWord' onClick='delkeyWord(this);' name='".($i+1)."' style='cursor:pointer;'/></span>";
							}
						}
						?>
					</dd>	
				</dl>	
				<div class="clearfix"></div>
			</div>
			<!--
            <div class="spm_img" style="text-align:center">
                <input type="file" id="hero_img_old" name="hero_img_old" style="width:350px; "/>
            </div>
-->
			<div class="btn_group tc mt60">
				<!--                <a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_00"><img src="../image/bbs/btn_write.gif" alt="" /></a>-->
				<input type="image" src="<?=DOMAIN_END?>image/bbs/btn_confrim2.gif"
					onclick="javascript:return doSubmit(frm);">
<?if(!strcmp($_GET['action'], 'update')){?>
                <a
					href="<?=PATH_HOME.'?'.get('view||action','view=view');?>"><img
						src="../image/bbs/btn_list.gif" alt="목록" /></a>
<?}else{?>
                <a href="<?=PATH_HOME.'?'.get('view||action');?>"><img
						src="../image/bbs/btn_list.gif" alt="목록" /></a>
<?}?>
            
			
			</div>
	
	</div>
	</form>
</div>
<script>
	function ch_count_text_kind(count,id){
		var ids = document.getElementById(id);
		if(count!=frm[id].value.length){
			alert(count+"글자로 입력해주세요.");
			ids.focus();
		}
	};
	function ch_count_text(count,id){
		var ids = document.getElementById(id);
		if(count<frm[id].value.length){
			alert(count+"글자 이내로 입력해주세요.");
			ids.focus();
		}
	};
	function ch_number(id){
		var ids = document.getElementById(id);
		if(isNaN(ids.value)==true){
			alert("숫자만 입력해 주세요.");
			ids.focus();
		}
	};
	
</script>

<script type="text/javascript">
    function doSubmit (theform){
        myeditor.outputBodyHTML();
        var title = theform.hero_title;
        var name = theform.hero_nick;
        var cmd = theform.command;

		var total_ask = "";

		var i_ask = 0;
		
		$('#step_write_question_area').children('dd').each(function( index ) {

			var hero_ask = $(this).children('.hero_ask').val();
			if(hero_ask!=null){
				hero_ask = hero_ask.trim();
				if(i_ask==0)		total_ask += hero_ask;
				else				total_ask += "/////"+hero_ask;
				
				i_ask++;
			}
		});

		$('#hero_ask').val(total_ask);
		//alert(total_ask);
        
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
    var myeditor = new cheditor();              // 에디터 개체를 생성합니다.
    myeditor.config.editorHeight = '300px';     // 에디터 세로폭입니다.
    myeditor.config.editorWidth = '100%';        // 에디터 가로폭입니다.
    myeditor.inputForm = 'editor';             // textarea의 id 이름입니다. 주의: name 속성 이름이 아닙니다.
    myeditor.run();                             // 에디터를 실행합니다.
    </script>



<script>
$(function() {      // window.onload 대신 쓰는 스크립트
    dateclick2();
    dateclick3();
    dateclick4();
    dateclick5();
});
function dateclick2(){
    var dates = $("#sdate1, #edate1").datepicker({
        monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
        defaultDate: null,
        showMonthAfterYear:true,
        dateFormat: 'yy-mm-dd',
        onSelect: function( selectedDate ) {
            var option = this.id == "sdate1" ? "minDate" : "maxDate",
            instance = $( this ).data( "datepicker" ),
            date = $.datepicker.parseDate(
                instance.settings.dateFormat ||
                $.datepicker._defaults.dateFormat,
                selectedDate, instance.settings );
            dates.not( this ).datepicker( "option", option, date );
        }
    });
};
function dateclick3(){
    var dates = $("#sdate2, #edate2").datepicker({
        monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
        defaultDate: null,
        showMonthAfterYear:true,
        dateFormat: 'yy-mm-dd',
        onSelect: function( selectedDate ) {
            var option = this.id == "sdate2" ? "minDate" : "maxDate",
            instance = $( this ).data( "datepicker" ),
            date = $.datepicker.parseDate(
                instance.settings.dateFormat ||
                $.datepicker._defaults.dateFormat,
                selectedDate, instance.settings );
            dates.not( this ).datepicker( "option", option, date );
        }
    });
};
function dateclick4(){
    var dates = $("#sdate3, #edate3").datepicker({
        monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
        defaultDate: null,
        showMonthAfterYear:true,
        dateFormat: 'yy-mm-dd',
        onSelect: function( selectedDate ) {
            var option = this.id == "sdate3" ? "minDate" : "maxDate",
            instance = $( this ).data( "datepicker" ),
            date = $.datepicker.parseDate(
                instance.settings.dateFormat ||
                $.datepicker._defaults.dateFormat,
                selectedDate, instance.settings );
            dates.not( this ).datepicker( "option", option, date );
        }
    });
};
function dateclick5(){
    var dates = $("#sdate4, #edate4").datepicker({
        monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
        defaultDate: null,
        showMonthAfterYear:true,
        dateFormat: 'yy-mm-dd',
        onSelect: function( selectedDate ) {
            var option = this.id == "sdate4" ? "minDate" : "maxDate",
            instance = $( this ).data( "datepicker" ),
            date = $.datepicker.parseDate(
                instance.settings.dateFormat ||
                $.datepicker._defaults.dateFormat,
                selectedDate, instance.settings );
            dates.not( this ).datepicker( "option", option, date );
        }
    });
};
</script>
