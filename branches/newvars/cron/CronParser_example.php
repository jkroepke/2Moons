<?php /* $Id$ */

/*
This is my cron checking script. It won't run by itself as it depends on
many other function and class files.

I include it here for you to use as a template for rolling out your own.

The table I use to store all the scheduled tasks:

CREATE TABLE `cron` (
  `cron_id` int(10) unsigned NOT NULL auto_increment,
  `task` char(100) NOT NULL default '',
  `active` tinyint(1) NOT NULL default '-1',
  `mhdmd` char(255) NOT NULL default '',
  `file` char(100) NOT NULL default '',
  `ran_at` int(11) NOT NULL default '0',
  `ok` tinyint(4) NOT NULL default '0',
  `log_level` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`cron_id`)
) ENGINE=MyISAM;

INSERT INTO `cron` VALUES (NULL, 'Fetch vendor data feed', -1, '55 8,10,12,14,16,18 * * 1-5', './cron/vendor_data_import.php', 0, 1, -1);
...


*/


$templates = array('cron_email_despatched');
define('TPL_DONE', true);
require_once('./config.php');
require_once(BASE_DIR . 'classes/CronParser.php');

//DEBUG can be 'print' or 'email', or ''
//define('DEBUG', 'email');

$cron = new CronParser();

$crontasks = $db->query("
	SELECT * FROM $settings[table_cron]
	WHERE active <> 0
");

while ($crontask = $db->fetch_array($crontasks))
{
	log_debug("Processing cron task '$crontask[task]'");

	//if one of cron crashed, send alert email
	if ($crontask['ok'] == false)
	{
		send_alert_email("A cron task was failed", "'$crontask[task]' crashed when we tried to run it.");
	}

	if ($cron->calcLastRan($crontask['mhdmd']))
	{
		//0=minute, 1=hour, 2=dayOfMonth, 3=month, 4=week, 5=year
		$lastRan = $cron->getLastRan();
		$my_logs = '';

		//log_debug($cron->getDebug());

		if ($cron->getLastRanUnix() > $crontask['ran_at'])
		{
			log_debug("'$crontask[task]' \r\ndue to be run at: $lastRan[5]-$lastRan[3]-$lastRan[2] $lastRan[1]:$lastRan[0]\r\nlast ran at: " . date('Y-m-d H:i:s', $crontask['ran_at']) . "\r\nTime now is: " . date('Y-m-d H:i:s'));
			log_debug("Begin processing '$crontask[task]'");

			//log the time we start this cron
			$db->query("
				UPDATE $settings[table_cron]
				SET ran_at = " . time() . ", ok = false
				WHERE cron_id = $crontask[cron_id]
			");

			run_cron_task($crontask['file']);

			if ($crontask['log_level'] AND $my_logs)
			{
				log_debug($my_logs);

				$db->query("
					INSERT INTO $settings[table_cron_log]
					SET log = '" . addslashes($my_logs) . "', cron_id = $crontask[cron_id], log_time = " . time()
				);
			}

			//completed the cron task
			$db->query("
				UPDATE $settings[table_cron]
				SET ok = true
				WHERE cron_id = $crontask[cron_id]
			");
		}
		else
		{
			log_debug("'$crontask[task]' is not due.\r\nLast due at: $lastRan[5]-$lastRan[3]-$lastRan[2] $lastRan[1]:$lastRan[0]\r\nlast ran at: " . date('Y-m-d H:i:s', $crontask['ran_at']) . "\r\nTime now is: " . date('Y-m-d H:i:s'));
		}

	}
	else
	{
		log_debug("Unable to calculate LastRan for cron id: $crontask[cron_id]");
	}
}

function run_cron_task($file)
{
	global $db, $settings, $my_logs;
	//require_once will halt on error, include_once only gives warning.
	include_once($file);
}

debug_this();
?>