<link rel="stylesheet" type="text/css" href="/css/front/pointmall.css" />
<script type="text/javascript" src="/js/musign/library/gsap.js"></script>
<?
	$board		= $_GET['board'];
	$color		= "";
	$backColor	= "";
	$url		= "";
	$bottom 	= "bottom";
	
	switch ($board) {
		case "group_04_06" : //��ƼŬ��
			$color 		= "#eb7989";
			$backColor 	= "#ffedf2";
			$url 		= "/image2/back_boxright_beauty_h.png";
			break;
		case "group_04_21" : //����Ʈ����
			$color 		= "#f68427";
			$backColor 	= "#f4f4f4";
			$url 		= "/image2/back_boxright_point.png";
			//$bottom = "";
			break;
		case "group_04_27" : //AK ���� ��Ʃ��
			$color 		= "#996c33";
			$backColor 	= "#e9b9a7";
			$url 		= "/image2/back_boxright_youtobe.png";
			$authPageEdit_height = "akloverYoutubePage";
			break;
		case "group_04_28" : //������Ŭ��
			$color 		= "#eb7989";
			$backColor 	= "#ffedf2";
			$url 		= "/image2/back_boxright_beauty_h.png";
			break;

  }
  
?>

        <? if($board == "group_04_06" || $board == "group_04_28") { // ��ƼŬ�� || ������Ŭ�� ?>
        <div class="authPage">
    		<div class="noAuthPage">
				<? include_once BOARD_INC_END.'club.php';?>
        	</div>
        </div>		
        <? }else if($board == "group_04_21") { //����Ʈ ����
			$sql = " SELECT b.hero_idx, b.hero_thumb FROM board b inner join member m on b.hero_code = m.hero_code ";
			$sql .=" WHERE  b.hero_table IN ('group_04_05', 'group_04_06', 'group_04_07', 'group_04_09','group_04_23' ) ";
        	$sql .=" AND (b.hero_board_three='1' OR b.hero_table='group_04_10')  AND b.hero_use = 1 ";
        	$sql .=" ORDER BY b.hero_today DESC LIMIT 0,10 ";
        	 
        	sql($sql);
        ?>
        <div class="authPage">
    		<div class="noAuthPage">
    			<div><img src="/img/front/pointmall/season2/pointmall.png" alt="����Ʈ ���� ���" /></div>
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
							<ul class="grid_3">
								<li>
									<span class="mini_tit fz17 fw600">����</span>
									<p class="tit fz26 fw800 f_c">�� 2ȸ �Ը���� ��¦ ����</p>
									<p class="fz18 fw600">��ݱ�/�Ϲݱ� �� 2ȸ �Ը��� ���µ˴ϴ�</p>
									<img src="/img/front/pointmall/season2/icon01.png" alt="����Ʈ ���� �Ⱓ ����">
									<p class="fz15 sub_noti">*����Ʈ �佺Ƽ�� ���� �� ����ڴ� ������ �� �ֽ��ϴ�.</p>
								</li>
								<li>
									<span class="mini_tit fz17 fw600">���</span>
									<p class="tit fz26 fw800 f_c">�� ȸ�� ������</p>
									<p class="fz18 fw600">����� ���� ���� �� �ϰ� �߼۵˴ϴ�</p>
									<img src="/img/front/pointmall/season2/icon02.png" alt="����Ʈ ���� �Ⱓ ����">
								</li>
								<li>
									<span class="mini_tit fz17 fw600">��ǰ</span>
									<p class="tit fz26 fw800">�ְ��� �پ��� �α� ��ǰ<br /> ���� ���� ����</p>
									<!-- <p class="tit fz26 fw800">�� ȸ �ٸ� ��ǰ ����</p> -->
									<p class="fz18 fw600">�ְ��� �پ��� ��ǰ�� �����غ�����!</p>
									<img src="/img/front/pointmall/season2/icon03.png" alt="����Ʈ ���� �Ⱓ ����">
								</li>
							</ul>
						</div>
						<a href="/main/index.php?board=group_04_33" class="faq_box f_b">						
							<div class="f_cs">
								<p class="fz24 fw600 desc c_white">����Ʈ �佺Ƽ���� ���� �ñ��� ���� �ִٸ� <span class="point">���� ���� ����</span>�� ���� Ȯ���غ�����!</p>
							</div>
							<img src="/img/front/pointmall/season2/arr_gold.png" alt="faq �ȳ� ����">	
						</a>
						<div class="noti f_c">
							<span class="mini_tit fz17 fw600">���ǻ���</span>
							<p class="fz18 fw300 sub_desc">
								- ����Ʈ �佺Ƽ���� �� 2ȸ ����Ǹ�, ���� ������ ��¦ �����˴ϴ�.<br />
								&ensp;(��ݱ� : �̴��� AK Lover �� �����̾� ��Ƽ/������ Ŭ��, �Ϲݱ� : ��ü ȸ�� ���)<br />
								- ��ݱ� ���� �� ����Ʈ�� �Ҹ���� ������, �Ϲݱ� ���� �� ���� ����Ʈ�� �ϰ� �Ҹ�˴ϴ�.
							</p>
						</div>
					</div>				
				</div>
       		</div>
      	</div>

         <? }else if($board == "group_04_27") { ?>
         <div class="<?=$authPageEdit_height;?> authPage">
   			<div class="noAuthPage">
   				<?
	        		$check_date = date("Ymd");	        	
	        		if($check_date < 20210803) {
	        	?>
	        		<div><a href="/main/index.php?board=idcheck"><img src="/image/mission/mission_member_join.jpg" /></a></div>
	        	<? } else {?>
   				<div>
           	    	<div class="img_product"><img src="/image2/focus_main_movie4.jpg" alt="" /></div>
           	    	<div class="bg_explain">
           	    		<dl class="box_explain">
           	    			<dt><span>���</span></dt>
           	    			<dd>��Ƽ Ȥ�� ��Ȱ��ǰ�� ������ ���� ���� ũ��������</dd>
           	    			<dt><span>�������</span></dt>
           	    			<dd>���� ���� �Ⱓ�� ����</dd>
           	    			<dt><span>�ֿ�Ȱ��</span></dt>
           	    			<dd style="letter-spacing:-1px;">�ְ� ��Ƽ/��Ȱ ����ǰ ��� �� ���� ����, ����ǰ ���̵�� ����, ��ǰ ǰ��ȸ, �������� ��</dd>
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
           	    </div>
           	    <? } ?>
			</div>
		</div>
        <? } ?>

