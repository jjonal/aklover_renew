<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/anytime.5.1.2.css">
<script src="<?=ADMIN_DEFAULT?>/js/anytime.5.1.2.js"></script>
<?
$table = 'banner';
$hero_board = 'banner';
if(!strcmp($_GET['type'], 'edit')){
    $post_count = count($_POST['hero_use']);
    $hero_file = imageUploader($_FILES['hero_file'],"/aklover/photo/", true);
    
    for($i=0;$i<$post_count;$i++){
        reset($_POST);
        unset($sql_one_update);
        unset($sql_one);
        unset($sql_two);
        
        $j=0;
        foreach($_POST as $post_key=>$post_val){

        	if($post_key=='hero_idx'){
        		$idx = $_POST[$post_key][$i];
        		continue;
        	}
        	if($j==0)	$comma = '';
        	else		$comma = ',';

            if($post_key == 'hero_order' &&  $_POST[$post_key][$i] == '') {
                $_POST[$post_key][$i] = 0;
            }
			
        	//update
        	if($idx!=0){
	        	if($post_key=='hero_main' && $hero_file[$i]!="noFile")		$sql_one_update .= $comma.$post_key."='".$hero_file[$i]."'";
	       		else														$sql_one_update .= $comma.$post_key."='".$_POST[$post_key][$i]."'";

		        $sql = "UPDATE ".$table." SET ".$sql_one_update." WHERE hero_idx = '".$idx."';";
			}
        	//insert
        	else{
        		if($post_key=='hero_main' && $hero_file[$i]!="noFile"){
        			$sql_one .= $comma.$post_key;
        			$sql_two .= $comma."'".$hero_file[$i]."'";
        		}else{
        			$sql_one .= $comma.$post_key;
        			$sql_two .= $comma."'".$_POST[$post_key][$i]."'";
        		}
        		$sql = "insert into ".$table." (".$sql_one.") values (".$sql_two.");";
//                echo $sql.'<br>';
        	}
	        $j++;
        }

		mysql_query($sql);
    }

    msg('수정 되었습니다.','location.href="'.PATH_HOME.'?'.get('type','').'"');
    exit;

}else if(!strcmp($_GET['type'], 'drop')){
	$idx = $_GET['idx'];
		
	if(is_numeric($idx)){
	    $sql = "DELETE FROM ".$table." WHERE hero_idx = '".$_GET['hero_idx']."'";
	    sql($sql);
	}
    msg('삭제 되었습니다.','location.href="'.PATH_HOME.'?'.get('type||hero_idx','').'"');
    exit;
}
?>
<div id="layer" style="text-align:center; position:absolute; display:none; margin:0; padding:0; z-index:1;border:solid 5px red"></div>
<div class="btnGroupFunction">
	<div class="leftWrap">
		<a href="javascript:void(make_new_form());" class="btnFunc">배너추가</a>
	</div>
	<div class="rightWrap"><a href="https://www.aklover.co.kr/image/banner.zip" class="btnFunc">템플릿 배너 다운로드</a></div>
</div>
<form name="form_next" action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post" enctype="multipart/form-data">
<table class="t_list">
    <thead>
        <tr>
            <th width="5%">선택</th>
            <th width="17%">이미지<br/>(1920x950)</th>
            <th width="*">내용</th>
            <th width="20%">노출기간</th>
            <th width="5%">순서</th>
            <th width="7%">상태</th>
            <th width="5%">관리</th>
        </tr>
    </thead>
    <tbody>
			<?
			$sql = "select * from ".$table." order by hero_order asc";
			sql($sql);
			$i = '0';
			while($list                             = @mysql_fetch_assoc($out_sql)){
			######################################################################################################################################################
			    if($list['hero_use']==1){
			        $use = '<font color=red><b>사용중</b></font>';
			        $hero_checked = "checked='checked'";
			    }else{
			        $use = '미사용';
			        $hero_checked = '';
			    }
				if($list['hero_box_use']==1) {
					$hero_box_use_checked = "checked='checked'";
				}else {
					$hero_box_use_checked = "";
				}
			?>

			<tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
  				<input type="hidden" name="hero_idx[]" value="<?=$list['hero_idx']?>">
  				<input type="hidden" name="hero_main[]" value="<?=$list['hero_main']?>">
     			<td>
     				<input type="checkbox" class="hero_use_check" <?=$hero_checked;?>>
     				<input type="hidden" class="hero_use" name="hero_use[]" value="<?=$list['hero_use']?>">
     			</td>
     			<td align="center" style="text-align:center;">
				  	<div align="center" style="text-align:center;width:100%;">
					<? if($list['hero_main']!='' && $list['hero_main']!=null){?>
						<img class="group1" src="/aklover/photo/<?=$list['hero_main']?>" alt="" height="71" onclick="hero_layer('layer',this.src);" style="margin-bottom:10px;"/><br/>
					<? } ?>
					<input type="file" name="hero_file[]" style="width:140px;">
					</div>	
    			</td>
    			<td>
    				<table border="0" cellpadding="0" cellspacing="0" width="95%" style="border: none;">
    					<tr>
    						<td style="border: none;padding:2px;">링크 : </td>
    						<td style="border: none;padding:2px;"><input type="text" name="hero_href[]" value="<?=$list['hero_href']?>" style="width:350px"/></td>
    					</tr>
                        
                        <tr>
    						<td style="border: none;padding:2px;">박스제목 : </td>
    						<td style="border: none;padding:2px;"><input type="text" name="hero_box_title[]" value="<?=$list['hero_box_title']?>" style="width:350px"/></td>
    					</tr>
    				</table>
    			</td>
    			<td>
    				<input class="sdate" id="sdate<?=$list['hero_idx']?>" type="text" name="hero_today_01[]" value="<?=$list['hero_today_01']?>" style="width:140px"/> ~
    				<input class="sdate" id="edate<?=$list['hero_idx']?>" type="text" name="hero_today_02[]" value="<?=$list['hero_today_02']?>" style="width:140px"/>
    			</td>
    			<td><input type="text" name="hero_order[]" value="<?=$list['hero_order']?>" style="width:40px;text-align:center;"></td>
    			<td><?=$use?></td>
    			<td><a href="javascript:location.href='<?=PATH_HOME.'?'.get('','type=drop&hero_idx='.$list['hero_idx']);?>'" class="btnForm">삭제</a></td>
  			</tr>
<script>
$(function(){
	$("#sdate<?=$list['hero_idx']?>").AnyTime_picker( {
    format: "%Y-%m-%d %H:%i:00"
 	}); 
	$("#edate<?=$list['hero_idx']?>").AnyTime_picker( {
    format: "%Y-%m-%d %H:%i:00"
 	});  
 	
});
 </script>
			<?
			$i++;
			}
			?>
    </tbody>
