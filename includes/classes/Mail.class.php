<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan <info@2moons.cc>
 * @copyright 2006 Perberos <ugamela@perberos.com.ar> (UGamela)
 * @copyright 2008 Chlorel (XNova)
 * @copyright 2009 Lucky (XGProyecto)
 * @copyright 2012 Jan <info@2moons.cc> (2Moons)
 * @licence MIT
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
        require_once 'includes/libs/phpmailer/class.phpmailer.php';

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