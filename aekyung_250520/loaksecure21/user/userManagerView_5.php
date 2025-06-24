<form name="searchForm" id="searchForm" method="GET">
    <? 
    unset($_GET["hero_code"]);
    unset($_GET["view"]);
    foreach($_GET as $key=>$val) {?>
    <input type="hidden" name="<?=$key?>" value="<?=$val?>" />
    <? } ?>
</form>


<form name="viewForm" id="viewForm">
<input type="hidden" name="mode" />
<input type="hidden" name="hero_code" value="<?=$view["hero_code"]?>"/>

<div class="tableSection mgt20">
    <h2 class="table_tit">회원 정보</h2>
    <table class="searchBox">
        <colgroup>
            <col width="200px">
            <col width=*>
            <col width="200px">
            <col width=*>
        </colgroup>
        <tbody>
        <tr>
            <th>아이디</th>
            <td><?=$view["hero_id"]?></td>
            <th>서포터즈</th>
            <td><?=$hero_group?></td>
        </tr>
        <tr>
            <th>이름</th>
            <td><?=$view["hero_name"]?></td>
            <th>서포터즈 팀</th>
            <td><?=$hero_board_group?></td>
        </tr>
        <tr>
            <th>닉네임</th>
            <td><?=$view["hero_nick"]?></td>
            <th>휴대폰 번호</th>
            <td>
                <?=$hero_hp[0]?> - <?=$hero_hp[1]?> - <?=$hero_hp[2]?>
            </td>
        </tr>
        </tbody>
    </table>
</div>

<div class="tableSection mgt20 mu_form">
    <h2 class="table_tit">서포터즈 검색</h2>
    <table class="searchBox">
        <colgroup>
            <col width="200px">
            <col width=*>
        </colgroup>
        <tbody>
            <tr>
                <th>등록 기간</th>
                <td>
                    <div class="search_inner">
                        <input type="text" id="sdate" name="startDate" value="<?=$_GET["startDate"]?>" readonly/>
                        <div class="inner_between">~</div>
                        <input type="text" id="edate" name="endDate" value="<?=$_GET["endDate"]?>" readonly/>
                        <div class="add_icon">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.46294 5.86456C1.46294 3.84025 3.10038 2.19922 5.12026 2.19922H12.4349C14.4548 2.19922 16.0922 3.84025 16.0922 5.86456V12.4622C16.0922 14.4865 14.4548 16.1275 12.4349 16.1275H5.12026C3.10038 16.1275 1.46294 14.4865 1.46294 12.4622V5.86456ZM5.12026 3.66536C3.90833 3.66536 2.92587 4.64998 2.92587 5.86456V12.4622C2.92587 13.6768 3.90833 14.6614 5.12026 14.6614H12.4349C13.6468 14.6614 14.6293 13.6768 14.6293 12.4622V5.86456C14.6293 4.64998 13.6468 3.66536 12.4349 3.66536H5.12026Z" fill="white"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.85172 1.46631C6.2557 1.46631 6.58318 1.79451 6.58318 2.19938V4.39858C6.58318 4.80345 6.2557 5.13165 5.85172 5.13165C5.44774 5.13165 5.12025 4.80345 5.12025 4.39858V2.19938C5.12025 1.79451 5.44774 1.46631 5.85172 1.46631Z" fill="white"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.7034 1.46631C12.1074 1.46631 12.4349 1.79451 12.4349 2.19938V4.39858C12.4349 4.80345 12.1074 5.13165 11.7034 5.13165C11.2995 5.13165 10.972 4.80345 10.972 4.39858V2.19938C10.972 1.79451 11.2995 1.46631 11.7034 1.46631Z" fill="white"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.77757 6.59766C9.18155 6.59766 9.50904 6.92586 9.50904 7.33073V8.79686H10.972C11.3759 8.79686 11.7034 9.12507 11.7034 9.52993C11.7034 9.93479 11.3759 10.263 10.972 10.263H9.50904V11.7291C9.50904 12.134 9.18155 12.4622 8.77757 12.4622C8.3736 12.4622 8.04611 12.134 8.04611 11.7291L8.04611 10.263H6.58318C6.1792 10.263 5.85172 9.93479 5.85172 9.52993C5.85172 9.12507 6.1792 8.79686 6.58318 8.79686H8.04611V7.33073C8.04611 6.92586 8.3736 6.59766 8.77757 6.59766Z" fill="white"/>
                            </svg>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th>검색어</th>
                <td>
                    <div class="search_inner"><input type="text" class="search_txt" style="width: 326px;"/></div>
                </td>
            </tr>
            <tr>
                <th>서포터즈 구분</th>
                <td>
                    <div class="search_inner sup">
                        <label class="akContainer">전체
                            <input type="checkbox" <?=($_GET['all'] == 'check' || $_GET['all'] == '') && $hero_group == '' ? 'checked' : ''?> name="all" value="check">
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">베이직 뷰티 & 라이프 클럽
                            <input type="checkbox" <?=strpos($hero_group,'group_04_05') ? 'checked' : ''?> name="hero_group[]" value="group_04_05">
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">프리미어 뷰티 클럽
                            <input type="checkbox" <?=strpos($hero_group,'group_04_06') ? 'checked' : ''?> name="hero_group[]" value="group_04_06">
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">프리미어 라이프 클럽
                            <input type="checkbox" <?=strpos($hero_group,'group_04_28') ? 'checked' : ''?> name="hero_group[]" value="group_04_28">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <th>선정 여부</th>
                <td>
                    <div class="search_inner sup">
                        <label class="akContainer">전체
                            <input type="radio" <?=!$_GET["hero_chk_cont1"] ? "checked" : ""?> name="hero_chk_cont1" value="">
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">선정
                            <input type="radio" <?=$_GET["hero_chk_cont1"] == "1" ? "checked" : ""?> name="hero_chk_cont1" value="1">
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">미선정
                            <input type="radio" <?=($_GET["hero_chk_cont1"]!="1" && strlen($_GET["hero_chk_phone"]) > 0) ? "checked" : ""?> name="hero_chk_cont1" value="2">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="btnContainer mgt20">
        <a href="javascript:;" class="btnAdd3">검색</a>
    </div>
