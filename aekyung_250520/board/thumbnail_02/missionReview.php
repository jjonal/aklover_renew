<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$idx = $_GET["idx"];
$board = $_GET["board"];
$cut_count_name = '6';
$cut_title_name = '10';
$cut_command_name = '50';
$today = date("Y-m-d");

$gisu_type_gubun = array(
		"group_04_06" => array("title"=>"Beauty Club","column"=>"hero_beauty_gisu","level"=>"9996")
		,"group_04_27" => array("title"=>"Beauty Club ������","column"=>"hero_movie_gisu","level"=>"9995")
		,"group_04_28" => array("title"=>"Life Club","column"=>"hero_life_gisu","level"=>"9994")
		,"group_04_31" => array("title"=>"Life Club ������","column"=>"hero_movie_gisu","level"=>"9993")
		,"group_youtube" => array("title"=>"Youtuber","column"=>"hero_youtube_gisu","level"=>"9995")
);


$gisu_column = $gisu_type_gubun[$board]["column"];
$gisu_level = $gisu_type_gubun[$board]["level"];

$sqlAddMovie = "";
if($board == "group_04_27") {
	$hero_movie_group = $_GET["hero_movie_group"];
	
	if(!$hero_movie_group) {
		//$hero_movie_group = "group_04_27";
		$gisu_column = "";
	}
	
	
	$gisu_level = $gisu_type_gubun[$hero_movie_group]["level"];
	if($hero_movie_group == "group_youtube") {
		$sqlAddMovie = " AND hero_youtube_gisu <= 4 ";
	} else if($hero_movie_group == "group_04_27") {
		$sqlAddMovie = " AND hero_movie_group = '".$hero_movie_group."' AND hero_movie_gisu > 4 ";
	} else if($hero_movie_group == "group_04_31") {
		$sqlAddMovie = " AND hero_movie_group = '".$hero_movie_group."' ";
	}
}

// 160928 ü���ı� 9�� ���, ����ı� 6�����
$list_page=6;

$page_per_list=10;

if(!strcmp($_GET['page'], ''))		$page = '1';
else								$page = $_GET['page'];

if($_GET['kewyword']){
	if($_GET['select']=="hero_title" || $_GET['select']=="hero_command")	$search = " and A.".$_GET['select']." like '%".$_GET['kewyword']."%'";
	else																	$search = " and B.".$_GET['select']." like '%".$_GET['kewyword']."%'";
	$search_next = "&select=".$_GET['select']."&kewyword=".$_GET['kewyword'];
}


if($_GET['ak_product']) {
	$search = " and a.hero_01 in (select hero_idx from mission where hero_keywords like '%".$_GET['ak_product']."%' ) ";
	$search_next = "&select=".$_GET['select']."&kewyword=".$_GET['kewyword']."&ak_product=".$_GET['ak_product'];
}

$start = ($page-1)*$list_page;
$next_path="board=".$board."&view=missionReview&idx=".$idx.$search_next."&hero_movie_group=".$_GET["hero_movie_group"]."&hero_gisu=".$_GET["hero_gisu"];

######################################################################################################################################################
$error = "THUMBNAIL_04_LIST_01";

//������ �����̼��� ���� (hero_type �����̼�  : 7)
$gisu_sql = " SELECT distinct(ifnull(".$gisu_column.",1)) as ".$gisu_column." FROM mission WHERE hero_table = '".$board."' AND hero_type != '7' ";
$gisu_sql .= " AND hero_use = 1 ".$sqlAddMovie;
$gisu_sql .= " order by ".$gisu_column." desc ";

$res = new_sql($gisu_sql, $error);

$res_gisu_list = array();
while($list = mysql_fetch_assoc($res)){
	$res_gisu_list[] = $list;
}

$hero_gisu = "";
$hero_gisu = $_GET["hero_gisu"];
$sql_gisu = "";
if($hero_gisu) {
	$sql_gisu = " AND m.".$gisu_type_gubun[$board]["column"]." = '".$hero_gisu."' ";
}
/*
if(!$_GET["hero_gisu"]) {
	$hero_gisu = $res_gisu_list[0][$gisu_column];
} else {
	$hero_gisu = $_GET["hero_gisu"];
}
*/

