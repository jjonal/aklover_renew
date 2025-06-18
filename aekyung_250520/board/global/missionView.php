<?
if(!defined('_HEROBOARD_'))exit;

if(!$_SESSION["global_code"]) {
	location("/main/index.php?board=group_04_30&view=noticeList");
	exit;
}

$search = "";
$temp_search = "";
if($_SESSION["global_admin_yn"] != "Y") {
	$temp_search .= " AND hero_start_date <= DATE_FORMAT(NOW(),'%Y-%m-%d') ";
	$temp_search .= " AND hero_country = '".$_SESSION["global_country"]."' ";
}

$sql  = " SELECT hero_idx, hero_thumb , hero_title, hero_title_02, hero_product  ";
$sql .= " , hero_start_date, hero_end_date, hero_command, hero_media, hero_required ";
$sql .= " , hero_tag , hero_tag_sub, hero_guide, hero_help, guide_ori_file1  ";
$sql .= " , guide_file1, guide_ori_file2, guide_file2 ";
$sql .= " FROM global_mission ";
$sql .= " WHERE hero_use_yn = 'Y' AND hero_idx ='".$_GET["hero_idx"]."' ".$temp_search;
$res = sql($sql, "on");
$view = mysql_fetch_assoc($res);

$start_date = substr($view["hero_start_date"],5,2)."��".substr($view["hero_start_date"],8,2)."��";
$end_date = substr($view["hero_end_date"],5,2)."��".substr($view["hero_end_date"],8,2)."��";

