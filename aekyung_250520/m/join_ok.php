<?
// echo '123';
// if(!defined('_HEROBOARD_'))exit;
// if($_SESSION["temp_code"]) {
// 	error_location("로그인 상태입니다.\\n올바른 경로로 이용해 주세요.","/main/index.php");
// }
?>
<!-- <? include_once "head.php";?>  -->
<link href="/m/css/musign/member.css" rel="stylesheet" type="text/css">
	<div class="contents_area join_ok join_wrap mu_member"> 
    <div class="page_title t_c">
        <h2 class="fz48 fw500 main_c">회원가입</h2>
		<p class="subtit fz12">AK Lover의 다양한 서포터즈를 경험하세요!</p>
		<div class="bread">
			<ul class="f_c">
				<li>본인인증</li>
				<li class="arr"><img src="/img/front/icon/bread.webp" alt="화살표"></li>
				<li class="joinstep">이용약관 동의</li>
				<li class="join_arr arr"><img src="/img/front/icon/bread.webp" alt="화살표"></li>
				<li class="joinstep">계정 생성(필수)</li>
				<!-- <li class="join_arr arr"><img src="/img/front/icon/bread.webp" alt="화살표"></li><br /> -->
			</ul>
			<ul class="f_c">				
				<!-- <li class="joinstep">계정 생성(선택)</li> -->
				<li class="join_arr arr"><img src="/img/front/icon/bread.webp" alt="화살표"></li>
				<li class="joinstep on">회원가입 완료</li>
			</ul>
		</div>
    </div>
        <div class="contents">
            <div class="maincont">
                <img src="/img/front/member/heart.webp" alt="회원가입 완료">
                <p class="desc fz28 fw600">
                    <!--!!!!!!!! [개발요청] 가입 아이디 노출 [완]!!!!!!!!  -->	
                    <span><?=$_GET["id"]?></span> 님, 회원가입을 축하드립니다!<br />
                    회원가입 완료 후, 다시 로그인이 필요합니다.
                </p>
                <p class="fz14 gray fw600">* 프로필 완성하고 추가 포인트 적립하세요!</p>
                <div>
                    <div class="btn_bx f_c">
						<a class="btn_submit btn_white" href="/">홈화면으로</a>
						<a class="btn_submit btn_black" href="/m/login.php">로그인 하기</a>
					</div>
                </div>
            </div>
            <a href="/" class="btn_submit btn_main_c btn_guide f_b">
                <span class="fz13 fw600">AK Lover 가 처음이신가요?</span>
                <span class="fz13 f_c">이용백서 보러가기 <img src="/img/front/member/arr.webp" alt="화살표"></span>
            </a>
        </div>
    </div>
<?include_once "tail.php";?>
<script>
$(document).ready(function(){})
</script>
