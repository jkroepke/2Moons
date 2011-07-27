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
$LNG['menu_top100']		    = 'Salón de la Fama';
$LNG['menu_disclamer']		= 'Contacto';
$LNG['uni_closed']			= '(offline)';

//index.php
//case lostpassword

$LNG['lost_empty']			= '¡Debes rellenar todos los campos!';
$LNG['lost_not_exists']		= '¡No pudo encontrarse ningún usuario que posea este correo electrónico!';
$LNG['lost_mail_title']		= 'Nueva contraseña';
$LNG['mail_sended']			= '¡Su nueva contraseña ha sido enviada con éxito!';

//case default

$LNG['server_infos']			= array(
	"Un juego de estrategia espacial en tiempo real.",
	"Juega junto con cientos de jugadores.",
	"Nada de descarga, s&oacute;lo se requiere un navegador est&aacute;ndar.",
	"Registro Gratuito",
);

$LNG['login_error_1']			= 'Usuario/Contrase&ntilde;a Incorrecto!';
$LNG['login_error_2']			= 'Alguien se ha conectado desde otro ordenador con esta cuenta!';
$LNG['login_error_3']			= 'La sesi&oacute;n ha expirado!';
$LNG['screenshots']				= 'Imagenes';
$LNG['universe']				= 'Universo';
$LNG['chose_a_uni']				= 'Elige Universo';

/* ------------------------------------------------------------------------------------------ */

//lostpassword.tpl
$LNG['lost_pass_title']			= 'Recuperar Contraseña';

//index_body.tpl
$LNG['user']					= 'Usuario';
$LNG['pass']					= 'Contrase&ntilde;a';
$LNG['remember_pass']			= 'Auto-Login';
$LNG['lostpassword']			= 'Recordar Contrase&ntilde;a';
$LNG['welcome_to']				= 'Bienvenido a';
$LNG['server_description']		= '<strong>%s</strong> es un <strong>Juego de Simulación de Estrategia en el Espacio</strong> compite con cientos de jugadores conectados a lo largo del planeta <strong>simultaneamente</strong> para ser el/la mejor de todos. Todo lo que necesitas para jugar es un navegador Web Estandart.';
$LNG['server_register']		    = 'Registrate Ahora';
$LNG['server_message']			= 'Reg&iacute;strese ahora y experimente una nueva y emocionante aventura en el mundo de';
$LNG['login']					= 'Conexión';
$LNG['disclamer']				= 'Contacto';
$LNG['login_info']				= 'Al conectarme, estoy de acuerdo con las siguientes <a href="index.php?page=rules">Reglas</a> y los <a href="index.php?page=agb">T & C</a>';

/* ------------------------------------------------------------------------------------------ */

