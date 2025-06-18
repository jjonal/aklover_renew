<?php include_once "head.php"; ?>

<link href="css/general.css" rel="stylesheet" type="text/css">

	<link href="editor_new/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="editor_new/css/froala_editor.min.css" rel="stylesheet" type="text/css">
    <link href="editor_new/css/froala_style.min.css" rel="stylesheet" type="text/css">

<?
if(!strcmp($_GET['next_board'],"hero")){
    $hero_table = 'hero';
}else{
    $hero_table = $_REQUEST['board'];
}

$sql = 'select * from board where hero_table = \''.$hero_table.'\' and hero_idx=\''.$_GET['idx'].'\';';
sql($sql, 'on');
    $out_row = @mysql_fetch_assoc($out_sql);//mysql_fetch_row

    if(!strcmp($_GET['action'], 'update')){
        $code = $out_row['hero_code'];
        $name = $out_row['hero_name'];
        $nick = $out_row['hero_nick'];
        $totay = $out_row['hero_today'];
        $review_count = $out_row['hero_review_count'];
    }else if(!strcmp($_GET['action'], 'write')){
        $code = $_SESSION['temp_code'];
        $name = $_SESSION['temp_name'];
        $nick = $_SESSION['temp_nick'];
        $totay = Ymdhis;
        $review_count = '0';
    }else{
        echo '<script>location.href="./out.php"</script>';
        exit;
    }
    
######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list = @mysql_fetch_assoc($out_sql);
$pk_sql = 'select * from level where hero_level = \''.$_SESSION['temp_level'].'\'';
$out_pk_sql = mysql_query($pk_sql);
$pk_row = @mysql_fetch_assoc($out_pk_sql);
?>

<script>
//공지사항에서 처음에 개별선택으로 선택되도록 조정 2014-06-23
	$(document).ready(function(){
			var hero_table = $('input[name=hero_table]').val();
			if(hero_table!='hero'){
				$('#chkbox2').attr('checked','checked');	
				$('input[name=hero_notice]').val("1");
			}
	});
</script>

<!--컨텐츠 시작-->
<div id="title"><p>등록</p></div>
     
<div><img src="img/shadow1.jpg" alt="" width="100%" height="2px"/></div>

<div style="padding:20px;"> 

	<form name="frm" class="form-horizontal" role="form" enctype="multipart/form-data" method="post" action="action.php?board=<?=$_GET['board'];?>&next_board=<?=$_GET['next_board'];?>&view=action&action=<?=$_GET['action'];?>&idx=<?=$_GET['idx'];?>&page=<?=$_GET['page'];?>">
		<input type="hidden" name="hero_drop" value="hero_drop||command||chkbox||hero_board_one[]">
		<input type="hidden" name="hero_code" value="<?=$code;?>">
		<input type="hidden" name="hero_review" value="<?=$code;?>">
		<input type="hidden" name="hero_today" value="<?=$totay;?>">
		<input type="hidden" name="hero_ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
		<input type="hidden" name="hero_review_count" value="<?=$review_count?>">
		<input type="hidden" name="hero_name" id="hero_name" title="작성자" value="<?=$name;?>" readonly/>
<?php
if(!strcmp($_GET['board'], 'group_04_10')){
?>
		<input type="hidden" name="hero_02" value="1">
<?
}

if(!strcmp($out_row['hero_table'], '')){
    $new_table = $_GET['board'];
    $new_notice = '0';
    $old_table = $_GET['board'];
    $old_notice = '0';
}else{
    $new_table = $out_row['hero_table'];
    $new_notice = $out_row['hero_notice'];

    $old_table = $out_row['hero_03'];
    $old_notice = $out_row['hero_notice'];

    if(!strcmp($out_row['hero_table'], 'hero')){
        $hero_checked_01 = ' checked';
        //$hero_checked_font_01 = ' style="color:red;font-weight:bold"';
        //$hero_checked_02 = ' disabled';
    }else if(!strcmp($out_row['hero_notice'], '1')){
        //$hero_checked_font_02 = ' style="color:red;font-weight:bold"';
        //$hero_checked_01 = ' disabled';
        $hero_checked_02 = ' checked';
    }
}

