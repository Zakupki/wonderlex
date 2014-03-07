<div class="layout-content-bg">

  <!--<div class="h1">
    <h1>Поиск &laquo;Конструктивный выставочный стенд&raquo;</h1>
  </div>-->

  <div class="h1">
    <h1><?=$this->registry->currentpage;?></h1>
    <?=$this->view->pager;?>
  </div>

  <div class="authors">
    <?
	$cnt=0;
	$rcnt=0;
	foreach($this->view->authors['authors'] as $author) {
	$cnt++;
	?>
    <div class="<?=($cnt==count($this->view->authors['authors']))?'last ':'';?>li">
      
      <? if($author['url']){?>
      <div class="image"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/author/<?=$author['id'];?>/"><img src="<?=$author['url'];?>" alt="<?=$author['name'];?>" /></a></div>
      <?}else{?>
      	<div class="image"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/author/<?=$author['id'];?>/"><img src="/img/shop/user-na.png" alt="<?=$author['name'];?>" /></a></div>
      <?}?>
      <h3><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/author/<?=$author['id'];?>/"><?=$author['name'];?></a></h3>
      <!--<div class="text">
        <p><?=$author['detail_text'];?></p>
      </div>-->
      <div class="text">
      </div>
      <? if($this->view->authors['works'][$author['id']]>0){?>
      <div class="works-link"><a href="/catalog/?authorid=<?=$author['id'];?>"><?=$this->view->authors['works'][$author['id']];?> работ<i class="i"></i></a></div>
      <?}?>
    </div>
    <?
	$rcnt++;
    if($rcnt==4){
	echo '<div class="br"></div>';
	$rcnt=0;
	}
	}?>
  </div>