</div>
</form>

<div class="tableSection mgt30">
    <h2 class="table_tit">콘텐츠 검색</h2>
    <p class="table_desc"></p>
    <div class="searchResultBox_container">
        <table class="searchResultBox">
            <colgroup>
                <col width="45px" />
                <col width="150px" />
                <col width="120px" />
                <col width="105px" />
                <col width="60px" />
                <col width="60px" />
                <col width="130px" />
                <col width="75px" />
                <col width="75px" />
            </colgroup>
            <thead>
                <th>
                    <div class="">
                        NO
                    </div>
                </th>
                <th>
                    <div class="">
                        서포터즈 구분
                    </div>
                </th>
                <th>
                    <div class="">
                        체험단명
                    </div>
                </th>
                <th>
                    <div class="">
                        체험단 모집기간
                    </div>
                </th>
                <th>
                    <div class="">
                        진행
                    </div>
                </th>
                <th>
                    <div class="">
                        슈퍼패스 사용 여부
                    </div>
                </th>
                <th>
                    <div class="">
                        선정 여부
                    </div>
                </th>
                <th>
                    <div class="">
                        체험단 신청일
                    </div>
                </th>
                <th>
                    <div class="">
                        배송포인트
                    </div>
                </th>
            </thead>
            <tbody>
            <tr style="cursor:pointer" onClick="fnView('<?=$list["hero_code"]?>')">
                    <td>
                        <div class="table_result_no">
                            <?=number_format($i);?>
                        </div>
                    </td>
                    <td>
                        <div class="table_result_types">
                           1
                        </div>
                    </td>
                    <td>
                        <div class="table_result_nick">
                           1
                        </div>
                    </td>
                    <td>
                        <div class="table_result_name">
                           1
                        </div>
                    </td>
                    <td>
                        <div class="table_result_create">
                            1
                        </div>
                    </td>
                    <td>
                        <div class="table_result_create">
                            1
                        </div>
                    </td>
                    <td>
                        <div class="table_result_create">
                            1
                        </div>
                    </td>
                    <td>
                        <div class="table_result_create">
                            1
                        </div>
                    </td>
                    <td>
                        <div class="table_result_create">
                            1
                        </div>
                    </td>
                </tr>
                <!-- <? 
                if($total_data > 0) {
                while($list = mysql_fetch_assoc($list_res)) { 
                    $age = (date("Y")-substr($list["hero_jumin"],0,4))+1;
                    $hero_sex_txt = "";
                    if($list["hero_sex"] == 1) {
                        $hero_sex_txt = "남";
                    } else if(strlen($list["hero_sex"]) > 0 && $list["hero_sex"] == 0) {
                        $hero_sex_txt = "여";
                    }
                    $hero_blog_00_txt = ""; //네이버
                    if($list["hero_blog_00"]) $hero_blog_00_txt = "블로그";
                    $hero_blog_03_txt = ""; //유튜브
                    if($list["hero_blog_03"]) $hero_blog_03_txt = "숏폼";
                    $hero_blog_04_txt = ""; //인스타
                    if($list["hero_blog_04"]) $hero_blog_04_txt = "인스타";
                    $hero_chk_phone_txt = "미동의";
                    if($list["hero_chk_phone"] == "1") $hero_chk_phone_txt = "동의";
                    $hero_chk_email_txt = "미동의";
                    if($list["hero_chk_email"] == "1") $hero_chk_email_txt = "동의";
                ?>
                <tr style="cursor:pointer" onClick="fnView('<?=$list["hero_code"]?>')">
                    <td>
                        <div class="table_result_no">
                            <?=number_format($i);?>
                        </div>
                    </td>
                    <td>
                        <div class="table_result_types">
                            <?=$list["hero_id"]?>
                        </div>
                    </td>
                    <td>
                        <div class="table_result_nick">
                            <?=$list["hero_nick"]?>
                        </div>
                    </td>
                    <td>
                        <div class="table_result_name">
                            <?=$list["hero_name"]?>
                        </div>
                    </td>
                    <td>
                        <div class="table_result_create">
                            <?=$age?>
                        </div>
                    </td>
                    <td>
                        <div class="table_result_create">
                            <?=$hero_sex_txt?>
                        </div>
                    </td>
                    <td>
                        <div class="table_result_create">
                            <?=number_format($list["hero_point"]);?>
                        </div>
                    </td>
                    <td>
                        <div class="table_result_btn03">
                            <p class="icon_box active">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.83335 3.33317C4.45264 3.33317 3.33335 4.45246 3.33335 5.83317V14.1665C3.33335 15.5472 4.45264 16.6665 5.83335 16.6665H14.1667C15.5474 16.6665 16.6667 15.5472 16.6667 14.1665V10.8332C16.6667 10.3729 17.0398 9.99984 17.5 9.99984C17.9603 9.99984 18.3334 10.3729 18.3334 10.8332V14.1665C18.3334 16.4677 16.4679 18.3332 14.1667 18.3332H5.83335C3.53217 18.3332 1.66669 16.4677 1.66669 14.1665V5.83317C1.66669 3.53198 3.53217 1.6665 5.83335 1.6665H9.16669C9.62692 1.6665 10 2.0396 10 2.49984C10 2.96007 9.62692 3.33317 9.16669 3.33317H5.83335Z" fill="black"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M18.0893 1.91058C18.4147 2.23602 18.4147 2.76366 18.0893 3.08909L10.5893 10.5891C10.2638 10.9145 9.7362 10.9145 9.41076 10.5891C9.08533 10.2637 9.08533 9.73602 9.41076 9.41058L16.9108 1.91058C17.2362 1.58514 17.7638 1.58514 18.0893 1.91058Z" fill="black"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.6667 2.49984C11.6667 2.0396 12.0398 1.6665 12.5 1.6665H17.5C17.9603 1.6665 18.3334 2.0396 18.3334 2.49984V7.49984C18.3334 7.96007 17.9603 8.33317 17.5 8.33317C17.0398 8.33317 16.6667 7.96007 16.6667 7.49984V3.33317H12.5C12.0398 3.33317 11.6667 2.96007 11.6667 2.49984Z" fill="black"/>
                                </svg>
                            </p>
                        </div>
                    </td>
                </tr>
                <?
                --$i;
                }
                } else {?>
                <tr>
                    <td colspan="25" class="no_data">등록된 데이터가 없습니다.</td>
                </tr>
                <? } ?> -->
            </tbody>
        </table>
    </div>
