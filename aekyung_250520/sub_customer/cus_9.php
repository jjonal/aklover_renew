<?php 
if(!defined('_HEROBOARD_'))exit;

$super_check = $_GET['super'];
$tabNum = $_GET['tabNum'];

?>
<div class="contents">

	<div style="width: 70%; margin: 0 auto;">
		<? include_once BOARD_INC_END.'method.php';?> 
	</div>

	<div style="width: 70%; margin: 0 auto;">
		<? #include_once BOARD_INC_END.'setting_method.php';?>
	</div>

    <!-- story.css -->
    <div class="introduceTab">
        <ul class="activityTab">
            <li <?=$super_check==""?"class='on'":''?> rel="tab01">AK LOVER ����</li>
            <li rel="tab02">ü���</li>
            <li rel="tab03">������/�����</li>
            <li <?=$super_check=="y"?"class='on'":''?>rel="tab04">�Ը��� �̺�Ʈ</li>
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
        	<p class="titleText"><span class="titleLine">l</span>AK LOVER ���� �� SNS ��� ���</p>
            
            <p class="titleText3"><span class="numberCircle">1</span>AK LOVER Ȩ������ ���� > [ȸ������] ��ư Ŭ���Ͽ� ���� ����</p>
            <img style="margin-top:10px;" src="../image2/intro/activity/home_guide_tab01_01.jpg" alt="ȸ�������̹���"/>
            
            <p class="titleText3" style="margin-top:70px;"><span class="numberCircle">2</span>�α��� > ���������� > ȸ������ ����</p>
            <font class="mgl10" color="red">*�߰� ���� ���� �� AK LOVER 30 ����Ʈ ����</font>
            <img style="margin-top:10px;" src="../image2/intro/activity/home_guide_tab01_02.jpg" alt="�α����̹���"/>
      	</div>
      	
        
        <div id="tab02" class="tab_content">
            <p class="titleText"><span class="titleLine">l</span>AK LOVER ü���</p>
            
            <font class="mgl10">*�ְ��� �پ��� ��ǰ�� ��/���������� ���� ���� ü���� �� �ֽ��ϴ�.</font>
            
            <p class="titleText3" style="margin-top:30px;"><span class="numberCircle">1</span>ü��� ����</p>
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
            	<div class="list mgt40">
            		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience3.jpg"></div>
            		<div class="text_area">
            			<p class="title">ǰ��, FGI/FGD, HUT</p>
            			<p class="text text_one">- AK LOVER���� �����ִ� ǰ�� ��ǰ ��� �� ������ �����ϴ� ü���</p>
            			<p class="txt_emphasis">* ǰ�� ��ǰ�� ���� �ܺ� ���� �� SNS ���� ���ε尡 �Ұ��մϴ�.</p>
            		</div>    
            	</div>
            	<div class="list mgt40">
            		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience4.jpg"></div>
            		<div class="text_area">
            			<p class="title">��������</p>
            			<p class="text text_one">- ������ �¶��� ���� ���� ����</p>
            			<p class="txt_emphasis">* ǰ�� �� �������� ���� URL�� īī���� �� ���ڷ� �߼� �˴ϴ�.</p>
            		</div>    
            	</div>
            </div>
            
            <p class="titleText3" style="margin-top:70px;"><span class="numberCircle">2</span>�ְ� �귣��</p>
            <img style="margin-top:10px;" src="../image2/intro/activity/home_guide_tab02_01.jpg" alt="�ְ�귣���̹���"/>
        </div>
        
        
        <div id="tab03" class="tab_content">
        	<p class="titleText"><span class="titleLine">l</span>������</p>
            <font class="mgl10">*AK LOVER ȸ���е��� �ϻ�, ü���, Ȱ�� ���� �� �پ��� �̾߱⸦ ������ ����</font>
            <img style="margin-top:10px;" src="../image2/intro/activity/home_guide_tab03_01.jpg" alt="�������̹���"/>
            
            <p class="titleText" style="margin-top:70px;"><span class="titleLine">l</span>�����</p>
            <font class="mgl10">*SNS ����� ����� �پ��� ü��� �ı� �ۼ� ������ ��� �� �ִ� ����</font>
            <img style="margin-top:10px;" src="../image2/intro/activity/home_guide_tab03_02.jpg" alt="������̹���"/>
        </div>
        
        
        <div id="tab04" class="tab_content">
	        <p class="titleText" style="margin-bottom:20px;"><span class="titleLine">l</span>AK LOVER �Ը��� �̺�Ʈ</p>
            <font class="mgl10">*���� �����Ͽ� ����Ǵ� ���� ������ �̺�Ʈ</font>
            
            <p class="titleText3" style="margin-top:30px;"><span class="numberCircle">1</span>AK LOVER ���� �ν�Ÿ�׷� �ȷο� <a href="https://www.instagram.com/aekyunglover/" style="color:blue">(@aekyunglover)</a></p>
            <img style="margin-top:10px;" src="../image2/intro/activity/home_guide_tab04_01.jpg" alt="ȸ�������̹���"/>
            
            <p class="titleText3" style="margin-top:70px;"><span class="numberCircle">2</span>���� �����Ͽ� ���ε� �Ǵ� �̺�Ʈ Ȯ�� �� ��۷� ���� �ۼ�</p>
            <font class="mgl10" color="red">(+ ģ�� �±�, ���丮 �� �ǵ忡 ���ε�)</font>
            <img style="margin-top:10px;" src="../image2/intro/activity/home_guide_tab04_02.jpg" alt="�α����̹���"/>
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

