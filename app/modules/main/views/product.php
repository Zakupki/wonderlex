		            <!-- item -->
                    <div class="item">

                        <!-- item view wrap -->
                        <div class="item__view-wrap">

                            <!-- item view -->
                            <div id="item-view" class="item__view">
                            <?  
                            	foreach($this->view->product['images'] as $image){
                            	$activePic=null;
								if($image['major']==1){
									$activePic='  item__view-preview-item_active';
									$mainbig=$image['origimg'];
								}
                            	$imageHTML.='<li class="item__view-preview-item'.$activePic.'">
                                            	<img src="'.$image['url'].'" width="110" height="90" alt="" data-src="'.$image['origimg'].'" />
                                        	</li>';
								
								
                            }?>
                                <div id="item-view-photo" class="item__view-photo">
                                    <img src="<?=$mainbig;?>" width="890" height="598" alt="" />
                                    <? if(count($this->view->product['images'])>1){?>
                                    <div class="item__view-photo-right"></div>
                                    <div class="item__view-photo-left"></div>
                                    <?}?>
                                </div>

                                <? if(count($this->view->product['images'])>1){?>
                                <div class="item__view-preview">

                                    <ul class="item__view-preview-list">
                                        <?=$imageHTML;?>
                                    </ul>
                                </div>
                                <?}?>

                            </div>
                            <!--/item view -->

                            <!-- item view description -->
                            <div class="item__view-description">
                                <a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/catalog/" class="item__view-description-back"><?=$this->view->translate['return'];?></a>
                                <h2 class="item__view-header"><?=$this->view->product['product']['name'];?><span class="item__view-header-year"><?=$this->view->product['product']['date_create'];?></span></h2>

                                <div class="item__view-tags">
                                    <a class="item__view-tags-item"><?=$this->view->product['product']['categoryname'];?></a>
                                    <!--<a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>#" class="item__view-tags-item">Скульптура,</a>
                                    <a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>#" class="item__view-tags-item">Живопись</a>-->
                                </div>

                                <div class="item__view-materials">
                                	<span class="item__view-materials-item"><?=strip_tags($this->view->product['product']['techinfo']);?></span>
                                    <!--<span class="item__view-materials-item">Картон, акрил</span>
                                    <span class="item__view-materials-item">60 Х 80 см</span>
                                    <span class="item__view-materials-item">2012</span>-->
                                </div>

                                <p class="item__view-description-text">
                                <?=strip_tags($this->view->product['product']['detail_text']);?>
                                </p>

                                <!-- item view -->
                                <div class="item__view-price-wrap">
                                    <? if($this->view->product['product']['price']>0){?>
                                    <span class="item__view-price"><?=$this->view->product['product']['price'];?> <?=$this->view->product['product']['curname'];?></span>
                                    <?}?>
                                    <div class="item__view-price-buttons">
                                        <button class="btn item__view-price_like<?=($_SESSION['User']['id'])?'':' btn_without-auth';?><?=($this->view->product['product']['rate']==1)?' disabled':'';?>" data-php="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/catalog/like/" data-id="<?=$this->view->product['product']['itemid'];?>"><?=tools::int($this->view->product['likes']);?></button>
                                        <?
                                         if($this->view->product['product']['price']>0 && 1==2){?>
                                        <a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/basket/?id=<?=$this->view->product['product']['itemid'];?>" class="btn item__view-price_order<?=($_SESSION['User']['id'])?'':' btn_without-auth';?>"><?=$this->view->translate['order'];?></a>
                                        <?}?>
                                    </div>
                                </div>
                                <!--/item view -->

                                <!-- author reference -->
                                <div class="item__view-author">

                                    <a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/author/<?=$this->view->product['product']['siteid'];?>/" class="item__view-author-wrap">
                                        <img src="<?=$this->view->product['product']['author_image'];?>" width="45" height="45" alt="" />
                                    </a>

                                    <div class="item__view-author-href">
                                        <a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/author/<?=$this->view->product['product']['siteid'];?>/" class="item__view-author-name"><?=$this->view->product['product']['sitename'];?></a>
                                        <a target="_blank" href="http://<?=$this->view->product['product']['domain'];?>" class="item__view-author-site"><?=$this->view->translate['authorssite'];?></a>
                                    </div>

                                </div>
                                <!--/author reference -->

                                <!-- social likes -->
                                <div class="item__view-social-network-like">
                                    <ul class="item__view-social-network-list">
                                        <span class="item__view-social-network-list-item st_vkontakte_hcount" displayText="Like"></span>
                                        <span class="item__view-social-network-list-item st_fblike_hcount" displayText="Like"></span>
                                        <span class="item__view-social-network-list-item st_twitter_hcount" displayText="Tweet"></span>
                                        <span class="item__view-social-network-list-item st_pinterest_hcount" displayText="Pin it"></span>
                                        <!--li class="item__view-social-network-list-item"><img src="pic/authors-profile-socila-network.png" width="75" height="21" alt="" /> </li>
                                        <li class="item__view-social-network-list-item"><img src="pic/authors-profile-socila-network-twitter.png" width="96" height="21" alt="" /> </li>
                                        <li class="item__view-social-network-list-item"><img src="pic/punit.png" width="40" height="21" alt="" /></li-->
                                    </ul>
                                </div>
                                <!--/social likes -->
                                
                                    <!--<ul class="item__view-social-network-list">
                                        <li class="item__view-social-network-list-item"><img src="/img/main/pic/authors-profile-socila-network.png" width="75" height="21" alt="" /> </li>
                                        <li class="item__view-social-network-list-item"><img src="/img/main/pic/authors-profile-socila-network-twitter.png" width="96" height="21" alt="" /> </li>
                                        <li class="item__view-social-network-list-item"><img src="/img/main/pic/punit.png" width="40" height="21" alt="" /></li>
                                    </ul>-->
                              

                            </div>
                            <!--/item view description -->

                        </div>
                        <!--/item view wrap -->

                        <!-- gallery -->
                        <div class="gallery">
                            <h3 class="gallery__header"><?=$this->view->translate['similarworks'];?></h3>
                            <div class="gallery__layout">
                                <ul class="gallery__column">

                                    <!--<li class="gallery__item gallery__item_best" data-id="1">
                                        <div class="gallery__wrap-element">
                                            <a class="gallery__pic-lnk" href="#"><img class="gallery__pic_min" src="/img/main/pic/item-img1.jpg" width="200" height="170" alt=""></a>
                                            <section class="gallery__data">
                                                <a href="#" class="gallery__title">maya presentation</a>
                                                <a class="gallery__lnk" href="#">наташа егорова</a>
                                                <div class="gallery__price">459 грн</div>
                                                <a href="#" class="gallery__auction"></a>
                                                <a href="#" class="gallery__cart"></a>
                                            </section>
                                        </div>
                                    </li>
                                    <li class="gallery__item gallery__item_new" data-id="2">
                                        <div class="gallery__wrap-element">
                                            <a class="gallery__pic-lnk" href="#"><img class="gallery__pic_min" src="/img/main/pic/item-img11.jpg" width="200" height="150" alt=""></a>
                                            <section class="gallery__data">
                                                <a href="#" class="gallery__title">maya presentation</a>
                                                <a class="gallery__lnk" href="#">наташа егорова</a>
                                                <div class="gallery__price">459 грн</div>
                                                <a href="#" class="gallery__auction"></a>
                                                <a href="#" class="gallery__cart"></a>
                                            </section>
                                        </div>
                                    </li>-->
                                   
                                    <? 
                                    $cnt=1;
                                    foreach($this->view->otherproducts as $product){?> 
                                    <!-- gallery item -->
                                    <li class="gallery__item" data-id="<?=$cnt;?>">
                                        <div class="gallery__wrap-element">
                                            <a class="gallery__pic-lnk" href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/"><img class="gallery__pic_min" src="<?=$product['url'];?>" width="<?=$product['width'];?>" height="<?=$product['height'];?>" alt=""></a>
                                            <section class="gallery__data">
                                                <a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/" class="gallery__title"><?=$product['name'];?></a>
                                                <a class="gallery__lnk" href="http://<?=$product['domain'];?>"><?=$product['sitename'];?></a>
                                                <? if($product['price']>0){?>
                                                <div class="gallery__price"><?=$product['price'];?> <?=$product['curname'];?></div>
                                                <?}?>
                                                <a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>#" class="gallery__auction"></a>
                                                <a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>#" class="gallery__cart"></a>
                                            </section>
                                        </div>
                                    </li>
                                    <!--/gallery item -->
                                    <?
									$cnt++;
									}?>

                                   

                                </ul>
                            </div>
                            <input type="button" class="btn btn__gallery-more2" id="btn__gallery-more" data-step="12" data-php="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/catalog/moreothers/?categoryid=<?=$this->view->product['product']['categoryid'];?>&itemid=<?=$this->view->product['product']['itemid'];?>" data-mode="more"  value="<?=$this->view->translate['showmore'];?>">
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

                                <form id="authors-profile-comments-form" action="/comments/add/" class="authors-profile-comments__write-field">
                                    <textarea name="description" class="authors-profile-comments__textarea"></textarea>
                                    <input name="itemid" type="hidden" value="<?=$this->view->product['product']['itemid'];?>"/>
                                    <input name="siteid" type="hidden" value="<?=$this->view->product['product']['siteid'];?>"/>
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


                    </div>
                    <!--/item -->