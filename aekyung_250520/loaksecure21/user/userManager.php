<?  if(!defined('_HEROBOARD_'))exit;

$search = "";

if($_GET["hero_point_start"]) {
    $search .= " AND m.hero_point >= '".$_GET["hero_point_start"]."' ";
}

if($_GET["hero_point_end"]) {
    $search .= " AND m.hero_point <= '".$_GET["hero_point_end"]."' ";
}
// 검색조건 재정의 musign 25.06.23
// sns 유무

if(!empty($_GET["hero_blog"]) && is_array($_GET["hero_blog"])) {

    $hero_blog_conditions = array(); // array() 사용

    foreach($_GET["hero_blog"] as $blog_type) {
        switch($blog_type) {
            case "1": // 블로그
                $hero_blog_conditions[] = "(m.hero_blog_00 is not null AND hero_blog_00 != '')";
                break;
            case "2": // 인스타
                $hero_blog_conditions[] = "(m.hero_blog_04 is not null AND hero_blog_04 != '')";
                break;
            case "3": // 블로그 or 인스타
                $hero_blog_conditions[] = "((m.hero_blog_00 is not null AND m.hero_blog_00 != '') or (m.hero_blog_04 is not null AND m.hero_blog_04 != ''))";
                break;
            case "4": // 블로그 and 인스타
                $hero_blog_conditions[] = "(m.hero_blog_00 is not null AND m.hero_blog_00 != '' AND m.hero_blog_04 is not null AND m.hero_blog_04 != '')";
                break;
            case "5": // 영상 채널
                $hero_blog_conditions[] = "((m.hero_blog_03 is not null AND m.hero_blog_03 != '') OR (m.hero_blog_06 is not null AND m.hero_blog_06 != '') OR (m.hero_blog_07 is not null AND m.hero_blog_07 != '') OR (m.hero_blog_08 is not null AND m.hero_blog_08 != ''))";
                break;
            case "6": // 인플루언서
                $hero_blog_conditions[] = "(m.hero_naver_influencer is not null AND m.hero_naver_influencer != '')";
                break;
            case "7": // 숏폼
                $hero_blog_conditions[] = "(m.hero_blog_07 is not null AND hero_blog_07 != '')";
                break;
            case "8": // 기타
                $hero_blog_conditions[] = "(m.hero_blog_08 is not null AND hero_blog_08 != '')";
                break;
        }
    }

    if(!empty($hero_blog_conditions)) {
        $search .= " AND (" . implode(" OR ", $hero_blog_conditions) . ")";
    }
}

if($_GET["hero_memo_01_image"]) {
    $search .= " AND m.hero_memo_01_image = '".$_GET["hero_memo_01_image"]."' ";
}

// sns 퀄리티 (관련 수치 로직 아직 미정 기존로직 수정 필요함)
if($_GET["hero_insta_image_grade"]) {
    $search .= " AND m.hero_insta_image_grade = '".$_GET["hero_insta_image_grade"]."' ";
}

if($_GET["hero_insta_grade"]) {
    $search .= " AND m.hero_insta_grade = '".$_GET["hero_insta_grade"]."' ";
}

if($_GET["hero_youtube_grade"]) {
    $search .= " AND m.hero_youtube_grade = '".$_GET["hero_youtube_grade"]."' ";
}

// 서포터즈 구분

if( !empty($_GET["hero_level"]) && is_array($_GET["hero_level"]) ) {

    $hero_level_conditions = array(); // array() 사용

    foreach($_GET["hero_level"] as $level_type) {
        switch($level_type) {
            case "9996": // 베이직 뷰티 & 라이프 클럽
                $hero_level_conditions[] = "(m.hero_level = '9996')";
                break;
            case "9994": // 프리미어 뷰티 클럽
                $hero_level_conditions[] = "(m.hero_level = '9994')";
                break;
            case "etc": // 프리미어 라이프 클럽
                $hero_level_conditions[] = "((m.hero_level != '') or (m.hero_level != ''))";
                break;
        }
    }

    if(!empty($hero_level_conditions)) {
        $search .= " AND (" . implode(" OR ", $hero_level_conditions) . ")";
    }
}

// 팀구분
if($_GET["hero_board_group"]) {
    if($_GET["hero_board_group"] == "b") { // 블로그
        $search .= " AND mg.hero_board_group = 'b' ";
    } else if($_GET["hero_board_group"] == "i") { // 인스타
        $search .= " AND mg.hero_board_group = 'i' ";
    } else if($_GET["hero_board_group"] == "s") { // 숏폼
        $search .= " AND mg.hero_board_group = 's' ";
    }
}





if($_GET["startDate"]) {
    $search .= " AND date_format(m.hero_oldday,'%Y-%m-%d') >= '".$_GET["startDate"]."' ";
}

if($_GET["edate"]) {
    $search .= " AND date_format(m.hero_oldday,'%Y-%m-%d') <= '".$_GET["edate"]."' ";
}

