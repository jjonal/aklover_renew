<? 
ini_set('allow_url_fopen', 'On');
//AK 러버 유튜버만 사용
if($_GET['board'] == "group_04_27") {
	//$youtubeKey = "AIzaSyBwEy_tUBRG54yJ3dGTkfCPZPsNtg8l-hU"; //수영 프로젝트 : 러버테스트
	$youtubeKey = "AIzaSyALKnqAlGVC6FKKcfSPNMBlYvX-IEv3hlQ";//운영
	
	$sql_youtube = " SELECT url, hero_nick, channel_name FROM youtube_gisu WHERE gisu = '1' ";
	sql($sql_youtube, 'on');
	
	echo $sql_youtube."test group_04_27";
	/*
	$urlTest = "https://www.googleapis.com/youtube/v3/channels?part=statistics,snippet&id=UCnet5iP8ZI2gaZiq1dX86UQ&key=".$youtubeKey;
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $urlTest);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	$contents = curl_exec($ch);
	curl_close($ch);
	$youtube_test = json_decode($contents,true);
	echo $youtube_test;
	*/
	
	
	
			
?>
<div class="youtuberListWrap">
	<ul class="youtuberList">
		<? 
		$ch = curl_init();
		while($youtube_list = @mysql_fetch_assoc($out_sql)){
				$channel_id = substr(strrchr($youtube_list["url"], '/'), 1);
				$youtube_url = "https://www.googleapis.com/youtube/v3/channels?part=statistics,snippet&id=".$channel_id."&key=".$youtubeKey;
				
				//$youtube_json = file_get_contents($youtube_url);
				curl_setopt ($ch, CURLOPT_URL, $youtube_url);
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
				$youtube_json = curl_exec($ch);
				$youtube_data = json_decode($youtube_json,true);
				
				//$channel_id = $youtube_data["items"][0]["id"];
				$thumbnail = $youtube_data["items"][0]["snippet"]["thumbnails"]["default"]["url"];
				
				//$tit = iconv("utf-8", "euc-kr",$youtube_data["items"][0]["snippet"]["title"]);
				$hero_nick = $youtube_list["hero_nick"];
				$channel_name = $youtube_list["channel_name"];
				//$subscriber = number_format($youtube_data["items"][0]["statistics"]["subscriberCount"]);
				
		?>
		<li>
			<a href="https://www.youtube.com/channel/<?=$channel_id;?>" target="_blank">
				<dl>
					<dt><img src="<?=$thumbnail?>" alt="" /></dt>
					<dd>
						<p class="tit"><?=$hero_nick?></p>
						<p class="subscriber"><?=$channel_name?></p>
						<p class="icon"><img src="/image/icon_youtuber.png" alt="icon youtube"/> 구독</p>
					</dd>
				</dl>
			</a>
		</li>
		<? }
		curl_close($ch);
		?>
	</ul>
</div>
<? } ?>