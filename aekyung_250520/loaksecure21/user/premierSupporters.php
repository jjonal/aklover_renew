<!-- 프리미어 서포터즈 -->

<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
    <input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
    <input type="hidden" name="board" value="<?=$_GET["board"]?>" />

    <!-- 회원 관리 퀄리티 평가 검색 필터 -->
    <table class="searchBox">
        <colgroup>
            <col width="171px" />
            <col width="*" />
        </colgroup>
        <tr>
            <th>
                활동 기간
            </th>
            <td>
                <div class="search_inner">
                    <div class="dateMode_box">
                        <input type="text" name="startDate" class="dateMode" value="<?=$_REQUEST['startDate']?>">
                    </div>
                    <div class="inner_between">~</div>
                    <div class="dateMode_box">
                        <input type="text" name="endDate" class="dateMode" value="<?=$_REQUEST['endDate']?>">
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <th>
                검색어
            </th>
            <td>
                <div class="search_inner">
                    <input class="search_txt" type="text" name="kewyword" value="<?=$_GET["kewyword"]?>"/>
                </div>
            </td>
        </tr>
        <tr>
            <th>서포터즈 구분</th>
            <td>
                <div class="search_inner sup">
                    <label class="akContainer">전체
                        <input type="checkbox" name="supporters_chk" value="0">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">프리미어 뷰티 클럽
                        <input type="checkbox" name="supporters_chk" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">프리미어 라이프 클럽
                        <input type="checkbox" name="supporters_chk" value="2">
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
        </tr>
    </table>
    <div class="btnGroupSearch_box">
        <div class="btnGroupSearch">
            <a href="javascript:;" onClick="fnSearch()" class="btnSearch">검색</a>
        </div>
    </div>
</form>


<div class="tableSection mgt30">
    <div class="table_top">
        <div>
            <h2 class="table_tit">검색 결과</h2>
            <p class="postNum"><span class="line"><?=number_format($search_total)?>개</span><span class="op_5">전체 <?=number_format($total_data)?>개</span></p>
        </div>
        <a class="table_btn bottom btnAdd3 popup_btn" data-popup="01">서포터즈 생성</a>
    </div>
    <p class="table_desc"></p>
    <div class="searchResultBox_container">
        <table class="searchResultBox">
            <colgroup>
                <col width="45px" />
                <col width="70px" />
                <col width="120px" />
                <col width="15px" />
                <col width="75px" />
                <col width="75px" />
                <col width="70px" />
            </colgroup>
            <thead>
            <th>
                <div class="">
                    NO
                </div>
            </th>
            <th>
                <div class="">
                    모집 기간
                </div>
            </th>
            <th>
                <div class="">
                    서포터즈명
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
            <th>
                <div class="">
                    명단관리
                </div>
            </th>
            <th>
                <div class="">
                    삭제여부
                </div>
            </th>
            </thead>
            <tbody>
            <tr>
                <td>
                    <div class="table_result_no">
                        17
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        24년 상반기
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        프리미어 뷰티 서포터즈
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
                <td>
                    <div class="table_result_btn01">
                        <div class="table_result_btn_yn active">보기</div>
                    </div>
                </td>
                <td class="title">
                    <div class="table_result_btn02 pop_btn_01">
                        <p class="icon_box">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                <g opacity="0.4">
                                    <path d="M5.5 4.58203V17.932C5.5 18.1529 5.67909 18.332 5.9 18.332H16.1C16.3209 18.332 16.5 18.1529 16.5 17.932V4.58203" stroke="black" stroke-width="1.5" stroke-linejoin="round"/>
                                    <path d="M3.6665 4.58203H18.3332" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M8.25 4.58333V3.15C8.25 2.92909 8.42909 2.75 8.65 2.75H13.35C13.5709 2.75 13.75 2.92909 13.75 3.15V4.58333" stroke="black" stroke-width="1.5" stroke-linejoin="round"/>
                                    <path d="M9.1665 8.25V14.6667" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M12.8335 8.25V14.6667" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
                                </g>
                            </svg>
                        </p>
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <div class="table_result_no">
                        16
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        24년 상반기
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        프리미어 뷰티 서포터즈
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
                <td>
                    <div class="table_result_btn01">
                        <div class="table_result_btn_yn active">보기</div>
                    </div>
                </td>
                <td class="title">
                    <div class="table_result_btn02 pop_btn_01">
                        <p class="icon_box">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                <g opacity="0.4">
                                    <path d="M5.5 4.58203V17.932C5.5 18.1529 5.67909 18.332 5.9 18.332H16.1C16.3209 18.332 16.5 18.1529 16.5 17.932V4.58203" stroke="black" stroke-width="1.5" stroke-linejoin="round"/>
                                    <path d="M3.6665 4.58203H18.3332" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M8.25 4.58333V3.15C8.25 2.92909 8.42909 2.75 8.65 2.75H13.35C13.5709 2.75 13.75 2.92909 13.75 3.15V4.58333" stroke="black" stroke-width="1.5" stroke-linejoin="round"/>
                                    <path d="M9.1665 8.25V14.6667" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M12.8335 8.25V14.6667" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
                                </g>
                            </svg>
                        </p>
                    </div>
                </td>
            </tr>

            <!-- 데이터가 없을 때 추가해주세요. -->
            <!-- <tr>
                <td colspan="7" class="no_data">등록된 데이터가 없습니다.</td>
            </tr> -->
            </tbody>
        </table>
    </div>
