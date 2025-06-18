<?
$table = 'board';
$hero_board = 'cus_3';
$hero_point = '4';
if(!strcmp($_GET['type'], 'edit')){
	//hero_file(AKLOVER_PHOTO_INC_END,AKLOVER_PHOTO_END);
    $post_count = @count($_POST['hero_idx']);
    for($i=0;$i<$post_count;$i++){
    	
        reset($_POST);
        unset($sql_one_update);
        $idx = $_POST['hero_idx'][$i];
        
        $hero_id = $_POST['hero_id'];
        $hero_hp = $_POST['hero_hp'];
        $alrimTalk = $_POST['alrimTalk'][$i];
        $admin_nick = $_SESSION["temp_nick"];
        
        //unset($_POST['hero_hp'][$i]);
        
        $data_i = '1';
        $count = @count($_POST);
        if(!strcmp($_POST['hero_10'][$i], '')){
            $sql_one_update .= 'hero_review_day=null, ';
        }else{
            $sql_one_update .= 'hero_review_day=\''.date('Y-m-d H:i:s').'\', ';
        }
        
        if($_POST["alrimTalk"]) {
        	$count = $count-2;
        } else{
        	$count = $count-1;
        }
        
        while(list($post_key, $post_val) = each($_POST)){

        	if($post_key != "hero_hp" && $post_key != "alrimTalk") {
				if(!strcmp($post_key, 'hero_id')){
					
				    $check_sql = "select ifnull(hero_10,'NOT REGISTERED') as hero_10 from ".$table." where hero_idx='".$idx."'";
					sql($check_sql);
					$check_list = @mysql_fetch_assoc($out_sql);
					if(!strcmp($check_list["hero_10"], 'NOT REGISTERED')){//최초 등록 시				
						//답변 쪽지 발송 쿼리
						$mail_content = "1:1 문의 건에 대한 답변이 등록되었습니다.\r\n자세한 내용은 고객센터 > 1:1문의 에서 확인 바랍니다.\r\n";
						$mail_content .= "<a href=\"".DOMAIN."/main/index.php?board=cus_3&page=1&view=view_new&idx=".$idx."\">".DOMAIN."/main/index.php?board=cus_3&page=1&view=view_new&idx=".$idx."</a>";
						$mail_sql = "INSERT INTO mail (hero_code, hero_table, hero_today, hero_name, hero_nick, hero_user, hero_title, hero_command,hero_use)";
						$mail_sql .= " VALUES ";
						$mail_sql .= "('".$_SESSION['temp_code']."', 'mail', SYSDATE(), '".$_SESSION['temp_name']."', '".$_SESSION['temp_name']."', '".$post_val."', '1:1 문의 건에 대한 답변이 등록되었습니다.', '".$mail_content."',0)";
						$msg = "답변 알림 쪽지가 발송 되었습니다.\\r\\n";
						mysql_query($mail_sql);
					}
	                $data_i++;
	                continue;
	            }
	            if(!strcmp($post_key, 'hero_idx')){
	                $data_i++;
	                continue;
	            }
	            if(!strcmp($count, $data_i)){
	                $comma = '';
	            } else {
	                $comma = ', ';
	            }
	            
	            $sql_one_update .= $post_key.'=\''.$_POST[$post_key][$i].'\''.$comma;
	       		$data_i++;
        	}
        }
        
        $sql = 'UPDATE '.$table.' SET '.$sql_one_update.' WHERE hero_idx = \''.$idx.'\';'.PHP_EOL;
        mysql_query($sql);
        
$alrim_msg = "AK LOVER 관리자 ".$admin_nick."로부터 쪽지 도착!

AK LOVER 고객센터 1:1 문의 건에 대한 답변이 등록되었습니다.
자세한 내용은 고객센터 > 1:1 문의에서 확인 바랍니다.";
        
        if($alrimTalk=="Y") {
        	$subject = "관리자1:1문의".$idx;
        	adminSendAlrimTalk($alrim_msg,$hero_hp,"10008",$subject,$hero_id);
        }
    }
    msg($msg.'답변이 등록/수정 되었습니다.','location.href="'.PATH_HOME.'?'.get('type','').'"');
    exit;
}else if(!strcmp($_GET['type'], 'drop')){
    $sql = 'select * from '.$table.' where hero_idx=\''.$_GET['hero_idx'].'\';';//desc//asc
    sql($sql);
    $drop_list                             = @mysql_fetch_assoc($out_sql);
    if(!strcmp($drop_list['hero_main'], '')){
        $sql = 'DELETE FROM '.$table.' WHERE hero_idx = \''.$_GET['hero_idx'].'\';';
    }else{
        $img_two = @explode('/', $drop_list['hero_main']);
        $img_count = @sizeof($img_two)-1;
        $last_img = $img_two[$img_count];
        @unlink(AKLOVER_PHOTO_INC_END.$last_img);
        $sql = 'DELETE FROM '.$table.' WHERE hero_idx = \''.$_GET['hero_idx'].'\';';
    }
    sql($sql);
    msg('삭제 되었습니다.','location.href="'.PATH_HOME.'?'.get('type||hero_idx','').'"');
    exit;
}

