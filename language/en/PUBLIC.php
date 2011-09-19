<?php

//general
$LNG['index']				= 'Index';
$LNG['register']			= 'Register';
$LNG['forum']				= 'Forum';
$LNG['send']				= 'Submit';
$LNG['menu_index']			= 'Home Page'; 	 
$LNG['menu_news']			= 'News';	 
$LNG['menu_rules']			= 'Rules'; 
$LNG['menu_agb']			= 'T&C'; 
$LNG['menu_pranger']		= 'Banned';
$LNG['menu_top100']			= 'Hall of Fame';	 
$LNG['menu_disclamer']		= 'Contact';	  
$LNG['uni_closed']			= '(offline)';
	 
/* ------------------------------------------------------------------------------------------ */

//index.php
//case lostpassword
$LNG['lost_empty']			= 'You must fill in all fields!';
$LNG['lost_not_exists']		= 'A user could not be found in connection with this email address!';
$LNG['lost_mail_title']		= 'New Password';
$LNG['mail_sended']				= 'Your password has been sent successfully!';
$LNG['server_infos']			= array(
	"A space strategy game in real time.",
	"Play along with hundreds of Users.",
	"No downloading, it will require only a standard browser.",
	"Free registration",
);

//case default
$LNG['login_error_1']			= 'Wrong Username/Password!';
$LNG['login_error_2']			= 'Someone has logged in from another PC in your account!';
$LNG['login_error_3']			= 'Your session has expired!';
$LNG['screenshots']				= 'Screenshots';
$LNG['universe']				= 'Universe';
$LNG['chose_a_uni']				= 'Choose a universe';
$LNG['universe']				= 'Universe';
$LNG['chose_a_uni']				= 'Choose a universe';

/* ------------------------------------------------------------------------------------------ */

//lostpassword.tpl
$LNG['lost_pass_title']			= 'Recover password';

//index_body.tpl
$LNG['user']					= 'User';
$LNG['pass']					= 'Password';
$LNG['remember_pass']			= 'Auto-Login';
$LNG['lostpassword']			= 'Forgot Password?';
$LNG['welcome_to']				= 'Welcome to';
$LNG['server_description']		= '<strong>%s</strong> is a space strategy game with hundreds of players simultaneously trying to be the best. All you need to play is a standard web browser (FireFox is recommended).';
$LNG['server_register']			= 'Please register now!';
$LNG['server_message']			= 'Sign up now and experience a new and exciting in the world of';
$LNG['login']					= 'Login';
$LNG['disclamer']				= 'Contact';
$LNG['login_info']				= 'By logging in I accept the <a href="index.php?page=rules">Rules</a> and the <a href="index.php?page=agb">T&C</a>';

/* ------------------------------------------------------------------------------------------ */

//reg.php - Registrierung
$LNG['register_closed']				= 'Registration is closed!';
$LNG['register_at']					= 'Registered at ';
$LNG['reg_mail_message_pass']		= 'One more step to activate your username';
$LNG['reg_mail_reg_done']			= 'Welcome to %s!';
$LNG['invalid_mail_adress']			= 'Invalid e-mail address!';
$LNG['empty_user_field']			= 'Please fill in all fields!';
$LNG['password_lenght_error']		= 'The password must be at least 4 characters long!';
$LNG['user_field_no_alphanumeric']	= 'Please enter the username only from alphanumeric characters!';
$LNG['user_field_no_space']			= 'Please do not enter a blank user name!';
$LNG['planet_field_no']				= 'You must enter a planet name!';
$LNG['planet_field_no_alphanumeric']= 'Please enter the planet name only from alphanumeric characters!';
$LNG['planet_field_no_space']		= 'Please do not enter a blank planet name!';
$LNG['terms_and_conditions']		= 'You must accept the Rules and T&C please!';
$LNG['user_already_exists']			= 'The username is already taken!';
$LNG['mail_already_exists']			= 'The e-mail address is already in use!';
$LNG['wrong_captcha']				= 'Security Code is incorrect!';
$LNG['different_passwords']			= 'You have entered 2 different passwords!';
$LNG['different_mails']				= 'You have entered 2 different email addresses!';
$LNG['welcome_message_from']		= 'Administrator';
$LNG['welcome_message_sender']		= 'Administrator';
$LNG['welcome_message_subject']		= 'Welcome';
$LNG['welcome_message_content']		= 'Welcome to %s!<br>First build a solar power,because energy is needed for the subsequent production of raw materials. To build it, left click in the menu on "building". Then build the 4th Building from the top. There you have energy, you can begin to build mines. Go back to the menu on the building and build a metal mine, then again a crystal mine. In order to be able to build ships you need to have first built a shipyard. What is needed for that you find in the left menu technology. The team wishes you much fun exploring the universe!';
$LNG['newpass_smtp_email_error']	= '<br><br>An error occurred. Your password is: ';
$LNG['reg_completed']				= 'Thank you for your subscription! You will receive an email with an activation link.';
$LNG['planet_already_exists']		= 'The planet position is already occupied! <br>';

