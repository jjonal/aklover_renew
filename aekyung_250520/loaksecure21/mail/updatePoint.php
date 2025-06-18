<?
//개근 데이터 뽑기 위한 테스트 로직
$sql = "SELECT * FROM `point` WHERE hero_top_title='출석체크' and  hero_today>='2014-03-01 00:00:00' and hero_today<='2014-03-31 24:00:00' order by hero_id, hero_today asc";
//$sql = mysql_query($sql);
$i=1;
while($sql_test = @mysql_fetch_assoc($sql)){
	if($hero_id==null){
		//echo "111111111111111";
		$hero_id	= 	$sql_test['hero_id'];
		
	}

	if($hero_id==$sql_test['hero_id']){
		
		if($i==31){
			echo $i."   :   ".$sql_test['hero_id']."   :   ".$sql_test['hero_today']."<br>";
			$insertvalue = "'".$sql_test['hero_code']."','group_04_04',0,0,'".$sql_test['hero_id']."','월출석개근','월출석개근','".$sql_test['hero_name']."','".$sql_test['hero_nick']."',50,'".$sql_test['hero_today']."',0";
			
			$sql_point = "INSERT INTO point (hero_code, hero_table, hero_old_idx, hero_review_idx, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today, hero_use) VALUES (".$insertvalue.")";
			
			//echo $sql_point;
			//mysql_query($sql_point);
			
			$sql_selmemeber = "select hero_point from member where hero_code='".$sql_test['hero_code']."'";
			$sql_selmemeber = mysql_query($sql_selmemeber);
			$sql_selmemeber = @mysql_fetch_assoc($sql_selmemeber);
			
			$pluspoint = $sql_selmemeber['hero_point']+50;
			//echo $pluspoint;

			$sql_member = "UPDATE member set hero_point=".$pluspoint." where hero_code='".$sql_test['hero_code']."'";
			//mysql_query($sql_member);
			//echo $sql_member;
		}		
		$i++;

	}else{
		$i=1;
		//echo $i."   :   ".$sql_test['hero_id']."   :   ".$sql_test['hero_today']."<br>";
		$i++;
	}

	$hero_id	= 	$sql_test['hero_id'];
};
?>