if( (!strcmp($_SESSION['temp_level'], '99')) or (!strcmp($_SESSION['temp_level'], '100')) ){
?>
                        <input type="hidden" name="hero_table" value="<?=$new_table;?>">
                        <input type="hidden" name="hero_notice" value="<?=$new_notice;?>">
<? }else{ ?>
                        <input type="hidden" name="hero_table" value="<?=$new_table;?>">
                        <input type="hidden" name="hero_notice" value="<?=$new_notice;?>">

<?
}
?>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="hero_title">제목</label>
		<div class="col-sm-10">		
			<input type="text" name="hero_title" id="hero_title" title="제목" value="<?=$out_row['hero_title'];?>" class="form-control"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="hero_nick">작성자</label>
		<div class="col-sm-10">		
			<input type="text" name="hero_nick" id="hero_nick" title="작성자" value="<?=$nick;?>" readonly class="form-control"/>
		</div>
	</div>
<?
   if( (!strcmp($_SESSION['temp_level'], '99')) or (!strcmp($_SESSION['temp_level'], '100')) ){
?>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="chkbox2">기타</label>
		<div class="col-sm-10">		

            <input type="radio" id="chkbox" onClick='javascript:change("chkbox")'<?=$hero_checked_01?>><span id="hero_all"<?=$hero_checked_font_01?>>전체</span>
            <script>
            	function change(inputID){
                        var f = document.getElementById(inputID);
                        var chkbox_01 = document.forms.frm.elements.chkbox;
                        var chkbox_02 = document.forms.frm.elements.chkbox2;
                        var all = document.getElementById("hero_all");
                        var each = document.getElementById("hero_each");
                            if(inputID == "chkbox"){
                                if(f.checked == true){
									<?if(!strcmp($_SESSION['temp_level'], '99')){?>
                                    	//chkbox_02.disabled = true;
									<?}?>
									chkbox_02.checked = false;
                                    document.forms.frm.elements.hero_table.value="hero";
                                    document.forms.frm.elements.hero_notice.value="0";
                                   // all.style.color="red";
                                   // all.style.fontWeight="bold";
									//each.style.color="";
                                   // each.style.fontWeight="";
                                }else{
									<?if(!strcmp($_SESSION['temp_level'], '99')){?>
                                    //chkbox_02.disabled = false;
									<?}?>
									chkbox_02.checked = false;
                                    document.forms.frm.elements.hero_table.value="<?=$old_table?>";
                                    document.forms.frm.elements.hero_notice.value="0";
                                    //all.style.color="";
                                    //all.style.fontWeight="";
									//each.style.color="";
                                    //each.style.fontWeight="";
                                }
                            }else if(inputID == "chkbox2"){
                                if(f.checked == true){
                                    //chkbox_01.disabled = true;
									chkbox_01.checked = false;
                                    document.forms.frm.elements.hero_table.value="<?=$old_table?>";
                                    document.forms.frm.elements.hero_notice.value="1";
                                    //each.style.color="red";
                                    //each.style.fontWeight="bold";
									//all.style.color="";
                                    //all.style.fontWeight="";
                                }else{
                                    //chkbox_01.disabled = false;
									chkbox_01.checked = false;
                                    document.forms.frm.elements.hero_table.value="<?=$old_table?>";
                                    document.forms.frm.elements.hero_notice.value="0";
                                    //each.style.color="";
                                    //each.style.fontWeight="";
									//all.style.color="";
                                   // all.style.fontWeight="";
                                }
                            }
                        }
                        </script>
<?
if(!strcmp($_SESSION['temp_level'], '99')){
?>
   <input type="radio" id="chkbox2" onClick='javascript:change("chkbox2")'<?=$hero_checked_02?>><span id="hero_each"<?=$hero_checked_font_02?>>개별</span>
<?
	$old_title_sql = 'select * from hero_group where hero_board =\''.$old_table.'\';';
	$out_old_title = mysql_query($old_title_sql);
	$old_title_list                             = @mysql_fetch_assoc($out_old_title);
	echo '<font color="orange">'.$old_title_list['hero_title'].'</font>';
}
?>
		</div>
	</div>	
<?
   }//if( (!strcmp($_SESSION['temp_level'], '99')) or (!strcmp($_SESSION['temp_level'], '100')) ){
