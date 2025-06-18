<? include_once "head.php";?> 
<link href="css/aklover.css?v=230503" rel="stylesheet" type="text/css">
<!--컨텐츠 시작-->
<?
$group_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_REQUEST['board'].'\';';//desc
$out_group = @mysql_query($group_sql);
$right_list                             = @mysql_fetch_assoc($out_group);
?>
<? include_once "boardIntroduce.php"; ?>

<div style="clear:both"></div>

<div id="line"></div>
<div id="love1">
	<div class="introduceTab">
        <ul class="activityTab">
            <li class="on" rel="tab01">체험(제품/포인트)</li>
            <li rel="tab02">품평, FGI/FGD</li>
            <li rel="tab03">설문조사</li>
        </ul>
    </div>
    <script type="text/javascript" src="/js/clipboard.min.js"></script>
    <script>
    $(document).ready(function(){
		$('.tab_content').hide();
		$('.tab_content:first').show();
		
        $('.activityTab > li').click(function(){
			//탭 on,off
			$('.activityTab').children('li').removeClass('on');
			$(this).addClass('on');
			
			//탭 이동
			$('.tab_content').hide();
			var tabNum = $(this).attr('rel');
			$('#'+tabNum).fadeIn();
			
			var clipboard = new Clipboard('.btn');
			
			clipboard.on('success', function(e) {
				alert('복사되었습니다.');
			});
			
			clipboard.on('error', function(e) {
				var result = window.prompt(" 기본 위젯 코드를 복사해주세요!", "<a href='http://www.aklover.co.kr/' target='_blank'><img src='http://www.aklover.co.kr/widget.png' width='170' height='170' border='0'></a>");
			});
			
        });

        <? if($_REQUEST["selectTab"]) { ?>
       	 $('.activityTab > li').eq('<?=$_REQUEST["selectTab"]?>').click();
        <? } ?>

         

        $("#banner_clipping").on("click",function(){

        	console.log("click");
            
			var clipboard = new Clipboard('#banner_clipping');
			
			clipboard.on('success', function(e) {
				alert('복사되었습니다.');
			});
			
			clipboard.on('error', function(e) {
				var result = window.prompt("공정위 배너코드를 복사해 주세요!", "<a href='http://aklover.co.kr' target='_blank'><img src='http://www.aklover.co.kr/image2/banner/공정위 문구2.jpg'></a>");
			});
        })
    });
    </script>

    <div id="tab01" class="missionProcess tab_content">
    	<p class="titleText" style="margin-top:30px;"><span class="titleLine">l</span>종류</p>
    	<div class="experienceTypeWrap">
        	<div class="list mgt30">
        		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience1.jpg"></div>
        		<div class="text_area">
        			<p class="title">제품 체험</p>
        			<p class="text text_one">- AK LOVER에서 제품 무료 지원으로 진행되는 체험단</p>
        			<p class="txt_emphasis" style="margin-top:5px;">* 단, 제품 배송비는 본인 부담 (포인트 차감 or 착불 中 선택)</p>
        		</div>    
        		
        	</div>
        	<div class="list mgt40">
        		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience2.jpg"></div>
        		<div class="text_area">
        			<p class="title">포인트 체험</p>
        			<p class="text text_one">- 체험단 내 고지된 오픈 마켓에서 <strong>직접 당첨된 제품을 구매</strong>하여 필수미션 및 권유미션 진행하는 체험단</p>
        			<p class="txt_emphasis" style="margin-top:5px;">* 구매 비용 환급이 아닌 상품권 및 AK LOVER 포인트로 혜택 지급</p>
        		</div>    
        	</div>
    	</div>
    	
    	<p class="titleText" style="margin-top:30px;"><span class="titleLine">l</span>참여 방법</p>
    	<ul>
            <li class="process l1"><img src="../image2/intro/activity/activityProcess1_on.png" alt="미션참여하기" onclick="clickScroll(0)"/></li>
            <li class="process arrow"><img src="../image2/intro/activity/activityArrow.png"/></li>
            <li class="process l2"><img src="../image2/intro/activity/activityProcess2_on.png" alt="리뷰어신청" onclick="clickScroll(1)"/></li>
            <li class="process arrow"><img src="../image2/intro/activity/activityArrow.png"/></li>
            <li class="process l3"><img src="../image2/intro/activity/activityProcess3_on.png" alt="리뷰등록" onclick="clickScroll(2)"/></li>
            <li class="process arrow"><img src="../image2/intro/activity/activityArrow.png"/></li>
            <li class="process l4"><img src="../image2/intro/activity/activityProcess4_on.png" alt="리뷰어발표" onclick="clickScroll(3)"/></li>
        </ul>
        <script>
		function clickScroll(n){
			$('html, body').stop().animate({
				scrollTop : $('.target').eq(n).offset().top
			});
		}
		</script>
		<style>
		.imagemap{position:relative;width:device-width;}
		.area1{position:absolute; top: 0.3%; left: 29%; width: 17%; height: 2%;}
		.area2{position:absolute; top: 0.3%; left: 25.5%; width: 17%; height: 2%;}
		</style>
        <p class="target imagemap">
        	<img src="../image2/intro/activity/tab01_missionProcess01.png?v=230509" alt="미션참여하기"/>
        	<a href="https://www.aklover.co.kr/sub_customer/player.php?video=mission_application" class="area1"></a>
        </p>
        <p class="target"><img src="../image2/intro/activity/tab01_missionProcess02.png" alt="리뷰어신청"/></p>
        <p class="target imagemap">
        	<img src="../image2/intro/activity/tab01_missionProcess03.png" alt="리뷰등록"/>
        	<a href="https://www.aklover.co.kr/sub_customer/player.php?video=mission_latter" class="area2"></a>
        </p>
        <p class="target"><img src="../image2/intro/activity/tab01_missionProcess04.png" alt="리뷰발표"/></p>
    </div>
    
    
    <div id="tab02" class="missionProcess tab_content">
    	<p class="titleText" style="margin-top:30px;"><span class="titleLine">l</span>종류</p>
    	<div class="experienceTypeWrap">
        	<div class="list mgt40">
        		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience3.jpg"></div>
        		<div class="text_area">
        			<p class="title">품평, FGI/FGD, HUT</p>
        			<p class="text text_one">- AK LOVER에서 보내주는 품평 제품 사용 후 설문에 참여하는 체험단</p>
        			<p class="txt_emphasis" style="margin-top:5px;">* 품평 제품은 절대 외부 유출 및 SNS 계정 업로드가 불가합니다.</p>
        		</div>    
        	</div>
    	</div>
    	
    	<p class="titleText" style="margin-top:30px;"><span class="titleLine">l</span>참여 방법</p>
    	<ul>
            <li class="process l1"><img src="../image2/intro/activity/activityProcess1_on.png" alt="미션참여하기" onclick="clickScroll(4)"/></li>
            <li class="process arrow"><img src="../image2/intro/activity/activityArrow.png"/></li>
            <li class="process l2"><img src="../image2/intro/activity/activityProcess2_on.png" alt="리뷰어신청" onclick="clickScroll(5)"/></li>
            <li class="process arrow"><img src="../image2/intro/activity/activityArrow.png"/></li>
            <li class="process l3"><img src="../image2/intro/activity/activityProcess5_on.png" alt="리뷰등록" onclick="clickScroll(6)"/></li>
        </ul>
        <script>
		function clickScroll(n){
			$('html, body').stop().animate({
				scrollTop : $('.target').eq(n).offset().top
			});
		}
		</script>
		<style>
		.imagemap{position:relative;width:device-width;}
		.area1{position:absolute; top: 0.3%; left: 29%; width: 17%; height: 2%;}
		.area2{position:absolute; top: 0.3%; left: 25.5%; width: 17%; height: 2%;}
		</style>
        <p class="target imagemap">
        	<img src="../image2/intro/activity/tab02_missionProcess01.png?v=230509" alt="미션참여하기"/>
        	<a href="https://www.aklover.co.kr/sub_customer/player.php?video=mission_application" class="area1"></a>
        </p>
        <p class="target"><img src="../image2/intro/activity/tab02_missionProcess02.png" alt="리뷰어신청"/></p>
        <p class="target"><img src="../image2/intro/activity/tab02_missionProcess03.png" alt="리뷰발표"/></p>
    </div>
    
    
    <div id="tab03" class="missionProcess tab_content">
    	<p class="titleText" style="margin-top:30px;"><span class="titleLine">l</span>종류</p>
    	<div class="experienceTypeWrap">
        	<div class="list mgt40">
        		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience4.jpg"></div>
        		<div class="text_area">
        			<p class="title">설문조사</p>
        			<p class="text text_one">- 간단한 온라인 설문 조사 응답</p>
        			<p class="txt_emphasis" style="margin-top:5px;">* 품평 및 설문조사 설문 URL은 카카오톡 및 문자로 발송 됩니다.</p>
        		</div>    
        	</div>
    	</div>
    	
    	<p class="titleText" style="margin-top:30px;"><span class="titleLine">l</span>참여 방법</p>
    	<ul>
            <li class="process l1"><img src="../image2/intro/activity/activityProcess6_on.png" alt="미션참여하기" onclick="clickScroll(7)"/></li>
            <li class="process arrow"><img src="../image2/intro/activity/activityArrow.png"/></li>
            <li class="process l2"><img src="../image2/intro/activity/activityProcess7_on.png" alt="리뷰어신청" onclick="clickScroll(8)"/></li>
        </ul>
        <script>
		function clickScroll(n){
			$('html, body').stop().animate({
				scrollTop : $('.target').eq(n).offset().top
			});
		}
		</script>
		<style>
		.imagemap{position:relative;width:device-width;}
		.area1{position:absolute; top: 0.3%; left: 29%; width: 17%; height: 2%;}
		.area2{position:absolute; top: 0.3%; left: 25.5%; width: 17%; height: 2%;}
		</style>
        <p class="target imagemap">
        	<img src="../image2/intro/activity/tab03_missionProcess01.png?v=230509" alt="미션참여하기"/>
        	<a href="https://www.aklover.co.kr/sub_customer/player.php?video=mission_application" class="area1"></a>
        </p>
        <p class="target"><img src="../image2/intro/activity/tab03_missionProcess02.png" alt="리뷰어신청"/></p>
    </div>
</div>        

</div>
<script>
function fnDownBanner(num) {
	if(confirm("공정위 배너를 필수로 기재 부탁드립니다.")){
		location.href= "/sub_customer/downBanner.php?gubun="+num;
	}
}
</script>
<!--컨텐츠 종료-->
<!--컨텐츠 종료-->
<?include_once "tail.php";?>