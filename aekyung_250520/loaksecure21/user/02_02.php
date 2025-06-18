<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
//border:1px solid #000000;
######################################################################################################################################################
$sql = 'select * from member where hero_idx=\''.$_GET['next_idx'].'\';';//desc
sql($sql);
$check_list                             = @mysql_fetch_assoc($out_sql);
$view_point = $check_list['hero_point'];
$user_level = $check_list['hero_level'];
/*
if(!strcmp($check_list['hero_point'],"")){
    $view_point = '0';
}else{
    $view_point = $check_list['hero_point'];
}
*/
if( (!strcmp($_GET['type'],"edit")) and (strcmp($_POST['hero_point'],'')) and (strcmp($_POST['hero_point'],'0')) ){
//160523 삭제
/*     $data_i = '1';
    $count = @count($_POST);
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
        $sql_one .= $post_key.$comma;
        $sql_two .= '\''.$_POST[$post_key].'\''.$comma;
    $data_i++;
    }
$join_point = $check_list['hero_point']+$_POST['hero_point'];
$level_sql = 'select * from level where hero_level!=\'0\' and hero_point_01<=\''.$join_point.'\' and hero_point_02>=\''.$join_point.'\'';
$out_level = mysql_query($level_sql);
$level_list                             = @mysql_fetch_assoc($out_level);
if($user_level >= $level_list['hero_level']){
    $user_temp_level = $user_level;
}else{
    $user_temp_level = $level_list['hero_level'];
}
$sql_one_update = 'hero_point=\''.$join_point.'\', hero_level=\''.$level_list['hero_level'].'\'';
//$sql = 'UPDATE member SET '.$sql_one_update.' WHERE hero_idx = \''.$_GET['next_idx'].'\';'.PHP_EOL;
//mysql_query($sql);
$sql = 'INSERT INTO point ('.$sql_one.') VALUES ('.$sql_two.');';
mysql_query($sql); */

//160523 추가
$point_rs = adminPoint($check_list['hero_code'], $_GET['board'], 'personPoint', 0, 0, 0, $check_list['hero_id'], $_POST['hero_title'], $check_list['hero_name'], $check_list['hero_nick'], $_POST['hero_point'], 'N', '');

msg('추가 되었습니다.','location.href="'.PATH_HOME.'?'.get('type','').'"');
EXIT;
}
$level_sql = 'select * from level where hero_level='.$check_list['hero_level'].' order by hero_level desc;';//desc<=
$out_level_sql = mysql_query($level_sql);
$level_list                             = @mysql_fetch_assoc($out_level_sql);

