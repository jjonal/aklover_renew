<form name="searchForm" id="searchForm" method="GET">
<? 
unset($_GET["hero_code"]);
unset($_GET["view"]);
foreach($_GET as $key=>$val) {?>
<input type="hidden" name="<?=$key?>" value="<?=$val?>" />
<? } ?>
</form>

<div class="btnGroupFunction">
    <div class="leftWrap">
        <h2 class="tit_section">�⺻����</h2>
    </div>
    <div class="rightWrap">
        <!-- <a href="javascript:;" onClick="fnPopPoint()" class="btnFunc">����Ʈ Ȯ��</a>
        <a href="javascript:;" onClick="fnPopWrite()" class="btnFunc">�ۼ��� Ȯ��</a> -->


        <!-- <a href="javascript:;" onClick="fnPopSuperpass()" class="btnAdd4">�����н� Ȯ��/�ο�</a> -->
        <a href="javascript:;" class="btnAdd4 popup_btn" data-popup="01">�����н� �ο�</a>


        <!-- <a href="javascript:;" onClick="fnPopPenalty()" class="btnFunc">�г�Ƽ ����</a>
        <a href="javascript:;" onClick="fnWithdrawal('<?=$view["hero_nick"]?>')" class="btnFormCancel">ȸ��Ż��</a> -->
    </div>
</div>

<form name="viewForm" id="viewForm">
<input type="hidden" name="mode" />
<input type="hidden" name="hero_code" value="<?=$view["hero_code"]?>"/>

<table class="searchBox mu_form">
    <colgroup>
        <col width="200px">
        <col width=*>
        <col width="200px">
        <col width=*>
    </colgroup>
    <tbody>
        <tr>
            <th>���̵�</th>
            <td><?=$view["hero_id"]?> (LV : <?=$view["hero_level"]?>)</td>
            <th>�г���</th>
            <td><?=$view["hero_nick"]?></td>
        </tr>
        <tr>
            <th>�̸�</th>
            <td><?=$view["hero_name"]?></td>
            <th>����</th>
            <td><?=$view["hero_age"]?></td>
        </tr>
        <tr>
            <th>�������</th>
            <td><?=$view["hero_jumin"]?></td>
            <th>��������</th>
            <td><?=$hero_group?></td>
        </tr>
        <tr>
            <th>��������Ʈ</th>
            <td>
                <?=number_format($view["hero_point"])?> p
                <a href="javascript:;" class="btnAdd4 popup_btn" data-popup="02">����Ʈ ����/����</a>
                <a href="javascript:;" class="btnAdd4 popup_btn" data-popup="03">�г�Ƽ ����/����</a>
            </td>
            <th>�������� ��</th>
            <td><?=$hero_board_group?></td>
        </tr>
        <tr>
            <th>�޴�����ȣ</th>
            <td>
                <div class="fl alc">
                    <div class="fl alc g5">
                        <input type="text" name="hero_hp_01" value="<?=$hero_hp[0]?>" class="w100 input_hero_hp" maxlength="4" numberOnly readonly/>
                        <div class="inner_between">-</div>
                        <input type="text" name="hero_hp_02" value="<?=$hero_hp[1]?>" class="w100 input_hero_hp" maxlength="4" numberOnly readonly />
                        <div class="inner_between">-</div>
                        <input type="text" name="hero_hp_03" value="<?=$hero_hp[2]?>" class="w100 input_hero_hp" maxlength="4" numberOnly readonly />
                    </div>

                    <label class="akContainer">���� Ȱ��ȭ
                        <input type="checkbox" name="hero_hp_check" id="hero_hp_check">
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
            <th>�̸���</th>
            <td>
                <div class="fl alc g5">
                    <input type="text" name="hero_mail_01" value="<?=$hero_mail[0]?>" class="w150 input_hero_mail" readonly/>
                    <div class="inner_between">@</div>
                    <input type="text" name="hero_mail_02" value="<?=$hero_mail[1]?>" class="w150 input_hero_mail" readonly />
                    
                    <label class="akContainer">���� Ȱ��ȭ
                        <input type="checkbox" name="hero_mail_check" id="hero_mail_check">
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
        </tr>
        <tr>
            <th>�޴��� ���ŵ���</th>
            <td>
                <div class="search_inner">
                    <label class="akContainer">����
                        <input type="radio"name="hero_chk_phone" id="hero_chk_phone_1" value="1" <?=$view["hero_chk_phone"] == "1" ? "checked":""?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">�̵���
                        <input type="radio" name="hero_chk_phone" id="hero_chk_phone_0" value="0" <?=$view["hero_chk_phone"] != "1" ? "checked":""?>/>
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
            <th>�̸��� ���ŵ���</th>
            <td>
                <div class="search_inner">
                    <label class="akContainer">����
                        <input type="radio" name="hero_chk_email" id="hero_chk_email_1" value="1" <?=$view["hero_chk_email"] == "1" ? "checked":""?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">�̵���
                        <input type="radio" name="hero_chk_email" id="hero_chk_email_0" value="0" <?=$view["hero_chk_email"] != "1" ? "checked":""?>/>
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
        </tr>
        <tr>
            <th>�ּ�</th>
            <td>
                [<?=$view["hero_address_01"]?>] <?=$view["hero_address_02"]?> <?=$view["hero_address_03"]?>
            </td>
            <th>ȸ������ ����</th>
            <td><?=$handphone?><?=$kakaoTalk?><?=$naver?><?=$google?><?=$facebook?></td>
        </tr>
        <tr>
            <th>������</th>
            <td><?=$view["hero_oldday"]?></td>
            <th>���� �α��� ��¥</th>
            <td><?=$view["hero_today"]?>&nbsp;&nbsp;&nbsp;<a href="javascript:;" class="btnAdd4 popup_btn" data-popup="04">�α��� �̷�</a></td>
        </tr>
        <tr>
            <th>ȸ��Ż��ó��</th>
            <td>
                <a href="javascript:;" onClick="fnWithdrawal('<?=$view["hero_nick"]?>')" class="btnAdd4">ȸ��Ż��</a>
            </td>
            <th>��й�ȣ �ʱ�ȭ ��¥</th>
            <td id="pw_initialized_datetime"><?=$pw_init["hero_today"]?>
            <? if(isset($pw_init["hero_today"]) && !empty($pw_init["hero_today"])) {?>
            &nbsp;&nbsp;&nbsp;<a href="javascript:;" onClick="fnPopResetPwHist()" class="btnFunc">�ʱ�ȭ �̷�</a>
            <? }?>
            </td>
        </tr>
    </tbody>
