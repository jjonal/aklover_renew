<!DOCTYPE html>
<?
define('_HEROBOARD_', TRUE);
include_once '../../freebest/head.php';
include                                    '../popupSessionCheck.php';
include                                     FREEBEST_INC_END.'hero.php';
include                                     FREEBEST_INC_END.'function.php';
include 									'../page02.php';

$hero_code = $_GET["hero_code"];
$search = "";
// 검색어가 있을경우에만 sql 실행
if($_GET["kewyword"] && $_GET["select"] != 'none') {


    if($_GET["kewyword"] && $_GET["select"] != 'none') { //
        if($_GET["select"] == 'hero_nick') { // 닉네임 검색
            $_GET["select"] = $_GET["select"];
        } elseif ($_GET["select"] == 'hero_name') { // 이름
            $_GET["select"] = $_GET["select"];
        } elseif ($_GET["select"] == 'hero_id') { // 아이디
            $_GET["select"] = $_GET["select"];
        }
        $search .= $_GET["select"]." like '%".$_GET["kewyword"]."%' ";
    }
    
    $total_sql = " SELECT count(*) cnt FROM member WHERE ".$search;
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

    $sql  = " SELECT hero_idx, hero_code, hero_id, hero_nick, hero_name , hero_jumin, hero_sex FROM member WHERE ".$search." ORDER BY hero_idx DESC ";
    $sql .= " LIMIT ".$start.",".$list_page;

    $list_res = sql($sql, "on");
    
}
?>
<meta charset="euc-kr" />
<head>
    <link rel="stylesheet" type="text/css" href="<?=ADMIN_DEFAULT?>/css/admin.css" />
    <link rel="stylesheet" type="text/css" href="<?=ADMIN_DEFAULT?>/css/common.css" />
    <script type="text/javascript" src="<?=JS_END;?>jquery.min.js"></script>
    <script type="text/javascript" src="<?=JS_END;?>jquery.form.js"></script>
    <script type="text/javascript" src="/js/common.js"></script>
</head>
<body style="background:none;">
<style>
    .tit {
        margin-top: 9px;
        font-family: 'Noto Sans KR';
        font-size: 20px;
        font-weight: 700;
        line-height: 28.96px;
        letter-spacing: -0.699999988079071px;
        text-align: left;
        color: black;
    }
