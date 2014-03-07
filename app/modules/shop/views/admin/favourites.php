<div class="h1">
  <h1><?=$this->view->translate['addedtofav'];?></h1>
</div>

<div class="favorites">
  <input name="favers_url" value="/_temp/_favers.php" type="hidden" />
  <div class="table">
    <div class="tbody">
      <?
        foreach($this->view->favouriteslist as $fav) {
          $cnt=0;
      ?>
      	  <div class="tr<?=($cnt)?'':' first';?>">
            <input name="userid[<?=$cnt;?>]" value="<?=$fav['id'];?>" type="hidden" />
            <div class="title">
              <div class="text"><span class="user"><a href="#" target="_blank"><?=$fav['firstName'];?> <?=$fav['secondName'];?><i class="i"></i></a></span> <?=strtolower($this->view->translate['addedtofav']);?> <a href="#"><?=$fav['name'];?></a></div>
            </div>
            <div class="button-small button"><div class="bg"><div class="r"><div class="l"><div class="el"><?=$this->view->translate['writemes'];?><i class="i"></i></div></div></div></div></div>
          </div>
      <?
        }
      ?>
    </div>
  </div>
</div>
