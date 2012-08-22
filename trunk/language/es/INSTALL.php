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
 * @package 2Moons
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <lucky@xgproyect.net> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.6.1 (2011-11-19)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */


$LNG['back']					= 'Atras';
$LNG['continue'] = 'Continuar';
$LNG['login']					= 'Login';

$LNG['menu_intro'] = 'Intro';
$LNG['menu_install'] = 'Instalar';
$LNG['menu_license'] = 'Licencia';

$LNG['title_install'] = 'Instalador';

$LNG['intro_lang'] = 'Idioma';
$LNG['intro_install'] = 'Instalación';
$LNG['intro_welcome'] = 'Bienvenido a 2Moons!';
$LNG['intro_text'] = '2Moons es uno de los mejores clones de OGame. <br> 2Moons es la última y más estable versión de un servidor basado en Xnova que ah sido desarrollada. Los puntos clave de 2Moons son su facilidad, estabilidad, flexibilidad, dinamismo y calidad. En 2Moons siempre esperamos a ser más que sus expectativas. <br> El sistema de instalación le guiará a través de la instalación o la actualización de una versión previa a la última. <br>  Si tiene preguntas o problemas, por favor, no dude en comunicarse en nuestro foro de desarrollo y soporte. <br> 2Moons es un proyecto de código abierto y está bajo licencia GNU GPL v3. Para conocer la licencia, por favor haga click en la opción del menú correspondiente. <br> Antes de comenzar la instalación se lleva a cabo una prueba para saber si el servidor cumple los requisitos mínimos.';

$LNG['licence_head']			= 'Lizenzbestimmungen';
$LNG['licence_desc']			= 'Bitte lesen Sie die folgenden Lizenzbestimmungen. Verwenden Sie die Bildlaufleiste, um das gesamte Dokument anzuzeigen.';
$LNG['licence_accept']			= 'Akzeptieren Sie sämtliche Bedingungen der Lizenzbestimmungen? Sie können die Software nur installieren, wenn Sie die Lizenzbestimmungen akzeptieren.';
$LNG['licence_need_accept']		= 'Um mit der Installation fortfahren zu können, müssen Sie die Lizenzbestimmungen akzeptieren.';

$LNG['req_head']				= 'Benötigte Systemvoraussetzungen';
$LNG['req_desc']				= 'Bevor die Installation fortgesetzt werden kann, wird 2Moons einige Tests zu deiner Server-Konfiguration und deinen Dateien durchführen, um sicherzustellen, dass du 2Moons installieren und benutzen kannst. Bitte lies die Ergebnisse aufmerksam durch und fahre nicht weiter fort, bevor alle erforderlichen Tests bestanden sind. Falls du irgendeine der Funktionen, die unter den optionalen Modulen aufgeführt sind, nutzen möchtest, solltest du sicherstellen, dass die entsprechenden Tests auch bestanden werden.';
$LNG['reg_yes'] = 'Sí';
$LNG['reg_no'] = 'No';
$LNG['reg_found'] = 'Encontrado';
$LNG['reg_not_found'] = 'No encontrado';
$LNG['reg_writable'] = 'Escritura';
$LNG['reg_not_writable'] = 'No escribible';
$LNG['reg_file'] = 'Archivo';
$LNG['reg_dir'] = 'Carpeta';
$LNG['reg_gd_need'] = '¿GB-Lib disponible?';
$LNG['reg_gd_desc']				= '<strong>Opcional</strong> — Librería de procesamiento de gráficos &raquo;gdlib&laquo; es responsable de la generación dinámica de imágenes. Sin ella, algunas funciones no funcionan el software.';
$LNG['reg_mysqli_active'] = '¿MySQLi disponible?';
$LNG['reg_mysqli_desc']			= '<strong>Requisito Previo</strong> — Usted necesita proporcionar apoyo a MySQLi en PHP. Si no hay módulos de bases de datos se muestran como disponibles, póngase en contacto con su proveedor de hosting o revisar la documentación pertinente de la instalación de PHP para el consejo.';
$LNG['reg_json_need'] = '¿JSON disponible?';
$LNG['reg_iniset_need'] = '¿ini_set() disponible?';
$LNG['reg_global_need'] = '¿register_globals desactivadas?';
$LNG['reg_global_desc']			= '2Moons también trabajará, si esta opción está habilitada. Sin embargo, se recomienda por razones de seguridad, deshabilitar register_globals en la instalación de PHP, si es posible.';
$LNG['req_php_need'] = 'Versión PHP (min. 5.2.5)';
$LNG['req_php_need_desc']		= '<strong>Requisitos Previos</strong> — PHP es el lenguaje del lado del servidor, 2Moons está escrito en el. 2Moons Esto funciona sin ninguna limitación, la versión PHP 5.2.5 previsto.';

