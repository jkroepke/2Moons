<?php
/**
* This class handles and logs the error that occurs in the project
*
* @author Nitesh Apte
* @copyright 2010
* @version 1.0
* @access private
* @License GPL
*/
class ErrorLogging
{
	/**
	 * @var $_backTrace Backtrace message in _customError() method
	 * @see _customError
	 */
	private $_backTrace;
	
	/**
	 * @var $_errorMessage Error message
	 * @see _customError
	 */
	private $_errorMessage;
	
	/**
	 * @var $_traceMessage Contains the backtrace message from _debugBacktrace() method
	 * @see _debugBacktrace()
	 */
	private $_traceMessage = '';
	
	/**
	 * @var $MAXLENGTH Maximum length for backtrace message
	 * @see _debugBacktrace()
	 */
	private $_MAXLENGTH = 64;
	
	/**
	 * @var $_traceArray Contains from debug_backtrace()
	 * @see _debugBacktrace()
	 */
	private $_traceArray;
	
	/**
	 * @var $_defineTabs
	 */
	private $_defineTabs;
	
	/**
	 * @var $_argsDefine
	 */
	private $_argsDefine = array();
	
	/**
	 * @var $_newArray
	 */
	private $_newArray;
	
	/**
	 * @var $_newValue
	 */
	private $_newValue;
	
	/**
	 * @var $_stringValue
	 */
	private $_stringValue;
	
	/**
	 * @var $_lineNumber
	 */
	private $_lineNumber;
	
	/**
	 * @var $_fileName
	 */
	private $_fileName;
	
	/**
	 * @var $_lastError
	 */
	private $_lastError;
	
	
	/**
	 * Set custom error handler
	 * 
	 * @param none
	 * @return none
	 */
	public function __construct()
	{
		set_error_handler(array($this,'_customError'), E_ALL ^ E_NOTICE);
		register_shutdown_function(array($this, '_fatalError'));
	}
	
	/**
	 * Custom error logging in custom format
	 * 
	 * @param Int $errNo Error number
	 * @param String $errStr Error string
	 * @param String $errFile Error file
	 * @param Int $errLine Error line
	 * @return none
	 */
	public function _customError($errNo, $errStr, $errFile, $errLine)
	{
		if (!error_reporting() || $errNo == E_DEPRECATED) return false;

		$this->_backTrace = $this->_debugBacktrace(2);
		
		$this->_toFile($errNo, $errStr, $errFile, $errLine);
		exit;
	}
	
	/**
	 * Build backtrace message
	 * 
	 * @param $_entriesMade Irrelevant entries in debug_backtrace, first two characters 
	 * @return  
	 */
	public function _debugBacktrace($_entriesMade)
	{
		$this->_traceArray = debug_backtrace();
		
		for($i=0;$i<$_entriesMade;$i++)
		{
			array_shift($this->_traceArray);
		}
		
		$this->_defineTabs = sizeof($this->_traceArray)-1;
		foreach($this->_traceArray as $this->_newArray)
		{
			$this->_defineTabs -=1;
			if(isset($this->_newArray['class']))
			{
				$this->_traceMessage .= $this->_newArray['class'].'.';
			}
			if(!empty($this->_newArray['args']))
			{
				foreach($this->_newArray['args'] as $this->_newValue)
				{
					if(is_null($this->_newValue))
					{
						$this->_argsDefine[] = NULL; 
					}
					elseif(is_array($this->_newValue))
					{
						$this->_argsDefine[] = 'Array['.sizeof($this->_newValue).']';
					}
					elseif(is_object($this->_newValue))
					{
						$this->_argsDefine[] = 'Object: '.get_class($this->_newValue);
					}
					elseif(is_bool($this->_newValue))
					{
						$this->_argsDefine[] = $this->_newValue ? 'TRUE' : 'FALSE';
					}
					else
					{
						$this->_newValue = (string)@$this->_newValue;
						$this->_stringValue = htmlspecialchars(substr($this->_newValue, 0, $this->_MAXLENGTH));
						if(strlen($this->_newValue)>$this->_MAXLENGTH)
						{
							$this->_stringValue = '...';
						}
						$this->_argsDefine[] = "\"".$this->_stringValue."\""; 
					}
				}
			}
			$this->_traceMessage .= $this->_newArray['function'].'('.implode(',', $this->_argsDefine).')';
			$this->_lineNumber = (isset($this->_newArray['line']) ? $this->_newArray['line']:"unknown");
			$this->_fileName = (isset($this->_newArray['file']) ? $this->_newArray['file']:"unknown");
				
			$this->_traceMessage .= sprintf(" # line %4d. file: %s", $this->_lineNumber, $this->_fileName, $this->_fileName);
			$this->_traceMessage .= "\n";	
		}
		return $this->_traceMessage;
	}
	
	public function _fatalError()
	{
		$this->_lastError = error_get_last();
		if($this->_lastError['type'] == 1 || $this->_lastError['type'] == 4 || $this->_lastError['type'] == 16 || $this->_lastError['type'] == 64 || $this->_lastError['type'] == 256 || $this->_lastError['type'] == 4096)
		{
			$this->_customError($this->_lastError['type'], $this->_lastError['message'], $this->_lastError['file'], $this->_lastError['line']);
		}
	}
	
	public function _toFile($errNo, $errStr, $errFile, $errLine)
	{
		file_put_contents(str_replace('\\', '/',dirname($_SERVER['SCRIPT_FILENAME'])).'/includes/error.log', "[".date('d-M-Y H:i:s', TIMESTAMP)."] ".$this->_getErrorType($errNo).": ".$errStr." in ".$errFile." on line ".$errLine."\r\n", FILE_APPEND);
	}

	public function _getErrorType($errNo)
	{
		switch($errNo)
		{
			case E_ERROR:
				return 'PHP Fatal error';
			case E_WARNING:
				return 'PHP Warning';
			case E_PARSE:
				return 'PHP Parse error';
			case E_DEPRECATED:
				return 'PHP Deprecated';
		}
	}
	
}
?>