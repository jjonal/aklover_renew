<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
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
######################################################################################################################################################
$cut_title_name = '26';
$_GET['board'];
$sql = 'select * from mission where hero_table = \''.$_GET['board'].'\' and hero_idx=\''.$_GET['idx'].'\';';
sql($sql, 'on');
    $out_row = @mysql_fetch_assoc($out_sql);//mysql_fetch_row
######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);
//echo $right_list['hero_view'];
//echo $_SESSION['temp_level'];
//if( ( ($right_list['hero_view'] >= $_SESSION['temp_level']) and (strcmp($_SESSION['temp_level'], '')) ) or (!strcmp($right_list['hero_view'], '99')) ){
if($right_list['hero_view'] <= $my_view){
######################################################################################################################################################
$temp_id = $_SESSION['temp_id'];
$temp_code = $_SESSION['temp_code'];
$temp_title = $right_list['hero_title'];
$temp_point = $right_list['hero_view_point'];
$temp_idx = $_GET['idx'];

$view_sql = 'select * from point where hero_table=\''.$_GET['board'].'\' and hero_old_idx=\''.$temp_idx.'\' and hero_type=\''.$_GET['view'].'\' and hero_id = \''.$temp_id.'\' order by hero_today desc limit 0,1;';
$view_out_sql = mysql_query($view_sql);
$view_list                             = @mysql_fetch_assoc($view_out_sql);
$last_day = date( "Ymd", strtotime($view_list['hero_today']));
$to_day = date( "Ymd", time());
//echo $out_row['hero_code'];
//echo $temp_code;
//if(strcmp($to_day, $last_day)){
######################################################################################################################################################
if(!strcmp($_GET['type'], 'edit')){
$data_i='1';
$count = @count($_POST);
    while(list($post_key, $post_val) = each($_POST)){
        if(!strcmp($count, $data_i)){
            $comma = '';
        }else{
            $comma = ', ';
        }
        $sql_one .= $post_key.$comma;
        $sql_two .= '\''.$_POST[$post_key].'\''.$comma;
    $data_i++;
    }
    $sql = 'INSERT INTO mission_review ('.$sql_one.') VALUES ('.$sql_two.');';
    mysql_query($sql);
    if( (strcmp($to_day, $last_day)) and (strcmp($out_row['hero_code'], $temp_code)) ){
        $sql_one_write = 'hero_code, hero_table, hero_type, hero_old_idx, hero_id, hero_title, hero_name, hero_nick, hero_point, hero_today';
        $sql_two_write = '\''.$_SESSION['temp_code'].'\', \''.$_GET['board'].'\', \''.$_GET['view'].'\', \''.$temp_idx.'\', \''.$temp_id.'\', \''.$temp_title.'\', \''.$_SESSION['temp_name'].'\', \''.$_SESSION['temp_nick'].'\', \''.$temp_point.'\', \''.Ymdhis.'\'';
        $up_sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
        sql($up_sql);
    }
    msg('등록 되었습니다.','location.href="'.PATH_HOME.'?board='.$_GET['board'].'&view=step_02&idx='.$_GET['idx'].'"');
}
?>
<script type="text/javascript">
    function showzip(){
        $('.layer_zip').show();
    }
    function inputzip(){
        $('.layer_zip').hide();
    }
    function fnLoad_01(a,b,c,d,e,f){
        document.getElementById("hero_address_01").value=a;
        document.getElementById("hero_address_02").value=b + ' ' + c + d + e;
        $('.layer_zip').hide();
    }
    function go_submit(form) {
//##################################################################################################################################################//
        var hero_02 = form.hero_02;
        var new_name = form.hero_new_name;
        var hero_03 = form.hero_03;
        var address_01 = form.hero_address_01;
        var address_02 = form.hero_address_02;
        var hp_01 = form.hero_hp_01;
        var hp_02 = form.hero_hp_02;
        var hp_03 = form.hero_hp_03;
//##################################################################################################################################################//
        if(hero_02.value == ""){
            alert("신청 한마디를 입력해주세요.");
            hero_02.style.border = '1px solid red';
            hero_02.focus();
            return false;
        }else{
            hero_02.style.border = '1px solid #e4e4e4';
        }
        if(hero_03.value == ""){
            alert("신청필수정보를 입력해주세요.");
            hero_03.style.border = '1px solid red';
            hero_03.focus();
            return false;
        }else{
            hero_03.style.border = '1px solid #e4e4e4';
        }
        if(new_name.value == ""){
            alert("받으시는분 이름을 입력해주세요.");
            new_name.style.border = '1px solid red';
            new_name.focus();
            return false;
        }else{
            new_name.style.border = '1px solid #e4e4e4';
        }
        if(address_01.value == ""){
            alert("배송지 주소 입력해주세요.");
            address_01.style.border = '1px solid red';
            address_01.focus();
            return false;
        }else{
            address_01.style.border = '1px solid #e4e4e4';
        }
        if(address_02.value == ""){
            alert("배송지 주소 입력해주세요.");
            address_02.style.border = '1px solid red';
            address_02.focus();
            return false;
        }else{
            address_02.style.border = '1px solid #e4e4e4';
        }
        if(hp_01.value == ""){
            alert("연락처를 입력해주세요.");
            hp_01.style.border = '1px solid red';
            hp_01.focus();
            return false;
        }else{
            hp_01.style.border = '1px solid #e4e4e4';
        }
        if(hp_02.value == ""){
            alert("연락처를 입력해주세요.");
            hp_02.style.border = '1px solid red';
            hp_02.focus();
            return false;
        }else{
            hp_02.style.border = '1px solid #e4e4e4';
        }
        if(hp_03.value == ""){
            alert("연락처를 입력해주세요.");
            hp_03.style.border = '1px solid red';
            hp_03.focus();
            return false;
        }else{
            hp_03.style.border = '1px solid #e4e4e4';
        }
            form.submit();
//##################################################################################################################################################//
        return true;
    }
</script>
<div class="contents_area">
    <div class="page_title">
        <h2><img src="<?=str($right_list['hero_right']);?>" alt="<?=$right_list['hero_title'];?>" /></h2>
        <ul class="nav">
            <li><img src="../image/common/icon_nav_home.gif" alt="home" /></li>
            <li>&gt;</li>
            <li><?=$right_list['hero_top_title']?></li>
            <li>&gt;</li>
            <li class="current"><?=$right_list['hero_title']?></li>
        </ul>
    </div>
    <div class="contents"> <img src="../image/mission/spm_txt_reviewer.gif" alt="리뷰어신청자" />
        <form name="form_next" action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post" enctype="multipart/form-data" onsubmit="return false;"> 
            <input type="hidden" name="hero_code" value="<?=$_SESSION['temp_code'];?>">
            <input type="hidden" name="hero_old_idx" value="<?=$_GET['idx'];?>">
            <input type="hidden" name="hero_table" value="<?=$_GET['board'];?>">
            <input type="hidden" name="hero_name" value="<?=$_SESSION['temp_name'];?>">
            <input type="hidden" name="hero_nick" value="<?=$_SESSION['temp_nick'];?>">
            <input type="hidden" name="hero_id" value="<?=$_SESSION['temp_id'];?>">
            <input type="hidden" name="hero_today" value="<?=Ymdhis?>">
            <input type="hidden" name="hero_ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
            <input type="hidden" name="hero_level" value="<?=$_SESSION['temp_level']?>">
            <input type="hidden" name="hero_power" value="<?=$_SESSION['temp_power']?>">

        <div class="spm"> <img src="../image/mission/spm_infobg_1.gif" alt="top" /> </div>
            <div class="spm_txt spm_step2">
                <dl>
                <dt><img src="../image/mission/spm_st2_txt1.gif" alt="항목1" /></dt>
                <dd>
                <label for=""><img src="../image/mission/txt_regblog.gif" alt="등록된 블로그" /></label>
                <select name="hero_01">
        <?
        $sql = 'select * from member where hero_id=\''.$_SESSION['temp_id'].'\'';//desc//asc// limit 0,5
        //$sql = out($sql); 
        sql($sql);
        $site_list                             = @mysql_fetch_assoc($out_sql);
        ?>
                  <option value="<?=url($site_list['hero_blog_01']);?>">페이스북 URL</option>
                  <option value="<?=url($site_list['hero_blog_02']);?>">트위터 URL</option>
                  <option value="<?=url($site_list['hero_blog_03']);?>">카카오스토리 URL</option>
                  <option value="<?=url($site_list['hero_blog_04']);?>">미투데이 URL</option>
                  <option value="<?=url($site_list['hero_blog_05']);?>">그외 SNS URL</option>

                </select>
<!--                <a href="#"><img src="../image/mission/btn_blogedit.gif" alt="수정하기" /></a> -->
                </dd>
                </dl>
                <div class="bddot"></div>
                <dl>
                <dt><img src="../image/mission/spm_st2_txt2.gif" alt="항목2" /></dt>
                <dd> 
                <ul>
                <li class="c_orange">신청 한마디를 남겨주세요.</li>
                <li>
                <textarea name="hero_02" id="hero_02" cols="30" rows="10" style="width:560px;"></textarea>
                </li>
                </ul>
                </dd>
                </dl>
                <div class="bddot"></div>
                <dl>
                <dt><img src="../image/mission/spm_st2_txt3.gif" alt="항목3" /></dt>
                <dd>
                <ul>
                <li class="c_orange">신청시 아래사항을 확인해주세요.</li>
                <li>
                    <pre>
<?=$out_row['hero_ask']?>
                    </pre>
                </li>
                <li>
                <label for="">신청필수정보</label>
                <input type="text" name="hero_03" id="hero_03" style="width:470px;" />
                </li>
                </ul>
                </dd>
                </dl>
                <div class="bddot"></div>
                <dl>
                <dt><img src="../image/mission/spm_st2_txt4.gif" alt="항목4" /></dt>
                <dd>
                    <ul>
                        <li class="c_orange">리뷰 상품을 배송 받을 주소를 입력해주세요.</li>
                        <li><label for="">받으시는분</label>
                            <input type="text" name="hero_new_name" id="hero_new_name" style="width:186px;">
                        </li>
                        <li>
                            <label for="">배송지 주소</label>
                            <input type="text" name="hero_address_01" id="hero_address_01" value="<?=$member_list['hero_address_01']?>" onclick="javascript:showzip()" readonly/>
                            <a href="javascript:showzip()"><img src="../image/member/btn_zipcode.gif" alt="우편번호찾기" /></a><br />
                            <label for=""></label>
                            <input type="text" name="hero_address_02" id="hero_address_02" value="<?=$member_list['hero_address_02']?>" style="width:186px;" onclick="javascript:showzip()" readonly/>
                            <input type="text" name="hero_address_03" id="hero_address_03" value="<?=$member_list['hero_address_03']?>" style="width:186px;">
                        </li>
                        <li><label for="">연락처</label>
                            <input type="text" name="hero_hp_01" id="hero_hp_01" onKeyUp="if(this.value.length >= 3)hero_hp_02.focus();" maxlength="3" style="ime-mode:disabled;"/> - 
                            <input type="text" name="hero_hp_02" id="hero_hp_02" onKeyUp="if(this.value.length >= 4)hero_hp_03.focus();" maxlength="4" style="ime-mode:disabled;"/> - 
                            <input type="text" name="hero_hp_03" id="hero_hp_03" maxlength="4" style="ime-mode:disabled;"/>
                        </li>
                    </ul>
                </dd>
                </dl>
            <div class="clearfix"></div>
        </div>
        <div class="spm"> <img src="../image/mission/spm_infobg_3.gif" alt="top" /> </div>
        <div class="btn_group tc mt60">
<!--            <a href="javascript:form_next.submit();" class="btn_blue2"><img src="../image/mission/btn_mission_jion.gif" alt="미션참여하기" /></a>-->
            <input type="image" src="../image/mission/btn_mission_jion.gif" alt="미션참여하기" onClick="go_submit(this.form)"/>
        </div>
    </form>
    </div>
</div>
        <div class="layer_zip">
            <dl>
            <form name="login_form" action="<?=PATH_HOME?>?board=result" onsubmit="return false;">
                <dt><img src="../image/member/zip1.gif" alt="우편번호 찾기" /></dt>
                <dd>
                <input id="addr" type="text" class="addr" /><input type="image" src="../image/member/btn_findzip.gif" alt="주소찾기" onclick="hero_ajax('zip.php', 'view_list', 'addr', 'zip'); return false;"/>
                </dd>
                <dd class="list">
                    <div id="view_list"></div>
                </dd>
                <dd class="tc"><a href="javascript:inputzip();"><img src="../image/member/btn_cancel.gif" alt="입력" /></a></dd>
            </form>
            </dl>
        </div>
<?
}else{
        $msg = '권한';
        $action_href = PATH_HOME.'?'.get('view');
        msg($msg.' 없습니다.','location.href="'.$action_href.'"');
    exit;
}
?>