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
	function send($mailTarget, $mailTargetName, $mailSubject, $mailContent)
	{		
		$mail	= self::getMailObject();
		
		$mailFromAdress	= Config::get('smtp_sendmail');
		$mailFromName	= Config::get('game_name');
			 
        $mail->CharSet          = 'UTF-8';              
        $mail->Subject          = $mailSubject;
        $mail->Body             = $mailContent;
        $mail->SetFrom($mailFromAdress, $mailFromName);
        $mail->AddAddress($mailTarget, $mailTargetName);
        $mail->Send(); 
	}
	
	function multiSend($mailTargets, $mailSubject, $mailContent = NULL)
	{
		$mail	= self::getMailObject();
		
		$mailFromAdress	= Config::get('smtp_sendmail');
		$mailFromName	= Config::get('game_name');
			 
        $mail->CharSet          = 'UTF-8';         
        $mail->SetFrom($mailFromAdress, $mailFromName);     
        $mail->Subject          = $mailSubject;
			 
		foreach($mailTargets as $address => $data)
		{
			$content = isset($data['body']) ? $data['body'] : $mailContent;
			
			$mail->AddAddress($address, $data['username']);
			$mail->MsgHTML($content);
			$mail->Send(); 
			$mail->ClearAddresses();
		}
	}
	
	function getMailObject()
	{
        require 'includes/libs/phpmailer/class.phpmailer.php';
        $mail                   = new PHPMailer(true);
		$mail->PluginDir		= 'includes/libs/phpmailer/';
		
        if(Config::get('mail_use') == 2) {
			$mail->IsSMTP();  
			$mail->SMTPSecure       = Config::get('smtp_ssl');                                            
			$mail->Host             = Config::get('smtp_host');
			$mail->Port             = Config::get('smtp_port');
			
			if(Config::get('smtp_user') != '')
			{
				$mail->SMTPAuth         = true; 
				$mail->Username         = Config::get('smtp_user');
				$mail->Password         = Config::get('smtp_pass');
			}
        } elseif(Config::get('mail_use') == 0) {
			$mail->IsMail();
        } else {
			throw new Exception("Sendmail is deprecated, use SMTP instaed!");
		}
		
		return $mail;
	}
}