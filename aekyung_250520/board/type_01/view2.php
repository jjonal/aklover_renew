<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
//echo $_SESSION['temp_level'];
$today = date( "Y-m-d", time());
if(!strcmp($_SESSION['temp_drop'], '')){
}else{
    $temp_drop = $_SESSION['temp_drop'];
    if($temp_drop<=$today){
        $sql = 'UPDATE member SET hero_dropday=null, hero_level=\''.$_SESSION['temp_level'].'\', hero_write=\''.$_SESSION['temp_level'].'\', hero_view=\''.$_SESSION['temp_level'].'\', hero_update=\''.$_SESSION['temp_level'].'\', hero_rev=\''.$_SESSION['temp_level'].'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
        mysql_query($sql);
        $_SESSION['temp_write']=$_SESSION['temp_level'];
        $_SESSION['temp_view']=$_SESSION['temp_level'];
        $_SESSION['temp_update']=$_SESSION['temp_level'];
        $_SESSION['temp_rev']=$_SESSION['temp_level'];
        unset($_SESSION['temp_drop']);
    }else{
    }
}
######################################################################################################################################################
if(!strcmp($_SESSION['temp_level'], '')){
    $my_level = '0';
    $my_write = '0';
    $my_view = '0';
    $my_update = '0';
    $my_rev = '0';
}else{
    $my_level = $_SESSION['temp_level'];
    $my_write = $_SESSION['temp_write'];
    $my_view = $_SESSION['temp_view'];
    $my_update = $_SESSION['temp_update'];
    $my_rev = $_SESSION['temp_rev'];
}
######################################################################################################################################################
$cut_title_name = '26';
if(!strcmp($_GET['next_board'],"hero")){
    $hero_table = 'hero';
}else{
    $hero_table = $_GET['board'];
}

$sql = 'select * from board where hero_table = \''.$hero_table.'\' and hero_idx=\''.$_GET['idx'].'\';';
sql($sql, 'on');
    $out_row = @mysql_fetch_assoc($out_sql);//mysql_fetch_row
    $temp_hit = $out_row['hero_hit']+1;
$sql = 'select * from board where hero_notice=\'0\' and hero_table = \''.$hero_table.'\' and hero_idx > \''.$_GET['idx'].'\' order by hero_idx asc limit 0,1;';
sql($sql, 'on');
    $Prev = @mysql_fetch_assoc($out_sql);//mysql_fetch_row
    $Prev['hero_idx'];

$sql = 'select * from board where hero_notice=\'0\' and hero_table = \''.$hero_table.'\' and hero_idx < \''.$_GET['idx'].'\' order by hero_idx desc limit 0,1;';
sql($sql, 'on');
    $Next = @mysql_fetch_assoc($out_sql);//mysql_fetch_row
    $Next['hero_idx'];
