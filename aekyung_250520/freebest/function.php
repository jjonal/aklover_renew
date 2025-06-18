<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
//인코딩
######################################################################################################################################################
// 2023.04.27 sha3 암호화
require_once ('sha3.php');

function sha3_hash($type, $msg)
{
    return sha3::hash_alg($type, $msg);
}

function in($value = null){
    global $out_in;
    $out_in = iconv(OLD_SET, NEW_SET, $value);//OLD_SET = euc-kr//NEW_SET = utf-8
    return $out_in;
}
function out($value = null){
    global $out_in;
    $out_in = iconv(NEW_SET, OLD_SET, $value);//NEW_SET=utf-8 //OLD_SET=euc-kr
    return $out_in;
}

//TODO 운영하고 테스트하고 인코딩 환경이 틀림
function getIconv($value = null) {
    return  iconv('EUC-KR', 'UTF-8', $value); //운영
    //return  $value; //테스트
}

//TODO 운영하고 테스트하고 다름
function getSnsDomain() {
    //return "https://aklover.co.kr"; //운영
    return "https://www.aklover.co.kr"; //운영
    //return "http://www.aklover.co.kr"; //테스트
//    return "http://aklover-test.musign.kr/"; //musign 테스트
}

//예제 : db('디비명을 선택가능');
######################################################################################################################################################
function db($dbname_old = null){
//    include FREEBEST_INC_END.'db_config.php';
    $out_db                                                         = @mysql_connect(HOST_DEFAULT, USER_DEFAULT, PASSWD_DEFAULT) or die('[DB접속실패]<br><a href="javascript:history.go(-1)">뒤로</a>');//mysql_error()
    //mysql_query('set names utf8',$out_db);
    mysql_query('set names euckr',$out_db);
    if(!strcmp($dbname_old, '')){
        @mysql_select_db(DBNAME_DEFAULT, $out_db);
    }else if(!strcmp($dbname_old, 'null')){
    }else{
        @mysql_select_db($dbname_old, $out_db);
    }
}
//설명 : '쿼리입력', 'on은 DB접속/off은 DB종료/end는 on,off를 한번에실행', '디비명을 선택가능'
//예제 : sql('select * from menu', 'on', 'hero');
######################################################################################################################################################
function sql($sql_old, $close_old = null,  $dbname_old = null){
    global $out_sql;
    if(!strcmp($close_old, 'on')){
        db($dbname_old);
        $out_sql                            = @mysql_query($sql_old);
    }else if(!strcmp($close_old, 'off')){
        $out_sql                            = @mysql_query($sql_old);
        @mysql_close();
    }else if(!strcmp($close_old, 'end')){
        db($dbname_old);
        $out_sql                            = @mysql_query($sql_old);
        @mysql_close();
    }else{
        $out_sql                            = mysql_query($sql_old);
    }
    return $out_sql;
}

