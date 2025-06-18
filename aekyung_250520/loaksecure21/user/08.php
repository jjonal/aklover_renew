<?php 
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;

?>
<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/jquery-ui-datepicker-1.10.4.custom.min.css">
 <link rel="stylesheet" type="text/css" href="<?=ADMIN_DEFAULT?>/css/jquery.mtz.monthpicker.css"/>
 <script src="<?=ADMIN_DEFAULT?>/js/jquery-ui-datepicker-1.10.4.custom.min.js"></script>
 <script type="text/javascript" src="<?=ADMIN_DEFAULT?>/js/jquery.mtz.monthpicker.js"></script>

 <script>
	$(document).ready(function(){
		var options = {
			monthNames: ['1��', '2��', '3��', '4��', '5��', '6��', '7��', '8��', '9��', '10��', '11��', '12��']
		};
 		$('#default_widget').monthpicker(options);
		$( "#datepicker" ).datepicker({
			dayNamesMin:[ "��", "��", "ȭ", "��", "��", "��", "��" ],
			monthNames:["1��", "2��", "3��", "4��", "5��", "6��", "7��", "8��", "9��", "10��", "11��", "12��"] 
		});

	});
	
	function outfocus(data){
		if(data=='month'){
			$('#datepicker').val('');
		}else if(data=='date'){
			$('#default_widget').val('');
		}
	}

	function reset(){

		document.getElementsByName("select")[0].selectedIndex = 0
		
		var kewyword = document.getElementsByName('kewyword')[0];
		kewyword.value = '';
		
		var month = document.getElementsByName('month')[0];
		month.value = '';

		var date = document.getElementsByName('date')[0];
		date.value = '';

		document.getElementById('month_date_click').click();
		
	}

	function ch_submit(form_name){
		var kewyword = form_name.kewyword;
		var select = form_name.select;
		
		if(kewyword.value!='' && select.value==''){
			alert('�˻������� �������ּ���');	
			select.focus();
			return false;
		}else{
			return true;
		}

	}
 </script>
<style>
.t_list{white-space:nowrap;}
.t_list td,tr,th{white-space:nowrap;}
</style>


	<div class="searchbox" style="margin: 2% 50%;background: #f2f2f2;width: 850px;height: 50px;border: 1px solid #D7D7D7;border-radius: 10px;left: -425px;">
						<div class="wrap_1" style="padding: 17px 0 0 43px;">
							<form action="<?=$_SERVER['PHP_SELF']."?board=".$_GET['board']."&idx=".$_GET['idx']."&search_area=".$_REQUEST['search_area']?>" method="POST" onsubmit="return ch_submit(this);">
								<span style="font-size:12px;font-weight:800">Search</span>&nbsp;&nbsp;&nbsp;
								<select name="search_area" style="width:120px;border: 2px solid #376EA6;">
									<option value="newcomer"<?if(!strcmp($_REQUEST['search_area'], 'newcomer')){echo ' selected';}else{echo '';}?>>�ű� ȸ�� ���</option>
									<option value="point"<?if(!strcmp($_REQUEST['search_area'], 'point')){echo ' selected';}else{echo '';}?>>����Ʈ ���</option>
									<option value="lover_star"<?if(!strcmp($_REQUEST['search_area'], 'lover_star')){echo ' selected';}else{echo '';}?>>����ı� ���</option>
									<option value="recommand"<?if(!strcmp($_REQUEST['search_area'], 'recommand')){echo ' selected';}else{echo '';}?>>�Խñ� ��õ ���</option>
									<option value="report"<?if(!strcmp($_REQUEST['search_area'], 'report')){echo ' selected';}else{echo '';}?>>�Խñ� �Ű� ���</option>
								</select>
								<select name="select" style="width:90px;">
									<option value="" <?if(!strcmp($_REQUEST['select'], '')){echo ' selected';}else{echo '';}?>>�˻� ����</option>
									<option value="hero_id"<?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>���̵�</option>
									<option value="hero_nick"<?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>�г���</option>
									<option value="hero_name"<?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>����</option>
								  	<option value="hero_all"<?if(!strcmp($_REQUEST['select'], 'hero_all')){echo ' selected';}else{echo '';}?>>���̵�+�г���+����</option>
								</select>
								<input name="kewyword" type="text" value="<?= $_REQUEST['kewyword'];?>" class="kewyword" id="kewyword" style='width: 110px;'>
								<span style="color: #999999;font-size: 9pt;font-weight: 800;margin-left: 10px;">����</span>
								<input type="text" id="default_widget" name='month' class="mtz-monthpicker-widgetcontainer" style="width:100px;" 
									value='<?if($_REQUEST['month']){echo $_REQUEST['month'];}?>' onchange="outfocus('month');">
								<span style="color: #999999;font-size: 9pt;font-weight: 800;margin-left: 10px;">�Ϻ�</span>
								<input type="text" id="datepicker"  name='date'  style="width:80px;" value='<?if($_REQUEST['date']){echo $_REQUEST['date'];}else{echo '';}?>' onchange="outfocus('date');">
								<input type="image" src="../image/bbs/btn_search.gif" alt="�˻�" class="bd0" id="month_date_click">
								<span style='background: #376EA6;padding: 4px 7px;color: #FFFFFF;font-weight: 800;border-radius: 9px;cursor:pointer;' onclick='reset();'>Reset</span>
							</form>
						</div>
					</div>
