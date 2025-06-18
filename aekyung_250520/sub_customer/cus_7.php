<?php
if(!defined('_HEROBOARD_'))exit;

$super_check = $_GET['super'];
$tabNum = $_GET['tabNum'];

?>
<div class="contents">
    <!-- story.css -->
    <div class="introduceTab"  style="width: 550px;">
        <ul class="activityTab">
            <li <?=$super_check==""?"class='on'":''?> rel="tab01">ü��(��ǰ/����Ʈ)</li>
            <li rel="tab02">ǰ��, FGI/FGD</li>
            <li rel="tab03">��������</li>
        </ul>
    </div>
    <script type="text/javascript" src="/js/jquery.zclip.min.js"></script>
    <script>
	var super_check = '<?=$super_check?>';
	var tabNum = '<?=$tabNum?>';
    $(document).ready(function(){
		$('.tab_content').hide();
		
		if(super_check == 'y') {
			$('#tab03').show();
		} else if(tabNum == "2"){
			$(".activityTab li").removeClass("on");
			$(".activityTab li").eq(1).addClass("on");
			$('#tab02').show();
		}else {
			$('.tab_content:first').show();
		}
		
		
        $('.activityTab > li').click(function(){
			//�� on,off
			$('.activityTab').children('li').removeClass('on');
			$(this).addClass('on');
			
			//�� �̵�
			$('.tab_content').hide();
			var tabNum = $(this).attr('rel');
			$('#'+tabNum).fadeIn();

			/*
			$('#clipping').zclip({			
				path:'/js/ZeroClipboard.swf', 
				copy:function(){
				return "<a href='http://www.aklover.co.kr/' target='_blank'><img src='http://www.aklover.co.kr/widget.png' width='170' height='170' border='0'></a>";
				}
			});
			*/
        });
		
		// top ��ư ����
		$( window ).scroll(function() {
		  if ( $(this).scrollTop() > 200 ) {
			$('.top').fadeIn();
		  }else{
			$('.top').fadeOut();
		  }
		});
		
		$('.top').on("click",function() {
		  $('html, body').animate( { scrollTop : 0 }, 400 );
		  return false;
		});

		//���� ����
		/*
		$("#banner_clipping").on("click",function() {
			$('#banner_clipping').zclip({			
				path:'/js/ZeroClipboard.swf', 
				copy:function(){
				return "<a href='http://aklover.co.kr' target='_blank'><img src='http://www.aklover.co.kr/image2/banner/������ ����2.jpg'></a>";
				}
			});
		})
		*/ 
    });
    </script>
    <div id="activity">
        <div id="tab01" class="tab_content">
        	<p class="titleText" style="margin-top:30px;"><span class="titleLine">l</span>����</p>
            
            <div class="experienceTypeWrap">
                <div class="list mgt30">
            		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience1.jpg"></div>
            		<div class="text_area">
            			<p class="title">��ǰ ü��</p>
            			<p class="text text_one">- AK LOVER���� ��ǰ ���� �������� ����Ǵ� ü���</p>
            			<p class="txt_emphasis">* ��, ��ǰ ��ۺ�� ���� �δ� (����Ʈ ���� or ���� �� ����)</p>
            		</div>    
            		
            	</div>
            	<div class="list mgt40">
            		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience2.jpg"></div>
            		<div class="text_area">
            			<p class="title">����Ʈ ü��</p>
            			<p class="text text_one">- ü��� �� ������ ���� ���Ͽ��� <strong>���� ��÷�� ��ǰ�� ����</strong>�Ͽ� �ʼ��̼� �� �����̼� �����ϴ� ü���</p>
            			<p class="txt_emphasis">* ���� ��� ȯ���� �ƴ� ��ǰ�� �� AK LOVER ����Ʈ�� ���� ����</p>
            		</div>    
            	</div>
        	</div>
        	
        	
        	<p class="titleText" style="margin-top:60px;"><span class="titleLine">l</span>���� ���</p>
        	
        	<ul>
                <li class="process l1" ><img src="../image2/intro/activity/activityProcess1_on.png" alt="�̼������ϱ�" onclick="clickScroll(0)"/></li>
                <li class="process l2" ><img src="../image2/intro/activity/activityProcess2_on.png" alt="������û" onclick="clickScroll(1)"/></li>
                <li class="process l3" ><img src="../image2/intro/activity/activityProcess3_on.png" alt="������" onclick="clickScroll(2)"/></li>
                <li class="process l4" ><img src="../image2/intro/activity/activityProcess4_on.png" alt="������ǥ" onclick="clickScroll(3)"/></li>
            </ul>
            
            <script>
            $(document).ready(function(){
				$('.process').children('img').on("mouseover",function(){
					//$('.process').children('img').attr('src', $('.process').children('img').attr('src').replace('on','off'));
					$(this).attr('src', $(this).attr('src').replace('on','off'));
				}).on("mouseleave",function(){
					$(this).attr('src', $(this).attr('src').replace('off','on'));
				});

            });
            function clickScroll(n){
				$('html, body').stop().animate({
					scrollTop : $('.target').eq(n).offset().top
				});
			}
            </script>
            <p class="target"><img src="../image2/intro/activity/tab01_missionProcess01.png?v=230509" alt="�̼������ϱ�" usemap="#map1"/></p>
            <p class="target"><img src="../image2/intro/activity/tab01_missionProcess02.png" alt="������û"/></p>
            <p class="target"><img src="../image2/intro/activity/tab01_missionProcess03.png" alt="������" usemap="#map2"/></p>
            <p class="target"><img src="../image2/intro/activity/tab01_missionProcess04.png" alt="�����ǥ"/></p>
			<map name="map1">
			  <area shape="rect" coords="126,13,233,48" href="https://www.aklover.co.kr/sub_customer/player.php?video=mission_application">
			</map>
			<map name="map2">
			  <area shape="rect" coords="109,9,217,40" href="https://www.aklover.co.kr/sub_customer/player.php?video=mission_latter">
			</map>
      	</div>
      	
        
        <div id="tab02" class="tab_content">
        	<p class="titleText" style="margin-top:30px;"><span class="titleLine">l</span>����</p>
        	
        	<div class="experienceTypeWrap">
                <div class="list mgt40">
            		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience3.jpg"></div>
            		<div class="text_area">
            			<p class="title">ǰ��, FGI/FGD, HUT</p>
            			<p class="text text_one">- AK LOVER���� �����ִ� ǰ�� ��ǰ ��� �� ������ �����ϴ� ü���</p>
            			<p class="txt_emphasis">* ǰ�� ��ǰ�� ���� �ܺ� ���� �� SNS ���� ���ε尡 �Ұ��մϴ�.</p>
            		</div>    
            	</div>
        	</div>
        	
        	<p class="titleText" style="margin-top:60px;"><span class="titleLine">l</span>���� ���</p>
        	
        	<ul>
                <li class="process l1" ><img src="../image2/intro/activity/activityProcess1_on.png" alt="�̼������ϱ�" onclick="clickScroll(4)"/></li>
                <li class="process l2" ><img src="../image2/intro/activity/activityProcess2_on.png" alt="������û" onclick="clickScroll(5)"/></li>
                <li class="process l3" ><img src="../image2/intro/activity/activityProcess5_on.png" alt="��������" onclick="clickScroll(6)"/></li>
            </ul>
            
            <p class="target"><img src="../image2/intro/activity/tab02_missionProcess01.png?v=230509" alt="�̼������ϱ�" usemap="#map1"/></p>
            <p class="target"><img src="../image2/intro/activity/tab02_missionProcess02.png" alt="������û"/></p>
            <p class="target"><img src="../image2/intro/activity/tab02_missionProcess03.png" alt="������" usemap="#map2"/></p>
			<map name="map1">
			  <area shape="rect" coords="177,6,284,31" href="https://www.aklover.co.kr/sub_customer/player.php?video=mission_application">
			</map>
			<!-- <map name="map2">
			  <area shape="rect" coords="159,9,263,34" href="/sub_customer/player.php?video=mission_latter">
			</map>-->
        </div>
        
        
        <div id="tab03" class="tab_content">
        	<p class="titleText" style="margin-top:30px;"><span class="titleLine">l</span>����</p>
        	
        	<div class="experienceTypeWrap">
                <div class="list mgt40">
            		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience4.jpg"></div>
            		<div class="text_area">
            			<p class="title">��������</p>
            			<p class="text text_one">- ������ �¶��� ���� ���� ����</p>
            			<p class="txt_emphasis">* ǰ�� �� �������� ���� URL�� īī���� �� ���ڷ� �߼� �˴ϴ�.</p>
            		</div>    
            	</div>
        	</div>
        	
        	<p class="titleText" style="margin-top:60px;"><span class="titleLine">l</span>���� ���</p>
        	<ul>
                <li class="process l1" ><img src="../image2/intro/activity/activityProcess6_on.png" alt="�̼������ϱ�" onclick="clickScroll(7)"/></li>
                <li class="process l2" ><img src="../image2/intro/activity/activityProcess7_on.png" alt="������û" onclick="clickScroll(8)"/></li>
            </ul>
        	
            <p class="target"><img src="../image2/intro/activity/tab03_missionProcess01.png" alt="�̼������ϱ�"/></p>
            <p class="target"><img src="../image2/intro/activity/tab03_missionProcess02.png" alt="������"/></p>
        </div>
        
        <a href="#" class="top">TOP &and;</a>
    </div>
</div>
</div> <!--footer-->
<script>
function fnDownBanner(num) {
	if(confirm("������ ��ʸ� �ʼ��� ���� ��Ź�帳�ϴ�.")){
		location.href= "/sub_customer/downBanner.php?gubun="+num;
	}
}

var clipboard = new Clipboard('.btn_clip');
clipboard.on('success', function(e) {
	alert("���� �Ǿ����ϴ�. ��α� � �ҽ� �ٿ��ֱ� ���ּ���~");
    console.log(e);
});
clipboard.on('error', function(e) {
    console.log(e);
});

var clipboard2 = new Clipboard('.btn_clip2');
clipboard2.on('success', function(e) {
	alert("���� �Ǿ����ϴ�. ��α� � �ҽ� �ٿ��ֱ� ���ּ���~");
    console.log(e);
});
clipboard2.on('error', function(e) {
    console.log(e);
});

</script>


