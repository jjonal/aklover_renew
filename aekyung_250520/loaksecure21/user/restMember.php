<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
if(strcmp($_POST['kewyword'], '')){
    $search .= ' and '.$_POST['select'].' like \'%'.$_POST['kewyword'].'%\'';
    $search_next .= '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
}else if(strcmp($_GET['kewyword'], '')){
    $search .= ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
    $search_next .= '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
}

if(strcmp($_POST['hero_today_start'], '') && strcmp($_POST['hero_today_end'], '')){
	$search .= " and date_format(A.hero_out_date,'%Y-%m-%d') between '".$_POST['hero_today_start']."' AND '".$_POST['hero_today_end']."'";
	$search_next .= '&hero_today_start='.$_POST['hero_today_start'].'&hero_today_end='.$_POST['hero_today_end'];
}else if(strcmp($_GET['hero_today_start'], '') && strcmp($_GET['hero_today_end'], '')){
	$search .= " and date_format(A.hero_out_date,'%Y-%m-%d') between '".$_GET['hero_today_start']."' AND '".$_GET['hero_today_end']."'";
	$search_next .= '&hero_today_start='.$_GET['hero_today_start'].'&hero_today_end='.$_GET['hero_today_end'];
}

######################################################################################################################################################
$sql = "select B.*, A.hero_out_date from member A LEFT JOIN member_backup B ON A.hero_code=B.hero_code where A.hero_use='2' ".$search." ";
//echo $sql."<br>";
sql($sql);
$total_data = @mysql_num_rows($out_sql);
######################################################################################################################################################
$list_page=50;
$page_per_list=10;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board'].$search_next.'&idx='.$_GET['idx'].'&order='.$_GET['order'];
######################################################################################################################################################
//echo $search_next;
?>
<link type='text/css' href='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.css' rel='stylesheet' />
<script type="text/javascript" src="<?=DOMAIN_END?>cal/jquery.min.js"></script>
<script type='text/javascript' src='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.min.js'></script> 
<style>
	.t_list thead th { letter-spacing: -1px; } 
</style>

						<div class="searchbox" style="margin-top: 20px;background: #f2f2f2;width: 800px;border: 1px solid #D7D7D7;border-radius: 10px;">
						  <div class="wrap_1" style="padding:11px 20px;">
                            <form action="<?=PATH_HOME.'?'.get('page');?>" method="POST" >
                            	<span style="font-size:12px;font-weight:800">Search</span>&nbsp;&nbsp;&nbsp;
        
                            	<input type="text"  id="sdate1" name="hero_today_start"  value="<?=$_REQUEST['hero_today_start']?>" style="text-align: center" /> ~ 
		                		<input type="text"  id="edate1" name="hero_today_end"  value="<?=$_REQUEST['hero_today_end']?>" style="text-align: center" />
                            
                                <select name="select" id="">
                                  <option value="B.hero_nick"<?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>닉네임</option>
                                  <option value="B.hero_name"<?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>성명</option>
                                  <option value="B.hero_id"<?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>아이디</option>
                                </select>
                                
                                <input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];?>" class="kewyword">
                                <input type="image" src="../image/bbs/btn_search.gif" alt="검색" class="bd0">
                                <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                (휴면회원등록일 기준)
                            </form>
                            <script>
								$(function() {      // window.onload 대신 쓰는 스크립트
									dateclick2();
								});
								function dateclick2(){
									var dates = $("#sdate1, #edate1").datepicker({
										monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
										dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
										defaultDate: null,
										showMonthAfterYear:true,
										dateFormat: 'yy-mm-dd',
										onSelect: function( selectedDate ) {
											var option = this.id == "sdate1" ? "minDate" : "maxDate",
											instance = $( this ).data( "datepicker" ),
											date = $.datepicker.parseDate(
												instance.settings.dateFormat ||
												$.datepicker._defaults.dateFormat,
												selectedDate, instance.settings );
											dates.not( this ).datepicker( "option", option, date );
										}
									});
								};
							</script>
                            </div>
                        </div>
                        
                        <div style="float:right">총 인원 : <span style="color:#f00"><?=number_format($total_data)?></span>명</div>
                        <div style="clear:both"></div>
                        
                        <table class="t_list">
                            
                            <thead>
                                <tr>
                                    <!--<th width="3%" class="first"><input type="checkbox" name="check_all" onclick="check_All();"/></th>-->
