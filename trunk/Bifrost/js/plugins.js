

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
		obj.find('.field-h').val($(this).attr('rel'));
		obj.find('.list').fadeOut(400);
		});
	});
};

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


