<?
if(!defined('_HEROBOARD_'))exit;

if(!strcmp($_SESSION['temp_level'], '') || !$_GET['action']){
	error_location('비정상적인 접근입니다. 로그인 후에 다시 시도해 주세요.', '/main/index.php?board=login');exit;
}

if(!$_GET['action'] || !$_GET['view']){
	error_historyBack('비정상적인 접근입니다.');exit;
}

	
	$today = date( "Y-m-d");
	$full_today = date( "Y-m-d H:i:s");

    $my_code 		= 		$_SESSION['temp_code'];
    $my_level 		= 		$_SESSION['temp_level'];
    $my_write 		= 		$_SESSION['temp_write'];
    $my_view 		= 		$_SESSION['temp_view'];
    $my_update 		= 		$_SESSION['temp_update'];
    $my_rev 		= 		$_SESSION['temp_rev'];
    $my_id			=		$_SESSION['temp_id'];
    $my_name		=		$_SESSION['temp_name'];
    $my_nick		=		$_SESSION['temp_nick'];

	$table 			= 		'board';
	
	$idx 			=		$_GET['idx'];
	$action			=		$_GET['action'];
	$board			=		$_GET['board'];
	$page			=		$_GET['page'];
	$next_board		=		$_GET['next_board'];
	$del_use_check 	= 		$_GET["del_use_check"];

	$hero_title	 	= 		$_POST['hero_title'];
	$hero_table		= 		$_POST['hero_table'];
	$command 		= 		$_POST['command'];
	$hero_thumb 	= 		$_POST["hero_thumb"];
	$hero_use 		= 		$_POST["hero_use"];
	$hero_review_use 		= 		$_POST["hero_review_use"];
	$hero_01_bak = $_POST["hero_01_bak"];

	$drop_check 	= 		explode('||', $_POST['hero_drop']);
	$point_type		=		"total";
	$gubun          =		$_POST["gubun"];
	

	if($board == 'group_04_33') $board = 'cus_2';
	if($board == 'group_04_34') $board = 'cus_2';
	if($board == 'group_04_35') $board = 'cus_3';
	
	if($hero_table == 'group_04_33') $hero_table = 'cus_2';
	if($hero_table == 'group_04_34') $hero_table = 'cus_2';
	if($hero_table == 'group_04_35') $hero_table = 'cus_3';
	
	## 본문내용 처리
######################################################################################################################################################
	if(($action=='update' && is_numeric($idx)) || $action=='write'){
		//$command = nl2br(htmlspecialchars($command));
		$command = nl2br($command);
		$command = str_ireplace("<br />", "", $command);//글자 변경
		
		
		$check_img = @explode('&lt;img', $command);
		
		while(list($check_key, $check_val) = @each($check_img)){

			if(!strcmp($check_key, '0'))	continue;
			
		    $check_one = explode('&gt;', $check_val);
		    $check_two = $check_one['0'];
		    $check_end = '&lt;img'.$check_two.'&gt;';
		    if(!strcmp(eregi('naver',$check_end),'1')){
		        error_historyBack("네이버 이미지는 등록하실 수 없습니다.");
		    }
		} 
				
		$command = str_ireplace("temp_".$my_id."_", '', $command);//str_ireplace 대소문자 구분없이 //preg_replace()
		$command = str_ireplace('&lt;a', '&lt;a target=\&quot;_BLANK\&quot;', $command);//대소문자 구분안하고 바꿀때 str_replace
		$command = str_ireplace('onclick', 'on_click', $command);
	
	
		$FILE_NAME = 'hero_board_one';
		$USER_FILE_NAME = $HTTP_POST_FILES[$FILE_NAME]['name'];
		
		$USER_TEMP_FILE_NAME = $HTTP_POST_FILES[$FILE_NAME]['tmp_name'];
		
		$userfile_count = count($USER_FILE_NAME);
		
	
	
	
	## 썸네일 처리
######################################################################################################################################################
		$sql = "select * from board where hero_idx='".$idx."'";
		$board_res = mysql_query($sql);
		
		if(!$board_res){
				
			logging_error($my_code, $board."-ACTION_01 : ".$sql, $full_today);
			error_historyBack("");
				
		}
		
		$list = mysql_fetch_assoc($board_res);
		
		if($hero_thumb && $hero_thumb!=$list["hero_thumb"] && $list["hero_table"] != "group_02_03"){
		    if($list["hero_table"] != "group_04_22") {
    			$dest_file = $_SERVER["DOCUMENT_ROOT"].$hero_thumb;
    		
    			$thumb_path = substr($hero_thumb,0,strripos($hero_thumb,"/")+1);
    			$temp_file = "thum_".substr($hero_thumb,strripos($hero_thumb,"/")+1);
    			$thumb_file = $_SERVER["DOCUMENT_ROOT"].$thumb_path.$temp_file;
    		
    			$im = thumbnail($dest_file, 289, 225);
    			imagejpeg($im, $thumb_file,100);
    			imagedestroy($im);
    		
    			$hero_thumb = $thumb_path.$temp_file;
		    }
		}
	
	
	
	
	## 필요없는 $_POST 제거
######################################################################################################################################################
		while(list($drop_key, $drop_val) = each($drop_check)){
		    unset($_POST[$drop_val]);
		}
	
	}
	
	##	업데이트
