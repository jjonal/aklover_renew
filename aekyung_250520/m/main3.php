<head>
<meta charset="euc-kr">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>
<title>��AK LOVER �ְ� ��������</title>
<link href="css/main3.css" rel="stylesheet" type="text/css">
<link href="css/down_menu.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="jquery-1.7.2.min.js"></script>
</head>

<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD����
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

<!--�������-->
<?include_once "head.php";?> 
<!--��� ����-->
        
<img src="img/shadow.jpg" alt="" width="100%" height="4px"/>

<?
include_once "down_menu.php";
/*�Ϲݹ̼�,�����̾� �̼�, Ȱ���̼�, �������� newȮ�� ����*/
    $check_day = date( "Y-m-d", time());
    $mission_sql = "select * from mission where DATE_FORMAT(hero_today_01_01,'%Y-%m-%d')<='".$check_day."' and DATE_FORMAT(hero_today_01_02,'%Y-%m-%d')>='".$check_day."' and hero_table in ('group_04_05', 'group_04_06', 'group_04_07', 'group_04_08') group by hero_table;";
    sql($mission_sql,"on");
    while($mission_list                             = @mysql_fetch_assoc($out_sql)){$new_mission_img_list .= $mission_list['hero_table']."||";}
    if(!strcmp(eregi('group_04_05',$new_mission_img_list),'1')){$new_img_mission_00 = "_new";}else{$new_img_mission_00="";}
    if(!strcmp(eregi('group_04_06',$new_mission_img_list),'1')){$new_img_mission_01 = "_new";}else{$new_img_mission_01="";}
    if(!strcmp(eregi('group_04_07',$new_mission_img_list),'1')){$new_img_mission_02 = "_new";}else{$new_img_mission_02="";}
    if(!strcmp(eregi('group_04_08',$new_mission_img_list),'1')){$new_img_mission_03 = "_new";}else{$new_img_mission_03="";}

/*�����ı� newȮ�� ����*/
    $board_01_sql = 'select * from board where hero_table in (\'group_04_05\', \'group_04_06\', \'group_04_07\', \'group_04_08\', \'group_04_09\') order by hero_today desc limit 0,1';
    $out_sql = @mysql_query($board_01_sql);
    $board_01_list                             = @mysql_fetch_assoc($out_sql);
    if(!strcmp(y."-".m."-".d, date( "y-m-d", strtotime($board_01_list['hero_today'])))){$new_img_mission_04 = "_new";}else{$new_img_mission_04 = "";}

/*������Ÿ newȮ�� ����*/
    $board_02_sql = 'select * from board where hero_table in (\'group_04_05\', \'group_04_06\', \'group_04_07\', \'group_04_08\', \'group_04_09\') and hero_board_three=\'1\' or  hero_table=\'group_04_10\' order by hero_today desc limit 0,1';
    $out_sql = @mysql_query($board_02_sql);
    $board_02_list                             = @mysql_fetch_assoc($out_sql);
    if(!strcmp(y."-".m."-".d, date( "y-m-d", strtotime($board_02_list['hero_today'])))){$new_img_mission_05 = "_new";}else{$new_img_mission_05 = "";}

/*�����Ϸ�,�ɹ̳���,�ֺ�9����,�̽İ���,�������� newȮ�� ����*/
    $today_sql = "select * from board where hero_today >= curdate() and hero_table in ('group_02_01', 'group_01_01', 'group_01_02', 'group_01_03', 'group_01_04') group by hero_table;";
    $out_sql = @mysql_query($today_sql);
    while($today_list                             = @mysql_fetch_assoc($out_sql)){$new_today_img_list .= $today_list['hero_table']."||";}
    if(!strcmp(eregi('group_02_01',$new_today_img_list),'1')){$new_img_view_00 = "_new";}else{$new_img_view_00="";}
    if(!strcmp(eregi('group_01_01',$new_today_img_list),'1')){$new_img_view_01 = "_new";}else{$new_img_view_01="";}
    if(!strcmp(eregi('group_01_02',$new_today_img_list),'1')){$new_img_view_02 = "_new";}else{$new_img_view_02="";}
    if(!strcmp(eregi('group_01_03',$new_today_img_list),'1')){$new_img_view_03 = "_new";}else{$new_img_view_03="";}
    if(!strcmp(eregi('group_01_04',$new_today_img_list),'1')){$new_img_view_04 = "_new";}else{$new_img_view_04="";}
