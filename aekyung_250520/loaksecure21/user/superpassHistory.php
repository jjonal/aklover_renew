<?
if(!defined('_HEROBOARD_'))exit;

$search = "";


// 250707 슈퍼패스 지급내역 검색 musign jnr
if( !empty($_GET["superpass_check"]) && is_array($_GET["superpass_check"]) ) {

    $superpass_conditions = array(); // array() 사용

    foreach($_GET["superpass_check"] as $superpass_type) {
        switch($superpass_type) {
            case "Y": // 지급
                $superpass_conditions[] = "(s.superpass_check = 'Y')";
                break;
            case "N": // 미지급
                $superpass_conditions[] = "(s.superpass_check = 'N')";
                break;
        }
    }

    if(!empty($superpass_conditions)) {
        $search .= " AND (" . implode(" OR ", $superpass_conditions) . ")";
    }
}


if($_GET["kewyword"] && $_GET["select"] != 'none') { //
    if($_GET["select"] == 'hero_nick') { // 닉네임 검색
        $_GET["select"] = "m.".$_GET["select"];
    } elseif ($_GET["select"] == 'hero_name') { // 이름
        $_GET["select"] = "m.".$_GET["select"];
    } elseif ($_GET["select"] == 'hero_id') { // 아이디
        $_GET["select"] = "m.".$_GET["select"];
    }
    $search .= " AND ".$_GET["select"]." like '%".$_GET["kewyword"]."%' ";
}

// 전체페이지
$total_all_sql = " SELECT count(*) as cnt FROM superpass_history s INNER JOIN member m ON s.hero_code = m.hero_code WHERE 1=1";
$total_all_result = sql($total_all_sql);
$total_all_res = mysql_fetch_assoc($total_all_result);
$total_cnt = $total_all_res['cnt'];

//페이지 넘버링
$total_sql = " SELECT count(*) as cnt FROM superpass_history s INNER JOIN member m ON s.hero_code = m.hero_code WHERE 1=1 ".$search;
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

$sql  = " SELECT ";
$sql .= " m.hero_code,m.hero_nick, m.hero_id, m.hero_name, s.panelty_check, s.login_a_month_ago_check  ";
$sql .= " , s.blog_check, s.write_check, s.superpass_check, s.hero_today  ";
$sql .= " FROM superpass_history s INNER JOIN member m ON s.hero_code = m.hero_code ";
$sql .= " WHERE 1=1 ".$search;
$sql .= " ORDER BY s.hero_idx DESC LIMIT ".$start.",".$list_page;


$list_res = sql($sql);
?>
<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
    <input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
    <input type="hidden" name="board" value="<?=$_GET["board"]?>" />


    <!-- 250625 슈퍼패스 지급내역 검색 필터 -->
    <table class="searchBox">
        <colgroup>
            <col width="171px" />
            <col width="*" />
        </colgroup>
        <tr>
            <th>지급/미지급</th>
            <td>
                <div class="search_inner sup">
                    <?php
                    $superpass_check = (isset($_GET['superpass_check']) && is_array($_GET['superpass_check'])) ? $_GET['superpass_check'] : array();
                    ?>
                    <label class="akContainer">전체
                        <input type="checkbox" <?php echo (!isset($_GET['superpass_check']) || empty($superpass_check)) ? 'checked' : ''; ?> name="superpass_check[]" value="">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">지급
                        <input type="checkbox" <?php echo (is_array($superpass_check) && in_array('Y', $superpass_check)) ? 'checked' : ''; ?> name="superpass_check[]" value="Y">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">미지급
                        <input type="checkbox" <?php echo (is_array($superpass_check) && in_array('N', $superpass_check)) ? 'checked' : ''; ?> name="superpass_check[]" value="N">
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

    <!-- 250625 검색필터 기존 주석처리 -->
    <!-- <table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>지급/미지급</th>
		<td>
			<input type="radio" name="superpass_check" id="superpass_check" <?=!$_GET["superpass_check"] ? "checked":""; ?> value=""><label for="superpass_check">전체</label>
			<input type="radio" name="superpass_check" id="superpass_check_y" <?=$_GET["superpass_check"]=="Y" ? "checked":""; ?> value="Y"><label for="superpass_check_y">지급</label>
			<input type="radio" name="superpass_check" id="superpass_check_n" <?=$_GET["superpass_check"]=="N" ? "checked":""; ?> value="N"><label for="superpass_check_n">미지급</label>
		</td>
	</tr>
	<tr>
		<th>검색어</th>
		<td>
			<select name="select">
		    	<option value="hero_nick" <?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>닉네임</option>
		    	<option value="hero_name" <?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>이름</option>
		    	<option value="hero_id" <?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>아이디</option>
	    	</select>
	    	<input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];;?>" class="kewyword">
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">검색</a>
</div> -->
</form>

