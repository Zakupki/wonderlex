<?php

require_once 'modules/base/controllers/Base_Controller.php';
require_once 'modules/main/models/Geo.php';
require_once 'modules/main/models/Catalog.php';
require_once 'modules/main/models/Author.php';
require_once 'modules/main/models/Reccount.php';
require_once 'modules/shop/models/Design.php';
require_once 'modules/shop/models/Favourites.php';
require_once 'modules/shop/widgets/Widget.php';
require_once 'modules/main/models/Operation.php';

Class Index_Controller Extends Base_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
		    
			parent::__construct($registry);
            
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->Geo=new Geo;
            $this->Reccount=new Reccount;
			$this->countrylist=$this->Geo->getCountries();
		}

        function indexAction() {
           if(in_array($_SERVER['REMOTE_ADDR'],tools::allowed_ip()) && 1==2)
            self::newAction();
           else{               
            $this->cache=cache::init();
            //$this->cache->set('ru_main_sites',true,false,-1);
            if($data=$this->cache->get('ru_main_sites')){
			    $this->view->renderLayout('layout', $data);
			}else{
    			$this->sites=$this->Reccount->getSiteStr(1);
                $this->content =$this->view->AddView('index2', $this);
                $this->citations=$this->Reccount->getCitationStr(1);
                $this->slides =$this->view->AddView('slides', $this); 
                $this->cache->set('ru_main_sites', $this,false,60*60*12);
                $this->view->renderLayout('layout', $this);
			}
            die('error');
           }
	    }

		function newAction() {
			$this->Catalog=new Catalog($this->registry);
			$this->Author=new Author($this->registry);
            $this->products=$this->Catalog->getProducts();
			$this->authors=$this->Author->getAuthors(array('start'=>0,'take'=>30));
			$this->content =$this->view->AddView('index', $this);
			$this->view->renderLayout('index', $this);
	    }
        function aboutAction() {
            $this->styles=array('about');
            $this->Author=new Author;
            $this->citations=$this->Reccount->getCitationStr(1);
            $this->authors=$this->Author->getAuthors(array('start'=>0,'take'=>10));
            $this->content =$this->view->AddView('about', $this);
            $this->view->renderLayout('index', $this);
        }
		function testAction() {
			//tools::print_r($_SESSION['User']);
			
									 $this->Catalog=new Catalog;
						$this->products=$this->Catalog->getProductGallery();
						echo $this->Catalog->getProductsCount();
						echo '<br>';
						$db=db::init();
						
						
						foreach($this->products as $pr){
							$file=null;	
							$file=getimagesize($_SERVER['DOCUMENT_ROOT'].$pr['url']);
							
						
							$db->exec('UPDATE z_gallery SET 
												width='.tools::int($file[0]).',
												height='.tools::int($file[1]).'
												WHERE id='.$pr['id'].'');
							
							
							echo $_SERVER['DOCUMENT_ROOT'].$pr['url'].' - '.$file[0].' РЅР° '.$file[1];
							echo '<br>';
								
							//echo '<img src="'.$pr['url'].'"/><br>';
						}
			
	    }
		
        function registrationAction() {        
        $lang = $_GET[ 'lang' ];
        
        $json_data = '{ "html": "
            <div class=\"registration\">
                <form class=\"login\" action=\"\/user\/register\/\" novalidate=\"novalidate\" data-empty=\"заполните<br \/> поле\"  data-mail=\"введите<br \/> e-mail\">
                    <fieldset class=\"login__layout\">
                        <label class=\"login__label login__label_name\" for=\"input_name\">Имя</label>
                        <input type=\"text\" class=\"login__input\" id=\"input_name\" name=\"input_name\" required=\"required\" placeholder=\"Имя\">
                    </fieldset>
                    <fieldset class=\"login__layout\">
                        <label class=\"login__label login__label_mail\" for=\"input_login\">Логин</label>
                        <input type=\"email\" class=\"login__input email\" id=\"input_login\" name=\"input_login\" required=\"required\" placeholder=\"ВАШ E-MAIL\">
                    </fieldset>
                    <fieldset class=\"login__layout\">
                        <label class=\"login__label login__label_password\" for=\"input_password\">Пароль</label>
                        <input type=\"password\" class=\"login__input login__input_pass\" id=\"input_password\" name=\"input_password\" required=\"required\" placeholder=\"Пароль\">
                    </fieldset>
                    <fieldset class=\"login__layout\">
                        <label class=\"login__label login__label_password\" for=\"input_password_repeat\">Пароль</label>
                        <input type=\"password\" class=\"login__input login__input_pass\" id=\"input_password_repeat\" name=\"input_password_repeat\" required=\"required\" placeholder=\"повторите пароль\">
                    </fieldset>
                    <div class=\"login-check\"><input type=\"checkbox\" value=\"1\" class=\"niceCheck\" id=\"login__check\" name=\"login__check\" /><label for=\"login__check\">согласен с соглашением</label></div>
                    <fieldset class=\"login__layout\">
                        <input class=\"login__send\" id=\"login__send\"  type=\"submit\" value=\"Зарегистрироваться\" />
                    </fieldset>
                </form>
                <div class=\"registration__aside\">
                    <div class=\"scroll\">
                        <div>
                            <h1>пользовательское соглашение</h1>
                            <p>Мониторинг активности повсеместно оправдывает культурный портрет потребителя,
                                используя опыт предыдущих кампаний. Искусство медиапланирования экономит потребительский
                                целевой трафик, осознавая социальную ответственность бизнеса. Пак-шот консолидирует
                                сублимированный медийный канал, полагаясь на инсайдерскую информацию. В соответствии с
                                законом Ципфа, ребрендинг не так уж очевиден. Информационная связь с потребителем, безусловно,
                                многопланово раскручивает продуктовый ассортимент, используя опыт Мониторинг активности
                                повсеместно оправдывает культурный портрет потребителя, используя опыт предыдущих кампаний.
                                Искусство медиапланирования экономит потребительский целевой трафик, осознавая социальную
                                ответственность бизнеса. Пак-шот консолидирует сублимированный медийный канал, полагаясь на
                                инсайдерскую информацию. В соответствии с законом Ципфа, ребрендинг не так уж очевиден.
                                Информационная связь с потребителем, безусловно, многопланово раскручивает продуктовый
                                ассортимент, используя опыт Мониторинг активности повсеместно оправдывает культурный портрет
                                потребителя, используя опыт предыдущих кампаний. Искусство медиапланирования экономит
                                потребительский целевой трафик, осознавая социальную ответственность бизнеса. Пак-шот
                                консолидирует сублимированный медийный канал, полагаясь на инсайдерскую информацию. В
                                соответствии с законом Ципфа, ребрендинг не так уж очевиден. Информационная связь с
                                потребителем, безусловно, многопланово раскручивает продуктовый ассортимент, используя опыт</p>
                        </div>
                    </div>
                    <a class=\"pdf-btn\" href=\"#\">Скачать pdf</a>
                    <dl class=\"registration__social\">
                        <dt>Войти как пользователь:</dt>
                        <dd><a class=\"facebook\" href=\"\/social\/fbconnect\/\">facebook</a></dd>
                        <!--<dd><a class=\"vk\" href=\"#\">fasebook</a></dd>
                        <dd><a class=\"tweeter\" href=\"#\">fasebook</a></dd>-->
                    </dl>
                </div>
        " }';
        
        
        
        $json_data = str_replace("\r\n",'',$json_data);
        $json_data = str_replace("\n",'',$json_data);
            
        echo $json_data;
        exit;
        }
                
        function registerAction() {
        $subject = "Новая заявка Wonderlex";
		$message = "Имя: ".$_POST['name']."\n\nФамилия: ".$_POST['surname']."\n\nE-mail: ".$_POST['email']."\n\nНомер телефона: ".$_POST['phone']."\n\nСтрана: ".$_POST['country']."\n\nДата рождения: ".$_POST['day'].".".$_POST['month']."".$_POST['year']."\n\nСсылка на работы: ".$_POST['url']."\n\nFacebook: ".$_POST['facebook']."\n\nСообщения: ".$_POST['message']."\n\n";
		
		
		
		$smtp=new smtp;
						$smtp->Connect(SMTP_HOST);
						$smtp->Hello(SMTP_HOST);
						$smtp->Authenticate('info@wonderlex.com', 'wI6VVSks');
						$smtp->Mail('info@wonderlex.com');
						//$smtp->Recipient('dmitriy.bozhok@gmail.com');
						$smtp->Recipient('larisa@atelier.ua');
						$smtp->Recipient('oksana@atelier.ua');
						//$smtp->Recipient('fox@atelier.ua');
						$smtp->Data($message, $subject);
		
		
		
				$greating=$this->Reccount->getGreeting($_POST['mid']);
		
				$subject="Изменение пароля";
				$message="Здравствуйте!\r\nВы успешно изменили пароль для доступа к вашему аккаунту\r\nВаш логин для входа:".$_SESSION['User']['email']."\r\nНовый пароль:".$data['new_password']."";
				$smtp=new smtp;
				$smtp->Connect(SMTP_HOST);
				$smtp->Hello(SMTP_HOST);
				$smtp->Authenticate('info@wonderlex.com', 'wI6VVSks');
				$smtp->Mail('info@wonderlex.com');
				$smtp->Recipient(trim($_POST['email']));
				echo $smtp->Data($smtp->Data($greating['detail_text'], $greating['subject']));	    
		}
		function feedbackAction() {
        $subject = "Обратная связь Wonderlex";
		$message = "Имя: ".$_POST['name']."\n\nE-mail: ".$_POST['email']."\n\nСообщения: ".$_POST['message']."\n\n";
		$smtp=new smtp;
		$smtp->Connect(SMTP_HOST);
		$smtp->Hello(SMTP_HOST);
		$smtp->Authenticate('reactor@reactor-pro.ru', '123qwe123');
		$smtp->Mail('reactor@reactor-pro.ru');
		$smtp->Recipient('info@wonderlex.com');
		$smtp->Recipient('larisa@atelier.ua');
		$smtp->Recipient('oksana@atelier.ua');
		$smtp->Data($message, $subject);
	    }
		function loginformAction() {
$lang = $_GET[ 'lang' ];

$json_data = '{ "html": "
    <form method=\"post\" class=\"login\" action=\"\/user\/login\" data-php=\"\/user\/remindpass\" novalidate=\"novalidate\" data-empty=\"заполните<br \/> поле\"  data-mail=\"введите<br \/> e-mail\">
        <fieldset class=\"login__layout\">
            <label class=\"login__label login__label_mail\" for=\"input_login\">Логин</label>
            <input type=\"email\" class=\"login__input email\" id=\"input_login\" name=\"input_login\" required=\"required\" placeholder=\"ВАШ E-MAIL\">
        </fieldset>
        <fieldset class=\"login__layout\">
            <label class=\"login__label login__label_password\" for=\"input_password\">Пароль</label>
            <input type=\"password\" class=\"login__input login__input_pass\" id=\"input_password\" name=\"input_password\" required=\"required\" placeholder=\"Пароль\">
        </fieldset>
        <fieldset class=\"login__layout\">
            <input class=\"login__send\" id=\"login__send\" type=\"submit\" value=\"Войти\" />
            <input class=\"login__send login__reminder\" id=\"login__reminder\" type=\"button\" value=\"Отправить пароль\" />
        </fieldset>
        <a class=\"login__forgot-pass\" href=\"#\">Забыли пароль?</a>
    </form>
" }';



$json_data = str_replace("\r\n",'',$json_data);
$json_data = str_replace("\n",'',$json_data);
    
echo $json_data;
exit;
		}
		function enAction() {
                $this->sites=$this->Reccount->getSiteStr(2);
                $this->citations=$this->Reccount->getCitationStr(2);
                $this->content =$this->view->AddView('index', $this);
                $this->slides =$this->view->AddView('slides', $this);
				$this->view->renderLayout('layouten', $this);
	    }
        function activateAction(){
            $this->styles=array('about');
            $User=new user;
            if($User->activateUser($_GET['act'])){
                $this->head='Регистрация';
                $this->text='Вы успешно активировали вашу учетную запись';
            }
            else{
                $this->head='Регистрация';
                $this->text='Вы перешли по не работающей ссылке.';
            }

            $this->content =$this->view->AddView('message', $this);
            $this->view->renderLayout('index', $this);
            
        }
		public function getcitiesAction(){
			 if(!tools::isAjaxRequest())
			 $this->registry->get->redirect('/');
			 header('Content-Type: application/json');
			 $this->Geo = new Geo;
			 $this->Geo->getCities($_POST['country']);
		}
		public function popupendAction(){
			$this->Operation=new Operation;
            $this->Operation->updateOperation($_POST);
            
            $xmlStr=base64_decode($_POST['operation_xml']);
            $rec_sign=base64_decode($_POST['signature']);
            $xml = simplexml_load_string($xmlStr);
            $db=db::init();
            $stmt=$db->prepare("INSERT INTO _request (ip,xml,sign) VALUES (?,?,?)");
            $stmt->execute(array($_SERVER['REMOTE_ADDR'],$xmlStr,$rec_sign));
			
			echo $xmlStr;
		}
		function privacyAction(){
			
$privacy = $_GET[ 'privacy' ];

if( $privacy == 1 ){
    $json_data = '{ "html": "
    <div class=\"privasy\">
        <h2 class=\"privasy__title\">правила конфиденциальности</h2>
        <div class=\"scroll scroll-privacy\">
            <div>
                <div class=\"privasy__layout\">
                    <p class=\"privasy__txt\">Бюджет на размещение основан на опыте. В общем, ребрендинг позитивно специфицирует
                        конструктивный опрос, оптимизируя бюджеты. Соц-дем характеристика аудитории, отбрасывая подробности,
                        стабилизирует эмпирический рекламный бриф, учитывая результат предыдущих медиа-кампаний. Таргетирование
                        конструктивно.</p>
                    <p class=\"privasy__txt\">Опрос, анализируя результаты рекламной кампании, спонтанно переворачивает побочный PR-эффект, размещаясь
                        во всех медиа. Правда, специалисты отмечают, что продукт раскручивает сублимированный план размещения,
                        учитывая современные тенденции. Пак-шот нетривиален. Рекламный клаттер пока плохо восстанавливает
                        конвергентный инвестиционный продукт, </p>
                    <h2 class=\"privasy__sub-title\">пункт 1.1.</h2>
                    <p class=\"privasy__txt\">Рекламный клаттер абстрактен. Изменение глобальной стратегии, как принято считать,
                        амбивалентно. Такое понимание ситуации восходит к Эл Райс, при этом перераспределение бюджета изящно
                        синхронизирует комплексный фактор коммуникации, используя опыт предыдущих кампаний. Такое понимание
                        ситуации восходит к Эл Райс, при этом социальный статус спорадически программирует креативный целевой
                        сегмент рынка, полагаясь на инсайдерскую информацию. Личность топ менеджера упорядочивает стратегический
                        медиамикс, осознавая социальную ответственность бизнеса.</p>
                    <p class=\"privasy__txt\">Повышение жизненных стандартов, как следует из вышесказанного, недостижимо.
                        Несмотря на сложности, маркетинговая </p>
                    <h2 class=\"privasy__sub-title\">пункт 1.1.</h2>
                    <p class=\"privasy__txt\">Рекламный клаттер абстрактен. Изменение глобальной стратегии, как принято считать,
                        амбивалентно. Такое понимание ситуации восходит к Эл Райс, при этом перераспределение бюджета изящно
                        синхронизирует комплексный фактор коммуникации, используя опыт предыдущих кампаний. Такое понимание
                        ситуации восходит к Эл Райс, при этом социальный статус спорадически программирует креативный целевой
                        сегмент рынка, полагаясь на инсайдерскую информацию. Личность топ менеджера упорядочивает стратегический
                        медиамикс, осознавая социальную ответственность бизнеса.</p>
                    <p class=\"privasy__txt\">Повышение жизненных стандартов, как следует из вышесказанного, недостижимо.
                        Несмотря на сложности, маркетинговая </p>
                </div>
            </div>
        </div>
        <a href=\"#\" class=\"pdf-btn\">Скачать PDF</a>
    </div>
    " }';
} else {
    $json_data = '{ "html": "
<div class=\"privasy\">
        <h2 class=\"privasy__title privasy__title_empty\">Content</h2>
        <div class=\"scroll scroll-privacy\">
            <div>
                <div class=\"privasy__layout\">
                    <p class=\"privasy__txt\">Бюджет на размещение основан на опыте. В общем, ребрендинг позитивно специфицирует
                        конструктивный опрос, оптимизируя бюджеты. Соц-дем характеристика аудитории, отбрасывая подробности,
                        стабилизирует эмпирический рекламный бриф, учитывая результат предыдущих медиа-кампаний. Таргетирование
                        конструктивно.</p>
                    <p class=\"privasy__txt\">Опрос, анализируя результаты рекламной кампании, спонтанно переворачивает побочный PR-эффект, размещаясь
                        во всех медиа. Правда, специалисты отмечают, что продукт раскручивает сублимированный план размещения,
                        учитывая современные тенденции. Пак-шот нетривиален. Рекламный клаттер пока плохо восстанавливает
                        конвергентный инвестиционный продукт, </p>
                    <h2 class=\"privasy__sub-title\">пункт 1.1.</h2>
                    <p class=\"privasy__txt\">Рекламный клаттер абстрактен. Изменение глобальной стратегии, как принято считать,
                        амбивалентно. Такое понимание ситуации восходит к Эл Райс, при этом перераспределение бюджета изящно
                        синхронизирует комплексный фактор коммуникации, используя опыт предыдущих кампаний. Такое понимание
                        ситуации восходит к Эл Райс, при этом социальный статус спорадически программирует креативный целевой
                        сегмент рынка, полагаясь на инсайдерскую информацию. Личность топ менеджера упорядочивает стратегический
                        медиамикс, осознавая социальную ответственность бизнеса.</p>
                    <p class=\"privasy__txt\">Повышение жизненных стандартов, как следует из вышесказанного, недостижимо.
                        Несмотря на сложности, маркетинговая </p>
                    <h2 class=\"privasy__sub-title\">пункт 1.1.</h2>
                    <p class=\"privasy__txt\">Рекламный клаттер абстрактен. Изменение глобальной стратегии, как принято считать,
                        амбивалентно. Такое понимание ситуации восходит к Эл Райс, при этом перераспределение бюджета изящно
                        синхронизирует комплексный фактор коммуникации, используя опыт предыдущих кампаний. Такое понимание
                        ситуации восходит к Эл Райс, при этом социальный статус спорадически программирует креативный целевой
                        сегмент рынка, полагаясь на инсайдерскую информацию. Личность топ менеджера упорядочивает стратегический
                        медиамикс, осознавая социальную ответственность бизнеса.</p>
                    <p class=\"privasy__txt\">Повышение жизненных стандартов, как следует из вышесказанного, недостижимо.
                        Несмотря на сложности, маркетинговая </p>
                </div>
            </div>
        </div>
        </div>
    " }';
}



$json_data = str_replace("\r\n",'',$json_data);
$json_data = str_replace("\n",'',$json_data);
    
echo $json_data;
exit;
		}
        public function getsearchAction(){
            $lang = $_GET[ 'lang' ];
        
        $json_data = '{ "html": "
                <form class=\"search-form\" action=\"\/search\/\" novalidate=\"novalidate\" data-empty=\"заполните<br \/> поле\">
                    <div class=\"search-form__item\">
                        <label class=\"search-form__label\">поиск:</label>
                        <div class=\"switch\">
                            <div class=\"switch__txt switch__txt_active\">по работам</div>
                            <div class=\"switch__slider\"><div></div></div>
                            <div class=\"switch__txt\">по авторам</div>
                            <input class=\"switch__radio\" type=\"radio\" name=\"search\" value=\"work\" checked=\"checked\">
                            <input class=\"switch__radio\" type=\"radio\" name=\"search\" value=\"authos\">
                        </div>
                    </div>
                    <div class=\"search-form__item\">
                        <input type=\"search\" id=\"search-form__search-txt\" name=\"q\" class=\"search-form__search-txt\" placeholder=\"поиск\">
                    </div>
                    <div class=\"search-form__txt\">Для поиска нажмите Enter</div>
                </form>
        
        " }';
        
        
        
        $json_data = str_replace("\r\n",'',$json_data);
        $json_data = str_replace("\n",'',$json_data);
            
        echo $json_data;
        exit;
}
    public function searchAction(){
    $this->Catalog=new Catalog;
    $this->Author=new Author;
    if(isset($_GET['q']))
    $q=$_GET['q'];
    
    if(isset($_GET['search']))
    if($_GET['search']=='work'){
        $this->products=$this->Catalog->getProducts(array('q'=>$q));
        $this->content =$this->view->AddView('search', $this);
    }elseif($_GET['search']=='authos'){
        $this->styles=array('authors-list');
        $this->authors=$this->Author->getAuthors(array('q'=>$q));
        $this->content =$this->view->AddView('searchauthors', $this);    
    }
    if(count($this->products['products'])<1 && count($this->authors)<1){
    $this->content =$this->view->AddView('searchnf', $this); 
    $this->nosocial=true;
    }

    $this->view->renderLayout('index', $this);
    }
    public function rssAction(){
        require_once 'classes/rssgenerator.php';
        
        $this->Catalog=new Catalog;
        $this->products=$this->Catalog->getProducts();
        
        $rss_channel = new rssGenerator_channel();
        $rss_channel->atomLinkHref = 'http://wonderlex.com/rss/';
        $rss_channel->title = 'wonderlex.com';
        $rss_channel->link = 'http://wonderlex.com/rss/';
        $rss_channel->description = 'Новые работы wonderlex.com';
        $rss_channel->language = 'ru-ru';
        $rss_channel->generator = 'PHP RSS Feed Generator';
        $rss_channel->managingEditor = 'info@wonderlex.com (Vladymyr Sokolivsky)';
        $rss_channel->webMaster = 'bozhok@ukr.net (Dmitriy Bozhok)';
        
        foreach($this->products['products'] as $product){
        $item = new rssGenerator_item();
        $item->title = $product['name'];
        $item->description = preg_replace("/&#?[a-z0-9]+;/i","",strip_tags($product['detail_text']));
        $item->link = 'http://wonderlex.com/product/'.$product['itemid'].'/';
        $item->guid = 'http://wonderlex.com/product/'.$product['itemid'].'/';
        $item->pubDate = gmdate(DATE_RSS, strtotime($product['date_create']));
        $rss_channel->items[] = $item;
        }
        
        $rss_feed = new rssGenerator_rss();
        $rss_feed->encoding = 'UTF-8';
        $rss_feed->version = '2.0';
        header('Content-Type: text/xml');
        echo $rss_feed->createFeed($rss_channel);
                
    }
    public function messageAction(){
        $this->view->renderLayout('test', $this);
    }
}
?>