<!DOCTYPE html>
<?
define('_HEROBOARD_', TRUE);
include_once '../../freebest/head.php';
include                                    '../popupSessionCheck.php';
include                                     FREEBEST_INC_END.'hero.php';
include                                     FREEBEST_INC_END.'function.php';
include 									'../page02.php';

$hero_code = $_GET["hero_code"];

$total_sql = " SELECT count(*) cnt FROM member m INNER JOIN superpass s  ON m.hero_code = s.hero_code WHERE m.hero_use = 0 AND m.hero_code=  '".$hero_code."' ";
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

$sql  = " SELECT s.hero_idx, s.hero_kind, s.hero_today, s.hero_superpass, s.hero_endday, s.hero_use_yn FROM member m ";
$sql .= " INNER JOIN superpass s ON m.hero_code = s.hero_code ";
$sql .= " WHERE m.hero_use = 0 AND m.hero_code=  '".$hero_code."' ORDER BY s.hero_idx DESC ";
$sql .= " LIMIT ".$start.",".$list_page;

$list_res = sql($sql, "on");
?>
<meta charset="euc-kr" />
<head>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="<?=ADMIN_DEFAULT?>/css/admin.css" />
    <link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/common.css?v=250617" type="text/css" />
    <script type="text/javascript" src="<?=JS_END;?>jquery.min.js"></script>
    <script type="text/javascript" src="<?=JS_END;?>jquery.form.js"></script>
    <script type="text/javascript" src="/js/common.js"></script>
    <script type="text/javascript" src="/loaksecure21/js/admin.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body style="background:none;">
<form name="searchForm" id="searchForm">
    <input type="hidden" name="page" value="<?=$page?>" />
    <input type="hidden" name="hero_code" value="<?=$hero_code?>" />
</form>
<div class="popupWrap">
    <!-- <div class="popHeader">
        <h1>�����н� Ȯ��</h1>
    </div> -->
    <div class="popContents">
        <form name="listForm" id="listForm" method="POST">
            <input type="hidden" name="hero_idx" />
            <input type="hidden" name="hero_code" value="<?=$hero_code?>" />

            <!-- �����н� Ȯ�� �ּ�ó�� -->
            <!-- <input type="hidden" name="mode" value="" />
			<table class=t_list>
			<colgroup>
				<col width="20%" />
				<col width="20%" />
				<col width="*%" />
				<col width="15%" />
				<col width="10%" />
				<col width="10%" />
			</colgroup>
			<thead>
				<tr>
					<th>�����</th>
					<th>��������</th>
					<th>Ÿ��</th>
					<th>�������</th>
					<th>����</th>
					<th>����</th>
				</tr>
			</thead>
			<tbody>
				<?
            if($total_data > 0) {
                while($list = mysql_fetch_assoc($list_res)) {?>
				<tr>
					<td><?=$list["hero_today"]?></td>
					<td><?=$list["hero_endday"]?></td>
					<td class="title"><?=$list["hero_kind"]?></td>
					<td><?=$list["hero_use_yn"]=="Y" ? "���":"�̻��"?></td>
					<td><?=$list["hero_superpass"]?></td>
					<td><a href="javascript:;" onClick="fnDelSuperpass('<?=$list["hero_idx"]?>');" class="btnForm">����</a></td>
				</tr>
				<? }
            } else {?>
				<tr>
					<td colspan="6">��ϵ� �����Ͱ� �����ϴ�.</td>
				</tr>
				<? } ?>
			</tbody>
			</table>
		</form>

		<div class="paginate">
			<?=page2($total_data,$list_page,$page_per_list,$page,$next_path);?>
        </div> -->

            <div class="popHeader">
                <h2>�����н� ����</h1>
            </div>
            <form name="writeForm" id="writeForm" method="POST">
                <input type="hidden" name="hero_code" value="<?=$hero_code?>" />
                <input type="hidden" name="mode" value="superpass" />
                <table class="mgt10 mu_table mu_form">
                    <colgroup>
                        <col width="*">
                        <col width="150">
                    </colgroup>
                    <thead>
                    <tr>
                        <th>Ÿ��</th>
                        <th>������</th>
                        <!-- <th>����</th> -->
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
                <div class="btnContainer mgt20">
                    <a href="javascript:;" onClick="fnSuperpass();" class="btnAdd3">�����н� ����</a>
                </div>

            </form>

            <!-- ���� �����н� ���� �ּ�ó�� -->
            <!-- <form name="writeForm" id="writeForm" method="POST">
        <input type="hidden" name="hero_code" value="<?=$hero_code?>" />
        <input type="hidden" name="mode" value="superpass" />
	        <table class="t_list mgt10">
	        <colgroup>
				<col width="*">
				<col width="150">
				<col width="100">
			</colgroup>
			<thead>
				<tr>
					<th>Ÿ��</th>
					<th>������</th>
					<th>����</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><input type="text" name="hero_kind" /></td>
					<td><input type="text" name="hero_endday" class="dateMode" style="width:100px;vertical-align:bottom" /></td>
					<td><a href="javascript:;" onClick="fnSuperpass();" class="btnForm">����</a></td>
				<tr>
			</tbody>
	        </table>
        </form> -->
    </div>
</div>
</body>
<html>
<script>
    $(document).ready(function(){
        fnDelSuperpass = function(hero_idx) {
            if(confirm("���޹��� �����н��� �����Ͻðڽ��ϱ�?")) {
                $("#listForm input[name='hero_idx']").val(hero_idx);
                $("#listForm input[name='mode']").val("delSuperpass");

                var param = $("#listForm").serialize();

                $.ajax({
                    url:"/loaksecure21/user/popUserManagerSuperpassListAction.php"
                    ,type:"POST"
                    ,data:param
                    ,dataType:"json"
                    ,success:function(d){
                        console.log(d);
                        if(d.result==1) {
                            alert("�����н��� �����Ǿ����ϴ�.");
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

        fnSuperpass = function() {
            if(!$("input[name='hero_kind']").val()) {
                alert("������ Ÿ���� �Է��� �ּ���.");
                $("input[name='hero_kind']").focus();
                return;
            }

            if(!$("input[name='hero_endday']").val()) {
                alert("����Ⱓ�� �Է��� �ּ���.");
                $("input[name='hero_endday']").focus();
                return;
            }

            if(confirm("�����н��� �����Ͻðڽ��ϱ�?")) {
                var param = $("#writeForm").serialize();

                $.ajax({
                    url:"/loaksecure21/user/popUserManagerSuperpassListAction.php"
                    ,type:"POST"
                    ,data:param
                    ,dataType:"json"
                    ,success:function(d){
                        console.log(d);
                        if(d.result==1) {
                            alert("�����н��� ���޵Ǿ����ϴ�.");
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