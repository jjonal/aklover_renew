<?php 
if(!defined('_HEROBOARD_'))exit;
?>

<?php 
$threeMonthAgo = date("Y-m-d",strtotime("-3 month"));
$this_year = date('Y',time());
$list_page=20;
$page_per_list=10;
$total_data = 0;
$page = 0;
$start = 0;
$next_path ='';
$order ="";
$NO = 0;
$board = $_POST['board'];


if($_POST['order']){
	$order = $_POST['order'];
	$order = explode('-',$order);
	$order = "hero_".$order[0]." ".$order[1];
}else{
	$order = "E.hero_old_idx desc";
}

if($_POST['mode']=='search'){
	
	$user_id	 			= $_POST['user_id'];
	$user_nick 				= $_POST['user_nick'];
	$user_name 				= $_POST['user_name'];
	$user_level 			= $_POST['user_level'];
	$user_region 			= $_POST['user_region'];
	$user_age 				= $_POST['user_age'];
	$user_penalty 			= $_POST['user_penalty'];
	$user_phone_agree 		= $_POST['user_phone_agree'];
	$user_email_agree 		= $_POST['user_email_agree'];
	
	$keyword		 		= $_POST['keyword'];
	$content_grade	 		= $_POST['content_grade'];
	$visit_count		 		= $_POST['visit_count'];
	$blog_type		 		= $_POST['blog_type'];
	
	$mission_register 		= $_POST['mission_register'];
	$mission_win	 		= $_POST['mission_win'];
	$mission_lover	 		= $_POST['mission_lover'];
	$mission_sns	 		= $_POST['mission_sns'];
	$mission_type	 		= $_POST['mission_type'];
	$mission_name	 		= $_POST['mission_name'];
	
	$user_power_blog	 	= $_POST['user_power_blog'];
	$user_vip_user			= $_POST['user_vip_user'];
	
	$search_condition = '';
	$search_condition = '';
	
	if($user_id)														$search_condition .= "and A.hero_id like '%".$user_id."%' ";
	if($user_nick)														$search_condition .= "and A.hero_nick like '%".$user_nick."%' ";
	if($user_name)														$search_condition .= "and A.hero_name like '%".$user_name."%' ";

	if(is_numeric($user_level[0]) and is_numeric($user_level[1]))								$search_condition .= "and hero_level >= ".$user_level[0]." and hero_level <= ".$user_level[1]." ";
	elseif(is_numeric($user_level[0]) and !is_numeric($user_level[1]))							$search_condition .= "and hero_level = ".$user_level." ";
	
	if($user_region)													$search_condition .= "and (hero_address_02 like '%".$user_region."%' or hero_address_03 like '%".$user_region."%') ";
	
	if($user_age){
		switch($user_age){
			case 1 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) < 11 ";break;
			case 10 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 11 and (".$this_year."-left(hero_jumin,4)+1) <= 15 ";break;
			case 15 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 16 and (".$this_year."-left(hero_jumin,4)+1) <= 20 ";break;
			case 20 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 21 and (".$this_year."-left(hero_jumin,4)+1) <= 25 ";break;
			case 25 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 26 and (".$this_year."-left(hero_jumin,4)+1) <= 30 ";break;
			case 30 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 31 and (".$this_year."-left(hero_jumin,4)+1) <= 35 ";break;
			case 35 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 36 and (".$this_year."-left(hero_jumin,4)+1) <= 40 ";break;
			case 40 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 41 and (".$this_year."-left(hero_jumin,4)+1) <= 45 ";break;
			case 45 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 46 and (".$this_year."-left(hero_jumin,4)+1) <= 50 ";break;
			case 50 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 51 and (".$this_year."-left(hero_jumin,4)+1) <= 55 ";break;
			case 55 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 56 and (".$this_year."-left(hero_jumin,4)+1) <= 60 ";break;
			case 60 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) <= 61";break;
		}		
	}
	
	if($content_grade)													$search_condition .= "and hero_memo_01='".$content_grade."' ";
	if($visit_count)													$search_condition .= "and hero_memo='".$visit_count."' ";
	if($blog_type)														$search_condition .= "and (hero_blog_00 like '%".$blog_type."%' or hero_blog_01 like '%".$blog_type."%' or hero_blog_02 like '%".$blog_type."%' or hero_blog_03 like '%".$blog_type."%' or hero_blog_04 like '%".$blog_type."%' or hero_blog_05 like '%".$blog_type."%') ";
	
	if($user_penalty)													$search_condition .= "and (hero_memo_02 like '%".$user_penalty."%' or hero_memo_03 like '%".$user_penalty."%' or hero_memo_04 like '%".$user_penalty."%') ";
	if(is_numeric($user_phone_agree))									$search_condition .= "and hero_chk_phone=".$user_phone_agree." ";
	if(is_numeric($user_email_agree))									$search_condition .= "and hero_chk_email=".$user_email_agree." ";
	
	if(is_numeric($mission_register[0]) and is_numeric($mission_register[1]))					$search_condition .= "and lot>='".$mission_register[0]."' and lot<='".$mission_register[1]."' ";
	elseif(is_numeric($mission_register[0]) and !is_numeric($mission_register[1]))				$search_condition .= "and lot='".$mission_register[0]."' ";
	
	if(is_numeric($mission_win[0]) and is_numeric($mission_win[1]))								$search_condition .= "and lot>='".$mission_win[0]."' and lot<='".$mission_win[1]."' ";
	elseif(is_numeric($mission_win[0]) and !is_numeric($mission_win[1]))						$search_condition .= "and lot='".$mission_win[0]."' ";

	if(is_numeric($mission_lover[0]) and is_numeric($mission_lover[1]))							$search_condition .= "and hero_board_three>='".$mission_lover[0]."' and hero_board_three<='".$mission_lover[1]."' ";
	elseif(is_numeric($mission_lover[0]) and !is_numeric($mission_lover[1]))					$search_condition .= "and hero_board_three='".$mission_lover[0]."' ";
	
	if($mission_sns)													$search_condition .= "and (hero_blog_00 like '%".$mission_sns."%' or hero_blog_01 like '%".$mission_sns."%' or hero_blog_02 like '%".$mission_sns."%' or hero_blog_03 like '%".$mission_sns."%' or hero_blog_04 like '%".$mission_sns."%' or hero_blog_05 like '%".$mission_sns."%') ";
	if(is_numeric($mission_type))										$search_condition .= "and hero_mission_type = '".$mission_type."' ";
	
	if($mission_name)													$search_condition .= "and BINARY(C.hero_title) like BINARY('%".$mission_name."%') ";
	
	if($user_power_blog==1)												$search_condition .= "and A.hero_memo>2000 and A.hero_memo_01='상' ";
	if($user_vip_user==1)												$search_condition .= "and hero_core_member ='Y'";
	
	
	//echo $search_condition;
	/* if($keyword){
		foreach($keyword as $key){
			$search_condition .= "and ";
		}
	} */

}

