<link rel="stylesheet" type="text/css" href="/css/front/lovertalk.css" />
<?
####################################################################################################################################################
## 2015-03 ������ ����
####################################################################################################################################################


## ���� ����
####################################################################################################################################################
if (! defined ( '_HEROBOARD_' ))	exit ();
if(!$_GET['board'] || !$_GET['view'] || !$_GET['action'] || $_SESSION['temp_level']<9999){
	error_historyBack("�߸��� �����Դϴ�.");
	exit;
}

$error = "THUMBNAIL_04_WRITE_01";
$right_sql = "select * from hero_group where hero_board='".$_GET['board']."' and hero_order!='0' and hero_use='1'";
$right_res = new_sql($right_sql,$error,"on");

if($right_res == $error){
	error_historyBack("");
	exit;
}

if($_SESSION['temp_write'])		$mywrite	= 	 $_SESSION['temp_write'];
else							$mywrite	= 	 0;


$right_rs = mysql_fetch_assoc($right_res);
if($right_rs['hero_write'] && $right_rs['hero_write'] > $mywrite){
	error_historyBack("�� �������� ".$right_rs['hero_view']."�������� �̿� �����մϴ�.");
	exit;
}


## ���� ����
######################################################################################################################################################
$board				=	 $_GET['board'];
$idx				=	 $_GET['idx'];

$myid				=	 $_SESSION['temp_id'];
$mycode				=	 $_SESSION['temp_code'];
$mynick				=	 $_SESSION['temp_nick'];
$mylevel			= 	 $_SESSION['temp_level'];

$action				=	 $_GET['action'];

if($_GET['page'])		$page = $_GET['page'];
else					$page = 1;



## ������ �ÿ�
######################################################################################################################################################
if($action=='update'){
	
	$hero_thumb 		= 		$_FILES["hero_thumb"];
	$hero_thumb_temp 	= 		$_POST["hero_thumb_temp"];
	$drop_check 		= 		explode('||', $_POST['hero_drop']);
	
	
	## ����� ó��
	######################################################################################################################################################
	
	
	
	if(is_uploaded_file( $hero_thumb['tmp_name'] )){
			
		$thumb_path = "/user/photo/".date("Y_m")."/";
	
		$temp_name = explode(".",$hero_thumb['name']);
		$temp_extenstion = $temp_name[count($temp_name)-1];
	
		$temp_filename = time()."_".$_SESSION["temp_id"].".".$temp_extenstion;
		$thum_filename = "thum_".$temp_filename;

		$temp_file = $_SERVER["DOCUMENT_ROOT"].$thumb_path.$temp_filename;
		$thumb_file = $_SERVER["DOCUMENT_ROOT"].$thumb_path.$thum_filename;

		if(!is_dir($_SERVER["DOCUMENT_ROOT"].$thumb_path))	mkdir($_SERVER["DOCUMENT_ROOT"].$thumb_path, 0777);

		if(move_uploaded_file($hero_thumb['tmp_name'], $temp_file)){
			
			$im = thumbnail($temp_file, 340, "");
			imagejpeg($im, $thumb_file, 100);
			imagedestroy($im);
			unlink($temp_file);

		$hero_thumb_img = $thumb_path.$thum_filename;
		
		}else{
			logging_error($mycode, $board."-THUMBNAIL_04_UPDATE_02", date("Y-m-d H:i:s"));
			error_historyBack("");
			exit;
		}
	}
	
	
	## �ʿ���� $_POST ����
	######################################################################################################################################################
	foreach ($drop_check as $drop_key => $drop_val) {
		unset($_POST[$drop_val]);
	}
	
	
	//�̺�Ʈ�� ó�� ����ϴ� ���
	if(!$idx){
		
		## auto increase check
		######################################################################################################################################################
		$error = "THUMBNAIL_04_UPDATE_03";
		$idx_sql = "SHOW TABLE STATUS LIKE 'mission_after'";
		$out_idx_sql = new_sql($idx_sql,$error);
		
		if($out_idx_sql==$error)	error_historyBack("");
		
		$idx_list                             = @mysql_fetch_assoc($out_idx_sql);
		
		$good_idx = $idx_list['Auto_increment'];
		

		## ���� ����
		######################################################################################################################################################
		
		$sql_one_write .= 'hero_idx';
		$sql_two_write .= "'".$good_idx."'";
		
		if($hero_thumb){		
			$sql_one_write .= ',hero_thumb';
			$sql_two_write .= ", '".$hero_thumb_img."'";
		}
		
		foreach ($_POST as $post_key => $post_val) {
				
			$sql_one_write .= ", ".$post_key;
			$sql_two_write .= ", '".$post_val."'";
			
		}
		
		$error = "THUMBNAIL_04_UPDATE_04";
		$sql = "INSERT INTO mission_after (".$sql_one_write.") VALUES (".$sql_two_write.");";
		$pf = new_sql($sql,$error);
		if($pf===$error){
			error_historyBack("");
			exit;
		}
		

	//�̺�Ʈ ������Ʈ�ϴ� ���
	}else{
		$error = "THUMBNAIL_04_UPDATE_05";
		$main_query = "select count(*) as count from mission_after where hero_idx='".$idx."'";
		$main_res = new_sql($main_query,$error);
		
		if($main_res == $error){
			error_historyBack("");
			exit;
		}
		     
		$count = mysql_result($main_res,0);
		
		if($count==0){
			error_location("�߸��� �ı� ��� ��ȣ�Դϴ�.","/main/index.php?board=group_04_22");
			exit;
		}
		
		
		$i=0;
		foreach ($_POST as $post_key => $post_val) {
			
			if($i==0)	$sql_one_update .= $post_key."='".$post_val."'";
			else		$sql_one_update .= ", ".$post_key."='".$post_val."'";
			$i++;
		
		}
		if($hero_thumb_img)						$sql_one_update .= ", hero_thumb = '".$hero_thumb_img."'";
		
		
		$msg .= '���� �Ǿ����ϴ�.';
		$error = "THUMBNAIL_04_UPDATE_06";
		$sql = "UPDATE mission_after SET ".$sql_one_update." WHERE hero_idx = '".$idx."'";
		
		$out_sql = new_sql($sql,$error);
		if($out_sql===$error){
				
			error_historyBack("");
			exit;				
		}
		
		
	}
	
	location(MAIN_HOME."?board=".$board);
	exit;
	
## ���� �ÿ�
######################################################################################################################################################
}elseif($action=='action_delete'){
	$error = "THUMBNAIL_04_DEL_01";
	$del_sql = "delete from mission_after where hero_idx='".$idx."'";
	//echo $del_sql;
	//exit;
	$del_res = new_sql($del_sql,$error);
	if((string)$del_res==$error){
		error_historyBack("");
		exit;
	}
	
	error_location("�����Ǿ����ϴ�.","/main/index.php?board=group_04_22");
	exit;
}

