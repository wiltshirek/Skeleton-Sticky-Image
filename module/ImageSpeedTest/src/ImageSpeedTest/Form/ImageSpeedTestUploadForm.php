<?php
namespace ImageSpeedTest\Form;

// File: ImageSpeedTestUploadForm



use Zend\Form\Form;

class ImageSpeedTestUploadForm extends Form
{
    
	
	public function __construct($name = null)
	{
		// we want to ignore the name passed
		parent::__construct('imageSpeedUpload');
		$this->setAttribute('method', 'post');
		
		$this->add(array(
				'name' => 'url',
				'type' => 'Text',
				'attributes'=>array(
						'id'=>'url'),
				'options' => array(
						'label' => 'Website Url',
						
				),
		));
		
	}
	
	
	
	
	
	
	
	
	
	
	
}