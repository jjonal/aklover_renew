<link rel="stylesheet" href="../css/front/check.css">
<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################

//���� ���� ������ �α���â���� �̵�
if(!strcmp($_SESSION['temp_code'],'')){error_location('�⼮üũ�� �α��� �Ŀ� �����մϴ�.','/main/index.php?board=login');exit;}

	##���� ����
######################################################################################################################################################
	$temp_id 		= 	$_SESSION['temp_id'];
	$temp_code 		= 	$_SESSION['temp_code'];
	$temp_nick 		= 	$_SESSION['temp_nick'];
	
	$today 			= 	date("Y-m-d");
	$full_today 	= 	date("Y-m-d H:i:s");		
	$board			=	$_GET['board'];
	
	//���� ������Ʈ
	/* if(strcmp($_SESSION['temp_drop'], '')){
	    $temp_drop = $_SESSION['temp_drop'];
	    if($temp_drop <= $today){
	        $sql = "UPDATE member SET hero_dropday=null, hero_level='".$_SESSION['temp_level']."', hero_write='".$_SESSION['temp_level']."', hero_view='".$_SESSION['temp_level']."', hero_update='".$_SESSION['temp_level']."', hero_rev='".$_SESSION['temp_level']."' WHERE hero_code = '".$_SESSION['temp_code']."'".PHP_EOL;
	        mysql_query($sql);
	        $_SESSION['temp_write']=$_SESSION['temp_level'];
	        $_SESSION['temp_view']=$_SESSION['temp_level'];
	        $_SESSION['temp_update']=$_SESSION['temp_level'];
	        $_SESSION['temp_rev']=$_SESSION['temp_level'];
	        unset($_SESSION['temp_drop']);
	    }
	} 
		
	if(strcmp($_SESSION['temp_level'], '')){
	
	    $my_level = $_SESSION['temp_level'];
	    $my_write = $_SESSION['temp_write'];
	    $my_view = $_SESSION['temp_view'];
	    $my_update = $_SESSION['temp_update'];
	    $my_rev = $_SESSION['temp_rev'];
	    
	}
	*/	
	
##�湮�� ȸ�� ����Ʈ ���Ϸ� ����
######################################################################################################################################################
$fileName = date("Ym")."afli9389-4-k04rnjx.txt";
$dir = "/home/users/aekyung/board/guide_4/visitedList/".$fileName;

if(is_file($dir) && is_dir("/home/users/aekyung/board/guide_4/visitedList/"))			$file = fopen($dir,"ab");
elseif(is_dir("/home/users/aekyung/board/guide_4/visitedList/"))						$file = fopen($dir,"wb");

if($file){

    $bname = browser_check();

    $log = $temp_nick."/".date('Y-m-d H:i:s')."/".$bname."\n";
    //echo $log;

    fwrite($file,$log);
    fclose($file);
}

## ���� üũ
######################################################################################################################################################
$sql = "select * from hero_group where hero_board='".$board."'";
sql($sql, 'on');
$point_list                             = @mysql_fetch_assoc($out_sql);

//������ ���� ���� ���� ������� ������ ���� ���
//if($point_list['hero_write'] > $my_level){		error_historyBack($point_list['hero_write']."�������� �̿밡���� �������Դϴ�.");exit;	}

######################################################################################################################################################
$sql = "select * from member where hero_code='".$temp_code."'";
$member = mysql_query($sql);

if(!$member){
	logging_error($temp_code, $board."-ATTENDENCE_01 : ".$sql, $full_today);
	error_location("","/main/index.php?board=group_04_04");
	exit;
}
$member_list                             = mysql_fetch_assoc($member);

$todayMusign = date("Y-m-d H:i:s");
$todayArray = explode("-", $todayMusign);
$startData = $todayArray[0] . '-' . $todayArray[1] . '-' . '01' . ' ' . "00:00:00";
$endData = $today . ' ' . "23:59:59"; //today�θ� �ϴϱ� ��ȸ �ȵǼ� �߰�

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


