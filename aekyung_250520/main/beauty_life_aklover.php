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
<link rel="stylesheet" type="text/css" href="/css/front/club_aklover.css" />

<!-- �������� -->
<div id="subpage" class="aklove_page">
    <div class="sub_title">
        <div class="sub_wrap">
            <div class="f_b">
                <div>
                    <h1 class="fz68 main_c fw500 ko">AK Lover �̿�鼭</h1>
                    <p class="fz18 fw600">AK Lover Ȩ������ �̿��� A to Z ���� ���������!</p>
                </div>
                <ul class="tab f_c">
                    <li><a href="/main/guide_aklover.php" class="fz18 fw600">Ȩ������ ��</a></li>
                    <li class="rel">
                        <a class="fz18 fw600 tab_btn on">�������� �� <img src="/img/front/intro/arrow_white.webp" alt="ȭ��ǥ" /></a>
                        <ul class="tab_list">
                            <li><a href="/main/beauty_life_aklover.php" class="fz18 fw600 select">�����̾� ��������</a></li>
                            <li><a href="/main/basic_aklover.php" class="fz18 fw600">������ ��������</a></li>
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
                    <a href="/main/beauty_life_aklover.php" class="fz18 fw600 f_cs mission_guide_btn">������� ��������<img src="/img/front/member/arr.webp" alt="������� ��������"></a>
                </div>
            </div>
            <div class="contents right">
                <ul class="image_content grid_2">
                    <li>
                        <div class="con_image">
                            <img src="/img/front/intro/beautyclub.webp" alt="��Ƽ Ŭ��" />
                        </div>
                        <p class="con_tit">Premier Beauty Club</p>
                        <p class="cont_des">��Ƽ ����ǰ ��� �� <b class="bold">����������</b> �������� �����ϴ� ��������</p>
                        <div class="btn_moreview">
                            <a href="/main/index.php?board=group_04_06">�����̾� ��Ƽ Ŭ�� �ڼ��� ����</a>
                        </div>
                    </li>
                    <li>
                        <div class="con_image">
                            <img src="/img/front/intro/lifeclub.webp" alt="������ Ŭ��" />
                        </div>
                        <p class="con_tit">Premier Life Club</p>
                        <p class="cont_des">
                            ��Ȱ��ǰ ����ǰ ��� �� <b class="bold">����������</b> �������� �����ϴ� ��������
                        </p>
                        <div class="btn_moreview">
                            <a href="/main/index.php?board=group_04_28">�����̾� ������ Ŭ�� �ڼ��� ����</a>
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
                            <div class="gift_info_tit">�ֿ���� �û�(�ִ� 30���� + AK Lover ����Ʈ 20����)</div>
                            <p class="gift_info_des">
                                Ȱ�� �Ⱓ ���� ��, ���� ����ڸ� �����Ͽ� �ִ� 30���� + AK Lover ����Ʈ 20���� ������ �����մϴ�.<br />
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
                                �ִ� 10���� ����� ��ǰ���� �帳�ϴ�. <span class="gray">(�ִ� 20��)</span>
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
                                �����̾� ������� ������ ��� �е��� ȯ���ϴ� ������ ���<br />
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
                                �����̾� ���������� �ʼ� Ȱ�� ������ ������ �е鿡��<br />
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
                                �پ��� Ȱ������ ������ ����Ʈ�� �ְ��� �α� ��ǰ��<br />
                                ���� ���� �� ��ȯ�� �� �ִ� �̺�Ʈ�Դϴ�.<br />
                                <span class="gray">(��ݱ� : �̴��� AK Lover �� �����̾� �������� ��� / �Ϲݱ� : ��ü ȸ�� ���)</span>
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
                            <div class="gift_info_tit">�ְ� ����ǰ/���׵� ���� ��ǰ ����</div>
                            <p class="gift_info_des">
                                ������ �ۼ��� ���Ͽ� �ְ� ����ǰ/���׵� ���� ��ǰ�� �����մϴ�.<br />
                                <span class="gray">(Ȱ�� �Ⱓ �� ��� 20ȸ)</span>
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
                        �������̾� ��Ƽ/������ Ŭ������ �� 2ȸ(��ݱ�/�Ϲݱ�) ���� �����Ͽ��� ���� ���� ��Ź�帳�ϴ�.<br />
                        �� Ȱ�� ������ ��Ȳ�� ���� ����� �� �ֽ��ϴ�. 
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
                    <li>
                        <div class="point_info">
                            <p><span class="number">1</span>����Ʈ ����</p>
                            <ul>
                                <li>������ ����/����/ƽ��/���̹����Ʈ � �ش��մϴ�.</li>
                                <li>�Խù�/��� �ۼ��� ���� ����Ʈ ȹ���� �� �ִ� 20P���� �����մϴ�.</li>
                                <li>����Ʈ ���� ������ ��Ȳ�� ���� ������ �� �ֽ��ϴ�.</li>
                            </ul>
                        </div>
                        <div class="table_container t_c club_tb">
                            <div class="table_head grid_custom">
                                <div>Ȱ�� ����</div>
                                <div>Ȱ�� ����</div>
                                <div>����Ʈ</div>
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
                                            <div class="no_line">+ 50</div>
                                        </div>
                                        <div class="grid_custom g2_1">
                                            <div>���� ����</div>
                                            <div class="no_line">+ 10</div>
                                        </div>
                                        <div class="grid_custom g2_1">
                                            <div>�Խñ� �ۼ�</div>
                                            <div class="no_line">+ 2</div>
                                        </div>
                                        <div class="grid_custom g2_1">
                                            <div>��� �ۼ�</div>
                                            <div class="no_line">+ 1</div>
                                        </div>
                                        <div class="grid_custom g2_1">
                                            <div>�� �⼮ üũ</div>
                                            <div class="no_line">+ 1</div>
                                        </div>
                                    </div>
                                </li>
                                <li class="grid_custom g2">
                                    <div class="division">��������</div>
                                    <div class="tb_inner">
                                        <div class="grid_custom g2_2 padd_1b">
                                            <div class="division color_orange no_line">������ �ۼ�</div>
                                            <div class="tb_inner no_line">
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>��α� <span class="fz14 gray">(�ش� ��/�ش� �� ��)</span></div>
                                                    <div class="no_line">+ 2,500</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>�ν�Ÿ�׷� <span class="fz14 gray">(�ش� ��/�ش� �� ��)</span></div>
                                                    <div class="no_line">+ 2,000</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>���� ����(����/����/ƽ�� ��) <span class="fz14 gray">(�ش� ��)</span></div>
                                                    <div class="no_line">+ 2,000</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>���� ����(����/����/ƽ�� ��) <span class="fz14 gray">(�ش� �� ��)</span></div>
                                                    <div class="no_line">+ 1,500</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>*���� ����<span class="fz14 gray">(*Ű���� ç���� ��)</span></div>
                                                    <div class="no_line">+ 5,000</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>�ν�Ÿ�׷� *���̿� Ү<br /> �̺�Ʈ/�Ǹ�ó ��ũ ���� <span class="fz14 gray">(�Ϻ� �̼� �ش�)</span></div>
                                                    <div class="no_line">+ 1,500</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>�ν�Ÿ�׷� ���丮 ���ε� <span class="fz14 gray">(1�� ���� / 20�ð� �̻� ���� ���� �ʼ�)</span></div>
                                                    <div class="no_line">+ 500</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid_custom g2_2 padd_1">
                                            <div class="division color_orange no_line">Ű���� ç����</div>
                                            <div class="tb_inner no_line">
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>*���� ���� <span class="fz14 gray">(~ 5�� / �� Ű���� ��)</span></div>
                                                    <div class="no_line">+ 1,500</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>���� <span class="fz14 gray">(�ִ� 3�� ���� / �� Ű���� ��)</span></div>
                                                    <div class="no_line">+ 1,000</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid_custom g2_2 padd_1">
                                            <div class="division color_orange no_line">��Ÿ SNS</div>
                                            <div class="tb_inner no_line">
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>�ʼ� ä�� �� <span class="fz14 gray">(�ִ� 3�� ���� / �� �̼� ��)</span></div>
                                                    <div class="no_line">+ 1,000</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid_custom g2_2 padd_1">
                                            <div class="division color_orange no_line">�Һ��� ����</div>
                                            <div class="tb_inner no_line">
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>�������� <span class="fz14 gray">(�� �̼� ��)</span></div>
                                                    <div class="no_line">+ 500 ~ 1,000</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="grid_custom g2">
                                    <div class="division">Ȱ��</div>
                                    <div class="tb_inner">
                                        <div class="grid_custom g2_2 padd_0">
                                            <div class="division color_orange no_line">������<br /> 2�� Ȱ��</div>
                                            <div class="tb_inner no_line">
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>�ܼ� Ȱ�� <span class="fz14 gray">(���׷�, �̹��� ĸ�� ��)</span></div>
                                                    <div class="no_line">+ 3,000</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>���� Ȱ�� <span class="fz14 gray">(������ ����, �ű� �Կ� ��)</span></div>
                                                    <div class="no_line">5���� ���<br /> �ְ� ��ǰ ����</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="point_info">
                            <p><span class="number">2</span>����Ʈ ����</p>
                            <ul>
                                <li>
                                    �������� ��û �� ������ ���ۼ� �� ����Ʈ ���� �� ���� �������� �������� ���ܵ˴ϴ�.
                                </li>
                            </ul>
                        </div>
                        <div class="table_container t_c club_tb">
                            <div class="table_head grid_custom">
                                <div>Ȱ�� ����</div>
                                <div>Ȱ�� ����</div>
                                <div>����Ʈ</div>
                            </div>
                            <ul class="table_body">
                                <li class="grid_custom g2">
                                    <div class="division">��������</div>
                                    <div class="tb_inner">
                                        <div class="grid_custom g2_2 padd_1b">
                                            <div class="division color_orange no_line">������ ���ۼ�</div>
                                            <div class="tb_inner no_line">
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>��α�</div>
                                                    <div class="no_line">- 5,000</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>����/�ν�Ÿ�׷�</div>
                                                    <div class="no_line">- 4,000</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid_custom g2_2 padd_1">
                                            <div class="division color_orange no_line">������ ���ؼ�</div>
                                            <div class="tb_inner no_line">
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>�ۼ� �Ⱓ</div>
                                                    <div class="no_line">- 2,500</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>���̵����</div>
                                                    <div class="no_line">- 2,500</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid_custom g2_2 padd_1">
                                            <div class="division color_orange no_line">��ǰ ��ۺ�</div>
                                            <div class="tb_inner no_line">
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>���� ���� or ����Ʈ ���� �� ���� ���� <span class="fz14 gray">(������ �̼ǿ� �� ��)</span></div>
                                                    <div class="no_line">- 1,000</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="point_left">
                            <div class="point_info">
                                <p><span class="number">3</span>����Ʈ ���� ����</p>
                            </div>
                        </div>                                             
                        <!-- <div class="point_right">
                            <div class="point_notice">
                                <div class="pn_top">
                                    Beauty, Life Club Ȱ�� ����Ʈ ���� ���� �ȳ�
                                </div>
                                <ul class="pn_content">
                                    <li>                                        
                                        ��α�, �ν�Ÿ�׷�, ����(����/ƽ��/����/���̹����Ʈ) �� ��ü���� ������ 1�Ǿ��� �����˴ϴ�.
                                        <p class="pn_des">
                                            ex. Aȸ���� ���� ���� ��α�a, ��α�b�� ������ �ۼ� �� ��α� 1�Ǹ� ����<br />
                                            Bȸ���� ���� ���� ��α�a, �ν�Ÿ�׷�a, b�� ������ �ۼ� �� ��α� 1��, �ν�Ÿ 1�� ����<br />
                                            Cȸ���� ���� ���� ��α�a, �ν�Ÿ�׷�a(�̹��� 1��, ���� 1��) ������ �ۼ�
                                            �� ��α� 1��, �ν�Ÿ 1��, ���� 1�� ���� (��, �� ��� ������ ���ο� ���� ���� ����Ʈ�� ������)
                                        </p>
                                    </li>
                                    <li>
                                        Ű����ç���� ����Ʈ ������ �ϱ� ���ؿ� ���� ����˴ϴ�.
                                        <p class="pn_des">
                                            - Ű����ç���� ���� ����Ʈ: Ȩ�������� �ı� ��ϵ� URL ����<br />
                                            - Ű����ç���� �������� ����Ʈ: īī�������� ���޵� �̹��� ĸ�� �ǿ� ����
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div> -->
                        <div class="point_right">
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
                                    <li>
                                        �ν�Ÿ�׷� ���̿�/���丮 ����Ʈ ���� ����
                                        <p class="pn_des">
                                            - �ν�Ÿ�׷� ���̿�/���丮�� ���� ����Ʈ ������ �Ϻ� �̼ǿ� �ش�Ǹ�, �ش� ���δ� ���̵���� �� �� �ȳ��帱 �����Դϴ�.<br />
                                            - �̼��� ������ ȭ���� ĸó�� �����ϴ� �ο��� ���� ����Ʈ ���� (������ - �ְ� ���� �ν�Ÿ�׷� DM / �����̾� - īī����)
                                        </p>
                                    </li>
                                    <li>
                                        �������� ����Ʈ ���� ����
                                        <p class="pn_des">
                                        - ���̵���� �� ������ '�������� ���� Ű����'�� ��α� �� ���� 10��/�ν�Ÿ �ǵ� 9�� �̳� ����� ��쿡 ���� ����Ʈ ����<br />
                                        - ������ ��� ���� +3 ������ ���� 10�� �������� ���� ����� �������� ���� (������ ��� ������ ���� ���ε�� ������ ����)<br />
                                        - �� ������ ���� ä�κ� �ִ� 1ȸ ����<br />
                                        ex. Aȸ���� ���� ���� ��α׿��� aŰ����, bŰ���� ���� ���� > ��α� 1�� ����<br />
                                        Bȸ���� ���� ���� ��α׿��� aŰ����, �ν�Ÿ�׷����� bŰ���� ���� ���� > ��α�, �ν�Ÿ�׷� 2�� ����
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?
//�������� ��û�� Ȯ���� Ǫ��X
include_once  PATH_INC_END.'tail2.php';
?>