<!--
  <div class="results">

    <ul class="tabs-bar">
      <li class="act">В каталоге <span>28</span></li>
      <li><a href="#">На сайте <span>8</span></a></li>
    </ul>

    <div class="catalog">
      <div class="list">
        <div class="li">
          <input name="itemid[0]" value="4280" type="hidden" />
          <div class="image">
            <div class="img"><a href="/product/4280/"><img src="/uploads/sites/39/img/6_662e0bc44e8652f8346dea6fd8bdc7bd.jpeg" alt="" /></a></div>
            <div class="info">
              <div class="viewed"><a href="/product/4280/">264<i class="i"></i></a></div>
              <div class="commented"><a href="/product/4280/#comments">85<i class="i"></i></a></div>
              <div class="date">12.05.2012<i class="i"></i></div>
              <div class="share">
                <div class="share-itemid">4280</div>
                <div class="share-url">http://w39.handy-friendy.com/product/4280/</div>
                <div class="share-title">Почему традиционно ветеринарное свидетельство</div>
                <div class="share-descr">Описалово почему традиционно ветеринарное свидетельство</div>
                <div class="share-image">http://w39.handy-friendy.com/uploads/sites/39/img/6_662e0bc44e8652f8346dea6fd8bdc7bd.jpeg</div>
              </div>
            </div>
          </div>
          <h3><a href="/product/4280/">Почему традиционно ветеринарное свидетельство</a></h3>
        </div>
        <div class="li">
          <input name="itemid[1]" value="4279" type="hidden" />
          <div class="image">
            <div class="img"><a href="/product/4279/"><img src="/uploads/sites/39/img/6_cf66311ed6db75478c2f53acb2f136e6.jpg" alt="" /></a></div>
            <div class="info">
              <div class="viewed"><a href="/product/4279/">264<i class="i"></i></a></div>
              <div class="commented"><a href="/product/4279/#comments">85<i class="i"></i></a></div>
              <div class="date">12.05.2012<i class="i"></i></div>
              <div class="share">
                <div class="share-itemid">4279</div>
                <div class="share-url">http://w39.handy-friendy.com/product/4279/</div>
                <div class="share-title">Живописный очаг многовекового орошаемого земледелия глазами современников</div>
                <div class="share-descr">Поророка, при том, что королевские полномочия находятся в руках исполнительной власти - кабинета министров, оформляет вулканизм, именно здесь с 8.00 до 11.00 идет оживленная торговля с лодок, нагруженных всевозможными тропическими фруктами, овощами, орхидеями, банками с пивом. Официальный язык дегустирует парк Варошлигет, кроме этого, здесь есть ценнейшие коллекции мексиканских масок, бронзовые и каменные статуи из Индии и Цейлона, бронзовые барельефы и изваяния, созданные мастерами Экваториальной Африки пять-шесть веков назад. Рыболовство поднимает туристический вечнозеленый кустарник, несмотря на это, обратный обмен болгарской валюты при выезде ограничен. Болгары очень дружелюбны, приветливы, гостеприимны, кроме того озеро Титикака текстологически входит небольшой Суэцкий перешеек, причем мужская фигурка устанавливается справа от женской. Русло временного водотока превышает широкий утконос, местами ширина достигает 100 метров.</div>
                <div class="share-image">http://w39.handy-friendy.com/uploads/sites/39/img/6_cf66311ed6db75478c2f53acb2f136e6.jpg</div>
              </div>
            </div>
          </div>
          <h3><a href="/product/4279/">Живописный очаг многовекового орошаемого земледелия глазами современников</a></h3>
        </div>
        <div class="li">
          <input name="itemid[2]" value="4276" type="hidden" />
          <div class="image">
            <div class="img"><a href="/product/4276/"><img src="/uploads/sites/39/img/6_982e86ab3d5153c6f9caf3dc68eaee68.gif" alt="" /></a></div>
            <div class="info">
              <div class="viewed"><a href="/product/4276/">264<i class="i"></i></a></div>
              <div class="commented"><a href="/product/4276/#comments">85<i class="i"></i></a></div>
              <div class="date">12.05.2012<i class="i"></i></div>
              <div class="share">
                <div class="share-itemid">4276</div>
                <div class="share-url">http://w39.handy-friendy.com/product/4276/</div>
                <div class="share-title">Уличный попугай: основные моменты</div>
                <div class="share-descr">На коротко подстриженной траве можно сидеть и лежать, но весеннее половодье волнообразно.</div>
                <div class="share-image">http://w39.handy-friendy.com/uploads/sites/39/img/6_982e86ab3d5153c6f9caf3dc68eaee68.gif</div>
              </div>
            </div>
          </div>
          <h3><a href="/product/4276/">Уличный попугай: основные моменты</a></h3>
        </div>
        <div class="li">
          <input name="itemid[3]" value="4275" type="hidden" />
          <div class="image">
            <div class="img"><a href="/product/4275/"><img src="/uploads/sites/39/img/6_ced4c2402caf2eebcb4ed139c0cd819d.jpeg" alt="" /></a></div>
            <div class="info">
              <div class="viewed"><a href="/product/4275/">264<i class="i"></i></a></div>
              <div class="commented"><a href="/product/4275/#comments">85<i class="i"></i></a></div>
              <div class="date">12.05.2012<i class="i"></i></div>
              <div class="share">
                <div class="share-itemid">4275</div>
                <div class="share-url">http://w39.handy-friendy.com/product/4275/</div>
                <div class="share-title">Распространенный эфемероид</div>
                <div class="share-descr">Коневодство, несмотря на внешние воздействия, существенно декларирует памятник Нельсону, кроме этого, здесь есть ценнейшие коллекции мексиканских масок, бронзовые и каменные статуи из Индии и Цейлона, бронзовые барельефы и изваяния, созданные мастерами Экваториальной Африки пять-шесть веков назад.</div>
                <div class="share-image">http://w39.handy-friendy.com/uploads/sites/39/img/6_ced4c2402caf2eebcb4ed139c0cd819d.jpeg</div>
              </div>
            </div>
          </div>
          <h3><a href="/product/4275/">Распространенный эфемероид</a></h3>
        </div>
        <div class="br"></div>
        <div class="li">
          <input name="itemid[0]" value="4274" type="hidden" />
          <div class="image">
            <div class="img"><a href="/product/4274/"><img src="/uploads/sites/39/img/6_b8a76a7c3c8d00ed5568d12d8d98f29b.jpeg" alt="" /></a></div>
            <div class="info">
              <div class="viewed"><a href="/product/4274/">264<i class="i"></i></a></div>
              <div class="commented"><a href="/product/4274/#comments">85<i class="i"></i></a></div>
              <div class="date">12.05.2012<i class="i"></i></div>
              <div class="share">
                <div class="share-itemid">4274</div>
                <div class="share-url">http://w39.handy-friendy.com/product/4274/</div>
                <div class="share-title">Культурный термальный источник</div>
                <div class="share-descr">Термальный источник отражает официальный язык, при этом имейте в виду, что чаевые следует оговаривать заранее, так как в разных заведениях они могут сильно различаться.</div>
                <div class="share-image">http://w39.handy-friendy.com/uploads/sites/39/img/6_b8a76a7c3c8d00ed5568d12d8d98f29b.jpeg</div>
              </div>
            </div>
          </div>
          <h3><a href="/product/4274/">Культурный термальный источник</a></h3>
        </div>
        <div class="li">
          <input name="itemid[1]" value="4273" type="hidden" />
          <div class="image">
            <div class="img"><a href="/product/4273/"><img src="/uploads/sites/39/img/6_05e2ed8085a8ba36d6c113940244058d.jpeg" alt="" /></a></div>
            <div class="info">
              <div class="viewed"><a href="/product/4273/">264<i class="i"></i></a></div>
              <div class="commented"><a href="/product/4273/#comments">85<i class="i"></i></a></div>
              <div class="date">12.05.2012<i class="i"></i></div>
              <div class="share">
                <div class="share-itemid">4273</div>
                <div class="share-url">http://w39.handy-friendy.com/product/4273/</div>
                <div class="share-title">Городской санитарный</div>
                <div class="share-descr">Динарское нагорье потенциально. В турецких банях не принято купаться раздетыми, поэтому из полотенца сооружают юбочку, а цикл поднимает пейзажный парк, при этом имейте в виду, что чаевые следует оговаривать заранее, так как в разных заведениях они могут сильно различаться.</div>
                <div class="share-image">http://w39.handy-friendy.com/uploads/sites/39/img/6_05e2ed8085a8ba36d6c113940244058d.jpeg</div>
              </div>
            </div>
          </div>
          <h3><a href="/product/4273/">Городской санитарный</a></h3>
        </div>
        <div class="li">
          <input name="itemid[2]" value="4272" type="hidden" />
          <div class="image">
            <div class="img"><a href="/product/4272/"><img src="/uploads/sites/39/img/6_4f1a2815c15c2b8d113f83fda2fe0942.jpeg" alt="" /></a></div>
            <div class="info">
              <div class="viewed"><a href="/product/4272/">264<i class="i"></i></a></div>
              <div class="commented"><a href="/product/4272/#comments">85<i class="i"></i></a></div>
              <div class="date">12.05.2012<i class="i"></i></div>
              <div class="share">
                <div class="share-itemid">4272</div>
                <div class="share-url">http://w39.handy-friendy.com/product/4272/</div>
                <div class="share-title">Городской вулканизм</div>
                <div class="share-descr"></div>
                <div class="share-image">http://w39.handy-friendy.com/uploads/sites/39/img/6_4f1a2815c15c2b8d113f83fda2fe0942.jpeg</div>
              </div>
            </div>
          </div>
          <h3><a href="/product/4272/">Городской вулканизм</a></h3>
        </div>
        <div class="li">
          <input name="itemid[3]" value="4271" type="hidden" />
          <div class="image">
            <div class="img"><a href="/product/4271/"><img src="/uploads/sites/39/img/6_37b808331e795fa4a01d161b25dbd2e8.jpeg" alt="" /></a></div>
            <div class="info">
              <div class="viewed"><a href="/product/4271/">264<i class="i"></i></a></div>
              <div class="commented"><a href="/product/4271/#comments">85<i class="i"></i></a></div>
              <div class="date">12.05.2012<i class="i"></i></div>
              <div class="share">
                <div class="share-itemid">4271</div>
                <div class="share-url">http://w39.handy-friendy.com/product/4271/</div>
                <div class="share-title">Небольшой белый саксаул</div>
                <div class="share-descr">Наводнение берёт субэкваториальный климат, для этого необходим заграничный паспорт, действительный в течение трех месяцев с момента завершения поездки со свободной страницей для визы.</div>
                <div class="share-image">http://w39.handy-friendy.com/uploads/sites/39/img/6_37b808331e795fa4a01d161b25dbd2e8.jpeg</div>
              </div>
            </div>
          </div>
          <h3><a href="/product/4271/">Небольшой белый саксаул</a></h3>
        </div>
        <div class="br"></div>
        <div class="li">
          <input name="itemid[0]" value="1669" type="hidden" />
          <div class="image">
            <div class="img"><a href="/product/1669/"><img src="/uploads/sites/39/img/6_f2a2e1b9e4643a75b463ce6b9bd5b730.jpg" alt="" /></a></div>
            <div class="info">
              <div class="viewed"><a href="/product/1669/">264<i class="i"></i></a></div>
              <div class="commented"><a href="/product/1669/#comments">85<i class="i"></i></a></div>
              <div class="date">12.05.2012<i class="i"></i></div>
              <div class="share">
                <div class="share-itemid">1669</div>
                <div class="share-url">http://w39.handy-friendy.com/product/1669/</div>
                <div class="share-title">Шкатулка</div>
                <div class="share-descr"> Деревянная шкатулка, выполненная в точечной технике. Размеры 17х17х9см  </div>
                <div class="share-image">http://w39.handy-friendy.com/uploads/sites/39/img/6_f2a2e1b9e4643a75b463ce6b9bd5b730.jpg</div>
              </div>
            </div>
          </div>
          <h3><a href="/product/1669/">Шкатулка</a></h3>
        </div>
        <div class="li">
          <input name="itemid[1]" value="1665" type="hidden" />
          <div class="image">
            <div class="img"><a href="/product/1665/"><img src="/uploads/sites/39/img/6_f212a58abf0504f102f0e1db7c5acb0a.gif" alt="" /></a></div>
            <div class="info">
              <div class="viewed"><a href="/product/1665/">264<i class="i"></i></a></div>
              <div class="commented"><a href="/product/1665/#comments">85<i class="i"></i></a></div>
              <div class="date">12.05.2012<i class="i"></i></div>
              <div class="share">
                <div class="share-itemid">1665</div>
                <div class="share-url">http://w39.handy-friendy.com/product/1665/</div>
                <div class="share-title">Вязаный медвежонок</div>
                <div class="share-descr">Забавный вязаный медвежок. Размер стоя 18 см, сидя 14 см. 5-ти-шплинтовое крепление. Наполнитель - синтепон. </div>
                <div class="share-image">http://w39.handy-friendy.com/uploads/sites/39/img/6_f212a58abf0504f102f0e1db7c5acb0a.gif</div>
              </div>
            </div>
          </div>
          <h3><a href="/product/1665/">Вязаный медвежонок</a></h3>
        </div>
        <div class="li">
          <input name="itemid[2]" value="1664" type="hidden" />
          <div class="image">
            <div class="img"><a href="/product/1664/"><img src="/uploads/sites/39/img/6_df872d60bed783d7286eb44134845c1b.jpeg" alt="" /></a></div>
            <div class="info">
              <div class="viewed"><a href="/product/1664/">264<i class="i"></i></a></div>
              <div class="commented"><a href="/product/1664/#comments">85<i class="i"></i></a></div>
              <div class="date">12.05.2012<i class="i"></i></div>
              <div class="share">
                <div class="share-itemid">1664</div>
                <div class="share-url">http://w39.handy-friendy.com/product/1664/</div>
                <div class="share-title">Монетница</div>
                <div class="share-descr">Деревянная шкатулка для денежных купюр, выполненная в технике декупаж. Размеры 17х8х4 см</div>
                <div class="share-image">http://w39.handy-friendy.com/uploads/sites/39/img/6_df872d60bed783d7286eb44134845c1b.jpeg</div>
              </div>
            </div>
          </div>
          <h3><a href="/product/1664/">Монетница</a></h3>
        </div>
        <div class="li">
          <input name="itemid[3]" value="1663" type="hidden" />
          <div class="image">
            <div class="img"><a href="/product/1663/"><img src="/uploads/sites/39/img/6_6b090c4c7109f811ae961d368838b7f9.JPG" alt="" /></a></div>
            <div class="info">
              <div class="viewed"><a href="/product/1663/">264<i class="i"></i></a></div>
              <div class="commented"><a href="/product/1663/#comments">85<i class="i"></i></a></div>
              <div class="date">12.05.2012<i class="i"></i></div>
              <div class="share">
                <div class="share-itemid">1663</div>
                <div class="share-url">http://w39.handy-friendy.com/product/1663/</div>
                <div class="share-title">Цветочный горшок</div>
                <div class="share-descr">Цветочный горшочек из дерева, выполненный в технике декупаж. Размеры 9,5х9,5х11 см </div>
                <div class="share-image">http://w39.handy-friendy.com/uploads/sites/39/img/6_6b090c4c7109f811ae961d368838b7f9.JPG</div>
              </div>
            </div>
          </div>
          <h3><a href="/product/1663/">Цветочный горшок</a></h3>
        </div>
      </div>
    </div>

    <ul class="site-results">
      <li>
        <div class="num">1.</div>
        <div class="descr">
          <h3><a href="#">Дизайн интерьеров</a></h3>
          <div class="text">Стратегия предоставления скидок и бонусов ускоряет <span class="match">конструктивный выставочный стенд</span>, осознав маркетинг как часть производства. Интересно отметить, что анализ зарубежного опыта искажает межличностный целевой трафик, используя опыт предыдущих кампаний.</div>
        </div>
      </li>
      <li>
        <div class="num">2.</div>
        <div class="descr">
          <h3><a href="#">Дизайн интерьеров</a></h3>
          <div class="text">Стратегия предоставления скидок и бонусов ускоряет <span class="match">конструктивный выставочный стенд</span>, осознав маркетинг как часть производства. Интересно отметить, что анализ зарубежного опыта искажает межличностный целевой трафик, используя опыт предыдущих кампаний.</div>
        </div>
      </li>
      <li>
        <div class="num">3.</div>
        <div class="descr">
          <h3><a href="#">Дизайн интерьеров</a></h3>
          <div class="text">Стратегия предоставления скидок и бонусов ускоряет <span class="match">конструктивный выставочный стенд</span>, осознав маркетинг как часть производства. Интересно отметить, что анализ зарубежного опыта искажает межличностный целевой трафик, используя опыт предыдущих кампаний.</div>
        </div>
      </li>
      <li>
        <div class="num">4.</div>
        <div class="descr">
          <h3><a href="#">Дизайн интерьеров</a></h3>
          <div class="text">Стратегия предоставления скидок и бонусов ускоряет <span class="match">конструктивный выставочный стенд</span>, осознав маркетинг как часть производства. Интересно отметить, что анализ зарубежного опыта искажает межличностный целевой трафик, используя опыт предыдущих кампаний.</div>
        </div>
      </li>
      <li class="last">
        <div class="num">58.</div>
        <div class="descr">
          <h3><a href="#">Дизайн интерьеров</a></h3>
          <div class="text">Стратегия предоставления скидок и бонусов ускоряет <span class="match">конструктивный выставочный стенд</span>, осознав маркетинг как часть производства. Интересно отметить, что анализ зарубежного опыта искажает межличностный целевой трафик, используя опыт предыдущих кампаний.</div>
        </div>
      </li>
    </ul>

  </div>
-->

  <div class="layout-bottom">
    <?=$this->view->pager;?>
    <div class="up"><?=$this->registry->translate['top'];?><i class="i"></i></div>
  </div>

</div>