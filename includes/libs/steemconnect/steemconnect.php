<?php

/**
 *  SteemNova
 *   by mys 2018
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package Steemnova
 * @author mys <miccelinski@gmail.com>
 * @licence MIT
 */

if (!function_exists('curl_init')) {
	throw new Exception('Steemconnect needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
	throw new Exception('Steemconnect needs the JSON PHP extension.');
}

class Steemconnect
{
	protected $access_token;

	protected $expires_in;

	protected $username;

	protected $data;

	protected static $CLIENT_ID = 'steemnova.app';

	protected static $SCOPE = 'login';


	public function __construct($config)
	{
		if (!empty($config['access_token']) and !empty($config['expires_in'])) {
			$this->access_token = $config['access_token'];
			$this->expires_in = $config['expires_in'];
		}
	}

	public static function getLoginUrl()
	{
		return 'https://steemconnect.com/oauth2/authorize?client_id=' . self::$CLIENT_ID . '&redirect_uri=' . HTTP_PATH.'index.php&scope=' . self::$SCOPE;
	}

	public static function getAdminUrl()
	{
		return 'https://steemconnect.com/oauth2/authorize?client_id=' . self::$CLIENT_ID . '&redirect_uri=' . HTTP_PATH.'admin.php&scope=' . self::$SCOPE;
	}

	protected function login()
	{
		$authstr = "authorization: " . $this->access_token;
		$check = curl_init();
		curl_setopt_array($check, array(
			CURLOPT_URL => "https://steemconnect.com/api/me",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 1,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{}",
			CURLOPT_HTTPHEADER => array(
				$authstr,
				"cache-control: no-cache",
				"content-type: application/json",
			),
		));
		$result = curl_exec($check);
		curl_close($check);
		$_result = json_decode($result);
		if(isset($_result->user)) {
			$this->data = $_result;
			return $_result->user;
		} else {
			return false;
		}
	}

	public function getUser()
	{
		if ($this->username !== null) {
			// we've already determined this and cached the value.
			return $this->username;
		}
		return $this->username = $this->login();
	}

	public function getData()
	{
		return $this->data;
	}

	protected function logout()
	{
		if (!isset($this->access_token)) {
			redirectLoginPage();
		} else {
			$authstr = "authorization: " . $this->access_token;
			$headers = array($authstr,"Content-Type: application/json");
			$check = curl_init();
			curl_setopt_array($check, array(
				CURLOPT_URL => "https://steemconnect.com/api/oauth2/token/revoke",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 1,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => "{}",
				CURLOPT_HTTPHEADER => array(
					$authstr,
					"cache-control: no-cache",
					"content-type: application/json",
				),
			));
			$result = curl_exec($check);
			curl_close($check);

			$this->access_token = null;
			$this->expires_in = null;
			$this->username = null;
			redirectLoginPage();
		}
	}
	
	protected function redirectLoginPage()
	{
		HTTP::redirectTo('index.php');
	}
}

class SteemconnectApiException extends Exception
{

}
