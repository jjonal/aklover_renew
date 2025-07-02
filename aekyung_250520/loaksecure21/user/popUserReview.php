<?php
define('_HEROBOARD_', TRUE);
header("Content-type: text/html; charset=euc-kr");
include_once                                                        '../../freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';

if($_REQUEST['location'] == 'top') {
    $sql_top = " SELECT b.hero_idx, mb.hero_level, mb.hero_nick, b.hero_title AS review_title, m.hero_title AS mission_title, b.hero_today, ";
    $sql_top .= " b.hero_board_three, IF(IFNULL(b.hero_board_three,0) = '1','Y','N') AS best, IF(IFNULL(b.hero_board_three,0) = '2','Y','N') AS semi_best, ";
    $sql_top .= " m.hero_table, ";
    $sql_top .= " m.hero_today_01_01, m.hero_today_01_02, ";
    $sql_top .= " m.hero_today_02_01, m.hero_today_02_02, ";
    $sql_top .= " m.hero_today_03_01, m.hero_today_03_02, ";
    $sql_top .= " m.hero_today_04_01, m.hero_today_04_02, ";
    $sql_top .= " m.hero_today_05_01, m.hero_today_05_02 ";
    $sql_top .= " FROM board b ";
    $sql_top .= " JOIN mission m ON m.hero_idx = b.hero_01 ";
    $sql_top .= " JOIN member mb ON mb.hero_code = b.hero_code ";
    $sql_top .= " WHERE 1=1 ";
    $sql_top .= " AND b.hero_idx = '" . $_POST["hero_idx"] . "' ";
    $sql_top .= " LIMIT 1";

    sql($sql_top, "on");
    $row_top = mysql_fetch_assoc($out_sql);

    if ($row_top['hero_level'] == '9994') {
        $member_grade = '프리미어 라이프 클럽';
    } else if ($row_top['hero_level'] == '9996') {
        $member_grade = '프리미어 뷰티 클럽';
    } else {
        $member_grade = '베이직 뷰티&라이프 클럽';
    }

    $html_top = '<table>';
    $html_top .= '    <colgroup>';
    $html_top .= '        <col width="144px" />';
    $html_top .= '        <col width="*" />';
    $html_top .= '    </colgroup>';
    $html_top .= '    <tr>';
    $html_top .= '        <th>';
    $html_top .= '            <div class="">닉네임</div>';
    $html_top .= '        </th>';
    $html_top .= '        <td>';
    $html_top .= '            <div class="">' . $row_top['hero_nick'] . '</div>';
    $html_top .= '        </td>';
    $html_top .= '    </tr>';
    $html_top .= '    <tr>';
    $html_top .= '        <th>';
    $html_top .= '            <div class="">회원 등급</div>';
    $html_top .= '        </th>';
    $html_top .= '        <td>';
    $html_top .= '            <div class="">' . $member_grade . '</div>';
    $html_top .= '        </td>';
    $html_top .= '    </tr>';
    $html_top .= '    <tr>';
    $html_top .= '        <th>';
    $html_top .= '            <div class="">콘텐츠 타이틀 명</div>';
    $html_top .= '        </th>';
    $html_top .= '        <td>';
    $html_top .= '            <div class="">' . $row_top['review_title'] . '</div>';
    $html_top .= '        </td>';
    $html_top .= '    </tr>';
    $html_top .= '    <tr>';
    $html_top .= '        <th>';
    $html_top .= '            <div class="">콘텐츠 등록일</div>';
    $html_top .= '        </th>';
    $html_top .= '        <td>';
    $html_top .= '            <div class="">' . $row_top['hero_today'] . '</div>';
    $html_top .= '        </td>';
    $html_top .= '    </tr>';
    $html_top .= '</table>';

    echo $html_top;
}
else if($_REQUEST['location'] == 'bot') {
    $sql_bot = "SELECT * FROM mission_url WHERE board_hero_idx = '" . $_POST["hero_idx"] . "'";
    sql($sql_bot, "on");
    var_dump($sql_bot);
    $html_bot = '';

    while ($row_bot = mysql_fetch_assoc($out_sql)) {
        if($row_bot['gubun'] == 'naver'){
            $gubun = '네이버 블로그';
        }else if ($row_bot['gubun'] == 'insta'){
            $gubun = '인스타그램';
        }else if ($row_bot['gubun'] == 'movie'){
        $gubun = '유투브';
        }else {
            $gubun = '기타';
        }

        $html_bot .= '<div class="popup_url_link_item">';
        $html_bot .= '   <div class="popup_url_link_top">';
        $html_bot .= '       <div class="popup_url_link_item_img"></div>';
        $html_bot .= '       <p class="popup_url_link_item_tit">'.$gubun.'</p>';
        $html_bot .= '   </div>';
        $html_bot .= '   <div class="popup_url_link_cont active">';
        $html_bot .= '       <input value="'.$row_bot['url'].'"/>';
        $html_bot .= '       <a href="'.$row_bot['url'].'" target="_blank">';
        $html_bot .= '       <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">';
        $html_bot .= '           <path fill-rule="evenodd" clip-rule="evenodd" d="M5.25 3C4.00736 3 3 4.00736 3 5.25V12.75C3 13.9926 4.00736 15 5.25 15H12.75C13.9926 15 15 13.9926 15 12.75V9.75C15 9.33579 15.3358 9 15.75 9C16.1642 9 16.5 9.33579 16.5 9.75V12.75C16.5 14.8211 14.8211 16.5 12.75 16.5H5.25C3.17893 16.5 1.5 14.8211 1.5 12.75V5.25C1.5 3.17893 3.17893 1.5 5.25 1.5H8.25C8.66421 1.5 9 1.83579 9 2.25C9 2.66421 8.66421 3 8.25 3H5.25Z" fill="black"/>';
        $html_bot .= '           <path fill-rule="evenodd" clip-rule="evenodd" d="M16.2803 1.71967C16.5732 2.01256 16.5732 2.48744 16.2803 2.78033L9.53033 9.53033C9.23744 9.82322 8.76256 9.82322 8.46967 9.53033C8.17678 9.23744 8.17678 8.76256 8.46967 8.46967L15.2197 1.71967C15.5126 1.42678 15.9874 1.42678 16.2803 1.71967Z" fill="black"/>';
        $html_bot .= '           <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 2.25C10.5 1.83579 10.8358 1.5 11.25 1.5H15.75C16.1642 1.5 16.5 1.83579 16.5 2.25V6.75C16.5 7.16421 16.1642 7.5 15.75 7.5C15.3358 7.5 15 7.16421 15 6.75V3H11.25C10.8358 3 10.5 2.66421 10.5 2.25Z" fill="black"/>';
        $html_bot .= '       </svg>';
        $html_bot .= '       </a>';
        $html_bot .= '   </div>';
        $html_bot .= '</div>';
    }

    echo $html_bot;
}
?>