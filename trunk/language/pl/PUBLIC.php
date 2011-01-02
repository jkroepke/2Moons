<?php

//general
$LNG['index']				= 'Start';
$LNG['register']			= 'Rejestracja';
$LNG['forum']				= 'Forum';
$LNG['send']				= 'Wyślij';
$LNG['menu_index']			= 'Home'; 	 
$LNG['menu_news']			= 'Newsy';	 
$LNG['menu_rules']			= 'Zasady'; 
$LNG['menu_agb']			= 'OWU'; 
$LNG['menu_pranger']		= 'Zbanowani';
$LNG['menu_top100']		= 'Hall of Fame';	 
$LNG['menu_disclamer']		= 'Kontakt';	 
	 
/* ------------------------------------------------------------------------------------------ */

//index.php
//case lostpassword
$LNG['mail_not_exist'] 		= 'Podany e-mail nie istnieje!';
$LNG['mail_title']				= 'Nowe hasło';
$LNG['mail_text']				= 'Twoje nowe hasło to: ';
$LNG['mail_sended']			= 'Nowe hasło zostało pomyślnie wysłane!';
$LNG['mail_sended_fail']		= 'Wiasomość nie została wysłana!';
$LNG['server_infos']			= array(
	"Gwiezdna strategia w czasie rzeczywistym.",
	"Możesz grać z setkami ludzi z całęgo świata.",
	"Nie musisz nic pobierać, ani instalować - wystarczy przeglądarka internetowa.",
	"Darmowa rejestracja",
);

//case default
$LNG['login_error']			= 'Niepoprawna nazwa / hasło! <br><a href="index.php">Potrów</a>';
$LNG['screenshots']			= 'Screeny';
$LNG['universe']				= 'Universum';
$LNG['chose_a_uni']			= 'Wybierz Uniwersum';

/* ------------------------------------------------------------------------------------------ */

//lostpassword.tpl
$LNG['lost_pass_title']		= 'Odzyskaj hasło';
$LNG['retrieve_pass']			= 'Przywróć';
$LNG['email']					= 'E-mail';

//index_body.tpl
$LNG['user']					= 'Nazwa';
$LNG['pass']					= 'Hasło';
$LNG['remember_pass']			= 'Zapamietaj mnie';
$LNG['lostpassword']			= 'Zapomniałeś hasła?';
$LNG['welcome_to']				= 'Witamy na';
$LNG['server_description']		= 'Marzy Ci się, by być gwiezdnym imperatorem, jesteś dobrym strategiem, chcesz podbijać nowe planety, galaktyki, wyeliminować innych wrogów i być na samym czele gwiezdnych graczy - zarejestruj się. Poprzez rozbudowę swojej infrasturktury, odkrywanie nowych technologii, licznym wojnom, sojuszom pnij sie na sam szczyt. Tylko dzięki swojej wytrwałości stalowych nerwów, stoickiego spokoju, opanowania w krytycznych momentach możesz dosięgnąć szczytu swoich najskrytszym marzeń. Zostań najlepszym Imperatorem w wirtualnym kosmosie!';
$LNG['server_register']		= 'Zagraj za darmo!';
$LNG['server_message']			= 'Dołącz do Nas i podbijaj gwiezdne galaktyki kosmosu!';
$LNG['login']					= 'Login';
$LNG['disclamer']				= 'Kontakt';
$LNG['login_info']				= 'Rejestrując się akceptujesz <a onclick="ajax(\'?page=rules&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">Zasady</a> oraz <a onclick="ajax(\'?page=agb&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">OWU</a>';

/* ------------------------------------------------------------------------------------------ */

