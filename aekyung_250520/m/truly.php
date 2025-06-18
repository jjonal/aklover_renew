<? include_once "head.php";?> 
<link href="css/aklover.css?v=20220825" rel="stylesheet" type="text/css">
<!--컨텐츠 시작-->
<?
$group_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_REQUEST['board'].'\';';//desc
$out_group = @mysql_query($group_sql);
$right_list                             = @mysql_fetch_assoc($out_group);
?>
<? include_once "boardIntroduce.php"; ?>

<div style="clear:both"></div>


<div id="line"></div>
<div class="trulyCont">
	<p class="titleText"><span class="titleLine">l</span>AK LOVER의 진정성</p>
    
    <p style="margin-left:13px; line-height:20px;">애경은 제품 효능의 진정성, 안전한 제품의 개발, 환경 친화적인 제품 개발을 통한 "진정성"에
        노력하고 있습니다.<br/>
        애경 서포터즈 AK LOVER는 이러한 진정성 있는 애경의 제품을 직접 체험 후 진솔한 컨텐츠를 작성해 주시면 됩니다.</p>
        
     <p style="margin-top:40px; padding:0 10px;" class="img"><img src="/image2/intro/truly/truly_img1.jpg" alt="" /></p><br/>
        
        <p class="titleText" style="margin-top:20px;"><span class="titleLine">l</span>AK LOVER의 진정성 있는 컨텐츠란?</p>
        
        <div class="trulyWrap">
        	<div class="section sincerity">
        		<p class="tit">1. 진심</p>
				<div class="first">
		        	<div class="box">
		        		<p><em>거짓없이 솔직하게 작성해요</em></p>
		        		<p>제품을 직접 써보고<br/>진심을 다해 솔직하게 작성한 컨텐츠</p>
		        	</div>
	        	
		        	<p class="txt01">발릴 때는 촉촉~하게 발렸지만
		마무리해준 다음 얼굴을 만져봤을 때 보송보송 산뜻함이 느껴졌어요.<br/><br/>
		
		손을 더럽히지 않고 퍼프로 얼굴을 두드려만 주면
		톤업과 선케어, 모공 블러 처리까지 한 번에 가능하니
		 꾸안꾸 여름필수템으로 딱이라는 생각이 들더라구요</p>
		 
		 			<div class="picture01">
		 				<p><img src="/m/img/aklover/img_truly_sincerity_01.png" /></p>
		 				
		 				<p class="txt_writer">&lt; AGE 20's 스킨 핏 톤업 선팩트 / Beauty Club 10기 폴라 님 &gt;</p>
		 			</div>
		 		</div>
		 		<div class="second last">
		 			<p class="txt01">핑크 컬러에서 화이트로 변할 때까지 맞춰서 씻으니깐<br/>
30초 정도를 꼼꼼하게 씻을 수 있더라구요.<br/>
아주 똑똑한 랩신 V3 컬러체인징은 손세정제 추천할만한 제품이에요</p>
					
					<div class="picture01">
		 				<p><img src="/m/img/aklover/img_truly_sincerity_02.png" /></p>
		 				<p class="txt_writer">&lt; 랩신 핸드워시 3종 / Life Club 1기 maybhong 님 &gt;</p>
		 			</div>
		 		</div>
 			</div>
 			
 			<div class="section sympathy">
 				 <p class="tit">2. 공감</p>	
 				 <div class="first">
	 				 <div class="box">
	 				 	<p><em>이 제품을 사용하게 된 나의 상황을 공유해요!</em></p>
	 				 	<p>본인의 이야기를 담은 스토리텔링을 통해<br/>읽는이에게 공감을 주는 컨텐츠</p>
	 				 </div>
	 				 
	 				 <p class="txt01">제가 진~짜 모공부자예요 모공이 엄청 크고 눈에 확 띄거든요.
근데도 귀찮다는 이유로 프라이머 사용을 안 했었는데
나이가 들어가니깐 안되겠더라고요.<br/><br/>

모공커버를 하냐 안 하냐에 따라서
메이크업 후 피부결이 달라지는 것 같아서
프라이머 사용을 시작했어요.<br/><br/>

루나 베이스레이어링포뮬라 3종을 사용해 봤는데요.
톤업부터 모공커버까지 선택해서 할 수 있는 제품이에요.
</p>

					<p class="txt_writer">&lt; LUNA 베이스 레이어링 포뮬라 3종 / Beauty Club 10기 센이 님 &gt;</p>
 				 </div>
 				 <div class="second last">
 				 	<p class="txt01">
 				 		빠르고 깨끗하게 설거지하고 싶은 마음에 선택한 주방세제! 순샘 뽀독
두가지 타입의 주방세제로 취향껏 골라 사용할 수 있어서 좋아요.<br/><br/>

저는 평소에도 향이 있는 제품보다는 향이 없는 제품들을 좋아해서
제일 먼저 무향을 사용해봤어요 ^^

 				 	</p>	
 				 	<p class="txt_writer">&lt; 순샘 뽀독 2종 체험단 / AK LOVER 최*화 &gt;</p>
 				 </div>
 				 
 			</div>
 			
 			<div class="section help">
 				 <div class="first">
 				 	<p class="tit">3. 도움</p>
 				 	<div class="box">
 				 		<p><em>걱정마세요! 체험단 가이드를 참고하세요!</em></p>
 				 		<p>정확한 정보 제공으로 읽는이에게 도움이 되는 컨텐츠</p>	
 				 	</div>	
 				 	
 				 	<p class="txt01">진짜 오일같지 않게 가볍고 산뜻해서 답답함은 전혀 없기 때문에
양을 듬뿍 듬뿍해서 넉넉한 양으로 바르고 롤링을 해주고 있는데요.<br/><br/>

이렇게 데일리 루틴으로 피지케어를 해주면
4주후 일상 피지 수준 개선율이 무려 54.99%라는
인체적용시험결과도 있다고 하더라고요.
대한피부과학연구소 / 20명 / 2020.11.11~12.30
</p>

					<p class="txt_writer">&lt; 포인트앤 피지 쏙 베지 클렌징오일 + 실리콘 모공브러쉬 / Beauty Club 10기 천안댁낭아 님 &gt;</p>
 				 </div>
 				 <div class="second last">
 				 	<p class="txt01">
 				 		온도와 습도가 높은 여름 장마철에는
빨래를 잘 해도 기분 나쁜 냄새가 남아있을 때가 많아요.
이 불쾌한 냄새가 나는 이유는 바로 세균과 습도 때문인데요.<br/><br/>

한국에서는 다소 생소한 섬유항균제는
미국이나 유럽, 중국에서 이미 사용되고 있는 섬유 전문 살균제에요.<br/><br/>

대장균이나 폐렴간균과 같은 세균부터
곰팡이인 칸디다균까지 99.9% 살균효과가 있어서
균으로 인한 꿉꿉한 빨래냄새를 제거해줘요.

 				 	</p>
 				 	
 				 	<p class="txt_writer">&lt; 랩신 섬유항균제 / Life Club 3기 아웃화 님  &gt;</p>
 				 </div>
 			</div>
        </div>
</div>
<!--컨텐츠 종료-->
<?include_once "tail.php";?>