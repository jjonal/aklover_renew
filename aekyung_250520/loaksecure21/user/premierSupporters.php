<?
if(!defined('_HEROBOARD_'))exit;

$search = "";


// 250708 검색 musign jnr
if( !empty($_GET["hero_board"]) ) {
    $search .= " AND hero_board like '%".$_GET["hero_board"]."%' ";
}


//if($_GET["kewyword"]) { // 검색어 는 서포터즈명 기준?...
//    $search .= " AND ".$_GET["select"]." like '%".$_GET["kewyword"]."%' ";
//}

// 활동기간
if($_GET["startDt"] && $_GET["endDt"]) {
    // 데이터 유효성 검사 y-m-d 형식으로 넘어올 시 y-m-d H:i:s 형식으로 변경
    if (!empty($_GET["startDt"]) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET["startDt"])) {
        $_GET["startDt"] = $_GET["startDt"]." 00:00:00";
    }
    if (!empty($_GET["endDt"]) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET["endDt"])) {
        $_GET["endDt"] = $_GET["endDt"]." 23:59:59";
    }

    $startDt = $_GET["startDt"];
    $endDt = $_GET["endDt"];
    // 활동 시작일이 검색 종료일보다 작거나 같고, 활동 종료일이 검색 시작일보다 크거나 같은 경우 조회
    $search .= " AND startDt <= '".$endDt."' AND endDt >= '".$startDt."'";
}

// 전체페이지
$total_all_sql = " SELECT count(*) as cnt FROM supporters WHERE 1=1 ";
$total_all_result = sql($total_all_sql);
$total_all_res = mysql_fetch_assoc($total_all_result);
$total_cnt = $total_all_res['cnt'];

//페이지 넘버링
$total_sql = " SELECT count(*) as cnt FROM supporters WHERE 1=1 ".$search;
sql($total_sql);
$out_res = mysql_fetch_assoc($out_sql);
$total_data = $out_res['cnt'];

$i=$total_data;

$list_page=20;
$page_per_list=10;

if(!strcmp($_GET['page'], '') || !strcmp($_GET['page'], '1')){
    $page = '1';
}else{
    $page = $_GET['page'];
    $i = $i-($page-1)*$list_page;
}

$start = ($page-1)*$list_page;
$next_path=get("page");

$sql  = " SELECT *";
$sql .= " FROM supporters where 1=1 ".$search;
$sql .= " ORDER BY idx DESC LIMIT ".$start.",".$list_page;

$list_res = sql($sql);
?>


<!-- 프리미어 서포터즈 -->
<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
    <input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
    <input type="hidden" name="board" value="<?=$_GET["board"]?>" />
    <input type="hidden" name="page" value="<?=$page?>" />
    <input type="hidden" name="sno" value="" />
    <input type="hidden" name="view" value="" />
    <!-- 회원 관리 퀄리티 평가 검색 필터 -->
    <table class="searchBox">
        <colgroup>
            <col width="171px" />
            <col width="*" />
        </colgroup>
        <tr>
            <th>
                활동 기간
            </th>
            <td>
                <div class="search_inner">
                    <div class="dateMode_box">
                        <input type="text" name="startDt" class="dateMode" value="<?=$_REQUEST['startDt']?>">
                    </div>
                    <div class="inner_between">~</div>
                    <div class="dateMode_box">
                        <input type="text" name="endDt" class="dateMode" value="<?=$_REQUEST['endDt']?>">
                    </div>
                </div>
            </td>
        </tr>
<!--        <tr>-->
<!--            <th>-->
<!--                검색어-->
<!--            </th>-->
<!--            <td>-->
<!--                <div class="search_inner">-->
<!--                    <input class="search_txt" type="text" name="kewyword" value="--><?php //=$_GET["kewyword"]?><!--"/>-->
<!--                </div>-->
<!--            </td>-->
<!--        </tr>-->
        <tr>
            <th>서포터즈 구분</th>
            <td>
                <div class="search_inner sup">
                    <label class="akContainer">전체
                        <input type="radio" name="hero_board" value="" <?=!$_GET["hero_board"] ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">프리미어 뷰티 클럽
                        <input type="radio" name="hero_board" value="group_04_06" <?=$_GET["hero_board"] == "group_04_06" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">프리미어 라이프 클럽
                        <input type="radio" name="hero_board" value="group_04_28" <?=$_GET["hero_board"] == "group_04_28" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
        </tr>
    </table>
    <div class="btnGroupSearch_box">
        <div class="btnGroupSearch">
            <a href="javascript:;" onClick="fnSearch()" class="btnSearch">검색</a>
        </div>
    </div>
</form>


