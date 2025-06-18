<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
if(strcmp($_REQUEST['kewyword'], '')){
	if($_REQUEST['select']=='hero_all'){
		$search = ' and ( hero_nick like \'%'.$_REQUEST['kewyword'].'%\' or hero_name like \'%'.$_REQUEST['kewyword'].'%\' or hero_id like \'%'.$_REQUEST['kewyword'].'%\' )';
		$search_next = '&select='.$_REQUEST['select'].'&kewyword='.$_REQUEST['kewyword'];
	}else{
		$search = ' and '.$_REQUEST['select'].' like \'%'.$_REQUEST['kewyword'].'%\'';
		$search_next = '&select='.$_REQUEST['select'].'&kewyword='.$_REQUEST['kewyword'];
	}
}


$sql = "select count(*) from member where 1=1 ".$search."";
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
$next_path="board=".$_GET['board']."&view=".$_GET['view'].$search_next.'&idx='.$_GET['idx'].'&today='.$_GET['today'].'&order='.$_GET['order'].'&month='.$_REQUEST['month'];
######################################################################################################################################################

if($_REQUEST['kind']=="add"){
	$table = "review";
	$column = "댓글";
}elseif($_REQUEST['kind']=="write" or $_REQUEST['kind']==""){
	$table = "board";
	$column = "작성글";
}
if($_REQUEST['order']==''){
	$_REQUEST['order'] = "total_all desc ";
}

if($_REQUEST['month']){
	$month = explode('/',$_REQUEST['month']);
	$new_today_check = $month[1]."-".$month[0];
}else{
	$new_today_check = date('Y-m');
}


