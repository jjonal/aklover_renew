<?php
/*//CRUL

$type = $_POST['type'];

if($type == 'lover'){
    $instaKey = "IGQWRQTWxMWXFWU01rVGJKWXVxSlFQeE9jNzNJaGhQRFJHRDdtQjBncGJ0Qm9KYTkzX0RtZA2RPRjdXc2g1Q3NlRWctbXVvNDRpZAXQzQ0ZAUNVVlQUtzbzNCeFd4SEVZANFdaV1k3aTVoX0xzT0U4bEJhQWVzZATY4NkkZD";
} else {
    $instaKey = "IGQWRQdGZAGcldXTkdiRG5SRUlTeWlBVDV6ZA0FaUl9ScTJhSURKcXlVR01GNzV6aVE2elM5c1dyWFVib1JweW5xd0R2RXZAualdSR3hYeDdaWUVHS09oT24xQjZAXNEN6cWgwbnlCczdqLVpoN0hVZA2R3RUZApM1ItMkUZD";
}

//인스타그램
$instaApi = "https://graph.instagram.com/me/media?fields=id,caption,media_type,media_url,thumbnail_url,permalink,username&access_token=".$instaKey;

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, "My User Agent" );
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

curl_setopt($ch, CURLOPT_URL, $instaApi);
$result = curl_exec($ch);

curl_close($ch);

echo json_encode($result);*/

$type = $_POST['type'];

if($type == 'lover'){ //AK Lover
    $instaKey = "IGQWRORjBxZADhONVVjV1NTb0FJd0EwRWFibERYT2Q4Q0N3WnJZARll2X20tckRGSEJOS1NyVjMwcjFaZAlJqWWVSaEtIMlF3bkJpUWFpaHR2bk50bF9jaWpFXzk3eDB6aHQ3eTc0TU93Q21pOGJuNWlqcUhCRHlQdTQZD";
} else { //애경산업
    $instaKey = "IGQWRQNUYzUFYtQkJRWDZAsNThFWjJKWER6ODVRcldDamtIV2wybXdrWXpEOTFXRExuZA1BhbzZAwdVpRSkFxWGg1Sk9TQXdmRDJOcEhGLWhnZAGdnTW9jRkNHRTJqMDJzVEdhd0ZAwaHVkZA3pzTkF0SmpPa1lKa2tmQUEZD";
}

// 인스타그램 API URL 설정
$instaApi = "/me/media?fields=id,caption,media_type,media_url,thumbnail_url,permalink,username&access_token=".$instaKey;
$host = "graph.instagram.com";
$port = 443;

// fsockopen을 사용하여 연결 시도
$fp = fsockopen("ssl://".$host, $port, $errno, $errstr, 30);

if (!$fp) {
    // 연결 실패 시 에러 메시지 출력
    echo "ERROR: $errno - $errstr<br />\n";
} else {
    // HTTP GET 요청 작성
    $out = "GET " . $instaApi . " HTTP/1.1\r\n";
    $out .= "Host: " . $host . "\r\n";
    $out .= "User-Agent: My User Agent\r\n";
    $out .= "Connection: Close\r\n\r\n";

    // 요청 전송
    fwrite($fp, $out);

    // 응답 읽기
    $response = '';
    while (!feof($fp)) {
        $response .= fgets($fp, 128);
    }

    // 소켓 닫기
    fclose($fp);

    // HTTP 헤더와 본문 분리
    list($header, $body) = explode("\r\n\r\n", $response, 2);

    // JSON 형식으로 응답 출력
    echo json_encode($body);
}
?>
