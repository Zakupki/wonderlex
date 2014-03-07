<form action="/admin/updatecategory/" method="post">

  <div class="h1">
    <h1><?=$this->view->translate['catalogsettings'];?></h1>
    <div class="button-small button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['save'];?></button></div></div></div></div>
  </div>
  
  <div class="categories form">
    <div class="table">
      <div class="thead">
        <div class="title"><div class="text"><?=$this->view->translate['categoryname'];?></div></div>
        <div class="url"><div class="text">URL</div></div>
      </div>
      <div class="sortable tbody">
        <?
          $cnt=1;
          if (is_array($this->view->categoryitems)) {
            foreach($this->view->categoryitems as $category) {
        ?>
              <div class="tr<?=($cnt==1)?' first':'';?><?=($cnt==count($this->view->menuitems))?' last':'';?>">
                <input name="itemid[<?=$cnt;?>]" value="<?=$category['itemid'];?>" type="hidden" />
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
                        $cnt1=0;
                        foreach($this->view->langlist as $lang) {
                      ?>
                          <div class="multiling-item<?=($cnt1)?'':' multiling-current'?>"><input name="title[<?=$cnt;?>][<?=$lang['id'];?>][<?=$category['category'][$lang['id']]['id'];?>]" value="<?=htmlspecialchars($category['category'][$lang['id']]['name']);?>" type="text" /></div>
                      <?
                          $cnt1++;
                        }
                      ?>
                    </div>
                  </div>
                </div>
                <div class="url"><div class="input-text"><input name="url[<?=$cnt;?>][<?=$category['itemid'];?>]" value="<?=$category['code'];?>" type="text" /></div></div>
                <div class="remove">
                  <input name="remove[<?=$cnt;?>][<?=$category['itemid'];?>]" value="0" type="hidden" />
                  <i class="i" title="Удалить"></i>
                </div>
                <div class="state<?=($category['active'])?'':' disabled';?>">
                  <input name="state[<?=$cnt;?>][<?=$category['itemid'];?>]" value="<?=$category['active'];?>" type="hidden" />
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
        <div class="empty placeholder tr">
          <input name="itemid[<?=$cnt;?>]" value="0" type="hidden" />
          <div class="title">
            <div class="input-text">
              <div class="multiling">
                <div class="multiling-select">
                  <select disabled="disabled">
                    <? foreach($this->view->langlist as $lang) { ?>
                      <option><?=$lang['name'];?></option>
                    <? } ?>
                  </select>
                </div>
                <div class="multiling-item multiling-current"><input name="title[<?=$cnt;?>][1][0]" type="text" /></div>
                <div class="multiling-item"><input name="title[<?=$cnt;?>][2][0]" type="text" /></div>
              </div>
            </div>
          </div>
          <div class="url"><div class="input-text"><input name="url[<?=$cnt;?>][0]" type="text" /></div></div>
          <div class="remove">
            <input name="remove[<?=$cnt;?>][0]" value="0" type="hidden" />
            <i class="i" title="Удалить"></i>
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
        <div class="title">
          <div class="input-text">
            <div class="multiling">
              <div class="multiling-select">
                <select disabled="disabled">
                  <? foreach($this->view->langlist as $lang) { ?>
                    <option><?=$lang['name'];?></option>
                  <? } ?>
                </select>
              </div>
              <div class="multiling-item multiling-current"><input name="title[][1][0]" type="text" /></div>
              <div class="multiling-item"><input name="title[][2][0]" type="text" /></div>
            </div>
          </div>
        </div>
        <div class="url"><div class="input-text"><input name="url[][0]" type="text" /></div></div>
        <div class="remove">
          <input name="remove[][0]" value="0" type="hidden" />
          <i class="i" title="Удалить"></i>
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