?>	
	<div class="form-group">
		<label class="col-sm-2 control-label" for="command">내용</label>
		<div class="col-sm-10">	
		
			<textarea class="form-control" rows="10" name="command" value="<?=$out_row['hero_command'];?>"></textarea>	
			
		</div>
	</div>	
	<div class="form-group">
		<label class="col-sm-2 control-label">사진</label>
		<div class="col-sm-10">	
		
			<input type="file" name="image1">	
			
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">사진2</label>
		<div class="col-sm-10">	
		
			<input type="file" name="image2">	
			
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">사진3</label>
		<div class="col-sm-10">	
		
			<input type="file" name="image3">	
			
		</div>
	</div>		
<?
if( (!strcmp($_REQUEST['board'], 'group_04_05')) or (!strcmp($_REQUEST['board'], 'group_04_06')) or (!strcmp($_REQUEST['board'], 'group_04_07')) or (!strcmp($_REQUEST['board'], 'group_04_08')) or (!strcmp($_REQUEST['board'], 'group_04_09')) ){
?>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="hero_title">URL</label>
		<div class="col-sm-10">		
			<br>URL은 한줄에 하나씩 전체 주소(HTTP:// 또는 HTTPS://)를 넣어주세요
			<textarea id="hero_04" name="hero_04" class="form-control"/><?=$out_row['hero_04'];?></textarea>
		</div>
	</div>
<?php
}
?>		
	<div class="form-actions">
			<button type="button" class="btn btn-primary" onclick="doSubmit(this.form);">등록</button>
			<button type="button" class="btn btn-warning" onclick="history.go(-1);">취소</button>
	</div>	
</form>
</div>
<div class="clear"></div>
<script type="text/javascript">
    function doSubmit (theform){
        var title = theform.hero_title;
        var name = theform.hero_nick;
        var cmd = theform.command;

        if(title.value == ""){
            alert("제목을 입력하세요.");
            title.style.border = '1px solid red';
            title.focus();
            return false;
        }else{
            title.style.border = '';
        }

        theform.submit();
        return false;
    }
</script>
<script src="editor_new/js/froala_editor.min.js"></script>
<!--[if lt IE 9]>
	<script src="editor/js/froala_editor_ie8.min.js"></script>
<![endif]-->


  <script src="editor_new/js/plugins/tables.min.js"></script>
  <script src="editor_new/js/plugins/lists.min.js"></script>
  <script src="editor_new/js/plugins/colors.min.js"></script>
  <script src="editor_new/js/plugins/font_family.min.js"></script>
  <script src="editor_new/js/plugins/font_size.min.js"></script>
  <script src="editor_new/js/plugins/block_styles.min.js"></script>
  <script src="editor_new/js/plugins/media_manager.min.js"></script>
  <script src="editor_new/js/plugins/video.min.js"></script>
  <script src="editor_new/js/plugins/char_counter.min.js"></script>
  <script src='editor_new/js/langs/ko.js'></script>

<script>
		$(function(){
				$('#command').editable({inlineMode: false, buttons: ['insertImage','bold', 'italic', 'undo','redo']},{language: 'ko'}).editable("option", "height", 140);
		});
</script>
<!--컨텐츠 종료-->
<?include_once "tail.php";?>