<?
  if ($this->view->bloglist) {
?>
  <div class="news">
    <div class="jswap">
      <h2><?=$this->view->pagename;?></h2>
      <? if(count($this->view->bloglist)>3){?>
	  <div class="controls">
        <div class="jswap-prev-disabled jswap-prev"></div>
     	 <div class="jswap-counter">1 / <?=ceil(count($this->view->bloglist)/3);?></div>
		<div class="jswap-next"></div>
      </div>
	  <?}?>
      <div class="jswap-list">
        <div class="jswap-li-current jswap-li">
          <?
            $pcnt=0;
            $cnt=0;
            foreach($this->view->bloglist as $blog) {
          ?> 
              <div class="li">
                <h3><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/blog/<?=$blog['itemid'];?>/"><?=$blog['name'];?></a></h3>
                <div class="text">
                  <p><?=mb_substr(strip_tags($blog['detail_text']),0,150,'UTF-8');?>...</p>
                </div>
                <div class="date"><?=$blog['date_start'];?><i class="i"></i></div>
              </div>
          <?
              $cnt++;
              $pcnt++;
              if ($cnt==3 && count($this->view->bloglist)>$pcnt) {
              	$cnt=0;
                echo '</div><div class="jswap-li">';
              }
            }
          ?>
        </div>
      </div>
    </div>
  </div>
<?
  }
?>