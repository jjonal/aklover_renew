<link rel="stylesheet" type="text/css" href="/css/front/pointmall.css" />
<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################

$sql = "select * from order_period";
$res = mysql_query($sql) or die(mysql_error());
$rs = mysql_fetch_array($res);
$pIdx = $rs["idx"];
$season = $rs["season"];
$hero_old_idx = $rs["hero_old_idx"];


$startDate = $rs["startDate"];
$endDate = $rs["endDate"];
$coreMember = $rs["coreMember"];
$adminSelectJoin = $rs["adminSelectJoin"];
$group_num = $rs["group_num"];
$adminSelectMemberCnt = 0;


$levelFlag = true;
$levelUse = 4;
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


$noAuthPage = false;
//로그인 여부
if(!$_SESSION["temp_id"] or !$_SESSION["temp_code"]){
    $noAuthPage = true; // no login

    /*msg('로그인 후 이용가능합니다.','location.href="'.PATH_HOME.'?board=login"');
    exit();*/
}
//관리자 여부 확인
if( (strcmp($_SESSION['temp_level'], '10000')) && (strcmp($_SESSION['temp_level'], '9999'))){
    //기간 확인
    if($pIdx && ((time() < $startDate && time() < $endDate) || ($startDate < time() && $endDate < time()))){
        $noAuthPage = true; // no date

        /*msg("구매기간이 아닙니다.", "history.back(-1);");
        exit();*/
    }
    //관리자 회원선택 여부
    if($adminSelectJoin != "Y") {
        if($coreMember == "Y") { //모르겠음
            $noAuthPage = true;
        }
    } else {
        if($adminSelectMemberCnt < 1) { //관리자 선택 그룹번호
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
            $val = "'',".$_POST['goods_idx'].",'".$sql_member["hero_id"]."','".$_SESSION["temp_code"]."','".$sql_member["hero_name"]."'";
            $val .= ",'".$sql_member["hero_nick"]."','".$order_number."','".$_PROCESS_ORDER."',".$_POST['goods_point'].",now()";
            $val .= ",'".$sql_member["hero_name"]."','".$sql_member["hero_hp"]."','".$sql_member["hero_hp"]."','".$sql_member["hero_address_02"]."'";
            $val .= ",'".$sql_member["hero_address_03"]."','".$sql_member["hero_mail"]."'";
            $sql  = " INSERT INTO order_main (hero_idx, goods_idx, hero_id, hero_code, hero_name, hero_nick ";
            $sql .= " , hero_order_number, hero_process, hero_order_point, hero_regdate, rcv_name, rcv_tel, rcv_mobile ";
            $sql .= " ,rcv_addr, rcv_addr_detail, rcv_email) ";
            $sql .= " VALUES($val) ";

            mysql_query($sql) or die("시스템 에러입니다. 다시 시도해 주시기 바랍니다.<br>".mysql_error());
            //musign 수정
            $sql_quantity = "update goods set hero_quantity = hero_quantity - 1 where hero_idx=".$_POST['goods_idx'];
            mysql_query($sql_quantity) or die(mysql_error());
            //musign 수정
            msg("구매 완료되었습니다.\\n\\n회원님 정보의 주소지로 배송되오니 \\n\\n반드시 확인바랍니다.", "location.href='".PATH_HOME."?board=".$_GET['board']."&cate=".$_GET['cate']."';");
            exit();
        }else{
            msg("품절된 상품입니다.\\n\\n확인 후 다시 구매해주세요.", "location.href='".PATH_HOME."?board=".$_GET['board']."&cate=".$_GET['cate']."';");
            exit();
        }
    }
}

######################################################################################################################################################
$cut_count_name = '6';
$cut_title_name = '23';



######################################################################################################################################################
if(strcmp($_POST['kewyword'], '')){
    $search = ' and '.$_POST['select'].' like \'%'.$_POST['kewyword'].'%\'';
    $search_next = '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
}else if(strcmp($_GET['kewyword'], '')){
    $search = ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
    $search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
}



######################################################################################################################################################
$sql = "select * from goods where hero_old_idx = '".$hero_old_idx."' AND hero_display='Y' ".$search;
$total_data = mysql_query($sql);
$total_data = @mysql_num_rows($total_data);



######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
$right_list = mysql_query($sql);
$right_list = @mysql_fetch_assoc($right_list);




######################################################################################################################################################
$list_page=6;
$page_per_list=10;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board'].$search_next;


if($_SESSION["temp_id"] && $_SESSION["temp_code"]){
    $userPoint = userPoint($_SESSION["temp_id"], $_SESSION["temp_code"]);
    $possiblePoint = possiblePoint($_SESSION["temp_id"], $_SESSION["temp_code"]);
}
?>

