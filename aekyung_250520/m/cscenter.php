<script type="text/javascript" src="/js/musign/board.js"></script>
<link rel="stylesheet" type="text/css" href="/m/css/musign/faq.css" />

<div class="slide_top cont_top">
    <ul class="f_cs">
        <li class="<? if($_GET["board"] == "group_04_03") { ?>on<? } ?>">
            <a href="/m/today.php?board=group_04_03">��������</a>
        </li>
        <li class="<? if($_GET["board"] == "cus_2") { ?>on<? } ?>">
            <a href="/m/faq.php?board=cus_2">FAQ</a>
        </li>
        <li class="<? if($_GET["board"] == "cus_3" || $_GET["board"] == "mail"|| $_GET["board"] == "group_02_02" ) { ?>on<? } ?>">
            <a href="/m/customer.php?board=cus_3&view_type=list">1:1 ����</a>
        </li>
    </ul>
    <div class="caution">
        <h3 class="fz28 fw600 conttop_tit">�ȳ�/���ǻ���</h3>
        <div>
            <div class="">
                <? if($_GET["board"] == "group_04_03") { ?>
                    <div class="f_fs">
                        <img src="/img/front/icon/caution.webp" alt="�ȳ�/���ǻ���">
                        <p class="fz24">
                            AK Lover Ȱ�� �� ��� ���ؼ��� ���������� Ȯ�����ּ���!<br />
                            �� �� �ñ��Ͻ� ������ FAQ�� Ȯ���ϰų�, 1:1 ���Ǹ� �����ּ���!                            
                        </p>
                    </div>
                <? } else if($_GET["board"] == "cus_2") { ?>
                    <div class="f_fs">
                        <img src="/img/front/icon/caution.webp" alt="�ȳ�/���ǻ���">
                        <p class="fz24">
                            AK Lover Ȱ�� �� ��� ���ؼ��� ���������� Ȯ�����ּ���!<br />
                            �� �� �ñ��Ͻ� ������ FAQ�� Ȯ���ϰų�, 1:1 ���Ǹ� �����ּ���!                            
                        </p>
                    </div>
                    <span class="fz24 info">
                        ������ȭ : 080-024-1357 (�����ںδ�)<br>
                        ���ð� : ���� 9��~18�� (��, ��, ���� ������ ����)
                    </span>
                <? } else { ?>
                    <div class="f_fs">
                        <img src="/img/front/icon/caution.webp" alt="�ȳ�/���ǻ���">
                        <p class="fz24">
                            AK Lover Ȱ�� �� ��� ���ؼ��� ���������� Ȯ�����ּ���!<br />
                            �� �� �ñ��Ͻ� ������ FAQ�� Ȯ���ϰų�, 1:1 ���Ǹ� �����ּ���!                            
                        </p>
                    </div>
                        <span class="fz24 info">
                            ������ȭ : 080-024-1357 (�����ںδ�)<br>
                            ���ð� : ���� 9��~18�� (��, ��, ���� ������ ����)
                        </span>
                <? } ?>

            </div>
        </div>
    </div>
</div>
<div class="best_qna">
    <h3 class="fz28 fw600 conttop_tit">TOP5 ����</h3>
    <div class="swiper-container best_qna_slide">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="f_cs">
                    <img src="/img/front/board/faq01.png"alt="������" class="icon">
                    <div class="quest">
                        <span>FAQ 1.</span>
                        <p class="fz20 fw600">
                            AK Lover�� �Ƿ��� ��� �ؾ� �ϳ���? <img src="/img/front/main/tab_arr_right_w.webp" alt="���� ����" class="arr">
                        </p>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="f_cs">
                    <img src="/img/front/board/faq02.png"alt="������" class="icon">
                    <div class="quest">
                        <span>FAQ 2.</span>
                        <p class="fz20 fw600">
                        ü��ܿ� �����ϰ� ������ ��� �ؾ� �ϳ���? <img src="/img/front/main/tab_arr_right_w.webp" alt="���� ����" class="arr">
                        </p>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="f_cs">
                    <img src="/img/front/board/faq01.png"alt="������" class="icon">
                    <div class="quest">
                        <span>FAQ 3.</span>
                        <p class="fz20 fw600">
                        ü��� ���̵������ �ٿ�ް� �;��! <img src="/img/front/main/tab_arr_right_w.webp" alt="���� ����" class="arr">
                        </p>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="f_cs">
                    <img src="/img/front/board/faq02.png"alt="������" class="icon">
                    <div class="quest">
                        <span>FAQ 4.</span>
                        <p class="fz20 fw600">
                            ����Ʈ �佺Ƽ���̶� �����ΰ���? <img src="/img/front/main/tab_arr_right_w.webp" alt="���� ����" class="arr">
                        </p>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="f_cs">
                    <img src="/img/front/board/faq01.png"alt="������" class="icon">
                    <div class="quest">
                        <span>FAQ 5.</span>
                        <p class="fz20 fw600">
                            �����н��� �����ΰ���? <img src="/img/front/main/tab_arr_right_w.webp" alt="���� ����" class="arr">
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>
<div class="page_tit">
    <? if($_GET["board"] == "group_04_03") { ?>
        <p class="fz44 fw600">��������</p>
    <? } else if($_GET["board"] == "cus_2") { ?>
        <p class="fz44 fw600">FAQ</p>
    <? } else { ?>
        <p class="fz44 fw600">1:1 ����</p>
    <? } ?>
