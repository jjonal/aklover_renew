<!DOCTYPE html>
<?
define('_HEROBOARD_', TRUE);
include_once '../../freebest/head.php';
include                                    '../popupSessionCheck.php';
include                                     FREEBEST_INC_END.'hero.php';
include                                     FREEBEST_INC_END.'function.php';
include 									'../page02.php';

$hero_code = $_GET["hero_code"];

$total_sql = " SELECT count(*) cnt FROM member_penalty WHERE hero_use_yn = 'Y' AND hero_code=  '".$hero_code."' ";
$total_res = sql($total_sql,"on");
$total_rs = mysql_fetch_assoc($total_res);

$total_data = $total_rs['cnt'];

$i=$total_data;

$list_page=5;
$page_per_list=10;

if(!strcmp($_GET['page'], '')) {
    $page = '1';
} else {
    $page = $_GET['page'];
    $i = $i-($page-1)*$list_page;
}

$start = ($page-1)*$list_page;
$next_path=get("page");

$sql  = " SELECT hero_idx, hero_today, memo, type FROM member_penalty WHERE hero_use_yn = 'Y' AND hero_code=  '".$hero_code."' ORDER BY hero_idx DESC ";
$sql .= " LIMIT ".$start.",".$list_page;

$list_res = sql($sql, "on");

$type_arr = array("1"=>"이중아이디","2"=>"가이드라인 미준수","3"=>"후기 미등록","4"=>"오프라인 모임 미참여","5"=>"풍평/설문 미진행","9"=>"기타");
?>
<meta charset="euc-kr" />
<head>
    <link rel="stylesheet" type="text/css" href="<?=ADMIN_DEFAULT?>/css/admin.css" />
    <link rel="stylesheet" type="text/css" href="<?=ADMIN_DEFAULT?>/css/common.css" />
    <link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/user.css?v=250617" type="text/css" />
    <script type="text/javascript" src="<?=JS_END;?>jquery.min.js"></script>
    <script type="text/javascript" src="<?=JS_END;?>jquery.form.js"></script>
    <script type="text/javascript" src="/js/common.js"></script>
</head>
<body style="background:none;">
<form name="searchForm" id="searchForm">
    <input type="hidden" name="page" value="<?=$page?>" />
    <input type="hidden" name="hero_code" value="<?=$hero_code?>" />
