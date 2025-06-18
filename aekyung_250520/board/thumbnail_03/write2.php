<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
//border:1px solid #000000;
######################################################################################################################################################
$_GET['board'];
if(!strcmp($_GET['next_board'],"hero")){
    $hero_table = 'hero';
}else{
    $hero_table = $_REQUEST['board'];
}

$sql = 'select * from board where hero_table = \''.$hero_table.'\' and hero_idx=\''.$_GET['idx'].'\';';
sql($sql, 'on');
    $out_row = @mysql_fetch_assoc($out_sql);//mysql_fetch_row

    if(!strcmp($_GET['action'], 'update')){
        $name = $out_row['hero_name'];
        $nick = $out_row['hero_nick'];
        $totay = $out_row['hero_today'];
        $review_count = $out_row['hero_review_count'];
    }else if(!strcmp($_GET['action'], 'write')){
        $name = $_SESSION['temp_name'];
        $nick = $_SESSION['temp_nick'];
        $totay = Ymdhis;
        $review_count = '0';
    }else{
        echo '<script>location.href="./out.php"</script>';
        exit;
    }
    if(!strcmp($out_row['hero_today'], '')){

    }else{

    }
######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);
$pk_sql = 'select * from level where hero_level = \''.$_SESSION['temp_level'].'\'';
$out_pk_sql = mysql_query($pk_sql);
$pk_row                             = @mysql_fetch_assoc($out_pk_sql);
?>
<script type="text/javascript" src="/smarteditor2/js/HuskyEZCreator.js" charset="euc-kr"></script>

