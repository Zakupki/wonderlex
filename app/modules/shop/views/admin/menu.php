<form action="/admin/updatemenu/" method="post">

  <div class="h1">
    <h1><?=$this->view->translate['menusettings'];?></h1>
    <div class="button-small button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['save'];?></button></div></div></div></div>
  </div>
  
  <div class="menu form">
    <div class="table">
      <div class="thead">
        <div class="title"><div class="text"><?=$this->view->translate['sectionname'];?></div></div>
        <div class="url"><div class="text">URL</div></div>
        <div class="template"><div class="text"><?=$this->view->translate['template'];?></div></div>
      </div>
      <div class="sortable tbody">
        <?
          if (is_array($this->view->menuitems)) {
            $cnt=1;
            foreach($this->view->menuitems as $menu) {
        ?>
              <div class="tr<?=($cnt==1)?' first':'';?><?=($cnt==count($this->view->menuitems))?' last':'';?>">
                <div class="title">
                  <div class="input-text">
                    <div class="multiling">
                      <div class="multiling-select">
                        <select>
                          <? foreach($this->view->langlist as $lang) { ?>
                            <option><?=$lang['name'];?></option>
                          <? } ?>
                        </select>
                      </div>
                      <?
                        $cnt=0;
                        foreach($this->view->langlist as $lang) {
                      ?>
                          <div class="multiling-item<?=($cnt)?'':' multiling-current'?>"><input name="title[<?=$menu['itemid'];?>][<?=$menu['menu'][$lang['id']]['id'];?>]" value="<?=$menu['menu'][$lang['id']]['name'];?>" type="text" /></div>
                      <?
                          $cnt++;
                        }
                      ?>
                    </div>
                  </div>
                </div>
                <div class="url"><div class="text">/<?=$menu['code'];?>/</div></div>
                <div class="template"><div class="text"><?=$menu['menutypename'];?></div></div>
                <div class="state<?=($menu['active'])?'':' disabled';?>">
                  <input name="state[<?=$menu['itemid'];?>]" value="<?=$menu['active'];?>" type="hidden" />
                  <i class="disable" title="Скрыть"></i>
                  <i class="enable" title="Отобразить"></i>
                </div>
                <div class="handle"></div>
              </div>
        <?
              $cnt++;
            }
          }
        ?>
      </div>
    </div>
    <div class="submit">
      <div class="button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['save'];?></button></div></div></div></div>
    </div>
  </div>

</form>
