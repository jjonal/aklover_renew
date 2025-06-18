<?php
include_once "head.php";
#####################################################################################################################################################
?>
<link href="css/main3.css" rel="stylesheet" type="text/css">        
<img src="img/shadow.jpg" alt="" width="100%" height="4px"/>

<?

/*일반미션,프리미엄 미션, 활동미션, 선물상자 new확인 쿼리*/
    $check_day = date( "Y-m-d", time());
    $mission_sql = "select * from mission where DATE_FORMAT(hero_today_01_01,'%Y-%m-%d')<='".$check_day."' and DATE_FORMAT(hero_today_01_02,'%Y-%m-%d')>='".$check_day."' and hero_table in ('group_04_05', 'group_04_06', 'group_04_07', 'group_04_08') group by hero_table;";
    sql($mission_sql,"on");
    while($mission_list                             = @mysql_fetch_assoc($out_sql)){$new_mission_img_list .= $mission_list['hero_table']."||";}
    if(!strcmp(eregi('group_04_05',$new_mission_img_list),'1')){$new_img_mission_00 = "_new";}else{$new_img_mission_00="";}
    if(!strcmp(eregi('group_04_06',$new_mission_img_list),'1')){$new_img_mission_01 = "_new";}else{$new_img_mission_01="";}
    if(!strcmp(eregi('group_04_07',$new_mission_img_list),'1')){$new_img_mission_02 = "_new";}else{$new_img_mission_02="";}
    if(!strcmp(eregi('group_04_08',$new_mission_img_list),'1')){$new_img_mission_03 = "_new";}else{$new_img_mission_03="";}

/*생생후기 new확인 쿼리*/
    $board_01_sql = 'select * from board where hero_table in (\'group_04_05\', \'group_04_06\', \'group_04_07\', \'group_04_08\', \'group_04_09\') order by hero_today desc limit 0,1';
    $out_sql = @mysql_query($board_01_sql);
    $board_01_list                             = @mysql_fetch_assoc($out_sql);
    if(!strcmp(y."-".m."-".d, date( "y-m-d", strtotime($board_01_list['hero_today'])))){$new_img_mission_04 = "_new";}else{$new_img_mission_04 = "";}

/*러버스타 new확인 쿼리*/
    $board_02_sql = 'select * from board where hero_table in (\'group_04_05\', \'group_04_06\', \'group_04_07\', \'group_04_08\', \'group_04_09\') and hero_board_three=\'1\' or  hero_table=\'group_04_10\' order by hero_today desc limit 0,1';
    $out_sql = @mysql_query($board_02_sql);
    $board_02_list                             = @mysql_fetch_assoc($out_sql);
    if(!strcmp(y."-".m."-".d, date( "y-m-d", strtotime($board_02_list['hero_today'])))){$new_img_mission_05 = "_new";}else{$new_img_mission_05 = "";}

/*오늘하루,꽃미녀팁,주부9단팁,미식가팁,예술가팁 new확인 쿼리*/
    $today_sql = "select * from board where hero_today >= curdate() and hero_table in ('group_02_01', 'group_01_01', 'group_01_02', 'group_01_03', 'group_01_04') group by hero_table;";
    $out_sql = @mysql_query($today_sql);
    while($today_list                             = @mysql_fetch_assoc($out_sql)){$new_today_img_list .= $today_list['hero_table']."||";}
    if(!strcmp(eregi('group_02_01',$new_today_img_list),'1')){$new_img_view_00 = "_new";}else{$new_img_view_00="";}
    if(!strcmp(eregi('group_01_01',$new_today_img_list),'1')){$new_img_view_01 = "_new";}else{$new_img_view_01="";}
    if(!strcmp(eregi('group_01_02',$new_today_img_list),'1')){$new_img_view_02 = "_new";}else{$new_img_view_02="";}
    if(!strcmp(eregi('group_01_03',$new_today_img_list),'1')){$new_img_view_03 = "_new";}else{$new_img_view_03="";}
    if(!strcmp(eregi('group_01_04',$new_today_img_list),'1')){$new_img_view_04 = "_new";}else{$new_img_view_04="";}
?>

