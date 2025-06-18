<link rel="stylesheet" href="/board/category.css?v=230515" type="text/css" />
<script type="text/javascript" src="/board/category.js"></script>
<script>
$(document).ready(function(){
	var category = ['<?=implode("','",$_FAQ_CATEGORY)?>'];

	$('#catetabs').tabSelect({
	  tabElements: category,
	  selectedTabs: ['<? if($_REQUEST["category"]){echo $_REQUEST["category"];}else{echo $_FAQ_CATEGORY[0];} ?>']
	});
});
</script>
<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$cut_count_name = '6';
$cut_title_name = '34';
######################################################################################################################################################
if(strcmp($_POST['kewyword'], '')){
    $search = " and ".$_POST['select']." like '%".$_POST['kewyword']."%'";
    $search_next = "&select=".$_POST['select']."&kewyword=".$_POST['kewyword'];
}else if(strcmp($_GET['kewyword'], '')){
    $search = " and ".$_GET['select']." like '%".$_GET['kewyword']."%'";
    $search_next = "&select=".$_GET['select']."&kewyword=".$_GET['kewyword'];
}
//카테고리 검색
if(strcmp($_GET['category'], '') && strcmp($_GET['category'], '전체')){
    $search .= " and hero_06 ='".$_GET['category']."' ";
    $search_next = "&category=".$_GET['category'];
}else{
}

######################################################################################################################################################
$sql = "select * from board where hero_table='".$_GET['board']."'".$search." and hero_use=1 order by hero_notice desc, hero_idx desc";
sql($sql);
$total_data = @mysql_num_rows($out_sql);
######################################################################################################################################################
$list_page=8;
$page_per_list=10;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board'].$search_next;
######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);
######################################################################################################################################################
?>

		<div style="padding-bottom:15px;">
			<div class="cate">
				<span id="catetabs" name="cus_2"></span>
			</div>
		</div>		
        <div class="contents">
        <p class="titleText" style="margin-top:10px;"><span class="titleLine">l</span>필독 TOP5</p>
        	
        	<table border="0" cellpadding="0" cellspacing="0" class="bbs_list">
                <colgroup>
                    <col width="30" />
                    <col width="*" />
                    <col width="1" />
                </colgroup>
                
                <!-- 필독 영역 시작 -->
                <tr class="q" style="background: #f5f5f5;">
                    <td><img src="../image/bbs/icon_q.png" alt="질문" /></td>
                    <td class="tl"><a href="#">AK LOVER가 되려면 어떻게 해야 하나요?</a></td>
                    <td></td>
                </tr>
                <tr class="answer">
                    <td valign="top" ><img src="../image/bbs/icon_a.png" alt="답변" class="mt10" /></td>
                    <td colspan="2" class="tl">
                    	<div>AK LOVER 홈페이지 가입과 동시에 AK LOVER로 활동이 가능하시며, 활동 임기 없이 지속적으로 활동 가능합니다.</div>
                    </td>
                </tr>
                
                <tr class="q" style="background: #f5f5f5;">
                    <td><img src="../image/bbs/icon_q.png" alt="질문" /></td>
                    <td class="tl"><a href="#">회원 정보를 변경하고 싶어요!</a></td>
                    <td></td>
                </tr>
                <tr class="answer">
                    <td valign="top" ><img src="../image/bbs/icon_a.png" alt="답변" class="mt10" /></td>
                    <td colspan="2" class="tl">
                    	<div>페이지 상단 - [마이페이지] - [회원정보 수정]에서 가능합니다.</div>
                    </td>
                </tr>
                
                <tr class="q" style="background: #f5f5f5;">
                    <td><img src="../image/bbs/icon_q.png" alt="질문" /></td>
                    <td class="tl"><a href="#">슈퍼패스란 무엇인가요?</a></td>
                    <td></td>
                </tr>
                <tr class="answer">
                    <td valign="top" ><img src="../image/bbs/icon_a.png" alt="답변" class="mt10" /></td>
                    <td colspan="2" class="tl">
                    	<div>슈퍼패스는 원하는 제품 체험단에 우선적으로 선정 가능한 티켓으로 선정 기준에 따라 매 월 첫 번째 로그인 시 부여되며, 매월 마지막날 소멸됩니다.</div>
                    </td>
                </tr>
                
                <tr class="q" style="background: #f5f5f5;">
                    <td><img src="../image/bbs/icon_q.png" alt="질문" /></td>
                    <td class="tl"><a href="#">체험단 가이드라인을 다운 받고 싶어요</a></td>
                    <td></td>
                </tr>
                <tr class="answer">
                    <td valign="top" ><img src="../image/bbs/icon_a.png" alt="답변" class="mt10" /></td>
                    <td colspan="2" class="tl">
                    	<div>체험단에 선정되시면, 아래 경로로 가이드라인을 다운 받아보실 수 있습니다. <br/>체험단 - [콘텐츠 가이드] - [가이드라인 다운로드]</div>
                    </td>
                </tr>
                
                <tr class="q" style="background: #f5f5f5;">
                    <td><img src="../image/bbs/icon_q.png" alt="질문" /></td>
                    <td class="tl"><a href="#">포인트 축제란 무엇인가요?</a></td>
                    <td></td>
                </tr>
                <tr class="answer">
                    <td valign="top" ><img src="../image/bbs/icon_a.png" alt="답변" class="mt10" /></td>
                    <td colspan="2" class="tl">
                    	<div>애경 서포터즈 AK LOVER 활동을 통해 적립된 포인트로 애경 제품을 교환 할 수 있는 축제입니다. 포인트 축제는 게릴라 성으로 불시에 진행될 예정입니다. 많은 기대 부탁드립니다.</div>
                    </td>
                </tr>
                <!-- 필독 영역 끝 -->
            </table>
            
            <table border="0" cellpadding="0" cellspacing="0" class="bbs_list" style="margin-top:30px;">
                <colgroup>
                    <col width="60" />
                    <col width="110" />
                    <col width="30" />
                    <col width="*" />
                 <? if( (!strcmp($_SESSION['temp_level'], '9999')) or (!strcmp($_SESSION['temp_level'], '10000')) ) {?>
                    <col width="150" />
                 <? } else { ?>
                    <col width="10" />
                 <? } ?>
                </colgroup>
                <tr class="bbshead">
                    <th class="first">번호</th>
                    <th>구분</th>
                    <th>&nbsp;</th>
                    <th colspan="2" class="last">제목</th>
                </tr>
