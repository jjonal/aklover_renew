<!--모서리 팝업 관리 겹쳐서 팝업-->
<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/anytime.5.1.2.css">
<script src="<?=ADMIN_DEFAULT?>/js/anytime.5.1.2.js"></script>
<?
$table = 'monthak';

if(!strcmp($_GET['type'], 'edit')){ //순서 저장
    unset($_POST['chk_hero_idx']);

    $post_count = count($_POST['hero_idx']);

    for($i=0;$i<$post_count;$i++){
        reset($_POST);
        unset($sql_one_update);
        unset($sql_one);
        unset($sql_two);

        $j=0;
        foreach($_POST as $post_key=>$post_val){
            if($post_key=='hero_idx'){
                $idx = $_POST[$post_key][$i];
                continue;
            }
            if($j==0)	$comma = '';
            else		$comma = ',';

            //노출 순서
            if ($post_key=='hero_order' && empty($_POST[$post_key][$i]) == 1) $_POST[$post_key][$i] = ($i+1);

            //update
            if($idx!=0){
                $sql_one_update .= $comma.$post_key."='".$_POST[$post_key][$i]."'";

                $sql = "UPDATE ".$table." SET ".$sql_one_update." WHERE hero_idx = '".$idx."';";
            }
            //insert
            else{
                $sql_one .= $comma.$post_key;
                $sql_two .= $comma."'".$_POST[$post_key][$i]."'";

                $sql = "insert into ".$table." (".$sql_one.") values (".$sql_two.");";
            }
            $j++;
        }
//        echo $sql.'<br>';
        mysql_query($sql);
    }

    msg('설정 되었습니다.','location.href="'.PATH_HOME.'?'.get('type','').'"');
    exit;
}else if(!strcmp($_GET['type'], 'edit2')){ //관리명, 노출기간 수정
    $sql  = " UPDATE monthak_manager ";
    $sql .= " SET hero_title = '".$_POST['hero_title']."', ";
    $sql .= " startdate = '".$_POST['startdate']."', ";
    $sql .= " enddate = '".$_POST['enddate']."' ";
    $sql .= " WHERE hero_idx = '".$_POST['hero_old_idx']."'";

    sql($sql);
    msg('수정 되었습니다.','location.href="'.PATH_HOME.'?'.get('type','').'"');
    exit;
}
else if(!strcmp($_GET['type'], 'drop')){
    for($i=0;$i<count($_POST['chk_hero_idx']);$i++){
        $sql = "UPDATE monthak SET hero_use = '1' WHERE hero_idx = '".$_POST['chk_hero_idx'][$i]."'";
        sql($sql);
    }

    msg('삭제 되었습니다.','location.href="'.PATH_HOME.'?'.get('type||hero_idx','').'"');
    exit;
}

$sql = "SELECT * FROM monthak_manager WHERE hero_idx = '".$_GET['hero_old_idx']."'";
sql($sql);
$row = @mysql_fetch_assoc($out_sql)
?>
<div class="list_modi_box">
	<div class="tit">
		<p>
			이달의 AK Lover 관리명
		</p>
		<p>
			노출기간
		</p>
	</div>
	<div class="cont">
		<p>
			<?=$row['hero_title']?>
		</p>
		<p>
            <?=$row['startdate']?> ~ <?=$row['enddate']?>
		</p>
	</div>
	<div class="list_modi_btn">수정</div>
</div>

