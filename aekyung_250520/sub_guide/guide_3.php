<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);
######################################################################################################################################################
?>

<div class="contents">
    <table border="0" cellpadding="0" cellspacing="0" class="bbs_list">
        <colgroup>
            <col width="90px" />
            <col width="*" />
            <col width="90px" />
            <col width="70px" />
            <col width="60px" />
            <col width="60px" />
        </colgroup>
        <tr class="bbshead">
            <th class="first"><img src="../image/bbs/bbs_t_no.gif" alt="날짜" /></th>
            <th><img src="../image/bbs/bbs_t_subject.gif" alt="제목" /></th>
            <th><img src="../image/bbs/bbs_t_writer.gif" alt="작성자" /></th>
            <th><img src="../image/bbs/bbs_t_date.gif" alt="날짜" /></th>
            <th><img src="../image/bbs/bbs_t_view.gif" alt="조회" /></th>
            <th class="last"><img src="../image/bbs/bbs_t_recom.gif" alt="추천" /></th>
        </tr>
        <tr class="notice">
            <td><img src="../image/bbs/icon_notice.gif" alt="공지" /></td>
            <td class="tl"><a href="#">아토피때문에 고민이 많았어요.</a> <strong>[20]</strong></td>
            <td>홍길동</td>
            <td>13-08-16</td>
            <td>20</td>
            <td>16</td>
        </tr>
        <tr class="notice">
            <td><img src="../image/bbs/icon_notice.gif" alt="공지" /></td>
            <td class="tl"><a href="#">아토피때문에 고민이 많았어요.</a> <strong>[20]</strong></td>
            <td>홍길동</td>
            <td>13-08-16</td>
            <td>20</td>
            <td>16</td>
        </tr>
        <tr>
            <td>001</td>
            <td class="tl"><a href="#">아토피때문에 고민이 많았어요.</a> <strong>[6]</strong></td>
            <td>홍길동</td>
            <td>13-08-16</td>
            <td>20</td>
            <td>16</td>
        </tr>
        <tr>
            <td>001</td>
            <td class="tl"><a href="#">아토피때문에 고민이 많았어요.</a> <strong>[6]</strong></td>
            <td>홍길동</td>
            <td>13-08-16</td>
            <td>20</td>
            <td>16</td>
        </tr>
        <tr>
            <td>001</td>
            <td class="tl"><a href="#">아토피때문에 고민이 많았어요.</a> <strong>[6]</strong></td>
            <td>홍길동</td>
            <td>13-08-16</td>
            <td>20</td>
            <td>16</td>
        </tr>
        <tr>
            <td>001</td>
            <td class="tl"><a href="#">아토피때문에 고민이 많았어요.</a> <strong>[6]</strong></td>
            <td>홍길동</td>
            <td>13-08-16</td>
            <td>20</td>
            <td>16</td>
        </tr>
        <tr>
            <td>001</td>
            <td class="tl"><a href="#">아토피때문에 고민이 많았어요.</a> <strong>[6]</strong></td>
            <td>홍길동</td>
            <td>13-08-16</td>
            <td>20</td>
            <td>16</td>
        </tr>
        <tr>
            <td>001</td>
            <td class="tl"><a href="#">아토피때문에 고민이 많았어요.</a> <strong>[6]</strong></td>
            <td>홍길동</td>
            <td>13-08-16</td>
            <td>20</td>
            <td>16</td>
        </tr>
        <tr class="last">
            <td>001</td>
            <td class="tl"><a href="#">아토피때문에 고민이 많았어요.</a> <strong>[6]</strong></td>
            <td>홍길동</td>
            <td>13-08-16</td>
            <td>20</td>
            <td>16</td>
        </tr>
    </table>
    <div class="btngroup">
        <div class="btn_l">
            <a href=""><img src="../image/bbs/btn_write.gif" alt="글쓰기" /></a>
        </div>
        <div class="paging">
            <a href="" class="img"><img src="../image/bbs/page_ppre.gif" alt="첫페이지" /></a>
            <a href="" class="img"><img src="../image/bbs/page_pre.gif" alt="이전페이지" /></a>
            <a href="">1</a>
            <a href="">2</a>
            <a href="" class="current">3</a>
            <a href="">4</a>
            <a href="">5</a>
            <a href="" class="img"><img src="../image/bbs/page_next.gif" alt="다음페이지" /></a>
            <a href="" class="img"><img src="../image/bbs/page_nnext.gif" alt="마지막페이지" /></a>
        </div>
        <div class="btn_r">
            <a href=""><img src="../image/bbs/btn_list.gif" alt="목록" /></a>
            <!--<a href=""><img src="../image/bbs/btn_del.gif" alt="삭제" /></a>
            <a href=""><img src="../image/bbs/btn_edit.gif" alt="수정" /></a>
            <a href=""><img src="../image/bbs/btn_cancle.gif" alt="취소" /></a>
            <a href=""><img src="../image/bbs/btn_confrim.gif" alt="확인" /></a>-->
        </div>
    </div>
    <div class="searchbox">
        <div class="wrap_1">
            <form action="" method="" >
                <select name="" id="">
                    <option value="제목">제목</option>
                    <option value="내용">내용</option>
                    <option value="작성자">작성자</option>
                </select>
                <input type="text" class="kewyword">
                <input type="image" src="../image/bbs/btn_search.gif" alt="검색" class="bd0">
            </form>
        </div>
    </div>
</div>
</div>