$LNG['req_ftp_head']			= 'Introduzca las credenciales de FTP';
$LNG['req_ftp_desc']			= 'Ingrese su información de FTP para que 2Moons pueda corregir automáticamente los problemas. Alternativamente, también puede asignar manualmente permisos de escritura.';
$LNG['req_ftp_host'] = 'Host FTP';
$LNG['req_ftp_username'] = 'Usuario';
$LNG['req_ftp_password'] = 'Contraseña';
$LNG['req_ftp_dir'] = 'Directorio de 2Moons';
$LNG['req_ftp_send'] = 'Enviar';
$LNG['req_ftp_error_data']		= 'Con las credenciales proporcionadas no se pudo conectar a un servidor FTP.';
$LNG['req_ftp_error_dir']		= 'El directorio que has introducido no es válido.';

$LNG['step1_head']				= 'Configurar el acceso a la base de datos';
$LNG['step1_desc']				= 'Ahora que se ha determinado que 2Moons se puede utilizar en su servidor, debe proporcionar cierta información. Si usted no sabe cómo los datos están conectados a la base de datos, por favor póngase en contacto con su proveedor de hosting, como la primera o la espalda en los foros de soporte de 2Moons. Al introducir datos, por favor revise esto cuidadosamente antes de continuar.';
$LNG['step1_mysql_server'] = 'Servidor MySQL: <br>Estandart: localhost';
$LNG['step1_mysql_port'] = 'Puerto del Servidor MySQL: <br>Estandart: 3306';
$LNG['step1_mysql_dbname'] = 'Nombre BD MySQL: <br> Ej.: Game';
$LNG['step1_mysql_dbuser'] = 'Usuario MySQL: <br> Ej.: root';
$LNG['step1_mysql_dbpass'] = 'Contraseña MySQL: <br> Ej.: 12345';
$LNG['step1_mysql_prefix'] = 'Prefijo Tablas BD MySQL: <br> Ej.: uni1_';

$LNG['step2_db_no_dbname']		= 'No se especifica el nombre de la base de datos.';
$LNG['step2_db_too_long']		= 'El prefijo de la tabla especificada es demasiado larga. La longitud máxima es de 36 caracteres.';
$LNG['step2_db_con_fail'] = "No hay conexi&oacute;n con la base de datos.<br> %s";
$LNG['step2_config_exists']		= 'config.php ya existe!';
$LNG['step2_conf_op_fail'] = "¡config.php no esta en modo escritura (CHMOD 777)!";
$LNG['step2_conf_create'] = "config.php creado satisfactoriamente...";
$LNG['step2_prefix_invalid'] = 'El prefijo DB debe contener sólo caracteres alfanuméricos y guiones.';
$LNG['step2_db_done']			= 'La conexión a la base de datos tuvo éxito!';

$LNG['step3_head']				= 'Crear tablas de base de datos';
$LNG['step3_desc']				= 'La base de datos utilizado por las tablas 2Moons se han creado y rellenado con unos valores iniciales. Ir al siguiente paso para completar la instalación de 2Moons.';
$LNG['step3_db_error']			= 'No se ha podido crear las tablas de base de datos:';

$LNG['step4_head']				= 'Puede crear la cuenta administrador';
$LNG['step4_desc']				= 'El asistente de instalación ahora va a crear una cuenta de administrador para usted. Por favor, introduzca un nombre de usuario, una dirección de correo electrónico y contraseña.';
$LNG['step4_admin_name']		= 'Nombre de usuario del administrador:';
$LNG['step4_admin_name_desc']	= 'Por favor, introduzca un nombre de usuario con una longitud de 3 a 20 caracteres.';
$LNG['step4_admin_pass']		= 'Administrador-Contraseña:';
$LNG['step4_admin_pass_desc']	= 'Por favor, introduzca una contraseña con una longitud de 6 a 30 caracteres.';
$LNG['step4_admin_mail']		= 'Dirección de E-Mail para contacto:';

$LNG['step6_head']				= '¡Felicidades!';
$LNG['step6_desc']				= 'Usted ha instalado exitosamente 2Moons.';
$LNG['step6_info_head']			= 'Comience con 2Moons!';
$LNG['step6_info_additional']	= 'Si hace clic en el botón de abajo, usted será redirigido a un formulario en el área de administración. Entonces usted debería tratar de sacar algo de tiempo para conocer las opciones disponibles.<br/><br/><strong>Por favor, borre el archivo &raquo;includes/ENABLE_INSTALL_TOOL&laquo; o renombrelo antes de utilizar su juego. Mientras existe este archivo, el juego estará en riesgo potencial!</strong>';

$LNG['sql_close_reason'] = 'El juego está actualmente cerrado';
$LNG['sql_welcome'] = 'Bienvenido a ';

// Translated into Spanish by Scofield06 . All rights reversed (C) 2011
?>