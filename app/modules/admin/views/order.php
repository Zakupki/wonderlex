<div class="section table_section">
						<!--[if !IE]>start title wrapper<![endif]-->
						<div class="title_wrapper">
							<h2>Заказы</h2>
							<span class="title_wrapper_left"></span>
							<span class="title_wrapper_right"></span>
						</div>
						<!--[if !IE]>end title wrapper<![endif]-->
						<!--[if !IE]>start section content<![endif]-->
						<div class="section_content">
							<!--[if !IE]>start section content top<![endif]-->
							<div class="sct">
								<div class="sct_left">
									<div class="sct_right">
										<div class="sct_left">
											<div class="sct_right">
												
												<form action="#">
												<fieldset>
												<!--[if !IE]>start table_wrapper<![endif]-->
												<div class="table_wrapper">
													<div class="table_wrapper_inner">
													<table cellpadding="0" cellspacing="0" width="100%">
														<tbody>
														<tr>
															<th style="width: 36px;">Id</th>
															<th></th>
															<th>Название</th>
															<th>Пользователь</th>
															<th>Дата заказа</th>
														</tr>
														<!--<tr class="first">
															<td>1.</td>
															<td><span class="approved">Approved</span></td>
															<td>FB-H061</td>
															<td>Elaine Rosen</td>
															<td>06/18/2008</td>
															<td>$106.38</td>
															<td style="width: 96px;">
																<div class="actions">
																	<ul>
																		<li><a class="action1" href="#">1</a></li>
																		<li><a class="action2" href="#">2</a></li>
																		<li><a class="action3" href="#">3</a></li>
																		<li><a class="action4" href="#">4</a></li>
																		<li><input class="radio" name="" type="checkbox" value="" /></li>
																	</ul>
																</div>
															</td>
														</tr>-->
														<? if(is_array($this->view->orderlist)){
														$linecss=array(0=>'first', 1=>'second');
														$cnt=0;
														foreach($this->view->orderlist as $social){
														if($social['url'])
														$social['url']='<a class="product_thumb" href="/admin/order/'.$social['id'].'/"><img width="20" height="20" src="'.$social['url'].'"/></a>';
														?>
														<tr class="<?=$linecss[$cnt];?>">
															<td><?=$social['id'];?></td>
															<td class="photo"><?=$social['url'];?></td>
															<td><a class="product_name" href="/admin/order/<?=$social['id'];?>/"><?=$social['name'];?></a></td>
															<td><?=$social['email'];?></td>
															<td><?=$social['date_create'];?></td>
														</tr>
														<?
														$cnt++;
														}
														}?>
														
														
														
														
													</tbody></table>
													</div>
												</div>
												<!--[if !IE]>end table_wrapper<![endif]-->
												
												<!--[if !IE]>start table menu<![endif]-->
												<div class="table_menu">
													<!--
													<ul class="left">
														<li><a href="#" class="button add_new"><span><span>ADD NEW</span></span></a></li>
													</ul>
													<ul class="right">
														<li><a href="#" class="button check_all"><span><span>CHECK ALL</span></span></a></li>
														<li><a href="#" class="button uncheck_all"><span><span>UNCHECK ALL</span></span></a></li>
														<li><span class="button approve"><span><span>APPROVE</span></span></span></li>
													</ul>
													-->
												</div>
												<!--[if !IE]>end table menu<![endif]-->
												
												
												</fieldset>
												</form>
												
												
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--[if !IE]>end section content top<![endif]-->
							<!--[if !IE]>start section content bottom<![endif]-->
							<span class="scb"><span class="scb_left"></span><span class="scb_right"></span></span>
							<!--[if !IE]>end section content bottom<![endif]-->
							
						</div>
						<!--[if !IE]>end section content<![endif]-->
					</div>