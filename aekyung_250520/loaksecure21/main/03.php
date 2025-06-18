<?
if(!defined('_HEROBOARD_'))exit;

######################################################################################################################################################

if(strcmp($_POST['kewyword'], '')){
	if($_POST['select']=='hero_all'){
		$search = ' and ( hero_title like \'%'.$_POST['kewyword'].'%\' or hero_command like \'%'.$_POST['kewyword'].'%\')';
		$search_next = '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
	}else{
		$search = ' and '.$_POST['select'].' like \'%'.$_POST['kewyword'].'%\'';
	    $search_next = '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
	}
}else if(strcmp($_GET['kewyword'], '')){
    if($_GET['select']=='hero_all'){
		$search = ' and ( hero_title like \'%'.$_GET['kewyword'].'%\' or hero_command like \'%'.$_GET['kewyword'].'%\')';
		$search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
	}else{
		$search = ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
	    $search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
	}
}

if(strcmp($_POST['kewyword'], '') || strcmp($_GET['kewyword'], '')){
	
	$sql = 'select count(*) as count from mission where (hero_table=\'group_04_05\' or hero_table=\'group_04_06\' or hero_table=\'group_04_07\' or hero_table=\'group_04_08\') and not hero_notice_use=1 and not hero_notice_use=2 '.$search.' order by hero_today desc, hero_idx desc;';
	//echo $sql;
	sql($sql);
	$total_data = @mysql_fetch_assoc($out_sql);
	$total_data = $total_data['count'];
	///////////////////////////////no 값 설정 201400508
	$i=$total_data;
	$list_page=10;
	$page_per_list=5;

	///////////////////////////////no 값 설정 201400508
	if(!strcmp($_GET['page'], '') || !strcmp($_GET['page'], '1')){$page = '1';
	}else{
		$page = $_GET['page'];
		$i = $i-($page-1)*$list_page;
	}

	$start = ($page-1)*$list_page;
	$next_path="board=".$_GET['board'].$search_next.'&idx='.$_GET['idx'];
	
}

?>

<style>
	.mainmain { background-color:#eeeeee; width:30%; height:40px; text-align:center; vertical-align:middle; margin:10px 0px 20px 33%; border: 1px solid #cccccc;}
	.mainmain p { font-size:15px; padding-top:14px;}
</style>

<div style="float:left;width:46%">

					<div class='mainmain'><p>검색</p></div>

					<div class="searchbox" style="margin-top:20px;margin-bottom:20px;margin-left:20%">
                            <div class="wrap_1">
                            <form name="frm" action="<?=PATH_HOME.'?'.get('page');?>" method="POST" >
                                <select name="select" id="" style='width:80px;'>
									<option value="hero_title"<?if(!strcmp($_REQUEST['select'], 'hero_table')){echo ' selected';}else{echo '';}?>>제목</option>
									<option value="hero_command"<?if(!strcmp($_REQUEST['select'], 'hero_command')){echo ' selected';}else{echo '';}?>>내용</option>
									<option value="hero_all"<?if(!strcmp($_REQUEST['select'], 'hero_all')){echo ' selected';}else{echo '';}?>>제목+내용</option>
                                </select>
                                <input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];?>" class="kewyword">
                                <input type="image" src="../image/bbs/btn_search.gif" alt="검색" class="bd0">
                            </form>
                            </div>
                        </div>


<table class='t_list'>
	<thead>
		<tr>
			<th width='3%'>NO</th>
			<th width='10%'>미션종류</th>
			<th width='30%'>제목</th>
			<th width='5%'>사용</th>
		</tr>
    </thead>
	<tbody>
		<?
			if(strcmp($_POST['kewyword'], '') || strcmp($_GET['kewyword'], '')){
				if($search){
					$sql = 'select hero_table, hero_title, hero_idx from mission where (hero_table=\'group_04_05\' or hero_table=\'group_04_06\' or hero_table=\'group_04_07\' or hero_table=\'group_04_08\') and not hero_notice_use=1 and not hero_notice_use=2 '.$search.' order by hero_today desc, hero_idx desc limit '.$start.','.$list_page.';';
					//echo $sql;
					sql($sql);
				
					while($sql_group                             = @mysql_fetch_assoc($out_sql)){
		?>
		<tr>
			<td><?=$i?></td>
			<td><?=$sql_group['hero_table']?></td>
			<td><?=$sql_group['hero_title']?></td>
			<td><a href="<?=ADMIN_DEFAULT?>/index.php?board=main&idx=59&idx2=<?=$sql_group['hero_idx']?>" class="btn_blue2">사용</a></td>
		</tr>
		<?
					$i--;
					}
				}
			}
		?>
	</tbody>