</div>


<!--프리미어 서포터즈 선정 및 관리 팝업-->
<div class="popup_url_box" id="pop_01">
    <div class="popup_url_cont height_typeB">
        <div class="popup_url_head">
            <svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.41073 4.41083C4.73617 4.08539 5.26381 4.08539 5.58925 4.41083L15.5892 14.4108C15.9147 14.7363 15.9147 15.2639 15.5892 15.5893C15.2638 15.9148 14.7362 15.9148 14.4107 15.5893L4.41073 5.58934C4.0853 5.2639 4.0853 4.73626 4.41073 4.41083Z" fill="black"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5892 4.41083C15.2638 4.08539 14.7362 4.08539 14.4107 4.41083L4.41072 14.4108C4.08529 14.7363 4.08529 15.2639 4.41072 15.5893C4.73616 15.9148 5.2638 15.9148 5.58924 15.5893L15.5892 5.58934C15.9147 5.2639 15.9147 4.73626 15.5892 4.41083Z" fill="black"></path>
            </svg>
        </div>
        <div class="popup_url_body">
            <div class="tit">프리미어 서포터즈 설정</div>
            <div class="popup_url_link_v2">
                <div class="popup_url_link_item_v2">
                    <div class="popup_url_link_top">
                        <p class="popup_url_link_item_tit">모집 기간</p>
                    </div>
                    <div class="popup_url_link_cont mgt10">
                        <input type="text" value="" placeholder="24년 상반기" />
                    </div>
                </div>

                <div class="popup_url_link_item_v2">
                    <div class="popup_url_link_top">
                        <p class="popup_url_link_item_tit">서포터즈명</p>
                    </div>
                    <div class="popup_url_link_cont mgt10">
                        <input type="text" value="" placeholder="프리미어 뷰티 서포터즈" />
                    </div>
                </div>

                <div class="popup_url_link_item_v2 mu_form">
                    <div class="popup_url_link_top">
                        <p class="popup_url_link_item_tit">활동 기간</p>
                    </div>
                    <div class="popup_url_link_cont mgt10 dateBox">
                        <div class="search_inner">
                            <div class="dateMode_box">
                                <input type="text" name="startDate" class="dateMode" value="<?=$_REQUEST['startDate']?>">
                            </div>
                            <div class="inner_between">~</div>
                            <div class="dateMode_box">
                                <input type="text" name="endDate" class="dateMode" value="<?=$_REQUEST['endDate']?>">
                            </div>
                        </div>
                    </div>
                    <p class="notice">* 설정된 기간동안 프리미어 서포터즈로 활동합니다.</p>
                </div>
            </div>
            <div class="btnContainer mgt20 line">
                <a href="javascript:;" class="btnAdd3">서포터즈 생성하기</a>
            </div>
        </div>
    </div>
</div>