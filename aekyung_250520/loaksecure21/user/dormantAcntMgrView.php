<?
if(!defined('_HEROBOARD_'))exit;

$hero_code = $_GET["hero_code"];

$member_sql  = " SELECT m.hero_code, hero_id, hero_name, hero_nick, hero_level ";
$member_sql .= " , hero_hp, hero_mail, hero_chk_phone, hero_chk_email, hero_address_01 ";
$member_sql .= " , hero_address_02, hero_address_03, area, area_etc_text, hero_user_type ";
$member_sql .= " , hero_user, hero_oldday , hero_blog_00, hero_memo ";
$member_sql .= " , hero_memo_01, hero_memo_01_image, hero_blog_04, hero_insta_cnt, hero_insta_grade  ";
$member_sql .= " , hero_insta_image_grade, hero_blog_03, hero_youtube_cnt, hero_youtube_grade, hero_youtube_view ";
$member_sql .= " , hero_blog_05, hero_blog_06, hero_blog_07, hero_blog_08, hero_sns_update_date, m.hero_today, hero_jumin ";
$member_sql .= " , q.hero_qs_01, q.hero_qs_02, q.hero_qs_03, q.hero_qs_04, q.hero_qs_05";
$member_sql .= " , q.hero_qs_06, q.hero_qs_07, q.hero_qs_08 ";
$member_sql .= " , (SELECT ifnull(sum(hero_point),0) FROM point WHERE hero_code = m.hero_code) as hero_point ";
$member_sql .= " , (SELECT ifnull(sum(hero_order_point),0) FROM order_main WHERE hero_code = m.hero_code AND hero_process!='".$_PROCESS_CANCEL."') hero_order_point ";
$member_sql .= " , (date_format(now(),'%Y') - substr(hero_jumin,1,4) + 1) as hero_age ";
$member_sql .= " FROM member_backup m ";
$member_sql .= " LEFT JOIN member_question q ON m.hero_code = q.hero_code AND q.hero_pid = 4 ";
$member_sql .= " WHERE m.hero_use = 0 AND m.hero_code = '".$hero_code."' ";

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
</form>
<div class="btnGroupFunction">
	<div class="leftWrap">
		<p class="tit_section">기본정보</p>
	</div>
</div>

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
		<td><?=$view["hero_id"]?> (LV : <?=$view["hero_level"]?>)</td>
		<th>닉네임</th>
		<td><?=$view["hero_nick"]?></td>
	</tr>
	<tr>
		<th>이름</th>
		<td><?=$view["hero_name"]?></td>
		<th>나이</th>
		<td><?=$view["hero_age"]?></td>
	</tr>
	<tr>
		<th>생년월일</th>
		<td colspan="3"><?=$view["hero_jumin"]?></td>
	</tr>
	<tr>
		<th>전체포인트</th>
		<td><?=number_format($view["hero_point"])?> p</td>
		<th>가용포인트</th>
		<td><?=number_format($view["hero_point"]-$view["hero_order_point"])?> p</td>
	</tr>
	<tr>
		<th>휴대폰번호</th>
		<td>
			<input type="text" name="hero_hp_01" value="<?=$hero_hp[0]?>" class="w100 input_hero_hp" maxlength="4" numberOnly readonly />
			- <input type="text" name="hero_hp_02" value="<?=$hero_hp[1]?>" class="w100 input_hero_hp" maxlength="4" numberOnly readonly/>
			- <input type="text" name="hero_hp_03" value="<?=$hero_hp[2]?>" class="w100 input_hero_hp" maxlength="4" numberOnly readonly/>
			
			<input type="checkbox" name="hero_hp_check" id="hero_hp_check"/><label>수정 활성화</label>
		</td>
		<th>이메일</th>
		<td>
			<input type="text" name="hero_mail_01" value="<?=$hero_mail[0]?>" class="w200 input_hero_mail" readonly/>
			@ <input type="text" name="hero_mail_02" value="<?=$hero_mail[1]?>" class="w200 input_hero_mail" readonly/>

		</td>
	</tr>
	<tr>
		<th>주소</th>
		<td colspan="3">
			[<?=$view["hero_address_01"]?>] <?=$view["hero_address_02"]?><br/>
			<?=$view["hero_address_03"]?>
		</td>
	</tr>
	<tr>
		<th>가입경로</th>
		<td colspan="3">
			<?=$view["area"]?>
			<? if($view["area"]=="기타") {?> 
				(<?=$view["area_etc_text"]?>)
			<? } ?>
		</td>
	</tr>
	<tr>
		<th>추천인</th>
		<td colspan="3">
			<? if($view["hero_user_type"] == "hero_id") {?>
				아이디 추천 : 
			<? } else if($view["hero_user_type"] == "hero_nick") { ?>
			   	닉네임 추천 :
			<? } ?>
			<?=$view["hero_user"]?>
		</td>
	</tr>
	<tr>
		<th>가입일</th>
		<td><?=$view["hero_oldday"]?></td>
		<th>최종 로그인 날짜</th>
		<td><?=$view["hero_today"]?></td>
	</tr>
</tbody>
</table>

<div class="align_c margin_t20">
	<a href="javascript:;" onclick="fnEdit()" class="btnAdd">수정</a>
</div>
</form>

<div class="align_l margin_t20">
	<a href="javascript:;" onclick="fnList();" class="btnList">목록</a>
</div>

<script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>
<script src="/js/daumAddressApi.js"></script>
<script>
$(document).ready(function(){
	$("#hero_hp_check").on("click",function(){
		if($(this).is(":checked")) {
			$(".input_hero_hp").attr("readOnly",false);
		} else {
			$(".input_hero_hp").attr("readOnly",true);
		}
	})
	
	$("#hero_mail_check").on("click",function(){
		if($(this).is(":checked")) {
			$(".input_hero_mail").attr("readOnly",false);
		} else {
			$(".input_hero_mail").attr("readOnly",true);
		}
	})
	
	fnEdit = function() {
		_frm = $("#viewForm");
		if(!_frm.find("input[name='hero_hp_01']").val()) {
			alert("휴대폰(1)을 입력해 주세요.");
			_frm.find("input[name='hero_hp_01']").focus();
			return;
		}

		if(!_frm.find("input[name='hero_hp_02']").val()) {
			alert("휴대폰(2)을 입력해 주세요.");
			_frm.find("input[name='hero_hp_02']").focus();
			return;
		}

		if(!_frm.find("input[name='hero_hp_03']").val()) {
			alert("휴대폰(3)을 입력해 주세요.");
			_frm.find("input[name='hero_hp_03']").focus();
			return;
		}

		_frm.find("input[name='mode']").val("edit");
		var param = _frm.serialize();
		$.ajax({
				url:"/loaksecure21/user/dormantManagerAction.php"
				,type:"POST"
				,data:param
				,dataType:"json"
				,success:function(d){
					console.log(d);
					if(d.result==1) {
						alert(" 수정 되었습니다.");
						location.reload();
					} else {
						alert("실행 중 실패했습니다.")
					}
				},error:function(e){
					console.log(e);
					alert("실패했습니다.");
				}
			})
			
			_frm.find("input[name='mode']").val(""); //초기화
	}

	
	fnList = function() {
		$("#searchForm").submit();
	}
})
</script>

