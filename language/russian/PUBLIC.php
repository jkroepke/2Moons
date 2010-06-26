<?php

//general
$LNG['index']				= 'Главная';
$LNG['register']			= 'Регистрация';
$LNG['forum']				= 'форум';
$LNG['send']				= 'подтвердить';
$LNG['menu_index']			= 'Стартовая страница'; 	 
$LNG['menu_news']			= 'Новости';	 
$LNG['menu_rules']			= 'Правила'; 
$LNG['menu_agb']			= 'T&C'; 
$LNG['menu_pranger']		= 'Список забаненных';
$LNG['menu_top100']		= 'Зал славы';	 
$LNG['menu_disclamer']		= 'Контакты';	 
	 
/* ------------------------------------------------------------------------------------------ */

//index.php
//case lostpassword
$LNG['mail_not_exist'] 		= 'Почтовый адрес не существует!';
$LNG['mail_title']				= 'Новый пароль';
$LNG['mail_text']				= 'Ваш новый пароль: ';
$LNG['mail_sended']			= 'Пароль успешно выслан!';
$LNG['mail_sended_fail']		= 'E-mail не может быть послан!';
$LNG['server_infos']			= array(
	"Космическая-стратегичская игра в реальном времени.",
	"Стань одним из тысяч игроков.",
	"Мало трафика, для игры Вам потребуется только стандартный браузер.",
	"Свободная регистрация",
);

//case default
$LNG['login_error']			= 'Неправильное имя / пароль! <br><a href="index.php">Вернуться</a>';
$LNG['screenshots']			= 'Скриншоты';
$LNG['universe']				= 'Вселенная';
$LNG['chose_a_uni']			= 'Выберите вселенную';

/* ------------------------------------------------------------------------------------------ */

//lostpassword.tpl
$LNG['lost_pass_title']		= 'Восстановить пароль';
$LNG['retrieve_pass']			= 'Восстановить';
$LNG['email']					= 'E-mail адрес';

//index_body.tpl
$LNG['user']					= 'Пользователь';
$LNG['pass']					= 'Пароль';
$LNG['remember_pass']			= 'Авто-вход';
$LNG['lostpassword']			= 'Забыли пароль?';
$LNG['welcome_to']				= 'Добро пожаловать в';
$LNG['server_description']		= '<strong>%s</strong> стратегический космический симулятор</strong> с <strong>миллионом игроков</strong> во всем мире <strong>,которые </strong> выступают друг против друга.<br> Для игры Вам нужен всего лишь обычный браузер (рекомендуется <strong><font color=red>FireFox</font></strong>).';
$LNG['server_register']		= 'Зарегистрироваться!';
$LNG['server_message']			= 'Присоединяйся сейчас и стань частью огромного мира';
$LNG['login']					= 'Войти';
$LNG['disclamer']				= 'Контакты';
$LNG['login_info']				= 'Входя я принимаю <a onclick="ajax(\'?page=rules&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">Правила</a> и <a onclick="ajax(\'?page=agb&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">T&C</a>';

/* ------------------------------------------------------------------------------------------ */

