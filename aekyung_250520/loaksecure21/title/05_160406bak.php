<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
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
				month_full:["1��", "2��", "3��", "4��", "5��", "6��", "7��", "8��", "9��", "10��", "11��", "12��"],
				month_short:["1��", "2��", "3��", "4��", "5��", "6��", "7��", "8��", "9��", "10��", "11��", "12��"],
				day_full:["�Ͽ���", "������", "ȭ����", "������", "�����", "�ݿ���", "�����"],
				day_short:["��", "��", "ȭ", "��", "��", "��", "��"]
			},
			labels:{
				dhx_cal_today_button:"����",
				day_tab:"�ϰ�",
				week_tab:"�ְ�",
				month_tab:"����",
				new_event:"���ο� ������",
				icon_save:"����",
				icon_cancel:"���",
				icon_details:"���λ���",
				icon_edit:"����",
				icon_delete:"����",
				confirm_closing:"", //Your changes will be lost, are your sure?
				confirm_deleting:"�������� �����Ͻðڽ��ϱ�?",
				section_description:"����",
				section_time:"�Ⱓ"
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
				    alert("�����Ǿ����ϴ�");
		        	if(args!='success'){
				        //$('#test').html(args);   
							location.href = now;
						}
		        },   
		        error:function(e){  
		            alert("������Ʈ�� �����Ͽ����ϴ�. �ٽ� �õ��� �ּ���.");
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
	        	alert("������Ʈ�Ǿ����ϴ�");
		        if(args!='success'){
			        
		        //$('#test').html(args);   
					location.href = now;
				}
	        },   
	        error:function(e){  
	            alert("������Ʈ�� �����Ͽ����ϴ�. �ٽ� �õ��� �ּ���.");
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