<? include_once "head.php";?> 
<link href="css/aklover.css?v=20220825" rel="stylesheet" type="text/css">
<!--������ ����-->
<?
$group_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_REQUEST['board'].'\';';//desc
$out_group = @mysql_query($group_sql);
$right_list                             = @mysql_fetch_assoc($out_group);
?>
<? include_once "boardIntroduce.php"; ?>

<div style="clear:both"></div>


<div id="line"></div>
<div class="trulyCont">
	<p class="titleText"><span class="titleLine">l</span>AK LOVER�� ������</p>
    
    <p style="margin-left:13px; line-height:20px;">�ְ��� ��ǰ ȿ���� ������, ������ ��ǰ�� ����, ȯ�� ģȭ���� ��ǰ ������ ���� "������"��
        ����ϰ� �ֽ��ϴ�.<br/>
        �ְ� �������� AK LOVER�� �̷��� ������ �ִ� �ְ��� ��ǰ�� ���� ü�� �� ������ �������� �ۼ��� �ֽø� �˴ϴ�.</p>
        
     <p style="margin-top:40px; padding:0 10px;" class="img"><img src="/image2/intro/truly/truly_img1.jpg" alt="" /></p><br/>
        
        <p class="titleText" style="margin-top:20px;"><span class="titleLine">l</span>AK LOVER�� ������ �ִ� ��������?</p>
        
        <div class="trulyWrap">
        	<div class="section sincerity">
        		<p class="tit">1. ����</p>
				<div class="first">
		        	<div class="box">
		        		<p><em>�������� �����ϰ� �ۼ��ؿ�</em></p>
		        		<p>��ǰ�� ���� �Ẹ��<br/>������ ���� �����ϰ� �ۼ��� ������</p>
		        	</div>
	        	
		        	<p class="txt01">�߸� ���� ����~�ϰ� �߷�����
		���������� ���� ���� �������� �� ���ۺ��� ������� ���������.<br/><br/>
		
		���� �������� �ʰ� ������ ���� �ε���� �ָ�
		����� ���ɾ�, ��� �� ó������ �� ���� �����ϴ�
		 �پȲ� �����ʼ������� ���̶�� ������ ����󱸿�</p>
		 
		 			<div class="picture01">
		 				<p><img src="/m/img/aklover/img_truly_sincerity_01.png" /></p>
		 				
		 				<p class="txt_writer">&lt; AGE 20's ��Ų �� ��� ����Ʈ / Beauty Club 10�� ���� �� &gt;</p>
		 			</div>
		 		</div>
		 		<div class="second last">
		 			<p class="txt01">��ũ �÷����� ȭ��Ʈ�� ���� ������ ���缭 �����ϱ�<br/>
30�� ������ �Ĳ��ϰ� ���� �� �ִ��󱸿�.<br/>
���� �ȶ��� ���� V3 �÷�ü��¡�� �ռ����� ��õ�Ҹ��� ��ǰ�̿���</p>
					
					<div class="picture01">
		 				<p><img src="/m/img/aklover/img_truly_sincerity_02.png" /></p>
		 				<p class="txt_writer">&lt; ���� �ڵ���� 3�� / Life Club 1�� maybhong �� &gt;</p>
		 			</div>
		 		</div>
 			</div>
 			
 			<div class="section sympathy">
 				 <p class="tit">2. ����</p>	
 				 <div class="first">
	 				 <div class="box">
	 				 	<p><em>�� ��ǰ�� ����ϰ� �� ���� ��Ȳ�� �����ؿ�!</em></p>
	 				 	<p>������ �̾߱⸦ ���� ���丮�ڸ��� ����<br/>�д��̿��� ������ �ִ� ������</p>
	 				 </div>
	 				 
	 				 <p class="txt01">���� ��~¥ ������ڿ��� ����� ��û ũ�� ���� Ȯ ��ŵ��.
�ٵ��� �����ٴ� ������ �����̸� ����� �� �߾��µ�
���̰� ���ϱ� �ȵǰڴ�����.<br/><br/>

���Ŀ���� �ϳ� �� �ϳĿ� ����
����ũ�� �� �Ǻΰ��� �޶����� �� ���Ƽ�
�����̸� ����� �����߾��.<br/><br/>

�糪 ���̽����̾���Ķ� 3���� ����� �ôµ���.
������� ���Ŀ������ �����ؼ� �� �� �ִ� ��ǰ�̿���.
</p>

					<p class="txt_writer">&lt; LUNA ���̽� ���̾ ���Ķ� 3�� / Beauty Club 10�� ���� �� &gt;</p>
 				 </div>
 				 <div class="second last">
 				 	<p class="txt01">
 				 		������ �����ϰ� �������ϰ� ���� ������ ������ �ֹ漼��! ���� �ǵ�
�ΰ��� Ÿ���� �ֹ漼���� ���ⲯ ��� ����� �� �־ ���ƿ�.<br/><br/>

���� ��ҿ��� ���� �ִ� ��ǰ���ٴ� ���� ���� ��ǰ���� �����ؼ�
���� ���� ������ ����غþ�� ^^

 				 	</p>	
 				 	<p class="txt_writer">&lt; ���� �ǵ� 2�� ü��� / AK LOVER ��*ȭ &gt;</p>
 				 </div>
 				 
 			</div>
 			
 			<div class="section help">
 				 <div class="first">
 				 	<p class="tit">3. ����</p>
 				 	<div class="box">
 				 		<p><em>����������! ü��� ���̵带 �����ϼ���!</em></p>
 				 		<p>��Ȯ�� ���� �������� �д��̿��� ������ �Ǵ� ������</p>	
 				 	</div>	
 				 	
 				 	<p class="txt01">��¥ ���ϰ��� �ʰ� ������ ����ؼ� ������� ���� ���� ������
���� ��� ����ؼ� �˳��� ������ �ٸ��� �Ѹ��� ���ְ� �ִµ���.<br/><br/>

�̷��� ���ϸ� ��ƾ���� �����ɾ ���ָ�
4���� �ϻ� ���� ���� �������� ���� 54.99%���
��ü����������� �ִٰ� �ϴ�����.
�����Ǻΰ��п����� / 20�� / 2020.11.11~12.30
</p>

					<p class="txt_writer">&lt; ����Ʈ�� ���� �� ���� Ŭ��¡���� + �Ǹ��� ����귯�� / Beauty Club 10�� õ�ȴ쳶�� �� &gt;</p>
 				 </div>
 				 <div class="second last">
 				 	<p class="txt01">
 				 		�µ��� ������ ���� ���� �帶ö����
������ �� �ص� ��� ���� ������ �������� ���� ���ƿ�.
�� ������ ������ ���� ������ �ٷ� ���հ� ���� �����ε���.<br/><br/>

�ѱ������� �ټ� ������ �����ױ�����
�̱��̳� ����, �߱����� �̹� ���ǰ� �ִ� ���� ���� ���������.<br/><br/>

������̳� ��Ű��հ� ���� ���պ���
�������� ĭ��ٱձ��� 99.9% ���ȿ���� �־
������ ���� �߲��� ���������� ���������.

 				 	</p>
 				 	
 				 	<p class="txt_writer">&lt; ���� �����ױ��� / Life Club 3�� �ƿ�ȭ ��  &gt;</p>
 				 </div>
 			</div>
        </div>
</div>
<!--������ ����-->
<?include_once "tail.php";?>