<div class="searchCnt">
	<div class="searchCnt_func_box">
		<div class="up_down btn_list">
			<h4>노출 순서 설정 : </h4>
            <button class="btn_front">
                <svg width="41" height="41" viewBox="0 0 41 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g opacity="0.5">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.41675 11.9582C3.41675 7.24074 7.24098 3.4165 11.9584 3.4165H29.0417C33.7592 3.4165 37.5834 7.24074 37.5834 11.9582V29.0415C37.5834 33.7589 33.7592 37.5832 29.0417 37.5832H11.9584C7.24098 37.5832 3.41675 33.7589 3.41675 29.0415V11.9582ZM11.9584 6.83317C9.12796 6.83317 6.83341 9.12771 6.83341 11.9582V29.0415C6.83341 31.872 9.12796 34.1665 11.9584 34.1665H29.0417C31.8722 34.1665 34.1667 31.872 34.1667 29.0415V11.9582C34.1667 9.12771 31.8722 6.83317 29.0417 6.83317H11.9584Z" fill="black"/>
                    </g>
                    <g opacity="0.5">
                        <path d="M16.3052 19.6031L20.2978 12.6877L24.2904 19.6031L16.3052 19.6031Z" fill="#030303"/>
                        <path d="M16.3052 26.6031L20.2978 19.6877L24.2904 26.6031L16.3052 26.6031Z" fill="#030303"/>
                    </g>
                </svg>
            </button>
            <button class="btn_prev">
                <svg width="41" height="41" viewBox="0 0 41 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g opacity="0.5">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.41675 11.9582C3.41675 7.24074 7.24098 3.4165 11.9584 3.4165H29.0417C33.7592 3.4165 37.5834 7.24074 37.5834 11.9582V29.0415C37.5834 33.7589 33.7592 37.5832 29.0417 37.5832H11.9584C7.24098 37.5832 3.41675 33.7589 3.41675 29.0415V11.9582ZM11.9584 6.83317C9.12796 6.83317 6.83341 9.12771 6.83341 11.9582V29.0415C6.83341 31.872 9.12796 34.1665 11.9584 34.1665H29.0417C31.8722 34.1665 34.1667 31.872 34.1667 29.0415V11.9582C34.1667 9.12771 31.8722 6.83317 29.0417 6.83317H11.9584Z" fill="black"/>
                    </g>
                    <path opacity="0.5" d="M14.8711 25.1296L20.5003 15.3796L26.1294 25.1296L14.8711 25.1296Z" fill="#030303"/>
                </svg>
            </button>
            <button class="btn_next">
                <svg width="41" height="41" viewBox="0 0 41 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g opacity="0.5">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.4165 11.9582C3.4165 7.24074 7.24074 3.4165 11.9582 3.4165H29.0415C33.7589 3.4165 37.5832 7.24074 37.5832 11.9582V29.0415C37.5832 33.7589 33.7589 37.5832 29.0415 37.5832H11.9582C7.24074 37.5832 3.4165 33.7589 3.4165 29.0415V11.9582ZM11.9582 6.83317C9.12771 6.83317 6.83317 9.12771 6.83317 11.9582V29.0415C6.83317 31.872 9.12771 34.1665 11.9582 34.1665H29.0415C31.872 34.1665 34.1665 31.872 34.1665 29.0415V11.9582C34.1665 9.12771 31.872 6.83317 29.0415 6.83317H11.9582Z" fill="black"/>
                    </g>
                    <path opacity="0.5" d="M20.5 26L14.8708 16.25L26.1292 16.25L20.5 26Z" fill="#030303"/>
                </svg>
            </button>
            <button class="btn_back">
                <svg width="41" height="41" viewBox="0 0 41 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g opacity="0.5">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.4165 11.9582C3.4165 7.24074 7.24074 3.4165 11.9582 3.4165H29.0415C33.7589 3.4165 37.5832 7.24074 37.5832 11.9582V29.0415C37.5832 33.7589 33.7589 37.5832 29.0415 37.5832H11.9582C7.24074 37.5832 3.4165 33.7589 3.4165 29.0415V11.9582ZM11.9582 6.83317C9.12771 6.83317 6.83317 9.12771 6.83317 11.9582V29.0415C6.83317 31.872 9.12771 34.1665 11.9582 34.1665H29.0415C31.872 34.1665 34.1665 31.872 34.1665 29.0415V11.9582C34.1665 9.12771 31.872 6.83317 29.0415 6.83317H11.9582Z" fill="black"/>
                    </g>
                    <g opacity="0.5">
                        <path d="M24.2905 21.9926L20.2979 28.908L16.3053 21.9926L24.2905 21.9926Z" fill="#030303"/>
                        <path d="M24.2905 14.9926L20.2979 21.908L16.3053 14.9926L24.2905 14.9926Z" fill="#030303"/>
                    </g>
			    </svg>
            </button>
		</div>
		<div class="select_ignore">
			<h4>선택한 선정자 제외 :</h4>
            <div class="select_ignore_btn" onclick="javascript:fnExec();">선택 삭제</div>
		</div>
	</div>
