<link rel="stylesheet" href="../m/css/musign/club.css">
<link rel="stylesheet" href="../css/front/animation.css">
<script type="text/javascript" src="/js/musign/animation.js"></script>

<?
$benefit_str = "Benefit";

if($_GET['board'] === 'group_04_06') {
    $club_name = '��Ƽ';
}else if($_GET['board'] === 'group_04_28') {
    $club_name = '������';
} 

?>
<div id="subpage" class="support">
    <div class="sub_title">
        <div class="sub_wrap">
            <div>
                <div>
                    <h1 class="fz74 main_c fw500 ko">�����̾� <?=$club_name?> Ŭ��</h1>
                </div>
                <ul class="tab f_cs">                              
                    <li><a href="/m/beauty_life_aklover.php" class="fz12 fw500 on mission_guide_btn">������� ��������<img src="/img/front/main/right_wh.webp" alt="�ٷΰ���"></a></li>
                </ul>
            </div>
        </div>        
    </div>
    <div class="beauty_container">
        <div class="beauty_top">
            <div class="bg">
                <? if ($_GET ['board'] == 'group_04_06') { ?>
                    <img src="/m/img/supporters/beautyclub_bg.webp" alt="��ƼŬ�� ���" />
                <? } else if ($_GET ['board'] == 'group_04_28') { ?>
                    <img src="/m/img/supporters/lifeclub_bg.webp" alt="������Ŭ�� ���" />
                <? } ?>
            </div>
            <div class="txt_box t_c">
                <p>
                    <?php if($_GET ['board'] === 'group_04_06'){?> 
                        �پ��� ������ ������� ����Ƽ Ŭ������ �����ϼ���!
                    <? } else if($_GET ['board'] == 'group_04_28') { ?>
                        �پ��� ������ �������<br /> �������̾� ������ Ŭ������ �����ϼ���!
                    <? } ?>       
                </p>
                <p class="en">
                    <?php if($_GET ['board'] === 'group_04_06'){?> 
                        Beauty
                    <? } else if($_GET ['board'] == 'group_04_28') { ?>
                        Life
                    <? } ?>   
                    Club
                </p>
            </div>
            <div class="obj_box">
                <? if ($_GET ['board'] == 'group_04_06') { ?>
                    <div class="box t_c"><img src="/m/img/supporters/box_pink.webp" alt="��Ʈ �ڽ�" /></div>
                    <div class="box_cap t_c"><img src="/m/img/supporters/box_cap_pink.webp" alt="��Ʈ �ڽ� ĸ" /></div>
                    <div class="products rel">
                        <div class="item item_01">
                            <img src="/m/img/supporters/pink_obj_1.webp" alt="������Ʈ" />
                        </div>
                        <div class="item item_02">
                            <img src="/m/img/supporters/pink_obj_2.webp" alt="������Ʈ" />
                        </div>
                        <div class="item item_03">
                            <img src="/m/img/supporters/pink_obj_3.webp" alt="������Ʈ" />
                        </div>
                        <div class="item item_04">
                            <img src="/m/img/supporters/pink_obj_4.webp" alt="������Ʈ" />
                        </div>
                        <div class="item item_05">
                            <img src="/m/img/supporters/pink_obj_5.webp" alt="������Ʈ" />
                        </div>
                        <div class="item item_06">
                            <img src="/m/img/supporters/pink_obj_6.webp" alt="������Ʈ" />
                        </div>
                        <div class="item item_07">
                            <img src="/m/img/supporters/pink_obj_7.webp" alt="������Ʈ" />
                        </div>
                        <div class="item item_08">
                            <img src="/m/img/supporters/pink_obj_8.webp" alt="wow" />
                        </div>
                    </div>
                <? } else if ($_GET ['board'] == 'group_04_28') { ?>
                    <div class="box t_c"><img src="/m/img/supporters/box_blue.webp" alt="��� �ڽ�" /></div>
                    <div class="box_cap t_c"><img src="/m/img/supporters/box_cap_blue.webp" alt="��� �ڽ� ĸ" /></div>
                    <div class="products rel">
                        <div class="item item_01">
                            <img src="/m/img/supporters/blue_obj_1.webp" alt="������Ʈ" />
                        </div>
                        <div class="item item_02">
                            <img src="/m/img/supporters/blue_obj_2.webp" alt="������Ʈ" />
                        </div>
                        <div class="item item_03">
                            <img src="/m/img/supporters/blue_obj_3.webp" alt="������Ʈ" />
                        </div>
                        <div class="item item_04">
                            <img src="/m/img/supporters/blue_obj_4.webp" alt="������Ʈ" />
                        </div>
                        <div class="item item_05">
                            <img src="/m/img/supporters/blue_obj_5.webp" alt="������Ʈ" />
                        </div>
                        <div class="item item_06">
                            <img src="/m/img/supporters/blue_obj_6.webp" alt="������Ʈ" />
                        </div>
                        <div class="item item_07">
                            <img src="/m/img/supporters/blue_obj_7.webp" alt="������Ʈ" />
                        </div>
                        <div class="item item_08">
                            <img src="/m/img/supporters/blue_obj_8.webp" alt="wow" />
                        </div>
                    </div>
                <? } ?>
            </div>
        </div>
        <div class="beaauty_bottom">
            <div class="bottom_inner">
                <ul class="info img-ani bottom-top">
                    <li>
                        <span class="info_txt <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>">���� ���</span><?php if($_GET ['board'] === 'group_04_06'){?> 
                            ��Ƽ��ǰ�� �����ִ� SNS ���<br /> (����/��α�/�ν�Ÿ�׷�)
                        <? } else if($_GET ['board'] == 'group_04_28') { ?>
                            ��Ȱ��ǰ�� �����ִ� SNS ���<br /> (����/��α�/�ν�Ÿ�׷�)
                        <? } ?>
                    </li>
                    <li>
                        <span class="info_txt <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>">���� ���</span>���� ���� �Ⱓ�� ���� (�� 2ȸ ����)
                    </li>
                    <li>
                        <span class="info_txt <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>">�ֿ� Ȱ��</span>�ְ濡�� ���Ӱ� ��õǴ� ����ǰ�� ���� ü��/��� ��<br /> ������ �ۼ�, ����ǰ ���� ����, ��ǰ ǰ��ȸ ��
                    </li>
                </ul>
                <div class="gift">
                    <div class="gift_txt <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>">����</div>
                    <ul class="gift_list">
                        <li class="img-ani bottom-top">
                            <div class="description">
                                <p class="en count <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>"><?=($benefit_str)?>1</p>
                                <p class="bold">���� ����� �û�(30����)</p>
                                <p>Ȱ�� �Ⱓ ���� ��, ���� ����ڸ� �����Ͽ� �ִ� 30���� ������ �����մϴ�.<br /> <span class="additional_des">*������ 1��~3��� ���� �����ϸ�, �������� ���� Ȱ���� �����մϴ�.</span></p>
                            </div>
                            <div class="gift_icon resize">
                                <img src="/img/front/supporters/gift_icon_1.webp" alt="����1 ������" />
                            </div>
                        </li>
                        <li class="img-ani bottom-top">
                            <div class="description">
                            <p class="en count <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>"><?=($benefit_str)?> 2</p>
                                <p class="bold">�� ����� ����(�ִ� 10����)</p>
                                <p>�ſ� ����� �������� �ۼ����ֽ� ���̴��� AK Lover���� �����Ͽ� �ִ� 10���� ����� ��ǰ���� �帳�ϴ�. <span class="additional_des">(�ִ� 30��)</span></p>
                            </div>
                            <div class="gift_icon resize">
                                <img src="/img/front/supporters/gift_icon_2.webp" alt="����2 ������" />
                            </div>
                        </li>
                        <li class="img-ani bottom-top">
                            <div class="description">
                                <p class="en count <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>"><?=($benefit_str)?> 3</p>
                                <p class="bold">������ ���� ���Ĺڽ� ���� (10���� ���)</p>
                                <p>
                                <?php if($_GET ['board'] === 'group_04_06'){?> 
                                    ��Ƽ Ŭ����
                                <? } else if($_GET ['board'] == 'group_04_28') { ?>
                                    �����̾� ������ Ŭ����
                                <? } ?>
                                ������ ��� �е��� ȯ���ϴ� ������ ���<br /> 10���� ����� �ְ� ��ǰ�� �����մϴ�.  <span class="additional_des">(1ȸ)</span></p>
                            </div>
                            <div class="gift_icon">
                                <img src="/img/front/supporters/gift_icon_3.webp" alt="����3 ������" />
                            </div>
                        </li>
                        <li class="img-ani bottom-top">
                            <div class="description">
                                <p class="en count <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>"><?=($benefit_str)?> 4</p>
                                <p class="bold">������ ���� ��ť �ڽ� ���� �� ������ ���� (10���� ���)</p>
                                <p>
                                <?php if($_GET ['board'] === 'group_04_06'){?> 
                                    ��Ƽ Ŭ����
                                <? } else if($_GET ['board'] == 'group_04_28') { ?>
                                    �����̾� ������ Ŭ����
                                <? } ?> 
                                �ʼ� Ȱ�� ������ ������ �е鿡��<br /> ������ ������ ��� 10���� ����� �ְ� ��ǰ�� �������� �����մϴ�. <span class="additional_des">(1ȸ)</span></p>
                            </div>
                            <div class="gift_icon resize">
                                <img src="/img/front/supporters/gift_icon_4.webp" alt="����4 ������" />
                            </div>
                        </li>
                        <li class="img-ani bottom-top">
                            <div class="description">
                                <p class="en count <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>"><?=($benefit_str)?> 5</p>
                                <p class="bold">����Ʈ �佺Ƽ�� ���� ��ȸ ����(�� 2ȸ)</p>
                                <p>�پ��� Ȱ������ ������ ����Ʈ�� �ְ��� �α� ��ǰ��<br /> ���� ���� �� ��ȯ�� �� �ִ� �̺�Ʈ�Դϴ�.<br />
                                <span class="additional_des">(��ݱ� : �̴��� AK Lover �� �����̾� ��� / �Ϲݱ� : ��ü ȸ�� ���)</span>
                            </p>
                            </div>
                            <div class="gift_icon resize">
                                <img src="/img/front/supporters/gift_icon_5.webp" alt="����5 ������" />
                            </div>
                        </li>
                        <li class="img-ani bottom-top">
                            <div class="description">
                                <p class="en count <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>"><?=($benefit_str)?> 6</p>
                                <p class="bold">�ְ� ��ǰ ���� (3���� ���)</p>
                                <p>���� ������ �ۼ��� ���Ͽ� �� ������ �� 3���� ����� �ְ� ����ǰ�� �����մϴ�.<br />
                                <span class="additional_des">(Ȱ�� �Ⱓ �� ��� 20ȸ �̻�)</span>
                                </p>
                            </div>
                            <div class="gift_icon resize">
                                <img src="/img/front/supporters/gift_icon_6.webp" alt="����5 ������" />
                            </div>
                        </li>
                        <li class="img-ani bottom-top">
                            <div class="description">
                                <p class="en count <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>"><?=($benefit_str)?> 7</p>
                                <p class="bold">AK Lover ����Ʈ ���� �� Ȱ��</p>
                                <p>���� ������ �ۼ� �ø��� AK Lover ����Ʈ�� �����ϸ�,<br />
                                Ű���� ç���� �� ��� �������� ������ �� ���� �߰� ����Ʈ�� �帳�ϴ�.<br />
                                <span class="additional_des">(���� ����Ʈ�� ��ǰ ��ۺ�(�� 3,400��)�� ��ü �� ����Ʈ �佺Ƽ�� �� ��� ����)</span>
                                </p>
                            </div>
                            <div class="gift_icon resize">
                                <img src="/img/front/supporters/gift_icon_7.webp" alt="����5 ������" />
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="notice f_c">
                    �� Ȱ�� ������ ���� ������ �� �ֽ��ϴ�.
                </div>
                <div class="more_view f_c">
                    <div class="btn f_cs">
                        <a href="/">
                            <?php if($_GET ['board'] === 'group_04_06'){?> 
                                ��ƼŬ��
                            <? } else if($_GET ['board'] == 'group_04_28') { ?>
                                ������Ŭ��
                            <? } ?>    
                            �˾ƺ��� <img src="/img/front/member/arr.webp" alt="�˾ƺ���">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="club_cont">
            <?php if($_GET['board'] === 'group_04_06') {
                $club_name = '��Ƽ';
            }else if($_GET['board'] === 'group_04_28') {
                $club_name = '������';
            } ?>
            <p class="tit fz34 fw600"><?=$club_name?> Ŭ�� Ȱ�� ����</p>
            <p class="sub_tit fz28"><?=$club_name?> Ŭ���� �����Ͽ� ��ſ� ü���� �Բ��ؿ�.</p>
            <? if(!strcmp($total_data,"0")){?>
                <div id="blankList">�˻������ �����ϴ�.</div>
            <? } else { ?>
            <div class="club_list blog_box2">
                <ul class="guerrilla_event grid_3">
                    <?
                    $list_sql = "SELECT * FROM mission WHERE hero_kind != '����ü��' AND hero_table='".$_GET['board']."' ".$search;
                    if($_SESSION['temp_level'] < 9999 ){
                        $list_sql .=" AND hero_use = 1 AND ((hero_today_05_01 is null or hero_today_05_01='') or (hero_today_05_01 is not null and hero_today_05_01 != '' AND '".date("Y-m-d H:i")."' >= hero_today_05_01)) ";
                        $list_sql .=" AND ((hero_today_05_02 is null or hero_today_05_02 ='') OR (hero_today_05_02 is not null and hero_today_05_02 != '' AND '".date("Y-m-d H:i")."' <= hero_today_05_02)) ";
                    }
                    $list_sql .=" ORDER BY hero_priority DESC,
                                    CASE WHEN (hero_today_01_01<='".date('Y-m-d 00:00:00')."' and hero_today_01_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_01_01 END DESC,
                                    CASE WHEN (hero_today_02_01<='".date('Y-m-d 00:00:00')."' and hero_today_02_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_02_01 END DESC,
                                    CASE WHEN (hero_today_03_01<='".date('Y-m-d 00:00:00')."' and hero_today_03_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_03_01 END DESC,
                                    CASE WHEN (hero_today_04_01<='".date('Y-m-d 00:00:00')."' and hero_today_04_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_04_01 END DESC,
                                    CASE WHEN (hero_today_04_02<='".date('Y-m-d 00:00:00')."') THEN hero_today_04_01 END desc ";

                    if($_GET['board'] == "group_04_06" || $_GET['board'] == "group_04_27" || $_GET['board'] == "group_04_28") { //��Ƽ,��Ʃ��,������
                        $list_sql .= " , hero_today_01_01 DESC ";
                    } else {
                        $list_sql .= " , hero_idx DESC ";
                    }
                    $list_sql .= " LIMIT ".$start.",".$list_page;

                    sql($list_sql, 'on');
                    while($list = @mysql_fetch_assoc($out_sql)){
                        $img_parser_url = @parse_url($list['hero_img_new']);
                        $img_host = $img_parser_url['host'];

                        if(!strcmp($list['hero_img_new'],'')){
                            $view_img = IMAGE_END.'hero.jpg';
                        }else if(!strcmp($img_host,'')){
                            $view_img = IMAGE_END.'hero.jpg';
                        }else if(!strcmp($img_host,$HTTP_SERVER_VARS['HTTP_HOST'])){
                            $view_img = $list['hero_img_new'];
                        }else if(!strcmp(eregi('naver',$img_host),'1')){
                            $view_img = IMAGE_END.'hero.jpg';
                        }else{
                            $view_img = $list['hero_img_new'];
                        }

                        if($list["hero_thumb"]) $view_img = $list['hero_thumb'];

                        $check_day = date( "Y-m-d", time());
                        $today_01_01 = date( "Y-m-d", strtotime($list['hero_today_01_01']));
                        $today_01_02 = date( "Y-m-d", strtotime($list['hero_today_01_02']));
                        $today_02_01 = date( "Y-m-d", strtotime($list['hero_today_02_01']));
                        $today_02_02 = date( "Y-m-d", strtotime($list['hero_today_02_02']));
                        $today_03_01 = date( "Y-m-d", strtotime($list['hero_today_03_01']));
                        $today_03_02 = date( "Y-m-d", strtotime($list['hero_today_03_02']));
                        $today_04_01 = date( "Y-m-d", strtotime($list['hero_today_04_01']));
                        $today_04_02 = date( "Y-m-d", strtotime($list['hero_today_04_02']));
                        $today_05_01 = date( "Y-m-d", strtotime($list['hero_today_05_01']));
                        $today_05_02 = date( "Y-m-d", strtotime($list['hero_today_05_02']));

                        $status_txt = "";
                        $status = "";
                        $period_day = "";
                        $ribbon_text = "";
                        $type_check = "";

                        $mission_board_type = false;
                        if($list["hero_type"] == "2" || $list["hero_type"] == "10") {
                            $mission_board_type = true;
                        }

                        if($_GET ['board'] == 'group_04_05') {
                            if($list["hero_question_url_check"] == "1") {
                                $type_check = "<img src='/img/front/main/ic_naver_blog.webp' alt='���̹� ��α�'>";
                            } else if($list["hero_question_url_check"] == "2") {
                                $type_check = "<img src='/img/front/main/ic_insta.webp' alt='�ν�Ÿ�׷�'>";
                            } else if($list["hero_question_url_check"] == "3") {
                                $type_check = "<img src='/img/front/main/ic_naver_blog.webp' alt='��α�'><img src='/img/front/main/ic_insta.webp' alt='�ν�Ÿ�׷�'>";
                            } else if($list["hero_question_url_check"] == "4") {
                                $type_check = "<img src='/img/front/main/ic_naver_blog.webp' alt='��α�'><img src='/img/front/main/ic_insta.webp' alt='�ν�Ÿ�׷�'>";
                            } else if($list["hero_question_url_check"] == "5") {
                                $type_check =  "<img src='/img/front/main/ic_youtube.webp' alt='��Ʃ��'>";
                            } else if($list["hero_question_url_check"] == "6") {
                                $type_check = "<img src='/img/front/main/ic_naver_blog.webp' alt='��α�'><img src='/img/front/main/ic_insta.webp' alt='�ν�Ÿ�׷�'><img src='/img/front/main/ic_youtube.webp' alt='��Ʃ��'>";
                            } else {
                                // if($list["hero_type"] == "1") {
                                // 	$type_check = "�̺�Ʈ";
                                // } else if($list["hero_type"] == "2") {
                                // 	$type_check = "�ҹ�����";
                                // } else if($list["hero_type"] == "3") {
                                // 	$type_check = "��������";
                                // } else if($list["hero_type"] == "5") {
                                // 	$type_check = "ǰ������";
                                // } else if($list["hero_type"] == "8") {
                                // 	$type_check = "����Ʈü��";
                                // } else {
                                // 	$type_check = "ü���";
                                // }
                            }
                        }

                        if($_GET['board'] == 'group_04_06' || $_GET['board'] == 'group_04_27' || $_GET['board'] == 'group_04_28'){

                            $ribbon_text = $list['hero_kind'];
                            if($list['hero_type'] == "4" || $list['hero_type'] == "7") {
                                $ribbon_text = $list['hero_kind'];
                            }

                            if($list['hero_type'] == "7" || $list['hero_type'] == "9") { //�����̼�, ����̼�(����)
                                if(($today_01_01<=$check_day) and ($today_01_02>=$check_day)){
                                    $status_txt = "ü��� ��û";
                                    $status = "1";
                                    $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                    $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                    $period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                                }else if( ($today_02_01<=$check_day) and ($today_02_02>=$check_day) ){
                                    $status_txt = "������ ��ǥ";
                                    $status = "2";
                                    $one_day = date( "Y.m.d", strtotime($list['hero_today_02_01']));
                                    $two_day = date( "Y.m.d", strtotime($list['hero_today_02_02']));
                                    $period_day =  intval((strtotime($list['hero_today_02_02'])-strtotime(date("Ymd")))/86400);
                                }else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
                                    $status_txt = "�ı���";
                                    $status = "3";
                                    $one_day = date( "Y.m.d", strtotime($list['hero_today_03_01']));
                                    $two_day = date( "Y.m.d", strtotime($list['hero_today_03_02']));
                                    $period_day =  intval((strtotime($list['hero_today_03_02'])-strtotime(date("Ymd")))/86400);
                                }else if( ($today_04_01<=$check_day) and ($today_04_02>=$check_day) ){
                                    $status_txt = "����ı��ǥ";
                                    $status = "4";
                                    $one_day = date( "Y.m.d", strtotime($list['hero_today_04_01']));
                                    $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                    $period_day =  intval((strtotime($list['hero_today_04_02'])-strtotime(date("Ymd")))/86400);
                                }else if($today_04_02<$check_day){
                                    $status_txt = "ü��� ����";
                                    $status = "5";
                                    $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                    // $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                    $two_day = "";
                                }else if($today_05_01>$check_day){
                                    $status_txt = "ü��� ���⿹��";
                                    $status = "5";
                                    $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                    $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                }
                            } else {
                                if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
                                    $status_txt = "�ı���";
                                    $status = "3";
                                    $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                    $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                    $period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                                }else if($today_01_02<$check_day){
                                    $status_txt = "ü��� ����";
                                    $status = "5";
                                    $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                    // $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                    $two_day = "";
                                }else if($today_05_01>$check_day){
                                    $status_txt = "ü��� ���⿹��";
                                    $status = "5";
                                    $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                    $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                }
                            }
                        } else {
                            /* 2021-03-25 Ÿ�� ��������, ��ǰǳ�� ���� ���� ��û�־��µ� �˻� ������ ����
                            if($list['hero_type'] == "3" ||  $list['hero_type'] == "5") {
                                $ribbon_text = "<div class='mission_ribbon bg_hero_type_".$list['hero_type']."'>".$list['hero_kind']."</div>";
                            }
                            */
                            $ribbon_text = $list['hero_kind'];

                            if($mission_board_type) {
                                $txt1 = "";
                                $txt2 = "";
                                if($list["hero_type"] == "2") {
                                    $txt1 = "�ҹ����� ";
                                    $txt2 = "�ҹ����� ��û";
                                } else if($list["hero_type"] == "10") {
                                    $txt1 = "ü���";
                                    $txt2 = "ü��� ����";
                                }

                                if(($today_01_01<=$check_day) and ($today_01_02>=$check_day)){
                                    $status_txt = $txt2;
                                    $status = "1";
                                    $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                    $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                    $period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                                }else if(($today_02_02 == $today_03_02) and ($today_02_02 == $today_04_02) and ($today_03_02 == $today_04_02) and ($today_02_02 >= $check_day)){
                                    $status_txt = "��÷�� ��ǥ";
                                    $status = "2";
                                    $one_day = date( "Y.m.d", strtotime($list['hero_today_02_01']));
                                    $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                    $period_day =  intval((strtotime($list['hero_today_04_02'])-strtotime(date("Ymd")))/86400);
                                }else if(($today_04_02 < $check_day)){
                                    $status_txt = $txt1." ����";
                                    $status = "5";
                                    $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                    $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                }
                            } else {
                                if(($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
                                    //20180831 �ӽ÷� �߰�
                                    if($list['hero_idx'] == "1288") {
                                        $status_txt = "�̺�Ʈ ��û";
                                    } else {
                                        $status_txt = "ü��� ��û";
                                    }
                                    $status = "1";
                                    $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                    $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                    $period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                                }else if( ($today_02_01<=$check_day) and ($today_02_02>=$check_day) ){
                                    $status_txt = "������ ��ǥ";
                                    $status = "2";
                                    $one_day = date( "Y.m.d", strtotime($list['hero_today_02_01']));
                                    $two_day = date( "Y.m.d", strtotime($list['hero_today_02_02']));
                                    $period_day =  intval((strtotime($list['hero_today_02_02'])-strtotime(date("Ymd")))/86400);
                                }else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
                                    $status_txt = "�ı���";
                                    $status = "3";
                                    $one_day = date( "Y.m.d", strtotime($list['hero_today_03_01']));
                                    $two_day = date( "Y.m.d", strtotime($list['hero_today_03_02']));
                                    $period_day =  intval((strtotime($list['hero_today_03_02'])-strtotime(date("Ymd")))/86400);
                                }else if(($today_04_01<=$check_day) and ($today_04_02>=$check_day)){
                                    $status_txt = "����ı��ǥ";
                                    $status = "4";
                                    $one_day = date( "Y.m.d", strtotime($list['hero_today_04_01']));
                                    $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                    $period_day =  intval((strtotime($list['hero_today_04_02'])-strtotime(date("Ymd")))/86400);
                                }else if($today_04_02<$check_day){
                                    $status_txt = "ü��� ����";
                                    $status = "5";
                                    $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                    // $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                    $two_day = "";
                                }else if($today_05_01>$check_day){
                                    $status_txt = "ü��� ���⿹��";
                                    $status = "5";
                                    $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                    $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                }
                            }
                        }
                        ?>
                        <li class="event_list">
                            <!--a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&page=<?=$page?>&view=view&idx=<?=$list['hero_idx']?>" class="rel"-->
                            <!--musign 24.07.06 ��ũ ���� pc��ũ�� �̵��ǰ� �־� ����-->
                            <a href="/m/mission_view.php?board=<?=$_GET['board']?>&page=<?=$page?>&hero_idx=&mission_idx=<?=$list['hero_idx']?>">
                                <div class="event_img rel">
                                    <div class="status_wrap">
                                        <span class="status"><?=$status_txt?></span>
                                        <span class="status status_txt"><?=$ribbon_text?></span>
                                    </div>
                                    <img class="mission_image" onerror="this.src='<?=IMAGE_END?>hero.jpg'" src="<?=$view_img?>" alt="">
                                    <? if($list["hero_use"] == 0) { ?>
                                        <div class="mission_com fz26 bold">�����</div>
                                    <? } ?>
                                    <? if($status == 5) {?>
                                        <div class="mission_com fz26 bold">����� ü���</div>
                                    <? } ?>
                                    <? if(strlen($type_check) > 0) {?>
                                        <span class="type_check"><?=$type_check?></span>
                                    <? } ?>
                                </div>
                                <div class="title fz28 fw600 ellipsis_100"><?=cut($list['hero_title'],"70");?></div>
                                <div class="day">
                                    <? if($period_day) {?>
                                        <span class="period fz24">
                                                D-<?=$period_day?>
                                            </span>
                                    <? } else if($period_day == 0 && strlen($period_day) > 0) { ?>
                                        <span class="period fz24">
                                                D-day
                                            </span>
                                    <? } ?>
                                    <? if($status == 5) {?>
                                        <span class="period fz24">
                                                END
                                            </span>
                                    <? } ?>
                                    <!-- <span class="date_02 fz24 fw600 op05"><?=$one_day?>-<?=$two_day?></span> -->
                                    <!-- <div class=""><?=mb_substr($list['hero_title_02'], 0, 18, 'EUC-KR');?></div> -->
                                    <p class="date_02 fz15 fw600 op05">
                                        <?=$one_day?>
                                        <span>-</span>
                                        <?=$two_day?>
                                    </p>
                                </div>
                            </a>
                        </li>
                    <? } ?>
                </ul>
            </div>
            <? } ?>
            <div class="paging"><?=page($total_data,$list_page,$page_per_list,$_GET[page],$next_path);?></div>
        </div>
    </div>
</div>


<script>
    // Event - Ư�� ��ġ�� �������� �� ���� �ִϸ��̼�
    const conHeight = document.querySelector(".beauty_container").offsetTop;
    const txt1 = document.querySelector(".txt_box > p:first-child");
    const txt2 = document.querySelector(".txt_box > p:last-child");

    function scrollEvent(){
        // if(window.scrollY > conHeight){
        if(window.scrollY > 1){
            document.querySelector(".box_cap").classList.add("up");

            setTimeout(() => {
                txt1.classList.add("appear");
                txt2.classList.add("appear2");
            }, 800);

            window.removeEventListener("scroll", scrollEvent);
        }
    }

    window.addEventListener("scroll", scrollEvent);

</script>