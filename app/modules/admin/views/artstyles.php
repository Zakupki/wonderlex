<div class="section table_section">
						<!--[if !IE]>start title wrapper<![endif]-->
						<div class="title_wrapper">
							<h2>Стили и направления в искусстве</h2>
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
															<th>Название</th>
															<th style="width: 140px;"></th>
														</tr>
														
														<? if(is_array($this->view->artstyles)){
														$linecss=array(0=>'first', 1=>'second');
														$cnt=0;
														foreach($this->view->artstyles as $site){
														if($cnt==2)
														$cnt=0;
														?>
														<tr class="<?=$linecss[$cnt];?>">
															<td><?=$site['id'];?></td>
															<td><a class="product_name" href="/admin/arttype/style/<?=$site['id'];?>/"><?=$site['name'];?></a></td>
														    <td>
                                                                <div class="actions_menu" style="width: 140px;">
                                                                    <ul>
                                                                        
                                                                        <li><a class="edit" href="/admin/arttype/style/<?=$site['id'];?>/">Edit</a></li>
                                                                        <li><a class="delete" href="/admin/arttype/deleteartstyle/?id=<?=$site['id'];?>">Delete</a></li>
                                                                    </ul>
                                                                </div>
                                                            </td>
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
													<ul class="left">
														<li><a href="/admin/arttype/style/new/" class="button add_new"><span><span>Добавить</span></span></a></li>
													</ul>
												<!--[if !IE]>end table menu<![endif]-->
												
												
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