<?

##################################################################################################################################################################################
#########    �ű� ȸ�� �˻���     ###############################################################################################################################
##################################################################################################################################################################################

//�ű�ȸ�� �˻�
if($_REQUEST['search_area']=='newcomer' || $_REQUEST['search_area']==''){
	
	
	if($_REQUEST['kewyword']!= ''){
		if($_REQUEST['select']=='hero_all'){
			$search = ' and ( hero_nick like \'%'.$_REQUEST['kewyword'].'%\' or hero_name like \'%'.$_REQUEST['kewyword'].'%\' or hero_id like \'%'.$_REQUEST['kewyword'].'%\' )';
			$search_next = '&select='.$_POST['select'].'&kewyword='.$_REQUEST['kewyword'];
		}else{
			$search = ' and '.$_REQUEST['select'].' like \'%'.$_REQUEST['kewyword'].'%\'';
			$search_next = '&select='.$_REQUEST['select'].'&kewyword='.$_REQUEST['kewyword'];
		}
	}
	

	if($_POST['month']){
		$month = explode('/',$_POST['month']);
		$new_today_check = " and DATE_FORMAT( hero_oldday,  '%Y-%m' ) ='".$month[1]."-".$month[0]."'";
	}
	if($_POST['date']){
		$date = explode('/',$_POST['date']);
		$new_today_check=" and DATE_FORMAT( hero_oldday,  '%Y-%m-%d' ) ='".$date[2]."-".$date[0]."-".$date[1]."'";
	}
	
	
	$sql = "select count(*) from member where 1=1 ".$new_today_check." ".$search."";
	
	sql($sql);
	//echo $sql;
	$out_sql = @mysql_fetch_assoc($out_sql);
	$total_data = $out_sql['count(*)'];
	$list_page=50;
	$page_per_list=10;
	
	if(!strcmp($_GET['page'], '')){
		$page = '1';
	}else{
		$page = $_GET['page'];
	}
	
	$start = ($page-1)*$list_page;
	
	if($_GET['page']){
		$j=$total_data-(($_GET['page']-1)*$list_page);
	}else{
		$j=$total_data;
	}
	
	
	$next_path="board=".$_GET['board'].'&idx='.$_GET['idx'].'&search_area='.$_REQUEST['search_area'].$search_next.'&month='.$_REQUEST['month'].'&date='.$_REQUEST['date'];

	?>
	<table class="t_list">
		<thead>
	        <tr>
				<th width="2%">NO</th>
				<th width="12%">���̵�</th>
                <th width="12%">���� </th>
                <th width="12%">�г��� </th>
				<th width="12%">��¥ </th>
           	</tr>
       	</thead>
  		<tbody>
			<?
							
								
				$sql = "SELECT * FROM member where 1=1 ".$new_today_check." ".$search." order by hero_oldday desc LIMIT ".$start.", ".$list_page.";";
				//echo $sql;
									
				sql($sql);
									
				$i = '0';
				while($roll_list                             = @mysql_fetch_assoc($out_sql)){
			?>

		        	<input type="hidden" name="hero_idx[]" value="<?=$roll_list['hero_idx']?>">
		            	<tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
		                	<td><?=$j?></td>
							<td><?=$roll_list['hero_id']?></td>
		                    <td><?=name_masking($roll_list['hero_name'])?></td>
		                    <td><?=$roll_list['hero_nick']?></td>
							<td><?=$roll_list['hero_oldday']?></td>
		                </tr>
			<?
					$i++;
					$j--;
				}
			?>
		</tbody>
	</table>
	
	<?php 
}
##################################################################################################################################################################################
#########    end / �ű� ȸ�� �˻���     ###############################################################################################################################
##################################################################################################################################################################################
	
	
##################################################################################################################################################################################
#########    ����Ʈ �˻���     ###############################################################################################################################
##################################################################################################################################################################################

	


