<link rel="stylesheet" type="text/css" href="/css/front/board.css" />
<link rel="stylesheet" type="text/css" href="/css/front/mypage.css" />
<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
//echo $_SESSION['temp_level'];
$today = date( "Y-m-d", time());
if(!strcmp($_SESSION['temp_drop'], '')){
}else{
    $temp_drop = $_SESSION['temp_drop'];
    if($temp_drop<=$today){
        $sql = 'UPDATE member SET hero_dropday=null, hero_level=\''.$_SESSION['temp_level'].'\', hero_write=\''.$_SESSION['temp_level'].'\', hero_view=\''.$_SESSION['temp_level'].'\', hero_update=\''.$_SESSION['temp_level'].'\', hero_rev=\''.$_SESSION['temp_level'].'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
        mysql_query($sql);
        $_SESSION['temp_write']=$_SESSION['temp_level'];
        $_SESSION['temp_view']=$_SESSION['temp_level'];
        $_SESSION['temp_update']=$_SESSION['temp_level'];
        $_SESSION['temp_rev']=$_SESSION['temp_level'];
        unset($_SESSION['temp_drop']);
    }else{
    }
}
######################################################################################################################################################
if(!strcmp($_SESSION['temp_level'], '')){
    $my_level = '0';
    $my_write = '0';
    $my_view = '0';
    $my_update = '0';
    $my_rev = '0';
}else{
    $my_level = $_SESSION['temp_level'];
    $my_write = $_SESSION['temp_write'];
    $my_view = $_SESSION['temp_view'];
    $my_update = $_SESSION['temp_update'];
    $my_rev = $_SESSION['temp_rev'];
}
######################################################################################################################################################
$cut_title_name = '26';
if(!strcmp($_GET['next_board'],"hero")){
    $hero_table = 'hero';
}else{
    $hero_table = $_GET['board'];
}

######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);
//권한
//if( ( ($right_list['hero_view'] >= $_SESSION['temp_level']) and (strcmp($_SESSION['temp_level'], '')) ) or (!strcmp($right_list['hero_view'], '99')) ){
if($right_list['hero_view'] <= $my_view){
######################################################################################################################################################
$temp_id = $_SESSION['temp_id'];
$temp_code = $_SESSION['temp_code'];
$temp_top_title = $right_list['hero_title'];
$temp_title = $out_row['hero_title'];
$temp_point = $right_list['hero_view_point'];
$temp_idx = $_GET['idx'];
######################################################################################################################################################
$sql = 'SELECT A.*, C.hero_img_new FROM mail A 
		LEFT JOIN member B ON A.hero_code = B.hero_code 
		LEFT JOIN level C ON B.hero_level = C.hero_level
		WHERE A.hero_idx=\''.$_GET['idx'].'\';';
sql($sql, 'on');
$out_row = @mysql_fetch_assoc($out_sql);//mysql_fetch_row
if(strcmp(eregi($_SESSION['temp_id'],$out_row['hero_user']),'1') && $out_row['hero_user'] != 'allUser' && $out_row['hero_user'] != 'all'){
	msg('본인의 쪽지만 확인 가능합니다.','location.href="'.PATH_HOME.'?board=mail"');
	exit;
}

$view_search_id = ",".$_SESSION['temp_id'].",";

$view_user_check_id = str_replace("||",",",$out_row['hero_user_check']);
$view_user_check_id = ",".$view_user_check_id.",";

if(strcmp(eregi($view_search_id,$view_user_check_id),'1')){
    if(!strcmp($out_row['hero_user_check'],'')){
        $new_hero_user_check = $_SESSION['temp_id'];
    }else{
        $new_hero_user_check = $out_row['hero_user_check'].'||'.$_SESSION['temp_id'];
    }
    $sql = 'UPDATE mail SET hero_user_check=\''.$new_hero_user_check.'\' WHERE hero_idx = \''.$_GET['idx'].'\';'.PHP_EOL;
    mysql_query($sql);
}


?>
     
	<div id="subpage" class="mypage">   
        <div class="sub_title">
            <div class="sub_wrap">
                <div class="f_b">
                    <h1 class="fz68 main_c fw600">마이페이지</h1>			
                </div>		
				<? include_once BOARD_INC_END.'mypage_top.php';?>
            </div>
        </div>
        <div class="sub_cont">
            <div class="sub_wrap board_wrap f_sb">
                <div class="left">
					<? include_once BOARD_INC_END.'mypage_nav.php';?>
				</div>
                <div class="contents right view_cont">
                    <a class="btn_list f_cs" href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&page=<?=$_GET['page'];?>" class="a_btn2">
						<img src="/img/front/board/list_back.webp" alt="back">
						<span class="fz19 fw700">목록으로</span>
					</a>
                    <div class="title rel"><span class="fz34 fw700"><?=cut($out_row['hero_title'],48);?></span></div>
                    <div class="writer f_b">
                        <div class="f_cs nick_cate">
						    <!-- [개발] 글쓴이 -->
							<img src="/img/front/main/profile.webp" alt="aklover" class="profile">
							<span class="fz15 fw500"><?=$out_row['hero_nick'];?></span>
						</div>
                        <!-- 날짜 -->
						<span class="gray fz15 fw500"><?=date( "Y.m.d h:i", strtotime($out_row['hero_today']));?></span>
					</div>
                    <!-- 내용 -->
					<div class="cont">
                        <? if(empty($out_row['hero_command2'])) {?>
                            <pre><?=$out_row['hero_command'];?></pre>
                        <?   } else { 
                            $temp_command = htmlspecialchars_decode ( $out_row['hero_command2'] );
                            $next_command = str_ireplace ( '<img', '<img onerror="this.src=\'' . IMAGE_END . 'hero.jpg\';" ', $temp_command );
                        ?>
                            <?=$next_command;?>
                        <?   } ?>
                    </div>
                    <!-- 첨부파일 -->                  
                    <?if(strcmp($out_row['out_row'], '')){?>
                        <div class="file f_cs">
                            <span class="fz18 fw500">첨부파일</span>
                            <a href="<?=FREEBEST_END?>download.php?hero=<?=$out_row['hero_board_one']?>&download=<?=$out_row['hero_board_two']?>" ><?=$out_row['hero_board_two'];?></a>
                        </div>                                    
                    <?}?>                    
                </div>
            </div>
        </div>
    </div>
<?
}else{
    if(!strcmp($my_level, '0')){
        $msg = '권한이';
        $action_href = PATH_HOME.'?board=login';
    }else{
        $msg = '권한이';
        $action_href = PATH_HOME.'?'.get('view');
    }
    msg($msg.' 없습니다.','location.href="'.$action_href.'"');
    exit;
}
?>