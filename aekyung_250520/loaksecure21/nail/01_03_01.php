<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$search=" hero_01='".$_GET['hero_idx']."' ";
$search_next="&list_count=".$_REQUEST['list_count']."";

if(!strcmp($_REQUEST['loverStar'], 'Y')) {
	$search .= 'and hero_board_three = 1';
	$search_next .= "&loverStar=".$_REQUEST['loverStar']."";
}
if(strcmp($_REQUEST['kewyword'], '')){
	if(!strcmp($_REQUEST['select'], 'hero_all')){
		$search .= ' AND ( hero_name like \'%'.$_REQUEST['kewyword'].'%\' or hero_title like \'%'.$_REQUEST['kewyword'].'%\' or hero_nick like \'%'.$_REQUEST['kewyword'].'%\') ';
		$search_next .= '&select='.$_REQUEST['select'].'&kewyword='.$_REQUEST['kewyword'];
	}else{
		$search .= ' AND '.$_REQUEST['select'].' like \'%'.$_REQUEST['kewyword'].'%\' ';
		$search_next .= '&select='.$_REQUEST['select'].'&kewyword='.$_REQUEST['kewyword'];
	}
}
######################################################################################################################################################
$sql = 'select * from board where '.$search;

sql($sql);
$total_data = @mysql_num_rows($out_sql);

/////////// no 생성 20140509
$no=$total_data;

######################################################################################################################################################
$list_page=$_REQUEST['list_count']==""?20:$_REQUEST['list_count'];
$page_per_list=5;

if(!strcmp($_GET['page'], '')){
	$page = '1';
}else{
	$page = $_GET['page'];
	$no = $no-($page-1)*$list_page;
}

$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board'].$search_next.'&idx='.$_GET['idx'].'&view='.$_GET['view'].'&hero_idx='.$_GET['hero_idx'];
######################################################################################################################################################

if(!strcmp($_GET['action'], 'ok')){
    $sql = 'UPDATE board SET hero_board_three=\'1\', hero_loverStarDate = now() WHERE hero_idx = \''.$_GET['new_idx'].'\';'.PHP_EOL;
    @mysql_query($sql);
    msg('선택 되었습니다.','location.href="'.PATH_HOME.'?'.get('action||new_idx','').'"');
    exit;
}else if(!strcmp($_GET['action'], 'no')){
    $sql = 'UPDATE board SET hero_board_three=\'0\' WHERE hero_idx = \''.$_GET['new_idx'].'\';'.PHP_EOL;
    @mysql_query($sql);
    msg('취소 되었습니다.','location.href="'.PATH_HOME.'?'.get('action||new_idx','').'"');
    exit;
}
$level_old_sql = $sql.' order by hero_table,hero_today desc limit '.$start.','.$list_page.';';
$out_level_old_sql = mysql_query($level_old_sql);
$level_old_list                             = @mysql_fetch_assoc($out_level_old_sql);

$level_sql = 'select * from hero_group where hero_board=\''.$level_old_list['hero_table'].'\';';//desc<=
$out_level_sql = mysql_query($level_sql);
$level_list                             = @mysql_fetch_assoc($out_level_sql);

$mission_sql = 'select * from mission where hero_table=\''.$level_old_list['hero_table'].'\' and hero_idx=\''.$_GET['hero_idx'].'\';';//desc<=
$out_mission_sql = mysql_query($mission_sql);
$mission_list                             = @mysql_fetch_assoc($out_mission_sql);

$postScript_sql = "SELECT hero_04 FROM board WHERE hero_01 = ".$_GET['hero_idx']." LIMIT 1";
$out_postScript_sql = mysql_query($postScript_sql);
$postScript_list = @mysql_fetch_assoc($out_postScript_sql);


?>
						<script>
						function excel() {
							$('#form1').attr('action','nail/excel_01_03.php').submit();
							$('#form1').attr('action', '<?=PATH_HOME.'?'.get('page');?>');
						}
						function listCount() {
							$('#form1').submit();
						}
						</script>

<div class="tit_wrap">
	<h4>후기 등록자 상세정보</h4>   
</div>

