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
<div id="subpage" class="aklove_page use_aklover">
    <div class="sub_title">
        <div class="sub_wrap">
            <div class="f_b">
                <div>
                    <h1 class="fz68 main_c fw500 ko">������ ���/����</h1>
                    <p class="fz18 fw600">AK Lover Ȩ������ �̿��� A to Z ���� ���������!</p>
                </div>
                <ul class="tab f_c">
                    <li><a href="/main/guide_aklover.php" class="fz18 fw600">Ȩ������ ��</a></li>
                    <li class="rel">
                        <a class="fz18 fw600 tab_btn on">�������� �� <img src="/img/front/intro/arrow_white.webp" alt="ȭ��ǥ" /></a>
                        <ul class="tab_list">
                            <li><a href="/main/beauty_life_aklover.php" class="fz18 fw600">�����̾� ��������</a></li>
                            <li><a href="/main/basic_aklover.php" class="fz18 fw600">������ ��������</a></li>
                            <li><a href="/main/use_aklover.php" class="fz18 fw600 select">������ ǥ�� �� ����</a></li>
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
                    <h3>������ ���/����</h3>
                    <p>
                        ���並 �ۼ��ϴ� ä�ο� �´� ������ ������ �Է����ּ���. <br />
                        (��α� : ������ ���, �ν�Ÿ�׷�/���� : ������ ����)
                    </p>
                </div>
            </div>
            <div class="contents right pb_s">
                <div class="caution f_cs">
                    <img src="/img/front/intro/caution.webp" alt="����" />
                    <p class="bold">
                        �����ŷ�����ȸ ǥ�� ����� ��ħ�� ����, ü��� ������ �� ������ ��� �� ������ �ݵ�� �����ؾ� �մϴ�.<br />
                        �ش� ������ �������� ���� ��� ���� ó���� ���� �� �ֽ��ϴ�.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="sub_cont">
        <div class="sub_wrap board_wrap f_sb">
            <div class="left">
                <div class="content_info">
                    <h3>��α�</h3>
                    <p>
                        ������ ���� �ϴܿ� ������ ��ʸ� �������ּ���.
                    </p>
                    <!-- <div class="btn_round smart_btn">
                        <a>����Ʈ ��� �̿� ��� ����</a>
                    </div> -->
                </div>
            </div>
            <div class="contents right">
                <div class="content f_sb">
                    <div class="con_left">
                        <div class="con_info">
                            <h3>���̹� ��α� ������ ��� ����</h3>
                            <ul class="method_banner_list">
                                <li><span class="number">1</span>'������ ��� �̹��� �ٿ�ε�' ��ư�� Ŭ���Ѵ�.</li>
                                <li><span class="number">2</span>�ٿ�ε� �� �̹����� �����Ϳ� �����Ѵ�.</li>
                                <li><span class="number">3</span>��ũ �����ϱ� ��ư�� ���� ����� ��ũ�� ���� �̹����� �����Ѵ�.</li>
                            </ul>
                            <div class="btn_square f_fs">
                                <!-- <a class="btn_clip" data-clipboard-text="https://www.aklover.co.kr/main/index.php?board=group_04_03&page=1&view=view&idx=305476">������ ��� ��ũ �����ϱ� <img src="/img/front/board/copy.webp" alt="ī��" /></a> -->
                                <a class="btn_clip" data-clipboard-text="https://www.aklover.co.kr/main/index.php">������ ��� ��ũ �����ϱ� <img src="/img/front/board/copy.webp" alt="ī��" /></a>
                                <!-- <a class="btn_clip" href="/img/front/intro/sponsor_banner.jpg" download>������ ��� �̹��� �ٿ�ε� �ϱ�</a> -->
                                <a class="btn_clip" href="/img/front/icon/banner_img_2.png" download>������ ��� �̹��� �ٿ�ε� �ϱ�</a>
                            </div>
                        </div>
                    </div>
                    <div class="con_right">
                        <div class="banner pad_short">
                             <!-- [���߿�û] ���� 1-->
                            <div class="banner_image">
                            <!-- <img src="/img/front/intro/sponsor_banner.jpg" alt="���̹� ����Ʈ ������ ONE ���� ������ ���" /> -->
                                <img src="/img/front/icon/banner_img_2.png" alt="���̹� ����Ʈ ������ ONE ���� ������ ���" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sub_cont">
        <div class="sub_wrap board_wrap f_sb">
            <div class="left">
                <div class="content_info">
                    <h3>�ν�Ÿ�׷�, ����, ����, ƽ��</h3>
                    <p>
                        ������ ���� �ֻ�ܿ� ������ ������ �������� �ۼ����ּ���.<br />
                        ������ ����, ��� � ���ܼ� �ۼ��ϸ� ���� �����Դϴ�.
                    </p>
                </div>
            </div>
            <div class="contents right pb_m">
                <div class="content f_sb">
                    <div class="con_left">
                        <div class="con_info">
                            <h3>������ ����</h3>
                            <div class="btn_square clickBtn">
                                <a onclick="copyClipBoard('copy');">���� �����ϱ� <img src="/img/front/board/copy.webp" alt="ī��" /></a>
                            </div>
                        </div>
                    </div>
                    <div class="con_right">
                        <div class="banner">
                             <!-- [���߿�û] ���� -->
                            <div id="copy" class="banner_image text">
                                AK Lover ��ǰ����
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sub_cont">
        <div class="sub_wrap board_wrap f_sb">
            <div class="left">
                <div class="content_info">
                    <h3>����</h3>
                    <p>
                        ������ ��α׿��� �� �������� ������ �ʰ�<br />
                        Ŭ���� �ٷ� AK Lover Ȩ�������� �̵��� �� �ֵ��� <br />
                        ���� �ٷΰ��� �������Դϴ�.
                    </p>
                    <!-- <div class="btn_round widget_btn">
                        <a>���� ��ġ ��� ����</a>
                    </div> -->
                </div>
            </div>
            <div class="contents right">
                <div class="content f_sb">
                    <div class="con_left">
                        <div class="con_info">
                            <h3>�⺻ ����</h3>
                            <div class="description">AK Lover ȸ�� ������ ��� ������ �����Դϴ�.</div>
                            <ul class="method_banner_list">
                                <li class="flex"><span class="number">1</span>�⺻ ���� �ڵ带 �����Ѵ�.</li>
                                <li class="flex"><span class="number">2</span>
                                    ������ ���� > �ٹ̱� ���� > ���̾ƿ� ���� ���� ><br />
                                    ���� ���� ��� BETA �޴����� ����� �ҽ��ڵ带<br />
                                    Ctrl+V�� �ٿ��ֱ�
                                </li>
                                <li class="flex"><span class="number">3</span>�����ϰ� ���� ��ġ�� ���콺�� �ű��.</li>
                            </ul>
                            <div class="btn_square">
                                <a class="btn_clip2" data-clipboard-text="<a href='http://www.aklover.co.kr/' target='_blank'><img src='https://aklover.co.kr/img/front/intro/basic_widget.webp' width='170' height='170' border='0'></a>">��� �ڵ� �����ϱ� <img src="/img/front/board/copy.webp" alt="ī��" /></a>
                            </div>
                        </div>
                    </div>
                    <div class="con_right">
                        <div class="banner">
                             <!-- [���߿�û] ���� -->
                            <div class="banner_image">
                                <img src="/img/front/intro/basic_widget.webp" alt="�⺻ ����" width="153px"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content f_sb">
                    <div class="con_left">
                        <div class="con_info">
                            <h3>10�ֳ� ����<span class="point">*���� �߼�</span></h3>
                            <div class="description">
                                Ȩ������ ���� 10�� �̻� ȸ���� ��� ������ �����Դϴ�.<br />
                                ����ڿ��� �����ڰ� ������ �ȳ��帮�� �ֽ��ϴ�.
                            </div>
                        </div>
                    </div>
                    <div class="con_right">
                        <div class="banner">
                             <!-- [���߿�û] ���� -->
                            <div class="banner_image">
                                <img src="/img/front/intro/widget_10.png" alt="10�ֳ� ����" width="155px" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- <div id="smart_banner" class="guide_popup popup" style="display: flex; display:none;">
        <div class="inner rel">
            <div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="�ݱ�"></div>
            <div class="pop_content">
                <? include_once BOARD_INC_END.'setting_method.php';?>
            </div>
        </div>	
    </div> -->

