<div class="layout-content-bg">

  <div class="layout-cols">
    
    <div class="layout-main">

      <div class="h1">
        <h1><?=$this->registry->currentpage;?></h1>
      </div>

      <div class="service">
        <div class="html">
          <? if($this->view->serviceinner['url']){?>
          <p><img src="<?=$this->view->serviceinner['url'];?>" alt="<?=$this->view->serviceinner['name'];?>"/></p>
          <?}?>
          <h2><?=$this->view->serviceinner['name'];?></h2>
          <p><?=$this->view->serviceinner['detail_text'];?></p>
        </div>
        <? if($this->view->serviceinner['link']){?>
        <div class="button"><div class="bg"><div class="r"><div class="l"><a href="<?=$this->view->serviceinner['link'];?>" class="el">Перейти к работам<i class="i"></i></a></div></div></div></div>
      	<?}?>
      </div>

    </div>

    <div class="layout-sidebar">
      <?=$this->view->widgetlist;?>
    </div>
    
  </div>

  <div class="layout-bottom">
    <?=$this->view->pager;?>
    <div class="up"><?=$this->registry->translate['top'];?><i class="i"></i></div>
  </div>

</div>