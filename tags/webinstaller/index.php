<?php

/**
 *  2Moons
 *  Copyright (C) 2011  Slaver
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package 2Moons Webinstaller
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.0 (2011-02-03)
 * @link http://code.google.com/p/2moons/
 */
 

// Get RootPath
$ROOT		= dirname(__FILE__).'/';

// Set Revision
$REV		= !isset($_GET['revision']) ? 1 : (int) $_GET['revision'];

// Set SVN Paths
$SVN		= 'http://2moons.googlecode.com/';
$SVNHIS		= $SVN.'svn-history/r'.$REV.'/trunk/';
$SVNPATH	= $SVN.'svn/trunk/';
$SMARTYSVN	= 'http://smarty-php.googlecode.com/svn/trunk/distribution/libs/';
$CAPTCHASVN	= 'http://recaptcha.googlecode.com/svn/trunk/recaptcha-plugins/php/';

// Set Functions for ErrorHandling
function ErrorHandler($errno, $errstr, $errfile, $errline) {
    switch ($errno) {
        case E_WARNING:
        case E_USER_WARNING:
            $error = '<b>Warning:</b> '.$errstr;
        break;
        case E_ERROR:
        case E_USER_ERROR:
            $error = '<b>Fatal Error:</b> '.$errstr;
        break;
        default:
            $error = '<b>Unknown:</b> '.$errstr;
        break;
    }

	if (!headers_sent())
		header('HTTP/1.1 200 OK');

	echo json_encode(array('status' => $error));
    exit;
}

function FatalErrorHandler()
{
    if ($error = error_get_last())
        ErrorHandler($error['type'], $error['message'], $error['file'], $error['line']);
}

set_error_handler('ErrorHandler');
register_shutdown_function('FatalErrorHandler');

// Start AJAX Actions
if(isset($_GET['action'])) {
	ini_set('display_errors', 0);
	switch($_GET['action']) {
		case 'filelist': // Get Filelist from SVN
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $SVNHIS.'includes/filelist');
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_CRLF, true);
			curl_setopt($ch, CURLOPT_USERAGENT, "2Moons WebInstaller");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			echo json_encode(explode("\r\n", curl_exec($ch)));
			rename(__FILE__, $ROOT.'webinstall.php');
		break;
		case 'require': // Get Requriments for 2Moons
			echo json_encode(array(
				'php'		=> version_compare(PHP_VERSION, "5.2.5", ">=") ? 'yes' : 'no',
				'mysqli'	=> class_exists('mysqli') ? 'yes' : 'no',
				'iniset'	=> function_exists('ini_set') ? 'yes' : 'no',
				'curl'		=> function_exists('curl_init') ? 'yes' : 'no',
				'root'		=> is_writable($ROOT) ? 'yes' : 'no',
			));
		break;
		case 'revision': // Get last Revisions Number
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $SVNPATH);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_CRLF, true);
			curl_setopt($ch, CURLOPT_USERAGENT, "2Moons WebInstaller");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			echo (int)preg_replace('/.*Revision (\d{1,4}).*/im', '$1', curl_exec($ch));
		break;
		case 'unlink': // Delete Installfiles
			unlink($ROOT.'webinstall.php');
			unlink($ROOT.'install.php');
			unlink($ROOT.'install.sql');
		break;
		case 'download': // Download a File
			if(strpos($_GET['file'], '.') === false) {
				if(!file_exists($ROOT.$_GET['file']))
					mkdir($ROOT.$_GET['file']);
				echo json_encode(array('status'	=> 'OK'));
				exit;
			}
			if(strpos($_GET['file'], 'libs/Smarty/') !== false) {
				$SVNHIS	= $SMARTYSVN;
				$Path	= str_replace('includes/libs/Smarty/', '', $_GET['file']);
			} elseif(strpos($_GET['file'], 'libs/reCAPTCHA/') !== false) {
				$SVNHIS	= $CAPTCHASVN;
				$Path	= str_replace('includes/libs/reCAPTCHA/', '', $_GET['file']);
			} elseif($_GET['file'] == '.htaccess' && file_exists($ROOT.'.htaccess')) {
				$Path	= $_GET['file'];
				$_GET['file']	= '_htaccess';
			} else {
				$Path	= $_GET['file'];
			}
			$fp	= fopen($ROOT.$_GET['file'], 'w');
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_AUTOREFERER, true);
			curl_setopt($ch, CURLOPT_URL, $SVNHIS.$Path);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_USERAGENT, "2Moons WebInstaller");
			curl_setopt($ch, CURLOPT_CRLF, true);
			curl_setopt($ch, CURLOPT_FILE, $fp);
			curl_exec($ch);
			if(curl_errno($ch))
				echo json_encode(array('status'	=> curl_error($ch)));
			else
				echo json_encode(array('status'	=> 'OK'));
				
			curl_close($ch);
			fclose($fp);			
		break;
	}
	exit;
}
?>
<!DOCTYPE html>

