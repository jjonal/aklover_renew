<?php 
if(!defined('_HEROBOARD_'))exit;
?>

<?php 
	if(!is_numeric($_GET['user_idx'])) exit;

	$user_idx = $_GET['user_idx'];
	$this_year = date('Y');
?>

<?php 
	if($_GET['mode']=='detail'){
		if($_POST['hero_address_01'] && $_POST['hero_address_02'] && $_POST['hero_address_03']){
			if(!$_POST['hero_idx']){
				error_location("�߸��� �����Դϴ�. �ٽ� �õ����ּ���.",ADMIN_DEFAULT."/index.php?board=user&idx=73&view=userManager_02&user_idx=".$_GET['user_idx']."");
				exit;
			}
			$addr_update = "update member set hero_job_01='Y', hero_address_01='".$_POST['hero_address_01']."', hero_address_02='".$_POST['hero_address_02']."', hero_address_03='".$_POST['hero_address_03']."' where hero_idx='".$_POST['hero_idx']."'";
			$addr_res = mysql_query($addr_update);
			if(!$addr_res){
				error_historyBack("");
				exit;
			}
			
			message("�����Ǿ����ϴ�.");
			location(ADMIN_DEFAULT."/index.php?board=user&idx=73&view=userManager_02&user_idx=".$_GET['user_idx']."");
			exit;
			
		}else{
			error_historyBack("�ּҰ� �Էµ��� �ʾҽ��ϴ�. �ּҸ� Ȯ���� �ּ���");
			exit;
		}
	}
	
	if($_GET['mode']=='emailUpdate'){
		if($_POST['hero_mail']){
			if(!$_POST['hero_idx']){
				error_location("�߸��� �����Դϴ�. �ٽ� �õ����ּ���.",ADMIN_DEFAULT."/index.php?board=user&idx=73&view=userManager_02&user_idx=".$_GET['user_idx']."");
				exit;
			}
			$email_update = "update member set hero_mail='".$_POST['hero_mail']."' where hero_idx='".$_POST['hero_idx']."'";
			$email_res = mysql_query($email_update);
			if(!$email_res){
				error_historyBack("");
				exit;
			}
			
			message("�����Ǿ����ϴ�.");
			location(ADMIN_DEFAULT."/index.php?board=user&idx=73&view=userManager_02&user_idx=".$_GET['user_idx']."");
			exit;
			
		}else{
			error_historyBack("�̸����� �Է��ϼ���.");
			exit;
		}	
		
	}

	if($_GET['mode']=="enrollVip"){
		
		$update_member = "update member set hero_vip='Y' where hero_idx='".$user_idx."'";
		$update_pf = mysql_query($update_member);
		if(!$update_pf){
			error_historyBack("");
			exit;
		}
		
		error_location("����Ǿ����ϴ�.",ADMIN_DEFAULT.'/index.php?board='.$_GET['board'].'&idx='.$_GET['idx'].'&view='.$_GET['view'].'&user_idx='.$_GET['user_idx']);
		exit;
	}elseif($_GET['mode']=="cancleVip"){
		$update_member = "update member set hero_vip='N' where hero_idx='".$user_idx."'";
		$update_pf = mysql_query($update_member);
		if(!$update_pf){
			error_historyBack("");
			exit;
		}
		
		error_location("����Ǿ����ϴ�.",ADMIN_DEFAULT.'/index.php?board='.$_GET['board'].'&idx='.$_GET['idx'].'&view='.$_GET['view'].'&user_idx='.$_GET['user_idx']);
		exit;
	}
	
	if($_GET['mode']=="enrollSuperpass"){
		
		$select = "select hero_code from member where hero_idx='".$user_idx."'";
		$select_res = mysql_query($select);
		if(!$select_res){
			error_historyBack("");
			exit;
		}
		$hero_code = mysql_result($select_res,0,0);
		
		$hero_kind = $_POST["hero_kind"];
		$hero_superpass = $_POST["hero_superpass"];
		$hero_endday = $_POST["hero_endday"];
		
		if(!$hero_kind || !is_numeric($hero_superpass) || !$hero_endday){
			error_historyBack("");
			exit;
		}
		
		$insert_superpass = "insert into superpass (hero_code,hero_kind,hero_superpass,hero_today,hero_endday) values ('".$hero_code."','".$hero_kind."','".$hero_superpass."','".date("Y-m-d H:i:s")."','".$hero_endday."')";
		$insert_res = mysql_query($insert_superpass);
		if(!$insert_res){
			error_historyBack("");
			exit;
		}
		error_location("����Ǿ����ϴ�.",ADMIN_DEFAULT.'/index.php?board='.$_GET['board'].'&idx='.$_GET['idx'].'&view='.$_GET['view'].'&user_idx='.$_GET['user_idx'].'&mode=superpass');
		exit;
	}
	
	if($_GET['mode']=="cancleSuperpass"){
	
		if(!$_GET["sidx"]){
			error_historyBack("");
			exit;
		}
		
		$delete_superpass = "delete from superpass where hero_idx='".$_GET['sidx']."'";
		$delete_res = mysql_query($delete_superpass);
		if(!$delete_res){
			error_historyBack("");
			exit;
		}
		error_location("����Ǿ����ϴ�.",ADMIN_DEFAULT.'/index.php?board='.$_GET['board'].'&idx='.$_GET['idx'].'&view='.$_GET['view'].'&user_idx='.$_GET['user_idx'].'&mode=superpass');
		exit;
	}