//reg.php - Registrierung
$LNG['register_closed']			    = 'Registro Cerrado!';
$LNG['register_at']				    = 'Registrado en ';
$LNG['reg_mail_message_pass']		= 'Un paso m&aacute;s para activar su nombre de usuario';
$LNG['reg_mail_reg_done']			= 'Bienvenido a %s!';
$LNG['invalid_mail_adress']		    = 'Correo Electrónico Incorrecto!<br>';
$LNG['empty_user_field']			= 'Por favor, rellene todos los campos!<br>';
$LNG['password_lenght_error']		= 'La contrase&ntilde;a debe tener al menos 6 caracteres!<br>';
$LNG['user_field_no_alphanumeric']	= 'Por favor introduce en el nombre de usuario s&oacute;lo caracteres alfanum&eacute;ricos!<br>';
$LNG['user_field_no_space']		    = 'Por favor, no introduzca el nombre de usuario con espacios!<br>';
$LNG['planet_field_no']				= 'Debe introducir un Nombre al Planeta!';
$LNG['planet_field_no_alphanumeric']= '¡El nombre de planetas solo puede contener caracéres Alfanuméricos!';
$LNG['planet_field_no_space']		= '¡Por Favor introduzca un Nombre de Planeta sin Espacios!';
$LNG['terms_and_conditions']		= '¡Usted debe aceptar los <a href="index.php?page=agb">T & C</a> y  el <a href="index.php?page=rules">Reglamento</a>!';
$LNG['user_already_exists']		    = 'El nombre de usuario ya está siendo usado.<br>';
$LNG['mail_already_exists']		    = 'La dirección de correo electrónico ya está en uso.<br>';
$LNG['wrong_captcha']				= 'Código de Seguridad incorrecto.<br>';
$LNG['different_passwords']		    = 'Ha introducido dos contraseñas diferentes.<br>';
$LNG['different_mails']			    = 'Ha introducido dos direcciónes de correo electrónico diferentes.<br>';
$LNG['welcome_message_from']		= 'Administración';
$LNG['welcome_message_sender']		= 'Administración';
$LNG['welcome_message_subject']	    = 'Bienvenido';
$LNG['welcome_message_content']		= 'Bienvenido a %s!<br>En primer lugar construye una Planta de energ&iacute;a solar, porque la energ&iacute;a es necesaria para la posterior producci&oacute;n de materias primas. Para construirla, haga clic en Edificios en el menú del panel izquierdo. Cuando tengas la energ&iacute;a, puedes comenzar a construir las minas. Vuelve al men&uacute; Edificio y construye una mina de metal, y luego otra vez una mina de cristal. Para construír Naves, deberá construír un Hangar. Para conocer los requerimientos de cualquier construcción, puede observarlos en la zona de Tecnología, la cual se accede desde el Menú izquierdo. El equipo le desea mucha diversi&oacute;n y comienza a explorar el universo!';
$LNG['newpass_smtp_email_error']	= 'Ha ocurrido un error en el envio del correo electrónico. Su Contraseña es: ';
$LNG['reg_completed']				= 'Gracias por registrarte, recibirás un correo electrónico con el enlace de activación de la cuenta.';
$LNG['planet_already_exists']		= '¡La posición del planeta ya está ocupada!';

//registry_form.tpl
$LNG['server_message_reg']			= 'Reg&iacute;strate ahora y forma parte de';
$LNG['register_at_reg']			    = 'Registrado en';
$LNG['uni_reg']					    = 'Universo';
$LNG['user_reg']					= 'Usuario';
$LNG['pass_reg']					= 'Contrase&ntilde;a';
$LNG['pass2_reg']					= 'Confirmar Contrase&ntilde;a';
$LNG['email_reg']					= 'Direccion de Correo electrónico';
$LNG['email2_reg']					= 'Confirmar Direccion Correo electrónico';
$LNG['planet_reg']					= 'Nombre del planeta principal';
$LNG['ref_reg']						= 'Referido por';
$LNG['lang_reg']					= 'Idioma';
$LNG['register_now']				= 'Registrate';
$LNG['captcha_reg']				    = 'Clave de Seguridad';
$LNG['accept_terms_and_conditions']	= 'Acepto las <a href="index.php?page=rules">Reglas</a> y los <a href="index.php?page=agb">T & C</a>.';
$LNG['captcha_reload']				= 'Recarga';
$LNG['captcha_help']				= 'Ayuda';
$LNG['captcha_get_image']			= 'Carga Bild-CAPTCHA';
$LNG['captcha_reload']				= 'Nuevo CAPTCHA';
$LNG['captcha_get_audio']			= 'Carga Sonido-CAPTCHA';
$LNG['user_active']                 = 'Usuario %s se ha activado!';

