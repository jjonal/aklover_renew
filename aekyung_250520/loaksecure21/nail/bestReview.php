<?  if(!defined('_HEROBOARD_'))exit;

//�̴��� Ak Lover���� ����
if($_POST["type"] == "write") {
    //monthak_manager�� Auto_increment�� ���ؼ� monthak�� hero_old_idx�� �ֱ�����
    $sql_idx = "SHOW TABLE STATUS WHERE name = 'monthak_manager'";
    $out_res  = @mysql_query($sql_idx);

    $res = mysql_fetch_assoc($out_res);
    $hero_old_idx = $res["Auto_increment"];
    
    //�̴��� Ak Lover������ �Է�
    $sql =  " INSERT INTO monthak_manager (hero_idx, hero_code, hero_title, startdate, enddate, hero_today, hero_use) VALUES ";
    $sql .= " ('".$hero_old_idx."', '".$_SESSION["temp_code"]."','".$_POST["hero_title"]."','".$_POST["startdate"]."','".$_POST["enddate"]."',now(), '0') ";
    mysql_query ( $sql );

    //���ڿ��� �Ѿ�� ������ �ο� �迭ȭ
    $board_hero_idx = explode('|', $_POST['board_hero_idx']);
    //������ �ο� ������ �Է�
    for($i = 0; $i < count($board_hero_idx)-1; $i++) {
        $sql_list =  " INSERT INTO monthak ( hero_code, hero_old_idx, board_hero_idx, hero_today, hero_order, hero_use) VALUES ";
        $sql_list .= " ('".$_SESSION["temp_code"]."','".$hero_old_idx."','".$board_hero_idx[$i]."',now(), '".($i+1)."', '0') ";
        mysql_query ( $sql_list );
    }
    msg ( '��� �Ǿ����ϴ�.', 'location.href="' . PATH_HOME . '?' . get ( 'type||view', '' ) . '"' );
    exit ();
}

//�˻���
$search = "";

$select_02 = $_REQUEST['select_02'];
//��¥ �˻�
if($_REQUEST['select_02'] != '' && $_GET["startDate"] && $_GET["endDate"]){
    if($select_02=='request'){
        $search .= " AND ( (date_format(m.hero_today_01_01,'%Y-%m-%d') <= '".$_GET["startDate"]."' AND date_format(m.hero_today_01_02,'%Y-%m-%d')>='".$_GET["startDate"]."' )";
        $search .= " || (date_format(m.hero_today_01_01,'%Y-%m-%d') <= '".$_GET["endDate"]."' AND date_format(m.hero_today_01_02,'%Y-%m-%d')>='".$_GET["endDate"]."' )";
        $search .= " || (date_format(m.hero_today_01_01,'%Y-%m-%d') >= '".$_GET["startDate"]."' AND date_format(m.hero_today_01_02,'%Y-%m-%d')<='".$_GET["endDate"]."' ))";
    }else if($select_02=='release'){
        $search .= " AND ( (date_format(m.hero_today_02_01,'%Y-%m-%d') <= '".$_GET["startDate"]."' AND date_format(m.hero_today_02_02,'%Y-%m-%d')>='".$_GET["startDate"]."' )";
        $search .= " || (date_format(m.hero_today_02_01,'%Y-%m-%d') <= '".$_GET["endDate"]."' AND date_format(m.hero_today_02_02,'%Y-%m-%d')>='".$_GET["endDate"]."' )";
        $search .= " || (date_format(m.hero_today_02_01,'%Y-%m-%d') >= '".$_GET["startDate"]."' AND date_format(m.hero_today_02_02,'%Y-%m-%d')<='".$_GET["endDate"]."' ))";
    }else if($select_02=='enroll'){
        $search .= " AND ( (date_format(m.hero_today_03_01,'%Y-%m-%d') <= '".$_GET["startDate"]."' AND date_format(m.hero_today_03_02,'%Y-%m-%d')>='".$_GET["startDate"]."' )";
        $search .= " || (date_format(m.hero_today_03_01,'%Y-%m-%d') <= '".$_GET["endDate"]."' AND date_format(m.hero_today_03_02,'%Y-%m-%d')>='".$_GET["endDate"]."' )";
        $search .= " || (date_format(m.hero_today_03_01,'%Y-%m-%d') >= '".$_GET["startDate"]."' AND date_format(m.hero_today_03_02,'%Y-%m-%d')<='".$_GET["endDate"]."' ))";
    }else if($select_02=='best'){
        $search .= " AND ( (date_format(m.hero_today_04_01,'%Y-%m-%d') <= '".$_GET["startDate"]."' AND date_format(m.hero_today_04_02,'%Y-%m-%d')>='".$_GET["startDate"]."' )";
        $search .= " || (date_format(m.hero_today_04_01,'%Y-%m-%d') <= '".$_GET["endDate"]."' AND date_format(m.hero_today_04_02,'%Y-%m-%d')>='".$_GET["endDate"]."' )";
        $search .= " || (date_format(m.hero_today_04_01,'%Y-%m-%d') >= '".$_GET["startDate"]."' AND date_format(m.hero_today_04_02,'%Y-%m-%d')<='".$_GET["endDate"]."' ))";
    }
}
//�˻���
if($_GET["kewyword"] != "") {
    if ($_GET['select'] == 'hero_nick') {
        $search .= " AND mb.hero_nick like '%" . $_GET["kewyword"] . "%' ";
    } else {
        $search .= " AND m.hero_title like '%" . $_GET["kewyword"] . "%' ";
    }
}
//�������� ����
$hero_groupArr = array_map(create_function('$item', 'return "\'" . $item . "\'";'), $_GET['hero_group']);
$hero_group = implode(',', $hero_groupArr);

