<?php 
if(!defined('_HEROBOARD_'))exit;
?>

<?php 
	if(!is_numeric($_GET['user_idx'])) exit;

	$user_idx = $_GET['user_idx'];
	$this_year = date('Y');
?>

<?php 
	$select = "select A.hero_idx, A.hero_id, A.hero_nick, A.hero_name, A.hero_today, (".$this_year."-left(A.hero_jumin,4)+1) as hero_birth, A.hero_address_01, A.hero_address_02, A.hero_address_03, A.hero_level, A.hero_blog_00, A.hero_blog_01, A.hero_blog_02, A.hero_blog_03, A.hero_blog_04, A.hero_blog_05, A.hero_memo, A.hero_memo_01, A.hero_memo_02, A.hero_memo_03, A.hero_memo_04, A.hero_user, B.sum_point, C.sum_total_point from member as A ";
    $select .= "inner join (select hero_code, sum(hero_point) as sum_point from point where hero_today > '2014-09-10 22:23:32' group by hero_code) as B on A.hero_code=B.hero_code ";
    $select .= "inner join (select hero_code, sum(hero_point) as sum_total_point from point where 1=1 group by hero_code) as C on A.hero_code=C.hero_code ";
    $select .= "where A.hero_use=0 and hero_idx=".$user_idx;
    //echo $select;
	$res = mysql_query($select) or die("<script>alert('시스템 에러입니다. 다시 시도해 주세요.');</script>");
	$rs = mysql_fetch_assoc($res);
	//    
	// 아이디, 닉네임, 이름, 연령, 레벨, 주소, 블로그url, 블로그 방문자수, 컨텐츠 등급, 페널티 여부, 결혼여부, 총포인트, 가용 포인트,가입일, 가입경로,포인트 적립내역, 작성글 확인 
	switch($rs['hero_excuse_check']){
		case 0 : $hero_excuse_check = "신문"; break;
		case 1 : $hero_excuse_check = "잡지"; break;
		case 2 : $hero_excuse_check = "블로그"; break;
		case 3 : $hero_excuse_check = "카페"; break;
		case 4 : $hero_excuse_check = "지인"; break;
		case 5 : $hero_excuse_check = "기타 : "; $hero_excuse_path = $rs['hero_excuse_path']; break;
		case 6 : $hero_excuse_check = "쪽지"; break;
	}
?>
<div id="detailArea">
	<table>
		<tr>	
			<td colspan='13' style="text-align: center;font-size: 15px;font-weight: 800;padding: 15px;">
				기본정보
			</td>
		</tr>
		<tr>
			<th style="width:5%;">아이디</th>
			<td><?=$rs['hero_id']?></td>
			<th style="width:5%;">닉네임</th>
			<td><?=$rs['hero_nick']?></td>
			<th style="width:5%;">이름</th>
			<td><?=$rs['hero_name']?></td>
			<th style="width:5%;">나이</th>
			<td style="width:10%;"><?=$rs['hero_birth']?></td>
			<th style="width:6%;">결혼여부</th>
			<td style="width:5%;">no data</td>
			<th style="width:5%;">주소</th>
			<td style="width:20%;"><?=$rs['hero_address_01']?> <?=$rs['hero_address_02']?> <?=$rs['hero_address_03']?></td>
		</tr>
		
		<tr>
			<th>레벨</th>
			<td><?=$rs['hero_level']?></td>
			<th>블로그 URL</th>
			<td colspan='3'>
				<?=($rs['hero_blog_00'])? $rs['hero_blog_00']."<br/>": ""; ?> <?=($rs['hero_blog_01'])? $rs['hero_blog_01']."<br/>": ""; ?> <?=($rs['hero_blog_02'])? $rs['hero_blog_02']."<br/>": ""; ?><?=($rs['hero_blog_03'])? $rs['hero_blog_03']."<br/>": ""; ?><?=$rs['hero_blog_04']?>
			</td>
			<th>방문자수</th>
			<td>
				<?php 
					switch ($rs['hero_memo']){
						
						case 200 : echo "200명 이하";break;
						case 800 : echo "201명 ~ 800명";break;
						case 1500 : echo "800명 ~ 1500명";break;
						case 3000 : echo "1500명 ~ 3000명";break;
						case 4000 : echo "3000명 ~ 4000명";break;
						case 10000 : echo "4000명 ~ 10000명";break;
						case 10001 : echo "10001명 이상";break;
						
					}
				?>
			</td>
			<th>컨텐츠 등급</th>
			<td>
    			<?=$rs['hero_memo_01']?>
			</td>
			<th >패널티</th>
			<td clospan=3>
				<?=($rs['hero_memo_02'])? $rs['hero_memo_02']."<br/>" : "" ;?>
				<?=($rs['hero_memo_03'])? $rs['hero_memo_03']."<br/>" : "" ;?>
				<?= $rs['hero_memo_04']?>
			</td>
		</tr>
		<tr>
			<th>총포인트</th>
			<td><?=$rs['sum_total_point']?></td>
			<th>가용포인트</th>
			<td><?=$rs['sum_point']?></td>
			<th>가입일</th>
			<td><?=$rs['hero_today']?></td>
			<th>가입경로</th>
			<td><?=$hero_excuse_check.$hero_excuse_path?></td>
			<th>추천인</th>
			<td><?=$rs['hero_user']?></td>
			<td></td>
			<td><div class="btn" onclick="location.href='<?=ADMIN_DEFAULT?>/index.php?board=<?=$_GET['board']?>&idx=<?=$_GET['idx']?>&view=<?=$_GET['view']?>&user_idx=<?=$_GET['user_idx']?>&mode=point'" style="cursor:pointer">적립 포인트 확인</div>
				<div class="btn" onclick="location.href='<?=ADMIN_DEFAULT?>/index.php?board=<?=$_GET['board']?>&idx=<?=$_GET['idx']?>&view=<?=$_GET['view']?>&user_idx=<?=$_GET['user_idx']?>&mode=write'" style="cursor:pointer">작성글 확인</div></td>
		</tr>
		
	</table>
	
