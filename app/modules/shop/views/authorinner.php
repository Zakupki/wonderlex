<div class="layout-content-bg">

  <div class="layout-cols">
    
    <div class="layout-main">

      <div class="h1">
        <h1><?=$this->view->authorinner['name'];?></h1>
      </div>

      <div class="author">
        <div class="html">
          <? if($this->view->authorinner['url']){?>
          <p><img src="<?=$this->view->authorinner['url'];?>" alt=""/></p>
          <?}?>
          <p><?=$this->view->authorinner['detail_text'];?></p>
        </div>
        
        <ul class="links">
          <?
            if ($this->view->authorinner['twitter']) {
              $this->view->authorinner['twitter']=str_replace('https://', '',$this->view->authorinner['twitter']);
              $this->view->authorinner['twitter']=str_replace('http://', '',$this->view->authorinner['twitter']);
              $prottype='http://';
          ?>
              <li class="twitter"><a href="<?=$prottype;?><?=$this->view->authorinner['twitter'];?>" target="_blank"><i class="i"></i></a></li>
          <?
            }
          ?>
          <?
            if ($this->view->authorinner['facebook']) {
              $this->view->authorinner['facebook']=str_replace('https://', '',$this->view->authorinner['facebook']);
              $this->view->authorinner['facebook']=str_replace('http://', '',$this->view->authorinner['facebook']);
              $prottype='http://';
          ?>
              <li class="fb"><a href="<?=$prottype;?><?=$this->view->authorinner['facebook'];?>" target="_blank"><i class="i"></i></a></li>
          <?
            }
          ?>
          <?
            if ($this->view->authorinner['vkontakte']) {
              $this->view->authorinner['vkontakte']=str_replace('https://', '',$this->view->authorinner['vkontakte']);
              $this->view->authorinner['vkontakte']=str_replace('http://', '',$this->view->authorinner['vkontakte']);
              $prottype='http://';
          ?>
              <li class="vk"><a href="<?=$prottype;?><?=$this->view->authorinner['vkontakte'];?>" target="_blank"><i class="i"></i></a></li>
          <?
            }
          ?>
          <?
            if ($this->view->authorinner['instagram']) {
              $this->view->authorinner['instagram']=str_replace('https://', '',$this->view->authorinner['instagram']);
              $this->view->authorinner['instagram']=str_replace('http://', '',$this->view->authorinner['instagram']);
              $prottype='http://';
          ?>
          <li class="instagram"><a href="<?=$prottype;?><?=$this->view->authorinner['instagram'];?>" target="_blank"><i class="i"></i></a></li>
          <?
            }
          ?>
        </ul>
        <? if ($this->view->authorinner['products']>0) { ?>
          <div class="button"><div class="bg"><div class="r"><div class="l"><a href="/catalog/?authorid=<?=$this->view->authorinner['itemid'];?>" class="el">Перейти к работам<i class="i"></i></a></div></div></div></div>
        <? } ?>
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