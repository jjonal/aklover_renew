<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################


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



######################################################################################################################################################
$sql = 'select * from member where hero_use=0 and hero_level<=\''.$_SESSION['temp_level'].'\' '.$search.' ';
sql($sql);
$total_data = @mysql_num_rows($out_sql);
######################################################################################################################################################
$list_page=50;
$page_per_list=10;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board'].$search_next.'&idx='.$_GET['idx'].'&order='.$_GET['order'];
######################################################################################################################################################

if($_POST["type"]=="point"){
	$idx			= $_POST["idx"];
	$hero_title		= $_POST["hero_title"];
	$hero_type		= $_POST["hero_type"];
	$hero_point		= $_POST["hero_point"];

	if($hero_title=="" || $hero_point==""){

	}
	
	if($hero_type=="minus"){
		$msg = "�ϰ� ����";
	}else{
		$msg = "�ϰ� ����";
	} 
	
	while(list($key,$val)=each($idx)){
		$sql = "select hero_idx, hero_code, hero_id, hero_name, hero_nick, hero_level, hero_point from member where hero_use=0 and hero_idx=".$val;
		$res = mysql_query($sql) or die(mysql_error());
		$rs = mysql_fetch_array($res);


		if($rs["hero_idx"]){
			//$update = "update member set hero_point=".$sum_point." where hero_idx=".$val;
			//mysql_query($update) or die($update."<br>".mysql_error());
			
			//160523 �߰�
			$point_rs = adminPoint($rs['hero_code'], $_GET['board'], 'togetherPoint', 0, 0, 0, $rs['hero_id'], $hero_title, $rs['hero_name'], $rs['hero_nick'], $hero_point, 'N', $hero_type);
			
			//160523 ����
			/* $insert = "insert point(hero_code, hero_id, hero_title, hero_name, hero_nick, hero_point, hero_today) values('".$rs["hero_code"]."', '".$rs["hero_id"]."', '".$hero_title."', '".$rs["hero_name"]."', '".$rs["hero_nick"]."', ".$hero_point.", now())";
			mysql_query($insert) or die($insert."<br>".mysql_error()); */
		}
	}

	msg($msg.' �Ͽ����ϴ�.','location.href="'.PATH_HOME.'?'.get('page').'"');
}
?>
<style>
.t_list{white-space:nowrap;}
.t_list td,tr,th{white-space:nowrap;}
.ui-widget-content {
	border: 1px solid #aaaaaa;
	background: #ffffff ;
	color: #222222;
}
</style>
<script>
function showzip(){
	$('#draggable').show();
}

function inputzip(){
	$('#draggable').hide();
}

