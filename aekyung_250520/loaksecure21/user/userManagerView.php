<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/user.css?v=250617" type="text/css" />
<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/sub.css?v=250617" type="text/css" />

<!-- �� ����Ʈ �� --> 
<ul class="viewTabList">
	<li class="on" data-idx="1"><a>ȸ�� ����</a></li>
	<li data-idx="2"><a>������ ����</a></li>
	<li data-idx="3"><a>ü��� ��û�̷�</a></li>
	<li data-idx="4"><a>Ȱ�� ����</a></li>
	<li data-idx="5"><a>�������� �̷� ����</a></li>
</ul>

<div class="viewTabContents">
	<ul>
		<li class="content_item active user_info">
			<? include_once PATH_INC_END.'/user/userManagerView_1.php';?>
		</li> 
		<li class="content_item">
			<? include_once PATH_INC_END.'/user/userManagerView_2.php';?>
		</li>
		<li class="content_item">
			<? include_once PATH_INC_END.'/user/userManagerView_3.php';?>
		</li>
		<li class="content_item">
			<? include_once PATH_INC_END.'/user/userManagerView_4.php';?>
		</li>
		<li class="content_item">
			<? include_once PATH_INC_END.'/user/userManagerView_5.php';?>
		</li>
	</ul>
</div>
