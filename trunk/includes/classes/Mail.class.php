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
	static public function send($mailTarget, $mailTargetName, $mailSubject, $mailContent)
	{		
		$mail	= self::getMailObject();
			 
        $mail->CharSet	= 'UTF-8';
        $mail->Subject	= $mailSubject;
        $mail->Body		= $mailContent;
        $mail->AddAddress($mailTarget, $mailTargetName);
        $mail->Send(); 
	}

	static public function multiSend($mailTargets, $mailSubject, $mailContent = NULL)
	{
		$mail	= self::getMailObject();

		$mail->Subject	= $mailSubject;

		foreach($mailTargets as $address => $data)
		{
			$content = isset($data['body']) ? $data['body'] : $mailContent;
			
			$mail->AddAddress($address, $data['username']);
			$mail->MsgHTML($content);
			$mail->Send(); 
			$mail->ClearAddresses();
		}
	}

	static private function getMailObject()
	{
        require 'includes/libs/phpmailer/class.phpmailer.php';

        $mail               = new PHPMailer(true);
		$mail->PluginDir	= 'includes/libs/phpmailer/';

		$config				= Config::get();

        if($config->mail_use == 2) {
			$mail->IsSMTP();  
			$mail->SMTPSecure       = $config->smtp_ssl;                                            
			$mail->Host             = $config->smtp_host;
			$mail->Port             = $config->smtp_port;
			
			if($config->smtp_user != '')
			{
				$mail->SMTPAuth         = true; 
				$mail->Username         = $config->smtp_user;
				$mail->Password         = $config->smtp_pass;
			}
        } elseif($config->mail_use == 0) {
			$mail->IsMail();
        } else {
			throw new Exception("sendmail is deprecated, use SMTP instead!");
		}

		$mailFromAddress	= $config->smtp_sendmail;
		$mailFromName		= $config->game_name;

		$mail->CharSet	= 'UTF-8';
		$mail->SetFrom($mailFromAddress, $mailFromName);
		
		return $mail;
	}
}