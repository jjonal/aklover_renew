<?php

######################################################################################################################################################
include_once "head.php";
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
//�α��� �̿밡��
if (!$_SESSION ['temp_level']){
	error_location("������ �����ϴ�.","/m/main.php?board=login");
	exit;
}


// #####################################################################################################################################################
//�̺κ� ���� ��Ȯ�� �ʿ� 160615
$error = "MYPOINT_01";
$group_sql = "select * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$_GET['board']."'"; // desc
//echo $group_sql;
//exit;
$out_group = new_sql( $group_sql,$error );
if((string)$out_group==$error){
	error_historyBack("");
	exit;
}
$right_list = mysql_fetch_assoc ( $out_group );

if($right_list["hero_view"]>$_SESSION['temp_level'] && $right_list["hero_view"]!=0){
	error_historyBack("������ ������ �����ϴ�.");
	exit;
}

$gubun = $_GET["gubun"];
if(!$gubun) $gubun = "point";

// #####################################################################################################################################################
$user_total_sql = "select total_user_point, total_use_point, C.superpass_use, D.superpass_sum from ";
$user_total_sql .= "(select hero_code, sum(hero_point) as total_user_point from point where hero_code='".$_SESSION['temp_code']."') as A, ";
$user_total_sql .= "(select SUM(hero_order_point) as total_use_point from order_main where hero_code='".$_SESSION['temp_code']."' and hero_process!='".$_PROCESS_CANCEL."') as B, ";
$user_total_sql .= "(select count(*) as superpass_use from mission_review where hero_superpass='Y' and hero_code='".$_SESSION['temp_code']."' and hero_today <= '".date("Y-m-t")."' and hero_today >= '".date("Y-m-01")."') as C, ";
$user_total_sql .= "(select count(*) as superpass_sum from superpass where hero_code='".$_SESSION['temp_code']."' and hero_use_yn = 'N' and hero_endday > date_format(now(),'%Y-%m-%d 00:00:00')) as D"; //12��7�� ����
//echo $user_total_sql;

$out_user_total_sql = @mysql_query($user_total_sql);
$today_total_list = @mysql_fetch_assoc($out_user_total_sql);
$today_total = $today_total_list['total_user_point'];
if($today_total=='') $today_total = 0;
$today_use_total = $today_total_list['total_user_point']-$today_total_list['total_use_point'];//

$member_sql = 'select * from member where hero_code=\''.$_SESSION['temp_code'].'\';';
$out_member_sql = mysql_query($member_sql);
$member_list = @mysql_fetch_assoc($out_member_sql);

$level_sql = 'select * from level where hero_level=\''.$member_list['hero_level'].'\';';
$out_level_sql = mysql_query($level_sql);
$level_list                             = @mysql_fetch_assoc($out_level_sql);

$superpass_ea = $today_total_list['superpass_sum'];

/* ����¡ó���� ���� ���� **********************************************/
$list_page		=	5;					//���������� ������ �ۼ�
$page_per_list 	=	5;					//paging number
if(!$_GET['page'])		$page = '1';
else						$page = $_GET['page'];
$keyword = $_GET['kewyword'];
$select = $_GET['select'];
//�ѹ���
$start 		= ($page-1)*$list_page;

$next_path = get ( "page||hero_i_count" );
/* ************************************************************************/

?>

