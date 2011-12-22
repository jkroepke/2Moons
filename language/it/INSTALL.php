<?php

$LNG['back']					= 'Indietro';
$LNG['continue']			= 'Continua';
$LNG['login']					= 'Login';

$LNG['menu_intro']			= 'Introduzione';
$LNG['menu_install']		= 'Installa';
$LNG['menu_license']		= 'Licenza';

$LNG['title_install']		= 'Installatore';

$LNG['intro_lang']			= 'Lingua';
$LNG['intro_instal']		= 'Installazione';
$LNG['intro_welcome']		= 'Benvenuto in 2moons!';
$LNG['intro_text']			= 'Uno dei migliori cloni di Ogame &egrave 2moons.<br>L\'ultima versione di 2Moons &egrave stabile, flessibile e dinamica.<br><br>Il sistema di installazione ti aiuta nell\'installare 2moons e nell\'aggiornarlo all\'ultima versione. Per domande o dubbi non esitare a contattarci!.<br><br>2Moons &egrave un progetto open source sotto licenza GNU GPL v3. Per informazioni rigaurdo la licenza, cliccare sulla voce "licenza" nel menu in alto di questa pagina.<br><br>Prima dell\'installazione sar&agrave eseguito un test per verificare che tutti i requisiti di 2Moons siano soddisfatti.<br><br><br><br>2Moons, versione italiana tradotta da Malware (bozzato@live.it) per la community italiana di 2Moons http://www.2moons.freedost.com.<br>Se si notato errori nella traduzione, non esitare a segnalarceli nel forum che trovi nel nostro sito. <br>Grazie.';

$LNG['licence_head']			= 'Avvertenze';
$LNG['licence_desc']			= 'Si prega di leggere i termini di questa licenza. Utilizzate la barra di scorrimento per visualizzare tutto il documento';
$LNG['licence_accept']			= 'Ricordate che questo gioco puo essere installato solo se accettate la licenza, in ogni caso una volta installato significa che abbiate preso visione delle suddette regole.';
$LNG['licence_need_accept']		= 'Una volta accettato il contratto di licenza procedete con la vostra installazione di gioco.';

$LNG['req_head']				= 'Requisiti di sistema';
$LNG['req_desc']				= 'Prima di continuare tale installazione, 2Moons eseguira alcuni test sul tuo server e file di configurazione per garantire che sia possibile installare e utilizzare 2Moons. Si prega di leggere attentamente i risultati e non procedere oltre fino a quando tutti i test richiesti sono passati. Se si desidera utilizzare una delle funzioni elencate qui di seguito i moduli opzionali, dovrete assicurarvi che i test effettuati siano andati con un esito positivo.';
$LNG['reg_yes']				= 'Si';
$LNG['reg_no']				= 'No';
$LNG['reg_found']			= 'Trovato';
$LNG['reg_not_found']		= 'Non trovato';
$LNG['reg_writable']		= 'Scrivibile';
$LNG['reg_not_writable']	= 'Non scrivibile';
$LNG['reg_file']			= 'File';
$LNG['reg_dir']				= 'Cartella';
$LNG['reg_gd_need']			= 'GD-Lib disponibile?';
$LNG['reg_gd_desc']				= '<strong>Opzioni</strong> — Gdlib serve per i file con espansioni di immagini, quindi le immagine messe all interno del gioco.';
$LNG['reg_mysqli_active']	= 'MySQL disponibile?';
$LNG['reg_mysqli_desc']			= '<strong>Condizioni</strong> — Dovete necessariamente avere il supporto per MySQLi in PHP nel vostro hosting. Se nessun modulo del database viene visualizzato come disponibile dovresti contattare il proprio fornitore del tuo hosting o contattare la documentazione di installazione di PHP per un consiglio.';
$LNG['reg_bcmath_need']		= 'BCMath disponibile?';
$LNG['reg_iniset_need']		= 'ini_set() disponibile?';
$LNG['reg_global_need']		= 'register_globals disattivato?';
$LNG['reg_global_desc']			= '2Moons funziona anche se questa impostazione risulta attivata. Tuttavia consigliamo per ragioni di sicurezza, di disabilitare register_globals nella installazione di PHP, se questo risulta possibile.';
$LNG['reg_json_need']		= 'JSON disponibile?';
$LNG['req_php_need']		= 'PHP-Version (min. 5.2.5)';
$LNG['req_php_need_desc']		= '<strong>VCondizioni</strong> — PHP 5.2 Richiesto per 2moons.';
$LNG['req_ftp_head']			= 'Inserisci i dati ftp';
$LNG['req_ftp_desc']			= 'Inserisci i tuoi dati FTP in modo che 2Moons possa correggere automaticamente i problemi e bugs del gioco. In alternativa, potete anche assegnare manualmente i permessi di scrittura.';
$LNG['req_ftp_host']		= 'FTP Host';
$LNG['req_ftp_username']	= 'Username';
$LNG['req_ftp_password']	= 'Password';
$LNG['req_ftp_dir']			= '2Moons Path';
$LNG['req_ftp_send']		= 'Esegui';
$LNG['req_ftp_error_data']		= 'Connessione verso il vostro FTP fallita.';
$LNG['req_ftp_error_dir']		= 'Directory immessa non valida, riprova scrivendo meglio.';


