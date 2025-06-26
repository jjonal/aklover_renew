<!DOCTYPE html>
<?
define('_HEROBOARD_', TRUE);
include_once '../../freebest/head.php';
include                                    '../popupSessionCheck.php';
include                                     FREEBEST_INC_END.'hero.php';
include                                     FREEBEST_INC_END.'function.php';
include 									'../page02.php';

$hero_code = $_GET["hero_code"];

$total_sql = " SELECT count(*) cnt FROM member_penalty WHERE hero_use_yn = 'Y' AND hero_code=  '".$hero_code."' ";
$total_res = sql($total_sql,"on");
$total_rs = mysql_fetch_assoc($total_res);

$total_data = $total_rs['cnt'];

$i=$total_data;

$list_page=5;
$page_per_list=10;

if(!strcmp($_GET['page'], '')) {
    $page = '1';
} else {
    $page = $_GET['page'];
    $i = $i-($page-1)*$list_page;
}

$start = ($page-1)*$list_page;
$next_path=get("page");

$sql  = " SELECT hero_idx, hero_today, memo, type FROM member_penalty WHERE hero_use_yn = 'Y' AND hero_code=  '".$hero_code."' ORDER BY hero_idx DESC ";
$sql .= " LIMIT ".$start.",".$list_page;

$list_res = sql($sql, "on");

$type_arr = array("1"=>"���߾��̵�","2"=>"���̵���� ���ؼ�","3"=>"�ı� �̵��","4"=>"�������� ���� ������","5"=>"ǳ��/���� ������","9"=>"��Ÿ");
?>
<meta charset="euc-kr" />
<head>
    <link rel="stylesheet" type="text/css" href="<?=ADMIN_DEFAULT?>/css/admin.css" />
    <link rel="stylesheet" type="text/css" href="<?=ADMIN_DEFAULT?>/css/common.css" />
    <link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/user.css?v=250617" type="text/css" />
    <script type="text/javascript" src="<?=JS_END;?>jquery.min.js"></script>
    <script type="text/javascript" src="<?=JS_END;?>jquery.form.js"></script>
    <script type="text/javascript" src="/js/common.js"></script>
</head>
<body style="background:none;">
<form name="searchForm" id="searchForm">
    <input type="hidden" name="page" value="<?=$page?>" />
    <input type="hidden" name="hero_code" value="<?=$hero_code?>" />
