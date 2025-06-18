<?
//주의 캐릭터셋 UTF-8 인스타에서 자음모음 분리현상 간혹 존재함
header("Content-Type:text/html; charset=UTF-8");

$mode = $_POST["mode"];
$search_keyword = $_POST["search_keyword"];

//TEST
$mission_idx = "2137";
$mode_test = $_GET["mode_test"];

if($mode == "naver_url_check") {
	$search_keyword = iconv("euc-kr","utf-8",urlDecode($search_keyword)); //찾아야되는 배너

	$url = $_POST["naver_url"]; //블로그 주소
	if(strpos(strtolower($url),"m.blog")) {
		$data = file_get_contents_check($url);
		preg_match("/<div class=\"_postView\">(.*?)<\/div>.*/s", $data, $match);
		$search_data = preg_replace("/\s+/","",$match[0]);
		$search_data = strtolower($search_data);
	} else {
		$data = file_get_contents_check($url);

		preg_match("/<iframe.*src=\"(.*)\".*><\/iframe>/isU",$data,$match);

		$blog = "https://blog.naver.com";
		$blog_pc_url = $blog.$match[1];

		$data2 = file_get_contents_check($blog_pc_url);
		preg_match("/<div id=\"postListBody\">(.*?)<div class=\"post_footer_contents\">.*/s", $data2, $match2);

		$search_data = preg_replace("/\s+/","",$match2[1]);
		$search_data = strtolower($search_data);
	}

	if(strpos($search_data,$search_keyword)) {
		echo "success";
	} else {
		echo "fail";
	}
} else if($mode == "insta_url_check") {
	$search_keyword = iconv("euc-kr","utf-8",urlDecode($search_keyword));

	$url = $_POST["insta_url"];

	$opts = array(
			'http'=>array(
					'method'=>"GET",
					'header'=>"Accept-language: en\r\n" .
					"User-Agent: Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36\r\n"
			)
	);

	$context = stream_context_create($opts);

	$data = file_get_contents_check($url, false, $context);

	preg_match("/<title>(.*?)<\/title>.*/s", $data, $match);

	$data = preg_replace("/\s+/","",$match[1]);
	$data = strtolower($data);

	//echo $data;

	if(strpos($data,$search_keyword) !== false || strpos($data,$insta_keyword) !== false) {
		echo "success";
	} else {
		echo "fail";
	}
} else if($mode_test == "insta") {

	echo "test";
	$url = $_GET["url"];
	$insta_keyword = "";
	if($board_test == "group_04_05") {
		$search_keyword = "aklover제품지원";
	} else if($board_test == "group_04_06") {
		$search_keyword = "aklover뷰티클럽제품지원";
		$insta_keyword = "aklover뷰티클럽제품지원";
	} else if($board_test == "group_04_27") {
		$search_keyword = "aklover유튜버제품지원";
	} else if($board_test == "group_04_28") {
		$search_keyword = "aklover라이프클럽제품지원";
	}

	//$search_keyword = iconv("euc-kr","utf-8",$search_keyword);

	$opts = array(
			'http'=>array(
					'method'=>"GET",
					'header'=>"Accept-language: en\r\n" .
					"User-Agent:  Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36\r\n".
					"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8"

			)
	);

	$context = stream_context_create($opts);

	$data = file_get_contents_check($url, false, $context);



	preg_match("/<title>(.*?)<\/title>.*/s", $data, $match);

	$data = preg_replace("/\s+/","",$match[1]);
	$data = strtolower($data);
	echo $data;
	//echo $CrayHangul->hangulJohap($data);
	//echo iconv("utf-8","euc-kr",$data);

	echo "<Br/>".$search_keyword;




	if(strpos($data,$search_keyword) !== false || strpos($data,$insta_keyword) !== false) {
		echo "success";
	} else {
		echo "fail";
	}
} else if($mode_test == "naver") {
	$search_keyword = "%BA%BB%C8%C4%B1%E2%B4%C2%BE%D6%B0%E6%BC%AD%C6%F7%C5%CD%C1%EEaklover%BF%A1%BC%AD%C1%A6%C7%B0%C0%BB%C1%F6%BF%F8%B9%DE%BE%C6%C1%F7%C1%A2%BB%E7%BF%EB%C7%D8%BA%B8%B0%ED%C0%DB%BC%BA%C7%CF%BF%B4%BD%C0%B4%CF%B4%D9.";
	$search_keyword = iconv("euc-kr","utf-8",urlDecode($search_keyword));

	echo $search_keyword;



	//$search_keyword = iconv("euc-kr","utf-8",$search_keyword);

	$url = $_GET["url"];
	if(strpos(strtolower($url),"m.blog")) {
		$data = file_get_contents_check($url);
		echo $data;
		preg_match("/<div class=\"_postView\">(.*?)<\/div>.*/s", $data, $match);
		echo $match[0];
		$search_data = preg_replace("/\s+/","",$match[0]);
		$search_data = strtolower($search_data);
	} else {

		$data = file_get_contents_check($url);

		preg_match("/<iframe.*src=\"(.*)\".*><\/iframe>/isU",$data,$match);

		$blog = "https://blog.naver.com";
		$blog_pc_url = $blog.$match[1];

		$data2 = file_get_contents_check($blog_pc_url);
		preg_match("/<div id=\"postListBody\">(.*?)<div class=\"post_footer_contents\">.*/s", $data2, $match2);

		echo $match2[1];

		$search_data = preg_replace("/\s+/","",$match2[1]);
		$search_data = strtolower($search_data);
		//$search_data = iconv("euc-kr","utf-8",$search_data);


	}

	if(strpos($search_data,$search_keyword)) {
		echo "success";
	} else {
		echo "fail";
	}
}

//curl 사용
function file_get_contents_check($url) {
	// Create a stream context for the HTTP request
	$context = stream_context_create(array(
		'http' => array(
			'follow_location' => true // Follow redirects
		)
	));

	// Get the content of the URL
	$data = file_get_contents($url, false, $context);

	return $data;
}
?>
