<link rel="stylesheet" type="text/css" href="/css/front/cscenter.css" />
<link rel="stylesheet" type="text/css" href="/css/front/lovertalk.css" />
<?
if(!defined('_HEROBOARD_'))exit;

if(!$_GET['board']){
    error_historyBack("�߸��� �����Դϴ�.");
    exit;
}

if($_SESSION['temp_level']=='' || !is_numeric($_SESSION['temp_level']) || !$_GET['action']){
    echo '<script>location.href="./out.php"</script>';
    exit;
}

$sql = "select * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$_GET['board']."'";//desc
$sql_res = mysql_query($sql) or die("<script>alert(�ý��� �����Դϴ�. �ٽ� �õ����ּ���. ���� �ڵ� : WRITE_02);location.href='/main/index.php'</script>");
$right_list = mysql_fetch_assoc($sql_res);

if($right_list['hero_write']>$_SESSION['temp_level'] && $right_list['hero_write']!=0){
    error_historyBack("�˼��մϴ�. �������� ���� ������ �����ϴ�.");
    exit;
}

//21-05-28 �ξ���� �߰�
if($_GET['board'] == "group_04_29") {
    $loyal_auth = false; //�ۼ�����
    $loyal_auth_sql  = " SELECT COUNT(*) cnt FROM member_loyal ";
    $loyal_auth_sql .= " WHERE hero_code = '".$_SESSION["temp_code"]."' AND date_format(CONCAT(gisu_year, gisu_month,'01'),'%Y%m%d') < '".date("Ym")."01"."' ";
    $loyal_auth_sql .= " AND  date_format(date_add(date_format(CONCAT(gisu_year, gisu_month,'01'),'%Y%m%d'), INTERVAL 7 MONTH),'%Y%m%d') > '".date("Ym")."01"."' ";
    $loyal_auth_res = sql($loyal_auth_sql);
    $loyal_auth_rs = mysql_fetch_assoc($loyal_auth_res);

    if($loyal_auth_rs["cnt"] > 0) $loyal_auth = true; //��� ���(�Ⱓ) 6�������� �Խ��� �̿� ����

    if(!$loyal_auth && $_SESSION['temp_level'] < 9999) {
        msg('Loyal AKLOVER ������ �����ϴ�.','location.href="'.PATH_HOME.'?board=group_04_29"');exit;
    }
}

$old_idx = "";
if($_GET['board'] == "group_04_22") {
    $old_idx = $_GET['oldidx'];
}

if($_GET['action']=='update'){ //���� ���μ���
    $idx 			= 	 $_GET['idx'];
    $board 			= 	 $_GET['board'];
    $next_board     =    $_GET['next_board'];
    $action			=	 $_GET['action'];
    $page			=	 $_GET['page'];

    $sql = "select * from board where hero_idx='".$idx."'";
    $sql_res = mysql_query($sql) or die("<script>alert(�ý��� �����Դϴ�. �ٽ� �õ����ּ���. ���� �ڵ� : WRITE_01);location.href='/main/index.php'</script>");
    $out_row = mysql_fetch_assoc($sql_res);

    $code 			=	 $out_row['hero_code'];
    $name 			=	 $out_row['hero_name'];
    $nick			=	 $out_row['hero_nick'];
    $totay 			=	 $out_row['hero_today'];
    $review_count 	=	 $out_row['hero_review_count'];
    $hero_thumb 	=	 $out_row['hero_thumb'];
    $hero_use 		=	 $out_row['hero_use'];
    $hero_review_use = $out_row['hero_review_use'];

    $level 			= 	$_SESSION['temp_level'];

    $new_table 	= $out_row['hero_table'];
    $hero_03 	= $out_row['hero_03'];
    $hero_05 	= $out_row['hero_05'];
    $hero_06 	= $out_row['hero_06'];
    if($code!=$_SESSION['temp_code'] && $_SESSION['temp_level']<9999){
        echo '<script>location.href="./out.php"</script>';
        exit;
    }
}else if(!strcmp($_GET['action'], 'write')){ //��� ���μ���
    $board 			= 	 $_GET['board'];
    $action			=	 $_GET['action'];
    $page			=	 $_GET['page'];

    $code 			= 	$_SESSION['temp_code'];
    $name 			= 	$_SESSION['temp_name'];
    $nick 			= 	$_SESSION['temp_nick'];
    $level 			= 	$_SESSION['temp_level'];

    $totay 			= 	date("Y-m-d H:i:s");
    $today			=	substr($totay,0,10);
    $review_count	=	'0';
    $hero_thumb 	=	"";

    //�̴��� �̺�Ʈ ��÷�ڹ�ǥ group_02_03�� ����
    if($_GET['board'] == 'group_02_10'){
        $new_table 		=	'group_02_03';
        $hero_03 		=	'group_02_03';
    }else {
        $new_table 		=	$_GET['board'];
        $hero_03 		=	$_GET['board'];
    }
}

