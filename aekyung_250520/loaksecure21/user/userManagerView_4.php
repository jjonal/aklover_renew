<?
$hero_code = $view["hero_code"];


// 전체 갯수
$total_sql  = " SELECT count(*) cnt FROM ( ";
$total_sql .= " SELECT hero_title FROM member m ";
$total_sql .= " INNER JOIN board b ON m.hero_code = b.hero_code  ";
$total_sql .= " WHERE m.hero_use = 0 AND m.hero_code=  '".$hero_code."' ";
$total_sql .= " UNION ALL ";
$total_sql .= " SELECT hero_command as hero_title FROM member m ";
$total_sql .= " INNER JOIN review r ON m.hero_code = r.hero_code ";
$total_sql .= " WHERE m.hero_use = 0 AND m.hero_code=  '".$hero_code."') b ";

$total_res = sql($total_sql,"on");
$total_rs = mysql_fetch_assoc($total_res);

$total_data4 = $total_rs['cnt'];

$i4=$total_data4;

$list_page4=10;
$page_per_list4=10;


//검색폼
$search = "";


//날짜 검색 (등록일)
$search = "";
if($_GET["startDate4"] && $_GET["endDate4"]) {
    $search .= " AND b.hero_today BETWEEN '".$_GET['startDate4']."' AND '".$_GET['endDate4']."' ";
}

// 메뉴검색
if( !empty($_GET["menu_title"]) && is_array($_GET["menu_title"]) ) {

    $hero_level_conditions = array(); // array() 사용

    foreach($_GET["menu_title"] as $menu_type) {
        switch($menu_type) {
            case "수다통": // lover 톡
                $menu_type_conditions[] = "hg.hero_title = '수다통'";
                break;
            case "공지사항": // 공지사항
                $menu_type_conditions[] = "hg.hero_title = '공지사항'";
                break;
            case "게릴라이벤트": // 이달의 이벤트
                $menu_type_conditions[] = "hg.hero_title = '게릴라이벤트'";
                break;
            case "1:1문의": // 이달의 이벤트
                $menu_type_conditions[] = "hg.hero_title = '1:1문의'";
                break;
        }
    }

    if(!empty($menu_type_conditions)) {
        $search .= " AND (" . implode(" OR ", $menu_type_conditions) . ")";
    }
}

// 타입검색
if($_GET["type"] && $_GET["type"]) {
    $search .= " AND b.type = '".$_GET["type"]."' ";
}

//검색 갯수
$search_sql  = " SELECT COUNT(*) AS cnt FROM ( ";
$search_sql .= "   SELECT b.hero_today ";
$search_sql .= "   FROM ( ";
$search_sql .= "     SELECT b.hero_table, b.hero_today, '게시글' AS type ";
$search_sql .= "     FROM member m ";
$search_sql .= "     INNER JOIN board b ON m.hero_code = b.hero_code ";
$search_sql .= "     WHERE m.hero_use = 0 AND m.hero_code = '".$hero_code."' ";

$search_sql .= "     UNION ALL ";

$search_sql .= "     SELECT r.hero_table, r.hero_today, '댓글' AS type ";
$search_sql .= "     FROM member m ";
$search_sql .= "     INNER JOIN review r ON m.hero_code = r.hero_code ";
$search_sql .= "     WHERE m.hero_use = 0 AND m.hero_code = '".$hero_code."' ";
$search_sql .= "   ) b ";
$search_sql .= "   LEFT JOIN hero_group hg ON b.hero_table = hg.hero_board ";
$search_sql .= "   WHERE 1=1 ".$search;
$search_sql .= " ) AS result ";


$search_res = sql($search_sql);
$search_row = mysql_fetch_assoc($search_res);
$search_total4 = $search_row['cnt'];


if(!strcmp($_GET['page'], '')) {
    $page4 = '1';
} else {
    $page4 = $_GET['page'];
    $i4 = $i4-($page4-1)*$list_page4;
}

$start4 = ($page4-1)*$list_page4;
$next_path4=get("page");

// 전체 페이지 수 계산
$total_data4 = $search_total4 > 0 ? $search_total4 : $total_data4;
$total_page4 = ceil($total_data4 / $list_page4);

// 페이지 그룹의 시작과 끝 계산
$start_page4 = floor(($page4 - 1) / $page_per_list4) * $page_per_list4 + 1;
$end_page4 = $start_page4 + $page_per_list4 - 1;

// 마지막 페이지가 전체 페이지 수를 넘지 않도록 조정
if ($end_page4 > $total_page4) {
    $end_page4 = $total_page4;
}

