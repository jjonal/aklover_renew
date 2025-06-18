<!--모서리 팝업 관리 겹쳐서 팝업-->
<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/anytime.5.1.2.css">
<script src="<?=ADMIN_DEFAULT?>/js/anytime.5.1.2.js"></script>
<?
$table = 'corner_popup';
//$hero_board = 'banner'; //뮤자인 삭제
if(!strcmp($_GET['type'], 'edit')){
    $post_count = count($_POST['hero_idx']);
    $hero_file = imageUploader($_FILES['hero_file'],"/aklover/photo/", true);

    for($i=0;$i<$post_count;$i++){
        reset($_POST);
        unset($sql_one_update);
        unset($sql_one);
        unset($sql_two);

        $j=0;
        foreach($_POST as $post_key=>$post_val){
        	if($post_key=='hero_idx'){
        		$idx = $_POST[$post_key][$i];
        		continue;
        	}
        	if($j==0)	$comma = '';
        	else		$comma = ',';

            //노출 순서
            if ($post_key=='hero_order' && empty($_POST[$post_key][$i]) == 1) $_POST[$post_key][$i] = ($i+1);

        	//update
        	if($idx!=0){
	        	if($post_key=='hero_main' && $hero_file[$i]!="noFile")		$sql_one_update .= $comma.$post_key."='".$hero_file[$i]."'";
	       		else														$sql_one_update .= $comma.$post_key."='".$_POST[$post_key][$i]."'";

		        $sql = "UPDATE ".$table." SET ".$sql_one_update." WHERE hero_idx = '".$idx."';";
			}
        	//insert
        	else{
        		if($post_key=='hero_main' && $hero_file[$i]!="noFile"){
        			$sql_one .= $comma.$post_key;
        			$sql_two .= $comma."'".$hero_file[$i]."'";
        		}else{
        			$sql_one .= $comma.$post_key;
        			$sql_two .= $comma."'".$_POST[$post_key][$i]."'";
        		}
        		$sql = "insert into ".$table." (".$sql_one.") values (".$sql_two.");";
        	}
//            echo $sql.'<br>';
	        $j++;
        }

		mysql_query($sql);
    }

    msg('설정 되었습니다.','location.href="'.PATH_HOME.'?'.get('type','').'"');
    exit;

}else if(!strcmp($_GET['type'], 'drop')){
	$idx = $_GET['idx'];

	if(is_numeric($idx)){
	    $sql = "DELETE FROM ".$table." WHERE hero_idx = '".$_GET['hero_idx']."'";
	    sql($sql);
	}
    msg('삭제 되었습니다.','location.href="'.PATH_HOME.'?'.get('type||hero_idx','').'"');
    exit;
}
?>
<div class="popupBtnList">
	<p>노출 순서 설정 : </p>
	<div class="btn_list">
		<button class="btn_front"><img src="/loaksecure21/image/icon_top.png" alt="맨위로" /></button>
		<button class="btn_prev"><img src="/loaksecure21/image/icon_up.png" alt="위로" /></button>
		<button class="btn_next"><img src="/loaksecure21/image/icon_down.png" alt="아래" /></button>
		<button class="btn_back"><img src="/loaksecure21/image/icon_bottom.png" alt="맨아래로" /></button>
	</div>
