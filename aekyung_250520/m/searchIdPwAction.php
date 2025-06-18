<?
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once '../freebest/head.php';
include_once                                                        $_SERVER['DOCUMENT_ROOT'].'/freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';

if($_POST['type']!='id' && $_POST['type']!='pw' && $_POST['type']!='pw2' && $_POST['type']!='chgpw' && $_POST['type']!='sendAuth')	exit;

if(!strcmp($_POST['type'],'id')){
	$sql = 'select * from member where hero_name = \''.$_POST['hero_name'].'\' and hero_jumin=\''.$_POST['hero_jumin'].'\' and hero_mail=\''.$_POST['hero_mail'].'\' and hero_use=0';
    $sql = out($sql);
    sql($sql, 'end');
    $count = @mysql_num_rows($out_sql);
    $review_list                             = @mysql_fetch_assoc($out_sql);
    if(!strcmp($count,'0')){
		
		//################### 휴면계정 추가 ######################
		$sql = 'select * from member_backup where hero_name = \''.$_POST['hero_name'].'\' and hero_jumin=\''.$_POST['hero_jumin'].'\' and hero_mail=\''.$_POST['hero_mail'].'\' and hero_use=0';
		$sql = out($sql);
		sql($sql, 'end');
		$count = @mysql_num_rows($out_sql);
		
		if($count == 0){
		}else{
			$review_list = @mysql_fetch_assoc($out_sql);
			$out = $review_list['hero_id'];
			echo getIconv($out);
			exit;
		}
		//################### 휴면계정 추가 ######################
		
        $out = "";
    }else{
        $out = $review_list['hero_id'];
    }
    echo getIconv($out);
} else if(!strcmp($_POST['type'],'pw')){
    $str_len = strlen($_POST['hero_id']);
    if(($str_len > '3') and ($str_len < '21') ){
        $sql = "select * from member where hero_id = '".$_POST['hero_id']."' and hero_jumin='".$_POST['hero_jumin']."' and hero_mail='".$_POST['hero_mail']."'";
        $sql = out($sql);
        sql($sql, 'end');
        $count = @mysql_num_rows($out_sql);
        $review_list                             = @mysql_fetch_assoc($out_sql);
            if(!strcmp($count,'0')){
				
				//################### 휴면계정 추가 ######################
				$sql = "select * from member_backup where hero_id = '".$_POST['hero_id']."' and hero_jumin='".$_POST['hero_jumin']."' and hero_mail='".$_POST['hero_mail']."'";
				$sql = out($sql);
				sql($sql, 'end');
				$count = @mysql_num_rows($out_sql);
				
				if($count == 0){
				}else{
					$review_list = @mysql_fetch_assoc($out_sql);
					for ($i=1;$i<=8;$i++ ) { // 8자리 난수 발생
						$code .= substr('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', rand(0,61), 1);
					}
					
					$login_id = $_POST['hero_id'];
					$pw_md5 = md5($code);
					$temp = $pw_md5.$login_id;
					$pw_sha3_256 = sha3_hash('sha3-256', $temp);
					
					$sql = "update member_backup set hero_pw= '".$pw_sha3_256."' where hero_id = '".$_POST['hero_id']."' and hero_jumin='".$_POST['hero_jumin']."' and hero_mail='".$_POST['hero_mail']."' and hero_code='".$review_list["hero_code"]."'";
					$sql = out($sql);
					sql($sql, 'end');
					
					$out = "회원님의 비밀번호를 [".$code."] 로 초기화 하였습니다. 로그인 후 비밀번호를 변경해 주세요.";
					//echo iconv('CP949', 'UTF-8', $out);
					echo getIconv($out);
					exit;
				}
				//################### 휴면계정 추가 ######################	
		
                $out = "일치하는 회원정보가 없습니다. 입력하신 정보를 확인하여 주세요.";
            }else{//데이터 있을 경우

				$hero_use = $review_list['hero_use'];
				$target_idx = $review_list["hero_idx"];
				$target_id = $review_list["hero_id"];
				$target_email = $review_list["hero_mail"];

				if($hero_use==0){//탈퇴 아님
					//' 인증코드 생성
					$authCode = MD5($target_idx.$target_id.time());

					//' 비밀번호 재설정 등록
					$sql = "INSERT INTO reset_pw (hero_id, hero_email, target_idx, auth_code, reg_ip, hero_date) VALUES ('".$target_id."','".$target_email."','".$target_idx."','".$authCode."','".$_SERVER["REMOTE_ADDR"]."',now())";
					$sql = out($sql);
					sql($sql, 'end');
				
							
					$mailTemplate = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
					<html xmlns='http://www.w3.org/1999/xhtml'>
					<head>
					<meta http-equiv='Content-Type' content='text/html; charset=CP949' />
					<title>AKLOVER</title>
					</head>

					<body	style='margin-left:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;'>
						<div style='border:3px solid #acacac;width:600px;' align='center'>
							<div style='width:100%;text-align:center;' align='center'><img src='http://aklover.co.kr/image/mail/top_repasswd.jpg'/></div>
							<div style='width:80%;text-align:center;' align='center'>
								<div style='width:100%;text-align:left;color:#f58424;font-size:15px;font-weight:bold;height:30px;padding-top:10px; border-bottom:1px solid #acacac;' align='left'>비밀번호 재설정 메일 입니다.</div>
								<div style='width:100%;text-align:left;color:#666666;font-size:13px;padding-top:15px;padding-bottom:50px;' align='left'>
									<p>
									".$id." 고객님, 안녕하세요!<br />
									고객님께서는 AK LOVER(애경서포터즈) 사이트의 비밀번호 재설정을 요청 하셨습니다.<br />
									아래의 링크를 클릭하시어 비밀번호를 재설정 해 주세요.
									</p>
									<a href='".DOMAIN_END."m/pwreset.php?board=pwreset&auth=".$authCode."&id=".$target_id."' style='color:#000000;' target='_blank'>
									".DOMAIN_END."m/pwreset.php?board=pwreset&auth=".$authCode."&id=".$target_id."
									</a>
									
								</div>
							</div>
							<div style='width:100%;height:104px;background-color:#f7f7f7;' align='left'>
								<table width='100%' border='0' cellspacing='0' cellpadding='0'>
									<tr>
										<td align='right' valign='middle' style='width:25%;'><img src='http://aklover.co.kr/image/mail/bottom_logo.jpg' /></td>
										<td align='left' valign='top' style='width:75%;padding-left:15px;padding-top:30px;'>
											<div style='width:100%;text-align:left;color:#666666;font-size:11px;' align='left'>
												<a href='https://www.aklover.co.kr' target='_blank' style='color:#666'>고객만족팀</a> 080-024-1357 애경산업(주) 서울시 마포구 양화로 188<br />
												COPYRIGHT ⓒ 2018 Aekyung Industrial Co., Ltd. ALL RIGHT RESERVED. 
											
											</div>						
										</td>
									</tr>
								</table>
							</div>
						</div>
					</body>
					</html>";
					
					$subject = "[ak lover] 비밀번호 재 설정 안내 메일";
					// HTML 내용을 메일로 보낼때는 Content-type을 설정해야한다
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=euc-kr' . "\r\n";

					// 추가 header
					// 받는사람 표시
					$headers .= 'To: '.$id.' <'.$target_email.'>' . "\r\n";
					// 보내는사람
					$headers .= 'From: AK LOVER<ak-cs@aekyung.kr>' . "\r\n";
					//$headers .= 'From: AK LOVER<ak-cs@aklover.co.kr>' . "\r\n";
					// 메일 보내기
					mail($to, $subject, $mailTemplate, $headers);		
					$out = "비밀번호 초기화 메일을 발송 하였습니다. 메일을 확인하여 주십시오.";					
				}else{//탈퇴임
					$out = "해당 회원은 탈퇴 하셨습니다";
				}//탈퇴여부		
			
			}//데이터 있을 경우
			//echo iconv('CP949', 'UTF-8', $out);			
			echo getIconv($out);
					
		}else{//$str_len > '3'
			$out = "일치하는 회원정보가 없습니다. 입력하신 정보를 확인하여 주세요.";
			//echo iconv('CP949', 'UTF-8', $out);
			echo getIconv($out);
		}

} else if(!strcmp($_POST['type'],'pw2')){
    $str_len = strlen($_POST['hero_id']);
    $hero_hp = $_POST['hero_hp1']."-".$_POST['hero_hp2']."-".$_POST['hero_hp3'];
    if(($str_len > '3') and ($str_len < '21') ){
        $sql = "select SEND_MESSAGE from TSMS_AGENT_MESSAGE where REGISTER_BY = '".$_POST['hero_id']."' and DATE_ADD(SEND_RESERVE_DATE, INTERVAL 3 MINUTE) >= NOW() order by SEND_RESERVE_DATE desc LIMIT 1";
        sql($sql, 'end');
        $sql_list = @mysql_fetch_assoc($out_sql);

        if(strpos($sql_list['SEND_MESSAGE'] , $_POST['authCode']) == false){
            //문자 전송?으면 LOG에서 확인
            $sql_log = "select SEND_MESSAGE from TSMS_AGENT_MESSAGE_LOG where REGISTER_BY = '".$_POST['hero_id']."' and DATE_ADD(SEND_RESERVE_DATE, INTERVAL 3 MINUTE) >= NOW() order by SEND_RESERVE_DATE desc LIMIT 1";
            sql($sql_log, 'end');
            $sql_log_list = @mysql_fetch_assoc($out_sql);

            if(strpos($sql_log_list['SEND_MESSAGE'] , $_POST['authCode']) == false){
                $out = "일치하는 회원정보가 없습니다. 입력하신 정보를 확인하여 주세요.";
                echo iconv('CP949', 'UTF-8', $out);
                exit;
            }
        }

        $sql = " SELECT * FROM member where hero_id = '".$_POST['hero_id']."' AND hero_name='".$_POST['hero_name']."' AND hero_hp='".$hero_hp."' AND hero_use = 0 ";
        $sql = out($sql);
        sql($sql, 'end');
        $count = @mysql_num_rows($out_sql);
        $review_list                             = @mysql_fetch_assoc($out_sql);
        if(!strcmp($count,'0')){

            //################### 휴면계정 추가 ######################
            $sql = "select * from member_backup where hero_id = '".$_POST['hero_id']."' and hero_name='".$_POST['hero_name']."' and hero_hp='".$hero_hp."'";
            $sql = out($sql);
            sql($sql, 'end');
            $count = @mysql_num_rows($out_sql);

            if($count == 0){
            }else{

                $review_list = @mysql_fetch_assoc($out_sql);
                /*임시 비밀번호 성성
				$rand_num = sprintf('%02d',rand(00,99));
			
				$chars = "abcdefghijklmnopqrstuvwxyz";
				$var_size = strlen($chars);
				$random_str = "";
				for( $x = 0; $x < 4; $x++ ) {
					$random_str .= $chars[rand(0,$var_size-1)];
				}
				
				$temp_password = $rand_num.$random_str;
				$login_id = $_POST['hero_id'];
				$pw_md5 = md5($temp_password);
				$temp = $pw_md5.$login_id;
				$pw_sha3_256 = sha3_hash('sha3-256', $temp);
				
				$sql = "UPDATE member_backup SET hero_pw = '".$pw_sha3_256."' WHERE hero_code = '".$review_list['hero_code']."' AND hero_use = 0 ";
				$sql = out($sql);
				sql($sql,"end");
				
				sendSmsPassword($temp_password,$review_list["hero_hp"],$review_list["hero_id"]);
		        */
                echo iconv('CP949', 'UTF-8', $out);
                exit;
            }
            //################### 휴면계정 추가 ######################

            $out = "일치하는 회원정보가 없습니다. 입력하신 정보를 확인하여 주세요.";
        }else{//데이터 있을 경우
            /*임시 비밀번호 생성
            $rand_num = sprintf('%02d',rand(00,99));

            $chars = "abcdefghijklmnopqrstuvwxyz";
            $var_size = strlen($chars);
            $random_str = "";
            for( $x = 0; $x < 4; $x++ ) {
                $random_str .= $chars[rand(0,$var_size-1)];
            }

            $temp_password = $rand_num.$random_str;
            $login_id = $_POST['hero_id'];
            $pw_md5 = md5($temp_password);
            $temp = $pw_md5.$login_id;
            $pw_sha3_256 = sha3_hash('sha3-256', $temp);

            $sql = "UPDATE member SET hero_pw = '".$pw_sha3_256."' WHERE hero_code = '".$review_list['hero_code']."' AND hero_use = 0 ";
            $sql = out($sql);
            sql($sql,"end");

            sendSmsPassword($temp_password,$review_list["hero_hp"],$review_list["hero_id"]);
            */
            $out = $review_list["hero_id"];

        }//데이터 있을 경우
        echo iconv('CP949', 'UTF-8', $out);
        //echo $out;

    }else{//$str_len > '3'
        $out = "일치하는 회원정보가 없습니다. 입력하신 정보를 확인하여 주세요.";
        //echo $out;
        echo iconv('CP949', 'UTF-8', $out);
    }
} else if(!strcmp($_POST['type'],'sendAuth')){
    $str_len = strlen($_POST['hero_id']);
    $hero_hp = $_POST['hero_hp1']."-".$_POST['hero_hp2']."-".$_POST['hero_hp3'];
    if(($str_len > '3') and ($str_len < '21') ){
        $sql = " SELECT * FROM member where hero_id = '".$_POST['hero_id']."' AND hero_name='".$_POST['hero_name']."' AND hero_hp='".$hero_hp."' AND hero_use = 0 ";
        $sql = out($sql);
        sql($sql, 'end');
        $count = @mysql_num_rows($out_sql);
        $review_list                             = @mysql_fetch_assoc($out_sql);
        if(!strcmp($count,'0')){

            //################### 휴면계정 추가 ######################
            $sql = "select * from member_backup where hero_id = '".$_POST['hero_id']."' and hero_name='".$_POST['hero_name']."' and hero_hp='".$hero_hp."'";
            $sql = out($sql);
            sql($sql, 'end');
            $count = @mysql_num_rows($out_sql);

            if($count == 0){
            }else{

                $review_list = @mysql_fetch_assoc($out_sql);

                $rand_num = sprintf('%02d',rand(00,99));

                $chars = "abcdefghijklmnopqrstuvwxyz";
                $var_size = strlen($chars);
                $random_str = "";
                for( $x = 0; $x < 4; $x++ ) {
                    $random_str .= $chars[rand(0,$var_size-1)];
                }

                $temp_authNumber = $rand_num.$random_str;

                sendSmsPasswordAuthNumber($temp_authNumber,$review_list["hero_hp"],$review_list["hero_id"]);

                $out = $review_list["hero_id"];

                echo iconv('CP949', 'UTF-8', $out);
                exit;
            }
            //################### 휴면계정 추가 ######################

            $out = "일치하는 회원정보가 없습니다. 입력하신 정보를 확인하여 주세요.";
        }else{//데이터 있을 경우
            $rand_num = sprintf('%02d',rand(00,99));

            $chars = "abcdefghijklmnopqrstuvwxyz";
            $var_size = strlen($chars);
            $random_str = "";
            for( $x = 0; $x < 4; $x++ ) {
                $random_str .= $chars[rand(0,$var_size-1)];
            }

            $temp_authNumber = $rand_num.$random_str;

            sendSmsPasswordAuthNumber($temp_authNumber,$review_list["hero_hp"],$review_list["hero_id"]);

            $out = $review_list["hero_id"];

        }//데이터 있을 경우
        echo iconv('CP949', 'UTF-8', $out);
        //echo $out;

    }else{//$str_len > '3'
        $out = "일치하는 회원정보가 없습니다. 입력하신 정보를 확인하여 주세요.";
        //echo $out;
        echo iconv('CP949', 'UTF-8', $out);
    }
} else if(!strcmp($_POST['type'],'chgpw')){ //비밀번호 변경
    //비밀번호 같은지 확인
    if($_POST['newPw'] != $_POST['chNewPw']){
        $out = "비밀번호가 같지 않습니다";
        echo iconv('CP949', 'UTF-8', $out);
        exit;
    }

    $str_len = strlen($_POST['hero_id']);
    if(($str_len > '3') and ($str_len < '21') ){
        $sql = " SELECT * FROM member where hero_id = '".$_POST['hero_id']."' AND hero_use = 0 ";
        $sql = out($sql);
        sql($sql, 'end');
        $count = @mysql_num_rows($out_sql);
        $review_list                             = @mysql_fetch_assoc($out_sql);
        if(!strcmp($count,'0')){ //데이터 없을 경우
            //################### 휴면계정 추가 ######################
            $sql = "select * from member_backup where hero_id = '".$_POST['hero_id']."'";
            $sql = out($sql);
            sql($sql, 'end');
            $count = @mysql_num_rows($out_sql);
            $review_list                             = @mysql_fetch_assoc($out_sql);
            if($count != 0){
                $chg_pw = $_POST['newPw'];

                $login_id = $_POST['hero_id'];
                $pw_md5 = md5($chg_pw);
                $temp = $pw_md5.$login_id;
                $pw_sha3_256 = sha3_hash('sha3-256', $temp);

                $sql = "UPDATE member_backup SET hero_pw = '".$pw_sha3_256."' WHERE hero_id = '".$_POST['hero_id']."' AND hero_use = 0 ";
                $sql = out($sql);
                sql($sql,"end");

                $out = $review_list["hero_id"];;

                echo iconv('CP949', 'UTF-8', $out);
                exit;
            }
            //################### 휴면계정 추가 ######################

            $out = "일치하는 회원정보가 없습니다. 입력하신 정보를 확인하여 주세요.";
        }else{//데이터 있을 경우
            $chg_pw = $_POST['newPw'];

            $login_id = $_POST['hero_id'];
            $pw_md5 = md5($chg_pw);
            $temp = $pw_md5.$login_id;
            $pw_sha3_256 = sha3_hash('sha3-256', $temp);

            $sql = "UPDATE member SET hero_pw = '".$pw_sha3_256."' WHERE hero_id = '".$_POST['hero_id']."' AND hero_use = 0 ";
            $sql = out($sql);
            sql($sql,"end");

            $out = $review_list["hero_id"];;

        }
    }else{
        $out = "일치하는 회원정보가 없습니다. 입력하신 정보를 확인하여 주세요.";
    }
    echo iconv('CP949', 'UTF-8', $out);
}
?>