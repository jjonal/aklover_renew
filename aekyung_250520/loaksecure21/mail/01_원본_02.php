<?
$table = 'mail';
if(!strcmp($_GET['type'], 'write')){
    if(!strcmp($_POST['hero_user'], '')){msg('유저를 선택하세요.','location.href="'.PATH_HOME.'?'.get('type','').'"');exit;}
    $data_i = '1';
    $count = @count($_POST);
    while(list($post_key, $post_val) = each($_POST)){
        if(!strcmp($count, $data_i)){
            $comma = '';
        }else{
            $comma = ', ';
        }
//        $sql_one_update .= $post_key.'=\''.$_POST[$post_key].'\''.$comma;
        if(!strcmp($post_key,"hero_command")){
            $command = nl2br(htmlspecialchars($_POST[$post_key]));
            $command = str_ireplace("<br />", "", $command);//글자 변경

            $sql_one_write .= $post_key.$comma;
            $sql_two_write .= '\''.$command.'\''.$comma;
        }else{
            $sql_one_write .= $post_key.$comma;
            $sql_two_write .= '\''.$_POST[$post_key].'\''.$comma;
        }
    $data_i++;
    }
    $sql = 'INSERT INTO '.$table.' ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
    mysql_query($sql);
    msg('발송 되었습니다.','location.href="'.PATH_HOME.'?'.get('type||hero_user||page||','').'"');
    exit;
}
?>
                        <link rel="stylesheet" href="<?=PATH_END?>mail/ui.css" />
                        <script src="<?=PATH_END?>mail/jquery.js"></script>
                        <script src="<?=PATH_END?>mail/ui.js"></script>
                        <script language='javascript'>
                        //새로고침방지
                        function noEvent() {
                            if (event.keyCode == 116) {
                                event.keyCode= 2;
                                return false;
                            }
                            else if(event.ctrlKey && (event.keyCode==78 || event.keyCode == 82))
                            {
                                return false;
                            }
                        }
                        //document.onkeydown = noEvent;
                        </script>

                        <style>
                            textarea {margin:0;padding:0}
                            input, textarea { font-size: 12px; line-height: 16px; vertical-align: middle; border: 1px solid #e4e4e4; color: #5e5e5e; }
                            textarea { overflow: auto; }

                            #draggable { top: 299px; left : 495px; width: 851px; height: 380px; padding: 0.5em; }/*205 || 495 || 851 || 380 */
                            span { font-size:12px; }
                            #list:hover{background: #B9DEFF;cursor:pointer;}
                        </style>

                        <script type="text/javascript">
                            $(document).ready(function(){
                                $("#draggable").draggable();
                                $("#close_popup").click(function(){
                                    $("#draggable").hide();
                                });
                            });
                            function showzip(){
                                $('#draggable').show();
                            }
                            function inputzip(){
                                $('#draggable').hide();
                            }
                        </script>
                        <!--<body oncontextmenu="return false">새로고침방지-->
                        <form name="form_next" action="<?=PATH_HOME.'?'.get('','type=write');?>" method="post" enctype="multipart/form-data"> 
                        <input type="hidden" name="hero_code" value="<?=$_SESSION['temp_code']?>">
                        <input type="hidden" name="hero_table" value="mail">
                        <input type="hidden" name="hero_today" value="<?=Ymdhis?>">
                        <input type="hidden" name="hero_name" value="<?=$_SESSION['temp_name']?>">
                        <table class="t_view" style="table-layout:fixed">
                            <colgroup>
                                <col width="150px">
                                <col width="550px">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th>보내는 사람</th>
                                    <td><input type="hidden" name="hero_nick" value="<?=$_SESSION['temp_nick']?>"><?=$_SESSION['temp_nick'];?></td>
                                </tr>
                                <tr>
                                    <th>받는 사람</th>
                                    <td>
                                        <div style="float:left;width:100%;"><a href="#" onclick="javascript:document.getElementById('hero_user').value='all'" class="btn_blue2">전체</a><a href="#" onclick="javascript:showzip();" class="btn_blue2">개인</a></div>
                                        <textarea id="hero_user" name="hero_user" class="textarea" style="float:left;width:700px;height:50px;word-break:break-all"><?=$_REQUEST['hero_user'];?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th>제목</th>
                                    <td><input type="text" id="hero_title" name="hero_title" value="<?=$main_list['hero_title'];?>" style="width:700px;height:20px;"></td>
                                </tr>
                                <tr>
                                    <th>내용</th>
                                    <td><textarea name="hero_command" id="editor" class="textarea" style="width:700px; height:300px;"><?=$out_row['hero_command'];?></textarea></td>
                                </tr>
                        </tbody>
                        </table>
                        <script>
function change(inputID, inputVALUE) {
var f = document.getElementById(inputID);
var temp_user = document.getElementById('hero_user').value;
    if(f.checked == false){
        f.checked = true;
        if(temp_user=='all'){
            document.getElementById('hero_user').value=inputVALUE;
            document.getElementById('hero_user_01').value=inputVALUE;
        }else if(temp_user==''){
            document.getElementById('hero_user').value=inputVALUE;
            document.getElementById('hero_user_01').value=inputVALUE;
        }else{
            document.getElementById('hero_user').value=temp_user+'||'+inputVALUE;
            document.getElementById('hero_user_01').value=temp_user+'||'+inputVALUE;
        }
    }else{
        f.checked = false;
        var delete_temp = document.getElementById('hero_user').value.split("||");
        var del_len = delete_temp.length;
        for(var i=0; i<=del_len; i++){
            if(delete_temp[i] == inputVALUE){
                var deldel = i;
            }
        }
        var delete_end = delete_temp.splice(deldel, 1);
        document.getElementById('hero_user').value=delete_temp.join('||');
        document.getElementById('hero_user_01').value=delete_temp.join('||');
        
    }
} 
                        </script>
                        <div class="align_c margin_t20">
                            <a href="javascript:form_next.submit();" class="btn_blue2">보내기</a>
                        </div>
                        </form>
                        <div id="draggable" class="ui-widget-content" style="position:absolute;z-index:999;display:none;">
                            <div style="padding:5px;">
<!--                            <a href="#" onclick="javascript:document.getElementById('hero_user').value='1';alert($('.hero_checkbox').attr('value'));" style="float:left;cursor:pointer" class="btn_blue2">입력</a><!--inputzip()-->
                            <span id="close_popup" onclick="javascript:inputzip();" style="margin-top:4px;margin-bottom:8px; float:right;cursor:pointer">닫기</span>
                            </div>
                            <div height="500px" id="layer" style='word-break:break-all;border: 1px solid #e4e4e4;padding:5px; width:828px; height:300px; overflow-y:auto; margin:auto; padding-bottom:15px;'>
<?
if(strcmp($_REQUEST['kewyword'], '')){
    $search = ' and '.$_REQUEST['select'].' like \'%'.$_REQUEST['kewyword'].'%\'';
    $search_next = '&select='.$_REQUEST['select'].'&kewyword='.$_REQUEST['kewyword'];
}
######################################################################################################################################################
$sql = 'select * from member where hero_level<=\''.$_SESSION['temp_level'].'\' '.$search.' ';
sql($sql);
$total_data = @mysql_num_rows($out_sql);
######################################################################################################################################################
$list_page=9;
$page_per_list=10;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path=get("page");
######################################################################################################################################################
$sql = 'select * from member where hero_level<=\''.$_SESSION['temp_level'].'\''.$search.$view_order.' limit '.$start.','.$list_page.';';
//$sql = 'select hero_idx, hero_id, hero_name from member';
sql($sql, 'end');
$count = @mysql_num_rows($out_sql);
?>

                            <table width="100%" style="text-align:center">
                                <colgroup>
                                    <col width="30px">
                                    <col width="30px">
                                    <col width="30px">
                                    <col width="140px">
                                    <col>
                                </colgroup>
                                <tbody>
                                <tr>
                                    <th>닉네임</th>
                                    <th>아이디</th>
                                    <th>이름</th>
                                    <th>핸드폰</th>
                                </tr>
                                <form name="frm" id="frm" method="post">
<?
$check_i = '1';
while($list  = @mysql_fetch_assoc($out_sql)){
?>
                                <tr id="list" onClick="javascript:change('chk<?=$check_i?>', '<?=$list['hero_id'];?>');" onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
                                    <td>
                                        <input type="hidden" class="hero_checkbox" id="<?='chk'.$check_i?>" name="<?='chk'.$check_i?>" value="<?=$list['hero_id'];?>"><!--checkbox-->
                                        <?=$list['hero_nick'];?>
                                    </td>
                                    <td>
                                        <?=$list['hero_id'];?>
                                    </td>
                                    <td>
                                        <?=$list['hero_name'];?>
                                    </td>
                                    <td>
                                        <?=$list['hero_hp'];?>
                                    </td>
                                </tr>
<script>
var delete_temp = document.getElementById('hero_user').value.split("||");
var del_len = delete_temp.length;
for(var i=0; i<=del_len; i++){
    if(delete_temp[i] == "<?=$list['hero_id'];?>"){
        document.getElementById("chk<?=$check_i?>").checked=true;
    }
}
</script>
<?
$check_i++;
}
?>
                                </form>
                            </tbody>
                        </table>
                        <div style="width:100%; text-align:center; margin-top:20px;">
<?
function page2($total,$list,$tail,$page,$next_path){
    global $PHP_SELF;
    $total_page = ceil($total/$list);
    if (!$page) $page = 1;
    $page_list = ceil($page/$tail)-1;
    if($page_list>0){
        $tail_page  = '     <a href="#" onclick="javascript:go_submit(form_next,\''.$next_path.'\',\'1\')"><span class="page"><<</span></a>'.PHP_EOL;
        $prev_page  = ($page_list-1)*$tail+1;
        $tail_page  = '     <a href="#" onclick="javascript:go_submit(form_next,\''.$next_path.'\',\''.$prev_page.'\')"><span class="page"><</span></a>'.PHP_EOL;
    }
    $page_end=($page_list+1)*$tail;
    if($page_end>$total_page) $page_end=$total_page;
    for($setpage=$page_list*$tail+1;$setpage<=$page_end;$setpage++){
        if ($setpage==$page){
            $tail_page .= '                            <a href="#" class="on"><span class="page">'.$setpage.'</span></a>'.PHP_EOL;
        }else{
            $tail_page .= '                            <a href="#" onclick="javascript:go_submit(form_next,\''.$next_path.'\',\''.$setpage.'\')"><span>'.$setpage.'</span></a>'.PHP_EOL;
        }
    }
    if($page_end<$total_page){
        $next_page = ($page_list+1)*$tail+1;
        $tail_page .= '     <a href="#" onclick="javascript:go_submit(form_next,\''.$next_path.'\',\''.$next_page.'\')"><span class="page">></span></a>'.PHP_EOL;
        $tail_page .= '     <a href="#" onclick="javascript:go_submit(form_next,\''.$next_path.'\',\''.$total_page.'\')"><span class="page">>></span></a>'.PHP_EOL;
    }
    return $tail_page;
}
?>
                        <div class="paginate">
<?
echo page2($total_data,$list_page,$page_per_list,$page,$next_path);
?>
                        </div>
<script>
function go_submit(temp_form,link,page){
    temp_form.action="<?=PATH_HOME?>?"+link+"&page="+page;
    temp_form.submit();
    return true;
}
</script>
                        </div>
<? //include_once BOARD_INC_END.'search.php';?>
                        <div class="searchbox" style="margin-top:20px;">
                            <div class="wrap_1">
                            <form action="<?=PATH_HOME.'?'.get('page');?>" method="POST" >
                                <input id="hero_user_01" name="hero_user" type="hidden" value="<?=$_REQUEST['hero_user'];?>">
                                <select name="select" id="">
                                  <option value="hero_nick"<?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>닉네임</option>
                                  <option value="hero_id"<?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>아이디</option>
                                  <option value="hero_name"<?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>성명</option>
                                  <option value="hero_hp"<?if(!strcmp($_REQUEST['select'], 'hero_hp')){echo ' selected';}else{echo '';}?>>핸드폰</option>
                                </select>
                                <input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];?>" class="kewyword">
                                <input type="image" src="../image/bbs/btn_search.gif" alt="검색" class="bd0">
                            </form>
                            </div>
                        </div>

                            </div>
                            <center>
                                <a href="#" onclick="javascript:inputzip();" style="cursor:pointer" class="btn_blue2">완료</a><!--inputzip()-->
                            </center>
                        </div>


                        <script>
                            var new_kewyword="<?=$_REQUEST['select']?>";
                            var new_page="<?=$_REQUEST['page']?>";
                            if(new_kewyword!=""){
                                showzip();
                            }
                            if(new_page!=""){
                                showzip();
                            }
                        </script>