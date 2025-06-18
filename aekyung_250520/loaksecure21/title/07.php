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
        $sql = 'UPDATE hero_group SET '.$sql_one_update.' WHERE hero_idx = \''.$idx.'\';'.PHP_EOL;
        mysql_query($sql);
    }
    echo '<script>location.href="'.PATH_HOME.'?'.get('type','').'"</script>';
    msg('수정 되었습니다.','location.href="'.PATH_HOME.'?'.get('type','').'"');
    exit;
}
?>
<div class="view_title_box">
	*출석체크는 쓰기 POINT에 획득할 포인트를 적어 주시면 됩니다.<br><br>
	미션포인트 적용방법<br>
	<font color=red><b>미션에 쓰기권한 이란</b></font> 미션을 작성 및 수정 할수있는 권한입니다.<br><br>
	<font color=green>읽기 POINT</font>에 포인트를 적용시 <font color=red>미션을 클릭했을때 얻는 포인트</font>입니다.<br>
	<font color=green>댓글 POINT</font>는 <font color=red>리뷰에 댓글을 입력했을때 얻는 포인트</font>입니다.<br>
	<font color=green>리뷰어(미션) 작성시</font> 얻는 포인트는 <font color=red>미션신청 및 오프라인신청 POINT</font>에 넣으시면 됩니다.<br>
	<font color=green>리뷰 작성시 얻는 포인트</font>는 <font color=red>미션제출 및 오프라인제출 POINT</font>에 넣으시면 됩니다.
</div>

<table class="t_list">
<thead>
<tr>
	<th width="20%">카테고리</th>
	<th width="7%">검색권한</th>
	<th width="7%">쓰기권한</th>
	<th width="7%">읽기권한(리스트썸네일)</th>
	<th width="7%">읽기권한(상세페이지)</th>
	<th width="7%">댓글권한</th>
	<th width="7%">쓰기 POINT</th>
	<th width="7%">읽기 POINT</th>
	<th width="7%">댓글 POINT</th>
	<th width="7%">미션신청 및 오프라인신청 POINT</th>
	<th width="7%">미션제출(후기등록) 및 오프라인제출 POINT</th>
</tr>                               
</thead>
<tbody>
<form name="form_next" action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post" enctype="multipart/form-data"> 
<?
$sql = 'select * from hero_group where hero_type!=\'html\' and hero_menu=\'0\' and hero_use=\'1\' order by hero_point,hero_order asc;';
sql($sql, 'on');
$count = @mysql_num_rows($out_sql);
//    echo $list['hero_title'].'<br>';
while($list                             = @mysql_fetch_assoc($out_sql)){
######################################################################################################################################################
?>
                                <input type="hidden" name="hero_idx[]" value="<?=$list['hero_idx']?>">
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
                                    <!--카테고리-->
                                    <td><?=$list['hero_title']?></td>
                                    <!--검색권한-->
                                    <td>
                                        <select name="hero_search[]" id="hero_search[]">
<?
                        $level_sql = 'select * from level where hero_level<=\''.$_SESSION['temp_level'].'\' and hero_use=\'0\' order by hero_level asc;';//desc
                        $out_level_sql = mysql_query($level_sql);
                        while($level_list                             = @mysql_fetch_assoc($out_level_sql)){
?>
                                            <option value="<?=$level_list['hero_level']?>"<?if(!strcmp($level_list['hero_level'], $list['hero_search'])){echo ' selected';}else{echo '';}?>><?=$level_list['hero_name'];?></option>
<?
                        }
?>
                                         </select>
                                    </td>
                                    <!--쓰기권한-->
                                    <td>
                                        <select name="hero_write[]" id="hero_write[]">
<?
                        $out_level_sql = mysql_query($level_sql);
                        while($level_list                             = @mysql_fetch_assoc($out_level_sql)){
?>
                                            <option value="<?=$level_list['hero_level']?>"<?if(!strcmp($level_list['hero_level'], $list['hero_write'])){echo ' selected';}else{echo '';}?>><?=$level_list['hero_name'];?></option>
<?
                        }
?>
                                         </select>
                                    </td>
                                    <!--읽기권한(리스트썸네일)-->
                                    <td>
                                        <select name="hero_list[]" id="hero_list[]">
<?
                        $out_level_sql = mysql_query($level_sql);
                        while($level_list                             = @mysql_fetch_assoc($out_level_sql)){
?>
                                            <option value="<?=$level_list['hero_level']?>"<?if(!strcmp($level_list['hero_level'], $list['hero_list'])){echo ' selected';}else{echo '';}?>><?=$level_list['hero_name'];?></option>
<?
                        }
?>
                                        </select>
                                    </td>
                                    <!--읽기권한(상세페이지)-->
                                    <td>
                                        <select name="hero_view[]" id="hero_view[]">
<?
                        $out_level_sql = mysql_query($level_sql);
                        while($level_list                             = @mysql_fetch_assoc($out_level_sql)){
?>
                                            <option value="<?=$level_list['hero_level']?>"<?if(!strcmp($level_list['hero_level'], $list['hero_view'])){echo ' selected';}else{echo '';}?>><?=$level_list['hero_name'];?></option>
<?
                        }
?>
                                        </select>
                                    </td>
                                    <!--댓글권한-->
                                    <td>
                                        <select name="hero_rev[]" id="hero_rev[]">
<?
                        $out_level_sql = mysql_query($level_sql);
                        while($level_list                             = @mysql_fetch_assoc($out_level_sql)){
?>
                                            <option value="<?=$level_list['hero_level']?>"<?if(!strcmp($level_list['hero_level'], $list['hero_rev'])){echo ' selected';}else{echo '';}?>><?=$level_list['hero_name'];?></option>
<?
                        }
?>
                                        </select>
                                    </td>
                                    <!--쓰기 POINT-->
                                    <td>
                                        <input type="text" name="hero_write_point[]" value="<?=$list['hero_write_point']?>" style="width:70px;text-align:center;">
                                    </td>
                                    <!--읽기 POINT-->
                                    <td>
                                        <input type="text" name="hero_view_point[]" value="<?=$list['hero_view_point']?>" style="width:70px;text-align:center;">
                                    </td>
                                    <!--댓글 POINT-->
                                    <td>
                                        <input type="text" name="hero_rev_point[]" value="<?=$list['hero_rev_point']?>" style="width:70px;text-align:center;">
                                    </td>
                                    <!--미션신청 및 오프라인신청 POINT-->
                                    <td>
                                        <input type="text" name="hero_mission_point[]" value="<?=$list['hero_mission_point']?>" style="width:70px;text-align:center;">
                                    </td>
                                    <!--미션제출(후기등록) 및 오프라인제출 POINT-->
                                    <td>
                                        <input type="text" name="hero_mission_join[]" value="<?=$list['hero_mission_join']?>" style="width:70px;text-align:center;">
                                    </td>
                                </tr>
<?
$i++;
}
?>
                                </form>
                            </tbody>
                        </table>
<div class="btnGroup">
	 <a href="javascript:form_next.submit();" class="btnAdd">설정수정</a>
</div>
<?// include_once PATH_INC_END.'page.php';?>
<?// include_once PATH_INC_END.'search.php';?>