?>


<?php 
	$select = "select A.hero_idx, A.hero_id, A.hero_nick, A.hero_name, A.hero_today, A.hero_oldday ";
	$select .= " , A.hero_vip, (".$this_year."-left(A.hero_jumin,4)+1) as hero_birth, A.hero_mail,A.hero_address_01 ";
	$select .= " , A.hero_address_02, A.hero_address_03, A.hero_level, A.hero_blog_00, A.hero_blog_01, A.hero_blog_02 ";
	$select .= " , A.hero_blog_03, A.hero_blog_04, A.hero_blog_05, A.hero_memo, A.hero_memo_01, A.hero_memo_02, A.hero_memo_03 ";
	$select .= " , A.hero_memo_04, A.hero_chk_phone, A.hero_chk_email, A.hero_user ";
	$select .= " , A.hero_insta_cnt,.A.hero_insta_grade, A.hero_youtube_cnt, A.hero_youtube_grade ";
	$select .= " , (select ifnull(sum(hero_order_point),0) from order_main where hero_code = A.hero_code and hero_process!='".$_PROCESS_CANCEL."') hero_order_point ";
	$select .= " , (select ifnull(sum(hero_point),0) from point where hero_code = A.hero_code ) hero_total ";
	$select .= " from member as A ";
    $select .= " where A.hero_use=0 and hero_idx=".$user_idx;
	$res = mysql_query($select) or die("<script>alert('�ý��� �����Դϴ�. �ٽ� �õ��� �ּ���.');</script>");
	$rs = mysql_fetch_assoc($res);
	//    
	// ���̵�, �г���, �̸�, ����, ����, �ּ�, ��α�url, ��α� �湮�ڼ�, ������ ���, ���Ƽ ����, ��ȥ����, ������Ʈ, ���� ����Ʈ,������, ���԰��,����Ʈ ��������, �ۼ��� Ȯ�� 
	switch($rs['hero_excuse_check']){
		case 0 : $hero_excuse_check = "�Ź�"; break;
		case 1 : $hero_excuse_check = "����"; break;
		case 2 : $hero_excuse_check = "��α�"; break;
		case 3 : $hero_excuse_check = "ī��"; break;
		case 4 : $hero_excuse_check = "����"; break;
		case 5 : $hero_excuse_check = "��Ÿ : "; $hero_excuse_path = $rs['hero_excuse_path']; break;
		case 6 : $hero_excuse_check = "����"; break;
	}