//Rules
$LNG['rules_overview']				= "Reglas";
$LNG['rules']						= array(
	"Cuentas"					=> "El propietario de una cuenta es siempre el propietario de la dirección de Correo Electrónico. A cada cuenta puede jugar un solo jugador.
									La única excepción es la tarea de cuidador. Si por alguna ocasión es necesario que la cuenta la controle uno o varios operadores. El operador competente deberá ser informado con antelación y obtener la aprobación del equipo del juego. Como mínimo el aviso deberá realizarse con más de 12 horas al período de control.
									Todos los movimientos de la flota están totalmente prohibidos, sólo está permitido en caso de un ataque a la cuenta en cuestión y el movimiento se limita a mover las naves y materias primas entre el planeta en cuestión y otro planeta o luna de la misma cuenta.
									Una cuenta puede ser cuidada durante un período de 72 horas. Existen excepciones, con la previa autorización de un operador.
									El cuidador de la cuenta lo puede hacer como máximo 3 veces al mes y hacer todo de forma gratuita.
									Todo el manejo de la cuenta debe quedar registrado por un operador.",

	"Multi Cuentas"				=> "Cada jugador tiene permitido jugar una cuenta por universo. Si dos o más cuentas se usan, ya sea temporal o permanente, desde la misma conexión a Internet (por ejemplo, escuelas, universidades y Cyber Cafés), deben aclarar con antelación a la administración para obtener una cuota de cuentas. En estos casos, está prohibido entre las cuentas correspondientes cualquier contacto con de flotas, mientras se use la misma conexión a Internet. Del mismo modo, otras acciones similares están prohibidas.",

	"Pushing"					=> "No está permitido a ninguna cuenta obtener provecho injusto a cabo de una cuenta de menor puntuación en cuestión de recursos.
Esto incluye pero no esta limitado a:

- Recursos enviados desde una cuenta de menor puntuación a una de mayor puntuación sin obtener nada tangible a cambio.
- Un jugador destruya su flota en una de mayor puntuación para que la de mayor puntuación pueda mantener el campo de escombros, y así sacar provecho de ella.
- Los préstamos que no se devuelven en 48 horas.
- Operaciones en las que el jugador de mayor puntuación no devuelve los recursos dentro de las 48 horas.
- Jugadores de que responden a una extorsión de un jugador de mayor puntuación mediante el pago de los recursos.
- Intercambios que significan un beneficio injusto para el jugador de mayor puntuación por la salida fuera de la siguiente gama de relaciones:

03:02:01 Donde cada unidad de deuterio vale 2 unidades de cristal o 3 unidades de metal.

02:01:01 Donde cada unidad de deuterio es un valor de 1 unidad de cristal o 2 unidades de metal.",

	"Bashing"					=> "Está prohibido más de cinco ataques en 24 horas sobre el mismo planeta - la luna se cuenta como un planeta aparte. Sondas de Espionaje o misiles interplanetarios no se consideran.
El Bashing sólo se aplica a los jugadores activos. Solo en caso de guerra declarada se permite más ataques. (Sujeto a la notificación entre ambas alianzas, con nombres de jugador correctamente listados) La guerra debe ser declarada en el foro al menos 24 horas antes que los ataques. Una declaración de guerra sólo puede ser dirigida a alianzas, y la declaración de guerra puede tener lugar a través de una alianza o una sola persona.
Es necesario que ambas partes de la Guerra estén de acuerdo en el foro. Las guerras que sólo sirven paraa la evasión masiva de Bashing están prohibidas. Los moderadores, operadores o administradores harán de juez para mediar posibles casos.",

	"Ataques de Misiles"             => "Se admiten un total de 1000 misiles cada 24 horas. El número de ataques en que se envian los misiles es irrelevante",

	"Explotar Errores"					=> "La explotación de errores y / o bugs en la programación está prohibida. Los errores detectados deben ser reportados con la mayor brevedad posible por correo, en el foro de errores, IRC  o ICQ. El engaño en el reporte también  está prohibido.",

	"Idioma en el Juego"			=> "En todos los universos correspondientes se debe utilizar el idioma oficial del juego. Violaciones a esto puede ser castigado con sanciones. El uso de idiomas extranjeros en  los Mensajes /Páginas de alianza puede conducir a sanciones.",

	"Amenazas/Insultos"	=> "Extorsión y amenazas a la vida real de un jugador puede llevar a la exclusión de una o todas las áreas del juego.
Se consideran todas las amenazas y el chantaje que aparezcan tanto en una noticia del juego, foros, IRC, los canales de ICQ, mensajes entre jugadores o dentro de alianzas, donde pueda verse claramente la intención de buscar a una persona y causarle daño o a un tercero relacionado.",

	"Spam y Contenido adulto"			=> "Spam y la publicidad a sitios exteriores está prohibido. Enlaces a sitios o contenidos eróticos y pornográficos están prohibidos. ¡Se sanciona con un bloqueo en todos los universos del juego  de por vida!",

	"Las Reglas"	=> "Las reglas se pueden cambiar, y cada usuario esta obligado a mantenerse informado constantemente  sobre las mismas.",

);

