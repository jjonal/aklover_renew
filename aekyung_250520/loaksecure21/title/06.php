<?
if(!defined('_HEROBOARD_'))exit;

if($_GET['mode']=='del' && is_numeric($_GET['id'])){
	
	$sql = "delete from manual where hero_idx=".$_GET['id'];
	$pf = mysql_query($sql);
	if($pf){
		echo "<script>alert('삭제되었습니다');location.href='".$_SERVER['PHP_SELF']."?board=title&idx=71'</script>";			
	}	
}

if(($_GET['mode']=='edit' || $_GET['mode']=='upload') && $_POST['title']){
	
	if($_GET['mode']=='upload'){
		$temp = explode(".", $_FILES["manual_file"]["name"]);
		$extension = end($temp);
		$tmp_name_arr = explode("/",$_FILES['manual_file']['tmp_name']);
		$tmp_name = end($tmp_name_arr);
		$file_name = $tmp_name.time().".".$extension;
		$save_url = $_SERVER['DOCUMENT_ROOT'].ADMIN_DEFAULT."/manual_folder/".$file_name;
		//echo $save_url;
		//exit;
		$pf = 0;
		
		
		if ($_FILES["manual_file"]["error"] > 0) {
			echo "<script>alert('업데이트에 실패하였습니다. 다시 시도해 주세요.')</script>";
		} else {
			
			if(move_uploaded_file($_FILES['manual_file']['tmp_name'], $save_url)){
				$pf=1;							
			}else{
				echo "<script>alert('업데이트에 실패하였습니다. 다시 시도해 주세요.')</script>";
			}
						
		}
	
		//파일 업로드에 성공하였을 경우
		if($pf==1){
			$sql = "insert into manual (hero_title, hero_url, hero_today) values ('".$_POST['title']."','".$file_name."', now())";
			//echo $sql;
			$pf = mysql_query($sql) or die("<script>alert('업데이트에 실패하였습니다. 다시 시도해 주세요.')</script>");
			if($pf==1){
				echo "<script>alert('업데이트 성공');location.href='".$_SERVER['PHP_SELF']."?board=title&idx=71';</script>";
			}
		}
	
	}elseif($_GET['mode']=='edit' && is_numeric($_POST['id'])){
		
		if($_POST['saved_file']==''){
			
			$temp = explode(".", $_FILES["manual_file"]["name"]);
			$extension = end($temp);
			$tmp_name_arr = explode("/",$_FILES['manual_file']['tmp_name']);
			$tmp_name = end($tmp_name_arr);
			$file_name = $tmp_name.time().".".$extension;
			$save_url = $_SERVER['DOCUMENT_ROOT'].ADMIN_DEFAULT."/manual_folder/".$file_name;
			//echo $save_url;
			//exit;
			$pf = 0;
			
			if ($_FILES["manual_file"]["error"] > 0) {
				echo "<script>alert('업데이트에 실패하였습니다. 다시 시도해 주세요.')</script>";
			} else {
			
				if(move_uploaded_file($_FILES['manual_file']['tmp_name'], $save_url)){
					$pf=1;
				}else{
					echo "<script>alert('업데이트에 실패하였습니다. 다시 시도해 주세요.');</script>";
				}
					
			}
			
		}else{
			$file_name = $_POST['saved_file'];
			$pf=1;
			
		}
		
		//파일 업로드에 성공하였을 경우
		if($pf==1){
			$sql = "update manual set hero_title='".$_POST['title']."', hero_url='".$file_name."', hero_today=now() where hero_idx=".$_POST['id'];
			$pf = mysql_query($sql) or die("<script>alert('업데이트에 실패하였습니다. 다시 시도해 주세요.');</script>");
			if($pf==1){
				echo "<script>alert('업데이트 성공');location.href='".$_SERVER['PHP_SELF']."?board=title&idx=71';</script>";
				exit;
			}
		}
		
	}
}

