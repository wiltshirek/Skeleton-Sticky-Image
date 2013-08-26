<?php
namespace ImageSpeedTest\Form;

use Zend\Form\Form;

class ImageSpeedTestForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('imagespeedtest');
        $this->setAttribute('method', 'post');
       
        $this->add(array(
            'name' => 'uploaded_image',
            'type' => 'File',
            'options' => array(
                'label' => 'Upload File',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
}