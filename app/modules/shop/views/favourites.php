<div class="layout-content-bg">
  <div class="h1">
    <h1><?=$this->registry->translate['yourfavourites'];?></h1>
    <?=$this->view->pager;?>
  </div>
  <div class="catalog">
    <input name="buy_url" value="/howtobuy/" type="hidden" />
    <input name="fave_url" value="/favourites/add/" type="hidden" />
    <input name="favers_url" value="/_temp/_favers.php" type="hidden" />
    <div class="<?=(count($this->view->products)<=4)?'last ':'';?>row">
      <? 
        $tcnt=0;
      	$cnt=0;
        foreach($this->view->products as $product) {
            if ($cnt==4) {
            if($tcnt+4>=count($this->view->products))
	        $lastrow= 'last ';
	        else
	        $lastrow= '';
	        ?>
              </div><div class="<?=$lastrow;?>row">
            <?
            $cnt=0;
            }
      ?>
          <div class="li">
            <input name="itemid[<?=$cnt?>]" value="<?=$product['itemid'];?>" type="hidden" />
            <div class="image" style="background-image: url(<?=$product['url'];?>);">
              <a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/"></a>
              <span class="favorites <?=($product['favourite'])?' faved':'';?>">
				<?
				if(tools::int($_SESSION['User']['id'])>0 && tools::int($_SESSION['User']['id'])==tools::int($_SESSION['Site']['userid'])){
				?>
                <span class="favers-link" title="Добавили в избранное"><span><?=tools::int($this->view->favourites[$product['itemid']]);?></span><i class="i"></i></span>
              	<?}else{
              		if($product['favourite']){
					$favenum=$this->view->favourites[$product['itemid']]-1;
					$unfavenum=tools::int($this->view->favourites[$product['itemid']]);
					}
					else{
					$favenum=$this->view->favourites[$product['itemid']];
					$unfavenum=tools::int($this->view->favourites[$product['itemid']])+1;	
					}
              	?>

              <?
                  if (tools::int($_SESSION['User']['id'])>0) {
              ?>
                    <span class="unfave" title="Убрать из избранного"><span><?=tools::int($unfavenum);?></span><i class="i"></i></span>
                    <span class="fave" title="Добавить в избранное"><span><?=tools::int($favenum);?></span><i class="i"></i></span>
              <?
                  } else {
              ?>
                    <span class="fave-auth fave" title="Добавить в избранное"><span><?=tools::int($favenum);?></span><i class="i"></i></span>
	            <?
	                }
	            ?>


	           <?}?>
              </span>
            </div>
            <h3><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/product/<?=$product['itemid'];?>/"><?=$product['name'];?></a></h3>
            <?
              if (strlen($product['detail_text'])>139) {
                $product['detail_text']=mb_substr(strip_tags($product['detail_text']), 0, 136, 'UTF-8')."...";
              }
            ?>
            <div class="text"><?=$product['detail_text'];?></div>
            <div class="footer">
              <?
                if($product['price']>0) {
              ?>
                  <div class="price"><?=$product['price'];?> <?=$product['curname'];?></div>
              <?
                }
              ?>
              <div class="buy"><span><?=$this->view->translate['buy'];?><i class="i"></i></span></div>
            </div>
          </div>
          <?
            $cnt++;
      		$tcnt++;
            }
          ?>
    </div>
  </div>
  <div class="layout-bottom">
    <?=$this->view->pager;?>
    <div class="up"><?=$this->registry->translate['top'];?><i class="i"></i></div>
  </div>
</div>