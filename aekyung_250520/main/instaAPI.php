<?php
/*//CRUL

$type = $_POST['type'];

if($type == 'lover'){
    $instaKey = "IGQWRQTWxMWXFWU01rVGJKWXVxSlFQeE9jNzNJaGhQRFJHRDdtQjBncGJ0Qm9KYTkzX0RtZA2RPRjdXc2g1Q3NlRWctbXVvNDRpZAXQzQ0ZAUNVVlQUtzbzNCeFd4SEVZANFdaV1k3aTVoX0xzT0U4bEJhQWVzZATY4NkkZD";
} else {
    $instaKey = "IGQWRQdGZAGcldXTkdiRG5SRUlTeWlBVDV6ZA0FaUl9ScTJhSURKcXlVR01GNzV6aVE2elM5c1dyWFVib1JweW5xd0R2RXZAualdSR3hYeDdaWUVHS09oT24xQjZAXNEN6cWgwbnlCczdqLVpoN0hVZA2R3RUZApM1ItMkUZD";
}

//�ν�Ÿ�׷�
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
} else { //�ְ���
    $instaKey = "IGQWRQNUYzUFYtQkJRWDZAsNThFWjJKWER6ODVRcldDamtIV2wybXdrWXpEOTFXRExuZA1BhbzZAwdVpRSkFxWGg1Sk9TQXdmRDJOcEhGLWhnZAGdnTW9jRkNHRTJqMDJzVEdhd0ZAwaHVkZA3pzTkF0SmpPa1lKa2tmQUEZD";
}

// �ν�Ÿ�׷� API URL ����
$instaApi = "/me/media?fields=id,caption,media_type,media_url,thumbnail_url,permalink,username&access_token=".$instaKey;
$host = "graph.instagram.com";
$port = 443;

// fsockopen�� ����Ͽ� ���� �õ�
$fp = fsockopen("ssl://".$host, $port, $errno, $errstr, 30);

if (!$fp) {
    // ���� ���� �� ���� �޽��� ���
    echo "ERROR: $errno - $errstr<br />\n";
} else {
    // HTTP GET ��û �ۼ�
    $out = "GET " . $instaApi . " HTTP/1.1\r\n";
    $out .= "Host: " . $host . "\r\n";
    $out .= "User-Agent: My User Agent\r\n";
    $out .= "Connection: Close\r\n\r\n";

    // ��û ����
    fwrite($fp, $out);

    // ���� �б�
    $response = '';
    while (!feof($fp)) {
        $response .= fgets($fp, 128);
    }

    // ���� �ݱ�
    fclose($fp);

    // HTTP ����� ���� �и�
    list($header, $body) = explode("\r\n\r\n", $response, 2);

    // JSON �������� ���� ���
    echo json_encode($body);
}
?>
