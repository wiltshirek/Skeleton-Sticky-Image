<?php

/**
 * Description of StickynotesController
 *
 * @author Arian Khosravi <arian@bigemployee.com>, <@ArianKhosravi>
 */
// module/Stickynotes/src/Stickynotes/Controller/StickynotesController.php:

namespace Stickynotes\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel,
Doctrine\ORM\EntityManager,
Stickynotes\Entity\Stickynote;


class StickynotesController extends AbstractActionController {

    //protected $_stickyNotesTable;
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    public function indexAction() {
        return new ViewModel(array(
                    'stickynotes' => $this->getEntityManager()->getRepository('Stickynotes\Entity\Stickynote')->findAll(),
                ));
    }
    
   
    
    

    public function addAction() {
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $new_note = new Stickynote();
            //if (!$note_id = $this->getStickynotesTable()->saveStickyNote($new_note))
            if (!$note_id = $this->getEntityManager()->persist($new_note)){
    			$this->getEntityManager()->flush();
    			$response->setContent(\Zend\Json\Json::encode(array('response' => false)));
            }
                
            else {
                $response->setContent(\Zend\Json\Json::encode(array('response' => true, 'new_note_id' => $note_id)));
            }
        }
        return $response;
    }
    
    
   /* public function addAction()
    {
    	$form = new AlbumForm();
    	$form->get('submit')->setAttribute('label', 'Add');
    
    	$request = $this->getRequest();
    
    	if ($request->isPost()) {
    		$album = new Album();
    
    		$form->setInputFilter($album->getInputFilter());
    		$form->setData($request->getPost());
    		if ($form->isValid()) {
    			$album->populate($form->getData());
    			$this->getEntityManager()->persist($album);
    			$this->getEntityManager()->flush();
    
    			// Redirect to list of albums
    			return $this->redirect()->toRoute('album');
    		}
    	}
    
    	return array('form' => $form);
    }
    */
    
    

    public function removeAction() {
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post_data = $request->getPost();
            $note_id = $post_data['id'];
            if (!$this->getStickynotesTable()->removeStickyNote($note_id))
                $response->setContent(\Zend\Json\Json::encode(array('response' => false)));
            else {
                $response->setContent(\Zend\Json\Json::encode(array('response' => true)));
            }
        }
        return $response;
    }

    public function updateAction() {
        // update post
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post_data = $request->getPost();
            $note_id = $post_data['id'];
            $note_content = $post_data['content'];
            $stickynote = $this->getStickynotesTable()->getStickyNote($note_id);
            $stickynote->setNote($note_content);
            if (!$this->getStickynotesTable()->saveStickyNote($stickynote))
                $response->setContent(\Zend\Json\Json::encode(array('response' => false)));
            else {
                $response->setContent(\Zend\Json\Json::encode(array('response' => true)));
            }
        }
        return $response;
    }

    /*public function getStickynotesTable() {
        if (!$this->_stickyNotesTable) {
            $sm = $this->getServiceLocator();
            $this->_stickyNotesTable = $sm->get('Stickynotes\Model\StickynotesTable');
        }
        return $this->_stickyNotesTable;
    }*/
    
    public function setEntityManager(EntityManager $em)
    {
    	$this->em = $em;
    }
    
    public function getEntityManager()
    {
    	if (null === $this->em) {
    		$this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    	}
    	return $this->em;
    }

}