<div class="layout-content-bg">

  <div class="h1">
    <h1><?=($this->view->currentcat)?$this->view->currentcat:$this->registry->currentpage;?></h1>
    <div class="filter">
      <div class="jdrop">
        <div class="jdrop-title"><div class="jdrop-caption"><?=$this->registry->translate['allcategories'];?></div><div class="jdrop-arrow"></div></div>
        <div class="jdrop-list">
          <ul>
            <? foreach($this->view->category as $category) { ?>
              <li><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/catalog/<?=$category['itemid'];?>/<?=tools::encodestring($category['name']);?>/"><?=$category['name'];?></a></li>
            <? } ?>
          </ul>
        </div>
      </div>
<!--
      <div class="jdrop">
        <div class="jdrop-title"><div class="jdrop-caption">Последние добавленные</div><div class="jdrop-arrow"></div></div>
        <div class="jdrop-list">
          <ul>
            <li><a href="#">Самые популярные</a></li>
            <li><a href="#">Последние добавленные</a></li>
          </ul>
        </div>
      </div>
-->
    </div>
    <?=$this->view->pager;?>
  </div>

  <div class="catalog">
    <div class="list">
      <?
        $cnt=0;
        $tcnt=0;
		foreach ($this->view->products as $product) {
          if ($cnt==4) {
            echo '<div class="br"></div>';
            $cnt=0;
          }
      ?>
          <div class="li">
            <div class="image">
              <div class="img"><a title="<?=$this->view->producttitle1;?> <?=$product['name'];?> (<?=tools::translit($product['name']);?>) <?=$this->view->producttitle2;?>" href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/<?=(strlen($product['name'])>0)?tools::encodestring($product['name']).'/':'';?>"><img src="<?=$product['url'];?>" alt="<?=$this->view->productalt1;?> <?=$product['name'];?> <?=$this->view->productalt2;?>" /></a></div>
              <div class="info">
                <div class="viewed"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/<?=(strlen($product['name'])>0)?tools::encodestring($product['name']).'/':'';?>"><?=$product['visits'];?><i class="i"></i></a></div>
                <div class="commented"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/<?=(strlen($product['name'])>0)?tools::encodestring($product['name']).'/':'';?>#comments"><?=tools::int($this->view->comments[$product['itemid']]);?><i class="i"></i></a></div>
                <div class="date"><?=$product['date_create'];?><i class="i"></i></div>
                <div class="share">
                  <div class="share-itemid"><?=$product['itemid'];?></div>
                  <div class="share-url">http://<?=$_SERVER['HTTP_HOST'];?>/product/<?=$product['itemid'];?>/<?=(strlen($product['name'])>0)?tools::encodestring($product['name']).'/':'';?></div>
                  <div class="share-title"><?=$product['name'];?></div>
                  <div class="share-descr"></div>
                  <div class="share-image">http://<?=$_SERVER['HTTP_HOST'];?><?=$product['url'];?></div>
                </div>
              </div>
               <? if($product['preview']){?>
              <div class="sample"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/<?=(strlen($product['name'])>0)?tools::encodestring($product['name']).'/':'';?>"></a></div>
              <?}?>
            </div>
            <h3><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/<?=(strlen($product['name'])>0)?tools::encodestring($product['name']).'/':'';?>"><?=$product['name'];?></a></h3>
          </div>
      <?
          $cnt++;
          $tcnt++;
        }
      ?>
    </div>
    
  </div>

  <div class="layout-bottom">
    <?=$this->view->pager;?>
    <div class="up"><?=$this->registry->translate['top'];?><i class="i"></i></div>
  
  </div>
   <? if(strlen($this->view->seotext)>0){?>
    <div style="padding: 0 0 16px 0;">
	      <?=$this->view->seotext;?>
	</div>
   <?}?>
</div>