$hero_groupArrNext = array_map(create_function('$item', 'return $item;'), $_GET['hero_group']);
$hero_groupNext = implode(',', $hero_groupArrNext);
$search_group = "";

for($i=0;$i<count($hero_groupArrNext);$i++) {
    $search_group .= "&hero_group[]=".$hero_groupArrNext[$i];
}

if($hero_group != '\'\'' && $hero_group != '') {
    $search .= " AND b.hero_table in (".$hero_group.")";
}else {
    $search .= " AND b.hero_table in ('group_04_05','group_04_06','group_04_28') ";
}
//��� ������
if($_GET["best"] != ""){
    $search .= " AND IF(IFNULL(b.hero_board_three,0) = '1','Y','N') = '".$_GET["best"]."'";
}
//�ؿ�� ������
if($_GET["semi_best"] != ""){
    $search .= " AND IF(IFNULL(b.hero_board_three,0) = '2','Y','N') = '".$_GET["semi_best"]."'";
}
//ORDER BY
if (! strcmp ( $_GET ['order'], '' )) {
    $order = ' ORDER BY b.hero_today DESC';
} else {
    $order = ' ORDER BY ' . $_GET ['order'];
}

//�� ����
$total_sql  = " SELECT count(*) cnt";
$total_sql .= " FROM board b ";
$total_sql .= " JOIN mission m ON m.hero_idx = b.hero_01 ";
$total_sql .= " JOIN member mb ON mb.hero_code = b.hero_code ";
$total_sql .= " WHERE 1=1 ".$search;
$total_sql .= " AND b.hero_table in ('group_04_05','group_04_06','group_04_28') ";

sql($total_sql);

$out_res = mysql_fetch_assoc($out_sql);
$total_data = $out_res['cnt'];

$i=$total_data;
//��¼� ����Ʈ 250
$list_page=$_REQUEST['list_count']==""?250:$_REQUEST['list_count'];
//$list_page=$_REQUEST['list_count']==""?5:$_REQUEST['list_count'];
$page_per_list=10;

if(!strcmp($_GET['page'], '')) {
	$page = '1';
} else {
	$page = $_GET['page'];
	$i = $i-($page-1)*$list_page;
}

$start = ($page-1)*$list_page;
$next_path=get("page");
$next_path = str_replace("&hero_group=Array",$search_group,$next_path);

//����Ʈ
$sql  = " SELECT b.hero_idx, mb.hero_level, mb.hero_nick, b.hero_title AS review_title, m.hero_title AS mission_title, b.hero_today, ";
$sql .= " b.hero_board_three, IF(IFNULL(b.hero_board_three,0) = '1','Y','N') AS best, IF(IFNULL(b.hero_board_three,0) = '2','Y','N') AS semi_best, ";
$sql .= " m.hero_table, ";
$sql .= " m.hero_today_01_01, m.hero_today_01_02, ";
$sql .= " m.hero_today_02_01, m.hero_today_02_02, ";
$sql .= " m.hero_today_03_01, m.hero_today_03_02, ";
$sql .= " m.hero_today_04_01, m.hero_today_04_02, ";
$sql .= " m.hero_today_05_01, m.hero_today_05_02 ";
$sql .= " FROM board b ";
$sql .= " JOIN mission m ON m.hero_idx = b.hero_01 ";
$sql .= " JOIN member mb ON mb.hero_code = b.hero_code ";
$sql .= " WHERE 1=1 ".$search.$order;
$sql .= " LIMIT ".$start.",".$list_page;

