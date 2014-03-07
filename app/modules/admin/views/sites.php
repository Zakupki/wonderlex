        <div class="section">
            <!--[if !ie]>start title wrapper<![endif]-->
            <div class="title_wrapper">
                <h2>Поиск</h2>
                <span class="title_wrapper_left"></span>
                <span class="title_wrapper_right"></span>
            </div>
            <!--[if !ie]>end title wrapper<![endif]-->
            <!--[if !ie]>start section content<![endif]-->
            <div class="section_content">
                <!--[if !ie]>start section content top<![endif]-->
                <div class="sct">
                    <div class="sct_left">
                        <div class="sct_right">
                            <div class="sct_left">
                                <div class="sct_right">
                                    <!--[if !ie]>start forms<![endif]-->
                                    <form action="/admin/sites/" class="search_form general_form">
                                        <!--[if !ie]>start fieldset<![endif]-->
                                        <fieldset>
                                            <!--[if !ie]>start forms<![endif]-->
                                            <div class="forms">

                                                <!--[if !ie]>start row<![endif]-->
                                                <div class="row">
                                                    <label>Название:</label>
                                                    <div class="inputs">
                                                        <span class="input_wrapper"><input class="text" name="name" type="text" value="<?=$_GET['name'];?>" /></span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label>Домен:</label>
                                                    <div class="inputs">
                                                        <span class="input_wrapper"><input class="text" name="domain" type="text" value="<?=$_GET['domain'];?>" /></span>
                                                    </div>
                                                </div>
                                                <!--[if !ie]>end row<![endif]-->

                                                <!--[if !ie]>start row<![endif]-->
                                                <div class="row">
                                                    <div class="buttons">
                                                        <ul>
                                                            <li><span class="button send_form_btn"><span><span>Поиск</span></span><input name="" type="submit" /></span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <!--[if !ie]>end row<![endif]-->
                                            </div>
                                            <!--[if !ie]>end forms<![endif]-->
                                        </fieldset>
                                        <!--[if !ie]>end fieldset<![endif]-->
                                    </form>
                                    <!--[if !ie]>end forms<![endif]-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--[if !ie]>end section content top<![endif]-->
                <!--[if !ie]>start section content bottom<![endif]-->
                <span class="scb"><span class="scb_left"></span><span class="scb_right"></span></span>
                <!--[if !ie]>end section content bottom<![endif]-->

            </div>
            <!--[if !ie]>end section content<![endif]-->
        </div>
        <!--[if !ie]>end section<![endif]-->
                <div class="section table_section">
						<!--[if !IE]>start title wrapper<![endif]-->
						<div class="title_wrapper">
							<h2>Сайты</h2>
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
															<th>Автор</th>
															<th>Email</th>
															<th>Пароль</th>
															<th>Тип</th>
															<th>Сортировка</th>
															<th>Промо</th>
															<th>Домен</th>
														</tr>
														
														<? if(is_array($this->view->sitelist)){
														$linecss=array(0=>'first', 1=>'second');
														$cnt=0;
														foreach($this->view->sitelist as $site){
														if($site['password']=='1cd803e2056d145af0e94dae20538b2e')
															$site['password']='123qwe';
														else 
															$site['password']=null;
														
															
														if($cnt==2)
														$cnt=0;
														if($site['domain'])
														$site['domain']='<a target="_blank" href="http://'.$site['domain'].'/">http://'.$site['domain'].'</a>';
														else
														$site['domain']='<a target="_blank" href="http://w'.$site['id'].'.wonderlex.com/">http://w'.$site['id'].'.wonderlex.com</a>';
														if($site['url'])
														$site['url']='<a class="product_thumb" href="/admin/site/'.$site['id'].'/"><img src="'.$site['url'].'"/></a>';
														?>
														<tr class="<?=$linecss[$cnt];?>">
															<td<?=($_GET['new']==$site['id'])?' style="background: #ffb49a"':'';?>><?=$site['id'];?></td>
															<td<?=($_GET['new']==$site['id'])?' style="background: #ffb49a"':'';?>><a class="product_name" href="/admin/site/<?=$site['id'];?>/"><?=$site['name'];?></a></td>
															<td<?=($_GET['new']==$site['id'])?' style="background: #ffb49a"':'';?>><a href="/admin/user/<?=$site['userid'];?>/"><?=$site['login'];?></a></td>
															<td<?=($_GET['new']==$site['id'])?' style="background: #ffb49a"':'';?>><?=$site['email'];?></td>
															<td<?=($_GET['new']==$site['id'])?' style="background: #ffb49a"':'';?>><?=$site['password'];?></td>
															<td<?=($_GET['new']==$site['id'])?' style="background: #ffb49a"':'';?>><?=$site['sitetype'];?></td>
															<td<?=($_GET['new']==$site['id'])?' style="background: #ffb49a"':'';?>><?=$site['sort'];?></td>
															<td<?=($_GET['new']==$site['id'])?' style="background: #ffb49a"':'';?>><?=($site['promo'])? '<span class="approved">&nbsp;</span>':'';?></td>
															<td<?=($_GET['new']==$site['id'])?' style="background: #ffb49a"':'';?>><?=$site['domain'];?></td>
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
														<li><a href="/admin/site/" class="button add_new"><span><span>Добавить</span></span></a></li>
													</ul>
													<!--
													<ul class="right">
														<li><a href="#" class="button check_all"><span><span>CHECK ALL</span></span></a></li>
														<li><a href="#" class="button uncheck_all"><span><span>UNCHECK ALL</span></span></a></li>
														<li><span class="button approve"><span><span>APPROVE</span></span></span></li>
													</ul>
													-->
												</div>
												<!--[if !IE]>end table menu<![endif]-->

                                                <?=$this->view->pager;?>
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