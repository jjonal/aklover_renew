<!-- /loaksecure21/index.php?idx=147&board=user&page=1&view=premierSupportersView -->
<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/user.css?v=250617" type="text/css" />


<?
if(!defined('_HEROBOARD_'))exit;
// 25.06.24 다섯개의 탭이 include 이기 때문에 해당 공통 페이지에 공통 쿼리문 삽입!

$sno = $_GET["sno"];

$supporters_sql  = " SELECT * FROM supporters WHERE idx = '".$sno."' ";
$supporters_res = sql($supporters_sql,"on");
$view = mysql_fetch_assoc($supporters_res);


$startDt = substr($view["startDt"], 0, 10);
$endDt = substr($view["endDt"], 0, 10);  // YYYY-MM-DD 부분만 추출

?>

<!-- 고정 타이틀 옆에 버튼 추가 Wrap -->
<div class="topButtonWrap">
    <a href="javascript:;" class="btnAdd3">저장</a>
</div>

<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
    <input type="hidden" name="sno" value="<?=$_GET["sno"]?>" />
    <input type="hidden" name="board" value="<?=$_GET["board"]?>" />

    <!-- 회원 관리 퀄리티 평가 검색 필터 -->
    <table class="searchBox">
        <colgroup>
            <col width="171px" />
            <col width="*" />
        </colgroup>
        <tr>
            <th>
                모집 기간
            </th>
            <td>
                <div class="search_inner">
                    <input class="search_txt" type="text" name="recruit" value="<?=$view["recruit"]?>"/>
                </div>
            </td>
        </tr>
        <tr>
            <th>
                서포터즈명
            </th>
            <td>
                <div class="search_inner">
                    <div class="search_inner">
                        <select class="search_txt" name="hero_board">
                            <option value="group_04_06" <?=$view["hero_board"] == "group_04_06" ? "selected" : ""?>>프리미어 뷰티 클럽</option>
                            <option value="group_04_28" <?=$view["hero_board"] == "group_04_28" ? "selected" : ""?>>프리미어 라이프 클럽</option>
                        </select>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <th>
                활동 기간
            </th>
            <td>
                <div class="search_inner">
                    <div class="dateMode_box">
                        <input type="text" name="startDate" class="dateMode" value="<?=$startDt?>">
                    </div>
                    <div class="inner_between">~</div>
                    <div class="dateMode_box">
                        <input type="text" name="endDate" class="dateMode" value="<?=$endDt?>">
                    </div>
                    <a class="btnAdd5 mgl20">수정</a>
                </div>
            </td>
        </tr>
    </table>
</form>


