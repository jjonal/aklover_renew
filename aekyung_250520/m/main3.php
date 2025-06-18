<head>
<meta charset="euc-kr">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>
<title>♡AK LOVER 애경 서포터즈</title>
<link href="css/main3.css" rel="stylesheet" type="text/css">
<link href="css/down_menu.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="jquery-1.7.2.min.js"></script>
</head>

<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once                                                        'mobile_head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';
#####################################################################################################################################################
?>
<script language=javascript>
function downMenu() {
    var $menu = $("#down_menu");
    if($menu.css("display") == "block"){
        $menu.slideUp(500, function(){
            $(".main_menu_btn").prop("src", "img/menu.jpg");
        });
    }else{
        $menu.slideDown(500, function(){
            $(".main_menu_btn").prop("src", "img/menu1.jpg");
        });
    }
}
</script>

<body>

<!--헤더시작-->
<?include_once "head.php";?> 
<!--헤더 종료-->
        
<img src="img/shadow.jpg" alt="" width="100%" height="4px"/>

<?
include_once "down_menu.php";
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
           <li style="width:35%"><img src="img/aklover/aklover1.jpg" alt="" width="80%"/></li>
           <li style="width:65%">
           <img src="img/aklover/aklover2.jpg" alt="" width="100%"/><br/>
           <p>애경을 사랑하고 아껴주는 분들이라면 지금 <span class="orange">AK LOVER</span>에 지원하세요!<br/>
           지원자격은 AK(애경)을 사랑한다면 누구나 지원가능 하답니다.</p>
           </li>
            
           <li style="width:100%">    
           <p style="margin-top:15px">애경의서포터즈 <span class="orange">AK LOVER</span>로 활동하게 될 일원들에게는 <span class="orange">AK LOVER</span> 만의 
           다양한 혜택과 이벤트 그리고 각종 문화활동의 기회가 주어집니다.<br/><br/> 

           지금 바로 <span class="orange">AK LOVER</span>에 지원하여, AK를 사랑하는 일원으로서 
           다양하고 특별한 체험과 이벤트를 경험해 보세요 :) <br/></p>
           </li>
       </ul> 
       <div class="clear"></div>  
</div>

<div style="width:90%; margin:auto; margin-top:30px">
<img src="img/aklover/aklover3.jpg" alt="AK LOVER 모집 대상" width="100%"/>
</div>


<div id="love2">
 <table width="100%" border="0" cellpadding="0px" cellspacing="0px">
      <tr>
           <td class="love2_left" style="width:40%; border-top:2px solid #b0b0b0">AK LOVER 모집 대상</td>
           <td class="love2_right" style="width:60%; border-top:2px solid #b0b0b0">
                <p>♥ &nbsp;애경을 사랑하는 자</p>
                <p>♥ &nbsp;20대 - 40대 여성</p>
                <p>♥ &nbsp;지역  불문, 직업 불문</p>
                <p>♥ &nbsp;개인 블로그 및 SNS 사용자</p>
            </td>
      </tr>
      
      
      <tr>
           <td class="love2_left" style="width:40%">AK LOVER 신청 방법</td>
           <td class="love2_right" style="width:60%">
                <p>♥ &nbsp;Step 1. AK LOVER 홈페이지 상단 회원가입 버튼 클릭</p>
                <p>♥ &nbsp;Step 2. 개인 정보를 입력 후 회원 가입</p>
                <p>♥ &nbsp;Step 3. 글 3개 이상 작성 시, AK LOVER로 활동하실 수 있는 
              등급으로 자동 전환 됩니다.</p>
            </td>
      </tr>
      
      
      <tr>
           <td class="love2_left" style="width:40%">AK LOVER 활동 내용</td>
           <td class="love2_right" style="width:60%">
                <p>♥ &nbsp;SNS 및 블로그 내 제품 포스팅</p>
                <p>♥ &nbsp;지인 샘플링을 통한 홍보</p>
                <p>♥ &nbsp;오프라인 행사 참여 및 포스팅</p>
            </td>
      </tr>
      
      
      <tr>
           <td class="love2_left" style="width:40%; border-bottom:2px solid #b0b0b0">활동 혜택</td>
           <td class="love2_right" style="width:60%; border-bottom:2px solid #b0b0b0">
                <p>♥ &nbsp;제품 체험 기회 제공</p>
                <p>♥ &nbsp;미션 당 우수 활동자 포상 </p>
                <p>♥ &nbsp;다양한 문화강좌 및 체험 제공</p>
                <p>♥ &nbsp;공연 관람 기회 제공</p>
                <p>♥ &nbsp;연말파티 및 선물 제공</p>
                <p>♥ &nbsp;게릴라 이벤트를 통한 선물 제공</p>
            </td>
      </tr>
</table>

</div>

   <div class="clear"></div>
<!--컨텐츠 종료-->
<?include_once "tail.php";?>