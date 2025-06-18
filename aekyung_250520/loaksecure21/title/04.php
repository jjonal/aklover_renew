<script type="text/javascript" src="<?='http://'.$HTTP_SERVER_VARS['HTTP_HOST']?>/cheditor/cheditor.js"></script>
<script type="text/javascript">
function doSubmit (theform){
    myeditor.outputBodyHTML();
    theform.action = "test.php";
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
<form method="post" name="theform" onsubmit="return doSubmit(this)">
<textarea id="fm_post" name="command"></textarea>
<script type="text/javascript">
var myeditor = new cheditor();              // 에디터 개체를 생성합니다.
myeditor.config.editorHeight = '300px';     // 에디터 세로폭입니다.
myeditor.config.editorWidth = '80%';        // 에디터 가로폭입니다.
myeditor.inputForm = 'fm_post';             // textarea의 id 이름입니다. 주의: name 속성 이름이 아닙니다.
myeditor.run();                             // 에디터를 실행합니다.
</script>
<input type="submit" value="글 가져오기" />
<input type="button" value="이미지 정보" onclick="showImageInfo()" />
</form>
