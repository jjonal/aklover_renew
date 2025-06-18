<? include_once "head.php";?> 
<link href="css/aklover.css?v=230501" rel="stylesheet" type="text/css">
<?
$group_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_REQUEST['board'].'\';';//desc
$out_group = @mysql_query($group_sql);
$right_list                             = @mysql_fetch_assoc($out_group);
?>
<? include_once "boardIntroduce.php"; ?>

<div style="clear:both"></div>


<div id="line"></div>
<div id="love1">
<?
	if($_REQUEST["board"]=="group_04_32"){
?>
	<div class="introduceTab">
        <ul class="activityTab">
            <li class="on" rel="tab01">AK LOVER 가입</li>
            <li rel="tab02">체험단</li>
            <li rel="tab03">수다통/배움통</li>
            <li rel="tab04">게릴라 이벤트</li>
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
    	<p class="titleText"><span class="titleLine">l</span>AK LOVER 가입 및 SNS 등록 방법</p>
            
        <p class="titleText3"><span class="numberCircle">1</span>AK LOVER 홈페이지 접속 > [회원가입] 버튼 클릭하여 가입 진행</p>
        <img style="display: block; margin: auto; max-width: 80%; height: auto;" src="../image2/intro/activity/home_guide_tab01_01.jpg" alt="회원가입이미지"/>
        
        <p class="titleText3" style="margin-top:70px;"><span class="numberCircle">2</span>로그인 > 마이페이지 > 회원정보 수정</p>
        <font class="mgl10" color="red">*추가 정보 기입 시 AK LOVER 30 포인트 지급</font>
        <img style="margin-top:10px;" src="../image2/intro/activity/home_guide_tab01_02.jpg" alt="로그인이미지"/>
    </div>
    
    <div id="tab02" class="tab_content">
    	<p class="titleText" style="margin-bottom:20px;"><span class="titleLine">l</span>AK LOVER 체험단</p>
        <font class="mgl10">*애경의 다양한 제품을 온/오프라인을 통해 직접 체험할 수 있습니다.</font>
        
        <p class="titleText3" style="margin-top:30px;"><span class="numberCircle">1</span>체험단 종류</p>
        <div class="experienceTypeWrap">
        	<div class="list mgt30">
        		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience1.jpg"></div>
        		<div class="text_area">
        			<p class="title">제품 체험</p>
        			<p class="text text_one">- AK LOVER에서 제품 무료 지원으로 진행되는 체험단</p>
        			<p class="txt_emphasis" style="margin-top:5px;">* 단, 제품 배송비는 본인 부담 (포인트 차감 or 착불 中 선택)</p>
        		</div>    
        		
        	</div>
        	<div class="list mgt20">
        		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience2.jpg"></div>
        		<div class="text_area">
        			<p class="title">포인트 체험</p>
        			<p class="text text_one">- 체험단 내 고지된 오픈 마켓에서 <strong>직접 당첨된 제품을 구매</strong>하여 필수미션 및 권유미션 진행하는 체험단</p>
        			<p class="txt_emphasis" style="margin-top:5px;">* 구매 비용 환급이 아닌 상품권 및 AK LOVER 포인트로 혜택 지급</p>
        		</div>    
        	</div>
        	<div class="list mgt20">
        		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience3.jpg"></div>
        		<div class="text_area">
        			<p class="title">품평, FGI/FGD, HUT</p>
        			<p class="text text_one">- AK LOVER에서 보내주는 품평 제품 사용 후 설문에 참여하는 체험단</p>
        			<p class="txt_emphasis" style="margin-top:5px;">* 품평 제품은 절대 외부 유출 및 SNS 계정 업로드가 불가합니다.</p>
        		</div>    
        	</div>
        	<div class="list mgt20">
        		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience4.jpg"></div>
        		<div class="text_area">
        			<p class="title">설문조사</p>
        			<p class="text text_one">- 간단한 온라인 설문 조사 응답</p>
        			<p class="txt_emphasis" style="margin-top:5px;">* 품평 및 설문조사 설문 URL은 카카오톡 및 문자로 발송 됩니다.</p>
        		</div>    
        	</div>
        </div>
        
        <p class="titleText3" style="margin-top:70px;"><span class="numberCircle">2</span>애경 브랜드</p>
        <img style="margin-top:10px;" src="../image2/intro/activity/home_guide_tab02_01.jpg"  width="100%" alt="애경브랜드이미지"/>
    </div>
    
    <div id="tab03" class="superpassProcess tab_content">
    	<p class="titleText"><span class="titleLine">l</span>수다통</p>
        <font class="mgl10">*AK LOVER 회원분들의 일상, 체험단, 활동 관련 등 다양한 이야기를 나누는 공간</font>
        <img style="margin-top:10px;" src="../image2/intro/activity/home_guide_tab03_01.jpg" alt="수다통이미지"/>
        
        <p class="titleText" style="margin-top:70px;"><span class="titleLine">l</span>배움통</p>
        <font class="mgl10">*SNS 기능을 비롯한 다양한 체험단 후기 작성 꿀팁을 배울 수 있는 공간</font>
        <img style="margin-top:10px;" src="../image2/intro/activity/home_guide_tab03_02.jpg" alt="배움통이미지"/>
    </div>
    
    <div id="tab04" class="superpassProcess tab_content">
	    <p class="titleText" style="margin-bottom:20px;"><span class="titleLine">l</span>AK LOVER 게릴라 이벤트</p>
        <font class="mgl10">*매주 수요일에 진행되는 쉽고 간단한 이벤트</font>
        
        <p class="titleText3" style="margin-top:30px;"><span class="numberCircle">1</span>AK LOVER 공식 인스타그램 팔로우 <a href="https://www.instagram.com/aekyunglover/"  style="color:blue">(@aekyunglover)</a></p>
        <img style="margin-top:10px;" src="../image2/intro/activity/home_guide_tab04_01.jpg" alt="회원가입이미지"/>
        
        <p class="titleText3" style="margin-top:70px;"><span class="numberCircle">2</span>매주 수요일에 업로드 되는 이벤트 확인 후 댓글로 정답 작성</p>
        <font class="mgl10" color="red">(+ 친구 태그, 스토리 및 피드에 업로드)</font>
        <img style="margin-top:10px;" src="../image2/intro/activity/home_guide_tab04_02.jpg" alt="로그인이미지"/>
    </div>
</div>


<?php 
}elseif($_REQUEST["board"]=="group_04_01"){
?>          
	<div id="akloverIntro">
        <p class="titleText"><span class="titleLine">l</span>애경 서포터즈 AK LOVER란?</p>
        <div class="toptext">
            <!-- p class="toptitle">애경 서포터즈 AK LOVER란?</p -->
            <p class="topcontent">
                애경의 다양한 제품들을 직접 사용 후 <span>진정성</span> 있는 온라인 활동을 통해
                애경과 함께 생각하고 소통하는 서포터즈입니다.<br/>
                누구나 가입 후 애경 서포터즈 AK LOVER로 활동하실 수 있으며,
                다양한 애경 <span>제품 체험</span>과 특별한 혜택을 누리실 수 있습니다.
            </p>
            <p style="margin:20px 0 0 0;">
                <a href="/m/truly.php?board=group_04_13" class="box">AK LOVER의 진정성</a>
                <a href="/m/aklover.php?board=group_04_15" class="box">체험단 참여방법</a>
            </p>
        </div>
        
        
        <p class="titleText" style="margin-top:50px;"><span class="titleLine">l</span>AK LOVER 활동 혜택</p>
        <p class="titleText2">AK LOVER가 되시면 다양한 혜택을 누리실 수 있습니다.</p>
        <ul>
            <li>
                <div class="icon_area">
                    <img src="../image2/intro/aklover/iwhy_001.jpg"/>
                </div>
                <div class="text_area">
                    <p class="title">제품 체험</p>
                    <p class="text text_one">- 애경의 다양한 제품을 직접 사용 후 진정성 있는 후기 작성</p>
                </div>    
            </li>
            <li>
                <div class="icon_area">
                    <img src="../image2/intro/aklover/iwhy_002.jpg"/>
                </div>
                <div class="text_area">
                    <p class="title">게릴라 이벤트</p>
                    <p class="text text_one">- 부담없이 즐기는 쉬운 이벤트로 당첨 시, 다양한 혜택 제공</p>
                </div>    
            </li>
            <li>
                <div class="icon_area">
                    <img src="../image2/intro/aklover/iwhy_003.jpg"/>
                </div>
                <div class="text_area">
                    <p class="title">슈퍼패스 이용권</p>
                    <p class="text text_one">- 모든 체험단에 우선적으로 선정 가능한 이용권</p>
                    <p class="text">- 지급 대상 : 1개월 이내 AK LOVER 게시글 작성 및 블로그 or 인스타그램을 운영하는 AK LOVER 회원</p>
                    <p class="text">- 지급 시기 : 매월 첫 번째 로그인 시 자동 지급 </p>
                    <p class="text">- 체험단 선정 인원의 10%만 선착순 사용 가능</p>
				    <p class="text">- 사용 후 취소할 수 없으며, 매 월 마지막 날 사용하지 않은 슈퍼패스는 자동 소멸 </p>
					<p class="text mgt10 txt_emphasis">※ 참고사항</p>
					<p class="text txt_emphasis">이중 ID 또는 3개월 이내 페널티가 확인될 경우 슈퍼패스가 발급되지 않습니다.</p>
                </div>    
            </li>
            <li>
                <div class="icon_area">
                    <img src="../image2/intro/aklover/iwhy_005.jpg"/>
                </div>
                <div class="text_area">
                    <p class="title">소비자 참여 프로그램</p>
                    <p class="text text_one">- FGI/FGD, HUT, 좌담회, 제품 품평 등</p>
                </div>    
            </li>
        </ul>

        <ul>
            <li>
                <div class="icon_area">
                    <img src="../image2/intro/aklover/iwhy_010.jpg"/>
                </div>
                <div class="text_area">
                    <p class="title">포인트 축제</p>
                    <p class="text text_one">- AK LOVER 활동으로 적립된 포인트로 연 1회 원하는 애경의 제품으로 교환</p>
                    <p class="text">- Loyal AK LOVER, Beauty Club, Life Club은 추가 진행</p>
                </div>    
            </li>
            <li>
                <div class="icon_area">
                    <img src="../image2/intro/aklover/iwhy_008.jpg"/>
                </div>
                <div class="text_area">
                    <p class="title">AK LOVER`s Day</p>
                    <p class="text text_one">- 한 해동안 AK LOVER 회원들의 적극적인 활동에 감사드리는 마음을 담아 준비한 신년파티</p>
                    <p class="text">- 우수자포상</p>
                    <p class="text">- 매년 AK LOVER의 생일(1월 14일)에 진행</p>
                    <p class="text">&nbsp;&nbsp;*상황에 따라 날짜 변경</p>
                </div>    
            </li>
            <li>
                <div class="icon_area">
                    <img src="../image2/intro/aklover/iwhy_009.jpg"/>
                </div>
                <div class="text_area">
                    <p class="title">Loyal AK LOVER</p>
                    <p class="text text_one">- 월 별 우수회원으로 선정된 AK LOVER로<br/>특별 혜택 제공</p>
                    <p class="text">- 인원 : 20명</p>
                    <p class="text">- 특별 혜택 : 5만원 백화점 상품권 제공</p>
                    
                    <p class="text" style="margin-left:66px;">포인트 축제 1회 추가 진행</p>
                    
                    <p class="text">[선정 기준]</p>
                    <p class="text">블로그 or 인스타 계정 有</p>
                    <p class="text">전월 체험단 후기 1회 이상 작성</p>
                    <p class="text">고퀄리티 및 진정성 있는 컨텐츠 작성</p>
                    <p class="text">전월 AK LOVER 참여도(체험단, 설문조사, 온/오프라인 모임, 적립 포인트, 글 작성 등)</p>
                    <p class="text">3개월 내 Loyal AK LOVER 선정자 제외 등 </p>
            </li>
            <li>
                <div class="icon_area">
                    <img src="../image2/intro/aklover/iwhy_012.jpg"/>
                </div>
                <div class="text_area">
                    <p class="title">AK LOVER 포인트<br/>2,000점</p>
                    <p class="text text_one">- 각 체험단 우수자로 선정되면 AK LOVER 포인트 2,000점 제공</p>
                    <p class="text">(일부 체험단 우수자 혜택 변경 가능)</p>

                </div>    
            </li>
        </ul>
        
        <div class="adminKyunga">
            <p class="title"><span style="font-size:11px;">애경 서포터즈</span> AK LOVER 관리자 <span>'경아'</span><p><br/>
            <p class="content">
                사랑(愛)과 존경(敬)의 애경(愛敬)의 이름에서 나온 경(敬)아는
                애경 서포터즈 AK LOVER 여러분들과 친근하게 소통하는 관리자 이름입니다.
            </p>
            
        </div>
    </div>
</div>
<?php 
}elseif($_REQUEST["board"]=="group_04_02"){
?>

    <div class="introduceTab">
        <ul class="pointTab">
            <li class="on" rel="tab01">1. 포인트 가이드</li>
            <li rel="tab02">2. 회원 등급</li>
            <li rel="tab03">3. 포인트 축제</li>
        </ul>
    </div>
    <script>
    $(document).ready(function(){
        $('.tab_content').hide();
        $('.tab_content:first').show();
        
        $('.pointTab > li').click(function(){
            //탭 on,off
            $('.pointTab').children('li').removeClass('on');
            $(this).addClass('on');
            
            //탭 이동
            $('.tab_content').hide();
            var tabNum = $(this).attr('rel');
            $('#'+tabNum).fadeIn();
        });

        <? if($_REQUEST["selectTab"]) {?>
        	$('.pointTab > li').eq('<?=$_REQUEST["selectTab"];?>').click();
        <? } ?>
    });
    </script>
    
    <style>
		.guide_main { font-size: 15.5px;padding: 7% 0 6% 5%;font-weight: 800;letter-spacing: -0.7px;line-height: 30px; }
		.guide_main span { color:#EC6022;font-size:22px; }
		
		.guide_2 { border-top: 2px solid #9B9B9B;border-bottom: 1px solid #9B9B9B;width: 100%;text-align: center;font-size: 1em;font-weight: 800;margin: 20px 0; }
		.guide_2 tr { height: 38px; }
		.guide_2 tr td { border: 1px solid #EBE2DC;border-bottom: 0px;padding: 15px 0; }
		
		#guide_2_1 { padding:10px; }
		#guide_2_1 li { font-size: 13px;font-weight: 800; }
		
		#guide_2_2 { border-top: 2px solid #9B9B9B;border-bottom: 1px solid #9B9B9B;width: 100%;text-align: center;font-size: 13px;font-weight: 800;margin: 20px 0; }
		#guide_2_2 tr { height: 30px; }
		#guide_2_2 tr td { border: 1px solid #EBE2DC;border-left: 0px;border-bottom: 0px; }
		#guide_2_2 tr td.first { background:#FEF2E8; }
		#guide_2_2 tr td.last { border-right:0px; }
		#guide_2_2 tr td img { position: relative;width: 25px;top: 4px; }
		
		.col-xs-10 { padding:0px;margin-right: 1%; }
		@media screen and (min-width:768px){
			.col-sm-12-space { height:20px;float:left; }
		}
	</style>
	<div id="tab01" class="tab_content">

		<div class="col-sm-12-space col-sm-12"></div>
		<p class="titleText"><span class="titleLine">l</span>포인트 지급</p>
		<table class="guide_2">
			<tr style="background: #FDE6D2;font-size:14px;height:40px;">
				<td style="width: 19%;">구 분</td>
				<td style="width: 44%;">활동 내용</td>
				<td style="width: 15%">Point</td>
			</tr>
			<tr >
				<td rowspan="5" >홈페이지</td>
				<td>출석체크<br> (해당 월 모두 출석시 +50)</td>
				<td>1</td>
			</tr>
			<tr>
				<td>댓글 작성</td>
				<td>1</td>
			</tr>
			<tr >
				<td>게시글 작성</td>
				<td >2</td>
			</tr>
			<!-- <tr >
				<td>러버아이디어(하루 1회만 글작성 가능합니다)</td>
				<td>3</td>
			</tr>-->
			<tr>
				<td>신규회원 추천</td>
				<td>500</td>
			</tr>
			<tr>
				<td>회원가입 후 첫 로그인</td>
				<td>500</td>
			</tr>
		</table>
        
        <ul id="guide_2_1">
            <li><img src="/image2/etc/guide2_4_heart.gif">&nbsp;&nbsp;하루에 얻을 수 있는 포인트는 <span style="color:#FF6600;">총 20점</span>으로 한정됩니다.</li>
            <li style="margin-bottom:20px;"><img src="/image2/etc/guide2_4_heart.gif">&nbsp;&nbsp;상황에 따라 추가 포인트 지급이 가능합니다.</li>
        </ul>
        
        <div style="clear:both;"></div>
        
        <p class="titleText"><span class="titleLine">l</span>포인트 차감</p>
        <table class="guide_2">
            <tr style="background: #FDE6D2;font-size:14px;height:40px;">
                <td style="width: 19%;">구 분</td>
				<td style="width: 44%;">활동 내용</td>
				<td style="width: 15%">Point</td>
            </tr>
            <tr>
                <td rowspan="4" >체험단</td>
                <td>후기 미작성</td>
                <td>-1,000</td>
            </tr>
            <tr>
                <td>기간 내 체험단 후기 미등록</td>
                <td>-500</td>
            </tr>
            <tr>
                <td>체험단 가이드라인 미준수</td>
                <td>-500</td>
            </tr>
            <tr>
                <td>오프라인 모임 미참석 시</td>
                <td>-1,000</td>
            </tr>
            <tr >
                <td rowspan="5">게시판</td>
                <td rowspan="3">욕설, 폭언, 남에게 피해주는 게시글 등</td>
                <td>-50<br>(1차)</td>
            </tr>
            <tr >
                <td>-100<br>(2차)</td>
            </tr>
            <tr >
                <td style="letter-spacing: -1.2px;">강제<br>탈퇴<br>(3차)</td>
            </tr>
            <tr >
                <td rowspan="2">컨텐츠 도용 및 복사글</td>
                <td>-100<br>(1차)</td>
            </tr>
            <tr >
                <td style="letter-spacing: -1.2px;">강제<br>탈퇴<br>(2차)</td>
            </tr>
        </table>
        
        <ul id="guide_2_1">
            <li style="margin-bottom:20px;"><img src="/image2/etc/guide2_4_heart.gif">&nbsp;&nbsp;후기 미작성 및 오프라인 모임 미참석으로 1,000P 차감되신 분들은 3개월 간 체험단 선정에서 제외됩니다.</li>
        </ul>
       
        
        <p class="titleText"><span class="titleLine">l</span>포인트 확인</p>
        <img src="/m/img/intro/point/m_pointCheck.png" width="100%"/>
        <ul id="guide_2_1">
               <li><img src="/image2/etc/guide2_4_heart.gif">&nbsp;&nbsp;가용 포인트 : 포인트 축제 기간 '제품 교환 가능한 포인트'이며, 포인트 축제 이후 남은 가용 포인트는 일괄 소멸 처리 됩니다.</li>
        </ul>
        <div style="clear:both;"></div>
    </div>
    
    <div id="tab02" class="tab_content">
    	<p class="titleText"><span class="titleLine">l</span>회원 등급</p>

    	<table id="guide_2_2">
            <tr style="background: #FDE6D2;font-size:14px;height:35px;">
                <td style="width: 16%">레벨</td>
                <td style="width: 39%">포인트</td>
                <td class="last" style="width: 17%">아이콘</td>
            </tr>
            <tr style="height: 75px;">
                <td class="first">AK LOVER</td>
                <td>AK LOVER 가입한 모든 회원</td>
                <td class="last"><img src="/image/bbs/lev1.png"></td>
            </tr>
            <tr style="height: 75px;">
                <td class="first">Beauty Club</td>
                <td>AK LOVER <br/>Beauty Club으로 선정된 회원</td>
                <td class="last"><img src="/image/bbs/lev_BeautyHolic.png"></td>
            </tr>
            <tr style="height: 75px;">
                <td class="first">Life Club</td>
                <td>AK LOVER <br/>Life Club으로 선정된 회원</td>
                <td class="last"><img src="/image/bbs/lev_life.png"></td>
            </tr>
            <tr style="height: 75px;">
                <td class="first">Global Club</td>
                <td>AK LOVER <br/>Global Club으로 선정된 회원<br/><span style="color:#f00;">※별도 내부 운영정책으로 진행됨</span></td>
                <td class="last"><img src="/image/bbs/lev_global.png"></td>
            </tr>
        </table>
    </div>
    
     <div id="tab03" class="tab_content">
            <p class="titleText"><span class="titleLine">l</span>포인트 축제</p>
            <div class="pointPestival"><span><img src="/image2/etc/guide2_4_heart.gif"></span>매년 1회 애경 서포터즈 AK LOVER 활동을 통해 적립된 포인트로 애경 제품을 교환 할 수 있는 축제입니다.<br/>(Loyal AK LOVER는 포인트 축제 추가 진행 되며, 보다 적은 포인트로 다양한 제품 교환 가능)</div>
            <p>
            	<span class="black">1. 포인트 축제 기간 : </span>포인트 축제는 게릴라 성으로 불시에 진행됩니다.<br/>
                <span class="black">2. 참여대상 : </span>AK LOVER 회원 전원<br/>
                <span class="black">3. 구매 목록 확인 : </span><br/>
                	&nbsp;&nbsp;&nbsp;&nbsp;- 진행 중: 체험단/이벤트 → 포인트 축제 → 내 구매내역<br/>
					&nbsp;&nbsp;&nbsp;&nbsp;- 종료 후: 마이페이지 → 포인트축제 구매내역<br/>
                <span class="black">4. 포인트 소멸 : </span>전체 회원을 위한 포인트 축제 이후 남은 가용 포인트는 일괄 소멸 처리 됩니다.
            </p>
            <img class="mgt10" src="/image2/intro/point/pointFestival2.png" width="100%"/>
    	</div>
    
<?php 
}elseif($_REQUEST["board"]=="group_03_01"){
?>

	
    <!--
	<div class="introduceTab">
        <ul class="storyTab">
            <li class="on" rel="tab01">About 애경</li>
            <li rel="tab02">지속가능경영</li
            <li rel="tab03">디자인경영</li>
        </ul>
    </div>
    -->
    <script>
    $(document).ready(function(){
        $('.tab_content').hide();
        $('.tab_content:first').show();
        
        $('.storyTab > li').click(function(){
            //탭 on,off
            $('.storyTab').children('li').removeClass('on');
            $(this).addClass('on');
            
            //탭 이동
            $('.tab_content').hide();
            var tabNum = $(this).attr('rel');
            $('#'+tabNum).fadeIn();
        });
    });
    </script>
    <div style="float:right">
        <a href="http://www.aekyung.co.kr" target="_blank"><img src="../image2/introduc_goak.jpg" /></a>
    </div>
    
    <div class="aboutAekyung">
        <div id="tab01" class="tab_content">
          <img src="../m/img/intro/aekyung/aekyungIntro_2022.png" alt="애경소개" class="mgt40"/>
          <img src="../image2/intro/aekyung/t1_about_000_2020.jpg" alt="About애경" class="mgt40"/>
          <img src="../image2/intro/aekyung/t1_about_01.jpg" alt="About애경1" class="mgt60"/>
          <img src="../image2/intro/aekyung/t1_about_02.jpg" alt="About애경2" class="mgt60"/>
        </div>
        
        <div id="tab02" class="tab_content">
          <img src="../m/img/intro/aekyung/aekyungIntro.png" alt="애경소개" class="mgt40"/>
          <img src="../image2/intro/aekyung/t2_CSR_01.jpg" alt="지속가능경영1" class="mgt40"/>
          <img src="../image2/intro/aekyung/t2_CSR_02.jpg" alt="지속가능경영2" class="mgt60"/>
        </div>
        
        <div id="tab03" class="tab_content">
          <img src="../m/img/intro/aekyung/aekyungIntro.png" alt="애경소개" class="mgt40"/>
          <img src="../image2/intro/aekyung/t3_design.jpg" alt="디자인경영" class="mgt40"/>
        </div>
        
        
     </div>
 </div>


<?php } ?>
</div>
<script>
function fnDownBanner(num) {
	if(confirm("공정위 배너를 필수로 기재 부탁드립니다.")){
		location.href= "/sub_customer/downBanner.php?gubun="+num;
	}
}
</script>
<!--컨텐츠 종료-->
<?include_once "tail.php";?>