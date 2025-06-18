<?php 
if(!defined('_HEROBOARD_'))exit;

include_once '../combined/admin_user_manager.php';

if(!$_GET['page'])		$page = '1';
else						$page = $_GET['page'];
?>
<link rel="stylesheet" type="text/css" href="<?=CSS_END;?>general.css"/>
<link rel="stylesheet" type="text/css" href="<?=PATH_END?>css/admin_login.css" />
<link rel="stylesheet" href="<?=PATH_END?>css/admin.css" type="text/css" />
<script type="text/javascript" src="<?=JS_END;?>jquery.min.js"></script>
<script type="text/javascript" src="<?=JS_END;?>head.js"></script>
<link type='text/css' href='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.css' rel='stylesheet' />
<script type="text/javascript" src="<?=DOMAIN_END?>cal/jquery.min.js"></script>
<script type='text/javascript' src='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.min.js'></script> 
<script>

function goPopup(id){
	var width=800, height=800;
    var left = (screen.availWidth - width)/2;
    var top = (screen.availHeight - height)/2;
    var specs = "width=" + width;
    specs += ",height=" + height;
    specs += ",left=" + left;
    specs += ",top=" + top;
    specs += ",scrollbars=yes"; 
    window.open("pointHistoryPopup.php?hero_id="+id, "popup", specs);
}

</script>
<div id="searchPointArea">
<form action="<?=$_SERVER['PHP_SELF']."?"."board=".$_GET['board']."&idx=".$_GET['idx']?>" name="frm"  id="frm">
	<input type="hidden" name="board"  value="<?=$_GET['board']?>"/> 
	<input type="hidden" name="idx"  value="<?=$_GET['idx']?>"/>
	
	<table>
		<colgroup>
			<col width="100px" />
			<col width="600px"/>
			<col width="*" />
		</colgroup>
			<tr>
				<th>�Ⱓ</th>
				<td colspan="2">
                		<input type="text"  id="sdate1" name="hero_today_start"  value="<?=$_GET['hero_today_start']?>" style="text-align: center"  readonly/> ~ 
                		<input type="text"  id="edate1" name="hero_today_end"  value="<?=$_GET['hero_today_end']?>" style="text-align: center"  readonly/>
                </td>
					<script>
						$(function() {      // window.onload ��� ���� ��ũ��Ʈ
						    dateclick2();
						});
						function dateclick2(){
						    var dates = $("#sdate1, #edate1").datepicker({
						        monthNames: ['�� 1��','�� 2��','�� 3��','�� 4��','�� 5��','�� 6��','�� 7��','�� 8��','�� 9��','�� 10��','�� 11��','�� 12��'],
						        dayNamesMin: ['��', '��', 'ȭ', '��', '��', '��', '��'],
						        defaultDate: null,
						        showMonthAfterYear:true,
						        dateFormat: 'yy-mm-dd',
						        onSelect: function( selectedDate ) {
						            var option = this.id == "sdate1" ? "minDate" : "maxDate",
						            instance = $( this ).data( "datepicker" ),
						            date = $.datepicker.parseDate(
						                instance.settings.dateFormat ||
							            $.datepicker._defaults.dateFormat,
							            selectedDate, instance.settings );
							        dates.not( this ).datepicker( "option", option, date );
								}
							});
						};
					</script>
			</tr>
            <tr>
            	<th>ȹ��/����</th>                
                <td colspan="2"><input type="radio" name="pointType"  id="pointAll" value="All" style="width:26px;" <?if($_GET['pointType']=="" || $_GET['pointType']=="All" ) echo checked;?>/><label for="pointAll">��ü</label> 
                    <input type="radio" name="pointType"  id="pointPlus" value="Plus" style="width:26px;" <?if($_GET['pointType']=="Plus" ) echo checked;?>/><label for="pointPlus">ȹ��</label> 
                    <input type="radio" name="pointType"  id="pointMinus" value="Minus" style="width:26px;" <?if($_GET['pointType']=="Minus" ) echo checked;?>/><label for="pointMinus">����</label>
                    (���ѵ� ����Ʈ <input type="checkbox" name="pointLimit" value="Y" style="width:26px;" <? if($_GET['pointLimit']=="Y") echo checked;?> />)
                </td>
            </tr>
			<tr>
				
				<th>�����˻�</th>
				<td>
					<select name="selectValue">
						<option value="id" <? echo $_GET['selectValue'] == "id" ? "selected" : ""?>>���̵�</option>
						<option value="name" <? echo $_GET['selectValue'] == "name" ? "selected" : ""?>>����</option>
						<option value="nick" <? echo $_GET['selectValue'] == "nick" ? "selected" : ""?>>�г���</option>
					</select>
					&nbsp;
					<input type="text" name="textValue" id="textValue" value="<?=$_GET['textValue']?>"/>
					<script>
					$(function() { 
						$('#textValue').keyup(function(e) {
						    if (e.keyCode == 13) $("#frm").submit();       
						});
					});
					</script>
				</td>
				<td align="right" ><div onclick="$('#frm').submit();" style="width:150px; cursor:pointer;height: 25px;padding: 10px 7px 2px 7px;background: #376EA6;color:white;text-align:center;font-size:13px;">�� ��</div></td>
			</tr>
	</table>
