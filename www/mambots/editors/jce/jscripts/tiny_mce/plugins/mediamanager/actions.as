/* 
* @copyright Copyright (C) 2007 Ryan Demmer. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
/*@version 1.1.4 14/05/2007*/
//Declare variables
var loadProgressId:Number;
var playProgressId:Number;
var scrubId:Number;
var volumeId:Number;
var videoTime:Number;
var progBarWidth:Number;
var defVolume:Number = 100;
var bufferInterval:Number;
if (frontcolor == 'undefined') {
	frontcolor = 0x333333;
}
if (lightcolor == 'undefined') {
	lightcolor = 0x999999;
}
if (bufferlength == 'undefined') {
	bufferlength = 5;
}
//Setup the video connection                               
var nc:NetConnection = new NetConnection();
nc.connect(null);
var ns:NetStream = new NetStream(nc);
ns.setBufferTime(bufferlength);
videoBox.smoothing = true;
videoBox.attachVideo(ns);
//Buffer time
function checkBufferTime(my_ns:NetStream):Void {
	var bufferPct:Number = Math.min(Math.round(my_ns.bufferLength/my_ns.bufferTime*100), 100);
	infoTxt.text = "Buffering: "+bufferPct+"%";
	if (bufferPct == 100 || bufferPct == 0) {
		infoTxt.text = '';
		clearInterval(bufferInterval);
	}
}
//Setup interface
setupInterface(Stage.width, Stage.height);
//Create sound clip       
this.createEmptyMovieClip("videoSound", this.getNextHighestDepth());
videoSound.attachAudio(ns);
audio = new Sound(videoSound);
setVolume(100);
//Auto play
if (autostart == 'true' || autostart == '1') {
	bigPlay._visible = false;
	playVideo();
}
ns.onMetaData = function(videoObj:Object) {
	videoTime = videoObj.duration;
};
ns.onStatus = function(streamObj:Object) {
	switch (streamObj.code) {
	case "NetStream.Play.Stop" :
		ns.seek(0.01);
		progressPlay._width = 0;
		if (repeat == 'true' || repeat == '1') {
			playVideo();
		} else {
			pauseVideo();
			bigPlay._visible = true;
		}
		break;
	case "NetStream.Play.Start" :
		if (playBtn._currentframe == 1) {
			playBtn.gotoAndStop(2);
		}
		break;
	case "NetStream.Play.StreamNotFound" :
		infoTxt.text = "Unable to load file";
		break;
	case "NetStream.Buffer.Empty" :
		//infoTxt.text = "Buffering...";
		bufferInterval = setInterval(checkBufferTime, 100, ns);
		break;
	case "NetStream.Buffer.Full" :
		infoTxt.text = "";
		clearInterval(bufferInterval);
		break;
	}
};
function setupInterface(w:Number, h:Number) {
	//Video Background
	videoBg._width = w;
	videoBg._height = h-16;
	videoBg._x = 0;
	videoBg._y = 0;
	//Video Box
	videoBox._width = w;
	videoBox._height = h-16;
	videoBox._x = 0;
	videoBox._y = 0;
	//Corners
	leftCorner._y = videoBg._height;
	rightCorner._y = videoBg._height;
	rightCorner._x = w;
	//Play Button
	playBtn._y = videoBg._height+5;
	pauseBtn._y = videoBg._height+5;
	//Mute Button
	muteBtn._x = w-15;
	muteBtn._y = videoBg._height+3;
	//volume Button
	volumeBtn._x = w-52;
	volumeBtn._y = videoBg._height;
	//Bottom Bar
	bar._x = 14;
	bar._y = videoBg._height;
	bar._width = w-28;
	//Progress Bars
	progressPlay._y = videoBg._height+5;
	progressPlay._width = 0;
	progressLoad._y = videoBg._height+5;
	progressLoad._width = 0;
	//Text
	infoTxt._x = w/2-infoTxt._width/2;
	infoTxt._y = videoBg._height/2-infoTxt._height/2;
	//Big Play
	bigPlay._x = w/2-bigPlay._width/2;
	bigPlay._y = videoBg._height/2-bigPlay._height/2;
	//Set button states
	playBtn._visible = true;
	pauseBtn._visible = false;
	muteBtn._visible = true;
	if (w<200) {
		volumeBtn._visible = false;
		//Progress Bar Width
		progBarWidth = w-43;
	} else {
		volumeBtn._visible = true;
		//Progress Bar Width
		progBarWidth = w-76;
	}
	//Set Colors
	setColor1(pauseBtn);
	setColor1(playBtn);
	setColor1(muteBtn.speaker);
	setColor1(muteBtn.sound_on);
	setColor1(volumeBtn.drag);
	setColor1(progressPlay);
	setColor2(progressLoad);
	setColor2(volumeBtn.back);
	setColor2(muteBtn.sound_off);
}
function setColor1(mc):Void {
	var color:Color = new Color(mc);
	color.setRGB(frontcolor);
}
function setColor2(mc):Void {
	var color:Color = new Color(mc);
	color.setRGB(lightcolor);
}
function setMute(opt):Void {
	switch (opt) {
	case 'on' :
		muteBtn.gotoAndStop(2);
		setVolume(0);
		volumeBtn.drag._xscale = 0;
		break;
	case 'off' :
		muteBtn.gotoAndStop(1);
		setVolume(defVolume);
		volumeBtn.drag._xscale = defVolume;
		break;
	}
}
function playProgress():Void {
	var progPlay:Number = ns.time/videoTime*progBarWidth;
	progressPlay._width = progPlay;
}
function loadProgress() {
	var progLoad:Number = ns.bytesLoaded/ns.bytesTotal*progBarWidth;
	progressLoad._width = progLoad;
	if (progLoad>=progBarWidth) {
		clearInterval(loadProgressId);
	}
}
videoBg.onPress = function() {
	if (playBtn._currentframe == 1) {
		playVideo();
	} else {
		pauseVideo();
	}
};
bigPlay.onPress = function() {
	playVideo();
};
leftCorner.onPress = function() {
	if (playBtn._currentframe == 1) {
		playVideo();
	} else {
		pauseVideo();
	}
};
rightCorner.onPress = function() {
	if (muteBtn._currentframe == 1) {
		setMute('on');
	} else if (muteBtn._currentframe == 2) {
		setMute('off');
	}
};
progressLoad.onPress = function() {
	scrubId = setInterval(doScrub, 10);
};
progressLoad.onRelease = progressLoad.onReleaseOutside=function () {
	clearInterval(scrubId);
};
volumeBtn.onPress = function() {
	volumeId = setInterval(doVolume, 10);
};
volumeBtn.onRelease = volumeBtn.onReleaseOutside=function () {
	clearInterval(volumeId);
};
function playVideo() {
	bigPlay._visible = false;
	bufferInterval = setInterval(checkBufferTime, 100, ns);
	playBtn.gotoAndStop(2);
	if (ns.time != 0) {
		ns.pause(false);
	} else {
		if (file != undefined) {
			infoTxt.text = "Loading movie...";
			ns.play(_root.file);
		} else {
			infoTxt.text = "No file specified";
			playBtn.gotoAndStop(1);
		}
		if (muteBtn._visible) {
			setVolume(defVolume);
			volumeBtn.drag._xscale = defVolume;
		} else {
			setVolume(0);
			volumeBtn.drag._xscale = 0;
		}
		loadProgressId = setInterval(loadProgress, 10);
	}
	playProgressId = setInterval(playProgress, 10);
}
function pauseVideo() {
	playBtn.gotoAndStop(1);
	ns.pause();
	clearInterval(playProgressId);
}
function setVolume(vol:Number) {
	audio.setVolume(vol);
}
function doVolume() {
	var pct:Number = volumeBtn._xmouse/32*100;
	if (pct>100) {
		pct = 100;
	}
	if (pct<0) {
		pct = 0;
	}
	if (pct == 0) {
		muteBtn.gotoAndStop(2);
	} else {
		muteBtn.gotoAndStop(1);
	}
	volumeBtn.drag._width = 32*pct/100;
	defVolume = pct;
	setVolume(pct);
}
function doScrub() {
	var mouseX:Number = progressLoad._xmouse*progressLoad._width/2;
	if (mouseX>progressLoad._width) {
		mouseX = progressLoad._width;
	}
	if (mouseX<0) {
		mouseX = 0;
	}
	progressPlay._width = mouseX;
	var pct:Number = mouseX/progressLoad._width*100;
	var pos = videoTime/100*pct;
	ns.seek(pos);
}