//reg.php - Registrierung
$LNG['register_closed']			= 'Регистрация закрыта!';
$LNG['register_at']				= 'Зарегистрирован как ';
$LNG['reg_mail_message_pass']		= 'Еще один шаг, чтобы активировать ваше имя пользователя';
$LNG['reg_mail_reg_done']			= 'Добро пожаловать на %s!';
$LNG['invalid_mail_adress']		= 'Неправильный e-mail адрес!<br>';
$LNG['empty_user_field']			= 'Пожалуйста заполните все поля!<br>';
$LNG['password_lenght_error']		= 'Пароль должен содержать не меньше 4 символов!<br>';
$LNG['user_field_no_alphanumeric']	= 'Имя может содержать только буквы и цифры!<br>';
$LNG['user_field_no_space']		= 'Пожалуйста, не оставляйте пустым имя пользователя!<br>';
$LNG['planet_field_no_alphanumeric']	= 'Имя планеты может содержать только буквы и цифры!<br>';
$LNG['planet_field_no_space']		= 'Пожалуйста, не оставляйте пустым имя планеты!<br>';
$LNG['terms_and_conditions']		= 'Вы должны принять <a href="index.php?page=agb">T&C</a> и <a href="index.php?page=rules>правила</a>!<br>';
$LNG['user_already_exists']		= 'Имя пользователя уже используется!<br>';
$LNG['mail_already_exists']		= 'Такой E-mail уже зарегистрирован!<br>';
$LNG['wrong_captcha']				= 'Секретный код неверный!<br>';
$LNG['different_passwords']		= 'Пароль не совпадает!<br>';
$LNG['different_mails']			= 'Email адреса не совпадают!<br>';
$LNG['welcome_message_from']		= 'Администратор';
$LNG['welcome_message_sender']		= 'Администратор';
$LNG['welcome_message_subject']	= 'Добро пожаловать';
$LNG['welcome_message_content']	= 'Добро пожаловать на %s!<br>Для начала постройте рудник по добыче металла.<br />Что бы сделать это, нажмите на ссылке "Постройки" слева, и нажмите "Строить" справа от рудника по добыче металла.<br />Теперь у Вас есть немного времени что бы больше узнать об игре.<p>Найти помощь:<br />Войти на <a href=\"ЗДЕСЬ_ССЫЛКА_НА_ФОРУМ\" target=\"_blank\">Форум</a><br />Сейчас ваша постройка наверно уже закончилась.<br />Производство невозможно без энергии, Вы должны построить солнечную электростанцию, дождитесь окончания, и постройте солнечную электростанцию.<p>Что бы увидеть все корабли, защитные структуры, постройки и исследования которые можно произвести, нажмите на пункте "Технологии" в левом меню.<p>Теперь вы готовы изучать вселенную ... Удачи!';
$LNG['newpass_smtp_email_error']	= '<br><br>Произошла ошибка. Ваш пароль: ';
$LNG['reg_completed']				= 'Регистрация завершена! На Ваш email выслано письмо с активацией.';

//registry_form.tpl
$LNG['server_message_reg']			= 'Зарегистрируйся сейчас и стань частью огромного мира';
$LNG['register_at_reg']			= 'Зарегистрироваться на';
$LNG['uni_reg']					= 'Вселенная';
$LNG['user_reg']					= 'Пользователь';
$LNG['pass_reg']					= 'Пароль';
$LNG['pass2_reg']					= 'Подтвердить пароль';
$LNG['email_reg']					= 'E-mail адрес';
$LNG['email2_reg']					= 'Подтвердить E-mail адрес';
$LNG['planet_reg']					= 'Имя Главной планеты';
$LNG['lang_reg']					= 'Язык';
$LNG['register_now']				= 'Зарегистрироваться!';
$LNG['captcha_reg']				= 'Секретный вопрос';
$LNG['accept_terms_and_conditions']= 'Я принимаю <a onclick="ajax(\'?page=rules&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">Правила</a> и <a onclick="ajax(\'?page=agb&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">T&C</a>';
$LNG['captcha_reload']				= 'Обновить';
$LNG['captcha_help']				= 'Помощь';
$LNG['captcha_get_image']			= 'Загрузить Bild-CAPTCHA';
$LNG['captcha_reload']				= 'Новая CAPTCHA';
$LNG['captcha_get_audio']			= 'Загрузить Sound-CAPTCHA';
$LNG['user_active']                = 'Пользователь %s активирован!';

//registry_closed.tpl
$LNG['info']						= 'Информация';
$LNG['reg_closed']					= 'Регистрация закрыта';