if(strlen($_GET["hero_sex"]) > 0) {
    $search .= " AND m.hero_sex = '".$_GET["hero_sex"]."' ";
}

// 연령대 현재기준으로 계산 (만 나이 적용)
if($_GET["startAge"]) {
    $search .= " AND (
        YEAR(CURRENT_DATE) - SUBSTR(m.hero_jumin,1,4)
        - (DATE_FORMAT(CURRENT_DATE, '%m%d') < CONCAT(SUBSTR(m.hero_jumin,5,2), SUBSTR(m.hero_jumin,7,2)))
    ) >= " . $_GET["startAge"];
}

if($_GET["endAge"]) {
    $search .= " AND (
        YEAR(CURRENT_DATE) - SUBSTR(m.hero_jumin,1,4)
        - (DATE_FORMAT(CURRENT_DATE, '%m%d') < CONCAT(SUBSTR(m.hero_jumin,5,2), SUBSTR(m.hero_jumin,7,2)))
    ) <= " . $_GET["endAge"];
}


if($_GET["hero_chk_phone"]) {
    if($_GET["hero_chk_phone"] == "1") {
        $search .= " AND m.hero_chk_phone = '1' ";
    } else {
        $search .= " AND COALESCE(m.hero_chk_phone,'0') != '1' ";
    }
}

if($_GET["hero_chk_email"]) {
    if($_GET["hero_chk_email"] == "1") {
        $search .= " AND m.hero_chk_email = '1' ";
    } else {
        $search .= " AND m.hero_chk_email != '1' ";
    }
}

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
$total_all_sql = " SELECT count(*) cnt FROM (
    SELECT m.hero_code 
    FROM member m 
    LEFT JOIN member_gisu mg ON m.hero_code = mg.hero_code 
    WHERE m.hero_use = 0
    GROUP BY m.hero_code
) AS t";
$total_all_result = sql($total_all_sql);
$total_all_res = mysql_fetch_assoc($total_all_result);
$total_all = $total_all_res['cnt'];

// 검색 결과 데이터 수
$total_sql = " SELECT count(*) cnt FROM (
    SELECT m.hero_code 
    FROM member m 
    LEFT JOIN member_gisu mg ON m.hero_code = mg.hero_code 
    WHERE m.hero_use = 0 ".$search."
    GROUP BY m.hero_code
) AS t";
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
$sql = " SELECT m.hero_code, m.hero_id, m.hero_nick, m.hero_name, m.hero_jumin, m.hero_sex ";
$sql .= " , m.hero_level, m.hero_point, m.hero_blog_00, m.hero_blog_04, m.hero_blog_03, m.hero_blog_07, m.hero_blog_08 ";
$sql .= " , m.hero_memo, m.hero_memo_01_image, m.hero_memo_01 ";
$sql .= " , m.hero_insta_cnt , m.hero_insta_image_grade, m.hero_insta_grade, m.hero_youtube_cnt, m.hero_youtube_grade";
$sql .= " , m.hero_youtube_view ";
$sql .= " , m.hero_chk_phone, m.hero_chk_email, m.hero_today, m.hero_oldday ";
$sql .= " , mg.hero_board, mg.hero_board_group "; // member_gisu 테이블의 컬럼 추가
$sql .= " FROM member m ";
$sql .= " LEFT JOIN member_gisu mg ON m.hero_code = mg.hero_code ";
$sql .= " WHERE m.hero_use = 0 " . $search;
$sql .= " GROUP BY m.hero_code ";
$sql .= " ORDER BY m.hero_idx DESC ";
$sql .= " LIMIT " . $start . "," . $list_page;

