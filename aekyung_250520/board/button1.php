<?
if(!strcmp($_SESSION['temp_level'], '')){
    $my_level = '0';
    $my_write = '0';
    $my_view = '0';
    $my_update = '0';
    $my_rev = '0';
}else{
    $my_level = $_SESSION['temp_level'];
    $my_write = $_SESSION['temp_write'];
    $my_view = $_SESSION['temp_view'];
    $my_update = $_SESSION['temp_update'];
    $my_rev = $_SESSION['temp_rev'];
}

$sql = "select * from hero_group where hero_board = 'group_02_03';";

sql($sql, 'on');
$check_list                             = @mysql_fetch_assoc($out_sql);


if($_GET['page'])	$page= $_GET['page'];
else				$page= 1;

?>
<div class="btngroup">
</div>
<div class="paging">
    <?
    if(!strcmp($_GET['view'], '')){
        include_once BOARD_INC_END.'page.php';
    } else if(!strcmp($_GET['view'], 'missionReview') || !strcmp($_GET['view'], 'greatReview')){
        include_once BOARD_INC_END.'page.php';
    }
    ?>
</div>
