<?
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
//검색기능

$mission_gubun = $_REQUEST["mission_gubun"];
$mission_title = $_REQUEST["mission_title"];
$mission_sel_option = $_REQUEST["mission_sel_option"];

if(strcmp($_REQUEST['keyword'], '')){
	$search1 .= ' and '.$_REQUEST['select'].'=\''.$_REQUEST['keyword'].'\' ';
	$search_next .= '&keyword='.$_REQUEST['keyword'];
	$search_next .= '&select='.$_REQUEST['select'];
}

if(strcmp($_REQUEST['hero_sex'], '')){
	$search1 .= ' and hero_sex=\''.$_REQUEST['hero_sex'].'\' ';
	$search_next .= '&hero_sex='.$_REQUEST['hero_sex'];
}

if(strcmp($_REQUEST['hero_blog_00'], '')){
	$search1 .= ' AND (hero_blog_00 is not null  and  length(hero_blog_00) > 0) ';
	$search_next .= '&hero_blog_00='.$_REQUEST['hero_blog_00'];
}

if(strcmp($_REQUEST['hero_blog_04'], '')){
	$search1 .= ' AND (hero_blog_04 is not null  and  length(hero_blog_04) > 0) ';
	$search_next .= '&hero_blog_04='.$_REQUEST['hero_blog_04'];
}

if(strcmp($_REQUEST['hero_chk_phone'], '')){
	if($_REQUEST['hero_chk_phone'] == "1") {
		$search1 .= ' AND hero_chk_phone = 1 ';
	} else if($_REQUEST['hero_chk_phone'] == "0") {
		$search1 .= ' AND hero_chk_phone != 1 ';
	}
	$search_next .= '&hero_chk_phone='.$_REQUEST['hero_chk_phone'];
}

if(strcmp($_REQUEST['hero_chk_email'], '')){
	if($_REQUEST['hero_chk_email'] == "1") {
		$search1 .= ' AND hero_chk_email = 1 ';
	} else if($_REQUEST['hero_chk_email'] == "0") {
		$search1 .= ' AND hero_chk_email != 1 ';
	}
	$search_next .= '&hero_chk_email='.$_REQUEST['hero_chk_email'];
}

if(strcmp($_REQUEST['hero_oldday_start'], '')){
	$search1 .= " AND date_format(hero_oldday,'%Y%m%d') >= ".$_REQUEST['hero_oldday_start'];
	$search_next .= '&hero_oldday_start='.$_REQUEST['hero_oldday_start'];
}

if(strcmp($_REQUEST['hero_oldday_end'], '')){
	$search1 .= " AND date_format(hero_oldday,'%Y%m%d') <= ".$_REQUEST['hero_oldday_end'];
	$search_next .= '&hero_oldday_end='.$_REQUEST['hero_oldday_end'];
}

if(strcmp($_REQUEST['hero_age_start'], '')){
	$search2 .= ' AND hero_age >= '.$_REQUEST['hero_age_start'];
	$search_next .= '&hero_age_start='.$_REQUEST['hero_age_start'];
}

if(strcmp($_REQUEST['hero_age_end'], '')){
	$search2 .= ' AND hero_age <= '.$_REQUEST['hero_age_end'];
	$search_next .= '&hero_age_end='.$_REQUEST['hero_age_end'];
}

