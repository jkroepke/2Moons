<?php

//general
$LNG['index']				= '首页';
$LNG['register']			= '注册';
$LNG['forum']				= '论坛';
$LNG['send']				= '提交';
$LNG['menu_index']			= '首页'; 	 
$LNG['menu_news']			= '新闻';	 
$LNG['menu_rules']			= '规则'; 
$LNG['menu_agb']			= '条件'; 
$LNG['menu_pranger']		= '封禁榜';	 
$LNG['menu_top100']		= '名人堂';	 
$LNG['menu_disclamer']		= '版本';	 
	 
/* ------------------------------------------------------------------------------------------ */

//index.php
//case lostpassword
$LNG['mail_not_exist'] 		= '所报至E - mail地址不存在！';
$LNG['mail_title']				= '新密码';
$LNG['mail_text']				= '您的新密码是： ';
$LNG['mail_sended']			= '您的密码已经成功发送！';
$LNG['mail_sended_fail']		= '电子邮件不能被发送。！';
$LNG['server_infos']			= array(
	"实际时间与空间战略的游戏.",
	"与数百上千的用户一起.",
	"无需下载，只需要一个标准的浏览器.",
	"免费注册--我们推荐您使用火狐/chrome浏览器.",
);

//case default
$LNG['login_error']			= '错误的用户名和密码! <br><a href="index.php">请返回确认</a>';
$LNG['screenshots']			= '游戏截图';
$LNG['universe']				= '宇宙';
$LNG['chose_a_uni']			= '选择星痕宇宙';

/* ------------------------------------------------------------------------------------------ */

//lostpassword.tpl
$LNG['lost_pass_title']		= '恢复密码';
$LNG['retrieve_pass']			= '还原';
$LNG['email']					= '电子邮件地址';

//index_body.tpl
$LNG['user']					= '用户';
$LNG['pass']					= '密码';
$LNG['remember_pass']			= '自动登录';
$LNG['lostpassword']			= '忘记密码?';
$LNG['welcome_to']				= '欢迎来到';
$LNG['server_description']		= '<strong>%s</strong> 是一个 <strong>星际空间战略游戏  与数百上千名游戏玩家</strong> 激烈网上星际对战 <strong>由我们免费为您在中国提供所有服务.</strong> ';
$LNG['server_register']		= '现在就注册！';
$LNG['server_message']			= '立即注册，体验新的和令人兴奋的世界';
$LNG['login']					= '登录';
$LNG['disclamer']				= '联系人';
$LNG['login_info']				= '随着登录我接受 <a onclick="ajax(\'?page=rules&amp;\'+\'getajax=1\');" style="cursor:pointer;">游戏规则</a> 包括 <a onclick="ajax(\'?page=agb&amp;\'+\'getajax=1\');" style="cursor:pointer;">服务条款</a>';

/* ------------------------------------------------------------------------------------------ */

