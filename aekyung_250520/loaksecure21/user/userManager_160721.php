<?php 
if(!defined('_HEROBOARD_'))exit;
?>

<?php 
include_once '../combined/admin_user_manager.php';	

$count_sql = "select count(*) as count from member as A ";
$count_sql .= "left outer join (select hero_code, sum(hero_point) as hero_possible from point where hero_today > '2014-09-10 22:23:32' ".$search_condition_02." group by hero_code) as B on A.hero_code=B.hero_code ";
$count_sql .= "left outer join (select hero_code, sum(hero_point) as hero_total from point where 1=1 ".$search_condition_02." group by hero_code) as C on A.hero_code=C.hero_code ";
$count_sql .= "left outer join (select hero_code from board WHERE hero_today>='".$oneMonthAgo."' group by hero_code) as D on D.hero_code = A.hero_code ";
$count_sql .= "where A.hero_use=0 ".$search_condition;
//echo "<script>console.log(\"".$count_sql."\")</script>";
//echo $count_sql;
$count_res = mysql_query($count_sql) or die("<script>alert('시스템에러입니다. 다시 시도해주세요. 반복될 경우 개발자에게 문의해 주세요. ERROR_CODE : USERMANAGER_01');</script>");
$count_rs = mysql_fetch_assoc($count_res);

$total_data = $count_rs['count'];
//echo $total_data;
if($_POST['page']!=''){
	$NO = $total_data-(($_POST['page']-1)*$list_page);
	$page = $_POST['page'];

}else{
	$page = '1';
	$NO = $total_data;
}

$start = ($page-1)*$list_page;

$next_path="board=".$_POST['board']."&view=".$_POST['view'].$search_next.'&idx='.$_POST['idx'];