</div>

<div id="layer" style="text-align:center; position:absolute; display:none; margin:0; padding:0; z-index:1;border:solid 5px red"></div>
<div class="apply_btn others" onClick="goEdit();">
    저장
</div>

<form id="form_next" name="form_next" action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post" enctype="multipart/form-data">
<div class="form_container">
    <div class="searchResultBox_BtnGroup">
        <a href="<?=PATH_HOME.'?board='.$_GET['board'].'&idx='.$_GET['idx'].'&hero_old_idx='.$_GET['hero_old_idx'].'&view=bestReviewHistoryViewAdd'?>" class="btnAdd">선정자 추가하기</a>
        <a class="btnAdd" onClick="fnExcel();">선정자 목록 다운로드</a>
    </div>
    <table class="searchResultBox">
        <colgroup>
            <col width="45px" />
            <col width="45px" />
            <col width="158px" />
            <col width="105px" />
            <col width="250px" />
            <col width="216px" />
            <col width="112px" />
            <col width="75px" />
            <col width="89px" />
        </colgroup>
        <thead>
            <tr>
                <th>
                    <div class="">
                        <label class="akContainer">
                            <input type="checkbox" name="all">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </th>
                <th>
                    <div class="">
                        NO
                    </div>
                </th>
                <th>
                    <div class="">
                        회원 구분
                    </div>
                </th>
                <th>
                    <div class="">
                        <p>
                            닉네임
                        </p>
                    </div>
                </th>
                <th>
                    <div class="">
                        <p>
                            콘텐츠 타이틀명
                        </p>
                    </div>
                </th>
                <th>
                    <div class="">
                        <p>
                            체험단명
                        </p>
                    </div>
                </th>
                <th>
                    <div class="">
                        <p>
                            콘텐츠 등록일
                        </p>
                    </div>
                </th>
                <th>
                    <div class="">
                            우수 콘텐츠
                    </div>
                </th>
                <th>
                    <div class="">
                        준우수 콘텐츠
                    </div>
                </th>
            </tr>
        </thead>
        <tbody class="list">
        <?
            //리스트
            $sql  = " SELECT a.hero_idx, a.board_hero_idx, d.hero_level, d.hero_nick, c.hero_title AS review_title,";
            $sql .= " e.hero_title AS mission_title, c.hero_today, a.hero_order, ";
            $sql .= " IF(IFNULL(c.hero_board_three,0) = '1','Y','N') AS best, IF(IFNULL(c.hero_board_three,0) = '2','Y','N') AS semi_best ";
            $sql .= " FROM monthak a ";
            $sql .= " JOIN monthak_manager b ON b.hero_idx = a.hero_old_idx ";
            $sql .= " JOIN board c ON c.hero_idx = a.board_hero_idx ";
            $sql .= " JOIN member d ON d.hero_code = c.hero_code ";
            $sql .= " JOIN mission e ON e.hero_idx = c.hero_01 ";
            $sql .= " WHERE hero_old_idx = '".$_GET['hero_old_idx']."' ";
            $sql .= " AND a.hero_use = '0'";
            $sql .= " ORDER BY a.hero_order";
            sql($sql);
    
            $i = '0';
            while($list                             = @mysql_fetch_assoc($out_sql)){
                //회원등급
                if($list['hero_level'] == '9994'){
                    $member_grade = '프리미어 라이프 클럽';
                }else if($list['hero_level'] == '9996'){
                    $member_grade = '프리미어 뷰티 클럽';
                }else {
                    $member_grade = '베이직 뷰티&라이프 클럽';
                }
                //우수 콘텐츠
                if($list['best'] == 'Y'){
                    $best = '선정';
                }else {
                    $best = '미선정';
                }
                //준우수 콘텐츠
                if($list['semi_best'] == 'Y'){
                    $semi_best = '선정';
                }else {
                    $semi_best = '미선정';
                }

            ######################################################################################################################################################
            ?>
                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'" class="item">
                    <input type="hidden" name="hero_idx[]" value="<?=$list['hero_idx']?>">
                    <input type="hidden" name="hero_order[]">
                    <td class="order-item">
                        <div class="table_checkbox" style="position:relative">
                            <label class="akContainer">
                                <input type="checkbox"  name="chk_hero_idx[]" value="<?=$list['hero_idx']?>" >
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="table_result_no">
                            <!--NO-->
                            <?=$i+1?>
                        </div>
                    </td>
                    <td>
                        <div class="table_result_types">
                            <?=$member_grade?> <!--회원등급-->
                        </div>
                    </td>
                    <td>
                        <div class="table_result_nick">
                            <?=$list['hero_nick']?> <!--닉네임-->
                        </div>
                    </td>
                    <td>
                        <div class="table_result_tit">
                            <?=$list['review_title']?> <!--콘텐츠 타이틀명-->
                        </div>
                    </td>
                    <td>
                        <div class="table_result_name">
                            <?=$list['mission_title']?> <!--체험단명-->
                        </div>
                    </td>
                    <td>
                        <div class="table_result_create">
                            <?=$list['hero_today']?> <!--콘텐츠 등록일-->
                        </div>
                    </td>
                    <td>
                        <div class="table_result_btn01">
                            <div class="table_result_btn_yn <?=$best == '선정' ? 'active' : ''?>">
                                <?=$best?> <!--우수 콘텐츠-->
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="table_result_btn02">
                            <div class="table_result_btn_yn <?=$semi_best == '선정' ? 'active' : ''?>">
                                <?=$semi_best?> <!--준우수 콘텐츠-->
                            </div>
                        </div>
                    </td>
                </tr>
                <?
                $i++;
            }
            ?>
        </tbody>
    </table>
    </form>