if($_REQUEST['search_area']=='point'){
	
		$next_path="board=".$_GET['board'].'&idx='.$_GET['idx'].'&search_area='.$_REQUEST['search_area'].'&select='.$_REQUEST['select'].'&kewyword='.$_REQUEST['kewyword'].'&month='.$_REQUEST['month'].'&date='.$_REQUEST['date'].'&order=';
		
		if($_REQUEST['select']=='hero_all'){
			$search = ' and ( A.hero_nick like \'%'.$_REQUEST['kewyword'].'%\' or A.hero_name like \'%'.$_REQUEST['kewyword'].'%\' or A.hero_id like \'%'.$_REQUEST['kewyword'].'%\' )';
		}elseif($_REQUEST['select']){
			$search = ' and A.'.$_REQUEST['select'].' like \'%'.$_REQUEST['kewyword'].'%\'';
		}
		
		if($_REQUEST['month']){
			$month = explode('/',$_REQUEST['month']);
			$new_today_check = " DATE_FORMAT( hero_today,  '%Y-%m' ) ='".$month[1]."-".$month[0]."'";
			$cate_month = $month[1]."�� ".$month[0]."�� ";
		}else{
			$new_today_check = " DATE_FORMAT( hero_today,  '%Y-%m' ) ='".date('Y-m')."'";
			$cate_month = date('Y�� m��');
		}
		
		if($_REQUEST['date']){
			$date = explode('/',$_REQUEST['date']);
			$new_today_check=" DATE_FORMAT( hero_today,  '%Y-%m-%d' ) ='".$date[2]."-".$date[0]."-".$date[1]."'";
			$cate_month = $date[2]."�� ".$date[0]."�� ".$date[1]."�� ";
		}
		if($_GET['order']){
			$order .= " order by ".$_GET['order'];
			$next_path .= "&order=".$_GET['order'];
		}else{
			$order .= " order by point_sum desc ";
		}
		

	
	$sql = 'SELECT count(*) ';
  	$sql .= 'FROM member AS A ';
  	$sql .= 'LEFT JOIN ( SELECT hero_code, SUM(hero_point) AS point_total, sum(case when '.$new_today_check.' then hero_point else 0 end) as point_sum FROM point GROUP BY hero_code ) AS B ON A.hero_code = B.hero_code ';
  	$sql .= 'where hero_level<=\''.$_SESSION['temp_level'].'\''.$search.'';
	
	//echo $sql;
	//echo $search_next;
	sql($sql);
	$out_sql = @mysql_fetch_assoc($out_sql);
	$total_data = $out_sql['count(*)'];
	$list_page=50;
	$page_per_list=10;
	
	if(!strcmp($_GET['page'], '')){
		$page = '1';
		$j=$total_data;
	}else{
		$page = $_GET['page'];
		$j=$total_data-(($_GET['page']-1)*$list_page);
	}
	
	$start = ($page-1)*$list_page;
	
	
	?>
	<table class="t_list">
		<thead>
	        	<tr>
					<th width="2%">NO</th>
                    <th width="10%">���̵�</th>
                    <th width="12%">����</th>
                    <th width="12%">�г���</th>
                    <th width="10%"><a href="<?=$_SERVER['PHP_SELF']."?".$next_path."&order=hero_level desc"?>">��</a> ���� <a href="<?=$_SERVER['PHP_SELF']."?".$next_path."&order=hero_level asc"?>">��</a></th>
                    <th width="12%"><a href="<?=$_SERVER['PHP_SELF']."?".$next_path."&order=point_total desc"?>">��</a> �� ����Ʈ <a href="<?=$_SERVER['PHP_SELF']."?".$next_path."&order=point_total asc"?>">��</a></th>
                    <th width="10%"><a href="<?=$_SERVER['PHP_SELF']."?".$next_path."&order=point_user_total desc"?>">��</a> ���� ����Ʈ <a href="<?=$_SERVER['PHP_SELF']."?".$next_path."&order=point_user_total asc"?>">��</a></th>
                    <th width="12%"><a href="<?=$_SERVER['PHP_SELF']."?".$next_path."&order=point_sum desc"?>">��</a> <?=$cate_month?> ����Ʈ<a href="<?=$_SERVER['PHP_SELF']."?".$next_path."&order=point_sum asc"?>">��</a></th>
               	</tr>
       		</thead>
  			<tbody>
  				<?php 
  				
  				$sql = 'SELECT A.hero_id, A.hero_name, A.hero_nick, A.hero_point, A.hero_level, ifnull(B.point_sum,0) as point_sum, ifnull(B.point_total,0) as point_total, (B.point_total-ifnull(C.total_use_point,0)) as point_user_total ';
  				$sql .= 'FROM member AS A ';
  				$sql .= 'LEFT JOIN ( SELECT hero_code, SUM(hero_point) AS point_total, sum(case when '.$new_today_check.' then hero_point else 0 end) as point_sum FROM point GROUP BY hero_code ) AS B ON A.hero_code = B.hero_code ';
  				$sql .= 'LEFT OUTER JOIN (select hero_code, SUM(hero_order_point) as total_use_point from order_main group by hero_code) as C on C.hero_code=A.hero_code ';
  				$sql .= 'where hero_level<=\''.$_SESSION['temp_level'].'\''.$search.''.$order.' limit '.$start.','.$list_page.';';

  				//echo $sql;
  				sql($sql);
  				
  				while($roll_list                             = @mysql_fetch_assoc($out_sql)){
  				?>
  					<tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
                    	<td><?=$j?></td>
						<td><?=$roll_list['hero_id']?></td>
                        <td><?=$roll_list['hero_name']?></td>
                        <td><?=$roll_list['hero_nick']?></td>
                        <td><?=$roll_list['hero_level']?></td>
                        <td><?=$roll_list['point_total']?></td>
                        <td><?=$roll_list['point_user_total']?></td>
                        <td><?=$roll_list['point_sum']?></td>
                    </tr>
  				
  				<?php
  					$j--; 
  				}
  				?>
  			</tbody>
	</table>
	<?php 
	
}

