<?php

/**
 * phpBuddy.eu FTP Class - PHP 5.2.2 or higher is required!
 *
 * @author     Andreas Skodzek <webmaster@phpbuddy.eu>
 * @link       http://www.phpbuddy.eu/
 * @copyright  2008 Andreas Skodzek
 * @license    GNU Public License <http://www.gnu.org/licenses/gpl.html>
 * @package    phpBuddy.FTP.Class
 * @version    1.0 released 01.09.2008
 */


class FTP
{
   /**
    * @var mixed Instance of the Class
	*/
	public static $instance = null;
	
   /**
    * @var mixed FTP Connection ID
	*/
	protected $cid = null;

   /**
    * @var string FTP Server Operating System
	*/
	protected $serverOS = null;

   /**
    * @var array File extensions that are considered ASCII for upload/download operations.
	*/
	protected $ascii_array = array( 'am', 'asp', 'bat', 'c', 'cfm', 'cgi', 'conf', 'cpp', 'css', 'dhtml', 'diz', 'h',
									'hpp', 'htaccess', 'htpasswd', 'htusers', 'htgroups', 'htm', 'html', 'in', 'inc', 'js', 'm4', 'mak',
									'nfo', 'nsi', 'pas', 'patch', 'php', 'php3', 'php4', 'php5', 'phpx', 'phtml', 'pl', 'po',
									'py', 'qmail', 'sh', 'shtml', 'sql', 'tcl', 'tpl', 'txt', 'vbs', 'xml', 'xrc' );
	
	

	/**
	 * Dummy-Methods to prevent additional instances of the class.
	 */
	private function __construct() {}
	private function __clone() {}

	
	/**
	 * Singleton to instantiate the class
	 *
	 * @return mixed Object of the class
	 */
	public static function getInstance()
	{
		if (self::$instance === NULL)
		{
			$klasse = __CLASS__;
			self::$instance = new $klasse;
		}
		return self::$instance;
	}


