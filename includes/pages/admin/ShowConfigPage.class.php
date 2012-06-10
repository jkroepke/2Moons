<?php

/**
 *  2Moons
 *  Copyright (C) 2011  Slaver
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
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <lucky@xgproyect.net> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.5 (2011-05-04)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class ShowConfigPage extends AbstractPage
{
	private $configArray = array();
	private $validates	= array();
	
	function __construct() 
	{
		global $LNG;
		parent::__construct();
		
		$this->validates = array(
			'teamspeak'	=> 'checkTeamSpeak',
			'mail'		=> 'checkSiteMail',
			'captcha'	=> 'checkSiteReCaptcha',
			'facebook'	=> 'checkSiteFacebook',
		);
		
		$this->mode = array(
			'universe'	=> 'uniConfig',
			'economy'	=> 'uniConfig',
			'planet'	=> 'uniConfig',
			'fleet'		=> 'uniConfig',
			'trader'	=> 'uniConfig',
			'highscore'	=> 'uniConfig',
		
			'general'	=> 'gameConfig',
			'user'		=> 'gameConfig',
			'teamspeak'	=> 'gameConfig',
			'mail'		=> 'gameConfig',
			'captcha'	=> 'gameConfig',
			'chat'		=> 'gameConfig',
			'facebook'	=> 'gameConfig',
			'analytics'	=> 'gameConfig',
			'disclamer'	=> 'gameConfig',
		);
		
		$this->configArray = array(
			'universe' => array(
				'uniName' => array(
					'type' => 'string',
				),
				'disabled' => array(
					'type' => 'bool',
				),
				'disableReason' => array(
					'type' => 'textarea',
				),
				'disableRegistration' => array(
					'type' => 'bool',
				),
				'planetMaxGalaxy' => array(
					'type' => 'int',
				),
				'planetMaxSystem' => array(
					'type' => 'int',
				),
				'planetMaxPosition' => array(
					'type' => 'int',
				),
				'gameSpeed' => array(
					'type' => 'int',
				),
				'fleetSpeed' => array(
					'type' => 'int',
				),
				'ecoSpeed' => array(
					'type' => 'int',
				),
				'expeditionSpeed' => array(
					'type' => 'int',
				),
				'storageFactor' => array(
					'type' => 'int',
				),
				'newsEnable' => array(
					'type' => 'bool',
				),
				'newsText' => array(
					'type' => 'textarea',
				),
			),
			'economy' => array(
				'planetResource901BasicIncome' => array(
					'type' => 'int',
				),
				'planetResource902BasicIncome' => array(
					'type' => 'int',
				),
				'planetResource903BasicIncome' => array(
					'type' => 'int',
				),
				'planetResource911BasicIncome' => array(
					'type' => 'int',
				),
				'planetResource921BasicIncome' => array(
					'type' => 'int',
				),
				'planetResource901Start' => array(
					'type' => 'int',
				),
				'planetResource902Start' => array(
					'type' => 'int',
				),
				'planetResource903Start' => array(
					'type' => 'int',
				),
				'planetResource911Start' => array(
					'type' => 'int',
				),
				'planetResource921Start' => array(
					'type' => 'int',
				),
				'listMaxBuilds' => array(
					'type' => 'int',
				),
				'listMaxResearch' => array(
					'type' => 'int',
				),
				'listMaxShipyard' => array(
					'type' => 'int',
				),
				'listMaxUnits' => array(
					'type' => 'int',
				),
				'ecoResourceOverflow' => array(
					'type' => 'int',
					'max' => 100,
					'unit' => 'se_unit_percent'
				),
				'buildMinBuildTime' => array(
					'type' => 'int',
				),
				'shipyardCancelCharge' => array(
					'type' => 'int',
					'max' => 100,
					'unit' => 'se_unit_percent'
				),
			),
			'planet' => array(
				'rocketStorageFactor' => array(
					'type' => 'int',
				),
				'planetColonizeSizeFactor' => array(
					'type' => 'int',
				),
				'planetFieldsMainPlanet' => array(
					'type' => 'int',
				),
				'planetMoonSizeFactor' => array(
					'type' => 'int',
				),
				'planetMoonCreateChanceFactor' => array(
					'type' => 'int',
				),
				'planetMoonCreateMaxFactor' => array(
					'type' => 'int',
					'max' => 100,
					'unit' => 'se_unit_percent'
				),
				'planetHoldDebrisOnMoonCreate' => array(
					'type' => 'int',
				),
				'planetJumpWaitTime' => array(
					'type' => 'int',
				),
				'planetAddFieldsByMoonBase' => array(
					'type' => 'int',
				),
				'planetAddFieldsByTerraFormer' => array(
					'type' => 'int',
				),
				'userMinPlanets' => array(
					'type' => 'int',
				),
				'userMaxPlanets' => array(
					'type' => 'int',
				),
				'galaxyNavigationDeuterium' => array(
					'type' => 'int',
				),
				'phalanxCost' => array(
					'type' => 'int',
				),
			),
			'fleet' => array(
				'attackBashEnable' => array(
					'type' => 'bool',
				),
				'attackBashAllowAttack' => array(
					'type' => 'int',
				),
				'attackBashInTime' => array(
					'type' => 'int',
					'unit' => 'se_unit_hour',
				),
				'attackMaxRounds' => array(
					'type' => 'int',
				),
				'fleetToDebris' => array(
					'type' => 'int',
					'unit' => 'se_unit_percent',
				),
				'defenseToDebris' => array(
					'type' => 'int',
					'unit' => 'se_unit_percent',
				),
				'fleetLimitDMMissions' => array(
					'type' => 'int',
				),
				'fleetMaxUsersPerACS' => array(
					'type' => 'int',
				),
				'noobProtectionEnable' => array(
					'type' => 'int',
				),
				'noobProtectionAllowStrong' => array(
					'type' => 'int',
				),
				'noobProtectionToPoints' => array(
					'type' => 'int',
					'unit' => 'se_unit_points',
				),
				'noobProtectionRange' => array(
					'type' => 'float',
				),
			),
			'trader' => array(
				'traderFleetCharge' => array(
					'type' => 'int',
					'unit' => 'se_unit_percent',
				),
				'traderResourceCost' => array(
					'type' => 'int',
					'unit' => 'tech.921',
				),
				/* 'traderResourceCharge' => array(
					'type' => 'int',
				), */
				'traderFleetData' => array(
					'type' => 'multi',
					'selection' => ArrayUtil::combineArrayWithKeyElements(array_merge($GLOBALS['VARS']['LIST'][ELEMENT_FLEET], $GLOBALS['VARS']['LIST'][ELEMENT_DEFENSIVE]), $LNG['tech']),
				),
			),
			'general'	=> array(
				'gameName' => array(
					'type' => 'string',
				),
				'boardAddress' => array(
					'type' => 'string',
					'validate' => 'url',
				),
				'adminProtection' => array(
					'type' => 'bool',
				),
				'language' => array(
					'type' => 'array',
					'selection' => Language::getAllowedLangs(false),
				),
				'timezone' => array(
					'type' => 'array',
					'selection' => DateUtil::getTimezones(),
				),
				'enableSimulatorLink' => array(
					'type' => 'bool',
				),
				'bannerFontFile' => array(
					'type' => 'string',
					'validate' => 'validateTTF',
				),
				'deleteOldData' => array(
					'type' => 'int',
					'unit' => 'se_unit_day'
				),
				'deleteMarkedUser' => array(
					'type' => 'int',
					'unit' => 'se_unit_day'
				),
				'deleteInactiveUser' => array(
					'type' => 'int',
					'unit' => 'se_unit_day'
				),
				'deleteFleetLogs' => array(
					'type' => 'int',
					'unit' => 'se_unit_day'
				),
			),
			'user' => array(
				'userAllowOneNameChangeInHour' => array(
					'type' => 'int',
					'unit' => 'se_unit_hour',
				),
				'userInactiveSinceDays' => array(
					'type' => 'int',
					'unit' => 'se_unit_day',
				),
				'userInactiveLongSinceDays' => array(
					'type' => 'int',
					'unit' => 'se_unit_day',
				),
				'inactiveMailEnable' => array(
					'type' => 'bool',
					'validate' => 'mailActive'
				),
				'inactiveMailAfterDays' => array(
					'type' => 'int',
					'unit' => 'se_unit_day',
				),
				'userVacationEnable' => array(
					'type' => 'bool',
				),
				'userMinVacationTime' => array(
					'type' => 'int',
					'unit' => 'se_unit_day',
				),
				'userMaxVacationTime' => array(
					'type' => 'int',
					'unit' => 'se_unit_day',
				),
				'userVertification' => array(
					'type' => 'bool',
					'validate' => 'mailActive'
				),
				'referralEnable' => array(
					'type' => 'bool',
				),
				'referralBonus'  => array(
					'type' => 'int',
				),
				'referralMinimumPoints' => array(
					'type' => 'int',
				),
				'referralLimit' => array(
					'type' => 'int',
				),
			),
			'highscore' => array(
				'highscoreAdminEnable' => array(
					'type' => 'array',
					'selection' => ArrayUtil::combineArrayWithKeyElements(array(0, 1, 2), $LNG['se_values_highscoreAdminEnable']),
				),
				'highscoreAdminFromLevel' => array(
					'type' => 'array',
					'selection' => ArrayUtil::combineArrayWithKeyElements(array(1, 2, 3), $LNG['user_level']),
				),
				'highscoreBannedEnable' => array(
					'type' => 'bool',
				),
				'highscorePointsPerResource' => array(
					'type' => 'int',
				),
			),
			'teamspeak'	=> array(
				'teamspeakEnable' => array(
					'type' => 'bool',
				),
				'teamspeakServerAdress' => array(
					'type' => 'string',
					'validate' => 'ipOrDsn',
				),
				'teamspeakUDPPort' => array(
					'type' => 'int',
				),
				'teamspeakServerQueryPort' => array(
					'type' => 'int',
				),
				'teamspeakServerQueryUser' => array(
					'type' => 'string',
				),
				'teamspeakServerQueryPassword' => array(
					'type' => 'string',
				),
			),
			'mail' => array(	
				'mailEnable' => array(
					'type' => 'bool',
				),
				'mailMethod' => array(
					'type' => 'array',
					'selection' => ArrayUtil::combineArrayWithKeyElements(array('mail', 'smtp'), $LNG['se_values_mailMethod']),
				),
				'mailSmtpAdress' => array(
					'type' => 'string',
					'validate' => 'ipOrDsn',
				),
				'mailSmtpPort' => array(
					'type' => 'int',
				),
				'mailSmtpUser' => array(
					'type' => 'string',
				),
				'mailSmtpPass' => array(
					'type' => 'string',
				),
				'mailSmtpSecure' => array(
					'type' => 'array',
					'selection' => ArrayUtil::combineArrayWithKeyElements(array('none', 'tls', 'ssl'), $LNG['se_values_mailSmtpSecure']),
				),
				'mailSenderMail' => array(
					'type' => 'string',
					'validate' => 'mail',
				),
			),
			'captcha' => array(					
				'recaptchaEnable' => array(
					'type' => 'bool',
				),
				'recaptchaPublicKey' => array(
					'type' => 'string',
				),
				'recaptchaPrivateKey' => array(
					'type' => 'string',
				),
			),
			'chat' => array(
				'chatEnable' => array(
					'type' => 'bool',
				),
				'chatAllowOwnChannel' => array(
					'type' => 'bool',
				),
				'chatAllowPrivateMessage' => array(
					'type' => 'bool',
				),
				'chatAllowDeleteOwnMessage' => array(
					'type' => 'bool',
				),
				'chatEnableLog' => array(
					'type' => 'bool',
				),
				'chatAllowNameChange' => array(
					'type' => 'bool',
				),
				'chatBotName' => array(
					'type' => 'string',
				),
				'chatChannelName' => array(
					'type' => 'string',
				),
			),
			'facebook' => array(
				'facebookEnable' => array(
					'type' => 'bool',
				),
				'facebookAPIKey' => array(
					'type' => 'string',
				),
				'facebookSecureKey' => array(
					'type' => 'string',
				),
			),
			'analytics' => array(
				'analyticsEnable' => array(
					'type' => 'bool',
				),
				'analyticsUID' => array(
					'type' => 'string',
				),
			),
			'disclamer' => array(
				'disclamerAddress' => array(
					'type' => 'textarea',
				),
				'disclamerPhone' => array(
					'type' => 'string',
				),
				'disclamerMail' => array(
					'type' => 'string',
				),
				'disclamerNotice' => array(
					'type' => 'textarea',
				),
			)
		);
	}
	
	function show()
	{
		global $LNG, $uniConfig, $gameConfig;
		
		$section	= HTTP::_GP('section', '');
		if(!isset($this->configArray[$section]))
		{
			$this->printMessage($LNG['page_doesnt_exist']);
		}
		
		$mode	= in_array($section, array('universe', 'economy', 'planet', 'fleet', 'trader', 'highscore')) ? 'universe' : 'global';
		
		$this->assign(array(
			'configArray'	=> $this->configArray[$section],
			'section'		=> $section,
			'mode'			=> $mode,
			'configValues'	=> ${$this->mode[$section]},
		));
		
		$this->render('page.config.default.tpl');
	}

	function update()
	{
		global $LNG, $uniConfig, $gameConfig;
		
		$section	= HTTP::_GP('section', '');
		if(!isset($this->configArray[$section]))
		{
			$this->printMessage($LNG['page_doesnt_exist']);
		}
		
		foreach($this->configArray[$section] as $configKey => $keySettings)
		{
			switch($keySettings['type'])
			{
				case 'bool':
					$value	= min(1, max(0, HTTP::_GP($configKey, 0)));
				break;
				case 'int':
					$value	= HTTP::_GP($configKey, 0);
					
					if(isset($keySettings['min']))
					{
						$value	= max($keySettings['min'], $value);
					}
					
					if(isset($keySettings['max']))
					{
						$value	= max($keySettings['max'], $value);
					}
				break;
				case 'float':
					$value	= HTTP::_GP($configKey, 0.0);
					
					if(isset($keySettings['min']))
					{
						$value	= max($keySettings['min'], $value);
					}
					
					if(isset($keySettings['max']))
					{
						$value	= max($keySettings['max'], $value);
					}
				break;
				case 'string':
				case 'textarea':
					$value	= HTTP::_GP($configKey, '', true);
				break;
				case 'array':
					$value	= HTTP::_GP($configKey, '', true);
					
					if(!ArrayUtil::arrayKeyExistsRecrusive($value, $keySettings['selection']))
					{
						throw new Exception('Invalid value "'.htmlspecialchars($value, ENT_QUOTES).'" for '.$configKey);
					}
				break;
				case 'multi':
					$values	= HTTP::_GP($configKey, array());
					
					foreach($values as $value)
					{
						if(!ArrayUtil::arrayKeyExistsRecrusive($value, $keySettings['selection']))
						{
							throw new Exception('Invalid value "'.htmlspecialchars($value, ENT_QUOTES).'" for '.$configKey);
						}
					}
					
					$value	= serialize($values);
				break;
			}
		
			if(isset($keySettings['validate']))
			{
				$validator	= 'checkFieldIs'.ucwords($keySettings['validate']);
				if(method_exists($this, $validator))
				{
					$errorMessage	= $this->{$validator}($value);
					
					if($errorMessage !== true)
					{
						$this->printMessage(sprintf($LNG['se_vaildation_field'], $LNG['se_label_'.$configKey], $errorMessage), NULL, array($LNG['common_back'] => 'javascript:history.go(-1)'));
					}
				}
				else
				{
					throw new Exception('Missing validator '.$validator);
				}
			}
			
			$newConfig[$configKey]	= $value;
		}
		
		if(isset($this->validates[$section]))
		{
			$validator	= $this->validates[$section];
			if(method_exists($this, $validator))
			{
				$errorMessage	= $this->{$validator}($newConfig);
			
				if($errorMessage !== true)
				{
					$this->printMessage($errorMessage, NULL, array($LNG['common_back'] => 'javascript:history.go(-1)'));
				}
			}
			else
			{
				throw new Exception('Missing validator '.$this->validates[$section]);
			}
		}
		
		setConfig($newConfig);
			
		$this->printMessage($LNG['se_saved'], NULL, array($LNG['common_continue'] => 'admin.php?page=config&section='.$section));
	}

	function checkFieldIsUrl($value)
	{
		global $LNG;
		
		if(!empty($value) && !filter_var($value, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED))
		{
			return $LNG['se_vaildation_url_missing_scheme'];
		}
		
		return true;
	}

	function checkFieldIsMailActive($value)
	{
		global $LNG, $gameConfig;
		
		if($value == 1 && $gameConfig['mailEnable'] != 1)
		{
			return $LNG['se_vaildation_actice_mail_not'];
		}
		
		return true;
	}

	function checkFieldIsValidateTTF($value)
	{
		global $LNG;
		
		if(!isModulAvalible(MODULE_BANNER))
		{
			return true;
		}
		
		if(!file_exists(ROOT_PATH.$value))
		{
			return $LNG['se_vaildation_ttf_missing'];
		}
		
		ob_start();
		try {
			$im = imagecreate (1, 1);
			ImageTTFText($im, 20, 0, 10, 20, ImageColorAllocate($im, 255, 255, 255), ROOT_PATH.$value, 'Test');
			imagedestroy($im);
		} catch(Exception $e) {
			echo $e->getMessage();
		}
		$buffer	= ob_get_clean();
		
		if(!empty($buffer))
		{
			return $LNG['se_vaildation_ttf_gd_error'].$buffer;
		}
		
		return true;
	}

	function checkFieldIsIpOrDsn($value)
	{
		global $LNG;
		if(!filter_var($value, FILTER_VALIDATE_IP) && !filter_var($value, FILTER_VALIDATE_URL))
		{
			return $LNG['se_vaildation_ip_dsn_invalid'];
		}
		
		return true;
	}

	function checkTeamSpeak($config)
	{
		global $LNG;
		if($config['teamspeakEnable'] == 0)
		{
			return true;
		}
		
		$tsAdmin = new ts3admin($config['teamspeakServerAdress'], $config['teamspeakServerQueryPort']);
		
		$connectData	= $tsAdmin->connect();
		
		if(!$tsAdmin->getElement('success', $connectData))
		{
			$error	= $tsAdmin->getElement('errors', $connectData);
			return $LNG['se_vaildation_ts_cant_connect'].$error[0];
		}
		
		if(!$tsAdmin->login($config['teamspeakServerQueryUser'], $config['teamspeakServerQueryPassword']))
		{
			return $LNG['se_vaildation_ts_cant_login'];
		}

		if(!$tsAdmin->selectServer($config['teamspeakUDPPort']))
		{
			return $LNG['se_vaildation_ts_wrong_server'];
		}

		$serverInfoData	= $tsAdmin->serverInfo();
		if(!$tsAdmin->getElement('success', $serverInfoData))
		{
			$error	= $tsAdmin->getElement('errors', $serverInfoData);
			return $LNG['se_vaildation_ts_cant_get_info'].$error[0];
		}
		
		return true;
	}
}