<!--컨텐츠 시작-->        
    <div id="icon">
       <ul>
        <li><a href="<?=DOMAIN_END?>m/mission.php?board=group_04_05"><img src="img/menu_icon1<?=$new_img_mission_00?>.jpg"alt="일반미션"/></a></li>
        <li><a href="<?=DOMAIN_END?>m/mission.php?board=group_04_06"><img src="img/menu_icon2<?=$new_img_mission_01?>.jpg"alt="프리미엄 미션"/></a></li>
        <li><a href="<?=DOMAIN_END?>m/mission.php?board=group_04_07"><img src="img/menu_icon3<?=$new_img_mission_02?>.jpg"alt="활동미션"/></a></li>
        <li><a href="<?=DOMAIN_END?>m/mission.php?board=group_04_08"><img src="img/menu_icon4<?=$new_img_mission_03?>.jpg"alt="선물상자"/></a></li>

        <li><a href="<?=DOMAIN_END?>m/board_01.php?board=group_04_09"><img src="img/menu_icon5<?=$new_img_mission_04?>.jpg"alt="생생후기"/></a></li>
        <li><a href="<?=DOMAIN_END?>m/board_02.php?board=group_04_10"><img src="img/menu_icon6<?=$new_img_mission_05?>.jpg"alt="러버스타"/></a></li>

        <li><a href="<?=DOMAIN_END?>m/today.php?board=group_02_01"><img src="img/menu_icon7<?=$new_img_view_00?>.jpg"alt="오늘하루"/></a></li>
        <li><a href="<?=DOMAIN_END?>m/check.php?board=group_04_04"><img src="img/menu_icon8.jpg"alt="출석체크"/></a></li>
        <li><a href="<?=DOMAIN_END?>m/board_00.php?board=group_01_01"><img src="img/menu_icon9<?=$new_img_view_01?>.jpg"  alt="꽃미녀팁"/></a></li>
        <li><a href="<?=DOMAIN_END?>m/board_00.php?board=group_01_02"><img src="img/menu_icon10<?=$new_img_view_02?>.jpg" alt="주부9단팁"/></a></li>
        <li><a href="<?=DOMAIN_END?>m/board_00.php?board=group_01_03"><img src="img/menu_icon11<?=$new_img_view_03?>.jpg" alt="미식가팁"/></a></li>
        <li><a href="<?=DOMAIN_END?>m/board_00.php?board=group_01_04"><img src="img/menu_icon12<?=$new_img_view_04?>.jpg" alt="예술가팁"/></a></li>
      </ul>
    <div class="clear"></div>
   </div>


   <div id="tab"  style="background-image:url(img/tab_bg1_1.jpg); background-repeat:repeat-x;">
      <ul>
      <li style="background-image:url(img/tab_bg1.jpg); background-repeat:repeat-x; width:24%"><a href="<?=DOMAIN_END?>m/main.php#tab"><p>공지사항 <span style="color:#584030; float:right; font-size:15px; margin-top:-2px;">|</span></p></a></li>
      <li style="background-image:url(img/tab_bg1.jpg); background-repeat:repeat-x; width:19%"><a href="<?=DOMAIN_END?>m/main1.php#tab"><p>핫이슈 <span style="color:#584030; float:right; font-size:15px; margin-top:-2px;">|</span></p></a></li>
      <li style="background-image:url(img/tab_bg1.jpg); background-repeat:repeat-x; width:24%"><a href="<?=DOMAIN_END?>m/main2.php#tab"><p>생생후기</p></a></li>
      <li style="background-image:url(img/tab_bg1_1.jpg); background-repeat:repeat-x; width:31%"><a href="<?=DOMAIN_END?>m/main3.php#tab"><p style="padding-left:3px">AK LOVER란?</p></a></li>
      </ul> 
      <div class="clear"></div> 
   </div>

   <img src="img/shadow1.jpg" alt="" width="100%" height="2px"/>


<div id="love1">
       <ul>
           <li style="width:35%">
		   
				<div class="guibox">
					<img src="../image/guide/AK_01.gif" style="width:80%"/>
					<img src="../image/guide/AK_02.gif" class="guimg" style="width:80%">
					<img src="../image/guide/AK_04.gif" usemap="#Map" class="guimg" border="0" style="width:80%"/>
					<map name="Map">
					  <area shape="rect" coords="326,197,520,248" href="http://aklover.co.kr/main/index.php?board=group_04_03&next_board=hero&page=1&view=view&idx=5642" >
					</map>
					<img src="../image/guide/AK_05.gif" class="guimg" style="width:80%"/>
					<img src="../image/guide/AK_06.gif" class="guimg" style="width:80%"/>
					<img src="../image/guide/AK_07.gif" class="guimg" style="width:80%"/>
						
					<ul>
						<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
						<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
						<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
						<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
						<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
					</ul>
					
				</div>
						

					<script type="text/javascript">
					$('.guimg').eq(0).show();
					$('.guibox ul li').click(function(e) {
						showimg($(this).index('.guibox ul li'));
					});
					function showimg(v){
						$('.guimg').hide();
						$('.guimg').eq(v).show();
					}
					</script>
		   
		   
		   
		   
		   </li>
           
       </ul> 
       <div class="clear"></div>  
</div>

<div style="width:90%; margin:auto; margin-top:30px">
<img src="img/aklover/aklover3.jpg" alt="AK LOVER 모집 대상" width="100%"/>
</div>


   <div class="clear"></div>
<!--컨텐츠 종료-->
<?include_once "tail.php";?>