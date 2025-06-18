<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
echo 'page : <font color=red>'.$_POST['page'].'</font><br>';
if(!strcmp($_POST['board'],'hero_01')){
    $ddr =  'bbs/'.$_POST['board'].'.php';
}
if(strcmp($_POST['board'],'')){
    include_once                                                    $HTTP_SERVER_VARS['DOCUMENT_ROOT'].'/'.$_POST['board'].'.php';
}
define('SELF',                          $HTTP_SERVER_VARS['PHP_SELF'],TRUE);
//hero_01는 파일명입니다.
//hero_01~hero_03.php라고 파일을 만들면 됩니다.
?>

<form name="bbs" action="<?='http://'.$HTTP_SERVER_VARS['HTTP_HOST'];?>" method="post" enctype="multipart/form-data">
  <input name="board" type="hidden" value="hero_02"><br>
  <input name="page" type="hidden" value="0"><br>
</form>
<div onClick="go_submit(bbs,'hero_01','01')" style="cursor:pointer">링크1-1page</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<div onClick="go_submit(bbs,'hero_01','02')" style="cursor:pointer">링크1-2page</div><br><br>

<div onClick="go_submit(bbs,'hero_02','01')" style="cursor:pointer">링크2-1page</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<div onClick="go_submit(bbs,'hero_02','02')" style="cursor:pointer">링크2-2page</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<div onClick="go_submit(bbs,'hero_02','03')" style="cursor:pointer">링크2-3page</div><br><br>

<div onClick="go_submit(bbs,'hero_03','01')" style="cursor:pointer">링크3-1page</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<div onClick="go_submit(bbs,'hero_03','02')" style="cursor:pointer">링크3-2page</div>
<script>
function go_submit(form,link,page){
    document.forms.bbs.elements.board.value=link;
    document.forms.bbs.elements.page.value=page;
    form.submit();
    return true;
}
</script>