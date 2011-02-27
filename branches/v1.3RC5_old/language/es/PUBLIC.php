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
$LNG['uni_closed']			= '(offline)';
	 
/* ------------------------------------------------------------------------------------------ */

$LNG['music_off']			= 'Music: OFF';
$LNG['music_on']			= 'Music: ON';


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
$LNG['login_error_1']			= 'Usuario/Contrase&ntilde;a Incorrecto!';
$LNG['login_error_2']			= 'Alguien se ha logueado desde otro ordenador con esta cuenta!';
$LNG['login_error_3']			= 'La sesi&oacute;n ha expirado!';
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
$LNG['server_description']		= '<strong>%s</strong> es un juego de estrategia en el espacio. Compite con jugadores las 24h para conquistar el universo. Todo lo que necesitas es un navegador estandard (Recomendamos Firefox).';
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
$LNG['user_field_no_alphanumeric']	= 'Por favor introduce en el nombre de usuario s&oacute;lo caracteres alfanum&eacute;ricos!<br>';
$LNG['user_field_no_space']		    = 'Por favor, no introduzca el nombre de usuario en blanco!<br>';
$LNG['planet_field_no_alphanumeric']= 'Por favor, introduce solo caracteres alphanumericos en el nombre del planeta!<br>';
$LNG['planet_field_no_space']		= 'Por favor, no deje el nombre del planeta vacio!<br>';
$LNG['terms_and_conditions']		= 'Acepta los <a onclick="ajax(\'?page=rules&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">Reglas</a> y los <a onclick="ajax(\'?page=agb&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">T&C</a> por favor!<br>';
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
$LNG['planet_already_exists']		= 'La posici&oacute;n del planeta ya esta ocupada! <br>';

//registry_form.tpl
$LNG['server_message_reg']			= 'Reg&iacute;strate ahora y forma parte de';
$LNG['register_at_reg']			    = 'Registrado en';
$LNG['uni_reg']					    = 'Universo';
$LNG['user_reg']					= 'Usuario';
$LNG['pass_reg']					= 'Contrase&ntilde;a';
$LNG['pass2_reg']					= 'Confirmar Contrase&ntilde;a';
$LNG['email_reg']					= 'Direccion E-mail';
$LNG['email2_reg']					= 'Confirmar Direccion E-mail';
$LNG['planet_reg']					= 'Nombre del planeta principal';
$LNG['lang_reg']					= 'Idioma';
$LNG['register_now']				= 'Registrate';
$LNG['captcha_reg']				    = 'Clave de Seguridad';
$LNG['accept_terms_and_conditions'] = 'Acepto las <a onclick="ajax(\'?page=rules&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">Reglas</a> y <a onclick="ajax(\'?page=agb&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">T&C</a>';
$LNG['captcha_reload']				= 'Recarga';
$LNG['captcha_help']				= 'Ayuda';
$LNG['captcha_get_image']			= 'Carga Bild-CAPTCHA';
$LNG['captcha_reload']				= 'Nuevo CAPTCHA';
$LNG['captcha_get_audio']			= 'Carga Sonido-CAPTCHA';
$LNG['user_active']                 = 'Usuario %s se ha activado!';

//registry_closed.tpl
$LNG['info']						= 'Informaci&oacute;n';
$LNG['reg_closed']					= 'Registro Cerrado';

