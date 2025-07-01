<?

//검색폼
$search = "";

$select_03 = $_REQUEST['select_03'];
//날짜 검색
if($_GET["startDate2"] && $_GET["endDate2"]) {
    $search .= " AND (
        A.hero_today_01_01 BETWEEN '".$_GET['startDate2']."' AND '".$_GET['endDate2']."'
        AND
        A.hero_today_04_02 BETWEEN '".$_GET['startDate2']."' AND '".$_GET['endDate2']."'
    )";
}

//검색어 (체험단명)
if($_GET["board_title"] != "") {
    $search .= " AND A.hero_title like '%" . $_GET["board_title"] . "%' ";
}

// 선정여부 (당첨여부)
if($_GET["lot_01"] != "") {
    $search .= " AND lot_01 like '%" . $_GET["lot_01"] . "%' ";
}


//ORDER BY
$order = ' ORDER BY A.hero_idx DESC';

//전체 갯수
$total_sql  = " SELECT count(*) cnt";
$total_sql .= " FROM mission as A ";
$total_sql .= " INNER JOIN (select hero_code,hero_old_idx, lot_01, hero_today from mission_review where hero_code='".$view["hero_code"]."') as B ";
$total_sql .= " on B.hero_old_idx=A.hero_idx inner join (select hero_code, hero_nick from member where hero_code='".$view["hero_code"]."') "; // 작은따옴표 수정
$total_sql .= " as C on B.hero_code=C.hero_code where 1=1";

$total_res = sql($total_sql,"on");
$total_rs = mysql_fetch_assoc($total_res);

$total_data3 = $total_rs['cnt'];

//$i3=$total_data3;
//검색 갯수

$search_sql  = " SELECT count(*) cnt";
$search_sql .= " FROM mission as A ";
$search_sql .= " INNER JOIN (select hero_code,hero_old_idx, lot_01, hero_today from mission_review where hero_code='".$view["hero_code"]."') as B ";
$search_sql .= " on B.hero_old_idx=A.hero_idx inner join (select hero_code, hero_nick from member where hero_code='".$view["hero_code"]."') ";
$search_sql .= " as C on B.hero_code=C.hero_code where 1=1";
$search_sql .= " AND B.hero_code = '".$view["hero_code"]."'".$search;


$search_res = sql($search_sql);
$search_row = mysql_fetch_assoc($search_res);
$search_total3 = $search_row['cnt'];


$list_page3=$_REQUEST['list_count']==""?10:$_REQUEST['list_count'];
$page_per_list3=10;

if(!strcmp($_GET['page'], '')) {
    $page3 = '1';
} else {
    $page3 = $_GET['page'];
//    $i3 = $i3-($page3-1)*$list_page3;
    $i3 = $search_total3-($page3-1)*$list_page3;
}

$start3 = ($page3-1)*$list_page3;
$next_path3=get("page");


// 전체 페이지 수 계산
$total_cnt3 = $search_total3 > 0 ? $search_total3 : $total_cnt3;
$total_page3 = ceil($total_cnt3 / $list_page3);

// 페이지 그룹의 시작과 끝 계산
$start_page3 = floor(($page3 - 1) / $page_per_list3) * $page_per_list3 + 1;
$end_page3 = $start_page3 + $page_per_list3 - 1;

// 마지막 페이지가 전체 페이지 수를 넘지 않도록 조정
if ($end_page3 > $total_page3) {
    $end_page3 = $total_page3;
}

// 이전/다음 페이지 그룹
$prev_page3 = $start_page3 - 1;
$next_page3 = $end_page3 + 1;

// URL 파라미터 처리
$query_string = $_SERVER['QUERY_STRING'];
$query_string = preg_replace('/&?page=[^&]*/', '', $query_string);

//리스트

$today = date("Y-m-d"); // 현재시간

$sql  = "SELECT A.hero_title, A.hero_table, A.hero_today_01_01, A.hero_today_01_02, 
         A.hero_today_02_01, A.hero_today_02_02, 
         A.hero_today_03_01, A.hero_today_03_02,
         A.hero_today_04_01, A.hero_today_04_02,
         B.hero_code, B.hero_old_idx, B.lot_01, B.hero_superpass, B.delivery_point_yn, B.hero_today, C.hero_nick";
