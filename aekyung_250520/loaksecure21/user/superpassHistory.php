<?
if(!defined('_HEROBOARD_'))exit;

$search = "";

if($_GET["superpass_check"]) {
    $search .= " AND superpass_check = '".$_GET["superpass_check"]."' ";
}

if($_GET["kewyword"]) {
    $search .= " AND ".$_GET["select"]." like '%".$_GET["kewyword"]."%' ";
}

$total_sql  = " SELECT count(*) as cnt  ";
$total_sql .= " FROM superpass_history s INNER JOIN member m ON s.hero_code = m.hero_code ";
$total_sql .= " WHERE 1=1 ".$search;

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
$sql .= " m.hero_nick, m.hero_id, m.hero_name, s.panelty_check, s.login_a_month_ago_check  ";
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
                    <label class="akContainer">전체
                        <input type="checkbox" name="superpass_chk" value="all">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">지급
                        <input type="checkbox" name="superpass_chk" value="payment">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">미지급
                        <input type="checkbox" name="superpass_chk" value="unpaid">
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
        <h2 class="table_tit">검색 결과</h2>
        <p class="postNum"><span class="line"><?=number_format($search_total)?>개</span><span class="op_5">전체 <?=number_format($total_data)?>개</span></p>
    </div>
    <p class="table_desc"></p>
    <div class="searchResultBox_container">
        <table class="searchResultBox">
            <colgroup>
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
                    <td colspan="10" class="no_data">등록된 데이터가 없습니다.</td>
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


