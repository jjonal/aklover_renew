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
    <h2 class="table_tit">ȸ�� ����</h2>
    <table class="searchBox">
        <colgroup>
            <col width="200px">
            <col width=*>
        </colgroup>
        <tbody>
        <tr>
            <th>���̵�</th>
            <td><?=$view["hero_id"]?></td>
        </tr>
        <tr>
            <th>�̸�</th>
            <td><?=$view["hero_name"]?></td>
        </tr>
        <tr>
            <th>�г���</th>
            <td><?=$view["hero_nick"]?></td>
        </tr>
        </tbody>
    </table>
</div>

<form name="viewForm" id="viewForm" method="POST">
<input type="hidden" name="hero_code" value="<?=$hero_code?>" />

<div class="tableSection mgt27 mu_form">
    <h2 class="table_tit">����Ƽ����ǥ ����</h2>
    <table class="searchBox">
        <colgroup>
            <col width="200px">
            <col width=*>
        </colgroup>
        <tbody>
        <tr>
            <th>���</th>
            <td>
                <div class="search_inner">
                    <div class="select-wrap">
                        <select name="grade">
                            <option value="none" <?=!isset($view["grade"]) || $view["grade"] == "none" ? "selected" : ""?>>����</option>
                            <option value="4" <?=$view["grade"] == "4" ? "selected" : ""?>>�ֻ�</option>
                            <option value="3" <?=$view["grade"] == "3" ? "selected" : ""?>>��</option>
                            <option value="2" <?=$view["grade"] == "2" ? "selected" : ""?>>��</option>
                            <option value="1" <?=$view["grade"] == "1" ? "selected" : ""?>>��</option>
                        </select>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <th>�̹��� ����Ƽ</th>
            <td>
                <div class="search_inner sup">
                    <label class="akContainer">��
                        <input type="radio" name="image_quality" value="100" <?=$view["image_quality"] == "100" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">��
                        <input type="radio" name="image_quality" value="50" <?=$view["image_quality"] == "50" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">��
                        <input type="radio" name="image_quality" value="0" <?=!isset($view["grade"]) || $view["image_quality"] == "0" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
        </tr>
        <tr>
            <th>�ؽ�Ʈ ����Ƽ</th>
            <td>
                <div class="search_inner sup">
                    <label class="akContainer">��
                        <input type="radio" name="text_quality" value="50" <?=$view["text_quality"] == "50" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">��
                        <input type="radio" name="text_quality" value="25" <?=$view["text_quality"] == "25" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">��
                        <input type="radio" name="text_quality" value="0" <?=!isset($view["text_quality"]) || $view["text_quality"] == "0" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
        </tr>
        <tr>
            <th>���̵� �ؼ�</th>
            <td>
                <div class="search_inner sup">
                    <label class="akContainer">��
                        <input type="radio" name="guide_compliance" value="50" <?=$view["guide_compliance"] == "50" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">��
                        <input type="radio" name="guide_compliance" value="25" <?=$view["guide_compliance"] == "25" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">��
                        <input type="radio" name="guide_compliance" value="0" <?=!isset($view["guide_compliance"]) || $view["guide_compliance"] == "0" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
        </tr>
        <tr>
            <th>�ΰ�������Ʈ</th>
            <td>
                <div class="fl alc g50">
                    <div class="search_inner sup">
                        <label class="akContainer">��
                            <input type="radio" name="engagement_score" value="100" <?=$view["engagement_score"] == "100" ? "checked" : ""?>>
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">��
                            <input type="radio" name="engagement_score" value="50" <?=$view["engagement_score"] == "50" ? "checked" : ""?>>
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">��
                            <input type="radio" name="engagement_score" value="0" <?=!isset($view["engagement_score"]) || $view["engagement_score"] == "0" ? "checked" : ""?>>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="addForm">
                        <p>���ƿ�</p>
                        <input type="number" name="engagement_likes" value="<?=$view['engagement_likes']?>" />
                    </div>
                    <div class="addForm">
                        <p>���</p>
                        <input type="number" name="engagement_comments" value="<?=$view['engagement_comments']?>" />
                    </div>
                </div>
            </td>
        </tr>
        <tr><!-- // �ȷο����� ���������� �׸�� ������� ����.  -->
            <th>�ȷο� ��</th>
            <td>
                <div class="fl alc g50">
                    <div class="search_inner sup">
                        <label class="akContainer">��
                            <input type="radio" name="follower_score" value="3" <?=$view["follower_score"] == "3" ? "checked" : ""?>>
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">��
                            <input type="radio" name="follower_score" value="2" <?=$view["follower_score"] == "2" ? "checked" : ""?>>
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">��
                            <input type="radio" name="follower_score" value="1" <?=!isset($view["follower_score"]) || $view["follower_score"] == "1" ? "checked" : ""?>>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="addForm">
                        <p>�ȷο� ��</p>
                        <input type="number" name="follower_count" value="<?=$view['follower_count']?>"/>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <th>���� ����</th>
            <td>
                <div class="search_inner sup">
                    <label class="akContainer">��
                        <input type="radio" name="top_exposure" value="3" <?=$view["top_exposure"] == "3" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">��
                        <input type="radio" name="top_exposure" value="2" <?=$view["top_exposure"] == "2" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">��
                        <input type="radio" name="top_exposure" value="1" <?=!isset($view["top_exposure"]) || $view["top_exposure"] == "1" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
        </tr>
        <tr>
            <th>�հ� ����</th>
            <td>
                <input type="hidden" name="total_score" value="<?=$view['total_score']?>">
                <?=$view['total_score']?>
            </td>
        </tr>
        <tr>
            <th>���� ������</th>
            <td><?=$view['modDt']?></td>
        </tr>
        </tbody>
    </table>

    <div class="btnContainer mgt20">
        <a href="javascript:;" onclick="fnSave()" class="btnAdd3">����</a>
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
                        alert("����Ƽ�򰡰� ����Ǿ����ϴ�.");
                        location.reload();
                    } else {
                        alert("���� �� �����߽��ϴ�.")
                    }
                },error:function(e){
                     console.log(e);
                    // alert("�����߽��ϴ�.");
                }
            });

    }
    })
</script>