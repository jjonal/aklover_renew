</div> <!-- content wrap (e) -->

	<link rel="stylesheet" type="text/css" href="/m/css/musign/main_popup.css" />
	<script type="text/javascript" src="/m/js/musign/main.js"></script>
	<script src="/js/musign/popup_close_period.js"></script>
	<!-- 뮤자인 모서리팝업 (s) -->
	<?
        $sql = "SELECT * FROM corner_popup WHERE hero_use='1' ";
        $sql .= " and ('".date("Y-m-d H:i:s")."' between hero_today_01 and hero_today_02) order by replace(hero_order,0,999) asc";
		sql($sql);
        $i = 1;
	?>
	<script>
	$(document).ready(function(e) {
        //확인불가
		$('.btn_close_alram').on('click', function(){
			$.cookie('alram_check', 1);
			$('.mainAlram').hide();
		})
        //링크 접속시 노출 여부(오늘 하루 열지 않기)
		if($.cookie('alram_check') != 1 && $.cookie('alram_today_check') != 1) {
			$('.mainAlram').show();
		}
        //오늘 하루 열지 않기 클릭시 쿠키 저장해서 미노출 처리
		$(".btn_today_close_alram").on("click",function(){
			$.cookie('alram_today_check', 1,{expires:1,path:'/'});
			$('.mainAlram').hide();
		})
	});
	</script>
		<!-- php 특정 ip서 해당 마크업이 보이도록 -->
			<div class="mainpopup corner_popup" id="mainpopup2">
				<div class="swiper-container slider2">
					<div class="swiper-wrapper">
                        <? while($list = @mysql_fetch_assoc($out_sql)){ //모바일 링크?>
						<div class="swiper-slide">
							<a href="<?=$list['hero_mo_href']?>" class="fz26 bold">
								<img src="/aklover/photo/<?=$list['hero_main']?>" alt="모서리 팝업">
							</a>
						</div>
						<?}?>
					</div>
					<div class="swbtn_wrap rel f_c">
						<div class="swiper-pagination"></div>  
						<div class="swiper-counter"></div>
					</div>
					<div class="swiper-button">
						<div class="swiper-button-prev"></div>
						<div class="swiper-button-next"></div>
					</div>
				</div>
				<button class="btnx fz28 bold">닫기</button>
				<div class="close_txt bg_w">
					<a class="btn_today_close_alram">오늘 하루 이 창을 열지 않음</a>
				</div>
			</div>
		<script>
			$('#mainpopup2 .btnx').click(function(){
				$('#mainpopup2').hide();
			});

			$("#mainpopup2 .btn_today_close_alram").on("click", function () {
				cookieSetting.setCookie("today2", "yes", 1);
				$('#mainpopup2').hide();
			});

			if (cookieSetting.getCookie("today2") == "yes") {
				$('#mainpopup2').hide();
			} else {
				$('#mainpopup2').show();
			}

			// 모서리 팝업 이미지가 없을 경우 팝업창 숨김
			const showImages = document.querySelectorAll('.corner_popup .swiper-wrapper .swiper-slide img');

			if(showImages.length === 0){
				document.querySelector(".corner_popup").classList.add("dis-no");
			} else {
				document.querySelector(".corner_popup").classList.remove("dis-no");
			}
		</script>
	<!-- 뮤자인 모서리팝업 (e) -->

	<!--푸터 시작-->
	<div id="footer">
		<div class="top">
			<a href="/m" class="ft_logo"><img src="/m/img/musign/main/ft_logo.webp" alt="aklover로고"></a>		
			<p class="fz24">애경산업㈜ 서울시 마포구 양화로 188 / 고객센터:080-024-1357<br>
			통신판매업신고번호 : 제 2018-서울마포-1843호</p>
		</div>
		
		<ul class="util">
			<li>
				<a href="javascript:;" onclick="popup('02', '/popup/term1_2.php', 550, 400, 10, 10,'yes');">이용약관</a>
			</li>
			<li>
				<a href="javascript:;" onclick="popup('02', '/popup/term3_21.html', 550, 400, 10, 10,'yes');">개인정보처리방침</a>
			</li>
			<li>
				<a href="/m/today.php?board=group_04_03">공지사항</a>
			</li>
			<li>			
				<a href="/m/customer.php?board=cus_3&view_type=list">고객센터</a>
			</li>
		</ul>
		<div class="dep1 select_shadow">
			<span class="select_tit sub_en">FAMILY SITE</span>
			<ul class="select_drop family_box scroll_css">
				<li><a href="https://www.aekyung.co.kr/" target="_blank">애경 공식 홈페이지</a></li>
				<li><a href="https://age20s.co.kr/" target="_blank">AGE20'S 브랜드 몰</a></li>
				<li><a href="https://brand.naver.com/age20s" target="_blank">AGE20'S 네이버 브랜드스토어</a></li>
				<li><a href="https://brand.naver.com/luna" target="_blank">루나 네이버 브랜드스토어</a></li>
				<li><a href="https://brand.naver.com/point_and_official" target="_blank">포인트앤 네이버 브랜드스토어</a></li>
				<li><a href="https://smartstore.naver.com/a_solution" target="_blank">에이솔루션 네이버 스마트스토어</a></li>
				<li><a href="https://brand.naver.com/akofficial" target="_blank">애경본사직영몰(생활용품)</a></li>
				<li><a href="https://onething.kr/index.html" target="_blank">ONE THING</a></li>
			</ul>
		</div>
		<p class="copyright ko_noto">COPYRIGHTⓒ2018 Aekyung Industrial Co., Ltd. ALL RIGHT RESERVED</p>
		<button type="button" id="tool-gotop" class="tool-gotop">			
			<img src="/img/front/icon/btn_top.png" alt="상단으로 이동">
		</button>
		<script>
		$(document).ready(function(e) {
			$("#familySite").on("change",function(){
				if($(this).val()) {
					var popFamilySite = window.open($(this).val(),'1','');
					popFamilySite.focus();
				}
			})
			
			$( window ).scroll(function() {
			if ( $(this).scrollTop() > 200 ) {
				$('#tool-gotop').show();
			}else{
				$('#tool-gotop').hide();
			}
			});
			$("#tool-gotop").click(function(){
				$('html, body').animate({ scrollTop : 0 } , 350);	
			})    
		});
		</script>
	</div>

	<div id="mission_popup" class="guide_popup" style="display:none">
		<div class="inner rel">
			<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="닫기"></div>
			<div class="scroll">
				<? include_once 'method.php';?>
			</div>
		</div>
	</div>

	<!-- [비밀번호  수정 팝업 임시] -->
	<?php if($_SESSION['ch_password']==1){?>
		<div class="mainpopup overlay password_popup" id="mainpopup3<?=$i?>">
			<div class="popup_inner">
				<div class="popup_content">
					<div class="image"><img src="/img/front/main/lock.webp" alt="비밀번호 수정"/></div>			
					<button class="btnx fz26 bold black" onClick="checkValueAndClose();">닫기</button>		
					<div class="txt_container t_c">
						<div class="bold fz25">고객님께서는 6개월 동안 비밀번호를 변경하지 않으셨습니다.</div>				
						<p class="fz22 fw500">
							고객님의 개인정보를 보호하기 위해서는<br />
							주기적으로 비밀번호를 변경해 주세요.
						</p>
					</div>
					<div class="btn_container f_c">
						<div class="btn_item btn_now"><a href="/m/pwedit.php?board=pwedit">지금 변경하기</a></div>	
						<div class="btn_item btn_today_close_alram border"><a href="">다음에 변경하기</a></div>	
					</div>
				</div>
				<div class="close_txt input_chk">
					<input type="checkbox" id="weeks" value="체크" name="weeks">
					<label class="input_chk_label" for="weeks">
						2주간 표시 안 함
					</label>
				</div>
			</div>
		</div>

		<script>
			$(".btn_today_close_alram, .btn_now a").on("click", function () { // 하루 보지 않기
				cookieSetting.setCookie("today3", "yes", 1);
				$('#mainpopup3<?=$i?>').hide();
			});

			function checkValueAndClose(){
				const checkInput = `input[name="weeks"]:checked`;
				const isEle = document.querySelector(checkInput);

				if(isEle){
					cookieSetting.setCookie("2weeks", "yes", 14); // 2주일간 보지 않기
					$('#mainpopup3<?=$i?>').hide();
				} else {
					$('#mainpopup3<?=$i?>').hide();
				}
			}

			if (cookieSetting.getCookie("today3") == "yes" || cookieSetting.getCookie("2weeks") == "yes") {
				$('#mainpopup3<?=$i?>').hide();
			} else {
				$('#mainpopup3<?=$i?>').show();
			}
		</script>
	<?php }?>

