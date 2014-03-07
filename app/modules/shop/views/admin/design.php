<form action="/admin/updatedesign/" method="post">

  <div class="h1">
    <h1><?=$this->view->translate['designopts'];?></h1>
    <div class="button-small button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['save'];?></button></div></div></div></div>
  </div>
  
  <div class="design form">

    <div class="image-field field">
      <div class="label"><?=$this->view->translate['logo'];?></div>
      <div class="input-image">
        <input name="logo_uploader" value="/file/uploadlogo/" type="hidden" />
        <input name="logo_max_w" value="220" type="hidden" />
        <input name="logo_max_h" value="70" type="hidden" />
        <input name="logo_id" value="<?=$this->view->sitecolor['logoid'];?>" type="hidden" />
        <input name="logo_new" value="" type="hidden" />
        <input name="logo_current" value="<?=$this->view->sitecolor['logo'];?>" type="hidden" />
        <div class="preview">
          <div class="img"><img src="<?=$this->view->sitecolor['logo'];?>" alt="" /></div>
          <div class="loading"></div>
        </div>
        <div class="input-file">
          <div class="button-small button"><div class="bg"><div class="r"><div class="l"><div class="el"><?=$this->view->translate['upload'];?><i class="i"></i><input name="logo_file" id="design-logo-file" type="file" /></div></div></div></div></div>
          <div class="note"><?=$this->view->translate['desiredsize'];?>: 220х70</div>
        </div>
      </div>
    </div>

    <div class="hr"></div>

    <div class="image-field field">
      <div class="label">Водяной знак</div>
      <div class="input-image">
        <input name="watermark_uploader" value="/file/uploadlogo/" type="hidden" />
        <input name="watermark_max_w" value="200" type="hidden" />
        <input name="watermark_max_h" value="200" type="hidden" />
        <input name="watermark_id" value="<?=$this->view->sitecolor['watermarkid'];?>" type="hidden" />
        <input name="watermark_new" value="" type="hidden" />
        <input name="watermark_current" value="<?=$this->view->sitecolor['watermark'];?>" type="hidden" />
        <div class="preview">
          <div class="img"><img src="<?=$this->view->sitecolor['watermark'];?>" alt="" /></div>
          <div class="loading"></div>
        </div>
        <div class="input-file">
          <div class="button-small button"><div class="bg"><div class="r"><div class="l"><div class="el"><?=$this->view->translate['upload'];?><i class="i"></i><input name="watermark_file" id="design-watermark-file" type="file" /></div></div></div></div></div>
          <div class="note">Формат PNG-24. Максимальный размер: 200х200</div>
        </div>
      </div>
    </div>

    <div class="hr"></div>

    <div class="header-field images-field field">
      <div class="label"><?=$this->view->translate['headebackground'];?></div>
      <div class="input-images">
        <input name="header_uploader" value="/file/uploadimage/" type="hidden" />
        <input name="header_cropper" value="/file/crop/" type="hidden" />
        <div class="list">
          <div class="color li">
            <label for="design-header0" style="background-color: #<?=$this->view->sitecolor['maincolor'];?>;"<?=($this->view->sitecolor['headercolor'])?' class="checked"':'';?>><?=$this->view->translate['onlycolor'];?><i class="i"></i></label>
            <i class="remove"></i>
            <input name="header" id="design-header0" value="0" type="radio"<?=($this->view->sitecolor['headercolor'])?' checked="checked"':'';?> />
            <input name="header_id[0]" value="0" type="hidden" />
            <input name="header_src[0]" value="" type="hidden" />
            <input name="header_tn[0]" value="" type="hidden" />
            <input name="header_preview[0]" value="" type="hidden" />
            <input name="header_preview_new[0]" value="" type="hidden" />
            <input name="header_removed[0]" value="0" type="hidden" />
          </div>
          <?
            $cnt=1;
			$imgidArr=array();
			foreach($this->view->sitedesign as $image) {
			if($image['backgroundid']>0 && !in_array($image['backgroundid'],$imgidArr))
			$imgidArr[$image['backgroundid']]=$image['backgroundid'];
			else
			continue;	
              if ($image['major']) $major_preview = $image['url'];
          ?>
              <div class="li">
                <label for="design-header<?=$cnt;?>" style="background-color: #<?=$this->view->sitecolor['maincolor'];?>; background-image: url(<?=$image['url'];?>);"<?=($image['major'])?' class="checked"':'';?>><i class="i"></i></label>
                <i class="remove"></i>
                <input name="header" id="design-header<?=$cnt;?>" value="<?=$cnt;?>" type="radio"<?=($image['major'])?' checked="checked"':'';?> />
                <input name="header_id[<?=$cnt;?>]" value="<?=$image['backgroundid'];?>" type="hidden" />
                <input name="header_src[<?=$cnt;?>]" value="<?=$image['url'];?>" type="hidden" />
                <input name="header_tn[<?=$cnt;?>]" value="<?=$image['url'];?>" type="hidden" />
                <input name="header_preview[<?=$cnt;?>]" value="<?=$image['url'];?>" type="hidden" />
                <input name="header_preview_new[<?=$cnt;?>]" value="" type="hidden" />
                <input name="header_removed[<?=$cnt;?>]" value="0" type="hidden" />
              </div>
          <?
              $cnt++;
            }
          ?>
        </div>
        <div class="image">
          <div class="preview">
            <div class="bg" style="background-color: #<?=$this->view->sitecolor['maincolor'];?>;<?=($major_preview)?' background-image: url('.$major_preview.');':'';?>"></div>
            <div class="edit"></div>
            <div class="loading"></div>
          </div>
          <div class="input-file">
            <div class="button-small button"><div class="bg"><div class="r"><div class="l"><div class="el"><?=$this->view->translate['upload'];?><i class="i"></i><input name="header_file" id="design-header-file" type="file" /></div></div></div></div></div>
          </div>
        </div>
        <div class="tpl li">
          <label for="design-header"><i class="i"></i></label>
          <i class="remove"></i>
          <input name="header" id="design-header" value="" type="radio" />
          <input name="header_id[]" value="" type="hidden" />
          <input name="header_src[]" value="" type="hidden" />
          <input name="header_tn[]" value="" type="hidden" />
          <input name="header_preview[]" value="" type="hidden" />
          <input name="header_preview_new[]" value="" type="hidden" />
          <input name="header_removed[]" value="" type="hidden" />
        </div>
        <div class="trash"></div>
      </div>
    </div>

    <div class="hr"></div>

    <div class="fieldset">
      <div class="field">
        <div class="label"><label for="design-main-color"><?=$this->view->translate['maincolor'];?></label></div>
        <div class="input-color"><input name="main_color" id="design-main-color" value="#<?=$this->view->sitecolor['maincolor'];?>" type="text" /><label for="design-main-color" class="sample" style="background: #<?=$this->view->sitecolor['maincolor'];?>;"></label><div class="picker"></div></div>
      </div>
      <div class="field">
        <div class="label"><label for="design-link-color"><?=$this->view->translate['linkcolor'];?></label></div>
        <div class="input-color"><input name="link_color" id="design-link-color" value="#<?=$this->view->sitecolor['linkcolor'];?>" type="text" /><label for="design-link-color" class="sample" style="background: #<?=$this->view->sitecolor['linkcolor'];?>;"></label><div class="picker"></div></div>
      </div>
      <div class="field">
        <div class="label"><label for="design-header-color"><?=$this->view->translate['htextcolor'];?></label></div>
        <div class="input-color"><input name="headcolor" id="design-header-color" value="#<?=$this->view->sitecolor['headcolor'];?>" type="text" /><label for="design-header-color" class="sample" style="background: #<?=$this->view->sitecolor['headcolor'];?>;"></label><div class="picker"></div></div>
      </div>
      <div class="field">
        <div class="label"><label for="design-main-bg"><?=$this->view->translate['mainbg'];?></label></div>
        <div class="input-color"><input name="bg_color" id="design-main-bg" value="#<?=$this->view->sitecolor['bgcolor'];?>" type="text" /><label for="design-main-bg" class="sample" style="background: #<?=$this->view->sitecolor['bgcolor'];?>;"></label><div class="picker"></div></div>
      </div>
      <div class="field">
        <div class="label"><label for="design-event-bg"><?=$this->view->translate['eventcolor'];?></label></div>
        <div class="input-color"><input name="eventscolor" id="design-event-bg" value="#<?=$this->view->sitecolor['eventscolor'];?>" type="text" /><label for="design-event-bg" class="sample" style="background: #<?=$this->view->sitecolor['eventscolor'];?>;"></label><div class="picker"></div></div>
      </div>
    </div>

    <div class="hr"></div>

    <div class="edges-field field">
      <div class="input-checkbox"><input name="edges" id="design-edges" value="1" type="checkbox" <?=($this->view->sitecolor['edges'])?'checked="checked"':'';?> /><label for="design-edges"><?=$this->view->translate['display'];?> <?=$this->view->translate['wavedesign'];?></label></div>
    </div>

    <div class="hr"></div>

    <div class="catalog-field field">
      <div class="label"><label for="design-catalog">Каталог на главной в:</label></div>
      <div class="select">
        <select name="mainrows" id="design-catalog">
          <? for($i=1;$i<=4;$i++) { ?>
            <option value="<?=$i;?>"<?=($i==$this->view->sitecolor['mainrows'])?' selected="selected"':'';?>><?=$i;?> ряд<?=($i>1)?'а':''?></option>
          <? } ?>
        </select>
      </div>
    </div>

    <div class="hr"></div>

    <div class="submit">
      <div class="button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['save'];?></button></div></div></div></div>
    </div>

  </div>

</form>
