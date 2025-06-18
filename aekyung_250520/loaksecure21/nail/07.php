<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 문수영)2020년 04월 09일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$beauty_gisu = !$_REQUEST["beauty_gisu"] ? "1":$_REQUEST["beauty_gisu"];

$sql_gisu = " SELECT hero_beauty_gisu FROM mission_gisu "; //현재 기수
sql($sql_gisu);
$rs_gisu = mysql_fetch_assoc($out_sql);

$hero_use = $_REQUEST["hero_use"];
$hero_chk_phone = $_REQUEST["hero_chk_phone"];
$hero_chk_email = $_REQUEST["hero_chk_email"];

if(strlen($hero_use) > 0) {
	if($hero_use == 0) {
		$where .= " AND m.hero_use = '0' ";
	} else {
		$where .= " AND (m.hero_use != '0' or m.hero_use is null) ";
	}
}
if(strlen($hero_chk_phone) > 0) {
	if($hero_chk_phone == "1") {
		$where .= " AND m.hero_chk_phone = '".$hero_chk_phone."' ";
	} else {
		$where .= " AND m.hero_chk_phone != '1' ";
	}
} 
	
if(strlen($hero_chk_email) > 0) {
	if($hero_chk_email == "1") {
		$where .= " AND m.hero_chk_email = '".$hero_chk_email."' ";
	} else {
		$where .= " AND m.hero_chk_email != '1' ";
	}
}

$list_sql  =  " SELECT  m.hero_code , m.hero_id, w.hero_nick , m.hero_use, m.hero_name ";
$list_sql .=  " , case when m.hero_chk_phone = 1 then '동의' else '미동의' end as hero_chk_phone_name ";
$list_sql .=  " , case when m.hero_chk_email = 1 then '동의' else '미동의' end as hero_chk_email_name ";
$list_sql .=  " FROM mission_winner_list w LEFT JOIN member m ON w.hero_nick = m.hero_nick AND w.hero_name = m.hero_name  ";
$list_sql .=  " WHERE w.level = '9997' ".$where;

$out_sql = mysql_query($list_sql);

