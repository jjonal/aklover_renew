<?php
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';
$sql = "SELECT hero_title FROM mission WHERE hero_idx = ".$_POST['hero_idx']."";
sql($sql,'on');
$row_sql = @mysql_fetch_array($out_sql);
$title = $row_sql[0];

header( "Content-type: application/vnd.ms-excel;charset=euc-kr" ); 
header( "Content-Disposition: attachment; filename=".$title."_신청자목록_".date("Ymd",time()).".xls" ); 
header("Content-charset=euc-kr");
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

$keyword = $_POST['kewyword'];
$select = $_POST['select'];
$hero_idx = $_POST['hero_idx'];
$lot_01 = $_POST['winner'];

$search = "";
$search_next = "";
if(!strcmp($lot_01, 'Y')) {
	$search .= 'and lot_01 = 1';
	$search_next .= "&winner=".$lot_01."";
}
if(strcmp($keyword, '')){
	if(!strcmp($select, 'hero_all')){
		$search .= 'and ( hero_nick like \'%'.$keyword.'%\' or hero_name like \'%'.$keyword.'%\') ';
		$search_next .= '&select='.$select.'&kewyword='.$keyword;
	}else{
		$search .= 'and '.$select.' like \'%'.$keyword.'%\' ';
		$search_next .= '&select='.$select.'&kewyword='.$keyword;
	}
}
?>
<strong><?=date("Y-m-d")?></strong>
<table width="100%" border="1" cellpadding="1" cellspacing="0">
<?
	$sql = "SELECT 
				A.hero_title, 
				B.hero_title AS mission_title,
				B.hero_type,
				B.hero_multiple,
				B.hero_single,
				C.hero_jumin, 
				C.hero_mail, 
				C.hero_insta_cnt,
				C.hero_memo,
				C.hero_memo_01,
				C.hero_memo_02, 
				C.hero_memo_03, 
				C.hero_memo_04,
				(case when C.hero_sex = 0 then '여' when C.hero_sex = 1 then '남' else '-' end) as hero_sex,
				D.hero_idx, 
				D.hero_id, 
				D.hero_number, 
				D.hero_name, 
				D.hero_nick, 
				D.hero_today, 
				D.hero_new_name,
				D.hero_hp_01,
				D.hero_hp_02,
				D.hero_hp_03,
				D.lot_01, 
				D.hero_01,
				D.hero_03,
				D.hero_address_01,
				D.hero_address_02,
				D.hero_address_03,
				D.hero_code,
				D.hero_superpass,
				D.hero_multiple AS user_multiple,
				D.hero_single AS user_single,
				D.delivery_point_yn AS delivery_point_yn,
				D.hero_agree,
				E.hero_idx as point_idx, 
				E.hero_point as sum_point, 
				E.hero_title AS point_title,
				(select ifnull(sum(hero_point),0) from point where hero_code = D.hero_code) as total_point,
				C.hero_level,
			    (select ifnull(sum(hero_order_point),0) from order_main where hero_code = D.hero_code AND hero_process != 'C') as order_point,
			    (select count(*) from order_main where hero_code = D.hero_code AND hero_process = 'DE' AND mission_idx = D.hero_old_idx) as delivery_point_cnt,
				C.hero_oldday
			FROM mission_review AS D 
			LEFT OUTER JOIN 
				hero_group AS A 
			ON A.hero_board=D.hero_table 
			LEFT OUTER JOIN 
				mission as B 
			ON B.hero_idx=D.hero_old_idx 
			LEFT OUTER JOIN 
				member AS C 
			ON C.hero_code=D.hero_code 
			LEFT OUTER JOIN 
				point AS E 
			ON E.hero_mission_idx=D.hero_old_idx AND E.hero_top_title='미션신청인원'
			AND E.hero_code=D.hero_code
			WHERE D.hero_old_idx='".$hero_idx."' 
			AND C.hero_use=0 ".$search."
			ORDER BY D.hero_table, D.hero_today DESC";
	sql($sql,'on');
	//echo $sql;
	
	//데이터 유무 확인위한 쿼리
	$sql2 = "SELECT hero_type, hero_ask, hero_multiple, hero_single, delivery_point_yn, hero_question_url_list FROM mission WHERE hero_idx = ".$hero_idx."";
	$out_sql2 = mysql_query($sql2);
	$list2 = @mysql_fetch_array($out_sql2);
	$ask_arr = array();
	if($list2["hero_ask"]) {
		$ask_arr = explode("/////",$list2["hero_ask"]);
	}
	$multiple_arr = array();
	if($list2["hero_multiple"]) {
		$multiple_arr = explode("/////",$list2["hero_multiple"]);
	}
	$single_arr = array();
	if($list2["hero_single"]) {
		$single_arr = explode("/////",$list2["hero_single"]);
	}
	
	$question_url_arr = array();
	if($list2["hero_question_url_list"]) {
		$question_url_arr = explode("/////",$list2["hero_question_url_list"]);
	}
	
	$numb=1;