</div>

<div class="popup_url_box">
	<div class="popup_url_cont">
		<div class="popup_url_head">
			<svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M4.41073 4.41083C4.73617 4.08539 5.26381 4.08539 5.58925 4.41083L15.5892 14.4108C15.9147 14.7363 15.9147 15.2639 15.5892 15.5893C15.2638 15.9148 14.7362 15.9148 14.4107 15.5893L4.41073 5.58934C4.0853 5.2639 4.0853 4.73626 4.41073 4.41083Z" fill="black"/>
				<path fill-rule="evenodd" clip-rule="evenodd" d="M15.5892 4.41083C15.2638 4.08539 14.7362 4.08539 14.4107 4.41083L4.41072 14.4108C4.08529 14.7363 4.08529 15.2639 4.41072 15.5893C4.73616 15.9148 5.2638 15.9148 5.58924 15.5893L15.5892 5.58934C15.9147 5.2639 15.9147 4.73626 15.5892 4.41083Z" fill="black"/>
			</svg>
		</div>
		<div class="popup_url_body">
			<div class="tit">후기 URL 확인</div>
			<div class="popup_url_table">
				<table>
					<colgroup>
						<col width="144px" />
						<col width="*" />
					</colgroup>
					<tr>
						<th>
							<div class="">날짜 검색</div>
						</th>
						<td>
							<div class="">베스트리뷰뮤자인</div>
						</td>
					</tr>
					<tr>
						<th>
							<div class="">검색어</div>
						</th>
						<td>
							<div class="">베이직 뷰티&라이프 클럽</div>
						</td>
					</tr>
					<tr>
						<th>
							<div class="">서포터즈 구분</div>
						</th>
						<td>
							<div class="">새로운 제품을 사용해 봤어요...</div>
						</td>
					</tr>
					<tr>
						<th>
							<div class="">우수 콘텐츠</div>
						</th>
						<td>
							<div class="">2024-07-17 11:12:44</div>
						</td>
					</tr>
				</table>
			</div>
			<div class="popup_url_link">
				<div class="popup_url_link_item">
					<div class="popup_url_link_top">
						<div class="popup_url_link_item_img"></div>
						<p class="popup_url_link_item_tit">네이버 블로그</p>
					</div>
					<div class="popup_url_link_cont active">
						<input/>
						<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M5.25 3C4.00736 3 3 4.00736 3 5.25V12.75C3 13.9926 4.00736 15 5.25 15H12.75C13.9926 15 15 13.9926 15 12.75V9.75C15 9.33579 15.3358 9 15.75 9C16.1642 9 16.5 9.33579 16.5 9.75V12.75C16.5 14.8211 14.8211 16.5 12.75 16.5H5.25C3.17893 16.5 1.5 14.8211 1.5 12.75V5.25C1.5 3.17893 3.17893 1.5 5.25 1.5H8.25C8.66421 1.5 9 1.83579 9 2.25C9 2.66421 8.66421 3 8.25 3H5.25Z" fill="black"/>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M16.2803 1.71967C16.5732 2.01256 16.5732 2.48744 16.2803 2.78033L9.53033 9.53033C9.23744 9.82322 8.76256 9.82322 8.46967 9.53033C8.17678 9.23744 8.17678 8.76256 8.46967 8.46967L15.2197 1.71967C15.5126 1.42678 15.9874 1.42678 16.2803 1.71967Z" fill="black"/>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 2.25C10.5 1.83579 10.8358 1.5 11.25 1.5H15.75C16.1642 1.5 16.5 1.83579 16.5 2.25V6.75C16.5 7.16421 16.1642 7.5 15.75 7.5C15.3358 7.5 15 7.16421 15 6.75V3H11.25C10.8358 3 10.5 2.66421 10.5 2.25Z" fill="black"/>
						</svg>
					</div>
				</div>
				<div class="popup_url_link_item">
					<div class="popup_url_link_top">
						<div class="popup_url_link_item_img"></div>
						<p class="popup_url_link_item_tit">인스타그램</p>
					</div>
					<div class="popup_url_link_cont">
						<input/>
						<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M5.25 3C4.00736 3 3 4.00736 3 5.25V12.75C3 13.9926 4.00736 15 5.25 15H12.75C13.9926 15 15 13.9926 15 12.75V9.75C15 9.33579 15.3358 9 15.75 9C16.1642 9 16.5 9.33579 16.5 9.75V12.75C16.5 14.8211 14.8211 16.5 12.75 16.5H5.25C3.17893 16.5 1.5 14.8211 1.5 12.75V5.25C1.5 3.17893 3.17893 1.5 5.25 1.5H8.25C8.66421 1.5 9 1.83579 9 2.25C9 2.66421 8.66421 3 8.25 3H5.25Z" fill="black"/>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M16.2803 1.71967C16.5732 2.01256 16.5732 2.48744 16.2803 2.78033L9.53033 9.53033C9.23744 9.82322 8.76256 9.82322 8.46967 9.53033C8.17678 9.23744 8.17678 8.76256 8.46967 8.46967L15.2197 1.71967C15.5126 1.42678 15.9874 1.42678 16.2803 1.71967Z" fill="black"/>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 2.25C10.5 1.83579 10.8358 1.5 11.25 1.5H15.75C16.1642 1.5 16.5 1.83579 16.5 2.25V6.75C16.5 7.16421 16.1642 7.5 15.75 7.5C15.3358 7.5 15 7.16421 15 6.75V3H11.25C10.8358 3 10.5 2.66421 10.5 2.25Z" fill="black"/>
						</svg>
					</div>
				</div>
				<div class="popup_url_link_item">
					<div class="popup_url_link_top">
						<div class="popup_url_link_item_img"></div>
						<p class="popup_url_link_item_tit">기타</p>
					</div>
					<div class="popup_url_link_cont">
						<input/>
						<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M5.25 3C4.00736 3 3 4.00736 3 5.25V12.75C3 13.9926 4.00736 15 5.25 15H12.75C13.9926 15 15 13.9926 15 12.75V9.75C15 9.33579 15.3358 9 15.75 9C16.1642 9 16.5 9.33579 16.5 9.75V12.75C16.5 14.8211 14.8211 16.5 12.75 16.5H5.25C3.17893 16.5 1.5 14.8211 1.5 12.75V5.25C1.5 3.17893 3.17893 1.5 5.25 1.5H8.25C8.66421 1.5 9 1.83579 9 2.25C9 2.66421 8.66421 3 8.25 3H5.25Z" fill="black"/>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M16.2803 1.71967C16.5732 2.01256 16.5732 2.48744 16.2803 2.78033L9.53033 9.53033C9.23744 9.82322 8.76256 9.82322 8.46967 9.53033C8.17678 9.23744 8.17678 8.76256 8.46967 8.46967L15.2197 1.71967C15.5126 1.42678 15.9874 1.42678 16.2803 1.71967Z" fill="black"/>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 2.25C10.5 1.83579 10.8358 1.5 11.25 1.5H15.75C16.1642 1.5 16.5 1.83579 16.5 2.25V6.75C16.5 7.16421 16.1642 7.5 15.75 7.5C15.3358 7.5 15 7.16421 15 6.75V3H11.25C10.8358 3 10.5 2.66421 10.5 2.25Z" fill="black"/>
						</svg>
					</div>
				</div>
				<div class="popup_url_link_item">
					<div class="popup_url_link_top">
						<div class="popup_url_link_item_img"></div>
						<p class="popup_url_link_item_tit">네이버 블로그</p>
					</div>
					<div class="popup_url_link_cont">
						<input/>
						<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M5.25 3C4.00736 3 3 4.00736 3 5.25V12.75C3 13.9926 4.00736 15 5.25 15H12.75C13.9926 15 15 13.9926 15 12.75V9.75C15 9.33579 15.3358 9 15.75 9C16.1642 9 16.5 9.33579 16.5 9.75V12.75C16.5 14.8211 14.8211 16.5 12.75 16.5H5.25C3.17893 16.5 1.5 14.8211 1.5 12.75V5.25C1.5 3.17893 3.17893 1.5 5.25 1.5H8.25C8.66421 1.5 9 1.83579 9 2.25C9 2.66421 8.66421 3 8.25 3H5.25Z" fill="black"/>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M16.2803 1.71967C16.5732 2.01256 16.5732 2.48744 16.2803 2.78033L9.53033 9.53033C9.23744 9.82322 8.76256 9.82322 8.46967 9.53033C8.17678 9.23744 8.17678 8.76256 8.46967 8.46967L15.2197 1.71967C15.5126 1.42678 15.9874 1.42678 16.2803 1.71967Z" fill="black"/>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 2.25C10.5 1.83579 10.8358 1.5 11.25 1.5H15.75C16.1642 1.5 16.5 1.83579 16.5 2.25V6.75C16.5 7.16421 16.1642 7.5 15.75 7.5C15.3358 7.5 15 7.16421 15 6.75V3H11.25C10.8358 3 10.5 2.66421 10.5 2.25Z" fill="black"/>
						</svg>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<!--저장 팝업-->