</table>
<div class="btnGroup">
	<a href="javascript:form_next.submit();" class="btnAdd">설정</a>
</div>
</form>
<script>
	$(document).ready(function(){
		pageInit();
		
	});

	function pageInit(){

		//dateclick2();
		$(".hero_use_check").click(function(){
			$hero_use = $(this).siblings(".hero_use");
			if($hero_use.val()==1){
				$hero_use.val(0);
			}else{
				$hero_use.val(1);
			}
		});
		
		$(".hero_box_use_check").click(function(){
			$hero_box_use = $(this).siblings(".hero_box_use");
			if($hero_box_use.val()==1){
				$hero_box_use.val(0);
			}else{
				$hero_box_use.val(1);
			}
		});

	}
var loop = 10000000;
function make_new_form(){
	var new_form = "";
	new_form += "<tr onmouseover=\"this.style.background='#B9DEFF'\" onmouseout=\"this.style.background='white'\">";
	new_form += "<input type='hidden' name='hero_idx[]' value='0'>";
	new_form += "<input type='hidden' name='hero_main[]'>";
    new_form += "<td><input type='checkbox' class='hero_use_check'><input type='hidden' class='hero_use' name='hero_use[]' value='0'></td>";
    new_form += "<td>";
    new_form += "<img class='group1' src='' alt='' height='71' onclick='hero_layer(\'layer\',this.src);' style='margin-bottom:10px;'/><br/>";
    new_form += "<input type='file' name='hero_file[]' style='width:140px;'>";
    new_form += "</td>";
    new_form += "<td>";
    new_form += "<table border='0' cellpadding='0' cellspacing='0' width='95%' style='border: none;'>";
	
	new_form += "<tr>";
    new_form += "<td style='border: none;padding:2px;'>링크 : </td>";
    new_form += "<td style='border: none;padding:2px;'><input type='text' name='hero_href[]' value='' style='width:350px'/></td>";
	new_form += "</tr>";
	
	new_form += "<tr>";
	new_form += "<td style='border: none;padding:2px;'>박스제목 : </td>";
	new_form += "<td style='border: none;padding:2px;'><input type='text' name='hero_box_title[]' style='width:350px'/> </td>";
	new_form += "</tr>";
	new_form += "</table>";
    new_form += "</td>";
    new_form += "<td>";
    new_form += "<input class='sdate' id='sdate"+loop+"' type='text' name='hero_today_01[]' style='width:140px'/> ~ ";
    new_form += "<input class='edate' id='edate"+loop+"' type='text' name='hero_today_02[]' style='width:140px'/>";
    new_form += "</td>";
    new_form += "<td><input type='text' name='hero_order[]' style='width:40px;text-align:center;'></td>";
    new_form += "<td></td>";
    new_form += "<td><a href=\"javascript:location.href='<?=PATH_HOME.'?'.get('','type=drop&hero_idx='.$list['hero_idx']);?>'\" class='btnForm'>삭제</a></td>";
	new_form += "</tr>";


	$(".t_list").append(new_form);
	pageInit();
	var sdate = "#sdate"+loop;
	var edate = "#edate"+loop; 
	var period = "#period"+loop; 
	$(sdate).AnyTime_picker({format:"%Y-%m-%d %H:%i:00"});
	$(edate).AnyTime_picker({format:"%Y-%m-%d %H:%i:00"});
	
	loop++;
	return false;
}
</script>