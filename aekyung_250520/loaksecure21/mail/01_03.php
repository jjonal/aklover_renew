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
        $sql_one_write .= $post_key.$comma;
        $sql_two_write .= '\''.$_POST[$post_key].'\''.$comma;

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
                        <script>
                        function change(inputID) {
                        var f = document.getElementById(inputID);
                            if(f.checked == false){
                                f.checked = true;
                            }else{
                                f.checked = false;
                            }
                        } 
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
                            $(document).ready(function(){
                                $("#btnSubmit").click(function(){
                                    var checkboxVal = $(":checkbox:checked").map(function(){
                                        return $(this).val();
                                    }).get().join("||");
                                    var radioVal = $("#frm>:radio:checked").map(function(){
                                        return $(this).val();
                                    }).get().join("||");
                                    var ccVal = $("#hero_user").map(function(){
                                        if($("#hero_user").val()==""){
                                            return $(this).val();
                                        }else if($("#hero_user").val()=="all"){
                                            $(this).val("");
                                            return $(this).val();
                                        }else{ 
                                            return $(this).val()+("||");
                                        }
                                    }).get().join("||");
                                    $("#hero_user").val( ccVal + checkboxVal);
                                    location.href = "<?=PATH_HOME?>?board=<?=$_GET['board']?>&idx=<?=$_GET['idx']?>&page=<?=$_GET['page']?>&hero_user="+ccVal + checkboxVal;
                                });
                            });
                        </script>
                        <form name="form_next" action="<?=PATH_HOME.'?'.get('','type=write');?>" method="post" enctype="multipart/form-data"> 
                        <input type="hidden" name="hero_code" value="<?=$_SESSION['temp_code']?>">
                        <input type="text" name="hero_table" value="mail">
                        <input type="text" name="hero_today" value="<?=Ymdhis?>">
                        <input type="text" name="hero_name" value="<?=$_SESSION['temp_name']?>">
                        <input type="text" name="hero_ddr" value="<?=$_REQUEST['hero_ddr']?>">
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
                                        <div style="float:left;width:100%;"><a href="#" onclick="javascript:document.getElementById('hero_user').innerHTML='all'" class="btn_blue2">전체</a><a href="#" onclick="javascript:showzip();" class="btn_blue2">개인</a></div>
                                        <textarea id="hero_user" name="hero_user" class="textarea" style="width:700px; height:50px;" style="float:left;width:700px;word-break:break-all"><?=$_REQUEST['hero_user'];?></textarea>
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
                            function go_list(){
                                location.href = "./index.php?board=<?=$_GET['board']?>&idx=<?=$_GET['idx']?>";
                            }
                        </script>
                        <div class="align_c margin_t20">
                            <a href="javascript:form_next.submit();" class="btn_blue2">보내기</a>
                        </div>
                        </form>
                        <div id="draggable" class="ui-widget-content" style="position:absolute;z-index:999;display:none;">
                            <div style="padding:5px;">
<!--                            <a href="#" onclick="javascript:document.getElementById('hero_user').innerHTML='1';alert($('.hero_checkbox').attr('value'));" style="float:left;cursor:pointer" class="btn_blue2">입력</a><!--inputzip()-->
                            <span id="close_popup" onclick="javascript:inputzip();" style="margin-top:4px;margin-bottom:8px; float:right;cursor:pointer">닫기</span>
                            </div>
                            <div height="500px" id="layer" style='word-break:break-all;border: 1px solid #e4e4e4;padding:5px; width:828px; height:300px; overflow-y:auto; margin:auto; padding-bottom:15px;'>
<?
if(strcmp($_POST['kewyword'], '')){
    $search = ' and '.$_POST['select'].' like \'%'.$_POST['kewyword'].'%\'';
    $search_next = '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
}else if(strcmp($_GET['kewyword'], '')){
    $search = ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
    $search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
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
$next_path=get();
######################################################################################################################################################
$sql = 'select * from member where hero_level<=\''.$_SESSION['temp_level'].'\''.$search.$view_order.' limit '.$start.','.$list_page.';';
//$sql = 'select hero_idx, hero_id, hero_name from member';
sql($sql, 'end');
$count = @mysql_num_rows($out_sql);
?>

                            <table width="100%" style="text-align:center">
                                <colgroup>
                                    <col width="20px">
                                    <col width="30px">
                                    <col width="30px">
                                    <col width="150px">
                                    <col>
                                </colgroup>
                                <tbody>
                                <tr>
                                    <th>체크</th>
                                    <th>닉네임</th>
                                    <th>아이디</th>
                                    <th>이름</th>
                                </tr>
                                <form name="frm" id="frm" method="post">
<?
$check_i = '1';
while($list  = @mysql_fetch_assoc($out_sql)){ 
?>

                                <tr id="list" onClick="if(document.getElementById('chk<?=$check_i?>').checked == false){this.bgColor='#B9DEFF';}else{this.bgColor='';};change('chk<?=$check_i?>');" onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
                                    <td>
                                        <input type="checkbox" class="hero_checkbox" id="<?='chk'.$check_i?>" name="<?='chk'.$check_i?>" value="<?=$list['hero_id'];?>">
                                    </td>
                                    <td>
                                        <?=$list['hero_nick'];?>
                                    </td>
                                    <td>
                                        <?=$list['hero_id'];?>
                                    </td>
                                    <td>
                                        <?=$list['hero_name'];?>
                                    </td>
                                </tr>

<?
$check_i++;
}
?>
                                </form>
                            </tbody>
                        </table>
                        <div style="width:100%; text-align:center; margin-top:20px;">
<? include_once PATH_INC_END.'page.php';?>
                        </div>
<? //include_once BOARD_INC_END.'search.php';?>
                        <div class="searchbox" style="margin-top:20px;">
                            <div class="wrap_1">
                            <form action="<?=PATH_HOME.'?'.get('page');?>" method="POST" >
                                <select name="select" id="">
                                  <option value="hero_nick"<?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>닉네임</option>
                                  <option value="hero_id"<?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>아이디</option>
                                  <option value="hero_name"<?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>성명</option>
                                </select>
                                <input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];?>" class="kewyword">
                                <input type="image" src="../image/bbs/btn_search.gif" alt="검색" class="bd0">
                            </form>
                            </div>
                        </div>

                            </div>
                            <center>
                                <a href="#" id="btnSubmit" style="cursor:pointer" class="btn_blue2">입력</a><!--inputzip()-->
                                <a href="#" onclick="javascript:inputzip();" style="cursor:pointer" class="btn_blue2">완료</a><!--inputzip()-->
                            </center>
                        </div>


                        <script>
                            var new_kewyword="<?=$_POST['select']?>";
                            var new_page="<?=$_GET['page']?>";
                            var new_view_list="<?=$_GET['hero_user']?>";
                            if(new_kewyword!=""){
//                                $('#draggable').show();
                                showzip();
//                                document.getElementById('draggable').style.display='block';
//                                alert(new_kewyword);
                            }
                            if(new_page!=""){
                                showzip();
                            }
                            if(new_view_list!=""){
                                showzip();
                            }
                        </script>