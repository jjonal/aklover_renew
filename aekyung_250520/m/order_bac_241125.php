<link rel="stylesheet" type="text/css" href="/m/css/musign/pointmall.css" />
<?
include_once "head.php";

if($_GET['board']!="group_04_21"){
    echo "<script>alert('�� ���� �����Դϴ�.');location.href='/m/main.php'</script>";
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
        //msg("���űⰣ�� �ƴմϴ�.", "history.back(-1);");
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
            msg('�߸��� �����Դϴ�.','history.back(-1);');
            exit();
        }
    }

    if($_POST['goods_idx'] && $_POST['goods_point']){
        $possiblePoint = possiblePoint($_SESSION["temp_id"], $_SESSION["temp_code"]);

        $sql = "select hero_point, hero_quantity from goods where hero_idx=".$_POST['goods_idx'];
        $res = mysql_query($sql) or die(mysql_error());
        $rs = mysql_fetch_array($res);

        if($rs["hero_point"]!=$_POST['goods_point']){
            msg("�߸��� �����Դϴ�.", "history.back(-1);");
            exit();
        }

        if($rs["hero_point"] > $possiblePoint){
            msg("��������Ʈ�� �����մϴ�.", "history.back(-1);");
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

            mysql_query($sql) or die("�ý��� �����Դϴ�. �ٽ� �õ��� �ֽñ� �ٶ��ϴ�.<br>".mysql_error());

            mysql_query("update goods set hero_quantity = hero_quantity - 1 where hero_idx=".$_POST['goods_idx']) or die(mysql_error());

            msg("���� �Ϸ�Ǿ����ϴ�.\\n\\nȸ���� ������ �ּ����� ��۵ǿ��� \\n\\n�ݵ�� Ȯ�ιٶ��ϴ�.", "location.href='/m/order.php?board=".$_GET['board']."';");
            exit();

        }else{
            msg("ǰ���� ��ǰ�Դϴ�.\\n\\nȮ�� �� �ٽ� �������ּ���.", "location.href='/m/order.php?board=".$_GET['board']."';");
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

<!--������ ����-->
<div id="subpage" class="sub_festival">
    <div class="sub_title">
        <div class="sub_wrap">
            <div class="f_b">
                <h1 class="fz74 main_c fw500 ko">����Ʈ �佺Ƽ��</h1>
            </div>
            <p class="fz28 fw600">������ ����Ʈ�� �ְ� ��ǰ�� ��ȯ�ϴ� Ư�� �̺�Ʈ�� ����������!</p>
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
                    <img src="/m/img/musign/pointmall/mall_top.jpg" alt="����Ʈ�� ��ܹ��" class="mainbanner">
                    <!-- ����Ʈ ���� ����, �� ����Ʈ ��Ȳ -->
                    <ul class="info">
                        <li class="myPoint">
                            <div class="myPointBox">
                                <span class="myPointTit fz26 fw600 c_white"><img src="/img/front/pointmall/mypoint.webp" style="width: 14px" alt="�� ����Ʈ ����">My Points</span>
                                <ul class="myPointList">
                                    <? if($_SESSION["temp_id"]=="" or $_SESSION["temp_code"]==""){ ?>
                                        <li class="fz66 fw500">�α����� ���ּ���.</li>
                                    <? }else{ ?>
                                        <li class="fz48 main_c en"><span class="fz66 en"><?=number_format($possiblePoint)?></span>P</li>
                                    <? } ?>
                                </ul>
                                <ul class="myPointInfo">
                                    <li class="f_b">
                                        <p class="fz28 fw600"><img src="/img/front/pointmall/coin.webp" style="width: 16px" alt="����Ʈ ����">����Ʈ ����</p>
                                        <a href="/m/mypoint.php?board=mypoint"><span class="fz24">�ٷΰ���</span><img src="/img/front/main/btn_right.webp" alt="�ٷΰ���"></a>
                                    </li>
                                    <li class="f_b">
                                        <p class="fz28 fw600"><img src="/img/front/pointmall/order.webp"  style="width: 16px" alt="��ǰ ��ȯ����">��ǰ ��ȯ����</p>
                                        <a href="/m/orderList.php?board=orderlist"><span class="fz24">�ٷΰ���</span><img src="/img/front/main/btn_right.webp" alt="�ٷΰ���"></a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="pointNotice">
                            <div class="noticeTitBox">
                                <span class="fz26 fw600">���ǻ���</span>
                            </div>
                            <p class="fz24">
                                - ����Ʈ �佺Ƽ�� �� �ܿ� ����Ʈ�� �Ʒ��� ���� ����˴ϴ�.<br />
                                &nbsp;&nbsp;(��ݱ� �佺Ƽ�� : �Ҹ� X / �Ϲݱ� �佺Ƽ�� : �Ҹ� O)<br />
                                - ��ȯ ��ǰ ���� �� ��Ҵ� ����Ʈ �佺Ƽ�� ���� �Ⱓ ������ �����մϴ�.<br />
                                - ��ȯ ��ǰ�� ��� ��Ȳ�� ���� ����� �� �ֽ��ϴ�.
                            </p>
                        </li>
                    </ul>
                </div>
                <!--!!!!!!!! [���߿�û] ��ǰ ī�װ� -- ��ġ �̵� �ʿ��ϸ� �������ּ��� [��]!!!!!!!!  -->
                <div class="tab">
                    <ul class="flex">
                        <li <?if($_GET['cate']==  '') echo 'class="active"'?> data-cate="">��ü����</li>
                        <li <?if($_GET['cate']=='BT') echo 'class="active"'?> data-cate="BT">��Ƽ</li>
                        <li <?if($_GET['cate']=='PC') echo 'class="active"'?> data-cate="PC">�۽����ɾ�</li>
                        <li <?if($_GET['cate']=='HC') echo 'class="active"'?> data-cate="HC">Ȩ�ɾ�</li>
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

                <!-- gallery ���� -->
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
                            $script = "alert('�α��� �� �̿밡���մϴ�');";
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
                                    <b class="endnoti fz26 bold main_c">ǰ���ӹ�</b>
                                <?}?>
                                <span class="title fz26 fw500 ellipsis_2line"><?=$title_01?></span>
                                <span class="sub fz24 op05 ellipsis_100" ><?=$main_list['hero_info']?></span>
                            </div>
                            <span onclick="<?=$script?>" class="label_button btn_buy">��ȯ�ϱ�</span>
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
                                <!--!!!!!!!! [���߿�û] �����ؽ�Ʈ ���� !!!!!!!!  -->
                                <span class="sub fz24 op05 ellipsis_100" ><?=$main_list['hero_info']?></span>
                            </div>
                            <span class="fz15 fw600 soldout_txt">ǰ��</span>
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
						<a href="<?=DOMAIN_END?>/m/write.php?board=<?=$_REQUEST['board']?>&action=write" ><img src="img/general/write_btn.jpg" alt="�۾���" width="70px"></a>
					</span>  -->
                    <?}?>
                </div>
            </div>
        <? } ?>
    </div>
</div>


<!--������ ����-->

<script>
    <? if(!strcmp($_REQUEST['download'],"ok")){?>
    downMenu();
    <? }?>

    // ī�װ� �̵� �� ��ũ�� ��ġ ����
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