$LNG['rules_info1']				= "Para informarse más ir al <a href=\"%s\" target=\"_blank\">Foro</a> y a la Página Principal del Juego ...";
$LNG['rules_info2']				= "Para complementar las reglas están los  <a onclick=\"ajax('?page=agb&getajax=1');\" style=\"cursor:pointer;\">T & C</a> ¡Leerlos y siempre cumplirlos !</font>";


//AGB

$LNG['agb_overview']				= "Términos y Condiciones";
$LNG['agb']						= array(
	"Servicios"				=> array(
		"El reconocimiento de los T&C son un requisito previo necesario para poder participar en el juego.
Se aplican a todas las ofertas por parte de los operadores, incluido el Foro y otros contenidos del juego. ",

                "El servicio es gratuito.
Por lo tanto no existen reclamaciones a la disponibilidad, la entrega, la funcionalidad, o da&ntilde;os y perjuicios.
Ademas, el jugador no debe tener pretensiones de restaurar una cuenta tratada negativamente.",
	),

	"Membresía"				=> array(
		"Con el registro exitoso en el juego y / o en el foro se iniciará en la membrecía.",

		"La  membrecía puede ser finalizada en cualquier momento por parte del dueño de la cuenta como por un administrador debido a un pedido o sanción.
		La supresión de los datos, por razones técnicas no es instantánea",

		"En caso de que se tome una decisión por parte de un operador ningún usuario tiene derecho a reclamar o participar en las discusiones  del operador.
		El administrador (o miembro del equipo del juego) se reserva el derecho de eliminar cuentas.
		La decisión sobre la cancelación de una cuenta es únicamente de las autoridades del juego (operador, Moderador o Administrador).
		Cualquier reclamo a un miembro del Equipo por los eventos anteriores no posee ninguna validez legal.",

		"Todos los derechos sobre el juego  permanecen con el Administrador",
	),

	"Responsabilidades/Contenidos"	=> "Los usuarios son responsables de todo contenido presente en las zonas de interacción (Comunicaciones entre usuarios, alianzas, imágenes) o modificación de datos presentes (descripciones, nombres de elementos) en los diversos juegos. Contenidos pornográficos, racistas, abusivos, o que vulnere alguna ley queda fuera de la responsabilidad del operador.
										Violaciones a leyes puede dar lugar a la inmediata cancelación o suspensión de la cuenta del usuario en cuestión.
										La supresión de estos contenidos se lleva a cabo lo más rápidamente posible, pero puede ser postergada por razones técnicas y / o personal por lo que no puede responsabilizarse a los administradores del juego.",

	"Procedimientos Prohibidos"			=> array(
		"El usuario no está autorizado a usar el hardware / software o cualquier otro hecho o mecanismos asociados con el sitio web, que puede interferir con el funcionamiento normal del juego del juego.
		El usuario no puede adoptar ninguna medida que una genere carga inaceptable o problemas técnicos en el Juego.
		El usuario no puede manipular por el contenido generado por el juego, o interferir de cualquier otra manera  en el funcionamiento del mismo. ",

		"Cualquier tipo de bot, script o otras función automática está prohibida.
		El juego debe ser jugado sólo en el navegador. Incluso aunque las opciones del mismo lo permitan, no se deben utilizar funciones  para obtener una ventaja de juego.
		Por lo tanto, no pueden bloquearse los anuncios de publicidad dentro del juego. La decisión de cuando un software genera ventaja para el jugador es decisión del equipo del juego (Administradores, Moderadores y Operadores). ",

		"Un sistema automatizado ingresar a la cuenta o registrarla, independientemente de si la página se muestra o no, no está permitido",
	),

	"Limitaciones de Uso"		=> array(
		"Un jugador sólo puede usar una cuenta por universo. Los jugadores que registran y usan multicuentas están incumpliendo las normas por lo que las cuentas se pueden eliminar o sancionar sin previo aviso.
		La decisión de cuando la situación es una multicuenta corresponde exclusivamente a los  administradores, moderadores y/o operadores. ",
		"El jugador se compromete a cumplir con las reglas del juego.",
		"Los cierres de cuenta pueden ser forma permanente o temporal y esto queda a cargo del operador, moderado o administrador que reviso el hecho.
		Del mismo modo, las sanciones pueden ser e una o todas las áreas que comprende el juego.
		La decisión de cuándo y por cuánto tiempo un jugador está sancionado se encuentra únicamente en los administradores, moderadores y/o operadores. "
	),

	"Política de Privacidad"					=> array(
		"El operador se reserva el derecho de almacenar los datos de los jugadores, vigilar su comportamiento para asegurar el cumplimiento de las reglas, y los T&C.
		Para lo anterior es necesario un registro de todas las acciones realizadas por los jugadores y datos que almacena DENTRO del juego. Estos datos incluyen IP relacionados al período de uso, las zonas de uso y los datos de registro (NO SE TIENE CONOCIMIENTO DE LA CONTRASEÑA).
		En los foros, los datos almacenados incluyen  el perfil, temas y comentarios.",

		"Los datos se darán a conocer en ciertas circunstancias para llevar a cabo el cumplimiento de las reglas y T&C por parte de las personas autorizadas.
		Además, si es necesario, los datos pueden ser emitidos a terceros bajo ciertas circunstancias que lo requieran.
		",

		"El usuario puede objetar el almacenamiento de sus datos personales en cualquier momento. Una contradicción es el derecho de rescisión, donde debe esperar que acabe el período de cierre de cuenta.",
	),

	"Derechos del Titular de Cuenta"	=> array(
		"Todas las cuentas y objetos virtuales son propiedad del equipo de administración.
		El jugador no tiene ningún derecho de propiedad sobre la cuenta o cualquier sección del juego. Su posición le otorga una responsabilidad sobre el uso del juego.
		Todos los derechos permanecen en el equipo de administración.
		La transferencia de la propiedad del juego u otros derechos  se puede llevar a cabo en cualquier momento.",

		"La venta no autorizada, uso, copia, distribución o violación de los derechos legales  (ej. Cuenta) por parte de jugadores u operadores será reportada a las autoridades competentes y en consecuencia procesada.
		La transferencia final de la cuenta y los recursos dentro del juego de forma gratuita está permitido, siempre y cuando no vaya la acción en contra de alguna regla o T&C.",
	),

	"Responsabilidad"	=> "El titular de cada universo no se hace responsable de los daños y perjuicios.
	El titular no tiene responsabilidad por daños causados por dolo, negligencia grave o cualquier daño a la vida y la salud que pueda ser provocado por el uso del juego por parte de los jugadores. En este sentido, se señala expresamente que los videojuegos pueden representar un riesgo significativo para la salud.
	El titular y/o los miembros del equipo no pretenden que por el juego ocurra algún tipo de daño al bienestar de los jugadores, y se desligan de toda responsabilidad por el mal o excesivo uso del juego.",

	"Modificación de los T&C o Reglas"	=> "El administrador se reserva el derecho de modificar estos términos o añadir nuevos en cualquier momento.
	Las modificaciones y agregados a los T&C o las reglas serán informadas en el foro una semana antes de que entren en vigencia.",
);

//Facebook Connect

$LNG['fb_perm']				= 'Acceso denegado. %s necesita de todos los derechos para acceder acceder con tu cuenta de Facebook.\nComo alternativa, se puede acceder sin una cuenta de Facebook!';

//NEWS

$LNG['news_overview']			= "Noticias";
$LNG['news_from']				= "Publicado el %s por %s";
$LNG['news_does_not_exist']	= "¡No hay noticias disponibles!";

//Impressum

$LNG['disclamer']				= "Descargo";
$LNG['disclamer_name']			= "Nombre:";
$LNG['disclamer_adress']		= "Dirección:";
$LNG['disclamer_tel']			= "Telefono:";
$LNG['disclamer_email']		    = "Correo Electrónico:";
?>