if($view['hero_command'] == "&lt;br /&gt;") {
	$command = "";
} else {
	//���� ��
	$command = htmlspecialchars_decode($view['hero_command']);
	$command = str_replace("&#160;","",$command);

	//20170512 ü��ܽ�û(ü��ܸ� ����)
	$hero_media = htmlspecialchars_decode($view['hero_media']);
	$hero_media = str_replace("&#160;","",$hero_media);
}
?>
<form name="searchForm" id="searchForm" method="GET">
<? foreach($_GET as $key=>$val) {?>
<input type="hidden" name="<?=$key?>" value="<?=$val?>" />
<? } ?>
</form>
<div class="contents_area">
	<div class="page_title">
		<div>�������� �̼�</div>
		<ul class="nav">
			<li><img src="/image/common/icon_nav_home.gif" alt="home" /></li>
			<li>&gt;</li>
			<li>�۷ι� Ŭ��</li>
			<li>&gt;</li>
			<li class="current">�������� �̼�</li>
		</ul>
	</div>
	<div class="contents">
		<div id="content_wrap">
			<div class="content_img_title">
				<div class="content_img">
					<img src="<?=$view["hero_thumb"]?>">
				</div>
				<div class="content_title">
					<p class="top_title"><?=$view['hero_title']?></p>
					<p class="top_title2"><?=$view['hero_title_02']?></p>
					<table>
					<tbody>
					<tr>
						<th>�̼ǱⰣ</th>
						<td><?=$start_date?> ~ <?=$end_date?></td>
					</tr>
					<tr>
						<th>�̼���ǰ</th>
						<td><?=$view['hero_product']?></td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
			
			<div class="clear"></div>
			
			<ul class="tabArea">
				<li><a href="#" class="on">��ǰ�Ұ�</a></li>
				<li><a href="#">�ȳ�/���� ���</a></li>
				<li><a href="#">�̼� ���̵�</a></li>
			</ul>
			
			<div class="content_guide">
				<table>
				<tbody>
				
				<? if($view['guide_ori_file1'] || $view['guide_ori_file2']) { ?>
		        <tr class="tabBtnArea3">
					<th>�̼� ���̵����</th>
		        </tr>
       			<tr class="tabBtnArea3">
		            <td>
		                <? if($view['guide_ori_file1']) { ?>
			            	<a href="/freebest/auth_download.php?hero_idx=<?=$view["hero_idx"]?>&type=globalMission&column=guide1&download=<?=$view['guide_ori_file1']?>" class="download_btn">
								���̵����(1) �ٿ�ε� ��
			                </a>
		                <? } ?>
		               
		                <? if($view['guide_ori_file2']) { ?>
			                <a href="/freebest/auth_download.php?hero_idx=<?=$view["hero_idx"]?>&type=globalMission&column=guide2&download=<?=$view['guide_ori_file2']?>" class="download_btn">	
	            				���̵����(2) �ٿ�ε� ��
			                </a>
		                <? } ?>
		            </td>
		        </tr>
		        <? } ?>
				<? if($view["hero_required"]) {?>
				<tr class="tabBtnArea3">
					<th>�ʼ� �̼�</th>
				</tr>
				<tr class="tabBtnArea3">
           			<td><?=nl2br($view["hero_required"])?></td>
      			</tr>
      			<? } ?>
      			<? if($view['hero_help']){ ?>
      			<tr class="tabBtnArea3">
		            <th>������ ���̵�</th>
		        </tr>
		        <tr class="tabBtnArea3">
          	  		<td><?=str_replace("\n","<br>",$view['hero_help']);?></td>
       			</tr>
      			<? } ?>
      			<? if($view['hero_tag']){ ?>
      			<tr class="tabBtnArea3">
		            <th>�ʼ� Ű����</th>
		        </tr>
		        <tr class="tabBtnArea3">
		            <td><?=$view['hero_tag']?></td>
		        </tr>
		        <? } ?>
		        <? if($view['hero_tag_sub']){ ?>
      			<tr class="tabBtnArea3">
		            <th>���� Ű����</th>
		        </tr>
		        <tr class="tabBtnArea3">
		            <td><?=$view['hero_tag_sub']?></td>
		        </tr>
		        <? } ?>
		        <tr class="tabBtnArea2">
            		<th>�̼� �ȳ�</th>
        		</tr>
        		<tr class="tabBtnArea2">
            		<td><?=htmlspecialchars_decode($view['hero_guide'])?></td>
        		</tr>
        		<tr class="tabBtnArea2">
            		<th>�̼� �������</th>
        		</tr>
        		<tr class="tabBtnArea2">
		            <td>
		                <?=$hero_media;?>
		            </td>  
		        </tr>
				<tr class="tabBtnArea1">
					<th>��ǰ�Ұ�</th>
				</tr>
				</tbody>
				</table>
				
				<div class="spm_img notice_bottom tabBtnArea1">
					<?=htmlspecialchars_decode($command);?>
				</div>
			</div>
		</div>
		<div class="content_btn_div2" style="text-align:center; margin-left:0;">
			<a href="javascript:;" onClick="fnList()" class="content_btn">���</a>
			<? if($_SESSION["global_admin_yn"] == "Y") {?>
				<a href="javascript:;" onClick="fnEdit();" class="content_btn">����</a>
				<a href="javascript:;" onClick="fnDelete();" class="content_btn">����</a>
			<? } ?>
		</div>
	</div>
</div>
<script>
var board_type = "2";
$(document).ready(function(){
	$(".tabArea li a").on("click",function(){
		var tabNum = $(this).parent("li").index()+1;
		$(".tabArea li a").removeClass("on");
		$(this).addClass("on");
		
		$("#content_wrap .content_guide table tr").hide();
		$("#content_wrap .tabBtnArea1").hide();

		$("#content_wrap .tabBtnArea"+tabNum).show();
	})

	fnList = function() {
		$("#searchForm input[name='view']").val("missionList");
		$("#searchForm").submit();
	}

	fnEdit = function() {
		$("#searchForm input[name='view']").val("missionManageWrite");
		$("#searchForm").submit();
	}

	fnDelete = function() {
		if(confirm("�����Ͻðڽ��ϱ�?")) {
			location.href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=missionManageAction&action=drop&hero_idx=<?=$view["hero_idx"]?>";
		}
	}
})
</script>