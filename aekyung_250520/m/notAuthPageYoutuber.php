<? 
//AK 러버 유튜버만 사용
if($_GET['board'] == "group_04_27") {
	//$youtubeKey = "AIzaSyBwEy_tUBRG54yJ3dGTkfCPZPsNtg8l-hU"; //수영 프로젝트 : 러버테스트
	$youtubeKey = "AIzaSyALKnqAlGVC6FKKcfSPNMBlYvX-IEv3hlQ";//운영
	
	$sql_youtube = " SELECT url, hero_nick, channel_name FROM member_gisu WHERE hero_board in ('group_04_27','group_04_31') AND gisu in  ('10','3') AND url_gubun = 'youtube' ORDER BY memo desc  ";
	sql($sql_youtube, 'on');
?>
<div class="youtuberListWrap">
	<ul class="youtuberList">
		<? 
		$ch = curl_init();
		while($youtube_list = @mysql_fetch_assoc($out_sql)){
				$channel_id = substr(strrchr($youtube_list["url"], '/'), 1);
				$youtube_url = "https://www.googleapis.com/youtube/v3/channels?part=statistics,snippet&id=".$channel_id."&key=".$youtubeKey;
				
				$youtube_json = file_get_contents($youtube_url);
				//curl_setopt ($ch, CURLOPT_URL, $youtube_url);
				//curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
				//$youtube_json = curl_exec($ch);
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
		//curl_close($ch);
		?>
		<li>
			<a href="https://www.tiktok.com/@unpreess" target="_blank">
				<dl>
					<dt><img src="/image2/unpreess_tiktok.png" alt="" /></dt>
					<dd>
						<p class="tit">unp</p>
						<p class="subscriber">unpreess 언프리</p>
						<p class="icon"><img src="/image2/img_tiktok01.png" alt="icon tictolk" width="30"> 팔로잉</p>
					</dd>
				</dl>
			</a>
		</li>
	</ul>
</div>
<? } ?>