<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/blitzer/jquery-ui.css">
<style type="text/css">h2{text-align:center}#selector{float:right}label{white-space:nowrap;width:110px;float:left;margin-top:4px}ul{list-style:none;margin:0;padding:0}.val{margin:0 auto;color:black;text-align:center;position:relative;top:14px}.ui-progressbar,.ui-progressbar-value{height:15px}.ui-progressbar-value{float:left}.left{text-align:left}.right{text-align:right;float:right}.no{color:red}.ok{color:#FF0}.transparent{background:none;border:none}.yes{color:lime}a{text-decoration:none}a:focus{outline:none}a:hover{color:red;text-decoration:none}body{background:url(http://2moons.googlecode.com/svn/trunk/styles/theme/gow/img/bkd_page.jpg) top left fixed #000;margin-top:20px;padding:0}body,input,button,select,textarea,a,td,th,tr,table{color:#CCC;font-family:Verdana;font-size:10px}button,input{border:1px solid #212121;margin:2px;text-align:center}button,input,select,option,textarea{background:#393939;text-align:left}select{border:1px solid #212121}table{margin:auto}table table{border:0}table,td,th{empty-cells:show;font-weight:400}td{text-align:center;background:url(http://2moons.googlecode.com/svn/trunk/styles/theme/gow/img/bkd_bg.png) no-repeat #090909;border:1px solid #222;padding-left:3px;padding-right:3px}textarea{width:97%}th{background:url(http://2moons.googlecode.com/svn/trunk/styles/theme/gow/img/bkd_title.png);color:#FFF;font-weight:700;height:22px;line-height:18px;padding-left:3px;text-align:left}button{display:block;margin:2px auto;cursor:pointer}</style>
<link rel="icon" href="data:image/ico;base64,AAABAAEAEBAAAAEAGABoAwAAFgAAACgAAAAQAAAAIAAAAAEAGAAAAAAAAAAAAEgAAABIAAAAAAAAAAAAAADu8fDg5OOnp6WFhYGgn53v8Njy8rjx8qnz98Lq7KDVzmDBqDG2jyeseiKTXxaDUBDv8PDv8fHx8vPm5+mQjolraFrn57Dy9LH0+NHo6qbPxFq4mimugCOgaxuHVBF5Sg/t8fPv8vLx8vLx8/Pz9O+QjoJWVEfv8df1+Nbn6JrQxVa5nC+qfCWYZhmDUxF1ShDt8e/v8u3x8uPw89fs7cLj4rlBPjJ6eG/5/eLw9azg2W/HrkWrgiiWZRuCVBZ0TRXt8dXu8dvw8sfw8qrv8Kbc252VlHEdGRCNjHK3uYTb2YHYyGS8nECmeS2PYiF5Uxru8LTv8MXw8bHw8Iv19arf36izsH8XEwqEf1atqG98eEmOhk/HtGTCnkuoezOJXyPv8rnu8cPv8LPy8o/4+sL2+c7m46knIhQ+OCLJu3bax32ckFxoYECplFW8k0Sbby3y98ry9drx887y8Jjx7aLu7Knf25skHxRTTDNMQy/Er3PXv364omdUTDudgUmlejXm65/t88Lx9cbr5ovj1Xbj1YG9tHkfGxM5MydCOyvFrnbRtnnJqmxeVUZnW0aeejnOzlfe4n7m6ZDf1m/awmTfx3d5bk0oJB19c1LYxIjTvoGvmmt2a1VVT0Z4Yz+NbjXBtEXOyVfW02TXyWPZvWy/p205NCo+OS+jlGuKfV5vZU9iWUdmWUGGbUKJbDp5Wy27oUjDsVDLvl3TwWi7pGVQSDg6Ni52aUqFdlGNelGUfU6agEqRdEGCZjZwVSpnSyO/oFTMs1/DsWWHelBJQzg9OTKRfVTNr2zFomCvjVCWeUGFaTV3WyxpTyRiSCJiRSBbTzRYUDhEPjM/OzRPRziSfVCylVyti1KpgUWYbzd/XiprUCBgRhxdRBxhRSBiQyFLQzBXTjlrYEOLd0qpkFShhk6UdUOIZzWEXit8VSBrShlZPhVWOxNeQRliQh1cPBypik28mVa5l1Ofg0eSdz+EaTZ0VylmSR1gQhVgPxJcPBFZOhNbPRZbPRhWORdRNRcAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA">
<title>WebInstaller • 2Moons</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<script type="text/javascript">
var i18n	= new Object();
i18n['de']	= {name:'Deutsch',title:'Webinstaller',yes:'Ja',no:'Nein',head:'Installieren','continue':'Weiter',done:'Fertig',error_head:'Fehler',error_msg:'Fehler beim Download der Datei:',error_offline:'Du bist nicht mit dem Internet verbunden!',error_server:'Internel Server Error',error_parse:'Parsing JSON Request failed.',error_timeout:'Request Timeout.',error_abort:'User hat abgebrochen',error_unkown:'Unbekannter Fehler:<br>',error_cancel:'Abbruch',error_no_json:'Auf dem Server fehlt die PHP Extension JSON! - 2Moons kann nicht installiert werden!',bar_step1:'Step 1 - Einführung',bar_step2:'Step 2 - Vorrausetztungen',bar_step3:'Step 3 - Revisionsauswahl',bar_step4:'Step 4 - Download 2Moons',bar_step5:'Step 5 - Install 2Moons',bar_step6:'Step 6 - Fertig',step1_head:'Herzlich Willkommen beim 2Moons!',step1_desc:'2Moons ist eines der besten Klone von OGame.<br>2Moons ist die neueste und stabilste XNova Version je entwickelt wurde. 2Moons glänzt durch Stabilität, Flexibilität, Dynamik, Qualität und Benutzerfreundlichkeit. Wir hoffen immer besser zu sein als ihre Erwartungen.<br><br>Das Installations-System führt Sie durch die Installation, oder Upgrade auf einer vorherigen Version auf die neueste ein. Jede Frage, ein Problem zögern Sie bitte nicht, unsere Entwicklung und Unterstützung zu ersuchen.<br><br>2Moons ist ein OpenSource-Projekt und ist under GNU GPL v3 lizenziert. Zur Lizenz klicken Sie bitte im Menu auf die entsprechenden Menüpunkt.<br><br>Bevor die Installation gestartet werden kann, wird vorher ein kleiner Test durchgeführt, ob sie die Mindestanforderungen unterstützen.<br><br>',step1_head:'Herzlich Willkommen beim 2Moons!',step2_php:'PHP-Version (min. 5.2.5)',step2_iniset:'ini_set erlaubt?',step2_curl:'cURL vorhanden?',step2_mysqli:'MySQLi vorhanden?',step2_root:'Verzeichnis beschreibar?',step3_dec:'Wähle hier aus, welche Revision du downloaden möchtest.',step3_lastrev:'(aktuelle Revision)',step3_revision:'Revision',step4_head:'Download 2Moons',step4_setins:'Einstellungen: AutoInstall',step4_download:'Download',step4_file:'Datei',step5_head:'Install 2Moons',dialog_head:'Installationsdaten',dialog_db_host:'MySQL Server',dialog_db_port:'MySQL Port',dialog_db_name:'MySQL Datenbank',dialog_db_user:'MySQL User',dialog_db_pass:'MySQL Passwort',dialog_db_prefix:'MySQL Tabellenprefix',dialog_adm_user:'Adminname',dialog_adm_pass:'Adminpasswort',dialog_adm_email:'Adminmailadresse',dialog_save:'Speichern',};
i18n['en']	= {name:'English',title:'Webinstaller',yes:'Yes',no:'No',head:'Install','continue':'Continue',done:'Done',error_head:'Error',error_msg:'Error downloading file:',error_offline:'You are not contected to the internet!',error_server:'Internel Server Error',error_parse:'Parsing JSON Request failed.',error_timeout:'Request Timeout.',error_abort:'User has aborted',error_unkown:'Unknown error:<br>',error_cancel:'Cancel',error_no_json:'The PHP Extension JSON! is missing on the server - 2Moons can not be installed!',bar_step1:'Step 1 - Introduction',bar_step2:'Step 2 - Conditions',bar_step3:'Step 3 - Version selection',bar_step4:'Step 4 - Download 2Moons',bar_step5:'Step 5 - Install 2Moons',bar_step6:'Step 6 - Finish',step1_head:'Welcome to 2Moons!',step1_desc:'2Moons is one of the best clones of OGame.<br>2Moons is the latest and most stable version of XNova ever developed. 2Moons shines with stability, flexibility, dynamism, quality and usability. We always hope to be better than your expectations. <br><br> The installation system will guide you through the installation or upgrade from a previous version to the latest one. Any questions or problems please do not hesitate to contact our development and support team. <br><br> 2Moons is an open source project and is under GNU GPL v3 license. To view the license, click the on the appropriate menu item. <br><br> Before the installation can be started there is a little test made as to whether you can support the minimum requirements.<br><br>',step1_head:'Welcome to 2Moons!',step2_php:'PHP-Version (min. 5.2.5)',step2_iniset:'ini_set Allowed?',step2_curl:'cURL present?',step2_mysqli:'MySQLi present?',step2_root:'Database writable?',step3_dec:'Choose here which revision you would like to download.',step3_lastrev:'(Actual Revision)',step3_revision:'Revision',step4_head:'Download 2Moons',step4_setins:'Settings: AutoInstall',step4_download:'Download',step4_file:'File',step5_head:'Install 2Moons',dialog_head:'Installation',dialog_db_host:'MySQL Server',dialog_db_port:'MySQL Port',dialog_db_name:'MySQL DatabaseName',dialog_db_user:'MySQL User',dialog_db_pass:'MySQL Password',dialog_db_prefix:'MySQL Tableprefix',dialog_adm_user:'Adminname',dialog_adm_pass:'Adminpassword',dialog_adm_email:'Adminemailaddress',dialog_save:'Save',};
i18n['es']	= {name:'Spanish',title:'Instalador Web',yes:'Sí',no:'No',head:'Instalación','continue':'Siguiente',done:'Done',error_head:'Error',error_msg:'Error al descargar archivo:',error_offline:'No estas conectado a internet!',error_server:'Error Interno del Servidor',error_parse:'Petición del analisis de JSON fallido.',error_timeout:'Tiempo de espera agotado.',error_abort:'El usuario abortó',error_unkown:'Error desconocido:<br>',error_cancel:'Cancelar',error_no_json:'El servidor no tiene instalado la extensión PHP JSON! - 2Moons no se puede isntalar!',bar_step1:'Step 1 - Introducción',bar_step2:'Step 2 - Condiciones',bar_step3:'Step 3 - Selección',bar_step4:'Step 4 - Descargar 2Moons',bar_step5:'Step 5 - Instalar 2Moons',bar_step6:'Step 6 - Finalizar',step1_head:'Bienvenido a 2Moons!',step1_desc:'2Moons es uno de los mejores clones de Ogame.<br>2Moons es la versión más reciente y más estable de XNova que se haya desarrollado. 2Moons luce por su estabilidad, flexibilidad, dinamismo, calidad y facilidad de uso. Nosotros siempre esperamos mejorar sus expectativas.<br><br> El sistema de instalación le guiará a través de la instalación o la actualización a una versión anterior a la última. Cualquier pregunta o problema no dude en consultarla en nuestro foro de desarrollo y soporte.<br><br>2Moons es un proyecto de código abierto y está bajo licencia GNU GPL v3. Para ver la licencia, haga clic la opción del menú correspondiente.<br><br>Antes de la instalación se puede iniciara una pequeña prueba para ver si se soportan los requisitos mínimos.<br><br>',step1_head:'Bienvenido a 2Moons!',step2_php:'PHP-Version (min. 5.2.5)',step2_iniset:'ini_set permitido?',step2_curl:'cURL disponible?',step2_mysqli:'MySQLi disponible?',step2_root:'Permisos de escritura?',step3_dec:'Elige aquí la revisión que quieres descargar.',step3_lastrev:'(Revisión actual)',step3_revision:'Revisión',step4_head:'Descargar 2Moons',step4_setins:'Configuración: AutoInstall',step4_download:'Descargar',step4_file:'Archivo',step5_head:'Instalar 2Moons',dialog_head:'Instalación',dialog_db_host:'Servidor MySQL',dialog_db_port:'Puerto MySQL',dialog_db_name:'Base de Datos MySQL',dialog_db_user:'Usuario MySQL',dialog_db_pass:'Contraseña MySQL',dialog_db_prefix:'Prefijo de tablas MySQL',dialog_adm_user:'Usuario Admin',dialog_adm_pass:'Contraseña Admin',dialog_adm_email:'E-Mail Admin',dialog_save:'Guardar',};
i18n['pt']	= {name:'Português',title:'Instalar a Web',yes:'Sim',no:'Não',head:'Instalação','continue':'Seguinte',done:'Concluir',error_head:'Erro',error_msg:'Erro em descarregar o arquivo:',error_offline:'Não estás ligado à Internet!',error_server:'Erro Interno do Servidor',error_parse:'Pedido de análise JSON falhou.',error_timeout:'Tempo de espera expirado',error_abort:'O utilizador abortou a operação',error_unkown:'Erro desconocido:<br>',error_cancel:'Cancelar',error_no_json:'O servidor não tem a extensão PHP JSON!! - Não é possivel instalar o 2Moons!',bar_step1:'Step 1 - Introdução',bar_step2:'Step 2 - Condições de Uso',bar_step3:'Step 3 - Selecionar',bar_step4:'Step 4 - Descarregar/Download do 2Moons',bar_step5:'Step 5 - Instalar 2Moons',bar_step6:'Step 6 - Terminar',step1_head:'Bemvindo a 2Moons!',step1_desc:'Bemvindo a um dos melhores clones do OGame , o 2Moons<br>A versão mais recente 2Moons porque a taxa fixa foi já desenvolvido. 2Moons brilha pela estabilidade, flexibilidade, dinâmica, qualidade e facilidade de utilização. Desejamos sempre ser melhor do que suas expectativas.<br><br>Os guias de instalação do sistema através da instalação ou atualização de uma versão mais antiga para a mais Na dúvida ou problema não hesite em contactar-nos (2moons.cc).<br><br>2Moons é um projeto de código aberto licenciado sob a GNU GPL v3. Para obter a licença, clique no item do menu.<br><br>Antes da instalação começar, um teste é realizado, se os requisitos do sistema são atendidas.<br><br>',step2_php:'PHP-Version (min. 5.2.5)',step2_iniset:'ini_set permitido?',step2_curl:'cURL disponivel?',step2_mysqli:'MySQLi disponivel?',step2_root:'Permissão de Escrita?',step3_dec:'Escolhe a revisão da versão que desejas fazer o Download',step3_lastrev:'(Revisão Actual)',step3_revision:'Revisão',step4_head:'Download do 2Moons',step4_setins:'Configurações: AutoInstall (Instalador Automático)',step4_download:'Executar o Download',step4_file:'Executar o Download',step5_head:'Instalar 2Moons',dialog_head:'Instalação',dialog_db_host:'Servidor MySQL',dialog_db_port:'Porta MySQL',dialog_db_name:'Base de Datdos MySQL',dialog_db_user:'Utilizador MySQL',dialog_db_pass:'Senha/Password MySQL',dialog_db_prefix:'Prefixo de tablas MySQL',dialog_adm_user:'Nick do Admin',dialog_adm_pass:'Senha do Admin',dialog_adm_email:'E-Mail do Admin',dialog_save:'Guardar',};
i18n['ru']	= {name:'Русский',title:'Установщик',yes:'Да',no:'Нет',head:'Установить','continue':'Дальше',done:'Отделка',error_head:'Ошибка',error_msg:'Ошибка загрузки файлов:',error_offline:'Вы не подключены к Интернету!',error_server:'Внутренняя ошибка сервера',error_parse:'Анализ JSON запроса не завершился.',error_timeout:'Превышено время обработки запроса.',error_abort:'Пользователь отменил действия',error_unkown:'Неизвестная ошибка:<br>',error_cancel:'Отмена',error_no_json:'На сервере нет PHP расширения JSON! - 2Moons не может быть установлен!',bar_step1:'Шаг 1 - Описание',bar_step2:'Шаг 2 - Условия использования',bar_step3:'Шаг 3 - Выбор версии',bar_step4:'Шаг 4 - Скачивание 2Moons',bar_step5:'Шаг 5 - Установка 2Moons',bar_step6:'Шаг 6 - Готово',step1_head:'Добро пожаловать в 2Moons!',step1_desc:'2Moons является одним из лучших клонов OGame.<br>2Moons является самым стабильным и развивающимся движком из всех подобных XNova на данный момент. Мы надеемся, что 2Moons будет лучше, чем вы ожидаете.<br><br>Установщик проведёт вас через процесс установки или обновления с ранних версий на актуальную.Если у Вас будут вопросы, консультируйтесь с нами.<br><br>2Moons является проектом с открытым кодом и распространяется под лицензией GNU GPL v3, ознакомиться с которой Вы можете в разделе Лицензия.<br><br>Перед установкой будет запущен небольшой тест на соответствие минимальным требованиям.<br><br>',step2_php:'PHP-версия (мин. 5.2.5)',step2_iniset:'ini_set разрешён?',step2_curl:'cURL доступен?',step2_mysqli:'MySQLi доступна?',step2_root:'Разрешена запись в каталог?',step3_dec:'Выберите версию, которую вы хотели бы скачать.',step3_lastrev:'(актуальная версия)',step3_revision:'Версия',step4_head:'Скачивание 2Moons',step4_setins:'Настройки: Автоустановка',step4_download:'Скачать',step4_file:'Файл',step5_head:'Установка 2Moons',dialog_head:'Установочные данные',dialog_db_host:'MySQL сервер',dialog_db_port:'MySQL порт',dialog_db_name:'MySQL название базы данных',dialog_db_user:'MySQL логин',dialog_db_pass:'MySQL пароль',dialog_db_prefix:'MySQL префикс',dialog_adm_user:'Логин',dialog_adm_pass:'Пароль',dialog_adm_email:'Электронная почта',dialog_save:'Сохранить',};
</script>
<script type="text/javascript">
var LNG 			= new Object();
var filelist 		= new Array();
var files 			= 0;
var filepointer 	= -1;
var error 			= false;
var revision 		= 0;
var lastrev 		= 0;
var callback 		= function() {};
var dialogClose		= function() {callback()};

