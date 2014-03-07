<div class="section">
						<div class="title_wrapper">
							<h2>Сайты</h2>
							<span class="title_wrapper_left"></span>
							<span class="title_wrapper_right"></span>
						</div>
						<div class="section_content">
							<div class="sct">
								<div class="sct_left">
									<div class="sct_right">
										<div class="sct_left">
											<div class="sct_right">
												<form action="/admin/sites/updatesiteinner/" method="POST" enctype="multipart/form-data" class="search_form general_form">
													<fieldset>
														<input type="hidden" name="id" value="<?=$this->view->siteinner['id'];?>" />
														<input type="hidden" name="userid" value="<?=$this->view->siteinner['userid'];?>" />
														<div class="forms">
														<? if($this->view->siteinner['id']>0){?>
														<div class="row">
															<label>Id:</label>
															<div class="inputs">
																<span class="input_wrapper"><input class="text" name="id" disabled="disabled" value="<?=$this->view->siteinner['id'];?>" type="text"/></span>
															</div>
														</div>
														<?}else{?>
														<div class="row">
															<label>Email:</label>
															<div class="inputs">
																<span class="input_wrapper"><input class="text" name="email" type="text"/></span>
															</div>
														</div>
														<?}?>
														<div class="row">
															<label>Тип сайта:</label>
															<div class="inputs">
																<span class="input_wrapper blank">
																	<select name="sitetypeid">
																		<? foreach($this->view->sitetypes as $sitetype){?>
																		<option<?=($sitetype['id']==$this->view->siteinner['sitetypeid'])?' selected=selected':'';?> value="<?=$sitetype['id'];?>"><?=$sitetype['name'];?></option>
																		<?}?>
																	</select>
																</span>
															</div>
														</div>	
														<? if($this->view->siteinner['id']>0){?>
                                                            <div class="row">
																<label>Сортировка:</label>
																<div class="inputs">
																	<span class="input_wrapper"><input class="text" name="sort" value="<?=$this->view->siteinner['sort'];?>" type="text"/></span>
																</div>
															</div>
                                                            <div class="row">
                                                                <label>Маленькая картинка:</label>
                                                                <div class="inputs">
																<span class="input_wrapper blank">
																	<? if($this->view->siteinner['preview_name']){?>
                                                                    <img src="<?=$this->view->siteinner['preview'];?>"/>
                                                                    <input name="preview" type="hidden" value="<?=$this->view->siteinner['preview'];?>">
                                                                    <?}?>
                                                                    <input name="small_image" type="file"></span>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <label>Большая картинка:</label>
                                                                <div class="inputs">
																<span class="input_wrapper blank">
																	<? if($this->view->siteinner['detail_name']){?>
                                                                    <img src="<?=$this->view->siteinner['detail'];?>"/>
                                                                    <input name="detail" type="hidden" value="<?=$this->view->siteinner['detail'];?>">
                                                                    <?}?>
                                                                    <input name="big_image" type="file"></span>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <label>Фото автора:</label>
                                                                <div class="inputs">
                                                                <span class="input_wrapper blank">
                                                                    <? if($this->view->siteinner['author_image']){?>
                                                                    <img src="<?=$this->view->siteinner['author_image'];?>"/>
                                                                    <input name="auth_im" type="hidden" value="<?=$this->view->siteinner['author_image'];?>">
                                                                    <?}?>
                                                                    <input name="author_image" type="file"></span>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                            <label>Описание автора:</label>
                                                            <div class="inputs">
                                                                <span class="input_wrapper textarea_wrapper">
                                                                    <textarea name="author_description" class="text"><?=$this->view->siteinner['author_description'];?></textarea>
                                                                </span>
                                                            </div>
                                                        </div>
														<div class="row">
															<label>Страна:</label>
															<div class="inputs">
																<span class="input_wrapper blank">
																	<select name="countryid">
																		<option></option>
																		<? foreach($this->view->countries as $country){?>
																		<option<?=($country['id']==$this->view->siteinner['countryid'])?' selected=selected':'';?> value="<?=$country['id'];?>"><?=$country['name'];?></option>
																		<?}?>
																	</select>
																</span>
															</div>
														</div>
                                                    	<div class="row">
															<label>Промо: </label>
															
															<? if($this->view->siteinner['domain_id']>0){?>
															<div class="inputs">
																<ul class="inline">
																	<li><input class="checkbox" name="promo" value="1" <?=($this->view->siteinner['promo'])?'checked="checked"':'';?> type="checkbox" /></li>
																</ul>
															</div>
															<?}else{?>
																Подключите домен для промо отображения на Wonderlex.com
															<?}?>
														</div>
														<?}?>
                                                        <div class="row">
                                                           <label>Активность: </label>
                                                               <div class="inputs">
                                                                   <ul class="inline">
                                                                       <li><input class="checkbox" name="active" value="1" <?=($this->view->siteinner['active'])?'checked="checked"':'';?> type="checkbox" /></li>
                                                                   </ul>
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