</div>

<?php 
	if($_GET['mode']=="point" || !$_GET['mode']){

?>
<div id="resultArea">
			
	<table>
		<tr>
			<td colspan='10' style="text-align: center;font-size: 15px;font-weight: 800;padding: 15px;">적립 포인트 내역</td>
		</tr>
		<tr>
			<th>NO</th>
			<th>아이디</th>
			<th>닉네임</th>
			<th>이름</th>
			<th>포인트</th>
			<th>타입</th>
			<th>카테고리</th>
			<th>일자</th>
			<th>글제목, 댓글내용</th>
			<th>페이지 확인</th>
		</tr>
<?php 
		
		$list_page 		= 30;
		$page_per_list 	= 10;
		$start			= 0;
		
		
		$next_path="board=".$_GET['board']."&idx=".$_GET['idx']."&view=".$_GET['view']."&user_idx=".$_GET['user_idx']."&mode=".$_GET['mode'];
		
		$count_sql = "select count(*) from member as A right outer join point as B on A.hero_code=B.hero_code where A.hero_idx=".$user_idx;
		$count_res = mysql_query($count_sql) or die("<script>alert('시스템 에러입니다. 다시 시도해주세요.');</script>");
		$total_data = mysql_result($count_res,0,0);

		if($_GET['page']){
			$page = $_GET['page'];
			$NO = $total_data-(($_GET['page']-1)*$list_page);
		}else{
			$page = 1;
			$NO = $total_data;
		}
		$start = ($page-1)*$list_page;
		
		$point_sql = "select A.hero_id, A.hero_nick, A.hero_name, B.hero_table, B.hero_old_idx, B.hero_review_idx, B.hero_top_title, B.hero_title, B.hero_point,B.hero_today, left(C.hero_command,20) as hero_command ";
		$point_sql .= "from member as A right outer join point as B on A.hero_code=B.hero_code ";
		$point_sql .= "left outer join review as C on C.hero_idx=B.hero_review_idx ";
		$point_sql .= "where A.hero_idx=".$user_idx." order by B.hero_today desc limit ".$start.", ".$list_page;
		//echo $point_sql;
		$point_res = mysql_query($point_sql) or die("<script>alert('시스템 에러입니다. 다시 시도해주세요.');</script>");
		while($point_rs = mysql_fetch_assoc($point_res)){
			
			if($point_rs['hero_old_idx'] && !$point_rs['hero_review_idx']){															
				$type = "글 등록"; 
				$command = 	$point_rs['hero_title'];
				$link = "<a href='/main/index.php?board=".$point_rs['hero_table']."&next_board=".$point_rs['hero_table']."&page=1&view=view&idx=".$point_rs['hero_old_idx']."' target='_blank'>확인</a>";			
			}elseif($point_rs['hero_old_idx'] && $point_rs['hero_review_idx']){														
				$type = "댓글"; 
				$command = $point_rs['hero_command'];
				$link = "<a href='/main/index.php?board=".$point_rs['hero_table']."&next_board=".$point_rs['hero_table']."&page=1&view=view&idx=".$point_rs['hero_old_idx']."' target='_blank'>확인</a>";
			}elseif(!$point_rs['hero_old_idx'] && !$point_rs['hero_review_idx'] && $point_rs['hero_top_title']=="출석체크"){			
				$type = "출석";
				$command="";
				$link = "";
			}elseif(!$point_rs['hero_old_idx'] && !$point_rs['hero_review_idx'] && $point_rs['hero_top_title']=="월출석개근"){			
				$type = "개근";
				$command="";
				$link = "";
			}
			
			
?>
		<tr>
			<td><?=$NO?></td>
			<td><?=$point_rs['hero_id']?></td>
			<td><?=$point_rs['hero_nick']?></td>
			<td><?=$point_rs['hero_name']?></td>
			<td><?=$point_rs['hero_point']?></td>
			<td><?=$type?></td>
			<td><?=$point_rs['hero_top_title']?></td>
			<td><?=$command?></td>
			<td><?=$point_rs['hero_today']?></td>
			<td><?=$link?></td>
		</tr>
<?php 
			$NO--;
		}
		
?>
	</table>	
	<div style="width:98%;"><? include PATH_INC_END.'page.php';?></div>
</div>
<?php }?>