?>
	<script>
		function upload_submit(form){

			var file_title = form.title;
			var manual_file = form.manual_file;
			var saved_file = form.saved_file;
			if(file_title.value==''){
				alert("메뉴얼 제목을 입력해주세요");
				file_title.focus();
				return false;
			}
			if(manual_file.value=='' && saved_file.value==''){
				alert("파일을 선택해주세요");
				manual_file.click();
				return false;
			}

			if(manual_file.value!=''){
				saved_file.value='';
			}

			var file_path = manual_file.value;
			var idx = file_path.lastIndexOf('.')+1;
			var idx2 = file_path.lastIndexOf('\\')+1;
			var extention = (file_path.substr(idx, file_path.length)).toLowerCase();

			var fileNameCheck = file_path.substring(idx2,file_path.length).toLowerCase();

			if(fileNameCheck.length !=0){

				for(i=0; i < fileNameCheck.length; i++){

					var chk = fileNameCheck.charCodeAt(i);
					if(chk > 128){

						alert("이름이 영문인 파일만 업로드 가능합니다");
						manual_file.focus();
						return false;
						
					}
					
				}
				
			}else{
				alert("선택한 파일이 없습니다");
				return false;		
			}			

			form.submit();
		}


		function ch_del(no){

			if (confirm("삭제하시겠습니까?") == true){    //확인
				location.href="<?=$_SERVER['REQUEST_URI']?>&mode=del&id="+no+"";
			}else{   //취소
			    return;
			}

		}

	</script>
	
	<style>
		#upload_form { position: absolute;width: 600px;display: none;top: 50%;left: 50%;margin: -73px 0 0 -300px;padding: 40px;border: 1px solid #CCCCCC;background: #376EA6; }
		#upload_form table {border: 1px solid #cdcdcd;background: white; }
		#upload_form div {background: #376EA6;text-align: center;color: white;height: 30px;font-weight: 800;font-size: 15px; }		.button { padding: 5px 10px;border: 1px solid #ADADAD;background: #eeeeee; }
		#download { text-align: center;margin-top: 25px; } 
		#download a { padding:10px 20px; font-size:15px; font-weight:800; background:#003B72;color:#eeeeee; }
	</style>

	
	<table class="t_list">
    	<thead>
        	<tr>
            	<th width="10%">NO</th>
                <th width="*">메뉴얼 제목</th>
                <th width="25%">파일 다운로드</th>
                <th width="10%">날짜</th>
                <th width="25%">관리</th>
           	</tr>
        </thead>
        <tbody>
			<?php 
				$sql = "select * from manual";
				$sql = mysql_query($sql) or die("<script>alert('페이지 로딩에 실패하였습니다')</script>");
				$i=1;
				while($manual = mysql_fetch_assoc($sql)){
			?>
                <tr>
                	<td><?=$i ?></td>
                    <td><?=$manual['hero_title']?></td>
                    <td><a class="button" href="<?=ADMIN_DEFAULT?>/title/file_downloader.php?file=<?=$manual['hero_url']?>">다운로드</a></td>
                    <td><?=$manual['hero_today']?></td>
                    <td>
                    	<a class="button" href="<?=$_SERVER['REQUEST_URI']?>&mode=edit&id=<?=$manual['hero_idx']?>">수정</a>
                    		&nbsp;&nbsp;
                    	<a class="button" onclick="ch_del(<?=$manual['hero_idx']?>);">삭제</a>
                    </td>
               	</tr>
            <?php 
            	$i++;
            	}
            ?>
       	</tbody>
    </table>
    
    <div id="download" >
		<a onclick="document.getElementById('upload_form').style.display='block'">파일 업로드</a>
	</div>
    <?php 
    
    	if($_GET['mode']=='edit'){
    		$sql = "select * from manual where hero_idx=".$_GET['id'];
    		$sql = mysql_query($sql);
    		$sq1 = mysql_fetch_assoc($sql);
    		$mode="edit";
    		
  	?>
    	<script>
    		$(document).ready(function(){
				$('#upload_form').css('display','block');
        	});
    	</script>		
    <?php
    	}else{
    		$mode="upload";
    	}
    
    ?>
    
    <div id="upload_form">
    	<div> 이름이 영문인 파일만 업로드 가능합니다 </div>
    	<table class="t_list">
	    	<thead>
	        	<tr>
	            	<th width="100px">메뉴얼 제목</th>
	                <th width="100px">업로드</th>
	           	</tr>
	        </thead>
	        <tbody>
	    		<form name="form_next" method="post"  action="<?=$_SERVER['PHP_SELF']."?board=title&idx=71&mode=".$mode?>" enctype="multipart/form-data">
	    			<input name="saved_file" type="hidden" value="<?=$sq1['hero_url']?>">
	    			<input name="id" type="hidden" value="<?=$sq1['hero_idx']?>">
	    			<tr>
	                    <td><input name="title" type="text" value="<?=$sq1['hero_title']?>"></td>
	                    <td><input name="manual_file" type="file" id="manual_file"></td>
	               	</tr>
	               	<tr>
	               		<td colspan=2>
	               			<input class="button" type="button" onclick="upload_submit(this.form)" value="업로드">
	               			<input class="button" type="button" onclick="document.getElementById('upload_form').style.display='none'" value="취소">
	               		</td>
	               	</tr>
	               	
	    		</form>
	    	</tbody>
    	</table>
    </div>