</table>


<!-- <table class="t_view">
<colgroup>
    <col width="150px">
    <col width=*>
    <col width="150px">
    <col width=*>
</colgroup>
<tbody>
    <tr>
        <th>���̵�</th>
        <td><?=$view["hero_id"]?> (LV : <?=$view["hero_level"]?>)</td>
        <th>�г���</th>
        <td><?=$view["hero_nick"]?></td>
    </tr>
    <tr>
        <th>�̸�</th>
        <td><?=$view["hero_name"]?></td>
        <th>����</th>
        <td><?=$view["hero_age"]?></td>
    </tr>
    <tr>
        <th>�������</th>
        <td colspan="3"><?=$view["hero_jumin"]?></td>
    </tr>
    <tr>
        <th>��ü����Ʈ</th>
        <td><?=number_format($view["hero_point"])?> p</td>
        <th>��������Ʈ</th>
        <td><?=number_format($view["hero_point"]-$view["hero_order_point"])?> p</td>
    </tr>
    <tr>
        <th>�޴�����ȣ</th>
        <td>
            <input type="text" name="hero_hp_01" value="<?=$hero_hp[0]?>" class="w100 input_hero_hp" maxlength="4" numberOnly readonly />
            - <input type="text" name="hero_hp_02" value="<?=$hero_hp[1]?>" class="w100 input_hero_hp" maxlength="4" numberOnly readonly/>
            - <input type="text" name="hero_hp_03" value="<?=$hero_hp[2]?>" class="w100 input_hero_hp" maxlength="4" numberOnly readonly/>
            
            <input type="checkbox" name="hero_hp_check" id="hero_hp_check"/><label>���� Ȱ��ȭ</label>
        </td>
        <th>�̸���</th>
        <td>
            <input type="text" name="hero_mail_01" value="<?=$hero_mail[0]?>" class="w200 input_hero_mail" readonly/>
            @ <input type="text" name="hero_mail_02" value="<?=$hero_mail[1]?>" class="w200 input_hero_mail" readonly/>
            
            <input type="checkbox" name="hero_mail_check" id="hero_mail_check"/><label>���� Ȱ��ȭ</label>
        </td>
    </tr>
    <tr>
        <th>�޴��� ���ŵ���</th>
        <td>
            <input type="radio" name="hero_chk_phone" id="hero_chk_phone_1" value="1" <?=$view["hero_chk_phone"] == "1" ? "checked":""?>/><label for="hero_chk_phone_1">����</label>
            <input type="radio" name="hero_chk_phone" id="hero_chk_phone_0" value="0" <?=$view["hero_chk_phone"] != "1" ? "checked":""?>/><label for="hero_chk_phone_0">�̵���</label>
        </td>
        <th>�̸��� ���ŵ���</th>
        <td>
            <input type="radio" name="hero_chk_email" id="hero_chk_email_1" value="1" <?=$view["hero_chk_email"] == "1" ? "checked":""?>/><label for="hero_chk_email_1">����</label>
            <input type="radio" name="hero_chk_email" id="hero_chk_email_0" value="0" <?=$view["hero_chk_email"] != "1" ? "checked":""?>/><label for="hero_chk_email_0">�̵���</label>
        </td>
    </tr>
    <tr>
        <th>�ּ�</th>
        <td colspan="3">
            [<?=$view["hero_address_01"]?>] <?=$view["hero_address_02"]?> <?=$view["hero_address_03"]?>
        </td>
    </tr>
    <tr>
        <th>���԰��</th>
        <td>
            <?=$view["area"]?>
            <? if($view["area"]=="��Ÿ") {?> 
                (<?=$view["area_etc_text"]?>)
            <? } ?>
        </td>
        <th>ȸ������ ����</th>
        <td><?=$handphone?><?=$kakaoTalk?><?=$naver?><?=$google?><?=$facebook?></td>
    </tr>
    <tr>
        <th>��õ��</th>
        <td colspan="3">
            <? if($view["hero_user_type"] == "hero_id") {?>
                ���̵� ��õ : 
            <? } else if($view["hero_user_type"] == "hero_nick") { ?>
                �г��� ��õ :
            <? } ?>
            <?=$view["hero_user"]?>
        </td>
    </tr>
    <tr>
        <th>������</th>
        <td><?=$view["hero_oldday"]?></td>
        <th>���� �α��� ��¥</th>
        <td><?=$view["hero_today"]?>&nbsp;&nbsp;&nbsp;<a href="javascript:;" onClick="fnPopLoginHist()" class="btnFunc">�α��� �̷�</a></td>
    </tr>
    <tr>
        <th>��й�ȣ �ʱ�ȭ</th>
        <td>
            <a href="javascript:;" onClick="fnPWInitialize('<?=$view["hero_id"]?>')" class="btnFunc2">�ʱ�ȭ</a>
            <input type="text" name="pw_initialized" value="" style="width:150px; outline:none; border:none;border-right:0px; border-top:0px; boder-left:0px; boder-bottom:0px;" readonly />
        </td>
        <th>���� ��й�ȣ �ʱ�ȭ<br/>��¥</th>
        <td id="pw_initialized_datetime"><?=$pw_init["hero_today"]?>
        <? if(isset($pw_init["hero_today"]) && !empty($pw_init["hero_today"])) {?>
        &nbsp;&nbsp;&nbsp;<a href="javascript:;" onClick="fnPopResetPwHist()" class="btnFunc">�ʱ�ȭ �̷�</a>
        <? }?>
        </td>
    </tr>