$(document).ready(function() {
	setLNG('de');
	$('#step').progressbar();
	$('#step_info').text(LNG['bar_step1']);
	$('#dialog').dialog({
		title : LNG['dialog_head'],
		autoOpen : false,
		width: 315,
		height: 330,
		close: dialogClose
	});
	$.each(i18n, function(key, name) {
		$('#selector').append('<option value="'+key+'">'+name['name']+'</option>');
	});
});

function step2() {
	$.getJSON('?action=require', function (data) {
		$.each(data, function(title, value) {
			$('#requires').append('<tr><td class="transparent" style="width:50%;">'+LNG['step2_'+title]+'</td><td style="width:50%;" class="transparent '+value+'">'+LNG[value]+'</td></tr>');
			if(value == 'no') 
				error = true;
		});
		if(error == false) 
			$('#button').show();
	});
	$('#step1').hide();
	$('#step2').show();
	$('#step_info').text(LNG['bar_step2']);
	$('#step .ui-progressbar-value').animate({width : '20%'}, 400);
}

function step3() {
	$.get('?action=revision', function(data) {
		lastrev = data;
		$('#step3').show();
	});
	$('#step2').hide();
	$('#step_info').text(LNG['bar_step3']);
	$('#step .ui-progressbar-value').animate({width : '40%'}, 400);
}

