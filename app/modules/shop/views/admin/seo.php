<form action="/admin/updateseo/" method="post">

  <div class="h1">
    <h1><?=$this->view->translate['seosettings'];?></h1>
    <div class="button-small button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['save'];?></button></div></div></div></div>
  </div>
  
  <div class="account form">
    <input name="remove" value="0" type="hidden" />
    <div class="field">
      <div class="label"><label for="account-title1"><?=$this->view->translate['sitename'];?></label></div>
      <div class="input-text">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <? foreach($this->view->sitelanguages as $lang) { ?>
                <option><?=$lang['languagename'];?></option>
              <? } ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->sitelanguages as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current'?>"><input name="title[<?=$lang['id'];?>]" id="account-title<?=$lang['id'];?>" value="<?=$lang['sitename'];?>" type="text" /></div>
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
              <? foreach($this->view->sitelanguages as $lang) { ?>
                <option><?=$lang['languagename'];?></option>
              <? } ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->sitelanguages as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current'?>"><input name="keywords[<?=$lang['id'];?>]" id="account-keywords<?=$lang['id'];?>" value="<?=$lang['keywords'];?>" type="text" /></div>
          <?
              $cnt++;
            }
          ?>
        </div>
      </div>
    </div>
    <div class="field">
      <div class="label"><label for="account-seo1"><?=$this->view->translate['description'];?></label></div>
      <div class="textarea">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <? foreach($this->view->sitelanguages as $lang) { ?>
                <option><?=$lang['languagename'];?></option>
              <? } ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->sitelanguages as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current'?>"><textarea name="seo[<?=$lang['id'];?>]" id="account-seo<?=$lang['id'];?>" rows="" cols=""><?=$lang['description'];?></textarea></div>
          <?
              $cnt++;
            }
          ?>
        </div>
      </div>
    </div>
    <div class="editor-field field">
      <div class="label"><?=$this->view->translate['mainseo'];?></div>
      <div class="editor">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <?
                $cnt=0;
                foreach($this->view->sitelanguages as $lang) {
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
            foreach($this->view->sitelanguages as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current';?>"><textarea name="mainseo[<?=$lang['id'];?>]" rows="" cols=""><?=$lang['mainseo'];?></textarea></div>
          <?
              $cnt++;
            }
          ?>
        </div>
      </div>
    </div>
    <div class="editor-field field">
      <div class="label"><?=$this->view->translate['secondseo'];?></div>
      <div class="editor">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <?
                $cnt=0;
                foreach($this->view->sitelanguages as $lang) {
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
            foreach($this->view->sitelanguages as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current';?>"><textarea name="secondseo[<?=$lang['id'];?>]" rows="" cols=""><?=$lang['secondseo'];?></textarea></div>
          <?
              $cnt++;
            }
          ?>
        </div>
      </div>
    </div>
    <div class="hr"></div>
    <div class="field">
      <div class="label"><label for="account-productalt1"><?=$this->view->translate['productalt'];?></label></div>
      <div class="input-text">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <? foreach($this->view->sitelanguages as $lang) { ?>
                <option><?=$lang['languagename'];?></option>
              <? } ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->sitelanguages as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current'?>"><input name="productalt1[<?=$lang['id'];?>]" id="account-productalt1<?=$lang['id'];?>" value="<?=$lang['productalt1'];?>" type="text" /></div>
          <?
              $cnt++;
            }
          ?>
        </div>
      </div>
      <?=$this->view->translate['title'];?>
      <div class="input-text">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <? foreach($this->view->sitelanguages as $lang) { ?>
                <option><?=$lang['languagename'];?></option>
              <? } ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->sitelanguages as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current'?>"><input name="productalt2[<?=$lang['id'];?>]" id="account-productalt2<?=$lang['id'];?>" value="<?=$lang['productalt2'];?>" type="text" /></div>
          <?
              $cnt++;
            }
          ?>
        </div>
      </div>
    </div>
    <div class="field">
      <div class="label"><label for="account-productalt1"><?=$this->view->translate['producttitle'];?></label></div>
      <div class="input-text">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <? foreach($this->view->sitelanguages as $lang) { ?>
                <option><?=$lang['languagename'];?></option>
              <? } ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->sitelanguages as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current'?>"><input name="producttitle1[<?=$lang['id'];?>]" id="account-producttitle1<?=$lang['id'];?>" value="<?=$lang['producttitle1'];?>" type="text" /></div>
          <?
              $cnt++;
            }
          ?>
        </div>
      </div>
      <?=$this->view->translate['title'];?>
      <div class="input-text">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <? foreach($this->view->sitelanguages as $lang) { ?>
                <option><?=$lang['languagename'];?></option>
              <? } ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->sitelanguages as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current'?>"><input name="producttitle2[<?=$lang['id'];?>]" id="account-producttitle2<?=$lang['id'];?>" value="<?=$lang['producttitle2'];?>" type="text" /></div>
          <?
              $cnt++;
            }
          ?>
        </div>
      </div>
    </div>
    <div class="hr"></div>
    <div class="field">
      <div class="label"><label for="account-seo1">PostalAddress</label></div>
      <div class="textarea">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <? foreach($this->view->sitelanguages as $lang) { ?>
                <option><?=$lang['languagename'];?></option>
              <? } ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->sitelanguages as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current'?>"><textarea name="postaladdress[<?=$lang['id'];?>]" id="account-postaladdress<?=$lang['id'];?>" rows="" cols=""><?=$lang['postaladdress'];?></textarea></div>
          <?
              $cnt++;
            }
          ?>
        </div>
      </div>
    </div>
    <div class="field">
      <div class="label"><label for="account-robots">robots.txt</label></div>
      <div class="textarea">
             <div><textarea name="robots" id="account-robots" rows="" cols=""><?=$this->view->sitelanguages[0]['robots'];?></textarea></div>
      </div>
    </div>
    <div class="field">
      <div class="label"><label for="account-sitemap">sitemap.xml</label></div>
      <div class="textarea">
             <div><textarea name="sitemap" id="account-sitemap" rows="" cols=""><?=$this->view->sitelanguages[0]['sitemap'];?></textarea></div>
      </div>
    </div>
    <div class="field">
      <div class="label"><label for="account-ror">ror.xml</label></div>
      <div class="textarea">
             <div><textarea name="ror" id="account-ror" rows="" cols=""><?=$this->view->sitelanguages[0]['ror'];?></textarea></div>
      </div>
    </div>
    <div class="field">
      <div class="label"><label for="account-metrics">Код перед &#60;/body&#62;</label></div>
      <div class="textarea">
             <div><textarea name="metrics" id="account-metrics" rows="" cols=""><?=$this->view->sitelanguages[0]['metrics'];?></textarea></div>
      </div>
    </div>
    <div class="hr"></div>
    <div class="submit">
      <div class="button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['save'];?></button></div></div></div></div>
    </div>
  </div>

</form>