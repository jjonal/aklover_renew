<?
######################################################################################################################################################
#ȸ�� ����
$sql = "SELECT a.hero_oldday, b.hero_name, a.hero_nick, a.hero_profile, a.hero_blog_00, a.hero_blog_03, a.hero_blog_04, a.hero_level FROM member a, level b WHERE a.hero_level = b.hero_level and hero_code ='".$_SESSION['temp_code']."'";
sql($sql);
$member = @mysql_fetch_assoc($out_sql);
$hero_nick = $member['hero_nick'];
$level = $member['hero_level'];
if(empty($member['hero_profile'])){
    $hero_profile = "/img/front/mypage/defalt.webp";
}else {
    $hero_profile = $member['hero_profile'];
}
#ȸ�����
$hero_level = "";
$hero_icon = "";
if ($level == "9996"){
    $hero_level = "�����̾� ��Ƽ";
    $hero_icon = '<img src="/img/front/icon/my_icon_beauty.png" style="width: 1.3rem;" alt="�����̾� ��Ƽ ���">';
}else if ($level == "9994"){
    $hero_level = "�����̾� ������";
    $hero_icon = '<img src="/img/front/icon/my_icon_life.png" style="width: 1.3rem;" alt="�����̾� ������ ���">';
}else {
    $hero_level = "������ ��������";
    $hero_icon = '<img src="/img/front/icon/my_icon.png" style="width: 2.5rem;" alt="������ ���">';
}
######################################################################################################################################################
#��������Ʈ
$user_total_sql = "select total_user_point, total_use_point, C.superpass_use, D.superpass_sum from ";
$user_total_sql .= "(select hero_code, sum(hero_point) as total_user_point from point where hero_code='".$_SESSION['temp_code']."') as A, ";
$user_total_sql .= "(select SUM(hero_order_point) as total_use_point from order_main where hero_code='".$_SESSION['temp_code']."' and hero_process!='".$_PROCESS_CANCEL."') as B, ";
$user_total_sql .= "(select count(*) as superpass_use from mission_review where hero_superpass='Y' and hero_code='".$_SESSION['temp_code']."' and hero_today <= '".date("Y-m-t")."' and hero_today >= '".date("Y-m-01")."') as C, ";
$user_total_sql .= "(select count(*) as superpass_sum from superpass where hero_code='".$_SESSION['temp_code']."' and hero_use_yn = 'N' and hero_endday > date_format(now(),'%Y-%m-%d 00:00:00')) as D"; //12��7�� ����

$out_user_total_sql = @mysql_query($user_total_sql);
$today_total_list   = @mysql_fetch_assoc($out_user_total_sql);
$today_total = $today_total_list['total_user_point'];
if($today_total=='') $today_total = 0;
$today_use_total = $today_total_list['total_user_point']-$today_total_list['total_use_point'];
######################################################################################################################################################
#������ �˸�
$sql = 'select * from mail where hero_table=\''.$_GET['board'].'\' and ((hero_user=\'all\' and hero_today > \''.$member['hero_oldday'].'\') or CONCAT(\'||\', hero_user, \'||\') LIKE \'%||'.$_SESSION['temp_id'].'||%\') and IFNULL(hero_user_check,\'\') = \'\' order by hero_today desc;';
sql($sql);
$noReadMail = @mysql_num_rows($out_sql);
######################################################################################################################################################
#�⼮üũ Ȯ��
$regdate = date("Y-m-d"); //����� �ð�

$attend_sql = 'select max(hero_today) hero_today from point where hero_type = \'attendance\' and hero_code = \''.$_SESSION['temp_code'].'\' ';
$out_attend_sql = mysql_query($attend_sql);
$attend_list                             = @mysql_fetch_assoc($out_attend_sql);
######################################################################################################################################################
?>

<link href="/m/css/musign/mypage.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/m/js/musign/mypage.js"></script>
<div class="my_info_wrap">
    <div class="my_info">
        <div class="my_profile f_cs">
            <!-- [����] ������ �̹��� ����, �̹��� �̸������ mypage.js�� �۾��صξ����ϴ� -->
            <a href="/m/infoauth.php?board=infoauth"  class="profile_img rel">
                <!-- class="upload"><img src="/img/front/mypage/upload.webp" alt="������ ���ε�"></a> -->
                <div class="image-preview"><img src="<?=$hero_profile?>" alt="������"></div>
            </a>
            <div class="my_support_wrap">
                <div class="my_support">
                    <ul class="f_c">
                        <li class="f_c">
                            <!-- ��� ������ s -->
                            <!-- ������Ŭ���� ��� -->
<!--                            <img src="/img/front/icon/my_icon.png" style="width: 2.2rem;" alt="������ ���">-->
                            <!-- �����̾� �������� ��� -->
<!--                            <img src="/img/front/icon/my_icon_life.png" style="width: 1.1rem;" alt="�����̾� ������ ���">-->
                            <!-- �����̾� ��Ƽ�� ��� -->
