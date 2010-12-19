(function($){$.fn.styleddropdown=function(){return this.each(function(){var obj=$(this)

obj.find('.field').click(function(){obj.find('.list').fadeIn(400);$(document).keyup(function(event){if(event.keyCode==27){obj.find('.list').fadeOut(400);}});obj.find('.list').hover(function(){},function(){$(this).fadeOut(400);});});obj.find('.list li').click(function(){obj.find('.field').text($(this).html()).css({'background':'#fff','color':'#333'});obj.find('.field-h').val($(this).attr('class'));obj.find('.list').fadeOut(400);});});};

/*

 * jQuery Quovolver v1.0 - http://sandbox.sebnitu.com/jquery/quovolver

 * By Sebastian Nitu - Copyright 2009 - All rights reserved 

 */

$.fn.quovolver=function(speed,delay){if(!speed)speed=500;if(!delay)delay=6000;var quaSpd=(speed*4);if(quaSpd>(delay))delay=quaSpd;var quote=$(this),firstQuo=$(this).filter(':first'),lastQuo=$(this).filter(':last'),wrapElem='<div id="quote_wrap"></div>';$(this).wrapAll(wrapElem);$(this).hide();$(firstQuo).show();$(this).parent().css({height:$(firstQuo).height()});setInterval(function(){if($(lastQuo).is(':visible')){var nextElem=$(firstQuo);var wrapHeight=$(nextElem).height();}else{var nextElem=$(quote).filter(':visible').next();var wrapHeight=$(nextElem).height();}

$(quote).filter(':visible').fadeOut(speed);setTimeout(function(){$(quote).parent().animate({height:wrapHeight},speed);},speed);if($(lastQuo).is(':visible')){setTimeout(function(){$(firstQuo).fadeIn(speed*2);},speed*2);}else{setTimeout(function(){$(nextElem).fadeIn(speed);},speed*2);}},delay);};

/*

 * SimpleModal 1.4.1 - jQuery Plugin

 * http://www.ericmmartin.com/projects/simplemodal/

 * Copyright (c) 2010 Eric Martin (http://twitter.com/ericmmartin)

 * Dual licensed under the MIT and GPL licenses

 * Revision: $Id: jquery.simplemodal.js 261 2010-11-05 21:16:20Z emartin24 $

 */

(function(d){var k=d.browser.msie&&parseInt(d.browser.version)===6&&typeof window.XMLHttpRequest!=="object",m=d.browser.msie&&parseInt(d.browser.version)===7,l=null,f=[];d.modal=function(a,b){return d.modal.impl.init(a,b)};d.modal.close=function(){d.modal.impl.close()};d.modal.focus=function(a){d.modal.impl.focus(a)};d.modal.setContainerDimensions=function(){d.modal.impl.setContainerDimensions()};d.modal.setPosition=function(){d.modal.impl.setPosition()};d.modal.update=function(a,b){d.modal.impl.update(a,

b)};d.fn.modal=function(a){return d.modal.impl.init(this,a)};d.modal.defaults={appendTo:"body",focus:true,opacity:50,overlayId:"simplemodal-overlay",overlayCss:{},containerId:"simplemodal-container",containerCss:{},dataId:"simplemodal-data",dataCss:{},minHeight:null,minWidth:null,maxHeight:null,maxWidth:null,autoResize:false,autoPosition:true,zIndex:1E3,close:true,closeHTML:'<a class="modalCloseImg" title="Close"></a>',closeClass:"simplemodal-close",escClose:true,overlayClose:false,position:null,

persist:false,modal:true,onOpen:null,onShow:null,onClose:null};d.modal.impl={d:{},init:function(a,b){var c=this;if(c.d.data)return false;l=d.browser.msie&&!d.boxModel;c.o=d.extend({},d.modal.defaults,b);c.zIndex=c.o.zIndex;c.occb=false;if(typeof a==="object"){a=a instanceof jQuery?a:d(a);c.d.placeholder=false;if(a.parent().parent().size()>0){a.before(d("<span></span>").attr("id","simplemodal-placeholder").css({display:"none"}));c.d.placeholder=true;c.display=a.css("display");if(!c.o.persist)c.d.orig=

a.clone(true)}}else if(typeof a==="string"||typeof a==="number")a=d("<div></div>").html(a);else{alert("SimpleModal Error: Unsupported data type: "+typeof a);return c}c.create(a);c.open();d.isFunction(c.o.onShow)&&c.o.onShow.apply(c,[c.d]);return c},create:function(a){var b=this;f=b.getDimensions();if(b.o.modal&&k)b.d.iframe=d('<iframe src="javascript:false;"></iframe>').css(d.extend(b.o.iframeCss,{display:"none",opacity:0,position:"fixed",height:f[0],width:f[1],zIndex:b.o.zIndex,top:0,left:0})).appendTo(b.o.appendTo);

b.d.overlay=d("<div></div>").attr("id",b.o.overlayId).addClass("simplemodal-overlay").css(d.extend(b.o.overlayCss,{display:"none",opacity:b.o.opacity/100,height:b.o.modal?f[0]:0,width:b.o.modal?f[1]:0,position:"fixed",left:0,top:0,zIndex:b.o.zIndex+1})).appendTo(b.o.appendTo);b.d.container=d("<div></div>").attr("id",b.o.containerId).addClass("simplemodal-container").css(d.extend(b.o.containerCss,{display:"none",position:"fixed",zIndex:b.o.zIndex+2})).append(b.o.close&&b.o.closeHTML?d(b.o.closeHTML).addClass(b.o.closeClass):

"").appendTo(b.o.appendTo);b.d.wrap=d("<div></div>").attr("tabIndex",-1).addClass("simplemodal-wrap").css({height:"100%",outline:0,width:"100%"}).appendTo(b.d.container);b.d.data=a.attr("id",a.attr("id")||b.o.dataId).addClass("simplemodal-data").css(d.extend(b.o.dataCss,{display:"none"})).appendTo("body");b.setContainerDimensions();b.d.data.appendTo(b.d.wrap);if(k||l)b.fixIE()},bindEvents:function(){var a=this;d("."+a.o.closeClass).bind("click.simplemodal",function(b){b.preventDefault();a.close()});

a.o.modal&&a.o.close&&a.o.overlayClose&&a.d.overlay.bind("click.simplemodal",function(b){b.preventDefault();a.close()});d(document).bind("keydown.simplemodal",function(b){if(a.o.modal&&b.keyCode===9)a.watchTab(b);else if(a.o.close&&a.o.escClose&&b.keyCode===27){b.preventDefault();a.close()}});d(window).bind("resize.simplemodal",function(){f=a.getDimensions();a.o.autoResize?a.setContainerDimensions():a.o.autoPosition&&a.setPosition();if(k||l)a.fixIE();else if(a.o.modal){a.d.iframe&&a.d.iframe.css({height:f[0],

width:f[1]});a.d.overlay.css({height:f[0],width:f[1]})}})},unbindEvents:function(){d("."+this.o.closeClass).unbind("click.simplemodal");d(document).unbind("keydown.simplemodal");d(window).unbind("resize.simplemodal");this.d.overlay.unbind("click.simplemodal")},fixIE:function(){var a=this,b=a.o.position;d.each([a.d.iframe||null,!a.o.modal?null:a.d.overlay,a.d.container],function(c,h){if(h){var g=h[0].style;g.position="absolute";if(c<2){g.removeExpression("height");g.removeExpression("width");g.setExpression("height",

'document.body.scrollHeight > document.body.clientHeight ? document.body.scrollHeight : document.body.clientHeight + "px"');g.setExpression("width",'document.body.scrollWidth > document.body.clientWidth ? document.body.scrollWidth : document.body.clientWidth + "px"')}else{var e;if(b&&b.constructor===Array){c=b[0]?typeof b[0]==="number"?b[0].toString():b[0].replace(/px/,""):h.css("top").replace(/px/,"");c=c.indexOf("%")===-1?c+' + (t = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop) + "px"':

parseInt(c.replace(/%/,""))+' * ((document.documentElement.clientHeight || document.body.clientHeight) / 100) + (t = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop) + "px"';if(b[1]){e=typeof b[1]==="number"?b[1].toString():b[1].replace(/px/,"");e=e.indexOf("%")===-1?e+' + (t = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft) + "px"':parseInt(e.replace(/%/,""))+' * ((document.documentElement.clientWidth || document.body.clientWidth) / 100) + (t = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft) + "px"'}}else{c=

'(document.documentElement.clientHeight || document.body.clientHeight) / 2 - (this.offsetHeight / 2) + (t = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop) + "px"';e='(document.documentElement.clientWidth || document.body.clientWidth) / 2 - (this.offsetWidth / 2) + (t = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft) + "px"'}g.removeExpression("top");g.removeExpression("left");g.setExpression("top",

c);g.setExpression("left",e)}}})},focus:function(a){var b=this;a=a&&d.inArray(a,["first","last"])!==-1?a:"first";var c=d(":input:enabled:visible:"+a,b.d.wrap);setTimeout(function(){c.length>0?c.focus():b.d.wrap.focus()},10)},getDimensions:function(){var a=d(window);return[d.browser.opera&&d.browser.version>"9.5"&&d.fn.jquery<"1.3"||d.browser.opera&&d.browser.version<"9.5"&&d.fn.jquery>"1.2.6"?a[0].innerHeight:a.height(),a.width()]},getVal:function(a,b){return a?typeof a==="number"?a:a==="auto"?0:

a.indexOf("%")>0?parseInt(a.replace(/%/,""))/100*(b==="h"?f[0]:f[1]):parseInt(a.replace(/px/,"")):null},update:function(a,b){var c=this;if(!c.d.data)return false;c.d.origHeight=c.getVal(a,"h");c.d.origWidth=c.getVal(b,"w");c.d.data.hide();a&&c.d.container.css("height",a);b&&c.d.container.css("width",b);c.setContainerDimensions();c.d.data.show();c.o.focus&&c.focus();c.unbindEvents();c.bindEvents()},setContainerDimensions:function(){var a=this,b=k||m,c=a.d.origHeight?a.d.origHeight:d.browser.opera?

a.d.container.height():a.getVal(b?a.d.container[0].currentStyle.height:a.d.container.css("height"),"h");b=a.d.origWidth?a.d.origWidth:d.browser.opera?a.d.container.width():a.getVal(b?a.d.container[0].currentStyle.width:a.d.container.css("width"),"w");var h=a.d.data.outerHeight(true),g=a.d.data.outerWidth(true);a.d.origHeight=a.d.origHeight||c;a.d.origWidth=a.d.origWidth||b;var e=a.o.maxHeight?a.getVal(a.o.maxHeight,"h"):null,i=a.o.maxWidth?a.getVal(a.o.maxWidth,"w"):null;e=e&&e<f[0]?e:f[0];i=i&&i<

f[1]?i:f[1];var j=a.o.minHeight?a.getVal(a.o.minHeight,"h"):"auto";c=c?a.o.autoResize&&c>e?e:c<j?j:c:h?h>e?e:a.o.minHeight&&j!=="auto"&&h<j?j:h:j;e=a.o.minWidth?a.getVal(a.o.minWidth,"w"):"auto";b=b?a.o.autoResize&&b>i?i:b<e?e:b:g?g>i?i:a.o.minWidth&&e!=="auto"&&g<e?e:g:e;a.d.container.css({height:c,width:b});a.d.wrap.css({overflow:h>c||g>b?"auto":"visible"});a.o.autoPosition&&a.setPosition()},setPosition:function(){var a=this,b,c;b=f[0]/2-a.d.container.outerHeight(true)/2;c=f[1]/2-a.d.container.outerWidth(true)/

2;if(a.o.position&&Object.prototype.toString.call(a.o.position)==="[object Array]"){b=a.o.position[0]||b;c=a.o.position[1]||c}else{b=b;c=c}a.d.container.css({left:c,top:b})},watchTab:function(a){var b=this;if(d(a.target).parents(".simplemodal-container").length>0){b.inputs=d(":input:enabled:visible:first, :input:enabled:visible:last",b.d.data[0]);if(!a.shiftKey&&a.target===b.inputs[b.inputs.length-1]||a.shiftKey&&a.target===b.inputs[0]||b.inputs.length===0){a.preventDefault();b.focus(a.shiftKey?"last":

"first")}}else{a.preventDefault();b.focus()}},open:function(){var a=this;a.d.iframe&&a.d.iframe.show();if(d.isFunction(a.o.onOpen))a.o.onOpen.apply(a,[a.d]);else{a.d.overlay.show();a.d.container.show();a.d.data.show()}a.o.focus&&a.focus();a.bindEvents()},close:function(){var a=this;if(!a.d.data)return false;a.unbindEvents();if(d.isFunction(a.o.onClose)&&!a.occb){a.occb=true;a.o.onClose.apply(a,[a.d])}else{if(a.d.placeholder){var b=d("#simplemodal-placeholder");if(a.o.persist)b.replaceWith(a.d.data.removeClass("simplemodal-data").css("display",

a.display));else{a.d.data.hide().remove();b.replaceWith(a.d.orig)}}else a.d.data.hide().remove();a.d.container.hide().remove();a.d.overlay.hide();a.d.iframe&&a.d.iframe.hide().remove();setTimeout(function(){a.d.overlay.remove();a.d={}},10)}}}})(jQuery);

/*

 * SimpleModal OSX Style Modal Dialog

 * http://www.ericmmartin.com/projects/simplemodal/

 * http://code.google.com/p/simplemodal/

 *

 * Copyright (c) 2010 Eric Martin - http://ericmmartin.com

 *

 * Licensed under the MIT license:

 *   http://www.opensource.org/licenses/mit-license.php

 *

 * Revision: $Id: osx.js 238 2010-03-11 05:56:57Z emartin24 $

 */

jQuery(function($){var OSX={container:null,init:function(){$("a.login").click(function(e){e.preventDefault();$("#modal-content").modal({overlayId:'overlay',containerId:'container',closeHTML:null,minHeight:80,opacity:65,position:['0',],overlayClose:true,onOpen:OSX.open,onClose:OSX.close});});},open:function(d){var self=this;self.container=d.container[0];d.overlay.fadeIn('slow',function(){$("#modal-content",self.container).show();var title=$("#modal-title",self.container);title.show();d.container.slideDown('slow',function(){setTimeout(function(){var h=$("#modal-data",self.container).height()

+title.height()

+20;d.container.animate({height:h},200,function(){$("div.close",self.container).show();$("#modal-data",self.container).show();});},300);});})},close:function(d){var self=this;d.container.animate({top:"-"+(d.container.height()+20)},500,function(){self.close();});}};OSX.init();});

})(window.jQuery);

