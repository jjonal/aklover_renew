<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
if(!strcmp($_GET['today'], '')){
    $new_today_check = Y."-".m;
}else{
    $new_today_check = $_GET['today'];
}
?>
<style>
.t_list{white-space:nowrap;}
.t_list td,tr,th{white-space:nowrap;}
</style>
                        <table class="t_list">
                            <thead>
                                <tr>
                                    <td colspan="5" align="center" style="padding:10px">
                                        <select name="select" id="" onchange="location.href='<?=PATH_HOME."?".get("today||select||kewyword","today=")?>'+this.value+'<?=$search_next?>'">
<?
for($m_date_i=0;$m_date_i<12;$m_date_i++){
$check_date = @date("Y-m",mktime(0,0,0,m-$m_date_i,d,Y));
?>
                                          <option value="<?=$check_date?>"<?if(!strcmp($_REQUEST['today'], $check_date)){echo ' selected';}else{echo '';}?>><?=$check_date?></option>
<?}?>
                                        </select>
                                        <a href="#" onclick="location.href='<?=PATH_HOME."?".get("today||select||kewyword","")?>'">첫화면</a><br>
                                        게시판 종류 : 오늘하루 / 연애&결혼 / 핫이슈/러버 아이디어 / 러버 칭찬통 / 도전! 파워블로그<br>
                                        비회원은 추천 할수 없습니다.
                                    </td>
                                </tr>
                                <tr>
                                    <th width="8%">게시판</th>
                                    <th width="25%">게시글 제목</th>
                                    <th width="8%">게시글 보기</th>
                                    <th width="8%">게시글 작성자</th>
                                    <th width="8%">게시글 닉네임</th>
                                    <th width="5%">추천받은 합계</th>
                                </tr>
                            </thead>
                            <tbody>