//reg.php - Registrierung
$LNG['register_closed']			= '注册关闭!';
$LNG['register_at']				= '注册于 ';
$LNG['reg_mail_message_pass']		= '再进一步激活您的用户名';
$LNG['reg_mail_reg_done']			= '欢迎到 %s!';
$LNG['invalid_mail_adress']		= '无效的电子邮件地址!<br>';
$LNG['empty_user_field']			= '请填写所有内容!<br>';
$LNG['password_lenght_error']		= '密码必须至少4个字符长!<br>';
$LNG['user_field_no_alphanumeric']	= '请输入用户名只有字母数字字符!<br>';
$LNG['user_field_no_space']		= '请输入用户名没有空格!<br>';
$LNG['planet_field_no_alphanumeric']	= '请填写星球名称只能是字母或数字!<br>';
$LNG['planet_field_no_space']		= '星球名不能为空或有空格!<br>';
$LNG['terms_and_conditions']		= '您必须同意 <a href="index.php?page=agb">服务条款</a> 和 <a href="index.php?page=rules>游戏规则</a> 才能注册!<br>';
$LNG['user_already_exists']		= '用户名已被使用!<br>';
$LNG['mail_already_exists']		= '电子邮件地址已在使用!<br>';
$LNG['wrong_captcha']				= '安全问题是不正确的!<br>';
$LNG['different_passwords']		= '您输入两个不同的密码!<br>';
$LNG['different_mails']			= '你有两个不同的电子邮件地址!<br>';
$LNG['welcome_message_from']		= '管理';
$LNG['welcome_message_sender']		= '管理';
$LNG['welcome_message_subject']	= '欢迎';
$LNG['welcome_message_content']	= '欢迎来到 %s!<br>在这里开创自己的帝国。一个崭新残酷的世界正等待着你的开启。你，或者会成为整个宇宙的王者！又或者成为其他帝国征服的对象，一切旨在你的王者之气！<br>  如有问题可以到我们的官方论坛去请教老玩家或者交给左边的客服。（注意：如果您的账号在非假期模式下超出3个月未登陆，我们将对其进行删除以维护系统数据。）<br>【请在阅读邮件后删除不用的邮件以便提高游戏处理速度】';
$LNG['newpass_smtp_email_error']	= '<br><br>发生错误。您的密码是： ';
$LNG['reg_completed']				= '感谢您注册！您将收到一个激活链接的电子邮件。';
//registry_form.tpl
$LNG['server_message_reg']			= '现在我注册的一部分';
$LNG['register_at_reg']			= '注册于';
$LNG['uni_reg']					= '宇宙';
$LNG['user_reg']					= '用户';
$LNG['pass_reg']					= '密码';
$LNG['pass2_reg']					= '确认密码';
$LNG['email_reg']					= 'E-mail地址';
$LNG['email2_reg']					= 'E-mail确认';
$LNG['planet_reg']					= '星球名';
$LNG['lang_reg']					= '语言';
$LNG['register_now']				= '马   上  注   册';
$LNG['captcha_reg']				= '安全问题';
$LNG['accept_terms_and_conditions']= '请接受并仔细查看 <a onclick="ajax(\'?page=rules&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\);" style="cursor:pointer;">游戏规则</a> 和 <a onclick="ajax(\'?page=agb&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\);" style="cursor:pointer;">服务条款</a> 。';
$LNG['captcha_reload']				= '载入';
$LNG['captcha_help']				= '说明';
$LNG['captcha_get_image']			= '载入 验证码图片';
$LNG['captcha_reload']				= '新的 CAPTCHA';
$LNG['captcha_get_audio']			= '载入声音';
$LNG['user_active']				= '用户 %s 已经被封号!';

//registry_closed.tpl
$LNG['info']						= '系统信息';
$LNG['reg_closed']					= '注册暂时已关闭，如有问题请到我们的论坛参与讨论。';

