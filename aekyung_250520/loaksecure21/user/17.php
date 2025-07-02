<?
if(!defined('_HEROBOARD_'))exit;

$search = "";


// 250702 sns 검색 musign jnr
if( !empty($_GET["hero_blog"]) && is_array($_GET["hero_blog"]) ) {

    $hero_blog_conditions = array(); // array() 사용

    foreach($_GET["hero_blog"] as $blog_type) {
        switch($blog_type) {
            case "hero_blog_00": // 네이버블로그
                //$search .= " AND ".$_GET["hero_blog"]." like '%".$_GET["url"]."%' ";
                $hero_blog_conditions[] = "(hero_blog_00 not like '' and hero_blog_00 != '')";
                break;
            case "hero_blog_04": // 인스타
                $hero_blog_conditions[] = "(hero_blog_04 not like '' and hero_blog_00 != '')";
                break;
            case "hero_blog_07": // 숏폼
                $hero_blog_conditions[] = "(hero_blog_07 not like '' and hero_blog_00 != '')";
                break;
            case "hero_blog_08": // 숏폼
                $hero_blog_conditions[] = "(hero_blog_08 not like '' and hero_blog_00 != '')";
                break;
        }
    }

    if(!empty($hero_blog_conditions)) {
        $search .= " AND (" . implode(" OR ", $hero_blog_conditions) . ")";
    }
}


if($_GET["kewyword"] && $_GET["select"] != 'none') { //
    if($_GET["select"] == 'hero_nick') { // 닉네임 검색
        $_GET["select"] = $_GET["select"];
    } elseif ($_GET["select"] == 'hero_name') { // 이름
        $_GET["select"] = $_GET["select"];
    } elseif ($_GET["select"] == 'hero_id') { // 아이디
        $_GET["select"] = $_GET["select"];
    } elseif ($_GET["select"] == 'hero_hp') { // 전화번호
        $_GET["select"] = 'hero_hp';
        // 검색어에서 하이픈 제거 후 포맷팅
        $phone = preg_replace("/[^0-9]/", "", $_GET["kewyword"]); // 숫자만 추출
        $_GET["kewyword"] = substr($phone, 0, 3) . '-' . substr($phone, 3, 4) . '-' . substr($phone, 7);
    }
    $search .= " AND ".$_GET["select"]." like '%".$_GET["kewyword"]."%' ";
}

// 전체페이지
$total_all_sql = " SELECT count(*) as cnt FROM member WHERE hero_use=0 ";
$total_all_result = sql($total_all_sql);
$total_all_res = mysql_fetch_assoc($total_all_result);
$total_cnt = $total_all_res['cnt'];

//페이지 넘버링
$total_sql = " SELECT count(*) as cnt FROM member WHERE hero_use=0 ".$search;
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

$sql  = " SELECT hero_name, hero_hp , hero_id, hero_nick, hero_blog_00 ";
$sql .= " , hero_blog_01, hero_blog_02, hero_blog_03 ";
$sql .= " , hero_blog_04, hero_blog_05, hero_blog_06, hero_blog_07, hero_blog_08  ";
$sql .= " FROM member where hero_use=0 ".$search;
$sql .= " ORDER BY hero_oldday DESC LIMIT ".$start.",".$list_page;

