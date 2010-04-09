<?php

//general
$lang['index']				= 'Index';
$lang['register']			= 'Register';
$lang['forum']				= 'Forum';
$lang['send']				= 'Submit';
$lang['menu_index']			= 'Home Page'; 	 
$lang['menu_news']			= 'News';	 
$lang['menu_rules']			= 'Rules'; 
$lang['menu_agb']			= 'T&C'; 
$lang['menu_pranger']		= 'Banned';
$lang['menu_top100']		= 'Hall of Fame';	 
$lang['menu_disclamer']		= 'Contact';	 
	 
/* ------------------------------------------------------------------------------------------ */

//index.php
//case lostpassword
$lang['mail_not_exist'] 		= 'The e-mail address does not exist!';
$lang['mail_title']				= 'New Password';
$lang['mail_text']				= 'Your new password is: ';
$lang['mail_sended']			= 'Your password has been sent successfully!';
$lang['mail_sended_fail']		= 'E-mail could not be sent.!';
$lang['server_infos']			= array(
	"A space strategy game in real time.",
	"Play along with hundreds of Users.",
	"No downloading, it will require only a standard browser.",
	"Free registration",
);

//case default
$lang['login_error']			= 'Wrong username / password! <br><a href="index.php">Back</a>';
$lang['screenshots']			= 'Screenshots';
$lang['universe']				= 'Universe';
$lang['chose_a_uni']			= 'Choose a universe';

/* ------------------------------------------------------------------------------------------ */

//lostpassword.tpl
$lang['lost_pass_title']		= 'Recover password';
$lang['retrieve_pass']			= 'Restore';
$lang['email']					= 'E-mail Address';

//index_body.tpl
$lang['user']					= 'User';
$lang['pass']					= 'Password';
$lang['remember_pass']			= 'Auto-Login';
$lang['lostpassword']			= 'Forgot Password?';
$lang['welcome_to']				= 'Welcome to';
$lang['server_description']		= ' is a space strategy game with hundreds of players simultaneously try to be the best. All you need to play is a standard web browser (FireFox is recommended).';
$lang['server_register']		= 'Please register now!';
$lang['server_message']			= 'Sign up now and experience a new and exciting in the world of';
$lang['login']					= 'Login';
$lang['disclamer']				= 'Contact';
$lang['login_info']				= 'By logging in I accept the <a onclick="ajax(\'?page=rules&amp;\'+\'getajax=1\');" style="cursor:pointer;">Rules</a> and the <a onclick="ajax(\'?page=agb&amp;\'+\'getajax=1\');" style="cursor:pointer;">T&C</a>';

/* ------------------------------------------------------------------------------------------ */

//reg.php - Registrierung
$lang['register_closed']			= 'Registration is closed!';
$lang['register_at']				= 'Registered at ';
$lang['reg_mail_message_pass']		= 'One more step to activate your username';
$lang['reg_mail_reg_done']			= 'Welcome to %s!';
$lang['invalid_mail_adress']		= 'Invalid e-mail address!<br>';
$lang['empty_user_field']			= 'Please fill in all fields!<br>';
$lang['password_lenght_error']		= 'The password must be at least 4 characters long!<br>';
$lang['user_field_no_alphanumeric']	= 'Please enter the username only alphanumeric characters!<br>';
$lang['user_field_no_space']		= 'Please do not enter the user name blank!<br>';
$lang['terms_and_conditions']		= 'You must accept <a href="index.php?page=agb">T&C</a> and <a href="index.php?page=rules>Rules</a> please!<br>';
$lang['user_already_exists']		= 'The username is already taken!<br>';
$lang['mail_already_exists']		= 'The e-mail address is already in use!<br>';
$lang['wrong_captcha']				= 'Security Code is incorrect!<br>';
$lang['different_passwords']		= 'You have entered 2 different passwords!<br>';
$lang['different_mails']			= 'You have entered 2 different email addresses!<br>';
$lang['welcome_message_from']		= 'Administrator';
$lang['welcome_message_sender']		= 'Administrator';
$lang['welcome_message_subject']	= 'Welcome';
$lang['welcome_message_content']	= 'Welcome to %s!<br>First build a solar power,because energy is needed for the subsequent production of raw materials. To build it, left click in the menu on "building". Then build the 4th Building from the top. There you have energy, you can begin to build mines. Go back to the menu on the building and build a metal mine, then again a crystal mine. In order to be able to build ships you need to have first built a shipyard. What is needed for that you find in the left menu technology. The team wishes you much fun exploring the universe!';
$lang['newpass_smtp_email_error']	= '<br><br>An error occurred. Your password is: ';
$lang['reg_completed']				= 'Thank you for your subscription! You will receive an email with an activation link.';

