<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
if(!strcmp($_SESSION['temp_level'], '')){
    $my_level = '0';
}else{
    $my_level = $_SESSION['temp_level'];
}
if(!strcmp($my_level,'0')){msg('권한이 없습니다.','location.href="'.PATH_HOME.'?board=login"');exit;}

$board = $_GET["board"];

$gubun = $_GET["gubun"];
if(!$gubun) $gubun = "point";

######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);

/* 페이징처리를 위한 변수 **********************************************/
$list_page		=	10;					//한페이지에 나오는 글수
$page_per_list 	=	10;					//paging number
if(!$_GET['page'])		$page = '1';
else					$page = $_GET['page'];
$keyword = $_GET['kewyword'];
$select = $_GET['select'];
//넘버링
$start 		= ($page-1)*$list_page;
/* ************************************************************************/
?>
<script src="/js/musign/library/jquery-ui.min.js"></script>
<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
<div id="subpage" class="mypage date_ver">
	<div class="sub_title">
		<div class="sub_wrap">
			<div class="f_b">
				<h1 class="fz68 main_c fw600">마이페이지</h1>			
			</div>		
			<? include_once BOARD_INC_END.'mypage_top.php';?>
		</div>
	</div>
	<div class="sub_cont">
		<div class="sub_wrap board_wrap f_sb">
			<div class="left">
				<? include_once BOARD_INC_END.'mypage_nav.php';?>
			</div>
			<div class="contents myPointArea right">
				<div class="page_tit fz32 fw600">나의 포인트</div>							
				<div class="introduceTab">
					<ul class="boardTabMenuWrap">
						<a href="/main/index.php?board=mypoint" class="<?=$gubun=="point" ? "on":"";?>">포인트 내역</a>
						<a href="/main/index.php?board=mypoint&gubun=delivery"  class="tab_delivery <?=$gubun=="delivery" ? "on":"";?>">배송비 내역</a>
						<a href="/main/index.php?board=orderlist">포인트 페스티벌 교환내역</a>
					</ul>
				</div>
                <!--포인트 내역 조회-->
				<? if($gubun=="point") { //포인트 내역 조회 ?>
					<!-- 포인트 슈퍼패스 확인용 삭제 예정 s -->
					<div class="member_left dis-no">
						<p class="sub_title"><span>l</span>포인트 현황</p>
						<table class="member mgt10" style="width:100%;">
						<colgroup>
							<col width="150px" />
							<col width="*" />
						</colgroup>
						<tbody>
							<tr>
								<th style="font-weight: normal;">가용 포인트</th>
								<td class="r"><strong><?=number_format($today_use_total)?></strong> P</td>
							</tr>
							<tr>
								<th>회원등급</th>
								<td class="r"><strong><?=$level_list['hero_name']?></strong> 등급</td>
							</tr>
						</tbody>
						</table>
					</div>					
					<div class="member_right dis-no">
						<p class="sub_title"><span>l</span>슈퍼패스 현황</p>
						<table class="member mgt10" style="width:100%;">
						<colgroup>
							<col width="150px" />
							<col width="*" />
						</colgroup>
						<tbody>
							<tr>
								<th style="height:75px">슈퍼패스 발급상태</th>
								<td>
									<? if($superpass_ea>0){ ?>
										<strong>O</strong>
									<? }else{?>
										<strong>X</strong>
									<? }?>
								</td>
							</tr>
							<!--
							<tr height="72">
								<th>슈퍼패스 사용 가능 횟수</th>
								<? if($today_total_list['superpass_sum']>0){?>
									<td><strong><?=$superpass_ea?>회</strong> 사용가능</td>
								<? }else{?>
									<td><strong>0회</strong></td>
								<? }?>
							</tr>
							-->
						</tbody>
						</table>
						<!--
						<p class="member_alert">
							<span>
								* 슈퍼패스는 매 월1회 부여되며, 사용하지 않는 슈퍼패스는
								<br/>&nbsp;&nbsp;&nbsp;매월 마지막날 소멸됩니다.
							</span>
						</p>
						-->
					</div>
					<!-- 포인트 슈퍼패스 확인용 삭제 예정 e -->
					<!-- 검색 -->						
					<form name="sFrm" id="sFrm" action="<?=PATH_HOME?>">
						<input type="hidden" name="board"  value="<?=$_GET['board']?>"/>
						<input type="hidden" name="gubun"  value="<?=$gubun?>"/>
						
						<div class="f_cs mu_searchbox point_search black_btn">
							<div class="datebox f_cs">
								<div class="title fz20 fw600">DATE</div>								
								<div class="date_check_list direct">	
									<input type="text"  id="sdate1" name="hero_today_start" class="dateMode input-date date-from call-datepicker search_input"  value="<?=$_GET['hero_today_start']?>" style="text-align: center"  readonly/>
									<input type="text"  id="edate1" name="hero_today_end"  class="dateMode input-date date-to call-datepicker search_input" value="<?=$_GET['hero_today_end']?>" style="text-align: center"  readonly/>
								</div>
							</div>
							<div class="datebox f_cs">
								<div class="title fz20 fw600">획득/차감</div>								
								<div class="date_check_list point_state direct flex">	
									<div class="input_radio"><input type="radio" name="pointType"  id="pointAll" value="All" <?if($_GET['pointType']=="" || $_GET['pointType']=="All" ) echo checked;?>/><label for="pointAll">전체</label></div>
									<div class="input_radio"><input type="radio" name="pointType"  id="pointPlus" value="Plus" <?if($_GET['pointType']=="Plus" ) echo checked;?>/><label for="pointPlus">획득</label></div>
									<div class="input_radio"><input type="radio" name="pointType"  id="pointMinus" value="Minus" <?if($_GET['pointType']=="Minus" ) echo checked;?>/><label for="pointMinus">차감</label></div>
								</div>
							</div>
							<a href="javascript:goSearch();" class="mu_search_btn screen_out">검색</a>	
						</div>
					</form>
					<?
						// 검색쿼리 설정
						$pointType = $_GET['pointType'];
						$hero_today_start = $_GET['hero_today_start'];
						$hero_today_end = $_GET['hero_today_end'];
						
						$pointLimit = $_GET['pointLimit'];
						
						$where_search = "";
						if($hero_today_start) $where_search .= " and date_format(`hero_today`,'%Y.%m.%d') >= '".$hero_today_start."' ";
						if($hero_today_start) $where_search .= " and date_format(`hero_today`,'%Y.%m.%d') <= '".$hero_today_end."' ";
						
						if($pointLimit == "Y") $where_search .= " and hero_include_maxpoint = 'Y' ";
						
						if($pointType){
							if($pointType == 'Plus') $where_search .="and hero_point > 0 ";
							else if($pointType == 'Minus') $where_search .="and hero_point < 0 ";
						}
						
						$today = date("Y-m-d"); // 오늘날짜
						$month = date("Y-m"); // 이번달
						$today_maxpoint = 20;
						// 획득가능 포인트
						$sql = "select A.hero_point as hero_today_point, B.hero_point as hero_maxpoint ,C.hero_point as hero_search_tot_point, D.hero_point as hero_month_point from
								(select sum(hero_point) as hero_point from point where hero_code='".$_SESSION['temp_code']."' and left(hero_ori_today,10)='".$today."') as A,
								(select sum(hero_point) as hero_point from point where hero_code='".$_SESSION['temp_code']."' and left(hero_ori_today,10)='".$today."' and hero_include_maxpoint='Y') as B,
								(select sum(hero_point) as hero_point from point where hero_code='".$_SESSION['temp_code']."' ".$where_search.") as C,
								(select sum(hero_point) as hero_point from point where hero_code='".$_SESSION['temp_code']."' and left(hero_today,7)='".$month."') as D";
//						echo $sql;
						$out_sql = mysql_query($sql);
						$point_sum = @mysql_fetch_assoc($out_sql);
					?>
					<!-- 가능 포인트 안내문구 -->
					<p class="fz15 today_point">※ 금일 획득 가능 포인트 : <strong class="orange"><?=$today_maxpoint - $point_sum['hero_maxpoint']?></strong>점(금일 <strong class="orange"><? echo $point_sum['hero_today_point'] != "" ?  number_format($point_sum['hero_today_point']) : "0"?></strong>점 획득) / 금월포인트 : <strong class="orange"><? echo $point_sum['hero_month_point'] != '' ? number_format($point_sum['hero_month_point']) : '0'?></strong>점 </p>
					<!-- 포인트 내역 조회 -->
					<table border="0" cellpadding="0" cellspacing="0" class="point_table mgt10">
						<colgroup>
							<col width="25%">
							<col width="*">
							<col width="16%">
							<col width="16%">
						</colgroup>
						<thead>
							<tr class="">
								<th>적립일시</th>
								<th>내용</th>
								<th>획득/차감</th>
								<th>적립포인트</th>
							</tr>
						</thead>
						<tbody>						
						<?
							$search = "";
							$search_next = "";
							
							if($pointType){
								$search_next .= "&pointType=".$pointType;
								
								if($pointType == 'Plus') $search .="and hero_point > 0 ";
								else if($pointType == 'Minus') $search .="and hero_point < 0 ";
							}

							if($hero_today_start && $hero_today_end){
								$search .= "and date_format(`hero_today`,'%Y.%m.%d') between '".$hero_today_start."' and '".$hero_today_end."'";
								$search_next .= "&hero_today_start=".$hero_today_start."&hero_today_end=".$hero_today_end;
							}
							
							if($pointLimit == "Y")  {
								$search .= " and hero_include_maxpoint = 'Y' ";
								$search_next .= "&pointLimit=".$pointLimit;
							}
								
							// 페이징을 위한 데이타 총 갯수
							$sql = "select count(*) cnt from point where hero_code='".$_SESSION['temp_code']."' and hero_point != 0 ".$search;
							$out_sql = mysql_query($sql);
							//$total_data = @mysql_num_rows($out_sql);
							$total_data = @mysql_fetch_array($out_sql); 
							$total_data = $total_data[0]; 
							
							// 게시판 쿼리
							$sql = "select hero_type, hero_mission_idx, hero_top_title, hero_title, hero_point, hero_today, hero_include_maxpoint, edit_hero_code ";
							$sql .="from point ";
							$sql .="where hero_code='".$_SESSION['temp_code']."' and hero_point != 0 ".$search." ";
							$sql .="order by hero_idx desc ";
							$sql .="limit ".$start.",".$list_page."";
//                            echo $sql;

							$out_sql = mysql_query($sql);

							$next_path 	= "board=".$board.$search_next;
							
							if($total_data == 0){
							?>	
							<tr><td colspan="4">검색 결과가 없습니다.</td></tr>
							<? 
							} else{
								while($list = @mysql_fetch_assoc($out_sql)){
									$hero_type = $list['hero_type'];
									$hero_old_idx = $list['hero_old_idx'];
									$hero_mission_idx = $list['hero_mission_idx'];
									$hero_review_idx = $list['hero_review_idx'];
									$hero_id = $list['hero_id'];
									$hero_top_title = $list['hero_top_title'];
									$hero_title = $list['hero_title'];
									$hero_point = $list['hero_point'];
									$edit_hero_code = $list['edit_hero_code'];
									
							?>
						<tr>
							<td><?=$list['hero_today']?></td>
							<td class="t_tit">
								<div class="ellipsis_100">
								<?
									//타입, 게시판번호, 미션번호, 리뷰번호, 아이디, 게시판이름, 포인트이름, 포인트
									pointHistoryContent($hero_type, $hero_old_idx, $hero_mission_idx, $hero_review_idx, $hero_id, $hero_top_title, $hero_title, $hero_point, $edit_hero_code);
								?>
								</div>
							</td>
							<td class="icon_point <? echo $hero_point > 0 ? "plus" : "minus"?>"><span><? echo $hero_point > 0 ? "획득" : "차감"?></span></td>
							<td class="num_pint"><span class="<? echo number_format($hero_point) > 0 ? "" : "minus"?> bold main_c"><? echo number_format($hero_point) > 0 ? "+" : ""?> <?=number_format($hero_point)?> P</span></td>
						</tr>
						<?  } //end while
							} //end if?>
						</tbody>
					</table>						
					<div class="btngroup">
						<div class="paging">
							<? echo page($total_data,$list_page,$page_per_list,$_GET['page'],$next_path);?>
						</div>
					</div>		

					<? }
                    /*배송비 내역 조회*/
                    else if($gubun=="delivery") { // 배송비 내역 조회 ?>
					<form name="sFrm" id="sFrm" action="<?=PATH_HOME?>">
					<input type="hidden" name="board"  value="<?=$_GET['board']?>"/>
					<input type="hidden" name="gubun"  value="<?=$gubun?>"/>						
						<div class="f_cs mu_searchbox point_search black_btn">
							<div class="datebox f_cs">
								<div class="title fz20 fw600">DATE</div>								
								<div class="date_check_list direct" style="margin-right: 0;">	
									<input type="text" id="sdate1" name="hero_today_start" class="dateMode input-date date-from call-datepicker search_input"  value="<?=$_GET['hero_today_start']?>" style="text-align: center"  readonly/>
									<input type="text" id="edate1" name="hero_today_end"  class="dateMode input-date date-to call-datepicker search_input" value="<?=$_GET['hero_today_end']?>" style="text-align: center"  readonly/>
								</div>
							</div>							
							<a href="javascript:goSearch();" class="mu_search_btn screen_out">검색</a>	
						</div>						
					</form>
					<?
						// 검색쿼리 설정
						$hero_today_start = $_GET['hero_today_start'];
						$hero_today_end = $_GET['hero_today_end'];
						
						$where_search = "";
						if($hero_today_start) $where_search .= " and date_format(`hero_today`,'%Y.%m.%d') >= '".$hero_today_start."' ";
						if($hero_today_start) $where_search .= " and date_format(`hero_today`,'%Y.%m.%d') <= '".$hero_today_end."' ";
						
						$today = date("Y-m-d"); // 오늘날짜
						$month = date("Y-m"); // 이번달
						$today_maxpoint = 20;
						
					?>
					<p class="fz15 today_point">
						※ 체험단 신청 시 가용포인트 <?=number_format($_DELIVERY_POINT)?>포인트 차감에 동의한 경우 체험단 제품은 무료로 배송됩니다.<br/>
						※ 체험단에 선정되지 않았을 경우 차감된 포인트는 환급됩니다.
					</p>
					<!-- 배송비 조회 테이블 -->
					<table border="0" cellpadding="0" cellspacing="0" class="point_table">
						<colgroup>
							<col width="25%">
							<col width="*">
							<col width="16%">
							<col width="16%">
						</colgroup>
						<thead>
						<tr>
							<th>적립일시</th>
							<th>내용</th>
							<th>차감/환급</th>
							<th>포인트</th>
						</tr>
						</thead>
						<tbody>						
						<?
							$search = "";
							$search_next = "&gubun=delivery";
							
							if($hero_today_start && $hero_today_end){
								$search .= "and date_format(`hero_regdate`,'%Y.%m.%d') between '".$hero_today_start."' and '".$hero_today_end."'";
								$search_next .= "&hero_today_start=".$hero_today_start."&hero_today_end=".$hero_today_end;
							}
								
							// 페이징을 위한 데이타 총 갯수
							$sql = "select count(*) cnt from order_main where hero_code='".$_SESSION['temp_code']."' and hero_process = 'DE' ".$search;
                            
							$out_sql = mysql_query($sql);
							//$total_data = @mysql_num_rows($out_sql);
							$total_data = @mysql_fetch_array($out_sql); 
							$total_data = $total_data[0]; 
							
							// 게시판 쿼리
							$sql = " select hero_order_point, hero_regdate, (select hero_title from mission where hero_idx = o.mission_idx) delivery_tit ";
							$sql .=" from order_main o ";
							$sql .=" where hero_code='".$_SESSION['temp_code']."' and hero_process = 'DE' ".$search." ";
							$sql .=" order by hero_idx desc ";
							$sql .=" limit ".$start.",".$list_page."";

							$out_sql = mysql_query($sql);

							$next_path 	= "board=".$board.$search_next;
							
							if($total_data == 0){
							?>	
							<tr><td colspan="4">검색 결과가 없습니다.</td></tr>
							<? 
							} else{
								while($list = @mysql_fetch_assoc($out_sql)){
								$order_point = $list['hero_order_point']*-1;
							?>
						<tr>
							<td><?=$list['hero_regdate']?></td>
							<td class="l"><?=$list['delivery_tit']?></td>
							<td class="icon_point <? echo $list['hero_order_point'] > 0 ? "minus" : "plus"?>"><span><?=$list['hero_order_point'] > 0 ? "차감":"환급"?></span></td>
							<td class="num_pint"><span class="<? echo $list['hero_order_point'] > 0 ? "minus" : "bold main_c"?>"><? echo number_format($order_point) > 0 ? "+" : ""?> <?=number_format($order_point);?> P</span></td>
						</tr>
						<?  } //end while
							} //end if?>
						</tbody>
					</table>
					
					<div class="btngroup">
						<div class="paging">
							<? echo page($total_data,$list_page,$page_per_list,$_GET['page'],$next_path);?>
						</div>
					</div>
					<? } ?>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	$.datepicker.setDefaults();
	var startDate = $('#sdate1').val(),
		endDate = $('#edate1').val(),
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

	const url = window.location.href;
	const urlParams = new URLSearchParams(new URL(url).search);
	const todayStart = urlParams.get('hero_today_start');
	const todayEnd = urlParams.get('hero_today_end');

	let date = new Date();
	const year = date.getFullYear();
	let month = new String(date.getMonth()+1);
	let day = new String(date.getDate());
	if(month.length == 1){ month = "0" + month; }
	if(day.length == 1){  day = "0" + day; }

	if ( todayStart == null || todayEnd == null ) {
		//시작일과 종료일이 선택되기 전에는 한달전~오늘 날짜로 셋팅
		let date = new Date();
		const year = date.getFullYear();
		let month = new String(date.getMonth()+1);
		let day = new String(date.getDate());
		if(month.length == 1){ month = "0" + month; }
		if(day.length == 1){  day = "0" + day; }

		//시작일
		if (document.getElementById('sdate1').value === '' ){		
		    //시작일은 기본 1달전
		    date = new Date();
		    date.setMonth(date.getMonth() - 1);

		    let year_saerch = date.getFullYear();
		    let month_saerch = (date.getMonth() + 1).toString();
		    let day_saerch = date.getDate().toString();

		    if (month_saerch.length == 1) { month_saerch = "0" + month_saerch; }
		    if (day_saerch.length == 1) { day_saerch = "0" + day_saerch; }

		    document.getElementById('sdate1').value = year_saerch + "." + month_saerch + "." + day_saerch;
		}
		//종료일
		if (document.getElementById('edate1').value === '' ){
			document.getElementById('edate1').value = year + "." + month + "." + day;
		}
	} else {
		//검색값이 결정된 경우 
		document.getElementById('sdate1').value = todayStart;
		document.getElementById('edate1').value = todayEnd;
	}	

})

function goSearch(){
	if($('#sdate1').val() != "" || $('#edate1').val() != ""){
		if($('#sdate1').val() == "" || $('#edate1').val() == ""){
			alert("기간을 정확히 입력해주세요.");
			return;
		}
	}
	$('#sFrm').submit();
}
</script> 