$count_sql = "select count(*) as count from member as A ";
$count_sql .= "right outer join (select hero_code, hero_old_idx, lot_01 from mission_review order by hero_code desc) as E on A.hero_code=E.hero_code ";
$count_sql .= "left outer join (select hero_code, hero_old_idx, sum(lot_01) as lot, count(lot_01) as lot_01 from mission_review group by hero_code order by hero_code) as B on A.hero_code=B.hero_code ";
$count_sql .= "left outer join mission as C on C.hero_idx=E.hero_old_idx ";
$count_sql .= "left outer join (select hero_code, sum(hero_board_three) as hero_board_three, sum(if(hero_today>='".$threeMonthAgo."',1,0)) as hero_vip from board group by hero_code) as D on D.hero_code=A.hero_code ";
$count_sql .= "where A.hero_use=0 ".$search_condition;
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
			//alert('현재 페이지 수정중입니다. 혹 필요한 자료 있으시면 joooniii12@unipics.com으로 연락부탁드립니다. 감사합니다.');
    		
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
			console.log('test');
			$('#frm').prop('action',"<?=ADMIN_DEFAULT?>/user/download_mission.php");
			$('#frm').submit();
			$('#frm').prop('action',"<?=$_SERVER['PHP_SELF']."?"."board=".$_GET['board']."&idx=".$_GET['idx']?>");
		}
		
    </script>

    
    <div id="searchArea">
	    <form method="POST" id="frm" name="frm" action="<?=$_SERVER['PHP_SELF']."?"."board=".$_GET['board']."&idx=".$_GET['idx']?>">
    	<input type="hidden" name="mode" value="search">
    	<input type="hidden" name="order" id="order" value="<?=$_POST['order']?>">
    	<input type="hidden" name="page" id="page" value="<?=$page ?>">
    	<table>
    		<tr>
    			<th>아이디</th>
    			<td><input name="user_id" type="text" value="<?=$user_id?>"></td>
    			<th>닉네임</th>
    			<td><input name="user_nick" type="text" value="<?=$user_nick?>"></td>
    			<th>이름</th>
    			<td><input name="user_name" type="text" value="<?=$user_name?>"></td>
				<th rowspan=2 style="border-left:1px solid #dddddd;"></th>
    			<td>미션 신청 수</td>   			
    			<td><input class="userManager_sch_text_03" name="mission_register[]" value="<?=$mission_register[0];?>" type="text">  ~  <input class="userManager_sch_text_03" name="mission_register[]" type="text" value="<?=$mission_register[1];?>"></td>
    			<td>미션 당첨 수 </td>   			
    			<td><input class="userManager_sch_text_03" name="mission_win[]" type="text" value="<?=$mission_win[0]?>">  ~  <input class="userManager_sch_text_03" name="mission_win[]" type="text" value="<?=$mission_win[1]?>"></td>
    		</tr>
    		<tr>
    			
    			<th>레벨</th>
    			<td><input class="userManager_sch_text_02" name="user_level[]" type="text" value="<?=$user_level[0]?>">  ~  <input class="userManager_sch_text_02" name="user_level[]" type="text" value="<?=$user_level[1];?>"></td>
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
    			
    			<td>러버스타 수 </td>   			
    			<td><input class="userManager_sch_text_03" name="mission_lover[]" type="text" value="<?=$mission_lover[0]?>">  ~  <input class="userManager_sch_text_03" name="mission_lover[]" type="text" value="<?=$mission_lover[1]?>"></td>
    			<!--<td>미션 별 조회</td>    			
    			<td>
    				<select name="mission_type">
    					<option value="">선택</option>
    					<option value="0" <?=($mission_type=="0")? "selected='selected'" : "";?>>뷰티</option>
    					<option value="1" <?=($mission_type=="1")? "selected='selected'" : "";?>>세제</option>
    					<option value="2" <?=($mission_type=="2")? "selected='selected'" : "";?>>식품</option>
    					<option value="3" <?=($mission_type=="3")? "selected='selected'" : "";?>>타사코웍</option>
    				</select>
    			</td>-->
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
    			<td></td>
    			<td style="border-right:1px solid #dddddd;"></td>
    			<td></td>
    			<td>미션명</td>
    			<td><input name="mission_name" type="text" value="<?=$mission_name?>"></td>
    			<td></td>
    			<td></td>
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
    			<td style="width:28%;">
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
                        <option value="facebook" <?=($blog_type=="facebook")? "selected='selected'" : "";?>>페이스북</option>
                        <option value="twitter" <?=($blog_type=="twitter")? "selected='selected'" : "";?>>트위터</option>
                        <option value="metwoday" <?=($blog_type=="metwoday")? "selected='selected'" : "";?>>미투데이</option>
                        <option value="kakao" <?=($blog_type=="kakao")? "selected='selected'" : "";?>>카카오스토리</option>
                        <option value="etc" <?=($blog_type=="etc")? "selected='selected'" : "";?>>기타</option>
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
    			<td><div onclick="frm_submit();" style="cursor:pointer;height: 25px;padding: 10px 7px 2px 7px;background: #376EA6;color: white;text-align: center;font-size: 13px;">검 색</div></td>
    			<td><div onclick="location.href='<?=$_SERVER['PHP_SELF']."?"."board=".$_GET['board']."&idx=".$_GET['idx']?>'" style="cursor:pointer;height: 25px;padding: 10px 7px 2px 7px;background: #94B9DC;color: white;text-align: center;font-size: 13px;">초기화</div></td>
    			<td><div onclick="frm_print();" style="cursor:pointer;height: 25px;padding: 10px 7px 2px 7px;background: #94B9DC;color: white;text-align: center;font-size: 13px;">다운로드</div></td>
    		</tr>
    		
    	</table>
    	
    	
