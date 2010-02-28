<?php

/**
 * Sistema de plugins
 * 
 * @author  Green
 * @version 0.4
 * @package XtremeGamez project
 * @copyright 2010 - 2011 Green (green.berwyn@gmail.com)
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
 interface mod_pl{
    
    public function install();
    public function exec();
    public function end();
    public function pre_exec();
 }
 class modPl{
    private $hooks;
    private $root = '../';
    private $exec = array();
    private $haccess = array();
    private $hraccess = array();
    private $ruotes;
    protected $pconf;
    
    function __construct(){
        global $xgp_root;
        
        // Ruta
        $this->root = ROOT_PATH;
        
        $this->db	= $GLOBALS['db'];
        // Ganchos
        $hooks = @include ROOT_PATH . 'includes/plugins/cmod_plug.'.PHP_EXT;
       
        // CB
        $this->prepare_hooks($mod_plug);
        
        // Ganchos tipo pre_system
        $this->run_hooks('pre_system');
        
        // Desactivado
        if ($GLOBALS['game_config']['plugins'] == '0') return;
        
        // Importar todos los plugins
        $plug_files = opendir(ROOT_PATH.'includes/plugins/');
        
        // Configuracion
        $config_plugins = array();
        $import_config  = $this->db->query('SELECT * FROM '.PLUGINS.';');
        while($plug_config = $this->db->fetch_array($import_config)){
            $config_plugins[$plug_config['plugin']] = $plug_config['status'];
        }
        $this->pconf = $config_plugins;
        
        // Bucle
        while(($mod_plugin = readdir($plug_files)) !== false){
            
            // Informacion del plug
            $plug_info = pathinfo(ROOT_PATH.'includes/plugins/'.$mod_plugin);
            
            // FIX
            if ($plug_info['extension'] != 'php') continue;
            
            // Desactivado
            if ($config_plugins[$plug_info['filename']] != 1 AND $config_plugins[$plug_info['filename']]) continue;
            
            // Importar
            require_once ROOT_PATH.'includes/plugins/'.$mod_plugin;
            
            // Hack_access
            $hack_function = $plug_info['filename'] . '_access'; 
            
            // HACK
            if (function_exists($hack_function)) $this->hack_access($plug_info['filename'], $hack_function());
            
            // Preparar la ejecucion
            $this->prepare_exec($plug_info['filename']);         
            
        }
    }
    /**
     * Prepara un plugin para su posterior ejecucion
     * modPl::prepare_exec()
     * 
     * @param string $plug_name
     * @return void
     */
    private function prepare_exec($plug_name = ''){
        $this->exec[] = $plug_name;
    }
    /**
     * Instala el sistema mod_plug
     * modPl::install_modpl()
     * 
     * @param string $plug_name
     * @return void
     */ 
     protected function get_selfile(){
        $file = $_SERVER["SCRIPT_FILENAME"];
        
        // Extraer datos
        $data = pathinfo($file, PATHINFO_FILENAME);
        
        return $data;
     }  
     
     /**
      * Prepara los ganchos de ejecucion
      * modPl::prepare_hooks()
      * 
      * @param mixed $config
      * @return void
      */
     private function prepare_hooks($config = array()){
        
        // Comprobacion
        if (!is_array($config)) return false;
        
        // Bucle
       $this->hooks = $config;
        
     }  
     
     /**
      * Ejecuta los hooks
      * modPl::run_hooks()
      * 
      * @param string $type
      * @return
      */
     protected function run_hooks($type = 'pre_system'){
        
        // Comprobacion
        if ( !is_array($this->hooks[$type]) ) return;
        
        // Llamar a los hooks 
        foreach ($this->hooks[$type] as $ID => $data){
            
            // Llamar al hook
            $class = @include $data['dir'] . $data['arch'];
            
            // Pamatros
            if (!$data['params_class']){
                $call = new $data['class']();
                } else {
                    $call = new $data['class']($data['params_class']);
                }
                
            // Funcion
            if (!$data['params_class'] and $data['function']){
                $callf = $call->$data['function']();
                } else {
                    $callf = $call->$data['function']($data['params_function']);
                }               
        }
     }
    /**
     * Funcion para el interfaz del plugin
     * modPl::install()
     * 
     * @param string $plug_name
     * @return void
     */     
    protected function install(mod_pl $pluginClass){
        $pluginClass->install();       
    }
    /**
     * Funcion para el interfaz del plugin
     * modPl::body()
     * 
     * @param string $plug_name
     * @return void
     */     
    protected function body(mod_pl $pluginClass){
        $pluginClass->exec();       
    }
    /**
     * Funcion para el interfaz del plugin
     * modPl::pre_exec()
     * 
     * @param string $plug_name
     * @return void
     */     
    protected function pre_exec(mod_pl $pluginClass){
        $pluginClass->pre_exec();       
    }
    /**
     * Funcion para el interfaz del plugin
     * modPl::end()
     * 
     * @param string $plug_name
     * @return void
     */     
    protected function end(mod_pl $pluginClass){
        $pluginClass->end();       
    }
    /**
     * Funcion para correr los plugins
     * modPl::run()
     * 
     * @param string $plug_name
     * @return void
     */      
    public function run($filename = 'game', $get_run = 'page'){
          
        // Solo se ejecutara dentro de $filename.php
        $self = $this->get_selfile();
        if ($self != $filename) return;
                
        // Ejecutar el metodo set_hook()
        foreach($this->exec as $ID => $Plugin){
            $plug_class = $Plugin . '_mod';
            if (!class_exists($plug_class)) continue;
            $plug_get   = new $plug_class();      
            $this->pre_exec($plug_get);      
        }
        
        //Hooks post_pre_exec
        $this->run_hooks('post_pre_exec');
        
        // Intentar correr algun plugin
        if (isset($_GET[$get_run]) AND in_array($_GET[$get_run], $this->exec)){
            $GLOBALS['run_plug'] = true;
            $plug_class = $_GET[$get_run] . '_mod';
            $plug_get   = new $plug_class();
            $this->run_hooks('post_construct');
            
            // Correr plugin
            if (!isset($game_config['mod_plug'][$name_class])) $this->install($plug_get);
            $this->run_hooks('post_install');
            $this->body($plug_get);
            $this->run_hooks('post_plugin');
            $this->end($plug_get);
     
        } else if(in_array($_GET[$get_run], $this->haccess)) {
            $GLOBALS['run_plug'] = true;
            $plug_class = $this->hraccess[$_GET[$get_run]] . '_mod';
            $plug_get   = new $plug_class();
            $this->run_hooks('post_construct');
            
            // Correr plugin
            if (!isset($game_config['mod_plug'][$name_class])) $this->install($plug_get);
            $this->run_hooks('post_install');
            $this->body($plug_get);
            $this->run_hooks('post_plugin');
            $this->end($plug_get);            
        }
    }
    
    /**
     * Crea una ruta nueva mediante hack_access
     * modPl::hack_access()
     * 
     * @param string $plugin
     * @param string $new
     * @return void
     */
    protected function hack_access($plugin = '', $new = ''){
        
        // Agregar
        $this->haccess[] = $new;
        
        // Rutas
        $this->hraccess[$new] = $plugin;
               
    }
    
    /**
     * Crea un sistema de llamadas
     * modPl::create_get_access()
     * 
     * @param mixed $get_param
     * @return void
     */
    protected function create_get_access(){
        
        // Parametros
        $params = func_num_args();
        
        // Variables
        $this->get_access = array();
        
        // Tipo 0
        if ($params <= 1) return false;
        
        // Tipo 1
        if ($params == 2){
            if (!is_array(func_get_arg(1))){
                $this->get_access[] = func_get_arg(1);
                $this->run_access(func_get_arg(0));
            } else {
                foreach(func_get_arg(1) as $ID => $access){
                    $this->get_access[] = $access;           
                }
                $this->run_access(func_get_arg(0));
            }
        }
        // Tipo 2
        if ($params > 2){
            $arg_list = func_get_args();
            for ($i = 0; $i < $params; $i++) {
                $this->get_access[] = $arg_list[$i];
            }
            $this->run_access(func_get_arg(0));
        }        
    }
    
    /**
     * Correr los metodos!
     * modPl::run_access()
     * 
     * @param string $mvar
     * @return void
     */
    protected function run_access($mvar = ''){     
        
        // Metodo
        $method = $mvar . '_' . $_GET[$mvar];
        
        // Comprobar
        if (!in_array($_GET[$mvar], $this->get_access)) return;
        
        if (empty($_GET[$mvar]) AND in_array('default', $this->get_access)) $method = $mvar . '_default';
        
        // Llamar
        $this->$method();        
    }
    
    /**
     * Declara una pagina de administracion
     * modPl::protect_admin()
     * 
     * @return void
     */
    public function protect($Level){
        global $user;
        
        if (!$user or $user['authlevel'] > $Level){
            $this->stop_exec('No tiene los suficientes permisos para acceder!');
        }
        
    }
    
    /**
     * Detiene la ejecucion
     * modPl::stop_exec()
     * 
     * @param string $reason
     * @return void
     */
    public function stop_exec($reason = ''){
        
        // Mensaje
        message($reason);
        exit;
        
    }
    /**
     * Funcion para correr los plugins
     * modPl::run()
     * 
     * @param string $name_class
     * @return void
     */ 
     protected function install_basic($name_class){
        
        // Comprobar
        if (empty($this->pconf[$name_class])){ 
            
            // Instalar la configuracion
            $this->db->query("INSERT INTO ".PLUGINS." SET plugin = '".$name_class."', status = 1");           
        }
     }  
     
     /**
      * Llama a archivos necesarios para el juego
      * modPl::call_default()
      * 
      * @return void
      */
     protected function call($name){
        global $xgp_root, $phpEx;
        
        // Fundamentos para una pagina del juego
        include_once(ROOT_PATH.'includes/functions/'.$name.'.'.PHP_EXT);   
     }
     
     /**
      * Agrega un elemento al menu lateral
      * modPl::menu_set()
      * 
      * @param integer $pos
      * @param string  $title
      * @param string  $ref
      * @return void
      */
      protected function menu_set($pos = 1, $title, $ref){
        global $lang;
        
        $pos_hack = array();
        $pos_hack[1] = 'lm_defenses';
        $pos_hack[2] = 'lm_search';
        $pos_hack[3] = 'lm_options';
        $pos_hack[10]= 'mu_connected';
        
        // Admin o no
        if ($pos >= 10)
        	$lang[$pos_hack[$pos]] .= '</a></th></tr><tr><th "onMouseOver="this.className="ForIEHover" onMouseOut="this.className="ForIE" class="ForIE"><a href="'.$ref.'" target="Hauptframe">'.$lang[$title];    
		else
			$lang[$pos_hack[$pos]] .= '</font></a></div></td></tr><tr><td><div align="center"><a href="'.$ref.'"><font color="white">'.$lang[$title];
      }
     /**
      * Procesa un archivo de lenguas
      * modPl::lang_txt()
      * 
      * @param string  $archive
      * @param string  $lang
      * @return void
      */
      protected function lang_txt($archive, $lang = 'de'){
			includeLang('plugins/'.$archive);          
      }
    
 }

?> 