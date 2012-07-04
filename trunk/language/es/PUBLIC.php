<?php

//general
$LNG['index'] = 'Indice';
$LNG['register'] = 'Registro';
$LNG['forum'] = 'Foro';
$LNG['send'] = 'Aceptar';
$LNG['menu_index'] = 'Inicio';
$LNG['menu_news'] = 'Noticias';
$LNG['menu_rules'] = 'Reglas';
$LNG['menu_pranger'] = 'Baneados';
$LNG['menu_top100'] = 'Salón de la Fama';
$LNG['menu_disclamer'] = 'Contacto';
$LNG['uni_closed'] = '(offline)';

//index.php
//case lostpassword

$LNG['lost_empty'] = '¡Debes rellenar todos los campos!';
$LNG['lost_not_exists'] = '¡No pudo encontrarse ningún usuario que posea este correo electrónico!';
$LNG['lost_mail_title'] = 'Nueva contraseña';
$LNG['mail_sended'] = '¡Su nueva contraseña ha sido enviada con éxito!';

//case default

$LNG['server_infos'] = array("Un juego de estrategia espacial en tiempo real.", "Juega junto con cientos de jugadores.", "Nada de descarga, s&oacute;lo se requiere un navegador est&aacute;ndar.", "Registro Gratuito", );

$LNG['login_error_1'] = 'Usuario/Contrase&ntilde;a Incorrecto!';
$LNG['login_error_2'] = 'Alguien se ha conectado desde otro ordenador con esta cuenta!';
$LNG['login_error_3'] = 'La sesi&oacute;n ha expirado!';
$LNG['login_error_4'] = 'Hubo un error en la autorización externa, por favor inténtelo más tarde!';
$LNG['screenshots'] = 'Imagenes';
$LNG['universe'] = 'Universo';
$LNG['chose_a_uni'] = 'Elige Universo';

/* ------------------------------------------------------------------------------------------ */

//lostpassword.tpl
$LNG['lost_pass_title'] = 'Recuperar Contraseña';

//index_body.tpl
$LNG['user'] = 'Usuario';
$LNG['pass'] = 'Contrase&ntilde;a';
$LNG['remember_pass'] = 'Auto-Login';
$LNG['lostpassword'] = 'Recordar Contrase&ntilde;a';
$LNG['welcome_to'] = 'Bienvenido a';
$LNG['server_description'] = '<strong>%s</strong> es un <strong>Juego de Simulación de Estrategia en el Espacio</strong> compite con cientos de jugadores conectados a lo largo del planeta <strong>simultaneamente</strong> para ser el/la mejor de todos. Todo lo que necesitas para jugar es un navegador Web Estandart.';
$LNG['server_register'] = 'Registrate Ahora';
$LNG['server_message'] = 'Reg&iacute;strese ahora y experimente una nueva y emocionante aventura en el mundo de';
$LNG['login'] = 'Conexión';
$LNG['disclamer'] = 'Contacto';
$LNG['login_info'] = 'Al conectarme, estoy de acuerdo con las siguientes <a href="index.php?page=rules">Reglas</a>';

/* ------------------------------------------------------------------------------------------ */

