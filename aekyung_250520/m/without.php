<? 
	include_once "head.php";
	
	if(!strcmp($_SESSION['temp_code'],'')){error_location('�α����� �ʿ��մϴ�.',"/m/main.php");exit;}
	
	$group_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_REQUEST['board'].'\';';//Ÿ��Ʋ
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
					<div class="btn_back f_cs" onclick="goBack()"><img src="/m/img/musign/main/hd_back.webp" alt="�ڷ� ����"></div>   
					<h1 class="fz36">���� ���� ����</h1>       
				</div>
			</div>  
			<? include_once "mypage_top.php";?> 
		</div>    		
		<div class="boardTabMenuWrap">
			<a href="/m/infoedit.php?board=infoedit">���� ����</a>
			<a href="/m/pwedit.php?board=pwedit">��й�ȣ ����</a>
			<a href="/m/without.php?board=without" class="on">ȸ��Ż��</a>
		</div>
	</div>
	<div class="info_wrap join_input without">
		<div class="info_box">
			<form name="form0" id="form0" onsubmit="return fnWithout()">
				<input type="hidden" name="mode" value="without" />
				<input type="hidden" name="hero_idx" value="<?=$member_list["hero_idx"]?>" />
				<div class="cont">
					<div class="box_line">
						<p class="tit fz26 fw500">*���̵�</p>
						<div class="fz26 fw500"><?=$_SESSION["temp_id"]?></div>
					</div>
					<div class="box_line">
						<p class="tit fz26 fw500">*��й�ȣ</p>
						<div class="fz26 fw500"><input type="password" name="hero_pw" id="hero_pw" value="" title="��й�ȣ" /></div>
					</div>
					<div class="choice">
						<p class="tit fz26 fw500" style="margin-bottom: 1.3rem;">*Ż�����</p>
						<div class="div_tr">
							<div class="div_td">
								<ul>
									<li><p class="input_radio"><input type="radio" name="hero_out_reason" id="hero_out_reason_1" value="1"><label for="hero_out_reason_1">������ ���� ���</label></li>
									<li><p class="input_radio"><input type="radio" name="hero_out_reason" id="hero_out_reason_2" value="2"><label for="hero_out_reason_2">����Ʈ �̿��� �����ؼ�</label></li>
									<li><p class="input_radio"><input type="radio" name="hero_out_reason" id="hero_out_reason_3" value="3"><label for="hero_out_reason_3">���� ��� �� ������ ���� �߻��Ǿ�</label></li>
									<li><p class="input_radio"><input type="radio" name="hero_out_reason" id="hero_out_reason_4" value="4"><label for="hero_out_reason_4">�������� ������ �η�����</label></li>
									<li><p class="input_radio"><input type="radio" name="hero_out_reason" id="hero_out_reason_9" value="9"><label for="hero_out_reason_9">��Ÿ</label></li>
									<textarea cols="89" rows="10" name="hero_out" id="hero_out" placeholder="��������� �Է��� �ּ���." class="w535 mgt10"></textarea>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</form>	
			<div class="btngroup t_c">
				<div class="btn_submit btn_black btn_pop" onClick="chk_submit()">ȸ��Ż�� �ϱ�</div>
			</div>	
		</div>
	</div>
</div>

<!-- ȸ��Ż�� �˾� -->
<div id="without_pop" class="guide_popup" style="display: none;">
    <div class="inner rel t_c">
		<p class="fz34 bold">ȸ�� Ż�� �����Ͻðھ��?</p>
		<p class="fz28 500 desc">Ż���Ͻø� ��� Ȱ�� ����� �����˴ϴ�.<br>
		�׷��� Ż���Ͻðھ��?</p>
		<div class="f_b btngroup">
			<div class="btn_submit btn_gray btn_cancel">���</div>
			<button class="btn_submit btn_black" onClick="fnWithout()">ȸ��Ż�� �ϱ�</button>
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
		alert("��й�ȣ�� �Է��� �ּ���.");
		_formChk.find("input[name='hero_pw']").focus();
		return;
	}
	if(!$("input:radio[name='hero_out_reason']").is(":checked")) {
		alert("Ż�� ������ ������ �ּ���.");
		return;
	}
	if($("input:radio[name='hero_out_reason']:checked").val() == "9") {
		if(!$("#hero_out").val()) {
			alert("��Ÿ ���� �� ��������� �Է��� �ּ���.");
			$("#hero_out").focus();
			return;
		}		
	}	
	$('#without_pop').show();
}

function fnWithout(){
	var _form = $("#form0");
	if(confirm("Ż���Ͻðڽ��ϱ�?")){
		$.ajax({
				url:"withoutAction.php"
				,data:_form.serialize()
				,type:"POST"
				,dataType:"html"
				,success:function(d) {
					if(d=="1") {
						alert("Ż��Ǿ����ϴ�.");
						location.href = "/m/out.php";
					} else if(d=="2") {
						alert("��й�ȣ�� ��Ȯ�� �Է����ּ���.");
					} else {
						alert("���� �� �����߽��ϴ�.");
					}
				},error:function(e) {
					console.log(e);
					alert("�����߽��ϴ�.\n�ٽ� �̿��� �ּ���.");				
				}
			})
	}
}
</script>
<?include_once "tail.php";?>