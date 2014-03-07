<form action="/admin/updatebloginner/" method="post">

  <div class="h1">
    <h1><?=$this->registry->currentpage;?></h1>
    <div class="button-small button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['save'];?></button></div></div></div></div>
    <div class="apply button-small-faded button"><div class="bg"><div class="r"><div class="l"><button class="el" type="button">Применить</button></div></div></div></div>
  </div>
  
  <div class="blog-edit form">
    <input name="apply" value="0" type="hidden" />
    <input type="hidden" name="itemid" value="<?=$this->view->bloginner[0]['itemid'];?>"/>
    <input name="redactor_css" value="/css/shopadmin/redactor.css" type="hidden" />
    <input name="redactor_image_upload" value="/file/addupload/" type="hidden" />
    <input name="redactor_image_remove" value="/file/remove/" type="hidden" />
    <input name="redactor_images" value="/file/getuploads/" type="hidden" />
    <input name="redactor_max_width" value="680" type="hidden" />
    <div class="field">
      <div class="label"><label for="blog-title1"><?=$this->view->translate['title'];?></label></div>
      <div class="input-text">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <? foreach($this->view->bloginner as $lang) { ?>
                <option><?=$lang['languagename'];?></option>
              <? } ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->bloginner as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current'?>"><input name="title[<?=$lang['languageid'];?>]" id="blog-title<?=$lang['languageid'];?>" value="<?=$lang['name'];?>" type="text" class="required" /></div>
          <?
              $cnt++;
            }
          ?>
        </div>
      </div>
    </div>
    <div class="field">
      <div class="label"><label for="blog-date"><?=$this->view->translate['date'];?></label></div>
      <div class="input-date"><input name="date" value="<?=$lang['date_start'];?>" id="blog-date" type="text" class="required" /><label for="blog-date" class="i"></label><div class="picker"></div></div>
    </div>
    <div class="field">
      <div class="editor">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <?
                $cnt=0;
                foreach($this->view->bloginner as $lang) {
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
            foreach($this->view->bloginner as $lang) {
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
