<div class="layout-content-bg">

  <div class="catalog">
    <h2><?=$this->registry->wigetmenu['catalog'];?></h2>
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
            <input name="itemid[<?=$cnt;?>]" value="<?=$product['itemid'];?>" type="hidden" />
            <div class="image">
              <div class="img"><a title="<?=$this->view->producttitle1;?> <?=$product['name'];?> (<?=tools::translit($product['name']);?>) <?=$this->view->producttitle2;?>" href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/<?=(strlen($product['name'])>0)?tools::encodestring($product['name']).'/':'';?>"><img src="<?=$product['url'];?>" alt="<?=$this->view->productalt1;?> <?=$product['name'];?> <?=$this->view->productalt2;?>" /></a></div>
              <div class="info">
                <div class="viewed"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/<?=(strlen($product['name'])>0)?tools::encodestring($product['name']).'/':'';?>"><span><?=$product['visits'];?></span><i class="i"></i></a></div>
                <div class="commented"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/<?=(strlen($product['name'])>0)?tools::encodestring($product['name']).'/':'';?>#comments"><span><?=tools::int($this->view->comments[$product['itemid']]);?></span><i class="i"></i></a></div>
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

</div>

<?=$this->view->widgetlist;?>
