<?
####################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
####################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
####################################################################################################################################################
if(
        (!strcmp($_GET['hero'],''))
    and (!strcmp($_GET['path'],''))
    and (!strcmp($_GET['board'],''))
    and (!strcmp($_GET['root'],''))
    and (!strcmp($_GET['admin'],''))
){
    $wrap_class = 'main';
}else{
    $wrap_class = 'sub';
}
$sql = 'select * from hero_group where hero_group=\'home\' and hero_idx=\'1\';';//desc
$sql = out($sql);
sql($sql, 'on');
$list                             = @mysql_fetch_assoc($out_sql);
$hero_alt = explode('||', $list['hero_title']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Type" content="text/html; charset=<?=OLDSET;?>" />
        <meta name="Keywords" content="<?=$hero_alt['1'];?>" />
<?
    $sns_sql = 'select * from board where hero_idx=\''.$_GET['idx'].'\';';
    $out_sns_sql = mysql_query($sns_sql);
    $sns_row = @mysql_fetch_assoc($out_sns_sql);//mysql_fetch_row
    $sns_title = $sns_row['hero_title'];
    $link = PATH_HOME.'?board='.$sns_row['hero_table'].'&page='.$_GET['page'].'&view='.$_GET['view'].'&idx='.$_GET['idx'];
    $sns_image= DOMAIN_END.'image/logo2.gif';

?>

        <meta property="og:type" content="website" />
        <meta property="og:site_name" content="<?=$hero_alt['0'];?>" />

        <title>AKLOVER</title>
        <meta name="description" content="AKLOVER 애경서포터즈">

        <link rel="stylesheet" type="text/css" href="<?=CSS_END;?>general2.css"/>


        <script type="text/javascript" src="<?=JS_END;?>jquery.min.js"></script>
        <script type="text/javascript" src="<?=JS_END;?>birthdate.js"></script>
        <script type="text/javascript" src="<?=JS_END;?>head.js"></script>
        <script type="text/javascript" src="<?=JS_END;?>common.js"></script>

<?
//ie 8인 경우
if( strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 8.0') !== FALSE){
	?>
	<script src='http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js'></script>
	<script>
		$(document).ready(function(){

		});
	</script>
<?
}

?>



<!--이미지 캐로셀 js-->
		<script type="text/javascript" src="<?=JS_END;?>jquery.cycle.all.js"></script>

        <script>
        function open0(link){
            var link1 = encodeURIComponent(link);
            window.open('http://www.facebook.com/sharer/sharer.php?u='+link1,'','width=520 height=400 scrollbars=yes');
        }
        function open1(sub, link){
            var sub1 = encodeURIComponent(sub);
            var link1 = encodeURIComponent(link);
            window.open('http://twitter.com/home?status='+sub1+' '+link1,'','width=520 height=200 scrollbars=yes');
        }
        function open2(sub, link){
            var sub1 = encodeURIComponent(sub);
            var link1 = encodeURIComponent(link);
            window.open('http://plugin.me2day.net/v1/me2post/create_post_form.nhn?body='+sub1+' '+link1,'','width=520 height=400 scrollbars=yes');
        }


			//########## quick menu ########## //
		function quick_button(){
			if($("#quick_button").attr("class")=="on"){
				$( "#quick_button" ).attr("class","off" );
				$( "#quick_button" ).animate({ right: "+=200px" });
				$( "#quick02" ).animate({width: "+=200px"});
				$('#qimage').attr('src','/image2/main/qclose.png');
			}else if($("#quick_button").attr("class")=="off"){
				$( "#quick_button" ).attr("class","on" );
				$( "#quick_button" ).animate({ right: "-=200px" });
				$( "#quick02" ).animate({width: "-=200px"});
				$( '#qimage' ).attr('src','/image2/main/qopen.png');

				var expire = new Date();
				var cDay = 1000*60*60*24;
				var cName = 'quick_off';
				var cValue = '1';
				expire.setDate(expire.getDate() + cDay);

				cookies = cName + '=' + escape(cValue) + '; path=/ '; // 한글 깨짐을 막기위해 escape(cValue)를 합니다.
				if(typeof cDay != 'undefined') {
					cookies += ';expires=' + expire.toGMTString() + ';';
					document.cookie = cookies;
				}
			}
		}
		</script>
	<?
		//메인페이지 일 경우
		if($wrap_class=='main'){
	?>
	<script>
		$(document).ready(function(){

				  cName = 'quick_off=';
				  var cookieData = document.cookie;
				  var start = cookieData.indexOf(cName);
				  var cValue = '';
				  if(start != -1){
					   start += cName.length;
					   var end = cookieData.indexOf(';', start);
					   if(end == -1)end = cookieData.length;
					   cValue = cookieData.substring(start, end);
				  }
				  //cookie 퀵메뉴 닫음

				  if(unescape(cValue)!='1'){
					$('#quick_button').css('right','238px');
					$('#quick_button').attr('class','off');
					$( '#qimage' ).attr('src','/image2/main/qclose.png');
					$('#quick02').css('width','200px');
				  }

				  var mobileKeyWords = new Array('iPhone', 'iPod', 'BlackBerry', 'Android', 'Windows CE', 'LG', 'MOT', 'SAMSUNG', 'SonyEricsson','lgtelecom','skt','mobile','Mobile','blackbem','sony','phone');
					for (var word in mobileKeyWords){
					  if (navigator.userAgent.match(mobileKeyWords[word]) != null){
							$('#quick_button').css('display','none');
							$('#quick02').css('width','0px');
					  }
					}

		});


    </script>
	<?
		}
	?>

    </head>
<body>
<!--quick menu-->
<div id="quick_menu">

            <div id="quick_button" class="on">
				<div id="quick01">
					<ul>
						<li class="oc"><img id="qimage" src="/image2/main/qopen.png" onclick="quick_button();" width="36" height="26" alt="퀵메뉴 닫기" /></li>
						<li><a href='/main/index.php?board=group_04_12'><img src="/image2/main/qmn01.png" width="28" height="28" alt="홈페이지 이용가이드 바로가기" /></a></li>
						<li><a href='/main/index.php?board=group_04_03'><img src="/image2/main/qmn02.png" width="28" height="27" alt="공지사항 바로가기" /></a></li>
						<li><a href='/main/index.php?board=group_04_05'><img src="/image2/main/qmn03.png" width="28" height="31" alt="일반미션 바로가기" /></a></li>
						<li><a href='/main/index.php?board=group_02_03'><img src="/image2/main/qmn04.png" width="28" height="28" alt="게릴라 이벤트 바로가기" /></a></li>
						<li><a href='/main/index.php?board=group_04_04'><img src="/image2/main/qmn05.png" width="28" height="31" alt="출석체크 바로가기" /></a></li>
						<li class="lilast"><a href='#'><img src="/image2/main/qmn06.png" width="28" height="28" alt="캘린더 바로가기" /></a></li>
				   </ul>
			   </div>
            </div>

            <div id="quick02">
				<ul>
					<li><a href='/main/index.php?board=group_04_12'>홈페이지 이용가이드</a></li>
					<li><a href='/main/index.php?board=group_04_03'>공지사항</a></li>
					<li><a href='/main/index.php?board=group_04_05'>일반미션</a></li>
					<li><a href='/main/index.php?board=group_02_03'>게릴라 이벤트</a></li>
					<li><a href='/main/index.php?board=group_04_04'>출석체크</a></li>
					<li class="lilast">캘린더
						<dl class="cal">
							<dt>신청 중 미션</dt>
							<?
									$sql = "select hero_idx, hero_table, substr(hero_title,1,15) as hero_title, dateDIFF(substr(hero_today_01_02,1,10),DATE_FORMAT(now(),'%Y-%m-%d')) as dDay from mission where substr(hero_today_01_02,1,10)>=DATE_FORMAT(now(),'%Y-%m-%d') and hero_table in ('group_04_05', 'group_04_06', 'group_04_07') order by dDay asc limit 0,5;";//desc
									$sql = mysql_query($sql);
									while($sql_mission = @mysql_fetch_assoc($sql)){
							?>

							<dd><a href="/main/index.php?board=<?=$sql_mission['hero_table']?>&page=1&view=view&idx=<?=$sql_mission['hero_idx']?>"><span class="orange">(D-<?=$sql_mission['dDay']?>)</span><?=$sql_mission['hero_title'];?></a></dd>
							<?
									}
							?>
						</dl>
						<dl class="cal">
							<dt>리뷰 등록 중인 미션</dt>

							<?
									$sql = "select hero_idx, hero_table,substr(A.hero_title,1,15) as hero_title, dateDIFF(substr(A.hero_today_03_02,1,10),DATE_FORMAT(now(),'%Y-%m-%d')) as dDay from mission A where substr(A.hero_today_03_02,1,10)>=DATE_FORMAT(now(),'%Y-%m-%d') and hero_table in ('group_04_05', 'group_04_06', 'group_04_07') and substr(A.hero_today_01_02,1,10)<DATE_FORMAT(now(),'%Y-%m-%d') order by dDay asc limit 0,5;";//desc
									$sql = mysql_query($sql);
									while($sql_mission = @mysql_fetch_assoc($sql)){
							?>
									<dd><a href="/main/index.php?board=<?=$sql_mission['hero_table']?>&page=1&view=view&idx=<?=$sql_mission['hero_idx']?>"><span class="orange">(D-<?=$sql_mission['dDay']?>)</span><?=$sql_mission['hero_title'];?></a></dd>
							<?
									}
							?>
						</dl>
				</li>
			</ul>
		</div>


</div><!--id="quick_menu"-->

<?
if(!strcmp($wrap_class,'main')){?>

	<div id="wrap">

<?}else if(!strcmp($wrap_class,'sub')){?>

<div id="wrap">
<?}?>

<script>
	$(document).ready(function(){

		$('.circle').hover(function(){
				$(this).css("background-image","/image2/main/circle_in.png");
			},function(){
				$(this).css("background-image","/image2/main/circle_out.png");
			}

		);


		var option = $('#select_options');
		var optionp = $('#select_options p');
		var select = $('#select_search');
		var selectd = $('#select_search div');
		var selecti = $('#select_search #select');

		optionp.hover(
			function(){
				$(this).css('background-color','#ED6022').css('color','#ffffff');
			},
			function(){
				$(this).css('background-color','#ffffff').css('color','#ED6022');;
			}
		);
		select.hover(
			function(){
				option.css('display','block');
				option.hover(
					function(){
						option.css('display','block');
					},function(){
						option.css('display','none');
					}
				);
				optionp.click(function(){
					var text = $( this ).text();
					var value = $( this ).attr('id');
					selecti.attr('value',value );
					selectd.text(text);
					option.css('display','none');
				});

			},function(){

				option.css('display','none');
			}
		);
		var agt = navigator.userAgent.toLowerCase();

	});


</script>
<style>
	#select_options { padding: 3px;cursor: pointer;display: none;width: 164px;position: relative;left: 463px;top: 17px;border-right: 1.5px solid #606060;border-left: 1.5px solid #606060;border-bottom: 1.5px solid #606060;border-radius: 0 0 5px 5px;background-color: #ffffff;float: left;z-index: 500; }
	#select_options p { color:#ED6022;}
	.searchbox > form > div { float:left;padding: 1px 0 0 4px;height: 20px; }
	#select_search div { width: 41px;overflow:hidden;float:left;height:16px; }
</style>
    <div id="header">
        <!--<h1><a href="<?=PATH_HOME?>"><img src="../image/common/logo.gif" alt="AK LOVER"></a></h1>-->

		<div class="topmn">
			<div class="top_wrap">
			<ul>
				<div id='select_options'>
					<p id='hero_title'>제목</p>
					<p id='hero_nick'>작성자</p>
					<p id='hero_all'>제목+작성자</p>
				</div>
				<?if(!strcmp($_SESSION['temp_id'],'')){?>

					<li class="tmn01"><a href="<?=PATH_HOME?>?board=idcheck"><img src="/image2/main/topmn01.png" width="54" height="12" alt="회원가입" /></a></li>

				<?}?>
				<?if(!strcmp($_SESSION['temp_id'],'')){?>

					<li class="tmn02"><a href="<?=PATH_HOME?>?board=login"><img src="/image2/main/topmn02.png" width="44" height="12" alt="로그인" /></a></li>

				<?}else{?>

					<li class="tmn02"><a href="<?=PATH_END?>out.php"><img src="/image2/main/topmn02_o.png" width="54" height="12" alt="로그아웃" /></a></li>

				<?}?>
					<li class="tmn03"><a href="#" onclick="{window.external.AddFavorite('<?=MAIN_END?>', '<?=$hero_alt['0'];?>')}"><img src="/image2/main/topmn03.png" width="54" height="12" alt="즐겨찾기" /></a></li>
					<li class="tmn04"><a href="<?=PATH_HOME?>?board=cus_2"><img src="/image2/main/topmn04.png" width="55" height="12" alt="고객센터" /></a></li>
				<?if(strcmp($_SESSION['temp_id'],'')){?>
					<li class="tmn04"><a href="<?=PATH_HOME?>?board=mission"><img src="/image2/main/topmn02_on.png" width="55" height="12" alt="mypage" /></a></li>
					<?

					/////////////////////////////////////쪽지
					if(strcmp($_SESSION['temp_id'],'')){
						$mail_sql = 'select * from mail where hero_user=\'all\' or CONCAT(\'||\', hero_user, \'||\') LIKE \'%||'.$_SESSION['temp_id'].'||%\';';
						$out_mail_sql = mysql_query($mail_sql);
						$total_mail_01 = @mysql_num_rows($out_mail_sql);

						$mail_sql = 'select * from mail where CONCAT(\'||\', hero_user_check, \'||\') LIKE \'%||'.$_SESSION['temp_id'].'||%\';';
						$out_mail_sql = mysql_query($mail_sql);
						$total_mail_02 = @mysql_num_rows($out_mail_sql);
						$total_mail = (int)$total_mail_01 - (int)$total_mail_02;
						if(!strcmp($total_mail,'0')){
							$total_mail_count = '';
						}else{
							$total_mail_count = $total_mail;
						}
					?>
					<li class="tmn04">
						<a href="<?=PATH_HOME?>?board=mail">
							<img src="/image2/main/topmn06.png" height="12" alt="mypage" />
							<span><?=$total_mail_count?></span>
						</a>
					</li>
					<?
					}
					?>
				<?}?>
					<li class="tmn04"><img src="/image2/main/topmn05.png" width="21" height="12" alt="검색" /></li>
					<li class="tmn05">
						<!-- 검색박스 -->


						<div class="searchbox">
							<form action="<?=PATH_HOME?>?board=search" method="POST" >
								<div id='select_search'>
									<div>
										<?
											if($_POST['select']){
												if($_POST['select']=='hero_title'){
													echo "제목";
												}elseif($_POST['select']=='hero_nick'){
													echo "작성자";
												}elseif($_POST['select']=='hero_all'){
													echo "제목+작성자";
												}

											}else{
										?>
											선택
										<?
											}
										?>
									</div>
									<input id='select' type='hidden' name='select' value='<?=$_POST['select']?>'>
									<img src='/image2/top/top_select.jpg'>
								</div>
								<input class="stext" name='kewyword' type="text" value='<?=$_POST['kewyword']?>' />
								<input class="sbtn" type="image" src="/image2/main/searchimg.png" />
							</form>
						</div>
					</li>
			</ul>





<?

/////////////////////////////////////쪽지
if(strcmp($_SESSION['temp_id'],'')){
    $mail_sql = 'select * from mail where hero_user=\'all\' or CONCAT(\'||\', hero_user, \'||\') LIKE \'%||'.$_SESSION['temp_id'].'||%\';';
    $out_mail_sql = mysql_query($mail_sql);
    $total_mail_01 = @mysql_num_rows($out_mail_sql);

    $mail_sql = 'select * from mail where CONCAT(\'||\', hero_user_check, \'||\') LIKE \'%||'.$_SESSION['temp_id'].'||%\';';
    $out_mail_sql = mysql_query($mail_sql);
    $total_mail_02 = @mysql_num_rows($out_mail_sql);
    $total_mail = (int)$total_mail_01 - (int)$total_mail_02;
    if(!strcmp($total_mail,'0')){
        $total_mail_count = '';
    }else{
        $total_mail_count = $total_mail;
    }
?>
					<!--<a href="<?=PATH_HOME?>?board=mail"><img src="../image/common/top_memo3.gif" alt="쪽지함" /><font color="black"><?=$total_mail_count?></font>&nbsp;<img src="../image/common/top_memo2.gif" alt="쪽지함" /></a>-->
<?
}
?>
					</div><!-- class="top_wrap" -->
				</div><!-- class="topmn" -->

      <div class="top_wrap">
		<div class="gnb_area" style='height:354'></div>
		<div class="mainmn gnb">
			<h1><a href="index.php"><img src="/image2/main/ak_logo.png" width="156" height="56" alt="ak lover 로고" /></a></h1>
			<ul>

<?


//카테고리
$sql = 'select * from hero_group where hero_menu=\'0\' and hero_use=\'1\' order by hero_point,hero_group, hero_order';//desc//asc
//echo $sql;
$out_sql = mysql_query($sql);
$total_data = @mysql_num_rows($out_sql);
$group = '';
$count_i = '0';
$total_i = $total_data-1;
$ii=0;
while($menu_list                             = @mysql_fetch_assoc($out_sql)){
	if(!strcmp($menu_list['hero_board'],"group_04_03")){
		$new_hero_table = " or hero_table='hero'";
	}else{
		$new_hero_table = "";
	}
	//최신글 모으기
	$new_sql = 'select * from board where hero_table=\''.$menu_list['hero_board'].'\' '.$new_hero_table.' and hero_table not in (\'group_04_05\', \'group_04_06\', \'group_04_07\', \'group_04_08\', \'group_04_09\', \'group_04_10\') order by hero_today desc limit 0,1;';
	//echo $new_sql;
	$out_new_sql = mysql_query($new_sql);
	$new_list                             = @mysql_fetch_assoc($out_new_sql);
	if(!strcmp(y."-".m."-".d, date( "y-m-d", strtotime($new_list['hero_today'])))){
		$new_img_view = " <img src='".DOMAIN_END."image/sub_new.jpg' alt='new' />";
	}else{
		$new_img_view = "";
	}


	if( (!strcmp($menu_list['hero_board'],"group_04_05")) or (!strcmp($menu_list['hero_board'],"group_04_06")) or (!strcmp($menu_list['hero_board'],"group_04_07")) or (!strcmp($menu_list['hero_board'],"group_04_08")) ){
		$check_day = date( "Y-m-d", time());
		//    $mission_sql = 'select * from mission where hero_table=\''.$menu_list['hero_board'].'\' and ( ( DATE_FORMAT(hero_today_01_01,\'%Y-%m-%d\')<=\''.$check_day.'\' and DATE_FORMAT(hero_today_01_02,\'%Y-%m-%d\')>=\''.$check_day.'\' ) or ( DATE_FORMAT(hero_today_02_01,\'%Y-%m-%d\')<=\''.$check_day.'\' and DATE_FORMAT(hero_today_02_02,\'%Y-%m-%d\')>=\''.$check_day.'\' ) or ( DATE_FORMAT(hero_today_03_01,\'%Y-%m-%d\')<=\''.$check_day.'\' and DATE_FORMAT(hero_today_03_02,\'%Y-%m-%d\')>=\''.$check_day.'\' ) or ( DATE_FORMAT(hero_today_04_01,\'%Y-%m-%d\')<=\''.$check_day.'\' and DATE_FORMAT(hero_today_04_02,\'%Y-%m-%d\')>=\''.$check_day.'\' ) );';
		$mission_sql = 'select * from mission where hero_table=\''.$menu_list['hero_board'].'\' and ( DATE_FORMAT(hero_today_01_01,\'%Y-%m-%d\')<=\''.$check_day.'\' and DATE_FORMAT(hero_today_01_02,\'%Y-%m-%d\')>=\''.$check_day.'\' );';
		$out_mission_sql = mysql_query($mission_sql);
		$mission_count = @mysql_num_rows($out_mission_sql);
		if(!strcmp($mission_count,"0")){
			$new_img_view = "";
		}else{
			$new_img_view = " <img src='".DOMAIN_END."image/sub_new.jpg' alt='new' style='vertical-align: middle;'/>";
		}
	}


	if(!strcmp($menu_list['hero_board'],"group_04_09")){
		$board_01_sql = 'select * from board where hero_table in (\'group_04_05\', \'group_04_06\', \'group_04_07\', \'group_04_08\', \'group_04_09\') order by hero_today desc limit 0,1';
		$out_board_01_sql = @mysql_query($board_01_sql);
		$board_01_list                             = @mysql_fetch_assoc($out_board_01_sql);
		if(!strcmp(y."-".m."-".d, date( "y-m-d", strtotime($board_01_list['hero_today'])))){
			$new_img_view = "<img src='".DOMAIN_END."image/sub_new.jpg' alt='new' />";}else{$new_img_view = "";
		}
	}


	if(!strcmp($menu_list['hero_board'],"group_04_10")){
		$board_02_sql = 'select * from board where hero_today >= curdate() and hero_table in (\'group_04_05\', \'group_04_06\', \'group_04_07\', \'group_04_08\', \'group_04_09\') and hero_board_three=\'1\' or  hero_table=\'group_04_10\' order by hero_today desc limit 0,1';
		$out_board_02_sql = @mysql_query($board_02_sql);
		$board_02_list                             = @mysql_fetch_assoc($out_board_02_sql);
		if(!strcmp(y."-".m."-".d, date( "y-m-d", strtotime($board_02_list['hero_today'])))){
			$new_img_view = "<img src='".DOMAIN_END."image/sub_new.jpg' alt='new' />";}else{$new_img_view = "";
		}
	}

	$href = url($menu_list['hero_href']); //링크 경로
	//echo $herf;

	//처음에만
    if(!strcmp($count_i,'0')){

?>
				<li>
					<a href="<?=$href?>"><img src="<?=str($menu_list['hero_main'])?>" alt="<?=$menu_list['hero_top_title']?>"></a>
					<ul>
						<li><a href="<?=$href?>"> <?=$menu_list['hero_title']?>&nbsp;<?=$new_img_view?></a></li>
<?
    }else{
        if(!strcmp($group,$menu_list['hero_group'])){
?>
						<li><a href="<?=$href?>"> <?=$menu_list['hero_title']?>&nbsp;<?=$new_img_view?></a></li>
<?
        }else{
?>
					</ul>
				</li>
				<li>
					<a href="<?=$href?>"><img src="<?=str($menu_list['hero_main'])?>" alt="<?=$menu_list['hero_top_title']?>"></a>
					<ul>
						<li><a href="<?=$href?>"> <?=$menu_list['hero_title']?>&nbsp;<?=$new_img_view?></a></li>
<?
            $count_i = '0';
        }
    }
	if(!strcmp($total_i,'0')){
?>
					</ul>
				</li>
<?
    }
    $count_i++;
    $total_i--;
    $group = $menu_list['hero_group'];
}

?>

				</ul>

			</div><!-- class="gnb" -->
		</div><!-- class="top_wrap" -->
	<div class="headerbar"></div>

 </div><!-- header -->
 <div id="content">