######################################################################################################################################################
function new_sql($sql_old,$error,$close_old = null){
    if($close_old!=''){
        if(!strcmp($close_old, 'on')){
            db(DBNAME_DEFAULT);
            $out_sql                            = mysql_query($sql_old);
            if(!$out_sql){
                logging_error($_SESSION['temp_code'], $_GET['board']."-".$error."-".$sql_old, date("Y-m-d H:i:s"));
                return $error;
                exit;
            }
        }else if(!strcmp($close_old, 'off')){
            $out_sql                            = mysql_query($sql_old);
            if(!$out_sql){
                logging_error($_SESSION['temp_code'], $_GET['board']."-".$error."-".$sql_old, date("Y-m-d H:i:s"));
                return $error;
                exit;
            }
            @mysql_close();
        }else if(!strcmp($close_old, 'end')){
            db(DBNAME_DEFAULT);
            $out_sql                            = mysql_query($sql_old);
            if(!$out_sql){
                logging_error($_SESSION['temp_code'], $_GET['board']."-".$error."-".$sql_old, date("Y-m-d H:i:s"));
                return $error;
                exit;
            }
            mysql_close();
        }
    }else{
        $out_sql                            = mysql_query($sql_old);
        if(!$out_sql){
            logging_error($_SESSION['temp_code'], $_GET['board']."-".$error."-".$sql_old, date("Y-m-d H:i:s"));
            return $error;
            exit;
        }
    }
    return $out_sql;
}
//str('IMAGE||main||1.ext');
######################################################################################################################################################
function str($str_old = null){
    $data = explode('||', $str_old);
    if(strcmp($data['2'], '')){
        if(!strcmp(eregi('_END',$data['0']),'1')){
            $data_00 = $data['0'];
        }else{
            $data_00 = $data['0'].'_END';
        }
        $data_00 = constant($data_00);
        $data_01 = $data['1'];
        $data_02 = $data['2'];
        $out_str = $data_00.$data_01.'/'.$data_02;

    }else if(strcmp($data['1'], '')){
        if(!strcmp(eregi('_END',$data['0']),'1')){
            $data_00 = $data['0'];
        }else{
            $data_00 = $data['0'].'_END';
        }
        $data_00 = constant($data_00);
        $data_01 = $data['1'];

        $out_str = $data_00.$data_01;
    }else{
        $out_str = $str_old;
    }
    return $out_str;
}
//str('IMAGE||main||1.ext');
######################################################################################################################################################
function str_inc($str_old = null){
    $data = explode('||', $str_old);
    if(strcmp($data['2'], '')){
        if(!strcmp(eregi('_INC_END',$data['0']),'1')){
            $data_00 = $data['0'];
        }else if(!strcmp(eregi('_END',$data['0']),'1')){
            $data_00 = str_replace('_END', '_INC_END', $data['0']);
        }else{
            $data_00 = $data['0'].'_INC_END';
        }
        $data_00 = constant($data_00);
        $data_01 = $data['1'];
        $data_02 = $data['2'];
        $out_str = $data_00.$data_01.'/'.$data_02;

    }else if(strcmp($data['1'], '')){
        if(!strcmp(eregi('_INC_END',$data['0']),'1')){
            $data_00 = $data['0'];
        }else if(!strcmp(eregi('_END',$data['0']),'1')){
            $data_00 = str_replace('_END', '_INC_END', $data['0']);
        }else{
            $data_00 = $data['0'].'_INC_END';
        }
        $data_00 = constant($data_00);
        $data_01 = $data['1'];

        $out_str = $data_00.$data_01;
    }else{
        $out_str = $str_old;
    }
    return $out_str;
}
######################################################################################################################################################
function url($str_old = null){
    $data = explode('||', $str_old);
    if(strcmp($data['1'], '')){
        if(!strcmp(eregi('_HOME',$data['0']),'1')){
            $data_00 = $data['0'];
            $data_00 = constant($data_00);
            $data_01 = $data['1'];
            $data_02 = $data['2'];
            $data_03 = $data['3'];
            $out_str = $data_00.'?'.$data_01.'='.$data_02.$data_03;
        }else if(!strcmp(eregi('_END',$data['0']),'1')){
            $data_00 = $data['0'];
            $data_00 = constant($data_00);
            $data_01 = $data['1'];
            $data_02 = $data['2'];
            $data_03 = $data['3'];
            $data_04 = $data['4'];
            $out_str = $data_00.$data_01.'?'.$data_02.'='.$data_03.$data_04;
        }else{
            $data_00 = $data['0'];
            $data_00 = constant($data_00);
            $data_01 = $data['1'];
            $data_02 = $data['2'];
            $data_03 = $data['3'];
            $data_04 = $data['4'];
            $out_str = $data_00.'/'.$data_01.'?'.$data_02.'='.$data_03.$data_04;
        }
    }else{
        if(strcmp(@constant($data['0']),'')){
            $data_00 = $data['0'];
            $data_00 = constant($data_00);
            $out_str = $data_00;
        }else{
            $out_str = $str_old;
        }
    }
    return $out_str;
}
## 이 미 지 기 능
######################################################################################################################################################
function img($name_old, $alt_old = null, $onclick_old = null, $onclick_next = null, $style_old = null, $tabindex_old = null, $end_old = null, $size_old = null){
    $size                                   = GetImageSize(str_inc($name_old));
    if(!strcmp($alt_old, ''))               $alt = '';
    else                                    $alt = ' alt="'.$alt_old.'"';

    if( (!strcmp($onclick_next, '')) and (strcmp($onclick_old, '')) )		$onclick = ' onclick="'.$onclick_old.'" style="cursor:pointer;"';
    else if( (strcmp($onclick_next, '')) and (strcmp($onclick_old, '')) )   $onclick = ' onclick="location.href=\''.$onclick_old.'\'" style="cursor:pointer;"';

    if(strcmp($style_old, ''))			$style = ' '.$style_old;
    if(strcmp($tabindex_old, ''))		$tabindex = ' tabindex="'.$tabindex_old.'"';
    if(strcmp($end_old, ''))	        $end = ' '.$end_old;
    if(strcmp($size_old, '')){
        $size_new = explode('||', $size_old);
        $size = 'width="'.$size_new['0'].'" height="'.$size_new['1'].'"';
    }else						        $size = $size[3];

    $out_img                                = '<img src="'.str($name_old).'" '.$size.$alt.$onclick.$style.$tabindex.$end.' border="0">';//PHP_EOL;사용시 공간생김exit;
    return $out_img;
}
######################################################################################################################################################
function img2($name_old, $onclick_old = null, $onclick_next = null, $style_old = null, $tabindex_old = null, $end_old = null, $size_old = null){
    global $out_alt;
    $data = explode('||', $name_old);
    $out_alt = $data['3'];
    $size                                   = @GetImageSize(str_inc($name_old));

    if(!strcmp($out_alt, '')){              $alt = '';}
    else{                                   $alt = ' alt="'.$out_alt.'"';}
    if( (!strcmp($onclick_next, '')) and (strcmp($onclick_old, '')) ){
        $onclick = ' onclick="'.$onclick_old.'" style="cursor:pointer;"';}
    else if( (strcmp($onclick_next, '')) and (strcmp($onclick_old, '')) ){
        $onclick = ' onclick="location.href=\''.$onclick_old.'\'" style="cursor:pointer;"';}
    if(strcmp($style_old, '')){             $style = ' '.$style_old;}
    if(strcmp($tabindex_old, '')){$tabindex = ' tabindex="'.$tabindex_old.'"';}
    if(strcmp($end_old, '')){             $end = ' '.$end_old;}
    if(strcmp($size_old, '')){
        $size_new                               = explode('||', $size_old);
        if(!strcmp($size_new['0'], '')){
            $size_00 = '';
        }else{
            $size_00 = 'width="'.$size_new['0'].'"';
        }
        if(!strcmp($size_new['1'], '')){
            $size_01 = '';
        }else{
            $size_01 = 'height="'.$size_new['1'].'"';
        }
        $size = $size_00.$size_01;
    }else{
        $size = $size[3];
    }
    $out_img                                = '<img src="'.str($name_old).'" '.$size.$alt.$onclick.$style.$tabindex.$end.' border="0">';//PHP_EOL;사용시 공간생김exit;
    return $out_img;
}
######################################################################################################################################################
//[          기본,     패치,              alt,             action,             action_next,         스타일시트,         tabindex] 형식이 기초설정입니다.
//=img('admin_logo.png', 'image', '설명', 'action', 'close', '스타일시트', '10', '추가');
//<img src="http://112.159.199.102/image/admin_logo.png" width="216" height="25" alt = "설명" onclick="location.href='action'" style="cursor:pointer;" 스타일시트 tabindex="10" 추가 border="0">
######################################################################################################################################################
//자동 홈페이지 링크
//예졔 : echo home(home, '메인');
######################################################################################################################################################
function home($content, $name_old = null){
    if(!strcmp($name_old, '')){
        $out_home_chang = '/([^\"\'\=\>])(mms|http|HTTP|ftp|FTP|telnet|TELNET)\:\/\/((.[^ \n\<\"\'\,\.]+)+)/';
        $out_home = preg_replace($out_home_chang,"\\1<a href=\\2://\\3>\\2://\\3</a>", " ".$content);

    }else{
        $out_home_chang = '/([^\"\'\=\>])(mms|http|HTTP|ftp|FTP|telnet|TELNET)\:\/\/((.[^ \n\<\"\'\,\.]+)+)/';
        $out_home = preg_replace($out_home_chang,'\\1<a href=\\2://\\3>'.$name_old.'</a>', ' '.$content);

    }
    return $out_home;
}
function href($text){
    $ret = ' ' . $text;
    $ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t<]*)#ise", "'\\1<a href=\"\\2\" >\\2</a>'", $ret);
    $ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r<]*)#ise", "'\\1<a href=\"http://\\2\" >\\2</a>'", $ret);
    $ret = preg_replace("#(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);
    $ret = substr($ret, 1);
    return($ret);
}
######################################################################################################################################################
//자동 이메일 링크
//예제 : echo email('1@1.1', '누구');
######################################################################################################################################################
function email($content, $name_old = null){
    if(!strcmp($name_old, '')){
        $out_email = eregi_replace('([a-z0-9\_\-\.]+)@([a-z0-9\_\-\.]+)', '<a href=mailto:\\1@\\2>\\1@\\2</a>', $content);
    }else{
        $out_email = eregi_replace('([a-z0-9\_\-\.]+)@([a-z0-9\_\-\.]+)', '<a href=mailto:\\1@\\2>'.$name_old.'</a>', $content);
    }
    return $out_email;
}
######################################################################################################################################################
function cut($cut_old = null, $value_old = null, $set_old = null){
    global $out_cut;
    if(!strcmp($value_old, '')){
        $value = '14';
    }else{
        $value = $value_old+4;
    }

    if(!strcmp($set_old, '')){
        $set = OLD_SET;//NEW_SET;
    }else{
        $set = OLD_SET;
    }
    $cut_text = strip_tags($cut_old);
    $cut = mb_strlen($cut_text, $set);

    if($cut > $value){$str_next = '..';}else{$str_next = '';}

    $str = mb_substr($cut_text, 0, $value, $set);
    $out_cut = $str.$str_next;
    return $out_cut;
}
######################################################################################################################################################
//예제 : echo input('passwd', 'qleka', 'class="input_txt" style="width:152px;"', 'dbname', '20', '1', '1', 'password');
//효과 : <input type="password" name="passwd" value="qlqjs" class="input_txt" style="width:152px;" onKeyUp="if(this.value.length >= 20)dbname.focus();" maxlength="20" tabindex="1" readonly>
######################################################################################################################################################
function input($name_old, $value_old = null, $style_old = null, $link_old = null, $max_old = null, $tabindex_old = null, $read_old = null,$type_old = null){
    $name_new                               = explode('||', $name_old);
    $name_one                               = strtolower($name_new['0']);//대문자로
    $name_two                               = strtolower($name_new['1']);//소문자로
    if(!strcmp($name_two,'')){              $name = ' id="'.$name_one.'"';}
    else if(!strcmp($name_two,'all')){      $name = ' id="'.$name_one.'" name="'.$name_one.'"';}
    else{                                   $name = ' name="'.$name_one.'"';}
//------------------------------------------------------------------------------------------------//
    if(strcmp($value_old, '')){             $value = ' value="'.$value_old.'"';}
//------------------------------------------------------------------------------------------------//
    if(strcmp($style_old, '')){             $style = ' '.$style_old;}
    if(strcmp($link_old, '')){              $link = ' onKeyUp="if(this.value.length >= '.$max_old.')'.$link_old.'.focus();" maxlength="'.$max_old.'"';}
    if(strcmp($tabindex_old, '')){          $tabindex = ' tabindex="'.$tabindex_old.'"';}
    if(strcmp($read_old, '')){              $read = " readonly";}
    if(strcmp($type_old, '')){              $type = $type_old;}else{$type = 'text';}

    $out_input = '<input type="'.$type.'"'.$name.$value.$style.$link.$tabindex.$read.'>';//PHP_EOL;사용시 공간생김
    return $out_input;
}
######################################################################################################################################################
//설명 : $_POST['action']값은 insert, update, delete, drop이 들어간다
//예제 : action($_POST['action']);
######################################################################################################################################################
function action($use_no = null){
    global $HTTP_POST_FILES,$out_get,$out_sql;
######################################################################################################################################################
//    $file_data_count = sizeof($HTTP_POST_FILES);
//    $file_data_i = '0';
    while(list($use_key, $use_val) = each($HTTP_POST_FILES)){
        $tem_name = $HTTP_POST_FILES[$use_key]['tmp_name'];
        $file_name = out(Y_m_d_h_i_s.'_'.$HTTP_POST_FILES['hero_file_old']['name']);
        $tem_file = $_POST['hero_file_inc_path'].$file_name;
    }
    reset($HTTP_POST_FILES);
    while(list($use_key, $use_val) = each($HTTP_POST_FILES)){
        $file_all .= $HTTP_POST_FILES[$use_key]['size'];
        if( (!strcmp($_POST['hero_view_old'], 'insert')) or (!strcmp($_POST['hero_view_old'], 'write')) ){
            $sql_one .= $use_key.', hero_file_new,';
            $sql_two .= '\''.$HTTP_POST_FILES[$use_key]['name'].'\', \''.Y_m_d_h_i_s.'_'.$HTTP_POST_FILES[$use_key]['name'].'\', ';
        }else if( (!strcmp($_POST['hero_view_old'], 'update')) or (!strcmp($_POST['hero_view_old'], 'modify')) ){
            $sql_one .= $use_key.' = \''.$HTTP_POST_FILES[$use_key]['name'].'\', hero_file_new = \''.Y_m_d_h_i_s.'_'.$HTTP_POST_FILES[$use_key]['name'].'\', ';
        }
    }
    if(strcmp($file_all, '0')){
        $hero_file_name = out($_POST['hero_file']);
//        @unlink($_POST['hero_file_inc_path'].$hero_file_name);
        @move_uploaded_file($tem_name,$tem_file);
    }else{
        unset($sql_one);
        unset($sql_two);
    }
######################################################################################################################################################
    $use_check = explode('||', in($use_no));
    while(list($use_key, $use_val) = each($use_check)){
        if(!strcmp($use_val, 'hero_view_old')){$action_old=$_POST[$use_val];}
        if(!strcmp($use_val, 'hero_db')){$action_table=$_POST[$use_val];}
        unset($_POST[$use_val]);
    }
######################################################################################################################################################
    $data_count = sizeof($_POST);
    $data_i = '1';
    while(list($post_key, $post_val) = each($_POST)){
        if(!strcmp($post_key, 'hero_idx')){$idx=$post_val;continue;}
        $data_check = $data_count-1;
        if(strcmp($data_check, $data_i)){
            $comma = ', ';
        }else{
            $comma = '';
        }
        if( (!strcmp($action_old, 'insert')) or (!strcmp($action_old, 'write')) ){
            $sql_one .= $post_key.$comma;
            $sql_two .= '\''.$_POST[$post_key].'\''.$comma;
        }else if( (!strcmp($action_old, 'update')) or (!strcmp($action_old, 'modify')) ){
            $sql_one .= $post_key.' = \''.$_POST[$post_key].'\''.$comma;
        }
        $data_i++;
    }
    if( (!strcmp($action_old, 'insert')) or (!strcmp($action_old, 'write')) ){
        $sql = 'INSERT INTO '.$action_table.' ('.$sql_one.') VALUES ('.out($sql_two).');';
    }else if( (!strcmp($action_old, 'update')) or (!strcmp($action_old, 'modify')) ){
        $sql = 'UPDATE '.$action_table.' SET '.out($sql_one).' WHERE hero_idx = \''.$_POST['hero_idx'].'\';';
    }else if( (!strcmp($action_old, 'delete')) or (!strcmp($_GET['view'], 'delete')) ){
        if(strcmp($_POST['hero_idx'], '')){$idx_next = $_POST['hero_idx'];}else{$idx_next = $_GET['idx'];}
######################################################################################################################################################
        $sql = 'select * from board where hero_table = \''.$_GET['board'].'\' and hero_idx=\''.$_GET['idx'].'\';';
        sql($sql, 'on');
        $out_row = mysql_fetch_assoc($out_sql);//mysql_fetch_row
        $drop_file = @constant(@str_replace('_END', '_INC_END', $out_row['hero_file_path'])).$out_row['hero_file_new'];
//        @unlink($drop_file);
        $sql = 'DELETE FROM board WHERE hero_idx = \''.$_GET['idx'].'\';';

//echo        $sql = 'UPDATE '.$action_table.' SET hero_use  = \'1\' WHERE hero_idx = \''.$idx_next.'\';';
    }else if( (!strcmp($action_old, 'drop')) or (!strcmp($_GET['view'], 'drop')) ){
        if(strcmp($_POST['hero_idx'], '')){$idx_next = $_POST['hero_idx'];}else{$idx_next = $_GET['idx'];}

        echo        $sql = 'DELETE FROM '.$action_table.' WHERE hero_idx = \''.$idx_next.'\';';
    }
    sql($sql, 'on');
######################################################################################################################################################
    get('view');
######################################################################################################################################################
    echo '<script>location.href="'.PATH_HOME.'?'.$out_get.'"</script>';
}
######################################################################################################################################################
function action2($use_no = null){
    global $HTTP_POST_FILES,$out_get,$out_sql;
######################################################################################################################################################
//    $file_data_count = sizeof($HTTP_POST_FILES);
//    $file_data_i = '0';
    while(list($use_key, $use_val) = each($HTTP_POST_FILES)){
        $tem_name = $HTTP_POST_FILES[$use_key]['tmp_name'];
        $file_name = out(Y_m_d_h_i_s.'_'.$HTTP_POST_FILES['hero_file_old']['name']);
        $tem_file = $_POST['hero_file_inc_path'].$file_name;
    }
    reset($HTTP_POST_FILES);
    while(list($use_key, $use_val) = each($HTTP_POST_FILES)){
        $file_all .= $HTTP_POST_FILES[$use_key]['size'];
        if( (!strcmp($_POST['hero_view_old'], 'insert')) or (!strcmp($_POST['hero_view_old'], 'write')) ){
            $sql_one .= $use_key.', hero_file_new,';
            $sql_two .= '\''.$HTTP_POST_FILES[$use_key]['name'].'\', \''.Y_m_d_h_i_s.'_'.$HTTP_POST_FILES[$use_key]['name'].'\', ';
        }else if( (!strcmp($_POST['hero_view_old'], 'update')) or (!strcmp($_POST['hero_view_old'], 'modify')) ){
            $sql_one .= $use_key.' = \''.$HTTP_POST_FILES[$use_key]['name'].'\', hero_file_new = \''.Y_m_d_h_i_s.'_'.$HTTP_POST_FILES[$use_key]['name'].'\', ';
        }
    }
    if(strcmp($file_all, '0')){
        $hero_file_name = out($_POST['hero_file']);
//        @unlink($_POST['hero_file_inc_path'].$hero_file_name);
        @move_uploaded_file($tem_name,$tem_file);
    }else{
        unset($sql_one);
        unset($sql_two);
    }
######################################################################################################################################################
    $use_check = explode('||', in($use_no));
    while(list($use_key, $use_val) = each($use_check)){
        if(!strcmp($use_val, 'hero_view_old')){$action_old=$_POST[$use_val];}
        if(!strcmp($use_val, 'hero_db')){$action_table=$_POST[$use_val];}
        unset($_POST[$use_val]);
    }
######################################################################################################################################################
    $data_count = sizeof($_POST);
    $data_i = '1';
    while(list($post_key, $post_val) = each($_POST)){
        if(!strcmp($post_key, 'hero_idx')){$idx=$post_val;continue;}
        $data_check = $data_count-1;
        if(strcmp($data_check, $data_i)){
            $comma = ', ';
        }else{
            $comma = '';
        }
        if( (!strcmp($action_old, 'insert')) or (!strcmp($action_old, 'write')) ){
            $sql_one .= $post_key.$comma;
            $sql_two .= '\''.$_POST[$post_key].'\''.$comma;
        }else if( (!strcmp($action_old, 'update')) or (!strcmp($action_old, 'modify')) ){
            $sql_one .= $post_key.' = \''.$_POST[$post_key].'\''.$comma;
        }
        $data_i++;
    }
    if( (!strcmp($action_old, 'insert')) or (!strcmp($action_old, 'write')) ){
        $sql = 'INSERT INTO '.$action_table.' ('.$sql_one.') VALUES ('.out($sql_two).');';
    }else if( (!strcmp($action_old, 'update')) or (!strcmp($action_old, 'modify')) ){
        $sql = 'UPDATE '.$action_table.' SET '.out($sql_one).' WHERE hero_idx = \''.$_POST['hero_idx'].'\';';
    }else if( (!strcmp($action_old, 'delete')) or (!strcmp($_GET['view'], 'delete')) ){
        if(strcmp($_POST['hero_idx'], '')){$idx_next = $_POST['hero_idx'];}else{$idx_next = $_GET['next_idx'];}
######################################################################################################################################################
        $sql = 'select * from board where hero_table = \''.$_GET['board'].'\' and hero_idx=\''.$_GET['next_idx'].'\';';
        sql($sql, 'on');
        $out_row = mysql_fetch_assoc($out_sql);//mysql_fetch_row
        $drop_file = @constant(@str_replace('_END', '_INC_END', $out_row['hero_file_path'])).$out_row['hero_file_new'];
//        @unlink($drop_file);
        $sql = 'DELETE FROM board WHERE hero_idx = \''.$_GET['next_idx'].'\';';

//echo        $sql = 'UPDATE '.$action_table.' SET hero_use  = \'1\' WHERE hero_idx = \''.$idx_next.'\';';
    }else if( (!strcmp($action_old, 'drop')) or (!strcmp($_GET['view'], 'drop')) ){
        if(strcmp($_POST['hero_idx'], '')){$idx_next = $_POST['hero_idx'];}else{$idx_next = $_GET['next_idx'];}

        echo        $sql = 'DELETE FROM '.$action_table.' WHERE hero_idx = \''.$idx_next.'\';';
    }
    sql($sql, 'on');
######################################################################################################################################################
    get('view');
######################################################################################################################################################
    echo '<script>location.href="'.PATH_HOME.'?'.$out_get.'"</script>';
}
######################################################################################################################################################
function get2($use_no = null,$join_old = null){
    global $out_get;
######################################################################################################################################################
    $use_check = explode('||', in($use_no));
    while(list($use_key, $use_val) = each($use_check)){
        unset($_GET[$use_val]);
    }
######################################################################################################################################################
    reset($_GET);
    $data_count = sizeof($_GET);
    $data_i = '0';
    while(list($get_key, $get_val) = each($_GET)){
        $data_check = $data_count-1;
        if(strcmp($data_check, $data_i)){
            $comma = '&';
        }else{
            $comma = '';
        }
        $out_get .= $get_key.'='.$_GET[$get_key].''.$comma;
        $data_i++;
    }
    if(strcmp($join_old, '')){
        $out_get .= '&'.$join_old;
    }

    return $out_get;
}
######################################################################################################################################################
function page($total,$list,$tail,$page,$next_path){
    global $PHP_SELF;
    $total_page = @ceil($total/$list); // 소수 값 있으면 올림
    if (!$page) $page = 1;
    $page_list = @ceil($page/$tail)-1;
    if($page_list>0){
        // $tail_page  = '     <a href="'.PATH_HOME.'?'.$next_path.'&page=1" ><<</a>'.PHP_EOL;
        $prev_page  = ($page_list-1)*$tail+1;
        $tail_page .= '     <a href="'.PATH_HOME.'?'.$next_path.'&page='.$prev_page.'" ><img src="/img/front/board/page_left.webp" alt="이전 페이지"></a>'.PHP_EOL;
    }
    $page_end=($page_list+1)*$tail;
    if($page_end>$total_page) $page_end=$total_page;
    for($setpage=$page_list*$tail+1;$setpage<=$page_end;$setpage++){
        if($setpage >= 1000) $big_number = 'big_number';
        else $big_number = "";
        if ($setpage==$page){
            $tail_page .= '                            <a href="#" class="current '.$big_number.'">'.$setpage.'</a>'.PHP_EOL;
        }else{
            $tail_page .= '                            <a href="'.PATH_HOME.'?'.$next_path.'&page='.$setpage.'" class="'.$big_number.'">'.$setpage.'</a>'.PHP_EOL;
        }
    }
    if($page_end<$total_page){
        echo PHP_EOL . '</br>';
        $next_page = ($page_list+1)*$tail+1;
        $tail_page .= '     <a href="'.PATH_HOME.'?'.$next_path.'&page='.$next_page.'"><img src="/img/front/board/page_right.webp" alt="다음 페이지"></a>'.PHP_EOL;
        // $tail_page .= '     <a href="'.PATH_HOME.'?'.$next_path.'&page='.$total_page.'" >>></a>'.PHP_EOL;
    }
    return $tail_page;
}
######################################################################################################################################################
function drop($table_old = null,$idx_old = null){
    global $out_get;
    $sql = 'DELETE FROM '.$table_old.' WHERE hero_idx = \''.$idx_old.'\';';
    sql($sql, 'on');
    get('view||idx||next_idx');
    echo '<script>location.href="'.PATH_HOME.'?'.$out_get.'"</script>';
}
function msg($msg = null,$command = null){
    echo '<script language=javascript>alert("'.$msg.'");'.$command.'</script>';
}

