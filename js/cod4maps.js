//<![CDATA[
/* LOOK, LEARN, BUT DON'T STEAL :) © 2008 - Daniel Lang, mavrick.id.au */
function fb_overlayMsg_adjust() {
	var myValues = $('fb_overlayMsg').getCoordinates();
	$('fb_overlayMsg').setStyles({
		'left' : ((window.getWidth() / 2) - 200) + 'px',
		'top' : ((window.getHeight() / 2) - (myValues.height.toInt() / 2) + window.getScrollTop().toInt()) + 'px'
	});
	$('fb_overlay').setStyles({
		'height' : window.getScrollHeight().toInt() + 'px',
		'width' : (window.getWidth().toInt()) + 'px'
	});
}
function addOption(selectId, txt, val, defSel){
	// if Safari/Konqueror/Chrome
	if(window.webkit) {	
		var element = $(selectId);
		var newone = new Option(txt,val,defSel);
		element.add(newone,element.options[element.options.length]);
	// if Internet Exploder (any)
	} else if(window.ie) {
		var objOption = new Option(txt, val, defSel, defSel);
		$(selectId).options.add(objOption);
	// if Mozilla/Gecko/Opera
	} else {
		var objOption = new Option(txt, val, defSel);
		$(selectId).options.add(objOption);
	}
}
window.addEvent('domready', function() {
	fb_overlayMsg_adjust();
	$('fb_overlay').setStyles({
		'height' : window.getScrollHeight().toInt() + 'px',
		'width' : (window.getWidth().toInt()) + 'px',
		'cursor' : 'hand',
		'cursor' : 'pointer'
	}).addEvent('click',function() { $('fb_overlayMsg').setStyle('display','none'); $('fb_overlay').setStyle('display','none'); });
	var i = 1; //new Drag.Move('colorcodes',{onStart: function() { $('colorcodes').setStyle('border','solid 3px #333').setOpacity(0.4); }, onComplete: function() { $('colorcodes').setStyle('border','solid 3px #000').setOpacity(1); }});
	$('msg_add').addEvent('click',function() {
		i++; var msg = $('msg').clone().injectInside($('container'));
		var child = msg.getChildren(); child.getLast().remove();
		msg.getElements('div[class=msg_title]').setText('Map ' + i + ':');
		msg.getElements('input[id=msg_1]').setProperties({'id':'msg_' + i,'value':''});
		msg.getElements('optgroup[id=customMaps_1]').setProperties({'id':'customMaps_' + i});
	});	
	$('generate').addEvent('click',function() {
		new Ajax( '?xhr', { 
			method: 'post',
			data: Object.toQueryString({'gametype':$('gametype').getProperty('value'),'verbose':($('verbose').checked ? '1' : ''),'randomize':($('randomize').checked ? '1' : ''),'type':$$('select[name^=rotationtype]').getProperty('value'),'map':$$('select[name^=rotationmap]').getProperty('value')}),
			update: $('output'),
			onRequest: function() { $('output').toggleClass('fb_loading').setOpacity(0.6); $('fb_download').setProperty('disabled','disabled'); $('fb_select').setProperty('disabled','disabled'); },
			onComplete: function() { $('output').toggleClass('fb_loading').setOpacity(1); $('fb_download').removeProperty('disabled'); $('fb_select').removeProperty('disabled'); }
		}).request();
	});
	$('fb_select').addEvent('click',function() {
		document.getElementById("output").select();
	});
	$('fb_download').addEvent('click',function() {
		if($('output').getProperty('value')) {
			$('fb_form').fireEvent('submit');
			$('fb_form').submit();
		} else {
			$('fb_download').setProperty('disabled','disabled');
		}
	});
	/* context menus */
	$$('.contextMenu .menuItem').each(function(el) {
		if(!el.hasClass('disabled')) {
			el.addEvent('mouseover',function() { this.addClass('over'); }).addEvent('mouseout',function() { this.removeClass('over'); });
		} else {
			el.removeEvent('mouseover').removeEvent('mouseout').setOpacity(0.45);
		}
	});
	/* new gametype */
	$('newGameType').addEvent('click',function() {
		$('fb_overlay').setOpacity(0.7).setStyle('display','block');
		$('fb_overlayMsg').setStyle('display','block');	
		new Ajax( '?xhr', { 
			method: 'post',
			data: Object.toQueryString({'newGameType':'1','ssid':fb_ssid}),
			update: $('overlayMiddle'),
			evalScripts: true,
			onRequest: function() {$('overlayMiddle').setHTML('<div style="padding:6px;text-align:center;margin:0 auto;"><strong>Loading, Please Wait</strong></div>'); $('overlayTitle').setHTML('Loading...'); },
			onComplete: function() { $('overlayTitle').setHTML('Add Custom Gametype'); fb_overlayMsg_adjust(); }
		}).request();
	});
	/* new map */
	$('newMap').addEvent('click',function() {
		$('fb_overlay').setOpacity(0.7).setStyle('display','block');
		$('fb_overlayMsg').setStyle('display','block');	
		new Ajax( '?xhr', { 
			method: 'post',
			data: Object.toQueryString({'newMap':'1','ssid':fb_ssid}),
			update: $('overlayMiddle'),
			evalScripts: true,
			onRequest: function() {$('overlayMiddle').setHTML('<div style="padding:6px;text-align:center;margin:0 auto;"><strong>Loading, Please Wait</strong></div>'); $('overlayTitle').setHTML('Loading...'); },
			onComplete: function() { $('overlayTitle').setHTML('Add Custom Map'); fb_overlayMsg_adjust(); }
		}).request();
	});
	/* manage gametypes */
	$('manageGameType').addEvent('click',function() {
		$('fb_overlay').setOpacity(0.7).setStyle('display','block');
		$('fb_overlayMsg').setStyle('display','block');	
		new Ajax( '?xhr', { 
			method: 'post',
			data: Object.toQueryString({'manageGameType':'1','ssid':fb_ssid}),
			update: $('overlayMiddle'),
			evalScripts: true,
			onRequest: function() {$('overlayMiddle').setHTML('<div style="padding:6px;text-align:center;margin:0 auto;"><strong>Loading, Please Wait</strong></div>'); $('overlayTitle').setHTML('Loading...'); },
			onComplete: function() { $('overlayTitle').setHTML('Manage Your Custom Gametypes'); fb_overlayMsg_adjust(); }
		}).request();
	});
	/* manage maps */
	$('manageMaps').addEvent('click',function() {
		$('fb_overlay').setOpacity(0.7).setStyle('display','block');
		$('fb_overlayMsg').setStyle('display','block');	
		new Ajax( '?xhr', { 
			method: 'post',
			data: Object.toQueryString({'manageMaps':'1','ssid':fb_ssid}),
			update: $('overlayMiddle'),
			evalScripts: true,
			onRequest: function() {$('overlayMiddle').setHTML('<div style="padding:6px;text-align:center;margin:0 auto;"><strong>Loading, Please Wait</strong></div>'); $('overlayTitle').setHTML('Loading...'); },
			onComplete: function() { $('overlayTitle').setHTML('Manage Your Custom Maps'); fb_overlayMsg_adjust(); }
		}).request();
	});
	/* new maps */
	$('newMap').addEvent('click',function() {
		$('fb_overlay').setOpacity(0.7).setStyle('display','block');
		$('fb_overlayMsg').setStyle('display','block');	
	});
});
window.addEvent('resize',function() {
	fb_overlayMsg_adjust();
	$('fb_overlay').setStyles({
		'height' : window.getScrollHeight().toInt() + 'px',
		'width' : (window.getWidth().toInt()) + 'px'
	});
});
window.onscroll = function() {
	fb_overlayMsg_adjust();
};
//]]>