?>

    <link rel="stylesheet" type="text/css" href="<?=CSS_END;?>general.css"/>
    <link rel="stylesheet" type="text/css" href="<?=PATH_END?>css/admin_login.css" />
    <link rel="stylesheet" href="<?=PATH_END?>css/admin.css" type="text/css" />
    <script type="text/javascript" src="<?=JS_END;?>jquery.min.js"></script>
    <script type="text/javascript" src="<?=JS_END;?>head.js"></script>
    <script>

    	$(document).ready(function(){

			$('#searchArea input').bind('keypress', function(e) {
				if(e.keyCode==13)	frm_submit();
			});

			//alert("페이지 점검 중입니다. 필요하신 정보가 있으시면 010-8941-1465로 연락부탁드립니다.");
    		
        });

		function ch_order(order){
			if(order!='')		$('#order').val(order);
			frm_submit();
		}

		function ch_page(page){
			if(page!='')		$('#page').val(page);
			frm_submit();
		}
        
		function frm_submit(order){

			document.frm.submit();

		}

		function frm_print(){
			$('#frm').prop('action',"/admin/user/download_user.php");
			$('#frm').submit();
			$('#frm').prop('action',"<?=$_SERVER['PHP_SELF']."?"."board=".$_GET['board']."&idx=".$_GET['idx']?>");
		}
		
    </script>

    
    <div id="searchArea">
	    <form method="POST" id="frm" name="frm" action="<?=$_SERVER['PHP_SELF']."?"."board=".$_GET['board']."&idx=".$_GET['idx']?>">
    	<input type="hidden" name="mode" value="search">
    	<input type="hidden" name="order" id="order" value="<?=$_POST['order'] ?>">
    	<input type="hidden" name="page" id="page" value="<?=$page ?>">
    	<table>
    		<tr>
    			<th>아이디</th>
    			<td><input name="user_id" type="text" value="<?=$user_id?>"></td>
    			<th>닉네임</th>
    			<td><input name="user_nick" type="text" value="<?=$user_nick?>"></td>
    			<th>이름</th>
    			<td><input name="user_name" type="text" value="<?=$user_name?>"></td>
				<th rowspan=3 style="border-left:1px solid #dddddd;">포인트</th>
    			<td>점수별 조회</td>   			
    			<td><input class="userManager_sch_text_03" name="user_point_bypoint[]" value="<?=$user_point_bypoint[0];?>" type="text">  ~  <input class="userManager_sch_text_03" name="user_point_bypoint[]" type="text" value="<?=$user_point_bypoint[1];?>"></td>
    		</tr>
    		<tr>
    			<th>레벨</th>
    			<td>
    				<input class="userManager_sch_text_02" name="user_level[]" type="text" value="<?=$user_level[0]?>">  ~  <input class="userManager_sch_text_02" name="user_level[]" type="text" value="<?=$user_level[1];?>">
    				<br/><span style="color:#666666;">기자단(9998), 휘슬(9997), 루나(9996)</span></td>
    			</td>
    			<th>연령대</th>
    			<td>
    				<select name="user_age">
    					<option value="">선택</option>
    					<?php 
    						
    						$age_interval 	= 5;
    						$age_max		= 60; 
    						
    						for($i_age = 10 ; $i_age<=60 ; $i_age = $i_age + $age_interval){
    							
								if($i_age==10) {
									if($user_age==1)	$selected = "selected='selected'";
									else				$selected = "";
									echo "<option value='1' ".$selected.">10대 이하</option>";
								}
								
								if($user_age==$i_age)	$selected = "selected='selected'";
								else					$selected = "";
								
								if($i_age!=60)			echo "<option value='".$i_age."' ".$selected.">".($i_age+1)." ~ ".($i_age+$age_interval)."</option>";
								else					echo "<option value='".$i_age."' ".$selected.">".$i_age."대 이상</option>";
								
    						}
    					?>
    					
    				</select>
    			</td>
    			<th>지역</th>
    			<td><input name="user_region" type="text" value="<?=$user_region?>"></td>
    			<td>일자별 조회 </td>   			
    			<td><input class="userManager_sch_text_03" name="user_point_bydate[]" type="text" placeholder="ex)2015-01-09" value="<?=$user_point_bydate[0]?>">  ~  <input class="userManager_sch_text_03" name="user_point_bydate[]" type="text" placeholder="ex)2015-01-09" value="<?=$user_point_bydate[1]?>"></td>
    		</tr>
    		<tr>
    			<th>패널티</th>
    			<td><input name="user_penalty" type="text" value="<?=$user_penalty?>"></td>
    			<th>수신동의</th>
    			<td>
    				핸드폰
    				<input type="radio" name="user_phone_agree" value="1" <?=($user_phone_agree=='1')? "checked='checked'":"";?>>동의
    				<input type="radio" name="user_phone_agree" value="0" <?=($user_phone_agree=='0')? "checked='checked'":"";?>>동의안함
    				<br/>
    				
    				이메일
    				<input type="radio" name="user_email_agree" value="1" <?=($user_email_agree=='1')? "checked='checked'":"";?>>동의
    				<input type="radio" name="user_email_agree" value="0" <?=($user_email_agree=='0')? "checked='checked'":"";?>>동의안함
    			</td>
    			<td>가입일</td>
    			<td><input type="text" name="user_today" value="<?=$user_today?>"><br/><span style="color:#666666;">월별(2015-01) 일별(2015-01-09)</span></td>
    			<td>가용포인트 조회</td>    			
    			<td><input class="userManager_sch_text_03" name="user_point_bypoint_02[]" type="text" value="<?=$user_point_bypoint_02[0];?>">  ~  <input class="userManager_sch_text_03" name="user_point_bypoint_02[]" type="text" value="<?=$user_point_bypoint_02[1];?>"></td>
    		</tr>
    	</table>
    	
    	<table style="margin-top:10px;">
    		<tr>
    			<?php 
    				$keyword_key = array("beauti","delicious","kids","fashion","recipe","travel","etc");
    				$keyword_arr = array();
    				if($keyword[0]){
    					$j=0;
    					for($i=0; $i<count($keyword_key); $i++){
    						
    						if($keyword_key[$i]==$keyword[$j]){
    							$keyword_arr[$i] = "checked='checked'";
    							$j++;
    						}else{
    							$keyword_arr[$i] = "";
    						}
    						
    					}
    				}
    			?>
    			<!--  <th>키워드</th>
    			<td colspan=3>
    				<input type="checkbox" name="keyword[]" value="beauti" <?=$keyword_arr[0]?>>뷰티
    				<input type="checkbox" name="keyword[]" value="delicious" <?=$keyword_arr[1]?>>맛집
    				<input type="checkbox" name="keyword[]" value="kids" <?=$keyword_arr[2]?>>육아
    				<input type="checkbox" name="keyword[]" value="fashion" <?=$keyword_arr[3]?>>패션
    				<input type="checkbox" name="keyword[]" value="recipe" <?=$keyword_arr[4]?>>레시피
    				<input type="checkbox" name="keyword[]" value="travel" <?=$keyword_arr[5]?>>여행
    				<input type="checkbox" name="keyword[]" value="etc" <?=$keyword_arr[6]?>>기타
    			</td>-->
    			<th>컨텐츠 등급</th>
    			<td>
    				<select name="content_grade">
    					<option value="">선택</option>
    					<option value="상" <?=($content_grade=="상")? "selected='selected'" : "";?>>상</option>
    					<option value="중" <?=($content_grade=="중")? "selected='selected'" : "";?>>중</option>
    					<option value="하" <?=($content_grade=="하")? "selected='selected'" : "";?>>하</option>
    				</select>
    			</td>
    			<th>일 방문자</th>
    			<td>
    				<select name="visit_count">
                    	<option value="">선택</option>
                        <option value="200" <?=($visit_count=="200")? "selected='selected'" : "";?>>200명 이하</option>
                        <option value="800" <?=($visit_count=="800")? "selected='selected'" : "";?>>201명 ~ 800명</option>
                        <option value="1500" <?=($visit_count=="1500")? "selected='selected'" : "";?>>801명  ~ 1500명</option>
                        <option value="3000" <?=($visit_count=="3000")? "selected='selected'" : "";?>>1501명  ~ 3000명</option>
                        <option value="4000" <?=($visit_count=="4000")? "selected='selected'" : "";?>>3001명  ~ 4000명</option>
                        <option value="5000" <?=($visit_count=="5000")? "selected='selected'" : "";?>>4001명  ~ 5000명</option>
                        <option value="10000" <?=($visit_count=="10000")? "selected='selected'" : "";?>>5001명  ~ 10000명</option>
                        <option value="10001" <?=($visit_count=="10001")? "selected='selected'" : "";?>>10001명 이상</option>
                   </select>
    			</td>
    			<th>블로그 유형</th>
    			<td>
    				<select name="blog_type">
                    	<option value="">선택</option>
                        <option value="naver" <?=($blog_type=="naver")? "selected='selected'" : "";?>>네이버</option>
                        <option value="daum" <?=($blog_type=="daum")? "selected='selected'" : "";?>>다음</option>
                        <option value="tistory" <?=($blog_type=="tistory")? "selected='selected'" : "";?>>티스토리</option>
                   </select>
    			</td>
    			<th>SNS 유형</th>
    			<td>
    				<select name="mission_sns">
                    	<option value="">선택</option>
                        <option value="facebook" <?=($mission_sns=="facebook")? "selected='selected'" : "";?>>페이스북</option>
                        <option value="twitter" <?=($mission_sns=="twitter")? "selected='selected'" : "";?>>트위터</option>
                        <option value="kakao" <?=($mission_sns=="kakao")? "selected='selected'" : "";?>>카카오스토리</option>
                        <option value="insta" <?=($mission_sns=="metwoday")? "selected='selected'" : "";?>>미투데이</option>
                   </select>
    			</td>
    			<td>파워블로그<br/>핵심인력<br/>슈퍼패스</td>
    			<td>
    				<input type="checkbox" name="user_power_blog" <?=($user_power_blog==1)? "checked='checked'":"";?> value="1"><br/>
    				<input type="checkbox" name="user_vip_user" <?=($user_vip_user==1)? "checked='checked'":"";?> value="1"><br/>
    				<input type="checkbox" name="superpass" <?=($superpass=='Y')? "checked='checked'":"";?> value="Y">
    			</td>
    			<td><div onclick="frm_submit();" style="cursor:pointer;height: 25px;padding: 10px 7px 2px 7px;background: #376EA6;color:white;text-align:center;font-size:13px;">검 색</div></td>
    			<td><div onclick="location.href='<?=$_SERVER['PHP_SELF']."?"."board=".$_GET['board']."&idx=".$_GET['idx']?>'" style="cursor:pointer;height: 25px;padding: 10px 7px 2px 7px;background: #94B9DC;color: white;text-align: center;font-size: 13px;">초기화</div></td>
    			<td><div onclick="frm_print()" style="cursor:pointer;height: 25px;padding: 10px 7px 2px 7px;background: #94B9DC;color: white;text-align: center;font-size: 13px;">다운로드</div></td>
    		</tr>
    	</table>
    	