function step4() {
	revision = $('#rev').val();
	if(revision == '' || isNaN(Math.round(revision))) 
		revision = lastrev;
	$.getJSON('?action=filelist&revision=' + revision, initDL);
	$('#step3').hide();
	$('#step4').show();
	$('#step_info').text(LNG['bar_step4']);
	$('#step .ui-progressbar-value').animate({width : '60%'}, 400);
}

function step5() {
	document.title = LNG['title'] + ' • 2Moons';
	$('#step4').hide();
	$('#step5').show();
	$('#step_info').text(LNG['bar_step5']);
	$('#step .ui-progressbar-value').animate({width : '80%'}, 400);
	installGame();
}

function initDL(data) {
	filelist = data;
	files = data.length;
	$('#progressbar').progressbar();
	downloadFile();
}

function downloadFile(msg) {
	if(filepointer + 1 == files) {
		step5();
		return;
	}
	if(typeof msg == 'object' && msg.status != 'OK')
		return downloadError(msg.status);
		
	$.ajax('webinstall.php?action=download&revision=' + revision + '&file=' + filelist[++filepointer], {
		dataType: 'json',
		success: downloadFile,
		error:function(x,e){
			if(x.status == 0)
				downloadError(LNG['error_offline']);
			else if(x.status == 500) 
				downloadError(LNG['error_server']);
			else if(e == 'parsererror')
				downloadError(LNG['error_parse']+'<br>'+x.responseText);
			else if(e == 'timeout')
				downloadError(LNG['error_timeout']);
			else if(e == 'abort')
				downloadError(LNG['error_abort']);
			else
				downloadError(LNG['error_unkown']+'<br>'+x.responseText);
		}
	});
	$('#info').text(LNG['step4_download']+'('+LNG['step4_file']+': '+filepointer+'/'+files+'): ' + filelist[filepointer] + '');
	$('#progressbar .ui-progressbar-value').css('width', (filepointer / files * 100) + '%');
	$('.val').text((Math.round(filepointer / files * 10000) / 100) + ' %');
	document.title = LNG['step4_download'] + ' ' + Math.floor(filepointer / files * 100) + '% • ' + LNG['title'] + ' • 2Moons';
}