## Image LoadJpeg (String $fName);
function LoadImage ($fName) {
    $file_ext = strtolower(substr(strrchr($fName,"."), 1)); //확장자
    switch ($file_ext) {
        case "jpg": case "jpeg":
        $im = @ImageCreateFromJPEG ($fName);
        break;
        case "gif":
            $im = @ImageCreateFromGIF ($fName);
            break;
        case "png":
            $im = @ImageCreateFromPNG ($fName);
            break;
    }
    if (!$im) {
        $im = imagecreatetruecolor (150, 30);
        $bgc = ImageColorAllocate ($im, 255, 255, 255);
        $tc = ImageColorAllocate ($im, 0, 0, 0);
        ImageFilledRectangle ($im, 0, 0, 150, 30, $bgc);
        ImageString ($im, 1, 5, 5, "Error loading $fName", $tc);
    }
    return $im;
}

## Image thumbnail_jpg(String $filepath, int $width, int $height);
function thumbnail($filepath, $width="", $height="") {
    $size=getimagesize($filepath); //원본 이미지사이즈를 구함
    $src_im=LoadImage($filepath);
    //1 소스의 너비가 높이보다 큰 경우

    if($height==null && $width){
        $new_width=$width;
        $new_height = round($new_width*$size[1]/$size[0]);

        $target_width = $new_width;
        $target_height = $new_height;

        $target_x = 0;
        $target_y = 0;

    }
    elseif($width==null && $height){
        $new_height=$height;
        $new_width = round($new_height*$size[0]/$size[1]);

        $target_width = $new_width;
        $target_height = $new_height;

        $target_x = 0;
        $target_y = 0;

    }
    elseif($size[0] >= $size[1]){
        //1-1 소스의 너비가 타겟의 너비보다 작은 경우
        if($size[0] < $width){
            //1-1-1 소스의 높이가 타겟의 높이보다 작은 경우
            if($size[1] < $height){//높이를 살려서 너비를 크롭
                $new_width = round(($size[1] * $width)/$height);
                $new_height= $size[1];

                //crop
                $target_width = round($size[0]*$height/$size[1]);
                $target_height = round($size[1]*$height/$size[1]);

                $target_x = -round(($target_width-$new_width)/2);
                $target_y = 0;

                //1-1-2 소스의 높이가 타겟의 높이보다 크거나 같은 경우
            }else{//너비를 살려서 높이를 크롭
                $new_width = $size[0];
                $new_height=round(($size[0] * $height)/$width);

                $target_width = round($size[0]*$height/$size[1]);
                $target_height = round($size[1]*$height/$size[1]);

                $target_x = -round(($target_width-$new_width)/2);
                $target_y = 0;
            }
            //1-2 소스의 너비가 타겟의 너비보다 크거나 같은 경우
        }else{
            //1-2-1 소스의 높이가 타겟의 높이보다 작은 경우
            if($size[1] < $height){//높이를 살리고 너비를 크롭

                //가로길이가 긴 이미지를 전체보이기 위해
                if($size[1] > 110){
                    $new_width = round(($size[1] * $width)/$height);
                    $new_height= $size[1];

                    $target_width = round($size[0]*$height/$size[1]);
                    $target_height = round($size[1]*$height/$size[1]);

                    $target_x = -round(($target_width-$new_width)/2);
                    $target_y = 0;
                }else{
                    $new_width = $width;
                    $new_height= $height;

                    $target_width = round($size[0]*$width/$size[0]);
                    $target_height = round($size[1]*$width/$size[0]);

                    //단 높이가 $new_height보다 높아야 한다.
                    if($target_width < $new_width){
                        $target_height = $height;
                        $target_width =round($heigt*$size[0]/$size[1]);
                    }
                    $target_x = 0;
                    $target_y = -round(($target_height-$new_height)/2);
                }
                //1-2-2 소스의 높이가 타겟의 높이보다 크거나 같은 경우
            }else{//높이에 맞추어 리사이징, 너비를 크롭
                // Resize
                $new_width = $width;
                $new_height= $height;

                $target_width = round($size[0]*$height/$size[1]);
                $target_height = round($size[1]*$height/$size[1]);

                //단, 너비가 $new_width보다 넓어야 한다.
                if($target_width < $new_width){
                    $target_width = $width;
                    $target_height =round($width*$size[1]/$size[0]);
                }

                $target_x = -round(($target_width-$new_width)/2);
                $target_y = 0;
            }
        }
    }else{//2 소스의 높이가 너비보다 크거나 같은 경우
        //2-1 소스의 너비가 타겟의 너비보다 작은 경우
        if($size[0] < $width){
            //2-1-1 소스의 높이가 타겟의 높이보다 작은 경우
            if($size[1] < $height){//너비를 살리고 높이를 크롭
                $new_width = $size[0];
                $new_height=round(($size[0] * $height)/$width);

                $target_width = round($size[0]*$width/$size[0]);
                $target_height = round($size[1]*$width/$size[0]);

                $target_x = 0;
                $target_y = -round(($target_height-$new_height)/2);
            }else{
                //2-1-2 소스의 높이가 타겟의 높이보다 크거나 같은 경우
                $new_width = $size[0];
                $new_height=round(($size[0] * $height)/$width);

                $target_width = round($size[0]*$width/$size[0]);
                $target_height = round($size[1]*$width/$size[0]);

                $target_x = 0;
                $target_y = -round(($target_height-$new_height)/2);
            }
            //2-2 소스의 너비가 타겟의 너비보다 크거나 같은 경우
        }else{
            //2-2-2 소스의 높이가 타겟의 높이보다 크거나 같은 경우
            // Resize
            $new_width = $width;
            $new_height= $height;

            $target_width = round($size[0]*$width/$size[0]);
            $target_height = round($size[1]*$width/$size[0]);

            //단 높이가 $new_height보다 높아야 한다.
            if($target_height < $new_height){
                $target_height = $height;
                $target_width =round($heigt*$size[0]/$size[1]);
            }
            $target_x = 0;
            $target_y = -round(($target_height-$new_height)/2);
        }
    }

    $thumb = imagecreatetruecolor($new_width,$new_height);
    imagecopyresized($thumb,$src_im, $target_x, $target_y, 0, 0, $target_width, $target_height, $size[0], $size[1]);

    return $thumb;
}

function encrypt ($value){
    return base64_encode($value) ;
}
function decrypt ($value){
    return base64_decode($value) ;
}

function info_mem($nick, $idx, $img){
    if(!strcmp($_SESSION['temp_level'],'0') || $_SESSION['temp_view']==''){
        echo "<img src='".str($img)."'>".$nick;
    }else{
        ?>
        <img src='<?=str($img)?>'><a class="regist cluetip-clicked" rel="/info_mem.php?idx=<?=encrypt ($idx);?>" title="<span><img src='<?=str($img);?>'>&nbsp;&nbsp;<?=$nick;?></span>"><?=$nick;?></a>
        <?php
    }
}

function userPoint($userid, $code){
    global $out_sql;
    //$sql = "select sum(hero_point) as point from point where hero_code='".$code."' and hero_id='".$userid."'";
    $sql = "select hero_point as point from member where hero_code='".$code."' and hero_id = '".$userid."'";
    $sql = out($sql);
    sql($sql, 'on');
    $rs = mysql_fetch_array($out_sql);
    $totalPoint = intval($rs["point"]);

    return $totalPoint;
}

