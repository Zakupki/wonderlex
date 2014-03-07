<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Wonderlex</title>
		<link rel="stylesheet" href="/css/main/reset.css">
		<link rel="stylesheet" href="/css/main/style.css">
		<link rel="icon" href="/img/main/favicon2.ico">

		<!--[if lt IE 9]>
			<script src="/css/main/html5.js"></script>
		<![endif]-->
        
		<script src="/js/main/lib.js"></script>   
		<script src="/js/main/main.js"></script>   
        
		<!--[if lt IE 8]>
			<script src="/js/main/noie6.js"></script>
		<![endif]-->   
		
		<!-- Slider Kit scripts -->
		<script type="text/javascript" src="/js/main/slider/js/sliderkit/jquery.sliderkit.1.9.pack.js"></script>
		<script type="text/javascript" src="/js/main/slider/js/sliderkit/sliderkit.delaycaptions.1.1.pack.js"></script>
        	
		<!-- Slider Kit styles -->
		<link rel="stylesheet" type="text/css" href="/js/main/slider/css/sliderkit-core.css" media="screen, projection" />
		<link rel="stylesheet" type="text/css" href="/js/main/slider/css/sliderkit-demos.css" media="screen, projection" />
		
		<!-- Slider Kit compatibility -->	
		<!--[if IE 6]><link rel="stylesheet" type="text/css" href="/js/main/slider/css/sliderkit-demos-ie6.css" /><![endif]-->
		<!--[if IE 7]><link rel="stylesheet" type="text/css" href="/js/main/slider/css/sliderkit-demos-ie7.css" /><![endif]-->
		<!--[if IE 8]><link rel="stylesheet" type="text/css" href="/js/main/slider/css/sliderkit-demos-ie8.css" /><![endif]-->
	</head>
	<body>
    
	<!-- WRAPPER -->
		<div class="wrapper">

		<!-- HEADER -->
			<header>
				<div class="head">

				<!-- logo -->
					<div class="logo"><a href=""><img src="/img/main/logo.png"></a></div>
				<!-- / logo -->
                
				<!-- lang -->
					<a href="/" class="lang">Русская версия</a>
				<!-- / lang -->

				<!-- social -->
					<ul class="social">
						<li class="fb"><a href="http://facebook.com/Wonderlex">Facebook</a></li>
						<!--<li class="vk"><a href="">Вконтакте</a></li>-->
						<li class="tw"><a href="https://twitter.com/Wonderlex_com">Twitter</a></li>
					</ul>
				<!-- / social -->

				<!-- contacts -->
					<ul class="contacts">
						<li class="phone">+38 (067) 517 60 14</li>
						<li class="adress">Kiev, Ukraine</li>
						<li class="feedback">
                        
                        	<a name="feedLink" href="#feedLink">Feedback</a>
                            
						<!-- windowFeedback" -->
                        	<div class="window windowFeedback">
                        		<div class="windowCont">
                        			<span class="close"><!-- Закрыть --></span>
                        			<h2>Feedback</h2>
                        			<form action="/feedback/" method="post">
                          			<table>
                          				<tr>
                          					<td class="first">Name</td>
                          					<td><input name="name" type="text" class="inp required"></td>
                          				</tr>
                          				<tr>
                          					<td class="first">E-mail</td>
                          					<td><input name="email" type="text" class="inp required email"></td>
                          				</tr>
                          				<tr>
                          					<td class="first">Message</td>
                          					<td><textarea name="message" class="required"></textarea></td>
                          				</tr>
                          			</table>
                          			<input type="submit" class="send" value="Отправить">
                          		</form>
                        		</div>
                        		<div class="windowCont windowContThanks">
                        			<span class="close"><!-- Закрыть --></span>
                        			<h2>Thank you for your message!</h2>
                        			<p>You will soon get a reply on email.</p>
                        		</div>
                        	</div>
						<!-- / windowFeedback -->
                            
                        </li>
					</ul>
				<!-- / contacts -->
                
					<div class="clear"><!-- clear --></div>
				</div>
			</header>
		<!-- / HEADER -->

		<!-- CONTENT -->
			<section>
				<div class="content">

				<!-- community -->
					<div class="community">
 						<a class="created">&nbsp;&nbsp;&nbsp;Soon</a>
						<h2>Professional art-comunity</h2>
						<p>Lanches Q1 2013.</p>
						<div class="clear"><!-- clear --></div>
					</div>
				<!-- / community -->

				<!-- sites -->
					<div class="sites">
                    
					<!-- join -->
						<div class="join">
                        
                        	<a name="joinToLink" href="#joinToLink" class="joinLink">Join us</a>
                            
						<!-- windowReg -->
                        	<div class="window windowReg">
                        		<div class="windowCont">
                        			<span class="close"><!-- Закрыть --></span>
                        			<h2>Registration</h2>
                        			<form action="/register/" method="post">
									<table>
                        				<tr>
                        					<td class="first">Name</td>
                        					<td><input name="name" type="text" class="inp required"></td>
                        				</tr>
                        				<tr>
                        					<td>Familyname</td>
                        					<td><input name="surname" type="text" class="inp required"></td>
                        				</tr>
                        				<tr>
                        					<td>Phone</td>
                        					<td><input name="phone" type="text" class="inp required"></td>
                        				</tr>
                        				<tr>
                        					<td>E-mail</td>
                        					<td><input name="email" type="text" class="inp required email"></td>
                        				</tr>
                        				<tr>
                        					<td class="first">Country</td>
                        					<td>
                        					 <select name="country" class="country-select">
                          					<? foreach($this->view->countrylist as $country){?>
											 <option value="<?=$country['code'];?>"><?=$country['name_en'];?></option>
                          					 <?}?>
                        					 </select>
                                  </td>
                        				</tr>
                        				<tr>
                        					<td class="first">Date of birth</td>
                        					<td>
                                    <div class="date">
                            					 <select name="day" class="day-select">
                              					 <? for ($i = 1; $i <= 31; $i++) {?>
												 <option value="<?=$i;?>"><?=$i;?></option>
												 <?}?>                              					 
                            					 </select>
                            					 <select name="month" class="month-select">
                              					 <? for ($i = 1; $i <= 12; $i++) {?>
												 <option value="<?=$i;?>"><?=$i;?></option>
												 <?}?>  
                            					 </select>
                            					 <select name="year" class="year-select">
                              					 <? for ($i = 1940; $i <= 2000; $i++) {?>
												 <option value="<?=$i;?>"><?=$i;?></option>
												 <?}?> 
                              					 </select>

                                    </div>
                                  </td>
                        				</tr>
                        				<tr>
                        					<td class="first">Link on forks</td>
                        					<td><input name="url" type="text" class="inp"></td>
                        				</tr>
                        				<tr>
                        					<td class="first">Facebook</td>
                        					<td><input name="facebook" type="text" class="inp facebook"></td>
                        				</tr>
                        				<tr>
                        					<td class="first">Comment</td>
                        					<td><textarea class="comment" name="message"></textarea></td>
                        				</tr>
                        			</table>
                        			<input type="submit" class="send" value="Отправить">
									</form>
                        		</div>
                        		<div class="windowCont windowContThanks">
                        			<span class="close"><!-- Закрыть --></span>
                        			<h2>Thank you for registering!</h2>
                        			<p>We will send you our decision on email.</p>
                        		</div>
                        	</div>
						<!-- / windowReg -->
                        
                        </div>
					<!-- / join -->

					<!-- sitesCont -->
						<div class="sitesCont">
							<h2>Personal sites</h2>
							<p><strong>WONDERLEX</strong>- Is a unique WEB service for professionals from various genres of modern (contemporary) imitative art. </p>
							<p>Individual sites are professionals here, having standard structure and placed on personal users domains.  Authors content and users news automatically lands in WONDERLEX, were content keepers are also moderators and administrators of comments. </p>
							<p>Getting web site master, you receive fully-featured web resource – splendid device for systematical presentation, qualified platform for professional communication and development, and, of course much-needed localization of seek addresses for target audience. And the most important- <strong>we suggest you to get rid of any questions concerning the site refreshment and filling, its support and maintenance! </strong></p>
							<p><strong> Join us! Wonder lex– here!</strong></p>
						</div>
					<!-- / sitesCont -->
                        
					</div>
				<!-- / sites -->
                    
				<!-- slider -->
					<div class="sliderWrap"><div class="sliderWrapCont"><div class="sliderkit photosgallery-captions delaycaptions-01">
                    
					<!-- slider-nav -->
						<div class="sliderkit-nav">
							<div class="leftShadow"><!-- leftShadow --></div>                        
							<div class="sliderkit-nav-clip">
								<ul>
									<? foreach($this->view->sites as $site){?>
                                    <li><a href="#" rel="nofollow" title="[link title]"><img src="<?=$site['preview'];?>" /></a></li>
                                    <?}?>
