<link rel="stylesheet" href="/m/css/musign/check.css">
<?php
include_once "head.php";
#####################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
//���� ���� ������ �α���â���� �̵�
//echo URI_PATH;
if(!strcmp($_SESSION['temp_code'],'')){error_location('�⼮üũ�� �α��� �Ŀ� �����մϴ�.',"/m/main.php");exit;}
include_once "../combined/attendance.php";
$right_list['hero_title'] = $point_list["hero_title"];

$today 			= 	date("Y-m-d");

$todayMusign = date("Y-m-d H:i:s");
$todayArray = explode("-", $todayMusign);
$startData = $todayArray[0] . '-' . $todayArray[1] . '-' . '01' . ' ' . "00:00:00";
$endData = $today . ' ' . "23:59:59"; //today�θ� �ϴϱ� ��ȸ �ȵǼ� �߰�

//�� �⼮��
//$old_sql = "select A.hero_point, B.count from (select sum(hero_point) as hero_point from point where hero_code='".$temp_code."') as A, (select count(*) as count from point where hero_code='".$temp_code."' and hero_top_title='�⼮üũ') as B";
$old_sql = "select A.hero_point, B.count from (select sum(hero_point) as hero_point from point where hero_code='".$temp_code."') as A, (select count(*) as count from point where hero_code='".$temp_code."' and hero_top_title='�⼮üũ' AND hero_today BETWEEN '" . $startData ."' AND '" . $endData . "') as B";

$out_old_sql = mysql_query($old_sql);
if(!$out_old_sql){
    logging_error($temp_code, $board."-ATTENDENCE_02 : ".$old_sql, $full_today);
    error_location("","/main/index.php?board=group_04_04");
    exit;
}

$out_old_res = mysql_fetch_assoc($out_old_sql);
$old_point = $out_old_res['hero_point'];
$old_count = $out_old_res['count'];

//���� ��ý�ߴ��� ���ߴ��� Ȯ��
$sql = "select count(*) as double_check from point where hero_table='".$board."' and hero_code = '".$temp_code."' and left(hero_today,10)='".$today."' order by hero_today desc limit 0,1";
$double_check_sql = mysql_query($sql);

//echo $sql . '</br>';

if(!$double_check_sql){
    logging_error($temp_code, $board."-ATTENDENCE_03 : ".$sql, $full_today);
    error_location("","/main/index.php?board=group_04_04");
    exit;
}

$today_list                             = mysql_fetch_assoc($double_check_sql);

//��ư none
if($today_list['double_check']){
    $stlye_none = "style='display:none'";

    //error_location("�̹� �⼮�ϼ̽��ϴ�.", PATH_HOME.'?'.get('type'));
    //msg($msg.' �ϼ̽��ϴ�.','location.href="'.$action_href.'"');
    //exit;
}
?>
	