if($mission_sel_option < 3 && $mission_sel_option) {
	$sql_join_search .= " INNER JOIN mission_review r ON m.hero_code = r.hero_code   ";
	$search2 .= " AND r.hero_use = 0 AND r.hero_old_idx = '".$mission_title."' ";
	if($mission_sel_option > 1) $search2 .= " AND r.lot_01 = 1 ";	
	
	$search_next .= '&mission_gubun='.$_REQUEST['mission_gubun'];
	$search_next .= '&mission_title='.$_REQUEST['mission_title'];
	$search_next .= '&mission_sel_option='.$_REQUEST['mission_sel_option'];
	
} else if($mission_sel_option > 2 && $mission_sel_option){ //3부터 후기등록, 우수후기 게시판 확인
	$sql_join_search .= " INNER JOIN board b ON m.hero_code = b.hero_code   ";
	$search2 .= " AND  b.hero_01 = '".$mission_title."' ";
	
	if($mission_sel_option > 3) $search2 .= " AND b.hero_board_three = 1 ";
	
	$search_next .= '&mission_gubun='.$_REQUEST['mission_gubun'];
	$search_next .= '&mission_title='.$_REQUEST['mission_title'];
	$search_next .= '&mission_sel_option='.$_REQUEST['mission_sel_option'];
}

	//페이지 넘버링
	$sql_count = 'SELECT count(*) FROM member WHERE hero_use=0 '.$search.' ORDER BY hero_oldday DESC ';//desc
	
	$sql_count  = " SELECT count(*) FROM ";
	$sql_count .= " (SELECT hero_code, hero_id, hero_nick, hero_name, hero_hp , hero_oldday ";
	$sql_count .= " , (case when hero_chk_phone = 1 then '수신' else '미수신' end) hero_chk_phone ";
	$sql_count .= " , (case when hero_chk_email = 1 then '수신' else '미수신' end) hero_chk_email ";
	$sql_count .= " , (case when hero_sex = 0 then '여성' else '남성' end) hero_sex ";
	$sql_count .= " , (date_format(now(),'%Y') - left(hero_jumin,4) + 1) hero_age ";
	$sql_count .= " FROM member where hero_use=0 ".$search1.") m ";
	$sql_count .= $sql_join_search;
	$sql_count .= " WHERE 1=1 ".$search2;
	
	$sql_count = mysql_query($sql_count);
	$count = mysql_fetch_assoc($sql_count);
	$no = $count['count(*)']; 
	$total_data = $no;
	$list_page=20;
	$page_per_list=5;
	if(!strcmp($_GET['page'], '') || !strcmp($_GET['page'], '1')){$page = '1';
	}else{
		$page = $_GET['page'];
		$no = $no-($page-1)*$list_page;
	}
	$start = ($page-1)*$list_page;
	$next_path="board=".$_GET['board'].$search_next.'&idx='.$_GET['idx'];
	
	//페이지 리스트
	$sql  = " SELECT m.hero_code, m.hero_id, m.hero_nick, m.hero_name, m.hero_hp, m.hero_oldday ";
	$sql .= " , m.hero_chk_phone , m.hero_chk_email, m.hero_sex, m.hero_age  FROM ";
	$sql .= " (SELECT hero_code, hero_id, hero_nick, hero_name, hero_hp , hero_oldday ";
	$sql .= " , (case when hero_chk_phone = 1 then '수신' else '미수신' end) hero_chk_phone ";
	$sql .= " , (case when hero_chk_email = 1 then '수신' else '미수신' end) hero_chk_email ";
	$sql .= " , (case when hero_sex = 0 then '여성' else '남성' end) hero_sex ";
	$sql .= " , (date_format(now(),'%Y') - left(hero_jumin,4) + 1) hero_age ";
	$sql .= " FROM member where hero_use=0 ".$search1.") m ";
	$sql .= $sql_join_search;
	$sql .= " WHERE 1=1 ".$search2. " order by hero_oldday desc limit ".$start.",".$list_page;

	$user_sql = mysql_query($sql);
?>
<script>


function goSearch(){
	$("#searchForm").submit();
}

