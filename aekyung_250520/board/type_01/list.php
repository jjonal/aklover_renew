<link rel="stylesheet" type="text/css" href="/css/front/lovertalk.css" />
<link rel="stylesheet" type="text/css" href="/css/front/cscenter.css" />
<script type="text/javascript" src="/js/musign/board.js"></script>
<?
if(!defined('_HEROBOARD_'))exit;

if(!strcmp($_GET['type'], 'drop')){
	$post_count = @count($_POST['hero_drop']);
	for($i=0;$i<$post_count;$i++){
		$review_sql = 'select * from review WHERE hero_old_idx = \''.$_POST['hero_drop'][$i].'\';';
		$out_review = @mysql_query($review_sql);
		
		$review_drop_sql = 'DELETE FROM review WHERE hero_old_idx = \''.$_POST['hero_drop'][$i].'\';';
		@mysql_query($review_drop_sql);
		$board_select_sql = 'select * from board WHERE hero_idx=\''.$_POST['hero_drop'][$i].'\';';
		$out_board_select = @mysql_query($board_select_sql);
		$board_select_list                             = @mysql_fetch_assoc($out_board_select);
	
		$drop_action_img = $board_select_list['hero_command'];
		$code_main_value = "&lt;img.*src=&quot;(.*)&quot;.*&gt;";
		preg_match_all("`$code_main_value`iU", $drop_action_img, $code_main);
		while(list($code_key, $code_val) = @each($code_main[1])){
			if(!strcmp(eregi(USER_PHOTO_END,$code_val),'1')){
				$check_file = @str_ireplace(USER_PHOTO_END, USER_PHOTO_INC_END, $code_val);
			}else{
				continue;
			}
		}

		pointDel($_POST['hero_drop'][$i], $_GET['board'], "write"); //���μ��� ���� �ش� ����Ʈ ���� -> �ش� �� ����

		$recommand_drop_sql = 'DELETE FROM hero_recommand WHERE hero_board_idx = \''.$_REQUEST['hero_drop'][$i].'\';';
		@mysql_query($recommand_drop_sql);
		
		$recommand_drop_sql = 'DELETE FROM review WHERE hero_old_idx = \''.$_POST['hero_drop'][$i].'\';';
		@mysql_query($recommand_drop_sql);
		
		$board_drop_sql = 'DELETE FROM board WHERE hero_idx = \''.$_POST['hero_drop'][$i].'\';';
		@mysql_query($board_drop_sql);
	}
	$msg = '���� �Ǿ����ϴ�.';
	$get_herf = get('next_board||view||action||idx||page||type','','');
	$action_href = PATH_HOME.'?'.$get_herf;
	msg($msg,'location.href="'.$action_href.'"');
}

$cut_count_name = 	'6';				//�ִ� �̸� ���ڼ�
$cut_title_name = 	'120';				//�ִ� ���� ���ڼ�
$list_page		=	15;					//���������� ������ �ۼ�
$page_per_list 	=	10;					//paging number

$board 			=	$_GET['board']; 

$today = time(date('Y-m-d'));
$week = date("w");
$week_first = $today-($week*86400); 	//�̹� ���� ù���� �Ͽ���
$week_last = $week_first+(7*86400); 	//�̹� ���� ���������� �����

$week_first = date("Y-m-d",$week_first);
$week_last = date("Y-m-d",$week_last);

if(!$_GET['page'])			$page = '1';
else						$page = $_GET['page'];

$hero_keywords = "";
if($_POST['kewyword']){
	$keyword = $_POST['kewyword'];
	$select = $_POST['select'];
}
else{
	$keyword = $_GET['kewyword'];
	$select = $_GET['select'];
	$hero_keywords = $_GET['hero_keywords'];
}

