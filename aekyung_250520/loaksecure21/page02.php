<?
function page2($total,$list,$tail,$page,$next_path){
    global $PHP_SELF;
    $total_page = ceil($total/$list);
	//exit;
    if (!$page) $page = 1;
    $page_list = ceil($page/$tail)-1;
    if($page_list>0){
        $tail_page  = '     <a href="javascript:ch_page(1)"><span class="page"><<</span></a>'.PHP_EOL;
        $prev_page  = ($page_list-1)*$tail+1;
        $tail_page .= '     <a href="javascript:ch_page('.$prev_page.')"><span class="page"><</span></a>'.PHP_EOL;
    }
    $page_end=($page_list+1)*$tail;
    if($page_end>$total_page) 	$page_end=$total_page;
    for($setpage=$page_list*$tail+1;$setpage<=$page_end;$setpage++){
        if ($setpage==$page){
            $tail_page .= '                            <a href="#" class="on"><span class="page">'.$setpage.'</span></a>'.PHP_EOL;
        }else{
            $tail_page .= '                            <a href="javascript:ch_page('.$setpage.')"><span>'.$setpage.'</span></a>'.PHP_EOL;
        }
    }
    
    if($page_end<$total_page){
        $next_page = ($page_list+1)*$tail+1;
        $tail_page .= '     <a href="javascript:ch_page('.$next_page.')"><span class="page">></span></a>'.PHP_EOL;
        $tail_page .= '     <a href="javascript:ch_page('.$total_page.')"><span class="page">>></span></a>'.PHP_EOL;
    }
    return $tail_page;
}
?>