function selMissionGubun(val,idx,option_num) {

	
	if(val) {
		
		var option_chk = "";
		if(!option_num) {
			option_chk = "1";
		} else {
			option_chk = option_num;
		}
		var dataparam = "";
		dataparam = "board="+val;
		
		if(idx) dataparam += "&hero_idx="+idx;
		
		$.ajax({
				url:"<?=ADMIN_DEFAULT?>/user/missionTypeList.php"
				,data:dataparam
				,type:"POST"
				,dataType:"html"
				,success:function(d) {
					console.log(d);
					
					var html = '<select name="mission_title" id="mission_title" class="ml15" style="width:400px; height:24px;">';
						html += d;
						html += '</select>';
					
					var option = '<label for="mission_sel_option_1" class="ml10">신청</label><input type="radio" name="mission_sel_option" id="mission_sel_option_1" value="1" '+((option_chk == 1) ? 'checked':'')+'/>';
						option += '<label for="mission_sel_option_2" class="ml10">선정자</label><input type="radio" name="mission_sel_option" id="mission_sel_option_2" value="2" '+((option_chk == 2) ? 'checked':'')+'/>';
						option += '<label for="mission_sel_option_3" class="ml10">후기등록</label><input type="radio" name="mission_sel_option" id="mission_sel_option_3" value="3" '+((option_chk == 3) ? 'checked':'')+'/>';
						option += '<label for="mission_sel_option_4" class="ml10">우수후기</label><input type="radio" name="mission_sel_option" id="mission_sel_option_4" value="4" '+((option_chk == 4) ? 'checked':'')+'/>';

					$("#mission_title").html(html);
					$("#mission_sel_option").html(option);
					
				},error:function(e){
					alert("다시 시도해 주세요.");
					return;
				}
			})

	} else {
		$("#mission_title").html("");
		$("#mission_sel_option").html("");
	}
}


<? if($mission_sel_option) {?>
selMissionGubun('<?=$mission_gubun;?>','<?=$mission_title;?>','<?=$mission_sel_option;?>')
<? } ?>

function excel() {
	$('#searchForm').attr('action','user/memberExcel.php').submit();
	$('#searchForm').attr('action', '<?=PATH_HOME.'?'.get('page');?>');
}

function fnPasswordCheck() {
	if(!$("input[name='password']").val()) {
		alert("비밀번호를 입력해 주세요.");
		$("input[name='password']").focus();
		return;
	}

	var param = "password="+$("input[name='password']").val();
	
	$.ajax({
			url:"<?=ADMIN_DEFAULT?>/user/14_password_check.php"
			,data:param
			,type:"post"
			,dataType:"json"
			,success:function(d) {
				if(d.result) {
					alert("확인되었습니다.");
					location.reload();
					return;
				} else {
					alert("비밀번호가 틀립니다.");
					return;
				}
			},error:function(e){
				console.log(e);
				alert("통신 실패했습니다.")
				return;
			}
		})
}

