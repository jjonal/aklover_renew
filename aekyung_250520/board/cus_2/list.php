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
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
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
//ī�װ� �˻�
if(strcmp($_GET['category'], '') && strcmp($_GET['category'], '��ü')){
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
        <p class="titleText" style="margin-top:10px;"><span class="titleLine">l</span>�ʵ� TOP5</p>
        	
        	<table border="0" cellpadding="0" cellspacing="0" class="bbs_list">
                <colgroup>
                    <col width="30" />
                    <col width="*" />
                    <col width="1" />
                </colgroup>
                
                <!-- �ʵ� ���� ���� -->
                <tr class="q" style="background: #f5f5f5;">
                    <td><img src="../image/bbs/icon_q.png" alt="����" /></td>
                    <td class="tl"><a href="#">AK LOVER�� �Ƿ��� ��� �ؾ� �ϳ���?</a></td>
                    <td></td>
                </tr>
                <tr class="answer">
                    <td valign="top" ><img src="../image/bbs/icon_a.png" alt="�亯" class="mt10" /></td>
                    <td colspan="2" class="tl">
                    	<div>AK LOVER Ȩ������ ���԰� ���ÿ� AK LOVER�� Ȱ���� �����Ͻø�, Ȱ�� �ӱ� ���� ���������� Ȱ�� �����մϴ�.</div>
                    </td>
                </tr>
                
                <tr class="q" style="background: #f5f5f5;">
                    <td><img src="../image/bbs/icon_q.png" alt="����" /></td>
                    <td class="tl"><a href="#">ȸ�� ������ �����ϰ� �;��!</a></td>
                    <td></td>
                </tr>
                <tr class="answer">
                    <td valign="top" ><img src="../image/bbs/icon_a.png" alt="�亯" class="mt10" /></td>
                    <td colspan="2" class="tl">
                    	<div>������ ��� - [����������] - [ȸ������ ����]���� �����մϴ�.</div>
                    </td>
                </tr>
                
                <tr class="q" style="background: #f5f5f5;">
                    <td><img src="../image/bbs/icon_q.png" alt="����" /></td>
                    <td class="tl"><a href="#">�����н��� �����ΰ���?</a></td>
                    <td></td>
                </tr>
                <tr class="answer">
                    <td valign="top" ><img src="../image/bbs/icon_a.png" alt="�亯" class="mt10" /></td>
                    <td colspan="2" class="tl">
                    	<div>�����н��� ���ϴ� ��ǰ ü��ܿ� �켱������ ���� ������ Ƽ������ ���� ���ؿ� ���� �� �� ù ��° �α��� �� �ο��Ǹ�, �ſ� �������� �Ҹ�˴ϴ�.</div>
                    </td>
                </tr>
                
                <tr class="q" style="background: #f5f5f5;">
                    <td><img src="../image/bbs/icon_q.png" alt="����" /></td>
                    <td class="tl"><a href="#">ü��� ���̵������ �ٿ� �ް� �;��</a></td>
                    <td></td>
                </tr>
                <tr class="answer">
                    <td valign="top" ><img src="../image/bbs/icon_a.png" alt="�亯" class="mt10" /></td>
                    <td colspan="2" class="tl">
                    	<div>ü��ܿ� �����ǽø�, �Ʒ� ��η� ���̵������ �ٿ� �޾ƺ��� �� �ֽ��ϴ�. <br/>ü��� - [������ ���̵�] - [���̵���� �ٿ�ε�]</div>
                    </td>
                </tr>
                
                <tr class="q" style="background: #f5f5f5;">
                    <td><img src="../image/bbs/icon_q.png" alt="����" /></td>
                    <td class="tl"><a href="#">����Ʈ ������ �����ΰ���?</a></td>
                    <td></td>
                </tr>
                <tr class="answer">
                    <td valign="top" ><img src="../image/bbs/icon_a.png" alt="�亯" class="mt10" /></td>
                    <td colspan="2" class="tl">
                    	<div>�ְ� �������� AK LOVER Ȱ���� ���� ������ ����Ʈ�� �ְ� ��ǰ�� ��ȯ �� �� �ִ� �����Դϴ�. ����Ʈ ������ �Ը��� ������ �ҽÿ� ����� �����Դϴ�. ���� ��� ��Ź�帳�ϴ�.</div>
                    </td>
                </tr>
                <!-- �ʵ� ���� �� -->
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
                    <th class="first">��ȣ</th>
                    <th>����</th>
                    <th>&nbsp;</th>
                    <th colspan="2" class="last">����</th>
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
                    <td><img src="../image/bbs/icon_q.png" alt="����" /></td>
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
<a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&next_board=<?=$hero_table?>&view=write&action=update&idx=<?=$list['hero_idx'];?>&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_edit.gif" alt="����" /></a>
<a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&next_board=<?=$hero_table?>&view=action&action=delete&code=<?=$list['hero_code']?>&table=<?=$list['hero_table']?>&idx=<?=$list['hero_idx'];?>&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_del.gif" alt="����" /></a>
<? } ?>
                    </td>
                </tr>
                <tr class="answer">
                    <td></td>
                    <td></td>
                    <td valign="top" ><img src="../image/bbs/icon_a.png" alt="�亯" class="mt10" /></td>
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
