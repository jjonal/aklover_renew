<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
$table = 'point';

if($_POST['order']){
	$order = $_POST['order'];
	$order = explode('-',$order);
	$order = "hero_".$order[0]." ".$order[1];

}else{
	$order = "hero_today desc";
}


//2014-06-09 검색어 추가
//2016-09-29 검색어 수정

if(strcmp($_POST['keyword'], '')){
	if($_POST['select'] == '1'){
		$search = " AND hero_id like '%".$_POST['keyword']."%'";
	    $search_next = '&select='.$_POST['select'].'&keyword='.$_POST['keyword'];
	}else if($_POST['select'] == '2') {
		$search = " AND hero_nick like '%".$_POST['keyword']."%'";
	    $search_next = '&select='.$_POST['select'].'&keyword='.$_POST['keyword'];
	}else if($_POST['select'] == '3') {
		$search_02 = " AND hero_id like '%".$_POST['keyword']."%'";
	    $search_next = '&select='.$_POST['select'].'&keyword='.$_POST['keyword'];
	}else if($_POST['select'] == '4') {
		$search_02 = " AND hero_nick like '%".$_POST['keyword']."%'";
	    $search_next = '&select='.$_POST['select'].'&keyword='.$_POST['keyword'];
	}
}else if(strcmp($_GET['keyword'], '')){
	if($_GET['select'] == '1'){
		$search = " AND hero_id like '%".$_GET['keyword']."%'";
	    $search_next = '&select='.$_GET['select'].'&keyword='.$_GET['keyword'];
	}else if($_GET['select'] == '2') {
		$search = " AND hero_nick like '%".$_GET['keyword']."%'";
	    $search_next = '&select='.$_GET['select'].'&keyword='.$_GET['keyword'];
	}else if($_GET['select'] == '3') {
		$search_02 = " AND hero_id like '%".$_GET['keyword']."%'";
	    $search_next = '&select='.$_GET['select'].'&keyword='.$_GET['keyword'];
	}else if($_GET['select'] == '4') {
		$search_02 = " AND hero_nick like '%".$_GET['keyword']."%'";
	    $search_next = '&select='.$_GET['select'].'&keyword='.$_GET['keyword'];
	}
}
if($_REQUEST['hero_today_start'] && $_REQUEST['hero_today_end']){
	$search .= "and date_format(hero_oldday,'%Y-%m-%d') between '".$_REQUEST['hero_today_start']."' and '".$_REQUEST['hero_today_end']."' ";
	$search_next .= "&hero_today_start=".$_REQUEST['hero_today_start']."&hero_today_end=".$_REQUEST['hero_today_end'];
}


//$sql = 'select * from member where hero_level<=\''.$_SESSION['temp_level'].'\' '.$search.' ';
//$sql = 'SELECT a.*, b.hero_id AS hero_reid, b.hero_name AS hero_rename, b.hero_nick AS hero_renick FROM point AS a LEFT JOIN ( SELECT * FROM member) AS b ON (a.hero_code = b.hero_code) where a.hero_type=\'member\'';
//$sql ="SELECT a.hero_code FROM point AS a LEFT JOIN member AS b ON a.hero_code = b.hero_code where a.hero_type='member'";

// 160929 쿼리수정
$sql = "SELECT hero_code FROM member WHERE hero_user is not null and hero_user != '' ".$search."";
sql($sql);
$total_data = @mysql_num_rows($out_sql);
$list_page=50;
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

