<link rel="stylesheet" type="text/css" href="/css/front/cscenter.css" />
<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$view_check = false;
$view_new = false;

if(!strcmp($_SESSION['temp_level'], '')){
    $my_level = '0';
}else{
    $my_level = $_SESSION['temp_level'];
}

if($_GET['view_type'] == "list") $view_check = true;
if($_GET['view'] == "view_new") $view_new = true;

if(!strcmp($my_level,'0') && $view_check){
    msg('�α������ֽñ� �ٶ��ϴ�.','location.href="'.PATH_HOME.'?board=login"');
    exit;
}
$cut_count_name = '6';
$cut_title_name = '34';
$board = 'cus_3';

$gubun_arr = array("1"=>"ü��� ����","2"=>"ü��� �ı����","3"=>"Ȩ������ ����",
    "111"=>"���� ��� ��û", "112"=>"ü�� ��ǰ ���� ��û",
    "121"=>"[���] ��� Ȯ�� ��û", "122"=>"[���] ��ǰ Ȯ�� ��û", "123"=>"[���] ��ǰ ȸ�� ��û", "124"=>"[���] ��ǰ �ļ� �Ű�",
    "131"=>"Ȩ������ �ı� ��� ��� ����", "132"=>"�ı� ��� �Ⱓ ���� ����", "133"=>"�����ı� ����", "134"=>"���̵���� ���� ����", "135"=>"���������/���� ����",
    "141"=>"�����н� ����",
    "151"=>"�г�Ƽ ��",
    "211"=>"�̺�Ʈ ��÷ ����", "212"=>"�̺�Ʈ ��÷ ��ǰ ����",
    "221"=>"[���] ��� Ȯ�� ��û", "222"=>"[���] ��ǰ Ȯ�� ��û", "223"=>"[���] ��ǰ ȸ�� ��û", "224"=>"[���] ��ǰ �ļ� �Ű�","225"=>"[����] ��ǰ ���� �Ű�",
    "311"=>"���� ����/���� ����", "312"=>"��������/�̿��� ����", "313"=>"����ȸ�� �Ű�", "314"=>"��Ÿ ����",
    "4"=>"��Ÿ");

######################################################################################################################################################
if(strcmp($_POST['kewyword'], '')){
    $search = ' and '.$_POST['select'].' like \'%'.$_POST['kewyword'].'%\'';
    $search_next = '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
}else if(strcmp($_GET['kewyword'], '')){
    $search = ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
    $search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
}

if($_GET["gubun"]) {
    $search .= " AND gubun = '".$_GET["gubun"]."' ";
    $search_next .= "&gubun=".$_GET["gubun"];
}

######################################################################################################################################################
$sql = 'select * from board where hero_code=\''.$_SESSION['temp_code'].'\' and hero_table=\''.$board.'\''.$search.' order by hero_notice desc, hero_idx desc;';
sql($sql);
$total_data = @mysql_num_rows($out_sql);
######################################################################################################################################################
$list_page=8;
$page_per_list=10;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board']."&view_type=list".$search_next;
######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);
?>

