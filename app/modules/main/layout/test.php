<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <title></title>
    <link rel="stylesheet" href="/css/main/main.css">
    <link rel="stylesheet" href="/css/main/gallery.css">

    <script src="/js/main/modernizr-2.6.2.min.js"></script>
    <script src="/js/main/jquery-1.8.3.min.js"></script>
    <script src="/js/main/tween-max.min.js"></script>
    <script src="/js/main/iscroll-min.js"></script>
    <script src="/js/main/jquery.main.js"></script>
    <script src="/js/main/jquery-ui-1.10.1.custom.min.js"></script>
    <script src="/js/main/jquery.gallery.js"></script>

    <!--[if lte IE 9]>
    <script src="js/jquery.placeholder.js"></script>
    <link rel="stylesheet" href="css/pie.css">
    <link rel="stylesheet" href="css/main.ie.css">
    <![endif]-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="css/main.ie8.css">
    <link rel="stylesheet" href="css/jquery.jscrollpane.css">

    <script src="js/jquery.jscrollpane.min.js"></script>
    <![endif]-->
</head>
<body>
<!-- site -->
<div class="site">
<div class="site__layout">
<!-- header -->
<header class="header">
    <div class="header__cube header__cube_rus">
        <div class="header__item header__item_rus">

            <!-- logo -->
            <h1 class="logo"><img src="img/logo.png" width="148" height="18" alt="wonderlex"></h1>
            <!-- /logo -->

            <!-- language -->
            <div class="language">
                <a class="language__lnk language__lnk_active" href="index_en.html" data-action="header__cube_en">en</a>
            </div>
            <!-- /language -->

            <!-- main-menu -->
            <nav class="main-menu">
                <ol class="main-menu__layout">
                    <li class="main-menu__item"><a class="main-menu__lnk" href="#">каталог</a></li>
                    <li class="main-menu__item"><a class="main-menu__lnk" href="#">аукцион</a></li>
                    <li class="main-menu__item"><a class="main-menu__lnk" href="#">Авторы</a></li>
                    <li class="main-menu__item"><a class="main-menu__lnk" href="#">события</a></li>
                    <li class="main-menu__item main-menu__item_sub">
                        <span class="main-menu__lnk main-menu__lnk_sub">о wonderlex</span>
                        <ul class="main-menu__sub">
                            <li class="main-menu__sub-title">
                                <a class="main-menu__sub-lnk" href="#">дополнительный подраздел 1</a>
                            </li>
                            <li class="main-menu__sub-title">
                                <a class="main-menu__sub-lnk" href="#">подраздел 2</a>
                            </li>
                            <li class="main-menu__sub-title">
                                <a class="main-menu__sub-lnk" href="#">подраздел 3</a>
                            </li>
                            <li class="main-menu__sub-title">
                                <a class="main-menu__sub-lnk" href="#">подраздел 4</a>
                            </li>
                            <li class="main-menu__sub-title">
                                <a class="main-menu__sub-lnk" href="#">подраздел 5</a>
                            </li>
                        </ul>
                    </li>
                </ol>
            </nav>
            <!-- /main-menu -->

            <!-- account -->
            <div class="account">
                <div class="account__login" data-php="/php/login-form.php?<?=time();?>">вход</div>
                или
                <div class="account__registration" data-php="php/registration-form.php">регистрация</div>
                <!--<div class="account__profile">-->
                <!--<span>Профиль</span>-->
                <!--<div class="account__profile-menu">-->
                <!--<ul class="account__profile-list">-->
                <!--<li class="account__profile-item">-->
                <!--<a href="#" class="account__profile-lnk">Настройки</a>-->
                <!--</li>-->
                <!--<li class="account__profile-item">-->
                <!--<a href="#" class="account__profile-lnk">История</a>-->
                <!--</li>-->
                <!--</ul>-->
                <!--<a href="#" class="account__profile-part">Принять участие</a>-->
                <!--<a href="#" class="account__profile-exit">Выход</a>-->
                <!--</div>-->
                <!--</div>-->
                <!--<div class="account__cart">Корзина <span class="account__cart-count">3</span></div>-->
            </div>
            <!-- /account -->

            <!-- search -->
            <div class="search" id="search" data-php="php/search-form.php"></div>
            <!-- /search -->

        </div>
        <div class="header__item header__item_en">

            <!-- logo -->
            <h1 class="logo"><img src="img/logo.png" width="148" height="18" alt="wonderlex"></h1>
            <!-- /logo -->

            <!-- language -->
            <div class="language">
                <a class="language__lnk" href="index.html"  data-action="header__cube_rus">ru</a>
            </div>
            <!-- /language -->

            <!-- main-menu -->
            <nav class="main-menu">
                <ol class="main-menu__layout">
                    <li class="main-menu__item"><a class="main-menu__lnk" href="#">catalog</a></li>
                    <li class="main-menu__item"><a class="main-menu__lnk" href="#">auction</a></li>
                    <li class="main-menu__item"><a class="main-menu__lnk" href="#">authors</a></li>
                    <li class="main-menu__item"><a class="main-menu__lnk" href="#">events</a></li>
                    <li class="main-menu__item main-menu__item_sub"><span class="main-menu__lnk main-menu__lnk_sub">about</span></li>
                </ol>
            </nav>
            <!-- /main-menu -->

            <!-- account -->
            <div class="account">
                <div class="account__login">login</div>
                or
                <div class="account__registration">signup</div>
            </div>
            <!-- /account -->

            <!-- search -->
            <form class="search" action="#">

            </form>
            <!-- /search -->

        </div>
    </div>

