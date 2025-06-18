<?
if(!defined('_HEROBOARD_'))exit;

$noAuthPage = true;

if(!$_SESSION["global_code"]) {
	$noAuthPage = false;
}

$temp_search = "";
$search = "";
if($_SESSION["global_admin_yn"] != "Y") { //임시 글
	$temp_search .= " AND b.hero_temp != '1' ";
}

if($_GET["kewyword"]) {
	$search .= " AND ".$_GET["select"]." LIKE '%".$_GET["kewyword"]."%' ";
}

if(!$_GET['page'])			$page = '1';
else						$page = $_GET['page'];

$list_page = 15;
$page_per_list = 10;
$start = ($page-1)*$list_page;

$notice_sql  = " SELECT b.hero_idx, b.hero_code, b.hero_title, b.hero_today, b.hero_temp ";
$notice_sql .= " , m.hero_nick, m.hero_level, m.hero_admin_yn ";
$notice_sql .= " ,(SELECT count(*) FROM global_reply WHERE hero_old_idx = b.hero_idx) reply_count ";
$notice_sql .= " FROM global_board b ";
$notice_sql .= " LEFT JOIN global_member m ON b.hero_code = m.hero_code ";
$notice_sql .= " WHERE b.hero_use_yn = 'Y'  AND b.hero_notice = '1' AND b.hero_table = '".$_GET["board"]."' ";
$notice_sql .= " AND b.board_code= 'notice' ".$temp_search;
$notice_sql .= " ORDER BY b.hero_idx DESC ";

$notice_res = sql($notice_sql, "on");

$total_sql  = " SELECT count(*) cnt FROM global_board b ";
$total_sql .= " WHERE b.hero_use_yn = 'Y' AND b.hero_notice != '1' AND b.hero_table = '".$_GET["board"]."' ";
$total_sql .= " AND b.board_code= 'notice' ".$temp_search." ".$search;
$total_res = sql($total_sql);
$total_rs = mysql_fetch_assoc($total_res);
$total_data = $total_rs["cnt"];

$sql  = " SELECT b.hero_idx, b.hero_code, b.hero_title, b.hero_today, b.hero_temp ";
$sql .= ", m.hero_nick, m.hero_level, m.hero_admin_yn ";
$sql .= " ,(SELECT count(*) FROM global_reply WHERE hero_old_idx = b.hero_idx) reply_count ";
$sql .= " FROM global_board b ";
$sql .= " LEFT JOIN global_member m ON b.hero_code = m.hero_code ";
$sql .= " WHERE b.hero_use_yn = 'Y'  AND b.hero_notice != '1' AND b.hero_table = '".$_GET["board"]."' ";
$sql .= " AND b.board_code= 'notice' ".$temp_search." ".$search;
$sql .= " ORDER BY b.hero_idx DESC ";
$sql .= " LIMIT ".$start.",".$list_page;

$res = sql($sql);

