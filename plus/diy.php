<?php
/**
 *
 * 自定义表单
 *
 * @version        $Id: diy.php 1 15:38 2010年7月8日Z tianya $
 * @package        DedeCMS.Site
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/../include/common.inc.php");

$diyid = isset($diyid) && is_numeric($diyid) ? $diyid : 0;
$action = isset($action) && in_array($action, array('post', 'list', 'view')) ? $action : 'post';
$id = isset($id) && is_numeric($id) ? $id : 0;

if(empty($diyid))
{
    showMsg('非法操作!', 'javascript:;');
    exit();
}

require_once DEDEINC.'/diyform.cls.php';
$diy = new diyform($diyid);

/*----------------------------
function Post(){ }
---------------------------*/
if($action == 'post')
{
    if(empty($do))
    {
        $postform = $diy->getForm(true);
        include DEDEROOT."/templets/plus/{$diy->postTemplate}";
        exit();
    }
    elseif($do == 2)
    {
        $dede_fields = empty($dede_fields) ? '' : trim($dede_fields);
        $dede_fieldshash = empty($dede_fieldshash) ? '' : trim($dede_fieldshash);
        if(!empty($dede_fields))
        {
            if($dede_fieldshash != md5($dede_fields.$cfg_cookie_encode))
            {
                showMsg('数据校验不对，程序返回', '-1');
                exit();
            }
        }
        $diyform = $dsql->getOne("select * from #@__diyforms where diyid='$diyid' ");
        if(!is_array($diyform))
        {
            showmsg('自定义表单不存在', '-1');
            exit();
        }

        $addvar = $addvalue = '';

        if(!empty($dede_fields))
        {

            $fieldarr = explode(';', $dede_fields);
            if(is_array($fieldarr))
            {
                foreach($fieldarr as $field)
                {
                    if($field == '') continue;
                    $fieldinfo = explode(',', $field);
                    if($fieldinfo[1] == 'textdata')
                    {
                        ${$fieldinfo[0]} = FilterSearch(stripslashes(${$fieldinfo[0]}));
                        ${$fieldinfo[0]} = addslashes(${$fieldinfo[0]});
                    }
                    else
                    {
                        ${$fieldinfo[0]} = GetFieldValue(${$fieldinfo[0]}, $fieldinfo[1],0,'add','','diy', $fieldinfo[0]);
                    }
                    $addvar .= ', `'.$fieldinfo[0].'`';
                    $addvalue .= ", '".${$fieldinfo[0]}."'";
                }
            }

        }
        $query = "INSERT INTO `{$diy->table}` (`id`, `ifcheck` $addvar)  VALUES (NULL, 0 $addvalue); ";
        if($dsql->ExecuteNoneQuery($query))
        {
			//新加程序，实现将客户留言内容发到个人邮箱
			//邮件发送开始
			/*
			$emailbody = '';
			foreach($diy->getFieldList() as $field=>$fieldvalue)
			{
				$emailbody .= $fieldvalue[0].':'.${$field}.'<br />';
			}
			global $cfg_smtp_server, $cfg_adminemail, $cfg_smtp_port, $cfg_smtp_usermail, $cfg_smtp_password, $cfg_webname, $cfg_basehost, $cfg_smtp_user;
			//引入PHPMailer的核心文件 使用require_once包含避免出现PHPMailer类重复定义的警告
			require_once("class.phpmailer.php"); 
			require_once("class.smtp.php");
			//实例化PHPMailer核心类
			$mail = new PHPMailer();
			//是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
			$mail->SMTPDebug = false;
			//使用smtp鉴权方式发送邮件
			$mail->isSMTP();
			//smtp需要鉴权 这个必须是true
			$mail->SMTPAuth=true;
			//链接qq域名邮箱的服务器地址
			$mail->Host = $cfg_smtp_server;
			//设置使用ssl加密方式登录鉴权
			$mail->SMTPSecure = 'ssl';
			//设置ssl连接smtp服务器的远程服务器端口号，以前的默认是25，但是现在新的好像已经不可用了 可选465或587
			$mail->Port = $cfg_smtp_port;
			//设置smtp的helo消息头 这个可有可无 内容任意
			// $mail->Helo = 'Hello smtp.qq.com Server';
			//设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名
			$mail->Hostname = $cfg_basehost;
			//设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
			$mail->CharSet = 'UTF-8';
			//设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
			$mail->FromName = $cfg_smtp_user;
			//smtp登录的账号 这里填入字符串格式的qq号即可
			$mail->Username = $cfg_smtp_usermail;
			//smtp登录的密码 使用生成的授权码（就刚才叫你保存的最新的授权码）
			$mail->Password = $cfg_smtp_password;
			//设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
			$mail->From = $cfg_smtp_usermail;
			//邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
			$mail->isHTML(true); 
			//设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
			$mail->addAddress($cfg_shoujianren,$cfg_smtp_user);
			//添加多个收件人 则多次调用方法即可
			// $mail->addAddress('xxx@163.com','lsgo在线通知');
			//添加该邮件的主题
			$mail->Subject = $diy->name;
			//添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
			$mail->Body = $emailbody;
			//为该邮件添加附件 该方法也有两个参数 第一个参数为附件存放的目录（相对目录、或绝对目录均可） 第二参数为在邮件附件中该附件的名称
			// $mail->addAttachment('./d.jpg','mm.jpg');
			//同样该方法可以多次调用 上传多个附件
			// $mail->addAttachment('./Jlib-1.1.0.js','Jlib.js');
			if(!$mail->send())  
			{  
				echo "Fail to send. <p>";  
				echo "Cause of the error: " . $mail->ErrorInfo;  
				exit;  
			}
			*/
			//邮件发送结束
			//新加程序，实现将客户留言内容发到个人邮箱 
            $id = $dsql->GetLastID();
            if($diy->public == 2)
            {
                //diy.php?action=view&diyid={$diy->diyid}&id=$id
                $goto = "diy.php?action=list&diyid={$diy->diyid}";
                $bkmsg = '发布成功，现在转向表单列表页...';
            }
            else
            {
                $goto = !empty($cfg_cmspath) ? $cfg_cmspath : '/';
                $bkmsg = '发布成功，请等待管理员处理...';
            }
            showmsg($bkmsg, $goto);
        }
    }
}
/*----------------------------
function list(){ }
---------------------------*/
else if($action == 'list')
{
    if(empty($diy->public))
    {
        showMsg('后台关闭前台浏览', 'javascript:;');
        exit();
    }
    include_once DEDEINC.'/datalistcp.class.php';
    if($diy->public == 2)
        $query = "SELECT * FROM `{$diy->table}` ORDER BY id DESC";
    else
        $query = "SELECT * FROM `{$diy->table}` WHERE ifcheck=1 ORDER BY id DESC";

    $datalist = new DataListCP();
    $datalist->pageSize = 10;
    $datalist->SetParameter('action', 'list');
    $datalist->SetParameter('diyid', $diyid);
    $datalist->SetTemplate(DEDEINC."/../templets/plus/{$diy->listTemplate}");
    $datalist->SetSource($query);
    $fieldlist = $diy->getFieldList();
    $datalist->Display();
}
else if($action == 'view')
{
    if(empty($diy->public))
    {
        showMsg('后台关闭前台浏览' , 'javascript:;');
        exit();
    }

    if(empty($id))
    {
        showMsg('非法操作！未指定id', 'javascript:;');
        exit();
    }
    if($diy->public == 2)
    {
        $query = "SELECT * FROM {$diy->table} WHERE id='$id' ";
    }
    else
    {
        $query = "SELECT * FROM {$diy->table} WHERE id='$id' AND ifcheck=1";
    }
    $row = $dsql->GetOne($query);

    if(!is_array($row))
    {
        showmsg('你访问的记录不存在或未经审核', '-1');
        exit();
    }

    $fieldlist = $diy->getFieldList();
    include DEDEROOT."/templets/plus/{$diy->viewTemplate}";
}