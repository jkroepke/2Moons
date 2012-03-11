<?php

// Traduzido por QwataKayean. Todos os Direitos Reservados © 2010-2011
// Texto escrito conforme o Acordo Ortográfico a ser inserido em 2011 pelo Ministério da Educação de Portugal - convertido pelo Lince.         

// 2Moons - Copyright (C) 2011  Slaver

// Recuperação de Senha
$LNG['lost_empty']                   = 'Deves preencher todos os campos!';
$LNG['lost_mail_title']              = 'Nova Senha';
$LNG['mail_sended']                  = 'A Nova senha foi enviada com sucesso para o teu e-mail %s!';
$LNG['lost_not_exists']              = 'Conta e ou endereço de Email não existe!';

//general
$LNG['index']                          	= 'Login';
$LNG['register']                       	= 'Registo';
$LNG['forum']                          	= 'Fórum';
$LNG['send']                           	= 'Enviar';
$LNG['menu_index']                     	= 'Entrar';    
$LNG['menu_news']                      	= 'Noticias';     
$LNG['menu_rules']                     	= 'Regras';
$LNG['menu_pranger']                   	= 'Banidos';   
$LNG['menu_top100']                    	= 'Salão da Fama';     
$LNG['menu_disclamer']                 	= 'Contacto';
$LNG['uni_closed']						= '(Offline)';	   
      
/* ------------------------------------------------------------------------------------------ */

//index.php
//case lostpassword
$LNG['server_infos']                   	= array(
        "Um jogo de estratégia espacial em tempo real.",
        "Joga juntamente com centenas de outros jogadores.",  
        "Não precisa fazer download, apenas necessitas de um Browser.",   
        "Registo Gratuito",

);

//case default
$LNG['login_error_1']					= 'Usuário/Password Incorreto!';
$LNG['login_error_2']					= 'A tua sessão expirou ou alguem entror desde outro computador!';
$LNG['login_error_3']					= 'A tua sessão expirou!';
$LNG['screenshots']                    	= 'Imagens';
$LNG['universe']                       	= 'Universo';
$LNG['chose_a_uni']                    	= 'Escolhe o universo';

/* ------------------------------------------------------------------------------------------ */

//lostpassword.tpl
$LNG['lost_pass_title']                = 'Recuperar password';

//index_body.tpl
$LNG['user']                           = 'Usuário';
$LNG['pass']                           = 'Password';
$LNG['remember_pass']                  = 'Entrar Automaticamente';
$LNG['lostpassword']                   = 'Password perdida?';
$LNG['welcome_to']                     = 'O';
$LNG['server_description']             = '<strong>É um jogo de estratégia emocionante com centenas de jogadores. Regista-te e torna-te no Imperador da Galáxia.<br>Só precisas de um browser para jogar.</strong>';
$LNG['server_register']                = 'Por favor, regista-te agora!';
$LNG['server_message']                 = 'Registea-te agora e experimenta um novo e emocionante Mundo ';
$LNG['login']                          = 'Entrar';
$LNG['disclamer']                      = 'Ficha técnica';
$LNG['login_info']                     = 'Quando entrares, estás aceitar as <a onclick="ajax(\'?page=rules&amp;\'+\'getajax=1\');" style="cursor:pointer;">Régras</a> e os <a onclick="ajax(\'?page=agb&amp;\'+\'getajax=1\');" style="cursor:pointer;">T&C</a>';




/* ------------------------------------------------------------------------------------------ */

