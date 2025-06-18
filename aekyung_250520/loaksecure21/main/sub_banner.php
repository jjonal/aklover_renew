<!--script src="<?=ADMIN_DEFAULT?>/js/jquery.cycle2.min.js"></script-->
<?
$table = 'banner_sub';
$hero_board = 'banner_sub';
if(!strcmp($_GET['type'], 'edit')){
    $post_count = count($_POST['hero_use']);

    $hero_file = imageUploader($_FILES['hero_file'],"/aklover/photo/");
    //exit;
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

<link type="text/css" href="/cal/jquery-ui-1.8.17.custom.css" rel="stylesheet">
<script type="text/javascript" src="/cal/jquery.min.js"></script>
<script type="text/javascript" src="/cal/jquery-ui-1.8.17.custom.min.js"></script>

<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/anytime.5.1.2.css">
<script src="<?=ADMIN_DEFAULT?>/js/anytime.5.1.2.js"></script>

<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/daterangepicker.css" />
<script src="<?=ADMIN_DEFAULT?>/js/moment.min.js"></script>
<script src="<?=ADMIN_DEFAULT?>/js/jquery.daterangepicker.js"></script>


<div id="layer" style="text-align:center; position:absolute; display:none; margin:0; padding:0; z-index:1;border:solid 5px red"></div>
<a href="https://www.aklover.co.kr/image/banner.zip">템플릿 배너 다운로드</a>
<form name="form_next" action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post" enctype="multipart/form-data"> 
<table class="t_list">
    <thead>
        <tr>
            <th width="5%">선택</th>
            <th width="17%">사용이미지</th>
            <th width="*">링크</th>
            <th width="15%">기간</th>
            <th width="5%">순서</th>
            <th width="7%">상태</th>
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
			?>
                                
			<tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
  				<input type="hidden" name="hero_idx[]" value="<?=$list['hero_idx']?>">
  				<input type="hidden" name="hero_main[]" value="<?=$list['hero_main']?>">
     			<td>
     				<input type="checkbox" class="hero_use_check" <?=$hero_checked;?>>
     				<input type="hidden" class="hero_use" name="hero_use[]" value="<?=$list['hero_use']?>"></td>
     			<td align="center" style="text-align:center;">

				
					  	<div align="center" style="text-align:center;width:100%;">
                            <?if($list['hero_main']!='' && $list['hero_main']!=null){?>
                            <img class="group1" src="/aklover/photo/<?=$list['hero_main']?>" alt="" height="71" onclick="hero_layer('layer',this.src);" style="margin-bottom:10px;"/><br/>
                            <?}?>
                            <input type="file" name="hero_file[]" style="width:140px;">
						</div>

					</div>

				
     					
     					
    			</td>
    			
    			<td>
    				<table border="0" cellpadding="0" cellspacing="0" width="95%" style="border: none;">
    					<tr>
    						<td style="border: none;padding:2px;">링크 : </td>
    						<td style="border: none;padding:2px;"><input type="text" name="hero_href[]" value="<?=$list['hero_href']?>" style="width:350px"/></td>
    					</tr>
    					<tr>
    						<td style="border: none;padding:2px;">제목 : </td>
    						<td style="border: none;padding:2px;"><input type="text" name="hero_title[]" value="<?=$list['hero_title']?>" style="width:350px"/></td>
    					</tr>
    					<tr>
    						<td style="border: none;padding:2px;">부제목 : </td>
    						<td style="border: none;padding:2px;"><input type="text" name="hero_subtitle[]" value="<?=$list['hero_subtitle']?>" style="width:350px"/></td>
    					</tr>
    					<tr>
    						<td style="border: none;padding:2px;">표시기간: </td>
    						<td style="border: none;padding:2px;">
    						<input class="period" id="period<?=$list['hero_idx']?>" type="text" name="hero_period[]" value="<?=$list['hero_period']?>" style="width:350px"/>	
    						</td>
    					</tr>
    				</table>
    			</td>
    			
    			<td>
    				<input class="sdate" id="sdate<?=$list['hero_idx']?>" type="text" name="hero_today_01[]" value="<?=$list['hero_today_01']?>" style="width:140px"/><br/> ~ <br/>
    				<input class="sdate" id="edate<?=$list['hero_idx']?>" type="text" name="hero_today_02[]" value="<?=$list['hero_today_02']?>" style="width:140px"/>
    			</td>
    			<td><input type="text" name="hero_order[]" value="<?=$list['hero_order']?>" style="width:40px;text-align:center;"></td>
    			<td><?=$use?><a href="javascript:location.href='<?=PATH_HOME.'?'.get('','type=drop&hero_idx='.$list['hero_idx']);?>'" class="btn_blue2">삭제</a></td>
  			</tr>
  			<script>
$(function(){
	$("#sdate<?=$list['hero_idx']?>").AnyTime_picker( {
    format: "%Y-%m-%d %H:%i:00"
 	}); 
	$("#edate<?=$list['hero_idx']?>").AnyTime_picker( {
    format: "%Y-%m-%d %H:%i:00"
 	});  
 	$('#period<?=$list['hero_idx']?>').dateRangePicker({format: 'MM월 DD일',separator: ' ~ '});
});
 </script>
			<?
			$i++;
			}
			?>
    </tbody>