</div>
    <div style="width:98%;"><? include PATH_INC_END.'page02.php';?></div>
    
    
    <div id="resultArea">
    	<div style="text-align:left;padding:10px 0;"><span style="color:blue;">파워블로거  </span><span style="color:green;">핵심인력  </span><span style="color:red;">파워블로거+핵심인력</span><span style="color:orange;"> 주소확인 필요 멤버</span></div>
    	<table>
    		<tr>
    			<th width="2%">NO</th>
    			<th width="5%"><a href="javascript:ch_order('id-desc')">▼</a>아이디<a href="javascript:ch_order('id-asc')">▲</a></th>
    			<th width="5%"><a href="javascript:ch_order('nick-desc')">▼</a>닉네임<a href="javascript:ch_order('nick-asc')">▲</a></th>
    			<th width="5%"><a href="javascript:ch_order('name-desc')">▼</a>성명<a href="javascript:ch_order('name-asc')">▲</a></th>
    			<th width="5%"><a href="javascript:ch_order('age-desc')">▼</a>연령<a href="javascript:ch_order('age-asc')">▲</a></th>
    			<th width="5%"><a href="javascript:ch_order('level-desc')">▼</a>레벨<a href="javascript:ch_order('level-asc')">▲</a></th>
    			<th width="10%">블로그URL</th>
    			<th width="5%"><a href="javascript:ch_order('memo_01-desc')">▼</a>등급<a href="javascript:ch_order('memo_01-asc')">▲</a></th>
    			<th width="5%"><a href="javascript:ch_order('total-desc')">▼</a>총포인트<a href="javascript:ch_order('total-asc')">▲</a></th>
    			<th width="5%"><a href="javascript:ch_order('possible-desc')">▼</a>가용포인트<a href="javascript:ch_order('possible-asc')">▲</a></th>
    			<th width="5%"><a href="javascript:ch_order('user-desc')">▼</a>추천인<a href="javascript:ch_order('user-asc')">▲</a></th>
    			<th width="12%">패널티</th>
    			<th width="5%">상세페이지</th>
    		</tr>
    		
    		<?php 
    			
    			$user_data_sql = "select A.hero_idx, A.hero_id, A.hero_nick, A.hero_name, (".$this_year."-left(A.hero_jumin,4)+1) as hero_age, A.hero_level, A.hero_blog_00, A.hero_blog_01, A.hero_blog_02, A.hero_blog_03, A.hero_blog_04, A.hero_blog_05, A.hero_memo, A.hero_today, if(A.hero_memo_01='상' or A.hero_memo_01='중' or A.hero_memo_01='하', A.hero_memo_01, '히') as hero_memo_01, A.hero_memo_02, A.hero_memo_03, A.hero_memo_04, A.hero_user, left(A.hero_oldday,10) as oldday, A.hero_job_01, B.hero_possible, C.hero_total, D.hero_code from (select * from member where hero_use=0) as A ";
    			$user_data_sql .= "left outer join (select hero_code, sum(hero_point) as hero_possible from point where hero_today > '2014-09-10 22:23:32' ".$search_condition_02." group by hero_code) as B on A.hero_code=B.hero_code ";
    			$user_data_sql .= "left outer join (select hero_code, sum(hero_point) as hero_total from point where 1=1 ".$search_condition_02." group by hero_code) as C on A.hero_code=C.hero_code ";
    			$user_data_sql .= "left outer join (select hero_code from board WHERE hero_today>='".$threeMonthAgo."' group by hero_code) as D on D.hero_code = A.hero_code ";
    			$user_data_sql .= "where 1=1 ".$search_condition." order by ".$order." limit ".$start.",".$list_page.";";
    		
    			//echo "<script>console.log(\"".$user_data_sql."\");</script>";
				//echo $user_data_sql;
    			$user_data_res = mysql_query($user_data_sql);
    			
    			while($user_data_rs = mysql_fetch_assoc($user_data_res)){
    				
    				if($user_data_rs['hero_memo']>2000 && $user_data_rs['hero_memo_01']=='상')	$power_blog = 1;
    				else																		$power_blog = 0;
    				
    				
    				if($user_data_rs['hero_today']>=$threeMonthAgo && $user_data_rs['hero_blog_00'] && $user_data_rs['hero_code'])	$vip = 1;
    				else																											$vip = 0;
    				
    				if($power_blog==1 && $vip==0)		$emphasis = "style='color:blue;'";
    				elseif($power_blog==0 && $vip==1)	$emphasis = "style='color:green;'";
    				elseif($vip==1 && $power_blog==1)	$emphasis = "style='color:red;'";
    				else								$emphasis = "";
    				
    				if(($user_data_rs['oldday']>='2015-08-24' && $user_data_rs['oldday']<='2015-09-04') && ($user_data_rs['hero_job_01']!='Y' or $user_data_rs['hero_job_01']==null)){
    					$ch_addr = "style='color:orange;'";
    				}
    		?>
    		
    		<tr <?=$emphasis?>>
    			<td><?=$NO?></td>
    			<td <?=$ch_addr?>><?=$user_data_rs['hero_id']?></td>
    			<td><?=$user_data_rs['hero_nick']?></td>
    			<td><?=$user_data_rs['hero_name']?></td>
    			<td><?=$user_data_rs['hero_age']?></td>
    			<td><?=$user_data_rs['hero_level']?></td>
    			<td style="cursor:pointer;" onclick="window.open('<?=$user_data_rs['hero_blog_00']?>');"><?=$user_data_rs['hero_blog_00']?></td>
    			<td align='center'><?=($user_data_rs['hero_memo_01']=='히')? "" : $user_data_rs['hero_memo_01'];?></td>
    			<td align='right'><?=$user_data_rs['hero_total']?></td>
    			<td align='right'><?=$user_data_rs['hero_possible']?></td>
    			<td align='right'><?=$user_data_rs['hero_user']?></td>
    			<td><?=($user_data_rs['hero_memo_02'])? $user_data_rs['hero_memo_02']."<br/>" : "" ;?><?=($user_data_rs['hero_memo_03'])? $user_data_rs['hero_memo_03']."<br/>" : "" ;?><?=$user_data_rs['hero_memo_04']?></td>
    			<td align='center'><a href="<?=$_SERVER['PHP_SELF']."?"."board=".$_GET['board']."&idx=".$_GET['idx']?>&view=userManager_02&user_idx=<?=$user_data_rs['hero_idx']?>" class="btn_blue">상세정보</a></td>
    		</tr>
    		
    		<?php 
    				$NO--;
    			}
    		?>
    		
    	</table>
    </div>
     
    <div style="width:98%;">                        
    	<div class="paginate">
			<?
			echo page2($total_data,$list_page,$page_per_list,$page,$next_path);
			?>
       </div>
    </div>    
    
    