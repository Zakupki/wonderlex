<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
  <title></title>
  <meta http-equiv="Cache-Control" content="Private" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="lang" content="ru" />
  <meta name="base" content="/" />
  <script src="/js/shopadmin/lang-<?=($_SESSION['langid']==2)?'en':'ru';?>.js?<?=time();?>" type="text/javascript"></script>
  <script src="/js/shopadmin/lib.js?<?=time();?>" type="text/javascript"></script>
  <script src="/js/shopadmin/redactor.js?<?=time();?>" type="text/javascript"></script>
  <link href="/css/shopadmin/main.css?<?=time();?>" type="text/css" rel="stylesheet" />
  <script src="/js/shopadmin/hc.js" type="text/javascript"></script>
  <script src="/js/shopadmin/main.js?<?=time();?>" type="text/javascript"></script>
  <link href="/favicon.ico" rel="icon" type="image/x-icon" />
  <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon" />
</head>
<body>

<div class="layout-body">

  <table class="layout-header">
  <tr>
    <td class="logo" rowspan="2"><a href="/"><img src="<?=$_SESSION['Site']['logo'];?>" alt="" /></a></td>
    <td class="dashboard">

      <div class="add-menu">
        <div class="jdrop">
          <div class="jdrop-title"><span class="jdrop-caption"><?=$this->view->translate['addto'];?></span><i class="jdrop-icon"></i><i class="jdrop-arrow"></i></div>
          <div class="jdrop-list">
            <ul>
              <? foreach($this->registry->addtomenu as $addkey=>$addmenu) { ?>
                <li><a href="/admin/<?=$addkey;?>/"><?=$addmenu;?></a></li>
              <? } ?>
            </ul>
          </div>
        </div>
      </div>

      <div class="settings-menu">
        <div class="jdrop">
          <div class="jdrop-title"><span class="jdrop-caption"><?=$this->view->translate['settings'];?></span><i class="jdrop-icon"></i><i class="jdrop-arrow"></i></div>
          <div class="jdrop-list">
            <ul>
              <li><a href="/admin/account/"><?=$this->view->translate['account'];?></a></li>
              <li><a href="/admin/design/"><?=$this->view->translate['design'];?></a></li>
              <li><a href="/admin/menu/"><?=$this->view->translate['menu'];?></a></li>
              <li><a href="/admin/category/"><?=$this->view->translate['catalog'];?></a></li>
              <li><a href="/admin/partners/"><?=$this->view->translate['partners'];?></a></li>
              <li><a href="/admin/banner/"><?=$this->view->translate['banner'];?></a></li>
              <li><a href="/admin/howtobuy/"><?=$this->view->translate['howtobuy'];?></a></li>
              <li><a href="/admin/agreement/"><?=$this->view->translate['useragreement'];?></a></li>
              <li><a href="/admin/seo/">Seo</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="site-link"><a href="/"><?=$this->view->translate['tosite'];?><i class="i"></i></a></div>
      
      <div class="stats-link"><a href="/admin/analytics">Аналитика<i class="i"></i></a></div>

      <div class="logout-link"><a href="/user/logout/"><?=$this->view->translate['singout'];?><i class="i"></i></a></div>

    </td>
  </tr>
  <tr>
    <td class="nav">
      
      <ul class="m1">
        <?
          foreach($this->view->mainmenu as $menu) {
            if ($menu['code']=='catalog') {
        ?>
          <li>
            <div class="jdrop">
              <div class="jdrop-title"><a href="/admin/<?=$menu['code'];?>/"><span class="jdrop-caption"><?=$menu['name'];?></span><i class="jdrop-arrow"></i></a></div>
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
                        <li><a href="/admin/catalog/<?=$category['itemid'];?>/"><?=$category['name'];?></a></li>
                  <?
                        $cnt++;
                      }
                    }
                  ?>
                </ul>
              </div>
            </div>
          </li>
          <? } elseif($menu['code']=='contacts') { ?>
            <li><div class="title"><div><span><a href="/admin/account/"><?=$menu['name'];?></a></span></div></div></li>
          <? } else { ?>
            <li><div class="title"><div><span><a href="/admin/<?=$menu['code'];?>/"><?=$menu['name'];?></a></span></div></div></li>
          <? }} ?>
      </ul>

      <ul class="lang">
        <li><a href="/admin/?lang=1">Русский</a></li>
        <li><a href="/admin/?lang=2">English</a></li>
      </ul>

    </td>
  </tr>
  </table>

  <div class="layout-content">
    <div class="layout-content-wrap">
      <?=$this->view->content;?>
    </div>
  </div>

