<?
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
$sql = 'select * from hero_group where hero_board = \''.$_GET['board'].'\'';
sql($sql, 'on');
$check_list                             = @mysql_fetch_assoc($out_sql);

if($_GET['page'])	$page= $_GET['page'];
else				$page= 1;

?>
      <div class="btngroup ">
        <div class="btn_r">
			<?
			if(!strcmp($_GET['view'], '') && $_GET['board'] != "mylist" && $_GET['board'] != "myreply" && $_GET['board'] != "search") {
				if($check_list['hero_write']<=$my_write) {
					if($_GET['board']=="group_04_05" || $_GET['board']=="group_04_06" || $_GET['board']=="group_04_09" || $_GET['board']=="group_04_10" || $_GET['board']=="group_04_27" || $_GET['board']=="group_04_28"){
					?>
						<? if($board == "group_04_10") { ?>
						<? } else {?>
							<a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&view=write2&action=write&page=<?=$page;?>" class="btn_submit small btn_main_c">글 작성하기</a>
						<? } ?>
					<?
					} else {
					?>
						<? if($_GET["board"] == "cus_3" || $_GET["board"] == "group_04_35") {?>
							<a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&view=write&action=write&page=<?=$page;?>" class="btn_submit small btn_main_c">문의하기</a>
						<? } else { ?>
							<? if($_GET["board"] == "group_04_29") { ?>
								<? if($loyal_auth || $_SESSION['temp_level'] >= 9999) {?>
									<a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&view=write&action=write&page=<?=$page;?>" class="btn_submit small btn_main_c">글 작성하기</a>
								<? } ?>
							<? } else if($_GET["board"] == "group_04_34" || $_GET["board"] == "group_04_33") { ?>
								<? if($_SESSION['temp_level'] >= 9999) {?>
									<a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&view=write&action=write&page=<?=$page;?>" class="btn_submit small btn_main_c">글 작성하기</a>
								<? } ?>
							<? } else if($_GET["board"] == "group_02_03" || $_GET["board"] == "group_02_10" || $_GET["board"] == "group_04_03") { ?>
								<a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&view=write&action=write&page=<?=$page;?>&oldidx=<?=$idx;?>" class="btn_submit small">글 작성</a>
							<? } else { ?>
								<a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&view=write&action=write&page=<?=$page;?>&oldidx=<?=$idx;?>" class="btn_submit small btn_main_c">글 작성하기</a>
							<? } ?>
						<? } ?>
					<?
					}
				}
			}
			?>
        </div>
<?php if(!strcmp($_GET['view'], 'view') or !strcmp($_GET['view'], 'view_new') or !strcmp($_GET['action'], 'write') or !strcmp($_GET['action'], 'update')){ ?>
        <div class="btn_r">
        <?
        	$view_type = "";
			if(strcmp($_GET['view'], '')){
				//1:1문의만
			    if($_GET['board'] == "cus_3" || $_GET["board"] == "group_04_35") $view_type="&view_type=list";
		?>
            <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?><?=$view_type;?>&page=<?=$_GET['page'];?>" class="btn_submit fz17 fw500">목록으로</a>
		<?
			}
		?>
			<?
			if( (!strcmp($_GET['view'], 'view')) or (!strcmp($_GET['view'], 'view_new')) ){?>
				<div class="admin_btn">
			    <? if( ($my_level>='9999') or (!strcmp($out_row['hero_code'], $_SESSION['temp_code'])) ){
			        $sql = 'select * from review where hero_table = \''.$_GET['board'].'\' and hero_old_idx=\''.$_GET['idx'].'\' order by hero_today desc;';
			        sql($sql, 'on');
			        $review_data = @mysql_num_rows($out_sql);
				?>
			        <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&next_board=<?=$hero_table?>&view=write&action=update&idx=<?=$_GET['idx'];?>&page=<?=$_GET['page'];?>" class="btn_submit">수정하기</a>
				<?
    				$notManToManQ = true;
    				if($_GET['board'] =='cus_3' || $_GET['board'] =='group_04_35') {
    				    $notManToManQ = false;
    				}

    				if( ($my_level>=9999 or !strcmp($review_data, '0')) && $notManToManQ){
				?>
			            <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&next_board=<?=$hero_table?>&view=action&action=delete&code=<?=$out_row['hero_code']?>&table=<?=$out_row['hero_table']?>&idx=<?=$_GET['idx'];?>&page=<?=$_GET['page'];?>" class="btn_delete">삭제하기</a>
				<? } else if($del_use_check == -1) { ?>
			        	<a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&next_board=<?=$hero_table?>&view=action&action=delete&code=<?=$out_row['hero_code']?>&table=<?=$out_row['hero_table']?>&idx=<?=$_GET['idx'];?>&page=<?=$_GET['page'];?>&del_use_check=<?=$del_use_check?>" class="btn_delete">삭제하기</a>
			    <?
			        }
			    }?>
				</div>
			<? } ?>
			<?
			if(!strcmp($_GET['action'], 'write')){
			    if($check_list['hero_write']<=$my_write){//btn_write.gif
				?>

			            <a href="#" onclick="javascript:on_submit();" class="a_btn2">등록</a>
			            <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&page=<?=$_GET['page'];?>" class="a_btn2">취소</a>
				<?
			    }
			}
			?>
			<?
			if(!strcmp($_GET['action'], 'update')){
			    if( ($my_level>='9999') or (!strcmp($out_row['hero_code'], $_SESSION['temp_code'])) ){
			        $sql = 'select * from review where hero_table = \''.$_GET['board'].'\' and hero_old_idx=\''.$_GET['idx'].'\' order by hero_today desc;';
			        sql($sql, 'on');
			        $review_data = @mysql_num_rows($out_sql);
				?>
			            <a href="#" onclick="javascript:on_submit();" class="a_btn2">등록</a>
			            <a href="<?=MAIN_HOME.'?'.get('next_board||action||view','view=view');?>" class="a_btn2">취소</a>
				<?
			    }
			}
			?>
        </div>
<?php }?>
      </div>
              <div class="paging">
<?
if(!strcmp($_GET['view'], '')){
   	include BOARD_INC_END.'page.php';
} else if(!strcmp($_GET['view'], 'missionReview') || !strcmp($_GET['view'], 'greatReview')){
	include_once BOARD_INC_END.'page.php';
}
?>
        </div>
