    <?
if(strcmp($_SESSION['temp_code'], '')){
	if($recommand_count==0 || $report_count==0){
	?>
			<div class="btn_recommand_report">
	                	<?php 
	                		if($recommand_count==0){
	                	?>
	                        <a onclick="confirm_writing('recommand','<?=$_SERVER['REQUEST_URI'].'&type=recommand'?>')"><img src="/image2/etc/like.jpg" alt="추천"></a>&nbsp;&nbsp;
	                    <?php 
	                    	}
	                    	
	                    	if($report_count==0){
	                    ?>
	                        &nbsp;&nbsp;<a onclick="confirm_writing('report','<?=$_SERVER['REQUEST_URI'].'&type=report'?>')"><img src="/image2/etc/btn_report.jpg" alt="신고"></a>
	                    <?php 
	                    	}
	                    ?>
	                    <script>
	                    	function confirm_writing(type, location){
		                    	if(type=='recommand')		var type="추천";
		                    	else if(type=='report')		var type="신고";
	                    		if (confirm(""+type+"하시겠습니까?") == true){    //확인
	                    		    document.location.href=location;
	                    		}else{   //취소
	                    		    return;
	                    		}
			                }
	                    </script>
	        </div>
	<?
	}
}
	?>