$pk_sql = 'select * from level where hero_level = \''.$level.'\'';
$sql_res = mysql_query($pk_sql) or die("<script>alert(�ý��� �����Դϴ�. �ٽ� �õ����ּ���. ���� �ڵ� : WRITE_03);location.href='/main/index.php'</script>");
$pk_row = mysql_fetch_assoc($sql_res);
?>
<div id="subpage" <? if($_GET['board'] =="group_02_02" || $_GET['board'] =="group_04_22"){?> class="talk_write"<? } ?>> 
    <? if($_GET['board'] !=="group_02_02" && $_GET['board'] !=="group_04_22"){?>					
    <div class="sub_title">
            <div class="sub_wrap">
                <? if($_GET['board']=="group_02_03"){?>					
					<div class="f_b">
                        <div>
							<h1 class="fz68 main_c fw500 ko">�̴��� �̺�Ʈ</h1>
							<p class="fz18 fw600">������ ���� ������ �̺�Ʈ�� �����غ�����!</p>
						</div>
					</div>
				<?
				}else if ($_GET['board']=="group_04_35" || $_GET['board']=="group_04_03" ||  $_GET['board']=="group_04_33"){
				?>
					<div class="f_b">
						<h1 class="fz68 fw600 main_c">������</h1>
					</div>
                <?
                }else if ($_GET['board']=="group_02_10"){ //musign �߰�
                ?>
                    <div class="f_b">
                        <h1 class="fz68 fw600 main_c">��÷�� ��ǥ</h1>
                    </div>
                <? } ?>
            </div>
    </div>    
    <? } ?>
    <div class="sub_cont">
        <div class="sub_wrap board_wrap f_sb">
            <? if($_GET['board']=="group_02_03"){?>			
                <div class="left view_list">  		
                    <a class="btn_list f_cs" href="<?=MAIN_HOME;?>?board=<?=$board;?>&page=<?=$_GET['page'];?>&gubun=<?=$out_row['gubun'];?>" class="a_btn2">
                        <img src="/img/front/board/list_back.webp" alt="back">
                        <span class="fz19 fw700">�������</span>
                    </a>                   
                </div>
            <?
            } else if ($_GET['board']=="group_04_35" || $_GET['board']=="group_04_03"  || $_GET['board']=="group_04_33"){
            ?>
                <div class="cscenter">
                    <ul class="sub_menu">
                        <li <? if($_GET['board']=="group_04_03"){?> class="on"<? } ?>><a href="/main/index.php?board=group_04_03">�������� <img src="/img/front/icon/bread.webp" alt="�������� �ٷΰ���"></a></li>
                        <li <? if($_GET['board']=="group_04_33"){?> class="on"<? } ?>><a href="/main/index.php?board=group_04_33">FAQ <img src="/img/front/icon/bread.webp" alt="FAQ �ٷΰ���"></a></li>
                        <li <? if($_GET['board']=="group_02_03"){?> class="on"<? } ?>><a href="/main/index.php?board=group_04_35&view_type=list">1:1 ���� <img src="/img/front/icon/bread.webp" alt="1:1 ���� �ٷΰ���"></a></li>
                        <!-- <li class="link" <? if($_GET['board']=="group_02_03"){?> class="on"<? } ?>><a href="/main/index.php?board=group_04_03&page=1&view=view&idx=443487">1:1 ���� <img src="/img/front/icon/bread.webp" alt="1:1 ���� �ٷΰ���"></a></li> -->
                    </ul>
                    <div class="caution">
                        <h3 class="fz20 fw600">�ȳ�/���ǻ���</h3>
                        <div>
                            <div class="f_fs">
                                <img src="/img/front/icon/caution.webp" alt="�ȳ�/���ǻ���">
                                <p class="fz14">
                                    AK Lover�� ���������� Ȯ�����ּ���!<br>
                                    AK Lover Ȱ�� �� ��� ���� �ȳ��帮�� �ֽ��ϴ�.<br>
                                    �� �� �ñ��Ͻ� ������ FAQ�� ���� Ȯ���Ͻðų�,<br> 
                                    1:1 ���Ǹ� �����ּ���.<br>                                    
                                </p>
                            </div>                                
                            <span class="info">
                                ������ȭ : 080-024-1357 (�����ںδ�)<br>
                                ���ð� : ���� 9��~18�� (��, ��, ���� ������ ����)
                            </span>
                        </div>
                    </div>
                </div>
            <? } ?>
            <div class="contents right view_cont">
                <form name="frm" id="frm" method="post" action="<?=MAIN_HOME;?>?board=<?=$board;?>&next_board=<?=$next_board;?>&view=action&action=<?=$action;?>&idx=<?=$idx;?>&page=<?=$page;?>" enctype="multipart/form-data">
                    <input type="hidden" name="hero_drop" value="hero_drop||sm_file||command||chkbox||inputWidth||inputAlt||inputCaption||setWidth||setHeight||setBgcolor||thumbCount||hero_thumb||x||y||inputTitle">
                    <input type="hidden" name="hero_code" value="<?=$code;?>">
                    <input type="hidden" name="hero_review" value="<?=$code;?>">
                    <input type="hidden" name="hero_today" value="<?=$totay;?>">
                    <input type="hidden" name="hero_ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
                    <input type="hidden" name="hero_review_count" value="<?=$review_count?>">
                    <input type="hidden" name="hero_name" id="hero_name" title="�ۼ���" value="<?=$name;?>" readonly />
                    <input type="hidden" name="thumbCount" id="thumbCount" value="0">
                    <?if($_SESSION['temp_level'] < 9999 || $board!="group_04_22") {?>
                        <input type="hidden" name="hero_thumb" id="hero_thumb" value="<?=$hero_thumb?>">
                    <?}?>
                    <input type="hidden" name="hero_notice" value="1">
                    <input type="hidden" name="hero_03" value="<?=$hero_03?>">
                    <input type="hidden" name="hero_table" value="<?=$new_table?>">
                    <input type="hidden" name="hero_review_use" value="<?=$hero_review_use?>">
                    <input type="hidden" name="hero_01_bak" value="<?=$old_idx?>">
                    <input type="hidden" name="hero_nick" id="hero_nick" title="�ۼ���" value="<?=$nick;?>" readonly />
                    <?if(!strcmp($board, 'group_04_10')){?>
                        <input type="hidden" name="hero_02" value="1">
                    <?}?>
                    <div class="write_cont">
                        <? if($_GET['board']=="group_04_35"){?>	
                            <div class="cont_top">
                                <h2 class="fz32 fw600">1:1 ����</h2>
                            </div>
                        <?}?>
                        <? if($_GET['board']=="group_02_02"){?>					
                            <div class="cont_top">
                                <h2 class="fz15 fw600 main_c"><span class="en fz16">Lover</span> ��</h2>
                            </div>
                        <? } ?>
                        <? if($_GET['board']=="group_04_22"){?>					
                            <div class="cont_top">
                                <h2 class="fz15 fw600 main_c">���� �ı�</h2>
                            </div>
                        <? } ?>
                        <!-- ���� -->
                        <p class="tit"><input type="text" name="hero_title" id="hero_title" title="����" value="<?=$out_row['hero_title'];?>" placeholder="������ �Է��ϼ���."/></p>
                        <!-- �ۼ��� ���� -->
                        <!-- <input type="text" name="hero_nick" id="hero_nick" title="�ۼ���" value="<?=$nick;?>" readonly /> -->
                        <!-- ������ ���� ��ư -->
                        <?if($_SESSION['temp_level']>=9999 && ($board!="group_04_35" && $board != 'group_04_33')){?>
                            <div class="admin_check flex mgb20">
                                <p class="list_tit fz17 fw500">���� ����</p>
                                <?if($board!="group_04_22"){?>
                                    <div class="input_chk mgr20">
                                        <input type="checkbox" id="hero_table_notice" value="hero" <?=$out_row['hero_table'] == "hero" ? "checked":"";?> />
                                        <label for="hero_table_notice" class="input_chk_label">��ܰ���</label>
                                    </div>
                                <? } ?>
                                <?if($board=="group_02_02"){?>
                                    <div class="input_chk mgr20">
                                        <input type="checkbox" name="hero_notice_use" id="hero_notice_use" value="1" <?=$out_row['hero_notice_use'] == "1" ? "checked":"";?> />
                                        <label for="hero_notice_use" class="input_chk_label">Lover�� ����</label>
                                    </div>
                                <? } else if($board=="group_04_24"){?>
                                    <div class="input_chk mgr20">
                                        <input type="checkbox" name="hero_notice_use" id="hero_notice_use" value="1" <?=$out_row['hero_notice_use'] == "1" ? "checked":"";?> />
                                        <label for="hero_notice_use" class="input_chk_label">��������</label>
                                    </div>
                                <? } else if($board=="group_04_29"){?>
                                    <div class="input_chk mgr20">
                                        <input type="checkbox" name="hero_notice_use" id="hero_notice_use" value="1" <?=$out_row['hero_notice_use'] == "1" ? "checked":"";?> />
                                        <label for="hero_notice_use" class="input_chk_label">Loyal AK LOVER ����</label>
                                    </div>
                                <? } ?>                                
                                <?if($board!="group_02_03"){?>
                                    <div class="input_chk mgr20">                                        
                                        <input id="temptext" type="checkbox" name="hero_use" value="2" <?=$hero_use=="2" ? "checked":""?>>
                                        <label for="temptext" class="input_chk_label">�ӽñ�</label>
                                    </div>
                                <?}?>
                                <?if($level>=9999){?>
                                    <div class="input_chk">
                                        <input type="checkbox" name="hero_review_use" id="hero_review_use" <?=$hero_review_use=="1" ? "checked":""?>>
                                        <label for="hero_review_use" class="input_chk_label">��� �Խ��� ����</label>
                                    </div>
                                <?}?>
                                <?if($board=="group_02_10"){?>
                                    <div class="input_chk f_cs dis-no">
                                        <input type="checkbox" name="event_notice" id="event_notice" value="1" checked/>
                                        <label for="event_notice" class="input_chk_label">��÷�� ��ǥ</label>
                                    </div>
                                <?}?>
                            </div>
                        <?}?>  
                        <!-- �̺�Ʈ������ -->
                        <?if($board=="group_02_03"){?> 
                             <div class="event_write">
                             <div class="mgb20 f_cs">     
                                <p class="list_tit fz17 fw500">������</p>
                                <div><input type="text" name="event_small_title" id="event_small_title" title="������" value="<?=$out_row['event_small_title'];?>" /></div>
                            </div>
                             <div class="mgb20 f_cs">     
                                <p class="list_tit fz17 fw500">��û��¥</p>
                                <div class="f_cs">
                                    <input type="text" name="event_start_date_01" id="sdate1" class="narrow" value="<?=$out_row['event_start_date_01'];?>" />
                                     ~ 
                                    <input type="text" name="event_start_date_02" id="sdate2" class="narrow" value="<?=$out_row['event_start_date_02'];?>" />
                                </div>
                            </div>
                             <div class="mgb25 f_cs">
                                <p class="list_tit fz17 fw500">��ǥ��¥</p>
                                <div class="input_chk f_cs">
                                    <input type="text" name="event_end_date" id="edate1" value="<?=$out_row['event_end_date'];?>" class="mgr20"/>
                                    <input type="checkbox" id="end_date_person" value="1" <?=$out_row['event_end_date']=="��������"?"checked":""?> /><label for="end_date_person" class="input_chk_label f_sc">��������</label>
                                </div>
                            </div>
                             <!-- ������ ����
                             <div class="mgb25 f_cs">
                                <p class="list_tit fz17 fw500">��ǥ����</p>
                                <div class="input_chk f_cs">
                                    <input type="checkbox" name="event_notice" id="event_notice" value="1" <?php /*=$out_row['event_notice']=="1"?"checked":""*/?>  />
                                    <label for="event_notice" class="input_chk_label">��÷�� ��ǥ(������)</label>
                                </div>
                            </div>
                            -->
                             <div class="mgb20 f_cs">     
                                <p class="list_tit fz17 fw500">��������</p>
                                <div>
                                    <div class="input_radio"><input type="radio" name="hero_use" id="use1" value="1" <?=$out_row['hero_use']==1?"checked":""?> /><label for="use1">����</label></div>
                                    <div class="input_radio"><input type="radio" name="hero_use" id="use2" value="0" <?=$out_row['hero_use']==0?"checked":""?>/><label for="use2">�����</label></div>
                                </div>
                            </div>
                            <link type='text/css' href='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.css' rel='stylesheet' />
                            <script type="text/javascript" src="<?=DOMAIN_END?>cal/jquery.min.js"></script>
                            <script type='text/javascript' src='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.min.js'></script>
                            <script>
                                $(function() {      // window.onload ��� ���� ��ũ��Ʈ
                                    dateclick2();
                                    dateclick3();

                                    $("#end_date_person").change(function(){
                                        if($(this).is(":checked")) {
                                            $("#edate1").val("��������");
                                        }else {
                                            $("#edate1").val("");
                                        }
                                    })
                                });
                                function dateclick2(){
                                    var dates = $("#sdate1, #sdate2").datepicker({
                                        monthNames: ['�� 1��','�� 2��','�� 3��','�� 4��','�� 5��','�� 6��','�� 7��','�� 8��','�� 9��','�� 10��','�� 11��','�� 12��'],
                                        dayNames: ['��', '��', 'ȭ', '��', '��', '��', '��'],
                                        dayNamesMin: ['��', '��', 'ȭ', '��', '��', '��', '��'],
                                        dateFormat: 'yy.mm.dd(DD)',
                                        defaultDate: null,
                                        showMonthAfterYear:true,
                                        onSelect: function( selectedDate ) {
                                            var option = this.id == "sdate1" ? "minDate" : "maxDate",
                                                instance = $( this ).data( "datepicker" ),
                                                date = $.datepicker.parseDate(
                                                    instance.settings.dateFormat ||
                                                    $.datepicker._defaults.dateFormat,
                                                    selectedDate, instance.settings );
                                            dates.not( this ).datepicker( "option", option, date );
                                        }
                                    });
                                };
                                function dateclick3(){
                                    var dates = $("#edate1").datepicker({
                                        monthNames: ['�� 1��','�� 2��','�� 3��','�� 4��','�� 5��','�� 6��','�� 7��','�� 8��','�� 9��','�� 10��','�� 11��','�� 12��'],
                                        dayNames: ['��', '��', 'ȭ', '��', '��', '��', '��'],
                                        dayNamesMin: ['��', '��', 'ȭ', '��', '��', '��', '��'],
                                        defaultDate: null,
                                        showMonthAfterYear:true,
                                        dateFormat: 'yy.mm.dd(DD)',
                                        onSelect: function( selectedDate ) {
                                            var option = this.id == "edate1" ? "minDate" : "maxDate",
                                                instance = $( this ).data( "datepicker" ),
                                                date = $.datepicker.parseDate(
                                                    instance.settings.dateFormat ||
                                                    $.datepicker._defaults.dateFormat,
                                                    selectedDate, instance.settings );
                                            dates.not( this ).datepicker( "option", option, date );
                                        }
                                    });
                                };
                            </script>
                            </div>
                        <?}?>    
                        <!-- ī�װ� -->
                            <?if($board=="cus_2" || $board=="group_04_33" || $board=="group_04_34"){ ?>
                                <div class="category mgb20 f_cs">
                                    <p class="list_tit fz17 fw500">ī�װ�</p>
                                    <select name="hero_06" class="wr_select">
                                        <?if($board=="cus_2" || $board=="group_04_33" || $board=="group_04_34"){
                                            for($i=1;$i<count($_FAQ_CATEGORY);$i++){
                                                echo "<option value='".$_FAQ_CATEGORY[$i]."'";
                                                if($hero_06==$_FAQ_CATEGORY[$i]){
                                                    echo " selected='selected'";
                                                }
                                                echo ">".$_FAQ_CATEGORY[$i]."</option>";
                                            }
                                        }else if($board=="group_04_03"){
                                            for($i=1;$i<count($_NOTICE_CATEGORY);$i++){
                                                echo "<option value='".$_NOTICE_CATEGORY[$i]."'";
                                                if($hero_06==$_NOTICE_CATEGORY[$i]){
                                                    echo " selected='selected'";
                                                }
                                                echo ">".$_NOTICE_CATEGORY[$i]."</option>";
                                            }
                                        }?>
                                    </select>       
                                </div>
                            <?}?>
                            <? if($board=="group_02_02") { ?>
                            <div class="category mgb20 f_cs">
                                <p class="list_tit fz17 fw500">ī�װ�</p>
                                <td>
                                    <div class="input_radio"><input type="radio" name="gubun" id="gubun_2" value="2" <?=$out_row['gubun']=="2" ? "checked":""?>><label for="gubun_2">ü���&��������</label></div>
                                    <div class="input_radio"><input type="radio" name="gubun" id="gubun_3" value="3" <?=$out_row['gubun']=="3" ? "checked":""?>><label for="gubun_3">��ǰ ����</label></div>
                                    <div class="input_radio"><input type="radio" name="gubun" id="gubun_1" value="1" <?=$out_row['gubun']=="1" ? "checked":""?>><label for="gubun_1">�ϻ� ����</label></div>
                                </td>
                            </div>
                            <? } else if($board=="group_04_03") { ?>
                                <div class="category mgb20 f_cs">
                                    <p class="list_tit fz17 fw500">ī�װ�</p>
                                    <td>
                                        <div class="input_radio"><input type="radio" name="gubun" id="gubun_1" value="1" <?=$out_row['gubun']=="1" ? "checked":""?>><label for="gubun_1">�ʵ�</label></div>
                                        <div class="input_radio"><input type="radio" name="gubun" id="gubun_2" value="2" <?=$out_row['gubun']=="2" ? "checked":""?>><label for="gubun_2">�ȳ�</label></div>
                                        <div class="input_radio"><input type="radio" name="gubun" id="gubun_3" value="3" <?=$out_row['gubun']=="3" ? "checked":""?>><label for="gubun_3">�̺�Ʈ</label></div>
                                        <div class="input_radio"><input type="radio" name="gubun" id="gubun_4" value="" <?=!$out_row['gubun'] ? "checked":""?>><label for="gubun_4">������</label></div>
                                    </td>
                                </div>
                            <? } else if($board=="group_04_24") {?>
                                <div class="category mgb20 f_cs">                            
                                    <p class="list_tit fz17 fw500">ī�װ�</p>
                                        <div class="input_radio">
                                            <input type="radio" name="hero_keywords" id="hero_keywords_1" value="1" <?=$out_row['hero_keywords']=="1" ? "checked":""?>><label for="hero_keywords_1">����</label>
                                        </div>
                                        <div class="input_radio">
                                            <input type="radio" name="hero_keywords" id="hero_keywords_2" value="2" <?=$out_row['hero_keywords']=="2" ? "checked":""?>><label for="hero_keywords_2">Ȱ��</label>
                                        </div>
                                        <div class="input_radio">
                                            <input type="radio" name="hero_keywords" id="hero_keywords_3" value="3" <?=$out_row['hero_keywords']=="3" ? "checked":""?>><label for="hero_keywords_3">���� TIP</label>
                                        </div>
                                        <div class="input_radio">
                                            <input type="radio" name="hero_keywords" id="hero_keywords_4" value="4" <?=$out_row['hero_keywords']=="4" ? "checked":""?>><label for="hero_keywords_4">��ü TIP</label>
                                        </div>
                                        <div class="input_radio">
                                            <input type="radio" name="hero_keywords" id="hero_keywords_5" value="" <?=!$out_row['hero_keywords'] ? "checked":""?>><label for="hero_keywords_5">������</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="category mgb20 f_cs">                                     
                                    <p class="list_tit fz17 fw500">ī�װ�</p>
                                    <div class="input_radio">
                                        <div class="input_radio"><input type="radio" name="gubun" id="gubun_1" value="1" <?=$out_row['gubun']=="1" ? "checked":""?>><label for="gubun_1">�ʵ�</label></div>
                                        <div class="input_radio"><input type="radio" name="gubun" id="gubun_2" value="2" <?=$out_row['gubun']=="2" ? "checked":""?>><label for="gubun_2">��α�</label></div>
                                        <div class="input_radio"><input type="radio" name="gubun" id="gubun_3" value="3" <?=$out_row['gubun']=="3" ? "checked":""?>><label for="gubun_3">�ν�Ÿ</label></div>
                                        <div class="input_radio"><input type="radio" name="gubun" id="gubun_4" value="4" <?=$out_row['gubun']=="4" ? "checked":""?>><label for="gubun_4">��Ʃ��&����</label></div>
                                        <div class="input_radio"><input type="radio" name="gubun" id="gubun_5" value="" <?=!$out_row['gubun'] ? "checked":""?>><label for="gubun_5">������</label></div>
                                    </div>
                                </div>
<!--                            --><?// } else if($board=="cus_3" || $board=="group_04_35") {?>
                            <? } else if($board=="cus_3") {?>
                                <div class="category mgb20 f_cs">
                                    <p class="list_tit fz17 fw500">ī�װ�</p>
                                    <div class="input_radio">
                                        <div class="input_radio"><input type="radio" name="gubun" id="gubun_1" value="1" <?=$out_row['gubun']=="1" ? "checked":""?>><label for="gubun_1">ü��� ����</label></div>
                                        <div class="input_radio"><input type="radio" name="gubun" id="gubun_2" value="2" <?=$out_row['gubun']=="2" ? "checked":""?>><label for="gubun_2">ü��� �ı����</label></div>
                                        <div class="input_radio"><input type="radio" name="gubun" id="gubun_3" value="3" <?=$out_row['gubun']=="3" ? "checked":""?>><label for="gubun_3">Ȩ������ ����</label></div>
                                        <div class="input_radio"><input type="radio" name="gubun" id="gubun_4" value="4" <?=$out_row['gubun']=="4" ? "checked":""?>><label for="gubun_4">��Ÿ</label></div>
                                    </div>
                                </div>
                            <? } else if ($board=="group_04_35"){?>
                                <div class="category mgb20 f_cs">
                                    <p class="list_tit fz17 fw500">ī�װ�</p>
                                    <div class="input_radio cateselect">
                                        <div class="input_radio"><input type="radio" name="b_gubun" id="b_gubun_1" value="100"><label for="b_gubun_1">ü���</label></div>
                                        <div class="input_radio"><input type="radio" name="b_gubun" id="b_gubun_2" value="200"><label for="b_gubun_2">�̺�Ʈ/����Ʈ �佺Ƽ��</label></div>
                                        <div class="input_radio"><input type="radio" name="b_gubun" id="b_gubun_3" value="300"><label for="b_gubun_3">Ȩ������</label></div>
                                        <div class="input_radio"><input type="radio" name="b_gubun" id="b_gubun_4" value="4"><label for="b_gubun_4">��Ÿ</label></div>
                                    </div>
                                </div>
                                <div class="category f_cs">
                                    <p class="list_tit fz17 fw500 screen_out">[ü]������</p>
                                    <div class="subcategory depht2 subcategory_100">
                                        <div class="rel selcet_wrap">
                                            <select name="m_gubun100" id="m_gubun100" class="wr_select">
                                                <option value="110">���� ��� �� ��ǰ ����</option>
                                                <option value="120">��ǰ ��� �� �ļ� Ȯ��</option>
                                                <option value="130">������ ����</option>
                                                <option value="140">�����н� ����</option>
                                                <option value="150">�г�Ƽ ����</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="subcategory depht3 subcategory_100 subcategory_110">
                                        <div class="rel selcet_wrap">
                                            <select name="s_gubun110" id="s_gubun110" class="wr_select">
                                                <option value="111">���� ��� ��û</option>
                                                <option value="112">ü�� ��ǰ ���� ��û</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="subcategory depht3 subcategory_120">
                                        <div class="rel selcet_wrap">
                                            <select name="s_gubun120" id="s_gubun120" class="wr_select">
                                                <option value="121">[���] ��� Ȯ�� ��û</option>
                                                <option value="122">[���] ��ǰ Ȯ�� ��û</option>
                                                <option value="123">[���] ��ǰ ȸ�� ��û</option>
                                                <option value="124">[���] ��ǰ �ļ� �Ű�</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="subcategory depht3 subcategory_130">
                                        <div class="rel selcet_wrap">
                                            <select name="s_gubun130" id="s_gubun130" class="wr_select">
                                                <option value="131">Ȩ������ �ı� ��� ��� ����</option>
                                                <option value="132">�ı� ��� �Ⱓ ���� ����</option>
                                                <option value="133">�����ı� ����</option>
                                                <option value="134">���̵���� ���� ����</option>
                                                <option value="135">���������/���� ����</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="subcategory depht3 subcategory_140">
                                        <div class="rel selcet_wrap">
                                            <select name="s_gubun140" id="s_gubun140" class="wr_select">
                                                <option value="141">�����н� ����</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="subcategory depht3 subcategory_150">
                                        <div class="rel selcet_wrap">
                                            <select name="s_gubun150" id="s_gubun150" class="wr_select">
                                                <option value="151">�г�Ƽ ����</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="category f_cs">
                                    <p class="list_tit fz17 fw500 screen_out">[��]������</p>
                                    <div class="subcategory depht2 subcategory subcategory_200">
                                        <div class="rel selcet_wrap">
                                            <select name="m_gubun200" id="m_gubun200" class="wr_select">
                                                <option value="210">��÷ ����</option>
                                                <option value="220">��ǰ �� ��� Ȯ��</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="f_cs subcategory depht3 subcategory_200 subcategory_210">
                                        <div class="rel selcet_wrap">
                                            <select name="s_gubun210" id="s_gubun210" class="wr_select">
                                                <option value="211">�̺�Ʈ ��÷ ����</option>
                                                <option value="212">�̺�Ʈ ��÷ ��ǰ ����</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="f_cs subcategory depht3 subcategory_220">
                                        <div class="rel selcet_wrap">
                                            <select name="s_gubun220" id="s_gubun220" class="wr_select">
                                                <option value="221">[���] ��� Ȯ�� ��û</option>
                                                <option value="222">[���] ��ǰ Ȯ�� ��û</option>
                                                <option value="223">[���] ��ǰ ȸ�� ��û</option>
                                                <option value="224">[���] ��ǰ �ļ� �Ű�</option>
                                                <option value="225">[����] ��ǰ ���� �Ű�</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="category f_cs">
                                    <p class="list_tit fz17 fw500 screen_out">[Ȩ]������</p>
                                    <div class="subcategory subcategory_300">
                                        <div class="rel selcet_wrap">
                                            <select name="m_gubun300" id="m_gubun300" class="wr_select">
                                                <option value="310">Ȩ������ �̿�</option>
                                            </select>
                                        </div>
                                    </div>    
                                    <div class="subcategory subcategory_300">
                                        <div class="rel selcet_wrap">
                                            <select name="s_gubun310" id="s_gubun310" class="wr_select">
                                                <option value="311">���� ����/���� ����</option>
                                                <option value="312">��������/�̿��� ����</option>
                                                <option value="313">����ȸ�� �Ű�</option>
                                                <option value="314">��Ÿ ����</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>     
                                <script>
                                    $(document).ready(function(){
                                        // ��з� Ŭ���� 
                                        $('.subcategory').hide();
                                        const subcategory = $('.subcategory');
                                        $('.cateselect input').on('click', function() {
                                            $('.subcategory').hide(); 
                                            $('.subcategory_' + $(this).val()).show(); // ���õ� ���� ī�װ� ǥ��
                                        });
                                        // �ߺз� Ŭ���� 
                                        const subcategory2 = $('.depht2 select');
                                        subcategory2.on('change', function() {
                                            $('.subcategory').not('.depht2').hide(); 
                                            $('.subcategory_' + $(this).val()).show(); // ���õ� ���� ī�װ� ǥ��
                                            console.log('aa');
                                        });
                                    });
                                </script>
                            <?} ?>
                            <!-- url -->
                            <?if((!strcmp($board, 'group_04_05')) or (!strcmp($board, 'group_04_06')) or (!strcmp($board, 'group_04_07')) or (!strcmp($board, 'group_04_08')) or (!strcmp($board, 'group_04_09')) or (!strcmp($board, 'group_04_27')) or (!strcmp($board, 'group_04_28'))){	?>
                                <div class="urlbox mgb20 f_cs">                                            
                                    <p class="list_tit fz17 fw500">URL</p>
                                    <div>
                                        <p class="fz13 op05">* URL�� ���ٿ� �ϳ��� ��ü �ּ�(HTTP:// �Ǵ� HTTPS://)�� �־��ּ���</p>
                                        <textarea id="hero_04" name="hero_04"><?=$out_row['hero_04'];?></textarea>
                                    </div>
                                </div>
                            <?}?>                                                 
                            <!-- �ۼ� ������ -->
                            <textarea id="editor" name="command">
                                <?=$out_row['hero_command']?>
                            </textarea>
                            <!-- ������ ����� ���� -->
                            <div class="thumnail mgb20" <? if($board!='group_02_03' && $board!='group_02_10'){?>style="display:none"<? } ?>>
                                <div>
                                    <div><img src="/image/bbs/guide_thumb.gif" /></div>
                                    <div style="background: #F2F2F2; margin-bottom: 10px;">
                                        <div id="thumbnailView" class="scroll f_cs"></div>
                                    </div> 
                                </div>
                            </div>
                            <!-- ��ǥ �̹��� ���ε� -->
                            <?if($_SESSION['temp_level']>=9999 && $board=="group_04_22") {?>
                                <div class="thum_file upfile f_cs mgb20">
                                    <p class="list_tit fz17 fw500">��ǥ �̹���</p>
                                    <div>                                                                                   
                                        <div id="present_image_area">
                                            <? if($hero_thumb){ ?>
                                                <img src="<?=$hero_thumb?>" style="width:200px;margin-top:10px;"><br/>
                                            <? } ?>
                                        </div>
                                        <div class="rel"> 
                                            <input type="hidden" id="hero_thumb" name="hero_thumb" value="<?=$hero_thumb?>"/>
                                            <label for="write_hero_thumb" id="link" class="custom-file-upload">�̹��� ���ε�<img src="/img/front/icon/fileup.webp" alt="÷������ ���ε�"></label>
                                        </div>
                                        <p class="fz15 op05">* 10MB ���Ϸ� ���ε��� �ּ���.</p>
                                    </div>
                                </div>
                            <? } ?>
                            <!-- ÷������ -->
                            <? if($_GET["board"] != "group_04_29"){?>
                                <div class="upfile f_cs">
                                    <p class="list_tit fz17 fw500">÷������</p>
                                    <div class="upfile_inner rel">
                                        <input type="file" id="hero_board_one" name="hero_board_one[]" title="÷������" value="<?=$out_row['hero_board_one'];?>" />
                                        <label for="hero_board_one" class="custom-file-upload">÷������<img src="/img/front/icon/fileup.webp" alt="÷������ ���ε�"></label>
                                        <?if($_GET['action'] == 'update' && $out_row['hero_board_one'] != ''){//�����̰� ÷�������� ������?>
                                          <!-- 2024-10-22 ���ε�� ÷������ ���� ��� ��û - musign YDH -->
                                          <input type="hidden" id="hero_board_two" name="hero_board_two" value="<?=$out_row['hero_board_two']?>">
                                          <span id="hero_board_two_ori">÷�����ϸ�: <?=$out_row['hero_board_two']?></span>
                                          <a href="javascript:rm_files();" class="delete_btn"> ����</a>
                                        <?}?>
                                    </div>
                                </div>
                                <div class="warn">                                        
                                    <p class="fz15 op05">* jpg, jpeg, gif, png, bmp, zip, hwp, ppt, xls, doc, txt, pdf, xlsx, pptx, docx ������ 2MB ���Ϸθ� ÷�ΰ� �����մϴ�.</p>
                                    <p class="fz15 op05">* ÷�ε� ������ ��ü �̿��ڰ� �ٿ�ε� ���� �� ������ �����Ͻñ� �ٶ��ϴ�.</p>
                                </div>
                            <? } ?>                            
                            <!-- ��ǥ�̹��� ���ε� -->
                    </div>
                    <? include_once BOARD_INC_END.'button2.php';?>
                </form>
        </div>    
        </div>    
    </div>
</div>
</div>

<form action="/main/zip_thumb.php" id="write2_file_upload" enctype="multipart/form-data" method="post" >
    <input type="file" name="thumbImage" id="write_hero_thumb" title="�̹���" style="position: absolute; left: -9999em;"/>
</form>

<script type="text/javascript" src="/loak/loak.js?v=1"></script>
<script src="/js/jquery.form.js"></script>
<script type="text/javascript">
    function rm_files(){ //���� ����
        $("#hero_board_two").val('');
        $("#hero_board_two_ori").text('');
    }

    var myeditor = new cheditor();              // ������ ��ü�� �����մϴ�.
    myeditor.config.editorHeight = '300px';     // ������ �������Դϴ�.
    myeditor.config.editorWidth = '100%';        // ������ �������Դϴ�.

    <? if($_GET["board"] == "group_02_02") {?>
    myeditor.config.oncontextmenu = false;
    <? } ?>
    myeditor.inputForm = 'editor';             // textarea�� id �̸��Դϴ�. ����: name �Ӽ� �̸��� �ƴմϴ�.
    myeditor.run();                             // �����͸� �����մϴ�.
    <? if($_GET['action'] == 'write') {?>
    var editorText = '������ �Է����ּ���';
    <? } ?>

    $(document).ready(function(){
        document.frm.hero_title.focus();
        <?php
        ## ���� ���̵�� ī�װ�
        if($board=="group_03_04"){
            echo "write_placeholder();";
        }
        ?>
        <? if($_GET['action'] == 'write') {?>
            setTimeout(function() {
                $('.cheditor-editarea').contents().find('body').text(editorText);
            }, 500);
            setTimeout(function() {
                $('.cheditor-editarea').contents().find('body').click(function () {
                    //Ŭ���Ҷ����� ���� �������� ó������ ���� ����
                    if($('.cheditor-editarea').contents().find('body').text() == '������ �Է����ּ���')
                        $('.cheditor-editarea').contents().find('body').text("");
                });
            }, 1000);
        <? } ?>
        $("#write_hero_thumb").change(function(){
            var file = this;
            var filename = $(this).val();
            var maxSize  = 10 * 1024 * 1024    //10MB
            var fileSize = 0;
            var browser=navigator.appName;

            var tf_extension = extension_check(filename,"image");

            if(tf_extension==false){
                $(this).val("");
                return false;
            }

            // �ͽ��÷η��� ���
            if (browser=="Microsoft Internet Explorer") {
                var oas = new ActiveXObject("Scripting.FileSystemObject");
                fileSize = oas.getFile( filename ).size;
            } else {
                fileSize = file.files[0].size;
            }

            if(maxSize < fileSize) {
                alert("�̹��� �뷮�ʰ��Դϴ�.\n10MB���Ϸ� ���ε带 ������ �ּ���.");
                return false;
            }

            var options=
                {
                    success: function(data){
                        if(data=='0'){
                            alert("�˼��մϴ�. �̹��� ���ε� �����Դϴ�. �ٽ� �õ����ּ���. ���� ������ �ݺ��� ��� �����Ϳ� �������ּ���.");
                            return false;
                        }else{
                            $("#present_image_area").html("<img src='"+data+"' style='margin:10px 0;'/>");
                            data = trim(data);
                            $("#hero_thumb").val(data);
                        }
                    },beforeSend:function(){
                        $('.img-loading').css('display','block');
                    }
                    ,complete:function(){
                        $('.img-loading').css('display','none');

                    },error:function(e){
                        alert("�˼��մϴ�. �̹��� ���ε� �����Դϴ�. �ٽ� �õ����ּ���. ���� ������ �ݺ��� ��� �����Ϳ� �������ּ���.");
                        return false;
                    }
                };

            $('#write2_file_upload').ajaxForm(options).submit();

        });
    });

    function write_placeholder(){
        $('.cheditor-editarea').contents().find('body').click(function(){
            $(this).find(".write_placeholder").remove();
        });
    }

    $("#hero_board_one").change(function(){
        var file = this;
        var filename = $(this).val();
        var maxSize  = 2 * 1024 * 1024    //2MB
        var fileSize = 0;
        var browser=navigator.appName;

        // �ͽ��÷η��� ���
        if (browser=="Microsoft Internet Explorer") {
            var oas = new ActiveXObject("Scripting.FileSystemObject");
            fileSize = oas.getFile( filename ).size;
        } else {
            fileSize = file.files[0].size;
        }

        if(maxSize < fileSize) {
            alert("�̹��� �뷮�ʰ��Դϴ�.\n2MB���Ϸ� ���ε带 ������ �ּ���.");
            $(this).val("");
            return false;
        }
    })

    function doSubmit (theform){
        
        var cmd_len_check = myeditor.outputBodyText();
        myeditor.outputBodyHTML();

        var title = theform.hero_title;
        var name = theform.hero_nick;
        var cmd = theform.command;
        var hero_table 	=	 theform.hero_table;
        var hero_03 	=	 theform.hero_03;
        var thumb = theform.hero_thumb;

        if(title.value == ""){
            alert("������ �Է��ϼ���.");
            title.style.border = '1px solid red';
            title.focus();
            return false;
        }else{
            title.style.border = '';
        }

        <? if($board=="group_02_02" || $board=="group_04_24" || $board=="cus_3") {//ī�װ� �ִ� �޴�?>
        if(!$("input:radio[name='gubun']").is(":checked")) {
            alert("ī�װ��� �������ּ���.");
            return false;
        }
        <? }else if($board=="group_04_35") { ?>
        if(!$("input:radio[name='b_gubun']").is(":checked")) {
            alert("ī�װ��� �������ּ���.");
            return false;
        }
        <? }?>

        if(cmd_len_check == ""){
            alert("������ �Է��ϼ���.");
            return false;
        }


        if(cmd_len_check.length < 5) {
            alert("5���� �̸��� ���� �ۼ� �Ұ��մϴ�.");
            return false;
        }

        hero_table.disabled = false;

        if(hero_table.value==''){
            alert("ī�װ��� �������� �ʾҽ��ϴ�. �߸��� �������� ���� �����Դϴ�. �ٽ� �õ��� �ּ���.");
            location.href="/main/index.php";
            return false;
        }

        <?php if($board=="group_03_04"){?>
        var hero_05 	=	 theform.hero_05;
        if(hero_05.value==''){
            alert("���̵�� ������ �������ּ���.");
            hero_05.style.border = '1px solid red';
            hero_05.focus();
            return false;
        }
        <?php }?>

        <? if($_SESSION['temp_level'] >= 9999) { ?>
        if($("#hero_table_notice").is(":checked")) {
            $("#frm input[name='hero_table']").val("hero");
        } else {
            $("#frm input[name='hero_table']").val($("#frm input[name='hero_03']").val());
        }

        if($("#hero_review_use").is(":checked") == true) {
            $("#frm input[name='hero_review_use']").val("1");
        } else {
            $("#frm input[name='hero_review_use']").val("0");
        }
        <? } ?>

        if($("input:file[name='hero_board_one[]']")) {
            if($("input:file[name='hero_board_one[]']").val()) {
                var filename = $("input:file[name='hero_board_one[]']").val();
                var flieLen = filename.length;
                var lastDot = filename.lastIndexOf('.');
                var fileExt = filename.substring(lastDot+1, flieLen).toLowerCase();
                var maxSize = 2 * 1024 * 1024

                //var filesize = document.getElementById("hero_board_one[]").files[0].size;
                //var filesize = document.frm.hero_board_one.files[0].size;
                //console.log(filesize);


                var extArr = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'zip', 'hwp', 'ppt', 'xls', 'doc', 'txt', 'pdf', 'xlsx', 'pptx', 'docx'];
                var checkExt = false;
                for(var i = 0; i < extArr.length; i++) {
                    if(fileExt == extArr[i]) checkExt = true;
                }

                if(!checkExt) {
                    alert("÷������ Ȯ���ڸ� Ȯ�����ּ���");
                    return;
                }
            }
        }


        theform.submit();
        return false;
    }

    function showImageInfo() {
        var data = myeditor.getImages();
        if (data == null) {
            alert('�ø� �̹����� �����ϴ�.');
            return;
        }
        for (var i=0; i<data.length; i++) {
            var str = 'URL: ' + data[i].fileUrl + "\n";
            str += '���� ���: ' + data[i].filePath + "\n";
            str += '���� �̸�: ' + data[i].origName + "\n";
            str += '���� �̸�: ' + data[i].fileName + "\n";
            str += 'ũ��: ' + data[i].fileSize;
            alert(str);
        }
    }
</script>
