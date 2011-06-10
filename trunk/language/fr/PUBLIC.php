<?php

//general
$LNG['index']				= 'Accueil';
$LNG['register']			= 'S\'enregistrer';
$LNG['forum']				= 'Forum';
$LNG['send']				= 'Soumettre';
$LNG['menu_index']			= 'Page d\'Accueil'; 	 
$LNG['menu_news']			= 'News';	 
$LNG['menu_rules']			= 'R&egrave;gles'; 
$LNG['menu_agb']			= 'Termes et Conditions'; 
$LNG['menu_pranger']		= 'Bannis';
$LNG['menu_top100']			= 'Hall of Fame';	 
$LNG['menu_disclamer']		= 'Contacter un administrateur';	  
$LNG['uni_closed']			= '(offline)';
	 
/* ------------------------------------------------------------------------------------------ */

$LNG['music_off']			= 'Musique: OFF';
$LNG['music_on']			= 'Musique: ON';


//index.php
//case lostpassword
$LNG['mail_not_exist'] 			= 'L\'adresse e-mail n\'existe pas!';
$LNG['mail_title']				= 'Nouveau mot de passe';
$LNG['mail_text']				= 'Votre nouveau mot de passe est:';
$LNG['mail_sended']				= 'Votre mot de passe a &eacute;t&eacute; envoy&eacute; avec succ&egrave;s!';
$LNG['mail_sended_fail']		= 'L\'e-mail n\'a pas pu être envoy&eacute;!';
$LNG['server_infos']			= array(
	"Un jeu de strat&eacute;gie spatiale en temps r&eacute;el.",
    "Jouer avec des centaines d'utilisateurs.",
    "Pas de t&eacute;l&eacute;chargement, il faudra UNIQUEMENT d'un navigateur internet standard.",
    "Inscription gratuite",
);

//case default
$LNG['login_error_1']			= 'Nom d\'utilisateur / mot de passe incorrect !';
$LNG['login_error_2']			= 'Quelqu\'un s\'est connect&eacute; depuis un autre PC dans votre compte!';
$LNG['login_error_3']			= 'Votre session a expir�!';
$LNG['screenshots']				= 'Captures d\'&eacute;cran';
$LNG['universe']				= 'Univers';
$LNG['chose_a_uni']				= 'Choisissez un univers';
$LNG['universe']				= 'Univers';
$LNG['chose_a_uni']				= 'Choisissez un univers';

/* ------------------------------------------------------------------------------------------ */

//lostpassword.tpl
$LNG['lost_pass_title']			= 'R&eacute;cup&eacute;rer mot de passe';
$LNG['retrieve_pass']			= 'Restaurer';
$LNG['email']					= 'Adresse e-mail';

//index_body.tpl
$LNG['user']					= 'Pseudo';
$LNG['pass']					= 'Mot de passe';
$LNG['remember_pass']			= 'Connection automatique';
$LNG['lostpassword']			= 'Mot de passe oubli&eacute;?';
$LNG['welcome_to']				= 'Bienvenue &agrave;';
$LNG['server_description']		= 'DESCRIPTION';
$LNG['server_register']			= 'S\'il vous pla&icirc;t inscrivez-vous maintenant!';
$LNG['server_message']			= 'Inscrivez-vous et une nouvelle exp&eacute;rience passionnante vous attend dans le monde du';
$LNG['login']					= 'Login';
$LNG['disclamer']				= 'Contacter un administrateur';
$LNG['login_info']				= 'En me connectant j\'accepte les <a onclick="ajax(\'?page=rules&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">Règles</a> et le <a onclick="ajax(\'?page=agb&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">Termes et Conditions</a>';

/* ------------------------------------------------------------------------------------------ */