##################################################################################################################################################################################
#########    end / ����Ʈ �˻���     ###############################################################################################################################
##################################################################################################################################################################################
	
	
	
	

##################################################################################################################################################################################
#########    ������Ÿ �˻���      ###############################################################################################################################
##################################################################################################################################################################################

?>
	<table class="t_list">
		
		
		<?php 
			//����Ʈ
			if($_REQUEST['search_area']=='lover_star'){
	
				$next_path="board=".$_GET['board'].'&idx='.$_GET['idx'].'&search_area='.$_REQUEST['search_area'].'&select='.$_REQUEST['select'].'&kewyword='.$_REQUEST['kewyword'].'&month='.$_REQUEST['month'].'&date='.$_REQUEST['date'].'&order=';
		
				if($_REQUEST['select']=='hero_all'){
					$search = ' and ( A.hero_nick like \'%'.$_REQUEST['kewyword'].'%\' or A.hero_name like \'%'.$_REQUEST['kewyword'].'%\' or A.hero_id like \'%'.$_REQUEST['kewyword'].'%\' )';
				}elseif($_REQUEST['select']){
					$search = ' and A.'.$_REQUEST['select'].' like \'%'.$_REQUEST['kewyword'].'%\'';
				}

				if($_REQUEST['month']){
					$month = explode('/',$_REQUEST['month']);
					$new_today_check = " and DATE_FORMAT( hero_today,  '%Y-%m' ) ='".$month[1]."-".$month[0]."'";
				}else{
				}
				
				if($_REQUEST['date']){
					$date = explode('/',$_REQUEST['date']);
					$new_today_check=" and DATE_FORMAT( hero_today,  '%Y-%m-%d' ) ='".$date[2]."-".$date[0]."-".$date[1]."'";
				}
				if($_GET['order']){
					$order .= " order by ".$_GET['order'];
					$next_path .= "&order=".$_GET['order'];
				}else{
					$order .= " order by review_count desc";					
				}
				
				//echo $search;

	
				$sql = "SELECT count(A.hero_code) as count "; 
  				$sql .= "FROM (SELECT hero_code, hero_id, hero_name, hero_nick, COUNT( hero_code ) AS apply_count FROM mission_review WHERE 1=1 ".$new_today_check." GROUP BY hero_code) AS A ";
  				$sql .= "where 1=1 ".$search;
				
				sql($sql);
				$out_sql = @mysql_fetch_assoc($out_sql);
				$total_data = $out_sql['count'];
				$list_page=50;
				$page_per_list=10;
				
				if(!strcmp($_GET['page'], '')){
					$page = '1';
				}else{
					$page = $_GET['page'];
				}
				
				$start = ($page-1)*$list_page;
				
				if($_GET['page']){
					$j=$total_data-(($_GET['page']-1)*$list_page);
				}else{
					$j=$total_data;
				}
				
	
	?>
				
			<thead>
	        	<tr>
					<th width="2%">NO</th>
                    <th width="10%">���̵�</th>
                    <th width="12%">����</th>
                    <th width="12%">�г���</th>
                    <th width="12%"><a href="<?=$_SERVER['PHP_SELF']."?".$next_path."&order=apply_count desc"?>">��</a> �̼� ��û Ƚ��<a href="<?=$_SERVER['PHP_SELF']."?".$next_path."&order=apply_count asc"?>">��</a></th>
                    <th width="12%"><a href="<?=$_SERVER['PHP_SELF']."?".$next_path."&order=selected_count desc"?>">��</a> ���� ��÷ Ƚ��<a href="<?=$_SERVER['PHP_SELF']."?".$next_path."&order=selected_count asc"?>">��</a></th>
                    <th width="12%"><a href="<?=$_SERVER['PHP_SELF']."?".$next_path."&order=review_count desc"?>">��</a> ���� ��� Ƚ��<a href="<?=$_SERVER['PHP_SELF']."?".$next_path."&order=review_count asc"?>">��</a></th>
                    <th width="12%"><a href="<?=$_SERVER['PHP_SELF']."?".$next_path."&order=lover_count desc"?>">��</a> ����ı� ��÷ Ƚ��<a href="<?=$_SERVER['PHP_SELF']."?".$next_path."&order=lover_count asc"?>">��</a></th>
               	</tr>
       		</thead>
  			<tbody>
  				<?php 
  				$sql = "SELECT A.*,B.*,C.*,D.* "; 
  				$sql .= "FROM (SELECT hero_code, hero_id, hero_name, hero_nick, COUNT( hero_code ) AS apply_count FROM mission_review WHERE 1=1 ".$new_today_check." GROUP BY hero_code) AS A ";
  				$sql .= "LEFT OUTER JOIN (SELECT hero_code, SUM(lot_01) AS selected_count FROM mission_review where 1=1 ".$new_today_check." group by hero_code) AS B ON A.hero_code = B.hero_code "; 
  				$sql .= "LEFT OUTER JOIN (SELECT hero_code, COUNT( * ) AS review_count FROM board WHERE hero_table =  'group_04_05' OR hero_table =  'group_04_06' OR hero_table =  'group_04_06' OR hero_table = 'group_04_07' ".$new_today_check." GROUP BY hero_code ) AS C ON A.hero_code = C.hero_code "; 
  				$sql .= "LEFT OUTER JOIN (SELECT hero_code, COUNT( * ) AS lover_count FROM board WHERE hero_board_three =1 ".$new_today_check." GROUP BY hero_code) AS D ON A.hero_code = D.hero_code "; 
  				$sql .= "where 1=1 ".$search." ".$order." limit ".$start.",".$list_page;
  				//echo $sql;
  				sql($sql);
  				
  				$i = '0';
  				while($roll_list                             = @mysql_fetch_assoc($out_sql)){
  				?>
  					<tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
                    	<td><?=$j?></td>
						<td><?=$roll_list['hero_id']?></td>
                        <td><?=$roll_list['hero_name']?></td>
                        <td><?=$roll_list['hero_nick']?></td>
                        <td><?=$roll_list['apply_count']?></td>
                        <td><?=$roll_list['selected_count']?></td>
                        <td><?=$roll_list['review_count']?></td>
                        <td><?=$roll_list['lover_count']?></td>
                    </tr>
  				
  				<?php
  				$j--; 
  				}
  				?>
  			
			</tbody>
		
		<?php 
			}
		?>
		</table>
	<?php
			
