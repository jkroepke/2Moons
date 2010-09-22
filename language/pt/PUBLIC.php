<?php

//general
$LNG['index']                          	= 'Login';
$LNG['register']                       	= 'Registo';
$LNG['forum']                          	= 'Fórum';
$LNG['send']                           	= 'Enviar';
$LNG['menu_index']                     	= 'Login';    
$LNG['menu_news']                      	= 'Noticias';     
$LNG['menu_rules']                     	= 'Régras';
$LNG['menu_agb']                       	= 'T&C';
$LNG['menu_pranger']                   	= 'Banidos';   
$LNG['menu_top100']                    	= 'Top de Fama';     
$LNG['menu_disclamer']                 	= 'Contactar';  
      
/* ------------------------------------------------------------------------------------------ */

$LNG['music_off']						= 'Musica: OFF';
$LNG['music_on']						= 'Musica: ON';

//index.php
//case lostpassword
$LNG['mail_not_exist']                 	= 'Este E-Mail não existe!';
$LNG['mail_title']                     	= 'Nova Password';
$LNG['mail_text']                      	= 'A nova password é: ';
$LNG['mail_sended']                    	= 'A nova password foi enviada com êxito!';
$LNG['mail_sended_fail']               	= 'O E-Mail não pôde ser enviado.!';
$LNG['server_infos']                   	= array(
        "Um jogo de estratégia espacial em tempo real.",
        "Joga juntamente com centenas de outros jogadores.",  
        "Não precisas de fazer download, apenas necessitas de um browser.",   
        "Registo Gratuito",

);

//case default
$LNG['login_error_1']					= 'Username/Password Incorrecto!';
$LNG['login_error_2']					= 'Alguem entrou na tua conta apartir de outro computador!';
$LNG['login_error_3']					= 'A tua sessão expirou!';
$LNG['screenshots']                    	= 'Imagens';
$LNG['universe']                       	= 'Universo';
$LNG['chose_a_uni']                    	= 'Escolha o universo';

/* ------------------------------------------------------------------------------------------ */

//lostpassword.tpl
$LNG['lost_pass_title']                = 'Recuperar password';
$LNG['retrieve_pass']                  = 'Recuperar';
$LNG['email']                          = 'Morada de E-Mail';

//index_body.tpl
$LNG['user']                           = 'Usuário';
$LNG['pass']                           = 'Password';
$LNG['remember_pass']                  = 'Auto-Login';
$LNG['lostpassword']                   = 'Password esquecida?';
$LNG['welcome_to']                     = 'O mundo  ';
$LNG['server_description']             = 'É um jogo de estratégia emocionante com milhares de jogadores.<br><br>Entre e torne-se o imperador da galáxia.<br><br>Só precisa de um browser para jogar.';
$LNG['server_register']                = 'Por favor, registe-se agora!';
$LNG['server_message']                 = 'Registe-se agora e experimente um novo e emocionante mundo ';
$LNG['login']                          = 'Login';
$LNG['disclamer']                      = 'Ficha técnica';
$LNG['login_info']                     = 'Com o meu login aceito as <a onclick="ajax(\'?page=rules&amp;\'+\'getajax=1\');" style="cursor:pointer;">Régras</a> e os <a onclick="ajax(\'?page=agb&amp;\'+\'getajax=1\');" style="cursor:pointer;">T&C</a>';




/* ------------------------------------------------------------------------------------------ */

//reg.php - Registrierung
$LNG['register_closed']                = 'Sistema de registo fechado!';
$LNG['register_at']                    = 'Registado em ';
$LNG['reg_mail_message_pass']          = 'Ainda falta mais um passo para poder entrar na sua conta';
$LNG['reg_mail_reg_done']              = 'Bem-vindo ao mundo %s!';
$LNG['invalid_mail_adress']            = 'Este E-mail não e válido!<br>';
$LNG['empty_user_field']               = 'Por favor, preencha os campos todos!<br>';
$LNG['password_lenght_error']          = 'A password tem de conter pelo menos um minimo de 4 caracteres!<br>';
$LNG['user_field_no_alphanumeric']     = 'Por favor, digite o nome do usuário apenas com caracteres alfanuméricos!<br>';
$LNG['user_field_no_space']            = 'Por favor, não insira o nome de usuário com espaços ou em branco !<br>';
$LNG['planet_field_no_alphanumeric']   = 'Por favor insira só caracteres alphanumericos!<br>';
$LNG['planet_field_no_space']	       = 'Por favor não deixe o nome do planeta em branco!<br>';
$LNG['terms_and_conditions']           = 'Aceito os <a href="index.php?page=agb">T&C</a> e as <a href="index.php?page=rules>Régras</a> de jogo!<br>';
$LNG['user_already_exists']            = 'O username que escolheu já existe!<br>';
$LNG['mail_already_exists']            = 'Este E-mail já existe!<br>';
$LNG['wrong_captcha']                  = 'Código de Segurança incorrecto!<br>';
$LNG['different_passwords']            = 'As 2 passwords que introduziu são diferentes!<br>';
$LNG['different_mails']                = 'Os 2 E-Mails que introduziu são diferentes!<br>';
$LNG['welcome_message_from']           = 'Administrador';
$LNG['welcome_message_sender']         = 'A Equipa';
$LNG['welcome_message_subject']        = 'Bem-vindo';
$LNG['welcome_message_content']        = 'Bem-vindo ao mundo %s!<br>A primeira construção deverá ser uma planta de energia solar, porque a energia é necessária para a subsequente produção de matérias-primas. Para construí-la, clique no menu à esquerda, "Edifícios". <br>Em seguida, procure o quarto edifício a partir do topo. Lá tem a planta de energia: agora que já a construiu deve começar as minas de matérias-primas.<br> Volte para o menu dos edifícios e construa uma mina de metal, em seguida, uma mina de cristal. A fim de ser capaz de construir naves, mas para isso precisa de ter construído o hangar. <br>Poderá ver na página das tecnologias o que é necessário para que tenha acesso às varias naves, edifícios, e tecnologias.<br><br> A equipa do Vedra deseja-lhe muito divertimento a explorar o universo!';
$LNG['newpass_smtp_email_error']       = '<br><br>Ocorreu um erro, a sua password é: ';
$LNG['reg_completed']                  = 'Obrigado pela sua inscrição! Foi-lhe enviado um E-Mail com o link de activação da sua conta.<br><b>Caso não receba o mail nos proçimos minutos por favor contacte a Equipa Vedra atravez do fórum!</b>';
$LNG['planet_already_exists']		   = 'Essa posição ja se encontra ocupada! <br>';

