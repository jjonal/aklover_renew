<?
$table = 'board';
if(!strcmp($_GET['type'], 'write')){
    $data_check = count($_POST);
    $data_i='1';
    if(!strcmp($_POST['hero_command'], '')){
        $sql_one .= 'hero_review_day, ';
        $sql_two .= 'null, ';
    }else{
        $sql_one .= 'hero_review_day, ';
        $sql_two .= '\''.Ymdhis.'\', ';
    }
    while(list($data_key, $data_val) = each($_POST)){
        if(!strcmp($data_check, $data_i)){
            $comma = '';
        }else{
            $comma = ', ';
        }
        if(!strcmp($data_key,"hero_command")){
            $command = nl2br(htmlspecialchars($_POST[$data_key]));
            $command = str_ireplace("<br />", "", $command);//글자 변경

            $sql_one .= $data_key.$comma;
            $sql_two .= '\''.$command.'\''.$comma;
        }else{
            $sql_one .= $data_key.$comma;
            $sql_two .= '\''.$_POST[$data_key].'\''.$comma;
        }
        $data_i++;
    }
    $sql = 'INSERT INTO '.$table.' ('.$sql_one.') VALUES ('.$sql_two.');';
    mysql_query($sql);
    msg('추가 되었습니다.','location.href="'.PATH_HOME.'?'.get('type||view||hero_board','').'"');
    exit;
}
?>
                        <table class="t_view">
                        <form name="form_next" action="<?=PATH_HOME.'?'.get('','type=write');?>" method="post" enctype="multipart/form-data"> 
                        <input type="hidden" name="hero_code" value="<?=$_SESSION['temp_code']?>">
                        <input type="hidden" name="hero_table" value="<?=$_GET['hero_table']?>">
                        <input type="hidden" name="hero_name" value="<?=$_SESSION['temp_name']?>">
                        <input type="hidden" name="hero_today" value="<?=Ymdhis?>">
                        <input type="hidden" name="hero_ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
                            <colgroup>
                                <col width="20%">
                                <col width="30%">
                                <col width="20%">
                                <col width="30%">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th>질문</th>
                                    <td colspan="3">
                                        <textarea name="hero_title" class="textarea" style="width:900px; height:150px;"><?=$check_list['hero_title'];?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th>답변</th>
                                    <td colspan="3"><textarea name="hero_command" class="textarea" style="width:900px; height:150px;"><?=$check_list['hero_command'];?></textarea></td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%">
                            <tr>
                                <td>
                                    <a href="javascript:go_list();" class="btn_blue2">목록</a>
                                </td>
                                <td>
                                    <a href="javascript:form_next.submit();" class="btn_blue2">입력</a>
                                </td>
                            </tr>
                        </form>
                        </table>
                        <script>
                            function go_list(){
                                location.href = "./index.php?board=<?=$_GET['board']?>&idx=<?=$_GET['idx']?>";
                            }
                        </script>