</tbody>
</table> -->

<!-- <div class="align_c margin_t20">
    <a href="javascript:;" onclick="fnEdit()" class="btnAdd">����</a>
</div> -->

<ul class="splitContent">
    <li>
        <p class="sub_tit">�߰�����</p>
        <table class="searchBox">
            <colgroup>
                <col width="200px">
                <col width=*>
            </colgroup>
            <tbody>
                <tr>
                    <th>�˰Ե� ���</th>
                    <td>
                        <?=$view["area"]?>
                        <? if($view["area"]=="��Ÿ") {?>
                            (<?=$view["area_etc_text"]?>)
                        <? } ?>
                    </td>
                </tr>
                <tr>
                    <th>�����ִ� Ȱ��</th>
                    <td><?=$view["hero_activity"]?></td>
                </tr>
                <tr>
                    <th>��ȥ ����</th>
                    <td><?=$view["hero_qs_02"] == "Y" ? "��ȥ":"��ȥ"?></td>
                </tr>
                <tr>
                    <th>�ڳ����� /�¾ ����</th>
                    <td>
                    <? if($view["hero_qs_04"]) {
                        $hero_qs_05_arr = explode(",",$view["hero_qs_05"]);
                        $hero_qs_05_txt = "";
                        foreach($hero_qs_05_arr as $val) {
                            if($hero_qs_05_txt) $hero_qs_05_txt .= ", ";
                            $hero_qs_05_txt .= $val;
                        }
                        
                    ?>
                        <?=$view["hero_qs_03"] == "Y" ? "����":"����"?> / <?=$view["hero_qs_04"]?>�� / <?=$hero_qs_05_txt?> 
                    <? } ?>
                    </td>
                </tr>
                <tr>
                    <th>�ݷ����� ����</th>
                    <td><?=$hero_qs_19?></td>
                </tr>
                <tr>
                    <th>������ ����</th>
                    <td><?=$hero_qs_20?></td>
                </tr>
                <tr>
                    <th>�ı⼼ô�� ����</th>
                    <td><?=$hero_qs_21?></td>
                </tr>
                <tr>
                    <th>AK Lover�� ������ ����</th>
                    <td><?=$view["hero_qs_06"]?></td>
                </tr>
                <tr>
                    <th>AK Lover �� Ȱ��</th>
                    <td>
                        <?=$view["hero_qs_07"] == "Y" ? "����":"����"?>
                        <? if($view["hero_qs_07"] == "Y") {?>
                            (<?=$view["hero_qs_08"]?>)
                        <? } ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </li>
    <li>
        <p class="sub_tit">SNS ����</p>
        <table class="searchBox">
            <colgroup>
                <col width="200px">
                <col width=*>
            </colgroup>
            <tbody class="mu_form">
                <tr>
                    <th>SNS ����Ƽ</th>
                    <td><?=$view["hero_id"]?> (LV : <?=$view["hero_level"]?>)</td>
                </tr>
                <tr>
                    <th>����Ƽ ������Ʈ ��¥</th>
                    <td><input type="text" name="hero_sns_update_date" value="<?=$view["hero_sns_update_date"]?>" placeholder="��� ex) yyyymm" numberOnly maxlength="6"></td>
                </tr>
                <tr>
                    <th>���̹� ��α�</th>
                    <td>https://blog.naver.com/<input type="text" style="width:200px;margin-left: 5px;" name="hero_blog_00" value="<?=$hero_naver_blog?>" /></td>
                </tr>
                <tr>
                    <th>�ν�Ÿ�׷�</th>
                    <td>https://www.instagram.com/<input type="text" style="width:200px;margin-left: 5px;" name="hero_blog_04" value="<?=$hero_instagram?>" /></td>
                </tr>
                <tr>
                    <th>����</th>
                    <!-- ��Ʃ�� -->
                    <td>
                        <div class="textLink">
                            <input type="text" name="hero_blog_03" value="<?=$view["hero_blog_03"]?>" class="w100p"/>
                            <span><a href=""><img src="<?=PATH_IMAGE_END?>common/icon_link.svg" alt="����" /></a></span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th rowspan="3">��Ÿ</th>
                    <td>
                        <div class="textLink">
                            <input type="text" name="hero_blog_08" value="<?=$view["hero_blog_08"]?>" class="w100p"/>
                            <span><a href=""><img src="<?=PATH_IMAGE_END?>common/icon_link.svg" alt="����" /></a></span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="textLink">
                            <input type="text" name="hero_blog_08" value="<?=$view["hero_blog_08"]?>" class="w100p"/>
                            <span><a href=""><img src="<?=PATH_IMAGE_END?>common/icon_link.svg" alt="����" /></a></span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="textLink">
                            <input type="text" name="hero_blog_08" value="<?=$view["hero_blog_08"]?>" class="w100p"/>
                            <span><a href=""><img src="<?=PATH_IMAGE_END?>common/icon_link.svg" alt="����" /></a></span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </li>
