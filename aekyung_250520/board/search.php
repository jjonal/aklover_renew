<!-- <script src="/js/datetimePicker/jquery.datetimepicker.full.min.js"></script>
<link rel="stylesheet" href="/js/datetimePicker/jquery.datetimepicker.css"> -->
<script src="/js/musign/library/jquery-ui.min.js"></script>
<?
if(!defined('_HEROBOARD_'))exit;
?>
<div class="mu_searchbox">
	<form action="<?=PATH_HOME;?>" method="GET" id="searchFrm">
	<!-- 검색어 -->
		<div class="title fz20 fw800 pc">SEARCH</div>
		<div class="search_cont rel">
			<input type="hidden" name="board" value="<?=$_GET['board']?>"/>
			<input type="hidden" name="statusSearch" id="statusSearch" value="<?=$_GET['statusSearch']?>"/>
			<? if($_GET['board'] == "cus_3"){ //1:1문의?>
				<input type="hidden" name="view_type" value="<?=$_GET["view_type"]?>" />
			<? } ?>
			<? if($_GET['idx']){?>
				<input type="hidden" name="idx" value="<?=$_GET['idx']?>"/>
			<? }?>
			<? if($_GET["board"] == 'group_02_02' || $_GET["board"] == "group_04_24") {//카테고리?>
				<input type="hidden" name="gubun" value="<?=$_GET['gubun']?>"/>
			<? } ?>
            <? if($_GET['lot_01'] == "1"){ //나의 체험단 탭 구분?>
                <input type="hidden" name="lot_01" value="<?=$_GET["lot_01"]?>" />
            <? } ?>
			<? if($_GET['board'] == 'group_04_05' || $_GET['board'] == 'group_04_06' || $_GET['board'] == 'group_04_27' || $_GET['board'] == 'group_04_28') { ?>
			<input type="hidden" name="select" value="hero_title" />
			<?} else {?>


				<!--!!!!!!!! [개발요청] 검색 말머리 기능이었으나 삭제 및 선택시 바로 검색으로 기능이 변경되어서 확인 부탁드립니다  -->
				<? if($_GET["board"] == "group_04_24") {?>
				<select name="hero_keywords" class="dis-no">
					<option value="">말머리 선택</option>
					<? foreach($hero_keywords_arr as $key=>$val) {?>
						<option value="<?=$key?>" <?=$_GET["hero_keywords"] == $key ? "selected":"";?>><?=$val?></option>
					<? } ?>
				</select>
				<? } ?>

				<select name="select">
                    <? if(!$_GET['board']=='group_04_33') { ?>
                        <? if($_GET['board']=='mission')						$seachOption_text_01 = "체험단명";
                        elseif($_GET['board']=='myreply')					$seachOption_text_01 = "게시글 제목";
                        else												$seachOption_text_01 = "제목";
                        ?>
                        <option value="hero_title"<?if(!strcmp($_GET['select'], 'hero_title')){echo ' selected';}else{echo '';}?>><?=$seachOption_text_01?></option>
                        <? if($_GET['board']=='myreply')						$seachOption_text_02 = "댓글 내용";
                        else												$seachOption_text_02 = "내용";
                        if($_GET['board']!='mission' && $_GET['board'] != 'group_04_05' && $_GET['board'] != 'group_04_06' && $_GET['board'] != 'group_04_27' && $_GET['board'] != 'group_04_28'){
                        ?>
                        <option value="hero_command"<?if(!strcmp($_GET['select'], 'hero_command')){echo ' selected';}else{echo '';}?>><?=$seachOption_text_02?></option>
                        <? }
                        if($_GET['board']=='myreply')						$seachOption_text_03 = "작성자 닉네임";
                        elseif($_GET['board']=='mail_sent')					$seachOption_text_03 = "수신자 닉네임";
                        else												$seachOption_text_03 = "작성자";
                        if($_GET['board']!='mylist' && $_GET['board']!='mission' && $_GET['board']!='cus_2' && $_GET['board']!='cus_3' && $_GET['board']!= 'group_04_05' && $_GET['board']!= 'group_04_06' && $_GET['board'] != 'group_02_03' && $_GET['board'] != 'group_04_03' && $_GET['board']!= 'group_04_27' && $_GET['board']!= 'group_04_28'){
                        ?>
                        <option value="hero_nick"<?if(!strcmp($_GET['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>><?=$seachOption_text_03?></option>
                        <? }
                        if($_GET['board'] != 'mail' && $_GET['board'] != 'myreply' && $_GET['board'] != 'mail_sent' && $_GET['board'] != 'mission' && $_GET['board'] != 'group_04_05' && $_GET['board'] != 'group_04_06' && $_GET['board'] != 'group_02_03' && $_GET['board'] != 'group_04_09' && $_GET['board'] != 'group_04_10' && $_GET['board'] != 'group_04_03' && $_GET['board'] != 'group_02_02' && $_GET['board'] != 'group_03_03' && $_GET['board'] != 'group_01_01' && $_GET['board'] != 'cus_2' && $_GET['board'] != 'group_04_27' && $_GET['board'] != 'group_04_28') {
                        $seachOption_text_04 = "제목+내용";
                        ?>
                        <option value="hero_all"<?if(!strcmp($_GET['select'], 'hero_all')){echo ' selected';}else{echo '';}?>><?=$seachOption_text_04?></option>
                        <? } ?>
                        <?if($_GET['board'] == 'group_04_10') {?>
                        <option value="hero_id" <?if(!strcmp($_GET['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>아이디</option>
                        <? } ?>

                        <option value="hero_title"<?if(!strcmp($_GET['select'], 'hero_command')){echo ' selected';}else{echo '';}?>><?=$seachOption_text_02?></option>

                    <? }
                    else if($_GET['board']=='group_02_02') {//수다통 (러버톡)?>
                        <option value="hero_title"<?if($_GET['select'] == 'hero_title'){echo ' selected';}else{echo '';}?>>제목</option>
                        <option value="hero_command"<?if($_GET['select'] == 'hero_command'){echo ' selected';}else{echo '';}?>>내용</option>
                    <? }else if($_GET['board']=='group_04_10') {//우수후기?>
                        <option value="hero_title"<?if($_GET['select'] == 'hero_title'){echo ' selected';}else{echo '';}?>>제목</option>
                        <option value="hero_command"<?if($_GET['select'] == 'hero_command'){echo ' selected';}else{echo '';}?>>내용</option>
                        <option value="hero_nick"<?if($_GET['select'] == 'hero_nick'){echo ' selected';}else{echo '';}?>>닉네임</option>
                    <? }else {
                        $seachOption_text_02 = "제목"?>
                        <option value="hero_title"<?if(!strcmp($_GET['select'], 'hero_title')){echo ' selected';}else{echo '';}?>><?=$seachOption_text_02?></option>
                        <option value="hero_nick"<?if($_GET['select'] == 'hero_nick'){echo ' selected';}else{echo '';}?>>닉네임</option>
                        <?
                    }?>
				</select>
			<? } ?>
				<? if($_GET['board'] == 'group_04_05' || $_GET['board'] == 'group_04_06' || $_GET['board'] == 'group_04_27' || $_GET['board'] == 'group_04_28') { ?>
				<select name="hero_type" style="padding:6px 6px;width:140px;font-size:14px;">
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
			<input name="kewyword" type="text" value="<?echo stripslashes($_GET['kewyword']);?>" class="kewyword wid100" placeholder="검색어를 입력해주세요">
			<input type="submit" class="mu_search_btn screen_out" value="검색" />
			<?
			## 로그인 + 내가 쓴 게시글 페이지가 아닐 경우
			if($_GET['board'] != 'group_04_33' && $_GET['board'] != 'group_04_09' && $_SESSION['temp_level']>0 && $_GET['board']!='mylist' && $_GET['board']!='mission' && $_GET['board']!='group_04_03' && $_GET['board']!='mail' && $_GET['board']!='mail_sent' && $_GET['board']!='cus_2' && $_GET['board']!='cus_3' && $_GET['board']!='group_02_03' && $_GET['board'] != 'group_04_05' && $_GET['board'] != 'group_04_07' && $_GET['board'] != 'group_04_06' && $_GET['board'] != 'group_04_27' && $_GET['board'] != 'group_04_28' && $_GET['board'] != 'group_04_24' && $_GET['board'] != 'group_02_10' && $_GET['board'] != 'group_02_02'){
			?>
				<input type="button" value="검색" class="my_post mu_search_btn screen_out" onclick="location.href='<?=PATH_HOME."?board=".$_GET['board']."&select=hero_nick&kewyword=".$_SESSION['temp_nick'];?>'"/>
			<? } ?>
            <?
            ## 로그인 + 내가 쓴 게시글 페이지가 아닐 경우
            if($_GET['board'] == 'group_04_33'){
                ?>
                <input type="button" value="검색" class="my_post mu_search_btn screen_out" onclick="location.href='<?=PATH_HOME."?board=".$_GET['board']."&select=hero_command&kewyword=".stripslashes($_GET['kewyword']);?>'"/>
            <? } ?>

			<div class="mo mo_cal screen_out">모바일날짜선택아이콘</div>
		</div>
		<!-- 날짜 -->
		<div class="datebox pc">
			<div class="title fz32 bold t_c rel mo">기간조회 <input type="image" src="/m/img/musign/board/search_x.webp" alt="닫기" class="mo_call_x"></div>
			<div class="title fz20 fw600">DATE</div>
			<div class="date_check_list">
                <div style="font-size: 0;"><input type="radio" name="search_month" id="month3" value="00"  class="btn_date search_input <?=$_GET["search_month"] == 00 ? "on":"";?>" <?=$_GET["search_month"] == 00 ? "checked":"";?>><label for="month3">전체</label></div>
                <div style="font-size: 0;"><input type="radio" name="search_month" id="month1" value="1"   class="btn_date search_input <?=$_GET["search_month"] == 1  ? "on":"";?>" <?=$_GET["search_month"] == 1  ? "checked":"";?>><label for="month1">1개월</label></div>
                <div style="font-size: 0;"><input type="radio" name="search_month" id="month2" value="3"   class="btn_date search_input <?=$_GET["search_month"] == 3  ? "on":"";?>" <?=$_GET["search_month"] == 3  ? "checked":"";?>><label for="month2">3개월</label></div>
				<div style="font-size: 0;"><input type="radio" name="search_month" id="month4" value="99"  class="btn_date search_input btn_direct <?=$_GET["search_month"] == 99 ? "on":"";?>" <?=$_GET["search_month"] == 99 ? "checked":"";?>><label for="month4">직접입력</label></div>
			</div>
			<div class="date_check_list direct <?=$_GET["search_month"] == 99 ? "on":"";?>">
                <?
                    if(!strcmp($_GET['search_month'], '99')){ //직접입력
                        $dateFrom = $_GET['date-from'];
                        $dateTo   = $_GET['date-to'];
                    }
                ?>
				<input type="text" id="date-from" name="date-from" class="input-date date-from call-datepicker search_input">
				<input type="text" id="date-to"   name="date-to"   class="input-date date-to   call-datepicker search_input">
			</div>
			<? if($_GET['board'] == 'group_02_03' || $_GET['board'] == 'group_02_10' || $_GET['board'] == 'group_04_22'){ ?>
				<div class="btn_wrapper t_c">
					<button class="mo_search_btn search_btn fz18 fw600">검색하기</button>
				</div>
			<? } ?>
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
                    if (in_array("포인트체험", $_GET['hero_kind'])) {
                        $point = "checked";
                    }
                    if (in_array("이벤트", $_GET['hero_kind'])) {
                        $event = "checked";
                    }
                }
            ?>
			<div class="title fz20 fw600">CATEGORY</div>
			<div class="cate_check_list">
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
					<!-- <li>
						<input type="checkbox" name="hero_kind[]" value="포인트체험" id="point" <?=$point?>>
						<label value="포인트체험" for="point">
							포인트체험
						</label>
					</li>
					<li>
						<input type="checkbox" name="hero_kind[]" value="이벤트" id="event" <?=$event?>>
						<label value="이벤트" for="event">
							이벤트
						</label>
					</li> -->
				</ul>
			</div>
			<div class="btn_wrapper t_c">
				<button class="mo_search_btn search_btn fz18 fw600">검색하기</button>
			</div>
		<? } ?>
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

		//직접선택시
		$('.btn_direct').click(function(){
			$('.direct').addClass('on');
		});

		let date = new Date();
		let year = date.getFullYear();
		let month = new String(date.getMonth()+1);
		let day = new String(date.getDate());
		if(month.length == 1){ month = "0" + month; }
		if(day.length == 1){  day = "0" + day; }

        let search_month = '<?=$_GET['search_month']?>';
        let board = '<?=$_GET['board']?>';

        if(search_month != '99') { //직접입력 아닐때
            if (document.getElementById('date-from').value === '') {
                document.getElementById('date-from').value = year + "." + month + "." + day;
            }
            if (document.getElementById('date-to').value === '') {
                document.getElementById('date-to').value = year + "." + month + "." + day;
            }
            if('<?=$_GET['date-from']?>' != ''){
                if(board == 'mission'){
                    document.getElementById('date-from').value = '<?=$_GET['date-from']?>';
                    document.getElementById('date-to').value = '<?=$_GET['date-to']?>';
                }
            }
        } else { //직접입력
            document.getElementById('date-from').value = '<?=$_GET['date-from']?>';
            document.getElementById('date-to').value = '<?=$_GET['date-to']?>';
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