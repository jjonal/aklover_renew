<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/user.css?v=250617" type="text/css" />
<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/sub.css?v=250617" type="text/css" />

<!-- 뷰 리스트 탭 -->
<ul class="viewTabList">
    <li class="on" data-idx="1"><a>회원 정보</a></li>
    <li data-idx="2"><a>콘텐츠 관리</a></li>
    <li data-idx="3"><a>체험단 신청이력</a></li>
    <li data-idx="4"><a>활동 관리</a></li>
    <li data-idx="5"><a>서포터즈 이력 관리</a></li>
</ul>

<?
if(!defined('_HEROBOARD_'))exit;
// 25.06.24 다섯개의 탭이 include 이기 때문에 해당 공통 페이지에 공통 쿼리문 삽입!

$hero_code = $_GET["hero_code"];

$member_sql  = " SELECT m.* ";
$member_sql .= " , q.hero_qs_01, q.hero_qs_02, q.hero_qs_03, q.hero_qs_04, q.hero_qs_05";
$member_sql .= " , q.hero_qs_06, q.hero_qs_07, q.hero_qs_08 ";
$member_sql .= " , q.hero_qs_18, q.hero_qs_19, q.hero_qs_20, q.hero_qs_21, q.hero_qs_22, q.hero_qs_23,mg.hero_board, mg.hero_board_group  ";
$member_sql .= " , (SELECT ifnull(sum(hero_point),0) FROM point WHERE hero_code = m.hero_code) as hero_point ";
$member_sql .= " , (SELECT ifnull(sum(hero_order_point),0) FROM order_main WHERE hero_code = m.hero_code AND hero_process!='".$_PROCESS_CANCEL."') hero_order_point ";
$member_sql .= " , (date_format(now(),'%Y') - substr(hero_jumin,1,4) + 1) as hero_age, mg.hero_board, mg.hero_board_group ";
$member_sql .= " FROM member m ";
$member_sql .= " LEFT JOIN member_question q ON m.hero_code = q.hero_code AND q.hero_pid = 4 ";
$member_sql .= " LEFT JOIN (
    SELECT mg1.* 
    FROM member_gisu mg1
    INNER JOIN (
        SELECT hero_code, MAX(gisu) AS max_gisu
        FROM member_gisu
        GROUP BY hero_code
    ) mg2 ON mg1.hero_code = mg2.hero_code AND mg1.gisu = mg2.max_gisu
)  mg ON m.hero_code = mg.hero_code ";
$member_sql .= " WHERE m.hero_use = 0 AND m.hero_code = '".$hero_code."' ";
$member_sql .= " ORDER BY m.hero_idx DESC ";

$member_res = sql($member_sql,"on");
$view = mysql_fetch_assoc($member_res);

$pw_init_sql  = " SELECT hero_today FROM member_pw_initialize WHERE hero_code = '".$hero_code."' ORDER BY hero_today DESC LIMIT 1";
$pw_init_res = sql($pw_init_sql,"on");
$pw_init = mysql_fetch_assoc($pw_init_res);


$hero_hp = explode("-",$view["hero_hp"]);
$hero_mail = explode("@",$view["hero_mail"]);

$hero_naver_blog = str_replace("https://blog.naver.com/", "", $view["hero_blog_00"]);
$hero_naver_blog = str_replace("http://blog.naver.com/", "", $hero_naver_blog);
$hero_naver_blog = str_replace("https://m.blog.naver.com/", "", $hero_naver_blog);
$hero_naver_blog = str_replace("http://m.blog.naver.com/", "", $hero_naver_blog);
$hero_naver_blog = str_replace("blog.naver.com/", "", $hero_naver_blog);

$hero_instagram = str_replace("https://www.instagram.com/", "", $view["hero_blog_04"]);
$hero_instagram = str_replace("http://www.instagram.com/", "", $hero_instagram);
$hero_instagram = str_replace("https://instagram.com/", "", $hero_instagram);
$hero_instagram = str_replace("http://instagram.com/", "", $hero_instagram);
$hero_instagram = str_replace("instagram.com/", "", $hero_instagram);


$hero_naver_influencer = str_replace("https://in.naver.com/", "", $view["hero_naver_influencer"]);

$hero_qs_18 = "";
if($view["hero_qs_18"] == "Y") {
    $hero_qs_18 = "있음";
} else if($view["hero_qs_18"] == "N") {
    $hero_qs_18 = "없음";
}

$hero_qs_19 = "";
if($view["hero_qs_19"] == "Y") {
    $hero_qs_19 = "있음";
} else if($view["hero_qs_19"] == "N") {
    $hero_qs_19 = "없음";
}

$hero_qs_20 = "";
if($view["hero_qs_20"] == "Y") {
    $hero_qs_20 = "있음";
} else if($view["hero_qs_20"] == "N") {
    $hero_qs_20 = "없음";
}

$hero_qs_21 = "";
if($view["hero_qs_21"] == "Y") {
    $hero_qs_21 = "있음";
} else if($view["hero_qs_21"] == "N") {
    $hero_qs_21 = "없음";
}

