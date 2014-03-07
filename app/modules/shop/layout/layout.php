<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?
  $langar=array(1=>'ru', 2=>'en-us');
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru-RU" xml:lang="ru-RU" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://ogp.me/ns/fb#" class="lang-<?=$langar[$_SESSION['langid']];?><?=($_SESSION['Site']['edges'])?'':' no-edges';?>">
<head>
  <meta http-equiv="Cache-Control" content="Private" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?=strip_tags($this->view->seotitle);?><?=($this->view->page>0)?' стр№'.tools::num2str($this->view->page):'';?></title>
  <meta name="title" content="<?=strip_tags($this->view->seotitle);?><?=($this->view->page>0)?' стр№'.tools::num2str($this->view->page):'';?>" />
  <meta name="keywords" content="<?=strip_tags($this->view->seokeywords);?>" />
  <meta name="description" content="<?=strip_tags($this->view->seodescription);?><?=($this->view->page>0)?' стр№'.tools::num2str($this->view->page):'';?>" />
  <meta property="og:site_name" content="<?=strip_tags($this->view->seotitle);?>"/>
  <meta property="og:title" content="<?=strip_tags($this->view->seotitle);?>" />
  <meta property="og:description" content="<?=strip_tags($this->view->seodescription);?>" />
  <?
    $image='http://'.$_SERVER['HTTP_HOST'].$_SESSION['Site']['logo'];
    if ($this->view->images[0]['url']) {
        $image='http://'.$_SERVER['HTTP_HOST'].$this->view->images[0]['url'];
    }
  ?>
  <meta property="og:image" content="<?=$image;?>" />
  <meta property="og:url" content="http://<?=$_SERVER['HTTP_HOST'];?><?=$_SERVER['REQUEST_URI'];?>" />
  <meta property="og:type" content="website" />
  <meta name="lang" content="<?=$langar[$_SESSION['langid']];?>" />
  <? if($this->view->page>1){?>
  <meta name="robots" content="noindex,follow">
  <?}?>
  <link rel="alternate" hreflang="x-default" href="http://<?=$_SERVER['HTTP_HOST'];?>/">
  <?foreach($this->view->langlist as $lang) {
            if ($lang['id']!=$this->view->curlang && $lang['active']) {
              if($lang['major']==1){?>
              <link rel="alternate" hreflang="<?=$langar[$lang['id']];?>" href="http://<?=$_SERVER['HTTP_HOST'];?>/">
              <?}else{?>
              <link rel="alternate" hreflang="<?=$langar[$lang['id']];?>" href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=$lang['code'];?>/">
              <?}
            }
          }
  ?>
  <meta name="base" content="/" />
  <script src="/js/shop/lang-ru.js" type="text/javascript"></script>
  <script src="/js/shop/lib.js" type="text/javascript"></script>
  <link href="/css/shop/main.css" type="text/css" rel="stylesheet" />
  <link href="/file/usercss/?1_<?=$_SESSION['Site']['date_update'];?>" type="text/css" rel="stylesheet" />
  <script src="/js/shop/main.js" type="text/javascript"></script>
  <link href="/favicon.ico" rel="icon" type="image/x-icon" />
  <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon" />
  <script src="http://vk.com/js/api/share.js" type="text/javascript"></script>
  <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-35997907-1']);
    _gaq.push(['_setDomainName', '<?=$_SERVER['HTTP_HOST'];?>']);
    _gaq.push(['_setAllowLinker', true]);
    _gaq.push(['_trackPageview']);
    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  </script>
</head>
<body>

<div id="fb-root"></div>
<script type="text/javascript">window.fbAsyncInit=function(){FB.init({xfbml:true});};(function(d){var js,id='facebook-jssdk',ref=d.getElementsByTagName('script')[0];if(d.getElementById(id)) return;js=d.createElement('script');js.id=id;js.async=true;js.type='text/javascript';js.src='//connect.facebook.net/en_US/all.js';ref.parentNode.insertBefore(js,ref);}(document));</script>
<script type="text/javascript">!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='//platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','twitter-wjs');</script>

