<?
include_once "head.php";
if(!defined('_HEROBOARD_'))exit;

$error = "BOARD_VIEW_02";
$group_sql = "select * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$_GET['board']."'"; // desc
$out_group = new_sql( $group_sql,$error,"on" );
if((string)$out_group==$error){
	error_historyBack("");
	exit;
}
$right_list = mysql_fetch_assoc ( $out_group );

$today = date( "Y-m-d", time());

$idx = $_GET['hero_idx'];

$board = $_GET['board'];

$level = $_SESSION['temp_level'];
$code = $_SESSION['temp_code'];

$my_write = $_SESSION ['temp_write'];
$my_view = $_SESSION ['temp_view'];
$my_update = $_SESSION ['temp_update'];
$my_rev = $_SESSION ['temp_rev'];

######################################################################################################################################################
$error = "BOARD_VIEW_02";
$board_sql = "select A.*,B.hero_nick, C.hero_img_new from ";
$board_sql .= "(select * from board where hero_idx='".$idx."') as A left outer join member as B on A.hero_code=B.hero_code ";
$board_sql .= "left outer join level as C on B.hero_level=C.hero_level ";
$board_sql .= "where A.hero_idx='".$idx."' ";
//exit;
$out_sql = new_sql( $board_sql, $error);

if((string)$out_sql==$error){
	error_historyBack("");
	exit;
}

######################################################################################################################################################
$board_list = mysql_fetch_assoc( $out_sql);

if($_SESSION['temp_level'] < 9999 && $board_list["hero_use"] == "0") {
	msg('비공개 게시글 입니다.','location.href="/m/board_00.php?board=group_02_03"');
	exit;
}

######################################################################################################################################################
if(date("Y-m-d")==substr($board_list['hero_today'],0,10))    	$new_img_view = "<img src='".DOMAIN_END."image/main_new_bt.png'  width='14' alt='new' /> ";
else													    	$new_img_view = "";
$sns_title = $board_list['hero_title'];
$link = DOMAIN.URI_PATH.'?'.get();
$sns_image= DOMAIN_END.'image/logo2.gif';

$mission_url_sql = " SELECT gubun, url FROM mission_url WHERE board_hero_idx = '".$_GET['hero_idx']."' ORDER BY field(gubun, 'naver', 'insta', 'movie', 'cafe', 'etc') ASC, hero_idx ASC ";
$mission_res = sql($mission_url_sql);
?>

<script type="text/javascript" src="<?=JS_END;?>head.js"></script>
<link href="css/review_viewer.css?version=003" rel="stylesheet" type="text/css">

<!--컨텐츠 시작-->
<!--<div id="title"><p><?=$group_list['hero_title'];?></p></div>-->
<? include_once "boardIntroduce.php"; ?>
     
<!-- 2018-12-14 체험단 후기 삭제 때문에 생성 -->
<form name="form0" id="form0" method="POST">
	<input type="hidden" name="hero_table" value="<?=$_GET["board"]?>" />
</form>
<div id="list_title">
    <div class="title_left">
        <ul style="width:100%">
        	<li class="top"><?=$new_img_view?><?=cut($board_list['hero_title'],48);?></li>
        	<li class="date">작성일: <?=date( "Y.m.d", strtotime($board_list['hero_today']));?></li>
        	<li class="nickname"><img src="<?=str($board_list['hero_img_new'])?>"/><?=$board_list['hero_nick'];?></li>
        </ul>
    </div>   
</div>
<?
$next_command = htmlspecialchars_decode($board_list['hero_command']);
$next_command = str_ireplace("<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n","",$next_command);
$next_command = str_ireplace("<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n","",$next_command);
$next_command = str_ireplace('<img', '<img onerror="this.src=\''.IMAGE_END.'hero.jpg\';" ', $next_command);
$next_command = preg_replace("/ width=(\"|\')?\d+(\"|\')?/"," width='100%'",$next_command);
$next_command = preg_replace("/ height=(\"|\')?\d+(\"|\')?/","",$next_command);
$next_command = preg_replace("/width: \d+px/","width:100%;",$next_command);
$next_command = preg_replace("/height: \d+px;/","",$next_command);
$next_command = preg_replace("/height: \d+px/","",$next_command);
$next_command = preg_replace("/margin-left: \d+pt/","",$next_command);



if($board_list['hero_04']) {
	$blog_urls = remove_kr($board_list['hero_04']);
}else {
	$blog_urls = remove_kr($board_list['blog_url']).remove_kr($board_list['cafe_url']).remove_kr($board_list['sns_url']).remove_kr($board_list['etc_url']);
}

$blog_urls = str_ireplace("http:","http:",$blog_urls);
$blog_urls = str_ireplace("https:","https:",$blog_urls);

$blog_urls = check_blog($blog_urls);

$unblocked_site_name = array("navercafe", "naverblog", "daumcafe", "daumblog", "tistory");
$blocked_site_name = array("facebook", "twitter", "instagram");

?>

