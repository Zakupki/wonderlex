<form action="/admin/updateproduct/" method="post">

  <div class="h1">
    <h1><?=$this->registry->currentpage;?></h1>
    <div class="button-small button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['save'];?></button></div></div></div></div>
    <div class="apply button-small-faded button"><div class="bg"><div class="r"><div class="l"><button class="el" type="button">Применить</button></div></div></div></div>
  </div>
  
  <div class="catalog-edit form">
    <input name="apply" value="0" type="hidden" />
    <input name="itemid" value="<?=$this->view->productinner[0]['itemid'];?>" type="hidden" />
    <input name="redactor_css" value="/css/shopadmin/redactor.css" type="hidden" />
    <input name="redactor_image_upload" value="/file/addupload/" type="hidden" />
    <input name="redactor_image_remove" value="/file/remove/" type="hidden" />
    <input name="redactor_images" value="/file/getuploads/" type="hidden" />
    <input name="redactor_max_width" value="680" type="hidden" />

    <div class="field">
      <div class="label"><label for="catalog-title1"><?=$this->view->translate['title'];?></label></div>
      <div class="input-text">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <? foreach($this->view->productinner as $lang) { ?>
                <option><?=$lang['languagename'];?></option>
              <? } ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->productinner as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current'?>"><input name="title[<?=$lang['languageid'];?>]" id="catalog-title<?=$lang['languageid'];?>" value="<?=$lang['name'];?>" type="text"/></div>
          <?
              $cnt++;
            }
          ?>
        </div>
      </div>
    </div>

    <div class="field">
      <div class="label"><label for="catalog-category"><?=$this->view->translate['categoryname'];?></label></div>
      <div class="select">
        <select name="category" id="catalog-category">
          <option value=""></option>
          <?
            foreach($this->view->category as $category) {
          ?>
              <option<?=($category['itemid']==$this->view->productinner[0]['categoryid'] || $category['itemid']==$_GET['cid'])?' selected="selected"':'';?> value="<?=$category['itemid'];?>"><?=$category['name'];?></option>
          <?
            }
          ?>
        </select>
      </div>
    </div>
    <div class="hr"></div>
    <? if($_SESSION['Site']['sitetypeid']==3){?>
        <div class="field">
            <div class="label"><label for="catalog-arttype"><?=$this->view->translate['arttype'];?></label></div>
                <select name="arttype" id="catalog-arttype">
                    <option value=""></option>
                    <?
                    foreach($this->view->arttype as $arttype) {
                        ?>
                        <option<?=($arttype['id']==$this->view->productinner[0]['arttype_id'])?' selected="selected"':'';?> value="<?=$arttype['id'];?>"><?=$arttype['name'];?></option>
                    <?
                    }
                    ?>
                </select>
        </div>
        <div class="field">
            <div class="label"><label for="catalog-artstyle"><?=$this->view->translate['artgenre'];?></label></div>
                <select<?=($this->view->productinner[0]['arttype_id'] && count($this->view->artstyles)>0)?'':' disabled="disabled"';?> name="artstyle" id="catalog-artstyle">
                    <option value=""></option>
                    <?
                    foreach($this->view->artstyles as $artstyle) {
                        ?>
                        <option<?=($artstyle['id']==$this->view->productinner[0]['artstyle_id'])?' selected="selected"':'';?> value="<?=$artstyle['id'];?>"><?=$artstyle['name'];?></option>
                    <?
                    }
                    ?>
                </select>
        </div>
        <div class="field">
            <div class="label"><label for="catalog-artgenre"><?=$this->view->translate['artstyle'];?></label></div>
                <select<?=($this->view->productinner[0]['artstyle_id'] && count($this->view->artgenres)>0)?'':' disabled="disabled"';?> name="artgenre" id="catalog-artgenre">
                    <option value=""></option>
                    <?
                    foreach($this->view->artgenres as $artgenre) {
                        ?>
                        <option<?=($artgenre['id']==$this->view->productinner[0]['artgenre_id'])?' selected="selected"':'';?> value="<?=$artgenre['id'];?>"><?=$artgenre['name'];?></option>
                    <?
                    }
                    ?>
                </select>
        </div>
    <div class="hr"></div>
    <?}?>
    <? if(count($this->view->authorslist)>0){?>
    <div class="authors-field field">
      <div class="label">Авторы</div>
      <div class="checkboxes">
        <?
        $cnt=1;
        foreach($this->view->authorslist as $author){?>
        <div class="<?=($cnt==count($this->view->authorslist))?'last ':'';?>input-checkbox"><input<?=($author['productid']>0)?' checked="checked"':'';?> name="author[<?=$author['itemid'];?>]" id="catalog-author<?=$author['itemid'];?>" value="1" type="checkbox" /><label for="catalog-author<?=$author['itemid'];?>"><?=$author['name'];?></label></div>
        <?
		$cnt++;
		}?>
        
      </div>
    </div>
    <?}?>

    <div class="hr"></div>

    <div class="field">
      <div class="label"><?=$this->view->translate['ordertype'];?></div>
      <div class="input">
      	<input name="order" id="catalog-order" value="1" type="radio"<?=($this->view->productinner[0]['order']<2)?' checked="checked"':'';?>/>
      	<label for="catalog-order"><?=$this->view->translate['orderpopup'];?></label>
      	<input name="order" id="catalog-order" value="2" type="radio"<?=($this->view->productinner[0]['order']>1)?' checked="checked"':'';?>/>
      	<label for="catalog-order"><?=$this->view->translate['canorder'];?></label>
      </div>
      <!--<div class="input-checkbox">
      	<input name="order" id="catalog-order" value="1" type="checkbox"<?=($this->view->productinner[0]['order'])?' checked="checked"':'';?>/>
      	<label for="catalog-order"><?=$this->view->translate['canorder'];?></label>
      </div>-->
    </div>

    <div class="hr"></div>

    <div class="featured-field image-field field">
      <div class="label">Изображение для главной</div>
      <div class="input-image">
        <input name="image_uploader" value="/file/uploadimage/" type="hidden" />
        <input name="image_cropper" value="/file/crop/" type="hidden" />
        <input name="image_size" value="1" type="hidden" />
        <input name="image_ratio" value="980/400" type="hidden" />
        <input name="image_min_w" value="980" type="hidden" />
        <input name="image_min_h" value="400" type="hidden" />
        <input name="image_new" value="" type="hidden" />
        <input name="image_current" value="<?=$this->view->productinner[0]['banner'];?>" type="hidden" />
        <input name="image_removed" value="0" type="hidden" />
        <? if ($this->view->productinner[0]['banner']) { ?>
            <div class="preview">
              <div class="img"><img src="<?=$this->view->productinner[0]['banner'];?>" alt="" /></div>
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
          <div class="input-checkbox"><input name="featured" id="catalog-featured" value="1" type="checkbox"<?=($this->view->productinner[0]['favourite'])?' checked="checked"':'';?> /><label for="catalog-featured"><?=$this->view->translate['tohomebanner'];?></label></div>
          <div class="button-small button"><div class="bg"><div class="r"><div class="l"><div class="el"><?=$this->view->translate['upload'];?><i class="i"></i><input name="image_file" id="service-image-file" type="file" /></div></div></div></div></div>
          <div class="note"><?=$this->view->translate['minimumsize'];?>: 980x400</div>
        </div>
      </div>
    </div>

    <div class="hr"></div>

    <div class="images-field field">
      <div class="label"><?=$this->view->translate['image'];?></div>
      <div class="input-images">
        <input name="images_uploader" value="/file/uploadimage/" type="hidden" />
        <input name="images_cropper" value="/file/crop/" type="hidden" />
        <input name="images_size" value="5" type="hidden" />
        <input name="images_min_w" value="220" type="hidden" />
        <input name="images_min_h" value="170" type="hidden" />
        <input name="images_preview_size" value="6" type="hidden" />
        <input name="images_preview_ratio" value="220/170" type="hidden" />
        <input name="images_preview_min_w" value="220" type="hidden" />
        <input name="images_preview_min_h" value="170" type="hidden" />
        <div class="list">
          <?
            $cnt=0;
            foreach($this->view->images as $image) {
              if ($image['major']) $major_preview=$image['url2'];
          ?>
                <div class="li">
                  <label for="catalog-images<?=$cnt;?>" style="background-color: #<?=$this->view->sitecolor['maincolor'];?>; background-image: url(<?=$image['url'];?>?<?=time();?>);"<?=($image['major'])?' class="checked"':'';?>><i class="i"></i></label>
                  <i class="remove"></i>
                  <input name="images" id="catalog-images<?=$cnt;?>" value="<?=$cnt;?>" type="radio"<?=($image['major'])?' checked="checked"':'';?> />
                  <input name="images_id[<?=$cnt;?>]" value="<?=$image['id'];?>" type="hidden" />
                  <input name="images_src[<?=$cnt;?>]" value="<?=$image['url3'];?>" type="hidden" />
                  <input name="images_tn[<?=$cnt;?>]" value="<?=$image['url'];?>" type="hidden" />
                  <input name="images_preview[<?=$cnt;?>]" value="<?=$image['url2'];?>" type="hidden" />
                  <input name="images_preview_new[<?=$cnt;?>]" value="" type="hidden" />
                  <input name="images_removed[<?=$cnt;?>]" value="0" type="hidden" />
                </div>
          <?
                $cnt++;
            }
          ?>
        </div>
        <div class="image">
          <? if($major_preview){?>
          <div class="preview">
            <div class="bg" style="background-image: url(<?=$major_preview;?>);"></div>
            <div class="edit"></div>
            <div class="loading"></div>
          </div>
          <?}else{?>
          <div class="empty preview">
            <div class="bg"></div>
            <div class="edit"></div>
            <div class="loading"></div>
          </div>
          <?}?>
          <div class="input-file">
            <div class="button-small button"><div class="bg"><div class="r"><div class="l"><div class="el"><?=$this->view->translate['upload'];?><i class="i"></i><input name="images_file" id="catalog-images-file" type="file" /></div></div></div></div></div>
          </div>
        </div>
        <div class="tpl li">
          <label for="catalog-images"><i class="i"></i></label>
          <i class="remove"></i>
          <input name="images" id="catalog-images" value="" type="radio" />
          <input name="images_id[]" value="" type="hidden" />
          <input name="images_src[]" value="" type="hidden" />
          <input name="images_tn[]" value="" type="hidden" />
          <input name="images_preview[]" value="" type="hidden" />
          <input name="images_preview_new[]" value="" type="hidden" />
          <input name="images_removed[]" value="" type="hidden" />
        </div>
        <div class="trash"></div>
      </div>
    </div>

    <div class="hr"></div>

    <div class="price-field field">
      <div class="label"><label for="catalog-price"><?=$this->view->translate['price'];?></label></div>
      <div class="input-text"><input name="price" value="<?=$this->view->productinner[0]['price'];?>" id="catalog-price" type="text" /></div>
      <div class="note"><label for="catalog-price">USD</label></div>
    </div>

    <div class="hr"></div>

    <div class="editor-field field">
      <div class="label">Описание</div>
      <div class="editor">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <?
                $cnt=0;
                foreach($this->view->productinner as $lang) {
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
            foreach($this->view->productinner as $lang) {
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

    <div class="editor-field field">
      <div class="label">Технические характеристики</div>
      <div class="editor">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <?
                $cnt=0;
                foreach($this->view->productinner as $lang) {
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
            foreach($this->view->productinner as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current';?>"><textarea name="info[<?=$lang['languageid'];?>]" rows="" cols=""><?=$lang['techinfo'];?></textarea></div>
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
              <? foreach($this->view->productinner as $lang) { ?>
                <option><?=$lang['languagename'];?></option>
              <? } ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->productinner as $lang) {
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
              <? foreach($this->view->productinner as $lang) { ?>
                <option><?=$lang['languagename'];?></option>
              <? } ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->productinner as $lang) {
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
              <? foreach($this->view->productinner as $lang) { ?>
                <option><?=$lang['languagename'];?></option>
              <? } ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->productinner as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current'?>"><textarea name="seodescription[<?=$lang['languageid'];?>]" id="account-seodescription<?=$lang['id'];?>" rows="" cols=""><?=$lang['seodescription'];?></textarea></div>
          <?
              $cnt++;
            }
          ?>
        </div>
      </div>
    </div>
    <div class="field">
      <div class="label"><label for="account-seotext"><?=$this->view->translate['seotext'];?></label></div>
      <div class="textarea">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <? foreach($this->view->productinner as $lang) { ?>
                <option><?=$lang['languagename'];?></option>
              <? } ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->productinner as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current'?>"><textarea name="seotext[<?=$lang['languageid'];?>]" id="account-seotext<?=$lang['id'];?>" rows="" cols=""><?=$lang['seotext'];?></textarea></div>
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
