<?
if(!defined('_HEROBOARD_'))exit;
$cut_title_name = '26';

$sql = 'select * from mission where hero_table = \''.$_GET['board'].'\' and hero_idx=\''.$_GET['idx'].'\';';
sql($sql, 'on');
$out_row = @mysql_fetch_assoc($out_sql);//mysql_fetch_row

$mission_board_type = false; //�ҹ�����, �̼� �����ϱ� Ÿ��
if($out_row["hero_type"] == "2" ||  $out_row["hero_type"] == "10") {
	$mission_board_type = true;
}

$right_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
$out_right_sql = mysql_query($right_sql);
$right_list                             = @mysql_fetch_assoc($out_right_sql);

//�����ڰ� ���� �� ���(ü���ı⿡��)
if($_GET['somun'] == 'Y') {
	$where = "and hero_old_idx = '".$_GET['idx']."' and hero_idx = '".$_GET['hero_idx']."'";
	$where2 = "and hero_idx = '".$_GET['board_idx']."'";
}else {
	$where = "and hero_old_idx = '".$_GET['idx']."' and hero_code = '".$_SESSION['temp_code']."'";
	$where2 = "and hero_code='".$_SESSION['temp_code']."'";
}

$edit_sql = 'select * from mission_review where hero_table = \''.$_GET['board'].'\' '.$where.'';

$out_edit_sql = mysql_query($edit_sql);
$edit_list                             = @mysql_fetch_assoc($out_edit_sql);

if(!$edit_list["hero_idx"]) {
	error_historyBack("��û������ �����ϴ�.");
}

if($mission_board_type) { //�ҹ�����
	$board_sql  = " SELECT hero_idx, hero_code, hero_01, hero_03, hero_04, hero_table, hero_title, hero_nick, hero_thumb FROM board ";
	$board_sql .= " WHERE hero_01=".$_GET['idx']." ".$where2."";
	$out_board_sql = mysql_query($board_sql);
	$board_list = @mysql_fetch_assoc($out_board_sql);
	
	//���̹�
	$naver_sql = " SELECT url, member_check, admin_check FROM mission_url WHERE board_hero_idx = '".$board_list["hero_idx"]."' AND gubun='naver' ";
	$naver_res = sql($naver_sql);
	$naver_rs = mysql_fetch_assoc($naver_res);
	
	//�ν�Ÿ
	$insta_sql = " SELECT url, member_check, admin_check FROM mission_url WHERE board_hero_idx = '".$board_list["hero_idx"]."' AND gubun='insta' ";
	$insta_res = sql($insta_sql);
	$insta_rs = mysql_fetch_assoc($insta_res);
	
	//��Ʃ��
	if($_GET["action"] == "group_04_27") {
		$movie_sql = " SELECT url, member_check, admin_check FROM mission_url WHERE board_hero_idx = '".$board_list["hero_idx"]."' AND gubun='movie' ORDER by hero_idx ASC ";
		$movie_res = sql($movie_sql);
	}
	
	//ī��
	$cafe_sql = " SELECT url, member_check, admin_check FROM mission_url WHERE board_hero_idx = '".$board_list["hero_idx"]."' AND gubun='cafe' ORDER by hero_idx ASC ";
	$cafe_res = sql($cafe_sql);
	
	//��Ÿ
	$etc_sql = " SELECT url, member_check, admin_check FROM mission_url WHERE board_hero_idx = '".$board_list["hero_idx"]."' AND gubun='etc' ORDER by hero_idx ASC ";
	$etc_res = sql($etc_sql);
	
}

//20180831 �ش� ü���  Ÿ��Ʋ �� �� �׸� ����
$temp_idx = "1288";

//210209 �������� ������ ����
$survey_cnt = 0;
$sql_cnt_survey = " SELECT count(*) cnt FROM mission_survey WHERE mission_idx = '".$out_row["hero_idx"]."' ";
$sql_cnt_res = sql($sql_cnt_survey);
$sql_cnt_rs = mysql_fetch_assoc($sql_cnt_res);
$survey_cnt = $sql_cnt_rs["cnt"];

$sql_survey  = " SELECT s.hero_idx, s.title, s.cont, s.image_cont, s.questionType ";
$sql_survey .= " , s.necessary, s.op1, s.op2 , s.op3 , s.op4 , s.op5 ";
$sql_survey .= " , s.op6 ,s.op7 ,s.op8 ,s.op9 ,s.op10 ";
$sql_survey .= " , s.op11 ,s.op12 ,s.op13 ,s.op14 ,s.op15 ";
$sql_survey .= " , s.op16 ,s.op17 ,s.op18 ,s.op19 ,s.op20 ";
$sql_survey .= " , a.answer ";
$sql_survey .= " FROM mission_survey s LEFT JOIN mission_survey_answer a ON s.hero_idx = a.survey_idx AND a.mission_review_idx = '".$_GET['hero_idx']."' ";
$sql_survey .= " WHERE s.mission_idx = '".$_GET['idx']."'  ORDER BY s.order_num ASC ";

$rs_survey = sql($sql_survey);

//����������
$search_ftc_naver = $out_row["hero_ftc_naver"];
$search_ftc_naver = preg_replace("/\s+/","",$search_ftc_naver);
$search_ftc_naver = strtolower($search_ftc_naver);
$search_ftc_naver = urlEncode($search_ftc_naver);

$search_ftc_insta = $out_row["hero_ftc_insta"];
$search_ftc_insta = preg_replace("/\s+/","",$search_ftc_insta);
$search_ftc_insta = strtolower($search_ftc_insta);
$search_ftc_insta = urlEncode($search_ftc_insta);

