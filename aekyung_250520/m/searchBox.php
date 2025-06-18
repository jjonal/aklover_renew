	
	<?php 
	####################################################################################################################################################
	if(!defined('_HEROBOARD_'))exit;
	####################################################################################################################################################
	?>
	<script src="/js/musign/library/jquery-ui.min.js"></script>
	<div id="searchBox" class="mu_searchbox rel">
	        <form method="GET" id="frm" >				
				<div class="title fz20 fw600 pc">SEARCH</div>					
				<div class="search_cont rel">
	        	<input type="hidden" name="board" value="<?=$_GET['board']?>"/>
                <input type="hidden" id="statusSearch" name="statusSearch" value="<?=$_GET['statusSearch']?>"/>
                <input type="hidden" name="hero_idx" value=""/>
                
                <? if($_GET["board"] == "group_02_02" || $_GET["board"] == "group_04_24") {?>
                	<input type="hidden" name="gubun" value="<?=$_GET['gubun']?>" />
                <? } ?>
	        	<? if($_GET['idx']){?>
		        	<input type="hidden" name="idx" value="<?=$_GET['idx']?>"/>
	        	<? } ?>
	        	
	        	<? if($_GET["board"] == "group_04_06") {?>
	        		<input type="hidden" name="hero_beauty_gisu" value="<?=$_GET["hero_beauty_gisu"]?>" />
	        	<? } else if($_GET["board"] == "group_04_28") {?>
	        		<input type="hidden" name="hero_life_gisu" value="<?=$_GET["hero_life_gisu"]?>" />
	        	<? } ?>
	        	<input type="hidden" name="hero_gisu" value="<?=$_GET["hero_gisu"]?>" />
	        	
                <? 
				if($_GET['board'] == 'group_04_05' || $_GET['board'] == 'group_04_07' || $_GET['board'] == 'group_04_06' || $_GET['board'] == 'group_04_25' 
					|| $_GET['board'] == 'group_04_23' || $_GET['board'] == 'group_04_27' || $_GET['board'] == 'group_04_28') {
					?>
                    <input type="hidden" name="select" value="hero_title" />
                    <?
				}else { 
				?>
                <? if($_GET['board'] == 'search_result'){ ?>
                    <select name="select">
                        <option value="hero_title"<?if(!strcmp($_REQUEST['select'], 'hero_title')){echo ' selected';}else{echo '';}?>>제목</option>
                        <option value="hero_nick"<?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>작성자</option>
                    </select>
                <? } else if($_GET['board'] != 'group_04_22'){?>
                    <select name="select">
                        <?php
                        if($_GET['board']=='mission')						$seachOption_text_01 = "체험단명";
                        elseif($_GET['board']=='myreply')					$seachOption_text_01 = "게시글 제목";
                        else												$seachOption_text_01 = "제목";
                        ?>
                        <option value="hero_title"<?if(!strcmp($_GET['select'], 'hero_title')){echo ' selected';}else{echo '';}?>><?=$seachOption_text_01?></option>

                        <?php
                        if($_GET['board']=='myreply')						$seachOption_text_02 = "댓글 내용";
                        else												$seachOption_text_02 = "내용";
                        if($_GET['board']!='mission' && $_GET['board'] != 'mission' && $_GET['board'] != 'group_04_05' && $_GET['board'] != 'group_04_07' && $_GET['board'] != 'group_04_06' && $_GET['board'] != 'group_04_23' && $_GET['board'] != 'group_04_08' && $_GET['board'] != 'group_04_09' && $_GET['board'] != 'group_04_25' && $_GET['board'] != 'group_04_27' && $_GET['board'] != 'group_04_28'){
                        ?>
                            <option value="hero_command"<?if(!strcmp($_GET['select'], 'hero_command')){echo ' selected';}else{echo '';}?>><?=$seachOption_text_02?></option>
                        <?php
                        }
                        if($_GET['board']=='myreply')						$seachOption_text_03 = "작성자 닉네임";
                        elseif($_GET['board']=='mail_sent')					$seachOption_text_03 = "수신자 닉네임";
                        elseif($_GET['board']!='group_04_10')               $seachOption_text_03 = "닉네임";
                        if($_GET['board']!='mylist' && $_GET['board']!='mission' && $_GET['board']!='cus_2' && $_GET['board']!='cus_3' && $_GET['board']!= 'group_04_05' && $_GET['board']!= 'group_04_07' && $_GET['board']!= 'group_04_06' && $_GET['board']!= 'group_04_23' && $_GET['board']!= 'group_04_08' && $_GET['board'] != 'group_02_03' && $_GET['board'] != 'group_04_03' && $_GET['board'] != 'group_04_25' && $_GET['board'] != 'group_04_27' && $_GET['board'] != 'group_04_28' && $_GET['board'] != 'group_04_10'){
                        ?>
                            <option value="hero_nick"<?if(!strcmp($_GET['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>><?=$seachOption_text_03?></option>
                        <?php
                        }
                        if($_GET['board'] != 'myreply' && $_GET['board'] != 'mail_sent' && $_GET['board'] != 'mission' && $_GET['board'] != 'group_04_05' && $_GET['board'] != 'group_04_07' && $_GET['board'] != 'group_04_06' && $_GET['board'] != 'group_04_23' && $_GET['board'] != 'group_04_08' && $_GET['board'] != 'group_02_03' && $_GET['board'] != 'group_04_09' && $_GET['board'] != 'group_04_10' && $_GET['board'] != 'group_04_03' && $_GET['board'] != 'group_02_02' && $_GET['board'] != 'group_03_03' && $_GET['board'] != 'group_01_01' && $_GET['board'] != 'group_04_25' && $_GET['board'] != 'group_04_27' && $_GET['board'] != 'group_04_28') {
                            $seachOption_text_04 = "제목+내용";
                        ?>
                            <option value="hero_all"<?if(!strcmp($_GET['select'], 'hero_all')){echo ' selected';}else{echo '';}?>><?=$seachOption_text_04?></option>
                        <?php
                        }
                        ?>

                        <?if($_GET['board'] == 'group_04_10') {?>
                        <option value="hero_id" <?if(!strcmp($_GET['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>아이디</option>
                        <? } ?>
                    </select>
                <?}?>
	                <?
					}
				?>		
				<? if($_GET['board'] == 'group_04_05' || $_GET['board'] == 'group_04_06' || $_GET['board'] == 'group_04_27' || $_GET['board'] == 'group_04_28') { ?>
					<select name="hero_type" style="width:140px;font-size:12px;height:26px;">
						<option value="">체험단 타입</option>
						<? if($_GET['board'] == 'group_04_06' || $_GET['board'] == 'group_04_27' || $_GET['board'] == 'group_04_28') {?>
							<option value="0" <?=$_GET["hero_type"] == 0 && strlen($_GET["hero_type"]) == 1 ? "selected":"";?>>정기미션</option>
							<option value="7" <?=$_GET["hero_type"] == 7 ? "selected":"";?>>자율미션</option>
						<? } else {?>
							<option value="0" <?=$_GET["hero_type"] == 0 && strlen($_GET["hero_type"]) == 1 ? "selected":"";?>>일반미션</option>
						<? } ?>
							<option value="1" <?=$_GET["hero_type"] == 1 ? "selected":"";?>>이벤트</option>
							<option value="2" <?=$_GET["hero_type"] == 2 ? "selected":"";?>>소문내기</option>
							<option value="3" <?=$_GET["hero_type"] == 3 ? "selected":"";?>>설문조사</option>
							<option value="5" <?=$_GET["hero_type"] == 5 ? "selected":"";?>>제품품평</option>
							<option value="8" <?=$_GET["hero_type"] == 8 ? "selected":"";?>>포인트체험</option>
					</select>
				<? } ?>
				<input name="kewyword" type="text" value="<?echo stripslashes($_REQUEST['kewyword']);?>" class="kewyword" placeholder="검색어를 입력하세요.">
	            <a href="javascript:$('#frm').submit();" class="mu_search_btn screen_out">검색</a>
					<?php
						## 로그인 + 내가 쓴 게시글 페이지가 아닐 경우  
						if($_SESSION['temp_level']>0 && $_GET['board']!='mylist' && $_GET['board']!='group_04_03' && $_GET['board']!='mail' && $_GET['board']!='mail_sent' && $_GET['board']!='cus_2' && $_GET['board']!='cus_3' && $_GET['board']!='group_02_03' && $_GET['board'] != 'group_04_05' && $_GET['board'] != 'group_04_07' && $_GET['board'] != 'group_04_06' && $_GET['board'] != 'group_04_23' && $_GET['board'] != 'group_04_08' && $_GET['board'] != 'group_04_25' && $_GET['board'] != 'group_04_27' && $_GET['board'] != 'group_04_28' && $_GET['board'] != 'group_04_24'){
					?>
                    <!-- <a href="javascript:;" onclick="location.href='<?="?board=".$_GET['board']."&select=hero_nick&kewyword=".$_SESSION['temp_nick'];?>'" class="search_btn screen_out">내 글 검색</a> -->
	            <?php }?>
				<? if($_GET['board'] == 'group_04_05' || $_GET['board'] == 'group_02_03' || $_GET['board'] == 'group_02_10'){ ?>
					<div class="mo mo_cal screen_out">모바일날짜선택아이콘</div>	
				<? }?>				
			</div>
			<!-- 카테고리 -->
			<? if($_GET['board'] == 'group_04_05') { //멀티클럽
					if(count($_GET['hero_kind']) > 0) {
						if (in_array("제품체험", $_GET['hero_kind'])) {
							$prod = "checked";
						}
						if (in_array("제품품평", $_GET['hero_kind'])) {
							$testing = "checked";
						}
						if (in_array("설문조사", $_GET['hero_kind'])) {
							$survey = "checked";
						}
						if (in_array("소문내기", $_GET['hero_kind'])) {
							$telling = "checked";
						}
					}
				?>
				<div class="title fz28 fw800">CATEGORY</div>				
				<div class="cate_check_list mb_0">	
					<ul class="grid_4">
						<li>
							<input type="checkbox" name="hero_kind[]" value="제품체험" id="prod" <?=$prod?>>
							<label value="제품체험" for="prod">
								제품체험
							</label>
						</li>
						<li>
							<input type="checkbox" name="hero_kind[]" value="제품품평" id="testing" <?=$testing?>>
							<label value="제품품평" for="testing">
								제품품평
							</label>
						</li>
						<li>
							<input type="checkbox" name="hero_kind[]" value="설문조사" id="survey" <?=$survey?>>
							<label value="설문조사" for="survey">
								설문조사
							</label>
						</li>
						<li>
							<input type="checkbox" name="hero_kind[]" value="소문내기" id="telling" <?=$telling?>>
							<label value="소문내기" for="telling">
								소문내기
							</label>
						</li>
					</ul>
				</div>		
				<? if($_GET['board'] == 'group_04_05'){ ?>
					<div class="btn_wrapper t_c">
						<button class="search_btn fz18 fw600">검색하기</button>
					</div>
				<? } ?>	
			<? } ?>

			<!-- 날짜 -->
			<div class="datebox pc">
				<div class="title fz32 bold t_c rel mo">기간조회 <input type="image" src="/m/img/musign/board/search_x.webp" alt="닫기" class="mo_call_x"></div>	
				<div class="title fz20 fw600">DATE</div>	
				<div class="date_check_list">
                    <input type="checkbox" name="search_month" id="month3" value="00" class="btn_date search_input <?=$_GET["search_month"] == 00 ? "on":"";?>" <?=$_GET["search_month"] == 00 ? "checked":"";?>"><label for="month3">전체</label>
                    <input type="checkbox" name="search_month" id="month1" value="1"  class="btn_date search_input <?=$_GET["search_month"] == 1 ? "on":"";?>" <?=$_GET["search_month"] == 1 ? "checked":"";?>"><label for="month1">1개월</label>
                    <input type="checkbox" name="search_month" id="month2" value="3"  class="btn_date search_input <?=$_GET["search_month"] == 3 ? "on":"";?>" <?=$_GET["search_month"] == 3 ? "checked":"";?>"><label for="month2">3개월</label>
					<input type="checkbox" name="search_month" id="month4" value="99" class="btn_date search_input btn_direct <?=$_GET["search_month"] == 99 ? "on":"";?>" <?=$_GET["search_month"] == 99 ? "checked":"";?>"><label for="month4">직접입력</label>
				</div>
				<div class="date_check_list direct <?=$_GET["search_month"] == 99 ? "on":"";?>"">
					<input type="text" id="date-from" name="date-from" class="input-date date-from call-datepicker search_input">	
					<input type="text" id="date-to" name="date-to" class="input-date date-to call-datepicker search_input">
				</div>
<!--				<button class="mo_search_btn mo">적용하기</button>-->
                <a href="javascript:$('#frm').submit();" class="mo_search_btn mo">검색하기</a>
			</div>
			</form>
	    </div>



		<script>
	$(document).ready(function () {
		//달력셋팅		
		$.datepicker.setDefaults();

		var $periodBtns = $('.btn_date'),
            startDate = $('#date-from').val(),
            endDate = $('#date-to').val(),
            today = new Date(),
            startday,
            datepicker_options = {
                maxDate: '0',
                dateFormat: 'yy.mm.dd', 
				dayNamesMin: ['일','월','화','수','목','금','토'],    
        		showButtonPanel: true,
                beforeShow: function(input, inst) {
                    inst.dpDiv.css('margin-top', 10);
				}
            };

        $('.call-datepicker').datepicker();
        $('.call-datepicker').datepicker('option', datepicker_options);

		$.each($periodBtns, function(){
			$(this).click(function(){
				$periodBtns.removeClass('on');
				$('.direct').removeClass('on');
				$(this).addClass('on');
			})
		});

        $('.btn_direct').click(function(){
            $('.direct').addClass('on');
        });

		//직접선택시
		let date = new Date();
		let year = date.getFullYear();
		let month = new String(date.getMonth()+1);
		let day = new String(date.getDate());
		if(month.length == 1){ month = "0" + month; }
		if(day.length == 1){  day = "0" + day; }
       		
		if (document.getElementById('date-from').value === '' ){
			document.getElementById('date-from').value = year + "." + month + "." + day;
		}
		if (document.getElementById('date-to').value === '' ){
			document.getElementById('date-to').value = year + "-" + month + "." + day;
		}

        //1개월
        $('#month1').click(function(){
            date = new Date();
            date.setMonth(date.getMonth() - 1);

            let year_saerch = date.getFullYear();
            let month_saerch = (date.getMonth() + 1).toString();
            let day_saerch = date.getDate().toString();

            if (month_saerch.length == 1) { month_saerch = "0" + month_saerch; }
            if (day_saerch.length == 1) { day_saerch = "0" + day_saerch; }

            document.getElementById('date-from').value = year_saerch + "." + month_saerch + "." + day_saerch;
            document.getElementById('date-to').value = year + "-" + month + "." + day;
        });
        //3개월
        $('#month2').click(function(){
            date = new Date();
            date.setMonth(date.getMonth() - 3);

            let year_saerch = date.getFullYear();
            let month_saerch = (date.getMonth() + 1).toString();
            let day_saerch = date.getDate().toString();

            if (month_saerch.length == 1) { month_saerch = "0" + month_saerch; }
            if (day_saerch.length == 1) { day_saerch = "0" + day_saerch; }

            document.getElementById('date-from').value = year_saerch + "." + month_saerch + "." + day_saerch;
            document.getElementById('date-to').value = year + "-" + month + "." + day;
        });

		//모바일 달력 온오프
		$('.mo_cal').click(function(e){
			e.preventDefault(e);
			$('.datebox').show();
		});
		$('.mo_call_x').click(function(e){
			e.preventDefault();
			$('.datebox').hide();
		});	
	
	})
</script>