?>

<!--������ ����-->        
    <div id="icon">
       <ul>
        <li><a href="<?=DOMAIN_END?>m/mission.php?board=group_04_05"><img src="img/menu_icon1<?=$new_img_mission_00?>.jpg"alt="�Ϲݹ̼�"/></a></li>
        <li><a href="<?=DOMAIN_END?>m/mission.php?board=group_04_06"><img src="img/menu_icon2<?=$new_img_mission_01?>.jpg"alt="�����̾� �̼�"/></a></li>
        <li><a href="<?=DOMAIN_END?>m/mission.php?board=group_04_07"><img src="img/menu_icon3<?=$new_img_mission_02?>.jpg"alt="Ȱ���̼�"/></a></li>
        <li><a href="<?=DOMAIN_END?>m/mission.php?board=group_04_08"><img src="img/menu_icon4<?=$new_img_mission_03?>.jpg"alt="��������"/></a></li>

        <li><a href="<?=DOMAIN_END?>m/board_01.php?board=group_04_09"><img src="img/menu_icon5<?=$new_img_mission_04?>.jpg"alt="�����ı�"/></a></li>
        <li><a href="<?=DOMAIN_END?>m/board_02.php?board=group_04_10"><img src="img/menu_icon6<?=$new_img_mission_05?>.jpg"alt="������Ÿ"/></a></li>

        <li><a href="<?=DOMAIN_END?>m/today.php?board=group_02_01"><img src="img/menu_icon7<?=$new_img_view_00?>.jpg"alt="�����Ϸ�"/></a></li>
        <li><a href="<?=DOMAIN_END?>m/check.php?board=group_04_04"><img src="img/menu_icon8.jpg"alt="�⼮üũ"/></a></li>
        <li><a href="<?=DOMAIN_END?>m/board_00.php?board=group_01_01"><img src="img/menu_icon9<?=$new_img_view_01?>.jpg"  alt="�ɹ̳���"/></a></li>
        <li><a href="<?=DOMAIN_END?>m/board_00.php?board=group_01_02"><img src="img/menu_icon10<?=$new_img_view_02?>.jpg" alt="�ֺ�9����"/></a></li>
        <li><a href="<?=DOMAIN_END?>m/board_00.php?board=group_01_03"><img src="img/menu_icon11<?=$new_img_view_03?>.jpg" alt="�̽İ���"/></a></li>
        <li><a href="<?=DOMAIN_END?>m/board_00.php?board=group_01_04"><img src="img/menu_icon12<?=$new_img_view_04?>.jpg" alt="��������"/></a></li>
      </ul>
    <div class="clear"></div>
   </div>


   <div id="tab"  style="background-image:url(img/tab_bg1_1.jpg); background-repeat:repeat-x;">
      <ul>
      <li style="background-image:url(img/tab_bg1.jpg); background-repeat:repeat-x; width:24%"><a href="<?=DOMAIN_END?>m/main.php#tab"><p>�������� <span style="color:#584030; float:right; font-size:15px; margin-top:-2px;">|</span></p></a></li>
      <li style="background-image:url(img/tab_bg1.jpg); background-repeat:repeat-x; width:19%"><a href="<?=DOMAIN_END?>m/main1.php#tab"><p>���̽� <span style="color:#584030; float:right; font-size:15px; margin-top:-2px;">|</span></p></a></li>
      <li style="background-image:url(img/tab_bg1.jpg); background-repeat:repeat-x; width:24%"><a href="<?=DOMAIN_END?>m/main2.php#tab"><p>�����ı�</p></a></li>
      <li style="background-image:url(img/tab_bg1_1.jpg); background-repeat:repeat-x; width:31%"><a href="<?=DOMAIN_END?>m/main3.php#tab"><p style="padding-left:3px">AK LOVER��?</p></a></li>
      </ul> 
      <div class="clear"></div> 
   </div>

   <img src="img/shadow1.jpg" alt="" width="100%" height="2px"/>


