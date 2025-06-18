<?
$sql = "select hero_today_01_01, hero_today_01_02, hero_today_02_01, hero_today_02_02, hero_today_03_01, hero_today_03_02, hero_today_04_01, hero_today_04_02, hero_type from mission ";
$sql .= "where hero_table = '".$_GET['board']."' and hero_idx = '".$_GET['mission_idx']."' ";
sql ( $sql, 'on' );
$missionDate = @mysql_fetch_assoc ( $out_sql ); 

$yoil = array('일','월','화','수','목','금','토');

$startD = $missionDate['hero_today_01_01'];
$endD = $missionDate['hero_today_01_02'];
$startD = $yoil[date('w', strtotime($startD))];
$endD = $yoil[date('w', strtotime($endD))];

$releaseSD = $missionDate['hero_today_02_01'];
$releaseSD = $yoil[date('w', strtotime($releaseSD))];
$releaseED = $missionDate['hero_today_02_02'];
$releaseED = $yoil[date('w', strtotime($releaseED))];

$reviewSD = $missionDate['hero_today_03_01'];
$reviewED = $missionDate['hero_today_03_02'];
$reviewSD = $yoil[date('w', strtotime($reviewSD))];
$reviewED = $yoil[date('w', strtotime($reviewED))];

$bestSD = $missionDate['hero_today_04_01'];
$bestSD = $yoil[date('w', strtotime($bestSD))];
$bestED = $missionDate['hero_today_04_02'];
$bestED = $yoil[date('w', strtotime($bestED))];
?>
<div class="content_date right">
    <!-- 일반미션 (s)-->
    <? if($_GET['board'] == 'group_04_05' && $mission_board_type == false){?> 
        <div class="applybox">
            <ul>
                <li> 
                    <div class="<?=$date_color_01?> tit">체험단 신청</div>
                    <div class="<?=$date_color_01?> cont"><?=date('m.d',strtotime($out_row['hero_today_01_01'])).'('.$startD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_01_02'])).'('.$endD.')'?></div>
                </li>
                <li>
                    <div class="<?=$date_color_02?> tit">선정자 발표</div>
                    <div class="<?=$date_color_02?> cont"><?=date('m.d',strtotime($out_row['hero_today_02_01'])).'('.$releaseSD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_02_02'])).'('.$releaseED.')'?></div>
                </li> 
                <? if($out_row['hero_today_02_02']!=$out_row['hero_today_03_02']){ ?>
                        <li>
                            <div class="<?=$date_color_03?> tit">콘텐츠 등록</div>
                            <div class="<?=$date_color_03?> cont"><?=date('m.d',strtotime($out_row['hero_today_03_01'])).'('.$reviewSD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_03_02'])).'('.$reviewED.')'?></div>
                        </li>
                    <? if($out_row['hero_today_04_01'] !=  "0000-00-00 00:00:00" && $out_row['hero_today_04_02'] != "0000-00-00 00:00:00") {?>
                        <li>
                            <div class="<?=$date_color_04?> tit">우수콘텐츠 발표</div>
                            <div class="<?=$date_color_04?> cont"><?=date('m.d',strtotime($out_row['hero_today_04_01'])).'('.$bestSD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_04_02'])).'('.$bestED.')'?></div>
                        </li>
                    <? } ?>
                <? }?>     
            </ul>
        </div>           
    <? }?>
    <!-- 일반미션 (e) -->
    
    <!-- 일반미션 중에 소문내기(s)-->
    <? if($_GET['board'] == 'group_04_05' && $mission_board_type){ 
            $txt_type_1 = "";
            if($out_row["hero_type"] == "2") {
                $txt_type_1 = "소문내기";
            } else if($out_row["hero_type"] == "10") {
                $txt_type_1 = "체험단";
            }
    ?> 
        <div class="applybox">
            <ul>
                <li>
                    <div class="<?=$date_color_01?> tit"><?=$txt_type_1?> 참여</div>
                    <div class="<?=$date_color_01?> cont"><?=date('m.d',strtotime($out_row['hero_today_01_01'])).'('.$startD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_01_02'])).'('.$endD.')'?></div>
                </li>
                <?php if($out_row['hero_today_01_01']!=$out_row['hero_today_04_01']){ ?>                    
                <li>
                    <div class="<?=$date_color_02?> tit">선정자 및 우수자 발표</div>
                    <div class="<?=$date_color_02?> cont"><?=date('m.d',strtotime($out_row['hero_today_04_01'])).'('.$bestSD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_04_02'])).'('.$bestED.')'?></div>
            
                </li>
            <? }?>   
            </ul>                         
        </div>
    <? }?>
    <!-- 일반미션 중에 소문내기 (e) -->
    
    <!-- AK기자단 (s)-->
    <? if($_GET['board'] == 'group_04_08'){?> 

        <div class="applybox">
            <ul>
                <li>
                    <div class="<?=$date_color_01?> tit">체험단 신청</div>
                    <div class="<?=$date_color_01?> cont"><?=date('m.d',strtotime($missionDate['hero_today_01_01'])).'('.$startD.')'.'~ '.date('m.d',strtotime($missionDate['hero_today_01_02'])).'('.$endD.')'?></div>
                </li>            
                <li>
                    <div class="<?=$date_color_02?> tit">선정자 발표</div>
                    <div class="<?=$date_color_02?> cont"><?=date('m.d',strtotime($missionDate['hero_today_02_01'])).'('.$releaseSD.')'.'~ '.date('m.d',strtotime($missionDate['hero_today_02_01'])).'('.$releaseED.')'?></div>
                </li>
            </ul>                         
        </div>
    <? }?>
    <!-- AK기자단 (e) -->
    
    <!-- 뷰티/유튜버/라이프 (s)-->
    <? if($_GET['board'] == 'group_04_06' || $_GET['board'] == 'group_04_27' || $_GET['board'] == 'group_04_28'){?> 
        <? if($out_row['hero_type'] == "7") {//자율미션 ?>
        <div class="applybox">
            <ul>
                <li>
                    <div class="<?=$date_color_01?> tit">체험단 신청</div>
                    <div class="<?=$date_color_01?> cont"><?=date('m.d',strtotime($out_row['hero_today_01_01'])).'('.$startD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_01_02'])).'('.$endD.')'?></div>
                </li>
                <li>
                    <div class="<?=$date_color_02?> tit">선정자 발표</div>
                    <div class="<?=$date_color_02?> cont"><?=date('m.d',strtotime($out_row['hero_today_02_01'])).'('.$releaseSD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_02_02'])).'('.$releaseED.')'?></div>
                </li>                    
                <? if($out_row['hero_today_02_02']!=$out_row['hero_today_03_02']){ ?>
                    <li>
                        <div class="<?=$date_color_03?> tit">콘텐츠 등록</div>
                        <div class="<?=$date_color_03?> cont"><?=date('m.d',strtotime($out_row['hero_today_03_01'])).'('.$reviewSD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_03_02'])).'('.$reviewED.')'?></div>
                    </li>
                    <? if($out_row['hero_today_04_01'] !=  "0000-00-00 00:00:00" && $out_row['hero_today_04_02'] != "0000-00-00 00:00:00") {?>
                        <li>
                            <div class="<?=$date_color_04?> tit">우수콘텐츠 발표</div>
                            <div class="<?=$date_color_04?> cont"><?=date('m.d',strtotime($out_row['hero_today_04_01'])).'('.$bestSD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_04_02'])).'('.$bestED.')'?></div>
                        </li>
                    <? } ?>
                <? }?>
            </ul>
        </div>
        <? } else if($out_row['hero_type'] == "9") {//정기미션(선택)?>
        <div class="applybox">
            <ul>
                <li>
                    <div class="<?=$date_color_01?> tit">체험단 신청</div>
                    <div class="<?=$date_color_01?> cont"><?=date('m.d',strtotime($out_row['hero_today_01_01'])).'('.$startD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_01_02'])).'('.$endD.')'?></div>
                </li>
                <li>
                    <div class="<?=$date_color_02?> tit">선정자 발표</div>
                    <div class="<?=$date_color_02?> cont"><?=date('m.d',strtotime($out_row['hero_today_02_01'])).'('.$releaseSD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_02_02'])).'('.$releaseED.')'?></div>
                </li>
                <? if($out_row['hero_today_02_02']!=$out_row['hero_today_03_02']){ ?>
                    <li>
                        <div class="<?=$date_color_03?> tit">콘텐츠 등록</div>
                        <div class="<?=$date_color_03?> cont"><?=date('m.d',strtotime($out_row['hero_today_03_01'])).'('.$reviewSD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_03_02'])).'('.$reviewED.')'?></div>
                    </li>
                    <? if($out_row['hero_today_04_01'] !=  "0000-00-00 00:00:00" && $out_row['hero_today_04_02'] != "0000-00-00 00:00:00") {?>
                        <li>
                            <div class="<?=$date_color_04?> tit">우수콘텐츠 발표</div>
                            <div class="<?=$date_color_04?> cont"><?=date('m.d',strtotime($out_row['hero_today_04_01'])).'('.$bestSD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_04_02'])).'('.$bestED.')'?></div>
                        </li>
                    <? } ?>
                <? }?>
            </ul>
        </div>
        <? } else {?> 
        <div class="applybox">
            <ul>
                <li>
                    <div class="<?=$date_color_01?> tit">콘텐츠 등록</div>
                    <div class="cont"><?=date('m.d',strtotime($out_row['hero_today_01_01'])).'('.$startD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_01_02'])).'('.$endD.')'?></div>
                </li>
            </ul>                
        </div>
        <? } ?>
    <? }?>
    <!-- 루나체험단/휘슬클럽 (e) -->
    <div class="mission_guide_btn fz32 main_c bold"><img src="/m/img/musign/board/view.png" alt="참여방법 보러가기">체험단 참여방법 보러가기</div>
</div>
   