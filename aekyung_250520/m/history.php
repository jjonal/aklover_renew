<? include_once "head.php";?> 
<link href="css/aklover.css?v=1" rel="stylesheet" type="text/css">
<!--������ ����-->

<?
$group_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_REQUEST['board'].'\';';//desc
$out_group = @mysql_query($group_sql);
$right_list                             = @mysql_fetch_assoc($out_group);
?>
<? include_once "boardIntroduce.php"; ?>
<div style="clear:both"></div>
<div id="line"></div>
<div id="love1">
	<div class="historyWrap">
	    <div class="introduceTab">
	        <ul class="pointTab">
				<li class="on" rel="tab01">2020��~����</li>
				<li rel="tab02">2016~2019</li>
				<li rel="tab03">2012-2015</li>
	        </ul>
	    </div>
	
		<div id="tab01" class="tab_content">
			<div class="list">
				<p class="year">2023</p>
				<dl class="monthList">
					<dt>7��</dt>
					<dd>AK LOVER ��5ȸ �¶��� �ߴ��</dd>
				</dl>
				<p class="img_year"><img src="/m/img/aklover/history_ico_2023.png" alt="2023�� ���� �̹���" /></p>
			</div>
			
			<div class="list">
				<p class="year">2022</p>
				<dl class="monthList">
					<dt>9��</dt>
					<dd>AK LOVER 10�ֳ�</dd>
					<dt>4��</dt>
					<dd>��Ÿ���� 'AK LOVER World' ���� (ZEPETO)</dd>
				</dl>
				<p class="img_year"><img src="/m/img/aklover/history_ico_2022.png?v=220825_2" alt="2022�� ���� �̹���" /></p>
			</div>
			
			<div class="list">
				<p class="year">2021</p>
				<dl class="monthList">
					<dt>3��</dt>
					<dd>AK LOVER ��1ȸ �¶��� �ߴ��</dd>
					<dt>5��</dt>
					<dd>���Ĺڽ� ����</dd>
					<dt>7��</dt>
					<dd>Global Club 1�� �</dd>
				</dl>
				<p class="img_year"><img src="/m/img/aklover/history_ico_2021.png?v=220825_2" alt="2021�� ���� �̹���" /></p>
			</div>
			
			<div class="list">
				<p class="year">2020</p>
				<dl class="monthList">
					<dt>12��</dt>
					<dd>Life Club 1�� �</dd>
				</dl>
				<p class="img_year"><img src="/m/img/aklover/history_ico_2020.png?v=220825_2" alt="2020�� ���� �̹���" /></p>
			</div>
	    </div>
	    
	    <div id="tab02" class="tab_content">
	    	<div class="list">
				<p class="year">2019</p>
				<dl class="monthList">
					<dt>10��</dt>
					<dd>Youtuber 1�� �</dd>
				</dl>
				<p class="img_year"><img src="/m/img/aklover/history_ico_2019.png?v=220825_2" alt="2019�� ���� �̹���" /></p>
			</div>
			
			<div class="list">
				<p class="year">2017</p>
				<dl class="monthList">
					<dt>1��</dt>
					<dd>�� ȸ�� �� 5,000�� �޼�</dd>
					<dt>3��</dt>
					<dd>AK LOVER ���� �ν�Ÿ�׷� ä�� ����</dd>
					<dt>7��</dt>
					<dd>AK LOVER ��ũ�� ����(���̿� �Բ��ϴ� û�� ���� ����)</dd>
					<dt>11��</dt>
					<dd>AK LOVER īī���� ä�� ����</dd>
				</dl>
				<p class="img_year"><img src="/m/img/aklover/history_ico_2017.png?v=220825_2" alt="2017�� ���� �̹���" /></p>
			</div>
			
			<div class="list">
				<p class="year">2016</p>
				<dl class="monthList">
					<dt>1��</dt>
					<dd>Beauty Club 1�� (�糪 ��������) �</dd>
					<dt>5��</dt>
					<dd>Whistle Club 1�� (�ݷ����� ��������) �</dd>
				</dl>
				<p class="img_year"><img src="/m/img/aklover/history_ico_2016.png?v=220825_2" alt="2016�� ���� �̹���" /></p>
			</div>
	    </div>
	    
		<div id="tab03" class="tab_content">
	    	<div class="list">
				<p class="year">2015</p>
				<dl class="monthList">
					<dt>1��</dt>
					<dd>���ν��� Ȱ�� ����(��������, FGD/FGI �)</dd>
					<dt>1��</dt>
					<dd>���л� ���ڴ�, TOP TEAM ���</dd>
					<dt>2��</dt>
					<dd>�ְ�ڽ�(��ǰ ���� �̺�Ʈ) ����</dd>
					<dt>4��</dt>
					<dd>AK LOVER ���� ��Ʃ�� ä�� ����</dd>
					<dt>6��</dt>
					<dd>AK LOVER ���� ���̽��� ä�� ����</dd>
				</dl>
				<p class="img_year"><img src="/m/img/aklover/history_ico_2015.png?v=220825_2" alt="2015�� ���� �̹���" /></p>
			</div>
			<div class="list">
				<p class="year">2014</p>
				<dl class="monthList">
					<dt>1��</dt>
					<dd>�� 1ȸ AK LOVER��s Day</dd>
					<dt>7��</dt>
					<dd>�� 1ȸ ����Ʈ ����</dd>
					<dt>9��</dt>
					<dd>AK LOVER ����� ������ ����</dd>
					<dt>12��</dt>
					<dd>�ı� ������ 10,000�� �޼�</dd>
				</dl>
				<p class="img_year"><img src="/m/img/aklover/history_ico_2014.png?v=220825_2" alt="2014�� ���� �̹���" /></p>
			</div>
			<div class="list">
				<p class="year">2013</p>
				<dl class="monthList">
					<dt>9��</dt>
					<dd>�������� Ȱ�� ����(��ȭ����/����Ȱ��/��������)</dd>
					<dt>10��</dt>
					<dd>��AK LOVER�� Ȩ������ ����</dd>
					<dt>11��</dt>
					<dd>�Ը��� �̺�Ʈ ����</dd>
					<dt>12��</dt>
					<dd>Loyal AK LOVER �</dd>
				</dl>
				<p class="img_year"><img src="/m/img/aklover/history_ico_2013.png?v=220825_2" alt="2013�� ���� �̹���" /></p>
			</div> 
			<div class="list">
				<p class="year">2012</p>
				<dl class="monthList">
					<dt>9��</dt>
					<dd>�ְ� �������� 'AK LOVER' ���</dd>
				</dl>
				<p class="img_year"><img src="/m/img/aklover/history_ico_2012.png?v=220825_2" alt="2012�� ���� �̹���" /></p>
			</div>      
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
    $('.tab_content').hide();
    $('.tab_content:first').show();
    
    $('.pointTab > li').click(function(){
        //�� on,off
        $('.pointTab').children('li').removeClass('on');
        $(this).addClass('on');
        
        //�� �̵�
        $('.tab_content').hide();
        var tabNum = $(this).attr('rel');
        $('#'+tabNum).fadeIn();
    });

    <? if($_REQUEST["selectTab"]) {?>
    	$('.pointTab > li').eq('<?=$_REQUEST["selectTab"];?>').click();
    <? } ?>
});
</script>
<!--������ ����-->
<?include_once "tail.php";?>