<?
//한시간동안 이용없을 경우 로그아웃 처리
if($_SESSION['temp_code'] && $_SESSION['temp_level'] < 9999) {
	$current_time_check = date("YmdHis");
	
	$timestamp = strtotime("+30 minutes", strtotime($_SESSION["temp_loginTime"]));
	//$timestamp = strtotime("+3 seconds", strtotime($_SESSION["temp_loginTime"]));
	
	$login_limit_time = date("YmdHis",$timestamp);	
	
	if($current_time_check > $login_limit_time) {
		@session_destroy();
		echo '<script>alert("30분 동안 이용이 없어 로그아웃 되었습니다.");location.href="./index.php"</script>';exit;
		//Header("Location:/index.php");
		//exit;
	} else {
		$_SESSION["temp_loginTime"] = date("YmdHis");
	}	
}
?>

<!--푸터 종료-->
<!-- LOGGER(TM) TRACKING SCRIPT V.40 FOR logger.co.kr / 102107 : COMBINE TYPE / DO NOT ALTER THIS SCRIPT. -->
<script type="text/javascript">var _TRK_LID = "102107";var _L_TD = "ssl.logger.co.kr";var _TRK_CDMN = ".aklover.co.kr";</script>
<script type="text/javascript">var _CDN_DOMAIN = location.protocol == "https:" ? "https://fs.bizspring.net" : "http://fs.bizspring.net"; 
(function (b, s) { var f = b.getElementsByTagName(s)[0], j = b.createElement(s); j.async = true; j.src = '//fs.bizspring.net/fs4/bstrk.1.js'; f.parentNode.insertBefore(j, f); })(document, 'script');
</script>
<noscript><img alt="Logger Script" width="1" height="1" src="http://ssl.logger.co.kr/tracker.1.tsp?u=102107&amp;js=N"/></noscript>
<!-- END OF LOGGER TRACKING SCRIPT -->
</body> 
</div> <!-- Content (e) -->