$handphone = "";
if(isset($view["hero_info_ci"]) && !empty($view["hero_info_ci"])) {
    $handphone = "휴대폰 ";
}

$facebook = "";
if(isset($view["hero_facebook"]) && !empty($view["hero_facebook"])) {
    $facebook = "페이스북 ";
}

$kakaoTalk = "";
if(isset($view["hero_kakaoTalk"]) && !empty($view["hero_kakaoTalk"])) {
    $kakaoTalk = "카카오톡 ";
}

$naver = "";
if(isset($view["hero_naver"]) && !empty($view["hero_naver"])) {
    $naver = "네이버 ";
}

$google = "";
if(isset($view["hero_google"]) && !empty($view["hero_google"])) {
    $google = "구글 ";
}
// musign 서포터즈구분자 추가
if($view["hero_level"] == "9996") {
    $hero_group = "프리미어 뷰티 클럽";
} elseif ($view["hero_level"] == "9994"){
    $hero_group = "프리미어 라이프 클럽";
} else {
    $hero_group = "베이직 뷰티 & 라이프 클럽"; // 기존명칭 베이직서포터즈
}

// 서포터즈 팀 구분
if($view["hero_board_group"] == "b") {
    $hero_board_group = "블로그";
} elseif ($view["hero_board_group"] == "i") {
    $hero_board_group = "인스타";
} elseif ($view["hero_board_group"] == "s") {
    $hero_board_group = "숏폼";
}

?>

<div class="viewTabContents">
    <ul>
        <li class="content_item active user_info" data-idx="1">
            <? include_once PATH_INC_END.'/user/userManagerView_1.php';?>
        </li>
        <li class="content_item" data-idx="2">
            <? include_once PATH_INC_END.'/user/userManagerView_2.php';?>
        </li>
        <li class="content_item" data-idx="3">
            <? include_once PATH_INC_END.'/user/userManagerView_3.php';?>
        </li>
        <li class="content_item" data-idx="4">
            <? include_once PATH_INC_END.'/user/userManagerView_4.php';?>
        </li>
        <li class="content_item" data-idx="5">
            <? include_once PATH_INC_END.'/user/userManagerView_5.php';?>
        </li>
    </ul>
</div>
<!-- 25.06.24 각탭 페이지 네비게이션 이동시 탭 활성화를 위해 속성 추가 -->
<script>
    // 공통 함수로 변경
    function fnSearch(tabIndex) {
        $("input[name='page']").val(1);
        var baseUrl = '<?=PATH_HOME?>?' + '<?=get("page")?>' +
            '&hero_code=' + '<?=$view["hero_id"]?>' +
            '&view=userManagerView' +
            '&tab=' + tabIndex;  // tab 파라미터 추가

        localStorage.setItem('activeTab', tabIndex);
        $("#searchForm" + tabIndex).attr("action", baseUrl).submit();
        return false;
    }

    // 페이지네이션 이벤트를 데이터 속성으로 구분
    $('[data-pagination-tab] .pagination a').on('click', function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var tabIndex = $(this).closest('[data-pagination-tab]').data('pagination-tab');

        // URL 객체 생성
        var url = new URL(href, window.location.href);

        // 기존의 모든 파라미터를 가져옴
        var params = new URLSearchParams(url.search);

        // 기존 tab 파라미터 제거
        params.delete('tab');

        // 현재 탭 파라미터 추가
        params.set('tab', tabIndex);

        // 새로운 URL 생성
        url.search = params.toString();

        localStorage.setItem('activeTab', tabIndex);
        window.location.href = url.toString();
    });

    function activateTab() {
        // URL의 tab 파라미터 확인
        const urlParams = new URLSearchParams(window.location.search);
        const tabParam = urlParams.get('tab');

        // localStorage의 activeTab 확인
        const storedTab = localStorage.getItem('activeTab');

        // 실제 사용할 탭 인덱스 결정 (URL 파라미터 우선)
        const activeTab = tabParam || storedTab;

        console.log('Tab activation:', {
            tabParam: tabParam,
            storedTab: storedTab,
            activeTab: activeTab
        });

        if(activeTab && window.parent && window.parent.$) {
            // 탭 메뉴 활성화
            window.parent.$('.viewTabList li').removeClass('on');
            window.parent.$('.viewTabList li[data-idx="' + activeTab + '"]').addClass('on');

            // 컨텐츠 영역 활성화
            window.parent.$('.viewTabContents .content_item').removeClass('active user_info');
            window.parent.$('.viewTabContents .content_item[data-idx="' + activeTab + '"]').addClass('active user_info');

            // URL도 업데이트
            if (!tabParam) {
                const newUrl = new URL(window.location.href);
                newUrl.searchParams.set('tab', activeTab);
                window.history.replaceState({}, '', newUrl);
            }

            localStorage.removeItem('activeTab');
        }
    }
    // 페이지 로드 시 탭 활성화
    $(document).ready(function() {
        activateTab();
    });
</script>