$search = "";
//답변유무
if($_GET['order'] == "Y"){
	$search .= " AND (b.hero_review_day IS NOT NULL || b.hero_review_day != '') ";
} else if($_GET['order'] == "N"){
	$search .= " AND b.hero_review_day IS NULL ";
}
//카테고리
if($_GET['gubun']){
	$search .= " AND b.gubun = '".$_GET['gubun']."' ";	
}
//검색어
if($_GET["kewyword"]){
    if($_GET['select'] == "hero_all"){ //성명+닉네임
		$search .= " AND (m.hero_name LIKE '%".$_GET['kewyword']."%' or m.hero_nick LIKE '%".$_GET['kewyword']."%') ";
	} else if($_GET['select']=="hero_command") { //답변
		$search .= " AND (b.hero_command LIKE '%".$_GET['kewyword']."' or b.hero_10 like '%".$_GET['kewyword']."%') ";
	} else if ($_GET['select']=="hero_title"){ //질문
        $search .= " AND b.hero_title LIKE '%".$_GET['kewyword']."%' ";
    }
    else {
		$search .= " AND m.".$_GET['select']." LIKE '%".$_GET['kewyword']."%' ";
	}
}
//총 건수
$total_sql  = " SELECT count(*) cnt ";
$total_sql .= " FROM board b ";
$total_sql .= " LEFT JOIN member m ON b.hero_code = m.hero_code ";
$total_sql .= " LEFT JOIN level l ON l.hero_level = m.hero_level ";
$total_sql .= " WHERE b.hero_table='".$hero_board."' ".$search;

sql($total_sql);
$out_res = mysql_fetch_assoc($out_sql);
$total_data = $out_res["cnt"];

$i=$total_data;

$list_page=10;
$page_per_list=10;

if(!strcmp($_GET['page'], ''))		$page = '1';
else								$page = $_GET['page'];

$i = $i-($page-1)*$list_page;

$start = ($page-1)*$list_page;
$next_path=get("page");

$sql  = " SELECT b.hero_idx, b.hero_title, b.hero_use, b.hero_board_one, b.hero_board_two ";
$sql .= " , b.hero_today, b.hero_10, b.hero_command , b.hero_review_day, b.gubun ";
$sql .= " , m.hero_hp, m.hero_id , m.hero_address_01, m.hero_address_02, m.hero_address_03, m.hero_name, m.hero_nick ";
$sql .= " , l.hero_name AS level_name ";
$sql .= " FROM board b ";
$sql .= " LEFT JOIN member m ON b.hero_code = m.hero_code ";
$sql .= " LEFT JOIN level l ON l.hero_level = m.hero_level ";
$sql .= " WHERE b.hero_table='".$hero_board."' ".$search." ORDER BY b.hero_today DESC LIMIT ".$start.",".$list_page;
$list_res = sql($sql);
//echo $sql;
$gubun_arr = array("1"=>"체험단 문의","2"=>"체험단 후기수정","3"=>"홈페이지 문의","4"=>"기타");
?>
<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
<input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
<input type="hidden" name="board" value="<?=$_GET["board"]?>" />
<table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>답변유무</th>
		<td>
			<input type="radio" name="order" id="order_all" value="" <?=!$_GET["order"] ? "checked":""?> /><label for="order_all">전체</label>
			<input type="radio" name="order" id="order_Y" value="Y" <?=$_GET["order"]=="Y" ? "checked":""?>/><label for="order_Y">답변</label>
			<input type="radio" name="order" id="order_N" value="N" <?=$_GET["order"]=="N" ? "checked":""?>/><label for="order_N">미답변</label>
		</td>
	</tr>
	<tr>
		<th>카테고리</th>
		<td>
			<input type="radio" name="gubun" id="gubun_all" value="" <?=!$_GET["gubun"] ? "checked":""?> /><label for="gubun_all">전체</label>
			<input type="radio" name="gubun" id="gubun_1" value="1" <?=$_GET["gubun"]=="1" ? "checked":""?>/><label for="gubun_1">체험단 문의</label>
			<input type="radio" name="gubun" id="gubun_2" value="2" <?=$_GET["gubun"]=="2" ? "checked":""?>/><label for="gubun_2">체험단 후기수정</label>
			<input type="radio" name="gubun" id="gubun_3" value="3" <?=$_GET["gubun"]=="3" ? "checked":""?>/><label for="gubun_3">홈페이지 문의</label>
			<input type="radio" name="gubun" id="gubun_4" value="4" <?=$_GET["gubun"]=="4" ? "checked":""?>/><label for="gubun_4">기타</label>
		</td>
	</tr>
	<tr>
		<th>검색어</th>
		<td>
			 <select name="select">
             	<option value="hero_nick"<?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>닉네임</option>
				<option value="hero_name"<?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>성명</option>
				<option value="hero_title"<?if(!strcmp($_REQUEST['select'], 'hero_title')){echo ' selected';}else{echo '';}?>>질문</option>
				<option value="hero_command"<?if(!strcmp($_REQUEST['select'], 'hero_command')){echo ' selected';}else{echo '';}?>>답변</option>
			  	<option value="hero_all"<?if(!strcmp($_REQUEST['select'], 'hero_all')){echo ' selected';}else{echo '';}?>>성명+닉네임</option>
			</select>
	    	<input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];;?>" class="kewyword">		
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">검색</a>
</div>
</form>