if(!strcmp($_GET['type'], 'edit')){
    $post_count = @count($_POST['hero_idx']);
    for($i=0;$i<$post_count;$i++){
        reset($_POST);
        unset($sql_one_update);
        $idx = $_POST['hero_idx'][$i];
        $data_i = '1';
        $count = @count($_POST);

        $user_sql = "select * from member where hero_id='".$_REQUEST['hero_id'][$i]."'";
        $out_user_sql = @mysql_query($user_sql);
        $user_count = @mysql_num_rows($out_user_sql);
        $user_list                             = @mysql_fetch_assoc($out_user_sql);
        if( (!strcmp($user_count, '')) or (!strcmp($user_count, '0')) ){
        }else{
            while(list($post_key, $post_val) = each($_POST)){
               if(!strcmp($post_key, 'hero_idx')){
                    $data_i++;
                    continue;
                }
                if(!strcmp($count, $data_i)){
                    $comma = '';
                }else{
                    $comma = ', ';
                }
                $sql_one_update .= $post_key.'=\''.$_POST[$post_key][$i].'\''.$comma;
            $data_i++;
            }
            $old_check_sql = "select * from point where hero_idx='".$idx."'";
            $out_old_check_sql = @mysql_query($old_check_sql);
            $old_check_list                             = @mysql_fetch_assoc($out_old_check_sql);

            $sql_one_update .= ', hero_code=\''.$user_list['hero_code'].'\', hero_id=\''.$user_list['hero_id'].'\', hero_name=\''.$user_list['hero_name'].'\', hero_nick=\''.$user_list['hero_nick'].'\'';
            $sql = 'UPDATE '.$table.' SET '.$sql_one_update.' WHERE hero_idx = \''.$idx.'\';'.PHP_EOL;
            @mysql_query($sql);
            $check_sql = "select * from point where hero_idx='".$idx."'";
            $out_check_sql = @mysql_query($check_sql);
            $check_list                             = @mysql_fetch_assoc($out_check_sql);

            $up_member_sql = 'UPDATE member SET hero_user=\''.$user_list['hero_id'].'\' WHERE hero_code = \''.$check_list['hero_recommand'].'\';'.PHP_EOL;
            @mysql_query($up_member_sql);

            if(!strcmp($old_check_list['hero_code'],$check_list['hero_code'])){
                $member_total_sql = 'select SUM(hero_point) as member_total from point where hero_code=\''.$check_list['hero_code'].'\';';
                $out_member_total_sql = @mysql_query($member_total_sql);
                $member_total_list                             = @mysql_fetch_assoc($out_member_total_sql);
                $member_total_point = $member_total_list['member_total'];
                $sql = 'UPDATE member SET hero_point=\''.$member_total_point.'\' WHERE hero_code = \''.$check_list['hero_code'].'\';'.PHP_EOL;
                @mysql_query($sql);
            }else{
                $member_total_sql = 'select SUM(hero_point) as member_total from point where hero_code=\''.$old_check_list['hero_code'].'\';';
                $out_member_total_sql = @mysql_query($member_total_sql);
                $member_total_list                             = @mysql_fetch_assoc($out_member_total_sql);
                $member_total_point = $member_total_list['member_total'];
                $sql = 'UPDATE member SET hero_point=\''.$member_total_point.'\' WHERE hero_code = \''.$old_check_list['hero_code'].'\';'.PHP_EOL;
                @mysql_query($sql);
                $member_total_sql = 'select SUM(hero_point) as member_total from point where hero_code=\''.$check_list['hero_code'].'\';';
                $out_member_total_sql = @mysql_query($member_total_sql);
                $member_total_list                             = @mysql_fetch_assoc($out_member_total_sql);
                $member_total_point = $member_total_list['member_total'];
                $sql = 'UPDATE member SET hero_point=\''.$member_total_point.'\' WHERE hero_code = \''.$check_list['hero_code'].'\';'.PHP_EOL;
                @mysql_query($sql);
            }
        }
    }
    msg('수정 되었습니다.','location.href="'.PATH_HOME.'?'.get('type','').'"');
    exit;

}
?>
<script type="text/javascript" src="<?=JS_END;?>jquery.min.js"></script>
<script type="text/javascript" src="<?=JS_END;?>head.js"></script>
<link type='text/css' href='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.css' rel='stylesheet' />
<script type="text/javascript" src="<?=DOMAIN_END?>cal/jquery.min.js"></script>
<script type='text/javascript' src='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.min.js'></script> 

