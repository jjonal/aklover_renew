

<?php

define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once                                                        '../freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';

	makeNaverSyndicationDocuments(0);
	
	
	//print_r($ping_rs);
	
	
	
function makeNaverSyndicationDocuments($no) {
	/*      * TODO : DB에서 가져온 콘텐츠를 가공하여 네이버 신디케이션 문서를 생성하는 함수 작성      */

	$per_doc = 5;
	$limit = $per_doc * $no;

	db("aekyung");


	$sql_c = "select count(*) as count from board where ";
	$sql_c .= "(hero_table='group_01_01' or hero_table='group_01_02' or hero_table='group_01_03' or hero_table='group_01_04' or hero_table='group_04_05' or hero_table='group_04_07' or hero_table='group_04_09' or hero_table='group_04_10') ";
	$sql_c .= "and hero_use=1 and left(hero_today,10)='".date('Y-m-d',time())."' ";
	$sql_c .= "order by hero_today desc limit ".$limit.",".$per_doc."";
	//echo $sql_c;
	$sql_c_res = mysql_query($sql_c) or die("쿼리 오류!!");
	$sql_c_rs = mysql_fetch_assoc($sql_c_res);


	if($sql_c_rs['count']>$limit){

		$sql = "select * from board where ";
		$sql .= "(hero_table='group_01_01' or hero_table='group_01_02' or hero_table='group_01_03' or hero_table='group_01_04' or hero_table='group_04_05' or hero_table='group_04_07' or hero_table='group_04_09' or hero_table='group_04_10') ";
		$sql .= "and hero_use=1 and left(hero_today,10)='".date('Y-m-d',time())."' ";
		$sql .= "order by hero_today desc limit ".$limit.",".$per_doc."";
		$sql_res = mysql_query($sql) or die("쿼리 오류!!");
	
		$ping_xml_file = "<?xml version='1.0' encoding='utf-8'?>";
		$ping_xml_file .= "<feed xmlns='http://webmastertool.naver.com'>";
		$ping_xml_file .= "	<id>http://www.aklover.co.kr/</id>";
		$ping_xml_file .= "	<title>AEKYUNG SYNDICATION DOCUMENTt</title>";
		$ping_xml_file .= "	<author>";
		$ping_xml_file .= "		<name>UNIPICS</name>";
		$ping_xml_file .= "		<email>joooniii12@unipics.com</email>";
		$ping_xml_file .= "	</author>";
		$ping_xml_file .= "	<updated>".date('c',time())."</updated>";
		$ping_xml_file .= "	<link rel='site' href='http://www.aklover.co.kr' title='AEKYUNG TEST SERVER SYNDICATION DOCUMENT'/>";
	
	
		while($sql_rs = mysql_fetch_assoc($sql_res)){
				
			$hero_today = $sql_rs['hero_today'];
			$hero_today = strtotime($hero_today);
			$hero_today = date('c',$hero_today);
				
			$hero_command = substr($sql_rs['hero_command'],0,2000);
				
			$hero_link = $sql_rs['hero_table'];
				
			switch ($hero_link){
				case 'group_01_01' : $link_title = "꽃미녀팁";
				case 'group_01_02' : $link_title = "똑순이팁";
				case 'group_01_03' : $link_title = "미식가팁";
				case 'group_01_04' : $link_title = "문화가팁";
				case 'group_04_05' : $link_title = "일반미션";
				case 'group_04_07' : $link_title = "애경박스";
				case 'group_04_09' : $link_title = "생생후기";
				case 'group_04_10' : $link_title = "러버스타";
			}
				
			$ping_xml_file .= "	<entry>";
			$ping_xml_file .= "		<id>";
			$ping_xml_file .= "			http://www.aklover.co.kr/main/index.php?board=".$sql_rs['hero_table']."&amp;view=view&amp;idx=".$sql_rs['hero_idx']."";
			$ping_xml_file .= "		</id>";
			$ping_xml_file .= "		<title>";
			$ping_xml_file .= "			<![CDATA[ ".iconv("EUC-KR", "UTF-8", $sql_rs['hero_title'])." ]]>";
			$ping_xml_file .= "		</title>";
			$ping_xml_file .= "		<author>";
			$ping_xml_file .= "			<name>".iconv("EUC-KR", "UTF-8", $sql_rs['hero_nick'])."</name>";
			$ping_xml_file .= "		</author>";
			$ping_xml_file .= "		<updated>".$hero_today."</updated>";
			$ping_xml_file .= "		<published>".$hero_today."</published>";
			$ping_xml_file .= "		<link rel='via' href='http://www.aklover.co.kr/main/index.php?board=".$sql_rs['hero_table']."' title='".iconv("EUC-KR", "UTF-8", $link_title)."'/>";
			$ping_xml_file .= "		<link rel='mobile' href='http://www.aklover.co.kr/m/board_view_01.php?board=".$sql_rs['hero_table']."&amp;hero_idx=".$sql_rs['hero_idx']."'/>";
			$ping_xml_file .= "		<content type='html'>";
			$ping_xml_file .= "			<![CDATA[ ".iconv("EUC-KR", "UTF-8", $hero_command)."]]>";
			$ping_xml_file .= "		</content>";
			$ping_xml_file .= "	</entry>";
			
			
		}
		
		$ping_xml_file .= "</feed>";
		
		$HTTP_RAW_POST_DATA = $ping_xml_file;
			
		$filename = "syndication_document_0".$no.".xml";
		$url = $_SERVER['DOCUMENT_ROOT']."/ak_syndi/".date("Ymd",time());
		$url_com = $_SERVER['DOCUMENT_ROOT']."/ak_syndi/".date("Ymd",time())."/".$filename;
		
		
		if(!is_dir($url)){
			mkdir($url, 0707) or die("폴더 생생 실패");
		}
			
			
		$fp = fopen($url_com,"w+");
		fwrite ( $fp, "$HTTP_RAW_POST_DATA" );
		fclose( $fp );
			
		echo $url_com."<br>";
		
		sendDocumentLocation($no);
		
		if($sql_c_rs['count']>$limit && $no<10){
			$no++;
			makeNaverSyndicationDocuments($no);
		}
			
		return false;
	}


	
}
	
	function sendDocumentLocation($no_i) {     
		// * TODO : 생성한 문서의 위치를 네이버 신디케이션 서버로 전송하는 함수      * "핑 전송 방법" 참고      */ } // 20분 동안 변경된 콘텐츠를 가공하여 네이버 신디케이션 문서를 생성한다. 
		// $db_data = getDocuments("yyyy-mm-dd 00:00:00", "yyyy-mm-dd 00:20:00"); 
		// $ping_xml_file = makeNaverSyndicatonDocuments($db_data); 
		// sendDocumentLocation($ping_xml_file); 
		
		
		$ping_auth_header = "Authorization: AAAAOEj1vlgUUf+NnNWiaia99qPcmC7vLOpVkrdzCRIMi886Fd0ra8u0q7KV2gTcNC1VkyY2UdfKmVOSfdIh8cb8Kzg="; 
		$ping_url = "http%3a%2f%2faklover.co.kr%2fak_syndi%2f".date("Ymd",time())."%2fsyndication_document_0".$no_i.".xml";
		echo $ping_url; 
		$ping_client_opt = array(     
				CURLOPT_URL => "https://apis.naver.com/crawl/nsyndi/v2",     
				CURLOPT_POST => true,     
				CURLOPT_POSTFIELDS => "ping_url=" .$ping_url,     
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_CONNECTTIMEOUT => 10,     
				CURLOPT_TIMEOUT => 10,     
				CURLOPT_HTTPHEADER => array("Host: apis.naver.com", "Pragma: no-cache", "Accept: */*", $ping_auth_header) 
		);
		
		$ping = curl_init(); 
		curl_setopt_array($ping, $ping_client_opt); 
		curl_exec($ping); 
		curl_close($ping);

		//print_r($header);
		
		return false;
	}
?>
