<?php
class premium_mod extends modPl implements mod_pl{
    public function install(){
        parent::install_basic('premium');
             
    }
    public function exec()
	{
		$CurrentUser	= $GLOBALS['user'];
		$CurrentPlanet	= $GLOBALS['planetrow'];
		$PlanetRess = new ResourceUpdate($CurrentUser, $CurrentPlanet);

		$template	= new template();

		$template->set_vars($CurrentUser, $CurrentPlanet);
		$template->page_header();
		$template->page_topnav();
		$template->page_leftmenu();
		$template->page_planetmenu();
		$template->page_footer();
		$template->show("plugins/premium_overview.tpl");
		$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);     
        
    }
    public function end(){ 
               
    }
    public function pre_exec(){
        global $game_config;
        parent::lang_txt('premium');
		parent::menu_set(2, 'lm_premium', 'game.php?page=premium');
	}    
    
}

?>