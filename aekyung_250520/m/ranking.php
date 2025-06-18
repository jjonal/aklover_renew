<?include_once "head.php";?>

<?php 
	if($_REQUEST["board"]!="group_05_01"){exit;}
	
?>
<?php 
######################################################################################################################################################
//누적포인트
$sql = "select * from (select hero_code, sum(hero_point) as totalPoint from point group by hero_code order by totalPoint desc limit 0,5) as A left outer join member as B on A.hero_code=B.hero_code left outer join level as C on B.hero_level=C.hero_level";//desc
sql($sql);
$top_nick_total=array();
$top_img_total=array();
$top_point_total = array();
$i=0;
$color_point = array('#FF7F3C','#DF5EF9','#717FFC','#45C729','#676767');
while($point_top                             = @mysql_fetch_assoc($out_sql)){
	
	if($i==0){
		$top_point_total[$i] .= "{name: '".$point_top['hero_nick']."',color: '".$color_point[$i]."',y: ".$point_top['totalPoint']."}";
	}else{
		$top_point_total[$i] .= ", {name: '".$point_top['hero_nick']."',color: '".$color_point[$i]."',y: ".$point_top['totalPoint']."}";
	}
	$top_img_total[$i] .= str($point_top['hero_img_new']);
	$top_nick_total[$i] .= $point_top['hero_nick'];
	$i++;
}

######################################################################################################################################################

######################################################################################################################################################
//금월 포인트
$month = date('Y-m');

$sql_month = "select A.*, B.hero_img_new, C.point_sum from member A inner join level B on A.hero_level = B.hero_level ";//desc
$sql_month .= "left outer join ( SELECT hero_code, SUM(hero_point) as point_sum FROM point where DATE_FORMAT(hero_today,'%Y-%m')='".$month."' GROUP BY hero_code ) AS C ON A.hero_code = C.hero_code ";
$sql_month .= "where 1=1 order by C.point_sum desc limit 0,5;";//desc
//echo $sql_month;
$sql_month=mysql_query($sql_month);
$month_nick_total=array();
$month_img_total=array();
$month_point_total = array();
$i=0;
$color_month = array('#FF7F3C','#8F8F8F','#A5A5A5','#D7D7D7','#eeeeee');
while($month_top                             = @mysql_fetch_assoc($sql_month)){
	if($month_top['point_sum']==null){
		$month_top['point_sum']=0;
	}
	if($i==0){
		$month_point_total[$i] .= "{name: '".$month_top['hero_nick']."',color: '".$color_month[$i]."',y: ".$month_top['point_sum']."}";
	}else{
		$month_point_total[$i] .= ", {name: '".$month_top['hero_nick']."',color: '".$color_month[$i]."',y: ".$month_top['point_sum']."}";
	}
	$month_img_total[$i] .= str($month_top['hero_img_new']);
	$month_nick_total[$i] .= $month_top['hero_nick'];
	$i++;
}

######################################################################################################################################################

######################################################################################################################################################
//금월 포인트

$sql_lover = "select A.*, B.hero_img_new, C.lover_count from member A inner join level B on A.hero_level = B.hero_level ";//desc
$sql_lover .= "left outer join ( SELECT hero_code, count(*) as lover_count FROM board where hero_board_three='1' GROUP BY hero_code ) AS C ON A.hero_code = C.hero_code ";
$sql_lover .= "where 1=1 order by C.lover_count desc limit 0,5;";//desc
//echo $sql_lover;
$sql_lover=mysql_query($sql_lover);
$lover_nick_total=array();
$lover_img_total=array();
$lover_point_total = array();
$i=0;
$color_lover = array('#DF5EF9','#8F8F8F','#A5A5A5','#D7D7D7','#eeeeee');
while($lover_top                             = @mysql_fetch_assoc($sql_lover)){

	if($i==0){
		$lover_point_total[$i] .= "{name: '".$lover_top['hero_nick']."',color: '".$color_lover[$i]."',y: ".$lover_top['lover_count']."}";
	}else{
		$lover_point_total[$i] .= ", {name: '".$lover_top['hero_nick']."',color: '".$color_lover[$i]."',y: ".$lover_top['lover_count']."}";
	}
	$lover_img_total[$i] .= str($lover_top['hero_img_new']);
	$lover_nick_total[$i] .= $lover_top['hero_nick'];
	$i++;
}

######################################################################################################################################################

######################################################################################################################################################
//글작성

$sql_write = "select A.*, B.hero_img_new, C.write_count from member A inner join level B on A.hero_level = B.hero_level ";//desc
$sql_write .= "left outer join ( SELECT hero_code, count(*) as write_count FROM board where 1=1 GROUP BY hero_code ) AS C ON A.hero_code = C.hero_code ";
$sql_write .= "where 1=1 order by C.write_count desc limit 0,5;";//desc
$sql_write = mysql_query($sql_write);
$write_nick_total=array();
$write_img_total=array();
$write_point_total = array();
$i=0;
$color_write = array('#717FFC','#8F8F8F','#A5A5A5','#D7D7D7','#eeeeee');
while($write_top                             = @mysql_fetch_assoc($sql_write)){
	if($i==0){
		$write_point_total[$i] .= "{name: '".$write_top['hero_nick']."',color: '".$color_write[$i]."',y: ".$write_top['write_count']."}";
	}else{
		$write_point_total[$i] .= ", {name: '".$write_top['hero_nick']."',color: '".$color_write[$i]."',y: ".$write_top['write_count']."}";
	}
	$write_img_total[$i] .= str($write_top['hero_img_new']);
	$write_nick_total[$i] .= $write_top['hero_nick'];
	$i++;
}

