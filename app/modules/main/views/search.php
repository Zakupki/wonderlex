                    <div class="search-result">
                        <h1 class="search-result__title">Поиск «<?=$_GET['q'];?>»</h1>
                    </div>
                    <!-- gallery -->
                    <div class="gallery">

                        <!-- gallery__layout -->
                        <div class="gallery__layout">

                            <!-- gallery__column -->
                            <ul class="gallery__column">
                            	<?
                            	$cnt=1;
                            	foreach($this->view->products['products'] as $product){?>
                            	<li class="gallery__item" data-id="<?=$cnt;?>"><!--gallery__item_best-->
                                    <div class="gallery__wrap-element">
                                        <a class="gallery__pic-lnk" href="/product/<?=$product['itemid'];?>/"><img class="gallery__pic" src="<?=$product['url'];?>" width="430" height="<?=$product['height'];?>" alt=""></a>
                                        <section class="gallery__data">
                                            <a href="/product/<?=$product['itemid'];?>/" class="gallery__title"><?=$product['name'];?></a>
                                            <a class="gallery__lnk" href="/product/<?=$product['itemid'];?>/"><?=$product['sitename'];?></a>
                                            <? if($product['price']>0){?>
                                            <div class="gallery__price"><?=$product['price'];?> <?=$product['curname'];?></div>
                                            <?}?>
                                            <!--<a href="#" class="gallery__auction"></a>-->
                                            <? if($product['price']>0 && $_SESSION['User']['id']>0){?>
                                            <a href="/basket/?id=<?=$product['itemid'];?>" class="gallery__cart"></a>
                                            <?}?>
                                        </section>
                                    </div>
                                </li>
                               <?
								$cnt++;
								}?>
                            </ul>
                            <!-- /gallery__column -->

                        </div>
                        <!-- /gallery__layout -->
                        <? if(count($this->view->products['products'])>11){?>
                        <input type="button" class="btn btn__gallery-more" id="btn__gallery-more" data-step="12" data-php="/catalog/moreworks/" data-mode="more"  value="Показать еще">
                        <?}?>
                    </div>
                    <!-- /gallery -->
                    <!-- authors -->
                    <section class="authors">
                        <h1 class="authors__title">Лучшие авторы</h1>
                        <div class="authors__gallery">
                            <div class="authors__gallery-btn authors__gallery-btn_prev"></div>
                            <ul class="authors__gallery-layout">
                                <? foreach($this->view->authors as $author){?>
                                <li class="authors__gallery-item">
                                    <a class="authors__gallery-lnk" href="/author/<?=$author['id'];?>/">
                                        <img class="authors__gallery-pic" src="<?=$author['author_image'];?>" width="150" height="150" alt="">
                                        <span class="authors__gallery-name"><?=$author['name'];?></span>
                                        <p class="authors__gallery-txt"><?=mb_substr(strip_tags($author['author_description']),0,150,'UTF-8');?>...</p>
                                    </a>
                                </li>
                                <?}?>
                            </ul>
                            <div class="authors__gallery-btn authors__gallery-btn_next"></div>
                        </div>
                    </section>
                    <!-- /authors -->