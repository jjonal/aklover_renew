<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
    $sql = 'select * from admin where hero_idx = \''.$_GET['next_idx'].'\';';
    @sql($sql,'on');
    $drop_list                             = @mysql_fetch_assoc($out_sql);
    $id_old = $drop_list['hero_id'];
    $table_old = 'admin';
    $sql = 'DELETE FROM '.$table_old.' WHERE hero_id = \''.$id_old.'\';';
    @mysql_query($sql);
    $table_old = 'member';
    $sql = 'DELETE FROM '.$table_old.' WHERE hero_id = \''.$id_old.'\';';
    @mysql_query($sql);
    $out_get = '?board=title&idx=2';
    echo '<script>location.href="'.PATH_HOME.'?'.$out_get.'"</script>';

//drop('admin', $_GET['next_idx']);
//drop('member', $_GET['next_idx']);
?>