function pointSubmit(){
	var form = document.frm;
	var flagCheck = false;

	$("input:checkbox[name='idx[]']:checked").each(function(){
		flagCheck = true;
	});

	if(flagCheck===false){
		alert("ó�� �� �����͸� �����ϼ���");
		return false;
	}

	if(form.hero_title.value.split(" ").join("")==""){
		alert("������ �Է��ϼ���");
		form.hero_title.focus();
		return false;
	}

	if(form.hero_point.value.split(" ").join("")==""){
		alert("����Ʈ�� �Է��ϼ���");
		form.hero_point.focus();
		return false;
	}
	
	form.type.value = "point";
	form.submit();
}
</script>

					<div class="searchbox" style="margin-top: 20px;background: #f2f2f2;width: 800px;border: 1px solid #D7D7D7;border-radius: 10px;">
											<div class="wrap_1" style="padding:11px 20px;">
					                            <form action="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=<?=$_GET['view']?>&idx=<?=$_GET['idx']?>" method="POST" >
					                            	<span style="font-size:12px;font-weight:800">Search</span>&nbsp;&nbsp;&nbsp;
					                            	<select name="gender" id="">
					                            		<option value=''>����</option>
					                            		<option value='0' <?if(!strcmp($_REQUEST['gender'], '0')){echo ' selected';}else{echo '';}?>>����</option>
					                            		<option value='1' <?if(!strcmp($_REQUEST['gender'], '1')){echo ' selected';}else{echo '';}?>>����</option>
					                            	</select>
					                            	&nbsp;
					                            	<select name="age" id="" style="width:70px;">
					                            		<option value=''>����</option>
					                            		<option value='1' <?if(!strcmp($_REQUEST['age'], '1')){echo ' selected';}else{echo '';}?>>10��</option>
					                            		<option value='2' <?if(!strcmp($_REQUEST['age'], '2')){echo ' selected';}else{echo '';}?>>20��</option>
					                            		<option value='3' <?if(!strcmp($_REQUEST['age'], '3')){echo ' selected';}else{echo '';}?>>30��</option>
					                            		<option value='4' <?if(!strcmp($_REQUEST['age'], '4')){echo ' selected';}else{echo '';}?>>40��</option>
					                            		<option value='5' <?if(!strcmp($_REQUEST['age'], '5')){echo ' selected';}else{echo '';}?>>50��</option>
					                            		<option value='6' <?if(!strcmp($_REQUEST['age'], '6')){echo ' selected';}else{echo '';}?>>60�� �̻�</option>
					                            	</select>
					                            	<select name="content" id="" style="width:70px;">
					                            		<option value=''>������</option>
					                            		<option value='��' <?if(!strcmp($_REQUEST['content'], '��')){echo ' selected';}else{echo '';}?>>��</option>
					                            		<option value='��' <?if(!strcmp($_REQUEST['content'], '��')){echo ' selected';}else{echo '';}?>>��</option>
					                            		<option value='��' <?if(!strcmp($_REQUEST['content'], '��')){echo ' selected';}else{echo '';}?>>��</option>
					                            	</select>
					                            	
					                            	&nbsp;
					                            	���&nbsp;<input type="text" placeholder="ex) 9998" name="grade" value="<?=$_REQUEST['grade'] ?>" style="width:90px;"/>					                            
					                            	&nbsp;
					                            	
					                                <select name="select" id="">
		                                                  <option value="hero_nick"<?if( (!strcmp($_POST['select'], 'hero_nick')) or (!strcmp($_GET['select'], 'hero_nick')) ){echo ' selected';}else{echo '';}?>>�г���</option>
		                                                  <option value="hero_name"<?if( (!strcmp($_POST['select'], 'hero_name')) or (!strcmp($_GET['select'], 'hero_name')) ){echo ' selected';}else{echo '';}?>>����</option>
		                                                  <option value="hero_id"<?if( (!strcmp($_POST['select'], 'hero_id')) or (!strcmp($_GET['select'], 'hero_id')) ){echo ' selected';}else{echo '';}?>>���̵�</option>
					                                </select>
					                                <input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];?>" class="kewyword">
					                                <input type="image" src="../image/bbs/btn_search.gif" alt="�˻�" class="bd0">
					                            </form>
					                        </div>
					                    </div>
                                        <p style="padding-left:670px; color:#F00;">AK���ڴ�: 9998 / �ֽ�Ŭ��: 9997</p>
					

						
						<form name="frm" method="post" action="<?=PATH_HOME.'?'.get('page');?>">
						<input type="hidden" name="type" value="">
						<input type="hidden" name="hero_code" value="<?=$check_list['hero_code']?>">
						<input type="hidden" name="hero_id" value="<?=$check_list['hero_id']?>">
						<input type="hidden" name="hero_name" value="<?=$check_list['hero_name']?>">
						<input type="hidden" name="hero_today" value="<?=$pk_today?>">
						<div id="draggable" class="ui-widget-content" style="position:absolute;z-index:999; top: 175px; left : 540px; width: 600px; height: 150px; padding: 0.5em; display:none;">
							<div style="padding:5px;">
								<span id="close_popup" onclick="javascript:inputzip();" style="margin-top:4px;margin-bottom:8px; float:right;cursor:pointer">�ݱ�</span>
                            </div>
							<div style="word-break:break-all;border: 1px solid #e4e4e4;padding:5px; width:500px; height:100px; margin:auto; padding-bottom:15px;">
								<table class="t_list">
								<thead>
									<tr>
										<th width="60%">����</th>
										<th width="20%">�з�</th>
										<th width="20%" style="border-right:1px solid #cdcdcd;">����Ʈ</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><input type="text" name="hero_title" value="" style="text-align:center;width:200px;"></td>
										<td>
											<select name="hero_type">
												<option value="plus">����Ʈ ����</option>
												<option value="minus">����Ʈ ����</option>
											</select>
										</td>
										<td style="border-right:1px solid #cdcdcd;"><input type="text" name="hero_point" value="" style="text-align:center;width:90px;"></td>
									</tr>
								</tbody>
								</table>
								<div style="margin-top:10px;float:right;">
									<a href="javascript:pointSubmit();" class="btn_blue2">�����ϱ�</a>
								</div>
							</div>
						</div>
                        <table class="t_list">
                            <thead>
                                <tr>
                                    <td style="padding:10px" colspan="14">
                                        <a href="<?=PATH_HOME.'?'.get('order','');?>" class="btn_blue2">�ʱ�����</a>
										<a href="javascript:javascript:showzip();" class="btn_blue2_big">�ϰ�����Ʈ �۾�</a>
                                    </td>
                                </tr>
                                <tr>
                                	<?php 
                                		$path 		= ADMIN_DEFAULT."/index.php?board=user&idx=64";
                                		$grade  	= "grade=".$_REQUEST['grade']."&";
                                		$age    	= "age=".$_REQUEST['age']."&";
                                		$gender 	= "gender=".$_REQUEST['gender']."&";
                                		$content  	= "content=".$_REQUEST['content']."&";
                                		$kewyword  	= "kewyword=".$_REQUEST['kewyword']."&";
                                	?>
                                    <th width="3%"><input type="checkbox" onclick="Javascript:allCheck(this.checked, 'idx[]');"/></th>
	                                <th width="7%">��ȣ</th>
                                    <th width="9%"><a href="<?=$path.'?'.$grade.$age.$gender.$content.$kewyword.'order=hero_id desc';?>">��</a> ���̵� <a href="<?=$path.'?'.$grade.$age.$gender.$content.$kewyword.'order=hero_id asc';?>">��</a></th>
                                    <th width="6%"><a href="<?=$path.'?'.$grade.$age.$gender.$content.$kewyword.'order=hero_name desc';?>">��</a> �� �� <a href="<?=$path.'?'.$grade.$age.$gender.$content.$kewyword.'order=hero_name asc';?>">��</a></th>
                                    <th width="8%"><a href="<?=$path.'?'.$grade.$age.$gender.$content.$kewyword.'order=hero_nick desc';?>">��</a> �г��� <a href="<?=$path.'?'.$grade.$age.$gender.$content.$kewyword.'order=hero_nick asc';?>">��</a></th>
                                    <th width="5%"><a href="<?=$path.'?'.$grade.$age.$gender.$content.$kewyword.'order=hero_jumin desc';?>">��</a> ���� <a href="<?=$path.'?'.$grade.$age.$gender.$content.$kewyword.'order=hero_jumin asc';?>">��</a></th>
                                    <th width="5%"><a href="<?=$path.'?'.$grade.$age.$gender.$content.$kewyword.'order=hero_sex desc';?>">��</a> ���� <a href="<?=$path.'?'.$grade.$age.$gender.$content.$kewyword.'order=hero_sex asc';?>">��</a></th>
                                    <th width="13%"><a href="<?=$path.'?'.$grade.$age.$gender.$content.$kewyword.'order=hero_excuse_check desc';?>">��</a> ���԰�� <a href="<?=$path.'?'.$grade.$age.$gender.$content.$kewyword.'order=hero_excuse_check asc';?>">��</a></th>
                                    <th width="5%"><a href="<?=$path.'?'.$grade.$age.$gender.$content.$kewyword.'order=hero_point desc';?>">��</a> �� ����Ʈ <a href="<?=$path.'?'.$grade.$age.$gender.$content.$kewyword.'order=hero_point asc';?>">��</a></th>
                                    <th width="9%"><a href="<?=$path.'?'.$grade.$age.$gender.$content.$kewyword.'order=hero_hp desc';?>">��</a> ����ó <a href="<?=$path.'?'.$grade.$age.$gender.$content.$kewyword.'order=hero_hp asc';?>">��</a></th>
                                    <th width="12%"><a href="<?=$path.'?'.$grade.$age.$gender.$content.$kewyword.'order=hero_mail desc';?>">��</a> �̸��� <a href="<?=$path.'?'.$grade.$age.$gender.$content.$kewyword.'order=hero_mail asc';?>">��</a></th>
                                    <th width="6%"><a href="<?=$path.'?'.$grade.$age.$gender.$content.$kewyword.'order=hero_level desc';?>">��</a> ��� <a href="<?=$path.'?'.$grade.$age.$gender.$content.$kewyword.'order=hero_level asc';?>">��</a></th>
                                    <th width="7%" style="border-right:1px solid #cdcdcd;"><a href="<?=$path.'?'.$grade.$age.$gender.$content.$kewyword.'order=hero_oldday desc';?>">��</a> ����� <a href="<?=$path.'?'.$grade.$age.$gender.$content.$kewyword.'order=hero_oldday asc';?>">��</a></th>
                                </tr>
                            </thead>
                            <tbody>
                        <?
                        if(!strcmp($_GET['order'], ''))                         $view_order = ' order by hero_oldday desc';
                        else						                            $view_order = ' order by '.$_GET['order'];
                        
                        $sql = 'select * from member where hero_use=0 and hero_level<=\''.$_SESSION['temp_level'].'\''.$search.$view_order.' limit '.$start.','.$list_page.';';
                        //echo $sql;
