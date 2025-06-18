<?
define('_HEROBOARD_', TRUE);
include_once $_SERVER["DOCUMENT_ROOT"].'/freebest/head.php';
include_once $_SERVER["DOCUMENT_ROOT"].'/freebest/hero.php';
include_once $_SERVER["DOCUMENT_ROOT"].'/freebest/function.php';

db("aekyung");

$sql = "SELECT hero_id, hero_nick, hero_pw, hero_code FROM admin WHERE hero_table = 'admin' AND hero_id IN ";
$sql .= "('akthe22', 'akakis22', 'akcrm22')";
$list_res = sql($sql);
$num = 0;
$userId = "";
$userPw = "";
?>
<table class="t_list">
<thead>
<tr>
	<th>number</th>
	<th>id</th>
	<th>nick</th>
	<th>code</th>
 	<th>pw-new</th>
</tr>
</thead>
<? while($list = @mysql_fetch_assoc($list_res)) {   
    $num +=  1;
    $userId = $list['hero_id'];
    $userCode = $list['hero_code'];
    $userPw = md5('##tgk6363');
    $temp = $userPw.$userId;
    $sha3_pw = sha3_hash('sha3-256', $temp);
    
    $update_sql  = "UPDATE admin SET hero_pw = '".$sha3_pw."', hero_today = now() WHERE hero_id = '".$userId."' ";
    $result = sql($update_sql); 
    
    $delete_sql  = "DELETE FROM logging_pw WHERE hero_code = '".$userCode."' ";
    $result = sql($delete_sql); 
?>
<tr>
	<td><?=$num;?></td>
	<td><?=$userId;?></td>
	<td><?=$list['hero_nick'];?></td>
	<td><?=$userCode;?></td>
	<td><?=$sha3_pw;?></td>
</tr>
<?
 }
?>
</table>