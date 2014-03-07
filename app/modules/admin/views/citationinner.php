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
												<form action="/admin/citations/updatecitationinner/" method="POST" enctype="multipart/form-data" class="search_form general_form">
													<fieldset>
														<input type="hidden" name="id" value="<?=$this->view->citationinner['id'];?>" />
														<div class="forms">
														<div class="row">
															<label>Цытата:</label>
															<div class="inputs">
																<span class="input_wrapper textarea_wrapper">
																	<textarea name="detail_text" class="text"><?=$this->view->citationinner['detail_text'];?></textarea>
																</span>
															</div>
														</div>
														<div class="row">
															<label>Цытата(English):</label>
															<div class="inputs">
																<span class="input_wrapper textarea_wrapper">
																	<textarea name="detail_text_en" class="text"><?=$this->view->citationinner['detail_text_en'];?></textarea>
																</span>
															</div>
														</div>
														<div class="row">
                                                                <label>Маленькая картинка:</label>
                                                                <div class="inputs">
																<span class="input_wrapper blank">
																	<? if($this->view->citationinner['preview_name']){?>
                                                                    <img src="<?=$this->view->citationinner['preview'];?>"/>
                                                                    <input name="preview" type="hidden" value="<?=$this->view->citationinner['preview'];?>">
                                                                    <?}?>
                                                                    <input name="small_image" type="file"></span>
                                                                </div>
                                                            </div>
                                                       <div class="row">
															<label>Сайт:</label>
															<div class="inputs">
																<span class="input_wrapper blank">
																	<select name="siteid">
																		<option></option>
																		<? foreach($this->view->sites as $site){?>
																		<option<?=($site['id']==$this->view->citationinner['siteid'])?' selected=selected':'';?> value="<?=$site['id'];?>"><?=$site['name'];?></option>
																		<?}?>
																	</select>
																</span>
															</div>
														</div>
                                                    	<div class="row">
															<label>Отображать: </label>
															<div class="inputs">
																<ul class="inline">
																	<li><input class="checkbox" name="active" value="1" <?=($this->view->citationinner['active'])?'checked="checked"':'';?> type="checkbox" /></li>
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