$error = "THUMBNAIL_04_WRITE_07";
$mission_sql1 = "select hero_idx, hero_title from mission where hero_table = 'group_04_05' order by hero_idx desc";
$mission_res1 = new_sql($mission_sql1,$error);

if($mission_res1 == $error){
	error_historyBack("");
	exit;
}

while($mission_rs1 = mysql_fetch_assoc($mission_res1)){
	$mission_option1 .= "<option value='".$mission_rs1['hero_idx']."'>";
	$mission_option1 .= $mission_rs1['hero_title'];
	$mission_option1 .= "</option>";

}


$mission_sql2 = "select hero_idx, hero_title from mission where hero_table = 'group_04_06' order by hero_idx desc";
$mission_res2 = new_sql($mission_sql2,$error);

if($mission_res2 == $error){
    error_historyBack("");
    exit;
}

while($mission_rs2 = mysql_fetch_assoc($mission_res2)){
    $mission_option2 .= "<option value='".$mission_rs2['hero_idx']."'>";
    $mission_option2 .= $mission_rs2['hero_title'];
    $mission_option2 .= "</option>";
    
}

$mission_sql3 = "select hero_idx, hero_title from mission where hero_table = 'group_04_28' order by hero_idx desc";
$mission_res3 = new_sql($mission_sql3,$error);

if($mission_res3 == $error){
    error_historyBack("");
    exit;
}

while($mission_rs3 = mysql_fetch_assoc($mission_res3)){
    $mission_option3 .= "<option value='".$mission_rs3['hero_idx']."'>";
    $mission_option3 .= $mission_rs3['hero_title'];
    $mission_option3 .= "</option>";
    
}