//reg.php - Registrierung
$LNG['register_closed'] = 'Registro Cerrado!';
$LNG['register_at'] = 'Registrado en ';
$LNG['reg_mail_message_pass'] = 'Un paso m&aacute;s para activar su nombre de usuario';
$LNG['reg_mail_reg_done'] = 'Bienvenido a %s!';
$LNG['invalid_mail_adress'] = 'Correo Electrónico Incorrecto!<br>';
$LNG['empty_user_field'] = 'Por favor, rellene todos los campos!<br>';
$LNG['password_lenght_error'] = 'La contrase&ntilde;a debe tener al menos 6 caracteres!<br>';
$LNG['user_field_specialchar']		= 'Los nombres de usuario sólo permiten números, letras, espacios, _, -,.!';
$LNG['planet_field_no'] = 'Debe introducir un Nombre al Planeta!';
$LNG['planet_field_specialchar']	= 'Los nombres de planeta sólo permiten números, letras, espacios, _, -,.!';
$LNG['terms_and_conditions'] = '¡Usted debe aceptar el Reglamento!';
$LNG['user_already_exists'] = 'El nombre de usuario ya está siendo usado.<br>';
$LNG['mail_already_exists'] = 'La dirección de correo electrónico ya está en uso.<br>';
$LNG['wrong_captcha'] = 'Código de Seguridad incorrecto.<br>';
$LNG['different_passwords'] = 'Ha introducido dos contraseñas diferentes.<br>';
$LNG['different_mails'] = 'Ha introducido dos direcciónes de correo electrónico diferentes.<br>';
$LNG['welcome_message_from'] = 'Administración';
$LNG['welcome_message_sender'] = 'Administración';
$LNG['welcome_message_subject'] = 'Bienvenido';
$LNG['welcome_message_content'] = 'Bienvenido a %s!<br>En primer lugar construye una Planta de energ&iacute;a solar, porque la energ&iacute;a es necesaria para la posterior producci&oacute;n de materias primas. Para construirla, haga clic en Edificios en el menú del panel izquierdo. Cuando tengas la energ&iacute;a, puedes comenzar a construir las minas. Vuelve al men&uacute; Edificio y construye una mina de metal, y luego otra vez una mina de cristal. Para construír Naves, deberá construír un Hangar. Para conocer los requerimientos de cualquier construcción, puede observarlos en la zona de Tecnología, la cual se accede desde el Menú izquierdo. El equipo le desea mucha diversi&oacute;n y comienza a explorar el universo!';
$LNG['reg_completed'] = 'Gracias por registrarte, recibirás un correo electrónico con el enlace de activación de la cuenta.';
$LNG['planet_already_exists'] = '¡La posición del planeta ya está ocupada!';

//registry_form.tpl
$LNG['server_message_reg'] = 'Reg&iacute;strate ahora y forma parte de';
$LNG['register_at_reg'] = 'Registrado en';
$LNG['uni_reg'] = 'Universo';
$LNG['user_reg'] = 'Usuario';
$LNG['pass_reg'] = 'Contrase&ntilde;a';
$LNG['pass2_reg'] = 'Confirmar Contrase&ntilde;a';
$LNG['email_reg'] = 'Direccion de Correo electrónico';
$LNG['email2_reg'] = 'Confirmar Direccion Correo electrónico';
$LNG['planet_reg'] = 'Nombre del planeta principal';
$LNG['ref_reg'] = 'Referido por';
$LNG['lang_reg'] = 'Idioma';
$LNG['register_now'] = 'Registrate';
$LNG['captcha_reg'] = 'Clave de Seguridad';
$LNG['accept_terms_and_conditions'] = 'Acepto las <a href="index.php?page=rules">Reglas</a>.';
$LNG['captcha_reload'] = 'Recarga';
$LNG['captcha_help'] = 'Ayuda';
$LNG['captcha_get_image'] = 'Carga Bild-CAPTCHA';
$LNG['captcha_reload'] = 'Nuevo CAPTCHA';
$LNG['captcha_get_audio'] = 'Carga Sonido-CAPTCHA';
$LNG['user_active'] = 'Usuario %s se ha activado!';

//Rules
$LNG['rules_overview'] = "Reglas";

//NEWS

$LNG['news_overview'] = "Noticias";
$LNG['news_from'] = "Publicado el %s por %s";
$LNG['news_does_not_exist'] = "¡No hay noticias disponibles!";

//Impressum

$LNG['disclamer'] = "Descargo";
$LNG['disclamer_name'] = "Nombre:";
$LNG['disclamer_adress'] = "Dirección:";
$LNG['disclamer_tel'] = "Telefono:";
$LNG['disclamer_email'] = "Correo Electrónico:";

// Translated into Spanish by Scofield06 . All rights reversed (C) 2011
?>