<div class="tableSection mgt30">
    <div class="table_top">
        <div>
            <h2 class="table_tit">검색 결과</h2>
            <p class="postNum"><span class="line"><?=number_format($total_data)?>개</span><span class="op_5">전체 <?=number_format($total_cnt)?>개</span></p>
        </div>
        <a class="table_btn bottom btnAdd3 popup_btn" data-popup="01">서포터즈 생성</a>
    </div>
    <p class="table_desc"></p>
    <div class="searchResultBox_container">
        <table class="searchResultBox">
            <colgroup>
                <col width="45px" />
                <col width="70px" />
                <col width="120px" />
                <col width="15px" />
                <col width="75px" />
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
                    모집 기간
                </div>
            </th>
            <th>
                <div class="">
                    서포터즈명
                </div>
            </th>
            <th>
                <div class="">
                    활동 기간
                </div>
            </th>
            <th>
                <div class="">
                    서포터즈 생성일
                </div>
            </th>
            <th>
                <div class="">
                    명단관리
                </div>
            </th>
            <th>
                <div class="">
                    삭제여부
                </div>
            </th>
            </thead>
            <tbody>
            <?
            if($total_data > 0) {
            while($list = mysql_fetch_assoc($list_res)) {
            // 서포터즈 명
            if($list["hero_board"] == 'group_04_06') {
                $list["hero_board"] = "프리미어 뷰티 클럽";
            } else if($list["hero_board"] == 'group_04_28') {
                $list["hero_board"] = "프리미어 라이프 클럽";
            } else {
                $list["hero_board"] = "";
            }
            ?>
            <tr>
                <td>
                    <div class="table_result_no">
                        <?=$i?>
                    </div>
                </td>
                <td>
                    <div class="">
                        <?=$list["recruit"]?>
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        <?=$list["hero_board"]?>
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        <?=$list["startDt"]?> ~ <?=$list["endDt"]?>
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        <?=$list["regDt"]?>
                    </div>
                </td>
                <td>
                    <div class="table_result_btn01">
                        <div class="table_result_btn_yn active" onClick="fnView('<?=$list["idx"]?>')">보기</div>
                    </div>
                </td>
                <td class="title">
                    <div class="table_result_btn02 pop_btn_01 delSupport" data-idx="<?=$list["idx"]?>">
                        <p class="icon_box">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                <g opacity="0.4">
                                    <path d="M5.5 4.58203V17.932C5.5 18.1529 5.67909 18.332 5.9 18.332H16.1C16.3209 18.332 16.5 18.1529 16.5 17.932V4.58203" stroke="black" stroke-width="1.5" stroke-linejoin="round"/>
                                    <path d="M3.6665 4.58203H18.3332" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M8.25 4.58333V3.15C8.25 2.92909 8.42909 2.75 8.65 2.75H13.35C13.5709 2.75 13.75 2.92909 13.75 3.15V4.58333" stroke="black" stroke-width="1.5" stroke-linejoin="round"/>
                                    <path d="M9.1665 8.25V14.6667" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M12.8335 8.25V14.6667" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
                                </g>
                            </svg>
                        </p>
                    </div>
                </td>
            </tr>

                <?
                $i--;
            }
            } else {
                ?>
                <tr>
                    <td colspan="7" class="no_data">등록된 데이터가 없습니다.</td>
                </tr>
            <?}?>

            </tbody>
        </table>
    </div>
</div>

<!-- 페이지네이션 -->
<div class="pagingWrap">
    <?     // 체크박스 항목 array 처리하여 전달
    $params = $_GET;
    // page 파라미터 제거 (페이지네이션에서 따로 처리)
    unset($params['page']);

    $query_string = '';
    foreach($params as $key => $value) {
        if(is_array($value)) {
            foreach($value as $v) {
                $query_string .= '&' . $key . '[]=' . urlencode($v);
            }
        } else {
            $query_string .= '&' . $key . '=' . urlencode($value);
        }
    }
    $next_path = $query_string;

    include_once PATH_INC_END.'page.php';
    ?>
</div>

