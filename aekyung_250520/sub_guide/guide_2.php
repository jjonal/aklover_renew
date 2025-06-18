<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);
######################################################################################################################################################
?>

    <div class="contents">
        <!-- story.css -->
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
		});
        </script>
        
        
        <style>
            	#guide_main { font-size: 17.5px;height: 58px;padding: 57px 0 0 22px;float: left;width: 442px;font-weight: 800;letter-spacing: -0.7px;line-height: 30px; }
            	#guide_main span { color:#EC6022;font-size:22px; }
            	
            	.guide_2 {border:1px solid #EBE2DC;border-top:2px solid #EBE2DC;border-bottom:2px solid #EBE2DC;width: 100%;text-align: center;font-size: 13px;font-weight: 800;margin: 5px 0; }
            	.guide_2 tr { height: 38px; }
            	.guide_2 tr td { border: 1px solid #EBE2DC;border-bottom: 0px; }
            	
            	#guide_2_1 { padding:10px; }
            	#guide_2_1 li { /*height: 23px;*/font-size: 13px;font-weight: 800; }
            	
            	#guide_2_2 {border:1px solid #EBE2DC;border-top:2px solid #EBE2DC;border-bottom:2px solid #EBE2DC;width: 100%;text-align: center;font-size: 13px;font-weight: 800;margin: 20px 0; }
            	#guide_2_2 tr { height: 30px; }
            	#guide_2_2 tr td { border: 1px solid #EBE2DC;border-left: 0px;border-bottom: 0px; }
            	#guide_2_2 tr td.first { background:#FEF2E8; }
            	#guide_2_2 tr td.last { border-right:0px; }
            	#guide_2_2 tr td img { position: relative;width: 25px;top: 4px; }
				
        </style>
        <div id="tab01" class="tab_content">
        	<div class="pointPestival"><span>&nbsp;<img src="/image2/etc/guide2_4_heart.gif"></span>&nbsp;AK LOVER 활동으로 적립된 포인트는 "포인트 축제"를 통해 애경의 원하는 제품으로 교환 가능합니다.</div>
            <p class="titleText"><span class="titleLine">l</span>포인트 지급</p>
            <table class="guide_2">
                <tr style="background: #FDE6D2;font-size:14px;height:40px;">
                    <td style="width: 100px;">구 분</td>
                    <td >활동 내용</td>
                    <td style="width:90px;">Point</td>
                </tr>
                <tr >
                    <td rowspan="5" >홈페이지</td>
                    <td >출석체크<br> (해당 월 모두 출석시 +50)</td>
                    <td >1</td>
                </tr>
                <tr >
                    <td>댓글 작성</td>
                    <td>1</td>
                </tr>
                <tr >
                    <td>게시글작성</td>
                    <td>2</td>
                </tr>
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
                <li><img src="/image2/etc/guide2_4_heart.gif">&nbsp;&nbsp;상황에 따라 추가 포인트 지급이 가능합니다.</li>
            </ul>
            
            <p class="titleText mgt40"><span class="titleLine">l</span>포인트 차감</p>
            <table class="guide_2">
                <tr style="background: #FDE6D2;font-size:14px;height:40px;">
                    <td style="width: 100px;">구 분</td>
                    <td >활동 내용</td>
                    <td style="width:90px;">Point</td>
                </tr>
                <tr >
                    <td rowspan="4" >체험단</td>
                    <td>후기 미작성</td>
                    <td>-1,000</td>
                </tr>
                <tr >
                    <td>기간 내 체험단 후기 미등록</td>
                    <td>-500</td>
                </tr>
                <tr >
                    <td>체험단 가이드라인 미준수</td>
                    <td>-500</td>
                </tr>
                <tr >
                    <td>오프라인 모임 미참석 시</td>
                    <td>-1,000</td>
                </tr>
                <tr >
                    <td rowspan="5" >게시판</td>
                    <td rowspan="3" >욕설, 폭언, 남에게 피해주는 게시글 등</td>
                    <td >-50(1차)</td>
                </tr>
                <tr >
                    <td >-100(2차)</td>
                </tr>
                <tr >
                    <td style="letter-spacing: -1.2px;">강제탈퇴(3차)</td>
                </tr>
                <tr >
                    <td rowspan="2" >컨텐츠 도용 및 복사글</td>
                    <td >-100(1차)</td>
                </tr>
                <tr >
                    <td style="letter-spacing: -1.2px;">강제탈퇴(2차)</td>
                </tr>
            </table>

            <ul id="guide_2_1">
                <li><img src="/image2/etc/guide2_4_heart.gif">&nbsp;&nbsp;후기 미작성 및 오프라인 모임 미참석으로 1,000P 차감되신 분들은 3개월 간 체험단 선정에서 제외됩니다.</li>
            </ul>
            
            <p class="titleText mgt40"><span class="titleLine">l</span>포인트 확인</p>
            <img src="/image2/intro/point/pointCheck.png"/>
            <ul id="guide_2_1">
                <li><img src="/image2/etc/guide2_4_heart.gif">&nbsp;&nbsp;가용 포인트 : 포인트 축제 기간 '제품 교환 가능한 포인트'이며, 포인트 축제 이후 남은 가용 포인트는 일괄 소멸 처리 <br/><span style="margin-left:100px;"> 됩니다.</span></li>
            </ul>
    	</div>
        
        <div id="tab02" class="tab_content">
	        <p class="titleText"><span class="titleLine">l</span>회원 등급</p>
	        
         	<table id="guide_2_2">
				<tr style="background: #FDE6D2;font-size:14px;height:35px;">
            		<td style="width: 90px;">레벨</td>
            		<td style="width: 400px;">포인트</td>
            		<td class="last" style="width:90px;">아이콘</td>
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
            <p class="pointPestivalP">
            	<span class="black">1. 포인트 축제 기간 : </span>포인트 축제는 게릴라 성으로 불시에 진행됩니다.<br/>
                <span class="black">2. 참여대상 : </span>AK LOVER 회원 전원<br/>
                <span class="black">3. 구매 목록 확인 : </span><br/>
					&nbsp;&nbsp;&nbsp;&nbsp;- 진행 중: 체험단/이벤트 → 포인트 축제 → 내 구매내역<br/>
					&nbsp;&nbsp;&nbsp;&nbsp;- 종료 후: 마이페이지 → 포인트축제 구매내역<br/>
                <span class="black">4. 포인트 소멸 : </span>전체 회원을 위한 포인트 축제 이후 남은 가용 포인트는 일괄 소멸 처리 됩니다.
            </p>
            <img class="mgt10" src="/image2/intro/point/pointFestival2.png"/>
    	</div>
    </div>
</div><!--footer-->