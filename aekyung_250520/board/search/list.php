<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$cut_count_name = '6';
$cut_title_name = '34';
######################################################################################################################################################
$sql_review_select = "";

$tab = $_REQUEST['tab'];
if(!$tab) $tab = 1;

if(strcmp($_REQUEST['kewyword'], '')){
    //���� ����, �ۼ��� ����
    if(!strcmp($_REQUEST['select'], '')){
        $sql_select = 'hero_title';
        $sql_review_select = "hero_command";
    }else{
        $sql_select = $_REQUEST['select'];
        if($sql_select == "hero_title") $sql_review_select = "r.hero_command";
        if($sql_select == "hero_nick") $sql_review_select = "m.hero_nick";
    }
    
    //�˻�����
    $search = ' and '.$sql_select.' like \'%'.$_REQUEST['kewyword'].'%\'';
    $sql_review_select = ' and '.$sql_review_select.' like \'%'.$_REQUEST['kewyword'].'%\'';
    $search_next = '&select='.$sql_select.'&kewyword='.stripslashes($_REQUEST['kewyword'])."&tab=".$tab;

	$mission_code   = "'group_04_05','group_02_03'";  //ü���/�̺�Ʈ -> ü���, �Ը����̺�Ʈ
	$board_code     = "'group_04_03','group_02_02' "; //����/Ŀ�´�Ƽ -> ��������, ������
	$post_code 		= "'group_04_09','group_04_10','group_04_22'"; //�ı�/Ȱ�� -> ü���ı�, ����ı�, �����ı�
	$reply_code 	= "'group_04_03','group_02_02','group_04_05','group_02_03','group_04_09','group_04_10','group_04_22' "; //��� -> ����/Ŀ�´�Ƽ, ������, ü���/�̺�Ʈ, �Ը����̺�Ʈ, ü�㹫��, ����ı�, �����ı�

	if($_SESSION["temp_level"] > 0) {
		$board_code .= ",'group_04_24'"; //�����
		$reply_code .= ",'group_04_24'";
	}

    // level 9999 ���
    // level 10000 ������
	if($_SESSION["temp_level"] >= 9999 || $_SESSION["temp_level"] == 9995) { // level 9995 Beauty Club ������
		$mission_code .= ",'group_04_27'"; //Beauty/Life Club ������ �ε� ���X
		$reply_code .= ",'group_04_27'";
	}

	if($_SESSION["temp_level"] >= 9999 || $_SESSION["temp_level"] == 9996) { // level 9996 ��ƼŬ��
		$mission_code .= ",'group_04_06'"; //ü���/�̺�Ʈ
		$reply_code .= ",'group_04_06'";
	}

	$totalCount = 0; //�� �Ǽ�
	$total_data = 0; //�Ǻ� ī��Ʈ

    //ü���/�̺�Ʈ
	$sql_mission = " SELECT count(*) as cnt FROM (SELECT hero_idx FROM mission WHERE hero_use=1 AND hero_table in ($mission_code) ".$search;
	$sql_mission .= " union all SELECT hero_idx FROM board WHERE hero_use=1 AND hero_table in ($mission_code) ".$search. " ) a ";
	sql($sql_mission);
	$row = mysql_fetch_assoc($out_sql);
	$missonCount = $row["cnt"];

	//����/Ŀ�´�Ƽ
	$sql_board = " SELECT count(*) as cnt FROM board WHERE hero_use=1 AND hero_table in ($board_code) ".$search;
	sql($sql_board);
	$row = mysql_fetch_assoc($out_sql);
	$boardCount = $row["cnt"];

	//�ı�/Ȱ��
	$sql_post = " SELECT count(*) as cnt FROM board WHERE hero_use=1 AND hero_table in ($post_code) ".$search;
	sql($sql_post);
	$row = mysql_fetch_assoc($out_sql);
	$postCount = $row["cnt"];

	//���
	$sql_reply = " SELECT count(*) as cnt FROM review r inner join  member m ON r.hero_code = m.hero_code WHERE r.hero_table in ($reply_code) ".$sql_review_select;
	sql($sql_reply);
	$row = mysql_fetch_assoc($out_sql);
	$replyCount = $row["cnt"];

    //�� �Ǽ�
	$totalCount = $missonCount+$boardCount+$postCount+$replyCount;
	
    //���������̼�
	$list_page=8;
	$page_per_list=10;
	if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
	$start = ($page-1)*$list_page;
	$next_path="board=".$_GET['board'].$search_next;

    //�Ǻ� �Ǽ�
	if($tab == "1") {
		$total_data = $missonCount;
		$sql_list = " SELECT * FROM (SELECT hero_title, hero_table, hero_nick, hero_code, hero_idx, hero_today FROM mission WHERE hero_use=1 AND hero_table in ($mission_code) ".$search;
		$sql_list .= " union all SELECT hero_title, hero_table, hero_nick, hero_code, hero_idx, hero_today  FROM board WHERE hero_use=1 AND hero_table in ($mission_code) ".$search." ) a";
	} else if($tab == "2") {
		$total_data = $boardCount;
		$sql_list = " SELECT hero_title, hero_table, hero_nick, hero_code, hero_idx, hero_today  FROM board WHERE hero_use=1 AND hero_table in ($board_code) ".$search;
	} else if($tab == "3") {
		$total_data = $postCount;
		$sql_list = " SELECT hero_title, hero_table, hero_nick, hero_code, hero_idx, hero_today  FROM board WHERE hero_use=1 AND hero_table in ($post_code) ".$search;
	} else if($tab == "4") {
		$total_data = $replyCount;
		$sql_list = " SELECT r.hero_command as hero_title, r.hero_table, r.hero_code, r.hero_old_idx as hero_idx, m.hero_nick, r.hero_today ";
		$sql_list .= " FROM review r INNER JOIN member m ON r.hero_code = m.hero_code WHERE r.hero_table in ($reply_code) ".$sql_review_select;
	}
	
	$sql_list .= " ORDER BY hero_idx DESC limit ".$start.",".$list_page;
//	echo $sql_list;
	sql($sql_list);
}

