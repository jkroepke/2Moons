<?php

// Translated into Chinese by Arathi and 爱疯的云. All rights reversed (C) 2013
// 2Moons - Copyright (C) 2010-2012 Slaver


$LNG['back']					= '退后';
$LNG['continue']				= '继续';
$LNG['continueUpgrade']			= '升级!';
$LNG['login']					= '登陆';

$LNG['menu_intro']				= '引言';
$LNG['menu_install']			= '安装';
$LNG['menu_license']			= 'License';
$LNG['menu_upgrade']			= '升级';

$LNG['title_install']			= '安装';

$LNG['intro_lang']				= '语言';
$LNG['intro_install']			= '安装准备';
$LNG['intro_welcome']			= '您好，2Moons的用户！';
$LNG['intro_text']				= '您正在安装的2Moons，是OGame类项目中最好的实现之一。<br>2Moons是也当前仍在开发的XNova中最新最稳定的版本。2Moons的卓越之处在于其稳定、灵活、开发活跃、高质量以及被千锤百炼。我们总是希望着这部作品能够超乎你所期盼。<br><br>本安装系统将会引导你安装，或者从上个版本升级。对于使用本系统中的每一个困惑，以及发生的每一个问题，请不要犹豫，立即向开发及技术支持人员提出！<br><br>2Moons是一个开放源代码的工程，基于GNU GPL v3授权。如对此还有疑异，可以点击下方的链接查看"Lincense"<br><br>在安装开始前，会有一个小测试，用来检测您的空间的方案/域名是否能完全满足2Moons的需要';
$LNG['intro_upgrade_head']		= '已经安装过2Moons？';
$LNG['intro_upgrade_text']		= '<p>您已经安装过2Moons，然后想轻松升级到当前版本？</p><p>您只需点击几下就能完成数据库的更新！</p>';


$LNG['upgrade_success']			= '数据库升级成功！现在的数据库版本是r%s。';
$LNG['upgrade_nothingtodo']		= '您当前的数据库版本已经是r%s了。';
$LNG['upgrade_back']			= '退后';
$LNG['upgrade_intro_welcome']	= '欢迎使用数据库升级工具！';
$LNG['upgrade_available']		= '您的数据库可以正常更新！当前数据库版本为%s，可升级到%s。<br><br>请选择下拉菜单中的第一个SQL升级包开始安装：';
$LNG['upgrade_notavailable']	= '您当前的数据库只能升级到%s。';
$LNG['upgrade_required_rev']	= '更新器只能够用于r2579 (2Moons v1.7)以及更高版本。';


$LNG['licence_head']			= '许可条款';
$LNG['licence_desc']			= '请阅读以下许可条款。拖动滚动条以阅读该文档的全部内容';
$LNG['licence_accept']			= '我接受此协议的条款'; //（在安装2Moons前，您必须同意2Moons的许可条款）
$LNG['licence_need_accept']		= '若要继续安装，您必须接受此协议中的条款';

