<!-- 회원 관리 퀄리티 평가-->
<?  if(!defined('_HEROBOARD_'))exit;

$search = "";

// 검색어가 있을 때
if($_GET["kewyword"] && $_GET["select"] != 'none') { //
    if($_GET["select"] == 'hero_nick') { // 닉네임 검색
        $_GET["select"] = 'm.'.$_GET["select"];
    } elseif ($_GET["select"] == 'hero_name') { // 이름
        $_GET["select"] = 'm.'.$_GET["select"];
    } elseif ($_GET["select"] == 'hero_id') { // 아이디
        $_GET["select"] = 'm.'.$_GET["select"];
    } elseif ($_GET["select"] == 'hero_hp') { // 전화번호
        $_GET["select"] = 'm.hero_hp';
        // 검색어에서 하이픈 제거 후 포맷팅
        $phone = preg_replace("/[^0-9]/", "", $_GET["kewyword"]); // 숫자만 추출
        $_GET["kewyword"] = substr($phone, 0, 3) . '-' . substr($phone, 3, 4) . '-' . substr($phone, 7);
    }
    $search .= " AND ".$_GET["select"]." like '%".$_GET["kewyword"]."%' ";
}

// 총 데이터 수
//$total_sql = " SELECT count(*) cnt FROM member WHERE hero_use = 0 ".$search;
// 전체 데이터 수 (검색 조건 없이)
$total_all_sql = " SELECT count(DISTINCT m.hero_code) as cnt";
$total_all_sql .= " FROM member m ";
$total_all_sql .= " LEFT JOIN quality_evaluation qe ON m.hero_code = qe.hero_code ";
$total_all_sql .= " WHERE m.hero_use = 0";

$total_all_result = sql($total_all_sql);
$total_all_res = mysql_fetch_assoc($total_all_result);
$total_all = $total_all_res['cnt'];

// 검색 결과 데이터 수
$total_sql = " SELECT count(DISTINCT m.hero_code) as cnt";
$total_sql .= " FROM member m ";
$total_sql .= " LEFT JOIN quality_evaluation qe ON m.hero_code = qe.hero_code ";
$total_sql .= " WHERE m.hero_use = 0" . $search;

$total_result = sql($total_sql);
$out_res = mysql_fetch_assoc($total_result);
$total_data = $out_res['cnt'];
$i = $total_data;

$list_page=$_REQUEST['list_count']==""?20:$_REQUEST['list_count'];
$page_per_list=10;

if(!strcmp($_GET['page'], '')) {
    $page = '1';
} else {
    $page = $_GET['page'];
    $i = $i-($page-1)*$list_page;
}

$start = ($page-1)*$list_page;
$next_path=get("page");

//리스트
$sql = " SELECT m.hero_code as member_code, m.hero_id, m.hero_nick, m.hero_name ";
$sql .= " , qe.* "; // member_gisu 테이블의 컬럼 추가
$sql .= " FROM member m ";
$sql .= " LEFT JOIN quality_evaluation qe ON m.hero_code = qe.hero_code ";
$sql .= " WHERE m.hero_use = 0 " . $search;
$sql .= " GROUP BY m.hero_code ";
$sql .= " ORDER BY m.hero_idx DESC ";
$sql .= " LIMIT " . $start . "," . $list_page;

$list_res = sql($sql);
?>
<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/user.css?v=250617" type="text/css" />

<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
    <input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
    <input type="hidden" name="board" value="<?=$_GET["board"]?>" />
    <input type="hidden" name="page" value="<?=$page?>" />
    <input type="hidden" name="member_code" value="" />
    <input type="hidden" name="view" value="" />

    <!-- 회원 관리 퀄리티 평가 검색 필터 -->
    <table class="searchBox">
        <colgroup>
            <col width="171px" />
            <col width="*" />
        </colgroup>
        <tr>
            <th>퀄리티</th>
            <td>
                <div class="search_inner sup">
                    <label class="akContainer">전체
                        <input type="checkbox" name="quality_chk" value="0">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">최상
                        <input type="checkbox" name="quality_chk" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">상
                        <input type="checkbox" name="quality_chk" value="2">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">중
                        <input type="checkbox" name="quality_chk" value="3">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">하
                        <input type="checkbox" name="quality_chk" value="4">
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
        </tr>
        <tr>
            <th>
                검색
            </th>
            <td>
                <div class="search_inner">
                    <div class="select-wrap">
                        <select name="select">
                            <option value="none" <?=!isset($_GET["select"]) || $_GET["select"] == "none" ? "selected" : ""?>>선택</option>
                            <option value="hero_memo" <?=$_GET["select"] == "m.memo" ? "selected" : ""?>>내용</option>
                            <option value="hero_nick" <?=$_GET["select"] == "m.hero_nick" ? "selected" : ""?>>닉네임</option>
                            <option value="hero_id" <?=$_GET["select"] == "m.hero_id" ? "selected" : ""?>>아이디</option>
                            <option value="hero_name" <?=$_GET["select"] == "m.hero_name" ? "selected" : ""?>>이름</option>
                        </select>
                    </div>
                    <input class="search_txt" type="text" name="kewyword" value="<?=$_GET["kewyword"]?>"/>
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