</div>
<div id="layer" style="text-align:center; position:absolute; display:none; margin:0; padding:0; z-index:1;border:solid 5px red"></div>
<form name="form_next" action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post" enctype="multipart/form-data">
<table class="t_list">
    <thead>
        <tr>
            <!-- <th width="5%">선택</th> -->
			<th width="5%">선택</th>
			<th width="5%">NO</th>
            <th width="17%">이미지</th>
            <th width="*">팝업링크</th>
            <th width="20%">노출기간</th>
            <th width="5%">관리</th>
        </tr>
    </thead>
    <tbody class="list">
        <?
        $sql = "select * from ".$table." order by replace(hero_order,0,999) asc";
        sql($sql);
        $i = '0';
        while($list                             = @mysql_fetch_assoc($out_sql)){
        ######################################################################################################################################################
            if($list['hero_use']==1){
                $hero_checked = "checked='checked'";
            }else{
                $hero_checked = '';
            }
        ?>
            <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'" class="item">
                <input type="hidden" name="hero_idx[]" value="<?=$list['hero_idx']?>">
                <input type="hidden" name="hero_main[]" value="<?=$list['hero_main']?>">
                <input type="hidden" name="hero_order[]">
                <!-- <td class="checkbox_container">
                    <input type="checkbox" class="hero_use_check" <?=$hero_checked;?>>
                    <input type="hidden" class="hero_use" name="hero_use[]" value="<?=$list['hero_use']?>">
                </td> -->
                <td class="order-item">
                    <input type="checkbox" />
                </td>
                <td><?=$list['hero_order']?></td>
                <td align="center" style="text-align:center;">
                    <div align="center" style="text-align:center;width:100%;">
                    <? if($list['hero_main']!='' && $list['hero_main']!=null){?>
                        <img class="group1" src="/aklover/photo/<?=$list['hero_main']?>" alt="" height="71" onclick="hero_layer('layer',this.src);" style="margin-bottom:10px;"/><br/>
                    <? } ?>
                    <input type="file" name="hero_file[]" style="width:140px;">
                    </div>
                </td>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="95%" style="border: none;">
                        <!--뮤자인 수정 S-->
                        <tr>
                            <td style="border: none;padding:2px;">PC : </td>
                            <td style="border: none;padding:2px;"><input type="text" name="hero_pc_href[]" value="<?=$list['hero_pc_href']?>" style="width:350px"/></td>
                        </tr>

                        <tr>
                            <td style="border: none;padding:2px;">MO : </td>
                            <td style="border: none;padding:2px;"><input type="text" name="hero_mo_href[]" value="<?=$list['hero_mo_href']?>" style="width:350px"/></td>
                        </tr>
                        <!--뮤자인 수정 E-->
                    </table>
                </td>
                <td>
                    <input class="sdate" id="sdate<?=$list['hero_idx']?>" type="text" name="hero_today_01[]" value="<?=$list['hero_today_01']?>" style="width:140px"/> ~
                    <input class="sdate" id="edate<?=$list['hero_idx']?>" type="text" name="hero_today_02[]" value="<?=$list['hero_today_02']?>" style="width:140px"/>
                </td>
                <td><a href="javascript:location.href='<?=PATH_HOME.'?'.get('','type=drop&hero_idx='.$list['hero_idx']);?>'" class="btnForm">삭제</a></td>
            </tr>
<!-- for문 끝나고 스크립트 동작하도록 수정
            <script>
                $(function(){
                    $("#sdate<?php /*=$list['hero_idx']*/?>").AnyTime_picker( {
                    format: "%Y-%m-%d %H:%i:00"
                    });
                    $("#edate<?php /*=$list['hero_idx']*/?>").AnyTime_picker( {
                    format: "%Y-%m-%d %H:%i:00"
                    });
                });
            </script>
-->
        <?
        $i++;
        }
        ?>
    </tbody>

    <script>
        $(function(){
            //sdate edate가 포함된 인풋박스들 데이터포맷 설정
            $("[id*='sdate']").AnyTime_picker({
                format: "%Y-%m-%d %H:%i:00"
            });
            $("[id*='edate']").AnyTime_picker({
                format: "%Y-%m-%d %H:%i:00"
            });
        });
    </script>
</table>
<div class="btnGroup">
	<a href="javascript:void(make_new_form());" class="btnAdd2">팝업 추가</a>
	<a href="javascript:form_next.submit();" class="btnAdd">설정</a>
</div>
</form>

