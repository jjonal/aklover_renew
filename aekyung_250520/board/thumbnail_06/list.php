<? 
if(!defined('_HEROBOARD_'))exit;

$group_sql = " SELECT * FROM hero_group WHERE hero_order!='0' AND hero_use='1' AND hero_board ='".$_GET['board']."' ";
sql($group_sql);
$right_list = @mysql_fetch_assoc($out_sql);

$startDateOfMonth = date("Y-m")."-01";
$timestamp = strtotime($startDateOfMonth)-1;
$gisu_date = date("Ym", $timestamp);
$gisu_year = substr($gisu_date,0,4);
$gisu_month = substr($gisu_date,4,2);


$loyal_period_sql = " SELECT if(startdate <= date_format(now(),'%Y-%m-%d') AND enddate >= date_format(now(),'%Y-%m-%d'),1,0) as status, hero_month FROM member_loyal_period ";
$loyal_period_res = sql($loyal_period_sql);
$loyal_period_rs = mysql_fetch_assoc($loyal_period_res);

$hero_month = "";
if($loyal_period_rs["hero_month"] > 0) {
    $hero_month = $loyal_period_rs["hero_month"]."�� ";
}

//�̴��� Loyal ȸ��
$review_member_sql =  " SELECT m.hero_nick FROM member_loyal l INNER JOIN member m ON l.hero_code = m.hero_code ";
$review_member_sql .= " WHERE gisu_year = '".$gisu_year."' AND gisu_month = '".$gisu_month."' ORDER BY l.hero_idx ASC ";
$review_member_res = sql($review_member_sql);

//��������
if($_SESSION['temp_level']<9999)	$hero_use = " AND b.hero_use=1 "; //�ӽñ� ���� ����	
?>

<div class="contents">
<? include_once("{$_SERVER[DOCUMENT_ROOT]}/include/listHeadTitle.php") ?>

<p class="titleText mgt30">
	<span class="titleLine">l</span> <?=$hero_month?> Loyal AK LOVER
</p>

<div class="loyalMemberWrap">
	<div class="listWrap">
		<div class="tit">Loyal AK LOVER</div>
		<div class="list">
			<? 
			  $k = 0;
			  while($reviewList = mysql_fetch_assoc($review_member_res)) {
			  if($k > 0) $review_nick .= ", ";
			  if($k%5==0 && $k > 0) $review_nick .= "<br/>";
			  $review_nick .= $reviewList["hero_nick"];
			  $k++;}
			?>
			<?=$review_nick?>
			
			<?if($k==0) {?>
				<?=$hero_month?> Loyal AK LOVER ��ǥ �����Դϴ�.<Br/>���ݸ� ��ٷ��ּ��� :)
			<? } ?>
		</div>
	</div>
</div>

<p class="titleText mgt30">
	<span class="titleLine">l</span> Loyal AK LOVER ��������
</p>
<div class="loyalStandardWrap border_none">
	<p class="txt_explain">
- �� 20�� ����<br/>
- ��α� or �ν�Ÿ�׷� ���� ��<br/>
- ���� AK LOVER ������ (ü���, ��������, �������� ����, ���� ����Ʈ, Ȩ������ Ȱ�� ��)<br/>
- ������Ƽ �� ������ �ִ� ������ �ۼ�<br/>
- 3���� �� Loyal AK LOVER ������ ����<br/>
	</p>
</div>

<p class="titleText mgt30">
	<span class="titleLine">l</span>  Loyal AK LOVER ����
</p>
<div class="loyalStandardWrap">
	<dl>
		<dt>����</dt>
		<dd>
			<p>5���� ��� ����� �ż��� ��ǰ��</p>
		</dd>
	</dl>
	<dl>
		<dt>�� ���ǻ���</dt>
		<dd>
			<p class="icon_hyphen">��ǥ �� ������ ���� 5�� �̳� Ȩ������ �� ��� �� ��ȣ�� �߼�</p>
			<p class="icon_hyphen">���� �ż����ȭ��/�̸�Ʈ ��ǰ�Ǽ����� <span>���̻�ǰ������ ���� ��ȯ ��</span> �̸�Ʈ, �ż����ȭ��, �̸�Ʈ��, �ż���� ���� ����ó���� ��� ����</p>
			<p class="icon_hyphen">�߱� �� ��ǰ���� �Ⱓ���� �� ��߱��� �Ұ��մϴ�.<br/>�ݵ�� �Ⱓ �� ��ȯ �� ��� ��Ź�帳�ϴ�.</p>
		</dd>
	</dl>
</div>
</div>
</div>