<?
####################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
####################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
####################################################################################################################################################
function hero($hero_old = null){
    global $out_hero;
    $hero_new = strtoupper($hero_old);
    $hero = @explode('||', $hero_new);
    if(!strcmp($hero['1'],'')){
#####################################################################################################################################################
        if(!strcmp(eregi('_INC',$hero['0']),'1')){
            if(!strcmp(eregi('_HOME',$hero['0']),'1')){
                if(!strcmp(eregi('_END',$hero['0']),'1')){
                    $out_hero = @constant(@str_replace('_INC_HOME_END', '_HOME', $hero['0']));//echo 'inc없다-'.'INC있다'.'HOME있다'.'END있다';
                }else{
                    $out_hero = @constant(@str_replace('_INC_HOME', '_HOME', $hero['0']));//echo 'inc없다-'.'INC있다'.'HOME있다'.'END없다';
                }
            }else{
                if(!strcmp(eregi('_END',$hero['0']),'1')){
                    $out_hero = @constant(@str_replace('_INC_END', '_END', $hero['0']));//echo 'inc없다-'.'INC있다'.'HOME없다'.'END있다';
                }else{
                    $out_hero = @constant(@str_replace('_INC', '_END', $hero['0']));//echo 'inc없다-'.'INC있다'.'HOME없다'.'END없다';
                }
            }
        }else{
            if(!strcmp(eregi('_HOME',$hero['0']),'1')){
                if(!strcmp(eregi('_END',$hero['0']),'1')){
                    $out_hero = @constant(@str_replace('_HOME_END', '_HOME', $hero['0']));//echo 'inc없다-'.'INC없다'.'HOME있다'.'END있다';
                }else{
                    $out_hero = @constant($hero['0']);//echo 'inc없다-'.'INC없다'.'HOME있다'.'END없다';
                }
            }else{
                if(!strcmp(eregi('_END',$hero['0']),'1')){
                    $out_hero = @constant($hero['0']);//echo 'inc없다-'.'INC없다'.'HOME없다'.'END있다';
                }else{
                    if(defined($hero['0'])){
                        $out_hero = @constant($hero['0'].'_END');//echo 'inc없다-'.'INC없다'.'HOME없다'.'END없다';
                    }else{
                        $out_hero = strtolower($hero['0']);
                    }
                }
            }
        }
#####################################################################################################################################################
    }else if(!strcmp($hero['1'],'INC')){
#####################################################################################################################################################
        if(!strcmp(eregi('_INC',$hero['0']),'1')){
            if(!strcmp(eregi('_HOME',$hero['0']),'1')){
                if(!strcmp(eregi('_END',$hero['0']),'1')){
                    $out_hero = @constant(@str_replace('_INC_HOME_END', '_INC_HOME', $hero['0']));//echo 'inc있다-'.'INC있다'.'HOME있다'.'END있다';
                }else{
                    $out_hero = @constant($hero['0']);//echo 'inc있다-'.'INC있다'.'HOME있다'.'END없다';
                }
            }else{
                if(!strcmp(eregi('_END',$hero['0']),'1')){
                    $out_hero = @constant($hero['0']);//echo 'inc있다-'.'INC있다'.'HOME없다'.'END있다';
                }else{
                    $out_hero = @constant($hero['0'].'_END');//echo 'inc있다-'.'INC있다'.'HOME없다'.'END없다';
                }
            }
        }else{
            if(!strcmp(eregi('_HOME',$hero['0']),'1')){
                if(!strcmp(eregi('_END',$hero['0']),'1')){
                    $out_hero = @constant(@str_replace('_HOME_END', '_INC_HOME', $hero['0']));//echo 'inc있다-'.'INC없다'.'HOME있다'.'END있다';
                }else{
                    $out_hero = @constant(@str_replace('_HOME', '_INC_HOME', $hero['0']));//echo 'inc있다-'.'INC없다'.'HOME있다'.'END없다';
                }
            }else{
                if(!strcmp(eregi('_END',$hero['0']),'1')){
                    $out_hero = @constant(@str_replace('_END', '_INC_END', $hero['0']));//echo 'inc있다-'.'INC없다'.'HOME없다'.'END있다';
                }else{
                    $out_hero = @constant($hero['0'].'_INC_END');//echo 'inc있다-'.'INC없다'.'HOME없다'.'END없다';
                }
            }
        }
#####################################################################################################################################################
    }
    return $out_hero;
}
#####################################################################################################################################################
function get($drop_old = null,$join_old = null, $backup_old = null){
    global $out_get;
#####################################################################################################################################################
    unset($out_get);
    reset($_GET);
    unset($get_id);
    unset($get_value);
    unset($get_count);
#####################################################################################################################################################
    unset($drop_id);
    unset($drop_check);
    unset($drop_count);
    unset($drop_out);
#####################################################################################################################################################
    unset($join_id);
    unset($join_id_value);//없어도됨
    unset($join_id_new);//없어도됨
    unset($join_check);
    unset($join_count);
    unset($join_out);
#####################################################################################################################################################
    unset($backup_id);
    unset($backup_value);//없어도됨
    unset($backup_new);//없어도됨
    unset($backup_check);
    unset($backup_count);
    unset($backup_out);
#####################################################################################################################################################
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
#####################################################################################################################################################
    $get_id = array_keys($_GET);
    $get_value = array_values($_GET);
    $get_count = sizeof($_GET);
#####################################################################################################################################################
    $get_i='0';
    while(list($get_key, $get_val) = each($_GET)){
        if(!strcmp($get_i, '0')){
            $comma = '';
        }else{
            $comma = '&';
        }
        $get_out .= $comma.$get_key.'='.$get_val;
        $get_i++;
    }
    @reset($_GET);
#####################################################################################################################################################
    $drop_check = explode('||', $drop_old);

    $drop_count = '0';
    $drop_check_count = '0';
    while(list($drop_check_key, $drop_check_val) = each($drop_check)){
        if(!strcmp($drop_check_val, '')){
            unset($drop_check[$drop_check_count]);
            continue;
        }else{
            $drop_count++;
        }
        $drop_check_count++;
    }
    reset($drop_check);
    $drop_new_count = sizeof($drop_check);//없어도됨
    if(!strcmp($drop_count, '0')){
        unset($drop_check);
    }
    $drop_id = $drop_check;//없어도됨
    $drop_id_count = sizeof($drop_id);//없어도됨
#####################################################################################################################################################
    $join_check = explode('||', $join_old);

    $join_count = '0';
    $join_check_count = '0';
    while(list($join_check_key, $join_check_val) = each($join_check)){
        if(!strcmp($join_check_val, '')){
            unset($join_check[$join_check_count]);
            continue;
        }else{
            $join_id_arr = explode('=', $join_check_val);
            $join_id_new[$join_id_arr['0']] = $join_id_arr['1'];
            $join_id = array_keys($join_id_new);
            $join_value = array_values($join_id_new);
            $join_count++;
        }
        $join_check_count++;
    }
    reset($join_check);
    $join_new_count = sizeof($join_check);//없어도됨
    if(!strcmp($join_count, '0')){
        unset($join_check);
    }
    $join_id_count = sizeof($join_id);//없어도됨
#####################################################################################################################################################
    $backup_check = explode('||', $backup_old);

    $backup_count = '0';
    $backup_check_count = '0';
    while(list($backup_check_key, $backup_check_val) = each($backup_check)){
        if(!strcmp($backup_check_val, '')){
            unset($backup_check[$backup_check_count]);
            continue;
        }else{
            $backup_id_arr = explode('=', $backup_check_val);
            $backup_id_new[$backup_id_arr['0']] = $backup_id_arr['1'];
            $backup_id = array_keys($backup_id_new);
            $backup_value = array_values($backup_id_new);
            $backup_count++;
        }
        $backup_check_count++;
    }
    reset($backup_check);
    $backup_new_count = sizeof($backup_check);//없어도됨
    if(!strcmp($backup_count, '0')){
        unset($backup_check);
    }
    $backup_id_count = sizeof($backup_id);//없어도됨
#####################################################################################################################################################
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
#####################################################################################################################################################
    if(!strcmp($join_count, '0')){//get없을때
        $join_out = '';
    }else{
        $join_i = '1';
        while(list($join_key, $join_val) = each($join_check)){
            if(!strcmp(substr($join_val, '0', '1'), '&')){
                $join_data = substr($join_val, '1');
            }else{
                $join_data = $join_val;
            }
            if(!strcmp($join_count, $join_i)){
                $comma = '';
            }else{
                $comma = '&';
            }
            $join_out .= $join_data.$comma;
            $join_i++;
        }
    }
######################################################################################################################################################
    if(!strcmp($get_count, '0')){//get없을때
######################################################################################################################################################
        unset($drop_old);
        unset($backup_old);
        $out_get = $join_out;
######################################################################################################################################################
    }else{//get있을때
######################################################################################################################################################
        if(!strcmp($backup_count, '0')){//backup 없을때
######################################################################################################################################################
            if(!strcmp($drop_count, '0')){
                if(!strcmp($join_count, '0')){
                    $out_get = $get_out;//echo 'get만있다';
                }else{
                    $out_get = $get_out.'&'.$join_out;//echo 'get/join만있다';
                }
            }else{
                $get_drop_id_i='1';
                reset($_GET);//없어도됨
                $get_drop_id = array_diff($get_id, $drop_id);//                $get_drop_id_count = sizeof($get_drop_id);
                while(list($get_drop_id_key, $get_drop_id_val) = each($get_drop_id)){
                    if(!strcmp($get_drop_id_i, '1')){
                        $comma = '';
                    }else{
                        $comma = '&';
                    }
                    $get_drop_out .= $comma.$get_drop_id_val.'='.$_GET[$get_drop_id_val];
                    $get_drop_id_i++;
                }
                if(!strcmp($join_count, '0')){
                    $out_get = $get_drop_out;//echo 'get/drop만있다';
                }else{
                    $out_get = $get_drop_out.'&'.$join_out;//echo 'get/drop/join만있다';
                }
            }
######################################################################################################################################################
        }else{// backup 있을때
######################################################################################################################################################
            if(!strcmp($drop_count, '0')){//drop 없고
                if(!strcmp($join_count, '0')){
                    $out_get = $get_out;//echo 'get/backup만있다';
                }else{
                    $out_get = $get_out.'&'.$join_out;//echo 'get/backup/join만있다';
                }
            }else{//drop 있고
                $get_drop_id_i='1';
                reset($_GET);//없어도됨
                $get_drop_id = array_diff($get_id, $drop_id);//                $get_drop_id_count = sizeof($get_drop_id);
                while(list($get_drop_id_key, $get_drop_id_val) = each($get_drop_id)){
                        if(!strcmp($get_drop_id_i, '1')){
                            $comma = '';
                        }else{
                            $comma = '&';
                        }
                        $get_drop_out .= $comma.$get_drop_id_val.'='.$_GET[$get_drop_id_val];
                    $get_drop_id_i++;
                }
                reset($backup_id);//없어도됨
                $backup_i='1';
                while(list($backup_key, $backup_val) = each($backup_id)){
                        if(!strcmp($backup_i, '1')){
                            $comma = '';
                        }else{
                            $comma = '&';
                        }
                        $backup_out .= $comma.$backup_val.'_b='.$_GET[$backup_val];
                    $backup_i++;
                }
                reset($_GET);//없어도됨
                if(!strcmp($join_count, '0')){
                    $out_get = $get_drop_out.'&'.$backup_out;//echo 'get/backup/drop만있다';
                }else{
                    $out_get = $get_drop_out.'&'.$join_out.'&'.$backup_out;//echo 'get/backup/drop만있다';
                }
            }
######################################################################################################################################################
        }
######################################################################################################################################################
    }
######################################################################################################################################################
    return $out_get;
}
//get end

