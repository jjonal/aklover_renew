<br><br>
<?
$to_day = date('Y³â m¿ù dÀÏ', time());
function month_small($y,$m){
$dayspacer = @date("w",mktime(0,0,0,$m,1,$y));
$lastday = @date("t",mktime(0,0,0,$m,1,$y));
$today = date('Y-m-d', time());
echo "
<table border=0 cellspacing=0 cellpadding=0>
<tr><td align=center height=22>$m"."êÅ</td></tr>
<tr>
<td style='text-align:left'>
<font color=#ff3333>ìí</font> êÅ ûý â© ÙÊ ÐÝ <font color=blue>÷Ï</font><br>
";

for ($space = 0; $space < $dayspacer; $space++){
echo "<font color=#ffffff>00&nbsp;</font>";
}
for ($date=1 ; $date<=$lastday ; $date++){
    $str_date = @date("d",mktime(0,0,0,$m,$date,$y));
    $check_date = @date("Y-m-d",mktime(0,0,0,$m,$date,$y));
if ($check_date == $today){
    echo "<font color=green><b>$str_date</b>&nbsp;</font>";
}else if (@date("w",mktime(0,0,0,$m,$date,$y)) == 0){
    echo "<font color=#ff3333>$str_date&nbsp;</font>";
}else if (@date("w",mktime(0,0,0,$m,$date,$y)) == 6){
    echo "<font color=blue>$str_date&nbsp;</font>";
}else{
    echo "$str_date&nbsp;";
}
if (!(($space+$date)%7)){
echo "<br>";
}
}
echo "
</td>
</tr>
<tr><td align=center>&nbsp;</td></tr>
</table>
";
}
if (!$_POST['year']){
$year = date(Y);
}else{
$year = $_POST['year'];
}
$x = 4;
$y = 3;
$width = "100%";
echo "
<style>
td {  font-family: '±¼¸², ±¼¸²Ã¼'; font-size: 12px; color:#000000; line-height: 15px}
</style>
<table width=$width border=0 cellspacing=0 cellpadding=0 height=40>
<tr>
<td width=200>&nbsp;</td>
<td align=center><b>$year"."Ò´</b></td>
<form method=post action=$PHP_SELF?".get().">
<td width=200 align=center valign=bottom>$to_day
<input type=text name=year size=8 maxlength=4>Ò´ <input type=submit value='Go!'>
</td>
</form>
</tr>
<tr><td colspan=3 height=20>&nbsp;</td></tr>
</table>
<table width=$width border=0 cellspacing=0 cellpadding=0>
";
$month = 1;
for($i=0; $i<$y; $i++){
echo '<tr align=center valign=top>';
for($j=0; $j<$x; $j++){
echo "<td>"; 
month_small($year,$month);
echo "</td>"; 
$month++; 
} 
echo "</tr>"; 
} 
echo" 
</table> 
"; 
?>
<br>