//Rules
$LNG['rules_overview']				= "Regelwerk";
$LNG['rules']						= array(
	"Accounts"					=> "Der Besitzer eines Accounts ist immer der Inhaber der festen E-mail Adresse. Ein Account darf ausschließlich alleine gespielt werden. 
	Eine Ausnahme bildet nur das Sitten. Sollte es notwendig werden, dass der Account eines Anderen überwacht oder in den Urlaubsmodus gesetzt werden muss, 
	so ist der zuständige Operator vorher zu informieren und dessen Genehmigung einzuholen. Für kurzfristiges Sitten unter 12 Stunden reicht eine Meldung an den Operator. 
	Beim Sitten sind sämtliche Flottenbewegungen verboten, lediglich das Saven der Flotte auf Koordinaten des Gesitteten und das Verbauen der Rohstoffe auf dem Planeten, auf dem sie liegen, ist erlaubt. 
	Ein Account darf für höchstens 72h gesittet werden. Bei Ausnahmen muss die Erlaubniss eines Operators vorliegen.
	Die Weitergabe eines Accounts darf max. alle 3 Monate und ausschliesslich unentgeltlich erfolgen. 
	Ausnamhen beim Operator melden.",

	"Multiaccounts"				=> "Der Besitzer eines Accounts ist immer der Inhaber der festen E-mail Adresse. Ein Account darf ausschließlich alleine gespielt werden. 
	Eine Ausnahme bildet nur das Sitten. Sollte es notwendig werden, dass der Account eines Anderen überwacht oder in den Urlaubsmodus gesetzt werden muss, 
	so ist der zuständige Operator vorher zu informieren und dessen Genehmigung einzuholen. Für kurzfristiges Sitten unter 12 Stunden reicht eine Meldung an den Operator. 
	Beim Sitten sind sämtliche Flottenbewegungen verboten, lediglich das Saven der Flotte auf Koordinaten des Gesitteten und das Verbauen der Rohstoffe auf dem Planeten, auf dem sie liegen, ist erlaubt. 
	Ein Account darf für höchstens 72h gesittet werden. Bei Ausnahmen muss die Erlaubniss eines Operators vorliegen.
	Die Weitergabe eines Accounts darf max. alle 3 Monate und ausschliesslich unentgeltlich erfolgen. 
	Ausnamhen beim Operator melden.",

	"Pushen"					=> "Pushen ist grundsätzlich verboten. Als Pushing werden alle Ressourcen-Lieferungen ohne angemessene Gegenleistung von punktschwächeren Accounts an punktstärkere Accounts gesehen. 
	Ausnahmen müssen im Vorfeld vom Operator genehmigt werden. Eine fehlende Genehmigung kann eine Sperre wegen Pushens nach sich ziehen.
	Ein Handel muss innerhalb 24 Stunden abgeschlossen oder bei einem Operator angemeldet sein.",

	"Bashen"					=> "Mehr als 5 Angriffe innerhalb von 24 Stunden auf den gleichen Planeten zählen als Bashen und sind verboten - der Mond zählt als eigenständiger Planet. Angriffe mit Spiosonden oder Interplanetarraketen werden dabei nicht gezählt.
	Die Bashregel gilt ausschließlich für aktive Spieler. Befinden sich die Parteien im Krieg, so sind weitere Angriffe erlaubt. Der Krieg muss mindestens 24 Stunden vor weiteren Angriffen im Forum erklärt werden (im Thema der Ankündigung müssen beide Allianzen bzw. der Name des kriegserklärenden Einzelspielers in korrekter Schreibweise genannt werden). Eine Kriegserklärung kann ausschließlich an Allianzen gerichtet werden, wobei die Kriegserklärung durch eine Allianz oder eine Einzelperson erfolgen kann. 
	Eine Annahme des Krieges ist nicht erforderlich. Kriege, die offensichtlich nur der massiven Umgehung der Bashregel dienen, sind verboten. Dies zu beurteilen obliegt den zuständigen Moderatoren und Operatoren.",

	"Irak-Angriffe"             => "Es sind nur 3 Irak-Angriffe pro 24 Stunden erlaubt. Die Anzahl der Raketen pro Angriff ist unabhängig.",
	
	"Bugusing"					=> "Bugs und/oder Fehler in der Programmierung auszunutzen ist verboten. Erkannte Bugs sollten so schnell wie möglich per Post im Bugforum, IRC, Email oder ICQ gemeldet werden. Cheaten ist auch verboten.",

	"Sprache im Spiel"			=> "In allen entsprechenden Universen ist Deutsch/Englisch die offizielle Sprache im Spiel. Verstöße können mit einer Sperrung des Accounts geahndet werden. Fremdsprachliche Ingame- Nachrichten/ Allypages können unter Vorbehalt zu einer Sperrung des Accounts führen.",

	"Bedrohungen/Beleidigungen"	=> "RL Erpressungen und -Bedrohungen führen zum Ausschluß aus einem oder allen Titan Space Bereichen.
	Als Real-Life-Erpressungen und -bedrohungen werden Ingamenachrichten, Forenbeiträge, IRC-Dialoge in öffentlichen Channels und ICQ-Dialoge gewertet, die eindeutige Absichten signalisieren eine Person ausfindig zu machen und ihr oder einer nahestehenden dritten Person Schaden zuzufügen.",

	"Spam und Erotik"			=> "Spammen und Fremdwerbung ist verboten.Jeweilige Form von Erotik und Pornografischen Darstellungen ist verboten. Und wird mit einer Universums weiten und Lebenslangen Sperrung geandet!",

	"Die Regeln"	=> "Die Regeln können sich ändern und jeder User ist verpflichtet sich ständig über den Stand zu Informieren !",

);