$list_res = sql($sql);
?>
<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
    <input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
    <input type="hidden" name="board" value="<?=$_GET["board"]?>" />
    <input type="hidden" name="page" value="<?=$page?>" />
    <input type="hidden" name="hero_code" value="" />
    <input type="hidden" name="view" value="" />

    <div class="searchCnt">
        <h4>회원 검색</h4>
    </div>
    <!-- 250618 회원정보 회원 검색-->
    <table class="searchBox">
        <colgroup>
            <col width="171px" />
            <col width="*" />
            <col width="171px" />
            <col width="*" />
        </colgroup>
        <tr>
            <th>
                SNS 유무
            </th>
            <td>
                <div class="search_inner">
                    <?php
                    // PHP 5.x 버전용
                    $hero_blog = (isset($_GET['hero_blog']) && is_array($_GET['hero_blog'])) ? $_GET['hero_blog'] : array();
                    ?>

                    <label class="akContainer">전체
                        <input type="checkbox" <?php echo (empty($_GET['hero_blog'])) ? 'checked' : ''; ?> name="all" value="check">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">블로그
                        <input type="checkbox" <?php echo (is_array($hero_blog) && in_array('1', $hero_blog)) ? 'checked' : ''; ?> name="hero_blog[]" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">인스타
                        <input type="checkbox" <?php echo (is_array($hero_blog) && in_array('2', $hero_blog)) ? 'checked' : ''; ?>
                               name="hero_blog[]" value="2">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">숏폼
                        <input type="checkbox" <?php echo (is_array($hero_blog) && in_array('7', $hero_blog)) ? 'checked' : ''; ?>
                               name="hero_blog[]" value="7">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">기타
                        <input type="checkbox" <?php echo (is_array($hero_blog) && in_array('8', $hero_blog)) ? 'checked' : ''; ?>
                               name="hero_blog[]" value="8">
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
            <th>
                연령대
            </th>
            <td>
                <div class="search_inner">
                    <input type="text" id="sage" name="startAge" value="<?=$_GET["startAge"]?>" readonly/>
                    <div class="inner_between">~</div>
                    <input type="text" id="eage" name="endAge" value="<?=$_GET["endAge"]?>" readonly/>
                </div>
            </td>
        </tr>
        <tr>
            <th>SNS 퀄리티</th>
            <td>
                <div class="search_inner">
                    <label class="akContainer">전체
                        <input type="checkbox" <?=($_GET['all'] == 'check' || $_GET['all'] == '') && $hero_group == '' ? 'checked' : ''?> name="all" value="check">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">최상
                        <input type="checkbox" <?=strpos($hero_group,'group_04_05') ? 'checked' : ''?> name="hero_group[]" value="group_04_05">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">상
                        <input type="checkbox" <?=strpos($hero_group,'group_04_06') ? 'checked' : ''?> name="hero_group[]" value="group_04_06">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">중
                        <input type="checkbox" <?=strpos($hero_group,'group_04_28') ? 'checked' : ''?> name="hero_group[]" value="group_04_28">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">하
                        <input type="checkbox" <?=strpos($hero_group,'group_04_28') ? 'checked' : ''?> name="hero_group[]" value="group_04_28">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">미정
                        <input type="checkbox" <?=strpos($hero_group,'group_04_28') ? 'checked' : ''?> name="hero_group[]" value="group_04_28">
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
            <th>가입일</th>
            <td>
                <div class="search_inner">
                    <input type="text" id="sdate" name="startDate" value="<?=$_GET["startDate"]?>" readonly/>
                    <div class="inner_between">~</div>
                    <input type="text" id="edate" name="endDate" value="<?=$_GET["endDate"]?>" readonly/>
                </div>
            </td>
        </tr>
        <tr>
            <th>서포터즈 구분</th>
            <td>
                <div class="search_inner sup">
                    <?php
                    $hero_level = (isset($_GET['hero_level']) && is_array($_GET['hero_level'])) ? $_GET['hero_level'] : array();
                    ?>

                    <label class="akContainer">전체
                        <input type="checkbox" <?php echo (empty($_GET['hero_level'])) ? 'checked' : ''; ?> name="all" value="check">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">베이직 뷰티 & 라이프 클럽
                        <input type="checkbox" <?php echo (is_array($hero_level) && in_array('etc', $hero_level)) ? 'checked' : ''; ?> name="hero_level[]" value="etc">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">프리미어 뷰티 클럽
                        <input type="checkbox" <?php echo (is_array($hero_level) && in_array('9996', $hero_level)) ? 'checked' : ''; ?> name="hero_level[]" value="9996">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">프리미어 라이프 클럽
                        <input type="checkbox" <?php echo (is_array($hero_level) && in_array('9994', $hero_level)) ? 'checked' : ''; ?>  name="hero_level[]" value="9994">
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
            <th>휴대폰 수신동의</th>
            <td>
                <div class="search_inner sup">
                    <label class="akContainer">전체
                        <input type="radio" <?=!$_GET["hero_chk_phone"] ? "checked" : ""?> name="hero_chk_phone" value="">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">동의
                        <input type="radio" <?=$_GET["hero_chk_phone"] == "1" ? "checked" : ""?> name="hero_chk_phone" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">미동의
                        <input type="radio" <?=($_GET["hero_chk_phone"]!="1" && strlen($_GET["hero_chk_phone"]) > 0) ? "checked" : ""?> name="hero_chk_phone" value="2">
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
        </tr>
        <tr>
            <th>팀 구분</th>
            <td>
                <div class="search_inner">
                    <label class="akContainer">전체
                        <input type="radio" <?=$_GET["hero_board_group"] == "" ? "checked" : ""?> name="hero_board_group" value="">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">블로그
                        <input type="radio" <?=$_GET["hero_board_group"] == "b" ? "checked" : ""?> name="hero_board_group" value="b">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">인스타
                        <input type="radio" <?=$_GET["hero_board_group"] == "i" ? "checked" : ""?> name="hero_board_group" value="i">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">숏폼
                        <input type="radio" <?=$_GET["hero_board_group"] == "s" ? "checked" : ""?> name="hero_board_group" value="s">
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
            <th>이메일 수신동의</th>
            <td>
                <div class="search_inner">
                    <label class="akContainer">전체
                        <input type="radio" <?=!$_GET["hero_chk_email"] ? "checked" : ""?> name="hero_chk_email" value="">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">선정
                        <input type="radio" <?=$_GET["hero_chk_email"] == "1" ? "checked" : ""?> name="hero_chk_email" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">미선정
                        <input type="radio" <?=($_GET["hero_chk_email"]!="1" && strlen($_GET["hero_chk_email"]) > 0) ? "checked" : ""?> name="hero_chk_email" value="2">
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
        </tr>
        <tr>
            <th>성별</th>
            <td>
                <div class="search_inner">
                    <label class="akContainer">전체
                        <input type="radio" <?=!$_GET["hero_sex"] ? "checked" : ""?> name="hero_sex" value="">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">여성
                        <input type="radio" <?=($_GET["hero_sex"]=="0" &&  strlen($_GET["hero_sex"]) > 0) ? "checked" : ""?> name="hero_sex" value="0">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">남성
                        <input type="radio" <?=$_GET["hero_sex"] == "1" ? "checked" : ""?> name="hero_sex" value="1">
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
        </tr>
    </table>

    <!-- 검색 -->
    <table class="searchBox addSearchBox">
        <colgroup>
            <col width="171px" />
            <col width="*" />
        </colgroup>
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
                            <option value="hero_hp" <?=$_GET["select"] == "m.hero_hp" ? "selected" : ""?>>연락처</option>
                            <!--                            <option value="hero_title" --><?php //=$_GET["select"] == "hero_title" ? "selected" : "" ?><!-->체험단명</option>-->
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


    <!-- 기존 검색 테이블 -->
    <!-- <table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>전체 포인트</th>
		<td><input type="text" name="hero_point_start" numberOnly value="<?=$_GET["hero_point_start"]?>"/> ~ <input type="text" name="hero_point_end" numberOnly value="<?=$_GET["hero_point_end"]?>"/></td>
		<th>SNS 유무</th>
		<td>
			<input type="radio" name="hero_blog" id="hero_blog_naver" value="1" <?=$_GET["hero_blog"] == "1" ? "checked":"";?>/><label for="hero_blog_naver">네이버 블로그</label>
			<input type="radio" name="hero_blog" id="hero_blog_insta" value="2" <?=$_GET["hero_blog"] == "2" ? "checked":"";?>/><label for="hero_blog_insta">인스타그램</label>
			<input type="radio" name="hero_blog" id="hero_blog_naver_or_insta" value="3" <?=$_GET["hero_blog"] == "3" ? "checked":"";?>/><label for="hero_blog_naver_or_insta">네이버 블로그 or 인스타그램</label>
			<input type="radio" name="hero_blog" id="hero_blog_naver_and_insta" value="4" <?=$_GET["hero_blog"] == "4" ? "checked":"";?>/><label for="hero_blog_naver_and_insta">네이버 블로그 and 인스타그램</label>
			<input type="radio" name="hero_blog" id="hero_blog_youtube" value="5" <?=$_GET["hero_blog"] == "5" ? "checked":"";?>/><label for="hero_blog_youtube">영상 채널</label>
			<input type="radio" name="hero_blog" id="hero_blog_influencer" value="6" <?=$_GET["hero_blog"] == "6" ? "checked":"";?>/><label for="hero_blog_influencer">인플루언서</label>
		</td>
	</tr>
	<tr>
		<th>네이버 블로그<br/>이미지 퀄리티</th>
		<td>
			<select name="hero_memo_01_image">
				<option value="">선택</option>
				<option value="상" <?=$_GET["hero_memo_01_image"] == "상" ? "selected":"";?>>상</option>
				<option value="중상" <?=$_GET["hero_memo_01_image"] == "중상" ? "selected":"";?>>중상</option>
				<option value="중" <?=$_GET["hero_memo_01_image"] == "중" ? "selected":"";?>>중</option>
				<option value="중하" <?=$_GET["hero_memo_01_image"] == "중하" ? "selected":"";?>>중하</option>
				<option value="하" <?=$_GET["hero_memo_01_image"] == "하" ? "selected":"";?>>하</option>
			</select>
		</td>
		<th>네이버 블로그<br/>텍스트 퀄리티</th>
		<td>
			<select name="hero_memo_01">
				<option value="">선택</option>
				<option value="상" <?=$_GET["hero_memo_01"] == "상" ? "selected":"";?>>상</option>
				<option value="중상" <?=$_GET["hero_memo_01"] == "중상" ? "selected":"";?>>중상</option>
				<option value="중" <?=$_GET["hero_memo_01"] == "중" ? "selected":"";?>>중</option>
				<option value="중하" <?=$_GET["hero_memo_01"] == "중하" ? "selected":"";?>>중하</option>
				<option value="하" <?=$_GET["hero_memo_01"] == "하" ? "selected":"";?>>하</option>
			</select>
		</td>
	</tr>
	<tr>
		<th>인스타그램<br/>이미지 퀄리티</th>
		<td>
			<select name="hero_insta_image_grade">
				<option value="">선택</option>
				<option value="상" <?=$_GET["hero_insta_image_grade"] == "상" ? "selected":"";?>>상</option>
				<option value="중상" <?=$_GET["hero_insta_image_grade"] == "중상" ? "selected":"";?>>중상</option>
				<option value="중" <?=$_GET["hero_insta_image_grade"] == "중" ? "selected":"";?>>중</option>
				<option value="중하" <?=$_GET["hero_insta_image_grade"] == "중하" ? "selected":"";?>>중하</option>
				<option value="하" <?=$_GET["hero_insta_image_grade"] == "하" ? "selected":"";?>>하</option>
			</select>
		</td>
		<th>인스타그램<br/>텍스트 퀄리티</th>
		<td>
			<select name="hero_insta_grade">
				<option value="">선택</option>
				<option value="상" <?=$_GET["hero_insta_grade"] == "상" ? "selected":"";?>>상</option>
				<option value="중상" <?=$_GET["hero_insta_grade"] == "중상" ? "selected":"";?>>중상</option>
				<option value="중" <?=$_GET["hero_insta_grade"] == "중" ? "selected":"";?>>중</option>
				<option value="중하" <?=$_GET["hero_insta_grade"] == "중하" ? "selected":"";?>>중하</option>
				<option value="하" <?=$_GET["hero_insta_grade"] == "하" ? "selected":"";?>>하</option>
			</select>
		</td>
	</tr>
	<tr>
		<th>유튜브<br/>콘텐츠 등급</th>
		<td>
			<select name="hero_youtube_grade">
				<option value="">선택</option>
				<option value="상" <?=$_GET["hero_youtube_grade"] == "상" ? "selected":"";?>>상</option>
				<option value="중상" <?=$_GET["hero_youtube_grade"] == "중상" ? "selected":"";?>>중상</option>
				<option value="중" <?=$_GET["hero_youtube_grade"] == "중" ? "selected":"";?>>중</option>
				<option value="중하" <?=$_GET["hero_youtube_grade"] == "중하" ? "selected":"";?>>중하</option>
				<option value="하" <?=$_GET["hero_youtube_grade"] == "하" ? "selected":"";?>>하</option>
			</select>
		</td>
		<th>생년월일</th>
		<td><input type="text" name="hero_jumin" numberOnly placeholder="ex) 19901020" value="<?=$_GET["hero_jumin"]?>" maxlength="8"/></td>
	</tr>
	<tr>
		<th>레벨</th>
		<td>
			<input type="text" name="hero_level_start" numberOnly value="<?=$_GET["hero_level_start"]?>"/> ~ <input type="text" name="hero_level_end" numberOnly value="<?=$_GET["hero_level_end"]?>"/>
		</td>
		<th>가입일</th>
		<td>
			<input type="text" name="hero_oldday_start" class="dateMode" value="<?=$_GET["hero_oldday_start"]?>"/> ~ <input type="text" name="hero_oldday_end" name="hero_oldday_end" class="dateMode" value="<?=$_GET["hero_oldday_end"]?>"/>
		</td>
	</tr>
	<tr>
		<th>성별</th>
		<td>
			<input type="radio" name="hero_sex" id="hero_sex_all" value="" <?=!$_GET["hero_sex"] ? "checked":""?>/><label for="hero_sex_all">전체</label>
			<input type="radio" name="hero_sex" id="hero_sex_0" value="0" <?=($_GET["hero_sex"]=="0" &&  strlen($_GET["hero_sex"]) > 0) ? "checked":""?>/><label for="hero_sex_0">여성</label>
			<input type="radio" name="hero_sex" id="hero_sex_1" value="1" <?=$_GET["hero_sex"]=="1" ? "checked":""?>/><label for="hero_sex_1">남성</label
		</td>
		<th>연령대</th>
		<td>
			<input type="text" name="hero_age_start" numberOnly value="<?=$_GET["hero_age_start"]?>"/> ~ <input type="text" name="hero_age_end" numberOnly value="<?=$_GET["hero_age_end"]?>"/>
		</td>
	</tr>
	<tr>
		<th>휴대폰 수신동의</th>
		<td>
			<input type="radio" name="hero_chk_phone" id="hero_chk_phone_all" value="" <?=!$_GET["hero_chk_phone"] ? "checked":""?>/><label for="hero_chk_phone_all">전체</label>
			<input type="radio" name="hero_chk_phone" id="hero_chk_phone_1" value="1" <?=$_GET["hero_chk_phone"]=="1" ? "checked":""?>/><label for="hero_chk_phone_1">동의</label>
			<input type="radio" name="hero_chk_phone" id="hero_chk_phone_2" value="2" <?=($_GET["hero_chk_phone"]!="1" && strlen($_GET["hero_chk_phone"]) > 0) ? "checked":""?>/><label for="hero_chk_phone_2">미동의</label
		</td>
		<th>이메일 수신동의</th>
		<td>
			<input type="radio" name="hero_chk_email" id="hero_chk_email_all" value="" <?=!$_GET["hero_chk_email"] ? "checked":""?>/><label for="hero_chk_email_all">전체</label>
			<input type="radio" name="hero_chk_email" id="hero_chk_email_1" value="1" <?=$_GET["hero_chk_email"]=="1" ? "checked":""?>/><label for="hero_chk_email_1">동의</label>
			<input type="radio" name="hero_chk_email" id="hero_chk_email_2" value="2" <?=($_GET["hero_chk_email"]!="1" && strlen($_GET["hero_chk_email"]) > 0) ? "checked":""?>/><label for="hero_chk_email_2">미동의</label
		</td>
	</tr>
	<tr>
		<th>검색어</th>
		<td colspan="3">
			<select name="select">
		    	<option value="hero_nick" <?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>닉네임</option>
		    	<option value="hero_name" <?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>이름</option>
		    	<option value="hero_id" <?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>아이디</option>
		    	<option value="hero_hp" <?if(!strcmp($_REQUEST['select'], 'hero_hp')){echo ' selected';}else{echo '';}?>>휴대폰</option>
		    	<option value="hero_mail" <?if(!strcmp($_REQUEST['select'], 'hero_mail')){echo ' selected';}else{echo '';}?>>이메일</option>
	    	</select>
	    	<input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];;?>" class="kewyword">
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">검색</a>
</div> -->


    <div class="searchCnt">
        <h4>검색 결과</h4>
        <p class="postNum"><span class="line"><?=number_format($total_data)?>개</span><span class="op_5">전체 <?=number_format($total_all)?>개</span></p>
    </div>

    <!-- 250618 작업중 -->
    <div class="searchResultBox_container">
        <div class="searchResultBox_BtnGroup">
            <a href="javascript:;" class="btnAdd popup_btn" data-popup="01">회원 목록 다운로드</a>
        </div>
        <table class="searchResultBox">
            <colgroup>
                <col width="45px" />
                <col width="150px" />
                <col width="120px" />
                <col width="105px" />
                <col width="60px" />
                <col width="60px" />
                <col width="130px" />
                <col width="75px" />
                <col width="89px" />
                <col width="77px" />
                <col width="140px" />
                <col width="140px" />
                <col width="140px" />
                <col width="77px" />
            </colgroup>
            <thead>
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
                    보유포인트
                </div>
            </th>
            <th>
                <div class="">
                    서포터즈
                </div>
            </th>
            <th>
                <div class="">
                    팀
                </div>
            </th>
            <th>
                <div class="">
                    보유 SNS
                </div>
            </th>
            <th>
                <div class="">
                    회원 퀄리티
                </div>
            </th>
            <th>
                <div class="">
                    이메일 수신동의
                </div>
            </th>
            <th>
                <div class="">
                    휴대폰 수신동의
                </div>
            </th>
            <th>
                <div class="">
                    가입일
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
                    if($list["hero_blog_00"]) $hero_blog_00_txt = "블로그";
                    if($list["hero_blog_04"]) $hero_blog_04_txt = "인스타";
                    if($list["hero_blog_07"]) $hero_blog_07_txt = "숏폼"; //틱톡
                    if($list["hero_blog_08"]) $hero_blog_08_txt = "기타";