</form>
</div>
<?php 
// �˻����� ����
$hero_today_start = $_GET['hero_today_start'];
$hero_today_end = $_GET['hero_today_end'];
$selectValue = $_GET['selectValue'];
$textValue = $_GET['textValue'];

$pointType = $_GET['pointType'];
$pointLimit = $_GET['pointLimit'];

$search = "";
$next_path = "";

$next_path="board=".$_GET['board']."&idx=".$_GET['idx'];
if($hero_today_start && $hero_today_end){
	$search .= "and date_format(`hero_today`,'%Y-%m-%d') between '".$hero_today_start."' and '".$hero_today_end."' ";
	$next_path .= "&hero_today_start=".$hero_today_start."&hero_today_end=".$hero_today_end;
}
if($selectValue && $textValue){
	if($selectValue == "id"){
		$search .= "and hero_id like '%".$textValue."%' ";
	}else if($selectValue == "name"){
		$search .= "and hero_name like '%".$textValue."%' ";
	}else if($selectValue == "nick"){
		$search .= "and hero_nick like '%".$textValue."%' ";
	}
	$next_path .= "&selectValue=".$selectValue."&textValue=".$textValue;
}

if($pointType){
	if($pointType == 'Plus') $search .=" and hero_point > 0 ";
	else if($pointType == 'Minus') $search .=" and hero_point < 0 ";
	
	$next_path .= "&pointType=".$pointType;
}

if($pointLimit == "Y") {
	$search .= " and hero_include_maxpoint = 'Y' ";
	$next_path .= "&pointLimit=".$pointLimit;
}


// ����¡�� ���� ����Ÿ �� ����
$sql = "select hero_code from point where 1=1 ".$search;
$out_sql = mysql_query($sql);
$total_data = @mysql_num_rows($out_sql);

if($_GET['page']!=''){
	$NO = $total_data-(($_GET['page']-1)*$list_page);
	$page = $_GET['page'];
	
}else{
	$page = '1';
	$NO = $total_data;
}

$start = ($page-1)*$list_page;

?>
<div id="resultPointArea">
	<p>�� :<?=number_format($total_data)?>��</p>
	
	<table>
		<colgroup>
			<col width="200px" />
			<col width="200px" />
			<col width="100px" />
			<col width="150px" />
			<col width="100px" />
			<col width="100px" />
			<col width="*" />
			<col width="100px" />
		</colgroup>

		<tr>
			<th>������</th>
			<th>���̵�</th>
			<th>����</th>
			<th>�г���</th>
			<th>����Ʈ ���� ����</th>
			<th>ȹ��/����</th>
			<th>����</th>
			<th>����Ʈ</th>
		</tr>
		<?
		
		// �Խ��� ����
		$sql = " select hero_type, hero_mission_idx, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today, hero_include_maxpoint, edit_hero_code ";
		$sql .= " ,(select hero_title from mission where hero_idx = p.hero_mission_idx ) as  mission_title ";
		$sql .="from point p ";
		$sql .="where 1=1 ".$search." ";
		$sql .="order by hero_idx desc ";
		$sql .="limit ".$start.",".$list_page."";
		//echo $sql;
		$out_sql = mysql_query($sql);	
		
		if($total_data == 0){
        ?>	
       <tr><td colspan="8">�˻� ����� �����ϴ�.</td></tr>
        <? 
         } else{
	           while($list = @mysql_fetch_assoc($out_sql)){
		           $hero_type = $list['hero_type'];
		           $hero_old_idx = $list['hero_old_idx'];
		           $hero_mission_idx = $list['hero_mission_idx'];
		           $hero_review_idx = $list['hero_review_idx'];
		           $hero_id = $list['hero_id'];
		           $hero_top_title = $list['hero_top_title'];
		           $hero_title = $list['hero_title'];
		           $hero_point = $list['hero_point'];
		           $edit_hero_code = $list['edit_hero_code'];
		           
	    ?>
		<tr>
			<td><?=$list['hero_today']?></td>
			<td><a href="javascript:goPopup('<?=$list['hero_id']?>')"><?=$list['hero_id']?></a></td>
			<td><?=name_masking($list['hero_name'])?></td>
			<td><?=$list['hero_nick']?></td>
			<td><? echo $list['hero_include_maxpoint'] == "Y" ? "����" : "���Ѿ���"?></td>
			<td>
				<? if($list['hero_point'] != 0) echo $list['hero_point'] > 0 ? "ȹ��" : "����";
					else echo "-"?>
			</td>
			<td style="text-align:left;">
		        <!-- Ÿ��, �Խ��ǹ�ȣ, �̼ǹ�ȣ, �����ȣ, ���̵�, �Խ����̸�, ����Ʈ�̸�, ����Ʈ -->
				<?=pointHistoryContent($hero_type, $hero_old_idx, $hero_mission_idx, $hero_review_idx, $hero_id, $hero_top_title, $hero_title, $hero_point, $edit_hero_code);?>
			</td>
			<td><?=$list['hero_point']?>��</td>
		</tr>
		<? } //end while
	      } //end if?>
	</table>
</div>

		<div style="width:98%;"><? include_once PATH_INC_END.'page.php';?></div>
     	
     	<script>
	     	function ch_page(page){
		     	location.href="<?=PATH_HOME.'?board='.$_GET['board'].'&idx='.$_GET['idx'].'&page='?>"+page+"<?=$search_next?>";
	     	}
     	</script>          


    
    