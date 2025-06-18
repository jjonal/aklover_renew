<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$today = date( "Y-m-d", time());
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
$sql = 'select a.*,b.hero_nick as nick from board a left join member b on a.hero_code = b.hero_code where a.hero_table = \''.$hero_table.'\' and a.hero_idx=\''.$_GET['idx'].'\';';
sql($sql, 'on');
$out_row = @mysql_fetch_assoc($out_sql);//mysql_fetch_row

$del_use_check = -1; //답변이 존재유무
if($out_row["hero_10"]) $del_use_check = 1;

if($out_row['hero_code'] != $_SESSION['temp_code']) {
	msg('본인의 글만 확인 가능합니다.','location.href="'.PATH_HOME.'?board=cus_3&view_type=list"');
	exit;
}

$gubun_arr = array("1"=>"체험단 문의","2"=>"체험단 후기수정","3"=>"홈페이지 문의","4"=>"기타");
?>
    <div id="subpage" class="mypage replypage">   
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
                    <a class="btn_list f_cs" href="/main/index.php?board=myreply" class="a_btn2">
						<img src="/img/front/board/list_back.webp" alt="back">
						<span class="fz19 fw700">목록으로</span>
					</a>
                    <div class="title rel"><span class="fz34 fw700"><?=cut($out_row['hero_title'],48);?></span></div>
                    <div class="writer f_b">
                        <div class="f_cs nick_cate">
						    <!-- [개발] 글쓴이 -->
							<img src="/img/front/main/profile.webp" alt="aklover" class="profile">
							<span class="fz15 fw500"><?=$out_row['nick'];?></span>
                            <span class="fz15 fw500 mu_bar"><?=$gubun_arr[$out_row['gubun']]?></span>
						</div>
                        <!-- 날짜 -->
						<span class="gray fz15 fw500"><?=date( "Y.m.d h:i", strtotime($out_row['hero_today']));?></span>
                    </div>
                    <!-- 내용 -->
                    <div class="cont">
                        <?=htmlspecialchars_decode($out_row['hero_command']);?>
                    </div>
                    <!-- 답변 -->
                    <?if(strcmp($out_row['hero_10'], '')){?>
                    <div class="replybox">
                        <div class="textstyle">
                            <?=nl2br($out_row['hero_10']);?>
                        </div>
                    </div>
                    <?}?>
                    <!-- 첨부파일 -->                        
                    <?if(strcmp($out_row['hero_board_two'], '')){?>
                        <div class="file f_cs">
                            <span class="fz18 fw500">첨부파일</span>
                            <a href="<?=FREEBEST_END?>download.php?hero=<?=$out_row['hero_board_one']?>&download=<?=$out_row['hero_board_two']?>" ><?=$out_row['hero_board_two'];?></a>
                        </div>                                    
                    <?}?>
                    <?
                        include_once BOARD_INC_END.'button.php';
                    ?>
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