<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$view_check = false;

if(!strcmp($_SESSION['temp_level'], '')){
    $my_level = '0';
}else{
    $my_level = $_SESSION['temp_level'];
}
if($_GET['view_type'] == "list") $view_check = true;
if(!strcmp($my_level,'0') && $view_check){
	msg('로그인해주시기 바랍니다.','location.href="'.PATH_HOME.'?board=login"');
	exit;
}
$cut_count_name = '6';
$cut_title_name = '34';

$gubun_arr = array("1"=>"체험단 문의","2"=>"체험단 후기수정","3"=>"홈페이지 문의","4"=>"기타");

######################################################################################################################################################
if(strcmp($_POST['kewyword'], '')){
    $search = ' and '.$_POST['select'].' like \'%'.$_POST['kewyword'].'%\'';
    $search_next = '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
}else if(strcmp($_GET['kewyword'], '')){
    $search = ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
    $search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
}

if($_GET["gubun"]) {
	$search .= " AND gubun = '".$_GET["gubun"]."' ";
	$search_next .= "&gubun=".$_GET["gubun"];
}

######################################################################################################################################################
$sql = 'select * from board where hero_code=\''.$_SESSION['temp_code'].'\' and hero_table=\''.$_GET['board'].'\''.$search.' order by hero_notice desc, hero_idx desc;';
sql($sql);
$total_data = @mysql_num_rows($out_sql);
######################################################################################################################################################
$list_page=8;
$page_per_list=10;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board']."&view_type=list".$search_next;
######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);
?>

<!--1:1문의의 팝업창-->
<? if($view_check) { ?>
<script type="text/javascript" src="/js/lightbox_me.js"></script>

<script>

	$(document).ready(function(){

	    var cus = "cus" + '=';
	    var cookieData = document.cookie;
	    var start = cookieData.indexOf(cus);
	    var cValue = '';
	    if(start != -1){
	         start += cus.length;
	         var end = cookieData.indexOf(';', start);
	         if(end == -1)end = cookieData.length;
	         cValue = cookieData.substring(start, end);
	    }
	    cus = unescape(cValue);
	    //alert(cus);
		if(cus!="true"){
			$('#sign_up').lightbox_me({
		        centered: true,
		        onLoad: function() {
		            $('#sign_up').find('input:first').focus()
		            }
		    });
		}
	});

	function cus(val){
		var check = $('#notViewToday').is(":checked");
		if(check==true){
		      var expire = new Date();
		      expire.setDate(expire.getDate() + 1);
		      cookies = "cus" + '=' + escape("true") + '; path=/ '; // 한글 깨짐을 막기위해 escape(cValue)를 합니다.
		      if(typeof cDay != 'undefined') cookies += ';expires=' + expire.toGMTString() + ';';
		      document.cookie = cookies;
		}
		if(val=='cus_2'){
			location.href="/main/index.php?board="+val+"";
		}

	}
</script>

<style>

	#sign_up {
        -moz-border-radius: 6px;background: #eef2f7;-webkit-border-radius: 6px;border: 1px solid #536376;-webkit-box-shadow: rgba(0,0,0,.6) 0px 2px 12px;-moz-box-shadow:rgba(0,0,0,.6) 0px 2px 12px;padding: 14px 22px;
        width: 400px;position: relative;display: none;}
    #sign_up #sign_up_form {
        margin-top: 20px;
    }

    #sign_up #sign_up label input {
        display: block;width: 393px;height: 31px;background-position: -201px 0;padding: 2px 8px;font-size: 1.2em;line-height: 31px;}

    #sign_up #see_id {
        width: 228px;        height: 23px;        background-position: -202px -133px;        margin-top:15px;    }
    #sign_up #left_out {
        background-position: -202px -158px;width: 113px; height: 16px;    }
    #sign_up #sign_up_form {
        position: relative;padding-bottom: 54px;   }
    #sign_up #actions {
        float: left;        position: absolute;        right: 0;        height: 31px;        bottom: 20px;
    }
    #sign_up a.form_button {
        float: left;        width: 93px; height: 31px;        margin-right: 15px;    }

</style>


        <div class="contents">
        	<div class="explainWrap">
				- 체험단 문의 : 체험단 일정, 제품 배송, 혜택 등 (체험단/포인트체험단/제품 품평 등 모두 포함)<br/>
				- 체험단 후기수정 : 체험단 후기수정 내용 전달<br/>
				- 홈페이지 문의 : 홈페이지 오류, 홈페이지 활동 등<br/>
				- 기타 : 그 외 1:1 문의
			</div>
        	<div class="boardTabMenuWrap colorType">
				<a href="<?=PATH_HOME?>?board=<?=$_GET["board"]?>&view_type=list" <?if(!$_GET["gubun"]) {?>class="on"<?}?>>전체</a>
				<a href="<?=PATH_HOME?>?board=<?=$_GET["board"]?>&view_type=list&gubun=1" <?if($_GET["gubun"] == "1") {?>class="on"<?}?>>체험단 문의</a>
				<a href="<?=PATH_HOME?>?board=<?=$_GET["board"]?>&view_type=list&gubun=2" <?if($_GET["gubun"] == "2") {?>class="on"<?}?>>체험단 후기수정</a>
				<a href="<?=PATH_HOME?>?board=<?=$_GET["board"]?>&view_type=list&gubun=3" <?if($_GET["gubun"] == "3") {?>class="on"<?}?>>홈페이지 문의</a>
				<a href="<?=PATH_HOME?>?board=<?=$_GET["board"]?>&view_type=list&gubun=4" <?if($_GET["gubun"] == "4") {?>class="on"<?}?>>기타</a>
			</div>
            <table border="0" cellpadding="0" cellspacing="0" class="bbs_list">
                <colgroup>
                    <col width="90px" />
                    <col width="100px" />
                    <col width="*" />
                    <col width="90px" />
                    <col width="70px" />
                </colgroup>
                <tr class="bbshead">
                    <th class="first">번호</th>
                    <th>카테고리</th>
                    <th>제목</th>
                    <th>글쓴이</th>
                    <th class="last">날짜</th>
                </tr>
