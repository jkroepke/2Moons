<?php

//general
$LNG['index']				= '&Iacute;ndice';
$LNG['register']			= 'Registro';
$LNG['forum']				= 'Foro';
$LNG['send']				= 'Aceptar';
$LNG['menu_index']			= 'Inicio';
$LNG['menu_news']			= 'Noticias';
$LNG['menu_rules']			= 'Reglas';
$LNG['menu_agb']			= 'T&C'; 
$LNG['menu_pranger']		= 'Baneados';
$LNG['menu_top100']		    = 'Sal&oacute;n de la Fama';
$LNG['menu_disclamer']		= 'Contacto';
	 
/* ------------------------------------------------------------------------------------------ */

//index.php
//case lostpassword
$LNG['mail_not_exist'] 		    = 'La direcci&oacute;n de correo electr&oacute;nico no existe!';
$LNG['mail_title']				= 'Nueva contrase&ntilde;a';
$LNG['mail_text']				= 'Su nueva contrase&ntilde;a es: ';
$LNG['mail_sended']			    = 'Su contrase&ntilde;a ha sido enviada con exito!';
$LNG['mail_sended_fail']		= 'E-mail No se pudo enviar.!';
$LNG['server_infos']			= array(
	"Un juego de estrategia espacial en tiempo real.",
	"Juega junto con cientos de jugadores.",
	"Nada de descarga, s&oacute;lo se requiere un navegador est&aacute;ndar.",
	"Registro Gratuito",
);

//case default
$LNG['login_error']			= 'Usuario/Contrase&ntilde;a Incorrecto! <br><a href="index.php">Atras</a>';
$LNG['screenshots']			= 'Imagenes';
$LNG['universe']				= 'Universo';
$LNG['chose_a_uni']			= 'Elige Universo';

/* ------------------------------------------------------------------------------------------ */

//lostpassword.tpl
$LNG['lost_pass_title']		    = 'Recuperar Contrase&ntilde;a';
$LNG['retrieve_pass']			= 'Restaurar';
$LNG['email']					= 'Direcci&oacute;n de E-mail';

//index_body.tpl
$LNG['user']					= 'Usuario';
$LNG['pass']					= 'Contrase&ntilde;a';
$LNG['remember_pass']			= 'Auto-Login';
$LNG['lostpassword']			= 'Recordar Contrase&ntilde;a';
$LNG['welcome_to']				= 'Bienvenido a';
$LNG['server_description']		= '<strong>%s</strong> es un juego de estrategia en el espacio. Compite con jugadores las 24h para conquistar el universo.';
$LNG['server_register']		    = 'Registrate Ahora';
$LNG['server_message']			= 'Reg&iacute;strese ahora y experimente una nueva y emocionante aventura en el mundo de';
$LNG['login']					= 'Login';
$LNG['disclamer']				= 'Contacto';
$LNG['login_info']				= 'Acepto las <a onclick="ajax(\'?page=rules&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">Reglas</a> y los <a onclick="ajax(\'?page=agb&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">T&C</a>';

/* ------------------------------------------------------------------------------------------ */