</div>
    <div style="width:98%;"><? include PATH_INC_END.'page02.php';?></div>
    <div id="resultArea">
    	<table>
    		<tr>
    			<th width="2%">NO</th>
    			<th width="5%">미션명</th>
    			<th width="5%"><a href="javascript:ch_order('id-desc')">▼</a>아이디<a href="javascript:ch_order('id-asc')">▲</a></th>
    			<th width="5%"><a href="javascript:ch_order('nick-desc')">▼</a>닉네임<a href="javascript:ch_order('nick-asc')">▲</a></th>
    			<th width="5%"><a href="javascript:ch_order('name-desc')">▼</a>성명<a href="javascript:ch_order('name-asc')">▲</a></th>
    			<th width="3%"><a href="javascript:ch_order('age-desc')">▼</a>연령<a href="javascript:ch_order('age-asc')">▲</a></th>
    			<th width="5%"><a href="javascript:ch_order('hp-desc')">▼</a>연락처<a href="javascript:ch_order('hp-asc')">▲</a></th>
    			<th width="10%"><a href="javascript:ch_order('addr-desc')">▼</a>주소<a href="javascript:ch_order('addr-asc')">▲</a></th>
    			<th width="10%">블로그URL</th>
    			<th width="5%"><a href="javascript:ch_order('memo-desc')">▼</a>방문자수<a href="javascript:ch_order('memo-asc')">▲</a></th>
    			<th width="3%"><a href="javascript:ch_order('memo_01-desc')">▼</a>등급<a href="javascript:ch_order('memo_01-asc')">▲</a></th>
    			<th width="8%"><a href="javascript:ch_order('penalty-desc')">▼</a>패널티<a href="javascript:ch_order('penalty-asc')">▲</a></th>
    			<th width="5%">상세페이지</th>
    		</tr>
    		
    		<?php 
    			
    			$user_data_sql = "select A.hero_idx, A.hero_id, A.hero_nick, A.hero_name, A.hero_blog_01, A.hero_blog_02, A.hero_blog_03, A.hero_blog_04, A.hero_blog_05, A.hero_today, (".$this_year."-left(A.hero_jumin,4)+1) as hero_age, A.hero_hp, A.hero_address_01, concat(A.hero_address_02,' ',A.hero_address_03) as hero_addr, A.hero_memo, A.hero_level, A.hero_blog_00, if(A.hero_memo_01='상' or A.hero_memo_01='중' or A.hero_memo_01='하', A.hero_memo_01, '히') as hero_memo_01, A.hero_memo_02, A.hero_memo_03, A.hero_memo_04, A.hero_core_member, D.hero_vip,C.hero_title ";
    			$user_data_sql .= "from member as A ";
    			$user_data_sql .= "right outer join (select hero_code, hero_old_idx, lot_01 from mission_review order by hero_code desc) as E on A.hero_code=E.hero_code ";
    			$user_data_sql .= "left outer join (select hero_code, hero_old_idx, sum(lot_01) as lot, count(lot_01) as lot_01 from mission_review group by hero_code order by hero_code) as B on A.hero_code=B.hero_code ";
    			$user_data_sql .= "left outer join mission as C on C.hero_idx=E.hero_old_idx ";
    			$user_data_sql .= "left outer join (select hero_code, sum(hero_board_three) as hero_board_three, sum(if(hero_today>='".$threeMonthAgo."',1,0)) as hero_vip from board group by hero_code) as D on D.hero_code=A.hero_code ";
    			$user_data_sql .= "where A.hero_use=0 ".$search_condition." order by ".$order." limit ".$start.",".$list_page.";";
    			//echo "<script>console.log('".$user_data_sql."')</script>";
    			//echo $user_data_sql;
    			$user_data_res = mysql_query($user_data_sql) or die("<script>alert('시스템에러입니다. 다시 시도해주세요. 반복될 경우 개발자에게 문의해 주세요. ERROR_CODE : USERMANAGER_02');</script>");
    			while($user_data_rs = mysql_fetch_assoc($user_data_res)){
    		?>
    		
    		<tr>
    			<td><?=$NO?></td>
    			<td><?=$user_data_rs['hero_title']?></td>
    			<td><?=$user_data_rs['hero_id']?></td>
    			<td><?=$user_data_rs['hero_nick']?></td>
    			<td><?=name_masking($user_data_rs['hero_name'])?></td>
    			<td><?=$user_data_rs['hero_age']?></td>
    			<td><?=phone_masking($user_data_rs['hero_hp'])?></td>
    			<td><?=$user_data_rs['hero_address_01']." ".$user_data_rs['hero_addr']?></td>
    			<td style="cursor:pointer;" onclick="window.open('<?=$user_data_rs['hero_blog_00']?>');"><?=$user_data_rs['hero_blog_00']?></td>
    			
    			<?php 
    				switch($user_data_rs['hero_memo']){
    					case 200 : $hero_memo = "200명 이하";break;
    					case 800 : $hero_memo = "201명 ~ 800명";break;
    					case 1500 : $hero_memo = "801명 ~ 1500명";break;
    					case 3000 : $hero_memo = "1501명 ~ 3000명";break;
    					case 4000 : $hero_memo = "3001명 ~ 4000명";break;
    					case 5000 : $hero_memo = "4001명 ~ 5000명";break;
    					case 10000 : $hero_memo = "5001명 ~ 10000명";break;
    					case 10001 : $hero_memo = "10001명 이상";break;
    				}
    			?>
    			
    			<td align='center'><?=$hero_memo?></td>
    			<td align='right'><?=($user_data_rs['hero_memo_01']=='히')? "" : $user_data_rs['hero_memo_01'];?></td>
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
    
    