<?php
/*
* Tradotto in italiano da XxidroxX
* Repository: https://github.com/XxidroxX/2moons-it
* Supporto: http://aesma.it
*/

//Titolo del Sito
$LNG['siteTitleIndex']				    = 'Index';
$LNG['siteTitleRegister']			    = 'Registrati';
$LNG['siteTitleScreens']	            = 'Screenshots';
$LNG['siteTitleBanList']	            = 'Pillory';
$LNG['siteTitleBattleHall']	            = 'HOF';
$LNG['siteTitleRules']	                = 'Regole';
$LNG['siteTitleNews']	                = 'News';
$LNG['siteTitleDisclamer']	            = 'Contatti';
$LNG['siteTitleLostPassword']	        = 'Password dimenticata?';
	 
// Menu
$LNG['forum']	                        = 'Forum';
$LNG['menu_index']	                    = 'Index';
$LNG['menu_news']	                    = 'News';
$LNG['menu_rules']	                    = 'Regole';
$LNG['menu_banlist']	                = 'Pillory';
$LNG['menu_battlehall']             	= 'HOF';
$LNG['menu_disclamer']	                = 'Contatti';
$LNG['menu_register']	                = 'Registration';

// Scelta universo
$LNG['chose_a_uni']	                    = 'Scegli l\'universo';
$LNG['universe']	                    = 'Universo';
$LNG['uni_closed']	                    = ' (chiuso)';

// Bottoni
$LNG['buttonRegister']	                = 'Registrati Ora!';
$LNG['buttonScreenshot']	            = 'Screenshot';
$LNG['buttonLostPassword']	            = 'Hai dimenticato la password?';

// Start
$LNG['gameInformations']	            = array(
'Un gioco spaziale di strategia in tempo reale.',
'Gioca con altre centinaia di giocatori.',
'Nessun download richiesto, ti basta semplicemente un browser.',
'Registrazione gratuita',
);

// Login
$LNG['loginHeader']	                    = 'Login';
$LNG['loginUsername']	                = 'Username';
$LNG['loginPassword']	                = 'Password';
$LNG['loginButton']	                    = 'Login';
$LNG['loginInfo']	                    = 'Facendo il login accetto le %s.';
$LNG['loginWelcome']	                = 'Benvenuto su %s';
$LNG['loginServerDesc']              	= '%s &egrave; un gioco spaziale di strategia in tempo reale dove potrai giocare con altre centinaia di giocatori. Tutto ci&ograve; di cui hai bisogno &egrave; un semplice browser.';

// Register
$LNG['registerFacebookAccount']	        = 'Account Facebook';
$LNG['registerUsername']	            = 'Username';
$LNG['registerUsernameDesc']	        = 'L\'username deve essere composto tra i 3 e i 25 caratteri, pu&ograve; anche essere composto da simboli, numeri e spazi';
$LNG['registerPassword']	            = 'Password';
$LNG['registerPasswordDesc']	        = 'La password deve essere di almeno 8 caratteri.';
$LNG['registerPasswordReplay']	        = 'Ripeti Password';
$LNG['registerPasswordReplayDesc']	    = 'Rimetti la stessa password.';
$LNG['registerEmail']	                = 'E-Mail';
$LNG['registerEmailDesc']	            = 'Inserisci la tua email!';
$LNG['registerEmailReplay']	            = 'Ripeti E-Mail';
$LNG['registerEmailReplayDesc']	        = 'Rimetti la tua email!';
$LNG['registerLanguage']	            = 'Lingua';
$LNG['registerReferral']	            = 'Referall:';
$LNG['registerCaptcha']	                = 'Codice di sicurezza';
$LNG['registerCaptchaDesc']	            = 'Per favore inserisci i caratteri che vedi nell\'immagine di sotto. Questo serve per verificare che sei un utente reale e non un bot';
$LNG['registerCaptchaReload']	        = 'Ricarica Captcha.';
$LNG['registerRules']	                = 'Regole';
$LNG['registerRulesDesc']	            = 'Accetto le %s';

$LNG['registerBack']	                = 'Indietro';
$LNG['registerNext']	                = 'Avanti';

$LNG['registerErrorUniClosed']	        = 'La registrazione in questo universo &egrave; chiusa.!';
$LNG['registerErrorUsernameEmpty']	    = 'Devi inserire un username!';
$LNG['registerErrorUsernameChar']	    = 'Il tuo username deve contenere soltanto numeri, lettere, spazi, _, -, .!';
$LNG['registerErrorUsernameExist']	    = 'Questo username esiste gi&agrave;!';
$LNG['registerErrorPasswordLength']	    = 'La password deve avere almeno 6 caratteri!';
$LNG['registerErrorPasswordSame']	    = 'Hai inserito 2 diverse password!';
$LNG['registerErrorMailEmpty']	        = 'Devi inserire un indirizzo e-Mail!';
$LNG['registerErrorMailInvalid']	    = 'Indirizzo email non valido!';
$LNG['registerErrorMailSame']	        = 'Hai inserito 2 diverse email!';
$LNG['registerErrorMailExist']       	= 'Questa email &egrave; gi&agrave; stata presa!';
$LNG['registerErrorRules']	            = 'Devi accettare il regolamento!';
$LNG['registerErrorCaptcha']	        = 'Il codice di sicurezza &egrave; sbagliato!';

