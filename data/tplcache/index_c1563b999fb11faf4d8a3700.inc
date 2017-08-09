<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?>
document.write("<LINK href='/kefu/css/style.css' type=text/css rel=stylesheet>");

document.write("<div class='QQbox' id='divQQbox'>");

document.write("<div class='Qlist' id='divOnline' >");

document.write("<div class='t'></div>");

document.write("<div class='con'>");
<?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{
  echo GetKefu($fields['id'],$fields['typename']);
}
}?>
document.write("<h2><a href='javascript:hideMsgBox(event);'>[关闭]</a></h2>")
document.write("</div>");

document.write("<div class='b'></div>");

document.write("</div>");

document.write("<div id='KefuMenu' onclick='OnlineOver();' style='display : none;'><img src='/kefu/images/qq_1.png' class='press' alt='QQ客服热线'></div>");

document.write("</div>");



//<![CDATA[

var tips;
var theTop = 100/*这是默认高度,越大越往下*/;
var old = theTop;

function initFloatTips() {

tips = document.getElementById('divQQbox');

moveTips();

};

function moveTips() {

var tt=50;

if (window.innerHeight) {

pos = window.pageYOffset

}

else if (document.documentElement && document.documentElement.scrollTop) {

pos = document.documentElement.scrollTop

}

else if (document.body) {

pos = document.body.scrollTop;

}

pos=pos-tips.offsetTop+theTop;

pos=tips.offsetTop+pos/10;



if (pos < theTop) pos = theTop;

if (pos != old) {

tips.style.top = pos+"px";

tt=10;

//alert(tips.style.top);

}



old = pos;

setTimeout(moveTips,tt);

}

//!]]>

initFloatTips();







function OnlineOver(){

document.getElementById("KefuMenu").style.display = "none";

document.getElementById("divOnline").style.display = "block";

document.getElementById("divQQbox").style.width = "145px";

}



function OnlineOut(){

document.getElementById("KefuMenu").style.display = "block";

document.getElementById("divOnline").style.display = "none";



}



function hideMsgBox(theEvent){ //theEvent用来传入事件，Firefox的方式

　 if (theEvent){

　 var browser=navigator.userAgent; //取得浏览器属性

　 if (browser.indexOf("Firefox")>0){ //如果是Firefox

　　 if (document.getElementById('divOnline').contains(theEvent.relatedTarget)) { //如果是子元素

　　 return; //结束函式

} 

} 

if (browser.indexOf("MSIE")>0){ //如果是IE

if (document.getElementById('divOnline').contains(event.toElement)) { //如果是子元素

return; //结束函式

}

}

}

/*要执行的操作*/

document.getElementById("KefuMenu").style.display = "block";

document.getElementById("divOnline").style.display = "none";

}