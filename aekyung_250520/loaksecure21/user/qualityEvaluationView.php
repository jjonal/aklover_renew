<?
if(!defined('_HEROBOARD_'))exit;

$hero_code = $_GET["hero_code"];


$member_sql = " SELECT m.hero_code as member_code, m.hero_id, m.hero_nick, m.hero_name ";
$member_sql .= " , qe.* ";
$member_sql .= " FROM member m ";
$member_sql .= " LEFT JOIN quality_evaluation qe ON m.hero_code = qe.hero_code ";
$member_sql .= " WHERE m.hero_use = 0 AND m.hero_code = '".$hero_code."' ";
$member_sql .= " ORDER BY m.hero_idx DESC ";
$member_res = sql($member_sql,"on");
$view = mysql_fetch_assoc($member_res);
?>

<div class="tableSection mgt20">
    <h2 class="table_tit">회원 정보</h2>
    <table class="searchBox">
        <colgroup>
            <col width="200px">
            <col width=*>
        </colgroup>
        <tbody>
        <tr>
            <th>아이디</th>
            <td><?=$view["hero_id"]?></td>
        </tr>
        <tr>
            <th>이름</th>
            <td><?=$view["hero_name"]?></td>
        </tr>
        <tr>
            <th>닉네임</th>
            <td><?=$view["hero_nick"]?></td>
        </tr>
        </tbody>
    </table>
</div>

<form name="viewForm" id="viewForm" method="POST">
<input type="hidden" name="hero_code" value="<?=$hero_code?>" />

<div class="tableSection mgt27 mu_form">
    <h2 class="table_tit">퀄리티평가지표 설정</h2>
    <table class="searchBox">
        <colgroup>
            <col width="200px">
            <col width=*>
        </colgroup>
        <tbody>
        <tr>
            <th>등급</th>
            <td>
                <div class="search_inner">
                    <div class="select-wrap">
                        <select name="grade">
                            <option value="none" <?=!isset($view["grade"]) || $view["grade"] == "none" ? "selected" : ""?>>선택</option>
                            <option value="4" <?=$view["grade"] == "4" ? "selected" : ""?>>최상</option>
                            <option value="3" <?=$view["grade"] == "3" ? "selected" : ""?>>상</option>
                            <option value="2" <?=$view["grade"] == "2" ? "selected" : ""?>>중</option>
                            <option value="1" <?=$view["grade"] == "1" ? "selected" : ""?>>하</option>
                        </select>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <th>이미지 퀄리티</th>
            <td>
                <div class="search_inner sup">
                    <label class="akContainer">○
                        <input type="radio" name="image_quality" value="100" <?=$view["image_quality"] == "100" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">△
                        <input type="radio" name="image_quality" value="50" <?=$view["image_quality"] == "50" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">×
                        <input type="radio" name="image_quality" value="0" <?=!isset($view["grade"]) || $view["image_quality"] == "0" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
        </tr>
        <tr>
            <th>텍스트 퀄리티</th>
            <td>
                <div class="search_inner sup">
                    <label class="akContainer">○
                        <input type="radio" name="text_quality" value="50" <?=$view["text_quality"] == "50" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">△
                        <input type="radio" name="text_quality" value="25" <?=$view["text_quality"] == "25" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">×
                        <input type="radio" name="text_quality" value="0" <?=!isset($view["text_quality"]) || $view["text_quality"] == "0" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
        </tr>
        <tr>
            <th>가이드 준수</th>
            <td>
                <div class="search_inner sup">
                    <label class="akContainer">○
                        <input type="radio" name="guide_compliance" value="50" <?=$view["guide_compliance"] == "50" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">△
                        <input type="radio" name="guide_compliance" value="25" <?=$view["guide_compliance"] == "25" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">×
                        <input type="radio" name="guide_compliance" value="0" <?=!isset($view["guide_compliance"]) || $view["guide_compliance"] == "0" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
        </tr>
        <tr>
            <th>인게이지먼트</th>
            <td>
                <div class="fl alc g50">
                    <div class="search_inner sup">
                        <label class="akContainer">○
                            <input type="radio" name="engagement_score" value="100" <?=$view["engagement_score"] == "100" ? "checked" : ""?>>
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">△
                            <input type="radio" name="engagement_score" value="50" <?=$view["engagement_score"] == "50" ? "checked" : ""?>>
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">×
                            <input type="radio" name="engagement_score" value="0" <?=!isset($view["engagement_score"]) || $view["engagement_score"] == "0" ? "checked" : ""?>>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="addForm">
                        <p>좋아요</p>
                        <input type="number" name="engagement_likes" value="<?=$view['engagement_likes']?>" />
                    </div>
                    <div class="addForm">
                        <p>댓글</p>
                        <input type="number" name="engagement_comments" value="<?=$view['engagement_comments']?>" />
                    </div>
                </div>
            </td>
        </tr>
        <tr><!-- // 팔로워수와 상위노출은 항목당 등급점수 없음.  -->
            <th>팔로워 수</th>
            <td>
                <div class="fl alc g50">
                    <div class="search_inner sup">
                        <label class="akContainer">○
                            <input type="radio" name="follower_score" value="3" <?=$view["follower_score"] == "3" ? "checked" : ""?>>
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">△
                            <input type="radio" name="follower_score" value="2" <?=$view["follower_score"] == "2" ? "checked" : ""?>>
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">×
                            <input type="radio" name="follower_score" value="1" <?=!isset($view["follower_score"]) || $view["follower_score"] == "1" ? "checked" : ""?>>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="addForm">
                        <p>팔로워 수</p>
                        <input type="number" name="follower_count" value="<?=$view['follower_count']?>"/>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <th>상위 노출</th>
            <td>
                <div class="search_inner sup">
                    <label class="akContainer">○
                        <input type="radio" name="top_exposure" value="3" <?=$view["top_exposure"] == "3" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">△
                        <input type="radio" name="top_exposure" value="2" <?=$view["top_exposure"] == "2" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">×
                        <input type="radio" name="top_exposure" value="1" <?=!isset($view["top_exposure"]) || $view["top_exposure"] == "1" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
        </tr>
        <tr>
            <th>합계 점수</th>
            <td>
                <input type="hidden" name="total_score" value="<?=$view['total_score']?>">
                <?=$view['total_score']?>
            </td>
        </tr>
        <tr>
            <th>최종 수정일</th>
            <td><?=$view['modDt']?></td>
        </tr>
        </tbody>
    </table>

    <div class="btnContainer mgt20">
        <a href="javascript:;" onclick="fnSave()" class="btnAdd3">저장</a>
    </div>
</div>
</form>
<script>
    $(document).ready(function(){
    fnSave = function() {
            var formData = $("#viewForm").serializeArray();
            formData.push({name: "mode", value: "update"});
            console.log(formData);
            var param = $.param(formData);
            $.ajax({
                url:"/loaksecure21/user/qualityEvaluationAct.php"
                ,type:"POST"
                ,data:param
                ,dataType:"json"
                ,success:function(d){
                    console.log(d);
                    if(d.result==1) {
                        alert("퀄리티평가가 저장되었습니다.");
                        location.reload();
                    } else {
                        alert("실행 중 실패했습니다.")
                    }
                },error:function(e){
                     console.log(e);
                    // alert("실패했습니다.");
                }
            });

    }
    })
</script>