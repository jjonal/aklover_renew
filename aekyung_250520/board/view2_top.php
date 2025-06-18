<?php 
## 2015-03 개발 김태준
	
	define('_HEROBOARD_', TRUE);//HEROBOARD오픈

	if(is_numeric($_GET['idx']))	$idx = $_GET['idx'];
	else							error_location('잘못된 접근입니다', '/main/index.php');
	
	$board 		 = 		$_GET['board'];
	//일반미션, 프리미엄미션, 애경박스의 경우 -> 생생후기
	//160504 휘슬클럽추가
	if($board=="group_04_05" || $board=="group_04_06" || $board=="group_04_07" || $board=="group_04_23" || $board=="group_04_27" || $board=="group_04_28"){
		$board = "group_04_09";
	}
	$code 		 = 		$_SESSION['temp_code'];
	$fulltoday 	 = 		date("Y-m-d H:i:s");
	$today 		 = 		substr($fulltoday,0,10);
	
	
	##메인 쿼리
	######################################################################################################################################################
	$error="VIEW2_TOP_01";
	$board_sql = "select A.*, B.hero_view as group_view, B.hero_title as group_title, B.hero_view_point as group_view_point, B.hero_right as group_right, B.hero_top_title as group_top_title ";
	$board_sql .= "from board A, hero_group B where A.hero_idx = '".$_GET['idx']."' and B.hero_board='".$board."'";

	$sql_res = new_sql($board_sql,$error,"on");

	if((string)$sql_res==$error){
		error_historyBack("");
		exit;
	}
	
	$board_list                            = mysql_fetch_assoc($sql_res);
	
	if(!$board_list['hero_idx']){
		error_historyBack("잘못된 접근입니다.");
		exit;
	}
	
	
	//권한
	if($board_list['group_view'] > $_SESSION['temp_view']){
	
		if(!strcmp($_SESSION['temp_level'], '0'))		$action_href = PATH_HOME.'?board=login';
		else											$action_href = PATH_HOME.'?'.get('view');
	
		msg('권한이 없습니다.','location.href="'.$action_href.'"');
		exit;
	}
	
	
	if($_GET['type']=='recommand'){
		$recom_rs = recommand();
		
		if(substr($recom_rs,0,7)=='message'){
			$message = explode($recom_rs,":");
		}elseif($recom_rs!=1){
			error_historyBack("");
			exit;
		}elseif($recom_rs==1){
			message("추천하였습니다.");		
		}
		
	}
	
	if($_GET['type']=='report'){
		$report_rs = report();
	
		if(substr($report_rs,0,7)=='message'){
			$message = explode(":",$report_rs);
			message($message[1]);
		}elseif($report_rs!=1){
			error_historyBack("");
			exit;
		}elseif($report_rs==1){
			message("신고하였습니다.");
		}
	}
	
	
	
	##블로그 주소 처리
