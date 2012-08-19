<?php

//general
$LNG['index']				= 'Index';
$LNG['register']			= 'Rejstracja';
$LNG['forum']				= 'Forum';
$LNG['send']				= 'Wyślij';
$LNG['menu_index']			= 'IndeX';
$LNG['menu_news']			= 'News';
$LNG['menu_rules']			= 'Regulamin';
$LNG['menu_pranger']		= 'Zbanowani';
$LNG['menu_top100']			= 'Hala Sław';
$LNG['menu_disclamer']		= 'Impressum';
$LNG['uni_closed']			= ' (closed)';

//index.php
//case lostpassword

$LNG['lost_empty']			= 'Musisz wypełnić wszystkie pola';
$LNG['lost_not_exists']		= 'Brak użytkownika z takim adresem email';
$LNG['lost_mail_title']		= 'Nowe hasło';
$LNG['mail_sended']			= 'Twoje hasło zostało wysłane na %s ';

//case default

$LNG['server_infos']			= array(
	"<h1>2Moon to prywatny serwer</h1> klon ogame oparty o 2moons. Gra online strategiczno-ekonomiczna czasu rzeczywistego w kosmosie. <br />",
	"Graj przeciwko innym graczom ! Nic nie musisz sciągać, grasz w przeglądarce ! W grze twoje postępy zależą tylko od Ciebie !.",
);

$LNG['login_error_1']		= 'Zła nazwa użytkownika albo hasło';
$LNG['login_error_2']		= 'Ktoś się zalogował na to konto z innego komputera!';
$LNG['login_error_3']		= 'Twoja sesja wygasła';
$LNG['login_error_4']		= 'Wystąpiło błędne logowanie. Szczególy na email';
$LNG['screenshots']			= 'Screenshots';
$LNG['universe']			= 'Universum';
$LNG['chose_a_uni']			= 'Wybierz universum';

/* ------------------------------------------------------------------------------------------ */

//lostpassword.tpl
$LNG['lost_pass_title']			= 'Przypomnienie hasła';

//index_body.tpl
$LNG['user']					= 'Użytkownik';
$LNG['pass']					= 'Hasło';
$LNG['remember_pass']			= 'Automatyczne logowanie';
$LNG['lostpassword']			= 'Zapomniałem hasło ?';
$LNG['welcome_to']				= 'Witaj na';
$LNG['server_description']		= 'prywatnym serwerze opartym o 2moons. Wszystko czego potrzebujesz by się dobrze bawić to przeglądarka (Polecamy FireFox  lub Chrome).';
$LNG['server_register']			= 'Zarejstruj się!';
$LNG['server_message']			= 'Zarejstruj się teraz by odkryć nowy świat i stać się jego częścią';
$LNG['login']					= 'Login';
$LNG['disclamer']				= 'Impressum';
$LNG['login_info']				= 'Logując się akceptujesz <a href="index.php?page=rules">Regulamin</a>';

/* ------------------------------------------------------------------------------------------ */

//reg.php - Registrierung
$LNG['register_closed']				= 'Rejstracja zamknięta!';
$LNG['register_at']					= 'Rejstracja na';
$LNG['reg_mail_message_pass']		= 'Jeszcze jeden krok do aktywacji twojego konta';
$LNG['reg_mail_reg_done']			= 'Witaj na %s!';
$LNG['invalid_mail_adress']			= 'Błędny adres email!';
$LNG['empty_user_field']			= 'Musisz podać nazwę użytkownika';
$LNG['password_lenght_error']		= 'Hasło musi mieć conajmniej 6 znaków';
$LNG['user_field_specialchar']		= 'W nazwie użytkownika są dozwolone tylko liczby, litery i puste znaki, ewentualnie , _, - .';
$LNG['planet_field_no']				= 'Musisz podać nazwę planety';
$LNG['planet_field_specialchar']	= 'W nazwie planety są dozwolone tylko liczby, litery i puste znaki, ewentualnie , _, - .';
$LNG['terms_and_conditions']		= 'Musisz zaakceptować regulamin';
$LNG['user_already_exists']			= 'Ta nazwa użytkownika jest już używana!';
$LNG['mail_already_exists']			= 'Ten adres został już użyty';
$LNG['wrong_captcha']				= 'Błędny kod';
$LNG['different_passwords']			= 'Podałeś dwa różne hasła';
$LNG['different_mails']				= 'Podałeś dwa różne adresy email';
$LNG['welcome_message_from']		= 'Administrator';
$LNG['welcome_message_sender']		= 'Administrator';
$LNG['welcome_message_subject']		= 'Witaj';
$LNG['welcome_message_content']		= 'Witaj na %s!<br>Pierwsze to zbuduj elektorwnie słoneczną, energia jest wymagana by móc wydobywać zasoby. By zacząć budowe wejdź w menu budynki . I zbuduj 4 budynek od góry. Teraz możesz zacząc budować kopalnie. Wróć do menu budynków i zacznij budować kopalnie metalu, potem kryształu. By budować okręty musisz najpierw zbudować stocznie. Co jest wymagane, informacje znajdziesz w menu technologie. Administracja życzy dużo przyjemności z odkrywania uniwersum :)!';
$LNG['reg_completed']				= 'Dziękujemy za zarejstrowanie się. Na pocztę został wysłany email z linkiem aktywacyjnym';
$LNG['planet_already_exists']		= 'Ta pozycja planety jest już zajęta';

//registry_form.tpl
$LNG['server_message_reg']			= 'Zarejstruj się teraz i zostań częscią ';
$LNG['register_at_reg']				= 'Zarejstrowany na';
$LNG['uni_reg']						= 'Universum';
$LNG['user_reg']					= 'Użytkownik';
$LNG['pass_reg']					= 'Hasło';
$LNG['pass2_reg']					= 'Potwierdź hasło';
$LNG['email_reg']					= 'E-Mail Adres';
$LNG['email2_reg']					= 'Potwierdź E-mail Adres';
$LNG['planet_reg']					= 'Nazwa planety matki';
$LNG['ref_reg']						= 'Zaproszony przez ';
$LNG['lang_reg']					= 'Język';
$LNG['register_now']				= 'Zarejstruj!';
$LNG['captcha_reg']					= 'Pytanie pomocniczne';
$LNG['accept_terms_and_conditions']	= 'Zrozumiałem <a href="index.php?page=rules">Regulamin</a>.';
$LNG['captcha_help']				= 'Pomoc';
$LNG['captcha_get_image']			= 'Załaduj Bild-CAPTCHA';
$LNG['captcha_reload']				= 'Przeładuj CAPTCHA';
$LNG['captcha_get_audio']			= 'Załaduj Sound-CAPTCHA';
$LNG['user_active']					= 'Użytkownik %s został aktywowany';

//Rules
$LNG['rules_overview']				= "Regulamin";
$LNG['rules_info1']					= "Regulamin znajdziesz na <a href=\"%s\" target=\"_blank\">Forum</a> na stronie startowej jak i w samej grze!";


//NEWS

$LNG['news_overview']				= "Nowości";
$LNG['news_from']					= "Od %s do %s";
$LNG['news_does_not_exist']			= "Brak nowych wiadomości";

//Impressum

$LNG['disclamer']					= "Haftungsausschluss";
$LNG['disclamer_name']				= "Nazwa:";
$LNG['disclamer_adress']			= "Adres:";
$LNG['disclamer_tel']				= "Telefon Nr.:";
$LNG['disclamer_email']				= "E-Mail Adress:";
?>