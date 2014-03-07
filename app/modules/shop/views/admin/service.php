<form action="/admin/updateserviceinner/" method="post">

  <div class="h1">
    <h1><?=$this->registry->currentpage;?></h1>
    <div class="button-small button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['save'];?></button></div></div></div></div>
    <div class="apply button-small-faded button"><div class="bg"><div class="r"><div class="l"><button class="el" type="button"><?=$this->view->translate['apply'];?></button></div></div></div></div>
  </div>
  
  <div class="service-edit form">
    <input name="apply" value="0" type="hidden" />
    <input name="itemid" value="<?=$this->view->servicedata[0]['itemid'];?>" type="hidden" />
    <input name="redactor_css" value="/css/shopadmin/redactor.css" type="hidden" />
    <input name="redactor_image_upload" value="/file/addupload/" type="hidden" />
    <input name="redactor_image_remove" value="/file/remove/" type="hidden" />
    <input name="redactor_images" value="/file/getuploads/" type="hidden" />
    <input name="redactor_max_width" value="680" type="hidden" />
    <input name="redactor_buttons" value="bold,formatting,link,fullscreen,html" type="hidden" />
    <div class="field">
      <div class="label"><label for="service-title1"><?=$this->view->translate['title'];?></label></div>
      <div class="input-text">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <? foreach($this->view->servicedata as $lang) { ?>
                <option><?=$lang['languagename'];?></option>
              <? } ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->servicedata as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current'?>"><input name="title[<?=$lang['languageid'];?>]" id="service-title<?=$lang['languageid'];?>" type="text" value="<?=htmlspecialchars($lang['name']);?>" class="required" /></div>
          <?
              $cnt++;
            }
          ?>
        </div>
      </div>
    </div>
    <div class="field">
      <div class="label"><label for="service-link"><?=$this->view->translate['workslink'];?></label></div>
      <div class="input-text"><input name="link" id="service-link" value="<?=$this->view->servicedata[0]['link'];?>" type="text" /></div>
    </div>
    <div class="image-field field">
      <div class="label"><?=$this->view->translate['image'];?></div>
      <div class="input-image">
        <input name="image_uploader" value="/file/uploadimage/" type="hidden" />
        <input name="image_cropper" value="/file/crop/" type="hidden" />
        <input name="image_size" value="6" type="hidden" />
        <input name="image_ratio" value="220/170" type="hidden" />
        <input name="image_min_w" value="220" type="hidden" />
        <input name="image_min_h" value="170" type="hidden" />
        <input name="image_new" value="" type="hidden" />
        <input name="image_current" value="<?=$this->view->servicedata[0]['url'];?>" type="hidden" />
        <input name="image_removed" value="" type="hidden" />
        <? if ($this->view->servicedata[0]['url']) { ?>
            <div class="preview">
              <div class="img"><img src="<?=$this->view->servicedata[0]['url'];?>" alt="" /></div>
              <div class="remove"></div>
              <div class="loading"></div>
            </div>
        <? } else { ?>
            <div class="empty preview">
              <div class="img"></div>
              <div class="remove"></div>
              <div class="loading"></div>
            </div>
        <? } ?>
        <div class="input-file">
          <div class="button-small button"><div class="bg"><div class="r"><div class="l"><div class="el"><?=$this->view->translate['upload'];?><i class="i"></i><input name="image_file" id="service-image-file" type="file" /></div></div></div></div></div>
          <div class="note"><?=$this->view->translate['desiredsize'];?>: 220х170</div>
        </div>
      </div>
    </div>
     <div class="editor-field field">
      <div class="label">Краткое описание</div>
      <div class="editor">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <?
                $cnt=0;
                foreach($this->view->servicedata as $lang) {
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
            foreach($this->view->servicedata as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current';?>"><textarea name="preview_text[<?=$lang['languageid'];?>]" rows="" cols=""><?=$lang['preview_text'];?></textarea></div>
          <?
              $cnt++;
            }
          ?>
        </div>
      </div>
    </div>
    <div class="editor-field field">
      <div class="label">Детальное описание</div>
      <div class="editor">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <?
                $cnt=0;
                foreach($this->view->servicedata as $lang) {
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
            foreach($this->view->servicedata as $lang) {
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
              <? foreach($this->view->servicedata as $lang) { ?>
                <option><?=$lang['languagename'];?></option>
              <? } ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->servicedata as $lang) {
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
              <? foreach($this->view->servicedata as $lang) { ?>
                <option><?=$lang['languagename'];?></option>
              <? } ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->servicedata as $lang) {
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
              <? foreach($this->view->servicedata as $lang) { ?>
                <option><?=$lang['languagename'];?></option>
              <? } ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->servicedata as $lang) {
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
      <div class="apply button-faded button"><div class="bg"><div class="r"><div class="l"><button class="el" type="button"><?=$this->view->translate['apply'];?></button></div></div></div></div>
    </div>
  </div>

</form>
