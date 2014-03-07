<div class="catalog-widget">
  <div class="jswap">
  	<h2><?=$this->registry->wigetmenu['catalog'];?></h2>
    <? if (count($this->view->products)>1) { ?>
      <div class="controls">
        <div class="jswap-prev-disabled jswap-prev"></div>
        <div class="jswap-counter">1 / <?=count($this->view->products);?></div>
        <div class="jswap-next"></div>
      </div>
    <? } ?>
    <div class="hr"></div>
    <div class="jswap-list">
      <?
        $cnt=0;
        foreach($this->view->products as $product) {
      ?>
        <div class="<?=($cnt)?'':'jswap-li-current '?>jswap-li">
          <div class="li">
            <div class="image">
              <div class="img"><a title="<?=$product['name']?>" href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/<?=(strlen($product['name'])>0)?tools::encodestring($product['name']).'/':'';?>"><img src="<?=$product['url'];?>" alt="<?=$product['name']?>" /></a></div>
              <div class="info">
                <div class="viewed"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/<?=(strlen($product['name'])>0)?tools::encodestring($product['name']).'/':'';?>"><?=$product['visits']?><i class="i"></i></a></div>
                <div class="commented"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/<?=(strlen($product['name'])>0)?tools::encodestring($product['name']).'/':'';?>#comments">0<i class="i"></i></a></div>
                <div class="date"><?=$product['date_create'];?><i class="i"></i></div>
                <div class="share">
                  <div class="share-itemid"><?=$product['itemid'];?></div>
                  <div class="share-url">http://<?=$_SERVER['HTTP_HOST'];?>/product/<?=$product['itemid'];?>/<?=(strlen($product['name'])>0)?tools::encodestring($product['name']).'/':'';?></div>
                  <div class="share-title"><?=$product['name'];?></div>
                  <div class="share-descr"><?=strip_tags($product['detail_text']);?></div>
                  <div class="share-image">http://<?=$_SERVER['HTTP_HOST'];?><?=$product['url'];?></div>
                </div>
              </div>
            </div>
            <h3><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/<?=(strlen($product['name'])>0)?tools::encodestring($product['name']).'/':'';?>"><?=$product['name']?></a></h3>
          </div>
        </div>
      <?
          $cnt++;
        }
      ?>
    </div>
  </div>
</div>