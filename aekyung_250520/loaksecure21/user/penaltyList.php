<?
if(!defined('_HEROBOARD_'))exit;

$search = "";

if($_GET["type"]) {
    $search .= " AND p.type = '".$_GET["type"]."' ";
}

if($_GET["kewyword"]) {
    $search .= " AND ".$_GET["select"]." like '%".$_GET["kewyword"]."%' ";
}

//������ �ѹ���
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

$type_arr = array("1"=>"���߾��̵�","2"=>"���̵���� ���ؼ�","3"=>"�ı� �̵��","4"=>"�������� ���� ������","5"=>"ǳ��/���� ������","9"=>"��Ÿ");
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
            <th>���Ƽ Ÿ��</th>
            <td>
                <div class="search_inner sup">
                    <label class="akContainer">��ü
                        <input type="checkbox" name="penalty_type_chk" value="0">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">���߾��̵�
                        <input type="checkbox" name="penalty_type_chk" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">���̵���� ���ؼ�
                        <input type="checkbox" name="penalty_type_chk" value="2">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">�ı� �̵��
                        <input type="checkbox" name="penalty_type_chk" value="3">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">�������� ���� ������
                        <input type="checkbox" name="penalty_type_chk" value="4">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">ǰ��/���� ������
                        <input type="checkbox" name="penalty_type_chk" value="5">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">��Ÿ
                        <input type="checkbox" name="penalty_type_chk" value="6">
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
                            <option value="hero_memo" <?=$_GET["select"] == "m.memo" ? "selected" : ""?>>����</option>
                            <option value="hero_nick" <?=$_GET["select"] == "m.hero_nick" ? "selected" : ""?>>�г���</option>
                            <option value="hero_id" <?=$_GET["select"] == "m.hero_id" ? "selected" : ""?>>���̵�</option>
                            <option value="hero_name" <?=$_GET["select"] == "m.hero_name" ? "selected" : ""?>>�̸�</option>
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
		<th>�г�Ƽ Ÿ��</th>
		<td>
			<select name="type">
				<option value="">����</option>
				<option value="1" <?=$_GET["type"]=="1" ? "selected":""?>>���߾��̵�</option>
				<option value="2" <?=$_GET["type"]=="2" ? "selected":""?>>���̵���� ���ؼ�</option>
				<option value="3" <?=$_GET["type"]=="3" ? "selected":""?>>�ı� �̵��</option>
				<option value="4" <?=$_GET["type"]=="4" ? "selected":""?>>�������� ���� ������</option>
				<option value="5" <?=$_GET["type"]=="5" ? "selected":""?>>ǰ��/���� ������</option>
				<option value="9" <?=$_GET["type"]=="9" ? "selected":""?>>��Ÿ</option>
			</select>
		</td>
	</tr>
	<tr>
		<th>�˻���</th>
		<td>
			<select name="select">
				<option value="p.memo" <?if(!strcmp($_REQUEST['select'], 'p.memo')){echo ' selected';}else{echo '';}?>>����</option>
		    	<option value="m.hero_nick" <?if(!strcmp($_REQUEST['select'], 'm.hero_nick')){echo ' selected';}else{echo '';}?>>�г���</option>
		    	<option value="m.hero_name" <?if(!strcmp($_REQUEST['select'], 'm.hero_name')){echo ' selected';}else{echo '';}?>>�̸�</option>
		    	<option value="m.hero_id" <?if(!strcmp($_REQUEST['select'], 'm.hero_id')){echo ' selected';}else{echo '';}?>>���̵�</option>
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
                    �̸�
                </div>
            </th>
            <th>
                <div class="">
                    ���̵�
                </div>
            </th>
            <th>
                <div class="">
                    �г���
                </div>
            </th>
            <th>
                <div class="">
                    �������� ����
                </div>
            </th>
            <th>
                <div class="">
                    ���Ƽ Ÿ��
                </div>
            </th>
            <th>
                <div class="">
                    �� ����
                </div>
            </th>
            <th>
                <div class="">
                    �����
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
                        $hero_sex_txt = "��";
                    } else if(strlen($list["hero_sex"]) > 0 && $list["hero_sex"] == 0) {
                        $hero_sex_txt = "��";
                    }

                    $hero_use_txt = "";
                    if($list["hero_use"] == 0) {
                        $hero_use_txt = "ȸ��";
                    } else if($list["hero_use"] == 1) {
                        $hero_use_txt = "Ż��";
                    } else if($list["hero_use"] == 2) {
                        $hero_use_txt = "�޸�ȸ��";
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
                                �������� ����
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
                    <td colspan="8" class="no_data">��ϵ� �����Ͱ� �����ϴ�.</td>
                </tr>
            <?}?>
            </tbody>
        </table>
    </div>
</div>

<!-- ���Ƽ �� ���� �˾�-->
<div class="popup_url_box">
    <div class="popup_url_cont height_typeB">
        <div class="popup_url_head">
            <svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.41073 4.41083C4.73617 4.08539 5.26381 4.08539 5.58925 4.41083L15.5892 14.4108C15.9147 14.7363 15.9147 15.2639 15.5892 15.5893C15.2638 15.9148 14.7362 15.9148 14.4107 15.5893L4.41073 5.58934C4.0853 5.2639 4.0853 4.73626 4.41073 4.41083Z" fill="black"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5892 4.41083C15.2638 4.08539 14.7362 4.08539 14.4107 4.41083L4.41072 14.4108C4.08529 14.7363 4.08529 15.2639 4.41072 15.5893C4.73616 15.9148 5.2638 15.9148 5.58924 15.5893L15.5892 5.58934C15.9147 5.2639 15.9147 4.73626 15.5892 4.41083Z" fill="black"/>
            </svg>
        </div>
        <div class="popup_url_body">
            <div class="tit">���Ƽ �� ����</div>
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
        // url �˾� �ݱ�
        $('.popup_url_head .close').on('click', function(){
            $('.popup_url_box').removeClass('show');
        })

        fnSearch = function() {
            $("#searchForm").attr("action","").submit();
        }
    })
</script>


