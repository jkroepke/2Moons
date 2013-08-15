<?php
/*
* Tradotto in italiano da XxidroxX
* Repository: https://github.com/XxidroxX/2moons-it
* Supporto: http://aesma.it
*/

$LNG['back']					= 'Indietro';
$LNG['continue']				= 'Continua';
$LNG['continueUpgrade']			= 'Aggiorna!';
$LNG['login']					= 'Login';

$LNG['menu_intro']				= 'Introduzione';
$LNG['menu_install']			= 'Installazione';
$LNG['menu_license']			= 'Licenza';
$LNG['menu_upgrade']			= 'Aggiorna';

$LNG['title_install']			= 'Installazione';

$LNG['intro_lang']				= 'Lingua';
$LNG['intro_install']			= 'All\'installazione';
$LNG['intro_welcome']			= 'Ciao utente di 2moons!';
$LNG['intro_text']				= '2moons &egrave; il migliore progetto dedicato ad OGame.';
$LNG['intro_upgrade_head']		= '2Moons gi&agrave; installato?';
$LNG['intro_upgrade_text']		= '<p>Hai gi&agrave; installato 2moons e vuoi aggiornarlo?</p><p>Qui puoi farlo in pochi click!</p>';

$LNG['licence_head']			= 'Termini di licenza';
$LNG['licence_desc']			= 'Per favore leggi i termini qui sotto. Usa la scrollbar per muoverti';
$LNG['licence_accept']			= 'Per continuare questa installazione devi accettare i termini di uso';
$LNG['licence_need_accept']		= 'Se vuoi continuare devi accettare questi termini!!!';

$LNG['req_head']				= 'Requisiti';
$LNG['req_desc']				= 'Prima di iniziare la traduzione, 2Moons far&agrave; qualche test per controllare che il tuo server sia idoneo ad ospitare questo engine.';
$LNG['reg_yes']					= 'Si';
$LNG['reg_no']					= 'No';
$LNG['reg_found']				= 'Trovato';
$LNG['reg_not_found']			= 'Non trovato';
$LNG['reg_writable']			= 'Scrivibile';
$LNG['reg_not_writable']		= 'Non scrivibile';
$LNG['reg_file']				= 'Il file &raquo;%s&laquo; &egrave; scrivibile?';
$LNG['reg_dir']					= 'La cartella &raquo;%s&laquo; &egrave; scrivibile?';
$LNG['req_php_need']			= 'Versione di PHP installata &raquo;PHP&laquo;';
$LNG['req_php_need_desc']		= '<strong>Richiesto</strong> — PHP &egrave; il linguaggio base per ogni script. La versione richiesta &egrave; la 5.2.5 o superiore.';
$LNG['reg_gd_need']				= 'Versione installata dello script GD PHP &raquo;gdlib&laquo;';
$LNG['reg_gd_desc']				= '<strong>Opzionale</strong> — &Egrave; meglio che questa libreria sia attiva ma se cos&igrave; non fosse il gioco funzione&agrave; lo stesso.';
$LNG['reg_mysqli_active']		= 'Supporto estensione MySQLi';
$LNG['reg_mysqli_desc']			= '<strong>Richiesto</strong> — Hai bisogno di mysqli per far funzionare correttamente il gioco. Senza questo modulo il gioco non funzioner&agrave; se non lo hai contatta il tuo hosting!.';
$LNG['reg_json_need']			= 'Estensione &raquo;JSON&laquo; disponibile?';
$LNG['reg_iniset_need']			= 'La funzione PHP &raquo;ini_set&laquo; &egrave; disponibile?';
$LNG['reg_global_need']			= 'register_globals disabilitato?';
$LNG['reg_global_desc']			= '2moons inoltre lavorer&agrave;, se questa configurazione &egrave; installata sul tuo server. Tuttavia, &egrave; consigliato per motivi di sicurezza di disabilitare la variabile "register_globals" nella installazione del PHP, se ovviamente &egrave; possibile.';
$LNG['req_ftp_head']			= 'Inserisci le informazioni FTP';
$LNG['req_ftp_desc']			= 'Write your information from FTP so 2Moons automatically fix problems. Alternatively, you can also manually assign permissions to write.';
$LNG['req_ftp_host']			= 'Hostname';
$LNG['req_ftp_username']		= 'User name';
$LNG['req_ftp_password']		= 'Password';
$LNG['req_ftp_dir']				= 'Directory di 2Moons';
$LNG['req_ftp_send']			= 'Invia';
$LNG['req_ftp_error_data']		= 'I dati sono errati';
$LNG['req_ftp_error_dir']		= 'La cartella di installazione &egrave; errata o inesistente';