</table>



<? 
if(strcmp($_POST['kewyword'], '') || strcmp($_GET['kewyword'], '')){
	include_once PATH_INC_END.'page.php';
}
?>
</div>

<div style="float:left;margin:13% 2% 0% 2%;"><img src='/image2/etc/black.png' width='30px;'></div>


<?

if($_GET['idx2'] && !$_POST['kewyword']){
	$idx=$_GET['idx2'];
	$sql = "update mission set hero_notice_use=2 where hero_idx=".$idx."";
	mysql_query($sql);
	echo "<script>alert('오른쪽 테이블에서 사용버튼을 클릭하면 메인에 나타납니다.')</script>";
}
if($_GET['remove'] && !$_POST['kewyword']){
	$remove = $_GET['remove'];
	$sql = "update mission set hero_notice_use=0 where hero_idx=".$remove."";
	mysql_query($sql);
}

if($_GET['use'] && !$_POST['kewyword']){
	$use = $_GET['use'];
	$idx = $_GET['id'];
		if($use==1){
			$sql = "update mission set hero_notice_use=2 where hero_idx=".$idx."";
			mysql_query($sql);
		}elseif($use==2){
			$sql = 'select count(*) from mission where (hero_table=\'group_04_05\' or hero_table=\'group_04_06\' or hero_table=\'group_04_07\' or hero_table=\'group_04_08\') and hero_notice_use=1;';
			//echo $sql;
			sql($sql);
			$count = @mysql_fetch_assoc($out_sql);
			$count = $count['count(*)'];
			//echo $count;
			if($count>=4){
				echo "<script>alert('미션은 4개까지 등록할 수 있습니다.')</script>";
			}else{
				$sql = "update mission set hero_notice_use=1 where hero_idx=".$idx."";
				mysql_query($sql);
			}
		}
}
?>



<div style="float:left;width:47%">
	<div class='mainmain'><p>등록된 두드리다 미션</p></div>

	<table class='t_list'>
		<thead>
			<tr>
				<th width='3%'>NO</th>
				<th width='10%'>종류</th>
				<th width='30%'>제목</th>
				<th width='5%'>사용</th>
				<th width='3%'>사용</th>
				<th width='3%'>취소</th>
				<th width='3%'>제거</th>
			</tr>
		</thead>
		<tbody>
			<?
				$sql = 'select hero_idx, hero_title, hero_notice_use, hero_table from mission where (hero_table=\'group_04_05\' or hero_table=\'group_04_06\' or hero_table=\'group_04_07\' or hero_table=\'group_04_08\') and hero_notice_use=1 or hero_notice_use=2 order by hero_today desc, hero_idx desc;';
				//echo $sql;
				sql($sql);
				$i=0;
				while($sql_group                             = @mysql_fetch_assoc($out_sql)){
			?>
			<tr>
				<td><?=$i+1?></td>
				<td><?=$sql_group['hero_table']?></td>
				<td><?=$sql_group['hero_title']?></td>
				<td>
					<?if($sql_group['hero_notice_use']==1){?>
						<b color="red">사용중</b>
					<?}?>
					</td>
				<td>
					<a href="<?=ADMIN_DEFAULT?>/index.php?board=main&idx=59&use=<?=$sql_group['hero_notice_use']?>&id=<?=$sql_group['hero_idx']?>" class="btn_blue2">사용</a>
				</td>
				<td>
					<a href="<?=ADMIN_DEFAULT?>/index.php?board=main&idx=59&use=<?=$sql_group['hero_notice_use']?>&id=<?=$sql_group['hero_idx']?>" class="btn_blue2">취소</a>
				</td>
				<td><a href="<?=ADMIN_DEFAULT?>/index.php?board=main&idx=59&remove=<?=$sql_group['hero_idx']?>" class="btn_blue2">제거</a></td>
			</tr>
			<?
				$i++;
				}
			?>
		</tbody>
	</table>
</div>
<?