<?
$sql = 'select a.*,count(a.hero_board_idx) AS total_count, b.* from hero_recommand AS a LEFT JOIN (SELECT * FROM member) AS b ON (a.hero_board_code = b.hero_code) where DATE_FORMAT(a.hero_today,\'%Y-%m\')=\''.$new_today_check.'\' and  a.hero_board=\'group_02_01\' group by hero_board_idx order by total_count desc limit 0,3;';
sql($sql,'on');
while($roll_list                             = @mysql_fetch_assoc($out_sql)){
    $select_sql = 'select * from board where hero_idx=\''.$roll_list['hero_board_idx'].'\'';
    $out_select = @mysql_query($select_sql);
    $select_list                             = @mysql_fetch_assoc($out_select);
?>
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
                                    <td>오늘하루</td>
                                    <td><?=cut($select_list['hero_title'],48);?></td>
                                    <td><a href='<?=$roll_list['hero_url']?>' target='_blank'>게시글 보기</a></td>
                                    <td><?=$roll_list['hero_board_id']?></td>
                                    <td><?=$roll_list['hero_board_nick']?></td>
                                    <td><?=$roll_list['total_count']?></td>
                                </tr>
<?
}
?>
<?
$sql = 'select a.*,count(a.hero_board_idx) AS total_count, b.* from hero_recommand AS a LEFT JOIN (SELECT * FROM member) AS b ON (a.hero_board_code = b.hero_code) where DATE_FORMAT(a.hero_today,\'%Y-%m\')=\''.$new_today_check.'\' and  a.hero_board=\'group_02_02\' group by hero_board_idx limit 0,3;';
sql($sql);
while($roll_list                             = @mysql_fetch_assoc($out_sql)){
    $select_sql = 'select * from board where hero_idx=\''.$roll_list['hero_board_idx'].'\'';
    $out_select = @mysql_query($select_sql);
    $select_list                             = @mysql_fetch_assoc($out_select);
?>
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
                                    <td>연애&결혼</td>
                                    <td><?=cut($select_list['hero_title'],48);?></td>
                                    <td><a href='<?=$roll_list['hero_url']?>' target='_blank'>게시글 보기</a></td>
                                    <td><?=$roll_list['hero_board_id']?></td>
                                    <td><?=$roll_list['hero_board_nick']?></td>
                                    <td><?=$roll_list['total_count']?></td>
                                </tr>
<?
}
?>
<?
$sql = 'select a.*,count(a.hero_board_idx) AS total_count, b.* from hero_recommand AS a LEFT JOIN (SELECT * FROM member) AS b ON (a.hero_board_code = b.hero_code) where DATE_FORMAT(a.hero_today,\'%Y-%m\')=\''.$new_today_check.'\' and  a.hero_board=\'group_03_03\' group by hero_board_idx limit 0,3;';
sql($sql);
while($roll_list                             = @mysql_fetch_assoc($out_sql)){
    $select_sql = 'select * from board where hero_idx=\''.$roll_list['hero_board_idx'].'\'';
    $out_select = @mysql_query($select_sql);
    $select_list                             = @mysql_fetch_assoc($out_select);
?>
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
                                    <td>핫이슈</td>
                                    <td><?=cut($select_list['hero_title'],48);?></td>
                                    <td><a href='<?=$roll_list['hero_url']?>' target='_blank'>게시글 보기</a></td>
                                    <td><?=$roll_list['hero_board_id']?></td>
                                    <td><?=$roll_list['hero_board_nick']?></td>
                                    <td><?=$roll_list['total_count']?></td>
                                </tr>
<?
}
?>
<?
$sql = 'select a.*,count(a.hero_board_idx) AS total_count, b.* from hero_recommand AS a LEFT JOIN (SELECT * FROM member) AS b ON (a.hero_board_code = b.hero_code) where DATE_FORMAT(a.hero_today,\'%Y-%m\')=\''.$new_today_check.'\' and  a.hero_board=\'group_03_04\' group by hero_board_idx limit 0,3;';
sql($sql);
while($roll_list                             = @mysql_fetch_assoc($out_sql)){
    $select_sql = 'select * from board where hero_idx=\''.$roll_list['hero_board_idx'].'\'';
    $out_select = @mysql_query($select_sql);
    $select_list                             = @mysql_fetch_assoc($out_select);
?>
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
                                    <td>러버 아이디어</td>
                                    <td><?=cut($select_list['hero_title'],48);?></td>
                                    <td><a href='<?=$roll_list['hero_url']?>' target='_blank'>게시글 보기</a></td>
                                    <td><?=$roll_list['hero_board_id']?></td>
                                    <td><?=$roll_list['hero_board_nick']?></td>
                                    <td><?=$roll_list['total_count']?></td>
                                </tr>
<?
}
?>
<?
$sql = 'select a.*,count(a.hero_board_idx) AS total_count, b.* from hero_recommand AS a LEFT JOIN (SELECT * FROM member) AS b ON (a.hero_board_code = b.hero_code) where DATE_FORMAT(a.hero_today,\'%Y-%m\')=\''.$new_today_check.'\' and  a.hero_board=\'group_03_05\' group by hero_board_idx limit 0,3;';
sql($sql);
while($roll_list                             = @mysql_fetch_assoc($out_sql)){
    $select_sql = 'select * from board where hero_idx=\''.$roll_list['hero_board_idx'].'\'';
    $out_select = @mysql_query($select_sql);
    $select_list                             = @mysql_fetch_assoc($out_select);
?>
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
                                    <td>러버 칭찬통</td>
                                    <td><?=cut($select_list['hero_title'],48);?></td>
                                    <td><a href='<?=$roll_list['hero_url']?>' target='_blank'>게시글 보기</a></td>
                                    <td><?=$roll_list['hero_board_id']?></td>
                                    <td><?=$roll_list['hero_board_nick']?></td>
                                    <td><?=$roll_list['total_count']?></td>
                                </tr>
<?
}
?>
<?
$sql = 'select a.*,count(a.hero_board_idx) AS total_count, b.* from hero_recommand AS a LEFT JOIN (SELECT * FROM member) AS b ON (a.hero_board_code = b.hero_code) where DATE_FORMAT(a.hero_today,\'%Y-%m\')=\''.$new_today_check.'\' and  a.hero_board=\'group_04_03\' group by hero_board_idx limit 0,3;';
sql($sql);
while($roll_list                             = @mysql_fetch_assoc($out_sql)){
    $select_sql = 'select * from board where hero_idx=\''.$roll_list['hero_board_idx'].'\'';
    $out_select = @mysql_query($select_sql);
    $select_list                             = @mysql_fetch_assoc($out_select);
?>
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
                                    <td>공지사항</td>
                                    <td><?=cut($select_list['hero_title'],48);?></td>
                                    <td><a href='<?=$roll_list['hero_url']?>' target='_blank'>게시글 보기</a></td>
                                    <td><?=$roll_list['hero_board_id']?></td>
                                    <td><?=$roll_list['hero_board_nick']?></td>
                                    <td><?=$roll_list['total_count']?></td>
                                </tr>
<?
}
?>
<?
$sql = 'select a.*,count(a.hero_board_idx) AS total_count, b.* from hero_recommand AS a LEFT JOIN (SELECT * FROM member) AS b ON (a.hero_board_code = b.hero_code) where DATE_FORMAT(a.hero_today,\'%Y-%m\')=\''.$new_today_check.'\' and  a.hero_board=\'group_04_11\' group by hero_board_idx limit 0,3;';
sql($sql);
while($roll_list                             = @mysql_fetch_assoc($out_sql)){
    $select_sql = 'select * from board where hero_idx=\''.$roll_list['hero_board_idx'].'\'';
    $out_select = @mysql_query($select_sql);
    $select_list                             = @mysql_fetch_assoc($out_select);
?>
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
                                    <td>도전! 파워블로그</td>
                                    <td><?=cut($select_list['hero_title'],48);?></td>
                                    <td><a href='<?=$roll_list['hero_url']?>' target='_blank'>게시글 보기</a></td>
                                    <td><?=$roll_list['hero_board_id']?></td>
                                    <td><?=$roll_list['hero_board_nick']?></td>
                                    <td><?=$roll_list['total_count']?></td>
                                </tr>
<?
}
?>
                            </tbody>
                        </table>
