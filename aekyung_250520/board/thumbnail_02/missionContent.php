<?
//�Խ��� Ÿ��
//ü���, ��ƼŬ��, �ֽ�Ŭ��, ���ڴ�
	$board_type = "1";
	if($_GET['board'] == 'group_04_05' && $mission_board_type){ //ü��� && �ҹ�����
		$board_type = "1";
	} else if($_GET['board'] == 'group_04_05'){ //ü���
		$board_type = "2";
	} else {
		$board_type = "3";
	}
	//20170512 ü��� �϶��� ��÷�� ���ǿ� ���� �Ǹ޴� ����
	if($board_type != "3") {
		$sql_winner = "select lot_01 from mission_review where hero_table = '" . $_GET ['board'] . "' and hero_code='" . $_SESSION ['temp_code'] . "' and hero_old_idx='" . $_GET ['idx'] . "'";
		sql ($sql_winner);
		$data_winner = @mysql_fetch_assoc ($out_sql);
	}	
	//��÷����
	$winner_yn = "N";
	if($board_type == "3") {
		if($my_view == $right_list['hero_view'] ||  $_SESSION['temp_id'] == "sr1787" ||  $_SESSION['temp_id'] == "dai42429" || $_SESSION['temp_level'] >= 9999) {
			$winner_yn = "Y";
		} else if($out_row['hero_type'] == "0" && $_GET['board'] == "group_04_27") {
			if($_SESSION['temp_level'] == "9993") $winner_yn = "Y";
		} 
	}else {
		if($data_winner["lot_01"] == "1" || $_SESSION['temp_level'] >= 9999) $winner_yn = "Y";
	}

	if($out_row['hero_command'] == "&lt;br /&gt;") {
				$command = "";	
	} else {
		//���� ��
		$command = htmlspecialchars_decode ( $out_row['hero_command'] );
		$command = str_replace("&#160;","",$command);
		
		//20170512 ü��ܽ�û(ü��ܸ� ����)
		$hero_media = htmlspecialchars_decode ( $out_row['hero_media'] );
		$hero_media = str_replace("&#160;","",$hero_media);
	}
	
