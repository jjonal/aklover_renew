<? 
if(!defined('_HEROBOARD_'))exit;

$hero_code = $_GET["hero_code"];

$member_sql  = " SELECT hero_code, hero_id, hero_name, hero_nick, hero_country ";
$member_sql .= " , hero_jumin , hero_mail, hero_hp, hero_motive, hero_insta ";
$member_sql .= " , hero_insta_cnt, hero_youtube, hero_vk, hero_etc, hero_remark, hero_oldday ";
$member_sql .= " , hero_today ";
$member_sql .= " , (date_format(now(),'%Y') - substr(hero_jumin,1,4) + 1) as hero_age ";
$member_sql .= " FROM global_member ";
$member_sql .= " WHERE hero_use = 0 AND hero_code = '".$hero_code."' ";

$member_res = sql($member_sql,"on");
$view = mysql_fetch_assoc($member_res);

$hero_hp = explode("-",$view["hero_hp"]);
$hero_mail = explode("@",$view["hero_mail"]);
?>
<form name="searchForm" id="searchForm" method="GET">
<? 
unset($_GET["hero_code"]);
unset($_GET["view"]);
foreach($_GET as $key=>$val) {?>
<input type="hidden" name="<?=$key?>" value="<?=$val?>" />
<? } ?>
<form name="viewForm" id="viewForm">
<input type="hidden" name="mode" />
<input type="hidden" name="hero_code" value="<?=$view["hero_code"]?>"/>
<table class="t_view">
<colgroup>
	<col width="150px">
	<col width=*>
	<col width="150px">
	<col width=*>
</colgroup>
<tbody>
	<tr>
		<th>아이디</th>
		<td><?=$view["hero_id"]?></td>
		<th>닉네임</th>
		<td><?=$view["hero_nick"]?></td>
	</tr>
	<tr>
		<th>이름</th>
		<td><?=$view["hero_name"]?></td>
		<th>나이</th>
		<td><?=$view["hero_age"]?> (생년월일 : <?=$view["hero_jumin"]?>)</td>
	</tr>
	<tr>
		<th>휴대폰번호</th>
		<td><?=$hero_hp[0]?>-<?=$hero_hp[1]?>-<?=$hero_hp[2]?></td>
		<th>이메일</th>
		<td><?=$hero_mail[0]?>@<?=$hero_mail[1]?></td>
	</tr>
	<tr>
		<th>인스타그램 URL</th>
		<td colspan="3"><?=$view["hero_insta"]?> (팔로워 수 : <?=number_format($view["hero_insta_cnt"])?>)</td>
	</tr>
	<tr>
		<th>유튜브 URL</th>
		<td colspan="3"><?=$view["hero_youtube"]?></td>
	</tr>
	<tr>
		<th>vk URL</th>
		<td colspan="3"><?=$view["hero_vk"]?></td>
	</tr>
	<tr>
		<th>기타 URL</th>
		<td colspan="3"><?=$view["hero_etc"]?></td>
	</tr>
	<tr>
		<th>지원동기</th>
		<td colspan="3"><?=nl2br($view["hero_motive"])?></td>
	</tr>
	<tr>
		<th>비고</th>
		<td colspan="3"><?=$view["hero_remark"]?></td>
	</tr>
	<tr>
		<th>마지막 로그인 시간</th>
		<td><?=$view["hero_today"]?></td>
		<th>가입일</th>
		<td><?=$view["hero_oldday"]?></td>
	</tr>
</tbody>
</table>

<div class="align_l margin_t20">
	<a href="javascript:;" onclick="fnList();" class="btnList">목록</a>
</div>
<script>
$(document).ready(function(){
	fnList = function() {
		$("#searchForm").submit();
	}
})
</script>
