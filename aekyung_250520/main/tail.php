<?
####################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
####################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
####################################################################################################################################################
//20140502 요청 google analytics 설치//
include_once FREEBEST_INC_END.'analyticstracking.php';
/////////////////////////////////////////
?>
    <div class="clearfix"></div>
</div>
<div class="footer">
    <div class="footer_cnt">
        <img src="../image/common/footer.gif" alt="애경산업(주)" usemap="#Map" border="0">
        <map name="Map" id="Map">
            <area shape="rect" coords="164,6,209,20" href="<?=MAIN_HOME?>?board=group_04_03" alt="공지사항" />
            <area shape="rect" coords="226,8,269,22" href="<?=MAIN_HOME?>?board=cus_4" alt="사이트맵" />
          <area shape="rect" coords="291,9,336,23" href="javascript:popup('02', '/popup/term1.html', 500, 350, 10, 10,'yes');" />
          <area shape="rect" coords="350,8,444,22" href="javascript:popup('02', '/popup/term2.html', 500, 400, 10, 10,'yes');" />
      </map>
        <select name="" onchange="window.open(this.value)">
          <option value="#" selected>::::::::::::Family Site::::::::::::</option>

<?
$sql = 'select * from hero_group where hero_group=\'site\' and hero_use=\'1\' order by hero_order asc;';//desc//asc// limit 0,5
//$sql = out($sql); 
sql($sql);
while($site_list                             = @mysql_fetch_assoc($out_sql)){
?>
          <option value="<?=url($site_list['hero_href']);?>"><?=$site_list['hero_title']?></option>
<?}?>
      </select>
  </div>
</div>
</body>
</html>