<!--프리미어 서포터즈 선정 및 관리 팝업-->
<div class="popup_url_box" id="pop_01">
    <div class="popup_url_cont height_typeB">
        <div class="popup_url_head">
            <svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.41073 4.41083C4.73617 4.08539 5.26381 4.08539 5.58925 4.41083L15.5892 14.4108C15.9147 14.7363 15.9147 15.2639 15.5892 15.5893C15.2638 15.9148 14.7362 15.9148 14.4107 15.5893L4.41073 5.58934C4.0853 5.2639 4.0853 4.73626 4.41073 4.41083Z" fill="black"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5892 4.41083C15.2638 4.08539 14.7362 4.08539 14.4107 4.41083L4.41072 14.4108C4.08529 14.7363 4.08529 15.2639 4.41072 15.5893C4.73616 15.9148 5.2638 15.9148 5.58924 15.5893L15.5892 5.58934C15.9147 5.2639 15.9147 4.73626 15.5892 4.41083Z" fill="black"></path>
            </svg>
        </div>
        <form name="writeForm" id="writeForm" method="POST">
        <input type="hidden" name="mode" value="insert" />
        <div class="popup_url_body">
            <div class="tit">프리미어 서포터즈 설정</div>
            <div class="popup_url_link_v2">
                <div class="popup_url_link_item_v2">
                    <div class="popup_url_link_top">
                        <p class="popup_url_link_item_tit">모집 기간</p>
                    </div>
                    <div class="popup_url_link_cont mgt10">
                        <input type="text" value="" name="new_recruit" placeholder="24년 상반기" />
                    </div>
                </div>

                <div class="popup_url_link_item_v2">
                    <div class="popup_url_link_top">
                        <p class="popup_url_link_item_tit">서포터즈명</p>
                    </div>
                    <div class="popup_url_link_cont mgt10">
                        <div class="search_inner">
                            <div class="select-wrap">
                                <select name="new_hero_board">
                                    <option value="group_04_06">프리미어 뷰티 클럽</option>
                                    <option value="group_04_28">프리미어 라이프 클럽</option>
                                </select>
                            </div>
                        </div>
<!--                        <input type="text" value="" name="hero_board" placeholder="프리미어 뷰티 서포터즈" />-->
                    </div>
                </div>
                <div class="popup_url_link_item_v2 mu_form">
                    <div class="popup_url_link_top">
                        <p class="popup_url_link_item_tit">활동 기간</p>
                    </div>
                    <div class="popup_url_link_cont mgt10 dateBox">
                        <div class="search_inner">
                            <div class="dateMode_box">
                                <input type="text" name="new_startDt" class="dateMode" value="">
                            </div>
                            <div class="inner_between">~</div>
                            <div class="dateMode_box">
                                <input type="text" name="new_endDt" class="dateMode" value="">
                            </div>
                        </div>
                    </div>
                    <p class="notice">* 설정된 기간동안 프리미어 서포터즈로 활동합니다.</p>
                </div>

            </div>
            <div class="btnContainer mgt20 line">
                <a href="javascript:addSupport();" class="btnAdd3">서포터즈 생성하기</a>
            </div>
        </div>
        </form>
    </div>
</div>

<script>
    // ajax 실행 함수를 전역 스코프로 이동
    function submitSupportersAction(param) {
        $.ajax({
            url: "/loaksecure21/user/premierSupportersAct.php",
            type: "POST",
            data: param,
            dataType: "json",
            success: function(d) {
                console.log(d)
                if(d.result == 1) {
                    let message;
                    // mode 파라미터값 추출
                    let mode = typeof param === 'string' ?
                        param.split('mode=')[1]?.split('&')[0] :
                        param.mode;

                    switch(mode) {
                        case "insert":
                            message = "서포터즈가 생성되었습니다.";
                            break;
                        case "delete":
                            message = "서포터즈가 삭제되었습니다.";
                            break;
                        case "update":
                            message = "서포터즈가 수정되었습니다.";
                            break;
                        default:
                            message = "처리가 완료되었습니다.";
                    }
                    alert(message);
                    location.reload();
                }
                else {
                    alert("실행 중 실패했습니다.");
                }
            },
            error: function(e) {
                console.log(e);
                alert("실패했습니다.");
            }
        });
    }

    $(document).ready(function(){
        fnSearch = function() {
            $("#searchForm").attr("action","").submit();
        }

        fnView = function(idx) {
            $("input[name='sno']").val(idx);
            $("input[name='view']").val("premierSupportersView");
            $("#searchForm").attr("action","<?=PATH_HOME?>").submit();
        }

        // 서포터즈 생성
        addSupport = function() {
            if(!$("input[name='new_recruit']").val()) {
                alert("모집 기간을 입력해 주세요");
                $("input[name='new_recruit']").focus();
                return;
            }

            if(!$("input[name='new_startDt']").val()) {
                alert("활동기간을 입력해 주세요.");
                $("input[name='new_startDt']").focus();
                return;
            }

            if(!$("input[name='new_endDt']").val()) {
                alert("활동기간을 입력해 주세요.");
                $("input[name='new_endDt']").focus();
                return;
            }

            var formData = $("#writeForm").serializeArray();
            var param = $.param(formData);
            console.log(param);
            submitSupportersAction(param);
        }

        // 서포터즈 삭제
        $(document).on('click', '.delSupport', function() {
            if(confirm("정말 삭제하시겠습니까?")) {
                const idx = $(this).data('idx');
                var param = {
                    mode: "delete",
                    idx: idx
                };
                submitSupportersAction(param);
            }
        });
    });
</script>