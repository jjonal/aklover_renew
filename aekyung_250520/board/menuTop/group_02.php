<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;

######################################################################################################################################################
$today = time(date('Y-m-d'));
$week = date("w");
$week_first = $today-($week*86400); 	//이번 주의 첫날인 일요일
$week_last = $week_first+(7*86400); 	//이번 주의 마지막날인 토요일

$week_first = date("Y-m-d",$week_first);
$week_last = date("Y-m-d",$week_last);

$groups = array("group_02_02","group_03_05");
$titles = array("수다통","칭찬통");
$subTitles = array("AK LOVER 수다통","제품 및 AK LOVER 칭찬통");

######################################################################################################################################################
for($i=0;$i<count($groups);$i++){
	$error = "GROUP_02_HTML_0".$i;
	$group_select = "select * from (select * from board where hero_rec!='0' and hero_table='".$groups[$i]."' and (LEFT(hero_today,10) between '".$week_first."' and '".$week_last."' and hero_use=1) order by hero_rec desc limit 0,1) as A ";
	$group_select .= "union ";
	$group_select .= "select * from (select * from board where hero_table='".$groups[$i]."' and hero_use=1 order by hero_idx desc limit 0,15) as B ";
	//echo $group_select;
	${$group_res.$i} = new_sql($group_select,$error);
	if((string)${$group_res_0.$i}==$error){
		error_historyBack("");
		exit;
	}
}


?>
<link rel="stylesheet" type="text/css" href="/css/group_02.css">
	<div id='group_02'>
<!-- 애숙이방 -->
	<?php 
		for($i=0;$i<count($groups);$i++){
	?>	
		 	<dl class="sub<?=$i+1?>">
				<dt class="title<?=$i+1?>">
					<span class="title"><?=$titles[$i]?></span> 
					<span class="title_text"><?=$subTitles[$i]?></span>
					<span class="more" location="/main/index.php?board=<?=$groups[$i]?>"><img src="/image2/etc/more.png" width="53" height="17" alt="더보기"></span>
				</dt>
				
				<?php
					$j=0;
					while ($group_rs = mysql_fetch_assoc(${$group_res_0.$i})){
						if($j<15){
							
							$error = "GROUP_02_HTML_0".(4+$i);
							$review_select = "select count(*) from review where hero_old_idx='".$group_rs['hero_idx']."'";
							$review_res = new_sql($review_select,$error);
							if((string)$review_res==$error){
								error_historyBack("");
								exit;
							}
							$review_count = mysql_result($review_res,0,0);

							if($review_count==0)										$review_text = "";
							else														$review_text = "[".$review_count."]";
							
							if(substr($group_rs['hero_today'],0,10)==date("Y-m-d"))		$newImage = "<img src='/image/sub_new.jpg' alt='NEW'>";
							else														$newImage = "";
							
								
							
							if($j==0){
								if($group_rs['hero_rec']>0){
							?>		
								<dd class="recommend" location="<?="/main/index.php?board=".$group_rs['hero_table']."&view=view&idx=".$group_rs['hero_idx']?>">
									<img src="/image/bbs/bbs_view_recom.gif" alt="HOT">
									<div class="group_02_title_02"><?=$group_rs['hero_title']?></div><span class="comment"><?=$review_text?></span> 
								</dd>
							<?php 
								}else{
							?>
								<dd location="<?="/main/index.php?board=".$group_rs['hero_table']."&view=view&idx=".$group_rs['hero_idx']?>">
									<div class="group_02_title"><?=$group_rs['hero_title']?></div> <span class="comment"><?=$review_text?></span>
									<?=$newImage?>
								</dd>
							<?php 
								}
							}else{
							?>	
								<dd location="<?="/main/index.php?board=".$group_rs['hero_table']."&view=view&idx=".$group_rs['hero_idx']?>">
									<div class="group_02_title"><?=$group_rs['hero_title']?></div> <span class="comment"><?=$review_text?></span>
									<?=$newImage?>
								</dd>
							<?php
							} 	
							$j++;
						}
					}
				?>
	
			</dl>
	<?php 
		}
	?>
		</div>
		</div>
		<script>

			$(document).ready(function(){

				$("dd,span.more").click(function(){
					location.href=$(this).attr("location");
					return false;
				});
				
			});

		</script>
