<!-- /loaksecure21/index.php?idx=147&board=user&page=1&view=premierSupportersView -->
<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/user.css?v=250617" type="text/css" />

<?
if(!defined('_HEROBOARD_'))exit;

// 해당 서포터즈 정보 추출
$supporters_sql  = " SELECT * FROM supporters WHERE idx = '".$_GET["sno"]."' ";
$supporters_res = sql($supporters_sql,"on");
$view = mysql_fetch_assoc($supporters_res);

$startDt = substr($view["startDt"], 0, 10);
$endDt = substr($view["endDt"], 0, 10);  // YYYY-MM-DD 부분만 추출


// 서포터즈 그룹 회원 리스트
$search = "";

// 그룹(팀) 검색
if( !empty($_GET["hero_supports_group"]) && is_array($_GET["hero_supports_group"]) ) {
    $group_conditions = array(); // array() 사용

    foreach($_GET["hero_supports_group"] as $hero_supports_group) {
        switch($hero_supports_group) {
            case "b": // 블로그
                $group_conditions[] = "(sm.hero_supports_group not like '' and sm.hero_supports_group = 'b')";
                break;
            case "i": // 인스타
                $group_conditions[] = "(sm.hero_supports_group not like '' and sm.hero_supports_group = 'i')";
                break;
            case "s": // 숏폼
                $group_conditions[] = "(sm.hero_supports_group not like '' and sm.hero_supports_group = 's')";
                break;
        }
    }
    if(!empty($group_conditions)) {
        $search .= " AND (" . implode(" OR ", $group_conditions) . ")";
    }
}

// 전체페이지
$total_all_sql = " SELECT count(sm.idx) as cnt FROM supporters_mem_info sm 
                  LEFT JOIN member m on sm.hero_code = m.hero_code 
                  LEFT JOIN quality_evaluation qe on sm.hero_code = qe.hero_code
                  WHERE supporters_idx = ".$_GET["sno"];
$total_all_result = sql($total_all_sql);
$total_all_res = mysql_fetch_assoc($total_all_result);
$total_cnt = $total_all_res['cnt'];

//페이지 넘버링
$total_sql = " SELECT count(sm.idx) as cnt FROM supporters_mem_info sm
               LEFT JOIN member m on sm.hero_code = m.hero_code 
               LEFT JOIN quality_evaluation qe on sm.hero_code = qe.hero_code
               WHERE sm.supporters_idx = ".$_GET["sno"]."".$search;
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


$sql  = " SELECT sm.*, m.hero_id, m.hero_name,m.hero_nick,m.hero_jumin,m.hero_sex,m.hero_oldday,qe.grade";
$sql .= " FROM supporters_mem_info sm
          LEFT JOIN member m ON sm.hero_code = m.hero_code
          LEFT JOIN quality_evaluation qe ON sm.hero_code = qe.hero_code";
$sql .= " WHERE sm.supporters_idx = ".$_GET["sno"]."".$search;
$sql .= " ORDER BY sm.idx DESC LIMIT ".$start.",".$list_page;

$list_res = sql($sql);

?>