//Rules
$LNG['rules_overview']				= "Reglas";
$LNG['rules']						= array(
	"Cuentas"					=> "Cada jugador es libre para controlar una sola cuenta. Cada cuenta tiene derecho a ser desempeñado por un solo jugador a la vez, la única excepción es la cuenta de sitting.
El Sitting permite a un jugador en cuestión tener su cuenta vigilada bajo las siguientes regulaciones:

- Un administrador debe ser informado antes de que el Sitting se realice mediante la apertura de un ticket.
- No se permiten movimientos de flota mientras la cuenta esta en sitting a menos que se de el caso de un ataque, en cuyo caso usted puede salvar su flota mediante el despliegue o transporte a un planeta o una luna de propiedad de la cuenta.
- Una cuenta puede ser cuidada durante un período máximo de 48 horas continuas (permiso de administración sera obtenido en los casos que sea necesaria una ampliación del plazo).
El Cuidador puede, en la cuenta que de Sitting y, mientras dura el período de sesión:

- Gastar recursos en edificios o investigaciones.
- Hacer Fleetsave de una flota en peligro inminente por una flota de ataque de entrada, sólo con la misión de despliegue o transporte a uno de los planetas propios de la cuenta.
- Colocar una cuenta en el modo de vacaciones.

El sitter no puede:

- Transportar recursos, ni entre los planetas / lunas de la cuenta que cuida, ni a cualquier otro planeta / luna.
- Gastar recursos en las estructuras de defensa o naves.
- Cuidar una cuenta si ya ha cuidado otra durante los últimos 7 días.
- Cuidar una cuenta que ya cuido en los últimos 7 días.
- Quitar una cuenta del modo de vacaciones.",


	"Pushing"					=> "No está permitido a ninguna cuenta obtener provecho injusto a cabo de una cuenta de menor puntuación en cuestión de recursos.
Esto incluye pero no esta limitado a:

- Recursos enviados desde una cuenta de menor puntuación a una de mayor puntuación sin obtener nada tangible a cambio.
- Un jugador destruya su flota en una de mayor puntuación para que la de mayor puntuación pueda mantener el campo de escombros, y así sacar provecho de ella.
- Los préstamos que no se devuelven en 48 horas.
- Operaciones en las que el jugador de mayor puntuación no devuelve los recursos dentro de las 48 horas.
- Jugadores de que responden a una extorsión de un jugador de mayor puntuación mediante el pago de los recursos.
- Intercambios que significan un beneficio injusto para el jugador de mayor puntuación por la salida fuera de la siguiente gama de relaciones:

03:02:01 Donde cada unidad de deuterio vale 2 unidades de cristal o 3 unidades de metal.

02:01:01 Donde cada unidad de deuterio es un valor de 1 unidad de cristal o 2 unidades de metal.
",

	"Bashing"					=> "No está permitido atacar a cualquier planeta o luna de propiedad de un jugador más de 6 veces en un solo período de 24 horas.

Bashing sólo está permitido cuando la Alianza está en guerra con otra Alianza. La guerra debe ser anunciado en el foro y los líderes deben estar de acuerdo con los términos.",

	
	"Bugusing"					=> "El uso de un bug con fines de lucro intencionado, o no reportar un bug intencionadamente est&aacute; estrictamente prohibido.",


	"Amenazas en la vida real"	=> "Est&aacute; prohibido insinuar que se va a localizar y causar da&ntilde;o a un jugador, a un miembro del equipo, a un empleado de Planet Moons o a cualquier persona.",

	"Spam"			=> "Cualquier intento de saturar la interfaz del jugador usando cualquier m&eacute;todo est&aacute; prohibido. Esto incluye pero no limita a:

- Mensajes personales de spam
- Pruebas de spam
- Spam en General",

  "Guerras"                    => "Después de que los líderes de las alianzas esten de acuerdo con la guerra, esta oficialmente empezada. Y continuar&aacute; hasta que una de las alianzas la cancele. Para cancelar oficialmente la guerra necesitan cancelar el pacto de guerra desde dentro del juego, y anunciarlo en el hilo que empez&oacute; inicialmente.
Mientras que la guerra este en marcha, las reglas de bashing no cuentan entre los ataques de estas alianzas. Significa que los miembros pertenecientes a las alianzas en dicha guerra se pueden atacar una cantidad infinita de veces con el castigo que eso conlleve.
Si bien una de las alianza se da por vencida y cancela la guerra, la norma entrará de Bashing en vigor de nuevo, y los miembros que rompan esta regla despues de que la guerra haya terminado seran castigados con un ban de un día. Se castigara m&aacute;s si el grado de ataque es muy alto.

Si alguna de las alianzas cuenta con una flota en vuelo. Y la guerra se cancela antes de que lleguen. Ellos no serán castigados por ese ataque. Pero cualquier flota enviada después de la cancelación de la guerra se cuenta para el Bashing.


Por una Nueva Guerra los líderes necesitan de crear un nuevo tema en el foro de guerra/diplomacia.
Se puede establecer una normativa espec&iacute;fica o t&eacute;rminos que los lideres quieran para una guerra. Cualquier norma establecida, y que se acuerde con la alianza contratia debe estar en acuerdo, y no deben contravenir las normas establecidas aquí.",

);

$LNG['rules_info1']				= "Sin embargo, se recoge en este <a href=\"%s\" target=\"_blank\"> Foro </ a> y sobre la página inicial del juego la informaci&oacute;n al respecto ...";
$LNG['rules_info2']				= "Para complementar esto, los <a onclick=\"ajax('?page=agb&getajax=1');\" style=\"cursor:pointer;\">T&C</a> tienen que ser respetados!</font>";


//AGB