function possiblePoint($userid, $code){
    global $_PROCESS_CANCEL, $_PROCESS_REMOVE;
    $sql = "select sum(hero_point) as point from point where hero_code='".$code."'";// and hero_id='".$userid."'
    $res = mysql_query($sql) or die(mysql_error());
    $rs = mysql_fetch_array($res);
    $totalPoint = intval($rs["point"]);

    $sql = "select sum(hero_order_point) as point from order_main where hero_code='".$code."' and hero_process!='".$_PROCESS_CANCEL."'"; //and hero_process!='".$_PROCESS_REMOVE."'";and hero_id='".$userid."'
    $res = mysql_query($sql) or die(mysql_error());
    $rs = mysql_fetch_array($res);
    $usePoint = intval($rs["point"]);

    $possiblePoint = $totalPoint - $usePoint;

    return $possiblePoint;
}

function del_get($url,$key){
    if ( strpos($url,'?')===false ) return $url;
    list($url,$query) = explode('?',$url);
    $temp = explode('&',$query);
    foreach ( $temp as $k => $v ) if ( substr($v,0,strlen($key)+1)==$key.'=' ) unset($temp[$k]);
    return $url.'?'.implode('&',$temp);
}

//포인트 부여 및 등업기능//테이블, 타입, 글번호, 리뷰번호, 제목, 최대포인트 포함여부, 날짜
######################################################################################################################################################
function pointInsert($board, $hero_type, $old_idx, $review_idx, $title, $include_point, $full_today ){

    $today 			=		substr($full_today,0,10);
    $hero_code 		= 		$_SESSION['temp_code'];
    $id				=		$_SESSION['temp_id'];
    $name			=		$_SESSION['temp_name'];
    $nick			=		$_SESSION['temp_nick'];

    if(!$hero_type || !board || !$include_point || !$full_today){

        logging_error($hero_code,"POINT_WRONG_ACCESS",$full_today);
        return "POINT_WRONG_ACCESS";
        exit;

    }

    // 현재 레벨, 오늘하루 얻은 포인트, 전체 포인트, 하루 최대 포인트, 지금 얻는 포인트를 더해 나온 레벨, board title, board의 글쓸때 주는 포인트
    $today_total_point_sql = "select A.*, B.hero_title, B.hero_write_point, B.hero_rev_point, B.hero_mission_point, B.hero_mission_join, C.hero_point as per_day_point ";
    $today_total_point_sql .= "from (select ifnull(sum(if((left(hero_today,10)='".$today."' and hero_include_maxpoint='Y'), hero_point,'0')),0) as today_sum_point, ifnull(sum(hero_point),0) as total_point from point where hero_code='".$hero_code."' and hero_use=0) as A, hero_group as B, today as C ";
    $today_total_point_sql .= "where B.hero_board='".$board."' and C.hero_type= 'hero_total'";

    $today_total_point_res = mysql_query($today_total_point_sql);


    if(!$today_total_point_res) {
        logging_error($hero_code,$board."-POINT_01 : ".$today_total_point_sql,$full_today);
        return "POINT_01";
        exit;
    }

    $today_total_point = mysql_fetch_assoc($today_total_point_res);

    //현재까지의 전체 포인트
    $total_point 			= $today_total_point['total_point'];
    //하루최대 포인트
    $per_day_point 			= $today_total_point['per_day_point'];
    //오늘 하루 얻은 포인트
    $today_sum_point 		= $today_total_point['today_sum_point'];
    //top_title
    $hero_top_title			= $today_total_point['hero_title'];

    $review_check = 0;

    //하루 최대 포인트보다 작은 경우
    if(($today_sum_point < $per_day_point && $per_day_point!=0) || $include_point=='N' || $hero_type=='attendance'){
        //지금 얻을 포인트
        //댓글
        if($hero_type=='review'){

            $review_point_check_sql = "select ifnull(sum(A.hero_point),0) as today_review_point, B.hero_point as per_day_review_point ";
            $review_point_check_sql .= "from point as A, today as B ";
            $review_point_check_sql .= "where A.hero_type='review' and A.hero_code='".$hero_code."' and left(A.hero_today,10)='".$today."' and A.hero_include_maxpoint='Y' and A.hero_use=0 and B.hero_type='hero_rev' ";
            $review_point_check_res = mysql_query($review_point_check_sql);

            if(!$review_point_check_res) {
                logging_error($hero_code,$board."-POINT_02 : ".$review_point_check_sql, $full_today);
                return "POINT_02";
                exit;
            }

            $review_point_check = mysql_fetch_assoc($review_point_check_res);

            //오늘 댓글로 얻은 포인트
            $today_review_point		= $review_point_check['today_review_point'];
            //댓글 최대 포인트
            $per_day_review_point	= $review_point_check['per_day_review_point'];

            //댓글의 최대 포인트 체크
            //댓글 최대 포인트가 0일 경우(설정이 안되어 있을 경우)
            if($per_day_review_point==0){
                $hero_write_point		= $today_total_point['hero_rev_point'];
                //댓글 최대 포인트가 설정되어 있을 경우
            }elseif($today_review_point < $per_day_review_point){
                if($today_review_point+$today_total_point['hero_rev_point'] > $per_day_review_point)		$hero_write_point 		= $per_day_review_point - $today_review_point;
                else																						$hero_write_point		= $today_total_point['hero_rev_point'];
            }else{
                return 1;
                exit;
            }

            //글쓰기
        }elseif($hero_type=='write')						$hero_write_point 		= $today_total_point['hero_write_point'];

        //리뷰등록
        elseif($hero_type=='mission_write'){
            $hero_write_point 		= $today_total_point['hero_mission_join'];
        }
        //미션신청
        elseif($hero_type=='mission_application'){
            $hero_write_point 		= $today_total_point['hero_mission_point'];

        }elseif($hero_type=='attendance'){

            if($today_sum_point < $per_day_point && $per_day_point!=0)		$hero_write_point 		= 1;
            else															$hero_write_point 		= 0;
            $hero_top_title = "출석체크";

        }else{
            return "Wrong Type";
            exit;
        }

        //지금 얻을 포인트가 0일 경우
        if($hero_write_point==0 && $hero_type!='attendance'){
            return 1;
            exit;
        }

        //지금 얻을 포인트가 하루 최대 포인트에 포함될 경우
        if($include_point=='Y'){

            //얻을 포인트+얻은 포인트가 하루 최대 포인트보다 클 경우
            if($today_sum_point + $hero_write_point  > $per_day_point)					$add_final_point = $per_day_point - $today_sum_point;
            else																		$add_final_point = $hero_write_point;
        }elseif($include_point=='N'){
            $add_final_point = $hero_write_point;
        }

        //입력할 포인트가 0이 아닐 경우
        if($add_final_point!=0 || $hero_type=='attendance'){

            $total_final_point = $total_point + $add_final_point;

            //변할 레벨 체크
            $level_check_sql = "select A.hero_level as future_level, B.hero_level as past_level ";
            $level_check_sql .= "from level as A, member as B ";
            $level_check_sql .= "where ".$total_final_point." between A.hero_point_01 and A.hero_point_02 and B.hero_code='".$hero_code."'";

            $level_check_res = mysql_query($level_check_sql);
            if(!$level_check_res){
                logging_error($hero_code, $board."-POINT_03 : ".$level_check_sql, $full_today);
                return "POINT_03";
                exit;
            }

            $level_check = mysql_fetch_assoc($level_check_res);

            $future_level 	= $level_check['future_level'];
            $past_level 	= $level_check['past_level'];

            //등업이 필요한 경우
            if($future_level>$past_level){

                //등업 조건이 있을 경우//2015년 02월 26일 현재까지 등록된 조건은 없었음.
                /* $level_up_sql = "select * from level_up where hero_number!='0'";
                $out_level_up = mysql_query($level_up_sql) or die(rollbackquery($good_idx,"POINT_02"));

                $out_level_up_count = mysql_num_rows($out_level_up);


                $level_up_ok = 0;
                if(strcmp($out_level_up_count, '0')){

                    while($level_up_list                             = mysql_fetch_assoc($out_level_up)){

                        //등업 조건 1(특정 레벨)
                        if(!strcmp($total_list['member_level'], $level_up_list['hero_level'])){

                            //등업 조건 2(특정 카테고리와 특정 타입(글쓰기, 댓글 등)으로 쌓은 포인트 체크)
                            $check_point_sql = "select count(*) as count from point where hero_table='".$level_up_list['hero_table']."' and hero_type='".$level_up_list['hero_type']."' and hero_code='".$my_code."'";
                            $out_check_point_sql = mysql_query($check_point_sql);
                            $out_check_point_count = @mysql_fetch_assoc($out_check_point_sql);

                            //조건을 만족시키지 못할 경우
                            if($level_up_list['hero_number'] > $out_check_point_count['count'])		$level_up_ok++;

                        }

                    }

                    if(!strcmp($level_up_ok, '0')){

                } */

                $level_up_sql = ", hero_level='".$future_level."', hero_write='".$future_level."', hero_view='".$future_level."', hero_update='".$future_level."', hero_rev='".$future_level."' ";

                $_SESSION['temp_level'] 	= $future_level;
                $_SESSION['temp_write'] 	= $future_level;
                $_SESSION['temp_view'] 		= $future_level;
                $_SESSION['temp_update'] 	= $future_level;
                $_SESSION['temp_rev'] 		= $future_level;
            }


            $idx_sql = "SHOW TABLE STATUS LIKE 'point'";
            $out_idx_sql = mysql_query($idx_sql);
            if(!$out_idx_sql){
                logging_error($code, $board."-POINT_04 : ".$idx_sql, $full_today);
                return "POINT_04";
                exit;
            }
            $idx_list                             = @mysql_fetch_assoc($out_idx_sql);
            $good_idx = $idx_list['Auto_increment'];

            $sql_one_write = "hero_idx, hero_old_idx, hero_mission_idx, hero_review_idx, hero_code, hero_table, hero_type, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today, hero_include_maxpoint";
            $sql_two_write = "".$good_idx.", '".$old_idx."','".$mission_idx."','".$review_idx."','".$hero_code."','".$board."','".$hero_type."', '".$id."', '".$hero_top_title."', '".$title."', '".$name."', '".$nick."', '".$add_final_point."', '".$full_today."','".$include_point."'";
            $sql = "INSERT INTO point (".$sql_one_write.") VALUES (".$sql_two_write.");";

            //echo $sql;
            //exit;

            $pf_point = mysql_query($sql);
            if(!$pf_point)	{
                logging_error($hero_code, $board."-POINT_04 : ".$sql, $full_today);
                return "POINT_04";
                exit;
            }


            if($add_final_point!=0){

                $sql = "UPDATE member SET hero_point='".$total_point."' ".$level_up_sql." WHERE hero_code = '".$hero_code."'";
                //echo $sql;
                $pf_member = mysql_query($sql);
                if(!$pf_member){

                    $rollback_query = "delete from point where hero_code='".$hero_code."' and hero_today='".$full_today."' and hero_idx=".$good_idx."";
                    $pf_temp = mysql_query($rollback_query);
                    if(!$pf_temp)	{
                        logging_error($hero_code, $board."-POINT_06 : ".$rollback_query, $full_today);
                        return "POINT_06";
                    }
                    logging_error($hero_code,$board."-POINT_05 : ".$sql, $full_today);
                    return "POINT_05";
                    exit;
                }
            }

        }
        if(!$level_up_sql){
            return 1;
            exit;
        }
        else{
            return "message:축하합니다. 레벨업되었습니다.";
            exit;
        }
    }

    return 1;
    exit;

}

##한달 출석 개근시 50point 증정기능
######################################################################################################################################################
function attendanceGift($temp_id, $temp_code){

    global $_ATTENDANCEGIFT;
    $firstday_of_month = date('Y-m-d', mktime(0,0,0,date(m),1,date(Y)));
    $lastday_of_month = date('Y-m-d', mktime(0,0,0,date(m)+1,1,date(Y))-1);
    $fulltoday = date("Y-m-d H:i:s");

    //이번달 출석 일수 구하기
    $sql = 'select count(date(hero_today)) as countAttendance from point where hero_table=\''.$_GET['board'].'\' and hero_id=\''.$temp_id.'\' and date(hero_today) >= \''.$firstday_of_month.'\' and date(hero_today) <=\''.$lastday_of_month.'\' order by hero_today asc;';
    //echo $sql;


    $count_attendance_month_temp = mysql_query($sql);
    if(!$count_attendance_month_temp){
        logging_error($temp_code, "ATTENDANCEGIFT_01 : ".$sql, $fulltoday);
        error_historyBack("");
        exit;
    }


    $count_attendance_month = mysql_fetch_array($count_attendance_month_temp);
    $last_day = date('t')-1; //출첵 인서트 전이라 -1

    //뮤자인 S
    //2024-07은 4일 제외
    $muDate = date("Y-m", time());

    if($muDate == '2024-07'){
        $last_day = date('t')-5; //204-07은 4일간 오픈작업으로 서버 닫아서 -5
    }
    //뮤자인 E

    //출석일수와 말일숫자 비교
    if($count_attendance_month[countAttendance]>=$last_day){

        //point 테이블에 50point 부여
        $sql_one_write = 'hero_code, hero_table, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today, hero_use, point_change_chk, hero_ori_today';
        $sql_two_write = "'".$temp_code."','".$_GET['board']."','".$temp_id."','월출석개근','월출석개근','".$_SESSION['temp_name']."','".$_SESSION['temp_nick']."','".$_ATTENDANCEGIFT."','".Ymdhis."', 1,'Y','".Ymdhis."'";

        $sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
        $insert_sql = mysql_query($sql);

        echo "<script>alert('축하합니다. 한달 개근으로 ".$_ATTENDANCEGIFT."point가 지급되었습니다!!')</script>";
    }

}