<script>
function ch_order(order){
	if(order!='')		$('#order').val(order);
	$('#form1').submit();
}
$(function() {      // window.onload 대신 쓰는 스크립트
	dateclick2();
});
function dateclick2(){
	var dates = $("#sdate1, #edate1").datepicker({
		monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
		dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
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
<style>
.t_list{white-space:nowrap;}
.t_list td,tr,th{white-space:nowrap;}
</style>
                        <table class="t_list">
                            <thead>
                                <tr>
                                    <td colspan="6" align="center" style="padding:10px">
                                        <div class="searchbox" style="margin-top:20px;height:80px;">
                                            <div class="wrap_1">
                                            <form action="<?=PATH_HOME?>?board=<?=$_REQUEST['board']?>&view=<?=$_REQUEST['view']?>&idx=<?=$_REQUEST['idx']?>" method="POST" id="form1" >
                                            	<input type="hidden" name="order" id="order" value=""/>
                                                <select name="select" id="">
                                                  <option value="1"<?if(!strcmp($_REQUEST['select'], '1')){echo ' selected';}else{echo '';}?>>가입자 아이디</option>
                                                  <option value="2"<?if(!strcmp($_REQUEST['select'], '2')){echo ' selected';}else{echo '';}?>>가입자 닉네임</option>
                                                  <!--<option value="3"<?if(!strcmp($_REQUEST['select'], '3')){echo ' selected';}else{echo '';}?>>추천받은사람 ID</option>-->
                                                  <!--<option value="4"<?if(!strcmp($_REQUEST['select'], '4')){echo ' selected';}else{echo '';}?>>추천받은사람 닉네임</option>-->
                                                  <!--<option value="hero_all"<?if(!strcmp($_REQUEST['select'], 'hero_all')){echo ' selected';}else{echo '';}?>>모든 아이디+닉네임</option>-->
                                                </select>
                                                <input name="keyword" type="text" value="<?=$_REQUEST['keyword'];?>" style="width:120px" class="kewyword">
                                                <input type="image" src="../image/bbs/btn_search.gif" alt="검색" class="bd0">
                                                
                                                <br/>
                                                <input type="text"  id="sdate1" name="hero_today_start"  value="<?=$_REQUEST['hero_today_start']?>" style="text-align: center"  readonly/> ~ 
						                		<input type="text"  id="edate1" name="hero_today_end"  value="<?=$_REQUEST['hero_today_end']?>" style="text-align: center"  readonly/>
                                            </form>
                                            </div>
                                        </div>
                                        <div style="width:100%; text-align:center; margin-top:20px;"><? include_once PATH_INC_END.'page.php';?></div>
                                </tr>
                                <tr>
									<th width="3%">NO</th>
                                    <th width="12%">가입자 아이디</th>
                                    <th width="12%">가입자 닉네임</th>
                                    <th width="12%">추천인 입력 내용</th>
                                    <th width="12%">추천받은사람 ID</th>
                                    <th width="12%">추천받은사람 닉네임</th>
                                    <th width="8%">획득포인트</th>
                                    <th width="12%"><a href="javascript:ch_order('today-desc')">▼</a>추천한시간<a href="javascript:ch_order('today-asc')">▲</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <form name="form_next" action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post" enctype="multipart/form-data"> 
                                <tr>
                                    <td colspan="8">
                                        <a href="javascript:form_next.submit();" class="btn_blue2">설정수정</a><br>
                                        <font color="red"><b>설정수정</b></font> 클릭시 현재 보여지는 페이지는 한번에 수정됩니다<br>
                                        <font color="red">추천받을 사람ID가 없으면 수정이 안됩니다.</font>
                                        <br>

                                    </td>
                                </tr>

<?
//SELECT a.*, b.* FROM point AS a LEFT JOIN ( SELECT * FROM member) AS b ON (a.hero_code = b.hero_code)
//SELECT a.*, b.* FROM point AS a LEFT JOIN ( SELECT * FROM member) AS b ON (a.hero_code = b.hero_code) where a.hero_type='member'
//$sql = 'select *, (select hero_id from member where a.hero_recommand=hero_code) As hero_reid, (select hero_name from member where a.hero_recommand=hero_code) As hero_rename, (select hero_nick from member where a.hero_recommand=hero_code) As hero_renick from point AS a where hero_type=\'member\' '.$search.$view_order.' limit '.$start.','.$list_page.';';
//hero_id,hero_name,hero_nick 
//$sql = 'SELECT a.*, b.hero_id AS hero_reid, b.hero_name AS hero_rename, b.hero_nick AS hero_renick FROM point AS a LEFT JOIN ( SELECT * FROM member) AS b ON (a.hero_recommand = b.hero_code) where a.hero_type=\'member\''.$search.$view_order.' order by hero_id limit '.$start.','.$list_page.';';

//160929 쿼리수정
$sql = "select hero_code, hero_id as hero_reid, hero_name, hero_nick as hero_renick, hero_user, hero_oldday as hero_today from member where hero_user is not null and hero_user!='' ".$search."";
$sql .= "order by ".$order." limit ".$start.",".$list_page."";
//echo $sql;
sql($sql);


$i = '0';
while($roll_list                             = @mysql_fetch_assoc($out_sql)){
	// 160929 쿼리수정하면서 추가
	$member = "";
	$nick = "";
	$id = "";
	$point = "";
	
	$member_sql = "select hero_code,hero_id, hero_nick from member where (hero_id='".$roll_list['hero_user']."' or hero_nick='".$roll_list['hero_user']."' ".$search_02.")";
    $member_sql = mysql_query($member_sql);
	while($member_list= @mysql_fetch_assoc($member_sql)) {
		$member = $member_list['hero_code'];
		$nick = $member_list['hero_nick'];
		$id = $member_list['hero_id'];
	}
	
    $user_sql = "select hero_point from point where hero_code='".$member."' and hero_type='member' and hero_recommand is not null";
    $user_sql = mysql_query($user_sql);
    while($total_list                             = @mysql_fetch_assoc($user_sql)){
        $point = $total_list['hero_point'];
	}
?>

                                <input type="hidden" name="hero_idx[]" value="<?=$roll_list['hero_idx']?>">
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
									<td><?=$j?></td>
                                    <td><?=$roll_list['hero_reid']?></td>
                                    <td><?=$roll_list['hero_renick']?></td>
                                    <td><?=$roll_list['hero_user']?></td>
                                    <td><input type="text" id="hero_id[]" name="hero_id[]" value="<?=$id?>" style="width:80px;height:20px;"></td>
                                    <td><?=$nick?></td>
                                    <td><input type="text" id="hero_point[]" name="hero_point[]" value="<?=$point?>" style="width:80px;height:20px;"></td>
                                    <td><?=$roll_list['hero_today']?></td>
                                </tr>   
<?
$i++;
$j--;
	
}
?>
                                </form>
                            </tbody>
                        </table>