<div class="descWrap mgt30">
    <p class="dw_tit"><label>슈퍼패스 조건</label></p>
    <p class="dw_desc">
        1. 매달 처음 로그인할 때 지급 가능</br>
        2. 로그인 시점에 3개월 이전에 패널티가 없어야 함</br>
        3. 로그인 시점에 한달 전에 로그인한 기록이 있어야함 </br>
        4. 블로그+영상 url 존재</br>
        5. 한달이전에 등록한 글 또는 댓글 존재</br></br>
        ex) 1번 조건이 성립되지 않으면 히스토리가 없음
    </p>
</div>

<div class="tableSection mgt30">
    <div class="table_top">
        <div>
            <h2 class="table_tit">검색 결과</h2>
            <p class="postNum"><span class="line"><?=number_format($total_data)?>개</span><span class="op_5">전체 <?=number_format($total_cnt)?>개</span></p>
        </div>
        <a class="table_btn bottom btnAdd3 popup_btn" data-popup="01">슈퍼패스 지급</a>
    </div>
    <p class="table_desc"></p>
    <div class="searchResultBox_container">
        <table class="searchResultBox">
            <colgroup>
                <col width="30px" />
                <col width="45px" />
                <col width="70px" />
                <col width="70px" />
                <col width="70px" />
                <col width="60px" />
                <col width="60px" />
                <col width="60px" />
                <col width="75px" />
                <col width="75px" />
                <col width="75px" />
            </colgroup>
            <thead>
            <th>
                <input type="checkbox" id="checkAll" />
            </th>
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
                    패널티
                </div>
            </th>
            <th>
                <div class="">
                    한달 전 로그인
                </div>
            </th>
            <th>
                <div class="">
                    블로그/영상
                </div>
            </th>
            <th>
                <div class="">
                    작성글
                </div>
            </th>
            <th>
                <div class="">
                    지급우뮤
                </div>
            </th>
            <th>
                <div class="">
                    로그인날짜
                </div>
            </th>
            </thead>
            <tbody>
            <?
            if($total_data > 0) {
                while($list = mysql_fetch_assoc($list_res)) {
                    $superpass_txt = "";
                    if($list["superpass_check"] == "Y") {
                        $superpass_txt = "지급";
                    } else {
                        $superpass_txt = "미지급";
                    }

                    // 패널티
                    if($list['panelty_check'] == 'Y') $panelty_check = '○';
                    else $panelty_check = '×';

                    // 한달 전 로그인
                    if($list['login_a_month_ago_check'] == 'Y') $monthAgo_check = '○';
                    else $monthAgo_check = '×';

                    // 블로그/영상
                    if($list['blog_check'] == 'Y') $blog_check = '○';
                    else $blog_check = '×';

                    // 작성글
                    if($list['write_check'] == 'Y') $write_check = '○';
                    else $write_check = '×';

                    ?>
                    <tr>
                        <td>
                            <div class="table_result_no">
                            <input type="checkbox" name="hero_codes[]" value="<?=$list['hero_code']?>" class="rowCheck" />
                            </div>
                        </td>
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
                                <?=$panelty_check?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_nick">
                                <?=$monthAgo_check?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_nick">
                                <?=$blog_check?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_nick">
                                <?=$write_check?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_nick">
                                <?=$superpass_txt?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_create">
                                <?=$list["hero_today"]?>
                            </div>
                        </td>
                    </tr>
                    <?
                    $i--;
                }
            } else {
                ?>
                <tr>
                    <td colspan="11" class="no_data">등록된 데이터가 없습니다.</td>
                </tr>
            <?}?>
            </tbody>
        </table>
    </div>