<div id="subpage">
    <div class="sub_wrap">
        <div class="contents">
            <form name="frm" method="post" action="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&next_board=<?=$_GET['next_board'];?>&view=action&action=<?=$_GET['action'];?>&idx=<?=$_GET['idx'];?>&page=<?=$_GET['page'];?>" enctype="multipart/form-data">
                <input type="hidden" name="hero_drop" value="hero_drop||sm_file||command||chkbox">
                <input type="hidden" name="hero_code" value="<?=$_SESSION['temp_code'];?>">
                <input type="hidden" name="hero_review" value="<?=$_SESSION['temp_code'];?>">
                <input type="hidden" name="hero_today" value="<?=$totay;?>">
                <input type="hidden" name="hero_ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
                <input type="hidden" name="hero_review_count" value="<?=$review_count?>">
                <input type="hidden" name="hero_name" id="hero_name" title="작성자" value="<?=$name;?>" readonly/>
                <?if(!strcmp($_GET['board'], 'group_04_10')){?>
                <input type="hidden" name="hero_02" value="1">
                <?}?>
                <table border="0" cellpadding="0" cellspacing="0" class="bbs_view">
                    <colgroup>
                        <col width="90px" />
                        <col width="*" />
                    </colgroup>
                    <tr class="bbshead">
                        <th><img src="../image/bbs/tit_subject.gif" alt="제목" /></th>
                        <td>
                            <input type="text" name="hero_title" id="hero_title" class="w590" title="제목" value="<?=$out_row['hero_title'];?>" />
                        </td>
                    </tr>
                    <tr>
                        <th><img src="../image/bbs/tit_writer.gif" alt="작성자" /></th>
                        <td>
                            <img src="<?=str($pk_row['hero_img_new'])?>" /><input type="text" name="hero_nick" id="hero_nick" title="작성자" value="<?=$nick;?>" readonly/>
    <?
    //                        alert(all.innerHTML);
    //                        alert(all.style.color);
    if(!strcmp($out_row['hero_table'], '')){
        $new_table = $_GET['board'];
        $new_notice = '0';
        $old_table = $_GET['board'];
        $old_notice = '0';
    }else{
        $new_table = $out_row['hero_table'];
        $new_notice = $out_row['hero_notice'];

        $old_table = $out_row['hero_03'];
        $old_notice = $out_row['hero_notice'];

        if(!strcmp($out_row['hero_table'], 'hero')){
            $hero_checked_01 = ' checked';
            $hero_checked_font_01 = ' style="color:red;font-weight:bold"';
            $hero_checked_02 = ' disabled';
        }else if(!strcmp($out_row['hero_notice'], '1')){
            $hero_checked_font_02 = ' style="color:red;font-weight:bold"';
            $hero_checked_01 = ' disabled';
            $hero_checked_02 = ' checked';
        }
    }
    ?>
    <?
    if( (!strcmp($_SESSION['temp_level'], '9999')) or (!strcmp($_SESSION['temp_level'], '10000')) ){
    ?>
                            <input type="hidden" name="hero_table" value="<?=$new_table;?>">
                            <input type="hidden" name="hero_notice" value="<?=$new_notice;?>">
    <?}else{?>
                            <input type="hidden" name="hero_table" value="<?=$new_table;?>">
                            <input type="hidden" name="hero_notice" value="<?=$new_notice;?>">
    <?
    }
    //if( (!strcmp($right_list['hero_type'], 'guide_3')) or (!strcmp($_SESSION['temp_level'], '100')) ){
        if( (!strcmp($_SESSION['temp_level'], '9999')) or (!strcmp($_SESSION['temp_level'], '10000')) ){
    ?>
                            <input type="checkbox" id="chkbox" onClick='javascript:change("chkbox")'<?=$hero_checked_01?>><span id="hero_all"<?=$hero_checked_font_01?>>전체</span>
    <?
        }
    //}
    ?>
                            <script>
                            function change(inputID){
                            var f = document.getElementById(inputID);
                            var chkbox_01 = document.forms.frm.elements.chkbox;
                            var chkbox_02 = document.forms.frm.elements.chkbox2;
                            var all = document.getElementById("hero_all");
                            var each = document.getElementById("hero_each");
                                if(inputID == "chkbox"){
                                    if(f.checked == true){
    <?if(!strcmp($_SESSION['temp_level'], '9999')){?>
                                        chkbox_02.disabled = true;
    <?}?>
                                        document.forms.frm.elements.hero_table.value="hero";
                                        document.forms.frm.elements.hero_notice.value="0";
                                        all.style.color="red";
                                        all.style.fontWeight="bold";
                                    }else{
    <?if(!strcmp($_SESSION['temp_level'], '9999')){?>
                                        chkbox_02.disabled = false;
    <?}?>
                                        document.forms.frm.elements.hero_table.value="<?=$old_table?>";
                                        document.forms.frm.elements.hero_notice.value="0";
                                        all.style.color="";
                                        all.style.fontWeight="";
                                    }
                                }else if(inputID == "chkbox2"){
                                    if(f.checked == true){
                                        chkbox_01.disabled = true;
                                        document.forms.frm.elements.hero_table.value="<?=$old_table?>";
                                        document.forms.frm.elements.hero_notice.value="1";
                                        each.style.color="red";
                                        each.style.fontWeight="bold";
                                    }else{
                                        chkbox_01.disabled = false;
                                        document.forms.frm.elements.hero_table.value="<?=$old_table?>";
                                        document.forms.frm.elements.hero_notice.value="0";
                                        each.style.color="";
                                        each.style.fontWeight="";
                                    }
                                }
                            }
                            </script>
    <?
    if(!strcmp($_SESSION['temp_level'], '9999')){
    ?>
                            <input type="checkbox" id="chkbox2" onClick='javascript:change("chkbox2")'<?=$hero_checked_02?>><span id="hero_each"<?=$hero_checked_font_02?>>개별</span>
    <?
    $old_title_sql = 'select * from hero_group where hero_board =\''.$old_table.'\';';
    $out_old_title = mysql_query($old_title_sql);
    $old_title_list                             = @mysql_fetch_assoc($out_old_title);
    echo '<font color="orange">'.$old_title_list['hero_title'].'</font>';
    }
    ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center" valign="top" style="padding-top:10px;padding-bottom:10px">
    <!--                        <textarea name="" id="" cols="30" rows="10" title="내용" ></textarea>-->
                            <div style="position:relative;">
                                <div style="position:absolute; top:9px; left:93%; cursor:pointer;">
                                    <a onclick="javascript:window.open('<?=BOARD_END?>pop_up.php?id=editor', 'uploader', 'width=417, height=100, left=550, top=320');">
                                        <img src="../img/photo.png" style="vertical-align:middle;"><span class="se2_mntxt" style="font-size:11px;">사진</span>
                                    </a>
                                </div>
                            </div>
                            <input type="hidden" name="sm_file">
                            <textarea name="command" id="editor" class="textarea" style="width:700px; height:300px;"><?=$out_row['hero_command'];?></textarea>



                            <script type="text/javascript" src="/loak/loak.js?v=1"></script>
                            <form method="post" name="theform" onsubmit="return doSubmit(this)">
                            <textarea id="fm_post" name="hero_command"><?=$list['hero_code'];?></textarea>
                                <input type="submit" value="글 가져오기" />
                                <input type=image src="http://aklover.co.kr/image/bbs/btn_list.gif" onclick="location.submit();">
                                <a href="#"  onclick="location.submit();"><img src="http://aklover.co.kr/image/bbs/btn_list.gif"></a>
                            </form>

                            <div class="align_c margin_t20">

                                <input type="button" value="이미지 정보" onclick="showImageInfo()" />

                                <a href="javascript:form_next.submit();" class="btn_blue2">보내기</a>
                            </div>
                            </form>
                            <script type="text/javascript">
                            function doSubmit (theform){
                                myeditor.outputBodyHTML();
                                theform.action = "edit.php?board=1234";
                                theform.submit();
                                return false;
                            }
                            function showImageInfo() {
                                var data = myeditor.getImages();
                                if (data == null) {
                                    alert('올린 이미지가 없습니다.');
                                    return;
                                }

                                for (var i=0; i<data.length; i++) {
                                    var str = 'URL: ' + data[i].fileUrl + "\n";
                                    str += '저장 경로: ' + data[i].filePath + "\n";
                                    str += '원본 이름: ' + data[i].origName + "\n";
                                    str += '저장 이름: ' + data[i].fileName + "\n";
                                    str += '크기: ' + data[i].fileSize;

                                    alert(str);
                                }
                            }
                            </script>
                            <script type="text/javascript">
                            var myeditor = new cheditor();              // 에디터 개체를 생성합니다.
                            myeditor.config.editorHeight = '300px';     // 에디터 세로폭입니다.
                            myeditor.config.editorWidth = '80%';        // 에디터 가로폭입니다.
                            myeditor.inputForm = 'fm_post';             // textarea의 id 이름입니다. 주의: name 속성 이름이 아닙니다.
                            myeditor.run();                             // 에디터를 실행합니다.
                            </script>

                        </td>
                    </tr>
                    <tr class="last">
                        <th><img src="../image/bbs/tit_file.gif" style="vertical-align:middle;"></th>
                        <td>
                            <input type="file" name="hero_board_one[]" title="첨부파일" value="<?=$out_row['hero_board_one'];?>"/>
                        </td>
                    </tr>
                </table>
    <? include_once BOARD_INC_END.'button.php';?>
            </form>
            </div>
    </div>
    </div>
    </div>
    <SCRIPT LANGUAGE="JavaScript">
        var oEditors = [];
        nhn.husky.EZCreator.createInIFrame({
            oAppRef: oEditors,
            elPlaceHolder: "editor",
            sSkinURI: "/smarteditor2/SmartEditor2Skin.html",
            htParams : {bUseToolbar : true,
                fOnBeforeUnload : function(){}
            }, //boolean
            fOnAppLoad : function(){
        },
        fCreator: "createSEditor2"
    });
    function pasteHTMLDemo(id, sHTML){
        oEditors.getById[id].exec("PASTE_HTML", [sHTML]);
    }
    function on_submit(){
        oEditors.getById["editor"].exec("UPDATE_CONTENTS_FIELD", []);
        var title = frm.hero_title;
        var name = frm.hero_nick;
        var cmd = frm.command;

        if(title.value == ""){
            alert("제목을 입력하세요.");
            title.style.border = '1px solid red';
            title.focus();
            return false;
        }else{
            title.style.border = '';
        }
        if(name.value == ""){
            alert("이름을 입력하세요.");
            name.style.border = '1px solid red';
            name.focus();
            return false;
        }else{
            name.style.border = '';
        }
        if(cmd.value == ""){
            alert("내용을 입력하세요.");
            cmd.style.border = '1px solid red';
            cmd.focus();
            return false;
        }else{
            cmd.style.border = '';
        }
//        if(confirm("입력하시겠습니까?")){
            frm.submit();
//        }
    }
    </SCRIPT>