</form>
<div class="popupWrap penalty_popup mu_form">
    <div class="popContents">
        <!-- �г�Ƽ ����/���� -->
        <div class="popHeader">
            <h2>�г�Ƽ ����/����</h2>
        </div>
        <form name="listForm" id="listForm" method="POST">
            <input type="hidden" name="hero_idx" />
            <input type="hidden" name="hero_code" value="<?=$hero_code?>" />
            <input type="hidden" name="mode" value="" />
            <table class="mu_table mgt10 panealty_list">
                <colgroup>
                    <col width="20%" />
                    <col width="15%" />
                    <col width="*%" />
                    <col width="15%" />
                </colgroup>
                <thead>
                <tr>
                    <th>�����</th>
                    <th>Ÿ��</th>
                    <th>ü���</th>
                    <th>����</th>
                </tr>
                </thead>
                <tbody class="line">
                <tr>
                    <td>2024-00-00</td>
                    <td>���̵� ���ؼ�</td>
                    <td class="title">Ȩ��� �κ�û�ұ� ���ο� Ŭ����...</td>
                    <td><a href="javascript:;" onClick="fnDelPenalty('<?=$list["hero_idx"]?>')" class="btnAdd4">����</a></td>
                </tr>
                <!-- ��ϵ� �����Ͱ� ���� �� �����ּ���. -->
                <!-- <tr>
                    <td colspan="4" class="no_data">��ϵ� �����Ͱ� �����ϴ�.</td>
                </tr> -->

                <!-- <?
                if($total_data > 0) {
                    while($list = mysql_fetch_assoc($list_res)) {?>
				<tr>
					<td><?=$list["hero_today"]?></td>
					<td><?=$type_arr[$list["type"]]?></td>
					<td class="title"><?=$list["memo"]?></td>
					<td><a href="javascript:;" onClick="fnDelPenalty('<?=$list["hero_idx"]?>')" class="btnForm">����</a></td>
				</tr>
				<? }
                } else {?>
				<tr class="align_c">
					<td colspan="4">��ϵ� �����Ͱ� �����ϴ�.</td>
				</tr>
				<? } ?> -->
                </tbody>
            </table>
        </form>

        <div class="paginate">
            <?=page2($total_data,$list_page,$page_per_list,$page,$next_path);?>
        </div>

        <!-- �г�Ƽ ��� -->
        <div class="popHeader">
            <h2>�г�Ƽ ���</h2>
        </div>
        <form name="writeForm" id="writeForm" method="POST">
            <input type="hidden" name="hero_code" value="<?=$hero_code?>" />
            <input type="hidden" name="mode" value="penalty" />
            <table class="mu_table mgt10">
                <colgroup>
                    <col width="150">
                    <col width="*">
                </colgroup>
                <thead>
                <tr>
                    <th>Ÿ��</th>
                    <th>����</th>
                    <!-- <th>���</th> -->
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <div class="select_wrap">
                            <select name="type">
                                <option value="">����</option>
                                <option value="1">���߾��̵�</option>
                                <option value="2">���̵���� ���ؼ�</option>
                                <option value="3">�ı� �̵��</option>
                                <option value="4">�������� ���� ������</option>
                                <option value="5">ǰ��/���� ������</option>
                                <option value="9">��Ÿ</option>
                            </select>
                        </div>
                    </td>
                    <td><input type="text" name="memo" /></td>
                    <!-- <td><a href="javascript:;" onClick="fnPenalty();" class="btnForm">���</a></td> -->
                <tr>
                </tbody>
            </table>

            <table class="mu_table mgt20">
                <colgroup>
                    <col width="150">
                    <col width="*">
                </colgroup>
                <thead>
                <tr>
                    <th>�������� ����</th>
                    <th>ü��� ����</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <div class="select_wrap">
                            <select name="type">
                                <option value="">����</option>
                                <option value="1">�����̾� ��Ƽ</option>
                                <option value="2">�����̾� ������</option>
                                <option value="3">������ ��Ƽ&������</option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="select_wrap">
                            <!-- ���� ����ǰ� �ִ� ü��� ����Ʈ ���� -->
                            <select name="type">
                                <option value="">����</option>
                                <option value="1"></option>
                                <option value="2"></option>
                                <option value="3"></option>
                            </select>
                        </div>
                    </td>
                <tr>
                </tbody>
            </table>
            <div class="btnContainer mgt20">
                <a href="javascript:;" onClick="fnPenalty();" class="btnAdd3">�г�Ƽ ���</a>
            </div>
        </form>
    </div>

    <!-- [���� ��û] �г�Ƽ �� ���� ���⼭ �����ּ���.-->
    <!-- <div class="penalty_detail">
        <div class="pop_header">
            <h2>���Ƽ �� ����</h2>
            <p class="penalty_detail_back">�ڷΰ��� �ӽ� ��ư</p>
        </div>
        <div class="pop_content mgt10">
            <textarea></textarea>
        </div>
    </div> -->


</div>
</body>
<html>
<script>
    $(document).ready(function(){
        fnDelPenalty = function(hero_idx) {
            if(confirm("�г�Ƽ�� �����Ͻðڽ��ϱ�?")) {
                $("#listForm input[name='hero_idx']").val(hero_idx);
                $("#listForm input[name='mode']").val("delPenalty");

                var param = $("#listForm").serialize();

                $.ajax({
                    url:"/loaksecure21/user/popUserManagerPenaltyListAction.php"
                    ,type:"POST"
                    ,data:param
                    ,dataType:"json"
                    ,success:function(d){
                        console.log(d);
                        if(d.result==1) {
                            alert("�г�Ƽ�� �����Ǿ����ϴ�.");
                            location.reload();
                        } else {
                            alert("���� �� �����߽��ϴ�.")
                        }
                    },error:function(e){
                        console.log(e);
                        alert("�����߽��ϴ�.");
                    }
                })

                $("#listForm input[name='mode']").val("");


            }
        }

        fnPenalty = function() {
            if(!$("select[name='type']").val()) {
                alert("�г�Ƽ Ÿ���� ������ �ּ���.");
                $("select[name='type']").focus();
                return;
            }

            if(!$("input[name='memo']").val()) {
                alert("�г�Ƽ ������ �Է��� �ּ���.");
                $("input[name='memo']").focus();
                return;
            }

            if(confirm("�г�Ƽ ����Ͻðڽ��ϱ�?")) {
                var param = $("#writeForm").serialize();

                $.ajax({
                    url:"/loaksecure21/user/popUserManagerPenaltyListAction.php"
                    ,type:"POST"
                    ,data:param
                    ,dataType:"json"
                    ,success:function(d){
                        console.log(d);
                        if(d.result==1) {
                            alert("�г�Ƽ�� ��ϵǾ����ϴ�.");
                            location.reload();
                        } else {
                            alert("���� �� �����߽��ϴ�.")
                        }
                    },error:function(e){
                        console.log(e);
                        alert("�����߽��ϴ�.");
                    }
                })
            }

        }

        ch_page = function(page) {
            $("input[name='page']").val(page);
            $("#searchForm").submit();
        }
    })
</script>  