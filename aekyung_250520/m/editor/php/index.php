<?php
header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Max-Age: 86400');

// ---------------------------------------------------------------------------
// �̹����� ����� ���丮�� ��ü ��θ� �����մϴ�.
// ���� ������(/)�� ������ �ʽ��ϴ�.
// ����: �� ����� ���� ������ ����, �бⰡ �����ϵ��� ������ �ֽʽÿ�.
define('hero_time',                                                         date('Y_m', time()),FALSE);


define("SAVE_DIR", $HTTP_SERVER_VARS['DOCUMENT_ROOT']."/m/upload/".hero_time);

if(strcmp(is_dir(SAVE_DIR),'1')){//������ ������
    $temp_permission = 0707;
    @umask(0);//�ý����� umask ���� ������ ���Ѽ����� ����� �������� �ʰ� ���丮�� 755�� �����Ǿ� �־ ���ε尡 �ȵǾ��� ���̾���.
    @mkdir(SAVE_DIR,$temp_permission, true);       //���丮 �۹̼��� 701�� ���丮 ���� �����̴�
}

// ������ ������ 'SAVE_DIR'�� URL�� �����մϴ�.
// ���� ������(/)�� ������ �ʽ��ϴ�.

define("SAVE_URL", "https://www.aklover.co.kr/m/upload/".hero_time);
    // Allowed extentions.
    $allowedExts = array("gif", "jpeg", "jpg", "png");

    // Get filename.
    $temp = explode(".", $_FILES["file"]["name"]);

    // Get extension.
    $extension = end($temp);

    // An image check is being done in the editor but it is best to
    // check that again on the server side.
    if ((($_FILES["file"]["type"] == "image/gif")
    || ($_FILES["file"]["type"] == "image/jpeg")
    || ($_FILES["file"]["type"] == "image/jpg")
    || ($_FILES["file"]["type"] == "image/pjpeg")
    || ($_FILES["file"]["type"] == "image/x-png")
    || ($_FILES["file"]["type"] == "image/png"))
    && in_array($extension, $allowedExts)) {
        // Generate new random name.
        $name = sha1(microtime()) . "." . $extension;

        // Save file in the uploads folder.
        move_uploaded_file($_FILES["file"]["tmp_name"], SAVE_DIR."/".$name);

        // Generate response.
        $response = new StdClass;
        $response->link = SAVE_URL."/" . $name;
        echo stripslashes(json_encode($response));
    }
?>