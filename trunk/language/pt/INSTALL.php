<?php

// Traduzido por QwataKayean. Todos os Direitos Reservados © 2010-2012
// Texto escrito conforme o Acordo Ortográfico a ser inserido em 2011 pelo Ministério da Educação de Portugal - convertido pelo Lince.         

// 2Moons - Copyright (C) 2012  Jan Kröpke

$LNG['back']					= 'Voltar';
$LNG['continue']				= 'Continuar';
$LNG['continueUpgrade']			= 'Atualizar!';
$LNG['login']					= 'Login';

$LNG['menu_intro']				= 'Introdução';
$LNG['menu_install']			= 'Instalação';
$LNG['menu_license']			= 'Licença';
$LNG['menu_upgrade']			= 'Atualizar';

$LNG['title_install']			= 'Instalação';

$LNG['intro_lang']				= 'Idioma';
$LNG['intro_install']			= 'Para Instalação';
$LNG['intro_welcome']			= 'Olá utilizador de 2Moons!';
$LNG['intro_text']				= 'O 2Moons é um dos melhores projectos de OGame.<br>O 2Moons é a versão mais recente e mais estável do XNova actualmente desenvolvido. 2Moons é notável por sua facilidade de estabilidade, flexibilidade, dinamismo, qualidade e utilização. Nós sempre esperamos ser melhor do que as tuas expectativas.<br><br>O sistema de instalação irá guiar-te através da instalação ou atualizar de uma versão anterior para a mais recente. Cada questão, um problema, por favor não hesites em pedir ao nosso desenvolvimento e suporte em caso de duvidas!<br><br>O 2Moons é um projeto em Open Source, lincenciado sob GNU GPL v3. Para que esta seja verificado, por favor clica no link acima onde se refera a "Lincença"<br><br>Antes da instalação pode ser iniciado um pequeno teste para verificar se o teu Plano/Dominio tem todos os requesitos para suportar o 2Moons';
$LNG['intro_upgrade_head']		= '2Moons já instalado?';
$LNG['intro_upgrade_text']		= '<p>Já instalaste o 2Moons e queres fácil actualização?</p><p>Aqui podes atualizar a base de dados antiga com apenas alguns cliques!</p>';


$LNG['upgrade_success']			= 'Atualização de base de dados com sucesso, de momento na revisão %s.';
$LNG['upgrade_nothingtodo']		= 'Sem ação requerida, base de dados na revisão %s.';
$LNG['upgrade_back']			= 'Atrás';
$LNG['upgrade_intro_welcome']	= 'Bem vindo à atualização de base de dados!';
$LNG['upgrade_available']		= 'Atualizações disponíveis! A tua base de dados se encontra na revisão %s e poderás atualizar para a revisão %s.<br><br>Escolhe um dos primeiros comandos SQL para iniciar a instalação:';
$LNG['upgrade_notavailable']	= 'A revisão %s é a ultima para a tua base de dados.';
$LNG['upgrade_required_rev']	= 'A atualizaçao apenas funciona na revisão 2579 (2Moons v1.7) ou superior.';

$LNG['licence_head']			= 'Termos de Licença';
$LNG['licence_desc']			= 'Por favor, leia os termos de licença a seguir. Usa a barra de scroll para poderes ver todo o conteudo do documento';
$LNG['licence_accept']			= 'Para prosseguires a instalação de 2Moons, precisas de concordar com os Termos e Condições da Lincença do 2Moons';
$LNG['licence_need_accept']		= 'Se quiseres continuar com a instalação, terás que aceitar os termos da licença';

$LNG['req_head']				= 'Requesitos de Sistema';
$LNG['req_desc']				= 'Antes da instalação prosseguir, o 2Moons realizará alguns testes para verificar se o teu Servidor suporta o 2Moons, de modo garantir que o 2Moons possa ser instalado. É surgerido que leia cuidadosamente os resultados, e não prossiga até todos estes serem verificados.';
$LNG['reg_yes']					= 'Sim';
$LNG['reg_no']					= 'Não';
$LNG['reg_found']				= 'Encontrado';
$LNG['reg_not_found']			= 'Não encontrado';
$LNG['reg_writable']			= 'Gravavel';
$LNG['reg_not_writable']		= 'Não gravavel  ';
$LNG['reg_file']				= 'O ficheiro &raquo;%s&laquo; é gravavel?';
$LNG['reg_dir']					= 'A pasta &raquo;%s&laquo; é gravavel?';
$LNG['req_php_need']			= 'Versão instalada da linguagem de script &raquo;PHP&laquo;';
$LNG['req_php_need_desc']		= '<strong>Requerido</strong> — O PHP é a linguagem base de código do 2Moons. Este é requerido a versão PHP 5.2.5 ou superior para que todos os modulos funcionam correctamente';
$LNG['reg_gd_need']				= 'Versão instalada do PHP GD Script &raquo;gdlib&laquo;';
$LNG['reg_gd_desc']				= '<strong>Opcional</strong> — Biblioteca de processamento gráfico &raquo;gdlib&laquo; é responsável pela geração dinâmica de imagens. Eles trabalham sem algumas das funcionalidades do software.';
$LNG['reg_mysqli_active']		= 'Suporte de extensão &raquo;MySQLi&laquo;';
$LNG['reg_mysqli_desc']			= '<strong>Requerido</strong> — Precisas de ter suporte para MySQLi em PHP. Se nenhum módulo de banco de dados são mostrados como sendo disponíveis, deves contactar o teu provedor de hospedagem (Hoster do Dominio) ou rever a documentação do PHP.';
$LNG['reg_json_need']			= 'Extensão &raquo;JSON&laquo; disponivél?';
$LNG['reg_iniset_need']			= 'Função PHP &raquo;ini_set&laquo; disponivél?';
$LNG['reg_global_need']			= 'register_globals desactivado?';
$LNG['reg_global_desc']			= '2Moons também irá funcionar, se essa configuração está instalada no teu servidor. No entanto, é recomendado por razões de segurança, desactivar o "register_globals" na instalação PHP, se isso é possível.';
$LNG['req_ftp_head']			= 'Inserir informações de FTP';
$LNG['req_ftp_desc']			= 'Escreve as tuas informações de FTP de modo 2Moons poder corrigir automaticamente os problemas. Alternativamente, podes também atribuir manualmente permissões de gravação.';
$LNG['req_ftp_host']			= 'Hostname';
$LNG['req_ftp_username']		= 'Nome de Utilizador';
$LNG['req_ftp_password']		= 'Password';
$LNG['req_ftp_dir']				= 'Directória do 2Moons';
$LNG['req_ftp_send']			= 'Enviar';
$LNG['req_ftp_error_data']		= 'As informações fornecidas, não permitem conectar ao servidor FTP, desse modo, esta ligação falhou';
$LNG['req_ftp_error_dir']		= 'A directória que inseriste é invalida ou não existente';

