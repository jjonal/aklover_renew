<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
if(strcmp($_POST['kewyword'], '')){
    $search = ' and '.$_POST['select'].' like \'%'.$_POST['kewyword'].'%\'';
    $search_next = '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
}else if(strcmp($_GET['kewyword'], '')){
    $search = ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
    $search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
}
######################################################################################################################################################
$sql = '
select new_board.* from(
    select hero_idx, hero_code, hero_table, hero_name, hero_today, hero_title, hero_use from board union all
    select hero_idx, hero_code, hero_table, hero_name, hero_today, hero_title, hero_use from mission
) as new_board where new_board.hero_table in (\'group_04_05\', \'group_04_06\', \'group_04_07\', \'group_04_08\', \'group_04_09\') 
'.$search.' ';
sql($sql);
$total_data = @mysql_num_rows($out_sql);
######################################################################################################################################################
$list_page=10;
$page_per_list=5;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board'].$search_next.'&idx='.$_GET['idx'];
######################################################################################################################################################
/*
if(!strcmp($_GET['type'], 'drop')){
    $sql = 'DELETE FROM mission WHERE hero_idx = \''.$_GET['hero_idx'].'\';';
    sql($sql);
    msg('삭제 되었습니다.','location.href="'.PATH_HOME.'?'.get('type||hero_idx','').'"');
    exit;
}
*/
?>
                        <table class="t_list">
                            <thead>
                                <tr>
                                    <!--<th width="3%" class="first"><input type="checkbox" name="check_all" onclick="check_All();"/></th>-->
<!--                                    <th width="5%">번호</th>-->
                                    <th width="15%">카테고리</th>
                                    <th width="15%">제목</th>
                                    <th width="15%">작성자</th>
                                    <th width="10%">등록일</th>
                                    <th width="10%">설정</th>
                                </tr>
                            </thead>
                            <tbody>
<?
$sql = '
select new_board.* from(
    select hero_idx, hero_code, hero_table, hero_name, hero_today, hero_title, hero_use from board union all
    select hero_idx, hero_code, hero_table, hero_name, hero_today, hero_title, hero_use from mission
) as new_board where new_board.hero_table in (\'group_04_05\', \'group_04_06\', \'group_04_07\', \'group_04_08\', \'group_04_09\') 
'.$search.' order by hero_table,hero_today desc limit '.$start.','.$list_page.';';

                        sql($sql);
                        while($list                             = @mysql_fetch_assoc($out_sql)){
                        $level_sql = 'select * from hero_group where hero_board=\''.$list['hero_table'].'\';';//desc<=
                        $out_level_sql = mysql_query($level_sql);
                        $level_list                             = @mysql_fetch_assoc($out_level_sql);
                        ?>
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'"><!-- onclick="location.href='<?=url('PATH_HOME||board||'.$board.'||&view=01_view&idx='.$_GET['idx'].'&next_idx='.$list['hero_idx']);?>'" style="cursor:pointer;"-->
                                    <td><?=$level_list['hero_title'];?></td>
                                    <td><?=$list['hero_title'];?></td>
                                    <td><?=$list['hero_name'];?></td>
                                    <td><?=date( "Y-m-d", strtotime($list['hero_today']));?></td>
                                    <td>
                                        <a href="javascript:location.href='<?=PATH_HOME.'?'.get('','view=01_01&hero_idx='.$list['hero_idx']);?>'" class="btn_blue2">신청자</a>
                                        <a href="javascript:location.href='<?=PATH_HOME.'?'.get('','view=01_03&hero_idx='.$list['hero_idx']);?>'" class="btn_blue2">참여자</a>
                                    </td>
                                </tr>
                        <?
                        }
                        ?>
                            </tbody>
                        </table>

                        <div style="width:100%; text-align:center; margin-top:20px;">
<? include_once PATH_INC_END.'page.php';?>
                        </div>
<? //include_once BOARD_INC_END.'search.php';?>
                        <div class="searchbox" style="margin-top:20px;">
                            <div class="wrap_1">
                            <form action="<?=PATH_HOME.'?'.get('page');?>" method="POST" >
                                <select name="select" id="">
                                  <option value="hero_user"<?if(!strcmp($_REQUEST['select'], 'hero_user')){echo ' selected';}else{echo '';}?>>받는사람</option>
                                  <option value="hero_title"<?if(!strcmp($_REQUEST['select'], 'hero_title')){echo ' selected';}else{echo '';}?>>제목</option>
                                  <option value="hero_command"<?if(!strcmp($_REQUEST['select'], 'hero_command')){echo ' selected';}else{echo '';}?>>내용</option>
                                </select>
                                <input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];?>" class="kewyword">
                                <input type="image" src="../image/bbs/btn_search.gif" alt="검색" class="bd0">
                            </form>
                            </div>
                        </div>