</div>
<!-- FAQ �˾� ���� -->
<div id="faq_popup_1" class="guide_popup faq_popups" style="display: none;">
    <div class="inner rel">
        <div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="�ݱ�"></div>
        <div class="faq_popup_con t_c">
            <div class="q_num">FAQ1</div>
            <div class="faq_qes">AK Lover�� �Ƿ��� ��� �ؾ� �ϳ���?</div>
            <div class="faq_ans">
                AK Lover Ȩ������ ���� �� SNS ������ 1�� �̻� �������ֽø� AK Lover ������ ��Ƽ&������ Ŭ������ Ȱ���� �����Ͻʴϴ�.
                ���� ���ѵ� �ӱ� ���� ���������� Ȱ���� �����մϴ�.
            </div>
        </div>
    </div>
</div>

<div id="faq_popup_2" class="guide_popup faq_popups" style="display: none;">
    <div class="inner rel">
        <div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="�ݱ�"></div>
        <div class="faq_popup_con t_c">
            <div class="q_num">FAQ2</div>
            <div class="faq_qes">ü��ܿ� �����ϰ� ������ ��� �ؾ� �ϳ���?</div>
            <div class="faq_ans">
                ���Ͻô� ü��� ��ʸ� Ŭ���Ͻ� �� ������� ������ �����Ͻø� �˴ϴ�.
                ��÷ ���δ� Ȩ������ ���� ��� ������ Ŭ�� �� [����������] - [���� ü���] - [������ ü���]���� Ȯ�� �����մϴ�.
                �ڼ��� ������ �̿�鼭 ������������ �����ϼ���.
            </div>
        </div>
    </div>
</div>

<div id="faq_popup_3" class="guide_popup faq_popups" style="display: none;">
    <div class="inner rel">
        <div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="�ݱ�"></div>
        <div class="faq_popup_con t_c">
            <div class="q_num">FAQ3</div>
            <div class="faq_qes">ü��� ���̵������ �ٿ�ް� �;��!</div>
            <div class="faq_ans">
                ü��ܿ� �����ǽø�, Ȩ������ ������� ������ Ŭ�� ��
                [����������] - [���� ü���] - [������ ü���]���� ������ ü����� Ȯ���Ͻ� �� �ֽ��ϴ�.
                �׸��� ������ ü����� Ŭ���Ͻø� ����
                [���̵���� Ȯ���ϱ�]�� ���� ���̵������ �ٿ�ε� ���� �� �ֽ��ϴ�.
            </div>
        </div>
    </div>
</div>

<div id="faq_popup_4" class="guide_popup faq_popups" style="display: none;">
    <div class="inner rel">
        <div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="�ݱ�"></div>
        <div class="faq_popup_con t_c">
            <div class="q_num">FAQ4</div>
            <div class="faq_qes">����Ʈ �佺Ƽ���̶� �����ΰ���?</div>
            <div class="faq_ans">
                AK Lover Ȱ������ ������ ����Ʈ��
                �ְ��� �پ��� �α� ��ǰ�� ���� ���� �� ��ȯ�� �� �ִ� �̺�Ʈ�Դϴ�
                �� 2ȸ(��ݱ�/�Ϲݱ�) ����Ǹ�, �佺Ƽ�� ������ ��¦ �����˴ϴ�. ���� ��� ��Ź�帳�ϴ�.
                (��ݱ� : �̴��� AK Lover �� �����̾� ��� / �Ϲݱ� : ��ü ȸ�� ���)
            </div>
        </div>
    </div>
</div>

<div id="faq_popup_5" class="guide_popup faq_popups" style="display: none;">
    <div class="inner rel">
        <div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="�ݱ�"></div>
        <div class="faq_popup_con t_c">
            <div class="q_num">FAQ5</div>
            <div class="faq_qes">�����н��� �����ΰ���?</div>
            <div class="faq_ans">
                �����н��� ���ϴ� ��ǰ ü��ܿ� �켱������ ���� ������ Ƽ������ ���� ���ؿ� ����
                �ſ� ù ��° �α��� �� �ο��Ǹ�, �ſ� �������� �Ҹ�˴ϴ�.
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        const faqBtn = $('.best_qna .swiper-slide'), faqPop = $('.faq_popups');
            $.each(faqBtn, function(){
                $(this).click(function(e){
                    e.preventDefault();
                    const thisIdx = $(this).attr('data-swiper-slide-index');
                    faqPop.eq(thisIdx).show();
                })
            })
            $('.faq_popups .btn_x').click(function(){
            faqPop.hide();
        });
    });
</script>