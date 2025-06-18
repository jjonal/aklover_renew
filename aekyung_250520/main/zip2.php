<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once '../freebest/head.php';
######################################################################################################################################################
include_once FREEBEST_INC_END.'function.php';
######################################################################################################################################################
if(!strcmp($_POST['type'],'id')){
    $str_len = strlen($_POST['01']);
    if( ($str_len > '3') and ($str_len < '21') ){
        $sql = 'select * from member where hero_name = \''.$_POST['01'].'\' and hero_jumin=\''.$_POST['02'].'\' and hero_mail=\''.$_POST['03'].'\' and hero_use=0';
        $sql = out($sql);
        sql($sql, 'end');
        $count = @mysql_num_rows($out_sql);
        $review_list                             = @mysql_fetch_assoc($out_sql);
            if(!strcmp($count,'0')){
                $out = '
                    <div style="border:1px solid #ccc;width:565px; height:40px; margin:auto; margin-top:50px;">
                        <br>
                    <p style="text-align:center;"><font color=red>데이터가 존재 하지 않습니다.</font></p>
                    </div>
                ';
            }else{
                $out = '
                    <div style="border:1px solid #ccc;width:565px; height:40px; margin:auto; margin-top:50px;">
                        <br>
                    <p style="text-align:center;">회원님의 아이디는 <b>[<font color=blue>'.$review_list['hero_id'].'</font>] 입니다.</b></p>
                    </div>
                ';
            }
        echo iconv('EUC-KR', 'UTF-8', $out);
    }else{
        $out = '
            <div style="border:1px solid #ccc;width:565px; height:40px; margin:auto; margin-top:50px;">
                <br>
            <p style="text-align:center;"><font color=red>데이터가 존재 하지 않습니다.</font></p>
            </div>
        ';
        echo iconv('EUC-KR', 'UTF-8', $out);
    }
}
if(!strcmp($_POST['type'],'pw')){
    $str_len = strlen($_POST['01']);
    if( ($str_len > '3') and ($str_len < '21') ){
        $sql = 'select * from member where hero_id = \''.$_POST['01'].'\' and hero_jumin=\''.$_POST['02'].'\' and hero_mail=\''.$_POST['03'].'\' and hero_use=0';
        $sql = out($sql);
        sql($sql, 'end');
        $count = @mysql_num_rows($out_sql);
        $review_list                             = @mysql_fetch_assoc($out_sql);
            if(!strcmp($count,'0')){
                $out = '
                    <div style="border:1px solid #ccc;width:565px; height:40px; margin:auto; margin-top:50px;">
                        <br>
                    <p style="text-align:center;"><font color=red>데이터가 존재 하지 않습니다.</font></p>
                    </div>
                ';
            }else{
                $out = '
                    <div style="border:1px solid #ccc;width:565px; height:40px; margin:auto; margin-top:50px;">
                        <br>
                    <p style="text-align:center;">회원님의 비밀번호는 <b>[<font color=blue>'.$review_list['hero_pw'].'</font>] 입니다.</b></p>
                    </div>
                ';
            }
        echo iconv('EUC-KR', 'UTF-8', $out);
    }else{
        $out = '
            <div style="border:1px solid #ccc;width:565px; height:40px; margin:auto; margin-top:50px;">
                <br>
            <p style="text-align:center;"><font color=red>데이터가 존재 하지 않습니다.</font></p>
            </div>
        ';
        echo iconv('EUC-KR', 'UTF-8', $out);
    }
}
?>