######################################################################################################################################################
if(!strcmp($_GET['type'], 'edit')){
	unset($_POST["hero_blog_00"]);
	unset($_POST["hero_blog_01"]);
	unset($_POST["hero_blog_02"]);
	unset($_POST["hero_blog_03"]);
	unset($_POST["hero_blog_04"]);
	unset($_POST["hero_blog_06"]);
	//�ҹ������϶� �ٸ� ���μ��� Ž
	if($mission_board_type) {
			$url = array();
			$gubun = array();
			$member_check = array();
			
			if($_POST["naver_url"]) {
				$url[] = $_POST["naver_url"];
				$gubun[] = "naver";
				$member_check[] = $_POST["naver_member_check"];
				$admin_check[] = !$_POST["naver_admin_check"] ? "N":$_POST["naver_admin_check"];
			}
			
			
			if($_POST["insta_url"]) {
				$url[] = $_POST["insta_url"];
				$gubun[] = "insta";
				$member_check[] = $_POST["insta_member_check"];
				$admin_check[] = !$_POST["insta_admin_check"] ? "N":$_POST["insta_admin_check"];
				
			}
			
			$movie_member_check_idx = 1;
			foreach($_POST["movie_url"] as $val) {
				if($val) {
					$url[] = $val;
					$gubun[] = "movie";
					$member_check[] = $_POST["movie_member_check".$movie_member_check_idx];
					$admin_check[] = "N";
				}
				$movie_member_check_idx++;
			}
			
			$cafe_member_check_idx = 1;
			foreach($_POST["cafe_url"] as $val) {
				if($val) {
					$url[] = $val;
					$gubun[] = "cafe";
					$member_check[] = $_POST["cafe_member_check".$cafe_member_check_idx];
					$admin_check[] = "N";
				}
				$cafe_member_check_idx++;
			}
			
			$etc_member_check_idx = 1;
			foreach($_POST["etc_url"] as $val) {
				if($val) {
					$url[] = $val;
					$gubun[] = "etc";
					$member_check[] = $_POST["etc_member_check".$etc_member_check_idx];
					$admin_check[] = "N";
				}
				$etc_member_check_idx++;
			}
		
			$hero_code = $_POST['hero_code'];
			$hero_old_idx = $_POST['hero_old_idx'];
			$hero_table = $_POST['hero_table'];
			$hero_id = $_POST['hero_id'];
			$hero_name = $_POST['hero_name'];
			$hero_new_name = $_POST['hero_new_name'];
			$hero_nick = $_POST['hero_nick'];
			$hero_hp_01 = $_POST['hero_hp_01'];
			$hero_hp_02 = $_POST['hero_hp_02'];
			$hero_hp_03 = $_POST['hero_hp_03'];
			$hero_ip = $_POST['hero_ip'];
			$hero_03 = $_POST['hero_03'];
			$hero_address_01 = $_POST['hero_address_01'];
			$hero_address_02 = $_POST['hero_address_02'];
			$hero_address_03 = $_POST['hero_address_03'];
			$hero_superpass = $_POST['hero_superpass'];
			$hero_agree = $_POST['hero_agree'];
			$hero_title = $_POST['hero_title'];
			$hero_review = $_POST['hero_review'];
			$hero_group = $_POST['hero_group'];
			$hero_01 = $_POST['hero_01'];
			$hero_04 = $_POST['hero_04'];
			$hero_thumb = $_POST['hero_thumb'];
			$hero_board_idx = $_POST['hero_board_idx'];
			
			$sql = "UPDATE mission_review SET hero_hp_01 = '".$hero_hp_01."',  hero_hp_02 = '".$hero_hp_02."', hero_hp_03 = '".$hero_hp_03."'";
			$sql .= ", hero_write_date = now(), hero_03= '".$hero_03."', hero_address_01='".$hero_address_01."', hero_address_02='".$hero_address_02."', hero_address_03='".$hero_address_03."'";
			$sql .= "WHERE hero_idx=".$_GET['hero_idx']."";
			$mission_review_pf = mysql_query($sql);
			
			if(!$mission_review_pf){
				logging_error($temp_nick, $board."-STEP_01_04", $full_today);
				error_historyBack("");
				exit;
			}
			
			$sql  = " UPDATE board SET hero_title = '".$hero_title."',  hero_04 = '".$hero_04."', hero_thumb = '".$hero_thumb."' ";
			$sql .= " WHERE hero_idx=".$hero_board_idx."";
			$mission_review_pf = mysql_query($sql);
			if(!$mission_review_pf){
				
				logging_error($temp_nick, $board."-STEP_01_04", $full_today);
				error_historyBack("");
				exit;
				
			}
			
			$del_mission_url_sql = " DELETE FROM mission_url WHERE board_hero_idx = '".$hero_board_idx."' ";
			sql($del_mission_url_sql);
			
			//SNS(�������) ���
			for($i=0; $i<count($url); $i++) {
				$gubun_val = $gubun[$i];
				$url_val = $url[$i];
				$member_check_val = $member_check[$i];
				$admin_check_val = $admin_check[$i];
			
				$url_sql  = " INSERT INTO mission_url (board_hero_idx, gubun, url, member_check, admin_check) VALUES ";
				$url_sql .= " ('".$hero_board_idx."','".$gubun_val."','".$url_val."','".$member_check_val."','".$admin_check_val."') ";
				sql($url_sql);
			}
			
	} else {
		$count = 0;
		foreach($_POST as $post_key => $post_val) {
			if($post_key != "survey_idx" && $post_key != "answer_idx" && strpos($post_key, "answer_") === false) { //�������� ���� ����, ī��Ʈ
				$count++;
			}
		}
		
		$data_i = '1';
		foreach($_POST as $post_key => $post_val) {
			if($post_key != "survey_idx" && $post_key != "answer_idx" && strpos($post_key, "answer_") === false) { //�������� ���� ����
	    		if(!strcmp($count, $data_i)){
	        		$comma = '';
	    		}else{
	        		$comma = ', ';
	   			}
	    		$sql_one_update .= $post_key.'=\''.$_POST[$post_key].'\''.$comma;
				$data_i++;
			}
		}
		
		$sql = 'UPDATE mission_review SET '.$sql_one_update.' WHERE hero_idx = \''.$_GET['hero_idx'].'\';'.PHP_EOL;
		$mission_review_pf = mysql_query($sql);
		if(!$mission_review_pf){
			
			logging_error($temp_nick, $board."-STEP_01_04", $full_today);
			error_historyBack("");
			exit;
		}
	}
	
	//�������� ����
	$survey_idx = $_POST["survey_idx"];
	if(count($survey_idx) > 0) {
		for($i = 0; $i < count($survey_idx); $i++) {
				
			$answer_arr = $_POST["answer_".$survey_idx[$i]];
			$answer = "";
			if(count($answer_arr) > 0) {
				for($k = 0; $k < count($answer_arr); $k++) {
					if($k > 0) $answer .= ",";
					$answer .= $answer_arr[$k];
				}
			} else {
				$answer = $answer_arr[0];
			}
			
			$sql_survey_ins_check = " SELECT count(*) cnt FROM mission_survey_answer WHERE mission_review_idx = '".$_GET['hero_idx']."' AND survey_idx = '".$survey_idx[$i]."' ";
			$rs_ins_check = @mysql_query($sql_survey_ins_check);
			$row_ins_check = mysql_fetch_assoc($rs_ins_check);
			
			if($row_ins_check["cnt"] > 0) {
				$sql_survey = " UPDATE mission_survey_answer SET answer = '".$answer."' , hero_today = now() WHERE mission_review_idx = '".$_GET['hero_idx']."' AND survey_idx = '".$survey_idx[$i]."' ";
			} else {
				$sql_survey = " INSERT into mission_survey_answer (mission_review_idx, survey_idx, answer, hero_code) VALUES ('".$_GET['hero_idx']."','".$survey_idx[$i]."','".$answer."','".$_SESSION["temp_code"]."') ";
			}
			@mysql_query($sql_survey);
		}		
	}
	
	msg('���� �Ǿ����ϴ�.','location.href="'.PATH_HOME.'?board='.$_GET['board'].'&view=step_02&idx='.$_GET['idx'].'"');
	EXIT;
}
?>
<script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>
<script src="/js/daumAddressApi.js"></script>
<script type="text/javascript">
    function go_submit(form) {
    	var expUrl = /^http[s]?\:\/\//i; //url üũ
        var new_name = form.hero_new_name;
        var hero_03 		= $('.hero_03');
        var address_01 = form.hero_address_01;
        var address_02 = form.hero_address_02;
        var hp_01 = form.hero_hp_01;
        var hp_02 = form.hero_hp_02;
        var hp_03 = form.hero_hp_03;
		var thumb = form.hero_thumb;
		var board_title = form.hero_title;
		var hero_04	= form.hero_04;
        var ft = 0;

        var hero_question_url_check = "<?=$out_row["hero_question_url_check"]?>"; //URL �ʼ� �� üũ
        var hero_type = "<?=$out_row["hero_type"]?>";
		var hero_blog = "";

		var mission_board_type = false;
		if(hero_type == "2" || hero_type == "10") {
			mission_board_type = true;
		}
		
		//URL �ʼ��� üũ �߰�
		if(mission_board_type == false) {
			if(hero_question_url_check == "1") {
				if(!$("input[name='hero_blog_00']").val()) {
					alert("���̹� ��α� URL�� �Է��� �ּ���.");
					$("input[name='hero_blog_00']").focus();
					return false;
				}
			} else if(hero_question_url_check == "2") {
				if(!$("input[name='hero_blog_04']").val()) {
					alert("name URL�� �Է��� �ּ���.");
					$("input[nam='hero_blog_04']").focus();
					return false;
				}
			} else if(hero_question_url_check == "3") {
				if(!$("input[name='hero_blog_00']").val() && !$("input[name='hero_blog_04']").val()) {
					alert("���̹� ��α�/�ν�Ÿ�׷� URL ��  �Ѱ��� URL�� �ʼ��� �Է��ϼž� �մϴ�.");
					$("input[name='hero_blog_00']").focus();
					return false;
				}
			} else if(hero_question_url_check == "4") {
				if(!$("input[name='hero_blog_00']").val() || !$("input[name='hero_blog_04']").val()) {
					alert("���̹� ��α�, �ν�Ÿ�׷� URL�� �ʼ��� �Է��ϼž� �մϴ�.");
					$("input[name='hero_blog_00']").focus();
					return false;
				}
			} else if(hero_question_url_check == "5") {
				if(!$("input[name='hero_blog_03']").val()) {
					alert("���� ä�� URL�� �Է��� �ּ���.");
					$("input[nam='hero_blog_03']").focus();
					return false;
				}
			} else if(hero_question_url_check == "6") {
				if(!$("input[name='hero_blog_00']").val() && !$("input[name='hero_blog_04']").val() && !$("input[name='hero_blog_03']").val()) {
					alert("���̹� ��α�/�ν�Ÿ�׷�/���� ä�� URL �� �Ѱ��� URL�� �ʼ��� �Է��ϼž� �մϴ�.");
					$("input[name='hero_blog_00']").focus();
					return false;
				}
			}
		}

		var val_chk = true;

		$('.hero_blog').each(function(index) {
			blog_value = ""
			if(this.name == "hero_blog_00") {
				blog_value = "https://blog.naver.com/" + this.value;
			} else if(this.name == "hero_blog_04") {
				blog_value = "https://www.instagram.com/" + this.value;
			} else {
    			if(!expUrl.test(this.value) && this.value) {
    				alert("SNS URL http:// �Ǵ� https:// �ʼ��� �Է��� �ʿ��մϴ�." + this.name);
    				this.focus();
    				val_chk = false;
    				return false;
    			} else {
    				blog_value = this.value
    			}
			}
	
			if(index == 0) hero_blog += blog_value;
			else hero_blog += ","+blog_value;
		});
			
		if(!val_chk) return false;
		
		hero_blog = $.trim(hero_blog);
		$("#hero_representative_blog").val(hero_blog);

		
			
		hero_03.each(function( index ) {
	        if($(this).val() == ""){
		        alert("��û�ʼ������� �Է����ּ���.");
	            $(this).css('border','1px solid red');
	            $(this).focus();
	            ft = 1;
	            return false;
	            
	        }else{
	        	$(this).css('border','1px solid #e4e4e4');
	        }
		});

		var surveyCheck = true;
		$(".survey").each(function(index, item){
			var _textarea = $(this).find("textarea");
			var _checkbox = $(this).find("input[type='checkbox']:checked");
			var _checkbox_necessary = $(this).find("input[type='checkbox']");
			var _radio = $(this).find("input[type='radio']:checked");
			var _radio_necessary = $(this).find("input[type='radio']");
			if(!_textarea.val() && _textarea.attr("title")) {
				alert("�ʼ����� ������� ü��� ��û�� �Ұ��մϴ�.\n"+_textarea.attr("title")+"�� Ȯ���� �ּ���");
				_textarea.focus();
				surveyCheck = false;
				return false;
			}

			if(_checkbox_necessary.attr("title") && !_checkbox.val()) {
				alert("�ʼ����� ������� ü��� ��û�� �Ұ��մϴ�.\n"+_checkbox_necessary.attr("title")+"�� Ȯ���� �ּ���");
				_checkbox.focus();
				surveyCheck = false;
				return false;
			}

			if(_radio_necessary.attr("title") && !_radio.val()) {
				alert("�ʼ����� ������� ü��� ��û�� �Ұ��մϴ�.\n"+_radio_necessary.attr("title")+"�� Ȯ���� �ּ���");
				_radio.focus();
				surveyCheck = false;
				return false;
			}
		})
		
		if(!surveyCheck) return;
		
		<? if($mission_board_type){ ?>
			if(board_title.value == "") {
				alert('������ �Է����ּ���.');
				board_title.style.border = '1px solid red';
				board_title.focus();
				return false;
			}
	
			if(thumb.value == ""){
	            alert("��ǥ �̹����� ������ּ���.");
	            return false;
	        }else{
	        	thumb.style.border = '';
	        }
	        
			<? if(strpos($out_row["hero_question_url_list"],"��α�") !== false) { ?>
				if(!$("input[name='naver_url']").val()) {
					alert("���̹� ��α� URL�� �Է��� �ּ���.");
					$("input[name='naver_url']").focus();
					return;
				}	
			<? } ?>
			if($("input[name='naver_url']").val()) {
				if(!expUrl.test($("input[name='naver_url']").val())) {
					alert("���̹� ��α� URL http:// �Ǵ� https:// �ʼ��� �Է��� �ʿ��մϴ�.");
					$("input[name='naver_url']").focus();
					return;
				}

				<? if($out_row["hero_ftc"] == "1") {?>
				if($("input[name='naver_admin_check']").val() != "Y") {
					alert("���̹� ��α� ������ ���� Ȯ�� �� ������ �ּ���.");
					return;
				}
				<? } ?>
	
				if($("input:radio[name='naver_member_check']:checked").val() != "Y") {
					alert("���̹� ��α� �����ŷ�����ȸ ���� �ۼ��� �������ּ���.");
					return;
				}
			}
	
			<? if(strpos($out_row["hero_question_url_list"],"�ν�Ÿ�׷�") !== false) { ?>
				if(!$("input[name='insta_url']").val()) {
					alert("�ν�Ÿ�׷�  URL�� �Է��� �ּ���.");
					$("input[name='insta_url']").focus();
					return;
				}	
			<? } ?>
	
			if($("input[name='insta_url']").val()) {
				if(!expUrl.test($("input[name='insta_url']").val())) {
					alert("�ν�Ÿ�׷� URL http:// �Ǵ� https:// �ʼ��� �Է��� �ʿ��մϴ�.");
					return;
				}

				<? if($out_row["hero_ftc"] == "1") {?>
				if($("input[name='insta_admin_check']").val() != "Y") {
					alert("�ν�Ÿ�׷� ������ ���� Ȯ�� �� ������ �ּ���.");
					return;
				}
				<? } ?>
	
				if($("input:radio[name='insta_member_check']:checked").val() != "Y") {
					alert("�ν�Ÿ�׷� �����ŷ�����ȸ ���� �ۼ��� �������ּ���.");
					return;
				}
			}
	
				<? if($_GET ['board'] == 'group_04_27') { ?>
					var movieUrlCheck = true;
					var movieMemberCheck = true;
			       	$("input[name='movie_url[]']").each(function(i){
			           	if($(this).val()) {
			           		if(!expUrl.test($(this).val())) {
				           		alert("�ı�(����) URL http:// �Ǵ� https:// �ʼ��� �Է��� �ʿ��մϴ�.");
				           		movieUrlCheck = false;
								return false;
			           		}
			
			           		if($(this).parent(".ui_url").find("input[type=radio]:checked").val() != "Y") {
			                    alert("�ı�(����) �����ŷ�����ȸ ���� �ۼ��� �������ּ���.")
			             	   movieMemberCheck = false;
			             	   return false;
			                }
			            }
			        })
			        if(!movieUrlCheck) return;
			        if(!movieMemberCheck) return;
		        <? } ?>
		
		        var cafeUrlCheck = true;
				var cafeMemberCheck = true;
		       	$("input[name='cafe_url[]']").each(function(i){
		           	if($(this).val()) {
		           		if(!expUrl.test($(this).val())) {
			           		alert("ī�� URL http:// �Ǵ� https:// �ʼ��� �Է��� �ʿ��մϴ�.");
			           		cafeUrlCheck = false;
							return false;
		           		}
		
		           		if($(this).parent(".ui_url").find("input[type=radio]:checked").val() != "Y") {
		                    alert("ī�� �����ŷ�����ȸ ���� �ۼ��� �������ּ���.")
		             	   cafeMemberCheck = false;
		             	   return false;
		                }
		            }
		        })
		        if(!cafeUrlCheck) return;
		        if(!cafeMemberCheck) return;
		
		        var etcUrlCheck = true;
				var etcMemberCheck = true;
		       	$("input[name='etc_url[]']").each(function(i){
		           	if($(this).val()) {
		           		if(!expUrl.test($(this).val())) {
			           		alert("��Ÿ URL http:// �Ǵ� https:// �ʼ��� �Է��� �ʿ��մϴ�.");
			           		etcUrlCheck = false;
							return false;
		           		}
		
		           		if($(this).parent(".ui_url").find("input[type=radio]:checked").val() != "Y") {
		                    alert("��Ÿ �����ŷ�����ȸ ���� �ۼ��� �������ּ���.")
		             	   etcMemberCheck = false;
		             	   return false;
		                }
		            }
		        })
		        if(!etcUrlCheck) return;
		        if(!etcMemberCheck) return;
		<? } //�ҹ����� ?>

		if(ft==1){
			return false;
		}
        if(new_name.value == ""){
            alert("�����ôº� �̸��� �Է����ּ���.");
            new_name.style.border = '1px solid red';
            new_name.focus();
            return false;
        }else{
            new_name.style.border = '1px solid #e4e4e4';
        }
        if(address_01.value == ""){
            alert("����� �ּ� �Է����ּ���.");
            address_01.style.border = '1px solid red';
            address_01.focus();
            return false;
        }else{
            address_01.style.border = '1px solid #e4e4e4';
        }
        if(address_02.value == ""){
            alert("����� �ּ� �Է����ּ���.");
            address_02.style.border = '1px solid red';
            address_02.focus();
            return false;
        }else{
            address_02.style.border = '1px solid #e4e4e4';
        }
        if(hp_01.value == ""){
            alert("����ó�� �Է����ּ���.");
            hp_01.style.border = '1px solid red';
            hp_01.focus();
            return false;
        }else{
            hp_01.style.border = '1px solid #e4e4e4';
        }
        if(hp_02.value == ""){
            alert("����ó�� �Է����ּ���.");
            hp_02.style.border = '1px solid red';
            hp_02.focus();
            return false;
        }else{
            hp_02.style.border = '1px solid #e4e4e4';
        }
        if(hp_03.value == ""){
            alert("����ó�� �Է����ּ���.");
            hp_03.style.border = '1px solid red';
            hp_03.focus();
            return false;
        }else{
            hp_03.style.border = '1px solid #e4e4e4';
        }

		form.submit();
        return true;
	}
