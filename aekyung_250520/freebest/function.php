<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
//���ڵ�
######################################################################################################################################################
// 2023.04.27 sha3 ��ȣȭ
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

//TODO ��ϰ� �׽�Ʈ�ϰ� ���ڵ� ȯ���� Ʋ��
function getIconv($value = null) {
    return  iconv('EUC-KR', 'UTF-8', $value); //�
    //return  $value; //�׽�Ʈ
}

//TODO ��ϰ� �׽�Ʈ�ϰ� �ٸ�
function getSnsDomain() {
    //return "https://aklover.co.kr"; //�
    return "https://www.aklover.co.kr"; //�
    //return "http://www.aklover.co.kr"; //�׽�Ʈ
//    return "http://aklover-test.musign.kr/"; //musign �׽�Ʈ
}

//���� : db('������ ���ð���');
######################################################################################################################################################
function db($dbname_old = null){
//    include FREEBEST_INC_END.'db_config.php';
    $out_db                                                         = @mysql_connect(HOST_DEFAULT, USER_DEFAULT, PASSWD_DEFAULT) or die('[DB���ӽ���]<br><a href="javascript:history.go(-1)">�ڷ�</a>');//mysql_error()
    //mysql_query('set names utf8',$out_db);
    mysql_query('set names euckr',$out_db);
    if(!strcmp($dbname_old, '')){
        @mysql_select_db(DBNAME_DEFAULT, $out_db);
    }else if(!strcmp($dbname_old, 'null')){
    }else{
        @mysql_select_db($dbname_old, $out_db);
    }
}
//���� : '�����Է�', 'on�� DB����/off�� DB����/end�� on,off�� �ѹ�������', '������ ���ð���'
//���� : sql('select * from menu', 'on', 'hero');
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
## �� �� �� �� ��
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

    $out_img                                = '<img src="'.str($name_old).'" '.$size.$alt.$onclick.$style.$tabindex.$end.' border="0">';//PHP_EOL;���� ��������exit;
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
    $out_img                                = '<img src="'.str($name_old).'" '.$size.$alt.$onclick.$style.$tabindex.$end.' border="0">';//PHP_EOL;���� ��������exit;
    return $out_img;
}
######################################################################################################################################################
//[          �⺻,     ��ġ,              alt,             action,             action_next,         ��Ÿ�Ͻ�Ʈ,         tabindex] ������ ���ʼ����Դϴ�.
//=img('admin_logo.png', 'image', '����', 'action', 'close', '��Ÿ�Ͻ�Ʈ', '10', '�߰�');
//<img src="http://112.159.199.102/image/admin_logo.png" width="216" height="25" alt = "����" onclick="location.href='action'" style="cursor:pointer;" ��Ÿ�Ͻ�Ʈ tabindex="10" �߰� border="0">
######################################################################################################################################################
//�ڵ� Ȩ������ ��ũ
//���� : echo home(home, '����');
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
//�ڵ� �̸��� ��ũ
//���� : echo email('1@1.1', '����');
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
//���� : echo input('passwd', 'qleka', 'class="input_txt" style="width:152px;"', 'dbname', '20', '1', '1', 'password');
//ȿ�� : <input type="password" name="passwd" value="qlqjs" class="input_txt" style="width:152px;" onKeyUp="if(this.value.length >= 20)dbname.focus();" maxlength="20" tabindex="1" readonly>
######################################################################################################################################################
function input($name_old, $value_old = null, $style_old = null, $link_old = null, $max_old = null, $tabindex_old = null, $read_old = null,$type_old = null){
    $name_new                               = explode('||', $name_old);
    $name_one                               = strtolower($name_new['0']);//�빮�ڷ�
    $name_two                               = strtolower($name_new['1']);//�ҹ��ڷ�
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

    $out_input = '<input type="'.$type.'"'.$name.$value.$style.$link.$tabindex.$read.'>';//PHP_EOL;���� ��������
    return $out_input;
}
######################################################################################################################################################
//���� : $_POST['action']���� insert, update, delete, drop�� ����
//���� : action($_POST['action']);
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
    $total_page = @ceil($total/$list); // �Ҽ� �� ������ �ø�
    if (!$page) $page = 1;
    $page_list = @ceil($page/$tail)-1;
    if($page_list>0){
        // $tail_page  = '     <a href="'.PATH_HOME.'?'.$next_path.'&page=1" ><<</a>'.PHP_EOL;
        $prev_page  = ($page_list-1)*$tail+1;
        $tail_page .= '     <a href="'.PATH_HOME.'?'.$next_path.'&page='.$prev_page.'" ><img src="/img/front/board/page_left.webp" alt="���� ������"></a>'.PHP_EOL;
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
        $tail_page .= '     <a href="'.PATH_HOME.'?'.$next_path.'&page='.$next_page.'"><img src="/img/front/board/page_right.webp" alt="���� ������"></a>'.PHP_EOL;
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
    $file_ext = strtolower(substr(strrchr($fName,"."), 1)); //Ȯ����
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
    $size=getimagesize($filepath); //���� �̹�������� ����
    $src_im=LoadImage($filepath);
    //1 �ҽ��� �ʺ� ���̺��� ū ���

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
        //1-1 �ҽ��� �ʺ� Ÿ���� �ʺ񺸴� ���� ���
        if($size[0] < $width){
            //1-1-1 �ҽ��� ���̰� Ÿ���� ���̺��� ���� ���
            if($size[1] < $height){//���̸� ����� �ʺ� ũ��
                $new_width = round(($size[1] * $width)/$height);
                $new_height= $size[1];

                //crop
                $target_width = round($size[0]*$height/$size[1]);
                $target_height = round($size[1]*$height/$size[1]);

                $target_x = -round(($target_width-$new_width)/2);
                $target_y = 0;

                //1-1-2 �ҽ��� ���̰� Ÿ���� ���̺��� ũ�ų� ���� ���
            }else{//�ʺ� ����� ���̸� ũ��
                $new_width = $size[0];
                $new_height=round(($size[0] * $height)/$width);

                $target_width = round($size[0]*$height/$size[1]);
                $target_height = round($size[1]*$height/$size[1]);

                $target_x = -round(($target_width-$new_width)/2);
                $target_y = 0;
            }
            //1-2 �ҽ��� �ʺ� Ÿ���� �ʺ񺸴� ũ�ų� ���� ���
        }else{
            //1-2-1 �ҽ��� ���̰� Ÿ���� ���̺��� ���� ���
            if($size[1] < $height){//���̸� �츮�� �ʺ� ũ��

                //���α��̰� �� �̹����� ��ü���̱� ����
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

                    //�� ���̰� $new_height���� ���ƾ� �Ѵ�.
                    if($target_width < $new_width){
                        $target_height = $height;
                        $target_width =round($heigt*$size[0]/$size[1]);
                    }
                    $target_x = 0;
                    $target_y = -round(($target_height-$new_height)/2);
                }
                //1-2-2 �ҽ��� ���̰� Ÿ���� ���̺��� ũ�ų� ���� ���
            }else{//���̿� ���߾� ������¡, �ʺ� ũ��
                // Resize
                $new_width = $width;
                $new_height= $height;

                $target_width = round($size[0]*$height/$size[1]);
                $target_height = round($size[1]*$height/$size[1]);

                //��, �ʺ� $new_width���� �о�� �Ѵ�.
                if($target_width < $new_width){
                    $target_width = $width;
                    $target_height =round($width*$size[1]/$size[0]);
                }

                $target_x = -round(($target_width-$new_width)/2);
                $target_y = 0;
            }
        }
    }else{//2 �ҽ��� ���̰� �ʺ񺸴� ũ�ų� ���� ���
        //2-1 �ҽ��� �ʺ� Ÿ���� �ʺ񺸴� ���� ���
        if($size[0] < $width){
            //2-1-1 �ҽ��� ���̰� Ÿ���� ���̺��� ���� ���
            if($size[1] < $height){//�ʺ� �츮�� ���̸� ũ��
                $new_width = $size[0];
                $new_height=round(($size[0] * $height)/$width);

                $target_width = round($size[0]*$width/$size[0]);
                $target_height = round($size[1]*$width/$size[0]);

                $target_x = 0;
                $target_y = -round(($target_height-$new_height)/2);
            }else{
                //2-1-2 �ҽ��� ���̰� Ÿ���� ���̺��� ũ�ų� ���� ���
                $new_width = $size[0];
                $new_height=round(($size[0] * $height)/$width);

                $target_width = round($size[0]*$width/$size[0]);
                $target_height = round($size[1]*$width/$size[0]);

                $target_x = 0;
                $target_y = -round(($target_height-$new_height)/2);
            }
            //2-2 �ҽ��� �ʺ� Ÿ���� �ʺ񺸴� ũ�ų� ���� ���
        }else{
            //2-2-2 �ҽ��� ���̰� Ÿ���� ���̺��� ũ�ų� ���� ���
            // Resize
            $new_width = $width;
            $new_height= $height;

            $target_width = round($size[0]*$width/$size[0]);
            $target_height = round($size[1]*$width/$size[0]);

            //�� ���̰� $new_height���� ���ƾ� �Ѵ�.
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

//����Ʈ �ο� �� ������//���̺�, Ÿ��, �۹�ȣ, �����ȣ, ����, �ִ�����Ʈ ���Կ���, ��¥
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

    // ���� ����, �����Ϸ� ���� ����Ʈ, ��ü ����Ʈ, �Ϸ� �ִ� ����Ʈ, ���� ��� ����Ʈ�� ���� ���� ����, board title, board�� �۾��� �ִ� ����Ʈ
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

    //��������� ��ü ����Ʈ
    $total_point 			= $today_total_point['total_point'];
    //�Ϸ��ִ� ����Ʈ
    $per_day_point 			= $today_total_point['per_day_point'];
    //���� �Ϸ� ���� ����Ʈ
    $today_sum_point 		= $today_total_point['today_sum_point'];
    //top_title
    $hero_top_title			= $today_total_point['hero_title'];

    $review_check = 0;

    //�Ϸ� �ִ� ����Ʈ���� ���� ���
    if(($today_sum_point < $per_day_point && $per_day_point!=0) || $include_point=='N' || $hero_type=='attendance'){
        //���� ���� ����Ʈ
        //���
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

            //���� ��۷� ���� ����Ʈ
            $today_review_point		= $review_point_check['today_review_point'];
            //��� �ִ� ����Ʈ
            $per_day_review_point	= $review_point_check['per_day_review_point'];

            //����� �ִ� ����Ʈ üũ
            //��� �ִ� ����Ʈ�� 0�� ���(������ �ȵǾ� ���� ���)
            if($per_day_review_point==0){
                $hero_write_point		= $today_total_point['hero_rev_point'];
                //��� �ִ� ����Ʈ�� �����Ǿ� ���� ���
            }elseif($today_review_point < $per_day_review_point){
                if($today_review_point+$today_total_point['hero_rev_point'] > $per_day_review_point)		$hero_write_point 		= $per_day_review_point - $today_review_point;
                else																						$hero_write_point		= $today_total_point['hero_rev_point'];
            }else{
                return 1;
                exit;
            }

            //�۾���
        }elseif($hero_type=='write')						$hero_write_point 		= $today_total_point['hero_write_point'];

        //������
        elseif($hero_type=='mission_write'){
            $hero_write_point 		= $today_total_point['hero_mission_join'];
        }
        //�̼ǽ�û
        elseif($hero_type=='mission_application'){
            $hero_write_point 		= $today_total_point['hero_mission_point'];

        }elseif($hero_type=='attendance'){

            if($today_sum_point < $per_day_point && $per_day_point!=0)		$hero_write_point 		= 1;
            else															$hero_write_point 		= 0;
            $hero_top_title = "�⼮üũ";

        }else{
            return "Wrong Type";
            exit;
        }

        //���� ���� ����Ʈ�� 0�� ���
        if($hero_write_point==0 && $hero_type!='attendance'){
            return 1;
            exit;
        }

        //���� ���� ����Ʈ�� �Ϸ� �ִ� ����Ʈ�� ���Ե� ���
        if($include_point=='Y'){

            //���� ����Ʈ+���� ����Ʈ�� �Ϸ� �ִ� ����Ʈ���� Ŭ ���
            if($today_sum_point + $hero_write_point  > $per_day_point)					$add_final_point = $per_day_point - $today_sum_point;
            else																		$add_final_point = $hero_write_point;
        }elseif($include_point=='N'){
            $add_final_point = $hero_write_point;
        }

        //�Է��� ����Ʈ�� 0�� �ƴ� ���
        if($add_final_point!=0 || $hero_type=='attendance'){

            $total_final_point = $total_point + $add_final_point;

            //���� ���� üũ
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

            //����� �ʿ��� ���
            if($future_level>$past_level){

                //��� ������ ���� ���//2015�� 02�� 26�� ������� ��ϵ� ������ ������.
                /* $level_up_sql = "select * from level_up where hero_number!='0'";
                $out_level_up = mysql_query($level_up_sql) or die(rollbackquery($good_idx,"POINT_02"));

                $out_level_up_count = mysql_num_rows($out_level_up);


                $level_up_ok = 0;
                if(strcmp($out_level_up_count, '0')){

                    while($level_up_list                             = mysql_fetch_assoc($out_level_up)){

                        //��� ���� 1(Ư�� ����)
                        if(!strcmp($total_list['member_level'], $level_up_list['hero_level'])){

                            //��� ���� 2(Ư�� ī�װ��� Ư�� Ÿ��(�۾���, ��� ��)���� ���� ����Ʈ üũ)
                            $check_point_sql = "select count(*) as count from point where hero_table='".$level_up_list['hero_table']."' and hero_type='".$level_up_list['hero_type']."' and hero_code='".$my_code."'";
                            $out_check_point_sql = mysql_query($check_point_sql);
                            $out_check_point_count = @mysql_fetch_assoc($out_check_point_sql);

                            //������ ������Ű�� ���� ���
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
            return "message:�����մϴ�. �������Ǿ����ϴ�.";
            exit;
        }
    }

    return 1;
    exit;

}

##�Ѵ� �⼮ ���ٽ� 50point �������
######################################################################################################################################################
function attendanceGift($temp_id, $temp_code){

    global $_ATTENDANCEGIFT;
    $firstday_of_month = date('Y-m-d', mktime(0,0,0,date(m),1,date(Y)));
    $lastday_of_month = date('Y-m-d', mktime(0,0,0,date(m)+1,1,date(Y))-1);
    $fulltoday = date("Y-m-d H:i:s");

    //�̹��� �⼮ �ϼ� ���ϱ�
    $sql = 'select count(date(hero_today)) as countAttendance from point where hero_table=\''.$_GET['board'].'\' and hero_id=\''.$temp_id.'\' and date(hero_today) >= \''.$firstday_of_month.'\' and date(hero_today) <=\''.$lastday_of_month.'\' order by hero_today asc;';
    //echo $sql;


    $count_attendance_month_temp = mysql_query($sql);
    if(!$count_attendance_month_temp){
        logging_error($temp_code, "ATTENDANCEGIFT_01 : ".$sql, $fulltoday);
        error_historyBack("");
        exit;
    }


    $count_attendance_month = mysql_fetch_array($count_attendance_month_temp);
    $last_day = date('t')-1; //��ý �μ�Ʈ ���̶� -1

    //������ S
    //2024-07�� 4�� ����
    $muDate = date("Y-m", time());

    if($muDate == '2024-07'){
        $last_day = date('t')-5; //204-07�� 4�ϰ� �����۾����� ���� �ݾƼ� -5
    }
    //������ E

    //�⼮�ϼ��� ���ϼ��� ��
    if($count_attendance_month[countAttendance]>=$last_day){

        //point ���̺� 50point �ο�
        $sql_one_write = 'hero_code, hero_table, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today, hero_use, point_change_chk, hero_ori_today';
        $sql_two_write = "'".$temp_code."','".$_GET['board']."','".$temp_id."','���⼮����','���⼮����','".$_SESSION['temp_name']."','".$_SESSION['temp_nick']."','".$_ATTENDANCEGIFT."','".Ymdhis."', 1,'Y','".Ymdhis."'";

        $sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
        $insert_sql = mysql_query($sql);

        echo "<script>alert('�����մϴ�. �Ѵ� �������� ".$_ATTENDANCEGIFT."point�� ���޵Ǿ����ϴ�!!')</script>";
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
        echo "<script>alert('�ý��� �����Դϴ�. �ٽ� �õ��� �ּ���. ���� ������ �ݺ��� ��� �����Ϳ� �������ּ���.');history.back(-1);</script>";
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
        echo "<script>alert('�ý��� �����Դϴ�. �ٽ� �õ��� �ּ���. ���� ������ �ݺ��� ��� �����Ϳ� �������ּ���.');location.href='".$location."';</script>";
        exit;
    }
}


//������ üũ
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

##��õ ����
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
        return "message:�� ���� �̹� ��õ�ϼ̽��ϴ�."; //�ߺ� ��õ
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

##�Ű� ����
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
        return "message:�� ���� �̹� �Ű��ϼ̽��ϴ�."; //�ߺ� �Ű�
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
        $yoil = array("��","��","ȭ","��","��","��","��");
        $longYoil = array("�Ͽ���","������","ȭ����","������","�����","�ݿ���","�����");
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

    //���� ������ ���
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

        //���� ������ ���
    }else{
        $countFiles = count($pluralFiles);
        if($countFiles<1){
            return "message:������ �����ϴ�.";
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

    //���� ������ ���
    if(!is_array($pluralFiles["tmp_name"])){
        if(!is_uploaded_file($pluralFiles["tmp_name"])){
            return "message:���õ� ������ �����ϴ�";
            exit;
        }

        $extention_ch = extension_check($pluralFiles["name"],"image");
        $extention_tf = explode(":",$extention_ch);
        if($extention_tf[0]==0){
            return "message:".$extention_tf[1]."�� ��ȿ�� Ȯ���ڰ� �ƴմϴ�.";
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

        //���� ������ ���
    }else{
        $countFiles = count($pluralFiles['tmp_name']);

        if($countFiles<1){
            return "message:������ �����ϴ�.";
            exit;
        }

        for ($i=0; $countFiles>$i; $i++){
            if(is_uploaded_file($pluralFiles["tmp_name"][$i])){

                $extention_ch = extension_check($pluralFiles["name"][$i],"image");
                $extention_tf = explode(":",$extention_ch);
                if($extention_tf[0]==0){
                    $fileNames[0] = "message:".$extention_tf[1]."�� ��ȿ�� Ȯ���ڰ� �ƴմϴ�.";
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
                //������ ���� ��� 0�� ��ȯ
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
        case "image" : 	$extensions=array("jpg","jpeg","png","gif","webp"); break; //������ webp���� �߰�
        case "other" :	$extensions=array("xlsx","xlsm","xlsb","xls","xml","hwp","txt","txt"); break;
        default : 		$extensions=array("not");break;
    }

    if($extensions[0]=='not'){
        return("message:Ÿ���� �߸� �����Ǿ� �ֽ��ϴ�.");
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
    $blocked_site_name = array("���̽���", "Ʈ����", "�ν�Ÿ�׷�", "īī�����丮", "��Ʃ��", "NAVER TV");

    $unblocked_site = array("blog", "tistory","cafe");
    $unblocked_site_name = array("��α�", "��α�", "ī��");

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

                //��α� üũ
                for($j=0; count($unblocked_site)>$j; $j++){
                    if($exploded_name[$i]==$unblocked_site[$j]){
                        array_push($blog_options,$unblocked_site_name[$j]);
                        array_push($blog_options,$blog);
                        $option_check = 1;
                    }
                }

                //sns üũ
                if($option_check==0){
                    for($j=0; count($blocked_site)>$j; $j++){
                        if($exploded_name[$i]==$blocked_site[$j]){
                            array_push($sns_options,$blocked_site_name[$j]);
                            array_push($sns_options,$blog);
                            $option_check = 1;
                        }
                    }
                }

                //��Ÿ üũ
                if($option_check==0){
                    array_push($other_options,"��Ÿ");
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
            //ù��° ���� ����..
            if($blog){
                $blog = trim($blog);
                if(substr($blog,0,3)=='://' || substr($blog,0,4)=='s://'){

                    $blogExploded = explode("/",$blog);

                    //��α� üũ
                    for($i=0; count($unblocked_site)>$i; $i++){
                        if(strstr(strtolower($blogExploded[2]),strtolower($unblocked_site[$i]))){
                            if($j==0) 	 $number = '';
                            else		 $number = $j;
                            $blog_options[$unblocked_site_name[$i].$number]="http".$blog;
                            $option_check = 1;
                            $j++;
                        }
                    }

                    //sns üũ
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

                    //��Ÿ üũ
                    if($option_check==0){
                        if($y==0) 	 $number = '';
                        else		 $number = $y;
                        $other_options["��Ÿ".$number]="http".$blog;
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

//����� ����Ʈ ��� 160516
//�Խ��Ǹ�, ����ƮŸ��, �Խñ۹�ȣ, �̼ǹ�ȣ, ��۹�ȣ, ����, ����Ʈ���ѿ���
function pointAdd($board, $type, $board_idx, $mission_idx, $review_idx, $title, $include_point) {
    //�⼮üũ ���� Ȯ���ؾ���
    $error = "pointAdd_01";
    $regdate = date("Y-m-d H:i:s"); //����� �ð�
    $today = substr($regdate,0,10); //����
    $today_my_point = 20;

    $hero_code = $_SESSION["temp_code"];
    $hero_id = $_SESSION["temp_id"];
    $hero_name = $_SESSION["temp_name"];
    $hero_nick = $_SESSION["temp_nick"];
    $cur_level = $_SESSION["temp_level"];

    $adminYn = false; //����9000 �̻� ����� ����Ʈ�� ���� ������ȯ ����

    if($cur_level >= 9000) $adminYn = true;

    $plus_point = 0; //ȹ������Ʈ

    $sql = " SELECT ifnull(sum(hero_point),0) as cur_point FROM point WHERE hero_code = '".$hero_code."' ";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);

    $cur_point = $row["cur_point"]; //��������Ʈ

    $sql = " SELECT hero_write_point, hero_rev_point, hero_mission_point, hero_mission_join, hero_title FROM hero_group WHERE hero_board='".$board."' ";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);

    //top Ÿ��Ʋ
    $hero_top_title = $row["hero_title"];

    //����Ʈ ����
    $write_point = $row["hero_write_point"];
    $rev_point = $row["hero_rev_point"];
    $mission_application_point = $row["hero_mission_point"];
    $mission_point = $row["hero_mission_join"];

    //����Ʈ Ÿ�� �߰��Ǿ�� ��
    if($type=="write") { //�۾���
        $plus_point = $write_point;
    } else if($type=="review") { //���
        $plus_point = $rev_point;
    } else if($type=="attendance") { //�⼮üũ
        $plus_point = $write_point;
    } else if($type=="mission_application") { //�̼������ϱ�
        $plus_point = $mission_application_point;
    } else if($type=="mission_write") { //�̼Ǹ�����
        $plus_point = $mission_point;
    } else if($type=="addInfo"){ //�߰������Է�
        $plus_point = 30;
    } else if($type=="firstLogin"){ //ù �α���
        $plus_point = 1000;
    } else if($type=="first_mission_write"){ //ù �̼Ǹ�����
        $plus_point = 2000;
    }

    //���ѵ� ����Ʈ
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
    //����Ȯ��
    $sql = " SELECT hero_level FROM level WHERE hero_point_01 <= '".$next_point."' and  hero_point_02 >= '".$next_point."' ";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $next_level = $row["hero_level"];

    //����Ʈ �Է�
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

    //ȸ������Ʈ ����
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
    $temp_hero_code = $_SESSION['temp_code']; //�����ϴ� �����(�����ڰ� �� �� ����)
    $hero_code = "";

    if(!$hero_idx || !$type) {
        return 0;
        exit;
    }
    $WHERE = "";


    //Ÿ�Կ� ���� ����� �ڵ�(���̵�) , ����
    if($type == "write") { //�۾���
        $sql = " select hero_code from board where hero_idx = '".$hero_idx."' ";
        $res = sql($sql, 'on');
        $row = mysql_fetch_array($res);

        $hero_code = $row["hero_code"];

        $WHERE = " and hero_table = '".$board."' and hero_type = '".$type."' and hero_old_idx = '".$hero_idx."' ";

    } else if($type == "review") { //���
        $sql = " select hero_code from review where hero_idx = '".$hero_idx."' ";
        $res = sql($sql, 'on');
        $row = mysql_fetch_array($res);

        $hero_code = $row["hero_code"];

        $WHERE = " and hero_type = '".$type."' and hero_review_idx = '".$hero_idx."' ";

    } else if($type == "mission_application") { //�̼� �����ϱ� ����(��û��)
        $sql = " select hero_code from mission_review where hero_idx = '".$hero_idx."' ";
        $res = sql($sql, 'on');
        $row = mysql_fetch_array($res);

        $hero_code = $row["hero_code"];

        $WHERE = " and hero_table = '".$board."' and hero_review_idx = '".$hero_idx."'";

    } else if($type == "mission_write") { //�̼� ���� ����
        $sql = " select hero_code from board where hero_idx = '".$hero_idx."' ";
        $res = sql($sql, 'on');
        $row = mysql_fetch_array($res);

        $hero_code = $row["hero_code"];
        $WHERE = " and hero_table = '".$board."' and hero_type = '".$type."' and hero_old_idx = '".$hero_idx."' ";

    } else if($type == "loverStar"){ // ������Ÿ ���
        $sql = " select hero_code, hero_01 from board where hero_idx = '".$hero_idx."' ";
        $res = sql($sql, 'on');
        $row = mysql_fetch_array($res);

        $hero_code = $row["hero_code"];
        $WHERE = " and hero_type='".$type."' and hero_old_idx='".$hero_idx."' and hero_mission_idx='".$row['hero_01']."'";

    }

    //�ߺ�����
    $sql = " select count(*) cnt from point where 1 ".$WHERE;

    $res = mysql_query($sql);
    $row = mysql_fetch_array($res);
    $cnt = $row["cnt"];

    if($hero_code && $cnt==1) {
        //����Ʈ ���� ���
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

        //ȸ������ ����
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

// 160523 ������ ����Ʈ �Է�
// ����ڵ�, �Խ��Ǹ�, ����ƮŸ��, �Խñ۹�ȣ, �̼ǹ�ȣ, ��۹�ȣ, ����, �̸�, �г���, ����Ʈ, ����Ʈ���ѿ���, ����Ʈ+,- ���� ����(userPoint������ ���)
function adminPoint($hero_code, $board, $type, $board_idx, $mission_idx, $review_idx, $hero_id, $title, $hero_name, $hero_nick, $plus_point, $include_point, $userPoint){
    $error = "pointAdd_01";
    $regdate = date("Y-m-d H:i:s"); //����� �ð�
    $today = substr($regdate,0,10); //����

    // ��������Ʈ Ȯ��
    $sql = " SELECT ifnull(sum(hero_point),0) as cur_point FROM point WHERE hero_code = '".$hero_code."' ";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);

    $cur_point = $row["cur_point"]; //��������Ʈ

    if($type == 'togetherPoint'){ //������������ �ϰ����޹�ư���� ����
        $hero_top_title = '�ϰ����޸޴�';
    }else if($type == 'applicationPoint'){ //����� �������� ����
        $hero_top_title = '�̼ǽ�û�ο�';
    }else if($type == 'personPoint'){ //������������ �����ο��� ����
        $hero_top_title = '�������޸޴�';
    }else if($type == 'loverStar'){ //����������� ������Ÿ �����ϸ� ����Ʈ ����
        $hero_top_title = '������Ÿ';
    }else if($type == 'deliveryPoint'){
        $hero_top_title = '��ۺ� ��������Ʈ';
    }else if($type == 'user'){
        $hero_top_title = 'ȸ������';
    }

    if($userPoint == 'minus') $plus_point = -1*$plus_point; //����Ʈ���� ��ư�� �� ����Ʈ���� �����
    $next_point = $cur_point+$plus_point;

    //����Ȯ��
    $sql = " SELECT hero_level FROM level WHERE hero_point_01 <= '".$next_point."' and  hero_point_02 >= '".$next_point."' ";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $next_level = $row["hero_level"];

    //����Ʈ �Է�
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

    //ȸ������Ʈ ����
    $sql  = " UPDATE member SET hero_point  = '".$next_point."' ";
    $sql .= " WHERE hero_code ='".$hero_code."' ";
    $result = mysql_query($sql);

    if(!$result) {
        logging_error($hero_code,$board."pointAdd3 : ".$sql,$regdate);
        return 2;
    }

    //$txt = autoLevelPoint($hero_code, $next_level);

}

// 160523 ������ ����Ʈ ����
function adminPointModi($hero_idx, $hero_point){
    $hero_code = $_SESSION["temp_code"];

    $update_sql = "UPDATE point SET hero_point='".$hero_point."'";
    $update_sql .= "WHERE hero_idx='".$hero_idx."'";
    $result = mysql_query($update_sql);

    if(!$result) {
        logging_error($hero_code,$board."pointAdd2 : ".$sql,$regdate);
        return 2;
    }

    // ��������Ʈ Ȯ��
    $sql = " SELECT ifnull(sum(hero_point),0) as cur_point FROM point WHERE hero_code = '".$hero_code."' ";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $cur_point = $row["cur_point"]; //��������Ʈ

    //ȸ������Ʈ ����
    $sql  = " UPDATE member SET hero_point  = '".$cur_point."' ";
    $sql .= " WHERE hero_code ='".$hero_code."' ";
    $result = mysql_query($sql);

    if(!$result) {
        logging_error($hero_code,$board."pointAdd3 : ".$sql,$regdate);
        return 2;
    }

}

//����Ʈ ����Ʈ���� ���� �Լ�
//Ÿ��, �Խ��ǹ�ȣ, �̼ǹ�ȣ, �����ȣ, ���̵�, �Խ����̸�, ����Ʈ�̸�, ����Ʈ
function pointHistoryContent($type, $hero_old_idx, $hero_mission_idx, $hero_review_idx, $hero_id, $hero_top_title, $hero_title, $hero_point, $edit_hero_code){
    //�����ڰ� ����޴����� �� ����Ʈ
    if($type == "mission"){
        echo $hero_title;

        //������, ����
    }else if($type == "mission_write"){
        $sql = "select hero_title from mission where hero_idx='".$hero_mission_idx."'";
        $title_sql = mysql_query($sql);
        $mission_title = @mysql_fetch_assoc($title_sql);

        if(!$edit_hero_code && $hero_point == 0){ //����Ʈ�� 0���̰� ����code�� ������ ���
            echo $hero_top_title." ".$mission_title['hero_title']." "."���� ���";
        }else{
            echo $hero_point > 0 ? $hero_top_title." ".$mission_title['hero_title']." "."���� ���" : $hero_top_title." ".$mission_title['hero_title']." "."���� ����";
        }

        //�̼ǽ�û, ����
    }else if($type == "mission_application"){
        if(!$edit_hero_code && $hero_point == 0){ //����Ʈ�� 0���̰� ����code�� ������ ���
            echo $hero_top_title." ".$hero_title." "."��û�� ���";
        }else{
            echo $hero_point > 0 ? $hero_top_title." ".$hero_title." "."��û�� ���" : $hero_top_title." ".$hero_title." "."��û�� ����";
        }

        //�Խñ� �ۼ�, ����
    }else if($type == "write"){
        if(!$edit_hero_code && $hero_point == 0){ //����Ʈ�� 0���̰� ����code�� ������ ���
            echo $hero_top_title." "."�Խñ� ���";
        }else{
            echo $hero_point > 0 ? $hero_top_title." "."�Խñ� ���" : $hero_top_title." "."�Խñ� ����";
        }

        //���, ����
    }else if($type == "review"){
        if(!$edit_hero_code && $hero_point == 0){ //����Ʈ�� 0���̰� ����code�� ������ ���
            echo $hero_top_title." "."��� ���";
        }else{
            echo $hero_point > 0 ? $hero_top_title." "."��� ���" : $hero_top_title." "."��� ����";
        }
        //��������
    }else if($type == "birth"){
        echo $hero_top_title;

        //�⼮üũ
    }else if($type == "attendance"){
        echo $hero_top_title;

        //�����ڰ� ������������ ȸ���鿡�� �ϰ������� ������ ����Ʈ
    }else if($type == "togetherPoint"){
        echo $hero_title;

        //�����ڰ� ���������޴����� ���������� ������ ����Ʈ
    }else if($type == "personPoint"){
        echo $hero_title;

        //�����ڰ� �����û�ڵ鿡�� �ϰ������� ������ ����Ʈ
    }else if($type == "applicationPoint"){
        echo $hero_title;

        //������Ÿ ����, ���
    }else if($type == "loverStar"){
        echo $hero_point > 0 ? $hero_title." ����" : $hero_title." ���";

        //��õ������Ʈ, ��� �̻���� �̺�Ʈ
    }else if($type == "member"){
        echo $hero_title;

        //�� ���� ����Ʈ, ȸ�������߰��Է�  ��� type���� �͵� �ؿ���� ������ �ʿ��� type�� �־������
    }else if($type == ""){
        echo $hero_title;

        //�߰������Է� �̺�Ʈ
    }else if($type == "addInfo"){
        echo $hero_title;

        /***********************���� ��ϸ��ְ� ���Ӱ� �߰������ʴ� Ÿ�Ե�***************************/
        //���� �Ϲ� �̼�, ��������, Ȱ���̼�
    }else if($type == "step_01"){
        echo $hero_top_title.' '.$hero_title;

        //���� �����̾��̼�, �̺�Ʈ
    }else if($type == "view"){
        echo $hero_title;

        //���� �̼�
    }else if($type == "action3"){
        echo $hero_top_title.' '.$hero_title;

        //��ۺ� ����Ʈ
    }else if($type == "deliveryPoint"){
        echo $hero_top_title.' '.$hero_title;

        //��� ����Ʈ ������ ���� �� ����Ʈ�� ����
    }else if($list['admin'] == "admin"){
        echo $hero_title;
        /*************************************************************************************************/
        //�� �̿� type, 50���� �޼�
    }else{
        echo $hero_title;
    }

}

function autoLevelPoint($hero_code, $next_level) {
    $full_today = date("Y-m-d H:i:s");
    $txt = "message:�����մϴ�! ".$next_level."������ �޼��ϼ̽��ϴ�.";

    if($next_level == 50) {
        $sql = " SELECT hero_code as temp_code, hero_id as temp_id, hero_nick as hero_nick FROM member WHERE hero_code = '".$hero_code."'";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);

        $level_log_chk = " SELECT * FROM level50_message_log WHERE hero_level=50 AND hero_code='".$row['temp_code']."'" ;
        $level_log_chk_res = mysql_query($level_log_chk);
        $level_log_chk_count = mysql_num_rows($level_log_chk_res);
        //$txt = "message:50���� ��������Ʈ ���� ������ �����մϴ�. ��������Ʈ �����޵˴ϴ�.";

        if($level_log_chk_count < 1) {
            //$txt = "message:50������ �޼��ϼ̽��ϴ�! ��������Ʈ�� 500P �����Ǿ����ϴ�.";
            /*
            $insertPoint_50level= "insert into point (hero_code, hero_table, hero_type, hero_old_idx, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today, hero_include_maxpoint, hero_use, point_change_chk, hero_ori_today) ";
            $insertPoint_50level .= "values ('".$row['temp_code']."','member', 'member', '0', '".$row['temp_id']."','50���� ��� ��������Ʈ','50���� ��� ��������Ʈ','".$row['temp_name']."','".$row['temp_nick']."','500','".$full_today."','N','0','Y','".$full_today."')";

            //500����Ʈ ����
            $insertPoint_50level_res = new_sql($insertPoint_50level,$error);
            if((string)$insertPoint_50level_res==$error){
                error_historyBack("50���� ��� ��������Ʈ ���� �����Դϴ�. �����ڿ��� �������ּ���.");
                exit;
            }
            */

            //���������� 20190225
            $column_hero_command = "AK LOVER Ȱ���� ������ ���ּż� ����帮��,\n";
            $column_hero_command .= "�����ε� �� ��Ź�帳�ϴ�!\n";
            $column_hero_command .= "�� �ϱ��� �ҽ��� �Է��Ͽ� ����Ͻø� �Ǵµ���~\n\n";
            $column_hero_command .= "&lt;a href=\'https://aklover.co.kr/\' target=\'_blank\'&gt;\n";
            $column_hero_command .= "&lt;img src=\'https://aklover.co.kr/widget_50_level.png\' width=\'170\' height=\'170\' border=\'0\'&gt;\n";
            $column_hero_command .= "&lt;/a&gt;\n\n";
            $column_hero_command .= "���� ���� ����� ������ �Ұ�/���� > ü��� ������� >\n";
            $column_hero_command .= "���� ��ġ ���μ������� Ȯ�� �����Ͻø�,\n\n";
            $column_hero_command .= "<a href=\'https://www.aklover.co.kr/main/index.php?board=group_04_12&tabNum=2\'>�ٷ�Ȯ�� �ϱ�>></a>\n\n";
            $column_hero_command .= "�׷� ���õ� �ູ�� �Ϸ� �������䢾";

            $insertMessageSql = " INSERT INTO mail (hero_code, hero_table, hero_title, hero_user ";
            $insertMessageSql .= " , hero_name, hero_nick, hero_today, hero_use, hero_command ) VALUES ";
            $insertMessageSql .= "('admin_2013_09_22','mail','50���� �޼��� ���ϵ帳�ϴ�.','".$row['temp_id']."' ";
            $insertMessageSql .= ", '������', '������',now(),'1', '".$column_hero_command."' ) ";

            $insertPoint_50level_res = new_sql($insertMessageSql,$error);


            $insertLevel_log = "INSERT INTO level50_message_log (hero_code, hero_id, hero_level, hero_today) 
								VALUES ('".$row['temp_code']."', '".$row['temp_id']."', '".$next_level."', now())";
            $insertLevel_log_res = new_sql($insertLevel_log,$error);
            if((string)$insertLevel_log_res==$error){
                error_historyBack("50���� LOG ERROR, �����ڿ��� �������ּ���.");
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

//�̸� ����ŷ
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

//����ó ����ŷ
function phone_masking($phone) {
    $val = $phone;
    $val_len = strlen($phone);

    if($val_len > 8) {
        $val = substr($phone,0,$val_len-4)."****";
    }

    return $val;
}

//�˸����߰� 190605
function memberJoinAlrimTalk($message ,$mobile, $type) {

    if($type == "10002") {
        $lms_message = $message." https://www.aklover.co.kr";
    }

    if($type == "10009") {
        $lms_message = $message." https://www.aklover.co.kr";
    }

    //ȸ������ �˸� 01058727371(�����)
    //BACKUP_PROCESS_CODE SMS��ȯ :000,   LMS/MMS ��ȯ : 001, ��ȯ���� 003

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

//�˸����߰� ������ ���� �߼� 20200109
function adminSendAlrimTalk($message ,$mobile, $type, $hero_idx_mail, $hero_id) {


    $lms_message = $message." https://www.aklover.co.kr";


    //ȸ������ �˸� 01058727371(�����)
    //BACKUP_PROCESS_CODE SMS��ȯ :000,   LMS/MMS ��ȯ : 001, ��ȯ���� 003

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


    $message = "<AK LOVER �ְ� ��������>\n�ӽú�й�ȣ�� ".$password."\n�Դϴ�.";


    //ȸ������ �˸� 01058727371(�����)
    //BACKUP_PROCESS_CODE SMS��ȯ :000,   LMS/MMS ��ȯ : 001, ��ȯ���� 003

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
    $message = "<AK LOVER �ְ� ��������>\n�����ڵ�� ".$authNumber."\n�Դϴ�.";

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

//������ �����Ǹ� ����
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
