<?
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
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
$sql = 'select * from hero_group where hero_board = \''.$_GET['board'].'\'';
sql($sql, 'on');
$check_list                             = @mysql_fetch_assoc($out_sql);
?>

	<script>
		function confirm_type(type,location){
	
			if (confirm(type+"하시겠습니까?") == true){    //확인
			    document.location.href=location;
			}else{   //취소
			    return;
			}
			
	    }
	</script>
      <div class="btngroup">
        <div class="btn_r f_c">
            <?
            if(!strcmp($_GET['view'], '')){
                if($check_list['hero_write']<=$my_write){
            ?>
                        <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&view=write&action=write&page=<?=$_GET['page'];?>" class="a_btn2">등록</a>
            <?
                }
            }
            if(strcmp($_GET['view'], '')){
            ?>
                        
            <?
            }
            ?>
            <?
            if( (!strcmp($_GET['view'], 'view')) or (!strcmp($_GET['view'], 'view_new')) ){?>
                <div class="admin_btn">
                <?if( ($my_level>='9999') or (!strcmp($out_row['hero_code'], $_SESSION['temp_code'])) ){
                    $sql = 'select * from review where hero_table = \''.$_GET['board'].'\' and hero_old_idx=\''.$_GET['idx'].'\' order by hero_today desc;';
                    sql($sql, 'on');
                    $review_data = @mysql_num_rows($out_sql);
            ?>
                        <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&next_board=<?=$hero_table?>&view=write&action=update&idx=<?=$_GET['idx'];?>&page=<?=$_GET['page'];?>" class="btn_submit">수정하기</a>
            <?
            ?>
                        <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&next_board=<?=$hero_table?>&view=action&action=delete&code=<?=$out_row['hero_code']?>&table=<?=$out_row['hero_table']?>&idx=<?=$_GET['idx'];?>&page=<?=$_GET['page'];?>" class="btn_delete">삭제하기</a>
            <?
                } ?>
                </div>
            <? } ?>
            <?
            if(!strcmp($_GET['action'], 'write')){
                if($check_list['hero_write']<=$my_write){//btn_write.gif
            ?>
                        <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&view_type=list&page=<?=$_GET['page'];?>" class="btn_submit btn_white">취소하기</a>
                        <a href="#" onclick="javascript:doSubmit(document.frm);" class="btn_submit btn_main_c">등록하기</a>
            <?
                }
            }
            ?>
            <?
            if(!strcmp($_GET['action'], 'update')){
                if( ($my_level>='9999') or (!strcmp($out_row['hero_code'], $_SESSION['temp_code'])) ){
            ?>
                        <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&view_type=list&page=<?=$_GET['page'];?>" class="btn_submit btn_white">취소하기</a>
                        <a href="#" onclick="javascript:doSubmit(document.frm);" class="btn_submit btn_main_c">등록하기</a>
            <?
                }
            }
            ?>
        </div>
      </div>