if(!strcmp($_GET['type'], 'edit2')){
    $post_count = @count($_POST['hero_idx']);
    for($i=0;$i<$post_count;$i++){
        reset($_POST);
        unset($sql_one_update);
        $idx = $_POST['hero_idx'][$i];
        $hero_point = $_POST['hero_point'][$i];
        $data_i = '1';
        $count = @count($_POST);
        /* while(list($post_key, $post_val) = each($_POST)){
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
        } */
        
        //160523 추가
        adminPointModi($idx, $hero_point);
        
        /* $sql = 'UPDATE point SET '.$sql_one_update.' WHERE hero_idx = \''.$idx.'\';'.PHP_EOL;
        mysql_query($sql); */
    }

/*     $sql = 'select hero_point from point where hero_code=\''.$check_list['hero_code'].'\';';//desc

    sql($sql);
    $point='0';
    while($total_list                             = @mysql_fetch_assoc($out_sql)){
        $point = $point+$total_list['hero_point'];
    }
    if(!strcmp($point,"")){
        $view_point = '0';
    }else{
        $view_point = $point;
    }
    $sql = 'UPDATE member SET hero_point=\''.$view_point.'\' WHERE hero_code = \''.$check_list['hero_code'].'\';'.PHP_EOL;
    mysql_query($sql); */
    msg('수정 되었습니다.','location.href="'.PATH_HOME.'?'.get('type','').'"');
    exit;
}
if(!strcmp($_GET['type'], 'drop')){
	// 관리자가 포인트내역을 삭제하는거라 DELETE
    $sql = 'select hero_point from point where hero_code=\''.$check_list['hero_code'].'\';';//desc
    sql($sql);
    $point='0';
    while($total_list                             = @mysql_fetch_assoc($out_sql)){
        $point = $point+$total_list['hero_point'];
    }
    $point_get = (int)$_GET['point'];
    $view_point = $point-$point_get;
    $sql = 'UPDATE member SET hero_point=\''.$view_point.'\' WHERE hero_code = \''.$check_list['hero_code'].'\';'.PHP_EOL;
    mysql_query($sql);
    $sql = 'DELETE FROM point WHERE hero_idx = \''.$_GET['hero_idx'].'\';';
    mysql_query($sql); 
    msg('삭제 되었습니다.','location.href="'.PATH_HOME.'?'.get('type||page','').'"');
    exit;
}
/*
어제
echo $ydate=date("Y-m-d", time()-86400);
echo date("Ymd",strtotime("-1 day"));
*/
$pk_d = date("Y-m-d", strtotime("-1 day", time()));
$pk_today = $pk_d.' '.His;
?>
                        <table width="100%">
                            <tr>
                                <td align="center">
                                    <b> [ <font color="blue"><?=$check_list['hero_id'];?></font> ] </b>님 총 획득 Point는
                                    <font color="red"><b><?=$view_point;?></b></font> * 참고 : 포인트 추가는 어제날자로 입력됩니다.
                                </td>
                            </tr>
                        </table>
                        <table class="t_list">
                            <thead>
                                <tr>
                                    <th width="10%">아이디</th>
                                    <th width="10%">성 명</th>
                                    <th width="30%">제목</th>
                                    <th width="20%">포인트</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form name="form_next" action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post" enctype="multipart/form-data"> 
                                <input type="hidden" name="hero_code" value="<?=$check_list['hero_code']?>">
                                <input type="hidden" name="hero_id" value="<?=$check_list['hero_id']?>">
                                <input type="hidden" name="hero_name" value="<?=$check_list['hero_name']?>">
                                <input type="hidden" name="hero_today" value="<?=$pk_today?>">
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
                                    <td><?=$check_list['hero_id'];?></td>
                                    <td><?=$check_list['hero_name'];?></td>
                                    <td><input type="text" name="hero_title" value="" style="width:300px;text-align:center;"></td>
                                    <td><input type="text" name="hero_point" value="" style="width:200px;text-align:center;"></td>
                                </tr>
                            </tbody>
                        </table><br>
                        <table width="100%">
                            <tr>
                                <td>
                                    <a href="javascript:go_list();" class="btn_blue2">목록</a>
                                </td>
                                <td>
                                    <a href="javascript:form_next.submit();" class="btn_blue2">포인트 추가</a>
                                </td>
                            </tr>
                            </form>
                        </table>
                        <script>
                            function go_list(){
                                location.href = "./index.php?board=<?=$_GET['board']?>&idx=<?=$_GET['idx']?>&page=<?=$_GET['next_page']?>";
                            }
                        </script>
                        <table class="t_list">
                            <thead>
                                <tr>
                                    <th width="8%"><a href="<?=PATH_HOME.'?'.get('order','order=hero_id asc');?>">▼</a> 아이디 <a href="<?=PATH_HOME.'?'.get('order','order=hero_id desc');?>">▲</a></th>
                                    <th width="8%"><a href="<?=PATH_HOME.'?'.get('order','order=hero_name asc');?>">▼</a> 성 명 <a href="<?=PATH_HOME.'?'.get('order','order=hero_name desc');?>">▲</a></th>
                                    <th width="20%"><a href="<?=PATH_HOME.'?'.get('order','order=hero_top_title asc');?>">▼</a> 카테고리 <a href="<?=PATH_HOME.'?'.get('order','order=hero_top_title desc');?>">▲</a></th>
                                    <th width="*"><a href="<?=PATH_HOME.'?'.get('order','order=hero_title asc');?>">▼</a> 제 목 <a href="<?=PATH_HOME.'?'.get('order','order=hero_title desc');?>">▲</a></th>
                                    <th width="10%">[참고용]</th>
                                    <th width="8%">포인트</th>
                                    <th width="5%">타입</th>
                                    <th width="8%"><a href="<?=PATH_HOME.'?'.get('order','order=hero_today asc');?>">▼</a> 기간 <a href="<?=PATH_HOME.'?'.get('order','order=hero_today desc');?>">▲</a></th>
                                    <th width="8%">설정</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form name="form_next2" action="<?=PATH_HOME.'?'.get('','type=edit2');?>" method="post" enctype="multipart/form-data"> 
