<?
include_once "head.php";

//로그인 이용가능
if (!$_SESSION ['temp_level']){
    error_location("해당 페이지는 로그인 후 이용 가능합니다.","/m/login.php");
    exit;
}

?>
<div id="subpage" class="mypage">
    <div class="my_top">    
        <div class="sub_title">       
            <div class="sub_wrap">  
                <div class="btn_back f_cs" onclick="goBack()"><img src="/m/img/musign/main/hd_back.webp" alt="뒤로 가기"></div>   
                <h1 class="fz36">마이페이지</h1>       
                <!-- <h1 class="fz36"><?=$right_list['hero_title'];?></h1>   //옛날 페이지명으로 노출  -->
            </div>
        </div>  
        <? include_once "mypage_top.php";?> 
    </div>    
    <ul class="sub_menu">
        <li><a href="/m/today.php?board=mail">나의 알림함 <img src="/img/front/icon/bread.webp" alt="알림함 바로가기"></a></li>
        <li><a href="/m/mysupport.php?board=mission">나의 체험단 <img src="/img/front/icon/bread.webp" alt="체험단 바로가기"></a></li>
        <li><a href="/m/mypoint.php?board=mypoint">나의 포인트 <img src="/img/front/icon/bread.webp" alt="포인트 바로가기"></a></li>
        <li><a href="/m/mylist.php?board=mylist">나의 작성글 <img src="/img/front/icon/bread.webp" alt="작성글 바로가기"></a></li>
        <!-- <li><a href="/m/today_view.php?board=group_04_03&statusSearch=&hero_idx=443487&hero_gisu=&select=hero_title&kewyword=&date-from=2024.08.29&date-to=2024-08.29">나의 작성글 <img src="/img/front/icon/bread.webp" alt="작성글 바로가기"></a></li> -->
        <li><a href="/m/infoauth.php?board=infoauth">나의 정보 변경 <img src="/img/front/icon/bread.webp" alt="정보변경 바로가기"></a></li>
        <!-- <li><a href="/m/today_view.php?board=group_04_03&statusSearch=&hero_idx=443487&hero_gisu=&select=hero_title&kewyword=&date-from=2024.08.29&date-to=2024-08.29">나의 정보 변경 <img src="/img/front/icon/bread.webp" alt="정보변경 바로가기"></a></li> -->
    </ul>
</div>
<?include_once "tail.php";?>