<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD����
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
                    <p style="text-align:center;"><font color=red>�����Ͱ� ���� ���� �ʽ��ϴ�.</font></p>
                    </div>
                ';
            }else{
                $out = '
                    <div style="border:1px solid #ccc;width:565px; height:40px; margin:auto; margin-top:50px;">
                        <br>
                    <p style="text-align:center;">ȸ������ ���̵�� <b>[<font color=blue>'.$review_list['hero_id'].'</font>] �Դϴ�.</b></p>
                    </div>
                ';
            }
        echo iconv('EUC-KR', 'UTF-8', $out);
    }else{
        $out = '
            <div style="border:1px solid #ccc;width:565px; height:40px; margin:auto; margin-top:50px;">
                <br>
            <p style="text-align:center;"><font color=red>�����Ͱ� ���� ���� �ʽ��ϴ�.</font></p>
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
                    <p style="text-align:center;"><font color=red>�����Ͱ� ���� ���� �ʽ��ϴ�.</font></p>
                    </div>
                ';
            }else{
                $out = '
                    <div style="border:1px solid #ccc;width:565px; height:40px; margin:auto; margin-top:50px;">
                        <br>
                    <p style="text-align:center;">ȸ������ ��й�ȣ�� <b>[<font color=blue>'.$review_list['hero_pw'].'</font>] �Դϴ�.</b></p>
                    </div>
                ';
            }
        echo iconv('EUC-KR', 'UTF-8', $out);
    }else{
        $out = '
            <div style="border:1px solid #ccc;width:565px; height:40px; margin:auto; margin-top:50px;">
                <br>
            <p style="text-align:center;"><font color=red>�����Ͱ� ���� ���� �ʽ��ϴ�.</font></p>
            </div>
        ';
        echo iconv('EUC-KR', 'UTF-8', $out);
    }
}
?>