//registry_form.tpl
$LNG['server_message_reg']			= 'Sign up now and be a part of';
$LNG['register_at_reg']				= 'Registered at';
$LNG['uni_reg']						= 'Universe';
$LNG['user_reg']					= 'User';
$LNG['pass_reg']					= 'Password';
$LNG['pass2_reg']					= 'Confirm Password';
$LNG['email_reg']					= 'E-mail Address';
$LNG['email2_reg']					= 'Confirm E-mail Address';
$LNG['planet_reg']					= 'Name of Mainplanet';
$LNG['ref_reg']						= 'Referred by';
$LNG['lang_reg']					= 'Language';
$LNG['register_now']				= 'Register!';
$LNG['captcha_reg']					= 'Security question';
$LNG['accept_terms_and_conditions']	= 'I Accept <a href="index.php?page=rules">Rules</a> and <a href="index.php?page=agb">T&C</a>';
$LNG['captcha_reload']				= 'Reloading';
$LNG['captcha_help']				= 'Help';
$LNG['captcha_get_image']			= 'Load Bild-CAPTCHA';
$LNG['captcha_reload']				= 'New CAPTCHA';
$LNG['captcha_get_audio']			= 'Load Sound-CAPTCHA';
$LNG['user_active']                	= 'User %s has been activated!';