<?
######################################################################################################################################################
if(strcmp($_POST['kewyword'], '')){
    $search = ' and '.$_POST['select'].' like \'%'.$_POST['kewyword'].'%\'';
    $search_next = '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
}else if(strcmp($_GET['kewyword'], '')){
    $search = ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
    $search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
}
if(!strcmp($_GET['order'], '')){
    $view_order = 'order by hero_today desc';
}else{
    $view_order = ' order by '.$_GET['order'];
}
######################################################################################################################################################
$sql = 'select * from point where hero_code=\''.$check_list['hero_code'].'\' '.$search.' ';
sql($sql);
$total_data = @mysql_num_rows($out_sql);
######################################################################################################################################################
$list_page=10;
$page_per_list=10;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board'].'&view='.$_GET['view'].$search_next.'&idx='.$_GET['idx'].'&next_idx='.$_GET['next_idx'];
######################################################################################################################################################
$sql = 'select * from point where hero_code=\''.$check_list['hero_code'].'\''.$search.$view_order.' limit '.$start.','.$list_page.';';
//$sql = 'select * from point where hero_code=\''.$check_list['hero_code'].'\';';//desc
sql($sql);
while($list                             = @mysql_fetch_assoc($out_sql)){
?>
                                <input type="hidden" name="hero_idx[]" value="<?=$list['hero_idx']?>">
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
                                    <td><?=$check_list['hero_id'];?></td>
                                    <td><?=$check_list['hero_name'];?></td>
                                    <td><input type="text" name="hero_top_title[]" value="<?=$list['hero_top_title']?>" style="width:90%;text-align:center;"></td>
                                    <td><input type="text" name="hero_title[]" value="<?=$list['hero_title']?>" style="width:90%;text-align:center;"></td>
                                    <td><?=$list['hero_old_idx']?></td>
                                    <td><input type="text" name="hero_point[]" value="<?=$list['hero_point']?>" style="width:80px;text-align:center;"></td>
                                    <td><?=$list['hero_type']?></td>
                                    <td><?=date( "Y-m-d", strtotime($list['hero_today']));?></td>
                                    <td>
                                        <a href="<?=PATH_HOME.'?'.get('','type=drop&point='.$list['hero_point'].'&hero_idx='.$list['hero_idx']);?>" class="btn_blue2">삭제</a>
                                    </td>
                                </tr>
<?
}
?>
                            </tbody>
                        </table>
                        <table width="100%">
                            <tr>
                                <td>
                                    <a href="javascript:go_list();" class="btn_blue2">목록</a>
                                </td>
<?if(!strcmp($_SESSION['temp_level'], '9999')){?>
                                <td>
                                    <a href="javascript:form_next2.submit();" class="btn_blue2">설정수정</a>
                                </td>
<?}?>
                            </tr>
                            </form>
                        </table>
                        <div style="width:100%; text-align:center; margin-top:20px;">
<? include_once PATH_INC_END.'page.php';?>
                        </div>
                        <div class="searchbox" style="margin-top:20px;">
                            <div class="wrap_1">
                            <form action="<?=PATH_HOME.'?'.get('page');?>" method="POST" >
                                <select name="select" id="">
                                  <option value="hero_title"<?if(!strcmp($_REQUEST['select'], 'hero_title')){echo ' selected';}else{echo '';}?>>제목</option>
                                  <option value="hero_point"<?if(!strcmp($_REQUEST['select'], 'hero_point')){echo ' selected';}else{echo '';}?>>포인트</option>
                                </select>
                                <input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];?>" class="kewyword">
                                <input type="image" src="../image/bbs/btn_search.gif" alt="검색" class="bd0">
                            </form>
                            </div>
                        </div>
