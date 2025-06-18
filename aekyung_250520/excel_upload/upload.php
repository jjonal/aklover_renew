<?
define('_HEROBOARD_', TRUE);
include_once '/home/users/aekyung/freebest/head.php';
include_once '/home/users/aekyung/freebest/hero.php';
include_once '/home/users/aekyung/freebest/function.php';
db("aekyung");

require_once "reader.php";
$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding("UTF-8//IGNORE");
//아래 파일 이름 정확히해서 사용
//$data->read("sample.xls");

for ($i = 2; $i <= $data->sheets[0]["numRows"]; $i++) {
	$my_id = $data->sheets[0]["cells"][$i][1];
	$my_grade = $data->sheets[0]["cells"][$i][2];

	//$query = "insert into my_user (my_name,my_age,my_gender,my_phone) values ('{$my_name}','{$my_age}','{$my_gender}','{$my_phone}') ";
	//$query = "update member set hero_memo = '{$my_grade}' where hero_id='{$my_id}' ";
	mysql_query($query) ;
}
echo "완료";
?>




