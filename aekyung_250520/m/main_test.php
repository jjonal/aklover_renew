<?php
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD���� 
#####################################################################################################################################################
//��� ����
include_once "head.php";
//��� ����

?>	
<style>
.swiper-pagination-clickable .swiper-pagination-bullet{margin:0 3px;}
.swiper-pagination-current{color:#fff;}
</style>

    <!-- ����� ���� ��� (s) -->
    <?
		$sql = "select hero_type,hero_title, hero_subtitle, hero_main, hero_href, hero_period from banner_mobile where hero_use='1' ";
		$sql .= " and ('".date("Y-m-d H:i:s")."' between hero_today_01 and hero_today_02) order by hero_order asc";
		sql($sql);
		$rollimg_count = @mysql_num_rows($out_sql);
		
		$banner_link = "";
		
		echo $rollimg_count;
	?>

    <div class="mainContent">
    	<!-- Swiper -->
        <div class="swiper-container" style="border-bottom:1px solid #d8d8d8; margin-bottom:10px;">
            <div class="swiper-wrapper">
            	<?  
				while($roll_list = @mysql_fetch_assoc($out_sql)){ 
					if($roll_list['hero_href'] != "")  {
						$banner_link = $roll_list['hero_href'];
					}else {
						$banner_link = "javascript:;";
					}
				?>
                <div class="swiper-slide">
                	<div class="bannerBackImg" style="width:100%;">
                    	<a href="<?=$banner_link?>">
                            <img src="/aklover/photo/<?=$roll_list["hero_main"];?>" />
                            
                            <? if($roll_list['hero_title'] != "" && $roll_list['hero_subtitle'] != "") {?>
                            <div class="banner_content">
                                <p class="head"><?=$roll_list['hero_title']?></p>
                                <p class="subhead"><?=$roll_list['hero_subtitle']?></p>
                                <p class="period"><?=$roll_list['hero_period']?></p>
                            </div>
                            <? } ?>
                        </a>
                    </div>
                </div>
                <? } ?>
            </div>
            <!-- Add Pagination -->
			<? if($rollimg_count > 0 ) {?>
            <div class="swiper-pagination" style="position:absolute; display:none;"></div>    
            <? } ?>           
        </div>
        <!-- Initialize Swiper -->
		<script>
        var swiper = new Swiper('.swiper-container', {
			loop:true,
            pagination: '.swiper-pagination',
			paginationType: 'fraction',
            paginationClickable: true,
			autoplay: 5000,
			autoplayDisableOnInteraction:false,

        });
		$(document).ready(function(){
			//var top = $(".bannerBackImg a img").height()-30;
			//��� ����¡��ư ��ġ ����
			$(".swiper-pagination").css({"top":"10px", "right":"10px", "color":"#ccc", "background":"rgba(0, 0, 0, 0.4)", "height":"20px", "min-width":"40px", "padding":"0 9px",
											"border-radius":"100rem", "transition":".1s", "line-height":"21px"});
			$(".swiper-pagination").show();
			
			$(window).resize(function(e) {
                var top = $(".bannerBackImg a img").height()-30;
				//$(".swiper-pagination").css({"top":top});
				//$(".swiper-pagination").show();
            });
		})
		
        </script>
        <!-- ����� ���� ��� (e) -->
        
        <div class="mainBannerWrap">
		<ul class="bannerBox">
			<li>
				<a href="/m/aklover.php?board=group_04_01">
					<p class="tit">AK LOVER��?</p>
					<p class="subTit">�ְ�� �Բ� �����ϰ�<br/>�����ϴ� ��������</p>
					<div class="bg"></div>
				</a>
				
			</li>
			<li>
				<a href="/m/truly.php?board=group_04_13">
					<p class="tit">AK LOVER�� ������</p>
					<p class="subTit">�ְ� ��ǰ ü���� ����<br/>������ ������ �ۼ�</p>
					<div class="bg"></div>
				</a>
			</li>
			<li>
				<a href="/m/aklover.php?board=group_04_12">
					<p class="tit">ü��� �������</p>
					<p class="subTit">ü��� ��û, ����/��� ��ġ,<br/>�����н� ����</p>
					<div class="bg"></div>
				</a>
			</li>
			<li>
				<a href="/m/board_00.php?board=group_02_03">
					<p class="tit">�Ը����̺�Ʈ</p>
					<p class="subTit">�δ���� ����<br/>���� �̺�Ʈ</p>
					<div class="bg"></div>
				</a>
			</li>
		</ul>
	</div>
        
    <div style="clear:both;"></div>
    	
    	<?
    	$sql = " SELECT b.hero_idx, b.hero_thumb, b.hero_04, b.blog_url, b.sns_url, b.cafe_url, b.etc_url FROM board b inner join member m on b.hero_code = m.hero_code ";
    	$sql .=" WHERE  b.hero_table IN ('group_04_05', 'group_04_06', 'group_04_07', 'group_04_09','group_04_23' ) ";
    	$sql .=" AND (b.hero_board_three='1' OR b.hero_table='group_04_10')  AND b.hero_use = 1 ";
    	$sql .=" ORDER BY b.hero_today DESC LIMIT 0,8 ";
    	 
    	sql($sql);
    	?>
    	<div class="postscriptWrap">
    		<p class="titleText"><span class="titleLine">l</span>AK LOVER ����ı� ���� ����</p>
    		
    		<ul>
    		<? 
    		
    		$k=0;
    		while($rs_postscript = @mysql_fetch_assoc($out_sql)){ 
    			$firstClass = "";
    			if($k%4==0)  $firstClass = "first";
	    			if($rs_postscript["hero_04"]) {
	    				$exploded_blog = explode("http", $rs_postscript["hero_04"]);
	    			}else {
	    				$exploded_blog = $rs_postscript["blog_url"].$rs_postscript["cafe_url"].$rs_postscript["sns_url"].$rs_postscript["etc_url"];
	    				$exploded_blog = str_replace(',','',$exploded_blog);
	    				$exploded_blog = explode("http", $exploded_blog);
	    			}
    		
    		?> 
    			<li class="<?=$firstClass;?>">
    				<a href="http<?=$exploded_blog[1]?>" target="_blank">
    					<img src="<?=$rs_postscript["hero_thumb"]?>" />
    					<div class="bg"></div>
    				</a>
    			</li>
    		<? $k++;} ?>
    		</ul>
    		
    </div>
<?php
//############ �޸���� ���� â ���� #################
if($_REQUEST["dormancy"] == "yes"){
	$dormancy_code = $_REQUEST["hero_code"];
	$dormancy_name = $_REQUEST["hero_name"];
	$dormancy_out_date = $_REQUEST["hero_out_date"];
	$dormancy_id = $_REQUEST["hero_id"];

?>
<style type='text/css'>
	.dimmed {	position: absolute;	top: 0;	right: 0;	bottom: 0;	left: 0;	z-index: 998;	display: block;	width:100%;	height: 100%;	background-color:#A8A8A8;	content: '';	opacity:0.7;}
	*{font-family:'�������',Nanum Gothic; font-size:14px; color:#4c4c4c; margin:0; padding:0;}
	.sleepbox { 
		position: absolute;
		width:440px;
		height:366px;

		z-index:1000;
		left:0px;
		top:0px;
		background: #fff;
		-webkit-box-shadow: 3px 3px 15px #afafaf;  
			-moz-box-shadow: 3px 3px 15px #afafaf; 
			box-shadow: 3px 3px 15px #afafaf;

	}	
</style>	
<script type='text/javascript'>
	$(function(){
		$(window).scrollTop(0);
		document.body.style.overflow = 'hidden';
		$('body').append('<div class=dimmed></div>');
		$('#sleepbox').css({'left': ( ($(window).width() - $('#sleepbox').width())/2 )+ 'px', 'top' : ( ($(window).height() - $('#sleepbox').height())/2 + $(window).scrollTop() )+ 'px'}).show();
	});	
	function goSubmit(){
		if(confirm("ȸ�������� Ȱ��ȭ �Ͻðڽ��ϱ�?")){
			return true;
		}else{
			return false;
		}	
	}		
</script> 
<div id='sleepbox' class='sleepbox' style='z-index:9999;'> 
<!--�޸��������-->
<form name="dormancy" method="post" action="/combined/activate.act.php" onsubmit="return goSubmit();">
<input type="hidden" name="hero_code" value="<?=$dormancy_code?>"/>
<input type="hidden" name="mobilepc" value="mobile"/>
<table width="440">
  <tr>
    <td><table width="440" border="0" cellspacing="0">
      <tr border="0" cellspacing="0">
        <td border="0" cellspacing="0"><img src="http://www.aklover.co.kr/image/popup/title_01.gif"></td>
      </tr>
      <tr>
        <td><table width="440" border="0" cellpadding="0">
      <tr>
        <td width="41"></td>
        <td height="30"></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td><table width="360" border="0" cellspacing="0">
          <tr>
<td class="text1"><strong><?=$dormancy_name?>(<?=$dormancy_id?>) ȸ������</strong><br />
              ��Ⱓ ����Ʈ�� �̿����� �ʾ� ���̵� �޸�����Դϴ�. <br />
              �޸������ ���̵� �� �̿��ϱ� ���ؼ��� �Ʒ� &quot;������&quot; <br />
              ���� ������ ���� ȸ���� ���� �̿��� �����ϰ� �˴ϴ�. <br />
              &quot;�������� ����'�� ���� �� ���̵�� �޸���°� �����˴ϴ�.</td>
          </tr>
          <tr>
            <td height="22"></td>
          </tr>
          <tr>
            <td bgcolor="#cccccc"  height="1" border="0" cellspacing="0"></td>
          </tr>
          <tr>
            <td height="30" valign="bottom"><img src="http://www.aklover.co.kr/image/popup/agree_01.gif" /></td>
          </tr>
          <tr>
            <td height="30" valign="bottom" class="text1">���̵�(<?=$dormancy_id?>) �޸���¸� �����ϴµ� �����Ͻʴϱ�?</td>
          </tr>
          <tr>
            <td><table width="370" border="0" cellspacing="0">
              <tr>
                <td></td>
                <td height="58" align="right" valign="bottom"><input type="image" src="http://www.aklover.co.kr/image/popup/ok_btn_01.gif"/></td>
                <td width="12"></td>
                <td height="58" valign="bottom" style="padding-bottom:5px;"><a href="/m"><img src="http://www.aklover.co.kr/image/popup/no_btn_01.gif" width="122" border="0"/></a></td>
                <td></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td height="30"></td>
        <td></td>
      </tr>
    </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<!--�޸������-->	
</div>		
<?php
//############ �޸���� ���� â �� #################
}
?>		
<?php
include_once "tail.php";
?> 		