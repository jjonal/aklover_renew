<?
$board 			=	$_GET['board'];
$gubun_arr = array("1"=>"�ϻ�","2"=>"ü���","3"=>"����");
$cut_count_name = 	'6';				//�ִ� �̸� ���ڼ�
$cut_title_name = 	'120';				//�ִ� ���� ���ڼ�

if($board == "group_02_02") { //�޴��� ����
    $sql_notice = " SELECT hero_idx, hero_title, gubun, hero_nick, hero_today, hero_03, hero_keywords, hero_use FROM board ";
    $sql_notice .= " WHERE hero_notice_use = 1 AND hero_table='" . $_GET['board'] . "' " . $hero_use . " ORDER BY hero_idx DESC ";
    $sql_notice_res = mysql_query($sql_notice);
}
?>

<script type="text/javascript" src="/js/musign/board.js"></script>
<div class="slide_top cont_top lover_top">   
    <div class="caution">
        <h3 class="fz28 fw600 conttop_tit">�ȳ�/���ǻ���</h3>
        <div>
            <div class="">
                <div class="f_fs">
                    <img src="/img/front/icon/caution.webp" alt="�ȳ�/���ǻ���">
                    <div>
                        <p class="fz24">
                            AK Lover ȸ���е��� ������ �ǰ߰� �������� �� �ϻ� �̾߱⸦ �����Ӱ� ������ �����Դϴ�.
                            ���θ� ����ϰ� �����ϴ� Lover �е��� ���� ��Ź�帳�ϴ�.                    
                        </p>
                        <p class="fz24">
                            - ����/��ġ ���� ��/��� ����<br />
                            - �������̰� ���Ǿ���(5�� �̳�) ��/��� ���� ����<br />
                            - ������ ������� ��� ����<br />
                            - �弳, ���� �� Ÿ�ο��� ���ظ� �ִ� ��/��� ����
                        </p>                    
                        <p class="fz24 main_c">
                            ��Lover�� ���ǻ����� ���ؼ� �Ͻô� ���, ���뺸 ���� �Ǵ�
                            ������(����Ʈ ������, ���� Ż�� ��)�� ���� �� ������ �ݵ�� ���ǻ����� �ؼ����ּ���.
                        </p>
                    </div>
                </div>
            </div>      
        </div>
    </div>
</div>
<div class="best_qna">    
    <div class="swiper-container best_qna_slide">
        <div class="swiper-wrapper">
            <?if($board == "group_02_02") {
                while($hero_notice_list = mysql_fetch_assoc($sql_notice_res)){ ?>
                    <div class="swiper-slide">
                        <div>
                            <a href="https://www.aklover.co.kr/m/today_view.php?board=group_04_03&statusSearch=&hero_idx=439908&hero_gisu=&select=hero_title&kewyword=&date-from=2024.07.11&date-to=2024-07.11" class="f_cs">
                                <!--!!!!!!!! [���߿�û] ������ ������ ���� �ʿ� !!!!!!!!  -->
                                <img src="/img/front/board/faq01.png"alt="������" class="icon">
                                <div class="quest">
                                    <!-- <span><?=$gubun_arr[$hero_notice_list['gubun']]?></span> -->
                                    <span>�ʵ�</span>
                                    <p class="fz22 fw600 ellipsis_1line">
                                        AK Lover �ű� Ȩ������ ���� ���� �ȳ�(24.07.11)
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div>
                            <a href="https://www.aklover.co.kr/m/today_view.php?board=group_04_03&statusSearch=&hero_idx=431253&hero_gisu=&select=hero_title&kewyword=&date-from=2024.07.11&date-to=2024-07.11" class="f_cs">
                                <!--!!!!!!!! [���߿�û] ������ ������ ���� �ʿ� !!!!!!!!  -->
                                <img src="/img/front/board/faq01.png"alt="������" class="icon">
                                <div class="quest">
                                    <!-- <span><?=$gubun_arr[$hero_notice_list['gubun']]?></span> -->
                                    <span>�ʵ�</span>
                                    <p class="fz22 fw600 ellipsis_1line">
                                        2024�� AK Lover � ������� �ȳ�
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                <? }
            }?>
        </div>                                    
        <div class="swiper-pagination"></div>
    </div>
</div>
<div class="page_tit">
    <p class="fz44 fw600">Lover ��</p> 
</div>
<!-- �˾�â ���� �þ� ����� -->
<table class="dis-no">
    <tr class="answer">
        <td valign="top" ><img src="../image/bbs/icon_a.png" alt="�亯" class="mt10" /></td>
        <td colspan="2" class="tl">
            <div>AK Lover Ȩ������ ���԰� ���ÿ� AK Lover�� Ȱ���� �����Ͻø�, Ȱ�� �ӱ� ���� ���������� Ȱ�� �����մϴ�.</div>
        </td>
    </tr>

    <tr class="answer">
        <td valign="top" ><img src="../image/bbs/icon_a.png" alt="�亯" class="mt10" /></td>
        <td colspan="2" class="tl">
            <div>������ ��� - [����������] - [ȸ������ ����]���� �����մϴ�.</div>
        </td>
    </tr>

    <tr class="answer">
        <td valign="top" ><img src="../image/bbs/icon_a.png" alt="�亯" class="mt10" /></td>
        <td colspan="2" class="tl">
            <div>�����н��� ���ϴ� ��ǰ ü��ܿ� �켱������ ���� ������ Ƽ������ ���� ���ؿ� ���� �� �� ù ��° �α��� �� �ο��Ǹ�, �ſ� �������� �Ҹ�˴ϴ�.</div>
        </td>
    </tr>

    <tr class="q" style="background: #f5f5f5;">
        <td><img src="../image/bbs/icon_q.png" alt="����" /></td>
        <td class="tl"><a href="#"></a></td>
        <td></td>
    </tr>
    <tr class="answer">
        <td valign="top" ><img src="../image/bbs/icon_a.png" alt="�亯" class="mt10" /></td>
        <td colspan="2" class="tl">
            <div>ü��ܿ� �����ǽø�, �Ʒ� ��η� ���̵������ �ٿ� �޾ƺ��� �� �ֽ��ϴ�. <br/>ü��� - [������ ���̵�] - [���̵���� �ٿ�ε�]</div>
        </td>
    </tr>                        
    <tr class="q" style="background: #f5f5f5;">
        <td><img src="../image/bbs/icon_q.png" alt="����" /></td>
        <td class="tl"><a href="#"></a></td>
        <td></td>
    </tr>
    <tr class="answer">
        <td valign="top" ><img src="../image/bbs/icon_a.png" alt="�亯" class="mt10" /></td>
        <td colspan="2" class="tl">
            <div>�ְ� �������� AK LOVER Ȱ���� ���� ������ ����Ʈ�� �ְ� ��ǰ�� ��ȯ �� �� �ִ� �����Դϴ�. ����Ʈ ������ �Ը��� ������ �ҽÿ� ����� �����Դϴ�. ���� ��� ��Ź�帳�ϴ�.</div>
        </td>
    </tr>
    <!-- �ʵ� ���� �� -->
</table>