</ul>

<div class="btnConainer_typeA">
    <a href="javascript:;" onclick="fnEditSns()" class="btnAdd3 center">����</a>
    <a href="javascript:;" onclick="fnList();" class="btnAdd3 right">���</a>
</div>

<!-- 
<p class="tit_section mgt30">SNS ����</p>
<table class="t_view mgt10">
<colgroup>
    <col width="150px">
    <col width=*>
    <col width="100">
    <col width="120">
    <col width="100">
    <col width="120">
    <col width="100">
    <col width="120">
</colgroup>
<tbody>
    <tr>
        <th>����Ƽ ������Ʈ ��¥</th>
        <td colspan="7"><input type="text" name="hero_sns_update_date" value="<?=$view["hero_sns_update_date"]?>" placeholder="��� ex) yyyymm" numberOnly maxlength="6"></td>
    </tr>
    <tr>
        <th>���̹� ��α�</th>
        <td>https://blog.naver.com/<input type="text" style="width:200px;margin-left: 5px;" name="hero_blog_00" value="<?=$hero_naver_blog?>" /></td>
        <th>�湮�� ��</th>
        <td><input type="text" name="hero_memo" value="<?=$view["hero_memo"]?>" numberOnly/></td>
        <th>�̹��� ����Ƽ</th>
        <td><select name="hero_memo_01_image">
                <option value="">����</option>
                <option value="��" <?=$view["hero_memo_01_image"]=="��" ? "selected":""?>>��</option>
                <option value="�߻�" <?=$view["hero_memo_01_image"]=="�߻�" ? "selected":""?>>�߻�</option>
                <option value="��" <?=$view["hero_memo_01_image"]=="��" ? "selected":""?>>��</option>
                <option value="����" <?=$view["hero_memo_01_image"]=="����" ? "selected":""?>>����</option>
                <option value="��" <?=$view["hero_memo_01_image"]=="��" ? "selected":""?>>��</option>
            </select>
        </td>
        <th>�ؽ�Ʈ ����Ƽ</th>
        <td><select name="hero_memo_01">
                <option value="">����</option>
                <option value="��" <?=$view["hero_memo_01"]=="��" ? "selected":""?>>��</option>
                <option value="�߻�" <?=$view["hero_memo_01"]=="�߻�" ? "selected":""?>>�߻�</option>
                <option value="��" <?=$view["hero_memo_01"]=="��" ? "selected":""?>>��</option>
                <option value="����" <?=$view["hero_memo_01"]=="����" ? "selected":""?>>����</option>
                <option value="��" <?=$view["hero_memo_01"]=="��" ? "selected":""?>>��</option>
            </select>
        </td>
    </tr>
    <tr>
        <th>�ν�Ÿ�׷�</th>
        <td>https://www.instagram.com/<input type="text" style="width:200px;margin-left: 5px;" name="hero_blog_04" value="<?=$hero_instagram?>" /></td>
        <th>�ȷο� ��</th>
        <td><input type="text" name="hero_insta_cnt" value="<?=$view["hero_insta_cnt"]?>" numberOnly/></td>
        <th>�̹��� ����Ƽ</th>
        <td><select name="hero_insta_image_grade">
                <option value="">����</option>
                <option value="��" <?=$view["hero_insta_image_grade"]=="��" ? "selected":""?>>��</option>
                <option value="�߻�" <?=$view["hero_insta_image_grade"]=="�߻�" ? "selected":""?>>�߻�</option>
                <option value="��" <?=$view["hero_insta_image_grade"]=="��" ? "selected":""?>>��</option>
                <option value="����" <?=$view["hero_insta_image_grade"]=="����" ? "selected":""?>>����</option>
                <option value="��" <?=$view["hero_insta_image_grade"]=="��" ? "selected":""?>>��</option>
            </select>
        </td>
        <th>�ؽ�Ʈ ����Ƽ</th>
        <td><select name="hero_insta_grade">
                <option value="">����</option>
                <option value="��" <?=$view["hero_insta_grade"]=="��" ? "selected":""?>>��</option>
                <option value="�߻�" <?=$view["hero_insta_grade"]=="�߻�" ? "selected":""?>>�߻�</option>
                <option value="��" <?=$view["hero_insta_grade"]=="��" ? "selected":""?>>��</option>
                <option value="����" <?=$view["hero_insta_grade"]=="����" ? "selected":""?>>����</option>
                <option value="��" <?=$view["hero_insta_grade"]=="��" ? "selected":""?>>��</option>
            </select>
        </td>
    </tr>
    <tr>
        <th>�� ��  SNS</th>
        <td colspan="7"><input type="text" name="hero_blog_05" value="<?=$view["hero_blog_05"]?>" /></td>
    </tr>
    <tr>
        <th>���̹� ���÷�� Ȩ</th>
        <td>https://in.naver.com/<input type="text" style="width:200px;margin-left: 5px;" name="hero_naver_influencer" value="<?=$hero_naver_influencer?>" /></td>
        <th colspan="2">���̹� ���÷�� ��</th>
        <td colspan="2"><input type="text" name="hero_naver_influencer_name" value="<?=$view["hero_naver_influencer_name"]?>"/></td>
        <th>Ȱ�� ī�װ�</th>
        <td><select id="hero_naver_influencer_category" name="hero_naver_influencer_category">
                <option value=""<?if(!strcmp($view["hero_naver_influencer_category"], '')){echo ' selected';}else{echo '';}?>>����</option>
                <option value="����"<?if(!strcmp($view["hero_naver_influencer_category"], '����')){echo ' selected';}else{echo '';}?>>����</option>
                <option value="�м�"<?if(!strcmp($view["hero_naver_influencer_category"], '�м�')){echo ' selected';}else{echo '';}?>>�м�</option>
                <option value="��Ƽ"<?if(!strcmp($view["hero_naver_influencer_category"], '��Ƽ')){echo ' selected';}else{echo '';}?>>��Ƽ</option>
                <option value="Ǫ��"<?if(!strcmp($view["hero_naver_influencer_category"], 'Ǫ��')){echo ' selected';}else{echo '';}?>>Ǫ��</option>
                <option value="IT��ũ"<?if(!strcmp($view["hero_naver_influencer_category"], 'IT��ũ')){echo ' selected';}else{echo '';}?>>IT��ũ</option>
                <option value="�ڵ���"<?if(!strcmp($view["hero_naver_influencer_category"], '�ڵ���')){echo ' selected';}else{echo '';}?>>�ڵ���</option>
                <option value="����"<?if(!strcmp($view["hero_naver_influencer_category"], '����')){echo ' selected';}else{echo '';}?>>����</option>
                <option value="����"<?if(!strcmp($view["hero_naver_influencer_category"], '����')){echo ' selected';}else{echo '';}?>>����</option>
                <option value="��Ȱ�ǰ�"<?if(!strcmp($view["hero_naver_influencer_category"], '��Ȱ�ǰ�')){echo ' selected';}else{echo '';}?>>��Ȱ�ǰ�</option>
                <option value="����"<?if(!strcmp($view["hero_naver_influencer_category"], '����')){echo ' selected';}else{echo '';}?>>����</option>
                <option value="����/��"<?if(!strcmp($view["hero_naver_influencer_category"], '����/��')){echo ' selected';}else{echo '';}?>>����/��</option>
                <option value="�/����"<?if(!strcmp($view["hero_naver_influencer_category"], '�/����')){echo ' selected';}else{echo '';}?>>�/����</option>
                <option value="���ν�����"<?if(!strcmp($view["hero_naver_influencer_category"], '���ν�����')){echo ' selected';}else{echo '';}?>>���ν�����</option>
                <option value="���/����"<?if(!strcmp($view["hero_naver_influencer_category"], '���/����')){echo ' selected';}else{echo '';}?>>���/����</option>
                <option value="��������"<?if(!strcmp($view["hero_naver_influencer_category"], '��������')){echo ' selected';}else{echo '';}?>>��������</option>
                <option value="��ȭ"<?if(!strcmp($view["hero_naver_influencer_category"], '��ȭ')){echo ' selected';}else{echo '';}?>>��ȭ</option>
                <option value="����/����/����"<?if(!strcmp($view["hero_naver_influencer_category"], '����/����/����')){echo ' selected';}else{echo '';}?>>����/����/����</option>
                <option value="����"<?if(!strcmp($view["hero_naver_influencer_category"], '����')){echo ' selected';}else{echo '';}?>>����</option>
                <option value="����/����Ͻ�"<?if(!strcmp($view["hero_naver_influencer_category"], '����/����Ͻ�')){echo ' selected';}else{echo '';}?>>����/����Ͻ�</option>
                <option value="����/����"<?if(!strcmp($view["hero_naver_influencer_category"], '����/����')){echo ' selected';}else{echo '';}?>>����/����</option>
            </select>
        </td>
    </tr>
    <tr>
        <th>��Ʃ��</th>
        <td><input type="text" name="hero_blog_03" value="<?=$view["hero_blog_03"]?>" /></td>
        <th>������ ��</th>
        <td><input type="text" name="hero_youtube_cnt" value="<?=$view["hero_youtube_cnt"]?>" numberOnly/></td>
        <th>��ȸ�� ��</th>
        <td><input type="text" name="hero_youtube_view" value="<?=$view["hero_youtube_view"]?>" numberOnly/></td>
        <th>������ ���</th>
        <td><select name="hero_youtube_grade">
                <option value="">����</option>
                <option value="��" <?=$view["hero_youtube_grade"]=="��" ? "selected":""?>>��</option>
                <option value="�߻�" <?=$view["hero_youtube_grade"]=="�߻�" ? "selected":""?>>�߻�</option>
                <option value="��" <?=$view["hero_youtube_grade"]=="��" ? "selected":""?>>��</option>
                <option value="����" <?=$view["hero_youtube_grade"]=="����" ? "selected":""?>>����</option>
                <option value="��" <?=$view["hero_youtube_grade"]=="��" ? "selected":""?>>��</option>
            </select>
        </td>
    </tr>
    <tr>
        <th>���̹�TV</th>
        <td colspan="7"><input type="text" name="hero_blog_06" value="<?=$view["hero_blog_06"]?>" /></td>
    </tr>
    <tr>
        <th>ƽ��</th>
        <td colspan="7"><input type="text" name="hero_blog_07" value="<?=$view["hero_blog_07"]?>" /></td>
    </tr>
    <tr>
        <th>��Ÿ(����)</th>
        <td colspan="7"><input type="text" name="hero_blog_08" value="<?=$view["hero_blog_08"]?>" /></td>
    </tr>