//Rules
$LNG['rules_overview']				= "Правила";
$LNG['rules']						= array(
	"Аккаунт"					=> " Пользоваться аккаунтом может только один игрок, но временно разрешается присматривать за чужим аккаунтом (ситтинг).
Ситтинг означает присмотр игрока за чужим аккаунтом. Перед началом присмотра, Оператор должен быть уведомлён игроком заранее, через службу поддержки:
<br>
- Администрация должна быть проинформированы об ситтинге, через заявку в службу поддержки.<br>
- Период досрочно прерывается, если на аккаунт заходит его владелец.<br>
-  <br>.
- Присмотр за чужим аккаунтом разрешён на период не более 48 часов. (Администрация может досрочно прервать время в случае нарушения правил). <br>
Присматривающий за аккаунтом имеет право:<br>

- Тратить ресурсы на постройку зданий или исследований.<br>
- Во время присмотра запрещены любые действия с флотом, за исключением увода флота из под атаки с заданием Транспорт или Оставить на другую планету или луну владельца. <br>
- Задействовать режим отпуска.<br>

Присматривающий за аккаунтом не имеет право:<br>

- Транспортировать ресурсы между планетами/лунами.<br>
- Строить оборону и флот.<br>
- Присматривать за аккаунтом можно при условии, что за ним ещё никто не присматривал в предыдущие 7 дней.<br>
- Отключать режим отпуска.",


	"Прокачка (Пушинг)"					=> "Нижестоящему в рейтинге игроку запрещено передавать ресурсы игроку, стоящему выше в рейтинге.<br>
Исключения:<br>

- Нижестоящему в рейтинге игроку запрещено передавать ресурсы игроку, стоящему выше в рейтинге.<br>
- Это также относится к скрытым схемам передачи ресурсов, например через разбитие флота игрока нижестоящего в рейтинге, и последующим сбором Поля Обломков, игроком стоящим выше него. .<br>
- Торговля между игроками должна быть завершена в 48 часовой срок.<br>
- Игроки с высоким рейтингом расплачиваются ресурсами.<br>
- Сделки, с повышенными рейтингами. Сделки не подпадающие под повышенные виды рейтинга:<br>

3:2:1 Где каждая единица составляет 1 дейтерия, 2 единицы кристалла и 3 единицы металла.<br>

2:1:1 Где каждая единица составляет 1 дейтерия, 1 единица кристалла и 2 единицы металла.<br>
",

	"Башинг"					=> "Запрещено атаковать одну планету или луну более 6 раз за период 24 часа. Задание Уничтожить приравнивается к Атаке. <br>

Разведка шпионскими зондами и Межпланетными ракетами не учитываются. Во время ведения войны между двумя Альянсами ограничение на количество атак снимается (при условии что война была объявлена по всем правилам на форуме).",

	
	"Использование Багов и Скриптов"					=> "Использование ошибок игры для получения превосходства, а также сокрытие ошибок от администрации строго запрещено. Запрещено использование сторонних программ-клиентов.<br> Использование автоматических скриптов (ботов) также запрещено",


	" Угрозы в реальной жизни"	=> "Запрещены угрозы, касающиеся расправы в реале над другим игроком, членом команды, представителем сервера или другой персоной, причастной к игре.",

	"Спам"			=> "Запрещены любые оскорбления и спам.",

  "Война"                    => "После того как Лидеры альянсов объявят о войне, она становится официальной. И будет длиться, пока один из альянсов не отменяет его. Чтобы официально отменить войну они должны прекратить военные действия в игре, и заявить об этом в теме на форуме.<br>
Когда война объявлена, башинг между альянсами снимает все ограничения. Это значит, что любой член входящий в альянс может быть атакован неограниченное кол-во раз.<br>
Если один из альянсов сдался и отменил войну, правила башинга вступаю в силу опять, и любой член альянса нарушивший правило понесет наказание бан 1 день.

Если флот оппозиционного альянса был отправлен. И война была отменена до того как они закончили выполнять задание. Они не будут наказаны за свои действия. Но любой владелец флота, который отправил его после отмены войны понесет наказание.


Что бы объявить войну, нужно создать новую тему в разделе Война/Дипломатия на форуме.
Там они могут устанавливать какие-либо конкретные правила и требования войны. Все правила, установленные в разделе, должны быть приняты на союз, и не должны противоречить чему-либо установленному здесь.",                          

);

$LNG['rules_info1']				= "";
$LNG['rules_info2']				= "Я ознакомился и принимаю <a onclick=\"ajax('?page=agb&getajax=1');\" style=\"cursor:pointer;\">T&C</a> и описанные здесь правила!</font>";


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

$LNG['fb_perm']                = 'Доступ запрещен. %s нужны соответствующие права что бы войти на свой аккаунт в Facebook. \n Альтернативно, вы можете залогинится сначала в Facebook!';

//NEWS

$LNG['news_overview']			= "Новости";
$LNG['news_from']				= "От %s к %s";
$LNG['news_does_not_exist']	= "Нет новостей!";

//Impressum

$LNG['disclamer']				= "Правила";
$LNG['disclamer_name']			= "Имя";
$LNG['disclamer_adress']		= "Адрес";
$LNG['disclamer_tel']			= "Телефон:";
$LNG['disclamer_email']		= "E-mail адрес";

// Translated into Russian by ssAAss . All rights reversed (C) 2010

?>
