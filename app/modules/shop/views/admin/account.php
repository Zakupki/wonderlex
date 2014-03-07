<form action="/admin/updateaccount/" method="post">

  <div class="h1">
    <h1><?=$this->view->translate['accountsettings'];?></h1>
    <div class="button-small button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['save'];?></button></div></div></div></div>
  </div>
  
  <div class="account form">
    <input name="remove" value="0" type="hidden" />
    <input name="countries_url" value="/ajax/findcountry/" type="hidden" />
    <input name="cities_url" value="/ajax/findcity/" type="hidden" />
    <div class="language-field field">
      <div class="label"><label for="account-language"><?=$this->view->translate['languageversions'];?></label></div>
      <? foreach($this->view->sitelanguages as $lang) { ?>
        <div class="input-checkbox"><input value="1" name="language[<?=$lang['id'];?>]" id="account-language<?=$lang['id'];?>"<?=($lang['active'])?' checked="checked"':''?> type="checkbox" /><label for="account-language<?=$lang['id'];?>"><?=$lang['languagename'];?></label></div>
      <? } ?>
    </div>
    <div class="default-language-field field">
      <div class="label"><label for="account-default-language"><?=$this->view->translate['mainlanguage'];?></label></div>
      <div class="select">
        <select name="default_language" id="account-default-language">
          <? foreach($this->view->sitelanguages as $lang) { ?>
          	<option value="<?=$lang['id'];?>"<?=($lang['major'])?' selected="selected"':'';?>><?=$lang['languagename'];?></option>
          <? } ?>
        </select>
      </div>
    </div>
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
    <div class="currency-field field">
      <div class="label"><label for="account-currency"><?=$this->view->translate['sitecurrency'];?></label></div>
      <? foreach($this->view->currencies as $currency) { ?>
        <div class="input-checkbox"><input name="currency[<?=$currency['id'];?>]" id="account-currency<?=$currency['id'];?>" value="<?=$currency['id'];?>"<?=($currency['id']==$currency['currencyid'])?' checked="checked"':'';?> type="checkbox" /><label for="account-currency<?=$currency['id'];?>"><?=$currency['code'];?></label></div>
      <? } ?>
    </div>
    <div class="default-currency-field field">
      <div class="label"><label for="account-default-currency"><?=$this->view->translate['defaultcurrency'];?></label></div>
      <div class="select">
        <select name="default_currency" id="account-default-currency">
          <? foreach($this->view->currencies as $currency) { ?>
          	<option value="<?=$currency['id'];?>"<?=($currency['major'])?' selected="selected"':'';?>><?=$currency['code'];?></option>
          <? } ?>
        </select>
      </div>
    </div>

    <div class="country-field field">
      <div class="label"><label for="account-country"><?=$this->view->translate['country'];?></label></div>
      <div class="input-text">
        <label for="account-country" class="placeholder">(<?=$this->view->translate['notselected'];?>)</label>
        <input name="country[title]" id="account-country" value="<?=$this->view->sitedata['countryname'];?>" type="text" />
        <input name="country[id]" value="<?=$this->view->sitedata['countryid'];?>" type="hidden" />
        <label for="account-country" class="arrow"></label>
      </div>
    </div>
    <div class="city-field field"<?=($this->view->sitedata['countryid'])?' style="display: block;"':'';?>>
      <div class="label"><label for="account-city"><?=$this->view->translate['city'];?></label></div>
      <div class="input-text">
        <label for="account-city" class="placeholder">(<?=$this->view->translate['notselected'];?>)</label>
        <input name="city[title]" id="account-city" value="<?=$this->view->sitedata['cityname'];?>" type="text" />
        <input name="city[id]" value="<?=$this->view->sitedata['cityid'];?>" type="hidden" />
        <label for="account-city" class="arrow"></label>
      </div>
    </div>
    <div class="address-field field">
      <div class="label"><label for="account-address1"><?=$this->view->translate['address'];?></label></div>
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
              <div class="multiling-item<?=($cnt)?'':' multiling-current'?>"><input name="address[<?=$lang['id'];?>]" id="account-address<?=$lang['id'];?>" value="<?=$lang['address'];?>" type="text" /></div>
          <?
              $cnt++;
            }
          ?>
        </div>
      </div>
      <div class="input-checkbox"><input name="map" id="account-map" value="1"<?=($this->view->sitedata['map'])?' checked="checked"':'';?> type="checkbox" /><label for="account-map"><?=$this->view->translate['showgmap'];?></label></div>
      <div class="maps">
        <?
          $cnt=0;
          foreach($this->view->sitelanguages as $lang) {
        ?>
            <div class="<?=($cnt)?'':'map-current '?> map input-image">
              <input name="map_uploader[<?=$lang['id'];?>]" value="/file/uploadimage/" type="hidden" />
              <input name="map_cropper[<?=$lang['id'];?>]" value="/file/crop/" type="hidden" />
              <input name="map_size[<?=$lang['id'];?>]" value="7" type="hidden" />
              <input name="map_max_w[<?=$lang['id'];?>]" value="680" type="hidden" />
              <input name="map_id[<?=$lang['id'];?>]" value="" type="hidden" />
              <input name="map_new[<?=$lang['id'];?>]" value="" type="hidden" />
              <input name="map_current[<?=$lang['id'];?>]" value="<?=$lang['map_url'];?>" type="hidden" />
              <input name="map_removed[<?=$lang['id'];?>]" value="0" type="hidden" />
              <div class="<?=($lang['map_url'])?'':'empty ';?>preview">
                <div class="img">
                	<? 
                	if($lang['map_url']){?><img src="<?=$lang['map_url'];?>" alt="" />
                	<?}?>
                </div>
                <div class="remove"></div>
                <div class="loading"></div>
              </div>
              <div class="input-file">
                <div class="button-small button"><div class="bg"><div class="r"><div class="l"><div class="el"><?=$this->view->translate['personalmap'];?><i class="i"></i><input name="map_file[<?=$lang['id'];?>]" id="account-map-file<?=$lang['id'];?>" type="file" /></div></div></div></div></div>
                <div class="note"><?=$this->view->translate['desiredsize'];?>: 680x300</div>
              </div>
            </div>
        <?
            $cnt++;
          }
        ?>
      </div>
    </div>
    <div class="field">
      <div class="label"><label for="account-phone"><?=$this->view->translate['phone'];?></label></div>
      <div class="input-text"><input name="phone" id="account-phone" value="<?=$this->view->sitedata['phone'];?>" type="text" /></div>
    </div>
    <div class="field">
      <div class="label"><label for="account-skype">Skype</label></div>
      <div class="input-text"><input name="skype" id="account-skype" value="<?=$this->view->sitedata['skype'];?>" type="text" /></div>
    </div>
    <div class="field">
      <div class="label"><label for="account-contact-email"><?=$this->view->translate['contactemail'];?></label></div>
      <div class="input-text"><input name="contact_email" id="account-contact-email" value="<?=$this->view->sitedata['email'];?>" type="text" /></div>
    </div>
    <div class="field">
      <div class="label"><label for="account-email">E-mail</label></div>
      <div class="input-text-disabled input-text"><input name="email" id="account-email" value="<?=$_SESSION['User']['email'];?>" disabled="disabled" class="email required" type="text" /></div>
    </div>
    <div class="field">
      <div class="label"><label for="account-password"><?=$this->view->translate['currentpassword'];?></label></div>
      <div class="input-password input-text"><input name="password" id="account-password" type="password" autocomplete="off" /><label for="account-password" class="toggle"><span class="show"><?=$this->view->translate['showpassword'];?></span><span class="hide"><?=$this->view->translate['hidepassword'];?></span></label></div>
    </div>
	<? if($_GET['newpass']==1){?>
	<div class="popup-src" id="password-alert">Ваш пароль изменен.<br />Письмо с новым паролем отправлено на ваш E-mail.</div>
    <?}elseif($_GET['newpass']==2){?>
    <div class="popup-src" id="password-alert">Пароль не изменен.<br />Вы ввели не правильный старый пароль или не правильно ввели новый повторно.</div>	
    <?}?>
    <div class="field">
      <div class="label"><label for="account-new-password"><?=$this->view->translate['newpassword'];?></label></div>
      <div class="input-password input-text"><input name="new_password" id="account-new-password" type="password" autocomplete="off" /><label for="account-new-password" class="toggle"><span class="show"><?=$this->view->translate['showpassword'];?></span><span class="hide"><?=$this->view->translate['hidepassword'];?></span></label></div>
    </div>
    <div class="field">
      <div class="label"><label for="account-repeat-new-password"><?=$this->view->translate['repeatnewpassword'];?></label></div>
      <div class="input-password input-text"><input name="repeatnew_password" id="account-repeat-new-password" type="password" autocomplete="off" /><label for="account-new-password" class="toggle"><span class="show"><?=$this->view->translate['showpassword'];?></span><span class="hide"><?=$this->view->translate['hidepassword'];?></span></label></div>
    </div>
    <div class="hr"></div>
    <div class="facebook-field field">
      <div class="label"><label for="account-facebook">Facebook</label></div>
      <div class="input-text"><input name="facebook" id="account-facebook" value="<?=$this->view->sitedata['facebook'];?>" type="text" /><label for="account-facebook" class="i"></label></div>
    </div>
    <div class="twitter-field field">
      <div class="label"><label for="account-twitter">Twitter</label></div>
      <div class="input-text"><input name="twitter" id="account-twitter" value="<?=$this->view->sitedata['twitter'];?>" type="text" /><label for="account-twitter" class="i"></label></div>
    </div>
    <div class="vkontakte-field field">
      <div class="label"><label for="account-vkontakte"><?=$this->view->translate['vk'];?></label></div>
      <div class="input-text"><input name="vkontakte" id="account-vkontakte" value="<?=$this->view->sitedata['vkontakte'];?>" type="text" /><label for="account-vkontakte" class="i"></label></div>
    </div>
    <div class="instagram-field field">
      <div class="label"><label for="account-instagram">Instagram</label></div>
      <div class="input-text"><input name="instagram" id="account-instagram" value="<?=$this->view->sitedata['instagram'];?>" type="text" /><label for="account-instagram" class="i"></label></div>
    </div>
    <div class="hr"></div>

	<?
	//if($_SESSION['Site']['id']==39 || $_SESSION['Site']['id']==100){
	?>
    <div class="socials-field field">
      <div class="label"><?=$this->view->translate['linksoc'];?></div>
      <div class="input-socials">
        <?
        //tools::print_r($this->view->sitedata['socials']);
        foreach($this->view->sitedata['socials'] as $social){?>
       	<?
       	if($_SESSION['Site']['id']!=39 && $social['socialid']==226)
		continue;
       	?>
        <div class="input-socials-li">
	        <? if($social['id']>0){
	          if($social['expired'] && $social['socialid']==255){
	          ?>
	          <div class="disconnect-<?=$social['socialname'];?> disconnect">
	            <a href="http://wonderlex.com/<?=$social['socialname'];?>/connect/?id=<?=$social['id'];?>&url=<?=urlencode($_SERVER['HTTP_HOST']);?>&sescode=<?=$_SESSION['sescode'];?>">
	              <i class="userpic" style="background-image: url(<?=$social['file_name'];?>);"><i class="i"></i></i>
	              <span class="username"><?=$social['name'];?></span>
	              <span class="action" style="color:red;">Обновить</span>
	            </a>
	          </div>
	          <?}else{?>
	          <div class="disconnect-<?=$social['socialname'];?> disconnect">
	            <a href="/<?=$social['socialname'];?>/unlink/?id=<?=$social['id'];?>">
	              <i class="userpic" style="background-image: url(<?=$social['file_name'];?>);"><i class="i"></i></i>
	              <span class="username"><?=$social['name'];?></span>
	              <span class="action">Отключить</span>
	            </a>
	          </div>
	          <?}
	          if($social['expired'] && $social['socialid']==255){?>
	          <div style="color:red; font-size: 10px; line-height: 12px; text-transform: uppercase;">
	           <br>
	           Ваше подключение устарело!
	           <br>Обновите его для дальнейше публикации ваших материалов.
	          </div>
	          <?}else{?>
	          <input name="transmit[<?=$social['id'];?>][id]" value="<?=$social['id'];?>" type="hidden" />
              <div class="input-checkbox"><input<?=($social['works'])?' checked="checked"':'';?> name="transmit[<?=$social['id'];?>][works]" id="account-transmit-<?=$social['socialname'];?>-works" value="1" type="checkbox" /><label for="account-transmit-<?=$social['socialname'];?>-works"><?=$this->view->translate['postworks'];?></label></div>
              <!--<div class="input-checkbox"><input<?=($social['news'])?' checked="checked"':'';?> name="transmit[<?=$social['id'];?>][news]" id="account-transmit-<?=$social['socialname'];?>-news" value="1" type="checkbox" /><label for="account-transmit-<?=$social['socialname'];?>-news">Новости</label></div>-->
              <div class="input-checkbox"><input<?=($social['blog'])?' checked="checked"':'';?> name="transmit[<?=$social['id'];?>][blog]" id="account-transmit-<?=$social['socialname'];?>-blog" value="1" type="checkbox" /><label for="account-transmit-<?=$social['socialname'];?>-blog"><?=$this->view->translate['blog'];?></label></div>
              <div class="last input-checkbox"><input<?=($social['events'])?' checked="checked"':'';?> name="transmit[<?=$social['id'];?>][events]" id="account-transmit-<?=$social['socialname'];?>-events" value="1" type="checkbox" /><label for="account-transmit-<?=$social['socialname'];?>-events"><?=$this->view->translate['events'];?></label></div>
              <?}?>
	        <?}else{?>
	        <div class="connect-<?=$social['socialname'];?> button"><div class="bg"><div class="i"></div><div class="r"><div class="l"><a href="http://wonderlex.com/<?=$social['socialname'];?>/connect?url=<?=urlencode($_SERVER['HTTP_HOST']);?>&sescode=<?=$_SESSION['sescode'];?>" class="el"><?=ucfirst($social['socialname']);?></a></div></div></div></div>
	        <?}?>
        </div>
        <?}?>

      </div>
    </div>
    <?
	//}
	?>


    <div class="hr"></div>
    <div class="notice-field field">
      <div class="input-checkbox"><input name="notice[messages]" id="account-notice-messages" value="1"<?=($this->view->sitedata['messagenotice'])?' checked="checked"':'';?> type="checkbox" /><label for="account-notice-messages"><?=$this->view->translate['notifymes'];?></label></div>
      <div class="input-checkbox"><input name="notice[news]" id="account-notice-news" value="1"<?=($this->view->sitedata['newsnotice'])?' checked="checked"':'';?> type="checkbox" /><label for="account-notice-news"><?=$this->view->translate['notifynews'];?></label></div>
      <!--<div class="last input-checkbox"><input name="notice[comments]" id="account-notice-comments" value="1"<?=($this->view->sitedata['commentnotice'])?' checked="checked"':'';?> type="checkbox" /><label for="account-notice-comments"><?=$this->view->translate['notifymes'];?></label></div>-->
    </div>
    <div class="hr"></div>
    <div class="submit">
      <div class="button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['save'];?></button></div></div></div></div>
    </div>
  </div>

</form>