if($keyword){
	if($select == "hero_all") {
		$search_a = " and (A.hero_title like '%".$keyword."%' or A.hero_command like '%".$keyword."%')";
		$search = " and (hero_title like '%".$keyword."%' or hero_command like '%".$keyword."%')";
	}else {
		$search_a = " and A.".$select." like '%".$keyword."%'";
		$search = " and ".$select." like '%".$keyword."%'";
	}
	$search_next = '&select='.$select.'&kewyword='.stripslashes($keyword);
}

if($hero_keywords) {
	$search_a .= " and A.hero_keywords  = '".$hero_keywords."' ";
	$search .= " and hero_keywords  = '".$hero_keywords."' ";
	$search_next .= "&hero_keywords=".$hero_keywords;
}

$gubun = "";
if($board == "group_02_02") { //������ ���
	$gubun_arr = array("1"=>"�ϻ�","2"=>"ü���","3"=>"����");
} else if($board == "group_04_24") { // �����
	$gubun_arr = array("1"=>"�ʵ�","2"=>"��α�","3"=>"�ν�Ÿ","4"=>"��Ʃ��&����");
	$hero_keywords_arr = array("1"=>"����","2"=>"Ȱ��","3"=>"���� TIP","4"=>"��ü TIP");
}

if($_GET["gubun"]) { 	
	$search_a .= " AND gubun = '".$_GET["gubun"]."' ";
	$search .= " AND gubun = '".$_GET["gubun"]."' ";
	$search_next .= "&gubun=".$_GET["gubun"];
}

//�ѹ���
$start 		= ($page-1)*$list_page;
$next_path 	= "board=".$board.$search_next;

if($_SESSION['temp_level']<9999)	$hero_use="and hero_use=1 "; //�ӽñ� ���� ����

//��ü ������
$sql  = " SELECT count(A.hero_idx) as count, B.recom_count from board A, (select count(hero_code) as recom_count from (select hero_code from board where hero_rec!='0' and hero_table='".$_GET['board']."' and LEFT(hero_today,10) between '".$week_first."' and '".$week_last."' order by hero_rec desc limit 0,3) C) B ";
$sql .= " WHERE hero_notice_use = 0 AND hero_table='".$_GET['board']."' ".$hero_use." ".$search." order by A.hero_notice desc, A.hero_idx desc ";
$sql_res = mysql_query($sql) or die("<script>alert('�ý��� ����, �ٽ� �õ����ֽñ� �ٶ��ϴ�. �����ڵ� - TODAY_01'); location.href='/main/index.php';</script>");
$sql_rs = mysql_fetch_assoc($sql_res);
$total_data = $sql_rs['count']+$sql_rs['recom_count'];

//������ Ÿ��Ʋ 
$sql = "select * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$_GET['board']."'";//desc
$sql_res = mysql_query($sql) or die("<script>alert('�ý��� ����, �ٽ� �õ����ֽñ� �ٶ��ϴ�. �����ڵ� - TODAY_02');location.href='/main/index.php';</script>");
$right_list = mysql_fetch_assoc($sql_res);

//����Ʈ ����üũ
$my_view 	=	$_SESSION ['temp_view'] == '' ? '0' : $_SESSION ['temp_view'];
if($my_view != '9999' && $my_view != '10000'){
	if($my_view < $right_list['hero_list']) {
		error_historyBack("�˼��մϴ�. ������ �����ϴ�.");
		exit;
	}
}

$sql = "";
if($board == "group_04_03") {
	$sql .= "select A.* from (select * from board where hero_table='hero' and hero_order = 0 ".$hero_use." order by hero_today desc) A ";
	$sql .= "union ";	
}
$sql .= "SELECT C.* from (SELECT * FROM board WHERE hero_notice_use = 0 AND hero_table='".$_GET['board']."' ".$hero_use." ".$search." order by hero_today desc limit ".$start.",".$list_page.") C";
//echo $sql;
$sql_res = mysql_query($sql) or die("<script>alert('�ý��� ����, �����ڿ��� ���� ��Ź�帳�ϴ�. �����ڵ� - TODAY_03');location.href='/main/index.php';</script>");

