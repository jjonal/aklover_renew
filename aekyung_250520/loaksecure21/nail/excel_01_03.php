<?php
define('_HEROBOARD_', TRUE);//HEROBOARD����
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

$sql = "SELECT hero_title, hero_type, hero_table FROM mission WHERE hero_idx = ".$_REQUEST['hero_idx']."";
sql($sql,'on');
$row_sql = @mysql_fetch_array($out_sql);
$title = $row_sql['hero_title'];
if($row_sql['hero_type'] == 2) {
	$title .= "_�ҹ�����_���";
}else {
	$title .= "_�ı��ۼ���_���";
}



header( "Content-type: application/vnd.ms-excel;charset=euc-kr" ); 
header( "Content-Disposition: attachment; filename=".$title.date("Ymd",time()).".xls" ); 
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

$keyword = $_REQUEST['kewyword'];
$select = $_REQUEST['select'];
$hero_idx = $_REQUEST['hero_idx'];
$loverStar= $_REQUEST['loverStar'];

$search = " 1=1 ";
$search_next = "";
if(!strcmp($loverStar, 'Y')) {
	$search .= 'and hero_board_three = 1';
	$search_next .= "&loverStar=".$loverStar."";
}

if(strcmp($keyword, '')){
	if(!strcmp($select, 'hero_all')){
		$search .= ' AND ( A.hero_name like \'%'.$keyword.'%\' or A.hero_title like \'%'.$keyword.'%\' or';
		$search .= ' A.hero_command like \'%'.$keyword.'%\') ';
		$search_next .= '&select='.$select.'&kewyword='.$keyword;
	}else{
		$search .= ' AND A.'.$select.' like \'%'.$keyword.'%\'';
		$search_next .= '&select='.$select.'&kewyword='.$keyword;
	}
}

?>

<strong><?=date("Y-m-d")?></strong>
<table width="100%" border="1" cellpadding="1" cellspacing="0">
<?
	$sql = "SELECT 
				A.*,
				B.hero_id, 
				B.hero_jumin, 
				B.hero_mail, 
				B.hero_memo,
				B.hero_memo_01,
				B.hero_memo_02, 
				B.hero_memo_03, 
				B.hero_memo_04,
				C.hero_title as category, 
				D.hero_title as mission_title
			FROM board A
			LEFT OUTER JOIN member B 
			ON A.hero_code = B.hero_code
			LEFT OUTER JOIN 
				(SELECT hero_title, hero_board FROM hero_group) AS C 
			ON A.hero_table = C.hero_board
			LEFT OUTER JOIN 
				(SELECT hero_idx, hero_title FROM mission) AS D 
			ON A.hero_01=D.hero_idx
			WHERE ".$search." AND A.hero_01= '".$hero_idx."'";

	sql($sql,'on');
	
	$numb=1;
	
$postScript_sql = "SELECT hero_04 FROM board WHERE hero_01 = ".$hero_idx." LIMIT 1";
$out_postScript_sql = mysql_query($postScript_sql);
$postScript_list = @mysql_fetch_assoc($out_postScript_sql);
?>
  <tr align="center">
   <td align="center" valign="middle"><strong>��ȣ</strong></td>
   <td valign="middle"><strong>����</strong></td>
   <td valign="middle"><strong>ü��ܸ�</strong></td>
   <td valign="middle"><strong>�̸�</strong></td>
   <td valign="middle"><strong>�޴��̸�</strong></td>
   <td valign="middle"><strong>���̵�</strong></td>
   <td valign="middle"><strong>�г���</strong></td>
   <td valign="middle"><strong>����</strong></td>
   <td valign="middle"><strong>�̸���</strong></td>
   <td valign="middle"><strong>��ȭ��ȣ</strong></td>
   <td valign="middle"><strong>�����ȣ</strong></td>
   <td valign="middle"><strong>�޴º� �ּ�</strong></td>
   <td valign="middle"><strong>��û�ʼ�����</strong></td>
   <? if($postScript_list['hero_04']){ ?>
   <td valign="middle"><strong>�ı���URL(��)</strong></td>
   <? }else { ?>
   <td valign="middle"><strong>��α�URL</strong></td>
   <td valign="middle"><strong>ī��URL</strong></td>
   <td valign="middle"><strong>SNS URL</strong></td>
   <td valign="middle"><strong>��ŸURL</strong></td>
   <? } ?>
   <th valign="middle">������</th>
   <th valign="middle">AK BEAUTY ���̵�</th>
   

   <td valign="middle"><strong>�湮�ڼ�</strong></td>
   <td valign="middle"><strong>������</strong></td>
   <td valign="middle"><strong>���</strong></td>
   <? if($row_sql["hero_table"] == "group_04_06" || $row_sql["hero_table"] == "group_04_27") {?>
   	<td valign="middle"><strong>������ ����</strong></td>
   <? } ?>
   <td valign="middle"><strong>�����</strong></td>
   <td valign="middle"><strong>����ı⿩��</strong></td>

    </tr>