</header>
<!-- /header -->

<div class="site__content">

<!-- content-wrap -->
<div class="content-wrap">

<!-- banner -->
<div class="banner">
    <a class="banner__item" href="#">
        <img src="pic/baner1.jpg" width="1430" height="200" alt="">
    </a>
</div>
<!-- /banner -->

<!-- gallery -->
<div class="gallery">

    <!-- gallery__layout -->
    <div class="gallery__layout">

        <!-- gallery__column -->
        <ul class="gallery__column">
            <li class="gallery__item gallery__item_best" data-id="1">
                <div class="gallery__wrap-element">
                    <a class="gallery__pic-lnk" href="#"><img class="gallery__pic" src="pic/gallery1.jpg" width="430" height="530" alt=""></a>
                    <section class="gallery__data">
                        <a href="#" class="gallery__title">maya presentation</a>
                        <a class="gallery__lnk" href="#">наташа егорова</a>
                        <div class="gallery__price">459 грн</div>
                        <a href="#" class="gallery__auction"></a>
                        <a href="#" class="gallery__cart"></a>
                    </section>
                </div>
            </li>
            <li class="gallery__item gallery__item_new" data-id="2">
                <div class="gallery__wrap-element">
                    <a class="gallery__pic-lnk" href="#"><img class="gallery__pic" src="pic/gallery2.jpg" width="430" height="398" alt=""></a>
                    <section class="gallery__data">
                        <a href="#" class="gallery__title">maya presentation</a>
                        <a class="gallery__lnk" href="#">наташа егорова</a>
                        <div class="gallery__price">459 грн</div>
                        <a href="#" class="gallery__auction"></a>
                        <a href="#" class="gallery__cart"></a>
                    </section>
                </div>
            </li>
            <li class="gallery__item" data-id="3">
                <div class="gallery__wrap-element">
                    <a class="gallery__pic-lnk" href="#"><img class="gallery__pic" src="pic/gallery3.jpg" width="430" height="610" alt=""></a>
                    <section class="gallery__data">
                        <a href="#" class="gallery__title">maya presentation</a>
                        <a class="gallery__lnk" href="#">наташа егорова</a>
                        <div class="gallery__price">459 грн</div>
                        <a href="#" class="gallery__auction"></a>
                        <a href="#" class="gallery__cart"></a>
                    </section>
                </div>
            </li>
            <li class="gallery__item" data-id="4">
                <div class="gallery__wrap-element">
                    <a class="gallery__pic-lnk" href="#"><img class="gallery__pic" src="pic/gallery4.jpg" width="430" height="280" alt=""></a>
                    <section class="gallery__data">
                        <a href="#" class="gallery__title">maya presentation</a>
                        <a class="gallery__lnk" href="#">наташа егорова</a>
                        <div class="gallery__price">459 грн</div>
                        <a href="#" class="gallery__auction"></a>
                        <a href="#" class="gallery__cart"></a>
                    </section>
                </div>
            </li>
            <li class="gallery__item" data-id="5">
                <div class="gallery__wrap-element">
                    <a class="gallery__pic-lnk" href="#"><img class="gallery__pic" src="pic/gallery5.jpg" width="430" height="300" alt=""></a>
                    <section class="gallery__data">
                        <a href="#" class="gallery__title">maya presentation</a>
                        <a class="gallery__lnk" href="#">наташа егорова</a>
                        <div class="gallery__price">459 грн</div>
                        <a href="#" class="gallery__auction"></a>
                        <a href="#" class="gallery__cart"></a>
                    </section>
                </div>
            </li>
            <li class="gallery__item" data-id="6">
                <div class="gallery__wrap-element">
                    <a class="gallery__pic-lnk" href="#"><img class="gallery__pic" src="pic/gallery6.jpg" width="430" height="180" alt=""></a>
                    <section class="gallery__data">
                        <a href="#" class="gallery__title">maya presentation</a>
                        <a class="gallery__lnk" href="#">наташа егорова</a>
                        <div class="gallery__price">459 грн</div>
                        <a href="#" class="gallery__auction"></a>
                        <a href="#" class="gallery__cart"></a>
                    </section>
                </div>
            </li>
            <li class="gallery__item" data-id="7">
                <div class="gallery__wrap-element">
                    <a class="gallery__pic-lnk" href="#"><img class="gallery__pic" src="pic/gallery7.jpg" width="430" height="296" alt=""></a>
                    <section class="gallery__data">
                        <a href="#" class="gallery__title">maya presentation</a>
                        <a class="gallery__lnk" href="#">наташа егорова</a>
                        <div class="gallery__price">459 грн</div>
                        <a href="#" class="gallery__auction"></a>
                        <a href="#" class="gallery__cart"></a>
                    </section>
                </div>
            </li>
            <li class="gallery__item" data-id="8">
                <div class="gallery__wrap-element">
                    <a class="gallery__pic-lnk" href="#"><img class="gallery__pic" src="pic/gallery8.jpg" width="430" height="300" alt=""></a>
                    <section class="gallery__data">
                        <a href="#" class="gallery__title">maya presentation</a>
                        <a class="gallery__lnk" href="#">наташа егорова</a>
                        <div class="gallery__price">459 грн</div>
                        <a href="#" class="gallery__auction"></a>
                        <a href="#" class="gallery__cart"></a>
                    </section>
                </div>
            </li>
            <li class="gallery__item" data-id="9">
                <div class="gallery__wrap-element">
                    <a class="gallery__pic-lnk" href="#"><img class="gallery__pic" src="pic/gallery9.jpg" width="430" height="323" alt=""></a>
                    <section class="gallery__data">
                        <a href="#" class="gallery__title">maya presentation</a>
                        <a class="gallery__lnk" href="#">наташа егорова</a>
                        <div class="gallery__price">459 грн</div>
                        <a href="#" class="gallery__auction"></a>
                        <a href="#" class="gallery__cart"></a>
                    </section>
                </div>
            </li>
            <li class="gallery__item" data-id="10">
                <div class="gallery__wrap-element">
                    <a class="gallery__pic-lnk" href="#"><img class="gallery__pic" src="pic/gallery10.jpg" width="430" height="328" alt=""></a>
                    <section class="gallery__data">
                        <a href="#" class="gallery__title">maya presentation</a>
                        <a class="gallery__lnk" href="#">наташа егорова</a>
                        <div class="gallery__price">459 грн</div>
                        <a href="#" class="gallery__auction"></a>
                        <a href="#" class="gallery__cart"></a>
                    </section>
                </div>
            </li>
            <li class="gallery__item" data-id="11">
                <div class="gallery__wrap-element">
                    <a class="gallery__pic-lnk" href="#"><img class="gallery__pic" src="pic/gallery11.jpg" width="430" height="300" alt=""></a>
                    <section class="gallery__data">
                        <a href="#" class="gallery__title">maya presentation</a>
                        <a class="gallery__lnk" href="#">наташа егорова</a>
                        <div class="gallery__price">459 грн</div>
                        <a href="#" class="gallery__auction"></a>
                        <a href="#" class="gallery__cart"></a>
                    </section>
                </div>
            </li>
            <li class="gallery__item" data-id="12">
                <div class="gallery__wrap-element">
                    <a class="gallery__pic-lnk" href="#"><img class="gallery__pic" src="pic/gallery12.jpg" width="430" height="283" alt=""></a>
                    <section class="gallery__data">
                        <a href="#" class="gallery__title">maya presentation</a>
                        <a class="gallery__lnk" href="#">наташа егорова</a>
                        <div class="gallery__price">459 грн</div>
                        <a href="#" class="gallery__auction"></a>
                        <a href="#" class="gallery__cart"></a>
                    </section>
                </div>
            </li>
        </ul>
        <!-- /gallery__column -->

    </div>
    <!-- /gallery__layout -->

    <input type="button" class="btn btn__gallery-more" id="btn__gallery-more" data-step="12" data-php="php/add-pic.php" data-mode="more"  value="Показать еще">
