                    <!-- cart -->
                    <section class="profile-services">

                        <!-- cart header -->
                        <header class="profile-services__header">
                            <h2 class="profile-services__header-title"><?=$this->view->translate['joinus'];?></h2>
                        </header>
                        <!--/cart header -->

                        <!-- cart form -->
                        <form class="profile-services__form" action="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/user/apply/">

                            <!-- cart fieldset row -->
                            <div class="cart-pushcase__fieldset-row">

                                <!-- fieldset 1 -->
                                <fieldset class="cart-pushcase__fieldset">
                                    <input name="name" type="text" class="cart-pushcase__input cart-pushcase__input_address" value="" placeholder="<?=$this->view->translate['name'];?>" required />
                                </fieldset>
                                <!--/fieldset 1 -->

                                <!-- fieldset 2 -->
                                <!-- fieldset 1 -->
                                <fieldset class="cart-pushcase__fieldset">

                                    <select name="country" class="cart-pushcase__select-element cart-pushcase__select_country" data-placeholder="<?=$this->view->translate['country'];?>" >
                                        <? foreach($this->view->countries as $country){?>
                                        <option value="<?=$country['id'];?>"><?=$country['name'];?></option>
                                        <?}?>
                                    </select>

                                </fieldset>
                                <!--/fieldset 1 -->
                                <!--/fieldset 2 -->

                            </div>
                            <!--/cart fieldset row -->

                            <!-- cart fieldset row -->
                            <div class="cart-pushcase__fieldset-row">

                                <!-- fieldset 1 -->
                                <fieldset class="cart-pushcase__fieldset">
                                    <input name="tel" type="tel" class="cart-pushcase__input cart-pushcase__input_phone" value="" placeholder="<?=$this->view->translate['phone'];?>" required />
                                </fieldset>
                                <!--/fieldset 1 -->

                                <!-- fieldset 2 -->
                                <fieldset class="cart-pushcase__fieldset profile-services-membership_day">
                                    <input name="day" type="text" class="cart-pushcase__input cart-pushcase__input_day" value="" autocomplete="off" placeholder="<?=$this->view->translate['day'];?>" required />
                                </fieldset>
                                <!--/fieldset 2 -->

                                <!-- fieldset 3 -->
                                <fieldset class="cart-pushcase__fieldset profile-services-membership_month">
                                    <input name="month" type="text" class="cart-pushcase__input cart-pushcase__input_month" value="" autocomplete="off" placeholder="<?=$this->view->translate['month'];?>" required />
                                </fieldset>
                                <!--/fieldset 3 -->

                                <!-- fieldset 4 -->
                                <fieldset class="cart-pushcase__fieldset profile-services-membership_year">
                                    <input name="year" type="text" class="cart-pushcase__input cart-pushcase__input_year" value="" autocomplete="off" placeholder="<?=$this->view->translate['year'];?>" required />
                                </fieldset>
                                <!--/fieldset 4 -->

                                <span class="cart-pushcase__fieldset__text"><?=$this->view->translate['оfbirth'];?></span>

                            </div>
                            <!--/cart fieldset row -->

                            <!-- cart fieldset row -->
                            <div class="cart-pushcase__fieldset-row">

                                <!-- fieldset 1 -->
                                <fieldset class="cart-pushcase__fieldset">
                                    <input name="email" type="email" class="cart-pushcase__input cart-pushcase__input_email" value="" autocomplete="off" placeholder="e-mail" required />
                                </fieldset>
                                <!--/fieldset 1 -->

                                <!-- fieldset 2 -->
                                <fieldset class="cart-pushcase__fieldset">
                                    <input name="reference" type="text" class="cart-pushcase__input cart-pushcase__input_reference-to-work" value="" autocomplete="off" placeholder="<?=$this->view->translate['workslink'];?>" required />
                                </fieldset>
                                <!--/fieldset 2 -->

                            </div>
                            <!--/cart fieldset row -->

                            <!-- cart fieldset row -->
                            <div class="cart-pushcase__fieldset-row cart-pushcase_textarea">

                                <fieldset class="cart-pushcase__fieldset cart-pushcase__fieldset_textarea" >
                                    <textarea name="description" required class="cart-pushcase__textarea" placeholder="<?=$this->view->translate['comments'];?>"></textarea>
                                </fieldset>

                            </div>
                            <!--/cart fieldset row -->

                            <!-- submit button -->
                            <div class="cart-pushcase__submit-wrap">
                                <input type="submit" class="cart-pushcase__button-submit profile-services-membership_submit" value="<?=$this->view->translate['apply'];?>" formnovalidate />
                            </div>
                            <!--/submit button -->

                        </form>
                        <!--/cart form -->

                    </section>
                    <!-- /cart -->