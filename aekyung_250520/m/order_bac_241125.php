<link rel="stylesheet" type="text/css" href="/m/css/musign/pointmall.css" />
<?
include_once "head.php";

if($_GET['board']!="group_04_21"){
    echo "<script>alert('잘 못된 접근입니다.');location.href='/m/main.php'</script>";
}

$sql = "select * from order_period";
$res = mysql_query($sql) or die(mysql_error());
$rs = mysql_fetch_array($res);
$pIdx = $rs["idx"];
$hero_old_idx = $rs["hero_old_idx"];
$startDate = $rs["startDate"];
$endDate = $rs["endDate"];
$coreMember = $rs["coreMember"];
$adminSelectJoin = $rs["adminSelectJoin"];
$group_num = $rs["group_num"];
$adminSelectMemberCnt = 0;

$levelFlag = true;
$levelUse = 4;
$noAuthPage = false;

if(!$_SESSION["temp_id"] or !$_SESSION["temp_code"]){
    $noAuthPage = true; // no login
}

$pointUse = 300;
$point_sql = "select hero_point from member where hero_code = '".$_SESSION['temp_code']."'";
$point_res = mysql_query($point_sql) or die(mysql_error());
$point_rs = mysql_fetch_assoc($point_res);

if($adminSelectJoin == "Y") {
    $adminSelectMember_sql =  " SELECT count(*) cnt FROM  pointMallTempMember WHERE hero_code = '".$_SESSION['temp_code']."' ";
    $adminSelectMember_sql .= " AND group_num = '".$group_num."' ";
    $adminSelectMember_res = mysql_query($adminSelectMember_sql) or die(mysql_error());
    $adminSelectMember_rs =  mysql_fetch_assoc($adminSelectMember_res);

    $adminSelectMemberCnt = $adminSelectMember_rs["cnt"];
}


if( (strcmp($_SESSION['temp_level'], '10000')) && (strcmp($_SESSION['temp_level'], '9999')) ){
    if($pIdx && ((time() < $startDate && time() < $endDate) || ($startDate < time() && $endDate < time()))){
        //msg("구매기간이 아닙니다.", "history.back(-1);");
        //exit();
        $noAuthPage = true;
    }
    if($adminSelectJoin != "Y") {
        if($coreMember == "Y") {
            if($_SESSION['temp_level'] != "9994") {
                $noAuthPage = true;
            }
        }
    } else {
        if($adminSelectMemberCnt < 1) {
            $noAuthPage = true;
        }
    }
}



if($_POST['type']=='new'){
    if($adminSelectJoin == "Y") {
        if($adminSelectMemberCnt < 1) {
            msg('잘못된 정보입니다.','history.back(-1);');
            exit();
        }
    }

    if($_POST['goods_idx'] && $_POST['goods_point']){
        $possiblePoint = possiblePoint($_SESSION["temp_id"], $_SESSION["temp_code"]);

        $sql = "select hero_point, hero_quantity from goods where hero_idx=".$_POST['goods_idx'];
        $res = mysql_query($sql) or die(mysql_error());
        $rs = mysql_fetch_array($res);

        if($rs["hero_point"]!=$_POST['goods_point']){
            msg("잘못된 정보입니다.", "history.back(-1);");
            exit();
        }

        if($rs["hero_point"] > $possiblePoint){
            msg("구매포인트가 부족합니다.", "history.back(-1);");
            exit();
        }

        if($rs["hero_quantity"]){
            $sql="select * from member where hero_code='".$_SESSION["temp_code"]."'";
            $sql_member = mysql_query($sql) or die(mysql_error());
            $sql_member = mysql_fetch_assoc($sql_member);
            $order_number = "ODR".time();
            $val = "".$_POST['goods_idx'].",'".$sql_member["hero_id"]."','".$_SESSION["temp_code"]."','".$sql_member["hero_name"]."'";
            $val .= ",'".$sql_member["hero_nick"]."','".$order_number."','".$_PROCESS_ORDER."',".$_POST['goods_point'].",now()";
            $val .= ",'".$sql_member["hero_name"]."','".$sql_member["hero_hp"]."','".$sql_member["hero_hp"]."','".$sql_member["hero_address_02"]."'";
            $val .= ",'".$sql_member["hero_address_03"]."','".$sql_member["hero_mail"]."'";
            $sql  = " INSERT INTO order_main (goods_idx, hero_id, hero_code, hero_name, hero_nick ";
            $sql .= " , hero_order_number, hero_process, hero_order_point, hero_regdate, rcv_name, rcv_tel, rcv_mobile ";
            $sql .= " ,rcv_addr, rcv_addr_detail, rcv_email) ";
            $sql .= " VALUES($val) ";

            mysql_query($sql) or die("시스템 에러입니다. 다시 시도해 주시기 바랍니다.<br>".mysql_error());

            mysql_query("update goods set hero_quantity = hero_quantity - 1 where hero_idx=".$_POST['goods_idx']) or die(mysql_error());

            msg("구매 완료되었습니다.\\n\\n회원님 정보의 주소지로 배송되오니 \\n\\n반드시 확인바랍니다.", "location.href='/m/order.php?board=".$_GET['board']."';");
            exit();

        }else{
            msg("품절된 상품입니다.\\n\\n확인 후 다시 구매해주세요.", "location.href='/m/order.php?board=".$_GET['board']."';");
            exit();
        }
    }
}