//reg.php - Registrierung
$LNG['register_closed']			    = 'Registro Cerrado!';
$LNG['register_at']				    = 'Registrado en ';
$LNG['reg_mail_message_pass']		= 'Un paso m&aacute;s para activar su nombre de usuario';
$LNG['reg_mail_reg_done']			= 'Bienvenido a %s!';
$LNG['invalid_mail_adress']		    = 'E-Mail Incorrecto!<br>';
$LNG['empty_user_field']			= 'Por favor, rellene todos los campos!<br>';
$LNG['password_lenght_error']		= 'La contrase&ntilde;a debe tener al menos 4 caracteres!<br>';
$LNG['user_field_no_alphanumeric']	= 'Por favor introduce el nombre de usuario s&oacute;lo caracteres alfanum&eacute;ricos!<br>';
$LNG['user_field_no_space']		    = 'Por favor, no introduzca el nombre de usuario en blanco!<br>';
$LNG['terms_and_conditions']		= 'Acepta los <a href="index.php?page=agb">T&C</a> y <a href="index.php?page=rules>Reglas</a> porfavor!<br>';
$LNG['user_already_exists']		    = 'El nombre de usuario ya est&aacute; siendo usado!<br>';
$LNG['mail_already_exists']		    = 'La direcci&oacute;n de correo electr&oacute;nico ya est&aacute; en uso!<br>';
$LNG['wrong_captcha']				= 'Codigo de Seguridad incorrecto!<br>';
$LNG['different_passwords']		    = 'Ha introducido dos contrase&ntilde;as diferentes!<br>';
$LNG['different_mails']			    = 'Ha introducido dos E-Mail diferentes!<br>';
$LNG['welcome_message_from']		= 'Administrador';
$LNG['welcome_message_sender']		= 'Administrador';
$LNG['welcome_message_subject']	    = 'Bienvenido';
$LNG['welcome_message_content']	    = 'Bienvenido a %s!<br>En primer lugar construye una Planta de energ&iacute;a solar, porque la energ&iacute;a es necesaria para la posterior producci&oacute;n de materias primas. Para construila, haga clic en Edificios del panel izquierdo. Cuando tengas la energ&iacute;a, puedes comenzar a construir las minas. Vuelve al men&uacute; Edificio y construye una mina de metal, y luego otra vez una mina de cristal. El equipo le desea mucha diversi&oacute;n y comienza a explorar el universo!';
$LNG['newpass_smtp_email_error']	= '<br><br>Se produjo un error. Su contrase&ntilde;a es: ';
$LNG['reg_completed']				= 'Gracias por tu registro! Usted recibir&aacute; un correo electr&oacute;nico con un enlace de activaci&oacute;n.';

//registry_form.tpl
$LNG['server_message_reg']			= 'Reg&iacute;strate ahora y forma parte de';
$LNG['register_at_reg']			    = 'Registrado en';
$LNG['uni_reg']					    = 'Universo';
$LNG['user_reg']					= 'Usuario';
$LNG['pass_reg']					= 'Contrase&ntilde;a';
$LNG['pass2_reg']					= 'Confirmar Contrase&ntilde;a';
$LNG['email_reg']					= 'Direccion E-mail';
$LNG['email2_reg']					= 'Confirmar Direccion E-mail';
$LNG['register_now']				= 'Registrate';
$LNG['lang_reg']					= 'Idioma';
$LNG['captcha_reg']				    = 'Clave de Seguridad';
$LNG['accept_terms_and_conditions'] = 'Acepto las <a onclick="ajax(\'?page=rules&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">Reglas</a> y <a onclick="ajax(\'?page=agb&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">T&C</a>';
$LNG['captcha_reload']				= 'Recarga';
$LNG['captcha_help']				= 'Ayuda';
$LNG['captcha_get_image']			= 'Carga Bild-CAPTCHA';
$LNG['captcha_reload']				= 'Nuevo CAPTCHA';
$LNG['captcha_get_audio']			= 'Carga Sonido-CAPTCHA';
$LNG['user_active']                 = 'Usuario %s se ha activado!';

//registry_closed.tpl
$LNG['info']						= 'Informacion';
$LNG['reg_closed']					= 'Registro Cerrado';

