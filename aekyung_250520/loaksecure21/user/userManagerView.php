<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/user.css?v=250617" type="text/css" />
<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/sub.css?v=250617" type="text/css" />

<!-- 뷰 리스트 탭 --> 
<ul class="viewTabList">
	<li class="on" data-idx="1"><a>회원 정보</a></li>
	<li data-idx="2"><a>콘텐츠 관리</a></li>
	<li data-idx="3"><a>체험단 신청이력</a></li>
	<li data-idx="4"><a>활동 관리</a></li>
	<li data-idx="5"><a>서포터즈 이력 관리</a></li>
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