<div class="searchbox3">
	<div class="wrap_2">
		<form action="<?=PATH_HOME.'?'.get('page');?>" method="GET" id="form1">
			<input type="hidden" name="new_idx" id="new_idx"  />
            <input type="hidden" name="action" id="action" />
            <input type="hidden" name="board" value="<?=$_GET['board']?>" />
            <input type="hidden" name="view" value="<?=$_GET['view']?>" />
            <input type="hidden" name="page" value="<?=$_GET['page']?>"/>
            <input type="hidden" name="hero_idx" value="<?=$_GET['hero_idx']?>"/>
            
            <select name="list_count" id="" style="width:130px;" onchange="listCount()">
            	<option value="">리스트 출력 갯수</option>
            	<option value="20"<?if(!strcmp($_REQUEST['list_count'], '20')){echo ' selected';}else{echo '';}?>>20개</option>
            	<option value="30"<?if(!strcmp($_REQUEST['list_count'], '30')){echo ' selected';}else{echo '';}?>>30개</option>
				<option value="50"<?if(!strcmp($_REQUEST['list_count'], '50')){echo ' selected';}else{echo '';}?>>50개</option>
           	 	<option value="100"<?if(!strcmp($_REQUEST['list_count'], '100')){echo ' selected';}else{echo '';}?>>100개</option>
           		<option value="250"<?if(!strcmp($_REQUEST['list_count'], '250')){echo ' selected';}else{echo '';}?>>250개</option>
            </select>
            
            <select name="select" id="" style='width:70px;'>
				<option value="hero_nick"<?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>닉네임</option>
				<option value="hero_name"<?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>이름</option>
                <option value="hero_title"<?if(!strcmp($_REQUEST['select'], 'hero_title')){echo ' selected';}else{echo '';}?>>제목</option>
				<option value="hero_all"<?if(!strcmp($_REQUEST['select'], 'hero_all')){echo ' selected';}else{echo '';}?>>닉네임+이름+제목</option>
            </select>
            
            <input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];?>" class="kewyword">
            <input type="image" src="../image/bbs/btn_search.gif" alt="검색" class="bd0">
            
            <input type="hidden" name="hero_idx" value="<?=$_GET['hero_idx']?>"/>
            <label><input type="checkbox" value="Y" name="loverStar" style="width:20px;" <?if(!strcmp($_REQUEST['loverStar'], 'Y')){echo ' checked';}else{echo '';}?>/>체크시 우수후기자만 검색</label>
			
		</form>
	</div>
</div>

<div class="btnGroupR">
	 <a href="<?=PATH_HOME.'?'.get('view||hero_idx')?>" class="btn_blue2">목록</a>
     <a href="javascript:;" onclick="excel()" class="btn_blue2">엑셀다운로드</a>
</div>

                        <table class="t_list">
                            <thead>
                                <tr>
                                     <th style="padding:10px;">
										카테고리 : <font color="blue" style="font-weight:800;">
													<?=$level_list['hero_title'];?>
												    </font><br><br>
										제목 : <font color="blue" style="font-weight:800;"><?=$mission_list['hero_title'];?></font><br>
                                        
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>
                                    	<form name="listFrm" id="listFrm">
                       					<input type="hidden" name="mode" value="select" />
                       					<input type="hidden" name="add_point" value="" />
                       					<input type="hidden" name="mission_idx" value="<?=$_GET["hero_idx"]?>" />
                                        <table class="t_list" style="table-layout:fixed;word-wrap:break-word; word-break:break-all;">
                                            <thead>
                                                <tr>
													<th width="30px">NO</td>
													<th width="70px">포인트 설정</th>
                                                    <th width="80px"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_03_02&table_type=hero_id&table_name=아이디")?>">아이디</a></th>
                                                    <th width="60px"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_03_02&table_type=hero_nick&table_name=닉네임")?>">닉네임</a></th>
                                                    <th width="50px"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_03_02&table_type=hero_name&table_name=이름")?>">이름</a></th>
                                                    <th width="50px"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_03_02&table_type=hero_new_name&table_name=받는이름")?>">받는이름</a></th>
                                                    <th width="30px">나이</th>
                                                    <th width="80px"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_03_02&table_type=hero_hp&table_name=전화번호")?>">전화번호</a></th>
                                                    <th width="60px"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_03_02&table_type=hero_address&table_name=받으시는분주소")?>">우편번호</a></td>
                                                    <th width="120px"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_03_02&table_type=hero_address&table_name=받으시는분주소")?>">받으시는분주소</a></td>
                                                    <? if($postScript_list['hero_04']){ ?>
                                                    <th width="110px"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_03_02&table_type=hero_01&table_name=url")?>">후기등록url(구)</a></th>
                                                    <? }else { ?>							
                                                    <th width="130px">블로그URL</th>
                                                    <th width="130px">카페URL</th>
                                                    <th width="130px">SNS URL</th>
                                                    <th width="130px">기타URL</th>
                                                    <? } ?>
                                                    <th width="130px">개선점</th>
                                                    <th width="150px"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_03_02&table_type=hero_02&table_name=신청내용")?>">신청내용</a></td>

                                                    <th width="50px">러버등급</td>
                                                    <th width="50px">포스팅</td>
                                                    <th width="110px">비고</td>
                                                    <th width="70px">등록일</th>
                                                    
                                                    <th width="100px">설정<br/>(포인트적립없이 우수후기 선정)</th>


                                                </tr>
                                            </thead>
                                            <tbody>