<script src="/js/musign/library/jquery-ui.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
	//����� �޷� �¿��� 
	$('.mo_cal').click(function(e){
	e.preventDefault(e);
		$('.datebox').show();
	});
	$('.mo_call_x').click(function(e){
		e.preventDefault();
		$('.datebox').hide();
	});	
	$('.mo_cal').click(function(){
        $('.dim').show();
    });
    // �޷� �ݱ�� �� ��Ȱ��ȭ, �޷¼���â ��Ȱ��ȭ
    $('.mo_call_x').click(function(){
        $('.dim').hide(); 
        $('.datebox').hide();
    });
    // ��Ŭ���� ��� ��Ȱ��ȭ
    $('.dim').click(function(){
        $(this).hide();
        $('.datebox').hide(); 
    });

	dateclick2();

	// $('.point_state .input_wrap').click(function(){
	// 	$('.point_state .input_wrap').removeClass('on');
	// 	$(this).addClass('on');
	// });
	
});
function dateclick2(){
    var startDate = $('#sdate1').val(),
		endDate = $('#edate1').val(),
		today = new Date(),
		startday,
		datepicker_options = {
        dateFormat: 'yy-mm-dd', 
		dayNamesMin: ['��','��','ȭ','��','��','��','��'],    
		defaultDate: null,
		showButtonPanel: true,
        showMonthAfterYear:true,
        dateFormat: 'yy-mm-dd',
        onSelect: function( selectedDate ) {
            var option = this.id == "sdate1" ? "minDate" : "maxDate",
            instance =  $( this ).data( "datepicker" ),
            date =  $.datepicker.parseDate(
                instance.settings.dateFormat ||
				$.datepicker._defaults.dateFormat,
	            selectedDate, instance.settings );
		}
	};

	$('.call-datepicker').datepicker();
	$('.call-datepicker').datepicker('option', datepicker_options);

	const date = new Date();
	const year = date.getFullYear();
	const lastyear = new String(date.getFullYear()-1);
	let month = new String(date.getMonth()+1);
	let day = new String(date.getDate());
	if(month.length == 1){ month = "0" + month; }
	if(day.length == 1){  day = "0" + day; }

    if (document.getElementById('sdate1').value === '' ){
		document.getElementById('sdate1').value = lastyear + "." + month + "." + day;
	}
	if (document.getElementById('edate1').value === '' ){
		document.getElementById('edate1').value = year + "-" + month + "." + day;
	}

};
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
<link href="css/musign/cscenter.css" rel="stylesheet" type="text/css">
<link href="css/musign/board.css" rel="stylesheet" type="text/css">
<!--������ ����-->
	<div id="subpage" class="mypage mypoint">	
		<div class="my_top off">    
			<div class="sub_title">       
				<div class="sub_wrap">  
					<div class="btn_back f_cs" onclick="goBack()"><img src="/m/img/musign/main/hd_back.webp" alt="�ڷ� ����"></div>   
					<h1 class="fz36">���� ����Ʈ</h1>       
				</div>
			</div>  
			<? include_once "mypage_top.php";?> 
		</div>    		
		<div class="boardTabMenuWrap">
			<a href="/m/mypoint.php?board=mypoint" <?=$gubun=="point" ? "class='on'":"";?>>����Ʈ ����</a>
			<a href="/m/mypoint.php?gubun=delivery" <?=$gubun=="delivery" ? "class='on'":"";?>>��ۺ� ����</a>
			<a href="/m/orderList.php?board=orderlist">����Ʈ �佺Ƽ�� ��ȯ����</a>
		</div>
	</div>
    <div class="date_ver">
    	<? if($gubun == "point") { // ����Ʈ ���� ?>
    	<div class="pointWrap dis-no">
        	<p class="subTit"><span>|</span>&nbsp;����Ʈ ��Ȳ</p>
            <table class="tb">
            	<colgroup>
                	<col width="55%" />
                    <col width="45%" />
                </colgroup>
            	<tr>
                	<th>��������Ʈ</th>
                    <td class="r"><?=number_format($today_use_total)?> P</td>
                </tr>
                <tr>
                	<th>ȸ�����</th>
                    <td class="r"><?=$level_list['hero_name']?> ���</td>
                </tr>
            </table>
        </div>
        <div class="superpassWrap dis-no">
        	<p class="subTit"><span>|</span>&nbsp;�����н� ��Ȳ</p>
            <table class="tb">
            	<colgroup>
                	<col width="55%" />
                    <col width="45%" />
                </colgroup>
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
                <tr height="57">
                	<th>�����н�<br/> ��� ���� Ƚ��</th>
                    	<? if($today_total_list['superpass_sum']>0){?>
                    		<td><strong><?=$superpass_ea?>ȸ</strong> ��밡��</td>
                    	<? }else{?>
                    		<td><strong>0ȸ</strong></td>
                    	<? }?>
                </tr>
                -->
            </table>
            <!--p class="ex">* �����н��� �� ��1ȸ �ο��Ǹ�, ������� �ʴ� �����н��� �ſ� �������� �Ҹ�˴ϴ�.</p-->
        </div>       
		<form name="sFrm" id="sFrm" action="">
			<input type="hidden" name="board"  value="<?=$_GET['board']?>"/>
			<div class="f_cs mu_searchbox point_search black_btn">
				<div class="datebox pc">
					<div class="title fz32 bold t_c rel mo">�Ⱓ��ȸ <input type="image" src="/m/img/musign/board/search_x.webp" alt="�ݱ�" class="mo_call_x"></div>	
					<div class="title fz20 fw600">DATE</div>								
					<div class="date_check_list direct">	
						<input type="text"  id="sdate1" name="hero_today_start"  value="<?=$_GET['hero_today_start']?>" class="input-date date-from call-datepicker search_input" readonly/>
						<input type="text"  id="edate1" name="hero_today_end"  value="<?=$_GET['hero_today_end']?>"  class="input-date date-to call-datepicker search_input" readonly/>
					</div>
					<div class="mo_search_btn t_c mo mo_call_x">�����ϱ�</div>			
				</div>
				<div class="search_cont rel">				
					<div class="date_check_list point_state flex">	
						<div class="input_wrap"><div class="input_radio"><input type="radio" name="pointType"  id="pointAll" value="All" <?if($_GET['pointType']=="" || $_GET['pointType']=="All" ) echo checked;?>/><label for="pointAll">��ü</label></div></div>
						<div class="input_wrap"><div class="input_radio"><input type="radio" name="pointType"  id="pointPlus" value="Plus" <?if($_GET['pointType']=="Plus" ) echo checked;?>/><label for="pointPlus">ȹ��</label></div></div>
						<div class="input_wrap"><div class="input_radio"><input type="radio" name="pointType"  id="pointMinus" value="Minus"  <?if($_GET['pointType']=="Minus" ) echo checked;?>/><label for="pointMinus">����</label></div></div>
						<a href="javascript:goSearch();" class="mu_point_btn screen_out">�˻�</a>	
					</div>
					<div class="mo mo_cal screen_out">����ϳ�¥���þ�����</div>	
				</div>				
			</div>
		</form>
	
			<?
				// �˻����� ����
				$pointType = $_GET['pointType'];
				$hero_today_start = $_GET['hero_today_start'];
				$hero_today_end = $_GET['hero_today_end'];
				$where_search = "";
				if($hero_today_start) $where_search .= " and date_format(`hero_today`,'%Y-%m-%d') >= '".$hero_today_start."' ";
				if($hero_today_start) $where_search .= " and date_format(`hero_today`,'%Y-%m-%d') <= '".$hero_today_end."' ";
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
             	//echo $sql;
             	$out_sql = mysql_query($sql);
             	$point_sum = @mysql_fetch_assoc($out_sql);
				//echo $sql;
             ?>
             <p class="point_txt dis-no">
             	���� ȹ�� ���� ����Ʈ : <strong><?=$today_maxpoint - $point_sum['hero_maxpoint']?></strong>��(���� <strong class="orange"><? echo $point_sum['hero_today_point'] != "" ?  $point_sum['hero_today_point'] : "0"?></strong>�� ȹ��)  
             	<br/>�ݿ�����Ʈ : <strong><? echo $point_sum['hero_month_point'] != '' ? number_format($point_sum['hero_month_point']) : '0'?></strong>��
             </p>
             
			 <div class="point_table">
			 <?
				$search = "";
				$search_next = "";
				
				if($pointType){
					$search_next .= "&pointType=".$pointType;
					
					if($pointType == 'Plus') $search .="and hero_point > 0 ";
					else if($pointType == 'Minus') $search .="and hero_point < 0 ";
				}
				
				if($hero_today_start && $hero_today_end){
					$search .= "and date_format(`hero_today`,'%Y-%m-%d') between '".$hero_today_start."' and '".$hero_today_end."'";
					$search_next .= "&hero_today_start=".$hero_today_start."&hero_today_end=".$hero_today_end;
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
				//echo $sql;
				$out_sql = mysql_query($sql);

				//$next_path 	= "board=".$board.$search_next;
				if($total_data == 0){
				?>	
				<p>�˻� ����� �����ϴ�.</p>
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
						
						if( $hero_type == "deliveryPoint" ) {
							if( $hero_title == "����" ) {
								$hero_point = -$_DELIVERY_POINT;
							}else {
								$hero_point = $_DELIVERY_POINT;
							}
						}
				?>
				<div class="point_table_li">
					<div class="tit fz28 fw600 ellipsis_100">  
					<?
						//Ÿ��, �Խ��ǹ�ȣ, �̼ǹ�ȣ, �����ȣ, ���̵�, �Խ����̸�, ����Ʈ�̸�, ����Ʈ
						pointHistoryContent($hero_type, $hero_old_idx, $hero_mission_idx, $hero_review_idx, $hero_id, $hero_top_title, $hero_title, $hero_point, $edit_hero_code);
					?>
					</div>
					<div class="box_point f_b">
						<p class="icon_point <? echo $hero_point > 0 ? "plus" : "minus"?>">
							<? echo $hero_point > 0 ? "ȹ��" : "����"?>
						</p>
						<span class="<? echo $hero_point > 0 ? "plus" : "minus"?>"><? echo $hero_point > 0 ? "+" : ""?><?=number_format($hero_point)?> P</span>
					</div>
					<div class="date fz24 op05"><?=$list['hero_today']?></div>
				</div>
			<?  } //end while?>
			 </div>
             <!-- ����Ʈ ���� 5�� -->	
			<? } //end if?>
			 <div id="page_number" class="paging">
             <?include_once "page.php"?>
             </div>
		<? } else if($gubun=="delivery") { //��ۺ� ���� ��ȸ?>
             
			<div class="sub_wrap">  
      		<form name="sFrm" id="sFrm" action="">
			<input type="hidden" name="board"  value="<?=$_GET['board']?>"/>
			<input type="hidden" name="gubun"  value="<?=$gubun?>"/>							
				<div class="mu_searchbox point_search black_btn">					
					<div class="date_check_list direct" style="margin-top: 0;">							
						<input type="text"  id="sdate1" name="hero_today_start"  value="<?=$_GET['hero_today_start']?>" class="input-date date-from call-datepicker search_input"  readonly/> -
						<input type="text"  id="edate1" name="hero_today_end"  value="<?=$_GET['hero_today_end']?>" class="input-date date-to call-datepicker search_input" readonly/>
						<a href="javascript:;" onClick='goSearch();' class="mu_point_btn screen_out">�˻�</a>		
					</div>
					<p class="fz26" style="line-height: 1.3; margin-top: 15px">
						�� ü��� ��û �� ��������Ʈ <?=number_format($_DELIVERY_POINT)?>����Ʈ ������<br /> ������ ��� ü��� ��ǰ�� ����� ��۵˴ϴ�.<br/>
						�� ü��ܿ� �������� �ʾ��� ��� ������ ����Ʈ�� ȯ�޵˴ϴ�.
					</p>	
				</div>	
             </form>
			</div>
              <?
			 	// �˻����� ����
				$hero_today_start = $_GET['hero_today_start'];
				$hero_today_end = $_GET['hero_today_end'];
				
				$where_search = "";
				if($hero_today_start) $where_search .= " and date_format(`hero_today`,'%Y-%m-%d') >= '".$hero_today_start."' ";
				if($hero_today_start) $where_search .= " and date_format(`hero_today`,'%Y-%m-%d') <= '".$hero_today_end."' ";
				
             	$today = date("Y-m-d"); // ���ó�¥
				$month = date("Y-m"); // �̹���
             	$today_maxpoint = 20;
             	
             ?>
            
			<div class="point_table">
                <?                	
                	$search = "";
                	$search_next = "&gubun=delivery";
                	
                	if($hero_today_start && $hero_today_end){
                		$search .= "and date_format(`hero_regdate`,'%Y-%m-%d') between '".$hero_today_start."' and '".$hero_today_end."'";
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
					<div class="non_search fz28 fw600">�˻� ����� �����ϴ�.</div>
                	<? 
                	} else{
	                	while($list = @mysql_fetch_assoc($out_sql)){
	                		$order_point = $list['hero_order_point']*-1;
	                ?>
					<div class="point_table_li">
						<div class="tit fz28 fw600 ellipsis_100"><?=$list['delivery_tit']?></div>
						<div class="box_point f_b">
							<p class="icon_point <? echo $list['hero_order_point'] > 0 ? "minus" : "plus"?>">
								<?=$list['hero_order_point'] > 0 ? "����":"ȯ��"?>
							</p>
							<span class="<? echo $list['hero_order_point'] > 0 ? "minus" : "plus"?>"><? echo $list['hero_order_point'] > 0 ? "" : "+"?><?=number_format($order_point);?> P</span>
						</div>
						<div class="date fz24 op05"><?=$list['hero_regdate']?></div>
					</div>
                <?  } //end while ?>
				</div>            
                <?	} //end if?>
				<div id="page_number" class="paging">
				<?include_once "page.php"?>
				</div>
             </div>
		<? } ?>
             
             
    </div>
	
		
<?include_once "tail.php";?>