<!-- loaksecure21/index.php?idx=146&board=user&page=1&view=qualityEvaluationView  -->

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
                        <select name="select">
                            <option value="none" <?=!isset($_GET["select"]) || $_GET["select"] == "none" ? "selected" : ""?>>����</option>
                            <option value="grade_top" <?=$_GET["select"] == "m.grade_top" ? "selected" : ""?>>�ֻ�</option>
                            <option value="grade_high" <?=$_GET["select"] == "m.grade_high" ? "selected" : ""?>>��</option>
                            <option value="grade_mid" <?=$_GET["select"] == "m.grade_mid" ? "selected" : ""?>>��</option>
                            <option value="grade_low" <?=$_GET["select"] == "m.grade_low" ? "selected" : ""?>>��</option>
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
                        <input type="radio" name="hero_image_quality" value="">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">��
                        <input type="radio" name="hero_image_quality" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">��
                        <input type="radio" name="hero_image_quality" value="2">
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
                        <input type="radio" name="hero_text_quality" value="">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">��
                        <input type="radio" name="hero_text_quality" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">��
                        <input type="radio" name="hero_text_quality" value="2">
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
                        <input type="radio" name="hero_guide" value="">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">��
                        <input type="radio" name="hero_guide" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">��
                        <input type="radio" name="hero_guide" value="2">
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
                            <input type="radio" name="hero_engagement" value="">
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">��
                            <input type="radio" name="hero_engagement" value="1">
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">��
                            <input type="radio" name="hero_engagement" value="2">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="addForm">
                        <p>���ƿ�</p>
                        <input type="text" />
                    </div>
                    <div class="addForm">
                        <p>���</p>
                        <input type="text" />
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <th>�ȷο� ��</th>
            <td>
                <div class="fl alc g50">
                    <div class="search_inner sup">
                        <label class="akContainer">��
                            <input type="radio" name="hero_follower" value="">
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">��
                            <input type="radio" name="hero_follower" value="1">
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">��
                            <input type="radio" name="hero_follower" value="2">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="addForm">
                        <p>�ȷο� ��</p>
                        <input type="text" />
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <th>���� ����</th>
            <td>
                <div class="search_inner sup">
                    <label class="akContainer">��
                        <input type="radio" name="hero_top_exposure" value="">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">��
                        <input type="radio" name="hero_top_exposure" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">��
                        <input type="radio" name="hero_top_exposure" value="2">
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
        </tr>
        <tr>
            <th>�հ� ����</th>
            <td>100</td>
        </tr>
        <tr>
            <th>���� ������</th>
            <td>2024-07-31 23:59</td>
        </tr>
        </tbody>
    </table>

    <div class="btnContainer mgt20">
        <a href="javascript:;" class="btnAdd3">����</a>
    </div>
</div>