<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
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
        	
				<div style="float:right">
                	<a href="http://www.aekyung.co.kr" target="_blank"><img src="../image2/introduc_goak.jpg" /></a>
                </div>
                <div id="tab01" class="tab_content">
                  <img src="../image2/intro/aekyung/aekyungIntro_2022.png" alt="애경소개"/>
                  <!--  <img src="../image2/intro/aekyung/t1_about_000_2020.jpg" alt="About애경" style="margin:20px 0 40px 0;"/>  2023.11.30 주석처리-->
               	  <img src="../image2/intro/aekyung/t1_about_01.jpg" alt="About애경1" style="margin:0 0 40px 0;"/>
                  <img src="../image2/intro/aekyung/t1_about_02.jpg" alt="About애경2" style="margin:0 0 40px 0;"/>
                </div>
                <!--
                <div id="tab02" class="tab_content">
                  <img src="../image2/intro/aekyung/aekyungIntro.png" alt="애경소개"/>
               	  <img src="../image2/intro/aekyung/t2_CSR_01.jpg" alt="지속가능경영1" style="margin:20px 0 40px 91px;"/>
                  <img src="../image2/intro/aekyung/t2_CSR_02.jpg" alt="지속가능경영2"/>
                </div>
                  
                
                <div id="tab03" class="tab_content">
                  <img src="../image2/intro/aekyung/aekyungIntro.png" alt="애경소개"/>
               	  <img src="../image2/intro/aekyung/t3_design.jpg" alt="디자인경영" width="100%;" style="margin:20px 0 0 0"/>
                </div>
                -->
			</div>
           </div> <!--footer-->