<div id="love1">
       <ul>
           <li style="width:35%"><img src="img/aklover/aklover1.jpg" alt="" width="80%"/></li>
           <li style="width:65%">
           <img src="img/aklover/aklover2.jpg" alt="" width="100%"/><br/>
           <p>�ְ��� ����ϰ� �Ʋ��ִ� �е��̶�� ���� <span class="orange">AK LOVER</span>�� �����ϼ���!<br/>
           �����ڰ��� AK(�ְ�)�� ����Ѵٸ� ������ �������� �ϴ�ϴ�.</p>
           </li>
            
           <li style="width:100%">    
           <p style="margin-top:15px">�ְ��Ǽ������� <span class="orange">AK LOVER</span>�� Ȱ���ϰ� �� �Ͽ��鿡�Դ� <span class="orange">AK LOVER</span> ���� 
           �پ��� ���ð� �̺�Ʈ �׸��� ���� ��ȭȰ���� ��ȸ�� �־����ϴ�.<br/><br/> 

           ���� �ٷ� <span class="orange">AK LOVER</span>�� �����Ͽ�, AK�� ����ϴ� �Ͽ����μ� 
           �پ��ϰ� Ư���� ü��� �̺�Ʈ�� ������ ������ :) <br/></p>
           </li>
       </ul> 
       <div class="clear"></div>  
</div>

<div style="width:90%; margin:auto; margin-top:30px">
<img src="img/aklover/aklover3.jpg" alt="AK LOVER ���� ���" width="100%"/>
</div>


<div id="love2">
 <table width="100%" border="0" cellpadding="0px" cellspacing="0px">
      <tr>
           <td class="love2_left" style="width:40%; border-top:2px solid #b0b0b0">AK LOVER ���� ���</td>
           <td class="love2_right" style="width:60%; border-top:2px solid #b0b0b0">
                <p>�� &nbsp;�ְ��� ����ϴ� ��</p>
                <p>�� &nbsp;20�� - 40�� ����</p>
                <p>�� &nbsp;����  �ҹ�, ���� �ҹ�</p>
                <p>�� &nbsp;���� ��α� �� SNS �����</p>
            </td>
      </tr>
      
      
      <tr>
           <td class="love2_left" style="width:40%">AK LOVER ��û ���</td>
           <td class="love2_right" style="width:60%">
                <p>�� &nbsp;Step 1. AK LOVER Ȩ������ ��� ȸ������ ��ư Ŭ��</p>
                <p>�� &nbsp;Step 2. ���� ������ �Է� �� ȸ�� ����</p>
                <p>�� &nbsp;Step 3. �� 3�� �̻� �ۼ� ��, AK LOVER�� Ȱ���Ͻ� �� �ִ� 
              ������� �ڵ� ��ȯ �˴ϴ�.</p>
            </td>
      </tr>
      
      
      <tr>
           <td class="love2_left" style="width:40%">AK LOVER Ȱ�� ����</td>
           <td class="love2_right" style="width:60%">
                <p>�� &nbsp;SNS �� ��α� �� ��ǰ ������</p>
                <p>�� &nbsp;���� ���ø��� ���� ȫ��</p>
                <p>�� &nbsp;�������� ��� ���� �� ������</p>
            </td>
      </tr>
      
      
      <tr>
           <td class="love2_left" style="width:40%; border-bottom:2px solid #b0b0b0">Ȱ�� ����</td>
           <td class="love2_right" style="width:60%; border-bottom:2px solid #b0b0b0">
                <p>�� &nbsp;��ǰ ü�� ��ȸ ����</p>
                <p>�� &nbsp;�̼� �� ��� Ȱ���� ���� </p>
                <p>�� &nbsp;�پ��� ��ȭ���� �� ü�� ����</p>
                <p>�� &nbsp;���� ���� ��ȸ ����</p>
                <p>�� &nbsp;������Ƽ �� ���� ����</p>
                <p>�� &nbsp;�Ը��� �̺�Ʈ�� ���� ���� ����</p>
            </td>
      </tr>
</table>

</div>

   <div class="clear"></div>
<!--������ ����-->
<?include_once "tail.php";?>