##################################################################################################################################################################################
#########    end / ������Ÿ �˻���     ###############################################################################################################################
##################################################################################################################################################################################
			
			
			
##################################################################################################################################################################################
#########    �Խ��� ��õ ���      ###############################################################################################################################
##################################################################################################################################################################################			
	?>
	<table class="t_list">
					
		<?php 
			if($_REQUEST['search_area']=='recommand'){
				
					
				$mode = $_GET['recom_mode'];
					
				if($mode=='recom_del'){
					$board_idx = $_GET['board_idx'];
				
					$recom_cancel_query = "update board set hero_rec_manage=1 where hero_idx=".$board_idx;
					//echo $recom_cancel_query;
					//exit;
					$recom_cancel_res = mysql_query($recom_cancel_query) or die(mysql_error());
					
					if($recom_cancel_res!=1)	echo "<script>alert('��õ�� ��ҿ� �����Ͽ����ϴ�. �ٽ� �õ��� �ּ���.');</script>";
					//echo $recom_cancel_query;
				}elseif($mode=='recom_back'){
					
					$board_idx = $_GET['board_idx'];
					$recom_cancel_query = "update board set hero_rec_manage=0 where hero_idx=".$board_idx;
					$recom_cancel_res = mysql_query($recom_cancel_query) or die(mysql_error());
						
					if($recom_cancel_res!=1)	echo "<script>alert('��ҿ� �����Ͽ����ϴ�. �ٽ� �õ��� �ּ���.');</script>";
					
				}
				
					$next_path="board=".$_GET['board'].'&idx='.$_GET['idx'].'&search_area='.$_REQUEST['search_area'].'&select='.$_REQUEST['select'].'&kewyword='.$_REQUEST['kewyword'].'&month='.$_REQUEST['month'].'&date='.$_REQUEST['date'];
					
					if($_REQUEST['select']=='hero_all'){
						$search = ' and ( A.hero_nick like \'%'.$_REQUEST['kewyword'].'%\' or A.hero_name like \'%'.$_REQUEST['kewyword'].'%\' or A.hero_id like \'%'.$_REQUEST['kewyword'].'%\' )';
					}elseif($_REQUEST['select']){
						if($_REQUEST['select']=='hero_nick') 		$select = "hero_board_nick";
						elseif($_REQUEST['select']=='hero_name') 	$select = "hero_board_name";
						elseif($_REQUEST['select']=='hero_id') 		$select = "hero_board_id";
						$search = ' and A.'.$select.' like \'%'.$_REQUEST['kewyword'].'%\'';
					}
	
					if($_REQUEST['month']){
						$month = explode('/',$_REQUEST['month']);
						$new_today_check = " and DATE_FORMAT( A.hero_today,  '%Y-%m' ) ='".$month[1]."-".$month[0]."'";
					}
					
					if($_REQUEST['date']){
						$date = explode('/',$_REQUEST['date']);
						$new_today_check=" and DATE_FORMAT( A.hero_today,  '%Y-%m-%d' ) ='".$date[2]."-".$date[0]."-".$date[1]."'";
					}
					
					if($_GET['order']){
						$order .= " order by ".$_GET['order'];
						$next_path .= "&order=".$_GET['order'];
					}else{
						$order .= " order by A.hero_board desc, A.hero_today desc";
					}
					
					
				
			
					$sql = "select count(A.total_count) as count from (select *, count(hero_board_idx) AS total_count from hero_recommand group by hero_board_idx) AS A ";
					$sql .= "where 1=1 ".$new_today_check." ".$search;
					//echo $sql; 
						
					sql($sql);
					$out_sql = @mysql_fetch_assoc($out_sql);
					$total_data = $out_sql['count'];
					$list_page=50;
					$page_per_list=10;
					
					if(!strcmp($_GET['page'], '')){
						$page = '1';
					}else{
						$page = $_GET['page'];
					}
					
					$start = ($page-1)*$list_page;
					
					if($_GET['page']){
						$j=$total_data-(($_GET['page']-1)*$list_page);
					}else{
						$j=$total_data;
					}
							
			?>
							
						<thead>
				        	<tr>
								 <th width="5%">NO</th>
								 <th width="8%">�Խ���</th>
                                 <th width="25%">�Խñ� ����</th>
                                 <th width="8%">�Խñ� ����</th>
                                 <th width="8%">�Խñ� �ۼ���</th>
                                 <th width="8%">�Խñ� �г���</th>
                                 <th width="5%"><a href="<?=$_SERVER['PHP_SELF']."?".$next_path."&order=total_count desc"?>">��</a> ��õ �հ�<a href="<?=$_SERVER['PHP_SELF']."?".$next_path."&order=otal_count asc"?>">��</a></th>
                                 <th width="3%">��õ�� ���⿩��</th>
			               	</tr>
			       		</thead>
			  			<?
						$sql = "select A.*, count(A.hero_board_idx) AS total_count, C.hero_idx as board_idx, left(C.hero_title,48) as hero_title, C.hero_rec_manage from hero_recommand AS A ";
						$sql .= "INNER JOIN board AS C on A.hero_board_idx = C.hero_idx ";
						$sql .= "where 1=1 ".$new_today_check." ".$search." group by hero_board_idx ";
						$sql .= $order." limit ".$start.",".$list_page;
						//echo $sql;
						sql($sql,'on');
						while($roll_list                             = @mysql_fetch_assoc($out_sql)){
							
							if($roll_list['hero_board']=='group_01_01') $hero_group = "�ɹ̳���";
							elseif($roll_list['hero_board']=='group_01_02') $hero_group = "�ȼ�����";
							elseif($roll_list['hero_board']=='group_01_03') $hero_group = "�̽İ���";
							elseif($roll_list['hero_board']=='group_01_04') $hero_group = "��ȭ����";
							elseif($roll_list['hero_board']=='group_04_11') $hero_group = "��α��� ";
							elseif($roll_list['hero_board']=='group_02_01') $hero_group = "�����Ϸ�";
							elseif($roll_list['hero_board']=='group_02_02') $hero_group = "����&��ȥ";
							elseif($roll_list['hero_board']=='group_03_04') $hero_group = "�������̵��";
							elseif($roll_list['hero_board']=='group_03_05') $hero_group = "����Ī����";
							elseif($roll_list['hero_board']=='group_02_05') $hero_group = "�������ι�";
							elseif($roll_list['hero_board']=='group_02_03') $hero_group = "�Ը��� �̺�Ʈ";
							elseif($roll_list['hero_board']=='group_04_05') $hero_group = "�Ϲݹ̼�";
							elseif($roll_list['hero_board']=='group_04_06') $hero_group = "�����̾��̼�";
							elseif($roll_list['hero_board']=='group_04_07') $hero_group = "�ְ�ڽ�";
							elseif($roll_list['hero_board']=='group_04_09') $hero_group = "�����ı�";
							elseif($roll_list['hero_board']=='group_04_20') $hero_group = "����� Ȯ��";
							elseif($roll_list['hero_board']=='group_04_03') $hero_group = "�Ը��� �̺�Ʈ";
							
							if($roll_list['hero_rec_manage']==0)	$hero_rec_manage = "<a style='background-color:#376ea6;padding:3px;border-radius:3px;color:white;' href='".$_SERVER['PHP_SELF']."?".$next_path."&recom_mode=recom_del&board_idx=".$roll_list['board_idx']."'>��õ�� ���</a>";
							else									$hero_rec_manage = "X <a style='border:1px solid #376ea6;padding:3px;border-radius:3px;' href='".$_SERVER['PHP_SELF']."?".$next_path."&recom_mode=recom_back&board_idx=".$roll_list['board_idx']."'>���</a>";
							
						?>
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
                                    <td><?=$j ?></td>
                                    <td><?=$hero_group ?></td>
                                    <td><?=$roll_list['hero_title']?></td>
                                    <td><a href='<?=$roll_list['hero_url']?>' target='_blank'>�Խñ� ����</a></td>
                                    <td><?=$roll_list['hero_board_id']?></td>
                                    <td><?=$roll_list['hero_board_nick']?></td>
                                    <td><?=$roll_list['total_count']?></td>
                                    <td><?=$hero_rec_manage?></td>
                                </tr>
			  				
			  				<?php
			  				$j--; 
			  				}
			  				?>
			  			</tbody>
					
					<?php 
						}
				?>
												
				</table>
				<?		
