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
        alert('�ø� �̹����� �����ϴ�.');
        return;
    }

    for (var i=0; i<data.length; i++) {
        var str = 'URL: ' + data[i].fileUrl + "\n";
        str += '���� ���: ' + data[i].filePath + "\n";
        str += '���� �̸�: ' + data[i].origName + "\n";
        str += '���� �̸�: ' + data[i].fileName + "\n";
        str += 'ũ��: ' + data[i].fileSize;

        alert(str);
    }
}
</script>
<form method="post" name="theform" onsubmit="return doSubmit(this)">
<textarea id="fm_post" name="command"></textarea>
<script type="text/javascript">
var myeditor = new cheditor();              // ������ ��ü�� �����մϴ�.
myeditor.config.editorHeight = '300px';     // ������ �������Դϴ�.
myeditor.config.editorWidth = '80%';        // ������ �������Դϴ�.
myeditor.inputForm = 'fm_post';             // textarea�� id �̸��Դϴ�. ����: name �Ӽ� �̸��� �ƴմϴ�.
myeditor.run();                             // �����͸� �����մϴ�.
</script>
<input type="submit" value="�� ��������" />
<input type="button" value="�̹��� ����" onclick="showImageInfo()" />
</form>