$LNG['agb_overview']				= "Terminos y Condiciones";
$LNG['agb']						= array(
	"Servicio de contenidos"				=> array( 
		"El reconocimiento de las pol&iacute;ticas son un requisito previo necesario para poder participar en el juego.
Se aplican a todas las ofertas por parte de los operadores, incluido el Foro y otros contenidos del juego. ",

                "El servicio es gratuito.
Por lo tanto no existen reclamaciones a la disponibilidad, la entrega, la funcionalidad, o da&ntilde;os y perjuicios.
Ademas, el jugador no debe tener pretensiones de restaurar una cuenta tratada negativamente.",
	),

	"Afiliacion"				=> array(
		"Al iniciar la sesion en el juego y / o los miembros del Foro se iniciara en el juego.",

                "Lo que comienza con la declaracion de miembros podra ser rescindido por parte del miembro, borrando su cuenta o por escrito de un administrador.
La supresi&oacute;n de los datos por razones t&eacute;cnicas no se pueden hacer de inmediato.",

                "Terminado por el operador ningun usuario tiene derecho a participar en las operaciones del operador.
El operador se reserva el derecho de borrar cuentas.
La decision de eliminar una cuenta es unica y exclusivamente del operador y del administrador.
Cualquier reclamacion legal de una calidad de miembro esta excluida.",

                "Todos los derechos permanecen con el operador.",
        ),

	"Contenidos / Responsabilidad"	=> "Para el contenido de las diversas capacidades de comunicaciones de juego, los usuarios son responsables. Pornografia, racismo, abusos o cualquier otra cosa que infrinja la ley en contra de contenidos ajenos a la responsabilidad del operador.
Violaci&oacute;nes pueden derivar en la anulaci&oacute;n o revocaci&oacute;n inmediata.",

	"Prohibido procedimientos"			=> array(
		"El usuario no est&aacute; autorizado a usar el hardware / software u otras sustancias o mecanismos asociados con el sitio web, que pueden interferir con la funci&oacute;n y el juego.
El usuario no podr&aacute; seguir aceptando cualquier acci&oacute;n que pueda causar la tensi&oacute;n indebida o el aumento de la capacidad t&eacute;cnica.
El usuario no se le permite manipular el contenido generado por el operador o interferir en modo alguno con el juego",
		
		"Cualquier tipo de bot, script o funciones automatizadas est&aacute;n prohibidas.
El juego se puede jugar s&oacute;lo en el navegador. Incluso sus funciones no se debe utilizar para obtener una ventaja en el juego.
Por lo tanto, ning&uacute;n tipo de publicidad se bloquear&aacute;. La decisi&oacute;n de cuando un programa es beneficioso para los jugadores, es competencia exclusiva con el operador / con los administradores u operadores.",
		
	
	),

	"Restricciones de uso"		=> array(
		"Un jugador s&oacute;lo puede usar uno por cada cuenta de universo, los llamados \ multinacionales \ no est&aacute;n permitidas y ser&aacute;n borrados sin previo aviso puede ser o ser&aacute; bloqueado.
La decisi&oacute;n de cuando hay un \ varios \ corresponde exclusivamente a los operadores y administradores u operadores. ",
		
		"Datos se regir&aacute; por las reglas.",
		
		"Los bloqueos pueden permanente a discreci&oacute;n del operador o temporalmente.
Del mismo modo, los cierres pueden extenderse a una o todas las &aacute;reas de juego.
La decisi&oacute;n se suspende cuando y cu&aacute;nto tiempo un jugador que es s&oacute;lo con el operador / con los administradores u operadores.",
	),

	"Privacidad"					=> array(
		"El operador se reserva el derecho de almacenar datos de los jugadores con el fin de vigilar el cumplimiento de las normas, condiciones de uso y la legislaci&oacute;n aplicable.
Guardado todos los obligatorios y presentado por el jugador o su informaci&oacute;n de cuenta.
Estos (IPs se asocian con periodos de utilizaci&oacute;n y uso, la direcci&oacute;n de correo electr&oacute;nico dada durante el registro y otros datos.
En el foro, lo que se almacene en el perfil. ",
		
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
Expresamente se permite la libre transferencia, permanente de la cuenta y las acciones de sus recursos propios en el universo, a menos que ya excepci&oacute;n de lo permitido por las reglas ",
            ),

	"Responsabilidad"	=> "El titular de cada universo no se responsabiliza de los da&ntilde;os y perjuicios.
Un pasivo es negarse, salvo por los da&ntilde;os causados por dolo o negligencia grave y todos los da&ntilde;os a la vida y la salud.
En este sentido, se se&ntilde;al&oacute; expresamente que los videojuegos pueden representar un riesgo significativo para la salud.
Los da&ntilde;os no son en el sentido del operador. ",

	"Cambios en los T&eacute;rminos"	=> "El operador se reserva el derecho de modificar estos t&eacute;rminos en cualquier momento o extender.
Un cambio o adici&oacute;n se publicar&aacute;n al menos una semana antes de la entrada en el Foro.",
);

//Facebook Connect

$LNG['fb_perm']                = "Acceso prohibido. %s necesitas todos los derechos para que puedas ingresar con tu cuenta de Facebook. Tambien se puede acceder sin una cuenta de Facebook! ";

//NEWS

$LNG['news_overview']			= "Noticias";
$LNG['news_from']				= "Abierto %s por %s";
$LNG['news_does_not_exist']	    = "No hay noticias!";

//Impressum

$LNG['disclamer']				= "Denuncia";
$LNG['disclamer_name']			= "Nombre";
$LNG['disclamer_adress']		= "Direcci&oacute;n";
$LNG['disclamer_tel']			= "Tel&eacute;fono:";
$LNG['disclamer_email']		    = "Direcci&oacute;n E-mail";

// Traducido por ZideN // Modified by Morktadela

?>