<div class="listExplainWrap mgb10">
	<label>총 </label> : <strong><?=number_format($total_data)?></strong>건
</div>

<table class="t_list">
<thead>
<tr>
	<th width="3%">NO</th>
	<th width="5%">카테고리</th>
	<th width="17%">질문자</th>
	<th width="25%">질문</th>
	<th width="25%">답변</th>
	<th width="7%">설정</th>
</tr>
</thead>
<?
if($total_data > 0) {
	while($list = @mysql_fetch_assoc($out_sql)){
?>
<form name="form_next<?=$i?>" id="form_next<?=$i?>" action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post" enctype="multipart/form-data"> 
<input type="hidden" name="hero_idx[]" value="<?=$list['hero_idx']?>">
<input type="hidden" name="hero_ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
<input type="hidden" name="hero_id" value="<?=$list['hero_id']?>">
<input type="hidden" name="hero_hp" value="<?=$list['hero_hp']?>">
<tr>
	<td><?=$i?></td>
	<td><?=$gubun_arr[$list['gubun']]?></td>
    <td class="title">
		이름 : <?=$list['hero_name']?><br>
        닉네임 : <font color="red"><?=$list['hero_nick']?></font><br>
		아이디 : <?=$list['hero_id']?><br>
        연락처 : <?=$list['hero_hp']?><br><br>
        주소 : <?=$list['hero_address_01']?><br>
        <?=$list['hero_address_02']?><br>
		<?=$list['hero_address_03']?><br><br>
        레벨 : <?=$list['level_name']?><br><br>
		<!-- 24.08.20 musign href경로 변경 http://aklover.co.kr 제거 -->
        첨부파일 : <a href="/freebest/download.php?hero=<?=$list['hero_board_one']?>&download=<?=$list['hero_board_two']?>" ><?=$list['hero_board_two'];?></a>
	</td>
	<td class="question"> 
		<div style="position:relative;">
			<? if(substr($list['hero_today'],0,13)>='2015-03-13 15'){?>
				작성일 : <font color="red"><?=$list['hero_today']?></font><br>
	    	<? } ?>
	            제목 : <font color="red"><?=$list['hero_title']?></font><br>
	       <?=htmlspecialchars_decode($list['hero_command'])?>
       </div>
	</td>
    <td class="title">
    	답변일: <font color="red"><?=$list['hero_review_day']?></font><br>
    	<textarea name="hero_10[]" class="textarea" style="height:200px; margin-top:5px;"><?=$list['hero_10']?></textarea>
    </td>
    <td>
		<div style="margin:0 0 20px 0;">
			<input type="checkbox" name="alrimTalk" id="alrimTalk<?=$i?>" value="Y" checked/><label for="alrimTalk<?=$i?>">알림톡 전송</label>
		</div>
		<a href="javascript:;" onClick="fnAnswer('form_next<?=$i?>','<?=$i?>')" class="btnFormFunc">답변하기</a>
		<a href="javascript:;" onClick="fnAnswerDel('<?=$list['hero_idx']?>')" class="btnForm">삭제</a>
	</td>
</tr>
</form>
<?
$i--;
}
} else {
?>
<tr>
	<td colspan="6">등록된 데이터가 없습니다.</td>
</tr>
<? } ?>
</table>

<div class="pagingWrap">
<? include_once PATH_INC_END.'page.php';?>
</div>
<script>
function fnSearch() {
	$("#searchForm").attr("action","").submit();
}

function fnAnswer(formName,i) {
	if($("#alrimTalk"+i).is(":checked")) {
		if(!confirm("알림톡 전송이 체크되어 있습니다. 답변을 전송하시겠습니까?")) {
			return;
		} 
	}

	$("#"+formName).submit();
	
}

function fnAnswerDel(hero_idx) {
	if(confirm("1:1문의 글을 삭제 하시겠습니까?")) {
		location.href = "<?=PATH_HOME.'?'.get('','type=drop')?>&hero_idx="+hero_idx
	}
}
</script>