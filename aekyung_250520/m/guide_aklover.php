<? include_once "head.php";?> 
<link rel="stylesheet" type="text/css" href="/m/css/musign/guide_aklover.css" />
<div id="subpage" class="aklove_page use_aklover">
    <div class="sub_title">
        <div class="sub_wrap">
            <div>
                <h1 class="fz74 main_c fw500 ko">AK Lover �̿�鼭</h1>
                <p class="fz28 fw600 desc">AK Lover Ȩ������ �̿��� A to Z ���� ���������!</p>
            </div>
            <div class="tab_wrap">
                <ul class="tab f_cs">
                    <li><a href="/m/guide_aklover.php" class="fz24 fw500 on">Ȩ������ ��</a></li>
                    <li class="rel">
                        <a class="fz24 fw500 tab_btn">�������� �� <img src="/img/front/intro/arrow_white.webp" alt="ȭ��ǥ" class="black"/></a>
                        <ul class="tab_list">
                            <li><a href="/m/beauty_life_aklover.php" class="fz28 fw600">�����̾� ��������</a></li>
                            <li><a href="/m/basic_aklover.php" class="fz28 fw600">������ ��������</a></li>
                            <li><a href="/m/use_aklover.php" class="fz28 fw600">������ ǥ�� �� ����</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>        
    </div>
    <div class="sub_cont">
        <div class="sub_wrap">
            <div class="left">
                <div class="content_info">
                    <h3><span class="step">Step.1</span>ȸ�������ϱ�</h3>
                    <p>
                        AK Lover Ȩ�������� �����Ͻø� �پ��� Ȱ���� ������ ��� �� �ֽ��ϴ�.
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
        <div class="sub_wrap">
            <div class="left">
                <div class="content_info">
                    <h3><span class="step">Step.2</span>���������� �ϼ��ϱ�</h3>
                    <p>
                        ������ �������� �ϼ��غ�����. ������ �ϼ� �� �߰� ����Ʈ�� �����˴ϴ�.
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
                        <p class="cont_des">������������ > ���� ���� ���桮�� ���� ������ ���� ������ �����մϴ�.</p>
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
                                <a href="/m/login.php">������ �ϼ��Ϸ� ����</a>
                            <? }else{ ?>
                                <a href="/m/infoauth.php?board=infoauth">������ �ϼ��Ϸ� ����</a>
                                <!-- <a href="/m/today_view.php?board=group_04_03&statusSearch=&hero_idx=443487&hero_gisu=&select=hero_title&kewyword=&date-from=2024.08.29&date-to=2024-08.29">������ �ϼ��Ϸ� ����</a> -->
                            <? } ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="sub_cont">
        <div class="sub_wrap">
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
                    <li>
                        <div class="lc_image">
                            <img src="/img/front/intro/browse_page_1_1.webp" alt="�̴��� �̺�Ʈ" />
                        </div>
                        <div class="lc_des">
                            <h3>
                                <a href="/m/board_00.php?board=group_02_03">    
                                    �̴��� �̺�Ʈ<span class="arrow"><img src="/img/front/intro/diagonal_arrow.webp" alt="ȭ��ǥ"/></span>
                                </a>
                            </h3>
                            <p>
                                AK Lover��� ������ ���� ������ ������ �̺�Ʈ�� �ſ� ����˴ϴ�.<br />
                                AK Lover ���� �ν�Ÿ�׷��� �ȷο��Ͻø� �̺�Ʈ �ҽ���<br /> ���� ������ �޾ƺ��� �� �ֽ��ϴ�.
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="lc_image">
                            <img src="/img/front/intro/browse_page_2.jpg" alt="����Ʈ ����" class="border_round" />
                        </div>
                        <div class="lc_des">
                            <h3>
                                <a href="/m/order.php?board=group_04_21">    
                                    ����Ʈ �佺Ƽ��<span class="arrow"><img src="/img/front/intro/diagonal_arrow.webp" alt="ȭ��ǥ" /></span>
                                </a>
                            </h3>
                            <p>
                                AK Lover Ȱ������ ������ ����Ʈ�� �ְ��� �پ��� �α� ��ǰ��<br/>
                                ���� ���� �� ��ȯ�� �� �ִ� �̺�Ʈ�Դϴ�.<br />
                                �� 2ȸ(��ݱ�/�Ϲݱ�) ����Ǹ�, �佺Ƽ�� ������ ��¦ �����˴ϴ�.<br />
                                <span class="fz20 gray">(��ݱ� : �̴��� AK Lover �� �����̾� ��� / �Ϲݱ� : ��ü ȸ�� ���)</span>
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="lc_image">
                            <img src="/img/front/intro/browse_page_4.webp" alt="�⼮üũ" />
                        </div>
                        <div class="lc_des">
                            <h3>
                                <a href="/m/check.php?board=group_04_04">    
                                    �⼮üũ<span class="arrow"><img src="/img/front/intro/diagonal_arrow.webp" alt="ȭ��ǥ" /></span>
                                </a>
                            </h3>
                            <p>
                                AK Lover Ȩ������ �⼮ üũ �� ����Ʈ�� �����Ǹ�,<br />
                                �� ������ �� Lover���Դ� �� ū ������ �����˴ϴ�.
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="lc_image">
                            <img src="/img/front/intro/browse_page_3.webp" alt="�̵��" />
                        </div>
                        <div class="lc_des">
                            <h3>
                                <a href="/m/media.php">
                                    �̵�� �ҽ�<span class="arrow"><img src="/img/front/intro/diagonal_arrow.webp" alt="ȭ��ǥ" /></span>
                                </a>
                            </h3>
                            <p>
                                AK Lover�� SNS �ҽ� �� �ְ�� �귣���� �پ��� �ҽ���<br />
                                �� ���� ��ƺ� �� �ִ� �����Դϴ�.
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="lc_image">
                            <img src="/img/front/intro/browse_page_5.webp" alt="������" />
                        </div>
                        <div class="lc_des">
                            <h3>
                                <a href="/m/today.php?board=group_02_02">    
                                    Lover ��<span class="arrow"><img src="/img/front/intro/diagonal_arrow.webp" alt="ȭ��ǥ" /></span>
                                </a>
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
<?include_once "tail.php";?>