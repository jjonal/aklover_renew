</main>
</div> <!-- 메인 컨테이너 닫기 -->

<link rel="stylesheet" type="text/css" href="/css/front/main_popup.css" />
<script type="text/javascript" src="/js/musign/main.js"></script>
<script src="/js/musign/popup_close_period.js"></script>

<?
####################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
####################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
####################################################################################################################################################
//20140502 google analytics 설치//

include_once FREEBEST_INC_END.'analyticstracking.php';
?>

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
		<div class="mainpopup corner_popup" id="mainpopup2">
                <div class="swiper-container slider">
					<div class="swiper-wrapper">
						<? while($list = @mysql_fetch_assoc($out_sql)) {?>
							<div class="swiper-slide">
							<a href="<?=$list['hero_pc_href']?>" class="fz26 bold">
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

	<!-- footer -->
	</div><!-- id="content" -->	
		<div class="front_footer">
			<footer id="footer" class="footer"> 
			<div class="footer_wrap">
				<div class="top">
					<div class="img_box">
						<a href="/">
							<img src="/img/front/main/footer_logo.png" alt="aekyung" class="pc">
							<img src="/img/front/main/footer_logo.png" alt="aekyung" class="mo">
						</a>
					</div>
					<div class="left">
						<a href="/popup/term1_2.php" target="_blank">이용약관</a>
						<a href="/popup/term3_21.html" target="_blank">개인정보처리방침</a>						
						<a href="/main/index.php?board=group_04_03">공지사항</a>						
						<a href="/main/index.php?board=group_04_33">고객센터</a>
					</div>	
				</div>
				<div class="bot">
					<span>
						애경산업㈜ 서울시 마포구 양화로 188 / 고객센터 : 080-024-1357<br>
						통신판매업신고번호 : 제 2018-서울마포-1843호
					</span>
					<div class="f_b f_a_e">
						<span class="copyr">COPYRIGHTⓒ 2024 Aekyung Industrial Co., Ltd. ALL RIGHT RESERVED</span>
						<div class="dep1 select_shadow">
							<span class="select_tit">FAMILY SITE</span>
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
					</div>
				</div>				
			</div>				
			</div><!-- id="footer" -->
		</div>
	</div><!-- id='wrap' -->

    <div id="mission_popup" class="guide_popup scroll_popup" style="display:none">
        <div class="inner rel">
            <div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="닫기"></div>
            <div class="scroll">
                <? include_once BOARD_INC_END.'method.php';?>
            </div>
        </div>
	</div>

	<?php if(MOBILE=='mobile'){?>
		<div style="background-color: #F68427;color: white;font-size: 50px;font-weight: 800;text-align: center;cursor: pointer;float: left;width: 100%;padding: 10px 0;" onclick="pcMobile('mobile','/m/main.php');">모바일로 이동</div>
	<?php }?>
	<div id="mail_form" style="display:none;">	</div>
	<!-- [비밀번호  수정 팝업 임시] -->
	<div class="img-loading" style="display:none;">
    	<div><img src="/image2/etc/loading1.gif" /></div>
	</div>
	<?php if($_SESSION['ch_password']==1){?>
		<div class="mainpopup overlay password_popup" id="mainpopup3">
			<div class="popup_inner">
				<div class="popup_content">
					<div class="image"><img src="/img/front/main/lock.webp" alt="비밀번호 수정"/></div>			
					<button class="btnx fz26 bold black" onClick="checkValueAndClose();">닫기</button>		
					<div class="txt_container t_c">
						<div class="bold fz16">고객님께서는 6개월 동안 비밀번호를 변경하지 않으셨습니다.</div>				
						<p class="fz16 fw500">
							고객님의 개인정보를 보호하기 위해서는<br />
							주기적으로 비밀번호를 변경해 주세요.
						</p>
					</div>
					<div class="btn_container f_c">
						<div class="btn_item btn_now"><a href="/main/index.php?board=infoauth">지금 변경하기</a></div>	
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
				$('#mainpopup3').hide();
			});

			function checkValueAndClose(){
				const checkInput = `input[name="weeks"]:checked`;
				const isEle = document.querySelector(checkInput);

				if(isEle){
					cookieSetting.setCookie("2weeks", "yes", 14); // 2주일간 보지 않기
					$('#mainpopup3').hide();
				} else {
					$('#mainpopup3').hide();
				}
			}

			if (cookieSetting.getCookie("today3") == "yes" || cookieSetting.getCookie("2weeks") == "yes") {
				$('#mainpopup3').hide();
			} else {
				$('#mainpopup3').show();
			}
		</script>
	<?php }?>

	<?php if($_COOKIE['member_login_event_03']=='1'){
		?>
		<div id="dormancyLoginEvent">
			<div>
				<div id="closeChLastUpdatedPw" onclick="setCookie('member_login_event_03','',-1200);location.reload();">X</div>		
				<img src="http://aklover.co.kr/image/mail/dormancy_login_event.jpg" alt="장기 미접속자 로그인 이벤트"/>
			</div>
		</div>
	<?php }?>

	<!-- <div id="term_popup" class="guide_popup">
		<div class="inner rel">
			<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="닫기"></div>
			<iframe id="popup-iframe" src="/popup/term3_19.html" frameborder='0'></iframe>
		</div>
	</div> -->


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
<!-- LOGGER(TM) TRACKING SCRIPT V.40 FOR logger.co.kr / 48142 : COMBINE TYPE / DO NOT ALTER THIS SCRIPT. -->
<script type="text/javascript">var _TRK_LID = "48142";var _L_TD = "ssl.logger.co.kr";var _TRK_CDMN = "";</script>
<script type="text/javascript">var _CDN_DOMAIN = location.protocol == "https:" ? "https://fs.bizspring.net" : "http://fs.bizspring.net"; 
(function (b, s) { var f = b.getElementsByTagName(s)[0], j = b.createElement(s); j.async = true; j.src = '//fs.bizspring.net/fs4/bstrk.1.js'; f.parentNode.insertBefore(j, f); })(document, 'script');
</script>
<noscript><img alt="Logger Script" width="1" height="1" src="http://ssl.logger.co.kr/tracker.1.tsp?u=48142&amp;js=N"/></noscript>
<!-- END OF LOGGER TRACKING SCRIPT -->

