<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/anytime.5.1.2.css">
<script src="<?=ADMIN_DEFAULT?>/js/anytime.5.1.2.js"></script>
<?
$table = 'bot_content';
//$hero_board = 'banner'; //������ ����
if(!strcmp($_GET['type'], 'edit')){
    $post_count = count($_POST['hero_use']);
    $hero_file = imageUploader($_FILES['hero_file'],"/aklover/photo/", true);

    //���������� Ÿ��Ʋ���� (S)
    $sql = "UPDATE ".$table." ";
    $sql.= "SET hero_title = '".$_POST['main_hero_title']."', ";
    $sql.= "hero_sub_title = '".$_POST['main_hero_sub_title']."' ";
    $sql.= "where hero_idx = 1"; //hero_idx == 1�� ����Ÿ��Ʋ

    mysql_query($sql);
    //���������� Ÿ��Ʋ���� (E)
    for($i=0;$i<$post_count;$i++){
        reset($_POST);
        unset($sql_one_update);
        unset($sql_one);
        unset($sql_two);

        $j=0;
        foreach($_POST as $post_key=>$post_val){
            //���������� Ÿ��Ʋ���� �÷� ��ŵ
            if($post_key == 'main_hero_idx' || $post_key == 'main_hero_title' || $post_key == 'main_hero_sub_title') continue;

            if($post_key=='hero_idx'){
                $idx = $_POST[$post_key][$i];
                continue;
            }
            if($j==0)	$comma = '';
            else		$comma = ',';

            //������ �߰� ������ �����̸� 0���� �μ�Ʈ or ������Ʈ
            if ($post_key=='hero_order' && empty($_POST[$post_key][$i]) == 1) $_POST[$post_key][$i] = 0;
            //update
            if($idx!=0){
                if($post_key=='hero_main' && $hero_file[$i]!="noFile")		$sql_one_update .= $comma.$post_key."='".$hero_file[$i]."'";
                else														$sql_one_update .= $comma.$post_key."='".$_POST[$post_key][$i]."'";

                $sql = "UPDATE ".$table." SET ".$sql_one_update." WHERE hero_idx = '".$idx."';";
            }
            //insert
            else{
                if($post_key=='hero_main' && $hero_file[$i]!="noFile"){
                    $sql_one .= $comma.$post_key;
                    $sql_two .= $comma."'".$hero_file[$i]."'";
                }else{
                    $sql_one .= $comma.$post_key;
                    $sql_two .= $comma."'".$_POST[$post_key][$i]."'";
                }
                $sql = "insert into ".$table." (".$sql_one.") values (".$sql_two.");";
            }
            $j++;
        }

        mysql_query($sql);
    }

    msg('���� �Ǿ����ϴ�.','location.href="'.PATH_HOME.'?'.get('type','').'"');
    exit;

}else if(!strcmp($_GET['type'], 'drop')){
    $idx = $_GET['idx'];

    if(is_numeric($idx)){
        $sql = "DELETE FROM ".$table." WHERE hero_idx = '".$_GET['hero_idx']."'";
        sql($sql);
    }
    msg('���� �Ǿ����ϴ�.','location.href="'.PATH_HOME.'?'.get('type||hero_idx','').'"');
    exit;
}
?>
<div id="layer" style="text-align:center; position:absolute; display:none; margin:0; padding:0; z-index:1;border:solid 5px red"></div>
<form name="form_next" action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post" enctype="multipart/form-data">
    <h3>���������� Ÿ��Ʋ����</h3>
    <table class="t_list">
        <thead>
        <tr>
            <th width="50%">����Ÿ��Ʋ</th>
            <th width="50%">����Ÿ��Ʋ</th>
        </tr>
        </thead>
        <tbody>
        <?
        $sql = "select * from ".$table." where hero_idx = 1";
        sql($sql);
        $main = @mysql_fetch_assoc($out_sql)
        ?>
            <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
                <input type="hidden" name="main_hero_idx" value="<?=$main['hero_idx']?>">
                <td><input type="text" name="main_hero_title" value="<?=$main['hero_title']?>" style="width:350px"/></td>
                <td><input type="text" name="main_hero_sub_title" value="<?=$main['hero_sub_title']?>" style="width:350px"/></td>
            </tr>
        </tbody>
    </table>
    <h3 class="pb_0">������ ����</h3>
    <p class="tit_des">
       * �ϴ� �������� 1���� ��� �����Ͽ��� �������ֽñ� �ٶ��ϴ�.
    </p>
    <table class="t_list content_list">
        <thead>
        <tr>
            <th width="5%">����</th>
            <th width="17%">������ �̹���<br />(590x365)</th>
            <th >������ ����</th>
            <th >���������� ��ũ</th>
