<?
$sql = "select hero_today_01_01, hero_today_01_02, hero_today_02_01, hero_today_02_02, hero_today_03_01, hero_today_03_02, hero_today_04_01, hero_today_04_02, hero_type from mission ";
$sql .= "where hero_table = '".$_GET['board']."' and hero_idx = '".$_GET['mission_idx']."' ";
sql ( $sql, 'on' );
$missionDate = @mysql_fetch_assoc ( $out_sql ); 

$yoil = array('��','��','ȭ','��','��','��','��');

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
    <!-- �Ϲݹ̼� (s)-->
    <? if($_GET['board'] == 'group_04_05' && $mission_board_type == false){?> 
        <div class="applybox">
            <ul>
                <li> 
                    <div class="<?=$date_color_01?> tit">ü��� ��û</div>
                    <div class="<?=$date_color_01?> cont"><?=date('m.d',strtotime($out_row['hero_today_01_01'])).'('.$startD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_01_02'])).'('.$endD.')'?></div>
                </li>
                <li>
                    <div class="<?=$date_color_02?> tit">������ ��ǥ</div>
                    <div class="<?=$date_color_02?> cont"><?=date('m.d',strtotime($out_row['hero_today_02_01'])).'('.$releaseSD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_02_02'])).'('.$releaseED.')'?></div>
                </li> 
                <? if($out_row['hero_today_02_02']!=$out_row['hero_today_03_02']){ ?>
                        <li>
                            <div class="<?=$date_color_03?> tit">������ ���</div>
                            <div class="<?=$date_color_03?> cont"><?=date('m.d',strtotime($out_row['hero_today_03_01'])).'('.$reviewSD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_03_02'])).'('.$reviewED.')'?></div>
                        </li>
                    <? if($out_row['hero_today_04_01'] !=  "0000-00-00 00:00:00" && $out_row['hero_today_04_02'] != "0000-00-00 00:00:00") {?>
                        <li>
                            <div class="<?=$date_color_04?> tit">��������� ��ǥ</div>
                            <div class="<?=$date_color_04?> cont"><?=date('m.d',strtotime($out_row['hero_today_04_01'])).'('.$bestSD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_04_02'])).'('.$bestED.')'?></div>
                        </li>
                    <? } ?>
                <? }?>     
            </ul>
        </div>           
    <? }?>
    <!-- �Ϲݹ̼� (e) -->
    
    <!-- �Ϲݹ̼� �߿� �ҹ�����(s)-->
    <? if($_GET['board'] == 'group_04_05' && $mission_board_type){ 
            $txt_type_1 = "";
            if($out_row["hero_type"] == "2") {
                $txt_type_1 = "�ҹ�����";
            } else if($out_row["hero_type"] == "10") {
                $txt_type_1 = "ü���";
            }
    ?> 
        <div class="applybox">
            <ul>
                <li>
                    <div class="<?=$date_color_01?> tit"><?=$txt_type_1?> ����</div>
                    <div class="<?=$date_color_01?> cont"><?=date('m.d',strtotime($out_row['hero_today_01_01'])).'('.$startD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_01_02'])).'('.$endD.')'?></div>
                </li>
                <?php if($out_row['hero_today_01_01']!=$out_row['hero_today_04_01']){ ?>                    
                <li>
                    <div class="<?=$date_color_02?> tit">������ �� ����� ��ǥ</div>
                    <div class="<?=$date_color_02?> cont"><?=date('m.d',strtotime($out_row['hero_today_04_01'])).'('.$bestSD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_04_02'])).'('.$bestED.')'?></div>
            
                </li>
            <? }?>   
            </ul>                         
        </div>
    <? }?>
    <!-- �Ϲݹ̼� �߿� �ҹ����� (e) -->
    
    <!-- AK���ڴ� (s)-->
    <? if($_GET['board'] == 'group_04_08'){?> 

        <div class="applybox">
            <ul>
                <li>
                    <div class="<?=$date_color_01?> tit">ü��� ��û</div>
                    <div class="<?=$date_color_01?> cont"><?=date('m.d',strtotime($missionDate['hero_today_01_01'])).'('.$startD.')'.'~ '.date('m.d',strtotime($missionDate['hero_today_01_02'])).'('.$endD.')'?></div>
                </li>            
                <li>
                    <div class="<?=$date_color_02?> tit">������ ��ǥ</div>
                    <div class="<?=$date_color_02?> cont"><?=date('m.d',strtotime($missionDate['hero_today_02_01'])).'('.$releaseSD.')'.'~ '.date('m.d',strtotime($missionDate['hero_today_02_01'])).'('.$releaseED.')'?></div>
                </li>
            </ul>                         
        </div>
    <? }?>
    <!-- AK���ڴ� (e) -->
    
    <!-- ��Ƽ/��Ʃ��/������ (s)-->
    <? if($_GET['board'] == 'group_04_06' || $_GET['board'] == 'group_04_27' || $_GET['board'] == 'group_04_28'){?> 
        <? if($out_row['hero_type'] == "7") {//�����̼� ?>
        <div class="applybox">
            <ul>
                <li>
                    <div class="<?=$date_color_01?> tit">ü��� ��û</div>
                    <div class="<?=$date_color_01?> cont"><?=date('m.d',strtotime($out_row['hero_today_01_01'])).'('.$startD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_01_02'])).'('.$endD.')'?></div>
                </li>
                <li>
                    <div class="<?=$date_color_02?> tit">������ ��ǥ</div>
                    <div class="<?=$date_color_02?> cont"><?=date('m.d',strtotime($out_row['hero_today_02_01'])).'('.$releaseSD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_02_02'])).'('.$releaseED.')'?></div>
                </li>                    
                <? if($out_row['hero_today_02_02']!=$out_row['hero_today_03_02']){ ?>
                    <li>
                        <div class="<?=$date_color_03?> tit">������ ���</div>
                        <div class="<?=$date_color_03?> cont"><?=date('m.d',strtotime($out_row['hero_today_03_01'])).'('.$reviewSD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_03_02'])).'('.$reviewED.')'?></div>
                    </li>
                    <? if($out_row['hero_today_04_01'] !=  "0000-00-00 00:00:00" && $out_row['hero_today_04_02'] != "0000-00-00 00:00:00") {?>
                        <li>
                            <div class="<?=$date_color_04?> tit">��������� ��ǥ</div>
                            <div class="<?=$date_color_04?> cont"><?=date('m.d',strtotime($out_row['hero_today_04_01'])).'('.$bestSD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_04_02'])).'('.$bestED.')'?></div>
                        </li>
                    <? } ?>
                <? }?>
            </ul>
        </div>
        <? } else if($out_row['hero_type'] == "9") {//����̼�(����)?>
        <div class="applybox">
            <ul>
                <li>
                    <div class="<?=$date_color_01?> tit">ü��� ��û</div>
                    <div class="<?=$date_color_01?> cont"><?=date('m.d',strtotime($out_row['hero_today_01_01'])).'('.$startD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_01_02'])).'('.$endD.')'?></div>
                </li>
                <li>
                    <div class="<?=$date_color_02?> tit">������ ��ǥ</div>
                    <div class="<?=$date_color_02?> cont"><?=date('m.d',strtotime($out_row['hero_today_02_01'])).'('.$releaseSD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_02_02'])).'('.$releaseED.')'?></div>
                </li>
                <? if($out_row['hero_today_02_02']!=$out_row['hero_today_03_02']){ ?>
                    <li>
                        <div class="<?=$date_color_03?> tit">������ ���</div>
                        <div class="<?=$date_color_03?> cont"><?=date('m.d',strtotime($out_row['hero_today_03_01'])).'('.$reviewSD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_03_02'])).'('.$reviewED.')'?></div>
                    </li>
                    <? if($out_row['hero_today_04_01'] !=  "0000-00-00 00:00:00" && $out_row['hero_today_04_02'] != "0000-00-00 00:00:00") {?>
                        <li>
                            <div class="<?=$date_color_04?> tit">��������� ��ǥ</div>
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
                    <div class="<?=$date_color_01?> tit">������ ���</div>
                    <div class="cont"><?=date('m.d',strtotime($out_row['hero_today_01_01'])).'('.$startD.')'.' ~ '.date('m.d',strtotime($out_row['hero_today_01_02'])).'('.$endD.')'?></div>
                </li>
            </ul>                
        </div>
        <? } ?>
    <? }?>
    <!-- �糪ü���/�ֽ�Ŭ�� (e) -->
    <div class="mission_guide_btn fz32 main_c bold"><img src="/m/img/musign/board/view.png" alt="������� ��������">ü��� ������� ��������</div>
</div>
   