$sql  = " SELECT count(*) FROM board b inner join mission m ON b.hero_01 = m.hero_idx ";
$sql .= " WHERE b.hero_table = '".$board."'  AND m.hero_table = '".$board."' "; 
$sql .= " AND b.hero_use = '1' AND m.hero_use = '1' ";
//$sql .= " AND m.".$gisu_column." = '".$hero_gisu."' ".$sqlAddMovie;
$sql .= $sql_gisu.$sqlAddMovie;

$count_res = new_sql($sql,$error,"on");
if((string)$count_res==$error){
	error_historyBack("");
	exit;
}

$total_data = mysql_result($count_res,0,0);

######################################################################################################################################################
$sql = "select * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$_GET['board']."'";//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);


?>
<script>
function fnGisu(val) {
	location.href = location.protocol+"//"+location.host+"/main/index.php?board=<?=$board?>&view=missionReview&hero_gisu="+val;
}

function fnMovieGroup(val) {
	location.href = location.protocol+"//"+location.host+"/main/index.php?board=<?=$board?>&view=missionReview&hero_movie_group="+val;
}

function fnMovieGisu(val) {
	location.href = location.protocol+"//"+location.host+"/main/index.php?board=<?=$board?>&view=missionReview&hero_movie_group=<?=$hero_movie_group?>&hero_gisu="+val;
}

//����ı� ����
function fnBest() {
	$("input[name='mode']",document.form_next).val("best");
	$(document.form_next).submit();
}

//����ı� ����
function fnBestCancel() {
	$("input[name='mode']",document.form_next).val("bestCancel");
	$(document.form_next).submit();
}