function downloadError(msg) {
	$('#error').html(LNG['error_msg']+'<br>./'+filelist[filepointer]+'<br>'+msg+'<br>'+LNG['error_cancel']).dialog({
		title: LNG['error_head'],
		buttons: {
			OK: function() {
				$(this).dialog("close");
			}
		}
	});
	return false;
}

function setDialogCallback(func) {
	callback	= func;
	return $('#dialog');
}

function setLNG(lang) {
	if(typeof i18n[lang] === 'object') {
		LNG	= i18n[lang];
		parseLang();
	}
}

function parseLang() {
	$.each(LNG, function(key, value) {
		$('#'+key).html(value);
	});
	$('.continue').text(LNG['continue']);
	$('#step_info').text(LNG['bar_step1']);
	document.title	= LNG['title'] + ' • 2Moons';
}

function installGame() {
	if($('#db_database').val() == "" || $('#db_user').val() == "") {
		setDialogCallback(installGame).dialog('open');
		return false;
	}
	$.getJSON('install/index.php?mode=ajax&action=install&' + $('#database').serialize(), function(data) {
		if(data.error) {
			$('#dialoghead').html(data.msg.replace(/\n/g, '<br>'));
			setDialogCallback(installGame).dialog('open');
		} else {
			createAdminAccount();
		}
	});
}

