<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$cut_title_name = '26';
$_GET['board'];
$sql = 'select * from mission where hero_table = \''.$_GET['board'].'\' and hero_idx=\''.$_GET['idx'].'\';';
sql($sql, 'on');
$right_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
$out_right_sql = mysql_query($right_sql);
$right_list                             = @mysql_fetch_assoc($out_right_sql);

$out_row = @mysql_fetch_assoc($out_sql);//mysql_fetch_row
$edit_sql = 'select * from mission_review where hero_table = \''.$_GET['board'].'\' and hero_old_idx=\''.$_GET['idx'].'\' and hero_code=\''.$_SESSION['temp_code'].'\';';
$out_edit_sql = mysql_query($edit_sql);
$edit_list                             = @mysql_fetch_assoc($out_edit_sql);
######################################################################################################################################################
if(!strcmp($_GET['type'], 'edit')){
$count = sizeof($_POST);
$data_i = '1';
foreach($_POST as $post_key => $post_val) {
    if(!strcmp($count, $data_i)){
        $comma = '';
    }else{
        $comma = ', ';
    }
    $sql_one_update .= $post_key.'=\''.$_POST[$post_key].'\''.$comma;
$data_i++;
}
    $sql = 'UPDATE mission_review SET '.$sql_one_update.' WHERE hero_idx = \''.$_GET['hero_idx'].'\';'.PHP_EOL;
    mysql_query($sql);
    msg('���� �Ǿ����ϴ�.','location.href="'.PATH_HOME.'?board='.$_GET['board'].'&view=step_02&idx='.$_GET['idx'].'"');
EXIT;
}
?>
<script type="text/javascript">
    function showzip(){
        $('.layer_zip').show();
    }
    function inputzip(){
        $('.layer_zip').hide();
    }
    function fnLoad_01(a,b,c,d,e,f){
        document.getElementById("hero_address_01").value=a;
        document.getElementById("hero_address_02").value=b + ' ' + c + d + e;
        $('.layer_zip').hide();
    }
    function go_submit(form) {
//##################################################################################################################################################//
        var new_name = form.hero_new_name;
        var hero_03 		= $('.hero_03');
        var address_01 = form.hero_address_01;
        var address_02 = form.hero_address_02;
        var hp_01 = form.hero_hp_01;
        var hp_02 = form.hero_hp_02;
        var hp_03 = form.hero_hp_03;
//##################################################################################################################################################//
        var ft = 0;
		hero_03.each(function( index ) {
	        if($(this).val() == ""){

		        alert("��û�ʼ������� �Է����ּ���.");
	            $(this).css('border','1px solid red');
	            $(this).focus();
	            ft = 1;
	            return false;
	            
	        }else{
	        	$(this).css('border','1px solid #e4e4e4');
	        }
		});

		if(ft==1){
			return false;
		}
        if(new_name.value == ""){
            alert("�����ôº� �̸��� �Է����ּ���.");
            new_name.style.border = '1px solid red';
            new_name.focus();
            return false;
        }else{
            new_name.style.border = '1px solid #e4e4e4';
        }
        if(address_01.value == ""){
            alert("����� �ּ� �Է����ּ���.");
            address_01.style.border = '1px solid red';
            address_01.focus();
            return false;
        }else{
            address_01.style.border = '1px solid #e4e4e4';
        }
        if(address_02.value == ""){
            alert("����� �ּ� �Է����ּ���.");
            address_02.style.border = '1px solid red';
            address_02.focus();
            return false;
        }else{
            address_02.style.border = '1px solid #e4e4e4';
        }
        if(hp_01.value == ""){
            alert("����ó�� �Է����ּ���.");
            hp_01.style.border = '1px solid red';
            hp_01.focus();
            return false;
        }else{
            hp_01.style.border = '1px solid #e4e4e4';
        }
        if(hp_02.value == ""){
            alert("����ó�� �Է����ּ���.");
            hp_02.style.border = '1px solid red';
            hp_02.focus();
            return false;
        }else{
            hp_02.style.border = '1px solid #e4e4e4';
        }
        if(hp_03.value == ""){
            alert("����ó�� �Է����ּ���.");
            hp_03.style.border = '1px solid red';
            hp_03.focus();
            return false;
        }else{
            hp_03.style.border = '1px solid #e4e4e4';
        }

        var i_ask=0;
		var total_ask = "";		
		hero_03.each(function( index ) {

			var hero_03 = $(this).val();
			if(hero_03!=null){
				hero_03 = hero_03.trim();
				if(i_ask==0)		total_ask += hero_03;
				else				total_ask += "/////"+hero_03;
				
				i_ask++;
			}
		});

		$('#hero_03').val(total_ask);
        
            form.submit();
//##################################################################################################################################################//
        return true;
    }
