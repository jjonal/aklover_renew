<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$table = 'popup';
if(!strcmp($_GET['type'], 'edit')){
//    if(!strcmp($_POST['hero_number'], '')){msg('Ƚ���� �Է��ϼ���.','location.href="'.PATH_HOME.'?'.get('type','').'"');exit;}
    $drop_check = explode('||', $_POST['hero_drop']);
    while(list($drop_key, $drop_val) = each($drop_check)){
        unset($_POST[$drop_val]);
    }
    @reset($_POST);
    $data_i = '1';
    $count = @count($_POST);
    while(list($post_key, $post_val) = each($_POST)){
        if(!strcmp($post_key, 'hero_idx')){
            $idx = $_POST[$post_key];
            $data_i++;
            continue;
        }
        if(!strcmp($count, $data_i)){
            $comma = '';
        }else{
            $comma = ', ';
        }
        $sql_one_update .= $post_key.'=\''.$_POST[$post_key].'\''.$comma;
    $data_i++;
    }
    $sql = 'UPDATE '.$table.' SET '.$sql_one_update.' WHERE hero_idx = \''.$idx.'\';'.PHP_EOL;
    mysql_query($sql);
    msg('���� �Ǿ����ϴ�.','location.href="'.PATH_HOME.'?'.get('type','').'"');
    exit;
}else if(!strcmp($_GET['type'], 'drop')){
    $sql = 'DELETE FROM '.$table.' WHERE hero_idx = \''.$_GET['hero_idx'].'\';';
    mysql_query($sql);
    msg('���� �Ǿ����ϴ�.','location.href="'.PATH_HOME.'?'.get('type||hero_idx','').'"');
}
$popup_sql = 'select * from popup where hero_idx=\''.$_REQUEST['hero_idx'].'\';';//desc<=
$out_popup_sql = mysql_query($popup_sql);
$popup_list                             = @mysql_fetch_assoc($out_popup_sql);

echo "test";

?>

<style>
td{height:30px;}
</style>
                        <script type="text/javascript" src="/cheditor/cheditor.js"></script>
                        <link type='text/css' href='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.css' rel='stylesheet' />
						<script type="text/javascript" src="<?=DOMAIN_END?>cal/jquery.min.js"></script>
                        <script type='text/javascript' src='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.min.js'></script> 
                        <table style="width:100%;text-align:center">
                            <form method="post" name="form_next" onsubmit="return doSubmit(this)">
                            <input type="hidden" name="hero_drop" value="hero_drop||inputWidth||inputAlt||inputCaption">
                            <input type="hidden" name="hero_idx" value="<?=$popup_list['hero_idx']?>">
                            <input type="hidden" name="hero_idx" id="thumbCount" value="1">
                            <tr>
                                <td>
                                    ���� ��ġ : <input type="text" name="hero_width_point" value="<?=$popup_list['hero_width_point']?>"/> �� : 100
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    ���� ��ġ : <input type="text" name="hero_height_point" value="<?=$popup_list['hero_height_point']?>"/> �� : 100
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�� : <input type="text" name="hero_width" value="<?=$popup_list['hero_width']?>"/> �� : 700
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;���� : <input type="text" name="hero_height" value="<?=$popup_list['hero_height']?>"/> �� : 500
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    &nbsp;&nbsp;&nbsp;&nbsp;��ũ ��� : <input type="text" name="hero_href" value="<?=$popup_list['hero_href']?>" size="40"/>
                                </td>
                            </tr>
                            <tr>
                            	<td>
                                	���� �ð� : 
                                    <input type="text" name="hero_startdate" id="sdate" value="<?=$popup_list['hero_startdate']?>"/> ~
                                    <input type="text" name="hero_enddate" id="edate" value="<?=$popup_list['hero_enddate']?>" />
                                    <input type="button" value="�ʱ�ȭ" onclick="$('#sdate').val('');$('#edate').val('');"/>
                                </td>	
                            </tr>
                            <tr>
                            	<td>
                                	
                                </td>
	
                            </tr>
                            <tr>
                                <td>
                                    <textarea id="fm_post" name="hero_command"><?=$popup_list['hero_command']?></textarea>
                                </td>
                            </tr>
                        </form>
                            <tr>
                                <td>	
                                    <input type="image" src="<?=DOMAIN_END?>image/bbs/btn_list.gif" onclick="javascript:location.href='<?=PATH_HOME.'?'.get('type||view||hero_idx','')?>';">
                                    <input type="image" src="<?=DOMAIN_END?>image/bbs/btn_edit.gif" onclick="javascript:return doSubmit(form_next);">
                                </td>
                            </tr>
                        </table>
                        <link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/anytime.5.1.2.css">
						<script src="<?=ADMIN_DEFAULT?>/js/anytime.5.1.2.js"></script>				
                        <script>
                        $(function(){
                            $("#sdate").AnyTime_picker( {
                            format: "%Y-%m-%d %H:%i:00"
                            });
                            $("#edate").AnyTime_picker( {
                            format: "%Y-%m-%d %H:%i:00"
                            }); 
                        });
                         </script>
                        <script type="text/javascript">
                        function doSubmit (theform){
                            myeditor.outputBodyHTML();
                            theform.action = "<?=PATH_HOME.'?'.get('type','type=edit')?>";
                            theform.submit();
                            return false;
                        }
                        function showImageInfo() {
                            var data = myeditor.getImages();
                            if (data == null) {
                                alert('�ø� �̹����� �����ϴ�.');
                                return;
                            }
                            for (var i=0; i<data.length; i++) {
                                var str = 'URL: ' + data[i].fileUrl + "\n";
                                str += '���� ���: ' + data[i].filePath + "\n";
                                str += '���� �̸�: ' + data[i].origName + "\n";
                                str += '���� �̸�: ' + data[i].fileName + "\n";
                                str += 'ũ��: ' + data[i].fileSize;
                                alert(str);
                            }
                        }
                        </script>
                        <script type="text/javascript">
                        var myeditor = new cheditor();              // ������ ��ü�� �����մϴ�.
                        myeditor.config.editorHeight = '300px';     // ������ �������Դϴ�.
                        myeditor.config.editorWidth = '100%';        // ������ �������Դϴ�.
                        myeditor.inputForm = 'fm_post';             // textarea�� id �̸��Դϴ�. ����: name �Ӽ� �̸��� �ƴմϴ�.
                        myeditor.run();                             // �����͸� �����մϴ�.
                        </script>