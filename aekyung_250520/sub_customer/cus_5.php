<?php 
if(!defined('_HEROBOARD_'))exit;

$super_check = $_GET['super'];
$tabNum = $_GET['tabNum'];

?>
<div class="contents">
    <!-- story.css -->
    <div class="introduceTab" style="width: 550px;">
        <ul class="activityTab">
            <li <?=$super_check==""?"class='on'":''?> rel="tab01">1. 공정위 문구</li>
            <li rel="tab02">2. 슈퍼패스</li>
            <li rel="tab03">3. 위젯</li>
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
        
        <div id="tab03" class="tab_content">
        	<div class="widgetType">
           		<p class="titleText"><span class="titleLine">l</span>위젯 이란</p>
                <p class="mgl10">
                	본인의 블로그에서 웹 브라우저를 통하지 않고 바로 AK LOVER 홈페이지로 이동할 수 있도록 만든 바로가기 아이콘
                </p>

                <p class="titleText" style="margin-top:30px;"><span class="titleLine">l</span>위젯 종류</p>
                <p class="mgl10">
                	다양한 혜택과 즐거움이 가득한 AK LOVER를 널리 알리고 쉽게 방문할 수 있도록 본인의 블로그에 AK LOVER 위젯 설치하는 방법을 알려드립니다.
                    <br/>
                    <br/>
                    <span class="black">기본위젯</span>은 <span class="juhwang">누구나 위젯코드를 복사</span>해서 등록하시고,<br/>
                    <span class="black">10년 이상 활동 회원 위젯</span>은 홈페이지 가입 후 <span class="juhwang">10년 이상 열심히 활동하신 회원 분</span>에게<br/>
                    관리자 경아가 위젯 코드를 쪽지로 발송해드리고 있습니다.
                </p>
                
                <p class="mgl70 mgt40"><img src="../image2/intro/activity/widgetImg.png" alt="위젯이미지"/></p>
                <!--<img class="widgetCopy" src="../image2/intro/activity/widgetCopy.png" alt="코드 복사하기"/>
                <img class="widgetText" src="../image2/intro/activity/widgetText2.png" alt="50레벨위젯설명"/>-->
            </div>
            
            <div class="widgetInsert">
            	<p class="titleText "><span class="titleLine">l</span>위젯 설치 프로세스</p>
                <ul>
                	<li class="widgetProcess w1" ><img src="../image2/intro/activity/widgetProcess1_on.png" alt="위젯코드 복사하기" onclick="widgetClickScroll(0)"/></li>
                	<li class="widgetProcess w2" ><img src="../image2/intro/activity/widgetProcess2_on.png" alt="위젯코드 하러가기" onclick="widgetClickScroll(1)"/></li>
               		<li class="widgetProcess w3" ><img src="../image2/intro/activity/widgetProcess3_on.png" alt="위젯코드 붙혀넣기" onclick="widgetClickScroll(2)"/></li>
                	<li class="widgetProcess w4" ><img src="../image2/intro/activity/widgetProcess4_on.png" alt="위젯코드 완료" onclick="widgetClickScroll(3)"/></li>
            	</ul>
                <script>
				$(document).ready(function(){
					$('.widgetProcess').children('img').on("mouseover",function(){
						$(this).attr('src', $(this).attr('src').replace('on','off'));
						
					}).on("mouseleave",function(){
						$(this).attr('src', $(this).attr('src').replace('off','on'));
					});
	
				});
				function widgetClickScroll(n){
					$('html, body').stop().animate({
						scrollTop : $('.widgetTarget').eq(n).offset().top
					});
				}
				</script>
                <p class="widgetTarget"><img src="../image2/intro/activity/widgetProcess01.png" alt="위젯코드 복사하기" usemap="#Map" border="0"/>
              
                <p style="text-align:center">
                	<img src="../image2/intro/activity/widgetClip.png" alt="코드복사 하기" style="margin:20px 0 0 20px; cursor:pointer" class="btn_clip" data-clipboard-text="<a href='http://www.aklover.co.kr/' target='_blank'><img src='http://www.aklover.co.kr/widget.png' width='170' height='170' border='0'></a>"  />
				</p>
                  
                </p>
                <p class="widgetTarget"><img src="../image2/intro/activity/widgetProcess02.png" alt="위젯코드 하러가기"/></p>
                <p class="widgetTarget"><img src="../image2/intro/activity/widgetProcess03.png" alt="위젯코드 붙혀넣기"/></p>
                <p class="widgetTarget"><img src="../image2/intro/activity/widgetProcess04.png" alt="위젯코드 완료"/></p>
            </div>
            
        </div>
        
        <div id="tab02" class="tab_content">
        	<div class="superpass">
                <div>
                    <p class="titleText"><span class="titleLine">l</span>슈퍼패스란?</p>
                    <style>
						
					</style>
                    <div class="icon_area">	
                    	<div class="thumbArea">
                    		<div class="thumbnail">
	                    		<img src="/image2/superpass_marik_2.jpg?v=230511" width="190" / style="float:left; padding-right:20px;vertical-align:middle;">
	                    	</div>
	                    	<div class="text">
		                    	<p style="line-height:24px; font-size:15px; padding-top:18px;">리본 메뉴가  <span class="red">제품 체험인 체험단</span>에 우선 선정될 수 있는 서비스 기능을<br/>
		                    	<span class="red">‘슈퍼패스’</span>라고 해요!</p>
		                    	
		                    	<p class="mgt10" style="line-height:24px; font-size:15px; padding-top:18px;">
		                    		* 지급: 매 월 첫 번째 로그인 시 1회권 지급<br/>
									* 지급 조건<br/>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- 1개월 이내에 AK LOVER 게시글 작성 회원<br/>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- 블로그 or 인스타그램 운영 회원<br/>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- 네이버 블로그 or 인스타그램 or 영상채널(네이버TV, Youtube, 틱톡 등)<br/>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 운영 회원
		                    	</p>
		                    	
		                    	<p class="mgt10" style="line-height:24px; font-size:15px; padding-top:18px;">* 사용 안내</p>
		                    	
		                    	<p>
                        			- 체험단 선정 인원의 10%만 선착순 사용 가능<br/>
                            		- 사용 후 취소할 수 없으며, 매 월 마지막 날 사용하지 않은 슈퍼패스는 자동 소멸<br/><br/>
                            		
                          		  <span class="red">※ 참고사항<br/>이중 ID 또는 3개월 이내 페널티가 확인될 경우 슈퍼패스가 발급되지 않습니다.</span>
                        		</p>
							</div>
						</div>
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
        
        <div id="tab01" class="tab_content">
	        <p class="titleText"><span class="titleLine">l</span>블로그/인스타그램 후기 공정위 문구</p>
            <p class="mgl10" style="margin-bottom:50px;">
              	 공정거래위원회 표시광고법 지침에 따라 제품을 제공받아 후기를 작성하실 경우,<br/>
				대가성 여부를 표시하는 것을 규정상 원칙으로 하고 있습니다. (유가의 고료 지급이 아닌 물품체험단 포함)<br/><br/>
				따라서 체험단에 당첨되어 블로그/ 인스타그램 후기를 작성할 때, 공정위 문구를 꼭! 기입하셔야 합니다.<br/>
				- 블로그 : 배너 삽입 <br/>
				- 인스타그램 : 문구 삽입<br/>
				
            </p>
            
        	<div class="bannerWrap">
            	<!--
                <p class="txt">1. 체험단 페이지 내 공정위 배너를 드래그 후 'Ctrl + C'를 눌러<br/>&nbsp;&nbsp;&nbsp;복사해주세요!</p>
                <p class="img_pos"><img src="../image2/intro/activity/bnr_txt_2.jpg" alt="" /></p>
                <p class="mgt70 txt">2. 글 작성 창에 Ctrl + F를 눌러 붙여 넣기 해주세요!<br/>&nbsp;&nbsp;&nbsp;그럼 이렇게 배너 이미지가 생성 됩니다!</p>
                <p class="img_pos"><img src="../image2/intro/activity/bnr_txt_4.jpg" alt="" /></p>
                -->
                
                <p class="titleText"><span class="titleLine">l</span>블로그 공정위 배너 & 배너코드 </p>
                 
                <p class="tit">* 일반 체험단</p>
                <p class="img_pos"><img src="../image2/intro/activity/aklover_gov_ban_220215.jpg" alt="" /></p>
                 
                <p class="txt mgt40">
                 	&lt;p&gt;&lt;a href=&quot;http://www.aklover.co.kr&quot; target=&quot;_blank&quot;&gt;<br />
					&lt;img src=&quot;http://www.aklover.co.kr/image2/공정위문구.jpg&quot;&gt;&lt;/a&gt;&lt;/p&gt;
                </p>
                 
                <p style="text-align:center; margin-top:20px;">
                	<a href="javascript:;" onClick="fnDownBanner(1)" style="display:inline-block;  margin:10px 0 0 0; text-align:center; width:140px; height:40px; line-height:40px; background:#f68427; color:#fff; font-size:16px;"/>배너 다운받기</a>
                	<a href="javascript:;" style="display:inline-block; margin:10px 0 0 20px; text-align:center; 
                	width:140px; height:40px; line-height:40px; background:#f68427; color:#fff; 
                	font-size:16px;" class="btn_clip2" 
                	data-clipboard-text="<a href='http://www.aklover.co.kr' target='_blank'><img src='http://www.aklover.co.kr/image2/공정위문구.jpg'></a>"/>코드 복사</a>
                </p>
                
                <p class="tit mgt20">* 포인트 체험단</p>
                <p class="img_pos"><img src="../image2/banner_point_04_05.jpg?v=1" alt="" /></p>
                 
                <p class="txt mgt40">
                 	&lt;p&gt;&lt;a href=&quot;http://www.aklover.co.kr&quot; target=&quot;_blank&quot;&gt;<br />
					&lt;img src=&quot;http://www.aklover.co.kr/image2/banner_point_04_05.jpg&quot;&gt;&lt;/a&gt;&lt;/p&gt;
                </p>
                 
                <p style="text-align:center; margin-top:20px;">
                	<a href="javascript:;" onClick="fnDownBanner(2)" style="display:inline-block;  margin:10px 0 0 0; text-align:center; width:140px; height:40px; line-height:40px; background:#f68427; color:#fff; font-size:16px;"/>배너 다운받기</a>
                	<a href="javascript:;" style="display:inline-block; margin:10px 0 0 20px; text-align:center; 
                	width:140px; height:40px; line-height:40px; background:#f68427; color:#fff; 
                	font-size:16px;" class="btn_clip2" 
                	data-clipboard-text="<a href='http://www.aklover.co.kr' target='_blank'><img src='http://www.aklover.co.kr/image2/banner_point_04_05.jpg?v=1'></a>"/>코드 복사</a>
                </p>
                
                 <p class="titleText mgt70"><span class="titleLine">l</span>인스타그램 공정위 문구 </p>
	             <p class="txt mgl10" style="margin-bottom:50px;">
					<strong>* 일반 체험단</strong>: 본문 최상단에 <span class="txt_emphasis2">‘AK LOVER 제품 지원‘</span> 문구를 꼭 작성해주세요.<br/>
					<strong>* 포인트 체험단</strong>: 본문 최상단에 <span class="txt_emphasis2">‘AK LOVER 상품권 및 혜택 지급‘</span> 문구를 꼭 작성해주세요
				 </p>
                
                <p class="titleText mgt70"><span class="titleLine">l</span>블로그 스마트 2.0 배너 올리는 법</p>
                
                <p class="txt">1. 글작성 창 오른쪽 하단 <span>'HTML'</span>를 클릭해주세요!</p>
                <p class="img_pos"><img src="../image2/intro/activity/bnr_m_img1.jpg" alt="" /></p>
                
                <p class="txt mgt70">2. 체험단 페이지 내 배너 소스코드를 드래그 후 'Ctrl + C'를 눌러 복사해 주세요.</p>
                <p class="txt_emphasis">※ 본 배너는 예시 이미지로 체험단 별 상이할 수 있으니, 반드시 진행하는 체험단 페이지에서 확인 부탁드립니다.</p>
                <p class="img_pos"><img src="../image2/intro/activity/bnr_m_img2_210504.png" alt="" /></p>
                
                <p class="txt mgt70">3. 원하시는 위치에 배너 소스코드를 Ctrl + V를 눌러 붙여넣기 해주세요.</p>
                <p class="img_pos"><img src="../image2/intro/activity/bnr_m_img3.jpg" alt="" /></p>
                
                <p class="txt mgt70">4. 그리고 다시 오른쪽 하단 <span>'Editor'</span> 클릭하면 화면에 배너 이미지가 생성 됩니다.</p>
                <p class="img_pos"><img src="../image2/intro/activity/bnr_m_img4_210504.png" alt="" /></p>
                
                <p class="titleText mgt70"><span class="titleLine">l</span>블로그 스마트 3.0 배너 올리는 법</p>
                
                <p class="txt mgt70">1. 체험단 페이지 내 공정위 배너를 드래그 후 Ctrl + C를 눌러 복사해주세요!</p>
                <p class="img_pos"><img src="../image2/intro/activity/30_ban_001_210504.jpg" alt="" /></p>
                
                <p class="txt mgt70">2. 글작성 창에 Ctrl + V를 눌러 붙여넣기 해주세요! <br/> 그럼 이렇게 배너 이미지가 생성됩니다!</p>
                <p class="img_pos"><img src="../image2/intro/activity/30_ban_002_210504.jpg" alt="" /></p>

            </div>
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