//Rules
$LNG['rules_overview']				= "Rules";
$LNG['rules']						= array(

"" => "The rules of the game have been set by the administrators and are overseen by them. Every player has the option and the duty to report violations of the rules which he or she notices. The rules should guarantee a fair and clean game."

	"Accounts"					=> "The accounts are the property of the operators of the Spaceinvasion website. ",


	"Multi-Accounts"					=> "It is prohibited to run more than one account in the same universe. Should multiple accounts use the same IP (Brother, Father, Sister, etc.) - it will need to be registered with support. Later registrations over the same IP are not possible! If multiple accounts use the same internet connection (e.g. at home, internet cafe, other networks), no further similarities must occur. (e.g. Internal shipping, Trading, or Alliance attacks).
Abusing the IP-Match function or holding more than one account in the same universe will be punished with a permanent ban. ",

	"Account transfer"					=> "The acquisition or exchange of an account must be registered with support prior to the takeover. The ticket-button is to be used and permission is to be awaited.
A transfer can be requested once in 30 days. ",

	
	"Buying/Selling Accounts and Resources"					=> "The buying and selling of accounts is not allowed and will be punished with a permanent ban and the deletion of the affected accounts.
Rule 3 remains in force. The exchange or transfer of accounts are still permitted, as long as this is done free of charge.
The buying and selling of resources (raw materials, fleets, in-game services, etc.) is prohibited and will be punished with a permanent ban and deletion of the affected accounts. ",


	"Supervising another account"	=> "Account sitting (i.e. monitoring another player´s account) is allowed only if approved by support through the ticketfunction. Sitting is only permitted to the extent that fleets may be saved and raw materials used (No Attacks may be sent during this period). The maximum sitting term is 24 hours. Sitting is also only permitted once per week. The vacation mode is intended for longer absences from the game.
Supervising without the use of the appropriate tool will be considered as Multiaccounting/Accountsharing and leads to a permanent ban of the accounts.(See rule 2)
",

	"Sharing"			=> "Account sharing, that is the common use of a single account, is not permitted. This would result in an unfair game advantage and will lead to the ultimate banning of the account.",

  "Pushing "                    => "Pushing, that is the targeted sending of raw materials without apparent quid pro quo, it is only permitted for lower-point players. A player is considered lower-point if they have a maximum of 75% of the points held by the player who wishes to send the resources. Sending resources to higher-point players is only permitted when there is an apparent return service at an appropriate ratio (See rule 4 and 8).
Making rubble available and the destruction/loss of ships/defence units on purpose is also considered pushing.

Pushing can lead to the loss of all involved accounts. .",    

	"Provide game-relevant information and services"					=> "In general it is permitted to provide/forward game-relevant information to other players. Demanding a return service is prohibited.
A claim can be raised in the following situations if a GO was contacted and informed prior to it.

    Information about a parked fleet
    (A 5% fee of the overall result can be claimed)

    Galaxy-Scanner Information
    (A 15% fee of the overall result can be claimed if the forwarded information resulted in a successful intercept)

    Recycling-Help
    (If someone makes his/her Recycler available to other users, he/she gains rights to the processed recycled goods by 20%)

    Trapping – playing the bait
    (A 30% fee of the overall result can be claimed if someone provokes an attack which leads to a successful counter-attack/intercept)

    Joint venture
    (Applicable for intercepts on a fleet which is on a station flight only. If 2 players are intercepting a fleet (on target and start planet) and the return-flight can be successfully intercepted the overall result can be shared (50% each).)


The result of such an action has to be investigated and confirmed by a GO. The GO will also give permission to deliver the appropriate amount of resources. Variances have to be in accordance with the Pushing and/or Trading rule (rule 3 and 4). Arrangements like this between the players must be provable via the ingame message-system. ",

	"Trading"					=> "Resource trading is allowed. For flexible trading rates, however, the current trading rates should be monitored. A trade must be completed within 24h. The general rules of thumb for trading rates are: 3:2:1 (Metal, Crystal, Deuterium). Trades which go through the general trading rates, may differentiate by 20% of the actual rate. If in doubt please consult your Game Operator. ",

	"Flights"					=> "Outbound flights are not to be longer than 24 hours.
Exceptions:

    Flights to own planets/asteroids
    Colonization
    Escapeflights
    Attacks where the distance plays a role",

	"Accounts"					=> "The accounts are the property of the operators of the Spaceinvasion website. ",	

);

$LNG['rules_info1']				= "However, it becomes in this <a href=\"%s\" target=\"_blank\">Forum</a> and over the initial page in the Game informed about it...";
$LNG['rules_info2']				= "To complement this, the <a onclick=\"ajax('?page=agb&getajax=1');\" style=\"cursor:pointer;\">T&C</a> are considered and followed!</font>";


//AGB

