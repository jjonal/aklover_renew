<? 
	include_once "head.php";
	
	
	if(!$_SESSION['temp_code']){
		error_location("잘못된 접근입니다.","/m/joinCheck.php?board=idcheck");
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
					<div class="btn_back f_cs" onclick="goBack()"><img src="/m/img/musign/main/hd_back.webp" alt="뒤로 가기"></div>   
					<h1 class="fz36">나의 정보 변경</h1>       
				</div>
			</div>  
			<? include_once "mypage_top.php";?> 
		</div>
		<div class="boardTabMenuWrap">
				<a href="/m/infoauth.php?board=infoauth" class="on">정보변경</a>
				<a href="/m/pwedit.php?board=pwedit">비밀번호 변경</a>
				<a href="/m/without.php?board=without">회원탈퇴</a>
			</div>
		</div>
	</div>
	<div class="sub_cont replypage">
		<div class="contents right">				
			<div class="member_wrap" style="padding-top: 0;">
				<p class="fz28 today_point">
					회원님의 정보를 더 안전하게 보호하기 위해<br /> 한 번 더 비밀번호를 입력해 주세요.
				</p>
				<div class="inner">
					<p class="fz30 bold">비밀번호 입력</p>
					<div>
						<p class="fz28">현재 비밀번호</p>
						<input type="password" name="auth_password" placeholder="현재 비밀번호를 입력해주세요."/>
					</div>							
					<a href="javascript:;"  onClick="fnAuth();" class="btn_black btn_submit">확인</a>    
				</div>
			</div>		     
		</div>
	</div>  
</div> 
<script>
$(document).ready(function(){
	fnAuth = function() {
		if(!$("input[name='auth_password'").val()) {
			alert('비밀번호를 입력해 주세요.');
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
					alert("비밀번호를 다시 확인해 주세요.");
					return;
				} else {
					alert("진행 중 실패했습니다.");
				}
			},error:function(e) {
				console.log(e);
			}
		})
	}
})
</script>
<?include_once "tail.php";?>