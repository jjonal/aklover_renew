<link rel="stylesheet" type="text/css" href="/css/front/cscenter.css" />
<link rel="stylesheet" type="text/css" href="/css/front/lovertalk.css" />
<?
if(!defined('_HEROBOARD_'))exit;

if(!$_GET['board']){
    error_historyBack("잘못된 접근입니다.");
    exit;
}

if($_SESSION['temp_level']=='' || !is_numeric($_SESSION['temp_level']) || !$_GET['action']){
    echo '<script>location.href="./out.php"</script>';
    exit;
}

$sql = "select * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$_GET['board']."'";//desc
$sql_res = mysql_query($sql) or die("<script>alert(시스템 에러입니다. 다시 시도해주세요. 에러 코드 : WRITE_02);location.href='/main/index.php'</script>");
$right_list = mysql_fetch_assoc($sql_res);

if($right_list['hero_write']>$_SESSION['temp_level'] && $right_list['hero_write']!=0){
    error_historyBack("죄송합니다. 페이지에 대한 권한이 없습니다.");
    exit;
}

//21-05-28 로얄권한 추가
if($_GET['board'] == "group_04_29") {
    $loyal_auth = false; //작성권한
    $loyal_auth_sql  = " SELECT COUNT(*) cnt FROM member_loyal ";
    $loyal_auth_sql .= " WHERE hero_code = '".$_SESSION["temp_code"]."' AND date_format(CONCAT(gisu_year, gisu_month,'01'),'%Y%m%d') < '".date("Ym")."01"."' ";
    $loyal_auth_sql .= " AND  date_format(date_add(date_format(CONCAT(gisu_year, gisu_month,'01'),'%Y%m%d'), INTERVAL 7 MONTH),'%Y%m%d') > '".date("Ym")."01"."' ";
    $loyal_auth_res = sql($loyal_auth_sql);
    $loyal_auth_rs = mysql_fetch_assoc($loyal_auth_res);

    if($loyal_auth_rs["cnt"] > 0) $loyal_auth = true; //등록 기수(기간) 6개월까지 게시판 이용 가능

    if(!$loyal_auth && $_SESSION['temp_level'] < 9999) {
        msg('Loyal AKLOVER 권한이 없습니다.','location.href="'.PATH_HOME.'?board=group_04_29"');exit;
    }
}

$old_idx = "";
if($_GET['board'] == "group_04_22") {
    $old_idx = $_GET['oldidx'];
}

if($_GET['action']=='update'){ //수정 프로세스
    $idx 			= 	 $_GET['idx'];
    $board 			= 	 $_GET['board'];
    $next_board     =    $_GET['next_board'];
    $action			=	 $_GET['action'];
    $page			=	 $_GET['page'];

    $sql = "select * from board where hero_idx='".$idx."'";
    $sql_res = mysql_query($sql) or die("<script>alert(시스템 에러입니다. 다시 시도해주세요. 에러 코드 : WRITE_01);location.href='/main/index.php'</script>");
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
}else if(!strcmp($_GET['action'], 'write')){ //등록 프로세스
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

    //이달의 이벤트 당첨자발표 group_02_03로 저장
    if($_GET['board'] == 'group_02_10'){
        $new_table 		=	'group_02_03';
        $hero_03 		=	'group_02_03';
    }else {
        $new_table 		=	$_GET['board'];
        $hero_03 		=	$_GET['board'];
    }
}

