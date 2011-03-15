<?php
function ShowPremium()
{
	global $USER, $CONF, $LNG, $db;
		
		$PlanetRess = new ResourceUpdate();
		$PlanetRess->CalcResource();
		$PlanetRess->SavePlanetToDB();
		
		$template= new template();
		
		$reflink="http://localhost/2moons/index.php?page=reg&id=".$USER['id']."";
				
		if(empty($USER['premium_aktiv'])){
			$premium_aktiv 	= $LNG['premium_deaktiv'];
			$aktiv = 0;
		}else{
			$premium_aktiv	= date('d.m.Y - H:i:s',$USER['premium_aktiv']);
			$premium_deaktiv= " bis ".date('d.m.Y - H:i:s',$USER['premium_deaktiv']);
			$aktiv = 1;
		}
			
		$template->assign_vars(array(
		'premium_aktiv'		=> $aktiv,
		'premiums'			=> $LNG['premiums'],
		'premium_ress'		=> $LNG['premium_ress'],
		'um'				=> $LNG['um'],
		'erweitert'			=> $LNG['erweitert'],
		'verringert'		=> $LNG['verringert'],
		'mehr_ress'			=> $CONF['mehr_ress'],
		'weniger_build'		=> $CONF['bauzeit_build'],
		'weniger_defense'	=> $CONF['bauzeit_defense'],
		'weniger_fleet'		=> $CONF['bauzeit_fleet'],
		'premium_build'		=> $LNG['premium_build'],
		'premium_defense'	=> $LNG['premium_defense'],
		'premium_fleet'		=> $LNG['premium_fleet'],
		'niedriger'			=> $LNG['niedriger'],
		'user_reflink'		=> $reflink,
		'ov_reflink'		=> $LNG['ov_reflink'],
		'aktiv'				=> $LNG['aktiv'],
		'deaktiv'			=> $LNG['deaktiv'],
		'premium'			=> $LNG['premium'],
		'premium_zeit'		=> $LNG['premium_zeit'],
		'premium_zeits'		=> $premium_aktiv,
		'premium_deaktiv'	=> $premium_deaktiv,	
		));
	$template->show("premium.tpl");
}
?>