$list_res = sql($sql);
$list_cnt = mysql_num_rows($list_res);
?>
<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
<input type="hidden" name="board" value="<?=$_GET["board"]?>" />
<input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
<input type="hidden" name="page" value="<?=$page?>" />
<h4>�̴��� AK Lover �˻�</h4>

<div class="form_container">
	<div class="apply_btn">
		����
	</div>
	<table class="searchBox">
		<colgroup>
			<col width="171px" />
			<col width="*" />
		</colgroup>
		<tr>
			<th>
				��¥ �˻�
			</th>
			<td>
				<div class="search_inner">
					<div class="select-wrap">
						<select name="select_02">
							<option value="">ü��ܱⰣ ����</option>
							<option value="request" <?php echo ($select_02=="request")? "selected='selected'" : ""; ?>>ü��� ��û</option>
							<option value="release" <?php echo ($select_02=="release")? "selected='selected'" : ""; ?>>ü��� ��ǥ</option>
							<option value="enroll" <?php echo ($select_02=="enroll")? "selected='selected'" : ""; ?>>�ı� ���</option>
							<option value="best" <?php echo ($select_02=="best")? "selected='selected'" : ""; ?>>����ı� ��ǥ</option>
						</select>
					</div>
					<input type="text" id="sdate" name="startDate" value="<?=$_GET["startDate"]?>" readonly/>
					<div class="inner_between">~</div>
					<input type="text" id="edate" name="endDate" value="<?=$_GET["endDate"]?>" readonly/>
					<div class="add_icon">
						<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M1.46294 5.86456C1.46294 3.84025 3.10038 2.19922 5.12026 2.19922H12.4349C14.4548 2.19922 16.0922 3.84025 16.0922 5.86456V12.4622C16.0922 14.4865 14.4548 16.1275 12.4349 16.1275H5.12026C3.10038 16.1275 1.46294 14.4865 1.46294 12.4622V5.86456ZM5.12026 3.66536C3.90833 3.66536 2.92587 4.64998 2.92587 5.86456V12.4622C2.92587 13.6768 3.90833 14.6614 5.12026 14.6614H12.4349C13.6468 14.6614 14.6293 13.6768 14.6293 12.4622V5.86456C14.6293 4.64998 13.6468 3.66536 12.4349 3.66536H5.12026Z" fill="white"/>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M5.85172 1.46631C6.2557 1.46631 6.58318 1.79451 6.58318 2.19938V4.39858C6.58318 4.80345 6.2557 5.13165 5.85172 5.13165C5.44774 5.13165 5.12025 4.80345 5.12025 4.39858V2.19938C5.12025 1.79451 5.44774 1.46631 5.85172 1.46631Z" fill="white"/>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M11.7034 1.46631C12.1074 1.46631 12.4349 1.79451 12.4349 2.19938V4.39858C12.4349 4.80345 12.1074 5.13165 11.7034 5.13165C11.2995 5.13165 10.972 4.80345 10.972 4.39858V2.19938C10.972 1.79451 11.2995 1.46631 11.7034 1.46631Z" fill="white"/>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M8.77757 6.59766C9.18155 6.59766 9.50904 6.92586 9.50904 7.33073V8.79686H10.972C11.3759 8.79686 11.7034 9.12507 11.7034 9.52993C11.7034 9.93479 11.3759 10.263 10.972 10.263H9.50904V11.7291C9.50904 12.134 9.18155 12.4622 8.77757 12.4622C8.3736 12.4622 8.04611 12.134 8.04611 11.7291L8.04611 10.263H6.58318C6.1792 10.263 5.85172 9.93479 5.85172 9.52993C5.85172 9.12507 6.1792 8.79686 6.58318 8.79686H8.04611V7.33073C8.04611 6.92586 8.3736 6.59766 8.77757 6.59766Z" fill="white"/>
						</svg>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<th>�˻���</th>
			<td>
				<div class="search_inner">
					<div class="select-wrap">
						<select name="select">
							<option value="hero_nick" <?=$_GET["select"] == "hero_nick" ? "selected" : "" ?>>�г���</option>
							<option value="hero_title" <?=$_GET["select"] == "hero_title" ? "selected" : "" ?>>ü��ܸ�</option>
						</select>
					</div>
					<input class="search_txt" type="text" name="kewyword" value="<?=$_GET["kewyword"]?>"/>
				</div>
			</td>
		</tr>
		<tr>
			<th>�������� ����</th>
			<td>
				<div class="search_inner sup">
					<label class="akContainer">��ü
                        <input type="checkbox" <?=($_GET['all'] == 'check' || $_GET['all'] == '') && $hero_group == '' ? 'checked' : ''?> name="all" value="check">
					    <span class="checkmark"></span>
					</label>
					<label class="akContainer">������ ��Ƽ & ������ Ŭ��
    					<input type="checkbox" <?=strpos($hero_group,'group_04_05') ? 'checked' : ''?> name="hero_group[]" value="group_04_05">
    					<span class="checkmark"></span>
					</label>
					<label class="akContainer">�����̾� ��Ƽ Ŭ��
					    <input type="checkbox" <?=strpos($hero_group,'group_04_06') ? 'checked' : ''?> name="hero_group[]" value="group_04_06">
					    <span class="checkmark"></span>
					</label>
					<label class="akContainer">�����̾� ������ Ŭ��
                        <input type="checkbox" <?=strpos($hero_group,'group_04_28') ? 'checked' : ''?> name="hero_group[]" value="group_04_28">
                        <span class="checkmark"></span>
					</label>
				</div>
			</td>
		</tr>
		<tr>
			<th>��� ������</th>
			<td>
				<div class="search_inner">
					<label class="akContainer">��ü
                        <input type="radio" <?=$_GET["best"] == "" ? "checked" : ""?> name="best" value="">
                        <span class="checkmark"></span>
					</label>
					<label class="akContainer">����
                        <input type="radio" <?=$_GET["best"] == "Y" ? "checked" : ""?> name="best" value="Y">
                        <span class="checkmark"></span>
					</label>
					<label class="akContainer">�̼���
                        <input type="radio" <?=$_GET["best"] == "N" ? "checked" : ""?> name="best" value="N">
                        <span class="checkmark"></span>
					</label>
				</div>
			</td>
		</tr>
		<tr>
			<th>�ؿ�� ������</th>
			<td>
				<div class="search_inner">
					<label class="akContainer">��ü
                        <input type="radio" <?=$_GET["semi_best"] == "" ? "checked" : ""?> name="semi_best" value="">
                        <span class="checkmark"></span>
					</label>
					<label class="akContainer">����
                        <input type="radio" <?=$_GET["semi_best"] == "Y" ? "checked" : ""?> name="semi_best" value="Y">
                        <span class="checkmark"></span>
					</label>
					<label class="akContainer">�̼���
                        <input type="radio" <?=$_GET["semi_best"] == "N" ? "checked" : ""?> name="semi_best" value="N">
                        <span class="checkmark"></span>
					</label>
				</div>
			</td>
		</tr>
	</table>