$sql .= " FROM mission AS A";
$sql .= " INNER JOIN (
    SELECT hero_code, hero_old_idx, lot_01, hero_superpass, delivery_point_yn, hero_today
    FROM mission_review 
    WHERE hero_code = '".$view["hero_code"]."') AS B ON B.hero_old_idx = A.hero_idx";
$sql .= " INNER JOIN (
    SELECT hero_code, hero_nick
    FROM member
    WHERE hero_code = '".$view["hero_code"]."'
) AS C ON B.hero_code = C.hero_code";
$sql .= " WHERE 1=1 ".$search;
$sql .= " ORDER BY 
    CASE 
        WHEN A.hero_today_01_01 <= '".$today." 00:00:00' 
        AND A.hero_today_01_02 >= '".$today." 00:00:00' 
        THEN A.hero_today_01_02 
    END DESC,
    CASE 
        WHEN A.hero_today_02_01 <= '".$today." 00:00:00' 
        AND A.hero_today_02_02 >= '".$today." 00:00:00' 
        THEN A.hero_today_02_02 
    END DESC,
    CASE 
        WHEN A.hero_today_03_01 <= '".$today." 00:00:00' 
        AND A.hero_today_03_02 >= '".$today." 00:00:00' 
        THEN A.hero_today_03_02 
    END DESC,
    CASE 
        WHEN A.hero_today_04_01 <= '".$today." 00:00:00' 
        AND A.hero_today_04_02 >= '".$today." 00:00:00' 
        THEN A.hero_today_04_02 
    END DESC,
    CASE 
        WHEN A.hero_today_04_02 <= '".$today." 00:00:00' 
        THEN A.hero_today_04_02 
    END DESC";
$sql .= " LIMIT ".$start.",".$list_page;


$list_res = sql($sql);
$list_cnt = mysql_num_rows($list_res);

?>
<form name="viewForm" id="viewForm">
    <input type="hidden" name="mode" />
    <input type="hidden" name="hero_code" value="<?=$view["hero_code"]?>"/>

    <div class="tableSection mgt20">
        <h2 class="table_tit">회원 정보</h2>
        <table class="searchBox">
            <colgroup>
                <col width="200px">
                <col width=*>
                <col width="200px">
                <col width=*>
            </colgroup>
            <tbody>
            <tr>
                <th>아이디</th>
                <td><?=$view["hero_id"]?></td>
                <th>서포터즈</th>
                <td><?=$hero_group?></td>
            </tr>
            <tr>
                <th>이름</th>
                <td><?=$view["hero_name"]?></td>
                <th>서포터즈 팀</th>
                <td><?=$hero_board_group?></td>
            </tr>
            <tr>
                <th>닉네임</th>
                <td><?=$view["hero_nick"]?></td>
                <th>휴대폰 번호</th>
                <td>
                    <?=$hero_hp[0]?> - <?=$hero_hp[1]?> - <?=$hero_hp[2]?>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</form>