<!--                            <img src="/img/front/icon/my_icon_beauty.png" style="width: 1.1rem;" alt="�����̾� ��Ƽ ���">-->
                            <!-- e -->
                            <?=$hero_icon?>
                            <?=$hero_level?>
                        </li>
                    </ul>
                </div>
                <div class="my_id">
                    <p><span class="fz32 fw600"><?=$_SESSION['temp_nick']?></span> ����</p>
                    <p><span class="fz32 fw600"><?=$hero_level?></span> �Դϴ�.</p>
                </div>
            </div>
        </div>
        <div class="">
            <div class="more_view btn_more">�� ����<img src="/m/img/musign/main/menu_dw.webp" alt="������"></div>
            <div class="card_bx">
                <ul>
                    <li>
                        <p>
                            <img src="/img/front/mypage/my_point.webp" alt="������" class="card_icon">���� ����Ʈ
                        </p>
    
                            <!-- today_use_total ����mypoint.php �� �ֽ��ϴ�!! -->
                        <a href="/m/mypoint.php?board=mypoint" class="point">
                            <span><?=number_format($today_use_total)?> ����Ʈ</span>
                            <img src="/img/front/main/tab_arr_right.webp" alt="�ٷΰ���">
                        </a>
                    </li>
                    <li>
                        <p><img src="/img/front/mypage/my_check.webp" alt="������" class="card_icon">�⼮üũ</p>
                        <?
                        if(strpos($attend_list['hero_today'] , $regdate)!==false){
                            echo '<a href="/m/check.php?board=group_04_04">�Ϸ�<img src="/img/front/main/tab_arr_right.webp" alt="�ٷΰ���" style="margin-left: .5rem;"></a>';
                            // echo '<a href="/m/today_view.php?board=group_04_03&statusSearch=&hero_idx=443487&hero_gisu=&select=hero_title&kewyword=&date-from=2024.08.29&date-to=2024-08.29">�Ϸ�<img src="/img/front/main/tab_arr_right.webp" alt="�ٷΰ���" style="margin-left: .5rem;"></a>';
                        } else {
                            echo '<a href="/m/check.php?board=group_04_04">�̿Ϸ�<img src="/img/front/main/tab_arr_right.webp" alt="�ٷΰ���" style="margin-left: .5rem;"></a>';
                            // echo '<a href="/m/today_view.php?board=group_04_03&statusSearch=&hero_idx=443487&hero_gisu=&select=hero_title&kewyword=&date-from=2024.08.29&date-to=2024-08.29">�̿Ϸ�<img src="/img/front/main/tab_arr_right.webp" alt="�ٷΰ���" style="margin-left: .5rem;"></a>';
                        }
                        ?>
                    </li>
                    <li>
                        <p>
                        <img src="/img/front/mypage/my_alram.webp" alt="������" class="card_icon">�˸�
                        </p>
                        <a href="/m/today.php?board=mail"><span><?=$noReadMail?>��</span>
                        <img src="/img/front/main/tab_arr_right.webp" alt="�ٷΰ���" style="margin-left: .5rem;">
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card_bx sns_card">
                <ul>
                    <li>
                        <p><img src="/img/front/mypage/my_naver.webp" alt="������" class="card_icon"></p>
                        <!-- �������� �ȵǾ� ���� ��� p tag class "none_sns" -->
                        <a href="/m/infoauth.php?board=infoauth" class="<?=$member['hero_blog_00'] ==  '' ? 'none_sns' : ''?>">
                            <span>
                                ���̹� ��α� ������ ������ �ּ���.
                            </span>
                            <img src="/img/front/main/tab_arr_right.webp" alt="�ٷΰ���" style="margin-left: .5rem;">
                        </a>
                    </li>
                    <li>
                        <p><img src="/img/front/mypage/my_insta.webp" alt="������" class="card_icon"></p>
                        <a href="/m/infoauth.php?board=infoauth" class="<?=$member['hero_blog_04'] ==  '' ? 'none_sns' : ''?>">
                            <span>
                                �ν�Ÿ�׷� ������ ������ �ּ���.
                            </span>
                            <img src="/img/front/main/tab_arr_right.webp" alt="�ٷΰ���" style="margin-left: .5rem;">
                        </a>
                    </li>
                    <!-- [����] ���� ����� ��� ���̵� ���� -->
                    <li>
                        <p><img src="/img/front/mypage/my_youtube.webp" alt="������" class="card_icon"></p>
                        <a href="/m/infoauth.php?board=infoauth" class="<?=$member['hero_blog_03'] ==  '' ? 'none_sns' : ''?>">
                            <span>
                                ��Ʃ�� ������ ������ �ּ���.
                            </span>
                            <img src="/img/front/main/tab_arr_right.webp" alt="�ٷΰ���" style="margin-left: .5rem;">
                        </a>
                    </li>
                </ul>
            </div>
            <div class="more_view btn_no">����<img src="/m/img/musign/main/menu_dw.webp" alt="������"></div>
        </div>
    </div>
    <div class="rel">
        <div class="rel superbanner f_cs open_pop">
            <img src="/m/img/musign/mypage/icon_super.png" alt="�����н�">
            <p class="fz18 en c_white">SUPER PASS</p>
            <span class="">�����н���?</span>
            <div class="super_info">
                <!-- superpass_ea ����mypoint.php �� �ֽ��ϴ�!! ���� ���������� �����ؼ� �׳� �ξ����ϴ�;;; -->
                <? if($superpass_ea>0){ ?>
                    <img src="/img/front/mypage/use.png" alt="��� ����">
                <? }else{?>
                    <img src="/img/front/mypage/unuse.png" alt="��� �Ұ���">
                <? }?>
            </div>
        </div>
    </div>

</div>
<!-- superpass popup -->
<? include_once BOARD_INC_END.'superpass.php';?>