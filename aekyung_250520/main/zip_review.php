<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD오픈


######################################################################################################################################################
include_once '../freebest/head.php';
include_once FREEBEST_INC_END.'function.php';

######################################################################################################################################################
	if(!strcmp($_SESSION['temp_level'], '')){
	
		//error_location('비정상적인 접근입니다. 로그인 후에 다시 시도해 주세요.', '/main/index.php?board=login');
		echo "WRONG_SETTING";
		exit;
		 
	}
	
	
######################################################################################################################################################
	$today = date("Y-m-d");
	$full_today = date("Y-m-d H:i:s");
	
	$my_code 		= 		$_SESSION['temp_code'];
	$my_level 		= 		$_SESSION['temp_level'];
	$my_write 		= 		$_SESSION['temp_write'];
	$my_view 		= 		$_SESSION['temp_view'];
	$my_update 		= 		$_SESSION['temp_update'];
	$my_rev 		= 		$_SESSION['temp_rev'];
	$my_id			=		$_SESSION['temp_id'];
	$my_name		=		$_SESSION['temp_name'];
	$my_nick		=		$_SESSION['temp_nick'];
	
	$board			=		$_POST['board'];
	$board_idx		=		$_POST['board_idx'];
	$hero_topfix	=	    $_POST['hero_topFix'];
    $command		=		iconv("UTF-8","CP949", $_POST['command']);
	$mode			=		$_REQUEST['mode'];

	$depth_idx = null;
	$depth_idx_old = null;
	
//리뷰 등록   
######################################################################################################################################################
if(!strcmp($mode,'review_write')){
######################################################################################################################################################

	## 리뷰 등록시 중복 체크
	######################################################################################################################################################
	$error = "REVIEW_WRITE_01";
	$duplecateInsertCheck = "select hero_old_idx, hero_table from review where hero_code='".$my_code."' and hero_command='".$command."' and hero_old_idx='".$board_idx."'";

	$duplecateInsertCheck_res = new_sql($duplecateInsertCheck,$error,"on");

	if((string)$duplecateInsertCheck_res == $error){
	
		echo $error;
		exit;
		//error_historyBack("");
			
	}
	
	$check_rs = mysql_fetch_assoc($duplecateInsertCheck_res);
	
	if($check_rs['hero_old_idx']){
		//$href = "/main/index.php?board=".$check_rs['hero_table']."&next_board=".$check_rs['hero_table']."&page=1&view=view&idx=".$check_rs['hero_old_idx'];
		//location('해당 글은 이미 등록되었습니다.',$href );
		echo "REGISTERED";
		exit;
	}	
	
	
	## review 테이블의 auto increase idx
	######################################################################################################################################################
	$error = "REVIEW_WRITE_02";
	$auto_sql = "SHOW TABLE STATUS LIKE 'review'";
    
    $out_auto_sql = new_sql($auto_sql,$error,"on");
    if((string)$out_auto_sql==$error){
    	echo $error;
    	exit;
    	//error_historyBack("");
    }
    
    $auto_list                               = mysql_fetch_assoc($out_auto_sql);
    
    $next_idx = $auto_list['Auto_increment'];
    
    
    
    ## 첫 댓글의 경우
	######################################################################################################################################################
    if(!$_POST['depth_idx'] && !$_POST['depth_idx_old']){
    	$old_idx 			=	$next_idx;
    	$top_old_idx 		=	$next_idx;
    	
    	## depth
    	$hero_create_depth 	=	0;
    
     ## 댓글의 댓글인 경우
    }elseif($_POST['depth_idx'] && $_POST['depth_idx_old']){
    	$old_idx 			=	$_POST['depth_idx']; 
    	$top_old_idx 		=	$_POST['depth_idx_old']; 
    	
    	
    	## depth
    	$error = "REVIEW_WRITE_03";
    	$review_depth_sql = "select hero_depth, hero_code from review where hero_idx='".$old_idx."'";

    	
    	$out_review_depth = new_sql($review_depth_sql,$error);
    	if((string)$out_review_depth==$error){
    		echo $error;
    		exit;
    		//error_historyBack("");
    	}
    	
    	$review_depth_list                             = mysql_fetch_assoc($out_review_depth);
    	$hero_create_depth = $review_depth_list['hero_depth']+1;

        $review_hero_code_sql = "select hero_nick from member where hero_code='".$review_depth_list['hero_code']."'";
        $review_hero_code = new_sql($review_hero_code_sql,$error);
        if((string)$review_hero_code==$error){
            echo $error;
            exit;
            //error_historyBack("");
        }
        $parentName                                    = mysql_fetch_assoc($review_hero_code);
        $command = 'SS$$SS' . $parentName['hero_nick'] . 'SS$$SS' . $command;
        //$command = htmlspecialchars($command);
    	//에러
    }else{
    	echo "WRONG_SETTING";
    	exit;
    }

    #########################################################################################
    $error = "REVIEW_WRITE_04";
    $sql_one_write = "hero_idx, hero_old_idx, hero_code, hero_name, hero_command, hero_table, hero_depth, hero_depth_idx, hero_depth_idx_old, hero_today, hero_topfix";
    $sql_two_write = "'".$next_idx."', '".$board_idx."', '".$my_code."', '".$my_name."', '".$command."', '".$board."', '".$hero_create_depth."', '".$old_idx."', '".$top_old_idx."', '".$full_today."', '".$hero_topfix."'";
    $sql = 'INSERT INTO review ('.$sql_one_write.') VALUES ('.$sql_two_write.');';

    $pf_review = new_sql($sql,$error);
    if((string)$pf_review==$error){
    	echo $error;
    	exit;
    }
    
    ## 포인트 부여 및 등업기능//테이블, 타입, 글번호, 리뷰번호, 제목, 최대포인트 포함여부
	######################################################################################################################################################
    $point_rs = pointAdd($board, "review", $board_idx ,0 ,$next_idx, $command, 'Y');
    
    if(substr($point_rs,0,7)=='message'){
	    echo iconv('EUC-KR', 'UTF-8', $point_rs); //등업시
	    exit;
	}elseif($point_rs!=1){
		$error = "REVIEW_WRITE_05";
    	$rollback_query = "delete from review where hero_idx='".$next_idx."'";
    	$pf_rollback = new_sql($rollback_query,$error);
    	if((string)$pf_rollback==$error){
    		echo $error;
    	}
		echo $point_rs;
		exit;    
    }

    echo 1;
    exit;    
    
}