	/**
	 * Connect to the FTP server.
	 * Also sends login information, detects target FTP OS and sets Passive Mode to TRUE
	 *
	 * @param  array  $config Login information to connect at the FTP server
	 * @param  bool   $useSSL Establish a secure SSL-FTP connection
	 * @param  bool   $fallback If a SSL-FTP connect fails, try a default FTP connect as fallback 
	 * @return void
	 */
	public function connect($config, $useSSL = false, $fallback = false)
	{
		// Check if native FTP support is enabled
		if (function_exists('ftp_connect') === false)
		{
			throw new FTPException( FTPException::FTP_SUPPORT_ERROR );
		}
		
		// Default connection
		if ($useSSL === false)
		{
			if (($this->cid = @ftp_connect( $config['host'], $config['port'])) === false)
			{
				throw new FTPException( FTPException::CONNECT_FAILED_BADHOST );
			}
		}
		
		// SSL-FTP connection
		if ($useSSL === true)
		{
			if (!function_exists( 'ftp_ssl_connect' ) ||
				!$this->cid = @ftp_ssl_connect( $config['host'], $config['port'] ))
			{
				if ($fallback === false)
				{
					throw new FTPException( FTPException::CONNECT_FAILED_NOSSL );
				}
				// Default connection as fallback
				else if ($fallback === true)
				{
					if (!$this->cid = @ftp_connect( $config['host'], $config['port'] ))
					{
						throw new FTPException( FTPException::CONNECT_FAILED_BADHOST );
					}
				}
			}
		}
		
		// Send login information
		if (@ftp_login( $this->cid, $config['username'], $config['password'] ) === false)
		{
			throw new FTPException( FTPException::CONNECT_FAILED_BADLOGIN );
		}
		
		// Detect FTP Server OS
		// This is required by some operations, such as chmod, to prevent wrong return values
		$tmpOS = strtoupper( self::getSystem() );
		if (strpos( $tmpOS, 'MAC' ) !== false)
		{
			$this->serverOS = 'MAC';
		}
		else if (strpos( $tmpOS, 'WIN' ) !== false)
		{
			$this->serverOS = 'WIN';
		}
		else if (strpos( $tmpOS, 'UNIX' ) !== false)
		{
			$this->serverOS = 'UNIX';
		}
		else
		{
			throw new FTPException( FTPException::CONNECT_UNKNOWN_OS );
		}

		// Set Passive mode
		self::setPassiveMode( true );
	}

	
	/**
	 * Downloads a file from the FTP server to the local system
	 *
	 * @param  string  $remotefile Remote path of the file to download
	 * @param  string  $localfile Local path where the file should be stored
	 * @param  string  $mode Transfer mode for the file. (auto or ascii or binary)
	 * @param  integer $position Pointer of the remote file from where the download should be resumed
	 * @return bool
	 */
	public function download( $remotefile, $localfile, $mode = 'auto', $position = null )
	{
		if (is_resource( $this->cid ))
		{
			$transfermode = self::transferMode( $mode );
			return ftp_get( $this->cid, $localfile, $remotefile, $transfermode, $position );
		}
	}

	
	/**
	 * Downloads a file from the FTP server to the local system but does not block other operations
	 *
	 * @param  string  $remotefile Remote path of the file to download
	 * @param  string  $localfile Local path where the file should be stored
	 * @param  string  $mode Transfer mode for the file. (auto or ascii or binary)
	 * @param  integer $position Pointer of the remote file from where the download should be resumed
	 * @return integer 0 = Transfer failed (FTP_FAILED) | 1 = Transfer finished (FTP_FINISHED) | 2 = Transfer in progress (FTP_MOREDATA)
	 */
	public function downloadUnobtrusive( $remotefile, $localfile, $mode = 'auto', $position = null )
	{
		if (is_resource( $this->cid ))
		{
			$transfermode = self::transferMode( $mode );
			return ftp_nb_get( $this->cid, $localfile, $remotefile, $transfermode, $position );
		}
	}

	
	/**
	 * Downloads a file from the FTP server and saves to an open file
	 *
	 * @param  string  $remotefile Remote path of the file to download
	 * @param  string  $resource Resource handle of the open file in which the downloaded file should be written
	 * @param  string  $mode Transfer mode for the file. (auto or ascii or binary)
	 * @param  integer $position Pointer of the remote file from where the download should be resumed
	 * @return bool
	 */
	public function downloadToFile( $remotefile, $resource, $mode = 'auto', $position = null )
	{
		if (is_resource( $this->cid ))
		{
			$transfermode = self::transferMode( $mode );
			return ftp_fget( $this->cid, $resource, $remotefile, $transfermode, $position );
		}
	}

	
	/**
	 * Downloads a file from the FTP server and saves to an open file but does not block other operations
	 *
	 * @param  string  $remotefile Remote path of the file to download
	 * @param  string  $resource Resource handle of the open file in which the downloaded file should be written
	 * @param  string  $mode Transfer mode for the file. (auto or ascii or binary)
	 * @param  integer $position Pointer of the remote file from where the download should be resumed
	 * @return integer 0 = Transfer failed (FTP_FAILED) | 1 = Transfer finished (FTP_FINISHED) | 2 = Transfer in progress (FTP_MOREDATA)
	 */
	public function downloadToFileUnobtrusive( $remotefile, $resource, $mode = 'auto', $position = null )
	{
		if (is_resource( $this->cid ))
		{
			$transfermode = self::transferMode( $mode );
			return ftp_nb_fget( $this->cid, $resource, $remotefile, $transfermode, $position );
		}
	}

	
	/**
	 * Uploads a file from the local system to the FTP server
	 *
	 * @param  string  $localfile Local path of the file to upload
	 * @param  string  $remotefile Remote path where the file should be stored
	 * @param  string  $mode Transfer mode for the file. (auto or ascii or binary)
	 * @param  integer $position Pointer of the local file from where the upload should be resumed
	 * @return bool
	 */
	public function upload( $localfile, $remotefile, $mode = 'auto', $position = null )
	{
		if (is_resource( $this->cid ))
		{
			$transfermode = self::transferMode( $mode );
			return ftp_put( $this->cid, $remotefile, $localfile, $transfermode, $position );
		}
	}

	
	/**
	 * Uploads a file from the local system to the FTP server but does not block other operations
	 *
	 * @param  string  $localfile Local path of the file to upload
	 * @param  string  $remotefile Remote path where the file should be stored
	 * @param  string  $mode Transfer mode for the file. (auto or ascii or binary)
	 * @param  integer $position Pointer of the local file from where the upload should be resumed
	 * @return integer 0 = Transfer failed (FTP_FAILED) | 1 = Transfer finished (FTP_FINISHED) | 2 = Transfer in progress (FTP_MOREDATA)
	 */
	public function uploadUnobtrusive( $localfile, $remotefile, $mode = 'auto', $position = null )
	{
		if (is_resource( $this->cid ))
		{
			$transfermode = self::transferMode( $mode );
			return ftp_nb_put( $this->cid, $remotefile, $localfile, $transfermode, $position );
		}
	}

	
	/**
	 * Uploads from an open file to the FTP server
	 *
	 * @param  string  $resource An open file pointer on the local file.
	 * @param  string  $remotefile Remote path where the file should be stored
	 * @param  string  $mode Transfer mode for the file. (auto or ascii or binary)
	 * @param  integer $position Pointer of the local file from where the upload should be resumed
	 * @return bool
	 */
	public function uploadFromFile( $resource, $remotefile, $mode = 'auto', $position = null )
	{
		if (is_resource( $this->cid ))
		{
			$transfermode = self::transferMode( $mode );
			return @ftp_fput( $this->cid, $remotefile, $resource, $transfermode, $position );
		}
	}

	
	/**
	 * Uploads from an open file to the FTP server but does not block other operations
	 *
	 * @param  string  $resource An open file pointer on the local file.
	 * @param  string  $remotefile Remote path where the file should be stored
	 * @param  string  $mode Transfer mode for the file. (auto or ascii or binary)
	 * @param  integer $position Pointer of the local file from where the upload should be resumed
	 * @return integer 0 = Transfer failed (FTP_FAILED) | 1 = Transfer finished (FTP_FINISHED) | 2 = Transfer in progress (FTP_MOREDATA)
	 */
	public function uploadFromFileUnobtrusive( $resource, $remotefile, $mode = 'auto', $position = null )
	{
		if (is_resource( $this->cid ))
		{
			$transfermode = self::transferMode( $mode );
			return ftp_nb_fput( $this->cid, $remotefile, $resource, $transfermode, $position );
		}
	}

	
	/**
	 * Continues an unobtrusive file transfer
	 *
	 * @return integer 0 = Transfer failed (FTP_FAILED) | 1 = Transfer finished (FTP_FINISHED) | 2 = Transfer in progress (FTP_MOREDATA)
	 */
	public function continueTransfer()
	{
		if (is_resource( $this->cid ))
		{
			return ftp_nb_continue( $this->cid );
		}
	}


