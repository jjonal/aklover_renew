<?
define('_HEROBOARD_', TRUE);
include_once                                                        '../freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';

$hero_movie_group = $_GET["hero_movie_group"];

if($hero_movie_group) { //체험단 후기 등록 시 영상그룹 일 때 포커스 그룹에 따른 기수를 선택해야한다.
	$gisu = "";
	
	$sql = " SELECT hero_moviebeauty_gisu, hero_movielife_gisu FROM mission_gisu ";
	sql($sql,"on");
	$rs_gisu = mysql_fetch_assoc($out_sql);
	
	$curr_moviebeauty_gisu = $rs_gisu["hero_moviebeauty_gisu"];
	$curr_movielife_gisu = $rs_gisu["hero_movielife_gisu"];
	
	if($hero_movie_group == "group_04_27") {
		$gisu = $curr_moviebeauty_gisu;
	} else if($hero_movie_group == "group_04_31") {
		$gisu = $curr_movielife_gisu;
	}
	
	echo $gisu;
}
?>