var pinit=function(q,r,s,l){var a=q[l.k]={w:q,d:r,n:s,a:l,f:{callback:[],doNotTrack:function(){var b=!1;"1"===a.n.doNotTrack||"yes"===a.n.doNotTrack||a.w.external&&"function"===typeof a.w.external.msTrackingProtectionEnabled&&a.w.external.msTrackingProtectionEnabled()?(a.f.log("Client has requested Do Not Track."),b=!0):a.f.log("No request for Do Not Track found.");return b},get:function(a,c){return"string"===typeof a[c]?a[c]:a.getAttribute(c)},getData:function(b,c){c=a.a.dataAttributePrefix+c;return a.f.get(b,
c)},set:function(a,c,d){"string"===typeof a[c]?a[c]=d:a.setAttribute(c,d)},make:function(b){var c=!1,d,e;for(d in b)if(b[d].hasOwnProperty){c=a.d.createElement(d);for(e in b[d])b[d][e].hasOwnProperty&&"string"===typeof b[d][e]&&a.f.set(c,e,b[d][e]);break}return c},kill:function(b){"string"===typeof b&&(b=a.d.getElementById(b));b&&b.parentNode&&b.parentNode.removeChild(b)},replace:function(b,c){b.parentNode.insertBefore(c,b);a.f.kill(b)},listen:function(b,c,d){"undefined"!==typeof a.w.addEventListener?
b.addEventListener(c,d,!1):"undefined"!==typeof a.w.attachEvent&&b.attachEvent("on"+c,d)},call:function(b,c){var d,e,f="?";d=a.f.callback.length;e=a.a.k+".f.callback["+d+"]";a.f.callback[d]=function(b){c(b,d);a.f.kill(e)};b.match(/\?/)&&(f="&");a.d.b.appendChild(a.f.make({SCRIPT:{id:e,type:"text/javascript",charset:"utf-8",src:b+f+"callback="+e}}))},log:function(b){a.v.config.debug&&a.w.console&&a.w.console.log(b)},presentation:function(){var b,c,d;b=a.f.make({STYLE:{type:"text/css"}});c=a.a.cdn[a.w.location.protocol]||
a.a.cdn["http:"];d=a.a.rules.join("\n");d=d.replace(/\._/g,"."+l.k+"_");d=d.replace(/_cdn/g,c);d=d.replace(/_rez/g,a.v.resolution);b.styleSheet?b.styleSheet.cssText=d:b.appendChild(a.d.createTextNode(d));a.d.h?a.d.h.appendChild(b):a.d.b.appendChild(b)},click:function(b){b=b||a.w.event;if((b=b.target?3===b.target.nodeType?b.target.parentNode:b.target:b.srcElement)&&b!==a.d.b){a.f.getData(b,"aha")||(b=b.parentNode);var c=a.f.getData(b,"aha");c&&b.href.match(/pinterest/)&&(b.className.match(/hazClick/)||
(b.className=b.className+" "+a.a.k+"_hazClick"),a.f.aha("&type="+c+"&href="+encodeURIComponent(b.href)))}},behavior:function(){a.f.listen(a.d.b,"click",a.f.click)},getPinCount:function(b){query="?url="+b+"&ref="+encodeURIComponent(a.v.here)+"&source="+a.a.countSource;a.f.call(a.a.endpoint.count+query,a.f.ping.count)},prettyPinCount:function(a){999<a&&(a=1E6>a?~~(a/1E3)+"K+":1E9>a?~~(a/1E6)+"M+":"++");return a},tile:function(b,c){b.style.display="block";var d=a.a.tile.scale.height,e=a.a.tile.scale.width,
f=a.f.getData(b,"scale-height");f&&f>=a.a.tile.scale.minHeight&&(d=parseInt(f));if((f=a.f.getData(b,"scale-width"))&&f>=a.a.tile.scale.minWidth)e=parseInt(f);f=a.f.getData(b,"board-width")||b.offsetWidth;f>b.offsetWidth&&(f=b.offsetWidth);f=Math.floor(f/(e+a.a.tile.style.margin));f>a.a.tile.maxColumns&&(f=a.a.tile.maxColumns);if(f<a.a.tile.minColumns)return!1;var g=a.f.make({SPAN:{className:a.a.k+"_embed_board_bd"}});g.style.height=d+"px";a.v.renderedWidth=f*(e+a.a.tile.style.margin)-a.a.tile.style.margin;
g.style.width=a.v.renderedWidth+"px";for(var h=0,m=[],k=0,l=c.length;k<l;k+=1){var i=a.f.make({A:{className:a.a.k+"_embed_board_th",target:"_blank",href:b.href}});a.f.set(i,a.a.dataAttributePrefix+"aha","embed_board");var j=c[k].image_medium_size_pixels.height*(e/c[k].image_medium_size_pixels.width),p=e,n=a.f.make({IMG:{src:c[k].image_medium_url,height:j,width:p,className:a.a.k+"_embed_board_img"}});n.style.height=j+"px";n.style.width=p+"px";n.style.marginTop=0-j/a.a.tile.style.margin+"px";j>d&&(j=
d);i.appendChild(n);i.style.height=j+"px";i.style.width=p+"px";m[h]||(m[h]=0);i.style.top=m[h]+"px";i.style.left=h*(e+a.a.tile.style.margin)+"px";m[h]=m[h]+j+a.a.tile.style.margin;i.appendChild(n);g.appendChild(i);h=(h+1)%f}return g},makeFooter:function(b,c){b=a.f.make({A:{className:a.a.k+"_embed_board_ft",href:b.href,target:"_blank"}});a.v.renderedWidth>a.a.tile.minWidthToShowAuxText&&(b.innerHTML="See On");a.f.set(b,a.a.dataAttributePrefix+"aha",c);c=a.f.make({SPAN:{className:a.a.k+"_embed_board_ft_logo"}});
b.appendChild(c);return b},cssHook:function(b,c){if(b=a.f.getData(b,"css-hook"))c.className=c.className+" "+b},ping:{count:function(b,c){if(c=a.d.getElementById(a.a.k+"_pin_count_"+c)){a.f.log("API replied with count: "+b.count);var d=c.parentNode,e=a.f.getData(d,"config");0===b.count&&("above"===e?(a.f.log("Rendering zero count above."),c.className=a.a.k+"_pin_it_button_count pin-it-button-count",c.appendChild(a.d.createTextNode("0"))):a.f.log("Zero pin count not rendered to the side."));0<b.count&&
(a.f.log("Got "+b.count+" pins for this page."),e=a.f.getData(d,"config"),"above"===e||"beside"===e?(a.f.log("Rendering pin count "+e),c.className=a.a.k+"_pin_it_button_count pin-it-button-count",c.appendChild(a.d.createTextNode(a.f.prettyPinCount(b.count)))):a.f.log("No valid pin count position specified; not rendering."));a.f.cssHook(d,c)}else a.f.log("Pin It button container not found.")},pin:function(b,c){if((c=a.d.getElementById(a.a.k+"_"+c))&&b.data&&b.data[0]){a.f.log("API replied with a pin");
var d=a.f.make({SPAN:{className:a.a.k+"_embed_pin"}});"plain"!==a.v.config.style&&(d.className=d.className+" "+a.a.k+"_fancy");var e=a.f.make({A:{className:a.a.k+"_embed_pin_link",href:"http://pinterest.com/pin/"+b.data[0].id,target:"_blank"}}),f=a.f.make({IMG:{className:a.a.k+"_embed_pin_img",nopin:"true",src:b.data[0].image_medium_url}});e.appendChild(f);a.f.set(e,a.a.dataAttributePrefix+"aha","embed_pin");d.appendChild(e);b.data[0].attribution&&(e=a.f.make({SPAN:{className:a.a.k+"_embed_pin_attrib"}}),
e.appendChild(a.f.make({IMG:{className:a.a.k+"_embed_pin_attrib_icon",src:b.data[0].attribution.provider_favicon_url.replace(/\/api/,"")}})),e.appendChild(a.d.createTextNode("by ")),e.appendChild(a.f.make({A:{className:a.a.k+"_embed_pin_attrib_author",innerHTML:b.data[0].attribution.author_name,href:b.data[0].attribution.author_url,target:"_blank"}})),d.appendChild(e));d.appendChild(a.f.make({SPAN:{className:a.a.k+"_embed_pin_description",innerHTML:b.data[0].description||""}}));a.f.cssHook(c,d);a.f.replace(c,
d)}},user:function(b,c){if((c=a.d.getElementById(a.a.k+"_"+c))&&b.data&&b.data.pins&&b.data.pins.length){a.f.log("API replied with a user");a.f.getData(c,"config");var d=a.f.make({SPAN:{className:a.a.k+"_embed_board"}});"plain"!==a.v.config.style&&(d.className=d.className+" "+a.a.k+"_fancy");var e=a.f.make({SPAN:{className:a.a.k+"_embed_board_hd"}}),f=a.f.make({A:{aha:"embed_user",className:a.a.k+"_embed_board_title",innerHTML:b.data.user.full_name,target:"_blank",href:c.href}});e.appendChild(f);
d.appendChild(e);if(b=a.f.tile(c,b.data.pins))d.appendChild(b),c.href+="pins/",d.appendChild(a.f.makeFooter(c,"embed_user")),a.f.cssHook(c,d),a.f.replace(c,d)}},board:function(b,c){if((c=a.d.getElementById(a.a.k+"_"+c))&&b.data&&b.data.pins&&b.data.pins.length){a.f.log("API replied with a group of pins");a.f.getData(c,"config");var d=a.f.make({SPAN:{className:a.a.k+"_embed_board"}});"plain"!==a.v.config.style&&(d.className=d.className+" "+a.a.k+"_fancy");var e=a.f.tile(c,b.data.pins),f=a.f.make({SPAN:{className:a.a.k+
"_embed_board_hd"}}),g=a.f.make({A:{aha:"embed_board",className:a.a.k+"_embed_board_name",innerHTML:b.data.board.name,target:"_blank",href:c.href}});f.appendChild(g);a.v.renderedWidth>a.a.tile.minWidthToShowAuxText?(b=a.f.make({A:{aha:"embed_board",className:a.a.k+"_embed_board_author",innerHTML:b.data.user.full_name,target:"_blank",href:c.href}}),f.appendChild(b)):g.className=a.a.k+"_embed_board_title";d.appendChild(f);e&&(d.appendChild(e),d.appendChild(a.f.makeFooter(c,"embed_board")),a.f.cssHook(c,
d),a.f.replace(c,d))}}},render:{buttonBookmark:function(b){a.f.log("build bookmarklet button");var c=a.f.make({A:{href:b.href,className:a.a.k+"_pin_it_button pin-it-button"}});a.f.set(c,a.a.dataAttributePrefix+"aha","button_pinit");var d=a.f.getData(b,"config");!0===a.a.config.pinItCountPosition[d]?(a.f.set(c,a.a.dataAttributePrefix+"config",d),c.className=c.className+" "+a.a.k+"_pin_it_"+d):c.className=c.className+" "+a.a.k+"_pin_it_none";a.f.getPinCount(encodeURIComponent(a.v.here));c.onclick=function(){a.v.firstScript.parentNode.insertBefore(a.f.make({SCRIPT:{type:"text/javascript",
charset:"utf-8",src:a.a.endpoint.bookmark+"?r="+99999999*Math.random()}}),a.v.firstScript);return!1};d=a.f.make({SPAN:{className:a.a.k+"_hidden ",id:a.a.k+"_pin_count_"+a.f.callback.length,innerHTML:"<i></i>"}});c.appendChild(d);a.f.replace(b,c)},buttonPin:function(b){a.f.log("build Pin It button");var c=a.f.make({A:{href:b.href,className:a.a.k+"_pin_it_button pin-it-button"}});a.f.set(c,a.a.dataAttributePrefix+"aha","button_pinit");var d=a.f.getData(b,"config");!0===a.a.config.pinItCountPosition[d]?
(a.f.set(c,a.a.dataAttributePrefix+"config",d),c.className=c.className+" "+a.a.k+"_pin_it_"+d):c.className=c.className+" "+a.a.k+"_pin_it_none";c.onclick=function(){a.w.open(this.href,"pin"+(new Date).getTime(),a.a.pop);return!1};d=b.href.split("url=");if(d[1]){var d=d[1].split("&")[0],e=a.f.make({SPAN:{className:a.a.k+"_hidden pin-it-button-count",id:a.a.k+"_pin_count_"+a.f.callback.length,innerHTML:"<i></i>"}});c.appendChild(e);a.f.getPinCount(d);a.f.replace(b,c)}},buttonFollow:function(b){a.f.log("build follow button");
if(b.href.split("/")[3]){a.f.getData(b,"config");var c=a.f.make({A:{target:"_pinterest",href:b.href,innerHTML:b.innerHTML,className:a.a.k+"_follow_me_button"}});c.appendChild(a.f.make({B:{}}));c.appendChild(a.f.make({I:{}}));a.f.set(c,a.a.dataAttributePrefix+"aha","button_follow");a.f.replace(b,c)}},embedPin:function(b){a.f.log("build embedded pin");(b=b.href.split("/")[4])&&0<parseInt(b)&&a.f.getPinsIn("pin","pins/info/",{pin_ids:b})},embedUser:function(b){a.f.log("build embedded profile");(b=b.href.split("/")[3])&&
a.f.getPinsIn("user",b+"/pins/")},embedBoard:function(b){a.f.log("build embedded board");var c=b.href.split("/")[3],b=b.href.split("/")[4];c&&b&&a.f.getPinsIn("board",c+"/"+b+"/pins/")}},getPinsIn:function(b,c,d){var e="",f="?",g;for(g in d)d[g].hasOwnProperty&&(e=e+f+g+"="+d[g],f="&");a.f.call(a.a.endpoint[b]+c+e,a.f.ping[b])},build:function(b){if("object"!==typeof b||null===b||!b.parentNode)b=a.d;var c=b.getElementsByTagName("A"),d,e=[];d=0;for(b=c.length;d<b;d+=1)e.push(c[d]);d=0;for(b=e.length;d<
b;d+=1)if(e[d].href&&e[d].href.match(a.a.myDomain)){c=a.f.getData(e[d],"do");if(!c&&e[d].href.match(/pin\/create\/button/)){var c="buttonPin",f=a.f.get(e[d],"count-layout"),g="none";"vertical"===f&&(g="above");"horizontal"===f&&(g="beside");a.f.set(e[d],"data-pin-config",g)}"function"===typeof a.f.render[c]&&(e[d].id=a.a.k+"_"+a.f.callback.length,a.f.render[c](e[d]))}},config:function(){var b=a.d.getElementsByTagName("SCRIPT"),c,d,e=b.length;d=!1;a.v.firstScript=b[0];for(c=0;c<e;c+=1)if(a.a.myScript&&
b[c]&&b[c].src&&b[c].src.match(a.a.myScript)){if(!1===d){for(d=0;d<a.a.configParam.length;d+=1)a.v.config[a.a.configParam[d]]=a.f.get(b[c],a.a.dataAttributePrefix+a.a.configParam[d]);d=!0}a.f.kill(b[c])}1===e&&(a.v.firstScript=a.f.make({SCRIPT:{}}),a.d.b.appendChild(a.v.firstScript));"string"===typeof a.v.config.build&&(a.w[a.v.config.build]=function(b){a.f.build(b)});!0===a.a.doNotTrack||"string"===typeof a.v.config["do-not-track"]||a.f.doNotTrack()?a.v.aha=!1:(a.v.trackUrl=a.a.endpoint.track+"?r="+
999999*Math.random(),a.v.aha=a.f.make({IFRAME:{src:a.v.trackUrl,height:"0",width:"0",frameborder:"0"}}),a.v.aha.style.position="absolute",a.v.aha.style.bottom="-1px",a.v.aha.style.left="-1px",a.d.b.appendChild(a.v.aha),a.w.setTimeout(function(){a.f.aha("&type=pidget")},500))},aha:function(b){if(a.v.aha){var c=a.v.trackUrl+"#via="+encodeURIComponent(a.v.here);b&&(c+=b);a.v.aha.src=c}},init:function(){a.d.b=a.d.getElementsByTagName("BODY")[0];a.d.h=a.d.getElementsByTagName("HEAD")[0];a.v={resolution:1,
here:a.d.URL.split("#")[0],config:{}};a.w.devicePixelRatio&&2<=a.w.devicePixelRatio&&(a.v.resolution=2);a.f.config();a.f.build();a.f.presentation();a.f.behavior()}}};a.f.init();return a.f}(window,document,navigator,{doNotTrack:!0,k:"PIN_"+(new Date).getTime(),myDomain:/^https?:\/\/pinterest\.com\//,myScript:/pinit.*?\.js$/,endpoint:{bookmark:"//assets.pinterest.com/js/pinmarklet.js",count:"//partners-api.pinterest.com/v1/urls/count.json",pin:"//api.pinterest.com/v3/pidgets/",board:"//api.pinterest.com/v3/pidgets/boards/",
user:"//api.pinterest.com/v3/pidgets/users/",track:"//assets.pinterest.com/pidget.html"},config:{pinItCountPosition:{none:!0,above:!0,beside:!0}},countSource:6,dataAttributePrefix:"data-pin-",configParam:["build","do-not-track","debug","style"],pop:"status=no,resizable=yes,scrollbars=yes,personalbar=no,directories=no,location=no,toolbar=no,menubar=no,width=632,height=270,left=0,top=0",cdn:{"https:":"https://a248.e.akamai.net/passets.pinterest.com.s3.amazonaws.com","http:":"http://passets-cdn.pinterest.com"},
tile:{scale:{minWidth:60,minHeight:60,width:92,height:175},minWidthToShowAuxText:150,minContentWidth:120,minColumns:1,maxColumns:6,style:{margin:2,padding:10}},rules:["a._pin_it_button {  background-image: url(_cdn/images/pidgets/bps_rez.png); background-repeat: none; background-size: 40px 60px; display: inline-block; height: 20px; margin: 0; position: relative; padding: 0; vertical-align: middle; text-decoration: none; width: 40px; background-position: 0 -20px }","a._pin_it_button:hover { background-position: 0 0px}",
"a._pin_it_button:active, a._pin_it_button._hazClick { background-position: 0 -40px}","a._pin_it_button span._pin_it_button_count { position: absolute; color: #777; text-align: center;  }","a._pin_it_above span._pin_it_button_count { background: transparent url(_cdn/images/pidgets/fpa_rez.png) 0 0 no-repeat; background-size: 40px 29px; position: absolute; bottom: 21px; left: 0px; height: 29px; width: 40px; font: 12px Arial, Helvetica, sans-serif; line-height: 24px; }","a._pin_it_beside span._pin_it_button_count, a._pin_it_beside span._pin_it_button_count i { background-color: transparent; background-repeat: no-repeat; background-image: url(_cdn/images/pidgets/fpb_rez.png); }",
"a._pin_it_beside span._pin_it_button_count { padding: 0 3px 0 10px; background-size: 45px 20px; background-position: 0 0; position: absolute; top: 0; left: 41px; height: 20px; font: 10px Arial, Helvetica, sans-serif; line-height: 20px; }","a._pin_it_beside span._pin_it_button_count i { background-position: 100% 0; position: absolute; top: 0; right: -2px; height: 20px; width: 2px; }","a._pin_it_button._pin_it_above { margin-top: 20px; }","a._follow_me_button, a._follow_me_button i { background: transparent url(_cdn/images/pidgets/bfs1.png) 0 0 no-repeat }",
'a._follow_me_button { color: #444; display: inline-block; font: bold normal normal 11px/20px "Helvetica Neue",helvetica,arial,san-serif; height: 20px; margin: 0; padding: 0; position: relative; text-decoration: none; text-indent: 19px; vertical-align: middle;}',"a._follow_me_button:hover { background-position: 0 -20px}","a._follow_me_button:active  { background-position: 0 -40px}","a._follow_me_button b { position: absolute; top: 3px; left: 3px; height: 14px; width: 14px; background-size: 14px 14px; background-image: url(_cdn/images/pidgets/log_rez.png); }",
"a._follow_me_button i { position: absolute; top: 0; right: -4px; height: 20px; width: 4px; background-position: 100% 0px; }","a._follow_me_button:hover i { background-position: 100% -20px;  }","a._follow_me_button:active i { background-position: 100% -40px; }","span._embed_pin { display: inline-block; padding: 15px 0; text-align: center; width: 225px; }","span._embed_pin._fancy { background: #fff; box-shadow: 0 0 3px #aaa; border-radius: 3px; }","span._embed_pin a._embed_pin_link { display: block;  margin: 0 auto 10px; padding: 0; position: relative;  line-height: 0;}",
"span._embed_pin a._embed_pin_link img._embed_pin_img { box-shadow: 0 0 1px #aaa; margin: 0;}","span._embed_pin a._embed_pin_link img._embed_pin_video { left: 50%; margin-left: -25px; margin-top: -25px; position: absolute; top: 50%; }",'span._embed_pin span._embed_pin_attrib, span._embed_pin span._embed_pin_description { display: block; font: normal 11px/14.85px "Helvetica Neue", arial, sans-serif; margin: 0 15px; text-align: left; }',"span._embed_pin span._embed_pin_attrib { color: #ad9c9c; margin-bottom: 10px; height: 16px; line-height: 16px;}",
"span._embed_pin span._embed_pin_attrib a._embed_pin_attrib_author { color: #ad9c9c; font-weight: bold; text-decoration: none; }","span._embed_pin span._embed_pin_attrib a._embed_pin_attrib_author:hover { text-decoration: underline; }","span._embed_pin span._embed_pin_attrib img._embed_pin_attrib_icon { margin: 0 5px 0 0; height: 16px; width: 16px; vertical-align: middle; display: inline-block; }","span._embed_board { display: inline-block; margin: 0; padding:10px 0; position: relative; text-align: center}",
"span._embed_board._fancy { background: #fff; box-shadow: 0 0 3px #aaa; border-radius: 3px; }","span._embed_board span._embed_board_hd { display: block; margin: 0 10px; padding: 0; line-height: 20px; height: 25px; position: relative;  }","span._embed_board span._embed_board_hd a { cursor: pointer; background: inherit; text-decoration: none; width: 48%; white-space: nowrap; position: absolute; top: 0; overflow: hidden;  text-overflow: ellipsis; }","span._embed_board span._embed_board_hd a:hover { text-decoration: none; background: inherit; }",
"span._embed_board span._embed_board_hd a:active { text-decoration: none; background: inherit; }","span._embed_board span._embed_board_hd a._embed_board_title { width: 100%; position: absolute; left: 0; text-align: left; font-family: Georgia; font-size: 16px; color:#2b1e1e;}","span._embed_board span._embed_board_hd a._embed_board_name { position: absolute; left: 0; text-align: left; font-family: Georgia; font-size: 16px; color:#2b1e1e;}","span._embed_board span._embed_board_hd a._embed_board_author { position: absolute; right: 0; text-align: right; font-family: Helvetica; font-size: 11px; color: #746d6a; font-weight: bold;}",
'span._embed_board span._embed_board_hd a._embed_board_author::before { content:"by "; font-weight: normal; }',"span._embed_board span._embed_board_bd { display:block; margin: 0 10px; overflow: hidden; border-radius: 2px; position: relative; }","span._embed_board span._embed_board_bd a._embed_board_th { cursor: pointer; display: inline-block; position: absolute; overflow: hidden; }",'span._embed_board span._embed_board_bd a._embed_board_th::before { position: absolute; content:""; z-index: 2; top: 0; left: 0; right: 0; bottom: 0; box-shadow: inset 0 0 2px #888; }',
"span._embed_board span._embed_board_bd a._embed_board_th img._embed_board_img { position: absolute; top: 50%; left: 0; }","a._embed_board_ft { text-shadow: 0 1px #fff; display: block; text-align: center; border: 1px solid #ccc; margin: 10px 10px 0; height: 31px; line-height: 30px;border-radius: 2px; text-decoration: none; font-family: Helvetica; font-weight: bold; font-size: 13px; color: #746d6a; background: #f4f4f4 url(_cdn/images/pidgets/board_button_link.png) 0 0 repeat-x}","a._embed_board_ft:hover { text-decoration: none; background: #fefefe url(_cdn/images/pidgets/board_button_hover.png) 0 0 repeat-x}",
"a._embed_board_ft:active { text-decoration: none; background: #e4e4e4 url(_cdn/images/pidgets/board_button_active.png) 0 0 repeat-x}","a._embed_board_ft span._embed_board_ft_logo { vertical-align: top; display: inline-block; margin-left: 2px; height: 30px; width: 66px; background: transparent url(_cdn/images/pidgets/board_button_logo.png) 50% 48% no-repeat; }","._hidden { display:none; }"]});