######################################################################################################################################################

######################################################################################################################################################
//댓글

$sql_review = "select A.*, B.hero_img_new, C.review_count from member A inner join level B on A.hero_level = B.hero_level ";//desc
$sql_review .= "left outer join ( SELECT hero_code, count(*) as review_count FROM review where 1=1 GROUP BY hero_code ) AS C ON A.hero_code = C.hero_code ";
$sql_review .= "where 1=1 order by C.review_count desc limit 0,5;";//desc
$sql_review = mysql_query($sql_review);
$review_nick_total=array();
$review_img_total=array();
$review_point_total = array();
$i=0;
$color_review = array('#45C729','#8F8F8F','#A5A5A5','#D7D7D7','#eeeeee');
while($review_top                             = @mysql_fetch_assoc($sql_review)){
	if($i==0){
		$review_point_total[$i] .= "{name: '".$review_top['hero_nick']."',color: '".$color_review[$i]."',y: ".$review_top['review_count']."}";
	}else{
		$review_point_total[$i] .= ", {name: '".$review_top['hero_nick']."',color: '".$color_review[$i]."',y: ".$review_top['review_count']."}";
	}
	$review_img_total[$i] .= str($review_top['hero_img_new']);
	$review_nick_total[$i] .= $review_top['hero_nick'];
	$i++;
}

######################################################################################################################################################

?>


<script src="/js/highcharts.js"></script>
<script>