?>
<script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>
<script src="/js/daumAddressApi.js"></script>
<div id="detailArea">
	<form action="<?=ADMIN_DEFAULT?>/index.php?board=user&idx=73&view=userManager_02&user_idx=<?=$_GET['user_idx']?>&mode=detail" method="post" name="detailForm">
	<input type="hidden" name="hero_idx" value="<?=$_GET['user_idx']?>">
	<table>
		<tr>	
			<td colspan='14' style="text-align: center;font-size: 15px;font-weight: 800;padding: 15px;">
				�⺻����
			</td>
		</tr>
		<tr>
				<th style="width:5%;">���̵�</th>
				<td><?=$rs['hero_id']?></td>
				<th style="width:5%;">�г���</th>
				<td><?=$rs['hero_nick']?></td>
				<th style="width:5%;">�̸�</th>
				<td><?=$rs['hero_name']?></td>
				<th style="width:5%;">����</th>
				<td style="width:10%;"><?=$rs['hero_birth']?></td>
				<th style="width:10%;">��ȥ����</th>
				<td style="width:7%;">no data</td>
				<th>�г�Ƽ</th>
				<td>
					<?=($rs['hero_memo_02'])? $rs['hero_memo_02']."<br/>" : "" ;?>
					<?=($rs['hero_memo_03'])? $rs['hero_memo_03']."<br/>" : "" ;?>
					<?= $rs['hero_memo_04']?>
				</td>
		</tr>
		<tr>
			<th rowspan="3">����</th>
			<td rowspan="3"><?=$rs['hero_level']?></td>
			<th rowspan="3">��α� URL</th>
			<td rowspan="3" colspan="5">
				<?=($rs['hero_blog_00'])? $rs['hero_blog_00']."<br/>": ""; ?> <?=($rs['hero_blog_01'])? $rs['hero_blog_01']."<br/>": ""; ?> <?=($rs['hero_blog_02'])? $rs['hero_blog_02']."<br/>": ""; ?><?=($rs['hero_blog_03'])? $rs['hero_blog_03']."<br/>": ""; ?><?=$rs['hero_blog_04']?>
			</td>
			<th>�湮�ڼ�</th>
			<td>
				<?=$rs['hero_memo']?>
			</td>
			<th>������ ���</th>
			<td>
    			<?=$rs['hero_memo_01']?>
			</td>
		</tr>
		<tr>
			<th>�ν�Ÿ �ȷο� ��</td>
			<td><?=$rs['hero_insta_cnt']?></td>
			<th>�ν�Ÿ ���</td>
			<td><?=$rs['hero_insta_grade']?></td>
		</tr>
		<tr>
			<th>��Ʃ�� ������ ��</td>
			<td><?=$rs['hero_youtube_cnt']?></td>
			<th>��Ʃ�� ���</td>
			<td><?=$rs['hero_youtube_grade']?></td>
		</tr>
		<tr>
			<th>������Ʈ</th>
			<td><?=$rs['hero_total']?></td>
			<th>��������Ʈ</th>
			<td><?=$rs['hero_total']-$rs["hero_order_point"]?></td>
			<th>������</th>
			<td><?=$rs['hero_oldday']?></td>
			<th>���԰��</th>
			<td><?=$hero_excuse_check.$hero_excuse_path?></td>
			<th>��õ��</th>
			<td><?=$rs['hero_user']?></td>
            <th>����<br/>���ſ���</th>
            <td>
            	����:<?=$rs['hero_chk_phone'] == 1 ? "����":"���ž���"?><br/>
                �̸���:<?=$rs['hero_chk_email'] == 1 ? "����":"���ž���"?>
            </td>
		</tr>
        <tr>
        	<th>�̸���</th>
            <td colspan="3">
            	<input type="text" id="hero_mail" name="hero_mail" value="<?=$rs['hero_mail']?>" style="width:300px;"/>
            </td>
            <th>�ּ�</th>
            <td colspan="9">
            	<input type="text" id="hero_address_01" name="hero_address_01" style="width:150px;" value="<?=$rs['hero_address_01']?>" onclick="javascript:btnAddressGet()"/>
				<input type="text" id="hero_address_02" name="hero_address_02" style="width:350px;" value="<?=$rs['hero_address_02']?>" onclick="javascript:btnAddressGet()"/> 
				<input type="text" id="hero_address_03" name="hero_address_03" style="width:250px;" value="<?=$rs['hero_address_03']?>"/>
            </td>
        </tr>
		<tr>
            <td colspan="14">
				<div class="btn" onclick="location.href='<?=ADMIN_DEFAULT?>/index.php?board=<?=$_GET['board']?>&idx=<?=$_GET['idx']?>&view=<?=$_GET['view']?>&user_idx=<?=$_GET['user_idx']?>&mode=point'">���� ����Ʈ Ȯ��</div>
				<div class="btn" onclick="location.href='<?=ADMIN_DEFAULT?>/index.php?board=<?=$_GET['board']?>&idx=<?=$_GET['idx']?>&view=<?=$_GET['view']?>&user_idx=<?=$_GET['user_idx']?>&mode=write'">�ۼ��� Ȯ��</div>
				<?php 
				if($rs['hero_vip']=='N' || !$rs['hero_vip']){
					$button_mode = "enrollVip";
					$button_text = "IDEA LAB ��� ���";
				}elseif($rs['hero_vip']=='Y'){
					$button_mode = "cancleVip";
					$button_text = "IDEA LAB ��� ���";
				}
				?>
				<div class="btn" onclick="location.href='<?=ADMIN_DEFAULT?>/index.php?board=<?=$_GET['board']?>&idx=<?=$_GET['idx']?>&view=<?=$_GET['view']?>&user_idx=<?=$_GET['user_idx']?>&mode=superpass'">�����н� Ȯ��</div>  
				<div class="btn" onclick="document.detailForm.submit();">���ּ� ����</div> 
                <div class="btn" onclick="emailUpdate()">�̸��� ����</div>
                <script>
					function emailUpdate(){
						var frm = document.detailForm;
						frm.action = "<?=ADMIN_DEFAULT?>/index.php?board=user&idx=73&view=userManager_02&user_idx=<?=$_GET['user_idx']?>&mode=emailUpdate";
						frm.submit();
					}
				</script>
                
			</td>
        </tr>
	</table>
	</form>
