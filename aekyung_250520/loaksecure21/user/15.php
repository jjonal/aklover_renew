<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################

	
	if(is_numeric($_POST['level'])) $level = $_POST['level'];
	if($_POST['select_area_01']=='point' || $_POST['select_area_01']=='member') $select_area_01 = $_POST['select_area_01'];
	if($_POST['select_area_02']=='period' || $_POST['select_area_02']=='level') $select_area_02 = $_POST['select_area_02'];

	if(is_numeric($_POST['month'])) {
		$month = $_POST['month'];
		if((int)$month<10) $month = "0".$month;
	}
	
	//차트 데이터
	$chart_data = array();
	//차트 전체 데이터
	$chart_whole_data = array();
	//차트 카테고리
	$chart_cate = array();
	//차트 카테고리
	$chart_whole_cate = array();

	$select_year = array();
	

	//차트 타이틀
	$each_chart = '';
	$total_chart = '';
	
	//차트의 y최고값
	$y_max = 0;
	
	
####################################################################################################################################################
#########    포인트 통계     ###############################################################################################################################
####################################################################################################################################################
if($select_area_01=='point' || $select_area_01==''){
	
	if($select_area_02=='period' || $select_area_02==''){
		
		
		if($_POST['year']) 	$year = $_POST['year'];
		else				$year = date('Y');
		


		//월별 검색
		if($month){
			//echo "111";
			
			$y_max = 10000;
			
			$each_chart = $year."년도 ".$month."월 포인트";
			$total_chart = $month."월 누적 포인트";
			
			$end_of_month = date("t", mktime(0, 0, 0, $month, 1, $year));
			
			$month_query = "left(hero_today,7) ='".$year."-".$month."'";
			
			$month_i=1;
			$date_name = array();
			
			$sql = "select A.point_total, B.* ";
			$sql .= "from (select sum(hero_point) as point_total from point where ".$month_query.") as A, ";
			$sql .= "(select ";
			
			while ($month_i<=$end_of_month){
				
				
				if($month_i<10) $month_i = "0".(string)$month_i;
				 
				$date_string = $year."-".$month."-".$month_i;
				array_push($date_name, $date_string);
				
				array_push($chart_cate, $month."-".$month_i);
				
				if($month_i<$end_of_month){
					$sql .= "sum(case when left(hero_today,10)='".$date_string."' then hero_point  else 0 end) as '".$year."-".$month."-".$month_i."', ";
				}elseif($month_i==$end_of_month){
					$sql .= "sum(case when left(hero_today,10)='".$date_string."' then hero_point  else 0 end) as '".$year."-".$month."-".$month_i."' ";
				}
				
				$month_i = (int)$month_i;
				$month_i++;
			}
			
			$sql .= "from point) ";
			$sql .= "as B";
			//echo $sql;
			
			$sql_res = mysql_query($sql) or die("<script>alert('데이터 로딩 실패!')</script>");;
			$sql_rs = mysql_fetch_assoc($sql_res);
			
			
			$month_i = 1;
			while ($month_i<=$end_of_month){
				 
				//$chart_while_date = "+".$cate_i." day";
				$chart_month = $date_name[$month_i-1];
				//echo $chart_month."<br>";
			
				array_push($chart_data, $sql_rs[$chart_month]);
			
				$month_i++;
			
			}
			
			$sql_level = "explain select sum(case when B.hero_code=A.hero_code and A.hero_level=1 then B.hero_point else 0 end) as level_1, sum(case when B.hero_code=A.hero_code and A.hero_level=2 then B.hero_point else 0 end) as level_2 from member as A, point as B";
			
			array_push($chart_whole_cate, "전체 월포인트");
			array_push($chart_whole_data, $sql_rs['point_total']);
		}
			
		
		
		//초기 검색 + 년도검색
		if(!$month){	
			
			$y_max = 70000;
			
			$each_chart = $year."년도 포인트";
			$total_chart = "전체 누적  포인트";
			
			//echo "222";
			$sql = "select A.point_total, B.point_use, D.point_year ,C.* ";
			$sql .= "from (select sum(hero_point) as point_total from point) as A, ";
			$sql .= "(select sum(hero_order_point) as point_use from order_main) as B, ";
			$sql .= "(select sum(hero_point) as point_year from point where left(hero_today,4)='".$year."') as D, ";
			$sql .= "(select ";
			
			$year_i = 1;
			while($year_i <= 12){
				
				if($year_i<10){
					$year_i = "0".$year_i;
				}
				
				$chart_month = $year."-".$year_i;
				
				array_push($chart_cate, $chart_month);
				
				if($year_i<12){
					$sql .= "sum(case when LEFT(hero_today,7)='".$chart_month."' then hero_point  else 0 end) as '".$chart_month."', ";
				}elseif($year_i==12){
					$sql .= "sum(case when LEFT(hero_today,7)='".$chart_month."' then hero_point  else 0 end) as '".$chart_month."' ";
				}
				
				$year_i++;
			}
			$sql .= "from point) ";
			$sql .= "as C";
			
			//echo $sql;
			
			$sql_res = mysql_query($sql) or die("<script>alert('데이터 로딩 실패!')</script>");
			$sql_rs = mysql_fetch_assoc($sql_res);
			
			$cate_i = 1;
			while($cate_i <= 12){
				 
				if($cate_i<10){
					$cate_i = "0".$cate_i;
				}
				
				$chart_month = $year."-".$cate_i;
				//echo $chart_month."<br>";
			
				array_push($chart_data, $sql_rs[$chart_month]);
			
				$cate_i++;
			
			}
			array_push($chart_whole_cate, "전체 포인트");
			array_push($chart_whole_cate, "전체 가용포인트");
			array_push($chart_whole_cate, $year."년 총포인트");
			array_push($chart_whole_data, $sql_rs['point_total']);
			array_push($chart_whole_data, ($sql_rs['point_total']-$sql_rs['point_use']));
			array_push($chart_whole_data, $sql_rs['point_year']);
			
			
			//echo $sql_level;
			
		}
		
		
		
		######################################################################################################################
		
		
		
	}elseif($_POST['select_area_02']=='level'){
	
		
		
		if($_POST['year']) 	$year = $_POST['year'];
		
		//한번에 불러오는 레벨 데이터 수
		$interval = 10;
		
		$y_max = 10000;
		
		if($level){
			
			$where = '';
			if($year && $month){
				$where = "and left(B.hero_today,7)='".$year."-".$month."'";
				$each_chart .= $year."년도  ".$month."월     ";;
			}elseif($year){
				$where = "and left(B.hero_today,4)='".$year."'";
				$each_chart .= $year."년도     ";
			}
			
			$each_chart .=$level."레벨 ~ ".($level+$interval-1)."레벨";
			
			$level_i = $level;
			$level_j = $level+$interval-1;
			
			
			$sql_level = "select ";
			
			for ($level_i; $level_i<=$level_j;$level_i++){
				if ($level_i!=$level_j){
					$sql_level_1 .= "table_".$level_i.".level_".$level_i.", ";
					$sql_level_2 .= "(select ifnull(sum(B.hero_point),0) as level_".$level_i." from member as A inner join point as B on A.hero_code=B.hero_code and A.hero_level=".$level_i." ".$where.") as table_".$level_i.", ";
				}else{
					$sql_level_1 .= "table_".$level_i.".level_".$level_i." ";
					$sql_level_2 .= "(select ifnull(sum(B.hero_point),0) as level_".$level_i." from member as A inner join point as B on A.hero_code=B.hero_code and A.hero_level=".$level_i." ".$where.") as table_".$level_i." ";
				}
			}
			
			
			$sql_level .= $sql_level_1." from ".$sql_level_2;
			//echo $sql_level;
			
			$level_res = mysql_query($sql_level);
			
			$level_rs = mysql_fetch_array($level_res);
			$j = 0;
			
			for ($i = $level; $i <= $level_j; $i++) {
				
				array_push($chart_cate,"level ".$i);
				array_push($chart_data, $level_rs[$j]);
				
				$j++;
				
			}
			
			//print_r($chart_cate);
			//print_r($chart_data);

		}
		
	}
}	

