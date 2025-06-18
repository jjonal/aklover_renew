<?
if(!defined('_HEROBOARD_'))exit;

$table = "monthak_manager";
if (! strcmp ( $_GET ['type'], 'drop' )) {

    $sql = 'UPDATE '.$table.' SET hero_use = 1 WHERE hero_idx = \'' . $_GET ['hero_idx'] . '\';';
    sql ( $sql );

    msg ( '삭제 되었습니다.', 'location.href="' . PATH_HOME . '?' . get ( 'type||hero_idx', '' ) . '"' );
    exit ();
}

$total_sql = " SELECT count(*) cnt FROM monthak_manager WHERE hero_use = 0 ";
sql($total_sql);
$out_res = mysql_fetch_assoc($out_sql);
$total_data = $out_res["cnt"];

$i = $total_data;

$list_page=10;
$page_per_list=5;

if(!strcmp($_GET['page'], ''))		$page = '1';
else								$page = $_GET['page'];

$i = $i-($page-1)*$list_page;

$start = ($page-1)*$list_page;
$next_path=get("page");

$sql = " SELECT hero_idx, hero_title,  startdate, enddate, hero_today FROM monthak_manager WHERE hero_use = 0 ORDER BY hero_idx DESC limit ".$start.",".$list_page;
$list_res = sql($sql);
?>

<div class="searchCnt">
    <h4>총 <?=number_format($total_data)?> 건</h4>
</div>

<form name="next_form" id="next_form">
    <input type="hidden" name="board" value="<?=$_GET["board"]?>" />
    <input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
    <input type="hidden" name="hero_old_idx" id="hero_old_idx" value="" />
    <input type="hidden" name="view" id="view" value="" />
</form>

<table class="searchResultBox">
	<colgroup>
		<col width="85px" />
		<col width="50%" />
		<col width="222px" />
		<col width="73px" />
		<col width="62px" />
		<col width="58px" />
	</colgroup>
	<tr>
		<th>
			<div class="">
				NO
			</div>
		</th>
		<th>
			<div class="">
				이달의 AK Lover 관리명
			</div>
		</th>
		<th>
			<div class="">
			노출기간
			</div>
		</th>
		<th>
			<div class="">
			선정일
			</div>
		</th>
		<th>
			<div class="">
			명단관리
			</div>
		</th>
		<th>
			<div class="">
			삭제여부
			</div>
		</th>
	</tr>
	
	<? 
		if($total_data > 0 ){
		while ($row = @mysql_fetch_assoc($list_res)){
			$row["startdate"] = substr($row["startdate"],0,16);
			$row["enddate"] = substr($row["enddate"],0,16);
			$row["hero_today"] = substr($row["hero_today"],0,10);
		?>
		<tr>
			<td>
				<div class="">
					<?=$i;?>
				</div>
			</td>
			<td>
				<div class="">
					<?=$row["hero_title"]?>
				</div>
			</td>
			<td>
				<div class="">
				<?=$row["startdate"]?> ~ <?=$row["enddate"]?>
				</div>
			</td>
			<td>
				<div class="">
					<?=$row["hero_today"];?>
				</div>
			</td>
			<td>
				<div class="table_result_btn02">
					<div class="table_result_btn_yn active"  onClick="goMomthak('<?=$row["hero_idx"]?>')">
						보기
					</div>
				</div>
			</td>
			<td>
				<div class="table_result_btn03" onclick="javascript:location.href='<?= PATH_HOME . '?' . get('', 'type=drop&hero_idx=' . $row['hero_idx']); ?>'">
					<p class="icon_box">
						<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
							<g opacity="0.4">
							<path d="M5.5 4.5835V17.9335C5.5 18.1544 5.67909 18.3335 5.9 18.3335H16.1C16.3209 18.3335 16.5 18.1544 16.5 17.9335V4.5835" stroke="black" stroke-width="1.5" stroke-linejoin="round"/>
							<path d="M3.66675 4.5835H18.3334" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
							<path d="M8.25 4.58333V3.15C8.25 2.92909 8.42909 2.75 8.65 2.75H13.35C13.5709 2.75 13.75 2.92909 13.75 3.15V4.58333" stroke="black" stroke-width="1.5" stroke-linejoin="round"/>
							<path d="M9.16675 8.25V14.6667" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
							<path d="M12.8333 8.25V14.6667" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
							</g>
						</svg>
					</p>
				</div>
			</td>
		</tr>
		<? 
		$i--;
			}
		} else {?>
		<tr>
			<td colspan="5">등록된 데이터가 없습니다.</td>
		</tr>
		<? }?>
</table>

<div class="pagingWrap">
<? include_once PATH_INC_END.'page.php';?>
</div>
<script>
$(document).ready(function(){
    goMomthak = function(hero_old_idx) {
		$("#view").val("bestReviewHistoryView");
        $("#hero_old_idx").val(hero_old_idx);
		$("#next_form").submit();
	}
})

</script>