</div>

<div class="layout-footer">

  <ul class="nav">
    <li><a href="#"><?=$this->view->translate['support'];?></a></li>
    <li><a href="#"><?=$this->view->translate['faq'];?></a></li>
    <li><a href="#"><?=$this->view->translate['feedback'];?></a></li>
  </ul>

  <div class="copy">&copy; 2012 <a href="/"><?=$this->view->siteinfo['name'];?></a></div>

</div>

<? /*
<div id="mail" class="popup-src">
  <div class="mail">
    <form action="/favourites/mail/" method="post">
      <input name="userid" type="hidden" />
      <h2>Написать письмо</h2>
      <div class="field">
        <label for="mail-subject" class="placeholder">Тема</label>
        <div class="input-text"><input name="subject" id="mail-subject" value="Тема" title="Тема" type="text" /></div>
      </div>
      <div class="field">
        <label for="mail-message" class="placeholder">Сообщение</label>
        <div class="textarea"><textarea name="message" id="mail-message" title="Сообщение" cols="" rows="" class="required">Сообщение</textarea></div>
      </div>
      <div class="submit">
        <div class="button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit">Отправить</button></div></div></div></div>
      </div>
    </form>
  </div>
</div>

<div id="report" class="popup-src">
  <div class="report">
    <form action="/_temp/_report.php" method="post">
      <h2>Сообщить об ошибке</h2>
      <div class="field">
        <div class="label"><label for="report-subject">Тема *</label></div>
        <div class="input-text"><input name="subject" id="report-subject" type="text" class="required" /></div>
      </div>
      <div class="field">
        <div class="label"><label for="report-message">Сообщение *</label></div>
        <div class="textarea"><textarea name="message" id="report-message" cols="" rows="" class="required"></textarea></div>
      </div>
      <div class="field">
        <div class="label"><label for="report-kind">Тип запроса</label></div>
        <div class="select">
          <select name="kind" id="report-kind">
            <option value="0">&mdash;</option>
            <option value="1">Тип запроса 1</option>
            <option value="2">Тип запроса 2</option>
            <option value="3">Тип запроса 3</option>
            <option value="4">Тип запроса 4</option>
            <option value="5">Тип запроса 5</option>
          </select>
        </div>
      </div>
      <div class="field">
        <div class="label"><label for="report-browser">Браузер *</label></div>
        <div class="select">
          <select name="browser" id="report-browser">
            <option value="0">&mdash;</option>
            <option value="1">Google Chrome</option>
            <option value="2">Mozilla Firefox</option>
            <option value="3">Internet Explorer</option>
            <option value="4">Safari</option>
            <option value="5">Opera</option>
            <option value="6">Другой</option>
          </select>
        </div>
      </div>
      <div class="field">
        <div class="label"><label for="report-browser">Прикрепить файл</label></div>
        <div class="input-file">
          <div class="button"><div class="bg"><div class="r"><div class="l"><div class="el">Обзор...<input name="file" id="report-file" type="file" /></div></div></div></div></div>
          <div class="name"></div>
          <div class="cancel"></div>
        </div>
      </div>
      <div class="submit">
        <div class="button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit">Отправить</button></div></div></div></div>
      </div>
    </form>
  </div>
</div>
*/ ?>

</body>
</html>