<form name="searchForm3" id="searchForm3" action="<?=PATH_HOME?>">
    <input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
    <input type="hidden" name="board" value="<?=$_GET["board"]?>" />
    <input type="hidden" name="hero_code" value="<?=$view["hero_code"]?>"/>
    <input type="hidden" name="view" value="userManagerView"/>
    <input type="hidden" name="tab" value="3"/>
    <input type="hidden" name="page" value="<?=$page3?>" />
    <div class="tableSection mgt20 mu_form">
        <h2 class="table_tit">체험단 검색</h2>
        <table class="searchBox">
            <colgroup>
                <col width="200px">
                <col width=*>
            </colgroup>
            <tbody>
            <tr>
                <th>체험단 기간</th>
                <td>
                    <div class="search_inner">
                        <input type="text" id="sdate2" name="startDate2" value="<?=$_GET["startDate2"]?>" readonly/>
                        <div class="inner_between">~</div>
                        <input type="text" id="edate2" name="endDate2" value="<?=$_GET["endDate2"]?>" readonly/>
                        <div class="add_icon">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.46294 5.86456C1.46294 3.84025 3.10038 2.19922 5.12026 2.19922H12.4349C14.4548 2.19922 16.0922 3.84025 16.0922 5.86456V12.4622C16.0922 14.4865 14.4548 16.1275 12.4349 16.1275H5.12026C3.10038 16.1275 1.46294 14.4865 1.46294 12.4622V5.86456ZM5.12026 3.66536C3.90833 3.66536 2.92587 4.64998 2.92587 5.86456V12.4622C2.92587 13.6768 3.90833 14.6614 5.12026 14.6614H12.4349C13.6468 14.6614 14.6293 13.6768 14.6293 12.4622V5.86456C14.6293 4.64998 13.6468 3.66536 12.4349 3.66536H5.12026Z" fill="white"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.85172 1.46631C6.2557 1.46631 6.58318 1.79451 6.58318 2.19938V4.39858C6.58318 4.80345 6.2557 5.13165 5.85172 5.13165C5.44774 5.13165 5.12025 4.80345 5.12025 4.39858V2.19938C5.12025 1.79451 5.44774 1.46631 5.85172 1.46631Z" fill="white"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.7034 1.46631C12.1074 1.46631 12.4349 1.79451 12.4349 2.19938V4.39858C12.4349 4.80345 12.1074 5.13165 11.7034 5.13165C11.2995 5.13165 10.972 4.80345 10.972 4.39858V2.19938C10.972 1.79451 11.2995 1.46631 11.7034 1.46631Z" fill="white"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.77757 6.59766C9.18155 6.59766 9.50904 6.92586 9.50904 7.33073V8.79686H10.972C11.3759 8.79686 11.7034 9.12507 11.7034 9.52993C11.7034 9.93479 11.3759 10.263 10.972 10.263H9.50904V11.7291C9.50904 12.134 9.18155 12.4622 8.77757 12.4622C8.3736 12.4622 8.04611 12.134 8.04611 11.7291L8.04611 10.263H6.58318C6.1792 10.263 5.85172 9.93479 5.85172 9.52993C5.85172 9.12507 6.1792 8.79686 6.58318 8.79686H8.04611V7.33073C8.04611 6.92586 8.3736 6.59766 8.77757 6.59766Z" fill="white"/>
                            </svg>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th>검색어</th>
                <td>
                    <div class="search_inner"><input type="text" class="search_txt" name="board_title" style="width: 326px;" value="<?=$_GET["board_title"] ? $_GET["board_title"]  : ""?>"/></div>
                </td>
            </tr>
            <tr>
                <th>선정 여부</th>
                <td>
                    <div class="search_inner sup">
                        <label class="akContainer">전체
                            <input type="radio" <?=!$_GET["lot_01"] ? "checked" : ""?> name="lot_01" value="">
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">선정
                            <input type="radio" <?=$_GET["lot_01"] == "1" ? "checked" : ""?> name="lot_01" value="1">
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">미선정
                            <input type="radio" <?=($_GET["lot_01"]!="1" && strlen($_GET["lot_01"]) > 0) ? "checked" : ""?> name="lot_01" value="0">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="btnContainer mgt20">
            <a href="javascript:;" onclick="return fnSearch(3);" class="btnAdd3">검색</a>
        </div>
    </div>



