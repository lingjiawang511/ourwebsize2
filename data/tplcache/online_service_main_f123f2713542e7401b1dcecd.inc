<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title>在线客服管理</title>
<link href="css/base.css" rel="stylesheet" type='text/css'>
<script language='javascript'>
function Sel(stype)
{
	  for(var i=0;i < document.getElementsByName('aids').length;i++)
	  {
		  if(stype=='all') document.getElementsByName('aids')[i].checked=true;
		  else document.getElementsByName('aids')[i].checked=false;
	  }
}
function checkSubmit()
{
	var str = '';
	for(var i=0;i < document.getElementsByName('aids').length;i++)
	{
		  if(document.getElementsByName('aids')[i].checked){
		  	if(str=='') str += document.getElementsByName('aids')[i].value;
		  	else str += ',' + document.getElementsByName('aids')[i].value;
		  }
	}
	if(str=='')
	{
		alert('你没选择任何内容！');
		return false;
	}
	else
	{
		location="friendlink_edit.php?aids="+str+"&dopost=delall";
	}
}
</script>
</head>
<body background='images/allbg.gif' leftmargin='8' topmargin='8'>

<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6">
  <tr>
    <td height="28" background="images/tbg.gif" colspan="6" style="padding-left:10px;">
  <div style="float:left">
  	<b>在线客服管理</b>
	</div>
	<div style="float:right;padding-right:6px;">
		[<a href="online_service_add.php"><u>添加在线客服</u></a>]
 	 	[<a href="online_service_edit.php?dopost=type"><u>客服分组管理</u></a>]
  </div>
  </td>
</tr>
<tr>
   <td height="30" align="center" bgcolor="#F9FCEF"  colspan="6"> 
   <form action="online_service_main.php" name="form1" method="get">
	  <table border="0" cellspacing="0" cellpadding="3">
      <tr>
          <td>关键字：</td>
          <td><input name="keyword" type="text" id="keyword" size="12" style="width:250px" value="<?php echo $keyword; ?>" /></td>
          <td>
          <?php echo GetSelect($typeid);?>
          </td>
          <td>
          <input name="imageField" class="np" type="image" src="images/button_search.gif" width="60" height="22" border="0" />
          </td>
        </tr>
      </table>
	  </form>
    </td>
</tr>
<form name='form1' method='post' action='online_service_edit.php' onSubmit='return checkSubmit();'>
<input type='hidden' name='dopost' value='delall'/>
<input type='hidden' name='allid' value=''/>
<tr align="center" bgcolor="#FBFCE2" height="26">
          <td width="6%">选择</td>
          <td width="23%">客服名称</td>
          <td width="12%">客服号码</td>
          <td width="15%">客服类别</td>
          <td width="15%">客服分组</td>
          <td width="8%">管理</td>
          
        </tr>
        <?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{
?>
        <tr align="center" bgcolor="#FFFFFF" height="26" onMouseMove="javascript:this.bgColor='#FCFDEE';"
        	 onMouseOut="javascript:this.bgColor='#FFFFFF';">
          <td><input type='checkbox' name='aids' value='<?php echo $fields['id']; ?>' class='np'></td>
          <td><?php echo $fields['kefuname']; ?></td>
          <td><?php echo $fields['kefusize']; ?></td>
          <td><?php echo GetKfType($fields['kefutype']); ?></td>
          <td><?php echo Getkefutype($fields['typeid']); ?></td>
          <td>
          	<a href='online_service_edit.php?id=<?php echo $fields['id']; ?>&dopost=getedit'>[更改]</a>
		        <a href='online_service_edit.php?id=<?php echo $fields['id']; ?>&dopost=delete'>[删除]</a>
		      </td>
        </tr>
		<?php
}
}?>
    </form>
     <tr bgcolor="#ffffff" height="28">
      <td colspan="6">
      	　
        <a href='#' onclick='Sel("all")' class='np coolbg'>[全选]</a>
      	<a href='#' onclick='Sel("none")' class='np coolbg'>[取消]</a>
      	<a href='#' onclick='checkSubmit()' class='np coolbg'>批量删除</a>
        <a href='online_service_add.php' class='np coolbg'>添加在线客服</a>
        <a href='online_service_edit.php?dopost=type' class='np coolbg'>客服分组管理</a>

      </td>
     </tr>
     <tr align="center" bgcolor="#F9FCEF" height="28">
      <td colspan="6">
      	<?php
