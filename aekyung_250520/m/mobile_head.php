<?
####################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
####################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
//보안 관련
//define("__CASTLE_PHP_VERSION_BASE_DIR__", $_SERVER['DOCUMENT_ROOT']."/castle-php/"); 
//include_once(__CASTLE_PHP_VERSION_BASE_DIR__ . "castle_referee.php");


header("Cache-Control: no-cache, must-revalidate");
####################################################################################################################################################
define('OLDSET',                                                    'euc-kr',TRUE);
define('DBSET',                                                     'euckr',TRUE);
define('OLD_SET',                                                   'euc-kr',TRUE);                                                                 //euc-kr
define('NEW_SET',                                                   'utf-8',TRUE);                                                                  //utf-8
define('JOINSET',                                                   'mysql_query("set names euckr");',TRUE);
define('CREATESET',                                                 'CHARACTER SET euckr COLLATE euckr_korean_ci;',TRUE);
define('TBSET',                                                     'ENGINE=MyISAM DEFAULT CHARSET=temp_server;',TRUE);
define('METASET',                                                   '<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">',TRUE);
//캐릭터 셋은 다시 선언해야됨
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define('HOST_DEFAULT',                                              'localhost',TRUE);                                                              //기본폴더/설치경로  예) home 기본폴더일경우 '/home'표시됨
define('USER_DEFAULT',                                              'aekyung',TRUE);                                                                   //기본폴더/설치경로  예) admin 기본폴더일경우 '/admin'표시됨
define('PASSWD_DEFAULT',                                            'dorudtksdjq1',TRUE);                                                           //기본폴더/설치경로  예) hero 기본폴더일경우 '/hero'표시됨
define('DBNAME_DEFAULT',                                            'aekyung',TRUE);                                                                //기본폴더/설치경로  예) img css 기본폴더일경우 'img css'표시됨
####################################################################################################################################################
define('HOME_DEFAULT',                                              '',TRUE);                                                                       //기본폴더/설치경로  예) home 기본폴더일경우 '/home'표시됨
define('ADMIN_DEFAULT',                                             '/admin',TRUE);                                                                 //기본폴더/설치경로  예) admin 기본폴더일경우 '/admin'표시됨
define('HERO_DEFAULT',                                              '/hero',TRUE);                                                                  //기본폴더/설치경로  예) hero 기본폴더일경우 '/hero'표시됨
define('DIR_DEFAULT',                                               'freebest board user user/upload user/file user/photo aklover aklover/upload aklover/file aklover/photo css image include js main psd sub_activity sub_customer sub_guide sub_member sub_mission sub_product sub_story sub_talk db',TRUE);//기본폴더/설치경로  예) img css 기본폴더일경우 'img css'표시됨
####################################################################################################################################################
define('DOMAIN_ADMIN',                                              DOMAIN.ADMIN_DEFAULT,TRUE);                                                     //http://a.com/admin
####################################################################################################################################################
define('BODY',                                                      '<body topmargin="0" leftmargin="0" marginwidth="0" marginheight="0" border="0">'.PHP_EOL,TRUE); //
####################################################################################################################################################
####################################################################################################################################################
//에러방지용
ini_set('register_globals','1');
ini_set('session.bug_compat_42','1');
ini_set('session.bug_compat_warn','0');
ini_set('session.auto_start','1');
ini_set('session.gc_maxlifetime', '86400'); //세션의 시간설정 3600은 60초*60분이다
ini_set("upload_max_filesize","100M");
ini_set('max_upload_size', '100M');
ini_set('memory_limit', '100M');
ini_set("post_max_size","100M");
session_set_cookie_params(0,  "/");
//ini_set("session.cookie_domain", ".aklover.co.kr");
ini_set("session.cookie_domain", $HTTP_SERVER_VARS['HTTP_HOST']); 
set_time_limit(0); 
@session_start();
/* 
$error_date = date('Y-m-d H');
if($error_date>='2015-12-31 17' && $_SESSION['temp_id']!='ADMIN'){
	include_once $_SERVER['DOCUMENT_ROOT'].'/error.php';
}
*/
####################################################################################################################################################
//날자 설정
####################################################################################################################################################
define('Y',                                                         date('Y', time()),FALSE);
define('y',                                                         date('y', time()),FALSE);
define('M',                                                         date('M', time()),FALSE);
define('m',                                                         date('m', time()),FALSE);
define('D',                                                         date('D', time()),FALSE);
define('d',                                                         date('d', time()),FALSE);
define('H',                                                         date('H', time()),FALSE);
define('h',                                                         date('h', time()),FALSE);
define('I',                                                         date('I', time()),FALSE);
define('i',                                                         date('i', time()),FALSE);
define('S',                                                         date('S', time()),FALSE);
define('s',                                                         date('s', time()),FALSE);

define('Ymd',                                                       Y.'-'.m.'-'.d,FALSE);
define('Y_m_d',                                                     Y.'_'.m.'_'.d,FALSE);
define('His',                                                       H.':'.i.':'.s,FALSE);

define('Ym',                                                        Y.'-'.m,FALSE);
define('Y_m',                                                       Y.'_'.m,FALSE);

define('Ymdhis',                                                    Ymd.' '.His,FALSE);
define('Ymdhis_old',                                                date("Y-m-d H:i:s", strtotime("-1 day", time())),FALSE);
define('Y_m_d_h_i_s',                                               Y_m_d.'_'.H.'_'.i.'_'.s,FALSE);
define('dHi',                                                       d.'일 '.H.'시 '.i.'분',FALSE);
define('mdHi',                                                      m.'월 '.d.'일 '.H.'시 '.i.'분',FALSE);
####################################################################################################################################################
define('SLASH',                                                     '/',TRUE);                                                                      //구분자 /
define('PAGE_DEFAULT',                                              'index.php',TRUE);                                                              //index.php
define('LOCALHOST',                                                 'localhost',TRUE);                                                              //localhost
####################################################################################################################################################
define('PHP_SELF',                                                  $HTTP_SERVER_VARS['PHP_SELF'],TRUE);                                            //예 : /현재폴더/install.php
define('PATH_DEFAULT',                                              eregi_replace('\/[^/]*\.php$', '', PHP_SELF),TRUE);                             //예 : /현재폴더

define('PATH_DEFAULT_END',                                          PATH_DEFAULT.SLASH,TRUE);                                                       //예 : /현재폴더/
define('PATH_DEFAULT_HOME',                                         PATH_DEFAULT_END.PAGE_DEFAULT,TRUE);                                            //예 : /현재폴더/index.php
####################################################################################################################################################
$TEMP_URI                                                           = $HTTP_SERVER_VARS['REQUEST_URI'];
$TEMP_URI_PARSE                                                     = @parse_url($TEMP_URI);
define('URI',                                                       $TEMP_URI,TRUE);                                                                //예 : /현재폴더/install.php
define('URI_PATH',                                                  $TEMP_URI_PARSE[path],TRUE);                                                    //예 : /현재폴더/install.php
define('URI_NEXT',                                                  $TEMP_URI_PARSE[query],TRUE);                                                   //예 : /현재폴더/install.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
//도메인 최상의 경로
//define('DOMAIN',                                                    'http://www.aklover.co.kr',TRUE);                                 //http://a.com
define('DOMAIN',                                                    'https://www.aklover.co.kr',TRUE);                                 //http://a.com
define('DOMAIN_END',                                                DOMAIN.SLASH,TRUE);                                                             //http://a.com/
define('DOMAIN_HOME',                                               DOMAIN_END.PAGE_DEFAULT,TRUE);                                                  //http://a.com/index.php
####################################################################################################################################################
define('DOMAIN_ADMIN',                                              DOMAIN.ADMIN_DEFAULT,TRUE);                                                     //http://a.com/admin
define('DOMAIN_ADMIN_END',                                          DOMAIN_ADMIN.SLASH,TRUE);                                                       //http://a.com/admin/
define('DOMAIN_ADMIN_HOME',                                         DOMAIN_ADMIN_END.PAGE_DEFAULT,TRUE);                                            //http://a.com/admin/index.php

define('DOMAIN_HERO',                                               DOMAIN.HERO_DEFAULT,TRUE);                                                      //http://a.com/hero
define('DOMAIN_HERO_END',                                           DOMAIN_HERO.SLASH,TRUE);                                                        //http://a.com/hero/
define('DOMAIN_HERO_HOME',                                          DOMAIN_HERO_END.PAGE_DEFAULT,TRUE);                                             //http://a.com/hero/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define('ROOT',                                                      DOMAIN.HOME_DEFAULT,TRUE);                                                      //http://a.com/기본폴더
define('ROOT_END',                                                  ROOT.SLASH,TRUE);                                                               //http://a.com/기본폴더/
define('ROOT_HOME',                                                 ROOT_END.PAGE_DEFAULT,TRUE);                                                    //http://a.com/기본폴더/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
//주로 사용 (HOME_END)
####################################################################################################################################################
define('HOME',                                                      DOMAIN.HOME_DEFAULT,TRUE);                                                      //http://a.com/기본폴더
define('HOME_END',                                                  HOME.SLASH,TRUE);                                                               //http://a.com/기본폴더/
define('HOME_HOME',                                                 HOME_END.PAGE_DEFAULT,TRUE);                                                    //http://a.com/기본폴더/index.php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
define('ADMIN',                                                     HOME.ADMIN_DEFAULT,TRUE);                                                       //http://a.com/기본폴더/admin
define('ADMIN_END',                                                 ADMIN.SLASH,TRUE);                                                              //http://a.com/기본폴더/admin/
define('ADMIN_HOME',                                                ADMIN_END.PAGE_DEFAULT,TRUE);                                                   //http://a.com/기본폴더/admin/index.php

define('HERO',                                                      HOME.HERO_DEFAULT,TRUE);                                                        //http://a.com/기본폴더/hero
define('HERO_END',                                                  HERO.SLASH,TRUE);                                                               //http://a.com/기본폴더/hero/
define('HERO_HOME',                                                 HERO_END.PAGE_DEFAULT,TRUE);                                                    //http://a.com/기본폴더/hero/index.php
####################################################################################################################################################
//주로 사용 (PATH_END)
####################################################################################################################################################
define('PATH',                                                      DOMAIN.PATH_DEFAULT,TRUE);                                                      //http://a.com/현재폴더
define('PATH_END',                                                  PATH.SLASH,TRUE);                                                               //http://a.com/현재폴더/
define('PATH_HOME',                                                 PATH_END.PAGE_DEFAULT,TRUE);                                                    //http://a.com/현재폴더/index.php
define('PATH_HOME_HTTPS',											'https://'.$HTTP_SERVER_VARS['HTTP_HOST'].PATH_DEFAULT.SLASH.PAGE_DEFAULT,TRUE);  //160616 추가 https://a.com/현재폴더/index.php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
define('PATH_ADMIN',                                                PATH.ADMIN_DEFAULT,TRUE);                                                       //http://a.com/현재폴더/admin
define('PATH_ADMIN_END',                                            PATH_ADMIN.SLASH,TRUE);                                                         //http://a.com/현재폴더/admin/
define('PATH_ADMIN_HOME',                                           PATH_ADMIN_END.PAGE_DEFAULT,TRUE);                                              //http://a.com/현재폴더/admin/index.php

define('PATH_HERO',                                                 PATH.HERO_DEFAULT,TRUE);                                                        //http://a.com/현재폴더/hero
define('PATH_HERO_END',                                             PATH_HERO.SLASH,TRUE);                                                          //http://a.com/현재폴더/hero/
define('PATH_HERO_HOME',                                            PATH_HERO_END.PAGE_DEFAULT,TRUE);                                               //http://a.com/현재폴더/hero/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define('DOMAIN_INC',                                                $HTTP_SERVER_VARS['DOCUMENT_ROOT'],TRUE);                                       //C:/APM_Setup/htdocs
define('DOMAIN_INC_END',                                            DOMAIN_INC.SLASH,TRUE);                                                         //C:/APM_Setup/htdocs/
define('DOMAIN_INC_HOME',                                           DOMAIN_INC_END.PAGE_DEFAULT,TRUE);                                              //C:/APM_Setup/htdocs/index.php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
define('DOMAIN_ADMIN_INC',                                          DOMAIN_INC.ADMIN_DEFAULT,TRUE);                                                 //C:/APM_Setup/htdocs/admin
define('DOMAIN_ADMIN_INC_END',                                      DOMAIN_ADMIN_INC.SLASH,TRUE);                                                   //C:/APM_Setup/htdocs/admin/
define('DOMAIN_ADMIN_INC_HOME',                                      DOMAIN_ADMIN_INC_END.PAGE_DEFAULT,TRUE);                                       //C:/APM_Setup/htdocs/admin/index.php

define('DOMAIN_HERO_INC',                                           DOMAIN_INC.HERO_DEFAULT,TRUE);                                                  //C:/APM_Setup/htdocs/hero
define('DOMAIN_HERO_INC_END',                                       DOMAIN_HERO_INC.SLASH,TRUE);                                                    //C:/APM_Setup/htdocs/hero/
define('DOMAIN_HERO_INC_HOME',                                      DOMAIN_HERO_INC_END.PAGE_DEFAULT,TRUE);                                         //C:/APM_Setup/htdocs/hero/index.php
####################################################################################################################################################
define('ROOT_INC',                                                  DOMAIN_INC.HOME_DEFAULT,TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더
define('ROOT_INC_END',                                              ROOT_INC.SLASH,TRUE);                                                           //C:/APM_Setup/htdocs/기본폴더/
define('ROOT_INC_HOME',                                             ROOT_INC_END.PAGE_DEFAULT,TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
//주로 사용 (HOME_INC_END)
####################################################################################################################################################
define('HOME_INC',                                                  DOMAIN_INC.HOME_DEFAULT,TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더
define('HOME_INC_END',                                              HOME_INC.SLASH,TRUE);                                                           //C:/APM_Setup/htdocs/기본폴더/
define('HOME_INC_HOME',                                             HOME_INC_END.PAGE_DEFAULT,TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/index.php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
define('ADMIN_INC',                                                 HOME_INC.ADMIN_DEFAULT,TRUE);                                                   //C:/APM_Setup/htdocs/기본폴더/admin
define('ADMIN_INC_END',                                             ADMIN_INC.SLASH,TRUE);                                                          //C:/APM_Setup/htdocs/기본폴더/admin/
define('ADMIN_INC_HOME',                                            ADMIN_INC_END.PAGE_DEFAULT,TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/admin/index.php

define('HERO_INC',                                                  HOME_INC.HERO_DEFAULT,TRUE);                                                    //C:/APM_Setup/htdocs/기본폴더/hero
define('HERO_INC_END',                                              HERO_INC.SLASH,TRUE);                                                           //C:/APM_Setup/htdocs/기본폴더/hero/
define('HERO_INC_HOME',                                             HERO_INC_END.PAGE_DEFAULT,TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/hero/index.php
####################################################################################################################################################
//주로 사용 (PATH_INC_END)
####################################################################################################################################################
define('PATH_INC',                                                  DOMAIN_INC.PATH_DEFAULT,TRUE);                                                  //C:/APM_Setup/htdocs/현재폴더
define('PATH_INC_END',                                              PATH_INC.SLASH,TRUE);                                                           //C:/APM_Setup/htdocs/현재폴더/
define('PATH_INC_HOME',                                             PATH_INC_END.PAGE_DEFAULT,TRUE);                                                //C:/APM_Setup/htdocs/현재폴더/index.php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
define('PATH_ADMIN_INC',                                            PATH_INC.ADMIN_DEFAULT,TRUE);                                                   //C:/APM_Setup/htdocs/현재폴더/admin
define('PATH_ADMIN_INC_END',                                        PATH_ADMIN_INC.SLASH,TRUE);                                                     //C:/APM_Setup/htdocs/현재폴더/admin/
define('PATH_ADMIN_INC_HOME',                                       PATH_ADMIN_INC_END.PAGE_DEFAULT,TRUE);                                          //C:/APM_Setup/htdocs/현재폴더/admin/index.php

define('PATH_HERO_INC',                                             PATH_INC.HERO_DEFAULT,TRUE);                                                    //C:/APM_Setup/htdocs/현재폴더/hero
define('PATH_HERO_INC_END',                                         PATH_HERO_INC.SLASH,TRUE);                                                      //C:/APM_Setup/htdocs/현재폴더/hero/
define('PATH_HERO_INC_HOME',                                        PATH_HERO_INC_END.PAGE_DEFAULT,TRUE);                                           //C:/APM_Setup/htdocs/현재폴더/hero/index.php
####################################################################################################################################################
####################################################################################################################################################
define("DOMAIN_FREEBEST",                                           DOMAIN_END."freebest",TRUE);                                                    //http://a.com/img
define("DOMAIN_FREEBEST_END",                                       DOMAIN_END."freebest".SLASH,TRUE);                                              //http://a.com/img/
define("DOMAIN_FREEBEST_HOME",                                      DOMAIN_FREEBEST_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/img/index.php

define("DOMAIN_ADMIN_FREEBEST",                                     DOMAIN_ADMIN_END."freebest",TRUE);                                              //http://a.com/admin/img
define("DOMAIN_ADMIN_FREEBEST_END",                                 DOMAIN_ADMIN_END."freebest".SLASH,TRUE);                                        //http://a.com/admin/img/
define("DOMAIN_ADMIN_FREEBEST_HOME",                                DOMAIN_ADMIN_FREEBEST_END.PAGE_DEFAULT,TRUE);                                   //http://a.com/admin/img/index.php

define("DOMAIN_HERO_FREEBEST",                                      DOMAIN_HERO_END."freebest",TRUE);                                               //http://a.com/hero/img
define("DOMAIN_HERO_FREEBEST_END",                                  DOMAIN_HERO_END."freebest".SLASH,TRUE);                                         //http://a.com/hero/img/
define("DOMAIN_HERO_FREEBEST_HOME",                                 DOMAIN_HERO_FREEBEST_END.PAGE_DEFAULT,TRUE);                                    //http://a.com/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_END)
####################################################################################################################################################
define("FREEBEST",                                                  HOME_END."freebest",TRUE);                                                      //http://a.com/기본폴더/img
define("FREEBEST_END",                                              HOME_END."freebest".SLASH,TRUE);                                                //http://a.com/기본폴더/img/
define("FREEBEST_HOME",                                             FREEBEST_END.PAGE_DEFAULT,TRUE);                                                //http://a.com/기본폴더/img/index.php

define("ADMIN_FREEBEST",                                            ADMIN_END."freebest",TRUE);                                                     //http://a.com/기본폴더/admin/img
define("ADMIN_FREEBEST_END",                                        ADMIN_END."freebest".SLASH,TRUE);                                               //http://a.com/기본폴더/admin/img/
define("ADMIN_FREEBEST_HOME",                                       ADMIN_FREEBEST_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/기본폴더/admin/img/index.php

define("HERO_FREEBEST",                                             HERO_END."freebest",TRUE);                                                      //http://a.com/기본폴더/hero/img
define("HERO_FREEBEST_END",                                         HERO_END."freebest".SLASH,TRUE);                                                //http://a.com/기본폴더/hero/img/
define("HERO_FREEBEST_HOME",                                        HERO_FREEBEST_END.PAGE_DEFAULT,TRUE);                                           //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_FREEBEST",                                             ROOT_END."freebest",TRUE);                                                      //http://a.com/기본폴더/img
define("ROOT_FREEBEST_END",                                         ROOT_END."freebest".SLASH,TRUE);                                                //http://a.com/기본폴더/img/
define("ROOT_FREEBEST_HOME",                                        ROOT_FREEBEST_END.PAGE_DEFAULT,TRUE);                                           //http://a.com/기본폴더/img/index.php

define("ROOT_ADMIN_FREEBEST",                                       ADMIN_END."freebest",TRUE);                                                     //http://a.com/기본폴더/admin/img
define("ROOT_ADMIN_FREEBEST_END",                                   ADMIN_END."freebest".SLASH,TRUE);                                               //http://a.com/기본폴더/admin/img/
define("ROOT_ADMIN_FREEBEST_HOME",                                  ROOT_ADMIN_FREEBEST_END.PAGE_DEFAULT,TRUE);                                     //http://a.com/기본폴더/admin/img/index.php

define("ROOT_HERO_FREEBEST",                                        HERO_END."freebest",TRUE);                                                      //http://a.com/기본폴더/hero/img
define("ROOT_HERO_FREEBEST_END",                                    HERO_END."freebest".SLASH,TRUE);                                                //http://a.com/기본폴더/hero/img/
define("ROOT_HERO_FREEBEST_HOME",                                   ROOT_HERO_FREEBEST_END.PAGE_DEFAULT,TRUE);                                      //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_FREEBEST",                                             HOME_END."freebest",TRUE);                                                      //http://a.com/기본폴더/img
define("HOME_FREEBEST_END",                                         HOME_END."freebest".SLASH,TRUE);                                                //http://a.com/기본폴더/img/
define("HOME_FREEBEST_HOME",                                        HOME_FREEBEST_END.PAGE_DEFAULT,TRUE);                                           //http://a.com/기본폴더/img/index.php

define("HOME_ADMIN_FREEBEST",                                       ADMIN_END."freebest",TRUE);                                                     //http://a.com/기본폴더/admin/img
define("HOME_ADMIN_FREEBEST_END",                                   ADMIN_END."freebest".SLASH,TRUE);                                               //http://a.com/기본폴더/admin/img/
define("HOME_ADMIN_FREEBEST_HOME",                                  HOME_ADMIN_FREEBEST_END.PAGE_DEFAULT,TRUE);                                     //http://a.com/기본폴더/admin/img/index.php

define("HOME_HERO_FREEBEST",                                        HERO_END."freebest",TRUE);                                                      //http://a.com/기본폴더/hero/img
define("HOME_HERO_FREEBEST_END",                                    HERO_END."freebest".SLASH,TRUE);                                                //http://a.com/기본폴더/hero/img/
define("HOME_HERO_FREEBEST_HOME",                                   HOME_HERO_FREEBEST_END.PAGE_DEFAULT,TRUE);                                      //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_END)
####################################################################################################################################################
define("PATH_FREEBEST",                                             PATH_END."freebest",TRUE);                                                      //http://a.com/현재폴더/img
define("PATH_FREEBEST_END",                                         PATH_END."freebest".SLASH,TRUE);                                                //http://a.com/현재폴더/img/
define("PATH_FREEBEST_HOME",                                        PATH_FREEBEST_END.PAGE_DEFAULT,TRUE);                                           //http://a.com/현재폴더/img/index.php

define("PATH_ADMIN_FREEBEST",                                       PATH_ADMIN_END."freebest",TRUE);                                                //http://a.com/현재폴더/admin/img
define("PATH_ADMIN_FREEBEST_END",                                   PATH_ADMIN_END."freebest".SLASH,TRUE);                                          //http://a.com/현재폴더/admin/img/
define("PATH_ADMIN_FREEBEST_HOME",                                  PATH_ADMIN_FREEBEST_END.PAGE_DEFAULT,TRUE);                                     //http://a.com/현재폴더/admin/img/index.php

define("PATH_HERO_FREEBEST",                                        PATH_HERO_END."freebest",TRUE);                                                 //http://a.com/현재폴더/hero/img
define("PATH_HERO_FREEBEST_END",                                    PATH_HERO_END."freebest".SLASH,TRUE);                                           //http://a.com/현재폴더/hero/img/
define("PATH_HERO_FREEBEST_HOME",                                   PATH_HERO_FREEBEST_END.PAGE_DEFAULT,TRUE);                                      //http://a.com/현재폴더/hero/img/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define("DOMAIN_FREEBEST_INC",                                       DOMAIN_INC_END."freebest",TRUE);                                                //C:/APM_Setup/htdocs/img
define("DOMAIN_FREEBEST_INC_END",                                   DOMAIN_INC_END."freebest".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/img/
define("DOMAIN_FREEBEST_INC_HOME",                                  DOMAIN_FREEBEST_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/img/index.php

define("DOMAIN_ADMIN_FREEBEST_INC",                                 DOMAIN_ADMIN_INC_END."freebest",TRUE);                                          //C:/APM_Setup/htdocs/admin/img
define("DOMAIN_ADMIN_FREEBEST_INC_END",                             DOMAIN_ADMIN_INC_END."freebest".SLASH,TRUE);                                    //C:/APM_Setup/htdocs/admin/img/
define("DOMAIN_ADMIN_FREEBEST_INC_HOME",                            DOMAIN_ADMIN_FREEBEST_INC_END.PAGE_DEFAULT,TRUE);                               //C:/APM_Setup/htdocs/admin/img/index.php

define("DOMAIN_HERO_FREEBEST_INC",                                  DOMAIN_HERO_INC_END."freebest",TRUE);                                           //C:/APM_Setup/htdocs/hero/img
define("DOMAIN_HERO_FREEBEST_INC_END",                              DOMAIN_HERO_INC_END."freebest".SLASH,TRUE);                                     //C:/APM_Setup/htdocs/hero/img/
define("DOMAIN_HERO_FREEBEST_INC_HOME",                             DOMAIN_HERO_FREEBEST_INC_END.PAGE_DEFAULT,TRUE);                                //C:/APM_Setup/htdocs/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_INC_END)
####################################################################################################################################################
define("FREEBEST_INC",                                              HOME_INC_END."freebest",TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/img
define("FREEBEST_INC_END",                                          HOME_INC_END."freebest".SLASH,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/img/
define("FREEBEST_INC_HOME",                                         FREEBEST_INC_END.PAGE_DEFAULT,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ADMIN_FREEBEST_INC",                                        ADMIN_INC_END."freebest",TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ADMIN_FREEBEST_INC_END",                                    ADMIN_INC_END."freebest".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ADMIN_FREEBEST_INC_HOME",                                   ADMIN_FREEBEST_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HERO_FREEBEST_INC",                                         HERO_INC_END."freebest",TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HERO_FREEBEST_INC_END",                                     HERO_INC_END."freebest".SLASH,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HERO_FREEBEST_INC_HOME",                                    HERO_FREEBEST_INC_END.PAGE_DEFAULT,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_FREEBEST_INC",                                         ROOT_INC_END."freebest",TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/img
define("ROOT_FREEBEST_INC_END",                                     ROOT_INC_END."freebest".SLASH,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/img/
define("ROOT_FREEBEST_INC_HOME",                                    ROOT_FREEBEST_INC_END.PAGE_DEFAULT,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ROOT_ADMIN_FREEBEST_INC",                                   ADMIN_INC_END."freebest",TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ROOT_ADMIN_FREEBEST_INC_END",                               ADMIN_INC_END."freebest".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ROOT_ADMIN_FREEBEST_INC_HOME",                              ROOT_ADMIN_FREEBEST_INC_END.PAGE_DEFAULT,TRUE);                                 //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("ROOT_HERO_FREEBEST_INC",                                    HERO_INC_END."freebest",TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/hero/img
define("ROOT_HERO_FREEBEST_INC_END",                                HERO_INC_END."freebest".SLASH,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("ROOT_HERO_FREEBEST_INC_HOME",                               ROOT_HERO_FREEBEST_INC_END.PAGE_DEFAULT,TRUE);                                  //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_FREEBEST_INC",                                         HOME_INC_END."freebest",TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/img
define("HOME_FREEBEST_INC_END",                                     HOME_INC_END."freebest".SLASH,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/img/
define("HOME_FREEBEST_INC_HOME",                                    HOME_FREEBEST_INC_END.PAGE_DEFAULT,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("HOME_ADMIN_FREEBEST_INC",                                   ADMIN_INC_END."freebest",TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/admin/img
define("HOME_ADMIN_FREEBEST_INC_END",                               ADMIN_INC_END."freebest".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("HOME_ADMIN_FREEBEST_INC_HOME",                              HOME_ADMIN_FREEBEST_INC_END.PAGE_DEFAULT,TRUE);                                 //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HOME_HERO_FREEBEST_INC",                                    HERO_INC_END."freebest",TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HOME_HERO_FREEBEST_INC_END",                                HERO_INC_END."freebest".SLASH,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HOME_HERO_FREEBEST_INC_HOME",                               HOME_HERO_FREEBEST_INC_END.PAGE_DEFAULT,TRUE);                                  //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_INC_END)
####################################################################################################################################################
define("PATH_FREEBEST_INC",                                         PATH_INC_END."freebest",TRUE);                                                  //C:/APM_Setup/htdocs/현재폴더/img
define("PATH_FREEBEST_INC_END",                                     PATH_INC_END."freebest".SLASH,TRUE);                                            //C:/APM_Setup/htdocs/현재폴더/img/
define("PATH_FREEBEST_INC_HOME",                                    PATH_FREEBEST_INC_END.PAGE_DEFAULT,TRUE);                                       //C:/APM_Setup/htdocs/현재폴더/img/index.php

define("PATH_ADMIN_FREEBEST_INC",                                   PATH_ADMIN_INC_END."freebest",TRUE);                                            //C:/APM_Setup/htdocs/현재폴더/admin/img
define("PATH_ADMIN_FREEBEST_INC_END",                               PATH_ADMIN_INC_END."freebest".SLASH,TRUE);                                      //C:/APM_Setup/htdocs/현재폴더/admin/img/
define("PATH_ADMIN_FREEBEST_INC_HOME",                              PATH_ADMIN_FREEBEST_INC_END.PAGE_DEFAULT,TRUE);                                 //C:/APM_Setup/htdocs/현재폴더/admin/img/index.php

define("PATH_HERO_FREEBEST_INC",                                    PATH_HERO_INC_END."freebest",TRUE);                                             //C:/APM_Setup/htdocs/현재폴더/hero/img
define("PATH_HERO_FREEBEST_INC_END",                                PATH_HERO_INC_END."freebest".SLASH,TRUE);                                       //C:/APM_Setup/htdocs/현재폴더/hero/img/
define("PATH_HERO_FREEBEST_INC_HOME",                               PATH_HERO_FREEBEST_INC_END.PAGE_DEFAULT,TRUE);                                  //C:/APM_Setup/htdocs/현재폴더/hero/img/index.php
####################################################################################################################################################
####################################################################################################################################################
define("DOMAIN_BOARD",                                              DOMAIN_END."board",TRUE);                                                       //http://a.com/img
define("DOMAIN_BOARD_END",                                          DOMAIN_END."board".SLASH,TRUE);                                                 //http://a.com/img/
define("DOMAIN_BOARD_HOME",                                         DOMAIN_BOARD_END.PAGE_DEFAULT,TRUE);                                            //http://a.com/img/index.php

define("DOMAIN_ADMIN_BOARD",                                        DOMAIN_ADMIN_END."board",TRUE);                                                 //http://a.com/admin/img
define("DOMAIN_ADMIN_BOARD_END",                                    DOMAIN_ADMIN_END."board".SLASH,TRUE);                                           //http://a.com/admin/img/
define("DOMAIN_ADMIN_BOARD_HOME",                                   DOMAIN_ADMIN_BOARD_END.PAGE_DEFAULT,TRUE);                                      //http://a.com/admin/img/index.php

define("DOMAIN_HERO_BOARD",                                         DOMAIN_HERO_END."board",TRUE);                                                  //http://a.com/hero/img
define("DOMAIN_HERO_BOARD_END",                                     DOMAIN_HERO_END."board".SLASH,TRUE);                                            //http://a.com/hero/img/
define("DOMAIN_HERO_BOARD_HOME",                                    DOMAIN_HERO_BOARD_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_END)
####################################################################################################################################################
define("BOARD",                                                     HOME_END."board",TRUE);                                                         //http://a.com/기본폴더/img
define("BOARD_END",                                                 HOME_END."board".SLASH,TRUE);                                                   //http://a.com/기본폴더/img/
define("BOARD_HOME",                                                BOARD_END.PAGE_DEFAULT,TRUE);                                                   //http://a.com/기본폴더/img/index.php

define("ADMIN_BOARD",                                               ADMIN_END."board",TRUE);                                                        //http://a.com/기본폴더/admin/img
define("ADMIN_BOARD_END",                                           ADMIN_END."board".SLASH,TRUE);                                                  //http://a.com/기본폴더/admin/img/
define("ADMIN_BOARD_HOME",                                          ADMIN_BOARD_END.PAGE_DEFAULT,TRUE);                                             //http://a.com/기본폴더/admin/img/index.php

define("HERO_BOARD",                                                HERO_END."board",TRUE);                                                         //http://a.com/기본폴더/hero/img
define("HERO_BOARD_END",                                            HERO_END."board".SLASH,TRUE);                                                   //http://a.com/기본폴더/hero/img/
define("HERO_BOARD_HOME",                                           HERO_BOARD_END.PAGE_DEFAULT,TRUE);                                              //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_BOARD",                                                ROOT_END."board",TRUE);                                                         //http://a.com/기본폴더/img
define("ROOT_BOARD_END",                                            ROOT_END."board".SLASH,TRUE);                                                   //http://a.com/기본폴더/img/
define("ROOT_BOARD_HOME",                                           ROOT_BOARD_END.PAGE_DEFAULT,TRUE);                                              //http://a.com/기본폴더/img/index.php

define("ROOT_ADMIN_BOARD",                                          ADMIN_END."board",TRUE);                                                        //http://a.com/기본폴더/admin/img
define("ROOT_ADMIN_BOARD_END",                                      ADMIN_END."board".SLASH,TRUE);                                                  //http://a.com/기본폴더/admin/img/
define("ROOT_ADMIN_BOARD_HOME",                                     ROOT_ADMIN_BOARD_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/기본폴더/admin/img/index.php

define("ROOT_HERO_BOARD",                                           HERO_END."board",TRUE);                                                         //http://a.com/기본폴더/hero/img
define("ROOT_HERO_BOARD_END",                                       HERO_END."board".SLASH,TRUE);                                                   //http://a.com/기본폴더/hero/img/
define("ROOT_HERO_BOARD_HOME",                                      ROOT_HERO_BOARD_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_BOARD",                                                HOME_END."board",TRUE);                                                         //http://a.com/기본폴더/img
define("HOME_BOARD_END",                                            HOME_END."board".SLASH,TRUE);                                                   //http://a.com/기본폴더/img/
define("HOME_BOARD_HOME",                                           HOME_BOARD_END.PAGE_DEFAULT,TRUE);                                              //http://a.com/기본폴더/img/index.php

define("HOME_ADMIN_BOARD",                                          ADMIN_END."board",TRUE);                                                        //http://a.com/기본폴더/admin/img
define("HOME_ADMIN_BOARD_END",                                      ADMIN_END."board".SLASH,TRUE);                                                  //http://a.com/기본폴더/admin/img/
define("HOME_ADMIN_BOARD_HOME",                                     HOME_ADMIN_BOARD_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/기본폴더/admin/img/index.php

define("HOME_HERO_BOARD",                                           HERO_END."board",TRUE);                                                         //http://a.com/기본폴더/hero/img
define("HOME_HERO_BOARD_END",                                       HERO_END."board".SLASH,TRUE);                                                   //http://a.com/기본폴더/hero/img/
define("HOME_HERO_BOARD_HOME",                                      HOME_HERO_BOARD_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_END)
####################################################################################################################################################
define("PATH_BOARD",                                                PATH_END."board",TRUE);                                                         //http://a.com/현재폴더/img
define("PATH_BOARD_END",                                            PATH_END."board".SLASH,TRUE);                                                   //http://a.com/현재폴더/img/
define("PATH_BOARD_HOME",                                           PATH_BOARD_END.PAGE_DEFAULT,TRUE);                                              //http://a.com/현재폴더/img/index.php

define("PATH_ADMIN_BOARD",                                          PATH_ADMIN_END."board",TRUE);                                                   //http://a.com/현재폴더/admin/img
define("PATH_ADMIN_BOARD_END",                                      PATH_ADMIN_END."board".SLASH,TRUE);                                             //http://a.com/현재폴더/admin/img/
define("PATH_ADMIN_BOARD_HOME",                                     PATH_ADMIN_BOARD_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/현재폴더/admin/img/index.php

define("PATH_HERO_BOARD",                                           PATH_HERO_END."board",TRUE);                                                    //http://a.com/현재폴더/hero/img
define("PATH_HERO_BOARD_END",                                       PATH_HERO_END."board".SLASH,TRUE);                                              //http://a.com/현재폴더/hero/img/
define("PATH_HERO_BOARD_HOME",                                      PATH_HERO_BOARD_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/현재폴더/hero/img/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define("DOMAIN_BOARD_INC",                                          DOMAIN_INC_END."board",TRUE);                                                   //C:/APM_Setup/htdocs/img
define("DOMAIN_BOARD_INC_END",                                      DOMAIN_INC_END."board".SLASH,TRUE);                                             //C:/APM_Setup/htdocs/img/
define("DOMAIN_BOARD_INC_HOME",                                     DOMAIN_BOARD_INC_END.PAGE_DEFAULT,TRUE);                                        //C:/APM_Setup/htdocs/img/index.php

define("DOMAIN_ADMIN_BOARD_INC",                                    DOMAIN_ADMIN_INC_END."board",TRUE);                                             //C:/APM_Setup/htdocs/admin/img
define("DOMAIN_ADMIN_BOARD_INC_END",                                DOMAIN_ADMIN_INC_END."board".SLASH,TRUE);                                       //C:/APM_Setup/htdocs/admin/img/
define("DOMAIN_ADMIN_BOARD_INC_HOME",                               DOMAIN_ADMIN_BOARD_INC_END.PAGE_DEFAULT,TRUE);                                  //C:/APM_Setup/htdocs/admin/img/index.php

define("DOMAIN_HERO_BOARD_INC",                                     DOMAIN_HERO_INC_END."board",TRUE);                                              //C:/APM_Setup/htdocs/hero/img
define("DOMAIN_HERO_BOARD_INC_END",                                 DOMAIN_HERO_INC_END."board".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/hero/img/
define("DOMAIN_HERO_BOARD_INC_HOME",                                DOMAIN_HERO_BOARD_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_INC_END)
####################################################################################################################################################
define("BOARD_INC",                                                 HOME_INC_END."board",TRUE);                                                     //C:/APM_Setup/htdocs/기본폴더/img
define("BOARD_INC_END",                                             HOME_INC_END."board".SLASH,TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/img/
define("BOARD_INC_HOME",                                            BOARD_INC_END.PAGE_DEFAULT,TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ADMIN_BOARD_INC",                                           ADMIN_INC_END."board",TRUE);                                                    //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ADMIN_BOARD_INC_END",                                       ADMIN_INC_END."board".SLASH,TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ADMIN_BOARD_INC_HOME",                                      ADMIN_BOARD_INC_END.PAGE_DEFAULT,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HERO_BOARD_INC",                                            HERO_INC_END."board",TRUE);                                                     //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HERO_BOARD_INC_END",                                        HERO_INC_END."board".SLASH,TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HERO_BOARD_INC_HOME",                                       HERO_BOARD_INC_END.PAGE_DEFAULT,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_BOARD_INC",                                            ROOT_INC_END."board",TRUE);                                                     //C:/APM_Setup/htdocs/기본폴더/img
define("ROOT_BOARD_INC_END",                                        ROOT_INC_END."board".SLASH,TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/img/
define("ROOT_BOARD_INC_HOME",                                       ROOT_BOARD_INC_END.PAGE_DEFAULT,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ROOT_ADMIN_BOARD_INC",                                      ADMIN_INC_END."board",TRUE);                                                    //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ROOT_ADMIN_BOARD_INC_END",                                  ADMIN_INC_END."board".SLASH,TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ROOT_ADMIN_BOARD_INC_HOME",                                 ROOT_ADMIN_BOARD_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("ROOT_HERO_BOARD_INC",                                       HERO_INC_END."board",TRUE);                                                     //C:/APM_Setup/htdocs/기본폴더/hero/img
define("ROOT_HERO_BOARD_INC_END",                                   HERO_INC_END."board".SLASH,TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("ROOT_HERO_BOARD_INC_HOME",                                  ROOT_HERO_BOARD_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_BOARD_INC",                                            HOME_INC_END."board",TRUE);                                                     //C:/APM_Setup/htdocs/기본폴더/img
define("HOME_BOARD_INC_END",                                        HOME_INC_END."board".SLASH,TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/img/
define("HOME_BOARD_INC_HOME",                                       HOME_BOARD_INC_END.PAGE_DEFAULT,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("HOME_ADMIN_BOARD_INC",                                      ADMIN_INC_END."board",TRUE);                                                    //C:/APM_Setup/htdocs/기본폴더/admin/img
define("HOME_ADMIN_BOARD_INC_END",                                  ADMIN_INC_END."board".SLASH,TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("HOME_ADMIN_BOARD_INC_HOME",                                 HOME_ADMIN_BOARD_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HOME_HERO_BOARD_INC",                                       HERO_INC_END."board",TRUE);                                                     //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HOME_HERO_BOARD_INC_END",                                   HERO_INC_END."board".SLASH,TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HOME_HERO_BOARD_INC_HOME",                                  HOME_HERO_BOARD_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_INC_END)
####################################################################################################################################################
define("PATH_BOARD_INC",                                            PATH_INC_END."board",TRUE);                                                     //C:/APM_Setup/htdocs/현재폴더/img
define("PATH_BOARD_INC_END",                                        PATH_INC_END."board".SLASH,TRUE);                                               //C:/APM_Setup/htdocs/현재폴더/img/
define("PATH_BOARD_INC_HOME",                                       PATH_BOARD_INC_END.PAGE_DEFAULT,TRUE);                                          //C:/APM_Setup/htdocs/현재폴더/img/index.php

define("PATH_ADMIN_BOARD_INC",                                      PATH_ADMIN_INC_END."board",TRUE);                                               //C:/APM_Setup/htdocs/현재폴더/admin/img
define("PATH_ADMIN_BOARD_INC_END",                                  PATH_ADMIN_INC_END."board".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/현재폴더/admin/img/
define("PATH_ADMIN_BOARD_INC_HOME",                                 PATH_ADMIN_BOARD_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/현재폴더/admin/img/index.php

define("PATH_HERO_BOARD_INC",                                       PATH_HERO_INC_END."board",TRUE);                                                //C:/APM_Setup/htdocs/현재폴더/hero/img
define("PATH_HERO_BOARD_INC_END",                                   PATH_HERO_INC_END."board".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/현재폴더/hero/img/
define("PATH_HERO_BOARD_INC_HOME",                                  PATH_HERO_BOARD_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/현재폴더/hero/img/index.php
####################################################################################################################################################
####################################################################################################################################################
define("DOMAIN_USER",                                               DOMAIN_END."user",TRUE);                                                        //http://a.com/img
define("DOMAIN_USER_END",                                           DOMAIN_END."user".SLASH,TRUE);                                                  //http://a.com/img/
define("DOMAIN_USER_HOME",                                          DOMAIN_USER_END.PAGE_DEFAULT,TRUE);                                             //http://a.com/img/index.php

define("DOMAIN_ADMIN_USER",                                         DOMAIN_ADMIN_END."user",TRUE);                                                  //http://a.com/admin/img
define("DOMAIN_ADMIN_USER_END",                                     DOMAIN_ADMIN_END."user".SLASH,TRUE);                                            //http://a.com/admin/img/
define("DOMAIN_ADMIN_USER_HOME",                                    DOMAIN_ADMIN_USER_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/admin/img/index.php

define("DOMAIN_HERO_USER",                                          DOMAIN_HERO_END."user",TRUE);                                                   //http://a.com/hero/img
define("DOMAIN_HERO_USER_END",                                      DOMAIN_HERO_END."user".SLASH,TRUE);                                             //http://a.com/hero/img/
define("DOMAIN_HERO_USER_HOME",                                     DOMAIN_HERO_USER_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_END)
####################################################################################################################################################
define("USER",                                                      HOME_END."user",TRUE);                                                          //http://a.com/기본폴더/img
define("USER_END",                                                  HOME_END."user".SLASH,TRUE);                                                    //http://a.com/기본폴더/img/
define("USER_HOME",                                                 USER_END.PAGE_DEFAULT,TRUE);                                                    //http://a.com/기본폴더/img/index.php

define("ADMIN_USER",                                                ADMIN_END."user",TRUE);                                                         //http://a.com/기본폴더/admin/img
define("ADMIN_USER_END",                                            ADMIN_END."user".SLASH,TRUE);                                                   //http://a.com/기본폴더/admin/img/
define("ADMIN_USER_HOME",                                           ADMIN_USER_END.PAGE_DEFAULT,TRUE);                                              //http://a.com/기본폴더/admin/img/index.php

define("HERO_USER",                                                 HERO_END."user",TRUE);                                                          //http://a.com/기본폴더/hero/img
define("HERO_USER_END",                                             HERO_END."user".SLASH,TRUE);                                                    //http://a.com/기본폴더/hero/img/
define("HERO_USER_HOME",                                            HERO_USER_END.PAGE_DEFAULT,TRUE);                                               //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_USER",                                                 ROOT_END."user",TRUE);                                                          //http://a.com/기본폴더/img
define("ROOT_USER_END",                                             ROOT_END."user".SLASH,TRUE);                                                    //http://a.com/기본폴더/img/
define("ROOT_USER_HOME",                                            ROOT_USER_END.PAGE_DEFAULT,TRUE);                                               //http://a.com/기본폴더/img/index.php

define("ROOT_ADMIN_USER",                                           ADMIN_END."user",TRUE);                                                         //http://a.com/기본폴더/admin/img
define("ROOT_ADMIN_USER_END",                                       ADMIN_END."user".SLASH,TRUE);                                                   //http://a.com/기본폴더/admin/img/
define("ROOT_ADMIN_USER_HOME",                                      ROOT_ADMIN_USER_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/기본폴더/admin/img/index.php

define("ROOT_HERO_USER",                                            HERO_END."user",TRUE);                                                          //http://a.com/기본폴더/hero/img
define("ROOT_HERO_USER_END",                                        HERO_END."user".SLASH,TRUE);                                                    //http://a.com/기본폴더/hero/img/
define("ROOT_HERO_USER_HOME",                                       ROOT_HERO_USER_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_USER",                                                 HOME_END."user",TRUE);                                                          //http://a.com/기본폴더/img
define("HOME_USER_END",                                             HOME_END."user".SLASH,TRUE);                                                    //http://a.com/기본폴더/img/
define("HOME_USER_HOME",                                            HOME_USER_END.PAGE_DEFAULT,TRUE);                                               //http://a.com/기본폴더/img/index.php

define("HOME_ADMIN_USER",                                           ADMIN_END."user",TRUE);                                                         //http://a.com/기본폴더/admin/img
define("HOME_ADMIN_USER_END",                                       ADMIN_END."user".SLASH,TRUE);                                                   //http://a.com/기본폴더/admin/img/
define("HOME_ADMIN_USER_HOME",                                      HOME_ADMIN_USER_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/기본폴더/admin/img/index.php

define("HOME_HERO_USER",                                            HERO_END."user",TRUE);                                                          //http://a.com/기본폴더/hero/img
define("HOME_HERO_USER_END",                                        HERO_END."user".SLASH,TRUE);                                                    //http://a.com/기본폴더/hero/img/
define("HOME_HERO_USER_HOME",                                       HOME_HERO_USER_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_END)
####################################################################################################################################################
define("PATH_USER",                                                 PATH_END."user",TRUE);                                                          //http://a.com/현재폴더/img
define("PATH_USER_END",                                             PATH_END."user".SLASH,TRUE);                                                    //http://a.com/현재폴더/img/
define("PATH_USER_HOME",                                            PATH_USER_END.PAGE_DEFAULT,TRUE);                                               //http://a.com/현재폴더/img/index.php

define("PATH_ADMIN_USER",                                           PATH_ADMIN_END."user",TRUE);                                                    //http://a.com/현재폴더/admin/img
define("PATH_ADMIN_USER_END",                                       PATH_ADMIN_END."user".SLASH,TRUE);                                              //http://a.com/현재폴더/admin/img/
define("PATH_ADMIN_USER_HOME",                                      PATH_ADMIN_USER_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/현재폴더/admin/img/index.php

define("PATH_HERO_USER",                                            PATH_HERO_END."user",TRUE);                                                     //http://a.com/현재폴더/hero/img
define("PATH_HERO_USER_END",                                        PATH_HERO_END."user".SLASH,TRUE);                                               //http://a.com/현재폴더/hero/img/
define("PATH_HERO_USER_HOME",                                       PATH_HERO_USER_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/현재폴더/hero/img/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define("DOMAIN_USER_INC",                                           DOMAIN_INC_END."user",TRUE);                                                    //C:/APM_Setup/htdocs/img
define("DOMAIN_USER_INC_END",                                       DOMAIN_INC_END."user".SLASH,TRUE);                                              //C:/APM_Setup/htdocs/img/
define("DOMAIN_USER_INC_HOME",                                      DOMAIN_USER_INC_END.PAGE_DEFAULT,TRUE);                                         //C:/APM_Setup/htdocs/img/index.php

define("DOMAIN_ADMIN_USER_INC",                                     DOMAIN_ADMIN_INC_END."user",TRUE);                                              //C:/APM_Setup/htdocs/admin/img
define("DOMAIN_ADMIN_USER_INC_END",                                 DOMAIN_ADMIN_INC_END."user".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/admin/img/
define("DOMAIN_ADMIN_USER_INC_HOME",                                DOMAIN_ADMIN_USER_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/admin/img/index.php

define("DOMAIN_HERO_USER_INC",                                      DOMAIN_HERO_INC_END."user",TRUE);                                               //C:/APM_Setup/htdocs/hero/img
define("DOMAIN_HERO_USER_INC_END",                                  DOMAIN_HERO_INC_END."user".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/hero/img/
define("DOMAIN_HERO_USER_INC_HOME",                                 DOMAIN_HERO_USER_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_INC_END)
####################################################################################################################################################
define("USER_INC",                                                  HOME_INC_END."user",TRUE);                                                      //C:/APM_Setup/htdocs/기본폴더/img
define("USER_INC_END",                                              HOME_INC_END."user".SLASH,TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/img/
define("USER_INC_HOME",                                             USER_INC_END.PAGE_DEFAULT,TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ADMIN_USER_INC",                                            ADMIN_INC_END."user",TRUE);                                                     //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ADMIN_USER_INC_END",                                        ADMIN_INC_END."user".SLASH,TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ADMIN_USER_INC_HOME",                                       ADMIN_USER_INC_END.PAGE_DEFAULT,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HERO_USER_INC",                                             HERO_INC_END."user",TRUE);                                                      //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HERO_USER_INC_END",                                         HERO_INC_END."user".SLASH,TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HERO_USER_INC_HOME",                                        HERO_USER_INC_END.PAGE_DEFAULT,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_USER_INC",                                             ROOT_INC_END."user",TRUE);                                                      //C:/APM_Setup/htdocs/기본폴더/img
define("ROOT_USER_INC_END",                                         ROOT_INC_END."user".SLASH,TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/img/
define("ROOT_USER_INC_HOME",                                        ROOT_USER_INC_END.PAGE_DEFAULT,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ROOT_ADMIN_USER_INC",                                       ADMIN_INC_END."user",TRUE);                                                     //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ROOT_ADMIN_USER_INC_END",                                   ADMIN_INC_END."user".SLASH,TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ROOT_ADMIN_USER_INC_HOME",                                  ROOT_ADMIN_USER_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("ROOT_HERO_USER_INC",                                        HERO_INC_END."user",TRUE);                                                      //C:/APM_Setup/htdocs/기본폴더/hero/img
define("ROOT_HERO_USER_INC_END",                                    HERO_INC_END."user".SLASH,TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("ROOT_HERO_USER_INC_HOME",                                   ROOT_HERO_USER_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_USER_INC",                                             HOME_INC_END."user",TRUE);                                                      //C:/APM_Setup/htdocs/기본폴더/img
define("HOME_USER_INC_END",                                         HOME_INC_END."user".SLASH,TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/img/
define("HOME_USER_INC_HOME",                                        HOME_USER_INC_END.PAGE_DEFAULT,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("HOME_ADMIN_USER_INC",                                       ADMIN_INC_END."user",TRUE);                                                     //C:/APM_Setup/htdocs/기본폴더/admin/img
define("HOME_ADMIN_USER_INC_END",                                   ADMIN_INC_END."user".SLASH,TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("HOME_ADMIN_USER_INC_HOME",                                  HOME_ADMIN_USER_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HOME_HERO_USER_INC",                                        HERO_INC_END."user",TRUE);                                                      //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HOME_HERO_USER_INC_END",                                    HERO_INC_END."user".SLASH,TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HOME_HERO_USER_INC_HOME",                                   HOME_HERO_USER_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_INC_END)
####################################################################################################################################################
define("PATH_USER_INC",                                             PATH_INC_END."user",TRUE);                                                      //C:/APM_Setup/htdocs/현재폴더/img
define("PATH_USER_INC_END",                                         PATH_INC_END."user".SLASH,TRUE);                                                //C:/APM_Setup/htdocs/현재폴더/img/
define("PATH_USER_INC_HOME",                                        PATH_USER_INC_END.PAGE_DEFAULT,TRUE);                                           //C:/APM_Setup/htdocs/현재폴더/img/index.php

define("PATH_ADMIN_USER_INC",                                       PATH_ADMIN_INC_END."user",TRUE);                                                //C:/APM_Setup/htdocs/현재폴더/admin/img
define("PATH_ADMIN_USER_INC_END",                                   PATH_ADMIN_INC_END."user".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/현재폴더/admin/img/
define("PATH_ADMIN_USER_INC_HOME",                                  PATH_ADMIN_USER_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/현재폴더/admin/img/index.php

define("PATH_HERO_USER_INC",                                        PATH_HERO_INC_END."user",TRUE);                                                 //C:/APM_Setup/htdocs/현재폴더/hero/img
define("PATH_HERO_USER_INC_END",                                    PATH_HERO_INC_END."user".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/현재폴더/hero/img/
define("PATH_HERO_USER_INC_HOME",                                   PATH_HERO_USER_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/현재폴더/hero/img/index.php
####################################################################################################################################################
####################################################################################################################################################
define("DOMAIN_USER_UPLOAD",                                        DOMAIN_END."user/upload",TRUE);                                                 //http://a.com/img
define("DOMAIN_USER_UPLOAD_END",                                    DOMAIN_END."user/upload".SLASH,TRUE);                                           //http://a.com/img/
define("DOMAIN_USER_UPLOAD_HOME",                                   DOMAIN_USER_UPLOAD_END.PAGE_DEFAULT,TRUE);                                      //http://a.com/img/index.php

define("DOMAIN_ADMIN_USER_UPLOAD",                                  DOMAIN_ADMIN_END."user/upload",TRUE);                                           //http://a.com/admin/img
define("DOMAIN_ADMIN_USER_UPLOAD_END",                              DOMAIN_ADMIN_END."user/upload".SLASH,TRUE);                                     //http://a.com/admin/img/
define("DOMAIN_ADMIN_USER_UPLOAD_HOME",                             DOMAIN_ADMIN_USER_UPLOAD_END.PAGE_DEFAULT,TRUE);                                //http://a.com/admin/img/index.php

define("DOMAIN_HERO_USER_UPLOAD",                                   DOMAIN_HERO_END."user/upload",TRUE);                                            //http://a.com/hero/img
define("DOMAIN_HERO_USER_UPLOAD_END",                               DOMAIN_HERO_END."user/upload".SLASH,TRUE);                                      //http://a.com/hero/img/
define("DOMAIN_HERO_USER_UPLOAD_HOME",                              DOMAIN_HERO_USER_UPLOAD_END.PAGE_DEFAULT,TRUE);                                 //http://a.com/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_END)
####################################################################################################################################################
define("USER_UPLOAD",                                               HOME_END."user/upload",TRUE);                                                   //http://a.com/기본폴더/img
define("USER_UPLOAD_END",                                           HOME_END."user/upload".SLASH,TRUE);                                             //http://a.com/기본폴더/img/
define("USER_UPLOAD_HOME",                                          USER_UPLOAD_END.PAGE_DEFAULT,TRUE);                                             //http://a.com/기본폴더/img/index.php

define("ADMIN_USER_UPLOAD",                                         ADMIN_END."user/upload",TRUE);                                                  //http://a.com/기본폴더/admin/img
define("ADMIN_USER_UPLOAD_END",                                     ADMIN_END."user/upload".SLASH,TRUE);                                            //http://a.com/기본폴더/admin/img/
define("ADMIN_USER_UPLOAD_HOME",                                    ADMIN_USER_UPLOAD_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/기본폴더/admin/img/index.php

define("HERO_USER_UPLOAD",                                          HERO_END."user/upload",TRUE);                                                   //http://a.com/기본폴더/hero/img
define("HERO_USER_UPLOAD_END",                                      HERO_END."user/upload".SLASH,TRUE);                                             //http://a.com/기본폴더/hero/img/
define("HERO_USER_UPLOAD_HOME",                                     HERO_USER_UPLOAD_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_USER_UPLOAD",                                          ROOT_END."user/upload",TRUE);                                                   //http://a.com/기본폴더/img
define("ROOT_USER_UPLOAD_END",                                      ROOT_END."user/upload".SLASH,TRUE);                                             //http://a.com/기본폴더/img/
define("ROOT_USER_UPLOAD_HOME",                                     ROOT_USER_UPLOAD_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/기본폴더/img/index.php

define("ROOT_ADMIN_USER_UPLOAD",                                    ADMIN_END."user/upload",TRUE);                                                  //http://a.com/기본폴더/admin/img
define("ROOT_ADMIN_USER_UPLOAD_END",                                ADMIN_END."user/upload".SLASH,TRUE);                                            //http://a.com/기본폴더/admin/img/
define("ROOT_ADMIN_USER_UPLOAD_HOME",                               ROOT_ADMIN_USER_UPLOAD_END.PAGE_DEFAULT,TRUE);                                  //http://a.com/기본폴더/admin/img/index.php

define("ROOT_HERO_USER_UPLOAD",                                     HERO_END."user/upload",TRUE);                                                   //http://a.com/기본폴더/hero/img
define("ROOT_HERO_USER_UPLOAD_END",                                 HERO_END."user/upload".SLASH,TRUE);                                             //http://a.com/기본폴더/hero/img/
define("ROOT_HERO_USER_UPLOAD_HOME",                                ROOT_HERO_USER_UPLOAD_END.PAGE_DEFAULT,TRUE);                                   //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_USER_UPLOAD",                                          HOME_END."user/upload",TRUE);                                                   //http://a.com/기본폴더/img
define("HOME_USER_UPLOAD_END",                                      HOME_END."user/upload".SLASH,TRUE);                                             //http://a.com/기본폴더/img/
define("HOME_USER_UPLOAD_HOME",                                     HOME_USER_UPLOAD_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/기본폴더/img/index.php

define("HOME_ADMIN_USER_UPLOAD",                                    ADMIN_END."user/upload",TRUE);                                                  //http://a.com/기본폴더/admin/img
define("HOME_ADMIN_USER_UPLOAD_END",                                ADMIN_END."user/upload".SLASH,TRUE);                                            //http://a.com/기본폴더/admin/img/
define("HOME_ADMIN_USER_UPLOAD_HOME",                               HOME_ADMIN_USER_UPLOAD_END.PAGE_DEFAULT,TRUE);                                  //http://a.com/기본폴더/admin/img/index.php

define("HOME_HERO_USER_UPLOAD",                                     HERO_END."user/upload",TRUE);                                                   //http://a.com/기본폴더/hero/img
define("HOME_HERO_USER_UPLOAD_END",                                 HERO_END."user/upload".SLASH,TRUE);                                             //http://a.com/기본폴더/hero/img/
define("HOME_HERO_USER_UPLOAD_HOME",                                HOME_HERO_USER_UPLOAD_END.PAGE_DEFAULT,TRUE);                                   //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_END)
####################################################################################################################################################
define("PATH_USER_UPLOAD",                                          PATH_END."user/upload",TRUE);                                                   //http://a.com/현재폴더/img
define("PATH_USER_UPLOAD_END",                                      PATH_END."user/upload".SLASH,TRUE);                                             //http://a.com/현재폴더/img/
define("PATH_USER_UPLOAD_HOME",                                     PATH_USER_UPLOAD_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/현재폴더/img/index.php

define("PATH_ADMIN_USER_UPLOAD",                                    PATH_ADMIN_END."user/upload",TRUE);                                             //http://a.com/현재폴더/admin/img
define("PATH_ADMIN_USER_UPLOAD_END",                                PATH_ADMIN_END."user/upload".SLASH,TRUE);                                       //http://a.com/현재폴더/admin/img/
define("PATH_ADMIN_USER_UPLOAD_HOME",                               PATH_ADMIN_USER_UPLOAD_END.PAGE_DEFAULT,TRUE);                                  //http://a.com/현재폴더/admin/img/index.php

define("PATH_HERO_USER_UPLOAD",                                     PATH_HERO_END."user/upload",TRUE);                                              //http://a.com/현재폴더/hero/img
define("PATH_HERO_USER_UPLOAD_END",                                 PATH_HERO_END."user/upload".SLASH,TRUE);                                        //http://a.com/현재폴더/hero/img/
define("PATH_HERO_USER_UPLOAD_HOME",                                PATH_HERO_USER_UPLOAD_END.PAGE_DEFAULT,TRUE);                                   //http://a.com/현재폴더/hero/img/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define("DOMAIN_USER_UPLOAD_INC",                                    DOMAIN_INC_END."user/upload",TRUE);                                             //C:/APM_Setup/htdocs/img
define("DOMAIN_USER_UPLOAD_INC_END",                                DOMAIN_INC_END."user/upload".SLASH,TRUE);                                       //C:/APM_Setup/htdocs/img/
define("DOMAIN_USER_UPLOAD_INC_HOME",                               DOMAIN_USER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                                  //C:/APM_Setup/htdocs/img/index.php

define("DOMAIN_ADMIN_USER_UPLOAD_INC",                              DOMAIN_ADMIN_INC_END."user/upload",TRUE);                                       //C:/APM_Setup/htdocs/admin/img
define("DOMAIN_ADMIN_USER_UPLOAD_INC_END",                          DOMAIN_ADMIN_INC_END."user/upload".SLASH,TRUE);                                 //C:/APM_Setup/htdocs/admin/img/
define("DOMAIN_ADMIN_USER_UPLOAD_INC_HOME",                         DOMAIN_ADMIN_USER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                            //C:/APM_Setup/htdocs/admin/img/index.php

define("DOMAIN_HERO_USER_UPLOAD_INC",                               DOMAIN_HERO_INC_END."user/upload",TRUE);                                        //C:/APM_Setup/htdocs/hero/img
define("DOMAIN_HERO_USER_UPLOAD_INC_END",                           DOMAIN_HERO_INC_END."user/upload".SLASH,TRUE);                                  //C:/APM_Setup/htdocs/hero/img/
define("DOMAIN_HERO_USER_UPLOAD_INC_HOME",                          DOMAIN_HERO_USER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                             //C:/APM_Setup/htdocs/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_INC_END)
####################################################################################################################################################
define("USER_UPLOAD_INC",                                           HOME_INC_END."user/upload",TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/img
define("USER_UPLOAD_INC_END",                                       HOME_INC_END."user/upload".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/img/
define("USER_UPLOAD_INC_HOME",                                      USER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ADMIN_USER_UPLOAD_INC",                                     ADMIN_INC_END."user/upload",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ADMIN_USER_UPLOAD_INC_END",                                 ADMIN_INC_END."user/upload".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ADMIN_USER_UPLOAD_INC_HOME",                                ADMIN_USER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HERO_USER_UPLOAD_INC",                                      HERO_INC_END."user/upload",TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HERO_USER_UPLOAD_INC_END",                                  HERO_INC_END."user/upload".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HERO_USER_UPLOAD_INC_HOME",                                 HERO_USER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_USER_UPLOAD_INC",                                      ROOT_INC_END."user/upload",TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/img
define("ROOT_USER_UPLOAD_INC_END",                                  ROOT_INC_END."user/upload".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/img/
define("ROOT_USER_UPLOAD_INC_HOME",                                 ROOT_USER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ROOT_ADMIN_USER_UPLOAD_INC",                                ADMIN_INC_END."user/upload",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ROOT_ADMIN_USER_UPLOAD_INC_END",                            ADMIN_INC_END."user/upload".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ROOT_ADMIN_USER_UPLOAD_INC_HOME",                           ROOT_ADMIN_USER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                              //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("ROOT_HERO_USER_UPLOAD_INC",                                 HERO_INC_END."user/upload",TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/hero/img
define("ROOT_HERO_USER_UPLOAD_INC_END",                             HERO_INC_END."user/upload".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("ROOT_HERO_USER_UPLOAD_INC_HOME",                            ROOT_HERO_USER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                               //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_USER_UPLOAD_INC",                                      HOME_INC_END."user/upload",TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/img
define("HOME_USER_UPLOAD_INC_END",                                  HOME_INC_END."user/upload".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/img/
define("HOME_USER_UPLOAD_INC_HOME",                                 HOME_USER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("HOME_ADMIN_USER_UPLOAD_INC",                                ADMIN_INC_END."user/upload",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/admin/img
define("HOME_ADMIN_USER_UPLOAD_INC_END",                            ADMIN_INC_END."user/upload".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("HOME_ADMIN_USER_UPLOAD_INC_HOME",                           HOME_ADMIN_USER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                              //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HOME_HERO_USER_UPLOAD_INC",                                 HERO_INC_END."user/upload",TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HOME_HERO_USER_UPLOAD_INC_END",                             HERO_INC_END."user/upload".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HOME_HERO_USER_UPLOAD_INC_HOME",                            HOME_HERO_USER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                               //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_INC_END)
####################################################################################################################################################
define("PATH_USER_UPLOAD_INC",                                      PATH_INC_END."user/upload",TRUE);                                               //C:/APM_Setup/htdocs/현재폴더/img
define("PATH_USER_UPLOAD_INC_END",                                  PATH_INC_END."user/upload".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/현재폴더/img/
define("PATH_USER_UPLOAD_INC_HOME",                                 PATH_USER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/현재폴더/img/index.php

define("PATH_ADMIN_USER_UPLOAD_INC",                                PATH_ADMIN_INC_END."user/upload",TRUE);                                         //C:/APM_Setup/htdocs/현재폴더/admin/img
define("PATH_ADMIN_USER_UPLOAD_INC_END",                            PATH_ADMIN_INC_END."user/upload".SLASH,TRUE);                                   //C:/APM_Setup/htdocs/현재폴더/admin/img/
define("PATH_ADMIN_USER_UPLOAD_INC_HOME",                           PATH_ADMIN_USER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                              //C:/APM_Setup/htdocs/현재폴더/admin/img/index.php

define("PATH_HERO_USER_UPLOAD_INC",                                 PATH_HERO_INC_END."user/upload",TRUE);                                          //C:/APM_Setup/htdocs/현재폴더/hero/img
define("PATH_HERO_USER_UPLOAD_INC_END",                             PATH_HERO_INC_END."user/upload".SLASH,TRUE);                                    //C:/APM_Setup/htdocs/현재폴더/hero/img/
define("PATH_HERO_USER_UPLOAD_INC_HOME",                            PATH_HERO_USER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                               //C:/APM_Setup/htdocs/현재폴더/hero/img/index.php
####################################################################################################################################################
####################################################################################################################################################
define("DOMAIN_USER_FILE",                                          DOMAIN_END."user/file",TRUE);                                                   //http://a.com/img
define("DOMAIN_USER_FILE_END",                                      DOMAIN_END."user/file".SLASH,TRUE);                                             //http://a.com/img/
define("DOMAIN_USER_FILE_HOME",                                     DOMAIN_USER_FILE_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/img/index.php

define("DOMAIN_ADMIN_USER_FILE",                                    DOMAIN_ADMIN_END."user/file",TRUE);                                             //http://a.com/admin/img
define("DOMAIN_ADMIN_USER_FILE_END",                                DOMAIN_ADMIN_END."user/file".SLASH,TRUE);                                       //http://a.com/admin/img/
define("DOMAIN_ADMIN_USER_FILE_HOME",                               DOMAIN_ADMIN_USER_FILE_END.PAGE_DEFAULT,TRUE);                                  //http://a.com/admin/img/index.php

define("DOMAIN_HERO_USER_FILE",                                     DOMAIN_HERO_END."user/file",TRUE);                                              //http://a.com/hero/img
define("DOMAIN_HERO_USER_FILE_END",                                 DOMAIN_HERO_END."user/file".SLASH,TRUE);                                        //http://a.com/hero/img/
define("DOMAIN_HERO_USER_FILE_HOME",                                DOMAIN_HERO_USER_FILE_END.PAGE_DEFAULT,TRUE);                                   //http://a.com/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_END)
####################################################################################################################################################
define("USER_FILE",                                                 HOME_END."user/file",TRUE);                                                     //http://a.com/기본폴더/img
define("USER_FILE_END",                                             HOME_END."user/file".SLASH,TRUE);                                               //http://a.com/기본폴더/img/
define("USER_FILE_HOME",                                            USER_FILE_END.PAGE_DEFAULT,TRUE);                                               //http://a.com/기본폴더/img/index.php

define("ADMIN_USER_FILE",                                           ADMIN_END."user/file",TRUE);                                                    //http://a.com/기본폴더/admin/img
define("ADMIN_USER_FILE_END",                                       ADMIN_END."user/file".SLASH,TRUE);                                              //http://a.com/기본폴더/admin/img/
define("ADMIN_USER_FILE_HOME",                                      ADMIN_USER_FILE_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/기본폴더/admin/img/index.php

define("HERO_USER_FILE",                                            HERO_END."user/file",TRUE);                                                     //http://a.com/기본폴더/hero/img
define("HERO_USER_FILE_END",                                        HERO_END."user/file".SLASH,TRUE);                                               //http://a.com/기본폴더/hero/img/
define("HERO_USER_FILE_HOME",                                       HERO_USER_FILE_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_USER_FILE",                                            ROOT_END."user/file",TRUE);                                                     //http://a.com/기본폴더/img
define("ROOT_USER_FILE_END",                                        ROOT_END."user/file".SLASH,TRUE);                                               //http://a.com/기본폴더/img/
define("ROOT_USER_FILE_HOME",                                       ROOT_USER_FILE_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/기본폴더/img/index.php

define("ROOT_ADMIN_USER_FILE",                                      ADMIN_END."user/file",TRUE);                                                    //http://a.com/기본폴더/admin/img
define("ROOT_ADMIN_USER_FILE_END",                                  ADMIN_END."user/file".SLASH,TRUE);                                              //http://a.com/기본폴더/admin/img/
define("ROOT_ADMIN_USER_FILE_HOME",                                 ROOT_ADMIN_USER_FILE_END.PAGE_DEFAULT,TRUE);                                    //http://a.com/기본폴더/admin/img/index.php

define("ROOT_HERO_USER_FILE",                                       HERO_END."user/file",TRUE);                                                     //http://a.com/기본폴더/hero/img
define("ROOT_HERO_USER_FILE_END",                                   HERO_END."user/file".SLASH,TRUE);                                               //http://a.com/기본폴더/hero/img/
define("ROOT_HERO_USER_FILE_HOME",                                  ROOT_HERO_USER_FILE_END.PAGE_DEFAULT,TRUE);                                     //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_USER_FILE",                                            HOME_END."user/file",TRUE);                                                     //http://a.com/기본폴더/img
define("HOME_USER_FILE_END",                                        HOME_END."user/file".SLASH,TRUE);                                               //http://a.com/기본폴더/img/
define("HOME_USER_FILE_HOME",                                       HOME_USER_FILE_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/기본폴더/img/index.php

define("HOME_ADMIN_USER_FILE",                                      ADMIN_END."user/file",TRUE);                                                    //http://a.com/기본폴더/admin/img
define("HOME_ADMIN_USER_FILE_END",                                  ADMIN_END."user/file".SLASH,TRUE);                                              //http://a.com/기본폴더/admin/img/
define("HOME_ADMIN_USER_FILE_HOME",                                 HOME_ADMIN_USER_FILE_END.PAGE_DEFAULT,TRUE);                                    //http://a.com/기본폴더/admin/img/index.php

define("HOME_HERO_USER_FILE",                                       HERO_END."user/file",TRUE);                                                     //http://a.com/기본폴더/hero/img
define("HOME_HERO_USER_FILE_END",                                   HERO_END."user/file".SLASH,TRUE);                                               //http://a.com/기본폴더/hero/img/
define("HOME_HERO_USER_FILE_HOME",                                  HOME_HERO_USER_FILE_END.PAGE_DEFAULT,TRUE);                                     //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_END)
####################################################################################################################################################
define("PATH_USER_FILE",                                            PATH_END."user/file",TRUE);                                                     //http://a.com/현재폴더/img
define("PATH_USER_FILE_END",                                        PATH_END."user/file".SLASH,TRUE);                                               //http://a.com/현재폴더/img/
define("PATH_USER_FILE_HOME",                                       PATH_USER_FILE_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/현재폴더/img/index.php

define("PATH_ADMIN_USER_FILE",                                      PATH_ADMIN_END."user/file",TRUE);                                               //http://a.com/현재폴더/admin/img
define("PATH_ADMIN_USER_FILE_END",                                  PATH_ADMIN_END."user/file".SLASH,TRUE);                                         //http://a.com/현재폴더/admin/img/
define("PATH_ADMIN_USER_FILE_HOME",                                 PATH_ADMIN_USER_FILE_END.PAGE_DEFAULT,TRUE);                                    //http://a.com/현재폴더/admin/img/index.php

define("PATH_HERO_USER_FILE",                                       PATH_HERO_END."user/file",TRUE);                                                //http://a.com/현재폴더/hero/img
define("PATH_HERO_USER_FILE_END",                                   PATH_HERO_END."user/file".SLASH,TRUE);                                          //http://a.com/현재폴더/hero/img/
define("PATH_HERO_USER_FILE_HOME",                                  PATH_HERO_USER_FILE_END.PAGE_DEFAULT,TRUE);                                     //http://a.com/현재폴더/hero/img/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define("DOMAIN_USER_FILE_INC",                                      DOMAIN_INC_END."user/file",TRUE);                                               //C:/APM_Setup/htdocs/img
define("DOMAIN_USER_FILE_INC_END",                                  DOMAIN_INC_END."user/file".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/img/
define("DOMAIN_USER_FILE_INC_HOME",                                 DOMAIN_USER_FILE_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/img/index.php

define("DOMAIN_ADMIN_USER_FILE_INC",                                DOMAIN_ADMIN_INC_END."user/file",TRUE);                                         //C:/APM_Setup/htdocs/admin/img
define("DOMAIN_ADMIN_USER_FILE_INC_END",                            DOMAIN_ADMIN_INC_END."user/file".SLASH,TRUE);                                   //C:/APM_Setup/htdocs/admin/img/
define("DOMAIN_ADMIN_USER_FILE_INC_HOME",                           DOMAIN_ADMIN_USER_FILE_INC_END.PAGE_DEFAULT,TRUE);                              //C:/APM_Setup/htdocs/admin/img/index.php

define("DOMAIN_HERO_USER_FILE_INC",                                 DOMAIN_HERO_INC_END."user/file",TRUE);                                          //C:/APM_Setup/htdocs/hero/img
define("DOMAIN_HERO_USER_FILE_INC_END",                             DOMAIN_HERO_INC_END."user/file".SLASH,TRUE);                                    //C:/APM_Setup/htdocs/hero/img/
define("DOMAIN_HERO_USER_FILE_INC_HOME",                            DOMAIN_HERO_USER_FILE_INC_END.PAGE_DEFAULT,TRUE);                               //C:/APM_Setup/htdocs/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_INC_END)
####################################################################################################################################################
define("USER_FILE_INC",                                             HOME_INC_END."user/file",TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/img
define("USER_FILE_INC_END",                                         HOME_INC_END."user/file".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/img/
define("USER_FILE_INC_HOME",                                        USER_FILE_INC_END.PAGE_DEFAULT,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ADMIN_USER_FILE_INC",                                       ADMIN_INC_END."user/file",TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ADMIN_USER_FILE_INC_END",                                   ADMIN_INC_END."user/file".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ADMIN_USER_FILE_INC_HOME",                                  ADMIN_USER_FILE_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HERO_USER_FILE_INC",                                        HERO_INC_END."user/file",TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HERO_USER_FILE_INC_END",                                    HERO_INC_END."user/file".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HERO_USER_FILE_INC_HOME",                                   HERO_USER_FILE_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_USER_FILE_INC",                                        ROOT_INC_END."user/file",TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/img
define("ROOT_USER_FILE_INC_END",                                    ROOT_INC_END."user/file".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/img/
define("ROOT_USER_FILE_INC_HOME",                                   ROOT_USER_FILE_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ROOT_ADMIN_USER_FILE_INC",                                  ADMIN_INC_END."user/file",TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ROOT_ADMIN_USER_FILE_INC_END",                              ADMIN_INC_END."user/file".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ROOT_ADMIN_USER_FILE_INC_HOME",                             ROOT_ADMIN_USER_FILE_INC_END.PAGE_DEFAULT,TRUE);                                //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("ROOT_HERO_USER_FILE_INC",                                   HERO_INC_END."user/file",TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/hero/img
define("ROOT_HERO_USER_FILE_INC_END",                               HERO_INC_END."user/file".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("ROOT_HERO_USER_FILE_INC_HOME",                              ROOT_HERO_USER_FILE_INC_END.PAGE_DEFAULT,TRUE);                                 //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_USER_FILE_INC",                                        HOME_INC_END."user/file",TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/img
define("HOME_USER_FILE_INC_END",                                    HOME_INC_END."user/file".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/img/
define("HOME_USER_FILE_INC_HOME",                                   HOME_USER_FILE_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("HOME_ADMIN_USER_FILE_INC",                                  ADMIN_INC_END."user/file",TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/admin/img
define("HOME_ADMIN_USER_FILE_INC_END",                              ADMIN_INC_END."user/file".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("HOME_ADMIN_USER_FILE_INC_HOME",                             HOME_ADMIN_USER_FILE_INC_END.PAGE_DEFAULT,TRUE);                                //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HOME_HERO_USER_FILE_INC",                                   HERO_INC_END."user/file",TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HOME_HERO_USER_FILE_INC_END",                               HERO_INC_END."user/file".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HOME_HERO_USER_FILE_INC_HOME",                              HOME_HERO_USER_FILE_INC_END.PAGE_DEFAULT,TRUE);                                 //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_INC_END)
####################################################################################################################################################
define("PATH_USER_FILE_INC",                                        PATH_INC_END."user/file",TRUE);                                                 //C:/APM_Setup/htdocs/현재폴더/img
define("PATH_USER_FILE_INC_END",                                    PATH_INC_END."user/file".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/현재폴더/img/
define("PATH_USER_FILE_INC_HOME",                                   PATH_USER_FILE_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/현재폴더/img/index.php

define("PATH_ADMIN_USER_FILE_INC",                                  PATH_ADMIN_INC_END."user/file",TRUE);                                           //C:/APM_Setup/htdocs/현재폴더/admin/img
define("PATH_ADMIN_USER_FILE_INC_END",                              PATH_ADMIN_INC_END."user/file".SLASH,TRUE);                                     //C:/APM_Setup/htdocs/현재폴더/admin/img/
define("PATH_ADMIN_USER_FILE_INC_HOME",                             PATH_ADMIN_USER_FILE_INC_END.PAGE_DEFAULT,TRUE);                                //C:/APM_Setup/htdocs/현재폴더/admin/img/index.php

define("PATH_HERO_USER_FILE_INC",                                   PATH_HERO_INC_END."user/file",TRUE);                                            //C:/APM_Setup/htdocs/현재폴더/hero/img
define("PATH_HERO_USER_FILE_INC_END",                               PATH_HERO_INC_END."user/file".SLASH,TRUE);                                      //C:/APM_Setup/htdocs/현재폴더/hero/img/
define("PATH_HERO_USER_FILE_INC_HOME",                              PATH_HERO_USER_FILE_INC_END.PAGE_DEFAULT,TRUE);                                 //C:/APM_Setup/htdocs/현재폴더/hero/img/index.php
####################################################################################################################################################
####################################################################################################################################################
define("DOMAIN_USER_PHOTO",                                         DOMAIN_END."user/photo",TRUE);                                                  //http://a.com/img
define("DOMAIN_USER_PHOTO_END",                                     DOMAIN_END."user/photo".SLASH,TRUE);                                            //http://a.com/img/
define("DOMAIN_USER_PHOTO_HOME",                                    DOMAIN_USER_PHOTO_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/img/index.php

define("DOMAIN_ADMIN_USER_PHOTO",                                   DOMAIN_ADMIN_END."user/photo",TRUE);                                            //http://a.com/admin/img
define("DOMAIN_ADMIN_USER_PHOTO_END",                               DOMAIN_ADMIN_END."user/photo".SLASH,TRUE);                                      //http://a.com/admin/img/
define("DOMAIN_ADMIN_USER_PHOTO_HOME",                              DOMAIN_ADMIN_USER_PHOTO_END.PAGE_DEFAULT,TRUE);                                 //http://a.com/admin/img/index.php

define("DOMAIN_HERO_USER_PHOTO",                                    DOMAIN_HERO_END."user/photo",TRUE);                                             //http://a.com/hero/img
define("DOMAIN_HERO_USER_PHOTO_END",                                DOMAIN_HERO_END."user/photo".SLASH,TRUE);                                       //http://a.com/hero/img/
define("DOMAIN_HERO_USER_PHOTO_HOME",                               DOMAIN_HERO_USER_PHOTO_END.PAGE_DEFAULT,TRUE);                                  //http://a.com/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_END)
####################################################################################################################################################
define("USER_PHOTO",                                                HOME_END."user/photo",TRUE);                                                    //http://a.com/기본폴더/img
define("USER_PHOTO_END",                                            HOME_END."user/photo".SLASH,TRUE);                                              //http://a.com/기본폴더/img/
define("USER_PHOTO_HOME",                                           USER_PHOTO_END.PAGE_DEFAULT,TRUE);                                              //http://a.com/기본폴더/img/index.php

define("ADMIN_USER_PHOTO",                                          ADMIN_END."user/photo",TRUE);                                                   //http://a.com/기본폴더/admin/img
define("ADMIN_USER_PHOTO_END",                                      ADMIN_END."user/photo".SLASH,TRUE);                                             //http://a.com/기본폴더/admin/img/
define("ADMIN_USER_PHOTO_HOME",                                     ADMIN_USER_PHOTO_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/기본폴더/admin/img/index.php

define("HERO_USER_PHOTO",                                           HERO_END."user/photo",TRUE);                                                    //http://a.com/기본폴더/hero/img
define("HERO_USER_PHOTO_END",                                       HERO_END."user/photo".SLASH,TRUE);                                              //http://a.com/기본폴더/hero/img/
define("HERO_USER_PHOTO_HOME",                                      HERO_USER_PHOTO_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_USER_PHOTO",                                           ROOT_END."user/photo",TRUE);                                                    //http://a.com/기본폴더/img
define("ROOT_USER_PHOTO_END",                                       ROOT_END."user/photo".SLASH,TRUE);                                              //http://a.com/기본폴더/img/
define("ROOT_USER_PHOTO_HOME",                                      ROOT_USER_PHOTO_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/기본폴더/img/index.php

define("ROOT_ADMIN_USER_PHOTO",                                     ADMIN_END."user/photo",TRUE);                                                   //http://a.com/기본폴더/admin/img
define("ROOT_ADMIN_USER_PHOTO_END",                                 ADMIN_END."user/photo".SLASH,TRUE);                                             //http://a.com/기본폴더/admin/img/
define("ROOT_ADMIN_USER_PHOTO_HOME",                                ROOT_ADMIN_USER_PHOTO_END.PAGE_DEFAULT,TRUE);                                   //http://a.com/기본폴더/admin/img/index.php

define("ROOT_HERO_USER_PHOTO",                                      HERO_END."user/photo",TRUE);                                                    //http://a.com/기본폴더/hero/img
define("ROOT_HERO_USER_PHOTO_END",                                  HERO_END."user/photo".SLASH,TRUE);                                              //http://a.com/기본폴더/hero/img/
define("ROOT_HERO_USER_PHOTO_HOME",                                 ROOT_HERO_USER_PHOTO_END.PAGE_DEFAULT,TRUE);                                    //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_USER_PHOTO",                                           HOME_END."user/photo",TRUE);                                                    //http://a.com/기본폴더/img
define("HOME_USER_PHOTO_END",                                       HOME_END."user/photo".SLASH,TRUE);                                              //http://a.com/기본폴더/img/
define("HOME_USER_PHOTO_HOME",                                      HOME_USER_PHOTO_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/기본폴더/img/index.php

define("HOME_ADMIN_USER_PHOTO",                                     ADMIN_END."user/photo",TRUE);                                                   //http://a.com/기본폴더/admin/img
define("HOME_ADMIN_USER_PHOTO_END",                                 ADMIN_END."user/photo".SLASH,TRUE);                                             //http://a.com/기본폴더/admin/img/
define("HOME_ADMIN_USER_PHOTO_HOME",                                HOME_ADMIN_USER_PHOTO_END.PAGE_DEFAULT,TRUE);                                   //http://a.com/기본폴더/admin/img/index.php

define("HOME_HERO_USER_PHOTO",                                      HERO_END."user/photo",TRUE);                                                    //http://a.com/기본폴더/hero/img
define("HOME_HERO_USER_PHOTO_END",                                  HERO_END."user/photo".SLASH,TRUE);                                              //http://a.com/기본폴더/hero/img/
define("HOME_HERO_USER_PHOTO_HOME",                                 HOME_HERO_USER_PHOTO_END.PAGE_DEFAULT,TRUE);                                    //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_END)
####################################################################################################################################################
define("PATH_USER_PHOTO",                                           PATH_END."user/photo",TRUE);                                                    //http://a.com/현재폴더/img
define("PATH_USER_PHOTO_END",                                       PATH_END."user/photo".SLASH,TRUE);                                              //http://a.com/현재폴더/img/
define("PATH_USER_PHOTO_HOME",                                      PATH_USER_PHOTO_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/현재폴더/img/index.php

define("PATH_ADMIN_USER_PHOTO",                                     PATH_ADMIN_END."user/photo",TRUE);                                              //http://a.com/현재폴더/admin/img
define("PATH_ADMIN_USER_PHOTO_END",                                 PATH_ADMIN_END."user/photo".SLASH,TRUE);                                        //http://a.com/현재폴더/admin/img/
define("PATH_ADMIN_USER_PHOTO_HOME",                                PATH_ADMIN_USER_PHOTO_END.PAGE_DEFAULT,TRUE);                                   //http://a.com/현재폴더/admin/img/index.php

define("PATH_HERO_USER_PHOTO",                                      PATH_HERO_END."user/photo",TRUE);                                               //http://a.com/현재폴더/hero/img
define("PATH_HERO_USER_PHOTO_END",                                  PATH_HERO_END."user/photo".SLASH,TRUE);                                         //http://a.com/현재폴더/hero/img/
define("PATH_HERO_USER_PHOTO_HOME",                                 PATH_HERO_USER_PHOTO_END.PAGE_DEFAULT,TRUE);                                    //http://a.com/현재폴더/hero/img/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define("DOMAIN_USER_PHOTO_INC",                                     DOMAIN_INC_END."user/photo",TRUE);                                              //C:/APM_Setup/htdocs/img
define("DOMAIN_USER_PHOTO_INC_END",                                 DOMAIN_INC_END."user/photo".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/img/
define("DOMAIN_USER_PHOTO_INC_HOME",                                DOMAIN_USER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/img/index.php

define("DOMAIN_ADMIN_USER_PHOTO_INC",                               DOMAIN_ADMIN_INC_END."user/photo",TRUE);                                        //C:/APM_Setup/htdocs/admin/img
define("DOMAIN_ADMIN_USER_PHOTO_INC_END",                           DOMAIN_ADMIN_INC_END."user/photo".SLASH,TRUE);                                  //C:/APM_Setup/htdocs/admin/img/
define("DOMAIN_ADMIN_USER_PHOTO_INC_HOME",                          DOMAIN_ADMIN_USER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                             //C:/APM_Setup/htdocs/admin/img/index.php

define("DOMAIN_HERO_USER_PHOTO_INC",                                DOMAIN_HERO_INC_END."user/photo",TRUE);                                         //C:/APM_Setup/htdocs/hero/img
define("DOMAIN_HERO_USER_PHOTO_INC_END",                            DOMAIN_HERO_INC_END."user/photo".SLASH,TRUE);                                   //C:/APM_Setup/htdocs/hero/img/
define("DOMAIN_HERO_USER_PHOTO_INC_HOME",                           DOMAIN_HERO_USER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                              //C:/APM_Setup/htdocs/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_INC_END)
####################################################################################################################################################
define("USER_PHOTO_INC",                                            HOME_INC_END."user/photo",TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/img
define("USER_PHOTO_INC_END",                                        HOME_INC_END."user/photo".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/img/
define("USER_PHOTO_INC_HOME",                                       USER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ADMIN_USER_PHOTO_INC",                                      ADMIN_INC_END."user/photo",TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ADMIN_USER_PHOTO_INC_END",                                  ADMIN_INC_END."user/photo".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ADMIN_USER_PHOTO_INC_HOME",                                 ADMIN_USER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HERO_USER_PHOTO_INC",                                       HERO_INC_END."user/photo",TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HERO_USER_PHOTO_INC_END",                                   HERO_INC_END."user/photo".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HERO_USER_PHOTO_INC_HOME",                                  HERO_USER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_USER_PHOTO_INC",                                       ROOT_INC_END."user/photo",TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/img
define("ROOT_USER_PHOTO_INC_END",                                   ROOT_INC_END."user/photo".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/img/
define("ROOT_USER_PHOTO_INC_HOME",                                  ROOT_USER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ROOT_ADMIN_USER_PHOTO_INC",                                 ADMIN_INC_END."user/photo",TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ROOT_ADMIN_USER_PHOTO_INC_END",                             ADMIN_INC_END."user/photo".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ROOT_ADMIN_USER_PHOTO_INC_HOME",                            ROOT_ADMIN_USER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                               //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("ROOT_HERO_USER_PHOTO_INC",                                  HERO_INC_END."user/photo",TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/hero/img
define("ROOT_HERO_USER_PHOTO_INC_END",                              HERO_INC_END."user/photo".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("ROOT_HERO_USER_PHOTO_INC_HOME",                             ROOT_HERO_USER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                                //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_USER_PHOTO_INC",                                       HOME_INC_END."user/photo",TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/img
define("HOME_USER_PHOTO_INC_END",                                   HOME_INC_END."user/photo".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/img/
define("HOME_USER_PHOTO_INC_HOME",                                  HOME_USER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("HOME_ADMIN_USER_PHOTO_INC",                                 ADMIN_INC_END."user/photo",TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/admin/img
define("HOME_ADMIN_USER_PHOTO_INC_END",                             ADMIN_INC_END."user/photo".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("HOME_ADMIN_USER_PHOTO_INC_HOME",                            HOME_ADMIN_USER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                               //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HOME_HERO_USER_PHOTO_INC",                                  HERO_INC_END."user/photo",TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HOME_HERO_USER_PHOTO_INC_END",                              HERO_INC_END."user/photo".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HOME_HERO_USER_PHOTO_INC_HOME",                             HOME_HERO_USER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                                //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_INC_END)
####################################################################################################################################################
define("PATH_USER_PHOTO_INC",                                       PATH_INC_END."user/photo",TRUE);                                                //C:/APM_Setup/htdocs/현재폴더/img
define("PATH_USER_PHOTO_INC_END",                                   PATH_INC_END."user/photo".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/현재폴더/img/
define("PATH_USER_PHOTO_INC_HOME",                                  PATH_USER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/현재폴더/img/index.php

define("PATH_ADMIN_USER_PHOTO_INC",                                 PATH_ADMIN_INC_END."user/photo",TRUE);                                          //C:/APM_Setup/htdocs/현재폴더/admin/img
define("PATH_ADMIN_USER_PHOTO_INC_END",                             PATH_ADMIN_INC_END."user/photo".SLASH,TRUE);                                    //C:/APM_Setup/htdocs/현재폴더/admin/img/
define("PATH_ADMIN_USER_PHOTO_INC_HOME",                            PATH_ADMIN_USER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                               //C:/APM_Setup/htdocs/현재폴더/admin/img/index.php

define("PATH_HERO_USER_PHOTO_INC",                                  PATH_HERO_INC_END."user/photo",TRUE);                                           //C:/APM_Setup/htdocs/현재폴더/hero/img
define("PATH_HERO_USER_PHOTO_INC_END",                              PATH_HERO_INC_END."user/photo".SLASH,TRUE);                                     //C:/APM_Setup/htdocs/현재폴더/hero/img/
define("PATH_HERO_USER_PHOTO_INC_HOME",                             PATH_HERO_USER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                                //C:/APM_Setup/htdocs/현재폴더/hero/img/index.php
####################################################################################################################################################
####################################################################################################################################################
define("DOMAIN_AKLOVER",                                            DOMAIN_END."aklover",TRUE);                                                     //http://a.com/img
define("DOMAIN_AKLOVER_END",                                        DOMAIN_END."aklover".SLASH,TRUE);                                               //http://a.com/img/
define("DOMAIN_AKLOVER_HOME",                                       DOMAIN_AKLOVER_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/img/index.php

define("DOMAIN_ADMIN_AKLOVER",                                      DOMAIN_ADMIN_END."aklover",TRUE);                                               //http://a.com/admin/img
define("DOMAIN_ADMIN_AKLOVER_END",                                  DOMAIN_ADMIN_END."aklover".SLASH,TRUE);                                         //http://a.com/admin/img/
define("DOMAIN_ADMIN_AKLOVER_HOME",                                 DOMAIN_ADMIN_AKLOVER_END.PAGE_DEFAULT,TRUE);                                    //http://a.com/admin/img/index.php

define("DOMAIN_HERO_AKLOVER",                                       DOMAIN_HERO_END."aklover",TRUE);                                                //http://a.com/hero/img
define("DOMAIN_HERO_AKLOVER_END",                                   DOMAIN_HERO_END."aklover".SLASH,TRUE);                                          //http://a.com/hero/img/
define("DOMAIN_HERO_AKLOVER_HOME",                                  DOMAIN_HERO_AKLOVER_END.PAGE_DEFAULT,TRUE);                                     //http://a.com/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_END)
####################################################################################################################################################
define("AKLOVER",                                                   HOME_END."aklover",TRUE);                                                       //http://a.com/기본폴더/img
define("AKLOVER_END",                                               HOME_END."aklover".SLASH,TRUE);                                                 //http://a.com/기본폴더/img/
define("AKLOVER_HOME",                                              AKLOVER_END.PAGE_DEFAULT,TRUE);                                                 //http://a.com/기본폴더/img/index.php

define("ADMIN_AKLOVER",                                             ADMIN_END."aklover",TRUE);                                                      //http://a.com/기본폴더/admin/img
define("ADMIN_AKLOVER_END",                                         ADMIN_END."aklover".SLASH,TRUE);                                                //http://a.com/기본폴더/admin/img/
define("ADMIN_AKLOVER_HOME",                                        ADMIN_AKLOVER_END.PAGE_DEFAULT,TRUE);                                           //http://a.com/기본폴더/admin/img/index.php

define("HERO_AKLOVER",                                              HERO_END."aklover",TRUE);                                                       //http://a.com/기본폴더/hero/img
define("HERO_AKLOVER_END",                                          HERO_END."aklover".SLASH,TRUE);                                                 //http://a.com/기본폴더/hero/img/
define("HERO_AKLOVER_HOME",                                         HERO_AKLOVER_END.PAGE_DEFAULT,TRUE);                                            //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_AKLOVER",                                              ROOT_END."aklover",TRUE);                                                       //http://a.com/기본폴더/img
define("ROOT_AKLOVER_END",                                          ROOT_END."aklover".SLASH,TRUE);                                                 //http://a.com/기본폴더/img/
define("ROOT_AKLOVER_HOME",                                         ROOT_AKLOVER_END.PAGE_DEFAULT,TRUE);                                            //http://a.com/기본폴더/img/index.php

define("ROOT_ADMIN_AKLOVER",                                        ADMIN_END."aklover",TRUE);                                                      //http://a.com/기본폴더/admin/img
define("ROOT_ADMIN_AKLOVER_END",                                    ADMIN_END."aklover".SLASH,TRUE);                                                //http://a.com/기본폴더/admin/img/
define("ROOT_ADMIN_AKLOVER_HOME",                                   ROOT_ADMIN_AKLOVER_END.PAGE_DEFAULT,TRUE);                                      //http://a.com/기본폴더/admin/img/index.php

define("ROOT_HERO_AKLOVER",                                         HERO_END."aklover",TRUE);                                                       //http://a.com/기본폴더/hero/img
define("ROOT_HERO_AKLOVER_END",                                     HERO_END."aklover".SLASH,TRUE);                                                 //http://a.com/기본폴더/hero/img/
define("ROOT_HERO_AKLOVER_HOME",                                    ROOT_HERO_AKLOVER_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_AKLOVER",                                              HOME_END."aklover",TRUE);                                                       //http://a.com/기본폴더/img
define("HOME_AKLOVER_END",                                          HOME_END."aklover".SLASH,TRUE);                                                 //http://a.com/기본폴더/img/
define("HOME_AKLOVER_HOME",                                         HOME_AKLOVER_END.PAGE_DEFAULT,TRUE);                                            //http://a.com/기본폴더/img/index.php

define("HOME_ADMIN_AKLOVER",                                        ADMIN_END."aklover",TRUE);                                                      //http://a.com/기본폴더/admin/img
define("HOME_ADMIN_AKLOVER_END",                                    ADMIN_END."aklover".SLASH,TRUE);                                                //http://a.com/기본폴더/admin/img/
define("HOME_ADMIN_AKLOVER_HOME",                                   HOME_ADMIN_AKLOVER_END.PAGE_DEFAULT,TRUE);                                      //http://a.com/기본폴더/admin/img/index.php

define("HOME_HERO_AKLOVER",                                         HERO_END."aklover",TRUE);                                                       //http://a.com/기본폴더/hero/img
define("HOME_HERO_AKLOVER_END",                                     HERO_END."aklover".SLASH,TRUE);                                                 //http://a.com/기본폴더/hero/img/
define("HOME_HERO_AKLOVER_HOME",                                    HOME_HERO_AKLOVER_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_END)
####################################################################################################################################################
define("PATH_AKLOVER",                                              PATH_END."aklover",TRUE);                                                       //http://a.com/현재폴더/img
define("PATH_AKLOVER_END",                                          PATH_END."aklover".SLASH,TRUE);                                                 //http://a.com/현재폴더/img/
define("PATH_AKLOVER_HOME",                                         PATH_AKLOVER_END.PAGE_DEFAULT,TRUE);                                            //http://a.com/현재폴더/img/index.php

define("PATH_ADMIN_AKLOVER",                                        PATH_ADMIN_END."aklover",TRUE);                                                 //http://a.com/현재폴더/admin/img
define("PATH_ADMIN_AKLOVER_END",                                    PATH_ADMIN_END."aklover".SLASH,TRUE);                                           //http://a.com/현재폴더/admin/img/
define("PATH_ADMIN_AKLOVER_HOME",                                   PATH_ADMIN_AKLOVER_END.PAGE_DEFAULT,TRUE);                                      //http://a.com/현재폴더/admin/img/index.php

define("PATH_HERO_AKLOVER",                                         PATH_HERO_END."aklover",TRUE);                                                  //http://a.com/현재폴더/hero/img
define("PATH_HERO_AKLOVER_END",                                     PATH_HERO_END."aklover".SLASH,TRUE);                                            //http://a.com/현재폴더/hero/img/
define("PATH_HERO_AKLOVER_HOME",                                    PATH_HERO_AKLOVER_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/현재폴더/hero/img/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define("DOMAIN_AKLOVER_INC",                                        DOMAIN_INC_END."aklover",TRUE);                                                 //C:/APM_Setup/htdocs/img
define("DOMAIN_AKLOVER_INC_END",                                    DOMAIN_INC_END."aklover".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/img/
define("DOMAIN_AKLOVER_INC_HOME",                                   DOMAIN_AKLOVER_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/img/index.php

define("DOMAIN_ADMIN_AKLOVER_INC",                                  DOMAIN_ADMIN_INC_END."aklover",TRUE);                                           //C:/APM_Setup/htdocs/admin/img
define("DOMAIN_ADMIN_AKLOVER_INC_END",                              DOMAIN_ADMIN_INC_END."aklover".SLASH,TRUE);                                     //C:/APM_Setup/htdocs/admin/img/
define("DOMAIN_ADMIN_AKLOVER_INC_HOME",                             DOMAIN_ADMIN_AKLOVER_INC_END.PAGE_DEFAULT,TRUE);                                //C:/APM_Setup/htdocs/admin/img/index.php

define("DOMAIN_HERO_AKLOVER_INC",                                   DOMAIN_HERO_INC_END."aklover",TRUE);                                            //C:/APM_Setup/htdocs/hero/img
define("DOMAIN_HERO_AKLOVER_INC_END",                               DOMAIN_HERO_INC_END."aklover".SLASH,TRUE);                                      //C:/APM_Setup/htdocs/hero/img/
define("DOMAIN_HERO_AKLOVER_INC_HOME",                              DOMAIN_HERO_AKLOVER_INC_END.PAGE_DEFAULT,TRUE);                                 //C:/APM_Setup/htdocs/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_INC_END)
####################################################################################################################################################
define("AKLOVER_INC",                                               HOME_INC_END."aklover",TRUE);                                                   //C:/APM_Setup/htdocs/기본폴더/img
define("AKLOVER_INC_END",                                           HOME_INC_END."aklover".SLASH,TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/img/
define("AKLOVER_INC_HOME",                                          AKLOVER_INC_END.PAGE_DEFAULT,TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ADMIN_AKLOVER_INC",                                         ADMIN_INC_END."aklover",TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ADMIN_AKLOVER_INC_END",                                     ADMIN_INC_END."aklover".SLASH,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ADMIN_AKLOVER_INC_HOME",                                    ADMIN_AKLOVER_INC_END.PAGE_DEFAULT,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HERO_AKLOVER_INC",                                          HERO_INC_END."aklover",TRUE);                                                   //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HERO_AKLOVER_INC_END",                                      HERO_INC_END."aklover".SLASH,TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HERO_AKLOVER_INC_HOME",                                     HERO_AKLOVER_INC_END.PAGE_DEFAULT,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_AKLOVER_INC",                                          ROOT_INC_END."aklover",TRUE);                                                   //C:/APM_Setup/htdocs/기본폴더/img
define("ROOT_AKLOVER_INC_END",                                      ROOT_INC_END."aklover".SLASH,TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/img/
define("ROOT_AKLOVER_INC_HOME",                                     ROOT_AKLOVER_INC_END.PAGE_DEFAULT,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ROOT_ADMIN_AKLOVER_INC",                                    ADMIN_INC_END."aklover",TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ROOT_ADMIN_AKLOVER_INC_END",                                ADMIN_INC_END."aklover".SLASH,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ROOT_ADMIN_AKLOVER_INC_HOME",                               ROOT_ADMIN_AKLOVER_INC_END.PAGE_DEFAULT,TRUE);                                  //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("ROOT_HERO_AKLOVER_INC",                                     HERO_INC_END."aklover",TRUE);                                                   //C:/APM_Setup/htdocs/기본폴더/hero/img
define("ROOT_HERO_AKLOVER_INC_END",                                 HERO_INC_END."aklover".SLASH,TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("ROOT_HERO_AKLOVER_INC_HOME",                                ROOT_HERO_AKLOVER_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_AKLOVER_INC",                                          HOME_INC_END."aklover",TRUE);                                                   //C:/APM_Setup/htdocs/기본폴더/img
define("HOME_AKLOVER_INC_END",                                      HOME_INC_END."aklover".SLASH,TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/img/
define("HOME_AKLOVER_INC_HOME",                                     HOME_AKLOVER_INC_END.PAGE_DEFAULT,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("HOME_ADMIN_AKLOVER_INC",                                    ADMIN_INC_END."aklover",TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/admin/img
define("HOME_ADMIN_AKLOVER_INC_END",                                ADMIN_INC_END."aklover".SLASH,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("HOME_ADMIN_AKLOVER_INC_HOME",                               HOME_ADMIN_AKLOVER_INC_END.PAGE_DEFAULT,TRUE);                                  //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HOME_HERO_AKLOVER_INC",                                     HERO_INC_END."aklover",TRUE);                                                   //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HOME_HERO_AKLOVER_INC_END",                                 HERO_INC_END."aklover".SLASH,TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HOME_HERO_AKLOVER_INC_HOME",                                HOME_HERO_AKLOVER_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_INC_END)
####################################################################################################################################################
define("PATH_AKLOVER_INC",                                          PATH_INC_END."aklover",TRUE);                                                   //C:/APM_Setup/htdocs/현재폴더/img
define("PATH_AKLOVER_INC_END",                                      PATH_INC_END."aklover".SLASH,TRUE);                                             //C:/APM_Setup/htdocs/현재폴더/img/
define("PATH_AKLOVER_INC_HOME",                                     PATH_AKLOVER_INC_END.PAGE_DEFAULT,TRUE);                                        //C:/APM_Setup/htdocs/현재폴더/img/index.php

define("PATH_ADMIN_AKLOVER_INC",                                    PATH_ADMIN_INC_END."aklover",TRUE);                                             //C:/APM_Setup/htdocs/현재폴더/admin/img
define("PATH_ADMIN_AKLOVER_INC_END",                                PATH_ADMIN_INC_END."aklover".SLASH,TRUE);                                       //C:/APM_Setup/htdocs/현재폴더/admin/img/
define("PATH_ADMIN_AKLOVER_INC_HOME",                               PATH_ADMIN_AKLOVER_INC_END.PAGE_DEFAULT,TRUE);                                  //C:/APM_Setup/htdocs/현재폴더/admin/img/index.php

define("PATH_HERO_AKLOVER_INC",                                     PATH_HERO_INC_END."aklover",TRUE);                                              //C:/APM_Setup/htdocs/현재폴더/hero/img
define("PATH_HERO_AKLOVER_INC_END",                                 PATH_HERO_INC_END."aklover".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/현재폴더/hero/img/
define("PATH_HERO_AKLOVER_INC_HOME",                                PATH_HERO_AKLOVER_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/현재폴더/hero/img/index.php
####################################################################################################################################################
####################################################################################################################################################
define("DOMAIN_AKLOVER_UPLOAD",                                     DOMAIN_END."aklover/upload",TRUE);                                              //http://a.com/img
define("DOMAIN_AKLOVER_UPLOAD_END",                                 DOMAIN_END."aklover/upload".SLASH,TRUE);                                        //http://a.com/img/
define("DOMAIN_AKLOVER_UPLOAD_HOME",                                DOMAIN_AKLOVER_UPLOAD_END.PAGE_DEFAULT,TRUE);                                   //http://a.com/img/index.php

define("DOMAIN_ADMIN_AKLOVER_UPLOAD",                               DOMAIN_ADMIN_END."aklover/upload",TRUE);                                        //http://a.com/admin/img
define("DOMAIN_ADMIN_AKLOVER_UPLOAD_END",                           DOMAIN_ADMIN_END."aklover/upload".SLASH,TRUE);                                  //http://a.com/admin/img/
define("DOMAIN_ADMIN_AKLOVER_UPLOAD_HOME",                          DOMAIN_ADMIN_AKLOVER_UPLOAD_END.PAGE_DEFAULT,TRUE);                             //http://a.com/admin/img/index.php

define("DOMAIN_HERO_AKLOVER_UPLOAD",                                DOMAIN_HERO_END."aklover/upload",TRUE);                                         //http://a.com/hero/img
define("DOMAIN_HERO_AKLOVER_UPLOAD_END",                            DOMAIN_HERO_END."aklover/upload".SLASH,TRUE);                                   //http://a.com/hero/img/
define("DOMAIN_HERO_AKLOVER_UPLOAD_HOME",                           DOMAIN_HERO_AKLOVER_UPLOAD_END.PAGE_DEFAULT,TRUE);                              //http://a.com/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_END)
####################################################################################################################################################
define("AKLOVER_UPLOAD",                                            HOME_END."aklover/upload",TRUE);                                                //http://a.com/기본폴더/img
define("AKLOVER_UPLOAD_END",                                        HOME_END."aklover/upload".SLASH,TRUE);                                          //http://a.com/기본폴더/img/
define("AKLOVER_UPLOAD_HOME",                                       AKLOVER_UPLOAD_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/기본폴더/img/index.php

define("ADMIN_AKLOVER_UPLOAD",                                      ADMIN_END."aklover/upload",TRUE);                                               //http://a.com/기본폴더/admin/img
define("ADMIN_AKLOVER_UPLOAD_END",                                  ADMIN_END."aklover/upload".SLASH,TRUE);                                         //http://a.com/기본폴더/admin/img/
define("ADMIN_AKLOVER_UPLOAD_HOME",                                 ADMIN_AKLOVER_UPLOAD_END.PAGE_DEFAULT,TRUE);                                    //http://a.com/기본폴더/admin/img/index.php

define("HERO_AKLOVER_UPLOAD",                                       HERO_END."aklover/upload",TRUE);                                                //http://a.com/기본폴더/hero/img
define("HERO_AKLOVER_UPLOAD_END",                                   HERO_END."aklover/upload".SLASH,TRUE);                                          //http://a.com/기본폴더/hero/img/
define("HERO_AKLOVER_UPLOAD_HOME",                                  HERO_AKLOVER_UPLOAD_END.PAGE_DEFAULT,TRUE);                                     //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_AKLOVER_UPLOAD",                                       ROOT_END."aklover/upload",TRUE);                                                //http://a.com/기본폴더/img
define("ROOT_AKLOVER_UPLOAD_END",                                   ROOT_END."aklover/upload".SLASH,TRUE);                                          //http://a.com/기본폴더/img/
define("ROOT_AKLOVER_UPLOAD_HOME",                                  ROOT_AKLOVER_UPLOAD_END.PAGE_DEFAULT,TRUE);                                     //http://a.com/기본폴더/img/index.php

define("ROOT_ADMIN_AKLOVER_UPLOAD",                                 ADMIN_END."aklover/upload",TRUE);                                               //http://a.com/기본폴더/admin/img
define("ROOT_ADMIN_AKLOVER_UPLOAD_END",                             ADMIN_END."aklover/upload".SLASH,TRUE);                                         //http://a.com/기본폴더/admin/img/
define("ROOT_ADMIN_AKLOVER_UPLOAD_HOME",                            ROOT_ADMIN_AKLOVER_UPLOAD_END.PAGE_DEFAULT,TRUE);                               //http://a.com/기본폴더/admin/img/index.php

define("ROOT_HERO_AKLOVER_UPLOAD",                                  HERO_END."aklover/upload",TRUE);                                                //http://a.com/기본폴더/hero/img
define("ROOT_HERO_AKLOVER_UPLOAD_END",                              HERO_END."aklover/upload".SLASH,TRUE);                                          //http://a.com/기본폴더/hero/img/
define("ROOT_HERO_AKLOVER_UPLOAD_HOME",                             ROOT_HERO_AKLOVER_UPLOAD_END.PAGE_DEFAULT,TRUE);                                //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_AKLOVER_UPLOAD",                                       HOME_END."aklover/upload",TRUE);                                                //http://a.com/기본폴더/img
define("HOME_AKLOVER_UPLOAD_END",                                   HOME_END."aklover/upload".SLASH,TRUE);                                          //http://a.com/기본폴더/img/
define("HOME_AKLOVER_UPLOAD_HOME",                                  HOME_AKLOVER_UPLOAD_END.PAGE_DEFAULT,TRUE);                                     //http://a.com/기본폴더/img/index.php

define("HOME_ADMIN_AKLOVER_UPLOAD",                                 ADMIN_END."aklover/upload",TRUE);                                               //http://a.com/기본폴더/admin/img
define("HOME_ADMIN_AKLOVER_UPLOAD_END",                             ADMIN_END."aklover/upload".SLASH,TRUE);                                         //http://a.com/기본폴더/admin/img/
define("HOME_ADMIN_AKLOVER_UPLOAD_HOME",                            HOME_ADMIN_AKLOVER_UPLOAD_END.PAGE_DEFAULT,TRUE);                               //http://a.com/기본폴더/admin/img/index.php

define("HOME_HERO_AKLOVER_UPLOAD",                                  HERO_END."aklover/upload",TRUE);                                                //http://a.com/기본폴더/hero/img
define("HOME_HERO_AKLOVER_UPLOAD_END",                              HERO_END."aklover/upload".SLASH,TRUE);                                          //http://a.com/기본폴더/hero/img/
define("HOME_HERO_AKLOVER_UPLOAD_HOME",                             HOME_HERO_AKLOVER_UPLOAD_END.PAGE_DEFAULT,TRUE);                                //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_END)
####################################################################################################################################################
define("PATH_AKLOVER_UPLOAD",                                       PATH_END."aklover/upload",TRUE);                                                //http://a.com/현재폴더/img
define("PATH_AKLOVER_UPLOAD_END",                                   PATH_END."aklover/upload".SLASH,TRUE);                                          //http://a.com/현재폴더/img/
define("PATH_AKLOVER_UPLOAD_HOME",                                  PATH_AKLOVER_UPLOAD_END.PAGE_DEFAULT,TRUE);                                     //http://a.com/현재폴더/img/index.php

define("PATH_ADMIN_AKLOVER_UPLOAD",                                 PATH_ADMIN_END."aklover/upload",TRUE);                                          //http://a.com/현재폴더/admin/img
define("PATH_ADMIN_AKLOVER_UPLOAD_END",                             PATH_ADMIN_END."aklover/upload".SLASH,TRUE);                                    //http://a.com/현재폴더/admin/img/
define("PATH_ADMIN_AKLOVER_UPLOAD_HOME",                            PATH_ADMIN_AKLOVER_UPLOAD_END.PAGE_DEFAULT,TRUE);                               //http://a.com/현재폴더/admin/img/index.php

define("PATH_HERO_AKLOVER_UPLOAD",                                  PATH_HERO_END."aklover/upload",TRUE);                                           //http://a.com/현재폴더/hero/img
define("PATH_HERO_AKLOVER_UPLOAD_END",                              PATH_HERO_END."aklover/upload".SLASH,TRUE);                                     //http://a.com/현재폴더/hero/img/
define("PATH_HERO_AKLOVER_UPLOAD_HOME",                             PATH_HERO_AKLOVER_UPLOAD_END.PAGE_DEFAULT,TRUE);                                //http://a.com/현재폴더/hero/img/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define("DOMAIN_AKLOVER_UPLOAD_INC",                                 DOMAIN_INC_END."aklover/upload",TRUE);                                          //C:/APM_Setup/htdocs/img
define("DOMAIN_AKLOVER_UPLOAD_INC_END",                             DOMAIN_INC_END."aklover/upload".SLASH,TRUE);                                    //C:/APM_Setup/htdocs/img/
define("DOMAIN_AKLOVER_UPLOAD_INC_HOME",                            DOMAIN_AKLOVER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                               //C:/APM_Setup/htdocs/img/index.php

define("DOMAIN_ADMIN_AKLOVER_UPLOAD_INC",                           DOMAIN_ADMIN_INC_END."aklover/upload",TRUE);                                    //C:/APM_Setup/htdocs/admin/img
define("DOMAIN_ADMIN_AKLOVER_UPLOAD_INC_END",                       DOMAIN_ADMIN_INC_END."aklover/upload".SLASH,TRUE);                              //C:/APM_Setup/htdocs/admin/img/
define("DOMAIN_ADMIN_AKLOVER_UPLOAD_INC_HOME",                      DOMAIN_ADMIN_AKLOVER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                         //C:/APM_Setup/htdocs/admin/img/index.php

define("DOMAIN_HERO_AKLOVER_UPLOAD_INC",                            DOMAIN_HERO_INC_END."aklover/upload",TRUE);                                     //C:/APM_Setup/htdocs/hero/img
define("DOMAIN_HERO_AKLOVER_UPLOAD_INC_END",                        DOMAIN_HERO_INC_END."aklover/upload".SLASH,TRUE);                               //C:/APM_Setup/htdocs/hero/img/
define("DOMAIN_HERO_AKLOVER_UPLOAD_INC_HOME",                       DOMAIN_HERO_AKLOVER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                          //C:/APM_Setup/htdocs/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_INC_END)
####################################################################################################################################################
define("AKLOVER_UPLOAD_INC",                                        HOME_INC_END."aklover/upload",TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/img
define("AKLOVER_UPLOAD_INC_END",                                    HOME_INC_END."aklover/upload".SLASH,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/img/
define("AKLOVER_UPLOAD_INC_HOME",                                   AKLOVER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ADMIN_AKLOVER_UPLOAD_INC",                                  ADMIN_INC_END."aklover/upload",TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ADMIN_AKLOVER_UPLOAD_INC_END",                              ADMIN_INC_END."aklover/upload".SLASH,TRUE);                                     //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ADMIN_AKLOVER_UPLOAD_INC_HOME",                             ADMIN_AKLOVER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                                //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HERO_AKLOVER_UPLOAD_INC",                                   HERO_INC_END."aklover/upload",TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HERO_AKLOVER_UPLOAD_INC_END",                               HERO_INC_END."aklover/upload".SLASH,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HERO_AKLOVER_UPLOAD_INC_HOME",                              HERO_AKLOVER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                                 //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_AKLOVER_UPLOAD_INC",                                   ROOT_INC_END."aklover/upload",TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/img
define("ROOT_AKLOVER_UPLOAD_INC_END",                               ROOT_INC_END."aklover/upload".SLASH,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/img/
define("ROOT_AKLOVER_UPLOAD_INC_HOME",                              ROOT_AKLOVER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                                 //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ROOT_ADMIN_AKLOVER_UPLOAD_INC",                             ADMIN_INC_END."aklover/upload",TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ROOT_ADMIN_AKLOVER_UPLOAD_INC_END",                         ADMIN_INC_END."aklover/upload".SLASH,TRUE);                                     //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ROOT_ADMIN_AKLOVER_UPLOAD_INC_HOME",                        ROOT_ADMIN_AKLOVER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                           //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("ROOT_HERO_AKLOVER_UPLOAD_INC",                              HERO_INC_END."aklover/upload",TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/hero/img
define("ROOT_HERO_AKLOVER_UPLOAD_INC_END",                          HERO_INC_END."aklover/upload".SLASH,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("ROOT_HERO_AKLOVER_UPLOAD_INC_HOME",                         ROOT_HERO_AKLOVER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                            //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_AKLOVER_UPLOAD_INC",                                   HOME_INC_END."aklover/upload",TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/img
define("HOME_AKLOVER_UPLOAD_INC_END",                               HOME_INC_END."aklover/upload".SLASH,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/img/
define("HOME_AKLOVER_UPLOAD_INC_HOME",                              HOME_AKLOVER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                                 //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("HOME_ADMIN_AKLOVER_UPLOAD_INC",                             ADMIN_INC_END."aklover/upload",TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/admin/img
define("HOME_ADMIN_AKLOVER_UPLOAD_INC_END",                         ADMIN_INC_END."aklover/upload".SLASH,TRUE);                                     //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("HOME_ADMIN_AKLOVER_UPLOAD_INC_HOME",                        HOME_ADMIN_AKLOVER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                           //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HOME_HERO_AKLOVER_UPLOAD_INC",                              HERO_INC_END."aklover/upload",TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HOME_HERO_AKLOVER_UPLOAD_INC_END",                          HERO_INC_END."aklover/upload".SLASH,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HOME_HERO_AKLOVER_UPLOAD_INC_HOME",                         HOME_HERO_AKLOVER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                            //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_INC_END)
####################################################################################################################################################
define("PATH_AKLOVER_UPLOAD_INC",                                   PATH_INC_END."aklover/upload",TRUE);                                            //C:/APM_Setup/htdocs/현재폴더/img
define("PATH_AKLOVER_UPLOAD_INC_END",                               PATH_INC_END."aklover/upload".SLASH,TRUE);                                      //C:/APM_Setup/htdocs/현재폴더/img/
define("PATH_AKLOVER_UPLOAD_INC_HOME",                              PATH_AKLOVER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                                 //C:/APM_Setup/htdocs/현재폴더/img/index.php

define("PATH_ADMIN_AKLOVER_UPLOAD_INC",                             PATH_ADMIN_INC_END."aklover/upload",TRUE);                                      //C:/APM_Setup/htdocs/현재폴더/admin/img
define("PATH_ADMIN_AKLOVER_UPLOAD_INC_END",                         PATH_ADMIN_INC_END."aklover/upload".SLASH,TRUE);                                //C:/APM_Setup/htdocs/현재폴더/admin/img/
define("PATH_ADMIN_AKLOVER_UPLOAD_INC_HOME",                        PATH_ADMIN_AKLOVER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                           //C:/APM_Setup/htdocs/현재폴더/admin/img/index.php

define("PATH_HERO_AKLOVER_UPLOAD_INC",                              PATH_HERO_INC_END."aklover/upload",TRUE);                                       //C:/APM_Setup/htdocs/현재폴더/hero/img
define("PATH_HERO_AKLOVER_UPLOAD_INC_END",                          PATH_HERO_INC_END."aklover/upload".SLASH,TRUE);                                 //C:/APM_Setup/htdocs/현재폴더/hero/img/
define("PATH_HERO_AKLOVER_UPLOAD_INC_HOME",                         PATH_HERO_AKLOVER_UPLOAD_INC_END.PAGE_DEFAULT,TRUE);                            //C:/APM_Setup/htdocs/현재폴더/hero/img/index.php
####################################################################################################################################################
####################################################################################################################################################
define("DOMAIN_AKLOVER_FILE",                                       DOMAIN_END."aklover/file",TRUE);                                                //http://a.com/img
define("DOMAIN_AKLOVER_FILE_END",                                   DOMAIN_END."aklover/file".SLASH,TRUE);                                          //http://a.com/img/
define("DOMAIN_AKLOVER_FILE_HOME",                                  DOMAIN_AKLOVER_FILE_END.PAGE_DEFAULT,TRUE);                                     //http://a.com/img/index.php

define("DOMAIN_ADMIN_AKLOVER_FILE",                                 DOMAIN_ADMIN_END."aklover/file",TRUE);                                          //http://a.com/admin/img
define("DOMAIN_ADMIN_AKLOVER_FILE_END",                             DOMAIN_ADMIN_END."aklover/file".SLASH,TRUE);                                    //http://a.com/admin/img/
define("DOMAIN_ADMIN_AKLOVER_FILE_HOME",                            DOMAIN_ADMIN_AKLOVER_FILE_END.PAGE_DEFAULT,TRUE);                               //http://a.com/admin/img/index.php

define("DOMAIN_HERO_AKLOVER_FILE",                                  DOMAIN_HERO_END."aklover/file",TRUE);                                           //http://a.com/hero/img
define("DOMAIN_HERO_AKLOVER_FILE_END",                              DOMAIN_HERO_END."aklover/file".SLASH,TRUE);                                     //http://a.com/hero/img/
define("DOMAIN_HERO_AKLOVER_FILE_HOME",                             DOMAIN_HERO_AKLOVER_FILE_END.PAGE_DEFAULT,TRUE);                                //http://a.com/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_END)
####################################################################################################################################################
define("AKLOVER_FILE",                                              HOME_END."aklover/file",TRUE);                                                  //http://a.com/기본폴더/img
define("AKLOVER_FILE_END",                                          HOME_END."aklover/file".SLASH,TRUE);                                            //http://a.com/기본폴더/img/
define("AKLOVER_FILE_HOME",                                         AKLOVER_FILE_END.PAGE_DEFAULT,TRUE);                                            //http://a.com/기본폴더/img/index.php

define("ADMIN_AKLOVER_FILE",                                        ADMIN_END."aklover/file",TRUE);                                                 //http://a.com/기본폴더/admin/img
define("ADMIN_AKLOVER_FILE_END",                                    ADMIN_END."aklover/file".SLASH,TRUE);                                           //http://a.com/기본폴더/admin/img/
define("ADMIN_AKLOVER_FILE_HOME",                                   ADMIN_AKLOVER_FILE_END.PAGE_DEFAULT,TRUE);                                      //http://a.com/기본폴더/admin/img/index.php

define("HERO_AKLOVER_FILE",                                         HERO_END."aklover/file",TRUE);                                                  //http://a.com/기본폴더/hero/img
define("HERO_AKLOVER_FILE_END",                                     HERO_END."aklover/file".SLASH,TRUE);                                            //http://a.com/기본폴더/hero/img/
define("HERO_AKLOVER_FILE_HOME",                                    HERO_AKLOVER_FILE_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_AKLOVER_FILE",                                         ROOT_END."aklover/file",TRUE);                                                  //http://a.com/기본폴더/img
define("ROOT_AKLOVER_FILE_END",                                     ROOT_END."aklover/file".SLASH,TRUE);                                            //http://a.com/기본폴더/img/
define("ROOT_AKLOVER_FILE_HOME",                                    ROOT_AKLOVER_FILE_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/기본폴더/img/index.php

define("ROOT_ADMIN_AKLOVER_FILE",                                   ADMIN_END."aklover/file",TRUE);                                                 //http://a.com/기본폴더/admin/img
define("ROOT_ADMIN_AKLOVER_FILE_END",                               ADMIN_END."aklover/file".SLASH,TRUE);                                           //http://a.com/기본폴더/admin/img/
define("ROOT_ADMIN_AKLOVER_FILE_HOME",                              ROOT_ADMIN_AKLOVER_FILE_END.PAGE_DEFAULT,TRUE);                                 //http://a.com/기본폴더/admin/img/index.php

define("ROOT_HERO_AKLOVER_FILE",                                    HERO_END."aklover/file",TRUE);                                                  //http://a.com/기본폴더/hero/img
define("ROOT_HERO_AKLOVER_FILE_END",                                HERO_END."aklover/file".SLASH,TRUE);                                            //http://a.com/기본폴더/hero/img/
define("ROOT_HERO_AKLOVER_FILE_HOME",                               ROOT_HERO_AKLOVER_FILE_END.PAGE_DEFAULT,TRUE);                                  //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_AKLOVER_FILE",                                         HOME_END."aklover/file",TRUE);                                                  //http://a.com/기본폴더/img
define("HOME_AKLOVER_FILE_END",                                     HOME_END."aklover/file".SLASH,TRUE);                                            //http://a.com/기본폴더/img/
define("HOME_AKLOVER_FILE_HOME",                                    HOME_AKLOVER_FILE_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/기본폴더/img/index.php

define("HOME_ADMIN_AKLOVER_FILE",                                   ADMIN_END."aklover/file",TRUE);                                                 //http://a.com/기본폴더/admin/img
define("HOME_ADMIN_AKLOVER_FILE_END",                               ADMIN_END."aklover/file".SLASH,TRUE);                                           //http://a.com/기본폴더/admin/img/
define("HOME_ADMIN_AKLOVER_FILE_HOME",                              HOME_ADMIN_AKLOVER_FILE_END.PAGE_DEFAULT,TRUE);                                 //http://a.com/기본폴더/admin/img/index.php

define("HOME_HERO_AKLOVER_FILE",                                    HERO_END."aklover/file",TRUE);                                                  //http://a.com/기본폴더/hero/img
define("HOME_HERO_AKLOVER_FILE_END",                                HERO_END."aklover/file".SLASH,TRUE);                                            //http://a.com/기본폴더/hero/img/
define("HOME_HERO_AKLOVER_FILE_HOME",                               HOME_HERO_AKLOVER_FILE_END.PAGE_DEFAULT,TRUE);                                  //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_END)
####################################################################################################################################################
define("PATH_AKLOVER_FILE",                                         PATH_END."aklover/file",TRUE);                                                  //http://a.com/현재폴더/img
define("PATH_AKLOVER_FILE_END",                                     PATH_END."aklover/file".SLASH,TRUE);                                            //http://a.com/현재폴더/img/
define("PATH_AKLOVER_FILE_HOME",                                    PATH_AKLOVER_FILE_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/현재폴더/img/index.php

define("PATH_ADMIN_AKLOVER_FILE",                                   PATH_ADMIN_END."aklover/file",TRUE);                                            //http://a.com/현재폴더/admin/img
define("PATH_ADMIN_AKLOVER_FILE_END",                               PATH_ADMIN_END."aklover/file".SLASH,TRUE);                                      //http://a.com/현재폴더/admin/img/
define("PATH_ADMIN_AKLOVER_FILE_HOME",                              PATH_ADMIN_AKLOVER_FILE_END.PAGE_DEFAULT,TRUE);                                 //http://a.com/현재폴더/admin/img/index.php

define("PATH_HERO_AKLOVER_FILE",                                    PATH_HERO_END."aklover/file",TRUE);                                             //http://a.com/현재폴더/hero/img
define("PATH_HERO_AKLOVER_FILE_END",                                PATH_HERO_END."aklover/file".SLASH,TRUE);                                       //http://a.com/현재폴더/hero/img/
define("PATH_HERO_AKLOVER_FILE_HOME",                               PATH_HERO_AKLOVER_FILE_END.PAGE_DEFAULT,TRUE);                                  //http://a.com/현재폴더/hero/img/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define("DOMAIN_AKLOVER_FILE_INC",                                   DOMAIN_INC_END."aklover/file",TRUE);                                            //C:/APM_Setup/htdocs/img
define("DOMAIN_AKLOVER_FILE_INC_END",                               DOMAIN_INC_END."aklover/file".SLASH,TRUE);                                      //C:/APM_Setup/htdocs/img/
define("DOMAIN_AKLOVER_FILE_INC_HOME",                              DOMAIN_AKLOVER_FILE_INC_END.PAGE_DEFAULT,TRUE);                                 //C:/APM_Setup/htdocs/img/index.php

define("DOMAIN_ADMIN_AKLOVER_FILE_INC",                             DOMAIN_ADMIN_INC_END."aklover/file",TRUE);                                      //C:/APM_Setup/htdocs/admin/img
define("DOMAIN_ADMIN_AKLOVER_FILE_INC_END",                         DOMAIN_ADMIN_INC_END."aklover/file".SLASH,TRUE);                                //C:/APM_Setup/htdocs/admin/img/
define("DOMAIN_ADMIN_AKLOVER_FILE_INC_HOME",                        DOMAIN_ADMIN_AKLOVER_FILE_INC_END.PAGE_DEFAULT,TRUE);                           //C:/APM_Setup/htdocs/admin/img/index.php

define("DOMAIN_HERO_AKLOVER_FILE_INC",                              DOMAIN_HERO_INC_END."aklover/file",TRUE);                                       //C:/APM_Setup/htdocs/hero/img
define("DOMAIN_HERO_AKLOVER_FILE_INC_END",                          DOMAIN_HERO_INC_END."aklover/file".SLASH,TRUE);                                 //C:/APM_Setup/htdocs/hero/img/
define("DOMAIN_HERO_AKLOVER_FILE_INC_HOME",                         DOMAIN_HERO_AKLOVER_FILE_INC_END.PAGE_DEFAULT,TRUE);                            //C:/APM_Setup/htdocs/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_INC_END)
####################################################################################################################################################
define("AKLOVER_FILE_INC",                                          HOME_INC_END."aklover/file",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/img
define("AKLOVER_FILE_INC_END",                                      HOME_INC_END."aklover/file".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/img/
define("AKLOVER_FILE_INC_HOME",                                     AKLOVER_FILE_INC_END.PAGE_DEFAULT,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ADMIN_AKLOVER_FILE_INC",                                    ADMIN_INC_END."aklover/file",TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ADMIN_AKLOVER_FILE_INC_END",                                ADMIN_INC_END."aklover/file".SLASH,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ADMIN_AKLOVER_FILE_INC_HOME",                               ADMIN_AKLOVER_FILE_INC_END.PAGE_DEFAULT,TRUE);                                  //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HERO_AKLOVER_FILE_INC",                                     HERO_INC_END."aklover/file",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HERO_AKLOVER_FILE_INC_END",                                 HERO_INC_END."aklover/file".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HERO_AKLOVER_FILE_INC_HOME",                                HERO_AKLOVER_FILE_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_AKLOVER_FILE_INC",                                     ROOT_INC_END."aklover/file",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/img
define("ROOT_AKLOVER_FILE_INC_END",                                 ROOT_INC_END."aklover/file".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/img/
define("ROOT_AKLOVER_FILE_INC_HOME",                                ROOT_AKLOVER_FILE_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ROOT_ADMIN_AKLOVER_FILE_INC",                               ADMIN_INC_END."aklover/file",TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ROOT_ADMIN_AKLOVER_FILE_INC_END",                           ADMIN_INC_END."aklover/file".SLASH,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ROOT_ADMIN_AKLOVER_FILE_INC_HOME",                          ROOT_ADMIN_AKLOVER_FILE_INC_END.PAGE_DEFAULT,TRUE);                             //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("ROOT_HERO_AKLOVER_FILE_INC",                                HERO_INC_END."aklover/file",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/hero/img
define("ROOT_HERO_AKLOVER_FILE_INC_END",                            HERO_INC_END."aklover/file".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("ROOT_HERO_AKLOVER_FILE_INC_HOME",                           ROOT_HERO_AKLOVER_FILE_INC_END.PAGE_DEFAULT,TRUE);                              //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_AKLOVER_FILE_INC",                                     HOME_INC_END."aklover/file",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/img
define("HOME_AKLOVER_FILE_INC_END",                                 HOME_INC_END."aklover/file".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/img/
define("HOME_AKLOVER_FILE_INC_HOME",                                HOME_AKLOVER_FILE_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("HOME_ADMIN_AKLOVER_FILE_INC",                               ADMIN_INC_END."aklover/file",TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/admin/img
define("HOME_ADMIN_AKLOVER_FILE_INC_END",                           ADMIN_INC_END."aklover/file".SLASH,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("HOME_ADMIN_AKLOVER_FILE_INC_HOME",                          HOME_ADMIN_AKLOVER_FILE_INC_END.PAGE_DEFAULT,TRUE);                             //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HOME_HERO_AKLOVER_FILE_INC",                                HERO_INC_END."aklover/file",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HOME_HERO_AKLOVER_FILE_INC_END",                            HERO_INC_END."aklover/file".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HOME_HERO_AKLOVER_FILE_INC_HOME",                           HOME_HERO_AKLOVER_FILE_INC_END.PAGE_DEFAULT,TRUE);                              //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_INC_END)
####################################################################################################################################################
define("PATH_AKLOVER_FILE_INC",                                     PATH_INC_END."aklover/file",TRUE);                                              //C:/APM_Setup/htdocs/현재폴더/img
define("PATH_AKLOVER_FILE_INC_END",                                 PATH_INC_END."aklover/file".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/현재폴더/img/
define("PATH_AKLOVER_FILE_INC_HOME",                                PATH_AKLOVER_FILE_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/현재폴더/img/index.php

define("PATH_ADMIN_AKLOVER_FILE_INC",                               PATH_ADMIN_INC_END."aklover/file",TRUE);                                        //C:/APM_Setup/htdocs/현재폴더/admin/img
define("PATH_ADMIN_AKLOVER_FILE_INC_END",                           PATH_ADMIN_INC_END."aklover/file".SLASH,TRUE);                                  //C:/APM_Setup/htdocs/현재폴더/admin/img/
define("PATH_ADMIN_AKLOVER_FILE_INC_HOME",                          PATH_ADMIN_AKLOVER_FILE_INC_END.PAGE_DEFAULT,TRUE);                             //C:/APM_Setup/htdocs/현재폴더/admin/img/index.php

define("PATH_HERO_AKLOVER_FILE_INC",                                PATH_HERO_INC_END."aklover/file",TRUE);                                         //C:/APM_Setup/htdocs/현재폴더/hero/img
define("PATH_HERO_AKLOVER_FILE_INC_END",                            PATH_HERO_INC_END."aklover/file".SLASH,TRUE);                                   //C:/APM_Setup/htdocs/현재폴더/hero/img/
define("PATH_HERO_AKLOVER_FILE_INC_HOME",                           PATH_HERO_AKLOVER_FILE_INC_END.PAGE_DEFAULT,TRUE);                              //C:/APM_Setup/htdocs/현재폴더/hero/img/index.php
####################################################################################################################################################
####################################################################################################################################################
define("DOMAIN_AKLOVER_PHOTO",                                      DOMAIN_END."aklover/photo",TRUE);                                               //http://a.com/img
define("DOMAIN_AKLOVER_PHOTO_END",                                  DOMAIN_END."aklover/photo".SLASH,TRUE);                                         //http://a.com/img/
define("DOMAIN_AKLOVER_PHOTO_HOME",                                 DOMAIN_AKLOVER_PHOTO_END.PAGE_DEFAULT,TRUE);                                    //http://a.com/img/index.php

define("DOMAIN_ADMIN_AKLOVER_PHOTO",                                DOMAIN_ADMIN_END."aklover/photo",TRUE);                                         //http://a.com/admin/img
define("DOMAIN_ADMIN_AKLOVER_PHOTO_END",                            DOMAIN_ADMIN_END."aklover/photo".SLASH,TRUE);                                   //http://a.com/admin/img/
define("DOMAIN_ADMIN_AKLOVER_PHOTO_HOME",                           DOMAIN_ADMIN_AKLOVER_PHOTO_END.PAGE_DEFAULT,TRUE);                              //http://a.com/admin/img/index.php

define("DOMAIN_HERO_AKLOVER_PHOTO",                                 DOMAIN_HERO_END."aklover/photo",TRUE);                                          //http://a.com/hero/img
define("DOMAIN_HERO_AKLOVER_PHOTO_END",                             DOMAIN_HERO_END."aklover/photo".SLASH,TRUE);                                    //http://a.com/hero/img/
define("DOMAIN_HERO_AKLOVER_PHOTO_HOME",                            DOMAIN_HERO_AKLOVER_PHOTO_END.PAGE_DEFAULT,TRUE);                               //http://a.com/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_END)
####################################################################################################################################################
define("AKLOVER_PHOTO",                                             HOME_END."aklover/photo",TRUE);                                                 //http://a.com/기본폴더/img
define("AKLOVER_PHOTO_END",                                         HOME_END."aklover/photo".SLASH,TRUE);                                           //http://a.com/기본폴더/img/
define("AKLOVER_PHOTO_HOME",                                        AKLOVER_PHOTO_END.PAGE_DEFAULT,TRUE);                                           //http://a.com/기본폴더/img/index.php

define("ADMIN_AKLOVER_PHOTO",                                       ADMIN_END."aklover/photo",TRUE);                                                //http://a.com/기본폴더/admin/img
define("ADMIN_AKLOVER_PHOTO_END",                                   ADMIN_END."aklover/photo".SLASH,TRUE);                                          //http://a.com/기본폴더/admin/img/
define("ADMIN_AKLOVER_PHOTO_HOME",                                  ADMIN_AKLOVER_PHOTO_END.PAGE_DEFAULT,TRUE);                                     //http://a.com/기본폴더/admin/img/index.php

define("HERO_AKLOVER_PHOTO",                                        HERO_END."aklover/photo",TRUE);                                                 //http://a.com/기본폴더/hero/img
define("HERO_AKLOVER_PHOTO_END",                                    HERO_END."aklover/photo".SLASH,TRUE);                                           //http://a.com/기본폴더/hero/img/
define("HERO_AKLOVER_PHOTO_HOME",                                   HERO_AKLOVER_PHOTO_END.PAGE_DEFAULT,TRUE);                                      //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_AKLOVER_PHOTO",                                        ROOT_END."aklover/photo",TRUE);                                                 //http://a.com/기본폴더/img
define("ROOT_AKLOVER_PHOTO_END",                                    ROOT_END."aklover/photo".SLASH,TRUE);                                           //http://a.com/기본폴더/img/
define("ROOT_AKLOVER_PHOTO_HOME",                                   ROOT_AKLOVER_PHOTO_END.PAGE_DEFAULT,TRUE);                                      //http://a.com/기본폴더/img/index.php

define("ROOT_ADMIN_AKLOVER_PHOTO",                                  ADMIN_END."aklover/photo",TRUE);                                                //http://a.com/기본폴더/admin/img
define("ROOT_ADMIN_AKLOVER_PHOTO_END",                              ADMIN_END."aklover/photo".SLASH,TRUE);                                          //http://a.com/기본폴더/admin/img/
define("ROOT_ADMIN_AKLOVER_PHOTO_HOME",                             ROOT_ADMIN_AKLOVER_PHOTO_END.PAGE_DEFAULT,TRUE);                                //http://a.com/기본폴더/admin/img/index.php

define("ROOT_HERO_AKLOVER_PHOTO",                                   HERO_END."aklover/photo",TRUE);                                                 //http://a.com/기본폴더/hero/img
define("ROOT_HERO_AKLOVER_PHOTO_END",                               HERO_END."aklover/photo".SLASH,TRUE);                                           //http://a.com/기본폴더/hero/img/
define("ROOT_HERO_AKLOVER_PHOTO_HOME",                              ROOT_HERO_AKLOVER_PHOTO_END.PAGE_DEFAULT,TRUE);                                 //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_AKLOVER_PHOTO",                                        HOME_END."aklover/photo",TRUE);                                                 //http://a.com/기본폴더/img
define("HOME_AKLOVER_PHOTO_END",                                    HOME_END."aklover/photo".SLASH,TRUE);                                           //http://a.com/기본폴더/img/
define("HOME_AKLOVER_PHOTO_HOME",                                   HOME_AKLOVER_PHOTO_END.PAGE_DEFAULT,TRUE);                                      //http://a.com/기본폴더/img/index.php

define("HOME_ADMIN_AKLOVER_PHOTO",                                  ADMIN_END."aklover/photo",TRUE);                                                //http://a.com/기본폴더/admin/img
define("HOME_ADMIN_AKLOVER_PHOTO_END",                              ADMIN_END."aklover/photo".SLASH,TRUE);                                          //http://a.com/기본폴더/admin/img/
define("HOME_ADMIN_AKLOVER_PHOTO_HOME",                             HOME_ADMIN_AKLOVER_PHOTO_END.PAGE_DEFAULT,TRUE);                                //http://a.com/기본폴더/admin/img/index.php

define("HOME_HERO_AKLOVER_PHOTO",                                   HERO_END."aklover/photo",TRUE);                                                 //http://a.com/기본폴더/hero/img
define("HOME_HERO_AKLOVER_PHOTO_END",                               HERO_END."aklover/photo".SLASH,TRUE);                                           //http://a.com/기본폴더/hero/img/
define("HOME_HERO_AKLOVER_PHOTO_HOME",                              HOME_HERO_AKLOVER_PHOTO_END.PAGE_DEFAULT,TRUE);                                 //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_END)
####################################################################################################################################################
define("PATH_AKLOVER_PHOTO",                                        PATH_END."aklover/photo",TRUE);                                                 //http://a.com/현재폴더/img
define("PATH_AKLOVER_PHOTO_END",                                    PATH_END."aklover/photo".SLASH,TRUE);                                           //http://a.com/현재폴더/img/
define("PATH_AKLOVER_PHOTO_HOME",                                   PATH_AKLOVER_PHOTO_END.PAGE_DEFAULT,TRUE);                                      //http://a.com/현재폴더/img/index.php

define("PATH_ADMIN_AKLOVER_PHOTO",                                  PATH_ADMIN_END."aklover/photo",TRUE);                                           //http://a.com/현재폴더/admin/img
define("PATH_ADMIN_AKLOVER_PHOTO_END",                              PATH_ADMIN_END."aklover/photo".SLASH,TRUE);                                     //http://a.com/현재폴더/admin/img/
define("PATH_ADMIN_AKLOVER_PHOTO_HOME",                             PATH_ADMIN_AKLOVER_PHOTO_END.PAGE_DEFAULT,TRUE);                                //http://a.com/현재폴더/admin/img/index.php

define("PATH_HERO_AKLOVER_PHOTO",                                   PATH_HERO_END."aklover/photo",TRUE);                                            //http://a.com/현재폴더/hero/img
define("PATH_HERO_AKLOVER_PHOTO_END",                               PATH_HERO_END."aklover/photo".SLASH,TRUE);                                      //http://a.com/현재폴더/hero/img/
define("PATH_HERO_AKLOVER_PHOTO_HOME",                              PATH_HERO_AKLOVER_PHOTO_END.PAGE_DEFAULT,TRUE);                                 //http://a.com/현재폴더/hero/img/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define("DOMAIN_AKLOVER_PHOTO_INC",                                  DOMAIN_INC_END."aklover/photo",TRUE);                                           //C:/APM_Setup/htdocs/img
define("DOMAIN_AKLOVER_PHOTO_INC_END",                              DOMAIN_INC_END."aklover/photo".SLASH,TRUE);                                     //C:/APM_Setup/htdocs/img/
define("DOMAIN_AKLOVER_PHOTO_INC_HOME",                             DOMAIN_AKLOVER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                                //C:/APM_Setup/htdocs/img/index.php

define("DOMAIN_ADMIN_AKLOVER_PHOTO_INC",                            DOMAIN_ADMIN_INC_END."aklover/photo",TRUE);                                     //C:/APM_Setup/htdocs/admin/img
define("DOMAIN_ADMIN_AKLOVER_PHOTO_INC_END",                        DOMAIN_ADMIN_INC_END."aklover/photo".SLASH,TRUE);                               //C:/APM_Setup/htdocs/admin/img/
define("DOMAIN_ADMIN_AKLOVER_PHOTO_INC_HOME",                       DOMAIN_ADMIN_AKLOVER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                          //C:/APM_Setup/htdocs/admin/img/index.php

define("DOMAIN_HERO_AKLOVER_PHOTO_INC",                             DOMAIN_HERO_INC_END."aklover/photo",TRUE);                                      //C:/APM_Setup/htdocs/hero/img
define("DOMAIN_HERO_AKLOVER_PHOTO_INC_END",                         DOMAIN_HERO_INC_END."aklover/photo".SLASH,TRUE);                                //C:/APM_Setup/htdocs/hero/img/
define("DOMAIN_HERO_AKLOVER_PHOTO_INC_HOME",                        DOMAIN_HERO_AKLOVER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                           //C:/APM_Setup/htdocs/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_INC_END)
####################################################################################################################################################
define("AKLOVER_PHOTO_INC",                                         HOME_INC_END."aklover/photo",TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/img
define("AKLOVER_PHOTO_INC_END",                                     HOME_INC_END."aklover/photo".SLASH,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/img/
define("AKLOVER_PHOTO_INC_HOME",                                    AKLOVER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ADMIN_AKLOVER_PHOTO_INC",                                   ADMIN_INC_END."aklover/photo",TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ADMIN_AKLOVER_PHOTO_INC_END",                               ADMIN_INC_END."aklover/photo".SLASH,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ADMIN_AKLOVER_PHOTO_INC_HOME",                              ADMIN_AKLOVER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                                 //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HERO_AKLOVER_PHOTO_INC",                                    HERO_INC_END."aklover/photo",TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HERO_AKLOVER_PHOTO_INC_END",                                HERO_INC_END."aklover/photo".SLASH,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HERO_AKLOVER_PHOTO_INC_HOME",                               HERO_AKLOVER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                                  //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_AKLOVER_PHOTO_INC",                                    ROOT_INC_END."aklover/photo",TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/img
define("ROOT_AKLOVER_PHOTO_INC_END",                                ROOT_INC_END."aklover/photo".SLASH,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/img/
define("ROOT_AKLOVER_PHOTO_INC_HOME",                               ROOT_AKLOVER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                                  //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ROOT_ADMIN_AKLOVER_PHOTO_INC",                              ADMIN_INC_END."aklover/photo",TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ROOT_ADMIN_AKLOVER_PHOTO_INC_END",                          ADMIN_INC_END."aklover/photo".SLASH,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ROOT_ADMIN_AKLOVER_PHOTO_INC_HOME",                         ROOT_ADMIN_AKLOVER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                            //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("ROOT_HERO_AKLOVER_PHOTO_INC",                               HERO_INC_END."aklover/photo",TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/hero/img
define("ROOT_HERO_AKLOVER_PHOTO_INC_END",                           HERO_INC_END."aklover/photo".SLASH,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("ROOT_HERO_AKLOVER_PHOTO_INC_HOME",                          ROOT_HERO_AKLOVER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                             //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_AKLOVER_PHOTO_INC",                                    HOME_INC_END."aklover/photo",TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/img
define("HOME_AKLOVER_PHOTO_INC_END",                                HOME_INC_END."aklover/photo".SLASH,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/img/
define("HOME_AKLOVER_PHOTO_INC_HOME",                               HOME_AKLOVER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                                  //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("HOME_ADMIN_AKLOVER_PHOTO_INC",                              ADMIN_INC_END."aklover/photo",TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/admin/img
define("HOME_ADMIN_AKLOVER_PHOTO_INC_END",                          ADMIN_INC_END."aklover/photo".SLASH,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("HOME_ADMIN_AKLOVER_PHOTO_INC_HOME",                         HOME_ADMIN_AKLOVER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                            //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HOME_HERO_AKLOVER_PHOTO_INC",                               HERO_INC_END."aklover/photo",TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HOME_HERO_AKLOVER_PHOTO_INC_END",                           HERO_INC_END."aklover/photo".SLASH,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HOME_HERO_AKLOVER_PHOTO_INC_HOME",                          HOME_HERO_AKLOVER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                             //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_INC_END)
####################################################################################################################################################
define("PATH_AKLOVER_PHOTO_INC",                                    PATH_INC_END."aklover/photo",TRUE);                                             //C:/APM_Setup/htdocs/현재폴더/img
define("PATH_AKLOVER_PHOTO_INC_END",                                PATH_INC_END."aklover/photo".SLASH,TRUE);                                       //C:/APM_Setup/htdocs/현재폴더/img/
define("PATH_AKLOVER_PHOTO_INC_HOME",                               PATH_AKLOVER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                                  //C:/APM_Setup/htdocs/현재폴더/img/index.php

define("PATH_ADMIN_AKLOVER_PHOTO_INC",                              PATH_ADMIN_INC_END."aklover/photo",TRUE);                                       //C:/APM_Setup/htdocs/현재폴더/admin/img
define("PATH_ADMIN_AKLOVER_PHOTO_INC_END",                          PATH_ADMIN_INC_END."aklover/photo".SLASH,TRUE);                                 //C:/APM_Setup/htdocs/현재폴더/admin/img/
define("PATH_ADMIN_AKLOVER_PHOTO_INC_HOME",                         PATH_ADMIN_AKLOVER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                            //C:/APM_Setup/htdocs/현재폴더/admin/img/index.php

define("PATH_HERO_AKLOVER_PHOTO_INC",                               PATH_HERO_INC_END."aklover/photo",TRUE);                                        //C:/APM_Setup/htdocs/현재폴더/hero/img
define("PATH_HERO_AKLOVER_PHOTO_INC_END",                           PATH_HERO_INC_END."aklover/photo".SLASH,TRUE);                                  //C:/APM_Setup/htdocs/현재폴더/hero/img/
define("PATH_HERO_AKLOVER_PHOTO_INC_HOME",                          PATH_HERO_AKLOVER_PHOTO_INC_END.PAGE_DEFAULT,TRUE);                             //C:/APM_Setup/htdocs/현재폴더/hero/img/index.php
####################################################################################################################################################
####################################################################################################################################################
define("DOMAIN_CSS",                                                DOMAIN_END."css",TRUE);                                                         //http://a.com/img
define("DOMAIN_CSS_END",                                            DOMAIN_END."css".SLASH,TRUE);                                                   //http://a.com/img/
define("DOMAIN_CSS_HOME",                                           DOMAIN_CSS_END.PAGE_DEFAULT,TRUE);                                              //http://a.com/img/index.php

define("DOMAIN_ADMIN_CSS",                                          DOMAIN_ADMIN_END."css",TRUE);                                                   //http://a.com/admin/img
define("DOMAIN_ADMIN_CSS_END",                                      DOMAIN_ADMIN_END."css".SLASH,TRUE);                                             //http://a.com/admin/img/
define("DOMAIN_ADMIN_CSS_HOME",                                     DOMAIN_ADMIN_CSS_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/admin/img/index.php

define("DOMAIN_HERO_CSS",                                           DOMAIN_HERO_END."css",TRUE);                                                    //http://a.com/hero/img
define("DOMAIN_HERO_CSS_END",                                       DOMAIN_HERO_END."css".SLASH,TRUE);                                              //http://a.com/hero/img/
define("DOMAIN_HERO_CSS_HOME",                                      DOMAIN_HERO_CSS_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_END)
####################################################################################################################################################
define("CSS",                                                       HOME_END."css",TRUE);                                                           //http://a.com/기본폴더/img
define("CSS_END",                                                   HOME_END."css".SLASH,TRUE);                                                     //http://a.com/기본폴더/img/
define("CSS_HOME",                                                  CSS_END.PAGE_DEFAULT,TRUE);                                                     //http://a.com/기본폴더/img/index.php

define("ADMIN_CSS",                                                 ADMIN_END."css",TRUE);                                                          //http://a.com/기본폴더/admin/img
define("ADMIN_CSS_END",                                             ADMIN_END."css".SLASH,TRUE);                                                    //http://a.com/기본폴더/admin/img/
define("ADMIN_CSS_HOME",                                            ADMIN_CSS_END.PAGE_DEFAULT,TRUE);                                               //http://a.com/기본폴더/admin/img/index.php

define("HERO_CSS",                                                  HERO_END."css",TRUE);                                                           //http://a.com/기본폴더/hero/img
define("HERO_CSS_END",                                              HERO_END."css".SLASH,TRUE);                                                     //http://a.com/기본폴더/hero/img/
define("HERO_CSS_HOME",                                             HERO_CSS_END.PAGE_DEFAULT,TRUE);                                                //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_CSS",                                                  ROOT_END."css",TRUE);                                                           //http://a.com/기본폴더/img
define("ROOT_CSS_END",                                              ROOT_END."css".SLASH,TRUE);                                                     //http://a.com/기본폴더/img/
define("ROOT_CSS_HOME",                                             ROOT_CSS_END.PAGE_DEFAULT,TRUE);                                                //http://a.com/기본폴더/img/index.php

define("ROOT_ADMIN_CSS",                                            ADMIN_END."css",TRUE);                                                          //http://a.com/기본폴더/admin/img
define("ROOT_ADMIN_CSS_END",                                        ADMIN_END."css".SLASH,TRUE);                                                    //http://a.com/기본폴더/admin/img/
define("ROOT_ADMIN_CSS_HOME",                                       ROOT_ADMIN_CSS_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/기본폴더/admin/img/index.php

define("ROOT_HERO_CSS",                                             HERO_END."css",TRUE);                                                           //http://a.com/기본폴더/hero/img
define("ROOT_HERO_CSS_END",                                         HERO_END."css".SLASH,TRUE);                                                     //http://a.com/기본폴더/hero/img/
define("ROOT_HERO_CSS_HOME",                                        ROOT_HERO_CSS_END.PAGE_DEFAULT,TRUE);                                           //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_CSS",                                                  HOME_END."css",TRUE);                                                           //http://a.com/기본폴더/img
define("HOME_CSS_END",                                              HOME_END."css".SLASH,TRUE);                                                     //http://a.com/기본폴더/img/
define("HOME_CSS_HOME",                                             HOME_CSS_END.PAGE_DEFAULT,TRUE);                                                //http://a.com/기본폴더/img/index.php

define("HOME_ADMIN_CSS",                                            ADMIN_END."css",TRUE);                                                          //http://a.com/기본폴더/admin/img
define("HOME_ADMIN_CSS_END",                                        ADMIN_END."css".SLASH,TRUE);                                                    //http://a.com/기본폴더/admin/img/
define("HOME_ADMIN_CSS_HOME",                                       HOME_ADMIN_CSS_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/기본폴더/admin/img/index.php

define("HOME_HERO_CSS",                                             HERO_END."css",TRUE);                                                           //http://a.com/기본폴더/hero/img
define("HOME_HERO_CSS_END",                                         HERO_END."css".SLASH,TRUE);                                                     //http://a.com/기본폴더/hero/img/
define("HOME_HERO_CSS_HOME",                                        HOME_HERO_CSS_END.PAGE_DEFAULT,TRUE);                                           //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_END)
####################################################################################################################################################
define("PATH_CSS",                                                  PATH_END."css",TRUE);                                                           //http://a.com/현재폴더/img
define("PATH_CSS_END",                                              PATH_END."css".SLASH,TRUE);                                                     //http://a.com/현재폴더/img/
define("PATH_CSS_HOME",                                             PATH_CSS_END.PAGE_DEFAULT,TRUE);                                                //http://a.com/현재폴더/img/index.php

define("PATH_ADMIN_CSS",                                            PATH_ADMIN_END."css",TRUE);                                                     //http://a.com/현재폴더/admin/img
define("PATH_ADMIN_CSS_END",                                        PATH_ADMIN_END."css".SLASH,TRUE);                                               //http://a.com/현재폴더/admin/img/
define("PATH_ADMIN_CSS_HOME",                                       PATH_ADMIN_CSS_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/현재폴더/admin/img/index.php

define("PATH_HERO_CSS",                                             PATH_HERO_END."css",TRUE);                                                      //http://a.com/현재폴더/hero/img
define("PATH_HERO_CSS_END",                                         PATH_HERO_END."css".SLASH,TRUE);                                                //http://a.com/현재폴더/hero/img/
define("PATH_HERO_CSS_HOME",                                        PATH_HERO_CSS_END.PAGE_DEFAULT,TRUE);                                           //http://a.com/현재폴더/hero/img/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define("DOMAIN_CSS_INC",                                            DOMAIN_INC_END."css",TRUE);                                                     //C:/APM_Setup/htdocs/img
define("DOMAIN_CSS_INC_END",                                        DOMAIN_INC_END."css".SLASH,TRUE);                                               //C:/APM_Setup/htdocs/img/
define("DOMAIN_CSS_INC_HOME",                                       DOMAIN_CSS_INC_END.PAGE_DEFAULT,TRUE);                                          //C:/APM_Setup/htdocs/img/index.php

define("DOMAIN_ADMIN_CSS_INC",                                      DOMAIN_ADMIN_INC_END."css",TRUE);                                               //C:/APM_Setup/htdocs/admin/img
define("DOMAIN_ADMIN_CSS_INC_END",                                  DOMAIN_ADMIN_INC_END."css".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/admin/img/
define("DOMAIN_ADMIN_CSS_INC_HOME",                                 DOMAIN_ADMIN_CSS_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/admin/img/index.php

define("DOMAIN_HERO_CSS_INC",                                       DOMAIN_HERO_INC_END."css",TRUE);                                                //C:/APM_Setup/htdocs/hero/img
define("DOMAIN_HERO_CSS_INC_END",                                   DOMAIN_HERO_INC_END."css".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/hero/img/
define("DOMAIN_HERO_CSS_INC_HOME",                                  DOMAIN_HERO_CSS_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_INC_END)
####################################################################################################################################################
define("CSS_INC",                                                   HOME_INC_END."css",TRUE);                                                       //C:/APM_Setup/htdocs/기본폴더/img
define("CSS_INC_END",                                               HOME_INC_END."css".SLASH,TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/img/
define("CSS_INC_HOME",                                              CSS_INC_END.PAGE_DEFAULT,TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ADMIN_CSS_INC",                                             ADMIN_INC_END."css",TRUE);                                                      //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ADMIN_CSS_INC_END",                                         ADMIN_INC_END."css".SLASH,TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ADMIN_CSS_INC_HOME",                                        ADMIN_CSS_INC_END.PAGE_DEFAULT,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HERO_CSS_INC",                                              HERO_INC_END."css",TRUE);                                                       //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HERO_CSS_INC_END",                                          HERO_INC_END."css".SLASH,TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HERO_CSS_INC_HOME",                                         HERO_CSS_INC_END.PAGE_DEFAULT,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_CSS_INC",                                              ROOT_INC_END."css",TRUE);                                                       //C:/APM_Setup/htdocs/기본폴더/img
define("ROOT_CSS_INC_END",                                          ROOT_INC_END."css".SLASH,TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/img/
define("ROOT_CSS_INC_HOME",                                         ROOT_CSS_INC_END.PAGE_DEFAULT,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ROOT_ADMIN_CSS_INC",                                        ADMIN_INC_END."css",TRUE);                                                      //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ROOT_ADMIN_CSS_INC_END",                                    ADMIN_INC_END."css".SLASH,TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ROOT_ADMIN_CSS_INC_HOME",                                   ROOT_ADMIN_CSS_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("ROOT_HERO_CSS_INC",                                         HERO_INC_END."css",TRUE);                                                       //C:/APM_Setup/htdocs/기본폴더/hero/img
define("ROOT_HERO_CSS_INC_END",                                     HERO_INC_END."css".SLASH,TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("ROOT_HERO_CSS_INC_HOME",                                    ROOT_HERO_CSS_INC_END.PAGE_DEFAULT,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_CSS_INC",                                              HOME_INC_END."css",TRUE);                                                       //C:/APM_Setup/htdocs/기본폴더/img
define("HOME_CSS_INC_END",                                          HOME_INC_END."css".SLASH,TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/img/
define("HOME_CSS_INC_HOME",                                         HOME_CSS_INC_END.PAGE_DEFAULT,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("HOME_ADMIN_CSS_INC",                                        ADMIN_INC_END."css",TRUE);                                                      //C:/APM_Setup/htdocs/기본폴더/admin/img
define("HOME_ADMIN_CSS_INC_END",                                    ADMIN_INC_END."css".SLASH,TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("HOME_ADMIN_CSS_INC_HOME",                                   HOME_ADMIN_CSS_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HOME_HERO_CSS_INC",                                         HERO_INC_END."css",TRUE);                                                       //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HOME_HERO_CSS_INC_END",                                     HERO_INC_END."css".SLASH,TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HOME_HERO_CSS_INC_HOME",                                    HOME_HERO_CSS_INC_END.PAGE_DEFAULT,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_INC_END)
####################################################################################################################################################
define("PATH_CSS_INC",                                              PATH_INC_END."css",TRUE);                                                       //C:/APM_Setup/htdocs/현재폴더/img
define("PATH_CSS_INC_END",                                          PATH_INC_END."css".SLASH,TRUE);                                                 //C:/APM_Setup/htdocs/현재폴더/img/
define("PATH_CSS_INC_HOME",                                         PATH_CSS_INC_END.PAGE_DEFAULT,TRUE);                                            //C:/APM_Setup/htdocs/현재폴더/img/index.php

define("PATH_ADMIN_CSS_INC",                                        PATH_ADMIN_INC_END."css",TRUE);                                                 //C:/APM_Setup/htdocs/현재폴더/admin/img
define("PATH_ADMIN_CSS_INC_END",                                    PATH_ADMIN_INC_END."css".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/현재폴더/admin/img/
define("PATH_ADMIN_CSS_INC_HOME",                                   PATH_ADMIN_CSS_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/현재폴더/admin/img/index.php

define("PATH_HERO_CSS_INC",                                         PATH_HERO_INC_END."css",TRUE);                                                  //C:/APM_Setup/htdocs/현재폴더/hero/img
define("PATH_HERO_CSS_INC_END",                                     PATH_HERO_INC_END."css".SLASH,TRUE);                                            //C:/APM_Setup/htdocs/현재폴더/hero/img/
define("PATH_HERO_CSS_INC_HOME",                                    PATH_HERO_CSS_INC_END.PAGE_DEFAULT,TRUE);                                       //C:/APM_Setup/htdocs/현재폴더/hero/img/index.php
####################################################################################################################################################
####################################################################################################################################################
define("DOMAIN_IMAGE",                                              DOMAIN_END."image",TRUE);                                                       //http://a.com/img
define("DOMAIN_IMAGE_END",                                          DOMAIN_END."image".SLASH,TRUE);                                                 //http://a.com/img/
define("DOMAIN_IMAGE_HOME",                                         DOMAIN_IMAGE_END.PAGE_DEFAULT,TRUE);                                            //http://a.com/img/index.php

define("DOMAIN_ADMIN_IMAGE",                                        DOMAIN_ADMIN_END."image",TRUE);                                                 //http://a.com/admin/img
define("DOMAIN_ADMIN_IMAGE_END",                                    DOMAIN_ADMIN_END."image".SLASH,TRUE);                                           //http://a.com/admin/img/
define("DOMAIN_ADMIN_IMAGE_HOME",                                   DOMAIN_ADMIN_IMAGE_END.PAGE_DEFAULT,TRUE);                                      //http://a.com/admin/img/index.php

define("DOMAIN_HERO_IMAGE",                                         DOMAIN_HERO_END."image",TRUE);                                                  //http://a.com/hero/img
define("DOMAIN_HERO_IMAGE_END",                                     DOMAIN_HERO_END."image".SLASH,TRUE);                                            //http://a.com/hero/img/
define("DOMAIN_HERO_IMAGE_HOME",                                    DOMAIN_HERO_IMAGE_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_END)
####################################################################################################################################################
define("IMAGE",                                                     HOME_END."image",TRUE);                                                         //http://a.com/기본폴더/img
define("IMAGE_END",                                                 HOME_END."image".SLASH,TRUE);                                                   //http://a.com/기본폴더/img/
define("IMAGE_HOME",                                                IMAGE_END.PAGE_DEFAULT,TRUE);                                                   //http://a.com/기본폴더/img/index.php

define("ADMIN_IMAGE",                                               ADMIN_END."image",TRUE);                                                        //http://a.com/기본폴더/admin/img
define("ADMIN_IMAGE_END",                                           ADMIN_END."image".SLASH,TRUE);                                                  //http://a.com/기본폴더/admin/img/
define("ADMIN_IMAGE_HOME",                                          ADMIN_IMAGE_END.PAGE_DEFAULT,TRUE);                                             //http://a.com/기본폴더/admin/img/index.php

define("HERO_IMAGE",                                                HERO_END."image",TRUE);                                                         //http://a.com/기본폴더/hero/img
define("HERO_IMAGE_END",                                            HERO_END."image".SLASH,TRUE);                                                   //http://a.com/기본폴더/hero/img/
define("HERO_IMAGE_HOME",                                           HERO_IMAGE_END.PAGE_DEFAULT,TRUE);                                              //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_IMAGE",                                                ROOT_END."image",TRUE);                                                         //http://a.com/기본폴더/img
define("ROOT_IMAGE_END",                                            ROOT_END."image".SLASH,TRUE);                                                   //http://a.com/기본폴더/img/
define("ROOT_IMAGE_HOME",                                           ROOT_IMAGE_END.PAGE_DEFAULT,TRUE);                                              //http://a.com/기본폴더/img/index.php

define("ROOT_ADMIN_IMAGE",                                          ADMIN_END."image",TRUE);                                                        //http://a.com/기본폴더/admin/img
define("ROOT_ADMIN_IMAGE_END",                                      ADMIN_END."image".SLASH,TRUE);                                                  //http://a.com/기본폴더/admin/img/
define("ROOT_ADMIN_IMAGE_HOME",                                     ROOT_ADMIN_IMAGE_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/기본폴더/admin/img/index.php

define("ROOT_HERO_IMAGE",                                           HERO_END."image",TRUE);                                                         //http://a.com/기본폴더/hero/img
define("ROOT_HERO_IMAGE_END",                                       HERO_END."image".SLASH,TRUE);                                                   //http://a.com/기본폴더/hero/img/
define("ROOT_HERO_IMAGE_HOME",                                      ROOT_HERO_IMAGE_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_IMAGE",                                                HOME_END."image",TRUE);                                                         //http://a.com/기본폴더/img
define("HOME_IMAGE_END",                                            HOME_END."image".SLASH,TRUE);                                                   //http://a.com/기본폴더/img/
define("HOME_IMAGE_HOME",                                           HOME_IMAGE_END.PAGE_DEFAULT,TRUE);                                              //http://a.com/기본폴더/img/index.php

define("HOME_ADMIN_IMAGE",                                          ADMIN_END."image",TRUE);                                                        //http://a.com/기본폴더/admin/img
define("HOME_ADMIN_IMAGE_END",                                      ADMIN_END."image".SLASH,TRUE);                                                  //http://a.com/기본폴더/admin/img/
define("HOME_ADMIN_IMAGE_HOME",                                     HOME_ADMIN_IMAGE_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/기본폴더/admin/img/index.php

define("HOME_HERO_IMAGE",                                           HERO_END."image",TRUE);                                                         //http://a.com/기본폴더/hero/img
define("HOME_HERO_IMAGE_END",                                       HERO_END."image".SLASH,TRUE);                                                   //http://a.com/기본폴더/hero/img/
define("HOME_HERO_IMAGE_HOME",                                      HOME_HERO_IMAGE_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_END)
####################################################################################################################################################
define("PATH_IMAGE",                                                PATH_END."image",TRUE);                                                         //http://a.com/현재폴더/img
define("PATH_IMAGE_END",                                            PATH_END."image".SLASH,TRUE);                                                   //http://a.com/현재폴더/img/
define("PATH_IMAGE_HOME",                                           PATH_IMAGE_END.PAGE_DEFAULT,TRUE);                                              //http://a.com/현재폴더/img/index.php

define("PATH_ADMIN_IMAGE",                                          PATH_ADMIN_END."image",TRUE);                                                   //http://a.com/현재폴더/admin/img
define("PATH_ADMIN_IMAGE_END",                                      PATH_ADMIN_END."image".SLASH,TRUE);                                             //http://a.com/현재폴더/admin/img/
define("PATH_ADMIN_IMAGE_HOME",                                     PATH_ADMIN_IMAGE_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/현재폴더/admin/img/index.php

define("PATH_HERO_IMAGE",                                           PATH_HERO_END."image",TRUE);                                                    //http://a.com/현재폴더/hero/img
define("PATH_HERO_IMAGE_END",                                       PATH_HERO_END."image".SLASH,TRUE);                                              //http://a.com/현재폴더/hero/img/
define("PATH_HERO_IMAGE_HOME",                                      PATH_HERO_IMAGE_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/현재폴더/hero/img/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define("DOMAIN_IMAGE_INC",                                          DOMAIN_INC_END."image",TRUE);                                                   //C:/APM_Setup/htdocs/img
define("DOMAIN_IMAGE_INC_END",                                      DOMAIN_INC_END."image".SLASH,TRUE);                                             //C:/APM_Setup/htdocs/img/
define("DOMAIN_IMAGE_INC_HOME",                                     DOMAIN_IMAGE_INC_END.PAGE_DEFAULT,TRUE);                                        //C:/APM_Setup/htdocs/img/index.php

define("DOMAIN_ADMIN_IMAGE_INC",                                    DOMAIN_ADMIN_INC_END."image",TRUE);                                             //C:/APM_Setup/htdocs/admin/img
define("DOMAIN_ADMIN_IMAGE_INC_END",                                DOMAIN_ADMIN_INC_END."image".SLASH,TRUE);                                       //C:/APM_Setup/htdocs/admin/img/
define("DOMAIN_ADMIN_IMAGE_INC_HOME",                               DOMAIN_ADMIN_IMAGE_INC_END.PAGE_DEFAULT,TRUE);                                  //C:/APM_Setup/htdocs/admin/img/index.php

define("DOMAIN_HERO_IMAGE_INC",                                     DOMAIN_HERO_INC_END."image",TRUE);                                              //C:/APM_Setup/htdocs/hero/img
define("DOMAIN_HERO_IMAGE_INC_END",                                 DOMAIN_HERO_INC_END."image".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/hero/img/
define("DOMAIN_HERO_IMAGE_INC_HOME",                                DOMAIN_HERO_IMAGE_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_INC_END)
####################################################################################################################################################
define("IMAGE_INC",                                                 HOME_INC_END."image",TRUE);                                                     //C:/APM_Setup/htdocs/기본폴더/img
define("IMAGE_INC_END",                                             HOME_INC_END."image".SLASH,TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/img/
define("IMAGE_INC_HOME",                                            IMAGE_INC_END.PAGE_DEFAULT,TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ADMIN_IMAGE_INC",                                           ADMIN_INC_END."image",TRUE);                                                    //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ADMIN_IMAGE_INC_END",                                       ADMIN_INC_END."image".SLASH,TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ADMIN_IMAGE_INC_HOME",                                      ADMIN_IMAGE_INC_END.PAGE_DEFAULT,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HERO_IMAGE_INC",                                            HERO_INC_END."image",TRUE);                                                     //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HERO_IMAGE_INC_END",                                        HERO_INC_END."image".SLASH,TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HERO_IMAGE_INC_HOME",                                       HERO_IMAGE_INC_END.PAGE_DEFAULT,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_IMAGE_INC",                                            ROOT_INC_END."image",TRUE);                                                     //C:/APM_Setup/htdocs/기본폴더/img
define("ROOT_IMAGE_INC_END",                                        ROOT_INC_END."image".SLASH,TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/img/
define("ROOT_IMAGE_INC_HOME",                                       ROOT_IMAGE_INC_END.PAGE_DEFAULT,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ROOT_ADMIN_IMAGE_INC",                                      ADMIN_INC_END."image",TRUE);                                                    //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ROOT_ADMIN_IMAGE_INC_END",                                  ADMIN_INC_END."image".SLASH,TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ROOT_ADMIN_IMAGE_INC_HOME",                                 ROOT_ADMIN_IMAGE_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("ROOT_HERO_IMAGE_INC",                                       HERO_INC_END."image",TRUE);                                                     //C:/APM_Setup/htdocs/기본폴더/hero/img
define("ROOT_HERO_IMAGE_INC_END",                                   HERO_INC_END."image".SLASH,TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("ROOT_HERO_IMAGE_INC_HOME",                                  ROOT_HERO_IMAGE_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_IMAGE_INC",                                            HOME_INC_END."image",TRUE);                                                     //C:/APM_Setup/htdocs/기본폴더/img
define("HOME_IMAGE_INC_END",                                        HOME_INC_END."image".SLASH,TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/img/
define("HOME_IMAGE_INC_HOME",                                       HOME_IMAGE_INC_END.PAGE_DEFAULT,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("HOME_ADMIN_IMAGE_INC",                                      ADMIN_INC_END."image",TRUE);                                                    //C:/APM_Setup/htdocs/기본폴더/admin/img
define("HOME_ADMIN_IMAGE_INC_END",                                  ADMIN_INC_END."image".SLASH,TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("HOME_ADMIN_IMAGE_INC_HOME",                                 HOME_ADMIN_IMAGE_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HOME_HERO_IMAGE_INC",                                       HERO_INC_END."image",TRUE);                                                     //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HOME_HERO_IMAGE_INC_END",                                   HERO_INC_END."image".SLASH,TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HOME_HERO_IMAGE_INC_HOME",                                  HOME_HERO_IMAGE_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_INC_END)
####################################################################################################################################################
define("PATH_IMAGE_INC",                                            PATH_INC_END."image",TRUE);                                                     //C:/APM_Setup/htdocs/현재폴더/img
define("PATH_IMAGE_INC_END",                                        PATH_INC_END."image".SLASH,TRUE);                                               //C:/APM_Setup/htdocs/현재폴더/img/
define("PATH_IMAGE_INC_HOME",                                       PATH_IMAGE_INC_END.PAGE_DEFAULT,TRUE);                                          //C:/APM_Setup/htdocs/현재폴더/img/index.php

define("PATH_ADMIN_IMAGE_INC",                                      PATH_ADMIN_INC_END."image",TRUE);                                               //C:/APM_Setup/htdocs/현재폴더/admin/img
define("PATH_ADMIN_IMAGE_INC_END",                                  PATH_ADMIN_INC_END."image".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/현재폴더/admin/img/
define("PATH_ADMIN_IMAGE_INC_HOME",                                 PATH_ADMIN_IMAGE_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/현재폴더/admin/img/index.php

define("PATH_HERO_IMAGE_INC",                                       PATH_HERO_INC_END."image",TRUE);                                                //C:/APM_Setup/htdocs/현재폴더/hero/img
define("PATH_HERO_IMAGE_INC_END",                                   PATH_HERO_INC_END."image".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/현재폴더/hero/img/
define("PATH_HERO_IMAGE_INC_HOME",                                  PATH_HERO_IMAGE_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/현재폴더/hero/img/index.php
####################################################################################################################################################
####################################################################################################################################################
define("DOMAIN_INCLUDE",                                            DOMAIN_END."include",TRUE);                                                     //http://a.com/img
define("DOMAIN_INCLUDE_END",                                        DOMAIN_END."include".SLASH,TRUE);                                               //http://a.com/img/
define("DOMAIN_INCLUDE_HOME",                                       DOMAIN_INCLUDE_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/img/index.php

define("DOMAIN_ADMIN_INCLUDE",                                      DOMAIN_ADMIN_END."include",TRUE);                                               //http://a.com/admin/img
define("DOMAIN_ADMIN_INCLUDE_END",                                  DOMAIN_ADMIN_END."include".SLASH,TRUE);                                         //http://a.com/admin/img/
define("DOMAIN_ADMIN_INCLUDE_HOME",                                 DOMAIN_ADMIN_INCLUDE_END.PAGE_DEFAULT,TRUE);                                    //http://a.com/admin/img/index.php

define("DOMAIN_HERO_INCLUDE",                                       DOMAIN_HERO_END."include",TRUE);                                                //http://a.com/hero/img
define("DOMAIN_HERO_INCLUDE_END",                                   DOMAIN_HERO_END."include".SLASH,TRUE);                                          //http://a.com/hero/img/
define("DOMAIN_HERO_INCLUDE_HOME",                                  DOMAIN_HERO_INCLUDE_END.PAGE_DEFAULT,TRUE);                                     //http://a.com/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_END)
####################################################################################################################################################
define("INCLUDE",                                                   HOME_END."include",TRUE);                                                       //http://a.com/기본폴더/img
define("INCLUDE_END",                                               HOME_END."include".SLASH,TRUE);                                                 //http://a.com/기본폴더/img/
define("INCLUDE_HOME",                                              INCLUDE_END.PAGE_DEFAULT,TRUE);                                                 //http://a.com/기본폴더/img/index.php

define("ADMIN_INCLUDE",                                             ADMIN_END."include",TRUE);                                                      //http://a.com/기본폴더/admin/img
define("ADMIN_INCLUDE_END",                                         ADMIN_END."include".SLASH,TRUE);                                                //http://a.com/기본폴더/admin/img/
define("ADMIN_INCLUDE_HOME",                                        ADMIN_INCLUDE_END.PAGE_DEFAULT,TRUE);                                           //http://a.com/기본폴더/admin/img/index.php

define("HERO_INCLUDE",                                              HERO_END."include",TRUE);                                                       //http://a.com/기본폴더/hero/img
define("HERO_INCLUDE_END",                                          HERO_END."include".SLASH,TRUE);                                                 //http://a.com/기본폴더/hero/img/
define("HERO_INCLUDE_HOME",                                         HERO_INCLUDE_END.PAGE_DEFAULT,TRUE);                                            //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_INCLUDE",                                              ROOT_END."include",TRUE);                                                       //http://a.com/기본폴더/img
define("ROOT_INCLUDE_END",                                          ROOT_END."include".SLASH,TRUE);                                                 //http://a.com/기본폴더/img/
define("ROOT_INCLUDE_HOME",                                         ROOT_INCLUDE_END.PAGE_DEFAULT,TRUE);                                            //http://a.com/기본폴더/img/index.php

define("ROOT_ADMIN_INCLUDE",                                        ADMIN_END."include",TRUE);                                                      //http://a.com/기본폴더/admin/img
define("ROOT_ADMIN_INCLUDE_END",                                    ADMIN_END."include".SLASH,TRUE);                                                //http://a.com/기본폴더/admin/img/
define("ROOT_ADMIN_INCLUDE_HOME",                                   ROOT_ADMIN_INCLUDE_END.PAGE_DEFAULT,TRUE);                                      //http://a.com/기본폴더/admin/img/index.php

define("ROOT_HERO_INCLUDE",                                         HERO_END."include",TRUE);                                                       //http://a.com/기본폴더/hero/img
define("ROOT_HERO_INCLUDE_END",                                     HERO_END."include".SLASH,TRUE);                                                 //http://a.com/기본폴더/hero/img/
define("ROOT_HERO_INCLUDE_HOME",                                    ROOT_HERO_INCLUDE_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_INCLUDE",                                              HOME_END."include",TRUE);                                                       //http://a.com/기본폴더/img
define("HOME_INCLUDE_END",                                          HOME_END."include".SLASH,TRUE);                                                 //http://a.com/기본폴더/img/
define("HOME_INCLUDE_HOME",                                         HOME_INCLUDE_END.PAGE_DEFAULT,TRUE);                                            //http://a.com/기본폴더/img/index.php

define("HOME_ADMIN_INCLUDE",                                        ADMIN_END."include",TRUE);                                                      //http://a.com/기본폴더/admin/img
define("HOME_ADMIN_INCLUDE_END",                                    ADMIN_END."include".SLASH,TRUE);                                                //http://a.com/기본폴더/admin/img/
define("HOME_ADMIN_INCLUDE_HOME",                                   HOME_ADMIN_INCLUDE_END.PAGE_DEFAULT,TRUE);                                      //http://a.com/기본폴더/admin/img/index.php

define("HOME_HERO_INCLUDE",                                         HERO_END."include",TRUE);                                                       //http://a.com/기본폴더/hero/img
define("HOME_HERO_INCLUDE_END",                                     HERO_END."include".SLASH,TRUE);                                                 //http://a.com/기본폴더/hero/img/
define("HOME_HERO_INCLUDE_HOME",                                    HOME_HERO_INCLUDE_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_END)
####################################################################################################################################################
define("PATH_INCLUDE",                                              PATH_END."include",TRUE);                                                       //http://a.com/현재폴더/img
define("PATH_INCLUDE_END",                                          PATH_END."include".SLASH,TRUE);                                                 //http://a.com/현재폴더/img/
define("PATH_INCLUDE_HOME",                                         PATH_INCLUDE_END.PAGE_DEFAULT,TRUE);                                            //http://a.com/현재폴더/img/index.php

define("PATH_ADMIN_INCLUDE",                                        PATH_ADMIN_END."include",TRUE);                                                 //http://a.com/현재폴더/admin/img
define("PATH_ADMIN_INCLUDE_END",                                    PATH_ADMIN_END."include".SLASH,TRUE);                                           //http://a.com/현재폴더/admin/img/
define("PATH_ADMIN_INCLUDE_HOME",                                   PATH_ADMIN_INCLUDE_END.PAGE_DEFAULT,TRUE);                                      //http://a.com/현재폴더/admin/img/index.php

define("PATH_HERO_INCLUDE",                                         PATH_HERO_END."include",TRUE);                                                  //http://a.com/현재폴더/hero/img
define("PATH_HERO_INCLUDE_END",                                     PATH_HERO_END."include".SLASH,TRUE);                                            //http://a.com/현재폴더/hero/img/
define("PATH_HERO_INCLUDE_HOME",                                    PATH_HERO_INCLUDE_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/현재폴더/hero/img/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define("DOMAIN_INCLUDE_INC",                                        DOMAIN_INC_END."include",TRUE);                                                 //C:/APM_Setup/htdocs/img
define("DOMAIN_INCLUDE_INC_END",                                    DOMAIN_INC_END."include".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/img/
define("DOMAIN_INCLUDE_INC_HOME",                                   DOMAIN_INCLUDE_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/img/index.php

define("DOMAIN_ADMIN_INCLUDE_INC",                                  DOMAIN_ADMIN_INC_END."include",TRUE);                                           //C:/APM_Setup/htdocs/admin/img
define("DOMAIN_ADMIN_INCLUDE_INC_END",                              DOMAIN_ADMIN_INC_END."include".SLASH,TRUE);                                     //C:/APM_Setup/htdocs/admin/img/
define("DOMAIN_ADMIN_INCLUDE_INC_HOME",                             DOMAIN_ADMIN_INCLUDE_INC_END.PAGE_DEFAULT,TRUE);                                //C:/APM_Setup/htdocs/admin/img/index.php

define("DOMAIN_HERO_INCLUDE_INC",                                   DOMAIN_HERO_INC_END."include",TRUE);                                            //C:/APM_Setup/htdocs/hero/img
define("DOMAIN_HERO_INCLUDE_INC_END",                               DOMAIN_HERO_INC_END."include".SLASH,TRUE);                                      //C:/APM_Setup/htdocs/hero/img/
define("DOMAIN_HERO_INCLUDE_INC_HOME",                              DOMAIN_HERO_INCLUDE_INC_END.PAGE_DEFAULT,TRUE);                                 //C:/APM_Setup/htdocs/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_INC_END)
####################################################################################################################################################
define("INCLUDE_INC",                                               HOME_INC_END."include",TRUE);                                                   //C:/APM_Setup/htdocs/기본폴더/img
define("INCLUDE_INC_END",                                           HOME_INC_END."include".SLASH,TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/img/
define("INCLUDE_INC_HOME",                                          INCLUDE_INC_END.PAGE_DEFAULT,TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ADMIN_INCLUDE_INC",                                         ADMIN_INC_END."include",TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ADMIN_INCLUDE_INC_END",                                     ADMIN_INC_END."include".SLASH,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ADMIN_INCLUDE_INC_HOME",                                    ADMIN_INCLUDE_INC_END.PAGE_DEFAULT,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HERO_INCLUDE_INC",                                          HERO_INC_END."include",TRUE);                                                   //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HERO_INCLUDE_INC_END",                                      HERO_INC_END."include".SLASH,TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HERO_INCLUDE_INC_HOME",                                     HERO_INCLUDE_INC_END.PAGE_DEFAULT,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_INCLUDE_INC",                                          ROOT_INC_END."include",TRUE);                                                   //C:/APM_Setup/htdocs/기본폴더/img
define("ROOT_INCLUDE_INC_END",                                      ROOT_INC_END."include".SLASH,TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/img/
define("ROOT_INCLUDE_INC_HOME",                                     ROOT_INCLUDE_INC_END.PAGE_DEFAULT,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ROOT_ADMIN_INCLUDE_INC",                                    ADMIN_INC_END."include",TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ROOT_ADMIN_INCLUDE_INC_END",                                ADMIN_INC_END."include".SLASH,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ROOT_ADMIN_INCLUDE_INC_HOME",                               ROOT_ADMIN_INCLUDE_INC_END.PAGE_DEFAULT,TRUE);                                  //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("ROOT_HERO_INCLUDE_INC",                                     HERO_INC_END."include",TRUE);                                                   //C:/APM_Setup/htdocs/기본폴더/hero/img
define("ROOT_HERO_INCLUDE_INC_END",                                 HERO_INC_END."include".SLASH,TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("ROOT_HERO_INCLUDE_INC_HOME",                                ROOT_HERO_INCLUDE_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_INCLUDE_INC",                                          HOME_INC_END."include",TRUE);                                                   //C:/APM_Setup/htdocs/기본폴더/img
define("HOME_INCLUDE_INC_END",                                      HOME_INC_END."include".SLASH,TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/img/
define("HOME_INCLUDE_INC_HOME",                                     HOME_INCLUDE_INC_END.PAGE_DEFAULT,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("HOME_ADMIN_INCLUDE_INC",                                    ADMIN_INC_END."include",TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/admin/img
define("HOME_ADMIN_INCLUDE_INC_END",                                ADMIN_INC_END."include".SLASH,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("HOME_ADMIN_INCLUDE_INC_HOME",                               HOME_ADMIN_INCLUDE_INC_END.PAGE_DEFAULT,TRUE);                                  //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HOME_HERO_INCLUDE_INC",                                     HERO_INC_END."include",TRUE);                                                   //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HOME_HERO_INCLUDE_INC_END",                                 HERO_INC_END."include".SLASH,TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HOME_HERO_INCLUDE_INC_HOME",                                HOME_HERO_INCLUDE_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_INC_END)
####################################################################################################################################################
define("PATH_INCLUDE_INC",                                          PATH_INC_END."include",TRUE);                                                   //C:/APM_Setup/htdocs/현재폴더/img
define("PATH_INCLUDE_INC_END",                                      PATH_INC_END."include".SLASH,TRUE);                                             //C:/APM_Setup/htdocs/현재폴더/img/
define("PATH_INCLUDE_INC_HOME",                                     PATH_INCLUDE_INC_END.PAGE_DEFAULT,TRUE);                                        //C:/APM_Setup/htdocs/현재폴더/img/index.php

define("PATH_ADMIN_INCLUDE_INC",                                    PATH_ADMIN_INC_END."include",TRUE);                                             //C:/APM_Setup/htdocs/현재폴더/admin/img
define("PATH_ADMIN_INCLUDE_INC_END",                                PATH_ADMIN_INC_END."include".SLASH,TRUE);                                       //C:/APM_Setup/htdocs/현재폴더/admin/img/
define("PATH_ADMIN_INCLUDE_INC_HOME",                               PATH_ADMIN_INCLUDE_INC_END.PAGE_DEFAULT,TRUE);                                  //C:/APM_Setup/htdocs/현재폴더/admin/img/index.php

define("PATH_HERO_INCLUDE_INC",                                     PATH_HERO_INC_END."include",TRUE);                                              //C:/APM_Setup/htdocs/현재폴더/hero/img
define("PATH_HERO_INCLUDE_INC_END",                                 PATH_HERO_INC_END."include".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/현재폴더/hero/img/
define("PATH_HERO_INCLUDE_INC_HOME",                                PATH_HERO_INCLUDE_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/현재폴더/hero/img/index.php
####################################################################################################################################################
####################################################################################################################################################
define("DOMAIN_JS",                                                 DOMAIN_END."js",TRUE);                                                          //http://a.com/img
define("DOMAIN_JS_END",                                             DOMAIN_END."js".SLASH,TRUE);                                                    //http://a.com/img/
define("DOMAIN_JS_HOME",                                            DOMAIN_JS_END.PAGE_DEFAULT,TRUE);                                               //http://a.com/img/index.php

define("DOMAIN_ADMIN_JS",                                           DOMAIN_ADMIN_END."js",TRUE);                                                    //http://a.com/admin/img
define("DOMAIN_ADMIN_JS_END",                                       DOMAIN_ADMIN_END."js".SLASH,TRUE);                                              //http://a.com/admin/img/
define("DOMAIN_ADMIN_JS_HOME",                                      DOMAIN_ADMIN_JS_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/admin/img/index.php

define("DOMAIN_HERO_JS",                                            DOMAIN_HERO_END."js",TRUE);                                                     //http://a.com/hero/img
define("DOMAIN_HERO_JS_END",                                        DOMAIN_HERO_END."js".SLASH,TRUE);                                               //http://a.com/hero/img/
define("DOMAIN_HERO_JS_HOME",                                       DOMAIN_HERO_JS_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_END)
####################################################################################################################################################
define("JS",                                                        HOME_END."js",TRUE);                                                            //http://a.com/기본폴더/img
define("JS_END",                                                    HOME_END."js".SLASH,TRUE);                                                      //http://a.com/기본폴더/img/
define("JS_HOME",                                                   JS_END.PAGE_DEFAULT,TRUE);                                                      //http://a.com/기본폴더/img/index.php

define("ADMIN_JS",                                                  ADMIN_END."js",TRUE);                                                           //http://a.com/기본폴더/admin/img
define("ADMIN_JS_END",                                              ADMIN_END."js".SLASH,TRUE);                                                     //http://a.com/기본폴더/admin/img/
define("ADMIN_JS_HOME",                                             ADMIN_JS_END.PAGE_DEFAULT,TRUE);                                                //http://a.com/기본폴더/admin/img/index.php

define("HERO_JS",                                                   HERO_END."js",TRUE);                                                            //http://a.com/기본폴더/hero/img
define("HERO_JS_END",                                               HERO_END."js".SLASH,TRUE);                                                      //http://a.com/기본폴더/hero/img/
define("HERO_JS_HOME",                                              HERO_JS_END.PAGE_DEFAULT,TRUE);                                                 //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_JS",                                                   ROOT_END."js",TRUE);                                                            //http://a.com/기본폴더/img
define("ROOT_JS_END",                                               ROOT_END."js".SLASH,TRUE);                                                      //http://a.com/기본폴더/img/
define("ROOT_JS_HOME",                                              ROOT_JS_END.PAGE_DEFAULT,TRUE);                                                 //http://a.com/기본폴더/img/index.php

define("ROOT_ADMIN_JS",                                             ADMIN_END."js",TRUE);                                                           //http://a.com/기본폴더/admin/img
define("ROOT_ADMIN_JS_END",                                         ADMIN_END."js".SLASH,TRUE);                                                     //http://a.com/기본폴더/admin/img/
define("ROOT_ADMIN_JS_HOME",                                        ROOT_ADMIN_JS_END.PAGE_DEFAULT,TRUE);                                           //http://a.com/기본폴더/admin/img/index.php

define("ROOT_HERO_JS",                                              HERO_END."js",TRUE);                                                            //http://a.com/기본폴더/hero/img
define("ROOT_HERO_JS_END",                                          HERO_END."js".SLASH,TRUE);                                                      //http://a.com/기본폴더/hero/img/
define("ROOT_HERO_JS_HOME",                                         ROOT_HERO_JS_END.PAGE_DEFAULT,TRUE);                                            //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_JS",                                                   HOME_END."js",TRUE);                                                            //http://a.com/기본폴더/img
define("HOME_JS_END",                                               HOME_END."js".SLASH,TRUE);                                                      //http://a.com/기본폴더/img/
define("HOME_JS_HOME",                                              HOME_JS_END.PAGE_DEFAULT,TRUE);                                                 //http://a.com/기본폴더/img/index.php

define("HOME_ADMIN_JS",                                             ADMIN_END."js",TRUE);                                                           //http://a.com/기본폴더/admin/img
define("HOME_ADMIN_JS_END",                                         ADMIN_END."js".SLASH,TRUE);                                                     //http://a.com/기본폴더/admin/img/
define("HOME_ADMIN_JS_HOME",                                        HOME_ADMIN_JS_END.PAGE_DEFAULT,TRUE);                                           //http://a.com/기본폴더/admin/img/index.php

define("HOME_HERO_JS",                                              HERO_END."js",TRUE);                                                            //http://a.com/기본폴더/hero/img
define("HOME_HERO_JS_END",                                          HERO_END."js".SLASH,TRUE);                                                      //http://a.com/기본폴더/hero/img/
define("HOME_HERO_JS_HOME",                                         HOME_HERO_JS_END.PAGE_DEFAULT,TRUE);                                            //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_END)
####################################################################################################################################################
define("PATH_JS",                                                   PATH_END."js",TRUE);                                                            //http://a.com/현재폴더/img
define("PATH_JS_END",                                               PATH_END."js".SLASH,TRUE);                                                      //http://a.com/현재폴더/img/
define("PATH_JS_HOME",                                              PATH_JS_END.PAGE_DEFAULT,TRUE);                                                 //http://a.com/현재폴더/img/index.php

define("PATH_ADMIN_JS",                                             PATH_ADMIN_END."js",TRUE);                                                      //http://a.com/현재폴더/admin/img
define("PATH_ADMIN_JS_END",                                         PATH_ADMIN_END."js".SLASH,TRUE);                                                //http://a.com/현재폴더/admin/img/
define("PATH_ADMIN_JS_HOME",                                        PATH_ADMIN_JS_END.PAGE_DEFAULT,TRUE);                                           //http://a.com/현재폴더/admin/img/index.php

define("PATH_HERO_JS",                                              PATH_HERO_END."js",TRUE);                                                       //http://a.com/현재폴더/hero/img
define("PATH_HERO_JS_END",                                          PATH_HERO_END."js".SLASH,TRUE);                                                 //http://a.com/현재폴더/hero/img/
define("PATH_HERO_JS_HOME",                                         PATH_HERO_JS_END.PAGE_DEFAULT,TRUE);                                            //http://a.com/현재폴더/hero/img/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define("DOMAIN_JS_INC",                                             DOMAIN_INC_END."js",TRUE);                                                      //C:/APM_Setup/htdocs/img
define("DOMAIN_JS_INC_END",                                         DOMAIN_INC_END."js".SLASH,TRUE);                                                //C:/APM_Setup/htdocs/img/
define("DOMAIN_JS_INC_HOME",                                        DOMAIN_JS_INC_END.PAGE_DEFAULT,TRUE);                                           //C:/APM_Setup/htdocs/img/index.php

define("DOMAIN_ADMIN_JS_INC",                                       DOMAIN_ADMIN_INC_END."js",TRUE);                                                //C:/APM_Setup/htdocs/admin/img
define("DOMAIN_ADMIN_JS_INC_END",                                   DOMAIN_ADMIN_INC_END."js".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/admin/img/
define("DOMAIN_ADMIN_JS_INC_HOME",                                  DOMAIN_ADMIN_JS_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/admin/img/index.php

define("DOMAIN_HERO_JS_INC",                                        DOMAIN_HERO_INC_END."js",TRUE);                                                 //C:/APM_Setup/htdocs/hero/img
define("DOMAIN_HERO_JS_INC_END",                                    DOMAIN_HERO_INC_END."js".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/hero/img/
define("DOMAIN_HERO_JS_INC_HOME",                                   DOMAIN_HERO_JS_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_INC_END)
####################################################################################################################################################
define("JS_INC",                                                    HOME_INC_END."js",TRUE);                                                        //C:/APM_Setup/htdocs/기본폴더/img
define("JS_INC_END",                                                HOME_INC_END."js".SLASH,TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/img/
define("JS_INC_HOME",                                               JS_INC_END.PAGE_DEFAULT,TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ADMIN_JS_INC",                                              ADMIN_INC_END."js",TRUE);                                                       //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ADMIN_JS_INC_END",                                          ADMIN_INC_END."js".SLASH,TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ADMIN_JS_INC_HOME",                                         ADMIN_JS_INC_END.PAGE_DEFAULT,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HERO_JS_INC",                                               HERO_INC_END."js",TRUE);                                                        //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HERO_JS_INC_END",                                           HERO_INC_END."js".SLASH,TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HERO_JS_INC_HOME",                                          HERO_JS_INC_END.PAGE_DEFAULT,TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_JS_INC",                                               ROOT_INC_END."js",TRUE);                                                        //C:/APM_Setup/htdocs/기본폴더/img
define("ROOT_JS_INC_END",                                           ROOT_INC_END."js".SLASH,TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/img/
define("ROOT_JS_INC_HOME",                                          ROOT_JS_INC_END.PAGE_DEFAULT,TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ROOT_ADMIN_JS_INC",                                         ADMIN_INC_END."js",TRUE);                                                       //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ROOT_ADMIN_JS_INC_END",                                     ADMIN_INC_END."js".SLASH,TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ROOT_ADMIN_JS_INC_HOME",                                    ROOT_ADMIN_JS_INC_END.PAGE_DEFAULT,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("ROOT_HERO_JS_INC",                                          HERO_INC_END."js",TRUE);                                                        //C:/APM_Setup/htdocs/기본폴더/hero/img
define("ROOT_HERO_JS_INC_END",                                      HERO_INC_END."js".SLASH,TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("ROOT_HERO_JS_INC_HOME",                                     ROOT_HERO_JS_INC_END.PAGE_DEFAULT,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_JS_INC",                                               HOME_INC_END."js",TRUE);                                                        //C:/APM_Setup/htdocs/기본폴더/img
define("HOME_JS_INC_END",                                           HOME_INC_END."js".SLASH,TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/img/
define("HOME_JS_INC_HOME",                                          HOME_JS_INC_END.PAGE_DEFAULT,TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("HOME_ADMIN_JS_INC",                                         ADMIN_INC_END."js",TRUE);                                                       //C:/APM_Setup/htdocs/기본폴더/admin/img
define("HOME_ADMIN_JS_INC_END",                                     ADMIN_INC_END."js".SLASH,TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("HOME_ADMIN_JS_INC_HOME",                                    HOME_ADMIN_JS_INC_END.PAGE_DEFAULT,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HOME_HERO_JS_INC",                                          HERO_INC_END."js",TRUE);                                                        //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HOME_HERO_JS_INC_END",                                      HERO_INC_END."js".SLASH,TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HOME_HERO_JS_INC_HOME",                                     HOME_HERO_JS_INC_END.PAGE_DEFAULT,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_INC_END)
####################################################################################################################################################
define("PATH_JS_INC",                                               PATH_INC_END."js",TRUE);                                                        //C:/APM_Setup/htdocs/현재폴더/img
define("PATH_JS_INC_END",                                           PATH_INC_END."js".SLASH,TRUE);                                                  //C:/APM_Setup/htdocs/현재폴더/img/
define("PATH_JS_INC_HOME",                                          PATH_JS_INC_END.PAGE_DEFAULT,TRUE);                                             //C:/APM_Setup/htdocs/현재폴더/img/index.php

define("PATH_ADMIN_JS_INC",                                         PATH_ADMIN_INC_END."js",TRUE);                                                  //C:/APM_Setup/htdocs/현재폴더/admin/img
define("PATH_ADMIN_JS_INC_END",                                     PATH_ADMIN_INC_END."js".SLASH,TRUE);                                            //C:/APM_Setup/htdocs/현재폴더/admin/img/
define("PATH_ADMIN_JS_INC_HOME",                                    PATH_ADMIN_JS_INC_END.PAGE_DEFAULT,TRUE);                                       //C:/APM_Setup/htdocs/현재폴더/admin/img/index.php

define("PATH_HERO_JS_INC",                                          PATH_HERO_INC_END."js",TRUE);                                                   //C:/APM_Setup/htdocs/현재폴더/hero/img
define("PATH_HERO_JS_INC_END",                                      PATH_HERO_INC_END."js".SLASH,TRUE);                                             //C:/APM_Setup/htdocs/현재폴더/hero/img/
define("PATH_HERO_JS_INC_HOME",                                     PATH_HERO_JS_INC_END.PAGE_DEFAULT,TRUE);                                        //C:/APM_Setup/htdocs/현재폴더/hero/img/index.php
####################################################################################################################################################
####################################################################################################################################################
define("DOMAIN_MAIN",                                               DOMAIN_END."main",TRUE);                                                        //http://a.com/img
define("DOMAIN_MAIN_END",                                           DOMAIN_END."main".SLASH,TRUE);                                                  //http://a.com/img/
define("DOMAIN_MAIN_HOME",                                          DOMAIN_MAIN_END.PAGE_DEFAULT,TRUE);                                             //http://a.com/img/index.php

define("DOMAIN_ADMIN_MAIN",                                         DOMAIN_ADMIN_END."main",TRUE);                                                  //http://a.com/admin/img
define("DOMAIN_ADMIN_MAIN_END",                                     DOMAIN_ADMIN_END."main".SLASH,TRUE);                                            //http://a.com/admin/img/
define("DOMAIN_ADMIN_MAIN_HOME",                                    DOMAIN_ADMIN_MAIN_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/admin/img/index.php

define("DOMAIN_HERO_MAIN",                                          DOMAIN_HERO_END."main",TRUE);                                                   //http://a.com/hero/img
define("DOMAIN_HERO_MAIN_END",                                      DOMAIN_HERO_END."main".SLASH,TRUE);                                             //http://a.com/hero/img/
define("DOMAIN_HERO_MAIN_HOME",                                     DOMAIN_HERO_MAIN_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_END)
####################################################################################################################################################
define("MAIN",                                                      HOME_END."main",TRUE);                                                          //http://a.com/기본폴더/img
define("MAIN_END",                                                  HOME_END."main".SLASH,TRUE);                                                    //http://a.com/기본폴더/img/
define("MAIN_HOME",                                                 MAIN_END.PAGE_DEFAULT,TRUE);                                                    //http://a.com/기본폴더/img/index.php

define("ADMIN_MAIN",                                                ADMIN_END."main",TRUE);                                                         //http://a.com/기본폴더/admin/img
define("ADMIN_MAIN_END",                                            ADMIN_END."main".SLASH,TRUE);                                                   //http://a.com/기본폴더/admin/img/
define("ADMIN_MAIN_HOME",                                           ADMIN_MAIN_END.PAGE_DEFAULT,TRUE);                                              //http://a.com/기본폴더/admin/img/index.php

define("HERO_MAIN",                                                 HERO_END."main",TRUE);                                                          //http://a.com/기본폴더/hero/img
define("HERO_MAIN_END",                                             HERO_END."main".SLASH,TRUE);                                                    //http://a.com/기본폴더/hero/img/
define("HERO_MAIN_HOME",                                            HERO_MAIN_END.PAGE_DEFAULT,TRUE);                                               //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_MAIN",                                                 ROOT_END."main",TRUE);                                                          //http://a.com/기본폴더/img
define("ROOT_MAIN_END",                                             ROOT_END."main".SLASH,TRUE);                                                    //http://a.com/기본폴더/img/
define("ROOT_MAIN_HOME",                                            ROOT_MAIN_END.PAGE_DEFAULT,TRUE);                                               //http://a.com/기본폴더/img/index.php

define("ROOT_ADMIN_MAIN",                                           ADMIN_END."main",TRUE);                                                         //http://a.com/기본폴더/admin/img
define("ROOT_ADMIN_MAIN_END",                                       ADMIN_END."main".SLASH,TRUE);                                                   //http://a.com/기본폴더/admin/img/
define("ROOT_ADMIN_MAIN_HOME",                                      ROOT_ADMIN_MAIN_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/기본폴더/admin/img/index.php

define("ROOT_HERO_MAIN",                                            HERO_END."main",TRUE);                                                          //http://a.com/기본폴더/hero/img
define("ROOT_HERO_MAIN_END",                                        HERO_END."main".SLASH,TRUE);                                                    //http://a.com/기본폴더/hero/img/
define("ROOT_HERO_MAIN_HOME",                                       ROOT_HERO_MAIN_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_MAIN",                                                 HOME_END."main",TRUE);                                                          //http://a.com/기본폴더/img
define("HOME_MAIN_END",                                             HOME_END."main".SLASH,TRUE);                                                    //http://a.com/기본폴더/img/
define("HOME_MAIN_HOME",                                            HOME_MAIN_END.PAGE_DEFAULT,TRUE);                                               //http://a.com/기본폴더/img/index.php

define("HOME_ADMIN_MAIN",                                           ADMIN_END."main",TRUE);                                                         //http://a.com/기본폴더/admin/img
define("HOME_ADMIN_MAIN_END",                                       ADMIN_END."main".SLASH,TRUE);                                                   //http://a.com/기본폴더/admin/img/
define("HOME_ADMIN_MAIN_HOME",                                      HOME_ADMIN_MAIN_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/기본폴더/admin/img/index.php

define("HOME_HERO_MAIN",                                            HERO_END."main",TRUE);                                                          //http://a.com/기본폴더/hero/img
define("HOME_HERO_MAIN_END",                                        HERO_END."main".SLASH,TRUE);                                                    //http://a.com/기본폴더/hero/img/
define("HOME_HERO_MAIN_HOME",                                       HOME_HERO_MAIN_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_END)
####################################################################################################################################################
define("PATH_MAIN",                                                 PATH_END."main",TRUE);                                                          //http://a.com/현재폴더/img
define("PATH_MAIN_END",                                             PATH_END."main".SLASH,TRUE);                                                    //http://a.com/현재폴더/img/
define("PATH_MAIN_HOME",                                            PATH_MAIN_END.PAGE_DEFAULT,TRUE);                                               //http://a.com/현재폴더/img/index.php

define("PATH_ADMIN_MAIN",                                           PATH_ADMIN_END."main",TRUE);                                                    //http://a.com/현재폴더/admin/img
define("PATH_ADMIN_MAIN_END",                                       PATH_ADMIN_END."main".SLASH,TRUE);                                              //http://a.com/현재폴더/admin/img/
define("PATH_ADMIN_MAIN_HOME",                                      PATH_ADMIN_MAIN_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/현재폴더/admin/img/index.php

define("PATH_HERO_MAIN",                                            PATH_HERO_END."main",TRUE);                                                     //http://a.com/현재폴더/hero/img
define("PATH_HERO_MAIN_END",                                        PATH_HERO_END."main".SLASH,TRUE);                                               //http://a.com/현재폴더/hero/img/
define("PATH_HERO_MAIN_HOME",                                       PATH_HERO_MAIN_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/현재폴더/hero/img/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define("DOMAIN_MAIN_INC",                                           DOMAIN_INC_END."main",TRUE);                                                    //C:/APM_Setup/htdocs/img
define("DOMAIN_MAIN_INC_END",                                       DOMAIN_INC_END."main".SLASH,TRUE);                                              //C:/APM_Setup/htdocs/img/
define("DOMAIN_MAIN_INC_HOME",                                      DOMAIN_MAIN_INC_END.PAGE_DEFAULT,TRUE);                                         //C:/APM_Setup/htdocs/img/index.php

define("DOMAIN_ADMIN_MAIN_INC",                                     DOMAIN_ADMIN_INC_END."main",TRUE);                                              //C:/APM_Setup/htdocs/admin/img
define("DOMAIN_ADMIN_MAIN_INC_END",                                 DOMAIN_ADMIN_INC_END."main".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/admin/img/
define("DOMAIN_ADMIN_MAIN_INC_HOME",                                DOMAIN_ADMIN_MAIN_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/admin/img/index.php

define("DOMAIN_HERO_MAIN_INC",                                      DOMAIN_HERO_INC_END."main",TRUE);                                               //C:/APM_Setup/htdocs/hero/img
define("DOMAIN_HERO_MAIN_INC_END",                                  DOMAIN_HERO_INC_END."main".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/hero/img/
define("DOMAIN_HERO_MAIN_INC_HOME",                                 DOMAIN_HERO_MAIN_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_INC_END)
####################################################################################################################################################
define("MAIN_INC",                                                  HOME_INC_END."main",TRUE);                                                      //C:/APM_Setup/htdocs/기본폴더/img
define("MAIN_INC_END",                                              HOME_INC_END."main".SLASH,TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/img/
define("MAIN_INC_HOME",                                             MAIN_INC_END.PAGE_DEFAULT,TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ADMIN_MAIN_INC",                                            ADMIN_INC_END."main",TRUE);                                                     //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ADMIN_MAIN_INC_END",                                        ADMIN_INC_END."main".SLASH,TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ADMIN_MAIN_INC_HOME",                                       ADMIN_MAIN_INC_END.PAGE_DEFAULT,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HERO_MAIN_INC",                                             HERO_INC_END."main",TRUE);                                                      //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HERO_MAIN_INC_END",                                         HERO_INC_END."main".SLASH,TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HERO_MAIN_INC_HOME",                                        HERO_MAIN_INC_END.PAGE_DEFAULT,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_MAIN_INC",                                             ROOT_INC_END."main",TRUE);                                                      //C:/APM_Setup/htdocs/기본폴더/img
define("ROOT_MAIN_INC_END",                                         ROOT_INC_END."main".SLASH,TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/img/
define("ROOT_MAIN_INC_HOME",                                        ROOT_MAIN_INC_END.PAGE_DEFAULT,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ROOT_ADMIN_MAIN_INC",                                       ADMIN_INC_END."main",TRUE);                                                     //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ROOT_ADMIN_MAIN_INC_END",                                   ADMIN_INC_END."main".SLASH,TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ROOT_ADMIN_MAIN_INC_HOME",                                  ROOT_ADMIN_MAIN_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("ROOT_HERO_MAIN_INC",                                        HERO_INC_END."main",TRUE);                                                      //C:/APM_Setup/htdocs/기본폴더/hero/img
define("ROOT_HERO_MAIN_INC_END",                                    HERO_INC_END."main".SLASH,TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("ROOT_HERO_MAIN_INC_HOME",                                   ROOT_HERO_MAIN_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_MAIN_INC",                                             HOME_INC_END."main",TRUE);                                                      //C:/APM_Setup/htdocs/기본폴더/img
define("HOME_MAIN_INC_END",                                         HOME_INC_END."main".SLASH,TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/img/
define("HOME_MAIN_INC_HOME",                                        HOME_MAIN_INC_END.PAGE_DEFAULT,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("HOME_ADMIN_MAIN_INC",                                       ADMIN_INC_END."main",TRUE);                                                     //C:/APM_Setup/htdocs/기본폴더/admin/img
define("HOME_ADMIN_MAIN_INC_END",                                   ADMIN_INC_END."main".SLASH,TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("HOME_ADMIN_MAIN_INC_HOME",                                  HOME_ADMIN_MAIN_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HOME_HERO_MAIN_INC",                                        HERO_INC_END."main",TRUE);                                                      //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HOME_HERO_MAIN_INC_END",                                    HERO_INC_END."main".SLASH,TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HOME_HERO_MAIN_INC_HOME",                                   HOME_HERO_MAIN_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_INC_END)
####################################################################################################################################################
define("PATH_MAIN_INC",                                             PATH_INC_END."main",TRUE);                                                      //C:/APM_Setup/htdocs/현재폴더/img
define("PATH_MAIN_INC_END",                                         PATH_INC_END."main".SLASH,TRUE);                                                //C:/APM_Setup/htdocs/현재폴더/img/
define("PATH_MAIN_INC_HOME",                                        PATH_MAIN_INC_END.PAGE_DEFAULT,TRUE);                                           //C:/APM_Setup/htdocs/현재폴더/img/index.php

define("PATH_ADMIN_MAIN_INC",                                       PATH_ADMIN_INC_END."main",TRUE);                                                //C:/APM_Setup/htdocs/현재폴더/admin/img
define("PATH_ADMIN_MAIN_INC_END",                                   PATH_ADMIN_INC_END."main".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/현재폴더/admin/img/
define("PATH_ADMIN_MAIN_INC_HOME",                                  PATH_ADMIN_MAIN_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/현재폴더/admin/img/index.php

define("PATH_HERO_MAIN_INC",                                        PATH_HERO_INC_END."main",TRUE);                                                 //C:/APM_Setup/htdocs/현재폴더/hero/img
define("PATH_HERO_MAIN_INC_END",                                    PATH_HERO_INC_END."main".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/현재폴더/hero/img/
define("PATH_HERO_MAIN_INC_HOME",                                   PATH_HERO_MAIN_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/현재폴더/hero/img/index.php
####################################################################################################################################################
####################################################################################################################################################
define("DOMAIN_PSD",                                                DOMAIN_END."psd",TRUE);                                                         //http://a.com/img
define("DOMAIN_PSD_END",                                            DOMAIN_END."psd".SLASH,TRUE);                                                   //http://a.com/img/
define("DOMAIN_PSD_HOME",                                           DOMAIN_PSD_END.PAGE_DEFAULT,TRUE);                                              //http://a.com/img/index.php

define("DOMAIN_ADMIN_PSD",                                          DOMAIN_ADMIN_END."psd",TRUE);                                                   //http://a.com/admin/img
define("DOMAIN_ADMIN_PSD_END",                                      DOMAIN_ADMIN_END."psd".SLASH,TRUE);                                             //http://a.com/admin/img/
define("DOMAIN_ADMIN_PSD_HOME",                                     DOMAIN_ADMIN_PSD_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/admin/img/index.php

define("DOMAIN_HERO_PSD",                                           DOMAIN_HERO_END."psd",TRUE);                                                    //http://a.com/hero/img
define("DOMAIN_HERO_PSD_END",                                       DOMAIN_HERO_END."psd".SLASH,TRUE);                                              //http://a.com/hero/img/
define("DOMAIN_HERO_PSD_HOME",                                      DOMAIN_HERO_PSD_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_END)
####################################################################################################################################################
define("PSD",                                                       HOME_END."psd",TRUE);                                                           //http://a.com/기본폴더/img
define("PSD_END",                                                   HOME_END."psd".SLASH,TRUE);                                                     //http://a.com/기본폴더/img/
define("PSD_HOME",                                                  PSD_END.PAGE_DEFAULT,TRUE);                                                     //http://a.com/기본폴더/img/index.php

define("ADMIN_PSD",                                                 ADMIN_END."psd",TRUE);                                                          //http://a.com/기본폴더/admin/img
define("ADMIN_PSD_END",                                             ADMIN_END."psd".SLASH,TRUE);                                                    //http://a.com/기본폴더/admin/img/
define("ADMIN_PSD_HOME",                                            ADMIN_PSD_END.PAGE_DEFAULT,TRUE);                                               //http://a.com/기본폴더/admin/img/index.php

define("HERO_PSD",                                                  HERO_END."psd",TRUE);                                                           //http://a.com/기본폴더/hero/img
define("HERO_PSD_END",                                              HERO_END."psd".SLASH,TRUE);                                                     //http://a.com/기본폴더/hero/img/
define("HERO_PSD_HOME",                                             HERO_PSD_END.PAGE_DEFAULT,TRUE);                                                //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_PSD",                                                  ROOT_END."psd",TRUE);                                                           //http://a.com/기본폴더/img
define("ROOT_PSD_END",                                              ROOT_END."psd".SLASH,TRUE);                                                     //http://a.com/기본폴더/img/
define("ROOT_PSD_HOME",                                             ROOT_PSD_END.PAGE_DEFAULT,TRUE);                                                //http://a.com/기본폴더/img/index.php

define("ROOT_ADMIN_PSD",                                            ADMIN_END."psd",TRUE);                                                          //http://a.com/기본폴더/admin/img
define("ROOT_ADMIN_PSD_END",                                        ADMIN_END."psd".SLASH,TRUE);                                                    //http://a.com/기본폴더/admin/img/
define("ROOT_ADMIN_PSD_HOME",                                       ROOT_ADMIN_PSD_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/기본폴더/admin/img/index.php

define("ROOT_HERO_PSD",                                             HERO_END."psd",TRUE);                                                           //http://a.com/기본폴더/hero/img
define("ROOT_HERO_PSD_END",                                         HERO_END."psd".SLASH,TRUE);                                                     //http://a.com/기본폴더/hero/img/
define("ROOT_HERO_PSD_HOME",                                        ROOT_HERO_PSD_END.PAGE_DEFAULT,TRUE);                                           //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_PSD",                                                  HOME_END."psd",TRUE);                                                           //http://a.com/기본폴더/img
define("HOME_PSD_END",                                              HOME_END."psd".SLASH,TRUE);                                                     //http://a.com/기본폴더/img/
define("HOME_PSD_HOME",                                             HOME_PSD_END.PAGE_DEFAULT,TRUE);                                                //http://a.com/기본폴더/img/index.php

define("HOME_ADMIN_PSD",                                            ADMIN_END."psd",TRUE);                                                          //http://a.com/기본폴더/admin/img
define("HOME_ADMIN_PSD_END",                                        ADMIN_END."psd".SLASH,TRUE);                                                    //http://a.com/기본폴더/admin/img/
define("HOME_ADMIN_PSD_HOME",                                       HOME_ADMIN_PSD_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/기본폴더/admin/img/index.php

define("HOME_HERO_PSD",                                             HERO_END."psd",TRUE);                                                           //http://a.com/기본폴더/hero/img
define("HOME_HERO_PSD_END",                                         HERO_END."psd".SLASH,TRUE);                                                     //http://a.com/기본폴더/hero/img/
define("HOME_HERO_PSD_HOME",                                        HOME_HERO_PSD_END.PAGE_DEFAULT,TRUE);                                           //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_END)
####################################################################################################################################################
define("PATH_PSD",                                                  PATH_END."psd",TRUE);                                                           //http://a.com/현재폴더/img
define("PATH_PSD_END",                                              PATH_END."psd".SLASH,TRUE);                                                     //http://a.com/현재폴더/img/
define("PATH_PSD_HOME",                                             PATH_PSD_END.PAGE_DEFAULT,TRUE);                                                //http://a.com/현재폴더/img/index.php

define("PATH_ADMIN_PSD",                                            PATH_ADMIN_END."psd",TRUE);                                                     //http://a.com/현재폴더/admin/img
define("PATH_ADMIN_PSD_END",                                        PATH_ADMIN_END."psd".SLASH,TRUE);                                               //http://a.com/현재폴더/admin/img/
define("PATH_ADMIN_PSD_HOME",                                       PATH_ADMIN_PSD_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/현재폴더/admin/img/index.php

define("PATH_HERO_PSD",                                             PATH_HERO_END."psd",TRUE);                                                      //http://a.com/현재폴더/hero/img
define("PATH_HERO_PSD_END",                                         PATH_HERO_END."psd".SLASH,TRUE);                                                //http://a.com/현재폴더/hero/img/
define("PATH_HERO_PSD_HOME",                                        PATH_HERO_PSD_END.PAGE_DEFAULT,TRUE);                                           //http://a.com/현재폴더/hero/img/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define("DOMAIN_PSD_INC",                                            DOMAIN_INC_END."psd",TRUE);                                                     //C:/APM_Setup/htdocs/img
define("DOMAIN_PSD_INC_END",                                        DOMAIN_INC_END."psd".SLASH,TRUE);                                               //C:/APM_Setup/htdocs/img/
define("DOMAIN_PSD_INC_HOME",                                       DOMAIN_PSD_INC_END.PAGE_DEFAULT,TRUE);                                          //C:/APM_Setup/htdocs/img/index.php

define("DOMAIN_ADMIN_PSD_INC",                                      DOMAIN_ADMIN_INC_END."psd",TRUE);                                               //C:/APM_Setup/htdocs/admin/img
define("DOMAIN_ADMIN_PSD_INC_END",                                  DOMAIN_ADMIN_INC_END."psd".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/admin/img/
define("DOMAIN_ADMIN_PSD_INC_HOME",                                 DOMAIN_ADMIN_PSD_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/admin/img/index.php

define("DOMAIN_HERO_PSD_INC",                                       DOMAIN_HERO_INC_END."psd",TRUE);                                                //C:/APM_Setup/htdocs/hero/img
define("DOMAIN_HERO_PSD_INC_END",                                   DOMAIN_HERO_INC_END."psd".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/hero/img/
define("DOMAIN_HERO_PSD_INC_HOME",                                  DOMAIN_HERO_PSD_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_INC_END)
####################################################################################################################################################
define("PSD_INC",                                                   HOME_INC_END."psd",TRUE);                                                       //C:/APM_Setup/htdocs/기본폴더/img
define("PSD_INC_END",                                               HOME_INC_END."psd".SLASH,TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/img/
define("PSD_INC_HOME",                                              PSD_INC_END.PAGE_DEFAULT,TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ADMIN_PSD_INC",                                             ADMIN_INC_END."psd",TRUE);                                                      //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ADMIN_PSD_INC_END",                                         ADMIN_INC_END."psd".SLASH,TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ADMIN_PSD_INC_HOME",                                        ADMIN_PSD_INC_END.PAGE_DEFAULT,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HERO_PSD_INC",                                              HERO_INC_END."psd",TRUE);                                                       //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HERO_PSD_INC_END",                                          HERO_INC_END."psd".SLASH,TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HERO_PSD_INC_HOME",                                         HERO_PSD_INC_END.PAGE_DEFAULT,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_PSD_INC",                                              ROOT_INC_END."psd",TRUE);                                                       //C:/APM_Setup/htdocs/기본폴더/img
define("ROOT_PSD_INC_END",                                          ROOT_INC_END."psd".SLASH,TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/img/
define("ROOT_PSD_INC_HOME",                                         ROOT_PSD_INC_END.PAGE_DEFAULT,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ROOT_ADMIN_PSD_INC",                                        ADMIN_INC_END."psd",TRUE);                                                      //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ROOT_ADMIN_PSD_INC_END",                                    ADMIN_INC_END."psd".SLASH,TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ROOT_ADMIN_PSD_INC_HOME",                                   ROOT_ADMIN_PSD_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("ROOT_HERO_PSD_INC",                                         HERO_INC_END."psd",TRUE);                                                       //C:/APM_Setup/htdocs/기본폴더/hero/img
define("ROOT_HERO_PSD_INC_END",                                     HERO_INC_END."psd".SLASH,TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("ROOT_HERO_PSD_INC_HOME",                                    ROOT_HERO_PSD_INC_END.PAGE_DEFAULT,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_PSD_INC",                                              HOME_INC_END."psd",TRUE);                                                       //C:/APM_Setup/htdocs/기본폴더/img
define("HOME_PSD_INC_END",                                          HOME_INC_END."psd".SLASH,TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/img/
define("HOME_PSD_INC_HOME",                                         HOME_PSD_INC_END.PAGE_DEFAULT,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("HOME_ADMIN_PSD_INC",                                        ADMIN_INC_END."psd",TRUE);                                                      //C:/APM_Setup/htdocs/기본폴더/admin/img
define("HOME_ADMIN_PSD_INC_END",                                    ADMIN_INC_END."psd".SLASH,TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("HOME_ADMIN_PSD_INC_HOME",                                   HOME_ADMIN_PSD_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HOME_HERO_PSD_INC",                                         HERO_INC_END."psd",TRUE);                                                       //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HOME_HERO_PSD_INC_END",                                     HERO_INC_END."psd".SLASH,TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HOME_HERO_PSD_INC_HOME",                                    HOME_HERO_PSD_INC_END.PAGE_DEFAULT,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_INC_END)
####################################################################################################################################################
define("PATH_PSD_INC",                                              PATH_INC_END."psd",TRUE);                                                       //C:/APM_Setup/htdocs/현재폴더/img
define("PATH_PSD_INC_END",                                          PATH_INC_END."psd".SLASH,TRUE);                                                 //C:/APM_Setup/htdocs/현재폴더/img/
define("PATH_PSD_INC_HOME",                                         PATH_PSD_INC_END.PAGE_DEFAULT,TRUE);                                            //C:/APM_Setup/htdocs/현재폴더/img/index.php

define("PATH_ADMIN_PSD_INC",                                        PATH_ADMIN_INC_END."psd",TRUE);                                                 //C:/APM_Setup/htdocs/현재폴더/admin/img
define("PATH_ADMIN_PSD_INC_END",                                    PATH_ADMIN_INC_END."psd".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/현재폴더/admin/img/
define("PATH_ADMIN_PSD_INC_HOME",                                   PATH_ADMIN_PSD_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/현재폴더/admin/img/index.php

define("PATH_HERO_PSD_INC",                                         PATH_HERO_INC_END."psd",TRUE);                                                  //C:/APM_Setup/htdocs/현재폴더/hero/img
define("PATH_HERO_PSD_INC_END",                                     PATH_HERO_INC_END."psd".SLASH,TRUE);                                            //C:/APM_Setup/htdocs/현재폴더/hero/img/
define("PATH_HERO_PSD_INC_HOME",                                    PATH_HERO_PSD_INC_END.PAGE_DEFAULT,TRUE);                                       //C:/APM_Setup/htdocs/현재폴더/hero/img/index.php
####################################################################################################################################################
####################################################################################################################################################
define("DOMAIN_SUB_ACTIVITY",                                       DOMAIN_END."sub_activity",TRUE);                                                //http://a.com/img
define("DOMAIN_SUB_ACTIVITY_END",                                   DOMAIN_END."sub_activity".SLASH,TRUE);                                          //http://a.com/img/
define("DOMAIN_SUB_ACTIVITY_HOME",                                  DOMAIN_SUB_ACTIVITY_END.PAGE_DEFAULT,TRUE);                                     //http://a.com/img/index.php

define("DOMAIN_ADMIN_SUB_ACTIVITY",                                 DOMAIN_ADMIN_END."sub_activity",TRUE);                                          //http://a.com/admin/img
define("DOMAIN_ADMIN_SUB_ACTIVITY_END",                             DOMAIN_ADMIN_END."sub_activity".SLASH,TRUE);                                    //http://a.com/admin/img/
define("DOMAIN_ADMIN_SUB_ACTIVITY_HOME",                            DOMAIN_ADMIN_SUB_ACTIVITY_END.PAGE_DEFAULT,TRUE);                               //http://a.com/admin/img/index.php

define("DOMAIN_HERO_SUB_ACTIVITY",                                  DOMAIN_HERO_END."sub_activity",TRUE);                                           //http://a.com/hero/img
define("DOMAIN_HERO_SUB_ACTIVITY_END",                              DOMAIN_HERO_END."sub_activity".SLASH,TRUE);                                     //http://a.com/hero/img/
define("DOMAIN_HERO_SUB_ACTIVITY_HOME",                             DOMAIN_HERO_SUB_ACTIVITY_END.PAGE_DEFAULT,TRUE);                                //http://a.com/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_END)
####################################################################################################################################################
define("SUB_ACTIVITY",                                              HOME_END."sub_activity",TRUE);                                                  //http://a.com/기본폴더/img
define("SUB_ACTIVITY_END",                                          HOME_END."sub_activity".SLASH,TRUE);                                            //http://a.com/기본폴더/img/
define("SUB_ACTIVITY_HOME",                                         SUB_ACTIVITY_END.PAGE_DEFAULT,TRUE);                                            //http://a.com/기본폴더/img/index.php

define("ADMIN_SUB_ACTIVITY",                                        ADMIN_END."sub_activity",TRUE);                                                 //http://a.com/기본폴더/admin/img
define("ADMIN_SUB_ACTIVITY_END",                                    ADMIN_END."sub_activity".SLASH,TRUE);                                           //http://a.com/기본폴더/admin/img/
define("ADMIN_SUB_ACTIVITY_HOME",                                   ADMIN_SUB_ACTIVITY_END.PAGE_DEFAULT,TRUE);                                      //http://a.com/기본폴더/admin/img/index.php

define("HERO_SUB_ACTIVITY",                                         HERO_END."sub_activity",TRUE);                                                  //http://a.com/기본폴더/hero/img
define("HERO_SUB_ACTIVITY_END",                                     HERO_END."sub_activity".SLASH,TRUE);                                            //http://a.com/기본폴더/hero/img/
define("HERO_SUB_ACTIVITY_HOME",                                    HERO_SUB_ACTIVITY_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_SUB_ACTIVITY",                                         ROOT_END."sub_activity",TRUE);                                                  //http://a.com/기본폴더/img
define("ROOT_SUB_ACTIVITY_END",                                     ROOT_END."sub_activity".SLASH,TRUE);                                            //http://a.com/기본폴더/img/
define("ROOT_SUB_ACTIVITY_HOME",                                    ROOT_SUB_ACTIVITY_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/기본폴더/img/index.php

define("ROOT_ADMIN_SUB_ACTIVITY",                                   ADMIN_END."sub_activity",TRUE);                                                 //http://a.com/기본폴더/admin/img
define("ROOT_ADMIN_SUB_ACTIVITY_END",                               ADMIN_END."sub_activity".SLASH,TRUE);                                           //http://a.com/기본폴더/admin/img/
define("ROOT_ADMIN_SUB_ACTIVITY_HOME",                              ROOT_ADMIN_SUB_ACTIVITY_END.PAGE_DEFAULT,TRUE);                                 //http://a.com/기본폴더/admin/img/index.php

define("ROOT_HERO_SUB_ACTIVITY",                                    HERO_END."sub_activity",TRUE);                                                  //http://a.com/기본폴더/hero/img
define("ROOT_HERO_SUB_ACTIVITY_END",                                HERO_END."sub_activity".SLASH,TRUE);                                            //http://a.com/기본폴더/hero/img/
define("ROOT_HERO_SUB_ACTIVITY_HOME",                               ROOT_HERO_SUB_ACTIVITY_END.PAGE_DEFAULT,TRUE);                                  //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_SUB_ACTIVITY",                                         HOME_END."sub_activity",TRUE);                                                  //http://a.com/기본폴더/img
define("HOME_SUB_ACTIVITY_END",                                     HOME_END."sub_activity".SLASH,TRUE);                                            //http://a.com/기본폴더/img/
define("HOME_SUB_ACTIVITY_HOME",                                    HOME_SUB_ACTIVITY_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/기본폴더/img/index.php

define("HOME_ADMIN_SUB_ACTIVITY",                                   ADMIN_END."sub_activity",TRUE);                                                 //http://a.com/기본폴더/admin/img
define("HOME_ADMIN_SUB_ACTIVITY_END",                               ADMIN_END."sub_activity".SLASH,TRUE);                                           //http://a.com/기본폴더/admin/img/
define("HOME_ADMIN_SUB_ACTIVITY_HOME",                              HOME_ADMIN_SUB_ACTIVITY_END.PAGE_DEFAULT,TRUE);                                 //http://a.com/기본폴더/admin/img/index.php

define("HOME_HERO_SUB_ACTIVITY",                                    HERO_END."sub_activity",TRUE);                                                  //http://a.com/기본폴더/hero/img
define("HOME_HERO_SUB_ACTIVITY_END",                                HERO_END."sub_activity".SLASH,TRUE);                                            //http://a.com/기본폴더/hero/img/
define("HOME_HERO_SUB_ACTIVITY_HOME",                               HOME_HERO_SUB_ACTIVITY_END.PAGE_DEFAULT,TRUE);                                  //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_END)
####################################################################################################################################################
define("PATH_SUB_ACTIVITY",                                         PATH_END."sub_activity",TRUE);                                                  //http://a.com/현재폴더/img
define("PATH_SUB_ACTIVITY_END",                                     PATH_END."sub_activity".SLASH,TRUE);                                            //http://a.com/현재폴더/img/
define("PATH_SUB_ACTIVITY_HOME",                                    PATH_SUB_ACTIVITY_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/현재폴더/img/index.php

define("PATH_ADMIN_SUB_ACTIVITY",                                   PATH_ADMIN_END."sub_activity",TRUE);                                            //http://a.com/현재폴더/admin/img
define("PATH_ADMIN_SUB_ACTIVITY_END",                               PATH_ADMIN_END."sub_activity".SLASH,TRUE);                                      //http://a.com/현재폴더/admin/img/
define("PATH_ADMIN_SUB_ACTIVITY_HOME",                              PATH_ADMIN_SUB_ACTIVITY_END.PAGE_DEFAULT,TRUE);                                 //http://a.com/현재폴더/admin/img/index.php

define("PATH_HERO_SUB_ACTIVITY",                                    PATH_HERO_END."sub_activity",TRUE);                                             //http://a.com/현재폴더/hero/img
define("PATH_HERO_SUB_ACTIVITY_END",                                PATH_HERO_END."sub_activity".SLASH,TRUE);                                       //http://a.com/현재폴더/hero/img/
define("PATH_HERO_SUB_ACTIVITY_HOME",                               PATH_HERO_SUB_ACTIVITY_END.PAGE_DEFAULT,TRUE);                                  //http://a.com/현재폴더/hero/img/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define("DOMAIN_SUB_ACTIVITY_INC",                                   DOMAIN_INC_END."sub_activity",TRUE);                                            //C:/APM_Setup/htdocs/img
define("DOMAIN_SUB_ACTIVITY_INC_END",                               DOMAIN_INC_END."sub_activity".SLASH,TRUE);                                      //C:/APM_Setup/htdocs/img/
define("DOMAIN_SUB_ACTIVITY_INC_HOME",                              DOMAIN_SUB_ACTIVITY_INC_END.PAGE_DEFAULT,TRUE);                                 //C:/APM_Setup/htdocs/img/index.php

define("DOMAIN_ADMIN_SUB_ACTIVITY_INC",                             DOMAIN_ADMIN_INC_END."sub_activity",TRUE);                                      //C:/APM_Setup/htdocs/admin/img
define("DOMAIN_ADMIN_SUB_ACTIVITY_INC_END",                         DOMAIN_ADMIN_INC_END."sub_activity".SLASH,TRUE);                                //C:/APM_Setup/htdocs/admin/img/
define("DOMAIN_ADMIN_SUB_ACTIVITY_INC_HOME",                        DOMAIN_ADMIN_SUB_ACTIVITY_INC_END.PAGE_DEFAULT,TRUE);                           //C:/APM_Setup/htdocs/admin/img/index.php

define("DOMAIN_HERO_SUB_ACTIVITY_INC",                              DOMAIN_HERO_INC_END."sub_activity",TRUE);                                       //C:/APM_Setup/htdocs/hero/img
define("DOMAIN_HERO_SUB_ACTIVITY_INC_END",                          DOMAIN_HERO_INC_END."sub_activity".SLASH,TRUE);                                 //C:/APM_Setup/htdocs/hero/img/
define("DOMAIN_HERO_SUB_ACTIVITY_INC_HOME",                         DOMAIN_HERO_SUB_ACTIVITY_INC_END.PAGE_DEFAULT,TRUE);                            //C:/APM_Setup/htdocs/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_INC_END)
####################################################################################################################################################
define("SUB_ACTIVITY_INC",                                          HOME_INC_END."sub_activity",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/img
define("SUB_ACTIVITY_INC_END",                                      HOME_INC_END."sub_activity".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/img/
define("SUB_ACTIVITY_INC_HOME",                                     SUB_ACTIVITY_INC_END.PAGE_DEFAULT,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ADMIN_SUB_ACTIVITY_INC",                                    ADMIN_INC_END."sub_activity",TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ADMIN_SUB_ACTIVITY_INC_END",                                ADMIN_INC_END."sub_activity".SLASH,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ADMIN_SUB_ACTIVITY_INC_HOME",                               ADMIN_SUB_ACTIVITY_INC_END.PAGE_DEFAULT,TRUE);                                  //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HERO_SUB_ACTIVITY_INC",                                     HERO_INC_END."sub_activity",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HERO_SUB_ACTIVITY_INC_END",                                 HERO_INC_END."sub_activity".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HERO_SUB_ACTIVITY_INC_HOME",                                HERO_SUB_ACTIVITY_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_SUB_ACTIVITY_INC",                                     ROOT_INC_END."sub_activity",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/img
define("ROOT_SUB_ACTIVITY_INC_END",                                 ROOT_INC_END."sub_activity".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/img/
define("ROOT_SUB_ACTIVITY_INC_HOME",                                ROOT_SUB_ACTIVITY_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ROOT_ADMIN_SUB_ACTIVITY_INC",                               ADMIN_INC_END."sub_activity",TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ROOT_ADMIN_SUB_ACTIVITY_INC_END",                           ADMIN_INC_END."sub_activity".SLASH,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ROOT_ADMIN_SUB_ACTIVITY_INC_HOME",                          ROOT_ADMIN_SUB_ACTIVITY_INC_END.PAGE_DEFAULT,TRUE);                             //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("ROOT_HERO_SUB_ACTIVITY_INC",                                HERO_INC_END."sub_activity",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/hero/img
define("ROOT_HERO_SUB_ACTIVITY_INC_END",                            HERO_INC_END."sub_activity".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("ROOT_HERO_SUB_ACTIVITY_INC_HOME",                           ROOT_HERO_SUB_ACTIVITY_INC_END.PAGE_DEFAULT,TRUE);                              //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_SUB_ACTIVITY_INC",                                     HOME_INC_END."sub_activity",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/img
define("HOME_SUB_ACTIVITY_INC_END",                                 HOME_INC_END."sub_activity".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/img/
define("HOME_SUB_ACTIVITY_INC_HOME",                                HOME_SUB_ACTIVITY_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("HOME_ADMIN_SUB_ACTIVITY_INC",                               ADMIN_INC_END."sub_activity",TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/admin/img
define("HOME_ADMIN_SUB_ACTIVITY_INC_END",                           ADMIN_INC_END."sub_activity".SLASH,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("HOME_ADMIN_SUB_ACTIVITY_INC_HOME",                          HOME_ADMIN_SUB_ACTIVITY_INC_END.PAGE_DEFAULT,TRUE);                             //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HOME_HERO_SUB_ACTIVITY_INC",                                HERO_INC_END."sub_activity",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HOME_HERO_SUB_ACTIVITY_INC_END",                            HERO_INC_END."sub_activity".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HOME_HERO_SUB_ACTIVITY_INC_HOME",                           HOME_HERO_SUB_ACTIVITY_INC_END.PAGE_DEFAULT,TRUE);                              //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_INC_END)
####################################################################################################################################################
define("PATH_SUB_ACTIVITY_INC",                                     PATH_INC_END."sub_activity",TRUE);                                              //C:/APM_Setup/htdocs/현재폴더/img
define("PATH_SUB_ACTIVITY_INC_END",                                 PATH_INC_END."sub_activity".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/현재폴더/img/
define("PATH_SUB_ACTIVITY_INC_HOME",                                PATH_SUB_ACTIVITY_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/현재폴더/img/index.php

define("PATH_ADMIN_SUB_ACTIVITY_INC",                               PATH_ADMIN_INC_END."sub_activity",TRUE);                                        //C:/APM_Setup/htdocs/현재폴더/admin/img
define("PATH_ADMIN_SUB_ACTIVITY_INC_END",                           PATH_ADMIN_INC_END."sub_activity".SLASH,TRUE);                                  //C:/APM_Setup/htdocs/현재폴더/admin/img/
define("PATH_ADMIN_SUB_ACTIVITY_INC_HOME",                          PATH_ADMIN_SUB_ACTIVITY_INC_END.PAGE_DEFAULT,TRUE);                             //C:/APM_Setup/htdocs/현재폴더/admin/img/index.php

define("PATH_HERO_SUB_ACTIVITY_INC",                                PATH_HERO_INC_END."sub_activity",TRUE);                                         //C:/APM_Setup/htdocs/현재폴더/hero/img
define("PATH_HERO_SUB_ACTIVITY_INC_END",                            PATH_HERO_INC_END."sub_activity".SLASH,TRUE);                                   //C:/APM_Setup/htdocs/현재폴더/hero/img/
define("PATH_HERO_SUB_ACTIVITY_INC_HOME",                           PATH_HERO_SUB_ACTIVITY_INC_END.PAGE_DEFAULT,TRUE);                              //C:/APM_Setup/htdocs/현재폴더/hero/img/index.php
####################################################################################################################################################
####################################################################################################################################################
define("DOMAIN_SUB_CUSTOMER",                                       DOMAIN_END."sub_customer",TRUE);                                                //http://a.com/img
define("DOMAIN_SUB_CUSTOMER_END",                                   DOMAIN_END."sub_customer".SLASH,TRUE);                                          //http://a.com/img/
define("DOMAIN_SUB_CUSTOMER_HOME",                                  DOMAIN_SUB_CUSTOMER_END.PAGE_DEFAULT,TRUE);                                     //http://a.com/img/index.php

define("DOMAIN_ADMIN_SUB_CUSTOMER",                                 DOMAIN_ADMIN_END."sub_customer",TRUE);                                          //http://a.com/admin/img
define("DOMAIN_ADMIN_SUB_CUSTOMER_END",                             DOMAIN_ADMIN_END."sub_customer".SLASH,TRUE);                                    //http://a.com/admin/img/
define("DOMAIN_ADMIN_SUB_CUSTOMER_HOME",                            DOMAIN_ADMIN_SUB_CUSTOMER_END.PAGE_DEFAULT,TRUE);                               //http://a.com/admin/img/index.php

define("DOMAIN_HERO_SUB_CUSTOMER",                                  DOMAIN_HERO_END."sub_customer",TRUE);                                           //http://a.com/hero/img
define("DOMAIN_HERO_SUB_CUSTOMER_END",                              DOMAIN_HERO_END."sub_customer".SLASH,TRUE);                                     //http://a.com/hero/img/
define("DOMAIN_HERO_SUB_CUSTOMER_HOME",                             DOMAIN_HERO_SUB_CUSTOMER_END.PAGE_DEFAULT,TRUE);                                //http://a.com/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_END)
####################################################################################################################################################
define("SUB_CUSTOMER",                                              HOME_END."sub_customer",TRUE);                                                  //http://a.com/기본폴더/img
define("SUB_CUSTOMER_END",                                          HOME_END."sub_customer".SLASH,TRUE);                                            //http://a.com/기본폴더/img/
define("SUB_CUSTOMER_HOME",                                         SUB_CUSTOMER_END.PAGE_DEFAULT,TRUE);                                            //http://a.com/기본폴더/img/index.php

define("ADMIN_SUB_CUSTOMER",                                        ADMIN_END."sub_customer",TRUE);                                                 //http://a.com/기본폴더/admin/img
define("ADMIN_SUB_CUSTOMER_END",                                    ADMIN_END."sub_customer".SLASH,TRUE);                                           //http://a.com/기본폴더/admin/img/
define("ADMIN_SUB_CUSTOMER_HOME",                                   ADMIN_SUB_CUSTOMER_END.PAGE_DEFAULT,TRUE);                                      //http://a.com/기본폴더/admin/img/index.php

define("HERO_SUB_CUSTOMER",                                         HERO_END."sub_customer",TRUE);                                                  //http://a.com/기본폴더/hero/img
define("HERO_SUB_CUSTOMER_END",                                     HERO_END."sub_customer".SLASH,TRUE);                                            //http://a.com/기본폴더/hero/img/
define("HERO_SUB_CUSTOMER_HOME",                                    HERO_SUB_CUSTOMER_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_SUB_CUSTOMER",                                         ROOT_END."sub_customer",TRUE);                                                  //http://a.com/기본폴더/img
define("ROOT_SUB_CUSTOMER_END",                                     ROOT_END."sub_customer".SLASH,TRUE);                                            //http://a.com/기본폴더/img/
define("ROOT_SUB_CUSTOMER_HOME",                                    ROOT_SUB_CUSTOMER_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/기본폴더/img/index.php

define("ROOT_ADMIN_SUB_CUSTOMER",                                   ADMIN_END."sub_customer",TRUE);                                                 //http://a.com/기본폴더/admin/img
define("ROOT_ADMIN_SUB_CUSTOMER_END",                               ADMIN_END."sub_customer".SLASH,TRUE);                                           //http://a.com/기본폴더/admin/img/
define("ROOT_ADMIN_SUB_CUSTOMER_HOME",                              ROOT_ADMIN_SUB_CUSTOMER_END.PAGE_DEFAULT,TRUE);                                 //http://a.com/기본폴더/admin/img/index.php

define("ROOT_HERO_SUB_CUSTOMER",                                    HERO_END."sub_customer",TRUE);                                                  //http://a.com/기본폴더/hero/img
define("ROOT_HERO_SUB_CUSTOMER_END",                                HERO_END."sub_customer".SLASH,TRUE);                                            //http://a.com/기본폴더/hero/img/
define("ROOT_HERO_SUB_CUSTOMER_HOME",                               ROOT_HERO_SUB_CUSTOMER_END.PAGE_DEFAULT,TRUE);                                  //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_SUB_CUSTOMER",                                         HOME_END."sub_customer",TRUE);                                                  //http://a.com/기본폴더/img
define("HOME_SUB_CUSTOMER_END",                                     HOME_END."sub_customer".SLASH,TRUE);                                            //http://a.com/기본폴더/img/
define("HOME_SUB_CUSTOMER_HOME",                                    HOME_SUB_CUSTOMER_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/기본폴더/img/index.php

define("HOME_ADMIN_SUB_CUSTOMER",                                   ADMIN_END."sub_customer",TRUE);                                                 //http://a.com/기본폴더/admin/img
define("HOME_ADMIN_SUB_CUSTOMER_END",                               ADMIN_END."sub_customer".SLASH,TRUE);                                           //http://a.com/기본폴더/admin/img/
define("HOME_ADMIN_SUB_CUSTOMER_HOME",                              HOME_ADMIN_SUB_CUSTOMER_END.PAGE_DEFAULT,TRUE);                                 //http://a.com/기본폴더/admin/img/index.php

define("HOME_HERO_SUB_CUSTOMER",                                    HERO_END."sub_customer",TRUE);                                                  //http://a.com/기본폴더/hero/img
define("HOME_HERO_SUB_CUSTOMER_END",                                HERO_END."sub_customer".SLASH,TRUE);                                            //http://a.com/기본폴더/hero/img/
define("HOME_HERO_SUB_CUSTOMER_HOME",                               HOME_HERO_SUB_CUSTOMER_END.PAGE_DEFAULT,TRUE);                                  //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_END)
####################################################################################################################################################
define("PATH_SUB_CUSTOMER",                                         PATH_END."sub_customer",TRUE);                                                  //http://a.com/현재폴더/img
define("PATH_SUB_CUSTOMER_END",                                     PATH_END."sub_customer".SLASH,TRUE);                                            //http://a.com/현재폴더/img/
define("PATH_SUB_CUSTOMER_HOME",                                    PATH_SUB_CUSTOMER_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/현재폴더/img/index.php

define("PATH_ADMIN_SUB_CUSTOMER",                                   PATH_ADMIN_END."sub_customer",TRUE);                                            //http://a.com/현재폴더/admin/img
define("PATH_ADMIN_SUB_CUSTOMER_END",                               PATH_ADMIN_END."sub_customer".SLASH,TRUE);                                      //http://a.com/현재폴더/admin/img/
define("PATH_ADMIN_SUB_CUSTOMER_HOME",                              PATH_ADMIN_SUB_CUSTOMER_END.PAGE_DEFAULT,TRUE);                                 //http://a.com/현재폴더/admin/img/index.php

define("PATH_HERO_SUB_CUSTOMER",                                    PATH_HERO_END."sub_customer",TRUE);                                             //http://a.com/현재폴더/hero/img
define("PATH_HERO_SUB_CUSTOMER_END",                                PATH_HERO_END."sub_customer".SLASH,TRUE);                                       //http://a.com/현재폴더/hero/img/
define("PATH_HERO_SUB_CUSTOMER_HOME",                               PATH_HERO_SUB_CUSTOMER_END.PAGE_DEFAULT,TRUE);                                  //http://a.com/현재폴더/hero/img/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define("DOMAIN_SUB_CUSTOMER_INC",                                   DOMAIN_INC_END."sub_customer",TRUE);                                            //C:/APM_Setup/htdocs/img
define("DOMAIN_SUB_CUSTOMER_INC_END",                               DOMAIN_INC_END."sub_customer".SLASH,TRUE);                                      //C:/APM_Setup/htdocs/img/
define("DOMAIN_SUB_CUSTOMER_INC_HOME",                              DOMAIN_SUB_CUSTOMER_INC_END.PAGE_DEFAULT,TRUE);                                 //C:/APM_Setup/htdocs/img/index.php

define("DOMAIN_ADMIN_SUB_CUSTOMER_INC",                             DOMAIN_ADMIN_INC_END."sub_customer",TRUE);                                      //C:/APM_Setup/htdocs/admin/img
define("DOMAIN_ADMIN_SUB_CUSTOMER_INC_END",                         DOMAIN_ADMIN_INC_END."sub_customer".SLASH,TRUE);                                //C:/APM_Setup/htdocs/admin/img/
define("DOMAIN_ADMIN_SUB_CUSTOMER_INC_HOME",                        DOMAIN_ADMIN_SUB_CUSTOMER_INC_END.PAGE_DEFAULT,TRUE);                           //C:/APM_Setup/htdocs/admin/img/index.php

define("DOMAIN_HERO_SUB_CUSTOMER_INC",                              DOMAIN_HERO_INC_END."sub_customer",TRUE);                                       //C:/APM_Setup/htdocs/hero/img
define("DOMAIN_HERO_SUB_CUSTOMER_INC_END",                          DOMAIN_HERO_INC_END."sub_customer".SLASH,TRUE);                                 //C:/APM_Setup/htdocs/hero/img/
define("DOMAIN_HERO_SUB_CUSTOMER_INC_HOME",                         DOMAIN_HERO_SUB_CUSTOMER_INC_END.PAGE_DEFAULT,TRUE);                            //C:/APM_Setup/htdocs/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_INC_END)
####################################################################################################################################################
define("SUB_CUSTOMER_INC",                                          HOME_INC_END."sub_customer",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/img
define("SUB_CUSTOMER_INC_END",                                      HOME_INC_END."sub_customer".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/img/
define("SUB_CUSTOMER_INC_HOME",                                     SUB_CUSTOMER_INC_END.PAGE_DEFAULT,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ADMIN_SUB_CUSTOMER_INC",                                    ADMIN_INC_END."sub_customer",TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ADMIN_SUB_CUSTOMER_INC_END",                                ADMIN_INC_END."sub_customer".SLASH,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ADMIN_SUB_CUSTOMER_INC_HOME",                               ADMIN_SUB_CUSTOMER_INC_END.PAGE_DEFAULT,TRUE);                                  //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HERO_SUB_CUSTOMER_INC",                                     HERO_INC_END."sub_customer",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HERO_SUB_CUSTOMER_INC_END",                                 HERO_INC_END."sub_customer".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HERO_SUB_CUSTOMER_INC_HOME",                                HERO_SUB_CUSTOMER_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_SUB_CUSTOMER_INC",                                     ROOT_INC_END."sub_customer",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/img
define("ROOT_SUB_CUSTOMER_INC_END",                                 ROOT_INC_END."sub_customer".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/img/
define("ROOT_SUB_CUSTOMER_INC_HOME",                                ROOT_SUB_CUSTOMER_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ROOT_ADMIN_SUB_CUSTOMER_INC",                               ADMIN_INC_END."sub_customer",TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ROOT_ADMIN_SUB_CUSTOMER_INC_END",                           ADMIN_INC_END."sub_customer".SLASH,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ROOT_ADMIN_SUB_CUSTOMER_INC_HOME",                          ROOT_ADMIN_SUB_CUSTOMER_INC_END.PAGE_DEFAULT,TRUE);                             //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("ROOT_HERO_SUB_CUSTOMER_INC",                                HERO_INC_END."sub_customer",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/hero/img
define("ROOT_HERO_SUB_CUSTOMER_INC_END",                            HERO_INC_END."sub_customer".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("ROOT_HERO_SUB_CUSTOMER_INC_HOME",                           ROOT_HERO_SUB_CUSTOMER_INC_END.PAGE_DEFAULT,TRUE);                              //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_SUB_CUSTOMER_INC",                                     HOME_INC_END."sub_customer",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/img
define("HOME_SUB_CUSTOMER_INC_END",                                 HOME_INC_END."sub_customer".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/img/
define("HOME_SUB_CUSTOMER_INC_HOME",                                HOME_SUB_CUSTOMER_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("HOME_ADMIN_SUB_CUSTOMER_INC",                               ADMIN_INC_END."sub_customer",TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/admin/img
define("HOME_ADMIN_SUB_CUSTOMER_INC_END",                           ADMIN_INC_END."sub_customer".SLASH,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("HOME_ADMIN_SUB_CUSTOMER_INC_HOME",                          HOME_ADMIN_SUB_CUSTOMER_INC_END.PAGE_DEFAULT,TRUE);                             //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HOME_HERO_SUB_CUSTOMER_INC",                                HERO_INC_END."sub_customer",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HOME_HERO_SUB_CUSTOMER_INC_END",                            HERO_INC_END."sub_customer".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HOME_HERO_SUB_CUSTOMER_INC_HOME",                           HOME_HERO_SUB_CUSTOMER_INC_END.PAGE_DEFAULT,TRUE);                              //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_INC_END)
####################################################################################################################################################
define("PATH_SUB_CUSTOMER_INC",                                     PATH_INC_END."sub_customer",TRUE);                                              //C:/APM_Setup/htdocs/현재폴더/img
define("PATH_SUB_CUSTOMER_INC_END",                                 PATH_INC_END."sub_customer".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/현재폴더/img/
define("PATH_SUB_CUSTOMER_INC_HOME",                                PATH_SUB_CUSTOMER_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/현재폴더/img/index.php

define("PATH_ADMIN_SUB_CUSTOMER_INC",                               PATH_ADMIN_INC_END."sub_customer",TRUE);                                        //C:/APM_Setup/htdocs/현재폴더/admin/img
define("PATH_ADMIN_SUB_CUSTOMER_INC_END",                           PATH_ADMIN_INC_END."sub_customer".SLASH,TRUE);                                  //C:/APM_Setup/htdocs/현재폴더/admin/img/
define("PATH_ADMIN_SUB_CUSTOMER_INC_HOME",                          PATH_ADMIN_SUB_CUSTOMER_INC_END.PAGE_DEFAULT,TRUE);                             //C:/APM_Setup/htdocs/현재폴더/admin/img/index.php

define("PATH_HERO_SUB_CUSTOMER_INC",                                PATH_HERO_INC_END."sub_customer",TRUE);                                         //C:/APM_Setup/htdocs/현재폴더/hero/img
define("PATH_HERO_SUB_CUSTOMER_INC_END",                            PATH_HERO_INC_END."sub_customer".SLASH,TRUE);                                   //C:/APM_Setup/htdocs/현재폴더/hero/img/
define("PATH_HERO_SUB_CUSTOMER_INC_HOME",                           PATH_HERO_SUB_CUSTOMER_INC_END.PAGE_DEFAULT,TRUE);                              //C:/APM_Setup/htdocs/현재폴더/hero/img/index.php
####################################################################################################################################################
####################################################################################################################################################
define("DOMAIN_SUB_GUIDE",                                          DOMAIN_END."sub_guide",TRUE);                                                   //http://a.com/img
define("DOMAIN_SUB_GUIDE_END",                                      DOMAIN_END."sub_guide".SLASH,TRUE);                                             //http://a.com/img/
define("DOMAIN_SUB_GUIDE_HOME",                                     DOMAIN_SUB_GUIDE_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/img/index.php

define("DOMAIN_ADMIN_SUB_GUIDE",                                    DOMAIN_ADMIN_END."sub_guide",TRUE);                                             //http://a.com/admin/img
define("DOMAIN_ADMIN_SUB_GUIDE_END",                                DOMAIN_ADMIN_END."sub_guide".SLASH,TRUE);                                       //http://a.com/admin/img/
define("DOMAIN_ADMIN_SUB_GUIDE_HOME",                               DOMAIN_ADMIN_SUB_GUIDE_END.PAGE_DEFAULT,TRUE);                                  //http://a.com/admin/img/index.php

define("DOMAIN_HERO_SUB_GUIDE",                                     DOMAIN_HERO_END."sub_guide",TRUE);                                              //http://a.com/hero/img
define("DOMAIN_HERO_SUB_GUIDE_END",                                 DOMAIN_HERO_END."sub_guide".SLASH,TRUE);                                        //http://a.com/hero/img/
define("DOMAIN_HERO_SUB_GUIDE_HOME",                                DOMAIN_HERO_SUB_GUIDE_END.PAGE_DEFAULT,TRUE);                                   //http://a.com/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_END)
####################################################################################################################################################
define("SUB_GUIDE",                                                 HOME_END."sub_guide",TRUE);                                                     //http://a.com/기본폴더/img
define("SUB_GUIDE_END",                                             HOME_END."sub_guide".SLASH,TRUE);                                               //http://a.com/기본폴더/img/
define("SUB_GUIDE_HOME",                                            SUB_GUIDE_END.PAGE_DEFAULT,TRUE);                                               //http://a.com/기본폴더/img/index.php

define("ADMIN_SUB_GUIDE",                                           ADMIN_END."sub_guide",TRUE);                                                    //http://a.com/기본폴더/admin/img
define("ADMIN_SUB_GUIDE_END",                                       ADMIN_END."sub_guide".SLASH,TRUE);                                              //http://a.com/기본폴더/admin/img/
define("ADMIN_SUB_GUIDE_HOME",                                      ADMIN_SUB_GUIDE_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/기본폴더/admin/img/index.php

define("HERO_SUB_GUIDE",                                            HERO_END."sub_guide",TRUE);                                                     //http://a.com/기본폴더/hero/img
define("HERO_SUB_GUIDE_END",                                        HERO_END."sub_guide".SLASH,TRUE);                                               //http://a.com/기본폴더/hero/img/
define("HERO_SUB_GUIDE_HOME",                                       HERO_SUB_GUIDE_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_SUB_GUIDE",                                            ROOT_END."sub_guide",TRUE);                                                     //http://a.com/기본폴더/img
define("ROOT_SUB_GUIDE_END",                                        ROOT_END."sub_guide".SLASH,TRUE);                                               //http://a.com/기본폴더/img/
define("ROOT_SUB_GUIDE_HOME",                                       ROOT_SUB_GUIDE_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/기본폴더/img/index.php

define("ROOT_ADMIN_SUB_GUIDE",                                      ADMIN_END."sub_guide",TRUE);                                                    //http://a.com/기본폴더/admin/img
define("ROOT_ADMIN_SUB_GUIDE_END",                                  ADMIN_END."sub_guide".SLASH,TRUE);                                              //http://a.com/기본폴더/admin/img/
define("ROOT_ADMIN_SUB_GUIDE_HOME",                                 ROOT_ADMIN_SUB_GUIDE_END.PAGE_DEFAULT,TRUE);                                    //http://a.com/기본폴더/admin/img/index.php

define("ROOT_HERO_SUB_GUIDE",                                       HERO_END."sub_guide",TRUE);                                                     //http://a.com/기본폴더/hero/img
define("ROOT_HERO_SUB_GUIDE_END",                                   HERO_END."sub_guide".SLASH,TRUE);                                               //http://a.com/기본폴더/hero/img/
define("ROOT_HERO_SUB_GUIDE_HOME",                                  ROOT_HERO_SUB_GUIDE_END.PAGE_DEFAULT,TRUE);                                     //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_SUB_GUIDE",                                            HOME_END."sub_guide",TRUE);                                                     //http://a.com/기본폴더/img
define("HOME_SUB_GUIDE_END",                                        HOME_END."sub_guide".SLASH,TRUE);                                               //http://a.com/기본폴더/img/
define("HOME_SUB_GUIDE_HOME",                                       HOME_SUB_GUIDE_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/기본폴더/img/index.php

define("HOME_ADMIN_SUB_GUIDE",                                      ADMIN_END."sub_guide",TRUE);                                                    //http://a.com/기본폴더/admin/img
define("HOME_ADMIN_SUB_GUIDE_END",                                  ADMIN_END."sub_guide".SLASH,TRUE);                                              //http://a.com/기본폴더/admin/img/
define("HOME_ADMIN_SUB_GUIDE_HOME",                                 HOME_ADMIN_SUB_GUIDE_END.PAGE_DEFAULT,TRUE);                                    //http://a.com/기본폴더/admin/img/index.php

define("HOME_HERO_SUB_GUIDE",                                       HERO_END."sub_guide",TRUE);                                                     //http://a.com/기본폴더/hero/img
define("HOME_HERO_SUB_GUIDE_END",                                   HERO_END."sub_guide".SLASH,TRUE);                                               //http://a.com/기본폴더/hero/img/
define("HOME_HERO_SUB_GUIDE_HOME",                                  HOME_HERO_SUB_GUIDE_END.PAGE_DEFAULT,TRUE);                                     //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_END)
####################################################################################################################################################
define("PATH_SUB_GUIDE",                                            PATH_END."sub_guide",TRUE);                                                     //http://a.com/현재폴더/img
define("PATH_SUB_GUIDE_END",                                        PATH_END."sub_guide".SLASH,TRUE);                                               //http://a.com/현재폴더/img/
define("PATH_SUB_GUIDE_HOME",                                       PATH_SUB_GUIDE_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/현재폴더/img/index.php

define("PATH_ADMIN_SUB_GUIDE",                                      PATH_ADMIN_END."sub_guide",TRUE);                                               //http://a.com/현재폴더/admin/img
define("PATH_ADMIN_SUB_GUIDE_END",                                  PATH_ADMIN_END."sub_guide".SLASH,TRUE);                                         //http://a.com/현재폴더/admin/img/
define("PATH_ADMIN_SUB_GUIDE_HOME",                                 PATH_ADMIN_SUB_GUIDE_END.PAGE_DEFAULT,TRUE);                                    //http://a.com/현재폴더/admin/img/index.php

define("PATH_HERO_SUB_GUIDE",                                       PATH_HERO_END."sub_guide",TRUE);                                                //http://a.com/현재폴더/hero/img
define("PATH_HERO_SUB_GUIDE_END",                                   PATH_HERO_END."sub_guide".SLASH,TRUE);                                          //http://a.com/현재폴더/hero/img/
define("PATH_HERO_SUB_GUIDE_HOME",                                  PATH_HERO_SUB_GUIDE_END.PAGE_DEFAULT,TRUE);                                     //http://a.com/현재폴더/hero/img/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define("DOMAIN_SUB_GUIDE_INC",                                      DOMAIN_INC_END."sub_guide",TRUE);                                               //C:/APM_Setup/htdocs/img
define("DOMAIN_SUB_GUIDE_INC_END",                                  DOMAIN_INC_END."sub_guide".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/img/
define("DOMAIN_SUB_GUIDE_INC_HOME",                                 DOMAIN_SUB_GUIDE_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/img/index.php

define("DOMAIN_ADMIN_SUB_GUIDE_INC",                                DOMAIN_ADMIN_INC_END."sub_guide",TRUE);                                         //C:/APM_Setup/htdocs/admin/img
define("DOMAIN_ADMIN_SUB_GUIDE_INC_END",                            DOMAIN_ADMIN_INC_END."sub_guide".SLASH,TRUE);                                   //C:/APM_Setup/htdocs/admin/img/
define("DOMAIN_ADMIN_SUB_GUIDE_INC_HOME",                           DOMAIN_ADMIN_SUB_GUIDE_INC_END.PAGE_DEFAULT,TRUE);                              //C:/APM_Setup/htdocs/admin/img/index.php

define("DOMAIN_HERO_SUB_GUIDE_INC",                                 DOMAIN_HERO_INC_END."sub_guide",TRUE);                                          //C:/APM_Setup/htdocs/hero/img
define("DOMAIN_HERO_SUB_GUIDE_INC_END",                             DOMAIN_HERO_INC_END."sub_guide".SLASH,TRUE);                                    //C:/APM_Setup/htdocs/hero/img/
define("DOMAIN_HERO_SUB_GUIDE_INC_HOME",                            DOMAIN_HERO_SUB_GUIDE_INC_END.PAGE_DEFAULT,TRUE);                               //C:/APM_Setup/htdocs/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_INC_END)
####################################################################################################################################################
define("SUB_GUIDE_INC",                                             HOME_INC_END."sub_guide",TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/img
define("SUB_GUIDE_INC_END",                                         HOME_INC_END."sub_guide".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/img/
define("SUB_GUIDE_INC_HOME",                                        SUB_GUIDE_INC_END.PAGE_DEFAULT,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ADMIN_SUB_GUIDE_INC",                                       ADMIN_INC_END."sub_guide",TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ADMIN_SUB_GUIDE_INC_END",                                   ADMIN_INC_END."sub_guide".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ADMIN_SUB_GUIDE_INC_HOME",                                  ADMIN_SUB_GUIDE_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HERO_SUB_GUIDE_INC",                                        HERO_INC_END."sub_guide",TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HERO_SUB_GUIDE_INC_END",                                    HERO_INC_END."sub_guide".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HERO_SUB_GUIDE_INC_HOME",                                   HERO_SUB_GUIDE_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_SUB_GUIDE_INC",                                        ROOT_INC_END."sub_guide",TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/img
define("ROOT_SUB_GUIDE_INC_END",                                    ROOT_INC_END."sub_guide".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/img/
define("ROOT_SUB_GUIDE_INC_HOME",                                   ROOT_SUB_GUIDE_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ROOT_ADMIN_SUB_GUIDE_INC",                                  ADMIN_INC_END."sub_guide",TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ROOT_ADMIN_SUB_GUIDE_INC_END",                              ADMIN_INC_END."sub_guide".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ROOT_ADMIN_SUB_GUIDE_INC_HOME",                             ROOT_ADMIN_SUB_GUIDE_INC_END.PAGE_DEFAULT,TRUE);                                //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("ROOT_HERO_SUB_GUIDE_INC",                                   HERO_INC_END."sub_guide",TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/hero/img
define("ROOT_HERO_SUB_GUIDE_INC_END",                               HERO_INC_END."sub_guide".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("ROOT_HERO_SUB_GUIDE_INC_HOME",                              ROOT_HERO_SUB_GUIDE_INC_END.PAGE_DEFAULT,TRUE);                                 //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_SUB_GUIDE_INC",                                        HOME_INC_END."sub_guide",TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/img
define("HOME_SUB_GUIDE_INC_END",                                    HOME_INC_END."sub_guide".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/img/
define("HOME_SUB_GUIDE_INC_HOME",                                   HOME_SUB_GUIDE_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("HOME_ADMIN_SUB_GUIDE_INC",                                  ADMIN_INC_END."sub_guide",TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/admin/img
define("HOME_ADMIN_SUB_GUIDE_INC_END",                              ADMIN_INC_END."sub_guide".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("HOME_ADMIN_SUB_GUIDE_INC_HOME",                             HOME_ADMIN_SUB_GUIDE_INC_END.PAGE_DEFAULT,TRUE);                                //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HOME_HERO_SUB_GUIDE_INC",                                   HERO_INC_END."sub_guide",TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HOME_HERO_SUB_GUIDE_INC_END",                               HERO_INC_END."sub_guide".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HOME_HERO_SUB_GUIDE_INC_HOME",                              HOME_HERO_SUB_GUIDE_INC_END.PAGE_DEFAULT,TRUE);                                 //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_INC_END)
####################################################################################################################################################
define("PATH_SUB_GUIDE_INC",                                        PATH_INC_END."sub_guide",TRUE);                                                 //C:/APM_Setup/htdocs/현재폴더/img
define("PATH_SUB_GUIDE_INC_END",                                    PATH_INC_END."sub_guide".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/현재폴더/img/
define("PATH_SUB_GUIDE_INC_HOME",                                   PATH_SUB_GUIDE_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/현재폴더/img/index.php

define("PATH_ADMIN_SUB_GUIDE_INC",                                  PATH_ADMIN_INC_END."sub_guide",TRUE);                                           //C:/APM_Setup/htdocs/현재폴더/admin/img
define("PATH_ADMIN_SUB_GUIDE_INC_END",                              PATH_ADMIN_INC_END."sub_guide".SLASH,TRUE);                                     //C:/APM_Setup/htdocs/현재폴더/admin/img/
define("PATH_ADMIN_SUB_GUIDE_INC_HOME",                             PATH_ADMIN_SUB_GUIDE_INC_END.PAGE_DEFAULT,TRUE);                                //C:/APM_Setup/htdocs/현재폴더/admin/img/index.php

define("PATH_HERO_SUB_GUIDE_INC",                                   PATH_HERO_INC_END."sub_guide",TRUE);                                            //C:/APM_Setup/htdocs/현재폴더/hero/img
define("PATH_HERO_SUB_GUIDE_INC_END",                               PATH_HERO_INC_END."sub_guide".SLASH,TRUE);                                      //C:/APM_Setup/htdocs/현재폴더/hero/img/
define("PATH_HERO_SUB_GUIDE_INC_HOME",                              PATH_HERO_SUB_GUIDE_INC_END.PAGE_DEFAULT,TRUE);                                 //C:/APM_Setup/htdocs/현재폴더/hero/img/index.php
####################################################################################################################################################
####################################################################################################################################################
define("DOMAIN_SUB_MEMBER",                                         DOMAIN_END."sub_member",TRUE);                                                  //http://a.com/img
define("DOMAIN_SUB_MEMBER_END",                                     DOMAIN_END."sub_member".SLASH,TRUE);                                            //http://a.com/img/
define("DOMAIN_SUB_MEMBER_HOME",                                    DOMAIN_SUB_MEMBER_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/img/index.php

define("DOMAIN_ADMIN_SUB_MEMBER",                                   DOMAIN_ADMIN_END."sub_member",TRUE);                                            //http://a.com/admin/img
define("DOMAIN_ADMIN_SUB_MEMBER_END",                               DOMAIN_ADMIN_END."sub_member".SLASH,TRUE);                                      //http://a.com/admin/img/
define("DOMAIN_ADMIN_SUB_MEMBER_HOME",                              DOMAIN_ADMIN_SUB_MEMBER_END.PAGE_DEFAULT,TRUE);                                 //http://a.com/admin/img/index.php

define("DOMAIN_HERO_SUB_MEMBER",                                    DOMAIN_HERO_END."sub_member",TRUE);                                             //http://a.com/hero/img
define("DOMAIN_HERO_SUB_MEMBER_END",                                DOMAIN_HERO_END."sub_member".SLASH,TRUE);                                       //http://a.com/hero/img/
define("DOMAIN_HERO_SUB_MEMBER_HOME",                               DOMAIN_HERO_SUB_MEMBER_END.PAGE_DEFAULT,TRUE);                                  //http://a.com/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_END)
####################################################################################################################################################
define("SUB_MEMBER",                                                HOME_END."sub_member",TRUE);                                                    //http://a.com/기본폴더/img
define("SUB_MEMBER_END",                                            HOME_END."sub_member".SLASH,TRUE);                                              //http://a.com/기본폴더/img/
define("SUB_MEMBER_HOME",                                           SUB_MEMBER_END.PAGE_DEFAULT,TRUE);                                              //http://a.com/기본폴더/img/index.php

define("ADMIN_SUB_MEMBER",                                          ADMIN_END."sub_member",TRUE);                                                   //http://a.com/기본폴더/admin/img
define("ADMIN_SUB_MEMBER_END",                                      ADMIN_END."sub_member".SLASH,TRUE);                                             //http://a.com/기본폴더/admin/img/
define("ADMIN_SUB_MEMBER_HOME",                                     ADMIN_SUB_MEMBER_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/기본폴더/admin/img/index.php

define("HERO_SUB_MEMBER",                                           HERO_END."sub_member",TRUE);                                                    //http://a.com/기본폴더/hero/img
define("HERO_SUB_MEMBER_END",                                       HERO_END."sub_member".SLASH,TRUE);                                              //http://a.com/기본폴더/hero/img/
define("HERO_SUB_MEMBER_HOME",                                      HERO_SUB_MEMBER_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_SUB_MEMBER",                                           ROOT_END."sub_member",TRUE);                                                    //http://a.com/기본폴더/img
define("ROOT_SUB_MEMBER_END",                                       ROOT_END."sub_member".SLASH,TRUE);                                              //http://a.com/기본폴더/img/
define("ROOT_SUB_MEMBER_HOME",                                      ROOT_SUB_MEMBER_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/기본폴더/img/index.php

define("ROOT_ADMIN_SUB_MEMBER",                                     ADMIN_END."sub_member",TRUE);                                                   //http://a.com/기본폴더/admin/img
define("ROOT_ADMIN_SUB_MEMBER_END",                                 ADMIN_END."sub_member".SLASH,TRUE);                                             //http://a.com/기본폴더/admin/img/
define("ROOT_ADMIN_SUB_MEMBER_HOME",                                ROOT_ADMIN_SUB_MEMBER_END.PAGE_DEFAULT,TRUE);                                   //http://a.com/기본폴더/admin/img/index.php

define("ROOT_HERO_SUB_MEMBER",                                      HERO_END."sub_member",TRUE);                                                    //http://a.com/기본폴더/hero/img
define("ROOT_HERO_SUB_MEMBER_END",                                  HERO_END."sub_member".SLASH,TRUE);                                              //http://a.com/기본폴더/hero/img/
define("ROOT_HERO_SUB_MEMBER_HOME",                                 ROOT_HERO_SUB_MEMBER_END.PAGE_DEFAULT,TRUE);                                    //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_SUB_MEMBER",                                           HOME_END."sub_member",TRUE);                                                    //http://a.com/기본폴더/img
define("HOME_SUB_MEMBER_END",                                       HOME_END."sub_member".SLASH,TRUE);                                              //http://a.com/기본폴더/img/
define("HOME_SUB_MEMBER_HOME",                                      HOME_SUB_MEMBER_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/기본폴더/img/index.php

define("HOME_ADMIN_SUB_MEMBER",                                     ADMIN_END."sub_member",TRUE);                                                   //http://a.com/기본폴더/admin/img
define("HOME_ADMIN_SUB_MEMBER_END",                                 ADMIN_END."sub_member".SLASH,TRUE);                                             //http://a.com/기본폴더/admin/img/
define("HOME_ADMIN_SUB_MEMBER_HOME",                                HOME_ADMIN_SUB_MEMBER_END.PAGE_DEFAULT,TRUE);                                   //http://a.com/기본폴더/admin/img/index.php

define("HOME_HERO_SUB_MEMBER",                                      HERO_END."sub_member",TRUE);                                                    //http://a.com/기본폴더/hero/img
define("HOME_HERO_SUB_MEMBER_END",                                  HERO_END."sub_member".SLASH,TRUE);                                              //http://a.com/기본폴더/hero/img/
define("HOME_HERO_SUB_MEMBER_HOME",                                 HOME_HERO_SUB_MEMBER_END.PAGE_DEFAULT,TRUE);                                    //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_END)
####################################################################################################################################################
define("PATH_SUB_MEMBER",                                           PATH_END."sub_member",TRUE);                                                    //http://a.com/현재폴더/img
define("PATH_SUB_MEMBER_END",                                       PATH_END."sub_member".SLASH,TRUE);                                              //http://a.com/현재폴더/img/
define("PATH_SUB_MEMBER_HOME",                                      PATH_SUB_MEMBER_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/현재폴더/img/index.php

define("PATH_ADMIN_SUB_MEMBER",                                     PATH_ADMIN_END."sub_member",TRUE);                                              //http://a.com/현재폴더/admin/img
define("PATH_ADMIN_SUB_MEMBER_END",                                 PATH_ADMIN_END."sub_member".SLASH,TRUE);                                        //http://a.com/현재폴더/admin/img/
define("PATH_ADMIN_SUB_MEMBER_HOME",                                PATH_ADMIN_SUB_MEMBER_END.PAGE_DEFAULT,TRUE);                                   //http://a.com/현재폴더/admin/img/index.php

define("PATH_HERO_SUB_MEMBER",                                      PATH_HERO_END."sub_member",TRUE);                                               //http://a.com/현재폴더/hero/img
define("PATH_HERO_SUB_MEMBER_END",                                  PATH_HERO_END."sub_member".SLASH,TRUE);                                         //http://a.com/현재폴더/hero/img/
define("PATH_HERO_SUB_MEMBER_HOME",                                 PATH_HERO_SUB_MEMBER_END.PAGE_DEFAULT,TRUE);                                    //http://a.com/현재폴더/hero/img/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define("DOMAIN_SUB_MEMBER_INC",                                     DOMAIN_INC_END."sub_member",TRUE);                                              //C:/APM_Setup/htdocs/img
define("DOMAIN_SUB_MEMBER_INC_END",                                 DOMAIN_INC_END."sub_member".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/img/
define("DOMAIN_SUB_MEMBER_INC_HOME",                                DOMAIN_SUB_MEMBER_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/img/index.php

define("DOMAIN_ADMIN_SUB_MEMBER_INC",                               DOMAIN_ADMIN_INC_END."sub_member",TRUE);                                        //C:/APM_Setup/htdocs/admin/img
define("DOMAIN_ADMIN_SUB_MEMBER_INC_END",                           DOMAIN_ADMIN_INC_END."sub_member".SLASH,TRUE);                                  //C:/APM_Setup/htdocs/admin/img/
define("DOMAIN_ADMIN_SUB_MEMBER_INC_HOME",                          DOMAIN_ADMIN_SUB_MEMBER_INC_END.PAGE_DEFAULT,TRUE);                             //C:/APM_Setup/htdocs/admin/img/index.php

define("DOMAIN_HERO_SUB_MEMBER_INC",                                DOMAIN_HERO_INC_END."sub_member",TRUE);                                         //C:/APM_Setup/htdocs/hero/img
define("DOMAIN_HERO_SUB_MEMBER_INC_END",                            DOMAIN_HERO_INC_END."sub_member".SLASH,TRUE);                                   //C:/APM_Setup/htdocs/hero/img/
define("DOMAIN_HERO_SUB_MEMBER_INC_HOME",                           DOMAIN_HERO_SUB_MEMBER_INC_END.PAGE_DEFAULT,TRUE);                              //C:/APM_Setup/htdocs/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_INC_END)
####################################################################################################################################################
define("SUB_MEMBER_INC",                                            HOME_INC_END."sub_member",TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/img
define("SUB_MEMBER_INC_END",                                        HOME_INC_END."sub_member".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/img/
define("SUB_MEMBER_INC_HOME",                                       SUB_MEMBER_INC_END.PAGE_DEFAULT,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ADMIN_SUB_MEMBER_INC",                                      ADMIN_INC_END."sub_member",TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ADMIN_SUB_MEMBER_INC_END",                                  ADMIN_INC_END."sub_member".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ADMIN_SUB_MEMBER_INC_HOME",                                 ADMIN_SUB_MEMBER_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HERO_SUB_MEMBER_INC",                                       HERO_INC_END."sub_member",TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HERO_SUB_MEMBER_INC_END",                                   HERO_INC_END."sub_member".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HERO_SUB_MEMBER_INC_HOME",                                  HERO_SUB_MEMBER_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_SUB_MEMBER_INC",                                       ROOT_INC_END."sub_member",TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/img
define("ROOT_SUB_MEMBER_INC_END",                                   ROOT_INC_END."sub_member".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/img/
define("ROOT_SUB_MEMBER_INC_HOME",                                  ROOT_SUB_MEMBER_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ROOT_ADMIN_SUB_MEMBER_INC",                                 ADMIN_INC_END."sub_member",TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ROOT_ADMIN_SUB_MEMBER_INC_END",                             ADMIN_INC_END."sub_member".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ROOT_ADMIN_SUB_MEMBER_INC_HOME",                            ROOT_ADMIN_SUB_MEMBER_INC_END.PAGE_DEFAULT,TRUE);                               //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("ROOT_HERO_SUB_MEMBER_INC",                                  HERO_INC_END."sub_member",TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/hero/img
define("ROOT_HERO_SUB_MEMBER_INC_END",                              HERO_INC_END."sub_member".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("ROOT_HERO_SUB_MEMBER_INC_HOME",                             ROOT_HERO_SUB_MEMBER_INC_END.PAGE_DEFAULT,TRUE);                                //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_SUB_MEMBER_INC",                                       HOME_INC_END."sub_member",TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/img
define("HOME_SUB_MEMBER_INC_END",                                   HOME_INC_END."sub_member".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/img/
define("HOME_SUB_MEMBER_INC_HOME",                                  HOME_SUB_MEMBER_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("HOME_ADMIN_SUB_MEMBER_INC",                                 ADMIN_INC_END."sub_member",TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/admin/img
define("HOME_ADMIN_SUB_MEMBER_INC_END",                             ADMIN_INC_END."sub_member".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("HOME_ADMIN_SUB_MEMBER_INC_HOME",                            HOME_ADMIN_SUB_MEMBER_INC_END.PAGE_DEFAULT,TRUE);                               //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HOME_HERO_SUB_MEMBER_INC",                                  HERO_INC_END."sub_member",TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HOME_HERO_SUB_MEMBER_INC_END",                              HERO_INC_END."sub_member".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HOME_HERO_SUB_MEMBER_INC_HOME",                             HOME_HERO_SUB_MEMBER_INC_END.PAGE_DEFAULT,TRUE);                                //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_INC_END)
####################################################################################################################################################
define("PATH_SUB_MEMBER_INC",                                       PATH_INC_END."sub_member",TRUE);                                                //C:/APM_Setup/htdocs/현재폴더/img
define("PATH_SUB_MEMBER_INC_END",                                   PATH_INC_END."sub_member".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/현재폴더/img/
define("PATH_SUB_MEMBER_INC_HOME",                                  PATH_SUB_MEMBER_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/현재폴더/img/index.php

define("PATH_ADMIN_SUB_MEMBER_INC",                                 PATH_ADMIN_INC_END."sub_member",TRUE);                                          //C:/APM_Setup/htdocs/현재폴더/admin/img
define("PATH_ADMIN_SUB_MEMBER_INC_END",                             PATH_ADMIN_INC_END."sub_member".SLASH,TRUE);                                    //C:/APM_Setup/htdocs/현재폴더/admin/img/
define("PATH_ADMIN_SUB_MEMBER_INC_HOME",                            PATH_ADMIN_SUB_MEMBER_INC_END.PAGE_DEFAULT,TRUE);                               //C:/APM_Setup/htdocs/현재폴더/admin/img/index.php

define("PATH_HERO_SUB_MEMBER_INC",                                  PATH_HERO_INC_END."sub_member",TRUE);                                           //C:/APM_Setup/htdocs/현재폴더/hero/img
define("PATH_HERO_SUB_MEMBER_INC_END",                              PATH_HERO_INC_END."sub_member".SLASH,TRUE);                                     //C:/APM_Setup/htdocs/현재폴더/hero/img/
define("PATH_HERO_SUB_MEMBER_INC_HOME",                             PATH_HERO_SUB_MEMBER_INC_END.PAGE_DEFAULT,TRUE);                                //C:/APM_Setup/htdocs/현재폴더/hero/img/index.php
####################################################################################################################################################
####################################################################################################################################################
define("DOMAIN_SUB_MISSION",                                        DOMAIN_END."sub_mission",TRUE);                                                 //http://a.com/img
define("DOMAIN_SUB_MISSION_END",                                    DOMAIN_END."sub_mission".SLASH,TRUE);                                           //http://a.com/img/
define("DOMAIN_SUB_MISSION_HOME",                                   DOMAIN_SUB_MISSION_END.PAGE_DEFAULT,TRUE);                                      //http://a.com/img/index.php

define("DOMAIN_ADMIN_SUB_MISSION",                                  DOMAIN_ADMIN_END."sub_mission",TRUE);                                           //http://a.com/admin/img
define("DOMAIN_ADMIN_SUB_MISSION_END",                              DOMAIN_ADMIN_END."sub_mission".SLASH,TRUE);                                     //http://a.com/admin/img/
define("DOMAIN_ADMIN_SUB_MISSION_HOME",                             DOMAIN_ADMIN_SUB_MISSION_END.PAGE_DEFAULT,TRUE);                                //http://a.com/admin/img/index.php

define("DOMAIN_HERO_SUB_MISSION",                                   DOMAIN_HERO_END."sub_mission",TRUE);                                            //http://a.com/hero/img
define("DOMAIN_HERO_SUB_MISSION_END",                               DOMAIN_HERO_END."sub_mission".SLASH,TRUE);                                      //http://a.com/hero/img/
define("DOMAIN_HERO_SUB_MISSION_HOME",                              DOMAIN_HERO_SUB_MISSION_END.PAGE_DEFAULT,TRUE);                                 //http://a.com/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_END)
####################################################################################################################################################
define("SUB_MISSION",                                               HOME_END."sub_mission",TRUE);                                                   //http://a.com/기본폴더/img
define("SUB_MISSION_END",                                           HOME_END."sub_mission".SLASH,TRUE);                                             //http://a.com/기본폴더/img/
define("SUB_MISSION_HOME",                                          SUB_MISSION_END.PAGE_DEFAULT,TRUE);                                             //http://a.com/기본폴더/img/index.php

define("ADMIN_SUB_MISSION",                                         ADMIN_END."sub_mission",TRUE);                                                  //http://a.com/기본폴더/admin/img
define("ADMIN_SUB_MISSION_END",                                     ADMIN_END."sub_mission".SLASH,TRUE);                                            //http://a.com/기본폴더/admin/img/
define("ADMIN_SUB_MISSION_HOME",                                    ADMIN_SUB_MISSION_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/기본폴더/admin/img/index.php

define("HERO_SUB_MISSION",                                          HERO_END."sub_mission",TRUE);                                                   //http://a.com/기본폴더/hero/img
define("HERO_SUB_MISSION_END",                                      HERO_END."sub_mission".SLASH,TRUE);                                             //http://a.com/기본폴더/hero/img/
define("HERO_SUB_MISSION_HOME",                                     HERO_SUB_MISSION_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_SUB_MISSION",                                          ROOT_END."sub_mission",TRUE);                                                   //http://a.com/기본폴더/img
define("ROOT_SUB_MISSION_END",                                      ROOT_END."sub_mission".SLASH,TRUE);                                             //http://a.com/기본폴더/img/
define("ROOT_SUB_MISSION_HOME",                                     ROOT_SUB_MISSION_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/기본폴더/img/index.php

define("ROOT_ADMIN_SUB_MISSION",                                    ADMIN_END."sub_mission",TRUE);                                                  //http://a.com/기본폴더/admin/img
define("ROOT_ADMIN_SUB_MISSION_END",                                ADMIN_END."sub_mission".SLASH,TRUE);                                            //http://a.com/기본폴더/admin/img/
define("ROOT_ADMIN_SUB_MISSION_HOME",                               ROOT_ADMIN_SUB_MISSION_END.PAGE_DEFAULT,TRUE);                                  //http://a.com/기본폴더/admin/img/index.php

define("ROOT_HERO_SUB_MISSION",                                     HERO_END."sub_mission",TRUE);                                                   //http://a.com/기본폴더/hero/img
define("ROOT_HERO_SUB_MISSION_END",                                 HERO_END."sub_mission".SLASH,TRUE);                                             //http://a.com/기본폴더/hero/img/
define("ROOT_HERO_SUB_MISSION_HOME",                                ROOT_HERO_SUB_MISSION_END.PAGE_DEFAULT,TRUE);                                   //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_SUB_MISSION",                                          HOME_END."sub_mission",TRUE);                                                   //http://a.com/기본폴더/img
define("HOME_SUB_MISSION_END",                                      HOME_END."sub_mission".SLASH,TRUE);                                             //http://a.com/기본폴더/img/
define("HOME_SUB_MISSION_HOME",                                     HOME_SUB_MISSION_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/기본폴더/img/index.php

define("HOME_ADMIN_SUB_MISSION",                                    ADMIN_END."sub_mission",TRUE);                                                  //http://a.com/기본폴더/admin/img
define("HOME_ADMIN_SUB_MISSION_END",                                ADMIN_END."sub_mission".SLASH,TRUE);                                            //http://a.com/기본폴더/admin/img/
define("HOME_ADMIN_SUB_MISSION_HOME",                               HOME_ADMIN_SUB_MISSION_END.PAGE_DEFAULT,TRUE);                                  //http://a.com/기본폴더/admin/img/index.php

define("HOME_HERO_SUB_MISSION",                                     HERO_END."sub_mission",TRUE);                                                   //http://a.com/기본폴더/hero/img
define("HOME_HERO_SUB_MISSION_END",                                 HERO_END."sub_mission".SLASH,TRUE);                                             //http://a.com/기본폴더/hero/img/
define("HOME_HERO_SUB_MISSION_HOME",                                HOME_HERO_SUB_MISSION_END.PAGE_DEFAULT,TRUE);                                   //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_END)
####################################################################################################################################################
define("PATH_SUB_MISSION",                                          PATH_END."sub_mission",TRUE);                                                   //http://a.com/현재폴더/img
define("PATH_SUB_MISSION_END",                                      PATH_END."sub_mission".SLASH,TRUE);                                             //http://a.com/현재폴더/img/
define("PATH_SUB_MISSION_HOME",                                     PATH_SUB_MISSION_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/현재폴더/img/index.php

define("PATH_ADMIN_SUB_MISSION",                                    PATH_ADMIN_END."sub_mission",TRUE);                                             //http://a.com/현재폴더/admin/img
define("PATH_ADMIN_SUB_MISSION_END",                                PATH_ADMIN_END."sub_mission".SLASH,TRUE);                                       //http://a.com/현재폴더/admin/img/
define("PATH_ADMIN_SUB_MISSION_HOME",                               PATH_ADMIN_SUB_MISSION_END.PAGE_DEFAULT,TRUE);                                  //http://a.com/현재폴더/admin/img/index.php

define("PATH_HERO_SUB_MISSION",                                     PATH_HERO_END."sub_mission",TRUE);                                              //http://a.com/현재폴더/hero/img
define("PATH_HERO_SUB_MISSION_END",                                 PATH_HERO_END."sub_mission".SLASH,TRUE);                                        //http://a.com/현재폴더/hero/img/
define("PATH_HERO_SUB_MISSION_HOME",                                PATH_HERO_SUB_MISSION_END.PAGE_DEFAULT,TRUE);                                   //http://a.com/현재폴더/hero/img/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define("DOMAIN_SUB_MISSION_INC",                                    DOMAIN_INC_END."sub_mission",TRUE);                                             //C:/APM_Setup/htdocs/img
define("DOMAIN_SUB_MISSION_INC_END",                                DOMAIN_INC_END."sub_mission".SLASH,TRUE);                                       //C:/APM_Setup/htdocs/img/
define("DOMAIN_SUB_MISSION_INC_HOME",                               DOMAIN_SUB_MISSION_INC_END.PAGE_DEFAULT,TRUE);                                  //C:/APM_Setup/htdocs/img/index.php

define("DOMAIN_ADMIN_SUB_MISSION_INC",                              DOMAIN_ADMIN_INC_END."sub_mission",TRUE);                                       //C:/APM_Setup/htdocs/admin/img
define("DOMAIN_ADMIN_SUB_MISSION_INC_END",                          DOMAIN_ADMIN_INC_END."sub_mission".SLASH,TRUE);                                 //C:/APM_Setup/htdocs/admin/img/
define("DOMAIN_ADMIN_SUB_MISSION_INC_HOME",                         DOMAIN_ADMIN_SUB_MISSION_INC_END.PAGE_DEFAULT,TRUE);                            //C:/APM_Setup/htdocs/admin/img/index.php

define("DOMAIN_HERO_SUB_MISSION_INC",                               DOMAIN_HERO_INC_END."sub_mission",TRUE);                                        //C:/APM_Setup/htdocs/hero/img
define("DOMAIN_HERO_SUB_MISSION_INC_END",                           DOMAIN_HERO_INC_END."sub_mission".SLASH,TRUE);                                  //C:/APM_Setup/htdocs/hero/img/
define("DOMAIN_HERO_SUB_MISSION_INC_HOME",                          DOMAIN_HERO_SUB_MISSION_INC_END.PAGE_DEFAULT,TRUE);                             //C:/APM_Setup/htdocs/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_INC_END)
####################################################################################################################################################
define("SUB_MISSION_INC",                                           HOME_INC_END."sub_mission",TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/img
define("SUB_MISSION_INC_END",                                       HOME_INC_END."sub_mission".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/img/
define("SUB_MISSION_INC_HOME",                                      SUB_MISSION_INC_END.PAGE_DEFAULT,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ADMIN_SUB_MISSION_INC",                                     ADMIN_INC_END."sub_mission",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ADMIN_SUB_MISSION_INC_END",                                 ADMIN_INC_END."sub_mission".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ADMIN_SUB_MISSION_INC_HOME",                                ADMIN_SUB_MISSION_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HERO_SUB_MISSION_INC",                                      HERO_INC_END."sub_mission",TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HERO_SUB_MISSION_INC_END",                                  HERO_INC_END."sub_mission".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HERO_SUB_MISSION_INC_HOME",                                 HERO_SUB_MISSION_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_SUB_MISSION_INC",                                      ROOT_INC_END."sub_mission",TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/img
define("ROOT_SUB_MISSION_INC_END",                                  ROOT_INC_END."sub_mission".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/img/
define("ROOT_SUB_MISSION_INC_HOME",                                 ROOT_SUB_MISSION_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ROOT_ADMIN_SUB_MISSION_INC",                                ADMIN_INC_END."sub_mission",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ROOT_ADMIN_SUB_MISSION_INC_END",                            ADMIN_INC_END."sub_mission".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ROOT_ADMIN_SUB_MISSION_INC_HOME",                           ROOT_ADMIN_SUB_MISSION_INC_END.PAGE_DEFAULT,TRUE);                              //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("ROOT_HERO_SUB_MISSION_INC",                                 HERO_INC_END."sub_mission",TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/hero/img
define("ROOT_HERO_SUB_MISSION_INC_END",                             HERO_INC_END."sub_mission".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("ROOT_HERO_SUB_MISSION_INC_HOME",                            ROOT_HERO_SUB_MISSION_INC_END.PAGE_DEFAULT,TRUE);                               //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_SUB_MISSION_INC",                                      HOME_INC_END."sub_mission",TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/img
define("HOME_SUB_MISSION_INC_END",                                  HOME_INC_END."sub_mission".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/img/
define("HOME_SUB_MISSION_INC_HOME",                                 HOME_SUB_MISSION_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("HOME_ADMIN_SUB_MISSION_INC",                                ADMIN_INC_END."sub_mission",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/admin/img
define("HOME_ADMIN_SUB_MISSION_INC_END",                            ADMIN_INC_END."sub_mission".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("HOME_ADMIN_SUB_MISSION_INC_HOME",                           HOME_ADMIN_SUB_MISSION_INC_END.PAGE_DEFAULT,TRUE);                              //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HOME_HERO_SUB_MISSION_INC",                                 HERO_INC_END."sub_mission",TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HOME_HERO_SUB_MISSION_INC_END",                             HERO_INC_END."sub_mission".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HOME_HERO_SUB_MISSION_INC_HOME",                            HOME_HERO_SUB_MISSION_INC_END.PAGE_DEFAULT,TRUE);                               //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_INC_END)
####################################################################################################################################################
define("PATH_SUB_MISSION_INC",                                      PATH_INC_END."sub_mission",TRUE);                                               //C:/APM_Setup/htdocs/현재폴더/img
define("PATH_SUB_MISSION_INC_END",                                  PATH_INC_END."sub_mission".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/현재폴더/img/
define("PATH_SUB_MISSION_INC_HOME",                                 PATH_SUB_MISSION_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/현재폴더/img/index.php

define("PATH_ADMIN_SUB_MISSION_INC",                                PATH_ADMIN_INC_END."sub_mission",TRUE);                                         //C:/APM_Setup/htdocs/현재폴더/admin/img
define("PATH_ADMIN_SUB_MISSION_INC_END",                            PATH_ADMIN_INC_END."sub_mission".SLASH,TRUE);                                   //C:/APM_Setup/htdocs/현재폴더/admin/img/
define("PATH_ADMIN_SUB_MISSION_INC_HOME",                           PATH_ADMIN_SUB_MISSION_INC_END.PAGE_DEFAULT,TRUE);                              //C:/APM_Setup/htdocs/현재폴더/admin/img/index.php

define("PATH_HERO_SUB_MISSION_INC",                                 PATH_HERO_INC_END."sub_mission",TRUE);                                          //C:/APM_Setup/htdocs/현재폴더/hero/img
define("PATH_HERO_SUB_MISSION_INC_END",                             PATH_HERO_INC_END."sub_mission".SLASH,TRUE);                                    //C:/APM_Setup/htdocs/현재폴더/hero/img/
define("PATH_HERO_SUB_MISSION_INC_HOME",                            PATH_HERO_SUB_MISSION_INC_END.PAGE_DEFAULT,TRUE);                               //C:/APM_Setup/htdocs/현재폴더/hero/img/index.php
####################################################################################################################################################
####################################################################################################################################################
define("DOMAIN_SUB_PRODUCT",                                        DOMAIN_END."sub_product",TRUE);                                                 //http://a.com/img
define("DOMAIN_SUB_PRODUCT_END",                                    DOMAIN_END."sub_product".SLASH,TRUE);                                           //http://a.com/img/
define("DOMAIN_SUB_PRODUCT_HOME",                                   DOMAIN_SUB_PRODUCT_END.PAGE_DEFAULT,TRUE);                                      //http://a.com/img/index.php

define("DOMAIN_ADMIN_SUB_PRODUCT",                                  DOMAIN_ADMIN_END."sub_product",TRUE);                                           //http://a.com/admin/img
define("DOMAIN_ADMIN_SUB_PRODUCT_END",                              DOMAIN_ADMIN_END."sub_product".SLASH,TRUE);                                     //http://a.com/admin/img/
define("DOMAIN_ADMIN_SUB_PRODUCT_HOME",                             DOMAIN_ADMIN_SUB_PRODUCT_END.PAGE_DEFAULT,TRUE);                                //http://a.com/admin/img/index.php

define("DOMAIN_HERO_SUB_PRODUCT",                                   DOMAIN_HERO_END."sub_product",TRUE);                                            //http://a.com/hero/img
define("DOMAIN_HERO_SUB_PRODUCT_END",                               DOMAIN_HERO_END."sub_product".SLASH,TRUE);                                      //http://a.com/hero/img/
define("DOMAIN_HERO_SUB_PRODUCT_HOME",                              DOMAIN_HERO_SUB_PRODUCT_END.PAGE_DEFAULT,TRUE);                                 //http://a.com/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_END)
####################################################################################################################################################
define("SUB_PRODUCT",                                               HOME_END."sub_product",TRUE);                                                   //http://a.com/기본폴더/img
define("SUB_PRODUCT_END",                                           HOME_END."sub_product".SLASH,TRUE);                                             //http://a.com/기본폴더/img/
define("SUB_PRODUCT_HOME",                                          SUB_PRODUCT_END.PAGE_DEFAULT,TRUE);                                             //http://a.com/기본폴더/img/index.php

define("ADMIN_SUB_PRODUCT",                                         ADMIN_END."sub_product",TRUE);                                                  //http://a.com/기본폴더/admin/img
define("ADMIN_SUB_PRODUCT_END",                                     ADMIN_END."sub_product".SLASH,TRUE);                                            //http://a.com/기본폴더/admin/img/
define("ADMIN_SUB_PRODUCT_HOME",                                    ADMIN_SUB_PRODUCT_END.PAGE_DEFAULT,TRUE);                                       //http://a.com/기본폴더/admin/img/index.php

define("HERO_SUB_PRODUCT",                                          HERO_END."sub_product",TRUE);                                                   //http://a.com/기본폴더/hero/img
define("HERO_SUB_PRODUCT_END",                                      HERO_END."sub_product".SLASH,TRUE);                                             //http://a.com/기본폴더/hero/img/
define("HERO_SUB_PRODUCT_HOME",                                     HERO_SUB_PRODUCT_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_SUB_PRODUCT",                                          ROOT_END."sub_product",TRUE);                                                   //http://a.com/기본폴더/img
define("ROOT_SUB_PRODUCT_END",                                      ROOT_END."sub_product".SLASH,TRUE);                                             //http://a.com/기본폴더/img/
define("ROOT_SUB_PRODUCT_HOME",                                     ROOT_SUB_PRODUCT_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/기본폴더/img/index.php

define("ROOT_ADMIN_SUB_PRODUCT",                                    ADMIN_END."sub_product",TRUE);                                                  //http://a.com/기본폴더/admin/img
define("ROOT_ADMIN_SUB_PRODUCT_END",                                ADMIN_END."sub_product".SLASH,TRUE);                                            //http://a.com/기본폴더/admin/img/
define("ROOT_ADMIN_SUB_PRODUCT_HOME",                               ROOT_ADMIN_SUB_PRODUCT_END.PAGE_DEFAULT,TRUE);                                  //http://a.com/기본폴더/admin/img/index.php

define("ROOT_HERO_SUB_PRODUCT",                                     HERO_END."sub_product",TRUE);                                                   //http://a.com/기본폴더/hero/img
define("ROOT_HERO_SUB_PRODUCT_END",                                 HERO_END."sub_product".SLASH,TRUE);                                             //http://a.com/기본폴더/hero/img/
define("ROOT_HERO_SUB_PRODUCT_HOME",                                ROOT_HERO_SUB_PRODUCT_END.PAGE_DEFAULT,TRUE);                                   //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_SUB_PRODUCT",                                          HOME_END."sub_product",TRUE);                                                   //http://a.com/기본폴더/img
define("HOME_SUB_PRODUCT_END",                                      HOME_END."sub_product".SLASH,TRUE);                                             //http://a.com/기본폴더/img/
define("HOME_SUB_PRODUCT_HOME",                                     HOME_SUB_PRODUCT_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/기본폴더/img/index.php

define("HOME_ADMIN_SUB_PRODUCT",                                    ADMIN_END."sub_product",TRUE);                                                  //http://a.com/기본폴더/admin/img
define("HOME_ADMIN_SUB_PRODUCT_END",                                ADMIN_END."sub_product".SLASH,TRUE);                                            //http://a.com/기본폴더/admin/img/
define("HOME_ADMIN_SUB_PRODUCT_HOME",                               HOME_ADMIN_SUB_PRODUCT_END.PAGE_DEFAULT,TRUE);                                  //http://a.com/기본폴더/admin/img/index.php

define("HOME_HERO_SUB_PRODUCT",                                     HERO_END."sub_product",TRUE);                                                   //http://a.com/기본폴더/hero/img
define("HOME_HERO_SUB_PRODUCT_END",                                 HERO_END."sub_product".SLASH,TRUE);                                             //http://a.com/기본폴더/hero/img/
define("HOME_HERO_SUB_PRODUCT_HOME",                                HOME_HERO_SUB_PRODUCT_END.PAGE_DEFAULT,TRUE);                                   //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_END)
####################################################################################################################################################
define("PATH_SUB_PRODUCT",                                          PATH_END."sub_product",TRUE);                                                   //http://a.com/현재폴더/img
define("PATH_SUB_PRODUCT_END",                                      PATH_END."sub_product".SLASH,TRUE);                                             //http://a.com/현재폴더/img/
define("PATH_SUB_PRODUCT_HOME",                                     PATH_SUB_PRODUCT_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/현재폴더/img/index.php

define("PATH_ADMIN_SUB_PRODUCT",                                    PATH_ADMIN_END."sub_product",TRUE);                                             //http://a.com/현재폴더/admin/img
define("PATH_ADMIN_SUB_PRODUCT_END",                                PATH_ADMIN_END."sub_product".SLASH,TRUE);                                       //http://a.com/현재폴더/admin/img/
define("PATH_ADMIN_SUB_PRODUCT_HOME",                               PATH_ADMIN_SUB_PRODUCT_END.PAGE_DEFAULT,TRUE);                                  //http://a.com/현재폴더/admin/img/index.php

define("PATH_HERO_SUB_PRODUCT",                                     PATH_HERO_END."sub_product",TRUE);                                              //http://a.com/현재폴더/hero/img
define("PATH_HERO_SUB_PRODUCT_END",                                 PATH_HERO_END."sub_product".SLASH,TRUE);                                        //http://a.com/현재폴더/hero/img/
define("PATH_HERO_SUB_PRODUCT_HOME",                                PATH_HERO_SUB_PRODUCT_END.PAGE_DEFAULT,TRUE);                                   //http://a.com/현재폴더/hero/img/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define("DOMAIN_SUB_PRODUCT_INC",                                    DOMAIN_INC_END."sub_product",TRUE);                                             //C:/APM_Setup/htdocs/img
define("DOMAIN_SUB_PRODUCT_INC_END",                                DOMAIN_INC_END."sub_product".SLASH,TRUE);                                       //C:/APM_Setup/htdocs/img/
define("DOMAIN_SUB_PRODUCT_INC_HOME",                               DOMAIN_SUB_PRODUCT_INC_END.PAGE_DEFAULT,TRUE);                                  //C:/APM_Setup/htdocs/img/index.php

define("DOMAIN_ADMIN_SUB_PRODUCT_INC",                              DOMAIN_ADMIN_INC_END."sub_product",TRUE);                                       //C:/APM_Setup/htdocs/admin/img
define("DOMAIN_ADMIN_SUB_PRODUCT_INC_END",                          DOMAIN_ADMIN_INC_END."sub_product".SLASH,TRUE);                                 //C:/APM_Setup/htdocs/admin/img/
define("DOMAIN_ADMIN_SUB_PRODUCT_INC_HOME",                         DOMAIN_ADMIN_SUB_PRODUCT_INC_END.PAGE_DEFAULT,TRUE);                            //C:/APM_Setup/htdocs/admin/img/index.php

define("DOMAIN_HERO_SUB_PRODUCT_INC",                               DOMAIN_HERO_INC_END."sub_product",TRUE);                                        //C:/APM_Setup/htdocs/hero/img
define("DOMAIN_HERO_SUB_PRODUCT_INC_END",                           DOMAIN_HERO_INC_END."sub_product".SLASH,TRUE);                                  //C:/APM_Setup/htdocs/hero/img/
define("DOMAIN_HERO_SUB_PRODUCT_INC_HOME",                          DOMAIN_HERO_SUB_PRODUCT_INC_END.PAGE_DEFAULT,TRUE);                             //C:/APM_Setup/htdocs/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_INC_END)
####################################################################################################################################################
define("SUB_PRODUCT_INC",                                           HOME_INC_END."sub_product",TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/img
define("SUB_PRODUCT_INC_END",                                       HOME_INC_END."sub_product".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/img/
define("SUB_PRODUCT_INC_HOME",                                      SUB_PRODUCT_INC_END.PAGE_DEFAULT,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ADMIN_SUB_PRODUCT_INC",                                     ADMIN_INC_END."sub_product",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ADMIN_SUB_PRODUCT_INC_END",                                 ADMIN_INC_END."sub_product".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ADMIN_SUB_PRODUCT_INC_HOME",                                ADMIN_SUB_PRODUCT_INC_END.PAGE_DEFAULT,TRUE);                                   //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HERO_SUB_PRODUCT_INC",                                      HERO_INC_END."sub_product",TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HERO_SUB_PRODUCT_INC_END",                                  HERO_INC_END."sub_product".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HERO_SUB_PRODUCT_INC_HOME",                                 HERO_SUB_PRODUCT_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_SUB_PRODUCT_INC",                                      ROOT_INC_END."sub_product",TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/img
define("ROOT_SUB_PRODUCT_INC_END",                                  ROOT_INC_END."sub_product".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/img/
define("ROOT_SUB_PRODUCT_INC_HOME",                                 ROOT_SUB_PRODUCT_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ROOT_ADMIN_SUB_PRODUCT_INC",                                ADMIN_INC_END."sub_product",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ROOT_ADMIN_SUB_PRODUCT_INC_END",                            ADMIN_INC_END."sub_product".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ROOT_ADMIN_SUB_PRODUCT_INC_HOME",                           ROOT_ADMIN_SUB_PRODUCT_INC_END.PAGE_DEFAULT,TRUE);                              //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("ROOT_HERO_SUB_PRODUCT_INC",                                 HERO_INC_END."sub_product",TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/hero/img
define("ROOT_HERO_SUB_PRODUCT_INC_END",                             HERO_INC_END."sub_product".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("ROOT_HERO_SUB_PRODUCT_INC_HOME",                            ROOT_HERO_SUB_PRODUCT_INC_END.PAGE_DEFAULT,TRUE);                               //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_SUB_PRODUCT_INC",                                      HOME_INC_END."sub_product",TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/img
define("HOME_SUB_PRODUCT_INC_END",                                  HOME_INC_END."sub_product".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/img/
define("HOME_SUB_PRODUCT_INC_HOME",                                 HOME_SUB_PRODUCT_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("HOME_ADMIN_SUB_PRODUCT_INC",                                ADMIN_INC_END."sub_product",TRUE);                                              //C:/APM_Setup/htdocs/기본폴더/admin/img
define("HOME_ADMIN_SUB_PRODUCT_INC_END",                            ADMIN_INC_END."sub_product".SLASH,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("HOME_ADMIN_SUB_PRODUCT_INC_HOME",                           HOME_ADMIN_SUB_PRODUCT_INC_END.PAGE_DEFAULT,TRUE);                              //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HOME_HERO_SUB_PRODUCT_INC",                                 HERO_INC_END."sub_product",TRUE);                                               //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HOME_HERO_SUB_PRODUCT_INC_END",                             HERO_INC_END."sub_product".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HOME_HERO_SUB_PRODUCT_INC_HOME",                            HOME_HERO_SUB_PRODUCT_INC_END.PAGE_DEFAULT,TRUE);                               //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_INC_END)
####################################################################################################################################################
define("PATH_SUB_PRODUCT_INC",                                      PATH_INC_END."sub_product",TRUE);                                               //C:/APM_Setup/htdocs/현재폴더/img
define("PATH_SUB_PRODUCT_INC_END",                                  PATH_INC_END."sub_product".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/현재폴더/img/
define("PATH_SUB_PRODUCT_INC_HOME",                                 PATH_SUB_PRODUCT_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/현재폴더/img/index.php

define("PATH_ADMIN_SUB_PRODUCT_INC",                                PATH_ADMIN_INC_END."sub_product",TRUE);                                         //C:/APM_Setup/htdocs/현재폴더/admin/img
define("PATH_ADMIN_SUB_PRODUCT_INC_END",                            PATH_ADMIN_INC_END."sub_product".SLASH,TRUE);                                   //C:/APM_Setup/htdocs/현재폴더/admin/img/
define("PATH_ADMIN_SUB_PRODUCT_INC_HOME",                           PATH_ADMIN_SUB_PRODUCT_INC_END.PAGE_DEFAULT,TRUE);                              //C:/APM_Setup/htdocs/현재폴더/admin/img/index.php

define("PATH_HERO_SUB_PRODUCT_INC",                                 PATH_HERO_INC_END."sub_product",TRUE);                                          //C:/APM_Setup/htdocs/현재폴더/hero/img
define("PATH_HERO_SUB_PRODUCT_INC_END",                             PATH_HERO_INC_END."sub_product".SLASH,TRUE);                                    //C:/APM_Setup/htdocs/현재폴더/hero/img/
define("PATH_HERO_SUB_PRODUCT_INC_HOME",                            PATH_HERO_SUB_PRODUCT_INC_END.PAGE_DEFAULT,TRUE);                               //C:/APM_Setup/htdocs/현재폴더/hero/img/index.php
####################################################################################################################################################
####################################################################################################################################################
define("DOMAIN_SUB_STORY",                                          DOMAIN_END."sub_story",TRUE);                                                   //http://a.com/img
define("DOMAIN_SUB_STORY_END",                                      DOMAIN_END."sub_story".SLASH,TRUE);                                             //http://a.com/img/
define("DOMAIN_SUB_STORY_HOME",                                     DOMAIN_SUB_STORY_END.PAGE_DEFAULT,TRUE);                                        //http://a.com/img/index.php

define("DOMAIN_ADMIN_SUB_STORY",                                    DOMAIN_ADMIN_END."sub_story",TRUE);                                             //http://a.com/admin/img
define("DOMAIN_ADMIN_SUB_STORY_END",                                DOMAIN_ADMIN_END."sub_story".SLASH,TRUE);                                       //http://a.com/admin/img/
define("DOMAIN_ADMIN_SUB_STORY_HOME",                               DOMAIN_ADMIN_SUB_STORY_END.PAGE_DEFAULT,TRUE);                                  //http://a.com/admin/img/index.php

define("DOMAIN_HERO_SUB_STORY",                                     DOMAIN_HERO_END."sub_story",TRUE);                                              //http://a.com/hero/img
define("DOMAIN_HERO_SUB_STORY_END",                                 DOMAIN_HERO_END."sub_story".SLASH,TRUE);                                        //http://a.com/hero/img/
define("DOMAIN_HERO_SUB_STORY_HOME",                                DOMAIN_HERO_SUB_STORY_END.PAGE_DEFAULT,TRUE);                                   //http://a.com/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_END)
####################################################################################################################################################
define("SUB_STORY",                                                 HOME_END."sub_story",TRUE);                                                     //http://a.com/기본폴더/img
define("SUB_STORY_END",                                             HOME_END."sub_story".SLASH,TRUE);                                               //http://a.com/기본폴더/img/
define("SUB_STORY_HOME",                                            SUB_STORY_END.PAGE_DEFAULT,TRUE);                                               //http://a.com/기본폴더/img/index.php

define("ADMIN_SUB_STORY",                                           ADMIN_END."sub_story",TRUE);                                                    //http://a.com/기본폴더/admin/img
define("ADMIN_SUB_STORY_END",                                       ADMIN_END."sub_story".SLASH,TRUE);                                              //http://a.com/기본폴더/admin/img/
define("ADMIN_SUB_STORY_HOME",                                      ADMIN_SUB_STORY_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/기본폴더/admin/img/index.php

define("HERO_SUB_STORY",                                            HERO_END."sub_story",TRUE);                                                     //http://a.com/기본폴더/hero/img
define("HERO_SUB_STORY_END",                                        HERO_END."sub_story".SLASH,TRUE);                                               //http://a.com/기본폴더/hero/img/
define("HERO_SUB_STORY_HOME",                                       HERO_SUB_STORY_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_SUB_STORY",                                            ROOT_END."sub_story",TRUE);                                                     //http://a.com/기본폴더/img
define("ROOT_SUB_STORY_END",                                        ROOT_END."sub_story".SLASH,TRUE);                                               //http://a.com/기본폴더/img/
define("ROOT_SUB_STORY_HOME",                                       ROOT_SUB_STORY_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/기본폴더/img/index.php

define("ROOT_ADMIN_SUB_STORY",                                      ADMIN_END."sub_story",TRUE);                                                    //http://a.com/기본폴더/admin/img
define("ROOT_ADMIN_SUB_STORY_END",                                  ADMIN_END."sub_story".SLASH,TRUE);                                              //http://a.com/기본폴더/admin/img/
define("ROOT_ADMIN_SUB_STORY_HOME",                                 ROOT_ADMIN_SUB_STORY_END.PAGE_DEFAULT,TRUE);                                    //http://a.com/기본폴더/admin/img/index.php

define("ROOT_HERO_SUB_STORY",                                       HERO_END."sub_story",TRUE);                                                     //http://a.com/기본폴더/hero/img
define("ROOT_HERO_SUB_STORY_END",                                   HERO_END."sub_story".SLASH,TRUE);                                               //http://a.com/기본폴더/hero/img/
define("ROOT_HERO_SUB_STORY_HOME",                                  ROOT_HERO_SUB_STORY_END.PAGE_DEFAULT,TRUE);                                     //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_SUB_STORY",                                            HOME_END."sub_story",TRUE);                                                     //http://a.com/기본폴더/img
define("HOME_SUB_STORY_END",                                        HOME_END."sub_story".SLASH,TRUE);                                               //http://a.com/기본폴더/img/
define("HOME_SUB_STORY_HOME",                                       HOME_SUB_STORY_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/기본폴더/img/index.php

define("HOME_ADMIN_SUB_STORY",                                      ADMIN_END."sub_story",TRUE);                                                    //http://a.com/기본폴더/admin/img
define("HOME_ADMIN_SUB_STORY_END",                                  ADMIN_END."sub_story".SLASH,TRUE);                                              //http://a.com/기본폴더/admin/img/
define("HOME_ADMIN_SUB_STORY_HOME",                                 HOME_ADMIN_SUB_STORY_END.PAGE_DEFAULT,TRUE);                                    //http://a.com/기본폴더/admin/img/index.php

define("HOME_HERO_SUB_STORY",                                       HERO_END."sub_story",TRUE);                                                     //http://a.com/기본폴더/hero/img
define("HOME_HERO_SUB_STORY_END",                                   HERO_END."sub_story".SLASH,TRUE);                                               //http://a.com/기본폴더/hero/img/
define("HOME_HERO_SUB_STORY_HOME",                                  HOME_HERO_SUB_STORY_END.PAGE_DEFAULT,TRUE);                                     //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_END)
####################################################################################################################################################
define("PATH_SUB_STORY",                                            PATH_END."sub_story",TRUE);                                                     //http://a.com/현재폴더/img
define("PATH_SUB_STORY_END",                                        PATH_END."sub_story".SLASH,TRUE);                                               //http://a.com/현재폴더/img/
define("PATH_SUB_STORY_HOME",                                       PATH_SUB_STORY_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/현재폴더/img/index.php

define("PATH_ADMIN_SUB_STORY",                                      PATH_ADMIN_END."sub_story",TRUE);                                               //http://a.com/현재폴더/admin/img
define("PATH_ADMIN_SUB_STORY_END",                                  PATH_ADMIN_END."sub_story".SLASH,TRUE);                                         //http://a.com/현재폴더/admin/img/
define("PATH_ADMIN_SUB_STORY_HOME",                                 PATH_ADMIN_SUB_STORY_END.PAGE_DEFAULT,TRUE);                                    //http://a.com/현재폴더/admin/img/index.php

define("PATH_HERO_SUB_STORY",                                       PATH_HERO_END."sub_story",TRUE);                                                //http://a.com/현재폴더/hero/img
define("PATH_HERO_SUB_STORY_END",                                   PATH_HERO_END."sub_story".SLASH,TRUE);                                          //http://a.com/현재폴더/hero/img/
define("PATH_HERO_SUB_STORY_HOME",                                  PATH_HERO_SUB_STORY_END.PAGE_DEFAULT,TRUE);                                     //http://a.com/현재폴더/hero/img/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define("DOMAIN_SUB_STORY_INC",                                      DOMAIN_INC_END."sub_story",TRUE);                                               //C:/APM_Setup/htdocs/img
define("DOMAIN_SUB_STORY_INC_END",                                  DOMAIN_INC_END."sub_story".SLASH,TRUE);                                         //C:/APM_Setup/htdocs/img/
define("DOMAIN_SUB_STORY_INC_HOME",                                 DOMAIN_SUB_STORY_INC_END.PAGE_DEFAULT,TRUE);                                    //C:/APM_Setup/htdocs/img/index.php

define("DOMAIN_ADMIN_SUB_STORY_INC",                                DOMAIN_ADMIN_INC_END."sub_story",TRUE);                                         //C:/APM_Setup/htdocs/admin/img
define("DOMAIN_ADMIN_SUB_STORY_INC_END",                            DOMAIN_ADMIN_INC_END."sub_story".SLASH,TRUE);                                   //C:/APM_Setup/htdocs/admin/img/
define("DOMAIN_ADMIN_SUB_STORY_INC_HOME",                           DOMAIN_ADMIN_SUB_STORY_INC_END.PAGE_DEFAULT,TRUE);                              //C:/APM_Setup/htdocs/admin/img/index.php

define("DOMAIN_HERO_SUB_STORY_INC",                                 DOMAIN_HERO_INC_END."sub_story",TRUE);                                          //C:/APM_Setup/htdocs/hero/img
define("DOMAIN_HERO_SUB_STORY_INC_END",                             DOMAIN_HERO_INC_END."sub_story".SLASH,TRUE);                                    //C:/APM_Setup/htdocs/hero/img/
define("DOMAIN_HERO_SUB_STORY_INC_HOME",                            DOMAIN_HERO_SUB_STORY_INC_END.PAGE_DEFAULT,TRUE);                               //C:/APM_Setup/htdocs/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_INC_END)
####################################################################################################################################################
define("SUB_STORY_INC",                                             HOME_INC_END."sub_story",TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/img
define("SUB_STORY_INC_END",                                         HOME_INC_END."sub_story".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/img/
define("SUB_STORY_INC_HOME",                                        SUB_STORY_INC_END.PAGE_DEFAULT,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ADMIN_SUB_STORY_INC",                                       ADMIN_INC_END."sub_story",TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ADMIN_SUB_STORY_INC_END",                                   ADMIN_INC_END."sub_story".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ADMIN_SUB_STORY_INC_HOME",                                  ADMIN_SUB_STORY_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HERO_SUB_STORY_INC",                                        HERO_INC_END."sub_story",TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HERO_SUB_STORY_INC_END",                                    HERO_INC_END."sub_story".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HERO_SUB_STORY_INC_HOME",                                   HERO_SUB_STORY_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_SUB_STORY_INC",                                        ROOT_INC_END."sub_story",TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/img
define("ROOT_SUB_STORY_INC_END",                                    ROOT_INC_END."sub_story".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/img/
define("ROOT_SUB_STORY_INC_HOME",                                   ROOT_SUB_STORY_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ROOT_ADMIN_SUB_STORY_INC",                                  ADMIN_INC_END."sub_story",TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ROOT_ADMIN_SUB_STORY_INC_END",                              ADMIN_INC_END."sub_story".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ROOT_ADMIN_SUB_STORY_INC_HOME",                             ROOT_ADMIN_SUB_STORY_INC_END.PAGE_DEFAULT,TRUE);                                //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("ROOT_HERO_SUB_STORY_INC",                                   HERO_INC_END."sub_story",TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/hero/img
define("ROOT_HERO_SUB_STORY_INC_END",                               HERO_INC_END."sub_story".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("ROOT_HERO_SUB_STORY_INC_HOME",                              ROOT_HERO_SUB_STORY_INC_END.PAGE_DEFAULT,TRUE);                                 //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_SUB_STORY_INC",                                        HOME_INC_END."sub_story",TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/img
define("HOME_SUB_STORY_INC_END",                                    HOME_INC_END."sub_story".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/img/
define("HOME_SUB_STORY_INC_HOME",                                   HOME_SUB_STORY_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("HOME_ADMIN_SUB_STORY_INC",                                  ADMIN_INC_END."sub_story",TRUE);                                                //C:/APM_Setup/htdocs/기본폴더/admin/img
define("HOME_ADMIN_SUB_STORY_INC_END",                              ADMIN_INC_END."sub_story".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("HOME_ADMIN_SUB_STORY_INC_HOME",                             HOME_ADMIN_SUB_STORY_INC_END.PAGE_DEFAULT,TRUE);                                //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HOME_HERO_SUB_STORY_INC",                                   HERO_INC_END."sub_story",TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HOME_HERO_SUB_STORY_INC_END",                               HERO_INC_END."sub_story".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HOME_HERO_SUB_STORY_INC_HOME",                              HOME_HERO_SUB_STORY_INC_END.PAGE_DEFAULT,TRUE);                                 //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_INC_END)
####################################################################################################################################################
define("PATH_SUB_STORY_INC",                                        PATH_INC_END."sub_story",TRUE);                                                 //C:/APM_Setup/htdocs/현재폴더/img
define("PATH_SUB_STORY_INC_END",                                    PATH_INC_END."sub_story".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/현재폴더/img/
define("PATH_SUB_STORY_INC_HOME",                                   PATH_SUB_STORY_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/현재폴더/img/index.php

define("PATH_ADMIN_SUB_STORY_INC",                                  PATH_ADMIN_INC_END."sub_story",TRUE);                                           //C:/APM_Setup/htdocs/현재폴더/admin/img
define("PATH_ADMIN_SUB_STORY_INC_END",                              PATH_ADMIN_INC_END."sub_story".SLASH,TRUE);                                     //C:/APM_Setup/htdocs/현재폴더/admin/img/
define("PATH_ADMIN_SUB_STORY_INC_HOME",                             PATH_ADMIN_SUB_STORY_INC_END.PAGE_DEFAULT,TRUE);                                //C:/APM_Setup/htdocs/현재폴더/admin/img/index.php

define("PATH_HERO_SUB_STORY_INC",                                   PATH_HERO_INC_END."sub_story",TRUE);                                            //C:/APM_Setup/htdocs/현재폴더/hero/img
define("PATH_HERO_SUB_STORY_INC_END",                               PATH_HERO_INC_END."sub_story".SLASH,TRUE);                                      //C:/APM_Setup/htdocs/현재폴더/hero/img/
define("PATH_HERO_SUB_STORY_INC_HOME",                              PATH_HERO_SUB_STORY_INC_END.PAGE_DEFAULT,TRUE);                                 //C:/APM_Setup/htdocs/현재폴더/hero/img/index.php
####################################################################################################################################################
####################################################################################################################################################
define("DOMAIN_SUB_TALK",                                           DOMAIN_END."sub_talk",TRUE);                                                    //http://a.com/img
define("DOMAIN_SUB_TALK_END",                                       DOMAIN_END."sub_talk".SLASH,TRUE);                                              //http://a.com/img/
define("DOMAIN_SUB_TALK_HOME",                                      DOMAIN_SUB_TALK_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/img/index.php

define("DOMAIN_ADMIN_SUB_TALK",                                     DOMAIN_ADMIN_END."sub_talk",TRUE);                                              //http://a.com/admin/img
define("DOMAIN_ADMIN_SUB_TALK_END",                                 DOMAIN_ADMIN_END."sub_talk".SLASH,TRUE);                                        //http://a.com/admin/img/
define("DOMAIN_ADMIN_SUB_TALK_HOME",                                DOMAIN_ADMIN_SUB_TALK_END.PAGE_DEFAULT,TRUE);                                   //http://a.com/admin/img/index.php

define("DOMAIN_HERO_SUB_TALK",                                      DOMAIN_HERO_END."sub_talk",TRUE);                                               //http://a.com/hero/img
define("DOMAIN_HERO_SUB_TALK_END",                                  DOMAIN_HERO_END."sub_talk".SLASH,TRUE);                                         //http://a.com/hero/img/
define("DOMAIN_HERO_SUB_TALK_HOME",                                 DOMAIN_HERO_SUB_TALK_END.PAGE_DEFAULT,TRUE);                                    //http://a.com/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_END)
####################################################################################################################################################
define("SUB_TALK",                                                  HOME_END."sub_talk",TRUE);                                                      //http://a.com/기본폴더/img
define("SUB_TALK_END",                                              HOME_END."sub_talk".SLASH,TRUE);                                                //http://a.com/기본폴더/img/
define("SUB_TALK_HOME",                                             SUB_TALK_END.PAGE_DEFAULT,TRUE);                                                //http://a.com/기본폴더/img/index.php

define("ADMIN_SUB_TALK",                                            ADMIN_END."sub_talk",TRUE);                                                     //http://a.com/기본폴더/admin/img
define("ADMIN_SUB_TALK_END",                                        ADMIN_END."sub_talk".SLASH,TRUE);                                               //http://a.com/기본폴더/admin/img/
define("ADMIN_SUB_TALK_HOME",                                       ADMIN_SUB_TALK_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/기본폴더/admin/img/index.php

define("HERO_SUB_TALK",                                             HERO_END."sub_talk",TRUE);                                                      //http://a.com/기본폴더/hero/img
define("HERO_SUB_TALK_END",                                         HERO_END."sub_talk".SLASH,TRUE);                                                //http://a.com/기본폴더/hero/img/
define("HERO_SUB_TALK_HOME",                                        HERO_SUB_TALK_END.PAGE_DEFAULT,TRUE);                                           //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_SUB_TALK",                                             ROOT_END."sub_talk",TRUE);                                                      //http://a.com/기본폴더/img
define("ROOT_SUB_TALK_END",                                         ROOT_END."sub_talk".SLASH,TRUE);                                                //http://a.com/기본폴더/img/
define("ROOT_SUB_TALK_HOME",                                        ROOT_SUB_TALK_END.PAGE_DEFAULT,TRUE);                                           //http://a.com/기본폴더/img/index.php

define("ROOT_ADMIN_SUB_TALK",                                       ADMIN_END."sub_talk",TRUE);                                                     //http://a.com/기본폴더/admin/img
define("ROOT_ADMIN_SUB_TALK_END",                                   ADMIN_END."sub_talk".SLASH,TRUE);                                               //http://a.com/기본폴더/admin/img/
define("ROOT_ADMIN_SUB_TALK_HOME",                                  ROOT_ADMIN_SUB_TALK_END.PAGE_DEFAULT,TRUE);                                     //http://a.com/기본폴더/admin/img/index.php

define("ROOT_HERO_SUB_TALK",                                        HERO_END."sub_talk",TRUE);                                                      //http://a.com/기본폴더/hero/img
define("ROOT_HERO_SUB_TALK_END",                                    HERO_END."sub_talk".SLASH,TRUE);                                                //http://a.com/기본폴더/hero/img/
define("ROOT_HERO_SUB_TALK_HOME",                                   ROOT_HERO_SUB_TALK_END.PAGE_DEFAULT,TRUE);                                      //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_SUB_TALK",                                             HOME_END."sub_talk",TRUE);                                                      //http://a.com/기본폴더/img
define("HOME_SUB_TALK_END",                                         HOME_END."sub_talk".SLASH,TRUE);                                                //http://a.com/기본폴더/img/
define("HOME_SUB_TALK_HOME",                                        HOME_SUB_TALK_END.PAGE_DEFAULT,TRUE);                                           //http://a.com/기본폴더/img/index.php

define("HOME_ADMIN_SUB_TALK",                                       ADMIN_END."sub_talk",TRUE);                                                     //http://a.com/기본폴더/admin/img
define("HOME_ADMIN_SUB_TALK_END",                                   ADMIN_END."sub_talk".SLASH,TRUE);                                               //http://a.com/기본폴더/admin/img/
define("HOME_ADMIN_SUB_TALK_HOME",                                  HOME_ADMIN_SUB_TALK_END.PAGE_DEFAULT,TRUE);                                     //http://a.com/기본폴더/admin/img/index.php

define("HOME_HERO_SUB_TALK",                                        HERO_END."sub_talk",TRUE);                                                      //http://a.com/기본폴더/hero/img
define("HOME_HERO_SUB_TALK_END",                                    HERO_END."sub_talk".SLASH,TRUE);                                                //http://a.com/기본폴더/hero/img/
define("HOME_HERO_SUB_TALK_HOME",                                   HOME_HERO_SUB_TALK_END.PAGE_DEFAULT,TRUE);                                      //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_END)
####################################################################################################################################################
define("PATH_SUB_TALK",                                             PATH_END."sub_talk",TRUE);                                                      //http://a.com/현재폴더/img
define("PATH_SUB_TALK_END",                                         PATH_END."sub_talk".SLASH,TRUE);                                                //http://a.com/현재폴더/img/
define("PATH_SUB_TALK_HOME",                                        PATH_SUB_TALK_END.PAGE_DEFAULT,TRUE);                                           //http://a.com/현재폴더/img/index.php

define("PATH_ADMIN_SUB_TALK",                                       PATH_ADMIN_END."sub_talk",TRUE);                                                //http://a.com/현재폴더/admin/img
define("PATH_ADMIN_SUB_TALK_END",                                   PATH_ADMIN_END."sub_talk".SLASH,TRUE);                                          //http://a.com/현재폴더/admin/img/
define("PATH_ADMIN_SUB_TALK_HOME",                                  PATH_ADMIN_SUB_TALK_END.PAGE_DEFAULT,TRUE);                                     //http://a.com/현재폴더/admin/img/index.php

define("PATH_HERO_SUB_TALK",                                        PATH_HERO_END."sub_talk",TRUE);                                                 //http://a.com/현재폴더/hero/img
define("PATH_HERO_SUB_TALK_END",                                    PATH_HERO_END."sub_talk".SLASH,TRUE);                                           //http://a.com/현재폴더/hero/img/
define("PATH_HERO_SUB_TALK_HOME",                                   PATH_HERO_SUB_TALK_END.PAGE_DEFAULT,TRUE);                                      //http://a.com/현재폴더/hero/img/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define("DOMAIN_SUB_TALK_INC",                                       DOMAIN_INC_END."sub_talk",TRUE);                                                //C:/APM_Setup/htdocs/img
define("DOMAIN_SUB_TALK_INC_END",                                   DOMAIN_INC_END."sub_talk".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/img/
define("DOMAIN_SUB_TALK_INC_HOME",                                  DOMAIN_SUB_TALK_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/img/index.php

define("DOMAIN_ADMIN_SUB_TALK_INC",                                 DOMAIN_ADMIN_INC_END."sub_talk",TRUE);                                          //C:/APM_Setup/htdocs/admin/img
define("DOMAIN_ADMIN_SUB_TALK_INC_END",                             DOMAIN_ADMIN_INC_END."sub_talk".SLASH,TRUE);                                    //C:/APM_Setup/htdocs/admin/img/
define("DOMAIN_ADMIN_SUB_TALK_INC_HOME",                            DOMAIN_ADMIN_SUB_TALK_INC_END.PAGE_DEFAULT,TRUE);                               //C:/APM_Setup/htdocs/admin/img/index.php

define("DOMAIN_HERO_SUB_TALK_INC",                                  DOMAIN_HERO_INC_END."sub_talk",TRUE);                                           //C:/APM_Setup/htdocs/hero/img
define("DOMAIN_HERO_SUB_TALK_INC_END",                              DOMAIN_HERO_INC_END."sub_talk".SLASH,TRUE);                                     //C:/APM_Setup/htdocs/hero/img/
define("DOMAIN_HERO_SUB_TALK_INC_HOME",                             DOMAIN_HERO_SUB_TALK_INC_END.PAGE_DEFAULT,TRUE);                                //C:/APM_Setup/htdocs/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_INC_END)
####################################################################################################################################################
define("SUB_TALK_INC",                                              HOME_INC_END."sub_talk",TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/img
define("SUB_TALK_INC_END",                                          HOME_INC_END."sub_talk".SLASH,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/img/
define("SUB_TALK_INC_HOME",                                         SUB_TALK_INC_END.PAGE_DEFAULT,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ADMIN_SUB_TALK_INC",                                        ADMIN_INC_END."sub_talk",TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ADMIN_SUB_TALK_INC_END",                                    ADMIN_INC_END."sub_talk".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ADMIN_SUB_TALK_INC_HOME",                                   ADMIN_SUB_TALK_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HERO_SUB_TALK_INC",                                         HERO_INC_END."sub_talk",TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HERO_SUB_TALK_INC_END",                                     HERO_INC_END."sub_talk".SLASH,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HERO_SUB_TALK_INC_HOME",                                    HERO_SUB_TALK_INC_END.PAGE_DEFAULT,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_SUB_TALK_INC",                                         ROOT_INC_END."sub_talk",TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/img
define("ROOT_SUB_TALK_INC_END",                                     ROOT_INC_END."sub_talk".SLASH,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/img/
define("ROOT_SUB_TALK_INC_HOME",                                    ROOT_SUB_TALK_INC_END.PAGE_DEFAULT,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ROOT_ADMIN_SUB_TALK_INC",                                   ADMIN_INC_END."sub_talk",TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ROOT_ADMIN_SUB_TALK_INC_END",                               ADMIN_INC_END."sub_talk".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ROOT_ADMIN_SUB_TALK_INC_HOME",                              ROOT_ADMIN_SUB_TALK_INC_END.PAGE_DEFAULT,TRUE);                                 //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("ROOT_HERO_SUB_TALK_INC",                                    HERO_INC_END."sub_talk",TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/hero/img
define("ROOT_HERO_SUB_TALK_INC_END",                                HERO_INC_END."sub_talk".SLASH,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("ROOT_HERO_SUB_TALK_INC_HOME",                               ROOT_HERO_SUB_TALK_INC_END.PAGE_DEFAULT,TRUE);                                  //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_SUB_TALK_INC",                                         HOME_INC_END."sub_talk",TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/img
define("HOME_SUB_TALK_INC_END",                                     HOME_INC_END."sub_talk".SLASH,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/img/
define("HOME_SUB_TALK_INC_HOME",                                    HOME_SUB_TALK_INC_END.PAGE_DEFAULT,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("HOME_ADMIN_SUB_TALK_INC",                                   ADMIN_INC_END."sub_talk",TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/admin/img
define("HOME_ADMIN_SUB_TALK_INC_END",                               ADMIN_INC_END."sub_talk".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("HOME_ADMIN_SUB_TALK_INC_HOME",                              HOME_ADMIN_SUB_TALK_INC_END.PAGE_DEFAULT,TRUE);                                 //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HOME_HERO_SUB_TALK_INC",                                    HERO_INC_END."sub_talk",TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HOME_HERO_SUB_TALK_INC_END",                                HERO_INC_END."sub_talk".SLASH,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HOME_HERO_SUB_TALK_INC_HOME",                               HOME_HERO_SUB_TALK_INC_END.PAGE_DEFAULT,TRUE);                                  //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_INC_END)
####################################################################################################################################################
define("PATH_SUB_TALK_INC",                                         PATH_INC_END."sub_talk",TRUE);                                                  //C:/APM_Setup/htdocs/현재폴더/img
define("PATH_SUB_TALK_INC_END",                                     PATH_INC_END."sub_talk".SLASH,TRUE);                                            //C:/APM_Setup/htdocs/현재폴더/img/
define("PATH_SUB_TALK_INC_HOME",                                    PATH_SUB_TALK_INC_END.PAGE_DEFAULT,TRUE);                                       //C:/APM_Setup/htdocs/현재폴더/img/index.php

define("PATH_ADMIN_SUB_TALK_INC",                                   PATH_ADMIN_INC_END."sub_talk",TRUE);                                            //C:/APM_Setup/htdocs/현재폴더/admin/img
define("PATH_ADMIN_SUB_TALK_INC_END",                               PATH_ADMIN_INC_END."sub_talk".SLASH,TRUE);                                      //C:/APM_Setup/htdocs/현재폴더/admin/img/
define("PATH_ADMIN_SUB_TALK_INC_HOME",                              PATH_ADMIN_SUB_TALK_INC_END.PAGE_DEFAULT,TRUE);                                 //C:/APM_Setup/htdocs/현재폴더/admin/img/index.php

define("PATH_HERO_SUB_TALK_INC",                                    PATH_HERO_INC_END."sub_talk",TRUE);                                             //C:/APM_Setup/htdocs/현재폴더/hero/img
define("PATH_HERO_SUB_TALK_INC_END",                                PATH_HERO_INC_END."sub_talk".SLASH,TRUE);                                       //C:/APM_Setup/htdocs/현재폴더/hero/img/
define("PATH_HERO_SUB_TALK_INC_HOME",                               PATH_HERO_SUB_TALK_INC_END.PAGE_DEFAULT,TRUE);                                  //C:/APM_Setup/htdocs/현재폴더/hero/img/index.php
####################################################################################################################################################
####################################################################################################################################################
define("DOMAIN_DB",                                                 DOMAIN_END."db",TRUE);                                                          //http://a.com/img
define("DOMAIN_DB_END",                                             DOMAIN_END."db".SLASH,TRUE);                                                    //http://a.com/img/
define("DOMAIN_DB_HOME",                                            DOMAIN_DB_END.PAGE_DEFAULT,TRUE);                                               //http://a.com/img/index.php

define("DOMAIN_ADMIN_DB",                                           DOMAIN_ADMIN_END."db",TRUE);                                                    //http://a.com/admin/img
define("DOMAIN_ADMIN_DB_END",                                       DOMAIN_ADMIN_END."db".SLASH,TRUE);                                              //http://a.com/admin/img/
define("DOMAIN_ADMIN_DB_HOME",                                      DOMAIN_ADMIN_DB_END.PAGE_DEFAULT,TRUE);                                         //http://a.com/admin/img/index.php

define("DOMAIN_HERO_DB",                                            DOMAIN_HERO_END."db",TRUE);                                                     //http://a.com/hero/img
define("DOMAIN_HERO_DB_END",                                        DOMAIN_HERO_END."db".SLASH,TRUE);                                               //http://a.com/hero/img/
define("DOMAIN_HERO_DB_HOME",                                       DOMAIN_HERO_DB_END.PAGE_DEFAULT,TRUE);                                          //http://a.com/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_END)
####################################################################################################################################################
define("DB",                                                        HOME_END."db",TRUE);                                                            //http://a.com/기본폴더/img
define("DB_END",                                                    HOME_END."db".SLASH,TRUE);                                                      //http://a.com/기본폴더/img/
define("DB_HOME",                                                   DB_END.PAGE_DEFAULT,TRUE);                                                      //http://a.com/기본폴더/img/index.php

define("ADMIN_DB",                                                  ADMIN_END."db",TRUE);                                                           //http://a.com/기본폴더/admin/img
define("ADMIN_DB_END",                                              ADMIN_END."db".SLASH,TRUE);                                                     //http://a.com/기본폴더/admin/img/
define("ADMIN_DB_HOME",                                             ADMIN_DB_END.PAGE_DEFAULT,TRUE);                                                //http://a.com/기본폴더/admin/img/index.php

define("HERO_DB",                                                   HERO_END."db",TRUE);                                                            //http://a.com/기본폴더/hero/img
define("HERO_DB_END",                                               HERO_END."db".SLASH,TRUE);                                                      //http://a.com/기본폴더/hero/img/
define("HERO_DB_HOME",                                              HERO_DB_END.PAGE_DEFAULT,TRUE);                                                 //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_DB",                                                   ROOT_END."db",TRUE);                                                            //http://a.com/기본폴더/img
define("ROOT_DB_END",                                               ROOT_END."db".SLASH,TRUE);                                                      //http://a.com/기본폴더/img/
define("ROOT_DB_HOME",                                              ROOT_DB_END.PAGE_DEFAULT,TRUE);                                                 //http://a.com/기본폴더/img/index.php

define("ROOT_ADMIN_DB",                                             ADMIN_END."db",TRUE);                                                           //http://a.com/기본폴더/admin/img
define("ROOT_ADMIN_DB_END",                                         ADMIN_END."db".SLASH,TRUE);                                                     //http://a.com/기본폴더/admin/img/
define("ROOT_ADMIN_DB_HOME",                                        ROOT_ADMIN_DB_END.PAGE_DEFAULT,TRUE);                                           //http://a.com/기본폴더/admin/img/index.php

define("ROOT_HERO_DB",                                              HERO_END."db",TRUE);                                                            //http://a.com/기본폴더/hero/img
define("ROOT_HERO_DB_END",                                          HERO_END."db".SLASH,TRUE);                                                      //http://a.com/기본폴더/hero/img/
define("ROOT_HERO_DB_HOME",                                         ROOT_HERO_DB_END.PAGE_DEFAULT,TRUE);                                            //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_DB",                                                   HOME_END."db",TRUE);                                                            //http://a.com/기본폴더/img
define("HOME_DB_END",                                               HOME_END."db".SLASH,TRUE);                                                      //http://a.com/기본폴더/img/
define("HOME_DB_HOME",                                              HOME_DB_END.PAGE_DEFAULT,TRUE);                                                 //http://a.com/기본폴더/img/index.php

define("HOME_ADMIN_DB",                                             ADMIN_END."db",TRUE);                                                           //http://a.com/기본폴더/admin/img
define("HOME_ADMIN_DB_END",                                         ADMIN_END."db".SLASH,TRUE);                                                     //http://a.com/기본폴더/admin/img/
define("HOME_ADMIN_DB_HOME",                                        HOME_ADMIN_DB_END.PAGE_DEFAULT,TRUE);                                           //http://a.com/기본폴더/admin/img/index.php

define("HOME_HERO_DB",                                              HERO_END."db",TRUE);                                                            //http://a.com/기본폴더/hero/img
define("HOME_HERO_DB_END",                                          HERO_END."db".SLASH,TRUE);                                                      //http://a.com/기본폴더/hero/img/
define("HOME_HERO_DB_HOME",                                         HOME_HERO_DB_END.PAGE_DEFAULT,TRUE);                                            //http://a.com/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_END)
####################################################################################################################################################
define("PATH_DB",                                                   PATH_END."db",TRUE);                                                            //http://a.com/현재폴더/img
define("PATH_DB_END",                                               PATH_END."db".SLASH,TRUE);                                                      //http://a.com/현재폴더/img/
define("PATH_DB_HOME",                                              PATH_DB_END.PAGE_DEFAULT,TRUE);                                                 //http://a.com/현재폴더/img/index.php

define("PATH_ADMIN_DB",                                             PATH_ADMIN_END."db",TRUE);                                                      //http://a.com/현재폴더/admin/img
define("PATH_ADMIN_DB_END",                                         PATH_ADMIN_END."db".SLASH,TRUE);                                                //http://a.com/현재폴더/admin/img/
define("PATH_ADMIN_DB_HOME",                                        PATH_ADMIN_DB_END.PAGE_DEFAULT,TRUE);                                           //http://a.com/현재폴더/admin/img/index.php

define("PATH_HERO_DB",                                              PATH_HERO_END."db",TRUE);                                                       //http://a.com/현재폴더/hero/img
define("PATH_HERO_DB_END",                                          PATH_HERO_END."db".SLASH,TRUE);                                                 //http://a.com/현재폴더/hero/img/
define("PATH_HERO_DB_HOME",                                         PATH_HERO_DB_END.PAGE_DEFAULT,TRUE);                                            //http://a.com/현재폴더/hero/img/index.php
####################################################################################################################################################
////////////////////////////////////////////////////////////////////////////////////////////////////
####################################################################################################################################################
define("DOMAIN_DB_INC",                                             DOMAIN_INC_END."db",TRUE);                                                      //C:/APM_Setup/htdocs/img
define("DOMAIN_DB_INC_END",                                         DOMAIN_INC_END."db".SLASH,TRUE);                                                //C:/APM_Setup/htdocs/img/
define("DOMAIN_DB_INC_HOME",                                        DOMAIN_DB_INC_END.PAGE_DEFAULT,TRUE);                                           //C:/APM_Setup/htdocs/img/index.php

define("DOMAIN_ADMIN_DB_INC",                                       DOMAIN_ADMIN_INC_END."db",TRUE);                                                //C:/APM_Setup/htdocs/admin/img
define("DOMAIN_ADMIN_DB_INC_END",                                   DOMAIN_ADMIN_INC_END."db".SLASH,TRUE);                                          //C:/APM_Setup/htdocs/admin/img/
define("DOMAIN_ADMIN_DB_INC_HOME",                                  DOMAIN_ADMIN_DB_INC_END.PAGE_DEFAULT,TRUE);                                     //C:/APM_Setup/htdocs/admin/img/index.php

define("DOMAIN_HERO_DB_INC",                                        DOMAIN_HERO_INC_END."db",TRUE);                                                 //C:/APM_Setup/htdocs/hero/img
define("DOMAIN_HERO_DB_INC_END",                                    DOMAIN_HERO_INC_END."db".SLASH,TRUE);                                           //C:/APM_Setup/htdocs/hero/img/
define("DOMAIN_HERO_DB_INC_HOME",                                   DOMAIN_HERO_DB_INC_END.PAGE_DEFAULT,TRUE);                                      //C:/APM_Setup/htdocs/hero/img/index.php
####################################################################################################################################################
//주로 사용 (IMG_INC_END)
####################################################################################################################################################
define("DB_INC",                                                    HOME_INC_END."db",TRUE);                                                        //C:/APM_Setup/htdocs/기본폴더/img
define("DB_INC_END",                                                HOME_INC_END."db".SLASH,TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/img/
define("DB_INC_HOME",                                               DB_INC_END.PAGE_DEFAULT,TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ADMIN_DB_INC",                                              ADMIN_INC_END."db",TRUE);                                                       //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ADMIN_DB_INC_END",                                          ADMIN_INC_END."db".SLASH,TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ADMIN_DB_INC_HOME",                                         ADMIN_DB_INC_END.PAGE_DEFAULT,TRUE);                                            //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HERO_DB_INC",                                               HERO_INC_END."db",TRUE);                                                        //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HERO_DB_INC_END",                                           HERO_INC_END."db".SLASH,TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HERO_DB_INC_HOME",                                          HERO_DB_INC_END.PAGE_DEFAULT,TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("ROOT_DB_INC",                                               ROOT_INC_END."db",TRUE);                                                        //C:/APM_Setup/htdocs/기본폴더/img
define("ROOT_DB_INC_END",                                           ROOT_INC_END."db".SLASH,TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/img/
define("ROOT_DB_INC_HOME",                                          ROOT_DB_INC_END.PAGE_DEFAULT,TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("ROOT_ADMIN_DB_INC",                                         ADMIN_INC_END."db",TRUE);                                                       //C:/APM_Setup/htdocs/기본폴더/admin/img
define("ROOT_ADMIN_DB_INC_END",                                     ADMIN_INC_END."db".SLASH,TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("ROOT_ADMIN_DB_INC_HOME",                                    ROOT_ADMIN_DB_INC_END.PAGE_DEFAULT,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("ROOT_HERO_DB_INC",                                          HERO_INC_END."db",TRUE);                                                        //C:/APM_Setup/htdocs/기본폴더/hero/img
define("ROOT_HERO_DB_INC_END",                                      HERO_INC_END."db".SLASH,TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("ROOT_HERO_DB_INC_HOME",                                     ROOT_HERO_DB_INC_END.PAGE_DEFAULT,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
define("HOME_DB_INC",                                               HOME_INC_END."db",TRUE);                                                        //C:/APM_Setup/htdocs/기본폴더/img
define("HOME_DB_INC_END",                                           HOME_INC_END."db".SLASH,TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/img/
define("HOME_DB_INC_HOME",                                          HOME_DB_INC_END.PAGE_DEFAULT,TRUE);                                             //C:/APM_Setup/htdocs/기본폴더/img/index.php

define("HOME_ADMIN_DB_INC",                                         ADMIN_INC_END."db",TRUE);                                                       //C:/APM_Setup/htdocs/기본폴더/admin/img
define("HOME_ADMIN_DB_INC_END",                                     ADMIN_INC_END."db".SLASH,TRUE);                                                 //C:/APM_Setup/htdocs/기본폴더/admin/img/
define("HOME_ADMIN_DB_INC_HOME",                                    HOME_ADMIN_DB_INC_END.PAGE_DEFAULT,TRUE);                                       //C:/APM_Setup/htdocs/기본폴더/admin/img/index.php

define("HOME_HERO_DB_INC",                                          HERO_INC_END."db",TRUE);                                                        //C:/APM_Setup/htdocs/기본폴더/hero/img
define("HOME_HERO_DB_INC_END",                                      HERO_INC_END."db".SLASH,TRUE);                                                  //C:/APM_Setup/htdocs/기본폴더/hero/img/
define("HOME_HERO_DB_INC_HOME",                                     HOME_HERO_DB_INC_END.PAGE_DEFAULT,TRUE);                                        //C:/APM_Setup/htdocs/기본폴더/hero/img/index.php
####################################################################################################################################################
//주로 사용 (PATH_IMG_INC_END)
####################################################################################################################################################
define("PATH_DB_INC",                                               PATH_INC_END."db",TRUE);                                                        //C:/APM_Setup/htdocs/현재폴더/img
define("PATH_DB_INC_END",                                           PATH_INC_END."db".SLASH,TRUE);                                                  //C:/APM_Setup/htdocs/현재폴더/img/
define("PATH_DB_INC_HOME",                                          PATH_DB_INC_END.PAGE_DEFAULT,TRUE);                                             //C:/APM_Setup/htdocs/현재폴더/img/index.php

define("PATH_ADMIN_DB_INC",                                         PATH_ADMIN_INC_END."db",TRUE);                                                  //C:/APM_Setup/htdocs/현재폴더/admin/img
define("PATH_ADMIN_DB_INC_END",                                     PATH_ADMIN_INC_END."db".SLASH,TRUE);                                            //C:/APM_Setup/htdocs/현재폴더/admin/img/
define("PATH_ADMIN_DB_INC_HOME",                                    PATH_ADMIN_DB_INC_END.PAGE_DEFAULT,TRUE);                                       //C:/APM_Setup/htdocs/현재폴더/admin/img/index.php

define("PATH_HERO_DB_INC",                                          PATH_HERO_INC_END."db",TRUE);                                                   //C:/APM_Setup/htdocs/현재폴더/hero/img
define("PATH_HERO_DB_INC_END",                                      PATH_HERO_INC_END."db".SLASH,TRUE);                                             //C:/APM_Setup/htdocs/현재폴더/hero/img/
define("PATH_HERO_DB_INC_HOME",                                     PATH_HERO_DB_INC_END.PAGE_DEFAULT,TRUE);                                        //C:/APM_Setup/htdocs/현재폴더/hero/img/index.php
####################################################################################################################################################
$_ATTENDANCEGIFT = 50;

$_GOODS_STOCK_TYPE = array("U"=>"무제한", "N"=>"수량", "O"=>"품절");
$_GOODS_DISPLAY = array("Y"=>"표출", "N"=>"미표출");

$_PROCESS_ORDER = "O";
$_PROCESS_DELIVERY = "D";
$_PROCESS_DECISION = "E";
$_PROCESS_CANCEL = "C";
$_PROCESS_REFUND = "R";
$_PROCESS_REMOVE = "M";
$_GOODS_PROCESS = array($_PROCESS_CANCEL=>"주문취소", $_PROCESS_REFUND=>"환불", $_PROCESS_ORDER=>"배송준비", $_PROCESS_DELIVERY=>"배송중", $_PROCESS_DECISION=>"수령완료", $_PROCESS_REMOVE=>"포인트삭제");


$_DELIVERY_ENTERPRISE = array("한진택배"=>"http://www.hanjin.co.kr/Delivery_html/inquiry/personal_inquiry.jsp", "대한통운"=>"https://www.doortodoor.co.kr/parcel/pa_004.jsp");
$_FAQ_CATEGORY = array("전체","홈페이지 이용", "미션 및 슈퍼패스", "배송", "포인트 및 패널티", "회원정보", "기타");
$_NOTICE_CATEGORY = array("전체", "공지사항", "홈페이지", "미션", "관리자와의 시간");
$_MAIN_COLOR = array("#f68428","#346DF1");
?>