<form action="/admin/updateabout/" method="post">

  <div class="h1">
    <h1><?=$this->view->translate['useragreement'];?></h1>
    <div class="button-small button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['save'];?></button></div></div></div></div>
  </div>
  
  <div class="agreement form">
    <input name="redactor_css" value="/css/shopadmin/redactor.css" type="hidden" />
    <input name="redactor_image_upload" value="/file/addupload/" type="hidden" />
    <input name="redactor_image_remove" value="/file/remove/" type="hidden" />
    <input name="redactor_images" value="/file/getuploads/" type="hidden" />
    <input name="redactor_max_width" value="680" type="hidden" />
    <div class="field">
      <div class="editor">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <?
                $cnt=0;
                foreach($this->view->agreement as $lang) {
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
            foreach($this->view->agreement as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current';?>"><textarea name="content[<?=$lang['languageid'];?>]" rows="" cols=""><?=$lang['agreement'];?></textarea></div>
          <?
              $cnt++;
            }
          ?>
        </div>
      </div>
    </div>
    <div class="submit">
      <div class="button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['save'];?></button></div></div></div></div>
    </div>
  </div>

</form>
