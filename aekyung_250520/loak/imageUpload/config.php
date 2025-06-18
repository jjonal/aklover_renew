<?php
// ---------------------------------------------------------------------------
// 이미지가 저장될 디렉토리의 전체 경로를 설정합니다.
// 끝에 슬래쉬(/)는 붙이지 않습니다.
// 주의: 이 경로의 접근 권한은 쓰기, 읽기가 가능하도록 설정해 주십시오.
define('hero_time',                                                         date('Y_m', time()),FALSE);

define("SAVE_DIR", $HTTP_SERVER_VARS['DOCUMENT_ROOT']."/user/photo/".hero_time);

if(strcmp(is_dir(SAVE_DIR),'1')){//폴더가 없을때
    $temp_permission = 0777;
    @umask(0);//시스템의 umask 설정 때문에 권한설정이 제대로 동작하지 않고 디렉토리가 755로 생성되어 있어서 업로드가 안되었던 것이었다.
    @mkdir(SAVE_DIR,$temp_permission, true);        //디렉토리 퍼미션을 701로 디렉토리 쓰기 권한이다
}

// 위에서 설정한 'SAVE_DIR'의 URL을 설정합니다.
// 끝에 슬래쉬(/)는 붙이지 않습니다.

define("SAVE_URL", "/user/photo/".hero_time);

// ---------------------------------------------------------------------------
?>
