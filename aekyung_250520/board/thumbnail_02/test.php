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
if(!strcmp($_GET['action'],"update")){
    $idx = $_GET['hero_idx'];
    $hero_idx = $_GET['idx'];
}else{
    $idx = $_GET['idx'];
    $hero_idx = $_GET['idx'];
}


$sql = 'select * from board where hero_table = \''.$hero_table.'\' and hero_idx=\''.$idx.'\';';
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
?>
<script type="text/javascript" src="/cheditor/cheditor.js"></script>
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
        <div class="contents">
        <form name="frm" method="post" action="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&next_board=<?=$_GET['next_board'];?>&view=action3&action=<?=$_GET['action'];?>&idx=<?=$hero_idx;?>&hero_idx=<?=$idx;?>&page=<?=$_GET['page'];?>" enctype="multipart/form-data">
            <input type="hidden" name="hero_drop" value="hero_drop||sm_file||command||chkbox">
            <input type="hidden" name="hero_code" value="<?=$_SESSION['temp_code'];?>">
            <input type="hidden" name="hero_review" value="<?=$_SESSION['temp_code'];?>">
            <input type="hidden" name="hero_today" value="<?=$totay;?>">
            <input type="hidden" name="hero_ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
            <input type="hidden" name="hero_review_count" value="<?=$review_count?>">
            <input type="hidden" name="hero_board_three" value="0">
            <input type="hidden" name="hero_name" value="<?=$name;?>">
            <input type="hidden" name="hero_01" value="<?=$_GET['idx'];?>">
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
                        <input type="text" name="hero_nick" id="hero_nick" title="작성자" value="<?=$nick;?>" readonly/>
<?
if(!strcmp($right_list['hero_type'], 'guide_3')){
?>
                        <input type="checkbox" id="chkbox" onClick='javascript:change("chkbox")'<?if(!strcmp($out_row['hero_table'], 'hero')){echo 'checked';}else{}?>>전체 공지시 [체크]
                        <input type="hidden" name="hero_table" value="<?=$hero_table;?>">
                        <script>
                        function change(inputID) {
                        var f = document.getElementById(inputID);
                        var table = document.getElementById("hero_table");
//                        alert(f.checked);
                            if(f.checked == true){
                                f.checked = true;
                                document.forms.frm.elements.hero_table.value='hero';
                            }else{
                                f.checked = false;
                                document.forms.frm.elements.hero_table.value="<?=$_REQUEST['board'];?>";
                            }
                        } 
                        </script>
<?}else{?>
                        <input type="hidden" name="hero_table" value="<?=$hero_table;?>">
<?}?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center" valign="top" style="padding-top:10px;padding-bottom:10px">
                        <textarea id="editor" name="command"><?=$out_row['hero_command']?></textarea>
                    </td>
                </tr>
                <tr class="last">
                    <th><center>파일</center></th>
                    <td>
                        <input type="file" name="hero_board_one[]" title="첨부파일" value="<?=$out_row['hero_board_one'];?>"/>
                    </td>
                </tr>
            </table>
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
$sql = 'select * from hero_group where hero_board = \''.$_GET['board'].'\'';
sql($sql, 'on');
$check_list                             = @mysql_fetch_assoc($out_sql);
?>
      <div class="btngroup">
        <div class="btn_l">
<?
if(strcmp($_GET['view'], '')){
?>
            <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_list.gif" alt="목록" /></a>
<?
}
?>
        </div>
        <div class="paging">
        </div>
        <div class="btn_r">
            <input type="image" src="<?=DOMAIN_END?>image/bbs/btn_confrim2.gif" onclick="javascript:return doSubmit(frm);">
            <a href="<?=PATH_HOME.'?'.get('view||action','view=view');?>"><img src="../image/bbs/btn_cancle.gif" alt="취소" /></a>
        </div>
      </div>

        </form>
        </div>
    </div>
    <script type="text/javascript">
    function doSubmit (theform){
        myeditor.outputBodyHTML();
        var title = theform.hero_title;
        var name = theform.hero_nick;
        var cmd = theform.command;

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
    myeditor.config.editorWidth = '100%';        // 에디터 가로폭입니다.
    myeditor.inputForm = 'editor';             // textarea의 id 이름입니다. 주의: name 속성 이름이 아닙니다.
    myeditor.run();                             // 에디터를 실행합니다.
    </script>