$LNG['agb_overview']				= "Terms and Conditions";
$LNG['agb']						= array(
	"Service content"				=> array( 
		"The recognition of the Policies are necessary prerequisite to be able to participate in the game.
They apply to all offers on the part of operators, including the Forum and other Game-content.",
		
		"The service is free.
Thus there are no claims to the availability, delivery, functionality, or damages.
Furthermore, the player has no claims to restore, account should have been adversely treated.",
	),

	"Membership"				=> array(
		"By logging on in the game and / or the Forum membership will start in the game.",
		
		"Which begins with the declaration Membership may be terminated on the part of the member by deleting the account or by letter of an administrator.
The erasure of data for technical reasons can not be made immediately.",
		
		"Terminated by the operator No user has any right to participate in tenders of the operator.
The operator reserves the right to delete accounts.
The decision to delete an account is solely and exclusively to the operator and administrator and operator.
Any legal claim to a membership is excluded.",
		
		"All rights remain with the operator.",
	),

	"Contents / Responsibility"	=> "For the content of the various game-communications capabilities, users are responsible. Pornographic, racist, abusive or otherwise violates applicable law contrary content outside the responsibility of the operator.
Violations can lead to immediate cancellation or revocation.",

	"Prohibited procedures"			=> array(
		"The user is not authorized to use hardware / software or other substances or mechanisms associated with the web site, which can interfere with the function and the game.
The user may not continue to take any action that may cause undue stress or increased technical capacity.
The user is not allowed to manipulate content generated by the operator or interfere in any way with the game.",
		
		"Any type of bot, script or other automated features are prohibited.
The game can be played only in the browser. Even its functions should not be used to gain an advantage in the game.
Thus, no advertising shall be blocked. The decision of when a software is beneficial for the players, lies solely with the operator / with the administrators / operators.",
		
	
	),

	"Restrictions on Use"		=> array(
		"A player may only use each one account per universe, so-called \ Multinationals \ are not allowed and will be deleted without warning can / will be locked.
The decision of when there is a \ multi \ lies solely with the operator / administrators / operators.",
		
		"Particulars shall be governed by the rules.",
		
		"Lockouts can permanently at the discretion of the operator or temporary.
Similarly, closures may extend to one or all play areas.
The decision will be suspended when and how long a player who is only with the operator / with the administrators / operators.",
	),

	"Privacy"					=> array(
		"The operator reserves the right to store data of the players in order to monitor compliance with the rules, terms of use and applicable law.
Filed all required and submitted by the player or his / her account information.
These (IPs are associated with periods of use and usage, the email address given during registration and other data.
In the forum, made there in the profile are stored.",
		
		"This data will be released under certain circumstances to carry out statutory duties to clerks and other authorized persons.
Furthermore, data can (if need be issued) under certain circumstances to third parties.",
		
		"The user can object to the storage of personal data at any time. An appeal is a termination right.",
	),

	"Rights of the operator of the Accounts"	=> array(
		"All accounts and all the virtual objects remain in the possession and ownership of the operator.
The player does not obtain ownership and other rights to any account or parts.
All rights remain with the operator.
A transfer of exploitation or other rights to the user will take place at any time.",
		
		"Unauthorized sale, use, copy, distribute, reproduce or otherwise violate the rights (eg on account) of the operator will be reported to authorities and prosecuted.
Expressly permitted is the free, permanent transfer of the account and the actions of their own resources in the universe, unless and except as permitted by the rules.",
	),

	"Liability"	=> "The operator of each universe is not liable for any damages.
A liability is excluded except for damage caused by intent or gross negligence and all damage to life and health.
In this regard, is expressly pointed out that computer games can pose significant health risks.
Damages are not within the meaning of the operator.",

	"Changes to Terms"	=> "The operator reserves the right to modify these terms at any time or extend.
A change or addition will be published at least one week before the entry in Forum.",
);

//Facebook Connect

$LNG['fb_perm']                	= 'Access prohibited. %s needs all the rights so you can login with your Facebook account. \n Alternatively, you can login without a Facebook account!';

//NEWS

$LNG['news_overview']			= "News";
$LNG['news_from']				= "On %s by %s";
$LNG['news_does_not_exist']		= "No news available!";

//Impressum

$LNG['disclamer']				= "Disclaimer";
$LNG['disclamer_name']			= "Name";
$LNG['disclamer_adress']		= "Address";
$LNG['disclamer_tel']			= "Phone:";
$LNG['disclamer_email']			= "E-mail Address";

// Translated into English by Languar . All rights reversed (C) 2010

?>