</div>
<div class="btnGroupSearch_box">
	<div class="btnGroupSearch">
		<a href="javascript:;" onClick="fnSearch()" class="btnSearch">�˻�</a>
	</div>
</div>

<div class="searchCnt">
	<h4>�� <?=number_format($total_data)?> ��</h4>
	<div class="">
        <span>���� : </span>
		<span class="chkCnt">0</span>
		<span>|</span>
		<span class="allCnd">20</span>
        <span>* �̴��� AK Lover�� �ִ� 20����� ������ �� �ֽ��ϴ�.</span>
	</div>
</div>

<div class="searchResultBox_container">
	<div class="searchResultBox_BtnGroup">
        <a class="btnAdd" onClick="fnExcel();">������ �ĺ� ��� �ٿ�ε�</a>
	</div>
	<table class="searchResultBox">
		<colgroup>
			<col width="45px" />
			<col width="45px" />
			<col width="158px" />
			<col width="105px" />
			<col width="250px" />
			<col width="216px" />
			<col width="112px" />
			<col width="75px" />
			<col width="89px" />
			<col width="77px" />
		</colgroup>
		<tr>
			<th>
				<div class="">
					<label class="akContainer">
						<input type="checkbox" name="all">
						<span class="checkmark"></span>
					</label>
				</div>
			</th>
			<th>
				<div class="">
					NO
				</div>
			</th>
			<th>
				<div class="">
					ȸ�� ����
				</div>
			</th>
            <?
            // �г���
            if($_GET['order'] == 'mb.hero_nick desc') $order_nick = "order=mb.hero_nick asc";
            else                                      $order_nick = "order=mb.hero_nick desc";
            // ������ Ÿ��Ʋ��
            if($_GET['order'] == 'b.hero_title desc') $order_review = "order=b.hero_title asc";
            else                                      $order_review = "order=b.hero_title desc";
            // ü��ܸ�
            if($_GET['order'] == 'm.hero_title desc') $order_mission = "order=m.hero_title asc";
            else                                      $order_mission = "order=m.hero_title desc";
            // ������ �����
            if($_GET['order'] == 'b.hero_today desc') $order_today = "order=b.hero_today asc";
            else                                      $order_today = "order=b.hero_today desc";
            ?>
            <!-- sort �� ���� p�±׿� class="sort" �־��ֽ� �˴ϴ�! �ϴ� p�±� ���� -->
			<th>
				<div class="nick" onclick="location.href='<?=PATH_HOME.'?'.get('order', $order_nick);?>'">
					<p class="<?=$_GET['order'] == 'mb.hero_nick desc' ? 'sort' : ''?>">
                        �г���
					</p>
				</div>
			</th>
			<th>
				<div class="contTit" onclick="location.href='<?=PATH_HOME.'?'.get('order', $order_review);?>'">
                    <p class="<?=$_GET['order'] == 'b.hero_title desc' ? 'sort' : ''?>">
                        ������ Ÿ��Ʋ��
                    </p>
				</div>
			</th>
			<th>
				<div class="goName" onclick="location.href='<?=PATH_HOME.'?'.get('order', $order_mission);?>'">
					<p class="<?=$_GET['order'] == 'm.hero_title desc' ? 'sort' : ''?>">
						ü��ܸ�
					</p>
				</div>
			</th>
			<th>
				<div class="contCreate" onclick="location.href='<?=PATH_HOME.'?'.get('order', $order_today);?>'">
					<p class="<?=$_GET['order'] == 'b.hero_today desc' ? 'sort' : ''?>">
						������ �����
					</p>
				</div>
			</th>
			<th>
				<div class="">
                    ��� ������
				</div>
			</th>
			<th>
				<div class="">
					�ؿ�� ������
				</div>
			</th>
			<th>
				<div class="">
					������ URL
				</div>
			</th>
		</tr>
		<? while($list =  mysql_fetch_assoc($list_res) ){
			//ȸ�����
			if($list['hero_level'] == '9994'){
				$member_grade = '�����̾� ������ Ŭ��';
			}else if($list['hero_level'] == '9996'){
				$member_grade = '�����̾� ��Ƽ Ŭ��';
			}else {
				$member_grade = '������ ��Ƽ&������ Ŭ��';
			}
			//��� ������
			if($list['best'] == 'Y') $best = '����';
			else $best = '�̼���';

			//�ؿ�� ������
			if($list['semi_best'] == 'Y') $semi_best = '����';
			else $semi_best = '�̼���';
			?>
			<tr>
			<td>
				<div class="table_checkbox" style="position:relative">
					<label class="akContainer">
						<input type="checkbox" name="hero_idx" value="<?=$list['hero_idx']?>">
						<span class="checkmark"></span>
					</label>
				</div>
			</td>
			<td>
				<div class="table_result_no">
					<?=$i?>
				</div>
			</td>
			<td>
				<div class="table_result_types">
					<?=$member_grade?>
				</div>
			</td>
			<td>
				<div class="table_result_nick">
					<?=$list['hero_nick']?>
				</div>
			</td>
			<td>
				<div class="table_result_tit">
					<?=$list['review_title']?>
				</div>
			</td>
			<td>
				<div class="table_result_name">
					<?=$list['mission_title']?>
				</div>
			</td>
			<td>
				<div class="table_result_create">
					<?=$list['hero_today']?>
				</div>
			</td>
			<td>
				<div class="table_result_btn01">
					<div class="table_result_btn_yn <?=$best == '����' ? 'active' : ''?>">
						<?=$best?>
					</div>
				</div>
			</td>
			<td>
				<div class="table_result_btn02">
					<div class="table_result_btn_yn <?=$semi_best == '����' ? 'active' : ''?>">
						<?=$semi_best?>
					</div>
				</div>
			</td>
			<td>
				<div class="table_result_btn03" data-idx="<?=$list['hero_idx']?>">
					<p class="icon_box active">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M5.83335 3.33317C4.45264 3.33317 3.33335 4.45246 3.33335 5.83317V14.1665C3.33335 15.5472 4.45264 16.6665 5.83335 16.6665H14.1667C15.5474 16.6665 16.6667 15.5472 16.6667 14.1665V10.8332C16.6667 10.3729 17.0398 9.99984 17.5 9.99984C17.9603 9.99984 18.3334 10.3729 18.3334 10.8332V14.1665C18.3334 16.4677 16.4679 18.3332 14.1667 18.3332H5.83335C3.53217 18.3332 1.66669 16.4677 1.66669 14.1665V5.83317C1.66669 3.53198 3.53217 1.6665 5.83335 1.6665H9.16669C9.62692 1.6665 10 2.0396 10 2.49984C10 2.96007 9.62692 3.33317 9.16669 3.33317H5.83335Z" fill="black"/>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M18.0893 1.91058C18.4147 2.23602 18.4147 2.76366 18.0893 3.08909L10.5893 10.5891C10.2638 10.9145 9.7362 10.9145 9.41076 10.5891C9.08533 10.2637 9.08533 9.73602 9.41076 9.41058L16.9108 1.91058C17.2362 1.58514 17.7638 1.58514 18.0893 1.91058Z" fill="black"/>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M11.6667 2.49984C11.6667 2.0396 12.0398 1.6665 12.5 1.6665H17.5C17.9603 1.6665 18.3334 2.0396 18.3334 2.49984V7.49984C18.3334 7.96007 17.9603 8.33317 17.5 8.33317C17.0398 8.33317 16.6667 7.96007 16.6667 7.49984V3.33317H12.5C12.0398 3.33317 11.6667 2.96007 11.6667 2.49984Z" fill="black"/>
						</svg>
					</p>
				</div>
			</td>
		</tr>
		<?$i--; }?>
	</table>
