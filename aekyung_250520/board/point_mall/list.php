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

// musign cart S 241119
// 장바구니 담기 sql
if ($_POST['type']=='cart') {
    if($_POST['goods_idx'] && $_POST['goods_point']){
        $val = "'".$_SESSION["temp_id"]."','".$_SESSION["temp_code"]."','".$_POST['goods_idx']."','".$_POST['goods_point']."',now()";
        //$val = "''".$_SESSION["temp_id"].",'".$_SESSION["temp_code"]."','".$_POST['goods_idx']."','".$_POST['goods_point']."',now()";
        $sql  = " INSERT INTO cart (hero_id, hero_code, goods_idx, goods_point, regDt) ";
        $sql .= " VALUES($val) ";
        mysql_query($sql) or die("시스템 에러입니다. 다시 시도해 주시기 바랍니다.<br>".mysql_error());
        //msg('상품이 장바구니에 담겼습니다.','history.back(-1);');
        echo "<script>history.back(-1);</script>";
        exit();
    }
}
// 장바구니 상품 전체 구매하기
if ($_POST['type']=='allGoodsBuy') {


    if($adminSelectJoin == "Y") {
        if($adminSelectMemberCnt < 1) {
            msg('잘못된 정보입니다.','history.back(-1);');
            exit();
        }
    }

    // 로그인한 회원의 cart goods_idx/goods_point 추출
    $sql = "select idx, goods_idx, goods_point from cart where hero_id='".$_SESSION["temp_id"]."'";
    $res = mysql_query($sql) or die(mysql_error());

    $goods = array(); // 상품정보를 배열로 저장 처리
    while ($row = mysql_fetch_array($res)) {
        $goods[] = array('idx' => $row['idx'], 'goods_idx' => $row['goods_idx'], 'goods_point' => $row['goods_point']);
        $goods_idx_list[] = $row['goods_idx'];
    }

    $goods_idx_list_str = implode(',', $goods_idx_list);

    // 로그인한 회원의 포인트 조회
    $possiblePoint = possiblePoint($_SESSION["temp_id"], $_SESSION["temp_code"]);

    // cart 테이블에서 hero_idx에 해당하는 hero_point의 합계 계산
    $sql = "SELECT SUM(goods_point) as totalPoint FROM cart WHERE hero_id='".$_SESSION["temp_id"]."'";
    $res = mysql_query($sql) or die(mysql_error());
    $rs = mysql_fetch_array($res);
    $totalPoint = $rs['totalPoint'];
    
    // 장바구니에 담긴 제품의 총 포인트 합과 보유 포인트 비교
    if ($totalPoint > $possiblePoint) {
        msg("구매포인트가 부족합니다.", "history.back(-1);");
        exit();
    }

    
    // 조회된 상품 갯수 만큼 기존 상품구매 로직 반복
    foreach ($goods as $item) {

        $sql = "select hero_point, hero_quantity from goods where hero_idx=".$item['goods_idx'];
        $res = mysql_query($sql) or die(mysql_error());
        $rs = mysql_fetch_array($res);

        if($rs["hero_quantity"]){
            $sql="select * from member where hero_code='".$_SESSION["temp_code"]."'";
            $sql_member = mysql_query($sql) or die(mysql_error());
            $sql_member = mysql_fetch_assoc($sql_member);
            $order_number = "ODR".time();
            $val = "'',".$item['goods_idx'].",'".$sql_member["hero_id"]."','".$_SESSION["temp_code"]."','".$sql_member["hero_name"]."'";
           // $val = "".$item['goods_idx'].",'".$sql_member["hero_id"]."','".$_SESSION["temp_code"]."','".$sql_member["hero_name"]."'";
            $val .= ",'".$sql_member["hero_nick"]."','".$order_number."','".$_PROCESS_ORDER."',".$item['goods_point'].",now()";
            $val .= ",'".$sql_member["hero_name"]."','".$sql_member["hero_hp"]."','".$sql_member["hero_hp"]."','".addslashes($sql_member["hero_address_02"])."'";
            $val .= ",'".$sql_member["hero_address_03"]."','".$sql_member["hero_mail"]."'";
            $sql  = " INSERT INTO order_main (hero_idx, goods_idx, hero_id, hero_code, hero_name, hero_nick ";
            //$sql  = " INSERT INTO order_main (goods_idx, hero_id, hero_code, hero_name, hero_nick ";
            $sql .= " , hero_order_number, hero_process, hero_order_point, hero_regdate, rcv_name, rcv_tel, rcv_mobile ";
            $sql .= " ,rcv_addr, rcv_addr_detail, rcv_email) ";
            $sql .= " VALUES($val) ";

            mysql_query($sql) or die("시스템 에러입니다. 다시 시도해 주시기 바랍니다.<br>".mysql_error());

            // 구매 상품 재고 차감
            $sql_quantity = "update goods set hero_quantity = hero_quantity - 1 where hero_idx=".$item['goods_idx'];
            mysql_query($sql_quantity) or die(mysql_error());


            // 구매완료된 상품의 정보를 장바구니에서 삭제
            $sql_del = "delete from cart where idx=".$item['idx'];
            mysql_query($sql_del) or die(mysql_error());

        }else{
            msg("품절된 상품입니다.\\n\\n확인 후 다시 구매해주세요.", "location.href='".PATH_HOME."?board=".$_GET['board']."&cate=".$_GET['cate']."';");
            exit();
        }

    }

    msg("제품 교환이 완료되었습니다.\\n\\n회원 정보에 기재된 주소지로 배송되오니 페스티벌 기간 내 꼭 확인하시기 바랍니다. \\n\\n※ 주소지 확인 경로 [ 마이페이지 → 나의 정보 변경 → 주소 ]", "location.href='".PATH_HOME."?board=".$_GET['board']."&cate=".$_GET['cate']."';");
    exit();
}

