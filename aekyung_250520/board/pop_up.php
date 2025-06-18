<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once                                                        '../freebest/head.php';
?>
<meta charset="euc-kr" />
<head>
<link rel="stylesheet" type="text/css" href="<?=CSS_END;?>general.css"/>
<!-- <script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script> -->	
<script type="text/javascript">
function putImg(id, file, file2) {
    opener.pasteHTMLDemo(id, file);
    opener.document.getElementsByName('sm_file')[0].value =  opener.document.getElementsByName('sm_file')[0].value +","+ file2;
    self.close();
}
</script>
<style>
    a:hover, a:active{color: #fff;}
</style>
</head>
<body topmargin="6" leftmargin="5">
<?
if($mode == "ok"){
    $size_info = @getimagesize(USER_PHOTO_INC_END.$_GET['file']);// 이미지사이즈를 구한다.
    $top_img = 653;
    if($size_info[0] > $top_img){
        $wid = $top_img; //가로사이즈 나누기 2
        $p = ($size_info[0]/$top_img); // 세로사이즈 나누기 2
        $hei = ($size_info[1]/$p); // 세로사이즈 나누기 2
    }else{
        $wid = $size_info[0];
        $hei = $size_info[1];
    }

?>
    <center><br><br>
    <table width="400" border="0" cellpadding="0" cellspacing="0" class="t_view">
        <tr>
            <td style="text-align:center;">사진이 등록되었습니다.</td>
        </tr>
    </table>
        <br><div><a href="#" onclick="javascript:putImg('<?=$_GET['id']?>', '<img src=<?=USER_PHOTO_END.$_GET['file']?> width=<?=$wid?> height=<?=$hei?>>', '<?=$_GET['file']?>', '<?=$_GET['sm']?>');" class="btn_blue">확 인</a></div>
    </center>
 <?
}else if($mode == "up"){
 function show_msg($msg, $url) {
    echo "<meta HTTP-EQUIV='CONTENT-TYPE' content='text/html;charset=euc-kr'>
    <script language=\"JavaScript\">
        alert(\"$msg\"); 
        document.location.replace(\"$url\");
    </script>";
 }
$max_file_size  = 10240000000;
$uploaddir = USER_PHOTO_INC_END; //서버에 저장될 디렉토리의 권한은 777로 해둔다.
$url = "pop_up.php?id=".$_POST['id']; //에러 발생 시 돌아갈 URL
//$file_new_name = str_ireplace(' ', '_', $_FILES['uploadedfile']['name']);
//$file_new_name = str_ireplace('img', 'hero', $file_new_name);
//$file_new_name = str_ireplace('naver', 'hero', $file_new_name);


$filename = $_FILES['uploadedfile']['name'];

$pos = strrpos($filename, '.');
$ext = strtolower(substr($filename, $pos, strlen($filename)));

switch ($ext) {
case '.gif' :
case '.png' :
case '.jpg' :
case '.jpeg' :
	break;
default :
	die("<center>-ERR: File Format!<br>gif/png/jpg/jpeg 확장자만<br> 올릴수있습니다.</center>");
}

function random_generator ($min=8, $max=32, $special=NULL, $chararray=NULL) {
    $random_chars = array();
    
    if ($chararray == NULL) {
        $str = "abcdefghijklmnopqrstuvwxyz";
        $str .= strtoupper($str);
        $str .= "1234567890";

        if ($special) {
            $str .= "!@#$%";
        }
    }
    else {
        $str = $charray;
    }

    for ($i=0; $i<strlen($str)-1; $i++) {
        $random_chars[$i] = $str[$i];
    }

    srand((float)microtime()*1000000);
    shuffle($random_chars);

    $length = rand($min, $max);
    $rdata = '';
    
    for ($i=0; $i<$length; $i++) {
        $char = rand(0, count($random_chars) - 1);
        $rdata .= $random_chars[$char];
    }
    return $rdata;
}
$file_new_name = random_generator().$ext;
$file_new_name = str_ireplace('img', 'bbs', $file_new_name);
$file_new_name = str_ireplace('naver', 'bbs', $file_new_name);
$file_new_name = str_ireplace('temp', 'bbs', $file_new_name);

if($file_new_name != "") {
    // 중복되지 않는 파일로 만든다
//    $tmpfile_01 = substr(md5(uniqid($g4[server_time])),0,8)."_".$file_new_name;
    $tmpfile_01 = "temp_".$_SESSION['temp_id']."_".Y_m_d_h_i_s.'_'.$file_new_name;
    $tmpfile = $uploaddir.$tmpfile_01;
    //공백이 있는 파일명을  "_"로 수정
    $tmpfile =  str_replace(" ","_", $tmpfile);
    $filename = $tmpfile;
    $chk_file = explode('.', $filename);
    $extension = $chk_file[sizeof($chk_file)-1];
    if($extension == 'html' || $extension == 'htm' || $extension == 'php' || $extension == 'asp' || $extension == 'jsp' || $extension == 'exe' || $extension == 'xls' || $extension == 'xlsx') {
        $errmsg = $file_new_name.' 파일은 금지된 확장자입니다.';
        show_msg($errmsg, $url);
        exit;
     }
    //파일용량 확인 
    if($_FILES['uploadedfile']['size'] > $max_file_size) {
         $errmsg = $file_new_name.' 파일 용량이 너무 큽니다.';
         show_msg($errmsg, $url);
         exit;
     }
//     echo $filename;exit;
    move_uploaded_file($_FILES["uploadedfile"]["tmp_name"], $filename);
    chmod($filename,0777);
}
?>
    <meta http-equiv='Refresh' content='0; URL="pop_up.php?mode=ok&amp;id=<?=$_POST['id']?>&sm=<?=$_POST['sm']?>&amp;file=<?=$tmpfile_01?>" ' />
<?} else {?>
<script>
    /*$(document).ready(function(){
        $("#addbtn").click(go);
    });*/
    function go(){
        if(document.getElementsByName('uploadedfile')[0].value == ""){ 
            alert("첨부할 사진을 입력해주세요.");
        return;
        }
        document.getElementsByName('frm3')[0].submit();
    }
</script>
<center><br><br>
    <form name="frm3" action="pop_up.php?mode=up" enctype="multipart/form-data" method="post">
    <input type="hidden" name="id" value="<?=$_GET['id']?>" />
    <table border="0" cellpadding="0" cellspacing="0">
        <colgroup>
        <col /></colgroup>
        <tr>
            <td><input type="file" name="uploadedfile" class="input" style="width:250px;"></td>
        </tr>
        <tr>
            <td>
                <p class="align_c">
                <a href="javascript:go();" id="addbtn" style="text-decoration:none;" class="btn_blue">올리기</a>&nbsp;&nbsp;
                <a href="javascript:self.close();" style="text-decoration:none;" class="btn_blue">취 소</a>
            </td>
        </tr>
    </table>
    <div class="clearfix margin_t10"></div>
    </form>
<? } ?>
</body>