</tbody>
</table>
<div class="align_c margin_t20">
    <a href="javascript:;" onclick="fnEditSns()" class="btnAdd">����</a>
</div>

<p class="tit_section mgt10">�߰� ���� ����</p>
<table class="t_view mgt10">
<colgroup>
    <col width="150px">
    <col width="">
    <col width="150px">
    <col width="">
</colgroup>
<tbody>
    <tr>
        <th>���� SNS URL(��/��)</th>
        <td><?=$view["hero_qs_01"] == "Y" ? "����":"����"?></td>
        <th>��ȥ ����</th>
        <td><?=$view["hero_qs_02"] == "Y" ? "��ȥ":"��ȥ"?></td>
    </tr>
    <tr>
        <th>�ڳ�����</th>
        <td><?=$view["hero_qs_03"] == "Y" ? "����":"����"?></td>
        <th>�ڳ� ��/�¾ �⵵</th>
        <td>
            <? if($view["hero_qs_04"]) {
                $hero_qs_05_arr = explode(",",$view["hero_qs_05"]);
                $hero_qs_05_txt = "";
                foreach($hero_qs_05_arr as $val) {
                    if($hero_qs_05_txt) $hero_qs_05_txt .= ", ";
                    $hero_qs_05_txt .= $val;
                }
                
            ?>
                <?=$view["hero_qs_04"]?>��/<?=$hero_qs_05_txt?>
                
            <? } ?>
        </td>
    </tr>
    <tr>
        <th>�Ǻ�Ÿ��</th>
        <td><?=$view["hero_qs_22"]?></td>
        <th>����Ÿ��</th>
        <td><?=$view["hero_qs_23"]?></td>
    </tr>
    <tr>
        <th>Ż�� ����</th>
        <td><?=$hero_qs_18?></td>
        <th>�ݷ����� ����</th>
        <td><?=$hero_qs_19?></td>
    </tr>
    <tr>
        <th>������ ����</th>
        <td><?=$hero_qs_20?></td>
        <th>�ı⼼ô�� ����</th>
        <td><?=$hero_qs_21?></td>
    </tr>
    <tr>
        <th>AK LOVER�� ������ ����</th>
        <td colspan="3"><?=$view["hero_qs_06"]?></td>
    </tr>
    <tr>
        <th>AK LOVER�� Ȱ���ϴ� ��������/ü��� ī�� �Ǵ� Ȩ������</th>
        <td colspan="3">
            <?=$view["hero_qs_07"] == "Y" ? "����":"����"?>
            <? if($view["hero_qs_07"] == "Y") {?>
                (<?=$view["hero_qs_08"]?>)
            <? } ?>
        </td>
    </tr>
