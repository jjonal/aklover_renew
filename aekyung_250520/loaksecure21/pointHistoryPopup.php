<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD����
######################################################################################################################################################
include_once                                '../freebest/head.php';
if(!$_SESSION['temp_id']){echo '<script>location.href="'.PATH_END.'out.php"</script>';exit;}
include                                     FREEBEST_INC_END.'hero.php';
include                                     FREEBEST_INC_END.'function.php';
include 									  PATH_INC_END.'page02.php';
include_once '../combined/admin_user_manager.php';

if(!$_GET['page'])		$page = '1';
else						$page = $_GET['page'];
?>
<meta charset="euc-kr" />
<head>
<link rel="stylesheet" type="text/css" href="<?=CSS_END;?>general.css"/>
<link rel="stylesheet" type="text/css" href="<?=PATH_END?>css/admin_login.css" />
<link rel="stylesheet" href="<?=PATH_END?>css/admin.css" type="text/css" />
<script type="text/javascript" src="<?=JS_END;?>jquery.min.js"></script>
<script type="text/javascript" src="<?=JS_END;?>head.js"></script>
<link type='text/css' href='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.css' rel='stylesheet' />
<script type="text/javascript" src="<?=DOMAIN_END?>cal/jquery.min.js"></script>
<script type='text/javascript' src='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.min.js'></script> 

</head>
<body>
<div id="searchPointArea" style="padding:0">
<form action="" name="frm"  id="frm">
	<input type="hidden" name="board"  value="<?=$_GET['board']?>"/>
	<input type="hidden" name="hero_id"  value="<?=$_GET['hero_id']?>"/>
	
	<table>
			<tr>
				<th>�Ⱓ</th>
				<td style="width:320px;">
                		<input type="text"  id="sdate1" name="hero_today_start"  value="<?=$_GET['hero_today_start']?>" style="text-align: center"  readonly/> ~ 
                		<input type="text"  id="edate1" name="hero_today_end"  value="<?=$_GET['hero_today_end']?>" style="text-align: center"  readonly/>
                </td>
					<script>
						$(function() {      // window.onload ��� ���� ��ũ��Ʈ
						    dateclick2();
						});
						function dateclick2(){
						    var dates = $("#sdate1, #edate1").datepicker({
						        monthNames: ['�� 1��','�� 2��','�� 3��','�� 4��','�� 5��','�� 6��','�� 7��','�� 8��','�� 9��','�� 10��','�� 11��','�� 12��'],
						        dayNamesMin: ['��', '��', 'ȭ', '��', '��', '��', '��'],
						        defaultDate: null,
						        showMonthAfterYear:true,
						        dateFormat: 'yy-mm-dd',
						        onSelect: function( selectedDate ) {
						            var option = this.id == "sdate1" ? "minDate" : "maxDate",
						            instance = $( this ).data( "datepicker" ),
						            date = $.datepicker.parseDate(
						                instance.settings.dateFormat ||
							            $.datepicker._defaults.dateFormat,
							            selectedDate, instance.settings );
							        dates.not( this ).datepicker( "option", option, date );
								}
							});
						};
					</script>
					<th>ȹ��/����</th>
					<td>
						<input type="radio"  style="width:30px;" name="pointType"  id="pointAll" value="All" <?if($_GET['pointType']=="" || $_GET['pointType']=="All" ) echo checked;?>/><label for="pointAll">��ü</label> 
                        <input type="radio"  style="width:30px;" name="pointType"  id="pointPlus" value="Plus" <?if($_GET['pointType']=="Plus" ) echo checked;?>/><label for="pointPlus">ȹ��</label> 
                        <input type="radio"  style="width:30px;" name="pointType"  id="pointMinus" value="Minus" <?if($_GET['pointType']=="Minus" ) echo checked;?>/><label for="pointMinus">����</label>
					</td>
					<td><div onClick="$('#frm').submit()" style="cursor:pointer;height: 25px;padding: 10px 7px 2px 7px;background: #376EA6;color:white;text-align:center;font-size:13px;">�� ��</div></td>
			</tr>
	</table>
</form>
</div>