<?
	while($list = @mysql_fetch_array($out_sql)){
		if($numb%2 == 0) $bgcolor = "bgcolor='#EAEAEA'";
		else $bgcolor = "";
		
		$mission_review_sql = 'select * from mission_review where hero_code=\''.$list['hero_code'].'\' and hero_old_idx=\''.$hero_idx.'\';';//desc<=
        $out_mission_review_sql = mysql_query($mission_review_sql);
        $mission_review_list = @mysql_fetch_assoc($out_mission_review_sql);
						
		if(!strcmp($list['hero_board_three'], '1')) $list['hero_board_three'] = '����ı���';
		else $list['hero_board_three'] = '';
		 
		if($list['hero_jumin']) $age = date('Y')-substr($list['hero_jumin'],0,4)+1;
        else					$age = '';
		 
		if($mission_review_list['hero_03'])	$hero_03 = explode("/////",$mission_review_list['hero_03']);
		 
		if(!$list['hero_04']){ 
			$blog_url_arr = explode(",",$list['blog_url']);
			$cafe_url_arr = explode(",",$list['cafe_url']);
			$sns_url_arr = explode(",",$list['sns_url']);
			$etc_url_arr = explode(",",$list['etc_url']);
			
			$blog_url_cnt = count($blog_url_arr);
			$cafe_url_cnt = count($cafe_url_arr);
			$sns_url_cnt = count($sns_url_arr);
			$etc_url_cnt = count($etc_url_arr);
			
			$max - 0;
			$max = max($blog_url_cnt, $cafe_url_cnt, $sns_url_cnt, $etc_url_cnt);

			$url = "";
			for($i=0; $i<$max; $i++) {
								
				if($i != 0 ) $url .= "</tr><tr>";
				
				$url 	.= "<a href='".$blog_url_arr[$i]."'><td align='center' valign='middle' ".$bgcolor.">".$blog_url_arr[$i]."</td></a>";
				$url 	.= "<a href='".$cafe_url_arr[$i]."'><td align='center' valign='middle' ".$bgcolor.">".$cafe_url_arr[$i]."</td></a>";
				$url 	.= "<a href='".$sns_url_arr[$i]."'><td align='center' valign='middle' ".$bgcolor.">".$sns_url_arr[$i]."</td></a>";
				$url 	.= "<a href='".$etc_url_arr[$i]."'><td align='center' valign='middle' ".$bgcolor.">".$etc_url_arr[$i]."</td></a>";
				
				if($i==0) {
					$memo = $list['hero_memo_02']."<br style='mso-data-placement:same-cell;'>".$list['hero_memo_03']."<br style='mso-data-placement:same-cell;'>".$list['hero_memo_04'];
					$url .= "<td align='center' valign='middle' rowspan='".$max."'>".$list['hero_upgrade']."</td>";
					$url .= "<td align='center' valign='middle' rowspan='".$max."'>".$list['akbeauty_id']."</td>";
					$url .= "<td align='center' valign='middle' rowspan='".$max."'>".$list['hero_memo']."</td>";
					$url .= "<td align='center' valign='middle' rowspan='".$max."'>".$list['hero_memo_01']."</td>";
					$url .= "<td align='center' valign='middle' rowspan='".$max."'>".$memo."</td>";
					if($row_sql["hero_table"] == "group_04_06" || $row_sql["hero_table"] == "group_04_27") {
						$url .= "<td align='center' valign='middle' rowspan='".$max."'>".($list["hero_agree"] == "Y" ? "����":"�̵���")."</td>";
					}
					$url .= "<td align='center' valign='middle' rowspan='".$max."'>".date( "Y-m-d", strtotime($list['hero_today']))."</td>";
					$url .= "<td align='center' valign='middle' rowspan='".$max."'>".$list['hero_board_three']."</td>";
				}
			} 
		}
		 
?>
  <tr align="left" <?=$bgcolor?>>
   <td align="center" valign="middle" rowspan="<?=$max?>"><?=$numb?></td>
   <td align="center" valign="middle" rowspan="<?=$max?>"><?=$list['hero_title'];?></td>
   <td align="center" valign="middle" rowspan="<?=$max?>"><?=$list['mission_title'];?></td>
   <td align="center" valign="middle" rowspan="<?=$max?>"><?=$list['hero_name'];?></td>
   <td align="center" valign="middle" rowspan="<?=$max?>"><?=nl2br($mission_review_list['hero_new_name']);?></td>
   <td align="center" valign="middle" rowspan="<?=$max?>"><?=$list['hero_id'];?></td>
   <td align="center" valign="middle" rowspan="<?=$max?>"><?=$list['hero_nick'];?></td>
   <td align="center" valign="middle" rowspan="<?=$max?>"><?=$age;?></td>
   <td align="center" valign="middle" rowspan="<?=$max?>"><?=$list['hero_mail'];?></td>
   <td align="center" valign="middle" rowspan="<?=$max?>"><?=nl2br($mission_review_list['hero_hp_01']);?>-<?=nl2br($mission_review_list['hero_hp_02']);?>-<?=nl2br($mission_review_list['hero_hp_03']);?></td>
   <td align="center" valign="middle" rowspan="<?=$max?>"><?=nl2br($mission_review_list['hero_address_01']);?></td>
   <td align="center" valign="middle" rowspan="<?=$max?>"><?=nl2br($mission_review_list['hero_address_02']);?> <?=nl2br($mission_review_list['hero_address_03']);?></td>
   <td align="center" valign="middle" rowspan="<?=$max?>">
   		<?
			if($hero_03) {
				foreach ($hero_03 as $value){
					echo $value."<br style='mso-data-placement:same-cell;'>";
				}
			}
		?>
   </td>
   <? if($list['hero_04']){ ?>
   <td align="center" valign="middle" rowspan="<?=$max?>"><?=nl2br($list['hero_04']);?></td>
   <td align="center" valign="middle"><?=nl2br($list['hero_upgrade']);?></td>
   <td align="center" valign="middle"><?=nl2br($list['akbeauty_id']);?></td>
   <td align="center" valign="middle"><?=$list['hero_memo'];?></td>
   <td align="center" valign="middle"><?=$list['hero_memo_01'];?></td>
   <td align="center" valign="middle">
	    <?
	   		echo nl2br($list['hero_memo_02']);
			echo "<br style='mso-data-placement:same-cell;'>";
			echo nl2br($list['hero_memo_03']);
			echo "<br style='mso-data-placement:same-cell;'>";
			echo nl2br($list['hero_memo_04']);
   		?>
   </td>
   <? if($row_sql["hero_table"] == "group_04_06" || $row_sql["hero_table"] == "group_04_27") {?>
   	<td align="center" valign="middle"><?=$list['hero_agree']=="Y" ? "����":"�̵���";?></td>
   <? } ?>
   <td align="center" valign="middle"><?=date( "Y-m-d", strtotime($list['hero_today']));?></td>
   <td align="center" valign="middle"><?=$list['hero_board_three'];?></td>
   <? 
   }else {  
	   echo $url;
   }
   ?> 
   
  </tr>
<?
		$numb++;
	}//end while
?>
</table>




 
