<div class="section">
						<div class="title_wrapper">
							<h2>Заявка</h2>
							<span class="title_wrapper_left"></span>
							<span class="title_wrapper_right"></span>
						</div>
						<div class="section_content">
							<div class="sct">
								<div class="sct_left">
									<div class="sct_right">
										<div class="sct_left">
											<div class="sct_right">
												<form action="/admin/sites/updateaplicationinner/" method="POST" enctype="multipart/form-data" class="search_form general_form">
													<fieldset>
														<input type="hidden" name="id" value="<?=$this->view->aplication['id'];?>" />
														<input type="hidden" name="userid" value="<?=$this->view->application['userid'];?>" />
														<div class="forms">
														<div class="row">
															<label>Название:</label>
															<div class="inputs">
																<span class="input_wrapper"><input disabled="disabled" class="text" value="<?=$this->view->aplication['name'];?>" name="name" type="text"/></span>
															</div>
														</div>
														<div class="row">
                                                            <label>Email:</label>
                                                            <div class="inputs">
                                                                <span class="input_wrapper"><input disabled="disabled" class="text" value="<?=$this->view->aplication['email'];?>" name="email" type="text"/></span>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label>Телефон:</label>
                                                            <div class="inputs">
                                                                <span class="input_wrapper"><input disabled="disabled" class="text" value="<?=$this->view->aplication['phone'];?>" name="phone" type="text"/></span>
                                                            </div>
                                                        </div>
                                                         <div class="row">
                                                            <label>Дата рождения:</label>
                                                            <div class="inputs">
                                                                <span class="input_wrapper"><input disabled="disabled" class="text" value="<?=$this->view->aplication['date_birth'];?>" name="date_birth" type="text"/></span>
                                                            </div>
                                                        </div>
                                                         <div class="row">
                                                            <label>Ссылка на работы:</label>
                                                            <div class="inputs">
                                                                <span class="input_wrapper"><input disabled="disabled" class="text" value="<?=$this->view->aplication['url'];?>" name="url" type="text"/></span>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label>Описание:</label>
                                                            <div class="inputs">
                                                                <span class="input_wrapper textarea_wrapper">
                                                                    <textarea name="description" class="text"><?=$this->view->aplication['description'];?></textarea>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label>Просмотрено: </label>
                                                            <div class="inputs">
                                                                <ul class="inline">
                                                                    <li><input class="checkbox" name="active" value="1" <?=($this->view->aplication['active'])?'checked="checked"':'';?> type="checkbox" /></li>
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