function getFlv(p, t, d){
	switch(t){
		case 'bool':
			if(typeof(p) == "undefined"){
				return false;	
			}else{
				return eval(p);	
			}
			break;
		case 'str':
			if (typeof(p) == "undefined"){
				return d;	
			}else{
				return p;
			}
			break;
		case 'color':
			if (typeof(p) == "undefined"){
				return d;
			}else{
				return hexReplace(p);	
			}
			break;
	}
};
function setFlv(v){
	var fv = 'file=' + jsEncode(v);	
	fv += (ischecked('flash_flv_autostart')) ? '&autostart=true' : '&autostart=false';
	fv += (ischecked('flash_flv_repeat')) ? '&repeat=true' : '&repeat=false';
	fv += (getValue('flash_flv_bufferlength') == '') ? '' : '&bufferlength=' + getValue('flash_flv_bufferlength');
	fv += (getValue('flash_flv_frontcolor') == '') ? '' : '&frontcolor=' + hashReplace(getValue('flash_flv_frontcolor'));
	fv += (getValue('flash_flv_lightcolor') == '') ? '' : '&lightcolor=' + hashReplace(getValue('flash_flv_lightcolor'));

	return fv;
};
function init() {
	var pl = "", val;
	var type = "flash", fe, i;

	tinyMCEPopup.resizeToInnerSize();
	
	setHTML('bgcolor_pickcontainer', getColorPickerHTML('bgcolor_pick','bgcolor'));	
	setHTML('flash_flv_frontcolor_pickcontainer', getColorPickerHTML('flash_flv_frontcolor_pick','flash_flv_frontcolor'));
	setHTML('flash_flv_lightcolor_pickcontainer', getColorPickerHTML('flash_flv_lightcolor_pick','flash_flv_lightcolor'));
	updateColor('bgcolor_pick', 'bgcolor');
	updateColor('flash_flv_frontcolor_pick', 'flash_flv_frontcolor');
	updateColor('flash_flv_lightcolor_pick', 'flash_flv_lightcolor');

	fe = tinyMCE.selectedInstance.getFocusElement();
	if (/mceItem(Flash|ShockWave|WindowsMedia|QuickTime|RealMedia)/.test(tinyMCE.getAttrib(fe, 'class'))) {
		pl = "x={" + fe.title + "};";

		switch (tinyMCE.getAttrib(fe, 'class')) {
			case 'mceItemFlash':
				type = 'flash';
				break;

			case 'mceItemShockWave':
				type = 'shockwave';
				break;

			case 'mceItemWindowsMedia':
				type = 'wmp';
				break;

			case 'mceItemQuickTime':
				type = 'qt';
				break;

			case 'mceItemRealMedia':
				type = 'rmp';
				break;
		}
		setValue('insert', tinyMCE.getLang('lang_update', 'Insert', true)); 
	}
	// Setup form
	if (pl != "") {
		pl = eval(pl);

		switch (type) {
			case "flash":
				setBool(pl, 'flash', 'play', true);
				setBool(pl, 'flash', 'loop', true);
				setBool(pl, 'flash', 'menu', true);
				setBool(pl, 'flash', 'swliveconnect', false);
				setStr(pl, 'flash', 'quality');
				setStr(pl, 'flash', 'scale');
				setStr(pl, 'flash', 'salign');
				setStr(pl, 'flash', 'wmode');
				setStr(pl, 'flash', 'base');
				setStr(pl, 'flash', 'flashvars');
			break;

			case "qt":				
				setBool(pl, 'qt', 'loop', false);
				setBool(pl, 'qt', 'autoplay', false);
				setBool(pl, 'qt', 'cache', false);
				setBool(pl, 'qt', 'controller', true);
				setBool(pl, 'qt', 'correction', false);
				setBool(pl, 'qt', 'enablejavascript', false);
				setBool(pl, 'qt', 'kioskmode', false);
				setBool(pl, 'qt', 'autohref', false);
				setBool(pl, 'qt', 'playeveryframe', false);
				setBool(pl, 'qt', 'targetcache', false);
				setStr(pl, 'qt', 'scale');
				setStr(pl, 'qt', 'starttime');
				setStr(pl, 'qt', 'endtime');
				setStr(pl, 'qt', 'tarset');
				setStr(pl, 'qt', 'qtsrcchokespeed');
				setStr(pl, 'qt', 'volume');
				setStr(pl, 'qt', 'qtsrc');
			break;

			case "shockwave":
				setBool(pl, 'shockwave', 'sound');
				setBool(pl, 'shockwave', 'progress');
				setBool(pl, 'shockwave', 'autostart');
				setBool(pl, 'shockwave', 'swliveconnect');
				setStr(pl, 'shockwave', 'swvolume');
				setStr(pl, 'shockwave', 'swstretchstyle');
				setStr(pl, 'shockwave', 'swstretchhalign');
				setStr(pl, 'shockwave', 'swstretchvalign');
			break;

			case "wmp":
				setBool(pl, 'wmp', 'autostart', false);
				setBool(pl, 'wmp', 'enabled', false);
				setBool(pl, 'wmp', 'enablecontextmenu', true);
				setBool(pl, 'wmp', 'fullscreen', false);
				setBool(pl, 'wmp', 'invokeurls', true);
				setBool(pl, 'wmp', 'mute', false);
				setBool(pl, 'wmp', 'stretchtofit', false);
				setBool(pl, 'wmp', 'windowlessvideo', false);
				setStr(pl, 'wmp', 'balance');
				setStr(pl, 'wmp', 'baseurl');
				setStr(pl, 'wmp', 'captioningid');
				setStr(pl, 'wmp', 'currentmarker');
				setStr(pl, 'wmp', 'currentposition');
				setStr(pl, 'wmp', 'defaultframe');
				setStr(pl, 'wmp', 'playcount');
				setStr(pl, 'wmp', 'rate');
				setStr(pl, 'wmp', 'uimode');
				setStr(pl, 'wmp', 'volume');
			break;

			case "rmp":				
				setBool(pl, 'rmp', 'autostart', false);
				setBool(pl, 'rmp', 'loop', false);
				setBool(pl, 'rmp', 'autogotourl', true);
				setBool(pl, 'rmp', 'center', false);
				setBool(pl, 'rmp', 'imagestatus', true);
				setBool(pl, 'rmp', 'maintainaspect', false);
				setBool(pl, 'rmp', 'nojava', false);
				setBool(pl, 'rmp', 'prefetch', false);
				setBool(pl, 'rmp', 'shuffle', false);
				setStr(pl, 'rmp', 'console');
				setStr(pl, 'rmp', 'controls');
				setStr(pl, 'rmp', 'numloop');
				setStr(pl, 'rmp', 'scriptcallbacks');
			break;
		}
		setStr(pl, null, 'src');
		setStr(pl, null, 'id');
		setStr(pl, null, 'name');
		setStr(pl, null, 'vspace');
		setStr(pl, null, 'hspace');
		setStr(pl, null, 'bgcolor');
		setStr(pl, null, 'align');
		setStr(pl, null, 'width');
		setStr(pl, null, 'height');
		
		if ((val = tinyMCE.getAttrib(fe, "width")) != ""){
			pl.width = val;
			setValue('width', val); 
			setValue('tmp_width', val);
		}
		if ((val = tinyMCE.getAttrib(fe, "height")) != ""){
			pl.height = val;
			setValue('height', val); 
			setValue('tmp_height', val);
		}
	}
	selectByValue('media_type', type);
	changedType(type);
	updateColor('bgcolor_pick', 'bgcolor');
	
	if(basename(getValue('src')) == jce.get('flv_player') && type == 'flash'){
		var params = parseQuery(getValue('flash_flashvars'));
		setValue('src', getFlv(params['file'], 'str', ''));	
		check('flash_flv_autostart', getFlv(params['autostart'], 'bool', false));
		check('flash_flv_repeat', getFlv(params['repeat'], 'bool', false));
		setValue('flash_flv_bufferlength', getFlv(params['bufferlength'], 'str', 5));
		setValue('flash_flv_frontcolor', getFlv(params['frontcolor'], 'color', '#333333'));
		setValue('flash_flv_lightcolor', getFlv(params['lightcolor'], 'color', '#eeeeee'));
		
		updateColor('flash_flv_frontcolor_pick', 'flash_flv_frontcolor');
		updateColor('flash_flv_lightcolor_pick', 'flash_flv_lightcolor');
		show('flv_options');
		setFlvPreview();
	}
	setupIframe(getValue('src'));
	jce.tree = new dTree('jce.tree', jce.getLibUrl());
};
function insertMedia() {
	var fe, html;
	var v = getValue('src');
	var t = getType(getExtension(v));
	
	var w = (getValue('width') == '') ? 100 : getValue('width');
	var h = (getValue('height') == '') ? 100 : getValue('height');
	
	fe = tinyMCE.selectedInstance.getFocusElement();
	if (fe != null && /mceItem(Flash|ShockWave|WindowsMedia|QuickTime|RealMedia)/.test(tinyMCE.getAttrib(fe, 'class'))) {
		switch (t) {
			case "flash":
				fe.className = "mceItemFlash";
				break;

			case "shockwave":
				fe.className = "mceItemShockWave";
				break;

			case "qt":
				fe.className = "mceItemQuickTime";
				break;

			case "wmp":
				fe.className = "mceItemWindowsMedia";
				break;

			case "rmp":
				fe.className = "mceItemRealMedia";
				break;
		}
		if (fe.width != w || fe.height != h) tinyMCE.selectedInstance.repaint();		
		fe.width = w;
		fe.height = h;
		fe.title = serializeParameters();
		fe.style.width = w + (w.indexOf('%') == -1 ? 'px' : '');
		fe.style.height = h + (h.indexOf('%') == -1 ? 'px' : '');
		fe.align = getSelectValue('align');
	} else {
		html = '<img src="' + tinyMCE.getParam("theme_href") + '/images/spacer.gif"' ;

		switch (t) {
			case "flash":
				html += ' class="mceItemFlash"';	
				break;

			case "shockwave":
				html += ' class="mceItemShockWave"';
				break;

			case "qt":
				html += ' class="mceItemQuickTime"';
				break;

			case "wmp":
				html += ' class="mceItemWindowsMedia"';
				break;

			case "rmp":
				html += ' class="mceItemRealMedia"';
				break;
		}
		html += ' title="' + serializeParameters() + '"';
		html += ' width="' + w + '"';
		html += ' height="' + h + '"';
		html += ' align="' + getSelectValue('align') + '"';
		html += ' />';
		tinyMCE.selectedInstance.execCommand('mceInsertContent', false, html);
	}
	tinyMCEPopup.close();
};
function getType(v) {
	var fo = tinyMCE.getParam("media_types", "flash=swf,flv;shockwave=dcr;qt=mov,qt,mpg,mp3,mp4,mpeg;shockwave=dcr;wmp=avi,wmv,wm,asf,asx,wmx,wvx;rmp=rm,ra,ram").split(';'), i, c, el, x;
	// YouTube
	if(v.indexOf('http://www.youtube.com/') == 0){
		setValue('width', '425');
		setValue('height', '350');
		setValue('tmp_width', '425');
		setValue('tmp_height', '350');
		selectByValue('flash_wmode', 'transparent');
		if(v.indexOf('http://www.youtube.com/watch?v=') == 0){
			setValue('src', 'http://www.youtube.com/v/' + v.substring('http://www.youtube.com/watch?v='.length));	
		}
		return 'flash';
	}
	// Google video
	if(v.indexOf('http://video.google.com/') == 0){
		setValue('width', '425');
		setValue('height', '326');
		setValue('tmp_width', '425');
		setValue('tmp_height', '326');
		setValue('id', 'VideoPlayback');
		if(v.indexOf('http://video.google.com/videoplay?docid=') == 0){
			setValue('src', 'http://video.google.com/googleplayer.swf?docId=' + v.substring('http://video.google.com/videoplay?docid='.length) + '&hl=en');	
		}
		return 'flash';
	}
	for (i=0; i<fo.length; i++) {
		c = fo[i].split('=');

		el = c[1].split(',');
		for (x=0; x<el.length; x++){
			if (v == el[x]){
				return c[0];
			}
		}
	}
	return null;
};
function hashReplace(str){
	return str.replace(/#/g, '0x');	
};
function hexReplace(str){
	if(str){
		str = str.replace(/0x/g, '#');	
	}
	return str;
};
function switchType(v) {
	var t = getType(v);
	changedType(t);
	selectByValue('media_type', t);
};
function changedType(t) {
	hide('flash_options');
	hide('flv_options');
	hide('qt_options');
	hide('shockwave_options');
	hide('wmp_options');
	hide('rmp_options');
	show(t + '_options');
};
function serializeParameters() {
	var s = '';	
	var v = getValue('src');
	//alert(v)
	if(getExtension(v) == 'flv'){
		var flv = makePath(tinyMCE.getParam('document_base_url'), jce.get('flv_player_path')) + '/' + jce.get('flv_player');
		s += "src:'" + jsEncode(flv) + "',";
	}else{
		s += getStr(null, 'src');	
	}
	
	var type = getSelectValue('media_type');
	//var type = getType(v);
	switch (type) {
		case "flash":
			s += getBool('flash', 'play', true);
			s += getBool('flash', 'loop', true);
			s += getBool('flash', 'menu', true);
			s += getBool('flash', 'swliveconnect', false);
			s += getStr('flash', 'quality');
			s += getStr('flash', 'scale');
			s += getStr('flash', 'salign');
			s += getStr('flash', 'wmode');
			s += getStr('flash', 'base');
			if(getExtension(v) == 'flv'){
				s += "flashvars:'" + setFlv(v) + "',";
			}else{
				s += getStr('flash', 'flashvars');	
			}	
		break;

		case "qt":
			s += getBool('qt', 'loop', false);
			s += getBool('qt', 'autoplay', false);
			s += getBool('qt', 'cache', false);
			s += getBool('qt', 'controller', true);
			s += getBool('qt', 'correction', false, 'none', 'full');
			s += getBool('qt', 'enablejavascript', false);
			s += getBool('qt', 'kioskmode', false);
			s += getBool('qt', 'autohref', false);
			s += getBool('qt', 'playeveryframe', false);
			s += getBool('qt', 'targetcache', false);
			s += getStr('qt', 'scale');
			s += getStr('qt', 'starttime');
			s += getStr('qt', 'endtime');
			s += getStr('qt', 'target');
			s += getStr('qt', 'qtsrcchokespeed');
			s += getStr('qt', 'volume');
			s += getStr('qt', 'qtsrc');
		break;

		case "shockwave":
			s += getBool('shockwave', 'sound');
			s += getBool('shockwave', 'progress');
			s += getBool('shockwave', 'autostart');
			s += getBool('shockwave', 'swliveconnect');
			s += getStr('shockwave', 'swvolume');
			s += getStr('shockwave', 'swstretchstyle');
			s += getStr('shockwave', 'swstretchhalign');
			s += getStr('shockwave', 'swstretchvalign');
		break;

		case "wmp":
			s += getBool('wmp', 'autostart', false);
			s += getBool('wmp', 'enabled', false);
			s += getBool('wmp', 'enablecontextmenu', true);
			s += getBool('wmp', 'fullscreen', false);
			s += getBool('wmp', 'invokeurls', true);
			s += getBool('wmp', 'mute', false);
			s += getBool('wmp', 'stretchtofit', false);
			s += getBool('wmp', 'windowlessvideo', false);
			s += getStr('wmp', 'balance');
			s += getStr('wmp', 'baseurl');
			s += getStr('wmp', 'captioningid');
			s += getStr('wmp', 'currentmarker');
			s += getStr('wmp', 'currentposition');
			s += getStr('wmp', 'defaultframe');
			s += getStr('wmp', 'playcount');
			s += getStr('wmp', 'rate');
			s += getStr('wmp', 'uimode');
			s += getStr('wmp', 'volume');
		break;

		case "rmp":
			s += getBool('rmp', 'autostart', false);
			s += getBool('rmp', 'loop', false);
			s += getBool('rmp', 'autogotourl', true);
			s += getBool('rmp', 'center', false);
			s += getBool('rmp', 'imagestatus', true);
			s += getBool('rmp', 'maintainaspect', false);
			s += getBool('rmp', 'nojava', false);
			s += getBool('rmp', 'prefetch', false);
			s += getBool('rmp', 'shuffle', false);
			s += getStr('rmp', 'console');
			s += getStr('rmp', 'controls');
			s += getStr('rmp', 'numloop');
			s += getStr('rmp', 'scriptcallbacks');
		break;
	}
	//s += getStr(null, 'src');
	s += getStr(null, 'id');
	s += getStr(null, 'name');
	s += getStr(null, 'align');
	s += getStr(null, 'bgcolor');
	s += getInt(null, 'vspace');
	s += getInt(null, 'hspace');
	s += getStr(null, 'width');
	s += getStr(null, 'height');

	s = s.length > 0 ? s.substring(0, s.length - 1) : s;

	return s;
};
function setBool(pl, p, n, d) {
	if (typeof(pl[n]) == "undefined"){
		document.getElementById(p + "_" + n).checked = d || false;
	}else{
		document.getElementById(p + "_" + n).checked = eval(pl[n]);
	}	
};
function setStr(pl, p, n) {
	var e = getObj((p != null ? p + "_" : '') + n);

	if (typeof(pl[n]) == "undefined")
		return;
		
	if(n == 'src'){
		if (tinyMCE.getParam('convert_urls'))
			pl[n] = convertURL(pl[n], null, true);	
	}

	if (e.type == "text")
		e.value = pl[n];
	else
		selectByValue((p != null ? p + "_" : '') + n, pl[n]);
};
function getBool(p, n, d, tv, fv) {
	var v = ischecked(p + "_" + n);

	tv = typeof(tv) == 'undefined' ? 'true' : "'" + jsEncode(tv) + "'";
	fv = typeof(fv) == 'undefined' ? 'false' : "'" + jsEncode(fv) + "'";
	
	if(n == 'autoplay' || n == 'autostart'){
		switch(p){
			case 'wmp':
				return n + (v ? ':1,' : ':0,');
				break;
			case 'qt':
				return n + (v ? ':true,' : ':false,');
				break;
			default:
				return (v == d) ? '' : n + (v ? ':' + tv + ',' : ':' + fv + ',');
				break;
		}
	
	}
	return (v == d) ? '' : n + (v ? ':' + tv + ',' : ':' + fv + ',');
};
function getStr(p, n, d) {
	var el = getObj((p != null ? p + "_" : "") + n);
	var v = el.type == "text" ? el.value : el.options[el.selectedIndex].value;

	return ((n == d || v == '') ? '' : n + ":'" + jsEncode(v) + "',");
};
function getInt(p, n, d) {
	var el = getObj((p != null ? p + "_" : "") + n);
	var v = el.type == "text" ? el.value : el.options[el.selectedIndex].value;

	return ((n == d || v == '') ? '' : n + ":" + v.replace(/[^0-9]+/g, '') + ",");
};
function jsEncode(s) {	
	s = s.replace(new RegExp('\\\\', 'g'), '\\\\');
	s = s.replace(new RegExp('"', 'g'), '\\"');
	s = s.replace(new RegExp("'", 'g'), "\\'");

	return s;
};
function changeHeight() {
   if(!ischecked('constrain'))
        return;

    if (getValue('width') == "" || getValue('height')== "")
		return;

	var temp = (getValue('width') / getValue('tmp_width')) * getValue('tmp_height');
	setValue('height', temp.toFixed(0));
};
function changeWidth() {	
	if(!ischecked('constrain'))
        return;

    if (getValue('width') == "" || getValue('height')== "")
		return;

	var temp = (getValue('height') / getValue('tmp_height')) * getValue('tmp_width');
	setValue('width', temp.toFixed(0));
};
function getDimensions(ext, w, h){
	switch(ext){
		case 'mp3':
			w = 200;
			h = 16;
			break;
	}
	setValue('width', w);
	setValue('tmp_width', w);
	setValue('height', h);
	setValue('tmp_height', h);
	setHTML('dim_loader', '');
	disable('insert', false);
};
function showProperties(html, width, height){
	if(document.getElementById('fileProperties')){
		setHTML('fileProperties', xmlDecode(html));	
		jce.set('showProperties', true);
		if(jce.get('fileSelected')){		
			setValue('width', width);
			setValue('tmp_width', width);
			setValue('height', height);
			setValue('tmp_height', height);
			setHTML('dim_loader', '');
			disable('insert', false);
		}
	}
};
function setFlvPreview(){
	var h = '';
	
	var c1 = hashReplace(getValue('flash_flv_frontcolor'));
	var c2 = hashReplace(getValue('flash_flv_lightcolor'));
	
	var player_src = jce.getPluginUrl() + '/flv_preview.swf?c1=' + c1 + '&c2=' + c2;
		
	h += '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" name="player_preview" width="160" height="16">';
	h += '<param name="movie" value="' + player_src + '">';
	h += '<param name="wmode" value="opaque">';
	h += '<embed type="application/x-shockwave-flash" mode="opaque" src="' + player_src + '" width="160" height="16"></embed></object>';
	
	setHTML('flv_preview_container', (h));
};
function selectFile(id){
	var dir = getDir();
	var name = getObj('manager').contentWindow.document.getElementById(id).title;
	var path = makePath(dir,name);
	
	disable('insert', true);
	
	var url = makePath(tinyMCE.getParam('document_base_url'), jce.get('base_url'));
	var src = makePath(url, makePath(dir, name));
	var ext = getExtension(name);

    setValue('src', src);
    setValue('name', stripExtension(name));
	setHTML('dim_loader', '<img src="' + jce.getLibImg('load.gif') + '" style="margin-left:2px;" />');
	jce.ajaxSend('getDimensions', path);
	switchType(ext);
	if(ext == 'flv'){
		show('flv_options');
		setFlvPreview();
	}
};
function showFileDetails(id){
	var dir = getDir();
    var name = getObj('manager').contentWindow.document.getElementById(id).title;
    var path = makePath(dir,name);
    var ext = getExtension(name).toUpperCase();
	
	switchType(ext.toLowerCase());
	if(ext.toLowerCase() == 'flv'){
		show('flv_options');
		setFlvPreview();
	}
	setIcons(1);
	show('viewIcon');
		
	var html = '';
    html += '<div style="font-weight:bold">' + stripExtension(name) + '</div>';
    html += '<div>' + ext + ' ' + jce.getLang('file', false, 'File') + '</div>';
	html += '<div id="fileProperties"></div>';	
	setHTML('fileDetails', html);
	setLoader();
	jce.ajaxSend('getProperties', path);
    setValue('itemsList', path);
};
function viewMedia(){
	var html = '', cls, type, codebase;

    var file = getValue('itemsList');
	var name = basename(file);
    var ext = getExtension(name).toLowerCase();
		
	var w = parseInt(getHTML('file_width'));
	var h = parseInt(getHTML('file_height'));
	
	file = makePath(makePath(tinyMCE.getParam('document_base_url'), jce.get('base_url')), file);
	if(ext == 'flv'){
		file = jce.getPluginUrl() + '/flvplayer.swf?file=' + file + '&autostart=true';	
		h = h + 16;
	}
	new mediaPreview(name, file, getType(ext), {
		mediaWidth: w,
		mediaHeight: h
	});
};