<div id="subpage" class="sub_festival">
    <div class="sub_title">
        <div class="sub_wrap">
            <div class="f_b">
                <h1 class="fz68 main_c fw500 ko">포인트 페스티벌</h1>
            </div>
            <p class="fz18 fw600">적립된 포인트로 애경 제품을 교환하는 특별 이벤트를 누려보세요!</p>
        </div>
    </div>
    <div class="contents">
        <div class="sub_wrap">
            <?
            if( $noAuthPage ) {
                include_once("{$_SERVER[DOCUMENT_ROOT]}/include/notAuthPage.php");
            }else {
            ?>
            <div class="festival">
                <form name="form_next" action="<?=$_SERVER["REQUEST_URI"]?>" method="post">
                    <input type="hidden" name="type" value="">
                    <input type="hidden" name="goods_idx" value="">
                    <input type="hidden" name="goods_point" value="">
                    <div class="cont_top">
                        <div class="flex">
                            <img src="/img/front/pointmall/mall_top.png" alt="포인트몰 상단배너" class="mainbanner">
                            <!-- 포인트 축제 공지, 내 포인트 현황 -->
                            <ul class="blog_article2 info">
                                <li class="myPoint">
                                    <div class="myPointBox">
                                        <span class="myPointTit fz18 fw600 c_white"><img src="/img/front/pointmall/mypoint.webp" alt="내 포인트 정보">My Points</span>
                                        <ul class="myPointList">
                                            <? if($_SESSION["temp_id"]=="" or $_SESSION["temp_code"]==""){ ?>
                                                <li class="fz48 fw500">로그인을 해주세요.</li>
                                            <? }else{ ?>
                                                <li class="fz38 main_c en"><span class="fz48 en"><?=number_format($possiblePoint)?></span>P</li>
                                            <? } ?>
                                        </ul>
                                        <ul class="myPointInfo">
                                            <li class="f_b">
                                                <p class="fz18 fw600"><img src="/img/front/pointmall/coin.webp" alt="포인트 내역">포인트 내역</p>
                                                <a href="/main/index.php?board=mypoint"><span class="fz15">바로가기</span><img src="/img/front/main/btn_right.webp" alt="바로가기"></a>
                                            </li>
                                            <li class="f_b">
                                                <p class="fz18 fw600"><img src="/img/front/pointmall/order.webp" alt="제품 교환내역">제품 교환내역</p>
                                                <a href="/main/index.php?board=orderlist"><span class="fz15">바로가기</span><img src="/img/front/main/btn_right.webp" alt="바로가기"></a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="pointNotice">
                                    <div class="noticeTitBox">
                                        <span class="fz17 fw600">유의사항</span>
                                    </div>
                                    <p class="fz14">
                                        - 포인트 페스티벌 후 잔여 포인트는 아래와 같이 적용됩니다.<br />
                                        &nbsp;&nbsp;(상반기 페스티벌 : 소멸 X / 하반기 페스티벌 : 소멸 O)<br />
                                        - 교환 제품 변경 및 취소는 포인트 페스티벌 진행 기간 내에만 가능합니다.<br />
                                        - 교환 제품은 재고 상황에 따라 변경될 수 있습니다.
                                    </p>
                                </li>
                            </ul>
                            <!-- 포인트 구매 상품 내역 -->
                        </div>
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
                                    <? echo 'location.href=\''.PATH_HOME.'?board='.$_GET['board'].'&cate=';?>'+dataCate;
                                    //musign E
                                });
                            });
                        });
                    </script>

                    <ul class="blog_article grid_4">
                        <?
                        if($_GET['cate'] != ''){
                            $cate = "AND hero_cate2 = '".$_GET['cate']."'";
                        }else {
                            $cate = "";
                        }

                        $sql  = "SELECT * FROM goods WHERE hero_old_idx = '".$hero_old_idx."' AND hero_display='Y' AND hero_quantity > 0 ".$search." ";
                        $sql .= $cate;
                        $sql .= "ORDER BY hero_order_num ASC, hero_idx DESC ";
                        $sql_goods = mysql_query($sql);
                        $data_count = mysql_num_rows($sql_goods);
                        $view_count = '4';

                        $i = '1';
                        $dd = '1';
                        $total_chack = $data_count;

                        $cut_title_name = '100';
                        $cut_command_name = '50';

                        while($list = @mysql_fetch_assoc($sql_goods)){
                            //musign S
                            $optionCheck = '';
                            $optionMusign = array();
                            //musign E
                            $img_parser_url = @parse_url($list['hero_image']);
                            $img_host = $img_parser_url['host'];
                            $img_path = $img_parser_url['path'];
                            //musign S
                            $optionMusign = explode('^_^', $list['hreo_options']);
                            if(!empty($optionMusign[0])) {
                                $optionCheck = 'y';
                            }
                            //musign E

                            //musign 주석 S
                            /*if (strcmp($dd,'3')){
                                echo '                    <li >'.PHP_EOL;
                            }else if(!strcmp($dd,'3')){
                                echo '                    <li class="last">'.PHP_EOL;
                                $dd = '0';
                            }*/
                            //musign 주석 E

                            //썸네일
                            if(!strcmp($list['hero_image'],'')){
                                $view_img = IMAGE_END.'hero.jpg'; //썸네일 기본이미지
                            }else{
                                $view_img = $list['hero_image'];
                            }
                            //제품설명 링크
                            if(strcmp($list['hero_info_href'],'')){
                                $hero_info_href = 'href='.$list['hero_info_href'];
                            }else{
                                $hero_info_href = '';
                            }
                            //제품명
                            $new_content = "상품명:".$list['hero_name'];

                            if($_SESSION["temp_id"] && $_SESSION["temp_code"]){
                                $script = "goodsBuy(".$list['hero_point'].", ".$possiblePoint.", ".$list['hero_idx'].");";
                            }else{
                                $script = "alert('로그인 후 이용가능합니다');";
                            }

                            echo '                        <div title="'.$new_content.'"><div class="top">'.PHP_EOL;
                            echo '                            <a '.$hero_info_href.' target="_blank"><img src="'.$view_img.'" />'.PHP_EOL.'</a>';
                            echo '                        </div>'.PHP_EOL;
                            echo '                            <div class="desc"><b class="tag fz13 bold c_white">P</b><span class="txt fz20 bold main_c">'.number_format($list['hero_point']).'P</span>'.PHP_EOL;
                            if($list['hero_quantity'] < $list['hero_sold_out_quantity']){
                                echo '                            <b class="endnoti fz20 bold main_c">품절임박</b>'.PHP_EOL;
                            }
                            echo '                            <span class="title fz18 fw500 ellipsis_2line" >'.$list['hero_name'].'</span>'.PHP_EOL;
                            echo '                            <span class="sub fz18 op05 ellipsis_100" >'.$list['hero_info'].'</span></div>'.PHP_EOL;
                            if($optionCheck == 'y') {
                                $script = "optionsCheck();";
                                echo '<span class="label_button btn_buy" onclick="Javascript:'.$script.'" style="cursor:pointer;">교환하기</span>'.PHP_EOL;
                            }
                            else{
                                echo '<span class="label_button btn_buy" onclick="Javascript:'.$script.'" style="cursor:pointer;">교환하기</span>'.PHP_EOL;
                            }
                            echo '                        </div>'.PHP_EOL;
                            echo '                    </li>'.PHP_EOL;

                            $i++;
                            $dd++;
                            $total_chack--;
                        }

                        $sql  = "select * from goods where hero_old_idx = '".$hero_old_idx."' AND hero_display='Y' and hero_quantity = 0 ".$search." ";
                        $sql .= $cate;
                        $sql .= "order by hero_order_num asc, hero_idx desc";
                        $sql_goods = mysql_query($sql);
                        while($list = @mysql_fetch_assoc($sql_goods)){
                            $img_parser_url = @parse_url($list['hero_image']);
                            $img_host = $img_parser_url['host'];
                            $img_path = $img_parser_url['path'];

                            if (strcmp($dd,'3')){
                                echo '                    <li >'.PHP_EOL;
                            }else if(!strcmp($dd,'3')){
                                echo '                    <li class="last" >'.PHP_EOL;
                                $dd = '0';
                            }

                            if(!strcmp($list['hero_image'],'')){
                                $view_img = IMAGE_END.'hero.jpg';

                            }else{
                                $view_img = $list['hero_image'];
                            }

                            $new_content = "상품명:".$list['hero_name'];

                            echo '                        <div title="'.$new_content.'"><div class="top rel soldout">'.PHP_EOL;
                            echo '                            <img src="'.$view_img.'" >'.PHP_EOL;
                            echo '                        </div>'.PHP_EOL;
                            echo '                           <div class="desc soldout"><b class="tag fz13 bold c_white">P</b><span class="txt fz20 bold op05">'.number_format($list['hero_point']).'P</span>'.PHP_EOL;
                            echo '                            <span class="title  fz18 fw500 ellipsis_2line"> '.cut($list['hero_name'], $cut_title_name).'</span>'.PHP_EOL;
                            echo '                            <span class="sub fz16 op05 ellipsis_100" >'.$list['hero_info'].'</span></div>'.PHP_EOL;
                            echo "							<span class='fz15 fw600 soldout_txt'>품절</span>".PHP_EOL;
                            echo '                        </div>'.PHP_EOL;
                            echo '                    </li>'.PHP_EOL;

                            $i++;
                            $dd++;
                            $total_chack--;
                        }
                        ?>
                    </ul>
                </form>
            </div>
            <div class="btngroup">
                <div class="paging">
                    <?
                    //echo page($total_data,$list_page,$page_per_list,$_GET[page],$next_path);
                    ?>
                </div>
                <div class="btn_r"></div>
                <? }?>
            </div>
        </div>
    </div>
</div>
<!-- </div> -->

<script>
    // 카테고리 이동 시 스크롤 위치 고정
    const searchParams = new URLSearchParams(location.search);
    const tabOffsetTop = document.querySelector(".tab");
    let isCate = searchParams.get('cate');

    if((isCate || isCate === "") && tabOffsetTop !== null){
        const eleTop = tabOffsetTop.offsetTop;
        window.scrollTo({
            top: eleTop - 130,
            left: 0,
            behavior: "instant"
        });
    }
</script>