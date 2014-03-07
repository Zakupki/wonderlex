$(document).ready(function() {
$(function(){
 if($.browser.msie && $.browser.version<8)
  $('.head').after(
   '<div id="ie6detect"><h2>Пожалуйста, обновите ваш браузер</h2><p>Веб-сервис для профессионалов в различных жанрах cовременного<br/>изобразительного искусства.</p><ul><li><a class="chrome" href="http://www.google.ru/chrome">Chrome</a></li><li><a class="ie" href="http://www.microsoft.com/rus/windows/internet-explorer/">Internet Explorer</a></li><li><a class="ff" href="http://www.mozilla-europe.org/ru/firefox/">Firefox</a></li></ul></div>'
  );
  $('section, footer, .contacts, .logo a img').remove()
  $('.logo').addClass("logofix")
  $('.logo a, .lang, .social a').addClass("pngfix")
});
}); 
