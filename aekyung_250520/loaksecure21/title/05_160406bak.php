<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
//border:1px solid #000000;
######################################################################################################################################################
$sql = 'select * from hero_group where hero_idx=\'1\';';//desc
$sql = out($sql); 
sql($sql);
$list                             = @mysql_fetch_assoc($out_sql);
    $data = explode('||', $list['hero_title']);

    $sql_events = "select * from events";
    $res_events = mysql_query($sql_events);
    
    $events_arr = array();
    $events_array = array();
    while($rs_events = mysql_fetch_assoc($res_events)){
    	
    	$events_arr = array(
    				id 			=> 	$rs_events['id'], 
    				start_date 	=> 	date('m/d/Y H:i',$rs_events['start_date']), 
    				end_date 	=> 	date('m/d/Y H:i',$rs_events['end_date']), 
    				text 		=> 	urlencode($rs_events['text'])
    			);
    	
    	array_push($events_array,$events_arr);
    	
    }
    
    $events_json = urldecode(json_encode($events_array));
    //echo $events_json;
    
?>

<script src="/admin/js/scheduler/codebase/dhtmlxscheduler.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="/admin/js/scheduler/codebase/dhtmlxscheduler.css" type="text/css" media="screen" title="no title" charset="utf-8">
 
<script type="text/javascript">



	function init() {

		scheduler.locale={
			date:{
				month_full:["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
				month_short:["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
				day_full:["일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일"],
				day_short:["일", "월", "화", "수", "목", "금", "토"]
			},
			labels:{
				dhx_cal_today_button:"오늘",
				day_tab:"일간",
				week_tab:"주간",
				month_tab:"월간",
				new_event:"새로운 스케줄",
				icon_save:"저장",
				icon_cancel:"취소",
				icon_details:"세부사항",
				icon_edit:"편집",
				icon_delete:"삭제",
				confirm_closing:"", //Your changes will be lost, are your sure?
				confirm_deleting:"스케줄을 삭제하시겠습니까?",
				section_description:"설명",
				section_time:"기간"
			}
		}
		
		
		scheduler.init('scheduler_here', new Date(), "month");
		
		scheduler.parse(<?=$events_json?>,"json");

		$('.dhx_cal_next_button').css("background-image","").css("background-position","").css("background","url(imgs_dhx_terrace/arrow_left.png) no-repeat center center;").css('width','46px').css('height','30px');
		$('.dhx_cal_prev_button').css("background-image","").css("background-position","").css("background","url(imgs_dhx_terrace/arrow_left.png) no-repeat center center;").css('width','46px').css('height','30px');
		
		scheduler.attachEvent("onEventDeleted",function(id,ev,is_new){

			var url="/admin/title/ajax_save_scheduler.php";

		    var params="id="+id+"&mode=del";
		    var now = location.href;
		    $.ajax({      
		        type:"POST",  
		        url:url,      
		        data:params,      
		        success:function(args){
				    alert("삭제되었습니다");
		        	if(args!='success'){
				        //$('#test').html(args);   
							location.href = now;
						}
		        },   
		        error:function(e){  
		            alert("업데이트에 실패하였습니다. 다시 시도해 주세요.");
		            location.href = now;  
		        }  
		    });
			
		    return true;

		});

		scheduler.attachEvent("onEventAdded",function(id,ev,is_new){

			save(id,ev.start_date,ev.end_date,ev.text,"save");
		    return true;
		    
		});

		scheduler.attachEvent("onEventChanged",function(id,ev,is_new){

			save(id,ev.start_date,ev.end_date,ev.text,"update");
			return true;
			
		});
		
	}

	
	function save(id, start_date, end_date, text, mode) {
		
		var url="/admin/title/ajax_save_scheduler.php";
		start_date = new Date(start_date);
		end_date = new Date(end_date); 
		start_date = (start_date).getTime() / 1000
		end_date = (end_date).getTime() / 1000

		var text = encodeURIComponent(text);
	    var params="id="+id+"&start_date="+start_date+"&end_date="+end_date+"&text="+text+"&mode="+mode+"";
	  	//alert(params);
	    var now = location.href;
	  	
	    $.ajax({      
	        type:"POST",  
	        url:url,      
	        data:params,      
	        success:function(args){
	        	alert("업데이트되었습니다");
		        if(args!='success'){
			        
		        //$('#test').html(args);   
					location.href = now;
				}
	        },   
	        error:function(e){  
	            alert("업데이트에 실패하였습니다. 다시 시도해 주세요.");
	            location.href = now;  
	        }  
	    });
		
	    return true;
	}
</script>


<body onLoad="init();">
	<div  style='float:left;width:100%; height:765px; border:1px solid #CCCCCC;'>
			  	<div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100%;'>
			        <div class="dhx_cal_navline">
			        <div class="dhx_cal_prev_button" style="background-image:url(../scheduler/codebase/imgs/buttons.png);background-position:0 0;width:29px;height:17px;cursor:pointer;">&nbsp;</div>
			        <div class="dhx_cal_next_button" style="background-image:url(../scheduler/codebase/imgs/buttons.png);background-position:-30px 0;width:29px;height:17px;cursor:pointer;">&nbsp;</div>
			        <div class="dhx_cal_today_button"></div>
			        <div class="dhx_cal_date"></div>
			        <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
			        <div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
			        <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
			  	</div>
				<div class="dhx_cal_header"> </div>
				<div class="dhx_cal_data"> </div>
				</div>
	</div>
	<div id="test"></div>
</body>