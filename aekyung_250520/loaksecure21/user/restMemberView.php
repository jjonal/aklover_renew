<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
//border:1px solid #000000;
######################################################################################################################################################
$sql = 'select * from member_backup where hero_idx=\''.$_GET['next_idx'].'\';';//desc
sql($sql,'on');
$check_list                             = @mysql_fetch_assoc($out_sql);

$level_sql = 'select * from level where hero_level='.$check_list['hero_level'].' order by hero_level desc;';//desc<=
$out_level_sql = mysql_query($level_sql);
$level_list                             = @mysql_fetch_assoc($out_level_sql);
######################################################################################################################################################
if(!strcmp($_GET['type'], 'edit')){
    $post_count = @count($_POST['hero_idx']);
    for($i=0;$i<$post_count;$i++){
        reset($_POST);
        unset($sql_one_update);
        $idx = $_POST['hero_idx'];
        $data_i = '1';
        $count = @count($_POST);
        while(list($post_key, $post_val) = each($_POST)){
           if(!strcmp($post_key, 'hero_idx')){
                $data_i++;
                continue;
            }
            if(!strcmp($count, $data_i)){
                $comma = '';
            }else{
                $comma = ', ';
            }
            $sql_one_update .= $post_key.'=\''.$_POST[$post_key].'\''.$comma;
        $data_i++;
        }
        $msg = '수정';
        $sql = 'UPDATE member_backup SET '.$sql_one_update.' WHERE hero_idx = \''.$idx.'\';'.PHP_EOL;
        mysql_query($sql);
    }
    msg($msg.' 되었습니다.','location.href="'.PATH_HOME.'?'.get('type','').'"');
    exit;
}else if(!strcmp($_GET['type'], 'drop')){
    $idx = $_REQUEST['next_idx'];
	
	//1. backup 테이블에서 복원
	$sql1 = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS  WHERE table_name = 'member'";//컬럼조회
	$res1 = mysql_query($sql1) or die(mysql_error());  
	$sql2 = "update member as A,member_backup as B set ";
	while($rs1 = mysql_fetch_array($res1)){
		if($rs1["COLUMN_NAME"] == "hero_idx"){
		}else{
			$sql2 .= "A.".$rs1["COLUMN_NAME"]."=B.".$rs1["COLUMN_NAME"].",";
		}	
	}
	$sql2.="A.hero_idx=A.hero_idx where A.hero_code=B.hero_code and B.hero_code='".$idx."' ";//기존 데이터에서 null 처리 시킴
	mysql_query($sql2) or die(mysql_error()); 
	
	
	//2. backup 테이블에서 삭제
	$sql_backupdelete = "delete from member_backup where hero_code='".$idx."'";
	$res_backupdelete = mysql_query($sql_backupdelete) or die(mysql_error());
	
	//3. 회원 히스토리 테이블 저장
	$sql_backup = "insert into member_backup_history (hero_code,hero_type,hero_today) values ('".$idx."','in',now())";
	$res_backup = mysql_query($sql_backup) or die(mysql_error());


	$sql_one = "hero_table='', hero_info_type=null, hero_info_di=null, hero_info_ci=null, hero_facebook='', hero_kakaoTalk='', hero_naver='', ";
    $sql_one .= "hero_id=null, hero_pw=null, hero_name=null, hero_jumin=null, hero_sex=null, hero_mail=null, hero_hp=null, hero_address_01=null, hero_address_02=null, ";
    $sql_one .= "hero_address_03=null, hero_job_01=null, hero_job_02=null, hero_job_03=null, hero_blog_00=null, hero_blog_01=null, hero_blog_02=null, hero_blog_03=null, ";
    $sql_one .= "hero_blog_04=null, hero_blog_05=null, hero_blog_05_name='', hero_blog_type='', hero_excuse=null, hero_excuse_check=null, hero_excuse_path=null, hero_terms_01=null, hero_terms_02=null, ";
    $sql_one .= "hero_terms_03=null, hero_terms_04=null, hero_today=null, hero_today_plus=null, hero_login_ip=null, hero_dropday=null, hero_point=null, hero_out='관리자에 의해 탈퇴 되었습니다.', hero_out_date='".time()."', ";
    $sql_one .= "hero_memo=null, hero_memo_01=null, hero_memo_02=null, hero_memo_03=null, hero_memo_04=null, hero_user=null, hero_superpass=null, hero_use='1', hero_chk_phone=null, ";
    $sql_one .= "hero_chk_email=null, area=null, area_etc_text=null, hero_terms_05=null";
    $msg = '탈퇴';
    $sql = 'UPDATE member SET '.$sql_one.' WHERE hero_idx = \''.$idx.'\';'.PHP_EOL;

    @mysql_query($sql);
######################################################################################################################################################
/*회원탈퇴시 포인트 삭제
    $sql = 'DELETE FROM point WHERE hero_code = \''.$check_list['hero_code'].'\';';
    @mysql_query($sql);
*/
######################################################################################################################################################
    msg($msg.' 되었습니다.','location.href="'.PATH_HOME.'?'.get('type','').'"');
    exit;
}
######################################################################################################################################################
/*
                        $sql = 'select hero_point from point where hero_code=\''.$check_list['hero_code'].'\';';//desc
                        sql($sql);
                        while($total_list                             = @mysql_fetch_assoc($out_sql)){
                            $point = $point+$total_list['hero_point'];
                        }
                        if(!strcmp($point,"")){
                            $view_point = '0';
                        }else{
                            $view_point = $point;
                        }
*/
                        $view_point = $check_list['hero_point'];
                        if(!strcmp($check_list['hero_sex'],"1")){
                            $view_sex = '남성';
                        }else if(!strcmp($check_list['hero_sex'],"2")){
                            $view_sex = '여성';
                        }
                        if(!strcmp($check_list['hero_excuse_check'],"")){
                            $view_excuse = '기타';
                        }else if(!strcmp($check_list['hero_excuse_check'],"0")){
                            $view_excuse = '신문';
                        }else if(!strcmp($check_list['hero_excuse_check'],"1")){
                            $view_excuse = '잡지';
                        }else if(!strcmp($check_list['hero_excuse_check'],"2")){
                            $view_excuse = '블러그';
                        }else if(!strcmp($check_list['hero_excuse_check'],"3")){
                            $view_excuse = '카페';
                        }else if(!strcmp($check_list['hero_excuse_check'],"4")){
                            $view_excuse = '지인';
                        }else if(!strcmp($check_list['hero_excuse_check'],"6")){
                            $view_excuse = '쪽지';
                        }else{
                            $view_excuse = '기타';
                        }