//                    $hero_blog_00_txt = ""; //네이버
//                    if($list["hero_blog_00"]) $hero_blog_00_txt = "블로그";
//                    $hero_blog_03_txt = ""; //유튜브
//                    if($list["hero_blog_03"]) $hero_blog_03_txt = "숏폼";
//                    $hero_blog_04_txt = ""; //인스타
//                    if($list["hero_blog_04"]) $hero_blog_04_txt = "인스타";
                    $hero_chk_phone_txt = "미동의";
                    if($list["hero_chk_phone"] == "1") $hero_chk_phone_txt = "동의";
                    $hero_chk_email_txt = "미동의";
                    if($list["hero_chk_email"] == "1") $hero_chk_email_txt = "동의";
                    // musign 서포터즈구분자 추가
                    if($list["hero_level"] == "9996") {
                        $hero_group = "프리미어 뷰티 클럽";
                    } elseif ($list["hero_level"] == "9994"){
                        $hero_group = "프리미어 라이프 클럽";
                    } else {
                        $hero_group = "베이직 뷰티 & 라이프 클럽"; // 기존명칭 베이직서포터즈
                    }

                    // 서포터즈 팀 구분
                    if($list["hero_board_group"] == "b") {
                        $hero_board_group = "블로그";
                    } elseif ($list["hero_board_group"] == "i") {
                        $hero_board_group = "인스타";
                    } elseif ($list["hero_board_group"] == "s") {
                        $hero_board_group = "숏폼";
                    }
                    ?>
                    <tr style="cursor:pointer" onClick="fnView('<?=$list["hero_code"]?>')">
                        <td>
                            <div class="table_result_no">
                                <?=number_format($i);?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_types">
                                <?=$list["hero_id"]?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_nick">
                                <?=$list["hero_nick"]?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_name">
                                <?=$list["hero_name"]?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_create">
                                <?=$age?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_create">
                                <?=$hero_sex_txt?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_create">
                                <?=number_format($list["hero_point"]);?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_create">
                                <?=$hero_group?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_create">
                                <?=$hero_board_group?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_create">
                                <!-- 블로그 -->
                                <?=$hero_blog_00_txt?>
                                <?=$hero_blog_04_txt?>
                                <?=$hero_blog_07_txt?>
                                <?=$hero_blog_08_txt?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_create">
                                회원퀄리티
                            </div>
                        </td>
                        <td>
                            <div class="table_result_create">
                                <?=$hero_chk_email_txt?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_create">
                                <?=$hero_chk_phone_txt?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_create">
                                <?=substr($list["hero_oldday"],0,10)?>
                            </div>
                        </td>
                    </tr>
                    <?
                    --$i;
                }
            } else {?>
                <tr>
                    <td colspan="25">등록된 데이터가 없습니다.</td>
                </tr>
            <? } ?>
            </tbody>
        </table>
    </div>

    <!-- <div class="btnGroupFunction">
	<div class="rightWrap">
		<a href="javascript:;" class="btnFormExcel" onClick="fnExcel();">회원 다운로드</a>
		<select name="list_count" onchange="fnListCount()">
        	<option value="">출력 수</option>
            <option value="20"<?if(!strcmp($_REQUEST['list_count'], '20')){echo ' selected';}else{echo '';}?>>20개</option>
        	<option value="30"<?if(!strcmp($_REQUEST['list_count'], '30')){echo ' selected';}else{echo '';}?>>30개</option>
	        <option value="50"<?if(!strcmp($_REQUEST['list_count'], '50')){echo ' selected';}else{echo '';}?>>50개</option>
            <option value="100"<?if(!strcmp($_REQUEST['list_count'], '100')){echo ' selected';}else{echo '';}?>>100개</option>
            <option value="250"<?if(!strcmp($_REQUEST['list_count'], '250')){echo ' selected';}else{echo '';}?>>250개</option>
		</select>
	</div>