//$recommand_i=1;	//��õ ���� ������ ��������
$num = $total_data - $sql_rs['recom_count'] - $start;

if($board == "group_02_02" || $board == "group_04_24") { //�޴��� ����
	$sql_notice  = " SELECT hero_idx, hero_title, gubun, hero_nick, hero_today, hero_03, hero_keywords, hero_use FROM board ";
	$sql_notice .= " WHERE hero_notice_use = 1 AND hero_table='".$_GET['board']."' ".$hero_use." ORDER BY hero_idx DESC "; 
	$sql_notice_res = mysql_query($sql_notice);
}
?>

<div id="subpage" class="cscenter">
	<div class="sub_title">
		<div class="sub_wrap">
			<? if($board=='group_02_02'){ //������?>
			<div class="f_b">
				<h1 class="fz86 main_c en">Lover <span class="fz68 fw500">��</span></h1>
			</div>
			<p class="fz18 fw600">�����е��� ������ ���̵��� Ȱ�� �̾߱⸦ �����غ�����!</p>			
			<? } ?>
		</div>
    </div>
	<div class="sub_cont lovertalk">
        <div class="sub_wrap board_wrap f_sb">
			<div class="left">
                <div class="caution">
                    <h3 class="fz24 bold">Lover �� ���ǻ���</h3>
                    <div>
						<p class="fz14 first">
							AK Lover ȸ���е��� ������ �ǰ߰� �������� ��<br />
							�ϻ� �̾߱⸦ �����Ӱ� ������ �����Դϴ�.<br />
							���θ� ����ϰ� �����ϴ� Lover �е��� ���� ��Ź�帳�ϴ�.
						</p>
						<p class="fz14">
							- ����/��ġ ���� ��/��� ����<br />
							- �������̰� ���Ǿ���(5�� �̳�) ��/��� ���� ����<br />
							- ������ ������� ��� ����<br />
							- �弳, ���� �� Ÿ�ο��� ���ظ� �ִ� ��/��� ����<br />
						</p>
						<p class="warn fz14 main_c">
							��Lover�� ���ǻ����� ���ؼ� �Ͻô� ���, ���뺸 ���� �Ǵ�<br /> 
							������(����Ʈ ������, ���� Ż�� ��)�� ���� �� ������<br /> 
							�ݵ�� ���ǻ����� �ؼ����ּ���.
						</p>    
                    </div>
                </div>				
				<? include_once BOARD_INC_END.'search.php';?>
            </div>
		<div class="contents right">

		<div class="best_qna">
			<div class="swiper-container best_qna_slide">
				<div class="swiper-wrapper">
					<!-- <?if($board == "group_02_02") { 
						while($hero_notice_list = mysql_fetch_assoc($sql_notice_res)){ ?>
						<div class="swiper-slide">
							<div class="f_cs">							
								<img src="/img/front/board/faq01.png"alt="������" class="icon">
								<div class="quest" style="width: 80%;">
									<span>�ʵ�</span>
									<div class="ellipsis_100 fw600 fz20" onclick="location.href='<?=PATH_HOME;?>?board=<?=$hero_notice_list['hero_03']?>&next_board=<?=$hero_notice_list['hero_03']?>&page=<?=$page?>&view=view&idx=<?=$hero_notice_list['hero_idx'];?>&gubun=<?=$_GET['gubun'];?>'" style="cursor:pointer;">
									<? if($hero_notice_list["hero_use"] == "2") {?>[�ӽñ�]<?}?>									
									<?=cut($hero_notice_list['hero_title'], $cut_title_name);?> <?=$re_count_total.$new_img_view?>
									</div>
									<p class="fz13 op05 date dis-no"><?=date( "Y.m.d", strtotime($hero_notice_list['hero_today']));?></p>
								</div>
							</div>
						</div>
					<? }
					}?>   -->

					<?if($board == "group_02_02"){
                        $sql = 'select * from board where hero_table=\'hero\' and hero_order =\'0\' and hero_notice_use = \'0\' '.$hero_use.' order by hero_today desc;';
                        sql($sql);
                        while($hero_list = @mysql_fetch_assoc($out_sql)){
                            ?>
                            <div class="swiper-slide">
                                <div>
                                    <a class="f_cs" href="<?=PATH_HOME;?>?board=<?=$_GET['board']?>&next_board=hero&page=<?=$page?>&view=view&idx=<?=$hero_list['hero_idx'];?>">
                                        <!--!!!!!!!! [���߿�û] ������ ������ ���� �ʿ� !!!!!!!!  -->
                                        <img src="/img/front/board/faq01.png"alt="������" class="icon">
                                        <div class="quest" style="width: 80%;">
                                            <!-- <span><?=$gubun_arr[$hero_notice_list['gubun']]?></span> -->
                                            <span>�ʵ�</span>
                                            <div class="ellipsis_100 fw600 fz20" style="cursor:pointer;">
                                                <?=cut($hero_list['hero_title'], $cut_title_name);?> <?=$re_count_total.$new_img_view?>
                                            </div>
                                            <p class="fz13 op05 date dis-no"><?=date( "Y.m.d", strtotime($hero_notice_list['hero_today']));?></p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <?
                        }
                        ?>
					<? } ?>  
				</div>                                    
				<div class="rel swbtn_wrap">   
					<div class="swbtn swiper-button-prev"></div>
					<div class="swbtn swiper-button-next"></div>                        
					<div class="swiper-pagination"></div>
				</div>  
			</div>
		</div>	
		<div class="rel">
			<? if($board=='group_02_02'){ //������?>
				<div class="boardTabMenuWrap colorType">
					<a href="<?=PATH_HOME?>?board=<?=$_GET["board"]?>" <?if(!$_GET["gubun"]) {?>class="on"<?}?>>��ü</a>
					<a href="<?=PATH_HOME?>?board=<?=$_GET["board"]?>&gubun=3" <?if($_GET["gubun"] == "3") {?>class="on"<?}?>>��ǰ ����</a>
					<a href="<?=PATH_HOME?>?board=<?=$_GET["board"]?>&gubun=2" <?if($_GET["gubun"] == "2") {?>class="on"<?}?>>ü���&��������</a>
					<a href="<?=PATH_HOME?>?board=<?=$_GET["board"]?>&gubun=1" <?if($_GET["gubun"] == "1") {?>class="on"<?}?>>�ϻ� ����</a>
				</div>
			<? } ?>
			<div class="table_wrap">
				<? while($hero_list = mysql_fetch_assoc($sql_res)){
						$main_review_sql_01 = 'select hero_idx from review where hero_old_idx=\''.$hero_list['hero_idx'].'\'';
						$out_main_review_sql_01 = @mysql_query($main_review_sql_01);
						$main_review_data_01 = @mysql_num_rows($out_main_review_sql_01);
						if(strcmp($main_review_data_01, '0')){
							$re_count_total = "$main_review_data_01";
						}else{
							$re_count_total = "";
						}

						$pk_sql = 'select a.hero_level,left(a.hero_nick,7) as hero_nick, b.hero_img_new, a.hero_profile from member as a, level as b  where b.hero_level = a.hero_level and a.hero_code = \''.$hero_list['hero_code'].'\'';
						$out_pk_sql = mysql_query($pk_sql);
						$pk_row                             = @mysql_fetch_assoc($out_pk_sql);
                        if(empty($pk_row['hero_profile'])){
                            $hero_profile = "/img/front/mypage/defalt.webp";
                        }else {
                            $hero_profile = $pk_row['hero_profile'];
                        }
					
						if(!strcmp(y."-".m."-".d, date( "y-m-d", strtotime($hero_list['hero_today'])))){
							$new_img_view = " <img src='".DOMAIN_END."image/sub_new.jpg' alt='new' />";
						}else{
							$new_img_view = "";
						}
				?>
				<form name="form_next" action="<?=PATH_HOME.'?'.get('','type=drop');?>" method="post" enctype="multipart/form-data">
					<div class="table_list">
						<div class="f_sb">
							<div class="cont f_sc">
								<?if($_SESSION['temp_level']>='9999'){?>
									<div class="input_chk"> 
										<input type="checkbox" id="checknum_<?=$hero_list['hero_idx']?>" name="hero_drop[]" value="<?=$hero_list['hero_idx']?>">
										<label for="checknum_<?=$hero_list['hero_idx']?>" class="input_chk_label"></label>
									</div>
								<?}?>
								<img src="<?=$hero_profile?>" alt="aklover" class="profile">
								<div class="list">
									<div class="f_cs nick_cate">										
										<span class="fz14 gray07"><?=$pk_row['hero_nick']?></span>
										<span class="fz14 gray07 mu_bar"><?=$gubun_arr[$hero_list['gubun']]?></span>
									</div>
									<div class="tit_bx" onclick="location.href='<?=PATH_HOME;?>?board=<?=$hero_list['hero_03']?>&next_board=<?=$hero_list['hero_03']?>&page=<?=$page?>&view=view&idx=<?=$hero_list['hero_idx'];?>&gubun=<?=$_GET['gubun'];?>'" style="cursor:pointer;">
										<?if($hero_list["hero_use"]=="2"){?>[�ӽñ�]<?}?>
										<? if($board == "group_04_24" && $hero_list['hero_keywords']){?>
											<!-- <span class="txt_hero_keywords">[<?=$hero_keywords_arr[$hero_list['hero_keywords']]?>]</span> -->
										<? } ?>
										<!-- ���� -->		
										<? //new �̹���
											if(!strcmp(y."-".m."-".d, date( "y-m-d", strtotime($hero_list['hero_today'])))) $new_img_view = "<span class='fz14 main_c'>new</span>";
											else $new_img_view = "";
										?>
                                        <?
                                        if($re_count_total>0)   $rev_count = "<font color='orange'>&nbsp;[".$re_count_total."]</font>";
                                        else                    $rev_count = "";
                                        ?>
                                        <p class="fz18 tit"><?=cut($hero_list['hero_title'], $cut_title_name).$rev_count;?><?=$new_img_view?></p>
<!--                                        <p class="fz18 tit">--><?php //=cut($hero_list['hero_title'], $cut_title_name).$$rev_count;?><!----><?php //=$new_img_view?><!--</p>-->
										<!--!!!!!!!! [���߿�û] ���� ���� ���� [��]!!!!!!!!  -->
										<div class="desc ellipsis_2line fz14 gray07">
                                            <?
                                                //p�±� ����
                                                $hero_command = htmlspecialchars_decode($hero_list['hero_command']);
                                                $hero_command = str_replace('<p>','',$hero_command);
                                                $hero_command = str_replace('</p>','',$hero_command);
                                                //echo $hero_command;
                                            ?>
										</div>
<!--										<div class="reply_c fz14">��� --><?php //=$re_count_total?><!--</div>-->
									</div>
								</div>
							</div>							
							<span class="fz14 op05"><?=date( "Y.m.d", strtotime($hero_list['hero_today']));?></span>
						</div>
					</div>
				<?}?>
				</form>
			</div>
			<div class="custom_btn">							
				<?if($_SESSION['temp_level']>='9999'){?>
					<a href="javascript:form_next.submit();" class="btn_del btn_submit btn_white fz15 fw500 small">�� �����ϱ�</a>
				<?}?>	
				<? include_once BOARD_INC_END.'button.php';?>
			</div>
		</div>
		</div>	
	</div>
</div>

<!-- </div> -->