?>
 <script type="text/javascript" src="<?=ADMIN_DEFAULT?>/js/jquery.mtz.monthpicker.js"></script>
 <link rel="stylesheet" type="text/css" href="<?=ADMIN_DEFAULT?>/css/jquery.mtz.monthpicker.css"/>
 <script>
	$(document).ready(function(){
		var options = {
			monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월']
		};
 		$('#default_widget').monthpicker(options);
	});
	function erase_month(){
		$('#default_widget').val("<?=date('m/Y')?>");
		$('#kewyword').val('');
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
												<select name="kind" id="">
												  <option value="write"<?if(!strcmp($_REQUEST['kind'], 'write')){echo ' selected';}else{echo '';}?>>작성글</option>
												  <option value="add"<?if(!strcmp($_REQUEST['kind'], 'add')){echo ' selected';}else{echo '';}?>>댓글</option>
												</select>
												<select name="select" style='width: 90px;'>
													<option value="hero_nick"<?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>아이디</option>
													<option value="hero_nick"<?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>닉네임</option>
													<option value="hero_name"<?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>이름</option>
													<option value="hero_all"<?if(!strcmp($_REQUEST['select'], 'hero_all')){echo ' selected';}else{echo '';}?>>아이디+닉네임+이름</option>
												</select>
												<input name="kewyword" type="text" value="<?= $_REQUEST['kewyword'];?>" class="kewyword" id="kewyword" style='width: 120px;'>
												<span style="color: #999999;font-size: 9pt;font-weight: 800;margin-left: 10px;">월별 검색</span>
												<input type="text" id="default_widget" name='month' class="mtz-monthpicker-widgetcontainer" value='<?if($_REQUEST['month']){echo $_REQUEST['month'];}else{echo date('m/Y');}?>'>
												<input type="image" src="../image/bbs/btn_search.gif" alt="검색" class="bd0">
											</form>
											</div>
										</div>
                                    </td>
                                </tr>
                                <tr>
									<th width="4%">NO</th>
									<th width="12%">아이디</th>
                                    <th width="12%">성명 </th>
                                    <th width="12%">닉네임 </th>
                                    <th width="12%">
										<a href="<?=PATH_HOME.'?board=user&idx=62&order=total_all desc&kewyword='.$_REQUEST['kewyword'].'&month='.$_REQUEST['month'].'&kind='.$_REQUEST['kind'].'&select='.$_REQUEST['select'];?>">
											▼
										</a>
											<?=$column?> 전체 통계 
										<a href="<?=PATH_HOME.'?board=user&idx=62&order=total_all asc&kewyword='.$_REQUEST['kewyword'].'&month='.$_REQUEST['month'].'&kind='.$_REQUEST['kind'].'&select='.$_REQUEST['select'];?>">
											▲
										</a>
									</th>
									<th width="12%">
										<a href="<?=PATH_HOME.'?board=user&idx=62&order=total_month desc&kewyword='.$_REQUEST['kewyword'].'&month='.$_REQUEST['month'].'&kind='.$_REQUEST['kind'].'&select='.$_REQUEST['select'];?>">
											▼
										</a>
										<?=$column?> 월별 통계
										<a href="<?=PATH_HOME.'?board=user&idx=62&order=total_month asc&kewyword='.$_REQUEST['kewyword'].'&month='.$_REQUEST['month'].'&kind='.$_REQUEST['kind'].'&select='.$_REQUEST['select'];?>">
											▲
										</a>
									</th>
                                </tr>
                            </thead>
                      <tbody>
<?
if(!strcmp($_GET['order'], '')){
    $view_order = '';
}else{
    $view_order = ' order by '.$_GET['order'];
}
//select a.*, (SELECT SUM(hero_point) FROM point where DATE_FORMAT(hero_today,'%Y-%m')='2013-12' where a.hero_code=hero_code GROUP BY hero_code) As hero_reid from member AS a
//echo $sql = 'select *, (SELECT hero_id,hero_code, SUM(hero_point) AS point_sum FROM point where DATE_FORMAT(hero_today,\'%Y-%m\')=\''.$new_today_check.'\' GROUP BY hero_code) As hero_reid, from member AS a where hero_level<=\''.$_SESSION['temp_level'].'\''.$search.$view_order.' limit '.$start.','.$list_page.';';
//$sql = 'SELECT a.hero_id, a.hero_name, a.hero_nick, a.hero_point, b.point_sum FROM member AS a LEFT JOIN ( SELECT hero_id,hero_code, SUM(hero_point) AS point_sum FROM point where DATE_FORMAT(hero_today,\'%Y-%m\')=\''.$new_today_check.'\' GROUP BY hero_code ) AS b ON ( a.hero_code = b.hero_code ) where hero_level<=\''.$_SESSION['temp_level'].'\''.$search.$view_order.' limit '.$start.','.$list_page.';';
//$sql = 'select a.*, (SELECT SUM(hero_point) FROM point where a.hero_code=hero_code GROUP BY hero_code) As point_total, (SELECT SUM(hero_point) FROM point where DATE_FORMAT(hero_today,\'%Y-%m\')=\''.$new_today_check.'\' and a.hero_code=hero_code GROUP BY hero_code) As point_sum from member AS a where hero_level<=\''.$_SESSION['temp_level'].'\''.$search.$view_order.' limit '.$start.','.$list_page.';';
//$sql = 'select * from (select m.hero_idx,m.hero_id,m.hero_pw,m.hero_name,m.hero_nick,sum(p.hero_point) as point_total,sum(case when  DATE_FORMAT(p.hero_today,\'%Y-%m\')=\''.$new_today_check.'\'  then p.hero_point else 0 end) as point_sum FROM point as p,member as m where hero_level<=\''.$_SESSION['temp_level'].'\''.$search.' and p.hero_code=m.hero_code GROUP BY m.hero_code) as sub1 '.$view_order.limit '.$start.','.$list_page.';';

$sql = "SELECT A.hero_id, A.hero_name, A.hero_nick, IFNULL( B.write_total, 0 ) AS total_all, IFNULL( B.write_sum, 0 ) AS total_month FROM member A LEFT JOIN (SELECT hero_code, COUNT( * ) AS write_total, SUM( CASE WHEN DATE_FORMAT( hero_today,  '%Y-%m' ) =  '".$new_today_check."' THEN 1 ELSE 0 END ) AS write_sum FROM ".$table." where 1=1 GROUP BY hero_code) B ON ( A.hero_code = B.hero_code ) WHERE 1=1 ".$search." order by ".$_REQUEST['order']." LIMIT ".$start.", ".$list_page.";";
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
                                    <td><?=$roll_list['total_all']?></td>
									<td><?=$roll_list['total_month']?></td>
                                </tr>
<?
$i++;
$j--;
}
?>
                            </tbody>
                        </table>
                        <div style="width:100%; text-align:center; margin-top:20px;"><? include_once PATH_INC_END.'page.php';?></div>
                        