<?php
/**
 * 编辑在线客服
 *
 * @version        $Id: online_service_edit.php 8 19:23 2014年8月26日Z 土匪 $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2013 - 2014, Dedejs.Inc.
 * @license        http://bbs.dedejs.com
 * @link           http://www.dedejs.com
 */
require_once(dirname(__FILE__)."/config.php");
CheckPurview('plus_在线客服插件');
$ENV_GOBACK_URL = empty($_COOKIE['ENV_GOBACK_URL']) ? 'online_service_main.php' : $_COOKIE['ENV_GOBACK_URL'];
if(empty($dopost)) $dopost = "";

if(isset($allid))
{
    $aids = explode(',',$allid);
    if(count($aids)==1)
    {
        $id = $aids[0];
        $dopost = "delete";
    }
}
if($dopost=="delete")
{
    $id = preg_replace("#[^0-9]#", "", $id);
    $dsql->ExecuteNoneQuery("DELETE FROM `#@__onlinekefu` WHERE id='$id'");
    ShowMsg("成功删除一个在线客服！",$ENV_GOBACK_URL);
    exit();
}
else if($dopost=="delall")
{
    $aids = explode(',',$aids);
    if(isset($aids) && is_array($aids))
    {
        foreach($aids as $aid)
        {
            $aid = preg_replace("#[^0-9]#", "", $aid);
            $dsql->ExecuteNoneQuery("DELETE FROM `#@__onlinekefu` WHERE id='$aid'");
        }
        ShowMsg("成功删除指定在线客服！",$ENV_GOBACK_URL);
        exit();
    }
    else
    {
        ShowMsg("你没选定任何在线客服！",$ENV_GOBACK_URL);
        exit();
    }
}else if($dopost=="saveedit")
{
	require_once DEDEINC.'/request.class.php';
	$request = new Request();
	$request->Init();
    $id = preg_replace("#[^0-9]#", "", $request->Item('id', 0));
	$kefuname = $request->Item('kefuname', '');
	$kefutype = $request->Item('kefutype', '');
	$kefusize = $request->Item('kefusize', '');
	$typeid = $request->Item('typeid', 0);
	
    $query = "UPDATE `#@__onlinekefu` SET kefuname='$kefuname',kefutype='$kefutype',kefusize='$kefusize',typeid='$typeid' WHERE id='$id' ";
    $dsql->ExecuteNoneQuery($query);
    ShowMsg("成功修改一个在线客服！",$ENV_GOBACK_URL);
    exit();
}else if($dopost=="type"){
	include DedeInclude('templets/online_service_type.htm');
	exit();
}else if($dopost=="typesave"){
	$startID = 1;
	$endID = $idend;
	for(;$startID<=$endID;$startID++)
	{
		$query = '';
		$tid = ${'ID_'.$startID};
		$ptypename =   ${'ptypename_'.$startID};
		$psort =   ${'psort_'.$startID};
		if(isset(${'check_'.$startID}))
		{
			if($ptypename!='')
			{
				$query = "update `#@__onlinekefu_type` set `typename`='$ptypename',`sort`='$psort' where id='$tid' ";
				$dsql->ExecuteNoneQuery($query);
			}
		}
		else
		{
			$query = "Delete From `#@__onlinekefu_type` where id='$tid' ";
			$dsql->ExecuteNoneQuery($query);
		}
	}
	//增加新记录
	if(isset($check_new) && $ptypename_new!='')
	{
		$query = "Insert Into #@__onlinekefu_type(`typename`,`sort`) Values('{$ptypename_new}','{$psort_new}');";
		$dsql->ExecuteNoneQuery($query);
		
	}
	ShowMsg("成功更新在线客服分组！","online_service_edit.php?dopost=type");
	exit();
}
$myService = $dsql->GetOne("SELECT #@__onlinekefu.*,#@__onlinekefu_type.typename FROM #@__onlinekefu LEFT JOIN #@__onlinekefu_type ON #@__onlinekefu.typeid=#@__onlinekefu_type.id WHERE #@__onlinekefu.id=$id");
include DedeInclude('templets/online_service_edit.htm');