<form name="infoForm" id="infoForm" action="<?=PATH_HOME.'?'.get('page');?>">
    <input type="hidden" name="sno" value="<?=$_GET["sno"]?>" />
    <input type="hidden" name="board" value="<?=$_GET["board"]?>" />
    <input type="hidden" name="view" value="<?=$_GET["view"]?>" />
    <!-- 회원 관리 퀄리티 평가 검색 필터 -->
    <table class="searchBox">
        <colgroup>
            <col width="171px" />
            <col width="*" />
        </colgroup>
        <tr>
            <th>
                모집 기간
            </th>
            <td>
                <div class="search_inner">
                    <input class="search_txt" type="text" name="recruit" value="<?=$view["recruit"]?>"/>
                </div>
            </td>
        </tr>
        <tr>
            <th>
                서포터즈명
            </th>
            <td>
                <div class="search_inner">
                    <div class="search_inner">
                        <select class="search_txt" name="hero_board">
                            <option value="group_04_06" <?=$view["hero_board"] == "group_04_06" ? "selected" : ""?>>프리미어 뷰티 클럽</option>
                            <option value="group_04_28" <?=$view["hero_board"] == "group_04_28" ? "selected" : ""?>>프리미어 라이프 클럽</option>
                        </select>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <th>
                활동 기간
            </th>
            <td>
                <div class="search_inner">
                    <div class="dateMode_box">
                        <input type="text" name="startDate" class="dateMode" value="<?=$startDt?>">
                    </div>
                    <div class="inner_between">~</div>
                    <div class="dateMode_box">
                        <input type="text" name="endDate" class="dateMode" value="<?=$endDt?>">
                    </div>
                    <a class="btnAdd5 mgl20">기간 수정</a>
                </div>
            </td>
        </tr>
    </table>
</form>

<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
    <input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
    <input type="hidden" name="sno" value="<?=$_GET["sno"]?>" />
    <input type="hidden" name="board" value="<?=$_GET["board"]?>" />
    <input type="hidden" name="page" value="<?=$page?>" />
    <input type="hidden" name="view" value="<?=$_GET["view"]?>" />

    <input type="hidden" name="mode" value="" />

    <!-- 서포터즈 그룹검색 필터 -->
    <table class="searchBox">
        <colgroup>
            <col width="171px" />
            <col width="*" />
        </colgroup>
        <tr>
            <th>
                그룹 선택
            </th>
            <td>
                <?php
                $hero_supports_group = (isset($_GET['hero_supports_group']) && is_array($_GET['hero_supports_group'])) ? $_GET['hero_supports_group'] : array();
                ?>
                <div class="search_inner">
                    <label class="akContainer">블로그
                        <input type="checkbox" name="hero_supports_group[]" value="b" <?php echo (is_array($hero_supports_group) && in_array('b', $hero_supports_group)) ? 'checked' : ''; ?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">인스타
                        <input type="checkbox" name="hero_supports_group[]" value="i" <?php echo (is_array($hero_supports_group) && in_array('i', $hero_supports_group)) ? 'checked' : ''; ?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">숏폼
                        <input type="checkbox" name="hero_supports_group[]" value="s" <?php echo (is_array($hero_supports_group) && in_array('s', $hero_supports_group)) ? 'checked' : ''; ?>>
                        <span class="checkmark"></span>
                    </label>
                    <a class="btnAdd5 mgl20" onClick="fnSearch()">그룹 검색</a>
                </div>
            </td>
        </tr>
    </table>
</form>