</div>
<!-- /gallery -->

<!-- authors -->
<section class="authors">
<h1 class="authors__title">Лучшие авторы</h1>
<div class="authors__gallery">
<div class="authors__gallery-btn authors__gallery-btn_prev"></div>
<ul class="authors__gallery-layout">
<li class="authors__gallery-item">
    <a class="authors__gallery-lnk" href="#">
        <img class="authors__gallery-pic" src="pic/authors-pic1.jpg" width="150" height="150" alt="">
        <span class="authors__gallery-name">Наташа Егорова</span>
        <p class="authors__gallery-txt">Время застывает, и мгновение длится
            бесконечно. Мы оказываемся перед лицом некой смутно знакомой, но отчужденной
            реальности.</p>
    </a>
</li>
<li class="authors__gallery-item">
    <a class="authors__gallery-lnk" href="#">
        <img class="authors__gallery-pic" src="pic/authors-pic3.jpg" width="150" height="150" alt="">
        <span class="authors__gallery-name">Никита Власов</span>
        <p class="authors__gallery-txt">Архитектор, дизайнер, иллюстратор</p>
    </a>
</li>
<li class="authors__gallery-item">
    <a class="authors__gallery-lnk" href="#">
        <img class="authors__gallery-pic" src="pic/authors-pic2.jpg" width="150" height="150" alt="">
        <span class="authors__gallery-name">Оксана Гудзык</span>
        <p class="authors__gallery-txt">Фантазия – главный ингредиент в творчестве
            Оксаны. Она может создать красивую вещь из чего угодно. И это не цветастая
            метафора и даже не преувеличение.</p>
    </a>