function logging_error($code, $error_code, $time){
    $error_code = str_replace("'","\"",$error_code);
    $logging_sql = "insert into logging_error (hero_code, hero_sql, hero_today) values ('".$code."', '".$error_code."', '".$time."')";
    $pf = @mysql_query($logging_sql);

}

function error_historyBack($error_message){
    if($error_message){
        echo "<meta charset='EUC-KR'>";
        echo "<script>alert('".$error_message."');history.back(-1);</script>";
        exit;
    }else{
        echo "<meta charset='EUC-KR'>";
        echo "<script>alert('시스템 에러입니다. 다시 시도해 주세요. 같은 현상이 반복될 경우 고객센터에 문의해주세요.');history.back(-1);</script>";
        exit;
    }
}

function error_location($error_message, $location){
    if($error_message){
        echo "<meta charset='EUC-KR'>";
        echo "<script>alert('".$error_message."');location.href='".$location."';</script>";
        exit;
    }else{
        echo "<meta charset='EUC-KR'>";
        echo "<script>alert('시스템 에러입니다. 다시 시도해 주세요. 같은 현상이 반복될 경우 고객센터에 문의해주세요.');location.href='".$location."';</script>";
        exit;
    }
}


//브라우저 체크
function browser_check(){

    if(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0') !== FALSE)			 	$bname = 'MSIE 11';
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 8') !== FALSE)			 		$bname = 'MSIE 8';
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 10') !== FALSE)			 	$bname = 'MSIE 10';
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 9') !== FALSE)			 		$bname = 'MSIE 9';
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7') !== FALSE)			 		$bname = 'MSIE 7';
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6') !== FALSE)			 		$bname = 'MSIE 6';
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE)	 				$bname = 'Chrome';
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE)	 			$bname = 'Firefox';
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE)	 				$bname = 'Safari';
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE)	 				$bname = 'Opera';
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'iphone') !== FALSE || strpos($_SERVER['HTTP_USER_AGENT'], 'ipad')!== FALSE || strpos($_SERVER['HTTP_USER_AGENT'], 'ipod')!== FALSE )	 				$bname = 'appleMobile';
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'android 1') !== FALSE)	 			$bname = 'android 1';
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'android 2') !== FALSE)	 			$bname = 'android 2';
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'android 3') !== FALSE)	 			$bname = 'android 3';
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'android 4') !== FALSE)	 			$bname = 'android 4';
    else																 			$bname = 'Other';

    return $bname;
}

function message($message){
    echo "<meta charset='EUC-KR'>";
    echo "<script>alert('".$message."')</script>";
}

function location($location){
    echo "<script>location.href='".$location."';</script>";
}

function countSuperpass($max){
    if($max>0){
        return ($max*(1/10)>=1)? round($max*(1/10)) : '1';
    }
}

##추천 쿼리
######################################################################################################################################################
function recommand(){

    $board = $_GET['board'];
    $code = $_SESSION['temp_code'];
    $fulltoday = date("Y-m-d H:i:s");
    $idx = $_GET['idx'];

    $recom_sql = "select count(*) as recom_count from hero_recommand where hero_recommand_code = '".$code."' and hero_board_idx = '".$idx."'";
    $recom_res = mysql_query($recom_sql);
    if(!$recom_res){
        logging_error($code, $board."-RECOMMAND_01 : ".$recom_sql, $fulltoday);
        return "RECOMMAND_01";
        exit;
    }
    $recom_rs = mysql_fetch_assoc($recom_res);

    if($recom_rs['recom_count']>0){
        return "message:이 글을 이미 추천하셨습니다."; //중복 추천
        exit;
    }

    $board_recom_sql = "select A.hero_rec, B.* from board as A, member as B where A.hero_idx = '".$idx."' and A.hero_code=B.hero_code";
    $board_recom_res = mysql_query($board_recom_sql);

    if(!$board_recom_res){
        logging_error($code, $board."-RECOMMAND_02 : ".$board_recom_sql, $fulltoday);
        return "RECOMMAND_02";
        exit;
    }

    $board_recom_rs = mysql_fetch_assoc($board_recom_res);

    if($board_recom_rs['hero_code']){

        $idx_sql = "SHOW TABLE STATUS LIKE 'hero_recommand'";

        $out_idx_sql = mysql_query($idx_sql);
        if(!$out_idx_sql){
            logging_error($code, $board."-RECOMMAND_03 : ".$idx_sql, $full_today);
            return "RECOMMAND_03";
            exit;
        }

        $idx_list                             = @mysql_fetch_assoc($out_idx_sql);
        $good_idx = $idx_list['Auto_increment'];

        $hero_url_value = str_ireplace('&type=recommand', '', DOMAIN.URI);

        $sql_one_write = "hero_idx, hero_url, hero_board, hero_board_idx, hero_board_code, hero_board_id, hero_board_nick, hero_board_name, hero_recommand_code, hero_recommand_id, hero_recommand_nick, hero_recommand_name, hero_today";
        $sql_two_write = "".$good_idx.",'".$hero_url_value."', '".$board."', '".$_GET['idx']."', '".$board_recom_rs['hero_code']."', '".$board_recom_rs['hero_id']."', '".$board_recom_rs['hero_nick']."', '".$board_recom_rs['hero_name']."', '".$_SESSION['temp_code']."', '".$_SESSION['temp_id']."', '".$_SESSION['temp_nick']."', '".$_SESSION['temp_name']."', '".$fulltoday."'";
        $hero_recommand_sql = "INSERT INTO hero_recommand (".$sql_one_write.") VALUES (".$sql_two_write.")";

        $hero_recommand_res = mysql_query($hero_recommand_sql);
        if(!$hero_recommand_res){
            logging_error($code, $board."-RECOMMAND_04 : ".$hero_recommand_sql, $full_today);
            return "RECOMMAND_04";
            exit;
        }

        $up_recom = $board_recom_rs['hero_rec']+1;
        $up_member_sql = "UPDATE board SET hero_rec=".$up_recom." WHERE hero_idx = '".$idx."'";
        $up_member_res = mysql_query($up_member_sql);

        if(!$up_member_res){

            $rollbackQuery = "delete from hero_recommand where hero_idx=".$good_idx."";
            $rollbackRes = mysql_query($rollbackQuery);

            if(!$rollbackRes){
                logging_error($code, $board."-RECOMMAND_05 : ".$rollbackQuery, $full_today);
                return "RECOMMAND_05";
                exit;
            }
            logging_error($code, $board."-RECOMMAND_06 : ".$up_member_sql, $full_today);
            return "RECOMMAND_06";
            exit;
        }
        return 1;
        exit;
    }
}

##신고 쿼리
######################################################################################################################################################
function report(){

    $board = $_GET['board'];
    $code = $_SESSION['temp_code'];
    $fulltoday = date("Y-m-d h:i:s");
    $idx = $_GET['idx'];

    $report_sql = "select count(*) as report_count from hero_report where hero_report_code = '".$code."' and hero_board_idx = '".$idx."'";
    $report_res = mysql_query($report_sql);
    if(!$report_res){
        logging_error($code, $board."REPORT-_01 : ".$report_sql, $fulltoday);
        return "REPORT_01";
        exit;
    }
    $report_rs = mysql_fetch_assoc($report_res);

    if($report_rs['report_count']>0){
        return "message:이 글을 이미 신고하셨습니다."; //중복 신고
        exit;
    }

    $board_report_sql = "select A.hero_rec, B.* from board as A, member as B where A.hero_idx = '".$idx."' and A.hero_code=B.hero_code";
    $board_report_res = mysql_query($board_report_sql);

    if(!$board_report_res){
        logging_error($code, $board."-REPORT_02 : ".$board_report_sql, $fulltoday);
        return "REPORT_02";
        exit;
    }

    $board_report_rs = mysql_fetch_assoc($board_report_res);

    if($board_report_rs['hero_code']){

        $idx_sql = "SHOW TABLE STATUS LIKE 'hero_report'";

        $out_idx_sql = mysql_query($idx_sql);
        if(!$out_idx_sql){
            logging_error($code, $board."-REPORT_03 : ".$idx_sql, $full_today);
            return "REPORT_03";
            exit;
        }

        $idx_list                             = @mysql_fetch_assoc($out_idx_sql);

        $good_idx = $idx_list['Auto_increment'];

        $hero_url_value = str_ireplace('&type=report', '', DOMAIN.URI);

        $sql_one_write = "hero_idx, hero_url, hero_board, hero_board_idx, hero_board_code, hero_board_id, hero_board_nick, hero_board_name, hero_report_code, hero_report_id, hero_report_nick, hero_report_name, hero_today";
        $sql_two_write = "".$good_idx.",'".$hero_url_value."', '".$board."', '".$idx."', '".$board_report_rs['hero_code']."', '".$board_report_rs['hero_id']."', '".$board_report_rs['hero_nick']."', '".$board_report_rs['hero_name']."', '".$_SESSION['temp_code']."', '".$_SESSION['temp_id']."', '".$_SESSION['temp_nick']."', '".$_SESSION['temp_name']."', '".$fulltoday."'";
        $hero_report_sql = "INSERT INTO hero_report (".$sql_one_write.") VALUES (".$sql_two_write.")";

        $hero_report_res = mysql_query($hero_report_sql);
        if(!$hero_report_res){
            logging_error($code, $board."-REPORT_04 : ".$hero_report_sql, $full_today);
            return "REPORT_04";
            exit;
        }

        return 1;
        exit;

    }

}

function yoil($getDate,$lang=null,$type=null){
    if($lang==null){
        $yoil = array("일","월","화","수","목","금","토");
        $longYoil = array("일요일","월요일","화요일","수요일","목요일","금요일","토요일");
    }
    elseif($lang=="en"){
        $yoil = array("Sun","Mon","Tues","Wed","Thur","Fri","Sat");
        $longYoil = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
    }
    else{
        return 0;
        exit;
    }
    if($type==null)				$thisYoil = $yoil[date('w',strtotime($getDate))];
    elseif($type=="long")		$thisYoil = $longYoil[date('w',strtotime($getDate))];
    else{
        return 0;
        exit;
    }

    return $thisYoil;
    exit;
}


function filesUploader($pluralFiles){

    $fileNames = array();
    $thumb_path = "/user/file/";
    $fileUrl = $_SERVER["DOCUMENT_ROOT"].$thumb_path;

    //단일 파일일 경우
    if($pluralFiles["tmp_name"]){

        if(!is_uploaded_file($pluralFiles["tmp_name"])){
            return 0;
            exit;
        }
        $fileName = Y_m_d_h_i_s.$pluralFiles["name"];

        if ( !move_uploaded_file($pluralFiles["tmp_name"], $fileUrl.$fileName)){
            return 0;
            exit;
        }

        $fileNames = $fileName;

        //복수 파일일 경우
    }else{
        $countFiles = count($pluralFiles);
        if($countFiles<1){
            return "message:파일이 없습니다.";
            exit;
        }

        foreach ($pluralFiles as $singleFile){
            if(!is_uploaded_file($singleFile["tmp_name"])){
                return 0;
                exit;
            }
            $fileName = Y_m_d_h_i_s.$singleFile["name"];

            if ( !move_uploaded_file($singleFile["tmp_name"], $fileUrl.$fileName)){
                return 0;
                exit;
            }

            array_push($fileNames,$fileName);
        }

    }
    return $fileNames;
    exit;

}

