<?php

// Translated into Russian by InquisitorEA (SporeEA@yandex.ru). All rights reserved © 2010-2012

// Общее
$LNG['index']                        = 'Главная';
$LNG['register']                     = 'Зарегистрироваться';
$LNG['forum']                        = 'Форум';
$LNG['send']                         = 'Отправить';
$LNG['menu_index']                   = 'Главная';
$LNG['menu_news']                    = 'Новости';
$LNG['menu_rules']                   = 'Правила';
$LNG['menu_pranger']                 = 'Заблокированные';
$LNG['menu_top100']                  = 'Зал славы';
$LNG['menu_disclamer']               = 'Контакты';
$LNG['uni_closed']                   = '(отключена)';

// Восстановление пароля
$LNG['lost_pass_title']              = 'Восстановление пароля';
$LNG['lost_empty']                   = 'Вы должны заполнить все поля.';
$LNG['lost_not_exists']              = 'Аккаунта с таким адресом электронной почты не существует.';
$LNG['lost_mail_title']              = 'Новый пароль';
$LNG['mail_sended']                  = 'Ваш новый пароль успешно отправлен на Вашу электронную почту %s.';

$LNG['server_infos']                 = array(
	"Создайте экономическую и военную инфраструктуру.",
	"Исследуйте новейшие технологии.",
	"Ведите войны против других империй.",
	"Создавайте альянсы и ведите переговоры с другими императорами.",
	"Постройте непобедимый флот или планетарную оборону.",
);

$LNG['login_error_1']                = 'Неправильный логин или пароль.';
$LNG['login_error_2']                = 'Ваш текущий IP адрес отличается от IP адреса последней незавершённой сессии.';
$LNG['login_error_3']                = 'Ваша сессия завершена.';
$LNG['login_error_4']                = 'Произошла ошибка во внешней авторизации. Попробуйте ещё раз позже.';
$LNG['screenshots']                  = 'Скриншоты';
$LNG['universe']                     = 'Вселенная';
$LNG['chose_a_uni']                  = 'Выбрать...';

// index_body.tpl - Авторизация
$LNG['user']                         = 'Логин';
$LNG['pass']                         = 'Пароль';
$LNG['remember_pass']                = 'Запомнить';
$LNG['lostpassword']                 = 'Забыли пароль?';
$LNG['welcome_to']                   = 'Добро пожаловать в';
$LNG['server_description']           = '<strong>%s</strong> - это <strong>стратегический космический симулятор в реальном времени</strong> Сражайтесь с <strong>тысячами игроков</strong> во всём мире <strong>одновременно</strong>, чтобы стать лучшим. Для этого вам понадобится обычный браузер.';
$LNG['server_register']              = 'Регистрация';
$LNG['server_message']               = 'Присоединяйтесь и станьте частью невероятного мира';
$LNG['login']                        = 'Вход';
$LNG['disclamer']                    = 'Контакты';
$LNG['login_info']                   = 'Я принимаю <a onclick="ajax(\'?page=rules&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">Правила</a>';

