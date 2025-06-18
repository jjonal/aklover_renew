<?

$table = 'member';
$hero_point = '9';


if(strcmp($_POST['gender'], '')){
	$search .= ' and hero_sex = '.$_POST['gender'];
	$search_next .= '&gender='.$_POST['gender'];
}else if(strcmp($_GET['gender'], '')){
	$search .= ' and hero_sex = '.$_GET['gender'];
	$search_next .= '&gender='.$_GET['gender'];
}



if(strcmp($_POST['age'], '')){
	if($_POST['age']=='6'){
		$search .= ' and left(YEAR(CURDATE())-left(hero_jumin,4)+1,1) >= '.$_POST['age'].'';
		$search_next .= '&age='.$_POST['age'];
	}else{
		$search .= ' and left(YEAR(CURDATE())-left(hero_jumin,4)+1,1) = '.$_POST['age'].'';
		$search_next .= '&age='.$_POST['age'];
	}
}else if(strcmp($_GET['age'], '')){
	if($_GET['age']=='6'){
		$search .= ' and left(YEAR(CURDATE())-left(hero_jumin,4)+1,1) >= '.$_GET['age'].'';
		$search_next .= '&age='.$_GET['age'];
	}else{
		$search .= ' and left(YEAR(CURDATE())-left(hero_jumin,4)+1,1) = '.$_GET['age'].'';
		$search_next .= '&age='.$_GET['age'];
	}
}


if(strcmp($_POST['grade'], '')){
	$search .= ' and hero_level = '.$_POST['grade'];
	$search_next .= '&grade='.$_POST['grade'];
}else if(strcmp($_GET['grade'], '')){
	$search .= ' and hero_level = '.$_GET['grade'];
	$search_next .= '&grade='.$_GET['grade'];
}



if(strcmp($_POST['content'], '')){
	$search .= " and hero_memo_01 = '".$_POST['content']."'";
	$search_next .= '&content='.$_POST['content'];
}else if(strcmp($_GET['content'], '')){
	$search .= " and hero_memo_01 = '".$_GET['content']."'";
	$search_next .= '&content='.$_GET['content'];
}



if(strcmp($_POST['kewyword'], '')){
    $search .= ' and '.$_POST['select'].' like \'%'.$_POST['kewyword'].'%\'';
    $search_next .= '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
}else if(strcmp($_GET['kewyword'], '')){
    $search .= ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
    $search_next .= '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
}




$sql = 'select * from member where hero_level<=\''.$_SESSION['temp_level'].'\' '.$search.' and hero_use=0 ';
sql($sql);
$total_data = @mysql_num_rows($out_sql);
$list_page=100;

//2014-06-09 넘버링
if($_GET['page']){
	$j=$total_data-(($_GET['page']-1)*$list_page);
}else{
	$j=$total_data;
}

$page_per_list=10;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}

$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board']."&view=".$_GET['view'].$search_next.'&idx='.$_GET['idx'];
######################################################################################################################################################

	if(!strcmp($_GET['type'], 'edit')){
	    $post_count = @count($_POST['hero_idx']);
	    for($i=0;$i<$post_count;$i++){
	        reset($_POST);
	        unset($sql_one_update);
	        $idx = $_POST['hero_idx'][$i];
	        $data_i = '1';
	        $count = @count($_POST);
	        while(list($post_key, $post_val) = each($_POST)){
	           if(!strcmp($post_key, 'hero_idx')){
	                $data_i++;
	                continue;
	            }
	            if(!strcmp($count, $data_i)){
	                $comma = '';
	            }else{
	                $comma = ', ';
	            }
	            $sql_one_update .= $post_key.'=\''.$_POST[$post_key][$i].'\''.$comma;
	        $data_i++;
	        }
	        $sql_one_update .= ', hero_write=\''.$_POST['hero_level'][$i].'\', hero_view=\''.$_POST['hero_level'][$i].'\', hero_update=\''.$_POST['hero_level'][$i].'\', hero_rev=\''.$_POST['hero_level'][$i].'\'';
	        $sql = 'UPDATE '.$table.' SET '.$sql_one_update.' WHERE hero_idx = \''.$idx.'\';'.PHP_EOL;
	        mysql_query($sql);
	    }
	    msg('수정 되었습니다.','location.href="'.PATH_HOME.'?'.get('type','').'"');
	    exit;
	}
?>
<style>
.t_list{white-space:nowrap;}
.t_list td,tr,th{white-space:nowrap;}
.bubbleInfo {
    position: relative;
}