$atts = array();
$atts['tagname'] = 'pagelist';
$atts['listsize'] = '6';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>

      </td>
     </tr>
   </table>
  </td>
</tr>
</table>
<table width="98%" border="0" cellpadding="1" cellspacing="1" align="center" class="tbtitle" style="background:#cfcfcf; margin-top:10px;">
  <tr>
    <td height="25" colspan="4" bgcolor="#EDF9D5" background="images/tbg.gif" style="padding-left:10px;">
    <div style="float:left">
  	<b>在线客服插件 版本信息</b>
	</div>
    </td>
  </tr>
  <tr bgcolor="#ffffff" height="25">
    <td colspan="4" align="left">
    
    <table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#ffffff">
      <tr>
        <td width="120" height="25" align="right">插件名称：</td>
        <td height="25" colspan="3">
         在线客服插件 for DedeCMS v5.7 SP1
        </td>
      </tr>
      <tr>
        <td height="25" align="right">当前版本：</td>
        <td height="25" colspan="3">v<?php echo PLUS_RATINGS_VER ?> 发布时间：2014-08-05</td>
      </tr>
      <tr>
        <td height="25" align="right">插件更新：</td>
        <td height="25" colspan="3">
          <?php echo $check_ver ?>
        </td>
      </tr>
      <tr>
        <td height="25" align="right">开发团队：</td>
        <td height="25" colspan="3">[织梦技术]-土匪</td>
      </tr>
      <tr>
        <td height="25" align="right">官方网站：</td>
        <td height="25"><a href="http://www.dedejs.com" target="_blank">http://www.dedejs.com</a></td>
      </tr>
      <tr>
        <td height="25" align="right">交流论坛：</td>
        <td height="25"><a href="http://bbs.dedejs.com" target="_blank">http://bbs.dedejs.com</a></td>
      </tr>
      <tr>
        <td height="25" align="right">QQ交流群：</td>
        <td height="25" colspan="3"><a target="_blank" href="http://wp.qq.com/wpa/qunwpa?idkey=e32165303f6ccb759247413d38bf8ab382b44fd5a63f98808703096af749de3b"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="DedeCms_Faq(官方群)" title="DedeCms_Faq(官方群)"></a></td>
      </tr>
      <tr>
        <td height="25" align="right">插件分享：</td>
        <td height="25" colspan="4">
        <div class="bdsharebuttonbox">
        <A title=分享到QQ空间 class=bds_qzone href="http://share.baidu.com/code#" data-cmd="qzone"></A>
        <A title=分享到新浪微博 class=bds_tsina href="http://share.baidu.com/code#" data-cmd="tsina"></A>
        <A title=分享到腾讯微博 class=bds_tqq href="http://share.baidu.com/code#" data-cmd="tqq"></A>
        <A title=分享到人人网 class=bds_renren href="http://share.baidu.com/code#" data-cmd="renren"></A>
        <A title=分享到腾讯朋友 class=bds_tqf href="http://share.baidu.com/code#" data-cmd="tqf"></A>
        <A title=分享到一键分享 class=bds_mshare href="http://share.baidu.com/code#" tangram_guid="TANGRAM_290" data-cmd="mshare"></A>
        <A class=bds_more href="http://share.baidu.com/code#" tangram_guid="TANGRAM_291" data-cmd="more"></A>
        </div>
		<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"织梦在线客服插件v1.0.0","bdUrl":"http://www.dedejs.com/html/article-335-1.html","bdDesc":"织梦dedecms在线客服插件是一款用于织梦CMS的在线客服插件，悬浮显示在网站右侧，可在后台添加或删除客服，支持QQ在线客服、阿里旺旺在线客服以及电话客服，支持客服分组功能，非常简单而且好用！","bdMini":"2","bdMiniList":false,"bdPic":"http://www.dedejs.com/files/litpic/140805/1-140P5215Qc16.jpg","bdStyle":"1","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
		</script>
        </td>
       </tr>
    </table>
    </td>
  </tr>
  <tr bgcolor="#F8FBFB">
    <td height="26" colspan="4" align="center" bgcolor="#F9FCEF">&nbsp;</td>
  </tr>
</table>
</body>
</html>