	/**
	 * Returns the working directory name
	 *
	 * @return string  Name of the current dir
	 */
	public function getDir()
	{
		if (is_resource( $this->cid ))
		{
			return ftp_pwd( $this->cid );
		}
	}

	
	/**
	 * Read all file names in a directory as plain list
	 *
	 * @param  string $dir Path to the directory. If $dir is NULL the last work directory (see self::changeDir()) is used
	 * @return array  File list
	 */
	public function getSimpleFileList( $dir = null )
	{
		if (is_resource( $this->cid ))
		{
			return ftp_nlist( $this->cid, $dir );
		}
	}

	
	/**
	 * Read all file names plus file informations in a directory
	 *
	 * @param  string $dir Path to the directory
	 * @param  mixed  $mode Value 0 means default list. Value 1 means extended list.
	 * @return array  Complete file list as one Array ($mode = 0) or file list as multidimensional array ($mode = 1)
	 */
	public function getFileList( $dir, $mode = 0 )
	{
		if (is_resource( $this->cid ))
		{
			// Default
			if ($mode == 0)
			{
				return ftp_rawlist( $this->cid, $dir );
			}
			
			// Extended
			if ($mode == 1)
			{
				$rawfilelist = ftp_rawlist( $this->cid, $dir );
				return self::extractFileInfo( $rawfilelist );
			}
		}
	}

	
	/**
	 * Read all file names plus file informations in a directory recursively
	 *
	 * @param  string $dir Path to the directory
	 * @param  integer  $mode Value 0 means default list. Value 1 means extended list.
	 * @param  integer  $onlydir Value 1 returns an Array with path structure only .
	 * @return array  Complete file list as one Array ($mode = 0) or file list as multidimensional array ($mode = 1)
	 */
	public function getFileListRecursive( $dir, $mode = 0, $onlydir = 0 )
	{
		if (is_resource( $this->cid ))
		{
			// Default
			if ($mode == 0)
			{
				return ftp_rawlist( $this->cid, $dir, true );
			}
			
			// Extended
			if ($mode == 1)
			{
				$rawfilelist = ftp_rawlist( $this->cid, $dir, true );
				$dirarray    = array( $dir );
				$rawdirarray = array();
				$listecount  = count( $rawfilelist );
				for ($i = 0; $i < $listecount; $i++)
				{
					if (!$rawfilelist[$i])
					{
						$dirarray[] = substr( $rawfilelist[$i+1], 0, -1 ). "/";
					}
				}
				// Dir list only
				if ($mode == 1 && $onlydir == 1)
				{
					return $dirarray;
				}
				// Detail list
				foreach ($dirarray as $dir)
				{
					$rawdirarray[$dir] = self::getFileList( $dir, 1 );
				}
				return $rawdirarray;
			}
		}
	}
	
	
	/**
	 * Change to the parent directory
	 *
	 * @return bool
	 */
	public function levelUp()
	{
		if (is_resource( $this->cid ))
		{
			return ftp_cdup( $this->cid );
		}
	}

	
	/**
	 * Change directory
	 *
	 * @param  string  $dir Path to change to
	 * @return bool
	 */
	public function changeDir( $dir )
	{
		if (is_resource( $this->cid ))
		{
			return @ftp_chdir( $this->cid, $dir );
		}
	}


