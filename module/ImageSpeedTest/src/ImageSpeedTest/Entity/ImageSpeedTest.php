<?php

namespace ImageSpeedTest\Entity;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface; 

/**
 *  imagespeedtest.
 *
 */
class ImageSpeedTest implements InputFilterAwareInterface 
{
    protected $inputFilter;

  
    protected $url;

    

    /**
     * Magic getter to expose protected properties.
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property) 
    {
        return $this->$property;
    }

    /**
     * Magic setter to save protected properties.
     *
     * @param string $property
     * @param mixed $value
     */
    public function __set($property, $value) 
    {
        $this->$property = $value;
    }

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy() 
    {
        return get_object_vars($this);
    }

    /**
     * Populate from an array.
     *
     * @param array $data
     */
    public function populate($data = array()) 
    {
        $this->url = $data['url'];
       
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    
    
   /* if (!Zend_Uri::check($value)) {
    	$this->_error(self::INVALID_URL);
    	return false;
    }*/
    
    
    
    
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $factory = new InputFactory();

            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'url',
                'required' => true,
                'filters'  => array(
                    
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'ImageSpeedTest\Validator\ValidateUrl',
                    	
                        
                    ),
                ),
            )));

            

            $this->inputFilter = $inputFilter;        
        }

        return $this->inputFilter;
    } 
}