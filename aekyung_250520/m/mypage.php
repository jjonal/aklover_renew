<?
include_once "head.php";

//�α��� �̿밡��
if (!$_SESSION ['temp_level']){
    error_location("�ش� �������� �α��� �� �̿� �����մϴ�.","/m/login.php");
    exit;
}

?>
<div id="subpage" class="mypage">
    <div class="my_top">    
        <div class="sub_title">       
            <div class="sub_wrap">  
                <div class="btn_back f_cs" onclick="goBack()"><img src="/m/img/musign/main/hd_back.webp" alt="�ڷ� ����"></div>   
                <h1 class="fz36">����������</h1>       
                <!-- <h1 class="fz36"><?=$right_list['hero_title'];?></h1>   //���� ������������ ����  -->
            </div>
        </div>  
        <? include_once "mypage_top.php";?> 
    </div>    
    <ul class="sub_menu">
        <li><a href="/m/today.php?board=mail">���� �˸��� <img src="/img/front/icon/bread.webp" alt="�˸��� �ٷΰ���"></a></li>
        <li><a href="/m/mysupport.php?board=mission">���� ü��� <img src="/img/front/icon/bread.webp" alt="ü��� �ٷΰ���"></a></li>
        <li><a href="/m/mypoint.php?board=mypoint">���� ����Ʈ <img src="/img/front/icon/bread.webp" alt="����Ʈ �ٷΰ���"></a></li>
        <li><a href="/m/mylist.php?board=mylist">���� �ۼ��� <img src="/img/front/icon/bread.webp" alt="�ۼ��� �ٷΰ���"></a></li>
        <!-- <li><a href="/m/today_view.php?board=group_04_03&statusSearch=&hero_idx=443487&hero_gisu=&select=hero_title&kewyword=&date-from=2024.08.29&date-to=2024-08.29">���� �ۼ��� <img src="/img/front/icon/bread.webp" alt="�ۼ��� �ٷΰ���"></a></li> -->
        <li><a href="/m/infoauth.php?board=infoauth">���� ���� ���� <img src="/img/front/icon/bread.webp" alt="�������� �ٷΰ���"></a></li>
        <!-- <li><a href="/m/today_view.php?board=group_04_03&statusSearch=&hero_idx=443487&hero_gisu=&select=hero_title&kewyword=&date-from=2024.08.29&date-to=2024-08.29">���� ���� ���� <img src="/img/front/icon/bread.webp" alt="�������� �ٷΰ���"></a></li> -->
    </ul>
</div>
<?include_once "tail.php";?>