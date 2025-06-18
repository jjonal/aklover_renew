                        <div style='text-align:center;'>
                            <form action="<?=PATH_HOME.'?'.get('page');?>" method="POST" >
                                    <select name="select">
                                        <option value="hero_herf"<?if(!strcmp($_REQUEST['select'], 'Title')){echo ' selected';}else{echo '';}?>>Title</option>
                                        <option value="hero_command"<?if(!strcmp($_REQUEST['select'], 'hero_command')){echo ' selected';}else{echo '';}?>>Content</option>
                                        <option value="hero_name"<?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>Writer</option>
                                    </select>
                                    <input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];?>"/>
                                    <input type="image" alt="Search" src="<?=DOMAIN_IMAGE_END?>bbs/btn_search.gif" align="absmiddle" />
                            </form>
                        </div>
