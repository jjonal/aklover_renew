<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
ob_start();
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
header("Content-Type: text/html; charset=euc-kr");
if(!defined('_HEROBOARD_'))exit;
include_once															$_SERVER["DOCUMENT_ROOT"].'/freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';

if(!strcmp($_SESSION['temp_level'], '')){
    $my_level = '0';
}else{
    $my_level = $_SESSION['temp_level'];
}

if(!strcmp($my_level,'0')){msg('권한이 없습니다.','location.href="'.PATH_HOME.'?board=login"');exit;}
######################################################################################################################################################
?>

<?
$table = 'mail';
    if(!strcmp($_POST['hero_user'], '')){echo "에러입니다. 다시 시도해주세요.";exit;}
    $data_i = '1';
    $count = @count($_POST);
    while(list($post_key, $post_val) = each($_POST)){
		//echo $post_key;
		if($post_key!='hero_title' and $post_key!='hero_command'){
			$post_val = decrypt ($post_val);
		}
		if($post_key=='hero_title' or $post_key=='hero_command'){
			$post_val = iconv('UTF-8','EUC-KR',$post_val);
		}
        if(!strcmp($count, $data_i)){
            $comma = '';
        }else{
            $comma = ', ';
        }
		
//        $sql_one_update .= $post_key.'=\''.$_POST[$post_key].'\''.$comma;
        if(!strcmp($post_key,"hero_command")){
            //$command = nl2br(htmlspecialchars($_POST[$post_key]));
            //$command = str_ireplace("<br />", "", $command);//글자 변경

            $sql_one_write .= $post_key.$comma;
            $sql_two_write .= '\''.$post_val.'\''.$comma;
        }else{
            $sql_one_write .= $post_key.$comma;
            $sql_two_write .= '\''.$post_val.'\''.$comma;
        }
    $data_i++;
    }
    $sql = 'INSERT INTO '.$table.' ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
	//echo $sql;
	$sql_result = sql($sql, 'on');
	echo $sql_result;
	//if (!$result) {echo "0";}	else{echo "1";}

?>