<div id="resultPointArea">
 <?
 
 	// �˻����� ����
	$hero_today_start = $_GET['hero_today_start'];
	$hero_today_end = $_GET['hero_today_end'];
	$pointType = $_GET['pointType'];
	
	$where_search = "";
	if($hero_today_start) $where_search .= " and date_format(`hero_today`,'%Y-%m-%d') >= '".$hero_today_start."' ";
	if($hero_today_start) $where_search .= " and date_format(`hero_today`,'%Y-%m-%d') <= '".$hero_today_end."' ";
	
	$today = date("Y-m-d"); // ���ó�¥
	$month = date("Y-m"); // �̹���
    $today_maxpoint = 20;
   	// ȹ�氡�� ����Ʈ
    $sql = "select A.hero_point as hero_today_point, B.hero_point as hero_maxpoint, C.hero_point as hero_total_point, D.hero_point as hero_search_tot_point, E.hero_point as hero_month_point from
			(select sum(hero_point) as hero_point from point where hero_id='".$_GET['hero_id']."' and left(hero_ori_today,10)='".$today."') as A,
			(select sum(hero_point) as hero_point from point where hero_id='".$_GET['hero_id']."' and left(hero_ori_today,10)='".$today."' and hero_include_maxpoint='Y') as B,
			(select sum(hero_point) as hero_point from point where hero_id='".$_GET['hero_id']."') as C,
			(select sum(hero_point) as hero_point from point where hero_id='".$_GET['hero_id']."' ".$where_search.") as D,
			(select sum(hero_point) as hero_point from point where hero_id='".$_GET['hero_id']."' and left(hero_today,7)='".$month."') as E";
			
    //echo $sql;
    $out_sql = sql($sql, 'on');
    $point_sum = @mysql_fetch_assoc($out_sql);
 ?>
    <p class="mgt20">-�� ȹ�� ����Ʈ : <strong class="orange"><?=$point_sum['hero_total_point']?></strong>��</p>
    <p>-���� ȹ�� ����Ʈ : <strong class="orange"><? echo $point_sum['hero_today_point'] != "" ?  $point_sum['hero_today_point'] : "0"?></strong>��</p>
    <p>-���� ȹ�� ���� ����Ʈ : <strong class="orange"><?= $today_maxpoint - $point_sum['hero_maxpoint']?></strong>��</p>
    <p>-�Ⱓ �� �� ����Ʈ : <strong class="orange"><?=$point_sum['hero_search_tot_point'];?></strong>��</p>
    <p>-�ݿ� ȹ�� ����Ʈ : <strong class="orange"><? echo $point_sum['hero_month_point'] != "" ? $point_sum['hero_month_point'] : "0"?></strong>��</p>
	<table>
		<colgroup>
			<col width="200px" />
			<col width="100px" />
			<col width="100px" />
			<col width="*" />
			<col width="100px" />
		</colgroup>

		<tr>
			<th>������</th>
			<th>����Ʈ ���� ����</th>
			<th>ȹ��/����</th>
			<th>����</th>
			<th>����Ʈ</th>
		</tr>
		<?
		
		$search = "and hero_id='".$_GET['hero_id']."' ";
		$search_next = "&hero_id=".$_GET['hero_id'];
		
		if($hero_today_start && $hero_today_end){
			$search .= "and date_format(`hero_today`,'%Y-%m-%d') between '".$hero_today_start."' and '".$hero_today_end."' ";
			$search_next .= "&hero_today_start=".$hero_today_start."&hero_today_end=".$hero_today_end;
		}
		if($pointType){
			$search_next .= "&pointType=".$pointType;
                		
            if($pointType == 'Plus') $search .="and hero_point > 0 ";
            else if($pointType == 'Minus') $search .="and hero_point < 0 ";
		}
			
		// ����¡�� ���� ����Ÿ �� ����
		$sql = "select hero_code from point where 1=1 ".$search;
		//echo $sql;
		$out_sql = mysql_query($sql);
		$total_data = @mysql_num_rows($out_sql);
	
		//echo $total_data;
		new_sql($sql,$error,"on");
		if($_GET['page']!=''){
			$NO = $total_data-(($_GET['page']-1)*$list_page);
			$page = $_GET['page'];
		
		}else{
			$page = '1';
			$NO = $total_data;
		}
		
		$start = ($page-1)*$list_page;
		
		$next_path="board=".$_GET['board']."&idx=".$_GET['idx']; 
		
		// �Խ��� ����
		$sql = "select hero_type, hero_mission_idx, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today, hero_include_maxpoint, edit_hero_code ";
		$sql .="from point ";
		$sql .="where 1=1 ".$search." ";
		$sql .="order by hero_idx desc ";
		$sql .="limit ".$start.",".$list_page."";
		//echo $sql;
		$out_sql = mysql_query($sql);
		
		if($total_data == 0){
		?>
			<tr><td colspan="5">�˻� ����� �����ϴ�.</td></tr>
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
			<td><?= $list['hero_today']?></td>
			<td><? echo  $list['hero_include_maxpoint'] == "Y" ? "����" : "���Ѿ���"?></td>
			<td>
				<? if($list['hero_point'] != 0) echo $list['hero_point'] > 0 ? "ȹ��" : "����";
					else echo "-"?>
			</td>
			<td style="text-align:left;">
				<?
					//Ÿ��, �Խ��ǹ�ȣ, �̼ǹ�ȣ, �����ȣ, ���̵�, �Խ����̸�, ����Ʈ�̸�, ����Ʈ
              		pointHistoryContent($hero_type, $hero_old_idx, $hero_mission_idx, $hero_review_idx, $hero_id, $hero_top_title, $hero_title, $hero_point, $edit_hero_code);	
                 ?>
			</td>
			<td><?=$list['hero_point']?>��</td>
		</tr>
		<? } //end while
		} // end if?>
	</table>
</div>
  		                    
    	<div class="paginate" style="text-align: center;">
			<? echo page2($total_data,$list_page,$page_per_list,$page,$next_path);?>
       </div>
       <script>
	   function ch_page(page){
	   		location.href="<?=ADMIN_DEFAULT?><?='/pointHistoryPopup.php?page='?>"+page+"<?=$search_next?>";
	   	}
       </script>     
        
</body>

    
    

    
    