<form name="manageForm" id="manageForm" action="<?=PATH_HOME.'?'.get('','type=edit2');?>" method="post">
    <input type="hidden" id="hero_old_idx" name="hero_old_idx" value="<?=$_GET['hero_old_idx']?>" />
    <input type="hidden" name="type" id="type" value="" />
    <div class="popup_apply_box">
        <div class="popup_apply_cont">
            <div class="popup_apply_head">
                <svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.41073 4.41083C4.73617 4.08539 5.26381 4.08539 5.58925 4.41083L15.5892 14.4108C15.9147 14.7363 15.9147 15.2639 15.5892 15.5893C15.2638 15.9148 14.7362 15.9148 14.4107 15.5893L4.41073 5.58934C4.0853 5.2639 4.0853 4.73626 4.41073 4.41083Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5892 4.41083C15.2638 4.08539 14.7362 4.08539 14.4107 4.41083L4.41072 14.4108C4.08529 14.7363 4.08529 15.2639 4.41072 15.5893C4.73616 15.9148 5.2638 15.9148 5.58924 15.5893L15.5892 5.58934C15.9147 5.2639 15.9147 4.73626 15.5892 4.41083Z" fill="black"/>
                </svg>
            </div>
            <div class="popup_apply_body">
                <div class="tit">이달의 AK Lover 설정</div>
                <div class="popup_apply_item">
                    <div class="popup_apply_item_top">
                        <p>이달의 AK Lover 관리명</p>
                        <input type="text" id="hero_title" name="hero_title" value="<?=$row['hero_title']?>"/>
                        <span>* 해당 관리명은 사용자 화면에 노출되지 않습니다.</span>
                    </div>
                </div>
                <div class="popup_apply_item date">
                    <div class="popup_apply_item_top">
                        <p>이달의 AK Lover 노출기간 설정</p>
                        <div class="date_input">
                            <input type="text" id="startdate" name="startdate" value="<?=$row['startdate']?>"/>
                            ~
                            <input type="text" id="enddate" name="enddate" value="<?=$row['enddate']?>"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup_apply_btn_box">
                <div class="popup_apply_btn" onClick="goEdit2();">
                    이달의 AK Lover 등록 하기
                </div>
            </div>
        </div>
    </div>