?>
<style>
.tbForm th{background:#eee; border:1px solid #cdcdcd; height:30px;}
.tbForm td{border:1px solid #cdcdcd; height:30px; padding:0 10px;}
.tbForm td input[type="text"]{width:100%;}
.tbForm td.c{text-align:center;}
</style>
<script>
function excel() {
	$('#form0 #mode').val("excel");
	$('#form0').attr('action','nail/excel_07.php').submit();
}

function fnSeach() {
	$('#form0 #mode').val("");
	$("#form0").attr("action","").submit();
}
</script>
<form name="form0" id="form0" method="post" enctype="multipart/form-data">
<div>
<input type="hidden" name="mode" id="mode" />
<input type="hidden" name="hero_id" id="hero_id" value="<?=$_SESSION["temp_id"]?>" />
<table class="tbForm" style="margin:0 auto;">
	<colgroup>
	<col width="120px" />
	<col width="300px" />
	<col width="120px" />
	<col width="300px" />
	</colgroup>
	<tr>
		<th><label>휘슬클럽 기수</label></th>
		<td>
			전체기수
		</td>
		<th><label>회원상태</label></th>
		<td><input type="radio" name="hero_use" id="hero_use_all" value="" style="margin-left:10px;" <?=!$hero_use ? "checked":"";?>/>
			<label for="hero_use_all" style="margin-left:5px;">전체</label>
		
			<input type="radio" name="hero_use" id="hero_use_0" value="0" style="margin-left:10px;" <?=$hero_use=="0" ? "checked":"";?>/>
			<label for="hero_use_0" style="margin-left:5px;">정상회원</label>
			
			<input type="radio" name="hero_use" id="hero_use_1" value="1" style="margin-left:10px;" <?=$hero_use=="1" ? "checked":"";?>/>
			<label for="hero_use_1" style="margin-left:5px;">정보없음</label>
		</td>
	</tr>
	<tr>
		<th><label>SMS수신동의</label></th>
		<td>
			<input type="radio" name="hero_chk_phone" id="hero_chk_phone_all" value="" style="margin-left:10px;" <?=!$hero_chk_phone ? "checked":"";?>/>
			<label for="hero_chk_phone_all" style="margin-left:5px;">전체</label>
			
			<input type="radio" name="hero_chk_phone" id="hero_chk_phone_1" value="1" style="margin-left:10px;" <?=$hero_chk_phone == "1" ? "checked":"";?>/>
			<label for="hero_chk_phone_1" style="margin-left:5px;">동의</label>
			
			<input type="radio" name="hero_chk_phone" id="hero_chk_phone_2" value="2" style="margin-left:10px;" <?=$hero_chk_phone == "2" ? "checked":"";?>/>
			<label for="hero_chk_phone_2" style="margin-left:5px;">미동의</label>
		</td>
		<th><label>이메일수신동의</label></th>
		<td>
			<input type="radio" name="hero_chk_email" id="hero_chk_email_all" value="" style="margin-left:10px;" <?=!$hero_chk_email ? "checked":"";?>/>
			<label for="hero_chk_email_all" style="margin-left:5px;">전체</label>
			
			<input type="radio" name="hero_chk_email" id="hero_chk_email_1" value="1" style="margin-left:10px;" <?=$hero_chk_email == "1" ? "checked":"";?>/>
			<label for="hero_chk_email_1" style="margin-left:5px;">동의</label>
			
			<input type="radio" name="hero_chk_email" id="hero_chk_email_2" value="2" style="margin-left:10px;" <?=$hero_chk_email == "2" ? "checked":"";?>/>
			<label for="hero_chk_email_2" style="margin-left:5px;">미동의</label>
		</td>
	</tr>
</table>

	<div style="margin:20px 0 0 0; text-align:center;">
		<a href="#" onClick="fnSeach();"><img src="../image/bbs/btn_search.gif" class="bd0"></a>
	</div>
</div>
</form>

<div style="text-align:right">
	<a href="javascript:;" onclick="excel()" class="btn_blue2">엑셀다운로드</a>
</div>

<div style="margin:30px 0 0 0;">
	<table class="tbForm" style="width:100%; margin:20px 0 0 0;">
		<colgroup>
			<col width="6%" />
			<col width="10%" />
			<col width="10%" />
			<col width="10%" />
			<col width="*" />
			<col width="10%" />
			<col width="10%" />
			<col width="10%" />
		</colgroup>
		<tr>
			<th>번호</th>
			<th>고유번호</th>
			<th>아이디</th>
			<th>이름</th>
			<th>닉네임</th>
			<th>회원상태</th>
			<th>SMS수신동의</th>
			<th>이메일수신동의</th>
		</tr>
		<? 
			$i=1;
			$member_status = array("0"=>"회원","1"=>"탈퇴","2"=>"휴먼회원");
			while($list = @mysql_fetch_assoc($out_sql)){ 
		?>
			<tr>
				<td class="c"><?=$i?></td>
				<td class="c"><?=$list["hero_code"];?></td>
				<td class="c"><?=$list["hero_id"];?></td>
				<td class="c"><?=$list["hero_name"];?></td>
				<td class="c"><?=$list["hero_nick"];?></td>
				<td class="c"><?=$member_status[$list["hero_use"]] == "회원" ? "회원":"정보없음";?></td>
				<td class="c"><?=$list["hero_chk_phone_name"];?></td>
				<td class="c"><?=$list["hero_chk_email_name"];?></td>
			</tr>
		<? 
			$i++;
			}
		?>
	</table>
	
	 <div style="width:100%; text-align:center; margin-top:20px;">
		<? include_once PATH_INC_END.'page.php';?>
     </div>
</div>
	

                        