</div>
<?
//�������� ��û�� Ȯ���� Ǫ��X
include_once  PATH_INC_END.'tail2.php';
?>

<script>
    // ���� ������ ������ ��� Ŭ������ �����ϱ�
    var clipboard = new Clipboard('.btn_clip');
    clipboard.on('success', function(e) {
        alert("���� �Ǿ����ϴ�. ��α� � �ҽ� �ٿ��ֱ� ���ּ���.");
        console.log(e);
    });

    clipboard.on('error', function(e) {
        console.log(e);
    });

    // �⺻ ���� Ŭ������ �����ϱ�
    var clipboard2 = new Clipboard('.btn_clip2');
    clipboard2.on('success', function(e) {
        alert("���� �Ǿ����ϴ�. ��α� � �ҽ� �ٿ��ֱ� ���ּ���.");
        console.log(e);
    });

    clipboard2.on('error', function(e) {
        console.log(e);
    });

    // ���� �����ϱ�
    function copyClipBoard(id){
        const text = document.getElementById(id);
        let range = document.createRange();
        range.selectNode(text.childNodes[0]);

        window.getSelection().removeAllRanges(); // ���� ���� ����
        window.getSelection().addRange(range); 

        document.execCommand("copy");  // ����  
        window.getSelection().removeRange(range); // ���� ����

        alert("������ ������ ����Ǿ����ϴ�.");
    }

</script>