######################################################################################################################################################
	##한국어 제거
	if($board_list['hero_04']) {
		$blog_options = remove_kr($board_list['hero_04']);
	}else {
		$blog_options = remove_kr($board_list['blog_url']).remove_kr($board_list['cafe_url']).remove_kr($board_list['sns_url']).remove_kr($board_list['etc_url']);
	}
	
	$blog_options = str_ireplace("http:","http:",$blog_options);
	$blog_options = str_ireplace("https:","https:",$blog_options);
	##주소값 배열 처리
	$blog_options = check_blog($blog_options);


	######################################################################################################################################################
	$error="VIEW2_TOP_02";
	$pk_sql = "select A.hero_id, A.hero_level, A.hero_nick, A.hero_idx, B.hero_img_new from member as A, level as B where B.hero_level = A.hero_level and A.hero_code = '".$board_list['hero_code']."'";

	$out_pk_sql = new_sql($pk_sql,$error);

	if((string)$out_pk_sql==$error){
			error_historyBack("");
			exit;
	}

	$pk_row                             = mysql_fetch_assoc($out_pk_sql);
	
	?>
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Type" content="text/html; charset=<?=OLDSET;?>" />
		<meta name="Keywords" content="<?=$hero_alt['1'];?>" />
        <meta property="og:type" content="website" /> 
        <meta property="og:title" content="<?=$sns_title?>" /> 
        <meta property="og:image" content="<?=$sns_image?>" /> 
        <meta property="og:description" content="" /> 
        <meta property="og:site_name" content="<?=$hero_alt['0'];?>" /> 
        <meta property="og:url" content="<?=$link?>" />
        

        <link rel="stylesheet" type="text/css" href="http://aklover.co.kr/css/general2.css?version==00000004"/>

		<script type="text/javascript" src="http://aklover.co.kr/js/jquery.min.js"></script>
		<script type="text/javascript" src="http://aklover.co.kr/js/head.js"></script>
		<script type="text/javascript" src="http://aklover.co.kr/js/common.js"></script>
		
		<?//ie 8인 경우
		if( strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 8.0') !== FALSE) echo "<script src='http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js'></script>";
		?>
		
	</head>
	<body>
		<style>
			
		</style>
		
		<div id="view_link_headerWrap">
			<div id="view_link_header">
				<h1><a href="http://www.aklover.co.kr" target="_parent"><img src="/image2/etc/logo.png" alt="aklover logo" width="139" height="88" border="0"></a></h1>
				<ul>
					<li class="view_link_nick"><img src="<?=str($pk_row[hero_img_new])?>"/><?=$pk_row['hero_nick'] ?></li>
					<li class='view_link_title'><?=$board_list['hero_title'] ?></li>
					<li>|&nbsp;<?=date("Y.m.d", strtotime($board_list['hero_today'])) ?>&nbsp;|</li>
                    <? 
						$mission_sql = "SELECT A.hero_idx AS board_idx, B.hero_type, B.hero_idx, C.hero_idx as review_idx FROM board A 
										LEFT JOIN mission B ON A.hero_01 = B.hero_idx
										LEFT JOIN mission_review C ON A.hero_code = C.hero_code
										WHERE A.hero_idx = '".$_GET['idx']."' AND
											  A.hero_01 = C.hero_old_idx
										LIMIT 1";
						$mission_sql_res = mysql_query($mission_sql);
						$mission_type = mysql_fetch_array($mission_sql_res);
						
					?>
                    
					<?php if($_SESSION['temp_level']>=9999 || ($_SESSION['temp_id']==$pk_row['hero_id'] && $_SESSION['temp_id'])){?>
                    	<? if($mission_type['hero_type'] == 2) { ?>
                            <li class="pointer" onclick="parent.location.href='<?=MAIN_HOME;?>?board=group_04_05&idx=<?=$mission_type['hero_idx']?>&view=step_02_01&hero_idx=<?=$mission_type['review_idx']?>&somun=Y&board_idx=<?=$mission_type['board_idx']?>'"><img src="/image2/etc/blog_link_modi.gif"></li>
                            <li class="pointer" onclick="confirmAction('삭제하시겠습니까?', '<?=MAIN_HOME;?>?board=group_04_05&view=step_02&idx=<?=$mission_type['hero_idx']?>&&type=drop&hero_idx=<?=$mission_type['review_idx']?>', parent)"><img src="/image2/etc/blog_link_del.gif"></li>
                        <? }else { ?>
                            <li class="pointer" onclick="parent.location.href='<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&view=write2&action=update&page=<?=$_GET['page'];?>&hero_idx=<?=$_GET['idx']?>'"><img src="/image2/etc/blog_link_modi.gif"></li>
                            <li class="pointer" onclick="confirmAction('삭제하시겠습니까?', '<?=MAIN_HOME;?>?board=<?=$_GET['board']?>&view=action_delete&action=delete&idx=<?=$_GET['idx'];?>&page=<?=$_GET['page'];?>', parent)"><img src="/image2/etc/blog_link_del.gif"></li>
                        <? } ?>
					<?php }?>
					<?php
						$recom_report_sql = "select * from (select count(*) as recom_count from hero_recommand where hero_recommand_code = '".$_SESSION['temp_code']."' and hero_board_idx = '".$_GET['idx']."') as A, (select count(*) as report_count from hero_report where hero_report_code = '".$_SESSION['temp_code']."' and hero_board_idx = '".$_GET['idx']."') as B ";
						$recom_report_res = mysql_query($recom_report_sql) or die("<script>alert('시스템 에러로 추천에 실패하였습니다. 다시 시도해 주세요. 에러코드 : RECOMMAND_REPORT_01');location.href='/main/index.php'</script>");
						$recommand_count = mysql_result($recom_report_res,0,0);
						$report_count = mysql_result($recom_report_res,0,1);
						
						if($_SESSION['temp_code']){
							if(($_SESSION['temp_id']!=$pk_row['hero_id'] && $_SESSION['temp_id']) && $recommand_count==0){
					?>
								<!--li class="pointer" onclick="confirmAction('추천하시겠습니까?', '<?=MAIN_HOME;?>?board=<?=$_GET['board']?>&view=<?=$_GET['view']?>&idx=<?=$_GET['idx'];?>&page=<?=$_GET['page'];?>&type=recommand', document)"><img src="/image2/etc/like_new.jpg"></li-->
							<?php 
							}
							if(($_SESSION['temp_id']!=$pk_row['hero_id'] && $_SESSION['temp_id']) && $report_count==0){
							?>	
								<!--li class="pointer" onclick="confirmAction('신고하시겠습니까?', '<?=MAIN_HOME;?>?board=<?=$_GET['board']?>&view=<?=$_GET['view']?>&idx=<?=$_GET['idx'];?>&page=<?=$_GET['page'];?>&type=report', document)"><img src="/image2/etc/btn_report_new.jpg"></li-->
					<?php }}?>
				</ul>
				
				<p>사랑과 존경의 AK LOVER</p>
				
					<select id="blog_option">
						<?php 
							foreach($blog_options as $blog_option){
								foreach($blog_option as $key => $value){
									if($key){
										echo "<option value='".$value."'>".$key."</option>";
									}
								}						
							} 			
								
						?>
					</select>
			</div>
		</div>
		
	</body>
	
	<script>

	$(document).ready(function(){
		
		<?php
			if($blog_options[0]){
				$keys = array_keys($blog_options[0]);
				echo "parent.blog_url.location.href=\"".$blog_options[0][$keys[0]]."\"";
			}elseif($blog_options[1]){
				$keys = array_keys($blog_options[1]);
				echo "blog_url_write('".trim($blog_options[1][$keys[0]])."', '".$board_list['hero_thumb']."','".$pk_row['hero_nick']."','".$keys[0]."');";
				
				//echo "parent.blog_url_write('".trim($blog_options[1][$keys[0]])."', '".$board_list['hero_thumb']."','".$pk_row['hero_nick']."','".$keys[0]."');";
			}elseif($blog_options[2]){
				$keys = array_keys($blog_options[2]);
				echo "parent.blog_url.location.href=\"".$blog_options[2][$keys[0]]."\"";
			}
		?>
			
		var blog_option = $("#blog_option");
		//blog_option.children().eq(0).attr("selected",true);
		blog_option.change(function(){

			var blog_value = blog_option.val();
			//블로그 url일 경우
			if(blog_value.substring(0,5)!="https"){
				parent.blog_url.location.href=blog_value;

			//sns url일 경우
			}else if(blog_value.substring(0,5)=="https"){
				window.open(blog_value);
			}

		});
	});

	function blog_url_write(url, img, nick, sns){
		//160530 추가 ie문제해결
		var url = encodeURI("/board/view2_bottom.php?url="+url+"&img="+img+"&nick="+nick+"&sns="+sns);
		parent.blog_url.location.href=url;
		
/*		160530 삭제 ie에서 안되는 문제 발생
		var top_bottom_contents = "";
		top_bottom_contents += "<!DOCTYPE html>";
		top_bottom_contents += "<html lang='ko'>";
		top_bottom_contents += "<head>";
		top_bottom_contents += "</head>";
		top_bottom_contents += "<body>";
		top_bottom_contents += "<div name='sns_url' style='text-align:center;padding-top:100px;cursor:pointer;'>";
		top_bottom_contents += "<img name='sns_img' src='"+img+"' style='margin-bottom: 10px;'/ onclick=\"window.open('"+url+"')\"><br/>";
		top_bottom_contents += "<img src='http://aklover.co.kr/image2/etc/new_window.gif' style='margin-right:10px;' onclick=\"window.open('"+url+"')\"/>";
		top_bottom_contents += "<span name='sns_contents' onclick=\"window.open('"+url+"')\">"+nick+" 님의 "+sns+"</span>";
		top_bottom_contents += "</div>";
		top_bottom_contents += "</body>";
		top_bottom_contents += "</html>";

		parent.blog_url.document.write(top_bottom_contents);
		*/
		
	}
	</script>
		
</html>