?>
<div id="subpage" class="search_end">
	<div class="sub_title">
	</div>
	<div class="sub_cont">
		<div class="sub_wrap board_wrap f_sb">
			<div class="left">
				<div class="searchbox mu_searchbox">
					<div class="title fz20 fw600 pc">SEARCH</div>	
					<div class="search_cont rel">
					<form action="<?=PATH_HOME.'?'.get('page');?>" method="POST" >
						<select name="select" id="">
						<option value="hero_title"<?if(!strcmp($_REQUEST['select'], 'hero_title')){echo ' selected';}else{echo '';}?>>����</option>
						<option value="hero_nick"<?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>�ۼ���</option>
						</select>
						<input name="kewyword" type="text" value="<?echo stripslashes($_REQUEST['kewyword']);?>" class="kewyword wid100" placeholder="�˻�� �Է����ּ���">
						<input type="submit" class="mu_search_btn screen_out" value="�˻�" />
					</form>
					</div>
				</div>
			</div>
			<div class="contents right">
				<p style="margin-bottom:4rem; font-size:1.6rem;">�� �˻� <strong><?=number_format($totalCount);?>��</strong> �˻��Ǿ����ϴ�.</p>
				<div class="introduceTab">
					<ul class="boardTabMenuWrap activityTab">
						<li <?=$tab=="1"?"class='on'":"";?> rel="tab01">ü���/�̺�Ʈ(<?=number_format($missonCount);?>)</li>
						<li <?=$tab=="2"?"class='on'":"";?> rel="tab02">����/Ŀ�´�Ƽ (<?=number_format($boardCount);?>)</li>
						<li <?=$tab=="3"?"class='on'":"";?> rel="tab04">�ı�/Ȱ�� (<?=number_format($postCount);?>)</li>
						<li <?=$tab=="4"?"class='on'":"";?> rel="tab03">��� (<?=number_format($replyCount);?>)</li>
					</ul>
				</div>
				<table border="0" cellpadding="0" cellspacing="0" class="bbs_list" style="margin-top:10px;">					
					<colgroup>
						<col width="15%" />
						<col width="*" />
						<col width="18%" />
						<col width="18%" />
					</colgroup>
					<thead>
						<tr class="bbshead">
							<th class="first">��ȣ</th>
							<th>����</th>
							<th>�ۼ���</th>
							<th class="last">��¥</th>
						</tr>
					</thead>
					<tbody>					
					<?
					$i=0;
					while($list                             = @mysql_fetch_assoc($out_sql)){
					$num=$total_data - $start-$i;
						$i++;
                        //�Խñ� ī�װ�
						$info_sql = 'select * from hero_group where hero_board=\''.$list['hero_table'].'\';';
						$out_info_sql = mysql_query($info_sql);
						$info_list                             = @mysql_fetch_assoc($out_info_sql);
                        //�ۼ���
						$pk_sql = 'select a.hero_level,a.hero_nick,b.hero_img_new from member as a, level as b  where b.hero_level = a.hero_level and a.hero_code = \''.$list['hero_code'].'\'';
						$out_pk_sql = mysql_query($pk_sql);
						$pk_row                             = @mysql_fetch_assoc($out_pk_sql);
						
						$target = "";
						if($list['hero_table'] == "group_04_09" || $list['hero_table'] == "group_04_10" || $list['hero_table'] == "group_04_22") {
							$link = PATH_HOME."?board=".$list['hero_table']."&view=view2&idx=".$list['hero_idx'];
							$target = "_blank";
						} else {
							$link = PATH_HOME."?board=".$list['hero_table']."&view=view&idx=".$list['hero_idx'];
						}
					?>
					<tr>
						<td><?=$num;?></td>
						<td class="tl">
						<a href="<?=$link;?>" target="<?=$target?>">
							<b class="main_c">[<?=$info_list['hero_title']?>]</b> <?=cut($list['hero_title'], $cut_title_name);?>
						</a>
						</td>
						<td><?=$pk_row['hero_nick'];?></td>
						<td><?=date( "Y.m.d", strtotime($list['hero_today']));?></td>
                    </tr>
					<?}?>
					<? if($i==0) {?>
					<tr>
						<td colspan="4">�˻��� �����Ͱ� �����ϴ�.</td>
					</tr>
					<? } ?>						
					</tbody>
				</table>
				<? include_once BOARD_INC_END.'button.php';?>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	$(".activityTab li").on("click",function(){
		var k = $(".activityTab li").index(this)+1;
		location.href = "<?=$MAIN_HOME?>?board=<?=$_GET["board"]?>&select=<?=$sql_select?>&kewyword=<?=stripslashes($_REQUEST["kewyword"])?>&tab="+k;
	})
})
</script>