</script>
<? if(!$_SESSION["passwordSuccess"]) { ?>
<div id="noAuthContents">
	<div style="text-align:center; ">
		<p style="font-size:24px;">비밀번호 입력 후 이용가능합니다.</p>
		
		<div style="margin:30px 0 0 0;">
			<input type="password" name="password" placeholder="비밀번호를 입력해 주세요." style="width:200px; height:30px; border:1px solid #376ea6; padding-left:20px;" />
		</div>
		<div style="margin:10px 0 0 0;">
			<a href="#" onClick="fnPasswordCheck();" style="display:block; width:120px; height:30px; line-height:30px; background:#376ea6; color:#fff; margin:0 auto;">확인</a>
		</div>
	</div>
</div>							
<? } else if($_SESSION["passwordSuccess"] == "Y") {?>					
<div id="authContents">
							<!--검색영역-->
							<div class="searchbox searchbox_pd">
                            <div class="wrap_1">
	                            <form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>" method="POST" >
	                            <div>
	                            	<label for="age_start">나이</label> <input type="text" name="hero_age_start" id="hero_age_start" value="<?=$_REQUEST["hero_age_start"]?>" style="width:60px" maxlength="3" /> ~ <input type="text" name="hero_age_end" id="hero_age_end" value="<?=$_REQUEST["hero_age_end"]?>" style="width:60px" maxlength="3"/>
	                            	
	                            	<label class="ml20">성별</label>  <label for="sex_all" class="ml10">전체</label><input type="radio" name="hero_sex" id="sex_all" value="" <? if($_REQUEST['hero_sex'] == "") echo "checked"; ?>/>
	                            							        <label for="hero_sex_0" class="ml10">여</label><input type="radio" name="hero_sex" id="hero_sex_0" value="0" <? if($_REQUEST['hero_sex'] == "0") echo "checked"; ?>/>
	                            							        <label for="hero_sex_1" class="ml10">남</label><input type="radio" name="hero_sex" id="hero_sex_1" value="1" <? if($_REQUEST['hero_sex'] == "1") echo "checked"; ?>/>
									
									<label class="ml20">블로그 여부</label> <label for="hero_blog_00" class="ml10">블로그</label><input type="checkbox" name="hero_blog_00" id="hero_blog_00" value="1" <? if($_REQUEST['hero_blog_00'] == "1") echo "checked"; ?>/>
															  		   <label for="hero_blog_04" class="ml10">인스타</label><input type="checkbox" name="hero_blog_04" id="hero_blog_04" value="1" <? if($_REQUEST['hero_blog_04'] == "1") echo "checked"; ?>/>
								</div>
								
								<div class="mt10">
									<label>가입일</label>
									<input type="text" name="hero_oldday_start" id="hero_oldday_start" value="<?=$_REQUEST["hero_oldday_start"]?>" />
									~
									<input type="text" name="hero_oldday_end" id="hero_oldday_end" value="<?=$_REQUEST["hero_oldday_end"]?>" />
									
									<span>숫자만 입력해주세요. (예:2019년01월15일 인 경우 20190115)</span>
									
									<label class="ml20">휴대폰수신동의</label>
									<input type="radio" name="hero_chk_phone" id="hero_chk_phone_all" <? if($_REQUEST['hero_chk_phone'] == "") echo "checked"; ?> value=""  /><label for="hero_chk_phone_all">전체</label>
									<input type="radio" name="hero_chk_phone" id="hero_chk_phone_1" <? if($_REQUEST['hero_chk_phone'] == "1") echo "checked"; ?> value="1" /><label for="hero_chk_phone_1">동의</label>
									<input type="radio" name="hero_chk_phone" id="hero_chk_phone_0" <? if($_REQUEST['hero_chk_phone'] == "0") echo "checked"; ?> value="0" /><label for="hero_chk_phone_0">미동의</label>
									
									<label class="ml20">이메일수신동의</label>
									<input type="radio" name="hero_chk_email" id="hero_chk_email_all" <? if($_REQUEST['hero_chk_email'] == "") echo "checked"; ?> value="" /><label for="hero_chk_email_all">전체</label>
									<input type="radio" name="hero_chk_email" id="hero_chk_email_1" <? if($_REQUEST['hero_chk_email'] == "1") echo "checked"; ?> value="1" /><label for="hero_chk_email_1">동의</label>
									<input type="radio" name="hero_chk_email" id="hero_chk_email_0" <? if($_REQUEST['hero_chk_email'] == "0") echo "checked"; ?> value="0" /><label for="hero_chk_email_0">미동의</label>
							
								</div>
								
								<!-- 190115 더 추가해야함
								<div class="mt10">
	                                <select name="select" id="" style='width:80px;'>
	                                  <option value="hero_id"<?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>아이디</option>
	                                  <option value="hero_name"<?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>이름
									  </option>
									  <option value="hero_nick"<?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>닉네임
									  </option>
	                                </select>
	                                <input name="keyword" type="text" value="<?echo $_REQUEST['keyword'];;?>" class="kewyword">
	                             </div>
	                             
	                             <div class="mt10">
	                             	<label for="">체험단 선택</label> <select name="mission_gubun" style="width:200px; height:24px;" onChange="selMissionGubun(this.value,'','')">
	                             								 	<option value="">선택</option>
	                             								 	<option value="group_04_05" <?=$mission_gubun == "group_04_05" ? "selected":""; ?>>체험단</option>
	                             								 	<option value="group_02_03" <?=$mission_gubun == "group_02_03" ? "selected":""; ?>>게릴라이벤트</option>
	                             								 	<option value="group_04_07" <?=$mission_gubun == "group_04_07" ? "selected":""; ?>>애경박스</option>
	                             								 	<option value="group_04_06" <?=$mission_gubun == "group_04_06" ? "selected":""; ?>>뷰티클럽</option>
	                             								 	<option value="group_04_23" <?=$mission_gubun == "group_04_23" ? "selected":""; ?>>휘슬클럽</option>
	                             								 </select>
	                             								 
									<span style="color:#f00;">- 체험단 선택 시 체험단 명, 참여자 구분 항목이 노출됩니다.(등록순, 최대30개 노출)<br/>
															
									</span>
	                             </div>
	                             
	                             <div class="mt10">
	                             	<label for="">체험단 명</label> <span id="mission_title"></span>
	                             </div>
	                             
	                             <div class="mt10">
	                             	<label for="">참여자 구분</label> <span id="mission_sel_option"></span>
	                             </div>
	                              -->
	                             
	                             <div class="mt10" style="text-align:center;">
	                             	<a href="javascript:;" onclick="goSearch();" style="display: inline-block;padding:5px 10px; background-color: #666; color:#fff;">검색하기</a>
	                             </div>
	                             
	                            </form>
                            </div>
                        </div>
						
						<div style="margin:0 0 10px 0; position:relative;">회원 수 : <?=number_format($count['count(*)']);?>명
							<a href="javascript:;" onclick="excel();" style="display:inline-block;padding:5px 10px; background-color:#559f13; color:#fff; position:absolute; right:0; top:-5px;">엑셀추출</a>
							
							<p style="color:#f00; text-align:right; margin-top:10px;">
							   - 휴대폰, 이메일 발송 시 반드시 수신에 '동의'한 회원에 한해 발송&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br/>
							   - 엑셀추출후 반드시 휴대폰, 이메일 수신에 '동의'로 필터링 후 활용필요
							</p>
						</div>
			
						<table class="t_list">
                            <thead>
                                <tr>
                                    <th width="5%">NO</th>
                                    <th width="10%">아이디</th>
                                    <th width="10%">이름</th>
                                    <th width="10%">닉네임</th>
                                    <th width="5%">나이</th>
                                    <th width="5%">성별</th>
                                    <th width="10%">가입일</th>
                                    <th width="15%">휴대폰번호</th>
                                    <th width="10%">문자수신여부</th>
                                    <th width="10%">이메일수신여부</th>
                                </tr>
                            </thead>
                            <tbody>
                        <?
                        if($no > 0) {
                        while($list                             = @mysql_fetch_assoc($user_sql)){
                        ?>
                           
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
                                    <td><?=$no?></td>
                                    <td><?=$list['hero_id'];?></td>
                                    <td><?=$list['hero_name'];?></td>
                                    <td><?=$list['hero_nick'];?></td>
                                    <td><?=$list['hero_age'];?></td>
                                    <td><?=$list['hero_sex'];?></td>
                                    <td><?=$list['hero_oldday'];?></td>
                                    <td><?=$list['hero_hp'];?></td>
									<td><?=$list['hero_chk_phone'];?></td>
									<td><?=$list['hero_chk_email'];?></td>
                                </tr>

                        <?
                        $no--;
                        }
                        } else {
                        ?>
                        <tr>
                        	<td colspan="8" style="test-align:center;">검색된 회원이 없습니다.</td>
                        </tr>
                        <? } ?>

                            </tbody>
                        </table>
						<div style="width:100%; text-align:center; margin-top:20px;">
<? include_once PATH_INC_END.'page.php';?>
                        </div>
</div>
<? } ?>
