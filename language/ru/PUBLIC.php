<?php

/**
 *  2Moons 
 *   by Jan-Otto Kröpke 2009-2016
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @licence MIT
 * @version 1.8.0
 * @link https://github.com/jkroepke/2Moons
 */

// Translation into Russian - Copyright © 2010-2013 InquisitorEA <support@moon-hunt.ru>

// Заголовки
$LNG['siteTitleIndex']              = 'Главная';
$LNG['siteTitleRegister']           = 'Регистрация';
$LNG['siteTitleScreens']            = 'Скриншоты';
$LNG['siteTitleBanList']            = 'Заблокированные';
$LNG['siteTitleBattleHall']         = 'Зал славы';
$LNG['siteTitleRules']              = 'Правила';
$LNG['siteTitleNews']               = 'Новости';
$LNG['siteTitleDisclamer']          = 'Контакты';
$LNG['siteTitleLostPassword']       = 'Восстановление пароля';

// Меню
$LNG['forum']                       = 'Форум';
$LNG['menu_index']                  = 'Главная';
$LNG['menu_news']                   = 'Новости';
$LNG['menu_rules']                  = 'Правила';
$LNG['menu_banlist']                = 'Заблокированные';
$LNG['menu_battlehall']             = 'Зал славы';
$LNG['menu_disclamer']              = 'Контакты';
$LNG['menu_register']               = 'Регистрация';

// Выбор вселенной
$LNG['chose_a_uni']                 = 'Выбрать...';
$LNG['universe']                    = 'Вселенная';
$LNG['uni_closed']                  = ' (отключена)';

// Кнопки
$LNG['buttonRegister']              = 'Зарегистрироваться';
$LNG['buttonScreenshot']            = 'Скриншоты';
$LNG['buttonLostPassword']          = 'Забыли пароль?';

// Описание
$LNG['gameInformations'] 			= "Создайте экономическую и военную инфраструктуру.\nИсследуйте новейшие технологии.\nСоздавайте альянсы и ведите переговоры с другими императорами.\nПостройте непобедимый флот или планетарную оборону.";

// Авторизация
$LNG['loginHeader']                 = 'Авторизация';
$LNG['loginUsername']               = 'Логин';
$LNG['loginPassword']               = 'Пароль';
$LNG['loginButton']                 = 'Войти';
$LNG['loginInfo']                   = 'Со входом в игру я принимаю %s.';
$LNG['loginWelcome']                = 'Добро пожаловать в %s';
$LNG['loginServerDesc']             = '%s - это стратегический космический симулятор в реальном времени. Сражайтесь с тысячами игроков во всём мире одновременно, чтобы стать лучшим.';

// Регистрация
$LNG['registerFacebookAccount']     = 'Аккаунт Facebook';
$LNG['registerUsername']            = 'Логин';
$LNG['registerUsernameDesc']        = 'Логин должен содержать от 3 до 25 символов и состоять только из букв, цифр, пробелов и символов "_", "-", "."';
$LNG['registerPassword']            = 'Пароль';
$LNG['registerPasswordDesc']        = 'Пароль должен содержать не менее %s символов.';
$LNG['registerPasswordReplay']      = 'Пароль (подтверждение)';
$LNG['registerPasswordReplayDesc']  = 'Пожалуйста, повторите ввод пароля';
$LNG['registerEmail']               = 'Электронная почта';
$LNG['registerEmailDesc']           = 'Пожалуйста, введите адрес электронной почты.';
$LNG['registerEmailReplay']         = 'Электронная почта (подтверждение)';
$LNG['registerEmailReplayDesc']     = 'Пожалуйста, повторите ввод адреса электронной почты.';
$LNG['registerLanguage']            = 'Язык';
$LNG['registerReferral']            = 'Пригласил';
$LNG['registerCaptcha']             = 'Защитный код';
$LNG['registerCaptchaDesc']         = 'Пожалуйста, введите ниже буквы, которые показаны на картинке. Верхний и нижний регистр букв нужно соблюдать. Если вы не разобрали буквы на изображении даже после многократных обновлений кода, пожалуйста, свяжитесь с администратором игры.';
$LNG['registerCaptchaReload']       = 'Обновить код.';
$LNG['registerRules']               = 'Правила';
$LNG['registerRulesDesc']           = 'Я согласен и принимаю %s.';

$LNG['registerBack']                = 'Назад';
$LNG['registerNext']                = 'Далее';