</div> -->

    <!-- 250618 폼 태그 위치 아래로 이동 -->
    <!-- </form> -->

    <!--
<table class="t_list">
<colgroup>
	<col width="3%" />
	<col width="7%" />
	<col width="6%" />
	<col width="6%" />
	<col width="3%" />
	<col width="3%" />
	<col width="3%" />
	<col width="3%" />
	<col width="3%" />
	<col width="3%" />
	<col width="4%" />

	<col width="4%" />
	<col width="4%" />
	<col width="4%" />
	<col width="4%" />
	<col width="4%" />
	<col width="3%" />
	<col width="3%" />
	<col width="4%" />
	<col width="4%" />
	<col width="4%" />
	<col width="4%" />
	<col width="7%" />
</colgroup>
<thead>
	<tr>
		<th rowspan="2">no</th>
		<th rowspan="2">아이디</th>
		<th rowspan="2">닉네임</th>
		<th rowspan="2">이름</th>
		<th rowspan="2">나이</th>
		<th rowspan="2">성별</th>
		<th rowspan="2">레벨</th>
		<th rowspan="2">전체<br/>포인트</th>
		<th colspan="4">네이버 블로그</th>
		<th colspan="4">인스타그램</th>
		<th colspan="4">유튜브</th>
		<th rowspan="2">휴대폰<br/>수신동의</th>
		<th rowspan="2">이메일<br/>수신동의</th>
		<th rowspan="2">가입일</th>
	</tr>
	<tr>
		<th>유/무</th>
		<th>방문자 수</th>
		<th>이미지 퀄리티</th>
		<th>텍스트 퀄리티</th>
		<th>유/무</th>
		<th>팔로워 수</th>
		<th>이미지 퀄리티</th>
		<th>텍스트 퀄리티</th>
		<th>유/무</th>
		<th>구독자 수</th>
		<th>조회수 수</th>
		<th>콘텐츠 등급</th>
	</tr>
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
            // 250623 musign 블로그 명칭 추가
            $hero_sns_txt = "무";
            if($list["hero_blog_00"]) $hero_sns_txt = "블로그";
            if($list["hero_blog_04"]) $hero_sns_txt = "인스타";
            if($list["hero_blog_07"]) $hero_sns_txt = "숏폼"; //틱톡
            if($list["hero_blog_08"]) $hero_sns_txt = "기타";
