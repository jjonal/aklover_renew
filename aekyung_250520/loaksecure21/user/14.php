<?
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
//�˻����

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
	
} else if($mission_sel_option > 2 && $mission_sel_option){ //3���� �ı���, ����ı� �Խ��� Ȯ��
	$sql_join_search .= " INNER JOIN board b ON m.hero_code = b.hero_code   ";
	$search2 .= " AND  b.hero_01 = '".$mission_title."' ";
	
	if($mission_sel_option > 3) $search2 .= " AND b.hero_board_three = 1 ";
	
	$search_next .= '&mission_gubun='.$_REQUEST['mission_gubun'];
	$search_next .= '&mission_title='.$_REQUEST['mission_title'];
	$search_next .= '&mission_sel_option='.$_REQUEST['mission_sel_option'];
}

	//������ �ѹ���
	$sql_count = 'SELECT count(*) FROM member WHERE hero_use=0 '.$search.' ORDER BY hero_oldday DESC ';//desc
	
	$sql_count  = " SELECT count(*) FROM ";
	$sql_count .= " (SELECT hero_code, hero_id, hero_nick, hero_name, hero_hp , hero_oldday ";
	$sql_count .= " , (case when hero_chk_phone = 1 then '����' else '�̼���' end) hero_chk_phone ";
	$sql_count .= " , (case when hero_chk_email = 1 then '����' else '�̼���' end) hero_chk_email ";
	$sql_count .= " , (case when hero_sex = 0 then '����' else '����' end) hero_sex ";
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
	
	//������ ����Ʈ
	$sql  = " SELECT m.hero_code, m.hero_id, m.hero_nick, m.hero_name, m.hero_hp, m.hero_oldday ";
	$sql .= " , m.hero_chk_phone , m.hero_chk_email, m.hero_sex, m.hero_age  FROM ";
	$sql .= " (SELECT hero_code, hero_id, hero_nick, hero_name, hero_hp , hero_oldday ";
	$sql .= " , (case when hero_chk_phone = 1 then '����' else '�̼���' end) hero_chk_phone ";
	$sql .= " , (case when hero_chk_email = 1 then '����' else '�̼���' end) hero_chk_email ";
	$sql .= " , (case when hero_sex = 0 then '����' else '����' end) hero_sex ";
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
					
					var option = '<label for="mission_sel_option_1" class="ml10">��û</label><input type="radio" name="mission_sel_option" id="mission_sel_option_1" value="1" '+((option_chk == 1) ? 'checked':'')+'/>';
						option += '<label for="mission_sel_option_2" class="ml10">������</label><input type="radio" name="mission_sel_option" id="mission_sel_option_2" value="2" '+((option_chk == 2) ? 'checked':'')+'/>';
						option += '<label for="mission_sel_option_3" class="ml10">�ı���</label><input type="radio" name="mission_sel_option" id="mission_sel_option_3" value="3" '+((option_chk == 3) ? 'checked':'')+'/>';
						option += '<label for="mission_sel_option_4" class="ml10">����ı�</label><input type="radio" name="mission_sel_option" id="mission_sel_option_4" value="4" '+((option_chk == 4) ? 'checked':'')+'/>';

					$("#mission_title").html(html);
					$("#mission_sel_option").html(option);
					
				},error:function(e){
					alert("�ٽ� �õ��� �ּ���.");
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
		alert("��й�ȣ�� �Է��� �ּ���.");
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
					alert("Ȯ�εǾ����ϴ�.");
					location.reload();
					return;
				} else {
					alert("��й�ȣ�� Ʋ���ϴ�.");
					return;
				}
			},error:function(e){
				console.log(e);
				alert("��� �����߽��ϴ�.")
				return;
			}
		})
}