<div class="layout-body">

  <div class="layout-header">
    <?
      $banner=pathinfo($this->view->bannerdata['url']);
      if(strtolower($banner['extension'])=='swf'){
      $bannersize=getimagesize($_SERVER['DOCUMENT_ROOT'].$this->view->bannerdata['url']);
    ?>
      <div class="bn" style="background: #<?=$this->view->bannerdata['color'];?>;">
        <object width="<?=$bannersize[0];?>" height="<?=$bannersize[1];?>" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">
          <param name="movie" value="/swf/test.swf" />
          <param name="wmode" value="opaque" />
          <!--[if !IE]>-->
          <object data="<?=$this->view->bannerdata['url'];?>" width="<?=$bannersize[0];?>" height="<?=$bannersize[1];?>" wmode="opaque" type="application/x-shockwave-flash"></object>
          <!--<![endif]-->
        </object>
      </div>
    <? } else { ?>
      <div class="bn" style="background: #<?=$this->view->bannerdata['color'];?>;">
      	
      	<? if($this->view->bannerdata['link']){?>
      	<a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?><?=$this->view->bannerdata['link'];?>">
      	<?}?>
      		<span><img src="<?=$this->view->bannerdata['url'];?>" alt="" /></span>
      	<? if($this->view->bannerdata['link']){?>
      	</a>
      	<?}?>
      </div>
    <? } ?>
    <table class="nav">
    <tr>
      <td class="logo">

        <div><a title="<?=$this->view->sitedata['name'];?>" href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/"><img src="<?=$_SESSION['Site']['logo'];?>" alt="<?=$this->view->sitedata['name'];?>" /></a></div>

      </td>
      <td>

        <?
          foreach($this->view->langlist as $lang) {
            if ($lang['id']!=$this->view->curlang && $lang['active']) {
              if($lang['major']==1)
			  $langStr.='<li><a href="/">'.$lang['description'].'</a></li>';
			  else
              $langStr.='<li><a href="/'.$lang['code'].'/">'.$lang['description'].'</a></li>';
            }
          }
          if ($langStr) {
        ?>
            <ul class="lang">
              <?=$langStr;?>
            </ul>
        <?
          }
        if(count($this->view->currency)>0){
		  foreach($this->view->currency as $cur) {
            if ($_SESSION['curid']==$cur['id'])
              $defaultCur=$cur['code'];
			
            $curStr.='<li><a href="?curid='.$cur['id'].'">'.$cur['code'].'</a></li>';  
          }
        
        ?>
        <div class="currency">
          <div class="label"><?=$this->view->translate['currency'];?>:&nbsp;</div>
          <div class="jdrop">
            <div class="jdrop-title"><div class="jdrop-caption"><?=$defaultCur;?></div><div class="jdrop-arrow"></div></div>
            <div class="jdrop-list">
              <ul>
                <?=$curStr;?>
              </ul>
            </div>
          </div>
        </div>
        <?}?>
    
<!--
        <div class="search">
          <form action="" method="post">
            <label for="search-q" class="placeholder"><?=$this->view->translate['searchword'];?></label>
            <input name="q" id="search-q" value="<?=$this->view->translate['searchword'];?>" title="<?=$this->view->translate['searchword'];?>" type="text" class="query required" />
            <button type="submit" class="submit-icon"></button>
            <button type="submit" class="submit-button"><?=$this->view->translate['search'];?></button>
          </form>
        </div>
