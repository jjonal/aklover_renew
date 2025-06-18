<link rel="stylesheet" type="text/css" href="/css/front/cscenter.css" />
<link rel="stylesheet" type="text/css" href="/css/front/review.css" />
<?
if(!defined('_HEROBOARD_'))exit;

$cut_count_name = '6';
$cut_title_name = '23';

if(strcmp($_POST['kewyword'], '')){
    $search = ' and '.$_POST['select'].' like \'%'.$_POST['kewyword'].'%\'';
    $search_next = '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
}else if(strcmp($_GET['kewyword'], '')){
    $search = ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
    $search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
}
######################################################################################################################################################
$sql = 'select * from board where hero_01=\''.$_GET['idx'].'\' and hero_board_three=\'1\' and hero_table=\''.$_GET['board'].'\''.$search.';';
sql($sql);
$total_data = @mysql_num_rows($out_sql);
######################################################################################################################################################
$list_page=6;
$page_per_list=10;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board']."&view=".$_GET['view']."&idx=".$_GET['idx'].$search_next;
######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);
######################################################################################################################################################
?>

<div id="subpage" class="cscenter reviewpage">
	<div class="sub_title">
		<div class="sub_wrap">
			<div class="f_b">
				<div>
					<h1 class="fz68 main_c fw500 ko">						
						후기 확인
					</h1>
				</div>
			</div>
		</div>
	</div>
	<div class="sub_cont">
		<div class="sub_wrap board_wrap">
			<div class="contents rel">
				<div class="support_review">
					<ul class="review_list grid_4">
						<?
						if($_GET['best']) {
							$sql = 'select * from board where hero_board_three=1 and hero_01=\''.$_GET['idx'].'\' and hero_table=\''.$_GET['board'].'\''.$search.';';
						}else {
							$sql = 'select * from board where hero_01=\''.$_GET['idx'].'\' and hero_table=\''.$_GET['board'].'\''.$search.';';
						}
						sql($sql);
						$total_data = @mysql_num_rows($out_sql);
						//select * from board where hero_01='10' and hero_board_three='1' and hero_table='group_04_05' order by hero_today desc limit 16,8; 
						//select * from board where hero_01='10' and hero_table='group_04_05' order by hero_today desc limit 16,8;
						if($_GET['best']) {
							$sql = 'select * from board where hero_board_three=1 and hero_01=\''.$_GET['idx'].'\' and hero_table=\''.$_GET['board'].'\''.$search.' order by hero_today desc limit '.$start.','.$list_page.';';
						}else {
							$sql = 'select * from board where hero_01=\''.$_GET['idx'].'\' and hero_table=\''.$_GET['board'].'\''.$search.' order by hero_today desc limit '.$start.','.$list_page.';';
						}