<?
                        $sql = $sql.' order by hero_table,hero_today desc limit '.$start.','.$list_page.';';
                        sql($sql);
                        while($list                             = @mysql_fetch_assoc($out_sql)){
                        $level_sql = 'select * from hero_group where hero_board=\''.$list['hero_table'].'\';';//desc<=
                        $out_level_sql = mysql_query($level_sql);
                        $level_list                             = @mysql_fetch_assoc($out_level_sql);

                        $mission_sql = 'select * from mission where hero_table=\''.$list['hero_table'].'\' and hero_idx=\''.$_GET['hero_idx'].'\';';//desc<=
                        $out_mission_sql = mysql_query($mission_sql);
                        $mission_list                             = @mysql_fetch_assoc($out_mission_sql);
                        if(!strcmp($list['hero_board_three'], '1')){
                            $lot_01 = '<font color="red">당첨자</font>';
                        }else{
                            $lot_01 = '';
                        }
						//160610 and hero_old_idx 조건 추가
                        $mission_review_sql = 'select * from mission_review where hero_code=\''.$list['hero_code'].'\' and hero_old_idx=\''.$_GET['hero_idx'].'\';';//desc<=
                        $out_mission_review_sql = mysql_query($mission_review_sql);
                        $mission_review_list                             = @mysql_fetch_assoc($out_mission_review_sql);

                        $member_sql = 'select * from member where hero_code=\''.$list['hero_code'].'\';';//desc<=
                        $out_member_sql = mysql_query($member_sql);
                        $member_list                             = @mysql_fetch_assoc($out_member_sql);
                        
                        $age = date('Y')-substr($member_list['hero_jumin'],0,4)+1;
						
						$blog_url = "";
						$cafe_url = "";
						$sns_url = "";
						$etc_url = "";
						if(!$list['hero_04']){ 
							$blog_url_arr = explode(",",$list['blog_url']);
							$cafe_url_arr = explode(",",$list['cafe_url']);
							$sns_url_arr = explode(",",$list['sns_url']);
							$etc_url_arr = explode(",",$list['etc_url']);
							for($i=0; $i<count($blog_url_arr); $i++) {
								$blog_url .= $blog_url_arr[$i]."<br/><br/>";
							}
							for($i=0; $i<count($cafe_url_arr); $i++) {
								$cafe_url .= $cafe_url_arr[$i]."<br/><br/>";
							}
							for($i=0; $i<count($sns_url_arr); $i++) {
								$sns_url .= $sns_url_arr[$i]."<br/><br/>";
							}
							for($i=0; $i<count($etc_url_arr); $i++) {
								$etc_url .= $etc_url_arr[$i]."<br/><br/>";
							}
						}
                        ?>
                        	<tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
												<td><?=$no?></td>
												<td>
                                                	<input type="checkbox" name="sel_point[<?=$list['hero_idx']?>]" id="sel_point_<?=$list['hero_idx']?>" value="<?=$list['hero_idx']?>"><label for="sel_point_<?=$list['hero_idx']?>">선택</label>
                                                </td>
                                                <td><?=nl2br($member_list['hero_id']);?></td>
                                                <!-- 160610수정 -->
                                                <!--<td><?=nl2br($mission_review_list['hero_id']);?></td>-->
                                                <td><?=nl2br($list['hero_nick']);?></td>
                                                <td><?=nl2br($list['hero_name']);?></td>
                                                <td><?=nl2br($mission_review_list['hero_new_name']);?></td>
                                                <td><?=$age?></td>
                                                <td><?=nl2br($mission_review_list['hero_hp_01']);?>-<?=nl2br($mission_review_list['hero_hp_02']);?>-<?=nl2br($mission_review_list['hero_hp_03']);?></td>
                                                <td><?=nl2br($mission_review_list['hero_address_01']);?></td>
                                                <td><?=nl2br($mission_review_list['hero_address_02']);?> <?=nl2br($mission_review_list['hero_address_03']);?></td>
                                                <? if($list['hero_04']){ ?>
                                                <td><?=nl2br($list['hero_04']);?></td>
                                                <? }else {?>
                                                <td><?=nl2br($blog_url);?></td>
                                                <td><?=nl2br($cafe_url);?></td>
                                                <td><?=nl2br($sns_url)?></td>
                                                <td><?=nl2br($etc_url)?></td>
                                                <? } ?>
                                                <td><?=nl2br($list['hero_upgrade']);?></td>
                                                <td><?=nl2br($mission_review_list['hero_02']);?></td>

                                                <td><?=nl2br($member_list['hero_memo']);?></td>
                                                <td><?=nl2br($member_list['hero_memo_01']);?></td>
                                                <td>
												<?=($member_list['hero_memo_02'])? "<p style='font-size:10.5px; color:red;'>(페)".nl2br($member_list['hero_memo_02'])."</p>" : "" ;?>
												<?=($member_list['hero_memo_03'])? "<p style='font-size:10.5px; color:blue;'>(페)".nl2br($member_list['hero_memo_03'])."</p>" : "" ;?>
												<?=($member_list['hero_memo_04'])? "<p style='font-size:10.5px; color:green;'>(비)".nl2br($member_list['hero_memo_04'])."</p>" : "" ;?>
                                                </td>
                                                <td><?=date( "Y-m-d", strtotime($list['hero_today']));?></td>
                                                <td><?=$lot_01;?><br><br/>
                                                   <input type="checkbox" name="hero_board_three[<?=$list['hero_idx']?>]" id="hero_board_three_<?=$list['hero_idx']?>" value="Y" <?=$list['hero_board_three']=="1" ? "checked":"";?>><label for="hero_board_three_<?=$list['hero_idx']?>">선택</label>
	                                               <input type="hidden" name="sel_hero_idx[]" value="<?=$list['hero_idx']?>" />
                                                </td>
                                            </tr>
                        <?
						$no--;
                        }
                        ?>
                                        </tbody>
                                    </table>
                                    </form>
                                </td>
                            </tr>

                            </tbody>
                        </table>
