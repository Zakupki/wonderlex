<div class="layout-content-bg">

  <div class="layout-cols">

    <div class="layout-main">

      <div class="h1">
        <div class="back-link"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/blogs/"><?=$this->registry->currentpage;?></a></div>
        <h1><?=$this->view->blog['name'];?></h1>
        <div class="info">
          <div class="date"><?=$this->view->blog['date_start'];?><i class="i"></i></div>
        </div>
        <div class="br"></div>
        <ul class="share-bar">
          <li id="share-bar-vk"></li>
          <li id="share-bar-fb"><div class="fb-like" data-layout="button_count" data-font="tahoma"></div></li>
          <li id="share-bar-twitter"><a href="https://twitter.com/share" class="twitter-share-button" data-text="<?=$this->view->blog['name'];?>" data-lang="en">Tweet</a></li>
        </ul>
        <div class="pager">
          <?
            if ($this->view->prevblog['itemid']>0) {
          ?>
              <div class="prev"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/blog/<?=$this->view->prevblog['itemid'];?>/"><?=$this->registry->translate['prevpost'];?><i class="i"></i></a></div>
          <?
            }
            if ($this->view->nextblog['itemid']>0) {
          ?>
              <div rel="next" class="next"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/blog/<?=$this->view->nextblog['itemid'];?>/"><?=$this->registry->translate['nextpost'];?><i class="i"></i></a></div>
          <?
            }
          ?>
        </div>
      </div>

      <div class="html">
        <?=$this->view->blog['detail_text'];?>
      </div>

    </div>

    <div class="layout-sidebar">
      <?=$this->view->widgetlist;?>
    </div>
    
  </div>

  <div class="layout-bottom">
    <div class="pager">
      <?
        if ($this->view->prevblog['itemid']>0) {
      ?>
          <div class="prev"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/blog/<?=$this->view->prevblog['itemid'];?>/"><?=$this->registry->translate['prevpost'];?><i class="i"></i></a></div>
      <?
        }
        if ($this->view->nextblog['itemid']>0) {
      ?>
          <div rel="next" class="next"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/blog/<?=$this->view->nextblog['itemid'];?>/"><?=$this->registry->translate['nextpost'];?><i class="i"></i></a></div>
      <?
        }
      ?>
    </div>
    <div class="up"><?=$this->registry->translate['top'];?><i class="i"></i></div>
  </div>

</div>