</li>
<li class="authors__gallery-item">
    <a class="authors__gallery-lnk" href="#">
        <img class="authors__gallery-pic" src="pic/authors-pic3.jpg" width="150" height="150" alt="">
        <span class="authors__gallery-name">Mour Vision</span>
        <p class="authors__gallery-txt">Kind of activity: Art</p>
    </a>
</li>
<li class="authors__gallery-item">
    <a class="authors__gallery-lnk" href="#">
        <img class="authors__gallery-pic" src="pic/authors-pic2.jpg" width="150" height="150" alt="">
        <span class="authors__gallery-name">Петр Гейдек</span>
        <p class="authors__gallery-txt">С 1982 года  принимал участие в крупных
            республиканских и всесоюзных выставках во Львове, Киеве, Москве,
            Риге.</p>
    </a>
</li>
<li class="authors__gallery-item">
    <a class="authors__gallery-lnk" href="#">
        <img class="authors__gallery-pic" src="pic/authors-pic1.jpg" width="150" height="150" alt="">
        <span class="authors__gallery-name">Наташа Егорова</span>
        <p class="authors__gallery-txt">Время застывает, и мгновение длится
            бесконечно. Мы оказываемся перед лицом некой смутно знакомой, но отчужденной
            реальности.</p>
    </a>
</li>
<li class="authors__gallery-item">
    <a class="authors__gallery-lnk" href="#">
        <img class="authors__gallery-pic" src="pic/authors-pic3.jpg" width="150" height="150" alt="">
        <span class="authors__gallery-name">Никита Власов</span>
        <p class="authors__gallery-txt">Архитектор, дизайнер, иллюстратор</p>
    </a>
</li>
<li class="authors__gallery-item">
    <a class="authors__gallery-lnk" href="#">
        <img class="authors__gallery-pic" src="pic/authors-pic2.jpg" width="150" height="150" alt="">
        <span class="authors__gallery-name">Оксана Гудзык</span>
        <p class="authors__gallery-txt">Фантазия – главный ингредиент в творчестве
            Оксаны. Она может создать красивую вещь из чего угодно. И это не цветастая
            метафора и даже не преувеличение.</p>
    </a>
</li>
<li class="authors__gallery-item">
    <a class="authors__gallery-lnk" href="#">
        <img class="authors__gallery-pic" src="pic/authors-pic3.jpg" width="150" height="150" alt="">
        <span class="authors__gallery-name">Mour Vision</span>
        <p class="authors__gallery-txt">Kind of activity: Art</p>
    </a>