//registry_form.tpl
$LNG['server_message_reg']             = 'Registe-se agora e faça parte do mundo';
$LNG['register_at_reg']                = 'Registado no';
$LNG['uni_reg']                        = 'Uníverso';
$LNG['user_reg']                       = 'Usuário';
$LNG['pass_reg']                       = 'Password';
$LNG['pass2_reg']                      = 'Repetir Password';
$LNG['email_reg']                      = 'Morada de E-mail';
$LNG['email2_reg']					   = 'Confirmar o Email';
$LNG['planet_reg']					   = 'Name of Mainplanet';
$LNG['lang_reg']                       = 'Língua de Jogo';
$LNG['register_now']                   = 'Registar!';
$LNG['captcha_reg']                    = 'Imagem de sugurança';
$LNG['accept_terms_and_conditions']    = 'Por favor aceite as <a onclick="ajax(\'?page=rules&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\);" style="cursor:pointer;">Régras</a> e o <a onclick="ajax(\'?page=agb&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\);" style="cursor:pointer;">T&C</a>';
$LNG['captcha_reload']                 = 'Reloading';
$LNG['captcha_help']                   = 'Ajuda';
$LNG['captcha_get_image']              = 'Imagem-CAPTCHA';
$LNG['captcha_reload']                 = 'Nova-CAPTCHA';
$LNG['captcha_get_audio']              = 'Som-CAPTCHA';
$LNG['user_active']		       		   = 'Usuários %s activos!';

//registry_closed.tpl
$LNG['info']                           = 'Imformações';
$LNG['reg_closed']                     = 'O sistema de registo encontra-se fechado';

