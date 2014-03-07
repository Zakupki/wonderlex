<div class="h1">
  <h1><?=$this->registry->currentpage;?></h1>
  <div class="search">
    <form action="" method="get">
      <label for="search-q" class="placeholder"><?=$this->view->translate['search'];?></label>
      <input name="q"<?=($_GET['q'])?' value="'.$_GET['q'].'"':'';?> id="search-q" type="text" />
      <button type="submit"><i class="i"></i></button>
    </form>
  </div>
  <div class="add button-small button"><div class="bg"><div class="r"><div class="l"><a href="/admin/service/" class="el"><?=$this->view->translate['add'];?> сервис<i class="i"></i></a></div></div></div></div>
</div>

<form action="/admin/updateservices/" method="post">
  <div class="services form">
    <div class="table">
      <div class="sortable tbody">
        <?
          $cnt=0;
          $classArr=array(0=>'first ', count($this->view->services)-1=>'last ');
          foreach ($this->view->services as $service) {
        ?>
            <div class="<?=$classArr[$cnt];?>tr">
              <input name="itemid[<?=$cnt;?>]" value="<?=$service['itemid'];?>" type="hidden" />
              <div class="title"><div class="text"><a href="/admin/service/<?=$service['itemid'];?>"><?=$service['name'];?><i class="image" style="background-image: url(<?=$service['url'];?>);"></i></a></div></div>
              <div class="edit"><a href="/admin/service/<?=$service['itemid'];?>"><i title="Редактировать" class="i"></i></a></div>
              <div class="remove">
                <input name="remove[<?=$cnt;?>][<?=$service['itemid'];?>]" value="0" type="hidden" />
                <i class="i" title="Удалить"></i>
              </div>
              <div class="state<?=($service['active'])?'':' disabled';?>">
                <input name="state[<?=$cnt;?>][<?=$service['itemid'];?>]" value="<?=$service['active'];?>" type="hidden" />
                <i class="disable" title="Скрыть"></i>
                <i class="enable" title="Отобразить"></i>
              </div>
              <div class="handle"></div>
            </div>
        <?
            $cnt++;
          }
        ?>
       </div>
      <div class="trash"></div>
    </div>
    <div class="submit">
      <div class="button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['save'];?></button></div></div></div></div>
    </div>
  </div>
</form>
