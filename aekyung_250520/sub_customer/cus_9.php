<?php 
if(!defined('_HEROBOARD_'))exit;

$super_check = $_GET['super'];
$tabNum = $_GET['tabNum'];

?>
<div class="contents">

	<div style="width: 70%; margin: 0 auto;">
		<? include_once BOARD_INC_END.'method.php';?> 
	</div>

	<div style="width: 70%; margin: 0 auto;">
		<? #include_once BOARD_INC_END.'setting_method.php';?>
	</div>

    <!-- story.css -->
    <div class="introduceTab">
        <ul class="activityTab">
            <li <?=$super_check==""?"class='on'":''?> rel="tab01">AK LOVER 가입</li>
            <li rel="tab02">체험단</li>
            <li rel="tab03">수다통/배움통</li>
            <li <?=$super_check=="y"?"class='on'":''?>rel="tab04">게릴라 이벤트</li>
        </ul>
    </div>
    <script type="text/javascript" src="/js/jquery.zclip.min.js"></script>
    <script>
	var super_check = '<?=$super_check?>';
	var tabNum = '<?=$tabNum?>';
    $(document).ready(function(){
		$('.tab_content').hide();
		
		if(super_check == 'y') {
			$('#tab03').show();
		} else if(tabNum == "2"){
			$(".activityTab li").removeClass("on");
			$(".activityTab li").eq(1).addClass("on");
			$('#tab02').show();
		}else {
			$('.tab_content:first').show();
		}
		
		
        $('.activityTab > li').click(function(){
			//탭 on,off
			$('.activityTab').children('li').removeClass('on');
			$(this).addClass('on');
			
			//탭 이동
			$('.tab_content').hide();
			var tabNum = $(this).attr('rel');
			$('#'+tabNum).fadeIn();

			/*
			$('#clipping').zclip({			
				path:'/js/ZeroClipboard.swf', 
				copy:function(){
				return "<a href='http://www.aklover.co.kr/' target='_blank'><img src='http://www.aklover.co.kr/widget.png' width='170' height='170' border='0'></a>";
				}
			});
			*/
        });
		
		// top 버튼 생성
		$( window ).scroll(function() {
		  if ( $(this).scrollTop() > 200 ) {
			$('.top').fadeIn();
		  }else{
			$('.top').fadeOut();
		  }
		});
		
		$('.top').on("click",function() {
		  $('html, body').animate( { scrollTop : 0 }, 400 );
		  return false;
		});

		//베너 복사
		/*
		$("#banner_clipping").on("click",function() {
			$('#banner_clipping').zclip({			
				path:'/js/ZeroClipboard.swf', 
				copy:function(){
				return "<a href='http://aklover.co.kr' target='_blank'><img src='http://www.aklover.co.kr/image2/banner/공정위 문구2.jpg'></a>";
				}
			});
		})
		*/ 
    });
    </script>
    <div id="activity">
        <div id="tab01" class="tab_content">
        	<p class="titleText"><span class="titleLine">l</span>AK LOVER 가입 및 SNS 등록 방법</p>
            
            <p class="titleText3"><span class="numberCircle">1</span>AK LOVER 홈페이지 접속 > [회원가입] 버튼 클릭하여 가입 진행</p>
            <img style="margin-top:10px;" src="../image2/intro/activity/home_guide_tab01_01.jpg" alt="회원가입이미지"/>
            
            <p class="titleText3" style="margin-top:70px;"><span class="numberCircle">2</span>로그인 > 마이페이지 > 회원정보 수정</p>
            <font class="mgl10" color="red">*추가 정보 기입 시 AK LOVER 30 포인트 지급</font>
            <img style="margin-top:10px;" src="../image2/intro/activity/home_guide_tab01_02.jpg" alt="로그인이미지"/>
      	</div>
      	
        
        <div id="tab02" class="tab_content">
            <p class="titleText"><span class="titleLine">l</span>AK LOVER 체험단</p>
            
            <font class="mgl10">*애경의 다양한 제품을 온/오프라인을 통해 직접 체험할 수 있습니다.</font>
            
            <p class="titleText3" style="margin-top:30px;"><span class="numberCircle">1</span>체험단 종류</p>
            <div class="experienceTypeWrap">
            	<div class="list mgt30">
            		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience1.jpg"></div>
            		<div class="text_area">
            			<p class="title">제품 체험</p>
            			<p class="text text_one">- AK LOVER에서 제품 무료 지원으로 진행되는 체험단</p>
            			<p class="txt_emphasis">* 단, 제품 배송비는 본인 부담 (포인트 차감 or 착불 中 선택)</p>
            		</div>    
            		
            	</div>
            	<div class="list mgt40">
            		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience2.jpg"></div>
            		<div class="text_area">
            			<p class="title">포인트 체험</p>
            			<p class="text text_one">- 체험단 내 고지된 오픈 마켓에서 <strong>직접 당첨된 제품을 구매</strong>하여 필수미션 및 권유미션 진행하는 체험단</p>
            			<p class="txt_emphasis">* 구매 비용 환급이 아닌 상품권 및 AK LOVER 포인트로 혜택 지급</p>
            		</div>    
            	</div>
            	<div class="list mgt40">
            		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience3.jpg"></div>
            		<div class="text_area">
            			<p class="title">품평, FGI/FGD, HUT</p>
            			<p class="text text_one">- AK LOVER에서 보내주는 품평 제품 사용 후 설문에 참여하는 체험단</p>
            			<p class="txt_emphasis">* 품평 제품은 절대 외부 유출 및 SNS 계정 업로드가 불가합니다.</p>
            		</div>    
            	</div>
            	<div class="list mgt40">
            		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience4.jpg"></div>
            		<div class="text_area">
            			<p class="title">설문조사</p>
            			<p class="text text_one">- 간단한 온라인 설문 조사 응답</p>
            			<p class="txt_emphasis">* 품평 및 설문조사 설문 URL은 카카오톡 및 문자로 발송 됩니다.</p>
            		</div>    
            	</div>
            </div>
            
            <p class="titleText3" style="margin-top:70px;"><span class="numberCircle">2</span>애경 브랜드</p>
            <img style="margin-top:10px;" src="../image2/intro/activity/home_guide_tab02_01.jpg" alt="애경브랜드이미지"/>
        </div>
        
        
        <div id="tab03" class="tab_content">
        	<p class="titleText"><span class="titleLine">l</span>수다통</p>
            <font class="mgl10">*AK LOVER 회원분들의 일상, 체험단, 활동 관련 등 다양한 이야기를 나누는 공간</font>
            <img style="margin-top:10px;" src="../image2/intro/activity/home_guide_tab03_01.jpg" alt="수다통이미지"/>
            
            <p class="titleText" style="margin-top:70px;"><span class="titleLine">l</span>배움통</p>
            <font class="mgl10">*SNS 기능을 비롯한 다양한 체험단 후기 작성 꿀팁을 배울 수 있는 공간</font>
            <img style="margin-top:10px;" src="../image2/intro/activity/home_guide_tab03_02.jpg" alt="배움통이미지"/>
        </div>
        
        
        <div id="tab04" class="tab_content">
	        <p class="titleText" style="margin-bottom:20px;"><span class="titleLine">l</span>AK LOVER 게릴라 이벤트</p>
            <font class="mgl10">*매주 수요일에 진행되는 쉽고 간단한 이벤트</font>
            
            <p class="titleText3" style="margin-top:30px;"><span class="numberCircle">1</span>AK LOVER 공식 인스타그램 팔로우 <a href="https://www.instagram.com/aekyunglover/" style="color:blue">(@aekyunglover)</a></p>
            <img style="margin-top:10px;" src="../image2/intro/activity/home_guide_tab04_01.jpg" alt="회원가입이미지"/>
            
            <p class="titleText3" style="margin-top:70px;"><span class="numberCircle">2</span>매주 수요일에 업로드 되는 이벤트 확인 후 댓글로 정답 작성</p>
            <font class="mgl10" color="red">(+ 친구 태그, 스토리 및 피드에 업로드)</font>
            <img style="margin-top:10px;" src="../image2/intro/activity/home_guide_tab04_02.jpg" alt="로그인이미지"/>
        </div>
        <a href="#" class="top">TOP &and;</a>
    </div>
</div>
</div> <!--footer-->
<script>
function fnDownBanner(num) {
	if(confirm("공정위 배너를 필수로 기재 부탁드립니다.")){
		location.href= "/sub_customer/downBanner.php?gubun="+num;
	}
}

var clipboard = new Clipboard('.btn_clip');
clipboard.on('success', function(e) {
	alert("복사 되었습니다. 블로그 등에 소스 붙여넣기 해주세요~");
    console.log(e);
});
clipboard.on('error', function(e) {
    console.log(e);
});

var clipboard2 = new Clipboard('.btn_clip2');
clipboard2.on('success', function(e) {
	alert("복사 되었습니다. 블로그 등에 소스 붙여넣기 해주세요~");
    console.log(e);
});
clipboard2.on('error', function(e) {
    console.log(e);
});

</script>