<?
$sql = 'SELECT A.*, B.hero_nick AS nick 
		FROM board A
		LEFT JOIN member B
		ON A.hero_code = B.hero_code
		WHERE A.hero_code=\''.$_SESSION['temp_code'].'\' AND A.hero_table=\''.$_GET['board'].'\''.$search.' 
		ORDER BY A.hero_idx DESC 
		LIMIT '.$start.','.$list_page.';';
sql($sql);
$i=0;
if($total_data > 0) {
while($list                             = @mysql_fetch_assoc($out_sql)){
$num=$total_data - $start-$i;
$i++;
?>
                <tr<?if(!strcmp($list['hero_notice'], '1')){?> class="notice"<?}?>>
                    <td><?=$num?></td>
                    <td class="color_<?=$list['gubun'];?>"><?=$gubun_arr[$list['gubun']]?></td>
                    <td class="tl">
                    <a href="<?=PATH_HOME;?>?board=<?=$_GET['board']?>&page=<?=$page?>&view=view_new&idx=<?=$list['hero_idx'];?>"><?=cut($list['hero_title'], $cut_title_name);?></a> <strong></strong>
                    </td>
                    <td><?=$list['nick']?></td>
                    <td><?=date( "y-m-d", strtotime($list['hero_today']));?></td>
                </tr>
<?}
} else {?>
<tr>
	<td colspan="5">등록된 데이터가 없습니다.</td>
</tr>
<?}?>
            </table>
<? include_once BOARD_INC_END.'button.php';?>
<? include_once BOARD_INC_END.'search.php';?>
        </div>
    </div>



	<div id="sign_up" style="display: none; left: 50%; margin-left: -223px; z-index: 1002; position: fixed; top: 50%; margin-top: -159px;">
                <h3 id="see_id" class="sprited">궁금한 점이 있으신가요?</h3>
                <span>자주 묻는 질문을 먼저 확인해주세요. </span><img src="/image2/etc/smile.png" width='20px'>
                <div id="sign_up_form">
                    <div id="actions">
                        <input type="checkbox" name="notViewToday" id="notViewToday">오늘 하루 그만 보기
                        <input type="button" value='자주 묻는 질문' style='margin-left: 24px;padding: 5px 10px;background: orange;border: 0px;border-radius: 5px;color: #eeeeee;cursor:pointer;' onclick="cus('cus_2')">
                        <input type="button" value='1:1문의' style='padding: 5px 10px;border: 0px;border-radius: 5px;cursor:pointer;' onclick="cus()" class="close form_button sprited">
                    </div>
                </div>
            </div>

<? }else { ?>
	<style>
		.contents h1{position: relative; margin-bottom:45px; font-weight:500; font-size:28px; text-align:center;}
		.contents .cs{text-align:center;}
		.contents .titleBig{margin-bottom:30px;text-align:center;color:#f68427;font-size:20px;font-weight:700;}
		.contents .description{margin-bottom:20px;font-weight:400;}
		.contents em{font-weight:400;color:#f68427;}
		.contents .csInfo{margin-bottom:50px; padding:28px 0 30px;text-align:left;background-color:#eee;}
		.contents .csInfo dl{margin-bottom:10px;padding-left:190px;}
		.contents .csInfo dt{display:inline-block; width:70px; margin-right:15px; font-size:16px;}
		.contents .csInfo dd{display:inline-block;font-weight:300;font-size:16px;}
		.contents .btnSection{text-align:center;margin-top:30px;}

	</style>
	<div class="contents">
    	<h1>고객센터</h1>
        <div class="cs">
            <p class="titleBig">
                AK LOVER 회원분들의<br/>
                작은 목소리에도 귀 기울이겠습니다.
            </p>
            <div class="description">
                AK LOVER 활동 문의 및 제안사항은 1:1 문의를 통해 접수해 주시고,<br/>
                통화를 원하시는 경우, <em>고객센터(080-024-1357)</em>로 전화주시면 친절하게 상담해 드리겠습니다.
            </div>

            <div class="csInfo">
                <dl>
                    <dt>문의전화</dt>
                    <dd>080-024-1357 <span>(수신자부담)</span></dd>
                </dl>
                <dl>
                    <dt>상담시간</dt>
                    <dd>평일 9시~18시 <span>(토, 일, 법정 공휴일 제외)</span></dd>
                </dl>
                <div class="btnSection btngroup">
                    <a href="/main/index.php?board=cus_3&view_type=list" class="a_btn">1:1문의</a>
                </div>
            </div>
    	</div>
    </div>
</div>
<? } ?>