$(function () {
    $('#point_top').highcharts({
        chart: {
            type: 'bar',
            height: 180,
        },
        title: {
            text: '',
        },
        xAxis: {
            title: {
                text: ""
            },
            lineColor: 'white',
            tickColor: 'white',
            labels:{
            	enabled: false
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: '',
            },
            
            gridLineColor: 'white',
            labels: {
                enabled: false
            }
        },
        tooltip: {
            valueSuffix: ' POINT',
            useHTML: true,
            headerFormat: '<small>{point.key}</small><table>',
            pointFormat: '<tr><td style="text-align: right"><b>{point.y}</b></td></tr>',
            footerFormat: '</table>',
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        credits: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        series: [{
            name: '',
	        data: [<?=$top_point_total[0] ?>,<?=$top_point_total[1] ?><?=$top_point_total[2] ?><?=$top_point_total[3] ?><?=$top_point_total[4] ?>]
        }]
    });
    
    //$('.highcharts-container').css('height','180px');


    $('#month_top').highcharts({
        chart: {
            type: 'bar',
            height: 180,
        },
        title: {
            text: '',
        },
        xAxis: {
            title: {
                text: ""
            },
            lineColor: 'white',
            tickColor: 'white',
            labels:{
            	enabled: false
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: '',
            },
            
            gridLineColor: 'white',
            labels: {
                enabled: false
            }
        },
        tooltip: {
        	valueSuffix: ' POINT',
            useHTML: true,
            headerFormat: '<small>{point.key}</small><table>',
            pointFormat: '<tr><td style="text-align: right"><b>{point.y}</b></td></tr>',
            footerFormat: '</table>',
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        credits: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        series: [{
            name: '',
	        data: [<?=$month_point_total[0] ?>,<?=$month_point_total[1] ?><?=$month_point_total[2] ?><?=$month_point_total[3] ?><?=$month_point_total[4] ?>]
        }]
    });

    $('#lover_top').highcharts({
        chart: {
            type: 'bar',
            height: 180,
        },
        title: {
            text: '',
        },
        xAxis: {
            title: {
                text: ""
            },
            lineColor: 'white',
            tickColor: 'white',
            labels:{
            	enabled: false
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: '',
            },
            
            gridLineColor: 'white',
            labels: {
                enabled: false
            }
        },
        tooltip: {
        	valueSuffix: ' 회',
            useHTML: true,
            headerFormat: '<small>{point.key}</small><table>',
            pointFormat: '<tr><td style="text-align: right"><b>{point.y}</b></td></tr>',
            footerFormat: '</table>',
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        credits: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        series: [{
            name: '',
	        data: [<?=$lover_point_total[0] ?>,<?=$lover_point_total[1] ?><?=$lover_point_total[2] ?><?=$lover_point_total[3] ?><?=$lover_point_total[4] ?>]
        }]
    });

    $('#write_top').highcharts({
        chart: {
            type: 'bar',
            height: 180,
        },
        title: {
            text: '',
        },
        xAxis: {
            title: {
                text: ""
            },
            lineColor: 'white',
            tickColor: 'white',
            labels:{
            	enabled: false
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: '',
            },
            
            gridLineColor: 'white',
            labels: {
                enabled: false
            }
        },
        tooltip: {
        	valueSuffix: ' 회',
            useHTML: true,
            headerFormat: '<small>{point.key}</small><table>',
            pointFormat: '<tr><td style="text-align: right"><b>{point.y}</b></td></tr>',
            footerFormat: '</table>',
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        credits: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        series: [{
            name: '',
	        data: [<?=$write_point_total[0] ?>,<?=$write_point_total[1] ?><?=$write_point_total[2] ?><?=$write_point_total[3] ?><?=$write_point_total[4] ?>]
        }]
    });

    $('#review_top').highcharts({
        chart: {
            type: 'bar',
            height: 180,
        },
        title: {
            text: '',
        },
        xAxis: {
            title: {
                text: ""
            },
            lineColor: 'white',
            tickColor: 'white',
            labels:{
            	enabled: false
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: '',
            },
            
            gridLineColor: 'white',
            labels: {
                enabled: false
            }
        },
        tooltip: {
        	valueSuffix: ' 회',
            useHTML: true,
            headerFormat: '<small>{point.key}</small><table>',
            pointFormat: '<tr><td style="text-align: right"><b>{point.y}</b></td></tr>',
            footerFormat: '</table>',
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            enabled: false
        },
        credits: {
            enabled: false
        },
        series: [{
            name: '',
	        data: [<?=$review_point_total[0] ?>,<?=$review_point_total[1] ?><?=$review_point_total[2] ?><?=$review_point_total[3] ?><?=$review_point_total[4] ?>]
        }]
    });

});
</script>

<link href="css/aklover.css" rel="stylesheet" type="text/css">
<!--컨텐츠 시작-->
<div id="title">
	<p>
		포인트 순위
	</p>
</div>
<div>
	<img src="img/shadow1.jpg" alt="" width="100%" height="2px"/>
</div>
<div >

        <div class="contents">
			<div class="chart_main">
				<div style="margin: 20px 0 5px 6%;"><span id="chart_title">누적포인트 TOP5<span></div>
				<div class="chart_nick">
					<?for ($i = 0; $i < count($top_nick_total); $i++) {
						echo "<p><span style='background-color: ".$color_point[$i].";'>".($i+1)."</span>";
						echo "<img src='".$top_img_total[$i]."'>".$top_nick_total[$i]."</p>";
					}?>
				</div>
				<div id="point_top" style="width: 64%;float: left;height: 160px;overflow: hidden;" ></div>
			</div>
			
			<div class="chart_main">
				<div style="margin: 20px 0 5px 6%;"><span id="chart_title" style="background-color: <?=$color_point[0] ?>;">금월포인트 TOP5<span></div>
				<div class="chart_nick">
					<?for ($i = 0; $i < count($month_nick_total); $i++) {
						echo "<p><span style='background-color: ".$color_point[$i].";'>".($i+1)."</span>";
						echo "<img src='".$month_img_total[$i]."'>".$month_nick_total[$i]."</p>";
					}?>
				</div>
				<div id="month_top" style="width: 64%;float: left;height: 160px;overflow: hidden;" ></div>
			</div>
			
			<div class="chart_main">
				<div style="margin: 20px 0 5px 6%;"><span id="chart_title" style="background-color: <?=$color_point[2] ?>;">글작성 TOP5<span></div>
				<div class="chart_nick">
					<?for ($i = 0; $i < count($write_nick_total); $i++) {
						echo "<p><span style='background-color: ".$color_point[$i].";'>".($i+1)."</span>";
						echo "<img src='".$write_img_total[$i]."'>".$write_nick_total[$i]."</p>";
					}?>
				</div>
				<div id="write_top" style="width: 64%;float: left;height: 160px;overflow: hidden;" ></div>
			</div>
			
			<div class="chart_main">
				<div style="margin: 20px 0 5px 6%;"><span id="chart_title" style="background-color: <?=$color_point[1] ?>;">러버스타 TOP5<span></div>
				<div class="chart_nick">
					<?for ($i = 0; $i < count($lover_nick_total); $i++) {
						echo "<p><span style='background-color: ".$color_point[$i].";'>".($i+1)."</span>";
						echo "<img src='".$lover_img_total[$i]."'>".$lover_nick_total[$i]."</p>";
					}?>
				</div>
				<div id="lover_top" style="width: 64%;float: left;height: 160px;overflow: hidden;" ></div>
			</div>
			
			<div class="chart_main">
				<div style="margin: 20px 0 5px 6%;"><span id="chart_title" style="background-color: <?=$color_point[3] ?>;">댓글 TOP5<span></div>
				<div class="chart_nick">
					<?for ($i = 0; $i < count($review_nick_total); $i++) {
						echo "<p><span style='background-color: ".$color_point[$i].";'>".($i+1)."</span>";
						echo "<img src='".$review_img_total[$i]."'>".$review_nick_total[$i]."</p>";
					}?>
				</div>
				<div id="review_top" style="width: 64%;float: left;height: 160px;overflow: hidden;" ></div>
			</div>	
			
		</div>
</div>
<?include_once "tail.php";?>