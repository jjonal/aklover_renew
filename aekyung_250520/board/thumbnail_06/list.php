<? 
if(!defined('_HEROBOARD_'))exit;

$group_sql = " SELECT * FROM hero_group WHERE hero_order!='0' AND hero_use='1' AND hero_board ='".$_GET['board']."' ";
sql($group_sql);
$right_list = @mysql_fetch_assoc($out_sql);

$startDateOfMonth = date("Y-m")."-01";
$timestamp = strtotime($startDateOfMonth)-1;
$gisu_date = date("Ym", $timestamp);
$gisu_year = substr($gisu_date,0,4);
$gisu_month = substr($gisu_date,4,2);


$loyal_period_sql = " SELECT if(startdate <= date_format(now(),'%Y-%m-%d') AND enddate >= date_format(now(),'%Y-%m-%d'),1,0) as status, hero_month FROM member_loyal_period ";
$loyal_period_res = sql($loyal_period_sql);
$loyal_period_rs = mysql_fetch_assoc($loyal_period_res);

$hero_month = "";
if($loyal_period_rs["hero_month"] > 0) {
    $hero_month = $loyal_period_rs["hero_month"]."월 ";
}

//이달의 Loyal 회원
$review_member_sql =  " SELECT m.hero_nick FROM member_loyal l INNER JOIN member m ON l.hero_code = m.hero_code ";
$review_member_sql .= " WHERE gisu_year = '".$gisu_year."' AND gisu_month = '".$gisu_month."' ORDER BY l.hero_idx ASC ";
$review_member_res = sql($review_member_sql);

//공지사항
if($_SESSION['temp_level']<9999)	$hero_use = " AND b.hero_use=1 "; //임시글 권한 설정	
?>

<div class="contents">
<? include_once("{$_SERVER[DOCUMENT_ROOT]}/include/listHeadTitle.php") ?>

<p class="titleText mgt30">
	<span class="titleLine">l</span> <?=$hero_month?> Loyal AK LOVER
</p>

<div class="loyalMemberWrap">
	<div class="listWrap">
		<div class="tit">Loyal AK LOVER</div>
		<div class="list">
			<? 
			  $k = 0;
			  while($reviewList = mysql_fetch_assoc($review_member_res)) {
			  if($k > 0) $review_nick .= ", ";
			  if($k%5==0 && $k > 0) $review_nick .= "<br/>";
			  $review_nick .= $reviewList["hero_nick"];
			  $k++;}
			?>
			<?=$review_nick?>
			
			<?if($k==0) {?>
				<?=$hero_month?> Loyal AK LOVER 발표 예정입니다.<Br/>조금만 기다려주세요 :)
			<? } ?>
		</div>
	</div>
</div>

<p class="titleText mgt30">
	<span class="titleLine">l</span> Loyal AK LOVER 선정기준
</p>
<div class="loyalStandardWrap border_none">
	<p class="txt_explain">
- 총 20명 선정<br/>
- 블로그 or 인스타그램 계정 有<br/>
- 전월 AK LOVER 참여도 (체험단, 설문조사, 오프라인 모임, 적립 포인트, 홈페이지 활동 등)<br/>
- 고퀄리티 및 진정성 있는 컨텐츠 작성<br/>
- 3개월 내 Loyal AK LOVER 선정자 제외<br/>
	</p>
</div>

<p class="titleText mgt30">
	<span class="titleLine">l</span>  Loyal AK LOVER 혜택
</p>
<div class="loyalStandardWrap">
	<dl>
		<dt>혜택</dt>
		<dd>
			<p>5만원 상당 모바일 신세계 상품권</p>
		</dd>
	</dl>
	<dl>
		<dt>※ 주의사항</dt>
		<dd>
			<p class="icon_hyphen">발표 후 영업일 기준 5일 이내 홈페이지 내 등록 된 번호로 발송</p>
			<p class="icon_hyphen">전국 신세계백화점/이마트 상품권샵에서 <span>종이상품권으로 직접 교환 후</span> 이마트, 신세계백화점, 이마트몰, 신세계몰 등의 제휴처에서 사용 가능</p>
			<p class="icon_hyphen">발급 된 상품권은 기간연장 및 재발급이 불가합니다.<br/>반드시 기간 내 교환 후 사용 부탁드립니다.</p>
		</dd>
	</dl>
</div>
</div>
</div>