</form>

<!--달력을 위한 css, js-->
<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/anytime.5.1.2.css">
<script src="<?=ADMIN_DEFAULT?>/js/anytime.5.1.2.js"></script>
<script>
    $(document).ready(function(){
        //저장버튼(순서 저장)
        goEdit = function() {
            $("#form_next").submit();
        }
        
        //수정버튼(관리명, 노출기간 수정)
        goEdit2 = function() {
            $("#type").val("edit2");
            $("#manageForm").submit();
        }

        //날짜 데이터포맷
        $(function(){
            jQuery("#startdate").AnyTime_picker( {
                format: "%Y-%m-%d %H:%i:00"
            });

            jQuery("#enddate").AnyTime_picker( {
                format: "%Y-%m-%d %H:%i:00"
            });
        });
    })
    fnExec = function() {
        var confirm_txt = "삭제?";

        if(confirm(confirm_txt)) {
            $("#form_next").attr("action",'<?=PATH_HOME.'?'.get('','type=drop');?>');
            $("#form_next").submit();
        }
    }

    fnExcel = function() {
        let board_hero_idx = "";

        $('input:checkbox[name="chk_hero_idx[]"]:checked').each(function () {
            board_hero_idx +=  $(this).val() + "|";
        });

        if(board_hero_idx == ""){
            alert("체크 선택하샘");
            return;
        }

        window.open('nail/download_member.php?a=b&hero_idx='+board_hero_idx);
    }

    // 노출 순서 설정 로직인거같음
    // 팝업 추가 시 아이템 리스트 재할당
    let itemInputAll = document.querySelectorAll(".item .order-item input");

    // 리스트 요소 위치 이동 기능 구현
    let itemAll = document.querySelectorAll(".item");
    let listContainer = document.querySelector(".list");
    let moveElement = new Set(); // 여기에 이동시킬 요소를 담는다.
    let itemElement = [];

    // 체크 박스 초기화
    function clearCheckbox(){
        const isCheckedBox = document.querySelectorAll(".item .order-item input");

        isCheckedBox.forEach(item => {
            item.checked = false;
        });
    }

    function resetFunc() {
        itemElement = [];
        moveElement = new Set();
        clearCheckbox();
        itemInputAll = document.querySelectorAll(".item .order-item input");
    };

    // 최상단 이동
    function movePosition1() {
        itemElement.forEach((item, _) => {
            listContainer.prepend(item.parentNode.parentNode.parentNode.parentNode);
        });

        resetFunc(); // 초기화
    }

    // 앞으로 이동
    function movePosition2() {
        const children = Array.from(listContainer.children);
        itemElement.forEach(item => {
            const itemIndex = children.indexOf(item.parentNode.parentNode.parentNode.parentNode);
            const newIndex = itemIndex - 1 < 0 ? 0 : itemIndex - 1;
            listContainer.insertBefore(item.parentNode.parentNode.parentNode.parentNode, listContainer.children[newIndex]);
        });
        resetFunc(); // 초기화
    };

    // 뒤로 이동
    function movePosition3() {
        itemElement.forEach(item => {
            const children = Array.from(listContainer.children);
            const itemIndex = children.indexOf(item.parentNode.parentNode.parentNode.parentNode);

            if (itemIndex === -1) return;
            const newIndex = Math.min(itemIndex + 1, children.length - 1);
            if (newIndex < children.length) {
                listContainer.insertBefore(item.parentNode.parentNode.parentNode.parentNode, children[newIndex + 1] || null);
            }

            resetFunc(); // 초기화
        });
    }

    // 최하단 이동
    function movePosition4() {
        itemElement.forEach((item, _) => {
            listContainer.append(item.parentNode.parentNode.parentNode.parentNode);
        });
        resetFunc(); // 초기화
    }

    // moveElement 객체에 checked 데이터 저장
    function saveCheckedItem() {
        itemInputAll.forEach((item, _) => {
            item.addEventListener("change", function () {
                // 현재 item의 최신 인덱스를 계산
                const updatedItemInputAll = Array.from(document.querySelectorAll(".item .order-item input"));
                const idx = updatedItemInputAll.indexOf(item);
                if (item.checked) {
                    const element = { idx, item };
                    moveElement.add(element);
                } else {
                    moveElement.forEach(ele => {
                        if (ele.idx === idx) {
                            moveElement.delete(ele);
                        }
                    });
                }
            })
        });
    };

    saveCheckedItem();

    // 버튼 리스트
    const btnList = document.querySelectorAll(".btn_list > button");
    const movePositions = [movePosition1, movePosition2, movePosition3, movePosition4];

    function ascending() {
        const ascArr = Array.from(moveElement).sort((a, b) =>  a.idx - b.idx ).map(el => el.item);
        itemElement = ascArr;
        return ascArr;
    }

    function descending() {
        const desArr = Array.from(moveElement).sort((a, b) =>  b.idx - a.idx ).map(el => el.item);
        itemElement = desArr;
        return desArr;
    }

    btnList.forEach((item, idx) => {
        item.addEventListener("click", () => {
            // 순서 변경 버튼 클릭 전, element 순서 정렬
            if(idx === 0 || idx === 2){
                descending();
            } else {
                ascending();
            }

            if(moveElement.size > 0) {
                movePositions[idx]();
            } else {
                alert("체크박스를 선택하세요.")
            }
        });
    })

	// 목록 체크박스 전체선택
	$('.searchResultBox :checkbox').on('change', function(){
		const _$this = $(this);
		if(_$this.get(0).name == "all"){
			if(_$this.prop('checked')){
				_$this.parents('.searchResultBox').each(function(){
					$(this).find(':checkbox').prop('checked', true);
				})
			}
			else{
				_$this.parents('.searchResultBox').each(function(){
					$(this).find(':checkbox').prop('checked', false);
				})
			}
		}
		else{
			_$this.parents('.searchResultBox').each(function(){
				const _all = $(this).find(':checkbox[name="all"]');
				const _chk = $(this).find(':checkbox').not(':checkbox[name="all"]');
				if(_chk.length == _chk.filter(':checked').length){
					_all.prop('checked', true);
				}
				else{
					_all.prop('checked', false);
				}
			})
		}
	})

	// 정렬 클릭
	$('.searchResultBox th div p').on('click', function(){
		if($(this).hasClass('sort')){
			return $(this).removeClass('sort');
		}
		$(this).addClass('sort');
		$('.searchResultBox th div p').not($(this)).removeClass('sort');
	})

	// url 팝업
	$('.table_result_btn03').on('click', function(){
		$('.popup_url_box').addClass('show');
	})
	// url 팝업 닫기
	$('.popup_url_head .close').on('click', function(){
		$('.popup_url_box').removeClass('show');
	})

    // 저장 팝업
    $('.list_modi_btn').on('click', function(){
        $('.popup_apply_box').addClass('show');
    })
    // 저장 팝업 닫기
    $('.popup_apply_head .close').on('click', function(){
        $('.popup_apply_box').removeClass('show');
    })
    // 저장 팝업 confirm
    $('.popup_apply_btn').on('click', function(){
        $('.popup_apply_box').removeClass('show');
    })
</script>