<?php
session_start(); 
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once   '../../freebest/head.php';
include_once  '../../freebest/function.php';

header( "Content-type: application/vnd.ms-excel;charset=iso-8859-1" );
header( "Content-Disposition: attachment; filename=선정자 후보 목록 ".date("Ymd",time()).".xls" );
header("Content-charset=euc-kr");

if(!$_SESSION['temp_id']){echo '<script>location.href="'.PATH_END.'out.php"</script>';exit;}

if((int)$_SESSION['temp_level'] >= 9999){
	include_once   '../../freebest/hero.php';
?>
    <strong><?=date("Y-m-d")?></strong>
    <table width="100%" border="1" cellpadding="3" cellspacing="0">
        <?
        if($_GET['hero_idx'] != ''){ //bestReviewHistoryView.php에서
            $hero_idxArr = explode('|', $_GET['hero_idx']);
            $hero_idx = "";

            for($i=0; $i<count($hero_idxArr); $i++){
                if($i == 0) $comma = "";
                else        $comma = ",";

                $hero_idx .= $comma."'".$hero_idxArr[$i]."'";
            }

            $sql  = " SELECT b.hero_idx, mb.hero_level, mb.hero_name, mb.hero_id, mb.hero_nick, ";
            $sql .= " b.hero_title AS review_title, m.hero_title AS mission_title, b.hero_today, ";
            $sql .= " b.hero_board_three, IF(IFNULL(b.hero_board_three,0) = '1','Y','N') AS best, IF(IFNULL(b.hero_board_three,0) = '2','Y','N') AS semi_best, ";
            $sql .= " mb.hero_sex, mb.hero_jumin, mb.hero_today AS member_today, mb.hero_mail ";
            $sql .= " FROM board b ";
            $sql .= " JOIN mission m ON m.hero_idx = b.hero_01 ";
            $sql .= " JOIN member mb ON mb.hero_code = b.hero_code ";
            $sql .= " WHERE 1=1 ";
            $sql .= " AND b.hero_idx IN ( ";
            $sql .= " SELECT board_hero_idx FROM monthak where hero_idx in (".$hero_idx.") ";
            $sql .= " )";
            $sql .= " ORDER BY b.hero_today DESC ";

            sql($sql,'on');
            $numb=1;
        }else { //bestReview.php에서
            //체크된 후기
            $board_hero_idxArr = explode('|', $_GET['board_hero_idx']);
            $board_hero_idx = "";

            for($i=0; $i<count($board_hero_idxArr); $i++){
                if($i == 0) $comma = "";
                else        $comma = ",";

                $board_hero_idx .= $comma."'".$board_hero_idxArr[$i]."'";
            }

            $sql  = " SELECT b.hero_idx, mb.hero_level, mb.hero_name, mb.hero_id, mb.hero_nick, ";
            $sql .= " b.hero_title AS review_title, m.hero_title AS mission_title, b.hero_today, ";
            $sql .= " b.hero_board_three, IF(IFNULL(b.hero_board_three,0) = '1','Y','N') AS best, IF(IFNULL(b.hero_board_three,0) = '2','Y','N') AS semi_best, ";
            $sql .= " mb.hero_sex, mb.hero_jumin, mb.hero_today AS member_today, mb.hero_mail ";
            $sql .= " FROM board b ";
            $sql .= " JOIN mission m ON m.hero_idx = b.hero_01 ";
            $sql .= " JOIN member mb ON mb.hero_code = b.hero_code ";
            $sql .= " WHERE 1=1 ";
            $sql .= " AND b.hero_idx IN (".$board_hero_idx.")";
            $sql .= " ORDER BY b.hero_today DESC ";

//        echo $sql;
            sql($sql,'on');
            $numb=1;
        }
        ?>
        <tr align="center">
            <td align="center" valign="middle"><strong>번호</strong></td>
            <td valign="middle"><strong>서포터즈 구분</strong></td>
            <td valign="middle"><strong>이름</strong></td>
            <td valign="middle"><strong>아이디</strong></td>
            <td valign="middle"><strong>닉네임</strong></td>
            <td valign="middle"><strong>콘텐츠 타이틀명</strong></td>
            <td valign="middle"><strong>체험단명</strong></td>
            <td valign="middle"><strong>콘텐츠 등록일</strong></td>
            <td valign="middle"><strong>우수콘텐츠 여부</strong></td>
            <td valign="middle"><strong>준우수콘텐츠 여부</strong></td>
            <td valign="middle"><strong>성별</strong></td>
            <td valign="middle"><strong>나이</strong></td>
            <td valign="middle"><strong>가입일</strong></td>
            <td valign="middle"><strong>이메일</strong></td>
            <td valign="middle"><strong>인스타 URL</strong></td>
            <td valign="middle"><strong>블로그 URL</strong></td>
            <td valign="middle"><strong>유튜브 URL</strong></td>
            <td valign="middle"><strong>기타 URL</strong></td>
        </tr>
        <?
	    while($list = @mysql_fetch_array($out_sql)){
            //회원등급
            if($list['hero_level'] == '9994'){
                $member_grade = '프리미어 라이프 클럽';
            }else if($list['hero_level'] == '9996'){
                $member_grade = '프리미어 뷰티 클럽';
            }else {
                $member_grade = '베이직 뷰티&라이프 클럽';
            }
            //우수 콘텐츠
            if($list['best'] == 'Y') $best = '선정';
            else $best = '미선정';
            //준우수 콘텐츠
            if($list['semi_best'] == 'Y') $semi_best = '선정';
            else $semi_best = '미선정';
            //성별
            if($list['hero_sex'] == '0') $sex = '여';
            else $sex = '남';
            //나이
            $age = (date("Y")-substr($list["hero_jumin"],0,4))+1;
        ?>
            <tr align="left">
                <td align="center" valign="middle"><?=$numb?></td>
                <td align="center" valign="middle" ><?=$member_grade?></td>
                <td align="center" valign="middle" ><?=$list["hero_name"]?></td>
                <td align="center" valign="middle" ><?=$list["hero_id"]?></td>
                <td align="center" valign="middle" ><?=$list["hero_nick"]?></td>
                <td align="center" valign="middle"><?=$list["review_title"]?></td>
                <td align="center" valign="middle"><?=$list["mission_title"]?></td>
                <td align="center" valign="middle"><?=$list["hero_today"]?></td>
                <td align="center" valign="middle"><?=$best?></td>
                <td align="center" valign="middle"><?=$semi_best?></td>
                <td align="center" valign="middle"><?=$sex?></td>
                <td align="center" valign="middle"><?=$age?></td>
                <td align="center" valign="middle"><?=$list["member_today"]?></td>
                <td align="center" valign="middle"><?=$list["hero_mail"]?></td>
                <?php
                //후기등록 URL
                $sql_url = "";

                $sql_url  = " SELECT gubun, GROUP_CONCAT(url) url FROM mission_url ";
                $sql_url .= " WHERE board_hero_idx = '".$list['hero_idx']."' ";
                $sql_url .= " GROUP BY board_hero_idx, gubun ";

                $res_url = @mysql_query($sql_url);
                while($mission_url = @mysql_fetch_array($res_url)){
                    if($mission_url['gubun'] == 'naver'){
                        $naver = $mission_url['url'];
                    }else if($mission_url['gubun'] == 'insta'){
                        $insta = $mission_url['url'];
                    }else if($mission_url['gubun'] == 'movie'){
                        $movie = $mission_url['url'];
                    }else if($mission_url['gubun'] == 'etc'){
                        $etc = $mission_url['url'];
                    }
                }
                ?>
                <td align="center" valign="middle"><?=$insta?></td>
                <td align="center" valign="middle"><?=$naver?></td>
                <td align="center" valign="middle"><?=$movie?></td>
                <td align="center" valign="middle"><?=$etc?></td>
            </tr>
        <?php
            $numb++;
	    }//end while
        ?>
    </table>
    <?
}//end if
?>