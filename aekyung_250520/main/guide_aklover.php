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
<link rel="stylesheet" type="text/css" href="/css/front/guide_aklover.css" />
<div id="subpage" class="aklove_page">
    <div class="sub_title">
        <div class="sub_wrap">
            <div class="f_b">
                <div>
                    <h1 class="fz68 main_c fw500 ko">AK Lover �̿�鼭</h1>
                    <p class="fz18 fw600">AK Lover Ȩ������ �̿��� A to Z ���� ���������!</p>
                </div>
                <ul class="tab f_c">
                    <li><a href="/main/guide_aklover.php" class="fz18 fw600 on">Ȩ������ ��</a></li>
                    <li class="rel">
                        <a class="fz18 fw600 tab_btn">�������� �� <img src="/img/front/intro/arrow_white.webp" alt="ȭ��ǥ" class="black"/></a>
                        <ul class="tab_list">
                            <li><a href="/main/beauty_life_aklover.php" class="fz18 fw600">�����̾� ��������</a></li>
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
                    <h3><span class="step">Step.1</span>ȸ�������ϱ�</h3>
                    <p>
                        AK Lover Ȩ�������� �����Ͻø�<br />
                        �پ��� Ȱ���� ������ ��� �� �ֽ��ϴ�.
                    </p>
                </div>
            </div>
            <div class="right">
                <ul class="image_content grid_2">
                    <li>
                        <div class="con_image">
                            <img src="/img/front/intro/guide_step1_1.png" alt="ȸ������ ��ư Ŭ��" />
                        </div>
                        <p class="con_tit"><span class="number">1</span>AK Lover Ȩ������ ����� ȸ������ ��ư Ŭ��!</p>
                    </li>
                    <li>
                        <div class="con_image">
                            <img src="/img/front/intro/guide_step1_2.png" alt="ȸ������ �Ϸ�" />
                        </div>
                        <p class="con_tit"><span class="number">2</span>���� ������ �ۼ��ϸ� ȸ������ �Ϸ�!</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="sub_cont">
        <div class="sub_wrap board_wrap f_sb">
            <div class="left">
                <div class="content_info">
                    <h3><span class="step">Step.2</span>���������� �ϼ��ϱ�</h3>
                    <p>
                        ������ �������� �ϼ��غ�����.<br />
                        ������ �ϼ� �� �߰� ����Ʈ�� �����˴ϴ�.
                    </p>
                </div>
            </div>
            <div class="right">
                <ul class="image_content grid_2">
                    <li>
                        <div class="con_image">
                            <img src="/img/front/intro/guide_step2_1.png" alt="������ ���� ����" />
                        </div>
                        <p class="con_tit"><span class="number">1</span>������ ������ ������ ������.</p>
                        <p class="cont_des">������������ > �� ���� ���桮�� ���� ������ ���� ������ �����մϴ�.</p>
                    </li>
                    <li>
                        <div class="con_image">
                            <img src="/img/front/intro/guide_step2_2.png" alt="sns ����" />
                        </div>
                        <p class="con_tit"><span class="number">2</span>Ȱ���ϴ� �̵��(SNS)�� ������ �ּ���.</p>
                        <p class="cont_des">
                            ����, ��α�, �ν�Ÿ �� Ȱ���ϰ� �ִ� ���� SNS ���� ���� �� ü��� ��û�� �����մϴ�.
                        </p>
                    </li>
                    <li>
                        <div class="con_image">
                            <img src="/img/front/intro/guide_step2_3.png" alt="���� ���� �Է�" />
                        </div>
                        <p class="con_tit"><span class="number">3</span>���� ������ �Է��� ������.</p>
                        <p class="cont_des">
                            ������ ������ �Է��Ͽ� ������ �ϼ� �� AK Lover ����Ʈ�� �߰� �����˴ϴ�. (+30P)
                        </p>
                    </li>
                    <li class="profile">
                        <img src="/img/front/intro/plus_profile.webp" alt="������ �ϼ��ϱ� ������" />
                        <p class="con_tit">�������� �ϼ��Ϸ� �������?</p>
                        <div class="btn_moreview">
                            <? if($_SESSION['temp_code']=='' && !$_SESSION["global_code"]){?>   <!-- ��α��� -->
                                <a href="/main/index.php?board=login">������ �ϼ��Ϸ� ����</a>
                            <? }else{ ?>
                                <a href="/main/index.php?board=infoauth">������ �ϼ��Ϸ� ����</a>
                                <!-- <a href="/main/index.php?board=group_04_03&page=1&view=view&idx=443487">������ �ϼ��Ϸ� ����</a> -->
                            <? } ?>
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
                    <h3><span class="step">Step.3</span>Ȩ������ �ѷ�����</h3>
                    <p>
                        �������� Ȱ�� �ܿ��� �̺�Ʈ �� Ŀ�´�Ƽ ������ ���õǾ��ֽ��ϴ�.<br />
                        �پ��� AK Lover Ȩ�������� �ѷ�������.
                    </p>
                </div>
            </div>
            <div class="right">
                <ul class="look_content">
                    <li class="f_fs">
                        <div class="lc_image">
                            <img src="/img/front/intro/browse_page_1_1.webp" alt="�̴��� �̺�Ʈ" />
                        </div>
                        <div class="lc_des">
                            <h3>
                                <a href="/main/index.php?board=group_02_03">    
                                    �̴��� �̺�Ʈ<span class="arrow"><img src="/img/front/intro/diagonal_arrow.webp" alt="ȭ��ǥ" /></span>
                                </a>
                            </h3>
                            <p>
                                AK Lover��� ������ ���� ������ ������ �̺�Ʈ�� �ſ� ����˴ϴ�.<br />
                                AK Lover ���� �ν�Ÿ�׷��� �ȷο��Ͻø� �̺�Ʈ �ҽ���<br /> ���� ������ �޾ƺ��� �� �ֽ��ϴ�.
                            </p>
                        </div>
                    </li>
                    <li class="f_fs">
                        <div class="lc_image">
                            <img src="/img/front/intro/browse_page_2.jpg" alt="����Ʈ ����" />
                        </div>
                        <div class="lc_des">
                            <h3>
                                <a href="/main/index.php?board=group_04_21">
                                    ����Ʈ �佺Ƽ��<span class="arrow"><img src="/img/front/intro/diagonal_arrow.webp" alt="ȭ��ǥ" /></span>
                                </a>
                            </h3>
                            <p>
                                AK Lover Ȱ������ ������ ����Ʈ�� �ְ��� �پ��� �α� ��ǰ��<br /> 
                                ���� ���� �� ��ȯ�� �� �ִ� �̺�Ʈ�Դϴ�.<br />
                                �� 2ȸ(��ݱ�/�Ϲݱ�) ����Ǹ�, �佺Ƽ�� ������ ��¦ �����˴ϴ�.<br />
                                <span class="fz15 gray">(��ݱ� : �̴��� AK Lover �� �����̾� ��� / �Ϲݱ� : ��ü ȸ�� ���)</span>
                            </p>
                        </div>
                    </li>
                    <li class="f_fs">
                        <div class="lc_image">
                            <img src="/img/front/intro/browse_page_4.webp" alt="�⼮üũ" />
                        </div>
                        <div class="lc_des">
                            <h3>
                                <a href="/main/index.php?board=group_04_04">
                                    �⼮üũ<span class="arrow"><img src="/img/front/intro/diagonal_arrow.webp" alt="ȭ��ǥ" /></span>
                                </a>
                                <!-- <a href="/main/index.php?board=group_04_03&page=1&view=view&idx=443487">
                                    �⼮üũ<span class="arrow"><img src="/img/front/intro/diagonal_arrow.webp" alt="ȭ��ǥ" /></span>
                                </a> -->
                            </h3>
                            <p>
                                AK Lover Ȩ������ �⼮ üũ �� ����Ʈ�� �����Ǹ�,<br />
                                �� ������ �� Lover���Դ� �� ū ������ �����˴ϴ�.
                            </p>
                        </div>
                    </li>
                    <li class="f_fs">
                        <div class="lc_image">
                            <img src="/img/front/intro/browse_page_3.webp" alt="�̵��" />
                        </div>
                        <div class="lc_des">
                            <h3>
                                <a href="/main/media.php">    
                                    �̵�� �ҽ�<span class="arrow"><img src="/img/front/intro/diagonal_arrow.webp" alt="ȭ��ǥ" /></span>
                                </a>
                            </h3>
                            <p>
                                AK Lover�� SNS �ҽ� �� �ְ�� �귣���� �پ��� �ҽ���<br />
                                �� ���� ��ƺ� �� �ִ� �����Դϴ�.
                            </p>
                        </div>
                    </li>
                    <li class="f_fs">
                        <div class="lc_image">
                            <img src="/img/front/intro/browse_page_5.webp" alt="������" />
                        </div>
                        <div class="lc_des">
                            <h3>
                                <a href="/main/index.php?board=group_02_02">    
                                    Lover ��<span class="arrow"><img src="/img/front/intro/diagonal_arrow.webp" alt="ȭ��ǥ" /></span>
                                </a>
                                <!-- <a href="/main/index.php?board=group_04_03&page=1&view=view&idx=443487">    
                                    Lover ��<span class="arrow"><img src="/img/front/intro/diagonal_arrow.webp" alt="ȭ��ǥ" /></span>
                                </a> -->
                            </h3>
                            <p>
                                �����е��� ������ ���̵��� ü��� �� �ϻ� �̾߱⸦<br />
                                �����ϴ� ���� �����Դϴ�.
                            </p>
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
