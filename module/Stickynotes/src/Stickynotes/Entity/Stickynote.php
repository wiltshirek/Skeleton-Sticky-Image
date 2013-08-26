<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StickyNote
 *
 * @author Arian Khosravi <arian@bigemployee.com>, <@ArianKhosravi>
 */
// module/StickyNotes/src/StickyNotes/Model/Entity/StickyNotes.php

namespace Stickynotes\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * A stickynote.
 *
 * @ORM\Entity
 * @ORM\Table(name="stickynotes")
 * @property int $_id
 * @property string $_note
 * @property string $_created
 */

class Stickynote implements InputFilterAwareInterface 
{
    protected $inputFilter;

    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\Column(name="id");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $_id;
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(name="note");
     */
    protected $_note;
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(name="created");
     */
    protected $_created;
    
    /**
     * Populate from an array.
     *
     * @param array $data
     */
    public function populate($data = array())
    {
    	$this->id = $data['_id'];
    	$this->artist = $data['_note'];
    	$this->title = $data['_created'];
    }

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    } 

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (!method_exists($this, $method)) {
            throw new Exception('Invalid Method');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (!method_exists($this, $method)) {
            throw new Exception('Invalid Method');
        }
        return $this->$method();
    }

    public function setOptions(array $options) {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
        return $this;
    }

    public function getNote() {
        return $this->_note;
    }

    public function setNote($note) {
        $this->_note = $note;
        return $this;
    }

    public function getCreated() {
        return $this->_created;
    }

    public function setCreated($created) {
        $this->_created = $created;
        return $this;
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
    	throw new \Exception("Not used");
    }
    
    public function getInputFilter()
    {
    	if (!$this->inputFilter) {
    		$inputFilter = new InputFilter();
    
    		$factory = new InputFactory();
    
    		$inputFilter->add($factory->createInput(array(
    				'name'       => '_id',
    				'required'   => true,
    				'filters' => array(
    						array('name'    => 'Int'),
    				),
    		)));
    
    		$inputFilter->add($factory->createInput(array(
    				'name'     => '_note',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'StripTags'),
    						array('name' => 'StringTrim'),
    				),
    				'validators' => array(
    						array(
    								'name'    => 'StringLength',
    								'options' => array(
    										'encoding' => 'UTF-8',
    										'min'      => 1,
    										'max'      => 100,
    								),
    						),
    				),
    		)));
    
    		$inputFilter->add($factory->createInput(array(
    				'name'     => '_created',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'StripTags'),
    						array('name' => 'StringTrim'),
    				),
    				'validators' => array(
    						array(
    								'name'    => 'StringLength',
    								'options' => array(
    										'encoding' => 'UTF-8',
    										'min'      => 1,
    										'max'      => 100,
    								),
    						),
    				),
    		)));
    
    		$this->inputFilter = $inputFilter;
    	}
    
    	return $this->inputFilter;
    }
    
    
    
    

}

?>
