<form action="/admin/updatebanner/" method="post">

  <div class="h1">
    <h1><?=$this->view->translate['bannersettings'];?></h1>
    <div class="button-small button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['save'];?></button></div></div></div></div>
  </div>
  
  <div class="bn form">
    <?
      if ($this->view->bannerdata['url']) {
        $banner=pathinfo($this->view->bannerdata['url']);
        if (strtolower($banner['extension'])=='swf') {
          $bannersize=getimagesize($_SERVER['DOCUMENT_ROOT'].$this->view->bannerdata['url']);
    ?>
          <div class="image" style="background-color: #<?=$this->view->bannerdata['color'];?>;">
          <object width="<?=$bannersize[0];?>" height="<?=$bannersize[1];?>" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">
            <param name="movie" value="/swf/test.swf" />
              <param name="wmode" value="opaque" />
              <!--[if !IE]>-->
              <object data="<?=$this->view->bannerdata['url'];?>" width="<?=$bannersize[0];?>" height="<?=$bannersize[1];?>" wmode="opaque" type="application/x-shockwave-flash"></object>
              <!--<![endif]-->
            </object>
          </div>
    <?
        } else {
    ?>
          <div class="image" style="background-color: #<?=$this->view->bannerdata['color'];?>;"><a href="#" target="_blank"><img src="<?=$this->view->bannerdata['url'];?>" alt="" /></a></div>
    <?
        }
      } else {
    ?>
        <div class="na image"></div>
    <?
      }
    ?>
    <div class="upload-field field">
      <input name="image_uploader" value="/file/uploadimage/" type="hidden" />
      <input name="image_cropper" value="/file/crop/" type="hidden" />
      <input name="image_id" value="<?=$this->view->bannerdata['id'];?>" type="hidden" />
      <input name="image_current" value="<?=$this->view->bannerdata['url'];?>" type="hidden" />
      <input name="image_new" type="hidden" />
      <div class="label"><label for="bn-image-file"><?=$this->view->translate['banner'];?></label></div>
      <div class="input-file">
        <div class="button-small button"><div class="bg"><div class="r"><div class="l"><div class="el"><?=$this->view->translate['upload'];?><i class="i"></i><input name="image_file" id="bn-image-file" type="file" /></div></div></div></div></div>
        <div class="note"><?=$this->view->translate['desiredformats'];?>: png, jpg, swf</div>
      </div>
    </div>
    <div class="field">
      <div class="label"><label for="bn-url"><?=$this->view->translate['link'];?></label></div>
      <div class="input-text"><input value="<?=$this->view->bannerdata['link'];?>" name="url" id="bn-url" type="text" /></div>
    </div>
    <div class="field">
      <div class="label"><label for="bn-color"><?=$this->view->translate['backgrcolor'];?></label></div>
      <div class="input-color"><input name="color" id="bn-color" value="#<?=$this->view->bannerdata['color'];?>" type="text" /><label class="sample" style="background: #<?=$this->view->bannerdata['color'];?>;"></label><div class="picker"></div></div>
    </div>
    <div class="hr"></div>
    <div class="display-field field">
      <div class="input-checkbox"><input name="active" id="bn-display" value="1" type="checkbox"<?=($this->view->bannerdata['active'])?' checked="checked"':''?>/><label for="bn-display"><?=$this->view->translate['display'];?></label></div>
    </div>
    <div class="hr"></div>
    <div class="submit">
      <div class="button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['save'];?></button></div></div></div></div>
    </div>
  </div>

</form>
