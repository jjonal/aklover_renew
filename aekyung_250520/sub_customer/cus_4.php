<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$sql = 'select * from hero_group where hero_order=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);
######################################################################################################################################################
?>

        <div class="contents" >

		<div id="menuList">
		
			<div class="menu" >
			    <h3 class="titel">&nbsp;&nbsp;&nbsp;&nbsp;<img src="../image/sitemap/menu1.png" width="46" height="17" alt="" /></h3>
					<ul class="list1">
						<li><a href="/main/index.php?board=group_01_01">�ɹ̳� ��</a></li>
						<li><a href="/main/index.php?board=group_01_02">�ֺ�9�� ��</a></li>
						<li><a href="/main/index.php?board=group_01_03">�̽İ� ��</a></li>
						<li><a href="/main/index.php?board=group_01_04">������ ��</a></li>
					</ul>
			</div>
		
			<div class="menu">
					<h3 class="titel">&nbsp;&nbsp;&nbsp;&nbsp;<img src="../image/sitemap/menu2.png" width="45" height="17" alt="" /></h3>
					<ul class="list1">
						<li><a href="/main/index.php?board=group_02_01">�����Ϸ�</a></li>
						<li><a href="/main/index.php?board=group_02_02">����&��ȥ</a></li>
					</ul>
			</div>
		
			<div class="menu">
					<h3 class="titel">&nbsp;&nbsp;&nbsp;&nbsp;<img src="../image/sitemap/menu3.png" width="45" height="17" alt="" /></h3>
					<ul class="list1">
						<li><a href="/main/index.php?board=group_03_01">AK �Ұ�</a></li>
						<li><a href="/main/index.php?board=group_03_02">AK ����Ʈ</a></li>
						<li><a href="/main/index.php?board=group_03_03">���̽�</a></li>
						<li><a href="/main/index.php?board=group_03_04">���� ���̵��</a></li>
						<li><a href="/main/index.php?board=group_03_05">���� Ī����</a></li>
					</ul>
			</div>
		
			<div class="menu">
					<h3 class="titel">&nbsp;&nbsp;&nbsp;&nbsp;<img src="../image/sitemap/menu4.png" width="69" height="18" alt="" /></h3>
					<ul class="list2">
						<li><a href="/main/index.php?board=group_04_01">AK Lover��?</a></li>
						<li><a href="/main/index.php?board=group_04_02">����Ʈ ��� ���̵�</a></li>
						<li><a href="/main/index.php?board=group_04_03">��������</a></li>
						<li><a href="/main/index.php?board=group_04_04">�⼮üũ</a></li> 
						<li><a href="/main/index.php?board=group_04_05">�Ϲ� �̼�</a></li>
						<li><a href="/main/index.php?board=group_04_06">�����̾� �̼�</a></li>
						<li><a href="/main/index.php?board=group_04_07">Ȱ�� �̼�</a></li>
						<li><a href="/main/index.php?board=group_04_08">��������</a></li>
						<li><a href="/main/index.php?board=group_04_09">�����ı�</a></li>
						<li><a href="/main/index.php?board=group_04_10">���� ��Ÿ</a></li>
						<li><a href="/main/index.php?board=group_04_11">����! �Ŀ���α�</a></li>
					</ul>
			</div>
		
			<div class="menu">
					<h3 class="titel">&nbsp;&nbsp;&nbsp;&nbsp;<img src="../image/sitemap/menu5.png" width="67" height="19" alt="" /></h3>
					<ul class="list2">
						<li><a href="/main/index.php?board=mission">������û�� �̼Ǻ���</a></li>
						<li><a href="/main/index.php?board=mail">�� ������</a></li>
						<li><a href="/main/index.php?board=infoedit">ȸ������ ����</a></li>
						<li><a href="/main/index.php?board=without">ȸ��Ż��</a></li>
					</ul>
			</div>
		
			<div class="menu">
					<h3 class="titel">&nbsp;&nbsp;&nbsp;&nbsp;<img src="../image/sitemap/menu6.png" width="60" height="17" alt="" /></h3>
					<ul class="list2">
						<li><a href="/main/index.php?board=cus_1">��������Ʈ �� <br />���ǥ��</a></li>
						<li><a href="/main/index.php?board=cus_2">���� ���� ����</a></li>
						<li><a href="/main/index.php?board=cus_3">1:1 ����</a></li>
					</ul>
			</div>
	</div>
	</div>
        

    </div>
<div class="clearfix"></div>  