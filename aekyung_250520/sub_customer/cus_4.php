<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$sql = 'select * from hero_group where hero_order=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);
######################################################################################################################################################
?>

        <div class="contents" >

		<div id="menuList">
		
			<div class="menu" >
			    <h3 class="titel">&nbsp;&nbsp;&nbsp;&nbsp;<img src="../image/sitemap/menu1.png" width="46" height="17" alt="" /></h3>
					<ul class="list1">
						<li><a href="/main/index.php?board=group_01_01">꽃미녀 팁</a></li>
						<li><a href="/main/index.php?board=group_01_02">주부9단 팁</a></li>
						<li><a href="/main/index.php?board=group_01_03">미식가 팁</a></li>
						<li><a href="/main/index.php?board=group_01_04">예술가 팁</a></li>
					</ul>
			</div>
		
			<div class="menu">
					<h3 class="titel">&nbsp;&nbsp;&nbsp;&nbsp;<img src="../image/sitemap/menu2.png" width="45" height="17" alt="" /></h3>
					<ul class="list1">
						<li><a href="/main/index.php?board=group_02_01">오늘하루</a></li>
						<li><a href="/main/index.php?board=group_02_02">연예&결혼</a></li>
					</ul>
			</div>
		
			<div class="menu">
					<h3 class="titel">&nbsp;&nbsp;&nbsp;&nbsp;<img src="../image/sitemap/menu3.png" width="45" height="17" alt="" /></h3>
					<ul class="list1">
						<li><a href="/main/index.php?board=group_03_01">AK 소개</a></li>
						<li><a href="/main/index.php?board=group_03_02">AK 사이트</a></li>
						<li><a href="/main/index.php?board=group_03_03">핫이슈</a></li>
						<li><a href="/main/index.php?board=group_03_04">러버 아이디어</a></li>
						<li><a href="/main/index.php?board=group_03_05">러버 칭찬통</a></li>
					</ul>
			</div>
		
			<div class="menu">
					<h3 class="titel">&nbsp;&nbsp;&nbsp;&nbsp;<img src="../image/sitemap/menu4.png" width="69" height="18" alt="" /></h3>
					<ul class="list2">
						<li><a href="/main/index.php?board=group_04_01">AK Lover란?</a></li>
						<li><a href="/main/index.php?board=group_04_02">포인트 등급 가이드</a></li>
						<li><a href="/main/index.php?board=group_04_03">공지사항</a></li>
						<li><a href="/main/index.php?board=group_04_04">출석체크</a></li> 
						<li><a href="/main/index.php?board=group_04_05">일반 미션</a></li>
						<li><a href="/main/index.php?board=group_04_06">프리미엄 미션</a></li>
						<li><a href="/main/index.php?board=group_04_07">활동 미션</a></li>
						<li><a href="/main/index.php?board=group_04_08">선물상자</a></li>
						<li><a href="/main/index.php?board=group_04_09">생생후기</a></li>
						<li><a href="/main/index.php?board=group_04_10">러버 스타</a></li>
						<li><a href="/main/index.php?board=group_04_11">도전! 파워블로그</a></li>
					</ul>
			</div>
		
			<div class="menu">
					<h3 class="titel">&nbsp;&nbsp;&nbsp;&nbsp;<img src="../image/sitemap/menu5.png" width="67" height="19" alt="" /></h3>
					<ul class="list2">
						<li><a href="/main/index.php?board=mission">내가신청한 미션보기</a></li>
						<li><a href="/main/index.php?board=mail">내 쪽지함</a></li>
						<li><a href="/main/index.php?board=infoedit">회원정보 수정</a></li>
						<li><a href="/main/index.php?board=without">회원탈퇴</a></li>
					</ul>
			</div>
		
			<div class="menu">
					<h3 class="titel">&nbsp;&nbsp;&nbsp;&nbsp;<img src="../image/sitemap/menu6.png" width="60" height="17" alt="" /></h3>
					<ul class="list2">
						<li><a href="/main/index.php?board=cus_1">개인포인트 및 <br />등급표시</a></li>
						<li><a href="/main/index.php?board=cus_2">자주 묻는 질문</a></li>
						<li><a href="/main/index.php?board=cus_3">1:1 문의</a></li>
					</ul>
			</div>
	</div>
	</div>
        

    </div>
<div class="clearfix"></div>  