//Rules
$LNG['rules_overview']				= "Reglas";
$LNG['rules']						= array(
	"Cuentas"					=> "El due&ntilde;o de una cuenta ser&aacute; siempre el due&ntilde;o de la direcci&oacute;n de e-mail permanente que figure en la cuenta de juego.
La cuenta de juego debe ser usada y gestionada exclusivamente por su due&ntilde;o. La &uacute;nica excepci&oacute;n permitida es el Cuidado de cuenta (Account Sitting).

El cambio de una cuenta dentro de un universo debe ser efectuado con la asistencia y bajo la supervisi&oacute;n del GO. Puedes contactar con el GO desde la p&aacute;gina http://support.ogame.com.es
Cuando una cuenta ha cambiado de due&ntilde;o, deben pasar por lo menos 30 d&iacute;as antes que &eacute;sta pueda cambiar de due&ntilde;o otra vez. Despu&eacute;s de que el nuevo due&ntilde;o haya tomado posesi&oacute;n de la cuenta, debe cambiar la direcci&oacute;n de e-mail durante las primeras 12 horas.
A cada jugador se le permite jugar con una sola cuenta por universo.
En caso de que dos o m&aacute;s cuentas est&eacute;n siendo jugadas, ya sea ocasional, habitual o permanentemente, desde la misma conexi&oacute;n de Internet (por ejemplo: desde el colegio, universidad o Internet caf&eacute;), se aconseja comunicarlo preventivamente al GO del universo. 
En este caso, las cuentas citadas no podr&aacute;n tener ning&uacute;n contacto de flota mientras utilicen la misma conexi&oacute;n. No se permiten tampoco similitudes entre las cuentas.
El Sitting permite confiarle a otro jugador el cuidado de una cuenta.
En este caso, antes de que el Sitting se produzca, es obligatorio informar previamente al GO del universo a trav&eacute;s del Sistema de Tickets.
Una cuenta puede ser cuidada durante un per&iacute;odo m&aacute;ximo de 12 horas.
El per&iacute;odo de Sitting se considera finalizado una vez el titular de la cuenta entre en ella.
No est&aacute; permitido ning&uacute;n tipo de movimiento de las flotas mientras la cuenta est&eacute; siendo cuidada. En caso de un ataque, se permite &uacute;nicamente el despliegue o el transporte de la flota (o de las flotas) a uno de los planetas o luna de la cuenta cuidada.
El cuidador puede utilizar recursos para la construcci&oacute;n de edificios o investigaciones, pero no puede utilizarlos de ninguna manera para la construcci&oacute;n de instalaciones de defensas o naves.
S&oacute;lo est&aacute; permitido cuidar de una cuenta que no haya sido cuidada en los &uacute;ltimos 7 d&iacute;as.",


	"Pushing"					=> "Est&aacute; estrictamente prohibido obtener provecho injusto de otra cuenta de menor puntuaci&oacute;n en forma de recursos.
Se entiende por Pushing, entre otras cosas, la transferencia de recursos de un jugador con una puntuaci&oacute;n baja a un jugador de mayor puntuaci&oacute;n, sin obtener alguna contraprestaci&oacute;n a cambio, o tambi&eacute;n la destrucci&oacute;n intencional de una flota contra un jugador de mayor puntuaci&oacute;n para as&iacute; sacar provecho de los escombros.
Los comercios deben ser concluidos en un plazo de 48 horas.
Para excepciones (como el reparto de un ataque conjunto, recompensas, ayuda para el reciclaje, etc.) se ha de pedir permiso al GO a trav&eacute;s del sistema de tickets
Para evitar un provecho injusto para el jugador de mayor puntuaci&oacute;n, se debe seguir unos patrones:

03:02:01 d&oacute;nde cada unidad de deuterio se valora en 2 unidades de cristal o 3 unidades de metal.

02:01:01 d&oacute;nde cada unidad de deuterio se valora en 1 unidad de cristal o 2 unidades de metal.
",

	"Bashing"					=> "No est&aacute; permitido atacar a un planeta o luna de un jugador m&aacute;s de 6 veces durante un per&iacute;odo de 24 horas. Esta regla se aplica tambi&eacute;n a las misiones para destruir la luna.
En los universos especiales y en el foro, la regla relacionada con el Bashing puede ser cambiada o derogada.
El Bashing de un jugador est&aacute; permitido solamente cuando la propia alianza est&aacute; en guerra con otra alianza. La guerra deber&aacute; ser declarada en la secci&oacute;n correspondiente del foro, y deber&aacute; cumplir las normas establecidas por el foro.
",

	
	"Bugusing"					=> "El uso de un bug con fines de lucro anyones intencionadamente, o no reportar un bug intencionadamente est&aacute; estrictamente prohibido.",


	"Amenazas en la vida real"	=> "Est&aacute; prohibido insinuar que se va a localizar y causar da&ntilde;o a un jugador, a un miembro del equipo, a un empleado de StarGame o a cualquier persona.",

	"Spam"			=> "Cualquier tipo de insulto y de spam est&aacute; prohibido.",

  "Infracciones a las reglas antes citadas"                    => "Conforme a su gravedad, las infracciones a las reglas antes citadas ser&aacute;n sancionadas con amonestaciones o con la completa expulsi&oacute;n del juego.
Los GO's responsables determinan el tipo y la duraci&oacute;n de la sanci&oacute;n y son las personas de contacto en caso de bloqueos de cuenta.",

);