$LNG['rules_info1']				= "你可以登录 <a href=\"%s\" target=\"_blank\">OGAME论坛</a> ，这里提供了在游戏中有关的信息 ...";
$LNG['rules_info2']				= "这是补充 <a onclick=\"ajax('?page=agb&getajax=1');\" style=\"cursor:pointer;\">条件</a> 遵守和履行!</font>";



//AGB

$LNG['agb_overview']				= "Allgemeine Geschäftsbedingungen";
$LNG['agb']						= array(
	"Leistungsinhalte"				=> array( 
		"Die Anerkennung der AGBS sind nötige Voraussetzung, um am Spiel teilnehmen zu können.
		Sie gelten für alle Angebote seitens der Betreiber, einschließlich des Forums und anderer spielbezogener Inhalte.",
		
		"Das Angebot ist kostenlos.
		Somit bestehen keinerlei Ansprüche auf Verfügbarkeit, Bereitstellung, Funktionalität oder Schadensersatz.
		Weiterhin hat der Spieler keinerlei Ansprüche auf Wiederherstellung, sollte sein Account nachteilig behandelt worden sein.",
	),

	"Mitgliedschaft"				=> array(
		"Mit erfolgter Anmeldung im Spiel- und/oder im Forum beginnt die Mitgliedschaft im jeweiligen Spiel.",
		
		"Die mit der Anmeldung beginnende Mitgliedschaft kann jederzeit von Seiten des Mitglieds mit Löschung des Accounts oder durch Anschreiben eines Administrators beendet werden.
		Eine Löschung der Daten kann aus technischen Gründen nicht sofort erfolgen.",
		
		"Beendigung durch den Betreiber Kein Nutzer hat einen Anspruch auf die Teilnahme an Angeboten des Betreibers.
		Der Betreiber behält sich das Recht vor, Accounts zu löschen.
		Die Entscheidung über die Löschung von Nutzeraccounts obliegt einzig und allein dem Betreiber sowie den Administratoren und Operator.
		Jedweder Rechtsanspruch auf eine Mitgliedschaft ist ausgeschlossen.",
		
		"Sämtliche Rechte verbleiben beim Betreiber.",
	),

	"Inhalte/Verantwortlichkeit"	=> "Für den Inhalt der verschiedenen spielbezogenen Kommunikationsmöglichkeiten sind die Nutzer selbst verantwortlich. Pornographische, rassistische, beleidigende oder auf sonstige Weise gegen geltendes Recht verstoßende Inhalte liegen nicht in der Verantwortung des Betreibers.
	Verstöße können zur sofortigen Löschung oder Sperrung führen.
	Die Löschung solcher Inhalte erfolgt schnellstmöglich, kann jedoch aus technischen und/oder persönlichen Gründen verzögert werden.",

	"Verbotene Eingriffe"			=> array(
		"Der Nutzer ist nicht berechtigt, Hardware/Software oder sonstige Materien oder Mechanismen in Verbindung mit der Website zu verwenden, die die Funktion und den Spielablauf stören können.
		Der Nutzer darf weiterhin keine Maßnahmen ergreifen, die eine unzumutbare oder verstärkte Belastung der technischen Kapazitäten zur Folge haben können.
		Es ist dem Nutzer nicht gestattet, vom Betreiber generierte Inhalte zu manipulieren oder in sonstiger Weise störend in das Spiel einzugreifen.",
		
		"Jede Art von Bot, Script oder sonstige Automatisierungsfunktionen sind verboten.
		Das Spiel darf nur im Browser gespielt werden. Selbst seine Funktionen dürfen nicht genutzt werden um sich einen Spielvorteil zu verschaffen.
		Somit darf auch keine Werbung geblockt werden. Die Entscheidung, wann eine Software für den Spieler vorteilhaft ist, liegt einzig beim Betreiber/ bei den Administratoren/Operatoren.",
		
		"Ein automatisiertes öffnen des Accounts, unabhängig davon, ob dabei die Startseite angezeigt wird oder nicht, ist nicht erlaubt.",
	),

	"Nutzungsbeschränkung"		=> array(
		"Ein Spieler darf nur jeweils einen Account pro Universum nutzen, so genannte \"Multis\" sind nicht erlaubt und können ohne Warnung gelöscht/gesperrt werden.
		Die Entscheidung, wann ein \"Multi\" vorliegt, liegt einzig beim Betreiber/Administratoren/Operatoren.",
		
		"Näheres bestimmt sich nach den Spielregeln.",
		
		"Sperrungen können nach Ermessen des Betreibers dauerhaft oder temporär sein.
		Ebenso können sich Sperrungen auf einen oder alle Spielbereiche erstrecken.
		Die Entscheidung, wann und wie lange ein Spieler gesperrt wird, liegt einzig beim Betreiber/ bei den Administratoren/Operatoren.",
	),

	"Datenschutz"					=> array(
		"Der Betreiber behält sich das Recht vor, Daten der Spieler zu speichern, um die Einhaltung der Regeln, der AGB sowie geltenden Rechts zu überwachen.
		Gespeichert werden alle benötigten und vom Spieler oder seinem Account abgegebenen Daten.
		Hierzu gehören (IPs in Verbindung mit Nutzungszeiten und Nutzungsart, die bei der Anmeldung angegebene Email Adresse und weitere Daten.
		Im Forum werden die dort im Profil gemachten Angaben gespeichert.",
		
		"Diese Daten werden unter Umständen zur Wahrnehmung gesetzlicher Pflichten an Handlungsgehilfen und sonstige Berechtigte herausgegeben.
		Weiterhin können Daten (wenn notwendig) unter Umständen an Dritte herausgegeben werden.",
		
		"Der Nutzer kann der Speicherung seiner personenbezogenen Daten jederzeit widersprechen. Ein Widerspruch kommt einer Kündigung gleich.",
	),

	"Rechte des Betreibers an den Accounts"	=> array(
		"Alle Accounts und alle virtuellen Gegenstände bleiben im Besitz und Eigentum des Betreibers.
		Der Spieler erwirbt kein Eigentum und auch sonst keinerlei Rechte am Account oder an Teilen.
		Sämtliche Rechte verbleiben beim Betreiber.
		Eine übertragung von Verwertungs- oder sonstigen Rechten auf den Nutzer findet zu keinem Zeitpunkt statt.",
		
		"Unerlaubte Veräußerung, Verwertung, Kopie, Verbreitung, Vervielfältigung oder anderweitige Verletzung der Rechte (z.B. am Account) des Betreibers werden dem geltenden Recht entsprechend verfolgt.
		Ausdrücklich gestattet ist die unentgeltliche, endgültige Weitergabe des Accounts sowie das Handeln von Ressourcen im eigenen Universum, sofern und soweit es die Regeln zulassen.",
	),

	"Haftung"	=> "Der Betreiber eines jeden Universums übernimmt keine Haftung für etwaige Schäden.
	Eine Haftung ist ausgeschlossen mit Ausnahme von Schäden, die durch Vorsatz und grobe Fahrlässigkeit entstehen sowie sämtlichen Schäden an Leben und Gesundheit.
	Diesbezüglich wird ausdrücklich darauf hingewiesen, dass Computerspiele erhebliche Gesundheitsrisiken bergen können.
	Schäden sind nicht im Sinne des Betreibers.",

	"Änderung der Nutzungsbedingungen"	=> "Der Betreiber behält sich das Recht vor, diese Nutzungsbedingungen jederzeit zu ändern oder zu erweitern.
	Eine änderung oder Ergänzung wird mindestens eine Woche vor Inkrafttreten im Forum veröffentlicht.",
);

//Facebook Connect

$LNG['fb_perm']				= '你有一个禁止访问. %s 需要的所有权利，让你可以与你的Facebook帐户.\ NAlternativ登录您可以登录没有一个Facebook帐户！';
//NEWS

$LNG['news_overview']			= "新闻";
$LNG['news_from']				= "在 %s 来自 %s";
$LNG['news_does_not_exist']	= "没有记录!";

//Impressum

$LNG['disclamer']				= "免责条款";
$LNG['disclamer_name']			= "名称";
$LNG['disclamer_adress']		= "地址";
$LNG['disclamer_tel']			= "电话:";
$LNG['disclamer_email']		= "E-Mail 地址";
?>