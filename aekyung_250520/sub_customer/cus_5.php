<?php 
if(!defined('_HEROBOARD_'))exit;

$super_check = $_GET['super'];
$tabNum = $_GET['tabNum'];

?>
<div class="contents">
    <!-- story.css -->
    <div class="introduceTab" style="width: 550px;">
        <ul class="activityTab">
            <li <?=$super_check==""?"class='on'":''?> rel="tab01">1. ������ ����</li>
            <li rel="tab02">2. �����н�</li>
            <li rel="tab03">3. ����</li>
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
        
        <div id="tab03" class="tab_content">
        	<div class="widgetType">
           		<p class="titleText"><span class="titleLine">l</span>���� �̶�</p>
                <p class="mgl10">
                	������ ��α׿��� �� �������� ������ �ʰ� �ٷ� AK LOVER Ȩ�������� �̵��� �� �ֵ��� ���� �ٷΰ��� ������
                </p>

                <p class="titleText" style="margin-top:30px;"><span class="titleLine">l</span>���� ����</p>
                <p class="mgl10">
                	�پ��� ���ð� ��ſ��� ������ AK LOVER�� �θ� �˸��� ���� �湮�� �� �ֵ��� ������ ��α׿� AK LOVER ���� ��ġ�ϴ� ����� �˷��帳�ϴ�.
                    <br/>
                    <br/>
                    <span class="black">�⺻����</span>�� <span class="juhwang">������ �����ڵ带 ����</span>�ؼ� ����Ͻð�,<br/>
                    <span class="black">10�� �̻� Ȱ�� ȸ�� ����</span>�� Ȩ������ ���� �� <span class="juhwang">10�� �̻� ������ Ȱ���Ͻ� ȸ�� ��</span>����<br/>
                    ������ ��ư� ���� �ڵ带 ������ �߼��ص帮�� �ֽ��ϴ�.
                </p>
                
                <p class="mgl70 mgt40"><img src="../image2/intro/activity/widgetImg.png" alt="�����̹���"/></p>
                <!--<img class="widgetCopy" src="../image2/intro/activity/widgetCopy.png" alt="�ڵ� �����ϱ�"/>
                <img class="widgetText" src="../image2/intro/activity/widgetText2.png" alt="50������������"/>-->
            </div>
            
            <div class="widgetInsert">
            	<p class="titleText "><span class="titleLine">l</span>���� ��ġ ���μ���</p>
                <ul>
                	<li class="widgetProcess w1" ><img src="../image2/intro/activity/widgetProcess1_on.png" alt="�����ڵ� �����ϱ�" onclick="widgetClickScroll(0)"/></li>
                	<li class="widgetProcess w2" ><img src="../image2/intro/activity/widgetProcess2_on.png" alt="�����ڵ� �Ϸ�����" onclick="widgetClickScroll(1)"/></li>
               		<li class="widgetProcess w3" ><img src="../image2/intro/activity/widgetProcess3_on.png" alt="�����ڵ� �����ֱ�" onclick="widgetClickScroll(2)"/></li>
                	<li class="widgetProcess w4" ><img src="../image2/intro/activity/widgetProcess4_on.png" alt="�����ڵ� �Ϸ�" onclick="widgetClickScroll(3)"/></li>
            	</ul>
                <script>
				$(document).ready(function(){
					$('.widgetProcess').children('img').on("mouseover",function(){
						$(this).attr('src', $(this).attr('src').replace('on','off'));
						
					}).on("mouseleave",function(){
						$(this).attr('src', $(this).attr('src').replace('off','on'));
					});
	
				});
				function widgetClickScroll(n){
					$('html, body').stop().animate({
						scrollTop : $('.widgetTarget').eq(n).offset().top
					});
				}
				</script>
                <p class="widgetTarget"><img src="../image2/intro/activity/widgetProcess01.png" alt="�����ڵ� �����ϱ�" usemap="#Map" border="0"/>
              
                <p style="text-align:center">
                	<img src="../image2/intro/activity/widgetClip.png" alt="�ڵ庹�� �ϱ�" style="margin:20px 0 0 20px; cursor:pointer" class="btn_clip" data-clipboard-text="<a href='http://www.aklover.co.kr/' target='_blank'><img src='http://www.aklover.co.kr/widget.png' width='170' height='170' border='0'></a>"  />
				</p>
                  
                </p>
                <p class="widgetTarget"><img src="../image2/intro/activity/widgetProcess02.png" alt="�����ڵ� �Ϸ�����"/></p>
                <p class="widgetTarget"><img src="../image2/intro/activity/widgetProcess03.png" alt="�����ڵ� �����ֱ�"/></p>
                <p class="widgetTarget"><img src="../image2/intro/activity/widgetProcess04.png" alt="�����ڵ� �Ϸ�"/></p>
            </div>
            
        </div>
        
        <div id="tab02" class="tab_content">
        	<div class="superpass">
                <div>
                    <p class="titleText"><span class="titleLine">l</span>�����н���?</p>
                    <style>
						
					</style>
                    <div class="icon_area">	
                    	<div class="thumbArea">
                    		<div class="thumbnail">
	                    		<img src="/image2/superpass_marik_2.jpg?v=230511" width="190" / style="float:left; padding-right:20px;vertical-align:middle;">
	                    	</div>
	                    	<div class="text">
		                    	<p style="line-height:24px; font-size:15px; padding-top:18px;">���� �޴���  <span class="red">��ǰ ü���� ü���</span>�� �켱 ������ �� �ִ� ���� �����<br/>
		                    	<span class="red">�������н���</span>��� �ؿ�!</p>
		                    	
		                    	<p class="mgt10" style="line-height:24px; font-size:15px; padding-top:18px;">
		                    		* ����: �� �� ù ��° �α��� �� 1ȸ�� ����<br/>
									* ���� ����<br/>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- 1���� �̳��� AK LOVER �Խñ� �ۼ� ȸ��<br/>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ��α� or �ν�Ÿ�׷� � ȸ��<br/>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ���̹� ��α� or �ν�Ÿ�׷� or ����ä��(���̹�TV, Youtube, ƽ�� ��)<br/>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; � ȸ��
		                    	</p>
		                    	
		                    	<p class="mgt10" style="line-height:24px; font-size:15px; padding-top:18px;">* ��� �ȳ�</p>
		                    	
		                    	<p>
                        			- ü��� ���� �ο��� 10%�� ������ ��� ����<br/>
                            		- ��� �� ����� �� ������, �� �� ������ �� ������� ���� �����н��� �ڵ� �Ҹ�<br/><br/>
                            		
                          		  <span class="red">�� �������<br/>���� ID �Ǵ� 3���� �̳� ���Ƽ�� Ȯ�ε� ��� �����н��� �߱޵��� �ʽ��ϴ�.</span>
                        		</p>
							</div>
						</div>
                    </div>                   
                </div>
                
                <div>
                    <p class="titleText mgt40"><span class="titleLine">l</span>�����н� Ȯ�� ���</p>
                    <p><img src="../image2/intro/activity/superpassProcess03.png"/></p>
                </div>
                
                <div>
                    <p class="titleText mgt40"><span class="titleLine">l</span>�����н� ��� ���</p>
                    <p><img src="../image2/intro/activity/superpassProcess02.png"/></p>
                </div>
                
                
            </div>
        </div>
        
        <div id="tab01" class="tab_content">
	        <p class="titleText"><span class="titleLine">l</span>��α�/�ν�Ÿ�׷� �ı� ������ ����</p>
            <p class="mgl10" style="margin-bottom:50px;">
              	 �����ŷ�����ȸ ǥ�ñ���� ��ħ�� ���� ��ǰ�� �����޾� �ı⸦ �ۼ��Ͻ� ���,<br/>
				�밡�� ���θ� ǥ���ϴ� ���� ������ ��Ģ���� �ϰ� �ֽ��ϴ�. (������ ��� ������ �ƴ� ��ǰü��� ����)<br/><br/>
				���� ü��ܿ� ��÷�Ǿ� ��α�/ �ν�Ÿ�׷� �ı⸦ �ۼ��� ��, ������ ������ ��! �����ϼž� �մϴ�.<br/>
				- ��α� : ��� ���� <br/>
				- �ν�Ÿ�׷� : ���� ����<br/>
				
            </p>
            
        	<div class="bannerWrap">
            	<!--
                <p class="txt">1. ü��� ������ �� ������ ��ʸ� �巡�� �� 'Ctrl + C'�� ����<br/>&nbsp;&nbsp;&nbsp;�������ּ���!</p>
                <p class="img_pos"><img src="../image2/intro/activity/bnr_txt_2.jpg" alt="" /></p>
                <p class="mgt70 txt">2. �� �ۼ� â�� Ctrl + F�� ���� �ٿ� �ֱ� ���ּ���!<br/>&nbsp;&nbsp;&nbsp;�׷� �̷��� ��� �̹����� ���� �˴ϴ�!</p>
                <p class="img_pos"><img src="../image2/intro/activity/bnr_txt_4.jpg" alt="" /></p>
                -->
                
                <p class="titleText"><span class="titleLine">l</span>��α� ������ ��� & ����ڵ� </p>
                 
                <p class="tit">* �Ϲ� ü���</p>
                <p class="img_pos"><img src="../image2/intro/activity/aklover_gov_ban_220215.jpg" alt="" /></p>
                 
                <p class="txt mgt40">
                 	&lt;p&gt;&lt;a href=&quot;http://www.aklover.co.kr&quot; target=&quot;_blank&quot;&gt;<br />
					&lt;img src=&quot;http://www.aklover.co.kr/image2/����������.jpg&quot;&gt;&lt;/a&gt;&lt;/p&gt;
                </p>
                 
                <p style="text-align:center; margin-top:20px;">
                	<a href="javascript:;" onClick="fnDownBanner(1)" style="display:inline-block;  margin:10px 0 0 0; text-align:center; width:140px; height:40px; line-height:40px; background:#f68427; color:#fff; font-size:16px;"/>��� �ٿ�ޱ�</a>
                	<a href="javascript:;" style="display:inline-block; margin:10px 0 0 20px; text-align:center; 
                	width:140px; height:40px; line-height:40px; background:#f68427; color:#fff; 
                	font-size:16px;" class="btn_clip2" 
                	data-clipboard-text="<a href='http://www.aklover.co.kr' target='_blank'><img src='http://www.aklover.co.kr/image2/����������.jpg'></a>"/>�ڵ� ����</a>
                </p>
                
                <p class="tit mgt20">* ����Ʈ ü���</p>
                <p class="img_pos"><img src="../image2/banner_point_04_05.jpg?v=1" alt="" /></p>
                 
                <p class="txt mgt40">
                 	&lt;p&gt;&lt;a href=&quot;http://www.aklover.co.kr&quot; target=&quot;_blank&quot;&gt;<br />
					&lt;img src=&quot;http://www.aklover.co.kr/image2/banner_point_04_05.jpg&quot;&gt;&lt;/a&gt;&lt;/p&gt;
                </p>
                 
                <p style="text-align:center; margin-top:20px;">
                	<a href="javascript:;" onClick="fnDownBanner(2)" style="display:inline-block;  margin:10px 0 0 0; text-align:center; width:140px; height:40px; line-height:40px; background:#f68427; color:#fff; font-size:16px;"/>��� �ٿ�ޱ�</a>
                	<a href="javascript:;" style="display:inline-block; margin:10px 0 0 20px; text-align:center; 
                	width:140px; height:40px; line-height:40px; background:#f68427; color:#fff; 
                	font-size:16px;" class="btn_clip2" 
                	data-clipboard-text="<a href='http://www.aklover.co.kr' target='_blank'><img src='http://www.aklover.co.kr/image2/banner_point_04_05.jpg?v=1'></a>"/>�ڵ� ����</a>
                </p>
                
                 <p class="titleText mgt70"><span class="titleLine">l</span>�ν�Ÿ�׷� ������ ���� </p>
	             <p class="txt mgl10" style="margin-bottom:50px;">
					<strong>* �Ϲ� ü���</strong>: ���� �ֻ�ܿ� <span class="txt_emphasis2">��AK LOVER ��ǰ ������</span> ������ �� �ۼ����ּ���.<br/>
					<strong>* ����Ʈ ü���</strong>: ���� �ֻ�ܿ� <span class="txt_emphasis2">��AK LOVER ��ǰ�� �� ���� ���ޡ�</span> ������ �� �ۼ����ּ���
				 </p>
                
                <p class="titleText mgt70"><span class="titleLine">l</span>��α� ����Ʈ 2.0 ��� �ø��� ��</p>
                
                <p class="txt">1. ���ۼ� â ������ �ϴ� <span>'HTML'</span>�� Ŭ�����ּ���!</p>
                <p class="img_pos"><img src="../image2/intro/activity/bnr_m_img1.jpg" alt="" /></p>
                
                <p class="txt mgt70">2. ü��� ������ �� ��� �ҽ��ڵ带 �巡�� �� 'Ctrl + C'�� ���� ������ �ּ���.</p>
                <p class="txt_emphasis">�� �� ��ʴ� ���� �̹����� ü��� �� ������ �� ������, �ݵ�� �����ϴ� ü��� ���������� Ȯ�� ��Ź�帳�ϴ�.</p>
                <p class="img_pos"><img src="../image2/intro/activity/bnr_m_img2_210504.png" alt="" /></p>
                
                <p class="txt mgt70">3. ���Ͻô� ��ġ�� ��� �ҽ��ڵ带 Ctrl + V�� ���� �ٿ��ֱ� ���ּ���.</p>
                <p class="img_pos"><img src="../image2/intro/activity/bnr_m_img3.jpg" alt="" /></p>
                
                <p class="txt mgt70">4. �׸��� �ٽ� ������ �ϴ� <span>'Editor'</span> Ŭ���ϸ� ȭ�鿡 ��� �̹����� ���� �˴ϴ�.</p>
                <p class="img_pos"><img src="../image2/intro/activity/bnr_m_img4_210504.png" alt="" /></p>
                
                <p class="titleText mgt70"><span class="titleLine">l</span>��α� ����Ʈ 3.0 ��� �ø��� ��</p>
                
                <p class="txt mgt70">1. ü��� ������ �� ������ ��ʸ� �巡�� �� Ctrl + C�� ���� �������ּ���!</p>
                <p class="img_pos"><img src="../image2/intro/activity/30_ban_001_210504.jpg" alt="" /></p>
                
                <p class="txt mgt70">2. ���ۼ� â�� Ctrl + V�� ���� �ٿ��ֱ� ���ּ���! <br/> �׷� �̷��� ��� �̹����� �����˴ϴ�!</p>
                <p class="img_pos"><img src="../image2/intro/activity/30_ban_002_210504.jpg" alt="" /></p>

            </div>
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

