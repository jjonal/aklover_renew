<?
if(!defined('_HEROBOARD_'))exit;

$search = "";

if($_GET["url"]) {
    $search .= " AND ".$_GET["hero_blog"]." like '%".$_GET["url"]."%' ";
}

if($_GET["kewyword"]) {
    $search .= " AND ".$_GET["select"]." = '".$_GET["kewyword"]."' ";
}

//������ �ѹ���
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

    <!-- 250625 SNS �ּ� Ȯ�� �˻� ���� -->
    <table class="searchBox">
        <colgroup>
            <col width="171px" />
            <col width="*" />
        </colgroup>
        <tr>
            <th>SNS</th>
            <td>
                <div class="search_inner sup">
                    <label class="akContainer">��ü
                        <input type="checkbox" name="sns_chk" value="all">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">��α�
                        <input type="checkbox" name="sns_chk" value="blog">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">�ν�Ÿ�׷�
                        <input type="checkbox" name="sns_chk" value="insta">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">����
                        <input type="checkbox" name="sns_chk" value="short">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">��Ÿ
                        <input type="checkbox" name="sns_chk" value="ect">
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
        </tr>
        <tr>
            <th>
                �˻�
            </th>
            <td>
                <div class="search_inner">
                    <div class="select-wrap">
                        <select name="select">
                            <option value="none" <?=!isset($_GET["select"]) || $_GET["select"] == "none" ? "selected" : ""?>>����</option>
                            <option value="hero_nick" <?=$_GET["select"] == "m.hero_nick" ? "selected" : ""?>>�г���</option>
                            <option value="hero_id" <?=$_GET["select"] == "m.hero_id" ? "selected" : ""?>>���̵�</option>
                            <option value="hero_name" <?=$_GET["select"] == "m.hero_name" ? "selected" : ""?>>�̸�</option>
                            <option value="hero_hp" <?=$_GET["select"] == "m.hero_hp" ? "selected" : ""?>>����ó</option>
                        </select>
                    </div>
                    <input class="search_txt" type="text" name="kewyword" value="<?=$_GET["kewyword"]?>"/>
                </div>
            </td>
        </tr>
    </table>
    <div class="btnGroupSearch_box">
        <div class="btnGroupSearch">
            <a href="javascript:;" onClick="fnSearch()" class="btnSearch">�˻�</a>
        </div>
    </div>

    <!-- 250625 �˻����� ���� �ּ�ó�� -->

    <!-- <table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>SNS URL</th>
		<td>
			<select name="hero_blog">
				<option value="hero_blog_00" <?=$_GET["hero_blog"]=="hero_blog_00" ? "selected":""?>>���̹� ��α�</option>
				<option value="hero_blog_04" <?=$_GET["hero_blog"]=="hero_blog_04" ? "selected":""?>>�ν�Ÿ�׷�</option>
				<option value="hero_blog_05" <?=$_GET["hero_blog"]=="hero_blog_05" ? "selected":""?>>�� �� SNS URL</option>
				<option value="hero_blog_03" <?=$_GET["hero_blog"]=="hero_blog_03" ? "selected":""?>>��Ʃ��</option>
				<option value="hero_blog_06" <?=$_GET["hero_blog"]=="hero_blog_06" ? "selected":""?>>���̹�TV</option>
				<option value="hero_blog_07" <?=$_GET["hero_blog"]=="hero_blog_07" ? "selected":""?>>ƽ��</option>
				<option value="hero_blog_08" <?=$_GET["hero_blog"]=="hero_blog_08" ? "selected":""?>>��Ÿ(����)</option>
			</select>
			<input type="text" name="url" value="<?=$_REQUEST["url"];?>" class="kewyword">
		</td>
	</tr>
	<tr>
		<th>�˻���</th>
		<td>
			<select name="select">
		    	<option value="hero_nick" <?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>�г���</option>
		    	<option value="hero_name" <?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>�̸�</option>
		    	<option value="hero_id" <?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>���̵�</option>
		    	<option value="hero_hp" <?if(!strcmp($_REQUEST['select'], 'hero_hp')){echo ' selected';}else{echo '';}?>>�޴�����ȣ</option>
	    	</select>
	    	<input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];;?>" class="kewyword">
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">�˻�</a>
</div> -->
</form>


<div class="tableSection mgt30">
    <div class="table_top">
        <h2 class="table_tit">�˻� ���</h2>
        <p class="postNum"><span class="line"><?=number_format($search_total)?>��</span><span class="op_5">��ü <?=number_format($total_data)?>��</span></p>
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
                    ���̵�
                </div>
            </th>
            <th>
                <div class="">
                    �̸�
                </div>
            </th>
            <th>
                <div class="">
                    �г���
                </div>
            </th>
            <th>
                <div class="">
                    �޴��� ��ȣ
                </div>
            </th>
            <th>
                <div class="">
                    ��α�
                </div>
            </th>
            <th>
                <div class="">
                    �ν�Ÿ�׷�
                </div>
            </th>
            <th>
                <div class="">
                    �� �� SNS �ּ�
                </div>
            </th>
            <th>
                <div class="">
                    ��Ʃ��
                </div>
            </th>
            <th>
                <div class="">
                    ���̹�TV
                </div>
            </th>
            <th>
                <div class="">
                    ƽ��
                </div>
            </th>
            <th>
                <div class="">
                    ��Ÿ(����)
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
                    <td colspan="12" class="no_data">��ϵ� �����Ͱ� �����ϴ�.</td>
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


