
                    <!-- profile -->
                    <section class="profile">

                        <!-- profile header -->
                        <header class="profile__header-wrap">
                            <h2 class="profile__header">ваш w-сайт</h2>
                            <span class="profile__header-text">Спасибо за участие!</span>

                            <div class="profile__packet-control">
                                <div class="profile__packet-name"><?=$this->view->sitedata['planname'];?></div><a href="#" class="profile__packet-improve">Улучшить</a>
                            </div>

                        </header>
                        <!--/profile header -->

                        <!-- packet list -->
                        <div id="profile-packet-list" class="profile__packet-list_hidden">
                            <ul class="profile__packet-list">
                            <? foreach($this->view->siteplans as $plan){?>
                            <li class="profile__packet-list-item">
                                <div class="profile__packet-cell-wrap">
                                    <div class="profile__packet-item-wrap">
                                        <div class="profile__packet-item-name">
                                            <?=$plan['title'];?>
                                            <div class="profile__packet-info">
                                                <div class="profile__packet-info-text">
                                                    <div class="privasy">
                                                        <h2 class="privasy__title privasy__title_empty">Информация</h2>
                                                        <div class="scroll-inner scroll-privacy">
                                                            <div>
                                                                <div class="privasy__layout">
                                                                    <p class="privasy__txt">
                                                                        Соц-дем характеристика аудитории, отбрасывая подробности, стабилизирует эмпирический рекламный бриф, учитывая результат
                                                                        предыдущих медиа-кампаний. Таргетирование конструктивно.
                                                                    </p>
                                                                    <p class="privasy__txt">
                                                                        Пак-шот нетривиален. Рекламный клаттер пока плохо восстанавливает конвергентный инвестиционный продукт,
                                                                    </p>
                                                                    <h2 class="privasy__sub-title">пункт 1.1.</h2>
                                                                    <p class="privasy__txt">Такое понимание ситуации восходит к Эл Райс, при этом социальный статус спорадически программирует
                                                                        креативный целевой сегмент рынка, полагаясь на инсайдерскую информацию. Личность топ менеджера упорядочивает стратегический
                                                                        медиамикс, осознавая социальную ответственность бизнеса.
                                                                    </p>
                                                                    <p class="privasy__txt">Повышение жизненных стандартов, как следует из вышесказанного, недостижимо. Несмотря на сложности, маркетинговая</p>
                                                                    <h2 class="privasy__sub-title">пункт 1.1.</h2>
                                                                    <p class="privasy__txt">Рекламный клаттер абстрактен. Изменение глобальной стратегии, как принято считать, амбивалентно. Такое понимание
                                                                        ситуации восходит к Эл Райс, при этом перераспределение бюджета изящно синхронизирует комплексный фактор коммуникации, используя опыт
                                                                        предыдущих кампаний. Такое понимание ситуации восходит к Эл Райс, при этом социальный статус спорадически программирует креативный целевой
                                                                        сегмент рынка, полагаясь на инсайдерскую информацию. Личность топ менеджера упорядочивает стратегический медиамикс, осознавая социальную
                                                                        ответственность бизнеса.
                                                                    </p>
                                                                    <p class="privasy__txt">Повышение жизненных стандартов, как следует из вышесказанного, недостижимо. Несмотря на сложности, маркетинговая </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <? if($this->view->sitedata['planid']==$plan['id'] && $plan['id']!=1){?>
                                        <span class="profile__packet-item-description">Осталось <?=$this->view->sitedata['date_end'];?> дней</span>
                                        <?}else{?>
                                        <span class="profile__packet-item-description"><?=$plan['description'];?></span>    
                                        <?}?>
                                        <? if($plan['price']>0){?>
                                        <div class="profile__packet-cost"><?=$plan['price'];?>  <?=$plan['curname'];?><span class="profile__packet-sup">в год</span></div>
                                        <?}else{?>
                                        <div class="profile__packet-cost">free</div>
                                        <?}?> 
                                    </div>
                                    <div class="profile__packet-button-wrap">
                                        <? if($this->view->sitedata['planid']==$plan['id'] && $plan['id']!=1){?>
                                        <a href="/user/payforsite/?plan=<?=$plan['id'];?>&siteid=<?=$this->view->sitedata['id'];?>" class="profile__packet-button">продлить</a>
                                        <?}elseif($plan['id']!=1){?>
                                        <a href="/user/payforsite/?plan=<?=$plan['id'];?>&siteid=<?=$this->view->sitedata['id'];?>" class="profile__packet-button">купить</a>    
                                        <?}?>
                                    </div>
                                </div>
                            </li>
                            <?}?>

                            <!--<li class="profile__packet-list-item">
                                <div class="profile__packet-cell-wrap">
                                    <div class="profile__packet-item-wrap">
                                        <div class="profile__packet-item-name">Simple</div>
                                        <span class="profile__packet-item-description">осталось 12 дней</span>

                                        <div class="profile__packet-cost">$29<span class="profile__packet-sup">в год</span></div>
                                    </div>
                                    <div class="profile__packet-button-wrap">
                                        <a href="#" class="profile__packet-button">продлить</a>
                                    </div>
                                </div>
                            </li>

                            <li class="profile__packet-list-item">

                                <div class="profile__packet-cell-wrap">
                                    <div class="profile__packet-item-wrap">
                                        <div class="profile__packet-item-name">
                                            PRO
                                            <div class="profile__packet-info">
                                                <div class="profile__packet-info-text">
                                                    <div class="privasy">
                                                        <h2 class="privasy__title privasy__title_empty">Информация</h2>
                                                        <div class="scroll-inner scroll-privacy">
                                                            <div>
                                                                <div class="privasy__layout">
                                                                    <p class="privasy__txt">
                                                                        Соц-дем характеристика аудитории, отбрасывая подробности, стабилизирует эмпирический рекламный бриф, учитывая результат
                                                                        предыдущих медиа-кампаний. Таргетирование конструктивно.
                                                                    </p>
                                                                    <p class="privasy__txt">
                                                                        Пак-шот нетривиален. Рекламный клаттер пока плохо восстанавливает конвергентный инвестиционный продукт,
                                                                    </p>
                                                                    <h2 class="privasy__sub-title">пункт 1.1.</h2>
                                                                    <p class="privasy__txt">Такое понимание ситуации восходит к Эл Райс, при этом социальный статус спорадически программирует
                                                                        креативный целевой сегмент рынка, полагаясь на инсайдерскую информацию. Личность топ менеджера упорядочивает стратегический
                                                                        медиамикс, осознавая социальную ответственность бизнеса.
                                                                    </p>
                                                                    <p class="privasy__txt">Повышение жизненных стандартов, как следует из вышесказанного, недостижимо. Несмотря на сложности, маркетинговая</p>
                                                                    <h2 class="privasy__sub-title">пункт 1.1.</h2>
                                                                    <p class="privasy__txt">Рекламный клаттер абстрактен. Изменение глобальной стратегии, как принято считать, амбивалентно. Такое понимание
                                                                        ситуации восходит к Эл Райс, при этом перераспределение бюджета изящно синхронизирует комплексный фактор коммуникации, используя опыт
                                                                        предыдущих кампаний. Такое понимание ситуации восходит к Эл Райс, при этом социальный статус спорадически программирует креативный целевой
                                                                        сегмент рынка, полагаясь на инсайдерскую информацию. Личность топ менеджера упорядочивает стратегический медиамикс, осознавая социальную
                                                                        ответственность бизнеса.
                                                                    </p>
                                                                    <p class="privasy__txt">Повышение жизненных стандартов, как следует из вышесказанного, недостижимо. Несмотря на сложности, маркетинговая </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="profile__packet-item-description">+40 проектов</span>
                                        <span class="profile__packet-item-description">+5 категорий</span>

                                        <div class="profile__packet-cost">$49<span class="profile__packet-sup">в год</span></div>
                                    </div>

                                    <div class="profile__packet-button-wrap">
                                        <a href="#" class="profile__packet-button">купить</a>
                                    </div>
                                </div>

                            </li>

                            <li class="profile__packet-list-item">
                                <div class="profile__packet-cell-wrap">
                                    <div class="profile__packet-item-wrap">
                                        <div class="profile__packet-item-name">Unlim</div>
                                        <span class="profile__packet-item-description">Unlim проектов</span>
                                        <span class="profile__packet-item-description">и категорий</span>

                                        <div class="profile__packet-cost">$129<span class="profile__packet-sup">в год</span></div>
                                    </div>
                                    <div class="profile__packet-button-wrap">
                                        <a href="#" class="profile__packet-button">продлить</a>
                                    </div>
                                </div>
                            </li>

                            <li class="profile__packet-list-item active">
                                <div class="profile__packet-cell-wrap">
                                    <div class="profile__packet-item-wrap">
                                        <div class="profile__packet-item-name">
                                            content
                                            <div class="profile__packet-info">
                                                <div class="profile__packet-info-text">
                                                    <div class="privasy">
                                                        <h2 class="privasy__title privasy__title_empty">Информация</h2>
                                                        <div class="scroll-inner scroll-privacy">
                                                            <div>
                                                                <div class="privasy__layout">
                                                                    <p class="privasy__txt">
                                                                        Соц-дем характеристика аудитории, отбрасывая подробности, стабилизирует эмпирический рекламный бриф, учитывая результат
                                                                        предыдущих медиа-кампаний. Таргетирование конструктивно.
                                                                    </p>
                                                                    <p class="privasy__txt">
                                                                        Пак-шот нетривиален. Рекламный клаттер пока плохо восстанавливает конвергентный инвестиционный продукт,
                                                                    </p>
                                                                    <h2 class="privasy__sub-title">пункт 1.1.</h2>
                                                                    <p class="privasy__txt">Такое понимание ситуации восходит к Эл Райс, при этом социальный статус спорадически программирует
                                                                        креативный целевой сегмент рынка, полагаясь на инсайдерскую информацию. Личность топ менеджера упорядочивает стратегический
                                                                        медиамикс, осознавая социальную ответственность бизнеса.
                                                                    </p>
                                                                    <p class="privasy__txt">Повышение жизненных стандартов, как следует из вышесказанного, недостижимо. Несмотря на сложности, маркетинговая</p>
                                                                    <h2 class="privasy__sub-title">пункт 1.1.</h2>
                                                                    <p class="privasy__txt">Рекламный клаттер абстрактен. Изменение глобальной стратегии, как принято считать, амбивалентно. Такое понимание
                                                                        ситуации восходит к Эл Райс, при этом перераспределение бюджета изящно синхронизирует комплексный фактор коммуникации, используя опыт
                                                                        предыдущих кампаний. Такое понимание ситуации восходит к Эл Райс, при этом социальный статус спорадически программирует креативный целевой
                                                                        сегмент рынка, полагаясь на инсайдерскую информацию. Личность топ менеджера упорядочивает стратегический медиамикс, осознавая социальную
                                                                        ответственность бизнеса.
                                                                    </p>
                                                                    <p class="privasy__txt">Повышение жизненных стандартов, как следует из вышесказанного, недостижимо. Несмотря на сложности, маркетинговая </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="profile__packet-item-description">поддержка и обновлениевашего w-сайта</span>

                                        <div class="profile__packet-cost">$129<span class="profile__packet-sup">в год</span></div>
                                    </div>
                                    <div class="profile__packet-button-wrap">
                                        <a href="#" class="profile__packet-button">продлить</a>
                                    </div>
                                </div>
                            </li>-->

                        </ul>
                        </div>
                        <!--/packet list -->

                        <h3 class="profile__content-header">Данные для доступа</h3>

                        <!-- data to access -->
                        <ul class="profile__access">

                            <li class="profile__access-item">
                                <div class="profile__access-header">ваш ID</div>
                                <div class="profile__access-value">W<?=$this->view->sitedata['id'];?></div>
                            </li>

                            <li class="profile__access-item">
                                <div class="profile__access-header">ваш сайт</div>
                                <div class="profile__access-value"><?=$this->view->sitedata['domain'];?></div>
                            </li>

                            <li class="profile__access-item">
                                <div class="profile__access-header">логин</div>
                                <div class="profile__access-value"><?=$_SESSION['User']['email'];?></div>
                            </li>

                            <!--<li class="profile__access-item">
                                <div class="profile__access-header">Пароль</div>
                                <div class="profile__access-value">Qg7Sj16s</div>
                            </li>-->

                        </ul>
                        <!--/data to access -->

                        <h3 class="profile__content-header">руководство пользователя</h3>

                        <!-- use instruction -->
                        <ul class="profile__user-instruction">

                            <li class="profile__user-instruction-item">
                                <a href="#" class="profile__user-instruction-item-wrap">
                                    <img src="/img/main/pic/profile-service-img1.png" alt="" width="250" height="160" />
                                </a>
                                PDF версия руководства
                            </li>

                            <li class="profile__user-instruction-item">
                                <a href="#" class="profile__user-instruction-item-wrap">
                                    <img src="/img/main/pic/profile-service-img2.png" alt="" width="250" height="160" />
                                </a>
                                #23984923
                            </li>

                            <li class="profile__user-instruction-item">
                                <a href="#" class="profile__user-instruction-item-wrap">
                                    <img src="/img/main/pic/profile-service-img2.png" alt="" width="250" height="160" />
                                </a>
                                #23984923
                            </li>

                            <li class="profile__user-instruction-item">
                                <a href="#" class="profile__user-instruction-item-wrap">
                                    <img src="/img/main/pic/profile-service-img2.png" alt="" width="250" height="160" />
                                </a>
                                #23984923
                            </li>

                            <li class="profile__user-instruction-item">
                                <a href="#" class="profile__user-instruction-item-wrap">
                                    <img src="/img/main/pic/profile-service-img2.png" alt="" width="250" height="160" />
                                </a>
                                #23984923
                            </li>

                            <li class="profile__user-instruction-item">
                                <a href="#" class="profile__user-instruction-item-wrap">
                                    <img src="/img/main/pic/profile-service-img2.png" alt="" width="250" height="160" />
                                </a>
                                #23984923
                            </li>

                            <li class="profile__user-instruction-item">
                                <a href="#" class="profile__user-instruction-item-wrap">
                                    <img src="/img/main/pic/profile-service-img2.png" alt="" width="250" height="160" />
                                </a>
                                #23984923
                            </li>

                            <li class="profile__user-instruction-item">
                                <a href="#" class="profile__user-instruction-item-wrap">
                                    <img src="/img/main/pic/profile-service-img2.png" alt="" width="250" height="160" />
                                </a>
                                #23984923
                            </li>

                            <li class="profile__user-instruction-item">
                                <a href="#" class="profile__user-instruction-item-wrap">
                                    <img src="/img/main/pic/profile-service-img2.png" alt="" width="250" height="160" />
                                </a>
                                #23984923
                            </li>

                        </ul>
                        <!--/use instruction -->

                        <h3 class="profile__content-header">история оплат</h3>

                        <!-- history payment -->
                        <ul class="profile__history-payment">

                            <li class="profile__history-payment-item profile__history-payment-item_header">
                                <div class="profile__history-payment-name">Описание</div>
                                <div class="profile__history-payment-price">Сумма</div>
                                <div class="profile__history-payment-date">Дата</div>
                                <!--<div class="profile__history-payment-check">PDF-Чек</div>-->
                            </li>
                            <? foreach($this->view->siteoperations as $operation){?>
                            <li class="profile__history-payment-item">
                                <div class="profile__history-payment-name">оплата за пакет <?=$operation['siteplan'];?></div>
                                <div class="profile__history-payment-price"><?=$operation['value'];?> грн</div>
                                <div class="profile__history-payment-date"><?=$operation['date'];?></div>
                                <!--<a href="#" class="profile__history-payment-check">PDF-Чек</a>-->
                            </li>
                            <?}?>
                            <!--<li class="profile__history-payment-item">
                                <div class="profile__history-payment-name">жажда общения с методом</div>
                                <div class="profile__history-payment-price">28 900 грн</div>
                                <div class="profile__history-payment-date">12.03.2013</div>
                                <a href="#" class="profile__history-payment-check">PDF-Чек</a>
                            </li>

                            <li class="profile__history-payment-item">
                                <div class="profile__history-payment-name">жажда общения с методом</div>
                                <div class="profile__history-payment-price">28 900 грн</div>
                                <div class="profile__history-payment-date">12.03.2013</div>
                                <a href="#" class="profile__history-payment-check">PDF-Чек</a>
                            </li>

                            <li class="profile__history-payment-item">
                                <div class="profile__history-payment-name">жажда общения с методом</div>
                                <div class="profile__history-payment-price">28 900 грн</div>
                                <div class="profile__history-payment-date">12.03.2013</div>
                                <a href="#" class="profile__history-payment-check">PDF-Чек</a>
                            </li>-->


                        </ul>
                        <!--/history payment -->

                    </section>
                    <!--/profile -->