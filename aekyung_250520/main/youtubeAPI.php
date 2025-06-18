<?
/*//CURL
$listId = $_POST['listId'];

$youtubeKey = "AIzaSyBkhHLDoZdNub2vv7h2jDLS0gEmGmXIuOk";

//유튜브
$youtubeApi = "https://www.googleapis.com/youtube/v3/playlistItems"; //사용할 API url
$youtubeApi .= "?part=snippet";
$youtubeApi .= "&maxResults=10";
$youtubeApi .= "&playlistId=".$listId;
$youtubeApi .= "&key=".$youtubeKey;//(API_KEY에 발급받은 KEY를 넣자)

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, "My User Agent" );
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

curl_setopt($ch, CURLOPT_URL, $youtubeApi);
$result = curl_exec($ch);

curl_close($ch);

echo json_encode($result);*/

$listId = $_POST['listId'];

$youtubeKey = "AIzaSyBkhHLDoZdNub2vv7h2jDLS0gEmGmXIuOk";

//유튜브
$youtubeApi = "/youtube/v3/playlistItems";
$youtubeApi .= "?part=snippet";
$youtubeApi .= "&maxResults=10";
$youtubeApi .= "&playlistId=".$listId;
$youtubeApi .= "&key=".$youtubeKey;

$host = "www.googleapis.com";
$fp = fsockopen("ssl://".$host, 443, $errno, $errstr, 30);

if (!$fp) {
    echo json_encode(array("error" => "$errno - $errstr"));
} else {
    $out = "GET " . $youtubeApi . " HTTP/1.1\r\n";
    $out .= "Host: " . $host . "\r\n";
    $out .= "User-Agent: My User Agent\r\n";
    $out .= "Connection: Close\r\n\r\n";

    fwrite($fp, $out);
    $response = '';
    while (!feof($fp)) {
        $response .= fgets($fp, 128);
    }
    fclose($fp);

    // 헤더와 본문 분리
    list($header, $body) = explode("\r\n\r\n", $response, 2);
    $body = substr($body,5);
    echo $body; // json_encode 제거
}
?>