<div class="events-widget">
  <div class="jswap">
    <h2><?=$this->view->pagename;?></h2>
    <? if (count($this->view->eventlist)>1) { ?>
      <div class="controls">
        <div class="jswap-prev-disabled jswap-prev"></div>
        <div class="jswap-counter">1 / <?=count($this->view->eventlist);?></div>
        <div class="jswap-next"></div>
      </div>
    <? } ?>
    <div class="hr"></div>
    <div class="jswap-list">
      <?
        $cnt=0;
        foreach($this->view->eventlist as $event) {
      ?>
          <div class="<?=($cnt)?'':'jswap-li-current ';?>jswap-li">
            <div class="li">
              <div class="date">
                <a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/event/<?=$event['itemid'];?>/<?=(strlen($event['name'])>0)?tools::encodestring($event['name']).'/':'';?>">
                  <span class="day"><?=$event['dayinmonth'];?></span>
                  <span class="month"><?=mb_substr(tools::GetMonth($event['month']),0,3,'UTF-8');?></span>
                </a>
              </div>
              <h3><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/event/<?=$event['itemid'];?>/<?=(strlen($event['name'])>0)?tools::encodestring($event['name']).'/':'';?>"><?=$event['name'];?></a></h3>
              <div class="br"></div>
<!--               <div class="location"><a href="#"><span>Киев, ул. Вернадского, 12</span><i class="i"></i></a></div> -->
              <div class="text"><?=mb_substr(strip_tags($event['detail_text']),0,150,'UTF-8');?>...</div>
            </div>
          </div>
      <?
          $cnt++;
        }
      ?>
    </div>
  </div>
</div>