<link rel="stylesheet" type="text/css" href="/m/css/musign/pointmall.css" />
<?
	$board 		= $_GET['board'];
	$color 		= "";
	$backColor 	= "";
	$url 		= "";
	$bottom 	= "bottom";
	
	switch ($board) {
		case "group_04_06" : //��ƼŬ��
			$color 		= "#eb7989";
			$backColor 	= "#ffedf2";
			$url 		= "/image2/m_box_backlight003.png";
			$height 	= "400";
			break;
		case "group_04_21" : //����Ʈ����
			$color 		= "#f68427";
			$backColor 	= "#f4f4f4";
			$url 		= "";
			$height 	= "auto";;
			break;
		case "group_04_27" : //AK ���� ��Ʃ��
			$color 		= "#996c33";
			$backColor 	= "#e9b9a7";
			$url 		= "/image2/m_box_backlight006.png";
			$height 	= "480";
			break;
		case "group_04_28" : //������Ŭ��
			$color 		= "#996c33";
			$backColor 	= "#e9b9a7";
			$url 		= "/image2/m_box_backlight006.png";
			$height 	= "480";
			break;
  }
?>

<?
	$check_date = date("Ymd");//�ӽ÷� �ݿ�
?>
        <? if($board == "group_04_06" || $board == "group_04_28") { ?>
	    <div class="authPage">  
	    	<div class="noAuthPage">
				<? include_once 'club.php';?>
            </div>
	    </div>
        <? }else if($board == "group_04_21") { //����Ʈ ����
 
        	$sql = " SELECT b.hero_idx, b.hero_thumb, b.hero_04, b.blog_url, b.sns_url, b.cafe_url, b.etc_url FROM board b inner join member m on b.hero_code = m.hero_code ";
        	$sql .=" WHERE  b.hero_table IN ('group_04_05', 'group_04_06', 'group_04_07', 'group_04_09','group_04_23' ) ";
        	$sql .=" AND (b.hero_board_three='1' OR b.hero_table='group_04_10')  AND b.hero_use = 1 ";
        	$sql .=" ORDER BY b.hero_today DESC LIMIT 0,8 ";
        	
        	sql($sql);

       	?>
        <div class="authPage">  
	    	<div class="noAuthPage">  
				<div><img src="/m/img/musign/pointmall/season2/pointmall.png" alt="����Ʈ ���� ���" /></div>
				<div class="sec_rollbanner">                   
					<div class="roll_wrap">
						<ul class="list">
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
						</ul>
						<ul class="list">
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
							<li class=""><img src="/img/front/pointmall/line_banner.png" alt="����Ʈ ����"></li>
						</ul>
					</div>
				</div>   
				<div class="con_box">
					<div class="inner">
						<div class="desc">
							<ul class="">
								<li>
									<span class="mini_tit fz28 bold">����</span>
									<p class="tit f_c">�� 2ȸ �Ը���� ��¦ ����</p>
									<p class="fz28 fw600 sub_desc">��ݱ�/�Ϲݱ� �� 2ȸ �Ը��� ���µ˴ϴ�</p>
									<img src="/img/front/pointmall/season2/icon01.png" style="width: 127px" alt="����Ʈ ���� �Ⱓ ����">
									<p class="fz15 sub_noti">*����Ʈ �佺Ƽ�� ���� �� ����ڴ�<br /> ������ �� �ֽ��ϴ�.</p>
								</li>
								<li>
									<span class="mini_tit fz28 bold">���</span>
									<p class="tit">�� ȸ�� ������</p>
									<p class="fz28 fw600 sub_desc">����� ���� ���� �� �ϰ� �߼۵˴ϴ�</p>
									<img src="/img/front/pointmall/season2/icon02.png" style="width: 176px" alt="����Ʈ ���� �Ⱓ ����">
								</li>
								<li>
									<span class="mini_tit fz28 bold">��ǰ</span>
									<p class="tit">�ְ��� �پ��� �α� ��ǰ<br /> ���� ���� ����</p>
									<!-- <p class="tit">�� ȸ �ٸ� ��ǰ ����</p> -->
									<p class="fz28 fw600 sub_desc">�ְ��� �پ��� ��ǰ�� �����غ�����!</p>
									<img src="/img/front/pointmall/season2/icon03.png" style="width: 182px" alt="����Ʈ ���� �Ⱓ ����">
								</li>
							</ul>
						</div>
						<div class="faq_box">						
							<div class="">
								<p class="fz32 fw600 desc c_white">����Ʈ �佺Ƽ���� ���� �ñ��� ����<br />�ִٸ� <span class="point">���� ���� ����</span>�� ���� Ȯ���غ�����!</p>
							</div>
							<a href="/m/faq.php?board=cus_2" class="faq_btn f_b">
								Ȯ���ϱ� <img src="/m/img/musign/pointmall/faq_btn.png" style="width: 6px;" alt="faq Ȯ���ϱ�">
							</a>
						</div>
						<div class="noti">
							<span class="mini_tit fz28 bold">���ǻ���</span>
							<p class="fz24 sub_desc">
								- ����Ʈ �佺Ƽ���� �� 2ȸ ����Ǹ�, ���� ������ ��¦ �����˴ϴ�.<br />
								&ensp;(��ݱ� : �̴��� AK Lover �� �����̾� ��Ƽ/������ Ŭ��,<br /> �Ϲݱ� : ��ü ȸ�� ���)<br />
								- ��ݱ� ���� �� ����Ʈ�� �Ҹ���� ������,<br /> �Ϲݱ� ���� �� ���� ����Ʈ�� �ϰ� �Ҹ�˴ϴ�.
							</p>
						</div>
					</div>				
				</div>    			         
       		</div>
       </div>
        <? }else if($board == "group_04_27") { ?>
        <div class="authPage">  
	    	<div class="noAuthPage">
	    		<? if($check_date < 20210803) { ?>
	    			<div><a href="/m/joinCheck.php?board=idcheck"><img src="./img/mission_member_join.jpg" width="100%" /></a></div>  	
      	   		<?  } else { ?>
	    		<div class="img_product"><img src="/image2/focus_main_movie4.jpg" alt="" /></div>
           	    <div class="bg_explain">
					<dl class="box_explain">
						<dt><span>���</span></dt>
						<dd>��Ƽ Ȥ�� ��Ȱ��ǰ�� ������ ���� ���� ũ��������</dd>
						<dt><span>�������</span></dt>
						<dd>���� ���� �Ⱓ�� ����</dd>
           	    		<dt><span>�ֿ�Ȱ��</span></dt>
           	    		<dd>�ְ� ��Ƽ/��Ȱ ����ǰ ��� �� ���� ����, ����ǰ ���̵�� ����, ��ǰ ǰ��ȸ, �������� ��</dd>
           	    		<dt><span>����</span></dt>
           	    		<dd>���� ����� 30���� ��� ����<br/>
							������ ���� 10���� ��� ���� �ڽ� ���� (���� 1ȸ)<br/>
							Ȱ�� ���� �� 10���� ��� ���� ���� * Ȱ�� �Ϸ� ���� ���� ��<br/>
							�� ����� 5���� ��� ��ǰ�� ����<br/>
							�귣�� ��� �켱 ���� ��ȸ ����<br/>
							�̼� �Ϸ� �� ��ǰ ��ȯ ������ ����Ʈ ����<br/>
							Ȱ�� ���� �� ������ ����
           	    		</dd>
           	    	</dl>
           	    </div>
           	    <? } ?>
			</div>
        <? } ?>