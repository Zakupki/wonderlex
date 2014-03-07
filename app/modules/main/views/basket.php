                    <!-- cart -->
                    <section class="cart">
                        <header class="cart__header">
                            <h1 class="cart__header-title"><?=$this->view->translate['cart'];?></h1>
                            <? if($this->view->inbasket>0){?>
                            <div class="cart__header-txt"><span class="cart__header-count"><?=$this->view->inbasket;?></span> <?=$this->view->translate['products'];?> – <span class="cart__header-price"><?=$this->view->basketsum;?></span></div>
                        	<?}?>
                        </header>

                        <!-- cart-galler -->
                        <ul class="cart-gallery" data-php="/basket/remove/">
                            <? 
                            if(count($this->view->basketproducts)>0){
                            foreach($this->view->basketproducts as $product){?>
                            <li class="cart-gallery__layout" data-id="<?=$product['itemid'];?>">
                                <div class="cart-gallery__info">
                                    <?=$product['price'];?> <?=$product['curname'];?>
                                    <a href="/basket/purchase/?id=<?=$product['itemid'];?>" class="cart-gallery__pay"><?=$this->view->translate['purchase'];?></a>
                                </div>
                                <div class="cart-gallery__item">
                                    <div class="cart-gallery__wrap-element">
                                        <a class="cart-gallery__pic-lnk" href="/product/<?=$product['itemid'];?>/">
                                            <img class="cart-gallery__pic" src="<?=$product['url'];?>" width="430" height="398" alt="">
                                        </a>
                                        <section class="cart-gallery__data">
                                            <a href="/product/<?=$product['itemid'];?>/" class="cart-gallery__title"><?=$product['name'];?></a>
                                            <a class="cart-gallery__lnk" href="/product/<?=$product['itemid'];?>/"><?=$product['sitename'];?></a>
                                             <? if($product['price']>0){?>
                                            <div class="cart-gallery__price"><?=$product['price'];?> <?=$product['curname'];?></div>
                                            <?}?>
                                            <div class="cart-gallery__del"></div>
                                        </section>
                                    </div>
                                </div>
                            </li>
                            <?
							}
                            }else{
							?>
							<li class="cart-gallery__layout" style="color:black; width:85%; text-align:center;">Oй, тут пока пусто.<br/></li>
							<?}?>
                        </ul>
                        <!-- /cart-galler -->

                    </section>
                    <!-- /cart -->