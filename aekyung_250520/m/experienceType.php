<? include_once "head.php";?> 
<link href="css/aklover.css?v=230503" rel="stylesheet" type="text/css">
<!--������ ����-->
<?
$group_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_REQUEST['board'].'\';';//desc
$out_group = @mysql_query($group_sql);
$right_list                             = @mysql_fetch_assoc($out_group);
?>
<? include_once "boardIntroduce.php"; ?>

<div style="clear:both"></div>

<div id="line"></div>
<div id="love1">
	<div class="introduceTab">
        <ul class="activityTab">
            <li class="on" rel="tab01">ü��(��ǰ/����Ʈ)</li>
            <li rel="tab02">ǰ��, FGI/FGD</li>
            <li rel="tab03">��������</li>
        </ul>
    </div>
    <script type="text/javascript" src="/js/clipboard.min.js"></script>
    <script>
    $(document).ready(function(){
		$('.tab_content').hide();
		$('.tab_content:first').show();
		
        $('.activityTab > li').click(function(){
			//�� on,off
			$('.activityTab').children('li').removeClass('on');
			$(this).addClass('on');
			
			//�� �̵�
			$('.tab_content').hide();
			var tabNum = $(this).attr('rel');
			$('#'+tabNum).fadeIn();
			
			var clipboard = new Clipboard('.btn');
			
			clipboard.on('success', function(e) {
				alert('����Ǿ����ϴ�.');
			});
			
			clipboard.on('error', function(e) {
				var result = window.prompt(" �⺻ ���� �ڵ带 �������ּ���!", "<a href='http://www.aklover.co.kr/' target='_blank'><img src='http://www.aklover.co.kr/widget.png' width='170' height='170' border='0'></a>");
			});
			
        });

        <? if($_REQUEST["selectTab"]) { ?>
       	 $('.activityTab > li').eq('<?=$_REQUEST["selectTab"]?>').click();
        <? } ?>

         

        $("#banner_clipping").on("click",function(){

        	console.log("click");
            
			var clipboard = new Clipboard('#banner_clipping');
			
			clipboard.on('success', function(e) {
				alert('����Ǿ����ϴ�.');
			});
			
			clipboard.on('error', function(e) {
				var result = window.prompt("������ ����ڵ带 ������ �ּ���!", "<a href='http://aklover.co.kr' target='_blank'><img src='http://www.aklover.co.kr/image2/banner/������ ����2.jpg'></a>");
			});
        })
    });
    </script>

    <div id="tab01" class="missionProcess tab_content">
    	<p class="titleText" style="margin-top:30px;"><span class="titleLine">l</span>����</p>
    	<div class="experienceTypeWrap">
        	<div class="list mgt30">
        		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience1.jpg"></div>
        		<div class="text_area">
        			<p class="title">��ǰ ü��</p>
        			<p class="text text_one">- AK LOVER���� ��ǰ ���� �������� ����Ǵ� ü���</p>
        			<p class="txt_emphasis" style="margin-top:5px;">* ��, ��ǰ ��ۺ�� ���� �δ� (����Ʈ ���� or ���� �� ����)</p>
        		</div>    
        		
        	</div>
        	<div class="list mgt40">
        		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience2.jpg"></div>
        		<div class="text_area">
        			<p class="title">����Ʈ ü��</p>
        			<p class="text text_one">- ü��� �� ������ ���� ���Ͽ��� <strong>���� ��÷�� ��ǰ�� ����</strong>�Ͽ� �ʼ��̼� �� �����̼� �����ϴ� ü���</p>
        			<p class="txt_emphasis" style="margin-top:5px;">* ���� ��� ȯ���� �ƴ� ��ǰ�� �� AK LOVER ����Ʈ�� ���� ����</p>
        		</div>    
        	</div>
    	</div>
    	
    	<p class="titleText" style="margin-top:30px;"><span class="titleLine">l</span>���� ���</p>
    	<ul>
            <li class="process l1"><img src="../image2/intro/activity/activityProcess1_on.png" alt="�̼������ϱ�" onclick="clickScroll(0)"/></li>
            <li class="process arrow"><img src="../image2/intro/activity/activityArrow.png"/></li>
            <li class="process l2"><img src="../image2/intro/activity/activityProcess2_on.png" alt="������û" onclick="clickScroll(1)"/></li>
            <li class="process arrow"><img src="../image2/intro/activity/activityArrow.png"/></li>
            <li class="process l3"><img src="../image2/intro/activity/activityProcess3_on.png" alt="������" onclick="clickScroll(2)"/></li>
            <li class="process arrow"><img src="../image2/intro/activity/activityArrow.png"/></li>
            <li class="process l4"><img src="../image2/intro/activity/activityProcess4_on.png" alt="������ǥ" onclick="clickScroll(3)"/></li>
        </ul>
        <script>
		function clickScroll(n){
			$('html, body').stop().animate({
				scrollTop : $('.target').eq(n).offset().top
			});
		}
		</script>
		<style>
		.imagemap{position:relative;width:device-width;}
		.area1{position:absolute; top: 0.3%; left: 29%; width: 17%; height: 2%;}
		.area2{position:absolute; top: 0.3%; left: 25.5%; width: 17%; height: 2%;}
		</style>
        <p class="target imagemap">
        	<img src="../image2/intro/activity/tab01_missionProcess01.png?v=230509" alt="�̼������ϱ�"/>
        	<a href="https://www.aklover.co.kr/sub_customer/player.php?video=mission_application" class="area1"></a>
        </p>
        <p class="target"><img src="../image2/intro/activity/tab01_missionProcess02.png" alt="������û"/></p>
        <p class="target imagemap">
        	<img src="../image2/intro/activity/tab01_missionProcess03.png" alt="������"/>
        	<a href="https://www.aklover.co.kr/sub_customer/player.php?video=mission_latter" class="area2"></a>
        </p>
        <p class="target"><img src="../image2/intro/activity/tab01_missionProcess04.png" alt="�����ǥ"/></p>
    </div>
    
    
    <div id="tab02" class="missionProcess tab_content">
    	<p class="titleText" style="margin-top:30px;"><span class="titleLine">l</span>����</p>
    	<div class="experienceTypeWrap">
        	<div class="list mgt40">
        		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience3.jpg"></div>
        		<div class="text_area">
        			<p class="title">ǰ��, FGI/FGD, HUT</p>
        			<p class="text text_one">- AK LOVER���� �����ִ� ǰ�� ��ǰ ��� �� ������ �����ϴ� ü���</p>
        			<p class="txt_emphasis" style="margin-top:5px;">* ǰ�� ��ǰ�� ���� �ܺ� ���� �� SNS ���� ���ε尡 �Ұ��մϴ�.</p>
        		</div>    
        	</div>
    	</div>
    	
    	<p class="titleText" style="margin-top:30px;"><span class="titleLine">l</span>���� ���</p>
    	<ul>
            <li class="process l1"><img src="../image2/intro/activity/activityProcess1_on.png" alt="�̼������ϱ�" onclick="clickScroll(4)"/></li>
            <li class="process arrow"><img src="../image2/intro/activity/activityArrow.png"/></li>
            <li class="process l2"><img src="../image2/intro/activity/activityProcess2_on.png" alt="������û" onclick="clickScroll(5)"/></li>
            <li class="process arrow"><img src="../image2/intro/activity/activityArrow.png"/></li>
            <li class="process l3"><img src="../image2/intro/activity/activityProcess5_on.png" alt="������" onclick="clickScroll(6)"/></li>
        </ul>
        <script>
		function clickScroll(n){
			$('html, body').stop().animate({
				scrollTop : $('.target').eq(n).offset().top
			});
		}
		</script>
		<style>
		.imagemap{position:relative;width:device-width;}
		.area1{position:absolute; top: 0.3%; left: 29%; width: 17%; height: 2%;}
		.area2{position:absolute; top: 0.3%; left: 25.5%; width: 17%; height: 2%;}
		</style>
        <p class="target imagemap">
        	<img src="../image2/intro/activity/tab02_missionProcess01.png?v=230509" alt="�̼������ϱ�"/>
        	<a href="https://www.aklover.co.kr/sub_customer/player.php?video=mission_application" class="area1"></a>
        </p>
        <p class="target"><img src="../image2/intro/activity/tab02_missionProcess02.png" alt="������û"/></p>
        <p class="target"><img src="../image2/intro/activity/tab02_missionProcess03.png" alt="�����ǥ"/></p>
    </div>
    
    
    <div id="tab03" class="missionProcess tab_content">
    	<p class="titleText" style="margin-top:30px;"><span class="titleLine">l</span>����</p>
    	<div class="experienceTypeWrap">
        	<div class="list mgt40">
        		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience4.jpg"></div>
        		<div class="text_area">
        			<p class="title">��������</p>
        			<p class="text text_one">- ������ �¶��� ���� ���� ����</p>
        			<p class="txt_emphasis" style="margin-top:5px;">* ǰ�� �� �������� ���� URL�� īī���� �� ���ڷ� �߼� �˴ϴ�.</p>
        		</div>    
        	</div>
    	</div>
    	
    	<p class="titleText" style="margin-top:30px;"><span class="titleLine">l</span>���� ���</p>
    	<ul>
            <li class="process l1"><img src="../image2/intro/activity/activityProcess6_on.png" alt="�̼������ϱ�" onclick="clickScroll(7)"/></li>
            <li class="process arrow"><img src="../image2/intro/activity/activityArrow.png"/></li>
            <li class="process l2"><img src="../image2/intro/activity/activityProcess7_on.png" alt="������û" onclick="clickScroll(8)"/></li>
        </ul>
        <script>
		function clickScroll(n){
			$('html, body').stop().animate({
				scrollTop : $('.target').eq(n).offset().top
			});
		}
		</script>
		<style>
		.imagemap{position:relative;width:device-width;}
		.area1{position:absolute; top: 0.3%; left: 29%; width: 17%; height: 2%;}
		.area2{position:absolute; top: 0.3%; left: 25.5%; width: 17%; height: 2%;}
		</style>
        <p class="target imagemap">
        	<img src="../image2/intro/activity/tab03_missionProcess01.png?v=230509" alt="�̼������ϱ�"/>
        	<a href="https://www.aklover.co.kr/sub_customer/player.php?video=mission_application" class="area1"></a>
        </p>
        <p class="target"><img src="../image2/intro/activity/tab03_missionProcess02.png" alt="������û"/></p>
    </div>
</div>        

</div>
<script>
function fnDownBanner(num) {
	if(confirm("������ ��ʸ� �ʼ��� ���� ��Ź�帳�ϴ�.")){
		location.href= "/sub_customer/downBanner.php?gubun="+num;
	}
}
</script>
<!--������ ����-->
<!--������ ����-->
<?include_once "tail.php";?>