$LNG['registerMailVertifyTitle']	    = 'Attivazione della registrazione al gioco: %s';
$LNG['registerMailVertifyError']	    = 'Invio dell\'email fallito: %s';

$LNG['registerMailCompleteTitle']	    = 'Benvenuto su %s!';

$LNG['registerSendComplete']	        = 'Grazie per esserti registrato. Controlla la tua email (Attenzione con lo SPAM) con maggiori informazioni.';

$LNG['registerWelcomePMSenderName']	    = 'Amministratore';
$LNG['registerWelcomePMSubject']	    = 'Benvenuto';
$LNG['registerWelcomePMText']	        = 'Benvenuto su %s! Per prima cosa costruisci una centrale solare, poich&egrave; l\'energia &egrave; fondamentale per la produzione delle altre risorse. Per costruirla, clicca nel menu su "Costruzioni". Poi clicca su "Costruisci" affianco alla centrale solare. </br> Quando avrai abbastanza energia, puoi cominciare a costruire le miniere. Vai sempre su costruzioni e clicca su costruisci la miniera di metallo seguita poi da quella di cristallo. </br></br>Dopo ti consigliamo di ampliare la fabbrica di robot al livello 2 per poter costruire l\'hangar. Per sapere quali sono i requisiti di ciascun edifico e/o ricerca clicca su "Tecnologie" nel menu laterale.</br>Se hai altre domande puoi consultare le nostre guide o contattare lo staff aprendo un nuovo ticket. </br></br> Il team di augura tantissimo divertimento in qusto bellissimo universo!';

//Vertify

$LNG['vertifyNoUserFound']	            = 'Richiesta non valida!';
$LNG['vertifyAdminMessage']	            = 'L\'username "%s" &egrave; attivo!';


//lostpassword
$LNG['passwordInfo']	                = 'Se hai dimenticato la tua password, ti basta indicare il tuo username e la tua email perch&egrave; ti venga impostata una nuova password.';
$LNG['passwordUsername']	            = 'Username';
$LNG['passwordMail']	                = 'E-Mail';
$LNG['passwordCaptcha']	                = 'Codice di sicurezza';
$LNG['passwordSubmit']	                = 'Invia';
$LNG['passwordErrorUsernameEmpty']	    = 'Non hai specificato un username!';
$LNG['passwordErrorMailEmpty']	        = 'Devi inserire un indirizzo email!';
$LNG['passwordErrorUnknown']	        = 'Non &egrave; stato trovato nessun account con questi dati.';
$LNG['passwordErrorOnePerDay']	        = 'C\'&egrave; stata un\'altra richiesta di reset della password nelle ultime 24h. Per poter procedere con un nuovo ripristino devi aspettare 24h. ';

$LNG['passwordValidMailTitle']	        = 'Reset password nel gioco: %s';
$LNG['passwordValidMailSend']	        = 'Riceverai un email con ulteriori informazioni.';

$LNG['passwordValidInValid']	        = 'Richiesta invalida!';
$LNG['passwordChangedMailSend']	        = 'Riceverai a breve un email contenente la tua nuova password.';
$LNG['passwordChangedMailTitle']	    = 'Nuova password nel gioco: %s';

$LNG['passwordBack']	                = 'Indietro';
$LNG['passwordNext']	                = 'Avanti';

//case default
$LNG['login_error_1']	                = 'Username/password sbagliati!';
$LNG['login_error_2']	                = 'Qualcuno da un altro PC si &egrave; loggato nel tuo account!';
$LNG['login_error_3']	                = 'La tua sessione è scaduta!';
$LNG['login_error_4']	                = 'C\'&egrave; stato un errore interno nelle autorizzazioni, prova di nuovo!';

//Rules
$LNG['rulesHeader']                 	= 'Regole';

//NEWS
$LNG['news_overview']	                = 'News';
$LNG['news_from']	                    = 'Su %s da %s';
$LNG['news_does_not_exist']	            = 'Nessuna news disponibile!';

//Impressum
$LNG['disclamerLabelAddress']	        = 'Indirizzo del gioco:';
$LNG['disclamerLabelPhone']         	= 'Nr. di telefono:';
$LNG['disclamerLabelMail']	            = 'Email di Supporto:';
$LNG['disclamerLabelNotice']	        = 'Pi&ugrave; informazioni';

?>