//reg.php - Registrierung
$LNG['register_closed']				= 'Les inscriptions sont closes!';
$LNG['register_at']					= 'Inscrit &agrave; ';
$LNG['reg_mail_message_pass']		= 'Un pas de plus pour activer votre nom d\'utilisateur';
$LNG['reg_mail_reg_done']			= 'Bienvenue &agrave; %s!';
$LNG['invalid_mail_adress']			= 'Adresse e-mail invalide!<br>';
$LNG['empty_user_field']			= 'S\'il vous pla&icirc;t remplir tous les champs!<br>';
$LNG['password_lenght_error']		= 'Le mot de passe doit être au moins 4 caract&egrave;res de long!<br>';
$LNG['user_field_no_alphanumeric']	= 'S\'il vous pla&icirc;t entrez votre pseudo avec des caract&egrave;res alphanum&eacute;riques UNIQUEMENT!<br>';
$LNG['user_field_no_space']			= 'Ne pas laisser le champs PSEUDO vide!<br>';
$LNG['planet_field_no_alphanumeric']= 'S\'il vous pla&icirc;t entrez le nom de la plan&egrave;te avec des caract&egrave;res alphanum&eacute;riques UNIQUEMENT!<br>';
$LNG['planet_field_no_space']		= 'Ne pas laisser le champs NOM PLANETE vide!<br>';
$LNG['terms_and_conditions']		= 'Vous devez accepter <a href="index.php?page=agb">Termes et Conditions</a> et <a href="index.php?page=rules>Rules</a> s\il vous pla&icirc;t!<br>';
$LNG['user_already_exists']			= 'Le nom d\'utilisateur est d&eacute;j&agrave; pris!<br>';
$LNG['mail_already_exists']			= 'L\'adresse e-mail est d&eacute;j&agrave; utilis&eacute;e!<br>';
$LNG['wrong_captcha']				= 'Code de s&eacute;curit&eacute; est incorrect!<br>';
$LNG['different_passwords']			= 'Vous avez indiqu&eacute; 2 mots de passe diff&eacute;rents!<br>';
$LNG['different_mails']				= 'Vous avez indiqu&eacute; 2 adresses e-mail diff&eacute;rentes!<br>';
$LNG['welcome_message_from']		= 'Administrateur';
$LNG['welcome_message_sender']		= 'Administrateur';
$LNG['welcome_message_subject']		= 'Bienvenue';
$LNG['welcome_message_content']		= 'Bienvenue &agrave; %s!<br>Premi&egrave;re construire une &eacute;nergie solaire, parce que l\'&eacute;nergie est n&eacute;cessaire pour la production ult&eacute;rieure de mati&egrave;res premi&egrave;res. Pour la construire, faites un clic gauche dans le menu «bâtiment». Puis la construction du bâtiment 4e &agrave; partir de la partie sup&eacute;rieure. L&agrave;, vous avez l\'&eacute;nergie, vous pouvez commencer &agrave; construire des mines. Retour au menu sur le bâtiment et construire une mine de m&eacute;taux, puis &agrave; nouveau une mine de cristal. Afin d\'être en mesure de construire des navires dont vous avez besoin d\'avoir d\'abord construit un chantier naval. Ce qui est n&eacute;cessaire pour que vous trouvez dans la technologie menu de gauche. L\'&eacute;quipe vous souhaite beaucoup de plaisir &agrave; explorer l\'univers!';
$LNG['newpass_smtp_email_error']	= '<br><br>Une erreur s\'est produite. Votre mot de passe est: ';
$LNG['reg_completed']				= 'Toute l\'&eacute;quipe vous remercie de votre inscription! Vous recevrez un email avec un lien d\'activation.';
$LNG['planet_already_exists']		= 'La position de la plan&egrave;te est d&eacute;j&agrave; occup&eacute;e! <br>';

//registry_form.tpl
$LNG['server_message_reg']			= 'Inscrivez-vous d&egrave;s maintenant et faire partie de';
$LNG['register_at_reg']				= 'Inscrit &agrave;';
$LNG['uni_reg']						= 'Univers';
$LNG['user_reg']					= 'Pseudo';
$LNG['pass_reg']					= 'Mot de passe';
$LNG['pass2_reg']					= 'Confirmation mot de passe';
$LNG['email_reg']					= 'Adresse e-mail';
$LNG['email2_reg']					= 'Confirmation adresse e-mail';
$LNG['planet_reg']					= 'Nom plan&egrave;te m&egrave;re';
$LNG['lang_reg']					= 'Langue';
$LNG['register_now']				= 'S\'inscrire!';
$LNG['captcha_reg']					= 'Question de s&eacute;curit&eacute;';
$LNG['accept_terms_and_conditions']	= 'J\'accepte les <a onclick="ajax(\'?page=rules&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">R&egrave;gles</a> et <a onclick="ajax(\'?page=agb&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">Termes et Conditions</a>';
$LNG['captcha_reload']				= 'Rechargement';
$LNG['captcha_help']				= 'Aide';
$LNG['captcha_get_image']			= 'Charge Bild-CAPTCHA';
$LNG['captcha_reload']				= 'Nouveau CAPTCHA';
$LNG['captcha_get_audio']			= 'Chargement Son-CAPTCHA';
$LNG['user_active']                	= 'Utilisateur %s a &eacute;t&eacute; activ&eacute;!';