</style>
<div class="tit">프리미어 서포터즈 선정자 추가</div>
<div class="popupWrap">
        <div class="popContents mu_form">
        <form name="searchForm" id="searchForm">
            <input type="hidden" name="page" value="<?=$page?>" />
            <input type="hidden" name="sno" value="<?=$_GET["sno"]?>" />
            <input type="hidden" name="hero_board" value="<?=$_GET["hero_board"]?>" />
            <table class="searchBox">
                <colgroup>
                    <col width="171px">
                    <col width="*">
                </colgroup>
                <tbody>
                <tr>
                    <th>
                        회원검색
                    </th>
                    <td>
                        <div class="search_inner">
                            <div class="select-wrap">
                                <select name="select">
                                    <option value="none" selected="">선택</option>
                                    <option value="hero_name">이름</option>
                                    <option value="hero_nick">닉네임</option>
                                    <option value="hero_id">아이디</option>
                                </select>
                            </div>
                            <input class="search_txt" type="text" name="kewyword" value="" style="width: 200px;"/>
                            <a href="javascript:;" onclick="fnSearch2()" style="    margin: 0;width: 82px;height:35px;color: white;background-color: #000;display: flex; flex-direction: row;justify-content: center; align-items: center;border-radius: 24px;">검색</a>
                        </div>
                    </td>
                </tr>
                </tbody></table>
        </form>
        <form name="writeForm" id="writeForm" method="POST">
        <input type="hidden" name="sno" value="<?=$_GET["sno"]?>" />
        <input type="hidden" name="hero_board" value="<?=$_GET["hero_board"]?>" />
        <input type="hidden" name="mode" value="insert_mem" />
            <table class="mu_table mgt30">
                <colgroup>
                    <col width="" />
                    <col width="" />
                    <col width="" />
                    <col width="" />
                    <col width="" />
                    <col width="" />
                    <col width="" />
                </colgroup>
                <thead>
                <tr>
                    <th> </th>
                    <th>아이디</th>
                    <th>닉네임</th>
                    <th>이름</th>
                    <th>나이</th>
                    <th>성별</th>
                    <th>그룹</th>
                </tr>
                </thead>
                <tbody class="line">
                <?
                if($total_data > 0) {
                    while($list = mysql_fetch_assoc($list_res)) {
                        $age = (date("Y")-substr($list["hero_jumin"],0,4))+1;
                        $hero_sex_txt = "";
                        if($list["hero_sex"] == 1) {
                            $hero_sex_txt = "남";
                        } else if(strlen($list["hero_sex"]) > 0 && $list["hero_sex"] == 0) {
                            $hero_sex_txt = "여";
                        }

                        ?>
                        <tr>
                            <td>
                                <div class="table_checkbox" style="position:relative">
                                    <label class="akContainer">
                                        <input type="checkbox" name="hero_code" value="<?=$list["hero_code"]?>" class="rowCheck">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </td>
                            <td><?=$list["hero_id"]?></td>
                            <td class="title"><?=$list["hero_nick"]?></td>
                            <td class="title"><?=$list["hero_name"]?></td>
                            <td class="title"><?=$age?></td>
                            <td class="title"><?=$hero_sex_txt?></td>
                            <td class="title">
                                <div class="search_inner">
                                    <div class="select-wrap">
                                        <select name="hero_supports_group">
                                            <option value="none" selected="">선택</option>
                                            <option value="b">블로그</option>
                                            <option value="i">인스타그램</option>
                                            <option value="s">숏폼</option>
                                        </select>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    <? }
                } else {?>
                    <tr>
                        <td colspan="7">검색된 데이터가 없습니다.</td>
                    </tr>
                <? } ?>
                </tbody>
            </table>
            </form>
        <div class="paginate">
            <?
            if ($_GET["kewyword"] && $_GET["select"] != 'none') {
                page2($total_data,$list_page,$page_per_list,$page,$next_path);
            }
            ?>
        </div>

        <div class="btnContainer mgt150 line">
            <a href="javascript:;" onClick="fnInsert();" class="btnAdd3">서포터즈 선정하기</a>
        </div>
        </div>
</div>

<script>
    $(document).ready(function(){

        fnSearch2 = function() {
            $("input[name='page']").val(1);
            $("#searchForm").attr("action","").submit();
        }
        fnInsert = function() {
            // 체크된 hero_code 값과 그룹을 배열로 수집
            var selectedCodes = [];
            var selectedGroups = [];

            $(".rowCheck:checked").each(function() {
                var heroCode = $(this).val();
                // 해당 row의 hero_supports_group 값 찾기
                var heroGroup = $(this).closest('tr').find('select[name="hero_supports_group"]').val();

                if(heroGroup === 'none' || heroGroup === '') {
                    alert("회원의 서포터즈 그룹을 선택해주세요.");
                    return false; // each 루프 중단
                }

                selectedCodes.push(heroCode);
                selectedGroups.push(heroGroup);
            });
            if(selectedCodes.length === 0) {
                alert("선택된 회원이 없습니다.");
                return;
            }

            if(confirm("선정자로 추가하겠습니까?")) {
                var formData = $("#writeForm").serializeArray();

                // 배열 데이터들을 formData에 추가
                for(var i = 0; i < selectedCodes.length; i++) {
                    formData.push({
                        name: 'hero_codes[]',
                        value: selectedCodes[i]
                    });
                    formData.push({
                        name: 'hero_groups[]',
                        value: selectedGroups[i]
                    });
                }

                var param = $.param(formData);

                $.ajax({
                    url:"/loaksecure21/user/premierSupportersAct.php"
                    ,type:"POST"
                    ,data:param
                    ,dataType:"json"
                    ,success:function(d){
                        console.log(d);
                        if(d.result == 1) {
                            alert("등록되었습니다.");
                            window.top.location.reload();
                            // location.reload();
                        } else {
                            alert("실행 중 실패했습니다: " + d.error);
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

</body>