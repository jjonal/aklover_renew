<!-- loaksecure21/index.php?idx=146&board=user&page=1&view=qualityEvaluationView  -->

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
                        <select name="select">
                            <option value="none" <?=!isset($_GET["select"]) || $_GET["select"] == "none" ? "selected" : ""?>>선택</option>
                            <option value="grade_top" <?=$_GET["select"] == "m.grade_top" ? "selected" : ""?>>최상</option>
                            <option value="grade_high" <?=$_GET["select"] == "m.grade_high" ? "selected" : ""?>>상</option>
                            <option value="grade_mid" <?=$_GET["select"] == "m.grade_mid" ? "selected" : ""?>>중</option>
                            <option value="grade_low" <?=$_GET["select"] == "m.grade_low" ? "selected" : ""?>>하</option>
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
                        <input type="radio" name="hero_image_quality" value="">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">△
                        <input type="radio" name="hero_image_quality" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">×
                        <input type="radio" name="hero_image_quality" value="2">
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
                        <input type="radio" name="hero_text_quality" value="">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">△
                        <input type="radio" name="hero_text_quality" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">×
                        <input type="radio" name="hero_text_quality" value="2">
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
                        <input type="radio" name="hero_guide" value="">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">△
                        <input type="radio" name="hero_guide" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">×
                        <input type="radio" name="hero_guide" value="2">
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
                            <input type="radio" name="hero_engagement" value="">
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">△
                            <input type="radio" name="hero_engagement" value="1">
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">×
                            <input type="radio" name="hero_engagement" value="2">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="addForm">
                        <p>좋아요</p>
                        <input type="text" />
                    </div>
                    <div class="addForm">
                        <p>댓글</p>
                        <input type="text" />
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <th>팔로워 수</th>
            <td>
                <div class="fl alc g50">
                    <div class="search_inner sup">
                        <label class="akContainer">○
                            <input type="radio" name="hero_follower" value="">
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">△
                            <input type="radio" name="hero_follower" value="1">
                            <span class="checkmark"></span>
                        </label>
                        <label class="akContainer">×
                            <input type="radio" name="hero_follower" value="2">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="addForm">
                        <p>팔로워 수</p>
                        <input type="text" />
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <th>상위 노출</th>
            <td>
                <div class="search_inner sup">
                    <label class="akContainer">○
                        <input type="radio" name="hero_top_exposure" value="">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">△
                        <input type="radio" name="hero_top_exposure" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">×
                        <input type="radio" name="hero_top_exposure" value="2">
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
        </tr>
        <tr>
            <th>합계 점수</th>
            <td>100</td>
        </tr>
        <tr>
            <th>최종 수정일</th>
            <td>2024-07-31 23:59</td>
        </tr>
        </tbody>
    </table>

    <div class="btnContainer mgt20">
        <a href="javascript:;" class="btnAdd3">저장</a>
    </div>
</div>