######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);
//권한
//if( ( ($right_list['hero_view'] >= $_SESSION['temp_level']) and (strcmp($_SESSION['temp_level'], '')) ) or (!strcmp($right_list['hero_view'], '99')) ){
if($right_list['hero_view'] <= $my_view){
######################################################################################################################################################
$temp_id = $_SESSION['temp_id'];
$temp_code = $_SESSION['temp_code'];
$temp_top_title = $right_list['hero_title'];
$temp_title = $out_row['hero_title'];
$temp_point = $right_list['hero_view_point'];
$temp_idx = $_GET['idx'];
######################################################################################################################################################
if(!strcmp($temp_point, '')){
    $temp_point = '0';
}else{
    $temp_point = $temp_point;
}
if( (!strcmp($my_level, '0')) or (!strcmp($temp_point, '0')) ){
    //포인트는 없다
}else{
    $sql = 'select * from point where hero_table=\''.$_GET['board'].'\' and hero_code = \''.$temp_code.'\' and hero_type=\''.$_GET['view'].'\' and hero_old_idx=\''.$_GET['idx'].'\' order by hero_today desc limit 0,1;';
    sql($sql, 'on');
    $today_list                             = @mysql_fetch_assoc($out_sql);
    $last_day = date( "Ymd", strtotime($today_list['hero_today']));
    $to_day = date( "Ymd", time());
    if(!strcmp($to_day, $last_day)){
    }else{
        $member_sql = 'select * from member where hero_code=\''.$temp_code.'\'';
        $out_member = mysql_query($member_sql);
        $member_list                             = @mysql_fetch_assoc($out_member);
        $total_point = $member_list['hero_point'];
        $total = $total_point+$temp_point;

        $today_sql = 'select * from point where date(hero_today)=\''.date( "Y-m-d", time()).'\' and hero_code=\''.$temp_code.'\' and not hero_title="월출석개근";';
        $out_today_sql = mysql_query($today_sql);
        $today_total_point='0';
        while($today_today_list                             = @mysql_fetch_assoc($out_today_sql)){
            $today_total_point = $today_total_point + $today_today_list['hero_point'];
        }
        if(!strcmp($today_total_point,'')){
            $today_total_point = '0';
        }else{
            $today_total_point = $today_total_point;
        }
        $admin_today_sql = 'select * from today where hero_type=\'hero_total\'';
        $out_admin_today_sql = mysql_query($admin_today_sql);
        $admin_today_today_list                             = @mysql_fetch_assoc($out_admin_today_sql);
        if($admin_today_today_list['hero_point']>$today_total_point){
######################################################################################################################################################
            $level_sql = 'select * from level where hero_level!=\'0\' and hero_point_01<=\''.$total_point.'\' and hero_point_02>=\''.$total_point.'\'';
            $out_level = mysql_query($level_sql);
            $level_list                             = @mysql_fetch_assoc($out_level);
            $level_up_sql = 'select * from level_up';
            $out_level_up = mysql_query($level_up_sql);
            if($member_list['hero_level'] <= $level_list['hero_level']){
                while($level_up_list                             = @mysql_fetch_assoc($out_level_up)){
                    if(!strcmp($member_list['hero_level'], $level_up_list['hero_level'])){
                        $check_point_sql = 'select * from point where hero_table=\''.$level_up_list['hero_table'].'\' and hero_type=\''.$level_up_list['hero_type'].'\' and hero_code=\''.$temp_code.'\';';
                        $out_check_point_sql = mysql_query($check_point_sql);
                        $out_check_point_count = @mysql_num_rows($out_check_point_sql);
                        if($level_up_list['hero_number'] <= $out_check_point_count){
                            $level_up_ok = $level_up_ok+'0';
                        }else{
                            $level_up_ok = $level_up_ok+'1';
                        }
                    }else{
                        $level_up_ok = '0';
                    }
                }
                if(!strcmp($level_up_ok, '0')){
                    $sql_one_write = 'hero_old_idx, hero_code, hero_table, hero_type, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today';
                    $sql_two_write = '\''.$_GET['idx'].'\', \''.$temp_code.'\', \''.$_GET['board'].'\', \''.$_GET['view'].'\', \''.$temp_id.'\', \''.$temp_top_title.'\', \''.$temp_title.'\', \''.$_SESSION['temp_name'].'\', \''.$_SESSION['temp_nick'].'\', \''.$temp_point.'\', \''.Ymdhis.'\'';
                    $sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
                    mysql_query($sql);
                    if(!strcmp($_SESSION['temp_drop'], '')){
                        $user_level_up = $level_list['hero_level'];
                        $user_write_up = $level_list['hero_level'];
                        $user_view_up = $level_list['hero_level'];
                        $user_update_up = $level_list['hero_level'];
                        $user_rev_up = $level_list['hero_level'];
                    }else{
                        $user_level_up = $level_list['hero_level'];
                        $user_write_up = $my_write;
                        $user_view_up = $my_view;
                        $user_update_up = $my_update;
                        $user_rev_up = $my_rev;
                    }
                    $sql = 'UPDATE board SET hero_hit=\''.$temp_hit.'\' WHERE hero_idx = \''.$_GET['idx'].'\';'.PHP_EOL;
                    mysql_query($sql);
                    $temp_level_sql = 'select * from level where hero_level=\''.$user_level_up.'\'';
                    $out_temp_level = mysql_query($temp_level_sql);
                    $temp_level_list                             = @mysql_fetch_assoc($out_temp_level);
//                    $msg = '축하 합니다. 레벨 상승하셨습니다.\n 현재 등급은 : ['.$temp_level_list['hero_name'].']';
                    if($level_list['hero_level']>$_SESSION['temp_level']){
                        $msg = '축하 합니다. 레벨 상승하셨습니다.';
                        $sql = 'UPDATE member SET hero_level=\''.$user_level_up.'\', hero_write=\''.$user_write_up.'\', hero_view=\''.$user_view_up.'\', hero_update=\''.$user_update_up.'\', hero_rev=\''.$user_rev_up.'\', hero_point=\''.$total.'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
                        mysql_query($sql);
                        msg($msg,'');
                    }
                    $_SESSION['temp_level'] = $user_level_up;
                    $_SESSION['temp_write'] = $user_write_up;
                    $_SESSION['temp_view'] = $user_view_up;
                    $_SESSION['temp_update'] = $user_update_up;
                    $_SESSION['temp_rev'] = $user_rev_up;

                }else{
                    $sql_one_write = 'hero_old_idx, hero_code, hero_table, hero_type, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today';
                    $sql_two_write = '\''.$_GET['idx'].'\', \''.$temp_code.'\', \''.$_GET['board'].'\', \''.$_GET['view'].'\', \''.$temp_id.'\', \''.$temp_top_title.'\', \''.$temp_title.'\', \''.$_SESSION['temp_name'].'\', \''.$_SESSION['temp_nick'].'\', \''.$temp_point.'\', \''.Ymdhis.'\'';
                    $sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
                    mysql_query($sql);
                    $sql = 'UPDATE member SET hero_point=\''.$total.'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
                    mysql_query($sql);
                    $sql = 'UPDATE board SET hero_hit=\''.$temp_hit.'\' WHERE hero_idx = \''.$_GET['idx'].'\';'.PHP_EOL;
                    mysql_query($sql);
                }
            }else{
                $sql_one_write = 'hero_old_idx, hero_code, hero_table, hero_type, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today';
                $sql_two_write = '\''.$_GET['idx'].'\', \''.$temp_code.'\', \''.$_GET['board'].'\', \''.$_GET['view'].'\', \''.$temp_id.'\', \''.$temp_top_title.'\', \''.$temp_title.'\', \''.$_SESSION['temp_name'].'\', \''.$_SESSION['temp_nick'].'\', \''.$temp_point.'\', \''.Ymdhis.'\'';
                $sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
                mysql_query($sql);
                $sql = 'UPDATE member SET hero_point=\''.$total.'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
                mysql_query($sql);
                $sql = 'UPDATE board SET hero_hit=\''.$temp_hit.'\' WHERE hero_idx = \''.$_GET['idx'].'\';'.PHP_EOL;
                mysql_query($sql);
            }
######################################################################################################################################################
        }else{
            $sql_one_write = 'hero_old_idx, hero_code, hero_table, hero_type, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today';
            $sql_two_write = '\''.$_GET['idx'].'\', \''.$temp_code.'\', \''.$_GET['board'].'\', \''.$_GET['view'].'\', \''.$temp_id.'\', \''.$temp_top_title.'\', \''.$temp_title.'(당일 포인트 초과)\', \''.$_SESSION['temp_name'].'\', \''.$_SESSION['temp_nick'].'\', \'0\', \''.Ymdhis.'\'';
//            $sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
//            mysql_query($sql);
        }
######################################################################################################################################################
    }
}
$hit_sql = 'select * from board where hero_table = \''.$hero_table.'\' and hero_idx=\''.$_GET['idx'].'\';';
$out_hit_sql = mysql_query($hit_sql);
$hit_row = @mysql_fetch_assoc($out_hit_sql);
?>

        <div class="contents">
            <table border="0" cellpadding="0" cellspacing="0" class="bbs_view">
                <colgroup>
                    <col width="90px" />
                    <col width="400px" />
                    <col width="100px" />
                    <col width="105px" />
                </colgroup>
                <tr class="bbshead">
                    <th><img src="../image/bbs/tit_subject.gif" alt="제목" /></th>
                    <td>
<?
if(!strcmp($out_row['hero_table'],'hero')){
?>
                        <img src="../image/bbs/icon_notice.gif" alt="공지" />
<?
}
?>
                        <?=cut($out_row['hero_title'],50);?>
                    </td>
                    <th>
                    </th>
                    <td>
<? 
	$sub = $out_row['hero_title'];
//    $link = '?board='.$out_row['hero_table'].'&page='.$_GET['page'].'&view='.$_GET['view'].'&idx='.$_GET['idx'];
	//$sub1 = urlencode(iconv('utf-8','utf-8',$sub));
	//밑에 head태그는 SNS링크공유로 가져가기 위함이다.
echo    $link = PATH_HOME.'?board='.$out_row['hero_table'].'&page='.$_GET['page'].'&view='.$_GET['view'].'&idx='.$_GET['idx'];
?>
<head>
<title><?=$sub?></title>
<meta property="og:type" content="website" /> 
<meta property="og:title" content="<?=$sub?>" /> 
<meta property="og:image" content="http://aklover.co.kr/image/common/logo.gif" /> 
<meta property="og:description" content="<?=$sub?>" /> 
<meta property="og:site_name" content="<?=$link?>" /> 
<meta property="og:url" content="<?=$link?>" /> 
<meta name="og:image" content="http://aklover.co.kr/image/common/logo.gif" />
</head>

			    <dd class="sns">
					<a href="javascript:open0('<?=$link?>');"><img src="../image/news/ico_fc.jpg" alt="페이스북공유"></a>
					<a href="javascript:open1('<?=$sub?>','<?=$link?>');"><img src="../image/news/ico_tw.jpg" alt="트위터공유"></a>
					<a href="javascript:open2('<?=$sub?>','<?=$link?>');"><img src="../image/news/ico_me.jpg" alt="미투데이공유"></a>
			    </dd>

<script>

/* SNS 링크공유 */
function open0(link){
	var link1 = encodeURIComponent(link);
	window.open('http://www.facebook.com/sharer/sharer.php?u='+link1,'','width=520 height=400 scrollbars=no');
}
function open1(sub, link){
	var sub1 = encodeURIComponent(sub);
	var link1 = encodeURIComponent(link);
	window.open('http://twitter.com/home?status='+sub1+' '+link1,'','width=520 height=400 scrollbars=y');
}
function open2(sub, link){
	var sub1 = encodeURIComponent(sub);
	var link1 = encodeURIComponent(link);
	window.open('http://plugin.me2day.net/v1/me2post/create_post_form.nhn?body='+sub1+' '+link1,'','width=520 height=400 scrollbars=no');
}
var copytoclip=1

function HighlightAll(theField) {
var tempval=eval("document."+theField)
//tempval.focus()
//tempval.select()
if (document.all&&copytoclip==1){
therange=tempval.createTextRange()
therange.execCommand("Copy")
window.status="문장을 선택하셨나요? 복사해가세요!"
setTimeout("window.status=''",1800)
}
}
</script><a href="javascript:HighlightAll('test.select1')">전체선택</a>
                    </td>
                </tr>
                <tr>
                    <th><img src="../image/bbs/tit_writer.gif" alt="작성자" /></th>
                    <td><?=$out_row['hero_nick'];?></td>
                    <th><img src="../image/bbs/tit_date.gif" alt="날짜" /></th>
                    <td><?=date( "y-m-d", strtotime($out_row['hero_today']));?></td>
                </tr>
                <tr>
                    <td colspan="4" valign="top" width="705px"  class="bbs_view" style="padding:10px;line-height:14px; word-break:break-all;">
<form name="test">
                    <div id="select1" name="select1"><?=htmlspecialchars_decode($out_row['hero_command']);?></div></td><!--677-->
</form>
                </tr>
<?if(strcmp($out_row['hero_board_two'], '')){?>
                <tr>
                    <th><center>파일</center></th>
                    <td colspan="3"><a href="<?=FREEBEST_END?>download.php?hero=<?=$out_row['hero_board_one']?>&download=<?=$out_row['hero_board_two']?>" ><?=$out_row['hero_board_two'];?></td><!--677-->
                </tr>
<?}?>
<?
if(strcmp($Prev['hero_idx'], '')){
?>
                <tr>
                    <th><img src="../image/bbs/tit_prev.gif" alt="이전글" /></th>
                    <td colspan="3"><a href="<?=PATH_HOME;?>?board=<?=$_GET['board'];?>&page=<?=$_GET['page'];?>&view=view&idx=<?=$Prev['hero_idx'];?>"><?=cut($Prev['hero_title'],$cut_title_name);?></a></td>
                </tr>
<?
}
if(strcmp($Next['hero_idx'], '')){
?>
                <tr class="last">
                    <th><img src="../image/bbs/tit_next.gif" alt="다음글" /></th>
                    <td colspan="3"><a href="<?=PATH_HOME;?>?board=<?=$_GET['board'];?>&page=<?=$_GET['page'];?>&view=view&idx=<?=$Next['hero_idx'];?>"><?=cut($Next['hero_title'],$cut_title_name);?></a></td>
                </tr>
<?
}
?>
            </table>
<?
    include_once BOARD_INC_END.'button.php';
$check_review_sql = 'select * from hero_group where hero_board=\''.$_GET['board'].'\';';
$out_check_review_sql = mysql_query($check_review_sql);
$check_review_list                             = @mysql_fetch_assoc($out_check_review_sql);
$check_review_list['hero_rev'];
if($check_review_list['hero_rev']<=$my_rev){
    include_once BOARD_INC_END.'review.php';
}
?>
        </div>
    </div>
<?
}else{
        $msg = '권한이';
        $action_href = PATH_HOME.'?'.get('view');
        msg($msg.' 없습니다.','location.href="'.$action_href.'"');
    exit;
}
?>