//                        $sql = 'select * from member where hero_level<=\''.$_SESSION['temp_level'].'\' and hero_use=\'0\';';//desc
                        sql($sql);
                        
                        while($list                             = @mysql_fetch_assoc($out_sql)){
	                        $level_sql = 'select * from level where hero_use=\'0\' and hero_level='.$list['hero_level'].' order by hero_level desc;';//desc<=
	                        $out_level_sql = mysql_query($level_sql);
	                        $level_list                             = @mysql_fetch_assoc($out_level_sql);
	/*
	                        $user_sql = 'select hero_point from point where hero_code=\''.$list['hero_code'].'\';';//desc
	                        $user_sql = mysql_query($user_sql);
	                        $point = '0';
	                        while($total_list                             = @mysql_fetch_assoc($user_sql)){
	                            $point = $point+$total_list['hero_point'];
	                        }
	*/
	                        $point = $list['hero_point'];
	                        
	                        if(!strcmp($list['hero_use'], '0'))                          $use = '����';
	                        else if(!strcmp($list['hero_use'], '1'))                     $use = '<font color=red>Ż��</font>';
	                        
	                        if(!strcmp($list['hero_sex'], '1')){
	                            $sex = "����";
	                        }else if(!strcmp($list['hero_sex'], '0')){
	                            if(!strcmp($list['hero_info_di'], ''))                   $sex = "������";
	                            else					                                 $sex = "����";
	                        
	                        }else{
	                            $sex = "������";
	                        }
	                        
	                        if(!strcmp($list['hero_jumin'], ''))		                            $jumin = "������";
	                        else if(!strcmp($list['hero_jumin'], '00000000'))                       $jumin = "������";
	                        else										                            $jumin = Y-substr($list['hero_jumin'],0,4)+1;
	                        
	                        if(!strcmp($list['hero_excuse_check'], '0'))                            $excuse_check="�Ź�";
	                        else if(!strcmp($list['hero_excuse_check'], '1'))                       $excuse_check="����";
	                        else if(!strcmp($list['hero_excuse_check'], '2'))                       $excuse_check="��α�";
	                        else if(!strcmp($list['hero_excuse_check'], '3'))                       $excuse_check="ī��";
	                        else if(!strcmp($list['hero_excuse_check'], '4'))                       $excuse_check="����";
	                        else if(!strcmp($list['hero_excuse_check'], '5'))                       $excuse_check="��Ÿ:".$list['hero_excuse_path'];
                        
                        ?>
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
									<td><input type="checkbox" name="idx[]" value="<?=$list['hero_idx']?>"></td>
                                    <td><?=in($list['hero_idx']);?></td>
                                    <td><?=$list['hero_id'];?></td>
                                    <td><?=name_masking($list['hero_name']);?></td>
                                    <td><?=$list['hero_nick'];?></td>
                                    <td><?=$jumin;?></td>
                                    <td><?=$sex;?></td>
                                    <td><?=$excuse_check;?></td>
                                    <td><?=$point;?></td>
                                    <td><?=phone_masking($list['hero_hp']);?></td>
                                    <td><?=$list['hero_mail'];?></td>
                                    <td><?=$level_list['hero_name'];?></td>
                                    <td style="border-right:1px solid #cdcdcd;"><?=date( "Y-m-d", strtotime($list['hero_oldday']));?></td>
                                </tr>
                        <?
                        }
                        ?>
                            </tbody>
                        </table>
						</form>
                        <div style="width:100%; text-align:center; margin-top:20px;">
