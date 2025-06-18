<?
if(!defined('_HEROBOARD_'))exit;
function page2($total,$list,$tail,$page,$next_path){
    global $PHP_SELF;
    $total_page = @ceil($total/$list);
    if (!$page) $page = 1;
    $page_list = @ceil($page/$tail)-1;

    $div_next_page= $page+1;
    /*if($page != $total_page){
    	$tail_page .='<style>.div_next_page{width:100%; height:30px; margin:0 0 10px 0; font-size:15px; color:#939393; background-color:#ffffff; border:1px solid #bbb; border-radius:10px; -webkit-transition: color 0.5s linear; margin-top:30px;}'.PHP_EOL;
    	$tail_page .='.div_next_page:hover{background-color:#eeeeee;}'.PHP_EOL;
    	$tail_page .='.div_next_page:active{box-shadow: 5px 5px 10px inset;}</style>'.PHP_EOL;
    	$tail_page .= '	<a href="'.DOMAIN.URI_PATH.'?'.$next_path.'&page='.$div_next_page.'"><button class="div_next_page">다음 페이지</button></a>'.PHP_EOL;
    }*/

    if($page_list>0){
//        $tail_page  = '     <a href="'.DOMAIN.URI_PATH.'?'.$next_path.'&page=1" class="img"><img src="../image/bbs/page_ppre.gif" alt="첫페이지" /></a>'.PHP_EOL;
        $prev_page  = ($page_list-1)*$tail+1;
        $tail_page .= '<a href="'.DOMAIN.URI_PATH.'?'.$next_path.'&page='.$prev_page.'"><img src="img/musign/board/page_l.webp" width="5px" alt="이전페이지" /></a>'.PHP_EOL;
    }
    $page_end=($page_list+1)*$tail;
    if($page_end>$total_page) $page_end=$total_page;
    for($setpage=$page_list*$tail+1;$setpage<=$page_end;$setpage++){
        if ($setpage==$page){
            $tail_page .= '<a href="#" class="current">'.$setpage.'</a>'.PHP_EOL;
        }else{
            $tail_page .= '<a href="'.DOMAIN.URI_PATH.'?'.$next_path.'&page='.$setpage.'" >'.$setpage.'</a>'.PHP_EOL;
        }
    }
    if($page_end<$total_page){
        $next_page = ($page_list+1)*$tail+1;
        $tail_page .= '     &nbsp;&nbsp;&nbsp;&nbsp;<a href="'.DOMAIN.URI_PATH.'?'.$next_path.'&page='.$next_page.'"><img src="img/musign/board/page_r.webp" width="5px" alt="다음페이지" /></a>'.PHP_EOL;
//        $tail_page .= '     <a href="'.DOMAIN.URI_PATH.'?'.$next_path.'&page='.$total_page.'" class="img"><img src="../image/bbs/page_nnext.gif" alt="마지막페이지" /></a>'.PHP_EOL;
    }

    return $tail_page;
}
echo page2($total_data,$list_page,$page_per_list,$_GET[page],stripslashes($next_path));
?>