<div class="tableSection mgt30">
    <div class="table_top">
        <h2 class="table_tit">검색 결과</h2>
        <p class="postNum"><span class="line"><?=number_format($search_total3)?>개</span><span class="op_5">전체 <?=number_format($total_data3)?>개</span></p>
    </div>
    <p class="table_desc"></p>
    <div class="searchResultBox_container">
        <table class="searchResultBox">
            <colgroup>
                <col width="45px" />
                <col width="150px" />
                <col width="150px" />
                <col width="105px" />
                <col width="60px" />
                <col width="120px" />
                <col width="70px" />
                <col width="75px" />
                <col width="70px" />
            </colgroup>
            <thead>
            <th>
                <div class="">
                    NO
                </div>
            </th>
            <th>
                <div class="">
                    서포터즈 구분
                </div>
            </th>
            <th>
                <div class="contTit">
                    <!-- sort 시 여기 p태그에 class="sort" 넣어주심 됩니다! 하단 p태그 동일 -->
                    <p class="">
                        체험단명
                    </p>
                    <!-- <p class="sort">
                        체험단명
                    </p> -->
                </div>
            </th>
            <th>
                <div class="">
                    체험단 모집기간
                </div>
            </th>
            <th>
                <div class="">
                    진행
                </div>
            </th>
            <th>
                <div class="">
                    슈퍼패스 사용 여부
                </div>
            </th>
            <th>
                <div class="">
                    선정 여부
                </div>
            </th>
            <th>
                <div class="contCreate">
                    <!-- sort 시 여기 p태그에 class="sort" 넣어주심 됩니다! -->
                    <p class="">
                        체험단 신청일
                    </p>
                </div>
            </th>
            <th>
                <div class="">
                    배송포인트
                </div>
            </th>
            </thead>
            <tbody>
            <?
            if($total_data3 > 0) {
            while($list = mysql_fetch_assoc($list_res)) {

                // 체험단진행상태
                if(substr($list["hero_today_04_02"],0,10)<$today){ //우수후기 발표 < 오늘
                    $progress = "체험단 마감";
                    // $href = "javascript:alert(\"마감된 체험단입니다.\")";
                    // 마감된 체험단도 접속 가능하게 요청하여 변경 조치
                    $href = "/main/index.php?board=".$list['hero_table']."&view=view&idx=".$list['hero_idx'];
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
                            if($board_rs['hero_board_three']==1)	$reviwer_tf = "<span class='mu_bar'>[우수후기 당첨]</span>";
                            $board_title = "<a href='http://www.aklover.co.kr/main/index.php?board=".$board_rs['hero_table']."&view=view2&idx=".$board_rs['hero_idx']."' target='_blank'><img src='/img/front/mypage/thum.jpg'><div class='txt_bx'><p class='ribon'><span class='type1'>프리미어 뷰티 클럽</span>".$reviwer_tf."</p><p class='tit t_l'>[후기] ".cut($board_rs['hero_title'],$cut_title_name)."</p></div></a>";
                        }
                    }

                    $review_button = '<span>콘텐츠 등록 기간 마감</span>';
                }

                // 선정 여부 (체험단 당첨 여부)
                $list['lot_01'] = $list['lot_01'] == "1" ? "선정" : "미선정";
                
                // 슈퍼패스 사용여부
                $list['hero_superpass'] = $list['hero_superpass'] == "N" ? "미사용" : "사용";

                // 배송비 차감 여부
                $list['delivery_point_yn'] = $list['delivery_point_yn'] == "Y" ? "차감" : "미차감";

                // 서포터즈 구분
                $hero_table = "";
                if($list['hero_table'] == 'group_04_06'){
                    $hero_table = "프리미어 뷰티 클럽";
                } else if($list['hero_table'] == 'group_04_28'){
                    $hero_table = "프리미어 라이프 클럽";
                } else if($list['hero_table'] == 'group_04_05'){
                    $hero_table = "베이직 뷰티&라이프 클럽";
                }

                
            ?>
            <tr style="cursor:pointer">
                <td>
                    <div class="table_result_no">
                        <?=number_format($i3);?>
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        <?= $hero_table?>
                    </div>
                </td>
                <td>
                    <div class="table_result_tit">
                        <?=$list['hero_title']?>
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        <?=$list['hero_today_01_01']?> ~ <?=$list['hero_today_04_02']?>
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        <?=$progress?>
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        <?=$list['hero_superpass']?>
                    </div>
                </td>
                <td>
                    <div class="table_result_btn01">
                        <!-- active 유무로 선정, 미선정 구분합니다. -->
                        <div class="table_result_btn_yn active">
                           <?=$list['lot_01']?>
                        </div>
                        <!-- <div class="table_result_btn_yn">
                            미선정
                        </div> -->
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        <?=$list['hero_today']?>
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                       <?=$list['delivery_point_yn']?>
                    </div>
                </td>
            </tr>
           <?
                --$i3;
            }
            } else {?>
                <tr>
                    <td colspan="9" class="no_data">등록된 데이터가 없습니다.</td>
                </tr>
            <? } ?>


            <!-- 데이터가 없을 경우 사용해주세요. -->
            <!-- <tr>
                <td colspan="9" class="no_data">등록된 데이터가 없습니다.</td>
            </tr> -->

            </tbody>
        </table>
    </div>
</div>
</form>