	/**
	 * Creates a single directory or complete directory structure
	 *
	 * @param  string  $dir Directory name or directory structure to create
	 * @param  integer $recursive If value is 1, the script will try to create a directory structure
	 * @return bool
	 */
	public function makeDir( $dir, $recursive = 0 )
	{
		if (is_resource( $this->cid ))
		{
			// Default
			if ($recursive == 0)
			{
				if (@ftp_mkdir( $this->cid, $dir ) === false)
				{
					return false;
				}
				return true;
			}

			// Create directory recursively
			if ($recursive == 1)
			{
				$currentWorkingDir = self::getDir();
				// Remove trailing slash
				if (substr( $dir, -1 ) == '/')
				{
					$dir = substr( $dir, 0, -1 );
				}
				// Start in root dir?
				if (substr( $dir, 0, 1 ) == '/')
				{
					self::changeDir( '/' );
				}
				// Create path
				$path = explode( "/", $dir );
				for ($i = 0; $i < count( $path ); $i++)
				{
					if (!$path[$i]) continue;
					if (!self::changeDir( $path[$i] ))
					{
						if (@ftp_mkdir( $this->cid, $path[$i] ))
						{
							self::changeDir( $path[$i] );
						}
						else
						{
							return false;
							break;
						}
					}
				}
				self::changeDir( $currentWorkingDir );
				return true;
			}
		}
	}

	
	/**
	 * Change file permissions
	 *
	 * @param  string  $file File name which permission should be changed
	 * @param  integer $cm New CHMOD Value as octal
	 * @return bool
	 */
	public function chmod( $file, $cm )
	{
		if (is_resource( $this->cid ))
		{
			if (ftp_chmod( $this->cid, $cm, $file ) === false)
			{
				if ($this->serverOS != 'WIN')
				{
					return false;
				}			
			}
			return true;
		}
	}

	
	/**
	 * Rename a file or directory
	 *
	 * @param  string  $oldname Old name
	 * @param  string  $newname New name
	 * @return bool
	 */
	public function rename( $oldname, $newname )
	{
		if (is_resource( $this->cid ))
		{
			return ftp_rename( $this->cid, $oldname, $newname );
		}
	}

	
	/**
	 * Delete a single file from a FTP server
	 *
	 * @param  string  $file Path and file name that should be delete
	 * @return bool
	 */
	public function delete( $file )
	{
		if (is_resource( $this->cid ))
		{
			return ftp_delete( $this->cid, $file );
		}
	}

	
	/**
	 * Removes a directory on the FTP server
	 *
	 * NOTE: Be careful with the recursive function. All files and directories in the specified directory
	 * will be deleted without further warning! So check and double check the path before you call this function.
	 *
	 * @param  string   $dir Path to dir
	 * @param  integer  $recursive Remove a directory structure
	 * @return bool
	 */
	public function removeDir( $dir, $recursive = 0 )
	{
		if (is_resource( $this->cid ))
		{
			// Add trailing slash
			if (substr( $dir, -1 ) != '/')
			{
				$dir = $dir. '/';
			}
			// Default
			if ($recursive == 0)
			{
				if (ftp_rmdir( $this->cid, $dir ) === false)
				{
					return false;
				}
				return true;
			}
			
			// Remove directory recursively
			if ($recursive == 1)
			{
				return self::removeDirRecursive( $dir );
			}
		}
	}

	
	/**
	 * Removes a directory structure on the FTP server
	 *
	 * @param  string  $dir Path to dir
	 * @return bool
	 */
	protected final function removeDirRecursive( $dir )
	{
		$filelist = self::getFileList( $dir, 1 );
		if (!empty( $filelist ))
		{
			foreach ($filelist as $file)
			{
				if ($file['type'] != 'Dir')
				{
					// Delete files
					if (self::delete( $dir.$file['name'] ) === false)
					{
						return false;
					}
				}
				// Change dir
				if ($file['type'] == 'Dir')
				{
					self::removeDirRecursive( $dir.$file['name']. '/' );
				}
			}
		}
		// Remove dir
		if (self::removeDir( $dir ) === false)
		{
			return false;
		}
		return true;
	}