function imageUploader($pluralFiles,$path=null,$mainImg=false){

    $todayYM = date('Y_m');
    $fileNames = array();

    if($path)	$thumb_path = $path;
    else		$thumb_path = "/user/photo/".$todayYM."/";

    $fileUrl = $_SERVER["DOCUMENT_ROOT"].$thumb_path;

    if( !is_dir($fileUrl) ) {
        mkdir($fileUrl,0707,true);
    }

    //단일 파일일 경우
    if(!is_array($pluralFiles["tmp_name"])){
        if(!is_uploaded_file($pluralFiles["tmp_name"])){
            return "message:선택된 파일이 없습니다";
            exit;
        }

        $extention_ch = extension_check($pluralFiles["name"],"image");
        $extention_tf = explode(":",$extention_ch);
        if($extention_tf[0]==0){
            return "message:".$extention_tf[1]."는 유효한 확장자가 아닙니다.";
            exit;
        }

        $fileName = time()."_".$_SESSION['temp_id'].".".$extention_tf[1];
        $image_size = getimagesize($pluralFiles["tmp_name"]);

        if($image_size[0]>=675 && !$mainImg){
            $temp_filename = time().$extention_tf[1];
            $temp_file = $_SERVER["DOCUMENT_ROOT"].$thumb_path.$temp_filename;

            if(!is_dir($_SERVER["DOCUMENT_ROOT"].$thumb_path))	mkdir($_SERVER["DOCUMENT_ROOT"].$thumb_path, 0707);

            if(move_uploaded_file($pluralFiles['tmp_name'], $temp_file)){

                $im = thumbnail($temp_file, 675, null);

                imagejpeg($im, $fileUrl.$fileName, 100);
                imagedestroy($im);
                unlink($temp_file);

            }else{
                echo "0";
                exit;
            }
        }else{
            if ( !move_uploaded_file($pluralFiles["tmp_name"], $fileUrl.$fileName)){
                return 0;
                exit;
            }
        }

        return $fileName;

        //복수 파일일 경우
    }else{
        $countFiles = count($pluralFiles['tmp_name']);

        if($countFiles<1){
            return "message:파일이 없습니다.";
            exit;
        }

        for ($i=0; $countFiles>$i; $i++){
            if(is_uploaded_file($pluralFiles["tmp_name"][$i])){

                $extention_ch = extension_check($pluralFiles["name"][$i],"image");
                $extention_tf = explode(":",$extention_ch);
                if($extention_tf[0]==0){
                    $fileNames[0] = "message:".$extention_tf[1]."는 유효한 확장자가 아닙니다.";
                    return $fileNames;
                    exit;
                }

                $fileName = time()."_".$_SESSION['temp_id']."_".$i.".".$extention_tf[1];

                $image_size = getimagesize($pluralFiles["tmp_name"][$i]);

                if($image_size[0]>=675 && !$mainImg){
                    $temp_filename = time().".".$extention_tf[1];
                    $temp_file = $_SERVER["DOCUMENT_ROOT"].$thumb_path.$temp_filename;

                    if(!is_dir($_SERVER["DOCUMENT_ROOT"].$thumb_path))	mkdir($_SERVER["DOCUMENT_ROOT"].$thumb_path, 0707);

                    if(move_uploaded_file($pluralFiles['tmp_name'][$i], $temp_file)){

                        $im = thumbnail($temp_file, 675, null);

                        imagejpeg($im, $fileUrl.$fileName, 100);
                        imagedestroy($im);
                        unlink($temp_file);

                    }else{
                        echo "0";
                        exit;
                    }
                }else{

                    if ( !move_uploaded_file($pluralFiles["tmp_name"][$i], $fileUrl.$fileName)){
                        $fileNames[0] = 0;
                        return $fileNames;
                        exit;
                    }
                }

                array_push($fileNames,$fileName);
                //파일이 없을 경우 0을 반환
            }else{
                array_push($fileNames,"noFile");
            }
        }
        return $fileNames;

    }
    exit;
}

function extension_check($filename, $type){

    if(filename==''){
        return 0;
        exit;
    }

    switch($type){
        case "image" : 	$extensions=array("jpg","jpeg","png","gif","webp"); break; //뮤자인 webp형식 추가
        case "other" :	$extensions=array("xlsx","xlsm","xlsb","xls","xml","hwp","txt","txt"); break;
        default : 		$extensions=array("not");break;
    }

    if($extensions[0]=='not'){
        return("message:타입이 잘못 설정되어 있습니다.");
        exit;
    }else{

        $filenames = explode(".",$filename);
        $fileExtension = $filenames[count($filenames)-1];
        $fileExtension = strtolower($fileExtension);
        $tf_extension=0;
        foreach($extensions as $extension){
            if($extension == $fileExtension){
                $tf_extension = 1;
                break;
            }
        }
        if($tf_extension==1){
            return "1:".$fileExtension;
        }else{
            return "0:".$fileExtension;;
        }
        exit;
    }

}


function check_blog($blogList){

    $blocked_site = array("facebook", "twitter", "instagram", "kakaoStory","youtu","tv.naver");
    $blocked_site_name = array("페이스북", "트위터", "인스타그램", "카카오스토리", "유튜브", "NAVER TV");

    $unblocked_site = array("blog", "tistory","cafe");
    $unblocked_site_name = array("블로그", "블로그", "카페");

    $total_options = array();
    $blog_options = array();
    $sns_options = array();
    $other_options = array();
    $option_check = 0;
    if($blogTitle){
        $exploded_name = explode("||", $blogTitle);
        $exploded_blog = explode("||", $blogList);

        $i=0;
        foreach($exploded_blog as $blog){
            $option_check = 0;
            if($blog){
                $blog = trim($blog);

                //블로그 체크
                for($j=0; count($unblocked_site)>$j; $j++){
                    if($exploded_name[$i]==$unblocked_site[$j]){
                        array_push($blog_options,$unblocked_site_name[$j]);
                        array_push($blog_options,$blog);
                        $option_check = 1;
                    }
                }

                //sns 체크
                if($option_check==0){
                    for($j=0; count($blocked_site)>$j; $j++){
                        if($exploded_name[$i]==$blocked_site[$j]){
                            array_push($sns_options,$blocked_site_name[$j]);
                            array_push($sns_options,$blog);
                            $option_check = 1;
                        }
                    }
                }

                //기타 체크
                if($option_check==0){
                    array_push($other_options,"기타");
                    array_push($other_options,$blog);
                }
            }
            $i++;
        }


    }else{
        $exploded_blog = explode("http", $blogList);

        $j=0;
        $k=0;
        $y=0;
        foreach($exploded_blog as $blog){
            $option_check = 0;
            //첫번째 값은 공백..
            if($blog){
                $blog = trim($blog);
                if(substr($blog,0,3)=='://' || substr($blog,0,4)=='s://'){

                    $blogExploded = explode("/",$blog);

                    //블로그 체크
                    for($i=0; count($unblocked_site)>$i; $i++){
                        if(strstr(strtolower($blogExploded[2]),strtolower($unblocked_site[$i]))){
                            if($j==0) 	 $number = '';
                            else		 $number = $j;
                            $blog_options[$unblocked_site_name[$i].$number]="http".$blog;
                            $option_check = 1;
                            $j++;
                        }
                    }

                    //sns 체크
                    if($option_check==0){
                        for($i=0; count($blocked_site)>$i; $i++){
                            if($k==0) 	 $number = '';
                            else		 $number = $k;
                            if(strstr(strtolower($blogExploded[2]),strtolower($blocked_site[$i]))){
                                $sns_options[$blocked_site_name[$i].$number]="http".$blog;
                                $option_check = 1;
                                $k++;
                            }
                        }
                    }

                    //기타 체크
                    if($option_check==0){
                        if($y==0) 	 $number = '';
                        else		 $number = $y;
                        $other_options["기타".$number]="http".$blog;
                        $y++;
                    }

                    $option_check=0;
                }
            }
        }
    }

    array_push($total_options,$blog_options);
    array_push($total_options,$sns_options);
    array_push($total_options,$other_options);

    return $total_options;
}

function remove_kr($textData){
    $textData = str_replace(",", "", $textData);
    $textData = preg_replace("/[^\x20-\x7e]/", "", $textData);
    $textData = str_replace("~", "", $textData);
    return $textData;
    exit;
}

function substr_in_array($needle, array $haystack){
    foreach ($haystack as $item) {
        if (strpos($needle, $item)==true) {
            return true;
        }
    }
    return false;
}

//사용자 포인트 등록 160516
//게시판명, 포인트타입, 게시글번호, 미션번호, 댓글번호, 제목, 포인트제한여부
function pointAdd($board, $type, $board_idx, $mission_idx, $review_idx, $title, $include_point) {
    //출석체크 로직 확인해야함
    $error = "pointAdd_01";
    $regdate = date("Y-m-d H:i:s"); //등록일 시간
    $today = substr($regdate,0,10); //금일
    $today_my_point = 20;

    $hero_code = $_SESSION["temp_code"];
    $hero_id = $_SESSION["temp_id"];
    $hero_name = $_SESSION["temp_name"];
    $hero_nick = $_SESSION["temp_nick"];
    $cur_level = $_SESSION["temp_level"];

    $adminYn = false; //레벨9000 이상 등급은 포인트에 따른 레벨변환 없음

    if($cur_level >= 9000) $adminYn = true;

    $plus_point = 0; //획득포인트

    $sql = " SELECT ifnull(sum(hero_point),0) as cur_point FROM point WHERE hero_code = '".$hero_code."' ";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);

    $cur_point = $row["cur_point"]; //현재포인트

    $sql = " SELECT hero_write_point, hero_rev_point, hero_mission_point, hero_mission_join, hero_title FROM hero_group WHERE hero_board='".$board."' ";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);

    //top 타이틀
    $hero_top_title = $row["hero_title"];

    //포인트 점수
    $write_point = $row["hero_write_point"];
    $rev_point = $row["hero_rev_point"];
    $mission_application_point = $row["hero_mission_point"];
    $mission_point = $row["hero_mission_join"];

    //포인트 타입 추가되어야 함
    if($type=="write") { //글쓰기
        $plus_point = $write_point;
    } else if($type=="review") { //댓글
        $plus_point = $rev_point;
    } else if($type=="attendance") { //출석체크
        $plus_point = $write_point;
    } else if($type=="mission_application") { //미션참여하기
        $plus_point = $mission_application_point;
    } else if($type=="mission_write") { //미션리뷰등록
        $plus_point = $mission_point;
    } else if($type=="addInfo"){ //추가정보입력
        $plus_point = 30;
    } else if($type=="firstLogin"){ //첫 로그인
        $plus_point = 1000;
    } else if($type=="first_mission_write"){ //첫 미션리뷰등록
        $plus_point = 2000;
    }

    //제한된 포인트
    if($include_point == "Y") {
        $sql = " SELECT ifnull(sum(hero_point),0) as today_point FROM point WHERE hero_code = '".$hero_code."' and left(hero_ori_today,10) = '".$today."' and hero_include_maxpoint = 'Y' ";

        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        $today_point = $row["today_point"];

        $plus_total_point = $today_point+$plus_point;
        if($plus_total_point >= $today_my_point ) {
            $plus_point = $today_my_point-$today_point;
        }
    }

    $next_point = $cur_point+$plus_point;
    //레벨확인
    $sql = " SELECT hero_level FROM level WHERE hero_point_01 <= '".$next_point."' and  hero_point_02 >= '".$next_point."' ";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $next_level = $row["hero_level"];

    //포인트 입력
    $sql = " INSERT INTO point (hero_code, hero_table, hero_type, hero_old_idx, hero_mission_idx
								  , hero_review_idx, hero_id, hero_top_title, hero_title, hero_name
								  , hero_nick, hero_point, hero_today, hero_include_maxpoint, point_change_chk, hero_ori_today)
						   values ('".$hero_code."','".$board."','".$type."','".$board_idx."','".$mission_idx."' 
						   		  , '".$review_idx."','".$hero_id."','".$hero_top_title."','".$title."','".$hero_name."'
								  , '".$hero_nick."','".$plus_point."','".$regdate."','".$include_point."','Y','".$regdate."') ";

    $result = mysql_query($sql);

    if(!$result) {
        logging_error($hero_code,$board."pointAdd2 : ".$sql,$regdate);
        return 2;
    }

    //회원포인트 변경
    $sql  = " UPDATE member SET hero_point  = '".$next_point."' ";
    $sql .= " WHERE hero_code ='".$hero_code."' ";
    $result = mysql_query($sql);

    if(!$result) {
        logging_error($hero_code,$board."pointAdd3 : ".$sql,$regdate);
        return 2;
    }

    return $result;
}


