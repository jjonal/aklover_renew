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

        <div class="contents tc">
      <img src="../image/story/story2_t1.gif" alt="" class="logotitle" />
      <ul class="logolist">
        <li></li>
        
        <li>
        	<a href="http://liq.aekyung.co.kr/" target="_blank"><img src="../image/story/logo7.gif" alt="��ť" border="0" />
        	</a>
        	<img src="../image/ico_fc.jpg" style="position: relative;top: -22px;left: 110px; cursor:pointer" alt="�ְ�ＤǪ" onclick="window.open('https://www.facebook.com/thankyouLiQ')"/>
        	<img src="../image/ico_blog.gif" style="position: relative;top: -22px;left: 110px; cursor:pointer" alt="�ְ�ＤǪ" onclick="window.open('http://blog.naver.com/thankyou_liq')"/>
        </li>
        <li><a href="http://www.coolspark.co.kr/" target="_blank"><img src="../image/story/logo6.gif" alt="����ũ" /></a></li>
        <li></li>
        <li>
        	<a href="http://www.woolshampoo.co.kr/" target="_blank">
        		<img src="../image/story/logo3.gif" alt="�ְ�ＤǪ" />
        	</a>
        	
        </li>
        <li><a href="http://trio.aekyung.co.kr/trio_08/index.htm" target="_blank"><img src="../image/story/logo4.gif" alt="Ʈ����" /></a></li>
        <li><a href="http://bubble.aekyung.co.kr/" target="_blank"><img src="../image/story/logo5.gif" alt="��������" /></a></li>
        <li><a href="http://www.aekyungst.co.kr/" target="_blank"><img src="../image/story/logo2.gif" alt="����ƼȨ��" /></a></li>       
      </ul>
      <img src="../image/story/story2_t2.gif" alt="" class="logotitle" />
      <ul class="logolist">
        <li>
        	<a href="http://2080.aekyung.co.kr/" target="_blank">
        		<img src="../image/story/logo9.gif" alt="��ŻŬ����2080" border="0" />
        	</a>
        	<img src="../image/ico_fc.jpg" style="position: relative;top: -22px;left: 139px; cursor:pointer" alt="��ŻŬ����2080" onclick="window.open('https://www.facebook.com/dental2080')"/>
        	<img src="../image/ico_tw.jpg" style="position: relative;top: -22px;left: 139px; cursor:pointer" alt="��ŻŬ����2080" onclick="window.open('https://twitter.com/dental2080')"/>
        </li>        
      </ul>
      <img src="../image/story/story2_t3.gif" alt="" class="logotitle" />
      <ul class="logolist">        
        <li>
        	<a href="http://www.kerasys.net/" target="_blank"><img src="../image/story/logo10.gif" alt="�ɶ�ý�" border="0" />
        	</a>
        	<img src="../image/ico_fc.jpg" style="position: relative;top: -22px;left: 117px; cursor:pointer" alt="�ɶ�ý�" onclick="window.open('https://www.facebook.com/KerasysBM')"/>
        	<img src="../image/ico_tw.jpg" style="position: relative;top: -22px;left: 117px; cursor:pointer" alt="�ɶ�ý�" onclick="window.open('https://twitter.com/Kerasys_bm')"/>
        	<img src="../image/ico_blog.gif" style="position: relative;top: -22px;left: 117px; cursor:pointer" alt="�ɶ�ý�" onclick="window.open('http://www.allthatb.com/')"/><img src="../image/ico_fc.jpg" style="position: relative;top: -22px;left: 122px; cursor:pointer" alt="��������" onclick="window.open('https://www.facebook.com/Esthaar.BM')"/>
        </li>
        <li><a href="http://www.aekyung.co.kr/ak_08/product_list/product_list_17.jsp" target="_blank"><img src="../image/story/logo16.gif" alt="�ϳ���" /></a></li>
        <li><a href="http://www.aekyung.co.kr/ak_08/main/sub.jsp?pcd=beauty_care%2Fbeauty_care_010_020" target="_blank"><img src="../image/story/logo17.gif" alt="��" /></a></li>
              
      </ul>
      <img src="../image/story/story2_t4.gif" class="logotitle" />
      <ul class="logolist">      
        <li>
        <a href="http://www.aekyung.co.kr/ak_08/product_list/product_list_13.jsp" target="_blank"><img src="../image/story/logo18.gif" alt="��������Ʈ" /></a></li>
        <li>
        <a href="http://www.aekyung.co.kr/ak_08/product_list/product_list_14.jsp" target="_blank"><img src="../image/story/logo19.gif" alt="���Ĩ" /></a></li>  
        <li>
        <a href="http://www.aekyung.co.kr/ak_08/product_list/product_list_15.jsp" target="_blank"><img src="../image/story/logo20.gif" alt="�ټ���" /></a></li>    
      </ul>
      <img src="../image/story/story2_t5.gif" alt="" class="logotitle" />
      <ul class="logolist">
      	<li>
      		<a href="http://www.aekyung.co.kr/ak_08/product_list/product_list_19.jsp" target="_blank"><img src="../image/story/logo12.gif" alt="����Ʈ" border="0" />
        	</a>
        	
        	<img src="../image/ico_fc.jpg" style="position: relative;top: -22px;left: 118px; cursor:pointer" alt="����Ʈ" onclick="window.open('https://www.facebook.com/pointcleansing')"/>
        </li>
        <li>
        	<a href="http://www.aekyung.co.kr/ak_08/product_list/product_list_20.jsp" target="_blank"><img src="../image/story/logo13.gif" alt="���ַ̼��" />
        	</a>
        	<img src="../image/ico_fc.jpg" style="position: relative;top: -22px;left: 122px; cursor:pointer" alt="���ַ̼��" onclick="window.open('https://www.facebook.com/asolution.clinical')"/>
        	<img src="../image/ico_blog.gif" style="position: relative;top: -22px;left: 122px; cursor:pointer" alt="���ַ̼��" onclick="window.open('http://blog.naver.com/a__solution/')"/>
        </li>
        <li>
        	<a href="http://cosmeticluna.com/" target="_blank"><img src="../image/story/logo14.gif" alt="�糪"border="0" /></a>
        	<img src="../image/ico_fc.jpg" style="position: relative;top: -22px;left: 117px; cursor:pointer" alt="�糪" onclick="window.open('https://www.facebook.com/Cosmetic.LUNA')"/>
        </li>
        <li>
        	<a href="http://cosmeticluna.com/" target="_blank"><img src="../image/story/ban_aget.gif" alt="�����������Ͻ�"border="0" /></a>
        	<img src="../image/ico_fc.jpg"  alt="�����������Ͻ�" />
        </li>
      
      
      </ul>
      <!--���Ż���Ʈ-->
      <img src="../image/story/story2_t5.gif" alt="" class="logotitle" />
      <ul class="logolist">
      	<li>
      		<a href="http://www.aekyung.co.kr/ak_08/product_list/product_list_19.jsp" target="_blank"><img src="../image/story/barnd_maumgage.gif" alt="����Ʈ" border="0" />
        	</a>
        </li>
        <li>	
        	<a href="http://akbeauty.co.kr/shop/goods/goods_list.php?&category=001" target="_blank"><img src="../image/story/barnd_beautymall.gif" alt="����Ʈ" border="0" />
        	</a>
        </li>
       
       
     
      
      </ul>
      
    </div>
    </div>