</div>

<div class="btnGroupFunction">
	<div class="rightWrap">
		<select name="list_count" onchange="fnListCount()">
        	<option value="">��� ��</option>
            <option value="20"<?if(!strcmp($_REQUEST['list_count'], '20')){echo ' selected';}else{echo '';}?>>20��</option>
        	<option value="30"<?if(!strcmp($_REQUEST['list_count'], '30')){echo ' selected';}else{echo '';}?>>30��</option>
	        <option value="50"<?if(!strcmp($_REQUEST['list_count'], '50')){echo ' selected';}else{echo '';}?>>50��</option>
            <option value="100"<?if(!strcmp($_REQUEST['list_count'], '100')){echo ' selected';}else{echo '';}?>>100��</option>
            <option value="250"<?if(!strcmp($_REQUEST['list_count'], '250')){echo ' selected';}else{echo '';}?>>250��</option>
		</select>
	</div>
</div>
</form>

<div class="pagingWrap remaking">
    <? include_once PATH_INC_END.'page.php';?>
</div>

<!--������ URL �˾�-->
<div class="popup_url_box">
	<div class="popup_url_cont">
		<div class="popup_url_head">
			<svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M4.41073 4.41083C4.73617 4.08539 5.26381 4.08539 5.58925 4.41083L15.5892 14.4108C15.9147 14.7363 15.9147 15.2639 15.5892 15.5893C15.2638 15.9148 14.7362 15.9148 14.4107 15.5893L4.41073 5.58934C4.0853 5.2639 4.0853 4.73626 4.41073 4.41083Z" fill="black"/>
				<path fill-rule="evenodd" clip-rule="evenodd" d="M15.5892 4.41083C15.2638 4.08539 14.7362 4.08539 14.4107 4.41083L4.41072 14.4108C4.08529 14.7363 4.08529 15.2639 4.41072 15.5893C4.73616 15.9148 5.2638 15.9148 5.58924 15.5893L15.5892 5.58934C15.9147 5.2639 15.9147 4.73626 15.5892 4.41083Z" fill="black"/>
			</svg>
		</div>
		<div class="popup_url_body">
			<div class="tit">�ı� URL Ȯ��</div>
			<div class="popup_url_table">
                <!--DB����-->
			</div>
			<div class="popup_url_link">
                <!--DB����-->
			</div>
		</div>
	</div>
