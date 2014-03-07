<div class="layout-content-bg">
  
  <div class="layout-cols">
    
    <div class="layout-main">

      <div class="h1">
        <h1><?=$this->registry->currentpage;?></h1>
        <?=$this->view->pager;?>
      </div>

      <div class="blog">
        <?
          $cnt=0;
          foreach($this->view->blogs as $blog) {
        ?>
          <div class="<?=($cnt==count($this->view->blogs)-1)?'last ':'';?>li">
            <h3><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/blog/<?=$blog['itemid'];?>/"><?=$blog['name'];?></a></h3>
            <div class="date"><?=$blog['date_start'];?><i class="i"></i></div>
            <!--<div class="image"><div class="img" style="background-image: url(/img/shop/uploads/about.jpg);"><img src="/img/shop/uploads/about.jpg" alt="" /></div></div>-->
            <div class="text">
              <p><?=mb_substr(strip_tags($blog['detail_text']),0,450,'UTF-8');?>...</p>
            </div>
            <div class="more"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/blog/<?=$blog['itemid'];?>/"><?=$this->registry->translate['readmore'];?>...</a></div>
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