<!--                                    <th width="5%">번호</th>-->
                                    <th style="width:3%;"><a href="<?=PATH_HOME.'?'.get('order','order=B.hero_id desc').$search_next;?>">▼</a> 아이디 <a href="<?=PATH_HOME.'?'.get('order','order=B.hero_id asc').$search_next;?>">▲</a></th>
                                    <th style="width:3%;"><a href="<?=PATH_HOME.'?'.get('order','order=B.hero_name desc').$search_next;?>">▼</a> 성 명 <a href="<?=PATH_HOME.'?'.get('order','order=B.hero_name asc').$search_next;?>">▲</a></th>
                                    <th style="width:3%;"><a href="<?=PATH_HOME.'?'.get('order','order=B.hero_nick desc').$search_next;?>">▼</a> 닉네임 <a href="<?=PATH_HOME.'?'.get('order','order=B.hero_nick asc').$search_next;?>">▲</a></th>
                                    <th style="width:2%;"><a href="<?=PATH_HOME.'?'.get('order','order=B.hero_jumin desc').$search_next;?>">▼</a> 나이 <a href="<?=PATH_HOME.'?'.get('order','order=B.hero_jumin asc').$search_next;?>">▲</a></th>
                                    <th style="width:3%;"><a href="<?=PATH_HOME.'?'.get('order','order=B.hero_sex desc').$search_next;?>">▼</a> 성별 <a href="<?=PATH_HOME.'?'.get('order','order=B.hero_sex asc').$search_next;?>">▲</a></th>
                                    <th style="width:4%;">연락처</th>
                                    <th style="width:2%;">우편번호</th>
                                    <th style="width:6%;">주소</th>
                                    <th style="width:7%;">블로그</th>
                                    <th style="width:5%;">이메일</th>
                                    <th style="width:3%;"><a href="<?=PATH_HOME.'?'.get('order','order=B.hero_excuse_check desc').$search_next;?>">▼</a> 가입경로 <a href="<?=PATH_HOME.'?'.get('order','order=B.hero_excuse_check asc').$search_next;?>">▲</a></th>
                                    <th style="width:2%;">추천인</th>

                                   
                                    <th style="width:3%;"><a href="<?=PATH_HOME.'?'.get('order','order=B.hero_oldday desc').$search_next;?>">▼</a> 등록일 <a href="<?=PATH_HOME.'?'.get('order','order=B.hero_oldday asc').$search_next;?>">▲</a></th>
                                    <th style="width:5%;"><a href="<?=PATH_HOME.'?'.get('order','order=A.hero_out_date desc').$search_next;?>">▼</a> 휴면회원등록일 <a href="<?=PATH_HOME.'?'.get('order','order=A.hero_out_date asc').$search_next;?>">▲</a></th>
                                    <th style="width:3%;">설정</th>
                                </tr>
                            </thead>
                            <tbody>
                        <?
                        if(!strcmp($_GET['order'], '')){
                            $view_order = ' order by A.hero_out_date desc';
                        }else{
                            $view_order = ' order by '.$_GET['order'];
                        }
                        $sql = "select date_format(A.hero_out_date,'%Y-%m-%d') as hero_out_date_normal, B.* from member A LEFT JOIN member_backup B ON A.hero_code=B.hero_code";
                        $sql .= " where A.hero_use='2' ".$search.$view_order." limit ".$start.",".$list_page;
                        //echo $sql;
                        sql($sql);
                        
                        
                        while($list                             = @mysql_fetch_assoc($out_sql)){
                       
	                      
	                        
	                        if(!strcmp($list['hero_sex'], '1')){
	                            $sex = "남자";
	                        }else if(!strcmp($list['hero_sex'], '0')){
	                            if(!strcmp($list['hero_info_di'], '')){
	                                $sex = "미인증";
	                            }else{
	                                $sex = "여자";
	                            }
	                        }else{
	                            $sex = "미인증";
	                        }
							if($list['area']) {
								$excuse_check = $list['area'];
							}else {
								if(!strcmp($list['hero_excuse_check'], '0')){
									$excuse_check="신문";
								}else if(!strcmp($list['hero_excuse_check'], '1')){
									$excuse_check="잡지";
								}else if(!strcmp($list['hero_excuse_check'], '2')){
									$excuse_check="블로그";
								}else if(!strcmp($list['hero_excuse_check'], '3')){
									$excuse_check="카페";
								}else if(!strcmp($list['hero_excuse_check'], '4')){
									$excuse_check="지인";
								}else if(!strcmp($list['hero_excuse_check'], '5')){
									$excuse_check="기타<br>".$list['hero_excuse_path'];
								}
							}
								
	                        
	                        if(!strcmp($list['hero_jumin'], '')){
	                            $jumin = "미인증";
	                        }else if(!strcmp($list['hero_jumin'], '00000000')){
	                            $jumin = "미인증";
	                        }else{
	                            $jumin = Y-substr($list['hero_jumin'],0,4)+1;
	                        }
	                        ?>
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
<!--                                <td><?=in($list['hero_idx']);?></td>-->
                                    <td><?=$list['hero_id'];?></td>
                                    <td><?=name_masking($list['hero_name']);?></td>
                                    <td><?=$list['hero_nick'];?></td>

                                    <td><?=$jumin;?></td>
                                    <td><?=$sex;?></td>
                                   
                                    <td><?=phone_masking($list['hero_hp']);?></td>
                                    <td><?=$list['hero_address_01'];?></td>
                                    <td><?=$list['hero_address_02'];?> <?=$list['hero_address_03'];?></td>
                                    <td>
                                    	<? echo ($list['hero_blog_00']) ? $list['hero_blog_00']."<br>" : '';?>
                                    	<? echo ($list['hero_blog_01']) ? $list['hero_blog_00']."<br>" : '';?>
                                    	<? echo ($list['hero_blog_02']) ? $list['hero_blog_00']."<br>" : '';?>
                                    	<? echo ($list['hero_blog_03']) ? $list['hero_blog_00']."<br>" : '';?>
                                    	<? echo ($list['hero_blog_04']) ? $list['hero_blog_00']."<br>" : '';?>
                                    	<? echo ($list['hero_blog_05']) ? $list['hero_blog_00']."<br>" : '';?>
                                    </td>
                                    <td><?=$list['hero_mail'];?></td>
                                    <td><?=$excuse_check;?></td>
									<td><?=$list['hero_user']; ?></td>
                                    <td><?=date( "Y-m-d", strtotime($list['hero_oldday']));?></td>
                                    <td><?=$list['hero_out_date_normal'];?></td>
                                    <td><a href="#" onclick="location.href='<?=url('PATH_HOME||board||'.$board.'||&view=restMemberView&idx='.$_GET['idx'].'&next_idx='.$list['hero_idx']);?>'" style="cursor:pointer;" class="btn_blue">상세페이지</a></td>
                                </tr>
                                
                        <?
                        }
                        ?>
                            </tbody>
                        </table>
                        <div style="width:100%; text-align:center; margin-top:20px;">
<? include_once PATH_INC_END.'page.php';?>
                        </div>
<? //include_once BOARD_INC_END.'search.php';?>
                        
                        <?php 
                        //echo $sql;
                        ?>