                    <!-- cart -->
                    <section class="cart">

                        <!-- cart header -->
                        <header class="cart__header cart__header_noborder">
                            <h1 class="cart__header-title">Заказ</h1>
                            <div class="cart__header-txt"><span class="cart__header-count">1</span> товар – <span class="cart__header-price"><?=$this->view->product['price'];?> грн</span></div>
                        </header>
                        <!--/cart header -->

                        <!-- cart form -->
                        <form class="cart-pushcase__form" method="post" action="/basket/makepurchase/">
                            <input type="hidden" value="<?=$this->view->product['itemid'];?>" name="itemid"/>
                            <input type="hidden" value="<?=$this->view->product['price'];?>" name="price"/>
                            <!-- cart fieldset row -->
                            <div class="cart-pushcase__fieldset-row">

                                <!-- fieldset 1 -->
                                <fieldset class="cart-pushcase__fieldset">
                                    <? tools::print_r($this->view->product); ?>

                                    <select name="country" class="cart-pushcase__select-element cart-pushcase__select_country" data-placeholder="Страна" >
                                        <? foreach($this->view->countries as $country){?>
                                        <option value="<?=$country['id'];?>"><?=$country['name'];?></option>
                                        <?}?>
                                    </select>

                                </fieldset>
                                <!--/fieldset 1 -->

                                <!-- fieldset 2 -->
                                <fieldset class="cart-pushcase__fieldset">

                                    <select name="city" class="cart-pushcase__select-element cart-pushcase__select_city" data-placeholder="Город"></select>

                                </fieldset>
                                <!--/fieldset 2 -->

                            </div>
                            <!--/cart fieldset row -->

                            <!-- cart fieldset row -->
                            <div class="cart-pushcase__fieldset-row">

                                <!-- fieldset 1 -->
                                <fieldset class="cart-pushcase__fieldset">
                                    <input name="address" type="text" class="cart-pushcase__input cart-pushcase__input_address" value="" placeholder="Адрес" required />
                                </fieldset>
                                <!--/fieldset 1 -->

                                <!-- fieldset 2 -->
                                <fieldset class="cart-pushcase__fieldset">
                                    <input name="index" type="text" class="cart-pushcase__input cart-pushcase__input_index" value="" placeholder="Индекс" required />
                                </fieldset>
                                <!--/fieldset 2 -->

                            </div>
                            <!--/cart fieldset row -->

                            <!-- cart fieldset row -->
                            <div class="cart-pushcase__fieldset-row">

                                <fieldset class="cart-pushcase__fieldset">
                                    <input name="tel" type="tel" class="cart-pushcase__input cart-pushcase__input_phone" value="" placeholder="Телефон" required />
                                </fieldset>

                            </div>
                            <!--/cart fieldset row -->

                            <!-- cart fieldset row -->
                            <div class="cart-pushcase__fieldset-row cart-pushcase_textarea">

                                <fieldset class="cart-pushcase__fieldset cart-pushcase__fieldset_textarea" >
                                    <textarea name="description" placeholder="Комментарий" required class="cart-pushcase__textarea"></textarea>
                                </fieldset>

                            </div>
                            <!--/cart fieldset row -->

                            <!-- cart fieldset row -->
                            <!--<div class="cart-pushcase__fieldset-row">

                                <fieldset class="cart-pushcase__fieldset">

                                    <select name="payment" class="cart-pushcase__select-element" data-placeholder="Способ оплаты" >
                                        <option value="1">Наличный расчет</option>
                                        <option value="2">Безналичный расчет</option>
                                    </select>

                                </fieldset>
                                
                                <fieldset class="cart-pushcase__fieldset">

                                    <select name="delivery" class="cart-pushcase__select-element " data-placeholder="Способо доставки" >
                                        <option value="1">Авто</option>
                                        <option value="2">Поезд</option>
                                        <option value="3">Самолет</option>
                                    </select>

                                </fieldset>

                            </div>-->
                            <!--/cart fieldset row -->

                            <!-- submit button -->
                            <div class="cart-pushcase__submit-wrap">
                                <button class="cart-pushcase__button-submit" type="submit" formnovalidate>
                                    <span class="cart-pushcase__button-submit-text">Заказать<span class="cart-pushcase__button-submit-sum"> – <?=$this->view->product['price'];?> грн</span></span>
                                </button>
                            </div>
                            <!--/submit button -->

                            <!-- bank card -->
                            <ul class="cart-pushcase__bank-card-list">
                                <li class="cart-pushcase__bank-card-item"><img src="/img/main/pic/bank-card1.png" width="131" height="49"  alt=""/></li>
                                <li class="cart-pushcase__bank-card-item"><img src="/img/main/pic/bank-card2.png" width="132" height="49" alt="" /></li>
                                <li class="cart-pushcase__bank-card-item"><img src="/img/main/pic/bank-card3.png" width="120" height="49"  alt="" /></li>
                            </ul>
                            <!--/bank card -->

                        </form>
                        <!--/cart form -->

                    </section>
                    <!-- /cart -->