<?php 
	if($_GET['mode']=="write"){
?>
		<div id="resultArea">
			
			<table>
				<tr>
					<td colspan='11' style="text-align: center;font-size: 15px;font-weight: 800;padding: 15px;">작성글, 덧글 내역</td>
				</tr>
				<tr>
					<th>NO</th>
					<th>아이디</th>
					<th>닉네임</th>
					<th>이름</th>
					<th>타입</th>
					<th>카테고리</th>
					<th>글제목, 댓글내용</th>
					<th>추천수</th>
					<th>일자</th>
					<th>페이지 확인</th>
				</tr>
				
				<?php 
		
					$list_page 		= 30;
					$page_per_list 	= 10;
					$start			= 0;
					
					
					$next_path="board=".$_GET['board']."&idx=".$_GET['idx']."&view=".$_GET['view']."&user_idx=".$_GET['user_idx']."&mode=".$_GET['mode'];
					
					$count_sql = "select count(*) from (select A.hero_idx from member as A right outer join board as B on A.hero_code=B.hero_code where A.hero_idx=".$user_idx." ";
					$count_sql .= "union all select C.hero_idx from member as C right outer join review as D on C.hero_code=D.hero_code where C.hero_idx=".$user_idx.") as E";
					//echo $count_sql;
					$count_res = mysql_query($count_sql) or die("<script>alert('시스템 에러입니다. 다시 시도해주세요.');</script>");
					$total_data = mysql_result($count_res,0,0);
			
					if($_GET['page']){
						$page = $_GET['page'];
						$NO = $total_data-(($_GET['page']-1)*$list_page);
					}else{
						$page = 1;
						$NO = $total_data;
					}
					$start = ($page-1)*$list_page;
					
					$write_sql = "select * ";
					$write_sql .= "from (select B.hero_idx, A.hero_id, A.hero_nick, A.hero_name, B.hero_table, B.hero_title, B.hero_today, B.hero_rec from member as A right outer join board as B on A.hero_code=B.hero_code where A.hero_idx=".$user_idx." ";
					$write_sql .= "union all select D. hero_old_idx as hero_idx, C.hero_id, C.hero_nick, C.hero_name, D.hero_table, left(D.hero_command,20) as hero_title, D.hero_today,-1 from member as C right outer join review as D on C.hero_code=D.hero_code where C.hero_idx=".$user_idx.") as E ";
					$write_sql .= "order by E.hero_today desc limit ".$start.", ".$list_page;
					//echo $write_sql;
					$write_res = mysql_query($write_sql) or die("<script>alert('시스템 에러입니다. 다시 시도해주세요.11');</script>");
					while($write_rs = mysql_fetch_assoc($write_res)){
						
						if($write_rs['hero_rec']!=-1){															
							$type = "글 작성";
							$hero_rec =  $write_rs['hero_rec'];
						}elseif($write_rs['hero_rec']==-1){														
							$type = "댓글"; 
							$hero_rec = "";
						}  

						switch ($write_rs['hero_table']){
							case 'group_02_01' : $cate = "오늘하루";break;
							case 'group_02_02' : $cate = "연애&결혼";break;
							case 'group_03_04' : $cate = "러버아이디어";break;
							case 'group_03_05' : $cate = "러버칭찬통";break;
							case 'group_02_05' : $cate = "오프라인방";break;
							case 'group_01_01' : $cate = "꽃미녀팁";break;
							case 'group_01_02' : $cate = "똑순이팁";break;
							case 'group_01_03' : $cate = "미식가팁";break;
							case 'group_01_04' : $cate = "문화가팁";break;
							case 'group_04_11' : $cate = "블로그팁";break;
							case 'group_04_05' : $cate = "일반미션";break;
							case 'group_04_06' : $cate = "프리미엄미션";break;
							case 'group_04_07' : $cate = "애경박스";break;
							case 'group_04_08' : $cate = "AK기자단";break;
							case 'group_04_09' : $cate = "생생후기";break;
							case 'group_04_10' : $cate = "러버스타";break;
						}
						
						
				?>
				
						<tr>
							<td><?=$NO?></td>
							<td><?=$write_rs['hero_id']?></td>
							<td><?=$write_rs['hero_nick']?></td>
							<td><?=$write_rs['hero_name']?></td>
							<td><?=$type?></td>
							<td><?=$cate?></td>
							<td><?=$write_rs['hero_title']?></td>
							<td><?=$hero_rec?></td>
							<td><?=$write_rs['hero_today']?></td>
							<td><a href='/main/index.php?board=<?=$write_rs['hero_table']?>&next_board=<?=$write_rs['hero_table']?>&page=1&view=view&idx=<?=$write_rs['hero_idx']?>' target="_blank">확인</a></td>
						</tr>
				
				<?php 
						$NO--;
					}
					
				?>
	</table>	
	<div style="width:98%;"><? include PATH_INC_END.'page.php';?></div>
</div>
<?php }?>