$LNG['req_head']				= '系统需求';
$LNG['req_desc']				= '在安装开始前，2Moons会做个测试，检验您的服务器是否能支持2Moons，以保证2Moons能够正常安装。建议您仔细阅读测试结果，如果检测中有未通过的项目，请勿继续安装。';
$LNG['reg_yes']					= '是';
$LNG['reg_no']					= '否';
$LNG['reg_found']				= '已找到';
$LNG['reg_not_found']			= '未找到';
$LNG['reg_writable']			= '可写入';
$LNG['reg_not_writable']		= '不可写';
$LNG['reg_file']				= '文件 &raquo;%s&laquo; 可写入？';
$LNG['reg_dir']					= '目录 &raquo;%s&laquo; 可写入？';
$LNG['req_php_need']			= '所安装的&raquo;PHP&laquo;的版本';
$LNG['req_php_need_desc']		= '<strong>必须</strong> — 2Moons基于PHP. 而且需要PHP版本高于5.2.5，这样才能使所有的模块正常工作';
$LNG['reg_gd_need']				= '已安装的GD库版本 &raquo;gdlib&laquo;';
$LNG['reg_gd_desc']				= '<strong>可选</strong> — 图像处理库 &raquo;gdlib&laquo; 用于生成动态图像。 They work without some of the features of the software.';
$LNG['reg_mysqli_active']		= '&raquo;MySQLi&laquo; 扩展支持';
$LNG['reg_mysqli_desc']			= '<strong>必须</strong> — 当前的PHP必须支持MySQLi。如果检测出您的服务器的数据库模块不可用，请与您的服务提供商联系，或者查看一下PHP的文档。';
$LNG['reg_json_need']			= '扩展 &raquo;JSON&laquo; 可用？';
$LNG['reg_iniset_need']			= 'PHP函数 &raquo;ini_set&laquo; 可用？';
$LNG['reg_global_need']			= 'register_globals 已禁用？';
$LNG['reg_global_desc']			= '即使您的服务器已经配置开启"register_globals"，2Moons也能正常工作，但出于安全考虑，还是建议尽可能地去禁用掉改选项。';
$LNG['req_ftp_head']			= '请填写FTP账户信息';
$LNG['req_ftp_desc']			= '填写您的FTP信息，以便2Moons能够自动修复权限相关的问题。或者您也可以手动去修改目录的写入权限。';
$LNG['req_ftp_host']			= '服务器名';
$LNG['req_ftp_username']		= '用户名';
$LNG['req_ftp_password']		= '密码';
$LNG['req_ftp_dir']				= '2Moons安装目录';
$LNG['req_ftp_send']			= '发送';
$LNG['req_ftp_error_data']		= '无法连接到FTP，您提供的信息有误，因此该环节失败！';
$LNG['req_ftp_error_dir']		= '您所填写的目录不存在！';

$LNG['step1_head']				= '配置数据库信息';
$LNG['step1_desc']				= '现在，已经确定了您的服务器可以安装2Moons，接着，您要提供一些数据库相关的信息。如果您不知道如何连接数据库，请先与您的服务提供商联系，或者去2Moons官方论坛寻求帮助。当你填写完相关的信息，系统会先检查是否有误，然后会建表和插入初始数据。';
$LNG['step1_mysql_server']		= '数据库服务器或DSN';
$LNG['step1_mysql_port']		= '数据库端口';
$LNG['step1_mysql_dbuser']		= '数据库用户名';
$LNG['step1_mysql_dbpass']		= '数据库密码';
$LNG['step1_mysql_dbname']		= '数据库名称';
$LNG['step1_mysql_prefix']		= '数据表前缀:';

$LNG['step2_prefix_invalid']	= '数据表的前缀必须同时包含字母和数字，并以下划线("_")结尾';
$LNG['step2_db_no_dbname']		= '请填写数据库名称';
$LNG['step2_db_too_long']		= '表前缀过长，最多只能包含36个字母';
$LNG['step2_db_con_fail']		= '数据库连接时出错。具体错误信息如下：';
$LNG['step2_conf_op_fail']		= "无法写入config.php！";
$LNG['step2_conf_create']		= 'config.php创建成功！';
$LNG['step2_config_exists']		= 'config.php已经存在！';
$LNG['step2_db_done']			= '数据库连接成功！';

$LNG['step3_head']				= '创建数据表';
$LNG['step3_desc']				= '2Moons所需的数据表已经创建成功，并且已经导入了默认值。点击下一步，结束2Moons的安装';
$LNG['step3_db_error']			= '创建数据表失败：';

$LNG['step4_head']				= '管理员账号';
$LNG['step4_desc']				= '安装器已经为您创建了管理员账号，您只需填写用户名、密码以及E-Mail。';
$LNG['step4_admin_name']		= '管理员用户名:';
$LNG['step4_admin_name_desc']	= '用户名至少3个字符，最长20个字符';
$LNG['step4_admin_pass']		= '管理员密码：';
$LNG['step4_admin_pass_desc']	= '密码至少要8个字符，最长30个字符';
$LNG['step4_admin_mail']		= '联系E-Mail：';

$LNG['step6_head']				= '安装完成！';
$LNG['step6_desc']				= '您已经成功安装2Moons';
$LNG['step6_info_head']			= '立即开始2Moons！';
$LNG['step6_info_additional']	= '点击下方的按钮，将会跳转到管理面板。<br/><br/><strong>请将&raquo;includes/ENABLE_INSTALL_TOOL&laquo;这个文件删除或改名！如果这个文件存在，可能会导致某些人恶意地去重新安装！</strong>';

$LNG['sql_close_reason']		= '游戏已关闭';
$LNG['sql_welcome']				= '欢迎来到2Moons v';
