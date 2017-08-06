function webwidth(){
var winWidth = 0; 
var winHeight = 0; 
//============================================================================
//获取窗口宽度 
if (window.innerWidth) {
winHeight = window.innerHeight; 
winWidth = window.innerWidth; 
}
else{
winHeight = document.documentElement.clientHeight; 
winWidth = document.documentElement.clientWidth; 
}

};
var winWidth = 0; 
var winHeight = 0; 
//============================================================================
//获取窗口宽度 
if (window.innerWidth) {
winHeight = window.innerHeight; 
winWidth = window.innerWidth; 
}
else{
winHeight = document.documentElement.clientHeight; 
winWidth = document.documentElement.clientWidth; 
}

//============================================================================
function b(){
	//h = $(window).height();
	//t = $(document).scrollTop();
//	var tno=0
//	var tno=($(window).width()<1200)?57:88;
	//if(t >tno){
	//	$(".web-top").css({position:"fixed"});
//	}else{
//		$(".web-top").css({position:"relative"})
//	}
	var cpbh=620/340
	cpbh=winWidth/0.94/cpbh
	if ($(window).width()<1200) {
	   $(".cp-banner").css({height:cpbh+60})
	   $(".cp-banpic").css({height:cpbh})
	}
}


function bcli(){
////////////////////////////////////////////////
hhwid4=$('.web-ncpli .wk-li').length
var gi=0
for(var i=0;i<hhwid4;i++){
gi++
//alert(gi)
gi=(gi=4)?0:gi
$('.web-ncpli .wk-li .iwoo').eq(i).css({left:gi+1})
}
///////////////////////////////////////////////////////
if ($(window).width()>1200){
$('.wk-li').css({height:300})
}else{
    $('.wk-li').css({height:$('.wk-li').width()})

}


}






$(function() { 
b();
bcli();
var fenhu=$('#fenye')
if(fenhu != '') {
var fenlin=$('#fenye a').length;
fenhu.css({'width':fenlin*38})
}


var fenhu1a=$('.container .flex-control-nav')
if(fenhu1a != '') {
var fenlin1a=$('.container .flex-control-nav li').length

var wiuozza=fenlin1a*36

wiuozza=$(window).width()-wiuozza-20
wiuozza=wiuozza/2

fenhu1a.css({'left':wiuozza})
}



var fenhu1a1=$('.pagination1')
if(fenhu1a1 != '') {
var fenlin1a1=$('.pagination1 span').length

var wiuozza1=fenlin1a1*16

wiuozza1=winWidth-wiuozza1-20
wiuozza1=wiuozza1/2

fenhu1a1.css({'left':wiuozza1})
}
//=================导航==================


 $(".sm-muse").click(function(){
   $('.web-dh').toggle();
});



$('#gotop').click(function(){
		$(document).scrollTop(0);	
	})
//=================导航==================

$('.ipone-cpgd-top li').width(winWidth/3-6)
var piohei=299/210
piohei=winWidth/4/piohei

$('.ipone-cpgd-index').height(piohei+40)

var banw=winWidth-620
banw=banw/2-100
$('.arrow-right').css({left:banw})
$('.arrow-left').css({right:banw})

//$('.towclass2').width($('.towclass2 li').parent().width())
//alert($('.towclass2 li').parent().width())
//$('.towclass1').width($('.towclass1 li').parent().width())





});








$(window).load(function() { 


});
$(window).resize(function(){
webwidth();
bcli();
b()
});

$(window).scroll(function(e){
	b();		
})