	/**
	 * Read the size of a file.
	 * Can also be used to determine if a given path is a file or a directory.
	 * Files return a positive integer value, while directories return -1. The method convert the -1 into FALSE.
	 * So if you use this method on a path and receive FALSE, it is either a directory or the file does not exist.
	 * To know if it is a directory use the changeDir method or use the getFileList method with detail flag 1.
	 *
	 * @param  string  $file File name
	 * @param  integer $convert Value 0 (Default) returns the size as Byte. Value 1 returns the converted size (Byte/KB/MB/GB/TB)
	 * @return mixed   On success the file size, otherwise FALSE
	 */
	public function getSize( $file, $convert = 0 )
	{
		if (is_resource( $this->cid ))
		{
			$status = ftp_size( $this->cid, $file );
			if ($status == -1)
			{
				return false;
			}
			else if (($status != -1) && $convert == 1)
			{
				return self::convertSize( $status );
			}
			return $status;
		}
	}

	
	/**
	 * Last date of file modification
	 *
	 * @param  string $file File name
	 * @return mixed  On success a Unix Timestamp, otherwise FALSE
	 */
	public function getLastModified( $file )
	{
		if (is_resource( $this->cid ))
		{
			$status = ftp_mdtm( $this->cid, $file );
			if ($status == -1)
			{
				return false;
			}
			return $status;
		}
	}

	
	/**
	 * Read the FTP Timeout setting in seconds.
	 *
	 * @return mixed  On success the seconds as Integer, otherwise FALSE
	 */
	public function getTimeout()
	{
		if (is_resource( $this->cid ))
		{
			return @ftp_get_option( $this->cid, FTP_TIMEOUT_SEC );
		}
	}

	
	/**
	 * Determine if autoseek is enabled.
	 * Autoseek is used by the unobtrusive Upload/Download methods to automatically find the resume position.
	 *
	 * @return bool
	 */
	public function getAutoseek()
	{
		if (is_resource( $this->cid ))
		{
			return @ftp_get_option( $this->cid, FTP_AUTOSEEK );
		}
	}