$LNG['upgrade_success']         = 'Update der Datenbank erfolgreich. Datenbank ist jetzt auf dem Stand von Revision %s.';
$LNG['upgrade_nothingtodo']     = 'Keine Aktion erforderlich. Datenbank ist bereits auf dem neusten Stand von Revision %s.';
$LNG['upgrade_back']            = 'Indietro';
$LNG['upgrade_intro_welcome']   = 'Willkommen beim Datenbank-Upgrader!';
$LNG['upgrade_available']       = 'Es sind Updates für deine Datenbank verfügbar! Die Datenbank ist auf dem Stand von Revision %s und kann durch ein Update auf Revision %s gebracht werden.<br><br>Bitte wähle aus dem folgendem Menü das erste zu installierende SQL-Update:';
$LNG['upgrade_notavailable']    = 'Die verwendete Revision %s ist die Aktuellste für deine Datenbank.';
$LNG['upgrade_required_rev']    = 'Der Updater kann nur ab Revision r2579 (2Moons v1.7) oder höher updaten.';

$LNG['step1_head']				= 'Connessione al database';
$LNG['step1_desc']				= 'Ora devi inserire i dati con i quali 2moons si connetter&agrave; al database per ricevere i dati';
$LNG['step1_mysql_server']		= 'Database server';
$LNG['step1_mysql_port']		= 'Database porta';
$LNG['step1_mysql_dbuser']		= 'Database user';
$LNG['step1_mysql_dbpass']		= 'Database Password';
$LNG['step1_mysql_dbname']		= 'Database nome';
$LNG['step1_mysql_prefix']		= 'Prefisso:';

$LNG['step2_prefix_invalid']	= 'Il preisso non &egrave; giusto (deve terminare con _)';
$LNG['step2_db_no_dbname']		= 'Non hai inserito un nome per il database';
$LNG['step2_db_too_long']		= 'The table prefix is too long. Must contain at most 36 characters';
$LNG['step2_db_con_fail']		= 'There is an error in the link to database. The details will be displayed below';
$LNG['step2_conf_op_fail']		= "config.php non pu&ograve; essere scritto!";
$LNG['step2_conf_create']		= 'config.php creato!';
$LNG['step2_config_exists']		= 'config.php esiste gi&agrave;!';
$LNG['step2_db_done']			= 'La connessione con il database &egrave; stata instaurata con successo!';

$LNG['step3_head']				= 'Creazione delle tabelle';
$LNG['step3_desc']				= "Le tabelle necessarie per il database 2Moons sono state gi&egrave; create e compilate con i valori predefiniti. Per passare alla fase successiva, concludi l'installazione di 2Moons.";
$LNG['step3_db_error']			= 'Tabelle non create:';

$LNG['step4_head']				= 'Account di amministratore';
$LNG['step4_desc']				= 'Ora il sistema crer&agrave; il tuo account con il quale amministrerai il gioco.';
$LNG['step4_admin_name']		= 'Username:';
$LNG['step4_admin_name_desc']	= 'Inserisci un username valido';
$LNG['step4_admin_pass']		= 'Password:';
$LNG['step4_admin_pass_desc']	= 'Inserisci una password valida';
$LNG['step4_admin_mail']		= 'E-mail:';

$LNG['step6_head']				= 'Installazione conclusa!';
$LNG['step6_desc']				= 'Hai installato correttamente 2moons';
$LNG['step6_info_head']			= 'Inizia ora ad usare 2Moons!';
$LNG['step6_info_additional']	= 'Se cliccherai qui sarai portato alla pagina di amministrazione del gioco';

$LNG['sql_close_reason']		= 'Il gioco &egrave; chiuso';
$LNG['sql_welcome']				= 'Benvenuto su 2Moons v';
