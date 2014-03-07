<form action="/admin/updateevent/" method="post">

  <div class="h1">
    <h1><?=$this->registry->currentpage;?></h1>
    <div class="button-small button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['save'];?></button></div></div></div></div>
    <div class="apply button-small-faded button"><div class="bg"><div class="r"><div class="l"><button class="el" type="button">Применить</button></div></div></div></div>
  </div>
  
  <div class="event-edit form">
    <input name="apply" value="0" type="hidden" />
    <input name="itemid" type="hidden" value="<?=$this->view->eventdata[0]['itemid'];?>"/>
    <input name="redactor_css" value="/css/shopadmin/redactor.css" type="hidden" />
    <input name="redactor_image_upload" value="/file/addupload/" type="hidden" />
    <input name="redactor_image_remove" value="/file/remove/" type="hidden" />
    <input name="redactor_images" value="/file/getuploads/" type="hidden" />
    <input name="redactor_max_width" value="680" type="hidden" />
    <div class="field">
      <div class="label"><label for="event-title1"><?=$this->view->translate['title'];?></label></div>
      <div class="input-text">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <? foreach($this->view->eventdata as $lang) { ?>
                <option><?=$lang['languagename'];?></option>
              <? } ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->eventdata as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current'?>"><input name="title[<?=$lang['languageid'];?>]" id="event-title<?=$lang['languageid'];?>" value="<?=$lang['name'];?>" type="text" class="required" /></div>
          <?
              $cnt++;
            }
          ?>
        </div>
      </div>
    </div>
    <div class="field">
      <div class="label"><label for="event-date"><?=$this->view->translate['date'];?></label></div>
      <div class="input-date"><input name="date" value="<?=$lang['date_start'];?>" id="event-date" type="text" class="required" /><label for="event-date" class="i"></label><div class="picker"></div></div>
    </div>
    <div class="field">
      <div class="editor">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <?
                $cnt=0;
                foreach($this->view->eventdata as $lang) {
              ?>
                  <option<?=($cnt)?'':' class="act"';?>><?=$lang['languagename'];?></option>
              <?
                  $cnt++;
                }
              ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->eventdata as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current';?>"><textarea name="content[<?=$lang['languageid'];?>]" rows="" cols=""><?=$lang['detail_text'];?></textarea></div>
          <?
              $cnt++;
            }
          ?>
        </div>
      </div>
    </div>
    <div class="hr"></div>
    <div class="field">
      <div class="label"><label for="account-title1"><?=$this->view->translate['sitename'];?></label></div>
      <div class="input-text">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <? foreach($this->view->eventdata as $lang) { ?>
                <option><?=$lang['languagename'];?></option>
              <? } ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->eventdata as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current'?>"><input name="seotitle[<?=$lang['languageid'];?>]" id="account-seotitle<?=$lang['id'];?>" value="<?=$lang['seotitle'];?>" type="text" /></div>
          <?
              $cnt++;
            }
          ?>
        </div>
      </div>
    </div>
    <div class="field">
      <div class="label"><label for="account-keywords1"><?=$this->view->translate['keywords'];?></label></div>
      <div class="input-text">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <? foreach($this->view->eventdata as $lang) { ?>
                <option><?=$lang['languagename'];?></option>
              <? } ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->eventdata as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current'?>"><input name="seokeywords[<?=$lang['languageid'];?>]" id="account-seokeywords<?=$lang['id'];?>" value="<?=$lang['seokeywords'];?>" type="text" /></div>
          <?
              $cnt++;
            }
          ?>
        </div>
      </div>
    </div>
    <div class="field">
      <div class="label"><label for="account-seodescription"><?=$this->view->translate['description'];?></label></div>
      <div class="textarea">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <? foreach($this->view->eventdata as $lang) { ?>
                <option><?=$lang['languagename'];?></option>
              <? } ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->eventdata as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current'?>"><textarea name="seodescription[<?=$lang['languageid'];?>]" id="account-seodescription<?=$lang['id'];?>" rows="" cols=""><?=$lang['seodescription'];?></textarea></div>
          <?
              $cnt++;
            }
          ?>
        </div>
      </div>
    </div>
    <div class="submit">
      <div class="button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['save'];?></button></div></div></div></div>
      <div class="apply button-faded button"><div class="bg"><div class="r"><div class="l"><button class="el" type="button">Применить</button></div></div></div></div>
    </div>
  </div>

</form>