</div>

<!--후기 URL 팝업-->
<div class="popup_url_box">
    <div class="popup_url_cont">
		<div class="popup_url_head">
			<svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M4.41073 4.41083C4.73617 4.08539 5.26381 4.08539 5.58925 4.41083L15.5892 14.4108C15.9147 14.7363 15.9147 15.2639 15.5892 15.5893C15.2638 15.9148 14.7362 15.9148 14.4107 15.5893L4.41073 5.58934C4.0853 5.2639 4.0853 4.73626 4.41073 4.41083Z" fill="black"></path>
				<path fill-rule="evenodd" clip-rule="evenodd" d="M15.5892 4.41083C15.2638 4.08539 14.7362 4.08539 14.4107 4.41083L4.41072 14.4108C4.08529 14.7363 4.08529 15.2639 4.41072 15.5893C4.73616 15.9148 5.2638 15.9148 5.58924 15.5893L15.5892 5.58934C15.9147 5.2639 15.9147 4.73626 15.5892 4.41083Z" fill="black"></path>
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
                    <tbody>
                        <tr>
                            <th><div class="">닉네임</div></th>
                            <td><div class="">dreammaam</div></td>
                        </tr>
                        <tr>
                            <th><div class="">회원 등급</div></th>
                            <td><div class="">프리미어 라이프 클럽</div></td>
                        </tr>
                        <tr>
                            <th><div class="">콘텐츠 타이틀 명</div></th>
                            <td><div class="">세탁과 세탁조 케어를 한번에!!</div></td>
                        </tr>
                        <tr>
                            <th><div class="">콘텐츠 등록일</div></th>
                            <td><div class="">2024-01-18 14:48:47</div></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="popup_url_link">
                <div class="popup_url_link_item">
                    <div class="popup_url_link_top">
                        <div class="popup_url_link_item_img"></div>
                        <p class="popup_url_link_item_tit">인스타그램</p>
                    </div>
                    <div class="popup_url_link_cont active">
                        <input value="https://www.instagram.com/p/C2MQjuWPJ4Y/?igsh=MXYzeHljNmdlbDZmNA==" />
                        <a href="https://www.instagram.com/p/C2MQjuWPJ4Y/?igsh=MXYzeHljNmdlbDZmNA==" target="_blank">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M5.25 3C4.00736 3 3 4.00736 3 5.25V12.75C3 13.9926 4.00736 15 5.25 15H12.75C13.9926 15 15 13.9926 15 12.75V9.75C15 9.33579 15.3358 9 15.75 9C16.1642 9 16.5 9.33579 16.5 9.75V12.75C16.5 14.8211 14.8211 16.5 12.75 16.5H5.25C3.17893 16.5 1.5 14.8211 1.5 12.75V5.25C1.5 3.17893 3.17893 1.5 5.25 1.5H8.25C8.66421 1.5 9 1.83579 9 2.25C9 2.66421 8.66421 3 8.25 3H5.25Z"
                                    fill="black"
                                ></path>
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M16.2803 1.71967C16.5732 2.01256 16.5732 2.48744 16.2803 2.78033L9.53033 9.53033C9.23744 9.82322 8.76256 9.82322 8.46967 9.53033C8.17678 9.23744 8.17678 8.76256 8.46967 8.46967L15.2197 1.71967C15.5126 1.42678 15.9874 1.42678 16.2803 1.71967Z"
                                    fill="black"
                                ></path>
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M10.5 2.25C10.5 1.83579 10.8358 1.5 11.25 1.5H15.75C16.1642 1.5 16.5 1.83579 16.5 2.25V6.75C16.5 7.16421 16.1642 7.5 15.75 7.5C15.3358 7.5 15 7.16421 15 6.75V3H11.25C10.8358 3 10.5 2.66421 10.5 2.25Z"
                                    fill="black"
                                ></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="popup_url_link_item">
                    <div class="popup_url_link_top">
                        <div class="popup_url_link_item_img"></div>
                        <p class="popup_url_link_item_tit">네이버</p>
                    </div>
                    <div class="popup_url_link_cont active">
                        <input value="https://www.instagram.com/p/C2MQjuWPJ4Y/?igsh=MXYzeHljNmdlbDZmNA==" />
                        <a href="https://www.instagram.com/p/C2MQjuWPJ4Y/?igsh=MXYzeHljNmdlbDZmNA==" target="_blank">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M5.25 3C4.00736 3 3 4.00736 3 5.25V12.75C3 13.9926 4.00736 15 5.25 15H12.75C13.9926 15 15 13.9926 15 12.75V9.75C15 9.33579 15.3358 9 15.75 9C16.1642 9 16.5 9.33579 16.5 9.75V12.75C16.5 14.8211 14.8211 16.5 12.75 16.5H5.25C3.17893 16.5 1.5 14.8211 1.5 12.75V5.25C1.5 3.17893 3.17893 1.5 5.25 1.5H8.25C8.66421 1.5 9 1.83579 9 2.25C9 2.66421 8.66421 3 8.25 3H5.25Z"
                                    fill="black"
                                ></path>
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M16.2803 1.71967C16.5732 2.01256 16.5732 2.48744 16.2803 2.78033L9.53033 9.53033C9.23744 9.82322 8.76256 9.82322 8.46967 9.53033C8.17678 9.23744 8.17678 8.76256 8.46967 8.46967L15.2197 1.71967C15.5126 1.42678 15.9874 1.42678 16.2803 1.71967Z"
                                    fill="black"
                                ></path>
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M10.5 2.25C10.5 1.83579 10.8358 1.5 11.25 1.5H15.75C16.1642 1.5 16.5 1.83579 16.5 2.25V6.75C16.5 7.16421 16.1642 7.5 15.75 7.5C15.3358 7.5 15 7.16421 15 6.75V3H11.25C10.8358 3 10.5 2.66421 10.5 2.25Z"
                                    fill="black"
                                ></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>

<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/anytime.5.1.2.css">
<script src="<?=ADMIN_DEFAULT?>/js/anytime.5.1.2.js"></script>

<script>
$(document).ready(function(){
	$("#hero_hp_check").on("click",function(){
		if($(this).is(":checked")) {
			$(".input_hero_hp").attr("readOnly",false);
		} else {
			$(".input_hero_hp").attr("readOnly",true);
		}
	})
	
	$("#hero_mail_check").on("click",function(){
		if($(this).is(":checked")) {
			$(".input_hero_mail").attr("readOnly",false);
		} else {
			$(".input_hero_mail").attr("readOnly",true);
		}
	})

    //날짜 데이터포맷
    $(function(){
        jQuery("#sdate, #startdate").AnyTime_picker( {
            format: "%Y-%m-%d %H:%i:00"
        });

        jQuery("#edate, #enddate").AnyTime_picker( {
            format: "%Y-%m-%d %H:%i:00"
        });
    });

});


</script>