//Rules
$LNG['rules_overview']                 = "Regras";
$LNG['rules']                          = array(
      "Contas"                      => "    
    * Cada jogador apenas pode possuir uma conta por universo, mais do que uma será considerada multi-conta e as contas envolvidas serão sancionadas com o bloqueamento.
    * Quando o jogador normal ou ocasionalmente jogar a partir de um IP público (cyber-café, universidades, escolas, etc), um operador de jogo do universo em causa deve ser obrigatoriamente notificado.
    * Se contas de proprietários diferentes são normal, ocasional ou permanentemente jogadas a partir do mesmo IP, um operador de jogo do universo em causa deve ser obrigatoriamente notificado.
    * Nestes casos, as contas não estão autorizadas em nenhum caso a terem interacção de frotas que inclui ataques, trocas, envios de recursos, envio de sondas, etc.
    * Perfis que partilhem um mesmo IP, seja em casa ou no trabalho, também não têm permissão de fora desse IP, fazerem interacções de frota incluindo ataques em acs ou empréstimo de recicladores, a única excepção é se essa partilha de IP resultar num sitting de uma das contas - neste caso apenas poderão fazer interacção fora de um mesmo IP.
    * Se duas ou mais contas partilharem regularmente o mesmo IP, nenhuma dessas contas poderá ser MoonMaker ou Moon Destroyers.",

      "Multi-Contas"                  => "    
    * Cada jogador apenas pode possuir uma conta por universo, mais do que uma será considerada multi-conta e as contas envolvidas serão sancionadas com o bloqueamento.
    * Quando o jogador normal ou ocasionalmente jogar a partir de um IP público (cyber-café, universidades, escolas, etc), um operador de jogo do universo em causa deve ser obrigatoriamente notificado.
    * Se contas de proprietários diferentes são normal, ocasional ou permanentemente jogadas a partir do mesmo IP, um operador de jogo do universo em causa deve ser obrigatoriamente notificado.
    * Nestes casos, as contas não estão autorizadas em nenhum caso a terem interacção de frotas que inclui ataques, trocas, envios de recursos, envio de sondas, etc.
    * Perfis que partilhem um mesmo IP, seja em casa ou no trabalho, também não têm permissão de fora desse IP, fazerem interacções de frota incluindo ataques em acs ou empréstimo de recicladores, a única excepção é se essa partilha de IP resultar num sitting de uma das contas - neste caso apenas poderão fazer interacção fora de um mesmo IP.
    * Se duas ou mais contas partilharem regularmente o mesmo IP, nenhuma dessas contas poderá ser MoonMaker ou Moon Destroyers.",


      "Pushing"                          => "
   * Não é permitido o favorecimento através de recursos de uma conta com mais pontos por uma conta mais fraca.
   * É considerado pushing:
          o Envio de recursos num único sentido por um jogador com menos pontuação do que aquele que recebe;
          o Acumulação de recursos num planeta com a intenção de beneficiar o atacante;
          o Empréstimos de recursos que não são devolvidos num prazo de 48 horas;
          o Trocas que não obedeçam ao mínimo estabelecido para as trocas de recursos.
    * São excepções (em alguns casos devidamente autorizados por um GO):
          o Envio de lucros de ACS;
          o Empréstimo de recicladores;
          o Cancelamento de ataque;
          o Pagamento de extorsões;
          o Protecção de recursos;
          o Empréstimos de recursos;
          o Caça prémios;
          o Ajudas na reconstrução de uma frota destruída;
          o Tentativas de lua em que o jogador que perdeu a frota receba os destroços recolhidos por outrem;
          o Tentativas de lua em que o jogador atacante perdeu a frota e o valor total da frota atacante perdida foi pago pelo defensor.",

        "Bashing"                          => " 
    * Mais de 6 ataques em 24 horas, ao mesmo planeta de um jogador activo, é considerado Bashing, e por isso não é permitido.
    * As luas são consideradas planetas independentes.
    * Ataques com Mísseis Interplanetários, ataques onde a frota atacante é completamente destruída ou ataques com frota composta só com sondas de espionagem, não são considerados para a regra de bashing.
    * Devido ao risco que acarreta uma Destruição de Lua este tipo de missão não é considerado para a regra do bashing.
    * Frotas compostas por 1 ou várias sondas de espionagem mais outro tipo de naves em missão Espiar com o intuito de atacar devido á contra-espionagem e provocar dano na conta do defensor é considerado para a regra do Bashing.
    * As declarações de guerra entre alianças não alteram o cumprimento desta regra.",

        "IP`s"                   => "
    * A verificação de IP de uma conta só pode ser desactivada mediante autorização de um operador de jogo através de ticket ou IRC.
    * As únicas razões válidas para esta ficar desligada é unicamente a impossibilidade de conseguir jogar no seu computador. É necessário demonstrar e explicar a razão para qual a verificação de IP deverá manter-se desligada.
    * A Equipa Vedra-Empires não irá responsabilizar-se por perdas de contas com a Verificação de IP desactivada. ",
       
        "Bugusing"                        => "
    * Não é permitido ser favorecido através do uso de bugs e/ou erros de programação e ainda de scripts.
    * Se um bug for identificado por um usuário, este deverá reportá-lo o mais rapidamente possível, através do suporte do jogo ou no fórum de Bugs, do IRC ou por email.
    * Quaisquer acções que interfiram no bom funcionamento do jogo são proibidas.
    * É proibido manter a verificação de IP desligada se esta não tiver sido autorizada por um Operador de Jogo.",

        "Línguagem e Atitudes"                => "
    * A língua oficial dos uníversos Vedra é o português. No entanto, qualquer pessoa, de qualquer nacionalidade, pode jogar no Vedra-Empires, desde que não use outra língua a não ser a oficial no jogo, quer através de mensagens internas com outros jogadores ou informação nas páginas de alianças. 
    * Da mesma maneira, spam, nomes ou mensagens no jogo de conteúdo obsceno, insultuoso, racista, xenófobo ou terrorista conduzem à exclusão do jogo. ",

        "Ameaças/Insultos"                => "   
     * Ameaças à vida real ou insinuações sobre medidas de coação a um jogador serão sancionadas com o bloqueamento permanente do infractor.
     * Desrespeito, insultos, racismo, xenofobia, ameaças à vida real, difamação ou qualquer tipo de perseguição feita a elementos da equipa do Vedra-Empires, leva à exclusão do jogador infractor da comunidade do Vedra, ou seja, ao bloqueamento permanente em todos os universos que joga.",

        "Spam/Racismo/Xenofobia/Nazismo/Terrorismo"          => "
     * Envio contínuo de sondas e mensagens sem informação relevante serão consideradas spam.
     * Também o envio de mensagens com carácter publicitário de outros jogos ou sites de Internet que não sejam relacionados com o jogo em si, serão alvo de bloqueamento.
     * Qualquer mensagem, de carácter ofensivo com um conteúdo inaceitável que possa ferir a integridade individual de cada um, é estritamente proibida. Todos os jogadores devem respeitar os seus oponentes/amigos. Todo o conteúdo em nomes de planetas, jogadores, luas, alianças, tags, mensagens internas de aliança e de informação na página de aliança, que não obedeçam aos padrões estabelecidos pela equipa do jogo, serão censurados e punidos temporariamente ou permanentemente consoante a infracção.
     * Queixas relativas a estas sanções não serão tidas em conta e a palavra final será sempre da equipa do jogo.",

        "Regras"                      => " 
     * As regras podem mudar, e cada usuário é obrigado a constantemente verificar se ouve alteração !",

);