$LNG['registerErrorUniClosed']      = 'Регистрация в данной вселенной закрыта.';
$LNG['registerErrorUsernameEmpty']  = 'Вы не ввели логин.';
$LNG['registerErrorUsernameChar']   = 'Логин может состоять только из букв, цифр, пробелов и символов "_", "-", "."';
$LNG['registerErrorUsernameExist']  = 'Указанный логин уже зарегистрирован.';
$LNG['registerErrorPasswordLength'] = 'Пароль должен содержать не менее %s символов.';
$LNG['registerErrorPasswordSame']   = 'Указанные пароли не совпадают.';
$LNG['registerErrorMailEmpty']      = 'Вы не ввели адрес электронной почты.';
$LNG['registerErrorMailInvalid']    = 'Адрес электронной почты введён неправильно.';
$LNG['registerErrorMailSame']       = 'Указанные адреса электронной почты не совпадают.';
$LNG['registerErrorMailExist']      = 'Указанный адрес электронной почты уже зарегистрирован.';
$LNG['registerErrorRules']          = 'Вы не приняли правила игры.';
$LNG['registerErrorCaptcha']        = 'Защитный код введён неправильно.';

$LNG['registerMailVertifyTitle']    = 'Активация аккаунта на сайте %s';
$LNG['registerMailVertifyError']    = 'Не удалось отправить сообщение на электронную почту %s';

$LNG['registerMailCompleteTitle']   = 'Добро пожаловать в %s!';

$LNG['registerSendComplete']        = 'Спасибо за регистрацию. В ближайшее время Вы получите по электронной почте письмо с дополнительной информацией. Письмо может попасть в категорию Спам.';

$LNG['registerWelcomePMSenderName'] = 'Администратор';
$LNG['registerWelcomePMSubject']    = 'Добро пожаловать';
$LNG['registerWelcomePMText']       = 'Добро пожаловать в %s! Первым делом постройте солнечную электростанцию​​, потому что энергия необходима для последующего производства ресурсов. Для этого нажмите кнопку "Постройки" в левом меню. Затем постройте четвёртое здание сверху. Теперь у Вас есть энергия, Вы можете начать строить шахты. Вернитесь в меню "Постройки" и постройте шахту металла, затем шахту кристалла. Чтобы строить корабли Вам нужно сначала построить Верфь. Что для этого нужно Вы найдёте в левом меню "Технологии". Команда проекта желает вам много удовольствия в исследовании Вселенной!';

// Активация учётной записи
$LNG['vertifyNoUserFound']          = 'Неверный запрос.';
$LNG['vertifyAdminMessage']         = 'Учётная запись "%s" активирована.';

// Восстановление пароля
$LNG['passwordInfo']                = 'Если Вы забыли свой ​​пароль, Вам нужно знать логин и адрес электронной почты, связанный с Вашим аккаунтом. Если Вы не знаете их, пожалуйста, свяжитесь с администратором игры.';
$LNG['passwordUsername']            = 'Логин';
$LNG['passwordMail']                = 'Электронная почта';
$LNG['passwordCaptcha']             = 'Защитный код';
$LNG['passwordSubmit']              = 'Отправить';
$LNG['passwordErrorUsernameEmpty']  = 'Вы не указали логин.';
$LNG['passwordErrorMailEmpty']      = 'Вы не указали электронную почту.';
$LNG['passwordErrorUnknown']        = 'Указанная учётная запись не найдена.';
$LNG['passwordErrorOnePerDay']      = 'Запрос на восстановление пароля к этой учётной записи уже был произведён один раз за последние 24 часа. По соображениям безопасности пароль пользователя можно восстановить только один раз в день. Вы можете восстановить пароль для этой учётной записи снова через 24 часа.';

$LNG['passwordValidMailTitle']      = 'Восстановление пароля на сайте %s';
$LNG['passwordValidMailSend']       = 'В ближайшее время Вы получите по электронной почте письмо с дополнительной информацией. Письмо может попасть в категорию Спам.';

$LNG['passwordValidInValid']        = 'Неверный запрос.';
$LNG['passwordChangedMailSend']     = 'В ближайшее время Вы получите по электронной почте письмо с Вашим новым паролем.';
$LNG['passwordChangedMailTitle']    = 'Новый пароль на сайте %s';

$LNG['passwordBack']                = 'Назад';
$LNG['passwordNext']                = 'Далее';

// Ошибки авторизации
$LNG['login_error_1']               = 'Неправильный логин или пароль.';
$LNG['login_error_2']               = 'Ваш текущий IP адрес отличается от IP адреса последней незавершённой сессии.';
$LNG['login_error_3']               = 'Ваша сессия завершена.';
$LNG['login_error_4']               = 'Произошла ошибка во внешней авторизации. Попробуйте ещё раз позже.';

// Правила
$LNG['rulesHeader']                 = 'Правила';

// Новости
$LNG['news_overview']               = 'Новости';
$LNG['news_from']                   = '%s от %s';
$LNG['news_does_not_exist']         = 'Нет новостей';

// Контакты
$LNG['disclamerLabelAddress']       = 'Адрес:';
$LNG['disclamerLabelPhone']         = 'Телефон:';
$LNG['disclamerLabelMail']          = 'Электронная почта:';
$LNG['disclamerLabelNotice']        = 'Дополнительная информация';