</script>

        <div class="contents">
        	<? include_once("{$_SERVER[DOCUMENT_ROOT]}/include/listHeadTitle.php") ?>

            <div class="blog_box2" style="margin-top:30px">
	            <form name="form_next" action="<?=PATH_HOME.'?'.get('','type=drop');?>" method="post" enctype="multipart/form-data">
	            <input type="hidden" name="mode" />
				    <div class="gisuWrap">
				    	<? if($board == "group_04_27") {?>
				    		<span class="titBox">
				    			<? if($hero_movie_group) {?>
				    			�� <?=$gisu_type_gubun[$hero_movie_group]["title"]?>
				    			<? } else { ?>
				    			�� Beauty/Life Club ������	
				    			<? } ?>  
				    			<? if($hero_gisu){?><?=$hero_gisu;?>��<? } ?>
				    		</span>
				    		
				    		<select name="hero_movie_group" onChange="fnMovieGroup(this.value)" style="right:90px;">
				    			<option value="">������ ����</option>
			        			<option value="group_04_27" <?=$hero_movie_group == "group_04_27" ? "selected":"";?>>Beauty Club</option>
								<option value="group_04_31" <?=$hero_movie_group == "group_04_31" ? "selected":"";?>>Life Club</option>
								<option value="group_youtube" <?=$hero_movie_group == "group_youtube" ? "selected":"";?>>Youtuber</option>
			        		</select>
				    	
				    		<select name="hero_movie_gisu" onChange="fnMovieGisu(this.value);">
			        			<option value="">��� ����</option>
			        			<? foreach($res_gisu_list as $rs_gisu) { ?>
			        				<option value="<?=$rs_gisu[$gisu_column]?>" <?=$rs_gisu[$gisu_column]==$_GET["hero_gisu"] ? "selected":"";?>><?=$rs_gisu[$gisu_column]?>��</option>
			        			<? } ?>
			        		</select>
				    	
				    	<? } else { ?>
			        		<span class="titBox">�� <?=$gisu_type_gubun[$board]["title"]?>  <? if($hero_gisu){?><?=$hero_gisu;?>��<? } ?></span>
			        		
			        		<select name="hero_gisu" onChange="fnGisu(this.value);">
			        			<option value=""><?=$gisu_type_gubun[$board]["title"]?> ��� ����</option>
			        			<? foreach($res_gisu_list as $rs_gisu) { ?>
			        				<option value="<?=$rs_gisu[$gisu_column]?>" <?=$rs_gisu[$gisu_column]==$_GET["hero_gisu"] ? "selected":"";?>><?=$gisu_type_gubun[$board]["title"]?> <?=$rs_gisu[$gisu_column]?>��</option>
			        			<? } ?>
			        		</select>
		        		<? } ?>
		        	</div>
		        	
		        	<? if($total_data == 0) { ?>
					<div style='width:100%; border:2px solid #eee; padding:30px 0; text-align:center; font-size:16px; font-weight:bold;'>ü�� �ıⰡ �������� �ʽ��ϴ�.</div>
				    <?	} ?>
				    
                
	                <ul class="blog_article">
						<?
						
						//����ı� ����
						if($_POST["mode"] == "best") {
							for($z=0; $z<count($_POST["hero_idx"]); $z++) {
								$sql_best = " UPDATE board SET hero_board_three = '1' WHERE hero_idx = '".$_POST["hero_idx"][$z]."' ";
								@mysql_query($sql_best);
							}
							$get_herf = get('type','','');
							$action_href = PATH_HOME.'?'.$get_herf;
							msg("����ı� �����Ǿ����ϴ�.",'location.href="'.$action_href.'"');
						}
						
						//����ı� ����
						if($_POST["mode"] == "bestCancel") {
							for($z=0; $z<count($_POST["hero_idx"]); $z++) {
								$sql_best_cancel = " UPDATE board SET hero_board_three = '0' WHERE hero_idx = '".$_POST["hero_idx"][$z]."' ";
								@mysql_query($sql_best_cancel);
							}
							$get_herf = get('type','','');
							$action_href = PATH_HOME.'?'.$get_herf;
							msg("����ı� �����Ǿ����ϴ�.",'location.href="'.$action_href.'"');
						}
						
						$error = "THUMBNAIL_04_LIST_02";
						/*	
						$sql = "select * ";
						$sql .= "from (select A.hero_idx, A.hero_code, A.hero_table, A.hero_command, A.hero_thumb, A.hero_img_new, A.hero_today, A.hero_title,A.hero_04,A.blog_url,A.cafe_url,A.sns_url,A.etc_url, B.hero_level, B.hero_nick from board as A, member as B where A.hero_code=B.hero_code ".$where." ".$search." and A.hero_use=1 order by A.hero_today desc limit ".$start.",".$list_page.") as A ";
						$sql .= ",(select hero_img_new as level_img, hero_level from level) as C where A.hero_level=C.hero_level order by A.hero_today desc";					//echo $sql;
						*/
						
						$sql = " 
								SELECT hero_idx, hero_title, hero_nick, hero_thumb, hero_img_new, hero_04
									  , blog_url, cafe_url, sns_url, etc_url, hero_board_three
									  , (SELECT count(*) FROM mission_url WHERE board_hero_idx = a.hero_idx) as url_cnt 	
									  , (SELECT hero_img_new as level_img from level where hero_level=a.hero_level) level_img
									  , hero_table, hero_movie_group, hero_movie_gisu
									FROM
									(SELECT
									b.hero_idx, b.hero_title, b.hero_nick, b.hero_thumb, b.hero_img_new, b.hero_04
									, b.blog_url,b.cafe_url,b.sns_url,b.etc_url,b.hero_board_three, b.hero_code
									, mem.hero_level
									, m.hero_table, m.hero_movie_group, m.hero_movie_gisu
									FROM board b inner join mission m
									on b.hero_01 = m.hero_idx
									LEFT JOIN member mem on b.hero_code = mem.hero_code
									WHERE
									b.hero_table = '".$board."'  AND m.hero_table = '".$board."'
									AND b.hero_use = '1' AND m.hero_use = '1'
									".$sql_gisu.$sqlAddMovie." ORDER BY b.hero_today DESC LIMIT ".$start.",".$list_page ." ) a ";

						$res = new_sql($sql, $error);
						if((string)$res==$error){
							error_historyBack("");
							exit;
						}
						$view_count = '4';
						$dd = '1';
							
						$unblocked_site = array("naver", "daum", "tistory");
						$unblocked_site_name = array("���̹�", "����", "Ƽ���丮");
						$total_html = "";
						
						while($list = mysql_fetch_assoc($res)){
					    	if($list['hero_04']) {
								$link="<a href='http://".$_SERVER["HTTP_HOST"]."/main/index.php?board=".$list['hero_table']."&page=".$page."&view=view2&idx=".$list['hero_idx']."' target='_blank'>";	
							}else if($list['blog_url'] || $list['cafe_url'] || $list['sns_url'] || $list['etc_url']) {
								$link="<a href='http://".$_SERVER["HTTP_HOST"]."/main/index.php?board=".$list['hero_table']."&page=".$page."&view=view2&idx=".$list['hero_idx']."' target='_blank'>";
							} else if($list["url_cnt"] > 0) {
								$link="<a href='http://".$_SERVER["HTTP_HOST"]."/main/index.php?board=".$list['hero_table']."&page=".$page."&view=view2&idx=".$list['hero_idx']."' target='_blank'>";
							}else {
								$link="<a href=".PATH_HOME."?board=".$_GET['board']."&page=".$page."&view=view&idx=".$list['hero_idx'].">";
							}
					    	
						    if($list["hero_thumb"])	    			$view_img = $list['hero_thumb'];
						    elseif($list["hero_img_new"]) 	 		$view_img = $list['hero_img_new'];
						    else						    										$view_img = IMAGE_END.'hero.jpg';
						    
					    
							$main_review_sql = "select count(*) from review where hero_old_idx='".$list['hero_idx']."'";
							$out_main_review_sql = @mysql_query($main_review_sql);
							$main_review_data = @mysql_result($out_main_review_sql,0,0);
						
							if($main_review_data>0)			$re_count_total = "<strong><font color='orange'>[".$main_review_data."]</font></strong>";
							else							$re_count_total = "";
							
							if($today == substr($list['hero_today'],0,10))		$new_img_view = " style='background:url(".DOMAIN_END."image/main_new_bt.png) no-repeat 0 2px;'";
						
							if (strcmp($dd,'3')){
								$total_html .= "<li>";
							} else if(!strcmp($dd,'3')){
								$total_html .= "<li class='last'>";
								$dd = '0';
							}
							
							if($_SESSION["temp_level"] == "9999") {
								if($list["hero_board_three"] == "1") {
									$total_html .= "<span class='best'><input type='checkbox' name='hero_idx[]' value='".$list['hero_idx']."' checked /></span>";
								} else {
									$total_html .= "<span class='best'><input type='checkbox' name='hero_idx[]' value='".$list['hero_idx']."' /></span>";
								}
							}
							//
							//$new_content = "����:".$list['hero_title']."\n\n�ۼ���:".date( "Y-m-d", strtotime($list['hero_today']))."\n\n�ۼ���:".$list['hero_nick'];
						    //$total_html .= "<div align='center' title='".$new_content."'>";
							$total_html .= "<div align='center'>";
						    $total_html .= $link;
						    $total_html .= "<div class='imgReviewBox'><img src='".$view_img."' onError='this.src=\"/image/hero_empty.jpg\"'/></div>";
						    $total_html .= "<span class='title'>".cut($list['hero_title'], '30').$re_count_total."</span>";
						    $total_html .= "<span class='date'><center>";
						    
						    $level_img = str($list["level_img"]);
						   	if($list["hero_table"] == "group_04_06") {
						   		$level_img = "/image/bbs/lev_BeautyHolic.png";
						   	} else if($list["hero_table"] == "group_04_28") {
						   		$level_img = "/image/bbs/lev_life.png";
						   	} else if($list["hero_table"] == "group_04_27") {
						   		if($list["hero_movie_group"] == "group_04_27") {
						   			if($list["hero_movie_gisu"] > 4) {
						   				$level_img = "/image/bbs/lev_BeautyHolic.png";
						   			} else {
						   				$level_img = "/image/bbs/lev_youtuber.png";
						   			}
						   		} else if($list["hero_movie_group"] == "group_04_31") {
						   			$level_img = "/image/bbs/lev_life.png";
						   		}
						   	}
							
					   		$total_html .= "<img src='".$level_img."' style='width:20px;height:20px' /> ".$list['hero_nick']."</center></span>";
							
						    $total_html .= "</a>";
						    $total_html .= "</div>";
						    $total_html .= "</li>";
						    $dd++;
						}//while
						echo $total_html;
						?>
	                </ul>
	            </div>
			</form>
        	<div class="clearfix"></div>
        	
        	<? if($_SESSION["temp_level"] == "9999") {?>
        	<div class="btngroup">
	        	<div class="btn_r">
	        		<a href="javascript:;" onClick="fnBestCancel()" class="a_btn" style="background:#888;">����ı� ����</a>
	        		<a href="javascript:;" onClick="fnBest()" class="a_btn">����ı� ����</a>
	        	</div>
	        </div>
        	<? } ?>
            
			<? include_once BOARD_INC_END.'button.php';?>
           
    	</div>
	</div>