####################################################################################################################################################
#########   end / 포인트 통계     ##########################################################################################################################
####################################################################################################################################################





####################################################################################################################################################
#########    회원수 통계     ###############################################################################################################################
####################################################################################################################################################

elseif($select_area_01=='member'){
	
	$tit_gender_chat .= "남/녀 회원수 통계   ";
	$sql_genger = " select hero_sex,count(*) as cnt from member where hero_use = 0 group by hero_sex order by hero_sex desc ";
	$sql_genger_res = mysql_query($sql_genger);
	$gender_list = array();
	$gender_tot = 0;
	while($sql_gender_rs = mysql_fetch_assoc($sql_genger_res)) {
		if($sql_gender_rs["hero_sex"] == "1") {
			$sql_gender_rs["hero_sex_txt"] = "남";	
		}else if($sql_gender_rs["hero_sex"] == "0") {
			$sql_gender_rs["hero_sex_txt"] = "여";
		}else{
			$sql_gender_rs["hero_sex_txt"] = "기타";
		}
		$gender_list[] = $sql_gender_rs;
		
		$gender_tot += $sql_gender_rs["cnt"];
	} 
	
	#########    기간별 통계     ###############################################################################################################################
	if($select_area_02=='period'){
		
		if($_POST['year']){
			$year = $_POST['year'];
			$each_chart .= $year."년   ";
			$total_chart .= $year."년   ";
		}else{
			$year = date('Y');
		}
		
		if($_POST['month']){
			$each_chart .= $month."월   ";
			$total_chart .= $month."월   ";
			//$tit_gender_chat .= $month."월   ";
		}
		
		$each_chart .= "회원수 통계";
		$total_chart .= "회원수 통계";
		
		
		if(!$month){
			$y_max = 1500;
			$sql = "select left(hero_oldday,7) as hero_month, count(hero_oldday) as count from member where hero_use=0 group by hero_month WITH ROLLUP";

			$sql_res = mysql_query($sql);
			
			$j=1;
			while($sql_rs = mysql_fetch_assoc($sql_res)){
	
				//전체 포인트 빼기
				if ($sql_rs['hero_month'] != null) {
					
					
					$rs_month = (int)substr($sql_rs['hero_month'],-2);
					$rs_year = (int)substr($sql_rs['hero_month'],0,4);
					
					//echo $rs_month."<br>";
					//echo $rs_year."<br>";
						
					if($year==$rs_year){
						if($j==1){
							for($i=1;$i<$rs_month;$i++){
										
								if($i >10){
									$this_month = $year."-0".$i;
								}else{  
									$this_month = $year."-".$i;
								}
								
								array_push($chart_cate,$this_month);  
								array_push($chart_data,0);
							}
							$j++;
						}
						array_push($chart_cate,$sql_rs['hero_month']);
						array_push($chart_data,$sql_rs['count']);
					}
					
				}
						
				else{
					
					array_push($chart_whole_cate,"누적 인원수");
					array_push($chart_whole_data,$sql_rs['count']);
							
				}
					
				$i++;
				
			}
			
		############################################################################################################################################################################	
			
		}elseif($month){
			$y_max = 500;
			$sql = "select substr(hero_oldday,6,5) as hero_day, count(hero_oldday) as count from member where left(hero_oldday,7)='".$year."-".$month."' group by hero_day WITH ROLLUP";
			//echo $sql;
			$sql_res = mysql_query($sql);
				   
			$i=1;
			while($sql_rs = mysql_fetch_assoc($sql_res)){
				
				if ($sql_rs['hero_day'] != null) {
					
					$rs_day = (int)substr($sql_rs['hero_day'],-2);
					//echo $rs_day."<br>";
					while($rs_day!=$i){
						
						if($i<10)	$i="0".$i;
						
						array_push($chart_cate,$month."-".$i);  
						array_push($chart_data,0);
						$i++;
					}
					
					array_push($chart_cate,$sql_rs['hero_day']);
					array_push($chart_data,$sql_rs['count']);
					$i++;
					
				}else{
					$thismonth = time(strtotime($year."-".$month."-01"));
					$end_day = date("t", $thismonth);
					if($rs_day!=$end_day){
						while($rs_day<=$end_day){
						
							if($rs_day<10)	$rs_day="0".$rs_day;
						
							array_push($chart_cate,$month."-".$rs_day);
							array_push($chart_data,0);
							$rs_day++;
						}
					}
					
					array_push($chart_whole_cate,"".$month." 누적 인원수");
					array_push($chart_whole_data,$sql_rs['count']);
					
				}
				
			}
		}
	}	
	#########    레벨별 통계     ###############################################################################################################################	
		
	elseif($select_area_02=='level'){
		
			
			$y_max = 4000;
			$sql = "select hero_level, count(*) as count from member group by hero_level WITH ROLLUP";
			//echo $sql;
				
			$sql_res = mysql_query($sql);
				
			$i=1;
			while($sql_rs = mysql_fetch_assoc($sql_res)){
				
				if ($sql_rs['hero_level'] != null) {
						
					$rs_level = $sql_rs['hero_level'];
					//echo $rs_day."<br>";
					/* while($rs_level!=$i){
						if($i>53) break;			
						array_push($chart_cate,$i."레벨");
						array_push($chart_data,0);
						$i++;
					} */
						
					array_push($chart_cate,$rs_level."레벨");
					array_push($chart_data,$sql_rs['count']);
					$i++;
						
				}else{
						
					array_push($chart_whole_cate,"총 인원수");
					array_push($chart_whole_data,$sql_rs['count']);
						
				}
				
			}
			
		
	}

	
}