</div>

<!--���� �˾�-->
<form name="manageForm" id="manageForm" action="<?=PATH_HOME.'?'.get('','type=write');?>" method="post">
    <input type="hidden" id="board_hero_idx" name="board_hero_idx" valie="" />
    <input type="hidden" name="type" id="type" value="" />
    <div class="popup_apply_box">
        <div class="popup_apply_cont">
            <div class="popup_apply_head">
                <svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.41073 4.41083C4.73617 4.08539 5.26381 4.08539 5.58925 4.41083L15.5892 14.4108C15.9147 14.7363 15.9147 15.2639 15.5892 15.5893C15.2638 15.9148 14.7362 15.9148 14.4107 15.5893L4.41073 5.58934C4.0853 5.2639 4.0853 4.73626 4.41073 4.41083Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5892 4.41083C15.2638 4.08539 14.7362 4.08539 14.4107 4.41083L4.41072 14.4108C4.08529 14.7363 4.08529 15.2639 4.41072 15.5893C4.73616 15.9148 5.2638 15.9148 5.58924 15.5893L15.5892 5.58934C15.9147 5.2639 15.9147 4.73626 15.5892 4.41083Z" fill="black"/>
                </svg>
            </div>
            <div class="popup_apply_body">
                <div class="tit">�̴��� AK Lover ����</div>
                <div class="popup_apply_item">
                    <div class="popup_apply_item_top">
                        <p>�̴��� AK Lover ������</p>
                        <input type="text" id="hero_title" name="hero_title" />
                        <span>* �ش� �������� ����� ȭ�鿡 ������� �ʽ��ϴ�.</span>
                    </div>
                </div>
                <div class="popup_apply_item date">
                    <div class="popup_apply_item_top">
                        <p>�̴��� AK Lover ����Ⱓ ����</p>
                        <div class="date_input">
                            <input type="text" id="startdate" name="startdate" />
                            ~
                            <input type="text" id="enddate" name="enddate" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup_apply_btn_box">
                <div class="popup_apply_btn" onClick="goWrite();">
                    �̴��� AK Lover ��� �ϱ�
                </div>
            </div>
        </div>
    </div>
