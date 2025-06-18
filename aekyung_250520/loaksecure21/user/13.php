<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
if(strcmp($_POST['kewyword'], '')){
	if($_POST['select']=='hero_all'){
		$search = ' and ( hero_nick like \'%'.$_POST['kewyword'].'%\' or hero_name like \'%'.$_POST['kewyword'].'%\' or hero_nick like \'%'.$_POST['kewyword'].'%\' )';
		$search_next = '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
	}else{
		$search = ' and '.$_POST['select'].' like \'%'.$_POST['kewyword'].'%\'';
		$search_next = '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
	}
}

if($_POST['month']){
	$month = explode('/',$_POST['month']);
	$new_today_check = " and DATE_FORMAT( hero_today,  '%Y-%m' ) ='".$month[1]."-".$month[0]."'";
}else{
	$new_today_check = " and DATE_FORMAT( hero_today,  '%Y-%m' ) ='".date('Y-m')."'";
}
if($_POST['date']){
	$date = explode('/',$_POST['date']);
	$new_today_check=" and DATE_FORMAT( hero_today,  '%Y-%m-%d' ) ='".$date[2]."-".$date[0]."-".$date[1]."'";
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

//2014-06-05 넘버링
if($_GET['page']){
	$j=$total_data-(($_GET['page']-1)*$list_page);
}else{
	$j=$total_data;
}

$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board']."&view=".$_GET['view'].$search_next.'&idx='.$_GET['idx'].'&today='.$_GET['today'].'&order='.$_GET['order'].'&month='.$_REQUEST['month'].'&date='.$_REQUEST['date'];;
######################################################################################################################################################

?>
<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/jquery-ui-datepicker-1.10.4.custom.min.css">
 <link rel="stylesheet" type="text/css" href="<?=ADMIN_DEFAULT?>/css/jquery.mtz.monthpicker.css"/>
 <script src="<?=ADMIN_DEFAULT?>/js/jquery-ui-datepicker-1.10.4.custom.min.js"></script>
 <script type="text/javascript" src="<?=ADMIN_DEFAULT?>/js/jquery.mtz.monthpicker.js"></script>

 <script>
	$(document).ready(function(){
		var options = {
			monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월']
		};
 		$('#default_widget').monthpicker(options);
		$( "#datepicker" ).datepicker({
			dayNamesMin:[ "일", "월", "화", "수", "목", "금", "토" ],
			monthNames:["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"] 
		});

	});
	function outfocus(data){
		if(data=='month'){
			$('#datepicker').val('');
		}else if(data=='date'){
			$('#default_widget').val('');
		}
	}
 </script>
<style>
.t_list{white-space:nowrap;}
.t_list td,tr,th{white-space:nowrap;}
</style>
                        <table class="t_list">
                            <thead>
                                <tr>
                                    <td colspan="5" align="center" style="padding:10px">
										 <div class="searchbox" style="margin-top:20px;background:url(../image/bbs/bg_search_02.gif);width: 687px;">
											<div class="wrap_1">
											<form action="<?=PATH_HOME.'?'.get('page');?>" method="POST" >
												<select name="select" style="width:90px;">
													<option value="hero_nick"<?if(!strcmp($_POST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>아이디</option>
													 <option value="hero_nick"<?if(!strcmp($_POST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>닉네임</option>
													<option value="hero_name"<?if(!strcmp($_POST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>성명</option>
													  <option value="hero_all"<?if(!strcmp($_POST['select'], 'hero_all')){echo ' selected';}else{echo '';}?>>아이디+닉네임+성명</option>
												</select>
												<input name="kewyword" type="text" value="<?= $_POST['kewyword'];?>" class="kewyword" id="kewyword" style='width: 110px;'>
												<span style="color: #999999;font-size: 9pt;font-weight: 800;margin-left: 10px;">월별</span>
												<input type="text" id="default_widget" name='month' class="mtz-monthpicker-widgetcontainer" style="width:100px;" value='<?if($_POST['month']){echo $_POST['month'];}elseif(!$_POST['month'] && !$_POST['date']){echo date('m/Y');}?>' onchange="outfocus('month');">
												<span style="color: #999999;font-size: 9pt;font-weight: 800;margin-left: 10px;">일별</span>
												<input type="text" id="datepicker"  name='date'  style="width:80px;" value='<?if($_POST['date']){echo $_POST['date'];}else{echo '';}?>' onchange="outfocus('date');">
												<input type="image" src="../image/bbs/btn_search.gif" alt="검색" class="bd0">
											</form>
											</div>
										</div>
                                    </td>
                                </tr>
                                <tr>
									<th width="2%">NO</th>
									<th width="12%">아이디</th>
                                    <th width="12%">성명 </th>
                                    <th width="12%">닉네임 </th>
									<th width="12%">날짜 </th>
                                </tr>
                            </thead>
                      <tbody>
<?
if(!strcmp($_GET['order'], '')){
    $view_order = '';
}else{
    $view_order = ' order by '.$_GET['order'];
}

$sql = "SELECT * FROM member where 1=1 ".$new_today_check." ".$search." order by hero_today desc LIMIT ".$start.", ".$list_page.";";
//echo $sql;

sql($sql);

$i = '0';
while($roll_list                             = @mysql_fetch_assoc($out_sql)){
?>

                                <input type="hidden" name="hero_idx[]" value="<?=$roll_list['hero_idx']?>">
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
                                    <td><?=$j?></td>
									 <td><?=$roll_list['hero_id']?></td>
                                    <td><?=$roll_list['hero_name']?></td>
                                    <td><?=$roll_list['hero_nick']?></td>
									<td><?=$roll_list['hero_today']?></td>
                                </tr>
<?
$i++;
$j--;
}
?>
                            </tbody>
                        </table>
                        <div style="width:100%; text-align:center; margin-top:20px;"><? include_once PATH_INC_END.'page.php';?></div>
                        