</tbody>
</table> -->

</form>
<!-- 
<div class="align_l margin_t20">
    <a href="javascript:;" onclick="fnList();" class="btnList">���</a>
</div> -->


<!-- �����н� Ȯ�� �ο� -->
<!-- /loaksecure21/user/popUserManagerSuperpassList.php -->
<div class="popup_url_box" id="pop_01">
	<div class="popup_url_cont">
		<div class="popup_url_head">
			<svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M4.41073 4.41083C4.73617 4.08539 5.26381 4.08539 5.58925 4.41083L15.5892 14.4108C15.9147 14.7363 15.9147 15.2639 15.5892 15.5893C15.2638 15.9148 14.7362 15.9148 14.4107 15.5893L4.41073 5.58934C4.0853 5.2639 4.0853 4.73626 4.41073 4.41083Z" fill="black"/>
				<path fill-rule="evenodd" clip-rule="evenodd" d="M15.5892 4.41083C15.2638 4.08539 14.7362 4.08539 14.4107 4.41083L4.41072 14.4108C4.08529 14.7363 4.08529 15.2639 4.41072 15.5893C4.73616 15.9148 5.2638 15.9148 5.58924 15.5893L15.5892 5.58934C15.9147 5.2639 15.9147 4.73626 15.5892 4.41083Z" fill="black"/>
			</svg>
		</div>
		<div class="popup_url_body mu_form" id="popupContent">
            <iframe src="/loaksecure21/user/popUserManagerSuperpassList.php?hero_code=<?= $view['hero_code'] ?>" width="660" height="720" frameborder="0" class="iframe_popup"></iframe>
		</div>
	</div>
</div>

<!-- ����Ʈ ���� ���� -->
<!-- /loaksecure21/user/popUserManagerPointList.php -->
<div class="popup_url_box" id="pop_02">
	<div class="popup_url_cont">
		<div class="popup_url_head">
			<svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M4.41073 4.41083C4.73617 4.08539 5.26381 4.08539 5.58925 4.41083L15.5892 14.4108C15.9147 14.7363 15.9147 15.2639 15.5892 15.5893C15.2638 15.9148 14.7362 15.9148 14.4107 15.5893L4.41073 5.58934C4.0853 5.2639 4.0853 4.73626 4.41073 4.41083Z" fill="black"/>
				<path fill-rule="evenodd" clip-rule="evenodd" d="M15.5892 4.41083C15.2638 4.08539 14.7362 4.08539 14.4107 4.41083L4.41072 14.4108C4.08529 14.7363 4.08529 15.2639 4.41072 15.5893C4.73616 15.9148 5.2638 15.9148 5.58924 15.5893L15.5892 5.58934C15.9147 5.2639 15.9147 4.73626 15.5892 4.41083Z" fill="black"/>
			</svg>
		</div>
		<div class="popup_url_body mu_form" id="popupContent">
            <iframe src="/loaksecure21/user/popUserManagerPointList.php?hero_code=<?=$view["hero_code"]?>" width="660" height="720" frameborder="0" class="iframe_popup">
            </iframe>
		</div>
	</div>
