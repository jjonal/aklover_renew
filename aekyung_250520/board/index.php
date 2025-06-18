<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
//border:1px solid #000000;
######################################################################################################################################################
//include BOARD_INC_END.'top.php';
$sql = 'select * from hero_group where hero_board = \''.$_GET['board'].'\';';
$sql = out($sql);
sql($sql);
$list_top = @mysql_fetch_assoc($out_sql);

if( (!strcmp($list_top['hero_type'], 'html')) or (!strcmp($list_top['hero_type'], 'type_09')) or (!strcmp($list_top['hero_type'], 'default'))){
    if((!strcmp($list_top['hero_board'], 'group_04_33')) or (!strcmp($list_top['hero_board'], 'group_04_34')) or (!strcmp($list_top['hero_board'], 'group_04_35'))) {
        if((!strcmp($_GET['view'], 'write')) or (!strcmp($_GET['view'], 'modify'))){
            if($pageCheck == "Y") echo "board page=".BOARD_INC_END.'write.php';
            include BOARD_INC_END.'write.php';
        } else if(!strcmp($_GET['view'], 'action') || !strcmp($_GET['view'], 'action2')){
            if($pageCheck == "Y") echo "board page=".BOARD_INC_END.$_GET['view'].'.php';
            include BOARD_INC_END.$_GET['view'].'.php';
        } else {
            if($pageCheck == "Y") echo "board page=".str_inc($list_top['hero_inc']);
            include str_inc($list_top['hero_inc']);
        }
    } else {
        if($pageCheck == "Y") echo "board page=".str_inc($list_top['hero_inc']);
        include str_inc($list_top['hero_inc']);
    }
}else{
    if(!strcmp($_GET['view'], '')){
            //AK 모임후기
    	if($_GET["board"]=="group_04_22" && !$_GET["idx"]) 	{
            if($pageCheck == "Y") echo "board page=".BOARD_INC_END.$list_top['hero_type'].'/list2.php';
            include BOARD_INC_END.$list_top['hero_type'].'/list2.php';
    	} else {
            if($pageCheck == "Y")
            echo "board page=".BOARD_INC_END.$list_top['hero_type'].'/list.php';
            include BOARD_INC_END.$list_top['hero_type'].'/list.php';
    	}
    }else if(!strcmp($_GET['view'], 'view')){
######################################################################################################################################################
        if(!strcmp($list_top['hero_type'], 'thumbnail_02')){
            if($pageCheck == "Y") echo "board page=".BOARD_INC_END.$list_top['hero_type'].'/view.php';
            include BOARD_INC_END.$list_top['hero_type'].'/view.php';
        } else if(!strcmp($list_top['hero_type'], 'thumbnail_06')){
            if($pageCheck == "Y") echo "board page=".BOARD_INC_END.$list_top['hero_type'].'/view.php';
            include BOARD_INC_END.$list_top['hero_type'].'/view.php';
        }else{
            if($pageCheck == "Y") echo "board page=".BOARD_INC_END.$_GET['view'].'.php';
            include BOARD_INC_END.$_GET['view'].'.php';
        }
    ##글등록폼1
######################################################################################################################################################
    }else if( (!strcmp($_GET['view'], 'write')) or (!strcmp($_GET['view'], 'modify')) ){
        if($pageCheck == "Y") echo "board page=".BOARD_INC_END.'write.php';
        include BOARD_INC_END.'write.php';
    }

    ##글등록폼2
######################################################################################################################################################
    else if(!strcmp($_GET['view'], 'write2')){
        if($pageCheck == "Y") echo "board page=".BOARD_INC_END.'write2.php';
        include BOARD_INC_END.'write2.php';

    }

    else if(!strcmp($_GET['view'], 'action') || !strcmp($_GET['view'], 'action2')){
        if($pageCheck == "Y") echo "board page=".BOARD_INC_END.$_GET['view'].'.php';
        include BOARD_INC_END.$_GET['view'].'.php';
    }

    else{
        if($pageCheck == "Y") echo "board page=".BOARD_INC_END.$list_top['hero_type'].'/'.$_GET['view'].'.php';
        include BOARD_INC_END.$list_top['hero_type'].'/'.$_GET['view'].'.php';
    }
}

//include BOARD_INC_END.'tail.php';
?>


<!-- /board/index.php 파일 내 작성 -->
<link rel="stylesheet" type="text/css" href="/css/front/board.css" />