<?
######################################################################################################################################################
######################################################################################################################################################
##���� ����
######################################################################################################################################################
######################################################################################################################################################
//function ����ϱ� ���� ��� ����

define(_HEROBOARD_, '_HEROBOARD_');
include '../../freebest/hero.php';
include  '../../freebest/function.php';
include '../../freebest/head.php';

$my_view 	=	$_SESSION ['temp_view'] == '' ? '0' : $_SESSION ['temp_view'];
$auth_check = "A.hero_use = 1 AND ";
if($my_view >= 9999) {
    $auth_check = "";
}
$list_page = 15;
$page_per_list = 9;


$page = $_GET['page'];
if(!$page) {
    $page = 1;
}
if(!is_numeric($_GET['page']))	$page = '1';
else							$page = $_GET['page'];
$start = ($page-1)*$list_page;



$sql = "select count(*) from board as A, member as B where  A.hero_code=B.hero_code and (A.hero_table='group_02_03' or A.hero_03='group_02_03')";
$error = "THUMBNAIL_03_LIST_01";
$count_res = new_sql($sql,$error,"on");
if((string)$count_res==$error){
    error_historyBack("");
    exit;
}

$total_data = mysql_result($count_res,0,0);

?>

<div id="subpage">
    <div class="sub_title">
        <div class="sub_wrap">
            <div class="f_b">
                <h1 class="fz68 main_c fw500 ko">�̴��� �̺�Ʈ</h1>
                <ul class="tab f_c">

                    <!--!!!!!!!! [���߿�û] ������ �Բ� ����Ǿ��� �̺�Ʈ ����Ʈ���� ��÷�� ��ǥ����Ʈ�� ������ ������ �մϴ� �۾��� �ʿ��� ����Ʈ �۾���û�ּ��� !!!!!!!!  -->
                    <li><a href="" class="fz18 fw600">�̺�Ʈ ����Ʈ</a></li>
                    <li><a href="" class="fz18 fw600">��÷�� ��ǥ</a></li>
                </ul>
            </div>
            <p class="fz18 fw600">������ ���� ������ �̺�Ʈ�� �����غ�����!</p>
        </div>
    </div>
    <div class="sub_cont">
        <div class="sub_wrap board_wrap f_sb">
            <div class="left">
                <? include_once BOARD_INC_END.'search.php';?>
            </div>
            <div class="contents right">

                <!-- <? include_once("{$_SERVER[DOCUMENT_ROOT]}/include/listHeadTitle.php") ?> -->

                <!-- �̺�Ʈ ����Ʈ -->

                <!-- ��÷�� ��ǥ -->
                <div class="guerrilla_event grid_3">
                    <?
                    $error = "THUMBNAIL_03_LIST_03";
                    $sql = "select * ";
                    $sql .= "from (select A.hero_idx, A.hero_code, A.hero_table, A.hero_command, A.hero_thumb, A.hero_img_new, A.hero_today ";
                    $sql .= ", A.hero_title,A.hero_04, B.hero_level, B.hero_nick, A.event_start_date_01,A.event_start_date_02,A.event_end_date,A.event_small_title,A.event_notice from board as A, member as B where ".$auth_check." A.event_notice = '' and A.hero_code=B.hero_code and (A.hero_table='group_02_03' or A.hero_03='group_02_03') order by A.hero_today desc limit 0,15) as A ";
                    //$sql .= ", A.hero_title,A.hero_04, B.hero_level, B.hero_nick, A.event_start_date_01,A.event_start_date_02,A.event_end_date,A.event_small_title from board as A, member as B where ".$auth_check." A.hero_code=B.hero_code and (A.hero_table='".$board."' or A.hero_03='".$board."') ".$search." order by A.hero_today desc limit ".$start.",".$list_page.") as A ";
                    $sql .= ",(select hero_img_new as level_img, hero_level from level) as C where C.hero_level=A.hero_level order by A.hero_today desc";

                    $main_res = sql($sql,'on');
                    /*if((string)$main_res==$error){
                        error_historyBack("");
                        exit;
                    }*/
                    while($list = mysql_fetch_assoc($main_res)){

                        if($list["hero_thumb"])	    			$view_img = $list['hero_thumb'];
                        elseif($_GET['board']=='group_02_03')	$view_img = IMAGE_END.'hero.jpg';
                        elseif($list["hero_img_new"] )  		$view_img = $list['hero_img_new'];
                        else						  			$view_img = IMAGE_END.'hero.jpg';

                        $url = "http://aklover-test.musign.kr/main/index.php?board='group_02_03'&page=".$page."&view=view&idx=".$list['hero_idx'];


                        $start_date = str_replace(".", "", $list["event_start_date_02"]);
                        $icon = "icon_ing";
                        $ing = "������";
                        if(strlen($list["event_start_date_02"]) > 13) {
                            $start_date = substr($start_date,0,8);
                            $event_start_date1 = substr($list['event_start_date_01'],5,9);
                            $event_start_date2 = substr($list['event_start_date_02'],5,9);
                            $event_end_date = substr($list['event_end_date'],5,9);

                            if(date('Ymd') > $start_date) {
                                $icon = "icon_end";
                                $ing = "����";
                            }

                        } else {
                            $start_date = substr($start_date,0,4);
                            $event_start_date1 = $list['event_start_date_01'];
                            $event_start_date2 = $list['event_start_date_02'];
                            $event_end_date = $list['event_end_date'];

                            $icon = "icon_end";
                            $ing = "����";
                        }

                        if($list['event_notice'] == 1) {
                            $icon = "icon_notice";
                            $ing = "��÷�� ��ǥ";


                            ?>

                            <div class="event_list">
                                <a href="<?=$url?>">
                                    <div class="event_img <?=$icon?> rel">
                                        <img src="<?=$view_img?>" />
                                    </div>
                                    <div class="event_text">
                                        <p class="ptitle">

                                            <!-- ///  -->
                                            <!-- ����� �������� �̺�Ʈ ����Ʈ �ǿ��� ���� -->
                                            <!-- ��÷�� ��ǥ�� ��÷�� ��ǥ �ǿ��� ���� -->
                                            <span class="fz24 main_c">�Խñ� ���� : <?=$ing?></span>
                                            <!-- ///  -->


                                            <span class="title ellipsis_2line fz18 fw600"><?=cut($list['hero_title'], '40')?></span>
                                        </p>
                                        <div>
                                            <dl class="f_cs">
                                                <dt class="fz15 fw600">�̺�Ʈ �Ⱓ</dt>
                                                <dd class="fz15 fw600 gray"><?=$event_start_date1?> ~ <?=$event_start_date2?></dd>
                                            </dl>
                                            <dl class="f_cs">
                                                <dt class="fz15 fw600">��÷�� ��ǥ</dt>
                                                <dd class="fz15 fw600 gray"><?=$event_end_date?></dd>
                                            </dl>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <? } ?>
                    <? } ?>
                </div>

                <? include_once BOARD_INC_END.'button1.php';?>
            </div>
        </div>
    </div>
</div>
</div>

<script>

</script>