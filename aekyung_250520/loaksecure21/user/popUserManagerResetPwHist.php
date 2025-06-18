<!DOCTYPE html>
<?
define('_HEROBOARD_', TRUE);
include_once '../../freebest/head.php';
include '../popupSessionCheck.php';
include FREEBEST_INC_END.'hero.php';
include FREEBEST_INC_END.'function.php';
include '../page02.php';

$hero_code = $_GET["hero_code"];

$total_sql  = " SELECT count(*) cnt FROM member_pw_initialize ";
$total_sql .= " WHERE hero_code=  '".$hero_code."' ";

$total_res = sql($total_sql,"on");
$total_rs = mysql_fetch_assoc($total_res);

$total_data = $total_rs['cnt'];

$i=$total_data;

$list_page=10;
$page_per_list=10;

if(!strcmp($_GET['page'], '')) {
	$page = '1';
} else {
	$page = $_GET['page'];
	$i = $i-($page-1)*$list_page;
}

$start = ($page-1)*$list_page;
$next_path=get("page");

$sql  = " SELECT hero_today, hero_id FROM member_pw_initialize ";
$sql .= " WHERE hero_code=  '".$hero_code."' ";
$sql .= " ORDER BY hero_today DESC ";
$sql .= " LIMIT ".$start.",".$list_page;

$list_res = sql($sql, "on");
$hero_yn = "성공";
$hero_channel = "";
?>
<meta charset="euc-kr" />
<head>
<link rel="stylesheet" type="text/css" href="<?=ADMIN_DEFAULT?>/css/admin.css" />
<script type="text/javascript" src="<?=JS_END;?>jquery.min.js"></script>
<script type="text/javascript" src="<?=JS_END;?>jquery.form.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
</head>
<body style="background:none;">
<form name="searchForm" id="searchForm">
	<input type="hidden" name="page" value="<?=$page?>" />
	<input type="hidden" name="hero_code" value="<?=$hero_code?>" />
</form>
<div class="popupWrap">
	<div class="popHeader">
		<h1>초기화 이력</h1>
	</div>
	<div class="popContents">
		<table class=t_list>
		<colgroup>
			<col width="50%" />
			<col width="50%" />
		</colgroup>
		<thead>
			<tr>
				<th>최기화 일시</th>
				<th>아이디</th>
			</tr>
		</thead>
		<tbody>
			<? 
			if($total_data > 0) {
			while($list = mysql_fetch_assoc($list_res)) {
			?>
			<tr>
				<td><?=$list["hero_today"]?></td>
				<td><?=$list["hero_id"]?></td>
			</tr>
			<? }
			} else {?>
			<tr>
				<td colspan="2">등록된 데이터가 없습니다.</td>
			</tr>
			<? } ?>
		</tbody>
		</table>
		
		<div class="paginate">
			<?=page2($total_data,$list_page,$page_per_list,$page,$next_path);?>
        </div>
	</div>
</div>
</body>
<html>
<script>
$(document).ready(function(){
	ch_page = function(page) {
		$("input[name='page']").val(page);
		$("#searchForm").submit();
	}
})
</script>  