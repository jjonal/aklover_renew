<?

$title_view_all = "";
$titleBigType = "";
switch($_REQUEST ['board']){
	case "group_01_01" : //기자단활동
		$title_view_all = "AK LOVER 대학생 기자단의 활동 내용을 공유하는 공간입니다. 현재는 운영하고 있지 않으나, 더 좋은 모습으로 찾아 뵙겠습니다!";
		break;
	case "group_01_02" : 
		$title_view_all = "청소, 세탁, 육아, 기타 생활정보";
		break;
	case "group_01_03" :  
		$title_view_all = "레시피, 맛집, 기타 요리 정보";
		break;
	case "group_01_04" :  
		$title_view_all = "여행, 공연, 독서, 기타 문화 정보";
		break;
	case "group_02_01" : 
		$title_view_all = "오늘 하루 일상을 남겨주세요";
		break;
	case "group_02_03" : //게릴라이벤트
		$title_view_all = "이달의 이벤트";
		break;
	case "group_02_02" : //수다통
			if($_GET["gubun"] == "1") {
				$title_view_all="AK LOVER 여러분의 일상 속 이야기를 자유롭게 공유해주세요.<br/>나만이 가지고 있는 생활 속 꿀팁들도 공유해주시는 것도 좋아요!";
			} else if($_GET["gubun"] == "2") {
				$title_view_all="AK LOVER 홈페이지에서 진행되는 체험단, 이벤트 진행 부터 후기 작성 등 다양한 의견을 자유롭게 공유해주세요.";
			} else if($_GET["gubun"] == "3") {
				$title_view_all="애경 제품에 대한 보완 및 개선에 대한 의견을 자유롭게 작성해주세요.";
			} else {
				$title_view_all="수다통은 AK LOVER 회원분들의 소소한 이야기, 일상 속 유익한 정보 공유, 체험단, 활동 관련등 다양한 이야기를 자유롭게 나누는 공간입니다.";
			}
		break;
	case "group_02_05" :  
		$title_view_all = "지역별, 연령별, 목적별로 게시글을 통해 오프라인으로 만나요";
		break;
	case "group_03_03" :  //정보통
		$title_view_all = "유익한 정보를 서로 공유하는 공간입니다.";
		break;
	case "group_03_04" : 
		$title_view_all = "제품에 대한 아이디어를 남겨주세요";
		break;
	case "group_03_05" :  
		$title_view_all = "제품에 대해 칭찬해주세요";
		break;
	case "mail" : 
		$title_view_all = "쪽지함입니다";
		break;
	case "group_04_03" : 
		$title_view_all = "AK LOVER의 공지사항입니다.";
		break;
	case "group_04_04" :  //출석체크
		$title_view_all = "매일 출석체크하고 포인트 1점을 획득하는 공간입니다.";
		break;
	case "group_04_05" :  //체험단
		$title_view_all = "애경 제품을 직접 체험할 수 있는 공간입니다.";
		break;
	case "group_04_06" :  //뷰티클럽
		$title_view_all = "별도 선발된 Beauty Club 회원들만을 위한 공간입니다.";
		break;
	case "group_04_25" :  //뷰티홀릭
		$title_view_all = "별도 선발된 뷰티홀릭 회원들만을 위한 공간입니다.";
		break;
	case "group_04_07" :  //애경박스
		$title_view_all = "애경 제품을 나누고 사랑과 존경을 전하는 공간입니다.";
		break;
	case "group_04_08" :  //기자단
		$title_view_all = "별도 선발된 AK LOVER 기자단 회원들만을 위한 공간입니다.";
		break;
	case "group_04_09" :  //체험후기
		$title_view_all = "체험후기";
		break;
	case "group_04_10" : //우수후기
		$title_view_all = "우수 후기에 선정되신 컨텐츠를 확인할 수 있는 공간입니다.";
		break;
	case "group_04_11" : 
		$title_view_all = "파워 블로그 팁을 알려드려요";
		break;
	case "group_04_20" : //운송장확인
		$title_view_all = "제품/선물 발송 관련 소식을 알려드려요";
		break;
	case "group_04_21" : //포인트축제
		$title_view_all = "매년 1회 AK LOVER 포인트로 애경 제품을 교환할 수 있는 공간입니다.";
		break;
	case "group_04_22" : //모임후기
		$title_view_all = "품평회, 문화강좌 등 행사 후기를 확인할 수 있는 공간입니다.";
		break;
	case "group_04_23" :  //휘슬클럽
		$title_view_all = "애경의 애경/애묘용품을 직접 체험하고 다양한 소식을 전하는 휘슬클럽 회원 여러분만을 위한 공간입니다.현재는 운영하고 있지 않으나, 더 좋은 모습으로 찾아 뵙겠습니다!";
		break;
	case "mylist" : 
		$title_view_all = "내가 쓴 게시글";
		break;
	case "cus_3" : 
		$title_view_all = "1:1 문의사항을 남겨 주세요";
		break;	
	case "group_04_24" : //배움통
		if($_GET["gubun"] == "1") {
			$title_view_all="AK LOVER 홈페이지 활동 및 리뷰 작성 시 반드시 참고해야 하는 내용입니다.";
		} else if($_GET["gubun"] == "2") {
			$title_view_all="네이버 블로그 후기 작성 꿀팁을 배우는 공간입니다.";
		} else if($_GET["gubun"] == "3") {
			$title_view_all="인스타그램 후기 작성 꿀팁을 배우는 공간입니다.";
		} else if($_GET["gubun"] == "4") {
			$title_view_all="유튜브 또는 영상 촬영 관련 꿀팁을 배우는 공간입니다.";
		} else {
			$title_view_all="애경 서포터즈 AK LOVER 회원분들과 배움을 함께 하는 공간입니다.";
		}
		break;	
	case "group_04_26" : //휘슬통
		$title_view_all="반려동물(반려견, 반려묘 등)에 대한 소소한 이야기, 정보를 나누는 소통의 공간입니다.";
		break;
	case "group_04_27" :  //AK 러버 유튜버
		$title_view_all = "애경의 뷰티 제품 또는 생활용품을 직접 체험하고 다양한 소식을 전하는 Beauty/Life Club 영상팀 여러분만을 위한 공간입니다."; 
		break;
	case "group_04_28" :  //라이프 클럽
		$title_view_all = "애경 생활용품을 직접 체험하고 다양 소식을 전하는 Life Club 회원 여러분만을 위한 공간입니다.";
		break;
	case "findpw" :  //아이디/비밀번호 찾기
		$title_view_all = "회원가입 시 입력한 정보로 아이디/비밀번호를 찾을 수 있습니다.";
		$titleBigType = "Y";
		break;
	case "without" :  //아이디/비밀번호 찾기
		$title_view_all = "회원가입 시 입력한 정보로 아이디/비밀번호를 찾을 수 있습니다.";
		break;
	case "group_04_29" : 
		$title_view_all = "월 별 우수회원으로 선정된 AK LOVER 회원에게는 특별한 혜택을 제공해드립니다.";
		break;
	case "orderlist" :
		$title_view_all = "매년 1회 AK LOVER 포인트로 애경 제품을 교환할 수 있는 공간입니다.";
		break;
}

if($_REQUEST["board"] == "agreement") {
	$right_list['hero_title'] = "회원가입";
} else if($_REQUEST["board"] == "auth") {
	$right_list['hero_title'] = "본인인증 및 추가정보 입력";
}
?>
<div class="introTxtWrap">
	<h1 class="fz44 fw600"><?=$title_view_all?></h1>
</div>
    

