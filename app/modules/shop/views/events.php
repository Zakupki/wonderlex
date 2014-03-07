<div class="layout-content-bg">
  
  <div class="layout-cols">
    
    <div class="layout-main">

      <div class="h1">
        <h1><?=$this->registry->currentpage;?></h1>
        <?=$this->view->pager;?>
      </div>

      <div class="events">
        <?
          $cnt=0;
          foreach($this->view->eventlist as $event) {
        ?>
            <div class="<?=($cnt==count($this->view->eventlist)-1)?'last ':'';?>li">
              <div class="date">
                <a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/event/<?=$event['itemid'];?>/<?=(strlen($event['name'])>0)?tools::encodestring($event['name']).'/':'';?>">
                  <span class="day"><?=$event['dayinmonth'];?></span>
                  <span class="month"><?=mb_substr(tools::GetMonth($event['month'],$_SESSION['langid']),0,3,'UTF-8');?></span>
                </a>
              </div>
              <div class="descr">
                <h3><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/event/<?=$event['itemid'];?>/<?=(strlen($event['name'])>0)?tools::encodestring($event['name']).'/':'';?>"><?=$event['name'];?></a></h3>
<!--
                <div class="location"><a href="#" target="_blank"><span>Киев, ул. Вернадского, 12</span><i class="i"></i></a></div>
                <div class="image"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/event/<?=$event['itemid'];?>/<?=tools::encodestring($event['name']);?>/"><img src="/uploads/events.jpg" alt="" /></a></div>
-->
                <div class="text"><?=mb_substr(strip_tags($event['detail_text']),0,150,'UTF-8');?>...</div>
              </div>
            </div>
        <?
            $cnt++;
          }
        ?>
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