.popup {
    position: absolute;
    display: none; /* keeps the popup hidden if no JS available */
    background-color: white;
	border: 2px solid #dddddd;
	padding: 15px;
}
</style>

<script>



		$(function () {
			  $('.bubbleInfo').each(function () {
			    // options
			    var distance = 0;
			    var time = 10;
			    var hideDelay = 10;

			    var hideDelayTimer = null;

			    // tracker
			    var beingShown = false;
			    var shown = false;
			    
			    var trigger = $('.trigger', this);
			    var popup = $('.popup', this).css('opacity', 0);

			    // set the mouseover and mouseout on both element
			    $([trigger.get(0), popup.get(0)]).mouseover(function () {
			      // stops the hide event if we move from the trigger to the popup element
			      if (hideDelayTimer) clearTimeout(hideDelayTimer);

			      // don't trigger the animation again if we're being shown, or already visible
			      if (beingShown || shown) {
			        return;
			      } else {
			        beingShown = true;

			        // reset position of popup box
			        popup.css({
			          top: -10,
			          left: -33,
			          display: 'block' // brings the popup back in to view
			        })

			        // (we're using chaining on the popup) now animate it's opacity and position
			        .animate({
			          top: '-=' + distance + 'px',
			          opacity: 1
			        }, time, 'swing', function() {
			          // once the animation is complete, set the tracker variables
			          beingShown = false;
			          shown = true;
			        });
			      }
			    }).mouseout(function () {
			      // reset the timer if we get fired again - avoids double animations
			      if (hideDelayTimer) clearTimeout(hideDelayTimer);
			      
			      // store the timer so that it can be cleared in the mouseover if required
			      hideDelayTimer = setTimeout(function () {
			        hideDelayTimer = null;
			        popup.animate({
			          top: '-=' + distance + 'px',
			          opacity: 0
			        }, time, 'swing', function () {
			          // once the animate is complete, set the tracker variables
			          shown = false;
			          // hide the popup entirely after the effect (opacity alone doesn't do the job)
			          popup.css('display', 'none');
			        });
			      }, hideDelay);
			    });
			  });

			 	$('.popup').children(':input').click(function(){

			 		var this_val = $(this).val();
					var past_val = $(this).parent('.popup').siblings('.trigger').val();
					if($(this).prop('checked')==true){
						if(past_val!='')	$(this).parent('.popup').siblings('.trigger').val(past_val+","+this_val);
						else				$(this).parent('.popup').siblings('.trigger').val(this_val);
					}else{
						past_val = past_val.replace(","+this_val,"");
						past_val = past_val.replace(this_val+",","");
						past_val = past_val.replace(this_val,"");
						$(this).parent('.popup').siblings('.trigger').val(past_val);
					}
					
				});
			});