</li>
<li class="authors__gallery-item">
    <a class="authors__gallery-lnk" href="#">
        <img class="authors__gallery-pic" src="pic/authors-pic2.jpg" width="150" height="150" alt="">
        <span class="authors__gallery-name">Петр Гейдек</span>
        <p class="authors__gallery-txt">С 1982 года  принимал участие в крупных
            республиканских и всесоюзных выставках во Львове, Киеве, Москве,
            Риге.</p>
    </a>
</li>
<li class="authors__gallery-item">
    <a class="authors__gallery-lnk" href="#">
        <img class="authors__gallery-pic" src="pic/authors-pic1.jpg" width="150" height="150" alt="">
        <span class="authors__gallery-name">Наташа Егорова</span>
        <p class="authors__gallery-txt">Время застывает, и мгновение длится
            бесконечно. Мы оказываемся перед лицом некой смутно знакомой, но отчужденной
            реальности.</p>
    </a>
</li>
<li class="authors__gallery-item">
    <a class="authors__gallery-lnk" href="#">
        <img class="authors__gallery-pic" src="pic/authors-pic3.jpg" width="150" height="150" alt="">
        <span class="authors__gallery-name">Никита Власов</span>
        <p class="authors__gallery-txt">Архитектор, дизайнер, иллюстратор</p>
    </a>
</li>
<li class="authors__gallery-item">
    <a class="authors__gallery-lnk" href="#">
        <img class="authors__gallery-pic" src="pic/authors-pic2.jpg" width="150" height="150" alt="">
        <span class="authors__gallery-name">Оксана Гудзык</span>
        <p class="authors__gallery-txt">Фантазия – главный ингредиент в творчестве
            Оксаны. Она может создать красивую вещь из чего угодно. И это не цветастая
            метафора и даже не преувеличение.</p>
    </a>
</li>
<li class="authors__gallery-item">
    <a class="authors__gallery-lnk" href="#">
        <img class="authors__gallery-pic" src="pic/authors-pic3.jpg" width="150" height="150" alt="">
        <span class="authors__gallery-name">Mour Vision</span>
        <p class="authors__gallery-txt">Kind of activity: Art</p>
    </a>
</li>
<li class="authors__gallery-item">
    <a class="authors__gallery-lnk" href="#">
        <img class="authors__gallery-pic" src="pic/authors-pic2.jpg" width="150" height="150" alt="">
        <span class="authors__gallery-name">Петр Гейдек</span>
        <p class="authors__gallery-txt">С 1982 года  принимал участие в крупных
            республиканских и всесоюзных выставках во Львове, Киеве, Москве,
            Риге.</p>
    </a>
</li>
<li class="authors__gallery-item">
    <a class="authors__gallery-lnk" href="#">
        <img class="authors__gallery-pic" src="pic/authors-pic1.jpg" width="150" height="150" alt="">
        <span class="authors__gallery-name">Наташа Егорова</span>
        <p class="authors__gallery-txt">Время застывает, и мгновение длится
            бесконечно. Мы оказываемся перед лицом некой смутно знакомой, но отчужденной
            реальности.</p>
    </a>
</li>
<li class="authors__gallery-item">
    <a class="authors__gallery-lnk" href="#">
        <img class="authors__gallery-pic" src="pic/authors-pic3.jpg" width="150" height="150" alt="">
        <span class="authors__gallery-name">Никита Власов</span>
        <p class="authors__gallery-txt">Архитектор, дизайнер, иллюстратор</p>
    </a>
</li>
<li class="authors__gallery-item">
    <a class="authors__gallery-lnk" href="#">
        <img class="authors__gallery-pic" src="pic/authors-pic2.jpg" width="150" height="150" alt="">
        <span class="authors__gallery-name">Оксана Гудзык</span>
        <p class="authors__gallery-txt">Фантазия – главный ингредиент в творчестве
            Оксаны. Она может создать красивую вещь из чего угодно. И это не цветастая
            метафора и даже не преувеличение.</p>
    </a>
</li>
<li class="authors__gallery-item">
    <a class="authors__gallery-lnk" href="#">
        <img class="authors__gallery-pic" src="pic/authors-pic3.jpg" width="150" height="150" alt="">
        <span class="authors__gallery-name">Mour Vision</span>
        <p class="authors__gallery-txt">Kind of activity: Art</p>
    </a>
