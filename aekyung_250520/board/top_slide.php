<script type="text/javascript" src="/js/musign/board.js"></script>
<script type="text/javascript" src="/js/musign/suppoters.js"></script>
<link rel="stylesheet" type="text/css" href="/css/front/faq.css" />

<div class="slide_top cont_top f_sb">
    <? if($_GET["board"] == "group_04_03") { ?>
        <h2 class="fz32 fw600">��������</h2>
        <a href="/main/index.php?board=group_04_35&view_type=list" class="fz17 fw600">1:1 ���� �ϱ�</a>
        <!-- <a href="/main/index.php?board=group_04_03&page=1&view=view&idx=443487" class="fz17 fw600">1:1 ���� �ϱ�</a> -->
    <? } else if($_GET["board"] == "group_04_33") { ?>
        <h2 class="fz32 fw600">FAQ</h2>
        <a href="/main/index.php?board=group_04_35&view_type=list" class="fz17 fw600">1:1 ���� �ϱ�</a>
        <!-- <a href="/main/index.php?board=group_04_03&page=1&view=view&idx=443487" class="fz17 fw600">1:1 ���� �ϱ�</a> -->
    <? } else { ?>
        <h2 class="fz32 fw600">1:1 ����</h2>
    <? } ?>
</div>
<div class="best_qna">
    <p class="fz20 fw600" style="margin-bottom: 1rem;">TOP 5 ����</p>
    <div class="swiper-container best_qna_slide">
        <div class="swiper-wrapper">
            <div class="swiper-slide faq_btn_1">
                <div class="f_cs">
                    <!--!!!!!!!! [���߿�û] ������ ������ ���� !!!!!!!!  -->
                    <img src="/img/front/board/faq01.png"alt="������" class="icon">
                    <div class="quest" style="width: 80%;">
                        <span>FAQ 1.</span>
                        <p class="fz20 fw600 ellipsis_100">
                            AK Lover�� �Ƿ��� ��� �ؾ� �ϳ���? <img src="/img/front/main/tab_arr_right_w.webp" alt="���� ����" class="arr">
                        </p>
                    </div>
                </div>
            </div>
            <div class="swiper-slide faq_btn_2">
                <div class="f_cs">
                    <img src="/img/front/board/faq02.png"alt="������" class="icon">
                    <div class="quest" style="width: 80%;">
                        <span>FAQ 2.</span>
                        <p class="fz20 fw600 ellipsis_100">
                            ü��ܿ� �����ϰ� ������ ��� �ؾ� �ϳ���? <img src="/img/front/main/tab_arr_right_w.webp" alt="���� ����" class="arr">
                        </p>
                    </div>
                </div>
            </div>
            <div class="swiper-slide faq_btn_3">
                <div class="f_cs">
                    <img src="/img/front/board/faq01.png"alt="������" class="icon">
                    <div class="quest" style="width: 80%;">
                        <span>FAQ 3.</span>
                        <p class="fz20 fw600 ellipsis_100">
                            ü��� ���̵������ �ٿ�ް� �;��! <img src="/img/front/main/tab_arr_right_w.webp" alt="���� ����" class="arr">
                        </p>
                    </div>
                </div>
            </div>
            <div class="swiper-slide faq_btn_4">
                <div class="f_cs">
                    <img src="/img/front/board/faq02.png"alt="������" class="icon">
                    <div class="quest" style="width: 80%;">
                        <span>FAQ 4.</span>
                        <p class="fz20 fw600 ellipsis_100">
                            ����Ʈ �佺Ƽ���̶� �����ΰ���? <img src="/img/front/main/tab_arr_right_w.webp" alt="���� ����" class="arr">
                        </p>
                    </div>
                </div>
            </div>
            <div class="swiper-slide faq_btn_5">
                <div class="f_cs">
                    <img src="/img/front/board/faq01.png"alt="������" class="icon">
                    <div class="quest" style="width: 80%;">
                        <span>FAQ 5.</span>
                        <p class="fz20 fw600 ellipsis_100">
                            �����н��� �����ΰ���? <img src="/img/front/main/tab_arr_right_w.webp" alt="���� ����" class="arr">
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="rel swbtn_wrap">
            <div class="swbtn swiper-button-prev"></div>
            <div class="swbtn swiper-button-next"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>

<!-- FAQ �˾� ���� -->
<div id="faq_popup_1" class="guide_popup faq_popups" style="display: none;">
    <div class="inner rel">
        <div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="�ݱ�"></div>
        <div class="faq_popup_con t_c">
            <div class="q_num">FAQ1</div>
            <div class="faq_qes">AK Lover�� �Ƿ��� ��� �ؾ� �ϳ���?</div>
            <div class="faq_ans">
                AK Lover Ȩ������ ���� �� SNS ������ 1�� �̻� �������ֽø�<br /> AK Lover ������ ��Ƽ&������ Ŭ������ Ȱ���� �����Ͻʴϴ�.<br />
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
                ���Ͻô� ü��� ��ʸ� Ŭ���Ͻ� �� ������� ������ �����Ͻø� �˴ϴ�.<br />
                ��÷ ���δ� Ȩ������ ���� ��� ������ Ŭ�� ��<br /> [����������] - [���� ü���] - [������ ü���]���� Ȯ�� �����մϴ�.<br />
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
                ü��ܿ� �����ǽø�, Ȩ������ ������� ������ Ŭ�� ��<br />
                [����������] - [���� ü���] - [������ ü���]���� ������ ü����� Ȯ���Ͻ� �� �ֽ��ϴ�.<br />
                �׸��� ������ ü����� Ŭ���Ͻø� ����<br /> [���̵���� Ȯ���ϱ�]�� ���� ���̵������ �ٿ�ε� ���� �� �ֽ��ϴ�.

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
                AK Lover Ȱ������ ������ ����Ʈ��<br /> �ְ��� �پ��� �α� ��ǰ�� ���� ���� �� ��ȯ�� �� �ִ� �̺�Ʈ�Դϴ�<br />
                �� 2ȸ(��ݱ�/�Ϲݱ�) ����Ǹ�, �佺Ƽ�� ������ ��¦ �����˴ϴ�. ���� ��� ��Ź�帳�ϴ�.<br />
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
                �����н��� ���ϴ� ��ǰ ü��ܿ� �켱������ ���� ������ Ƽ������ ���� ���ؿ� ����<br /> �ſ� ù ��° �α��� �� �ο��Ǹ�, �ſ� �������� �Ҹ�˴ϴ�.
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        const faqBtn = $('.best_qna .swiper-slide'),
              faqPop = $('.faq_popups');
        // faq �˾�
        $.each(faqBtn, function(){
            $(this).click(function(e){
                e.preventDefault();
                const thisIdx = $(this).attr('data-swiper-slide-index');
                faqPop.eq(thisIdx).show();
            });
        });
        $('.faq_popups .btn_x').click(function(){
            faqPop.hide();
        });
    });
</script>