//registry_form.tpl
$lang['server_message_reg']			= 'Sign up now and be a part of';
$lang['register_at_reg']			= 'Registered at';
$lang['uni_reg']					= 'Universe';
$lang['user_reg']					= 'User';
$lang['pass_reg']					= 'Password';
$lang['pass2_reg']					= 'Confirm Password';
$lang['email_reg']					= 'E-mail Address';
$lang['email2_reg']					= 'Confirm E-mail Address';
$lang['register_now']				= 'Register!';
$lang['captcha_reg']				= 'Security question';
$lang['accept_terms_and_conditions']= 'I Accept <a onclick="ajax(\'?page=rules&amp;\'+\'getajax=1\');" style="cursor:pointer;">Rules</a> and <a onclick="ajax(\'?page=agb&amp;\'+\'getajax=1\');" style="cursor:pointer;">T&C</a>';
$lang['captcha_reload']				= 'Reloading';
$lang['captcha_help']				= 'Help';
$lang['captcha_get_image']			= 'Load Bild-CAPTCHA';
$lang['captcha_reload']				= 'New CAPTCHA';
$lang['captcha_get_audio']			= 'Load Sound-CAPTCHA';

//registry_closed.tpl
$lang['info']						= 'Information';
$lang['reg_closed']					= 'Registration is closed';

//Rules
$lang['rules_overview']				= "Rules";
$lang['rules']						= array(
	"Accounts"					=> "Each player is allowed to control a single account. Each account is entitled to be played by a single player at a time, account sitting being the only exception.
Account sitting entitles a given player to have his account watched over under the following regulations:

- Am admin must be informed before the sitting takes place, by opening a ticket.
- No Fleet movements are allowed while the account is being sat unless an attack that may raid or crash the account is incoming, in which case you may save your fleet(s) by deploying or transporting to a planet or to a moon owned by the account being sat. You may not ninja an incoming attack in cases where you would need to move a fleet for it.
- An account may only be sat for a maximum period of 48 continuous hours (admin permission needs to be obtained in cases where a time extension is needed).
The sitter may, on the account being sat and while the sitting period lasts:

- Spend Resources on buildings or researches.
- Fleetsave any ship that imminently endangered by an incoming attacking fleet, only with a deployment or transport mission to one of the accounts own planets.
- Place an account into vacation mode.

The sitter may not:

- Transport resources, neither between planets/moons of the account being sat, nor to any other planet/moon.
- Spend Resources on defensive structures or ships.
- Sit an account if he sat another one within the previous 7 days.
- Sit an account that was sat within the previous 7 days.
- Remove an account from vacation mode.",


	"Pushing"					=> "It is not allowed for any account to obtain unfair profit out of a lower ranked account in a matter of resources.
This includes but is not limited to:

- Resources sent from a lower ranked account to a higher ranked one with nothing tangible in return.
- A player crashing his fleet into a higher ranked one for the higher ranked one to keep the Debris Field, and thus profiting from it.
- Loans that are not returned within 48 hours.
- Trades in which the higher ranked player does not return the resources within 48 hours.
- Players answering to a higher ranked player extortion by paying resources.
- Trades that mean an unfair profit to the higher ranked player by falling outside the following range of ratios:

3:2:1 Where each unit of deuterium is worth 2 units of crystal or 3 units of metal.

2:1:1 Where each unit of deuterium is worth 1 unit of crystal or 2 units of metal.
",

	"Bashing"					=> "It is not allowed to attack any given planet or moon owned by a player over 6 times in a single 24 hours period.

Bashing is only allowed when your Alliance is at war with another Alliance. The war must be announced in the forum and both leaders must agree to the terms.",

	
	"Bugusing"					=> "Using a bug for anyones profit intentionally or not reporting a bug intentionally is strictly forbidden.",


	"Real life threats"	=> "Implying that you are going to locate and harm another player, is forbidden.",

	"Spam"			=> "Any situation intended to saturate a players interface through any method is forbidden. This includes but is not limited to:

- Personal Messages spam
- Probes spam
- Overview spam",



);

$lang['rules_info1']				= "";
$lang['rules_info2']				= "To complement this, the <a onclick=\"ajax('?page=agb&getajax=1');\" style=\"cursor:pointer;\">T&C</a> are considered and followed!</font>";


//AGB

$lang['agb_overview']				= "Terms and Conditions";
$lang['agb']						= array(
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

//NEWS

$lang['news_overview']			= "News";
$lang['news_from']				= "On %s by %s";
$lang['news_does_not_exist']	= "No news available!";

//Impressum

$lang['disclamer']				= "Disclaimer";
$lang['disclamer_name']			= "Name";
$lang['disclamer_adress']		= "Address";
$lang['disclamer_tel']			= "Phone:";
$lang['disclamer_email']		= "E-mail Address";

// Translated into English by Languar . All rights reversed (C) 2010

?>