	/**
	 * Read the OS identification string
	 *
	 * @return mixed  On success the name of the OS as string, otherwise FALSE
	 */
	public function getSystem()
	{
		if (is_resource( $this->cid ))
		{
			return ftp_systype( $this->cid );
		}
	}

	
	/**
	 * Change the passive mode of the connection.
	 * If FTP operations fail, try to set the mode to passive (ON by Default, set in the connect Method). Firewalls and NAT Routers usually prevent an active connection.
	 *
	 * @param  bool  $status Set to TRUE to turn passiven mode ON. FALSE will turn it OFF.
	 * @return bool
	 */
	public function setPassiveMode( $status = true )
	{
		if (is_resource( $this->cid ))
		{
			return ftp_pasv( $this->cid, $status );
		}
	}


	/**
	 * Set the FTP Timeout in seconds
	 *
	 * @param  integer  $seconds Timeout in Seconds
	 * @return bool
	 */
	public function setTimeout( $seconds )
	{
		if (is_resource( $this->cid ))
		{
			if (@ftp_set_option( $this->cid, FTP_TIMEOUT_SEC, $seconds ) === false)
			{
				return false;
			}
			return true;
		}
	}


	/**
	 * Turn Autoseek ON or OFF
	 * Autoseek is used by the unobtrusive Upload/Download methods to automatically find the resume position.
	 *
	 * @param  bool  $status Turn ON or OFF autoseek
	 * @return bool
	 */
	public function setAutoseek( $status )
	{
		if (is_resource( $this->cid ))
		{
			if (@ftp_set_option( $this->cid, FTP_AUTOSEEK, $status ) === false)
			{
				return false;
			}
			return true;
		}
	}


	/**
	 * Sends a SITE EXEC command to a FTP server.
	 *
	 * @param  string  $command The command that is send to the server.
	 * @return bool
	 */
	public function executeCommand( $command )
	{
		if (is_resource( $this->cid ))
		{
			return ftp_exec( $this->cid, $command );
		}
	}


	/**
	 * Sends an arbitrary command to a FTP server
	 *
	 * @param  string  $command The command that is send to the server.
	 * @return mixed  The server response as string or array
	 */
	public function executeRawCommand( $command )
	{
		if (is_resource( $this->cid ))
		{
			return ftp_raw( $this->cid, $command );
		}
	}


	/**
	 * Converts a given file size in Byte into Byte/KB/MB/GB/TB
	 *
	 * @param  integer $filesize File size in Byte
	 * @return string  Converted file size as decimal with suffix
	 */
	protected final function convertSize( $filesize )
	{
	    $size = intval( $filesize );
		$type = array( 'Byte', 'KB', 'MB', 'GB', 'TB' );
    	for ($i = 0; ($size >= 1024 && $i < (count( $type ) -1)); $size /= 1024, $i++ );
    	return round( $size, 2 ). " " .$type[$i];
	}