<? include_once PATH_INC_END.'page.php';?>
                        </div>
<? //include_once BOARD_INC_END.'search.php';?>
                        <div class="searchbox" style="margin-top:20px;">
                            <div class="wrap_1">
                            <form action="<?=PATH_HOME.'?'.get('page');?>" method="POST" >
                                <select name="select" id="">
                                  <option value="hero_nick"<?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>�г���</option>
                                  <option value="hero_name"<?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>����</option>
                                  <option value="hero_id"<?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>���̵�</option>
                                  <option value="hero_hp"<?if(!strcmp($_REQUEST['select'], 'hero_hp')){echo ' selected';}else{echo '';}?>>����ó</option>
                                  <option value="hero_mail"<?if(!strcmp($_REQUEST['select'], 'hero_mail')){echo ' selected';}else{echo '';}?>>�̸���</option>
                                  <option value="hero_memo"<?if(!strcmp($_REQUEST['select'], 'hero_memo')){echo ' selected';}else{echo '';}?>>���</option>
                                  <option value="hero_memo_01"<?if(!strcmp($_REQUEST['select'], 'hero_memo_01')){echo ' selected';}else{echo '';}?>>������</option>
                                </select>
                                <input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];?>" class="kewyword">
                                <input type="image" src="../image/bbs/btn_search.gif" alt="�˻�" class="bd0">
                            </form>
                            </div>
                        </div>