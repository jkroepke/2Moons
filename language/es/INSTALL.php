<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @licence MIT
 * @version 1.7.2 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */


$LNG['back']					= 'Atras';
$LNG['continue'] = 'Continuar';
$LNG['continueUpgrade']			= 'Actualización!';
$LNG['login']					= 'Login';

$LNG['menu_intro'] = 'Intro';
$LNG['menu_install'] = 'Instalar';
$LNG['menu_license'] = 'Licencia';
$LNG['menu_upgrade']			= 'Actualizar';

$LNG['title_install'] = 'Instalador';

$LNG['intro_lang'] = 'Idioma';
$LNG['intro_install'] = 'Instalación';
$LNG['intro_welcome'] = 'Bienvenido a 2Moons!';
$LNG['intro_text'] = '2Moons es uno de los mejores clones de OGame. <br> 2Moons es la última y más estable versión de un servidor basado en Xnova que ah sido desarrollada. Los puntos clave de 2Moons son su facilidad, estabilidad, flexibilidad, dinamismo y calidad. En 2Moons siempre esperamos a ser más que sus expectativas. <br> El sistema de instalación le guiará a través de la instalación o la actualización de una versión previa a la última. <br>  Si tiene preguntas o problemas, por favor, no dude en comunicarse en nuestro foro de desarrollo y soporte. <br> 2Moons es un proyecto de código abierto y está bajo licencia GNU GPL v3. Para conocer la licencia, por favor haga click en la opción del menú correspondiente. <br> Antes de comenzar la instalación se lleva a cabo una prueba para saber si el servidor cumple los requisitos mínimos.';
$LNG['intro_upgrade_head']		= '2Moons ya instalado?';
$LNG['intro_upgrade_text']		= '<p>2Moons ya está instalado y sólo desea actualizarlo?</p>Aquí usted puede actualizar su base de datos antigua con unos pocos clics</p>';

$LNG['upgrade_success']			= 'Actualización de la base de datos correcta. Base de datos Corresponde ahora al estado de la revisión %s.';
$LNG['upgrade_nothingtodo']		= 'No se requiere acción. Base de datos ya está en actualizada hasta la fecha de la revisión %s.';
$LNG['upgrade_back']			= 'Atrás';
$LNG['upgrade_intro_welcome']	= 'Bienvenido al actualizador de la base de datos!';
$LNG['upgrade_available']		= 'Hay actualizaciones disponibles para su base de datos! La base de datos está actualizada a la revisión %s y hay una actualización de la revisión %s para actualizar.<br><br>Por favor, seleccione en el menú siguiente, el primero en instalar la actualización de SQL:';
$LNG['upgrade_notavailable']	= 'La actualización utiliza la revisión %s es el más reciente de la base de datos.';
$LNG['upgrade_required_rev']	= 'La actualización sólo se puede utilizar desde la r2579 (2Moons v1.7) o superior.';

$LNG['licence_head']			= 'Aviso Legal';
$LNG['licence_desc']			= 'Por favor, lea el siguiente acuerdo de licencia. Utilice la barra de desplazamiento para ver el documento completo.';
$LNG['licence_accept']			= '¿Acepta todas las condiciones del contrato de licencia? Puede instalar el software sólo si acepta los términos de la licencia.';
$LNG['licence_need_accept']		= 'Para continuar con la instalación, debe aceptar los términos de la licencia.';

$LNG['req_head']				= 'Systema Requerido';
$LNG['req_desc']				= 'Antes de que la instalación pueda continuar, 2Moons realizará algunas pruebas en la configuración de su servidor y los archivos para asegurarse de que se puede instalar y utilizar 2Moons. Por favor, lea cuidadosamente los resultados y no van más allá de todas las pruebas necesarias hasta que haya sido aprobada. Si desea utilizar cualquiera de las funciones que se enumeran en los módulos opcionales, debe asegurarse de que las pruebas adecuadas también se pasan.';
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