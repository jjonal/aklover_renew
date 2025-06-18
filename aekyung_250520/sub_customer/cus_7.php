<?php
if(!defined('_HEROBOARD_'))exit;

$super_check = $_GET['super'];
$tabNum = $_GET['tabNum'];

?>
<div class="contents">
    <!-- story.css -->
    <div class="introduceTab"  style="width: 550px;">
        <ul class="activityTab">
            <li <?=$super_check==""?"class='on'":''?> rel="tab01">체험(제품/포인트)</li>
            <li rel="tab02">품평, FGI/FGD</li>
            <li rel="tab03">설문조사</li>
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
        	<p class="titleText" style="margin-top:30px;"><span class="titleLine">l</span>종류</p>
            
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
        	</div>
        	
        	
        	<p class="titleText" style="margin-top:60px;"><span class="titleLine">l</span>참여 방법</p>
        	
        	<ul>
                <li class="process l1" ><img src="../image2/intro/activity/activityProcess1_on.png" alt="미션참여하기" onclick="clickScroll(0)"/></li>
                <li class="process l2" ><img src="../image2/intro/activity/activityProcess2_on.png" alt="리뷰어신청" onclick="clickScroll(1)"/></li>
                <li class="process l3" ><img src="../image2/intro/activity/activityProcess3_on.png" alt="리뷰등록" onclick="clickScroll(2)"/></li>
                <li class="process l4" ><img src="../image2/intro/activity/activityProcess4_on.png" alt="리뷰어발표" onclick="clickScroll(3)"/></li>
            </ul>
            
            <script>
            $(document).ready(function(){
				$('.process').children('img').on("mouseover",function(){
					//$('.process').children('img').attr('src', $('.process').children('img').attr('src').replace('on','off'));
					$(this).attr('src', $(this).attr('src').replace('on','off'));
				}).on("mouseleave",function(){
					$(this).attr('src', $(this).attr('src').replace('off','on'));
				});

            });
            function clickScroll(n){
				$('html, body').stop().animate({
					scrollTop : $('.target').eq(n).offset().top
				});
			}
            </script>
            <p class="target"><img src="../image2/intro/activity/tab01_missionProcess01.png?v=230509" alt="미션참여하기" usemap="#map1"/></p>
            <p class="target"><img src="../image2/intro/activity/tab01_missionProcess02.png" alt="리뷰어신청"/></p>
            <p class="target"><img src="../image2/intro/activity/tab01_missionProcess03.png" alt="리뷰등록" usemap="#map2"/></p>
            <p class="target"><img src="../image2/intro/activity/tab01_missionProcess04.png" alt="리뷰발표"/></p>
			<map name="map1">
			  <area shape="rect" coords="126,13,233,48" href="https://www.aklover.co.kr/sub_customer/player.php?video=mission_application">
			</map>
			<map name="map2">
			  <area shape="rect" coords="109,9,217,40" href="https://www.aklover.co.kr/sub_customer/player.php?video=mission_latter">
			</map>
      	</div>
      	
        
        <div id="tab02" class="tab_content">
        	<p class="titleText" style="margin-top:30px;"><span class="titleLine">l</span>종류</p>
        	
        	<div class="experienceTypeWrap">
                <div class="list mgt40">
            		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience3.jpg"></div>
            		<div class="text_area">
            			<p class="title">품평, FGI/FGD, HUT</p>
            			<p class="text text_one">- AK LOVER에서 보내주는 품평 제품 사용 후 설문에 참여하는 체험단</p>
            			<p class="txt_emphasis">* 품평 제품은 절대 외부 유출 및 SNS 계정 업로드가 불가합니다.</p>
            		</div>    
            	</div>
        	</div>
        	
        	<p class="titleText" style="margin-top:60px;"><span class="titleLine">l</span>참여 방법</p>
        	
        	<ul>
                <li class="process l1" ><img src="../image2/intro/activity/activityProcess1_on.png" alt="미션참여하기" onclick="clickScroll(4)"/></li>
                <li class="process l2" ><img src="../image2/intro/activity/activityProcess2_on.png" alt="리뷰어신청" onclick="clickScroll(5)"/></li>
                <li class="process l3" ><img src="../image2/intro/activity/activityProcess5_on.png" alt="설문참여" onclick="clickScroll(6)"/></li>
            </ul>
            
            <p class="target"><img src="../image2/intro/activity/tab02_missionProcess01.png?v=230509" alt="미션참여하기" usemap="#map1"/></p>
            <p class="target"><img src="../image2/intro/activity/tab02_missionProcess02.png" alt="리뷰어신청"/></p>
            <p class="target"><img src="../image2/intro/activity/tab02_missionProcess03.png" alt="리뷰등록" usemap="#map2"/></p>
			<map name="map1">
			  <area shape="rect" coords="177,6,284,31" href="https://www.aklover.co.kr/sub_customer/player.php?video=mission_application">
			</map>
			<!-- <map name="map2">
			  <area shape="rect" coords="159,9,263,34" href="/sub_customer/player.php?video=mission_latter">
			</map>-->
        </div>
        
        
        <div id="tab03" class="tab_content">
        	<p class="titleText" style="margin-top:30px;"><span class="titleLine">l</span>종류</p>
        	
        	<div class="experienceTypeWrap">
                <div class="list mgt40">
            		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience4.jpg"></div>
            		<div class="text_area">
            			<p class="title">설문조사</p>
            			<p class="text text_one">- 간단한 온라인 설문 조사 응답</p>
            			<p class="txt_emphasis">* 품평 및 설문조사 설문 URL은 카카오톡 및 문자로 발송 됩니다.</p>
            		</div>    
            	</div>
        	</div>
        	
        	<p class="titleText" style="margin-top:60px;"><span class="titleLine">l</span>참여 방법</p>
        	<ul>
                <li class="process l1" ><img src="../image2/intro/activity/activityProcess6_on.png" alt="미션참여하기" onclick="clickScroll(7)"/></li>
                <li class="process l2" ><img src="../image2/intro/activity/activityProcess7_on.png" alt="리뷰어신청" onclick="clickScroll(8)"/></li>
            </ul>
        	
            <p class="target"><img src="../image2/intro/activity/tab03_missionProcess01.png" alt="미션참여하기"/></p>
            <p class="target"><img src="../image2/intro/activity/tab03_missionProcess02.png" alt="리뷰등록"/></p>
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