//registry_closed.tpl
$LNG['info']						= 'Information';
$LNG['reg_closed']					= 'Les inscriptions sont closes';

//Rules
$LNG['rules_overview']				= "R&egrave;gles";
$LNG['rules']						= array(
	"Comptes"					=> "Chaque joueur est autorisé à contrôler un seul compte. Chaque compte est le droit d'être joué par un seul joueur à un moment, assis en compte étant la seule exception.
Séance de compte donne droit à un joueur donné à son compte en vertu de veille sur les règlements suivants:

- Suis-admin doit être informé avant la séance prend place, en ouvrant un ticket.
- Pas de mouvements de la flotte sont autorisés que le compte est être assis à moins d'une attaque qui peut raid ou un crash du compte est arrivée, dans ce cas, vous pouvez enregistrer votre parc (s) par le déploiement ou le transport d'une planète ou une lune appartenant à la compte sam. Vous ne pouvez pas ninja une attaque entrante dans le cas où vous auriez besoin de déplacer une flotte pour elle.
- Un compte ne peut être gardé pendant une période maximale de 48 heures en continu (autorisation admin doit être obtenu dans les cas où une prorogation de délai est nécessaire).
Le sitter peut, sur le compte satellite et alors que la période de séance dure:

- consacrer des ressources à des bâtiments ou des recherches.
- Fleetsave tout navire qui imminente en voie de disparition par une flotte d'attaque entrante, seulement avec une mission de déploiement ou du transport à l'un des comptes propres planètes.
- Placez un compte en mode vacances.

Le sitter peut pas:

- les ressources de transport, ni entre les planètes / lunes du compte étant assis, ni à aucune autre planète / lune.
- consacrer des ressources à des structures défensives ou de navires.
- Asseyez-vous un compte si il était assis un autre au cours des 7 derniers jours.
- Asseyez-vous un compte qui était assis dans les 7 derniers jours.
- Supprimer un compte en mode vacances.",


	"Pushing"					=> "N'est pas autorisé pour un compte pour obtenir des profits injustes d'un faible compte classé dans une question de ressources.
Cela inclut, mais n'est pas limité à:

- Ressources envoyé à partir d'un faible compte classé à un rang supérieur avec une rien de tangible en retour.
- Un joueur s'écraser sa flotte dans un rang supérieur un pour les mieux classés de un à garder le champ de débris, et donc en tirer profit.
- Les prêts qui ne sont pas retournés dans les 48 heures.
- Métiers dans lequel le joueur le mieux classé supérieur ne retourne pas les ressources dans les 48 heures.
- Les joueurs répondant à une extorsion de fonds joueur classé supérieur en versant des ressources.
- Métiers qui signifie un profit injuste pour les plus joueurs classés en tombant en dehors de la gamme suivante de ratios:

03:02:01 Si chaque unité de deutérium est une valeur de 2 unités de cristal ou 3 unités de métal.

02:01:01 Si chaque unité de deutérium est une valeur de 1 unité de cristal ou 2 unités de métal.",

	"Bashing"					=> "Il n'est pas permis d'attaquer une planète donnée ou de la lune possédée par un joueur de plus de 6 fois en une seule période de 24 heures.

Bashing n'est autorisée que si votre Alliance est en guerre avec une autre Alliance. La guerre doit être annoncé dans le forum et les deux dirigeants doivent accepter les termes.",

	
	"Bugusing"					=> "L'utilisation d'un bug dans un but lucratif anyones intentionnellement ou non de rapporter un bug est intentionnellement strictement interdite.",


	"Les menaces"	=> "Ce qui implique que vous allez à localiser et à nuire à un autre joueur, est interdite.",

	"Spam"			=> "Toute situation visant à saturer une interface joueurs à travers toute méthode est interdite. Cela inclut, mais n'est pas limité à:

- Messages personnels spam
- Sondes spam
- Vue d'ensemble spam",

  "Guerres"                    => "Après les dirigeants des alliances sont d'accord pour la guerre, il est officiellement le. Et se poursuivra jusqu'à l'une des alliances qu'il annule. Pour annuler officiellement la guerre dont ils ont besoin pour annuler le pacte de guerre du in-game, et l'annoncer dans le fil, ils ont commencé d'abord.
Alors que la guerre est sur??, la règle de dénigrement entre les alliances impliquées ne compte pas. Signification des membres appartenant à des alliances dans ladite guerre ne peut être attaquer une quantité infinie de fois à la peine à.
Si l'alliance abandonne et annule la guerre, la règle bashing prendra effet à nouveau, et les membres de la casser après la guerre a pris fin avec puni d'une interdiction de 1 jour, plus si le degré d'attaque est extrêmement élevé.

Si l'alliance adverse dispose d'une flotte en vol. Et la guerre est annulée avant leur arrivée. Ils ne seront pas punis pour cette attaque. Mais toute la flotte envoyée après l'annulation de guerre seront comptabilisés dans l'état bashing.


Pour de nouvelles guerres l'un des leaders nécessité de créer un nouveau thread dans la guerre la section de diplomatie.
Là, ils peuvent définir des règles spécifiques ou des termes, ils veulent la guerre. Les règles mises en place, et sont acceptés par l'alliance adverse doit être mis en jachère, et ne doit pas contredire les règles énoncées ici.",                          

);

