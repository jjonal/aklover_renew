<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
if(!strcmp($_SESSION['temp_level'], '')){
    $my_level = '0';
}else{
    $my_level = $_SESSION['temp_level'];
}
if(!strcmp($my_level,'0')){msg('������ �����ϴ�.','location.href="'.PATH_HOME.'?board=login"');exit;}

$board = $_GET["board"];

$gubun = $_GET["gubun"];
if(!$gubun) $gubun = "point";

######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);

/* ����¡ó���� ���� ���� **********************************************/
$list_page		=	10;					//���������� ������ �ۼ�
$page_per_list 	=	10;					//paging number
if(!$_GET['page'])		$page = '1';
else					$page = $_GET['page'];
$keyword = $_GET['kewyword'];
$select = $_GET['select'];
//�ѹ���
$start 		= ($page-1)*$list_page;
/* ************************************************************************/
?>
<script src="/js/musign/library/jquery-ui.min.js"></script>
<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
<div id="subpage" class="mypage date_ver">
	<div class="sub_title">
		<div class="sub_wrap">
			<div class="f_b">
				<h1 class="fz68 main_c fw600">����������</h1>			
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
				<div class="page_tit fz32 fw600">���� ����Ʈ</div>							
				<div class="introduceTab">
					<ul class="boardTabMenuWrap">
						<a href="/main/index.php?board=mypoint" class="<?=$gubun=="point" ? "on":"";?>">����Ʈ ����</a>
						<a href="/main/index.php?board=mypoint&gubun=delivery"  class="tab_delivery <?=$gubun=="delivery" ? "on":"";?>">��ۺ� ����</a>
						<a href="/main/index.php?board=orderlist">����Ʈ �佺Ƽ�� ��ȯ����</a>
					</ul>
				</div>
                <!--����Ʈ ���� ��ȸ-->
				<? if($gubun=="point") { //����Ʈ ���� ��ȸ ?>
					<!-- ����Ʈ �����н� Ȯ�ο� ���� ���� s -->
					<div class="member_left dis-no">
						<p class="sub_title"><span>l</span>����Ʈ ��Ȳ</p>
						<table class="member mgt10" style="width:100%;">
						<colgroup>
							<col width="150px" />
							<col width="*" />
						</colgroup>
						<tbody>
							<tr>
								<th style="font-weight: normal;">���� ����Ʈ</th>
								<td class="r"><strong><?=number_format($today_use_total)?></strong> P</td>
							</tr>
							<tr>
								<th>ȸ�����</th>
								<td class="r"><strong><?=$level_list['hero_name']?></strong> ���</td>
							</tr>
						</tbody>
						</table>
					</div>					
					<div class="member_right dis-no">
						<p class="sub_title"><span>l</span>�����н� ��Ȳ</p>
						<table class="member mgt10" style="width:100%;">
						<colgroup>
							<col width="150px" />
							<col width="*" />
						</colgroup>
						<tbody>
							<tr>
								<th style="height:75px">�����н� �߱޻���</th>
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
								<th>�����н� ��� ���� Ƚ��</th>
								<? if($today_total_list['superpass_sum']>0){?>
									<td><strong><?=$superpass_ea?>ȸ</strong> ��밡��</td>
								<? }else{?>
									<td><strong>0ȸ</strong></td>
								<? }?>
							</tr>
							-->
						</tbody>
						</table>
						<!--
						<p class="member_alert">
							<span>
								* �����н��� �� ��1ȸ �ο��Ǹ�, ������� �ʴ� �����н���
								<br/>&nbsp;&nbsp;&nbsp;�ſ� �������� �Ҹ�˴ϴ�.
							</span>
						</p>
						-->
					</div>
					<!-- ����Ʈ �����н� Ȯ�ο� ���� ���� e -->
					<!-- �˻� -->						
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
								<div class="title fz20 fw600">ȹ��/����</div>								
								<div class="date_check_list point_state direct flex">	
									<div class="input_radio"><input type="radio" name="pointType"  id="pointAll" value="All" <?if($_GET['pointType']=="" || $_GET['pointType']=="All" ) echo checked;?>/><label for="pointAll">��ü</label></div>
									<div class="input_radio"><input type="radio" name="pointType"  id="pointPlus" value="Plus" <?if($_GET['pointType']=="Plus" ) echo checked;?>/><label for="pointPlus">ȹ��</label></div>
									<div class="input_radio"><input type="radio" name="pointType"  id="pointMinus" value="Minus" <?if($_GET['pointType']=="Minus" ) echo checked;?>/><label for="pointMinus">����</label></div>
								</div>
							</div>
							<a href="javascript:goSearch();" class="mu_search_btn screen_out">�˻�</a>	
						</div>
					</form>
					<?
						// �˻����� ����
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
						
						$today = date("Y-m-d"); // ���ó�¥
						$month = date("Y-m"); // �̹���
						$today_maxpoint = 20;
						// ȹ�氡�� ����Ʈ
						$sql = "select A.hero_point as hero_today_point, B.hero_point as hero_maxpoint ,C.hero_point as hero_search_tot_point, D.hero_point as hero_month_point from
								(select sum(hero_point) as hero_point from point where hero_code='".$_SESSION['temp_code']."' and left(hero_ori_today,10)='".$today."') as A,
								(select sum(hero_point) as hero_point from point where hero_code='".$_SESSION['temp_code']."' and left(hero_ori_today,10)='".$today."' and hero_include_maxpoint='Y') as B,
								(select sum(hero_point) as hero_point from point where hero_code='".$_SESSION['temp_code']."' ".$where_search.") as C,
								(select sum(hero_point) as hero_point from point where hero_code='".$_SESSION['temp_code']."' and left(hero_today,7)='".$month."') as D";
//						echo $sql;
						$out_sql = mysql_query($sql);
						$point_sum = @mysql_fetch_assoc($out_sql);
					?>
					<!-- ���� ����Ʈ �ȳ����� -->
					<p class="fz15 today_point">�� ���� ȹ�� ���� ����Ʈ : <strong class="orange"><?=$today_maxpoint - $point_sum['hero_maxpoint']?></strong>��(���� <strong class="orange"><? echo $point_sum['hero_today_point'] != "" ?  number_format($point_sum['hero_today_point']) : "0"?></strong>�� ȹ��) / �ݿ�����Ʈ : <strong class="orange"><? echo $point_sum['hero_month_point'] != '' ? number_format($point_sum['hero_month_point']) : '0'?></strong>�� </p>
					<!-- ����Ʈ ���� ��ȸ -->
					<table border="0" cellpadding="0" cellspacing="0" class="point_table mgt10">
						<colgroup>
							<col width="25%">
							<col width="*">
							<col width="16%">
							<col width="16%">
						</colgroup>
						<thead>
							<tr class="">
								<th>�����Ͻ�</th>
								<th>����</th>
								<th>ȹ��/����</th>
								<th>��������Ʈ</th>
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
								
							// ����¡�� ���� ����Ÿ �� ����
							$sql = "select count(*) cnt from point where hero_code='".$_SESSION['temp_code']."' and hero_point != 0 ".$search;
							$out_sql = mysql_query($sql);
							//$total_data = @mysql_num_rows($out_sql);
							$total_data = @mysql_fetch_array($out_sql); 
							$total_data = $total_data[0]; 
							
							// �Խ��� ����
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
							<tr><td colspan="4">�˻� ����� �����ϴ�.</td></tr>
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
									//Ÿ��, �Խ��ǹ�ȣ, �̼ǹ�ȣ, �����ȣ, ���̵�, �Խ����̸�, ����Ʈ�̸�, ����Ʈ
									pointHistoryContent($hero_type, $hero_old_idx, $hero_mission_idx, $hero_review_idx, $hero_id, $hero_top_title, $hero_title, $hero_point, $edit_hero_code);
								?>
								</div>
							</td>
							<td class="icon_point <? echo $hero_point > 0 ? "plus" : "minus"?>"><span><? echo $hero_point > 0 ? "ȹ��" : "����"?></span></td>
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
                    /*��ۺ� ���� ��ȸ*/
                    else if($gubun=="delivery") { // ��ۺ� ���� ��ȸ ?>
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
							<a href="javascript:goSearch();" class="mu_search_btn screen_out">�˻�</a>	
						</div>						
					</form>
					<?
						// �˻����� ����
						$hero_today_start = $_GET['hero_today_start'];
						$hero_today_end = $_GET['hero_today_end'];
						
						$where_search = "";
						if($hero_today_start) $where_search .= " and date_format(`hero_today`,'%Y.%m.%d') >= '".$hero_today_start."' ";
						if($hero_today_start) $where_search .= " and date_format(`hero_today`,'%Y.%m.%d') <= '".$hero_today_end."' ";
						
						$today = date("Y-m-d"); // ���ó�¥
						$month = date("Y-m"); // �̹���
						$today_maxpoint = 20;
						
					?>
					<p class="fz15 today_point">
						�� ü��� ��û �� ��������Ʈ <?=number_format($_DELIVERY_POINT)?>����Ʈ ������ ������ ��� ü��� ��ǰ�� ����� ��۵˴ϴ�.<br/>
						�� ü��ܿ� �������� �ʾ��� ��� ������ ����Ʈ�� ȯ�޵˴ϴ�.
					</p>
					<!-- ��ۺ� ��ȸ ���̺� -->
					<table border="0" cellpadding="0" cellspacing="0" class="point_table">
						<colgroup>
							<col width="25%">
							<col width="*">
							<col width="16%">
							<col width="16%">
						</colgroup>
						<thead>
						<tr>
							<th>�����Ͻ�</th>
							<th>����</th>
							<th>����/ȯ��</th>
							<th>����Ʈ</th>
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
								
							// ����¡�� ���� ����Ÿ �� ����
							$sql = "select count(*) cnt from order_main where hero_code='".$_SESSION['temp_code']."' and hero_process = 'DE' ".$search;
                            
							$out_sql = mysql_query($sql);
							//$total_data = @mysql_num_rows($out_sql);
							$total_data = @mysql_fetch_array($out_sql); 
							$total_data = $total_data[0]; 
							
							// �Խ��� ����
							$sql = " select hero_order_point, hero_regdate, (select hero_title from mission where hero_idx = o.mission_idx) delivery_tit ";
							$sql .=" from order_main o ";
							$sql .=" where hero_code='".$_SESSION['temp_code']."' and hero_process = 'DE' ".$search." ";
							$sql .=" order by hero_idx desc ";
							$sql .=" limit ".$start.",".$list_page."";

							$out_sql = mysql_query($sql);

							$next_path 	= "board=".$board.$search_next;
							
							if($total_data == 0){
							?>	
							<tr><td colspan="4">�˻� ����� �����ϴ�.</td></tr>
							<? 
							} else{
								while($list = @mysql_fetch_assoc($out_sql)){
								$order_point = $list['hero_order_point']*-1;
							?>
						<tr>
							<td><?=$list['hero_regdate']?></td>
							<td class="l"><?=$list['delivery_tit']?></td>
							<td class="icon_point <? echo $list['hero_order_point'] > 0 ? "minus" : "plus"?>"><span><?=$list['hero_order_point'] > 0 ? "����":"ȯ��"?></span></td>
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
			dayNamesMin: ['��','��','ȭ','��','��','��','��'],
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
		//�����ϰ� �������� ���õǱ� ������ �Ѵ���~���� ��¥�� ����
		let date = new Date();
		const year = date.getFullYear();
		let month = new String(date.getMonth()+1);
		let day = new String(date.getDate());
		if(month.length == 1){ month = "0" + month; }
		if(day.length == 1){  day = "0" + day; }

		//������
		if (document.getElementById('sdate1').value === '' ){		
		    //�������� �⺻ 1����
		    date = new Date();
		    date.setMonth(date.getMonth() - 1);

		    let year_saerch = date.getFullYear();
		    let month_saerch = (date.getMonth() + 1).toString();
		    let day_saerch = date.getDate().toString();

		    if (month_saerch.length == 1) { month_saerch = "0" + month_saerch; }
		    if (day_saerch.length == 1) { day_saerch = "0" + day_saerch; }

		    document.getElementById('sdate1').value = year_saerch + "." + month_saerch + "." + day_saerch;
		}
		//������
		if (document.getElementById('edate1').value === '' ){
			document.getElementById('edate1').value = year + "." + month + "." + day;
		}
	} else {
		//�˻����� ������ ��� 
		document.getElementById('sdate1').value = todayStart;
		document.getElementById('edate1').value = todayEnd;
	}	

})

function goSearch(){
	if($('#sdate1').val() != "" || $('#edate1').val() != ""){
		if($('#sdate1').val() == "" || $('#edate1').val() == ""){
			alert("�Ⱓ�� ��Ȯ�� �Է����ּ���.");
			return;
		}
	}
	$('#sFrm').submit();
}
</script> 