<div class="btnGroup">
	  <div class="l">
	  	<input type="text" name="point" id="point" value="" />
	  	<a href="javascript:;" onclick="fnPoint()" class="btn_blue2">포인트 지급</a>
	  </div>
	  <div class="r">
	  	<a href="javascript:;" onclick="fnGreatSelect()" class="btn_blue2">우수후기상태변경</a>
	  </div>
	  <!-- <a href="#" onclick="location.href='<?=PATH_HOME.'?'.get('action||new_idx','action=no&new_idx='.$list['hero_idx']);?>'" class="btn_blue2">후기등록 취소</a>-->
</div>
<script>

fnPoint = function() {
	if(!$("#point").val()) {
		alert("지급할 포인트를 입력해주세요");
		$("#point").focus();
		return;
	}

	if(confirm($("#point").val()+"포인트를 지급하시겠습니까?")) {
		$("#listFrm input[name='mode']").val("point");
		$("#listFrm input[name='add_point']").val($("#point").val());

		var formData = $("#listFrm").serialize();

		$.ajax({
			url:"<?=ADMIN_DEFAULT?>/nail/01_03_01_action.php"
			,data:formData
			,type:"POST"
			,dataType:"json"
			,success:function(d){
				//console.log(d);
				if(d.result) {
					alert(d.cnt+"건 "+$("#point").val()+"포인트가 지급되었습니다.");
					location.reload();
				} else {
					alert("변경 중 실패했습니다.\n관리자에게 문의해 주세요.");
				}
			},error:function(e) {
				console.log("::errro::");
				console.log(e);
			}
		})

	}
}

fnGreatSelect = function() {

	if(confirm("우수후기상태를 변경하시겠습니까?")) {
		$("#listFrm input[name='mode']").val("select");
		var formData = $("#listFrm").serialize();
		
		$.ajax({
				url:"<?=ADMIN_DEFAULT?>/nail/01_03_01_action.php"
				,data:formData
				,type:"POST"
				,dataType:"json"
				,success:function(d){
					if(d.result) {
						alert("상태값이 변경되었습니다.");
						location.reload();
					} else {
						alert("변경 중 실패했습니다.\n관리자에게 문의해 주세요.");
					}
				},error:function(e) {
					console.log("::errro::");
					console.log(e);
				}
			})
	}
}

function fnLoverStar(action, new_idx) {
	if(action == "ok") {
		if (confirm("러버스타로 선정하시겠습니까?")){
			$("#action").val(action);
			$("#new_idx").val(new_idx);
		}
	}else {
		if (confirm("러버스타를 취소하시겠습니까?")){
			$("#action").val(action);
			$("#new_idx").val(new_idx);
		}
	}
	$("#form1").submit();
}
</script>

                        <div style="width:100%; text-align:center; margin-top:20px;">
<? include_once PATH_INC_END.'page.php';?>
                        </div>
<? //include_once BOARD_INC_END.'search.php';?>
                        