window.log=function(){log.history=log.history||[];log.history.push(arguments);if(this.console){console.log(Array.prototype.slice.call(arguments));}};(function(doc){var write=doc.write;doc.write=function(q){log('document.write(): ',arguments);if(/docwriteregexwhitelist/.test(q))write.apply(doc,arguments);};})(document);function closeDiv(){$("#close-message").fadeTo("slow",0.01,function(){$(this).slideUp("slow",function(){$(this).hide()})})}window.setTimeout("closeDiv();",2500);

/*$('a[href*=#]').click(function(){if(location.pathname.replace(/^\//,'')==this.pathname.replace(/^\//,'')&&location.hostname==this.hostname){var $target=$(this.hash);$target=$target.length&&$target||$('[name='+this.hash.slice(1)+']');if($target.length){var targetOffset=$target.offset().top;$('html,body').animate({scrollTop:targetOffset},1000);return false;}}});*/$('.forumbutton,.button').bind({mousedown:function(){$(this).addClass('mousedown');},blur:function(){$(this).removeClass('mousedown');},mouseup:function(){$(this).removeClass('mousedown');}});$('.forum_thread_user_post input[type="checkbox"]').bind('click',function(e){var $this=$(this);if($this.is(':checked')){$this.parents('tr:first').addClass('checked');$this.parents('tr:first').next('tr').addClass('checked');$this.parents('tr:first').prev('tr').addClass('checked');}else{$this.parents('tr:first').removeClass('checked');$this.parents('tr:first').next('tr').removeClass('checked');$this.parents('tr:first').prev('tr').removeClass('checked');}});$('.forum_table input[type="checkbox"]').bind('click',function(e){var $this=$(this);if($this.is(':checked')){$this.parents('tr:first').addClass('checked');}else{$this.parents('tr:first').removeClass('checked');}});$('.dropselect').styleddropdown();$("#s").val("Search...").css("color","#A0A0A0").focus(function(){$(this).css("color","black");if($(this).val()=="Search..."){$(this).val("");}}).blur(function(){$(this).css("color","#A0A0A0");if($(this).val()==""){$(this).val("Search...");}});$('#testimonials blockquote').quovolver();

