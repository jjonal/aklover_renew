<?
echo $sql = 'select * from board where hero_table = \'group_01_01\' and hero_idx=\'3017\';';
sql($sql, 'on');
    $out_row = @mysql_fetch_assoc($out_sql);//mysql_fetch_row
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>CHEditor</title>
<meta http-equiv="content-type" content="text/html; charset=euc-kr" />
<!-- cheidtor.js 파일의 위치를 지정합니다. -->
<script type="text/javascript" src="/cheditor/cheditor.js"></script>
</head>
<body>
<center>
<h3>CHEditor Demo</h3>
<script type="text/javascript">
function doSubmit (theform)
{
    // ---------------------------------------------------------------------------------
    // myeditor라는 이름은 현재 데모에서 만들어진 에디터 개체 이름입니다.
    //
    // myeditor.outputBodyHTML() 메서드를 호출하면 에디터에서 작성한 글 내용이
    // myeditor.inputForm 설정 옵션에 지정한 'fm_post' 폼 값에 자동으로 입력됩니다.
    //
    // outputBodyHTML:  BODY 태그 안쪽 내용을 가져옵니다.
    // outputHTML:      HTML 문서 모두를 가져옵니다.
    // outputBodyText:  BODY 태그 안쪽의 HTML 태그를 제외한 텍스트만을 가져옵니다.
    // inputLength:     입력한 텍스트 문자 수를 리턴합니다.
    // contentsLength:  BODY 태그 안쪽의 HTML 태그를 포함한 모든 문자 수를 리턴합니다.
    // contentsLengthAll: HTML 문서의 모든 문자 수를 리턴합니다.

    alert(myeditor.outputBodyHTML());
    return false;
}

// 업로드한 이미지 정보를 얻는 예제입니다.
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
<textarea id="fm_post" name="fm_write"><?=$out_row['hero_command'];?></textarea>

<!-- 에디터를 화면에 출력합니다. -->
<script type="text/javascript">
var myeditor = new cheditor();              // 에디터 개체를 생성합니다.
myeditor.config.editorHeight = '300px';     // 에디터 세로폭입니다.
myeditor.config.editorWidth = '80%';        // 에디터 가로폭입니다.
myeditor.inputForm = 'fm_post';             // textarea의 id 이름입니다. 주의: name 속성 이름이 아닙니다.
myeditor.run();                             // 에디터를 실행합니다.
</script>

<br/><br/>
<!--
<input type="submit" value="글 가져오기" />
<input type="button" value="이미지 정보" onclick="showImageInfo()" />
-->
</form>

<p>
    <font face="verdana" size="1" color="#666666">
        Copyright ⓒ 1997-2012 by <b>CHCODE.</b> All right reserved.
    </font>
</p>
</center>
</body>
</html>