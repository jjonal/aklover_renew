<?
if(!defined('_HEROBOARD_'))exit;

$search = "";

if($_GET["url"]) {
    $search .= " AND ".$_GET["hero_blog"]." like '%".$_GET["url"]."%' ";
}

if($_GET["kewyword"]) {
    $search .= " AND ".$_GET["select"]." = '".$_GET["kewyword"]."' ";
}

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
                    <label class="akContainer">전체
                        <input type="checkbox" name="sns_chk" value="all">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">블로그
                        <input type="checkbox" name="sns_chk" value="blog">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">인스타그램
                        <input type="checkbox" name="sns_chk" value="insta">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">숏폼
                        <input type="checkbox" name="sns_chk" value="short">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">기타
                        <input type="checkbox" name="sns_chk" value="ect">
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

    <!-- 250625 검색필터 기존 주석처리 -->

    <!-- <table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>SNS URL</th>
		<td>
			<select name="hero_blog">
				<option value="hero_blog_00" <?=$_GET["hero_blog"]=="hero_blog_00" ? "selected":""?>>네이버 블로그</option>
				<option value="hero_blog_04" <?=$_GET["hero_blog"]=="hero_blog_04" ? "selected":""?>>인스타그램</option>
				<option value="hero_blog_05" <?=$_GET["hero_blog"]=="hero_blog_05" ? "selected":""?>>그 외 SNS URL</option>
				<option value="hero_blog_03" <?=$_GET["hero_blog"]=="hero_blog_03" ? "selected":""?>>유튜브</option>
				<option value="hero_blog_06" <?=$_GET["hero_blog"]=="hero_blog_06" ? "selected":""?>>네이버TV</option>
				<option value="hero_blog_07" <?=$_GET["hero_blog"]=="hero_blog_07" ? "selected":""?>>틱톡</option>
				<option value="hero_blog_08" <?=$_GET["hero_blog"]=="hero_blog_08" ? "selected":""?>>기타(영상)</option>
			</select>
			<input type="text" name="url" value="<?=$_REQUEST["url"];?>" class="kewyword">
		</td>
	</tr>
	<tr>
		<th>검색어</th>
		<td>
			<select name="select">
		    	<option value="hero_nick" <?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>닉네임</option>
		    	<option value="hero_name" <?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>이름</option>
		    	<option value="hero_id" <?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>아이디</option>
		    	<option value="hero_hp" <?if(!strcmp($_REQUEST['select'], 'hero_hp')){echo ' selected';}else{echo '';}?>>휴대폰번호</option>
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
        <p class="postNum"><span class="line"><?=number_format($search_total)?>개</span><span class="op_5">전체 <?=number_format($total_data)?>개</span></p>
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
                    틱톡
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
                                <?=$list["hero_hp"]?>
                            </div>
                        </td>
                        <td class="title">
                            <div class="table_result_create">
                                <?=$list["hero_blog_00"]?>
                            </div>
                        </td>
                        <td class="title">
                            <div class="table_result_create">
                                <?=$list["hero_blog_04"]?>
                            </div>
                        </td>
                        <td class="title">
                            <div class="table_result_create">
                                <?=$list["hero_blog_05"]?>
                            </div>
                        </td>
                        <td class="title">
                            <div class="table_result_create">
                                <?=$list["hero_blog_03"]?>
                            </div>
                        </td>
                        <td class="title">
                            <div class="table_result_create">
                                <?=$list["hero_blog_06"]?>
                            </div>
                        </td>
                        <td class="title">
                            <div class="table_result_create">
                                <?=$list["hero_blog_07"]?>
                            </div>
                        </td>
                        <td class="title">
                            <div class="table_result_create">
                                <?=$list["hero_blog_08"]?>
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


