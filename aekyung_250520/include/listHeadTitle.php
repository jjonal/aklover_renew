<?
	$board = $_GET['board'];
	$img = "headtit_01.png"; //기본이미지
	$text = ""; //텍스트
	$css = "headText"; //기본css
	$css2 = ""; //이미지 다를 경우 margin이 달라 경우에 따라 사용
	
	switch ($board) {
		case "group_04_05" : //체험단
			$text="애경의 다양한 제품을 온/오프라인을 통해 직접 체험할 수 있습니다."; 
			break;
		case "group_02_03" : //이달의 이벤트
			$text="매주 수요일에 업로드 되는 쉽고 간단한 이벤트입니다."; 
			break;
		case "group_04_07" : //애경박스
			$text="매 월 주위의 소중한 이웃, 지인, 가족들에게 애경 제품을 나누고 사랑과 존경을 전하는<br/>애경 서포터즈 AK LOVER만의 특별한 체험단 공간입니다"; 
			break;
		case "group_04_06" : //뷰티스타
			$text="애경의 뷰티 제품을 직접 체험하고 다양한 소식을 전하는 Beauty Club 회원 여러분만을 위한 공간입니다.";
			$img="lev_BeautyHolic.png"; 
			$css="text01";
			$css2="";
			break;
		case "group_04_23" : //휘슬클럽
			$text="애경의 애경/애묘용품을 직접 체험하고 다양한 소식을 전하는 휘슬클럽 회원 여러분만을 위한 공간입니다.<br/>현재는 운영하고 있지 않으나, 더 좋은 모습으로 찾아 뵙겠습니다!"; 
			$img="headtit_03_190228.png";
			$css2="mt10";
			break;
		case "group_04_08" : //기자단
			$text="애경 서포터즈 AK LOVER 내에 대학생 서포터즈로 애경 제품을 직접 체험하고 다양한 <br/>애경의 브랜드 소식을 전하는 기자단 여러분만을 위한 공간입니다.";
			$img="headtit_04.png"; 
			$css="text03";
			break;
		case "group_04_20" : //운송장확인
			$text="체험단, 게릴라 이벤트, 애경박스 당첨 회원에게 발송해 드리는 제품 운송장 정보를 직접<br/>확인 할 수 있는 공간입니다."; 
			$css2="imgMargin";
			break;
		case "group_04_21" : //포인트축제
			$text="애경 서포터즈 AK LOVER 활동을 통해 적립된 포인트로 애경 제품을 교환 할 수 있는 축제입니다."; 
			$css="text04";
			$css2="imgMargin";
			break;
		case "group_02_02" : //수다통
			if($_GET["gubun"] == "1") {
				$text="AK LOVER 여러분의 일상 속 이야기를 자유롭게 공유해주세요.<br/>나만이 가지고 있는 생활 속 꿀팁들도 공유해주시는 것도 좋아요!";
			} else if($_GET["gubun"] == "2") {
				$text="AK LOVER 홈페이지에서 진행되는 체험단, 이벤트 진행 부터 후기 작성 등<br/>다양한 의견을 자유롭게 공유해주세요.";
			} else if($_GET["gubun"] == "3") {
				$text="애경 제품에 대한  보완 및 개선에 대한 의견을 자유롭게 작성해주세요.";
			} else {
				$text="수다통은 AK LOVER 회원분들의 소소한 이야기, 일상 속 유익한 정보 공유, 체험단, 활동 관련등<br/>다양한 이야기를 자유롭게 나누는 공간입니다.";
			}
			$css2="imgMargin";
			break;
		case "group_03_03" : //정보통
			$text="할인, 이벤트, 체험단 등의 유익한 정보를 애경 서포터즈 회원분들이 서로 공유 할 수 있는<br/>공간입니다.(애경 외 타사 정보도 공유 가능)"; 
			$css2="imgMargin";
			break;
		case "group_03_05" : //칭찬통
			$text="애경 서포터즈 AK LOVER 혹은 자사 제품에 대해 칭찬을 나누는 공간입니다."; 
			$css="text04";
			$css2="imgMargin";
			break;
		case "group_04_09" : //체험후기
			$text="애경 서포터즈 AK LOVER에서 진행되는 체험단, 이벤트, 문화 활동 등 회원들의 진정성 있는<br/>체험 후기를 직접 확인할 수 있는 공간입니다."; 
			break;
		case "group_04_10" : //우수후기
			$text="애경 서포터즈 AK LOVER 회원분들이 직접 작성하신 후기들 중 우수 후기에 선정되신 컨텐츠들을 <br/>확인할 수 있는 공간입니다."; 
			break;
		case "group_04_22" : //모임후기
			$text="애경 서포터즈 AK LOVER에서 진행한 AK LOVER’S DAY(신년파티), 품평회, 봉사활동, 문화강좌 등 <br/>행사 후기를 직접 확인할 수 있는 공간입니다."; 
			break;
		case "group_04_24" : //AK LOVER TIP
			if($_GET["gubun"] == "1") {
				$text="AK LOVER 홈페이지 활동 및 리뷰 작성 시 반드시 참고해야 하는 내용입니다.";
			} else if($_GET["gubun"] == "2") {
				$text="네이버 블로그 후기 작성 꿀팁을 배우는 공간입니다.";
			} else if($_GET["gubun"] == "3") {
				$text="인스타그램 후기 작성 꿀팁을 배우는 공간입니다.";
			} else if($_GET["gubun"] == "4") {
				$text="유튜브 또는 영상 촬영 관련 꿀팁을 배우는 공간입니다.";
			} else {
				$text="애경 서포터즈 AK LOVER 회원분들과 배움을 함께 하는 공간입니다.";
			}
			$css2="imgMargin";
			break;
		case "group_01_01" : //기자단활동
			$text="애경 서포터즈 AK LOVER 대학생 기자단이 기자단 활동 및 애경 제품의 다양한 정보를<br/>전하는 공간입니다. 현재는 운영하고 있지 않으나, 더 좋은 모습으로 찾아 뵙겠습니다!";
			break;
		case "group_04_04" : //출석체크
			$text="출석체크 시 1포인트가 지급되며, 한달 동안 빠짐없이 출석하시면, 추가로 50포인트를 드립니다. <br/>매일매일 출석체크에 도전하세요!!";
			break;
		case "group_04_25" : //뷰티홀릭
			$text="애경의 뷰티 제품을 직접 체험하고 다양한 소식을 전하는 뷰티클럽 회원 여러분만을 위한 공간입니다.";
			$img="lev_BeautyHolic.png";
			$css="text01";
			$css2="";
			break;
		case "group_04_26" : //휘슬통
			$text="반려동물(반려견, 반려묘 등)에 대한 소소한 이야기, 정보를 나누는 소통의 공간입니다.";
			$css2="imgMargin";
			break;
		case "group_04_27" : //aklover 유튜버
			$text="애경의 뷰티 제품 또는 생활용품을 직접 체험하고 다양한 소식을 전하는 Beauty/Life Club 영상팀 여러분만을 위한 공간입니다.";
			$img="headtit_group_04_27.png";
			$css2="mt10";
			break;
		case "group_04_28" : //aklover 유튜버
			$text="애경 생활용품을 직접 체험하고 다양한 소식을 전하는 Life Club 회원 여러분만을 위한 공간입니다.";
			$img="headtit_28.jpg";
			$css2="";
			break;
		case "group_04_29" : //loyal ak lover
			$text="월 별 우수회원으로 선정된 AK LOVER 회원에게는 특별한 혜택을 제공해드립니다.";
			break;

  }
?>
<div class="listHeadTitle">
	<div class="headImg <?=$css2?>"><img src="/image2/<?=$img?>"/></div>
    <div class="<?=$css?>"><?=$text?></div>
</div>

<div style="clear:both"></div>