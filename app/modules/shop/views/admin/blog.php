<div class="h1">
  <h1><?=$this->registry->currentpage;?></h1>
  <div class="search">
    <form action="" method="get">
      <label for="search-q" class="placeholder"><?=$this->view->translate['search'];?></label>
      <input name="q"<?=($_GET['q'])?' value="'.$_GET['q'].'"':'';?> id="search-q" type="text" />
      <button type="submit"><i class="i"></i></button>
    </form>
  </div>
  <div class="add button-small button"><div class="bg"><div class="r"><div class="l"><a href="/admin/blog/" class="el"><?=$this->view->translate['add'];?> запись<i class="i"></i></a></div></div></div></div>
</div>

<form action="/admin/updateblogs/" method="post">  
  <div class="blog form">
    <div class="table">
      <div class="thead">
        <div class="title"><div class="text"><?=$this->view->translate['title'];?></div></div>
        <div class="date"><div class="text"><?=$this->view->translate['datecreate'];?></div></div>
      </div>
      <div class="tbody">
        <?
          $cnt=0;
          foreach($this->view->blogs as $blog) {
        ?>
            <div class="<?=($cnt)?'':'first ';?><?=($cnt==count($this->view->blogs)-1)?'last ':'';?>tr">
              <input name="itemid[<?=$cnt;?>]" value="<?=$blog['itemid'];?>" type="hidden" />
              <div class="title"><div class="text"><a href="/admin/blog/<?=$blog['itemid'];?>/"><?=$blog['name'];?></a></div></div>
              <div class="date"><div class="text"><?=$blog['date_start'];?></div></div>
              <div class="edit"><a href="/admin/blog/<?=$blog['itemid'];?>/"><i title="Редактировать" class="i"></i></a></div>
              <div class="remove">
                <input name="remove[<?=$cnt;?>][<?=$blog['itemid'];?>]" value="0" type="hidden" />
                <i class="i" title="<?=$this->view->translate['delete'];?>"></i>
              </div>
              <div class="state<?=($blog['active'])?'':' disabled';?>">
                <input name="state[<?=$cnt;?>][<?=$blog['itemid'];?>]" value="<?=$blog['active'];?>" type="hidden" />
                <i class="disable" title="Скрыть"></i>
                <i class="enable" title="Отобразить"></i>
              </div>
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
