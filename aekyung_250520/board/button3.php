<?
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$sql = 'select * from hero_group where hero_board = \''.$_GET['board'].'\'';
sql($sql, 'on');
$check_list                             = @mysql_fetch_assoc($out_sql);
?>
<script>
	function printdiv(printpage){
		var headstr = "<html><head><title></title></head><body>";
		var footstr = "</body>";
		var newstr = document.getElementsByClassName(printpage);
		var printstr = "";

		for (var i = 0; i < newstr.length; i++) {
			printstr += newstr[i].innerHTML;
		}

		var oldstr = document.body.innerHTML;
		
		document.body.innerHTML = headstr+printstr+footstr;
		window.print();
		document.body.innerHTML = oldstr;
		return false;
	}
	
	function confirm_del(location){

		if (confirm("삭제하시겠습니까?") == true){    //확인
		    document.location.href=location;
		}else{   //취소
		    return;
		}
		
    }
	
</script>
      <div class="btngroup">
        <div class="btn_r">
<?
if(!strcmp($_GET['view'], '')){
    if($check_list['hero_write']<=$_SESSION['temp_write']){
?>
            <a href="<?=MAIN_HOME;?>?board=<?=$group_table_name;?>&view=write&action=write&page=<?=$_GET['page'];?>" class="a_btn">글작성</a>
<?
    }
}
if(strcmp($_GET['view'], '')){
?>
            <!-- <a href="<?=MAIN_HOME;?>?board=<?=$group_table_name;?>&page=<?=$_GET['page'];?>&gubun=<?=$_GET['gubun'];?>" class="a_btn2">목록으로</a> -->
            <!--<a href="#" onClick="printdiv('print_area');" class="a_btn">인쇄</a>-->
<?
}if( (!strcmp($_GET['view'], 'view')) or (!strcmp($_GET['view'], 'view_new'))  or (!strcmp($_GET['view'], 'step_test')) ){?>
    <div class="admin_btn">
    <?if( ($_SESSION['temp_level']>='9999') or (!strcmp($board_list['hero_code'], $_SESSION['temp_code'])) ){
?>
            <a href="<?=MAIN_HOME."?".get('view||action','view=write&action=update');?>" class="btn_submit">수정하기</a>
<?
        $sql = 'select * from review where hero_table = \''.$board_list['hero_table'].'\' and hero_old_idx=\''.$_GET['idx'].'\' order by hero_today desc;';
        sql($sql, 'on');
        $review_data = @mysql_num_rows($out_sql);
?>
        <a onclick="confirm_del('<?=MAIN_HOME;?>?board=<?=$group_table_name;?>&next_board=<?=$board_list['hero_table']?>&view=action_delete&action=delete&idx=<?=$_GET['idx'];?>&page=<?=$_GET['page'];?>')" class="btn_delete">삭제하기</a>
<?
//        }
    }?>
    </div>
<?} ?>
<?
if(!strcmp($_GET['action'], 'write')){
    if($check_list['hero_write']<=$_SESSION['temp_write']){//btn_write.gif
?>
            <a href="#" onclick="javascript:on_submit();" class="a_btn2">등록</a>
            <a href="<?=MAIN_HOME;?>?board=<?=$group_table_name;?>&page=<?=$_GET['page'];?>" class="a_btn2">취소</a>
<?
    }
}
?>
<?
if(!strcmp($_GET['action'], 'update')){
    if( ($my_level>='9999') or (!strcmp($board_list['hero_code'], $_SESSION['temp_code'])) ){
?>
            <a href="#" onclick="javascript:on_submit();" class="a_btn2">등록</a>
            <a href="<?=MAIN_HOME.'?'.get('next_board||action||view','view=view');?>" class="a_btn2">취소</a>
<?
    }
}
?>
        </div>
      </div>
        <div class="paging">
<?
if(!strcmp($_GET['view'], '')){
            include_once BOARD_INC_END.'page.php';
}
?>
        </div>