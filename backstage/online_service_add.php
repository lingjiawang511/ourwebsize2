<?php
/**
 * 添加在线客服
 *
 * @version        $Id: online_service_add.php 8 19:23 2014年8月26日Z 土匪 $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2013 - 2014, Dedejs.Inc.
 * @license        http://bbs.dedejs.com
 * @link           http://www.dedejs.com
 */
require(dirname(__FILE__)."/config.php");
CheckPurview('plus_在线客服插件');
if(empty($dopost)) $dopost="";

if($dopost=="add")
{

    //强制检测在线客服分组是否数据结构不符
    if(empty($typeid) || preg_match("#[^0-9]#", $typeid))
    {
        $typeid = 0;
        $dsql->ExecuteNoneQuery("ALTER TABLE `#@__onlinekefu_type` CHANGE `ID` `id` MEDIUMINT( 8 ) UNSIGNED DEFAULT NULL AUTO_INCREMENT; ");
    }
    $query = "INSERT INTO `#@__onlinekefu`(kefuname,kefutype,kefusize,typeid)
            VALUES('$kefuname','$kefutype','$kefusize','$typeid'); ";
    $rs = $dsql->ExecuteNoneQuery($query);
    $burl = empty($_COOKIE['ENV_GOBACK_URL']) ? "online_service_main.php" : $_COOKIE['ENV_GOBACK_URL'];
    if($rs)
    {
        ShowMsg("成功增加一个在线客服!",$burl,0,500);
        exit();
    }
    else
    {
        ShowMsg("增加在线客服时出错，请加QQ群：217479292反馈，原因：".$dsql->GetError(),"javascript:;");
        exit();
    }
}
include DedeInclude('templets/online_service_add.htm');