//                        echo $sql;

						sql($sql, 'on');
						$data_count = mysql_num_rows($out_sql);
						$view_count = '4';
						//echo floor($data_count/$view_count);

						$i = '1';
						$dd = '1';
						$total_chack = $data_count;

						$cut_title_name = '8';
						$cut_command_name = '100';
						while($list                             = @mysql_fetch_assoc($out_sql)){
							$img_parser_url = @parse_url($list['hero_img_new']);
							$img_host = $img_parser_url['host'];
							
							$pk_sql = 'select a.hero_level,a.hero_nick,b.hero_img_new, a.hero_profile from member as a, level as b  where b.hero_level = a.hero_level and a.hero_code = \''.$list['hero_code'].'\'';
							//echo $pk_sql;
							$out_pk_sql = mysql_query($pk_sql);
							$pk_row = @mysql_fetch_assoc($out_pk_sql);

                            if(empty($pk_row['hero_profile'])){
                                $hero_profile = "/img/front/mypage/defalt.webp";
                            }else {
                                $hero_profile = $pk_row['hero_profile'];
                            }

                            if (strcmp($dd,'3')){
                                echo '                    <li>'.PHP_EOL;
                            }else if(!strcmp($dd,'3')){
                                echo '                    <li class="last">'.PHP_EOL;
                                $dd = '0';
                            }
                            if(!strcmp($list['hero_img_new'],'')){
                                $view_img = IMAGE_END.'hero.jpg';
                            }else if(!strcmp($img_host,'')){
                                $view_img = IMAGE_END.'hero.jpg';
                            }else if(!strcmp($img_host,$HTTP_SERVER_VARS['HTTP_HOST'])){
                                $view_img = $list['hero_img_new'];
                        //        $view_img = USER_PHOTO_END.$list['hero_img_new'];
                            }else if(!strcmp(eregi('naver',$img_host),'1')){
                                $view_img = IMAGE_END.'hero.jpg';
                            }else{
                                $view_img = $list['hero_img_new'];
                            }

                            if($list["hero_thumb"]) $view_img = $list['hero_thumb'];

                            if($list['hero_04']) {
                                $link="<a href=http://aklover.co.kr/main/index.php?board=".$list['hero_table']."&page=".$page."&view=view2&idx=".$list['hero_idx']." target='_blank'>";
                            } else if($list['youtube_url'] || $list['blog_url'] || $list['cafe_url'] || $list['sns_url'] || $list['etc_url']) {
                                $link="<a href=http://aklover.co.kr/main/index.php?board=".$list['hero_table']."&page=".$page."&view=view2&idx=".$list['hero_idx']." target='_blank'>";
                            } else if($list["hero_table"] == "group_04_05" || $list["hero_table"] == "group_04_06" || $list["hero_table"] == "group_04_27" || $list["hero_table"] == "group_04_28") {
                                $link="<a href=/main/index.php?board=".$list['hero_table']."&page=".$page."&view=view2&idx=".$list['hero_idx']." target='_blank'>";
                            } else {
                                $link="<a href=".PATH_HOME."?board=group_04_09&page=".$page."&view=view&idx=".$list['hero_idx'].">";
                            }
							
							if(!strcmp(y."-".m."-".d, date( "y-m-d", strtotime($list['hero_today'])))){
							//    $new_img_view = "<img src='".DOMAIN_END."image/main_new_bt.png' width='13px' height='13px' alt='new' /> ";
								$new_img_view = " style='background:url(".DOMAIN_END."image/main_new_bt.png) no-repeat 0 2px;'";
							}else{
								$new_img_view = "style='background:url(../image/common/ico_main_dot.gif) no-repeat 0 2px;'";
							}
							$content = $list['hero_command'];
							$content = TRIM(str_ireplace('&nbsp;', '', strip_tags(htmlspecialchars_decode($content))));
							$content = str_replace("\r", "", $content);
							$content = str_replace("\n", "", $content);
							$content = str_replace("&#65279;", "", $content);
							$content_01 = cut($content,'50');
							$new_content="제목:".$list['hero_title']."\n\n작성일:".date( "Y-m-d", strtotime($list['hero_today']))."\n\n작성자:".$list['hero_nick'];
	        						echo '                        <div class="rel cont_wrap" title="'.$new_content.'" align="center">'.PHP_EOL;
									// echo '                        '.$link.PHP_EOL;
									echo '                            <img src="'.$view_img.'" alt="" class="thum_img">'.PHP_EOL;
									echo '                            <div class="txt_bx"><span class="nick"><img src="'.$hero_profile.'"/>'.$list['hero_nick'].'</span>'.PHP_EOL;
									echo '                            <span class="title ellipsis_3line">'.cut($list['hero_title'], $cut_title_name).'</span></div>'.PHP_EOL;
									// echo '                        </a>'.PHP_EOL;
									echo '                        </div>'.PHP_EOL;
									echo '                    <div class="sns_btn_group f_c">'.PHP_EOL;


                                    $url_sql = "select gubun, url from mission_url where board_hero_idx = '".$list['hero_idx']."'";
                                    $url_res = new_sql($url_sql, $error);
//                                    echo $url_sql;
                                    while($url_list = mysql_fetch_assoc($url_res)){
                                        if($url_list['gubun'] == 'insta') {
                                            echo "<a href='".$url_list['url']."' target='_blank' class='btnLink insta'><span></span><p>인스타그램</p></a>";
                                        }
                                        if($url_list['gubun'] == 'naver') {
                                            echo "<a href='".$url_list['url']."' target='_blank' class='btnLink blog'><span></span><p>블로그</p></a>";
                                        }
                                        if($url_list['gubun'] == 'movie') {
                                            echo "<a href='".$url_list['url']."' target='_blank' class='btnLink etc'><span></span><p>유튜브</p></a>";
                                        }
                                        if($url_list['gubun'] == 'etc') {
                                            echo "<a href='".$url_list['url']."' target='_blank' class='btnLink etc'><span></span><p>기타</p></a>";
                                        }
                                    }

									echo '                    </div></li>'.PHP_EOL;
							$i++;
							$dd++;
							$total_chack--;
												}
						?>
					</ul>					
					<!-- 후기없을때 s -->
					<ul>
						<li class="fz22 bold t_c none_review">선정된 서포터즈 분들이 제품을 체험하고 있어요.<br>
						솔직하고 행복한 후기 함께 기다려요!</li>
					</ul>
					<!-- 후기없을때 e -->
				</div>
				<div class="btngroup">
					<div class="btn_l">
					</div>
					<div class="paging">
						<? 
						echo page($total_data,$list_page,$page_per_list,$_GET[page],$next_path);
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>