//reg.php - Registrierung
$LNG['register_closed']			= 'Rejestracja zamknięta!';
$LNG['register_at']				= 'Zarejestruj na ';
$LNG['reg_mail_message_pass']		= 'Potwierdzenie aktywacji';
$LNG['reg_mail_reg_done']			= 'Witamy na %s!';
$LNG['invalid_mail_adress']		= 'Niepoprawny e-mail.!<br>';
$LNG['empty_user_field']			= 'Proszę usupełnić wszystkie pola!<br>';
$LNG['password_lenght_error']		= 'Hasło musi mieć conajmniej 4 znaki!<br>';
$LNG['user_field_no_alphanumeric']	= 'Nazwa gracza moze zawierać tylko znaki alfanumeryczne!<br>';
$LNG['user_field_no_space']		= 'Proszę nie zostawiać pustej nazwy!<br>';
$LNG['planet_field_no_alphanumeric']	= 'Nazwa plantety moze zawierać tylko znaki alfanumeryczne!<br>';
$LNG['planet_field_no_space']		= 'Proszę nie zostawiać pustej nazwy planety!<br>';
$LNG['terms_and_conditions']		= 'Musisz zaakcepotwać <a href="index.php?page=agb">OWU</a> oraz <a href="index.php?page=rules>Zasady</a> !<br>';
$LNG['user_already_exists']		= 'Nazwa gracza jest zajęta!<br>';
$LNG['mail_already_exists']		= 'E-mail jest używany przez innego gracza!<br>';
$LNG['wrong_captcha']				= 'Błędny kod!<br>';
$LNG['different_passwords']		= 'Podałeś dwa różne hasła!<br>';
$LNG['different_mails']			= 'Podałeś dwa różne adresy E-mail!<br>';
$LNG['welcome_message_from']		= 'Administrator';
$LNG['welcome_message_sender']		= 'Administrator';
$LNG['welcome_message_subject']	= 'Witaj';
$LNG['welcome_message_content']	= 'Witamy na %s!<br>Życzymy miłej gry!';
$LNG['newpass_smtp_email_error']	= '<br><br>Błąd ogólny. Twojw hasło to: ';
$LNG['reg_completed']				= 'Dziękujemy za rejestrację. Po odebraniu poczty e-mail prosimy aktywować konto, aby zacząć grę!';

//registry_form.tpl
$LNG['server_message_reg']			= 'Zarejestruj na';
$LNG['register_at_reg']			= 'Zarejestruj na';
$LNG['uni_reg']					= 'Universum';
$LNG['user_reg']					= 'Nazwa gracza';
$LNG['pass_reg']					= 'Hasło';
$LNG['pass2_reg']					= 'Potwierdź hasło';
$LNG['email_reg']					= 'Adres E-mail';
$LNG['email2_reg']					= 'Potwierdź E-mail';
$LNG['planet_reg']					= 'Nazwa planety matki';
$LNG['lang_reg']					= 'Język';
$LNG['register_now']				= 'Zarejestruj!';
$LNG['captcha_reg']				= 'Security question';
$LNG['accept_terms_and_conditions']= 'Akceptuję <a onclick="ajax(\'?page=rules&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">Zasady</a> oraz <a onclick="ajax(\'?page=agb&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">OWU</a>';
$LNG['captcha_reload']				= 'Odśwież';
$LNG['captcha_help']				= 'Pomoc';
$LNG['captcha_get_image']			= 'Załaduj Bild-CAPTCHA';
$LNG['captcha_reload']				= 'Nowa CAPTCHA';
$LNG['captcha_get_audio']			= 'Załąduj dzwiękową-CAPTCHA';
$LNG['user_active']                = 'Gracz %s został aktywowany!';

//registry_closed.tpl
$LNG['info']						= 'Informacja';
$LNG['reg_closed']					= 'Rejestracja wyłączonas';

//Rules
$LNG['rules_overview']				= "Zasady";
$LNG['rules']						= array(

);
$LNG['rules_info1']				= "";
$LNG['rules_info2']				= "To complement this, the <a onclick=\"ajax('?page=agb&getajax=1');\" style=\"cursor:pointer;\">T&C</a> are considered and followed!</font>";


//AGB

$LNG['agb_overview']				= "Ogolne warunki umowy";
$LNG['agb']						= array(

);

//Facebook Connect

$LNG['fb_perm']                = 'Access prohibited. %s needs all the rights so you can login with your Facebook account. \n Alternatively, you can login without a Facebook account!';

//NEWS

$LNG['news_overview']			= "News";
$LNG['news_from']				= "On %s by %s";
$LNG['news_does_not_exist']	= "No news available!";

//Impressum

$LNG['disclamer']				= "Disclaimer";
$LNG['disclamer_name']			= "Name";
$LNG['disclamer_adress']		= "Address";
$LNG['disclamer_tel']			= "Phone:";
$LNG['disclamer_email']		= "E-mail Address";

//Polish Language by Cyceron
?>