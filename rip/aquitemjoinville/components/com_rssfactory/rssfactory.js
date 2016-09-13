// This function decodes the any string
// that's been encoded using URL encoding technique


function URLDecode(psEncodeString)
{
  // Create a regular expression to search all +s in the string
  var lsRegExp = /\+/g;
  // Return the decoded string
  return unescape(String(psEncodeString).replace(lsRegExp, " "));
}
function openliks(url,img)
{
	swapimg(img);
	newwindow=window.open(url,'name');
	if (window.focus) {newwindow.focus()}
}
function swapimg(im_nr)
{
  if (document.images) {
	document.images[im_nr].src=document.images[im_nr].src.replace('0\.gif','1\.gif');
	}
  return true;
}
function getcontent(id){
	if (document.getElementById){
		el=document.getElementById(id);
		if (el) return el.innerHTML;
	}
	
	return '&nbsp;';
}
function opendiv(id){
	if (document.getElementById){
		el=document.getElementById(id);
		if (el) 
			if (el.style.display=='block') {el.style.display='none';}else{el.style.display='block';}
	}
	
	return '&nbsp;';
}