function pointDel($hero_idx, $board, $type) {
    $temp_hero_code = $_SESSION['temp_code']; //삭제하는 사용자(관리자가 될 수 있음)
    $hero_code = "";

    if(!$hero_idx || !$type) {
        return 0;
        exit;
    }
    $WHERE = "";


    //타입에 따른 사용자 코드(아이디) , 조건
    if($type == "write") { //글쓰기
        $sql = " select hero_code from board where hero_idx = '".$hero_idx."' ";
        $res = sql($sql, 'on');
        $row = mysql_fetch_array($res);

        $hero_code = $row["hero_code"];

        $WHERE = " and hero_table = '".$board."' and hero_type = '".$type."' and hero_old_idx = '".$hero_idx."' ";

    } else if($type == "review") { //댓글
        $sql = " select hero_code from review where hero_idx = '".$hero_idx."' ";
        $res = sql($sql, 'on');
        $row = mysql_fetch_array($res);

        $hero_code = $row["hero_code"];

        $WHERE = " and hero_type = '".$type."' and hero_review_idx = '".$hero_idx."' ";

    } else if($type == "mission_application") { //미션 참여하기 삭제(신청서)
        $sql = " select hero_code from mission_review where hero_idx = '".$hero_idx."' ";
        $res = sql($sql, 'on');
        $row = mysql_fetch_array($res);

        $hero_code = $row["hero_code"];

        $WHERE = " and hero_table = '".$board."' and hero_review_idx = '".$hero_idx."'";

    } else if($type == "mission_write") { //미션 리뷰 삭제
        $sql = " select hero_code from board where hero_idx = '".$hero_idx."' ";
        $res = sql($sql, 'on');
        $row = mysql_fetch_array($res);

        $hero_code = $row["hero_code"];
        $WHERE = " and hero_table = '".$board."' and hero_type = '".$type."' and hero_old_idx = '".$hero_idx."' ";

    } else if($type == "loverStar"){ // 러버스타 취소
        $sql = " select hero_code, hero_01 from board where hero_idx = '".$hero_idx."' ";
        $res = sql($sql, 'on');
        $row = mysql_fetch_array($res);

        $hero_code = $row["hero_code"];
        $WHERE = " and hero_type='".$type."' and hero_old_idx='".$hero_idx."' and hero_mission_idx='".$row['hero_01']."'";

    }

    //중복방지
    $sql = " select count(*) cnt from point where 1 ".$WHERE;

    $res = mysql_query($sql);
    $row = mysql_fetch_array($res);
    $cnt = $row["cnt"];

    if($hero_code && $cnt==1) {
        //포인트 차감 등록
        $pointMinus_insert_sql  = " insert into point (hero_code, hero_table, hero_type, hero_old_idx, hero_mission_idx ";
        $pointMinus_insert_sql .= " , hero_review_idx, hero_id, hero_top_title, hero_title, hero_name ";
        $pointMinus_insert_sql .= " , hero_nick, hero_point , hero_today, hero_recommand, hero_include_maxpoint ";
        $pointMinus_insert_sql .= " , hero_use, point_change_chk, hero_ori_today, edit_hero_code) ";
        $pointMinus_insert_sql .= " select hero_code, hero_table, hero_type, hero_old_idx, hero_mission_idx ";
        $pointMinus_insert_sql .= " , hero_review_idx, hero_id, hero_top_title, hero_title, hero_name ";
        $pointMinus_insert_sql .= " , hero_nick, (-1*hero_point) as hero_point , now(), hero_recommand, hero_include_maxpoint ";
        $pointMinus_insert_sql .= " , hero_use , 'Y', hero_ori_today, '".$temp_hero_code."' ";
        $pointMinus_insert_sql .= "   from point where 1 ".$WHERE." ";

        $pointMinus_insert_res = mysql_query($pointMinus_insert_sql);

        if(!$pointMinus_insert_res) {
            logging_error($temp_hero_code,"-pointDel01 : ".$pointMinus_insert_sql,date("Y-m-d H:i:s"));
            return "pointDel01";
            exit;
        }

        //회원정보 변경
        $memberPoint_change_sql  = " update member set hero_point = (select sum(hero_point) from point where hero_code = '".$hero_code."') ";
        $memberPoint_change_sql .= " where hero_code = '".$hero_code."'";

        $result = mysql_query($memberPoint_change_sql);

        //syslog(LOG_INFO, $result);

        if(!$result) {
            logging_error($temp_hero_code,"-pointDel02 : ".$memberPoint_change_sql,date("Y-m-d H:i:s"));
            return "pointDel02";
            exit;
        }

        return $result;
    }

    return 2;

}

// 160523 관리자 포인트 입력
// 멤버코드, 게시판명, 포인트타입, 게시글번호, 미션번호, 댓글번호, 제목, 이름, 닉네임, 포인트, 포인트제한여부, 포인트+,- 구별 변수(userPoint에서만 사용)
function adminPoint($hero_code, $board, $type, $board_idx, $mission_idx, $review_idx, $hero_id, $title, $hero_name, $hero_nick, $plus_point, $include_point, $userPoint){
    $error = "pointAdd_01";
    $regdate = date("Y-m-d H:i:s"); //등록일 시간
    $today = substr($regdate,0,10); //금일

    // 현재포인트 확인
    $sql = " SELECT ifnull(sum(hero_point),0) as cur_point FROM point WHERE hero_code = '".$hero_code."' ";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);

    $cur_point = $row["cur_point"]; //현재포인트

    if($type == 'togetherPoint'){ //유저관리에서 일괄지급버튼으로 지급
        $hero_top_title = '일괄지급메뉴';
    }else if($type == 'applicationPoint'){ //리뷰어 관리에서 지급
        $hero_top_title = '미션신청인원';
    }else if($type == 'personPoint'){ //유저관리에서 개개인에게 지급
        $hero_top_title = '개인지급메뉴';
    }else if($type == 'loverStar'){ //리뷰관리에서 러버스타 선정하면 포인트 지급
        $hero_top_title = '러버스타';
    }else if($type == 'deliveryPoint'){
        $hero_top_title = '배송비 가용포인트';
    }else if($type == 'user'){
        $hero_top_title = '회원정보';
    }

    if($userPoint == 'minus') $plus_point = -1*$plus_point; //포인트삭제 버튼일 때 포인트음수 만들기
    $next_point = $cur_point+$plus_point;

    //레벨확인
    $sql = " SELECT hero_level FROM level WHERE hero_point_01 <= '".$next_point."' and  hero_point_02 >= '".$next_point."' ";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $next_level = $row["hero_level"];

    //포인트 입력
    $sql = " INSERT INTO point (hero_code, hero_table, hero_type, hero_old_idx, hero_mission_idx
								  , hero_review_idx, hero_id, hero_top_title, hero_title, hero_name
								  , hero_nick, hero_point, hero_today, hero_include_maxpoint, point_change_chk,hero_ori_today)
						   values ('".$hero_code."','".$board."','".$type."','".$board_idx."','".$mission_idx."'
						   		  , '".$review_idx."','".$hero_id."','".$hero_top_title."','".addslashes($title)."','".$hero_name."'
								  , '".$hero_nick."','".$plus_point."','".$regdate."','".$include_point."','Y','".$regdate."') ";

    $result = mysql_query($sql);

    if(!$result) {
        logging_error($hero_code,$board."pointAdd2 : ".$sql,$regdate);
        return 2;
    }

    //회원포인트 변경
    $sql  = " UPDATE member SET hero_point  = '".$next_point."' ";
    $sql .= " WHERE hero_code ='".$hero_code."' ";
    $result = mysql_query($sql);

    if(!$result) {
        logging_error($hero_code,$board."pointAdd3 : ".$sql,$regdate);
        return 2;
    }

    //$txt = autoLevelPoint($hero_code, $next_level);

}

// 160523 관리자 포인트 수정
function adminPointModi($hero_idx, $hero_point){
    $hero_code = $_SESSION["temp_code"];

    $update_sql = "UPDATE point SET hero_point='".$hero_point."'";
    $update_sql .= "WHERE hero_idx='".$hero_idx."'";
    $result = mysql_query($update_sql);

    if(!$result) {
        logging_error($hero_code,$board."pointAdd2 : ".$sql,$regdate);
        return 2;
    }

    // 현재포인트 확인
    $sql = " SELECT ifnull(sum(hero_point),0) as cur_point FROM point WHERE hero_code = '".$hero_code."' ";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $cur_point = $row["cur_point"]; //현재포인트

    //회원포인트 변경
    $sql  = " UPDATE member SET hero_point  = '".$cur_point."' ";
    $sql .= " WHERE hero_code ='".$hero_code."' ";
    $result = mysql_query($sql);

    if(!$result) {
        logging_error($hero_code,$board."pointAdd3 : ".$sql,$regdate);
        return 2;
    }

}

//포인트 리스트에서 내용 함수
//타입, 게시판번호, 미션번호, 리뷰번호, 아이디, 게시판이름, 포인트이름, 포인트
function pointHistoryContent($type, $hero_old_idx, $hero_mission_idx, $hero_review_idx, $hero_id, $hero_top_title, $hero_title, $hero_point, $edit_hero_code){
    //관리자가 리뷰메뉴에서 준 포인트
    if($type == "mission"){
        echo $hero_title;

        //리뷰등록, 삭제
    }else if($type == "mission_write"){
        $sql = "select hero_title from mission where hero_idx='".$hero_mission_idx."'";
        $title_sql = mysql_query($sql);
        $mission_title = @mysql_fetch_assoc($title_sql);

        if(!$edit_hero_code && $hero_point == 0){ //포인트가 0점이고 수정code가 없으면 등록
            echo $hero_top_title." ".$mission_title['hero_title']." "."리뷰 등록";
        }else{
            echo $hero_point > 0 ? $hero_top_title." ".$mission_title['hero_title']." "."리뷰 등록" : $hero_top_title." ".$mission_title['hero_title']." "."리뷰 삭제";
        }

        //미션신청, 삭제
    }else if($type == "mission_application"){
        if(!$edit_hero_code && $hero_point == 0){ //포인트가 0점이고 수정code가 없으면 등록
            echo $hero_top_title." ".$hero_title." "."신청서 등록";
        }else{
            echo $hero_point > 0 ? $hero_top_title." ".$hero_title." "."신청서 등록" : $hero_top_title." ".$hero_title." "."신청서 삭제";
        }

        //게시글 작성, 삭제
    }else if($type == "write"){
        if(!$edit_hero_code && $hero_point == 0){ //포인트가 0점이고 수정code가 없으면 등록
            echo $hero_top_title." "."게시글 등록";
        }else{
            echo $hero_point > 0 ? $hero_top_title." "."게시글 등록" : $hero_top_title." "."게시글 삭제";
        }

        //댓글, 삭제
    }else if($type == "review"){
        if(!$edit_hero_code && $hero_point == 0){ //포인트가 0점이고 수정code가 없으면 등록
            echo $hero_top_title." "."댓글 등록";
        }else{
            echo $hero_point > 0 ? $hero_top_title." "."댓글 등록" : $hero_top_title." "."댓글 삭제";
        }
        //생일축하
    }else if($type == "birth"){
        echo $hero_top_title;

        //출석체크
    }else if($type == "attendance"){
        echo $hero_top_title;

        //관리자가 유저관리에서 회원들에게 일괄적으로 지급한 포인트
    }else if($type == "togetherPoint"){
        echo $hero_title;

        //관리자가 유저관리메뉴에서 개개인으로 지급한 포인트
    }else if($type == "personPoint"){
        echo $hero_title;

        //관리자가 리뷰신청자들에게 일괄적으로 지급한 포인트
    }else if($type == "applicationPoint"){
        echo $hero_title;

        //러버스타 선정, 취소
    }else if($type == "loverStar"){
        echo $hero_point > 0 ? $hero_title." 선정" : $hero_title." 취소";

        //추천인포인트, 장기 미사용자 이벤트
    }else if($type == "member"){
        echo $hero_title;

        //월 개근 포인트, 회원정보추가입력  등등 type없는 것들 ※여기는 수정이 필요함 type을 넣어줘야함
    }else if($type == ""){
        echo $hero_title;

        //추가정보입력 이벤트
    }else if($type == "addInfo"){
        echo $hero_title;

        /***********************과거 기록만있고 새롭게 추가되지않는 타입들***************************/
        //예전 일반 미션, 선물상자, 활동미션
    }else if($type == "step_01"){
        echo $hero_top_title.' '.$hero_title;

        //예전 프리미엄미션, 이벤트
    }else if($type == "view"){
        echo $hero_title;

        //예전 미션
    }else if($type == "action3"){
        echo $hero_top_title.' '.$hero_title;

        //배송비 포인트
    }else if($type == "deliveryPoint"){
        echo $hero_top_title.' '.$hero_title;

        //댓글 포인트 오류로 지급 된 포인트로 추측
    }else if($list['admin'] == "admin"){
        echo $hero_title;
        /*************************************************************************************************/
        //그 이외 type, 50레벨 달성
    }else{
        echo $hero_title;
    }

}

