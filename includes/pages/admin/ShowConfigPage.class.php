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
		
		$this->configArray = array(
			'universe' => array(
			
			),
			'global' => array(
				'teamspeak'	=> 'checkTeamSpeak',
				'teamspeak'	=> 'checkTeamSpeak',
				'mail'		=> 'checkSiteMail',
				'captcha'	=> 'checkSiteReCaptcha',
				'facebook'	=> 'checkSiteFacebook',
			),
		);
		
		$this->configArray = array(
			'universe' => array(
				'general' => array(
					'uniName' => array(
						'type' => 'string',
					),
					'enable' => array(
						'type' => 'bool',
					),
					'enableReason' => array(
						'type' => 'string',
					),
					'enableRegistration' => array(
						'type' => 'bool',
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
					'newsEnable' => array(
						'type' => 'bool',
					),
					'newsText' => array(
						'type' => 'string',
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
					'storageFactor' => array(
						'type' => 'int',
					),
					'ecoResourceOverflow' => array(
						'type' => 'float',
					),
					'buildMinBuildTime' => array(
						'type' => 'int',
					),
					'shipyardCancelCharge' => array(
						'type' => 'int',
						'max' => 100
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
					),
					'planetHoldDebrisOnMoonCreate' => array(
						'type' => 'int',
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
					),
					'attackMaxRounds' => array(
						'type' => 'int',
					),
					'attackAllowAdmin' => array(
						'type' => 'int',
					),
					'fleetToDebris' => array(
						'type' => 'int',
					),
					'defenseToDebris' => array(
						'type' => 'int',
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
					),
					'noobProtectionRange' => array(
						'type' => 'int',
					),
				),
				'trader' => array(
					'traderFleetCharge' => array(
						'type' => 'int',
					),
					'traderResourceCost' => array(
						'type' => 'int',
					),
					'traderResourceCharge' => array(
						'type' => 'int',
					),
					'traderFleetData' => array(
						'type' => 'array',
						'selection' => array(array_merge($GLOBALS['VARS']['LIST'][ELEMENT_FLEET], $GLOBALS['VARS']['LIST'][ELEMENT_DEFENSIVE]), $LNG['tech']),
					),
				),
			),
			'global' => array(
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
						'selection' => array(Language::getAllowedLangs(false)),
					),
					'timezone' => array(
						'type' => 'array',
						'selection' => array(DateUtil::getTimezones()),
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
					),
					'deleteMarkedUser' => array(
						'type' => 'int',
					),
					'deleteInactiveUser' => array(
						'type' => 'int',
					),
					'deleteFleetLogs' => array(
						'type' => 'int',
					),
				),
				'user' => array(
					'userAllowOneNameChangeInHour' => array(
						'type' => 'int',
					),
					'userInactiveSinceDays' => array(
						'type' => 'int',
					),
					'userInactiveLongSinceDays' => array(
						'type' => 'int',
					),
					'userMinVacationTime' => array(
						'type' => 'int',
					),
					'userMaxVacationTime' => array(
						'type' => 'int',
					),
					'userVertification' => array(
						'type' => 'bool',
						'validate' => 'checkIfMailActive'
					),
					'referralEnable' => array(
						'type' => 'bool',
					),
					'referralBonus' => array(
						'type' => 'bool',
					),
					'referralMinimumPoints' => array(
						'type' => 'int',
					),
					'referralLimit' => array(
						'type' => 'int',
					),
					'inactiveMailEnable' => array(
						'type' => 'bool',
						'validate' => 'checkIfMailActive'
					),
					'inactiveMailAfterDays' => array(
						'type' => 'int',
					),
				),
				'highscore' => array(
					'highscoreAdminEnable' => array(
						'type' => 'array',
						'selection' => array(array(0, 1, 2), $LNG['se_highscoreAdminEnable_values']),
					),
					'highscoreAdminFromLevel' => array(
						'type' => 'int',
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
						'validate' => 'ip_dsn',
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
						'selection' => array(array('mail', 'smtp'), $LNG['se_mailSmtpSecure_values']),
					),
					'mailSmtpAdress' => array(
						'type' => 'string',
						'validate' => 'ip_dsn',
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
						'selection' => array(array('none', 'tls', 'ssl'), $LNG['se_mailSmtpSecure_values']),
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
				'google' => array(
					'analyticsEnable' => array(
						'type' => 'bool',
					),
					'analyticsUID' => array(
						'type' => 'string',
					),
				)
			)
		);
	}

	function selection()
	{
		global $LNG, $uniConfig, $gameConfig;
		$selective	= HTTP::_GP('selective', '');
		$category	= HTTP::_GP('category', '');
		if(!isset($this->configArray[$selective][$category]))
		{
			$this->printMessage($LNG['page_doesnt_exist']);
		}
		
		$this->assign(array(
			'configArray'	=> $this->configArray[$selective][$category],
			'configValues'	=> $selective === 'universe' ? $uniConfig : $gameConfig,
			'selective'		=> $selective,
			'category'		=> $category,
		));
		
		$this->render('page.config.selection.tpl');
	}

	function show()
	{
		

	}
}