$list_res = sql($sql);
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
            <th>SNS</th>
            <td>
                <div class="search_inner sup">
                    <?php
                    $hero_blog = (isset($_GET['hero_blog']) && is_array($_GET['hero_blog'])) ? $_GET['hero_blog'] : array();
                    ?>
                    <label class="akContainer">전체
                        <input type="checkbox" <?php echo (!isset($_GET['hero_blog']) || empty($hero_blog) || in_array('', $hero_blog)) ? 'checked' : ''; ?> name="hero_blog[]" value="">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">블로그
                        <input type="checkbox" <?php echo (is_array($hero_blog) && in_array('hero_blog_00', $hero_blog)) ? 'checked' : ''; ?> name="hero_blog[]" value="hero_blog_00">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">인스타그램
                        <input type="checkbox" <?php echo (is_array($hero_blog) && in_array('hero_blog_04', $hero_blog)) ? 'checked' : ''; ?> name="hero_blog[]" value="hero_blog_04">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">숏폼
                        <input type="checkbox" <?php echo (is_array($hero_blog) && in_array('hero_blog_07', $hero_blog)) ? 'checked' : ''; ?> name="hero_blog[]" value="hero_blog_07">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">기타
                        <input type="checkbox" <?php echo (is_array($hero_blog) && in_array('hero_blog_08', $hero_blog)) ? 'checked' : ''; ?> name="hero_blog[]" value="hero_blog_08">
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
                            <option value="hero_hp" <?=$_GET["select"] == "m.hero_hp" ? "selected" : ""?>>연락처</option>
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
                <col width="100px" />
                <col width="100px" />
                <col width="100px" />
                <col width="60px" />
                <col width="60px" />
                <col width="60px" />
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
                    아이디
                </div>
            </th>
            <th>
                <div class="">
                    이름
                </div>
            </th>
            <th>
                <div class="">
                    닉네임
                </div>
            </th>
            <th>
                <div class="">
                    휴대폰 번호
                </div>
            </th>
            <th>
                <div class="">
                    블로그
                </div>
            </th>
            <th>
                <div class="">
                    인스타그램
                </div>
            </th>
            <th>
                <div class="">
                    그 외 SNS 주소
                </div>
            </th>
            <th>
                <div class="">
                    유튜브
                </div>
            </th>
            <th>
                <div class="">
                    네이버TV
                </div>
            </th>
            <th>
                <div class="">
                    숏폼
                </div>
            </th>
            <th>
                <div class="">
                    기타(영상)
                </div>
            </th>
            </thead>
            <tbody>
            <?
            if($total_data > 0) {
                while($list = mysql_fetch_assoc($list_res)) {?>
                    <tr>
                        <td>
                            <div class="table_result_no">
                                <?=$i?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_nick">
                                <?=$list["hero_id"]?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_nick">
                                <?=$list["hero_name"]?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_nick">
                                <?=$list["hero_nick"]?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_nick">
                                <?=$list["hero_hp"]?>
                            </div>
                        </td>
                        <td class="title">
                            <div class="table_result_create">
                                <a href="<?=$list["hero_blog_00"]?>" target="_blank"><?=$list["hero_blog_00"]?></a>
                            </div>
                        </td>
                        <td class="title">
                            <div class="table_result_create">
                                <a href="<?=$list["hero_blog_04"]?>" target="_blank"><?=$list["hero_blog_04"]?></a>
                            </div>
                        </td>
                        <td class="title">
                            <div class="table_result_create">
                                <a href="<?=$list["hero_blog_05"]?>" target="_blank"><?=$list["hero_blog_05"]?></a>
                            </div>
                        </td>
                        <td class="title">
                            <div class="table_result_create">
                                <a href="<?=$list["hero_blog_03"]?>" target="_blank"><?=$list["hero_blog_03"]?></a>
                            </div>
                        </td>
                        <td class="title">
                            <div class="table_result_create">
                                <a href="<?=$list["hero_blog_06"]?>" target="_blank"><?=$list["hero_blog_06"]?></a>
                            </div>
                        </td>
                        <td class="title">
                            <div class="table_result_create">
                                <a href="<?=$list["hero_blog_07"]?>" target="_blank"><?=$list["hero_blog_07"]?></a>
                            </div>
                        </td>
                        <td class="title">
                            <div class="table_result_create">
                                <a href="<?=$list["hero_blog_08"]?>" target="_blank"><?=$list["hero_blog_08"]?></a>
                            </div>
                        </td>
                    </tr>
                    <?
                    $i--;
                }
            } else {
                ?>
                <tr>
                    <td colspan="12" class="no_data">등록된 데이터가 없습니다.</td>
                </tr>
            <?}?>
            </tbody>
        </table>
    </div>
</div>

<div class="pagingWrap">
    <? include_once PATH_INC_END.'page.php';?>
</div>

<script>
    $(document).ready(function(){
        fnSearch = function() {
            $("#searchForm").attr("action","").submit();
        }
    })
</script>


