<?php


function ShowMultiIPPage()
{
	global $LNG, $db;
	$Query	= $db->query("SELECT id, username, user_lastip FROM uni1_users WHERE (user_lastip) IN (SELECT user_lastip FROM uni1_users GROUP BY user_lastip HAVING COUNT(*)>1) ORDER BY user_lastip ASC;");
	$IPs	= array();
	while($Data = $db->fetch_array($Query)) {
		if(!isset($IPs[$Data['user_lastip']]))
			$IPs[$Data['user_lastip']]	= array();
		
		$IPs[$Data['user_lastip']][]	= array($Data['username'], $Data['id']);
	}
	$template	= new template();
	$template->assign_vars(array(
		'IPs'	=> $IPs
	));
	$template->show('adm/MultiIPs.tpl');
}


?>