####################################################################################################################################################
#########   end / 회원수 통계     ##########################################################################################################################
####################################################################################################################################################


	$i=2013;
	while((int)date('Y')>=$i){
	
		array_push($select_year,$i);
		$i++;
	
	}
	//echo $sql."<br>";
			
	
	
?>
 	<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/jquery-ui-datepicker-1.10.4.custom.min.css">
 	<link rel="stylesheet" type="text/css" href="<?=ADMIN_DEFAULT?>/css/jquery.mtz.monthpicker.css"/>
 	<script src="<?=ADMIN_DEFAULT?>/js/jquery-ui-datepicker-1.10.4.custom.min.js"></script>
 	<script type="text/javascript" src="<?=ADMIN_DEFAULT?>/js/jquery.mtz.monthpicker.js"></script>
	<script src="/js/highcharts.js"></script>

	<script>

	function change_search(){

		var sel_02 = $('#select_area_02');
		var sel_01 = $("#select_area_01");
		var level = $('#46_level');
		var year = $('#46_year');
		var month = $('#46_month');


		if(sel_01.val()=='point'){

			if(sel_02.val()=='period'){

				level.css('display','none');
				year.css('display','inline');
				month.css('display','inline');

				level.children().eq(0).prop("selected", "selected");
				year.children().eq(-1).prop("selected", "selected");
				month.children().eq(0).prop("selected", "selected");
				
			}else if(sel_02.val()=='level'){

				level.css('display','inline');
				year.css('display','inline');
				month.css('display','inline');

				level.children().eq(1).prop("selected", "selected");
				year.children().eq(0).prop("selected", "selected");
				month.children().eq(0).prop("selected", "selected");
				
			}

		}else if(sel_01.val()=='member'){
			

			if(sel_02.val()=='period'){

				level.css('display','none');
				year.css('display','inline');
				month.css('display','inline');

				level.children().eq(1).prop("selected", "selected");
				year.children().eq(-1).prop("selected", "selected");
				month.children().eq(0).prop("selected", "selected");
				
			}else if(sel_02.val()=='level'){
				
				level.css('display','none');
				year.css('display','none');
				month.css('display','none');

				level.children().eq(0).prop("selected", "selected");
				year.children().eq(0).prop("selected", "selected");
				month.children().eq(0).prop("selected", "selected");
				
			}
	
		}
		 
	}

	function init_search(){

		var sel_02 = $('#select_area_02');
		var sel_01 = $("#select_area_01");
		var level = $('#46_level');
		var year = $('#46_year');
		var month = $('#46_month');


		if(sel_01.val()=='point'){

			if(sel_02.val()=='period'){

				level.css('display','none');
				year.css('display','inline');
				month.css('display','inline');

			}else if(sel_02.val()=='level'){

				level.css('display','inline');
				year.css('display','inline');
				month.css('display','inline');

			}

		}else if(sel_01.val()=='member'){

			if(sel_02.val()=='period'){

				level.css('display','none');
				year.css('display','inline');
				month.css('display','inline');

			}else if(sel_02.val()=='level'){
				
				level.css('display','none');
				year.css('display','none');
				month.css('display','none');

			}
	
		}

	}



	function reset(){
		$('.46_reset').each(function(){
			if($(this).prop('name')=='year')	$("option:eq(-1)", this).prop("selected", "selected");
			else 								$("option:eq(0)", this).prop("selected", "selected");
		});
		$('#month_date_click').click();
	}
	