<div class="tableSection mgt30">
    <div class="table_top">
        <div>
            <h2 class="table_tit">검색 결과</h2>
            <div class="postNum">
                <span class="line"><?=number_format($search_total)?>개</span><span class="op_5">전체 <?=number_format($total_data)?>개</span>
                <div class="mu_form mgl10">
                    <div class="chkBox_wrap">
                        <p class="chkBox_tit mgr10">그룹 선택</p>
                        <label class="chkItem" for="chk1">전체
                            <input type="checkbox" id="chk1" name="chk_group">
                            <span class="checkmark"></span>
                        </label>
                        <label class="chkItem" for="chk2">프리미어 뷰티 클럽
                            <input type="checkbox" id="chk2" name="chk_group">
                            <span class="checkmark"></span>
                        </label>

                        <label class="chkItem" for="chk3">프리미어 라이프 클럽
                            <input type="checkbox" id="chk3" name="chk_group">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="table_btn bottom">
            <a class="btnAdd3 popup_btn" data-popup="01">선정자 추가하기</a>
            <a class="btnAdd3">회원 목록 다운로드</a>
            <a class="btnAdd3">선택 삭제</a>
        </div>
    </div>
    <p class="table_desc"></p>
    <div class="searchResultBox_container mu_form">
        <table class="searchResultBox">
            <colgroup>
                <col width="45px" />
                <col width="45px" />
                <col width="70px" />
                <col width="70px" />
                <col width="70px" />
                <col width="50px" />
                <col width="50px" />
                <col width="70px" />
                <col width="70px" />
                <col width="70px" />
                <col width="140px" />
            </colgroup>
            <thead>
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
                    아이디
                </div>
            </th>
            <th>
                <div class="">
                    닉네임
                </div>
            </th>
            <th>
                <div class="">
                    이름
                </div>
            </th>
            <th>
                <div class="">
                    나이
                </div>
            </th>
            <th>
                <div class="">
                    성별
                </div>
            </th>
            <th>
                <div class="">
                    그룹
                </div>
            </th>
            <th>
                <div class="">
                    SNS 퀄리티등급
                </div>
            </th>
            <th>
                <div class="">
                    가입일
                </div>
            </th>
            <th>
                <div class="">
                    비고
                </div>
            </th>
            </thead>
            <tbody>
            <tr>
                <td>
                    <div class="table_checkbox" style="position:relative">
                        <label class="akContainer">
                            <input type="checkbox" name="hero_idx" value="<?=$list['hero_idx']?>">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="table_result_no">
                        1
                    </div>
                </td>
                <td>
                    <div class="table_result_name">
                        aaaaaaaaaaaaaaaaaaaa
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        닉네임최대8글자
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        AK Lover
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        -
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        -
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        블로그팀
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        -
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        2024-00-00
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        <input type="text" />
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <div class="table_checkbox" style="position:relative">
                        <label class="akContainer">
                            <input type="checkbox" name="hero_idx" value="<?=$list['hero_idx']?>">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="table_result_no">
                        2
                    </div>
                </td>
                <td>
                    <div class="table_result_name">
                        아이디 20자 까지 등록가능
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        닉네임최대8글자
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        AK Lover
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        24
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        여
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        인스타그램팀
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        상
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        2024-00-00
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        <input type="text"/>
                    </div>
                </td>
            </tr>

            <!-- 데이터가 없을 때 추가해주세요. -->
            <!-- <tr>
                <td colspan="11" class="no_data">등록된 데이터가 없습니다.</td>
            </tr> -->
            </tbody>
        </table>
    </div>
</div>


<!--후기 URL 팝업-->
<div class="popup_url_box popup_supporters_selected" id="pop_01">
    <div class="popup_url_cont height_typeB">
        <div class="popup_url_head">
            <svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.41073 4.41083C4.73617 4.08539 5.26381 4.08539 5.58925 4.41083L15.5892 14.4108C15.9147 14.7363 15.9147 15.2639 15.5892 15.5893C15.2638 15.9148 14.7362 15.9148 14.4107 15.5893L4.41073 5.58934C4.0853 5.2639 4.0853 4.73626 4.41073 4.41083Z" fill="black"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5892 4.41083C15.2638 4.08539 14.7362 4.08539 14.4107 4.41083L4.41072 14.4108C4.08529 14.7363 4.08529 15.2639 4.41072 15.5893C4.73616 15.9148 5.2638 15.9148 5.58924 15.5893L15.5892 5.58934C15.9147 5.2639 15.9147 4.73626 15.5892 4.41083Z" fill="black"></path>
            </svg>
        </div>
        <div class="popup_url_body mu_form">
            <div class="tit">프리미어 서포터즈 선정 및 관리</div>
            <div class="popup_content mgt30">
                <div class="cont_item">
                    <p>모집 기간</p>
                    <input type="text"/>
                </div>
                <div class="cont_item">
                    <p>서포터즈명</p>
                    <input type="text"/>
                </div>
                <div class="cont_item">
                    <p>그룹 설정</p>
                    <div class="select_wrap">
                        <select>
                            <option>블로그팀</option>
                            <option>인스타그램팀</option>
                            <option>숏폼팀</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="btnContainer mgt150 line">
                <a href="javascript:;" class="btnAdd3">서포터즈 선정하기</a>
            </div>
        </div>
    </div>
</div>

<script>
    // 서브 제목 수정
    const subTittle = document.querySelector("#content .sub_tit");
    subTittle.innerText = "프리미어 서포터즈 명단 관리";

</script>