$pk_sql = 'select * from level where hero_level = \''.$level.'\'';
$sql_res = mysql_query($pk_sql) or die("<script>alert(시스템 에러입니다. 다시 시도해주세요. 에러 코드 : WRITE_03);location.href='/main/index.php'</script>");
$pk_row = mysql_fetch_assoc($sql_res);
?>
<div id="subpage" <? if($_GET['board'] =="group_02_02" || $_GET['board'] =="group_04_22"){?> class="talk_write"<? } ?>> 
    <? if($_GET['board'] !=="group_02_02" && $_GET['board'] !=="group_04_22"){?>					
    <div class="sub_title">
            <div class="sub_wrap">
                <? if($_GET['board']=="group_02_03"){?>					
					<div class="f_b">
                        <div>
							<h1 class="fz68 main_c fw500 ko">이달의 이벤트</h1>
							<p class="fz18 fw600">누구나 참여 가능한 이벤트에 참여해보세요!</p>
						</div>
					</div>
				<?
				}else if ($_GET['board']=="group_04_35" || $_GET['board']=="group_04_03" ||  $_GET['board']=="group_04_33"){
				?>
					<div class="f_b">
						<h1 class="fz68 fw600 main_c">고객센터</h1>
					</div>
                <?
                }else if ($_GET['board']=="group_02_10"){ //musign 추가
                ?>
                    <div class="f_b">
                        <h1 class="fz68 fw600 main_c">당첨자 발표</h1>
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
                        <span class="fz19 fw700">목록으로</span>
                    </a>                   
                </div>
            <?
            } else if ($_GET['board']=="group_04_35" || $_GET['board']=="group_04_03"  || $_GET['board']=="group_04_33"){
            ?>
                <div class="cscenter">
                    <ul class="sub_menu">
                        <li <? if($_GET['board']=="group_04_03"){?> class="on"<? } ?>><a href="/main/index.php?board=group_04_03">공지사항 <img src="/img/front/icon/bread.webp" alt="공지사항 바로가기"></a></li>
                        <li <? if($_GET['board']=="group_04_33"){?> class="on"<? } ?>><a href="/main/index.php?board=group_04_33">FAQ <img src="/img/front/icon/bread.webp" alt="FAQ 바로가기"></a></li>
                        <li <? if($_GET['board']=="group_02_03"){?> class="on"<? } ?>><a href="/main/index.php?board=group_04_35&view_type=list">1:1 문의 <img src="/img/front/icon/bread.webp" alt="1:1 문의 바로가기"></a></li>
                        <!-- <li class="link" <? if($_GET['board']=="group_02_03"){?> class="on"<? } ?>><a href="/main/index.php?board=group_04_03&page=1&view=view&idx=443487">1:1 문의 <img src="/img/front/icon/bread.webp" alt="1:1 문의 바로가기"></a></li> -->
                    </ul>
                    <div class="caution">
                        <h3 class="fz20 fw600">안내/유의사항</h3>
                        <div>
                            <div class="f_fs">
                                <img src="/img/front/icon/caution.webp" alt="안내/유의사항">
                                <p class="fz14">
                                    AK Lover의 공지사항을 확인해주세요!<br>
                                    AK Lover 활동 및 운영에 대해 안내드리고 있습니다.<br>
                                    이 외 궁금하신 사항은 FAQ을 통해 확인하시거나,<br> 
                                    1:1 문의를 남겨주세요.<br>                                    
                                </p>
                            </div>                                
                            <span class="info">
                                문의전화 : 080-024-1357 (수신자부담)<br>
                                상담시간 : 평일 9시~18시 (토, 일, 법정 공휴일 제외)
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
                    <input type="hidden" name="hero_name" id="hero_name" title="작성자" value="<?=$name;?>" readonly />
                    <input type="hidden" name="thumbCount" id="thumbCount" value="0">
                    <?if($_SESSION['temp_level'] < 9999 || $board!="group_04_22") {?>
                        <input type="hidden" name="hero_thumb" id="hero_thumb" value="<?=$hero_thumb?>">
                    <?}?>
                    <input type="hidden" name="hero_notice" value="1">
                    <input type="hidden" name="hero_03" value="<?=$hero_03?>">
                    <input type="hidden" name="hero_table" value="<?=$new_table?>">
                    <input type="hidden" name="hero_review_use" value="<?=$hero_review_use?>">
                    <input type="hidden" name="hero_01_bak" value="<?=$old_idx?>">
                    <input type="hidden" name="hero_nick" id="hero_nick" title="작성자" value="<?=$nick;?>" readonly />
                    <?if(!strcmp($board, 'group_04_10')){?>
                        <input type="hidden" name="hero_02" value="1">
                    <?}?>
                    <div class="write_cont">
                        <? if($_GET['board']=="group_04_35"){?>	
                            <div class="cont_top">
                                <h2 class="fz32 fw600">1:1 문의</h2>
                            </div>
                        <?}?>
                        <? if($_GET['board']=="group_02_02"){?>					
                            <div class="cont_top">
                                <h2 class="fz15 fw600 main_c"><span class="en fz16">Lover</span> 톡</h2>
                            </div>
                        <? } ?>
                        <? if($_GET['board']=="group_04_22"){?>					
                            <div class="cont_top">
                                <h2 class="fz15 fw600 main_c">모임 후기</h2>
                            </div>
                        <? } ?>
                        <!-- 제목 -->
                        <p class="tit"><input type="text" name="hero_title" id="hero_title" title="제목" value="<?=$out_row['hero_title'];?>" placeholder="제목을 입력하세요."/></p>
                        <!-- 작성자 삭제 -->
                        <!-- <input type="text" name="hero_nick" id="hero_nick" title="작성자" value="<?=$nick;?>" readonly /> -->
                        <!-- 관리자 노출 버튼 -->
                        <?if($_SESSION['temp_level']>=9999 && ($board!="group_04_35" && $board != 'group_04_33')){?>
                            <div class="admin_check flex mgb20">
                                <p class="list_tit fz17 fw500">공지 설정</p>
                                <?if($board!="group_04_22"){?>
                                    <div class="input_chk mgr20">
                                        <input type="checkbox" id="hero_table_notice" value="hero" <?=$out_row['hero_table'] == "hero" ? "checked":"";?> />
                                        <label for="hero_table_notice" class="input_chk_label">상단고정</label>
                                    </div>
                                <? } ?>
                                <?if($board=="group_02_02"){?>
                                    <div class="input_chk mgr20">
                                        <input type="checkbox" name="hero_notice_use" id="hero_notice_use" value="1" <?=$out_row['hero_notice_use'] == "1" ? "checked":"";?> />
                                        <label for="hero_notice_use" class="input_chk_label">Lover톡 공지</label>
                                    </div>
                                <? } else if($board=="group_04_24"){?>
                                    <div class="input_chk mgr20">
                                        <input type="checkbox" name="hero_notice_use" id="hero_notice_use" value="1" <?=$out_row['hero_notice_use'] == "1" ? "checked":"";?> />
                                        <label for="hero_notice_use" class="input_chk_label">배움통공지</label>
                                    </div>
                                <? } else if($board=="group_04_29"){?>
                                    <div class="input_chk mgr20">
                                        <input type="checkbox" name="hero_notice_use" id="hero_notice_use" value="1" <?=$out_row['hero_notice_use'] == "1" ? "checked":"";?> />
                                        <label for="hero_notice_use" class="input_chk_label">Loyal AK LOVER 공지</label>
                                    </div>
                                <? } ?>                                
                                <?if($board!="group_02_03"){?>
                                    <div class="input_chk mgr20">                                        
                                        <input id="temptext" type="checkbox" name="hero_use" value="2" <?=$hero_use=="2" ? "checked":""?>>
                                        <label for="temptext" class="input_chk_label">임시글</label>
                                    </div>
                                <?}?>
                                <?if($level>=9999){?>
                                    <div class="input_chk">
                                        <input type="checkbox" name="hero_review_use" id="hero_review_use" <?=$hero_review_use=="1" ? "checked":""?>>
                                        <label for="hero_review_use" class="input_chk_label">댓글 게시판 노출</label>
                                    </div>
                                <?}?>
                                <?if($board=="group_02_10"){?>
                                    <div class="input_chk f_cs dis-no">
                                        <input type="checkbox" name="event_notice" id="event_notice" value="1" checked/>
                                        <label for="event_notice" class="input_chk_label">당첨자 발표</label>
                                    </div>
                                <?}?>
                            </div>
                        <?}?>  
                        <!-- 이벤트페이지 -->
                        <?if($board=="group_02_03"){?> 
                             <div class="event_write">
                             <div class="mgb20 f_cs">     
                                <p class="list_tit fz17 fw500">소제목</p>
                                <div><input type="text" name="event_small_title" id="event_small_title" title="소제목" value="<?=$out_row['event_small_title'];?>" /></div>
                            </div>
                             <div class="mgb20 f_cs">     
                                <p class="list_tit fz17 fw500">신청날짜</p>
                                <div class="f_cs">
                                    <input type="text" name="event_start_date_01" id="sdate1" class="narrow" value="<?=$out_row['event_start_date_01'];?>" />
                                     ~ 
                                    <input type="text" name="event_start_date_02" id="sdate2" class="narrow" value="<?=$out_row['event_start_date_02'];?>" />
                                </div>
                            </div>
                             <div class="mgb25 f_cs">
                                <p class="list_tit fz17 fw500">발표날짜</p>
                                <div class="input_chk f_cs">
                                    <input type="text" name="event_end_date" id="edate1" value="<?=$out_row['event_end_date'];?>" class="mgr20"/>
                                    <input type="checkbox" id="end_date_person" value="1" <?=$out_row['event_end_date']=="개별연락"?"checked":""?> /><label for="end_date_person" class="input_chk_label f_sc">개별연락</label>
                                </div>
                            </div>
                             <!-- 뮤자인 삭제
                             <div class="mgb25 f_cs">
                                <p class="list_tit fz17 fw500">발표여부</p>
                                <div class="input_chk f_cs">
                                    <input type="checkbox" name="event_notice" id="event_notice" value="1" <?php /*=$out_row['event_notice']=="1"?"checked":""*/?>  />
                                    <label for="event_notice" class="input_chk_label">당첨자 발표(아이콘)</label>
                                </div>
                            </div>
                            -->
                             <div class="mgb20 f_cs">     
                                <p class="list_tit fz17 fw500">공개여부</p>
                                <div>
                                    <div class="input_radio"><input type="radio" name="hero_use" id="use1" value="1" <?=$out_row['hero_use']==1?"checked":""?> /><label for="use1">공개</label></div>
                                    <div class="input_radio"><input type="radio" name="hero_use" id="use2" value="0" <?=$out_row['hero_use']==0?"checked":""?>/><label for="use2">비공개</label></div>
                                </div>
                            </div>
                            <link type='text/css' href='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.css' rel='stylesheet' />
                            <script type="text/javascript" src="<?=DOMAIN_END?>cal/jquery.min.js"></script>
                            <script type='text/javascript' src='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.min.js'></script>
                            <script>
                                $(function() {      // window.onload 대신 쓰는 스크립트
                                    dateclick2();
                                    dateclick3();

                                    $("#end_date_person").change(function(){
                                        if($(this).is(":checked")) {
                                            $("#edate1").val("개별연락");
                                        }else {
                                            $("#edate1").val("");
                                        }
                                    })
                                });
                                function dateclick2(){
                                    var dates = $("#sdate1, #sdate2").datepicker({
                                        monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
                                        dayNames: ['일', '월', '화', '수', '목', '금', '토'],
                                        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
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
                                        monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
                                        dayNames: ['일', '월', '화', '수', '목', '금', '토'],
                                        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
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
                        <!-- 카테고리 -->
                            <?if($board=="cus_2" || $board=="group_04_33" || $board=="group_04_34"){ ?>
                                <div class="category mgb20 f_cs">
                                    <p class="list_tit fz17 fw500">카테고리</p>
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
                                <p class="list_tit fz17 fw500">카테고리</p>
                                <td>
                                    <div class="input_radio"><input type="radio" name="gubun" id="gubun_2" value="2" <?=$out_row['gubun']=="2" ? "checked":""?>><label for="gubun_2">체험단&서포터즈</label></div>
                                    <div class="input_radio"><input type="radio" name="gubun" id="gubun_3" value="3" <?=$out_row['gubun']=="3" ? "checked":""?>><label for="gubun_3">제품 제안</label></div>
                                    <div class="input_radio"><input type="radio" name="gubun" id="gubun_1" value="1" <?=$out_row['gubun']=="1" ? "checked":""?>><label for="gubun_1">일상 공유</label></div>
                                </td>
                            </div>
                            <? } else if($board=="group_04_03") { ?>
                                <div class="category mgb20 f_cs">
                                    <p class="list_tit fz17 fw500">카테고리</p>
                                    <td>
                                        <div class="input_radio"><input type="radio" name="gubun" id="gubun_1" value="1" <?=$out_row['gubun']=="1" ? "checked":""?>><label for="gubun_1">필독</label></div>
                                        <div class="input_radio"><input type="radio" name="gubun" id="gubun_2" value="2" <?=$out_row['gubun']=="2" ? "checked":""?>><label for="gubun_2">안내</label></div>
                                        <div class="input_radio"><input type="radio" name="gubun" id="gubun_3" value="3" <?=$out_row['gubun']=="3" ? "checked":""?>><label for="gubun_3">이벤트</label></div>
                                        <div class="input_radio"><input type="radio" name="gubun" id="gubun_4" value="" <?=!$out_row['gubun'] ? "checked":""?>><label for="gubun_4">미지정</label></div>
                                    </td>
                                </div>
                            <? } else if($board=="group_04_24") {?>
                                <div class="category mgb20 f_cs">                            
                                    <p class="list_tit fz17 fw500">카테고리</p>
                                        <div class="input_radio">
                                            <input type="radio" name="hero_keywords" id="hero_keywords_1" value="1" <?=$out_row['hero_keywords']=="1" ? "checked":""?>><label for="hero_keywords_1">리뷰</label>
                                        </div>
                                        <div class="input_radio">
                                            <input type="radio" name="hero_keywords" id="hero_keywords_2" value="2" <?=$out_row['hero_keywords']=="2" ? "checked":""?>><label for="hero_keywords_2">활동</label>
                                        </div>
                                        <div class="input_radio">
                                            <input type="radio" name="hero_keywords" id="hero_keywords_3" value="3" <?=$out_row['hero_keywords']=="3" ? "checked":""?>><label for="hero_keywords_3">리뷰 TIP</label>
                                        </div>
                                        <div class="input_radio">
                                            <input type="radio" name="hero_keywords" id="hero_keywords_4" value="4" <?=$out_row['hero_keywords']=="4" ? "checked":""?>><label for="hero_keywords_4">매체 TIP</label>
                                        </div>
                                        <div class="input_radio">
                                            <input type="radio" name="hero_keywords" id="hero_keywords_5" value="" <?=!$out_row['hero_keywords'] ? "checked":""?>><label for="hero_keywords_5">미지정</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="category mgb20 f_cs">                                     
                                    <p class="list_tit fz17 fw500">카테고리</p>
                                    <div class="input_radio">
                                        <div class="input_radio"><input type="radio" name="gubun" id="gubun_1" value="1" <?=$out_row['gubun']=="1" ? "checked":""?>><label for="gubun_1">필독</label></div>
                                        <div class="input_radio"><input type="radio" name="gubun" id="gubun_2" value="2" <?=$out_row['gubun']=="2" ? "checked":""?>><label for="gubun_2">블로그</label></div>
                                        <div class="input_radio"><input type="radio" name="gubun" id="gubun_3" value="3" <?=$out_row['gubun']=="3" ? "checked":""?>><label for="gubun_3">인스타</label></div>
                                        <div class="input_radio"><input type="radio" name="gubun" id="gubun_4" value="4" <?=$out_row['gubun']=="4" ? "checked":""?>><label for="gubun_4">유튜브&영상</label></div>
                                        <div class="input_radio"><input type="radio" name="gubun" id="gubun_5" value="" <?=!$out_row['gubun'] ? "checked":""?>><label for="gubun_5">미지정</label></div>
                                    </div>
                                </div>
<!--                            --><?// } else if($board=="cus_3" || $board=="group_04_35") {?>
                            <? } else if($board=="cus_3") {?>
                                <div class="category mgb20 f_cs">
                                    <p class="list_tit fz17 fw500">카테고리</p>
                                    <div class="input_radio">
                                        <div class="input_radio"><input type="radio" name="gubun" id="gubun_1" value="1" <?=$out_row['gubun']=="1" ? "checked":""?>><label for="gubun_1">체험단 문의</label></div>
                                        <div class="input_radio"><input type="radio" name="gubun" id="gubun_2" value="2" <?=$out_row['gubun']=="2" ? "checked":""?>><label for="gubun_2">체험단 후기수정</label></div>
                                        <div class="input_radio"><input type="radio" name="gubun" id="gubun_3" value="3" <?=$out_row['gubun']=="3" ? "checked":""?>><label for="gubun_3">홈페이지 문의</label></div>
                                        <div class="input_radio"><input type="radio" name="gubun" id="gubun_4" value="4" <?=$out_row['gubun']=="4" ? "checked":""?>><label for="gubun_4">기타</label></div>
                                    </div>
                                </div>
                            <? } else if ($board=="group_04_35"){?>
                                <div class="category mgb20 f_cs">
                                    <p class="list_tit fz17 fw500">카테고리</p>
                                    <div class="input_radio cateselect">
                                        <div class="input_radio"><input type="radio" name="b_gubun" id="b_gubun_1" value="100"><label for="b_gubun_1">체험단</label></div>
                                        <div class="input_radio"><input type="radio" name="b_gubun" id="b_gubun_2" value="200"><label for="b_gubun_2">이벤트/포인트 페스티벌</label></div>
                                        <div class="input_radio"><input type="radio" name="b_gubun" id="b_gubun_3" value="300"><label for="b_gubun_3">홈페이지</label></div>
                                        <div class="input_radio"><input type="radio" name="b_gubun" id="b_gubun_4" value="4"><label for="b_gubun_4">기타</label></div>
                                    </div>
                                </div>
                                <div class="category f_cs">
                                    <p class="list_tit fz17 fw500 screen_out">[체]중유형</p>
                                    <div class="subcategory depht2 subcategory_100">
                                        <div class="rel selcet_wrap">
                                            <select name="m_gubun100" id="m_gubun100" class="wr_select">
                                                <option value="110">선정 취소 및 제품 변경</option>
                                                <option value="120">제품 배송 및 파손 확인</option>
                                                <option value="130">콘텐츠 문의</option>
                                                <option value="140">슈퍼패스 문의</option>
                                                <option value="150">패널티 문의</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="subcategory depht3 subcategory_100 subcategory_110">
                                        <div class="rel selcet_wrap">
                                            <select name="s_gubun110" id="s_gubun110" class="wr_select">
                                                <option value="111">선정 취소 요청</option>
                                                <option value="112">체험 제품 변경 요청</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="subcategory depht3 subcategory_120">
                                        <div class="rel selcet_wrap">
                                            <select name="s_gubun120" id="s_gubun120" class="wr_select">
                                                <option value="121">[배송] 배송 확인 요청</option>
                                                <option value="122">[배송] 제품 확인 요청</option>
                                                <option value="123">[배송] 제품 회수 요청</option>
                                                <option value="124">[배송] 제품 파손 신고</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="subcategory depht3 subcategory_130">
                                        <div class="rel selcet_wrap">
                                            <select name="s_gubun130" id="s_gubun130" class="wr_select">
                                                <option value="131">홈페이지 후기 등록 방법 문의</option>
                                                <option value="132">후기 등록 기간 연장 문의</option>
                                                <option value="133">수정후기 전달</option>
                                                <option value="134">가이드라인 관련 문의</option>
                                                <option value="135">공정위배너/문구 문의</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="subcategory depht3 subcategory_140">
                                        <div class="rel selcet_wrap">
                                            <select name="s_gubun140" id="s_gubun140" class="wr_select">
                                                <option value="141">슈퍼패스 문의</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="subcategory depht3 subcategory_150">
                                        <div class="rel selcet_wrap">
                                            <select name="s_gubun150" id="s_gubun150" class="wr_select">
                                                <option value="151">패널티 문의</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="category f_cs">
                                    <p class="list_tit fz17 fw500 screen_out">[이]중유형</p>
                                    <div class="subcategory depht2 subcategory subcategory_200">
                                        <div class="rel selcet_wrap">
                                            <select name="m_gubun200" id="m_gubun200" class="wr_select">
                                                <option value="210">당첨 문의</option>
                                                <option value="220">상품 및 배송 확인</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="f_cs subcategory depht3 subcategory_200 subcategory_210">
                                        <div class="rel selcet_wrap">
                                            <select name="s_gubun210" id="s_gubun210" class="wr_select">
                                                <option value="211">이벤트 당첨 문의</option>
                                                <option value="212">이벤트 당첨 제품 문의</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="f_cs subcategory depht3 subcategory_220">
                                        <div class="rel selcet_wrap">
                                            <select name="s_gubun220" id="s_gubun220" class="wr_select">
                                                <option value="221">[배송] 배송 확인 요청</option>
                                                <option value="222">[배송] 제품 확인 요청</option>
                                                <option value="223">[배송] 제품 회수 요청</option>
                                                <option value="224">[배송] 제품 파손 신고</option>
                                                <option value="225">[누락] 제품 누락 신고</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="category f_cs">
                                    <p class="list_tit fz17 fw500 screen_out">[홈]중유형</p>
                                    <div class="subcategory subcategory_300">
                                        <div class="rel selcet_wrap">
                                            <select name="m_gubun300" id="m_gubun300" class="wr_select">
                                                <option value="310">홈페이지 이용</option>
                                            </select>
                                        </div>
                                    </div>    
                                    <div class="subcategory subcategory_300">
                                        <div class="rel selcet_wrap">
                                            <select name="s_gubun310" id="s_gubun310" class="wr_select">
                                                <option value="311">서비스 개선/오류 문의</option>
                                                <option value="312">개인정보/이용방법 문의</option>
                                                <option value="313">부정회원 신고</option>
                                                <option value="314">기타 문의</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>     
                                <script>
                                    $(document).ready(function(){
                                        // 대분류 클릭시 
                                        $('.subcategory').hide();
                                        const subcategory = $('.subcategory');
                                        $('.cateselect input').on('click', function() {
                                            $('.subcategory').hide(); 
                                            $('.subcategory_' + $(this).val()).show(); // 선택된 하위 카테고리 표시
                                        });
                                        // 중분류 클릭시 
                                        const subcategory2 = $('.depht2 select');
                                        subcategory2.on('change', function() {
                                            $('.subcategory').not('.depht2').hide(); 
                                            $('.subcategory_' + $(this).val()).show(); // 선택된 하위 카테고리 표시
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
                                        <p class="fz13 op05">* URL은 한줄에 하나씩 전체 주소(HTTP:// 또는 HTTPS://)를 넣어주세요</p>
                                        <textarea id="hero_04" name="hero_04"><?=$out_row['hero_04'];?></textarea>
                                    </div>
                                </div>
                            <?}?>                                                 
                            <!-- 작성 에디터 -->
                            <textarea id="editor" name="command">
                                <?=$out_row['hero_command']?>
                            </textarea>
                            <!-- 에디터 썸네일 설정 -->
                            <div class="thumnail mgb20" <? if($board!='group_02_03' && $board!='group_02_10'){?>style="display:none"<? } ?>>
                                <div>
                                    <div><img src="/image/bbs/guide_thumb.gif" /></div>
                                    <div style="background: #F2F2F2; margin-bottom: 10px;">
                                        <div id="thumbnailView" class="scroll f_cs"></div>
                                    </div> 
                                </div>
                            </div>
                            <!-- 대표 이미지 업로드 -->
                            <?if($_SESSION['temp_level']>=9999 && $board=="group_04_22") {?>
                                <div class="thum_file upfile f_cs mgb20">
                                    <p class="list_tit fz17 fw500">대표 이미지</p>
                                    <div>                                                                                   
                                        <div id="present_image_area">
                                            <? if($hero_thumb){ ?>
                                                <img src="<?=$hero_thumb?>" style="width:200px;margin-top:10px;"><br/>
                                            <? } ?>
                                        </div>
                                        <div class="rel"> 
                                            <input type="hidden" id="hero_thumb" name="hero_thumb" value="<?=$hero_thumb?>"/>
                                            <label for="write_hero_thumb" id="link" class="custom-file-upload">이미지 업로드<img src="/img/front/icon/fileup.webp" alt="첨부파일 업로드"></label>
                                        </div>
                                        <p class="fz15 op05">* 10MB 이하로 업로드해 주세요.</p>
                                    </div>
                                </div>
                            <? } ?>
                            <!-- 첨부파일 -->
                            <? if($_GET["board"] != "group_04_29"){?>
                                <div class="upfile f_cs">
                                    <p class="list_tit fz17 fw500">첨부파일</p>
                                    <div class="upfile_inner rel">
                                        <input type="file" id="hero_board_one" name="hero_board_one[]" title="첨부파일" value="<?=$out_row['hero_board_one'];?>" />
                                        <label for="hero_board_one" class="custom-file-upload">첨부파일<img src="/img/front/icon/fileup.webp" alt="첨부파일 업로드"></label>
                                        <?if($_GET['action'] == 'update' && $out_row['hero_board_one'] != ''){//수정이고 첨부파일이 있으면?>
                                          <!-- 2024-10-22 업로드된 첨부파일 삭제 기능 요청 - musign YDH -->
                                          <input type="hidden" id="hero_board_two" name="hero_board_two" value="<?=$out_row['hero_board_two']?>">
                                          <span id="hero_board_two_ori">첨부파일명: <?=$out_row['hero_board_two']?></span>
                                          <a href="javascript:rm_files();" class="delete_btn"> 삭제</a>
                                        <?}?>
                                    </div>
                                </div>
                                <div class="warn">                                        
                                    <p class="fz15 op05">* jpg, jpeg, gif, png, bmp, zip, hwp, ppt, xls, doc, txt, pdf, xlsx, pptx, docx 파일을 2MB 이하로만 첨부가 가능합니다.</p>
                                    <p class="fz15 op05">* 첨부된 파일은 전체 이용자가 다운로드 받을 수 있으니 주의하시기 바랍니다.</p>
                                </div>
                            <? } ?>                            
                            <!-- 대표이미지 업로드 -->
                    </div>
                    <? include_once BOARD_INC_END.'button2.php';?>
                </form>
        </div>    
        </div>    
    </div>
</div>
</div>

<form action="/main/zip_thumb.php" id="write2_file_upload" enctype="multipart/form-data" method="post" >
    <input type="file" name="thumbImage" id="write_hero_thumb" title="이미지" style="position: absolute; left: -9999em;"/>
</form>

<script type="text/javascript" src="/loak/loak.js?v=1"></script>
<script src="/js/jquery.form.js"></script>
<script type="text/javascript">
    function rm_files(){ //파일 제거
        $("#hero_board_two").val('');
        $("#hero_board_two_ori").text('');
    }

    var myeditor = new cheditor();              // 에디터 개체를 생성합니다.
    myeditor.config.editorHeight = '300px';     // 에디터 세로폭입니다.
    myeditor.config.editorWidth = '100%';        // 에디터 가로폭입니다.

    <? if($_GET["board"] == "group_02_02") {?>
    myeditor.config.oncontextmenu = false;
    <? } ?>
    myeditor.inputForm = 'editor';             // textarea의 id 이름입니다. 주의: name 속성 이름이 아닙니다.
    myeditor.run();                             // 에디터를 실행합니다.
    <? if($_GET['action'] == 'write') {?>
    var editorText = '내용을 입력해주세요';
    <? } ?>

    $(document).ready(function(){
        document.frm.hero_title.focus();
        <?php
        ## 러버 아이디어 카테고리
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
                    //클릭할때마다 내용 지워져서 처음에만 내용 삭제
                    if($('.cheditor-editarea').contents().find('body').text() == '내용을 입력해주세요')
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

            // 익스플로러일 경우
            if (browser=="Microsoft Internet Explorer") {
                var oas = new ActiveXObject("Scripting.FileSystemObject");
                fileSize = oas.getFile( filename ).size;
            } else {
                fileSize = file.files[0].size;
            }

            if(maxSize < fileSize) {
                alert("이미지 용량초과입니다.\n10MB이하로 업로드를 진행해 주세요.");
                return false;
            }

            var options=
                {
                    success: function(data){
                        if(data=='0'){
                            alert("죄송합니다. 이미지 업로드 오류입니다. 다시 시도해주세요. 같은 현상이 반복될 경우 고객센터에 문의해주세요.");
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
                        alert("죄송합니다. 이미지 업로드 오류입니다. 다시 시도해주세요. 같은 현상이 반복될 경우 고객센터에 문의해주세요.");
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

        // 익스플로러일 경우
        if (browser=="Microsoft Internet Explorer") {
            var oas = new ActiveXObject("Scripting.FileSystemObject");
            fileSize = oas.getFile( filename ).size;
        } else {
            fileSize = file.files[0].size;
        }

        if(maxSize < fileSize) {
            alert("이미지 용량초과입니다.\n2MB이하로 업로드를 진행해 주세요.");
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
            alert("제목을 입력하세요.");
            title.style.border = '1px solid red';
            title.focus();
            return false;
        }else{
            title.style.border = '';
        }

        <? if($board=="group_02_02" || $board=="group_04_24" || $board=="cus_3") {//카테고리 있는 메뉴?>
        if(!$("input:radio[name='gubun']").is(":checked")) {
            alert("카테고리를 선택해주세요.");
            return false;
        }
        <? }else if($board=="group_04_35") { ?>
        if(!$("input:radio[name='b_gubun']").is(":checked")) {
            alert("카테고리를 선택해주세요.");
            return false;
        }
        <? }?>

        if(cmd_len_check == ""){
            alert("내용을 입력하세요.");
            return false;
        }


        if(cmd_len_check.length < 5) {
            alert("5글자 미만의 글을 작성 불가합니다.");
            return false;
        }

        hero_table.disabled = false;

        if(hero_table.value==''){
            alert("카테고리가 설정되지 않았습니다. 잘못된 접근으로 인한 오류입니다. 다시 시도해 주세요.");
            location.href="/main/index.php";
            return false;
        }

        <?php if($board=="group_03_04"){?>
        var hero_05 	=	 theform.hero_05;
        if(hero_05.value==''){
            alert("아이디어 종류를 선택해주세요.");
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
                    alert("첨부파일 확장자를 확인해주세요");
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
            alert('올린 이미지가 없습니다.');
            return;
        }
        for (var i=0; i<data.length; i++) {
            var str = 'URL: ' + data[i].fileUrl + "\n";
            str += '저장 경로: ' + data[i].filePath + "\n";
            str += '원본 이름: ' + data[i].origName + "\n";
            str += '저장 이름: ' + data[i].fileName + "\n";
            str += '크기: ' + data[i].fileSize;
            alert(str);
        }
    }
</script>
