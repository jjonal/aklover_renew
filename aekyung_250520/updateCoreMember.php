<?
define('_HEROBOARD_', TRUE);
include_once '/home/users/aekyung/freebest/head.php';
include_once '/home/users/aekyung/freebest/hero.php';
include_once '/home/users/aekyung/freebest/function.php';
db("aekyung");


/**********************************
* 날짜: 20170126 
* 작성자: 나아론
* 핵심인력 조건 확인 후 업데이트
* 조건 
	(3개 모두 충족하고)
	- 접속기록 일주일 이내 //170511 조건제외
	- 게시글 일주일 이내
	- 블로그 URL 有
	(아래 옵션 중 하나 충족)
	- 블로그 컨텐츠 '상'
	- 우수후기 1회이상 선정 기록 // 170510 조건 제외
	- 일방문자 1500이상

* 기존은 로그인할때 체크했지만 20170511 기준 스케쥴러로 변경
***********************************/
//2017.05.17 한달전으로 변경
//2017.06.29 세달전으로 변경
$oneWeekAgo = date("Y-m-d",strtotime("-3 month"));

/*
$sql1 = "select count(a.hero_name) cn from (
	select count(*) cnt, hero_name from board where hero_today  >= NOW() -  INTERVAL 3 MONTH  and
	hero_table in ('group_02_02','group_03_03','group_04_09','group_04_07','group_04_06','group_04_23','group_04_05','group_04_10')
	group by hero_code order by cnt desc
	) a";
*/
/*
$sql1 = "select count(b.hero_name) cn from(
			select sum(cnt) cnt, a.hero_name,a.hero_code from(
				
				select count(*) cnt, hero_name,hero_code from review where hero_today  >= NOW() -  INTERVAL 3 MONTH  and
				hero_table in ('group_02_03','group_04_03','group_02_02','group_03_03','group_03_05','group_04_24','group_01_01')
				group by hero_code 
				
				union all
				
				select count(*) cnt, hero_name,hero_code from board where hero_today  >= NOW() -  INTERVAL 3 MONTH  and
				hero_table in ('group_02_02','group_03_03','group_04_09','group_04_07','group_04_06','group_04_23','group_04_05','group_04_10')
				group by hero_code 
				
			) a
			group by hero_code order by cnt desc
		) b";
		
$res = new_sql($sql1,$error,"on");
$rs = @mysql_fetch_assoc($res);
$cnt = round($rs['cn'] * 1);
echo $cnt;
*/
/*
$sql2 = "select count(*) cnt, hero_name, hero_code from board where hero_today  >= NOW() -  INTERVAL 3 MONTH  
and hero_table in ('group_02_02','group_03_03','group_04_09','group_04_07','group_04_06','group_04_23','group_04_05','group_04_10')
group by hero_code order by cnt desc limit 0, {$cnt}";
*/
/*
$sql2 = "
			select sum(cnt) cnt, a.hero_name, a.hero_code from(
				
				select count(*) cnt, hero_name,hero_code from review where hero_today  >= NOW() -  INTERVAL 3 MONTH  and
				hero_table in ('group_02_03','group_04_03','group_02_02','group_03_03','group_03_05','group_04_24','group_01_01')
				group by hero_code 
				
				union all
				
				select count(*) cnt, hero_name,hero_code from board where hero_today  >= NOW() -  INTERVAL 3 MONTH  and
				hero_table in ('group_02_02','group_03_03','group_04_09','group_04_07','group_04_06','group_04_23','group_04_05','group_04_10')
				group by hero_code 
				
			) a
			group by hero_code order by cnt desc limit 0, {$cnt}
";
$res2 = mysql_query($sql2) or die(mysql_error());  
*/

$sql1 = "SELECT COUNT(*) cnt, hero_code FROM board WHERE hero_today  >= NOW() -  INTERVAL 3 MONTH 
		AND hero_table IN ('group_02_02','group_03_03','group_04_09','group_04_07','group_04_06','group_04_23','group_04_05','group_04_10')
		GROUP BY hero_code";
//$sql1 = "SELECT hero_code FROM `member` WHERE hero_use=0";
$res = mysql_query($sql1) or die(mysql_error());  
$i = 0;
$chechk = "";
while($rs = mysql_fetch_array($res)){
	$chk = false;
	
	// 게시글 일주일 이내 확인
	/*
	$core_member_check = "SELECT COUNT(*) AS cnt FROM board WHERE hero_today>='".$oneWeekAgo."' AND hero_code = '".$rs["hero_code"]."' and hero_table in ('group_02_02','group_03_03','group_04_09','group_04_07','group_04_06','group_04_23','group_04_05','group_04_10')";
	$core_member_check_res = new_sql($core_member_check,$error,"on");
	$core_member_check_rs  = @mysql_fetch_assoc($core_member_check_res);
	*/
	/*
	$core_member_check2 = "SELECT COUNT(*) AS cnt FROM review WHERE hero_today>='".$oneWeekAgo."' AND hero_code = '".$rs["hero_code"]."' and hero_table in ('group_02_03','group_04_03','group_02_02','group_03_03','group_03_05','group_04_24','group_01_01')";
	$core_member_check_res2 = new_sql($core_member_check2,$error,"on");
	$core_member_check_rs2  = @mysql_fetch_assoc($core_member_check_res2);
	*/
	
	// 인스타그램 URL, 방문자수, 컨텐츠 등급
	$core_member_login_check = "SELECT hero_code, hero_blog_04, hero_memo, hero_memo_01, hero_core_member, hero_nick FROM member WHERE hero_code = '".$rs["hero_code"]."'";
	$core_member_login_check_res = new_sql($core_member_login_check,$error,"on");
	$core_member_login_check_rs  = @mysql_fetch_assoc($core_member_login_check_res);
	
	// 인스타그램 확인
	if($core_member_login_check_rs['hero_blog_04']) {
		// 우수후기 기록이 있는지 확인
		// 170510 조건제외
		//$core_member_best_check = "SELECT COUNT(*) AS cnt FROM BOARD WHERE hero_code = '".$_SESSION['temp_code']."' AND hero_board_three = 1 ";
		//$core_member_best_check_res = new_sql($core_member_best_check,$error,"on");
		//$core_member_best_check_rs  = @mysql_fetch_assoc($core_member_best_check_res);

		// 핵심인력으로 업데이트
		if($core_member_login_check_rs['hero_memo'] >= 1500 || $core_member_login_check_rs['hero_memo_01'] == "상")  {
			// 핵심인력이 N 이였던 회원만 update
			$i++;
			$chechk .= $core_member_login_check_rs['hero_nick']."<br/>";
			if($core_member_login_check_rs['hero_core_member'] == "N") {
				//$update_core_member = "UPDATE member SET hero_core_member = 'Y' WHERE hero_code = '".$rs["hero_code"]."'";
				//$update_core_member_res = new_sql($update_core_member,$error);
			}
			$chk = true;
		}
	}
	
	// 핵심인력 조건 미충족				   
	if(!$chk) {
		// 핵심인력 Y 이였던 회원만 업데이트
		if($core_member_login_check_rs['hero_core_member'] == "Y") {
			//$update_core_member2 = "UPDATE member SET hero_core_member = 'N' WHERE hero_code = '".$rs["hero_code"]."'";
			//$update_core_member2_res = new_sql($update_core_member2,$error);
		}
	}
}
echo "완료".$i."</br>";
echo $chechk;

?>