function createAdminAccount() {
	$('#database').hide();
	if($('#admin_user').val() == "" || $('#admin_pass').val() == "" || $('#admin_email').val() == "") {
		setDialogCallback(createAdminAccount).dialog('open');
		return false;
	} else {
		$.post('install/index.php?mode=ins&page=3&lang=' + LNG['name'], $('#admin').serialize(), function() {
			$.get('admin.php?page=update&version=1.3.' + revision, function() {
				$.get('webinstall.php?action=unlink', function() {
					alert(LNG['done']);
					return;
					document.location = 'admin.php';
				});
			});
		});
	}
}
</script>
</head>
<body>
<table style="width:700px">
	<tr>
		<th colspan="3" id="head"></th>
	</tr>
	<tr>
		<td>
		<div id="step"></div><div id="step_info" class="left"></div>
		</td>
	</tr>
	<tr>
		<td>
			<div id="step1">
				<h2 id="step1_head"></h2><select onchange="setLNG($('#selector').val())" id="selector"></select><br>
				<div class="left" id="step1_desc"></div>
				<?php if(extension_loaded('json')) { ?>
				<button onclick="step2();" class="continue"></button>
				<?php } else { ?>
				<span id="error_no_json" class="no"></span>
				<?php } ?>
			</div>
			<div id="step2" style="display:none;">
				<table style="width:100%" id="requires"></table>
				<button style="display:none" onclick="step3();" class="continue" id="button"></button>
			</div>
			<div id="step3" style="display:none;">
				<span id="step3_desc"></span><br><br>
				<span id="step3_revision"></span>: <input id="rev" type="text"> <a href="#" onclick="$('#rev').val(lastrev);return false;" id='step3_lastrev'></a><br><br>
				<button onclick="step4();" class="continue"></button>
			</div>
			<div id="step4" style="display:none;">
				<h2 id="step4_head"></h2><br>
				<div class="val"></div>
				<div id="progressbar"></div><div id="info" class="left"></div><br>
				<a href="#" onclick="$('#dialog').dialog('open');return false" class="right" id="step4_setins"></a>
			</div>
			<div id="step5" style="display:none;">
				<h2 id="step5_head"></h2><br>
				<div id="install" class="left"></div>
			</div>
		</td>
	</tr>
