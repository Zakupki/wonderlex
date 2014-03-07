                    <!-- catalog -->
                    <section class="catalog">

                        <!-- catalog__header -->
                        <header class="catalog__header">
                            <h1 class="catalog__header-title"><?=$this->view->translate['catalog'];?></h1>
                            <div class="authors-list__sort-popup">

                                <span id="authors-list-sort-label" class="authors-list__sort-header"><?=$this->view->translate['sort'];?></span>

                                <!-- sort parameters list -->
                                <ul id="authors-list-sort-parameters" class="authors-list__sort-parameters" style="display: none;">
                                    <li class="authors-list__sort-parameters-item authors-list__sort-parameters-item_date"><a href="#" class="authors-list__sort-parameters-item-href"><?=$this->view->translate['bydate'];?></a></li>
                                    <li class="authors-list__sort-parameters-item authors-list__sort-parameters-item_rating"><a href="#" class="authors-list__sort-parameters-item-href"><?=$this->view->translate['byrate'];?></a></li>
                                    <li class="authors-list__sort-parameters-item authors-list__sort-parameters-item_popularity"><a href="#" class="authors-list__sort-parameters-item-href"><?=$this->view->translate['bypopular'];?></a></li>
                                </ul>
                                <!--/sort parameters list -->
                            </div>

                            <!-- filter -->
                            <div class="filter" data-php="/catalog/getartfilter/">
                                <div class="filter__item filter__item_view filter__item_menu"><?=$this->view->translate['kind'];?></div>

                                <!-- filter__menu -->
                                <ul class="filter__menu filter__menu_view">
                                    <? foreach( $this->view->arttypes as $arttype){?>
                                    <li class="filter__menu-item"><a class="filter__menu-lnk" href="#" data-id="<?=$arttype['id'];?>"><?=$arttype['name'];?></a></li>
                                    <?}?>
                                </ul>
                                <!-- /filter__menu -->

                                <div class="filter__item filter__item_price filter__item_slider" data-start="0" data-finish="80000" data-currency=""><?=$this->view->translate['price'];?></div>
                                <div class="filter__item filter__item_year filter__item_slider" data-start="1900" data-finish="<?=date('Y');?>"><?=$this->view->translate['year'];?></div>
                                <!--<div class="filter__item filter__item_clear">сбросить фильтры</div>-->

                            </div>
                            <!-- /filter -->

                        </header>
                        <!-- /catalog__header -->

                    </section>
                    <!-- /catalog -->

                   <!-- gallery -->
                    <div class="gallery" data-php="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/catalog/moreworks/" data-type="<?=$this->view->catalogType;?>" >

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
                                        <section class="gallery__data">
                                            <a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/" class="gallery__title"><?=$product['name'];?></a>
                                            <a class="gallery__lnk" href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/"><?=$product['sitename'];?></a>
                                            <? if($product['price']>0){?>
                                            <div class="gallery__price"><?=$product['price'];?> <?=$product['curname'];?></div>
                                            <?}?>
                                            <!--<a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>#" class="gallery__auction"></a>-->
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
                </div>
                <!-- /content-wrap -->          
					
					
					
					
					