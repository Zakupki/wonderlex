<form action="/admin/updateauthorinner/" method="post">

  <div class="h1">
    <h1><?=$this->registry->currentpage;?></h1>
    <div class="button-small button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['save'];?></button></div></div></div></div>
    <div class="apply button-small-faded button"><div class="bg"><div class="r"><div class="l"><button class="el" type="button">Применить</button></div></div></div></div>
  </div>
  
  <div class="author-edit form">
    <input name="apply" value="0" type="hidden" />
    <input name="itemid" value="<?=$this->view->authordata[0]['itemid'];?>" type="hidden" />
    <input name="redactor_css" value="/css/shopadmin/redactor.css" type="hidden" />
    <input name="redactor_image_upload" value="/file/addupload/" type="hidden" />
    <input name="redactor_image_remove" value="/file/remove/" type="hidden" />
    <input name="redactor_images" value="/file/getuploads/" type="hidden" />
    <input name="redactor_max_width" value="680" type="hidden" />
    <input name="redactor_buttons" value="bold,formatting,link,fullscreen,html" type="hidden" />
    <div class="field">
      <div class="label"><label for="author-name1"><?=$this->view->translate['name'];?></label></div>
      <div class="input-text">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <? foreach($this->view->authordata as $lang) { ?>
                <option><?=$lang['languagename'];?></option>
              <? } ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->authordata as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current'?>"><input name="name[<?=$lang['languageid'];?>]" id="author-name<?=$lang['languageid'];?>" value="<?=htmlspecialchars($lang['name']);?>" type="text" class="required" /></div>
          <?
              $cnt++;
            }
          ?>
        </div>
      </div>
    </div>
    <div class="hr"></div>
    <div class="facebook-field field">
      <div class="label"><label for="author-facebook">Facebook</label></div>
      <div class="input-text"><input name="facebook" id="author-facebook" value="<?=$this->view->authordata[0]['facebook'];?>" type="text" /><label for="author-facebook" class="i"></label></div>
    </div>
    <div class="twitter-field field">
      <div class="label"><label for="author-twitter">Twitter</label></div>
      <div class="input-text"><input name="twitter" id="author-twitter" value="<?=$this->view->authordata[0]['twitter'];?>" type="text" /><label for="author-twitter" class="i"></label></div>
    </div>
    <div class="vkontakte-field field">
      <div class="label"><label for="author-vkontakte"><?=$this->view->translate['vk'];?></label></div>
      <div class="input-text"><input name="vkontakte" id="author-vkontakte" value="<?=$this->view->authordata[0]['vkontakte'];?>" type="text" /><label for="author-vkontakte" class="i"></label></div>
    </div>
    <div class="instagram-field field">
      <div class="label"><label for="author-instagram">Instagram</label></div>
      <div class="input-text"><input name="instagram" id="author-instagram" value="<?=$this->view->authordata[0]['instagram'];?>" type="text" /><label for="author-instagram" class="i"></label></div>
    </div>
    <div class="hr"></div>
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
        <input name="image_current" value="<?=$this->view->authordata[0]['url'];?>" type="hidden" />
        <input name="image_removed" value="0" type="hidden" />
        <? if ($this->view->authordata[0]['url']) { ?>
            <div class="preview">
              <div class="img"><img src="<?=$this->view->authordata[0]['url'];?>" alt="" /></div>
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
          <div class="button-small button"><div class="bg"><div class="r"><div class="l"><div class="el"><?=$this->view->translate['upload'];?><i class="i"></i><input name="image_file" id="author-image-file" type="file" /></div></div></div></div></div>
          <div class="note"><?=$this->view->translate['desiredsize'];?>: 220х170</div>
        </div>
      </div>
    </div>
    <div class="hr"></div>
    <div class="field">
      <div class="editor">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <?
                $cnt=0;
                foreach($this->view->authordata as $lang) {
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
            foreach($this->view->authordata as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current';?>"><textarea name="content[<?=$lang['languageid'];?>]" rows="" cols=""><?=$lang['detail_text'];?></textarea></div>
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
