<? include_once "head.php";?> 
<link href="css/aklover.css?v=1" rel="stylesheet" type="text/css">
<!--컨텐츠 시작-->

<?
$group_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_REQUEST['board'].'\';';//desc
$out_group = @mysql_query($group_sql);
$right_list                             = @mysql_fetch_assoc($out_group);
?>
<? include_once "boardIntroduce.php"; ?>
<div style="clear:both"></div>
<div id="line"></div>
<div id="love1">
	<div class="historyWrap">
	    <div class="introduceTab">
	        <ul class="pointTab">
				<li class="on" rel="tab01">2020년~현재</li>
				<li rel="tab02">2016~2019</li>
				<li rel="tab03">2012-2015</li>
	        </ul>
	    </div>
	
		<div id="tab01" class="tab_content">
			<div class="list">
				<p class="year">2023</p>
				<dl class="monthList">
					<dt>7월</dt>
					<dd>AK LOVER 제5회 온라인 발대식</dd>
				</dl>
				<p class="img_year"><img src="/m/img/aklover/history_ico_2023.png" alt="2023년 연혁 이미지" /></p>
			</div>
			
			<div class="list">
				<p class="year">2022</p>
				<dl class="monthList">
					<dt>9월</dt>
					<dd>AK LOVER 10주년</dd>
					<dt>4월</dt>
					<dd>메타버스 'AK LOVER World' 오픈 (ZEPETO)</dd>
				</dl>
				<p class="img_year"><img src="/m/img/aklover/history_ico_2022.png?v=220825_2" alt="2022년 연혁 이미지" /></p>
			</div>
			
			<div class="list">
				<p class="year">2021</p>
				<dl class="monthList">
					<dt>3월</dt>
					<dd>AK LOVER 제1회 온라인 발대식</dd>
					<dt>5월</dt>
					<dd>웰컴박스 오픈</dd>
					<dt>7월</dt>
					<dd>Global Club 1기 운영</dd>
				</dl>
				<p class="img_year"><img src="/m/img/aklover/history_ico_2021.png?v=220825_2" alt="2021년 연혁 이미지" /></p>
			</div>
			
			<div class="list">
				<p class="year">2020</p>
				<dl class="monthList">
					<dt>12월</dt>
					<dd>Life Club 1기 운영</dd>
				</dl>
				<p class="img_year"><img src="/m/img/aklover/history_ico_2020.png?v=220825_2" alt="2020년 연혁 이미지" /></p>
			</div>
	    </div>
	    
	    <div id="tab02" class="tab_content">
	    	<div class="list">
				<p class="year">2019</p>
				<dl class="monthList">
					<dt>10월</dt>
					<dd>Youtuber 1기 운영</dd>
				</dl>
				<p class="img_year"><img src="/m/img/aklover/history_ico_2019.png?v=220825_2" alt="2019년 연혁 이미지" /></p>
			</div>
			
			<div class="list">
				<p class="year">2017</p>
				<dl class="monthList">
					<dt>1월</dt>
					<dd>총 회원 수 5,000명 달성</dd>
					<dt>3월</dt>
					<dd>AK LOVER 공식 인스타그램 채널 오픈</dd>
					<dt>7월</dt>
					<dd>AK LOVER 피크닉 진행(아이와 함께하는 청양 공장 견학)</dd>
					<dt>11월</dt>
					<dd>AK LOVER 카카오톡 채널 오픈</dd>
				</dl>
				<p class="img_year"><img src="/m/img/aklover/history_ico_2017.png?v=220825_2" alt="2017년 연혁 이미지" /></p>
			</div>
			
			<div class="list">
				<p class="year">2016</p>
				<dl class="monthList">
					<dt>1월</dt>
					<dd>Beauty Club 1기 (루나 서포터즈) 운영</dd>
					<dt>5월</dt>
					<dd>Whistle Club 1기 (반려동물 서포터즈) 운영</dd>
				</dl>
				<p class="img_year"><img src="/m/img/aklover/history_ico_2016.png?v=220825_2" alt="2016년 연혁 이미지" /></p>
			</div>
	    </div>
	    
		<div id="tab03" class="tab_content">
	    	<div class="list">
				<p class="year">2015</p>
				<dl class="monthList">
					<dt>1월</dt>
					<dd>프로슈머 활동 시작(설문조사, FGD/FGI 운영)</dd>
					<dt>1월</dt>
					<dd>대학생 기자단, TOP TEAM 출범</dd>
					<dt>2월</dt>
					<dd>애경박스(제품 나눔 이벤트) 오픈</dd>
					<dt>4월</dt>
					<dd>AK LOVER 공식 유튜브 채널 오픈</dd>
					<dt>6월</dt>
					<dd>AK LOVER 공식 페이스북 채널 오픈</dd>
				</dl>
				<p class="img_year"><img src="/m/img/aklover/history_ico_2015.png?v=220825_2" alt="2015년 연혁 이미지" /></p>
			</div>
			<div class="list">
				<p class="year">2014</p>
				<dl class="monthList">
					<dt>1월</dt>
					<dd>제 1회 AK LOVER’s Day</dd>
					<dt>7월</dt>
					<dd>제 1회 포인트 축제</dd>
					<dt>9월</dt>
					<dd>AK LOVER 모바일 페이지 오픈</dd>
					<dt>12월</dt>
					<dd>후기 컨텐츠 10,000건 달성</dd>
				</dl>
				<p class="img_year"><img src="/m/img/aklover/history_ico_2014.png?v=220825_2" alt="2014년 연혁 이미지" /></p>
			</div>
			<div class="list">
				<p class="year">2013</p>
				<dl class="monthList">
					<dt>9월</dt>
					<dd>오프라인 활동 시작(문화강좌/봉사활동/공연관람)</dd>
					<dt>10월</dt>
					<dd>‘AK LOVER’ 홈페이지 오픈</dd>
					<dt>11월</dt>
					<dd>게릴라 이벤트 시작</dd>
					<dt>12월</dt>
					<dd>Loyal AK LOVER 운영</dd>
				</dl>
				<p class="img_year"><img src="/m/img/aklover/history_ico_2013.png?v=220825_2" alt="2013년 연혁 이미지" /></p>
			</div> 
			<div class="list">
				<p class="year">2012</p>
				<dl class="monthList">
					<dt>9월</dt>
					<dd>애경 서포터즈 'AK LOVER' 출범</dd>
				</dl>
				<p class="img_year"><img src="/m/img/aklover/history_ico_2012.png?v=220825_2" alt="2012년 연혁 이미지" /></p>
			</div>      
		</div>
	</div>
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
<!--컨텐츠 종료-->
<?include_once "tail.php";?>