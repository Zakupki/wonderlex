                    <!-- authors profile -->
                    <div class="authors-profile">

                        <!-- authors header -->
                        <div class="authors-profile__header">

                            <div class="authors-profile__photo">
                                <img src="<?=$this->view->authorinner['author_image'];?>" alt="" width="143" height="143" />
                            </div>

                            <!-- authors info -->
                            <div class="authors-profile__info">
                                <a href="/authors/" class="authors-profile__back-href"><?=$this->view->translate['return'];?></a>
                                <h3 class="authors-profile__name"><?=$this->view->authorinner['name'];?></h3>
                                <ul class="authors-profile__list">
                                    <li id="authors-profile-my-work" class="authors-profile__list-item"><?=$this->view->translate['works'];?><span class="authors-profile__list-item-count">(<?=$this->view->productscount;?>)</span></li>
                                    <li id="authors-profile-reviews" class="authors-profile__list-item"><?=$this->view->translate['replies'];?><span class="authors-profile__list-item-count">(0)</span></li>
                                </ul>
                            </div>
                            <!--/authors info -->

                        </div>
                        <!--/authors header -->

                        <!-- authors description -->
                        <div class="authors-profile__description">

                                <h3 class="authors-profile__about-header">Живопись, дизайн интерьеров, фотография</h3>

                                <!-- authors profile social network reference  -->
                                <ul  class="authors-profile__reference-social-network">
                                    <span class="authors-profile__reference-social-network-item st_vkontakte_hcount" displayText="Like"></span>
                                    <span class="authors-profile__reference-social-network-item st_fblike_hcount" displayText="Like"></span>
                                    <span class="authors-profile__reference-social-network-item st_twitter_hcount" displayText="Tweet"></span>
                                    <span class="authors-profile__reference-social-network-item st_pinterest_hcount" displayText="Pin it"></span>
                                </ul>
                                <!--<ul  class="authors-profile__reference-social-network">
                                    <li class="authors-profile__reference-social-network-item">
                                        <img src="/img/main/pic/authors-profile-socila-network.png" alt="" width="75" height="21" />
                                    </li>
                                    <li class="authors-profile__reference-social-network-item">
                                        <img src="/img/main/pic/authors-profile-socila-network-twitter.png" alt="" width="96" height="21" />
                                    </li>
                                </ul>-->
                                <!--/authors profile social network reference  -->

                        </div>
                        <!--/authors description -->

                        <!-- authors profile reference -->
                        <div class="authors-profile__reference">
                            <!-- authors profile about text -->
                            <div class="authors-profile__about">
                                <!-- about authors -->
                                <div class="authors-profile__about-text">

                                    <p class="authors-profile__about-paragraph">
                                        <?=$this->view->authorinner['author_description'];?>
                                    </p>

                                    

                                </div>
                                <!--/about authors -->
                            </div>

                            <!-- authors profile reference columns -->
                            <div class="authors-profile__reference-columns">
                                <ul class="authors-profile__reference-info">
                                    <li class="authors-profile__reference-info-item authors-profile__reference-info-item_country"><?=($this->view->authorinner['city'])?$this->view->authorinner['city'].', ':'';?><?=$this->view->authorinner['country'];?></li>
                                    <li class="authors-profile__reference-info-item authors-profile__reference-info-item_sale">0 <?=$this->view->translate['sells'];?></li>
                                    <li class="authors-profile__reference-info-item authors-profile__reference-info-item_like"><?=$this->view->authorinner['rate'];?> <?=$this->view->translate['likes'];?></li>
                                </ul>

                                <ul class="authors-profile__reference-site">
                                    <li class="authors-profile__reference-site-item authors-profile__reference-site-item_red"><a class="authors-profile__reference-site-item-href" target="_blank" href="http://<?=$this->view->authorinner['domain'];?>"><?=$this->view->translate['authorssite'];?></a></li>
                                    <? if($this->view->authorinner['facebook']){?>
                                    <li class="authors-profile__reference-site-item authors-profile__reference-site-item_facebook"><a class="authors-profile__reference-site-item-href" target="_blank" href="http://<?=str_replace('http://', '',str_replace('https://', '',$this->view->authorinner['facebook']));?>">FACEBOOK</a></li>
                                    <?} if($this->view->authorinner['twitter']){?>
                                    <li class="authors-profile__reference-site-item authors-profile__reference-site-item_twitter"><a class="authors-profile__reference-site-item-href" target="_blank" href="http://<?=str_replace('http://', '',str_replace('https://', '',$this->view->authorinner['twitter']));?>">TWITTER</a></li>
                                    <!--<li class="authors-profile__reference-site-item authors-profile__reference-site-item_instram"><a class="authors-profile__reference-site-item-href" href="#">INSTAGRAM</a></li>-->
                                     <?} if($this->view->authorinner['vkontakte']){?>
                                    <li class="authors-profile__reference-site-item authors-profile__reference-site-item_vk"><a class="authors-profile__reference-site-item-href" target="_blank" href="http://<?=str_replace('http://', '',str_replace('https://', '',$this->view->authorinner['vkontakte']));?>">VK</a></li>
                                	<?}?>
                                </ul>
                            </div>
                            <!--/authors profile reference columns -->

                        </div>
                        <!--/authors profile reference -->


                    </div>
                    <!-- authors profile -->

                    <!-- gallery -->
                    <div class="gallery">
                        <div class="gallery__layout">
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
                                            <? if($product['price']>0 && $_SESSION['User']['id']>0){?>
                                            <!--<a href="#" class="gallery__auction"></a>-->
                                            <a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/basket/?id=<?=$product['itemid'];?>" class="gallery__cart"></a>
                                            <?}?>
                                        </section>
                                    </div>
                                </li>
                               <?
								$cnt++;
								}?>
                            </ul>
                        </div>
                        <input type="button" class="btn btn__gallery-more" id="btn__gallery-more" data-step="12" data-php="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/catalog/moreworks/" data-mode="more" data-value="{'siteid': '<?=$this->view->authorinner["id"];?>'}" value="<?=$this->view->translate['showmore'];?>">
                    </div>
                    <!-- /gallery -->

                    <!-- authors profile comments -->
                        <div id="authors-profile-comments" class="authors-profile-comments" data-php="<?=($this->registry->langurl)?$this->registry->langurl:'';?>php/authors-comments.php" data-value="5">
                            <h3 class="authors-profile-comments__header"><?=$this->view->translate['comments'];?><span class="authors-profile-comments__count"><?=$this->view->product['comments'];?></span></h3>
                             <ul class="authors-profile-comments__list">
                                <li class="authors-profile-comments__item-description"><!--authors-profile-comments__item-opacity-->
                                    
                                </li>
                            <? if(count($this->view->comments)>0){
                            
                            $attitude=array(2=>'positive', 1=>'neutral', 0=>'negative');    
                                
                            ?>
                            

                           
                                <? foreach($this->view->comments as $comment){?>
                                <li class="authors-profile-comments__item-description"><!--authors-profile-comments__item-opacity-->
                                    <a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/author/<?=$comment['siteid'];?>/" class="authors-profile-comments__author-photo authors-profile-comments__author-photo_<?=$attitude[$comment['attitude']];?>"><img src="<?=$comment['author_image'];?>" alt="" width="45" height="45" /></a>
                                    <div class="authors-profile-comments__item-text">
                                        <p class="authors-profile-comments__item-paragraph"><?=$comment['preview_text'];?></p>
                                        <time class="authors-profile-comments__item-date" datetime="<?=$comment['date_create'];?>"><?=$comment['date_create'];?></time>
                                    </div>
                                </li>
                                <?
                                if(!$lastcomment)
                                $lastcomment=$comment['id'];
                                }?>
                            

                            <!--<span class="btn authors-profile-comments_button" id="btn__comments-more" data-php="php/add-pic.php" data-mode="more">Показать еще</span>-->
                            <?}?>
                            </ul>
                            <?
                            if($_SESSION['User']['id']>0){
                            ?>
                            <div class="authors-profile-comments__write">
                                <h3 class="authors-profile-comments__write-header"><?=$this->view->translate['leavecomment'];?></h3>

                                <div id="authors-profile-comments-photo" class="authors-profile-comments__author-photo authors-profile-comments_write authors-profile-comments_photo-write">
                                    <img src="<?=$_SESSION['User']['reccounts'][0]['author_image'];?>" alt="" width="45" height="45" />
                                </div>

                                <form id="authors-profile-comments-form" action="/comments/addsite/" method="post" class="authors-profile-comments__write-field">
                                    <textarea name="description" class="authors-profile-comments__textarea"></textarea>
                                    <input name="siteid" type="hidden" value="<?=$this->view->authorinner['id'];?>"/>
                                    <input name="lastcomment" type="hidden" value="<?=$lastcomment;?>"/>
                                    <div class="authors-profile-comments__write-controls">
                                        <span class="authors-profile-comments__write-label authors-profile-comments__write-positive"></span>
                                        <span class="authors-profile-comments__write-label authors-profile-comments__write-neutral"></span>
                                        <span class="authors-profile-comments__write-label authors-profile-comments__write-negative"></span>
                                        <span class="authors-profile-comments__error-send"><?=$this->view->translate['errormessagel'];?></span>
                                        <input class="authors-profile-comments__submit" type="submit" value="<?=$this->view->translate['send'];?>" />
                                        <input id="authors-profile-comments-attitude-type" type="hidden" name="attitude" value="neutral" />
                                    </div>
                                </form>
                            </div>
                            <?}?>
                        </div>
                        <!--/authors profile comments -->