function autoLevelPoint($hero_code, $next_level) {
    $full_today = date("Y-m-d H:i:s");
    $txt = "message:축하합니다! ".$next_level."레벨을 달성하셨습니다.";

    if($next_level == 50) {
        $sql = " SELECT hero_code as temp_code, hero_id as temp_id, hero_nick as hero_nick FROM member WHERE hero_code = '".$hero_code."'";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);

        $level_log_chk = " SELECT * FROM level50_message_log WHERE hero_level=50 AND hero_code='".$row['temp_code']."'" ;
        $level_log_chk_res = mysql_query($level_log_chk);
        $level_log_chk_count = mysql_num_rows($level_log_chk_res);
        //$txt = "message:50레벨 축하포인트 지급 내역이 존재합니다. 축하포인트 미지급됩니다.";

        if($level_log_chk_count < 1) {
            //$txt = "message:50레벨을 달성하셨습니다! 축하포인트로 500P 적립되었습니다.";
            /*
            $insertPoint_50level= "insert into point (hero_code, hero_table, hero_type, hero_old_idx, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today, hero_include_maxpoint, hero_use, point_change_chk, hero_ori_today) ";
            $insertPoint_50level .= "values ('".$row['temp_code']."','member', 'member', '0', '".$row['temp_id']."','50레벨 기념 축하포인트','50레벨 기념 축하포인트','".$row['temp_name']."','".$row['temp_nick']."','500','".$full_today."','N','0','Y','".$full_today."')";

            //500포인트 지급
            $insertPoint_50level_res = new_sql($insertPoint_50level,$error);
            if((string)$insertPoint_50level_res==$error){
                error_historyBack("50레벨 기념 축하포인트 지급 오류입니다. 관리자에게 문의해주세요.");
                exit;
            }
            */

            //쪽지보내기 20190225
            $column_hero_command = "AK LOVER 활동을 열심히 해주셔서 감사드리며,\n";
            $column_hero_command .= "앞으로도 잘 부탁드립니다!\n";
            $column_hero_command .= "▼ 하기의 소스를 입력하여 등록하시면 되는데요~\n\n";
            $column_hero_command .= "&lt;a href=\'https://aklover.co.kr/\' target=\'_blank\'&gt;\n";
            $column_hero_command .= "&lt;img src=\'https://aklover.co.kr/widget_50_level.png\' width=\'170\' height=\'170\' border=\'0\'&gt;\n";
            $column_hero_command .= "&lt;/a&gt;\n\n";
            $column_hero_command .= "위젯 설정 방법은 만나다 소개/문의 > 체험단 참여방법 >\n";
            $column_hero_command .= "위젯 설치 프로세스에서 확인 가능하시며,\n\n";
            $column_hero_command .= "<a href=\'https://www.aklover.co.kr/main/index.php?board=group_04_12&tabNum=2\'>바로확인 하기>></a>\n\n";
            $column_hero_command .= "그럼 오늘도 행복한 하루 보내세요♥";

            $insertMessageSql = " INSERT INTO mail (hero_code, hero_table, hero_title, hero_user ";
            $insertMessageSql .= " , hero_name, hero_nick, hero_today, hero_use, hero_command ) VALUES ";
            $insertMessageSql .= "('admin_2013_09_22','mail','50레벨 달성을 축하드립니다.','".$row['temp_id']."' ";
            $insertMessageSql .= ", '관리자', '관리자',now(),'1', '".$column_hero_command."' ) ";

            $insertPoint_50level_res = new_sql($insertMessageSql,$error);


            $insertLevel_log = "INSERT INTO level50_message_log (hero_code, hero_id, hero_level, hero_today) 
								VALUES ('".$row['temp_code']."', '".$row['temp_id']."', '".$next_level."', now())";
            $insertLevel_log_res = new_sql($insertLevel_log,$error);
            if((string)$insertLevel_log_res==$error){
                error_historyBack("50레벨 LOG ERROR, 관리자에게 문의해주세요.");
                exit;
            }

        }
    }
    return $txt;
}

function deliveryPoint($mission_idx, $hero_id, $hero_code, $hero_name, $hero_nick, $point) {
    $result = true;

    $delivery_sql	= "INSERT INTO order_main (mission_idx, hero_id, hero_code, hero_name, hero_nick, hero_process, hero_order_point, hero_regdate)
						VALUES ({$mission_idx}, '{$hero_id}', '{$hero_code}', '{$hero_name}', '{$hero_nick}', 'DE', {$point}, now())";
    $result = mysql_query($delivery_sql);

    if(!$result) {
        return false;
    }

    return true;
}

//이름 마스킹
function name_masking($name) {
    $val = $name;

    $val_len = mb_strlen($name,"euc-kr");
    if($val_len > 1) {
        $val = mb_substr($name,0,1,"euc-kr")."*".mb_substr($name,2,mb_strlen($name,"euc-kr")-2,"euc-kr");
    } else if($val_len == 1) {
        $val = "*";
    }

    return $val;
}

//연락처 마스킹
function phone_masking($phone) {
    $val = $phone;
    $val_len = strlen($phone);

    if($val_len > 8) {
        $val = substr($phone,0,$val_len-4)."****";
    }

    return $val;
}

//알림톡추가 190605
function memberJoinAlrimTalk($message ,$mobile, $type) {

    if($type == "10002") {
        $lms_message = $message." https://www.aklover.co.kr";
    }

    if($type == "10009") {
        $lms_message = $message." https://www.aklover.co.kr";
    }

    //회원가입 알림 01058727371(차장님)
    //BACKUP_PROCESS_CODE SMS전환 :000,   LMS/MMS 전환 : 001, 전환없음 003

    $sql = " INSERT INTO TSMS_AGENT_MESSAGE (
				SERVICE_SEQNO, SEND_MESSAGE, SUBJECT, BACKUP_MESSAGE, BACKUP_PROCESS_CODE
				, MESSAGE_TYPE, CONTENTS_TYPE, RECEIVE_MOBILE_NO, CALLBACK_NO, JOB_TYPE
				, SEND_RESERVE_DATE, TEMPLATE_CODE, REGISTER_DATE, REGISTER_BY, IMG_ATTACH_FLAG
				, KKO_BTN_NAME, KKO_BTN_URL, KKO_BTN_LINK1, KKO_BTN_LINK2, KKO_BTN_LINK3
				, KKO_BTN_LINK4, KKO_BTN_LINK5
			) VALUES (
				1910032159,
				'".$message."',
				'AKLOVER',
				'".$lms_message."',
				'001', 
				'002',
				'004',
				'".$mobile."',
				'".$mobile."',
				'R00',
				now(),
				'".$type."',
				now(),
				'admin',
				'N',
				'',
				'',
				'',
				'',
				'',
				'',
				''
		)";

    mysql_query($sql);
}

//알림톡추가 관리자 쪽지 발송 20200109
function adminSendAlrimTalk($message ,$mobile, $type, $hero_idx_mail, $hero_id) {


    $lms_message = $message." https://www.aklover.co.kr";


    //회원가입 알림 01058727371(차장님)
    //BACKUP_PROCESS_CODE SMS전환 :000,   LMS/MMS 전환 : 001, 전환없음 003

    $sql = " INSERT INTO TSMS_AGENT_MESSAGE (
				SERVICE_SEQNO, SEND_MESSAGE, SUBJECT, BACKUP_MESSAGE, BACKUP_PROCESS_CODE
				, MESSAGE_TYPE, CONTENTS_TYPE, RECEIVE_MOBILE_NO, CALLBACK_NO, JOB_TYPE
				, SEND_RESERVE_DATE, TEMPLATE_CODE, REGISTER_DATE, REGISTER_BY, IMG_ATTACH_FLAG
				, KKO_BTN_NAME, KKO_BTN_URL, KKO_BTN_LINK1, KKO_BTN_LINK2, KKO_BTN_LINK3
				, KKO_BTN_LINK4, KKO_BTN_LINK5
			) VALUES (
				1910032159,
				'".$message."',
				'".$hero_idx_mail."',
				'".$lms_message."',
				'001',
				'002',
				'004',
				'".$mobile."',
				'02-768-2299',
				'R00',
				now(),
				'".$type."',
				now(),
				'".$hero_id."',
				'N',
				'',
				'',
				'',
				'',
				'',
				'',
				''
		)";

    mysql_query($sql);
}

function sendSmsPassword($password ,$mobile, $hero_id) {


    $message = "<AK LOVER 애경 서포터즈>\n임시비밀번호는 ".$password."\n입니다.";


    //회원가입 알림 01058727371(차장님)
    //BACKUP_PROCESS_CODE SMS전환 :000,   LMS/MMS 전환 : 001, 전환없음 003

    $sql = " INSERT INTO TSMS_AGENT_MESSAGE (
				SERVICE_SEQNO, SEND_MESSAGE, SUBJECT, BACKUP_MESSAGE, BACKUP_PROCESS_CODE
				, MESSAGE_TYPE, CONTENTS_TYPE, RECEIVE_MOBILE_NO, CALLBACK_NO, JOB_TYPE
				, SEND_RESERVE_DATE, TEMPLATE_CODE, REGISTER_DATE, REGISTER_BY, IMG_ATTACH_FLAG
				, KKO_BTN_NAME, KKO_BTN_URL, KKO_BTN_LINK1, KKO_BTN_LINK2, KKO_BTN_LINK3
				, KKO_BTN_LINK4, KKO_BTN_LINK5
			) VALUES (
				1910032159,
				'".$message."',
				'".$message."',
				'".$message."',
				'003',
				'001',
				'S01',
				'".$mobile."',
				'02-768-2299',
				'R00',
				now(),
				'10002',
				now(),
				'".$hero_id."',
				'N',
				'',
				'',
				'',
				'',
				'',
				'',
				''
		)";

    sql($sql,"on");
}

function sendSmsPasswordAuthNumber($authNumber ,$mobile, $hero_id) {
    $message = "<AK LOVER 애경 서포터즈>\n인증코드는 ".$authNumber."\n입니다.";

    $sql = " INSERT INTO TSMS_AGENT_MESSAGE (
				SERVICE_SEQNO, SEND_MESSAGE, SUBJECT, BACKUP_MESSAGE, BACKUP_PROCESS_CODE
				, MESSAGE_TYPE, CONTENTS_TYPE, RECEIVE_MOBILE_NO, CALLBACK_NO, JOB_TYPE
				, SEND_RESERVE_DATE, TEMPLATE_CODE, REGISTER_DATE, REGISTER_BY, IMG_ATTACH_FLAG
				, KKO_BTN_NAME, KKO_BTN_URL, KKO_BTN_LINK1, KKO_BTN_LINK2, KKO_BTN_LINK3
				, KKO_BTN_LINK4, KKO_BTN_LINK5
			) VALUES (
				1910032159,
				'".$message."',
				'".$message."',
				'".$message."',
				'003',
				'001',
				'S01',
				'".$mobile."',
				'02-768-2299',
				'R00',
				now(),
				'10002',
				now(),
				'".$hero_id."',
				'N',
				'',
				'',
				'',
				'',
				'',
				'',
				''
		)";

    sql($sql,"on");
}

//뮤자인 아이피만 노출
function musignEcho($string){
    if($_SERVER['REMOTE_ADDR'] == "121.167.104.240"){
        echo $string;
    }
}

function musignPrint($string){
    if($_SERVER['REMOTE_ADDR'] == "121.167.104.240"){
        echo '<br>';
        print_r($string);
        echo '</br>';
    }
}


?>
