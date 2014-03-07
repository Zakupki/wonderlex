<div class="section">
						<div class="title_wrapper">
							<h2>Заказы</h2>
							<span class="title_wrapper_left"></span>
							<span class="title_wrapper_right"></span>
						</div>
						<div class="section_content">
							<div class="sct">
								<div class="sct_left">
									<div class="sct_right">
										<div class="sct_left">
											<div class="sct_right">
												<form action="/admin/order/updateorderinner/" method="POST" enctype="multipart/form-data" class="search_form general_form">
													<fieldset>
														<input type="hidden" name="id" value="<?=$this->view->order['id'];?>" />
														<div class="forms">
														<div class="row">
                                                        <label>Id:</label>
                                                            <div class="inputs">
                                                                <span class="input_wrapper"><input class="text" disabled="disabled" name="id" value="<?=$this->view->order['id'];?>" type="text"/></span>
                                                            </div>
                                                        </div>
														<div class="row">
														<label>Товар:</label>
															<div class="inputs">
																<span class="input_wrapper"><input class="text" disabled="disabled" name="name" value="<?=$this->view->order['name'];?>" type="text"/></span>
															</div>
														</div>
														<div class="row">
                                                        <label>Дата заказа:</label>
                                                            <div class="inputs">
                                                                <span class="input_wrapper"><input class="text" disabled="disabled" value="<?=$this->view->order['date_create'];?>" type="text"/></span>
                                                            </div>
                                                        </div>
														<div class="row">
                                                        <label>Страна:</label>
                                                            <div class="inputs">
                                                                <span class="input_wrapper"><input class="text" disabled="disabled" value="<?=$this->view->order['country'];?>" type="text"/></span>
                                                            </div>
                                                        </div>
														<div class="row">
                                                        <label>Город:</label>
                                                            <div class="inputs">
                                                                <span class="input_wrapper"><input class="text" disabled="disabled" value="<?=$this->view->order['city'];?>" type="text"/></span>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                        <label>Индекс:</label>
                                                            <div class="inputs">
                                                                <span class="input_wrapper"><input class="text" disabled="disabled" value="<?=$this->view->order['postindex'];?>" type="text"/></span>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                        <label>Телефон:</label>
                                                            <div class="inputs">
                                                                <span class="input_wrapper"><input class="text" disabled="disabled" value="<?=$this->view->order['tel'];?>" type="text"/></span>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                        <label>Описание:</label>
                                                            <div class="inputs">
                                                                <span class="input_wrapper"><input class="text" disabled="disabled" value="<?=$this->view->order['description'];?>" type="text"/></span>
                                                            </div>
                                                        </div>
														<div class="row">
                                                        <label>Цена:</label>
                                                            <div class="inputs">
                                                                <span class="input_wrapper"><input class="text" name="price" value="<?=$this->view->order['price'];?>" type="text"/></span>
                                                            </div>
                                                        </div>
														
														<div class="row">
                                                            <label>Активность: </label>
                                                            <div class="inputs">
                                                                <ul class="inline">
                                                                    <li><input class="checkbox" name="acticve" value="1" <?=($this->view->order['active'])?'checked="checked"':'';?> type="checkbox" /></li>
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