</form>

<!--�޷��� ���� css, js-->
<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/anytime.5.1.2.css">
<script src="<?=ADMIN_DEFAULT?>/js/anytime.5.1.2.js"></script>
<script>
$(document).ready(function(){
    //�̴��� AK Lover ����
    goWrite = function() {
        //üũ�� ����Ʈ �ѱ�� ���ؼ� ���ڿ�ȭ
        var board_hero_idx = "";
        $('input:checkbox[name=hero_idx]').each(function (index) {
            if ($(this).is(":checked") === true) {
                board_hero_idx +=  $(this).val() + "|";
            }
        });

        $("#type").val("write");
        $("#board_hero_idx").val(board_hero_idx );
        $("#manageForm").submit();
    }
    
    //��¥ ����������
    $(function(){
        jQuery("#sdate, #startdate").AnyTime_picker( {
            format: "%Y-%m-%d %H:%i:00"
        });

        jQuery("#edate, #enddate").AnyTime_picker( {
            format: "%Y-%m-%d %H:%i:00"
        });
    });

	fnListCount = function() {
		$("input[name='page']").val(1);
		$("#searchForm").attr("action","").submit();
	}

	fnSearch = function() {
		$("input[name='page']").val(1);
		$("#searchForm").attr("action","").submit();
	}

	fnExcel = function() {
        var board_hero_idx = "";
        $('input:checkbox[name=hero_idx]').each(function (index) {
            if ($(this).is(":checked") === true) {
                board_hero_idx +=  $(this).val() + "|";
            }
        });

        if(board_hero_idx == ""){
            alert("üũ �����ϻ�");
            return;
        }
        window.open('nail/download_member.php?a=b&board_hero_idx='+board_hero_idx);
	}
	
	// select box arrow
	$('.select-wrap').on('click', function(){
		if($(this).hasClass('active')){
			return $(this).removeClass('active');
		}
		$(this).addClass('active');
		$('.select-wrap').not($(this)).removeClass('active');
	});

	// select box arrow close
    $(document).on('click', function(e){
        if(!$(e.target).is('select')){
            $('.select-wrap').removeClass('active');
        }
    });

	// ���� Ŭ��
	$('.searchResultBox th div p').on('click', function(){
		if($(this).hasClass('sort')){
			return $(this).removeClass('sort');
		}
		$(this).addClass('sort');
		$('.searchResultBox th div p').not($(this)).removeClass('sort');
	})

	// �˻� üũ�ڽ� ��ü����
	$('.search_inner.sup :checkbox').on('change', function(){
		const _$this = $(this);
		if(_$this.get(0).name == "all"){
			if(_$this.prop('checked')){
				_$this.parents('.search_inner.sup').each(function(e, index){
					if(index > 19){
						return;
					}
					console.log(index)
					$(this).find(':checkbox').prop('checked', true);
				})
			}
			else{
				_$this.parents('.search_inner.sup').each(function(){
					$(this).find(':checkbox').prop('checked', false);
				})
			}
		}
		else{
			_$this.parents('.search_inner.sup').each(function(){
				const _all = $(this).find(':checkbox[name="all"]');
				const _chk = $(this).find(':checkbox').not(':checkbox[name="all"]');
				if(_chk.length == _chk.filter(':checked').length){
					_all.prop('checked', true);
				}
				else{
					_all.prop('checked', false);
				}
			})
		}
	})

	// ��� üũ�ڽ� ����
	$('.searchResultBox :checkbox').on('change', function(){

		// �ִ� 20�������� ���� ����
		const maxChk = 20;
		const _$this = $(this);
		// ���� üũ�� ����
		let chkCnt = $('.searchResultBox :checkbox:checked').not(':checkbox[name="all"]').length;
		if(chkCnt > maxChk){
			$(this).prop('checked', false);
			return alert('�ִ� '+maxChk+'����� ������ �� �ֽ��ϴ�.');
		}

		if(_$this.get(0).name == "all"){ // ��ü ����
			if(_$this.prop('checked')){
				$('.searchResultBox :checkbox').not(':checkbox:checked').each(function(index){
					if(chkCnt >= maxChk){
						return false;
					}
					$(this).prop('checked', true);
					chkCnt++;
				})
			}
			else{
				_$this.parents('.searchResultBox').each(function(){
					$(this).find(':checkbox').prop('checked', false);
				})
			}
		}
		else{
			_$this.parents('.searchResultBox').each(function(){
				const _all = $(this).find(':checkbox[name="all"]');
				const _chk = $(this).find(':checkbox').not(':checkbox[name="all"]');
				if(_chk.filter(':checked').length == 20){
					_all.prop('checked', true);
				}
				else{
					_all.prop('checked', false);
				}
			})
		}

		// üũ�� ���� ǥ��
		$('.chkCnt').text($('.searchResultBox :checkbox:checked').not(':checkbox[name="all"]').length);

	})
	// url �˾�
	$('.table_result_btn03').on('click', function(){
        //�ı� URL �˾�������
        // �˾� ���
        popupData.call(this, 'top', '.popup_url_table');
        // �˾� �ϴ�
        popupData.call(this, 'bot', '.popup_url_link');

		$('.popup_url_box').addClass('show');
	})
	// url �˾� �ݱ�
	$('.popup_url_head .close').on('click', function(){
		$('.popup_url_box').removeClass('show');
	})

	// ���� �˾�
	$('.apply_btn').on('click', function(){
		$('.popup_apply_box').addClass('show');
	})
	// ���� �˾� �ݱ�
	$('.popup_apply_head .close').on('click', function(){
		$('.popup_apply_box').removeClass('show');
	})
	// ���� �˾� confirm
	$('.popup_apply_btn').on('click', function(){
		$('.popup_apply_box').removeClass('show');
	})
})
//�ı� URL �˾�������
function popupData(location, divName) {
    $.ajax({
        url: "/loaksecure21/nail/bestReviewUrl.php",
        data: {
            hero_idx: $(this).data("idx"),
            location: location,
        },
        type: "POST",
        dataType: "html",
        success: function(data) {
            $(divName).html(data);
        },
        error: function(e) {
            console.log(e);
        }
    });
}

</script>