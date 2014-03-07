<div class="layout-content-bg">

  <div class="layout-cols">

    <div class="layout-main">

      <div class="h1">
        <div class="back-link"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/events/"><?=$this->registry->currentpage;?></a></div>
        <h1><?=$this->view->event['name'];?></h1>
        <div class="br"></div>
        <ul class="share-bar">
          <li id="share-bar-vk"></li>
          <li id="share-bar-fb"><div class="fb-like" data-layout="button_count" data-font="tahoma"></div></li>
          <li id="share-bar-twitter"><a href="https://twitter.com/share" class="twitter-share-button" data-text="<?=$this->view->event['name'];?>" data-lang="en">Tweet</a></li>
        </ul>
        <div class="pager">
          <?
            if ($this->view->prevevent['itemid']>0) {
          ?>
              <div rel="prev" class="prev"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/event/<?=$this->view->prevevent['itemid'];?>/<?=(strlen($this->view->prevevent['name'])>0)?tools::encodestring($this->view->prevevent['name']).'/':''?>"><?=$this->registry->translate['prevevent'];?><i class="i"></i></a></div>
          <?
            }
            if ($this->view->nextevent['itemid']>0) {
          ?>
              <div rel="next" class="next"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/event/<?=$this->view->nextevent['itemid'];?>/<?=(strlen($this->view->nextevent['name'])>0)?tools::encodestring($this->view->nextevent['name']).'/':''?>"><?=$this->registry->translate['nextevent'];?><i class="i"></i></a></div>
          <?
            }
          ?>
        </div>
      </div>

      <div class="html">
        <?=$this->view->event['detail_text'];?>
      </div>

    </div>

    <div class="layout-sidebar">
      <?=$this->view->widgetlist;?>
    </div>
    
  </div>

  <div class="layout-bottom">
    <div class="pager">
      <?
        if ($this->view->prevevent['itemid']>0) {
      ?>
          <div rel="prev" class="prev"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/event/<?=$this->view->prevevent['itemid'];?>/<?=(strlen($this->view->prevevent['name'])>0)?tools::encodestring($this->view->prevevent['name']).'/':''?>"><?=$this->registry->translate['prevevent'];?><i class="i"></i></a></div>
      <?
        }
        if ($this->view->nextevent['itemid']>0) {
      ?>
          <div rel="next" class="next"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/event/<?=$this->view->nextevent['itemid'];?>/<?=(strlen($this->view->nextevent['name'])>0)?tools::encodestring($this->view->nextevent['name']).'/':''?>"><?=$this->registry->translate['nextevent'];?><i class="i"></i></a></div>
      <?
        }
      ?>
    </div>
    <div class="up"><?=$this->registry->translate['top'];?><i class="i"></i></div>
  </div>

</div>