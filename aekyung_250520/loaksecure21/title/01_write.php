<?
if(!defined('_HEROBOARD_'))exit;

$sql  = " SELECT *  ";
$sql .=" , (SELECT hero_name FROM level WHERE hero_level = a.hero_level) as level_name ";
$sql .=" FROM admin a WHERE hero_use=0 AND hero_idx=".$_GET['hero_idx'];
sql($sql);

$list = @mysql_fetch_assoc($out_sql);
$hp_data = explode('-', $list['hero_hp']);
$mail_data = explode('@', $list['hero_mail']);

?>
    <script>
    function emailChg(){
    form_next.email2.value = form_next.email_select.value;
    }
    function go_list(){
        location.href = "./index.php?board=<?=$_GET['board']?>&idx=<?=$_GET['idx']?>";
    }
    </script>
<form name="form_next" action="<?=url('PATH_HOME||board||'.$_GET['board'].'||&view=write&idx='.$_GET['idx']);?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="hero_drop" value="hero_code||type||hero_idx||hero_drop||email_select||email1||email2||hero_hp1||hero_hp2||hero_hp3">
<input type="hidden" name="hero_code" value="<?=$list['hero_code']?>">
<input type="hidden" name="type" value="<?=$list["hero_idx"] ? "modify":"write"?>">
<input type="hidden" name="hero_table" value="admin">
<input type="hidden" name="hero_today" value="<?=Ymdhis?>">
<input type="hidden" name="hero_login_ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
<table class="t_view">
<colgroup>
<col width="150">
<col width="*">
</colgroup>
<tbody>
<tr>
	<th>운영자 ID</th>
	<td><input style="width:100px" name="hero_id" value="<?=$list['hero_id'];?>" type="text" <?if(!strcmp($_GET['type'], 'modify')){echo ' readonly';}else{echo '';}?>></td>
</tr>
<tr>
	<th>운영자 비밀번호</th>
	<td><input style="width:150px;" name="hero_pw" value="" type="password"></td>
</tr>
<tr>
	<th>운영자 성명</th>
	<td><input style="width:100px;" name="hero_name" value="<?=$list['hero_name'];?>" type="text"></td>
</tr>
<tr>
	<th>운영자 닉네임</th>
	<td><input style="width:100px;" name="hero_nick" value="<?=$list['hero_nick'];?>" type="text"></td>
</tr>
<tr>
	<th>운영자 생년월일</th>
	<td><input style="width:100px;" name="hero_jumin" value="<?=$list['hero_jumin'];?>" type="text"> 예)19890820</td>
</tr>
<tr>
	<th>운영자 권한</th>
	<td><select name="hero_level" id="hero_level" style="height:26px;">
			<?
				$level_sql = 'select * from level where hero_level<=\''.$_SESSION['temp_level'].'\' and hero_use=\'0\' order by hero_level asc;';//desc
				$out_level_sql = sql($level_sql);
				while($level_list = @mysql_fetch_assoc($out_level_sql)){ ?>
				<option value="<?=$level_list['hero_level']?>" <?if(!strcmp($level_list['hero_level'], $list['hero_level'])){echo ' selected';}else{echo '';}?>><?=$level_list['hero_name'];?></option>
			<?
				}
			?>
        </select>
	</td>
</tr>
<tr>
	<th>연락처</th>
	<td><input style="width:100px" name="hero_hp1" value="<?=$hp_data['0'];?>" size="3" maxlength="3" value="" type="text">-<input style="width:100px" name="hero_hp2" value="<?=$hp_data['1'];?>" required="yes" size="4" maxlength="4" message="연락처2" is_num="yes" value="" type="text">-<input style="width:100px" name="hero_hp3" value="<?=$hp_data['2'];?>" required="yes" size="4" maxlength="4" message="연락처3" is_num="yes" value="" type="text"></td>
</tr>
<tr>
	<th>이메일</th>
	<td>
		<input style="width:120px;" name="email1" value="<?=$mail_data['0'];?>" type="text">&nbsp;
		@&nbsp;<input style="width:120px;" name="email2" value="<?=$mail_data['1'];?>" type="text"> 
               <select name="email_select" id="email_select" onchange="javascript:emailChg();">
                                <option value="">직접입력</option>
                                <option value="paran.com">paran.com</option>
                                <option value="chollian.net">chollian.net</option>
                                <option value="empal.com">empal.com</option>
                                <option value="freechal.com">freechal.com</option>
                                <option value="hotmail.com">hotmail.com</option>
                                <option value="lycos.co.kr">lycos.co.kr</option>
                                <option value="korea.com">korea.com</option>
                                <option value="nate.com">nate.com</option>
                                <option value="naver.com">naver.com</option>
                                <option value="netian.com">netian.com</option>
                                <option value="unitel.co.kr">unitel.co.kr</option>
                                <option value="yahoo.co.kr">yahoo.co.kr</option>
                                <option value="hanmail.net">hanmail.net</option>
                                <option value="daum.net">daum.net</option>
				</select>
	</td>
</tr>
</tbody>
</table>
</form>
<div class="btnGroup">
	<div class="l">
		 <a href="javascript:;" onClick="fnList()" class="btnList">목록</a>
	</div>
	<div class="r">
		<? if($list["hero_idx"]) {?>
			<a href="javascript:form_next.submit();" class="btnAdd">수정</a>
		<? } else { ?>
			<a href="javascript:form_next.submit();" class="btnAdd">등록</a>
		<? } ?>
	</div>
</div>
<script>
$(document).ready(function(){

	fnEdit = function(no){
		location.href = "<?=url('PATH_HOME||board||'.$_GET['board'].'||&view=01_write&idx='.$_GET['idx'].'&type=modify&next_idx='.$list['hero_idx']);?>";
  	}
	
	fnList = function() {
		location.href = "./index.php?board=<?=$_GET['board']?>&idx=<?=$_GET['idx']?>";
	}
})
</script>