?>
  <tr align="center">
   <td align="center" valign="middle"><strong>번호</strong></td>
   <td valign="middle"><strong>카테고리</strong></td>
   <td valign="middle"><strong>제목</strong></td>
   <td valign="middle"><strong>이름</strong></td>
   <td valign="middle"><strong>받는이름</strong></td>
   <td valign="middle"><strong>아이디</strong></td>
   <td valign="middle"><strong>닉네임</strong></td>
   <td valign="middle"><strong>성별</strong></td>
   <td valign="middle"><strong>나이</strong></td>
   <td valign="middle"><strong>레벨</strong></td>
   <td valign="middle"><strong>가입일</strong></td>
   <td valign="middle"><strong>이메일</strong></td>
   <td valign="middle"><strong>전화번호</strong></td>
   <td valign="middle"><strong>우편번호</strong></td>
   <td valign="middle"><strong>받는분 주소</strong></td>
   <? if($list2['hero_type'] != 2) {?>
   	<? if($list2["hero_question_url_list"]) {?>
   		<? foreach($question_url_arr as $val) {?>
   			<td valign="middle"><strong><?=$val?></strong></td>
   		<? } ?>
   	<? } else { ?>
   		<td valign="middle"><strong>URL</strong></td>
   	<? } ?>
   <? } ?>
   <? if($list2['hero_type'] == 2) { ?>
   <td valign="middle"><strong>등록URL(소문내기)</strong></td>
   <? } ?>
   <td valign="middle"><strong>방문자수</strong></td>
   <td valign="middle"><strong>포스팅</strong></td>
   <td valign="middle"><strong>팔로워수</strong></td>
   <td valign="middle"><strong>비고</strong></td>
   <td valign="middle"><strong>슈퍼패스</strong></td>
   <td valign="middle"><strong>부여한포인트</strong></td>
   <?php if($list2['delivery_point_yn'] == "Y") { ?>
   <td valign="middle"><strong>가용포인트</strong></td>
   <td valign="middle"><strong>배송비 차감</strong></td>
   <td valign="middle"><strong>배송비 POINT 차감</strong></td>
   <?php } ?>
   <? foreach($ask_arr as $val) {?>
   	<th width="200"><?=$val?></th>
   <? } ?>
   <? foreach($multiple_arr as $val) {?>
   	<th width="200"><?=$val?></th>
   <? } ?>
   <? foreach($single_arr as $val) {?>
   	<th width="200"><?=$val?></th>
   <? } ?>
   <? if($list2['hero_type'] != "1") { ?>
   <td valign="middle"><strong>콘텐츠 동의</strong></td>
   <? } ?>
   <td valign="middle"><strong>등록일</strong></td>
   <td valign="middle"><strong>선택여부</strong></td>
    </tr>