######################################################################################################################################################
elseif(!strcmp($mode,'review_edit')){
######################################################################################################################################################
	
	if(!$_POST["depth_idx"]){
		echo 0;
		exit;
	}
	$error = "REVIEW_EDIT_01";

    $review_command_sql = "SELECT hero_command FROM review WHERE hero_idx = '".$_POST["depth_idx"]."'";
    sql ( $review_command_sql, 'on' );

    while ( $review_command_row = @mysql_fetch_assoc ( $out_sql ) ) {
        $commandArray = explode('SS$$SS', $review_command_row['hero_command']);
        
        if($commandArray[1]) { //대댓글
            $parentName = $commandArray[1];
            $command =  'SS$$SS'.$parentName.'SS$$SS'.$command;
        }
    }


	$sql_one_update = "hero_command='".$command."'";
    $sql = "UPDATE review SET ".$sql_one_update." WHERE hero_idx = '".$_POST["depth_idx"]."'";
    $edit_pf = new_sql($sql,$error,"on");
    
    if((string)$edit_pf==$error){
    	echo $error;
    	exit;
    }
    echo 1;
    exit;
    
######################################################################################################################################################
}else if(!strcmp($mode,'review_drop')){
######################################################################################################################################################
	if(!$_POST["depth_idx"]){
		echo 0;
		exit;
	}
	
	//프로세스 순서 해당 포인트 삭제 -> 해당 글 삭제
	$result = pointDel($_POST["depth_idx"],"","review");

	$error = "REVIEW_DROP_01";
	$delete_review = "DELETE FROM review where hero_idx = '".$_POST["depth_idx"]."'";
	$out_point = new_sql($delete_review, $error);
		
	if((string)$out_point == $error){
		echo $error;
		exit;
	}
	
	
	
	/*	
	$error = "REVIEW_DROP_03";
	$point_sql = "DELETE FROM point WHERE hero_review_idx = '".$_POST["depth_idx"]."'";
	$out_point = new_sql($point_sql,$error);

	if((string)$out_point == $error){
		echo $error;
		exit;
	}
		
	$error = "REVIEW_DROP_04";
	$member_total_sql = "select SUM(hero_point) as member_total from point where hero_code='".$review_code."'";
	$out_point = new_sql($member_total_sql, $error);
		
	if((string)$out_point == $error){
		echo $error;
		exit;
	}
		
	$total_point = mysql_result($out_point,0,0);
	
	$sql = "UPDATE member SET hero_point='".$total_point."' WHERE hero_code = '".$review_code."'";
	@mysql_query($sql);
	*/

	echo $result;
	exit;
	
######################################################################################################################################################
}

?>