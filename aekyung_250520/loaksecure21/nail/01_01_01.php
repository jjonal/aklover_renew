<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$search = '1=1 ';
$search_next="&list_count=".$_REQUEST['list_count']."";
if(strcmp($_REQUEST['kewyword'], '')){
	if(!strcmp($_REQUEST['select'], 'hero_all')){
		$search .= ' and ( hero_nick like \'%'.$_REQUEST['kewyword'].'%\' or hero_id like \'%'.$_REQUEST['kewyword'].'%\' or';
		$search .= ' hero_name like \'%'.$_REQUEST['kewyword'].'%\' or hero_new_name like \'%'.$_REQUEST['kewyword'].'%\') ';
		$search_next .= '&select='.$_REQUEST['select'].'&kewyword='.$_REQUEST['kewyword'];
	}else{
		$search .= 'and '.$_REQUEST['select'].' like \'%'.$_REQUEST['kewyword'].'%\'';
		$search_next .= '&select='.$_REQUEST['select'].'&kewyword='.$_REQUEST['kewyword'];
	}
}
if(!strcmp($_REQUEST['winner'], 'Y')) {
	$search .= 'and lot_01 = 1';
	$search_next .= "&winner=".$_REQUEST['winner']."";
}
######################################################################################################################################################
$sql = 'select * from mission_review where '.$search.' and hero_old_idx=\''.$_GET['hero_idx'].'\'';
sql($sql);

$total_data = @mysql_num_rows($out_sql);

/////////// no ���� 20140509
$i=$total_data;

######################################################################################################################################################
$list_page=$_REQUEST['list_count']==""?50:$_REQUEST['list_count'];
$page_per_list=5;

if(!strcmp($_GET['page'], '')){
	$page = '1';
}else{
	$page = $_GET['page'];
	
	/////////// no ���� 20140509
	$i = $i-($page-1)*$list_page;
}

$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board'].$search_next.'&idx='.$_GET['idx'].'&view='.$_GET['view'].'&hero_idx='.$_GET['hero_idx'];
######################################################################################################################################################
if(!strcmp($_GET['action'], 'ok')){
    $sql = 'UPDATE mission_review SET lot_01=\'1\' WHERE hero_idx = \''.$_GET['new_idx'].'\';'.PHP_EOL;
    @mysql_query($sql);
    msg('���� �Ǿ����ϴ�.','location.href="'.PATH_HOME.'?'.get('action||new_idx','').'"');
    exit;
}else if(!strcmp($_GET['action'], 'no')){
    $sql = 'UPDATE mission_review SET lot_01=\'0\' WHERE hero_idx = \''.$_GET['new_idx'].'\';'.PHP_EOL;
    @mysql_query($sql);
    msg('��� �Ǿ����ϴ�.','location.href="'.PATH_HOME.'?'.get('action||new_idx','').'"');
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

$ask_arr = array();
if($mission_list["hero_ask"]) {
	$ask_arr = explode("/////",$mission_list["hero_ask"]);
}

$multiple_arr = array();
if($mission_list["hero_multiple"]) {
	$multiple_arr = explode("/////",$mission_list["hero_multiple"]);
}

$single_arr = array();
if($mission_list["hero_single"]) {
	$single_arr = explode("/////",$mission_list["hero_single"]);
}

?>
<script>
function excel() {
	$('#searchForm').attr('action','nail/excel_01_01.php').submit();
	$('#searchForm').attr('action', '<?=PATH_HOME.'?'.get('page');?>');
}
function listCount() {
	$('#searchForm').submit();
}
</script>

<div class="tit_wrap">
	<h4>��û�� ������</h4>   
</div>

<div class="searchbox3">
	<div class="wrap_2">
    	<form action="<?=PATH_HOME.'?'.get('page');?>" method="POST" id="searchForm">
    		
        	<select name="list_count" id="" style="width:130px;" onchange="listCount()">
            	<option value="">����Ʈ ��� ����</option>
				<option value="20"<?if(!strcmp($_REQUEST['list_count'], '20')){echo ' selected';}else{echo '';}?>>20��</option>
				<option value="30"<?if(!strcmp($_REQUEST['list_count'], '30')){echo ' selected';}else{echo '';}?>>30��</option>
      			<option value="50"<?if(!strcmp($_REQUEST['list_count'], '50')){echo ' selected';}else{echo '';}?>>50��</option>
				<option value="100"<?if(!strcmp($_REQUEST['list_count'], '100')){echo ' selected';}else{echo '';}?>>100��</option>
				<option value="100"<?if(!strcmp($_REQUEST['list_count'], '250')){echo ' selected';}else{echo '';}?>>250��</option>
			</select>
			
			<select name="select" id="" style="width:70px;">
            	<option value="hero_nick"<?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>�г���</option>
                <option value="hero_id"<?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>���̵�</option>
                <option value="hero_name"<?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>�̸�</option>
                <option value="hero_new_name"<?if(!strcmp($_REQUEST['select'], 'hero_new_name')){echo ' selected';}else{echo '';}?>>�޴��̸�</option>
  				<option value="hero_all"<?if(!strcmp($_REQUEST['select'], 'hero_all')){echo ' selected';}else{echo '';}?>>�г���+���̵�+�̸�+�޴��̸�</option>
  			</select>
            
            <input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];?>" class="kewyword">
            <input type="image" src="../image/bbs/btn_search.gif" alt="�˻�" class="bd0">
            <input type="hidden" name="hero_idx" value="<?=$_GET['hero_idx']?>" />

			<label><input type="checkbox" value="Y" name="winner" style="width:20px;" <?if(!strcmp($_REQUEST['winner'], 'Y')){echo ' checked';}else{echo '';}?>/>üũ�� ��÷�ڸ� �˻�</label>
            
		</form>
	</div>