</script>


	<div class="searchbox" style="margin-top: 20px;background: #f2f2f2;width: 800px;border: 1px solid #D7D7D7;border-radius: 10px;">
											<div class="wrap_1" style="padding:11px 20px;">
					                            <form action="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=<?=$_GET['view']?>&idx=<?=$_GET['idx']?>" method="POST" >
					                            	<span style="font-size:12px;font-weight:800">Search</span>&nbsp;&nbsp;&nbsp;
					                            	<select name="gender" id="">
					                            		<option value=''>성별</option>
					                            		<option value='0' <?if(!strcmp($_REQUEST['gender'], '0')){echo ' selected';}else{echo '';}?>>여성</option>
					                            		<option value='1' <?if(!strcmp($_REQUEST['gender'], '1')){echo ' selected';}else{echo '';}?>>남성</option>
					                            	</select>
					                            	&nbsp;
					                            	<select name="age" id="" style="width:70px;">
					                            		<option value=''>나이</option>
					                            		<option value='1' <?if(!strcmp($_REQUEST['age'], '1')){echo ' selected';}else{echo '';}?>>10대</option>
					                            		<option value='2' <?if(!strcmp($_REQUEST['age'], '2')){echo ' selected';}else{echo '';}?>>20대</option>
					                            		<option value='3' <?if(!strcmp($_REQUEST['age'], '3')){echo ' selected';}else{echo '';}?>>30대</option>
					                            		<option value='4' <?if(!strcmp($_REQUEST['age'], '4')){echo ' selected';}else{echo '';}?>>40대</option>
					                            		<option value='5' <?if(!strcmp($_REQUEST['age'], '5')){echo ' selected';}else{echo '';}?>>50대</option>
					                            		<option value='6' <?if(!strcmp($_REQUEST['age'], '6')){echo ' selected';}else{echo '';}?>>60대 이상</option>
					                            	</select>
					                            	<select name="content" id="" style="width:70px;">
					                            		<option value=''>컨텐츠</option>
					                            		<option value='상' <?if(!strcmp($_REQUEST['content'], '상')){echo ' selected';}else{echo '';}?>>상</option>
					                            		<option value='중' <?if(!strcmp($_REQUEST['content'], '중')){echo ' selected';}else{echo '';}?>>중</option>
					                            		<option value='하' <?if(!strcmp($_REQUEST['content'], '하')){echo ' selected';}else{echo '';}?>>하</option>
					                            	</select>
					                            	
					                            	&nbsp;
					                            	등급&nbsp;<input type="text" placeholder="숫자(기자단:98)" name="grade" value="<?=$_REQUEST['grade'] ?>" style="width:90px;"/>					                            	
					                            	&nbsp;
					                            	
					                                <select name="select" id="">
		                                                  <option value="hero_nick"<?if( (!strcmp($_POST['select'], 'hero_nick')) or (!strcmp($_GET['select'], 'hero_nick')) ){echo ' selected';}else{echo '';}?>>닉네임</option>
		                                                  <option value="hero_name"<?if( (!strcmp($_POST['select'], 'hero_name')) or (!strcmp($_GET['select'], 'hero_name')) ){echo ' selected';}else{echo '';}?>>성명</option>
		                                                  <option value="hero_id"<?if( (!strcmp($_POST['select'], 'hero_id')) or (!strcmp($_GET['select'], 'hero_id')) ){echo ' selected';}else{echo '';}?>>아이디</option>
					                                </select>
					                                <input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];?>" class="kewyword">
					                                <input type="image" src="../image/bbs/btn_search.gif" alt="검색" class="bd0">
                                                    <input type="hidden" name="page" value="<?=$_REQUEST['page']?>" />
					                            </form>
					                        </div>
	</div>
	<div style="padding:20px;margin:20px;border:1px solid #DFDFDF;border-radius:5px;float:left;">
							                    <div style="padding-bottom:10px;">
							                    	<a type="button" class="btn_blue2" value="유저 정보 Download" onclick="window.open('user/download_vip.php');">다운로드</a>
		                                        	유저정보를 다운로드 받으실 수 있습니다.
							                    </div>
												
												<div>
							                    	<a href="javascript:form_next.submit();" class="btn_blue2">설정수정</a>
		                                        	페이지가 한번에 수정됩니다.
		                                        </div>
	                                        </div>
    <div style="width:100%; text-align:center; margin-top:100px;"><? include_once PATH_INC_END.'page.php';?></div>
    
    
                        <table class="t_list">
                            <thead>
                                <tr>
                                    <td colspan="12" align="center" style="padding:10px">
                                        
                                </tr>
                                <tr>
									<th width="3%">NO</th>
                                    <th width="7%">아이디</th>
                                    <th width="7%">성명</th>
                                    <th width="7%">닉네임</th>
                                    <th width="5%">총포인트</th>
                                    <th width="5%">등급</th>
                                    <th width="12%">블로그url</th>
                                    <th width="12%">인스타그램url</th>
                                    <th width="5%">블로그 컨텐츠(상,중,하)</th>
                                    <th width="5%">블로그 방문자수</th>
                                    <th width="5%">팔로워수</th>
                                    <th width="10%">블로그 타입</th>
                                    <th width="5%">페널티</th>
                                    <th width="5%">페널티</th>
                                    <th width="5%">비고</th>
                                    <th width="1%">메일수신</th>
                                    <th width="1%">핸드폰수신</th>
                                    <th width="7%">포인트확인</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form name="form_next" action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post" enctype="multipart/form-data"> 
                                

<?
if(!strcmp($_GET['order'], '')){
    $view_order = ' order by hero_oldday desc';
}else{
    $view_order = ' order by '.$_GET['order'];
}

 $sql = 'select * from '.$table.' where hero_use=0 and hero_level<=\''.$_SESSION['temp_level'].'\''.$search.$view_order.' limit '.$start.','.$list_page.';';