var lang = {

	"SA":"Find support in <a href=\"http://www.phpfusion-ar.com\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Arabia</a>",
	"BE":"Find support in <a href=\"http://www.phpfusion-nederlands.info\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Belgium</a>",
	"BR":"Find support in <a href=\"http://www.phpfusion-br.com\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Brazil</a>",
	"DK":"Få support på <a href=\"http://www.php-fusion.dk\" target=\"_blank\">PHP-Fusion Denmark</a>",
	"CZ":"Find support in <a href=\"http://www.phpfusion.cz\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Czech Republic</a>",
	"FR":"Find support in <a href=\"http://www.phpfusion-fr.com\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion France</a>",
	"DE":"Finde Support auf <a href=\"http://www.phpfusion-support.de\" target=\"_blank\">PHP-Fusion Germany</a>",
	"HU":"Find support in <a href=\"http://www.php-fusion.co.hu\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Hungary</a>",
	"IR":"Find support in <a href=\"http://www.fusion.alaviweb.com\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Iran</a>",
	"IT":"Find support in <a href=\"http://www.php-fusion.it\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Italy</a>",
	"NL":"Find support in <a href=\"http://www.phpfusion-nederlands.info\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Netherlands</a>",
	"NO":"Find support in <a href=\"http://www.phpfusion-no.com\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Norway</a>",
	"PL":"Znajdź wsparcie na <a href=\"http://www.php-fusion.pl\" target=\"_blank\">PHP-Fusion Poland</a>",
	"RO":"Obțineți ajutor pe <a href=\"http://www.phpfusion.ro\" target=\"_blank\">PHP-Fusion Romania</a>",
	"RU":"Find support in <a href=\"http://netck.ru\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Russia</a>",
	"RS":"Find support in <a href=\"http://www.yu-fusion.org\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Serbia</a>",
	"ES":"Encuentra soporte en <a href=\"http://php-fusion.uni.cc\" target=\"_blank\">PHP-Fusion Spain</a>",
	"SE":"Sök support på <a href=\"http://www.php-fusion.se\" target=\"_blank\">PHP-Fusion Sweden</a>",
	"TR":"<a href=\"http://www.phpfusionturkiye.com\" target=\"_blank\">PHP-Fusion TÃ¼rkiye</a> destek sitesinden TÃ¼rkÃ§e destek alabilirsiniz.",
	"DF":"<a href=\"http://www.php-fusion.co.uk/viewpage.php?page_id=39\">PHP-Fusion International Network</a>"
}