$LNG['step1_head']				= 'Configurar Instalação de base de dados';
$LNG['step1_desc']				= 'Agora que foi determinado que 2Moons pode ser instalado no teu servidor, deverás fornecer algumas informações. Se tu não sabes como executar uma ligação de base de dados, entra em contato com teu provedor de hospedagem primeiro ou com o fórum de 2Moons para ajuda e suporte. Quando tu inserires os dados, verifica se foram introduzidos correctamente';
$LNG['step1_mysql_server']		= 'Servidor da Base de Dados ou DSN';
$LNG['step1_mysql_port']		= 'Porta da Base de Dados';
$LNG['step1_mysql_dbuser']		= 'Utilizador da Base de Dados';
$LNG['step1_mysql_dbpass']		= 'Password da Base de Dados';
$LNG['step1_mysql_dbname']		= 'Nome da Base de Dados';
$LNG['step1_mysql_prefix']		= 'Prefixo de tabelas:';

$LNG['step2_prefix_invalid']	= 'O prefixo de Base de Dados deve conter caracteres alfanuméricos e sublinhado como ultimo caracter';
$LNG['step2_db_no_dbname']		= 'Não especificaste o nome para a base de dados';
$LNG['step2_db_too_long']		= 'O prefixo de tabela é muito longo. Deve conter no máximo 36 caracteres';
$LNG['step2_db_con_fail']		= 'Existe um erro na ligação à Base de Dados. Os detalhes serão exibidos abaixo';
$LNG['step2_conf_op_fail']		= 'config.php não pode ser gravado!';
$LNG['step2_conf_create']		= 'config.php criado com sucesso!';
$LNG['step2_config_exists']		= 'config.php já existe!';
$LNG['step2_db_done']			= 'A conexão à Base de Dados foi bem-sucedida!';

$LNG['step3_head']				= 'Criar tabelas de Base de Dados';
$LNG['step3_desc']				= 'As tabelas necessárias para a base de dados do 2Moons já foram criadas e preenchidas com os valores por defeito. Ao ires para o próximo passo, concluirás a instalação do 2Moons';
$LNG['step3_db_error']			= 'Falha ao criar tabelas na Base de Dados:';

$LNG['step4_head']				= 'Conta do Administrador';
$LNG['step4_desc']				= 'O assistente de instalação vai agora criar uma conta de administrador para ti. Escreve o nome de usário, a tua password e o teu email';
$LNG['step4_admin_name']		= 'Nome de Usário de Administrador:';
$LNG['step4_admin_name_desc']	= 'Escreva o nome de usário com o comprimento de 3 a 20 caracteres';
$LNG['step4_admin_pass']		= 'Password de Administrador:';
$LNG['step4_admin_pass_desc']	= 'Escreva uma password com o comprimento de 6 a 30 caracteres';
$LNG['step4_admin_mail']		= 'E-mail de contato:';

$LNG['step6_head']				= 'Instalação concluida!';
$LNG['step6_desc']				= 'Instalaste com sucesso o sistema 2Moons';
$LNG['step6_info_head']			= 'Começe a utilizar o 2Moons agora!';
$LNG['step6_info_additional']	= 'Se clicares no botão abaixo, serás redireccionado para a página de Administração. Ai será um bom partido para começares a explorar as ferramentas de Administrador de 2Moons.<br/><br/><strong>Por favor apaga o &raquo;includes/ENABLE_INSTALL_TOOL&laquo; ou modifica o nome do ficheiro. Com a existência deste ficheiro, pode causar o teu jogo em risco, ao permitir que alguem reescreva a instalação!</strong>';

$LNG['sql_close_reason']		= 'O jogo encontra-se fechado';
$LNG['sql_welcome']				= 'Bem vindo ao 2Moons v';
