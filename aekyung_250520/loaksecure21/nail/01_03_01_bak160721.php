<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
if(strcmp($_REQUEST['kewyword'], '')){
	if(!strcmp($_REQUEST['select'], 'hero_all')){
		$search = ' ( hero_name like \'%'.$_REQUEST['kewyword'].'%\' or hero_title like \'%'.$_REQUEST['kewyword'].'%\' or hero_nick like \'%'.$_REQUEST['kewyword'].'%\') and ';
		$search_next = '&select='.$_REQUEST['select'].'&kewyword='.$_REQUEST['kewyword'];
	}else{
		$search = ' '.$_REQUEST['select'].' like \'%'.$_REQUEST['kewyword'].'%\' and ';
		$search_next = '&select='.$_REQUEST['select'].'&kewyword='.$_REQUEST['kewyword'];
	}
}
######################################################################################################################################################
$sql = 'select * from board where '.$search.'  hero_01=\''.$_GET['hero_idx'].'\'';
sql($sql);
$total_data = @mysql_num_rows($out_sql);

/////////// no 생성 20140509
$i=$total_data;

######################################################################################################################################################
$list_page=10;
$page_per_list=5;

if(!strcmp($_GET['page'], '')){
	$page = '1';
}else{
	$page = $_GET['page'];
	$i = $i-($page-1)*$list_page;
}

$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board'].$search_next.'&idx='.$_GET['idx'].'&view='.$_GET['view'].'&hero_idx='.$_GET['hero_idx'];
######################################################################################################################################################
if(!strcmp($_GET['action'], 'ok')){
    $sql = 'UPDATE board SET hero_board_three=\'1\' WHERE hero_idx = \''.$_GET['new_idx'].'\';'.PHP_EOL;
    @mysql_query($sql);
    msg('선택 되었습니다.','location.href="'.PATH_HOME.'?'.get('action||new_idx','').'"');
    exit;
}else if(!strcmp($_GET['action'], 'no')){
    $sql = 'UPDATE board SET hero_board_three=\'0\' WHERE hero_idx = \''.$_GET['new_idx'].'\';'.PHP_EOL;
    @mysql_query($sql);
    msg('취소 되었습니다.','location.href="'.PATH_HOME.'?'.get('action||new_idx','').'"');
    exit;
}
$level_old_sql = $sql.' order by hero_table,hero_today desc limit '.$start.','.$list_page.';';
$out_level_old_sql = mysql_query($level_old_sql);
$level_old_list                             = @mysql_fetch_assoc($out_level_old_sql);

$level_sql = 'select * from hero_group where hero_board=\''.$level_old_list['hero_table'].'\';';//desc<=
$out_level_sql = mysql_query($level_sql);
$level_list                             = @mysql_fetch_assoc($out_level_sql);

$mission_sql = 'select * from mission where hero_table=\''.$level_old_list['hero_table'].'\' and hero_idx=\''.$_GET['hero_idx'].'\';';//desc<=
$out_mission_sql = mysql_query($mission_sql);
$mission_list                             = @mysql_fetch_assoc($out_mission_sql);

?>
                        <center>
                            <div style="margin:20px;">
								<font color="blue" style="margin:20px;font-size: 20px;font-weight: 800;"> 리뷰 신청자 </font>
								<a href="<?=PATH_HOME.'?'.get('view||hero_idx')?>" class="btn_blue2">목록</a>
							</div>
							<div class="searchbox" style="margin:20px;">
                            <div class="wrap_1">
                            <form action="<?=PATH_HOME.'?'.get('page');?>" method="POST" >
                                <select name="select" id="" style='width:70px;'>
                                  <option value="hero_nick"<?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>닉네임</option>
								  <option value="hero_name"<?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>이름</option>
                                  <option value="hero_title"<?if(!strcmp($_REQUEST['select'], 'hero_title')){echo ' selected';}else{echo '';}?>>제목</option>
								  <option value="hero_all"<?if(!strcmp($_REQUEST['select'], 'hero_all')){echo ' selected';}else{echo '';}?>>닉네임+이름+제목</option>
                                </select>
                                <input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];?>" class="kewyword">
                                <input type="image" src="../image/bbs/btn_search.gif" alt="검색" class="bd0">
								</form>
								</div>
								
							</div>
                        </center>
