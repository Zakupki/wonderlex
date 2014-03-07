<div class="h1">
  <h1><?=$this->registry->currentpage;?></h1>
  <div class="search">
    <form action="" method="get">
      <label for="search-q" class="placeholder"><?=$this->view->translate['search'];?></label>
      <input name="q"<?=($_GET['q'])?' value="'.$_GET['q'].'"':'';?> id="search-q" type="text" />
      <button type="submit"><i class="i"></i></button>
    </form>
  </div>
  <div class="add button-small button"><div class="bg"><div class="r"><div class="l"><a href="/admin/event/" class="el"><?=$this->view->translate['add'];?> событие<i class="i"></i></a></div></div></div></div>
</div>

<form action="/admin/updateevents/" method="post">
  <div class="events form">
    <div class="table">
      <div class="thead">
        <div class="title"><div class="text"><?=$this->view->translate['title'];?></div></div>
        <div class="date"><div class="text"><?=$this->view->translate['datecreate'];?></div></div>
      </div>
      <div class="sortable tbody">
        <?
          $cnt=0;
          foreach ($this->view->events as $event) {
        ?>
            <div class="tr<?=($cnt)?'':' first';?><?=($cnt==count($this->view->events)-1)?' last':'';?>">
              <input name="itemid[<?=$cnt;?>]" value="<?=$event['itemid'];?>" type="hidden" />
              <div class="title"><div class="text"><a href="/admin/event/<?=$event['itemid'];?>/"><?=$event['name'];?><i class="image" style="background-image: url();"></i></a></div></div>
              <div class="date"><div class="text"><?=$event['date_start'];?></div></div>
              <div class="edit"><a href="/admin/event/<?=$event['itemid'];?>/"><i title="Редактировать" class="i"></i></a></div>
              <div class="remove">
                <input name="remove[<?=$cnt;?>][<?=$event['itemid'];?>]" value="0" type="hidden" />
                <i class="i" title="Удалить"></i>
              </div>
              <div class="state<?=($event['active'])?'':' disabled';?>">
                <input name="state[<?=$cnt;?>][<?=$event['itemid'];?>]" value="1" type="hidden" />
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
