<div class="layout-content-bg">

  <div class="layout-cols">

    <div class="layout-main">

      <div class="h1">
        <h1><?=$this->registry->currentpage;?></h1>
      </div>
      <div class="html"><?=$this->view->agreement['agreement'];?></div>

    </div>  

    <div class="layout-sidebar">
      <?=$this->view->widgetlist;?>
    </div>

  </div>

  <div class="layout-bottom">
    <div class="up"><?=$this->registry->translate['top'];?><i class="i"></i></div>
  </div>

</div>