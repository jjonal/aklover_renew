<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
##변수 설정
######################################################################################################################################################
if($_GET['kewyword']){
	if($_GET['select']=="hero_title" || $_GET['select']=="hero_command")	$search = " and A.".$_GET['select']." like '%".$_GET['kewyword']."%'";
	else																	$search = " and B.".$_GET['select']." like '%".$_GET['kewyword']."%'";
	$search_next = "&select=".$_GET['select']."&kewyword=".$_GET['kewyword'];
}

$cut_count_name = '8';
$cut_title_name = '50';
$list_page=6;
$page_per_list=10;

$page = $_GET['page'];
if(!is_numeric($_GET['page']))	$page = '1';
else							$page = $_GET['page'];	
$start = ($page-1)*$list_page;

$board = $_GET['board'];

$next_path="board=".$board.$search_next;


######################################################################################################################################################
$error = "THUMBNAIL_03_LIST_01";
$sql = "select count(*) from board as A, member as B where A.hero_code=B.hero_code and (A.hero_table='".$board."' or A.hero_03='".$board."') and A.hero_use='1' ".$search."";
$count_res = new_sql($sql,$error,"on");
if((string)$count_res==$error){
	error_historyBack("");
	exit;
}

$total_data = mysql_result($count_res,0,0);


######################################################################################################################################################
$error = "THUMBNAIL_03_LIST_02";
$sql = "select * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$board."'";
$right_res = new_sql($sql,$error);
if((string)$right_res==$error){
	error_historyBack("");
	exit;
}
$right_list                             = @mysql_fetch_assoc($right_res);
######################################################################################################################################################

?>

        <div class="contents">
            <div class="blog_box2" style="margin-top:0px">
                <ul class="blog_article">
<?
$error = "THUMBNAIL_03_LIST_03";
$sql = "select * ";
$sql .= "from (select A.hero_idx, A.hero_code, A.hero_table, A.hero_command, A.hero_thumb, A.hero_img_new, A.hero_today, A.hero_title,A.hero_04, B.hero_level, B.hero_nick from board as A, member as B where A.hero_code=B.hero_code and (A.hero_table='".$board."' or A.hero_03='".$board."') ".$search." and A.hero_use=1 order by A.hero_today desc limit ".$start.",".$list_page.") as A ";
$sql .= ",(select hero_img_new as level_img, hero_level from level) as C where A.hero_level=C.hero_level order by A.hero_today desc";//echo $sql;
//echo $sql;
$main_res = new_sql($sql,$error);
if((string)$main_res==$error){
	error_historyBack("");
	exit;
}

$data_count = mysql_num_rows($main_res);
$i = 1;
$dd = 1;
$total_html = "";
while($list = mysql_fetch_assoc($main_res)){
	
	if($list["hero_thumb"])	    			$view_img = $list['hero_thumb'];
	elseif($_GET['board']=='group_02_03')	$view_img = IMAGE_END.'hero.jpg';
	elseif($list["hero_img_new"] )  		$view_img = $list['hero_img_new'];
	else						  			$view_img = IMAGE_END.'hero.jpg';
	
    $error = "THUMBNAIL_03_LIST_04";
	$review_sql = "select count(*) from review where hero_old_idx='".$list['hero_idx']."'";
	$review_res = new_sql($review_sql,$error);
	
	if((string)$review_res==$error){
		error_historyBack("");
		exit;
	}
	
	$review_data = mysql_result($review_res,0,0);
	
	if($review_data>0)				$re_count_total = "<strong><font color='orange'>[".$review_data."]</font></strong>";
	else							$re_count_total = "";
	
	if (strcmp($dd,'3'))		$total_html .= "<li>";
	else if(!strcmp($dd,'3')){
		$total_html .= "<li class='last'>";
		$dd = '0';
	}
	
    $total_html .= "<div align='center' title='제목:".$list['hero_title']."\n\n작성일:".date( "Y-m-d", strtotime($list['hero_today']))."\n\n작성자:".$list['hero_nick']."'>";
    $total_html .= "<a href='".PATH_HOME."?board=".$board."&page=".$page."&view=view&idx=".$list['hero_idx']."'>";
    $total_html .= "<img src='".$view_img."' >";
    $total_html .= "<span class='title'>".cut($list['hero_title'], '30').$re_count_total."</span>";
    $total_html .= "<span class='date'><center>";
	$total_html .= "<img src='".str($list["level_img"])."' style='width:20px;height:20px' /> ".$list['hero_nick']."</center></span>";
    $total_html .= "</a>";
    $total_html .= "</div>";
    $total_html .= "</li>";
    
	$i++;
	$dd++;
}
	echo $total_html;
?>
                </ul>
            </div>
            <div class="clearfix"></div>
<? include_once BOARD_INC_END.'button.php';?>
<? include_once BOARD_INC_END.'search.php';?>
        </div>
    </div>