</ul>
							</div>
							<div class="rightShadow"><!-- rightShadow --></div> 
						</div>
					<!-- / slider-nav -->

					<!-- slides -->
						<ul class="sliderkit-panels">						
							<? foreach($this->view->sites as $site){?>
                            <li class="sliderkit-panel">
								<a href="http://<?=$site['domain'];?>" target="_blank" title="[title]">
                                	<img src="<?=$site['detail'];?>" />
									<span class="sliderkit-panel-textbox">http://<?=$site['domain'];?></span>
									<span class="name"><span class="nameCont"><span><?=$site['name'];?></span> <img src="<?=$site['flag'];?>"><?=$site['country'];?></span></span>
                                </a>
							</li>
                            <?}?>

						</ul>
					<!-- / slides -->
                    
					<!-- slider btns -->
						<div class="sliderkit-btns">
							<div class="sliderkit-btn sliderkit-go-btn sliderkit-go-prev"><a rel="nofollow" href="#" title="Previous photo"><span>Previous photo</span></a></div>
							<div class="sliderkit-btn sliderkit-go-btn sliderkit-go-next"><a rel="nofollow" href="#" title="Next photo"><span>Next photo</span></a></div>
							<div class="nextLoad"><img src="/img/main/load.gif"></div>
						</div>
					<!-- / slider btns -->
                        
					</div></div></div>
				<!-- / slider -->
                    
				</div>
			</section>
		<!-- / CONTENT -->
        
		</div>
	<!-- / WRAPPER -->

	<!-- FOOTER -->
		<footer>
			<div class="footer">
            
			<!-- services -->
				<div class="services"><div class="servicesCont">
					<ul class="servicesList1">
						<li>Fully-featured individual site</li>
						<li>Individual tune</li>
						<li>Customer support</li>
						<li>24 hour support </li>
						<li>Multilanguage</li>
					</ul>
					<ul class="servicesList2">
						<li>Social networks support</li>
						<li>Support and site update</li>
						<li class="item3">Payment service</li>
						<li class="item3">Other...</li>
					</ul>
				</div></div>
			<!-- / services -->

			<!-- footerTop -->
				<div class="footerTop"><div class="footerTopCont">
					<div class="copy">
						<p>© 2012 Wonderlex</p>
					</div>
					<ul class="links">
						<li class="link1"><a target="_blank" href="/pdf/main/en.pdf">Download PDF presentation</a></li>
						<li class="link2"><a href="#feedLink">Feedback</a></li>
					</ul>
				</div></div>
			<!-- / footerTop -->
            
			<!-- footerBott -->
				<div class="footerBott"><div class="footerBottCont">
					<div class="text1">
						<p>Wonderlex - is a unique project, uniting the professional art-community and personal sites of the best representatives from various directions of the modern picturesque art. Personal sites from Wonderlex with personal domain names are the best thing to present modern art, architecture, sculpture, interior-design, digital art and more.  </p>
					</div>
					<div class="text2">
						<p>Personal sites integrated in Wonderlex portal, but they also could have no direct connection with the portal (at will of a site keeper). The portal has the mirror reflection of the site in the form of authors’ profile. Design quality and technical support of Wonderlex - correspond the world standards of the internet (web) projects.</p>
					</div>
					<div class="text3">
						<p>Wonderlex will help you to tell about your art to collectors and fans of the picturesque art from the whole world. Will help you to find like-minded persons, realize business tasks (ideas) and inspire (with new ideas).               </p>
					</div>
                </div></div>
			<!-- / footerBott -->
            
			</div>
		</footer>
	<!-- / FOOTER -->
    
	</body>
</html>
