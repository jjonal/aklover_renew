<?
$table = 'with_supporters_mo';
if(!strcmp($_GET['type'], 'edit')){
    $post_count = @count($_POST['hero_idx']);
    $hero_file = imageUploader($_FILES['hero_file'],"/aklover/photo/", true);

    for($i=0;$i<$post_count;$i++){
        reset($_POST);
        unset($sql_one_update);

        $j=0;
        foreach($_POST as $post_key=>$post_val){
            if($post_key=='hero_idx'){
                $idx = $_POST[$post_key][$i];
                continue;
            }
            if($j==0)	$comma = '';
            else		$comma = ',';

            //������ �߰� ������ �����̸� 0���� ������Ʈ
            if ($post_key=='hero_order' && empty($_POST[$post_key][$i]) == 1) $_POST[$post_key][$i] = 0;

            if($post_key=='hero_main' && $hero_file[$i]!="noFile")		$sql_one_update .= $comma.$post_key."='".$hero_file[$i]."'";
            else														$sql_one_update .= $comma.$post_key."='".$_POST[$post_key][$i]."'";

            $sql = "UPDATE ".$table." SET ".$sql_one_update." WHERE hero_idx = '".$idx."';";

            $j++;
        }

        mysql_query($sql);
    }

    msg('���� �Ǿ����ϴ�.','location.href="'.PATH_HOME.'?'.get('type','').'"');
    exit;
}
?>
<div id="layer" style="text-align:center; position:absolute; display:none; margin:0; padding:0; z-index:1;border:solid 5px red"></div>
<table class="t_list">
    <thead>
    <tr>
        <th width="10%">ī�װ�</th>
        <th width="20%">����̹���(PC)<br />(720x720)</th>
        <th>�±׼���</th>
    </tr>
    </thead>
    <tbody>
    <form name="form_next" action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post" enctype="multipart/form-data" onsubmit="return false">
        <?
        $sql = 'select * from '.$table.' order by hero_idx asc;';
        sql($sql);
        $i = '0';
        while($roll_list                             = @mysql_fetch_assoc($out_sql)){
            ?>
            <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
                <input type="hidden" name="hero_idx[]" value="<?=$roll_list['hero_idx']?>">
                <input type="hidden" name="hero_main[]" value="<?=$roll_list['hero_main']?>">
                <td><?=$roll_list['hero_cate']?></td>
                <td>
                    <!-- �����߰� ���� ��ʿ��� �����Խ��ϴ�. �����ʿ��մϴ� -->
                    <div align="center" style="text-align:center;width:100%;">
                        <?if($roll_list['hero_main']!='' && $roll_list['hero_main']!=null){?>
                            <img class="group1" src="/aklover/photo/<?=$roll_list['hero_main']?>" alt="" height="71" onClick="hero_layer('layer',this.src);" style="margin-bottom:10px;"/><br/>
                        <?}?>
                        <input type="file" name="hero_file[]" style="width:140px;">
                    </div>
                </td>
                <td class="f_cs pd_l">
                    <div class="f_cs">
                        <label for="">#</label>
                        <input type="text" name="hero_tag1[]" value="<?=$roll_list['hero_tag1']?>" style="width:90%">
                    </div>
                    <div class="f_cs">
                        <label for="">#</label>
                        <input type="text" name="hero_tag2[]" value="<?=$roll_list['hero_tag2']?>" style="width:90%">
                    </div>
                    <div class="f_cs">
                        <label for="">#</label>
                        <input type="text" name="hero_tag3[]" value="<?=$roll_list['hero_tag3']?>" style="width:90%">
                    </div>
                    <div class="f_cs">
                        <label for="">#</label>
                        <input type="text" name="hero_tag4[]" value="<?=$roll_list['hero_tag4']?>" style="width:90%">
                    </div>
                </td>
            </tr>
            <?
            $i++;
        }
        ?>
    </form>
    </tbody>
</table>
<div class="btnGroup">
    <a href="javascript:form_next.submit();" class="btnAdd">����</a>
</div>