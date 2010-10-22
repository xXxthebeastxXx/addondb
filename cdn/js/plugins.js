(function($){
$.fn.styleddropdown = function(){
	return this.each(function(){
		var obj = $(this)
		obj.find('.field').click(function() { //onclick event, 'list' fadein
		obj.find('.list').fadeIn(400);

		$(document).keyup(function(event) { //keypress event, fadeout on 'escape'
			if(event.keyCode == 27) {
			obj.find('.list').fadeOut(400);
			}
		});

		obj.find('.list').hover(function(){ },
			function(){
				$(this).fadeOut(400);
			});
		});

		obj.find('.list li').click(function() { //onclick event, change field value with selected 'list' item and fadeout 'list'
		obj.find('.field')
			.text($(this).html())
			.css({
				'background':'#fff',
				'color':'#333'
			});
		obj.find('.field-h').val($(this).attr('class'));
		obj.find('.list').fadeOut(400);
		});
	});
};

/*
 * jQuery Quovolver v1.0 - http://sandbox.sebnitu.com/jquery/quovolver
 *
 * By Sebastian Nitu - Copyright 2009 - All rights reserved
 * 
 */

	$.fn.quovolver = function(speed, delay) {
		
		/* Sets default values */
		if (!speed) speed = 500;
		if (!delay) delay = 6000;
		
		// If "delay" is less than 4 times the "speed", it will break the effect 
		// If that's the case, make "delay" exactly 4 times "speed"
		var quaSpd = (speed*4);
		if (quaSpd > (delay)) delay = quaSpd;
		
		// Create the variables needed
		var	quote = $(this),
			firstQuo = $(this).filter(':first'),
			lastQuo = $(this).filter(':last'),
			wrapElem = '<div id="quote_wrap"></div>';
		
		// Wrap the quotes
		$(this).wrapAll(wrapElem);
		
		// Hide all the quotes, then show the first
		$(this).hide();
		$(firstQuo).show();
		
		// Set the hight of the wrapper
		$(this).parent().css({height: $(firstQuo).height()});		
		
		// Where the magic happens
		setInterval(function(){
			
			// Set required hight and element in variables for animation
			if($(lastQuo).is(':visible')) {
				var nextElem = $(firstQuo);
				var wrapHeight = $(nextElem).height();
			} else {
				var nextElem = $(quote).filter(':visible').next();
				var wrapHeight = $(nextElem).height();
			}
			
			// Fadeout the quote that is currently visible
			$(quote).filter(':visible').fadeOut(speed);
			
			// Set the wrapper to the hight of the next element, then fade that element in
			setTimeout(function() {
				$(quote).parent().animate({height: wrapHeight}, speed);
			}, speed);
			
			if($(lastQuo).is(':visible')) {
				setTimeout(function() {
					$(firstQuo).fadeIn(speed*2);
				}, speed*2);
				
			} else {
				setTimeout(function() {
					$(nextElem).fadeIn(speed);
				}, speed*2);
			}
			
		}, delay);
	
	};
	/*
 AnythingSlider v1.4.5 minified using Google Closure Compiler
 By Chris Coyier: http://css-tricks.com
 with major improvements by Doug Neiner: http://pixelgraphics.us/
 based on work by Remy Sharp: http://jqueryfordesigners.com/
*/
$.anythingSlider=function(f,g){var a=this;a.$el=$(f).addClass("anythingBase").wrap('<div class="anythingSlider"><div class="anythingWindow" /></div>');a.$el.data("AnythingSlider",a);a.init=function(){a.options=$.extend({},$.anythingSlider.defaults,g);a.$wrapper=a.$el.parent().closest("div.anythingSlider").addClass("anythingSlider-"+a.options.theme);a.$window=a.$el.closest("div.anythingWindow");a.$controls=$('<div class="anythingControls"></div>').appendTo(a.$wrapper);a.$items=a.$el.find("> li").addClass("panel");
a.pages=a.$items.length;a.timer=null;a.flag=false;a.playing=false;a.hovered=false;a.panelSize=[];a.currentPage=a.options.startPanel;a.hasEmb=!!a.$items.find("embed[src*=youtube]").length;a.hasSwfo=typeof swfobject!=="undefined"&&swfobject.hasOwnProperty("embedSWF")&&$.isFunction(swfobject.embedSWF)?true:false;a.runTimes=$("div.anythingSlider").index(a.$wrapper)+1;if(!$.isFunction($.easing[a.options.easing]))a.options.easing="swing";a.options.theme!="default"&&!$("link[href*="+a.options.theme+"]").length&&
$("body").append('<link rel="stylesheet" href="'+a.options.themeDirectory.replace(/\{themeName\}/g,a.options.theme)+'" type="text/css" />');a.hasEmb&&a.hasSwfo&&a.$items.find("embed[src*=youtube]").each(function(b){($(this).parent()[0].tagName=="OBJECT"?$(this).parent():$(this)).wrap('<div id="ytvideo'+b+'"></div>');swfobject.embedSWF($(this).attr("src")+"&enablejsapi=1&version=3&playerapiid=ytvideo"+b,"ytvideo"+b,"100%","100%","10",null,null,{allowScriptAccess:"always",wmode:a.options.addWmodeToObject},
{})});if(a.options.resizeContents){a.options.width&&a.$wrapper.add(a.$items).css("width",a.options.width);a.options.height&&a.$wrapper.add(a.$items).css("height",a.options.height);a.hasEmb&&a.$el.find("object, embed").css({width:"100%",height:"100%"})}if(a.pages===1){a.options.autoPlay=false;a.options.buildNavigation=false;a.options.buildArrows=false}if(a.options.autoPlay){a.playing=!a.options.startStopped;a.buildAutoPlay()}a.buildNavigation();a.$el.prepend(a.$items.filter(":last").clone().addClass("cloned").removeAttr("id"));
a.$el.append(a.$items.filter(":first").clone().addClass("cloned").removeAttr("id"));a.$items=a.$el.find("> li");a.setDimensions();a.options.resizeContents||$(window).load(function(){a.setDimensions()});a.options.buildArrows&&a.buildNextBackButtons();a.options.pauseOnHover&&a.$wrapper.hover(function(){if(a.playing){a.$el.trigger("slideshow_paused",a);$.isFunction(a.options.onShowPause)&&a.options.onShowPause(a);a.clearTimer(true)}},function(){if(a.playing){a.$el.trigger("slideshow_unpaused",a);$.isFunction(a.options.onShowUnpause)&&
a.options.onShowUnpause(a);a.startStop(a.playing,true)}});if(a.options.hashTags===true&&!a.gotoHash()||a.options.hashTags===false)a.setCurrentPage(a.options.startPanel,false);a.$items.find("a").focus(function(){a.$items.find(".focusedLink").removeClass("focusedLink");$(this).addClass("focusedLink");a.$items.each(function(b){if($(this).find("a.focusedLink").length){a.gotoPage(b);return false}})});a.slideControls(false);a.$wrapper.hover(function(b){a.hovered=b.type=="mouseenter"?true:false;a.slideControls(a.hovered,
false)});$(document).keyup(function(b){if(a.$wrapper.is(".activeSlider"))switch(b.which){case 39:a.goForward();break;case 37:a.goBack()}})};a.buildNavigation=function(){a.$nav=$('<ul class="thumbNav" />').appendTo(a.$controls);a.options.playRtl&&a.$wrapper.addClass("rtl");a.options.buildNavigation&&a.pages>1&&a.$items.each(function(b){var c=b+1;b=$("<a href='#'></a>").addClass("panel"+c).wrap("<li />");a.$nav.append(b.parent());if($.isFunction(a.options.navigationFormatter)){var d=a.options.navigationFormatter(c,
$(this));b.html(d);parseInt(b.css("text-indent"),10)<0&&b.addClass(a.options.tooltipClass).attr("title",d)}else b.text(c);b.bind(a.options.clickControls,function(e){if(!a.flag){a.flag=true;setTimeout(function(){a.flag=false},100);a.gotoPage(c);a.options.hashTags&&a.setHash("panel"+a.runTimes+"-"+c)}e.preventDefault()})})};a.buildNextBackButtons=function(){a.$forward=$('<span class="arrow forward"><a href="#">'+a.options.forwardText+"</a></span>");a.$back=$('<span class="arrow back"><a href="#">'+
a.options.backText+"</a></span>");a.$back.bind(a.options.clickArrows,function(b){a.goBack();b.preventDefault()});a.$forward.bind(a.options.clickArrows,function(b){a.goForward();b.preventDefault()});a.$back.add(a.$forward).find("a").bind("focusin focusout",function(){$(this).toggleClass("hover")});a.$wrapper.prepend(a.$forward).prepend(a.$back);a.$arrowWidth=a.$forward.width()};a.buildAutoPlay=function(){a.$startStop=$("<a href='#' class='start-stop'></a>").html(a.playing?a.options.stopText:a.options.startText);
a.$controls.append(a.$startStop);a.$startStop.bind(a.options.clickSlideshow,function(b){a.startStop(!a.playing);if(a.playing)a.options.playRtl?a.goBack(true):a.goForward(true);b.preventDefault()}).bind("focusin focusout",function(){$(this).toggleClass("hover")});a.startStop(a.playing)};a.setDimensions=function(){var b,c,d,e,i,h=0,j=a.$window.width(),k=$(window).width();a.$items.each(function(l){d=$(this).children("*");if(a.options.resizeContents){b=parseInt(a.options.width,10)||j;c=parseInt(a.options.height,
10)||a.$window.height();$(this).css({width:b,height:c});d.length==1&&d.css({width:"100%",height:"100%"})}else{b=$(this).width();i=b>=k?true:false;if(d.length==1&&i){e=d.width()>=k?j:d.width();$(this).css("width",e);d.css("max-width",e);b=e}b=i?a.options.width||j:b;$(this).css("width",b);c=$(this).outerHeight();$(this).css("height",c)}a.panelSize[l]=[b,c,h];h+=b});a.$el.css("width",h<a.options.maxOverallWidth?h:a.options.maxOverallWidth)};a.gotoPage=function(b,c){if(typeof b==="undefined"||b===null){b=
a.options.startPage;a.setCurrentPage(a.options.startPage)}if(!a.checkVideo(a.playing)){a.$el.trigger("slide_init",a);$.isFunction(a.options.onSlideInit)&&a.options.onSlideInit(a);a.slideControls(true,false);if(b>a.pages+1)b=a.pages;if(b<0)b=1;if(c!==true)c=false;if(!c||a.options.stopAtEnd&&b==a.pages)a.startStop(false);a.$el.trigger("slide_begin",a);$.isFunction(a.options.onSlideBegin)&&a.options.onSlideBegin(a);a.options.resizeContents||a.$wrapper.filter(":not(:animated)").animate({width:a.panelSize[b][0],
height:a.panelSize[b][1]},{queue:false,duration:a.options.animationTime,easing:a.options.easing});a.$window.filter(":not(:animated)").animate({scrollLeft:a.panelSize[b][2]},{queue:false,duration:a.options.animationTime,easing:a.options.easing,complete:function(){a.endAnimation(b)}})}};a.endAnimation=function(b){if(b===0){a.$window.scrollLeft(a.panelSize[a.pages][2]);b=a.pages}else if(b>a.pages){a.$window.scrollLeft(a.panelSize[1][2]);b=1}a.setCurrentPage(b,false);a.hovered||a.slideControls(false);
if(a.hasEmb){b=a.$items.eq(a.currentPage).find("object[id*=ytvideo], embed[id*=ytvideo]");b.length&&$.isFunction(b[0].getPlayerState)&&b[0].getPlayerState()>0&&b[0].getPlayerState()!=5&&b[0].playVideo()}a.$el.trigger("slide_complete",a);$.isFunction(a.options.onSlideComplete)&&setTimeout(function(){a.options.onSlideComplete(a)},0)};a.setCurrentPage=function(b,c){if(a.options.buildNavigation){a.$nav.find(".cur").removeClass("cur");a.$nav.find("a").eq(b-1).addClass("cur")}if(!c){a.$wrapper.css({width:a.panelSize[b][0],
height:a.panelSize[b][1]});a.$wrapper.scrollLeft(0);a.$window.scrollLeft(a.panelSize[b][2])}a.currentPage=b;if(!a.$wrapper.is(".activeSlider")){$(".activeSlider").removeClass("activeSlider");a.$wrapper.addClass("activeSlider")}};a.goForward=function(b){if(b!==true){b=false;a.startStop(false)}a.gotoPage(a.currentPage+1,b)};a.goBack=function(b){if(b!==true){b=false;a.startStop(false)}a.gotoPage(a.currentPage-1,b)};a.gotoHash=function(){var b=window.location.hash.match(/^#?panel(\d+)-(\d+)$/);if(b)if(parseInt(b[1],
10)==a.runTimes){b=parseInt(b[2],10);if(a.$items.filter(":eq("+b+")").length!==0){a.setCurrentPage(b,false);return true}}return false};a.setHash=function(b){if(typeof window.location.hash!=="undefined"){if(window.location.hash!==b)window.location.hash=b}else if(location.hash!==b)location.hash=b;return b};a.slideControls=function(b){var c=b?"slideDown":"slideUp",d=b?0:a.options.animationTime,e=b?a.options.animationTime:0;b=b?0:1;a.options.toggleControls&&a.$controls.stop(true,true).delay(d)[c](a.options.animationTime/
2).delay(e);if(a.options.toggleArrows){if(!a.hovered&&a.playing)b=1;a.$forward.stop(true,true).delay(d).animate({right:b*a.$arrowWidth,opacity:e},a.options.animationTime/2);a.$back.stop(true,true).delay(d).animate({left:b*a.$arrowWidth,opacity:e},a.options.animationTime/2)}};a.clearTimer=function(b){if(a.timer){window.clearInterval(a.timer);if(!b){a.$el.trigger("slideshow_stop",a);$.isFunction(a.options.onShowStop)&&a.options.onShowStop(a)}}};a.startStop=function(b,c){if(b!==true)b=false;if(b&&!c){a.$el.trigger("slideshow_start",
a);$.isFunction(a.options.onShowStart)&&a.options.onShowStart(a)}a.playing=b;if(a.options.autoPlay){a.$startStop.toggleClass("playing",b).html(b?a.options.stopText:a.options.startText);if(parseInt(a.$startStop.css("text-indent"),10)<0)a.$startStop.addClass(a.options.tooltipClass).attr("title",b?"Stop":"Start")}if(b){a.clearTimer(true);a.timer=window.setInterval(function(){a.checkVideo(b)||(a.options.playRtl?a.goBack(true):a.goForward(true))},a.options.delay)}else a.clearTimer()};a.checkVideo=function(b){var c,
d,e=false;a.hasEmb&&a.$items.find("object[id*=ytvideo], embed[id*=ytvideo]").each(function(){c=$(this);if(c.length&&$.isFunction(c[0].getPlayerState)){d=c[0].getPlayerState();if(b&&(d==1||d>2)&&a.$items.index(c.closest("li.panel"))==a.currentPage&&a.options.resumeOnVideoEnd)e=true;else d>0&&c[0].pauseVideo()}});return e};a.init()};$.anythingSlider.defaults={width:null,height:null,resizeContents:true,tooltipClass:"tooltip",theme:"default",themeDirectory:"css/theme-{themeName}.css",startPanel:1,hashTags:true,
buildArrows:true,toggleArrows:false,buildNavigation:true,toggleControls:false,navigationFormatter:null,forwardText:"&raquo;",backText:"&laquo;",autoPlay:true,startStopped:false,pauseOnHover:true,resumeOnVideoEnd:true,stopAtEnd:false,playRtl:false,startText:"Start",stopText:"Stop",delay:3E3,animationTime:600,easing:"swing",onShowStart:null,onShowStop:null,onShowPause:null,onShowUnpause:null,onSlideInit:null,onSlideBegin:null,onSlideComplete:null,clickArrows:"click",clickControls:"click focusin",clickSlideshow:"click",
addWmodeToObject:"opaque",maxOverallWidth:32766};$.fn.anythingSlider=function(f){if((typeof f).match("object|undefined"))return this.each(function(){$(this).is(".anythingBase")||new $.anythingSlider(this,f)});else if(/\d/.test(f)&&!isNaN(f))return this.each(function(){var g=$(this).data("AnythingSlider");if(g){var a=typeof f=="number"?f:parseInt($.trim(f),10);a<1||a>g.pages||g.gotoPage(a)}})}
})(window.jQuery);



window.log = function(){
  log.history = log.history || []; 
  log.history.push(arguments);
  if(this.console){
    console.log( Array.prototype.slice.call(arguments) );
  }
};

(function(doc){
  var write = doc.write;
  doc.write = function(q){ 
    log('document.write(): ',arguments); 
    if (/docwriteregexwhitelist/.test(q)) write.apply(doc,arguments);  
  };
})(document);



