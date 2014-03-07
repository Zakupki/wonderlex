<div class="section">
                        <div class="title_wrapper">
                            <h2>Стиль/направление в искусстве</h2>
                            <span class="title_wrapper_left"></span>
                            <span class="title_wrapper_right"></span>
                        </div>
                        <div class="section_content">
                            <div class="sct">
                                <div class="sct_left">
                                    <div class="sct_right">
                                        <div class="sct_left">
                                            <div class="sct_right">
                                                <form action="/admin/arttype/updateartstyleinner/" method="POST" id="mailform" class="search_form general_form">
                                                    <fieldset>
                                                        <input type="hidden" name="id" value="<?=$this->view->artstyle['id'];?>" />
                                                        <div class="forms">
                                                        <div class="row">
                                                            <label>Название:</label>
                                                            <div class="inputs">
                                                                <span class="input_wrapper"><input class="text" name="name" value="<?=$this->view->artstyle['name'];?>" type="text" /></span>
                                                            </div>
                                                        </div>
                                                       <div class="row">
                                                            <label>Вид искусства:</label>
                                                            <div class="inputs">
                                                                <span class="input_wrapper blank">
                                                                    <select name="arttype_id">
                                                                        <? foreach($this->view->arttypes as $arttype){?>
                                                                        <option<?=($arttype['id']==$this->view->artstyle['arttype_id'])?' selected=selected':'';?> value="<?=$arttype['id'];?>"><?=$arttype['name'];?></option>
                                                                        <?}?>
                                                                    </select>
                                                                </span>
                                                            </div>
                                                        </div>  
                                                        <div class="row">
                                                            <div class="buttons">
                                                                <ul>
                                                                    <li><span class="button send_form_btn"><span><span>Сохранить</span></span><input name="" type="submit" /></span></li>
                                                                    <li><span class="button cancel_btn"><span><span>Отмена</span></span><input name="" type="submit" /></span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        
                                                        </div>
                                                        
                                                    </fieldset>
                                                    
                                                    
                                                    
                                                    
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="scb"><span class="scb_left"></span><span class="scb_right"></span></span>
                            
                        </div>
                    </div>