$LNG['step1_head']				= 'Configura accesso al database';
$LNG['step1_desc']				= 'Il server 2Moons può essere eseguito sul server, dovete ora fornire informazioni a riguardo. Se non sai come procedere per la connessione dati al database, si prega di contattare il proprio fornitore di hosting o contattare un supporto 2Moons forum. Quando si immettono i dati, vi preghiamo di controllare con attenzione prima di continuare.';
$LNG['step1_mysql_server']	= 'MySQL-DB-Server: <br>Standard: localhost';
$LNG['step1_mysql_port']	= 'MySQL-DB-Server-Porta: <br>Standard: 3306';
$LNG['step1_mysql_dbname']	= 'Name Database: <br> Es.:(per altervista: my_nomegioco)';
$LNG['step1_mysql_dbuser']	= 'Username ftp: <br> Es.: root';
$LNG['step1_mysql_dbpass']	= 'Password ftp: <br> Es.: 12345';
$LNG['step1_mysql_prefix']	= 'Prefisso sql: <br> Es.: uni1_';

$LNG['step2_prefix_invalid']	= 'Il prefisso del database deve contenere solo numeri alfanumerici o underscore.';
$LNG['step2_db_error']			= 'Impossibile creare la seguente tavola del database:';
$LNG['step2_db_no_dbname']		= 'Nessun nome database specificato!';
$LNG['step2_db_too_long']		= 'Prefisso tabella troppo lungo, max. 36 caratteri consentiti.';
$LNG['step2_db_con_fail']		= 'Nessuna connessione al database, qui sotto trovate il motivo degli errori.';
$LNG['step2_conf_op_fail']		= 'config.php non scrivibile!';
$LNG['step2_conf_create']		= 'config.php creato con successo...';
$LNG['step2_db_done']			= 'Database connesso con successo!';

$LNG['step3_head']				= 'Crea tabella database';
$LNG['step3_desc']				= 'Perfetto, ora procedi con l installazione andando al passaggio successivo.';

$LNG['step4_head']				= 'Account admin';
$LNG['step4_desc']				= 'Ora vi resta solamente creare il vostro account di gioco, scegliete quindi la vostra username e la vostra password.';
$LNG['step4_admin_name']		= 'Username:';
$LNG['step4_admin_name_desc']	= 'Si prega di inserire un nome utente con una lunghezza da 3 a 20 caratteri.';
$LNG['step4_admin_pass']		= 'Password:';
$LNG['step4_admin_pass_desc']	= 'Si prega di inserire una password con una lunghezza da 6 a 30 caratteri.';
$LNG['step4_admin_mail']		= 'E-Mail:';

$LNG['step6_head']				= 'Congratulazioni!';
$LNG['step6_desc']				= 'Hai installato con successo 2Moons!';
$LNG['step6_info_head']			= 'Gioca a partire da ora su 2 moons!';
$LNG['step6_info_additional']	= 'Fai clic sul pulsante qui sotto per essere reindirezzato al pannello amministrativo di gioco e ricordati di eliminale la cartella "install" dal tuo ftp!</strong>';

$LNG['sql_universe']			= 'Universo';
$LNG['sql_close_reason']		= 'Gioco attualmente chiuso..';
$LNG['sql_welcome']				= 'Benvenuti su 2Moons V.';
		
?>