function hero_file($file_inc_path = null,$file_path = null){
    global $_FILES,$out_hero_file;
    
    while(list($file_key, $file_val) = @each($_FILES)){
        $file_old = $file_key;
    }
    $file_name = $_FILES[$file_old]['name'];
    $file_count = @count($file_name);
    
    if(strcmp($file_count,"0")){
       $i=0;
        while(list($file_key, $file_val) = each($file_name)){
            if(strcmp($_FILES[$file_old]['size'][$i],"0")){
           		//20170726 한글이미지 오류 수정
				//$ext = explode("/",$_FILES[$file_old]['type'][$i]);
				
				$ext = substr(strrchr($file_name[$i],"."),1);	//확장자앞 .을 제거하기 위하여 substr()함수를 이용
				$ext = strtolower($ext);			//확장자를 소문자로 변환
				
				$temp = explode("/",$_FILES[$file_old]['tmp_name'][$i]);
				//@move_uploaded_file($_FILES[$file_old]['tmp_name'][$i], $file_inc_path.Y_m_d_h_i_s.'_'.$file_name[$i]);
                //$file_new = $file_path.Y_m_d_h_i_s.'_'.$file_name[$i];
				
				@move_uploaded_file($_FILES[$file_old]['tmp_name'][$i], $file_inc_path.Y_m_d_h_i_s.'_'.$_POST['hero_idx'][$i].'.'.$ext);
                $file_new = $file_path.Y_m_d_h_i_s.'_'.$_POST['hero_idx'][$i].'.'.$ext;
                //echo "<br/>=".$file_new;
            }else{
                $file_new = '';
            }
            $out_hero_file[$_POST['hero_idx'][$i]] = $file_new;
            $i++;
        }
    }
    return $out_hero_file;
}
?>
