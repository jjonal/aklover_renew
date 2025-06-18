<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
$table = 'point';

//2014-06-09 검색어 추가
if(strcmp($_POST['kewyword'], '')){
	if($_POST['select']=='hero_all'){
		$search = ' and ( b.hero_id like \'%'.$_POST['kewyword'].'%\' or b.hero_name like \'%'.$_POST['kewyword'].'%\' or a.hero_id like \'%'.$_POST['kewyword'].'%\' or a.hero_name like \'%'.$_POST['kewyword'].'%\')';
		$search_next = '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
	}else{
		$search = ' and '.$_POST['select'].' like \'%'.$_POST['kewyword'].'%\'';
	    $search_next = '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
	}
}else if(strcmp($_GET['kewyword'], '')){
    if($_GET['select']=='hero_all'){
		$search = ' and ( hero_nick like \'%'.$_GET['kewyword'].'%\' or hero_name like \'%'.$_GET['kewyword'].'%\' or hero_id like \'%'.$_GET['kewyword'].'%\' or hero_level like \'%'.$_GET['kewyword'].'%\')';
		$search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
	}else{
		$search = ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
		$search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
	}
}

//$sql = 'select * from member where hero_level<=\''.$_SESSION['temp_level'].'\' '.$search.' ';
//$sql = 'SELECT a.*, b.hero_id AS hero_reid, b.hero_name AS hero_rename, b.hero_nick AS hero_renick FROM point AS a LEFT JOIN ( SELECT * FROM member) AS b ON (a.hero_code = b.hero_code) where a.hero_type=\'member\'';
$sql ="SELECT a.hero_code FROM point AS a LEFT JOIN member AS b ON a.hero_code = b.hero_code where a.hero_type='member'";
// 160929 쿼리수정
//$sql = "SELECT hero_code FROM member WHERE hero_user is not null and hero_user != ''";
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
<style>
.t_list{white-space:nowrap;}
.t_list td,tr,th{white-space:nowrap;}
</style>
                        <table class="t_list">
                            <thead>
                                <tr>
                                    <td colspan="6" align="center" style="padding:10px">
                                        <div class="searchbox" style="margin-top:20px;">
                                            <div class="wrap_1">
                                            <form action="<?=PATH_HOME?>?board=<?=$_REQUEST['board']?>&view=<?=$_REQUEST['view']?>&idx=<?=$_REQUEST['idx']?>" method="POST" >
                                                <select name="select" id="">
                                                  <option value="b.hero_id"<?if(!strcmp($_REQUEST['select'], 'b.hero_id')){echo ' selected';}else{echo '';}?>>가입자 아이디</option>
                                                  <option value="b.hero_name"<?if(!strcmp($_REQUEST['select'], 'b.hero_name')){echo ' selected';}else{echo '';}?>>가입자 닉네임</option>
                                                  <option value="a.hero_id"<?if(!strcmp($_REQUEST['select'], 'a.hero_id')){echo ' selected';}else{echo '';}?>>추천받은사람 ID</option>
                                                  <option value="a.hero_nick"<?if(!strcmp($_REQUEST['select'], 'a.hero_nick')){echo ' selected';}else{echo '';}?>>추천받은사람 닉네임</option>
                                                  <option value="hero_all"<?if(!strcmp($_REQUEST['select'], 'hero_all')){echo ' selected';}else{echo '';}?>>모든 아이디+닉네임</option>
                                                </select>
                                                <input name="kewyword" type="text" value="<?=$_REQUEST['kewyword'];?>" style="width:120px" class="kewyword">
                                                <input type="image" src="../image/bbs/btn_search.gif" alt="검색" class="bd0">
                                            </form>
                                            </div>
                                        </div>
                                        <div style="width:100%; text-align:center; margin-top:20px;"><? include_once PATH_INC_END.'page.php';?></div>
                                </tr>
                                <tr>
									<th width="3%">NO</th>
                                    <th width="12%">가입자 아이디</th>
                                    <th width="12%">가입자 닉네임</th>
                                    <th width="12%">추천받은사람 ID</th>
                                    <th width="12%">추천받은사람 닉네임</th>
                                    <th width="12%">획득포인트</th>
                                    <th width="12%">추천한시간</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form name="form_next" action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post" enctype="multipart/form-data"> 
                                <tr>
                                    <td colspan="7">
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
//$sql = 'SELECT a.*, b.hero_id AS hero_reid, b.hero_name AS hero_rename, b.hero_nick AS hero_renick FROM point AS a LEFT JOIN member AS b ON a.hero_code = b.hero_code where a.hero_recommand is not null and a.hero_type=\'member\''.$search.$view_order.' order by a.hero_today desc limit '.$start.','.$list_page.';';
//$sql = 'SELECT a.*, b.hero_id AS hero_reid, b.hero_name AS hero_rename, b.hero_nick AS hero_renick  FROM point a, member b where a.hero_recommand=b.hero_code and a.hero_recommand is not null and a.hero_type=\'member\''.$search.$view_order.' limit '.$start.','.$list_page.';';
//$sql = "select a.hero_code, a.hero_nick, a.hero_id, a.hero_user, (select hero_id as hero_reid from member where hero_id=a.hero_user),(select hero_nick as hero_renick from member where hero_id=a.hero_user),(select hero_code as hero_recode from member where hero_id=a.hero_user) from member a where hero_user is not null and hero_user != '' ".$search." limit ".$start.",".$list_page."";
$sql = "SELECT DISTINCT A.*, B.hero_id AS hero_reid, B.hero_name AS hero_rename, B.hero_nick AS hero_renick FROM point A LEFT OUTER JOIN member B on A.hero_recommand=B.hero_code where A.hero_recommand is not null and A.hero_type='member' ORDER BY A.hero_idx desc limit ".$start.",".$list_page."";
sql($sql);
echo $sql;
$i = '0';
while($roll_list                             = @mysql_fetch_assoc($out_sql)){
    $point = '0';
    $user_sql = 'select hero_point from point where hero_code=\''.$roll_list['hero_code'].'\';';//desc
    $user_sql = mysql_query($user_sql);
    while($total_list                             = @mysql_fetch_assoc($user_sql)){
        $point = $point+$total_list['hero_point'];
    }
?>

                                <input type="hidden" name="hero_idx[]" value="<?=$roll_list['hero_idx']?>">
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
									<td><?=$j?></td>
                                    <td><?=$roll_list['hero_reid']?></td>
                                    <td><?=$roll_list['hero_renick']?></td>
                                    <td><input type="text" id="hero_id[]" name="hero_id[]" value="<?=$roll_list['hero_id']?>" style="width:80px;height:20px;"></td>
                                    <td><?=$roll_list['hero_nick']?></td>
                                    <td><input type="text" id="hero_point[]" name="hero_point[]" value="<?=$roll_list['hero_point']?>" style="width:80px;height:20px;"></td>
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