</li>
<li class="authors__gallery-item">
    <a class="authors__gallery-lnk" href="#">
        <img class="authors__gallery-pic" src="pic/authors-pic2.jpg" width="150" height="150" alt="">
        <span class="authors__gallery-name">Петр Гейдек</span>
        <p class="authors__gallery-txt">С 1982 года  принимал участие в крупных
            республиканских и всесоюзных выставках во Львове, Киеве, Москве,
            Риге.</p>
    </a>
</li>
<li class="authors__gallery-item">
    <a class="authors__gallery-lnk" href="#">
        <img class="authors__gallery-pic" src="pic/authors-pic1.jpg" width="150" height="150" alt="">
        <span class="authors__gallery-name">Наташа Егорова</span>
        <p class="authors__gallery-txt">Время застывает, и мгновение длится
            бесконечно. Мы оказываемся перед лицом некой смутно знакомой, но отчужденной
            реальности.</p>
    </a>
</li>
<li class="authors__gallery-item">
    <a class="authors__gallery-lnk" href="#">
        <img class="authors__gallery-pic" src="pic/authors-pic3.jpg" width="150" height="150" alt="">
        <span class="authors__gallery-name">Никита Власов</span>
        <p class="authors__gallery-txt">Архитектор, дизайнер, иллюстратор</p>
    </a>
</li>
<li class="authors__gallery-item">
    <a class="authors__gallery-lnk" href="#">
        <img class="authors__gallery-pic" src="pic/authors-pic2.jpg" width="150" height="150" alt="">
        <span class="authors__gallery-name">Оксана Гудзык</span>
        <p class="authors__gallery-txt">Фантазия – главный ингредиент в творчестве
            Оксаны. Она может создать красивую вещь из чего угодно. И это не цветастая
            метафора и даже не преувеличение.</p>
    </a>
</li>
<li class="authors__gallery-item">
    <a class="authors__gallery-lnk" href="#">
        <img class="authors__gallery-pic" src="pic/authors-pic3.jpg" width="150" height="150" alt="">
        <span class="authors__gallery-name">Mour Vision</span>
        <p class="authors__gallery-txt">Kind of activity: Art</p>
    </a>
</li>
<li class="authors__gallery-item">
    <a class="authors__gallery-lnk" href="#">
        <img class="authors__gallery-pic" src="pic/authors-pic2.jpg" width="150" height="150" alt="">
        <span class="authors__gallery-name">Петр Гейдек</span>
        <p class="authors__gallery-txt">С 1982 года  принимал участие в крупных
            республиканских и всесоюзных выставках во Львове, Киеве, Москве,
            Риге.</p>
    </a>
</li>
</ul>
<div class="authors__gallery-btn authors__gallery-btn_next"></div>
</div>
</section>
<!-- /authors -->

<!-- social -->
<div class="social">
    <ul class="social__menu">
        <li class="social__item social__item_active">
            <span class="social__item-btn social__item-btn_facebook">Facebook</span>
        </li>
        <li class="social__item">
            <span class="social__item-btn social__item-btn_vk">Вконтакте</span>
        </li>
    </ul>
    <a href="#" class="social__tweeter">tweeter</a>
    <a href="#" class="social__rss">rss</a>

    <ul class="social__content">
        <li class="social__content-item">
            <div class="fb-like-box" data-href="http://www.facebook.com/platform" data-border-color="#ffffff" data-width="1833" data-show-faces="true" data-stream="false" data-header="false"></div>
        </li>
        <li class="social__content-item">
            <!-- VK Widget -->
            <script type="text/javascript" src="//vk.com/js/api/openapi.js?75"></script>
            <div id="vk_groups"></div>
            <script type="text/javascript">
                VK.Widgets.Group("vk_groups", {mode: 0, width: "1833", height: "258"}, 20003922);
            </script>
            <!-- V/K Widget -->
        </li>
    </ul>
</div>
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
        <div class="footer__copyright">&copy; 2012 «<span class="footer__copyright-item">Wonderlex</span>»</div>

        <!-- main-menu -->
        <nav class="main-menu main-menu_footer">
            <ol class="main-menu__layout">
                <li class="main-menu__item"><a class="main-menu__lnk main-menu__lnk_privacy" href="php/show-privacy.php">Правила конфиденциальности</a></li>
                <li class="main-menu__item"><a class="main-menu__lnk" href="php/show-privacy.php">пользовательское соглашение</a></li>
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