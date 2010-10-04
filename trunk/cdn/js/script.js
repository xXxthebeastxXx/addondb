/*
 *Flipbox written by CrappoMan
 *simonpatterson@dsl.pipex.com
 */
function flipBox(b){var a;if(document.images["b_"+b].src.indexOf("_on")==-1){a=document.images["b_"+b].src.replace("_off","_on");document.getElementById("box_"+b).style.display="none";if(document.getElementById("box_"+b+"_diff")){document.getElementById("box_"+b+"_diff").style.display="block"}document.images["b_"+b].src=a;disply="none";now=new Date();now.setTime(now.getTime()+1000*60*60*24*365);expire=(now.toGMTString());document.cookie="fusion_box_"+b+"="+escape(disply)+"; expires="+expire}else{a=document.images["b_"+b].src.replace("_on","_off");document.getElementById("box_"+b).style.display="block";if(document.getElementById("box_"+b+"_diff")){document.getElementById("box_"+b+"_diff").style.display="none"}document.images["b_"+b].src=a;disply="block";now=new Date();now.setTime(now.getTime()+1000*60*60*24*365);expire=(now.toGMTString());document.cookie="fusion_box_"+b+"="+escape(disply)+"; expires="+expire}}function addText(f,i,a,e){if(e==undefined){e="inputform"}if(f==undefined){f="message"}element=document.forms[e].elements[f];element.focus();if(document.selection){var c=document.selection.createRange();var h=c.text.length;c.text=i+c.text+a;return false}else{if(element.setSelectionRange){var b=element.selectionStart,g=element.selectionEnd;var d=element.scrollTop;element.value=element.value.substring(0,b)+i+element.value.substring(b,g)+a+element.value.substring(g);element.setSelectionRange(b+i.length,g+i.length);element.scrollTop=d;element.focus()}else{var d=element.scrollTop;element.value+=i+a;element.scrollTop=d;element.focus()}}}function insertText(f,h,e){if(e==undefined){e="inputform"}if(document.forms[e].elements[f].createTextRange){document.forms[e].elements[f].focus();document.selection.createRange().duplicate().text=h}else{if((typeof document.forms[e].elements[f].selectionStart)!="undefined"){var a=document.forms[e].elements[f];var g=a.selectionEnd;var d=a.value.length;var c=a.value.substring(0,g);var i=a.value.substring(g,d);var b=a.scrollTop;a.value=c+h+i;a.selectionStart=c.length+h.length;a.selectionEnd=c.length+h.length;a.scrollTop=b;a.focus()}else{document.forms[e].elements[f].value+=h;document.forms[e].elements[f].focus()}}}function show_hide(a){document.getElementById(a).style.display=document.getElementById(a).style.display=="none"?"block":"none"}function correctPNG(){if(navigator.appName=="Microsoft Internet Explorer"&&navigator.userAgent.indexOf("Opera")==-1){for(var g=0;g<document.images.length;g++){var d=document.images[g];var f=d.src.toUpperCase();if(f.substring(f.length-3,f.length)=="PNG"){var b=(d.id)?"id='"+d.id+"' ":"";var e=(d.className)?"class='"+d.className+"' ":"";var h=(d.title)?"title='"+d.title+"' ":"title='"+d.alt+"' ";var c="display:inline-block;"+d.style.cssText;if(d.align=="left"){c="float:left;"+c}if(d.align=="right"){c="float:right;"+c}if(d.parentElement.href){c="cursor:hand;"+c}var a="<span "+b+e+h+' style="width:'+d.width+"px; height:"+d.height+"px;"+c+";filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+d.src+"', sizingMethod='scale');\"></span>";d.outerHTML=a;g=g-1}}}}function getStyle(c,b){if(typeof c=="string"){var a=document.getElementById(c)}else{var a=c}if(a.currentStyle){var d=a.currentStyle[b]}else{if(window.getComputedStyle){var d=document.defaultView.getComputedStyle(a,null).getPropertyValue(b)}}return d};
/*
 * Drop Down/ Overlapping Content- © Dynamic Drive (www.dynamicdrive.com)
 * This notice must stay intact for legal use.
 * Visit http://www.dynamicdrive.com/ for full source code
 */
function getposOffset(a,d){var c=(d=="left")?a.offsetLeft:a.offsetTop;var b=a.offsetParent;while(b!=null){if(getStyle(b,"position")!="relative"){c=(d=="left")?c+b.offsetLeft:c+b.offsetTop}b=b.offsetParent}return c}function overlay(e,d,a){if(document.getElementById){var c=document.getElementById(d);c.style.display=(c.style.display!="block")?"block":"none";var b=getposOffset(e,"left")+((typeof a!="undefined"&&a.indexOf("right")!=-1)?-(c.offsetWidth-e.offsetWidth):0);var f=getposOffset(e,"top")+((typeof a!="undefined"&&a.indexOf("bottom")!=-1)?e.offsetHeight:0);c.style.left=b+"px";c.style.top=f+"px";return false}else{return true}}function overlayclose(a){document.getElementById(a).style.display="none"}NewWindowPopUp=null;function OpenWindow(d,c,a,b){if(NewWindowPopUp!=null){NewWindowPopUp.close();NewWindowPopUp=null}if(b==false){wtop=0;wleft=0}else{wtop=(screen.availHeight-a)/2;wleft=(screen.availWidth-c)/2}NewWindowPopUp=window.open(d,"","toolbar=no,menubar=no,location=no,personalbar=no,scrollbars=yes,status=no,directories=no,resizable=yes,height="+a+",width="+c+",top="+wtop+",left="+wleft+"");NewWindowPopUp.focus()}function resize_forum_imgs(){var f;var e;if(self.innerWidth){e=self.innerWidth}else{if(document.documentElement&&document.documentElement.clientWidth){e=document.documentElement.clientWidth}else{if(document.body){e=document.body.clientWidth}else{e=1000}}}if(e<=800){f=200}else{if(e<1152){f=300}else{if(e>=1152){f=400}}}for(var c=0;c<document.images.length;c++){var b=document.images[c];if(b.className!="forum-img"){continue}var j=b.height;var a=b.width;var d=false;if(a<=j){if(j>f){b.height=f;b.width=a*(f/j);d=true}}else{if(a>f){b.width=f;b.height=j*(f/a);d=true}}var h=b.parentNode;var g=h.parentNode;if(h.className!="forum-img-wrapper"){continue}if(d){h.style.display="inline";if(g.tagName!="A"){h.onclick=new Function("OpenWindow('"+b.src+"', "+(a+40)+", "+(j+40)+", true)");h.onmouseover="this.style.cursor='pointer'"}}else{h.style.display="inline"}}return true}
/*
 * Close admin msg
 */
function closeDiv(){$("#close-message").fadeTo("slow",0.01,function(){$(this).slideUp("slow",function(){$(this).hide()})})}window.setTimeout("closeDiv();",2500);

$('a[href*=#]').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
    && location.hostname == this.hostname) {
      var $target = $(this.hash);
      $target = $target.length && $target
      || $('[name=' + this.hash.slice(1) +']');
      if ($target.length) {
        var targetOffset = $target.offset().top;
        $('html,body')
        .animate({scrollTop: targetOffset}, 1000);
       return false;
      }
    }
  });
$('.forumbutton,.button').bind({
	mousedown: function() {
		$(this).addClass('mousedown');
	},
	blur: function() {
		$(this).removeClass('mousedown');
	},
	mouseup: function() {
		$(this).removeClass('mousedown');
	}
});
$('.forum_thread_user_post input[type="checkbox"]').bind('click',function(e) {
	var $this = $(this);
	if($this.is(':checked')) {
		$this.parents('tr:first').addClass('checked');
		$this.parents('tr:first').next('tr').addClass('checked');
		$this.parents('tr:first').prev('tr').addClass('checked');
	} else {
		$this.parents('tr:first').removeClass('checked');
		$this.parents('tr:first').next('tr').removeClass('checked');
		$this.parents('tr:first').prev('tr').removeClass('checked');
	}
});
$('.forum_table input[type="checkbox"]').bind('click',function(e) {
	var $this = $(this);
	if($this.is(':checked')) {
		$this.parents('tr:first').addClass('checked');
	} else {
		$this.parents('tr:first').removeClass('checked');
	}
});
$('.dropselect').styleddropdown();
$("#s")
    .val("Search...")
    .css("color", "#A0A0A0")
    .focus(function(){
        $(this).css("color", "black");
        if ($(this).val() == "Search...") {
            $(this).val("");
        }
    })
    .blur(function(){
        $(this).css("color", "#A0A0A0");
        if ($(this).val() == "") {
            $(this).val("Search...");
        }
    });
var lang = {
	"SA":"Find support in <a href=\"http://www.phpfusion-ar.com\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Arabia</a>",
	"BE":"Find support in <a href=\"http://www.phpfusion-nederlands.info\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Belgium</a>",
	"BR":"Find support in <a href=\"http://www.phpfusion-br.com\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Brazil</a>",
	"DK":"Find support in <a href=\"http://www.php-fusion.dk\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Denmark</a>",
	"CZ":"Find support in <a href=\"http://www.phpfusion.cz\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Czech Republic</a>",
	"FR":"Find support in <a href=\"http://www.phpfusion-fr.com\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion France</a>",
	"DE":"Find support in <a href=\"http://www.phpfusion-support.de\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Germany</a>",
	"HU":"Find support in <a href=\"http://www.php-fusion.co.hu\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Hungary</a>",
	"IR":"Find support in <a href=\"http://www.fusion.alaviweb.com\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Iran</a>",
	"IT":"Find support in <a href=\"http://www.php-fusion.it\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Italy</a>",
	"NL":"Find support in <a href=\"http://www.phpfusion-nederlands.info\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Netherlands</a>",
	"NO":"Find support in <a href=\"http://www.phpfusion-no.com\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Norway</a>",
	"PL":"Find support in <a href=\"http://www.php-fusion.pl\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Poland</a>",
	"RO":"Find support in <a href=\"http://www.phpfusion.ro\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Romania</a>",
	"RU":"Find support in <a href=\"http://netck.ru\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Russia</a>",
	"RS":"Find support in <a href=\"http://www.yu-fusion.org\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Serbia</a>",
	"ES":"Find support in <a href=\"http://php-fusion.uni.cc\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Spain</a>",
	"SE":"Få hjälp på <a href=\"http://www.php-fusion.se\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Sverige</a>",
	"TR":"Find support in <a href=\"http://www.phpfusionturkiye.com\" target=\"_blank\" rel=\"nofollow\">PHP-Fusion Turkey</a>",
	"DF":"We couldn't find a support site in you language."
}
$.getJSON("http://api.wipmania.com/jsonp?callback=?", function(data){
	var elem = $("#profile")
	switch(data.address.country_code) {
		case "SA":
		elem.append(lang.SA);
		break;
		case "BE":
		elem.append(lang.BE);
		break;
		case "BR":
		elem.append(lang.BR);
		break;
		case "DK":
		elem.append(lang.DK);
		break;
		case "CZ":
		elem.append(lang.CZ);
		break;
		case "FR":
		elem.append(lang.FR);
		break;
		case "DE":
		elem.append(lang.DE);
		break;
		case "HU":
		elem.append(lang.HU);
		break;
		case "IR":
		elem.append(lang.IR);
		break;
		case "DE":
		elem.append(lang.DE);
		break;
		case "IT":
		elem.append(lang.IT);
		break;
		case "NL":
		elem.append(lang.NL);
		break;
		case "NO":
		elem.append(lang.NO);
		break;
		case "PL":
		elem.append(lang.PL);
		break;
		case "RO":
		elem.append(lang.RO);
		break;
		case "RU":
		elem.append(lang.RU);
		break;
		case "RS":
		elem.append(lang.RS);
		break;
		case "ES":
		elem.append(lang.ES);
		break;
		case "SE":
		elem.append(lang.SE);
		break;
		case "TR":
		elem.append(lang.TR);
		break;
		default:
		elem.append(lang.DF);
		break;
	}
});