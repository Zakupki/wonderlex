<form action="/admin/updatepartners/" method="post">

  <div class="h1">
    <h1><?=$this->view->translate['partneropts'];?></h1>
    <div class="button-small button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['save'];?></button></div></div></div></div>
  </div>
  
  <div class="partners form">
    <input name="image_uploader" value="/file/uploadlogo/" type="hidden" />
    <input name="image_max_w" value="150" type="hidden" />
    <input name="image_max_h" value="150" type="hidden" />
    <div class="table">
      <div class="thead">
        <div class="image"><div class="text"><?=$this->view->translate['logo'];?> (<?=$this->view->translate['desiredsize'];?>: 150х40)</div></div>
        <div class="url"><div class="text">URL</div></div>
      </div>
      <div class="sortable tbody">
        <?
          $cnt=1;
          foreach($this->view->partners as $partner) {
        ?>
            <div class="first tr">
              <input name="itemid[<?=$cnt;?>]" value="<?=$partner['id'];?>" type="hidden" />
              <div class="image">
                <input name="image_new[<?=$cnt;?>][<?=$partner['id'];?>]" value="" type="hidden" />
                <input name="image_current[<?=$cnt;?>][<?=$partner['id'];?>]" value="<?=$partner['url'];?>" type="hidden" />
                <div class="img"><img src="<?=$partner['url'];?>" alt="" /></div>
                <div class="button-small button"><div class="bg"><div class="r"><div class="l"><div class="el"><?=$this->view->translate['upload'];?><input name="image_file[<?=$cnt;?>][<?=$partner['id'];?>]" id="partners-image-file<?=$cnt;?>" type="file" /></div></div></div></div></div>
              </div>
              <div class="url"><div class="input-text"><input name="url[<?=$cnt;?>][<?=$partner['id'];?>]" value="<?=$partner['link'];?>" type="text" /></div></div>
              <div class="remove">
                <input name="remove[<?=$cnt;?>][<?=$partner['id'];?>]" value="0" type="hidden" />
                <i class="i" title="Удалить"></i>
              </div>
              <div class="state<?=($partner['active'])?'':' disabled';?>">
                <input name="state[<?=$cnt;?>][<?=$partner['id'];?>]" value="<?=$partner['active'];?>" type="hidden" />
                <i class="disable" title="Скрыть"></i>
                <i class="enable" title="Отобразить"></i>
              </div>
              <div class="handle"></div>
            </div>
        <?
            $cnt++;
          }
        ?>
        <div class="empty placeholder tr">
          <input name="itemid[<?=$cnt;?>]" value="0" type="hidden" />
          <div class="image">
            <input name="image_new[<?=$cnt;?>][0]" value="" type="hidden" />
            <div class="na img"></div>
            <div class="button-small button"><div class="bg"><div class="r"><div class="l"><div class="el"><?=$this->view->translate['upload'];?><input name="image_file[<?=$cnt;?>][0]" id="partners-image-file<?=$cnt;?>" type="file" /></div></div></div></div></div>
          </div>
          <div class="url"><div class="input-text"><input name="url[<?=$cnt;?>][0]" value="" type="text" /></div></div>
          <div class="remove">
            <input name="remove[<?=$cnt;?>][0]" value="0" type="hidden" />
            <div class="link"><i class="i" title="Удалить"></i></div>
          </div>
          <div class="state">
            <input name="state[<?=$cnt;?>][0]" value="1" type="hidden" />
            <i class="disable" title="Скрыть"></i>
            <i class="enable" title="Отобразить"></i>
          </div>
          <div class="handle"></div>
        </div>
      </div>
      <div class="tpl empty placeholder tr">
        <input name="itemid[]" value="0" type="hidden" />
        <div class="image">
          <input name="image_new[][0]" value="" type="hidden" />
          <div class="na img"></div>
          <div class="button-small button"><div class="bg"><div class="r"><div class="l"><div class="el"><?=$this->view->translate['upload'];?><input name="image_file[][0]" id="partners-image-file" type="file" /></div></div></div></div></div>
        </div>
        <div class="url"><div class="input-text"><input name="url[][0]" value="" type="text" /></div></div>
        <div class="remove">
          <input name="remove[][0]" value="0" type="hidden" />
          <div class="link"><i class="i" title="Удалить"></i></div>
        </div>
        <div class="state">
          <input name="state[][0]" value="1" type="hidden" />
          <i class="disable" title="Скрыть"></i>
          <i class="enable" title="Отобразить"></i>
        </div>
        <div class="handle"></div>
      </div>
      <div class="trash"></div>
    </div>
    <div class="submit">
      <div class="button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['save'];?></button></div></div></div></div>
    </div>
  </div>

</form>
