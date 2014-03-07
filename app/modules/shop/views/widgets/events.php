<?
  if ($this->view->eventlist) {
?>
  <div class="events-block">
    <div class="bg-top">
      <div class="content">
        <div class="jswap">
          <h2><?=$this->view->pagename;?></h2>
          <? if (count($this->view->eventlist)>3) { ?>
            <div class="controls">
              <div class="jswap-prev-disabled jswap-prev"></div>
              <div class="jswap-counter">1 / <?=ceil(count($this->view->eventlist)/3);?></div>
              <div class="jswap-next"></div>
            </div>
          <? } ?>
          <div class="hr"></div>
          <div class="jswap-list">
            <div class="jswap-li-current jswap-li">
              <?
                $cnt=0;
                $pcnt=0;
                foreach($this->view->eventlist as $event) {
              ?>
                  <div class="li">
                    <div class="date">
                      <a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/event/<?=$event['itemid'];?>/<?=(strlen($event['name'])>0)?tools::encodestring($event['name']).'/':'';?>">
                        <span class="day"><?=$event['dayinmonth'];?></span>
                        <span class="month"><?=mb_substr(tools::GetMonth($event['month']),0,3,'UTF-8');?></span>
                      </a>
                    </div>
                    <h3><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/event/<?=$event['itemid'];?>/<?=(strlen($event['name'])>0)?tools::encodestring($event['name']).'/':'';?>"><?=$event['name'];?></a></h3>
<!--                     <div class="location"><a href="#"><span>Киев, ул. Вернадского, 12</span><i class="i"></i></a></div> -->
                    <div class="text"><?=mb_substr(strip_tags($event['detail_text']),0,150,'UTF-8');?>...</div>
                  </div>
              <?
                  $cnt++;
                  $pcnt++;
                  if ($cnt==3 && count($this->view->eventlist)>$pcnt) {
                    $cnt=0;
                    echo '
                      </div>
                      <div class="jswap-li">
                    ';
                  }
                }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="bg-bot"></div>
  </div>
<?
  }
?>