<div class="contacts-widget">
  <h2><?=$this->registry->translate['contacts'];?></h2>
  <div class="hr"></div>
  <div class="content">
  	<? if($this->view->contactdata['phone']){?>
    <h3><?=$this->registry->translate['phone'];?></h3>
    <p><?=$this->view->contactdata['phone'];?></p>
    <?}?>
    <h3>E-mail</h3>
    <p><a href="mailto:<?=$this->view->contactdata['email'];?>"><?=$this->view->contactdata['email'];?></a></p>
    <? if($this->view->contactdata['address']){?>
    <h3><?=$this->registry->translate['address'];?></h3>
    <p><?=$this->view->contactdata['address'];?></p>
    <?}?>
  </div>
</div>