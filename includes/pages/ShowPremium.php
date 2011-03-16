<?php
function ShowPremium()
{
	global $USER, $CONF, $LNG, $db;
		
	$PlanetRess = new ResourceUpdate();
	$PlanetRess->CalcResource();
	$PlanetRess->SavePlanetToDB();
	
	$template = new template();
		
	$reflink	= PROTOCOL.$_SERVER['HTTP_HOST'].HTTP_ROOT."index.php?page=reg&id=".$USER['id'];
		
	if(TIMESTAMP - $USER['premium_aktiv'] <= 0){
		$premium_aktiv 	= $LNG['premium_deaktiv'];
		$aktiv = sprintf($LNG['premium'],$LNG['deaktiv']);
	}else{
		$premium_aktiv	= date(TDFORMAT,$USER['premium_aktiv']);
		$aktiv = sprintf($LNG['premium'],$LNG['aktiv']);
	}
		
	$template->assign_vars(array(
		'premiums'			=> $LNG['premiums'],
		'premium_ress'		=> $LNG['premium_ress'],
		'mehr_ress'			=> sprintf($LNG['mehr_ress'],$CONF['mehr_ress']."%"),
		'erweitert'			=> $LNG['erweitert'],
		'bauzeit_building'	=> sprintf($LNG['bauzeit_verringert'],$CONF['bauzeit_build']."%"),
		'bauzeit_defense'	=> sprintf($LNG['bauzeit_verringert'],$CONF['bauzeit_defense']."%"),
		'bauzeit_fleet'		=> sprintf($LNG['bauzeit_verringert'],$CONF['bauzeit_fleet']."%"),
		'premium_build'		=> $LNG['premium_build'],
		'premium_defense'	=> $LNG['premium_defense'],
		'premium_fleet'		=> $LNG['premium_fleet'],
		'user_reflink'		=> $reflink,
		'ov_reflink'		=> $LNG['ov_reflink'],
		'premium'			=> $aktiv,
		'premium_zeit'		=> $LNG['premium_zeit'],
		'premium_aktiv'		=> $premium_aktiv,
	));
	$template->show("premium.tpl");
}
?>