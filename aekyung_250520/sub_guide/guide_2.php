<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);
######################################################################################################################################################
?>

    <div class="contents">
        <!-- story.css -->
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
		});
        </script>
        
        
        <style>
            	#guide_main { font-size: 17.5px;height: 58px;padding: 57px 0 0 22px;float: left;width: 442px;font-weight: 800;letter-spacing: -0.7px;line-height: 30px; }
            	#guide_main span { color:#EC6022;font-size:22px; }
            	
            	.guide_2 {border:1px solid #EBE2DC;border-top:2px solid #EBE2DC;border-bottom:2px solid #EBE2DC;width: 100%;text-align: center;font-size: 13px;font-weight: 800;margin: 5px 0; }
            	.guide_2 tr { height: 38px; }
            	.guide_2 tr td { border: 1px solid #EBE2DC;border-bottom: 0px; }
            	
            	#guide_2_1 { padding:10px; }
            	#guide_2_1 li { /*height: 23px;*/font-size: 13px;font-weight: 800; }
            	
            	#guide_2_2 {border:1px solid #EBE2DC;border-top:2px solid #EBE2DC;border-bottom:2px solid #EBE2DC;width: 100%;text-align: center;font-size: 13px;font-weight: 800;margin: 20px 0; }
            	#guide_2_2 tr { height: 30px; }
            	#guide_2_2 tr td { border: 1px solid #EBE2DC;border-left: 0px;border-bottom: 0px; }
            	#guide_2_2 tr td.first { background:#FEF2E8; }
            	#guide_2_2 tr td.last { border-right:0px; }
            	#guide_2_2 tr td img { position: relative;width: 25px;top: 4px; }
				
        </style>
        <div id="tab01" class="tab_content">
        	<div class="pointPestival"><span>&nbsp;<img src="/image2/etc/guide2_4_heart.gif"></span>&nbsp;AK LOVER Ȱ������ ������ ����Ʈ�� "����Ʈ ����"�� ���� �ְ��� ���ϴ� ��ǰ���� ��ȯ �����մϴ�.</div>
            <p class="titleText"><span class="titleLine">l</span>����Ʈ ����</p>
            <table class="guide_2">
                <tr style="background: #FDE6D2;font-size:14px;height:40px;">
                    <td style="width: 100px;">�� ��</td>
                    <td >Ȱ�� ����</td>
                    <td style="width:90px;">Point</td>
                </tr>
                <tr >
                    <td rowspan="5" >Ȩ������</td>
                    <td >�⼮üũ<br> (�ش� �� ��� �⼮�� +50)</td>
                    <td >1</td>
                </tr>
                <tr >
                    <td>��� �ۼ�</td>
                    <td>1</td>
                </tr>
                <tr >
                    <td>�Խñ��ۼ�</td>
                    <td>2</td>
                </tr>
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
                <li><img src="/image2/etc/guide2_4_heart.gif">&nbsp;&nbsp;��Ȳ�� ���� �߰� ����Ʈ ������ �����մϴ�.</li>
            </ul>
            
            <p class="titleText mgt40"><span class="titleLine">l</span>����Ʈ ����</p>
            <table class="guide_2">
                <tr style="background: #FDE6D2;font-size:14px;height:40px;">
                    <td style="width: 100px;">�� ��</td>
                    <td >Ȱ�� ����</td>
                    <td style="width:90px;">Point</td>
                </tr>
                <tr >
                    <td rowspan="4" >ü���</td>
                    <td>�ı� ���ۼ�</td>
                    <td>-1,000</td>
                </tr>
                <tr >
                    <td>�Ⱓ �� ü��� �ı� �̵��</td>
                    <td>-500</td>
                </tr>
                <tr >
                    <td>ü��� ���̵���� ���ؼ�</td>
                    <td>-500</td>
                </tr>
                <tr >
                    <td>�������� ���� ������ ��</td>
                    <td>-1,000</td>
                </tr>
                <tr >
                    <td rowspan="5" >�Խ���</td>
                    <td rowspan="3" >�弳, ����, ������ �����ִ� �Խñ� ��</td>
                    <td >-50(1��)</td>
                </tr>
                <tr >
                    <td >-100(2��)</td>
                </tr>
                <tr >
                    <td style="letter-spacing: -1.2px;">����Ż��(3��)</td>
                </tr>
                <tr >
                    <td rowspan="2" >������ ���� �� �����</td>
                    <td >-100(1��)</td>
                </tr>
                <tr >
                    <td style="letter-spacing: -1.2px;">����Ż��(2��)</td>
                </tr>
            </table>

            <ul id="guide_2_1">
                <li><img src="/image2/etc/guide2_4_heart.gif">&nbsp;&nbsp;�ı� ���ۼ� �� �������� ���� ���������� 1,000P �����ǽ� �е��� 3���� �� ü��� �������� ���ܵ˴ϴ�.</li>
            </ul>
            
            <p class="titleText mgt40"><span class="titleLine">l</span>����Ʈ Ȯ��</p>
            <img src="/image2/intro/point/pointCheck.png"/>
            <ul id="guide_2_1">
                <li><img src="/image2/etc/guide2_4_heart.gif">&nbsp;&nbsp;���� ����Ʈ : ����Ʈ ���� �Ⱓ '��ǰ ��ȯ ������ ����Ʈ'�̸�, ����Ʈ ���� ���� ���� ���� ����Ʈ�� �ϰ� �Ҹ� ó�� <br/><span style="margin-left:100px;"> �˴ϴ�.</span></li>
            </ul>
    	</div>
        
        <div id="tab02" class="tab_content">
	        <p class="titleText"><span class="titleLine">l</span>ȸ�� ���</p>
	        
         	<table id="guide_2_2">
				<tr style="background: #FDE6D2;font-size:14px;height:35px;">
            		<td style="width: 90px;">����</td>
            		<td style="width: 400px;">����Ʈ</td>
            		<td class="last" style="width:90px;">������</td>
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
            <p class="pointPestivalP">
            	<span class="black">1. ����Ʈ ���� �Ⱓ : </span>����Ʈ ������ �Ը��� ������ �ҽÿ� ����˴ϴ�.<br/>
                <span class="black">2. ������� : </span>AK LOVER ȸ�� ����<br/>
                <span class="black">3. ���� ��� Ȯ�� : </span><br/>
					&nbsp;&nbsp;&nbsp;&nbsp;- ���� ��: ü���/�̺�Ʈ �� ����Ʈ ���� �� �� ���ų���<br/>
					&nbsp;&nbsp;&nbsp;&nbsp;- ���� ��: ���������� �� ����Ʈ���� ���ų���<br/>
                <span class="black">4. ����Ʈ �Ҹ� : </span>��ü ȸ���� ���� ����Ʈ ���� ���� ���� ���� ����Ʈ�� �ϰ� �Ҹ� ó�� �˴ϴ�.
            </p>
            <img class="mgt10" src="/image2/intro/point/pointFestival2.png"/>
    	</div>
    </div>
</div><!--footer-->