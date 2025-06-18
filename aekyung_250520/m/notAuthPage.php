<link rel="stylesheet" type="text/css" href="/m/css/musign/pointmall.css" />
<?
	$board 		= $_GET['board'];
	$color 		= "";
	$backColor 	= "";
	$url 		= "";
	$bottom 	= "bottom";
	
	switch ($board) {
		case "group_04_06" : //뷰티클럽
			$color 		= "#eb7989";
			$backColor 	= "#ffedf2";
			$url 		= "/image2/m_box_backlight003.png";
			$height 	= "400";
			break;
		case "group_04_21" : //포인트축제
			$color 		= "#f68427";
			$backColor 	= "#f4f4f4";
			$url 		= "";
			$height 	= "auto";;
			break;
		case "group_04_27" : //AK 러버 유튜버
			$color 		= "#996c33";
			$backColor 	= "#e9b9a7";
			$url 		= "/image2/m_box_backlight006.png";
			$height 	= "480";
			break;
		case "group_04_28" : //라이프클럽
			$color 		= "#996c33";
			$backColor 	= "#e9b9a7";
			$url 		= "/image2/m_box_backlight006.png";
			$height 	= "480";
			break;
  }
?>

<?
	$check_date = date("Ymd");//임시로 반영
?>
        <? if($board == "group_04_06" || $board == "group_04_28") { ?>
	    <div class="authPage">  
	    	<div class="noAuthPage">
				<? include_once 'club.php';?>
            </div>
	    </div>
        <? }else if($board == "group_04_21") { //포인트 축제
 
        	$sql = " SELECT b.hero_idx, b.hero_thumb, b.hero_04, b.blog_url, b.sns_url, b.cafe_url, b.etc_url FROM board b inner join member m on b.hero_code = m.hero_code ";
        	$sql .=" WHERE  b.hero_table IN ('group_04_05', 'group_04_06', 'group_04_07', 'group_04_09','group_04_23' ) ";
        	$sql .=" AND (b.hero_board_three='1' OR b.hero_table='group_04_10')  AND b.hero_use = 1 ";
        	$sql .=" ORDER BY b.hero_today DESC LIMIT 0,8 ";
        	
        	sql($sql);

       	?>
        <div class="authPage">  
	    	<div class="noAuthPage">  
				<div><img src="/m/img/musign/pointmall/season2/pointmall.png" alt="포인트 축제 배너" /></div>
				<div class="sec_rollbanner">                   
					<div class="roll_wrap">
						<ul class="list">
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
						</ul>
						<ul class="list">
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="포인트 축제"></li>
						</ul>
					</div>
				</div>   
				<div class="con_box">
					<div class="inner">
						<div class="desc">
							<ul class="">
								<li>
									<span class="mini_tit fz28 bold">일정</span>
									<p class="tit f_c">연 2회 게릴라로 깜짝 오픈</p>
									<p class="fz28 fw600 sub_desc">상반기/하반기 각 2회 게릴라 오픈됩니다</p>
									<img src="/img/front/pointmall/season2/icon01.png" style="width: 127px" alt="포인트 축제 기간 설명">
									<p class="fz15 sub_noti">*포인트 페스티벌 일정 및 대상자는<br /> 변동될 수 있습니다.</p>
								</li>
								<li>
									<span class="mini_tit fz28 bold">배송</span>
									<p class="tit">전 회원 무료배송</p>
									<p class="fz28 fw600 sub_desc">배송은 축제 종료 후 일괄 발송됩니다</p>
									<img src="/img/front/pointmall/season2/icon02.png" style="width: 176px" alt="포인트 축제 기간 설명">
								</li>
								<li>
									<span class="mini_tit fz28 bold">제품</span>
									<p class="tit">애경의 다양한 인기 제품<br /> 직접 선택 가능</p>
									<!-- <p class="tit">매 회 다른 제품 구성</p> -->
									<p class="fz28 fw600 sub_desc">애경의 다양한 제품을 경험해보세요!</p>
									<img src="/img/front/pointmall/season2/icon03.png" style="width: 182px" alt="포인트 축제 기간 설명">
								</li>
							</ul>
						</div>
						<div class="faq_box">						
							<div class="">
								<p class="fz32 fw600 desc c_white">포인트 페스티벌에 대해 궁금한 점이<br />있다면 <span class="point">자주 묻는 질문</span>을 통해 확인해보세요!</p>
							</div>
							<a href="/m/faq.php?board=cus_2" class="faq_btn f_b">
								확인하기 <img src="/m/img/musign/pointmall/faq_btn.png" style="width: 6px;" alt="faq 확인하기">
							</a>
						</div>
						<div class="noti">
							<span class="mini_tit fz28 bold">유의사항</span>
							<p class="fz24 sub_desc">
								- 포인트 페스티벌은 연 2회 진행되며, 진행 일정은 깜짝 공개됩니다.<br />
								&ensp;(상반기 : 이달의 AK Lover 및 프리미어 뷰티/라이프 클럽,<br /> 하반기 : 전체 회원 대상)<br />
								- 상반기 진행 후 포인트는 소멸되지 않으며,<br /> 하반기 진행 후 남은 포인트는 일괄 소멸됩니다.
							</p>
						</div>
					</div>				
				</div>    			         
       		</div>
       </div>
        <? }else if($board == "group_04_27") { ?>
        <div class="authPage">  
	    	<div class="noAuthPage">
	    		<? if($check_date < 20210803) { ?>
	    			<div><a href="/m/joinCheck.php?board=idcheck"><img src="./img/mission_member_join.jpg" width="100%" /></a></div>  	
      	   		<?  } else { ?>
	    		<div class="img_product"><img src="/image2/focus_main_movie4.jpg" alt="" /></div>
           	    <div class="bg_explain">
					<dl class="box_explain">
						<dt><span>대상</span></dt>
						<dd>뷰티 혹은 생활용품에 관심이 많은 영상 크리에이터</dd>
						<dt><span>지원방법</span></dt>
						<dd>별도 모집 기간에 공고</dd>
           	    		<dt><span>주요활동</span></dt>
           	    		<dd>애경 뷰티/생활 신제품 사용 후 영상 제작, 신제품 아이디어 제안, 제품 품평회, 설문조사 등</dd>
           	    		<dt><span>혜택</span></dt>
           	    		<dd>최종 우수자 30만원 상금 지급<br/>
							선정자 전원 10만원 상당 웰컴 박스 지급 (최초 1회)<br/>
							활동 종료 후 10만원 상당 혜택 지급 * 활동 완료 조건 충족 시<br/>
							월 우수자 5만원 상당 상품권 지급<br/>
							브랜드 행사 우선 참여 기회 제공<br/>
							미션 완료 시 제품 교환 가능한 포인트 지급<br/>
							활동 종료 후 수료증 제공
           	    		</dd>
           	    	</dl>
           	    </div>
           	    <? } ?>
			</div>
        <? } ?>