</form>
<div class="popupWrap penalty_popup mu_form">
    <div class="popContents">
        <!-- 패널티 내역/지급 -->
        <div class="popHeader">
            <h2>패널티 내역/지급</h2>
        </div>
        <form name="listForm" id="listForm" method="POST">
            <input type="hidden" name="hero_idx" />
            <input type="hidden" name="hero_code" value="<?=$hero_code?>" />
            <input type="hidden" name="mode" value="" />
            <table class="mu_table mgt10 panealty_list">
                <colgroup>
                    <col width="20%" />
                    <col width="15%" />
                    <col width="*%" />
                    <col width="15%" />
                </colgroup>
                <thead>
                <tr>
                    <th>등록일</th>
                    <th>타입</th>
                    <th>체험단</th>
                    <th>관리</th>
                </tr>
                </thead>
                <tbody class="line">
                <tr>
                    <td>2024-00-00</td>
                    <td>가이드 미준수</td>
                    <td class="title">홈백신 로봇청소기 올인원 클리너...</td>
                    <td><a href="javascript:;" onClick="fnDelPenalty('<?=$list["hero_idx"]?>')" class="btnAdd4">삭제</a></td>
                </tr>
                <!-- 등록된 데이터가 없을 시 보여주세요. -->
                <!-- <tr>
                    <td colspan="4" class="no_data">등록된 데이터가 없습니다.</td>
                </tr> -->

                <!-- <?
                if($total_data > 0) {
                    while($list = mysql_fetch_assoc($list_res)) {?>
				<tr>
					<td><?=$list["hero_today"]?></td>
					<td><?=$type_arr[$list["type"]]?></td>
					<td class="title"><?=$list["memo"]?></td>
					<td><a href="javascript:;" onClick="fnDelPenalty('<?=$list["hero_idx"]?>')" class="btnForm">삭제</a></td>
				</tr>
				<? }
                } else {?>
				<tr class="align_c">
					<td colspan="4">등록된 데이터가 없습니다.</td>
				</tr>
				<? } ?> -->
                </tbody>
            </table>
        </form>

        <div class="paginate">
            <?=page2($total_data,$list_page,$page_per_list,$page,$next_path);?>
        </div>

        <!-- 패널티 등록 -->
        <div class="popHeader">
            <h2>패널티 등록</h2>
        </div>
        <form name="writeForm" id="writeForm" method="POST">
            <input type="hidden" name="hero_code" value="<?=$hero_code?>" />
            <input type="hidden" name="mode" value="penalty" />
            <table class="mu_table mgt10">
                <colgroup>
                    <col width="150">
                    <col width="*">
                </colgroup>
                <thead>
                <tr>
                    <th>타입</th>
                    <th>내용</th>
                    <!-- <th>등록</th> -->
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <div class="select_wrap">
                            <select name="type">
                                <option value="">선택</option>
                                <option value="1">이중아이디</option>
                                <option value="2">가이드라인 미준수</option>
                                <option value="3">후기 미등록</option>
                                <option value="4">오프라인 모임 미참여</option>
                                <option value="5">품평/설문 미진행</option>
                                <option value="9">기타</option>
                            </select>
                        </div>
                    </td>
                    <td><input type="text" name="memo" /></td>
                    <!-- <td><a href="javascript:;" onClick="fnPenalty();" class="btnForm">등록</a></td> -->
                <tr>
                </tbody>
            </table>

            <table class="mu_table mgt20">
                <colgroup>
                    <col width="150">
                    <col width="*">
                </colgroup>
                <thead>
                <tr>
                    <th>서포터즈 구분</th>
                    <th>체험단 선택</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <div class="select_wrap">
                            <select name="type">
                                <option value="">선택</option>
                                <option value="1">프리미어 뷰티</option>
                                <option value="2">프리미어 라이프</option>
                                <option value="3">베이직 뷰티&라이프</option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="select_wrap">
                            <!-- 현재 진행되고 있는 체험단 리스트 노출 -->
                            <select name="type">
                                <option value="">선택</option>
                                <option value="1"></option>
                                <option value="2"></option>
                                <option value="3"></option>
                            </select>
                        </div>
                    </td>
                <tr>
                </tbody>
            </table>
            <div class="btnContainer mgt20">
                <a href="javascript:;" onClick="fnPenalty();" class="btnAdd3">패널티 등록</a>
            </div>
        </form>
    </div>

    <!-- [개발 요청] 패널티 상세 내용 여기서 보여주세요.-->
    <!-- <div class="penalty_detail">
        <div class="pop_header">
            <h2>페널티 상세 내용</h2>
            <p class="penalty_detail_back">뒤로가기 임시 버튼</p>
        </div>
        <div class="pop_content mgt10">
            <textarea></textarea>
        </div>
    </div> -->


</div>
</body>
<html>
<script>
    $(document).ready(function(){
        fnDelPenalty = function(hero_idx) {
            if(confirm("패널티를 삭제하시겠습니까?")) {
                $("#listForm input[name='hero_idx']").val(hero_idx);
                $("#listForm input[name='mode']").val("delPenalty");

                var param = $("#listForm").serialize();

                $.ajax({
                    url:"/loaksecure21/user/popUserManagerPenaltyListAction.php"
                    ,type:"POST"
                    ,data:param
                    ,dataType:"json"
                    ,success:function(d){
                        console.log(d);
                        if(d.result==1) {
                            alert("패널티가 삭제되었습니다.");
                            location.reload();
                        } else {
                            alert("실행 중 실패했습니다.")
                        }
                    },error:function(e){
                        console.log(e);
                        alert("실패했습니다.");
                    }
                })

                $("#listForm input[name='mode']").val("");


            }
        }

        fnPenalty = function() {
            if(!$("select[name='type']").val()) {
                alert("패널티 타입을 선택해 주세요.");
                $("select[name='type']").focus();
                return;
            }

            if(!$("input[name='memo']").val()) {
                alert("패널티 내용을 입력해 주세요.");
                $("input[name='memo']").focus();
                return;
            }

            if(confirm("패널티 등록하시겠습니까?")) {
                var param = $("#writeForm").serialize();

                $.ajax({
                    url:"/loaksecure21/user/popUserManagerPenaltyListAction.php"
                    ,type:"POST"
                    ,data:param
                    ,dataType:"json"
                    ,success:function(d){
                        console.log(d);
                        if(d.result==1) {
                            alert("패널티가 등록되었습니다.");
                            location.reload();
                        } else {
                            alert("실행 중 실패했습니다.")
                        }
                    },error:function(e){
                        console.log(e);
                        alert("실패했습니다.");
                    }
                })
            }

        }

        ch_page = function(page) {
            $("input[name='page']").val(page);
            $("#searchForm").submit();
        }
    })
</script>  