sql($sql);
$i = '0';
while($roll_list                             = @mysql_fetch_assoc($out_sql)){
    $point = '0';
    $user_sql = 'select hero_point from point where hero_code=\''.$roll_list['hero_code'].'\';';//desc
    $user_sql = mysql_query($user_sql);
    while($total_list                             = @mysql_fetch_assoc($user_sql)){
        $point = $point+$total_list['hero_point'];
    }
?>

                                <input type="hidden" name="hero_idx[]" value="<?=$roll_list['hero_idx']?>">
                                
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
									<td><?=$j?></td>
                                    <td><?=$roll_list['hero_id']?></td>
                                    <td><?=name_masking($roll_list['hero_name'])?></td>
                                    <td><?=$roll_list['hero_nick']?></td>
                                    <td><?=$roll_list['hero_point']?></td>
                                    <td>
                                        <select name="hero_level[]" id="hero_level[]">
<?
                                    $level_sql = 'select * from level where hero_level<=\''.$_SESSION['temp_level'].'\' order by hero_level asc;';//desc
                                    $out_level_sql = mysql_query($level_sql);
                                    while($level_list                             = @mysql_fetch_assoc($out_level_sql)){
?><option value="<?=$level_list['hero_level']?>"<?if(!strcmp($level_list['hero_level'], $roll_list['hero_level'])){echo ' selected';}else{echo '';}?>><?=$level_list['hero_name'];?></option><?
                                    }
?>
                                         </select>
                                    </td>
                                    <td><input type="text" id="hero_blog_00[]" name="hero_blog_00[]" value="<?=$roll_list['hero_blog_00'];?>" style="width:200px;height:20px;" /></td>
                                    <td><input type="text" id="hero_blog_04[]" name="hero_blog_04[]" value="<?=$roll_list['hero_blog_04'];?>" style="width:200px;height:20px;" /></td>
                                    <td><input type="text" id="hero_memo_01[]" name="hero_memo_01[]" value="<?=$roll_list['hero_memo_01'];?>" style="width:80px;height:20px;"></td>
                                    
                                    <td><input type="text" name="hero_memo[]" id="hero_memo[]" value="<?=$roll_list['hero_memo']?>" style="width:60px;height:20px;" /></td>
                                    <td><input type="text" name="hero_insta_cnt[]" value="<?=$roll_list['hero_insta_cnt']?>" style="width:30px;" /></td>
                                   <td>
                                   
                                   		<div class="bubbleInfo">
	                                    	<input class="trigger" type="text" name="hero_blog_type[]" value="<?=$roll_list['hero_blog_type']?>">
											<div class="popup">
												<?php 
													$hero_blog_type = explode(',',$roll_list['hero_blog_type']);
													$hero_blog_type_arr = array("패션","뷰티","맛집","리뷰","일상","육아","애완","공연/전시","음악/방송","연예","건강","IT","교육","상업");
													$hero_blog_type_arr_num = array();
													
													for ($blog_i = 0; $blog_i < count($hero_blog_type_arr); $blog_i++) {
														
														for ($blog_j = 0; $blog_j < count($hero_blog_type); $blog_j++) {
															if($hero_blog_type_arr[$blog_i]==$hero_blog_type[$blog_j]){
																$hero_blog_type_arr_num[$blog_i] = 1;
															}
														}
														
														
													}
												?>
											   <input type="checkbox" <?=($hero_blog_type_arr_num[0]==1)? "checked='checked'" : "";?> value='패션'>패션
											   <input type="checkbox" <?=($hero_blog_type_arr_num[1]==1)? "checked='checked'" : "";?> value='뷰티'>뷰티
											   <input type="checkbox" <?=($hero_blog_type_arr_num[2]==1)? "checked='checked'" : "";?> value='맛집'>맛집
											   <input type="checkbox" <?=($hero_blog_type_arr_num[3]==1)? "checked='checked'" : "";?> value='리뷰'>리뷰
											   <input type="checkbox" <?=($hero_blog_type_arr_num[4]==1)? "checked='checked'" : "";?> value='일상'>일상
											   <input type="checkbox" <?=($hero_blog_type_arr_num[5]==1)? "checked='checked'" : "";?> value='육아'>육아
											   <input type="checkbox" <?=($hero_blog_type_arr_num[6]==1)? "checked='checked'" : "";?> value='애완'>애완
											   <input type="checkbox" <?=($hero_blog_type_arr_num[7]==1)? "checked='checked'" : "";?> value='공연,전시'>공연/전시
											   <input type="checkbox" <?=($hero_blog_type_arr_num[8]==1)? "checked='checked'" : "";?> value='음악,방송'>음악/방송
											   <input type="checkbox" <?=($hero_blog_type_arr_num[9]==1)? "checked='checked'" : "";?> value='연예'>연예
											   <input type="checkbox" <?=($hero_blog_type_arr_num[10]==1)? "checked='checked'" : "";?> value='건강'>건강
											   <input type="checkbox" <?=($hero_blog_type_arr_num[11]==1)? "checked='checked'" : "";?> value='IT'>IT
											   <input type="checkbox" <?=($hero_blog_type_arr_num[12]==1)? "checked='checked'" : "";?> value='교육'>교육
											   <input type="checkbox" <?=($hero_blog_type_arr_num[13]==1)? "checked='checked'" : "";?> value='상업'>상업
											   
											  </div>
										</div>
                                   
                                    	

                                   		
                                    	<!--  <select class="hero_blog_type">
                                            <option value="" >선택</option>
                                            <option value="1" <?echo ($roll_list['hero_blog_type']=='1')? "selected='selected'" : "";?>>패션</option>
                                            <option value="2" <?echo ($roll_list['hero_blog_type']=='2')? "selected='selected'" : "";?>>뷰티</option>
                                            <option value="3" <?echo ($roll_list['hero_blog_type']=='3')? "selected='selected'" : "";?>>맛집</option>
                                            <option value="4" <?echo ($roll_list['hero_blog_type']=='4')? "selected='selected'" : "";?>>리뷰</option>
                                            <option value="5" <?echo ($roll_list['hero_blog_type']=='5')? "selected='selected'" : "";?>>일상</option>
                                            <option value="6" <?echo ($roll_list['hero_blog_type']=='6')? "selected='selected'" : "";?>>육아</option>
                                            <option value="7" <?echo ($roll_list['hero_blog_type']=='7')? "selected='selected'" : "";?>>애완</option>
                                            <option value="8" <?echo ($roll_list['hero_blog_type']=='8')? "selected='selected'" : "";?>>공연,전시</option>
                                            <option value="9" <?echo ($roll_list['hero_blog_type']=='9')? "selected='selected'" : "";?>>음악,방송</option>
                                            <option value="10" <?echo ($roll_list['hero_blog_type']=='10')? "selected='selected'" : "";?>>연예</option>
                                            <option value="11" <?echo ($roll_list['hero_blog_type']=='11')? "selected='selected'" : "";?>>건강</option>
                                            <option value="12" <?echo ($roll_list['hero_blog_type']=='12')? "selected='selected'" : "";?>>IT</option>
                                            <option value="13" <?echo ($roll_list['hero_blog_type']=='13')? "selected='selected'" : "";?>>교육</option>
                                            <option value="14" <?echo ($roll_list['hero_blog_type']=='14')? "selected='selected'" : "";?>>상업</option>
                                         </select>-->
                                    	
                                    </td> 
                                    <td><input type="text" id="hero_memo_02[]" name="hero_memo_02[]" value="<?=$roll_list['hero_memo_02'];?>" style="width:80px;height:20px;"></td>
                                    <td><input type="text" id="hero_memo_03[]" name="hero_memo_03[]" value="<?=$roll_list['hero_memo_03'];?>" style="width:80px;height:20px;"></td>
                                    <td><input type="text" id="hero_memo_04[]" name="hero_memo_04[]" value="<?=$roll_list['hero_memo_04'];?>" style="width:80px;height:20px;"></td>
                                    <td>
                                    	<select name="hero_chk_email[]" id="hero_chk_email[]">
                                            <option value="0" <?echo ($roll_list['hero_chk_email']==0)? "selected='selected'" : "";?>>X</option>
                                            <option value="1" <?echo ($roll_list['hero_chk_email']==1 || $roll_list['hero_chk_phone']==2)? "selected='selected'" : "";?>>O</option>
                                         </select>
                                    
                                    </td>
                                    
                                    <td>
                                    	<select name="hero_chk_phone[]" id="hero_chk_phone[]">
                                            <option value="0" <?echo ($roll_list['hero_chk_phone']==0)? "selected='selected'" : "";?>>X</option>
                                            <option value="1" <?echo ($roll_list['hero_chk_phone']==1 || $roll_list['hero_chk_phone']==2)? "selected='selected'" : "";?>>O</option>
                                         </select>
                                    </td>
                                    <td>
                                        <a href="<?=url('PATH_HOME||board||'.$board.'||&view=02_02&idx='.$_GET['idx'].'&next_page='.$_GET['page'].'&next_idx='.$roll_list['hero_idx']);?>" class="btn_blue">포인트확인</a>
                                    </td>
                                </tr>
<?
$i++;
$j--;
}
?>
                                </form>
                            </tbody>
                        </table>