//
//            $hero_blog_00_txt = "무"; //네이버
//            if($list["hero_blog_00"]) $hero_blog_00_txt = "유";
//            $hero_blog_03_txt = "무"; //유튜브
//            if($list["hero_blog_03"]) $hero_blog_03_txt = "유";
//            $hero_blog_04_txt = "무"; //인스타
//            if($list["hero_blog_04"]) $hero_blog_04_txt = "유";
            $hero_chk_phone_txt = "미동의";
            if($list["hero_chk_phone"] == "1") $hero_chk_phone_txt = "동의";
            $hero_chk_email_txt = "미동의";
            if($list["hero_chk_email"] == "1") $hero_chk_email_txt = "동의";
            ?>
	<tr style="cursor:pointer" onClick="fnView('<?=$list["hero_code"]?>')">
		<td><?=number_format($i);?></td>
		<td><?=$list["hero_id"]?></td>
		<td><?=$list["hero_nick"]?></td>
		<td><?=$list["hero_name"]?></td>
		<td><?=$age?></td>
		<td><?=$hero_sex_txt?></td>
		<td><?=$list["hero_level"]?></td>
		<td><?=$list["hero_point"]?></td>
		<td><?=$hero_blog_00_txt?></td>
		<td><?=$list["hero_memo"]?></td>
		<td><?=$list["hero_memo_01_image"]?></td>
		<td><?=$list["hero_memo_01"]?></td>
		<td><?=$hero_blog_04_txt?></td>
		<td><?=$list["hero_insta_cnt"]?></td>
		<td><?=$list["hero_insta_image_grade"]?></td>
		<td><?=$list["hero_insta_grade"]?></td>
		<td><?=$hero_blog_03_txt?></td>
		<td><?=$list["hero_youtube_cnt"]?></td>
		<td><?=$list["hero_youtube_view"]?></td>
		<td><?=$list["hero_youtube_grade"]?></td>
		<td><?=$hero_chk_phone_txt?></td>
		<td><?=$hero_chk_email_txt?></td>
		<td><?=substr($list["hero_oldday"],0,10)?></td>
	</tr>
	<?
            --$i;
        }
    } else {
        ?>
	<tr>
		<td colspan="25">등록된 데이터가 없습니다.</td>
	</tr>
	<?
    }
    ?>