// 이전/다음 페이지 그룹
$prev_page4 = $start_page4 - 1;
$next_page4 = $end_page4 + 1;

// URL 파라미터 처리
$query_string = $_SERVER['QUERY_STRING'];
$query_string = preg_replace('/&?page=[^&]*/', '', $query_string);


$sql  = " SELECT b.hero_title, b.hero_nick, b.hero_today, b.type, hg.hero_title AS menu_title ";
$sql .= " FROM ( ";
$sql .= "   SELECT b.hero_title, b.hero_table, b.hero_today, '게시글' AS type, m.hero_nick ";
$sql .= "   FROM member m ";
$sql .= "   INNER JOIN board b ON m.hero_code = b.hero_code ";
$sql .= "   WHERE m.hero_use = 0 AND m.hero_code = '".$hero_code."' ";
$sql .= "   UNION ALL ";
$sql .= "   SELECT r.hero_command AS hero_title, r.hero_table, r.hero_today, '댓글' AS type, m.hero_nick ";
$sql .= "   FROM member m ";
$sql .= "   INNER JOIN review r ON m.hero_code = r.hero_code ";
$sql .= "   WHERE m.hero_use = 0 AND m.hero_code = '".$hero_code."' ";
$sql .= " ) b ";
$sql .= " LEFT JOIN hero_group hg ON b.hero_table = hg.hero_board ";
$sql .= " WHERE 1=1 ".$search;
$sql .= " ORDER BY b.hero_today DESC ";
$sql .= " LIMIT ".$start4.", ".$list_page4;



$list_res = sql($sql, "on");
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

<form name="searchForm4" id="searchForm4" action="<?=PATH_HOME?>">
    <input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
    <input type="hidden" name="board" value="<?=$_GET["board"]?>" />
    <input type="hidden" name="hero_code" value="<?=$view["hero_code"]?>"/>
    <input type="hidden" name="view" value="userManagerView"/>
    <input type="hidden" name="tab" value="4"/>
    <input type="hidden" name="page" value="<?=$page4?>" />
    <div class="tableSection mgt20 mu_form">
        <h2 class="table_tit">활동 내용 검색</h2>
        <table class="searchBox">
            <colgroup>
                <col width="200px">
                <col width=*>
            </colgroup>
            <tbody>
            <tr>
                <th>등록 기간</th>
                <td>
                    <div class="search_inner">
                        <input type="text" id="sdate4" name="startDate4" value="<?=$_GET["startDate4"]?>" readonly/>
                        <div class="inner_between">~</div>
                        <input type="text" id="edate4" name="endDate4" value="<?=$_GET["endDate4"]?>" readonly/>
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
                    <div class="search_inner"><input type="text" class="search_txt" style="width: 326px;"/></div>
                </td>
            </tr>
            <tr>
                <th>메뉴분류</th>
                <td>
                    <div class="search_inner sup">
                        <?php
                        $menu_title = (isset($_GET['menu_title']) && is_array($_GET['menu_title'])) ? $_GET['menu_title'] : array();
                        ?>
                        <label class="akContainer">전체
                            <input type="checkbox" <?php echo (empty($_GET['menu_title'])) ? 'checked' : ''; ?> name="menu_title[]" value="check">
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">Lover톡
                            <input type="checkbox" <?php echo (is_array($menu_title) && in_array('수다통', $menu_title)) ? 'checked' : ''; ?> name="menu_title[]" value="수다통">
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">공지사항
                            <input type="checkbox" <?php echo (is_array($menu_title) && in_array('공지사항', $menu_title)) ? 'checked' : ''; ?> name="menu_title[]" value="공지사항">
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">이달의 이벤트
                            <input type="checkbox" <?php echo (is_array($menu_title) && in_array('게릴라이벤트', $menu_title)) ? 'checked' : ''; ?> name="menu_title[]" value="게릴라이벤트">
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">1:1문의
                            <input type="checkbox" <?php echo (is_array($menu_title) && in_array('1:1문의', $menu_title)) ? 'checked' : ''; ?> name="menu_title[]" value="1:1문의">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <th>타입</th>
                <td>
                    <div class="search_inner sup">
                        <label class="akContainer">전체
                            <input type="radio" <?=!$_GET["type"] ? "checked" : ""?> name="type" value="">
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">게시글
                            <input type="radio" <?=$_GET["type"] == "게시글" ? "checked" : ""?> name="type" value="게시글">
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">댓글
                            <input type="radio" <?=$_GET["type"]=="댓글" ? "checked" : ""?> name="type" value="댓글">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="btnContainer mgt20">
            <a href="javascript:;" onclick="return fnSearch(4);" class="btnAdd3">검색</a>
        </div>
    </div>


