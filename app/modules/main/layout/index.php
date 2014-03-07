<?$langarr=array(1=>'ru',2=>'en');
$langarr2=array(1=>'rus',2=>'en');
$langarr3=array(2=>'rus',1=>'en');
$langarr4=array(2=>'ru',1=>'en');?>
<!DOCTYPE html>
<html lang="<?=$langarr[$this->view->curlang];?>">
<head>
    <meta charset="utf-8" />
    <title></title>
    <link rel="stylesheet" href="/css/main/main.css">
    <link rel="stylesheet" href="/css/main/gallery.css">
    <link rel="stylesheet" href="/css/main/jquery-ui-1.10.1.custom.css">
    <? foreach($this->view->styles as $style){?>
    <link rel="stylesheet" href="/css/main/<?=$style;?>.css">
    <?}?>
    <script src="/js/main/modernizr-2.6.2.min.js"></script>
    <script src="/js/main/jquery-1.8.3.min.js"></script>
    <script src="/js/main/tween-max.min.js"></script>
    <script src="/js/main/iscroll-min.js"></script>

    <script src="/js/main/jquery-ui-1.10.1.custom.min.js"></script>

    <script src="/js/main/jquery.gallery.js"></script>
    <script src="/js/main/jquery.main.js"></script>
    <? foreach($this->view->styles as $style){?>
    <script src="/js/main/jquery.<?=$style;?>.js"></script>
    <?}?>
    

    <!--[if lte IE 9]>
    <script src="/js/main/jquery.placeholder.js"></script>
    <link rel="stylesheet" href="/css/main/pie.css">
    <link rel="stylesheet" href="/css/main/main.ie.css">
    <![endif]-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/css/main/main.ie8.css">
    <link rel="stylesheet" href="/css/main/jquery.jscrollpane.css">

    <script src="/js/main/jquery.jscrollpane.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
    <script type="text/javascript">
        stLight.options({
            publisher: "b8837325-130e-4e7d-889a-bf67f11bdb71",
            doNotHash: false,
            doNotCopy: false,
            hashAddressBar: false
        });
    </script>
