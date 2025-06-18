<? include_once "head.php";?> 
<link href="css/aklover.css?v=1" rel="stylesheet" type="text/css">
<!--컨텐츠 시작-->


<!--
<div id="title">
	<p>
		<?php if($_REQUEST["board"]=="group_04_01"){?>AK LOVER란?
		<?php }elseif($_REQUEST["board"]=="group_04_02"){?>포인트/등급
		<?php }elseif($_REQUEST["board"]=="group_03_01"){?>애경소개
		<?php }elseif($_REQUEST["board"]=="group_04_15"){?>체험단 참여방법
		<?php }?>
    </p>
</div>-->
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
	if($_REQUEST["board"]=="group_04_15"){
?>
	<div class="introduceTab">
        <ul class="activityTab">
            <li class="on" rel="tab04">1. 공정위 문구</li>
            <li rel="tab03">2. 슈퍼패스</li>
            <li rel="tab02">3. 위젯</li>
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
	
	<div id="tab04" class="superpassProcess tab_content">
	    <p class="titleText"><span class="titleLine">l</span>블로그/인스타그램 후기 공정위 문구</p>
        <p class="mgl10 letter07">
            	 공정거래위원회 표시광고법 지침에 따라 제품을 제공받아 후기를 작성하실 경우,
				대가성 여부를 표시하는 것을 규정상 원칙으로 하고 있습니다. (유가의 고료 지급이 아닌 물품체험단 포함)<br/><br/>
				따라서 체험단에 당첨되어 블로그/ 인스타그램 후기를 작성할 때, 공정위 문구를 꼭! 기입하셔야 합니다.<br/>
				- 블로그 : 배너 삽입 <br/>
				- 인스타그램 : 문구 삽입<br/>
        </p>
        
    	<div class="bannerWrap">
    		<p class="titleText mgt40"><span class="titleLine">l</span>블로그 공정위 배너 & 배너코드 </p>
    		<p class="txt"><strong>* 일반 체험단</strong></p>
            <p class="img"><img src="../image2/intro/activity/aklover_gov_ban_220215.jpg" alt="" /></p>
            
            <p class="txt mgt40">
                 	&lt;p&gt;&lt;a href=&quot;http://www.aklover.co.kr&quot; target=&quot;_blank&quot;&gt;<br />
					&lt;img src=&quot;http://www.aklover.co.kr/image2/공정위문구.jpg&quot;&gt;&lt;/a&gt;&lt;/p&gt;
            </p>
            
             <p style="text-align:center; margin-bottom:40px;"><a href="javascript:;" onClick="fnDownBanner(1)" style="display:inline-block;  margin:10px 0 0 0; text-align:center; width:30%; height:30px; line-height:30px; background:#f68427; color:#fff; font-size:16px;"/>배너 다운받기</a>
               <a href="javascript:;"  id="banner_clipping" style="display:inline-block; margin:10px 0 0 20px; text-align:center; width:30%; height:30px; line-height:30px; background:#f68427; color:#fff; font-size:16px;" data-clipboard-text="<a href='http://www.aklover.co.kr' target='_blank'><img src='http://www.aklover.co.kr/image2/공정위문구.jpg'></a>"/>코드 복사</a>
            </p>
            
            <p class="txt"><strong>* 포인트 체험단</strong></p>
            <p class="img"><img src="/image2/banner_point_04_05.jpg" alt="" /></p>
            
            <p class="txt mgt40">
                 	&lt;p&gt;&lt;a href=&quot;http://www.aklover.co.kr&quot; target=&quot;_blank&quot;&gt;<br />
					&lt;img src=&quot;http://www.aklover.co.kr/image2/banner_point_04_05.jpg&quot;&gt;&lt;/a&gt;&lt;/p&gt;
            </p>
            
             <p style="text-align:center; margin-bottom:40px;"><a href="javascript:;" onClick="fnDownBanner(2)" style="display:inline-block;  margin:10px 0 0 0; text-align:center; width:30%; height:30px; line-height:30px; background:#f68427; color:#fff; font-size:16px;"/>배너 다운받기</a>
               <a href="javascript:;"  id="banner_clipping" style="display:inline-block; margin:10px 0 0 20px; text-align:center; width:30%; height:30px; line-height:30px; background:#f68427; color:#fff; font-size:16px;" data-clipboard-text="<a href='http://www.aklover.co.kr' target='_blank'><img src='http://www.aklover.co.kr/image2/공정위문구.jpg'></a>"/>코드 복사</a>
            </p>
            
            <p class="titleText mgt40"><span class="titleLine">l</span>인스타그램 공정위 문구 </p>
            <p class="txt" style="margin-bottom:40px;">
            	<strong>* 일반 체험단</strong>: 본문 최상단에 <span class="red">‘AK LOVER 제품 지원‘</span> 문구를 꼭 작성해주세요.<br/>
				<strong>* 포인트 체험단</strong>: 본문 최상단에 <span class="red">‘AK LOVER 상품권 및 혜택 지급‘</span> 문구를 꼭 작성해주세요
            </p>
            
        	<p class="titleText"><span class="titleLine">l</span>블로그 스마트 2.0 배너 올리는 법</p>
            
        	<p class="txt letter07">1. 글작성 창 오른쪽 하단 <span>'HTML'</span>를 클릭해주세요!</p>
            <p class="img"><img src="../image2/intro/activity/bnr_m_img1.jpg" alt="" /></p>
            
            <p class="txt mgt40 letter07">2. 체험단 페이지 내 배너 소스코드를 드래그 후 'Ctrl + C'를 눌러 복사해 주세요.</p>
            <p class="img"><img src="../image2/intro/activity/bnr_m_img2_210504.png" alt="" /></p>
            
            <p class="txt mgt40 letter07">3. 원하시는 위치에 배너 소스코드를 Ctrl + V를 눌러 붙여넣기 해주세요.</p>
            <p class="img"><img src="../image2/intro/activity/bnr_m_img3.jpg" alt="" /></p>
            
            <p class="txt mgt40 letter07">4. 그리고 다시 오른쪽 하단 <span>'Editor'</span> 클릭하면 화면에 배너 이미지가 생성 됩니다.</p>
            <p class="img"><img src="../image2/intro/activity/bnr_m_img4_210504.png" alt="" /></p>
            
            <p class="titleText mgt40"><span class="titleLine">l</span>블로그 스마트 3.0 배너 올리는 법</p>
            
            <p class="txt mgt40 letter07">1. 체험단 페이지 내 공정위 배너를 드래그 후 Ctrl + C를 눌러 복사해주세요!</p>
            <p class="img"><img src="../image2/intro/activity/30_ban_001_210504.jpg" alt="" /></p>
           
            
            <p class="txt mgt40 letter07">2. 글작성 창에 Ctrl + V를 눌러 붙여넣기 해주세요! <br/> 그럼 이렇게 배너 이미지가 생성됩니다!</p>
            <p class="txt_emphasis">※ 본 배너는 예시 이미지로 체험단 별 상이할 수 있으니, 반드시 진행하는 체험단 페이지에서 확인 부탁드립니다.</p>
            <p class="img"><img src="../image2/intro/activity/30_ban_002_210504.jpg" alt="" /></p>
            
        </div>
    </div>
    
    <div id="tab02" class="tab_content">
        	<div class="widgetType">
           		<p class="titleText"><span class="titleLine">l</span>위젯 이란</p>
                <p class="mgl10 letter07">
                	본인의 블로그에서 웹 브라우저를 통하지 않고 바로 AK LOVER 홈페이지로 이동할 수 있도록 만든 바로가기 아이콘
                </p>
                
                <p class="titleText" style="margin-top:20px;"><span class="titleLine">l</span>위젯 종류</p>
                <p class="mgl10 letter07">
                	AK LOVER를 널리 알리고 쉽게 방문할 수 있도록 본인의 블로그에 AK LOVER 위젯 설치하는 방법을 알려드립니다.<br/>
                    먼저, AK LOVER는 기본위젯, 우수 서포터즈 위젯으로 구분해서 제공해드려요<br/><br/>
                    <span class="black">기본위젯</span>은 <span class="juhwang">누구나 위젯코드를 복사</span>해서 등록하시고,
                    <span class="black">10년 이상 활동 회원 위젯</span>은 홈페이지 가입 후 <span class="juhwang">10년 이상 열심히 활동하신 회원 분</span>에게
                    관리자 경아가 쪽지를 통해 위젯 코드를 발송해 드리고 있습니다.
                </p>
                <p style="text-align:center"><img src="../image2/intro/activity/widgetImg.png" alt="위젯이미지"/></p>
                <!--<img class="widgetCopy" src="../image2/intro/activity/widgetCopy.png" alt="코드 복사하기"/>
                <img class="widgetText" src="../image2/intro/activity/widgetText2.png" alt="50레벨위젯설명"/>-->
            </div>
            
            <div class="widgetInsert">
            	<p class="titleText "><span class="titleLine">l</span>위젯 설치 프로세스</p>
                <ul>
                    <li class="widget l1"><img src="../image2/intro/activity/widgetProcess1_on.png" alt="위젯코드 복사하기" onclick="widgetClickScroll(0)"/></li>
                    <li class="widget arrow"><img src="../image2/intro/activity/activityArrow.png"/></li>
                    <li class="widget l2"><img src="../image2/intro/activity/widgetProcess2_on.png" alt="위젯코드 하러가기" onclick="widgetClickScroll(1)"/></li>
                    <li class="widget arrow"><img src="../image2/intro/activity/activityArrow.png"/></li>
                    <li class="widget l3"><img src="../image2/intro/activity/widgetProcess3_on.png" alt="위젯코드 붙혀넣기" onclick="widgetClickScroll(2)"/></li>
                    <li class="widget arrow"><img src="../image2/intro/activity/activityArrow.png"/></li>
                    <li class="widget l4"><img src="../image2/intro/activity/widgetProcess4_on.png" alt="위젯코드 완료"onclick="widgetClickScroll(3)"/></li>
                </ul>
                <script>
				function widgetClickScroll(n){
					$('html, body').stop().animate({
						scrollTop : $('.widgetTarget').eq(n).offset().top
					});
				}
				</script>
                
                <p class="widgetTarget" style="margin-top:100px;"><img src="../image2/intro/activity/widgetProcess01.png" alt="위젯코드 복사하기" usemap="#Map" border="0"/>
                <p style="text-align:center">
                	<a href="#" class="btn" style="margin:0;padding:0;" data-clipboard-text="<a href='http://www.aklover.co.kr/' target='_blank'><img src='http://www.aklover.co.kr/widget.png' width='170' height='170' border='0'></a>">
	                	<img src="../image2/intro/activity/widgetClip.png" alt="코드복사 하기" id="clipping"> 
                    </a>
                </p>
                  
                </p>
                <p class="widgetTarget"><img src="../image2/intro/activity/widgetProcess02.png" alt="위젯코드 하러가기"/></p>
                <p class="widgetTarget"><img src="../image2/intro/activity/widgetProcess03.png" alt="위젯코드 붙혀넣기"/></p>
                <p class="widgetTarget"><img src="../image2/intro/activity/widgetProcess04.png" alt="위젯코드 완료"/></p>
            </div>
        </div>
    
    <div id="tab03" class="superpassProcess tab_content">
    	<div class="superpass">
            <div>
                <p class="titleText"><span class="titleLine">l</span>슈퍼패스란?</p>
				<style>
					.superpass .icon_area{text-align:center;}
                    .superpass .icon_area img{width:50%;}
                    .superpass .text_area{width:100%; word-break:break-all; margin-left:10px; line-height:20px; margin-right:0;}
                    .superpass .red{color:#f00;}
                </style>
                <div class="icon_area">
                    <img src="/image2/superpass_marik_2.jpg?v=230511" />
                </div>
                <div class="text_area">
                	<p>리본 메뉴가  <span class="red">제품 체험인 체험단</span>에 우선 선정될 수 있는 서비스 기능을 <span class="red">‘슈퍼패스’</span>라고 해요!</p>
                	
                	<p class="mgt10">
                    		* 지급: 매 월 첫 번째 로그인 시 1회권 지급<br/>
							* 지급 조건<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- 1개월 이내에 AK LOVER 게시글 작성 회원<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- 네이버 블로그 or 인스타그램 or 영상채널(네이버TV, Youtube, 틱톡 등) 운영 회원<br/>
                    	</p>
                	

                    
                    <p style="margin-top:20px;">
                        - 체험단 선정 인원의 10%만 선착순 사용 가능<br/>
                        - 사용 후 취소할 수 없으며, 매 월 마지막 날 사용하지 않은 슈퍼패스는 자동 소멸<br/><br/>
                        <span class="red">※ 참고사항<br/>이중 ID 또는 3개월 이내 페널티가 확인될 경우 슈퍼패스가 발급되지 않습니다.</span>
                    </p>
                </div>
            </div>
            
            <div>
                <p class="titleText mgt40"><span class="titleLine">l</span>슈퍼패스 확인 방법</p>
                <p><img src="../image2/intro/activity/superpassProcess03.png"/></p>
            </div>
            
            <div>
                <p class="titleText mgt40"><span class="titleLine">l</span>슈퍼패스 사용 방법</p>
                <p><img src="../image2/intro/activity/superpassProcess02.png"/></p>
            </div>
            
            
        </div>
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
                    <p class="text text_one">- 월별 우수회원으로 선정된 AK LOVER로 특별 혜택 제공</p>
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
          <!-- <img src="../image2/intro/aekyung/t1_about_000_2020.jpg" alt="About애경" class="mgt40"/>  -->
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