</table>
<div id="dialog" style="display:none;">
	<span id="dialoghead"></span><br>
	<form id="database" action="webinstall.php" onsubmit="return false">
	<ul>
		<li><label id="dialog_db_host" for="db_host"></label> <input type="text" id="db_host" name="host" value="localhost" size="30"></li>
		<li><label id="dialog_db_port" for="db_port"></label> <input type="text" id="db_port" name="port" value="3306" size="30"></li>
		<li><label id="dialog_db_name" for="db_database"></label> <input type="text" id="db_database" name="db" value="" size="30"></li>
		<li><label id="dialog_db_user" for="db_user"></label> <input type="text" id="db_user" name="user" value="" size="30"></li>
		<li><label id="dialog_db_pass" for="db_pass"></label> <input type="password" id="db_pass" name="passwort" value="" size="30"></li>
		<li><label id="dialog_db_prefix" for="db_prefix"></label> <input type="text" id="db_prefix" name="prefix" value="uni1_" size="30"></li>
	</ul>
	<hr>
	</form>
	<form id="admin" action="webinstall.php" onsubmit="return false">
	<ul>
		<li><label id="dialog_adm_user" for="admin_user"></label> <input type="text" id="admin_user" name="adm_user" size="30"></li>
		<li><label id="dialog_adm_pass" for="admin_pass"></label> <input type="password" id="admin_pass" name="adm_pass" size="30"></li>
		<li><label id="dialog_adm_email" for="admin_email"></label> <input type="text" id="admin_email" name="adm_email" size="30"></li>
	</ul>
	</form>
	<button style="cursor:pointer;text-align:center;margin:10px 5px 5px auto;float:right" onclick="$('#dialog').dialog('close');" id="dialog_save"></button>
</div>
<div id="error" style="display:none;"></div>
</body>
</html>