-->
    
        <ul class="networks">
          <? if($_SESSION['Site']['sitetypeid']==3){?>
          <li class="wonderlex-link"><a href="http://wonderlex.com/" target="_blank"><i class="i"></i></a></li>
          <?}?>
          
          <? if(strlen($this->view->sitedata['facebook'])>0){
          $this->view->sitedata['facebook']=str_replace('https://', '',$this->view->sitedata['facebook']);
          $this->view->sitedata['facebook']=str_replace('http://', '',$this->view->sitedata['facebook']);
          $prottype='http://';
          ?>
          <li class="facebook-link"><a href="<?=$prottype;?><?=$this->view->sitedata['facebook'];?>" target="_blank"><i class="i"></i></a></li>
          <?}
          if(strlen($this->view->sitedata['vkontakte'])>0){
              $this->view->sitedata['vkontakte']=str_replace('https://', '',$this->view->sitedata['vkontakte']);
          $this->view->sitedata['vkontakte']=str_replace('http://', '',$this->view->sitedata['vkontakte']);
          $prottype='http://';
          ?>
              <li class="vkontakte-link"><a href="<?=$prottype;?><?=$this->view->sitedata['vkontakte'];?>" target="_blank"><i class="i"></i></a></li>
              <?}
          if(strlen($this->view->sitedata['twitter'])>0){
              $this->view->sitedata['twitter']=str_replace('https://', '',$this->view->sitedata['twitter']);
          $this->view->sitedata['twitter']=str_replace('http://', '',$this->view->sitedata['twitter']);
          $prottype='http://';
          ?>
          <li class="twitter-link"><a href="<?=$prottype;?><?=$this->view->sitedata['twitter'];?>" target="_blank"><i class="i"></i></a></li>
          <?}?>
        </ul>

        <table>
        <tr>
          <td class="m1">
        
            <ul>
              <?
                foreach($this->view->mainmenu as $menu) {
                  if ($this->registry->controller==$menu['code'] || $this->registry->action==$menu['code']){
                    $currentcss=' class="act"';
                  } else {
                    $currentcss='';                
                  }
                  if ($menu['code']=='catalog') {
              ?>
                    <li<?=$currentcss;?>>
                      <div class="jdrop">
                        <div class="jdrop-title"><div class="jdrop-caption"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/<?=$menu['code'];?>/"><?=$menu['name'];?></a></div><div class="jdrop-arrow"></div></div>
                        <div class="jdrop-list">
                          <ul>
                          <?
                            if (is_array($this->view->category)) {
                              $half=ceil(count($this->view->category)/2);
                              $cnt=0;
                              foreach($this->view->category as $category) {
                                if ($cnt==$half) {
                                  echo '</ul><ul>';
                                  $cnt=0;
                                }
                              ?>
                              <li><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/catalog/<?=$category['itemid'];?>/<?=tools::encodestring($category['name']);?>/"><?=$category['name'];?></a></li>
                              <?
                                $cnt++;
                              }
                            }
                          ?>
                          </ul>
                        </div>
                      </div>
                    </li>
              <?
                  } else {
              ?>
                    <li<?=$currentcss;?>><div class="title"><a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/<?=$menu['code'];?>/"><?=$menu['name'];?></a></div></li>
              <?
                  }
                  $cnt++;
                }
              ?>
              <!--<li><div class="title"><a href="/authors/">Авторы</a></div></li>-->
            </ul>
        
          </td>
          <td>
        
            <? if ($this->view->Session->User['id']) { ?>
              <div class="member">
                <? if($this->view->Session->User['id']==$this->view->Session->Site['userid']) { ?>
                  <div class="profile-link"><a href="/admin/account/"><i class="i"></i></a></div>
                <? } else { ?>
                  <div class="profile-link"><span><i class="i"></i></span></div>
                <? } ?>
                <? if($this->view->Session->User['id']==$this->view->Session->Site['userid']) { ?>
                  <div class="admin-link"><a href="/admin/"><i class="i"></i></a></div>
                <? } else { ?>
        <!--               <div class="favorites-link"><a href="/favourites/"><i class="i"></i></a></div> -->
                <? } ?>
                <div class="logout-link"><a href="/user/logout/"><i class="i"></i></a></div>
              </div>
            <? } else { ?>
              <div class="auth-link"><i class="i"></i></div>
            <? } ?>
        
          </td>
        </tr>
        </table>

      </td>
    </tr>
    </table>

    <?=$this->view->teaser;?>

    <div class="layout-header-bot"></div>

  </div>

  <div class="layout-content">
    <?=$this->view->content;?>
  </div>
  <? if($this->registry->controller=='index' && $this->registry->action=='index' && strlen($this->view->mainseo)>0){?>
  <div class="layout-content">
  	<div class="layout-content-bg" style="padding: 16px; color:#FFF; background: #767e95; font-size: 11px; line-height: 14px;">
    <?=$this->view->mainseo;?>
   	</div>
  </div>
  <?}?>
