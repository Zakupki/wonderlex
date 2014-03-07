<div class="layout-content-bg">

  <div class="layout-cols">
    
    <div class="layout-main">

      <div class="h1">
        <input name="itemid" value="<?=$this->view->productinner['itemid'];?>" type="hidden" />
        <input name="buy_url" value="/howtoorder/" type="hidden" />
        <input name="help_url" value="/howtobuy/" type="hidden" />
        <div class="back-link"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/catalog/<?=$this->view->productinner['categoryid'];?>/<?=tools::encodestring($this->view->productinner['categoryname']);?>/"><?=$this->view->productinner['categoryname'];?></a></div>
        <h1><?=$this->view->productinner['name'];?></h1>
        <div class="info">
          <div class="viewed"><?=$this->view->productinner['visits'];?><i class="i"></i></div>
          <div class="commented"><?=tools::int($this->view->commentsinner);?><i class="i"></i></div>
          <div class="date"><?=$this->view->productinner['date_create'];?><i class="i"></i></div>
        </div>
        <div class="br"></div>
    		<?
      		foreach($this->view->images as $image) {
            if ($image['major']) {
              $mainimage=$image['url'];
              $mainorigimage=$image['origimg'];
            }
      		}
    		?>
        <ul class="share-bar">
          <li class="vk"></li>
          <li class="fb"><div class="fb-like" data-layout="button_count" data-font="tahoma"></div></li>
          <li class="twitter"><a href="https://twitter.com/share" class="twitter-share-button" data-text="<?=$this->view->productinner['name'];?>" data-lang="en">Tweet</a></li>
          <li class="pinit"><a href="http://pinterest.com/pin/create/button/?url=<?=urlencode('http://'.$_SERVER['HTTP_HOST'].'/product/'.$this->view->productinner['itemid'].'/');?>&amp;media=<?=urlencode('http://'.$_SERVER['HTTP_HOST'].$mainorigimage);?>&amp;description=<?=urlencode($this->view->productinner['name']);?>" class="pin-it-button" count-layout="horizontal" target="_blank"></a></li>
        </ul>
        <? if($this->view->productinner['order']<2) { ?> 
          <div class="help button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['buy'];?><i class="i"></i></button></div></div></div></div>
        <?}elseif($this->view->productinner['order']>1){?>
          <div class="buy button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['buy'];?><i class="i"></i></button></div></div></div></div>
        <?} if($this->view->productinner['price']>0) { ?>
          <div class="price"><?=$this->view->productinner['price'];?> <span><?=$this->view->productinner['curname'];?></span></div>
        <? } ?>
        <div class="pager">
          <?
            if ($this->view->prevproduct['itemid']>0) {
          ?>
              <div rel="prev" class="prev"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$this->view->prevproduct['itemid'];?>/<?=(strlen($this->view->prevproduct['name'])>0)?tools::encodestring($this->view->prevproduct['name']).'/':'';?>"><?=$this->registry->translate['prevwork'];?><i class="i"></i></a></div>
          <?
            }
            if ($this->view->nextproduct['itemid']>0) {
          ?>
              <div rel="next" class="next"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$this->view->nextproduct['itemid'];?>/<?=(strlen($this->view->nextproduct['name'])>0)?tools::encodestring($this->view->nextproduct['name']).'/':'';?>"><?=$this->registry->translate['nextwork'];?><i class="i"></i></a></div>
          <?
            }
          ?>
        </div>
      </div>

      <div class="gallery">
        <div class="preview">
          <div class="img"><img src="<?=$mainimage;?>" alt="<?=$this->view->productalt1;?> <?=$this->view->productinner['name'];?> <?=$this->view->productalt2;?>" /></div>
          <div class="loading"></div>
          <div class="zoom"><i class="i"></i></div>
          <div rel="prev" class="prev"><i class="i"></i></div>
          <div rel="next" class="next"><i class="i"></i></div>
        </div>
        <div class="thumbs<?=(count($this->view->images)==1)?' thumbs-disabled':'';?>">
          <div class="prev-disabled prev"></div>
          <div class="viewport">
            <ul>
              <?
                $cnt=0;
                foreach($this->view->images as $image) {
              ?>
                  <li><a href="<?=$image['origimg'];?>" rel="<?=$image['url'];?>"<?=($image['major'])?' class="act"':'';?>><img src="<?=$image['url2'];?>" alt="<?=$this->view->productalt1;?> <?=$this->view->productinner['name'];?> <?=$this->view->productalt2;?>" /></a></li>
              <?
                  $cnt++;
                }
              ?>
            </ul>
          </div>
          <div rel="next" class="next"></div>
        </div>
      </div>
      
      <div class="work">
        <div class="text"><?=$this->view->productinner['detail_text'];?></div>
        <div class="specs"><?=$this->view->productinner['techinfo'];?></div>
      </div>
      <? if(strlen($this->view->productinner['seotext'])>0){?>
      <div class="work">
      <?=$this->view->productinner['seotext'];?>
      </div>
      <?}?>

    </div>

    <div class="layout-sidebar">
      <?=$this->view->widgetlist;?>
    </div>
    
  </div>

  <div class="catalog-related catalog">
    <h2><?=$this->registry->translate['similarworks'];?></h2>
    <div class="list">
      <?
        $cnt=0;
        $tcnt=0;
        foreach ($this->view->otherproducts as $product) {
          if ($cnt==4) {
            echo '<div class="br"></div>';
            $cnt=0;
          }
      ?>
          <div class="li">
            <input name="itemid[<?=$cnt;?>]" value="<?=$product['itemid'];?>" type="hidden" />
            <div class="image">
              <div class="img"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/<?=tools::encodestring($product['name']);?>/"><img src="<?=$product['url'];?>" alt="<?=$this->view->productalt1;?> <?=$product['name'];?> <?=$this->view->productalt2;?>" /></a></div>
              <div class="info">
                <div class="viewed"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/<?=(strlen($product['name'])>0)?tools::encodestring($product['name']).'/':'';?>"><?=$product['visits'];?><i class="i"></i></a></div>
                <div class="commented"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/<?=(strlen($product['name'])>0)?tools::encodestring($product['name']).'/':'';?>#comments"><?=tools::int($this->view->othercomments[$product['itemid']]);?><i class="i"></i></a></div>
                <div class="date"><?=$product['date_create'];?><i class="i"></i></div>
                <div class="share">
                  <div class="share-itemid"><?=$product['itemid'];?></div>
                  <div class="share-url">http://<?=$_SERVER['HTTP_HOST'];?>/product/<?=$product['itemid'];?>/</div>
                  <div class="share-title"><?=$product['name'];?></div>
                  <div class="share-descr"><?=strip_tags($product['detail_text']);?></div>
                  <div class="share-image">http://<?=$_SERVER['HTTP_HOST'];?><?=$product['url'];?></div>
                </div>
              </div>
              <? if($product['preview']){?>
              <div class="sample"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/<?=tools::encodestring($product['name']);?>/"></a></div>
              <?}?>
            </div>
            <h3><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/<?=tools::encodestring($product['name']);?>/"><?=$product['name'];?></a></h3>
          </div>
      <?
          $cnt++;
          $tcnt++;
        }
      ?>
    </div>
  </div>

  <div class="comments">
    <div class="comments-loading">Загрузка комментариев...<i class="i"></i><input name="url" value="/comments/showcomments/?id=<?=$this->view->productinner['itemid'];?>" type="hidden" /></div>
  </div>

  <div class="layout-bottom">
    <div class="pager">
      <?
        if ($this->view->prevproduct['itemid']>0) {
      ?>
          <div rel="prev" class="prev"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$this->view->prevproduct['itemid'];?>/<?=(strlen($this->view->prevproduct['name'])>0)?tools::encodestring($this->view->prevproduct['name']).'/':'';?>"><?=$this->registry->translate['prevwork'];?><i class="i"></i></a></div>
      <?
        }
        if ($this->view->nextproduct['itemid']>0) {
      ?>
          <div rel="next" class="next"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$this->view->nextproduct['itemid'];?>/<?=(strlen($this->view->nextproduct['name'])>0)?tools::encodestring($this->view->nextproduct['name']).'/':'';?>"><?=$this->registry->translate['nextwork'];?><i class="i"></i></a></div>
      <?
        }
      ?>
    </div>
    <div class="up"><?=$this->registry->translate['top'];?><i class="i"></i></div>
  </div>

</div>