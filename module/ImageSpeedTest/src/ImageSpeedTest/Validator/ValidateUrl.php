<?php 
namespace ImageSpeedTest\Validator;

use Zend\Uri\Http as ValidateUri;
use Zend\Uri\Exception as UriException;


class ValidateUrl extends \Zend\Validator\AbstractValidator {
     /**
      * Error codes
      * @const string
      */
	
     const INVALID_URL = 'invalidUrl';
     /**
      * Error messages
      * @var array
      */
     protected $messageTemplates = array(self::INVALID_URL => "'%value%' is not a valid URL. It must start with http(s):// and be valid.");
    /**
     * Defined by Zend_Validate_Interface
     *
     * Returns true if and only if the $value is a valid url that starts with http(s)://
     * and the hostname is a valid TLD
     *
     * @param  string $value
     * @return boolean
     */
    public function isValid($value)
    {
        if (!is_string($value)) {
            $this->error(self::INVALID_URL);
            return false;
        }
 
        $this->setValue($value);
    	if (is_string ($value)) {
    		try{
            	$value = \Zend\Uri\UriFactory::factory($value);
            	$validator = new \Zend\Validator\Hostname(\Zend\Validator\Hostname::ALLOW_DNS);
            	if ($validator->isValid($value->getHost()) && ($value->getScheme() == 'http' || $value->getScheme() =='https')  ) {
            		// hostname appears to be valid
	            		return true;
            	} else {
            		// hostname is invalid; print the reasons
            		$this->error(self::INVALID_URL);
            		return false;
            		
            		}
    		}catch ( \Exception  $e) {
    			$this->error(self::INVALID_URL);
    			return false;
    			
    			}
    		
    		}

      
        return true;
    }
}