if($idx){
	$error = "THUMBNAIL_04_WRITE_08";
	$mission_after_sql  = "select * from mission_after where hero_idx='".$idx."'";
	//echo $board_sql;
	$mission_after_res = new_sql($mission_after_sql,$error);
	
	if($mission_after_res == $error){
		error_historyBack("");
		exit;
	}
	
	$mission_after_rs = mysql_fetch_assoc($mission_after_res);
	$hero_old_idx = explode(",",$mission_after_rs["hero_old_idx"]);
	for($i=0;count($hero_old_idx)>$i;$i++){
		if($i==0)	$old_idx = $hero_old_idx[$i];
		else		$old_idx .= ",".$hero_old_idx[$i];
	}
	
	if($mission_after_rs["hero_old_idx"]!=""){
		
		$error = "THUMBNAIL_04_WRITE_09";
		$board_sql = "select hero_idx, hero_table, left(hero_nick,4) as hero_nick, left(hero_title,48) as hero_title, left(hero_today,10) as hero_today from board as B where hero_idx in (".$old_idx.")";
		//echo $board_sql;
		$board_res = new_sql($board_sql,$error);
	
		if($board_res == $error){
			error_historyBack("");
			exit;
		}
			
	}
	
}



?>

<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

	<div id="subpage" class="talk_write review_write">		
		<div class="sub_cont">
			<div class="sub_wrap board_wrap f_sb">
				<div class="contents right view_cont">					
					<form name="frm" method="post" action="<?=MAIN_HOME;?>?board=<?=$board?>&view=step_write&action=update&idx=<?=$idx?>&page=<?=$page?>" enctype="multipart/form-data">
						<input type="hidden" name="hero_drop" value="hero_drop||hero_thumb||x||y">
						<input type="hidden" name="hero_old_idx" value="<?=$old_idx?>">
						<input type="hidden" name="hero_code" value="<?=$mycode?>"> 
						<input type="hidden" name="hero_today" value="<?=date("Y-m-d H:i:s")?>">
						<div class="write_cont">
							<div class="cont_top">
                                <h2 class="fz15 fw600 main_c">���� ������</h2>
                            </div>
							<!-- ���� -->
							<p class="tit mgb25"><input type="text" name="hero_title" value="<?=$mission_after_rs['hero_title']?>" placeholder="������ �Է��ϼ���."/></p>
							<div class="upfile f_cs">
                                <p class="list_tit fz17 fw500">��ǥ �̹���</p>
								<div id="present_image_area">
									<?php if($idx){?>
										<img src="<?=$mission_after_rs['hero_thumb']?>" id="hero_thumb_temp" alt="��ǥ �̹���" style="margin-right: 5rem">
									<?php }?>									
								</div>
                                <div class="upfile_inner rel">								
									<input type="file" id="hero_thumb" name="hero_thumb"/>
                                   	<label for="hero_thumb" id="link" class="custom-file-upload">���ϼ���<img src="/img/front/icon/fileup.webp" alt="÷������ ���ε�"></label>
                                </div>	
                            </div>
							<div class="warn mgb25">       
								<p class="fz15 op05">(�̹��� ũ�� 340*254)</p>		
							</div>	
							<div class="mgb25 f_cs">     
                                <p class="list_tit fz17 fw500">�Ⱓ</p>
                                <div class="f_cs">
                                    <input type="text" name="hero_period_01" value="<?=$mission_after_rs['hero_period_01']?>" class="dateType narrow" style="font-size: 1.6rem; text-align: center;"/>
                                     ~ 
                                    <input type="text" value="<?=$mission_after_rs['hero_period_02']?>" name="hero_period_02" class="dateType narrow" style="font-size: 1.6rem; text-align: center;" />
                                </div>
                            </div>
							<div class="mgb25 f_cs">     
                                <p class="list_tit fz17 fw500">��ϵ� ����</p>
                            </div>							
							<dl class="event_result">
							</dl>
							<div class="btngroup f_c" style="gap: 1rem;">
								<a href="<?=PATH_HOME.'?'."board=".$board."&page=".$page;?>" class="btn_submit btn_gray">�������</a>
								<a href="<?=PATH_HOME.'?'."board=".$board."&view=step_write&action=action_delete&idx=".$_GET['idx'];?>" class="btn_submit btn_black">�����ϱ�</a>
								<a href="#" onclick="javascript:doSubmit();" class="btn_submit btn_main_c">����ϱ�</a>
							</div>								
							<div class="review_cate category mgb20">								
								<div class="mgb25 f_cs">  
									<p class="list_tit fz17 fw500">ü��� ����</p>
									<select onchange="get_event_category(this);" class="wr_select">
										<option value="group_04_05">ü���</option>
										<option value="group_04_06">��ƼŬ��</option>
										<option value="group_04_28">������Ŭ��</option>
									</select>	
									<select id="THUMBNAIL_04_category_option1" onchange="get_event_data(this,'mission',1);" class="wr_select">
										<?=$mission_option1?>
									</select>
									
									<select id="THUMBNAIL_04_category_option2" onchange="get_event_data(this,'mission',1);" style="display:none;" class="wr_select">
										<?=$mission_option2?>
									</select>
									
									<select id="THUMBNAIL_04_category_option3" onchange="get_event_data(this,'mission',1);" style="display:none;" class="wr_select">
										<?=$mission_option3?>
									</select>			
								</div>		
								<div class="mgb25 f_cs search_end">     
									<p class="list_tit fz17 fw500">�˻�</p>
									<div class="f_cs">
										<div class="mu_searchbox rel">
											<select id="THUMBNAIL_04_search_option">
												<option value="">����</option>
												<option value="title">����</option>
												<option value="command">����</option>
												<option value="nick">�г���</option>
												<option value="code">���̵�</option>
												<option value="name">����</option>
												<option value="total">��ü</option>
											</select>												
											<input type="text" id="THUMBNAIL_04_search"/>
											<div class="THUMBNAIL_04_btn mu_search_btn" onclick="get_event_data(this,'search',1);"></div>
										</div>
									</div>
								</div>
								<dl class="event_result"></dl>			    
							</div>	
						</div>						
					</form>
				</div>
			</div>
		</div>
	</div>
	