<script>
	$(document).ready(function(){
		pageInit();

	});

	function pageInit(){
		//dateclick2();
		$(".hero_use_check").click(function(){
			$hero_use = $(this).siblings(".hero_use");
			if($hero_use.val()==1){
				$hero_use.val(0);
			}else{
				$hero_use.val(1);
			}
		});
	}

	var loop = 10000000;
	// 팝업 추가 시 아이템 리스트 재할당
	let itemInputAll = document.querySelectorAll(".item .order-item input");

	function make_new_form(){
		var new_form = "";
		new_form += "<tr onmouseover=\"this.style.background='#B9DEFF'\" onmouseout=\"this.style.background='white'\" class='item'>";
		new_form += "<input type='hidden' name='hero_idx[]' value='0'>";
        new_form += "<input type='hidden' name='hero_main[]'>";
        new_form += "<input type='hidden' name='hero_order[]'>";
		// new_form += "<td class='checkbox_container'><input type='checkbox' class='hero_use_check'><input type='hidden' class='hero_use' name='hero_use[]' value='0'></td>";
		new_form += "<td class='order-item'><input type='checkbox'></td>"
		new_form += "<td></td>"
		new_form += "<td>";
		new_form += "<img class='group1' src='' alt='' height='71' onclick='hero_layer(\'layer\',this.src);' style='margin-bottom:10px;'/><br/>";
		new_form += "<input type='file' name='hero_file[]' style='width:140px;'>";
		new_form += "</td>";
		new_form += "<td>";
		new_form += "<table border='0' cellpadding='0' cellspacing='0' width='95%' style='border: none;'>";
		<!--뮤자인 수정 S-->
		new_form += "<tr>";
		new_form += "<td style='border: none;padding:2px;'>PC : </td>";
		new_form += "<td style='border: none;padding:2px;'><input type='text' name='hero_pc_href[]' value='' style='width:350px'/></td>";
		new_form += "</tr>";

		new_form += "<tr>";
		new_form += "<td style='border: none;padding:2px;'>MO : </td>";
		new_form += "<td style='border: none;padding:2px;'><input type='text' name='hero_mo_href[]' style='width:350px'/> </td>";
		new_form += "</tr>";
		<!--뮤자인 수정 E-->
		new_form += "</table>";
		new_form += "</td>";
		new_form += "<td>";
		new_form += "<input class='sdate' id='sdate"+loop+"' type='text' name='hero_today_01[]' style='width:140px'/> ~ ";
		new_form += "<input class='edate' id='edate"+loop+"' type='text' name='hero_today_02[]' style='width:140px'/>";
		new_form += "</td>";
		new_form += "<td><a href=\"javascript:location.href='<?=PATH_HOME.'?'.get('','type=drop&hero_idx='.$list['hero_idx']);?>'\" class='btnForm'>삭제</a></td>";
		new_form += "</tr>";


		$(".t_list").append(new_form);
		pageInit();
		var sdate = "#sdate"+loop;
		var edate = "#edate"+loop;
		var period = "#period"+loop;
		$(sdate).AnyTime_picker({format:"%Y-%m-%d %H:%i:00"});
		$(edate).AnyTime_picker({format:"%Y-%m-%d %H:%i:00"});

		itemInputAll = document.querySelectorAll(".item .order-item input");
		loop++;
		return false;
	}

	// 리스트 요소 위치 이동 기능 구현
	let itemAll = document.querySelectorAll(".item");
    let listContainer = document.querySelector(".list");
    let moveElement = new Set(); // 여기에 이동시킬 요소를 담는다.
    let itemElement = [];

    // 체크 박스 초기화
    function clearCheckbox(){
        const isCheckedBox = document.querySelectorAll(".item .order-item input");

        isCheckedBox.forEach(item => {
            item.checked = false;
        });
    }

    function resetFunc() {
        itemElement = [];
        moveElement = new Set();
        clearCheckbox();
        itemInputAll = document.querySelectorAll(".item .order-item input");
    };

    // 최상단 이동
    function movePosition1() {
        itemElement.forEach((item, _) => {
            listContainer.prepend(item.parentNode.parentNode);
        });

        resetFunc(); // 초기화
    }

    // 앞으로 이동
    function movePosition2() {
        const children = Array.from(listContainer.children);
        itemElement.forEach(item => {
            const itemIndex = children.indexOf(item.parentNode.parentNode);
            const newIndex = itemIndex - 1 < 0 ? 0 : itemIndex - 1;
            listContainer.insertBefore(item.parentNode.parentNode, listContainer.children[newIndex]);
        });
        resetFunc(); // 초기화
    };

    // 뒤로 이동
    function movePosition3() {
        itemElement.forEach(item => {
            const children = Array.from(listContainer.children);
            const itemIndex = children.indexOf(item.parentNode.parentNode);

            if (itemIndex === -1) return;
            const newIndex = Math.min(itemIndex + 1, children.length - 1);
            if (newIndex < children.length) {
                listContainer.insertBefore(item.parentNode.parentNode, children[newIndex + 1] || null);
            }

            resetFunc(); // 초기화
        });
    }

    // 최하단 이동
    function movePosition4() {
        itemElement.forEach((item, _) => {
            listContainer.append(item.parentNode.parentNode);
        });
        resetFunc(); // 초기화
    }

    // moveElement 객체에 checked 데이터 저장
    function saveCheckedItem() {
        itemInputAll.forEach((item, _) => {
            item.addEventListener("change", function () {
                // 현재 item의 최신 인덱스를 계산
                const updatedItemInputAll = Array.from(document.querySelectorAll(".item .order-item input"));
                const idx = updatedItemInputAll.indexOf(item);
                if (item.checked) {
                    const element = { idx, item };
                    moveElement.add(element);
                } else {
                    moveElement.forEach(ele => {
                        if (ele.idx === idx) {
                            moveElement.delete(ele);
                        }
                    });
                }
            })
        });
    };

    saveCheckedItem();

    // 버튼 리스트
    const btnList = document.querySelectorAll(".btn_list > button");
    const movePositions = [movePosition1, movePosition2, movePosition3, movePosition4];

    function ascending() {
        const ascArr = Array.from(moveElement).sort((a, b) =>  a.idx - b.idx ).map(el => el.item);
        itemElement = ascArr;
        return ascArr;
    }

    function descending() {
        const desArr = Array.from(moveElement).sort((a, b) =>  b.idx - a.idx ).map(el => el.item);
        itemElement = desArr;
        return desArr;
    }

    btnList.forEach((item, idx) => {
        item.addEventListener("click", () => {
            // 순서 변경 버튼 클릭 전, element 순서 정렬
            if(idx === 0 || idx === 2){
                descending();
            } else {
                ascending();
            }

            if(moveElement.size > 0) {
                movePositions[idx]();
            } else {
                alert("체크박스를 선택하세요.")
            }
        });
    })
</script>