</div>

<?php 
	if($_GET['mode']=="point" || !$_GET['mode']){
?>
<div id="resultArea">
			
	<table>
		<tr>
			<td colspan='10' style="text-align: center;font-size: 15px;font-weight: 800;padding: 15px;">���� ����Ʈ ����</td>
		</tr>
		<tr>
			<th>NO</th>
			<th>���̵�</th>
			<th>�г���</th>
			<th>�̸�</th>
			<th>����Ʈ</th>
			<th>Ÿ��</th>
			<th>ī�װ�</th>
			<th>������, ��۳���</th>
			<th>�ο���</th>
			<th>������ Ȯ��</th>
		</tr>
<?php 
		
		$list_page 		= 30;
		$page_per_list 	= 10;
		$start			= 0;
		
		
		$next_path="board=".$_GET['board']."&idx=".$_GET['idx']."&view=".$_GET['view']."&user_idx=".$_GET['user_idx']."&mode=".$_GET['mode'];
		
		$count_sql = "select count(*) from member as A right outer join point as B on A.hero_code=B.hero_code where A.hero_idx=".$user_idx;
		$count_res = mysql_query($count_sql) or die("<script>alert('�ý��� �����Դϴ�. �ٽ� �õ����ּ���.');</script>");
		$total_data = mysql_result($count_res,0,0);

		if($_GET['page']){
			$page = $_GET['page'];
			$NO = $total_data-(($_GET['page']-1)*$list_page);
		}else{
			$page = 1;
			$NO = $total_data;
		}
		$start = ($page-1)*$list_page;
		
		$point_sql = "select A.hero_id, A.hero_nick, A.hero_name, B.hero_table, B.hero_old_idx, B.hero_review_idx, B.hero_top_title, B.hero_title, B.hero_point,B.hero_today, left(C.hero_command,20) as hero_command ";
		$point_sql .= "from member as A right outer join point as B on A.hero_code=B.hero_code ";
		$point_sql .= "left outer join review as C on C.hero_idx=B.hero_review_idx ";
		$point_sql .= "where A.hero_idx=".$user_idx." order by B.hero_today desc limit ".$start.", ".$list_page;
		//echo "<script>console.log('".$point_sql."')</script>";
		$point_res = mysql_query($point_sql) or die("<script>alert('�ý��� �����Դϴ�. �ٽ� �õ����ּ���.');</script>");
		while($point_rs = mysql_fetch_assoc($point_res)){
			
			if($point_rs['hero_old_idx'] && !$point_rs['hero_review_idx'] && $point_rs['hero_top_title']!="ȸ�������߰��Է�"){															
				$type = "�� ���"; 
				$command = 	$point_rs['hero_title'];
				$link = "<a href='/main/index.php?board=".$point_rs['hero_table']."&next_board=".$point_rs['hero_table']."&page=1&view=view&idx=".$point_rs['hero_old_idx']."' target='_blank'>Ȯ��</a>";			
			}elseif($point_rs['hero_old_idx'] && $point_rs['hero_review_idx']){														
				$type = "���"; 
				$command = $point_rs['hero_command'];
				$link = "<a href='/main/index.php?board=".$point_rs['hero_table']."&next_board=".$point_rs['hero_table']."&page=1&view=view&idx=".$point_rs['hero_old_idx']."' target='_blank'>Ȯ��</a>";
			}elseif(!$point_rs['hero_old_idx'] && !$point_rs['hero_review_idx'] && $point_rs['hero_top_title']=="�⼮üũ"){			
				$type = "�⼮";
				$command="";
				$link = "";
			}elseif(!$point_rs['hero_old_idx'] && !$point_rs['hero_review_idx'] && $point_rs['hero_top_title']=="���⼮����"){			
				$type = "����";
				$command="";
				$link = "";
			}elseif(!$point_rs['hero_old_idx'] && !$point_rs['hero_review_idx'] && $point_rs['hero_title']=="��õ������Ʈ"){			
				$type = "��õ";
				$command="";
				$link = "";
			}elseif(!$point_rs['hero_top_title']){
				$type = $point_rs['hero_title'];
				$command="";
				$link = "";
			}else{
				$type = "";
				$command="";
				$link = "";
			}
			
			
?>
		<tr>
			<td><?=$NO?></td>
			<td><?=$point_rs['hero_id']?></td>
			<td><?=$point_rs['hero_nick']?></td>
			<td><?=$point_rs['hero_name']?></td>
			<td><?=$point_rs['hero_point']?></td>
			<td><?=$type?></td>
			<td><?=$point_rs['hero_top_title']?></td>
			<td><?=$command?></td>
			<td><?=$point_rs['hero_today']?></td>
			<td><?=$link?></td>
		</tr>
<?php 
			$NO--;
		}
		
?>
	</table>	
	<div style="width:98%;"><? include PATH_INC_END.'page.php';?></div>
</div>
<?php }elseif($_GET['mode']=="write"){?>

		<div id="resultArea">
			
			<table>
				<tr>
					<td colspan='11' style="text-align: center;font-size: 15px;font-weight: 800;padding: 15px;">�ۼ���, ���� ����</td>
				</tr>
				<tr>
					<th>NO</th>
					<th>���̵�</th>
					<th>�г���</th>
					<th>�̸�</th>
					<th>Ÿ��</th>
					<th>ī�װ�</th>
					<th>������, ��۳���</th>
					<th>��õ��</th>
					<th>����</th>
					<th>������ Ȯ��</th>
				</tr>
				
				<?php 
		
					$list_page 		= 30;
					$page_per_list 	= 10;
					$start			= 0;
					
					
					$next_path="board=".$_GET['board']."&idx=".$_GET['idx']."&view=".$_GET['view']."&user_idx=".$_GET['user_idx']."&mode=".$_GET['mode'];
					
					$count_sql = "select count(*) from (select A.hero_idx from member as A right outer join board as B on A.hero_code=B.hero_code where A.hero_idx=".$user_idx." ";
					$count_sql .= "union all select C.hero_idx from member as C right outer join review as D on C.hero_code=D.hero_code where C.hero_idx=".$user_idx.") as E";
					//echo $count_sql;
					$count_res = mysql_query($count_sql) or die("<script>alert('�ý��� �����Դϴ�. �ٽ� �õ����ּ���.');</script>");
					$total_data = mysql_result($count_res,0,0);
			
					if($_GET['page']){
						$page = $_GET['page'];
						$NO = $total_data-(($_GET['page']-1)*$list_page);
					}else{
						$page = 1;
						$NO = $total_data;
					}
					$start = ($page-1)*$list_page;
					
					$write_sql = "select * ";
					$write_sql .= "from (select B.hero_idx, A.hero_id, A.hero_nick, A.hero_name, B.hero_table, B.hero_title, B.hero_today, B.hero_rec from member as A right outer join board as B on A.hero_code=B.hero_code where A.hero_idx=".$user_idx." ";
					$write_sql .= "union all select D. hero_old_idx as hero_idx, C.hero_id, C.hero_nick, C.hero_name, D.hero_table, left(D.hero_command,20) as hero_title, D.hero_today,-1 from member as C right outer join review as D on C.hero_code=D.hero_code where C.hero_idx=".$user_idx.") as E ";
					$write_sql .= "order by E.hero_today desc limit ".$start.", ".$list_page;
					//echo $write_sql;
					$write_res = mysql_query($write_sql) or die("<script>alert('�ý��� �����Դϴ�. �ٽ� �õ����ּ���.');</script>");
					while($write_rs = mysql_fetch_assoc($write_res)){
						
						if($write_rs['hero_rec']!=-1){															
							$type = "�� �ۼ�";
							$hero_rec =  $write_rs['hero_rec'];
						}elseif($write_rs['hero_rec']==-1){														
							$type = "���"; 
							$hero_rec = "";
						}  

						switch ($write_rs['hero_table']){
							case 'group_02_01' : $cate = "�����Ϸ�";break;
							case 'group_02_02' : $cate = "����&��ȥ";break;
							case 'group_03_04' : $cate = "�������̵��";break;
							case 'group_03_05' : $cate = "����Ī����";break;
							case 'group_02_05' : $cate = "�������ι�";break;
							case 'group_01_01' : $cate = "�ɹ̳���";break;
							case 'group_01_02' : $cate = "�ȼ�����";break;
							case 'group_01_03' : $cate = "�̽İ���";break;
							case 'group_01_04' : $cate = "��ȭ����";break;
							case 'group_04_11' : $cate = "��α���";break;
							case 'group_04_05' : $cate = "�Ϲݹ̼�";break;
							case 'group_04_06' : $cate = "�����̾��̼�";break;
							case 'group_04_07' : $cate = "�ְ�ڽ�";break;
							case 'group_04_08' : $cate = "AK���ڴ�";break;
							case 'group_04_09' : $cate = "�����ı�";break;
							case 'group_04_10' : $cate = "������Ÿ";break;
						}
						
						
				?>
				
						<tr>
							<td><?=$NO?></td>
							<td><?=$write_rs['hero_id']?></td>
							<td><?=$write_rs['hero_nick']?></td>
							<td><?=$write_rs['hero_name']?></td>
							<td><?=$type?></td>
							<td><?=$cate?></td>
							<td><?=$write_rs['hero_title']?></td>
							<td><?=$hero_rec?></td>
							<td><?=$write_rs['hero_today']?></td>
							<td><a href='/main/index.php?board=<?=$write_rs['hero_table']?>&next_board=<?=$write_rs['hero_table']?>&page=1&view=view&idx=<?=$write_rs['hero_idx']?>' target="_blank">Ȯ��</a></td>
						</tr>
				
				<?php 
						$NO--;
					}
					
				?>
	</table>	
	<div style="width:98%;"><? include PATH_INC_END.'page.php';?></div>
</div>

<?php }elseif($_GET['mode']=="superpass"){?>
		<style>
				#superpassForm {text-align: center;margin: 10px auto;width: 245px;}
				#superpassForm li {text-align: center;border: 1px solid #eeeeee;padding: 10px;}
				#superpassForm input {margin-left: 20px;height:22px;}
				#superpassForm li.superpass_title {font-size:15px;font-weight:800;}
			</style>
		<form method="post" name="superpassForm" action="<?=ADMIN_DEFAULT?>/index.php?board=<?=$_GET['board']?>&idx=<?=$_GET['idx']?>&view=<?=$_GET['view']?>&user_idx=<?=$_GET['user_idx']?>&mode=enrollSuperpass" onsubmit="return checkForm(this);";>
			<ul id="superpassForm">
				<li class="superpass_title">�����н� �ο�</li>
				<li>Ÿ��<input type="text" name="hero_kind"/></li>
				<li>����<input type="text" name="hero_superpass"/></li>
				<li>����<input type="text" name="hero_endday" id="hero_endday"/></li>
				<li><input type="submit" value="���" style="background-color: #376EA6;color: white;width: 50px;text-align: center;cursor: pointer;"></li>
			</ul>
		</form>
		
<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/anytime.5.1.2.css">
<script src="<?=ADMIN_DEFAULT?>/js/anytime.5.1.2.js"></script>
<script>
$(function(){
	$("#hero_endday").AnyTime_picker( {
    format: "%Y-%m-%d %H:%i"
 	});
 
});
</script>
	
		<div id="resultArea">
			
			<table>
				<tr>
					<td colspan='11' style="text-align: center;font-size: 15px;font-weight: 800;padding: 15px;">�����н� ����</td>
				</tr>
				<tr>
					<th>NO</th>
					<th>���̵�</th>
					<th>�г���</th>
					<th>�̸�</th>
					<th>Ÿ��Ʋ</th>
					<th>����</th>
					<th width='130'>�߱�����</th>
                    <th width='130'>��������</th>
                    <th>��뿩��</th>
					<th></th>
				</tr>
				
				<?php 
		
					$list_page 		= 30;
					$page_per_list 	= 10;
					$start			= 0;
					
					$next_path="board=".$_GET['board']."&idx=".$_GET['idx']."&view=".$_GET['view']."&user_idx=".$_GET['user_idx']."&mode=".$_GET['mode'];
					
					$count_sql = "select count(*) from member as A right outer join superpass as B on A.hero_code=B.hero_code where A.hero_idx=".$user_idx." ";
					//echo $count_sql;
					$count_res = mysql_query($count_sql) or die("<script>alert('�ý��� �����Դϴ�. �ٽ� �õ����ּ���.');</script>");
					$total_data = mysql_result($count_res,0,0);
			
					if($_GET['page']){
						$page = $_GET['page'];
						$NO = $total_data-(($_GET['page']-1)*$list_page);
					}else{
						$page = 1;
						$NO = $total_data;
					}
					$start = ($page-1)*$list_page;
					
					$write_sql = "select B.hero_idx, A.hero_id,A.hero_nick,A.hero_name,B.hero_kind,B.hero_kind,B.hero_superpass,B.hero_today, B.hero_endday, B.hero_use_yn from member as A right outer join superpass as B on A.hero_code=B.hero_code where A.hero_idx=".$user_idx." order by B.hero_idx desc ";
					//echo $write_sql;
					$write_res = mysql_query($write_sql) or die("<script>alert('�ý��� �����Դϴ�. �ٽ� �õ����ּ���.');</script>");
					while($write_rs = mysql_fetch_assoc($write_res)){

						if(strstr($write_rs['hero_kind'],"vip:powerblog")){
							$hero_kind = "�Ѵ�";
						}elseif(strstr($write_rs['hero_kind'],"vip")){
							$hero_kind = "�ٽ��η�";  
						}elseif(strstr($write_rs['hero_kind'],"powerblog")){
							$hero_kind = "�Ŀ���ΰ�";
						}elseif(strstr($write_rs['hero_kind'],"dontKnow")){
							$hero_kind = "";
						}else{
							$hero_kind = $write_rs['hero_kind'];
						}
						
				?>
				
						<tr>
							<td><?=$NO?></td>
							<td><?=$write_rs['hero_id']?></td>
							<td><?=$write_rs['hero_nick']?></td>
							<td><?=$write_rs['hero_name']?></td>
							<td><?=$hero_kind?></td>
							<td><?=$write_rs['hero_superpass']?></td>
							<td><?=$write_rs['hero_today']?></td>
                            <td><?=$write_rs['hero_endday']?></td>
                            <td><? echo $write_rs['hero_use_yn'] == 'Y' ? '���' : '������' ?></td>
							<td><input style="background-color: #376EA6;color: white;width: 50px;text-align: center;cursor: pointer;float: left;" value="����" type="button" onclick="location.href='<?=ADMIN_DEFAULT?>/index.php?board=<?=$_GET['board']?>&idx=<?=$_GET['idx']?>&view=<?=$_GET['view']?>&user_idx=<?=$_GET['user_idx']?>&mode=cancleSuperpass&sidx=<?=$write_rs['hero_idx']?>'"></td>
						</tr>
				
				<?php 
						$NO--;
					}
					
				?>
	</table>	
	<div style="width:98%;"><? include PATH_INC_END.'page.php';?></div>
</div>

<script type="text/javascript">

	function checkForm(obj){
		var hero_kind = obj.hero_kind;
		var hero_superpass = obj.hero_superpass;
		if(hero_kind.value==''){
			alert("Ÿ���� ������ּ���.");
			hero_kind.focus();
			return false;
		}
		if(hero_superpass.value=='' || isNaN(hero_superpass.value)==true){
			alert("������ ���ڷθ� �Է����ּ���.");
			hero_superpass.focus();
			return false;
		}
		return true;
	}
				
</script>
<?php }?>
<script>
	function showzip(){
        $('.layer_zip').show();
    }
    function inputzip(){
        $('.layer_zip').hide();
    }
    function fnLoad_01(a,b,c,d,e,f){
        document.getElementById("hero_address_01").value=a;
        document.getElementById("hero_address_02").value=b + ' ' + c + d + e;
        $('.layer_zip').hide();
    }
	</script>
<div class="layer_zip">
	<dl>
		<form name="login_form" action="<?=PATH_HOME?>?board=result"
			onsubmit="return false;">
			<dt>
				<img src="../image/member/zip1.gif" alt="�����ȣ ã��" />
			</dt>
			<dd>
				<input id="addr" type="text" class="addr" /><input type="image"	src="../image/member/btn_findzip.gif" alt="�ּ�ã��" onclick="hero_ajax('/main/zip.php', 'view_list', 'addr', 'zip'); return false;" />
			</dd>
			<dd class="list">
				<div id="view_list"></div>
			</dd>
			<dd class="tc">
				<a href="javascript:inputzip();"><img
					src="../image/member/btn_cancel.gif" alt="�Է�" /></a>
			</dd>
		</form>
	</dl>
</div>

