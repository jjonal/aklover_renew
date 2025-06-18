<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
//2014-06-09 검색어 추가
if(strcmp($_POST['kewyword'], '')){
	if($_POST['select']=='hero_all'){
		$search = ' and ( a.hero_nick like \'%'.$_POST['kewyword'].'%\' or a.hero_id like \'%'.$_POST['kewyword'].'%\')';
		$search_next = '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
	}else{
		$search = ' and '.$_POST['select'].' like \'%'.$_POST['kewyword'].'%\'';
	    $search_next = '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
	}
}else if(strcmp($_GET['kewyword'], '')){
    if($_GET['select']=='hero_all'){
		$search = ' and ( a.hero_nick like \'%'.$_GET['kewyword'].'%\' or a.hero_id like \'%'.$_GET['kewyword'].'%\')';
		$search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
	}else{
		$search = ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
		$search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
	}
}

if(strcmp($_POST['month'], '')){
	
	$month = explode('/',$_POST['month']);
	
	$firstday = strtotime($month[1]."-".$month[0]."-01 00:00:00");
	$lastday = date("t", $firstday);
	$firstday = date('Y-m-d H:i:s',$firstday);
	
	$lastday = strtotime( $month[1]."-".$month[0]."-".$lastday." 23:59:59");
	$lastday = date('Y-m-d H:i:s', $lastday);

	$search_month = " and a.hero_today>='".$firstday."' and a.hero_today<='".$lastday."' ";
}


//$sql = 'select * from member where hero_level<=\''.$_SESSION['temp_level'].'\' '.$search.' ';
$sql = 'SELECT a.*, count(a.hero_id) AS user_count from point AS a LEFT JOIN member AS b ON a.hero_code = b.hero_code where a.hero_type=\'member\''.$search.$search_month.$view_order.' group by hero_id asc';
sql($sql);
$total_data = @mysql_num_rows($out_sql);
$list_page=100;
$page_per_list=10;

//2014-06-09 넘버링
if($_GET['page']){
	$j=$total_data-(($_GET['page']-1)*$list_page);
}else{
	$j=$total_data;
}

if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board']."&view=".$_GET['view'].$search_next.'&idx='.$_GET['idx'];
######################################################################################################################################################
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
		$('#default_widget').val('');
		$('#kewyword').val('');
	}
 </script>

<style>
	td.mtz-monthpicker-month {        text-align:center;      }
	select.mtz-monthpicker:focus {        outline: none;      }   
	.t_list{white-space:nowrap;}
	.t_list td,tr,th{white-space:nowrap;}
</style>
                        <table class="t_list">
                            <thead>
                                <tr>
                                    <td colspan="7" align="center" style="padding:10px">
                                        <div class="searchbox" style="margin-top:20px;background:url(../image/bbs/bg_search_02.gif);width: 687px;">
                                            <div class="wrap_1">
                                            <form action="<?=PATH_HOME?>?board=<?=$_REQUEST['board']?>&view=<?=$_REQUEST['view']?>&idx=<?=$_REQUEST['idx']?>" method="POST" >
                                                <select name="select" id="" style="width:114px;">
                                                  <option value="a.hero_id"<?if(!strcmp($_REQUEST['select'], 'a.hero_id')){echo ' selected';}else{echo '';}?>>추천받은사람 ID</option>
                                                  <option value="a.hero_nick"<?if(!strcmp($_REQUEST['select'], 'a.hero_nick')){echo ' selected';}else{echo '';}?>>추천받은사람 닉네임</option>
												  <option value="hero_all"<?if(!strcmp($_REQUEST['select'], 'hero_all')){echo ' selected';}else{echo '';}?>>아이디+닉네임</option>
                                                </select>
                                                <input name="kewyword" type="text" value="<?=$_REQUEST['kewyword'];?>" style="width:120px" class="kewyword">
                                                <span style="color: #999999;font-size: 9pt;font-weight: 800;margin-left: 10px;">월별 검색</span>
												<input type="text" id="default_widget" name='month' class="mtz-monthpicker-widgetcontainer" value='<?=$_POST['month']?>'>
                                                <input type="image" src="../image/bbs/btn_search.gif" alt="검색" class="bd0">
												<input type="button" value="초기화" alt="초기화" style="border: 1px solid #969696;border-radius: 10px;margin-left: 7px;padding: 1px 5px;color: white;font-size: 8pt;background-color: #A8A8A8;cursor:pointer" onclick='erase_month()' >
                                            </form>
                                            </div>
                                        </div>
                                        <div style="width:100%; text-align:center; margin-top:20px;"><? include_once PATH_INC_END.'page.php';?></div>
                                </tr>
                                <tr>
									<th width="5%">NO</th>
                                    <th width="30%">추천받은사람 ID</th>
                                    <th width="30%">추천받은사람 닉네임</th>
                                    <th width="30%">추천받은 합계</th>
                                </tr>
                            </thead>
                            <tbody>

<?
//SELECT a.*, b.* FROM point AS a LEFT JOIN ( SELECT * FROM member) AS b ON (a.hero_code = b.hero_code)
//SELECT a.*, b.* FROM point AS a LEFT JOIN ( SELECT * FROM member) AS b ON (a.hero_code = b.hero_code) where a.hero_type='member'
//$sql = 'select *, (select hero_id from member where a.hero_recommand=hero_code) As hero_reid, (select hero_name from member where a.hero_recommand=hero_code) As hero_rename, (select hero_nick from member where a.hero_recommand=hero_code) As hero_renick from point AS a where hero_type=\'member\' '.$search.$view_order.' limit '.$start.','.$list_page.';';
//hero_id,hero_name,hero_nick 
$sql = 'SELECT a.*,count(a.hero_id) AS user_count from point AS a LEFT JOIN member AS b ON a.hero_code = b.hero_code where a.hero_type=\'member\''.$search.$search_month.$view_order.' group by hero_id asc order by user_count desc limit '.$start.','.$list_page.';';

sql($sql);
while($roll_list                             = @mysql_fetch_assoc($out_sql)){
?>

                                <input type="hidden" name="hero_idx[]" value="<?=$roll_list['hero_idx']?>">
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
									<td><?=$j?></td>
                                    <td><?=$roll_list['hero_id']?></td>
                                    <td><?=$roll_list['hero_nick']?></td>
                                    <td><?=$roll_list['user_count']?></td>
                                    
                                </tr>
<?
$j--;
}
?>
                                </form>
                            </tbody>
                        </table>