$LNG['rules_info1']				= "Cependant, il devient dans ce <a href=\"%s\" target=\"_blank\">Forum</a> et plus la page initiale dans le jeu informé � ce sujet ...";
$LNG['rules_info2']				= "En complément, les <a onclick=\"ajax('?page=agb&getajax=1');\" style=\"cursor:pointer;\">Termes et Conditions</a> sont considérées et respectées!</font>";


//AGB

$LNG['agb_overview']				= "Termes et Conditions";
$LNG['agb']						= array(
	"Contenu Service"				=> array( 
		"La reconnaissance de ces politiques sont une condition préalable nécessaire pour pouvoir participer au jeu.
Elles s'appliquent à toutes les offres de la part des opérateurs, y compris le Forum et d'autres jeu-contenu.",
		
		"Le service est gratuit.
Ainsi, il n'ya pas de revendications à la disponibilité, la livraison, la fonctionnalité, ou de dommages.
En outre, le joueur n'a aucune prétention à restaurer, compte aurait d'être traitée défavorablement.",
	),

	"Adhésion"				=> array(
		"En vous connectant au jeu et / ou les membres du Forum va commencer dans le jeu.",
		
		"Qui commence avec la déclaration d'adhésion peut être résiliée de la part de l'élément en supprimant le compte ou par lettre d'un administrateur.
L'effacement des données pour des raisons techniques ne peut être faite immédiatement.",
		
		"Dénoncé par l'opérateur Aucun utilisateur n'a aucun droit de participer aux appels d'offres de l'opérateur.
L'opérateur se réserve le droit de supprimer les comptes.
La décision de supprimer un compte est uniquement et exclusivement à l'opérateur et l'administrateur et l'opérateur.
Toute réclamation légale pour l'adhésion est exclue.",
		
		"Tous les droits restent à l'opérateur.",
	),

	"Contenu / responsabilité"	=> "Pour le contenu des capacités de jeu différentes communications, les utilisateurs sont responsables. Pornographique, raciste, injurieux ou contraire viole la loi applicable contenu contraire en dehors de la responsabilité de l'exploitant.
Les infractions peuvent mener à l'annulation ou la révocation immédiate.",

	"Procédures interdites"			=> array(
		"L'utilisateur n'est pas autorisé �  utiliser le matériel / logiciel ou d'autres substances ou des mécanismes associés au site web, qui peut interférer avec la fonction et le jeu.
L'utilisateur ne peut pas continuer �  prendre toute action qui pourrait causer un stress excessif ou augmentation de la capacité technique.
L'utilisateur n'est pas autorisé �  manipuler le contenu généré par l'opérateur ou d'interférer de quelque fa�on avec le jeu.",
		
		"N'importe quel type de bot, script ou d'autres fonctions automatisées sont interdites.
Le jeu peut être joué que dans le navigateur. Même ses fonctions ne doit pas être utilisé pour obtenir un avantage dans le jeu.
Ainsi, pas de publicité doit être bloqué. La décision de savoir quand un logiciel est bénéfique pour les joueurs, incombe exclusivement �  l'opérateur / avec les administrateurs / exploitants.",
		
	
	),

	"Sur l'utilisation"		=> array(
		"Un joueur ne peut utiliser chaque compte un par univers, que l'on appelle \ multinationales \ ne sont pas autorisés et seront supprimés sans avertissement peut / sera bloqué.
La décision de savoir quand il ya un \ multi \ incombe exclusivement à l'opérateur / administrateurs / exploitants.",
		
		"Les détails doivent être régies par les règles.",
		
		"Lock-out peut en permanence �  la discrétion de l'exploitant ou temporaire.
De même, la fermeture peut s'étendre �  une ou toutes les aires de jeux.
La décision sera suspendue quand et combien de temps un joueur qui est seulement avec l'opérateur / avec les administrateurs / exploitants.",
	),

	"Protection des renseignements personnels"					=> array(
		"L'opérateur se réserve le droit de stocker les données des joueurs afin de surveiller le respect des règles, conditions d'utilisation et le droit applicable.
Classé tous tenus et présentés par le joueur ou son renseignements sur son compte.
Ces IPs (sont associées �  des périodes d'utilisation et de l'utilisation, l'adresse e-mail indiquée lors de votre inscription et d'autres données.
Dans le forum, il fait dans le profil sont stockées.",
		
		"Ces données seront diffusées dans certaines circonstances, �  accomplir ses devoirs statutaires aux greffiers et autres personnes autorisées.
En outre, les données peuvent (si besoin est émis) dans certaines circonstances �  des tiers.",
		
		"L'utilisateur peut s'opposer au stockage de données personnelles �  tout moment. Un appel est un droit de résiliation.",
	),

	"Droits de l'exploitant des Comptes"	=> array(
		"Tous les comptes et tous les objets virtuels restent en la possession et la propriété de l'opérateur.
Le joueur n'a pas la propriété et autres droits � n'importe quel compte ou des pièces.
Tous les droits restent avec l'opérateur.
Un transfert d'exploitation ou d'autres droits � l'utilisateur aura lieu �  tout moment.",
		
		"Vente non autorisée, utiliser, copier, distribuer, reproduire ou autrement violer les droits (par exemple en raison) de l'opérateur seront signalés aux autorités et de poursuites.
Expressément autorisée est la libre circulation, le transfert définitif du compte et les actions de leurs propres ressources dans l'univers, sauf dans la mesure permise par les règles.",
	),

	"Responsabilité"	=> "L'exploitant de chaque univers n'est pas responsable de tout dommage.
Un passif est exclu, sauf pour les dommages causés intentionnellement ou par négligence grave et tous les dommages �  la vie et la santé.
� cet égard, est expressément souligné que les jeux vidéo peuvent présenter des risques importants pour la santé.
Les dommages ne sont pas dans le sens de l'opérateur.",

	"Modifications des conditions"	=> "L'opérateur se réserve le droit de modifier ces termes �  tout moment ou d'étendre.
Un changement ou ajout sera publié au moins une semaine avant l'entrée dans le forum.",
);

//Facebook Connect

$LNG['fb_perm']                	= 'Accès interdit. %s besoins de tous les droits afin que vous puissiez vous connecter avec votre compte Facebook. \n Alternativement, vous pouvez vous connecter sans compte Facebook!';

//NEWS

$LNG['news_overview']			= "News";
$LNG['news_from']				= "Sur %s par %s";
$LNG['news_does_not_exist']		= "Pas de News disponibles!";

//Impressum

$LNG['disclamer']				= "Disclaimer";
$LNG['disclamer_name']			= "Pseudo";
$LNG['disclamer_adress']		= "Adresse";
$LNG['disclamer_tel']			= "Téléphone:";
$LNG['disclamer_email']			= "Adresse E-mail";

// Traduction fran�ais by HaloRaptor . All rights reversed (C) 2011 haloraptor33@gmail.com

?>