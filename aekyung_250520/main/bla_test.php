<?
$pageCheck = $_GET["pageCheck"];
//musign s
$pageCheck = 'Y';//musign�ӽ�
//musign e
ob_start();
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD����

include_once '../freebest/head.php';
include_once FREEBEST_INC_END.'hero.php';
include_once FREEBEST_INC_END.'function.php';

include_once PATH_INC_END.'top2.php';
#####################################################################################################################################################
?>
<!-- <link rel="stylesheet" type="text/css" href="/css/front/club_aklover.css" /> -->
<div id="subpage" class="aklove_page">
    <div class="sub_title">
        <div class="sub_wrap">
            <div class="f_b">
                <div>
                    <h1 class="fz68 main_c fw500 ko">AK Lover �̿�鼭</h1>
                    <p class="fz18 fw600">AK Lover �������� �̿��� A to Z ���� ���������!</p>
                </div>
                <!-- <ul class="tab f_c">
                    <li><a href="/main/beauty_life_aklover.php" class="fz18 fw600 on">Premium Club</a></li>
                    <li><a href="/main/multiclub_aklover.php" class="fz18 fw600">Basic Club</a></li>
                    <li><a href="/main/use_aklover.php" class="fz18 fw600">������ ǥ�� �� ����</a></li>
                </ul> -->
                <ul class="tab f_c">
                    <li><a href="/main/guide_aklover.php" class="fz18 fw600">Ȩ������ ��</a></li>
                    <li class="rel">
                        <a class="fz18 fw600 tab_btn on">�������� �� <img src="/img/front/intro/arrow_white.webp" alt="ȭ��ǥ" /></a>
                        <ul class="tab_list">
                            <li><a href="/main/beauty_life_aklover.php" class="fz18 fw600 select">�����̾� Ŭ��</a></li>
                            <li><a href="/main/multiclub_aklover.php" class="fz18 fw600">������ Ŭ��</a></li>
                            <li><a href="/main/use_aklover.php" class="fz18 fw600">������ ǥ�� �� ����</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>        
    </div>
    <div class="sub_cont">
        <div class="sub_wrap board_wrap f_sb">
            <div class="left">
                <div class="content_info">
                    <h3><span class="step">Step.1</span>�����̾� ��Ƽ/������ Ŭ���̶�?</h3>
                    <p>
                        ��Ƽ/��Ȱ��ǰ ��ǰ ���信 �������� ���� ���������<br />
                        �� 2ȸ ���� �����Ͽ� ��˴ϴ�.
                    </p>
                </div>
            </div>
            <div class="contents right">
                <ul class="image_content grid_2">
                    <li>
                        <div class="con_image">
                            <img src="/img/front/intro/beautyclub.webp" alt="��Ƽ Ŭ��" />
                        </div>
                        <p class="con_tit">Premier Beauty Club</p>
                        <p class="cont_des">�ְ��� ��Ƽ ��ǰ�� ���������� �����ϴ� ���������Դϴ�.</p>
                        <div class="btn_moreview">
                            <a href="http://aklover-test.musign.kr/main/index.php?board=group_04_06">�����̾� ��Ƽ Ŭ�� �ڼ��� ����</a>
                        </div>
                    </li>
                    <li>
                        <div class="con_image">
                            <img src="/img/front/intro/lifeclub.webp" alt="������ Ŭ��" />
                        </div>
                        <p class="con_tit">Premier Life Club</p>
                        <p class="cont_des">
                            �ְ��� Ȩ�ɾ�, �۽����ɾ� ��ǰ�� ���������� �����ϴ� ���������Դϴ�.
                        </p>
                        <div class="btn_moreview">
                            <a href="http://aklover-test.musign.kr/main/index.php?board=group_04_28">�����̾� ������ Ŭ�� �ڼ��� ����</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="sub_cont">
        <div class="sub_wrap board_wrap f_sb">
            <div class="left">
                <div class="content_info">
                    <h3><span class="step">Step.2</span>�����̾� ��Ƽ/������ Ŭ�� ���� Ȯ���ϱ�</h3>
                    <p>
                        �� �� �پ��� ������ �������� ���� �� ���� ���ϰ� �ȳ��帳�ϴ�.
                    </p>
                </div>
            </div>
            <div class="contents right">
                <ul class="gift_content">
                    <li>
                        <div class="gift_num">
                            <p class="en">benefit</p>
                            <p class="en">1</p>
                        </div>
                        <div class="gift_info">
                            <div class="gift_info_tit">�ֿ���� �û�(�ִ� 30����)</div>
                            <p class="gift_info_des">
                                Ȱ�� �Ⱓ ���� ��, ���� ����ڸ� �����Ͽ� �ִ� 30���� ������ �����մϴ�.<br />
                                <span class="gray">*������ 1��~3��� ���� �����ϸ�, �������� ���� Ȱ���� �����մϴ�.</span>
                            </p>
                        </div>
                        <div class="gift_icon">
                            <img src="/img/front/supporters/gift_icon_1.webp" alt="���� 1" />
                        </div>
                    </li>
                    <li>
                        <div class="gift_num">
                            <p class="en">benefit</p>
                            <p class="en">2</p>
                        </div>
                        <div class="gift_info">
                            <div class="gift_info_tit">�� ����� �û� (�ִ� 10����)</div>
                            <p class="gift_info_des">
                                �ſ� ����� �������� �ۼ����ֽ� ���̴��� AK Lover���� �����Ͽ�<br />
                                �ִ� 10���� ����� ��ǰ���� �帳�ϴ�. <span class="gray">(�ִ� 30��)</span>
                            </p>
                        </div>
                        <div class="gift_icon">
                            <img src="/img/front/supporters/gift_icon_2.webp" alt="���� 2" />
                        </div>
                    </li>
                    <li>
                        <div class="gift_num">
                            <p class="en">benefit</p>
                            <p class="en">3</p>
                        </div>
                        <div class="gift_info">
                            <div class="gift_info_tit">������ ���� ���Ĺڽ� ���� (10���� ���)</div>
                            <p class="gift_info_des">
                                �����̾� Ŭ���� ������ ��� �е��� ȯ���ϴ� ������ ���<br />
                                10���� ����� �ְ� ��ǰ�� �����մϴ�. <span class="gray">(1ȸ)</span>
                            </p>
                        </div>
                        <div class="gift_icon">
                            <img src="/img/front/supporters/gift_icon_3.webp" alt="���� 3" />
                        </div>
                    </li>
                    <li>
                        <div class="gift_num">
                            <p class="en">benefit</p>
                            <p class="en">4</p>
                        </div>
                        <div class="gift_info">
                            <div class="gift_info_tit">������ ���� ��ť �ڽ� ���� �� ������ ���� (10���� ���)</div>
                            <p class="gift_info_des">
                                �����̾� Ŭ���� �ʼ� Ȱ�� ������ ������ �е鿡��<br />
                                ������ ������ ��� 10���� ����� �ְ� ��ǰ �� �������� �����մϴ�.
                                <span class="gray">(1ȸ)</span>
                            </p>
                        </div>
                        <div class="gift_icon">
                            <img src="/img/front/supporters/gift_icon_4.webp" alt="���� 4" />
                        </div>
                    </li>
                    <li>
                        <div class="gift_num">
                            <p class="en">benefit</p>
                            <p class="en">5</p>
                        </div>
                        <div class="gift_info">
                            <div class="gift_info_tit">����Ʈ �佺Ƽ�� ���� ��ȸ ����(�� 2ȸ)</div>
                            <p class="gift_info_des">
                                �پ��� Ȱ������ ȹ���� AK Lover ����Ʈ�� �ְ� ��ǰ����<br />
                                ��ȯ�� ���� �� �ִ� ����Ʈ �佺Ƽ�� ���� ��ȸ�� �����մϴ�.
                            </p>
                        </div>
                        <div class="gift_icon">
                            <img src="/img/front/supporters/gift_icon_5.webp" alt="���� 5" />
                        </div>
                    </li>
                    <li>
                        <div class="gift_num">
                            <p class="en">benefit</p>
                            <p class="en">6</p>
                        </div>
                        <div class="gift_info">
                            <div class="gift_info_tit">�ְ� ��ǰ ���� (3���� ���)</div>
                            <p class="gift_info_des">
                                ���� ������ �ۼ��� ���Ͽ� �� ������ �� 3���� ����� �ְ� ����ǰ�� �����մϴ�.<br />
                                <span class="gray">(Ȱ�� �Ⱓ �� ��� 20ȸ �̻�)</span>
                            </p>
                        </div>
                        <div class="gift_icon">
                            <img src="/img/front/supporters/gift_icon_6.webp" alt="���� 5" />
                        </div>
                    </li>
                    <li>
                        <div class="gift_num">
                            <p class="en">benefit</p>
                            <p class="en">7</p>
                        </div>
                        <div class="gift_info">
                            <div class="gift_info_tit">AK Lover ����Ʈ ���� �� Ȱ��</div>
                            <p class="gift_info_des">
                                ���� ������ �ۼ� �ø��� AK Lover ����Ʈ�� �����ϸ�,<br />
                                Ű���� ç���� �� ��� �������� ������ �� ���� �߰� ����Ʈ�� �帳�ϴ�.<br />
                                <span class="gray">(���� ����Ʈ�� ��ǰ ��ۺ�(�� 3,400��)�� ��ü �� ����Ʈ �佺Ƽ�� �� ��� ����)</span>
                            </p>
                        </div>
                        <div class="gift_icon">
                            <img src="/img/front/supporters/gift_icon_7.webp" alt="���� 5" />
                        </div>
                    </li>
                </ul>
                <div class="gift_bottom">
                    <p>
                        �� �� �����̾� Ŭ���� ���� �پ��� ������ ������ �� ���� ���ϰ� �ȳ��˴ϴ�.<br />
                        �����̾� Ŭ�� �������� ���� ���ɰ� ��û ��Ź�帳�ϴ�. <span class="gray">* Ȱ�� ������ ��Ȳ�� ���� ������ �� �ֽ��ϴ�.(�����̾�/������ ���� ����)</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="sub_cont">
        <div class="sub_wrap board_wrap f_sb">
            <div class="left">
                <div class="content_info">
                    <h3><span class="step">Step.3</span>�����̾� ��Ƽ/������ Ŭ��<br />����Ʈ ���� �˾ƺ���</h3>
                    <p>
                        ������ �´� �������� Ȱ���ϰ� ����Ʈ�� ������ �� �ֽ��ϴ�.
                    </p>
                </div>
            </div>
            <div class="contents right">
                <ul class="point_contents">
                    <li class="">
                        <div class="point_info">
                            <p><span class="number">1</span>����Ʈ ����</p>
                            <ul>
                                <li>������ ����/����/ƽ��/���̹����Ʈ � �ش��մϴ�.</li>
                                <li>�Խñ�/����� ���� ����Ʈ ȹ���� �� �ִ� 20P���� �����մϴ�.</li>
                                <li>����Ʈ ���� ������ ��Ȳ�� ���� ������ �� �ֽ��ϴ�.</li>
                            </ul>
                        </div>
                        <!-- <div style="margin-top: 2rem;">
                            <img src="/img/front/intro/point1.png" alt="����Ʈ ����">
                        </div> -->

                        <div class="table_container t_c club_tb">
                            <div class="table_head grid_custom">
                                <div>Ȱ�� ����</div>
                                <div>Ȱ�� ����</div>
                                <div>point</div>
                            </div>
                            <ul class="table_body">
                                <li class="grid_custom g2">
                                    <div class="division">Ȩ������</div>
                                    <div class="tb_inner">
                                        <div class="grid_custom g2_1">
                                            <div>ȸ������ �� ù �α���</div>
                                            <div class="no_line">+ 1,000</div>
                                        </div>
                                        <div class="grid_custom g2_1">
                                            <div>�ű�ȸ�� ��õ</div>
                                            <div class="no_line">+ 1,000</div>
                                        </div>
                                        <div class="grid_custom g2_1">
                                            <div>�� �� �⼮ �Ϸ�</div>
                                            <div class="no_line">+ 1,000</div>
                                        </div>
                                        <div class="grid_custom g2_1">
                                            <div>���� ����</div>
                                            <div class="no_line">+ 1,000</div>
                                        </div>
                                        <div class="grid_custom g2_1">
                                            <div>�Խñ� �ۼ�</div>
                                            <div class="no_line">+ 1,000</div>
                                        </div>
                                        <div class="grid_custom g2_1">
                                            <div>��� �ۼ�</div>
                                            <div class="no_line">+ 1,000</div>
                                        </div>
                                        <div class="grid_custom g2_1">
                                            <div>�ű�ȸ�� ��õ</div>
                                            <div class="no_line">�� �⼮ üũ</div>
                                        </div>
                                    </div>
                                </li>
                                <li class="grid_custom g2">
                                    <div class="division">��������</div>
                                    <div class="tb_inner">
                                        <div class="grid_custom g2_1">
                                            <div>ȸ������ �� ù �α���</div>
                                            <div class="no_line">+ 2,000</div>
                                        </div>
                                        <div class="grid_custom g2_2 padd_1">
                                            <div class="division color_orange">������ �ۼ�</div>
                                            <div class="tb_inner">
                                                <div class="grid_custom g2_3 ti">
                                                    <div>���� ����</div>
                                                    <div class="no_line">+ 1,500</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti">
                                                    <div>���� ����</div>
                                                    <div class="no_line">+ 1,000</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti">
                                                    <div>�ν�Ÿ�׷�</div>
                                                    <div class="no_line">+ 1,500</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti">
                                                    <div>��α�</div>
                                                    <div class="no_line">+ 2,000</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid_custom g2_2 padd_1">
                                            <div class="division color_orange">������ �ۼ�</div>
                                            <div class="tb_inner">
                                                <div class="grid_custom g2_3 ti">
                                                    <div>��������</div>
                                                    <div class="no_line">+ 1,500</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti">
                                                    <div>����</div>
                                                    <div class="no_line">+ 1,000</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid_custom g2_1">
                                            <div>�ʼ� �̼� �� ��Ÿ SNS</div>
                                            <div class="no_line">+ 500</div>
                                        </div>
                                        <div class="grid_custom g2_1">
                                            <div>��������</div>
                                            <div class="no_line">+ 300 ~ 500</div>
                                        </div>
                                    </div>
                                </li>
                                <li class="grid_custom g2">
                                    <div class="division">Ȱ��</div>
                                    <div class="tb_inner">
                                        <div class="grid_custom g2_2 padd_1">
                                            <div class="division color_orange">�ı� 2�� Ȱ��</div>
                                            <div class="tb_inner">
                                                <div class="grid_custom g2_3 ti">
                                                    <div>�ܼ� Ȱ��</div>
                                                    <div class="no_line">+ 2,000</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti">
                                                    <div>���� Ȱ��</div>
                                                    <div class="no_line">5���� ��� ��ǰ ����</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="">
                        <div class="point_left">
                            <div class="point_info">
                                <p><span class="number">2</span>����Ʈ ����</p>
                                <ul>
                                    <li>
                                        �������� ��û �� ������ ���ۼ� �� ����Ʈ ����<br /> 
                                        �� ���� �������� �������� ���ܵ˴ϴ�.
                                    </li>
                                </ul>
                            </div>
                        </div>                        
                        <div style="margin-top: 2rem;">
                            <img src="/img/front/intro/point2.png" alt="����Ʈ ����">
                        </div>
                        <!-- <div class="point_right">
                            <div class="table_container t_c">
                                <div class="table_head grid_custom">
                                    <div>Ȱ�� ����</div>
                                    <div>point</div>
                                </div>
                                <ul class="table_body">
                                    <li class="grid_custom">
                                        <div>��α��� �ı� ���ۼ�</div>
                                        <div>-3,000</div>
                                    </li>
                                    <li class="grid_custom">
                                        <div>�ν�Ÿ�׷�/������ �ı� ���ۼ�</div>
                                        <div>-2,500</div>
                                    </li>
                                    <li class="grid_custom">
                                        <div>�ı� �ۼ�/���� �ʾ� ���� �Ⱓ ���ؼ�</div>
                                        <div>-1,500</div>
                                    </li>
                                    <li class="grid_custom">
                                        <div>���̵���� ���ؼ� (���� �ȳ� �� �̼���)</div>
                                        <div>-1,500</div>
                                    </li>
                                </ul>
                            </div>
                        </div> -->
                    </li>
                    <li class="">
                        <div class="point_left">
                            <div class="point_info">
                                <p><span class="number">3</span>����Ʈ ���� ����</p>
                            </div>
                        </div>                                             
                        <div style="margin-top: 2rem;">
                            <img src="/img/front/intro/point3.png" alt="����Ʈ ����">
                        </div>
                        <!-- <div class="point_right">
                            <div class="point_notice">
                                <ul class="pn_content">
                                    <li>                                        
                                        ������ �� ���� ����<br /> 
                                        <span class="fz15">����, �ν�Ÿ�׷�, ��α� �� ��ü���� 1�� ���� �����˴ϴ�.</span>
                                        <p class="pn_des">
                                            ex. Aȸ���� ���� ���� ��α�a, ��α�b�� ������ �ۼ� �� ��α� 1�Ǹ� ����<br />
                                            Bȸ���� ���� ���� ��α�a, �ν�Ÿ�׷�a, b�� ������ �ۼ� �� ��α� 1��, �ν�Ÿ 1�� ����<br />
                                            Cȸ���� ���� ���� ��α�a, �ν�Ÿ�׷�a, ����a ������ �ۼ�<br />
                                            �� ��α� 1��, �ν�Ÿ 1��, ���� 1�� ����
                                        </p>
                                    </li>
                                    <li>
                                        Ű���� ç���� ���� ����
                                        <p class="pn_des">
                                            - Ű���� ç������? ���̹����� ��ϴ� ���÷�� ���� �����Դϴ�.
                                           <a href="https://help.naver.com/service/22665/contents/10765?lang=ko" target="_blank" class="bold more_view">�ڼ��� ���� <b class="arr_img"></b></a><br />
                                            - ���� ����<br />
                                            (1) Ȩ������ �ı� �ۼ� �� URL ��� �ʼ�<br />
                                            (2) ���� ���� ��, ȭ�� ĸ�� �� AK Lover ��Ƽ/������ Ŭ�� īī���� ���� �ʼ�
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div> -->
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    /* grid */
    .aklove_page {

    }
    .aklove_page .left {
        width: 42rem;
    }
    .aklove_page .right {
        width: calc(100% - 56.3rem);
        margin-bottom: 20rem;
    }
    @media(max-width: 1260px) {
        .aklove_page .left {
            width: 360px;
        }
        .aklove_page .right {
            width: calc(100% - 380px);
        }   
    }
    .aklove_page .pb_s {
        margin-bottom: 15.2rem;
    }

    .aklove_page .pb_m {
        margin-bottom: 20rem;
    }

    .content_info {
        border-top: 1px solid #000;
        padding-top: 2.8rem;
    }

    .content_info h3 {
        font-size: 2rem;
        font-weight: bold;
        line-height: 1.5;
        letter-spacing: -0.06rem;
        position: relative;
        padding-left: 7rem;
    }
    .about .content_info h3,
    .use_aklover .content_info h3 {
        padding-left: 0;
    }
    .content_info h3 .step {
        position: absolute;
        left: 0;
        top: 0;
        color: #ff4c05;
        text-decoration: underline;
        margin-right: 1.4rem;
    }

    .content_info p {
        margin-top: 3.2rem;
        font-size: 1.5rem;
        line-height: 1.5;
        letter-spacing: -0.045rem;
        font-weight: 500;
        opacity: 0.7;
    }
    .use_aklover .content_info p {
        margin-top: 2rem;
    }
    .method_list {
        margin-top: 4.9rem;
    }

    .method_list .method_item {
        margin-bottom: 3rem;
    }

    .method_list .item_word {
        background-color: #f8f8f8;
        width: fit-content;
        padding: 0.9rem 1rem;
        font-size: 1.65rem;
        font-weight: 500;
        line-height: 1.45;
        letter-spacing: -0.083rem;
    }

    .method_list .item_des {
        margin-top: 1.7rem;
        font-size: 1.5rem;
        font-weight: 500;
        line-height: 1.6;
        letter-spacing: -0.075rem;
        opacity: 0.7;
    }

    .caution {
        background-color: #f8f8f8;
        border-radius: 0.5rem;
        padding: 4.5rem 6rem;
        gap: 5rem;
    }

    .caution p {
        font-size: 1.95rem;
        line-height: 1.64;
        letter-spacing: -0.098rem;
    }

    .content {
        margin-bottom: 5rem;
    }

    .content .con_left {
        width: calc(100% - 50rem);
    }

    .content .con_right {    
        width: 48rem;
    }

    .con_info h3 {
        font-size: 2.2rem;
        font-weight: bold;
        line-height: 1.39;
        letter-spacing: -0.11rem;
    }

    .con_info .point {
        color: #ff4c05;    
        font-size: 1.65rem;
        font-weight: 600;
        margin-left: 1rem;
    }

    .con_info .description {
        font-size: 1.5rem;
        color: #373737;
        line-height: 1.6;
        letter-spacing: -0.075rem;
        margin: 1.2rem 0;
    }

    .con_info .method {
        margin: 3rem 0 1.6rem;
        background-color: #f8f8f8;
        border-radius: 0.5rem;
        width: fit-content;
        font-size: 1.65rem;
        font-weight: 600;
        letter-spacing: -0.083rem;
        padding: 0.8rem 1rem;
    }

    .con_info .method_banner_list li {
        font-size: 1.5rem;
        line-height: 1.55;
        font-weight: 500;
        letter-spacing: -0.045rem;
        margin-bottom: 0.8rem;
    }

    .content_info .btn_round {
        width: fit-content;
        border: 1px solid #e5e5e5;
        border-radius: 2.4rem;
        margin-top: 3.9rem;
    }

    .content_info .btn_round a {
        padding: 1.6rem 3rem;
        display: block;
        cursor: pointer;
        font-size: 1.7rem;
        font-weight: 600;
        letter-spacing: -0.085rem;
    }

    .con_info .btn_square {
        margin-top: 3.4rem;
        background-color: #000;
        width: fit-content;
        border-radius: 0.5rem;
    }

    .con_info .btn_square a {
        display: block;
        padding: 1.5rem 2.3rem;
        color: #fff;
        font-size: 1.8rem;
        line-height: 1.3;
        letter-spacing: -0.09rem;
        cursor: pointer;
    }

    .con_info .btn_square img {
        vertical-align: inherit;
        margin-left: 1rem
    }


    .con_info .number {
        display: inline-block;
        width: 2.1rem;
        height: 2.1rem;
        border-radius: 0.3rem;
        background-color: #ff4c05;
        color: #fff;
        font-size: 1.4rem;
        font-weight: 800;
        text-align: center;
        line-height: 2.1rem;
        margin-right: 1rem;
    }

    .content .banner {
        background-color: #f8f8f8;
        border-radius: 1rem;
        text-align: center;
        padding: 8rem 0;
    }

    .content .pad_short {
        padding: 4rem 0;
    }

    .banner .banner_image {
        margin: 0 auto;
    }

    .banner .text {
        font-size: 3.2rem;
        font-weight: bold;
        line-height: 2.5;
        letter-spacing: -0.16rem;
    }

    .banner .banner_info {
        margin-top: 2rem;
        font-size: 1.5rem;
        opacity: 0.7;
        font-weight: 500;
        line-height: 1.4;
        letter-spacing: -0.045rem;
    }

    .image_content {
        grid-row-gap: 4.9rem;
    }

    .image_content .con_tit {
        margin-top: 1.8rem;
        font-size: 2rem;
        font-weight: bold;
        letter-spacing: -0.1rem;
    }

    .image_content .con_tit a {
        font-size: 2rem;
        font-weight: bold;
        letter-spacing: -0.1rem;
    }

    .image_content .con_tit .arrow {
        margin-left: 0.7rem;
    }

    .image_content .con_tit .arrow img {
        vertical-align: top;
    }

    .image_content .cont_des {
        margin-top: 1.8rem;
        font-size: 1.65rem;
        letter-spacing: -0.083rem;
        line-height: 1.58;
        color: #373737;
    }
    .image_content .cont_des .mini {
        font-size: 1.2rem;
        display: inline-block;
        vertical-align: top;
    }
    .image_content .btn_moreview {
        margin-top: 4rem;
        width: fit-content;
        border: 1px solid #e5e5e5;
        border-radius: 4rem;
    }

    .image_content .btn_moreview a {
        display: block;
        padding: 1.6rem 3rem;
        font-size: 1.7rem;
        font-weight: 600;
        line-height: 1.71;
        letter-spacing: -0.085rem;
    }

    .gift_content li {
        background-color: #fafafa;
        display: grid;
        grid-template-columns: 1fr 3fr 1.5fr;
        grid-column-gap: 1rem;
        align-items: center;
        padding: 3rem 0rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }

    .gift_content .gift_num {
        text-align: center;
    }

    .gift_content .gift_num p:first-child {
        color: #ff4c05;
        font-size: 1.5rem;
        letter-spacing: -0.045rem;
    }

    .gift_content .gift_num p:last-child {
        margin-top: 1.3rem;
        color: #ff4c05;
        font-size: 5rem;
    }

    .gift_content .gift_info_tit {
        font-size: 1.95rem;
        font-weight: bold;
        line-height: 1.33;
        letter-spacing: -0.117rem;
    }

    .gift_content .gift_info_des {
        font-size: 1.5rem;
        line-height: 1.5;
        letter-spacing: -0.09rem;
        opacity: 0.8;
        margin-top: 1rem;
    }

    .gift_content .gift_icon {
        margin: 0 auto;
    }

    .gift_bottom {
        position: relative;
        margin: 3rem 0;
    }

    .gift_bottom::before {
        content:"��";
        display: inline-block;
        position: absolute;
        top: 0.5rem;
        left: 0;
    }

    .gift_bottom p {
        font-size: 1.5rem;
        color: #373737;
        line-height: 1.6;
        letter-spacing: -0.075rem;
        margin-left: 2rem;
    }

    .point_contents > li {
        gap: 1rem;
        margin-bottom: 8rem;
    }

    /* .point_contents .point_left {
        width: calc(100% - clamp(40rem, 60%, 65rem));
    }

    .point_contents .point_right {
        width: clamp(45rem, 60%, 62.4rem);
    } */

    .point_contents .point_info p {
        font-size: 1.95rem;
        font-weight: bold;
        line-height: 1.33;
        letter-spacing: -0.098rem;
    }

    .point_contents .point_info .number {
        display: inline-block;
        width: 2.1rem;
        height: 2.1rem;
        border-radius: 0.3rem;
        background-color: #ff4c05;
        color: #fff;
        font-size: 1.4rem;
        font-weight: 800;
        text-align: center;
        line-height: 2.1rem;
        margin-right: 1rem;
        vertical-align: text-bottom;
    }

    .point_contents .point_info ul {
        margin-top: 2.6rem;
        padding-left: 1.3rem;
    }

    .point_contents .point_info ul li {
        font-size: 1.65rem;
        color: #373737;
        line-height: 1.58;
        letter-spacing: -0.083rem;
        list-style-type: '- ';
        list-style-position : outside;
    }

    /* ���̺� CSS ______________________________________________________________________________________________________________________*/
    .grid_custom {
        display: grid;
        grid-template-columns: 23fr 57.2fr 23.4fr;
        grid-column-gap: 0.4rem;
        align-items: center;
    }

    /* �߰� */
    .grid_custom.g2 {
        grid-template-columns: 23fr 80.6fr;
        grid-column-gap: 0.4rem;
    }
    /* �߰� */
    .grid_custom.g2_1 {
        grid-template-columns: 57.2fr 23.4fr;
        grid-column-gap: 0.4rem;
        padding: 1.9rem 0;
    }
    .grid_custom.g2_2 {
        grid-template-columns: 15fr 65.6fr;
        grid-column-gap: 0.4rem;
        padding: 1.9rem 0;
    }
    .grid_custom.g2_3 {
        grid-template-columns: 42fr 23.4fr;
        grid-column-gap: 0.4rem;
        padding: 1.9rem 0;
    }
    .padd_1 {
        padding: 1rem !important;
    }
    .grid_custom.ti > div:first-child {
        text-indent: -150px;
    }

    .table_container {
        border: 1px solid #e5e5e5;
        padding: 2rem 2rem 1rem;
        border-radius: 0.5rem;

    }
    .table_container .table_head > div {
        background-color: #f8f8f8;
        padding: 1.5rem 0;
        border-radius: 0.5rem;
        font-size: 1.65rem;
        font-weight: 500;
        letter-spacing: -0.083rem;
    }

    /* �߰� */
    .table_container .table_body .division {
        height: 100%;
        background-color: #f8f8f8;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .table_container .table_body .division.color_orange {
        background-color: rgba(255, 76, 5, 0.05);
    }

    .table_container .table_body li {
        padding: 1rem 0;
        border-bottom: 1px solid #e5e5e5;
    }

    .table_container .table_body li:last-child {
        border-bottom: 0;
    }

    .table_container .table_body li > div {
        font-size: 1.7rem;
        font-weight: 500;
        letter-spacing: -0.085rem;
        line-height: 1.53;
    }

    .table_container .table_body li > div:first-child {
        position: relative;
    }

    .table_container .table_body li > div:first-child::after {
        display: block;
        content: "";
        width: 1px;
        height: 2.6rem;
        background-color: #e5e5e5;
        position: absolute;
        top: 0; 
        right: -0.4rem;
    }

    .table_container .table_body .tb_inner > div {
        border-bottom: 1px solid #e5e5e5;
    }

    .table_container .table_body .tb_inner > div > div {
        position: relative;
    }

    .table_container .table_body .tb_inner div > div:not(.no_line)::after {
        display: block;
        content: "";
        width: 1px;
        height: 2.5rem;
        background-color: #e5e5e5;
        position: absolute;
        top: 50%;
        right: -0.5rem;
        transform: translate(-50%, -50%);
    }

    .table_container .table_body .tb_inner > div:last-child {
        border-bottom: 0;
    }

    .point_contents .point_image img {
        width: 100%;
    }

    .point_contents .point_notice {
        border: 1px solid #e5e5e5;
        padding: 2rem;
    }

    .point_contents .point_notice .pn_top {
        background-color: #f8f8f8;
        border-radius: 0.5rem;
        padding: 1.4rem 0;
        font-size: 1.65rem;
        text-align: center;
        font-weight: 500;
        letter-spacing: -0.083rem;
    }

    .point_contents .point_notice .pn_content {
        counter-reset: colorcircle 0;
    }

    .point_contents .point_notice .pn_content li {
        padding: 3rem 4rem;
        border-bottom: 1px solid #e5e5e5;
        counter-increment: colorcircle 1;
        list-style-position: inside;

        font-size: 1.65rem;
        font-weight: 500;
        line-height: 1.58;
        letter-spacing: -0.083rem;
    }

    .point_contents .point_notice .pn_content li::before {
        display: inline-block;
        content: counter(colorcircle) ". ";
    }

    .point_contents .point_notice .pn_content li:last-child {
        border-bottom: 0;
    }

    .point_contents .point_notice .pn_content .pn_des {
        margin-top: 1.9rem;
        color: rgba(55, 55, 55, 0.8);
        font-size: 1.5rem;
        line-height: 1.63;
        letter-spacing: -0.075rem;
    }

    .point_contents .point_notice .pn_content .pn_des span {
        display: inline-block;
        line-height: 1;
    }

    .point_contents .point_notice .pn_content .pn_des .arr_img {
        width: 0.6rem;
        height: .6rem;
        background: url(/img/front/intro/diagonal_arrow.webp) no-repeat center;
        background-size: contain;
        display: block;
        position: absolute;
        right: 1.1rem;
        top: .9rem;
    }
    .point_contents .point_notice .pn_content .more_view {
        display: inline-block;
        height: 3rem;
        line-height: 3rem;
        background-color: #f6f6f6;
        border-radius: 1.5rem;
        padding: 0 2.2rem 0 1.5rem;
        font-size: 1.2rem;
        margin-left: .2rem;
        transition: .4s;
        position: relative;
    }
    .point_contents .point_notice .pn_content .more_view:hover {
        background: #000;
        color: #fff;
    }
    .point_contents .point_notice .pn_content .more_view:hover .arr_img {
        background: url(/img/front/intro/diagonal_arrow_wh.png) no-repeat center;
        background-size: contain;
    }

    /* �˾� */
    .popup .inner {
        height: 82vh;
    }


    /* pc 1290 */
    @media(max-width: 1680px) {
        .point_contents .point_notice .pn_content li {
            padding: 3rem 1rem;
        }
    }
</style>
<?
//�������� ��û�� Ȯ���� Ǫ��X
include_once  PATH_INC_END.'tail2.php';
?>