</div>

<!-- �г�Ƽ ���� ���� -->
<!-- /loaksecure21/user/popUserManagerPenaltyList.php -->
<div class="popup_url_box" id="pop_03">
	<div class="popup_url_cont">
		<div class="popup_url_head">
			<svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M4.41073 4.41083C4.73617 4.08539 5.26381 4.08539 5.58925 4.41083L15.5892 14.4108C15.9147 14.7363 15.9147 15.2639 15.5892 15.5893C15.2638 15.9148 14.7362 15.9148 14.4107 15.5893L4.41073 5.58934C4.0853 5.2639 4.0853 4.73626 4.41073 4.41083Z" fill="black"/>
				<path fill-rule="evenodd" clip-rule="evenodd" d="M15.5892 4.41083C15.2638 4.08539 14.7362 4.08539 14.4107 4.41083L4.41072 14.4108C4.08529 14.7363 4.08529 15.2639 4.41072 15.5893C4.73616 15.9148 5.2638 15.9148 5.58924 15.5893L15.5892 5.58934C15.9147 5.2639 15.9147 4.73626 15.5892 4.41083Z" fill="black"/>
			</svg>
		</div>
		<div class="popup_url_body mu_form" id="popupContent">
        <iframe src="/loaksecure21/user/popUserManagerPenaltyList.php?hero_code=<?=$view["hero_code"]?>" width="660" height="720" frameborder="0" class="iframe_popup">
        </iframe>
		</div>
	</div>
</div>

<!-- �α��� �̷� -->
<!-- /loaksecure21/user/popUserManagerLoginHist.php -->
<div class="popup_url_box" id="pop_04">
	<div class="popup_url_cont">
		<div class="popup_url_head">
			<svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M4.41073 4.41083C4.73617 4.08539 5.26381 4.08539 5.58925 4.41083L15.5892 14.4108C15.9147 14.7363 15.9147 15.2639 15.5892 15.5893C15.2638 15.9148 14.7362 15.9148 14.4107 15.5893L4.41073 5.58934C4.0853 5.2639 4.0853 4.73626 4.41073 4.41083Z" fill="black"/>
				<path fill-rule="evenodd" clip-rule="evenodd" d="M15.5892 4.41083C15.2638 4.08539 14.7362 4.08539 14.4107 4.41083L4.41072 14.4108C4.08529 14.7363 4.08529 15.2639 4.41072 15.5893C4.73616 15.9148 5.2638 15.9148 5.58924 15.5893L15.5892 5.58934C15.9147 5.2639 15.9147 4.73626 15.5892 4.41083Z" fill="black"/>
			</svg>
		</div>
		<div class="popup_url_body mu_form" id="popupContent">
            <iframe src="/loaksecure21/user/popUserManagerLoginHist.php?hero_code=<?=$view["hero_code"]?>" width="660" height="720" frameborder="0" class="iframe_popup"></iframe>
		</div>
	</div>
