<div class="layout-content-bg">
  
  <div class="layout-cols">
    
    <div class="layout-main">

      <div class="h1">
        <h1><?=$this->registry->currentpage;?></h1>
      </div>

      <ul class="contacts">
        <li>
          <h3>E-mail</h3>
          <p><a href="mailto:<?=$this->view->contactdata['email'];?>"><?=$this->view->contactdata['email'];?></a></p>
        </li>
        <? if($this->view->contactdata['address']){?>
        <li>
          <h3><?=$this->registry->translate['address'];?></h3>
          <p><?=$this->view->contactdata['address'];?></p>
        </li>
        <?}
        if($this->view->contactdata['phone']){?>
        <li>
          <h3><?=$this->registry->translate['phone'];?></h3>
          <p><?=$this->view->contactdata['phone'];?></p>
        </li><?}
        if($this->view->contactdata['skype']){?>
        <li class="last">
          <h3>Skype</h3>
          <p><a href="skype:wonder_site?call"><?=$this->view->contactdata['skype'];?></a></p>
        </li>
        <?}?>
      </ul>
	  
      <? if($this->view->contactdata['map'] && !$this->view->contactdata['map_url']){?>
        <script src="https://maps.google.com/maps/api/js?sensor=true&amp;language=ru" type="text/javascript"></script>
        <div class="gmap"><input name="latlng" value="<?=$this->view->location->lat;?>,<?=$this->view->location->lng;?>" type="hidden" /></div>
      <? } elseif($this->view->contactdata['map_url']){?>
      	<div class="map"><img src="<?=$this->view->contactdata['map_url'];?>"/></div>
      <? } ?>

      <div class="feedback">
        <form action="/user/sendfeedback/" method="post">
          <div class="field">
            <div class="label"><label for="feedback-name"><?=$this->registry->translate['name'];?></label></div>
            <? if($_SESSION['User']['id']){?>
            <div class="user"><a><?=$_SESSION['User']['firstName'];?><i class="i"></i></a></div>
            <input name="name" id="feedback-name" type="hidden" value="<?=$_SESSION['User']['firstName'];?>"/>
            <?}else{?>
            <div class="input-text"><input name="name" id="feedback-name" type="text" class="required"/></div>
            <?}?>
          </div>
		
		  <? if($_SESSION['User']['id']){?>
         <input name="email" id="feedback-email" type="hidden" value="<?=$_SESSION['User']['email'];?>"" class="email required" />
          <?}else{?>
          <div class="field">
            <div class="label"><label for="feedback-email">E-mail</label></div>
            <div class="input-text"><input name="email" id="feedback-email" type="text" class="email required" /></div>
          </div>
          <?}?>

          <div class="field">
            <div class="label"><label for="feedback-message"><?=$this->registry->translate['message'];?></label></div>
            <div class="textarea"><textarea name="message" id="feedback-message" rows="" cols="" class="required"></textarea></div>
          </div>
    
          <div class="captcha-field field">
          	<div class="label"><label for="comments-captcha"><?=$this->registry->translate['spamfilter'];?></label></div>
            <div class="input-text input"> 
            <label for="comments-captcha"><img src="/captcha/image.php" alt="" /></label>
            <input name="user_capcha" id="comments-captcha" type="text" class="required" />
            </div>
          </div>
    			  <!--
				  <div class="field">
							  <div class="label"><label for="feedback-captcha">РЎРїР°Рј С„РёР»СЊС‚СЂ:</label></div>
							  <div class="input-text input">
								<input name="capcha" id="feedback-captcha" type="text" class="required" />
								<input name="capcha_answer" value="" type="hidden" />
								<input name="capcha_id" value="" type="hidden" />
								<input name="capcha_url" value="/index/captcha/" type="hidden" />
								<i class="captcha-reload"></i>
							  </div>
							</div>-->
				  
          <div class="submit">
            <div class="button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->registry->translate['send'];?></button></div></div></div></div>
          </div>
        </form>
      </div>

    </div>

    <div class="layout-sidebar">
      <?=$this->view->widgetlist;?>
    </div>
    
  </div>

  <div class="layout-bottom">
    <div class="up"><?=$this->registry->translate['top'];?><i class="i"></i></div>
  </div>

</div>