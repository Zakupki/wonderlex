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
                                        <a class="gallery__pic-lnk" href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/"><img class="gallery__pic" src="<?=$product['url'];?>" width="430" height="<?=$product['height'];?>" alt=""></a>
                                        <section class="gallery__data <?=($product['price']>0)?'':'gallery__data_without-price';?>">
                                            <a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/" class="gallery__title"><?=$product['name'];?></a>
                                            <a class="gallery__lnk" href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/"><?=$product['sitename'];?></a>
                                            <? if($product['price']>0){?>
                                            <div class="gallery__price"><?=$product['price'];?> <?=$product['curname'];?></div>
                                            <?}?>
                                            <!--<a href="#" class="gallery__auction"></a>-->
                                            <? if($product['price']>0 && $_SESSION['User']['id']>0){?>
                                            <a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/basket/?id=<?=$product['itemid'];?>" class="gallery__cart"></a>
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

                        <input type="button" class="btn btn__gallery-more" id="btn__gallery-more" data-step="12" data-php="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/catalog/moreworks/" data-mode="more"  value="<?=$this->view->translate['showmore'];?>">
                    </div>
                    <!-- /gallery -->
                    <!-- authors -->
                    <section class="authors">
                        <h1 class="authors__title"><?=$this->view->translate['bestauthors'];?></h1>
                        <div class="authors__gallery">
                            <div class="authors__gallery-btn authors__gallery-btn_prev"></div>
                            <ul class="authors__gallery-layout">
                                <? foreach($this->view->authors as $author){?>
                                <li class="authors__gallery-item">
                                    <a class="authors__gallery-lnk" href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/author/<?=$author['id'];?>/">
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