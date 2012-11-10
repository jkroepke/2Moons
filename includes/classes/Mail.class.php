<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package 2Moons
 * @author Jan <info@2moons.cc>
 * @copyright 2006 Perberos <ugamela@perberos.com.ar> (UGamela)
 * @copyright 2008 Chlorel (XNova)
 * @copyright 2009 Lucky (XGProyecto)
 * @copyright 2012 Jan <info@2moons.cc> (2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 2.0 (2012-11-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class Mail
{	
	function send($MailTarget, $MailTargetName, $MailSubject, $MailContent)
	{		
		$transport	= self::getSwiftTranspor();
		$mailer 	= Swift_Mailer::newInstance($transport);
		
		$mailFrom	= Config::get('smtp_sendmail');
		$mailTo		= Config::get('game_name');
					
		$mail = Swift_Message::newInstance();
		$mail->setSubject($MailSubject)
			 ->setFrom(array($mailFrom => $mailTo))
			 ->setTo(array($MailTarget => $MailTargetName))
			 ->setBody($MailContent);
			 
		$mailer->send($mail);
	}
	
	function multiSend($MailTargets, $MailSubject, $MailContent = NULL)
	{
		$transport	= self::getSwiftTranspor();
		$mailer 	= Swift_Mailer::newInstance($transport);
		
		$mailFrom	= Config::get('smtp_sendmail');
		$mailTo		= Config::get('game_name');
					
		$mail		= Swift_Message::newInstance();
		$mail->setSubject($MailSubject)
			 ->setFrom(array($mailFrom => $mailTo));
			 
		foreach($MailTargets as $address => $data)
		{
			$content = isset($data['body']) ? $data['body'] : $MailContent;
			$mail->setTo(array($address => $data['username']))
				 ->setBody(strip_tags($content))
				 ->addPart($content, 'text/html');
				 
			$mailer->send($mail);
		}
	}
	
	function getSwiftTranspor()
	{
		require_once(ROOT_PATH.'includes/libs/swift/swift_required.php');
		
		if(Config::get('mail_use') == 2)
		{
			$transport = Swift_SmtpTransport::newInstance(Config::get('smtp_host'), Config::get('smtp_port'));
			
			if(Config::get('smtp_ssl') == 'ssl' || Config::get('smtp_ssl') == 'tls')
			{
				$transport->setEncryption(Config::get('smtp_ssl'));
			}
			
			if(Config::get('smtp_user') != '')
			{
				$transport->setUsername(Config::get('smtp_user'));
				$transport->setPassword(Config::get('smtp_pass'));
			}
		}
		elseif(Config::get('mailMethod') == 0)
		{
			$transport = Swift_MailTransport::newInstance();
		}
		
		return $transport;
	}
}