<?
	while($list = @mysql_fetch_array($out_sql)){
		
		//print_r($list);
		
		 if(!strcmp($list['lot_01'], '1')) $list['lot_01'] = '후기등록가능자';
		 else $list['lot_01'] = '';
		 
		 if($list['hero_jumin']) $age = date('Y')-substr($list['hero_jumin'],0,4)+1;
         else					 $age = '';
         
         if(!empty($ask_arr)) $ask_answer_arr = explode("/////",$list["hero_03"]);
         if(!empty($multiple_arr)) $multiple_answer_arr = explode("/////",$list["user_multiple"]);
         if(!empty($single_arr)) $single_answer_arr = explode("/////",$list["user_single"]);
		 		 
		 $possible_point = $list["total_point"]-$list["order_point"];
		 
		 if($list['hero_type'] != 2) { 
			$url_arr = explode(",",$list['hero_01']);
		
			//$url_cnt = count($url_arr); //20201228 이전에는 url 항목 열로 노출됨
			$url = "";
			//for($i=0; $i<$url_cnt; $i++) {
								
				//if($i != 0 ) $url .= "</tr><tr>";
				$z = 0;
				foreach($url_arr as $val) {
					$url 	.= "<td align='center' valign='middle'><a href='".$val."'>".$val."</a></td>";
					$z++;
				}
				
				//if($i==0) {
					$memo = $list['hero_memo_02']."<br style='mso-data-placement:same-cell;'>".$list['hero_memo_03']."<br style='mso-data-placement:same-cell;'>".$list['hero_memo_04'];
					$url .= "
						   <td align='center' valign='middle'>".$list['hero_memo']."</td>
						   <td align='center' valign='middle'>".$list['hero_memo_01']."</td>
						   <td align='center' valign='middle'>".$list['hero_insta_cnt']."</td>
						   <td align='center' valign='middle'>".
                                     nl2br($list['hero_memo_02']).
                                     "<br style='mso-data-placement:same-cell;'>".
                                     nl2br($list['hero_memo_03']).
                                     "<br style='mso-data-placement:same-cell;'>".
                                     nl2br($list['hero_memo_04']).
							"</td>

						   <td align='center' valign='middle'>".$list['hero_superpass']."</td>
						   <td align='center' valign='middle'>".$list['sum_point']."</td>";
                   if($list2['delivery_point_yn'] == "Y") {
                   	
                   	$url .= "<td align='center' valign='middle'>".$possible_point."</td>";
                   	$url .= "<td align='center' valign='middle'>".$list["delivery_point_cnt"]."</td>";
                   	
                   	$delivery_p = "아니오";
                   	if( $list['delivery_point_yn'] == "Y" ) $delivery_p = "예";
                   		$url .= "<td align='center' valign='middle'>".$delivery_p."</td>";
                    }
                   
                    foreach($ask_answer_arr as $val) {
                   		$url .= "<td align='center' valign='middle'>".$val."</td>";
                    }
                    
                    foreach($multiple_answer_arr as $val) {
                    	$url .= "<td align='center' valign='middle'>".$val."</td>";
                    }
                    
                    foreach($single_answer_arr as $val) {
                    	$url .= "<td align='center' valign='middle'>".$val."</td>";
                    }
                    if($list2["hero_type"] != "1") {
                    	$url .= "<td align='center' valign='middle'>".($list["hero_agree"] == "Y" ? "동의":"미동의")."</td>";
                    }

                    $url .= "
						   <td align='center' valign='middle'>".date( "Y-m-d", strtotime($list['hero_today']))."</td>
                           <td align='center' valign='middle'>".$list['lot_01']."</td>";
				//}
				
			//} 
		}
		 
?>
  <tr align="left">
   <td align="center" valign="middle"><?=$numb?></td>
   <td align="center" valign="middle"><?=$list['hero_title'];?></td>
   <td align="center" valign="middle"><?=$list['mission_title'];?></td>
   <td align="center" valign="middle"><?=$list['hero_name'];?></td>
   <td align="center" valign="middle"><?=nl2br($list['hero_new_name']);?></td>
   <td align="center" valign="middle"><?=$list['hero_id'];?></td>
   <td align="center" valign="middle"><?=$list['hero_nick'];?></td>
    <td align="center" valign="middle"><?=$list['hero_sex'];?></td>
   <td align="center" valign="middle"><?=$age;?></td>
   <td align="center" valign="middle"><?=$list['hero_level'];?></td>
   <td align="center" valign="middle"><?=$list['hero_oldday'];?></td>
   <td align="center" valign="middle"><?=$list['hero_mail'];?></td>
   <td align="center" valign="middle"><?=nl2br($list['hero_hp_01']);?>-<?=nl2br($list['hero_hp_02']);?>-<?=nl2br($list['hero_hp_03']);?></td>
   <td align="center" valign="middle"><?=nl2br($list['hero_address_01']);?></td>
   <td align="center" valign="middle"><?=nl2br($list['hero_address_02']);?> <?=nl2br($list['hero_address_03']);?></td>
   <? if($list['hero_type'] == 2) { ?>
	   <td align="center" valign="middle"><?=$list['hero_04'];?></td>
	   
	   <td align="center" valign="middle"><?=$list['hero_memo'];?></td>
	   <td align="center" valign="middle"><?=$list['hero_memo_01'];?></td>
	   <td align="center" valign="middle"><?=$list['hero_insta_cnt'];?></td>
	   <td align="center" valign="middle">
		    <?
		   		echo nl2br($list['hero_memo_02']);
				echo "<br style='mso-data-placement:same-cell;'>";
				echo nl2br($list['hero_memo_03']);
				echo "<br style='mso-data-placement:same-cell;'>";
				echo nl2br($list['hero_memo_04']);
	   		?>
	   </td>
	   <td align="center" valign="middle"><?=$list['hero_superpass'];?></td>
	   <td align="center" valign="middle"><?=$list['sum_point'];?></td>
	   <td align="center" valign="middle"><?=$list['hero_agree']=="Y" ? "동의":"미동의";?></td>
	   <td align="center" valign="middle"><?=date( "Y-m-d", strtotime($list['hero_today']));?></td>
	   <td align="center" valign="middle"><?=$list['lot_01'];?></td>
   <? 
   }else { 
   		echo $url;
   } 
   ?>
   
  </tr>
<?php
		$numb++;
	}//end while
?>
</table>