<div class="tableSection mgt30">
    <div class="table_top">
        <div>
            <h2 class="table_tit">검색 결과</h2>
            <div class="postNum">
                <span class="line"><?=number_format($total_data)?>개</span><span class="op_5">전체 <?=number_format($total_cnt)?>개</span>
            </div>
        </div>
        <div class="table_btn bottom">
            <a class="btnAdd3 popup_btn" data-popup="01">선정자 추가하기</a>
            <a class="btnAdd3">회원 목록 다운로드</a>
            <a class="btnAdd3" onclick="fnDel();">선택 삭제</a>
            <a class="btnAdd3" onclick="fnMemo();">비고 작성 저장</a>
        </div>
    </div>
    <p class="table_desc"></p>
    <div class="searchResultBox_container mu_form">
        <table class="searchResultBox">
            <colgroup>
                <col width="45px" />
                <col width="45px" />
                <col width="70px" />
                <col width="70px" />
                <col width="70px" />
                <col width="50px" />
                <col width="50px" />
                <col width="70px" />
                <col width="70px" />
                <col width="70px" />
                <col width="140px" />
            </colgroup>
            <thead>
            <th>
                <div class="">
                    <label class="akContainer">
                        <input type="checkbox" name="all">
                        <span class="checkmark"></span>
                    </label>
                </div>
            </th>
            <th>
                <div class="">
                    NO
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
                    이름
                </div>
            </th>
            <th>
                <div class="">
                    나이
                </div>
            </th>
            <th>
                <div class="">
                    성별
                </div>
            </th>
            <th>
                <div class="">
                    그룹
                </div>
            </th>
            <th>
                <div class="">
                    SNS 퀄리티등급
                </div>
            </th>
            <th>
                <div class="">
                    가입일
                </div>
            </th>
            <th>
                <div class="">
                    비고
                </div>
            </th>
            </thead>
            <tbody>
            <?
            if($total_data > 0) {
            while($list = mysql_fetch_assoc($list_res)) {
            $age = (date("Y")-substr($list["hero_jumin"],0,4))+1;
            $hero_sex_txt = "";
            if($list["hero_sex"] == 1) {
                $hero_sex_txt = "남";
            } else if(strlen($list["hero_sex"]) > 0 && $list["hero_sex"] == 0) {
                $hero_sex_txt = "여";
            }
            if($list["hero_supports_group"] == 'b') {
                $hero_supports_group = "블로그";
            } else if($list["hero_supports_group"] == 'i') {
                $hero_supports_group = "인스타그램";
            } else if($list["hero_supports_group"] == 's') {
                $hero_supports_group = "숏폼";
            } else {
                $hero_supports_group = "";
            }
            ?>
            <tr>
                <td>
                    <div class="table_checkbox" style="position:relative">
                        <label class="akContainer">
                            <input type="checkbox" name="hero_code" value="<?=$list['hero_code']?>" class="rowCheck">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="table_result_no">
                        <?=$i?>
                    </div>
                </td>
                <td>
                    <div class="table_result_id">
                        <?=$list['hero_id']?>
                    </div>
                </td>
                <td>
                    <div class="">
                        <?=$list['hero_nick']?>
                    </div>
                </td>
                <td>
                    <div class="table_result_name">
                        <?=$list['hero_name']?>
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        <?=$age?>
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        <?=$hero_sex_txt?>
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        <?=$hero_supports_group?>
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        <?=$list['grade']?>
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        <?=$list['hero_oldday']?>
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        <input type="text" name="memo" value="<?=$list['memo']?>"/>
                    </div>
                </td>
            </tr>

            <?
                $i--;
            }
            } else {?>
                <tr>
                    <td colspan="11">검색된 데이터가 없습니다.</td>
                </tr>
            <? } ?>

            <!-- 데이터가 없을 때 추가해주세요. -->
            <!-- <tr>
                <td colspan="11" class="no_data">등록된 데이터가 없습니다.</td>
            </tr> -->
            </tbody>
        </table>
    </div>
</div>

<div class="pagingWrap">
    <?
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

<!--선정자 추가 팝업 iframe 호출로 변경 25.07.14 musign jnr-->
<div class="popup_url_box popup_supporters_selected" id="pop_01">
    <div class="popup_url_cont height_typeA">
        <div class="popup_url_head">
            <svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.41073 4.41083C4.73617 4.08539 5.26381 4.08539 5.58925 4.41083L15.5892 14.4108C15.9147 14.7363 15.9147 15.2639 15.5892 15.5893C15.2638 15.9148 14.7362 15.9148 14.4107 15.5893L4.41073 5.58934C4.0853 5.2639 4.0853 4.73626 4.41073 4.41083Z" fill="black"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5892 4.41083C15.2638 4.08539 14.7362 4.08539 14.4107 4.41083L4.41072 14.4108C4.08529 14.7363 4.08529 15.2639 4.41072 15.5893C4.73616 15.9148 5.2638 15.9148 5.58924 15.5893L15.5892 5.58934C15.9147 5.2639 15.9147 4.73626 15.5892 4.41083Z" fill="black"></path>
            </svg>
        </div>
        <div class="popup_url_body mu_form" id="popupContent">
            <iframe src="/loaksecure21/user/popPremierSupportersMem.php?sno=<?=$_GET["sno"]?>&hero_board=<?=$view["hero_board"]?>" width="660" height="720" frameborder="0" class="iframe_popup"></iframe>
        </div>
    </div>