$num = $total_data - $start;
$next_path = get("page");
?>
<div class="contents_area">
	<div class="page_title">
		<div>공지사항</div>
		<ul class="nav">
			<li><img src="/image/common/icon_nav_home.gif" alt="home" /></li>
			<li>&gt;</li>
			<li>글로벌 클럽</li>
			<li>&gt;</li>
			<li class="current">공지사항</li>
		</ul>
	</div>
	<form name="searchForm" id="searchForm">
	<input type="hidden" name="hero_idx" value=""/>
	<input type="hidden" name="board" value="<?=$_GET["board"]?>"/>
	<input type="hidden" name="view" value="<?=$_GET["view"]?>"/>
	<div class="contents">
		<div class="listHeadTitle">
			<div class="headImg "><img src="/image2/lev_global.png"></div>
	    	<div class="headText" style="margin-top:0;">애경의 생활 제품을 직접 체험하고 다양한 소식을 전하는 Global Club 회원 여러분만을 위한 공간입니다.</div>
		</div>
		
		<div style="clear:both;"></div>
		<? if(!$noAuthPage) {?>
		<div class="authPage">
    		<div class="noAuthPage">
				<div>
           	    	<div class="img_product"><img src="/image2/focus_main_global.jpg" alt=""></div>
           	    	<div class="bg_explain">
           	    		<dl class="box_explain">
           	    			<dt><span>대상</span></dt>
           	    			<dd>글로벌 고객으로  SNS 운영자</dd>
           	    			<dt><span>지원방법</span></dt>
           	    			<dd>별도 모집 기간에 공고</dd>
           	    			<dt><span>주요활동</span></dt>
           	    			<dd style="letter-spacing:-1px;">미션을 통한 후기 작성 등</dd>
           	    			<dt><span>혜택</span></dt>
           	    			<dd>별도 공고</dd>
           	    		</dl>
           	    	</div>
           	    </div>
			</div>
        </div>
        <? } else { ?>
		
		<table border="0" cellpadding="0" cellspacing="0" class="bbs_list mgt20">
		<colgroup>
			<col width="90px">
			<col width="*">
			<col width="120px">
			<col width="70px">
		</colgroup>
		<tbody>
			<tr class="bbshead">
				<th>번호</th>
				<th>제목</th>
				<th>글쓴이</th>  
				<th>날짜</th>
	        </tr>
	        <? while($notice_list = mysql_fetch_assoc($notice_res)) { //공지 리스트
	        
				$level_icon = "";
				if($notice_list["hero_admin_yn"] == "Y") {
					$level_icon = "/image/bbs/levAdmin01.png";
				} else {
					$level_icon = "/image/bbs/lev_global.png";
				}
		        
	        	$new_img_view = ""; 
	        	if(substr($notice_list["hero_today"],0,10) == date("Y-m-d")) {
		        	$new_img_view = "<img src='".DOMAIN_END."image/sub_new.jpg' alt='new' />";
		        }
			?>
	        <tr>
	        	<td>
	        		<img src="../image/bbs/icon_notice.gif" alt="공지" />
	        	</td>
	        	<td class="tl">
	        		<a href="javascript:;" onClick="fnView('<?=$notice_list["hero_idx"]?>')">
	        			<?if($notice_list["hero_temp"]=="1"){?>[임시글]<?}?>
	        			<?=cut($notice_list["hero_title"],32)?>
	        			<? if($notice_list["reply_count"] > 0 ) {?>
	        				<strong><font color='orange'>[<?=$notice_list["reply_count"]?>]</font></strong>
	        			<? } ?>
	        			<?=$new_img_view?>
	        		</a>
				</td>
	        	<td><img src="<?=$level_icon?>" /><strong><?=$notice_list['hero_nick']?></strong></td>
	        	<td><?=substr($notice_list["hero_today"],0,10)?></td>
	        </tr>
	        <? } ?>
	        <? if($total_data > 0) {
	        	while($list = mysql_fetch_assoc($res)) {
	        		$level_icon = "";
	        		if($list["hero_admin_yn"] == "Y") {
	        			$level_icon = "/image/bbs/levAdmin01.png";
	        		} else {
	        			$level_icon = "/image/bbs/lev_global.png";
	        		}
	        		
	        		$new_img_view = "";
	        		if(substr($list["hero_today"],0,10) == date("Y-m-d")) {
	        			$new_img_view = "<img src='".DOMAIN_END."image/sub_new.jpg' alt='new' />";
	        		}
	        		
	        ?>
	        <tr>
	        	<td><?=$num?></td>
	        	<td class="tl">
	        		<a href="javascript:;" onClick="fnView('<?=$list["hero_idx"]?>')">
	        			<?if($list["hero_temp"]=="1"){?>[임시글]<?}?>
	        			<?=cut($list["hero_title"],32)?>
	        			<? if($list["reply_count"] > 0 ) {?>
	        				<strong><font color='orange'>[<?=$list["reply_count"]?>]</font></strong>
	        			<? } ?>
	        			<?=$new_img_view?>
	        		</a>
				</td>
	        	<td><img src="<?=$level_icon?>" /><strong><?=$list['hero_nick']?></strong></td>
	        	<td><?=substr($list["hero_today"],0,10)?></td>
	        </tr>
	        <? 
	        	$num--;
	        	}
        	} else {?>
        	<tr>
        		<td colspan="4">등록된 글이 없습니다.</td>
        	</tr>
        	<? } ?>
		</tbody>
		</table>
		<? if($_SESSION["global_admin_yn"] == "Y") {?>
		<div class="btngroup">
			<div class="btn_r">
				<a href="javascript:;" onClick="fnWritePage()" class="a_btn">글작성</a>
			</div>
		</div>
		<? } ?>
		
		<div class="paging">
		<? include_once BOARD_INC_END.'page.php'; ?>
		</div>
		
		<div class="searchbox">
			<select name="select" style="padding:6px 6px;width:100px;font-size:14px;">
    			<option value="b.hero_title" <?=$_GET["select"]=="b.hero_title" ? "selected":"";?>>제목</option>
			</select>
			<input name="kewyword" type="text" value="<?=$_GET["kewyword"]?>" class="kewyword" placeholder="검색어를 입력해주세요">
			<input type="button" onClick="fnSearch()" class="search_btn" value="검색">
		</div>
		</form>
		<? } ?>
	</div>
</div>
<script>
$(document).ready(function(){
	fnWritePage = function() {
		$("#searchForm input[name='view']").val("noticeWrite");
		$("#searchForm").submit();
	}

	fnView = function(hero_idx) {
		$("#searchForm input[name='hero_idx']").val(hero_idx);
		$("#searchForm input[name='view']").val("noticeView");
		$("#searchForm").submit();
	}

	fnSearch = function() {
		$("#searchForm").submit();
	}
})
</script>