$LNG['rules_info1']                      = "Mais informações podem ser encontradas no <a href=\"%s\" target=\"_blank\">Fórum</a> ou se tiveres dúvidas também as podes expor lá ...";
$LNG['rules_info2']                      = "Estas são para cumprir obrigatóriamente  <a onclick=\"ajax('?page=agb&getajax=1');\" style=\"cursor:pointer;\">T&C</a> !</font>";

//AGB

$LNG['agb_overview']                     = "Termos e Condições";
$LNG['agb']                              = array(

        "Objecto das condições de utilização; área de aplicação"             => array(
                "As seguintes condições regulam a utilização dos jogos online e outras ofertas de serviços disponibilizadas nas páginas de Internet do jogo caso de registo ou início de sessão do utilizador no site do portal do jogo, o presente contrato de cessão está sempre dependente do jogo para os jogos online com base no cliente, ou seja, jogos para os quais é necessário o download por parte do cliente. Nestes casos, o Vedra Productions é apenas colaboradora da jogo em relação ao registo e início de sessão.",
               
                "Estas condições de utilização substituem por completo as versões mais antigas das condições de utilização do jogo.",
                
                "O O jogo online e as outras ofertas de serviços, no âmbito das suas possibilidades técnicas e de funcionamento, com uma disponibilidade de 98,0 %, média anual. Não está abrangido o tempo em que a utilização dos jogos online e de outras ofertas de serviço está interrompida ou afectada por razões técnicas obrigatórias ou devido a trabalhos de manutenção necessários sem que o jogo tenha de ser responsabilizado por isso de acordo com as disposições deste contrato.",
                
                "Os jogos online e as outras ofertas de serviços estão constantemente a ser desenvolvidos, actualizados e adaptados pelo jogo. Sendo assim, o utilizador só tem a possibilidade de participar no respectivo jogo online e outras ofertas na respectiva versão actual.", 
                
                "Os jogos online e os outros serviços disponibilizados pelo O jogo serve apenas de entretenimento. É proibida a utilização para efeitos de aquisição ou efeitos comerciais.",
                
                "O utilizador é responsável pela actualização e adequação do software e hardware que utiliza.",
                
                "Adicionalmente a estas condições de utilização, são válidas as regras do jogo válidas para o respectivo jogo online, caso existam. No caso de contradições entre estas condições de utilização e as regras do jogo, prevalecem as disposições destas condições de utilização. Para jogos online individuais, variantes especiais e/ou partes integrantes dos jogos online e ofertas de serviços individuais nas páginas de Internet do jogo são válidas, para além disso, condições de utilização especiais. Antes da utilização da respectiva oferta, o utilizador é chamado a atenção para isso de uma forma adequada.",
                
                "O utilizador tem a possibilidade de utilizar serviços de parceiros contratuais do O jogos online individual e outros serviços. Neste caso, celebra-se um contrato em separado entre o utilizador e o respectivo parceiro contratual da Gameforge. Antes da celebração do contrato, o utilizador é chamado a atenção para isso de forma adequada.",
                
                "Os regulamentos que divergem destas condições ou as condições gerais de negócio do utilizador só se aplicam se o jogo o autorizar previamente por escrito.",    
        ),


        "Celebração do contrato"                      => array( 
                "O pressuposto para a utilização dos jogos online e outras ofertas de serviços disponibilizados pelo jogo é o registo do utilizador.",
                
                "O registo só é permitido a pessoas físicas. Só são permitidas pessoas individuais como utilizadores (são proibidos grupos, famílias, parceiros, etc.). Caso o utilizador seja um menor, este assegura com o envio do requerimento de registo que existe uma autorização legal dos representantes legais.",
                
                "Ao efectuar o registo, o utilizador deve indicar um nome de jogador e um endereço de e-mail registado em seu nome. O utilizador não tem direito à atribuição de um determinado nome de jogador. O nome do jogador não deve violar os direitos de terceiros e também não deve infringir as boas maneiras. Para além disso, também não é permitido escolher um endereço de e-mail ou de Internet como nome de jogador. O utilizador responsabiliza-se pelo facto de as informações prestadas por ele no registo do jogo serem verdadeiras e completas.",
                
                "O registo deve ser efectuado pessoalmente. Não é permitido o registo por terceiros, nomeadamente terceiros que efectuam os registos de pessoas individuais comercialmente em vários operadores de teleserviços (serviços de registos e serviços de inscrições).",
                
                "A aceitação do requerimento de registo realiza-se no portal do jogo e na maior parte das páginas web de jogos online através de uma confirmação de autorização por e-mail. Com este e-mail, o utilizador recebe um link de activação. Nestes casos, o jogo valida o utilizador e a conta do utilizador, seleccionando o link de activação. Com a autorização ou outra validação por parte do jogo, realiza-se um contrato de utilização celebrado a tempo indeterminado entre o jogo e o utilizador com estas disposições. Em casos individuais, o processo de registo pode divergir, sendo depois o utilizador informado de forma adequada.",
                
                "Com o registo bem sucedido, o utilizador cria uma conta de utilizador (“user account”) que o utilizador pode administrar por ele próprio. O utilizador pode criar um user account tanto no site de portal do jogo como também no respectivo site do jogo online. O user account criado no portal do jogo também pode ser utilizado pelo utilizador para todos os outros jogos online ligados pela Gameforge por link ao portal da Gameforge. De modo inverso, o user account criado numa página de jogos online não é utilizável para outros jogos online.",
                
                "O user account não é transmissível sem a autorização expressa do jogo.",
                
                "Não existe direito a registo ou validação. Por cada ronda do jogo (p. ex. mundo, universo, etc.), um utilizador só se pode registar uma vez em jogos browser. Se o registo de um utilizador já tiver sido efectuado uma vez para uma destas rondas do jogo, o utilizador não pode, durante o tempo de duração do registo existente, realizar mais registos na mesma ronda do jogo, indicando, p. ex., outros dados ou dados alterados relacionados com a pessoa.",
       ),                            


        "Deveres gerais do utilizador"      => array( 
               "O utilizador responsabiliza-se a comunicar imediatamente ao jogo todas as alterações futuras dos seus dados indicados no âmbito do registo, nomeadamente a alteração do endereço de e-mail. O utilizador tem o dever de, se solicitado, confirmar ao jogo a exactidão dos seus dados.",
               
               "O utilizador tem o dever de manter sigilo relativamente aos seus dados de login e a todas as senhas e palavras-passe. O utilizador só deve introduzir os dados de login nas páginas de Internet exploradas pelo jogo.",
                
               "Sob o conceito Dados login e Senhas e palavras-passe compreendem-se todas as letras e/ou sequência de símbolos e/ou números utilizados para autentificar o utilizador e para se excluir a utilização por terceiros não autorizados. A palavra-passe não deve ser idêntica ao nome do jogador e deve conter uma combinação de números e letras.",
               
               "O utilizador tem o dever de proteger os seus dados de login e todas as senhas e palavras-passe do acesso não autorizado por parte de terceiros.",
               
               "No caso de o utilizador ter razões para acreditar que os seus dados foram obtidos ou poderiam ser obtidos por terceiros de forma não autorizada, o mesmo deverá informar imediatamente o jogo e alterará os seus dados ou deixará que a Gameforge altere os mesmos. Além disso, o jogo tem o direito de, neste caso, ou para o caso de o jogo ter valores de referência para um uso abusivo dos dados, bloquear provisoriamente o acesso do utilizador. A utilização por parte do utilizador será novamente autorizada, assim que a suspeita de uso abusivo for eliminada.",
                
               "Sob nenhumas circunstâncias, o utilizador está autorizado a utilizar os dados de login de outro utilizador, a não ser que as regras do jogo prevejam excepções.",
       
       ),
       
        "Utilização das páginas de Internet do jogo e conteúdos das páginas de Internet"               => array(
                "As páginas de Internet do jogo têm conteúdos de todo o tipo que estão protegidos pela lei relativa a marcas, direitos de autor e de outra forma a favor do jogo ou a favor de terceiros. Desde que não esteja expressamente permitido no âmbito destas condições de utilização, o utilizador não está autorizado a processar, fotocopiar, divulgar, reproduzir publicamente, publicitar ou utilizar, para além do que foi acordado contratualmente, as páginas de Internet do jogo ou os conteúdos ou partes individuais disponibilizados. Só é permitida a reprodução condicionada pela técnica para efeitos de browsing, assim como a reprodução permanente apenas para uso privado. As indicações de direitos de autor e as designações de marcas não podem ser alteradas nem suprimidas ou eliminadas.",
                
                "Sob o termo “Conteúdos” estão incluídos todos os dados, imagens, textos, gráficos, músicas, sons, sequências de sons, vídeos, programas e códigos de software e outras informações disponibilizados pelo jogo nas suas páginas de Internet. Sob o termo “Conteúdos” estão igualmente incluídas em particular todas as ofertas de serviços disponibilizadas para o download.",
                
                "O utilizador responsabiliza-se a abster-se de todas as medidas que afectam ou perturbam o modo de funcionamento das páginas de Internet do jogo ou serviços e prestações de serviço aqui oferecidos, assim como a não aceder a dados para os quais o utilizador não tem autorização. A consulta dos conteúdos disponibilizados só deve realizar-se de modo a não afectar a utilização das páginas de Internet do jogo e dos conteúdos pelos restantes utilizadores. Não é permitido o envio de dados ou software que podem influenciar o hardware ou o software de receptores.",
                
                "Qualquer utilização das páginas de Internet do jogo para efeitos comerciais, nomeadamente publicitários requer a expressa autorização prévia, por escrito, do jogo.",
                
                "O utilizador não tem qualquer direito à publicação de conteúdos nas páginas de Internet do jogo.",
                
                "Não é permitida a utilização das páginas de Internet do jogo através de serviços de anonimização que suprimem o verdadeiro endereço IP do utilizador.",
                
                "É permitido colocar um link para as páginas de Internet do jogo desde que este link sirva apenas para a referência cruzada. No entanto, o jogo reserva-se o direito de revogar esta autorização. No entanto, não é permitido integrar ou apresentar as páginas de Internet do jogo ou os respectivos conteúdos através de uma hiperligação numa janela parcial (Frame).",
                
                "O jogo concede ao utilizador – nas ofertas (incluindo os jogos) cuja utilização requer a instalação prévia de um Client Software – o direito não exclusivo (simples), limitado à existência do seu registo no jogo, de instalar e utilizar o Client Software. Apenas é permitido ao utilizador reproduzir o Client Software na medida em que for necessário para a utilização contratual do software. Não é permitida qualquer forma de utilização comercial do software. Não é permitida a alteração do Client Software, assim como a retransposição do código do programa deixado para outras formas de código (decompilação), assim como outras formas de reexploração dos diversos níveis de fabrico do software (Reverse-Engineering).",
        ),


        "Condições especiais para a utilização dos jogos online"               => array(
                "Em cada ronda de um jogo online (p. ex, Mundo, Universo, etc.), o utilizador só pode participar com um user account, a não ser que as regras do jogo prevejam excepções. Não é permitida a utilização de vários user accounts. Estas “multi user accounts” podem ser eliminadas e bloqueadas livremente pelo jogo a qualquer momento.",
                
                "Não é permitido ao utilizador intervir de forma manipulativa no jogo online. Nomeadamente, o utilizador não está autorizado a utilizar medidas, mecanismos ou software que possam perturbar o funcionamento e o decorrer do jogo. O utilizador não deve tomar medidas que possam ter como consequência a sobrecarga não razoável ou em demasia das capacidades técnicas. Não é permitido ao utilizador bloquear conteúdos gerados pela gestão do jogo, sobrescrevê-los ou modificá-los ou intervir de outra forma qualquer no jogo, perturbando-o.",
                
                "Além disso, não é permitido ao utilizador aceder ao jogo online (incluindo todas as páginas de Internet individuais) com outros programas, excepto com o Internet Browser ou o programa Client disponibilizado. Isto refere-se nomeadamente aos chamados Bots, assim como a outras ferramentas que devem substituir ou complementar a interface web. Também não são permitidos scripts e programas completa ou parcialmente automatizados que dão ao utilizador uma vantagem em relação aos outros jogadores. Aqui também estão incluídas funções de “auto refresh” e outros mecanismos integrados do browser de Internet, desde que se tratem de processos automatizados.",
                
                "ob nenhumas circunstâncias, o utilizador deve
	         a) Elaborar ou utilizar cheats, mods e/ou hacks, assim como utilizar qualquer outro software elaborado por terceiros que altere a experiência dos jogos online,
	         b) Utilizar software que permita o Datamining ou que, de outra forma, capte e recolha de outro modo informações relacionadas com os jogos online,
	         c) Utilizar objectos virtuais, utilizados nos jogos online, fora dos jogos online, comprá-los, vendê-los ou trocá-los com dinheiro verdadeiro.
	         Isto também abrange todos os contornos, modos de actuação semelhantes ou que, quanto ao seu efeito, são iguais às proibições acima mencionadas.",
                
                "Não é permitida a utilização de medidas que suprimam a publicidade. Neste caso, não importa se a publicidade é suprimida de forma consequente ou se de uma forma geral não pode ser apresentada, p. ex., devido aos chamados Pop Up Blocker, browsers baseados em texto ou semelhantes.",
                
                "Só é permitido efectuar o login através da página inicial do respectivo jogo online e através da página de portal do jogo. Não é permitida a abertura automatizada do user account, independentemente do facto de a página inicial ser apresentada ou não.",
                
                "Todos os direitos relativamente aos objectos virtuais utilizados nos jogos online e deixados a título oneroso são exclusivos do jogo ou dos parceiros contratuais autorizados pelo jogo. O mesmo é válido para os objectos virtuais criados pelo próprio utilizador. O utilizador concede ao jogo um direito de utilização exclusivo, limitado no espaço, no tempo e nos conteúdos, destes objectos virtuais por ele criados. Este direito inclui nomeadamente os direitos de reprodução, divulgação e processamento. O utilizador recebe apenas nos objectos virtuais um direito de utilização não exclusivo e limitado ao prazo do contrato.",
        ),


        "Condições especiais para (nomeadamente fórum de discussão, chat)"                         => array(
                "O utilizador pode publicar através de diversas possibilidades de comunicação (nomeadamente fórums de discussão, chats, blogs, livros de visitas e semelhantes, assim como no âmbito da função de comentário) conteúdos e artigos próprios nas páginas de Internet Gameforge. Ao jogo só disponibiliza as possibilidades técnicas para a troca de informações.",
                
                "O utilizador é o único responsável pelos conteúdos e artigos introduzidos por ele e responsabiliza-se por libertar completamente a Gameforge das reivindicações de terceiros. Ao jogo não toma como sua propriedade os conteúdos utilizados pelos utilizadores. No entanto, o utilizador concede ao jogo o direito permanente, irrevogável e não exclusivo para a utilização dos conteúdos e artigos por ele ajustados. Ao jogo chama a atenção para o facto de ao jogo não efectuar uma monitorização activa dos conteúdos ajustados. No entanto, fazem-se verificações aleatórias. Para além disso, qualquer utilizador tem a possibilidade de comunicar ao jogo os conteúdos que supostamente infringem a lei. Ao jogo reagirá então o mais rapidamente possível e editará ou apagará os conteúdos comunicados, se necessário.",
                
                "Ao utilizador não é permitido publicar ou divulgar, nas páginas de Internet do jogo e nomeadamente no âmbito das possibilidades de comunicação aqui disponibilizadas, conteúdos que
	         a) Violam a lei em vigor, que são ilegais ou imorais;
	         b) Violam marcas, patentes, amostras e utilização, direitos de autor, segredos comerciais ou outros direitos de terceiros;
	         c) Têm um carácter obsceno, racista, de enaltecimento da violência, pornográfico, que afecta a juventude ou de outra forma afecta o desenvolvimento de crianças e jovens ou que têm um carácter prejudicial;
	         d) Têm um carácter ofensivo, incómodo ou calunioso;
	         e) Contêm cartas de corrente ou sistemas de bola de neve;
	         f) Causam erradamente a impressão de que são disponibilizados ou suportados pelo jogo;
	         g) Possuem dados pessoais de terceiros sem a sua autorização expressa sobre o objecto;
	         h) Possuem um carácter comercial e nomeadamente publicitário.",
                
                "A indicação de páginas de Internet, empresas ou nomes de produtos só é permitido desde que isso não se realize prioritariamente para efeitos publicitários.",
                
                "Todos os utilizadores das possibilidades de comunicação disponibilizadas nas páginas de Internet do jogo têm o dever de escolher palavras aceitáveis. Não é permitida a crítica de injúria ou ataques destrutivos a pessoas.",
                
                "Sem prejuízo dos outros direitos de acordo com estas condições de utilização, ao Vedra Empiers tem o direito de alterar e apagar total ou parcialmente os conteúdos e os artigos que violam estas regras. Além disso, ao Vedra Empiers tem o direito de excluir, total ou provisoriamente, os utilizadores que infringem estas regras, da utilização dos jogos online, páginas de Internet do jogo e outras ofertas de serviços.",
        ),


        "Consequência da violação de deveres" => array(
                "O jogo não assume responsabilidade por danos que resultam de uma violação de deveres por parte do utilizador.",
                
                "Sem prejuízo de todos os outros direitos legais ou contratuais, ao Vedra Empiers pode tomar as seguintes medidas, conforme pretendido, se existirem pontos de referência de que um utilizador está a infringir as normas legais, os direitos de terceiros, as presentes condições de utilização ou as condições e regras do jogo complementares aplicáveis:
	         a) Alterar e apagar conteúdos,
	         b) Advertir um utilizador,
	         c) Publicação do comportamento errado no respectivo jogo online, indicando o nome do utilizador,
	         d) Bloqueio provisório ou permanente de um utilizador para jogos online individuais ou para todos os jogos online e conteúdos das páginas de Internet Gameforge,
	         e) Exclusão de um utilizador,
	         f) Decisão de proibição virtual provisória ou permanente de utilização do site nos casos de infracção contra o capítulo 6 ou
	         g) Rescisão imediata do contrato de utilização.",
                
                "Se um utilizador tiver sido bloqueado ou excluído, não pode registar-se novamente sem a autorização prévia do Vedra Empiers. Não existe direito ao levantamento de um bloqueio, de uma exclusão, de uma proibição virtual de utilização do site ou de outras medidas.",                
        ),


        "Recompensa relativamente à utilização"                               => array(
                "Se não for expressamente indicado de outra forma, a utilização dos jogos online e das outras ofertas de serviços é gratuita.",
                
                "No entanto, o utilizador pode adquirir ofertas de serviços individuais e funções individuais no âmbito dos jogos online, mediante pagamento. O utilizador é informado em separado relativamente ao tipo de funções disponíveis mediante pagamento, nomeadamente sobre as funções do respectivo feature, se aplicável, o tempo de disposição do feature a nível oneroso, o valor a pagar e o tipo de pagamento disponível relativamente ao jogo online.",
                
                "Se um utilizador menor desejar adquirir funções a título oneroso, o mesmo assegura que os meios que lhe foram deixados para o pagamento das funções a título oneroso lhe foram deixados pelo representante legal para este efeito ou para utilização livre.",
                
                "As recompensas acordadas devem ser pagas com a celebração do contrato. A cobrança de pagamento realiza-se, regra geral, pelo prestador de serviços encarregue do processo de pagamento sendo que a cobrança pode ser efectuada alguns dias antes para se poder assegurar a utilidade sem falhas. Para além destas condições de utilização, são válidas as condições comerciais gerais integradas eventualmente pelo prestador de serviços em casos únicos.",
                
                "O utilizador assegura que todas as informações prestadas no âmbito de um processo de pagamento (nomeadamente dados bancários, número de cartão de crédito, etc.) estão completas e correctas.",
                
                "As possibilidades de pagamento variam de acordo com o jogo online, o país do participante e as possibilidades de pagamento disponíveis no mercado e tecnicamente realizáveis. Ao Vedra Empiers reserva-se o direito de alterar, a qualquer momento, as possibilidades de pagamento.",
                
                "O Vedra Empiers reserva-se o direito de alterar recompensas para funções internas do jogo (incluindo moedas virtuais). Isto inclui o direito do Vedra Empiers de baixar ou aumentar recompensas para funções individuais internas ao jogo.",
                
                "Em caso de atraso, aplicam-se os juros legais. Para além disso, o Vedra Empiers está autorizada a bloquear o user account, a exigir a substituição de um dano e a anular os serviços.",
                
                "Se o Vedra Empiers tiver de pagar taxas de agravo ou de anulação devido à culpa do utilizador (também se a conta não tiver saldo suficiente), o utilizador suporta os custos relacionados com isso. O Vedra Empiers pode exigir estes custos e a recompensa, através de novo débito. Se o pagamento se efectuar através de cobrança de cartão de crédito, surgem débitos de até 50 Euros por cada cobrança de cartão de crédito, adicionando-se as taxas bancárias que surgiram à Gameforge. O Vedra Empiers está autorizada a exigir que um dano seja reparado através de substituição.",
        ),

        
        "Limitação de responsabilidade"      => array(
                "O utilizador responsabiliza-se, quanto à infracção que realizou, pelos direitos de terceiros em relação a eles próprios e directamente. O utilizador tem o dever de substituir todos os danos ao Vedra Empiers que surgem devido à não observância dos deveres resultantes destas condições de utilização. O utilizador liberta o Vedra Empiers de todas as reivindicações que outros utilizadores ou outros terceiros fazem em relação ao Vedra Empiers devido à violação dos seus direitos devido aos conteúdos ajustados pelo utilizador ou devido à violação de outros deveres. O utilizador também assume aqui os custos da defesa legal necessária do Vedra Empiers, incluindo todos os custos de tribunal e advogado. Isto não é válido se a violação dos direitos não for da responsabilidade do utilizador.",
                
                "A responsabilidade do Vedra Empiers, qualquer que seja a razão legal, quer seja devido à violação de deveres contratual ou actuação não permitida determina-se de acordo com os seguintes regulamentos:",
                
                "Caso o Vedra Empiers preste o respectivo serviço que activa a responsabilidade a título oneroso, o Vedra Empiers responsabiliza-se apenas pela intenção dolosa e pela negligência grave.",
                
                "Nos serviços a título oneroso, o Vedra Empiers responsabiliza-se ilimitadamente pela intenção dolosa e pela negligência grave, assim como no caso de danos em pessoas, no entanto quanto à negligência leve apenas se forem violados deveres essenciais ao contrato, em caso de atraso por parte do Vedra Empiers e impossibilidade. A responsabilidade em caso de violação de um destes deveres essenciais ao contrato está limitada ao dano típico contratual com cujo surgimento o Vedra Empiers teve de contar na celebração do contrato devido às circunstâncias conhecidas nessa altura.",
                
                "O Vedra Empiers não assume responsabilidade por falhas não cometidas pelo Vedra Empiers dentro das redes.",
                
                "O Vedra Empiers só se responsabiliza pela perda de dados de acordo com os parágrafos mencionados previamente se não fosse possível evitar esta perda através de medidas adequadas de protecção de dados por parte do utilizador.",
                
                "As limitações de responsabilidade existentes não são válidas no caso de aceitação de garantias expressas pelo Vedra Empiers, no caso de malícia e no caso de danos resultantes da colocação em perigo de vida, do corpo ou saúde, assim como no caso de regulamentos legais obrigatórios.",
         ),


         
         "Privacy"      => "Os dados pessoais do utilizador só são recolhidos, processados ou utilizados desde que o utilizador o tenha autorizado ou a lei de protecção de dados federal (BDSG), a lei de telemeios (TMG) ou outra norma legal o ordenar ou permitir.",
         );
         
//Facebook Connect         
         
$LNG['fb_perm']				= 'Acesso proibido. %s Precisas de todos os direitos para faseres o login com a conta do Facebook.\n Alternadamente poderás faser o login sem a conta do Facebook!';         
         
//NEWS

$LNG['news_overview']                          = "Noticias";
$LNG['news_from']                              = "De %s a %s";
$LNG['news_does_not_exist']                    = "Não há notícias desponiveis!";

//Impressum

$LNG['disclamer']                              = "Termos e Condições";
$LNG['disclamer_name']                         = "Nome";
$LNG['disclamer_adress']                       = "Morrada";
$LNG['disclamer_tel']                          = "Telefone:";
$LNG['disclamer_email']                        = "E-Mail";

?>