</div>

<script>
    // 서브 제목 수정
    const subTittle = document.querySelector("#content .sub_tit");
    subTittle.innerText = "프리미어 서포터즈 명단 관리";

    $(document).ready(function(){
        // 그룹 검색
        fnSearch = function() {
            $("#searchForm").attr("action","").submit();
        }

        // 비고작성 저장
        fnMemo = function() {
            // 체크된 hero_code 값과 그룹을 배열로 수집
            var selectedCodes = [];
            var selectedMemos = [];

            $(".rowCheck:checked").each(function() {
                var heroCode = $(this).val();
                // 해당 row의 비고입력 값 찾기
                var heroMemo = $(this).closest('tr').find('input[name="memo"]').val()
                selectedCodes.push(heroCode);
                selectedMemos.push(heroMemo);
            });

            if(selectedCodes.length === 0) {
                alert("선택된 회원이 없습니다.");
                return;
            }

            if(confirm("선정자에서 삭제하겠습니까?")) {
                var formData =[];

                // 배열 데이터들을 formData에 추가
                for(var i = 0; i < selectedCodes.length; i++) {
                    formData.push({
                        name: 'hero_codes[]',
                        value: selectedCodes[i]
                    });
                    formData.push({
                        name: 'memos[]',
                        value: selectedMemos[i]
                    });
                    formData.push({
                        name: 'supporters_idx',
                        value: '<?=$_GET["sno"]?>'
                    });
                    formData.push({
                        name: 'mode',
                        value: 'insert_memo'
                    });
                }

                var param = $.param(formData);

                $.ajax({
                    url:"/loaksecure21/user/premierSupportersAct.php"
                    ,type:"POST"
                    ,data:param
                    ,dataType:"json"
                    ,success:function(d){
                        console.log(d);
                        if(d.result == 1) {
                            alert("수정하였습니다.");
                            location.reload();
                        } else {
                            alert("실행 중 실패했습니다: " + d.error);
                        }
                    },error:function(e){
                        console.log(e);
                        alert("실패했습니다.");
                    }
                })
            }

        }

        // 선택삭제
        fnDel = function() {
            // 체크된 hero_code 값과 그룹을 배열로 수집
            var selectedCodes = [];

            $(".rowCheck:checked").each(function() {
                var heroCode = $(this).val();
                selectedCodes.push(heroCode);
            });
            if(selectedCodes.length === 0) {
                alert("선택된 회원이 없습니다.");
                return;
            }

            if(confirm("선정자에서 삭제하겠습니까?")) {
                var formData =[];

                // 배열 데이터들을 formData에 추가
                for(var i = 0; i < selectedCodes.length; i++) {
                    formData.push({
                        name: 'hero_codes[]',
                        value: selectedCodes[i]
                    });
                    formData.push({
                        name: 'supporters_idx',
                        value: '<?=$_GET["sno"]?>'
                    });
                    formData.push({
                        name: 'mode',
                        value: 'delete_mem'
                    });
                }

                var param = $.param(formData);

                $.ajax({
                    url:"/loaksecure21/user/premierSupportersAct.php"
                    ,type:"POST"
                    ,data:param
                    ,dataType:"json"
                    ,success:function(d){
                        console.log(d);
                        if(d.result == 1) {
                            alert("삭제하였습니다.");
                            location.reload();
                        } else {
                            alert("실행 중 실패했습니다: " + d.error);
                        }
                    },error:function(e){
                        console.log(e);
                        alert("실패했습니다.");
                    }
                })
            }

        }

        // 회원목록 다운로드
        fnExcel = function() {
            var form = document.getElementById('searchForm');
            form.action = '/loaksecure21/user/userManger_excel.php';
            form.submit();
            //$("#searchForm").attr("action","/loaksecure21/user/userManger_excel.php").submit();
        }
    })
</script>