$sql = 'select * from board where hero_table=\''.$_REQUEST['board'].'\' order by hero_today desc';
sql($sql,"on");
$total_data = @mysql_num_rows($out_sql);
######################################################################################################################################################
$list_page=12;
$page_per_list=5;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;

//https://aklover.co.kr:11486/m/board_00.php?board=group_01_01
$next_path=get("page||download");
######################################################################################################################################################
$group_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_REQUEST['board'].'\';';//desc
$out_group = @mysql_query($group_sql);
$right_list                             = @mysql_fetch_assoc($out_group);
######################################################################################################################################################
$sql = "select * from goods where hero_old_idx = '".$hero_old_idx."' AND hero_display='Y' ";
$total_data = mysql_query($sql);
$total_data = @mysql_num_rows($total_data);


######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
$right_list = mysql_query($sql);
$right_list = @mysql_fetch_assoc($right_list);

######################################################################################################################################################
$list_page=40;
$page_per_list=10;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board'].$search_next;


if($_SESSION["temp_id"] && $_SESSION["temp_code"]){
    $userPoint = userPoint($_SESSION["temp_id"], $_SESSION["temp_code"]);
    $possiblePoint = possiblePoint($_SESSION["temp_id"], $_SESSION["temp_code"]);
}
?>

<!--컨텐츠 시작-->
<div id="subpage" class="sub_festival">
    <div class="sub_title">
        <div class="sub_wrap">
            <div class="f_b">
                <h1 class="fz74 main_c fw500 ko">포인트 페스티벌</h1>
            </div>
            <p class="fz28 fw600">적립된 포인트로 애경 제품을 교환하는 특별 이벤트를 누려보세요!</p>
        </div>
    </div>
    <div class="contents">
        <?
        $title_view_all="";
        ?>
        <div class="clear">
            <form name="form_next" action="<?=$_SERVER["REQUEST_URI"]?>" method="post">
                <input type="hidden" name="type" value="">
                <input type="hidden" name="goods_idx" value="">
                <input type="hidden" name="goods_point" value="">
            </form>
        </div>
        <? if($noAuthPage) { ?>
            <? include_once("{$_SERVER[DOCUMENT_ROOT]}/m/notAuthPage.php"); ?>
        <? } else { ?>
            <div class="festival">
                <div class="cont_top">
                    <img src="/m/img/musign/pointmall/mall_top.jpg" alt="포인트몰 상단배너" class="mainbanner">
                    <!-- 포인트 축제 공지, 내 포인트 현황 -->
                    <ul class="info">
                        <li class="myPoint">
                            <div class="myPointBox">
                                <span class="myPointTit fz26 fw600 c_white"><img src="/img/front/pointmall/mypoint.webp" style="width: 14px" alt="내 포인트 정보">My Points</span>
                                <ul class="myPointList">
                                    <? if($_SESSION["temp_id"]=="" or $_SESSION["temp_code"]==""){ ?>
                                        <li class="fz66 fw500">로그인을 해주세요.</li>
                                    <? }else{ ?>
                                        <li class="fz48 main_c en"><span class="fz66 en"><?=number_format($possiblePoint)?></span>P</li>
                                    <? } ?>
                                </ul>
                                <ul class="myPointInfo">
                                    <li class="f_b">
                                        <p class="fz28 fw600"><img src="/img/front/pointmall/coin.webp" style="width: 16px" alt="포인트 내역">포인트 내역</p>
                                        <a href="/m/mypoint.php?board=mypoint"><span class="fz24">바로가기</span><img src="/img/front/main/btn_right.webp" alt="바로가기"></a>
                                    </li>
                                    <li class="f_b">
                                        <p class="fz28 fw600"><img src="/img/front/pointmall/order.webp"  style="width: 16px" alt="제품 교환내역">제품 교환내역</p>
                                        <a href="/m/orderList.php?board=orderlist"><span class="fz24">바로가기</span><img src="/img/front/main/btn_right.webp" alt="바로가기"></a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="pointNotice">
                            <div class="noticeTitBox">
                                <span class="fz26 fw600">유의사항</span>
                            </div>
                            <p class="fz24">
                                - 포인트 페스티벌 후 잔여 포인트는 아래와 같이 적용됩니다.<br />
                                &nbsp;&nbsp;(상반기 페스티벌 : 소멸 X / 하반기 페스티벌 : 소멸 O)<br />
                                - 교환 제품 변경 및 취소는 포인트 페스티벌 진행 기간 내에만 가능합니다.<br />
                                - 교환 제품은 재고 상황에 따라 변경될 수 있습니다.
                            </p>
                        </li>
                    </ul>
                </div>
                <!--!!!!!!!! [개발요청] 제품 카테고리 -- 위치 이동 필요하면 말씀해주세요 [완]!!!!!!!!  -->
                <div class="tab">
                    <ul class="flex">
                        <li <?if($_GET['cate']==  '') echo 'class="active"'?> data-cate="">전체보기</li>
                        <li <?if($_GET['cate']=='BT') echo 'class="active"'?> data-cate="BT">뷰티</li>
                        <li <?if($_GET['cate']=='PC') echo 'class="active"'?> data-cate="PC">퍼스널케어</li>
                        <li <?if($_GET['cate']=='HC') echo 'class="active"'?> data-cate="HC">홈케어</li>
                    </ul>
                </div>

                <script>
                    $(document).ready(function(){
                        const tabLi = $('.tab li');
                        $.each(tabLi, function(idx, item){
                            $(this).click(function(){
                                //musign S
                                // tabLi.removeClass('active');
                                // $(this).addClass('active');

                                const dataCate = $(this).data('cate');
                                <? echo 'location.href=\'/m/order.php?board='.$_GET['board'].'&cate=';?>'+dataCate;
                                //musign E
                            });
                        });
                    });
                </script>

                <!-- gallery 시작 -->
                <div class="blog_article orderlist">
                    <?
                    $sql = "select * from goods where hero_old_idx = '".$hero_old_idx."' AND hero_display='Y' and hero_quantity > 0 ".$search." order by hero_order_num asc, hero_idx desc";
                    $main_sql = $sql.' limit '.$start.','.$list_page.';';
                    $out_main = @mysql_query($main_sql);
                    $i="0";

                    while($main_list                             = @mysql_fetch_assoc($out_main)){
                        $img_parser_url = $main_list['hero_image'];
                        $img_host = $img_parser_url['host'];
                        if($img_parser_url){
                            $view_img = $main_list['hero_image'];
                        }else if(!strcmp($img_parser_url,'')){
                            $view_img = IMAGE_END.'hero.jpg';
                        }

                        $content = number_format($main_list['hero_point']);
                        $content = str_replace("\r", "", $content);
                        $content = str_replace("\n", "", $content);
                        $content = str_replace("&#65279;", "", $content);
                        if(!strcmp($content,"")){
                            $content = "&nbsp;";
                        }
                        $title = $main_list['hero_name'];
                        $title = str_replace("\r", "", $title);
                        $title = str_replace("\n", "", $title);
                        $title = str_replace("&#65279;", "", $title);
                        $title_01 = cut($title,'50');
                        if(!strcmp($title_01,"")){
                            $title_01 = "&nbsp;";
                        }
                        if(!strcmp(y."-".m."-".d, date( "y-m-d", strtotime($main_list['hero_today'])))){
                            $new_img_view = " <img src='".DOMAIN_END."image/main_new_bt.png' alt='new' />";
                        }else{
                            $new_img_view = "";
                        }

                        if(strcmp($list['hero_info_href'],'')){
                            $hero_info_href = 'href='.$list['hero_info_href'];

                        }else{
                            $hero_info_href = '';
                        }

                        if($_SESSION["temp_id"] && $_SESSION["temp_code"]){
                            $script = "goodsBuy(".$main_list['hero_point'].", ".$possiblePoint.", ".$main_list['hero_idx'].");";
                        }else{
                            $script = "alert('로그인 후 이용가능합니다');";
                        }
                        $pk_sql = 'select a.hero_level,a.hero_nick,b.hero_img_new from member as a, level as b  where b.hero_level = a.hero_level and a.hero_code = \''.$main_list['hero_code'].'\'';
                        $out_pk_sql = mysql_query($pk_sql);
                        $pk_row                             = @mysql_fetch_assoc($out_pk_sql);
                        ?>
                        <div>
                            <div class='top'>
                                <a $hero_info_href target="_blank"><img onerror="this.src='<?=IMAGE_END?>hero.jpg'" src="<?=$view_img?>" width="100%"/></a>
                            </div>
                            <div class="desc">
                                <b class="tag bold c_white">P</b>
                                <span class="txt fz26 bold main_c"><?=$content?>P</span>
                                <? if($main_list['hero_quantity'] < $main_list['hero_sold_out_quantity']) {?>
                                    <b class="endnoti fz26 bold main_c">품절임박</b>
                                <?}?>
                                <span class="title fz26 fw500 ellipsis_2line"><?=$title_01?></span>
                                <span class="sub fz24 op05 ellipsis_100" ><?=$main_list['hero_info']?></span>
                            </div>
                            <span onclick="<?=$script?>" class="label_button btn_buy">교환하기</span>
                        </div>
                        <?
                        $i++;
                    }
                    ?>
                    <?

                    $sql = "select * from goods where hero_old_idx = '".$hero_old_idx."' AND hero_display='Y' and hero_quantity = 0 ".$search." order by hero_order_num ASC, hero_idx desc";
                    $main_sql = $sql.' limit '.$start.','.$list_page.';';
                    $out_main = @mysql_query($main_sql);
                    $i="0";

                    while($main_list                             = @mysql_fetch_assoc($out_main)){

                        $img_parser_url = $main_list['hero_image'];
                        $img_host = $img_parser_url['host'];
                        if($img_parser_url){
                            $view_img = $main_list['hero_image'];
                        }else if(!strcmp($img_parser_url,'')){
                            $view_img = IMAGE_END.'hero.jpg';
                        }

                        $content = number_format($main_list['hero_point']);
                        $content = str_replace("\r", "", $content);
                        $content = str_replace("\n", "", $content);
                        $content = str_replace("&#65279;", "", $content);
                        if(!strcmp($content,"")){
                            $content = "&nbsp;";
                        }
                        $title = $main_list['hero_name'];
                        $title = str_replace("\r", "", $title);
                        $title = str_replace("\n", "", $title);
                        $title = str_replace("&#65279;", "", $title);
                        $title_01 = cut($title,'50');
                        if(!strcmp($title_01,"")){
                            $title_01 = "&nbsp;";
                        }
                        if(!strcmp(y."-".m."-".d, date( "y-m-d", strtotime($main_list['hero_today'])))){
                            $new_img_view = " <img src='".DOMAIN_END."image/main_new_bt.png' alt='new' />";
                        }else{
                            $new_img_view = "";
                        }

                        ?>
                        <div>
                            <div class='top rel soldout'>
                                <a $hero_info_href target="_blank"><img onerror="this.src='<?=IMAGE_END?>hero.jpg'" src="<?=$view_img?>" width="100%"/></a>
                            </div>
                            <div class="desc soldout">
                                <b class="tag bold c_white">P</b>
                                <span class="txt fz26 bold op05"><?=$content?>P</span>
                                <span class="title fz26 fw500 ellipsis_2line"><?=$title_01?></span>
                                <!--!!!!!!!! [개발요청] 서브텍스트 노출 !!!!!!!!  -->
                                <span class="sub fz24 op05 ellipsis_100" ><?=$main_list['hero_info']?></span>
                            </div>
                            <span class="fz15 fw600 soldout_txt">품절</span>
                        </div>
                        <?
                        $i++;
                    }
                    ?>
                </div>
                <div id="page_number" class="paging">
                    <?include_once "page.php"?>
                    <?
                    $sql = 'select * from hero_group where hero_board = \''.$_GET['board'].'\'';
                    sql($sql, 'on');
                    $check_list                             = @mysql_fetch_assoc($out_sql);
                    if($check_list['hero_write']<=$_SESSION['temp_write']){
                        ?>
                        <!-- <span class="gallery_btn">
						<a href="<?=DOMAIN_END?>/m/write.php?board=<?=$_REQUEST['board']?>&action=write" ><img src="img/general/write_btn.jpg" alt="글쓰기" width="70px"></a>
					</span>  -->
                    <?}?>
                </div>
            </div>
        <? } ?>
    </div>
</div>


<!--컨텐츠 종료-->

<script>
    <? if(!strcmp($_REQUEST['download'],"ok")){?>
    downMenu();
    <? }?>

    // 카테고리 이동 시 스크롤 위치 고정
    const searchParams = new URLSearchParams(location.search);
    const tabOffsetTop = document.querySelector(".tab");
    let isCate = searchParams.get('cate');

    if((isCate || isCate === "") && tabOffsetTop !== null){
        const eleTop = tabOffsetTop.offsetTop;
        window.scrollTo({
            top: eleTop - 70,
            left: 0,
            behavior: "instant"
        });
    }
</script>


<?include_once "tail.php";?>