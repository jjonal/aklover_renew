</div> <!-- content wrap (e) -->

	<link rel="stylesheet" type="text/css" href="/m/css/musign/main_popup.css" />
	<script type="text/javascript" src="/m/js/musign/main.js"></script>
	<script src="/js/musign/popup_close_period.js"></script>
	<!-- ������ �𼭸��˾� (s) -->
	<?
        $sql = "SELECT * FROM corner_popup WHERE hero_use='1' ";
        $sql .= " and ('".date("Y-m-d H:i:s")."' between hero_today_01 and hero_today_02) order by replace(hero_order,0,999) asc";
		sql($sql);
        $i = 1;
	?>
	<script>
	$(document).ready(function(e) {
        //Ȯ�κҰ�
		$('.btn_close_alram').on('click', function(){
			$.cookie('alram_check', 1);
			$('.mainAlram').hide();
		})
        //��ũ ���ӽ� ���� ����(���� �Ϸ� ���� �ʱ�)
		if($.cookie('alram_check') != 1 && $.cookie('alram_today_check') != 1) {
			$('.mainAlram').show();
		}
        //���� �Ϸ� ���� �ʱ� Ŭ���� ��Ű �����ؼ� �̳��� ó��
		$(".btn_today_close_alram").on("click",function(){
			$.cookie('alram_today_check', 1,{expires:1,path:'/'});
			$('.mainAlram').hide();
		})
	});
	</script>
		<!-- php Ư�� ip�� �ش� ��ũ���� ���̵��� -->
			<div class="mainpopup corner_popup" id="mainpopup2">
				<div class="swiper-container slider2">
					<div class="swiper-wrapper">
                        <? while($list = @mysql_fetch_assoc($out_sql)){ //����� ��ũ?>
						<div class="swiper-slide">
							<a href="<?=$list['hero_mo_href']?>" class="fz26 bold">
								<img src="/aklover/photo/<?=$list['hero_main']?>" alt="�𼭸� �˾�">
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
				<button class="btnx fz28 bold">�ݱ�</button>
				<div class="close_txt bg_w">
					<a class="btn_today_close_alram">���� �Ϸ� �� â�� ���� ����</a>
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

			// �𼭸� �˾� �̹����� ���� ��� �˾�â ����
			const showImages = document.querySelectorAll('.corner_popup .swiper-wrapper .swiper-slide img');

			if(showImages.length === 0){
				document.querySelector(".corner_popup").classList.add("dis-no");
			} else {
				document.querySelector(".corner_popup").classList.remove("dis-no");
			}
		</script>
	<!-- ������ �𼭸��˾� (e) -->

	<!--Ǫ�� ����-->
	<div id="footer">
		<div class="top">
			<a href="/m" class="ft_logo"><img src="/m/img/musign/main/ft_logo.webp" alt="aklover�ΰ�"></a>		
			<p class="fz24">�ְ����� ����� ������ ��ȭ�� 188 / ������:080-024-1357<br>
			����Ǹž��Ű��ȣ : �� 2018-���︶��-1843ȣ</p>
		</div>
		
		<ul class="util">
			<li>
				<a href="javascript:;" onclick="popup('02', '/popup/term1_2.php', 550, 400, 10, 10,'yes');">�̿���</a>
			</li>
			<li>
				<a href="javascript:;" onclick="popup('02', '/popup/term3_21.html', 550, 400, 10, 10,'yes');">��������ó����ħ</a>
			</li>
			<li>
				<a href="/m/today.php?board=group_04_03">��������</a>
			</li>
			<li>			
				<a href="/m/customer.php?board=cus_3&view_type=list">������</a>
			</li>
		</ul>
		<div class="dep1 select_shadow">
			<span class="select_tit sub_en">FAMILY SITE</span>
			<ul class="select_drop family_box scroll_css">
				<li><a href="https://www.aekyung.co.kr/" target="_blank">�ְ� ���� Ȩ������</a></li>
				<li><a href="https://age20s.co.kr/" target="_blank">AGE20'S �귣�� ��</a></li>
				<li><a href="https://brand.naver.com/age20s" target="_blank">AGE20'S ���̹� �귣�彺���</a></li>
				<li><a href="https://brand.naver.com/luna" target="_blank">�糪 ���̹� �귣�彺���</a></li>
				<li><a href="https://brand.naver.com/point_and_official" target="_blank">����Ʈ�� ���̹� �귣�彺���</a></li>
				<li><a href="https://smartstore.naver.com/a_solution" target="_blank">���ַ̼�� ���̹� ����Ʈ�����</a></li>
				<li><a href="https://brand.naver.com/akofficial" target="_blank">�ְ溻��������(��Ȱ��ǰ)</a></li>
				<li><a href="https://onething.kr/index.html" target="_blank">ONE THING</a></li>
			</ul>
		</div>
		<p class="copyright ko_noto">COPYRIGHT��2018 Aekyung Industrial Co., Ltd. ALL RIGHT RESERVED</p>
		<button type="button" id="tool-gotop" class="tool-gotop">			
			<img src="/img/front/icon/btn_top.png" alt="������� �̵�">
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
			<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="�ݱ�"></div>
			<div class="scroll">
				<? include_once 'method.php';?>
			</div>
		</div>
	</div>

	<!-- [��й�ȣ  ���� �˾� �ӽ�] -->
	<?php if($_SESSION['ch_password']==1){?>
		<div class="mainpopup overlay password_popup" id="mainpopup3<?=$i?>">
			<div class="popup_inner">
				<div class="popup_content">
					<div class="image"><img src="/img/front/main/lock.webp" alt="��й�ȣ ����"/></div>			
					<button class="btnx fz26 bold black" onClick="checkValueAndClose();">�ݱ�</button>		
					<div class="txt_container t_c">
						<div class="bold fz25">���Բ����� 6���� ���� ��й�ȣ�� �������� �����̽��ϴ�.</div>				
						<p class="fz22 fw500">
							������ ���������� ��ȣ�ϱ� ���ؼ���<br />
							�ֱ������� ��й�ȣ�� ������ �ּ���.
						</p>
					</div>
					<div class="btn_container f_c">
						<div class="btn_item btn_now"><a href="/m/pwedit.php?board=pwedit">���� �����ϱ�</a></div>	
						<div class="btn_item btn_today_close_alram border"><a href="">������ �����ϱ�</a></div>	
					</div>
				</div>
				<div class="close_txt input_chk">
					<input type="checkbox" id="weeks" value="üũ" name="weeks">
					<label class="input_chk_label" for="weeks">
						2�ְ� ǥ�� �� ��
					</label>
				</div>
			</div>
		</div>

		<script>
			$(".btn_today_close_alram, .btn_now a").on("click", function () { // �Ϸ� ���� �ʱ�
				cookieSetting.setCookie("today3", "yes", 1);
				$('#mainpopup3<?=$i?>').hide();
			});

			function checkValueAndClose(){
				const checkInput = `input[name="weeks"]:checked`;
				const isEle = document.querySelector(checkInput);

				if(isEle){
					cookieSetting.setCookie("2weeks", "yes", 14); // 2���ϰ� ���� �ʱ�
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
//�ѽð����� �̿���� ��� �α׾ƿ� ó��
if($_SESSION['temp_code'] && $_SESSION['temp_level'] < 9999) {
	$current_time_check = date("YmdHis");
	
	$timestamp = strtotime("+30 minutes", strtotime($_SESSION["temp_loginTime"]));
	//$timestamp = strtotime("+3 seconds", strtotime($_SESSION["temp_loginTime"]));
	
	$login_limit_time = date("YmdHis",$timestamp);	
	
	if($current_time_check > $login_limit_time) {
		@session_destroy();
		echo '<script>alert("30�� ���� �̿��� ���� �α׾ƿ� �Ǿ����ϴ�.");location.href="./index.php"</script>';exit;
		//Header("Location:/index.php");
		//exit;
	} else {
		$_SESSION["temp_loginTime"] = date("YmdHis");
	}	
}
?>

<!--Ǫ�� ����-->
<!-- LOGGER(TM) TRACKING SCRIPT V.40 FOR logger.co.kr / 102107 : COMBINE TYPE / DO NOT ALTER THIS SCRIPT. -->
<script type="text/javascript">var _TRK_LID = "102107";var _L_TD = "ssl.logger.co.kr";var _TRK_CDMN = ".aklover.co.kr";</script>
<script type="text/javascript">var _CDN_DOMAIN = location.protocol == "https:" ? "https://fs.bizspring.net" : "http://fs.bizspring.net"; 
(function (b, s) { var f = b.getElementsByTagName(s)[0], j = b.createElement(s); j.async = true; j.src = '//fs.bizspring.net/fs4/bstrk.1.js'; f.parentNode.insertBefore(j, f); })(document, 'script');
</script>
<noscript><img alt="Logger Script" width="1" height="1" src="http://ssl.logger.co.kr/tracker.1.tsp?u=102107&amp;js=N"/></noscript>
<!-- END OF LOGGER TRACKING SCRIPT -->
</body> 
</div> <!-- Content (e) -->