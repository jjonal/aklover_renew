<!DOCTYPE html>
<?
define('_HEROBOARD_', TRUE);
include_once '../../freebest/head.php';
include                                    '../popupSessionCheck.php';
include                                     FREEBEST_INC_END.'hero.php';
include                                     FREEBEST_INC_END.'function.php';
include 									'../page02.php';

$hero_code = $_GET["hero_code"];

$total_sql  = " SELECT count(*) cnt FROM ( ";
$total_sql .= " SELECT hero_title FROM member m ";
$total_sql .= " INNER JOIN board b ON m.hero_code = b.hero_code  ";
$total_sql .= " WHERE m.hero_use = 0 AND m.hero_code=  '".$hero_code."' ";
$total_sql .= " UNION ALL ";
$total_sql .= " SELECT hero_command as hero_title FROM member m ";
$total_sql .= " INNER JOIN review r ON m.hero_code = r.hero_code ";
$total_sql .= " WHERE m.hero_use = 0 AND m.hero_code=  '".$hero_code."') b ";

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

$sql  = " SELECT hero_title, hero_nick, hero_today, type ";
$sql .= " ,(SELECT hero_title FROM hero_group WHERE hero_board = b.hero_table) as menu_title ";
$sql .= " FROM ( ";
$sql .= " SELECT b.hero_title, b.hero_table, b.hero_today, '게시글' as type , m.hero_nick FROM member m ";
$sql .= " INNER JOIN board b ON m.hero_code = b.hero_code ";
$sql .= " WHERE m.hero_use = 0 AND m.hero_code=  '".$hero_code."' ";
$sql .= " UNION ALL ";
$sql .= " SELECT r.hero_command as hero_title, r.hero_table, r.hero_today, '댓글' as type , m.hero_nick FROM member m ";
$sql .= " INNER JOIN review r ON m.hero_code = r.hero_code ";
$sql .= " WHERE m.hero_use = 0 AND m.hero_code=  '".$hero_code."') b ";
$sql .= " ORDER BY b.hero_today DESC ";
$sql .= " LIMIT ".$start.",".$list_page;

$list_res = sql($sql, "on");
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
		<h1>작성글 확인</h1>
	</div>
	<div class="popContents">
		<table class=t_list>
		<colgroup>
			<col width="20%" />
			<col width="10%" />
			<col width="15%" />
			<col width="10%" />
			<col width="*%" />
		</colgroup>
		<thead>
			<tr>
				<th>등록일</th>
				<th>닉네임</th>
				<th>메뉴명</th>
				<th>타입</th>
				<th>내용</th>
			</tr>
		</thead>
		<tbody>
			<? 
			if($total_data > 0) {
			while($list = mysql_fetch_assoc($list_res)) {?>
			<tr>
				<td><?=$list["hero_today"]?></td>
				<td><?=$list["hero_nick"]?></td>
				<td><?=$list["menu_title"]?></td>
				<td><?=$list["type"]?></td>
				<td class="title"><?=$list["hero_title"]?></td>
			</tr>
			<? }
			} else {?>
			<tr>
				<td colspan="5">등록된 데이터가 없습니다.</td>
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