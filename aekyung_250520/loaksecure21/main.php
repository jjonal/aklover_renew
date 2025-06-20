<?
if(!defined('_HEROBOARD_'))exit;
	$pageCheck = $_GET["pageCheck"];
    //musign s
$pageCheck = 'Y';//musign임시
    //musign e
    $sql = 'select * from ' . $hero_table . ' where hero_board = \'' . $board . '\' and hero_use = \'0\' and hero_idx=\'' . $idx . '\'';
    sql($sql);
    $sub_list = @mysql_fetch_assoc($out_sql);

    if(!strcmp($sub_list['hero_depth'], '0')){
		$sub_comma = '';
		$sub_title = '';
    } else {
    	$sub_comma = ' > ';
    	$sub_title = $sub_list['hero_alt'];
    }
?>
                <div class="inner">
                    <? if($main_title) {?>
                    <h3><?=$main_title.$sub_comma.$sub_title;?></h3>
                    <? } ?>
                <div class="cont">
<?
    if(!strcmp($_GET['view'], '')){
    	if($_SESSION['temp_level'] == "9998") {
    		//테스트
    		/*
    		if($_GET["idx"] != "93") {
    			echo "<script>location.href = ".ADMIN_DEFAULT."'/index.php?board=user&idx=93'; </script>";
    			exit;
    		}
    		*/

    		//운영
    		if($_GET["idx"] != "92") {
    		 	echo "<script>location.href = ".ADMIN_DEFAULT."'/index.php?board=user&idx=92'; </script>";
    		 	exit;
    		}

    		if($pageCheck == "Y") echo  "pageName = /user/14.php";
    		include_once "./user/14.php";
    	} else if($_SESSION['temp_level'] == "9997") {
    		//테스트
    		/*
    		if($_GET["idx"] != "96") {
    			echo "<script>location.href = ".ADMIN_DEFAULT."'/index.php?board=user&idx=96'; </script>";
    			exit;
    		}
    		*/

    		//운영
    		if($_GET["idx"] != "93") {
    		 	echo "<script>location.href = '".ADMIN_DEFAULT."/index.php?board=user&idx=93'; </script>";
    			exit;
    		}

    		if($pageCheck == "Y") echo  "pageName = /user/17.php";
    		include_once "./user/17.php";
		} else if($_SESSION['temp_level'] == "9996") {
			if($pageCheck == "Y") echo  "pageName = /global/qnaWrite.php";
    		include_once "./global/qnaWrite.php";
    	} else { //temp_level == 9999
    		if($pageCheck == "Y") echo  "pageName = ".str_inc($sub_list['hero_href']);
        	include_once str_inc($sub_list['hero_href']);
    	}
    }else{
    	if($pageCheck == "Y") echo  "pageName = ".PATH_INC_END.$_GET['board'].'/'.$_GET['view'].'.php';
        include_once PATH_INC_END.$_GET['board'].'/'.$_GET['view'].'.php';
    }
?>
                    </div>
                </div>
<script>
$(document).ready(
	function(){
		$('#breadcrumbs').text('<?=str_inc($sub_list['hero_href'])?>');
	}
);
</script>