<!--������ ����-->
<div id="content" class=""> 
    <div id="content_bg">
		<div class="cal_left">
    	<?
		    $y_day = date(Y);
		    $m_day = date(m);
			if(!strcmp($m_day,'1')){
			    $new_y_day = $y_day-1;
			    $new_m_day = '12';
				
			    $next_y_day = $y_day;
			    $next_m_day = $m_day+1;
			}else if(!strcmp($m_day,'12')){
			    $new_y_day = $y_day;
			    $new_m_day = $m_day-1;
				
			    $next_y_day = $y_day+1;
			    $next_m_day = '1';
			}else{
			    $new_y_day = $y_day;
			    $new_m_day = $m_day-1;
				
			    $next_y_day = $y_day;
			    $next_m_day = $m_day+1;
			}
				
			$today = date('Y-m-d');
			$dayspacer = @date("w",mktime(0,0,0,$m_day,1,$y_day));//������
			$lastday = @date("t",mktime(0,0,0,$m_day,1,$y_day));//��������
		?>
			<p class="chk_tit bold">���� ���� �⼮üũ�ϰ�</p>
			<p class="chk_tit bold">��&ensp;&ensp;��&ensp;&ensp;Ʈ&ensp;&ensp;��&ensp;&ensp;�� !</p>
			<div class="text_check">                            
				<span>
					���ϸ��� �⼮üũ�� �����غ�����!<br />
					(�⼮üũ �� 1p, �� �� ��ü �⼮ �� 50p �߰� ����)
				</span>
			</div>
			<!-- �⼮üũ ��ư �ӽ� ���� -->
			<? if($_SESSION['temp_code']) { ?>
				<?if($out_old_res['hero_today']){?>
				<?}else{?>
					<!-- ���⿡�� �ٽ� ���� -->
					<a href="<?=DOMAIN_END.'m/check.php?'.get('','type=write');?>" <?=$stlye_none?> class="btn_submit btn_black check_today">
						�⼮üũ�ϱ� <img src="/img/front/icon/check_today.png" alt="�⼮üũ�ϱ�">
					</a>
				<?
				}
			$pk_sql = 'select a.hero_level,a.hero_nick,b.hero_img_new from member as a, level as b  where b.hero_level = a.hero_level and a.hero_code = \''.$_SESSION['temp_code'].'\'';
			$out_pk_sql = mysql_query($pk_sql);
			$pk_row                             = @mysql_fetch_assoc($out_pk_sql);
			?>
			<div class="check_grade">
				<ul>
					<li class="f_b">
						<div class="fz16 fw600">���� �׷�</div>
						<div><img src="<?=str($pk_row['hero_img_new'])?>" height="25px"/></div>
					</li> 
					<li class="f_b">
						<div class="fz16 fw600">���� <?=$m_day?>�� �⼮ �� ��</div>
						<!-- [�����ʿ�] pc���� �� �⼮���� �ִµ� ����Ͽ��� ��� ���� �ʿ��մϴ� -->
                        <?
                        $closeDay = 4;

                        //2024-07-05 ��ý ���� üũ
                        $closeDay_sql05 = 'select count(*) cnt from point where hero_code = \''.$_SESSION['temp_code'].'\' and hero_top_title=\'�⼮üũ\' and hero_today like \'2024-07-05%\' ';
                        sql($closeDay_sql05);
                        $out_res05 = mysql_fetch_assoc($out_sql);
                        $closeDay05 = $out_res05["cnt"];

                        if($closeDay05 != 0){ //2024-07-08 ��ý ������ -1
                        $closeDay--;
                        }

                        //2024-07-08 ��ý ���� üũ
                        $closeDay_sql08 = 'select count(*) cnt from point where hero_code = \''.$_SESSION['temp_code'].'\' and hero_top_title=\'�⼮üũ\' and hero_today like \'2024-07-08%\' ';
                        sql($closeDay_sql08);
                        $out_res08 = mysql_fetch_assoc($out_sql);
                        $closeDay08 = $out_res08["cnt"];

                        if($closeDay08 != 0){ //2024-07-08 ��ý ������ -1
                        $closeDay--;
                        }
                        ?>
						<div class="fz16 fw600"><span class="brown"><?=($todayArray[1] == 07) ? $old_count + $closeDay : $old_count; ?></span>��</p></div>
					</li>
				</ul>   
			</div>   				
			<? } else { ?>
			<a href="javascript:;" onClick="alert('�⼮üũ�� �α��� �Ŀ� �����մϴ�.')" class="btn_submit btn_black check_today">
				�⼮üũ�ϱ� <img src="/img/front/icon/check_today.png" alt="�⼮üũ�ϱ�">
			</a>
			<? } ?>	
			
			<!-- [�����ʿ�] ���� ����Ͽ��� ����� ��� pc�� �����ϰ� �Ű� �ξ����ϴ� -->
			<div class="ym_btn f_c"> 
				<a href="<?=$PHP_SELF.'?'.get('y_day||m_day','y_day='.$new_y_day.'&m_day='.$new_m_day)?>" class="ym_arr ym_left dis-no"><img src="/m/img/musign/icon/check_left.png" class="btn1"/></a>
				<span class="yearmonth fz36 fw800"><?=$y_day.'.'.$m_day?></span>
				<a href="<?=$PHP_SELF.'?'.get('y_day||m_day','y_day='.$next_y_day.'&m_day='.$next_m_day)?>" class="ym_arr ym_right dis-no"><img src="/m/img/musign/icon/check_right.png" class="btn2" /></a>
			</div>	
		</div>
		<div class="cal_right">
           		<table border="0" cellpadding="0" cellspacing="0" class="calendar">
				   <colgroup>
						<col width="14%">
						<col width="14%">
						<col width="14%">
						<col width="14%">
						<col width="14%">
						<col width="14%">
						<col width="14%">
					</colgroup>
					<thead>
						<tr>
							<td>SUN</td>
							<td>mon</td>
							<td>tue</td>
							<td>wed</td>
							<td>thu</td>
							<td>fri</td>
							<td>sat</td>
						</tr>
					</thead>
					<tbody>
					<?
					    for ($null_i = 0; $null_i < $dayspacer; $null_i++){
					        if ($null_i == '0'){
					    		echo '<tr class="we1">'.PHP_EOL;
					    		echo '<td class="week"></td>'.PHP_EOL;
					        }else{
					    		echo '<td class="week"></td>'.PHP_EOL;
					        }
					    }
					    
					    $dd = '1';
					    $start_day = date('Y-m-d', mktime(0, 0, 0, $m_day, 1, $y_day));
					    $end_day = date('Y-m-d', mktime(0, 0, 0, $m_day, $lastday, $y_day));
					    
					    $error = "ATTENDANCE_01";
					    $sql = 'select date(hero_today) as lee from point where hero_table=\''.$board.'\' and hero_id=\''.$temp_id.'\' and date(hero_today) >= \''.$start_day.'\' and date(hero_today) <=\''.$end_day.'\' order by hero_today asc;';
					    $attendance_res = new_sql($sql,$error,'on');
					    
					    if($attendance_res==$error){
					    	error_historyBack("");
					    	exit;
					    }  
					    
					    while($attendance_rs                             = mysql_fetch_assoc($attendance_res)){
					        $all_day[] = $attendance_rs['lee'];
					    }

                        $sql = 'select date(hero_today) as lee from point where hero_table=\''.$board.'\' and hero_id=\''.$temp_id.'\' and date(hero_today) >= \''.$start_day.'\' and date(hero_today) <=\''.$end_day.'\' order by hero_today asc;';

                        sql($sql, 'on');
                        while($today_old_list                             = @mysql_fetch_assoc($out_sql)){
                            $all_day[] = $today_old_list['lee'];
                            //musign �̹��޸� �۾� �ش޶�� ��. 7�� �۾��Ⱓ..?
                            $musignEventArray = explode('-' , $today_old_list['lee']);
                            if($musignEventArray[1] == 07) {
                                $all_day[] = '2024-07-05';
                                $all_day[] = '2024-07-06';
                                $all_day[] = '2024-07-07';
                                $all_day[] = '2024-07-08';
                            }
                            $all_day = array_unique($all_day);
                        }
					    
					    for ($day_i = 1; $day_i <= $lastday; $day_i++){
					        $str_date = @date("d",mktime(0,0,0,$m_day,$day_i,$y_day));
					        $check_date = @date("Y-m-d",mktime(0,0,0,$m_day,$day_i,$y_day));
					        $check_ok = @in_array($check_date,$all_day);//������ 1
					        
					        if(!strcmp($check_ok,'1'))           $img_open = '<div class="chk_status"><img src="/img/front/icon/chk_done.png" alt="�⼮" /></div>';
							//else if($check_date >= $today)      $img_open = '<div class="chk_status"><img src="/img/front/icon/chk_default.png" alt="�⼮���" /></div>';
							else if($check_date >= $today)      $img_open = '<div class="chk_status chk_date f_c">'.$day_i.'</div>';
					        else						         $img_open = '<div class="chk_status"><img src="/img/front/icon/chk_fail.png" alt="�⼮����" /></div>';
					
					        if ($check_date == $today){
					
					        	if (@date("w",mktime(0,0,0,$m_day,$day_i,$y_day)) == 0)        echo '<tr class="we'.$dd.'"><td class="week">'.$img_open.'<span class="screen_out"><font color=green><b>����'.$str_date.'</b></font></span></td>'.PHP_EOL;
					            else											               echo '<td class="week">'.$img_open.'<span class="screen_out"><font color=green><b>����'.$str_date.'</b></font></span></td>'.PHP_EOL;
					        
					        
					        }else if (@date("w",mktime(0,0,0,$m_day,$day_i,$y_day)) == 0)      echo '<tr class="we'.$dd.'"><td class="week">'.$img_open.'<span class="screen_out">'.$str_date.'</span></td>'.PHP_EOL;
					        else if (@date("w",mktime(0,0,0,$m_day,$day_i,$y_day)) == 6)       echo '<td class="week">'.$img_open.'<span class="screen_out">'.$str_date.'</span></td>'.PHP_EOL;
					        else													           echo '<td class="week">'.$img_open.'<span class="screen_out">'.$str_date.'</span></td>'.PHP_EOL;
					        
							if($day_i == $lastday){
								$week = 5;
								$last_week = @date("w",mktime(0,0,0,$m_day,$day_i,$y_day));
								for($i=0; $i<=$week-$last_week; $i++){
									echo '<td></td>'.PHP_EOL;
								}                                    
							}
					        if( (!(($null_i+$day_i)%7)) or ($str_date == $lastday) ){
						        echo "</tr>".PHP_EOL;
					    	    $dd++;
					        }
					    }
					    
					?>
					</tbody>
           	</table>     
		</div>    
    </div>    
</div> 
<script>
	const lastRow = document.querySelector('.cal_right tbody tr:last-child');
		if (lastRow) {
		const weekTds = lastRow.querySelectorAll('td.week');                
		if (weekTds.length > 0) {
			const lastWeekTd = weekTds[weekTds.length - 1];                    
			lastWeekTd.classList.add('last_day');
		}
	}
</script>
<!--������ ����-->
<?include_once "tail.php";
?>