// reg.php - Регистрация
$LNG['register_closed']              = 'Регистрация закрыта.';
$LNG['register_at']                  = 'Регистрация в ';
$LNG['reg_mail_message_pass']        = 'Вам осталось активировать аккаунт';
$LNG['reg_mail_reg_done']            = 'Добро пожаловать в %s!';
$LNG['invalid_mail_adress']          = 'Недействительный адрес электронной почты.';
$LNG['empty_user_field']             = 'Вы не ввели логин.';
$LNG['password_lenght_error']        = 'Пароль должен состоять из неменее 6 символов.';
$LNG['user_field_no_alphanumeric']   = 'Логин может содержать только алфавитно-цифровые символы.';
$LNG['user_field_no_space']          = 'Логин не может содержать пробелы.';
$LNG['planet_field_no']              = 'Вы не ввели название планеты.';
$LNG['planet_field_no_alphanumeric'] = 'Название планеты может содержать только алфавитно-цифровые символы.';
$LNG['planet_field_no_space']        = 'Название планеты не может содержать пробелы.';
$LNG['terms_and_conditions']         = 'Я принимаю <a href="index.php?page=rules">Правила</a>';
$LNG['user_already_exists']          = 'Выбранный логин уже существует.';
$LNG['mail_already_exists']          = 'Введённый адрес электронной почты уже существует.';
$LNG['wrong_captcha']                = 'Неверный защитный код.';
$LNG['different_passwords']          = 'Пароль не совпадает.';
$LNG['different_mails']              = 'Е-мейл не совпадает.';
$LNG['welcome_message_from']         = 'Администрация';
$LNG['welcome_message_sender']       = 'Администрация';
$LNG['welcome_message_subject']      = 'Добро пожаловать';
$LNG['welcome_message_content']      = 'Добро пожаловать в %s! Для начала постройте шахту металла. Для этого пройдите в меню Постройки и нажмите Строить справа от изображения шахты металла. Теперь у Вас есть некоторое время, чтобы узнать больше об игре. Помощь новичкам: на нашем <a href=\"http://2moons.cc/" target=\"_blank\">Форуме</a>. Теперь постройка Вашего месторождения должна быть завершена. Так как месторождения ничего не производят без энергии, Вы должны построить солнечную электростанцию, вернитесь в меню Постройки, и выберите строить солнечную электростанцию. Чтобы видеть все виды кораблей, оборонных сооружений, зданий и исследований, которые есть в игре, Вам нужно пройти в меню Технологии. Теперь Вы можете начать завоевание вселенной. Удачи!';
$LNG['reg_completed']                = 'Спасибо за регистрацию! Вы получите письмо на электронную почту с ссылкой на активацию аккаунта. Иногда письмо попадает в спам.';
$LNG['planet_already_exists']        = 'Планета уже существует.';

// registry_form.tpl - Регистрация
$LNG['server_message_reg']           = 'Присоединяйтесь и станьте частью невероятного мира';
$LNG['register_at_reg']              = 'Регистрация в ';
$LNG['uni_reg']                      = 'Вселенная';
$LNG['user_reg']                     = 'Логин';
$LNG['pass_reg']                     = 'Пароль';
$LNG['pass2_reg']                    = 'Подтвердить пароль';
$LNG['email_reg']                    = 'Электронная почта';
$LNG['email2_reg']                   = 'Подтвердить электронную почту';
$LNG['planet_reg']                   = 'Название главной планеты';
$LNG['ref_reg']                      = 'Привлечён игроком';
$LNG['lang_reg']                     = 'Язык';
$LNG['register_now']                 = 'Регистрация';
$LNG['captcha_reg']                  = 'Слова с картинки';
$LNG['accept_terms_and_conditions']  = 'Я принимаю <a href="index.php?page=rules">Правила</a>';
$LNG['captcha_help']                 = 'Помощь';
$LNG['captcha_get_image']            = 'Визуальная CAPTCHA';
$LNG['captcha_reload']               = 'Обновить CAPTCHA';
$LNG['captcha_get_audio']            = 'Звуковая CAPTCHA';
$LNG['user_active']                  = 'Аккаунт %s активирован.';

// Правила
$LNG['rules_overview']               = "Правила";
$LNG['rules_info1']                  = "Правила размещены на главной странице игры и на <a href=\"%s\" target=\"_blank\">форуме</a>";

// Новости
$LNG['news_overview']                = "Новости";
$LNG['news_from']                    = "%s от %s";
$LNG['news_does_not_exist']          = "Нет новостей";

// Контакты
$LNG['disclamer']                    = "Условия использования";
$LNG['disclamer_name']               = "Имя";
$LNG['disclamer_adress']             = "Адрес";
$LNG['disclamer_tel']                = "Телефон";
$LNG['disclamer_email']              = "Электронная почта";
?>