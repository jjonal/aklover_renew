<?
if(!defined('_HEROBOARD_'))exit;

if($_GET["type"] == "write") {
    $data = $_POST['hero_alt'][0]."||".$_POST['hero_alt'][1];

    $sql = 'UPDATE '.$_POST['hero_table'].' SET hero_title=\''.$data.'\' WHERE hero_idx = \''.$_POST['hero_idx'].'\';';

    sql($sql, 'on');
    msg ( '��� �Ǿ����ϴ�.', 'location.href="' . PATH_HOME . '?' . get ( 'type||view', '' ) . '"' );
    exit ();
}

$sql = 'select * from hero_group where hero_idx=\'281\';';//desc
$sql = out($sql);
sql($sql);
$list = @mysql_fetch_assoc($out_sql);
$data = explode('||', $list['hero_title']);
?>

<form name="form_next" method="post"  action="<?=PATH_HOME.'?'.get('','type=write');?>">
<input name="hero_idx" value="<?=$list['hero_idx'];?>" type="hidden">
<input name="hero_table" value="hero_group" type="hidden">
<div class="apply_btn others">
	����
</div>
<h4>�̴��� AK Lover �Ұ�</h4>
<div class="intro_box_outer">
    <textarea name="hero_alt[]"><?=$data[0]?></textarea>
</div>

<h4>�̴��� AK Lover ���� ���� �� ����</h4>
<div class="intro_box_outer">
    <textarea name="hero_alt[]"><?=$data[1]?></textarea>
</div>
</form>

<script>
    $(document).ready(function(){
        //����
        $(".apply_btn.others").click(function(){
            $("form[name='form_next']").submit();
        });
    });
</script>