<!-- LOGGER(TM) CLICKZONE(TM) SCRIPT ver.FR02 -->
<!-- COPYRIGHT (C) 2002-2018 BIZSPRING INC. LOGGER(TM) ALL RIGHTS RESERVED. -->
<!-- DO NOT MODIFY THIS SCRIPT. -->
<script type="text/javascript">
var _CZ_U = 48142;
var _CZ_HTTP_HOST = "ssl.logger.co.kr";
var _CZ_HTTPS_HOST = "ssl.logger.co.kr";
var _CZ_HOST = document.location.protocol.indexOf("https") != -1 ? "https://" + _CZ_HTTPS_HOST : "http://" + _CZ_HTTP_HOST;
var _CZ_DU = encodeURIComponent(self.document.location.href);
var _CZ_CC = _trk_getCookieCZ("_TRK_CC");
var _CZ_IMG = new Image();
var _CZ_URL = ".";
function _trk_getCookieCZ(name) {
    var cookieName = name + "=";
    var x = 0;
    while (x <= document.cookie.length) {
        var y = (x + cookieName.length);
        if (document.cookie.substring(x, y) == cookieName) {
            if ((endOfCookie = document.cookie.indexOf(";", y)) == -1) endOfCookie = document.cookie.length;
            return unescape(document.cookie.substring(y, endOfCookie));
        }
        x = document.cookie.indexOf(" ", x) + 1;
        if (x == 0) break;
    }
    return "";
}
function _cz_getposition(obj) {
    var pos = new Object;
    pos.x = 0;
    pos.y = 0;
    if (obj) {
        pos.x = obj.offsetLeft;
        pos.y = obj.offsetTop;
    }
    return pos;
}
function _cz_iframe_mouseClick(i_ax, i_ay, iframeName) {
    var iframeTop = 0, iframeLeft = 0, px = 0;
    if (typeof(window.innerWidth) == 'number') {
        ww = window.innerWidth;
    } else if (document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight)) {
        ww = document.documentElement.clientWidth;
    } else if (document.body && (document.body.clientWidth || document.body.clientHeight)) {
        ww = document.body.clientWidth;
    }
    if (iframeName) {
        var ppos = _cz_getposition(document.all[iframeName]);
        iframeTop = ppos.x;
        iframeLeft = ppos.y;
    }
    c_ax = iframeTop + i_ax;
    c_ay = iframeLeft + i_ay;
    rx = Math.round(c_ax - ww / 2);
    px = Math.round(c_ax / ww * 100);
    _CZ_IMG.src = _CZ_HOST + "/tracker_czn.tsp?u=" + _CZ_U + "&czIdx=11664&ax=" + c_ax + "&ay=" + c_ay + "&rx=" + rx + "&px=" + px + "&ww=" + ww + "&CC=" + _CZ_CC;
}
function _cz_mouseClick(e) {
    if (document.location.href.indexOf(_CZ_URL) < 0) return;
    var ax, ay, rx;
    if (!e) var e = window.event;
    var _scrOfX = 0;
    var _scrOfY = 0;
    if (document.body && ( document.body.scrollLeft || document.body.scrollTop)) {
        _scrOfY = document.body.scrollTop;
        _scrOfX = document.body.scrollLeft;
    } else if (document.documentElement && (document.documentElement.scrollLeft || document.documentElement.scrollTop)) {
        _scrOfY = document.documentElement.scrollTop;
        _scrOfX = document.documentElement.scrollLeft;
    }
    ax = e.clientX + _scrOfX;
    ay = e.clientY + _scrOfY;
    _cz_iframe_mouseClick(ax, ay, "");
}
if (window.addEventListener)document.addEventListener('mousedown', _cz_mouseClick, false); else document.attachEvent('onmousedown', _cz_mouseClick);
</script>
<!-- END OF LOGGER(TM) CLICKZONE(TM) SCRIPT -->
	</body>	
</html>