if(!strcmp($old_point,''))   $old_point = '0';
else				  	            $old_point = $old_point;

	
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

## �⼮üũ ���
######################################################################################################################################################
if(!strcmp($_GET['type'], 'write')){
	// �������� �ι������°� ���� ����
    if($today_list['double_check']){
		error_location("�̹� �⼮�ϼ̽��ϴ�.", PATH_HOME.'?'.get('type'));
        msg($msg.' �ϼ̽��ϴ�.','location.href="'.$action_href.'"');
        exit;
    }	
    
    //����Ʈ �ο� �� ������//���̺�, Ÿ��, �۹�ȣ, �����ȣ, ����, �ִ�����Ʈ ���Կ���, ��¥
	###################################################################################################################################################### 	
	//�Ѵ� ���� 50point ����

	if(date('d',time())==date('t')){//���������� üũ
		attendanceGift($temp_id, $temp_code);
	};

    $point_insert_pf = pointAdd($board, 'attendance', 0, 0, 0, "�⼮üũ", 'Y');
    	
   	if(substr($point_insert_pf,0,7)=='message'){
	    $point_insert_pf = explode(":",$point_insert_pf);
	    message($point_insert_pf[1]);  
	}else if($point_insert_pf!=1){

		error_location("",PATH_HOME.'?'.get('type'));
		exit;
	}
	 	
	location(PATH_HOME.'?'.get('type'));


######################################################################################################################################################
    exit;
}
######################################################################################################################################################]]
?>
        <div class="contents">
            <?
            if(!$_GET['m_day']){
                $y_day = date(Y);
                $m_day = date(m);
            }else{
                $y_day = $_GET['y_day'];
                $m_day = $_GET['m_day'];
            }
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

            $today = date('Y-m-d', time());
            $dayspacer = @date("w",mktime(0,0,0,$m_day,1,$y_day));//������
            $lastday = @date("t",mktime(0,0,0,$m_day,1,$y_day));//��������
            ?>


            <div class="f_sb calbox">
                <div class="cal_left">
                    <div>
                        <!-- �����̵� -->
                        <div class="ym_btn f_cs"> 
                            <a href="<?=$PHP_SELF.'?'.get('y_day||m_day','y_day='.$new_y_day.'&m_day='.$new_m_day)?>" class="ym_arr ym_left dis-no"><img src="/img/front/icon/left_arr.webp" class="btn1"/></a>
                            <span class="yearmonth fz24 fw800"><?=$y_day.'.'.$m_day?></span>
                            <a href="<?=$PHP_SELF.'?'.get('y_day||m_day','y_day='.$next_y_day.'&m_day='.$next_m_day)?>" class="ym_arr ym_right dis-no"><img src="/img/front/icon/right_arr.webp" class="btn2" /></a>
                        </div>
                        <!-- �⼮��ư -->
                        <div class="cal_group rel">
                            <div>
                                <p class="chk_tit bold">���� ���� �⼮üũ�ϰ�</p><br />
                                <p class="chk_tit bold">��&ensp;&ensp;��&ensp;&ensp;Ʈ&ensp;&ensp;��&ensp;&ensp;�� !</p>
                                <!-- �⼮üũ ��ư, ��ũ��Ʈ �ӽ� ���� -->
                                <!-- ���⿡ �ٽ� ���� -->
                                <a href="javascript:btn_write()" <?=$stlye_none?> class="btn_submit btn_black check_today">�⼮üũ�ϱ� <img src="/img/front/icon/check_today.png" alt="�⼮üũ�ϱ�"></a>
                                <script>
                                    var session = "<?=$_SESSION['temp_code']?>";
                                    function btn_write() {
                                        if(session == '') {
                                            alert('�⼮üũ�� �α��� �Ŀ� �����մϴ�.');
                                            return;
                                        }
                                        location.href="/main/index.php?board=group_04_04&type=write";                                    
                                    }
                                </script>                   	
                            </div>
                            <div class="check_grade">
                                <?                            
                                $pk_sql = 'select a.hero_level,a.hero_nick,b.hero_img_new from member as a, level as b  where b.hero_level = a.hero_level and a.hero_code = \''.$_SESSION['temp_code'].'\'';
                                $out_pk_sql = mysql_query($pk_sql);
                                $pk_row                             = @mysql_fetch_assoc($out_pk_sql);

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
                                <ul>
                                    <li class="f_b">
                                        <div class="fz16 fw600">���� �׷�</div>
                                        <div><img src="<?=str($pk_row['hero_img_new'])?>" height="25px"/></div>
                                    </li> 
                                    <li class="f_b">
                                        <div class="fz16 fw600">���� <?=$m_day?>�� �⼮ �� ��</div>
                                        <div class="fz16 fw600"><span class="brown"><?=($todayArray[1] == 07) ? $old_count + $closeDay : $old_count; ?></span>��</p></div>
                                    </li>
                                </ul>     
                            </div>   
                        </div>    
                    </div>
                    <div class="text_check">                            
                        <span>
                            ���ϸ��� �⼮üũ�� �����غ�����!<br />
                            (�⼮üũ �� 1p, �� �� ��ü �⼮ �� 50p �߰� ����)
                        </span>
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
                        //    $end_day = date('Y-m-d', mktime(0, 0, 0, $m_day, $lastday+1, $y_day));
                            $end_day = date('Y-m-d', mktime(0, 0, 0, $m_day, $lastday, $y_day));
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
                                if(!strcmp($check_ok,'1')){
                                    $img_open = '<div class="chk_status"><img src="/img/front/icon/chk_done.png" alt="�⼮" /></div>';
                                } else if ( $check_date >= $today  ) {
//                                    $img_open = '<div class="chk_status"><img src="/img/front/icon/chk_default.png" alt="�⼮���" /></div>';
                                    $img_open = '<div class="chk_status chk_date">'.$day_i.'</div>';
                                } else {
                                    $img_open = '<div class="chk_status"><img src="/img/front/icon/chk_fail.png" alt="�⼮����" /></div>';
                                }
                                if ($check_date == $today){
                                    if (@date("w",mktime(0,0,0,$m_day,$day_i,$y_day)) == 0){
                                        echo '<tr class="we'.$dd.'"><td class="week">'.$img_open.'<span class=""><font color=green><b>����'.$str_date.'</b></font></span>/td>'.PHP_EOL;
                                    }else{
                                        echo '<td class="week">'.$img_open.'<span class=""><font color=green><b>����'.$str_date.'</b></font></span></td>'.PHP_EOL;
                                    }
                                }else if (@date("w",mktime(0,0,0,$m_day,$day_i,$y_day)) == 0){
                                    echo '<tr class="we'.$dd.'"><td class="week">'.$img_open.'<span class="c_red">'.$str_date.'</span></td>'.PHP_EOL;
                                }else if (@date("w",mktime(0,0,0,$m_day,$day_i,$y_day)) == 6){
                                    echo '<td class="week">'.$img_open.'<span class="c_blue">'.$str_date.'</span></td>'.PHP_EOL;
                                }else{
                                    echo '<td class="week">'.$img_open.'<span class="">'.$str_date.'</span></td>'.PHP_EOL;
                                }
                                if($day_i == $lastday){
                                    $week = 5;
                                    $last_week = @date("w",mktime(0,0,0,$m_day,$day_i,$y_day));
                                    for($i=0; $i<=$week-$last_week; $i++){
                                        echo '<td></td>'.PHP_EOL;
                                    }
                                }
                                if( (!(($null_i+$day_i)%7)) or ($str_date == $lastday) ){
                        //        if(!(($null_i+$day_i)%7)){
                                echo "</tr>".PHP_EOL;
                                $dd++;
                                }
                            }
                        ?>
                        </tbody>
                    </table>
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
