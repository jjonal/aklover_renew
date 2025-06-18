<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
//border:1px solid #000000;
######################################################################################################################################################
$sql = 'select * from member where hero_use=\'0\' and hero_idx=\''.$_GET['next_idx'].'\';';//desc
sql($sql);
$check_list                             = @mysql_fetch_assoc($out_sql);

$level_sql = 'select * from level where hero_use=\'0\' and hero_level='.$check_list['hero_level'].' order by hero_level desc;';//desc<=
$out_level_sql = mysql_query($level_sql);
$level_list                             = @mysql_fetch_assoc($out_level_sql);
?>

<?
if(!strcmp($_GET['type'], 'edit')){
    $post_count = @count($_POST['hero_idx']);
    for($i=0;$i<$post_count;$i++){
        reset($_POST);
        unset($sql_one_update);
        $idx = $_POST['hero_idx'][$i];
        $data_i = '1';
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
            $sql_one_update .= $post_key.'=\''.$_POST[$post_key][$i].'\''.$comma;
        $data_i++;
        }
        $sql = 'UPDATE point SET '.$sql_one_update.' WHERE hero_idx = \''.$idx.'\';'.PHP_EOL;
        mysql_query($sql);
    }
    $sql = 'select hero_point from point where hero_code=\''.$check_list['hero_code'].'\';';//desc
    sql($sql);
    while($total_list                             = @mysql_fetch_assoc($out_sql)){
        $point = $point+$total_list['hero_point'];
    }
    if(!strcmp($point,"")){
        $view_point = '0';
    }else{
        $view_point = $point;
    }
    $sql = 'UPDATE member SET hero_point=\''.$view_point.'\' WHERE hero_code = \''.$check_list['hero_code'].'\';'.PHP_EOL;
    mysql_query($sql);
    msg('수정 되었습니다.','location.href="'.PATH_HOME.'?'.get('type','').'"');
    exit;
}
/*
                        $sql = 'select hero_point from point where hero_code=\''.$check_list['hero_code'].'\';';//desc
                        sql($sql);
                        while($total_list                             = @mysql_fetch_assoc($out_sql)){
                            $point = $point+$total_list['hero_point'];
                        }
                        if(!strcmp($point,"")){
                            $view_point = '0';
                        }else{
                            $view_point = $point;
                        }
*/
                        $view_point = $check_list['hero_point'];
?>
                        <table width="100%">
                            <tr>
                                <td align="center">
                                    <b> [ <font color="blue"><?=$check_list['hero_id'];?></font> ] </b>님 총 획득 Point는
                                    <font color="red"><b><?=$view_point;?></b></font>
                                </td>
                            </tr>
                        </table>
                        <table class="t_list">
                            <thead>
                                <tr>
                                    <!--<th width="3%" class="first"><input type="checkbox" name="check_all" onclick="check_All();"/></th>-->
<!--                                    <th width="5%">번호</th>-->
                                    <th width="15%">아이디</th>
                                    <th width="15%">성 명</th>
                                    <th width="15%">제목</th>
                                    <th width="20%">포인트</th>
                                    <th width="10%">타입</th>
                                    <th width="10%">날짜</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form name="form_next" action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post" enctype="multipart/form-data"> 
                        <?
                        $sql = 'select * from point where hero_code=\''.$check_list['hero_code'].'\';';//desc
                        sql($sql);
                        while($list                             = @mysql_fetch_assoc($out_sql)){
                        ?>
                                <input type="hidden" name="hero_idx[]" value="<?=$list['hero_idx']?>">
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
<!--                                    <td><?=in($list['hero_idx']);?></td>-->
                                    <td><?=$check_list['hero_id'];?></td>
                                    <td><?=$check_list['hero_name'];?></td>
                                    <td><input type="text" name="hero_title[]" value="<?=$list['hero_title']?>" style="width:70px;text-align:center;"></td>
                                    <td><input type="text" name="hero_point[]" value="<?=$list['hero_point']?>" style="width:70px;text-align:center;"></td>
                                    <td><?=$list['hero_type']?></td>
                                    <td><?=date( "Y-m-d", strtotime($list['hero_today']));?></td>
                                </tr>
                        <?
                        }
                        ?>
                            </tbody>
                        </table><br>
                        <table width="100%">
                            <tr>
                                <td>
                                    <a href="javascript:go_list();" class="btn_blue2">목록</a>
                                </td>
                                <td>
                                    <a href="javascript:form_next.submit();" class="btn_blue">설정수정</a>
                                    <a href="<?=url('PATH_HOME||board||'.$board.'||&view=02_02&idx='.$_GET['idx'].'&next_idx='.$check_list['hero_idx']);?>" class="btn_blue">포인트 추가</a>
                                </td>
                            </tr>
                        </table>
                        <script>
                            function go_list(){
                                location.href = "./index.php?board=<?=$_GET['board']?>&idx=<?=$_GET['idx']?>";
                            }
                        </script>