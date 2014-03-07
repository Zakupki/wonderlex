                    <!-- cart -->
                    <section class="cart">

                        <!-- cart header -->
                        <header class="cart__header cart__header_noborder">
                            <h1 class="cart__header-title">Оплата</h1>
                            <div class="cart__header-txt"><?=$this->view->plan['title'];?> на 1 год – <span class="cart__header-price"><?=$this->view->plan['price'];?> грн</span></div>
                        </header>
                        <!--/cart header -->

                        <!-- cart form -->
                        <form class="cart-pushcase__form" method="post" action="<?=$this->view->liqurl;?>">
							<input type='hidden' name='operation_xml' value='<?=$this->view->xml_encoded;?>' />
  	  						<input type='hidden' name='signature' value='<?=$this->view->lqsignature;?>' />
                            <!-- submit button -->
                            <div class="cart-pushcase__submit-wrap">
                                <button class="cart-pushcase__button-submit" type="submit" formnovalidate>
                                    <span class="cart-pushcase__button-submit-text">Оплатить<span class="cart-pushcase__button-submit-sum"> – <?=$this->view->plan['price'];?> грн</span></span>
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