</div>

            
<script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>
<script src="/js/daumAddressApi.js"></script>
<script>
$(document).ready(function(){
	$("#hero_hp_check").on("click",function(){
		if($(this).is(":checked")) {
			$(".input_hero_hp").attr("readOnly",false);
		} else {
			$(".input_hero_hp").attr("readOnly",true);
		}
	})
	
	$("#hero_mail_check").on("click",function(){
		if($(this).is(":checked")) {
			$(".input_hero_mail").attr("readOnly",false);
		} else {
			$(".input_hero_mail").attr("readOnly",true);
		}
	})

	fnPopPoint = function() {
		var popPoint = window.open("/loaksecure21/user/popUserManagerPointList.php?hero_code=<?=$view["hero_code"]?>","popPoint","width=660, height=660");
		popPoint.focus();
	}

	fnPopWrite = function() {
		var popWrite = window.open("/loaksecure21/user/popUserManagerWriteList.php?hero_code=<?=$view["hero_code"]?>","popWrite","width=660, height=500");
		popWrite.focus();
	}
	
	fnPopLoginHist = function() {
		var popWrite = window.open("/loaksecure21/user/popUserManagerLoginHist.php?hero_code=<?=$view["hero_code"]?>","popWrite","width=660, height=500");
		popWrite.focus();
	}
	
	fnPopResetPwHist = function() {
		var popWrite = window.open("/loaksecure21/user/popUserManagerResetPwHist.php?hero_code=<?=$view["hero_code"]?>","popWrite","width=660, height=500");
		popWrite.focus();
	}

	fnPopSuperpass = function() {
		var popSuperpass = window.open("/loaksecure21/user/popUserManagerSuperpassList.php?hero_code=<?=$view["hero_code"]?>","popSuperpass","width=660, height=500");
		popSuperpass.focus();
	}

	fnPopPenalty = function() {
		var popPenalty = window.open("/loaksecure21/user/popUserManagerPenaltyList.php?hero_code=<?=$view["hero_code"]?>","popPenalty","width=660, height=500");
		popPenalty.focus();
	}
	
	fnEditSns = function() {
		if(confirm("SNS ���� ������ �����Ͻðڽ��ϱ�?")) {
			$("#viewForm input[name='mode']").val("editSns");
			var param = $("#viewForm").serialize();
			$.ajax({
					url:"/loaksecure21/user/userManagerAction.php"
					,type:"POST"
					,data:param
					,dataType:"json"
					,success:function(d){
						console.log(d);
						if(d.result==1) {
							alert("SNS ���� ������ ���� �Ǿ����ϴ�.");
							location.reload();
						} else {
							alert("���� �� �����߽��ϴ�.")
						}
					},error:function(e){
						console.log(e);
						alert("�����߽��ϴ�.");
					}
				})
				
			$("#viewForm input[name='mode']").val("");//�ʱ�ȭ
		}
	}
	
	
	fnEdit = function() {
		_frm = $("#viewForm");
		if(!_frm.find("input[name='hero_hp_01']").val()) {
			alert("�޴���(1)�� �Է��� �ּ���.");
			_frm.find("input[name='hero_hp_01']").focus();
			return;
		}

		if(!_frm.find("input[name='hero_hp_02']").val()) {
			alert("�޴���(2)�� �Է��� �ּ���.");
			_frm.find("input[name='hero_hp_02']").focus();
			return;
		}

		if(!_frm.find("input[name='hero_hp_03']").val()) {
			alert("�޴���(3)�� �Է��� �ּ���.");
			_frm.find("input[name='hero_hp_03']").focus();
			return;
		}

		if(!_frm.find("input[name='hero_mail_01']").val()) {
			alert("�̸���(1)�� �Է��� �ּ���.");
			_frm.find("input[name='hero_mail_01']").focus();
			return;
		}

		if(!_frm.find("input[name='hero_mail_02']").val()) {
			alert("�̸���(2)�� �Է��� �ּ���.");
			_frm.find("input[name='hero_mail_02']").focus();
			return;
		}
		/*
		if(!_frm.find("input[name='hero_address_01']").val()) {
			alert("�����ȣ�� �Է��� �ּ���.");
			_frm.find("input[name='hero_address_01']").focus();
			return;
		}

		if(!_frm.find("input[name='hero_address_02']").val()) {
			alert("�ּҸ� �Է��� �ּ���.");
			_frm.find("input[name='hero_address_02']").focus();
			return;
		}
		*/

		_frm.find("input[name='mode']").val("edit");
		var param = _frm.serialize();
		$.ajax({
				url:"/loaksecure21/user/userManagerAction.php"
				,type:"POST"
				,data:param
				,dataType:"json"
				,success:function(d){
					console.log(d);
					if(d.result==1) {
						alert(" ���� �Ǿ����ϴ�.");
						location.reload();
					} else {
						alert("���� �� �����߽��ϴ�.")
					}
				},error:function(e){
					console.log(e);
					alert("�����߽��ϴ�.");
				}
			})
			
			_frm.find("input[name='mode']").val(""); //�ʱ�ȭ
	}
	
	
	fnPWInitialize = function(hero_id) { 
		alert("�н����带 �Է����ּ���.");
        const name = prompt("�н����� �Է�" + "");
        if (name=="") {
            return fnPwResetConfirm();
        }
        
        else if (name == null) {
            return;
        }
    
        if (name == '0104'){
            _frm = $("#viewForm");
        
            const characters ='8A0B1CD2EF7GH3IJKL4MN6OPQ5RS9TUV6WXYZa7b5cde8fghi9jkl4mn3opqr2stuvw1xyz0';
            let result = '';
            const charactersLength = characters.length;
            for (let i = 0; i < 8; i++) {
               result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
        
            result = hero_id + result;
            _frm.find("input[name='pw_initialized']").val(result);

    		_frm.find("input[name='mode']").val("pwInitialize");
    		var param = _frm.serialize();
    		$.ajax({
    				url:"/loaksecure21/user/userManagerAction.php"
    				,type:"POST"
    				,data:param
    				,dataType:"json"
    				,success:function(d){
    					console.log(d);
    					if(d.result==1) {
    						var today = new Date();
                            today.setHours(today.getHours() + 9);
                            var datestr = today.toISOString().replace('T', ' ').substring(0, 19);
                            $("#pw_initialized_datetime").text(datestr);
    						alert("�ʱ�ȭ �Ǿ����ϴ�.");
    					} else {
    						alert("���� �� �����߽��ϴ�.");
    					}
    				},error:function(e){
    					console.log(e);
    					alert("�����߽��ϴ�.");
    				}
    			})
			
			_frm.find("input[name='mode']").val("");
        } else {
            alert("�н����尡 Ʋ�Ƚ��ϴ�.")
        }
	}
	
	
	fnWithdrawal = function(hero_nick) {
		if(confirm(hero_nick+"���� ������ �������� Ż���Ͻðڽ��ϱ�?\nŻ�� �� ������ �Ұ����մϴ�.")) {
			$("#viewForm input[name='mode']").val("withdrawal");
			var param = $("#viewForm").serialize();
			$.ajax({
					url:"/loaksecure21/user/userManagerAction.php"
					,type:"POST"
					,data:param
					,dataType:"json"
					,success:function(d){
						console.log(d);
						if(d.result==1) {
							alert("Ż��Ǿ����ϴ�.");
							fnList();
						} else {
							alert("���� �� �����߽��ϴ�.")
						}
					},error:function(e){
						console.log(e);
						alert("�����߽��ϴ�.");
					}
				})
				
			$("#viewForm input[name='mode']").val("");//�ʱ�ȭ
		}
	}
	
	fnList = function() {
		$("#searchForm").submit();
	}
})

</script>