##################################################################################################################################################################################
#########    END / �Խ��� ��õ ���      ###############################################################################################################################
##################################################################################################################################################################################						
				
				
##################################################################################################################################################################################
#########    �Խ��� �Ű� ���      ###############################################################################################################################
##################################################################################################################################################################################			
	?>
	<?php 
		
	?>
	
	<table class="t_list">
					
		<?php 
			if($_GET['mode']=='del' && is_numeric($_GET['id'])){
				$sql_del = "update board set hero_use=0 where hero_idx=".$_GET['id']."";
				//echo $sql_del;
				//exit;
				$pf = mysql_query($sql_del) or die("<script>alert('������ �����Ͽ����ϴ�. �����ڿ��� �������ּ���.')</script>");
				if($pf){
				
					echo "<script>alert('�����Ǿ����ϴ�')</script>";
					echo "<script>location.href='".$_SERVER['PHP_SELF']."?board=".$_GET['board']."&idx=".$_GET['idx']."&search_area=".$_REQUEST['search_area']."&select=".$_REQUEST['select']."&kewyword=".$_REQUEST['kewyword']."&month=".$_REQUEST['month']."&date=".$_REQUEST['date']."'</script>";
					
				}else{
					
					echo "<script>alert('������ �����Ͽ����ϴ�. �����ڿ��� �������ּ���.')</script>";					

				}

			}elseif($_GET['mode']=='cancle' && is_numeric($_GET['id'])){
				$sql_del = "update board set hero_use=1 where hero_idx=".$_GET['id']."";
				//echo $sql_del;
				//exit;
				$pf = mysql_query($sql_del) or die("<script>alert('���� ��ҿ� �����Ͽ����ϴ�. �����ڿ��� �������ּ���.')</script>");
				if($pf){
				
					echo "<script>alert('������ ��ҵǾ����ϴ�')</script>";
					echo "<script>location.href='".$_SERVER['PHP_SELF']."?board=".$_GET['board']."&idx=".$_GET['idx']."&search_area=".$_REQUEST['search_area']."&select=".$_REQUEST['select']."&kewyword=".$_REQUEST['kewyword']."&month=".$_REQUEST['month']."&date=".$_REQUEST['date']."'</script>";
					
				}else{
					
					echo "<script>alert('���� ��ҿ� �����Ͽ����ϴ�. �����ڿ��� �������ּ���.')</script>";					

				}

			}
		
			if($_REQUEST['search_area']=='report'){
				
					$next_path="board=".$_GET['board'].'&idx='.$_GET['idx'].'&search_area='.$_REQUEST['search_area'].'&select='.$_REQUEST['select'].'&kewyword='.$_REQUEST['kewyword'].'&month='.$_REQUEST['month'].'&date='.$_REQUEST['date'];
					
					if($_REQUEST['select']=='hero_all'){
						$search = ' and ( A.hero_board_nick like \'%'.$_REQUEST['kewyword'].'%\' or A.hero_board_name like \'%'.$_REQUEST['kewyword'].'%\' or A.hero_board_id like \'%'.$_REQUEST['kewyword'].'%\' )';
					}elseif($_REQUEST['select']){
						if($_REQUEST['select']=='hero_nick') $select = "hero_board_nick";
						if($_REQUEST['select']=='hero_name') $select = "hero_board_name";
						if($_REQUEST['select']=='hero_id') $select = "hero_board_id";
						$search = ' and A.'.$select.' like \'%'.$_REQUEST['kewyword'].'%\'';
					}
	
					if($_REQUEST['month']){
						$month = explode('/',$_REQUEST['month']);
						$new_today_check = " and DATE_FORMAT( A.hero_today,  '%Y-%m' ) ='".$month[1]."-".$month[0]."'";
					}
					
					if($_REQUEST['date']){
						$date = explode('/',$_REQUEST['date']);
						$new_today_check=" and DATE_FORMAT( A.hero_today,  '%Y-%m-%d' ) ='".$date[2]."-".$date[0]."-".$date[1]."'";
					}
					
					if($_GET['order']){
						$search .= " order by ".$_GET['order'];
						$next_path .= "&order=".$_GET['order'];
					}else{
						$order .= " order by A.hero_board desc";
					}
					
					
				
			
					$sql = "select count(A.hero_board_idx) as count from (select hero_board_idx, count(hero_board_idx) from hero_report group by hero_board_idx) as A ";
			  		$sql .= "where 1=1 ".$new_today_check." ".$search." ";
					//echo $sql;	
			  		
					sql($sql);
					$out_sql = @mysql_fetch_assoc($out_sql);
					$total_data = $out_sql['count'];
					$list_page=50;
					$page_per_list=10;
					
					if(!strcmp($_GET['page'], '')){
						$page = '1';
					}else{
						$page = $_GET['page'];
					}
					
					$start = ($page-1)*$list_page;
					
					if($_GET['page']){
						$j=$total_data-(($_GET['page']-1)*$list_page);
					}else{
						$j=$total_data;
					}
							
			?>
			
			
			<script>

					function delete_writing(no){
						if (confirm("�����Ͻðڽ��ϱ�??") == true){ 
						    location.href="<?php echo $_SERVER['PHP_SELF'].'?'.$next_path.'&mode=del&id='?>"+no+"";
						}else{   //���
						    return;
						}
					}
					function cancle_writing(no){
						if (confirm("������ ����Ͻðڽ��ϱ�??") == true){ 
						    location.href="<?php echo $_SERVER['PHP_SELF'].'?'.$next_path.'&mode=cancle&id='?>"+no+"";
						}else{   //���
						    return;
						}
					}
			</script>
							
						<thead>
				        	<tr>
								 <th width="5%">NO</th>
								 <th width="8%">�Խ���</th>
                                 <th width="25%">�Խñ� ����</th>
                                 <th width="8%">�Խñ� ����</th>
                                 <th width="8%">�Խñ� �ۼ���</th>
                                 <th width="8%">�Խñ� �г���</th>
                                 <th width="5%"><a href="<?=$_SERVER['PHP_SELF']."?".$next_path."&order=total_count desc"?>">��</a> �Ű� �հ�<a href="<?=$_SERVER['PHP_SELF']."?".$next_path."&order=otal_count asc"?>">��</a></th>
                                 <th width="5%">����</th>
			               	</tr>
			       		</thead>
			  			<?
			  			$sql = "select A.*, count(A.hero_board_idx) AS total_count, left(B.hero_title,48) as hero_title, B.hero_use from hero_report as A ";
						$sql .= "LEFT OUTER JOIN board AS B on A.hero_board_idx = B.hero_idx ";
			  			$sql .= "where 1=1 ".$new_today_check." ".$search." group by hero_board_idx ";
						$sql .= $order." limit ".$start.",".$list_page;
			  			
						//echo $sql;
						sql($sql,'on');
						while($roll_list                             = @mysql_fetch_assoc($out_sql)){
							
							if($roll_list['hero_board']=='group_01_01') $hero_group = "�ɹ̳���";
							elseif($roll_list['hero_board']=='group_01_02') $hero_group = "�ȼ�����";
							elseif($roll_list['hero_board']=='group_01_03') $hero_group = "�̽İ���";
							elseif($roll_list['hero_board']=='group_01_04') $hero_group = "��ȭ����";
							elseif($roll_list['hero_board']=='group_04_11') $hero_group = "��α��� ";
							elseif($roll_list['hero_board']=='group_02_01') $hero_group = "�����Ϸ�";
							elseif($roll_list['hero_board']=='group_02_02') $hero_group = "����&��ȥ";
							elseif($roll_list['hero_board']=='group_03_04') $hero_group = "�������̵��";
							elseif($roll_list['hero_board']=='group_03_05') $hero_group = "����Ī����";
							elseif($roll_list['hero_board']=='group_02_05') $hero_group = "�������ι�";
							elseif($roll_list['hero_board']=='group_02_03') $hero_group = "�Ը��� �̺�Ʈ";
							elseif($roll_list['hero_board']=='group_04_05') $hero_group = "�Ϲݹ̼�";
							elseif($roll_list['hero_board']=='group_04_06') $hero_group = "�����̾��̼�";
							elseif($roll_list['hero_board']=='group_04_07') $hero_group = "�ְ�ڽ�";
							elseif($roll_list['hero_board']=='group_04_09') $hero_group = "�����ı�";
							
							if($roll_list['hero_use']==0){
								$button = "<input type='button' value='���� ���' style='background: #9B9B9B;padding: 4px 7px;color: #FFFFFF;font-weight: 800;border-radius: 9px;cursor: pointer;'/ onclick='cancle_writing(".$roll_list['hero_board_idx'].")'>";
							}elseif($roll_list['hero_use']==1){
								$button = "<input type='button' value='�� ����' style='background: #376EA6;padding: 4px 7px;color: #FFFFFF;font-weight: 800;border-radius: 9px;cursor: pointer;'/ onclick='delete_writing(".$roll_list['hero_board_idx'].")'>";
							}
							
						?>
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
                                    <td><?=$j ?></td>
                                    <td><?=$hero_group ?></td>
                                    <td><?=$roll_list['hero_title']?></td>
                                    <td><a href='<?=$roll_list['hero_url']?>' target='_blank'>�Խñ� ����</a></td>
                                    <td><?=$roll_list['hero_board_id']?></td>
                                    <td><?=$roll_list['hero_board_nick']?></td>
                                    <td><?=$roll_list['total_count']?></td>
                                    <td><?=$button?></td>
                                </tr>
			  				
			  				<?php
			  				$j--; 
			  				}
			  				?>
			  			</tbody>
					
					<?php 
						}
				?>
												
				</table>
				<?		
##################################################################################################################################################################################
#########    END / �Խ��� �Ű� ���      ###############################################################################################################################
##################################################################################################################################################################################						
				?>

	
        	<div style="width:100%; text-align:center; margin-top:20px;"><? include_once PATH_INC_END.'page.php';?></div>
        	
        	

                        