</div>
							
<div class="upload_wrap">
	<form id="form_excel" name="form_excel" method="post" enctype="multipart/form-data">
		<input type="hidden" name="mission_idx" value="<?=$_GET["hero_idx"]?>" />
		<b>����Ʈ :</b>
		<input type="text" name="point" id="excel_point" placeholder="���ڸ� �Է����ּ���"/>
		<input type="file" id="upload_excel" name="upload_excel" />
		<a href="javascript:;" id="btn_upload" style="display: inline-block;padding:5px 10px; background-color: #6799FF; color:#fff;">���ε��ϱ�</a>
	</form>
</div>

<div class="btnGroupR">
	 <a href="javascript:;" onclick="fnPopupPostscriptSelect('<?=$_GET["hero_idx"]?>')" class="btn_blue2">�ı� ��÷�� ����</a>
	 <a href="javascript:;" onclick="excel()" class="btn_blue2">�����ٿ�ε�</a>
	 <a href="<?=PATH_HOME.'?'.get('view||hero_idx')?>" class="btn_blue2">���</a>
</div>
                        	
                        	<script>
							$(document).ready(function(){
								$(document).on('click', '#btn_upload', function(e){
									e.preventDefault();

									if( $("#excel_point").val() == "" ) {
										alert("����Ʈ ������ �Է��ϼ���");
										$("#excel_point").focus();
										return;
									}
							
									var _data = new FormData($('#form_excel')[0]);
									console.log(_data);
									var options = {
										url:		"<?=ADMIN_DEFAULT?>/nail/excelUpload.php",
										data:		_data, 
										cache:		false,
										async:		false,
										processData: false,	
										type:		"POST",
										contentType:false,
										success:	function(result) {
											if (result.success) {
												alert(result.cnt+'�� ����Ʈ �ԷµǾ����ϴ�.');
												document.location.reload();
											} else{
												if(result.status == "noFile") {
													alert("������ Ȯ�����ּ���.");
													document.location.reload();
												}else if(result.status == "insertError") {
													alert("�Է¿����Դϴ�. �����ڿ��� ���ǹٶ��ϴ�.");
													document.location.reload();
												}
											}
										},error:function(request,status,error){
									        console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
									       }
									};
									
									if( confirm('���������� ���ε� �Ͻðڽ��ϱ�?') ){
										$.ajax(options);
									}
								});
							})
                        	</script>
                        </center>
                        <form name="listFrm" id="listFrm">
                        <input type="hidden" name="mode" value="select" />
                        <table class="t_list">
                            <thead>
                                <tr>
									<th style="padding:10px;">
                                        ī�װ� : <font color="blue" style="font-weight:800;">
													<?=$level_list['hero_title'];?>
												    </font><br><br>
										���� : <font color="blue" style="font-weight:800;"><?=$mission_list['hero_title'];?></font><br>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td style="border:none;">
                                    	<div id="tb_scroll" style="overflow:scroll; height:600px">
	                                        <table class="t_list" style="table-layout:fixed;word-wrap:break-word; word-break:break-all;">
	                                            <thead>
	                                                <tr>
														<th width="50">��û��ȣ</th>
	                                                    <th width="100"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_01_02&table_type=hero_id&table_name=���̵�")?>">���̵�</a></th>
	                                                    <th width="100"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_01_02&table_type=hero_nick&table_name=�г���")?>">�г���</a></th>
	                                                    <th width="100"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_01_02&table_type=hero_name&table_name=�̸�")?>">�̸�</a></th>
	                                                    <th width="100"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_01_02&table_type=hero_new_name&table_name=�޴��̸�")?>">�޴��̸�</a></th>
	                                                    <th width="50">���ɴ�</th>
	                                                    <th width="100"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_01_02&table_type=hero_hp&table_name=��ȭ��ȣ")?>">��ȭ��ȣ</a></th>
	                                                    <th width="100"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_01_02&table_type=hero_address&table_name=�����ôº��ּ�")?>">�����ȣ</a></th>
	                                                    <th width="200"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_01_02&table_type=hero_address&table_name=�����ôº��ּ�")?>">�����ôº��ּ�</a></th>
	                                                    <!-- <th width="100"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_01_02&table_type=hero_03&table_name=��û�ʼ�����")?>">��û�ʼ�����</a></th>-->
	                                                    <th width="200"><a href="<?=PATH_HOME."?".get("view||table_type||table_name","view=01_01_02&table_type=hero_01&table_name=url")?>">url</a></th>
	                                                    <? if($mission_list['hero_type'] == 2) { ?>
	                                                    <th width="200">��� URL(�ҹ�����)</th>
	                                                    <? } ?>
	                                                    <th width="50">�湮�ڼ�</th>
	                                                    <th width="50">������</th>
	                                                    <th width="50">�ȷο���</th>
	                                                    <th width="200">���</th>
	                                                    <th width="50">�����н�</th>
	                                                    <? foreach($ask_arr as $val) {?>
	                                                    <th width="200"><?=$val?></th>
	                                                    <? } ?>
	                                                    <? foreach($multiple_arr as $val) {?>
	                                                    <th width="200"><?=$val?></th>
	                                                    <? } ?>
	                                                    <? foreach($single_arr as $val) {?>
	                                                    <th width="200"><?=$val?></th>
	                                                    <? } ?>
	                                                    <th width="100">�����</th>
	                                                    <th width="100">����</th>
	
	                                                </tr>
	                                            </thead>
	                                            <tbody>
	<?
	                        $sql = $sql.' order by hero_table,hero_today desc limit '.$start.','.$list_page.';';
	                        sql($sql);
	                        while($list                             = @mysql_fetch_assoc($out_sql)){
	                        	
	                        	if(!empty($ask_arr)) $ask_answer_arr = explode("/////",$list["hero_03"]);
	                        	if(!empty($multiple_arr)) $multiple_answer_arr = explode("/////",$list["hero_multiple"]);
	                        	if(!empty($single_arr)) $single_answer_arr = explode("/////",$list["hero_single"]);
	                        	
	
	                        if(!strcmp($list['lot_01'], '1')){
								if($mission_list['hero_type'] == 2) { 
		                            $lot_01 = '<span style="color:#f00">�ҹ����� ��÷��</span>';
								}else {
									$lot_01 = '<span style="color:#f00">�ı� ��ϰ�����</span>';
								}
	                        }else{
	                            $lot_01 = '';
	                        }
	
	                        $member_sql = "select * from member where hero_code='".$list['hero_code']."';";
	                        $out_member_sql = @mysql_query($member_sql);
	                        $member_list                             = @mysql_fetch_assoc($out_member_sql);
							
							if($mission_list['hero_type'] == 2) { 
								$board_sql = "select hero_04 from board where hero_01 = '".$_GET['hero_idx']."'";
								$out_board_sql = mysql_query($board_sql);
								$board_list                             = @mysql_fetch_assoc($out_board_sql);
							}
		                        
	                        	if($member_list['hero_jumin'])               	$age = date('Y')-substr($member_list['hero_jumin'],0,4)+1;
	                        	else											$age = '';
	
	                        ?>
	                                            <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
													<td><?=$list['hero_number']?></td>  
	                                                <td><?=nl2br($list['hero_id']);?></td>
	                                                <td><?=nl2br($list['hero_nick']);?></td>
	                                                <td><?=nl2br($list['hero_name']);?></td>
	                                                <td><?=nl2br($list['hero_new_name']);?></td>
	                                                <td><?=$age?></td>
	                                                <td><?=nl2br($list['hero_hp_01']);?>-<?=nl2br($list['hero_hp_02']);?>-<?=nl2br($list['hero_hp_03']);?></td>
	                                                <td><?=nl2br($list['hero_address_01']);?></td>
	                                                <td><?=nl2br($list['hero_address_02']);?> <?=nl2br($list['hero_address_03']);?></td>
	                                                <td>
	                                                <?php 
														if($list['hero_01'])	{
															$hero_01 = explode(",",$list['hero_01']);
															foreach ($hero_01 as $value){
													?>
															<?=$value?><br/>
													<?php }
														}
													?>
	                                                </td>
	                                                <? if($mission_list['hero_type'] == 2) { ?>
	                                               <td><?=$board_list['hero_04'];?></td>
	                                                <? } ?>
	
	                                                <td><?=$member_list['hero_memo'];?></td>
	                                                <td><?=$member_list['hero_memo_01'];?></td>
	                                                <td><?=$member_list['hero_insta_cnt'];?></td>
	                                                <td>
	                                                <?=($member_list['hero_memo_02'])? "<p style='font-size:10.5px; color:red;'>(��)".nl2br($member_list['hero_memo_02'])."</p>" : "" ;?>
													<?=($member_list['hero_memo_03'])? "<p style='font-size:10.5px; color:blue;'>(��)".nl2br($member_list['hero_memo_03'])."</p>" : "" ;?>
													<?=($member_list['hero_memo_04'])? "<p style='font-size:10.5px; color:green;'>(��)".nl2br($member_list['hero_memo_04'])."</p>" : "" ;?>
	                                                </td>
	                                                <td><?=$list['hero_superpass'];?></td>
	                                                <? foreach($ask_answer_arr as $val) {?>
	                                                <td><?=$val?></td>
	                                                <? } ?>
	                                                 <? foreach($multiple_answer_arr as $val) {?>
	                                                <td><?=$val?></td>
	                                                <? } ?>
	                                                 <? foreach($single_answer_arr as $val) {?>
	                                                <td><?=$val?></td>
	                                                <? } ?>
	                                                <td><?=date( "Y-m-d", strtotime($list['hero_today']));?></td>
	                                                <td><?=$lot_01;?><br>
	                                                	
	                                                	<input type="checkbox" name="lot_01[<?=$list['hero_idx']?>]" id="lot_01_<?=$list['hero_idx']?>" value="Y" <?=$list['lot_01']=="1" ? "checked":"";?>><label for="lot_01_<?=$list['hero_idx']?>">����</label>
	                                                	<input type="hidden" name="sel_hero_idx[]" value="<?=$list['hero_idx']?>" />
	                                                	
	                                                	<!-- 
	                                                    <a href="#" onclick="location.href='<?=PATH_HOME.'?'.get('action||new_idx','action=ok&new_idx='.$list['hero_idx']);?>'" class="btn_blue2">����</a>
	                                                    <a href="#" onclick="location.href='<?=PATH_HOME.'?'.get('action||new_idx','action=no&new_idx='.$list['hero_idx']);?>'" class="btn_blue2">���</a>
	                                                    -->
	
	                                                </td>
	                                            </tr>
	                        <?
							 $i--;
	                        }
	                        ?>
	                                        </tbody>
	                                    </table>
	                                   </div>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                        </form>
                        