?>
                        <table width="100%">
                            <tr>
                                <td align="center">
                                    <b> [ <font color="blue"><?=$check_list['hero_id'];?></font> ] </b>님 총 획득 Point는
                                    <font color="red"><b><?=$view_point;?></b></font>
                                </td>
                            </tr>
                        </table>
                        <table class="t_view">
                        <form name="form_next" action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post" enctype="multipart/form-data"> 
                        <input type="hidden" name="hero_idx" value="<?=$check_list['hero_idx']?>">
                            <colgroup>
                                <col width="20%">
                                <col width="30%">
                                <col width="20%">
                                <col width="30%">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th>회원 ID</th>
                                    <td><?=$check_list['hero_id'];?></td>
                                    <th>회원 성명</th>
                                    <td><?=$check_list['hero_name'];?></td>
                                </tr>
                                <tr>
                                    <th>연락처</th>
                                    <td><?=$check_list['hero_hp'];?></td>
                                    <th>E-mail</th>
                                    <td><?=$check_list['hero_mail'];?></td>
                                </tr>
                                <tr>
                                    <th>생년월일</th>
                                    <td><?=$check_list['hero_jumin'];?></td>
                                    <th>성별</th>
                                    <td><?=$view_sex;?></td>
                                </tr>
                                <tr>
                                    <th>등록일</th>
                                    <td><?=$check_list['hero_today'];?></td>
                                    <th>등급</th>
                                    <td><?=$level_list['hero_name'];?></td>
                                </tr>
                                <tr>
                                    <th>블로그url</th>
                                    <td><?=$check_list['hero_blog_00'];?></td>
                                    <th>페이스북url</th>
                                    <td><?=$check_list['hero_blog_01'];?></td>
                                </tr>
                                <tr>
                                    <th>트위터url</th>
                                    <td><?=$level_list['hero_blog_02'];?></td>
                                    <th>카카오스토리url</th>
                                    <td><?=$check_list['hero_blog_03'];?></td>
                                </tr>
                                <tr>
                                    <th>미투데이url</th>
                                    <td><?=$level_list['hero_blog_04'];?></td>
                                    <th>그외 SNS url</th>
                                    <td><?=$check_list['hero_blog_05'];?></td>
                                </tr>
                                <tr>
                                    <th>AK LOVER로 선발해야 하는 이유</th>
                                    <td colspan="3"><?=$check_list['hero_excuse'];?></td>
                                </tr>
                                <tr>
                                    <th>AK LOVER를 알게된 경로</th>
                                    <td><?=$view_excuse;?></td>
                                    <th>AK LOVER를 알게된 경로 기타</th>
                                    <td><?=$check_list['hero_excuse_path'];?></td>
                                </tr>
                                <tr>
                                    <th>주소</th>
                                    <td colspan="3">[<?=$check_list['hero_address_01'];?>] <?=$check_list['hero_address_02'];?> <?=$check_list['hero_address_03'];?></td>
                                </tr>
                                <tr>
                                    <th>탈퇴사유</th>
                                    <td colspan="3">
                                        <input type="text" id="hero_out" name="hero_out" value="<?=$check_list['hero_out'];?>" style="width:400px;height:20px;" readonly>
                                        <a href="<?=PATH_HOME.'?'.get('','type=drop');?>" class="btn_blue">강제탈퇴</a>
                                        <!-- *강제탈퇴는 포인트가 모두 소멸됩니다.-->
                                    </td>
                                </tr>
                                <tr>
                                    <th>러버등급</th>
                                    <td colspan="3"><textarea name="hero_memo" id="editor" class="textarea" style="width:900px; height:150px;"><?=$check_list['hero_memo'];?></textarea></td>
                                </tr>
                                <tr>
                                    <th>포스팅</th>
                                    <td colspan="3"><textarea name="hero_memo_01" id="editor" class="textarea" style="width:900px; height:150px;"><?=$check_list['hero_memo_01'];?></textarea></td>
                                </tr>
                                <tr>
                                    <th>비고란</th>
                                    <td colspan="3"><textarea name="hero_memo_02" id="editor" class="textarea" style="width:900px; height:150px;"><?=$check_list['hero_memo_02'];?></textarea></td>
                                </tr>
                                <tr>
                                    <th>비고란</th>
                                    <td colspan="3"><textarea name="hero_memo_03" id="editor" class="textarea" style="width:900px; height:150px;"><?=$check_list['hero_memo_03'];?></textarea></td>
                                </tr>
                                <tr>
                                    <th>비고란</th>
                                    <td colspan="3"><textarea name="hero_memo_04" id="editor" class="textarea" style="width:900px; height:150px;"><?=$check_list['hero_memo_04'];?></textarea></td>
                                </tr>
                        </tbody>
                        </table>
                        <table width="100%">
                            <tr>
                                <td width="45%">
                                    <a href="javascript:go_list();" class="btn_blue2">목록</a>
                                </td>
                            </tr>
                        </form>
                        </table>
                        <script>
                            function go_list(){
                                location.href = "./index.php?board=<?=$_GET['board']?>&idx=<?=$_GET['idx']?>";
                            }
                        </script>