<div class="evalutation_wrap mgt27">
    <ul class="evalutation_info">
        <li class="point">평가단계 : 4단계</li>
        <li>하 (0점~29점)</li>
        <li>중 (30점~69점)</li>
        <li>상 (70점~100점)</li>
        <li>최상 (70점 이상 + 팔로우 10K이상)</li>
    </ul>
    <table cellspacing="0" class="evalutation_table mgt15">
        <colgroup>
            <col width="40">
            <col width="40">
            <col width="140">
            <col width="120">
            <col width="120">
            <col width="120">
            <col width="120">
            <col width="130">
            <col width="130">
            <col width="130">
        </colgroup>
        <thead>
        <tr>
            <th colspan="2">평가 항목</th>
            <th>이미지 (30%)</th>
            <th colspan="2">텍스트 (25%)</th>
            <th colspan="2">가이드 (25%)</th>
            <th>인게이지먼트 (20%)</th>
            <th>팔로워 수</th>
            <th>상위 노출</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td colspan="2">기준</td>
            <td class="left">
                [비주얼]<br>
                1) 선명도, 밝기가 적절한가?<br>
                2) 깔끔한 배경에서 제품에 초점이<br>
                맞춰 촬영 되었는가?
            </td>
            <td class="left">
                [가독성]<br>
                띄어쓰기, 문단, 구분, 폰트 크기와 컬러가 적절한가?
            </td>
            <td class="left">
                [정성도]<br>
                가이드'복붙'이 아닌 본인의 리얼 리뷰가<br>
                반영되었는가?
            </td>
            <td class="left">
                [이미지]<br>
                촬영 컷 가이드를 모두 준수하였는가?<br>
                (제품 컷, B&A 컷 포함 여부 등)
            </td>
            <td class="left">
                [텍스트]<br>
                필수 키워드, 키메세지, 내용이<br>
                모두 반영되었는가?
            </td>
            <td class="left">
                좋아요+댓글 수 총합이 10개 이상인가?
            </td>
            <td class="left">
                구독자 수, 팔로워 수가 10K 이상인가?
            </td>
            <td class="left">
                상위 노출된 콘텐츠가 있는가?
            </td>
        </tr>
        <tr>
            <td rowspan="3">배점</td>
            <td>○</td>
            <td>100</td>
            <td>50</td>
            <td>50</td>
            <td>50</td>
            <td>50</td>
            <td>100</td>
            <td rowspan="3" colspan="2">총 점수 70점 이상이면서 둘 다 O 일 경우, 최상 등급</td>
        </tr>
        <tr>
            <td>△</td>
            <td>50</td>
            <td>25</td>
            <td>25</td>
            <td>25</td>
            <td>25</td>
            <td>50</td>
        </tr>
        <tr>
            <td>×</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        </tbody>
    </table>
</div>

<div class="tableSection mgt30">
    <div class="table_top">
        <h2 class="table_tit">검색 결과</h2>
        <p class="postNum"><span class="line"><?=number_format($total_data)?>개</span><span class="op_5">전체 <?=number_format($total_all)?>개</span></p>
    </div>
    <p class="table_desc"></p>
    <div class="searchResultBox_container">
        <table class="searchResultBox">
            <colgroup>
                <col width="45px" />
                <col width="70px" />
                <col width="70px" />
                <col width="70px" />
                <col width="70px" />
                <col width="70px" />
                <col width="75px" />
                <col width="75px" />
                <col width="75px" />
                <col width="75px" />
                <col width="75px" />
                <col width="75px" />
                <col width="75px" />
            </colgroup>
            <thead>
            <th>
                <div class="">
                    NO
                </div>
            </th>
            <th>
                <div class="">
                    이름
                </div>
            </th>
            <th>
                <div class="">
                    아이디
                </div>
            </th>
            <th>
                <div class="">
                    닉네임
                </div>
            </th>
            <th>
                <div class="">
                    이미지퀄리티
                </div>
            </th>
            <th>
                <div class="">
                    텍스트퀄리티
                </div>
            </th>
            <th>
                <div class="">
                    가이드 준수
                </div>
            </th>
            <th>
                <div class="">
                    인게이지먼트
                </div>
            </th>
            <th>
                <div class="">
                    팔로워 수
                </div>
            </th>
            <th>
                <div class="">
                    상위 노출
                </div>
            </th>
            <th>
                <div class="">
                    합계 점수
                </div>
            </th>
            <th>
                <div class="">
                    평가단계
                </div>
            </th>
            <th>
                <div class="">
                    보기
                </div>
            </th>
            </thead>
            <tbody>
            <?
            if($total_data > 0) {
            while($list = mysql_fetch_assoc($list_res)) {
            ?>
            <tr>
                <td>
                    <div class="table_result_no">
                        <?=$i?>
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        <?=$list["hero_name"]?>
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        <?=$list["hero_id"]?>
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        <?=$list["hero_nick"]?>
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        -
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        -
                    </div>
                </td>
                <td class="title">
                    <div class="table_result_contents pop_btn_01">
                        -
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        -
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        -
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        -
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        -
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        -
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        <a href="<?=PATH_HOME.'?'.get('page');?>&view=qualityEvaluationView&hero_code=<?=$list["member_code"]?>" class="btnAdd5">수정</a>
                    </div>
                </td>
            </tr>
                <?
                --$i;
            }
            } else {
            ?>
            <!-- 데이터가 없을 때 추가해주세요. -->
            <tr>
                <td colspan="13" class="no_data">등록된 데이터가 없습니다.</td>
            </tr>
                <?
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<div class="pagingWrap">
    <?php
    // 체크박스 항목 array 처리하여 전달
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

<script>
    $(document).ready(function(){

        //fnView = function(member_code) {
        //    $("input[name='member_code']").val(member_code);
        //    $("input[name='view']").val("qualityEvaluationView");
        //    $("#searchForm").attr("action","<?php //=PATH_HOME?>//").submit();
        //    console.log(member_code);
        //}
    })
</script>