<?
$sql = 'select * from board where hero_table=\''.$_GET['board'].'\''.$search.' and hero_use=1 order by hero_order asc, hero_today desc limit '.$start.','.$list_page.';';
sql($sql);
$i=0;
while($list                             = @mysql_fetch_assoc($out_sql)){
$num=$total_data - $start-$i;
$i++;
?>
                <tr class="q">
                    <td><?=$num?></td>
                    <td><?=$list['hero_06']?></td>
                    <td><img src="../image/bbs/icon_q.png" alt="질문" /></td>
                    <td class="tl"><a href="#"><?=$list['hero_title']?></a></td>
                    <td>
<?
if( (!strcmp($_SESSION['temp_level'], '9999')) or (!strcmp($_SESSION['temp_level'], '10000')) ){
	if(!strcmp($_GET['next_board'],"hero")){
		$hero_table = 'hero';
	}else{
		$hero_table = $_REQUEST['board'];
	}
?>
<a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&next_board=<?=$hero_table?>&view=write&action=update&idx=<?=$list['hero_idx'];?>&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_edit.gif" alt="수정" /></a>
<a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&next_board=<?=$hero_table?>&view=action&action=delete&code=<?=$list['hero_code']?>&table=<?=$list['hero_table']?>&idx=<?=$list['hero_idx'];?>&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_del.gif" alt="삭제" /></a>
<? } ?>
                    </td>
                </tr>
                <tr class="answer">
                    <td></td>
                    <td></td>
                    <td valign="top" ><img src="../image/bbs/icon_a.png" alt="답변" class="mt10" /></td>
                    <td colspan="2" class="tl">
                    <div><?=htmlspecialchars_decode($list['hero_command']);?></div>
                    </td>
                </tr>
<? } ?>
                </tr>
            </table>
<? 
	//if( (!strcmp($_SESSION['temp_level'], '9999')) or (!strcmp($_SESSION['temp_level'], '10000')) ){
		include_once BOARD_INC_END.'button.php';
	//}
?>
<? include_once BOARD_INC_END.'search.php';?>
        </div>
    </div>
    <script type="text/javascript">

        $('.q').click(function(e) {
        	if($(this).next().css('display') == "none") {
				$(this).next().show();
			}else {
				$(this).next().hide();
			}
        });
    </script>
