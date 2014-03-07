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
                            <form action="/admin/users/" class="search_form general_form">
                                <!--[if !ie]>start fieldset<![endif]-->
                                <fieldset>
                                    <!--[if !ie]>start forms<![endif]-->
                                    <div class="forms">

                                        <!--[if !ie]>start row<![endif]-->
                                        <div class="row">
                                            <label>E-mail:</label>
                                            <div class="inputs">
                                                <span class="input_wrapper"><input class="text" name="email" type="text" value="<?=$_GET['email'];?>" /></span>
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
							<h2>Пользователи</h2>
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
                                                        <?
                                                            $url='/admin/users/';
                                                            $sortArr=array('asc'=>'desc','desc'=>'asc');
                                                        ?>
													<table cellpadding="0" cellspacing="0" width="100%">
														<tbody><tr>
															<th style="width: 36px;"><a href="<?=$url;?>?sorttype=id&sort=<?=($_GET['sorttype']=='id')?$sortArr[$_GET['sort']]:'asc';?>" <?=($_GET['sorttype']=='id')?' class="'.$_GET['sort'].'"':'';?>>Id</a></th>
                                                            <th><a href="<?=$url;?>?sorttype=email&sort=<?=($_GET['sorttype']=='email')?$sortArr[$_GET['sort']]:'asc';?>" <?=($_GET['sorttype']=='email')?' class="'.$_GET['sort'].'"':'';?>>E-mail</a></th>
                                                            <th style="width: 78px;"><a href="<?=$url;?>?sorttype=hassite&sort=<?=($_GET['sorttype']=='hassite')?$sortArr[$_GET['sort']]:'asc';?>" <?=($_GET['sorttype']=='hassite')?' class="'.$_GET['sort'].'"':'';?>>Есть сайт</a></th>
                                                            <th style="width: 133px;"><a href="<?=$url;?>?sorttype=date_create&sort=<?=($_GET['sorttype']=='date_create')?$sortArr[$_GET['sort']]:'asc';?>" <?=($_GET['sorttype']=='date_create')?' class="'.$_GET['sort'].'"':'';?>>Дата регистрации</a></th>
                                                        </tr>

														<? if(is_array($this->view->userlist)){
														$linecss=array(0=>'first', 1=>'second');
														$cnt=0;
														foreach($this->view->userlist as $userdata){
														if($cnt==2)
														$cnt=0;
														if($userdata['url'])
														$userdata['url']='<a class="product_thumb" href="/admin/user/'.$userdata['id'].'/"><img src="'.$userdata['url'].'"/></a>';
														?>
														<tr class="<?=$linecss[$cnt];?>">
															<td><?=$userdata['id'];?></td>
															<td><?=$userdata['email'];?></td>
                                                            <td><? if($userdata['hassite']>0){?><span class="approved">&nbsp;</span><?}?></td>
                                                            <td><?=$userdata['date_create'];?></td>

														</tr>
														<?
														$cnt++;
														}
														}?>
														
														
														
														
													</tbody></table>
													</div>
												</div>

                                                <?=$this->view->pager;?>

												
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