?>
<div class="content_guide rel">
<? if($command){ ?>
<div class="spm_img notice_bottom tabBtnArea1">
    <div class="more_view_cont rel">
	    <?=htmlspecialchars_decode($command);?>
    </div>
    <? if($out_row['hero_product_more']) { ?>
    <div class="more_div">
		<a href="<?=$out_row['hero_product_more']?>" class="more_btn fz18 bold" target="_blank">��ǰ���� �� ����</a>
    </div>    
	<? } else { ?>
        <div class="more_btn more_btn_view fz18 bold">������</div>
    <? } ?>
</div> <!-- �̼ǰ��� ���̺��� div�� �� -->
<? } ?>
<!-- ���̵���� �˾� -->
<div id="guideline" class="guide_popup" style="display: none;">
    <div class="inner rel">
        <? $isGuide = $out_row['guide_ori_file'] || $out_row['guide_ori_file2'] || $out_row['guide_ori_file3'] ?>
        <div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="�ݱ�"></div>
        <div <? if( $isGuide ) { ?>class="f_sc" <? } ?>>
             <? if( $isGuide ) { ?>
            <div class="guide_wrap wid50">                
                <p class="fz28 bold pop_tit">���̵���� �ٿ�ε�</p>
                <div class="pop_cont guid_dw">
                    <?
                    //
                    $guide_ori_file  = str_replace('&','��',$out_row['guide_ori_file']);
                    $guide_ori_file2  = str_replace('&','��',$out_row['guide_ori_file2']);
                    $guide_ori_file3  = str_replace('&','��',$out_row['guide_ori_file3']);
                    ?>
                    <? if( $out_row['guide_ori_file'] ) { ?>
                        <a href="/freebest/auth_download.php?hero_idx=<?=$out_row["hero_idx"]?>&type=mission&column=guide1&download=<?=$guide_ori_file?>" class="guide_btn f_c"><img src="/img/front/board/guide_insta.webp" alt="�ν�Ÿ�׷� ���̵����"><p class="f_b fz17 bold"> �ν�Ÿ�׷� ���̵���� �ٿ�ε� <span class="guide_dw_img"></span></p></a>
                    <? } ?>
                    <? if( $out_row['guide_ori_file2'] ) { ?>
                        <a href="/freebest/auth_download.php?hero_idx=<?=$out_row["hero_idx"]?>&type=mission&column=guide2&download=<?=$guide_ori_file2?>" class="guide_btn f_c"><img src="/img/front/board/guide_naver.webp" alt="���̹� ��α� ���̵����"><p class="f_b fz17 bold">  ���̹� ��α� ���̵���� �ٿ�ε� <span class="guide_dw_img"></span></p></a>
                    <? } ?>
                    <? if( $out_row['guide_ori_file3'] ) { ?>
                        <a href="/freebest/auth_download.php?hero_idx=<?=$out_row["hero_idx"]?>&type=mission&column=guide3&download=<?=$guide_ori_file3?>" class="guide_btn f_c"><img src="/img/front/board/guide_youtube.webp" alt="���� ���̵����"><p class="f_b fz17 bold">  ���� ���̵���� �ٿ�ε� <span class="guide_dw_img"></span></p></a>
                    <? } ?>
                </div>
            </div>            
            <? } ?>
            <div class="text_wrap <? if( $isGuide ) { ?>wid50<? } ?>">                
                <p class="fz28 bold pop_tit">������ ���/���� ����</p>            
                <div class="pop_cont">
                    <? if($out_row['hero_banner']){ ?>	
                    <div class="naver_txt">                 
                        <div class="tabBtnArea3">
                            <div class="f_b">
                                <span class="fz18 bold">���̹� ��α� ������ ��� ���� ���</span>
                            </div>
                            <div class="naver_cont">
                                <ul>
                                    <li class="">
                                        <span class="fz16 bold main_c">Step.1 </span>
                                        <div>
                                            <p class="fz16 fw500">������ ����̹��� �ٿ�ޱ� ��ư Ŭ���ϱ�</p>
                                            <a href="/img/front/icon/banner_img_2.png" download class="fz12 fw600 btn_copy">������ ��� �̹��� �ٿ�ޱ� <img src="/img/front/board/copy.webp" alt="��� �ڵ� �����ϱ�"></a>
                                        </div>
                                    </li>
                                    <li class="">
                                        <span class="fz16 bold main_c">Step.2 </span>
                                        <div>
                                            <p class="fz16 fw500">������ ��� ��ũ �����ϱ� ��ư Ŭ���ϱ�</p>
                                            <a data-clipboard-text="https://www.aklover.co.kr/main/index.php" class="fz12 fw600 btn_copy btn_clip_naver">������ ��� ��ũ �����ϱ� <img src="/img/front/board/copy.webp" alt="��� �ڵ� �����ϱ�"></a>
                                        </div>
                                    </li>
                                    <li class="f_s">
                                        <span class="fz16 bold main_c">Step.3 </span>
                                        <div>
                                            <p class="fz16 fw500">��α� �����Ϳ� ��� �̹����� �����ϰ�<br>
                                            ����� ��ũ �ɸ� �Ϸ�!</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>              
                    <? } ?>  
                    <? if($out_row['hero_insta']){ ?>	
                    <div class="insta_txt">                        
                        <div class="tabBtnArea3">
                            <div class="f_b">
                                <span class="fz18 bold">�ν�Ÿ�׷� ������ ���� ����</span>
                            </div>
                        </div>
                        <div class="banner_img fz18 bold"><?=nl2br($out_row['hero_insta'])?></div>      
                        <div class="banner_info">
                            <ul>
                                <li>- �� ������ �ؽ�Ʈ ���� ��ܿ� �ۼ��� �ּ���.</li>
                            </ul>
                        </div>
                    </div>
                    <? } ?>                  
                </div>
            </div>
        </div>
    </div>	
</div>