<div class="btnGroupR">
	  <a href="javascript:;" onclick="fnPostscriptSelect()" class="btn_blue2">�ı���º���</a>
	  <!-- <a href="#" onclick="location.href='<?=PATH_HOME.'?'.get('action||new_idx','action=no&new_idx='.$list['hero_idx']);?>'" class="btn_blue2">�ı��� ���</a>-->
</div>

                        <div style="width:100%; text-align:center; margin-top:20px;">
<? include_once PATH_INC_END.'page.php';?>
                        </div>
<? //include_once BOARD_INC_END.'search.php';?>
<script>
$(document).ready(function() {
	var w_cont = $(".cont").width();
	$("#tb_scroll").css("width",w_cont);

	fnPostscriptSelect = function() {

		if(confirm("�ı��ϻ��¸� �����Ͻðڽ��ϱ�?")) {
			
			var formData = $("#listFrm").serialize();
			
			$.ajax({
					url:"<?=ADMIN_DEFAULT?>/nail/01_01_01_action.php"
					,data:formData
					,type:"POST"
					,dataType:"json"
					,success:function(d){
						if(d.result) {
							alert("���°��� ����Ǿ����ϴ�.");
							location.reload();
						} else {
							alert("���� �� �����߽��ϴ�.\n�����ڿ��� ������ �ּ���.");
						}
					},error:function(e) {
						console.log("::errro::");
						console.log(e);
					}
				})
		}
	}

	fnPopupPostscriptSelect = function(hero_old_idx) {
		var popup_01_01_01 = window.open('/loaksecure21/nail/popup_01_01_01.php?hero_old_idx='+hero_old_idx,'popup_01_01_01','width=600, height=600');
		popup_01_01_01.focus();
	}
})
</script>
							