<? 
	include_once "head.php";
	
	
	if(!$_SESSION['temp_code']){
		error_location("�߸��� �����Դϴ�.","/m/joinCheck.php?board=idcheck");
		exit;
	}

$group_sql = " SELECT * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$_GET['board']."' "; // desc
$out_group = new_sql( $group_sql,$error );
if((string)$out_group==$error){
	error_historyBack("");
	exit;
}
$right_list = mysql_fetch_assoc ($out_group);
?>

<link href="/m/css/musign/member.css" rel="stylesheet" type="text/css">
<link href="/m/css/musign/cscenter.css" rel="stylesheet" type="text/css">

<div class="memberWrap mu_member">
	<div id="subpage" class="mypage mypoint">	
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
				<a href="/m/infoauth.php?board=infoauth" class="on">��������</a>
				<a href="/m/pwedit.php?board=pwedit">��й�ȣ ����</a>
				<a href="/m/without.php?board=without">ȸ��Ż��</a>
			</div>
		</div>
	</div>
	<div class="sub_cont replypage">
		<div class="contents right">				
			<div class="member_wrap" style="padding-top: 0;">
				<p class="fz28 today_point">
					ȸ������ ������ �� �����ϰ� ��ȣ�ϱ� ����<br /> �� �� �� ��й�ȣ�� �Է��� �ּ���.
				</p>
				<div class="inner">
					<p class="fz30 bold">��й�ȣ �Է�</p>
					<div>
						<p class="fz28">���� ��й�ȣ</p>
						<input type="password" name="auth_password" placeholder="���� ��й�ȣ�� �Է����ּ���."/>
					</div>							
					<a href="javascript:;"  onClick="fnAuth();" class="btn_black btn_submit">Ȯ��</a>    
				</div>
			</div>		     
		</div>
	</div>  
</div> 
<script>
$(document).ready(function(){
	fnAuth = function() {
		if(!$("input[name='auth_password'").val()) {
			alert('��й�ȣ�� �Է��� �ּ���.');
			$("input[name='auth_password'").focus();
			return;
		}		
	
		var auth_path = $("input[name='auth_password'").val();
		auth_path = auth_path.replace(/&/g, "%26");
		auth_path = auth_path.replace(/\+/g, "%2B");
		auth_path = auth_path.replace(/=/g, "%3D");
		
		var param = "mode=infoauth&auth_password="+auth_path;
			
		$.ajax({
			url:"infoauthAction.php"
			,type:"POST"
			,data:param
			,dataType:"html"
			,success:function(d){
				if(d=="1") {
					location.href = "/m/infoedit.php?board=infoedit";
				} else if(d=="-1"){
					alert("��й�ȣ�� �ٽ� Ȯ���� �ּ���.");
					return;
				} else {
					alert("���� �� �����߽��ϴ�.");
				}
			},error:function(e) {
				console.log(e);
			}
		})
	}
})
</script>
<?include_once "tail.php";?>