<div id="subpage" class="cscenter">
    <div class="sub_title">
        <div class="sub_wrap">
            <div class="f_b">
                <h1 class="fz68 fw600 main_c">������</h1>
            </div>
        </div>
    </div>
    <div class="sub_cont inquiry">
        <div class="sub_wrap board_wrap f_sb">
            <div class="left">
                <ul class="sub_menu">
                    <li><a href="/main/index.php?board=group_04_03">�������� <img src="/img/front/icon/bread.webp" alt="�������� �ٷΰ���"></a></li>
                    <li><a href="/main/index.php?board=group_04_33">FAQ <img src="/img/front/icon/bread.webp" alt="FAQ �ٷΰ���"></a></li>
                    <li class="on"><a href="/main/index.php?board=group_04_35&view_type=list">1:1 ���� <img src="/img/front/icon/bread.webp" alt="1:1 ���� �ٷΰ���"></a></li>
                </ul>
                <div class="caution">
                    <h3 class="fz20 fw600">�ȳ�/���ǻ���</h3>
                    <div>
                        <div class="f_fs">
                            <img src="/img/front/icon/caution.webp" alt="�ȳ�/���ǻ���">
                            <p class="fz14">
                                AK Lover Ȱ�� �� ��� ���ؼ��� ���������� Ȯ�����ּ���!<br />
                                �� �� �ñ��Ͻ� ������ FAQ�� Ȯ���ϰų�, 1:1 ���Ǹ� �����ּ���!                            
                            </p>
                        </div>
                        <span class="info">
                            ������ȭ : 080-024-1357 (�����ںδ�)<br>
                            ���ð� : ���� 9��~18�� (��, ��, ���� ������ ����)
                        </span>
                    </div>
                </div>
            </div>
            <!--1:1������ �˾�â-->
            <? if($view_check) { ?>
                <div class="contents right">
                    <div class="cont_top">
                        <h2 class="fz32 fw600">1:1 ����</h2>
                    </div>
                    <table>
                        <colgroup>
                            <col width="120px" />
                            <col width="150px" />
                            <col width="*" />
                            <col width="120px" />
                            <col width="160px" />
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="first">��ȣ</th>
                                <th>ī�װ�</th>
                                <th>����</th>
                                <!--!!!!!!!! [���߿�û] �亯���� ������ ���� �����̶� ���� �ʿ��մϴ�[��] !!!!!!!!  -->
                                <th>�亯����</th>
                                <th class="last">���� ����</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                                $sql = 'SELECT A.*, B.hero_nick AS nick 
                                        FROM board A
                                        LEFT JOIN member B
                                        ON A.hero_code = B.hero_code
                                        WHERE A.hero_code=\''.$_SESSION['temp_code'].'\' AND A.hero_table=\''.$board.'\''.$search.' 
                                        ORDER BY A.hero_idx DESC 
                                        LIMIT '.$start.','.$list_page.';';
                                sql($sql);
                                $i=0;
                                if($total_data > 0) {
                                while($list                             = @mysql_fetch_assoc($out_sql)){
                                $num=$total_data - $start-$i;
                                $i++;
                            ?>
                            <tr<?if(!strcmp($list['hero_notice'], '1')){?> class="notice"<?}?>>
                                <td><?=$num?></td>
                                <td class="color_<?=$list['gubun'];?>"><?=$gubun_arr[$list['gubun']]?></td>
                                <td class="t_l">
                                    <a href="<?=PATH_HOME;?>?board=<?=$_GET['board']?>&page=<?=$page?>&view=view_new&idx=<?=$list['hero_idx'];?>"><?=cut($list['hero_title'], $cut_title_name);?></a> <strong></strong>
                                </td>
                                <!--!!!!!!!! [���߿�û] �亯���� ������ ���� �����̶� ���� �ʿ��մϴ� [��]!!!!!!!!  -->
                                <!--!!!!!!!! �Ϸ�!!!!!!!!  -->
                                <td>
                                    <?if(!$list['hero_10']) {?>
                                        <img src="/img/front/board/no.webp" alt="�亯���">
                                    <?}
                                    else
                                    { ?>
                                        <img src="/img/front/board/yes.webp" alt="�亯�Ϸ�">
                                    <?}?>
                                </td>
                                <td>
                                    <?=date( "Y.m.d", strtotime($list['hero_today']));?><br />
                                    <?=date( "H:i:s", strtotime($list['hero_today']));?>
                                </td>
                            </tr>
                                <?}
                                } else {?>
                                <tr>
                                    <td colspan="5">��ϵ� �����Ͱ� �����ϴ�.</td>
                                </tr>
                            <?}?>
                        </tbody>
                    </table>
                    <div class="admin_btn">
                        <? include_once BOARD_INC_END.'button.php';?>
                    </div>
                </div>
                <!-- </div> -->

            <? } else { ?>

                <? if($view_new) { ?>

                <?
                        $today = date( "Y-m-d", time());
                        ######################################################################################################################################################
                        if(!strcmp($_SESSION['temp_level'], '')){
                            $my_level = '0';
                            $my_write = '0';
                            $my_view = '0';
                            $my_update = '0';
                            $my_rev = '0';
                        }else{
                            $my_level = $_SESSION['temp_level'];
                            $my_write = $_SESSION['temp_write'];
                            $my_view = $_SESSION['temp_view'];
                            $my_update = $_SESSION['temp_update'];
                            $my_rev = $_SESSION['temp_rev'];
                        }
                        ######################################################################################################################################################
                        $cut_title_name = '26';
                        if(!strcmp($_GET['next_board'],"hero")){
                            $hero_table = 'hero';
                        }else{
                            $hero_table = $_GET['board'];
                            if($hero_table == 'group_04_35') {
                                $hero_table = 'cus_3';
                            }
                        }
                        ######################################################################################################################################################
                        $sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
                        sql($sql);
                        $right_list                             = @mysql_fetch_assoc($out_sql);
                        //����
                        //if( ( ($right_list['hero_view'] >= $_SESSION['temp_level']) and (strcmp($_SESSION['temp_level'], '')) ) or (!strcmp($right_list['hero_view'], '99')) ){
                        if($right_list['hero_view'] <= $my_view){
                        ######################################################################################################################################################
                        $temp_id = $_SESSION['temp_id'];
                        $temp_code = $_SESSION['temp_code'];
                        $temp_top_title = $right_list['hero_title'];
                        $temp_title = $out_row['hero_title'];
                        $temp_point = $right_list['hero_view_point'];
                        $temp_idx = $_GET['idx'];

                        ######################################################################################################################################################
                        $sql = 'select a.*,b.hero_nick as nick, b.hero_profile, (select hero_nick from member where hero_code = a.hero_review) review_nick, (select hero_profile from member where hero_code = a.hero_review) review_profile from board a left join member b on a.hero_code = b.hero_code where a.hero_table = \''.$hero_table.'\' and a.hero_idx=\''.$_GET['idx'].'\';';
                        sql($sql, 'on');

                        $out_row = @mysql_fetch_assoc($out_sql);//mysql_fetch_row

                        if(empty($out_row['hero_profile'])){
                            $hero_profile = "/img/front/mypage/defalt.webp";
                        }else {
                            $hero_profile = $out_row['hero_profile'];
                        }

                        if(empty($out_row['review_profile'])){
                            $review_profile = "/img/front/mypage/defalt.webp";
                        }else {
                            $review_profile = $out_row['review_profile'];
                        }

                        $del_use_check = -1; //�亯�� ��������
                        if($out_row["hero_10"]) $del_use_check = 1;

                        if($out_row['hero_code'] != $_SESSION['temp_code']) {
                            msg('������ �۸� Ȯ�� �����մϴ�.','location.href="'.PATH_HOME.'?board=group_04_35&view_type=list"');
                            exit;
                        }

//                        $gubun_arr = array("1"=>"ü��� ����","2"=>"ü��� �ı����","3"=>"Ȩ������ ����",
//                            "111"=>"���� ��� ��û", "112"=>"ü�� ��ǰ ���� ��û",
//                            "121"=>"[���] ��� Ȯ�� ��û", "122"=>"[���] ��ǰ Ȯ�� ��û", "123"=>"[���] ��ǰ ȸ�� ��û", "124"=>"[���] ��ǰ �ļ� �Ű�",
//                            "131"=>"Ȩ������ �ı� ��� ��� ����", "132"=>"�ı� ��� �Ⱓ ���� ����", "133"=>"�����ı� ����", "134"=>"���̵���� ���� ����", "135"=>"���������/���� ����",
//                            "141"=>"�����н� ����",
//                            "151"=>"�г�Ƽ ��",
//                            "211"=>"�̺�Ʈ ��÷ ����", "212"=>"�̺�Ʈ ��÷ ��ǰ ����",
//                            "221"=>"[���] ��� Ȯ�� ��û", "222"=>"[���] ��ǰ Ȯ�� ��û", "223"=>"[���] ��ǰ ȸ�� ��û", "224"=>"[���] ��ǰ �ļ� �Ű�","225"=>"[����] ��ǰ ���� �Ű�",
//                            "311"=>"���� ����/���� ����", "312"=>"��������/�̿��� ����", "313"=>"����ȸ�� �Ű�", "314"=>"��Ÿ ����",
//                            "4"=>"��Ÿ");
                        ?>
                                <div class="contents right">
                                    <div class="cont_top">
                                        <h2 class="fz32 fw600">1:1����</h2>
                                    </div>
                                    <div class="viewbox">
                                        <!-- ���� -->
                                        <div class="t_l fz34 fw600 tit"><!--<?=$out_row['hero_title']?>-->
                                            <?=cut($out_row['hero_title'],48);?>
                                        </div>
                                        <div class="f_b writer">
                                            <div class="f_cs">
                                                <!--!!!!!!!! [���߿�û] ������ ������ �̹��� ����[��]!!!!!!!!  -->
                                                <img src="<?=$hero_profile?>" alt="aklover" class="profile">
                                                <span class="fz16 gray07 nick"><?=$out_row['nick'];?></span>
                                                <span class="fz16 gray07"><?=$gubun_arr[$out_row['gubun']]?></span>
                                            </div>
                                            <div class="op05"><?=date( "Y.m.d h:i:s", strtotime($out_row['hero_today']));?></div>
                                        </div>
                                        <!-- ���� -->
                                        <div class="cont">
                                            <div class="cont_inner textstyle">
                                                <?=htmlspecialchars_decode($out_row['hero_command']);?>
                                            </div>
                                            <!-- ÷������ -->
                                            <?if(strcmp($out_row['hero_board_two'], '')){?>
                                                <div class="file f_cs"><span class="fz18 fw500">÷������</span><a href="<?=FREEBEST_END?>download.php?hero=<?=$out_row['hero_board_one']?>&download=<?=$out_row['hero_board_two']?>" ><?=$out_row['hero_board_two'];?></a></div>
                                            <?}?>
                                        </div>
                                        <!-- �亯 -->
                                        <?if(strcmp($out_row['hero_10'], '')){?>
                                            <div class="replybox">
                                                <div class="cont_tit">
                                                    <!--!!!!!!!! [���߿�û] �亯 ���� ����!!!!!!!!  -->
                                                    <!--!!!!!!!! ������ �����ϴ�.!!!!!!!!  -->
                                                    <div class="t_l fz34 fw600 tit"><!--<?=$out_row['hero_title']?>-->
                                                        Re:"�����Ͻ� ���뿡 ���� �亯�帳�ϴ�."
                                                    </div>
                                                    <div class="f_b writer">
                                                        <div class="f_cs">
                                                            <!--!!!!!!!! [���߿�û] �亯�� ������ �̹��� ����[��]!!!!!!!!  -->
                                                            <img src="<?=$review_profile?>" alt="aklover" class="profile">
                                                            <!--!!!!!!!! [���߿�û] �亯�� �г��� ����[��]!!!!!!!!  -->
                                                            <span class="fz16 gray07 nick"><?=$out_row['review_nick']?></span>
                                                            <span class="fz16 gray07"><?=$gubun_arr[$out_row['gubun']]?></span>
                                                    </div>
                                                        <!--!!!!!!!! [���߿�û] �亯 �ð� ����[��]!!!!!!!!  -->
                                                        <div  class="op05"><?=$out_row['hero_review_day']?></div>
                                                    </div>
                                                </div>
                                                <div class="textstyle">
                                                    <?=nl2br($out_row['hero_10']);?>
                                                </div>
                                            </div>
                                        <?}?>
                                        <?
                                            include_once BOARD_INC_END.'button.php';
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?
                        }else{
                            if(!strcmp($my_level, '0')){
                                $msg = '������';
                                $action_href = PATH_HOME.'?board=login';
                            }else{
                                $msg = '������';
                                $action_href = PATH_HOME.'?'.get('view');
                            }
                            msg($msg.' �����ϴ�.','location.href="'.$action_href.'"');
                            exit;
                        }
                        ?>


                <? } else { ?>

                            <div class="contents right">
                                <!-- ž �����̵� -->
                                <? include_once BOARD_INC_END.'top_slide.php';?>
                                <h1>������</h1>
                                <div class="cs">
                                    <p class="titleBig">
                                        AK LOVER ȸ���е���<br/>
                                        ���� ��Ҹ����� �� ����̰ڽ��ϴ�.
                                    </p>
                                    <div class="description">
                                        AK LOVER Ȱ�� ���� �� ���Ȼ����� 1:1 ���Ǹ� ���� ������ �ֽð�,<br/>
                                        ��ȭ�� ���Ͻô� ���, <em>������(080-024-1357)</em>�� ��ȭ�ֽø� ģ���ϰ� ����� �帮�ڽ��ϴ�.
                                    </div>

                                    <div class="csInfo">
                                        <dl>
                                            <dt>������ȭ</dt>
                                            <dd>080-024-1357 <span>(�����ںδ�)</span></dd>
                                        </dl>
                                        <dl>
                                            <dt>���ð�</dt>
                                            <dd>���� 9��~18�� <span>(��, ��, ���� ������ ����)</span></dd>
                                        </dl>
                                        <div class="btnSection btngroup">
                                            <a href="/main/index.php?board=group_04_35&view_type=list" class="a_btn">1:1����</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?} ?>
            <?} ?>
        </div>
    </div>
</div>