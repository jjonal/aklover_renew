<?

	define('_HEROBOARD_', TRUE);//HEROBOARD오픈
	######################################################################################################################################################
	
	include_once                                '../../freebest/head.php';
	
	if(!$_SESSION['temp_id']){echo '<script>location.href="'.PATH_END.'out.php"</script>';exit;}
	
	if( (!strcmp($_SESSION['temp_level'], '10000')) or (!strcmp($_SESSION['temp_level'], '9999')) ){
		
		include                                     FREEBEST_INC_END.'hero.php';
		include                                     FREEBEST_INC_END.'function.php';
	
		db("aekyung");
		
		if($_POST['mode']=='save' || $_POST['mode']=='update'){
			
			if(!$_POST['id'] || !$_POST['start_date'] || !$_POST['end_date'] || !$_POST['text']){
				echo "<script>alert('잘못된 접근입니다')</script>";
				exit;
			}
					
			$id 		= $_POST['id'];
			$start_date = $_POST['start_date'];
			$end_date 	= $_POST['end_date'];
			//$text2 		= iconv("UTF-8","EUC-KR",$_POST['text']);
			$text		= iconv("UTF-8","EUC-KR",$_POST['text']);
			
			if($_POST['mode']=='save'){
				
				$sql = "insert into events (id,start_date,end_date,text) values ('".time()."','".$start_date."','".$end_date."',replace('".$text."','\n',''))";
			
			}elseif($_POST['mode']=='update'){
				
				$sql = "update events set start_date='".$start_date."',end_date='".$end_date."',text=replace('".$text."','\n','') where id='".$id."'";
				
			}
			
			$pf = mysql_query($sql);
			if($pf!=0)	echo "success";
			elseif($pf==0)	echo "<script>alert('업데이트 오류');</script>";
			
			
		}elseif($_POST['mode']=='del'){
			if(!$_POST['id']){
				echo "<script>alert('잘못된 접근입니다')</script>";
				exit;
			}
			
			$id 		= $_POST['id'];
			
			$sql = "delete from events where id='".$id."'";
			//echo $sql;
				
			$pf = mysql_query($sql);
			if($pf!=0)	echo "success";
			elseif($pf==0)	echo "<script>alert('삭제 오류');</script>";
			
		}
		
	}else{
		echo '<script>alert("권한이 없습니다.")</script>';
		echo '<script>location.href="'.PATH_END.'out.php"</script>';exit;
	}
	