$(function () {

	init_search();

<?php if(!($_POST['select_area_01']=='point' && $_POST['select_area_02']=='level')){
	  if($_POST['select_area_01']=='point') $as = "point";
	  else if($_POST['select_area_01']=='member') $as = "명";
?>
    $('#chart_point_01').highcharts({
        chart: {
        	type: 'column',
            height: 600,
        },
        title: {
        	text: '<?=$each_chart?>',
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [
            <?php 
            	$count = count($chart_cate);
            	$i = 1;
				while($cate = each($chart_cate)) {
						echo "'".$cate[value]."', ";

					$i++;
				}
            ?>
            ]
        },
        yAxis: {
            min: 0,
            max: <?=$y_max?>,
            title: {
                text: ''
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="padding:0"><b>{point.y:f}  <?=$as?></b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true,

        },

        plotOptions: {
        	series: {
                dataLabels: {
                    enabled: true,
                }
            },
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
           
        },
        credits: {
            enabled: false
        },
        legend: {
            enabled: true
        },
        
        series: [{

            name : '<?=$as?>',
            data: [
					<?php 
					$count = count($chart_data);
					$i = 1;
					while($cate = each($chart_data)) {
							echo $cate[value].",";
						$i++;	
					}
			    	?>
		    	]
        }]
    });

    $('#chart_point_02').highcharts({
        chart: {
        	type: 'column',
            height: 600,
        },
        title: {
            text: '<?=$total_chart?>'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [
            <?php 
            		echo "'".$chart_whole_cate[0]."','".$chart_whole_cate[1]."','".$chart_whole_cate[2]."'";
            ?>
            ]
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="padding:0"><b>{point.y:f} <?=$as?></b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
        	series: {
                dataLabels: {
                    enabled: true,
                }
            },
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        credits: {
            enabled: false
        },
        legend: {
            enabled: true
        },
        
        series: [{

            name : '<?=$as?>',
            data: [
		<?php 
               		echo $chart_whole_data[0].",".$chart_whole_data[1].",".$chart_whole_data[2];
    	?>
    	]
        }]
    });

    <?
    	//20171212 남/여 회원수 통계 추가
    	if($_POST['select_area_01']=='member') {
    	
    ?>
		    $('#chart_point_03').highcharts({
			    chart: {
			    	type: 'column',
			        height: 600,
			    },
			    title: {
			        text: '<?=$tit_gender_chat?>'
			    },
			    subtitle: {
			        text: ''
			    },
			    xAxis: {
			        categories: [
			        	<? foreach($gender_list as $rs) { ?>
			        	  '<?=$rs["hero_sex_txt"]?>',
			        	<? } ?>
			        ]
			    },
			    yAxis: {
			        min: 100,
			        max: <?=$gender_tot;?>,
			        title: {
			            text: ''
			        }
			    },
			    tooltip: {
			        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
			        pointFormat: '<tr><td style="padding:0"><b>{point.y:f} <?=$as?></b></td></tr>',
			        footerFormat: '</table>',
			        shared: true,
			        useHTML: true
			    },
			    plotOptions: {
			    	series: {
		                dataLabels: {
		                    enabled: true,
		                }
		            },
			        column: {
			            pointPadding: 0.2,
			            borderWidth: 0
			        }
			    },
			    credits: {
			        enabled: false
			    },
			    legend: {
			        enabled: true
			    },
			    
			    series: [{
			
			        name : '<?=$as?>',
			        data: [
							<? foreach($gender_list as $rs) { ?>
							<?=$rs["cnt"]?>,
							<? } ?>
				    	]
			    }]
			});
    <? 
		}
    ?>
    
<?php }else{
		?>
	$('#chart_point_03').highcharts({
	    chart: {
	    	type: 'column',
	        height: 500,
	    },
	    title: {
	        text: '<?=$each_chart?>'
	    },
	    subtitle: {
	        text: ''
	    },
	    xAxis: {
	        categories: [
	        <?php 
	        	$count = count($chart_cate);
				while($cate = each($chart_cate)) {
						echo "'".$cate[value]."', ";
					$i++;
				}
	        ?>
	        ]
	    },
	    yAxis: {
	        min: 0,
	        max: 30000,
	        title: {
	            text: ''
	        }
	    },
	    tooltip: {
	        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
	        pointFormat: '<tr><td style="padding:0"><b>{point.y:f} <?=$as?></b></td></tr>',
	        footerFormat: '</table>',
	        shared: true,
	        useHTML: true
	    },
	    plotOptions: {
	    	series: {
                dataLabels: {
                    enabled: true,
                }
            },
	        column: {
	            pointPadding: 0.2,
	            borderWidth: 0
	        }
	    },
	    credits: {
	        enabled: false
	    },
	    legend: {
	        enabled: true
	    },
	    
	    series: [{
	
	        name : '<?=$as?>',
	        data: [
					<?php 
					$count = count($chart_data);
					while($cate = each($chart_data)) {
							echo $cate[value].",";
						$i++;	
					}
			    	?>
		    	]
	    }]
	});
<?php }?>

	$('.highcharts-title > tspan').css('font-size','18px').css('font-weight','800');
});
</script>
	
 


	<div class="searchbox" style="margin: 0 50%;background: #f2f2f2;width: 1200px;height: 60px;border: 1px solid #D7D7D7;border-radius: 10px;left: -600px;text-align: center;padding: 10px;font-size: 15px;">
		<span style="font-weight: 800;font-size:17px;">월별/일별/총 회원수와 포인트 통계를 확인하실 수 있습니다.</span><br><br> 
		포인트의 레벨별 검색시 다소 시간이 걸리니 신중하게 선택하고 검색해주시기 바랍니다. 
	</div>
	<div class="searchbox" style="margin: 2% 50%;background: #f2f2f2;width: 840px;height: 50px;border: 1px solid #D7D7D7;border-radius: 10px;left: -420px;">
						<div class="wrap_1" style="padding: 17px 0 0 43px;">
							<form action="<?=$_SERVER['PHP_SELF']."?board=".$_GET['board']."&idx=".$_GET['idx']."&search_area=".$_REQUEST['search_area']?>" method="POST" onsubmit="return ch_submit(this);">
								<span style="font-size:12px;font-weight:800">Search</span>&nbsp;&nbsp;&nbsp;
								
								<span style="color: #999999;font-size: 9pt;font-weight: 800;margin-left: 10px;">통계영역</span>
								<select name='select_area_01' onchange="change_search()" id="select_area_01" class="46_reset">
									<option value="point" <?echo ($_POST['select_area_01']=='point')? "selected='selected'" : ''; ?>>포인트 통계</option>
									<option value="member" <?echo ($_POST['select_area_01']=='member')? "selected='selected'" : ''; ?>>회원수 통계</option>
								</select>
								
								<span style="color: #999999;font-size: 9pt;font-weight: 800;margin-left: 10px;">기간/레벨</span>
								<select name='select_area_02' onchange="change_search()" id="select_area_02" class="46_reset">
									<option value="period" <?echo ($_POST['select_area_02']=='period')? "selected='selected'" : ''; ?>>기간별</option>
									<option value="level" <?echo ($_POST['select_area_02']=='level')? "selected='selected'" : ''; ?>>레벨별</option>
								</select>
								
								<span style="color: #999999;font-size: 9pt;font-weight: 800;margin-left: 10px;display:none;">레벨</span>
								<select name='level' id="46_level" style="display:none;" class="46_reset">
									<option value=''>선택</option>
									<?php
										for($i=1; $i<=100; $i+=10){ 
											if($level == $i) $select = "selected='selected'";
											else $select = "";
											echo "<option value='".($i)."' ".$select.">".$i."레벨 ~ ".($i+9)."레벨</option>";
										}
									?>
                                    <option value='9998'>기자단</option>
                                    <option value='9997'>휘슬클럽</option>
                                    <option value='9996'>루나클럽</option>
								</select>
								
								<span style="color: #999999;font-size: 9pt;font-weight: 800;margin-left: 10px;">년도</span>
								<select name='year' id="46_year" class="46_reset">
									<option value=''>선택</option>
									<?php 
										while($each_year = each($select_year)){

											if($year==$each_year[value])	$selected = "selected='selected'";
											else 							$selected = "";
											
											echo "<option value='".$each_year[value]."' ".$selected.">".$each_year[value]."</option>";
											
										}
									?>
								</select>
								
							
								<span style="color: #999999;font-size: 9pt;font-weight: 800;margin-left: 10px;">월</span>
								<select name='month' id="46_month" class="46_reset">
									<option value=''>선택</option>
									<?php
										for($i=1; $i<=12; $i++){ 
											if((int)$month == $i) $select = "selected='selected'";
											else $select = "";
											echo "<option value='".$i."' ".$select.">".$i." 월</option>";
										}
									?>
								</select>
								
								
								
								
								<!--  
								<span style="color: #999999;font-size: 9pt;font-weight: 800;margin-left: 10px;">일별</span>
								<input type="text" id="datepicker"  name='date' style="width:80px;" value='<?if($_REQUEST['date']){echo $_REQUEST['date'];}else{echo '';}?>' onchange="outfocus('date');">
								-->
								
								<input type="image" src="../image/bbs/btn_search.gif" alt="검색" class="bd0" id="month_date_click">
								<span style='background: #376EA6;padding: 4px 7px;color: #FFFFFF;font-weight: 800;border-radius: 9px;cursor:pointer;' onclick='reset();'>Reset</span>
							</form>
						</div>
					</div>

		<?php if(!($_POST['select_area_01']=='point' && $_POST['select_area_02']=='level')){?>
		<div id="chart_point_01" style="min-width: 78%; height: 600px; float:left;"></div>
		<div id="chart_point_02" style="min-width: 20%; height: 600px; float:left;"></div>
		<? if($_POST['select_area_01']=='member') { ?>
			<div id="chart_point_03" style="min-width: 30%; height: 600px; float:left;"></div>
		<? } ?>
		<?php }else{?>
		<div id="chart_point_03" style="min-width: 100%; height: 500px; float:left;"></div>
		<?php }?>
	


	
        	
        	

                        