<?php
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD오픈 
#####################################################################################################################################################
//헤더 시작
include_once "head.php";
//헤더 종료

?>	
<style>
.swiper-pagination-clickable .swiper-pagination-bullet{margin:0 3px;}
.swiper-pagination-current{color:#fff;}
</style>

    <!-- 모바일 전용 배너 (s) -->
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
			//배너 페이징버튼 위치 조절
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
        <!-- 모바일 전용 배너 (e) -->
        
        <div class="mainBannerWrap">
		<ul class="bannerBox">
			<li>
				<a href="/m/aklover.php?board=group_04_01">
					<p class="tit">AK LOVER란?</p>
					<p class="subTit">애경과 함께 생각하고<br/>소통하는 서포터즈</p>
					<div class="bg"></div>
				</a>
				
			</li>
			<li>
				<a href="/m/truly.php?board=group_04_13">
					<p class="tit">AK LOVER의 진정성</p>
					<p class="subTit">애경 제품 체험을 통한<br/>솔직한 컨텐츠 작성</p>
					<div class="bg"></div>
				</a>
			</li>
			<li>
				<a href="/m/aklover.php?board=group_04_12">
					<p class="tit">체험단 참여방법</p>
					<p class="subTit">체험단 신청, 위젯/배너 설치,<br/>슈퍼패스 사용법</p>
					<div class="bg"></div>
				</a>
			</li>
			<li>
				<a href="/m/board_00.php?board=group_02_03">
					<p class="tit">게릴라이벤트</p>
					<p class="subTit">부담없이 즐기는<br/>쉬운 이벤트</p>
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
    		<p class="titleText"><span class="titleLine">l</span>AK LOVER 우수후기 명예의 전당</p>
    		
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
//############ 휴면계정 동의 창 시작 #################
if($_REQUEST["dormancy"] == "yes"){
	$dormancy_code = $_REQUEST["hero_code"];
	$dormancy_name = $_REQUEST["hero_name"];
	$dormancy_out_date = $_REQUEST["hero_out_date"];
	$dormancy_id = $_REQUEST["hero_id"];

?>
<style type='text/css'>
	.dimmed {	position: absolute;	top: 0;	right: 0;	bottom: 0;	left: 0;	z-index: 998;	display: block;	width:100%;	height: 100%;	background-color:#A8A8A8;	content: '';	opacity:0.7;}
	*{font-family:'나눔고딕',Nanum Gothic; font-size:14px; color:#4c4c4c; margin:0; padding:0;}
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
		if(confirm("회원정보를 활성화 하시겠습니까?")){
			return true;
		}else{
			return false;
		}	
	}		
</script> 
<div id='sleepbox' class='sleepbox' style='z-index:9999;'> 
<!--휴면계정시작-->
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
<td class="text1"><strong><?=$dormancy_name?>(<?=$dormancy_id?>) 회원님은</strong><br />
              장기간 사이트를 이용하지 않아 아이디가 휴면상태입니다. <br />
              휴면상태인 아이디를 재 이용하기 위해서는 아래 &quot;동의함&quot; <br />
              인증 절차를 통해 회원제 서비스 이용이 가능하게 됩니다. <br />
              &quot;동의하지 않음'을 선택 시 아이디는 휴면상태가 유지됩니다.</td>
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
            <td height="30" valign="bottom" class="text1">아이디(<?=$dormancy_id?>) 휴면상태를 해지하는데 동의하십니까?</td>
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
<!--휴면계정끝-->	
</div>		
<?php
//############ 휴면계정 동의 창 끝 #################
}
?>		
<?php
include_once "tail.php";
?> 		