</div>


<!--프리미어 서포터즈 선정 및 관리 팝업-->
<div class="popup_url_box" id="pop_01">
    <div class="popup_url_cont height_type_A">
        <div class="popup_url_head">
            <svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.41073 4.41083C4.73617 4.08539 5.26381 4.08539 5.58925 4.41083L15.5892 14.4108C15.9147 14.7363 15.9147 15.2639 15.5892 15.5893C15.2638 15.9148 14.7362 15.9148 14.4107 15.5893L4.41073 5.58934C4.0853 5.2639 4.0853 4.73626 4.41073 4.41083Z" fill="black"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5892 4.41083C15.2638 4.08539 14.7362 4.08539 14.4107 4.41083L4.41072 14.4108C4.08529 14.7363 4.08529 15.2639 4.41072 15.5893C4.73616 15.9148 5.2638 15.9148 5.58924 15.5893L15.5892 5.58934C15.9147 5.2639 15.9147 4.73626 15.5892 4.41083Z" fill="black"></path>
            </svg>
        </div>
        <div class="popup_url_body ori">
            <div class="tit">슈퍼패스 지급</div>
            <div class="popup_url_link_item_v3">
                <form name="writeForm" id="writeForm" method="POST">
                    <input type="hidden" name="hero_code" value="<?=$hero_code?>" />
                    <input type="hidden" name="mode" value="chkSuperpass" />
                    <table class="mgt10 mu_table mu_form">
                        <colgroup>
                            <col width="*">
                            <col width="150">
                        </colgroup>
                        <thead>
                        <tr>
                            <th>타입</th>
                            <th>만료일</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input type="text" name="hero_kind" /></td>
                            <td>
                                <div class="calendar">
                                    <input type="text" name="hero_endday" class="dateMode w100p" style="vertical-align:bottom" />
                                </div>
                            </td>
                        <tr>
                        </tbody>
                    </table>
                    <div class="btnContainer mgt20 mgb20">
                        <a href="javascript:;" onClick="fnSuperpass();" class="btnAdd3">슈퍼패스 지급</a>
                    </div>
                </form>
            </div>
        </div>
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
<script>
    $(document).ready(function(){

        // 체크박스 전체 선택/해제
        $("#checkAll").change(function() {
            $(".rowCheck").prop('checked', $(this).prop("checked"));
        });

        fnSearch = function() {
            $("#searchForm").attr("action","").submit();
        }

        fnSuperpass = function() {
            // 체크된 hero_code 값들을 배열로 수집
            var selectedCodes = [];
            $(".rowCheck:checked").each(function() {
                selectedCodes.push($(this).val());
            });

            if(selectedCodes.length === 0) {
                alert("선택된 회원이 없습니다.");
                return;
            }
            if(!$("input[name='hero_kind']").val()) {
                alert("지급할 타입을 입력해 주세요.");
                $("input[name='hero_kind']").focus();
                return;
            }

            if(!$("input[name='hero_endday']").val()) {
                alert("만료기간을 입력해 주세요.");
                $("input[name='hero_endday']").focus();
                return;
            }

            if(confirm("선택한 " + selectedCodes.length + "명의 회원에게 슈퍼패스를 지급하시겠습니까?")) {
                var formData = $("#writeForm").serializeArray();

                // hero_code array 추가
                formData.push({
                    name: 'hero_codes',
                    value: selectedCodes
                });
                var param = $.param(formData);
                $.ajax({
                    url:"/loaksecure21/user/popUserManagerSuperpassListAction.php"
                    ,type:"POST"
                    ,data:param
                    ,dataType:"json"
                    ,success:function(d){
                        console.log(d);
                        if(d.result==1) {
                            alert("슈퍼패스가 지급되었습니다.");
                            location.reload();
                        } else {
                            alert("실행 중 실패했습니다.")
                        }
                    },error:function(e){
                        console.log(e);
                        alert("실패했습니다.");
                    }
                });
            }
        }
    })
</script>