</script>
<? if(!$_SESSION["passwordSuccess"]) { ?>
<div id="noAuthContents">
	<div style="text-align:center; ">
		<p style="font-size:24px;">��й�ȣ �Է� �� �̿밡���մϴ�.</p>
		
		<div style="margin:30px 0 0 0;">
			<input type="password" name="password" placeholder="��й�ȣ�� �Է��� �ּ���." style="width:200px; height:30px; border:1px solid #376ea6; padding-left:20px;" />
		</div>
		<div style="margin:10px 0 0 0;">
			<a href="#" onClick="fnPasswordCheck();" style="display:block; width:120px; height:30px; line-height:30px; background:#376ea6; color:#fff; margin:0 auto;">Ȯ��</a>
		</div>
	</div>
</div>							
<? } else if($_SESSION["passwordSuccess"] == "Y") {?>					
<div id="authContents">
							<!--�˻�����-->
							<div class="searchbox searchbox_pd">
                            <div class="wrap_1">
	                            <form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>" method="POST" >
	                            <div>
	                            	<label for="age_start">����</label> <input type="text" name="hero_age_start" id="hero_age_start" value="<?=$_REQUEST["hero_age_start"]?>" style="width:60px" maxlength="3" /> ~ <input type="text" name="hero_age_end" id="hero_age_end" value="<?=$_REQUEST["hero_age_end"]?>" style="width:60px" maxlength="3"/>
	                            	
	                            	<label class="ml20">����</label>  <label for="sex_all" class="ml10">��ü</label><input type="radio" name="hero_sex" id="sex_all" value="" <? if($_REQUEST['hero_sex'] == "") echo "checked"; ?>/>
	                            							        <label for="hero_sex_0" class="ml10">��</label><input type="radio" name="hero_sex" id="hero_sex_0" value="0" <? if($_REQUEST['hero_sex'] == "0") echo "checked"; ?>/>
	                            							        <label for="hero_sex_1" class="ml10">��</label><input type="radio" name="hero_sex" id="hero_sex_1" value="1" <? if($_REQUEST['hero_sex'] == "1") echo "checked"; ?>/>
									
									<label class="ml20">��α� ����</label> <label for="hero_blog_00" class="ml10">��α�</label><input type="checkbox" name="hero_blog_00" id="hero_blog_00" value="1" <? if($_REQUEST['hero_blog_00'] == "1") echo "checked"; ?>/>
															  		   <label for="hero_blog_04" class="ml10">�ν�Ÿ</label><input type="checkbox" name="hero_blog_04" id="hero_blog_04" value="1" <? if($_REQUEST['hero_blog_04'] == "1") echo "checked"; ?>/>
								</div>
								
								<div class="mt10">
									<label>������</label>
									<input type="text" name="hero_oldday_start" id="hero_oldday_start" value="<?=$_REQUEST["hero_oldday_start"]?>" />
									~
									<input type="text" name="hero_oldday_end" id="hero_oldday_end" value="<?=$_REQUEST["hero_oldday_end"]?>" />
									
									<span>���ڸ� �Է����ּ���. (��:2019��01��15�� �� ��� 20190115)</span>
									
									<label class="ml20">�޴������ŵ���</label>
									<input type="radio" name="hero_chk_phone" id="hero_chk_phone_all" <? if($_REQUEST['hero_chk_phone'] == "") echo "checked"; ?> value=""  /><label for="hero_chk_phone_all">��ü</label>
									<input type="radio" name="hero_chk_phone" id="hero_chk_phone_1" <? if($_REQUEST['hero_chk_phone'] == "1") echo "checked"; ?> value="1" /><label for="hero_chk_phone_1">����</label>
									<input type="radio" name="hero_chk_phone" id="hero_chk_phone_0" <? if($_REQUEST['hero_chk_phone'] == "0") echo "checked"; ?> value="0" /><label for="hero_chk_phone_0">�̵���</label>
									
									<label class="ml20">�̸��ϼ��ŵ���</label>
									<input type="radio" name="hero_chk_email" id="hero_chk_email_all" <? if($_REQUEST['hero_chk_email'] == "") echo "checked"; ?> value="" /><label for="hero_chk_email_all">��ü</label>
									<input type="radio" name="hero_chk_email" id="hero_chk_email_1" <? if($_REQUEST['hero_chk_email'] == "1") echo "checked"; ?> value="1" /><label for="hero_chk_email_1">����</label>
									<input type="radio" name="hero_chk_email" id="hero_chk_email_0" <? if($_REQUEST['hero_chk_email'] == "0") echo "checked"; ?> value="0" /><label for="hero_chk_email_0">�̵���</label>
							
								</div>
								
								<!-- 190115 �� �߰��ؾ���
								<div class="mt10">
	                                <select name="select" id="" style='width:80px;'>
	                                  <option value="hero_id"<?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>���̵�</option>
	                                  <option value="hero_name"<?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>�̸�
									  </option>
									  <option value="hero_nick"<?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>�г���
									  </option>
	                                </select>
	                                <input name="keyword" type="text" value="<?echo $_REQUEST['keyword'];;?>" class="kewyword">
	                             </div>
	                             
	                             <div class="mt10">
	                             	<label for="">ü��� ����</label> <select name="mission_gubun" style="width:200px; height:24px;" onChange="selMissionGubun(this.value,'','')">
	                             								 	<option value="">����</option>
	                             								 	<option value="group_04_05" <?=$mission_gubun == "group_04_05" ? "selected":""; ?>>ü���</option>
	                             								 	<option value="group_02_03" <?=$mission_gubun == "group_02_03" ? "selected":""; ?>>�Ը����̺�Ʈ</option>
	                             								 	<option value="group_04_07" <?=$mission_gubun == "group_04_07" ? "selected":""; ?>>�ְ�ڽ�</option>
	                             								 	<option value="group_04_06" <?=$mission_gubun == "group_04_06" ? "selected":""; ?>>��ƼŬ��</option>
	                             								 	<option value="group_04_23" <?=$mission_gubun == "group_04_23" ? "selected":""; ?>>�ֽ�Ŭ��</option>
	                             								 </select>
	                             								 
									<span style="color:#f00;">- ü��� ���� �� ü��� ��, ������ ���� �׸��� ����˴ϴ�.(��ϼ�, �ִ�30�� ����)<br/>
															
									</span>
	                             </div>
	                             
	                             <div class="mt10">
	                             	<label for="">ü��� ��</label> <span id="mission_title"></span>
	                             </div>
	                             
	                             <div class="mt10">
	                             	<label for="">������ ����</label> <span id="mission_sel_option"></span>
	                             </div>
	                              -->
	                             
	                             <div class="mt10" style="text-align:center;">
	                             	<a href="javascript:;" onclick="goSearch();" style="display: inline-block;padding:5px 10px; background-color: #666; color:#fff;">�˻��ϱ�</a>
	                             </div>
	                             
	                            </form>
                            </div>
                        </div>
						
						<div style="margin:0 0 10px 0; position:relative;">ȸ�� �� : <?=number_format($count['count(*)']);?>��
							<a href="javascript:;" onclick="excel();" style="display:inline-block;padding:5px 10px; background-color:#559f13; color:#fff; position:absolute; right:0; top:-5px;">��������</a>
							
							<p style="color:#f00; text-align:right; margin-top:10px;">
							   - �޴���, �̸��� �߼� �� �ݵ�� ���ſ� '����'�� ȸ���� ���� �߼�&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br/>
							   - ���������� �ݵ�� �޴���, �̸��� ���ſ� '����'�� ���͸� �� Ȱ���ʿ�
							</p>
						</div>
			
						<table class="t_list">
                            <thead>
                                <tr>
                                    <th width="5%">NO</th>
                                    <th width="10%">���̵�</th>
                                    <th width="10%">�̸�</th>
                                    <th width="10%">�г���</th>
                                    <th width="5%">����</th>
                                    <th width="5%">����</th>
                                    <th width="10%">������</th>
                                    <th width="15%">�޴�����ȣ</th>
                                    <th width="10%">���ڼ��ſ���</th>
                                    <th width="10%">�̸��ϼ��ſ���</th>
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
                        	<td colspan="8" style="test-align:center;">�˻��� ȸ���� �����ϴ�.</td>
                        </tr>
                        <? } ?>

                            </tbody>
                        </table>
						<div style="width:100%; text-align:center; margin-top:20px;">
<? include_once PATH_INC_END.'page.php';?>
                        </div>
</div>
<? } ?>
