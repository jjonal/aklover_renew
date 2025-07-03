<?
if(!defined('_HEROBOARD_'))exit;

$search = "";

// 전체페이지 및 검색 sql 추가 25.07.02 jnr musign
if( !empty($_GET["type"]) && is_array($_GET["type"]) ) {

    $type_conditions = array(); // array() 사용

    foreach($_GET["type"] as $type) {
        switch($type) {
            case "1": // 이중아이디
                //$search .= " AND ".$_GET["hero_blog"]." like '%".$_GET["url"]."%' ";
                $type_conditions[] = "p.type = '1'";
                break;
            case "2": // 가이드라인 미준수
                $type_conditions[] = "p.type = '2'";
                break;
            case "3": // 후기 미등록
                $type_conditions[] = "p.type = '3'";
                break;
            case "4": // 오프라인 모임 미참여
                $type_conditions[] = "p.type = '4'";
                break;
            case "5": // 품평/설문 미진행
                $type_conditions[] = "p.type = '5'";
                break;
            case "9": // 기타
                $type_conditions[] = "p.type = '9'";
                break;
        }
    }

    if(!empty($type_conditions)) {
        $search .= " AND (" . implode(" OR ", $type_conditions) . ")";
    }
}


if($_GET["kewyword"] && $_GET["select"] != 'none') { //
    if($_GET["select"] == 'hero_nick') { // 닉네임 검색
        $_GET["select"] = "m".$_GET["select"];
    } elseif ($_GET["select"] == 'hero_name') { // 이름
        $_GET["select"] = "m".$_GET["select"];
    } elseif ($_GET["select"] == 'hero_id') { // 아이디
        $_GET["select"] = "m".$_GET["select"];
    } elseif ($_GET["select"] == 'memo') { // 내용
        $_GET["select"] = "p".$_GET["select"];
    }
    $search .= " AND ".$_GET["select"]." like '%".$_GET["kewyword"]."%' ";
}



$total_all_sql = " SELECT count(*) as cnt FROM member_penalty p 
 LEFT JOIN member m ON p.hero_code = m.hero_code WHERE p.hero_use_yn='Y'";
$total_all_result = sql($total_all_sql);
$total_all_res = mysql_fetch_assoc($total_all_result);
$total_cnt = $total_all_res['cnt'];


//페이지 넘버링
$total_sql  = " SELECT count(*) as cnt FROM member_penalty p ";
$total_sql .= " LEFT JOIN member m ON p.hero_code = m.hero_code ";
$total_sql .= " WHERE p.hero_use_yn='Y' ".$search;
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

$sql  = " SELECT p.type, p.memo, p.hero_today ";
$sql .= " , m.hero_id, m.hero_name, m.hero_nick, m.hero_sex , m.hero_level ";
$sql .= " , m.hero_jumin, m.hero_use, m.hero_level ";
$sql .= " FROM member_penalty p ";
$sql .= " LEFT JOIN member m ON p.hero_code = m.hero_code ";
$sql .= " WHERE p.hero_use_yn='Y' ".$search;
$sql .= " ORDER BY p.hero_idx DESC LIMIT ".$start.",".$list_page;

$list_res = sql($sql);

var_dump($sql);
$type_arr = array("1"=>"이중아이디","2"=>"가이드라인 미준수","3"=>"후기 미등록","4"=>"오프라인 모임 미참여","5"=>"풍평/설문 미진행","9"=>"기타");
?>
<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
    <input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
    <input type="hidden" name="board" value="<?=$_GET["board"]?>" />

    <!-- 250625 SNS 주소 확인 검색 필터 -->
    <table class="searchBox">
        <colgroup>
            <col width="171px" />
            <col width="*" />
        </colgroup>
        <tr>
            <th>페널티 타입</th>
            <td>
                <div class="search_inner sup">
                    <?php
                    $type = (isset($_GET['type']) && is_array($_GET['type'])) ? $_GET['type'] : array();
                    ?>
                    <label class="akContainer">전체
                        <input type="checkbox" <?php echo (!isset($_GET['type']) || empty($type) || in_array('', $type)) ? 'checked' : ''; ?> name="type[]" value="">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">이중아이디
                        <input type="checkbox" <?php echo (is_array($type) && in_array('1', $type)) ? 'checked' : ''; ?> name="type[]" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">가이드라인 미준수
                        <input type="checkbox" <?php echo (is_array($type) && in_array('2', $type)) ? 'checked' : ''; ?> name="type[]" value="2">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">후기 미등록
                        <input type="checkbox" <?php echo (is_array($type) && in_array('3', $type)) ? 'checked' : ''; ?> name="type[]" value="3">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">오프라인 모임 미참여
                        <input type="checkbox" <?php echo (is_array($type) && in_array('4', $type)) ? 'checked' : ''; ?> name="type[]" value="4">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">품평/설문 미진행
                        <input type="checkbox" <?php echo (is_array($type) && in_array('5', $type)) ? 'checked' : ''; ?> name="type[]" value="5">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">기타
                        <input type="checkbox" <?php echo (is_array($type) && in_array('9', $type)) ? 'checked' : ''; ?> name="type[]" value="9">
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
                            <option value="hero_memo" <?=$_GET["select"] == "p.memo" ? "selected" : ""?>>내용</option>
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
		<th>패널티 타입</th>
		<td>
			<select name="type">
				<option value="">선택</option>
				<option value="1" <?=$_GET["type"]=="1" ? "selected":""?>>이중아이디</option>
				<option value="2" <?=$_GET["type"]=="2" ? "selected":""?>>가이드라인 미준수</option>
				<option value="3" <?=$_GET["type"]=="3" ? "selected":""?>>후기 미등록</option>
				<option value="4" <?=$_GET["type"]=="4" ? "selected":""?>>오프라인 모임 미참여</option>
				<option value="5" <?=$_GET["type"]=="5" ? "selected":""?>>품평/설문 미진행</option>
				<option value="9" <?=$_GET["type"]=="9" ? "selected":""?>>기타</option>
			</select>
		</td>
	</tr>
	<tr>
		<th>검색어</th>
		<td>
			<select name="select">
				<option value="p.memo" <?if(!strcmp($_REQUEST['select'], 'p.memo')){echo ' selected';}else{echo '';}?>>내용</option>
		    	<option value="m.hero_nick" <?if(!strcmp($_REQUEST['select'], 'm.hero_nick')){echo ' selected';}else{echo '';}?>>닉네임</option>
		    	<option value="m.hero_name" <?if(!strcmp($_REQUEST['select'], 'm.hero_name')){echo ' selected';}else{echo '';}?>>이름</option>
		    	<option value="m.hero_id" <?if(!strcmp($_REQUEST['select'], 'm.hero_id')){echo ' selected';}else{echo '';}?>>아이디</option>
	    	</select>
	    	<input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];;?>" class="kewyword">
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">검색</a>
</div> -->
</form>