<script>

	$(document).ready(function(){
		<? if($idx){?>
			get_event_data(document.getElementsByName("hero_old_idx")[0],'enroll',0);
		<?}?>
		
		var dates = $(".dateType").datepicker({
 	       monthNames: ['�� 1��','�� 2��','�� 3��','�� 4��','�� 5��','�� 6��','�� 7��','�� 8��','�� 9��','�� 10��','�� 11��','�� 12��'],
    	    dayNamesMin: ['��', '��', 'ȭ', '��', '��', '��', '��'],
        	defaultDate: null,
        	showMonthAfterYear:true,
        	dateFormat: 'yy-mm-dd'
    	});
		
	});

	function doSubmit (){
		var theform = document.frm;
		var title = document.frm.hero_title;
	    var thumb = document.frm.hero_thumb;
	    var thumb_temp = document.getElementById("hero_thumb_temp");
	    var hero_old_idx = document.frm.hero_old_idx;
	    
	    if(title.value==''){
			alert("������ �Է��� �ּ���.");
			title.focus();
			return false;
		}

		if(thumb.value=='' && thumb_temp.src==''){
			alert("��ǥ �̹����� ����� �ּ���.");
			thumb.focus();
			return false;
		}

		if(hero_old_idx.value==''){
			alert("���µ� ���䰡 �����ϴ�.");
			return false;
		}
	
	    theform.submit();
	    return false;
	}
	

	function enroll_review(mode){

		var event_check;
		var hero_old_idx = document.getElementsByName("hero_old_idx")[0];

		if(mode=='enroll'){
			event_check = $(".event_result").eq(1).find("input:checkbox");
		}else if(mode=='cancle'){
			event_check = $(".event_result").eq(0).find("input:checkbox");
		}

		var checked_list = "";

		for(var i=0; event_check.length>i; i++){
			var checked = event_check[i].checked;
			if(checked==true){

				if(checked_list==''){
					checked_list = event_check[i].value;
				}else{
					checked_list += ","+event_check[i].value;
				}
			}

		}

		if(checked_list==''){
			alert("���õ� ���䰡 �����ϴ�.");
			return false;
		}

		if(mode=='cancle'){
			checked_list_arr = checked_list.split(",");
			checked_list = hero_old_idx.value;
			for(var i=0; checked_list_arr.length>i; i++){

				if(checked_list.indexOf(checked_list_arr[i])!='-1'){
					if(checked_list.indexOf(checked_list_arr[i])==0){
						checked_list = checked_list.replace(checked_list_arr[i]+",","");
					}else{
						checked_list = checked_list.replace(","+checked_list_arr[i],"");
					}
				}

			}
		}
		
		if(hero_old_idx.value!="" && mode!='cancle'){
			checked_list = hero_old_idx.value+","+checked_list;
		}
		//alert(checked_list);
		hero_old_idx.value=checked_list;
		get_event_data(hero_old_idx,'enroll',0);
		return false;
	}


	function get_event_category(obj) {
		var this_value = obj.value;
		
		if(this_value == 'group_04_05') {
			document.getElementById("THUMBNAIL_04_category_option1").style.display="";
			document.getElementById("THUMBNAIL_04_category_option2").style.display="none";
			document.getElementById("THUMBNAIL_04_category_option3").style.display="none";	
			get_event_data(document.getElementById("THUMBNAIL_04_category_option1"),'mission',1);		
		} else if(this_value == 'group_04_06') {
			document.getElementById("THUMBNAIL_04_category_option1").style.display="none";
			document.getElementById("THUMBNAIL_04_category_option2").style.display="";
			document.getElementById("THUMBNAIL_04_category_option3").style.display="none";
			get_event_data(document.getElementById("THUMBNAIL_04_category_option2"),'mission',1);	
		} else if(this_value == 'group_04_28') {
			document.getElementById("THUMBNAIL_04_category_option1").style.display="none";
			document.getElementById("THUMBNAIL_04_category_option2").style.display="none";
			document.getElementById("THUMBNAIL_04_category_option3").style.display="";
			get_event_data(document.getElementById("THUMBNAIL_04_category_option3"),'mission',1);
		}
	}
	
	function get_event_data(obj,type,idx){

		var this_value = obj.value; 
		var post_url = "search_event.php";
		var params = "";
		var button_mode = "";
		var hero_old_idx = document.getElementsByName("hero_old_idx")[0];
		
		if(type=='mission'){
			params="idx="+this_value;
			button_mode = "enroll";
			button_text = "���� ���"; 
		
		}else if(type=='search'){
			var mode = document.getElementById("THUMBNAIL_04_search_option").value;
			var this_value = document.getElementById("THUMBNAIL_04_search").value;
			
			if(mode==''){	
				alert("�˻� �ɼ��� �������ּ���.");
				return false;
			}else if(this_value==''){
				alert("�˻�� �Է����ּ���.");
				return false;
			}
			params = "search_mode="+mode+"&search_text="+this_value;
			button_mode = "enroll"; 
			button_text = "���� ���";
		
		}else if(type=='enroll'){
			
			params="idxs="+this_value;
			button_mode = "cancle";
			button_text = "���� ����";  
		}
			

		$.ajax({
			url: post_url,
			type: "POST",
			data:params,
			success: function(data){
				data = trim(data);
				$(".event_result").eq(idx).html(data);
				if(data==0){
					alert("�˼��մϴ�. �ý��� �����Դϴ�. �ٽ� �õ����ּ���. ���� ������ �ݺ��� ��� �����Ϳ� �������ּ���.");
					return false;
				}else if(trim(data).substring(0,7)=='message'){
					var data_splited = data.split(":");
					alert(data_splited[1]);
				}else{

					var table_th = "";
					table_th = "";

					table_th += "<table>";
					table_th += "<colgroup>";
					table_th += "<col width='5%'>";
					table_th += "<col width='5%'>";
					table_th += "<col width='25%'>";
					table_th += "<col width='15%'>";
					table_th += "<col width='*'>";
					table_th += "<col width='130px'>";
					table_th += "</colgroup>";
					table_th += "<thead>";
					table_th += "<tr>";
					table_th += "<th><input type='checkbox' onclick='allCheck(this,"+idx+")' value=''></th>";
					table_th += "<th>NO</th>";
					table_th += "<th>�����</th>";
					table_th += "<th>�г���</th>";
					table_th += "<th>����</th>";
					table_th += "<th>�����</th>";
					table_th += "</tr>";
					table_th += "</thead>";
					table_th += "<tbody>";
					table_th += unescape(data);					
					table_th += "</tbody>";
					table_th += "</table>"; 
					table_th += "<div class='btn_thum4'><div class='btn_submit mini btn_gray main_c' onclick='enroll_review(\""+button_mode+"\");'>"+button_text+"</div></div>";
					
					
					$(".event_result").eq(idx).html(table_th);
				}
			},
			error:function(e){  
				alert("�˼��մϴ�. �̹��� ���ε� �����Դϴ�. �ٽ� �õ����ּ���. ���� ������ �ݺ��� ��� �����Ϳ� �������ּ���.");
				return false;
	        }  
		});
	}

	function allCheck(obj,arrNo){
		var check_tf=false;
		if(obj.checked==true){
			check_tf=true
		}else{
			check_tf=false;
		}
		var event_check = $(".event_result").eq(arrNo).find("input:checkbox");
		
		for(var i=0; event_check.length>i; i++){
			event_check[i].checked = check_tf;
		}
	}
</script>