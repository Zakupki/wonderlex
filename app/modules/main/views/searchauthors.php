                    <div class="search-result">
                        <h1 class="search-result__title">Поиск «<?=$_GET['q'];?>»</h1>
                    </div>
                    <!-- authors list -->
                    <div class="authors-list">

                       <!-- list content -->
                        <div id="authors-list" class="authors-list__wrap authors-lis_no-button" data-php="/authors/moreauthors/" data-step="12" data-value="{'typeOfWork': 'type1', 'directions': 'date', 'count': 12}">

                            <ul class="authors-list__content">
                                <? foreach($this->view->authors as $author){?>
                                <li class="authors-list__content-item">
                                    <a class="authors-list__content-href" href="/author/<?=$author['id'];?>/">
                                        <div class="authors-list__content-item-href"><img src="<?=$author['author_image'];?>" alt="" width="187" height="187" /></div>
                                        <? if($author['new']){?>
                                        <div class="authors-list__new">Новый!</div>
                                        <?}?>
                                        <span class="authors-list__author-name"><?=$author['name'];?></span>
                                    </a>
                                    <p class="authors-list__author-description"><?=mb_substr(strip_tags($author['author_description']),0,150,'UTF-8');?>...</p>
                                </li>
                                <?}?>
                            </ul>

                            <div id="authors-list-see-more" class="authors-list__see-more authors-list_see-more-hidden">Показать еще</div>

                        </div>
                        <!--/list content -->

                    </div>
                    <!--/authors list -->