$.getJSON("http://api.wipmania.com/jsonp?callback=?",function(data){var elem=$("#profile")

switch(data.address.country_code){case"SA":elem.append(lang.SA);break;case"BE":elem.append(lang.BE);break;case"BR":elem.append(lang.BR);break;case"DK":elem.append(lang.DK);break;case"CZ":elem.append(lang.CZ);break;case"FR":elem.append(lang.FR);break;case"DE":elem.append(lang.DE);break;case"HU":elem.append(lang.HU);break;case"IR":elem.append(lang.IR);break;case"DE":elem.append(lang.DE);break;case"IT":elem.append(lang.IT);break;case"NL":elem.append(lang.NL);break;case"NO":elem.append(lang.NO);break;case"PL":elem.append(lang.PL);break;case"RO":elem.append(lang.RO);break;case"RU":elem.append(lang.RU);break;case"RS":elem.append(lang.RS);break;case"ES":elem.append(lang.ES);break;case"SE":elem.append(lang.SE);break;case"TR":elem.append(lang.TR);break;default:elem.append(lang.DF);break;}});$('.spoiler_click').click(function(){if($(this).next().is(':hidden')){$(this).next().slideDown('normal');}else{$(this).next().slideUp('normal');}});$('a.slide_click').click().toggle(function(){$('.spoiler_click').next().slideDown('normal');return false;},function(){$('.spoiler_click').next().slideUp('normal');return false;});$('a.slide_down').click(function(){$('.spoiler_click').next().slideDown('normal');return false;});$('a.slide_up').click(function(){$('.spoiler_click').next().slideUp('normal');return false;});