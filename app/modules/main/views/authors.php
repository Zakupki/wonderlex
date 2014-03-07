                    <!-- authors list -->
                    <div class="authors-list">

                        <!-- list header -->
                        <div class="authors-list__header" data-php="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/catalog/getartfilter/">

                            <h3 class="authors-list__header-text"><?=$this->view->translate['authors'];?></h3>

                            <div id="authors-list-label" class="authors-list__label authors-list__label_view"><?=$this->view->translate['workkind'];?></div>

                            <!-- authors jobs list -->
                            <div id="authors-list-jobs" class="authors-list__jobs">
                                <ul class="authors-list__jobs-list authors-list__jobs-list_view">
                                    <? foreach( $this->view->arttypes as $arttype){?>
                                    <li class="authors-list__jobs-list-item"><a data-id="<?=$arttype['id'];?>" class="authors-list__jobs-list-item-href authors-list__jobs-list-item-href_view" href="#" ><?=$arttype['name'];?></a></li>
                                    <?}?>
                                </ul>
                            </div>
                            <!--/authors jobs list -->

                            <!-- popup window for sort -->
                            <div class="authors-list__sort-popup">

                                <span id="authors-list-sort-label" class="authors-list__sort-header"><?=$this->view->translate['sort'];?></span>

                                <!-- sort parameters list -->
                                <ul id="authors-list-sort-parameters" class="authors-list__sort-parameters">
                                    <li class="authors-list__sort-parameters-item authors-list__sort-parameters-item_date"><a href="#" class="authors-list__sort-parameters-item-href"><?=$this->view->translate['bydate'];?></a></li>
                                    <li class="authors-list__sort-parameters-item authors-list__sort-parameters-item_rating"><a href="#" class="authors-list__sort-parameters-item-href"><?=$this->view->translate['byrate'];?></a></li>
                                    <li class="authors-list__sort-parameters-item authors-list__sort-parameters-item_popularity"><a href="#" class="authors-list__sort-parameters-item-href"><?=$this->view->translate['bypopular'];?></a></li>
                                </ul>
                                <!--/sort parameters list -->

                            </div>
                            <!--/popup window for sort -->
                        </div>
                        <!--/list header -->
                        <!--/list header -->

                        <!-- list content -->
                        <div id="authors-list" class="authors-list__wrap authors-lis_no-button" data-php="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/authors/moreauthors/" data-step="12" data-value="{'typeOfWork': 'type1', 'directions': 'date', 'count': 12}">

                            <ul class="authors-list__content">
                                <? foreach($this->view->authors as $author){?>
                                <li class="authors-list__content-item">
                                    <a class="authors-list__content-href" href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/author/<?=$author['id'];?>/">
                                        <div class="authors-list__content-item-href"><img src="<?=$author['author_image'];?>" alt="" width="187" height="187" /></div>
                                        <? if($author['new']){?>
                                        <div class="authors-list__new"><?=$this->view->translate['new'];?>!</div>
                                        <?}?>
                                        <span class="authors-list__author-name"><?=$author['name'];?></span>
                                    </a>
                                    <p class="authors-list__author-description"><?=mb_substr(strip_tags($author['author_description']),0,150,'UTF-8');?>...</p>
                                </li>
                                <?}?>
                            </ul>

                            <div id="authors-list-see-more" class="authors-list__see-more authors-list_see-more-hidden"><?=$this->view->translate['showmore'];?></div>

                        </div>
                        <!--/list content -->

                    </div>
                    <!--/authors list -->