</script>

    <div class="contents"><p style="font-size:14px;margin:10px 0 5px 10px;"><span class="titleLine" style="line-height:21px;">l</span>ü��� ��û��</p>
        <form name="form_next" action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post" enctype="multipart/form-data" onsubmit="return false;">
        
        <input type="hidden" name="hero_03" id="hero_03" value="">
        <input type="hidden" name="hero_multiple" id="hero_multiple" value="">
        <input type="hidden" name="hero_single" id="hero_single" value=""> 
        <input type="hidden" name="hero_01" id="hero_representative_blog" value="" />
        <? if($mission_board_type) { ?>
        	<input type="hidden" name="hero_board_idx" id="hero_board_idx" value="<?=$board_list['hero_idx']?>"> 
            <input type="hidden" name="hero_type" id="hero_type" value="<?=$out_row['hero_type']?>"> 
        <? } ?>
        
        <div class="spm" style="line-height:1px;"> <img src="../image/mission/spm_infobg_1.gif" alt="top" /> </div>
            <div class="spm_txt spm_step2">
                <?php
           		$number=1;
           		//�ҹ����� �ƴҰ��
           		if($mission_board_type == false && $out_row["hero_question_url_yn"] != "N"){
            	?>
					<dl>
	                	<dt><span class="question_num">0<? echo $number++;?></span></dt>
						<? 
						if($_GET['idx'] != $temp_idx) {?>
	                	<dd>
	                		<ul>
		                	<li class="c_orange">URL�� �Է����ּ���.<br/>
		                		<? if($out_row['hero_question_url_check'] == "1") {?>
									<p class=txt_emphasis_12>* ���̹� ��α� URL�� �ʼ��� �Է��ϼž� �մϴ�.</p>
								<? } else if($out_row['hero_question_url_check'] == "2") {?>
									<p class="txt_emphasis_12">* �ν�Ÿ�׷� URL�� �ʼ��� �Է��ϼž� �մϴ�.</p>
								<? } else if($out_row['hero_question_url_check'] == "3") {?>
									<p class="txt_emphasis_12">* ���̹� ��α�/�ν�Ÿ�׷� URL ��  �Ѱ��� URL�� �ʼ��� �Է��ϼž� �մϴ�.</p>
								<? } else if($out_row['hero_question_url_check'] == "4") {?>
									<p class="txt_emphasis_12">* ���̹� ��α�, �ν�Ÿ�׷� URL�� �ʼ��� �Է��ϼž� �մϴ�.</p>
								<? } else if($out_row['hero_question_url_check'] == "5") {?>
									<p class="txt_emphasis_12">* ���� ä��(��Ʃ��, ���̹�TV, ƽ��, ��Ÿ ��) URL�� �ʼ��� �Է��ϼž� �մϴ�.</p>
								<? } else if($out_row['hero_question_url_check'] == "6") {?>
									<p class="txt_emphasis_12">* ���̹� ��α�/�ν�Ÿ�׷�/���� ä��(��Ʃ��, ���̹�TV, ƽ��, ��Ÿ ��) URL �� �Ѱ��� URL�� �ʼ��� �Է��ϼž� �մϴ�.</p>
								<? } ?>
                            	<? 
                            		$hero_question_url_list = explode("/////",$out_row['hero_question_url_list']);
									$blog_url = explode("," ,$edit_list['hero_01']);
									for($i=0; $i<count($blog_url); $i++) {
										switch ($hero_question_url_list[$i]) {
											case "��α�":
												$blog_id = "hero_blog_00";
												?>
                									<span class="txt_url"><?=$hero_question_url_list[$i]=="��α�" ? "���̹� ��α�":$hero_question_url_list[$i]?> URL :</span>
                	                            	<span class="txt_url" style="width:135px;">https://blog.naver.com/</span><input type="text" id="hero_blog_0<?=$i?>" name="<?=$blog_id?>" class="hero_blog_cnt hero_blog" value="<?=str_replace("https://blog.naver.com/", "", $blog_url[$i]);?>" placeholder="���̹� �Ǵ� ��α� ID�� �Է����ּ���." style="width:240px; margin:5px;"><br/>
                                                <?
												break;
												
											case "�ν�Ÿ�׷�":
												$blog_id = "hero_blog_04";
												?>
                									<span class="txt_url"><?=$hero_question_url_list[$i]=="��α�" ? "���̹� ��α�":$hero_question_url_list[$i]?> URL :</span>
                	                            	<span class="txt_url" style="width:165px;">https://www.instagram.com/</span><input type="text" id="hero_blog_0<?=$i?>" name="<?=$blog_id?>" class="hero_blog_cnt hero_blog" value="<?=str_replace("https://www.instagram.com/", "", $blog_url[$i]);?>" placeholder="�ν�Ÿ�׷� ID�� �Է����ּ���." style="width:210px; margin:5px;"><br/>
                                                <?
												break;
												
											case "���̽���":
												$blog_id = "hero_blog_01";
												?>
                									<span class="txt_url"><?=$hero_question_url_list[$i]=="��α�" ? "���̹� ��α�":$hero_question_url_list[$i]?> URL :</span>
                	                            	<input type="text" id="hero_blog_0<?=$i?>" name="<?=$blog_id?>" class="hero_blog_cnt hero_blog" value="<?=$blog_url[$i]?>" placeholder="SNS URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)" style="width:400px; margin:5px;"><br/>
                                                <?
												break;
												
											case "Ʈ����":
												$blog_id = "hero_blog_02";
												?>
                									<span class="txt_url"><?=$hero_question_url_list[$i]=="��α�" ? "���̹� ��α�":$hero_question_url_list[$i]?> URL :</span>
                	                            	<input type="text" id="hero_blog_0<?=$i?>" name="<?=$blog_id?>" class="hero_blog_cnt hero_blog" value="<?=$blog_url[$i]?>" placeholder="SNS URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)" style="width:400px; margin:5px;"><br/>
                                                <?
												break;
												
											case "īī�����丮":
												$blog_id = "hero_blog_06";
												?>
                									<span class="txt_url"><?=$hero_question_url_list[$i]=="��α�" ? "���̹� ��α�":$hero_question_url_list[$i]?> URL :</span>
                	                            	<input type="text" id="hero_blog_0<?=$i?>" name="<?=$blog_id?>" class="hero_blog_cnt hero_blog" value="<?=$blog_url[$i]?>" placeholder="SNS URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)" style="width:400px; margin:5px;"><br/>
                                                <?
												break;
												
											case "�� ��":
												$blog_id = "hero_blog_05";
												?>
                									<span class="txt_url"><?=$hero_question_url_list[$i]=="��α�" ? "���̹� ��α�":$hero_question_url_list[$i]?> URL :</span>
                	                            	<input type="text" id="hero_blog_0<?=$i?>" name="<?=$blog_id?>" class="hero_blog_cnt hero_blog" value="<?=$blog_url[$i]?>" placeholder="SNS URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)" style="width:400px; margin:5px;"><br/>
                                                <?
												break;
												
											case "���� ä��":
												$blog_id = "hero_blog_03";
												?>
                									<span class="txt_url"><?=$hero_question_url_list[$i]=="��α�" ? "���̹� ��α�":$hero_question_url_list[$i]?> URL :</span>
                	                            	<input type="text" id="hero_blog_0<?=$i?>" name="<?=$blog_id?>" class="hero_blog_cnt hero_blog" value="<?=$blog_url[$i]?>" placeholder="SNS URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)" style="width:400px; margin:5px;"><br/>
                                                <?
												break;
										}
								 } ?>
                            </li>
		                	</ul>
	                	</dd>
	                	<? } else { ?>
	                	<dd>
	                		<ul>
		                		<li class="c_orange">�� �Ʒ� ������ �Է��� �ּ���.</li>
		                	</ul>
		                </dd>
		                	
	                	<? } ?>
               		</dl>
               	<? } ?>
                <? if($survey_cnt > 0) {?>
                <? if($number > 1) { ?>
                	<div class="bddot"></div>
                <? } ?>
                <dl>
                	<dt><span class="question_num">0<? echo $number++;?></span></dt>
                    <dd>						
						<?
						$survey_num = 1;
						while($row_survey = mysql_fetch_assoc($rs_survey)){	
						?>
						<input type="hidden" name="survey_idx[]" value="<?=$row_survey['hero_idx']?>">
						<div class="survey">
							<p class="title">
								<?if($row_survey["necessary"] == "Y") {?><span class="txt_emphasis">*</span><?}?>
								<span class="number"><?=$survey_num?>)</span>
								<?=$row_survey["title"]?>
							</p>
							
							<div class="exBox">
								<p><?=nl2br($row_survey["cont"])?></p>
								<? if($row_survey["image_cont"]) {?>
									<p class="img"><img src="/user/survey/<?=$out_row["hero_idx"]?>/<?=$row_survey["image_cont"]?>" /></p>
								<? } ?>
							</div>
							
							<div class="answerBox">
								<? if($row_survey["questionType"] == "1") {?>
								<textarea name="answer_<?=$row_survey['hero_idx']?>[]" <?if($row_survey["necessary"] == "Y") {?>title="<?=$survey_num?>����"<?}?>><?=$row_survey["answer"]?></textarea>
								<? } else if($row_survey["questionType"] == "2") {?>
									<? for($z=1; $z<=20; $z++) {?>
										<? if($row_survey["op".$z]) { 
											if($z > 1) echo "<br/>";
										?>
										<input type="radio" name="answer_<?=$row_survey['hero_idx']?>[]" id="answer_<?=$survey_num?>_<?=$z?>" value="<?=$row_survey["op".$z]?>" <?=$row_survey["op".$z] == $row_survey["answer"] ? "checked":"";?>  <?if($row_survey["necessary"] == "Y") {?>title="<?=$survey_num?>����"<?}?> /> <label for="answer_<?=$survey_num?>_<?=$z?>"><?=$row_survey["op".$z]?></label>
										<? } ?>
									<? } ?>
								<? } else if($row_survey["questionType"] == "3") {?>
									<? for($z=1; $z<=20; $z++) {
										$checkbox_checked = false; 
									?>
										<? if($row_survey["op".$z]) { 
											if($z > 1) echo "<br/>";
											$answer_arr = explode(",",$row_survey["answer"]);
											if(count($answer_arr) > 0) {
												for($a = 0; $a < count($answer_arr); $a++) {
													if($answer_arr[$a] == $row_survey["op".$z]) $checkbox_checked = true;
												}
											}
										?>
										<input type="checkbox" name="answer_<?=$row_survey['hero_idx']?>[]" id="answer_<?=$survey_num?>_<?=$z?>" value="<?=$row_survey["op".$z]?>" <?=$checkbox_checked ? "checked":""?> <?if($row_survey["necessary"] == "Y") {?>title="<?=$survey_num?>����"<?}?>/> <label for="answer_<?=$survey_num?>_<?=$z?>"><?=$row_survey["op".$z]?></label>
										<? } ?>
									<? } ?>	
								<? } ?>
							</div>
						</div>
						<? 
							$survey_num++;
							} 
						?>
					</dd>
                </dl>
                <? } ?>
                
                 <? if($mission_board_type){?>
                 	<? if($number > 1) { ?>
	                <div class="bddot"></div>
	                <? } ?>
	                <dl>  
	                	<dt><span class="question_num">0<? echo $number++;?></span></dt>
						<dd>
							<p class="emphasisInfo"><span class="txt_emphasis">*</span>�� �ʼ� �Է� �׸��Դϴ�!!!</p>
	                        <table class="bbs_view tb_review_type">
	                            <colgroup>
	                                <col width="100px" />
	                                <col width="*" />
	                            </colgroup>
	                            <tr>
	                               <th><span class="txt_emphasis">*</span> ����</th>
	                                <td><input type="text" name="hero_title" id="hero_title" title="����" value="<?=$board_list['hero_title']?>" style="width:480px"/></td>
	                            </tr>
	                            <tr>
	                                <th>�ۼ���</th>
	                                <td><?=$board_list['hero_nick'];?></td>
	                            </tr>
	                            <tr>
	                                <th><span class="txt_emphasis">*</span> ��ǥ�̹���</th>
	                                <td>
	                                    <div id="present_image_area">
	                                    <? if($board_list['hero_thumb']){ ?>
	                                        <img src="<?=$board_list['hero_thumb']?>" style="width:200px;margin-top:10px;"><br/>
	                                    <? } ?>
	                                    </div>
	                                    <label for="write_hero_thumb" id="link" class="btnUpload">���� ���ε�</label>
	                                    <input type="hidden" id="hero_thumb" name="hero_thumb" value="<?=$board_list['hero_thumb']?>"/>
	                                    <span style="color:#ff0000">* 10MB ���Ϸ� ���ε��� �ּ���.</span>
	                                </td>
	                            </tr>
	                            <style>
								.url_plus{padding:2px 5px;border:1px solid #F90; background:#F90;color:#fff !important;margin:0 0 0 5px;}
								</style>
								<tr>
									<th><? if(strpos($out_row["hero_question_url_list"],"��α�") !== false) { ?>
											<span class="txt_emphasis">*</span>
										<? } ?>
										���̹� ��α�
									</th>
									<td>
										<input type="text" name="naver_url" placeholder="�ݵ�� ������ URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)" class="inputUrl2" value="<?=$naver_rs["url"]?>"/>
										<input type="hidden" name="naver_admin_check" id="naver_admin_check" value="<?=$naver_rs["admin_check"]?>"/>
										<? if($out_row["hero_ftc"] == "1") {?>
											<a href="javascript:;" onClick="fnAdminCheck('naver')" class="btnUrlCheck">����������Ȯ��</a> 	
											<p class="txt_url_check" id="txt_naver_url_check"></p>
										<? } ?>
										<dl class="urlAgreeBox urlAgreeBoxType2">
											<dt>�� �����ŷ�����ȸ ������ �ۼ��Ͽ����ϱ�?</dt>
											<dd><input type="radio" name="naver_member_check" id="naver_member_check_Y" value="Y" <?=$naver_rs["member_check"] == "Y" ? "checked":"";?>/><label for="naver_member_check_Y">��</label>
												<input type="radio" name="naver_member_check" id="naver_member_check_N" vlaue="N" <?=$naver_rs["member_check"] == "N" ? "checked":"";?>/><label for="naver_member_check_N">�ƴϿ�</label>
											</dd>
										</dl>
										<p class="txt_agree_info mgb5">
											�� �����ŷ�����ȸ�� ����õ���� � ���� ǥ�ñ��� �ɻ���ħ�� �Ǵ� �����ڻ�ŷ� ����� �Һ��ں�ȣ�� ���� �������� ���� �ʼ� �����������, �ۼ����� ���� ��� AK LOVER Ȱ���� �������� ���� �� �ֽ��ϴ�.
										</p>
									</td>
								</tr>
								<tr>
									<th>
										<? if(strpos($out_row["hero_question_url_list"],"�ν�Ÿ�׷�") !== false) { ?>
											<span class="txt_emphasis">*</span>
										<? } ?>
										�ν�Ÿ�׷�
									</th>
									<td>
										<input type="text" name="insta_url" placeholder="�ݵ�� ������ URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)" class="inputUrl2" value="<?=$insta_rs["url"]?>"/>
										<input type="hidden" name="insta_admin_check" id="insta_admin_check" value="<?=$insta_rs["admin_check"]?>"/>
										<? if($out_row["hero_ftc"] == "1") {?>
											<a href="javascript:;" onClick="fnAdminCheck('insta')" class="btnUrlCheck">����������Ȯ��</a> 	
											<p class="txt_url_check" id="txt_insta_url_check"></p>
										<? } ?>	
										<dl class="urlAgreeBox urlAgreeBoxType2">
											<dt>�� �����ŷ�����ȸ ������ �ۼ��Ͽ����ϱ�?</dt>
											<dd><input type="radio" name="insta_member_check" id="insta_member_check_Y" value="Y" <?=$insta_rs["member_check"] == "Y" ? "checked":"";?>/><label for="insta_member_check_Y">��</label>
												<input type="radio" name="insta_member_check" id="insta_member_check_N" value="N" <?=$insta_rs["member_check"] == "N" ? "checked":"";?>/><label for="insta_member_check_N">�ƴϿ�</label>
											</dd>
										</dl>
										<p class="txt_agree_info mgb5">
											�� �����ŷ�����ȸ�� ����õ���� � ���� ǥ�ñ��� �ɻ���ħ�� �Ǵ� �����ڻ�ŷ� ����� �Һ��ں�ȣ�� ���� �������� ���� �ʼ� �����������, �ۼ����� ���� ��� AK LOVER Ȱ���� �������� ���� �� �ֽ��ϴ�.
										</p>
									</td>
								</tr>
								<? if($_GET['board'] == 'group_04_27' || $out_row["hero_table"] == "group_04_27" ){ ?>
								<tr>
									<th>�ı�(����)</th>
									<td>
										<div class="ui_urlBox">
											<div class="ui_url">
												<input type="text" name="movie_url[]" placeholder="�ݵ�� ������ URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)" class="inputUrl4"/>
												<a href="javascript:;" onClick="fnUrl(this,'add')" class="btn_url_add">+</a> 	
												<dl class="urlAgreeBox urlAgreeBoxType2">
													<dt>�� �����ŷ�����ȸ ������ �ۼ��Ͽ����ϱ�?</dt>
													<dd><input type="radio" name="movie_member_check1" id="movie_member_check1_Y" value="Y"/><label for="movie_member_check1_Y">��</label>
														<input type="radio" name="movie_member_check1" id="movie_member_check2_N" value="N"/><label for="movie_member_check2_N">�ƴϿ�</label>
													</dd>
												</dl>
												<p class="txt_agree_info mgb5">
													�� �����ŷ�����ȸ�� ����õ���� � ���� ǥ�ñ��� �ɻ���ħ�� �Ǵ� �����ڻ�ŷ� ����� �Һ��ں�ȣ�� ���� �������� ���� �ʼ� �����������, �ۼ����� ���� ��� AK LOVER Ȱ���� �������� ���� �� �ֽ��ϴ�.
												</p>
											</div>
											<? 
											if($_GET["board"] == "group_04_27") {
												$k = 2;
												while($movie_list = mysql_fetch_assoc($movie_res)) {
											?>
												<div class="ui_url">
													<input type="text" name="movie_url[]" placeholder="�ݵ�� ������ URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)" class="inputUrl4" value="<?=$movie_list["url"]?>"/>
													<a href="javascript:;" onClick="fnUrl(this,'minus')" class="btn_url_minus">-</a> 	
													<dl class="urlAgreeBox urlAgreeBoxType2">
														<dt>�� �����ŷ�����ȸ ������ �ۼ��Ͽ����ϱ�?</dt>
														<dd><input type="radio" name="movie_member_check<?=$k?>" id="movie_member_check<?=$k?>_Y" value="Y" <?=$movie_list["member_check"] == "Y" ? "checked":"";?>/><label for="movie_member_check<?=$k?>_Y">��</label>
															<input type="radio" name="movie_member_check<?=$k?>" id="movie_member_check<?=$k?>_N" value="N" <?=$movie_list["member_check"] == "N" ? "checked":"";?>/><label for="movie_member_check<?=$k?>_N">�ƴϿ�</label>
														</dd>
													</dl>
													<p class="txt_agree_info mgb5">
														�� �����ŷ�����ȸ�� ����õ���� � ���� ǥ�ñ��� �ɻ���ħ�� �Ǵ� �����ڻ�ŷ� ����� �Һ��ں�ȣ�� ���� �������� ���� �ʼ� �����������, �ۼ����� ���� ��� AK LOVER Ȱ���� �������� ���� �� �ֽ��ϴ�.
													</p>
												</div>	
											<? 
												$k++;
												}
											}?>
										</div>
									</td>
								</tr>
								<? } ?>
								<tr>
									<th>ī��</th>
									<td>
										<div class="ui_urlBox">
											<div class="ui_url">
												<input type="text" name="cafe_url[]" placeholder="�ݵ�� ������ URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)" class="inputUrl4"/>
												<a href="javascript:;" onClick="fnUrl(this,'add')" class="btn_url_add">+</a> 	
												<dl class="urlAgreeBox urlAgreeBoxType2">
													<dt>�� �����ŷ�����ȸ ������ �ۼ��Ͽ����ϱ�?</dt>
													<dd><input type="radio" name="cafe_member_check1" id="cafe_member_check1_Y" value="Y"/><label for="cafe_member_check1_Y">��</label>
														<input type="radio" name="cafe_member_check1" id="cafe_member_check1_N" value="N"/><label for="cafe_member_check1_N">�ƴϿ�</label>
													</dd>
												</dl>
												<p class="txt_agree_info mgb5">
													�� �����ŷ�����ȸ�� ����õ���� � ���� ǥ�ñ��� �ɻ���ħ�� �Ǵ� �����ڻ�ŷ� ����� �Һ��ں�ȣ�� ���� �������� ���� �ʼ� �����������, �ۼ����� ���� ��� AK LOVER Ȱ���� �������� ���� �� �ֽ��ϴ�.
												</p>
											</div>
											<? 
											$k = 2;
											while($cafe_list = mysql_fetch_assoc($cafe_res)) {
											?>
												<div class="ui_url">
													<input type="text" name="cafe_url[]" placeholder="�ݵ�� ������ URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)" class="inputUrl4" value="<?=$cafe_list["url"]?>"/>
													<a href="javascript:;" onClick="fnUrl(this,'minus')" class="btn_url_minus">-</a> 	
													<dl class="urlAgreeBox urlAgreeBoxType2">
														<dt>�� �����ŷ�����ȸ ������ �ۼ��Ͽ����ϱ�?</dt>
														<dd><input type="radio" name="cafe_member_check<?=$k?>" id="cafe_member_check<?=$k?>_Y" value="Y" <?=$cafe_list["member_check"] == "Y" ? "checked":"";?>/><label for="cafe_member_check<?=$k?>_Y">��</label>
															<input type="radio" name="cafe_member_check<?=$k?>" id="cafe_member_check<?=$k?>_N" value="N" <?=$cafe_list["member_check"] == "N" ? "checked":"";?>/><label for="cafe_member_check<?=$k?>_N">�ƴϿ�</label>
														</dd>
													</dl>
													<p class="txt_agree_info mgb5">
														�� �����ŷ�����ȸ�� ����õ���� � ���� ǥ�ñ��� �ɻ���ħ�� �Ǵ� �����ڻ�ŷ� ����� �Һ��ں�ȣ�� ���� �������� ���� �ʼ� �����������, �ۼ����� ���� ��� AK LOVER Ȱ���� �������� ���� �� �ֽ��ϴ�.
													</p>
												</div>	
											<? 
											$k++;
											}
											?>
										</div>
									</td>
								</tr> 
								<tr>
									<th>��Ÿ</th>
									<td>
										<div class="ui_urlBox">
											<div class="ui_url">
												<input type="text" name="etc_url[]" placeholder="�ݵ�� ������ URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)" class="inputUrl4"/>
												<a href="javascript:;" onClick="fnUrl(this,'add')" class="btn_url_add">+</a> 	
												<dl class="urlAgreeBox urlAgreeBoxType2">
													<dt>�� �����ŷ�����ȸ ������ �ۼ��Ͽ����ϱ�?</dt>
													<dd><input type="radio" name="etc_member_check1" id="etc_member_check1_Y" value="Y"/><label for="etc_member_check1_Y">��</label>
														<input type="radio" name="etc_member_check1" id="etc_member_check1_N" value="N"/><label for="etc_member_check1_N">�ƴϿ�</label>
													</dd>
												</dl>
												<p class="txt_agree_info mgb5">
													�� �����ŷ�����ȸ�� ����õ���� � ���� ǥ�ñ��� �ɻ���ħ�� �Ǵ� �����ڻ�ŷ� ����� �Һ��ں�ȣ�� ���� �������� ���� �ʼ� �����������, �ۼ����� ���� ��� AK LOVER Ȱ���� �������� ���� �� �ֽ��ϴ�.
												</p>
											</div>
											<? 
											$k = 2;
											while($etc_list = mysql_fetch_assoc($etc_res)) {
											?>
												<div class="ui_url">
													<input type="text" name="etc_url[]" placeholder="�ݵ�� ������ URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)" class="inputUrl4" value="<?=$etc_list["url"]?>"/>
													<a href="javascript:;" onClick="fnUrl(this,'minus')" class="btn_url_minus">-</a> 	
													<dl class="urlAgreeBox urlAgreeBoxType2">
														<dt>�� �����ŷ�����ȸ ������ �ۼ��Ͽ����ϱ�?</dt>
														<dd><input type="radio" name="etc_member_check<?=$k?>" id="etc_member_check<?=$k?>_Y" value="Y" <?=$etc_list["member_check"] == "Y" ? "checked":"";?>/><label for="etc_member_check<?=$k?>_Y">��</label>
															<input type="radio" name="etc_member_check<?=$k?>" id="etc_member_check<?=$k?>_N" value="N" <?=$etc_list["member_check"] == "N" ? "checked":"";?>/><label for="etc_member_check<?=$k?>_N">�ƴϿ�</label>
														</dd>
													</dl>
													<p class="txt_agree_info mgb5">
														�� �����ŷ�����ȸ�� ����õ���� � ���� ǥ�ñ��� �ɻ���ħ�� �Ǵ� �����ڻ�ŷ� ����� �Һ��ں�ȣ�� ���� �������� ���� �ʼ� �����������, �ۼ����� ���� ��� AK LOVER Ȱ���� �������� ���� �� �ֽ��ϴ�.
													</p>
												</div>	
											<? 
											$k++;
											}
											?>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<div class="infoBox">
											<p class="txt_info">
											�� AK LOVER���� ����Ǵ� ��� ü����� �����ŷ�����ȸ ǥ�ñ���� ��ħ�� ���� ��ǰ�� �����޾� �ı⸦ �ۼ��Ͻ� ���, �밡�� ���θ� ǥ���ϴ� ���� ������ ��Ģ���� �ϰ� �ֽ��ϴ�.<br/>
											<span class="txt_subInfo">
											�� ���̹� ��α�, �ν�Ÿ�׷� URL�� 1���� ��� �����ϸ�, �ı�(����), ī��, ��Ÿ URL�� �ִ� 5������ ����� �����մϴ�.<br/>
											�� ��Ÿ����  Ʈ����, īī�����丮, ���̽��� �� URL�� �Է��մϴ�.
											</span>
											</p>
										</div>
									</td>
								</tr>
	                        </table>
                        </dd>
                	</dl>

                <? } ?>

                <div class="bddot"></div>
                <dl>
                	<dt><span style="background-color:#686868;padding:10px;font-size:20px;font-weight:800;color:#feb007;border-radius:30px;margin-left:10px;">0<? echo $number++;?></span></dt>
                <dd>
                    <ul>
                    	<? if($out_row['hero_type'] != 8) { ?>
                        <li class="c_orange">���� ��ǰ�� ��� ���� �ּҸ� �Է����ּ���.</li>
                        <? } else { ?>
                        <li class="c_orange">����Ʈ ü��� ������ �����Ͻ� �޴��� ��ȣ�� �Է����ּ���.</li>
                        <? }?>
                        
                        <li><label for="">�����ôº�</label>
                            <input type="text" name="hero_new_name" id="hero_new_name" value="<?=$edit_list['hero_new_name']?>" style="width:186px;">
                        </li>
                        <? if($out_row['hero_type'] != 8) { ?>
                        <li>
                            <label for="">����� �ּ�</label>
                            <input type="text" name="hero_address_01" id="hero_address_01" value="<?=$edit_list['hero_address_01']?>" onclick="javascript:btnAddressGet()" readonly/>
                            <a href="javascript:btnAddressGet()"><img src="../image/member/btn_zipcode.gif" alt="�����ȣã��" /></a><br />
                            <label for=""></label>
                            <input type="text" name="hero_address_02" id="hero_address_02" value="<?=$edit_list['hero_address_02']?>"  style="width:467px" readonly/><br/>
                            <label for=""></label>
                            <input type="text" name="hero_address_03" id="hero_address_03" value="<?=$edit_list['hero_address_03']?>" style="width:467px; margin:5px 0 0 0;">
                        </li>
                        <? } else { ?>
            				<input type="hidden" name="hero_address_01" value="<?=$edit_list['hero_address_01'];?>"> 
                        	<input type="hidden" name="hero_address_02" value="<?=$edit_list['hero_address_02'];?>"> 
                        	<input type="hidden" name="hero_address_03" value="<?=$edit_list['hero_address_03'];?>"> 
        				<? }?>
                        <li><label for="">����ó</label>
                            <input type="text" name="hero_hp_01" id="hero_hp_01" value="<?=$edit_list['hero_hp_01'];?>" onKeyUp="if(this.value.length >= 3)hero_hp_02.focus();" maxlength="3" style="ime-mode:disabled;"/> - 
                            <input type="text" name="hero_hp_02" id="hero_hp_02" value="<?=$edit_list['hero_hp_02'];?>" onKeyUp="if(this.value.length >= 4)hero_hp_03.focus();" maxlength="4" style="ime-mode:disabled;"/> - 
                            <input type="text" name="hero_hp_03" id="hero_hp_03" value="<?=$edit_list['hero_hp_03'];?>" maxlength="4" style="ime-mode:disabled;"/>
                        </li>
                    </ul>
                </dd>
                </dl>
            <div class="clearfix"></div>
        </div>
        <div class="spm" style="line-height:1px;"> <img src="../image/mission/spm_infobg_3.gif" alt="top" /> </div>
        <div class="btn_group tc mt60">
        	<a href="javascript:;" class="btn_lover" onClick="go_submit(document.form_next)">�����ϱ�</a>
        </div>
    </form>
    </div>
</div>
<form action="/main/zip_thumb.php" id="write2_file_upload" enctype="multipart/form-data" method="post" >
    <input type="file" name="thumbImage" id="write_hero_thumb" title="�̹���" style="position: absolute; left: -9999em;"/>
</form>
<script src="/js/jquery.form.js"></script>
<script type="text/javascript">
var clipboard_naver = new Clipboard('.btn_clip_naver');
clipboard_naver.on('success', function(e) {
	alert("���̹���α� ������������ ���� �Ǿ����ϴ�.");
});

clipboard_naver.on('error', function(e) {
    console.log(e);
});

var clipboard_insta = new Clipboard('.btn_clip_insta');
clipboard_insta.on('success', function(e) {
	alert("�ν�Ÿ�׷� ������������ ���� �Ǿ����ϴ�.");
});

clipboard_insta.on('error', function(e) {
    console.log(e);
});

$(document).ready(function(){
	<? if($out_row["hero_ftc"]=="1") {?>
		$("input[name='naver_url']").on("keyup",function(){
			fnAdminCheckCancel("naver");
		})
                			
		$("input[name='insta_url']").on("keyup",function(){
			fnAdminCheckCancel("insta");
		})
	<? } ?>

	fnAdminCheckCancel = function(gubun) {
		if(gubun == "naver") {
			$("#naver_admin_check").val("N");
			$("#txt_naver_url_check").html("");
		} else if(gubun == "insta") {
			$("#insta_admin_check").val("N");
			$("#txt_insta_url_check").html("");
		}
	}

	fnAdminCheck = function(gubun) {
		var search_keyword = "";
                    		
		if(gubun == "naver") {
			var param = "mode=naver_url_check&naver_url="+$("input[name='naver_url']").val()+"&search_keyword=<?=$search_ftc_naver?>";
			if(!$("input[name='naver_url']").val()) {
				alert("���̹� ��α׸� �Է����ּ���.");
				$("input[name='naver_url']").focus();
				return;
			}
		} else if(gubun == "insta") {
			var param = "mode=insta_url_check&insta_url="+$("input[name='insta_url']").val()+"&search_keyword=<?=$search_ftc_insta?>";
			if(!$("input[name='insta_url']").val()) {
				alert("�ν�Ÿ�׷�  URL�� �Է����ּ���.");
				$("input[name='insta_url']").focus();
				return;
			}
		}
		
		$.ajax({
			url:"/main/sns_url_check.php"
			,data:param
			,type:"POST"
			,dataType:"html"
			,success:function(d){
				if(d=="success") {
					if(gubun == "naver") {
						$("#naver_admin_check").val("Y");
						$("#txt_naver_url_check").addClass("txt_success");
						$("#txt_naver_url_check").html("������������ Ȯ�εǾ����ϴ�.");
					} else if(gubun == "insta") {
						$("#insta_admin_check").val("Y");
						$("#txt_insta_url_check").addClass("txt_success");
						$("#txt_insta_url_check").html("������������ Ȯ�εǾ����ϴ�.");
					}
				} else {
					if(gubun == "naver") {
						var html  = "������ ���� ���ۼ��� �ı� ����� �Ұ��մϴ�.";
							html += "<br/>�ݵ��, �Ʒ� ���� �״�� ������ �ϴܿ� ���� ��Ź�帳�ϴ�.<br/>";
							html += '<span style="color:#000; line-height:24px;"><?=$out_row["hero_ftc_naver"]?> <a href="javascript:;" class="btn_copy btn_clip_naver" data-clipboard-text="<?=$out_row['hero_ftc_naver']?>">���������� �����ϱ�</a></span>';
						
						$("#naver_admin_check").val("N");
						$("#txt_naver_url_check").removeClass("txt_success");
						$("#txt_naver_url_check").html(html);
					} else if(gubun == "insta") {
						var html  = "������ ���� ���ۼ��� �ı� ����� �Ұ��մϴ�.";
							html += "<br/>�ݵ��, �Ʒ� ���� �״�� ������ ��ܿ� ���� ��Ź�帳�ϴ�.<br/>";
							html += '<span style="color:#000; line-height:24px;"><?=$out_row["hero_ftc_insta"]?> <a href="javascript:;" class="btn_copy btn_clip_insta" data-clipboard-text="<?=$out_row['hero_ftc_insta']?>">���������� �����ϱ�</a></span>';
						
						$("#insta_admin_check").val("N");
						$("#txt_insta_url_check").removeClass("txt_success");
						$("#txt_insta_url_check").html(html);
					}
				}
			},error:function(e) {
				console.log(e);
			}
		})
}

fnUrl = function(t,type) {
	if(type == "add"){
		var html = "<div class='ui_url'>"+$(t).parents(".ui_url").html()+"</div>";
		var ui_urlBox = $(t).parents(".ui_urlBox");
		var idx = ui_urlBox.children("div").length+1;
		html = html.replace("+","-");
		html = html.replace(/add/gi,"minus");
		html = html.replace(/member_check1/gi,"member_check"+idx);
		var ui_url_limit_ea = 5;
		if(ui_urlBox.children("div").length < ui_url_limit_ea) {
			ui_urlBox.append(html);
		} else {
			alert("�ִ� 5������ ��� �����մϴ�.");
			return;
		}
	} else if(type == "minus"){
		var ui_urlBox = $(t).parents(".ui_url");
		ui_urlBox.remove();
	}
}                			

$("#write_hero_thumb").change(function(){
	var file = this;
    var filename = $(this).val();
    var maxSize  = 10 * 1024 * 1024    //10MB
	var fileSize = 0;
	var browser=navigator.appName;

    var tf_extension = extension_check(filename,"image");

    if(tf_extension==false){
        $(this).val("");
        return false;
    }

	// �ͽ��÷η��� ���
	if (browser=="Microsoft Internet Explorer") {
		var oas = new ActiveXObject("Scripting.FileSystemObject");
		fileSize = oas.getFile( filename ).size;
	} else {
		fileSize = file.files[0].size;
	}

	if(maxSize < fileSize) {
		alert("�̹��� �뷮�ʰ��Դϴ�.\n10MB���Ϸ� ���ε带 ������ �ּ���.");
		return false;
	}

    var options=
    {
            success: function(data){
                if(data=='0'){
                    alert("�˼��մϴ�. �̹��� ���ε� �����Դϴ�. �ٽ� �õ����ּ���. ���� ������ �ݺ��� ��� �����Ϳ� �������ּ���.");
                    return false;
                }else{
                    $("#present_image_area").html("<img src='"+data+"' style='margin:10px 0;'/>");
                    data = trim(data);
                    $("#hero_thumb").val(data);
                }
            },beforeSend:function(){
                $('.img-loading').css('display','block');
            }
            ,complete:function(){
                $('.img-loading').css('display','none');
         
            },error:function(e){  
                alert("�˼��մϴ�. �̹��� ���ε� �����Դϴ�. �ٽ� �õ����ּ���. ���� ������ �ݺ��� ��� �����Ϳ� �������ּ���.");
                return false;
            } 
    };
    $('#write2_file_upload').ajaxForm(options).submit();
                
});

});
</script>
                        
