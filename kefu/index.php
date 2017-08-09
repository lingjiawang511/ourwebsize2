<?php
/*
* 在线客服数据调用
* 织梦技术研究中心http://www.dedejs.com
*/
header("Content-Type: text/html; charset=gb2312"); 
require_once (dirname(__FILE__) . "/../include/common.inc.php");
require_once(DEDEINC.'/datalistcp.class.php');
function GetKefu($typeid=0,$typename='在线客服'){
	global $dsql;
	$dsql->SetQuery("Select * From #@__onlinekefu where typeid=$typeid");
	$dsql->Execute();
	$k=0;
	$kefu='document.write("<h2>'.$typename.'</h2>");';
	$kefu.='document.write("<ul>");';
	while($row = $dsql->GetObject())
	{
      $k++;
	  if($row->kefutype=="1"){
	  $kfurl="http://wpa.qq.com/msgrd?v=3&uin=".$row->kefusize."&site=qq&menu=yes";
	  $kfimg="http://wpa.qq.com/pa?p=1:".$row->kefusize.":4";
	  
	  $kefu.="document.write(\"<li class='odd'><a href='{$kfurl}' target='_blank' title='点击QQ联系{$row->kefuname}'><span><img src='{$kfimg}'  border='0' alt='{$row->kefuname}' /></span> {$row->kefuname}</a></li>\");";
	  }else if($row->kefutype=="2"){
		  $nkefusize=urlencode($row->kefusize);
	  $kfurl="http://www.taobao.com/webww/ww.php?ver=3&touid=".$nkefusize."&siteid=cntaobao&status=2&charset=utf-8";
	  $kfimg="http://amos.alicdn.com/realonline.aw?v=2&uid=".$nkefusize."&site=cntaobao&s=2&charset=utf-8";
	  $kefu.="document.write(\"<li class='odd'><a href='{$kfurl}' target='_blank' title='点此阿里旺旺联系{$row->kefuname}'><span><img src='{$kfimg}'  border='0' alt='{$row->kefuname}' /></span> {$row->kefuname}</a></li>\");";
	  }else{
	  	  $kefu.="document.write(\"<li class='odd' title='{$row->kefuname}'><a><span><img src='/kefu/images/Phone.gif'  border='0' alt='{$row->kefuname}' /></span> {$row->kefusize}</a></li>\");";
      }
	}
	$kefu.='document.write("</ul>");';
	return $kefu;
}
$sql="Select * From #@__onlinekefu_type";
$dlist = new DataListCP();
$dlist->pageSize = 500;
$dlist->SetParameter("dopost",$dopost);
$dlist->SetTemplate(dirname(__FILE__).'/templets/index.htm');
$dlist->SetSource($sql);
$dlist->Display();
?>