// 장바구니 상품 삭제하기
if ($_POST['type']=='goodsDel') {
    if($_POST['cart_idx']){
        $sql = "delete from cart where idx = ".$_POST['cart_idx'];
        mysql_query($sql) or die("시스템 에러입니다. 다시 시도해 주시기 바랍니다.<br>".mysql_error());
       // msg('상품이 장바구니에서 삭제되었습니다.','history.back(-1);');
        echo "<script>history.back(-1);</script>";
        echo "<script>sessionStorage.setItem('isDelete', 'true');</script>";
        exit();
    }
}

// 장바구니 상품 전체 삭제하기
if ($_POST['type']=='goodsAllDel') {
    $sql = "delete from cart where hero_id='".$_SESSION["temp_id"]."'";
    mysql_query($sql) or die("시스템 에러입니다. 다시 시도해 주시기 바랍니다.<br>".mysql_error());
    //msg('상품이 장바구니서 삭제되었습니다.','history.back(-1);');
    echo "<script>history.back(-1);</script>";
    exit();
}


// musign cart E 241119

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
            <input type="hidden" name="cart_idx" value=""> <!-- musign cart value 추가 //241119 -->
            <div class="cont_top">
                <div class="flex">
                    <img src="/img/front/pointmall/season2/pointmall.png" alt="포인트몰 상단배너" class="mainbanner">
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
                            // musign cart S 241119
                            $script = "goodsCart(".$list['hero_point'].", ".$list['hero_idx'].");";
                            //musign cart E 기존 goodsbuy 함수에서 goodscart로 교체
                           // $script = "goodsBuy(".$list['hero_point'].", ".$possiblePoint.", ".$list['hero_idx'].");";
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
                            // musign cart S 241119
                            echo '<span class="label_button btn_buy" onclick="Javascript:'.$script.'" style="cursor:pointer;">장바구니 담기</span>'.PHP_EOL;
                            // musign cart E 기존 교환하기 에서 장바구니 담기로 버튼 교체
                           // echo '<span class="label_button btn_buy" onclick="Javascript:'.$script.'" style="cursor:pointer;">교환하기</span>'.PHP_EOL;
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

                <!-- musign cart S //241119-->
                <!-- 장바구니 layer 영역. 해당 부분 퍼블리싱 진행 해주세요! -->
                <?
                // 해당 유저의 장바구니 정보 호출
                $sql = "SELECT c.idx AS cart_idx, c.hero_id,g.* FROM cart c INNER JOIN goods g ON c.goods_idx = g.hero_idx WHERE c.hero_id = '".$_SESSION["temp_id"]."'";
                $sql .= "ORDER BY c.idx asc ";
                $sql_cart = mysql_query($sql);
                $cart_count = mysql_num_rows($sql_cart);

                // cart 에 담긴 상품의 total 포인트 가져오기
                $sql_sum = "SELECT SUM(c.goods_point) AS total_goods_point FROM cart c WHERE c.hero_id = '".$_SESSION["temp_id"]."'";
                $res_sum = mysql_query($sql_sum) or die(mysql_error());
                $row_sum = mysql_fetch_array($res_sum);

                $total_goods_point = $row_sum['total_goods_point'];

               // 장바구니 영역 미리보기 노출
               echo '<div class="festival_bottom_cart">';
               echo '<div class="btn_extension"><img src="/img/front/member/arr.webp" alt="화살표" /></div>';
               echo '<div class="cart_top preview"><div class="f_c"><span class="fz20 fw700">장바구니</span><span class="cart_num fz12 fw700">('.$cart_count.')</span>';
               echo '<span class="reset bold fz15" onclick="Javascript:goodsAllDel();">장바구니 초기화 <img src="/img/front/pointmall/refresh.png" alt="새로고침" /></span></div>';
               echo '<div class="f_c"><div class="point_product fz16 fw600">총 <span class="highlight">'.$cart_count.'개</span> 상품 (총 <span class="highlight">'.number_format($total_goods_point).'</span>포인트)</div>';
               echo '<button class="btn_cart" onclick="Javascript:allGoodsBuy();" style="cursor:pointer;">포인트로 교환하기</button>';
               echo '</div></div>';

               // 장바구니 리스트 활성화 시, 노출되는 상단 UI
               echo '<div class="cart_top f_c"><p class="fz20 fw700">장바구니 <span class="count fz12 fw700">('.$cart_count.')</span></p>';
               echo '<p class="reset bold fz15" onclick="Javascript:goodsAllDel();">장바구니 초기화 <img src="/img/front/pointmall/refresh.png" alt="새로고침" /></p>';
               echo '</div>';

               echo '<div class="cart_list grid_2">';
                while($list = @mysql_fetch_assoc($sql_cart)){
                    echo '<div class="flex"><img src="'.$list['hero_image'].'" class="thumb">';
                    echo '<div class="desc"><p class="fz16 ellipsis_2line">'.$list['hero_name'].'</p>';
                    echo '<p class="price fz14 fw700 f_cs"><b class="tag bold c_white">P</b> '.number_format($list['hero_point']).'P</p></div>';
                    echo '<span class="delete" onclick="Javascript:goodsDel('.$list['cart_idx'].')" style="cursor:pointer;"><img src="/img/front/pointmall/icon_close.png" alt="삭제" /></span>';
                    echo '</div>';
                }
                echo '</div>';

                echo '<div class="rel f_c"><div class="point_product fz16 fw600 act_point">총 <span class="highlight">'.$cart_count.'개</span> 상품 (총 <span class="highlight">'.number_format($total_goods_point).'</span>포인트)</div>';
                echo '<button class="btn_cart" onclick="Javascript:allGoodsBuy();" style="cursor:pointer;">포인트로 교환하기</button>';
                echo '</div>';
                ?>

                <!-- musign cart E -->
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

    // 장바구니 고정
    const cartContainer = document.querySelector(".festival_bottom_cart");
    const extensionBtn = document.querySelector(".btn_extension");
    const previewCart = document.querySelector(".preview");

    function getBottomCartList() {
        [cartContainer, previewCart, extensionBtn].forEach((item, _) => {
            item.classList.toggle("active");
        })
    }

    extensionBtn.addEventListener("click", function(){
        getBottomCartList();
    });

    // 아이템 삭제 시 장바구니 바텀시트 active 유지하기
    window.onpageshow = function (event){
        // 뒤로가기로 페이지 접근했는지 확인
        if((event.persisted || (window.performance && window.performance.navigation.type == 2))){
            const isDelete = sessionStorage.getItem("isDelete");
            if(isDelete) {
                getBottomCartList();
                sessionStorage.removeItem("isDelete");
            }
        }
    }

    // 장바구니가 비었을 때, 해당 텍스트 렌더링
    const cartList = document.querySelector(".cart_list");
    const cartItems = document.querySelectorAll(".cart_list > div");

    if(!cartItems.length){
        const pTag = document.createElement("p");
        pTag.setAttribute('class', 'blank');
        pTag.innerText = "장바구니가 비어 있습니다.";
        cartList.appendChild(pTag);
    }

</script>