<style>
/*
.t_list{white-space:nowrap;}
.t_list td,tr,th{white-space:nowrap;}
*/
</style>
                        <table class="t_list">
                            <thead>
                                <tr>
                                     <th style="padding:10px;">
										카테고리 : <font color="blue" style="font-weight:800;">
													<?=$level_list['hero_title'];?>
												    </font><br>
										제목 : <font color="blue" style="font-weight:800;"><?=$mission_list['hero_title'];?></font><br>
                                        
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>
                                        <table class="t_list" style="table-layout:fixed;word-wrap:break-word; word-break:break-all;">
                                            <thead>
                                                <tr>
													<th width="30px">NO</td>
                                                    <th width="80px"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_03_02&table_type=hero_id&table_name=아이디")?>">아이디</a></th>
                                                    <th width="60px"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_03_02&table_type=hero_nick&table_name=닉네임")?>">닉네임</a></th>
                                                    <th width="50px"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_03_02&table_type=hero_name&table_name=이름")?>">이름</a></th>
                                                    <th width="50px"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_03_02&table_type=hero_new_name&table_name=받는이름")?>">받는이름</a></th>
                                                    <th width="50px">나이</th>
                                                    <th width="80px"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_03_02&table_type=hero_hp&table_name=전화번호")?>">전화번호</a></th>
                                                    <th width="60px"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_03_02&table_type=hero_address&table_name=받으시는분주소")?>">우편번호</a></td>
                                                    <th width="150px"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_03_02&table_type=hero_address&table_name=받으시는분주소")?>">받으시는분주소</a></td>
                                                    <th width="110px"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_03_02&table_type=hero_01&table_name=url")?>">url</a></th>
                                                    <th width="280px"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_03_02&table_type=hero_02&table_name=신청내용")?>">신청내용</a></td>

                                                    <th width="50px">러버등급</td>
                                                    <th width="50px">포스팅</td>
                                                    <th width="70px">비고</td>
                                                    <th width="60px">비고</td>
                                                    <th width="70px">등록일</th>
                                                    <th width="100px">설정</th>


                                                </tr>
                                            </thead>
                                            <tbody>
<?
                        $sql = $sql.' order by hero_table,hero_today desc limit '.$start.','.$list_page.';';
                        sql($sql);
                        while($list                             = @mysql_fetch_assoc($out_sql)){
                        $level_sql = 'select * from hero_group where hero_board=\''.$list['hero_table'].'\';';//desc<=
                        $out_level_sql = mysql_query($level_sql);
                        $level_list                             = @mysql_fetch_assoc($out_level_sql);

                        $mission_sql = 'select * from mission where hero_table=\''.$list['hero_table'].'\' and hero_idx=\''.$_GET['hero_idx'].'\';';//desc<=
                        $out_mission_sql = mysql_query($mission_sql);
                        $mission_list                             = @mysql_fetch_assoc($out_mission_sql);
                        if(!strcmp($list['hero_board_three'], '1')){
                            $lot_01 = '<font color="red">당첨자</font>';
                        }else{
                            $lot_01 = '';
                        }
						//160610 and hero_old_idx 조건 추가
                        $mission_review_sql = 'select * from mission_review where hero_code=\''.$list['hero_code'].'\' and hero_old_idx=\''.$_GET['hero_idx'].'\';';//desc<=
                        $out_mission_review_sql = mysql_query($mission_review_sql);
                        $mission_review_list                             = @mysql_fetch_assoc($out_mission_review_sql);

                        $member_sql = 'select * from member where hero_code=\''.$list['hero_code'].'\';';//desc<=
                        $out_member_sql = mysql_query($member_sql);
                        $member_list                             = @mysql_fetch_assoc($out_member_sql);
                        
                        $age = date('Y')-substr($member_list['hero_jumin'],0,4)+1;
                        ?>
                        	<tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
												<td><?=$i?></td>
                                                <td><?=nl2br($member_list['hero_id']);?></td>
                                                <!-- 160610수정 -->
                                                <!--<td><?=nl2br($mission_review_list['hero_id']);?></td>-->
                                                <td><?=nl2br($list['hero_nick']);?></td>
                                                <td><?=nl2br($list['hero_name']);?></td>
                                                <td><?=nl2br($mission_review_list['hero_new_name']);?></td>
                                                <td><?=$age?></td>
                                                <td><?=nl2br($mission_review_list['hero_hp_01']);?>-<?=nl2br($mission_review_list['hero_hp_02']);?>-<?=nl2br($mission_review_list['hero_hp_03']);?></td>
                                                <td><?=nl2br($mission_review_list['hero_address_01']);?></td>
                                                <td><?=nl2br($mission_review_list['hero_address_02']);?> <?=nl2br($mission_review_list['hero_address_03']);?></td>
                                                <td ><?=nl2br($list['hero_04']);?></td>
                                                <td><?=nl2br($mission_review_list['hero_02']);?></td>

                                                <td><?=nl2br($member_list['hero_memo']);?></td>
                                                <td><?=nl2br($member_list['hero_memo_01']);?></td>
                                                <td><?=nl2br($member_list['hero_memo_02']);?></td>
                                                <td><?=nl2br($member_list['hero_memo_03']);?></td>
                                                <td><?=date( "Y-m-d", strtotime($list['hero_today']));?></td>
                                                <td><?=$lot_01;?><br>
                                                    <a href="javascript:location.href='<?=PATH_HOME.'?'.get('action||new_idx','action=ok&new_idx='.$list['hero_idx']);?>'" class="btn_blue2">선택</a>
                                                    <a href="javascript:location.href='<?=PATH_HOME.'?'.get('action||new_idx','action=no&new_idx='.$list['hero_idx']);?>'" class="btn_blue2">취소</a>
                                                </td>
                                            </tr>
                        <?
						$i--;
                        }
                        ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            </tbody>
                        </table>

                        <div style="width:100%; text-align:center; margin-top:20px;">
<? include_once PATH_INC_END.'page.php';?>
                        </div>
<? //include_once BOARD_INC_END.'search.php';?>
                        