</head>
<body>
    <!-- site -->
    <div class="site">
        <div class="site__layout">
            <!-- header -->
            <header class="header">
                <div class="header__cube header__cube_<?=$langarr2[$this->view->curlang];?>">
                    
                    <?
                    foreach($this->view->langlist as $lang) {
                    ?>
<div class="header__item header__item_<?=$langarr2[$lang['id']];?>">
                        <!-- logo -->
                        <a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/" class="logo" title="<?=$this->view->translate['gohome'];?>"><img src="/img/main/logo_.png" width="148" height="28" alt="wonderlex"></a>
                        <!-- /logo -->

                        <!-- language -->
                        <div class="language">
                            <a class="language__lnk" href="<?=($langarr4[$lang['id']]=='ru')?'/':'/'.$langarr4[$lang['id']].'/';?>"  data-action="header__cube_<?=$langarr2[$lang['id']];?>">&nbsp;<!--<?=$langarr4[$lang['id']];?>--></a>
                        </div>
                        <!-- /language -->

                        <!-- main-menu -->
                        <nav class="main-menu">
                            <ol class="main-menu__layout">
                                <li class="main-menu__item"><a class="main-menu__lnk" href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/catalog/"><?=$this->view->translate['catalog'];?></a></li>
                                <li class="main-menu__item"><a class="main-menu__lnk" href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/collector/"><?=$this->view->translate['forcollector'];?></a></li>
                                <li class="main-menu__item"><a class="main-menu__lnk" href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/authors/"><?=$this->view->translate['authors'];?></a></li>
                                <li class="main-menu__item"><a class="main-menu__lnk" href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/about/"><?=$this->view->translate['aboutus'];?></a></li>
                            </ol>
                        </nav>
                        <!-- /main-menu -->

                        <!-- account -->
                        <div class="account">
                            
                            <?if(count($this->view->currency)>0){?>
                            <!--<div class="main-menu__item main-menu__item_sub main-menu__item_last">
                                <? foreach($this->view->currency as $cur){
                                    if ($_SESSION['curid']==$cur['id'])
                                    $defaultCur=$cur['code'];
                                    else
                                    $curlist.='<li class="main-menu__sub-title">
                                        <a class="main-menu__sub-lnk" href="?curid='.$cur['id'].'"><img class="currency-img" src="/img/main/'.$cur['code'].'-ico.png" width="15" height="21" alt="">'.$cur['code'].'</a>
                                    </li>';
                                    }?>
                                
                                <span class="main-menu__lnk main-menu__lnk_sub"> <img class="currency-img" src="/img/main/<?=$defaultCur;?>-ico.png" width="15" height="21" alt=""><?=$defaultCur;?></span>
                                <ul class="main-menu__sub">
                                    <?=$curlist;?>
                                </ul>
                            </div>-->
                            <?}?>
                            <? if($_SESSION['User']['id']<1){?>
                            <div class="account__login" data-php="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/loginform/"><?=$this->view->translate['signin'];?></div>
                            <?=$this->view->translate['or'];?>
                            <div class="account__registration" data-php="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/registration/"><?=$this->view->translate['register'];?></div>
                            <?}else{?>
                            <div class="account__profile">
                                <span><?=$this->view->translate['profile'];?></span>
                                <div class="account__profile-menu">
                                    <ul class="account__profile-list">
                                        <li class="account__profile-item">
                                            <a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/user/profile/" class="account__profile-lnk"><?=$this->view->translate['settings'];?></a>
                                        </li>
                                        <li class="account__profile-item">
                                            <a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/user/history/" class="account__profile-lnk"><?=$this->view->translate['history'];?></a>
                                        </li>
                                    </ul>
                                    <? if($_SESSION['User']['reccounts'][0]['id']>0){?>
                                    <a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/user/site/<?=$_SESSION['User']['reccounts'][0]['id'];?>/" class="account__profile-part"><?=$_SESSION['User']['reccounts'][0]['id'];?></a>
                                    <?}else{?>
                                    <a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/user/signup/" class="account__profile-part"><?=$this->view->translate['signup'];?></a>
                                    <?}?>
                                    <a href="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/user/logout/" class="account__profile-exit"><?=$this->view->translate['logout'];?></a>
                                </div>
                            </div>
                            <div class="account__cart"><a href="/basket/"><?=$this->view->translate['cart'];?></a> <span class="account__cart-count"><?=$this->view->inbasket;?></span></div>
                            <?}?>
                        </div>
                        <!-- /account -->

                        <!-- search -->
                        <div class="search" id="search" data-php="<?=($this->registry->langurl)?$this->registry->langurl:'';?>/getsearch/"></div>
                        <!-- /search -->

                    </div>
                    <?
                    }?>
                    <!--<div class="header__item header__item_rus">

                        <h1 class="logo"><img src="/img/main/logo.png" width="148" height="18" alt="wonderlex"></h1>
                    
                        <div class="language">
                            <a class="language__lnk" href="index.html"  data-action="header__cube_rus">ru</a>
                        </div>
                        
                        <nav class="main-menu">
                            <ol class="main-menu__layout">
                                <li class="main-menu__item"><a class="main-menu__lnk" href="#">catalog</a></li>
                                <li class="main-menu__item"><a class="main-menu__lnk" href="#">auction</a></li>
                                <li class="main-menu__item"><a class="main-menu__lnk" href="#">authors</a></li>
                                <li class="main-menu__item"><a class="main-menu__lnk" href="#">events</a></li>
                                <li class="main-menu__item main-menu__item_sub"><span class="main-menu__lnk main-menu__lnk_sub">about</span></li>
                            </ol>
                        </nav>
                        
                        <div class="account">
                            <div class="account__login">login</div>
                            or
                            <div class="account__registration">signup</div>
                        </div>
                        
                        
                        <form class="search" action="#">

                        </form>

                    </div>-->
                </div>

            </header>
            <!-- /header -->

            <div class="site__content">
                <div class="content-wrap">
                <!-- content-wrap -->
                    <?=$this->view->content;?>
                    <!-- social -->
                    <? if(!$this->view->nosocial){?>
                    <div class="social">
                        <ul class="social__menu">
                            <li class="social__item social__item_active">
                                <span class="social__item-btn social__item-btn_facebook">Facebook</span>
                            </li>
                            <!--<li class="social__item">
                                <span class="social__item-btn social__item-btn_vk">Вконтакте</span>
                            </li>-->
                        </ul>
                        <a href="https://twitter.com/Wonderlex_com" class="social__tweeter">tweeter</a>
                        <a target="_blank" href="/rss/" class="social__rss">rss</a>

                        <ul class="social__content">
                            <li class="social__content-item">
                                <div class="fb-like-box" data-href="https://www.facebook.com/Wonderlex" data-border-color="#ffffff" data-width="1833" data-show-faces="true" data-stream="false" data-header="false"></div>
                            </li>
                            <!--<li class="social__content-item">
                                <script type="text/javascript" src="//vk.com/js/api/openapi.js?75"></script>
                                <div id="vk_groups"></div>
                                <script type="text/javascript">
                                    VK.Widgets.Group("vk_groups", {mode: 0, width: "1833", height: "258"}, 20003922);
                                </script>
                            </li>-->
                        </ul>
                    </div>
                    <?}?>
                    <!-- /social -->
                </div>
                <!-- /content-wrap -->
            </div>
        </div>
    </div>
    <!-- /site -->

    <!-- footer -->
    <footer class="footer">
        <div class="footer__layout">
            <div class="footer__copyright">&copy; <?=date("Y");?> «<span class="footer__copyright-item">Wonderlex</span>»</div>

            <!-- main-menu -->
            <nav class="main-menu main-menu_footer">
                <ol class="main-menu__layout">
                    <li class="main-menu__item"><a class="main-menu__lnk main-menu__lnk_privacy" href="/privacy/"><?=$this->view->translate['privacy'];?></a></li>
                    <li class="main-menu__item"><a class="main-menu__lnk" href="/privacy/"><?=$this->view->translate['useragreement'];?></a></li>
                </ol>
            </nav>
            <!-- /main-menu -->

        </div>
    </footer>
    <!-- /footer -->

    <!-- for facebook -->
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <!-- /for facebook -->

</body>
</html>