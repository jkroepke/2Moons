<?php

/**
 *  2Moons
 *  Copyright (C) 2011 Jan Kröpke
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
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2009 Lucky
 * @copyright 2011 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.5 (2011-07-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

$LNG['back']					= 'Wróć';
$LNG['continue']				= 'Dalej';
$LNG['login']					= 'Login';

$LNG['menu_intro']				= 'Intro';
$LNG['menu_install']			= 'Instalacja';
$LNG['menu_license']			= 'Licencja';

$LNG['title_install']			= 'Instalator';

$LNG['intro_lang']				= 'Język';
$LNG['intro_install']			= 'Przejdź do instalacji';
$LNG['intro_welcome']			= 'Serdecznie witamy w 2Moons!';
$LNG['intro_text']				= '2Moons to najlepszy klon Ogame.<br>2Moons to najnowsza i najbardziej stabilna wersja Xnova, jaka kiedykolwiek powstała. Cechuje ją przyjazność, elastyczność i dynamiczność jak również jakość obsługi. Mamy nadzieję że jak zawsze sprawimy się lepiej niż oczekiwaliście. System przeprowadzi Cię przez proces instalacji, lub też aktualizacji aktualnej wersji do najnowszej. Jeśli masz jakiekolwiek problemy nie wachaj się zadać pytania na naszym forum poświęconemu rozwojowi i wsparciu.<br><br>2Moons podlega licencji GNU GPL v3. Licencje przeczytasz po kliknięciu odpowiedniego linku w menu.<br><br>Przed instalacją skrypt sprawdzi czy twój serwer spełnia minimalne wymagania.';

$LNG['licence_head']			= 'Licencja';
$LNG['licence_desc']			= 'Prosze przeczytać licencję, przewiń by przeczytać całą!.';
$LNG['licence_accept']			= 'Możesz zainstalować ten program tylko wtedy, gdy zgadasz sie z postanowieniami licencji.';
$LNG['licence_need_accept']		= 'By przejść dalej zaakceptuj licencję.';

$LNG['req_head']				= 'Wymagania systemowe';
$LNG['req_desc']				= '2Moons sprawdzi teraz konfigurację twojego serwera. Czytaj uważnie wyniki testów nim przejdziesz dalej. Jeśli chcesz używać opcjonalnych modułów to upewnij się że dodatkowe testy mają wynik pozytywny..';
$LNG['reg_yes']					= 'Tak';
$LNG['reg_no']					= 'Nie';
$LNG['reg_found']				= 'Znalazłem';
$LNG['reg_not_found']			= 'Nie znalazłem';
$LNG['reg_writable']			= 'zapisywalny';
$LNG['reg_not_writable']		= 'Nie zapisywalny';
$LNG['reg_file']				= 'Dane &raquo;%s&laquo; zapisywalne?';
$LNG['reg_dir']					= 'Katalogi &raquo;%s&laquo; zapisywalne ?';
$LNG['req_php_need']			= 'Minimalna wersja &raquo;PHP&laquo;';
$LNG['req_php_need_desc']		= '<strong>Wymagane</strong> — PHP to język skryptowy wykonywane po stronie serwera, 2Moons jest w nim napisany. Do poprawnej instalacji wymagana wersja minimalna to PHP Version 5.2.5.';
$LNG['reg_gd_need']				= 'Zainstalowana wersja biblioteki graficznej &raquo;gdlib&laquo;';
$LNG['reg_gd_desc']				= '<strong>Opcjonalne</strong> — Biblioteka graficzna &raquo;gdlib&laquo; jest potrzebna do generowania grafik w "locie". Bez niej nie wykorzystasz wszystkich możliwości 2Moons.';
$LNG['reg_mysqli_active']		= 'Rozszerzenie &raquo;MySQLi&laquo;';
$LNG['reg_mysqli_desc']			= '<strong>Wymagane</strong> — musisz mieć zainstalowane rozszerzenie MYSQLi dla php. Jeśli nie masz musisz się skontaktować z dostawcą usługi lub zainstalować samemu.';
$LNG['reg_json_need']			= 'Dostępny &raquo;JSON&laquo; ?';
$LNG['reg_iniset_need']			= 'Funkcja php &raquo;ini_set&laquo; dostępna?';
$LNG['reg_global_need']			= 'register_globals deaktywowane?';
$LNG['reg_global_desc']			= '2Moons nie będzie funkcjonował gdy register_globals jest aktywne. Z powodów bezpieczeństwa zaleca się by, register_globals wyłączyć w ustawieniach php.';
$LNG['req_ftp_head']			= 'Dostęp do FTP';
$LNG['req_ftp_desc']			= 'Tutaj podaj dane dostępowe do serwera FTP, dzięki temu 2Moons będzie mogło się automatycznie aktualizować. Alternatywnym sposobem jest robienie tego ręcznie.';
$LNG['req_ftp_host']			= 'Hostname';
$LNG['req_ftp_username']		= 'Nazwa użytkownika';
$LNG['req_ftp_password']		= 'Hasło';
$LNG['req_ftp_dir']				= 'Ścieżka do katalogu w którym jest zainstalowane 2Moons';
$LNG['req_ftp_send']			= 'Wyślij';
$LNG['req_ftp_error_data']		= 'Połączenie z serwerem nie powiodło się.';
$LNG['req_ftp_error_dir']		= 'Błędna ścieżka dostępu do plików.';

$LNG['step1_head']				= 'Konfiguracja bazy danych';
$LNG['step1_desc']				= 'Tutaj musisz podać dane do połączenia się z baza mysql, jeśli ich nie znasz skontaktują się usługodwacą hostingu, lub napisz na forum wsparcia.';
$LNG['step1_mysql_server']		= 'Adres serwera mysql';
$LNG['step1_mysql_port']		= 'Port serwera';
$LNG['step1_mysql_dbuser']		= 'Nazwa użytkownika';
$LNG['step1_mysql_dbpass']		= 'Hasło';
$LNG['step1_mysql_dbname']		= 'Nazwa bazy danych';
$LNG['step1_mysql_prefix']		= 'Prefix tabeli:';

$LNG['step2_prefix_invalid']	= 'Prefix może mieć tylko litery i cyfry ewentualnie znak podkreślenia.';
$LNG['step2_db_error']			= 'Błąd podczas łączenia do bazy danych:';
$LNG['step2_db_no_dbname']		= 'Nie znaleziono bazy danych o takiej nazwie.';
$LNG['step2_db_too_long']		= 'Nazwa tabeli jest za długa, maksymalnie 36 znaków.';
$LNG['step2_db_con_fail']		= 'Nie można połączyć z bazą danych, szczegóły poniżej.';
$LNG['step2_config_exists']		= 'config.php już istnieje!';
$LNG['step2_conf_op_fail']		= 'config.php jest nie zapisywalny!';
$LNG['step2_conf_create']		= 'config.php utworzono pomyślnie';
$LNG['step2_db_done']			= 'Połączenie z bazą danych ustalone!';

$LNG['step3_head']				= 'Instalacja tabeli';
$LNG['step3_desc']				= 'Tabele utworzone, przejdź do następnego kroku.';

$LNG['step4_head']				= 'Dane administratora';
$LNG['step4_desc']				= 'Kreator instalacji utworzy teraz konto administratora, proszę podać hasło, nazwę użytkownika i adres email.';
$LNG['step4_admin_name']		= 'Nazwa konta administratora:';
$LNG['step4_admin_name_desc']	= 'Nazwa musi mieć od 3 do 20 znaków.';
$LNG['step4_admin_pass']		= 'Hasło:';
$LNG['step4_admin_pass_desc']	= 'Minimalna długość hasła to 6 a maksymalnie 30 znaków.';
$LNG['step4_admin_mail']		= 'Adres kontaktowy email:';

$LNG['step6_head']				= 'Gratualcje!';
$LNG['step6_desc']				= 'Zainstalowałeś prawidłowo 2Moons.';
$LNG['step6_info_head']			= 'Możesz już grać!';
$LNG['step6_info_additional']	= 'Po kliknięciu zostaniesz przeniesiony na stronę zarządzania grą.<br/><br/><strong>Skasuj plik &raquo;includes/ENABLE_INSTALL_TOOL&laquo; nim gra zostanie udostępniona, w przeciwnym wypadku bezpieczeństwo serwera będzie zagrożone!</strong>';

$LNG['sql_close_reason']		= 'Gra chwilowo zamknięta';
$LNG['sql_welcome']				= 'Serdecznie witamy na 2Moons v';

?>