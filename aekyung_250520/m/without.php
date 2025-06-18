<? 
	include_once "head.php";
	
	if(!strcmp($_SESSION['temp_code'],'')){error_location('로그인이 필요합니다.',"/m/main.php");exit;}
	
	$group_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_REQUEST['board'].'\';';//타이틀
	$out_group = @mysql_query($group_sql);
	$right_list                             = @mysql_fetch_assoc($out_group);
	
	$member_sql =  " select * from member where hero_id= '".$_SESSION['temp_id']."' ";
	$out_member_sql = mysql_query($member_sql);
	$member_list                             = @mysql_fetch_assoc($out_member_sql);
	
?>


<link href="/m/css/musign/member.css" rel="stylesheet" type="text/css">
<link href="/m/css/musign/cscenter.css" rel="stylesheet" type="text/css">


<div class="memberWrap mu_member mypage">
	<div id="subpage" class="mypoint">	
		<div class="my_top off">    
			<div class="sub_title">       
				<div class="sub_wrap">  
					<div class="btn_back f_cs" onclick="goBack()"><img src="/m/img/musign/main/hd_back.webp" alt="뒤로 가기"></div>   
					<h1 class="fz36">나의 정보 변경</h1>       
				</div>
			</div>  
			<? include_once "mypage_top.php";?> 
		</div>    		
		<div class="boardTabMenuWrap">
			<a href="/m/infoedit.php?board=infoedit">정보 변경</a>
			<a href="/m/pwedit.php?board=pwedit">비밀번호 변경</a>
			<a href="/m/without.php?board=without" class="on">회원탈퇴</a>
		</div>
	</div>
	<div class="info_wrap join_input without">
		<div class="info_box">
			<form name="form0" id="form0" onsubmit="return fnWithout()">
				<input type="hidden" name="mode" value="without" />
				<input type="hidden" name="hero_idx" value="<?=$member_list["hero_idx"]?>" />
				<div class="cont">
					<div class="box_line">
						<p class="tit fz26 fw500">*아이디</p>
						<div class="fz26 fw500"><?=$_SESSION["temp_id"]?></div>
					</div>
					<div class="box_line">
						<p class="tit fz26 fw500">*비밀번호</p>
						<div class="fz26 fw500"><input type="password" name="hero_pw" id="hero_pw" value="" title="비밀번호" /></div>
					</div>
					<div class="choice">
						<p class="tit fz26 fw500" style="margin-bottom: 1.3rem;">*탈퇴사유</p>
						<div class="div_tr">
							<div class="div_td">
								<ul>
									<li><p class="input_radio"><input type="radio" name="hero_out_reason" id="hero_out_reason_1" value="1"><label for="hero_out_reason_1">정보가 별로 없어서</label></li>
									<li><p class="input_radio"><input type="radio" name="hero_out_reason" id="hero_out_reason_2" value="2"><label for="hero_out_reason_2">사이트 이용이 불편해서</label></li>
									<li><p class="input_radio"><input type="radio" name="hero_out_reason" id="hero_out_reason_3" value="3"><label for="hero_out_reason_3">서비스 장애 및 지연이 자주 발생되어</label></li>
									<li><p class="input_radio"><input type="radio" name="hero_out_reason" id="hero_out_reason_4" value="4"><label for="hero_out_reason_4">개인정보 유출이 두려워서</label></li>
									<li><p class="input_radio"><input type="radio" name="hero_out_reason" id="hero_out_reason_9" value="9"><label for="hero_out_reason_9">기타</label></li>
									<textarea cols="89" rows="10" name="hero_out" id="hero_out" placeholder="불편사항을 입력해 주세요." class="w535 mgt10"></textarea>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</form>	
			<div class="btngroup t_c">
				<div class="btn_submit btn_black btn_pop" onClick="chk_submit()">회원탈퇴 하기</div>
			</div>	
		</div>
	</div>
</div>

<!-- 회원탈퇴 팝업 -->
<div id="without_pop" class="guide_popup" style="display: none;">
    <div class="inner rel t_c">
		<p class="fz34 bold">회원 탈퇴를 진행하시겠어요?</p>
		<p class="fz28 500 desc">탈퇴하시면 모든 활동 기록이 삭제됩니다.<br>
		그래도 탈퇴하시겠어요?</p>
		<div class="f_b btngroup">
			<div class="btn_submit btn_gray btn_cancel">취소</div>
			<button class="btn_submit btn_black" onClick="fnWithout()">회원탈퇴 하기</button>
    	</div>
    </div>	
</div>

<script>
$(document).ready(function(){
	$("input[type='password']").keydown(function(e){
		if(e.keyCode === 13) event.preventDefault();
	});
	$('#without_pop .btn_cancel').click(function(){
		$('#without_pop').hide();
	});	
})

function chk_submit(form) {
	var _formChk = $("#form0");
	if(!_formChk.find("input[name='hero_pw']").val()) {
		alert("비밀번호를 입력해 주세요.");
		_formChk.find("input[name='hero_pw']").focus();
		return;
	}
	if(!$("input:radio[name='hero_out_reason']").is(":checked")) {
		alert("탈퇴 사유를 선택해 주세요.");
		return;
	}
	if($("input:radio[name='hero_out_reason']:checked").val() == "9") {
		if(!$("#hero_out").val()) {
			alert("기타 선택 시 불편사항을 입력해 주세요.");
			$("#hero_out").focus();
			return;
		}		
	}	
	$('#without_pop').show();
}

function fnWithout(){
	var _form = $("#form0");
	if(confirm("탈퇴하시겠습니까?")){
		$.ajax({
				url:"withoutAction.php"
				,data:_form.serialize()
				,type:"POST"
				,dataType:"html"
				,success:function(d) {
					if(d=="1") {
						alert("탈퇴되었습니다.");
						location.href = "/m/out.php";
					} else if(d=="2") {
						alert("비밀번호를 정확히 입력해주세요.");
					} else {
						alert("실행 중 실패했습니다.");
					}
				},error:function(e) {
					console.log(e);
					alert("실패했습니다.\n다시 이용해 주세요.");				
				}
			})
	}
}
</script>
<?include_once "tail.php";?>