<div class="tableSection mgt30">
    <div class="table_top">
        <h2 class="table_tit">검색 결과</h2>
        <p class="postNum"><span class="line"><?=number_format($total_data)?>개</span><span class="op_5">전체 <?=number_format($total_cnt)?>개</span></p>
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
                <col width="120px" />
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
                    서포터즈 구분
                </div>
            </th>
            <th>
                <div class="">
                    페널티 타입
                </div>
            </th>
            <th>
                <div class="">
                    상세 내용
                </div>
            </th>
            <th>
                <div class="">
                    등록일
                </div>
            </th>
            </thead>
            <tbody>
            <?
            if($total_data > 0) {
                while($list = mysql_fetch_assoc($list_res)) {
                    $age = "";
                    if($list["hero_jumin"]) {
                        $age = (date("Y")-substr($list["hero_jumin"],0,4))+1;
                    }

                    $hero_sex_txt = "";
                    if($list["hero_sex"] == 1) {
                        $hero_sex_txt = "남";
                    } else if(strlen($list["hero_sex"]) > 0 && $list["hero_sex"] == 0) {
                        $hero_sex_txt = "여";
                    }

                    $hero_use_txt = "";
                    if($list["hero_use"] == 0) {
                        $hero_use_txt = "회원";
                    } else if($list["hero_use"] == 1) {
                        $hero_use_txt = "탈퇴";
                    } else if($list["hero_use"] == 2) {
                        $hero_use_txt = "휴먼회원";
                    }
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
                                서포터즈 구분
                            </div>
                        </td>
                        <td>
                            <div class="table_result_types">
                                <?=$type_arr[$list["type"]]?>
                            </div>
                        </td>
                        <td class="title">
                            <div class="table_result_contents pop_btn_01">
                                <?=$list["memo"]?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_create">
                                <?=substr($list["hero_today"],0,10)?>
                            </div>
                        </td>
                    </tr>
                    <?
                    $i--;
                }
            } else {
                ?>
                <tr>
                    <td colspan="8" class="no_data">등록된 데이터가 없습니다.</td>
                </tr>
            <?}?>
            </tbody>
        </table>
    </div>
</div>

<!-- 페널티 상세 내용 팝업-->
<div class="popup_url_box">
    <div class="popup_url_cont height_typeB">
        <div class="popup_url_head">
            <svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.41073 4.41083C4.73617 4.08539 5.26381 4.08539 5.58925 4.41083L15.5892 14.4108C15.9147 14.7363 15.9147 15.2639 15.5892 15.5893C15.2638 15.9148 14.7362 15.9148 14.4107 15.5893L4.41073 5.58934C4.0853 5.2639 4.0853 4.73626 4.41073 4.41083Z" fill="black"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5892 4.41083C15.2638 4.08539 14.7362 4.08539 14.4107 4.41083L4.41072 14.4108C4.08529 14.7363 4.08529 15.2639 4.41072 15.5893C4.73616 15.9148 5.2638 15.9148 5.58924 15.5893L15.5892 5.58934C15.9147 5.2639 15.9147 4.73626 15.5892 4.41083Z" fill="black"/>
            </svg>
        </div>
        <div class="popup_url_body">
            <div class="tit">페널티 상세 내용</div>
            <div class="popup_url_normal mu_form mgt10">
                <textarea value="" readonly></textarea>
            </div>
        </div>
    </div>
</div>

<div class="pagingWrap">
    <? include_once PATH_INC_END.'page.php';?>
</div>
<script>
    $(document).ready(function(){

        $('.pop_btn_01').on('click', function(){
            const content = $(this).text().trim();
            $('.popup_url_box textarea').val(content);
            $('.popup_url_box').addClass('show');
        })
        // url 팝업 닫기
        $('.popup_url_head .close').on('click', function(){
            $('.popup_url_box').removeClass('show');
        })

        fnSearch = function() {
            $("#searchForm").attr("action","").submit();
        }
    })
</script>