//Pagina de Registo
$LNG['register_closed']                = 'Sistema de registo fechado!';
$LNG['register_at']                    = 'Registado em ';
$LNG['reg_mail_message_pass']          = 'Ainda falta mais um passo para poderes entrar na tua conta';
$LNG['reg_mail_reg_done']              = 'Bem-vindo ao Mundo %s!';
$LNG['invalid_mail_adress']            = 'Este E-mail não e válido!<br>';
$LNG['empty_user_field']               = 'Por favor, preencha os campos todos!<br>';
$LNG['password_lenght_error']          = 'A password tem de conter pelo menos um minimo de 4 carateres!<br>';
$LNG['user_field_no_alphanumeric']     = 'Por favor, insere o nome do usuário apenas com carateres alfanuméricos!<br>';
$LNG['user_field_no_space']            = 'Por favor, não insira o nome de usuário com espaços ou em branco !<br>';
$LNG['planet_field_no']                = 'Não inseris-te o nome do planeta!';
$LNG['planet_field_no_alphanumeric']   = 'Por favor insira só carateres alphanumericos!<br>';
$LNG['planet_field_no_space']	       = 'Por favor não deixes o nome do planeta em branco!<br>';
$LNG['terms_and_conditions']           = 'Aceito os <a href="index.php?page=agb">T&C</a> e as <a href="index.php?page=rules>Régras</a> de jogo!<br>';
$LNG['user_already_exists']            = 'O Nome do Usuário que escolheu já existe!<br>';
$LNG['mail_already_exists']            = 'Este E-mail já existe!<br>';
$LNG['wrong_captcha']                  = 'Código de Segurança incorreto!<br>';
$LNG['different_passwords']            = 'As 2 passwords que introduzis-te são diferentes!<br>';
$LNG['different_mails']                = 'Os 2 E-Mails que introduzis-te são diferentes!<br>';
$LNG['welcome_message_from']           = 'Administrador';
$LNG['welcome_message_sender']         = 'A Equipa';
$LNG['welcome_message_subject']        = 'Bem-vindo';
$LNG['welcome_message_content']        = 'Bem-vindo ao Mundo %1$s!<br>A primeira construção deverá ser uma planta de energia solar, porque a energia é necessária para a subsequente produção de matérias-primas. Para construí-la, clique no menu à esquerda, "Edifícios". <br>Em seguida, procure o quarto edifício a partir do topo. Lá tem a planta de energia: agora que já a construiu deve começar as minas de matérias-primas.<br> Volte para o menu dos edifícios e construa uma mina de metal, em seguida, uma mina de cristal. A fim de ser capaz de construir naves, mas para isso precisa de ter construído o hangar. <br>Poderá ver na página das tecnologias o que é necessário para que tenha acesso às varias naves, edifícios, e tecnologias.<br><br> A equipa do %1$s deseja-lhe muito divertimento a explorar o universo!';
$LNG['reg_completed']                  = 'Obrigado pelo teu registo! Foi-te enviado um E-Mail com o link de ativação da tua conta.<br><br><b>Caso não recebas o E-mail nos proximos minutos por favor procure na sua caixa de SPAM ou contacte  o webmaster atravéz do fórum ou pelo <font face="Arial Black" color="#FFFF00">CONTACTO</fonte><font face="Arial Black" color="#FDEEF4"> desta pagina!</fonte></b>';
$LNG['planet_already_exists']		   = 'Essa posição ja se encontra ocupada! <br>';$LNG['planet_already_exists']		   = 'Essa posição ja se encontra ocupada! <br>';

//Template de Registo
$LNG['server_message_reg']             = 'Regista-te agora e faça parte do Mundo';
$LNG['register_at_reg']                = 'Registado no';
$LNG['uni_reg']                        = 'Uníverso';
$LNG['user_reg']                       = 'Usuário';
$LNG['pass_reg']                       = 'Password';
$LNG['pass2_reg']                      = 'Repetir Password';
$LNG['email_reg']                      = 'Morada de E-mail';
$LNG['email2_reg']					   = 'Confirmar o Email';
$LNG['planet_reg']					   = 'Nome do Planeta Principal';
$LNG['ref_reg']						   = 'Indicado por';
$LNG['lang_reg']                       = 'Idioma de Jogo';
$LNG['register_now']                   = 'Registar!';
$LNG['captcha_reg']                    = 'Imagem de sugurança';
$LNG['accept_terms_and_conditions']    = 'Por favor aceite as <a href="index.php?page=rules">Regras</a> e <a href="index.php?page=agb">Termos & Condições</a> para poder continuar';
$LNG['captcha_reload']                 = 'Reloading';
$LNG['captcha_help']                   = 'Ajuda';
$LNG['captcha_get_image']              = 'Imagem-CAPTCHA';
$LNG['captcha_reload']                 = 'Nova-CAPTCHA';
$LNG['captcha_get_audio']              = 'Som-CAPTCHA';
$LNG['user_active']		       		   = 'Usuários %s ativos!';

//Rules
$LNG['rules_overview']                 = "Regras";
$LNG['rules_info1']                    = "Mais informações podem ser encontradas no <a href=\"jogo\" target=\"_blank\">Fórum</a> ou se tiveres dúvidas também as podes expor lá ...";
         
//Facebook Connect         
         
$LNG['fb_perm']						   = 'Acesso proibido. Precisas de todos os direitos para fazeres o login com a conta do Facebook.Logo a seguir, poderás fazer o login sem a conta do Facebook!';         
         
//NEWS

$LNG['news_overview']                  = "Noticias";
$LNG['news_from']                      = "De %s a %s";
$LNG['news_does_not_exist']            = "Não há notícias disponiveis!";

//Impressum

$LNG['disclamer']                      = "Termos e Condições";
$LNG['disclamer_name']                 = "Nome";
$LNG['disclamer_adress']               = "Morrada";
$LNG['disclamer_tel']                  = "Telefone:";
$LNG['disclamer_email']                = "E-Mail";


?>
