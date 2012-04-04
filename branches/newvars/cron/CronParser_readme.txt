CronParser Class initial release Version 1.0
11 Sep 2005 by Nikol S ns@eyo.com.au


CronParser Class
================
This class is based on the concept in the CronParser class written by Mick Sear http://www.ecreate.co.uk

I discovered some major bugs in the original class and decided to fix, but ended up re-coding
roughly the entire class.

This class has eliminated the need for php calendar extension.
Despite all the flows are now different from the original, the calling function name remains the
same. This should make it easy for existing users to try out this class.


Who can use this class?
=======================
This class is idea for people who can not use the traditional Unix cron through shell.
It is not possible to expect all the users of your php scripts can use crontab. By bundling
your software with a cron parser like this one. Planning a scheduled task can be as easy as
making an entry through a web form.

Features
========
Accept traditional Unix crontab format, format including comma separated and range etc.
	It can parse a complicated cron string like:
	0,12,30-51 3,21-23,10 1-25 9-12,1 0,3-7

Calculate the last due time based on the cron to be parsed. For a very complicated combination
of cron string, the last run time could be hours ago, or even a few years ago. Knowing the last due
time, and comparing with the last run time (recommending log last run time when invoking scheduled
tasks). We know whether the scheduled task is due to be run again.

Detects and sometimes corrects errors a cron to be parsed.
Automatically removes overlapping or duplicating data entry. eg. 1-6,3,7
Ignore impossible range entry. eg. 13 for month or 8 for weekday.
Detects if the cron string contains invalid characters.
Detects if format for the cron string contains error.
Mapping weekday 7 to 0 for Sunday.

Usage
=====
Generally there are three public functions can be called:

$cron->calcLastRan($cron_string)
Each time this function is called with a cron string. It calculates the last due time.

$cron->getLastRanUnix()
Returns the last due time in Unix timestamp format

$cron->getLastRan()
Returns the last due time in an array
(0=minute, 1=hour, 2=dayOfMonth, 3=month, 4=week, 5=year)


To Test
=======

$cron_str0 = "0,12,30-51 3,21-23,10 1-25 9-12,1 0,3-7";
require_once("CronParser.php");
$cron = new CronParser();
$cron->calcLastRan($cron_str0);
// $cron->getLastRanUnix() returns an Unix timestamp
echo "Cron '$cron_str0' last due at: " . date('r', $cron->getLastRanUnix()) . "<p>";
// $cron->getLastRan() returns last due time in an array
print_r($cron->getLastRan());
echo "Debug:<br>" . nl2br($cron->getDebug());

$cron_str1 = "3 12 * * *";
if ($cron->calcLastRan($cron_str1))
{
   echo "<p>Cron '$cron_str1' last due at: " . date('r', $cron->getLastRanUnix()) . "<p>";
   print_r($cron->getLastRan());
}
else
{
   echo "Error parsing";
}
echo "Debug:<br>" . nl2br($cron->getDebug());

==============================================================================================

Actual Usage
============

It is best to create a table storing all the scheduled tasks. eg.

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

By regularly checking the last due run time, we decide whether to run a certain scheduled task.

One way of running a checking script is embedding a calling script in one of the image tags.

"<img src='http://your.site/my_cron.php' alt='' width='1' height='1'>";

in my_cron.php
Have
header('Location: http://your.site/clear.gif');
then use register_shutdown_function() to call a checking script.

For a busy page, you might want to include some random mechanism to prevent the parser to be called too often.



License: GPL
By Nikol S
Please send bug reports to ns@eyo.com.au
