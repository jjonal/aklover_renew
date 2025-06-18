<?
include_once "head.php";
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
//로그인 이용가능
if (!$_SESSION ['temp_level']){
    error_location("권한이 없습니다.","/m/main.php?board=login");
    exit;
}

######################################################################################################################################################
$cut_count_name = '6';
$cut_title_name = '32';

$list_page=5;
$page_per_list=5;

$today = date("Y-m-d");

if(!is_numeric($_GET['page']))		$page = 1;
else								$page = $_GET['page'];

$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board'].$search_next;

$code = $_SESSION['temp_code'];
$board = $_GET['board'];
######################################################################################################################################################
if($_GET['kewyword']){
    $search = " and ".$_GET['select']." like '%".$_GET['kewyword']."%'";
    $search_next = "&select=".$_GET['select']."&kewyword=".$_GET['kewyword'];
}
// 24.06.19 https://app.asana.com/0/1207585762197898/1207597939373068/f 요청에 따라 검색기간 추가
if($_GET['date-from']){
    $search .= "AND DATE_FORMAT(B.hero_today,'%Y-%m-%d') between DATE_FORMAT('".$_GET['date-from']."','%Y-%m-%d') and DATE_FORMAT('".$_GET['date-to']."','%Y-%m-%d')";
    $search_next .= "&date-from=".$_GET['date-from']."&date-to=".$_GET['date-to'];
}
if($_GET['lot_01']){
    $search = " and B.lot_01 = '".$_GET['lot_01']."'";
    $search_next = "&lot_01=".$_GET['lot_01'];
}

######################################################################################################################################################
$error = "MISSION_01";
$main_sql = "select count(*) from mission as A inner join (select hero_code,hero_old_idx, lot_01, hero_today from mission_review where hero_code='".$code."') as B on B.hero_old_idx=A.hero_idx inner join (select hero_code, hero_nick from member where hero_code='".$code."') as C on B.hero_code=C.hero_code where 1=1 ".$search."";

$main_res = new_sql($main_sql,$error,"on");

if((string)$main_res==$error){
    error_historyBack("");
    exit;
}

$total_data = mysql_result($main_res,0,0);
######################################################################################################################################################
$error = "MISSION_02";
$sql = "select * from hero_group where hero_order!=0 and hero_board ='".$board."'";//desc
$right_res = new_sql($sql,$error);
if((string)$right_res==$error){
    error_historyBack("");
    exit;
}

$right_list                             = @mysql_fetch_assoc($right_res);
######################################################################################################################################################
?>
<link href="css/musign/cscenter.css" rel="stylesheet" type="text/css">
<link href="css/musign/board.css" rel="stylesheet" type="text/css">
<!--컨텐츠 시작-->
	<div id="subpage" class="mypage">	
		<div class="my_top off">    
			<div class="sub_title">       
				<div class="sub_wrap">  
					<div class="btn_back f_cs" onclick="goBack()"><img src="/m/img/musign/main/hd_back.webp" alt="뒤로 가기"></div>   
					<h1 class="fz36">나의 체험단</h1>       
				</div>
			</div>  
			<? include_once "mypage_top.php";?> 
		</div>    		
		<div class="boardTabMenuWrap">
			<a href="/m/mysupport.php?board=mission" class="<?=$_GET['lot_01'] != 1 ? "on":""?>">신청한 체험단</a>
			<a href="/m/mysupport.php?board=mission&lot_01=1" class=" <?=$_GET['lot_01'] == 1 ? "on":""?>">당첨된 체험단</a>
		</div>
	</div>
    <div class="date_ver mysupport rel">
        <? include_once 'searchBox.php';?>  
        <div class="mo mo_cal screen_out">모바일날짜선택아이콘</div>	      
    </div>
    <div class="my_support_list_wrap">
        <?
        $error = "MISSION_03";
        $sql="select A.hero_idx, A.hero_table, A.hero_title, A.hero_kind, A.hero_today_01_01, A.hero_today_01_01, A.hero_today_02_01, A.hero_today_02_02, ";
        $sql.="A.hero_today_03_01, A.hero_today_03_02, A.hero_today_04_01, A.hero_today_04_02, A.hero_thumb, A.hero_type, B.hero_idx as review_idx, B.lot_01, B.hero_today ";
