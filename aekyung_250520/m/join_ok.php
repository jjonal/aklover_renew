<?
// echo '123';
// if(!defined('_HEROBOARD_'))exit;
// if($_SESSION["temp_code"]) {
// 	error_location("�α��� �����Դϴ�.\\n�ùٸ� ��η� �̿��� �ּ���.","/main/index.php");
// }
?>
<!-- <? include_once "head.php";?>  -->
<link href="/m/css/musign/member.css" rel="stylesheet" type="text/css">
	<div class="contents_area join_ok join_wrap mu_member"> 
    <div class="page_title t_c">
        <h2 class="fz48 fw500 main_c">ȸ������</h2>
		<p class="subtit fz12">AK Lover�� �پ��� ������� �����ϼ���!</p>
		<div class="bread">
			<ul class="f_c">
				<li>��������</li>
				<li class="arr"><img src="/img/front/icon/bread.webp" alt="ȭ��ǥ"></li>
				<li class="joinstep">�̿��� ����</li>
				<li class="join_arr arr"><img src="/img/front/icon/bread.webp" alt="ȭ��ǥ"></li>
				<li class="joinstep">���� ����(�ʼ�)</li>
				<!-- <li class="join_arr arr"><img src="/img/front/icon/bread.webp" alt="ȭ��ǥ"></li><br /> -->
			</ul>
			<ul class="f_c">				
				<!-- <li class="joinstep">���� ����(����)</li> -->
				<li class="join_arr arr"><img src="/img/front/icon/bread.webp" alt="ȭ��ǥ"></li>
				<li class="joinstep on">ȸ������ �Ϸ�</li>
			</ul>
		</div>
    </div>
        <div class="contents">
            <div class="maincont">
                <img src="/img/front/member/heart.webp" alt="ȸ������ �Ϸ�">
                <p class="desc fz28 fw600">
                    <!--!!!!!!!! [���߿�û] ���� ���̵� ���� [��]!!!!!!!!  -->	
                    <span><?=$_GET["id"]?></span> ��, ȸ�������� ���ϵ帳�ϴ�!<br />
                    ȸ������ �Ϸ� ��, �ٽ� �α����� �ʿ��մϴ�.
                </p>
                <p class="fz14 gray fw600">* ������ �ϼ��ϰ� �߰� ����Ʈ �����ϼ���!</p>
                <div>
                    <div class="btn_bx f_c">
						<a class="btn_submit btn_white" href="/">Ȩȭ������</a>
						<a class="btn_submit btn_black" href="/m/login.php">�α��� �ϱ�</a>
					</div>
                </div>
            </div>
            <a href="/" class="btn_submit btn_main_c btn_guide f_b">
                <span class="fz13 fw600">AK Lover �� ó���̽Ű���?</span>
                <span class="fz13 f_c">�̿�鼭 �������� <img src="/img/front/member/arr.webp" alt="ȭ��ǥ"></span>
            </a>
        </div>
    </div>
<?include_once "tail.php";?>
<script>
$(document).ready(function(){})
</script>
