<? include_once "head.php";?> 
<link href="css/aklover.css?v=230501" rel="stylesheet" type="text/css">
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
	if($_REQUEST["board"]=="group_04_32"){
?>
	<div class="introduceTab">
        <ul class="activityTab">
            <li class="on" rel="tab01">AK LOVER ����</li>
            <li rel="tab02">ü���</li>
            <li rel="tab03">������/�����</li>
            <li rel="tab04">�Ը��� �̺�Ʈ</li>
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
    	<p class="titleText"><span class="titleLine">l</span>AK LOVER ���� �� SNS ��� ���</p>
            
        <p class="titleText3"><span class="numberCircle">1</span>AK LOVER Ȩ������ ���� > [ȸ������] ��ư Ŭ���Ͽ� ���� ����</p>
        <img style="display: block; margin: auto; max-width: 80%; height: auto;" src="../image2/intro/activity/home_guide_tab01_01.jpg" alt="ȸ�������̹���"/>
        
        <p class="titleText3" style="margin-top:70px;"><span class="numberCircle">2</span>�α��� > ���������� > ȸ������ ����</p>
        <font class="mgl10" color="red">*�߰� ���� ���� �� AK LOVER 30 ����Ʈ ����</font>
        <img style="margin-top:10px;" src="../image2/intro/activity/home_guide_tab01_02.jpg" alt="�α����̹���"/>
    </div>
    
    <div id="tab02" class="tab_content">
    	<p class="titleText" style="margin-bottom:20px;"><span class="titleLine">l</span>AK LOVER ü���</p>
        <font class="mgl10">*�ְ��� �پ��� ��ǰ�� ��/���������� ���� ���� ü���� �� �ֽ��ϴ�.</font>
        
        <p class="titleText3" style="margin-top:30px;"><span class="numberCircle">1</span>ü��� ����</p>
        <div class="experienceTypeWrap">
        	<div class="list mgt30">
        		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience1.jpg"></div>
        		<div class="text_area">
        			<p class="title">��ǰ ü��</p>
        			<p class="text text_one">- AK LOVER���� ��ǰ ���� �������� ����Ǵ� ü���</p>
        			<p class="txt_emphasis" style="margin-top:5px;">* ��, ��ǰ ��ۺ�� ���� �δ� (����Ʈ ���� or ���� �� ����)</p>
        		</div>    
        		
        	</div>
        	<div class="list mgt20">
        		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience2.jpg"></div>
        		<div class="text_area">
        			<p class="title">����Ʈ ü��</p>
        			<p class="text text_one">- ü��� �� ������ ���� ���Ͽ��� <strong>���� ��÷�� ��ǰ�� ����</strong>�Ͽ� �ʼ��̼� �� �����̼� �����ϴ� ü���</p>
        			<p class="txt_emphasis" style="margin-top:5px;">* ���� ��� ȯ���� �ƴ� ��ǰ�� �� AK LOVER ����Ʈ�� ���� ����</p>
        		</div>    
        	</div>
        	<div class="list mgt20">
        		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience3.jpg"></div>
        		<div class="text_area">
        			<p class="title">ǰ��, FGI/FGD, HUT</p>
        			<p class="text text_one">- AK LOVER���� �����ִ� ǰ�� ��ǰ ��� �� ������ �����ϴ� ü���</p>
        			<p class="txt_emphasis" style="margin-top:5px;">* ǰ�� ��ǰ�� ���� �ܺ� ���� �� SNS ���� ���ε尡 �Ұ��մϴ�.</p>
        		</div>    
        	</div>
        	<div class="list mgt20">
        		<div class="icon_area"><img src="../image2/intro/aklover/ico_experience4.jpg"></div>
        		<div class="text_area">
        			<p class="title">��������</p>
        			<p class="text text_one">- ������ �¶��� ���� ���� ����</p>
        			<p class="txt_emphasis" style="margin-top:5px;">* ǰ�� �� �������� ���� URL�� īī���� �� ���ڷ� �߼� �˴ϴ�.</p>
        		</div>    
        	</div>
        </div>
        
        <p class="titleText3" style="margin-top:70px;"><span class="numberCircle">2</span>�ְ� �귣��</p>
        <img style="margin-top:10px;" src="../image2/intro/activity/home_guide_tab02_01.jpg"  width="100%" alt="�ְ�귣���̹���"/>
    </div>
    
    <div id="tab03" class="superpassProcess tab_content">
    	<p class="titleText"><span class="titleLine">l</span>������</p>
        <font class="mgl10">*AK LOVER ȸ���е��� �ϻ�, ü���, Ȱ�� ���� �� �پ��� �̾߱⸦ ������ ����</font>
        <img style="margin-top:10px;" src="../image2/intro/activity/home_guide_tab03_01.jpg" alt="�������̹���"/>
        
        <p class="titleText" style="margin-top:70px;"><span class="titleLine">l</span>�����</p>
        <font class="mgl10">*SNS ����� ����� �پ��� ü��� �ı� �ۼ� ������ ��� �� �ִ� ����</font>
        <img style="margin-top:10px;" src="../image2/intro/activity/home_guide_tab03_02.jpg" alt="������̹���"/>
    </div>
    
    <div id="tab04" class="superpassProcess tab_content">
	    <p class="titleText" style="margin-bottom:20px;"><span class="titleLine">l</span>AK LOVER �Ը��� �̺�Ʈ</p>
        <font class="mgl10">*���� �����Ͽ� ����Ǵ� ���� ������ �̺�Ʈ</font>
        
        <p class="titleText3" style="margin-top:30px;"><span class="numberCircle">1</span>AK LOVER ���� �ν�Ÿ�׷� �ȷο� <a href="https://www.instagram.com/aekyunglover/"  style="color:blue">(@aekyunglover)</a></p>
        <img style="margin-top:10px;" src="../image2/intro/activity/home_guide_tab04_01.jpg" alt="ȸ�������̹���"/>
        
        <p class="titleText3" style="margin-top:70px;"><span class="numberCircle">2</span>���� �����Ͽ� ���ε� �Ǵ� �̺�Ʈ Ȯ�� �� ��۷� ���� �ۼ�</p>
        <font class="mgl10" color="red">(+ ģ�� �±�, ���丮 �� �ǵ忡 ���ε�)</font>
        <img style="margin-top:10px;" src="../image2/intro/activity/home_guide_tab04_02.jpg" alt="�α����̹���"/>
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
                    <p class="text text_one">- �� �� ���ȸ������ ������ AK LOVER��<br/>Ư�� ���� ����</p>
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
          <img src="../image2/intro/aekyung/t1_about_000_2020.jpg" alt="About�ְ�" class="mgt40"/>
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