</div>

<div class="layout-footer">

  <?=$this->view->partners;?>  
  
  <div class="footnote">
    <div class="copy">
      <div class="owner">&copy; <?=date('Y');?> <?
      if($_SESSION['Site']['id']!=179){?>
      <a href="/contacts/"><?=$this->view->sitedata['name'];?></a>
      <?}?>
      </div>
      <div class="text"><?=$this->view->translate['rightspreserved'];?></div>
    </div>
    <ul class="links">
      <li><span class="a"><?=$this->view->translate['howtobuy'];?><span class="href">/howtobuy/</span></span></li>
      <li><a href="/agreement/"><?=$this->view->translate['useragreement'];?></a></li>
      <li><a href="/contacts/"><?=$this->view->translate['feedback'];?></a></li>
    </ul>
    <? if(strlen($this->view->postaladdress)>0){?>
    <div class="seo">
    <?=$this->view->postaladdress;?>
    </div>
    <?}?>
    <div class="seo">
      <? if($this->registry->controller=='index' && $this->registry->action=='index'){?>
      <p><?=$this->view->secondseo;?></p>
      <?}?>
    </div> 
  </div>

</div>

<? if ($this->view->Session->User['id']) { ?>

<div id="profile" class="popup-src">
  <div class="profile">
    <form action="/user/profile/" method="post" autocomplete="off">
      <h2><?=$this->view->translate['editpersonal'];?></h2>
      <div class="name-field field">
        <div class="label"><label for="profile-name"><?=$this->view->translate['name'];?></label></div>
        <div class="input-text"><input name="name" id="profile-name" value="Дмитрий Божок" type="text" class="required" autocomplete="yes" /></div>
      </div>
      <div class="email-field field">
        <div class="label"><label for="profile-email">E-mail</label></div>
        <div class="input-text"><input name="email" id="profile-email" value="bozhok@ukr.net" type="text" disabled="disabled" class="email required" autocomplete="yes" /></div>
      </div>
      <div class="password-field field">
        <div class="label"><label for="profile-password"><?=$this->view->translate['currentpassword'];?></label></div>
        <div class="input-text"><input name="password" id="profile-password" type="password" class="required" /></div>
      </div>
      <div class="password-field field">
        <div class="label"><label for="profile-new-password"><?=$this->view->translate['newpassword'];?></label></div>
        <div class="input-text"><input name="new_password" id="profile-new-password" type="password" /></div>
      </div>
      <div class="password-field field">
        <div class="label"><label for="profile-new-password2"><?=$this->view->translate['newpasswordagain'];?></label></div>
        <div class="input-text"><input name="new_password2" id="profile-new-password2" type="password" /></div>
      </div>
      <div class="status"></div>
      <div class="submit">
        <div class="button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['save'];?></button></div></div></div></div>
      </div>
    </form>
  </div>
</div>

<? } else { ?>

<div id="auth" class="popup-src">
  <div class="auth">
    <ul class="tabs">
      <li class="act"><span><?=$this->view->translate['singin'];?></span></li>
      <li><span><?=$this->view->translate['register'];?></span></li>
    </ul>
    <div class="content">
      <div class="current logon ci">
        <form action="/user/login/" method="post">
          <div class="email-field field">
            <div class="label"><label for="logon-email">E-mail</label></div>
            <div class="input-text"><input name="email" id="logon-email" type="text" class="email required" /></div>
          </div>
          <div class="password-field field">
            <div class="label"><label for="logon-password"><?=$this->view->translate['password'];?></label> (<span class="recover-link"><?=$this->view->translate['forgot'];?></span>)</div>
            <div class="input-text"><input name="password" id="logon-password" type="password" class="required" /><label for="logon-password" class="hidden"><span class="show"><?=$this->view->translate['showpassword'];?></span><span class="hide"><?=$this->view->translate['hidepassword'];?></span></label></div>
          </div>
          <div class="status"></div>
          <div class="submit">
            <div class="input-checkbox">
              <input name="remember" id="logon-remember" type="checkbox" checked="checked" />
              <label for="logon-remember"><?=$this->view->translate['rememberme'];?></label>
            </div>
            <div class="button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['login'];?></button></div></div></div></div>
          </div>
        </form>
      </div>
      <div class="register ci">
        <form action="/user/register/" method="post" autocomplete="off">
          <div class="email-field field">
            <div class="label"><label for="register-email">E-mail</label></div>
            <div class="input-text"><input name="email" id="register-email" type="text" class="email required" autocomplete="yes" /></div>
          </div>
          <div class="password-field field">
            <div class="label"><label for="register-password"><?=$this->view->translate['password'];?></label></div>
            <div class="input-text"><input name="password" id="register-password" type="password" class="required" /><label for="register-password" class="hidden"><span class="show"><?=$this->view->translate['showpassword'];?></span><span class="hide"><?=$this->view->translate['hidepassword'];?></span></label></div>
          </div>
          <div class="password-field field">
            <div class="label"><label for="register-password"><?=$this->view->translate['passwordagain'];?></label></div>
            <div class="input-text"><input name="password2" id="register-password2" type="password" class="required" /><label for="register-password2" class="hidden"><span class="show"><?=$this->view->translate['showpassword'];?></span><span class="hide"><?=$this->view->translate['hidepassword'];?></span></label></div>
          </div>
          <div class="status"></div>
          <div class="submit">
            <div class="input-checkbox">
              <input name="agreement" id="register-agreement" type="checkbox" class="required" />
              <label for="register-agreement"><?=$this->view->translate['agreewith'];?> <strong><a href="/agreement/" target="_blank"><?=$this->view->translate['useragreement'];?></a></strong></label>
            </div>
            <div class="button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['register'];?></button></div></div></div></div>
          </div>
        </form>
      </div>
    </div>
    <div class="network-links">
      <h3><?=$this->view->translate['loginwith'];?></h3>
      <ul>
        <li class="facebook-link"><span>Facebook<i class="i"></i></span></li>
        <li class="vkontakte-link"><span>Вконтакте<i class="i"></i></span></li>
        <li class="twitter-link"><span>Twitter<i class="i"></i></span></li>
      </ul>
    </div>
  </div>
</div>

<div id="recover" class="popup-src">
  <div class="recover">
    <form action="/user/recover/" method="post">
      <h2>Выслать пароль</h2>
      <div class="email-field field">
        <div class="label"><label for="recover-email">E-mail</label></div>
        <div class="input-text"><input name="email" id="recover-email" type="text" class="email required" /></div>
      </div>
      <div class="status"></div>
      <div class="submit">
        <div class="button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit">Отправить</button></div></div></div></div>
        <div class="button"><div class="bg"><div class="r"><div class="l"><span class="auth-link el">Вспомнил!</span></div></div></div></div>
      </div>
    </form>
  </div>
</div>
<? } ?>

<script src="/js/shop/pinit.js" type="text/javascript"></script>
<?=$this->view->metrics;?>
</body>
</html>