</tbody>
</table> -->


    <!--콘텐츠 URL 팝업-->
    <div class="popup_url_box" id="pop_01">
        <div class="popup_url_cont">
            <div class="popup_url_head">
                <svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.41073 4.41083C4.73617 4.08539 5.26381 4.08539 5.58925 4.41083L15.5892 14.4108C15.9147 14.7363 15.9147 15.2639 15.5892 15.5893C15.2638 15.9148 14.7362 15.9148 14.4107 15.5893L4.41073 5.58934C4.0853 5.2639 4.0853 4.73626 4.41073 4.41083Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5892 4.41083C15.2638 4.08539 14.7362 4.08539 14.4107 4.41083L4.41072 14.4108C4.08529 14.7363 4.08529 15.2639 4.41072 15.5893C4.73616 15.9148 5.2638 15.9148 5.58924 15.5893L15.5892 5.58934C15.9147 5.2639 15.9147 4.73626 15.5892 4.41083Z" fill="black"/>
                </svg>
            </div>
            <div class="popup_url_body mu_form">
                <div class="tit">회원 목록 다운로드</div>
                <p class="desc">추출할 항목을 선택해주세요</p>
                <div class="popup_checkbox_table">
                    <table>
                        <colgroup>
                            <col width="120px" />
                            <col width="*" />
                        </colgroup>
                        <thead>
                        <th>선택</th>
                        <th>추출 항목</th>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <input type="checkbox" id="chk1" name="chk_id"/>
                                <label for="chk1"></label>
                            </td>
                            <td>아이디</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="chk2" name="chk_nick"/>
                                <label for="chk2"></label>
                            </td>
                            <td>닉네임</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="chk3" name="chk_name"/>
                                <label for="chk3"></label>
                            </td>
                            </td>
                            <td>이름</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="chk4" name="chk_age"/>
                                <label for="chk4"></label>
                            </td>
                            <td>나이</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="chk5" name="chk_sex"/>
                                <label for="chk5"></label>
                            </td>
                            <td>성별</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="chk6" name="chk_level"/>
                                <label for="chk6"></label>
                            </td>
                            <td>서포터즈</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <a href="javascript:;" class="btnAdd3 pop_submit" onClick="fnExcel();">파일 다운로드</a>
            </div>
        </div>
    </div>
</form>


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

        fnView = function(hero_code) {
            $("input[name='hero_code']").val(hero_code);
            $("input[name='view']").val("userManagerView");
            $("#searchForm").attr("action","<?=PATH_HOME?>").submit();

        }

        fnListCount = function() {
            $("input[name='page']").val(1);
            $("#searchForm").attr("action","").submit();
        }

        fnSearch = function() {
            $("input[name='page']").val(1);
            $("#searchForm").attr("action","").submit();
        }

        fnExcel = function() {
            var form = document.getElementById('searchForm');
            form.action = '/loaksecure21/user/userManger_excel.php';
            form.submit();
            //$("#searchForm").attr("action","/loaksecure21/user/userManger_excel.php").submit();
        }
    })
</script>