<div class="tableSection mgt30">
    <!-- <h2 class="table_tit">콘텐츠 검색</h2> -->
    <div class="table_top">
        <h2 class="table_tit">검색 결과</h2>
        <p class="postNum"><span class="line"><?=number_format($search_total4)?>개</span><span class="op_5">전체 <?=number_format($total_data4)?>개</span></p>
    </div>
    <p class="table_desc"></p>
    <div class="searchResultBox_container">
        <table class="searchResultBox">
            <colgroup>
                <col width="45px" />
                <col width="100px" />
                <col width="100px" />
                <col width="180px" />
                <col width="60px" />
                <col width="60px" />
                <col width="130px" />
            </colgroup>
            <thead>
            <th>
                <div class="">
                    NO
                </div>
            </th>
            <th>
                <div class="">
                    닉네임
                </div>
            </th>
            <th>
                <div class="">
                    메뉴분류
                </div>
            </th>
            <th>
                <div class="">
                    내용
                </div>
            </th>
            <th>
                <div class="">
                    타입
                </div>
            </th>
            <th>
                <div class="">
                    등록일
                </div>
            </th>
            <th>
                <div class="">
                    삭제일
                </div>
            </th>
            </thead>
            <tbody>
            <?
            if($total_data4 > 0) {
            while($list = mysql_fetch_assoc($list_res)) {

                // 일부 메뉴명칭 변경에 따른 메뉴명칭 변경
                if ($list["menu_title"] == "게릴라이벤트") {
                    $list['menu_title'] = "이달의 이벤트";
                } elseif ($list["menu_title"] == "수다통") {
                    $list['menu_title'] = "Lover톡";
                } else {
                    $list['menu_title'] = $list["menu_title"];
                }

            ?>
            <tr style="cursor:pointer" onClick="fnView('<?=$list["hero_code"]?>')">
                <td>
                    <div class="table_result_no">
                        <?=number_format($i4);?>
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        <?=$list["hero_nick"]?>
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        <?=$list["menu_title"]?>
                    </div>
                </td>
                <td>
                    <div class="table_result_contents">
                        <?=$list["hero_title"]?>
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        <?=$list["type"]?>
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        <?=$list["hero_today"]?>
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        체크필요
                    </div>
                </td>
            </tr>
           <?
                --$i4;
            }
            } else {?>
                <tr>
                    <td colspan="7" class="no_data">등록된 데이터가 없습니다.</td>
                </tr>
            <? } ?>
            </tbody>
        </table>
    </div>
</div>
</form>

<div class="pagingWrap remaking">
    <?php if ($total_page4 > 1) { ?>
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
            $current_tab = 4;
            ?>

            <?php if ($start_page4 > 1) { ?>
                <a href="?<?=$clean_query_string?>&page=1&tab=<?=$current_tab?>" class="pg_btn first">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.2002 7.99935L11.2002 13.9993M5.2002 7.99935L11.2002 1.99935M5.2002 7.99935H13.0002" stroke="#888888" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <a href="?<?=$clean_query_string?>&page=<?=$prev_page4?>&tab=<?=$current_tab?>" class="pg_btn prev">이전</a>
            <?php } ?>

            <?php for ($i = $start_page4; $i <= $end_page4; $i++) { ?>
                <a href="?<?=$clean_query_string?>&page=<?=$i?>&tab=<?=$current_tab?>" class="pg_btn num <?=$page4 == $i ? 'active' : ''?>"><?=$i?></a>
            <?php } ?>

            <?php if ($end_page4 < $total_page4) { ?>
                <a href="?<?=$clean_query_string?>&page=<?=$next_page4?>&tab=<?=$current_tab?>" class="pg_btn next">다음</a>
                <a href="?<?=$clean_query_string?>&page=<?=$total_page4?>&tab=<?=$current_tab?>" class="pg_btn last">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.7998 7.99935L4.7998 13.9993M10.7998 7.99935L4.7998 1.99935M10.7998 7.99935H2.9998" stroke="#888888" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            <?php } ?>
        </div>
    <?php } ?>
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
            jQuery("#sdate4, #startDate4").AnyTime_picker( {
                format: "%Y-%m-%d %H:%i:00"
            });

            jQuery("#edate4, #endDate4").AnyTime_picker( {
                format: "%Y-%m-%d %H:%i:00"
            });
        });
    });


</script>