######################################################################################################################################################
	if($action=='update' && is_numeric($idx) && $hero_title){

		$sql_one_update = $sql_one_update."hero_command = '".$command."'";

		if(strcmp($first_img, ''))	$sql_one_update .= ", hero_img_new = '".$first_img."'";
		
		if($hero_thumb)						$sql_one_update .= ", hero_thumb = '".$hero_thumb."'";

		if(strcmp($userfile_count,"0")){

			while(list($USER_FILE_NAME_KEY, $USER_FILE_NAME_VAL) = each($USER_FILE_NAME)){
                
				$FILE_LOW = strtolower($USER_FILE_NAME_VAL);//소문자로

				if(strcmp($FILE_LOW,"")){ //파일 업로드 했을때
					$FILE_NEW_NAME= Y_m_d_h_i_s.'_'.$FILE_LOW;

					if(strcmp(is_file(USER_FILE_INC_END.$FILE_NEW_NAME),"1")){
						 
						@copy($USER_TEMP_FILE_NAME[$USER_FILE_NAME_KEY], USER_FILE_INC_END.$FILE_NEW_NAME);
						$sql_one_update .= ", ".$FILE_NAME." = '".$FILE_NEW_NAME."'";
		
						$sql_one_update .= ", hero_board_two = '".$FILE_LOW."'";
					}
				}else { //파일 업로드 안했을때
                    if($_POST['hero_board_two'] == '') {
                        $sql_one_update .= ", ".$FILE_NAME." = ''";

                        $sql_one_update .= ", hero_board_two = ''";
                    }
                }
			}
		}

        unset($_POST["hero_board_two"]);

		if($_POST["hero_notice_use"]) {
			$sql_one_update .= ", hero_notice_use = '".$_POST["hero_notice_use"]."' ";
		} else {
			$sql_one_update .= ", hero_notice_use = '0' ";
		}
		
		unset($_POST["hero_notice_use"]);
		
		if(strlen($_POST["hero_use"]) > 0) {
			$sql_one_update .= ", hero_use = '".$_POST["hero_use"]."' ";
		} else {
			$sql_one_update .= ", hero_use = '1' ";
		}
		
		unset($_POST["hero_use"]);
		
		
		foreach ($_POST as $post_key => $post_val) {
		    if($post_val == 'group_04_35') $post_val = "cus_3";
		    if($post_val == 'group_04_34') $post_val = "cus_2";
		    if($post_val == 'group_04_33') $post_val = "cus_2";

            if($post_key == "b_gubun") continue;
            if($post_key == "m_gubun100") continue;
            if($post_key == "m_gubun200") continue;
            if($post_key == "m_gubun300") continue;
            if($post_key == "s_gubun110") continue;
            if($post_key == "s_gubun120") continue;
            if($post_key == "s_gubun130") continue;
            if($post_key == "s_gubun140") continue;
            if($post_key == "s_gubun150") continue;
            if($post_key == "s_gubun210") continue;
            if($post_key == "s_gubun220") continue;
            if($post_key == "s_gubun310") continue;
		    
			$sql_one_update .= ", ".$post_key."='".$post_val."'";
		}
		
		if(!$_POST["event_notice"]) { //게릴라 이벤트
            $sql_one_update .= ", event_notice='' ";
		}

        //1:1문의 카테고리
        if($_POST['b_gubun'] == '100'){ //체험단
            if($_POST['m_gubun100'] == '110'){
                $sql_one_update .= ", gubun = ".$_POST['s_gubun110'];
            }else if($_POST['m_gubun100'] == '120'){
                $sql_one_update .= ", gubun = ".$_POST['s_gubun120'];
            }else if($_POST['m_gubun100'] == '130'){
                $sql_one_update .= ", gubun = ".$_POST['s_gubun130'];
            }else if($_POST['m_gubun100'] == '140'){
                $sql_one_update .= ", gubun = ".$_POST['s_gubun140'];
            }else if($_POST['m_gubun100'] == '150'){
                $sql_one_update .= ", gubun = ".$_POST['s_gubun150'];
            }
        }else if($_POST['b_gubun'] == '200'){ //이벤트/포인트 페스티벌
            if($_POST['m_gubun200'] == '210'){
                $sql_one_update .= ", gubun = ".$_POST['s_gubun210'];
            }else if($_POST['m_gubun200'] == '220'){
                $sql_one_update .= ", gubun = ".$_POST['s_gubun220'];
            }
        }else if($_POST['b_gubun'] == '300'){ //홈페이지
            if($_POST['m_gubun200'] == '310'){
                $sql_one_update .= ", gubun = ".$_POST['s_gubun310'];
            }
        }else if($_POST['m_gubun100'] == '4'){ //기타
            $sql_one_update .= ", gubun = 4";
        }

		$msg .= '수정 되었습니다.';
		$sql = "UPDATE board SET ".$sql_one_update." WHERE hero_idx = '".$idx."'";
		
		//echo $sql;
		
		$out_sql = mysql_query($sql);
		if(!$out_sql){
			
			logging_error($my_code, $board."-ACTION_02 : ".$sql, $full_today);
			error_historyBack("");
			
		}
		
		
		## 업데이트하면서 필요없어진 파일 삭제 기능 -> 무슨 이유에서인지 주석처리되어 있음.
	######################################################################################################################################################
		/* $drop_action_img = $list['hero_command'];
		$code_main_value = "&lt;img.*src=&quot;(.*)&quot;.*&gt;";
		
		preg_match_all("`$code_main_value`iU", $drop_action_img, $code_main);
		while(list($code_key, $code_val) = @each($code_main[1])){
			if(!strcmp(eregi(USER_PHOTO_END,$code_val),'1')){
				if(!strcmp(eregi($code_val,$command),'1')){
					continue;
				}else{
					$check_file = @str_ireplace(USER_PHOTO_END, USER_PHOTO_INC_END, $code_val);
					//                @unlink($check_file);
				}
			}else{
				continue;
			}
		} */
		
	} else if($action=='write' && $hero_title) {
		
		$duplecateInsertCheck =  " SELECT hero_idx, hero_table FROM board WHERE hero_code='".$my_code."' AND hero_title='".$hero_title."' ";
		$duplecateInsertCheck .= " AND hero_table='".$hero_table."' AND left(hero_today,10)='".$today."'";

		$duplecateInsertCheck_res = mysql_query($duplecateInsertCheck);
		if(!$duplecateInsertCheck_res){
		
			logging_error($my_code, $board."-WRITE_01 : ".$duplecateInsertCheck, $full_today);
			error_historyBack("");
		
		}
		
		$check_rs = mysql_fetch_assoc($duplecateInsertCheck_res);
		
		if($check_rs['hero_idx']){
			$href = "/main/index.php?board=".$check_rs['hero_table']."&next_board=".$check_rs['hero_table']."&page=1&view=view&idx=".$check_rs['hero_idx'];
			error_location('해당 글은 이미 등록되었습니다.',$href );
			exit;
		}
		
		## auto increase check
		######################################################################################################################################################
		$idx_sql = "SHOW TABLE STATUS LIKE 'board'";
		
		$out_idx_sql = mysql_query($idx_sql);
		if(!$out_idx_sql){
			logging_error($my_code, $board."-WRITE_02 : ".$idx_sql, $full_today);
			error_historyBack("");
		}
		
		$idx_list                             = @mysql_fetch_assoc($out_idx_sql);
		
		$idx = $idx_list['Auto_increment'];
		
		

		## 쿼리 셋팅
		######################################################################################################################################################
		
		$sql_one_write .= 'hero_idx, hero_command';
		$sql_two_write .= "'".$idx."', '".$command."'";
		
		if(strcmp($first_img, '')){
			$sql_one_write .= ", hero_img_new";
			$sql_two_write .= ", '".$first_img."'";
		}
		
		if($hero_thumb){
			$sql_one_write .= ", hero_thumb";
			$sql_two_write .= ", '".$hero_thumb."'";
		}
		
		if($hero_table != 'group_04_03') {
    		if(strlen($_POST["hero_review_use"]) > 0) {
    		    $sql_one_write .= ", hero_review_use";
    		    $sql_two_write .= ", '".$_POST["hero_review_use"]."'";
    		} else {
    		    $sql_one_write .= ", hero_review_use";
    		    $sql_two_write .= ", 1 ";
    		}
    		
    		unset($_POST["hero_review_use"]);
		}
		
		foreach ($_POST as $post_key => $post_val) {
			if($post_val == 'group_04_35') $post_val = "cus_3";
			if($post_val == 'group_04_34') $post_val = "cus_2";
			if($post_val == 'group_04_33') $post_val = "cus_2";

            if($post_key == "b_gubun") continue;
            if($post_key == "m_gubun100") continue;
            if($post_key == "m_gubun200") continue;
            if($post_key == "m_gubun300") continue;
            if($post_key == "s_gubun110") continue;
            if($post_key == "s_gubun120") continue;
            if($post_key == "s_gubun130") continue;
            if($post_key == "s_gubun140") continue;
            if($post_key == "s_gubun150") continue;
            if($post_key == "s_gubun210") continue;
            if($post_key == "s_gubun220") continue;
            if($post_key == "s_gubun310") continue;

            $sql_one_write .= ", ".$post_key;
			$sql_two_write .= ", '".$post_val."'";
		}
		
		
		if(strcmp($userfile_count,"0")){
		
			while(list($USER_FILE_NAME_KEY, $USER_FILE_NAME_VAL) = each($USER_FILE_NAME)){
		
				$FILE_LOW = strtolower($USER_FILE_NAME_VAL);//소문자로
				 
				if(strcmp($FILE_LOW,"")){
					$FILE_NEW_NAME= Y_m_d_h_i_s.'_'.$FILE_LOW;
					 
					if(strcmp(is_file(USER_FILE_INC_END.$FILE_NEW_NAME),"1")){
						 
						@copy($USER_TEMP_FILE_NAME[$USER_FILE_NAME_KEY], USER_FILE_INC_END.$FILE_NEW_NAME);
						$sql_one_write .= ", ".$FILE_NAME;
						$sql_two_write .= ", '".$FILE_NEW_NAME."'";
		
						$sql_one_write .= ", hero_board_two";
						$sql_two_write .= ", '".$FILE_LOW."'";
						 
					}
				}
			}
		}

        if($hero_table == 'cus_3'){
            //1:1문의 카테고리
            if($_POST['b_gubun'] == '100'){ //체험단
                if($_POST['m_gubun100'] == '110'){
                    $gubun = $_POST['s_gubun110'];
                }else if($_POST['m_gubun100'] == '120'){
                    $gubun = $_POST['s_gubun120'];
                }else if($_POST['m_gubun100'] == '130'){
                    $gubun = $_POST['s_gubun130'];
                }else if($_POST['m_gubun100'] == '140'){
                    $gubun .= $_POST['s_gubun140'];
                }else if($_POST['m_gubun100'] == '150'){
                    $gubun .= $_POST['s_gubun150'];
                }
            }else if($_POST['b_gubun'] == '200'){ //이벤트/포인트 페스티벌
                if($_POST['m_gubun200'] == '210'){
                    $gubun .= $_POST['s_gubun210'];
                }else if($_POST['m_gubun200'] == '220'){
                    $gubun .= $_POST['s_gubun220'];
                }
            }else if($_POST['b_gubun'] == '300'){ //홈페이지
                if($_POST['m_gubun300'] == '310'){
                    $gubun .= $_POST['s_gubun310'];
                }
            }else if($_POST['m_gubun100'] == '4'){ //기타
                $gubun .= ", 4";
            }

            $sql_one_write .= ", gubun";
            $sql_two_write .= ", '".$gubun."'";
        }

		$sql = "INSERT INTO board (".$sql_one_write.") VALUES (".$sql_two_write.");";

		$pf = mysql_query($sql);
		if(!$pf){
			logging_error($my_code, $board."-WRITE_03 : ".$sql, $full_today);
			error_historyBack("");
			exit;
		}
		
		// 모임후기 처리 2023-02-18
		if($board == 'group_04_22') {
		    $last_board_sql = "select hero_idx from board order by hero_idx desc limit 1";
		    $last_board_res = sql($last_board_sql);
		    $last_board_rs = mysql_fetch_assoc($last_board_res);
		    $last_board_idx = $last_board_rs['hero_idx'];
		    
		    $mission_after_sql = "select hero_old_idx from mission_after where hero_idx=".$hero_01_bak;
		    $mission_after_res = sql($mission_after_sql);
		    $mission_after_rs = mysql_fetch_assoc($mission_after_res);
		    $mission_after_old_idx = $mission_after_rs['hero_old_idx'];
		    
		    $hero_old_idx_value = $last_board_idx.",".$mission_after_old_idx;
		    $mission_after_update = "update mission_after set hero_old_idx ='".$hero_old_idx_value."' where hero_idx=".$hero_01_bak;
		    $pf = mysql_query($mission_after_update);
		}
		
		
		
	 	## href 셋팅
	 	######################################################################################################################################################
	 	if($_POST['hero_03']) 		$wheretogo = $_POST['hero_03'];
	 	else						$wheretogo = $_POST['hero_table'];
	 	
	 	$get_herf = "board=".$wheretogo;
	 	
	 	$point_rs = pointAdd($board, "write", $idx, 0, 0, $hero_title, 'Y' ,$gubun);
	 	
	 	if(substr($point_rs,0,7)=='message'){
	 		$point_rs = explode(":",$point_rs);
	 		message($point_rs[1]);
	 	}elseif($point_rs!=1){
	 	
	 		$rollback_query = "delete from board where hero_idx='".$idx."'";
	 		//echo $rollback_query;
	 		$pf_rollback = mysql_query($rollback_query);
	 		if(!$pf_rollback){
	 			logging_error($my_code, $idx."-WRITE_04 : ".$rollback_query, $full_today);
	 		}
	 		logging_error($my_code, $idx."-WRITE_05 : ".$point_rs, $full_today);
	 		error_historyBack("");
	 		exit;
	 	}
	}
		
	//170710 자주묻는질문 삭제 기능 추가
	if($action == "delete" && $board=="cus_2") {
		$msg = '삭제 되었습니다.';
		$sql = " DELETE FROM board  WHERE hero_idx = '".$idx."'";
		
		//echo $sql;exit;
		
		$out_sql = mysql_query($sql);
		if(!$out_sql){
			logging_error($my_code, $board."-DELETE_01 : ".$sql, $full_today);
			error_historyBack("");
			exit;
		}
		
		if($_GET['board'] == "cus_2") {
		    $get_herf = "board=cus_2";
		} else {
		    $get_herf = "board=group_04_34";
		}
		
		$action_href = PATH_HOME.'?'.$get_herf;
		echo "<script>location.href='".$action_href."'</script>";
		exit;
	}
	
	//1:1문의 답변 없는 경우 삭제 
	if($action == "delete" && $del_use_check==-1 && $board=="cus_3") {
		
		$sql = " SELECT hero_10 FROM board WHERE  hero_idx = '".$idx."'";
		$res = mysql_query($sql);
		$row = @mysql_fetch_assoc($res);//mysql_fetch_row
				
		if(!$row["hero_10"]) {
			$msg = '삭제 되었습니다.';
			
			pointDel($idx,$board,"write");

            // 댓글 삭제 전 데이터 저장 musign 25.07.10 jnr
            // 게시글 삭제 전 데이터 저장
            $board_sql = "SELECT b.hero_code, b.hero_table, b.hero_command, b.hero_today 
              FROM board b 
              WHERE b.hero_idx = '".$idx."'";
            $board_result = @mysql_query($board_sql);
            $board = @mysql_fetch_assoc($board_result);

            if($board) {
                $save_sql = "INSERT INTO board_del 
                 (hero_code, hero_table, hero_command, hero_today, content_type) 
                 VALUES (
                     '".addslashes($board['hero_code'])."',
                     '".addslashes($board['hero_table'])."',
                     '".addslashes($board['hero_command'])."',
                     '".$board['hero_today']."',
                     'board'
                 )";
                @mysql_query($save_sql);
            }
            // 댓글 삭제 전 데이터 저장 E musign 25.07.10 jnr

			$sql = " DELETE FROM board  WHERE hero_idx = '".$idx."'";

			
			$out_sql = mysql_query($sql);
			if(!$out_sql){
				logging_error($my_code, $board."-DELETE_01 : ".$sql, $full_today);
				error_historyBack("");
				exit;
			}
		}
		
		if($_GET['board'] == "cus_3") {
		    $get_herf = "board=cus_3&view_type=list";
		} else {
		    $get_herf = "board=group_04_35&view_type=list";
		}
		
		
		$action_href = PATH_HOME.'?'.$get_herf;
		echo "<script>location.href='".$action_href."'</script>";
		exit;
	}

	if($_POST['hero_table']=='group_04_05' 
	    || $_POST['hero_table']=='group_04_06' 
	    || $_POST['hero_table']=='group_04_27' 
	    || $_POST['hero_table']=='group_04_28') {
	        
	    $wheretogo = 'group_04_09';
	    
	} elseif($_POST['hero_03'])	{
	    $wheretogo = $_POST['hero_03'];
	    
	    if($wheretogo == "cus_2") {
	        if($_GET['board'] == "group_04_33" || $_GET['board'] == "group_04_34") {
	            $wheretogo = $_GET['board']; //musign 수정 group_04_34 -> $_GET['board']
	        }
	    } else if($wheretogo == "cus_3") {
	        if($_GET['board'] == "group_04_35") {
	            $wheretogo = "group_04_35";
	        }
	    }
	} else	{
	    $wheretogo = $_POST['hero_table'];
	    
	    if($wheretogo == "cus_2") {
	        if($_GET['board'] == "group_04_33" || $_GET['board'] == "group_04_34") {
	           $wheretogo = $_GET['board']; //musign 수정 group_04_34 -> $_GET['board']
	        }
	    } else if($wheretogo == "cus_3") {
	        if($_GET['board'] == "group_04_35") {
	            $wheretogo = "group_04_35";
	        }
	    }
	}

	if($_POST['hero_table']=='cus_3') {
	    $view_page = "view_new";
	} else if($_GET['board'] == "group_04_33" || $_GET['board'] == "group_04_34"){ //musign 추가
        $view_page = "";
    } else {
	    $view_page = "view";
	}
	
	$get_herf = "board=".$wheretogo."&page=".$page."&view=".$view_page."&idx=".$idx;
	

    $action_href = PATH_HOME.'?'.$get_herf;
    //20240509 1:1문의 등록 수정 시 리스트 페이지 이동
    if($_GET['board'] == 'group_04_35') {
        echo "<script>location.href='/main/index.php?board=group_04_35&view_type=list'</script>";
    }
    echo "<script>location.href='".$action_href."'</script>";
    //msg($msg,'location.href="'.$action_href.'"');
    exit;
?>