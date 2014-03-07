<?
  if ($this->view->banners) {
?>
  <div class="teaser">
    <div class="jflow">
      <input name="buy_url" value="/howtobuy/" type="hidden" />
      <input name="fave_url" value="/favourites/add/" type="hidden" />
      <input name="favers_url" value="/favourites/all/" type="hidden" />
      <div class="jflow-viewport">
        <?
          $cnt=0;
          foreach($this->view->banners['products'] as $banner) {
          	if($banner['preview']>0)
          	$previewtesaser=1;
        ?>
            <div class="<?=($cnt)?'':'jflow-li-current ';?>jflow-li">
              <input name="itemid[<?=$cnt;?>]" value="<?=$banner['itemid'];?>" type="hidden" />
              <div class="image" style="background-image: url(<?=$banner['banner'];?>);"></div>
              <div class="descr">
                <h3><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$banner['itemid'];?>/<?=(strlen($banner['name'])>0)?tools::encodestring($banner['name']).'/':'';?>"><?=$banner['name'];?></a></h3>
                <div class="info">
                  <div class="viewed"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$banner['itemid'];?>/<?=(strlen($banner['name'])>0)?tools::encodestring($banner['name']).'/':'';?>"><span><?=$banner['visits'];?></span><i class="i"></i></a></div>
                  <div class="commented"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$banner['itemid'];?>/<?=(strlen($banner['name'])>0)?tools::encodestring($banner['name']).'/':'';?>#comments"><span><?=tools::int($this->view->comments[$banner['itemid']]);?></span><i class="i"></i></a></div>
                  <div class="date"><?=$banner['date_create'];?><i class="i"></i></div>
                  <div class="share">
                    <div class="share-itemid"><?=$banner['itemid'];?></div>
                    <div class="share-url">http://<?=$_SERVER['HTTP_HOST'];?>/product/<?=$banner['itemid'];?>/</div>
                    <div class="share-title"><?=$banner['name'];?></div>
                    <div class="share-descr"><?=strip_tags($banner['detail_text']);?></div>
                    <div class="share-image">http://<?=$_SERVER['HTTP_HOST'];?><?=$banner['image'];?></div>
                  </div>
                </div>
              </div>
            </div>
        <?
            $cnt++;
          }
        ?>  
      </div>
      <div class="jflow-prev"><i class="i"></i></div>
      <div class="jflow-next"><i class="i"></i></div>
      <? if($previewtesaser){?>
      <div class="sample"></div>
      <?}?>
    </div>
  </div>
<?}?>