<div class="pagingWrap remaking">
    <?php if ($total_page3 > 1) { ?>
        <div class="pagination">
            <?php
            // query_string에서 tab 파라미터만 제거
            $params = explode('&', $query_string);
            $clean_params = array();
            foreach($params as $param) {
                if(strpos($param, 'tab=') !== 0) {
                    $clean_params[] = $param;
                }
            }
            $clean_query_string = implode('&', $clean_params);

            // 현재 활성화된 탭
            $current_tab = 3;
            ?>

            <?php if ($start_page3 > 1) { ?>
                <a href="?<?=$clean_query_string?>&page=1&tab=<?=$current_tab?>" class="pg_btn first">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.2002 7.99935L11.2002 13.9993M5.2002 7.99935L11.2002 1.99935M5.2002 7.99935H13.0002" stroke="#888888" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <a href="?<?=$clean_query_string?>&page=<?=$prev_page3?>&tab=<?=$current_tab?>" class="pg_btn prev">이전</a>
            <?php } ?>

            <?php for ($i = $start_page3; $i <= $end_page3; $i++) { ?>
                <a href="?<?=$clean_query_string?>&page=<?=$i?>&tab=<?=$current_tab?>" class="pg_btn num <?=$page3 == $i ? 'active' : ''?>"><?=$i?></a>
            <?php } ?>

            <?php if ($end_page3 < $total_page3) { ?>
                <a href="?<?=$clean_query_string?>&page=<?=$next_page3?>&tab=<?=$current_tab?>" class="pg_btn next">다음</a>
                <a href="?<?=$clean_query_string?>&page=<?=$total_page3?>&tab=<?=$current_tab?>" class="pg_btn last">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.7998 7.99935L4.7998 13.9993M10.7998 7.99935L4.7998 1.99935M10.7998 7.99935H2.9998" stroke="#888888" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<!--후기 URL 팝업-->
<div class="popup_url_box">
    <div class="popup_url_cont">
        <div class="popup_url_head">
            <svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.41073 4.41083C4.73617 4.08539 5.26381 4.08539 5.58925 4.41083L15.5892 14.4108C15.9147 14.7363 15.9147 15.2639 15.5892 15.5893C15.2638 15.9148 14.7362 15.9148 14.4107 15.5893L4.41073 5.58934C4.0853 5.2639 4.0853 4.73626 4.41073 4.41083Z" fill="black"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5892 4.41083C15.2638 4.08539 14.7362 4.08539 14.4107 4.41083L4.41072 14.4108C4.08529 14.7363 4.08529 15.2639 4.41072 15.5893C4.73616 15.9148 5.2638 15.9148 5.58924 15.5893L15.5892 5.58934C15.9147 5.2639 15.9147 4.73626 15.5892 4.41083Z" fill="black"></path>
            </svg>
        </div>
        <div class="popup_url_body">
            <div class="tit">후기 URL 확인</div>
            <div class="popup_url_table">
                <table>
                    <colgroup>
                        <col width="144px" />
                        <col width="*" />
                    </colgroup>
                    <tbody>
                    <tr>
                        <th><div class="">닉네임</div></th>
                        <td><div class="">dreammaam</div></td>
                    </tr>
                    <tr>
                        <th><div class="">회원 등급</div></th>
                        <td><div class="">프리미어 라이프 클럽</div></td>
                    </tr>
                    <tr>
                        <th><div class="">콘텐츠 타이틀 명</div></th>
                        <td><div class="">세탁과 세탁조 케어를 한번에!!</div></td>
                    </tr>
                    <tr>
                        <th><div class="">콘텐츠 등록일</div></th>
                        <td><div class="">2024-01-18 14:48:47</div></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="popup_url_link">
                <div class="popup_url_link_item">
                    <div class="popup_url_link_top">
                        <div class="popup_url_link_item_img"></div>
                        <p class="popup_url_link_item_tit">인스타그램</p>
                    </div>
                    <div class="popup_url_link_cont active">
                        <input value="https://www.instagram.com/p/C2MQjuWPJ4Y/?igsh=MXYzeHljNmdlbDZmNA==" />
                        <a href="https://www.instagram.com/p/C2MQjuWPJ4Y/?igsh=MXYzeHljNmdlbDZmNA==" target="_blank">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M5.25 3C4.00736 3 3 4.00736 3 5.25V12.75C3 13.9926 4.00736 15 5.25 15H12.75C13.9926 15 15 13.9926 15 12.75V9.75C15 9.33579 15.3358 9 15.75 9C16.1642 9 16.5 9.33579 16.5 9.75V12.75C16.5 14.8211 14.8211 16.5 12.75 16.5H5.25C3.17893 16.5 1.5 14.8211 1.5 12.75V5.25C1.5 3.17893 3.17893 1.5 5.25 1.5H8.25C8.66421 1.5 9 1.83579 9 2.25C9 2.66421 8.66421 3 8.25 3H5.25Z"
                                        fill="black"
                                ></path>
                                <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M16.2803 1.71967C16.5732 2.01256 16.5732 2.48744 16.2803 2.78033L9.53033 9.53033C9.23744 9.82322 8.76256 9.82322 8.46967 9.53033C8.17678 9.23744 8.17678 8.76256 8.46967 8.46967L15.2197 1.71967C15.5126 1.42678 15.9874 1.42678 16.2803 1.71967Z"
                                        fill="black"
                                ></path>
                                <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M10.5 2.25C10.5 1.83579 10.8358 1.5 11.25 1.5H15.75C16.1642 1.5 16.5 1.83579 16.5 2.25V6.75C16.5 7.16421 16.1642 7.5 15.75 7.5C15.3358 7.5 15 7.16421 15 6.75V3H11.25C10.8358 3 10.5 2.66421 10.5 2.25Z"
                                        fill="black"
                                ></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="popup_url_link_item">
                    <div class="popup_url_link_top">
                        <div class="popup_url_link_item_img"></div>
                        <p class="popup_url_link_item_tit">네이버</p>
                    </div>
                    <div class="popup_url_link_cont active">
                        <input value="https://www.instagram.com/p/C2MQjuWPJ4Y/?igsh=MXYzeHljNmdlbDZmNA==" />
                        <a href="https://www.instagram.com/p/C2MQjuWPJ4Y/?igsh=MXYzeHljNmdlbDZmNA==" target="_blank">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M5.25 3C4.00736 3 3 4.00736 3 5.25V12.75C3 13.9926 4.00736 15 5.25 15H12.75C13.9926 15 15 13.9926 15 12.75V9.75C15 9.33579 15.3358 9 15.75 9C16.1642 9 16.5 9.33579 16.5 9.75V12.75C16.5 14.8211 14.8211 16.5 12.75 16.5H5.25C3.17893 16.5 1.5 14.8211 1.5 12.75V5.25C1.5 3.17893 3.17893 1.5 5.25 1.5H8.25C8.66421 1.5 9 1.83579 9 2.25C9 2.66421 8.66421 3 8.25 3H5.25Z"
                                        fill="black"
                                ></path>
                                <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M16.2803 1.71967C16.5732 2.01256 16.5732 2.48744 16.2803 2.78033L9.53033 9.53033C9.23744 9.82322 8.76256 9.82322 8.46967 9.53033C8.17678 9.23744 8.17678 8.76256 8.46967 8.46967L15.2197 1.71967C15.5126 1.42678 15.9874 1.42678 16.2803 1.71967Z"
                                        fill="black"
                                ></path>
                                <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M10.5 2.25C10.5 1.83579 10.8358 1.5 11.25 1.5H15.75C16.1642 1.5 16.5 1.83579 16.5 2.25V6.75C16.5 7.16421 16.1642 7.5 15.75 7.5C15.3358 7.5 15 7.16421 15 6.75V3H11.25C10.8358 3 10.5 2.66421 10.5 2.25Z"
                                        fill="black"
                                ></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/anytime.5.1.2.css">
<script src="<?=ADMIN_DEFAULT?>/js/anytime.5.1.2.js"></script>

<script>
    $(document).ready(function(){
        $("#hero_hp_check").on("click",function(){
            if($(this).is(":checked")) {
                $(".input_hero_hp").attr("readOnly",false);
            } else {
                $(".input_hero_hp").attr("readOnly",true);
            }
        })

        $("#hero_mail_check").on("click",function(){
            if($(this).is(":checked")) {
                $(".input_hero_mail").attr("readOnly",false);
            } else {
                $(".input_hero_mail").attr("readOnly",true);
            }
        })

        //날짜 데이터포맷
        $(function(){
            jQuery("#sdate2, #startdate2").AnyTime_picker( {
                format: "%Y-%m-%d %H:%i:00"
            });

            jQuery("#edate2, #enddate2").AnyTime_picker( {
                format: "%Y-%m-%d %H:%i:00"
            });
        });
    });


</script>