</table>
</form>
<a href="javascript:form_next.submit();" class="btn_blue2">설정수정</a>
<a href="javascript:void(make_new_form());" class="btn_blue2">추가</a>

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
    new_form += "<table border='0' cellpadding='0' cellspacing='0' width='95%' style='border: none;'><tr>"; 
    new_form += "<td style='border: none;padding:2px;'>링크 : </td>"; 
    new_form += "<td style='border: none;padding:2px;'><input type='text' name='hero_href[]' value='' style='width:350px'/></td>"; 
    new_form += "</tr><tr><td style='border: none;padding:2px;'>제목 : </td>"; 
    new_form += "<td style='border: none;padding:2px;'><input type='text' name='hero_title[]' value='' style='width:350px'/></td>"; 
    new_form += "</tr><tr><td style='border: none;padding:2px;'>부제목 : </td>"; 
    new_form += "<td style='border: none;padding:2px;'><input type='text' name='hero_subtitle[]' value='' style='width:350px'/></td>"; 
    new_form += "</tr><tr><td style='border: none;padding:2px;'>표시기간: </td>"; 
    new_form += "<td style='border: none;padding:2px;'>"; 
    new_form += "<input class='period' id='period"+loop+"' type='text' name='hero_period[]' value='' style='width:350px'/>"; 
    new_form += "</td></tr></table>"; 
    new_form += "</td>";  
    new_form += "<td>";
    new_form += "<input class='sdate' id='sdate"+loop+"' type='text' name='hero_today_01[]' style='width:140px'/><br/> ~ <br/>";
    new_form += "<input class='edate' id='edate"+loop+"' type='text' name='hero_today_02[]' style='width:140px'/>";
    new_form += "</td>";
    new_form += "<td><input type='text' name='hero_order[]' style='width:40px;text-align:center;'></td>";
    new_form += "<td><a href=\"javascript:location.href='<?=PATH_HOME.'?'.get('','type=drop&hero_idx='.$list['hero_idx']);?>'\" class='btn_blue2'>삭제</a></td>";
	new_form += "</tr>";


	$(".t_list").append(new_form);
	pageInit();
	var sdate = "#sdate"+loop;
	var edate = "#edate"+loop; 
	var period = "#period"+loop; 
	$(sdate).AnyTime_picker({format:"%Y-%m-%d %H:%i:00"});
	$(edate).AnyTime_picker({format:"%Y-%m-%d %H:%i:00"});
	$(period).dateRangePicker({format: 'MM월 DD일',separator: ' ~ '});
	loop++;
	return false;
}
	
	/*function dateclick2(){
	    var dates = $(".sdate").datepicker({
	        monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
	        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
	        defaultDate: null,
	        showMonthAfterYear:true,
	        dateFormat: 'yy-mm-dd',
	        onSelect: function( selectedDate ) {
	            //var option = this.id == "sdate1" ? "minDate" : "maxDate",
	            instance = $( this ).data( "datepicker" ),
	            date = $.datepicker.parseDate(
	                instance.settings.dateFormat ||
	                $.datepicker._defaults.dateFormat,
	                selectedDate, instance.settings );
	        }
	    });
	};*/
</script>