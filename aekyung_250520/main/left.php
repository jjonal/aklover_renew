<?
if(!defined('_HEROBOARD_'))exit;

$error="LEFT_01";

$sql = "select B.* from (select hero_group from hero_group where hero_board='".$_GET['board']."' and hero_use='1') as A, hero_group as B where A.hero_group=B.hero_group and B.hero_use='1' and hero_order!='0' and hero_depth != 2 order by hero_order asc";//desc

$left_res = new_sql($sql,$error, "on");
if((string)$left_res==$error){
	error_historyBack("");
	exit;
}

$dontNeedSnbTop = array("login");
$needToChangeSnb = array("signup","idcheck");
$left_i=0;
$left_result = "";
while($left_rs = mysql_fetch_assoc($left_res)) {
	
	for ($i = 0; $i < count($needToChangeSnb); $i=$i+2) {
		if($needToChangeSnb[$i]==$_GET['board'])			$board = $needToChangeSnb[$i+1];
		else												$board = $_GET['board'];
	}
	if($left_rs['hero_board']==$board)				$active_class = " class='active'";
	else									        $active_class = "";

	$top_alt = explode('||', $left_rs['hero_top']);
	$hero_alt = explode('||', $left_rs['hero_left']);
	if($left_i==0) {
		$left_result .= "<div class='subtop_img'>";
		$left_result .= "</div>";
		$left_result .= "<div id='content'>";
		$left_result .= "<div class='clearfix'></div>";
		$left_result .= "<div class='snb_area'>";
		$left_result .= "<ul class='snb'>";
	}
	
	if($left_rs['hero_group']==$left_rs['hero_board'] && !in_array($left_rs['hero_group'], $dontNeedSnbTop)) {
		$left_result .=  "<li class='topTitle' onclick=\"location.href='".url($left_rs['hero_href'])."'\">";
		$left_result .=  $left_rs['hero_top_title'];
		$left_result .=  "</li>";
	} else {
		if($left_rs["hero_board"] == "group_04_06" 
			|| $left_rs["hero_board"] == "group_04_27" 
			|| $left_rs["hero_board"] == "group_04_28") { //뷰티클럽 메뉴 추가, 유튜버, 라이프클럽
			if($active_class) $active_class = " class='active2' ";
			$left_result .=  "<li ".$active_class." style='height:inherit'>";
			$left_result .=  "<a href='javascript:;' onclick=\"location.href='".url($left_rs['hero_href'])."'\">".$left_rs['hero_title']."</a>";
			
				$subOn[] = array();
				if($_GET["view"] != "missionReview" && $_GET["view"] != "greatReview") {
					$subOn[0] = "class='on'";
					$subOn[1] = "";
					$subOn[2] = "";
				} else if($_GET["view"] == "missionReview") {
					$subOn[0] = "";
					$subOn[1] = "class='on'";
					$subOn[2] = "";
				} else if($_GET["view"] == "greatReview") {
					$subOn[0] = "";
					$subOn[1] = "";
					$subOn[2] = "class='on'";
				}
				
				$left_result .= '<ul>';
				$left_result .= '<li '.$subOn[0].'><a href="'.url($left_rs['hero_href']).'">진행중인 미션</a></li>';
				$left_result .= '<li '.$subOn[1].' style="border-bottom:none;"><a href="'.url($left_rs['hero_href']).'&view=missionReview">미션후기</a></li>';
				// 2023.02.23 Beauty Club, Life Club 모두 우수후기 카테고리 사용자 화면에서 미노출 되도록 설정
				//$left_result .= '<li '.$subOn[2].' style="border-bottom:none;"><a href="'.url($left_rs['hero_href']).'&view=greatReview">우수후기</a></li>';
				$left_result .= '</ul>';
		} else if($left_rs["hero_board"] == "group_04_30") {
			$depth1_url = url($left_rs['hero_href'])."&view=login";
			if($_SESSION["global_code"] || $_SESSION["temp_level"] == "9999") $depth1_url = url($left_rs['hero_href'])."&view=noticeList";			
			if($active_class) $active_class = " class='active2' ";
			
			$subOn[] = array();
			if(strpos($_GET["view"],"login") !== false) {
				unset($subOn);
				$subOn[0] = "class='on'";
			} else if(strpos($_GET["view"],"notice") !== false) {
				unset($subOn);
				$subOn[1] = "class='on'";
			} else if(strpos($_GET["view"],"mission") !== false) {
				unset($subOn);
				$subOn[2] = "class='on'";
			} else if(strpos($_GET["view"],"review")!== false) {
				unset($subOn);
				$subOn[3] = "class='on'";
			} else if(strpos($_GET["view"],"qna") !== false) {
				unset($subOn);
				$subOn[4] = "class='on'";
			}
			
			$left_result .=  "<li ".$active_class." style='height:inherit'>";
			$left_result .=  "<a href='javascript:;' onclick=\"location.href='".$depth1_url."'\">".$left_rs['hero_title']."</a>";
			$left_result .= '<ul>';
			
			if(!$_SESSION["global_code"]) {
				$left_result .= '<li '.$subOn[0].'><a href="'.url($left_rs['hero_href']).'&view=login">로그인</a></li>';
			}
			$left_result .= '<li '.$subOn[1].'><a href="'.url($left_rs['hero_href']).'&view=noticeList">공지사항</a></li>';
			$left_result .= '<li '.$subOn[2].'><a href="'.url($left_rs['hero_href']).'&view=missionList">진행중인 미션</a></li>';
			$left_result .= '<li '.$subOn[3].'><a href="'.url($left_rs['hero_href']).'&view=reviewList">후기통</a></li>';
			$left_result .= '<li '.$subOn[4].' style="border-bottom:none;"><a href="'.url($left_rs['hero_href']).'&view=qnaList">1:1 문의</a></li>';
			$left_result .= '</ul>';
		} else if($left_rs["hero_board"] == "group_04_12") {
			if($active_class) {
				$active_class = " class='active2' ";
			} else if($_GET["board"] == "group_04_14") {
				$active_class = " class='active2' ";
			} else if($_GET["board"] == "group_04_15") {
				$active_class = " class='active2' ";
			} else if($_GET["board"] == "group_04_32") {
			    $active_class = " class='active2' ";
			} 

			$subOn[] = array();
			if($_GET["board"] == "group_04_12" || $_GET["board"] == "group_04_14") {
				unset($subOn);
				$subOn[1] = "class='on'";
			} else if($_GET["board"] == "group_04_12" || $_GET["board"] == "group_04_15") {
				unset($subOn);
				$subOn[2] = "class='on'";
			} else if($_GET["board"] == "group_04_12" || $_GET["board"] == "group_04_32") {
			    unset($subOn);
			    $subOn[0] = "class='on'";
			}
			
			$left_result .=  "<li ".$active_class." style='height:inherit'>";
			$left_result .=  "<a href='javascript:;' onclick=\"location.href='/main/index.php?board=group_04_32'\">AK LOVER 참여하기</a>";
			
			$left_result .= '<ul>';
			$left_result .= '<li '.$subOn[0].'><a href="/main/index.php?board=group_04_32">홈페이지 이용가이드</a></li>';
			$left_result .= '<li '.$subOn[1].'><a href="/main/index.php?board=group_04_14">체험단 종류</a></li>';
			$left_result .= '<li '.$subOn[2].' style="border-bottom:none;"><a href="/main/index.php?board=group_04_15">공정위문구/슈퍼패스</a></li>';
			$left_result .= '</ul>';
		}  else if($left_rs["hero_board"] == "group_04_33") {
		    if($active_class) {
		        $active_class = " class='active2' ";
		    } else if($_GET["board"] == "group_04_34") {
		        $active_class = " class='active2' ";
		    } else if($_GET["board"] == "group_04_35") {
		        $active_class = " class='active2' ";
		    }
		    
		    $subOn[] = array();
		    if($_GET["board"] == "group_04_33" || $_GET["board"] == "group_04_34") {
		        unset($subOn);
		        $subOn[0] = "class='on'";
		    } else if($_GET["board"] == "group_04_33" || $_GET["board"] == "group_04_35") {
		        unset($subOn);
		        $subOn[1] = "class='on'";
		    }
		    
		    $left_result .=  "<li ".$active_class." style='height:inherit'>";
		    $left_result .=  "<a href='javascript:;' onclick=\"location.href='/main/index.php?board=group_04_33'\">고객센터</a>";
		    
		    $left_result .= '<ul>';
		    $left_result .= '<li '.$subOn[0].'><a href="/main/index.php?board=group_04_34">자주 묻는 질문</a></li>';
		    $left_result .= '<li '.$subOn[1].' style="border-bottom:none;"><a href="/main/index.php?board=group_04_35">1:1 문의</a></li>';
		    $left_result .= '</ul>';
		} else {
			$left_result .=  "<li ".$active_class." onclick=\"location.href='".url($left_rs['hero_href'])."'\">";
			$left_result .=  $left_rs['hero_title'];
		}
		
		$left_result .=  "</li>";
	}
	$left_i++;
	
	
}
//고객센터는 하드코딩
/* if($_GET['board'] == "group_04_01" ||
   $_GET['board'] == "group_04_02" ||
   $_GET['board'] == "group_04_12" ||
   $_GET['board'] == "group_04_13" ||
   $_GET['board'] == "group_04_14" ||
   $_GET['board'] == "group_04_15" ||
   $_GET['board'] == "group_04_32" ||
   $_GET['board'] == "group_04_16" ||
   $_GET['board'] == "group_03_01") {
    $left_result .= "<li onclick=\"location.href='/main/index.php?board=cus_2'\">고객센터</li>";
} */

echo $left_result;
?>
        </ul>
    </div>
    
<?php 
$dontNeedNav = array("login", "idcheck", "signup", "findpw", "auth", "group_04_30");
if (!in_array($_GET['board'], $dontNeedNav)) {
######################################################################################################################################################
$sql = "select * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$_GET['board']."'";
//echo $sql;
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);
######################################################################################################################################################
?>
    <?if($right_list["hero_idx"]) {?>
    <div class="contents_area">
        <div class="page_title">
            <div><?=$right_list['hero_title']?></div>
            <? if($_GET['board'] == "group_04_05") {?>
            <a href="/main/index.php?board=group_04_12" class="mission_guide_btn">체험단 참여방법 >></a>
            <? } ?>
            <ul class="nav">
                <li><img src="/image/common/icon_nav_home.gif" alt="home" /></li>
                <li>&gt;</li>
                <li><?=$right_list['hero_top_title'];?></li>
                <li>&gt;</li>
                <li class="current"><?=$right_list['hero_title'];?></li>
            </ul>
        </div>
    <? } ?>
 <? } ?>
