  <!-- cart -->
                    <section class="profile-history">

                        <!-- cart header -->
                        <header class="profile-history__header">
                            <h2 class="profile-history__header-title"><?=$this->view->translate['history'];?></h2>

                            <!-- history toggle control -->
                            <!--<div class="profile-history__header-control">
                                <span id="profile-history_shopping-button" class="profile-history__header-control-text profile-history__header-control_active">Покупок</span>
                                    <div class="profile-history__header-control-wrap ">
                                        <div class="profile-history__header-control-slider ui-slider-handle">
                                            <div id="profile-history__header-button" class="profile-history__header-button"></div>
                                        </div>
                                    </div>
                                <span id="profile-history_review-button" class="profile-history__header-control-text">Просмотров</span>
                            </div>-->
                            <!--/history toggle control -->

                        </header>
                        <!--/cart header -->

                        <div class="profile-history__list-wrap">

                            <!-- profile history list -->
                            <ul id="profile-history_shopping" class="profile-history__list profile-history__list-active" data-php="/user/edithistory/" data-step="10">

                                <!-- profile history item -->
                                <? foreach($this->view->products as $product){?>
                                <li class="profile-history__item" data-id="<?=$product['itemid'];?>">

                                    <div class="profile-history__img-wrap">
                                        <a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/"><img src="<?=$product['url'];?>" width="50" height="50" alt="" /></a>
                                    </div>

                                    <div class="profile-history__description">
                                       <a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/">
                                        <span class="profile-history__item-name"><?=$product['name'];?></span>
                                        <span class="profile-history__author-name"><?=$product['sitename'];?></span>
                                       </a>
                                    </div>

                                    <div class="profile-history__price-date">
                                        <span class="profile-history__price"><?=$product['price'];?> <?=$product['curname'];?></span>
                                        <span class="profile-history__date"><?=$product['date_create'];?></span>
                                    </div>

                                    <div class="profile-history__remove-button"></div>

                                </li>
                                <?}?>
                                <!--/profile history item -->

                                

                            </ul>
                            <!--/profile history list -->

                            <!-- profile history list -->
                            <ul id="profile-history_review"  class="profile-history__list" data-php="php/profile-history.php">

                                <!-- profile history item -->
                                <li class="profile-history__item" data-id="5">

                                    <div class="profile-history__img-wrap">
                                        <img src="/img/main/pic/profile-history-img.jpg" width="50" height="50" alt="" />
                                    </div>

                                    <div class="profile-history__description">
                                        <span class="profile-history__item-name">Жажда общения с методом</span>
                                        <span class="profile-history__author-name">Наташа Егорова</span>
                                    </div>

                                    <div class="profile-history__price-date">
                                        <span class="profile-history__price">28 900 грн</span>
                                        <span class="profile-history__date">12.07.2012</span>
                                    </div>

                                    <div class="profile-history__remove-button"></div>

                                </li>
                                <!--/profile history item -->
                                
                            </ul>
                            <!--/profile history list -->

                        </div>

                    </section>
                    <!-- /cart -->