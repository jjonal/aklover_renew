<? include_once "head.php";?> 
<link href="css/aklover.css?v=1" rel="stylesheet" type="text/css">
<!--������ ����-->


<!--
<div id="title">
	<p>
		<?php if($_REQUEST["board"]=="group_04_01"){?>AK LOVER��?
		<?php }elseif($_REQUEST["board"]=="group_04_02"){?>����Ʈ/���
		<?php }elseif($_REQUEST["board"]=="group_03_01"){?>�ְ�Ұ�
		<?php }elseif($_REQUEST["board"]=="group_04_15"){?>ü��� �������
		<?php }?>
    </p>
</div>-->
<?
$group_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_REQUEST['board'].'\';';//desc
$out_group = @mysql_query($group_sql);
$right_list                             = @mysql_fetch_assoc($out_group);
?>
<? include_once "boardIntroduce.php"; ?>

<div style="clear:both"></div>


<div id="line"></div>
<div id="love1">
<?
	if($_REQUEST["board"]=="group_04_15"){
?>
	<div class="introduceTab">
        <ul class="activityTab">
            <li class="on" rel="tab04">1. ������ ����</li>
            <li rel="tab03">2. �����н�</li>
            <li rel="tab02">3. ����</li>
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
	
	<div id="tab04" class="superpassProcess tab_content">
	    <p class="titleText"><span class="titleLine">l</span>��α�/�ν�Ÿ�׷� �ı� ������ ����</p>
        <p class="mgl10 letter07">
            	 �����ŷ�����ȸ ǥ�ñ���� ��ħ�� ���� ��ǰ�� �����޾� �ı⸦ �ۼ��Ͻ� ���,
				�밡�� ���θ� ǥ���ϴ� ���� ������ ��Ģ���� �ϰ� �ֽ��ϴ�. (������ ��� ������ �ƴ� ��ǰü��� ����)<br/><br/>
				���� ü��ܿ� ��÷�Ǿ� ��α�/ �ν�Ÿ�׷� �ı⸦ �ۼ��� ��, ������ ������ ��! �����ϼž� �մϴ�.<br/>
				- ��α� : ��� ���� <br/>
				- �ν�Ÿ�׷� : ���� ����<br/>
        </p>
        
    	<div class="bannerWrap">
    		<p class="titleText mgt40"><span class="titleLine">l</span>��α� ������ ��� & ����ڵ� </p>
    		<p class="txt"><strong>* �Ϲ� ü���</strong></p>
            <p class="img"><img src="../image2/intro/activity/aklover_gov_ban_220215.jpg" alt="" /></p>
            
            <p class="txt mgt40">
                 	&lt;p&gt;&lt;a href=&quot;http://www.aklover.co.kr&quot; target=&quot;_blank&quot;&gt;<br />
					&lt;img src=&quot;http://www.aklover.co.kr/image2/����������.jpg&quot;&gt;&lt;/a&gt;&lt;/p&gt;
            </p>
            
             <p style="text-align:center; margin-bottom:40px;"><a href="javascript:;" onClick="fnDownBanner(1)" style="display:inline-block;  margin:10px 0 0 0; text-align:center; width:30%; height:30px; line-height:30px; background:#f68427; color:#fff; font-size:16px;"/>��� �ٿ�ޱ�</a>
               <a href="javascript:;"  id="banner_clipping" style="display:inline-block; margin:10px 0 0 20px; text-align:center; width:30%; height:30px; line-height:30px; background:#f68427; color:#fff; font-size:16px;" data-clipboard-text="<a href='http://www.aklover.co.kr' target='_blank'><img src='http://www.aklover.co.kr/image2/����������.jpg'></a>"/>�ڵ� ����</a>
            </p>
            
            <p class="txt"><strong>* ����Ʈ ü���</strong></p>
            <p class="img"><img src="/image2/banner_point_04_05.jpg" alt="" /></p>
            
            <p class="txt mgt40">
                 	&lt;p&gt;&lt;a href=&quot;http://www.aklover.co.kr&quot; target=&quot;_blank&quot;&gt;<br />
					&lt;img src=&quot;http://www.aklover.co.kr/image2/banner_point_04_05.jpg&quot;&gt;&lt;/a&gt;&lt;/p&gt;
            </p>
            
             <p style="text-align:center; margin-bottom:40px;"><a href="javascript:;" onClick="fnDownBanner(2)" style="display:inline-block;  margin:10px 0 0 0; text-align:center; width:30%; height:30px; line-height:30px; background:#f68427; color:#fff; font-size:16px;"/>��� �ٿ�ޱ�</a>
               <a href="javascript:;"  id="banner_clipping" style="display:inline-block; margin:10px 0 0 20px; text-align:center; width:30%; height:30px; line-height:30px; background:#f68427; color:#fff; font-size:16px;" data-clipboard-text="<a href='http://www.aklover.co.kr' target='_blank'><img src='http://www.aklover.co.kr/image2/����������.jpg'></a>"/>�ڵ� ����</a>
            </p>
            
            <p class="titleText mgt40"><span class="titleLine">l</span>�ν�Ÿ�׷� ������ ���� </p>
            <p class="txt" style="margin-bottom:40px;">
            	<strong>* �Ϲ� ü���</strong>: ���� �ֻ�ܿ� <span class="red">��AK LOVER ��ǰ ������</span> ������ �� �ۼ����ּ���.<br/>
				<strong>* ����Ʈ ü���</strong>: ���� �ֻ�ܿ� <span class="red">��AK LOVER ��ǰ�� �� ���� ���ޡ�</span> ������ �� �ۼ����ּ���
            </p>
            
        	<p class="titleText"><span class="titleLine">l</span>��α� ����Ʈ 2.0 ��� �ø��� ��</p>
            
        	<p class="txt letter07">1. ���ۼ� â ������ �ϴ� <span>'HTML'</span>�� Ŭ�����ּ���!</p>
            <p class="img"><img src="../image2/intro/activity/bnr_m_img1.jpg" alt="" /></p>
            
            <p class="txt mgt40 letter07">2. ü��� ������ �� ��� �ҽ��ڵ带 �巡�� �� 'Ctrl + C'�� ���� ������ �ּ���.</p>
            <p class="img"><img src="../image2/intro/activity/bnr_m_img2_210504.png" alt="" /></p>
            
            <p class="txt mgt40 letter07">3. ���Ͻô� ��ġ�� ��� �ҽ��ڵ带 Ctrl + V�� ���� �ٿ��ֱ� ���ּ���.</p>
            <p class="img"><img src="../image2/intro/activity/bnr_m_img3.jpg" alt="" /></p>
            
            <p class="txt mgt40 letter07">4. �׸��� �ٽ� ������ �ϴ� <span>'Editor'</span> Ŭ���ϸ� ȭ�鿡 ��� �̹����� ���� �˴ϴ�.</p>
            <p class="img"><img src="../image2/intro/activity/bnr_m_img4_210504.png" alt="" /></p>
            
            <p class="titleText mgt40"><span class="titleLine">l</span>��α� ����Ʈ 3.0 ��� �ø��� ��</p>
            
            <p class="txt mgt40 letter07">1. ü��� ������ �� ������ ��ʸ� �巡�� �� Ctrl + C�� ���� �������ּ���!</p>
            <p class="img"><img src="../image2/intro/activity/30_ban_001_210504.jpg" alt="" /></p>
           
            
            <p class="txt mgt40 letter07">2. ���ۼ� â�� Ctrl + V�� ���� �ٿ��ֱ� ���ּ���! <br/> �׷� �̷��� ��� �̹����� �����˴ϴ�!</p>
            <p class="txt_emphasis">�� �� ��ʴ� ���� �̹����� ü��� �� ������ �� ������, �ݵ�� �����ϴ� ü��� ���������� Ȯ�� ��Ź�帳�ϴ�.</p>
            <p class="img"><img src="../image2/intro/activity/30_ban_002_210504.jpg" alt="" /></p>
            
        </div>
    </div>
    
    <div id="tab02" class="tab_content">
        	<div class="widgetType">
           		<p class="titleText"><span class="titleLine">l</span>���� �̶�</p>
                <p class="mgl10 letter07">
                	������ ��α׿��� �� �������� ������ �ʰ� �ٷ� AK LOVER Ȩ�������� �̵��� �� �ֵ��� ���� �ٷΰ��� ������
                </p>
                
                <p class="titleText" style="margin-top:20px;"><span class="titleLine">l</span>���� ����</p>
                <p class="mgl10 letter07">
                	AK LOVER�� �θ� �˸��� ���� �湮�� �� �ֵ��� ������ ��α׿� AK LOVER ���� ��ġ�ϴ� ����� �˷��帳�ϴ�.<br/>
                    ����, AK LOVER�� �⺻����, ��� �������� �������� �����ؼ� �����ص����<br/><br/>
                    <span class="black">�⺻����</span>�� <span class="juhwang">������ �����ڵ带 ����</span>�ؼ� ����Ͻð�,
                    <span class="black">10�� �̻� Ȱ�� ȸ�� ����</span>�� Ȩ������ ���� �� <span class="juhwang">10�� �̻� ������ Ȱ���Ͻ� ȸ�� ��</span>����
                    ������ ��ư� ������ ���� ���� �ڵ带 �߼��� �帮�� �ֽ��ϴ�.
                </p>
                <p style="text-align:center"><img src="../image2/intro/activity/widgetImg.png" alt="�����̹���"/></p>
                <!--<img class="widgetCopy" src="../image2/intro/activity/widgetCopy.png" alt="�ڵ� �����ϱ�"/>
                <img class="widgetText" src="../image2/intro/activity/widgetText2.png" alt="50������������"/>-->
            </div>
            
            <div class="widgetInsert">
            	<p class="titleText "><span class="titleLine">l</span>���� ��ġ ���μ���</p>
                <ul>
                    <li class="widget l1"><img src="../image2/intro/activity/widgetProcess1_on.png" alt="�����ڵ� �����ϱ�" onclick="widgetClickScroll(0)"/></li>
                    <li class="widget arrow"><img src="../image2/intro/activity/activityArrow.png"/></li>
                    <li class="widget l2"><img src="../image2/intro/activity/widgetProcess2_on.png" alt="�����ڵ� �Ϸ�����" onclick="widgetClickScroll(1)"/></li>
                    <li class="widget arrow"><img src="../image2/intro/activity/activityArrow.png"/></li>
                    <li class="widget l3"><img src="../image2/intro/activity/widgetProcess3_on.png" alt="�����ڵ� �����ֱ�" onclick="widgetClickScroll(2)"/></li>
                    <li class="widget arrow"><img src="../image2/intro/activity/activityArrow.png"/></li>
                    <li class="widget l4"><img src="../image2/intro/activity/widgetProcess4_on.png" alt="�����ڵ� �Ϸ�"onclick="widgetClickScroll(3)"/></li>
                </ul>
                <script>
				function widgetClickScroll(n){
					$('html, body').stop().animate({
						scrollTop : $('.widgetTarget').eq(n).offset().top
					});
				}
				</script>
                
                <p class="widgetTarget" style="margin-top:100px;"><img src="../image2/intro/activity/widgetProcess01.png" alt="�����ڵ� �����ϱ�" usemap="#Map" border="0"/>
                <p style="text-align:center">
                	<a href="#" class="btn" style="margin:0;padding:0;" data-clipboard-text="<a href='http://www.aklover.co.kr/' target='_blank'><img src='http://www.aklover.co.kr/widget.png' width='170' height='170' border='0'></a>">
	                	<img src="../image2/intro/activity/widgetClip.png" alt="�ڵ庹�� �ϱ�" id="clipping"> 
                    </a>
                </p>
                  
                </p>
                <p class="widgetTarget"><img src="../image2/intro/activity/widgetProcess02.png" alt="�����ڵ� �Ϸ�����"/></p>
                <p class="widgetTarget"><img src="../image2/intro/activity/widgetProcess03.png" alt="�����ڵ� �����ֱ�"/></p>
                <p class="widgetTarget"><img src="../image2/intro/activity/widgetProcess04.png" alt="�����ڵ� �Ϸ�"/></p>
            </div>
        </div>
    
    <div id="tab03" class="superpassProcess tab_content">
    	<div class="superpass">
            <div>
                <p class="titleText"><span class="titleLine">l</span>�����н���?</p>
				<style>
					.superpass .icon_area{text-align:center;}
                    .superpass .icon_area img{width:50%;}
                    .superpass .text_area{width:100%; word-break:break-all; margin-left:10px; line-height:20px; margin-right:0;}
                    .superpass .red{color:#f00;}
                </style>
                <div class="icon_area">
                    <img src="/image2/superpass_marik_2.jpg?v=230511" />
                </div>
                <div class="text_area">
                	<p>���� �޴���  <span class="red">��ǰ ü���� ü���</span>�� �켱 ������ �� �ִ� ���� ����� <span class="red">�������н���</span>��� �ؿ�!</p>
                	
                	<p class="mgt10">
                    		* ����: �� �� ù ��° �α��� �� 1ȸ�� ����<br/>
							* ���� ����<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- 1���� �̳��� AK LOVER �Խñ� �ۼ� ȸ��<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ���̹� ��α� or �ν�Ÿ�׷� or ����ä��(���̹�TV, Youtube, ƽ�� ��) � ȸ��<br/>
                    	</p>
                	

                    
                    <p style="margin-top:20px;">
                        - ü��� ���� �ο��� 10%�� ������ ��� ����<br/>
                        - ��� �� ����� �� ������, �� �� ������ �� ������� ���� �����н��� �ڵ� �Ҹ�<br/><br/>
                        <span class="red">�� �������<br/>���� ID �Ǵ� 3���� �̳� ���Ƽ�� Ȯ�ε� ��� �����н��� �߱޵��� �ʽ��ϴ�.</span>
                    </p>
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
    
</div>


<?php 
}elseif($_REQUEST["board"]=="group_04_01"){
?>          
	<div id="akloverIntro">
        <p class="titleText"><span class="titleLine">l</span>�ְ� �������� AK LOVER��?</p>
        <div class="toptext">
            <!-- p class="toptitle">�ְ� �������� AK LOVER��?</p -->
            <p class="topcontent">
                �ְ��� �پ��� ��ǰ���� ���� ��� �� <span>������</span> �ִ� �¶��� Ȱ���� ����
                �ְ�� �Բ� �����ϰ� �����ϴ� ���������Դϴ�.<br/>
                ������ ���� �� �ְ� �������� AK LOVER�� Ȱ���Ͻ� �� ������,
                �پ��� �ְ� <span>��ǰ ü��</span>�� Ư���� ������ ������ �� �ֽ��ϴ�.
            </p>
            <p style="margin:20px 0 0 0;">
                <a href="/m/truly.php?board=group_04_13" class="box">AK LOVER�� ������</a>
                <a href="/m/aklover.php?board=group_04_15" class="box">ü��� �������</a>
            </p>
        </div>
        
        
        <p class="titleText" style="margin-top:50px;"><span class="titleLine">l</span>AK LOVER Ȱ�� ����</p>
        <p class="titleText2">AK LOVER�� �ǽø� �پ��� ������ ������ �� �ֽ��ϴ�.</p>
        <ul>
            <li>
                <div class="icon_area">
                    <img src="../image2/intro/aklover/iwhy_001.jpg"/>
                </div>
                <div class="text_area">
                    <p class="title">��ǰ ü��</p>
                    <p class="text text_one">- �ְ��� �پ��� ��ǰ�� ���� ��� �� ������ �ִ� �ı� �ۼ�</p>
                </div>    
            </li>
            <li>
                <div class="icon_area">
                    <img src="../image2/intro/aklover/iwhy_002.jpg"/>
                </div>
                <div class="text_area">
                    <p class="title">�Ը��� �̺�Ʈ</p>
                    <p class="text text_one">- �δ���� ���� ���� �̺�Ʈ�� ��÷ ��, �پ��� ���� ����</p>
                </div>    
            </li>
            <li>
                <div class="icon_area">
                    <img src="../image2/intro/aklover/iwhy_003.jpg"/>
                </div>
                <div class="text_area">
                    <p class="title">�����н� �̿��</p>
                    <p class="text text_one">- ��� ü��ܿ� �켱������ ���� ������ �̿��</p>
                    <p class="text">- ���� ��� : 1���� �̳� AK LOVER �Խñ� �ۼ� �� ��α� or �ν�Ÿ�׷��� ��ϴ� AK LOVER ȸ��</p>
                    <p class="text">- ���� �ñ� : �ſ� ù ��° �α��� �� �ڵ� ���� </p>
                    <p class="text">- ü��� ���� �ο��� 10%�� ������ ��� ����</p>
				    <p class="text">- ��� �� ����� �� ������, �� �� ������ �� ������� ���� �����н��� �ڵ� �Ҹ� </p>
					<p class="text mgt10 txt_emphasis">�� �������</p>
					<p class="text txt_emphasis">���� ID �Ǵ� 3���� �̳� ���Ƽ�� Ȯ�ε� ��� �����н��� �߱޵��� �ʽ��ϴ�.</p>
                </div>    
            </li>
            <li>
                <div class="icon_area">
                    <img src="../image2/intro/aklover/iwhy_005.jpg"/>
                </div>
                <div class="text_area">
                    <p class="title">�Һ��� ���� ���α׷�</p>
                    <p class="text text_one">- FGI/FGD, HUT, �´�ȸ, ��ǰ ǰ�� ��</p>
                </div>    
            </li>
        </ul>

        <ul>
            <li>
                <div class="icon_area">
                    <img src="../image2/intro/aklover/iwhy_010.jpg"/>
                </div>
                <div class="text_area">
                    <p class="title">����Ʈ ����</p>
                    <p class="text text_one">- AK LOVER Ȱ������ ������ ����Ʈ�� �� 1ȸ ���ϴ� �ְ��� ��ǰ���� ��ȯ</p>
                    <p class="text">- Loyal AK LOVER, Beauty Club, Life Club�� �߰� ����</p>
                </div>    
            </li>
            <li>
                <div class="icon_area">
                    <img src="../image2/intro/aklover/iwhy_008.jpg"/>
                </div>
                <div class="text_area">
                    <p class="title">AK LOVER`s Day</p>
                    <p class="text text_one">- �� �ص��� AK LOVER ȸ������ �������� Ȱ���� ����帮�� ������ ��� �غ��� �ų���Ƽ</p>
                    <p class="text">- ���������</p>
                    <p class="text">- �ų� AK LOVER�� ����(1�� 14��)�� ����</p>
                    <p class="text">&nbsp;&nbsp;*��Ȳ�� ���� ��¥ ����</p>
                </div>    
            </li>
            <li>
                <div class="icon_area">
                    <img src="../image2/intro/aklover/iwhy_009.jpg"/>
                </div>
                <div class="text_area">
                    <p class="title">Loyal AK LOVER</p>
                    <p class="text text_one">- ���� ���ȸ������ ������ AK LOVER�� Ư�� ���� ����</p>
                    <p class="text">- �ο� : 20��</p>
                    <p class="text">- Ư�� ���� : 5���� ��ȭ�� ��ǰ�� ����</p>
                    
                    <p class="text" style="margin-left:66px;">����Ʈ ���� 1ȸ �߰� ����</p>
                    
                    <p class="text">[���� ����]</p>
                    <p class="text">��α� or �ν�Ÿ ���� ��</p>
                    <p class="text">���� ü��� �ı� 1ȸ �̻� �ۼ�</p>
                    <p class="text">������Ƽ �� ������ �ִ� ������ �ۼ�</p>
                    <p class="text">���� AK LOVER ������(ü���, ��������, ��/�������� ����, ���� ����Ʈ, �� �ۼ� ��)</p>
                    <p class="text">3���� �� Loyal AK LOVER ������ ���� �� </p>
            </li>
            <li>
                <div class="icon_area">
                    <img src="../image2/intro/aklover/iwhy_012.jpg"/>
                </div>
                <div class="text_area">
                    <p class="title">AK LOVER ����Ʈ<br/>2,000��</p>
                    <p class="text text_one">- �� ü��� ����ڷ� �����Ǹ� AK LOVER ����Ʈ 2,000�� ����</p>
                    <p class="text">(�Ϻ� ü��� ����� ���� ���� ����)</p>

                </div>    
            </li>
        </ul>
        
        <div class="adminKyunga">
            <p class="title"><span style="font-size:11px;">�ְ� ��������</span> AK LOVER ������ <span>'���'</span><p><br/>
            <p class="content">
                ���(��)�� ����(��)�� �ְ�(����)�� �̸����� ���� ��(��)�ƴ�
                �ְ� �������� AK LOVER �����е�� ģ���ϰ� �����ϴ� ������ �̸��Դϴ�.
            </p>
            
        </div>
    </div>
</div>
<?php 
}elseif($_REQUEST["board"]=="group_04_02"){
?>

    <div class="introduceTab">
        <ul class="pointTab">
            <li class="on" rel="tab01">1. ����Ʈ ���̵�</li>
            <li rel="tab02">2. ȸ�� ���</li>
            <li rel="tab03">3. ����Ʈ ����</li>
        </ul>
    </div>
    <script>
    $(document).ready(function(){
        $('.tab_content').hide();
        $('.tab_content:first').show();
        
        $('.pointTab > li').click(function(){
            //�� on,off
            $('.pointTab').children('li').removeClass('on');
            $(this).addClass('on');
            
            //�� �̵�
            $('.tab_content').hide();
            var tabNum = $(this).attr('rel');
            $('#'+tabNum).fadeIn();
        });

        <? if($_REQUEST["selectTab"]) {?>
        	$('.pointTab > li').eq('<?=$_REQUEST["selectTab"];?>').click();
        <? } ?>
    });
    </script>
    
    <style>
		.guide_main { font-size: 15.5px;padding: 7% 0 6% 5%;font-weight: 800;letter-spacing: -0.7px;line-height: 30px; }
		.guide_main span { color:#EC6022;font-size:22px; }
		
		.guide_2 { border-top: 2px solid #9B9B9B;border-bottom: 1px solid #9B9B9B;width: 100%;text-align: center;font-size: 1em;font-weight: 800;margin: 20px 0; }
		.guide_2 tr { height: 38px; }
		.guide_2 tr td { border: 1px solid #EBE2DC;border-bottom: 0px;padding: 15px 0; }
		
		#guide_2_1 { padding:10px; }
		#guide_2_1 li { font-size: 13px;font-weight: 800; }
		
		#guide_2_2 { border-top: 2px solid #9B9B9B;border-bottom: 1px solid #9B9B9B;width: 100%;text-align: center;font-size: 13px;font-weight: 800;margin: 20px 0; }
		#guide_2_2 tr { height: 30px; }
		#guide_2_2 tr td { border: 1px solid #EBE2DC;border-left: 0px;border-bottom: 0px; }
		#guide_2_2 tr td.first { background:#FEF2E8; }
		#guide_2_2 tr td.last { border-right:0px; }
		#guide_2_2 tr td img { position: relative;width: 25px;top: 4px; }
		
		.col-xs-10 { padding:0px;margin-right: 1%; }
		@media screen and (min-width:768px){
			.col-sm-12-space { height:20px;float:left; }
		}
	</style>
	<div id="tab01" class="tab_content">

		<div class="col-sm-12-space col-sm-12"></div>
		<p class="titleText"><span class="titleLine">l</span>����Ʈ ����</p>
		<table class="guide_2">
			<tr style="background: #FDE6D2;font-size:14px;height:40px;">
				<td style="width: 19%;">�� ��</td>
				<td style="width: 44%;">Ȱ�� ����</td>
				<td style="width: 15%">Point</td>
			</tr>
			<tr >
				<td rowspan="5" >Ȩ������</td>
				<td>�⼮üũ<br> (�ش� �� ��� �⼮�� +50)</td>
				<td>1</td>
			</tr>
			<tr>
				<td>��� �ۼ�</td>
				<td>1</td>
			</tr>
			<tr >
				<td>�Խñ� �ۼ�</td>
				<td >2</td>
			</tr>
			<!-- <tr >
				<td>�������̵��(�Ϸ� 1ȸ�� ���ۼ� �����մϴ�)</td>
				<td>3</td>
			</tr>-->
			<tr>
				<td>�ű�ȸ�� ��õ</td>
				<td>500</td>
			</tr>
			<tr>
				<td>ȸ������ �� ù �α���</td>
				<td>500</td>
			</tr>
		</table>
        
        <ul id="guide_2_1">
            <li><img src="/image2/etc/guide2_4_heart.gif">&nbsp;&nbsp;�Ϸ翡 ���� �� �ִ� ����Ʈ�� <span style="color:#FF6600;">�� 20��</span>���� �����˴ϴ�.</li>
            <li style="margin-bottom:20px;"><img src="/image2/etc/guide2_4_heart.gif">&nbsp;&nbsp;��Ȳ�� ���� �߰� ����Ʈ ������ �����մϴ�.</li>
        </ul>
        
        <div style="clear:both;"></div>
        
        <p class="titleText"><span class="titleLine">l</span>����Ʈ ����</p>
        <table class="guide_2">
            <tr style="background: #FDE6D2;font-size:14px;height:40px;">
                <td style="width: 19%;">�� ��</td>
				<td style="width: 44%;">Ȱ�� ����</td>
				<td style="width: 15%">Point</td>
            </tr>
            <tr>
                <td rowspan="4" >ü���</td>
                <td>�ı� ���ۼ�</td>
                <td>-1,000</td>
            </tr>
            <tr>
                <td>�Ⱓ �� ü��� �ı� �̵��</td>
                <td>-500</td>
            </tr>
            <tr>
                <td>ü��� ���̵���� ���ؼ�</td>
                <td>-500</td>
            </tr>
            <tr>
                <td>�������� ���� ������ ��</td>
                <td>-1,000</td>
            </tr>
            <tr >
                <td rowspan="5">�Խ���</td>
                <td rowspan="3">�弳, ����, ������ �����ִ� �Խñ� ��</td>
                <td>-50<br>(1��)</td>
            </tr>
            <tr >
                <td>-100<br>(2��)</td>
            </tr>
            <tr >
                <td style="letter-spacing: -1.2px;">����<br>Ż��<br>(3��)</td>
            </tr>
            <tr >
                <td rowspan="2">������ ���� �� �����</td>
                <td>-100<br>(1��)</td>
            </tr>
            <tr >
                <td style="letter-spacing: -1.2px;">����<br>Ż��<br>(2��)</td>
            </tr>
        </table>
        
        <ul id="guide_2_1">
            <li style="margin-bottom:20px;"><img src="/image2/etc/guide2_4_heart.gif">&nbsp;&nbsp;�ı� ���ۼ� �� �������� ���� ���������� 1,000P �����ǽ� �е��� 3���� �� ü��� �������� ���ܵ˴ϴ�.</li>
        </ul>
       
        
        <p class="titleText"><span class="titleLine">l</span>����Ʈ Ȯ��</p>
        <img src="/m/img/intro/point/m_pointCheck.png" width="100%"/>
        <ul id="guide_2_1">
               <li><img src="/image2/etc/guide2_4_heart.gif">&nbsp;&nbsp;���� ����Ʈ : ����Ʈ ���� �Ⱓ '��ǰ ��ȯ ������ ����Ʈ'�̸�, ����Ʈ ���� ���� ���� ���� ����Ʈ�� �ϰ� �Ҹ� ó�� �˴ϴ�.</li>
        </ul>
        <div style="clear:both;"></div>
    </div>
    
    <div id="tab02" class="tab_content">
    	<p class="titleText"><span class="titleLine">l</span>ȸ�� ���</p>

    	<table id="guide_2_2">
            <tr style="background: #FDE6D2;font-size:14px;height:35px;">
                <td style="width: 16%">����</td>
                <td style="width: 39%">����Ʈ</td>
                <td class="last" style="width: 17%">������</td>
            </tr>
            <tr style="height: 75px;">
                <td class="first">AK LOVER</td>
                <td>AK LOVER ������ ��� ȸ��</td>
                <td class="last"><img src="/image/bbs/lev1.png"></td>
            </tr>
            <tr style="height: 75px;">
                <td class="first">Beauty Club</td>
                <td>AK LOVER <br/>Beauty Club���� ������ ȸ��</td>
                <td class="last"><img src="/image/bbs/lev_BeautyHolic.png"></td>
            </tr>
            <tr style="height: 75px;">
                <td class="first">Life Club</td>
                <td>AK LOVER <br/>Life Club���� ������ ȸ��</td>
                <td class="last"><img src="/image/bbs/lev_life.png"></td>
            </tr>
            <tr style="height: 75px;">
                <td class="first">Global Club</td>
                <td>AK LOVER <br/>Global Club���� ������ ȸ��<br/><span style="color:#f00;">�غ��� ���� ���å���� �����</span></td>
                <td class="last"><img src="/image/bbs/lev_global.png"></td>
            </tr>
        </table>
    </div>
    
     <div id="tab03" class="tab_content">
            <p class="titleText"><span class="titleLine">l</span>����Ʈ ����</p>
            <div class="pointPestival"><span><img src="/image2/etc/guide2_4_heart.gif"></span>�ų� 1ȸ �ְ� �������� AK LOVER Ȱ���� ���� ������ ����Ʈ�� �ְ� ��ǰ�� ��ȯ �� �� �ִ� �����Դϴ�.<br/>(Loyal AK LOVER�� ����Ʈ ���� �߰� ���� �Ǹ�, ���� ���� ����Ʈ�� �پ��� ��ǰ ��ȯ ����)</div>
            <p>
            	<span class="black">1. ����Ʈ ���� �Ⱓ : </span>����Ʈ ������ �Ը��� ������ �ҽÿ� ����˴ϴ�.<br/>
                <span class="black">2. ������� : </span>AK LOVER ȸ�� ����<br/>
                <span class="black">3. ���� ��� Ȯ�� : </span><br/>
                	&nbsp;&nbsp;&nbsp;&nbsp;- ���� ��: ü���/�̺�Ʈ �� ����Ʈ ���� �� �� ���ų���<br/>
					&nbsp;&nbsp;&nbsp;&nbsp;- ���� ��: ���������� �� ����Ʈ���� ���ų���<br/>
                <span class="black">4. ����Ʈ �Ҹ� : </span>��ü ȸ���� ���� ����Ʈ ���� ���� ���� ���� ����Ʈ�� �ϰ� �Ҹ� ó�� �˴ϴ�.
            </p>
            <img class="mgt10" src="/image2/intro/point/pointFestival2.png" width="100%"/>
    	</div>
    
<?php 
}elseif($_REQUEST["board"]=="group_03_01"){
?>

	
    <!--
	<div class="introduceTab">
        <ul class="storyTab">
            <li class="on" rel="tab01">About �ְ�</li>
            <li rel="tab02">���Ӱ��ɰ濵</li
            <li rel="tab03">�����ΰ濵</li>
        </ul>
    </div>
    -->
    <script>
    $(document).ready(function(){
        $('.tab_content').hide();
        $('.tab_content:first').show();
        
        $('.storyTab > li').click(function(){
            //�� on,off
            $('.storyTab').children('li').removeClass('on');
            $(this).addClass('on');
            
            //�� �̵�
            $('.tab_content').hide();
            var tabNum = $(this).attr('rel');
            $('#'+tabNum).fadeIn();
        });
    });
    </script>
    <div style="float:right">
        <a href="http://www.aekyung.co.kr" target="_blank"><img src="../image2/introduc_goak.jpg" /></a>
    </div>
    
    <div class="aboutAekyung">
        <div id="tab01" class="tab_content">
          <img src="../m/img/intro/aekyung/aekyungIntro_2022.png" alt="�ְ�Ұ�" class="mgt40"/>
          <!-- <img src="../image2/intro/aekyung/t1_about_000_2020.jpg" alt="About�ְ�" class="mgt40"/>  -->
          <img src="../image2/intro/aekyung/t1_about_01.jpg" alt="About�ְ�1" class="mgt60"/>
          <img src="../image2/intro/aekyung/t1_about_02.jpg" alt="About�ְ�2" class="mgt60"/>
        </div>
        
        <div id="tab02" class="tab_content">
          <img src="../m/img/intro/aekyung/aekyungIntro.png" alt="�ְ�Ұ�" class="mgt40"/>
          <img src="../image2/intro/aekyung/t2_CSR_01.jpg" alt="���Ӱ��ɰ濵1" class="mgt40"/>
          <img src="../image2/intro/aekyung/t2_CSR_02.jpg" alt="���Ӱ��ɰ濵2" class="mgt60"/>
        </div>
        
        <div id="tab03" class="tab_content">
          <img src="../m/img/intro/aekyung/aekyungIntro.png" alt="�ְ�Ұ�" class="mgt40"/>
          <img src="../image2/intro/aekyung/t3_design.jpg" alt="�����ΰ濵" class="mgt40"/>
        </div>
        
        
     </div>
 </div>


<?php } ?>
</div>
<script>
function fnDownBanner(num) {
	if(confirm("������ ��ʸ� �ʼ��� ���� ��Ź�帳�ϴ�.")){
		location.href= "/sub_customer/downBanner.php?gubun="+num;
	}
}
</script>
<!--������ ����-->
<?include_once "tail.php";?>