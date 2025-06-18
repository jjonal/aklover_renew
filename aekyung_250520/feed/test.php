<?
ob_start();
header("pragma: no-cache");
header("Content-type: text/xml; charset=utf-8"); 
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
if(!defined('_HEROBOARD_'))exit;
include_once '../freebest/head.php';
include_once FREEBEST_INC_END.'hero.php';
include_once FREEBEST_INC_END.'function.php';
#####################################################################################################################################################
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n"; 
echo "<rss version=\"2.0\">\n";
echo "<channel>";

//넘어오는 변수
$keyWord = urldecode($_REQUEST["keyWord"]);
$subject = urldecode($_REQUEST["subject"]);

//글이 있는가?
$sql= " Select count(*)	 From board as A, mission as B where A.hero_table=B.hero_table and B.hero_keywords like '%".$keyWord."%'";
if($subject){
	$sql .= "and A.hero_title like '%".$subject."%'";
}
$sql .= " and A.hero_01=B.hero_idx";

sql($sql,'on');
if($out_sql){//쿼리 성공
	$count = (int)mysql_result($out_sql,0,0);	
	if($count == 0){
		echo "<title><![CDATA[공개된 게시물이 없습니다.]]></title>\n";
		echo "</channel>\n";//해당 데이터가 없을 경우 종료
		echo "</rss>";
		exit;
	}
}else{
		echo "<title><![CDATA[공개된 게시물이 없습니다.]]></title>\n";
		echo "</channel>\n";//쿼리실패 
		echo "</rss>";
		exit;
}

$LINK = "https://".$_SERVER['HTTP_HOST']."/";
$URL = $LINK."feed/";
echo "<title><![CDATA[애경서포터즈]]></title>\n";
echo "<link><![CDATA[http://".$_SERVER['HTTP_HOST']."]]></link>\n";
echo "<description><![CDATA[애경서포터즈]]></description>\n";
echo "<language><![CDATA[ko]]></language>\n";
echo "<pubDate><![CDATA[".date("D, j M Y H:i:s T",time())."]]></pubDate>\n";
echo "<lastBuildDate><![CDATA[".date("D, j M Y H:i:s T",time())."]]></lastBuildDate>\n";
echo "<docs><![CDATA[".$URL."]]></docs>\n";
echo "<generator><![CDATA[Weblog Editor 2.0]]></generator>\n";
echo "<managingEditor><![CDATA[editor@example.com]]></managingEditor>\n";
echo "<webMaster><![CDATA[webmaster@example.com]]></webMaster>\n";

$sql= " Select A.hero_idx,A.hero_title,A.hero_name,A.hero_nick,A.hero_today,A.hero_hit,A.hero_rec,A.hero_notice,";
$sql .= "A.hero_command,A.hero_review_day,A.hero_img_new,A.hero_thumb,A.hero_hit,A.hero_table  From board as A,mission as B ";
$sql .= " where A.hero_01=B.hero_idx and A.hero_table=B.hero_table and B.hero_keywords like '%".$keyWord."%' ";
if($subject){
	$sql .= " and A.hero_title like '%".$subject."%'";
}
$sql .= " and A.hero_table in ('group_04_05', 'group_04_06', 'group_04_07', 'group_04_08', 'group_04_09') order by A.hero_idx desc";

sql($sql);
$numb=1;
while($list = @mysql_fetch_array($out_sql)){
	$no[$numb]=$list["hero_idx"];
	$title[$numb]=iconv("EUC-KR","UTF-8",stripslashes($list["hero_title"]));
	$entry_date[$numb]=$list["hero_today"];
	//필터링
	$search = array('@<script[^>]*?>.*?</script>@si',
								 '@<style[^>]*?>.*?</style>@siU','@<div[^>]*?>.*?</div>@siU','@<p[^>]*?>.*?</p>@siU');
	#★ RSS의 요약의 플랫팅 ★
	$content = trim(iconv("EUC-KR","UTF-8",$list["hero_command"]));
	$content = html_entity_decode($content);
	//$content = strip_tags($content);
	//$content = preg_replace($search, "", $content);	
	//$content = htmlspecialchars($content);
	//$content = html_entity_decode($content);
	///////////////////////////////////////////////////신규///////////////////////////
	//$content = str_replace("\"","",$content);
	//$content = str_replace("\n","",$content);
	//$content = str_replace("\r","",$content);	
	//$content = str_replace("'","",$content);
	//$content = str_replace(">","",$content);
	//$content = str_replace("<","",$content);
	//$content = str_replace("&nbsp;","",$content);
	
	$contents[$numb]=$content;
	$cnt[$numb]=$list["hero_hit"];
	$filename[$numb]=$list["hero_img_new"];
	$thumb[$numb]=$list["hero_thumb"];
	if($list["hero_thumb"]){
		if(strpos($list["hero_thumb"],"https://")!== false || strpos($list["hero_thumb"],"http://")!== false){
			$images[$numb]= iconv("euc-kr","utf-8",$list["hero_thumb"]);
		}else{
		 	$images[$numb]= $LINK.iconv("euc-kr","utf-8",$list["hero_thumb"]);
		}
	}else{
		if(strpos($list["hero_img_new"],"https://")!== false || strpos($list["hero_img_new"],"http://")!== false){

			$images[$numb]= iconv("euc-kr","utf-8",$list["hero_img_new"]);
		}else{
		 	$images[$numb]= $LINK.iconv("euc-kr","utf-8",$list["hero_img_new"]);
		}	
	}
	$weblink[$numb]=$LINK."main/?board=group_04_09&page=1&view=view&idx=".$list['hero_idx'];
	$numb++;
}


	for ( $i = 1 ; $i < $numb ; $i ++ ) {
		echo"<item>
		<title><![CDATA[".$title[$i]."]]></title>
		<link><![CDATA[".$weblink[$i]."]]></link>
		<description><![CDATA[".$contents[$i]."]]></description>
		<pubDate><![CDATA[".$entry_date[$i]."]]></pubDate>
		<image><![CDATA[".$images[$i]."]]></image>
		<guid><![CDATA[".$no[$i]."]]></guid>
		</item>";
	}//end for


echo "</channel>";
echo "</rss>";
?>