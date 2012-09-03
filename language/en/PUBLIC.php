<?php

// Translated into English by QwataKayean . All rights reversed (C) 2012
// 2Moons - Copyright (C) 2010-2012 Slaver


//general
$LNG['index']				= 'Index';
$LNG['register']			= 'Register';
$LNG['forum']				= 'Forum';
$LNG['send']				= 'Submit';
$LNG['menu_index']			= 'Home Page'; 	 
$LNG['menu_news']			= 'News';	 
$LNG['menu_rules']			= 'Rules'; 
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
$LNG['login_error_4']					= 'There was an error of session authorization. Try again!';
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
$LNG['login_info']				= 'By logging in I accept the <a href="index.php?page=rules">Rules</a> and the <a href="index.php?page=agb">Terms & Conditions</a>';

/* ------------------------------------------------------------------------------------------ */

//reg.php - Registrierung
$LNG['register_closed']				= 'Registration is closed!';
$LNG['register_at']					= 'Registered at ';
$LNG['reg_mail_message_pass']		= 'One more step to activate your username.';
$LNG['reg_mail_reg_done']			= 'Welcome to %s!';
$LNG['invalid_mail_adress']			= 'Invalid e-mail address!';
$LNG['empty_user_field']			= 'Please fill in all fields!';
$LNG['password_lenght_error']		= 'The password must be at least 4 characters long!';
$LNG['user_field_specialchar']     = 'Please enter the user name only with alphanumeric characters!<br>';
$LNG['planet_field_specialchar']   = 'Please enter only contain alphanumeric characters!';
$LNG['planet_field_no']	       = 'Please dont let the name of blank planet!<br>';
$LNG['terms_and_conditions']		= 'You must accept the Rules and the Terms & Conditions please!';
$LNG['user_already_exists']			= 'The username is already taken!';
$LNG['mail_already_exists']			= 'The e-mail address is already in use!';
$LNG['wrong_captcha']				= 'Security Code is incorrect!';
$LNG['different_passwords']			= 'You have entered 2 different passwords!';
$LNG['different_mails']				= 'You have entered 2 different email addresses!';
$LNG['welcome_message_from']		= 'Administrator';
$LNG['welcome_message_sender']		= 'Administrator';
$LNG['welcome_message_subject']		= 'Welcome';
$LNG['welcome_message_content']		= 'Welcome to %s!</br></br>First build a solar power plant,because energy is needed for the production of raw materials. To build one, left click in the menu on "buildings". Then build the 4th Building from the top. </br> When you have energy, you can begin to build mines. Go to buildings on the menu and build a metal mine, followed by a crystal mine. </br></br>In order to be able to build ships you need to have a shipyard. To see what is needed to unlock that building you can take a look at "Technologies" at the left menu.</br>If you more questions you can look at the beginnersguide, our forum or open a support ticket. </br></br> The team wishes you much fun exploring the universe!';
$LNG['reg_completed']				= 'Thank you for your registration! You will receive an email with an activation link.';
$LNG['planet_already_exists']		= 'The planet position is already occupied! <br>';

//registry_form.tpl
$LNG['server_message_reg']			= 'Sign up now and be a part of';
$LNG['register_at_reg']				= 'Registered at';
$LNG['uni_reg']						= 'Universe';
$LNG['user_reg']					= 'Username';
$LNG['pass_reg']					= 'Password';
$LNG['pass2_reg']					= 'Confirm Password';
$LNG['email_reg']					= 'E-mail Address';
$LNG['email2_reg']					= 'Confirm E-mail Address';
$LNG['planet_reg']					= 'Name of Mainplanet';
$LNG['ref_reg']						= 'Referred by';
$LNG['lang_reg']					= 'Language';
$LNG['register_now']				= 'Register!';
$LNG['captcha_reg']					= 'Security question';
$LNG['accept_terms_and_conditions']	= 'I accept the <a href="index.php?page=rules">Rules</a> and <a href="index.php?page=agb">Terms & Conditions</a>';
$LNG['captcha_reload']				= 'Reloading';
$LNG['captcha_help']				= 'Help';
$LNG['captcha_get_image']			= 'Load Bild-CAPTCHA';
$LNG['captcha_reload']				= 'New CAPTCHA';
$LNG['captcha_get_audio']			= 'Load Sound-CAPTCHA';
$LNG['user_active']                	= 'User %s has been activated!';

//Rules
$LNG['rules_overview']				= "Rules";

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