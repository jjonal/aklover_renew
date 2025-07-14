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
// ����Ƽ �� ���� ��� �� ����
    const weights = {
        image_quality: 0.30,      // 30%
        text_quality: 0.25,       // 25%
        guide_compliance: 0.25,   // 25%
        engagement_score: 0.20    // 20%
    };

// �հ� ���� ��� �Լ�
function calculateTotalScore() {
    let totalScore = 0;

    // �� �׸��� ���õ� �� ��������
    const imageQuality = document.querySelector('input[name="image_quality"]:checked');
    const textQuality = document.querySelector('input[name="text_quality"]:checked');
    const guideCompliance = document.querySelector('input[name="guide_compliance"]:checked');
    const engagementScore = document.querySelector('input[name="engagement_score"]:checked');

    // �� �׸��� ���� ����ġ�� ���ؼ� �ջ�
    if (imageQuality) {
        totalScore += parseInt(imageQuality.value) * weights.image_quality;
    }

    if (textQuality) {
        totalScore += parseInt(textQuality.value) * weights.text_quality;
    }

    if (guideCompliance) {
        totalScore += parseInt(guideCompliance.value) * weights.guide_compliance;
    }

    if (engagementScore) {
        totalScore += parseInt(engagementScore.value) * weights.engagement_score;
    }

    // �Ҽ��� 2�ڸ����� �ݿø�
    //totalScore = Math.round(totalScore * 100) / 100;

    // ù ��° �Ҽ������� �ݿø� ó��
    totalScore = Math.round(totalScore);
    // ȭ�鿡 ǥ��
    document.querySelector('input[name="total_score"]').value = totalScore;
    document.querySelector('input[name="total_score"]').parentNode.innerHTML =
        '<input type="hidden" name="total_score" value="' + totalScore + '">' + totalScore;

    return totalScore;
}

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

        // ��� ���� ��ư�� �̺�Ʈ ������ �߰�
        const radioButtons = document.querySelectorAll('input[type="radio"][name="image_quality"], input[type="radio"][name="text_quality"], input[type="radio"][name="guide_compliance"], input[type="radio"][name="engagement_score"]');

        radioButtons.forEach(function(radio) {
            radio.addEventListener('change', calculateTotalScore);
        });

        // �ʱ� ���� ���
        calculateTotalScore();
    })

// ���� �׸� ���� Ȯ�� �Լ� (������)
// function getIndividualScores() {
//     const imageQuality = document.querySelector('input[name="image_quality"]:checked');
//     const textQuality = document.querySelector('input[name="text_quality"]:checked');
//     const guideCompliance = document.querySelector('input[name="guide_compliance"]:checked');
//     const engagementScore = document.querySelector('input[name="engagement_score"]:checked');
//
//     console.log('���� ����:');
//     console.log('�̹��� ����Ƽ:', imageQuality ? imageQuality.value : '�̼���');
//     console.log('�ؽ�Ʈ ����Ƽ:', textQuality ? textQuality.value : '�̼���');
//     console.log('���̵� �ؼ�:', guideCompliance ? guideCompliance.value : '�̼���');
//     console.log('�ΰ�������Ʈ:', engagementScore ? engagementScore.value : '�̼���');
//
//     return {
//         image_quality: imageQuality ? parseInt(imageQuality.value) : 0,
//         text_quality: textQuality ? parseInt(textQuality.value) : 0,
//         guide_compliance: guideCompliance ? parseInt(guideCompliance.value) : 0,
//         engagement_score: engagementScore ? parseInt(engagementScore.value) : 0
//     };
// }
</script>