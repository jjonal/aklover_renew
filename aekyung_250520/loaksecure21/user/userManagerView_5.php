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
                        <input type="text" id="sdate4" name="startDate4" value="<?=$_GET["startDate4"]?>" readonly/>
                        <div class="inner_between">~</div>
                        <input type="text" id="edate4" name="endDate4" value="<?=$_GET["endDate4"]?>" readonly/>
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
                <th>팀 구분</th>
                <td>
                    <div class="search_inner sup">
                        <label class="akContainer">전체
                            <input type="checkbox" <?=($_GET['all'] == 'check' || $_GET['all'] == '') && $hero_group == '' ? 'checked' : ''?> name="all" value="check">
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">숏폼팀
                            <input type="checkbox" <?=strpos($hero_group,'group_04_05') ? 'checked' : ''?> name="hero_group[]" value="group_04_05">
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">인스타팀
                            <input type="checkbox" <?=strpos($hero_group,'group_04_06') ? 'checked' : ''?> name="hero_group[]" value="group_04_06">
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">블로그팀
                            <input type="checkbox" <?=strpos($hero_group,'group_04_28') ? 'checked' : ''?> name="hero_group[]" value="group_04_28">
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
    <div class="table_top">
        <h2 class="table_tit">검색 결과</h2>
        <p class="postNum"><span class="line"><?=number_format($search_total)?>개</span><span class="op_5">전체 <?=number_format($total_cnt)?>개</span></p>
    </div>
    <p class="table_desc"></p>
    <div class="searchResultBox_container">
        <table class="searchResultBox">
            <colgroup>
                <col width="45px" />
                <col width="150px" />
                <col width="120px" />
                <col width="105px" />
                <col width="120px" />
                <col width="60px" />
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
                    그룹
                </div>
            </th>
            <th>
                <div class="">
                    모집 시기
                </div>
            </th>
            <th>
                <div class="">
                    활동 기간
                </div>
            </th>
            <th>
                <div class="">
                    선정일
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
                        프리미어 뷰티 서포터즈
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        블로그팀
                    </div>
                </td>
                <td>
                    <div class="table_result_name">
                        24년 상반기
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        2024-07-01 00:00 ~ 2024-07-31 23:59
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        2024-06-28
                    </div>
                </td>
            </tr>
            <tr style="cursor:pointer" onClick="fnView('<?=$list["hero_code"]?>')">
                <td>
                    <div class="table_result_no">
                        <?=number_format($i);?>
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        프리미어 라이프 서포터즈
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        인스타팀
                    </div>
                </td>
                <td>
                    <div class="table_result_name">
                        24년 상반기
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        2024-07-01 00:00 ~ 2024-07-31 23:59
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        2024-06-28
                    </div>
                </td>
            </tr>

            <!-- 데이터가 없을 경우 사용해주세요. -->
            <!-- <tr>
                <td colspan="6" class="no_data">등록된 데이터가 없습니다.</td>
            </tr> -->

            </tbody>
        </table>
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
            jQuery("#sdate4, #startdate4").AnyTime_picker( {
                format: "%Y-%m-%d %H:%i:00"
            });

            jQuery("#edate4, #enddate4").AnyTime_picker( {
                format: "%Y-%m-%d %H:%i:00"
            });
        });

    });


</script>