//        $sql.="(select count(*) from board where hero_01 = A.hero_idx and hero_table = A.hero_table and hero_code = '".$code."' and lot_01 = 1) review_check";
        $sql.="from mission as A inner join (select hero_idx, hero_code,hero_old_idx, lot_01, hero_today from mission_review where hero_code='".$code."') as B on A.hero_idx=B.hero_old_idx ";
        $sql.="inner join (select hero_code,hero_nick from member where hero_code='".$code."') as C on B.hero_code=C.hero_code where 1=1 ".$search." ";
        $sql.="order by CASE WHEN (hero_today_01_01<='".$today." 00:00:00"."' and hero_today_01_02>='".$today." 00:00:00"."') THEN hero_today_01_02 END desc, ";
        $sql.="CASE WHEN (hero_today_02_01<='".$today." 00:00:00"."' and hero_today_02_02>='".$today." 00:00:00"."') THEN hero_today_02_02 END desc, ";
        $sql.="CASE WHEN (hero_today_03_01<='".$today." 00:00:00"."' and hero_today_03_02>='".$today." 00:00:00"."') THEN hero_today_03_02 END desc, ";
        $sql.="CASE WHEN (hero_today_04_01<='".$today." 00:00:00"."' and hero_today_04_02>='".$today." 00:00:00"."') THEN hero_today_04_02 END desc, ";
        $sql.="CASE WHEN (hero_today_04_02<='".$today." 00:00:00"."') THEN hero_today_04_02 END desc ";
        $sql.="limit ".$start.",".$list_page.";";

        //echo $sql;

        $main_res = new_sql($sql,$error);
        if((string)$main_res==$error){
            error_historyBack("");
            exit;
        }

        $i=0;
        while($list                             = @mysql_fetch_assoc($main_res)){
            $reviwer_tf = "";
            $board_title = "";
            $num=$total_data - $start-$i;
            $i++;

            //후기등록 여부 - 콘텐츠 상세에서 가져옴
            $new_sql = 'select * from board where hero_table = \'' . $list ['hero_table'] . '\' and hero_code=\'' . $_SESSION ['temp_code'] . '\' and hero_01=\'' . $list ['hero_idx'] . '\'';
            $view_new_sql = mysql_query ( $new_sql );
            $new_count = mysql_num_rows ( $view_new_sql );
            $new_res = mysql_fetch_assoc($view_new_sql);

            //후기등록 버튼 로직추가 240926 YDH
            $review_button = '';
            if(substr($list["hero_today_04_02"],0,10)<$today){ //우수후기 발표 < 오늘
                $progress = "체험단 마감";
                // $href = "javascript:alert(\"마감된 체험단입니다.\")";
                // 마감된 체험단도 접속 가능하게 요청하여 변경 조치
                $href = "/m/mission_view.php?board=".$list['hero_table']."&mission_idx=".$list['hero_idx'];
                if($list['lot_01']==1){

                    $error = "MISSION_04";
                    $board_sql = "select hero_idx, hero_table, hero_title from board where hero_code='".$code."' and hero_01='".$list['hero_idx']."'";
                    $board_res = new_sql($board_sql,$error);
                    if((string)$board_res==$error){
                        error_historyBack("");
                        exit;
                    }

                    $borad_count = mysql_num_rows($board_res);
                    if($borad_count>0){
                        $board_rs	= mysql_fetch_assoc($board_res);
                        if($board_rs['hero_board_three']==1)	$reviwer_tf = "<font color=red class='fontStrong'>[우수후기 당첨]</font>";
                        $board_title = "<a href='http://www.aklover.co.kr/main/index.php?board=".$board_rs['hero_table']."&view=view2&idx=".$board_rs['hero_idx']."' target='_blank'><img src='/img/front/mypage/thum.jpg'><div class='txt_bx'><p class='ribon'>프리미어 뷰티 클럽</p><p class='tit'>[후기] ".cut($board_rs['hero_title'],$cut_title_name)."</p></div></a>";
                    }
                }
            }
            //240926 musign 수정 YDH - 일정 조건 체험단이랑 동일하게 수정
            //우수후기 발표 시작일 <= 오늘 && 우수후기 발표 종료일 >= 오늘
            elseif(substr($list["hero_today_04_01"],0,10)<=$today && substr($list["hero_today_04_02"],0,10)>=$today){
                $progress = "우수후기 발표";
//                $href = "/m/board_01.php?board=".$list['hero_table']."&best=true&idx=".$list['hero_idx'];
                //250320 musign 수정 YDH - 진행상태 구분없이 체험단 페이지로 이동
                $href = "/m/mission_view.php?board=".$list['hero_table']."&hero_idx=&mission_idx=".$list['hero_idx'];
                
                if($list['lot_01']==1){
                    $error = "MISSION_04";
                    $board_sql = "select hero_idx, hero_table, hero_title from board where hero_code='".$code."' and hero_01='".$list['hero_idx']."' and hero_board_three=1";
                    $board_res = new_sql($board_sql,$error);
                    if((string)$board_res==$error){
                        error_historyBack("");
                        exit;
                    }

                    $borad_count = mysql_num_rows($board_res);
                    if($borad_count>0){
                        $board_rs	= mysql_fetch_assoc($board_res);
                        $reviwer_tf = "<font color=red>[우수후기 당첨]</font>";
                        $board_title = "<a href='http://www.aklover.co.kr/main/index.php?board=".$board_rs['hero_table']."&view=view2&idx=".$board_rs['hero_idx']."' target='_blank'><img src='/img/front/mypage/thum.jpg'><div class='txt_bx'><p class='ribon'>프리미어 뷰티 클럽</p><p class='tit'>[후기]  ".cut($board_rs['hero_title'],$cut_title_name)."</p></div></a>";
                    }
                }

                $review_button = '<span>콘텐츠 등록 기간 마감</span>';
            }
            //후기등록 시작일 <= 오늘 && 후기등록 종료일 >= 오늘
            elseif(substr($list["hero_today_03_01"],0,10)<=$today && substr($list["hero_today_03_02"],0,10)>=$today){
                $progress = "후기 등록";
                $href = "/m/mission_view.php?board=".$list['hero_table']."&hero_idx=&mission_idx=".$list['hero_idx'];

                if($list['lot_01']==1){
                    $reviwer_tf = "<font color=orange class='fontStrong'>[체험단 선정]</font>";
                    $error = "MISSION_04";
                    $board_sql = "select hero_idx, hero_table, hero_title, hero_board_three from board where hero_code='".$code."' and hero_01='".$list['hero_idx']."'";
                    $board_res = new_sql($board_sql,$error);
                    if((string)$board_res==$error){
                        error_historyBack("");
                        exit;
                    }

                    $borad_count = mysql_num_rows($board_res);
                    if($borad_count>0){
                        $board_rs	= mysql_fetch_assoc($board_res);

                        $href = "/m/mission_view.php?board=".$list['hero_table']."&hero_idx=&mission_idx=".$list['hero_idx'];
                        $board_title = "<a href='http://www.aklover.co.kr/main/index.php?board=".$board_rs['hero_table']."&view=view2&idx=".$board_rs['hero_idx']."'  target='_blank'><img src='/img/front/mypage/thum.jpg'><div class='txt_bx'><p class='ribon'>프리미어 뷰티 클럽</p><p class='tit'>[후기]  ".cut($board_rs['hero_title'],$cut_title_name)."</p></div></a>";
                    }else{
                        $reviwer_tf = "<font color=red class='fontStrong'>[체험단 선정]</font>";
                    }
                }

                $review_button = '<span>콘텐츠 등록 기간 마감</span>';

                if (! strcmp ( $new_count, '0' )) {
                    $review_button = '<a href="/m/mission_write.php?board='.$list['hero_table'].'&idx='.$list['hero_idx'].'&action=write"><img src="/img/front/board/icon_create.png" alt="후기등록" /></a>';
                }else {
                    if($list['hero_type'] == 2) { //소문내기
                        $review_button = '<a href="/m/mission_write.php?board=group_04_05&hero_idx='.$list['review_idx'].'&idx='.$list['hero_idx'].'&action=update&pre_board=group_04_09"><img src="/img/front/board/icon_update.png" alt="후기수정" /></a>';
                        $review_button .= '<a href="javascript:;" onClick="delPostscript(\''.$list['hero_table'].'\',\''.$list['hero_idx'].'\',\''.$new_res['hero_idx'].'\')"><img src="/img/front/board/icon_delete.png" alt="후기삭제" /></a>';
                    }else{
                        $review_button = '후기 등록일: ' . substr($new_res['hero_today'], 0, 10);
                        $review_button .= "<a href=\"/m/mission_write.php?board=".$list['hero_table']."&hero_idx=".$new_res['hero_idx']."&idx=".$list['hero_idx']."&action=update&pre_board=group_04_09\"><img src='/img/front/board/icon_update.png' alt='후기수정' /></a>";
                        $review_button .= '<a href="javascript:;" onClick="delPostscript(\''.$list['hero_table'].'\',\''.$list['hero_idx'].'\',\''.$new_res['hero_idx'].'\')"><img src="/img/front/board/icon_delete.png" alt="후기삭제" /></a>';
                    }
                }
            }
            //당첨자 발표 시작일 <= 오늘 && 당첨자 발표 종료일 >= 오늘
            elseif(substr($list["hero_today_02_01"],0,10)<=$today && substr($list["hero_today_02_02"],0,10)>=$today){
                $progress = "선정자 발표";
//                $href = "/m/mission_win_list.php?board=".$list['hero_table']."&idx=".$list['hero_idx'];
                //250320 musign 수정 YDH - 진행상태 구분없이 체험단 페이지로 이동
                $href = "/m/mission_view.php?board=".$list['hero_table']."&hero_idx=&mission_idx=".$list['hero_idx'];

                if($list["lot_01"]==1)		$reviwer_tf = "<font color=orange class='fontStrong'>[체험단 선정]</font>";

                $review_button  = '';
            }
            else{
                $progress = "체험단 신청";
                $href = "/m/mission_view.php?board=".$list['hero_table']."&mission_idx=".$list['hero_idx'];

                $review_button  = '';
            }

            /* class 뷰티일 경우 type1, 라이프 type2, 멀티 type3 넣어주세요 */
            if($list['hero_table'] == 'group_04_05'){
                $type = "<p class='club fz24 c_white type3'>베이직 뷰티&라이프 클럽</p>";
            }else if($list['hero_table'] == 'group_04_06'){
                $type = "<p class='club fz24 c_white type1'>프리미어 뷰티 클럽</p>";
            }else if($list['hero_table'] == 'group_04_28'){
                $type = "<p class='club fz24 c_white type2'>프리미어 라이프 클럽</p>";
            }

            $mission_title  = "<a href='".$href."' class='board_title'><img src='".$list['hero_thumb']."'><div class='txt_bx'>".$type."<p class='tit'>".cut($list['hero_title'],$cut_title_name)."</p></div></a>";
            ?>
            <div class="my_support_list f_cs">
                <p class="num fz22"><?=$num?></p>
                <? if($list['hero_thumb'] != '') { ?>
                    <a href="<?=$href?>"><img src="<?=$list['hero_thumb']?>" alt="체험단 썸네일" class="thum_img"></a>
                <?}else { ?>
                    <img src="/m/img/musign/main/tab01.webp" alt="체험단 썸네일" class="thum_img">
                <?}?>
                <div class="info">
                    <div>
                        <div class="sub_top f_cs">
                            <!-- class 뷰티일 경우 type1, 라이프 type2, 멀티 type3 넣어주세요  -->
                            <?=$type?>
                            <p class="cate fz24 mu_bar"><?=$list['hero_kind']?></p>
                        </div>
                        <div class="tit ellipsis_2line fz28 fw600">
                            <?=cut($list['hero_title'],$cut_title_name)?><br>
                            <?=$reviwer_tf?>
                        </div>
                    </div>
                    <div class="date fz24">체험단 신청일 :<?=date( "Y.m.d", strtotime($list['hero_today']));?></div>
                    <div class="review_btn f_cl"><?=$review_button;?></div>
                </div>
            </div>
        <?}?>
    </div>
    <script>
        function delPostscript(board, idx, hero_idx) {

            if(confirm('삭제하시겠습니까?')==true){
                var url = "/m/mission_write_proc.php";
                var data = {
                    board: board,
                    action: 'delete',
                    idx: idx,
                    hero_idx: hero_idx
                };

                $.ajax({
                    type: 'GET',
                    url: url,
                    data: data,
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr, status, error) {

                    }
                });
            }
        }
    </script>
	<div id="page_number" class="paging">
        <?include_once "page.php"?>
    </div>		
<?include_once "tail.php";?>