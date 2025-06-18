<?
function page2($total,$list,$tail,$page,$next_path){
    global $PHP_SELF;
    $total_page = ceil($total/$list);
    if (!$page) $page = 1;
    $page_list = ceil($page/$tail)-1;
    if($page_list>0){
//        $tail_page  = '     <span class="page"><a href="'.PATH_HOME.'?'.$next_path.'&page=1"><img src="'.PATH_IMAGE_END.'btn_prev_end.gif" alt="prev end" /></a></span>'.PHP_EOL;
//        $tail_page  = '     <a href="'.PATH_HOME.'?'.$next_path.'&page=1"><span class="page"><img src="'.PATH_IMAGE_END.'btn_prev_end.gif" alt="prev end" /></span></a>'.PHP_EOL;
        $tail_page  = '     <a href="'.PATH_HOME.'?'.$next_path.'&page=1"><span class="page"><<</span></a>'.PHP_EOL;
        $prev_page  = ($page_list-1)*$tail+1;
//        $tail_page .= '     <span class="page"><a href="'.PATH_HOME.'?'.$next_path.'&page='.$prev_page.'"><img src="'.PATH_IMAGE_END.'btn_prev.gif" alt="prev" /></a></span>'.PHP_EOL;
//        $tail_page .= '     <a href="'.PATH_HOME.'?'.$next_path.'&page='.$prev_page.'"><span class="page"><img src="'.PATH_IMAGE_END.'btn_prev.gif" alt="prev" /></span></a>'.PHP_EOL;
        $tail_page .= '     <a href="'.PATH_HOME.'?'.$next_path.'&page='.$prev_page.'"><span class="page"><</span></a>'.PHP_EOL;
    }
    $page_end=($page_list+1)*$tail;
    if($page_end>$total_page) $page_end=$total_page;
    for($setpage=$page_list*$tail+1;$setpage<=$page_end;$setpage++){
        if ($setpage==$page){
//            $tail_page .= '                            <span class="page"><a href="#" class="on">'.$setpage.'</a></span>'.PHP_EOL;
            $tail_page .= '                            <a href="#" class="on"><span class="page">'.$setpage.'</span></a>'.PHP_EOL;
        }else{
//            $tail_page .= '                            <span><a href="'.PATH_HOME.'?'.$next_path.'&page='.$setpage.'">'.$setpage.'</a></span>'.PHP_EOL;
            $tail_page .= '                            <a href="'.PATH_HOME.'?'.$next_path.'&page='.$setpage.'"><span>'.$setpage.'</span></a>'.PHP_EOL;
        }
    }
    if($page_end<$total_page){
        $next_page = ($page_list+1)*$tail+1;
//        $tail_page .= '     <span class="page"><a href="'.PATH_HOME.'?'.$next_path.'&page='.$next_page.'"><img src="'.PATH_IMAGE_END.'btn_next.gif" alt="next" /></a></span>'.PHP_EOL;
//        $tail_page .= '     <a href="'.PATH_HOME.'?'.$next_path.'&page='.$next_page.'"><span class="page"><img src="'.PATH_IMAGE_END.'btn_next.gif" alt="next" /></span></a>'.PHP_EOL;
        $tail_page .= '     <a href="'.PATH_HOME.'?'.$next_path.'&page='.$next_page.'"><span class="page">></span></a>'.PHP_EOL;
//        $tail_page .= '     <span class="page"><a href="'.PATH_HOME.'?'.$next_path.'&page='.$total_page.'"><img src="'.PATH_IMAGE_END.'btn_next_end.gif" alt="next end" /></a></span>'.PHP_EOL;
//        $tail_page .= '     <a href="'.PATH_HOME.'?'.$next_path.'&page='.$total_page.'"><span class="page"><img src="'.PATH_IMAGE_END.'btn_next_end.gif" alt="next end" /></span></a>'.PHP_EOL;
        $tail_page .= '     <a href="'.PATH_HOME.'?'.$next_path.'&page='.$total_page.'"><span class="page">>></span></a>'.PHP_EOL;
    }
    return $tail_page;
}
?>
                        <div class="paginate">
<?
echo page2($total_data,$list_page,$page_per_list,$page,$next_path);
?>
                        </div>