$LNG['rules_info1']				= "";
$LNG['rules_info2']				= "Para complementar esto, los <a onclick=\"ajax('?page=agb&getajax=1');\" style=\"cursor:pointer;\">T&C</a> tienen que ser respetados!</font>";


//AGB

$LNG['agb_overview']				= "Terminos y Condiciones";
$LNG['agb']						= array(
	"Servicio de contenidos"				=> array( 
		"El reconocimiento de las pol&iacute;ticas son un requisito previo necesario para poder participar en el juego.
Se aplican a todas las ofertas por parte de los operadores, incluido el Foro y otros contenidos del juego. ",

"El servicio es gratuito. Por lo tanto no existen reclamaciones a la disponibilidad, la entrega, la funcionalidad, o da&ntilde;os y perjuicios. Ademas, el jugador no tiene pretensiones de restaurar, cuenta deberia haber sido tratada negativamente.",
	),

	"Afiliacion"				=> array(
		"Al iniciar la sesion en el juego y / o los miembros del Foro se iniciara en el juego."

- "Lo que comienza con la declaracion de miembros podra ser rescindido por parte del miembro, borrando su cuenta o por escrito de un administrador.
La supresi&oacute;n de los datos por razones t&eacute;cnicas no se pueden hacer de inmediato.",

"Terminado el operador ningun usuario tiene derecho a participar en las subastas del operador. El operador se reserva el derecho de borrar cuentas. La decision de eliminar una cuenta unica y exclusivamente en el operador y el administrador y operador. Cualquier reclamacion legal de una calidad de miembro esta excluida.",
  "Todos los derechos permanecen con el operador.",


	"Contenidos / Responsabilidad"	=> "Para el contenido de las diversas capacidades de comunicaciones de juego, los usuarios son responsables. Pornogr&aacute;fico, racista, ofensivo, o que infrinja la ley en contra de contenidos ajenos a la responsabilidad del operador.
Violaci&oacute;nes pueden derivar en la anulaci&oacute;n o revocaci&oacute;n inmediata."),


	"Prohibido procedimientos"			=> array(
		"El usuario no est&aacute; autorizado a usar el hardware / software u otras sustancias o mecanismos asociados con el sitio web, que pueden interferir con la funci&oacute;n y el juego.
El usuario no podr&aacute; seguir aceptando cualquier acci&oacute;n que pueda causar la tensi&oacute;n indebida o el aumento de la capacidad t&eacute;cnica.
El usuario no se le permite manipular el contenido generado por el operador o interferir en modo alguno con el juego",
		
		"Cualquier tipo de bot, script o funciones automatizadas est&aacute;n prohibidas.
El juego se puede jugar s&oacute;lo en el navegador. Incluso sus funciones no se debe utilizar para obtener una ventaja en el juego.
Por lo tanto, ning&uacute;n tipo de publicidad se bloquear&aacute;n. La decisi&oacute;n de cuando un programa es beneficioso para los jugadores, es competencia exclusiva con el operador / con los administradores u operadores.",
		
	
	),

	"Restricciones de uso"		=> array(
		"Un jugador s&oacute;lo puede usar uno por cada cuenta de universo, los llamados \ multinacionales \ no est&aacute;n permitidas y ser&aacute;n borrados sin previo aviso puede ser o ser&aacute; bloqueado.
La decisi&oacute;n de cuando hay un \ varios \ corresponde exclusivamente a los operadores y administradores u operadores. ",
		
		"Datos se regir&aacute; por las reglas.",
		
		"Los bloqueos pueden permanente a discreci&oacute;n del operador o temporal.
Del mismo modo, los cierres pueden extenderse a una o todas las &aacute;reas de juego.
La decisi&oacute;n se suspende cuando y cu&aacute;nto tiempo un jugador que es s&oacute;lo con el operador / con los administradores u operadores.",
	),

	"Intimidad"					=> array(
		"El operador se reserva el derecho de almacenar datos de los jugadores con el fin de vigilar el cumplimiento de las normas, condiciones de uso y la legislaci&oacute;n aplicable.
Guardado todos los obligatorios y presentado por el jugador o su informaci&oacute;n de cuenta.
Estos (IPs se asocian con periodos de utilizaci&oacute;n y uso, la direcci&oacute;n de correo electr&oacute;nico dada durante el registro y otros datos.
En el foro, realizado all&iacute; en el perfil se almacena. ",
		
		"Estos datos se dar&aacute; a conocer en determinadas circunstancias para llevar a cabo las obligaciones legales de los empleados y otras personas autorizadas.
Por otra parte, los datos pueden (si es necesario emitidos) en determinadas circunstancias a terceros. ",
		
		"El usuario puede objetar el almacenamiento de datos personales en cualquier momento. Una apelaci&oacute;n es un derecho de rescisi&oacute;n.",
	),

	"Derechos del titular de las cuentas"	=> array(
		"Todas las cuentas y todos los objetos virtuales siguen siendo en la posesi&oacute;n y propiedad de la operadora.
El jugador no obtiene la propiedad y otros derechos a cualquier cuenta o partes.
Todos los derechos permanecen con el operador.
Una transferencia de la explotaci&oacute;n u otros derechos para el usuario se llevar&aacute; a cabo en cualquier momento. ",
		
		"La venta no autorizada, usar, copiar, distribuir, reproducir o violar los derechos (por ejemplo, a cuenta) de que el operador ser&aacute; reportado a las autoridades y perseguidos.
Expresamente se permite la libre transferencia, permanente de la cuenta y las acciones de sus recursos propios en el universo, a menos que ya excepci&oacute;n de lo permitido por las reglas ",),

	"Responsabilidad"	=> "El titular de cada universo no se responsabiliza de los da&ntilde;os y perjuicios.
Un pasivo es negarse, salvo por los da&ntilde;os causados por dolo o negligencia grave y todos los da&ntilde;os a la vida y la salud.
En este sentido, se se&ntilde;al&oacute; expresamente que los videojuegos pueden representar un riesgo significativo para la salud.
Los da&ntilde;os no son en el sentido del operador. ",

	"Cambios en los T&eacute;rminos"	=> "El operador se reserva el derecho de modificar estos t&eacute;rminos en cualquier momento o extender.
Un cambio o adici&oacute;n se publicar&aacute;n al menos una semana antes de la entrada en el Foro.",);

//Facebook Connect

$LNG['fb_perm']                = "Acceso prohibido. %s necesitas todos los derechos para que puedas ingresar con tu cuenta de Facebook. Tambien se puede acceder sin una cuenta de Facebook! ";
//NEWS

$LNG['news_overview']			= "Noticias";
$LNG['news_from']				= "Abierto %s por %s";
$LNG['news_does_not_exist']	    = "Nuevas Noticias!";

//Impressum

$LNG['disclamer']				= "Denuncia";
$LNG['disclamer_name']			= "Nombre";
$LNG['disclamer_adress']		= "Direccion";
$LNG['disclamer_tel']			= "Telefono:";
$LNG['disclamer_email']		    = "Direccion E-mail";

// Traducido por ZideN

?>
