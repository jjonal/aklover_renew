<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
?> 




				<table class="t_list">
                            <thead>
                                <tr>
                                    <th width="5%">idx</th>
                                    <th width="5%">����</th>
                                    <th width="15%">������</th>
                                    <th width="11%">��������Ʈ</th>
                                    <th width="11%">��������Ʈ</th>
                                    <th width="10%">����</th>
                                </tr>
                            </thead>
                            <tbody>
                        <?
                        $sql = 'select * from level where hero_level<=\''.$_SESSION['temp_level'].'\' order by hero_order asc;';//desc
                        $user_sql = mysql_query($sql);
                        $i = '0';
                        while($list                             = @mysql_fetch_assoc($user_sql)){
                        ?>
                            <form name="form_next<?=$i?>" action="<?=PATH_HOME.'?'.get('','view=03_01&type=edit');?>" method="post" enctype="multipart/form-data"> 
                            <input type="hidden" name="hero_drop" value="hero_drop||hero_img_old">
                            <input type='hidden' name='hero_table' value="level">
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
                                    <td><input type="hidden" name="hero_idx" id="hero_idx" value="<?=$list['hero_idx'];?>"><?=$list['hero_idx'];?></td>
                                    <td><?=$list['hero_level'];?></td>
                                    <td><?=$list['hero_name'];?></td>
                                    <td><input type="text" name="hero_point_01" id="hero_point_01" style="width:100px;text-align:center" value="<?=$list['hero_point_01'];?>"></td>
                                    <td><input type="text" name="hero_point_02" id="hero_point_02" style="width:100px;text-align:center" value="<?=$list['hero_point_02'];?>"></td>
                                    <td><a href="javascript:form_next<?=$i?>.submit();" class="btn_blue2">��������</a></td>
                                </tr>
                            </form>
                        <?
                        $i++;
                        }
                        ?>
                            </tbody>
                        </table>