	/**
	 * Converts a symbolic CHMOD into an octal value
	 *
	 * @param  string   $cm CHMOD as symbolic string
	 * @return integer  CHMOD as octal with leading zero
	 */
	protected function convertToOctal( $cm )
	{
		$oct = 0;
		// Owner
		if ($cm{1}      == 'r') $oct += 0400;
		if ($cm{2}      == 'w') $oct += 0200;
		if ($cm{3}      == 'x') $oct += 0100;
		else if ($cm{3} == 's') $oct += 04100;
		else if ($cm{3} == 'S') $oct += 04000;
		// Group
		if ($cm{4}      == 'r') $oct += 040;
		if ($cm{5}      == 'w') $oct += 020;
		if ($cm{6}      == 'x') $oct += 010;
		else if ($cm{6} == 's') $oct += 02010;
		else if ($cm{6} == 'S') $oct += 02000;
		// Other
		if ($cm{7}      == 'r') $oct += 04;
		if ($cm{8}      == 'w') $oct += 02;
		if ($cm{9}      == 'x') $oct += 01;
		else if ($cm{9} == 't') $oct += 01001;
		else if ($cm{9} == 'T') $oct += 01000;
		
		return sprintf( '%04o', $oct );
	}


	/**
	 * Converts a simple file list array into a multidimensional array
	 * File size in Byte is converted with convertSize( size )
	 * Symbolic CHMOD is converted to octal with convertToOctal( chmod )
	 *
	 * @param  array  $rawfilelist Array with file list
	 * @return array  File list
	 */
	protected function extractFileInfo( $rawfilelist )
	{
		$filearray = array();
		if (is_array( $rawfilelist ))
		{
			foreach ($rawfilelist as $rawfile)
			{
				$fileinfo = preg_split( "/[\s]+/", $rawfile );
				if ($fileinfo[8] != '.' &&
					$fileinfo[8] != '..')
				{
					switch ($fileinfo[0]{0})
					{
						case '-': $file['type'] = 'File'; break;
						case 'd': $file['type'] = 'Dir'; break;
						case 'l': $file['type'] = 'Link'; break;
						default : $file['type'] = 'File'; break;
					}
					$file['chmod']    = self::convertToOctal( $fileinfo[0] );
					$file['hardlink'] = $fileinfo[1];
					$file['owner']    = $fileinfo[2];
					$file['group']    = $fileinfo[3];
					$file['size']     = self::convertSize( $fileinfo[4] );
					$file['month']    = $fileinfo[5];
					$file['day']      = $fileinfo[6];
					$file['modified'] = $fileinfo[7];
					$file['name']     = $fileinfo[8];
					$filearray[$file['name']] = $file;
				}
			}
		}
		return $filearray;
	}


	/**
	 * Set the transfer mode for uploads/downloads
	 *
	 * @param  string   $mode Transfer mode (ascii | binary | auto)
	 * @return integer  1 = ASCII | 2 = BINARY
	 */
	protected function transferMode( $mode )
	{
		// Check if a correct mode is given
		if ($mode != 'ascii' || $mode != 'binary' || $mode != 'auto')
		{
			$mode = 'auto';
		}
		// Try to determine the transfer mode by file extension
		if ($mode == 'auto')
		{
			$ext = array_pop( explode( '.', $remotefile ) );
			$transfermode = in_array( $ext, $this->ascii_array ) ? FTP_ASCII : FTP_BINARY;
		}
		// Force transfer mode by user
		else if ($mode == 'ascii')
		{
			$transfermode = FTP_ASCII;
		}
		else if ($mode == 'binary')
		{
			$transfermode = FTP_BINARY;
		}
		return $transfermode;
	}


	/**
	 * Close the FTP connection
	 *
	 * @return bool
	 */
	protected function close()
	{
		if (is_resource( $this->cid ))
		{
			return ftp_close( $this->cid );
		}
	}

	
	/**
	 * Destructor - close the FTP connection
	 *
	 * @return void
	 */
	public function __destruct()
	{
		if (is_resource( $this->cid ))
		{
			self::close();
		}
	}
}

?>