<div class="board_view_01">  
	<img src="<?=$board_list['hero_thumb']?>" alt=""><br/>
	
	<dl class="snsURLShareWrap">
		<? 
		$gubun_arr = array("naver"=>"네이버 블로그","insta"=>"인스타그램","movie"=>"후기(영상)","cafe"=>"까페","etc"=>"기타");
		while($list = mysql_fetch_assoc($mission_res)) {?>
		<dt><?=$gubun_arr[$list["gubun"]]?></dt>
		<dd><a href="<?=$list["url"]?>" target="_blank" class="btnLink">바로가기</a></dd>
		<? } ?>
	</dl>
</div>
<?
//수정 : 체험단 등록 후 미션에 속한 후기글만 노출
$mission_where = "";

$mission_where_prev = " hero_table in ('group_04_05', 'group_04_06', 'group_04_07', 'group_04_08', 'group_04_09', 'group_04_27', 'group_04_28') and (hero_board_three='1' or hero_table='group_04_10') and hero_idx > ".$_GET['hero_idx'];
$mission_where_next = " hero_table in ('group_04_05', 'group_04_06', 'group_04_07', 'group_04_08', 'group_04_09', 'group_04_27', 'group_04_28') and (hero_board_three='1' or hero_table='group_04_10') and hero_idx < ".$_GET['hero_idx'];

$sql = 'select * from board where '.$mission_where_prev.'  order by hero_idx asc limit 0,1;';

$out_sql = @mysql_query($sql);
$Prev = @mysql_fetch_assoc($out_sql);//mysql_fetch_row
$Prev['hero_idx'];

$sql = 'select * from board where '.$mission_where_next.' order by hero_idx desc limit 0,1;';
$out_sql = @mysql_query($sql);
$Next = @mysql_fetch_assoc($out_sql);//mysql_fetch_row
$Next['hero_idx'];

if(strcmp($Prev['hero_idx'], '')){
?>
<div id="list_previous" style="width:90%; margin:auto">
        <a href="<?=PATH_END;?>board_view_02.php?<?=get("hero_idx","hero_idx=".$Prev['hero_idx'])?>">
        <ul style="width:100%">
        <li style="width:19%; padding-left:2%">이전글&nbsp;&nbsp;<img src="img/review/arrow1.png" alt=""/></li>
        <li style="width:79%"><?=cut($Prev['hero_title'],26);?></li>
        </ul>
        </a>
</div>
<?
}
if(strcmp($Next['hero_idx'], '')){
?>
<div id="list_next" style="width:90%; margin:auto">
        <a href="<?=PATH_END;?>board_view_02.php?<?=get("hero_idx","hero_idx=".$Next['hero_idx'])?>">
        <ul style="width:100%">
        <li style="width:19%; padding-left:2%">다음글&nbsp;&nbsp;<img src="img/review/arrow2.png" alt=""/></li>
        <li style="width:79%"><?=cut($Next['hero_title'],26);?></li>
        </ul>
        </a>
</div>
<?
}
?>
<div class="clear"></div> 
     
     
<div id="list_btn" style="width:90%; margin:auto; margin-top:20px; margin-bottom:20px">
        <ul style="width:100%">
        
        	<li style="width:40%; float:left">
            	<a href="<?=DOMAIN_END."m/board_02.php?".get("hero_idx")?>"><img src="img/review/list_btn.jpg" alt="목록" width="70px"/></a>
        	</li>
        	<!-- 
        	<li style="width:60%; float:right; text-align:right">
				<?if( ($_SESSION['temp_level']>='9999') or (!strcmp($board_list['hero_code'],$_SESSION['temp_code'])) ){?>
					
					<a href="/m/mission_write.php?board=<?=$_GET['board']?>&hero_idx=<?=$_GET['hero_idx']?>&idx=<?=$_GET["idx"]?>&action=update">
						<img src="img/review/modify_btn.jpg" alt="수정" width="70px"/>
					</a>
					<a href="javascript:;" onClick="delPostscript()">
            			<img src="img/review/delete_btn.jpg" alt="삭제" width="70px"/>
            		</a>
            		&nbsp;
				<?}?>
            </li>
            -->
  		</ul>
        <div class="clear"></div>
</div>
<script>
function delPostscript() {
	var f = document.form0;
	f.action = "/m/mission_write_proc.php?board=<?=$_GET['board']?>&action=delete&idx=<?=$_GET["idx"];?>&hero_idx=<?=$_GET['hero_idx']?>";
	f.submit();
}

function check_review_del(idx){

	if(confirm("삭제하시겠습니까?")==true)	hero_review_del(idx,"pc");		
	else								return false;
	
}

function open0(link){
    var link1 = encodeURIComponent(link);
    window.open('http://www.facebook.com/sharer/sharer.php?u='+link1,'','width=520 height=400 scrollbars=yes');
}
function open1(sub, link){
    var sub1 = encodeURIComponent(sub);
    var link1 = encodeURIComponent(link);
    window.open('http://twitter.com/home?status='+sub1+' '+link1,'','width=520 height=200 scrollbars=yes');
}
function open2(sub, link){
    var sub1 = encodeURIComponent(sub);
    var link1 = encodeURIComponent(link);
    window.open('http://plugin.me2day.net/v1/me2post/create_post_form.nhn?body='+sub1+' '+link1,'','width=520 height=400 scrollbars=yes');
}
	
</script>
  
  
     
<!--컨텐츠 종료-->
<?
include_once "tail.php";
?>
