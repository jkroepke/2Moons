<?php

//general
$LNG['index']				= 'Indice';
$LNG['register']			= 'Registro';
$LNG['forum']				= 'Foro';
$LNG['send']				= 'Aceptar';
$LNG['menu_index']			= 'Inicio';
$LNG['menu_news']			= 'Noticias';
$LNG['menu_rules']			= 'Reglas';
$LNG['menu_agb']			= 'T&C'; 
$LNG['menu_pranger']		= 'Baneados';
$LNG['menu_top100']		    = 'Salon de la Fama';
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
$LNG['server_description']		= '<strong>%s</strong> es un juego de estrategia localizado en el espacio. Miles de jugadores por todo el mundo compiten al mismo tiempo. Para jugar solo necesitas un navegador web.';
$LNG['server_register']		    = 'Registrate Ahora!';
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
$LNG['welcome_message_content']	    = 'Bienvenido a %s!<br>En primer lugar construye una Planta de energ&iacute;a solar, porque la energ&iacute;a es necesaria para la posterior producci&oacute;n de materias primas. Para construila, haga clic en Edificios del panel izquierdo. Hay que tener energ&iacute;a, puede comenzar a construir las minas. Vuelve al men&uacute; Edificio y construye una mina de metal, y luego otra vez una mina de cristal. El equipo le desea mucha diversi&oacute;n y comienza a explorar el universo!';
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
$LNG['register_now']				= 'Registrate!';
$LNG['captcha_reg']				    = 'Pregunta de Seguridad';
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
	"Cuentas"					=> "Cada jugador se le permite controlar una sola cuenta. Cada cuenta tiene derecho a ser desempe&ntilde;ado por un solo jugador a la vez, sentado en cuenta que la &uacute;nica excepci&oacute;n.
Cuenta sesi&oacute;n facultar&aacute; a un determinado jugador a tener en cuenta su vigilada bajo las siguientes regulaciones:

- Soy administrador debe ser informado antes de que &eacute;ste tenga lugar, mediante la apertura de un billete.
- No se permiten movimientos de flota mientras la cuenta es estar sentado a menos que un ataque que puede redada contra la cuenta es de entrada, en cuyo caso usted puede salvar su flota (s) por el despliegue o transporte a un planeta o una luna de propiedad de la teniendo en s&aacute;b No se puede estrellar un ataque de entrada en caso de que usted tendr&iacute;a que mover una flota para ello.
- Una cuenta puede ser cuidada durante un per&iacute;odo m&aacute;ximo de 48 horas continuas (permiso de administrador debe ser obtenido en los casos donde se necesita una ampliaci&oacute;n del plazo).
El Cuidador puede, en la cuenta de que est&aacute; cuidando y mientras dure el per&iacute;odo de sesi&oacute;n:

- Gastar recursos en edificios o investigaciones.
- Fleetsave de cualquier buque que inminentemente amenazada por un ataque de la flota de entrada, s&oacute;lo con un despliegue o transporte a una de las cuentas de propios planetas.
- Poner la cuenta en modo vacaciones.

El Cuidador no puede:

- Los recursos de transporte, ni entre los planetas / lunas de la cuenta que est&aacute; cuidando, ni a ning&uacute;n otro planeta / luna.
- Gastar recursos en las estructuras de defensa o barcos.
- Cuidar una cuenta si ya ha cuidado otra durante los &uacute;ltimos 7 d&iacute;as.
- Cuidar una cuenta que ha sido cuidada durante los &uacute;ltimos 7 d&iacute;as.
- Quitar una cuenta del modo de vacaciones.",


	"Molesto"					=> "No est&aacute; permitido a ninguna cuenta obtener provecho injusto de otra cuenta de menor puntuaci&oacute;n en cuesti&oacute;n de recursos.
Esto incluye pero no limitado a:

- Enviar recursos de una cuenta de menor puntuaci&oacute;n a una de mayor puntuaci&oacute;n sin obtener nada tangible a cambio.
- Un jugador destruya su flota contra una mayor puntuaci&oacute;n, una para el de mayor puntuaci&oacute;n, para mantener los escombros y, en consecuencia, obteniendo provecho.
- Los pr&eacute;stamos que no se devuelven en 48 horas.
- Operaciones en las que el jugador de mayor puntuaci&oacute;n no devuelve los recursos dentro de las 48 horas.
- Jugadores que una extorsi&oacute;n jugador de mayor puntuaci&oacute;n envi&aacute;ndole recursos.
- Comercios que producen un provecho injusto para el jugador de mayor puntuaci&oacute;n, al caer fuera de la siguiente gama de relaciones:

03:02:01 d&oacute;nde cada unidad de deuterio se valora en 2 unidades de cristal o 3 unidades de metal.

02:01:01 d&oacute;nde cada unidad de deuterio se valora en 1 unidad de cristal o 2 unidades de metal.
",

	"Paliza"					=> "No est&aacute; permitido atacar a cualquier planeta o luna de propiedad de un jugador m&aacute;s de 6 veces en un periodo de 24 horas.

Bashing s&oacute;lo est&aacute; permitido cuando la Alianza est&aacute; en guerra con otra alianza. La guerra debe ser anunciado en el foro y ambos l&iacute;deres deben estar de acuerdo con los t&eacute;rminos.",

	
	"Bugusing"					=> "El uso de un bug con fines de lucro anyones intencionadamente, o no reportar un bug intencionadamente est&aacute; estrictamente prohibido.",


	"Amenazas de la vida real"	=> "A entender que se va a localizar y da&ntilde;ar a otro jugador, est&aacute; prohibido.",

	"Spam"			=> "Asituaci&oacute;n ny intento de saturar la interfaz del jugador usando cualquier m&eacute;todo est&aacute; prohibido. Esto incluye pero no limitado a:

- La mensajer&iacute;a privada de spam
- Sondas de spam
- Informaci&oacute;n general spam",

  "Guerras"                    => "Despu&eacute;s de los l&iacute;deres de las alianzas est&aacute;n de acuerdo con la guerra, es oficialmente el. Y continuar&aacute; hasta que una de las alianzas se cancela. Para cancelar oficialmente la guerra tienen que cancelar el pacto de la guerra en el juego, y anuncian que en el hilo que empez&oacute; inicialmente.
Mientras que la guerra est&aacute; en la norma entre los ataques a las alianzas que se trate no tiene importancia. Significado los miembros pertenecientes a las alianzas en dicha guerra se puede atacar a una cantidad infinita de veces con pena corporal.
Si bien la alianza se da por vencido y cancela la guerra, el Estado entrar&aacute; en vigor golpear de nuevo, y cualquier miembro de que se rompa despu&eacute;s de la guerra ha terminado con ser castigado con una prohibici&oacute;n de d&iacute;a 1, m&aacute;s si el grado de ataque es muy alto.

Si la alianza oposici&oacute;n cuenta con una flota en vuelo. Y la guerra se cancela antes de que lleguen. No van a ser castigados por ese ataque. Pero cualquier flota enviada despu&eacute;s de la cancelaci&oacute;n de la guerra se cuentan para el Estado que golpea.


Para Nueva Wars uno de los l&iacute;deres tienen que crear un nuevo hilo en la guerra / la secci&oacute;n de la diplomacia.
All&iacute; se puede establecer una normativa espec&iacute;fica o conjunto de t&eacute;rminos que quieren para la guerra. Cualquier normas establecidas en el lugar, y que se acuerden por la alianza de oposici&oacute;n debe estar en barbecho, y no debe contradecir las normas establecidas aqu&iacute;.",

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

// Translated into English by Languar . All rights reversed (C) 2010

?>