<!--            <th width="5%">����</th>-->
        </tr>
        </thead>
        <tbody>
        <?
        $sql = "select * from ".$table." where hero_idx != 1 order by replace(hero_order,0,9) asc";
        sql($sql);
        $i = '0';
        while($list                             = @mysql_fetch_assoc($out_sql)){
            ######################################################################################################################################################
            if($list['hero_use']==1){
                $hero_checked = "checked='checked'";
            }else{
                $hero_checked = '';
            }
            ?>

            <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
                <input type="hidden" name="hero_idx[]" value="<?=$list['hero_idx']?>">
                <input type="hidden" name="hero_main[]" value="<?=$list['hero_main']?>">
                <td>
                    <input type="checkbox" class="hero_use_check" <?=$hero_checked;?>>
                    <input type="hidden" class="hero_use" name="hero_use[]" value="<?=$list['hero_use']?>">
                </td>
                <td align="center" style="text-align:center;">
                    <div align="center" style="text-align:center;width:100%;">
                        <? if($list['hero_main']!='' && $list['hero_main']!=null){?>
                            <img class="group1" src="/aklover/photo/<?=$list['hero_main']?>" alt="" height="71" onclick="hero_layer('layer',this.src);" style="margin-bottom:10px;"/><br/>
                        <? } ?>
                        <input type="file" name="hero_file[]" style="width:140px;">
                    </div>
                </td>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="95%" style="border: none;">
                        <tr>
                            <td style="border: none;padding:2px;">Ÿ��Ʋ : </td>
                            <td style="border: none;padding:2px;"><input type="text" name="hero_title[]" value="<?=$list['hero_title']?>" style="width:350px"/></td>
                        </tr>

                        <tr>
                            <td style="border: none;padding:2px;">����Ÿ��Ʋ : </td>
                            <!--<td style="border: none;padding:2px;"><input type="text" name="hero_sub_title[]" value="<?php /*=$list['hero_sub_title']*/?>" style="width:350px"/></td>-->
                            <td style="border: none;padding:2px;"><textarea type="text" name="hero_sub_title[]" style="width:350px"><?=$list['hero_sub_title']?></textarea></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="95%" style="border: none;">
                        <tr>
                            <td style="border: none;padding:2px;">pc : </td>
                            <td style="border: none;padding:2px;"><input type="text" name="hero_pc_href[]" value="<?=$list['hero_pc_href']?>" style="width:350px"/></td>
                        </tr>

                        <tr>
                            <td style="border: none;padding:2px;">mo : </td>
                            <td style="border: none;padding:2px;"><input type="text" name="hero_mo_href[]" value="<?=$list['hero_mo_href']?>" style="width:350px"/></td>
                        </tr>
                    </table>
                </td>
<!--                <td><input type="text" name="hero_order[]" value="--><?php //=$list['hero_order']?><!--" style="width:40px;text-align:center;"></td>-->
<!--                <td><a href="javascript:location.href='--><?php //=PATH_HOME.'?'.get('','type=drop&hero_idx='.$list['hero_idx']);?><!--'" class="btnForm">����</a></td>-->
            </tr>
            <?
            $i++;
        }
        ?>
        </tbody>
    </table>
    <div class="btnGroup">
        <a href="javascript:form_next.submit();" class="btnAdd">��������</a>
<!--        <a href="javascript:void(make_new_form());" class="btnAdd">�߰�</a>-->
    </div>
</form>
<script>
    $(document).ready(function(){
        pageInit();
    });

    function pageInit(){
        //dateclick2();
        $(".hero_use_check").click(function(){
            $hero_use = $(this).siblings(".hero_use");
            if($hero_use.val()==1){
                $hero_use.val(0);
            }else{
                $hero_use.val(1);
            }
        });
    }
    var loop = 10000000;
    function make_new_form(){
        var new_form = "";
        new_form += "<tr onmouseover=\"this.style.background='#B9DEFF'\" onmouseout=\"this.style.background='white'\">";
        new_form += "<input type='hidden' name='hero_idx[]' value='0'>";
        new_form += "<input type='hidden' name='hero_main[]'>";
        new_form += "<td><input type='checkbox' class='hero_use_check'><input type='hidden' class='hero_use' name='hero_use[]' value='0'></td>";
        new_form += "<td>";
        new_form += "<img class='group1' src='' alt='' height='71' onclick='hero_layer(\'layer\',this.src);' style='margin-bottom:10px;'/><br/>";
        new_form += "<input type='file' name='hero_file[]' style='width:140px;'>";
        new_form += "</td>";
        new_form += "<td>";
        new_form += "<table border='0' cellpadding='0' cellspacing='0' width='95%' style='border: none;'>";

        new_form += "<tr>";
        new_form += "<td style='border: none;padding:2px;'>Ÿ��Ʋ : </td>";
        new_form += "<td style='border: none;padding:2px;'><input type='text' name='hero_title[]' value='' style='width:350px'/></td>";
        new_form += "</tr>";

        new_form += "<tr>";
        new_form += "<td style='border: none;padding:2px;'>����Ÿ��Ʋ : </td>";
        // new_form += "<td style='border: none;padding:2px;'><input type='text' name='hero_sub_title[]' style='width:350px'/> </td>";
        new_form += "<td style='border: none;padding:2px;'><textarea type='text' name='hero_sub_title[]' style='width:350px'></textarea></td>";
        new_form += "</tr>";
        new_form += "</table>";
        new_form += "</td>";

        new_form += "<td>";
        new_form += "<table border='0' cellpadding='0' cellspacing='0' width='95%' style='border: none;'>";
        new_form += "<tr>";
        new_form += "<td style='border: none;padding:2px;'>pc : </td>";
        new_form += "<td style='border: none;padding:2px;'><input type='text' name='hero_pc_href[]' style='width:350px'/></td>";
        new_form += "</tr>";

        new_form += "<tr>";
        new_form += "<td style='border: none;padding:2px;'>mo : </td>";
        new_form += "<td style='border: none;padding:2px;'><input type='text' name='hero_mo_href[]' style='width:350px'/></td>";
        new_form += "</tr>";
        new_form += "</table>";
        new_form += "</td>";

        // new_form += "<td><input type='text' name='hero_order[]' style='width:40px;text-align:center;'></td>";
        new_form += "</tr>";


        $(".content_list").append(new_form);
        pageInit();
        return false;
    }
</script>