                    <!-- cart -->
                    <section class="profile-settings">

                        <!-- cart header -->
                        <header class="profile-settings__header">
                            <h2 class="profile-settings__header-title"><?=$this->view->translate['settings'];?></h2>
                        </header>
                        <!--/cart header -->

                        <!-- cart form -->
                        <form class="profile-settings__form" action="/user/updateprofile/">
							<input type="hidden" name="userid" value="<?=$_SESSION['User']['id'];?>"/>
                            <!-- cart fieldset row -->
                            <div class="cart-pushcase__fieldset-row">

                                <!-- fieldset 1 -->
                                <fieldset class="cart-pushcase__fieldset">
                                    <input name="name" type="text" class="cart-pushcase__input cart-pushcase__input_address" value="<?=$this->view->profile['firstName'];?>" placeholder="<?=$this->view->translate['name'];?>" required />
                                </fieldset>
                                <!--/fieldset 1 -->

                                <!-- fieldset 2 -->
                                <fieldset class="cart-pushcase__fieldset">
                                    <input name="email" type="email" class="cart-pushcase__input cart-pushcase__input_index" disabled="disabled" value="<?=$this->view->profile['email'];?>" placeholder="e-mail"/>
                                </fieldset>
                                <!--/fieldset 2 -->

                            </div>
                            <!--/cart fieldset row -->

                            <!-- cart fieldset row -->
                            <div class="cart-pushcase__fieldset-row">

                                <!-- fieldset 1 -->
                                <fieldset class="cart-pushcase__fieldset">
                                    <input name="password" type="password" class="cart-pushcase__input cart-pushcase__input_password" value="" placeholder="<?=$this->view->translate['password'];?>" />
                                </fieldset>
                                <!--/fieldset 1 -->

                                <!-- fieldset 2 -->
                                <fieldset class="cart-pushcase__fieldset">
                                    <input name="confirm-password" type="password" class="cart-pushcase__input cart-pushcase__input_confirm-password" value="" placeholder="<?=$this->view->translate['confirmation'];?>" />
                                </fieldset>
                                <!--/fieldset 2 -->

                            </div>
                            <!--/cart fieldset row -->

                            <!-- cart fieldset row -->
                            <div class="cart-pushcase__fieldset-row">

                                <!-- fieldset 1 -->
                                <fieldset class="cart-pushcase__fieldset">
                                    <input name="site" type="text" class="cart-pushcase__input cart-pushcase__input_site" disabled="disabled" value="<?=$this->view->profile['domain'];?>" placeholder="<?=$this->view->translate['site'];?>"  />
                                </fieldset>
                                <!--/fieldset 1 -->

                                <!-- fieldset 2 -->
                                <fieldset class="cart-pushcase__fieldset">
                                    <input name="facebook" type="text" class="cart-pushcase__input cart-pushcase__input_facebook" value="<?=$this->view->profile['facebook'];?>" placeholder="facebook"  />
                                </fieldset>
                                <!--/fieldset 2 -->

                            </div>
                            <!--/cart fieldset row -->

                            <!-- cart fieldset row -->
                            <div class="cart-pushcase__fieldset-row">

                                <!-- fieldset 1 -->
                                <fieldset class="cart-pushcase__fieldset">
                                    <input name="twitter" type="text" class="cart-pushcase__input cart-pushcase__input_twitter" value="<?=$this->view->profile['twitter'];?>" placeholder="twitter"  />
                                </fieldset>
                                <!--/fieldset 1 -->

                                <!-- fieldset 2 -->
                                <fieldset class="cart-pushcase__fieldset">
                                    <input name="vkontakte" type="text" class="cart-pushcase__input cart-pushcase__input_vk" value="<?=$this->view->profile['vkontakte'];?>" placeholder="vkontakte"  />
                                </fieldset>
                                <!--/fieldset 2 -->

                            </div>
                            <!--/cart fieldset row -->


                            <!-- submit button -->
                            <div class="cart-pushcase__submit-wrap">
                                <input type="submit" class="cart-pushcase__button-submit" value="<?=$this->view->translate['save'];?>" formnovalidate />
                            </div>
                            <!--/submit button -->

                        </form>
                        <!--/cart form -->

                    </section>
                    <!-- /cart -->