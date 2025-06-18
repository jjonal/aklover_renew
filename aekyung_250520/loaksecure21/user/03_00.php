<?
######################################################################################################################################################
$name       = "순서                 ||레벨                  ||레벨명                ||시작 포인트                           ||종료 포인트               ||이미지";
$id_name    = "hero_order           ||hero_level            ||hero_name             ||hero_point_01                         ||hero_point_02             ||hero_img_new";
$type       = "text                 ||text                  ||text                  ||textarea                              ||text                      ||file";
$css        = "style='width:700px;' ||style='width:700px;'  ||style='width:700px;'  ||style='width:700px; height:300px;'    ||style='width:700px;'      ||";
$value      = "0                    ||                      ||                      ||                                      ||                          ||";
######################################################################################################################################################
/*
$name       .= "||레벨";
$id_name    .= "||hero_img_old";
$type       .= "||file";
$css        .= "||";
$name       .= "||레벨                   ||레벨명                  ||시작 포인트                           ||종료 포인트               ||이미지";
$id_name    .= "||hero_level             ||hero_name               ||hero_point_01                         ||hero_point_02             ||hero_old_img";
$type       .= "||text                   ||text                    ||textarea                              ||text                      ||file";
$css        .= "||style='width:700px;'   ||style='width:700px;'    ||style='width:700px; height:300px;'    ||style='width:700px;'      ||";
*/
######################################################################################################################################################
?>
                        <table class="t_view">
                            <colgroup>
                                <col width="20%">
                                <col width="80%">
                            </colgroup>
                            <tbody>
                            <form name="form_next" action="<?=PATH_HOME.'?'.get('view||type','view=03_01&type=write');?>" method="post" enctype="multipart/form-data"> 
                            <input type='hidden' name='hero_table' value="level">
                            <input type='hidden' name='hero_idx' value="<?=$_GET['hero_idx']?>">

<?
                            $name_arr = @explode('||',$name);
                            $id_name_arr = @explode('||',$id_name);
                            $type_arr = @explode('||',$type);
                            $css_arr = @explode('||',$css);
                            $value_arr = @explode('||',$value);
                            $count = sizeof($id_name_arr);
                            if($count == "" || $count == 0){
                            }else{
                                $i = 0;
                                while($i < $count){
                                    if(!strcmp(trim($type_arr[$i]),"textarea")){
                                        $type = "textarea";
                                        $type_end = "</textarea>";
                                    }else{
                                        $type = "input type='".trim($type_arr[$i])."'";
                                    }
?>
                                <tr>
                                    <th><?=trim($name_arr[$i])?></th>
                                    <td><?="<".$type." name='".trim($id_name_arr[$i])."' id='".trim($id_name_arr[$i])."' ".trim($css_arr[$i])." value='".trim($value_arr[$i])."'>".$type_end?></td>
                                </tr>
<?
                                        $i++;
                                    }
                                }

?>
                                <tr>
                                    <td colspan="2" style="text-align:center"><a href="javascript:form_next.submit();" class="btn_blue2">추가</a></td>
                                </tr>
                            </form>
                        </tbody>
                        </table>
