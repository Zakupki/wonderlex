<div class="layout-content-bg">

  <div class="layout-cols">
    
    <div class="layout-main">
    
      <div class="h1">
        <h1><?=$this->registry->currentpage;?></h1>
      </div>
    
      <div class="services">
        <?
		$cnt=0;
		foreach($this->view->services as $service) {
		$cnt++;?>
		<div class="<?=($cnt==count($this->view->services))?'last ':'';?>li">
          <? if ($service['url']){?>
          <div class="image"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/service/<?=$service['id'];?>/<?=(strlen($service['name'])>0)?tools::encodestring($service['name']).'/':'';?>"><img src="<?=$service['url'];?>" alt="<?=$service['name'];?>" /></a></div>
          <?}?>
          <div class="descr">
            <h3><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/service/<?=$service['id'];?>/<?=(strlen($service['name'])>0)?tools::encodestring($service['name']).'/':'';?>"><?=$service['name'];?></a></h3>
            <div class="text">
            	<p><?=strip_tags($service['preview_text']);?></p>
			</div>
          </div>
        <? if($service['link']){?>
        <div class="button"><div class="bg"><div class="r"><div class="l"><a href="<?=$service['link'];?>" class="el">Перейти к работам<i class="i"></i></a></div></div></div></div>
      	<?}?>
        </div>
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