</script>
<div class="contents_area">
    <div class="page_title">
        <h2><img src="<?=str($right_list['hero_right']);?>" alt="<?=$right_list['hero_title'];?>" /></h2>
        <ul class="nav">
            <li><img src="../image/common/icon_nav_home.gif" alt="home" /></li>
            <li>&gt;</li>
            <li><?=$right_list['hero_top_title']?></li>
            <li>&gt;</li>
            <li class="current"><?=$right_list['hero_title']?></li>
        </ul>
    </div>
    <div class="contents"> <img src="../image/mission/spm_txt_reviewer.gif" alt="������û��" />
        <form name="form_next" action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post" enctype="multipart/form-data" onsubmit="return false;">
        
        <input type="hidden" name="hero_03" id="hero_03" value=""> 
        <div class="spm"> <img src="../image/mission/spm_infobg_1.gif" alt="top" /> </div>
            <div class="spm_txt spm_step2">
                <?php
           		$number=1;
           		//�Ϲݹ̼��� ��� 
           		if($out_row['hero_type']==0){
            	?>
					<dl>
	                	<dt><span style="background-color:#686868;padding:10px;font-size:20px;font-weight:800;color:#feb007;border-radius:30px;margin-left:10px;">0<? echo $number++;?></span></dt>
	
	                	<dd>
		                	<label for=""><img src="../image/mission/txt_regblog.gif" alt="��ϵ� ��α�" /></label>
						        <?
						        $sql = 'select * from member where hero_id=\''.$_SESSION['temp_id'].'\'';//desc//asc// limit 0,5
						        sql($sql);
						        $site_list                             = @mysql_fetch_assoc($out_sql);
						            $blog_00 = url($site_list['hero_blog_00']);
						            $blog_01 = url($site_list['hero_blog_01']);
						            $blog_02 = url($site_list['hero_blog_02']);
						            $blog_03 = url($site_list['hero_blog_03']);
						            $blog_04 = url($site_list['hero_blog_04']);
						            $blog_05 = url($site_list['hero_blog_05']);
						        ?>
				                <select name="hero_01">
				                  <option value="<?=$blog_00?>"<?if(!strcmp($blog_00, $edit_list['hero_01'])){echo ' selected';}else{echo '';}?>>��α� URL</option>
				                  <option value="<?=$blog_01?>"<?if(!strcmp($blog_01, $edit_list['hero_01'])){echo ' selected';}else{echo '';}?>>���̽��� URL</option>
				                  <option value="<?=$blog_02?>"<?if(!strcmp($blog_02, $edit_list['hero_01'])){echo ' selected';}else{echo '';}?>>Ʈ���� URL</option>
				                  <option value="<?=$blog_03?>"<?if(!strcmp($blog_03, $edit_list['hero_01'])){echo ' selected';}else{echo '';}?>>īī�����丮 URL</option>
				                  <option value="<?=$blog_04?>"<?if(!strcmp($blog_04, $edit_list['hero_01'])){echo ' selected';}else{echo '';}?>>�������� URL</option>
				                  <option value="<?=$blog_05?>"<?if(!strcmp($blog_05, $edit_list['hero_01'])){echo ' selected';}else{echo '';}?>>�׿� SNS URL</option>
				
				                </select>
	                	</dd>
               		</dl>
	                <div class="bddot"></div>
               	<?php }?>
                
                
                <dl>
                	<dt><span style="background-color:#686868;padding:10px;font-size:20px;font-weight:800;color:#feb007;border-radius:30px;margin-left:10px;">0<? echo $number++;?></span></dt>
                <dd> 
	                <ul>
	
	                	<li class="c_orange" style="margin-bottom:10px;">��û�� �Ʒ������� Ȯ�����ּ���.</li>
	                		<?php 
							
								$hero_ask = explode("/////",$out_row['hero_ask']);
								$hero_03 = explode("/////",$edit_list['hero_03']);
								
								for($row=0; $row<count($hero_ask); $row++) {
									?>
									<li style="margin-bottom:10px;">
										<pre style='word-wrap: break-word;'><?=$hero_ask[$row];?></pre>
                    				</li>
									<li style="margin-bottom:10px;">
				                		<textarea class="hero_03" style="width: 400px;height: 50px;margin-left: 17px;"><?=$hero_03[$row]?></textarea>
				                	</li>
									
									<?php 
								}
								
							?>
							<li style="margin-bottom:10px;">
										<pre style='word-wrap: break-word;'><?=$out_row['hero_ask_notice'];?></pre>
                    		</li>
	                </ul>
                </dd>
                </dl>

                <div class="bddot"></div>
                <dl>
                	<dt><span style="background-color:#686868;padding:10px;font-size:20px;font-weight:800;color:#feb007;border-radius:30px;margin-left:10px;">0<? echo $number++;?></span></dt>
                <dd>
                    <ul>
                        <li class="c_orange">���� ��ǰ�� ��� ���� �ּҸ� �Է����ּ���.</li>
                        <li><label for="">�����ôº�</label>
                            <input type="text" name="hero_new_name" id="hero_new_name" value="<?=$edit_list['hero_new_name']?>" style="width:186px;">
                        </li>
                        <li>
                            <label for="">����� �ּ�</label>
                            <input type="text" name="hero_address_01" id="hero_address_01" value="<?=$edit_list['hero_address_01']?>" onclick="javascript:showzip()" readonly/>
                            <a href="javascript:showzip()"><img src="../image/member/btn_zipcode.gif" alt="�����ȣã��" /></a><br />
                            <label for=""></label>
                            <input type="text" name="hero_address_02" id="hero_address_02" value="<?=$edit_list['hero_address_02']?>" style="width:186px;" onclick="javascript:showzip()" readonly/>
                            <input type="text" name="hero_address_03" id="hero_address_03" value="<?=$edit_list['hero_address_03']?>" style="width:186px;">
                        </li>
                        <li><label for="">����ó</label>
                            <input type="text" name="hero_hp_01" id="hero_hp_01" value="<?=$edit_list['hero_hp_01'];?>" onKeyUp="if(this.value.length >= 3)hero_hp_02.focus();" maxlength="3" style="ime-mode:disabled;"/> - 
                            <input type="text" name="hero_hp_02" id="hero_hp_02" value="<?=$edit_list['hero_hp_02'];?>" onKeyUp="if(this.value.length >= 4)hero_hp_03.focus();" maxlength="4" style="ime-mode:disabled;"/> - 
                            <input type="text" name="hero_hp_03" id="hero_hp_03" value="<?=$edit_list['hero_hp_03'];?>" maxlength="4" style="ime-mode:disabled;"/>
                        </li>
                    </ul>
                </dd>
                </dl>
            <div class="clearfix"></div>
        </div>
        <div class="spm"> <img src="../image/mission/spm_infobg_3.gif" alt="top" /> </div>
        <div class="btn_group tc mt60">
            <input type="image" src="../image/mission/btn_mission_jion.gif" alt="�̼������ϱ�" onClick="go_submit(this.form)"/>
        </div>
    </form>
    </div>
</div>
        <div class="layer_zip">
            <dl>
            <form name="login_form" action="<?=PATH_HOME?>?board=result" onsubmit="return false;">
                <dt><img src="../image/member/zip1.gif" alt="�����ȣ ã��" /></dt>
                <dd>
                <input id="addr" type="text" class="addr" /><input type="image" src="../image/member/btn_findzip.gif" alt="�ּ�ã��" onclick="hero_ajax('zip.php', 'view_list', 'addr', 'zip'); return false;"/>
                </dd>
                <dd class="list">
                    <div id="view_list"></div>
                </dd>
                <dd class="tc"><a href="javascript:inputzip();"><img src="../image/member/btn_cancel.gif" alt="�Է�" /></a></dd>
            </form>
            </dl>
        </div>
