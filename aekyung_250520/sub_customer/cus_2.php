<link rel="stylesheet" type="text/css" href="/css/front/cscenter.css" />
<script type="text/javascript" src="/board/category.js"></script>
<script>
    
$(document).ready(function(){
	var category = ['<?=implode("','",$_FAQ_CATEGORY)?>'];
    console.log(category);
	$('#catetabs').tabSelect({
	  tabElements: category,
	  selectedTabs: ['<? if($_REQUEST["category"]){echo $_REQUEST["category"];}else{echo $_FAQ_CATEGORY[0];} ?>']
	});
});
</script>
<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$cut_count_name = '6';
$cut_title_name = '34';
$board = 'cus_2';
######################################################################################################################################################
if(strcmp($_POST['kewyword'], '')){
    $search = " and ".$_POST['select']." like '%".$_POST['kewyword']."%'";
    $search_next = "&select=".$_POST['select']."&kewyword=".$_POST['kewyword'];
}else if(strcmp($_GET['kewyword'], '')){
    $search = " and ".$_GET['select']." like '%".$_GET['kewyword']."%'";
    $search_next = "&select=".$_GET['select']."&kewyword=".$_GET['kewyword'];
}
//카테고리 검색
if(strcmp($_GET['category'], '') && strcmp($_GET['category'], '전체')){
    $search .= " and hero_06 ='".$_GET['category']."' ";
    $search_next = "&category=".$_GET['category'];
}else{
}

######################################################################################################################################################
$sql = "select * from board where hero_table='".$board."'".$search." and hero_use=1 order by hero_notice desc, hero_idx desc";
sql($sql);
$total_data = @mysql_num_rows($out_sql);
######################################################################################################################################################
$list_page=8;
$page_per_list=10;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board'].$search_next;
######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list = @mysql_fetch_assoc($out_sql);
######################################################################################################################################################
?>

        <div id="subpage" class="cscenter">
            <div class="sub_title">
                <div class="sub_wrap">
                    <div class="f_b">
                        <h1 class="fz68 fw600 main_c">고객센터</h1>
                    </div>
                </div>
            </div>
            <div class="sub_cont faq">
                <div class="sub_wrap board_wrap f_sb">
                    <div class="left">
                        <ul class="sub_menu">
                            <li><a href="/main/index.php?board=group_04_03">공지사항 <img src="/img/front/icon/bread.webp" alt="공지사항 바로가기"></a></li>
                            <li class="on"><a href="/main/index.php?board=group_04_33">FAQ <img src="/img/front/icon/bread.webp" alt="FAQ 바로가기"></a></li>
                            <li><a href="/main/index.php?board=group_04_35&view_type=list">1:1 문의 <img src="/img/front/icon/bread.webp" alt="1:1 문의 바로가기"></a></li>
                        </ul>
                        <div class="caution">
                            <h3 class="fz20 fw600">안내/유의사항</h3>
                            <div>
                                <div class="f_fs">
                                    <img src="/img/front/icon/caution.webp" alt="안내/유의사항">
                                    <p class="fz14">
                                        AK Lover 활동 및 운영에 대해서는 공지사항을 확인해주세요!<br />
                                        그 외 궁금하신 사항은 FAQ를 확인하거나, 1:1 문의를 남겨주세요!
                                    </p>
                                </div>
                                <span class="info">
                                    문의전화 : 080-024-1357 (수신자부담)<br>
                                    상담시간 : 평일 9시~18시 (토, 일, 법정 공휴일 제외)
                                </span>
                            </div>
                        </div>
                        <? include_once BOARD_INC_END.'search.php';?>
                    </div>
                    <div class="contents right">
                        <!-- 탑 슬라이드 -->
                        <? include_once BOARD_INC_END.'top_slide.php';?>
                        <div  id="catetabs" name="group_04_34" class="boardTabMenuWrap"></div>
                        <div class="faq_list">
                            <?
                            $sql = 'select * from board where hero_table=\''.$board.'\''.$search.' and hero_use=1 order by hero_order asc, hero_today desc limit '.$start.','.$list_page.';';
                            sql($sql);
                            $i=0;
                            while($list = @mysql_fetch_assoc($out_sql)) {
                                $num=$total_data - $start-$i;
                                $i++;
                            ?>
                            <div class="q">
                                <div class="f_cs q_tit">
                                    <span class="fz20 fw600 main_c">Q.</span>
                                    <p class="cate fz16"><?=$list['hero_06']?></p>
                                    <p class="tit fz16 gray08"><?=$list['hero_title']?></p>
                                </div>
                                <div class="answer">
                                    <div class="flex">
                                        <b class="fz20 bold main_c tit_a">A.</b>
                                        <div class="cont_a"><?=htmlspecialchars_decode($list['hero_command']);?></div>
                                    </div>
                                    <?
                                    if( (!strcmp($_SESSION['temp_level'], '9999')) or (!strcmp($_SESSION['temp_level'], '10000')) ){
                                        if(!strcmp($_GET['next_board'],"hero")){
                                            $hero_table = 'hero';
                                        }else{
                                            $hero_table = $_REQUEST['board'];
                                        }
                                    ?>
                                    <div class="btn_wrap">
                                        <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&next_board=<?=$hero_table?>&view=write&action=update&idx=<?=$list['hero_idx'];?>&page=<?=$_GET['page'];?>">수정</a>
                                        <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&next_board=<?=$hero_table?>&view=action&action=delete&code=<?=$list['hero_code']?>&table=<?=$list['hero_table']?>&idx=<?=$list['hero_idx'];?>&page=<?=$_GET['page'];?>">삭제</a>
                                    </div>
                                    <? } ?>
                                </div>
                            </div>
                            <? } ?>
                        </div>
                        <div class="admin_btn">
                            <? include_once BOARD_INC_END.'button.php';?>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    <script type="text/javascript">
        $(document).ready(function(){
            $('.answer').hide();
            $('.q .q_tit').click(function(e) {
                if($(this).next().css('display') == "none") {
                    $('.q .q_tit').removeClass('active');
                    $(this).addClass('active');
                    $('.answer').hide();
                    $(this).next().show();
                }else {
                    $('.q .q_tit').removeClass('active');
                    $('.answer').hide();
                }
            });
        });
    </script>
