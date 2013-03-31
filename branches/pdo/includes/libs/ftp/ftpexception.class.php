<?php

/**
 * FTP Exception Class
 *
 * @author     Andreas Skodzek <webmaster@phpbuddy.eu>
 * @link       http://www.phpbuddy.eu/
 * @copyright  2008 Andreas Skodzek
 * @license    GNU Public License <http://www.gnu.org/licenses/gpl.html>
 * @package    phpBuddy.FTP.Exception.Class
 * @version    1.0 released 01.09.2008
 */


class FTPException extends Exception
{
   /**
    * Error Message if no native FTP support is available
	*/
	const FTP_SUPPORT_ERROR = 'Die FTP-Funktionen sind auf diesem System nicht verfuegbar!';

   /**
    * Error Message if the given Host does not respond
	*/
	const CONNECT_FAILED_BADHOST = 'Der angegebene Host konnte nicht kontaktiert werden!';

   /**
    * Error Message if no SSL-FTP is available and no fallback is used
	*/
	const CONNECT_FAILED_NOSSL = 'Die Verbindung via SSL konnte nicht hergestellt werden!';

   /**
    * Error Message if the given login information is not valid
	*/
	const CONNECT_FAILED_BADLOGIN = 'Die Zugangsdaten für die FTP Verbindung sind inkorrekt!';

   /**
    * Error Message if the FTP server OS could not be determined.
	*/
	const CONNECT_UNKNOWN_OS = 'Das Betriebssystem des FTP Server konnte nicht identifiziert werden!';


	
   /**
    * Constructor
	*/
	public function __construct( $meldung, $code = 0 )
	{
		parent::__construct( $meldung, $code );
	}
}

?>